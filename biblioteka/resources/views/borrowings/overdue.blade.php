@extends('layouts.admin')

@section('title', 'Kasne pozajmice')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0 text-danger">
        <i class="bi bi-exclamation-triangle me-2"></i>Kasne pozajmice
    </h2>
    <span class="badge bg-danger fs-6">{{ $borrowings->total() }} kasnih</span>
</div>

<div class="card border-0 shadow-sm border-danger border-opacity-25">
    <div class="card-body p-0">
        @if($borrowings->isEmpty())
            <div class="p-4 text-center">
                <i class="bi bi-check-circle text-success fs-1"></i>
                <p class="text-muted mt-2 mb-0">Odlično! Nema kasnih pozajmica.</p>
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-danger">
                    <tr>
                        <th>Knjiga</th>
                        <th>Autor</th>
                        <th>Čitalac</th>
                        <th>Datum uzimanja</th>
                        <th>Rok vraćanja</th>
                        <th>Kašnjenje</th>
                        <th class="text-end">Akcija</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrowings as $b)
                    <tr class="table-danger">
                        <td>
                            <a href="{{ route('admin.books.show', $b->book) }}" class="text-decoration-none fw-semibold">
                                {{ $b->book->title }}
                            </a>
                        </td>
                        <td>{{ $b->book->author }}</td>
                        <td>{{ $b->borrower_name }}</td>
                        <td>{{ $b->borrowed_at->format('d.m.Y') }}</td>
                        <td class="fw-semibold text-danger">{{ $b->due_date->format('d.m.Y') }}</td>
                        <td>
                            <span class="badge bg-danger">{{ $b->overdueDays() }} dan(a)</span>
                        </td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('admin.borrowings.return', $b) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success"
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
