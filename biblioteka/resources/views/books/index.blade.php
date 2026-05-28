@extends('layouts.admin')

@section('title', 'Knjige')

@section('content')

<div class="page-head">
    <div>
        <h2 class="page-title">Knjige</h2>
        <p class="page-sub">Upravljanje katalogom knjiga</p>
    </div>
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i>Dodaj knjigu
    </a>
</div>

{{-- Search + Category filter --}}
<div class="card mb-4" style="padding:1rem 1.25rem;">
    <form method="GET" action="{{ route('admin.books.index') }}">
        <div style="display:flex;gap:.75rem;align-items:flex-end;flex-wrap:wrap;">
            <div style="flex:1;min-width:180px;">
                <label class="form-label">Pretraga</label>
                <div class="position-relative">
                    <i class="bi bi-search position-absolute" style="top:50%;left:.75rem;transform:translateY(-50%);color:var(--ink-4);font-size:.8rem;"></i>
                    <input type="text" name="search" class="form-control" style="padding-left:2rem;"
                        placeholder="Naslov ili autor..." value="{{ request('search') }}">
                </div>
            </div>
            <div style="flex:1;min-width:160px;">
                <label class="form-label">Kategorija</label>
                <select name="category_id" class="form-select">
                    <option value="">Sve kategorije</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="display:flex;gap:.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel"></i>Filtriraj
                </button>
                <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary" title="Resetuj">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </div>
    </form>
</div>

{{-- Books table --}}
<div class="card">
    @if($books->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon" style="background:rgba(15,18,40,0.05);">
                <i class="bi bi-search" style="color:var(--ink-4);"></i>
            </div>
            <p style="font-size:.875rem;color:var(--ink-1);font-weight:600;margin-bottom:.25rem;">Nema pronađenih knjiga</p>
            <p style="font-size:.78rem;color:var(--ink-4);margin:0;">Pokušajte drugačiji filter ili dodajte novu knjigu.</p>
        </div>
    @else
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
    <div class="table-responsive">
        <table class="tbl">
            <thead>
                <tr>
                    <th style="width:52px;"></th>
                    <th>Naslov</th>
                    <th>Autor</th>
                    <th>Kategorija</th>
                    <th style="text-align:center;">Kopija</th>
                    <th style="width:120px;">Dostupnost</th>
                    <th style="text-align:right;">Akcije</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                @php
                    $cover = $covers[$book->id % count($covers)];
                    $words = explode(' ', $book->title);
                    $initials = strtoupper(substr($words[0], 0, 1)) . (isset($words[1]) ? strtoupper(substr($words[1], 0, 1)) : '');
                    $pct = $book->total_copies > 0 ? round(($book->available_copies / $book->total_copies) * 100) : 0;
                    $progClass = $pct === 0 ? 'full' : ($pct < 50 ? 'half' : '');
                @endphp
                <tr>
                    <td>
                        @if($book->imageUrl())
                            <img src="{{ $book->imageUrl() }}" alt="{{ $book->title }}"
                                style="width:36px;height:48px;object-fit:cover;border-radius:5px;box-shadow:0 2px 6px rgba(15,18,40,0.12);">
                        @else
                            <div class="book-cover" style="background:linear-gradient(135deg, {{ $cover['from'] }}, {{ $cover['to'] }});">
                                {{ $initials }}
                            </div>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.books.show', $book) }}" class="text-decoration-none fw-semibold"
                           style="color:var(--ink-1);font-size:.8375rem;">
                            {{ $book->title }}
                        </a>
                    </td>
                    <td style="color:var(--ink-3);font-size:.8rem;">{{ $book->author }}</td>
                    <td><span class="cat-pill">{{ $book->category->name }}</span></td>
                    <td style="text-align:center;">
                        <span class="num" style="font-size:.8rem;font-weight:600;color:var(--ink-2);">{{ $book->total_copies }}</span>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:.5rem;">
                            <div style="flex:1;">
                                <div class="prog-wrap">
                                    <div class="prog-bar {{ $progClass }}" style="width:{{ $pct }}%;"></div>
                                </div>
                            </div>
                            <span class="num" style="font-size:.72rem;color:var(--ink-3);min-width:28px;text-align:right;">{{ $book->available_copies }}/{{ $book->total_copies }}</span>
                        </div>
                    </td>
                    <td style="text-align:right;">
                        <div style="display:flex;gap:4px;justify-content:flex-end;">
                            <a href="{{ route('admin.books.show', $book) }}" class="btn btn-sm btn-outline-info" title="Detalji">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-outline-warning" title="Izmeni">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.books.destroy', $book) }}" class="d-inline"
                                  onsubmit="return confirm('Obrisati ovu knjigu?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Obriši">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="padding:.75rem 1rem;display:flex;align-items:center;justify-content:space-between;border-top:1px solid var(--line-1);">
        <span style="font-size:.75rem;color:var(--ink-4);">
            Prikazano {{ $books->firstItem() }}–{{ $books->lastItem() }} od <span class="num">{{ $books->total() }}</span>
        </span>
        {{ $books->links() }}
    </div>
    @endif
</div>

@endsection
