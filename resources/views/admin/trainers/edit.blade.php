@extends('layouts.admin')

@section('title', 'Izmeni trenera')
@section('page-title', 'Izmeni trenera')

@section('content')

<div class="admin-card-header mb-4" style="padding:0">
    <h2 class="admin-page-title">{{ $trainer->name }}</h2>
    <a href="{{ route('admin.trainers.index') }}" class="btn btn-ghost btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Nazad
    </a>
</div>

@if(session('success'))
    <div class="alert-success-custom mb-4">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert-error-custom mb-4">
        <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
    </div>
@endif

<div class="admin-card" style="max-width: 700px">
    <form method="POST" action="{{ route('admin.trainers.update', $trainer) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="row g-3">

            {{-- Trainer type --}}
            <div class="col-12">
                <label class="form-label-custom">Tip trenera</label>
                <div class="trainer-type-selector">
                    <label class="trainer-type-option">
                        <input type="radio" name="trainer_type" value="personal"
                               id="type-personal"
                               {{ old('trainer_type', $trainer->trainer_type) === 'personal' ? 'checked' : '' }}>
                        <span class="trainer-type-card">
                            <i class="bi bi-person-fill"></i>
                            <strong>Personalni</strong>
                            <small>Trener koji radi 1-na-1, korisnici biraju termin</small>
                        </span>
                    </label>
                    <label class="trainer-type-option">
                        <input type="radio" name="trainer_type" value="group"
                               id="type-group"
                               {{ old('trainer_type', $trainer->trainer_type) === 'group' ? 'checked' : '' }}>
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
                    <div class="photo-upload-preview" id="photoPreview"
                         style="{{ $trainer->photo ? '' : 'display:none' }}">
                        <img id="photoPreviewImg"
                             src="{{ $trainer->photo ? asset('storage/'.$trainer->photo) : '' }}" alt="Preview">
                        <button type="button" class="photo-remove-btn" id="removePhoto">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="photo-upload-placeholder" id="photoPlaceholder"
                         style="{{ $trainer->photo ? 'display:none' : '' }}">
                        <i class="bi bi-camera-fill"></i>
                        <span>Klikni ili prevuci novu fotografiju</span>
                        <small>JPG, PNG, WEBP · max 2MB</small>
                    </div>
                    <input type="file" name="photo" id="photoInput" accept="image/*" class="photo-file-input">
                    <input type="hidden" name="remove_photo" id="removePhotoInput" value="0">
                </div>
            </div>

            <div class="col-sm-8">
                <label class="form-label-custom">Ime i prezime</label>
                <input type="text" name="name" class="form-input-custom @error('name') is-error @enderror"
                       value="{{ old('name', $trainer->name) }}">
            </div>
            <div class="col-sm-4">
                <label class="form-label-custom">Inicijali (ako nema foto)</label>
                <input type="text" name="avatar_initials" class="form-input-custom"
                       maxlength="3" value="{{ old('avatar_initials', $trainer->avatar_initials) }}"
                       style="text-transform:uppercase">
            </div>
            <div class="col-12">
                <label class="form-label-custom">Specijalnost</label>
                <input type="text" name="specialty" class="form-input-custom"
                       value="{{ old('specialty', $trainer->specialty) }}">
            </div>
            <div class="col-12">
                <label class="form-label-custom">Biografija</label>
                <textarea name="bio" rows="4" class="form-input-custom">{{ old('bio', $trainer->bio) }}</textarea>
            </div>

            {{-- Session price — samo za personalne --}}
            <div class="col-sm-6" id="sessionPriceField"
                 style="{{ $trainer->trainer_type === 'group' ? 'display:none' : '' }}">
                <label class="form-label-custom">Cena po terminu (RSD)</label>
                <div style="position:relative">
                    <input type="number" name="session_price" min="500" max="50000" step="100"
                           class="form-input-custom @error('session_price') is-error @enderror"
                           value="{{ old('session_price', $trainer->session_price) }}"
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
                                   {{ old('avatar_color', $currentColor) === $key ? 'checked' : '' }}>
                            <span class="admin-color-swatch" style="background: {{ $gradient }}" title="{{ ucfirst($key) }}"></span>
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="col-12">
                <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer">
                    <input type="checkbox" name="is_active" value="1"
                           {{ $trainer->is_active ? 'checked' : '' }} class="auth-check">
                    <span style="font-size:0.875rem; color:var(--text-dim)">Aktivan (vidljiv korisnicima)</span>
                </label>
            </div>
            <div class="col-12 mt-2">
                <button type="submit" class="btn btn-accent px-4">
                    <i class="bi bi-check-lg me-1"></i> Sacuvaj izmene
                </button>
            </div>
        </div>
    </form>
</div>

