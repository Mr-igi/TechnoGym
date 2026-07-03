<?php

namespace App\Http\Controllers;

use App\Models\GroupClassEnrollment;
use App\Models\UserMembership;
use App\Models\TrainingSession;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $membership = UserMembership::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->latest()
            ->first();

        $history = UserMembership::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $upcomingSessions = TrainingSession::with('trainer')
            ->where('user_id', $user->id)
            ->where('scheduled_at', '>', now())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();

        $groupEnrollments = GroupClassEnrollment::where('user_id', $user->id)
            ->where('status', 'active')
            ->with(['groupClass.trainer'])
            ->latest()
            ->get();

        return view('dashboard.index', compact('membership', 'history', 'upcomingSessions', 'groupEnrollments'));
    }
}
