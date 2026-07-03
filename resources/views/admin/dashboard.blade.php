@extends('layouts.admin')

@section('title', 'Admin Pregled')
@section('page-title', 'Pregled')

@section('content')

{{-- Stats --}}
<div class="admin-stats-grid">
    <div class="admin-stat-card">
        <div class="admin-stat-icon" style="background: rgba(204,34,0,0.12); color: var(--accent)">
            <i class="bi bi-people-fill"></i>
        </div>
        <div class="admin-stat-body">
            <div class="admin-stat-num">{{ $stats['users'] }}</div>
            <div class="admin-stat-label">Registrovanih korisnika</div>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-icon" style="background: rgba(99,102,241,0.12); color: #818cf8">
            <i class="bi bi-person-badge-fill"></i>
        </div>
        <div class="admin-stat-body">
            <div class="admin-stat-num">{{ $stats['trainers'] }}</div>
            <div class="admin-stat-label">Aktivnih trenera</div>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-icon" style="background: rgba(34,197,94,0.12); color: #4ade80">
            <i class="bi bi-credit-card-fill"></i>
        </div>
        <div class="admin-stat-body">
            <div class="admin-stat-num">{{ $stats['memberships'] }}</div>
            <div class="admin-stat-label">Aktivnih clanarina</div>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-icon" style="background: rgba(251,191,36,0.12); color: #fbbf24">
            <i class="bi bi-calendar-event-fill"></i>
        </div>
        <div class="admin-stat-body">
            <div class="admin-stat-num">{{ $stats['sessions'] }}</div>
            <div class="admin-stat-label">Predstojecih treninga</div>
        </div>
    </div>
</div>

{{-- Revenue + recent --}}
<div class="row g-4 mt-1">
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <span>Ukupan prihod od clanarina</span>
            </div>
            <div class="admin-revenue">
                {{ number_format($stats['revenue'], 0, ',', '.') }} RSD
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <span>Poslednje kupljene clanarine</span>
                <a href="{{ route('admin.users.index') }}" class="admin-card-link">Sve</a>
            </div>
            @if($recentMemberships->isEmpty())
                <p class="admin-empty">Nema kupljenih clanarina.</p>
            @else
                <table class="admin-table">
                    <thead><tr><th>Korisnik</th><th>Plan</th><th>Cena</th><th>Datum</th></tr></thead>
                    <tbody>
                        @foreach($recentMemberships as $m)
                            <tr>
                                <td>{{ $m->user->name }}</td>
                                <td><span class="admin-plan-badge">{{ $m->plan_name }}</span></td>
                                <td>{{ number_format($m->price, 0, ',', '.') }} RSD</td>
                                <td>{{ $m->created_at->format('d.m.Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <span>Poslednja zakazivanja</span>
                <a href="{{ route('admin.sessions.index') }}" class="admin-card-link">Sve</a>
            </div>
            @if($recentSessions->isEmpty())
                <p class="admin-empty">Nema zakazanih treninga.</p>
            @else
                <table class="admin-table">
                    <thead><tr><th>Korisnik</th><th>Trener</th><th>Termin</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach($recentSessions as $s)
                            <tr>
                                <td>{{ $s->user->name }}</td>
                                <td>{{ $s->trainer->name }}</td>
                                <td>{{ $s->scheduled_at->format('d.m H:i') }}h</td>
                                <td><span class="history-badge {{ $s->statusClass() }}">{{ $s->statusLabel() }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

@endsection
