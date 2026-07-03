@extends('layouts.app')

@section('title', 'TechnoGym - Moj nalog')

@section('content')

<div class="dashboard-page">
    <div class="container">

        {{-- Success banners --}}
        @if(session('purchased'))
            <div class="alert-success-custom mb-4">
                <i class="bi bi-check-circle-fill me-2"></i>
                Uspesno si kupio/la <strong>{{ session('purchased') }}</strong> clanarinu! Dobrodosao/la u TechnoGym.
            </div>
        @endif
        @if(session('session_booked'))
            <div class="alert-success-custom mb-4">
                <i class="bi bi-calendar-check-fill me-2"></i>
                Trening je uspesno zakazan! Vidis ga ispod u sekciji "Predstojeći treninzi".
            </div>
        @endif

        {{-- Header --}}
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title">Zdravo, {{ Auth::user()->name }} 👋</h1>
                <p class="dashboard-date">{{ now()->translatedFormat('l, d. F Y.') }}</p>
            </div>
            @if(!$membership)
            <a href="{{ route('memberships.index') }}" class="btn btn-outline-accent">
                <i class="bi bi-plus-lg me-1"></i> Kupi clanarinu
            </a>
            @endif
        </div>

        <div class="row g-4">

            {{-- Membership card --}}
            <div class="col-lg-7">
                @if($membership)
                    <div class="membership-card membership-card--{{ $membership->plan }}">
                        <div class="membership-card-top">
                            <div>
                                <div class="membership-card-label">Aktivna clanarina</div>
                                <div class="membership-card-plan">{{ $membership->plan_name }}</div>
                            </div>
                            <div class="membership-status-badge">
                                <i class="bi bi-circle-fill me-1" style="font-size:0.5rem"></i> Aktivna
                            </div>
                        </div>

                        <div class="membership-card-dates">
                            <div>
                                <div class="membership-date-label">Pocela</div>
                                <div class="membership-date-value">{{ $membership->starts_at->format('d.m.Y') }}</div>
                            </div>
                            <div class="membership-date-arrow"><i class="bi bi-arrow-right"></i></div>
                            <div>
                                <div class="membership-date-label">Istice</div>
                                <div class="membership-date-value">{{ $membership->ends_at->format('d.m.Y') }}</div>
                            </div>
                        </div>

                        <div class="membership-progress-wrap">
                            <div class="membership-progress-bar">
                                <div class="membership-progress-fill" style="width: {{ $membership->progressPercent() }}%"></div>
                            </div>
                            <div class="membership-progress-label">
                                <span>{{ $membership->daysRemaining() }} dana preostalo</span>
                                <span>{{ $membership->progressPercent() }}% iskorisceno</span>
                            </div>
                        </div>

                        <div class="membership-card-footer">
                            <span>
                                <i class="bi bi-credit-card me-1"></i>
                                •••• •••• •••• {{ $membership->card_last_four }}
                            </span>
                            <span>{{ number_format($membership->price, 0, ',', '.') }} RSD/mes</span>
                        </div>
                    </div>
                @else
                    <div class="no-membership-card">
                        <div class="no-membership-icon"><i class="bi bi-credit-card-2-front"></i></div>
                        <h4>Nemas aktivnu clanarinu</h4>
                        <p>Izaberi plan koji ti odgovara i pocni trening vec danas.</p>
                        <a href="{{ route('home') }}#clanarine" class="btn btn-accent px-4">
                            Pogledaj planove
                        </a>
                    </div>
                @endif
            </div>

            {{-- Quick info --}}
            <div class="col-lg-5">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="dashboard-stat-card">
                            <div class="dashboard-stat-icon"><i class="bi bi-calendar-check"></i></div>
                            <div class="dashboard-stat-num">{{ $history->count() }}</div>
                            <div class="dashboard-stat-label">Ukupno clanarina</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="dashboard-stat-card">
                            <div class="dashboard-stat-icon"><i class="bi bi-clock-history"></i></div>
                            <div class="dashboard-stat-num">
                                {{ $membership ? $membership->daysRemaining() : 0 }}
                            </div>
                            <div class="dashboard-stat-label">Dana preostalo</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="dashboard-cta-card">
                            <i class="bi bi-person-lines-fill dashboard-cta-icon"></i>
                            <div>
                                <div class="dashboard-cta-title">Zakazi personalni trening</div>
                                <div class="dashboard-cta-sub">Izaberi trenera i termin koji ti odgovara.</div>
                            </div>
                            <a href="{{ route('trainers.index') }}" class="btn btn-outline-accent btn-sm ms-auto">Zakazi</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- History --}}
            {{-- Upcoming sessions --}}
            @if($upcomingSessions->count())
                <div class="col-12">
                    <div class="dashboard-section-title">Predstojeći treninzi</div>
                    <div class="history-table-wrap">
                        <table class="history-table">
                            <thead>
                                <tr>
                                    <th>Trener</th>
                                    <th>Specijalnost</th>
                                    <th>Datum</th>
                                    <th>Vreme</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingSessions as $session)
                                    <tr>
                                        <td style="color: var(--text-light); font-weight:600">{{ $session->trainer->name }}</td>
                                        <td>{{ $session->trainer->specialty }}</td>
                                        <td>{{ $session->scheduled_at->format('d.m.Y') }}</td>
                                        <td>{{ $session->scheduled_at->format('H:i') }}h</td>
                                        <td><span class="history-badge {{ $session->statusClass() }}">{{ $session->statusLabel() }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Group class enrollments --}}
            @if($groupEnrollments->count())
                <div class="col-12">
                    <div class="dashboard-section-title">Moji grupni treninzi</div>
                    <div class="row g-3">
                        @foreach($groupEnrollments as $enrollment)
                            @php $gc = $enrollment->groupClass; @endphp
                            <div class="col-md-6">
                                <div class="gc-enrollment-card">
                                    <div class="gc-enrollment-top">
                                        <div class="gc-enrollment-name">{{ $gc->name }}</div>
                                        <span class="gc-enrollment-badge">
                                            <i class="bi bi-circle-fill me-1" style="font-size:0.4rem"></i> Aktivan
                                        </span>
                                    </div>

                                    <div class="gc-enrollment-trainer">
                                        @if($gc->trainer->photo)
                                            <img src="{{ asset('storage/' . $gc->trainer->photo) }}"
                                                 alt="{{ $gc->trainer->name }}" class="gc-enrollment-trainer-photo">
                                        @else
                                            <div class="gc-enrollment-trainer-avatar"
                                                 style="background: {{ $gc->trainer->avatar_gradient }}">
                                                {{ $gc->trainer->avatar_initials }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="gc-enrollment-trainer-name">{{ $gc->trainer->name }}</div>
                                            <div class="gc-enrollment-trainer-spec">{{ $gc->trainer->specialty }}</div>
                                        </div>
                                    </div>

                                    <div class="gc-enrollment-schedule">
                                        <div class="gc-enrollment-chip">
                                            <i class="bi bi-calendar3"></i>
                                            {{ $gc->days_of_week }}
                                        </div>
                                        <div class="gc-enrollment-chip">
                                            <i class="bi bi-clock"></i>
                                            {{ $gc->time_start }}
                                        </div>
                                        <div class="gc-enrollment-chip">
                                            <i class="bi bi-arrow-repeat"></i>
                                            {{ $gc->sessions_per_week }}x ned.
                                        </div>
                                        <div class="gc-enrollment-chip">
                                            <i class="bi bi-geo-alt-fill"></i>
                                            {{ $gc->sala }}
                                        </div>
                                    </div>

                                    <div class="gc-enrollment-footer">
                                        <span class="gc-enrollment-price">
                                            {{ number_format($gc->monthly_price, 0, ',', '.') }} RSD
                                            <span>/ mes</span>
                                        </span>
                                        <span class="gc-enrollment-since">
                                            Prijavljen/a {{ $enrollment->created_at->format('d.m.Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($history->count())
                <div class="col-12">
                    <div class="dashboard-section-title">Istorija clanarina</div>
                    <div class="history-table-wrap">
                        <table class="history-table">
                            <thead>
                                <tr>
                                    <th>Plan</th>
                                    <th>Cena</th>
                                    <th>Pocela</th>
                                    <th>Istice</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history as $item)
                                    <tr>
                                        <td>{{ $item->plan_name }}</td>
                                        <td>{{ number_format($item->price, 0, ',', '.') }} RSD</td>
                                        <td>{{ $item->starts_at->format('d.m.Y') }}</td>
                                        <td>{{ $item->ends_at->format('d.m.Y') }}</td>
                                        <td>
                                            @if($item->isActive())
                                                <span class="history-badge history-badge--active">Aktivna</span>
                                            @else
                                                <span class="history-badge history-badge--expired">Istekla</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@endsection
