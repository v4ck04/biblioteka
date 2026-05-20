@extends('layouts.admin')

@section('title', 'Nova kategorija')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h2 class="fw-bold mb-0">Nova kategorija</h2>
</div>

<div class="card border-0 shadow-sm" style="max-width: 480px;">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="form-label fw-semibold">Naziv <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" required autofocus>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-floppy me-1"></i>Sačuvaj
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Otkaži</a>
            </div>
        </form>
    </div>
</div>
@endsection
