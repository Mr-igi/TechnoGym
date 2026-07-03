<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GroupClass;
use App\Models\Trainer;
use Illuminate\Http\Request;

class GroupClassController extends Controller
{
    const DAYS = ['Pon', 'Uto', 'Sre', 'Čet', 'Pet', 'Sub', 'Ned'];

    public function store(Request $request, Trainer $trainer)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:100',
            'sala'              => 'required|string|max:80',
            'days_of_week'      => 'required|array|min:1',
            'days_of_week.*'    => 'in:' . implode(',', self::DAYS),
            'time_start'        => 'required|string|regex:/^\d{2}:\d{2}$/',
            'sessions_per_week' => 'required|integer|min:1|max:7',
            'monthly_price'     => 'required|integer|min:100|max:100000',
            'description'       => 'nullable|string|max:500',
            'is_active'         => 'boolean',
        ]);

        $trainer->groupClasses()->create([
            'name'              => $data['name'],
            'sala'              => $data['sala'],
            'days_of_week'      => implode(', ', $data['days_of_week']),
            'time_start'        => $data['time_start'],
            'sessions_per_week' => $data['sessions_per_week'],
            'monthly_price'     => $data['monthly_price'],
            'description'       => $data['description'] ?? null,
            'is_active'         => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.trainers.edit', $trainer)
            ->with('success', 'Grupni trening dodat!');
    }

    public function destroy(Trainer $trainer, GroupClass $groupClass)
    {
        abort_unless($groupClass->trainer_id === $trainer->id, 403);
        $groupClass->delete();

        return redirect()->route('admin.trainers.edit', $trainer)
            ->with('success', 'Grupni trening obrisan.');
    }
}
