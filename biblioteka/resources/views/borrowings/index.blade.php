@extends('layouts.admin')

@section('title', 'Aktivne pozajmice')

@section('content')

<div class="page-head" style="flex-wrap:wrap;gap:.75rem;">
    <div>
        <h2 class="page-title">Pozajmice</h2>
        <p class="page-sub">Knjige koje su trenutno van biblioteke</p>
    </div>
    <a href="{{ route('admin.borrowings.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i>Nova pozajmica
    </a>
</div>

{{-- Tab navigation --}}
<div style="margin-bottom:1.125rem;">
    <div class="segctl">
        <a href="{{ route('admin.borrowings.index') }}" class="segctl-item active">
            <i class="bi bi-clock" style="font-size:.8rem;"></i>
            Aktivne
            @if($borrowings->total() > 0)
                <span class="seg-count">{{ $borrowings->total() }}</span>
            @endif
        </a>
        <a href="{{ route('admin.borrowings.overdue') }}" class="segctl-item">
            <i class="bi bi-exclamation-triangle" style="font-size:.8rem;"></i>
            Kasne
        </a>
        <a href="{{ route('admin.borrowings.all') }}" class="segctl-item">
            <i class="bi bi-list-ul" style="font-size:.8rem;"></i>
            Istorija
        </a>
    </div>
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

<div class="card">
    @if($borrowings->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon" style="background:var(--success-soft);">
                <i class="bi bi-check-circle" style="color:var(--success);"></i>
            </div>
            <p style="font-size:.875rem;color:var(--ink-1);font-weight:600;margin-bottom:.25rem;">Nema aktivnih pozajmica</p>
            <p style="font-size:.78rem;color:var(--ink-4);margin:0;">Sve knjige su na svom mestu.</p>
        </div>
    @else
    <div class="table-responsive">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Knjiga</th>
                    <th>Čitalac</th>
                    <th>Uzeto</th>
                    <th>Rok vraćanja</th>
                    <th>Status</th>
                    <th style="text-align:right;">Akcija</th>
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
                                <div style="font-size:.72rem;color:var(--ink-4);">{{ $b->book->author }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:.55rem;">
                            <div class="borrower-av">{{ $pInitials }}</div>
                            <span style="font-size:.8rem;font-weight:500;color:var(--ink-1);">{{ $b->borrower_name }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="num" style="font-size:.78rem;color:var(--ink-4);">{{ $b->borrowed_at->format('d.m.Y') }}</span>
                    </td>
                    <td>
                        <span class="num" style="font-size:.8rem;font-weight:{{ $b->isOverdue() ? '700' : '500' }};color:{{ $b->isOverdue() ? 'var(--danger)' : 'var(--ink-2)' }};">
                            {{ $b->due_date->format('d.m.Y') }}
                        </span>
                    </td>
                    <td>
                        @if($b->isOverdue())
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
                    <td style="text-align:right;">
                        <form method="POST" action="{{ route('admin.borrowings.return', $b) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-success"
                                    onclick="return confirm('Označiti knjigu kao vraćenu?');">
                                <i class="bi bi-check-lg"></i>Vraćeno
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="padding:.75rem 1rem;display:flex;align-items:center;justify-content:space-between;border-top:1px solid var(--line-1);">
        <span style="font-size:.75rem;color:var(--ink-4);">
            <span class="num">{{ $borrowings->total() }}</span> aktivnih pozajmica
        </span>
        {{ $borrowings->links() }}
    </div>
    @endif
</div>

@endsection
