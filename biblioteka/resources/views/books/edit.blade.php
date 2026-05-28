@extends('layouts.admin')

@section('title', 'Izmeni knjigu')

@section('content')

<div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.375rem;">
    <a href="{{ route('admin.books.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h2 class="page-title">Izmeni knjigu</h2>
        <p class="page-sub">{{ $book->title }}</p>
    </div>
</div>

@php $activeBorrowed = $book->activeBorrowingsCount(); @endphp

@if($activeBorrowed > 0)
<div class="alert alert-info mb-4">
    <i class="bi bi-info-circle-fill"></i>
    Ova knjiga ima <strong>{{ $activeBorrowed }}</strong> aktivnih pozajmica.
    Ukupan broj primeraka ne može biti manji od tog broja.
</div>
@endif

<div class="row">
    <div class="col-lg-7 col-xl-6">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Naslov <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $book->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Autor <span class="text-danger">*</span></label>
                        <input type="text" id="author" name="author"
                            class="form-control @error('author') is-invalid @enderror"
                            value="{{ old('author', $book->author) }}" required>
                        @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategorija <span class="text-danger">*</span></label>
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

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label for="total_copies" class="form-label">
                                Ukupno primeraka <span class="text-danger">*</span>
                                @if($activeBorrowed > 0)
                                    <span class="text-muted fw-normal">(min. {{ $activeBorrowed }})</span>
                                @endif
                            </label>
                            <input type="number" id="total_copies" name="total_copies"
                                class="form-control @error('total_copies') is-invalid @enderror"
                                value="{{ old('total_copies', $book->total_copies) }}"
                                min="{{ $activeBorrowed }}" required>
                            @error('total_copies')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-6">
                            <label for="available_copies" class="form-label">Dostupno primeraka <span class="text-danger">*</span></label>
                            <input type="number" id="available_copies" name="available_copies"
                                class="form-control @error('available_copies') is-invalid @enderror"
                                value="{{ old('available_copies', $book->available_copies) }}" min="0" required>
                            @error('available_copies')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label">Slika naslovnice</label>

                        @if($book->imageUrl())
                            <div class="mb-3 p-3 rounded d-flex align-items-start gap-3"
                                 style="background:rgba(15,18,40,0.03);border:1px solid var(--line-1);">
                                <img src="{{ $book->imageUrl() }}" alt="{{ $book->title }}"
                                    class="rounded" style="max-height:110px;max-width:80px;object-fit:cover;">
                                <div>
                                    <div class="text-muted mb-2" style="font-size:.76rem;font-weight:600;text-transform:uppercase;letter-spacing:.04em;">Trenutna slika</div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remove_image"
                                            name="remove_image" value="1">
                                        <label class="form-check-label" for="remove_image"
                                               style="font-size:.8rem;color:var(--danger);">
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
                            {{ $book->imageUrl() ? 'Odaberi novi fajl samo ako želiš da zamijeniš sliku.' : 'JPEG, PNG, WebP ili GIF · max 2 MB · nije obavezno.' }}
                        </div>
                        <img id="image-preview" src="#" alt="Preview"
                            class="mt-3 rounded d-none"
                            style="max-height:200px;max-width:100%;object-fit:contain;border:1px solid var(--line-1);">
                    </div>

                    <div class="d-flex gap-2 pt-2 border-top" style="border-color:var(--line-1)!important;">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-floppy"></i>Ažuriraj
                        </button>
                        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">Otkaži</a>
                    </div>

                </form>
            </div>
        </div>
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
