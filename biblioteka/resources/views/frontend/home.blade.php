@extends('layouts.public')

@section('title', 'Početna')

@section('content')

@php
$catIcons = [
    'Naučna fantastika' => 'bi-rocket-takeoff',
    'Detektivski roman' => 'bi-search',
    'Istorija'          => 'bi-hourglass-split',
    'Roman'             => 'bi-book',
    'Filozofija'        => 'bi-lightbulb',
    'Biografija'        => 'bi-person-vcard',
    'Poezija'           => 'bi-feather',
    'Dečija knjiga'     => 'bi-balloon-heart',
];
@endphp

{{-- ══════════════ HERO ══════════════ --}}
<section class="gb-hero">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                <div class="gb-hero-eyebrow">
                    <i class="bi bi-book-half"></i>
                    Dobrodošli u Gradsku biblioteku
                </div>

                <h1>
                    Knjiga koju tražite<br>
                    <em>verovatno je već</em><br>
                    na polici.
                </h1>

                <p class="gb-hero-lead">
                    Bogat katalog knjiga iz svih žanrova. Pronađite svoju sledeću omiljenu
                    knjigu i pozajmite je uz jednostavan zahtev.
                </p>

                <form action="{{ route('katalog') }}" method="GET" class="gb-hero-search">
                    <input type="text" name="search"
                           placeholder="Pretraži knjige po naslovu ili autoru"
                           value="{{ request('search') }}" autocomplete="off">
                    <button type="submit">
                        <i class="bi bi-search me-1"></i>Pretraži
                    </button>
                </form>

                <div class="gb-hero-chips">
                    @foreach($categories->sortByDesc('books_count')->take(6) as $cat)
                    @php $chipIcon = $catIcons[$cat->name] ?? 'bi-bookmark'; @endphp
                    <a href="{{ route('katalog') }}?category_id={{ $cat->id }}" class="gb-chip">
                        <i class="bi {{ $chipIcon }}"></i>
                        {{ $cat->name }}
                    </a>
                    @endforeach
                    <a href="{{ route('katalog') }}" class="gb-chip gb-chip-all">
                        <i class="bi bi-grid"></i>
                        Sve kategorije →
                    </a>
                </div>

                <div class="gb-stats">
                    <div>
                        <div class="gb-stat-num">{{ $stats['books'] }}</div>
                        <div class="gb-stat-label">Naslova u katalogu</div>
                    </div>
                    <div class="gb-stats-sep"></div>
                    <div>
                        <div class="gb-stat-num">{{ $stats['categories'] }}</div>
                        <div class="gb-stat-label">Kategorija</div>
                    </div>
                    <div class="gb-stats-sep"></div>
                    <div>
                        <div class="gb-stat-num gb-stat-text">Pon–Sub</div>
                        <div class="gb-stat-label">Otvoreno za posete</div>
                    </div>
                </div>
            </div>

            {{-- ──────── Visual: dynamic book stack ──────── --}}
            <div class="col-lg-6 d-none d-lg-flex gb-hero-visual">
                @php
                    $stackColors = [
                        ['#1e3a5f', '#2d5a8a'],
                        ['#0d2137', '#1a3a5c'],
                        ['#162d4a', '#244d70'],
                    ];
                @endphp
                <div class="gb-book-stack" id="heroBookStack">
                    @foreach($heroBooks as $i => $heroBook)
                    @php $sc = $stackColors[$i % 3]; @endphp
                    <div class="gb-stack-book" data-pos="{{ $i }}">
                        @if($heroBook->imageUrl())
                            <img class="gb-stack-img" src="{{ $heroBook->imageUrl() }}" alt="{{ $heroBook->title }}">
                        @else
                            @php
                                $sw = explode(' ', $heroBook->title);
                                $si = strtoupper($sw[0][0] ?? '?');
                                if (isset($sw[1])) $si .= strtoupper($sw[1][0]);
                            @endphp
                            <div class="gb-stack-ph" style="background: linear-gradient(160deg, {{ $sc[0] }}, {{ $sc[1] }});">
                                <span class="gb-stack-initials">{{ $si }}</span>
                                <span class="gb-stack-spine">{{ Str::limit($heroBook->title, 16) }}</span>
                            </div>
                        @endif
                    </div>
                    @endforeach

                    {{-- Floating stat card --}}
                    <div class="gb-hero-float-card">
                        <div class="gb-hero-float-pulse">
                            <div class="gb-hero-float-dot"></div>
                        </div>
                        <div>
                            <div class="gb-hero-float-num">{{ $stats['available'] }}</div>
                            <div class="gb-hero-float-label">naslova dostupno</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════ POPULAR BOOKS ══════════════ --}}
