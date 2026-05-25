@extends('layouts.admin')

@section('title', 'Izmeni knjigu')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary btn-sm me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h2 class="fw-bold mb-0">Izmeni knjigu</h2>
</div>

@php $activeBorrowed = $book->activeBorrowingsCount(); @endphp
@if($activeBorrowed > 0)
<div class="alert alert-info">
    <i class="bi bi-info-circle me-2"></i>
    Ova knjiga ima <strong>{{ $activeBorrowed }}</strong> aktivnih pozajmica.
    Ukupan broj primeraka ne može biti manji od tog broja.
</div>
@endif

<div class="card border-0 shadow-sm" style="max-width: 640px;">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label fw-semibold">Naslov <span class="text-danger">*</span></label>
                <input type="text" id="title" name="title"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title', $book->title) }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="author" class="form-label fw-semibold">Autor <span class="text-danger">*</span></label>
                <input type="text" id="author" name="author"
                    class="form-control @error('author') is-invalid @enderror"
                    value="{{ old('author', $book->author) }}" required>
                @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label fw-semibold">Kategorija <span class="text-danger">*</span></label>
                <select id="category_id" name="category_id"
                    class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">Odaberi kategoriju</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $book->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3 mb-4">
                <div class="col-6">
                    <label for="total_copies" class="form-label fw-semibold">
                        Ukupno primeraka <span class="text-danger">*</span>
                        @if($activeBorrowed > 0)
                            <small class="text-muted">(min. {{ $activeBorrowed }})</small>
                        @endif
                    </label>
                    <input type="number" id="total_copies" name="total_copies"
                        class="form-control @error('total_copies') is-invalid @enderror"
                        value="{{ old('total_copies', $book->total_copies) }}"
                        min="{{ $activeBorrowed }}" required>
                    @error('total_copies')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-6">
                    <label for="available_copies" class="form-label fw-semibold">Dostupno primeraka <span class="text-danger">*</span></label>
                    <input type="number" id="available_copies" name="available_copies"
                        class="form-control @error('available_copies') is-invalid @enderror"
                        value="{{ old('available_copies', $book->available_copies) }}" min="0" required>
                    @error('available_copies')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="image" class="form-label fw-semibold">Slika naslovnice</label>

                @if($book->imageUrl())
                    <div class="mb-2 d-flex align-items-start gap-3">
                        <img src="{{ $book->imageUrl() }}" alt="{{ $book->title }}"
                            class="rounded border" style="max-height: 140px; max-width: 100px; object-fit: cover;">
                        <div>
                            <div class="text-muted small mb-2">Trenutna slika</div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remove_image"
                                    name="remove_image" value="1">
                                <label class="form-check-label text-danger small" for="remove_image">
                                    Ukloni sliku
                                </label>
                            </div>
                        </div>
                    </div>
                @endif

                <input type="file" id="image" name="image" accept="image/*"
                    class="form-control @error('image') is-invalid @enderror"
                    onchange="previewImage(this)">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">
                    {{ $book->imageUrl() ? 'Odaberi novi fajl samo ako želiš da zamijeniš sliku.' : 'JPEG, PNG, WebP ili GIF, max 2 MB. Nije obavezno.' }}
                </div>
                <img id="image-preview" src="#" alt="Preview" class="mt-3 rounded border d-none"
                    style="max-height: 200px; max-width: 100%; object-fit: contain;">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-floppy me-1"></i>Ažuriraj
                </button>
                <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">Otkaži</a>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    if (input.files && input.files[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
        preview.classList.remove('d-none');
    } else {
        preview.classList.add('d-none');
    }
}
</script>
@endpush
@endsection
