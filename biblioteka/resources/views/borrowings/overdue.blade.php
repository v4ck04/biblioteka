@extends('layouts.admin')

@section('title', 'Kasne pozajmice')

@section('content')

<div class="page-head" style="flex-wrap:wrap;gap:.75rem;">
    <div>
        <h2 class="page-title" style="color:var(--danger);">
            <i class="bi bi-exclamation-triangle" style="font-size:1.1rem;margin-right:.4rem;"></i>Kasne pozajmice
        </h2>
        <p class="page-sub">Knjige kojima je prošao rok vraćanja</p>
    </div>
    @if(!$borrowings->isEmpty())
        <span class="badge bg-danger" style="font-size:.75rem!important;padding:.4em .8em!important;align-self:center;">
            <span class="dot" style="background:var(--danger);"></span>
            {{ $borrowings->total() }} kasnih
        </span>
    @endif
</div>

{{-- Tab navigation --}}
<div style="margin-bottom:1.125rem;">
    <div class="segctl">
        <a href="{{ route('admin.borrowings.index') }}" class="segctl-item">
            <i class="bi bi-clock" style="font-size:.8rem;"></i>
            Aktivne
        </a>
        <a href="{{ route('admin.borrowings.overdue') }}" class="segctl-item active">
            <i class="bi bi-exclamation-triangle" style="font-size:.8rem;"></i>
            Kasne
            @if(!$borrowings->isEmpty())
                <span class="seg-count" style="background:var(--danger-soft);color:var(--danger-ink);">{{ $borrowings->total() }}</span>
            @endif
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

<div class="card" style="border-color:rgba(229,66,75,0.18)!important;">
    @if($borrowings->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon" style="background:var(--success-soft);">
                <i class="bi bi-patch-check" style="color:var(--success);"></i>
            </div>
            <p style="font-size:.9rem;font-weight:700;color:var(--ink-1);margin-bottom:.25rem;">Odlično!</p>
            <p style="font-size:.78rem;color:var(--ink-4);margin:0;">Nema kasnih pozajmica.</p>
        </div>
    @else
    <div class="table-responsive">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Knjiga</th>
                    <th>Čitalac</th>
                    <th>Datum uzimanja</th>
                    <th>Rok vraćanja</th>
                    <th>Kašnjenje</th>
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
                <tr class="tbl-danger">
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
                                   style="color:var(--danger-ink);font-size:.8rem;">
                                    {{ $b->book->title }}
                                </a>
                                <div style="font-size:.72rem;color:var(--ink-4);">{{ $b->book->author }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:.55rem;">
                            <div class="borrower-av" style="background:linear-gradient(135deg,var(--danger),#f87171);">{{ $pInitials }}</div>
                            <span style="font-size:.8rem;font-weight:600;color:var(--danger-ink);">{{ $b->borrower_name }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="num" style="font-size:.78rem;color:var(--ink-4);">{{ $b->borrowed_at->format('d.m.Y') }}</span>
                    </td>
                    <td>
                        <span class="num" style="font-size:.8rem;font-weight:700;color:var(--danger);">{{ $b->due_date->format('d.m.Y') }}</span>
                    </td>
                    <td>
                        <span class="badge bg-danger">
                            <span class="dot" style="background:var(--danger);"></span>
                            {{ pluralizeDan($b->overdueDays()) }}
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <form method="POST" action="{{ route('admin.borrowings.return', $b) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success"
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
    <div style="padding:.75rem 1rem;border-top:1px solid rgba(229,66,75,0.12);">
        {{ $borrowings->links() }}
    </div>
    @endif
</div>

@endsection