{{-- ══ GROUP CLASSES SECTION ══ --}}
<div id="groupClassesSection" style="{{ $trainer->trainer_type !== 'group' ? 'display:none' : '' }}">

    <div class="admin-card-header mt-5 mb-3" style="padding:0">
        <h3 class="admin-page-title" style="font-size:1.2rem">Grupni treninzi</h3>
    </div>

    {{-- Existing classes --}}
    @if($groupClasses->isNotEmpty())
        <div class="admin-card mb-4" style="padding:0; overflow:hidden">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Naziv</th>
                        <th>Sala</th>
                        <th>Raspored</th>
                        <th>Vreme</th>
                        <th>Cena/mes.</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groupClasses as $class)
                        <tr>
                            <td><strong style="color:var(--text-light)">{{ $class->name }}</strong></td>
                            <td style="color:var(--text-muted)">{{ $class->sala }}</td>
                            <td style="color:var(--text-muted); font-size:0.8rem">
                                {{ $class->sessions_per_week }}x ned. · {{ $class->days_of_week }}
                            </td>
                            <td style="color:var(--text-muted)">{{ $class->time_start }}</td>
                            <td style="color:var(--accent); font-weight:700">
                                {{ number_format($class->monthly_price, 0, ',', '.') }} RSD
                            </td>
                            <td>
                                <span class="admin-status-badge {{ $class->is_active ? 'confirmed' : 'cancelled' }}">
                                    {{ $class->is_active ? 'Aktivan' : 'Neaktivan' }}
                                </span>
                            </td>
                            <td>
                                <form method="POST"
                                      action="{{ route('admin.group-classes.destroy', [$trainer, $class]) }}"
                                      onsubmit="return confirm('Obrisati ovaj trening?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-sm"
                                            style="color:#e55353; border-color:rgba(229,83,83,0.3)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Add new class form --}}
    <div class="admin-card" style="max-width: 700px">
        <h4 style="color:var(--text-light); font-size:1rem; font-weight:700; margin-bottom:1.25rem">
            <i class="bi bi-plus-circle me-2" style="color:var(--accent)"></i>Dodaj novi grupni trening
        </h4>

        <form method="POST" action="{{ route('admin.group-classes.store', $trainer) }}">
            @csrf
            <div class="row g-3">
                <div class="col-sm-6">
                    <label class="form-label-custom">Naziv treninga</label>
                    <input type="text" name="name" class="form-input-custom"
                           placeholder="npr. Boks, Joga, HIIT..." value="{{ old('name') }}">
                </div>
                <div class="col-sm-6">
                    <label class="form-label-custom">Sala</label>
                    <input type="text" name="sala" class="form-input-custom"
                           placeholder="npr. Sala A, Sala B..." value="{{ old('sala') }}">
                </div>

                <div class="col-12">
                    <label class="form-label-custom">Dani u nedelji</label>
                    <div class="days-picker">
                        @foreach($days as $day)
                            <label class="day-pill">
                                <input type="checkbox" name="days_of_week[]" value="{{ $day }}"
                                       {{ in_array($day, old('days_of_week', [])) ? 'checked' : '' }}>
                                <span>{{ $day }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="col-sm-4">
                    <label class="form-label-custom">Vreme pocetka</label>
                    <input type="time" name="time_start" class="form-input-custom"
                           value="{{ old('time_start', '18:00') }}">
                </div>
                <div class="col-sm-4">
                    <label class="form-label-custom">Puta nedeljno</label>
                    <input type="number" name="sessions_per_week" min="1" max="7"
                           class="form-input-custom" placeholder="3"
                           value="{{ old('sessions_per_week', 3) }}">
                </div>
                <div class="col-sm-4">
                    <label class="form-label-custom">Mesecna cena (RSD)</label>
                    <div style="position:relative">
                        <input type="number" name="monthly_price" min="100" max="100000" step="100"
                               class="form-input-custom" placeholder="2500"
                               value="{{ old('monthly_price', 2500) }}"
                               style="padding-right:3.5rem">
                        <span class="price-input-suffix">RSD</span>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label-custom">Opis (opciono)</label>
                    <textarea name="description" rows="2" class="form-input-custom"
                              placeholder="Kratki opis treninga...">{{ old('description') }}</textarea>
                </div>

                <div class="col-12">
                    <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="auth-check">
                        <span style="font-size:0.875rem; color:var(--text-dim)">Aktivan (vidljiv korisnicima)</span>
                    </label>
                </div>

                <div class="col-12 mt-1">
                    <button type="submit" class="btn btn-accent px-4">
                        <i class="bi bi-plus-lg me-1"></i> Dodaj trening
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    // Photo upload
    const photoInput = document.getElementById('photoInput');
    const photoPreview = document.getElementById('photoPreview');
    const photoPreviewImg = document.getElementById('photoPreviewImg');
    const photoPlaceholder = document.getElementById('photoPlaceholder');
    const removePhoto = document.getElementById('removePhoto');
    const removePhotoInput = document.getElementById('removePhotoInput');
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
        removePhotoInput.value = '1';
        photoPreview.style.display = 'none';
        photoPlaceholder.style.display = '';
    });
    function setPhoto(file) {
        removePhotoInput.value = '0';
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
    const groupSection = document.getElementById('groupClassesSection');

    function toggleTypeFields() {
        const isGroup = document.getElementById('type-group').checked;
        priceField.style.display   = isGroup ? 'none' : '';
        groupSection.style.display = isGroup ? ''     : 'none';
    }
    document.querySelectorAll('input[name="trainer_type"]').forEach(r => {
        r.addEventListener('change', toggleTypeFields);
    });
    toggleTypeFields();
</script>
@endpush

@endsection
