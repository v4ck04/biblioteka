@extends('layouts.frontend')

@section('title', 'Početna')

@section('content')

{{-- ══════════════ HERO ══════════════ --}}
<section class="hero-section d-flex align-items-center py-5">
    <div class="container py-4 position-relative">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 text-white">
                <span class="badge mb-3 px-3 py-2 fw-normal"
                      style="background: rgba(232,168,56,.2); border: 1px solid rgba(232,168,56,.4); color: #e8a838; font-size: .8rem;">
                    <i class="bi bi-stars me-1"></i>Dobrodošli u gradsku biblioteku
                </span>
                <h1 class="display-4 fw-bold lh-1 mb-4">
                    Otkrijte svet<br>
                    <span style="color: var(--accent);">između stranica</span>
                </h1>
                <p class="lead mb-5 opacity-75">
                    Bogat katalog knjiga iz svih žanrova. Pronađite svoju sledeću omiljenu knjigu i obogatite znanje,
                    maštu i iskustvo.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('books.index') }}" class="btn btn-warning btn-lg px-4 fw-semibold">
                        <i class="bi bi-journal-text me-2"></i>Pregled knjiga
                    </a>
                    <a href="{{ route('books.index') }}?availability=available" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-check-circle me-2"></i>Dostupne sada
                    </a>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="row g-3">
                    <div class="col-4">
                        <div class="hero-stat-card text-center text-white p-3">
                            <div class="fs-2 fw-bold" style="color: var(--accent);">{{ $stats['books'] }}</div>
                            <div class="small opacity-75">Knjiga</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="hero-stat-card text-center text-white p-3">
                            <div class="fs-2 fw-bold" style="color: var(--accent);">{{ $stats['categories'] }}</div>
                            <div class="small opacity-75">Kategorija</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="hero-stat-card text-center text-white p-3">
                            <div class="fs-2 fw-bold" style="color: var(--accent);">{{ $stats['available'] }}</div>
                            <div class="small opacity-75">Dostupno</div>
                        </div>
                    </div>
                </div>

                {{-- Decorative floating books icon --}}
                <div class="text-center mt-4 d-none d-lg-block" style="opacity: .15;">
                    <i class="bi bi-book-half" style="font-size: 8rem; color: white;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════ CATEGORIES ══════════════ --}}
<section class="py-5 bg-body-secondary">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="fw-bold section-heading mb-0">Kategorije</h2>
        </div>
        <div class="row g-3">
            @foreach($categories as $cat)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="{{ route('books.index') }}?category_id={{ $cat->id }}"
                   class="card text-decoration-none border-0 shadow-sm h-100 text-center p-3
                          {{ request('category_id') == $cat->id ? 'border border-primary' : '' }}"
                   style="transition: transform .15s, box-shadow .15s;"
                   onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 .5rem 1rem rgba(0,0,0,.12)'"
                   onmouseout="this.style.transform=''; this.style.boxShadow=''">
                    <i class="bi bi-tag fs-3 mb-2" style="color: var(--primary-mid);"></i>
                    <div class="small fw-semibold">{{ $cat->name }}</div>
                    <div class="text-muted" style="font-size: .72rem;">{{ $cat->books_count }} {{ $cat->books_count == 1 ? 'knjiga' : 'knjiga' }}</div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════ FEATURED BOOKS ══════════════ --}}
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-5">
            <h2 class="fw-bold section-heading mb-0">Najnovije knjige</h2>
            <a href="{{ route('books.index') }}" class="btn btn-outline-primary btn-sm">
                Sve knjige <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($featuredBooks as $book)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <a href="{{ route('books.show', $book) }}" class="text-decoration-none">
                    <div class="card book-card shadow-sm rounded-3 overflow-hidden">
                        @if($book->imageUrl())
                            <img src="{{ $book->imageUrl() }}" alt="{{ $book->title }}" class="book-cover">
                        @else
                            <div class="book-cover-placeholder rounded-top">
                                <i class="bi bi-book"></i>
                            </div>
                        @endif
                        <div class="card-body p-3">
                            <h6 class="card-title fw-semibold mb-1 text-truncate" title="{{ $book->title }}">
                                {{ $book->title }}
                            </h6>
                            <p class="text-muted small mb-2">{{ $book->author }}</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle"
                                      style="font-size: .7rem;">
                                    {{ $book->category->name }}
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

        <div class="text-center mt-5">
            <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg px-5">
                <i class="bi bi-journals me-2"></i>Pogledaj ceo katalog
            </a>
        </div>
    </div>
</section>

{{-- ══════════════ CTA BANNER ══════════════ --}}
<section class="py-5" style="background: linear-gradient(135deg, #0a2342, #1565c0);">
    <div class="container text-center text-white py-3">
        <i class="bi bi-book-half display-4 mb-3 d-block" style="color: var(--accent);"></i>
        <h2 class="fw-bold mb-3">Pronađi svoju sledeću avanturu</h2>
        <p class="lead mb-4 opacity-75 mx-auto" style="max-width: 540px;">
            Naš fond se redovno obogaćuje novim naslovima. Poseti nas i pronađi knjigu koja će te odvesti u novi svet.
        </p>
        <a href="{{ route('books.index') }}?availability=available" class="btn btn-warning btn-lg px-5 fw-semibold">
            <i class="bi bi-search me-2"></i>Pretraži dostupne knjige
        </a>
    </div>
</section>

@endsection
