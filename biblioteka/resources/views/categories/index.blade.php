@extends('layouts.admin')

@section('title', 'Kategorije')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Kategorije</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Dodaj kategoriju
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($categories->isEmpty())
            <p class="text-muted p-4 mb-0">Nema kategorija.</p>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Naziv</th>
                        <th class="text-center">Broj knjiga</th>
                        <th class="text-end">Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $cat)
                    <tr>
                        <td class="text-muted">{{ $cat->id }}</td>
                        <td class="fw-semibold">{{ $cat->name }}</td>
                        <td class="text-center">
                            <span class="badge bg-primary">{{ $cat->books_count }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-outline-warning" title="Izmeni">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" class="d-inline"
                                  onsubmit="return confirm('Obrisati kategoriju {{ addslashes($cat->name) }}?');">
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
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
