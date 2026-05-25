@extends('layouts.admin')

@section('title', 'Knjige')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Knjige</h2>
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Dodaj knjigu
    </a>
</div>

{{-- Filters --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.books.index') }}" class="row g-3">
            <div class="col-md-5">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Pretraži po naslovu ili autoru..."
                    value="{{ request('search') }}"
                >
            </div>
            <div class="col-md-4">
                <select name="category_id" class="form-select">
                    <option value="">Sve kategorije</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search me-1"></i>Filtriraj
                </button>
                <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($books->isEmpty())
            <p class="text-muted p-4 mb-0">Nema pronađenih knjiga.</p>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 56px;"></th>
                        <th>Naslov</th>
                        <th>Autor</th>
                        <th>Kategorija</th>
                        <th class="text-center">Ukupno</th>
                        <th class="text-center">Dostupno</th>
                        <th class="text-end">Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td>
                            @if($book->imageUrl())
                                <img src="{{ $book->imageUrl() }}" alt="{{ $book->title }}"
                                    class="rounded" style="width: 40px; height: 52px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 52px;">
                                    <i class="bi bi-book text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td><span class="badge bg-secondary">{{ $book->category->name }}</span></td>
                        <td class="text-center">{{ $book->total_copies }}</td>
                        <td class="text-center">
                            <span class="badge {{ $book->available_copies > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $book->available_copies }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.books.show', $book) }}" class="btn btn-sm btn-outline-info" title="Detalji">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-outline-warning" title="Izmeni">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.books.destroy', $book) }}" class="d-inline"
                                  onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovu knjigu?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Obriši">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $books->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
