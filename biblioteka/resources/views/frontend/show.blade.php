@extends('layouts.frontend')

@section('title', $book->title)

@section('content')

{{-- ══════════════ PAGE HEADER ══════════════ --}}
<div style="background: linear-gradient(135deg, #0a2342, #1565c0);" class="py-4 mb-5">
    <div class="container text-white py-2">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider-color: rgba(255,255,255,.5);">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Početna</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('books.index') }}" class="text-white-50 text-decoration-none">Knjige</a>
                </li>
                <li class="breadcrumb-item active text-white text-truncate" style="max-width: 300px;">
                    {{ $book->title }}
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-5 justify-content-center">

        {{-- ══════ COVER ══════ --}}
        <div class="col-md-4 col-lg-3">
            <div class="text-center text-md-start">
                @if($book->imageUrl())
                    <img src="{{ $book->imageUrl() }}" alt="{{ $book->title }}"
                         class="img-fluid rounded-3 shadow-lg"
                         style="max-height: 420px; width: 100%; object-fit: cover;">
                @else
                    <div class="rounded-3 shadow d-flex align-items-center justify-content-center"
                         style="height: 380px; background: linear-gradient(135deg, #e8eaf6, #cfd8dc);">
                        <i class="bi bi-book display-1" style="color: #90a4ae;"></i>
                    </div>
                @endif
            </div>
        </div>

        {{-- ══════ DETAILS ══════ --}}
        <div class="col-md-8 col-lg-6">

            {{-- Category + availability badges --}}
            <div class="d-flex flex-wrap gap-2 mb-3">
                <a href="{{ route('books.index') }}?category_id={{ $book->category_id }}"
                   class="badge bg-primary-subtle text-primary border border-primary-subtle text-decoration-none px-3 py-2"
                   style="font-size: .8rem;">
                    <i class="bi bi-tag me-1"></i>{{ $book->category->name }}
                </a>
                @if($book->available_copies > 0)
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2"
                          style="font-size: .8rem;">
                        <i class="bi bi-check-circle me-1"></i>Dostupna za pozajmicu
                    </span>
                @else
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2"
                          style="font-size: .8rem;">
                        <i class="bi bi-x-circle me-1"></i>Trenutno nedostupna
                    </span>
                @endif
            </div>

            <h1 class="fw-bold mb-2">{{ $book->title }}</h1>
            <p class="fs-5 text-muted mb-4">
                <i class="bi bi-person-circle me-2"></i>{{ $book->author }}
            </p>

            {{-- Info cards --}}
            <div class="row g-3 mb-4">
                <div class="col-6">
                    <div class="card border-0 bg-body-secondary rounded-3 p-3 text-center">
                        <div class="fw-bold fs-4 mb-1">{{ $book->total_copies }}</div>
                        <div class="text-muted small">Ukupno primeraka</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-0 rounded-3 p-3 text-center
                        {{ $book->available_copies > 0 ? 'bg-success-subtle' : 'bg-danger-subtle' }}">
                        <div class="fw-bold fs-4 mb-1
                            {{ $book->available_copies > 0 ? 'text-success' : 'text-danger' }}">
                            {{ $book->available_copies }}
                        </div>
                        <div class="text-muted small">Dostupno</div>
                    </div>
                </div>
            </div>

            {{-- Availability note --}}
            @if($book->available_copies > 0)
            <div class="alert alert-success d-flex align-items-start gap-2 border-0 rounded-3" role="alert">
                <i class="bi bi-info-circle-fill mt-1 flex-shrink-0"></i>
                <div class="small">
                    Ova knjiga je dostupna za pozajmicu. Posetite nas u biblioteci sa ličnom kartom i slobodnom
                    knjiga je vaša na <strong>14 dana</strong>.
                </div>
            </div>
            @else
            <div class="alert alert-warning d-flex align-items-start gap-2 border-0 rounded-3" role="alert">
                <i class="bi bi-clock-history mt-1 flex-shrink-0"></i>
                <div class="small">
                    Svi primerci su trenutno pozajmljeni. Proverite ponovo uskoro ili nas kontaktirajte da te
                    obaveštimo kada knjiga postane dostupna.
                </div>
            </div>
            @endif

            {{-- Action buttons --}}
            <div class="d-flex flex-wrap gap-3 mt-4">
                <a href="{{ route('books.index') }}?category_id={{ $book->category_id }}"
                   class="btn btn-outline-primary">
                    <i class="bi bi-collection me-2"></i>Više iz kategorije
                </a>
                <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Svi katalog
                </a>
            </div>
        </div>
    </div>

    {{-- ══════ RELATED BOOKS ══════ --}}
    @if($relatedBooks->isNotEmpty())
    <hr class="my-5">
    <div>
        <h3 class="fw-bold section-heading mb-5">Više iz kategorije "{{ $book->category->name }}"</h3>
        <div class="row g-4">
            @foreach($relatedBooks as $rel)
            <div class="col-6 col-md-3">
                <a href="{{ route('books.show', $rel) }}" class="text-decoration-none">
                    <div class="card book-card shadow-sm rounded-3 overflow-hidden h-100">
                        @if($rel->imageUrl())
                            <img src="{{ $rel->imageUrl() }}" alt="{{ $rel->title }}" class="book-cover">
                        @else
                            <div class="book-cover-placeholder">
                                <i class="bi bi-book"></i>
                            </div>
                        @endif
                        <div class="card-body p-3">
                            <h6 class="card-title fw-semibold mb-1 text-truncate" title="{{ $rel->title }}">
                                {{ $rel->title }}
                            </h6>
                            <p class="text-muted small mb-2">{{ $rel->author }}</p>
                            @if($rel->available_copies > 0)
                                <span class="badge bg-success-subtle text-success border border-success-subtle"
                                      style="font-size: .68rem;">
                                    <i class="bi bi-check-circle me-1"></i>Dostupna
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle"
                                      style="font-size: .68rem;">
                                    <i class="bi bi-x-circle me-1"></i>Pozajmljena
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@endsection
