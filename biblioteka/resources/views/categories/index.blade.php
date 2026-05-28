@extends('layouts.admin')

@section('title', 'Kategorije')

@section('content')

<div class="page-head">
    <div>
        <h2 class="page-title">Kategorije</h2>
        <p class="page-sub">Upravljanje kategorijama knjiga</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i>Dodaj kategoriju
    </a>
</div>

<div class="card">
    @if($categories->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon" style="background:var(--primary-dim);">
                <i class="bi bi-bookmark" style="color:var(--primary);"></i>
            </div>
            <p style="font-size:.875rem;color:var(--ink-1);font-weight:600;margin-bottom:.25rem;">Nema kategorija</p>
            <p style="font-size:.78rem;color:var(--ink-4);margin:0;">Dodajte prvu kategoriju knjiga.</p>
        </div>
    @else
    <div class="table-responsive">
        <table class="tbl">
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Naziv kategorije</th>
                    <th style="text-align:center;">Broj knjiga</th>
                    <th style="text-align:right;">Akcije</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                <tr>
                    <td><span class="num" style="font-size:.75rem;color:var(--ink-4);font-weight:600;">{{ $cat->id }}</span></td>
                    <td><span style="font-weight:600;color:var(--ink-1);">{{ $cat->name }}</span></td>
                    <td style="text-align:center;">
                        <span class="badge bg-primary">
                            <span class="dot" style="background:var(--primary);"></span>
                            {{ $cat->books_count }}
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <div style="display:flex;gap:4px;justify-content:flex-end;">
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-outline-warning" title="Izmeni">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" class="d-inline"
                                  onsubmit="return confirm('Obrisati kategoriju {{ addslashes($cat->name) }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Obriši">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="padding:.75rem 1rem;display:flex;align-items:center;justify-content:space-between;border-top:1px solid var(--line-1);">
        <span style="font-size:.75rem;color:var(--ink-4);">
            <span class="num">{{ $categories->total() }}</span> kategorija ukupno
        </span>
        {{ $categories->links() }}
    </div>
    @endif
</div>

@endsection
