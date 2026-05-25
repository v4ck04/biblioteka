@extends('layouts.frontend')

@section('title', 'Katalog knjiga')

@section('content')

{{-- ══════════════ PAGE HEADER ══════════════ --}}
<div style="background: linear-gradient(135deg, #0a2342, #1565c0);" class="py-4 mb-5">
    <div class="container text-white py-2">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider-color: rgba(255,255,255,.5);">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Početna</a>
                </li>
                <li class="breadcrumb-item active text-white">Knjige</li>
            </ol>
        </nav>
        <h1 class="fw-bold mb-1">Katalog knjiga</h1>
        <p class="mb-0 opacity-75">Pronađi svoju sledeću omiljenu knjigu</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">

        {{-- ══════ SIDEBAR FILTERS ══════ --}}
        <div class="col-lg-3">
            <div class="card filter-card shadow-sm sticky-top" style="top: 80px;">
                <div class="card-header bg-transparent fw-semibold border-0 pb-0 pt-3">
                    <i class="bi bi-funnel me-2 text-primary"></i>Filteri
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('books.index') }}" id="filterForm">

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted text-uppercase"
                                   style="font-size: .7rem; letter-spacing: .07em;">Pretraga</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0 bg-transparent">
                                    <i class="bi bi-search text-muted small"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-start-0 ps-0"
                                       placeholder="Naslov ili autor..."
                                       value="{{ request('search') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted text-uppercase"
                                   style="font-size: .7rem; letter-spacing: .07em;">Kategorija</label>
                            <select name="category_id" class="form-select form-select-sm">
                                <option value="">Sve kategorije</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase"
                                   style="font-size: .7rem; letter-spacing: .07em;">Dostupnost</label>
                            <div class="d-flex flex-column gap-2">
                                @foreach(['' => 'Sve knjige', 'available' => 'Dostupne', 'unavailable' => 'Pozajmljene'] as $val => $label)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="availability"
                                           id="avail_{{ $val ?: 'all' }}" value="{{ $val }}"
                                           {{ request('availability', '') === $val ? 'checked' : '' }}
                                           onchange="document.getElementById('filterForm').submit()">
                                    <label class="form-check-label small" for="avail_{{ $val ?: 'all' }}">
                                        {{ $label }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-search me-1"></i>Primeni filtere
                            </button>
                            @if(request()->hasAny(['search', 'category_id', 'availability']))
                            <a href="{{ route('books.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-x-lg me-1"></i>Poništi
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ══════ BOOKS GRID ══════ --}}
        <div class="col-lg-9">

            {{-- Result count & active filters --}}
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                <div>
                    <span class="fw-semibold">{{ $books->total() }}</span>
                    <span class="text-muted"> {{ $books->total() == 1 ? 'knjiga pronađena' : 'knjiga pronađeno' }}</span>

                    @if(request('search'))
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle ms-2">
                            <i class="bi bi-search me-1"></i>{{ request('search') }}
                        </span>
                    @endif
                    @if(request('category_id'))
                        @php $activeCat = $categories->firstWhere('id', request('category_id')); @endphp
                        @if($activeCat)
                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle ms-2">
                            <i class="bi bi-tag me-1"></i>{{ $activeCat->name }}
                        </span>
                        @endif
                    @endif
                    @if(request('availability') === 'available')
                        <span class="badge bg-success-subtle text-success border border-success-subtle ms-2">
                            <i class="bi bi-check-circle me-1"></i>Dostupne
                        </span>
                    @elseif(request('availability') === 'unavailable')
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle ms-2">
                            <i class="bi bi-x-circle me-1"></i>Pozajmljene
                        </span>
                    @endif
                </div>
            </div>

            @if($books->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-search display-1 text-muted d-block mb-3"></i>
                    <h4 class="fw-semibold">Nema rezultata</h4>
                    <p class="text-muted">Pokušaj sa drugačijim filterima ili <a href="{{ route('books.index') }}">prikaži sve knjige</a>.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach($books as $book)
                    <div class="col-sm-6 col-xl-4">
                        <a href="{{ route('books.show', $book) }}" class="text-decoration-none">
                            <div class="card book-card shadow-sm rounded-3 overflow-hidden h-100">
                                @if($book->imageUrl())
                                    <img src="{{ $book->imageUrl() }}" alt="{{ $book->title }}" class="book-cover">
                                @else
                                    <div class="book-cover-placeholder">
                                        <i class="bi bi-book"></i>
                                    </div>
                                @endif
                                <div class="card-body p-3 d-flex flex-column">
                                    <h6 class="card-title fw-semibold mb-1" style="line-height: 1.3;">
                                        {{ $book->title }}
                                    </h6>
                                    <p class="text-muted small mb-3">
                                        <i class="bi bi-person me-1"></i>{{ $book->author }}
                                    </p>
                                    <div class="mt-auto d-flex align-items-center justify-content-between flex-wrap gap-1">
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle"
                                              style="font-size: .7rem;">
                                            <i class="bi bi-tag me-1"></i>{{ $book->category->name }}
                                        </span>
                                        @if($book->available_copies > 0)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle"
                                                  style="font-size: .7rem;">
                                                <i class="bi bi-check-circle me-1"></i>Dostupna
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle"
                                                  style="font-size: .7rem;">
                                                <i class="bi bi-x-circle me-1"></i>Pozajmljena
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($books->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    <nav>
                        {{ $books->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>

@endsection
