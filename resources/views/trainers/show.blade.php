@extends('layouts.app')

@section('title', 'TechnoGym - ' . ($trainer->isGroup() ? 'Grupni treninzi' : 'Zakazi trening') . ' — ' . $trainer->name)

@section('content')

<div class="booking-page">
    <div class="container">

        <a href="{{ route('trainers.index') }}" class="checkout-back mb-4 d-inline-flex">
            <i class="bi bi-arrow-left me-1"></i> Svi treneri
        </a>

        @if($trainer->isGroup())
            {{-- ════════════════════ GROUP TRAINER VIEW ════════════════════ --}}
            <div class="row g-5">

                <div class="col-lg-4">
                    <div class="booking-trainer-card">
                        @if($trainer->photo)
                            <div class="trainer-photo-wrap booking-avatar">
                                <img src="{{ asset('storage/' . $trainer->photo) }}" alt="{{ $trainer->name }}" class="trainer-photo-img">
                            </div>
                        @else
                            <div class="trainer-avatar booking-avatar" style="background: {{ $trainer->avatar_gradient }}">
                                {{ $trainer->avatar_initials }}
                            </div>
                        @endif
                        <div class="booking-trainer-info">
                            <div class="group-trainer-badge mb-2">
                                <i class="bi bi-people-fill me-1"></i> Grupni trener
                            </div>
                            <div class="trainer-name">{{ $trainer->name }}</div>
                            <div class="trainer-spec">{{ $trainer->specialty }}</div>
                            <p class="trainer-desc mt-2">{{ $trainer->bio }}</p>
                        </div>
                        <div class="booking-trainer-meta">
                            <div class="booking-meta-item">
                                <i class="bi bi-geo-alt"></i>
                                <span>TechnoGym — vise sala</span>
                            </div>
                            <div class="booking-meta-item">
                                <i class="bi bi-people-fill" style="color:var(--accent)"></i>
                                <span>{{ $trainer->groupClasses->where('is_active', true)->count() }} aktivnih programa</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <h1 class="checkout-title">Raspored grupnih treninga</h1>
                    <p class="checkout-subtitle">Izaberi program koji ti odgovara i prikljuci se grupi.</p>

                    @php $activeClasses = $trainer->groupClasses->where('is_active', true); @endphp

                    @if($activeClasses->isEmpty())
                        <div class="group-empty-state">
                            <i class="bi bi-calendar-x"></i>
                            <p>Trenutno nema aktivnih grupnih treninga za ovog trenera.</p>
                        </div>
                    @else
                        <div class="group-classes-list">
                            @foreach($activeClasses as $class)
                                <div class="group-class-card">
                                    <div class="group-class-header">
                                        <div>
                                            <div class="group-class-name">{{ $class->name }}</div>
                                            <div class="group-class-sala">
                                                <i class="bi bi-geo-alt-fill me-1"></i>{{ $class->sala }}
                                            </div>
                                        </div>
                                        <div class="group-class-price-badge">
                                            <div class="group-class-price">{{ number_format($class->monthly_price, 0, ',', '.') }} RSD</div>
                                            <div class="group-class-price-label">mesecno</div>
                                        </div>
                                    </div>
                                    <div class="group-class-schedule">
                                        <div class="group-class-schedule-item"><i class="bi bi-arrow-repeat"></i><span>{{ $class->sessions_per_week }}x nedeljno</span></div>
                                        <div class="group-class-schedule-item"><i class="bi bi-calendar3"></i><span>{{ $class->days_of_week }}</span></div>
                                        <div class="group-class-schedule-item"><i class="bi bi-clock"></i><span>{{ $class->time_start }}</span></div>
                                    </div>
                                    @if($class->description)
                                        <p class="group-class-desc">{{ $class->description }}</p>
                                    @endif
                                    <div class="group-class-footer">
                                        <div class="group-class-summary">
                                            <i class="bi bi-info-circle me-1"></i>
                                            {{ $class->sessions_per_week }}x nedeljno · {{ $class->sala }} · {{ $class->days_of_week }} u {{ $class->time_start }}
                                        </div>
                                        <a href="{{ route('group-classes.inquiry', $class) }}" class="btn btn-accent btn-sm">
                                            <i class="bi bi-envelope me-1"></i>Prijavite se
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        @else
            {{-- ════════════════════ PERSONAL TRAINER BOOKING VIEW ════════════════════ --}}

            @guest
                <div class="auth-page" style="min-height: auto; padding: 3rem 0">
                    <div class="auth-card" style="max-width: 480px">
                        <div class="text-center mb-4" style="font-size:2.5rem; color: var(--accent)">
                            <i class="bi bi-lock-fill"></i>
                        </div>
                        <h2 class="auth-title text-center">Prijava potrebna</h2>
                        <p class="auth-subtitle text-center">
                            Da bi zakazao trening sa <strong style="color:var(--text-light)">{{ $trainer->name }}</strong>,
                            moraš biti prijavljen na nalog.
                        </p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('login') }}" class="btn btn-accent flex-fill">Prijavi se</a>
                            <a href="{{ route('register') }}" class="btn btn-ghost flex-fill">Registruj se</a>
                        </div>
                    </div>
                </div>
            @else

            <div class="row g-5">

                {{-- ── Trainer card ─────────────────────── --}}
                <div class="col-lg-4">
                    <div class="booking-trainer-card">
                        @if($trainer->photo)
                            <div class="trainer-photo-wrap booking-avatar">
                                <img src="{{ asset('storage/' . $trainer->photo) }}" alt="{{ $trainer->name }}" class="trainer-photo-img">
                            </div>
                        @else
                            <div class="trainer-avatar booking-avatar" style="background: {{ $trainer->avatar_gradient }}">
                                {{ $trainer->avatar_initials }}
                            </div>
                        @endif
                        <div class="booking-trainer-info">
                            <div class="trainer-name">{{ $trainer->name }}</div>
                            <div class="trainer-spec">{{ $trainer->specialty }}</div>
                            <p class="trainer-desc mt-2">{{ $trainer->bio }}</p>
                        </div>
                        <div class="booking-price-badge">
                            <div class="booking-price-amount">{{ number_format($trainer->session_price, 0, ',', '.') }} RSD</div>
                            <div class="booking-price-label">po terminu · 60 min</div>
                        </div>
                        <div class="booking-trainer-meta">
                            <div class="booking-meta-item">
                                <i class="bi bi-clock"></i>
                                <span>Trajanje: 60 minuta</span>
                            </div>
                            <div class="booking-meta-item">
                                <i class="bi bi-geo-alt"></i>
                                <span>TechnoGym, Sala A</span>
                            </div>
                            <div class="booking-meta-item">
                                <i class="bi bi-shield-check" style="color:#4ade80"></i>
                                <span>Besplatno otkazivanje 24h ranije</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Booking form ──────────────────────── --}}
                <div class="col-lg-8">
                    <h1 class="checkout-title">Zakazi personalni trening</h1>
                    <p class="checkout-subtitle">Izaberi datum i termin koji ti odgovara.</p>

                    @if($errors->any())
                        <div class="alert-error-custom mb-4">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('sessions.store') }}" id="bookingForm">
                        @csrf
                        <input type="hidden" name="trainer_id" value="{{ $trainer->id }}">
                        <input type="hidden" name="date"  id="hiddenDate"  value="{{ old('date',  now()->addDay()->format('Y-m-d')) }}">
                        <input type="hidden" name="hour"  id="hiddenHour"  value="{{ old('hour') }}">

                        {{-- ── STEP 1: Datum ── --}}
                        <div class="booking-step">
                            <div class="booking-step-label">
                                <span class="booking-step-num">1</span>
                                Izaberi datum
                                <span id="dateStepSub" class="booking-step-sub"></span>
                            </div>

                            <div class="booking-cal-grid">
                                <div class="bcg-header">
                                    <span>Pon</span>
                                    <span>Uto</span>
                                    <span>Sre</span>
                                    <span>Čet</span>
                                    <span>Pet</span>
                                    <span>Sub</span>
                                    <span>Ned</span>
                                </div>
                                <div class="bcg-days" id="calGrid"></div>
                            </div>
                        </div>

                        {{-- ── STEP 2: Termin ── --}}
                        <div class="booking-step">
                            <div class="booking-step-label">
                                <span class="booking-step-num">2</span>
                                Izaberi termin
                                <span id="slotStepSub" class="booking-step-sub"></span>
                            </div>

                            <div id="slotsContainer">
                                <div class="slots-loading">
                                    <i class="bi bi-hourglass-split"></i> Ucitavanje termina...
                                </div>
                            </div>

                            <div class="slots-legend mt-3">
                                <span class="slot-demo slot-demo--free"></span> Slobodan &nbsp;
                                <span class="slot-demo slot-demo--taken"></span> Zauzet &nbsp;
                                <span class="slot-demo slot-demo--selected"></span> Izabran
                            </div>
                        </div>

                        {{-- ── STEP 3: Napomena ── --}}
                        <div class="booking-step">
                            <div class="booking-step-label">
                                <span class="booking-step-num">3</span>
                                Napomena <span style="color:var(--text-muted);font-weight:400">(opciono)</span>
                            </div>
                            <textarea name="notes" rows="3" class="form-input-custom"
                                      placeholder="Recite treneru na cemu zelite da radite...">{{ old('notes') }}</textarea>
                        </div>

                        {{-- ── SUMMARY + SUBMIT ── --}}
                        <div id="bookingSummary" class="booking-summary booking-summary--hidden">
                            <div class="booking-summary-inner">
                                <i class="bi bi-calendar2-check-fill booking-summary-icon"></i>
                                <div>
                                    <div class="booking-summary-label">Odabrani termin</div>
                                    <div class="booking-summary-value" id="summaryDateTime">—</div>
                                </div>
                                <div class="booking-summary-price ms-auto">
                                    {{ number_format($trainer->session_price, 0, ',', '.') }} RSD
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-accent btn-lg px-5 w-100 mt-3" id="bookBtn" disabled>
                            <i class="bi bi-calendar-check me-2"></i>Potvrdi termin
                        </button>
                        <p style="font-size:0.75rem; color:var(--text-muted); text-align:center; margin-top:0.75rem">
                            <i class="bi bi-lock-fill me-1"></i>Zakazivanje je potvrdjeno odmah — bez naplate unapred
                        </p>
                    </form>
                </div>

            </div>
            @endguest

        @endif

    </div>
