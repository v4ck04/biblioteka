@extends('layouts.admin')

@section('title', 'Istorija pozajmica')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Istorija pozajmica</h2>
    <a href="{{ route('admin.borrowings.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Nova pozajmica
    </a>
</div>

{{-- Filters --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.borrowings.all') }}" class="row g-3">
            <div class="col-md-4">
                <select name="book_id" class="form-select">
                    <option value="">Sve knjige</option>
                    @foreach($books as $bk)
                        <option value="{{ $bk->id }}" {{ request('book_id') == $bk->id ? 'selected' : '' }}>
                            {{ $bk->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">Svi statusi</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktivne</option>
                    <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Vraćene</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control"
                    value="{{ request('date_from') }}" placeholder="Od datuma">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" class="form-control"
                    value="{{ request('date_to') }}" placeholder="Do datuma">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                <a href="{{ route('admin.borrowings.all') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($borrowings->isEmpty())
            <p class="text-muted p-4 mb-0">Nema pronađenih pozajmica.</p>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Knjiga</th>
                        <th>Kategorija</th>
                        <th>Čitalac</th>
                        <th>Uzeto</th>
                        <th>Rok</th>
                        <th>Vraćeno</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrowings as $b)
                    <tr class="{{ $b->isOverdue() ? 'table-danger' : '' }}">
                        <td>
                            <a href="{{ route('admin.books.show', $b->book) }}" class="text-decoration-none fw-semibold">
                                {{ $b->book->title }}
                            </a>
                        </td>
                        <td><span class="badge bg-secondary">{{ $b->book->category->name }}</span></td>
                        <td>{{ $b->borrower_name }}</td>
                        <td>{{ $b->borrowed_at->format('d.m.Y') }}</td>
                        <td>{{ $b->due_date->format('d.m.Y') }}</td>
                        <td>
                            @if($b->returned_at)
                                {{ $b->returned_at->format('d.m.Y') }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($b->returned_at)
                                <span class="badge bg-secondary">Vraćeno</span>
                            @elseif($b->isOverdue())
                                <span class="badge bg-danger">Kasni {{ $b->overdueDays() }}d</span>
                            @else
                                <span class="badge bg-success">Aktivna</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $borrowings->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
