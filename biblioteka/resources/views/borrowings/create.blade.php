@extends('layouts.admin')

@section('title', 'Nova pozajmica')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.borrowings.index') }}" class="btn btn-outline-secondary btn-sm me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h2 class="fw-bold mb-0">Nova pozajmica</h2>
</div>

<div class="card border-0 shadow-sm" style="max-width: 640px;">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.borrowings.store') }}">
            @csrf

            <div class="mb-3">
                <label for="book_id" class="form-label fw-semibold">Knjiga <span class="text-danger">*</span></label>
                <select id="book_id" name="book_id"
                    class="form-select @error('book_id') is-invalid @enderror" required>
                    <option value="">Odaberi knjigu...</option>
                    @foreach($books as $bk)
                        <option value="{{ $bk->id }}"
                            {{ (old('book_id', request('book_id')) == $bk->id) ? 'selected' : '' }}>
                            {{ $bk->title }} – {{ $bk->author }}
                            ({{ $bk->category->name }}, dostupno: {{ $bk->available_copies }})
                        </option>
                    @endforeach
                </select>
                @error('book_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                @if($books->isEmpty())
                    <div class="form-text text-danger">Nema knjiga sa dostupnim primercima.</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="borrower_name" class="form-label fw-semibold">Ime čitaoca <span class="text-danger">*</span></label>
                <input type="text" id="borrower_name" name="borrower_name"
                    class="form-control @error('borrower_name') is-invalid @enderror"
                    value="{{ old('borrower_name') }}" required
                    placeholder="Ime i prezime čitaoca">
                @error('borrower_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3 mb-4">
                <div class="col-6">
                    <label for="borrowed_at" class="form-label fw-semibold">Datum uzimanja <span class="text-danger">*</span></label>
                    <input type="date" id="borrowed_at" name="borrowed_at"
                        class="form-control @error('borrowed_at') is-invalid @enderror"
                        value="{{ old('borrowed_at', today()->toDateString()) }}" required>
                    @error('borrowed_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-6">
                    <label for="due_date" class="form-label fw-semibold">Rok vraćanja <span class="text-danger">*</span></label>
                    <input type="date" id="due_date" name="due_date"
                        class="form-control @error('due_date') is-invalid @enderror"
                        value="{{ old('due_date', today()->addDays(14)->toDateString()) }}" required>
                    @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-floppy me-1"></i>Kreiraj pozajmicu
                </button>
                <a href="{{ route('admin.borrowings.index') }}" class="btn btn-outline-secondary">Otkaži</a>
            </div>
        </form>
    </div>
</div>
@endsection
