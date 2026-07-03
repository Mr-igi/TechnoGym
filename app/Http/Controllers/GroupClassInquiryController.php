<?php

namespace App\Http\Controllers;

use App\Models\GroupClass;
use App\Models\GroupClassEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupClassInquiryController extends Controller
{
    public function show(GroupClass $groupClass)
    {
        abort_unless($groupClass->is_active, 404);
        $groupClass->load('trainer');

        $alreadyEnrolled = Auth::check()
            ? GroupClassEnrollment::where('user_id', Auth::id())
                ->where('group_class_id', $groupClass->id)
                ->where('status', 'active')
                ->exists()
            : false;

        return view('group-classes.inquiry', compact('groupClass', 'alreadyEnrolled'));
    }

    public function store(GroupClass $groupClass, Request $request)
    {
        abort_unless($groupClass->is_active, 404);

        $request->validate([
            'ime'     => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'telefon' => 'nullable|string|max:30',
            'poruka'  => 'nullable|string|max:1000',
        ], [
            'ime.required'   => 'Ime i prezime je obavezno.',
            'email.required' => 'Email adresa je obavezna.',
            'email.email'    => 'Unesite ispravnu email adresu.',
        ]);

        if (Auth::check()) {
            $existing = GroupClassEnrollment::where('user_id', Auth::id())
                ->where('group_class_id', $groupClass->id)
                ->where('status', 'active')
                ->exists();

            if ($existing) {
                return redirect()
                    ->route('group-classes.inquiry', $groupClass)
                    ->with('already_enrolled', true);
            }

            GroupClassEnrollment::create([
                'user_id'        => Auth::id(),
                'group_class_id' => $groupClass->id,
                'status'         => 'active',
            ]);
        }

        // TODO: send notification email
        return redirect()
            ->route('group-classes.inquiry', $groupClass)
            ->with('success', "Uspesno ste se prijavili za \"{$groupClass->name}\"! Vidite trening u svom profilu.");
    }
}
