@extends('layouts.admin')

@section('title', 'Izmeni kategoriju')

@section('content')

<div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.375rem;">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h2 class="page-title">Izmeni kategoriju</h2>
        <p class="page-sub">{{ $category->name }}</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-5 col-xl-4">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="form-label">Naziv kategorije <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $category->name) }}"
                            required autofocus>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2 pt-2 border-top" style="border-color:var(--line-1)!important;">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-floppy"></i>Ažuriraj
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Otkaži</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
