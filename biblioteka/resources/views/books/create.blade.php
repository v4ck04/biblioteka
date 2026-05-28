@extends('layouts.admin')

@section('title', 'Dodaj knjigu')

@section('content')

<div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.375rem;">
    <a href="{{ route('admin.books.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h2 class="page-title">Dodaj novu knjigu</h2>
        <p class="page-sub">Unesite podatke o novoj knjizi</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-7 col-xl-6">
        <div class="card">
            <div class="card-body" style="padding:1.5rem;">
                <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Naslov <span style="color:var(--danger);">*</span></label>
                        <input type="text" id="title" name="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}"
                            placeholder="Unesite naslov knjige"
                            required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Autor <span style="color:var(--danger);">*</span></label>
                        <input type="text" id="author" name="author"
                            class="form-control @error('author') is-invalid @enderror"
                            value="{{ old('author') }}"
                            placeholder="Ime i prezime autora"
                            required>
                        @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategorija <span style="color:var(--danger);">*</span></label>
                        <select id="category_id" name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Odaberi kategoriju</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label for="total_copies" class="form-label">Ukupno primeraka <span style="color:var(--danger);">*</span></label>
                            <input type="number" id="total_copies" name="total_copies"
                                class="form-control @error('total_copies') is-invalid @enderror"
                                value="{{ old('total_copies', 1) }}" min="0" required>
                            @error('total_copies')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-6">
                            <label for="available_copies" class="form-label">Dostupno primeraka <span style="color:var(--danger);">*</span></label>
                            <input type="number" id="available_copies" name="available_copies"
                                class="form-control @error('available_copies') is-invalid @enderror"
                                value="{{ old('available_copies', 1) }}" min="0" required>
                            @error('available_copies')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label">Slika naslovnice</label>
                        <input type="file" id="image" name="image" accept="image/*"
                            class="form-control @error('image') is-invalid @enderror"
                            onchange="previewImage(this)">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">JPEG, PNG, WebP · max 2 MB · nije obavezno</div>
                        <img id="image-preview" src="#" alt="Preview"
                            class="mt-3 rounded d-none"
                            style="max-height:200px;max-width:100%;object-fit:contain;border:1px solid var(--line-1);">
                    </div>

                    <div style="display:flex;gap:.5rem;padding-top:.875rem;border-top:1px solid var(--line-1);">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-floppy"></i>Sačuvaj knjigu
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
