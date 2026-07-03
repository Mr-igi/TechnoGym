@extends('layouts.app')

@section('title', 'TechnoGym - Pocetna')

@section('content')

{{-- ═══════════════════════════════════════ HERO ══ --}}
<section class="hero">
    <div class="hero-deco">GYM</div>
    <div class="container position-relative">
        <div class="row">
            <div class="col-lg-7">
                <span class="hero-eyebrow">Dobrodosli u TechnoGym</span>
                <h1 class="hero-title">
                    IZGRADI<br>SVOJE<br><span class="accent">NAJBOLJE</span><br>TELO
                </h1>
                <p class="hero-subtitle">
                    Moderna teretana sa profesionalnim trenerima, vrhunskom opremom
                    i fleksibilnim clanarinama. Pocni svoju transformaciju danas.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('trainers.index') }}" class="btn btn-accent btn-lg px-4">
                        <i class="bi bi-calendar-check me-2"></i>Zakazi trening
                    </a>
                    <a href="{{ route('memberships.index') }}" class="btn btn-outline-accent btn-lg px-4">
                        Pogledaj clanarine
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════ STATS BAR ══ --}}
<div class="stats-bar" id="statsBar">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3">
                <span class="stat-num" data-target="500" data-suffix="+">0</span>
                <span class="stat-label">Aktivnih clanova</span>
            </div>
            <div class="col-6 col-md-3">
                <span class="stat-num" data-target="15" data-suffix="+">0</span>
                <span class="stat-label">Trenera</span>
            </div>
            <div class="col-6 col-md-3">
                <span class="stat-num" data-target="2000" data-suffix="m²" data-format="true">0</span>
                <span class="stat-label">Prostora</span>
            </div>
            <div class="col-6 col-md-3">
                <span class="stat-num" data-target="98" data-suffix="%">0</span>
                <span class="stat-label">Zadovoljnih korisnika</span>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════ FEATURES ══ --}}
<section class="section" id="features">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-label">Zasto mi?</span>
            <h2 class="section-title">Sve sto ti treba na jednom mestu</h2>
            <p class="section-subtitle mx-auto">
                Nudimo kompletno fitness iskustvo — od opreme i trenera do fleksibilnih
                programa koji se prilagodjavaju tvojim ciljevima.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                    <h4>Vrhunska oprema</h4>
                    <p>Najnovije sprave i fitnes oprema svetskih brendova. Sve redovno servisirano i dostupno bez cekanja.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-person-check-fill"></i></div>
                    <h4>Iskusni treneri</h4>
                    <p>Licencirani i sertifikovani treneri koji prave personalizovan plan ishrane i treninga specijalno za tebe.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-clock-fill"></i></div>
                    <h4>Fleksibilno radno vreme</h4>
                    <p>Otvoreni svaki dan od 6 ujutru do 22h. Treniraj kada tebi odgovara, mi smo tu.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-people-fill"></i></div>
                    <h4>Grupni treninzi</h4>
                    <p>Vise od 20 vrsta grupnih casova nedeljno — od joge i pilatesa do HIIT i crossfita.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                    <h4>Pracenje napretka</h4>
                    <p>Digitalno pracenje tvog napretka i rezultata. Vidi kako rastete svakog dana kroz nas sistem.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-droplet-fill"></i></div>
                    <h4>Wellness zona</h4>
                    <p>Savna, parno kupatilo i prostor za regeneraciju. Kompletan wellness dozivljaj posle svakog treninga.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════ MEMBERSHIP PLANS ══ --}}
<section class="section section-alt" id="clanarine">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-label">Clanarine</span>
            <h2 class="section-title">Izaberi plan koji ti odgovara</h2>
            <p class="section-subtitle mx-auto">
                Bez skrivenih troskova. Otkazi kada hoces. Svi planovi ukljucuju pristup svim spravama.
            </p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4 col-lg-3">
                <div class="plan-card">
                    <div class="plan-name">Basic</div>
                    <div class="plan-price">2.500 <span>RSD/mes</span></div>
                    <hr class="plan-divider">
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Pristup teretani</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Svlacionice i tusevi</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Besplatno parkiranje</div>
                    <div class="plan-feature plan-feature-off"><i class="bi bi-x-circle"></i> Grupni treninzi</div>
                    <div class="plan-feature plan-feature-off"><i class="bi bi-x-circle"></i> Personalni trener</div>
                    <div class="plan-feature plan-feature-off"><i class="bi bi-x-circle"></i> Sauna i wellness</div>
                    <a href="{{ auth()->check() ? route('membership.checkout', 'basic') : route('login') }}" class="btn btn-outline-accent w-100 mt-4">Izaberi plan</a>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="plan-card featured">
                    <div class="plan-badge">Najpopularnije</div>
                    <div class="plan-name">Standard</div>
                    <div class="plan-price">4.500 <span>RSD/mes</span></div>
                    <hr class="plan-divider">
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Pristup teretani</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Svlacionice i tusevi</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Besplatno parkiranje</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> 2× grupna treninga/ned</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Nutritivni plan</div>
                    <div class="plan-feature plan-feature-off"><i class="bi bi-x-circle"></i> Sauna i wellness</div>
                    <a href="{{ auth()->check() ? route('membership.checkout', 'standard') : route('login') }}" class="btn btn-accent w-100 mt-4">Izaberi plan</a>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="plan-card">
                    <div class="plan-name">Premium</div>
                    <div class="plan-price">7.000 <span>RSD/mes</span></div>
                    <hr class="plan-divider">
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Pristup teretani</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Svlacionice i tusevi</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Besplatno parkiranje</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Neograniceni grupni treninzi</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> 4× personalni trening/mes</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Sauna i wellness zona</div>
                    <a href="{{ auth()->check() ? route('membership.checkout', 'premium') : route('login') }}" class="btn btn-outline-accent w-100 mt-4">Izaberi plan</a>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('memberships.index') }}" class="btn btn-ghost btn-sm px-4">
                Pogledaj sve planove <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════ TRAINERS STRIP ══ --}}
