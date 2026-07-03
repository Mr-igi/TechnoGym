<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TrainingSessionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'trainer_id' => 'required|exists:trainers,id',
            'date'       => 'required|date_format:Y-m-d',
            'hour'       => 'required|numeric|min:6|max:21',
            'notes'      => 'nullable|string|max:500',
        ]);

        $scheduledAt = Carbon::createFromFormat('Y-m-d', $request->date)
            ->setHour((int) $request->hour)
            ->setMinute(0)
            ->setSecond(0);

        if ($scheduledAt->isPast()) {
            return back()
                ->withErrors(['hour' => 'Izabrani termin je u proslosti. Izaberi budući termin.'])
                ->withInput();
        }

        $taken = TrainingSession::where('trainer_id', $request->trainer_id)
            ->where('scheduled_at', $scheduledAt)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($taken) {
            return back()
                ->withErrors(['hour' => 'Ovaj termin je vec zauzet. Izaberi drugi.'])
                ->withInput();
        }

        $userConflict = TrainingSession::where('user_id', Auth::id())
            ->where('scheduled_at', $scheduledAt)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($userConflict) {
            return back()
                ->withErrors(['hour' => 'Vec imate zakazan trening u ovom terminu. Izaberite drugi sat.'])
                ->withInput();
        }

        TrainingSession::create([
            'trainer_id'   => (int) $request->trainer_id,
            'user_id'      => Auth::id(),
            'scheduled_at' => $scheduledAt,
            'status'       => 'pending',
            'notes'        => $request->notes,
        ]);

        return redirect()->route('dashboard')->with('session_booked', true);
    }

    public function availability(Trainer $trainer, Request $request)
    {
        $date = $request->query('date');

        if (! $date) {
            return response()->json(['booked' => []]);
        }

        $booked = TrainingSession::where('trainer_id', $trainer->id)
            ->whereDate('scheduled_at', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('scheduled_at')
            ->map(fn($dt) => Carbon::parse($dt)->hour)
            ->values();

        return response()->json(['booked' => $booked]);
    }
}
