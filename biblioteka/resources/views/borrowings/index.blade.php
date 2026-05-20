@extends('layouts.admin')

@section('title', 'Aktivne pozajmice')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Aktivne pozajmice</h2>
    <a href="{{ route('admin.borrowings.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Nova pozajmica
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($borrowings->isEmpty())
            <p class="text-muted p-4 mb-0">Nema aktivnih pozajmica.</p>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Knjiga</th>
                        <th>Autor</th>
                        <th>Čitalac</th>
                        <th>Datum uzimanja</th>
                        <th>Rok vraćanja</th>
                        <th>Status</th>
                        <th class="text-end">Akcija</th>
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
                        <td class="text-muted">{{ $b->book->author }}</td>
                        <td>{{ $b->borrower_name }}</td>
                        <td>{{ $b->borrowed_at->format('d.m.Y') }}</td>
                        <td>{{ $b->due_date->format('d.m.Y') }}</td>
                        <td>
                            @if($b->isOverdue())
                                <span class="badge bg-danger">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Kasni {{ $b->overdueDays() }} dan(a)
                                </span>
                            @else
                                <span class="badge bg-success">Aktivna</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('admin.borrowings.return', $b) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-success"
                                        onclick="return confirm('Označiti knjigu kao vraćenu?');">
                                    <i class="bi bi-check-lg me-1"></i>Vraćeno
                                </button>
                            </form>
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
