@extends('layouts.app')

@section('title', 'TechnoGym - O nama')

@section('content')

{{-- ══════════════════════════════════ PAGE HERO ══ --}}
<section class="page-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-7">
                <span class="section-label">Ko smo mi</span>
                <h1 class="page-hero-title">O nama</h1>
                <p class="page-hero-subtitle">
                    Vise od 8 godina pomazemo ljudima da dostignu svoje fitnes ciljeve.
                    Nasa prica pocinila je u maloj sali, a danas smo jedna od vodecih teretana u gradu.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════ STORY ══ --}}
<section class="section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-label">Nasa prica</span>
                <h2 class="section-title">Poceli smo sa jednim ciljem — tvojim rezultatima</h2>
                <p class="about-text">
                    TechnoGym je osnovan 2016. godine sa vizijom da fitness postane dostupan svima,
                    bez obzira na nivo treniranosti ili iskustvo. Verujemo da svako telo zasluzuje
                    strucnu pazu i profesionalan pristup.
                </p>
                <p class="about-text">
                    Tokom godina izgradili smo tim od preko 15 sertifikovanih trenera koji zajedno
                    broje vise od 100 godina iskustva. Svaki klijent dobija personalizovan plan
                    i pracenje napretka od prvog dana.
                </p>
                <p class="about-text">
                    Danas imamo vise od 500 aktivnih clanova i ponos nam je sto vecina njih
                    dolazi po preporuci. Nasa najveca nagrada su vasi rezultati.
                </p>
                <div class="about-stats">
                    <div class="about-stat">
                        <span class="about-stat-num">2016.</span>
                        <span class="about-stat-label">Godina osnivanja</span>
                    </div>
                    <div class="about-stat">
                        <span class="about-stat-num">500+</span>
                        <span class="about-stat-label">Zadovoljnih clanova</span>
                    </div>
                    <div class="about-stat">
                        <span class="about-stat-num">15+</span>
                        <span class="about-stat-label">Strucnih trenera</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-image-wrap">
                    <div class="about-image-inner"></div>
                    <div class="about-image-badge">
                        <span class="about-image-badge-num">8+</span>
                        <span class="about-image-badge-text">Godina iskustva</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════ VALUES ══ --}}
<section class="section section-alt">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-label">Nase vrednosti</span>
            <h2 class="section-title">Principi koji nas vode</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="value-card text-center">
                    <div class="value-icon mx-auto"><i class="bi bi-trophy-fill"></i></div>
                    <h5>Rezultati</h5>
                    <p>Fokusirani smo isklucivo na tvoj napredak i merljive rezultate.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="value-card text-center">
                    <div class="value-icon mx-auto"><i class="bi bi-shield-fill"></i></div>
                    <h5>Bezbednost</h5>
                    <p>Pravilna tehnika i sigurnost na prvom mestu — uvek.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="value-card text-center">
                    <div class="value-icon mx-auto"><i class="bi bi-heart-fill"></i></div>
                    <h5>Posvećenost</h5>
                    <p>Svaki trener je posvecen svakom klijentu bez izuzetka.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="value-card text-center">
                    <div class="value-icon mx-auto"><i class="bi bi-stars"></i></div>
                    <h5>Kvalitet</h5>
                    <p>Vrhunska oprema, cist prostor i profesionalan tim svaki dan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════ CONTACT FORM ══ --}}
<section class="section section-alt" id="kontakt">
    <div class="container">
        <div class="row g-5 justify-content-between">

            {{-- Info --}}
            <div class="col-lg-4">
                <span class="section-label">Kontakt</span>
                <h2 class="section-title">Pisi nam</h2>
                <p class="section-subtitle mb-5">
                    Imas pitanje o clanarini, treninzima ili zelite da zakazete obilazak teretane?
                    Javi nam se, odgovaramo u roku od 24h.
                </p>

                <div class="contact-info-item">
                    <div class="contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
                    <div>
                        <div class="contact-info-label">Adresa</div>
                        <div class="contact-info-value">Bulevar Oslobodjenja 12, Beograd</div>
                    </div>
                </div>
                <div class="contact-info-item">
                    <div class="contact-icon"><i class="bi bi-telephone-fill"></i></div>
                    <div>
                        <div class="contact-info-label">Telefon</div>
                        <div class="contact-info-value">+381 11 123 4567</div>
                    </div>
                </div>
                <div class="contact-info-item">
                    <div class="contact-icon"><i class="bi bi-envelope-fill"></i></div>
                    <div>
                        <div class="contact-info-label">Email</div>
                        <div class="contact-info-value">info@technogym.rs</div>
                    </div>
                </div>
                <div class="contact-info-item">
                    <div class="contact-icon"><i class="bi bi-clock-fill"></i></div>
                    <div>
                        <div class="contact-info-label">Radno vreme</div>
                        <div class="contact-info-value">Pon–Sub: 06:00–22:00<br>Ned: 08:00–20:00</div>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="col-lg-7">
                @if(session('success'))
                    <div class="alert-success-custom mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact') }}" method="POST" class="contact-form">
                    @csrf
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label-custom">Ime i prezime</label>
                            <input type="text" name="name" class="form-input-custom @error('name') is-error @enderror"
                                   placeholder="Marko Markovic" value="{{ old('name') }}">
                            @error('name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-custom">Email adresa</label>
                            <input type="email" name="email" class="form-input-custom @error('email') is-error @enderror"
                                   placeholder="marko@email.com" value="{{ old('email') }}">
                            @error('email')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">Tema poruke</label>
                            <input type="text" name="subject" class="form-input-custom @error('subject') is-error @enderror"
                                   placeholder="Pitanje o clanarini..." value="{{ old('subject') }}">
                            @error('subject')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">Poruka</label>
                            <textarea name="message" rows="6" class="form-input-custom @error('message') is-error @enderror"
                                      placeholder="Napisite nam...">{{ old('message') }}</textarea>
                            @error('message')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="bi bi-send-fill me-2"></i>Posalji poruku
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

@endsection
