<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use App\Models\UserMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    public function index()
    {
        $plans = MembershipPlan::active()->get();
        return view('memberships.index', compact('plans'));
    }

    public function checkout(string $plan)
    {
        $membershipPlan = MembershipPlan::where('slug', $plan)->where('is_active', true)->first();
        abort_unless($membershipPlan, 404);

        return view('memberships.checkout', [
            'plan' => $membershipPlan->toCheckoutArray(),
        ]);
    }

    public function purchase(Request $request)
    {
        $planSlug = $request->input('plan');
        $membershipPlan = MembershipPlan::where('slug', $planSlug)->where('is_active', true)->first();
        abort_unless($membershipPlan, 404);

        $request->validate([
            'plan'             => 'required|string',
            'cardholder_name'  => 'required|string|max:100',
            'card_number'      => ['required', 'digits:16'],
            'card_expiry'      => ['required', 'regex:/^\d{2}\/\d{2}$/'],
            'card_cvv'         => ['required', 'digits_between:3,4'],
        ], [
            'card_number.digits'      => 'Broj kartice mora imati tacno 16 cifara.',
            'card_expiry.regex'       => 'Datum isteka mora biti u formatu MM/GG.',
            'card_cvv.digits_between' => 'CVV mora imati 3 ili 4 cifre.',
        ]);

        $user = Auth::user();

        $activeMembership = UserMembership::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->latest()
            ->first();

        if ($activeMembership) {
            $expiresOn = $activeMembership->ends_at->format('d.m.Y');
            return back()->withErrors([
                'plan' => "Već imate aktivnu članarinu koja ističe {$expiresOn}. Nova može biti kupljena tek nakon isteka.",
            ])->withInput();
        }

        $startsAt = now();
        $endsAt   = $startsAt->copy()->addDays(30);

        UserMembership::create([
            'user_id'         => $user->id,
            'plan'            => $membershipPlan->slug,
            'plan_name'       => $membershipPlan->name,
            'price'           => $membershipPlan->price,
            'status'          => 'active',
            'cardholder_name' => $request->cardholder_name,
            'card_last_four'  => substr($request->card_number, -4),
            'starts_at'       => $startsAt,
            'ends_at'         => $endsAt,
        ]);

        return redirect()->route('dashboard')->with('purchased', $membershipPlan->name);
    }
}
