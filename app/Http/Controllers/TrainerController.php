<?php

namespace App\Http\Controllers;

use App\Models\GroupClass;
use App\Models\Trainer;

class TrainerController extends Controller
{
    public function index()
    {
        $personal = Trainer::where('is_active', true)
            ->where('trainer_type', 'personal')
            ->get();

        $groupClasses = GroupClass::where('is_active', true)
            ->with('trainer')
            ->orderBy('name')
            ->get();

        $groupTrainers = Trainer::where('is_active', true)
            ->where('trainer_type', 'group')
            ->with('groupClasses')
            ->get();

        return view('trainers.index', compact('personal', 'groupClasses', 'groupTrainers'));
    }

    public function show(Trainer $trainer)
    {
        abort_unless($trainer->is_active, 404);
        $trainer->load('groupClasses');
        return view('trainers.show', compact('trainer'));
    }
}
