@extends('layouts.admin')

@section('title', $book->title)

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary btn-sm me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h2 class="fw-bold mb-0">{{ $book->title }}</h2>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-3">Podaci o knjizi</h5>
                <dl class="row mb-0">
                    <dt class="col-5 text-muted">Naslov</dt>
                    <dd class="col-7">{{ $book->title }}</dd>

                    <dt class="col-5 text-muted">Autor</dt>
                    <dd class="col-7">{{ $book->author }}</dd>

                    <dt class="col-5 text-muted">Kategorija</dt>
                    <dd class="col-7"><span class="badge bg-secondary">{{ $book->category->name }}</span></dd>

                    <dt class="col-5 text-muted">Ukupno</dt>
                    <dd class="col-7">{{ $book->total_copies }}</dd>

                    <dt class="col-5 text-muted">Dostupno</dt>
                    <dd class="col-7">
                        <span class="badge {{ $book->available_copies > 0 ? 'bg-success' : 'bg-danger' }} fs-6">
                            {{ $book->available_copies }}
                        </span>
                    </dd>
                </dl>

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil me-1"></i>Izmeni
                    </a>
                    @if($book->available_copies > 0)
                    <a href="{{ route('admin.borrowings.create') }}?book_id={{ $book->id }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus me-1"></i>Pozajmi
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-clock-history me-2"></i>Istorija pozajmica
            </div>
            <div class="card-body p-0">
                @if($borrowings->isEmpty())
                    <p class="text-muted p-4 mb-0">Knjiga još nije bila pozajmljena.</p>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Čitalac</th>
                                <th>Datum uzimanja</th>
                                <th>Rok vraćanja</th>
                                <th>Vraćeno</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($borrowings as $b)
                            <tr class="{{ $b->isOverdue() ? 'table-danger' : '' }}">
                                <td>{{ $b->borrower_name }}</td>
                                <td>{{ $b->borrowed_at->format('d.m.Y') }}</td>
                                <td>{{ $b->due_date->format('d.m.Y') }}</td>
                                <td>
                                    @if($b->returned_at)
                                        <span class="text-success">
                                            <i class="bi bi-check-circle me-1"></i>{{ $b->returned_at->format('d.m.Y') }}
                                        </span>
                                    @else
                                        @if($b->isOverdue())
                                            <span class="badge bg-danger">Kasni {{ $b->overdueDays() }}d</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Nije vraćeno</span>
                                        @endif
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
    </div>
</div>
@endsection
