@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- Page header --}}
<div style="margin-bottom:1.375rem;">
    <h1 class="page-title">Dobrodošli, {{ Auth::user()->name }}</h1>
    <p class="page-sub">Pregled stanja biblioteke u realnom vremenu.</p>
</div>

{{-- Stat cards --}}
<div class="grid-stats">

    <div class="stat-card">
        <div class="stat-card-icon blue"><i class="bi bi-journals"></i></div>
        <div class="stat-value num">{{ $totalBooks }}</div>
        <div class="stat-label">Ukupno knjiga</div>
        <svg class="stat-spark" width="80" height="36" viewBox="0 0 80 36" fill="none">
            <path d="M0 28 L12 22 L24 25 L36 18 L48 20 L60 12 L72 15 L80 8" stroke="rgba(79,110,247,0.3)" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon green"><i class="bi bi-bookmark"></i></div>
        <div class="stat-value num">{{ $totalCategories }}</div>
        <div class="stat-label">Kategorije</div>
        <svg class="stat-spark" width="80" height="36" viewBox="0 0 80 36" fill="none">
            <path d="M0 30 L16 26 L32 28 L48 22 L64 20 L80 16" stroke="rgba(29,170,110,0.3)" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon amber"><i class="bi bi-clock-history"></i></div>
        <div class="stat-value num">{{ $activeBorrowings }}</div>
        <div class="stat-label">Aktivne pozajmice</div>
        <svg class="stat-spark" width="80" height="36" viewBox="0 0 80 36" fill="none">
            <path d="M0 24 L10 20 L20 26 L30 16 L40 18 L50 12 L62 16 L72 10 L80 14" stroke="rgba(217,119,6,0.3)" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon red"><i class="bi bi-exclamation-triangle"></i></div>
        <div class="stat-value num" style="color:var(--danger);">{{ $overdueBorrowings }}</div>
        <div class="stat-label">Kasne pozajmice</div>
        <svg class="stat-spark" width="80" height="36" viewBox="0 0 80 36" fill="none">
            <path d="M0 30 L14 28 L28 24 L42 20 L56 16 L70 10 L80 6" stroke="rgba(229,66,75,0.3)" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

</div>

{{-- Recent borrowings table --}}
<div class="card">
    <div class="card-head">
        <div>
            <div class="card-head-title">Pozajmice po roku vraćanja</div>
            <div style="font-size:.72rem;color:var(--ink-4);margin-top:.15rem;">Aktivne, sortirane po datumu isteka</div>
        </div>
        <a href="{{ route('admin.borrowings.index') }}" class="btn btn-sm btn-outline-primary">
            Sve aktivne <i class="bi bi-arrow-right" style="font-size:.65rem;"></i>
        </a>
    </div>

    @if($recentBorrowings->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon" style="background:var(--success-soft);">
                <i class="bi bi-check-circle" style="color:var(--success);"></i>
            </div>
            <p class="fw-semibold mb-1" style="font-size:.875rem;color:var(--ink-1);">Sve je pod kontrolom</p>
            <p style="color:var(--ink-4);font-size:.78rem;margin:0;">Nema aktivnih pozajmica.</p>
        </div>
    @else
    <div class="table-responsive">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Knjiga</th>
                    <th>Čitalac</th>
                    <th>Rok vraćanja</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentBorrowings as $b)
                @php
                    $initials = collect(explode(' ', $b->borrower_name))->take(2)->map(fn($w) => strtoupper($w[0]))->join('');
                @endphp
                <tr class="{{ $b->isOverdue() ? 'tbl-danger' : '' }}">
                    <td>
                        <span class="fw-semibold" style="color:var(--ink-1);">{{ $b->book->title }}</span>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:.55rem;">
                            <div class="borrower-av">{{ $initials }}</div>
                            <span style="font-size:.8rem;">{{ $b->borrower_name }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="num" style="font-size:.8rem;font-weight:{{ $b->isOverdue() ? '700' : '500' }};color:{{ $b->isOverdue() ? 'var(--danger)' : 'var(--ink-3)' }};">
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
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

@endsection
