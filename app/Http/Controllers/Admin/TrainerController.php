<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainerController extends Controller
{
    const GRADIENTS = [
        'red'    => 'linear-gradient(140deg, #1c0500 0%, #2e0a00 100%)',
        'blue'   => 'linear-gradient(140deg, #080a1c 0%, #0d112e 100%)',
        'green'  => 'linear-gradient(140deg, #001a08 0%, #002d10 100%)',
        'purple' => 'linear-gradient(140deg, #12001c 0%, #1e002e 100%)',
        'gold'   => 'linear-gradient(140deg, #1c1500 0%, #2e2300 100%)',
    ];

    public function index()
    {
        $trainers = Trainer::latest()->get();
        return view('admin.trainers.index', compact('trainers'));
    }

    public function create()
    {
        return view('admin.trainers.create', ['gradients' => self::GRADIENTS]);
    }

    public function store(Request $request)
    {
        $isGroup = $request->input('trainer_type') === 'group';

        $data = $request->validate([
            'name'            => 'required|string|max:100',
            'specialty'       => 'required|string|max:100',
            'bio'             => 'required|string|max:1000',
            'trainer_type'    => 'required|in:personal,group',
            'session_price'   => $isGroup ? 'nullable|integer|min:500|max:50000' : 'required|integer|min:500|max:50000',
            'avatar_initials' => 'required|string|max:3',
            'avatar_color'    => 'required|in:' . implode(',', array_keys(self::GRADIENTS)),
            'photo'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'       => 'boolean',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('trainers', 'public');
        }

        Trainer::create([
            'name'            => $data['name'],
            'specialty'       => $data['specialty'],
            'bio'             => $data['bio'],
            'trainer_type'    => $data['trainer_type'],
            'session_price'   => $isGroup ? null : $data['session_price'],
            'avatar_initials' => strtoupper($data['avatar_initials']),
            'avatar_gradient' => self::GRADIENTS[$data['avatar_color']],
            'photo'           => $photoPath,
            'is_active'       => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.trainers.index')->with('success', 'Trener uspesno dodat!');
    }

    public function edit(Trainer $trainer)
    {
        $currentColor = array_search($trainer->avatar_gradient, self::GRADIENTS) ?: 'red';
        $groupClasses = $trainer->groupClasses()->latest()->get();
        $days = \App\Http\Controllers\Admin\GroupClassController::DAYS;

        return view('admin.trainers.edit', [
            'trainer'      => $trainer,
            'gradients'    => self::GRADIENTS,
            'currentColor' => $currentColor,
            'groupClasses' => $groupClasses,
            'days'         => $days,
        ]);
    }

    public function update(Request $request, Trainer $trainer)
    {
        $isGroup = $request->input('trainer_type') === 'group';

        $data = $request->validate([
            'name'            => 'required|string|max:100',
            'specialty'       => 'required|string|max:100',
            'bio'             => 'required|string|max:1000',
            'trainer_type'    => 'required|in:personal,group',
            'session_price'   => $isGroup ? 'nullable|integer|min:500|max:50000' : 'required|integer|min:500|max:50000',
            'avatar_initials' => 'required|string|max:3',
            'avatar_color'    => 'required|in:' . implode(',', array_keys(self::GRADIENTS)),
            'photo'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $photoPath = $trainer->photo;

        if ($request->hasFile('photo')) {
            if ($trainer->photo) {
                Storage::disk('public')->delete($trainer->photo);
            }
            $photoPath = $request->file('photo')->store('trainers', 'public');
        }

        if ($request->boolean('remove_photo') && $trainer->photo) {
            Storage::disk('public')->delete($trainer->photo);
            $photoPath = null;
        }

        $trainer->update([
            'name'            => $data['name'],
            'specialty'       => $data['specialty'],
            'bio'             => $data['bio'],
            'trainer_type'    => $data['trainer_type'],
            'session_price'   => $isGroup ? null : $data['session_price'],
            'avatar_initials' => strtoupper($data['avatar_initials']),
            'avatar_gradient' => self::GRADIENTS[$data['avatar_color']],
            'photo'           => $photoPath,
            'is_active'       => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.trainers.index')->with('success', 'Trener uspesno azuriran!');
    }

    public function destroy(Trainer $trainer)
    {
        if ($trainer->photo) {
            Storage::disk('public')->delete($trainer->photo);
        }
        $trainer->delete();
        return redirect()->route('admin.trainers.index')->with('success', 'Trener obrisan.');
    }
}
