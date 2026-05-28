@extends('layouts.public')

@section('title', 'Zahtev primljen')

@section('content')

<div class="gb-confirm-wrap">

    {{-- Check icon --}}
    <div class="gb-confirm-icon">
        <i class="bi bi-check-lg" style="font-size:2rem;"></i>
    </div>

    <h1 style="font-family:'Cormorant Garamond',serif; font-size:2.2rem; font-weight:700;
               color:var(--gb-ink); margin-bottom:.5rem; line-height:1.2;">
        Vaš zahtev je uspešno poslat
    </h1>
    <p style="font-size:.9rem; color:var(--gb-ink-4); margin-bottom:2rem; max-width:380px; margin-left:auto; margin-right:auto;">
        Bibliotekar će vas kontaktirati u roku od 24 sata.
        Hvala što koristite Gradsku biblioteku.
    </p>

    {{-- Progress steps --}}
    <div class="gb-steps mb-4">
        <div class="gb-step">
            <div class="gb-step-dot done">
                <i class="bi bi-check" style="font-size:.75rem;"></i>
            </div>
            <div class="gb-step-lbl done">Zahtev poslat</div>
        </div>
        <div class="gb-step-line done"></div>
        <div class="gb-step">
            <div class="gb-step-dot active">2</div>
            <div class="gb-step-lbl active">Na čekanju</div>
        </div>
        <div class="gb-step-line"></div>
        <div class="gb-step">
            <div class="gb-step-dot wait">3</div>
            <div class="gb-step-lbl wait">Preuzimanje</div>
        </div>
    </div>

    {{-- Confirmation card --}}
    <div class="gb-confirm-card">
        <div class="gb-confirm-ref">{{ $data['ref'] }}</div>

        <div class="gb-confirm-row">
            <span class="gb-confirm-key">Knjiga</span>
            <span class="gb-confirm-val">{{ $data['book_title'] }}</span>
        </div>
        <div class="gb-confirm-row">
            <span class="gb-confirm-key">Autor</span>
            <span class="gb-confirm-val">{{ $data['book_author'] }}</span>
        </div>
        <div class="gb-confirm-row">
            <span class="gb-confirm-key">Podnosilac</span>
            <span class="gb-confirm-val">{{ $data['reader_name'] }}</span>
        </div>
        <div class="gb-confirm-row">
            <span class="gb-confirm-key">Kontakt</span>
            <span class="gb-confirm-val">{{ $data['contact'] }}</span>
        </div>
        <div class="gb-confirm-row">
            <span class="gb-confirm-key">Status</span>
            <span class="gb-confirm-val" style="color:var(--gb-amber);">
                <i class="bi bi-clock me-1"></i>Na čekanju
            </span>
        </div>
    </div>

    <p style="font-size:.8rem; color:var(--gb-ink-4); margin-bottom:1.5rem;">
        Sačuvaj referentni broj <strong style="color:var(--gb-forest);">{{ $data['ref'] }}</strong>
        i donesi ga kada dođeš po knjigu.
    </p>

    <div class="d-flex gap-2 justify-content-center flex-wrap">
        <a href="{{ route('katalog') }}" class="gb-btn gb-btn-forest">
            <i class="bi bi-arrow-left"></i>
            Nazad na katalog
        </a>
        <a href="{{ route('katalog') }}" class="gb-btn gb-btn-outline">
            <i class="bi bi-journals"></i>
            Vidi još knjiga
        </a>
    </div>

</div>

@endsection
