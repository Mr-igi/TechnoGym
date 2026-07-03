@extends('layouts.app')

@section('title', 'TechnoGym - Treneri')

@section('content')

<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-6">
                <span class="section-label">Nas tim</span>
                <h1 class="page-hero-title">Nasi treneri</h1>
                <p class="page-hero-subtitle">
                    Sertifikovani profesionalci sa godinama iskustva. Izaberi personalni pristup
                    ili se prikljuci grupnim treninzima — za svakoga ima nesto.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════ PERSONALNI TRENERI ══════════════════════════════════════════ --}}
<section class="section">
    <div class="container">

        <div class="trainers-section-header">
            <div>
                <span class="section-label">1 na 1</span>
                <h2 class="section-title mb-1">Personalni treneri</h2>
                <p class="section-subtitle">Individualni pristup, prilagodjen plan treninga i ishrane.</p>
            </div>
            @if($personal->count() > 0)
                <div class="trainers-count-badge">
                    <i class="bi bi-person-fill me-1"></i>{{ $personal->count() }} trenera
                </div>
            @endif
        </div>

        @if($personal->isEmpty())
            <div class="trainers-empty-state">
                <div class="trainers-empty-icon"><i class="bi bi-person"></i></div>
                <h5>Uskoro dostupno</h5>
                <p>Personalni treneri ce biti objavljeni uskoro.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($personal as $trainer)
                    <div class="col-sm-6 col-lg-4">
                        <div class="trainer-card">
                            @if($trainer->photo)
                                <div class="trainer-photo-wrap">
                                    <img src="{{ asset('storage/' . $trainer->photo) }}"
                                         alt="{{ $trainer->name }}" class="trainer-photo-img">
                                </div>
                            @else
                                <div class="trainer-avatar" style="background: {{ $trainer->avatar_gradient }}">
                                    {{ $trainer->avatar_initials }}
                                </div>
                            @endif

                            <div class="trainer-info">
                                <div class="trainer-name">{{ $trainer->name }}</div>
                                <div class="trainer-spec">{{ $trainer->specialty }}</div>
                                <p class="trainer-desc">{{ Str::limit($trainer->bio, 120) }}</p>

                                <div class="trainer-price">
                                    <i class="bi bi-tag-fill"></i>
                                    {{ number_format($trainer->session_price, 0, ',', '.') }} RSD
                                    <span>/ termin</span>
                                </div>

                                @auth
                                    <a href="{{ route('trainers.show', $trainer) }}"
                                       class="btn btn-outline-accent btn-sm w-100">
                                        <i class="bi bi-calendar-plus me-1"></i> Zakazi trening
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                       class="btn btn-outline-accent btn-sm w-100">
                                        <i class="bi bi-calendar-plus me-1"></i> Zakazi trening
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</section>

