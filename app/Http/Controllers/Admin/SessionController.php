<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingSession;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index(Request $request)
    {
        $query = TrainingSession::with('user', 'trainer')->orderByDesc('scheduled_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sessions = $query->paginate(15);
        return view('admin.sessions.index', compact('sessions'));
    }

    public function updateStatus(Request $request, TrainingSession $session)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,cancelled']);
        $session->update(['status' => $request->status]);
        return back()->with('success', 'Status treninga azuriran.');
    }
}
