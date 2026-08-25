@extends('layouts.app')

@section('title', 'TechnoGym - Prijava za ' . $groupClass->name)

@section('content')

<div class="inquiry-page">
    <div class="container">

        <a href="{{ route('trainers.index') }}" class="checkout-back mb-4 d-inline-flex">
            <i class="bi bi-arrow-left me-1"></i> Nazad na trenere
        </a>

        <div class="row g-5 justify-content-center">

            {{-- Info panel --}}
            <div class="col-lg-4">
                <div class="inquiry-info-panel">

                    <div class="inquiry-class-badge">
                        <i class="bi bi-people-fill me-1"></i> Grupni trening
                    </div>

                    <div class="inquiry-class-name">{{ $groupClass->name }}</div>

                    <div class="inquiry-price-row">
                        <span class="inquiry-price">{{ number_format($groupClass->monthly_price, 0, ',', '.') }} RSD</span>
                        <span class="inquiry-price-unit">/ mesec</span>
                    </div>

                    <hr class="inquiry-divider">

                    <div class="inquiry-meta-list">
                        <div class="inquiry-meta-item">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>{{ $groupClass->sala }}</span>
                        </div>
                        <div class="inquiry-meta-item">
                            <i class="bi bi-arrow-repeat"></i>
                            <span>{{ $groupClass->sessions_per_week }}x nedeljno</span>
                        </div>
                        <div class="inquiry-meta-item">
                            <i class="bi bi-calendar3"></i>
                            <span>{{ $groupClass->days_of_week }}</span>
                        </div>
                        <div class="inquiry-meta-item">
                            <i class="bi bi-clock"></i>
                            <span>{{ $groupClass->time_start }}</span>
                        </div>
                    </div>

                    @if($groupClass->description)
                        <hr class="inquiry-divider">
                        <p class="inquiry-class-desc">{{ $groupClass->description }}</p>
                    @endif

                    <hr class="inquiry-divider">

                    {{-- Trener --}}
                    <div class="inquiry-trainer-row">
                        @if($groupClass->trainer->photo)
                            <img src="{{ asset('storage/' . $groupClass->trainer->photo) }}"
                                 alt="{{ $groupClass->trainer->name }}" class="inquiry-trainer-photo">
                        @else
                            <div class="inquiry-trainer-avatar" style="background: {{ $groupClass->trainer->avatar_gradient }}">
                                {{ $groupClass->trainer->avatar_initials }}
                            </div>
                        @endif
                        <div>
                            <div class="inquiry-trainer-name">{{ $groupClass->trainer->name }}</div>
                            <div class="inquiry-trainer-spec">{{ $groupClass->trainer->specialty }}</div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Forma --}}
            <div class="col-lg-6">

                @if(session('success'))
                    <div class="inquiry-success">
                        <div class="inquiry-success-icon"><i class="bi bi-check-circle-fill"></i></div>
                        <div>
                            <div class="inquiry-success-title">Prijava primljena!</div>
                            <div class="inquiry-success-msg">{{ session('success') }}</div>
                        </div>
                    </div>
                @endif

                @if(session('already_enrolled') || $alreadyEnrolled)
                    <div class="inquiry-already">
                        <div class="inquiry-already-icon"><i class="bi bi-patch-check-fill"></i></div>
                        <div>
                            <div class="inquiry-already-title">Vec ste prijavljeni</div>
                            <div class="inquiry-already-msg">
                                Ovaj trening vec vidite na svom
                                <a href="{{ route('dashboard') }}">profilu</a>.
                            </div>
                        </div>
                    </div>
                @endif

                <h1 class="checkout-title">Prijavite se za trening</h1>
                <p class="checkout-subtitle">
                    Popunite formu i nas tim ce Vas kontaktirati u roku od 24 sata sa svim detaljima
                    o pocetku i nacinu placanja.
                    @auth Prijava ce biti vidljiva i na <a href="{{ route('dashboard') }}" style="color:var(--accent)">Vašem profilu</a>. @endauth
                </p>

                @if($errors->any())
                    <div class="alert-error-custom mb-4">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
                    </div>
                @endif

                @if(!$alreadyEnrolled)
                <form method="POST" action="{{ route('group-classes.inquiry.store', $groupClass) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label-custom">Ime i prezime *</label>
                        <input type="text" name="ime"
                               class="form-input-custom @error('ime') is-error @enderror"
                               placeholder="Marko Markovic"
                               value="{{ old('ime') }}">
                        @error('ime')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Email adresa *</label>
                        <input type="email" name="email"
                               class="form-input-custom @error('email') is-error @enderror"
                               placeholder="marko@primer.rs"
                               value="{{ old('email') }}">
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Broj telefona <span style="color:var(--text-muted); font-weight:400">(opciono)</span></label>
                        <input type="text" name="telefon"
                               class="form-input-custom @error('telefon') is-error @enderror"
                               placeholder="+381 60 123 4567"
                               value="{{ old('telefon') }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Poruka <span style="color:var(--text-muted); font-weight:400">(opciono)</span></label>
                        <textarea name="poruka" rows="4"
                                  class="form-input-custom @error('poruka') is-error @enderror"
                                  placeholder="Pitanja, napomene ili posebni zahtevi...">{{ old('poruka') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg px-5">
                        <i class="bi bi-send me-2"></i>Posalji prijavu
                    </button>

                    <p class="checkout-note mt-3">
                        <i class="bi bi-shield-fill me-1"></i>
                        Vasi podaci se koriste iskljucivo radi kontakta u vezi ovog treninga.
                    </p>

                </form>
                @else
                    <div class="mt-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-accent px-4">
                            <i class="bi bi-person me-1"></i> Idi na profil
                        </a>
                        <a href="{{ route('trainers.index') }}" class="btn btn-ghost px-4 ms-2">
                            Pogledaj jos treninga
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

@endsection
