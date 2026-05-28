@extends('layouts.public')

@section('title', 'Katalog knjiga')

@section('content')

<div style="background: var(--gb-cream-2); border-bottom: 1px solid var(--gb-line); padding: 2rem 0 1.75rem;">
    <div class="container">
        <div class="gb-breadcrumb">
            <a href="{{ route('home') }}">Početna</a>
            <span class="gb-breadcrumb-sep"><i class="bi bi-chevron-right" style="font-size:.7rem;"></i></span>
            <span>Katalog</span>
        </div>
        <h1 style="font-family:'Cormorant Garamond',serif; font-size:2.2rem; font-weight:700; color:var(--gb-ink); margin:0 0 .25rem;">
            Katalog knjiga
        </h1>
        <p style="font-size:.88rem; color:var(--gb-ink-4); margin:0;">
            Pronađite svoju sledeću omiljenu knjigu
        </p>
    </div>
</div>

<div class="container" style="padding-top:2rem; padding-bottom:4rem;">

    {{-- ══════ FILTER BAR ══════ --}}
    <form method="GET" action="{{ route('katalog') }}" id="filterForm">
        <div class="gb-filters">
            <span class="gb-filter-label">Filteri</span>
            <div class="gb-filter-divider"></div>

            <div class="gb-filter-search" style="flex:1; min-width:200px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.867-3.834zm-5.242 1.156a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"/>
                </svg>
                <input type="text" name="search" placeholder="Naslov ili autor…"
                       value="{{ request('search') }}" autocomplete="off">
            </div>

            <div class="gb-filter-divider"></div>

            <select name="category_id" class="gb-filter-select"
                    onchange="document.getElementById('filterForm').submit()">
                <option value="">Sve kategorije</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <div class="gb-filter-divider"></div>

            <label class="gb-filter-check">
                <input type="checkbox" name="dostupne" value="1"
                    {{ request('dostupne') ? 'checked' : '' }}
                    onchange="document.getElementById('filterForm').submit()">
                Samo dostupne
            </label>

            <div class="gb-filter-divider"></div>

            <button type="submit" class="gb-filter-btn">
                <i class="bi bi-search me-1"></i>Traži
            </button>

            @if(request()->hasAny(['search','category_id','dostupne']))
            <a href="{{ route('katalog') }}" class="gb-filter-clear">
                <i class="bi bi-x me-1"></i>Poništi
            </a>
            @endif
        </div>
    </form>

    {{-- ══════ RESULTS META ══════ --}}
    <div class="gb-results-meta">
        <div class="gb-results-count">
            <strong>{{ $books->total() }}</strong>
            {{ $books->total() == 1 ? 'knjiga pronađena' : 'knjiga pronađeno' }}
            @if(request('search'))
                za „{{ request('search') }}"
            @endif
        </div>

        <form method="GET" action="{{ route('katalog') }}" style="display:inline;">
            @if(request('search'))    <input type="hidden" name="search"      value="{{ request('search') }}"> @endif
            @if(request('category_id')) <input type="hidden" name="category_id" value="{{ request('category_id') }}"> @endif
            @if(request('dostupne'))  <input type="hidden" name="dostupne"    value="1"> @endif
            <select name="sort" class="gb-sort-select" onchange="this.form.submit()">
                <option value="naslov"    {{ $sort === 'naslov'    ? 'selected' : '' }}>Abecedno (naslov)</option>
                <option value="autor"     {{ $sort === 'autor'     ? 'selected' : '' }}>Abecedno (autor)</option>
                <option value="najnovije" {{ $sort === 'najnovije' ? 'selected' : '' }}>Najnovije</option>
            </select>
        </form>
    </div>

    {{-- ══════ BOOKS GRID ══════ --}}
    @php
        $coverColors = [
            ['#2b4a25','#5c8a50'],['#6b4f3a','#a07455'],['#3d5a7a','#6b8db0'],
            ['#4a2b4a','#7a5078'],['#6b3a1f','#a05c38'],['#1a3a4a','#3d6b7a'],
            ['#3a4a1a','#6b7a3d'],['#4a3a1a','#7a6038'],
        ];
    @endphp

    @if($books->isEmpty())
        <div class="gb-empty">
            <div class="gb-empty-icon"><i class="bi bi-search"></i></div>
            <h4>Nema rezultata</h4>
            <p>
                Pokušaj sa drugačijim filterima ili
                <a href="{{ route('katalog') }}" style="color:var(--gb-forest-mid);">prikaži sve knjige</a>.
            </p>
        </div>
    @else
        <div class="gb-grid">
            @foreach($books as $book)
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

        @if($books->hasPages())
            <div class="gb-pagination">
                {{ $books->links('pagination::bootstrap-5') }}
            </div>
        @endif
    @endif

</div>

@endsection
