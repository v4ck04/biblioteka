@extends('layouts.admin')

@section('title', 'Istorija pozajmica')

@section('content')

<div class="page-head" style="flex-wrap:wrap;gap:.75rem;">
    <div>
        <h2 class="page-title">Istorija pozajmica</h2>
        <p class="page-sub">Kompletna evidencija svih pozajmica</p>
    </div>
    <a href="{{ route('admin.borrowings.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i>Nova pozajmica
    </a>
</div>

{{-- Tab navigation --}}
<div style="margin-bottom:1.125rem;">
    <div class="segctl">
        <a href="{{ route('admin.borrowings.index') }}" class="segctl-item">
            <i class="bi bi-clock" style="font-size:.8rem;"></i>
            Aktivne
        </a>
        <a href="{{ route('admin.borrowings.overdue') }}" class="segctl-item">
            <i class="bi bi-exclamation-triangle" style="font-size:.8rem;"></i>
            Kasne
        </a>
        <a href="{{ route('admin.borrowings.all') }}" class="segctl-item active">
            <i class="bi bi-list-ul" style="font-size:.8rem;"></i>
            Istorija
        </a>
    </div>
</div>

{{-- Filters --}}
<div class="card mb-4" style="padding:1rem 1.25rem;">
    <form method="GET" action="{{ route('admin.borrowings.all') }}">
        <div style="display:flex;gap:.75rem;align-items:flex-end;flex-wrap:wrap;">
            <div style="flex:2;min-width:160px;">
                <label class="form-label">Knjiga</label>
                <select name="book_id" class="form-select">
                    <option value="">Sve knjige</option>
                    @foreach($books as $bk)
                        <option value="{{ $bk->id }}" {{ request('book_id') == $bk->id ? 'selected' : '' }}>
                            {{ $bk->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="flex:1;min-width:120px;">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Svi</option>
                    <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Aktivne</option>
                    <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Vraćene</option>
                </select>
            </div>
            <div style="flex:1;min-width:130px;">
                <label class="form-label">Od datuma</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div style="flex:1;min-width:130px;">
                <label class="form-label">Do datuma</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div style="display:flex;gap:.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel"></i>Filter
                </button>
                <a href="{{ route('admin.borrowings.all') }}" class="btn btn-outline-secondary" title="Resetuj">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </div>
    </form>
</div>

@php
    $covers = [
        ['from'=>'#4f6ef7','to'=>'#818cf8'],
        ['from'=>'#1daa6e','to'=>'#34d399'],
        ['from'=>'#d97706','to'=>'#fbbf24'],
        ['from'=>'#e5424b','to'=>'#f87171'],
        ['from'=>'#2e82d4','to'=>'#60a5fa'],
        ['from'=>'#7c3aed','to'=>'#a78bfa'],
        ['from'=>'#0891b2','to'=>'#67e8f9'],
        ['from'=>'#be185d','to'=>'#f472b6'],
    ];
@endphp

{{-- Table --}}
<div class="card">
    @if($borrowings->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon" style="background:rgba(15,18,40,0.05);">
                <i class="bi bi-search" style="color:var(--ink-4);"></i>
            </div>
            <p style="font-size:.875rem;color:var(--ink-1);font-weight:600;margin-bottom:.25rem;">Nema pronađenih pozajmica</p>
            <p style="font-size:.78rem;color:var(--ink-4);margin:0;">Pokušajte drugačiji filter.</p>
        </div>
    @else
    <div class="table-responsive">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Knjiga</th>
                    <th>Kategorija</th>
                    <th>Čitalac</th>
                    <th>Uzeto</th>
                    <th>Rok</th>
                    <th>Vraćeno</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($borrowings as $b)
                @php
                    $cover = $covers[$b->book->id % count($covers)];
                    $bWords = explode(' ', $b->book->title);
                    $bInitials = strtoupper(substr($bWords[0], 0, 1)) . (isset($bWords[1]) ? strtoupper(substr($bWords[1], 0, 1)) : '');
                    $pInitials = collect(explode(' ', $b->borrower_name))->take(2)->map(fn($w) => strtoupper($w[0]))->join('');
                @endphp
                <tr class="{{ $b->isOverdue() ? 'tbl-danger' : '' }}">
                    <td>
                        <div style="display:flex;align-items:center;gap:.65rem;">
                            @if($b->book->imageUrl())
                                <img src="{{ $b->book->imageUrl() }}" alt="{{ $b->book->title }}"
                                     style="width:36px;height:48px;object-fit:cover;border-radius:5px;box-shadow:0 2px 6px rgba(15,18,40,0.12);flex-shrink:0;">
                            @else
                                <div class="book-cover" style="background:linear-gradient(135deg, {{ $cover['from'] }}, {{ $cover['to'] }});flex-shrink:0;">
                                    {{ $bInitials }}
                                </div>
                            @endif
                            <div>
                                <a href="{{ route('admin.books.show', $b->book) }}" class="text-decoration-none fw-semibold"
                                   style="color:var(--ink-1);font-size:.8rem;">
                                    {{ $b->book->title }}
                                </a>
                            </div>
                        </div>
                    </td>
                    <td><span class="cat-pill">{{ $b->book->category->name }}</span></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:.5rem;">
                            <div class="borrower-av">{{ $pInitials }}</div>
                            <span style="font-size:.8rem;">{{ $b->borrower_name }}</span>
                        </div>
                    </td>
                    <td><span class="num" style="font-size:.78rem;color:var(--ink-4);">{{ $b->borrowed_at->format('d.m.Y') }}</span></td>
                    <td><span class="num" style="font-size:.78rem;color:var(--ink-3);">{{ $b->due_date->format('d.m.Y') }}</span></td>
                    <td>
                        @if($b->returned_at)
                            <span class="num" style="font-size:.78rem;color:var(--success);">{{ $b->returned_at->format('d.m.Y') }}</span>
                        @else
                            <span style="color:var(--ink-4);font-size:.78rem;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($b->returned_at)
                            <span class="badge bg-secondary">
                                <span class="dot" style="background:var(--ink-4);"></span>
                                Vraćeno
                            </span>
                        @elseif($b->isOverdue())
                            <span class="badge bg-danger">
                                <span class="dot" style="background:var(--danger);"></span>
                                Kasni {{ pluralizeDan($b->overdueDays()) }}
                            </span>
                        @else
                            <span class="badge bg-success">
                                <span class="dot" style="background:var(--success);"></span>
                                Aktivna
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="padding:.75rem 1rem;display:flex;align-items:center;justify-content:space-between;border-top:1px solid var(--line-1);">
        <span style="font-size:.75rem;color:var(--ink-4);">
            Prikazano {{ $borrowings->firstItem() }}–{{ $borrowings->lastItem() }} od <span class="num">{{ $borrowings->total() }}</span>
        </span>
        {{ $borrowings->links() }}
    </div>
    @endif
</div>

@endsection