@php $stripTrainers = \App\Models\Trainer::where('is_active', true)->take(6)->get(); @endphp
@if($stripTrainers->isNotEmpty())
<section class="trainers-strip">
    <div class="container">
        <div class="row align-items-center g-5">

            {{-- Left: text --}}
            <div class="col-lg-4">
                <span class="section-label">Tim trenera</span>
                <h2 class="section-title mb-3">Upoznaj nase eksperte</h2>
                <p style="color:var(--text-muted); font-size:0.9rem; line-height:1.7; margin-bottom:1.5rem">
                    Licencirani treneri sa godinama iskustva. Svaki trener ima personalizovan pristup i brine o tvom napretku korak po korak.
                </p>
                <a href="{{ route('trainers.index') }}" class="btn btn-outline-accent px-4">
                    Svi treneri <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            {{-- Right: avatar grid --}}
            <div class="col-lg-8">
                <div class="trainer-strip-grid">
                    @foreach($stripTrainers as $t)
                    <a href="{{ route('trainers.show', $t) }}" class="trainer-strip-item">
                        @if($t->photo)
                            <div class="trainer-strip-avatar">
                                <img src="{{ asset('storage/'.$t->photo) }}" alt="{{ $t->name }}">
                            </div>
                        @else
                            <div class="trainer-strip-avatar trainer-strip-initials"
                                 style="background: {{ $t->avatar_gradient }}">
                                {{ $t->avatar_initials }}
                            </div>
                        @endif
                        <div class="trainer-strip-name">{{ $t->name }}</div>
                        <div class="trainer-strip-spec">{{ $t->specialty }}</div>
                    </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════ CTA ══ --}}
<section class="cta-section text-center">
    <div class="container position-relative">
        @auth
            <span class="section-label d-block mb-3">Dobrodosao, {{ Auth::user()->name }}!</span>
            <h2 class="cta-title mb-4">Nastavi tamo gde<br>si stao/la</h2>
            <p class="section-subtitle mx-auto mb-5" style="max-width: 460px;">
                Zakazi sledeci trening, proveri svoju clanarinu ili pogledaj dostupne trenere.
            </p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('trainers.index') }}" class="btn btn-accent btn-lg px-5">
                    <i class="bi bi-calendar-check me-2"></i>Zakazi trening
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-lg px-4">
                    <i class="bi bi-person-circle me-2"></i>Moja clanarina
                </a>
            </div>
        @else
            <span class="section-label d-block mb-3">Pocni danas</span>
            <h2 class="cta-title mb-4">Spreman/a da promenite<br>svoju rutinu?</h2>
            <p class="section-subtitle mx-auto mb-5" style="max-width: 460px;">
                Priduzi se stotinama zadovoljnih clanova. Prva nedelja je na nas — bez obaveza, bez kartice.
            </p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('register') }}" class="btn btn-accent btn-lg px-5">Registruj se besplatno</a>
                <a href="{{ route('about') }}#kontakt" class="btn btn-ghost btn-lg px-4">Kontaktiraj nas</a>
            </div>
        @endauth
    </div>
</section>

@push('scripts')
<script>
(function () {
    const counters = document.querySelectorAll('.stat-num[data-target]');
    const DURATION = 1800;

    function easeOutQuart(t) {
        return 1 - Math.pow(1 - t, 4);
    }

    function formatNumber(n, useFormat) {
        if (!useFormat) return n.toString();
        return n.toLocaleString('sr-RS').replace(',', '.');
    }

    function animateCounter(el) {
        const target  = parseInt(el.dataset.target);
        const suffix  = el.dataset.suffix || '';
        const fmt     = el.dataset.format === 'true';
        const start   = performance.now();

        function tick(now) {
            const elapsed  = now - start;
            const progress = Math.min(elapsed / DURATION, 1);
            const value    = Math.round(easeOutQuart(progress) * target);
            el.textContent = formatNumber(value, fmt) + suffix;
            if (progress < 1) requestAnimationFrame(tick);
        }

        requestAnimationFrame(tick);
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                counters.forEach(animateCounter);
                observer.disconnect();
            }
        });
    }, { threshold: 0.3 });

    const statsBar = document.getElementById('statsBar');
    if (statsBar) observer.observe(statsBar);
})();
</script>
@endpush

@endsection
