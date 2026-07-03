<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — TechnoGym</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-body">

{{-- Sidebar --}}
<aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar-logo">
        <a href="{{ route('admin.dashboard') }}">TECHNO<span>GYM</span></a>
        <span class="admin-badge">ADMIN</span>
    </div>

    <nav class="admin-nav">
        <div class="admin-nav-label">Glavni meni</div>

        <a href="{{ route('admin.dashboard') }}"
           class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-3x2-gap-fill"></i> Pregled
        </a>
        <a href="{{ route('admin.trainers.index') }}"
           class="admin-nav-item {{ request()->routeIs('admin.trainers.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge-fill"></i> Treneri
        </a>
        <a href="{{ route('admin.sessions.index') }}"
           class="admin-nav-item {{ request()->routeIs('admin.sessions.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-event-fill"></i> Zakazivanja
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="admin-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Korisnici
        </a>
        <a href="{{ route('admin.memberships.index') }}"
           class="admin-nav-item {{ request()->routeIs('admin.memberships.*') ? 'active' : '' }}">
            <i class="bi bi-credit-card-fill"></i> Clanarine
        </a>

        <div class="admin-nav-label mt-4">Sajt</div>
        <a href="{{ route('home') }}" target="_blank" class="admin-nav-item">
            <i class="bi bi-box-arrow-up-right"></i> Pogledaj sajt
        </a>
    </nav>

    <div class="admin-sidebar-footer">
        <div class="admin-user-info">
            <div class="admin-user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div>
                <div class="admin-user-name">{{ Auth::user()->name }}</div>
                <div class="admin-user-role">Administrator</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="admin-logout-btn" title="Odjava">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </form>
    </div>
</aside>

{{-- Main --}}
<div class="admin-main">
    {{-- Topbar --}}
    <header class="admin-topbar">
        <button class="admin-menu-toggle" id="menuToggle">
            <i class="bi bi-list"></i>
        </button>
        <div class="admin-topbar-title">@yield('page-title', 'Dashboard')</div>
        <div class="admin-topbar-right">
            <span style="font-size:0.8rem; color: var(--text-muted)">{{ now()->format('d.m.Y') }}</span>
        </div>
    </header>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="admin-alert admin-alert--success">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="admin-alert admin-alert--error">
            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
        </div>
    @endif

    <main class="admin-content">
        @yield('content')
    </main>
</div>

<script>
    document.getElementById('menuToggle')?.addEventListener('click', () => {
        document.getElementById('adminSidebar').classList.toggle('open');
    });
</script>
@stack('scripts')
</body>
</html>
