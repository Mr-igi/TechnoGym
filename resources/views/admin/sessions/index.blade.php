@extends('layouts.admin')

@section('title', 'Zakazivanja')
@section('page-title', 'Zakazivanja')

@section('content')

<div class="admin-card-header mb-4" style="padding:0">
    <h2 class="admin-page-title">Sva zakazivanja</h2>
    <div class="d-flex gap-2">
        @foreach([''=>'Svi', 'pending'=>'Na cekanju', 'confirmed'=>'Potvrdjena', 'cancelled'=>'Otkazana'] as $val => $label)
            <a href="{{ route('admin.sessions.index', $val ? ['status'=>$val] : []) }}"
               class="btn btn-sm {{ request('status') === $val || (request('status') === null && $val === '') ? 'btn-accent' : 'btn-ghost' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
</div>

<div class="admin-card">
    @if($sessions->isEmpty())
        <p class="admin-empty">Nema zakazivanja.</p>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Korisnik</th>
                    <th>Trener</th>
                    <th>Datum i vreme</th>
                    <th>Napomena</th>
                    <th>Status</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sessions as $session)
                    <tr>
                        <td style="color:var(--text-light);font-weight:600">{{ $session->user->name }}</td>
                        <td>{{ $session->trainer->name }}</td>
                        <td>{{ $session->scheduled_at->format('d.m.Y, H:i') }}h</td>
                        <td style="color:var(--text-muted);font-size:0.82rem;max-width:180px">
                            {{ $session->notes ? Str::limit($session->notes, 60) : '—' }}
                        </td>
                        <td>
                            <span class="history-badge {{ $session->statusClass() }}">{{ $session->statusLabel() }}</span>
                        </td>
                        <td>
                            <form action="{{ route('admin.sessions.status', $session) }}" method="POST"
                                  class="d-flex gap-1">
                                @csrf @method('PATCH')
                                @if($session->status !== 'confirmed')
                                    <button name="status" value="confirmed" class="admin-btn-sm admin-btn-sm--green" title="Potvrdi">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                @endif
                                @if($session->status !== 'cancelled')
                                    <button name="status" value="cancelled" class="admin-btn-sm admin-btn-sm--red" title="Otkazi"
                                            onclick="return confirm('Otkazi ovaj trening?')">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                @endif
                                @if($session->status !== 'pending')
                                    <button name="status" value="pending" class="admin-btn-sm" title="Vrati na cekanje">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">{{ $sessions->links() }}</div>
    @endif
</div>

@endsection
