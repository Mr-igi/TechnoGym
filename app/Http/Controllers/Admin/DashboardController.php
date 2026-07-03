<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserMembership;
use App\Models\TrainingSession;
use App\Models\Trainer;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users'        => User::where('is_admin', false)->count(),
            'trainers'     => Trainer::where('is_active', true)->count(),
            'memberships'  => UserMembership::where('status', 'active')->where('ends_at', '>', now())->count(),
            'sessions'     => TrainingSession::where('scheduled_at', '>', now())->whereIn('status', ['pending', 'confirmed'])->count(),
            'revenue'      => UserMembership::sum('price'),
        ];

        $recentMemberships = UserMembership::with('user')->latest()->take(5)->get();
        $recentSessions    = TrainingSession::with('user', 'trainer')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentMemberships', 'recentSessions'));
    }
}
