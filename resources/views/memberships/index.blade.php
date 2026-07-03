@extends('layouts.app')

@section('title', 'TechnoGym - Clanarine')

@section('content')

{{-- ══════════════════════ PAGE HERO ══ --}}
<section class="memberships-hero">
    <div class="container position-relative">
        <div class="text-center">
            <span class="section-label">Clanarine</span>
            <h1 class="memberships-hero-title">Izaberi plan koji ti odgovara</h1>
            <p class="memberships-hero-subtitle mx-auto">
                Bez skrivenih troskova. Otkazi kada hoces. Svi planovi ukljucuju pristup svim spravama.
            </p>
        </div>
    </div>
</section>

{{-- ══════════════════════════ PLANS ══ --}}
<section class="section" style="padding-top: 3rem">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @foreach($plans as $plan)
            <div class="col-md-4 col-lg-3">
                <div class="plan-card {{ $plan->is_featured ? 'featured' : '' }}">
                    @if($plan->is_featured)
                        <div class="plan-badge">Najpopularnije</div>
                    @endif
                    <div class="plan-name">{{ $plan->name }}</div>
                    <div class="plan-price">{{ number_format($plan->price, 0, ',', '.') }} <span>RSD/mes</span></div>
                    <hr class="plan-divider">

                    @foreach($plan->features ?? [] as $feature)
                        <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> {{ $feature }}</div>
                    @endforeach
                    @foreach($plan->features_off ?? [] as $feature)
                        <div class="plan-feature plan-feature-off"><i class="bi bi-x-circle"></i> {{ $feature }}</div>
                    @endforeach

                    <a href="{{ auth()->check() ? route('membership.checkout', $plan->slug) : route('login') }}"
                       class="btn {{ $plan->is_featured ? 'btn-accent' : 'btn-outline-accent' }} w-100 mt-4">
                        Izaberi plan
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        {{-- FAQ / Garantije --}}
        <div class="memberships-guarantees row g-4 mt-5">
            <div class="col-md-4 text-center">
                <div class="guarantee-icon"><i class="bi bi-check-circle-fill"></i></div>
                <div class="guarantee-title">Bez obaveza</div>
                <p class="guarantee-desc">Otkazi clanstvo u bilo kom trenutku bez penala i skrivenih naknada.</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="guarantee-icon"><i class="bi bi-arrow-repeat"></i></div>
                <div class="guarantee-title">Automatsko obnavljanje</div>
                <p class="guarantee-desc">Clanarina se automatski obnavlja svakih 30 dana dok ne odlucis da otkazes.</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="guarantee-icon"><i class="bi bi-lock-fill"></i></div>
                <div class="guarantee-title">Sigurna naplata</div>
                <p class="guarantee-desc">Sva placanja su zasticena SSL enkripcijom. Tvoji podaci su bezbedni.</p>
            </div>
        </div>
    </div>
</section>

@endsection