@if($popularBooks->isNotEmpty())
<section class="gb-popular-section">
    <div class="container">
        <div class="d-flex align-items-end justify-content-between gb-section-head mb-0">
            <div>
                <div class="gb-section-eyebrow">Najpozajmljenije</div>
                <h2 class="gb-section-title">Najpopularnije knjige</h2>
                <p style="font-size:.88rem; color:var(--gb-text-muted); margin-top:.35rem; margin-bottom:0;">
                    Knjige koje se najčešće pozajmljuju
                </p>
            </div>
            <a href="{{ route('katalog') }}" class="gb-section-more mb-1">
                Sve knjige <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @php
            $popularColors = [
                ['#1e3a5f','#2d5a8a'],['#0d2137','#1a3a5c'],['#162d4a','#244d70'],
                ['#1a2a4a','#2a4a6a'],['#0e1e3a','#1a3458'],['#142436','#243c5a'],
            ];
        @endphp

        <div class="gb-popular-grid mt-4">
            @foreach($popularBooks as $popBook)
            @php $pc = $popularColors[$popBook->id % 6]; @endphp
            <a href="{{ route('knjiga.show', $popBook) }}" class="gb-card">
                <div class="gb-cover">
                    @if($popBook->imageUrl())
                        <img src="{{ $popBook->imageUrl() }}" alt="{{ $popBook->title }}">
                    @else
                        @php
                            $pw = explode(' ', $popBook->title);
                            $pi = strtoupper($pw[0][0] ?? '?');
                            if (isset($pw[1])) $pi .= strtoupper($pw[1][0]);
                        @endphp
                        <div class="gb-cover-placeholder"
                             style="background: linear-gradient(150deg, {{ $pc[0] }}, {{ $pc[1] }});">
                            <span class="gb-cover-initials">{{ $pi }}</span>
                        </div>
                    @endif
                </div>
                <div class="gb-card-body">
                    <div class="gb-card-title">{{ $popBook->title }}</div>
                    <div class="gb-card-author">{{ $popBook->author }}</div>
                    <div class="gb-card-foot">
                        <span class="gb-badge-cat">{{ $popBook->category->name }}</span>
                        <span class="gb-loan-badge">
                            <i class="bi bi-arrow-repeat"></i>
                            {{ $popBook->borrowings_count }}×
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════ CATEGORIES ══════════════ --}}
<section class="gb-section gb-section-alt">
    <div class="container">
        <div class="d-flex align-items-end justify-content-between gb-section-head mb-0">
            <div>
                <div class="gb-section-eyebrow">Pretraži po žanru</div>
                <h2 class="gb-section-title">Kategorije</h2>
            </div>
            <a href="{{ route('katalog') }}" class="gb-section-more mb-1">
                Sve knjige <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="gb-cat-grid mt-4">
            @forelse($categories as $cat)
            @php $catGridIcon = $catIcons[$cat->name] ?? 'bi-bookmark'; @endphp
            <a href="{{ route('katalog') }}?category_id={{ $cat->id }}" class="gb-cat-card">
                <div class="gb-cat-icon">
                    <i class="bi {{ $catGridIcon }}"></i>
                </div>
                <div class="gb-cat-name">{{ $cat->name }}</div>
                <div class="gb-cat-count">{{ $cat->books_count }} {{ $cat->books_count == 1 ? 'knjiga' : ($cat->books_count >= 2 && $cat->books_count <= 4 ? 'knjige' : 'knjiga') }}</div>
            </a>
            @empty
            <p class="text-muted" style="font-size:.88rem;">Još nema kategorija.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- ══════════════ FEATURED BOOKS ══════════════ --}}
