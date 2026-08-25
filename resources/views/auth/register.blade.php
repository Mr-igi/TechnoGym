@extends('layouts.app')

@section('title', 'TechnoGym - Upisite se')

@section('content')

<div class="auth-page">
    <div class="auth-card">

        <a href="{{ route('home') }}" class="auth-logo">TECHNO<span>GYM</span></a>

        <h1 class="auth-title">Kreirajte nalog</h1>
        <p class="auth-subtitle">Pridruzite se TechnoGymu i pocnite svoju transformaciju danas.</p>

        @if($errors->any())
            <div class="alert-error-custom mb-4">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label-custom">Ime i prezime</label>
                <input type="text" name="name" class="form-input-custom @error('name') is-error @enderror"
                       placeholder="Marko Markovic" value="{{ old('name') }}" autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label-custom">Email adresa</label>
                <input type="email" name="email" class="form-input-custom @error('email') is-error @enderror"
                       placeholder="tvoj@email.com" value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label class="form-label-custom">Lozinka</label>
                <div class="password-field-wrap">
                    <input type="password" name="password" id="regPassword" class="form-input-custom @error('password') is-error @enderror"
                           placeholder="Minimum 8 karaktera">
                    <button type="button" class="password-toggle" onclick="togglePassword('regPassword', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label-custom">Potvrdi lozinku</label>
                <div class="password-field-wrap">
                    <input type="password" name="password_confirmation" id="regPasswordConfirm" class="form-input-custom"
                           placeholder="Ponovi lozinku">
                    <button type="button" class="password-toggle" onclick="togglePassword('regPasswordConfirm', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100 btn-lg">
                Upisite se
            </button>
        </form>

        <div class="auth-footer">
            Vec imate nalog? <a href="{{ route('login') }}">Prijavite se</a>
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
</script>
@endpush

@endsection
