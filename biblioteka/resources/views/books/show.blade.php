@extends('layouts.admin')

@section('title', $book->title)

@section('content')

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
    $cover = $covers[$book->id % count($covers)];
    $words = explode(' ', $book->title);
    $initials = strtoupper(substr($words[0], 0, 1)) . (isset($words[1]) ? strtoupper(substr($words[1], 0, 1)) : '');
    $pct = $book->total_copies > 0 ? round(($book->available_copies / $book->total_copies) * 100) : 0;
    $progClass = $pct === 0 ? 'full' : ($pct < 50 ? 'half' : '');
@endphp

<div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.375rem;">
    <a href="{{ route('admin.books.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h2 class="page-title">{{ $book->title }}</h2>
        <p class="page-sub">Detalji knjige</p>
    </div>
</div>

<div class="row g-4">

    {{-- Book info card --}}
    <div class="col-lg-4">
        <div class="card h-100">
            @if($book->imageUrl())
                <img src="{{ $book->imageUrl() }}" alt="{{ $book->title }}"
                    class="card-img-top"
                    style="height:240px;object-fit:cover;border-radius:var(--r-lg) var(--r-lg) 0 0;">
            @else
                <div style="height:200px;background:linear-gradient(135deg, {{ $cover['from'] }}, {{ $cover['to'] }});border-radius:var(--r-lg) var(--r-lg) 0 0;display:flex;align-items:center;justify-content:center;">
                    <span style="font-size:4rem;font-weight:800;color:rgba(255,255,255,0.7);letter-spacing:-.05em;">{{ $initials }}</span>
                </div>
            @endif

            <div class="card-body" style="padding:1.25rem;">
                <div style="font-size:.65rem;font-weight:700;color:var(--ink-4);text-transform:uppercase;letter-spacing:.1em;margin-bottom:.875rem;">
                    Podaci o knjizi
                </div>

                <div style="display:grid;gap:.625rem;">
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:.5rem;">
                        <span style="font-size:.74rem;color:var(--ink-4);">Naslov</span>
                        <span style="font-size:.8rem;font-weight:600;color:var(--ink-1);text-align:right;max-width:60%;">{{ $book->title }}</span>
                    </div>
                    <div style="height:1px;background:var(--line-2);"></div>
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:.5rem;">
                        <span style="font-size:.74rem;color:var(--ink-4);">Autor</span>
                        <span style="font-size:.8rem;color:var(--ink-2);">{{ $book->author }}</span>
                    </div>
                    <div style="height:1px;background:var(--line-2);"></div>
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:.5rem;">
                        <span style="font-size:.74rem;color:var(--ink-4);">Kategorija</span>
                        <span class="cat-pill">{{ $book->category->name }}</span>
                    </div>
                    <div style="height:1px;background:var(--line-2);"></div>
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:.5rem;">
                        <span style="font-size:.74rem;color:var(--ink-4);">Ukupno</span>
                        <span class="num" style="font-size:.9rem;font-weight:700;color:var(--ink-1);">{{ $book->total_copies }}</span>
                    </div>
                    <div style="height:1px;background:var(--line-2);"></div>
                    <div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.4rem;">
                            <span style="font-size:.74rem;color:var(--ink-4);">Dostupnost</span>
                            <span class="num" style="font-size:.78rem;font-weight:600;color:{{ $book->available_copies > 0 ? 'var(--success)' : 'var(--danger)' }};">
                                {{ $book->available_copies }}/{{ $book->total_copies }}
                            </span>
                        </div>
                        <div class="prog-wrap">
                            <div class="prog-bar {{ $progClass }}" style="width:{{ $pct }}%;"></div>
                        </div>
                    </div>
                </div>

                <div style="display:flex;gap:.5rem;margin-top:1.125rem;padding-top:.875rem;border-top:1px solid var(--line-1);">
                    <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-outline-warning">
                        <i class="bi bi-pencil"></i>Izmeni
                    </a>
                    @if($book->available_copies > 0)
                    <a href="{{ route('admin.borrowings.create') }}?book_id={{ $book->id }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus"></i>Pozajmi
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Borrowing history --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-head">
                <div class="card-head-title">
                    <i class="bi bi-clock-history" style="color:var(--primary);margin-right:.4rem;"></i>Istorija pozajmica
                </div>
            </div>
            @if($borrowings->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon" style="background:rgba(15,18,40,0.05);">
                        <i class="bi bi-inbox" style="color:var(--ink-4);"></i>
                    </div>
                    <p style="font-size:.875rem;color:var(--ink-1);font-weight:600;margin-bottom:.25rem;">Nema pozajmica</p>
                    <p style="font-size:.78rem;color:var(--ink-4);margin:0;">Knjiga još nije bila pozajmljena.</p>
                </div>
            @else
            <div class="table-responsive">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Čitalac</th>
                            <th>Uzeto</th>
                            <th>Rok vraćanja</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrowings as $b)
                        @php
                            $pInitials = collect(explode(' ', $b->borrower_name))->take(2)->map(fn($w) => strtoupper($w[0]))->join('');
                        @endphp
                        <tr class="{{ $b->isOverdue() ? 'tbl-danger' : '' }}">
                            <td>
                                <div style="display:flex;align-items:center;gap:.55rem;">
                                    <div class="borrower-av">{{ $pInitials }}</div>
                                    <span style="font-size:.8rem;font-weight:500;">{{ $b->borrower_name }}</span>
                                </div>
                            </td>
                            <td><span class="num" style="font-size:.78rem;color:var(--ink-4);">{{ $b->borrowed_at->format('d.m.Y') }}</span></td>
                            <td><span class="num" style="font-size:.78rem;color:{{ $b->isOverdue() ? 'var(--danger)' : 'var(--ink-3)' }};font-weight:{{ $b->isOverdue() ? '700' : '400' }};">{{ $b->due_date->format('d.m.Y') }}</span></td>
                            <td>
                                @if($b->returned_at)
                                    <span class="badge bg-secondary">
                                        <span class="dot" style="background:var(--ink-4);"></span>
                                        {{ $b->returned_at->format('d.m.Y') }}
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
            <div style="padding:.75rem 1rem;border-top:1px solid var(--line-1);">
                {{ $borrowings->links() }}
            </div>
            @endif
        </div>
    </div>

</div>

@endsection
