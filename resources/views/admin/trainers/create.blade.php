@extends('layouts.admin')

@section('title', 'Dodaj trenera')
@section('page-title', 'Dodaj trenera')

@section('content')

<div class="admin-card-header mb-4" style="padding:0">
    <h2 class="admin-page-title">Novi trener</h2>
    <a href="{{ route('admin.trainers.index') }}" class="btn btn-ghost btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Nazad
    </a>
</div>

<div class="admin-card" style="max-width: 700px">
    @if($errors->any())
        <div class="alert-error-custom mb-4">
            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.trainers.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">

            {{-- Trainer type --}}
            <div class="col-12">
                <label class="form-label-custom">Tip trenera</label>
                <div class="trainer-type-selector">
                    <label class="trainer-type-option">
                        <input type="radio" name="trainer_type" value="personal"
                               id="type-personal"
                               {{ old('trainer_type', 'personal') === 'personal' ? 'checked' : '' }}>
                        <span class="trainer-type-card">
                            <i class="bi bi-person-fill"></i>
                            <strong>Personalni</strong>
                            <small>Trener koji radi 1-na-1, korisnici biraju termin</small>
                        </span>
                    </label>
                    <label class="trainer-type-option">
                        <input type="radio" name="trainer_type" value="group"
                               id="type-group"
                               {{ old('trainer_type') === 'group' ? 'checked' : '' }}>
                        <span class="trainer-type-card">
                            <i class="bi bi-people-fill"></i>
                            <strong>Grupni</strong>
                            <small>Trener koji vodi grupe po fiksnom rasporedu</small>
                        </span>
                    </label>
                </div>
            </div>

            {{-- Photo upload --}}
            <div class="col-12">
                <label class="form-label-custom">Fotografija trenera</label>
                <div class="photo-upload-area" id="photoArea">
                    <div class="photo-upload-preview" id="photoPreview" style="display:none">
                        <img id="photoPreviewImg" src="" alt="Preview">
                        <button type="button" class="photo-remove-btn" id="removePhoto">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="photo-upload-placeholder" id="photoPlaceholder">
                        <i class="bi bi-camera-fill"></i>
                        <span>Klikni ili prevuci fotografiju</span>
                        <small>JPG, PNG, WEBP · max 2MB</small>
                    </div>
                    <input type="file" name="photo" id="photoInput" accept="image/*" class="photo-file-input">
                </div>
            </div>

            <div class="col-sm-8">
                <label class="form-label-custom">Ime i prezime</label>
                <input type="text" name="name" class="form-input-custom @error('name') is-error @enderror"
                       placeholder="Marko Markovic" value="{{ old('name') }}">
            </div>
            <div class="col-sm-4">
                <label class="form-label-custom">Inicijali (ako nema foto)</label>
                <input type="text" name="avatar_initials" class="form-input-custom"
                       placeholder="MM" maxlength="3" value="{{ old('avatar_initials') }}"
                       style="text-transform:uppercase">
            </div>
            <div class="col-12">
                <label class="form-label-custom">Specijalnost</label>
                <input type="text" name="specialty" class="form-input-custom @error('specialty') is-error @enderror"
                       placeholder="Snaga & Kondicija" value="{{ old('specialty') }}">
            </div>
            <div class="col-12">
                <label class="form-label-custom">Biografija</label>
                <textarea name="bio" rows="4" class="form-input-custom @error('bio') is-error @enderror"
                          placeholder="Kratka biografija trenera...">{{ old('bio') }}</textarea>
            </div>

            {{-- Session price — samo za personalne --}}
            <div class="col-sm-6" id="sessionPriceField">
                <label class="form-label-custom">Cena po terminu (RSD)</label>
                <div style="position:relative">
                    <input type="number" name="session_price" min="500" max="50000" step="100"
                           class="form-input-custom @error('session_price') is-error @enderror"
                           placeholder="3000" value="{{ old('session_price', 3000) }}"
                           style="padding-right:3.5rem">
                    <span class="price-input-suffix">RSD</span>
                </div>
                <small style="color:var(--text-muted);font-size:0.75rem">Cena jednog personalnog treninga (60 min)</small>
            </div>

            <div class="col-12">
                <label class="form-label-custom">Boja avatara (fallback bez fotografije)</label>
                <div class="admin-color-picker">
                    @foreach($gradients as $key => $gradient)
                        <label class="admin-color-option">
                            <input type="radio" name="avatar_color" value="{{ $key }}"
                                   {{ old('avatar_color', 'red') === $key ? 'checked' : '' }}>
                            <span class="admin-color-swatch" style="background: {{ $gradient }}" title="{{ ucfirst($key) }}"></span>
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="col-12">
                <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="auth-check">
                    <span style="font-size:0.875rem; color:var(--text-dim)">Aktivan (vidljiv korisnicima)</span>
                </label>
            </div>
            <div class="col-12 mt-2 d-flex gap-2">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-check-lg me-1"></i> Sacuvaj trenera
                </button>
                <a href="{{ route('admin.trainers.index') }}" class="btn btn-outline-danger px-4">
                    <i class="bi bi-x-lg me-1"></i> Otkazi
                </a>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Photo upload
    const photoInput = document.getElementById('photoInput');
    const photoPreview = document.getElementById('photoPreview');
    const photoPreviewImg = document.getElementById('photoPreviewImg');
    const photoPlaceholder = document.getElementById('photoPlaceholder');
    const removePhoto = document.getElementById('removePhoto');
    const photoArea = document.getElementById('photoArea');

    photoArea.addEventListener('click', (e) => {
        if (!e.target.closest('.photo-remove-btn')) photoInput.click();
    });
    photoArea.addEventListener('dragover', (e) => { e.preventDefault(); photoArea.classList.add('drag-over'); });
    photoArea.addEventListener('dragleave', () => photoArea.classList.remove('drag-over'));
    photoArea.addEventListener('drop', (e) => {
        e.preventDefault();
        photoArea.classList.remove('drag-over');
        if (e.dataTransfer.files[0]) setPhoto(e.dataTransfer.files[0]);
    });
    photoInput.addEventListener('change', () => { if (photoInput.files[0]) setPhoto(photoInput.files[0]); });
    removePhoto.addEventListener('click', (e) => {
        e.stopPropagation();
        photoInput.value = '';
        photoPreview.style.display = 'none';
        photoPlaceholder.style.display = '';
    });
    function setPhoto(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            photoPreviewImg.src = e.target.result;
            photoPreview.style.display = '';
            photoPlaceholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }

    // Trainer type toggle
    const priceField = document.getElementById('sessionPriceField');
    function togglePriceField() {
        const isGroup = document.getElementById('type-group').checked;
        priceField.style.display = isGroup ? 'none' : '';
    }
    document.querySelectorAll('input[name="trainer_type"]').forEach(r => {
        r.addEventListener('change', togglePriceField);
    });
    togglePriceField();
</script>
@endpush

@endsection
