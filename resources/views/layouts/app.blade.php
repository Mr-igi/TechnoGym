<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TechnoGym')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">TECHNO<span>GYM</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto gap-1">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'nav-active' : '' }}" href="{{ route('home') }}">Pocetna</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('memberships.*') ? 'nav-active' : '' }}" href="{{ route('memberships.index') }}">Clanarine</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('trainers.*') ? 'nav-active' : '' }}" href="{{ route('trainers.index') }}">Treneri</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'nav-active' : '' }}" href="{{ route('about') }}">O nama</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}#kontakt">Kontakt</a></li>
            </ul>
            <div class="d-flex gap-2 align-items-center">
                @auth
                    <div class="dropdown">
                        <button class="btn btn-ghost btn-sm px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end nav-dropdown">
                            @if(Auth::user()->is_admin)
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}" style="color:var(--accent)"><i class="bi bi-shield-fill me-2"></i>Admin panel</a></li>
                            <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.07)"></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-card-checklist me-2"></i>Moja clanarina</a></li>
                            <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.07)"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger-soft">
                                        <i class="bi bi-box-arrow-right me-2"></i>Odjavite se
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-sm px-3">Prijavite se</a>
                    <a href="{{ route('register') }}" class="btn btn-success btn-sm px-3">Upisite se</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<main style="padding-top: 76px;">
    @yield('content')
</main>

<footer class="footer">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand">TECHNO<span>GYM</span></div>
                <p class="footer-desc">Moderna teretana u srcu grada. Postignite svoje ciljeve uz podršku naših iskusnih trenera i vrhunske opreme.</p>
                <div class="d-flex gap-2 mt-3">
                    <a href="https://instagram.com" target="_blank" class="social-btn"><i class="bi bi-instagram"></i></a>
                    <a href="https://facebook.com" target="_blank" class="social-btn"><i class="bi bi-facebook"></i></a>
                    <a href="https://tiktok.com" target="_blank" class="social-btn"><i class="bi bi-tiktok"></i></a>
                    <a href="https://youtube.com" target="_blank" class="social-btn"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 offset-lg-1">
                <div class="footer-heading">Navigacija</div>
                <a href="{{ route('home') }}" class="footer-link">Pocetna</a>
                <a href="{{ route('memberships.index') }}" class="footer-link">Clanarine</a>
                <a href="{{ route('trainers.index') }}" class="footer-link">Treneri</a>
                <a href="{{ route('about') }}" class="footer-link">O nama</a>
                <a href="{{ route('about') }}#kontakt" class="footer-link">Kontakt</a>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="footer-heading">Usluge</div>
                <a href="{{ route('trainers.index') }}" class="footer-link">Personalni treninzi</a>
                <a href="{{ route('trainers.index') }}" class="footer-link">Grupni treninzi</a>
                <a href="{{ route('trainers.index') }}" class="footer-link">Zakazi trening</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-heading">Kontakt</div>
                <p class="footer-link"><i class="bi bi-geo-alt me-2 text-accent"></i>Bulevar Oslobodjenja 12, Beograd</p>
                <p class="footer-link"><i class="bi bi-telephone me-2 text-accent"></i>+381 11 123 4567</p>
                <p class="footer-link"><i class="bi bi-envelope me-2 text-accent"></i>info@technogym.rs</p>
                <p class="footer-link"><i class="bi bi-clock me-2 text-accent"></i>Pon–Sub: 06:00–22:00</p>
                <p class="footer-link"><i class="bi bi-clock me-2 text-accent"></i>Ned: 08:00–20:00</p>
            </div>
        </div>
        <div class="footer-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span>&copy; {{ date('Y') }} TechnoGym. Sva prava zadrzana.</span>
            <span>Made with <i class="bi bi-heart-fill text-accent"></i> for fitness</span>
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
