@extends('layouts.admin')

@section('title', 'Treneri')
@section('page-title', 'Treneri')

@section('content')

<div class="admin-card-header mb-4" style="padding:0">
    <h2 class="admin-page-title">Svi treneri</h2>
    <a href="{{ route('admin.trainers.create') }}" class="btn btn-success btn-sm px-3">
        <i class="bi bi-plus-lg me-1"></i> Dodaj trenera
    </a>
</div>

<div class="admin-card">
    @if($trainers->isEmpty())
        <p class="admin-empty">Nema trenera. <a href="{{ route('admin.trainers.create') }}">Dodaj prvog.</a></p>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Ime</th>
                    <th>Specijalnost</th>
                    <th>Cena / termin</th>
                    <th>Status</th>
                    <th>Zakazivanja</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trainers as $trainer)
                    <tr>
                        <td>
                            <div class="admin-trainer-avatar" style="background: {{ $trainer->avatar_gradient }}">
                                {{ $trainer->avatar_initials }}
                            </div>
                        </td>
                        <td style="color: var(--text-light); font-weight: 600">{{ $trainer->name }}</td>
                        <td>{{ $trainer->specialty }}</td>
                        <td style="color:var(--accent);font-weight:600">
                            {{ number_format($trainer->session_price, 0, ',', '.') }} RSD
                        </td>
                        <td>
                            @if($trainer->is_active)
                                <span class="history-badge history-badge--active">Aktivan</span>
                            @else
                                <span class="history-badge history-badge--expired">Neaktivan</span>
                            @endif
                        </td>
                        <td>{{ $trainer->sessions()->count() }}</td>
                        <td>
                            <div class="admin-actions">
                                <a href="{{ route('admin.trainers.edit', $trainer) }}" class="admin-btn-icon" title="Izmeni">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('admin.trainers.destroy', $trainer) }}" method="POST"
                                      onsubmit="return confirm('Sigurno zelis da obrises ovog trenera?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="admin-btn-icon admin-btn-icon--danger" title="Obrisi">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
