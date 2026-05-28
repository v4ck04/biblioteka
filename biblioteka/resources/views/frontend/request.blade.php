@extends('layouts.public')

@section('title', 'Zahtev za pozajmicu – ' . $book->title)

@section('content')

@php
    $coverColors = [
        ['#2b4a25','#5c8a50'],['#6b4f3a','#a07455'],['#3d5a7a','#6b8db0'],
        ['#4a2b4a','#7a5078'],['#6b3a1f','#a05c38'],['#1a3a4a','#3d6b7a'],
        ['#3a4a1a','#6b7a3d'],['#4a3a1a','#7a6038'],
    ];
    $ci = $book->id % 8;
    $cc = $coverColors[$ci];
    $words = explode(' ', $book->title);
    $init  = strtoupper($words[0][0] ?? '?');
    if (isset($words[1])) $init .= strtoupper($words[1][0]);
@endphp

<div style="background: var(--gb-cream-2); border-bottom: 1px solid var(--gb-line); padding: 2rem 0 1.75rem;">
    <div class="container">
        <div class="gb-breadcrumb">
            <a href="{{ route('home') }}">Početna</a>
            <span class="gb-breadcrumb-sep"><i class="bi bi-chevron-right" style="font-size:.7rem;"></i></span>
            <a href="{{ route('katalog') }}">Katalog</a>
            <span class="gb-breadcrumb-sep"><i class="bi bi-chevron-right" style="font-size:.7rem;"></i></span>
            <a href="{{ route('knjiga.show', $book) }}">{{ Str::limit($book->title, 30) }}</a>
            <span class="gb-breadcrumb-sep"><i class="bi bi-chevron-right" style="font-size:.7rem;"></i></span>
            <span>Zahtev</span>
        </div>
        <h1 style="font-family:'Cormorant Garamond',serif; font-size:2.2rem; font-weight:700; color:var(--gb-ink); margin:0;">
            Zahtev za pozajmicu
        </h1>
    </div>
</div>

<div class="gb-form-wrap">

    {{-- Book info card --}}
    <div class="gb-form-book-card">
        <div class="gb-form-book-cover">
            @if($book->imageUrl())
                <img src="{{ $book->imageUrl() }}" alt="{{ $book->title }}">
            @else
                <div style="width:100%; height:100%; background: linear-gradient(150deg, {{ $cc[0] }}, {{ $cc[1] }}); display:flex; align-items:center; justify-content:center;">
                    <span style="font-family:'Cormorant Garamond',serif; font-size:1.4rem; font-weight:700; color:rgba(255,255,255,0.9);">{{ $init }}</span>
                </div>
            @endif
        </div>
        <div>
            <div class="gb-form-book-title">{{ $book->title }}</div>
            <div class="gb-form-book-author">{{ $book->author }}</div>
            <span class="gb-avail-badge ok" style="font-size:.72rem;">
                <i class="bi bi-check-circle-fill"></i>
                {{ $book->available_copies }} {{ $book->available_copies == 1 ? 'primerak dostupan' : 'primeraka dostupno' }}
            </span>
        </div>
    </div>

    {{-- Form card --}}
    <div class="gb-form-card">
        <div class="gb-form-title">Vaši podaci</div>
        <div class="gb-form-sub">Popunite formu i bibliotekar će pregledati vaš zahtev.</div>

        <div class="gb-info-box">
            <i class="bi bi-info-circle" style="flex-shrink:0; margin-top:1px;"></i>
            <div>
                Nakon slanja zahteva, poseti biblioteku sa ličnom kartom i referentnim brojem.
                Knjiga se pozajmljuje na <strong>14 dana</strong>.
            </div>
        </div>

        <form method="POST" action="{{ route('requests.store', $book) }}">
            @csrf

            {{-- Ime i prezime --}}
            <div class="gb-field">
                <label class="gb-label" for="reader_name">Ime i prezime *</label>
                <input type="text" id="reader_name" name="reader_name"
                       class="gb-input {{ $errors->has('reader_name') ? 'is-invalid' : '' }}"
                       value="{{ old('reader_name') }}"
                       placeholder="Npr. Marija Petrović"
                       autocomplete="name">
                @error('reader_name')
                    <div class="gb-error"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            {{-- Kontakt --}}
            <div class="gb-field">
                <label class="gb-label" for="contact">Email ili telefon *</label>
                <input type="text" id="contact" name="contact"
                       class="gb-input {{ $errors->has('contact') ? 'is-invalid' : '' }}"
                       value="{{ old('contact') }}"
                       placeholder="Npr. marija@email.rs ili +381 64 123 4567"
                       autocomplete="email">
                @error('contact')
                    <div class="gb-error"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            {{-- Napomena --}}
            <div class="gb-field">
                <label class="gb-label" for="notes">Napomena <span style="font-weight:400; text-transform:none; color:var(--gb-ink-4);">(opciono)</span></label>
                <textarea id="notes" name="notes"
                          class="gb-input gb-textarea {{ $errors->has('notes') ? 'is-invalid' : '' }}"
                          placeholder="Dodaj napomenu za bibliotekara (maks. 280 znakova)…"
                          maxlength="280">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="gb-error"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            {{-- Consent --}}
            <div class="gb-consent">
                <input type="checkbox" id="consent" name="consent" value="1"
                       {{ old('consent') ? 'checked' : '' }}>
                <label for="consent">
                    Saglasan/na sam sa obradom ličnih podataka u svrhu obrade zahteva za pozajmicu knjige.
                    Podaci se neće koristiti u druge svrhe.
                </label>
            </div>
            @error('consent')
                <div class="gb-error" style="margin-top:-.5rem; margin-bottom:.75rem;">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror

            {{-- Buttons --}}
            <div class="d-flex gap-2 flex-wrap" style="margin-top:1.5rem;">
                <button type="submit" class="gb-btn gb-btn-forest">
                    <i class="bi bi-send"></i>
                    Pošalji zahtev
                </button>
                <a href="{{ route('knjiga.show', $book) }}" class="gb-btn gb-btn-outline">
                    <i class="bi bi-arrow-left"></i>
                    Nazad
                </a>
            </div>
        </form>
    </div>

</div>

@endsection