<section class="gb-section">
    <div class="container">
        <div class="d-flex align-items-end justify-content-between gb-section-head mb-0">
            <div>
                <div class="gb-section-eyebrow">Najnovije u fondu</div>
                <h2 class="gb-section-title">Istaknute knjige</h2>
            </div>
            <a href="{{ route('katalog') }}" class="gb-section-more mb-1">
                Ceo katalog <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @php
            $coverColors = [
                ['#2b4a25','#5c8a50'],['#6b4f3a','#a07455'],['#3d5a7a','#6b8db0'],
                ['#4a2b4a','#7a5078'],['#6b3a1f','#a05c38'],['#1a3a4a','#3d6b7a'],
                ['#3a4a1a','#6b7a3d'],['#4a3a1a','#7a6038'],
            ];
        @endphp

        @if($featuredBooks->isEmpty())
        <div class="gb-empty" style="padding:3rem 0;">
            <div class="gb-empty-icon"><i class="bi bi-journals"></i></div>
            <h4>Katalog je prazan</h4>
            <p>Knjige još uvek nisu dodate u fond biblioteke.</p>
        </div>
        @else
        <div class="gb-grid mt-4">
            @foreach($featuredBooks as $book)
            @php $ci = $book->id % 8; $cc = $coverColors[$ci]; @endphp
            <a href="{{ route('knjiga.show', $book) }}" class="gb-card">
                <div class="gb-cover">
                    @if($book->imageUrl())
                        <img src="{{ $book->imageUrl() }}" alt="{{ $book->title }}">
                    @else
                        @php
                            $words = explode(' ', $book->title);
                            $init  = strtoupper($words[0][0] ?? '?');
                            if (isset($words[1])) $init .= strtoupper($words[1][0]);
                        @endphp
                        <div class="gb-cover-placeholder"
                             style="background: linear-gradient(150deg, {{ $cc[0] }}, {{ $cc[1] }});">
                            <span class="gb-cover-initials">{{ $init }}</span>
                        </div>
                    @endif
                </div>
                <div class="gb-card-body">
                    <div class="gb-card-title">{{ $book->title }}</div>
                    <div class="gb-card-author">{{ $book->author }}</div>
                    <div class="gb-card-foot">
                        <span class="gb-badge-cat">{{ $book->category->name }}</span>
                        @if($book->available_copies > 0)
                            <span class="gb-badge-avail ok">Dostupna</span>
                        @else
                            <span class="gb-badge-avail out">Pozajmljena</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</section>

{{-- ══════════════ HOW IT WORKS ══════════════ --}}
<div class="gb-how">
    <div class="container">
        <div class="row g-5">
            <div class="col-12 col-md-4">
                <div class="gb-how-step">
                    <div class="gb-step-num">01</div>
                    <div class="gb-step-title">Pronađi knjigu</div>
                    <div class="gb-step-desc">Pretražuj katalog po naslovu, autoru ili kategoriji. Filtruj po dostupnosti.</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="gb-how-step">
                    <div class="gb-step-num">02</div>
                    <div class="gb-step-title">Pošalji zahtev</div>
                    <div class="gb-step-desc">Popuni kratku formu sa kontakt podacima. Bibliotekar će pregledati zahtev u roku od 24 sata.</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="gb-how-step">
                    <div class="gb-step-num">03</div>
                    <div class="gb-step-title">Preuzmi knjigu</div>
                    <div class="gb-step-desc">Poseti biblioteku sa ličnom kartom i preuzmi svoju knjigu na 14 dana.</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
