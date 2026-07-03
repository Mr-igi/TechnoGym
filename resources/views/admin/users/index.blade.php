@extends('layouts.admin')

@section('title', 'Korisnici')
@section('page-title', 'Korisnici')

@section('content')

<div class="admin-card-header mb-4" style="padding:0">
    <h2 class="admin-page-title">Svi korisnici</h2>
    <span style="font-size:0.82rem;color:var(--text-muted)">{{ $users->total() }} ukupno</span>
</div>

<div class="admin-card">
    @if($users->isEmpty())
        <p class="admin-empty">Nema registrovanih korisnika.</p>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Korisnik</th>
                    <th>Email</th>
                    <th>Registrovan</th>
                    <th>Clanarine</th>
                    <th>Aktivna clanarina</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    @php
                        $active = $user->memberships()
                            ->where('status','active')->where('ends_at','>',now())->latest()->first();
                    @endphp
                    <tr>
                        <td style="color:var(--text-light);font-weight:600">{{ $user->name }}</td>
                        <td style="color:var(--text-muted)">{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('d.m.Y') }}</td>
                        <td>{{ $user->membership_count }}</td>
                        <td>
                            @if($active)
                                <span class="history-badge history-badge--active">
                                    {{ $active->plan_name }} — do {{ $active->ends_at->format('d.m.Y') }}
                                </span>
                            @else
                                <span style="color:var(--text-muted);font-size:0.82rem">Nema aktivne</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">{{ $users->links() }}</div>
    @endif
</div>

@endsection
