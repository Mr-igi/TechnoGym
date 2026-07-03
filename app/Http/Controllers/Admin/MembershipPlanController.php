<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use Illuminate\Http\Request;

class MembershipPlanController extends Controller
{
    public function index()
    {
        $plans = MembershipPlan::orderBy('sort_order')->get();
        return view('admin.memberships.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.memberships.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug'         => 'required|string|alpha_dash|max:50|unique:membership_plans,slug',
            'name'         => 'required|string|max:100',
            'price'        => 'required|integer|min:100|max:999999',
            'features'     => 'required|string',
            'features_off' => 'nullable|string',
            'is_featured'  => 'nullable|boolean',
            'is_active'    => 'nullable|boolean',
            'sort_order'   => 'nullable|integer|min:0|max:9999',
        ]);

        MembershipPlan::create([
            'slug'         => $data['slug'],
            'name'         => $data['name'],
            'price'        => $data['price'],
            'features'     => $this->parseLines($data['features']),
            'features_off' => $this->parseLines($data['features_off'] ?? ''),
            'is_featured'  => $request->boolean('is_featured'),
            'is_active'    => $request->boolean('is_active'),
            'sort_order'   => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.memberships.index')
            ->with('success', 'Clanarina je dodata.');
    }

    public function edit(MembershipPlan $membership)
    {
        return view('admin.memberships.edit', compact('membership'));
    }

    public function update(Request $request, MembershipPlan $membership)
    {
        $data = $request->validate([
            'slug'         => 'required|string|alpha_dash|max:50|unique:membership_plans,slug,' . $membership->id,
            'name'         => 'required|string|max:100',
            'price'        => 'required|integer|min:100|max:999999',
            'features'     => 'required|string',
            'features_off' => 'nullable|string',
            'is_featured'  => 'nullable|boolean',
            'is_active'    => 'nullable|boolean',
            'sort_order'   => 'nullable|integer|min:0|max:9999',
        ]);

        $membership->update([
            'slug'         => $data['slug'],
            'name'         => $data['name'],
            'price'        => $data['price'],
            'features'     => $this->parseLines($data['features']),
            'features_off' => $this->parseLines($data['features_off'] ?? ''),
            'is_featured'  => $request->boolean('is_featured'),
            'is_active'    => $request->boolean('is_active'),
            'sort_order'   => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.memberships.index')
            ->with('success', 'Clanarina je azurirana.');
    }

    public function destroy(MembershipPlan $membership)
    {
        $membership->delete();
        return redirect()->route('admin.memberships.index')
            ->with('success', 'Clanarina je obrisana.');
    }

    private function parseLines(string $text): array
    {
        return array_values(array_filter(
            array_map('trim', explode("\n", str_replace("\r", '', $text)))
        ));
    }
}