{{-- ═══════════════════════════════════════════ GRUPNI TRENINZI ════════════════════════════════════════════ --}}
<section class="section section-alt">
    <div class="container">

        <div class="trainers-section-header">
            <div>
                <span class="section-label">Grupno</span>
                <h2 class="section-title mb-1">Grupni treninzi</h2>
                <p class="section-subtitle">Treniraj uz grupu, motivisi se i uzivaj u zajednickoj energiji.</p>
            </div>
            @if($groupClasses->count() > 0)
                <div class="trainers-count-badge trainers-count-badge--group">
                    <i class="bi bi-people-fill me-1"></i>{{ $groupClasses->count() }} programa
                </div>
            @endif
        </div>

        @if($groupClasses->isEmpty())
            {{-- Nema klasa — prikazi trenere kao fallback --}}
            @if($groupTrainers->isEmpty())
                <div class="trainers-empty-state">
                    <div class="trainers-empty-icon"><i class="bi bi-people"></i></div>
                    <h5>Uskoro dostupno</h5>
                    <p>Grupni treninzi ce biti objavljeni uskoro.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach($groupTrainers as $trainer)
                        <div class="col-sm-6 col-lg-4">
                            <div class="trainer-card trainer-card--group h-100">
                                <div class="group-trainer-badge">
                                    <i class="bi bi-people-fill me-1"></i> Grupni trener
                                </div>
                                @if($trainer->photo)
                                    <div class="trainer-photo-wrap">
                                        <img src="{{ asset('storage/' . $trainer->photo) }}"
                                             alt="{{ $trainer->name }}" class="trainer-photo-img">
                                    </div>
                                @else
                                    <div class="trainer-avatar" style="background: {{ $trainer->avatar_gradient }}">
                                        {{ $trainer->avatar_initials }}
                                    </div>
                                @endif
                                <div class="trainer-info">
                                    <div class="trainer-name">{{ $trainer->name }}</div>
                                    <div class="trainer-spec">{{ $trainer->specialty }}</div>
                                    <a href="{{ route('trainers.show', $trainer) }}"
                                       class="btn btn-outline-accent btn-sm w-100 mt-3">
                                        <i class="bi bi-calendar3 me-1"></i> Pogledaj raspored
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @else
            {{-- Grid grupnih klasa --}}
            <div class="row g-4">
                @foreach($groupClasses as $class)
                    <div class="col-md-6">
                        <div class="gc-card h-100">
                            <div class="gc-card-top">
                                <div class="gc-card-title-wrap">
                                    <div class="gc-card-name">{{ $class->name }}</div>
                                    <div class="gc-card-sala">
                                        <i class="bi bi-geo-alt-fill"></i> {{ $class->sala }}
                                    </div>
                                </div>
                                <div class="gc-card-price-wrap">
                                    <div class="gc-card-price">{{ number_format($class->monthly_price, 0, ',', '.') }}</div>
                                    <div class="gc-card-price-unit">RSD / mes</div>
                                </div>
                            </div>

                            <div class="gc-card-trainer">
                                @if($class->trainer->photo)
                                    <img src="{{ asset('storage/' . $class->trainer->photo) }}"
                                         alt="{{ $class->trainer->name }}" class="gc-trainer-photo">
                                @else
                                    <div class="gc-trainer-avatar" style="background: {{ $class->trainer->avatar_gradient }}">
                                        {{ $class->trainer->avatar_initials }}
                                    </div>
                                @endif
                                <div>
                                    <div class="gc-trainer-name">{{ $class->trainer->name }}</div>
                                    <div class="gc-trainer-spec">{{ $class->trainer->specialty }}</div>
                                </div>
                            </div>

                            <div class="gc-card-schedule">
                                <div class="gc-schedule-chip">
                                    <i class="bi bi-arrow-repeat"></i>
                                    {{ $class->sessions_per_week }}x nedeljno
                                </div>
                                <div class="gc-schedule-chip">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $class->days_of_week }}
                                </div>
                                <div class="gc-schedule-chip">
                                    <i class="bi bi-clock"></i>
                                    {{ $class->time_start }}
                                </div>
                            </div>

                            @if($class->description)
                                <p class="gc-card-desc">{{ $class->description }}</p>
                            @endif

                            <div class="gc-card-footer">
                                <a href="{{ route('group-classes.inquiry', $class) }}" class="btn btn-accent btn-sm">
                                    <i class="bi bi-envelope me-1"></i> Prijavite se
                                </a>
                                <a href="{{ route('trainers.show', $class->trainer) }}"
                                   class="btn btn-ghost btn-sm">
                                    <i class="bi bi-person me-1"></i> Profil trenera
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Treneri koji vode grupne klase --}}
            @if($groupTrainers->count() > 1)
                <div class="gc-trainers-footer mt-5">
                    <div class="gc-trainers-footer-label">Treneri koji vode programe</div>
                    <div class="gc-trainers-footer-list">
                        @foreach($groupTrainers as $trainer)
                            <a href="{{ route('trainers.show', $trainer) }}" class="gc-trainer-chip">
                                @if($trainer->photo)
                                    <img src="{{ asset('storage/' . $trainer->photo) }}"
                                         alt="{{ $trainer->name }}" class="gc-trainer-chip-photo">
                                @else
                                    <div class="gc-trainer-chip-avatar" style="background: {{ $trainer->avatar_gradient }}">
                                        {{ $trainer->avatar_initials }}
                                    </div>
                                @endif
                                <span>{{ $trainer->name }}</span>
                                <span class="gc-trainer-chip-count">
                                    {{ $trainer->groupClasses->where('is_active', true)->count() }} prog.
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

    </div>
</section>

@endsection