</div>

@push('scripts')
@if($trainer->isPersonal())
<script>
(function () {
    const TRAINER_ID   = {{ $trainer->id }};
    const SESSION_PRICE = '{{ number_format($trainer->session_price, 0, ",", ".") }}';

    const DAYS_SR_FULL = ['Nedeljom', 'Ponedeljak', 'Utorak', 'Sreda', 'Četvrtak', 'Petak', 'Subota'];
    const MONTHS_SR    = ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Avg', 'Sep', 'Okt', 'Nov', 'Dec'];
    const MONTHS_GEN   = ['januara', 'februara', 'marta', 'aprila', 'maja', 'juna', 'jula', 'avgusta', 'septembra', 'oktobra', 'novembra', 'decembra'];

    const SLOT_GROUPS = [
        { label: 'Jutro',    icon: 'bi-sunrise-fill',   hours: [6,7,8,9,10,11] },
        { label: 'Popodne',  icon: 'bi-sun-fill',        hours: [12,13,14,15,16] },
        { label: 'Veče',     icon: 'bi-moon-stars-fill', hours: [17,18,19,20,21] },
    ];

    const today   = new Date(); today.setHours(0,0,0,0);
    const minDate = new Date(today); minDate.setDate(today.getDate() + 1);
    const maxDate = new Date(today); maxDate.setDate(today.getDate() + 30);

    const hiddenDate      = document.getElementById('hiddenDate');
    const hiddenHour      = document.getElementById('hiddenHour');
    const calGrid         = document.getElementById('calGrid');
    const slotsContainer  = document.getElementById('slotsContainer');
    const bookBtn         = document.getElementById('bookBtn');
    const bookingSummary  = document.getElementById('bookingSummary');
    const summaryDateTime = document.getElementById('summaryDateTime');
    const slotStepSub     = document.getElementById('slotStepSub');
    const dateStepSub     = document.getElementById('dateStepSub');

    let selectedDate = hiddenDate.value || toDateStr(minDate);
    let currentHour  = parseInt(hiddenHour.value) || null;
    let bookedHours  = [];

    // ── Helpers ────────────────────────────────────
    function toDateStr(d) {
        return d.getFullYear() + '-' +
               String(d.getMonth() + 1).padStart(2, '0') + '-' +
               String(d.getDate()).padStart(2, '0');
    }

    function parseDate(ds) {
        const [y, m, d] = ds.split('-').map(Number);
        return new Date(y, m - 1, d);
    }

    // ── Calendar grid ──────────────────────────────
    function renderCalendar() {
        calGrid.innerHTML = '';

        // Find Monday of the week containing minDate
        const gridStart = new Date(minDate);
        const dow = gridStart.getDay();                      // 0=Sun
        const toMon = dow === 0 ? -6 : 1 - dow;             // shift to Monday
        gridStart.setDate(gridStart.getDate() + toMon);

        // Find Sunday of the week containing maxDate
        const gridEnd = new Date(maxDate);
        const dowEnd  = gridEnd.getDay();
        const toSun   = dowEnd === 0 ? 0 : 7 - dowEnd;
        gridEnd.setDate(gridEnd.getDate() + toSun);

        const cur = new Date(gridStart);
        while (cur <= gridEnd) {
            const ds        = toDateStr(cur);
            const inRange   = cur >= minDate && cur <= maxDate;
            const isSelected = ds === selectedDate;
            const isFirst   = cur.getDate() === 1;

            const cell = document.createElement('button');
            cell.type  = 'button';

            if (!inRange) {
                cell.className = 'bcg-day bcg-day--out';
                cell.disabled  = true;
                cell.innerHTML = `<span class="bcg-num">${cur.getDate()}</span>`;
            } else if (isSelected) {
                cell.className = 'bcg-day bcg-day--selected';
                cell.innerHTML = isFirst
                    ? `<span class="bcg-num">${cur.getDate()}</span><span class="bcg-mon">${MONTHS_SR[cur.getMonth()]}</span>`
                    : `<span class="bcg-num">${cur.getDate()}</span>`;
                cell.addEventListener('click', () => pickDate(ds));
            } else {
                cell.className = 'bcg-day';
                cell.innerHTML = isFirst
                    ? `<span class="bcg-num">${cur.getDate()}</span><span class="bcg-mon">${MONTHS_SR[cur.getMonth()]}</span>`
                    : `<span class="bcg-num">${cur.getDate()}</span>`;
                cell.addEventListener('click', () => pickDate(ds));
            }

            calGrid.appendChild(cell);
            cur.setDate(cur.getDate() + 1);
        }

        // Update date step sub-label
        if (selectedDate) {
            const d = parseDate(selectedDate);
            dateStepSub.textContent = `— ${DAYS_SR_FULL[d.getDay()]}, ${d.getDate()}. ${MONTHS_SR[d.getMonth()]}`;
        }
    }

    function pickDate(ds) {
        selectedDate      = ds;
        hiddenDate.value  = ds;
        currentHour       = null;
        hiddenHour.value  = '';
        bookBtn.disabled  = true;
        slotStepSub.textContent = '';
        renderCalendar();
        loadSlots(ds);
        updateSummary();
    }

    // ── Slot loading ───────────────────────────────
    async function loadSlots(date) {
        slotsContainer.innerHTML = '<div class="slots-loading"><i class="bi bi-hourglass-split"></i> Ucitavanje termina...</div>';
        try {
            const res  = await fetch(`/treneri/${TRAINER_ID}/dostupnost?date=${date}`);
            const data = await res.json();
            bookedHours = data.booked.map(Number);
            renderSlots();
        } catch (e) {
            slotsContainer.innerHTML = '<p style="color:#e55353;font-size:.875rem;padding:.5rem 0">Greška pri ucitavanju termina. Osvezi stranicu.</p>';
        }
    }

    function renderSlots() {
        slotsContainer.innerHTML = '';

        let allTaken = true;

        SLOT_GROUPS.forEach(group => {
            const freeInGroup = group.hours.filter(h => !bookedHours.includes(h));
            if (freeInGroup.length > 0) allTaken = false;

            const groupEl = document.createElement('div');
            groupEl.className = 'slot-group';

            const labelEl = document.createElement('div');
            labelEl.className = 'slot-group-label';
            labelEl.innerHTML = `<i class="bi ${group.icon}"></i> ${group.label}`;
            groupEl.appendChild(labelEl);

            const rowEl = document.createElement('div');
            rowEl.className = 'slot-group-row';

            group.hours.forEach(hour => {
                const taken = bookedHours.includes(hour);
                const isSelected = hour === currentHour;
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.dataset.hour = hour;

                if (taken) {
                    btn.className = 'slot-btn slot-btn--taken';
                    btn.disabled = true;
                } else if (isSelected) {
                    btn.className = 'slot-btn slot-btn--selected';
                } else {
                    btn.className = 'slot-btn slot-btn--free';
                }

                btn.innerHTML = `<span class="slot-time">${String(hour).padStart(2,'0')}:00</span>`;
                if (taken) btn.innerHTML += `<span class="slot-taken-label">Zauzeto</span>`;

                if (!taken) btn.addEventListener('click', () => selectSlot(hour, btn));
                rowEl.appendChild(btn);
            });

            groupEl.appendChild(rowEl);
            slotsContainer.appendChild(groupEl);
        });

        if (allTaken) {
            slotsContainer.innerHTML = '<p style="color:var(--text-muted);font-size:.875rem;padding:.75rem 0"><i class="bi bi-calendar-x me-2"></i>Svi termini za ovaj dan su zauzeti. Odaberi drugi datum.</p>';
        }
    }

    function selectSlot(hour, btn) {
        document.querySelectorAll('.slot-btn--selected').forEach(b => b.classList.replace('slot-btn--selected', 'slot-btn--free'));
        btn.classList.replace('slot-btn--free', 'slot-btn--selected');
        currentHour       = hour;
        hiddenHour.value  = hour;
        bookBtn.disabled  = false;
        updateSummary();

        const hStr = String(hour).padStart(2,'0') + ':00h';
        slotStepSub.textContent = '— ' + hStr;
    }

    // ── Summary ────────────────────────────────────
    function updateSummary() {
        if (selectedDate && currentHour !== null) {
            const parts = selectedDate.split('-');
            const d = new Date(+parts[0], +parts[1]-1, +parts[2]);
            const label = `${DAYS_SR_FULL[d.getDay()]}, ${d.getDate()}. ${MONTHS_GEN[d.getMonth()]} u ${String(currentHour).padStart(2,'0')}:00h`;
            summaryDateTime.textContent = label;
            bookingSummary.classList.remove('booking-summary--hidden');
        } else {
            bookingSummary.classList.add('booking-summary--hidden');
        }
    }

    // ── Init ───────────────────────────────────────
    renderCalendar();
    loadSlots(selectedDate);
    if (currentHour !== null) { bookBtn.disabled = false; updateSummary(); }
})();
</script>
@endif
@endpush

@endsection
