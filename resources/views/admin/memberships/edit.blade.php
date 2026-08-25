@extends('layouts.admin')

@section('title', 'Izmeni plan clanarine')
@section('page-title', 'Izmeni plan clanarine')

@section('content')

<div class="admin-card-header mb-4" style="padding:0">
    <h2 class="admin-page-title">Izmeni: {{ $membership->name }}</h2>
    <a href="{{ route('admin.memberships.index') }}" class="btn btn-ghost btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Nazad
    </a>
</div>

<div class="admin-card" style="max-width: 700px">
    @if($errors->any())
        <div class="alert-error-custom mb-4">
            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.memberships.update', $membership) }}">
        @csrf @method('PUT')

        <div class="row g-3">

            <div class="col-sm-6">
                <label class="form-label-custom">Naziv plana</label>
                <input type="text" name="name" class="form-input-custom @error('name') is-error @enderror"
                       placeholder="Premium" value="{{ old('name', $membership->name) }}">
            </div>

            <div class="col-sm-6">
                <label class="form-label-custom">Slug (URL identifikator)</label>
                <input type="text" name="slug" class="form-input-custom @error('slug') is-error @enderror"
                       placeholder="premium" value="{{ old('slug', $membership->slug) }}"
                       style="font-family:monospace">
                <small style="color:var(--text-muted);font-size:0.75rem">Samo mala slova, cifre i crtice</small>
            </div>

            <div class="col-sm-6">
                <label class="form-label-custom">Cena (RSD/mesec)</label>
                <div style="position:relative">
                    <input type="number" name="price" min="100" max="999999" step="100"
                           class="form-input-custom @error('price') is-error @enderror"
                           placeholder="7000" value="{{ old('price', $membership->price) }}"
                           style="padding-right:3.5rem">
                    <span class="price-input-suffix">RSD</span>
                </div>
            </div>

            <div class="col-sm-6">
                <label class="form-label-custom">Redosled prikaza</label>
                <input type="number" name="sort_order" min="0" max="9999"
                       class="form-input-custom"
                       placeholder="1" value="{{ old('sort_order', $membership->sort_order) }}">
                <small style="color:var(--text-muted);font-size:0.75rem">Manji broj = prikazuje se pre</small>
            </div>

            <div class="col-12">
                <label class="form-label-custom">Ukljucene stavke</label>
                <textarea name="features" rows="5"
                          class="form-input-custom @error('features') is-error @enderror"
                          placeholder="Pristup teretani&#10;Svlacionice i tusevi">{{ old('features', implode("\n", $membership->features ?? [])) }}</textarea>
                <small style="color:var(--text-muted);font-size:0.75rem">Jedna stavka po redu</small>
            </div>

            <div class="col-12">
                <label class="form-label-custom">Iskljucene stavke (X oznakom)</label>
                <textarea name="features_off" rows="3"
                          class="form-input-custom"
                          placeholder="Sauna i wellness">{{ old('features_off', implode("\n", $membership->features_off ?? [])) }}</textarea>
                <small style="color:var(--text-muted);font-size:0.75rem">Jedna stavka po redu — prikazuju se precrtano sa X</small>
            </div>

            <div class="col-12 d-flex gap-4 flex-wrap">
                <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer">
                    <input type="checkbox" name="is_featured" value="1"
                           {{ old('is_featured', $membership->is_featured) ? 'checked' : '' }} class="auth-check">
                    <span style="font-size:0.875rem; color:var(--text-dim)">Najpopularnije (istaknut plan)</span>
                </label>
                <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $membership->is_active) ? 'checked' : '' }} class="auth-check">
                    <span style="font-size:0.875rem; color:var(--text-dim)">Aktivan (vidljiv korisnicima)</span>
                </label>
            </div>

            <div class="col-12 mt-2 d-flex gap-2">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-check-lg me-1"></i> Sacuvaj izmene
                </button>
                <a href="{{ route('admin.memberships.index') }}" class="btn btn-outline-danger px-4">
                    <i class="bi bi-x-lg me-1"></i> Otkazi
                </a>
            </div>
        </div>
    </form>
</div>

@endsection
