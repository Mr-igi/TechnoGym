@extends('layouts.admin')

@section('title', 'Clanarine')
@section('page-title', 'Clanarine')

@section('content')

<div class="admin-card-header mb-4" style="padding:0">
    <h2 class="admin-page-title">Svi planovi clanarine</h2>
    <a href="{{ route('admin.memberships.create') }}" class="btn btn-accent btn-sm px-3">
        <i class="bi bi-plus-lg me-1"></i> Dodaj plan
    </a>
</div>

<div class="admin-card">
    @if($plans->isEmpty())
        <p class="admin-empty">Nema planova. <a href="{{ route('admin.memberships.create') }}">Dodaj prvi.</a></p>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Red</th>
                    <th>Slug</th>
                    <th>Naziv</th>
                    <th>Cena</th>
                    <th>Benefiti</th>
                    <th>Popularno</th>
                    <th>Status</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plans as $plan)
                <tr>
                    <td style="color:var(--text-muted); font-size:0.85rem">{{ $plan->sort_order }}</td>
                    <td style="color:var(--text-muted); font-size:0.8rem; font-family:monospace">{{ $plan->slug }}</td>
                    <td style="color:var(--text-light); font-weight:600">{{ $plan->name }}</td>
                    <td style="color:var(--accent); font-weight:600">{{ number_format($plan->price, 0, ',', '.') }} RSD</td>
                    <td>
                        <span style="color:var(--text-muted); font-size:0.8rem">
                            {{ count($plan->features ?? []) }} ukljucenih,
                            {{ count($plan->features_off ?? []) }} iskljucenih
                        </span>
                    </td>
                    <td>
                        @if($plan->is_featured)
                            <span class="history-badge history-badge--active">Da</span>
                        @else
                            <span style="color:var(--text-muted); font-size:0.8rem">—</span>
                        @endif
                    </td>
                    <td>
                        @if($plan->is_active)
                            <span class="history-badge history-badge--active">Aktivan</span>
                        @else
                            <span class="history-badge history-badge--expired">Neaktivan</span>
                        @endif
                    </td>
                    <td>
                        <div class="admin-actions">
                            <a href="{{ route('admin.memberships.edit', $plan) }}" class="admin-btn-icon" title="Izmeni">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="{{ route('admin.memberships.destroy', $plan) }}" method="POST"
                                  onsubmit="return confirm('Sigurno zelis da obrises ovaj plan?')">
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
