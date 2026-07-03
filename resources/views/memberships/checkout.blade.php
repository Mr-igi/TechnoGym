@extends('layouts.app')

@section('title', 'TechnoGym - Kupovina clanarine')

@section('content')

<div class="checkout-page">
    <div class="container">
        <div class="row justify-content-center g-5">

            {{-- Order summary --}}
            <div class="col-lg-4 col-md-5">
                <div class="checkout-summary">
                    <div class="checkout-summary-label">Tvoj izbor</div>
                    <div class="checkout-plan-name">{{ $plan['name'] }}</div>
                    <div class="checkout-plan-price">
                        {{ number_format($plan['price'], 0, ',', '.') }}
                        <span>RSD / mesec</span>
                    </div>
                    <hr class="checkout-divider">
                    <ul class="checkout-features">
                        @foreach($plan['features'] as $feature)
                            <li><i class="bi bi-check-circle-fill"></i> {{ $feature }}</li>
                        @endforeach
                        @foreach($plan['features_off'] ?? [] as $feature)
                            <li class="off"><i class="bi bi-x-circle"></i> {{ $feature }}</li>
                        @endforeach
                    </ul>
                    <hr class="checkout-divider">
                    <div class="checkout-total-row">
                        <span>Ukupno danas</span>
                        <span class="checkout-total-price">{{ number_format($plan['price'], 0, ',', '.') }} RSD</span>
                    </div>
                    <div class="checkout-total-row" style="font-size:0.8rem; color: var(--text-muted)">
                        <span>Trajanje</span>
                        <span>30 dana</span>
                    </div>
                    <div class="checkout-secure mt-3">
                        <i class="bi bi-lock-fill"></i> Sigurna SSL naplata
                    </div>
                </div>
            </div>

            {{-- Payment form --}}
            <div class="col-lg-6 col-md-7">
                <div class="checkout-form-wrap">
                    <a href="{{ route('memberships.index') }}" class="checkout-back">
                        <i class="bi bi-arrow-left me-1"></i> Nazad
                    </a>
                    <h1 class="checkout-title">Podaci o placanju</h1>
                    <p class="checkout-subtitle">Unesi podatke sa kartice. Naplata je simulirana — ne koristi pravu karticu.</p>

                    @if($errors->any())
                        <div class="alert-error-custom mb-4">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('membership.purchase') }}" id="checkoutForm">
                        @csrf
                        <input type="hidden" name="plan" value="{{ $plan['slug'] }}">

                        <div class="checkout-section-label">Podaci o kartici</div>

                        <div class="mb-3">
                            <label class="form-label-custom">Ime vlasnika kartice</label>
                            <input type="text" name="cardholder_name"
                                   class="form-input-custom @error('cardholder_name') is-error @enderror"
                                   placeholder="Marko Markovic" value="{{ old('cardholder_name') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Broj kartice</label>
                            <div class="card-number-wrap">
                                <input type="text" name="card_number" id="cardNumber"
                                       class="form-input-custom @error('card_number') is-error @enderror"
                                       placeholder="0000 0000 0000 0000"
                                       maxlength="19" inputmode="numeric" autocomplete="cc-number"
                                       value="{{ old('card_number') }}">
                                <i class="bi bi-credit-card-2-front card-number-icon"></i>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <label class="form-label-custom">Datum isteka</label>
                                <input type="text" name="card_expiry" id="cardExpiry"
                                       class="form-input-custom @error('card_expiry') is-error @enderror"
                                       placeholder="MM/GG" maxlength="5" inputmode="numeric"
                                       value="{{ old('card_expiry') }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label-custom">CVV</label>
                                <input type="text" name="card_cvv"
                                       class="form-input-custom @error('card_cvv') is-error @enderror"
                                       placeholder="•••" maxlength="4" inputmode="numeric">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-accent btn-lg w-100" id="submitBtn">
                            <i class="bi bi-lock-fill me-2"></i>
                            Plati {{ number_format($plan['price'], 0, ',', '.') }} RSD
                        </button>

                        <p class="checkout-note">
                            <i class="bi bi-shield-fill me-1"></i>
                            Kliknom na dugme prihvatas nase <a href="{{ route('about') }}">uslove koriscenja</a>.
                            Clanarina se automatski obnavlja svakih 30 dana.
                        </p>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    // Format card number with spaces
    document.getElementById('cardNumber').addEventListener('input', function (e) {
        let val = e.target.value.replace(/\D/g, '').slice(0, 16);
        e.target.value = val.replace(/(.{4})/g, '$1 ').trim();
    });

    // Format expiry MM/GG
    document.getElementById('cardExpiry').addEventListener('input', function (e) {
        let val = e.target.value.replace(/\D/g, '').slice(0, 4);
        if (val.length >= 3) val = val.slice(0, 2) + '/' + val.slice(2);
        e.target.value = val;
    });

    // Before submit: strip spaces from card number
    document.getElementById('checkoutForm').addEventListener('submit', function () {
        const cn = document.getElementById('cardNumber');
        cn.value = cn.value.replace(/\s/g, '');
    });
</script>
@endpush

@endsection
