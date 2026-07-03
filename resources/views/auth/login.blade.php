@extends('layouts.app')

@section('title', 'TechnoGym - Prijavite se')

@section('content')

<div class="auth-page">
    <div class="auth-card">

        <a href="{{ route('home') }}" class="auth-logo">TECHNO<span>GYM</span></a>

        <h1 class="auth-title">Dobrodosli nazad</h1>
        <p class="auth-subtitle">Prijavite se na svoj nalog da nastavite tamo gde ste stali.</p>

        @if($errors->any())
            <div class="alert-error-custom mb-4">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
            </div>
        @endif

        <div class="auth-forgot-msg" id="forgotMsg">
            <i class="bi bi-envelope-check me-2"></i>
            Poslat je mejl za resetovanje lozinke. Proverite inbox.
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label-custom">Email adresa</label>
                <input type="email" name="email" class="form-input-custom @error('email') is-error @enderror"
                       placeholder="tvoj@email.com" value="{{ old('email') }}" autofocus>
            </div>

            <div class="mb-2">
                <label class="form-label-custom">Lozinka</label>
                <div class="password-field-wrap">
                    <input type="password" name="password" id="loginPassword" class="form-input-custom @error('password') is-error @enderror"
                           placeholder="••••••••">
                    <button type="button" class="password-toggle" onclick="togglePassword('loginPassword', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-end mb-4">
                <button type="button" class="auth-forgot-btn" id="forgotBtn">
                    Zaboravili ste lozinku?
                </button>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-4">
                <label class="auth-check-label">
                    <input type="checkbox" name="remember" class="auth-check">
                    <span>Zapamti me</span>
                </label>
            </div>

            <button type="submit" class="btn btn-accent w-100 btn-lg">
                Prijavite se
            </button>
        </form>

        <div class="auth-footer">
            Nemate nalog? <a href="{{ route('register') }}">Upisite se besplatno</a>
        </div>

    </div>
</div>

@push('scripts')
<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

document.getElementById('forgotBtn').addEventListener('click', function () {
    document.getElementById('forgotMsg').style.display = 'block';
    this.style.display = 'none';
});
</script>
@endpush

@endsection
