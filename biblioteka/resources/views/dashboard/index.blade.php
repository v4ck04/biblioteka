@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h2 class="mb-4 fw-bold">Dashboard</h2>

<div class="row g-4 mb-5">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                    <i class="bi bi-book fs-2 text-primary"></i>
                </div>
                <div>
                    <div class="text-muted small">Ukupno knjiga</div>
                    <div class="fs-3 fw-bold">{{ $totalBooks }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 rounded-3 p-3">
                    <i class="bi bi-tag fs-2 text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Kategorije</div>
                    <div class="fs-3 fw-bold">{{ $totalCategories }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                    <i class="bi bi-clock fs-2 text-warning"></i>
                </div>
                <div>
                    <div class="text-muted small">Aktivne pozajmice</div>
                    <div class="fs-3 fw-bold">{{ $activeBorrowings }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                    <i class="bi bi-exclamation-triangle fs-2 text-danger"></i>
                </div>
                <div>
                    <div class="text-muted small">Kasne pozajmice</div>
                    <div class="fs-3 fw-bold text-danger">{{ $overdueBorrowings }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clock-history me-2"></i>Najskorije pozajmice (po roku vraćanja)</span>
        <a href="{{ route('admin.borrowings.index') }}" class="btn btn-sm btn-outline-primary">Sve aktivne</a>
    </div>
    <div class="card-body p-0">
        @if($recentBorrowings->isEmpty())
            <p class="text-muted p-4 mb-0">Nema aktivnih pozajmica.</p>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Knjiga</th>
                        <th>Čitalac</th>
                        <th>Rok vraćanja</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentBorrowings as $b)
                    <tr class="{{ $b->isOverdue() ? 'table-danger' : '' }}">
                        <td>{{ $b->book->title }}</td>
                        <td>{{ $b->borrower_name }}</td>
                        <td>{{ $b->due_date->format('d.m.Y') }}</td>
                        <td>
                            @if($b->isOverdue())
                                <span class="badge bg-danger">Kasni {{ $b->overdueDays() }} dan(a)</span>
                            @else
                                <span class="badge bg-success">Aktivna</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
