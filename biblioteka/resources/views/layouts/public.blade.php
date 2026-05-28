<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Početna') – Gradska biblioteka</title>
    <meta name="description" content="@yield('meta_desc', 'Katalog knjiga Gradske biblioteke. Pronađite, rezervišite i pozajmite knjige.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/biblioteka.css') }}">
    @stack('head')
</head>
<body>

{{-- ═══════════ NAVBAR ═══════════ --}}
<nav class="gb-nav">
    <div class="container">
        <div class="gb-nav-inner">
            <a href="{{ route('home') }}" class="gb-brand">
                <span class="gb-brand-name">Gradska biblioteka</span>
                <span class="gb-brand-sub">Otvorena vrata znanja</span>
            </a>

            <button class="gb-nav-toggle" id="nav-toggle" aria-label="Meni">
                <i class="bi bi-list"></i>
            </button>

            <div class="gb-nav-menu" id="nav-menu">
                <ul class="gb-nav-links">
                    <li>
                        <a href="{{ route('home') }}"
                           class="gb-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                            Početna
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('katalog') }}"
                           class="gb-nav-link {{ request()->routeIs('katalog') ? 'active' : '' }}">
                            Katalog
                        </a>
                    </li>
                </ul>

                <div class="gb-nav-divider"></div>

                <a href="{{ route('login') }}" class="gb-nav-admin">
                    <i class="bi bi-lock" style="font-size:.75rem;"></i>
                    Bibliotekar
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- ═══════════ FLASH MESSAGES ═══════════ --}}
@if(session('error'))
<div class="container mt-3">
    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3" role="alert"
         style="font-size:.88rem; font-family:'Manrope',sans-serif;">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

{{-- ═══════════ CONTENT ═══════════ --}}
@yield('content')

{{-- ═══════════ FOOTER ═══════════ --}}
<footer class="gb-footer">
    <div class="container">
        <div class="row g-5">

            <div class="col-lg-4">
                <div class="gb-footer-brand-name">Gradska biblioteka</div>
                <div class="gb-footer-brand-sub">Otvorena vrata znanja</div>
                <p class="gb-footer-desc">
                    Bogat fond knjiga iz svih žanrova, ljubazno osoblje i ugodan prostor za čitanje.
                    Vaš prozor u svet znanja i mašte.
                </p>
            </div>

            <div class="col-lg-3 col-6">
                <div class="gb-footer-head">Kontakt</div>
                <div class="gb-footer-item">
                    <i class="bi bi-geo-alt"></i>
                    <span>Ulica knjiga 1, Beograd</span>
                </div>
                <div class="gb-footer-item">
                    <i class="bi bi-telephone"></i>
                    <span>+381 11 123 456</span>
                </div>
                <div class="gb-footer-item">
                    <i class="bi bi-envelope"></i>
                    <span>info@biblioteka.rs</span>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="gb-footer-head">Radno vreme</div>
                <div class="gb-footer-item">
                    <i class="bi bi-clock"></i>
                    <div>
                        <div><strong style="color:rgba(255,255,255,.55);">Pon – Pet:</strong> 08:00 – 20:00</div>
                        <div><strong style="color:rgba(255,255,255,.55);">Subota:</strong> 09:00 – 16:00</div>
                        <div><strong style="color:rgba(255,255,255,.55);">Nedelja:</strong> Zatvoreno</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-6">
                <div class="gb-footer-head">Pristup</div>
                <a href="{{ route('login') }}" class="gb-footer-link">
                    <i class="bi bi-shield-lock me-1"></i>Pristup za bibliotekare
                </a>
                <a href="{{ route('katalog') }}" class="gb-footer-link">
                    <i class="bi bi-journals me-1"></i>Katalog knjiga
                </a>
            </div>

        </div>

        <hr class="gb-footer-divider">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="gb-footer-copy">&copy; {{ date('Y') }} Gradska biblioteka. Sva prava zadržana.</span>
            <a href="{{ route('login') }}" class="gb-footer-access">
                <i class="bi bi-lock me-1"></i>Pristup za bibliotekare
            </a>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Mobile nav toggle
    document.getElementById('nav-toggle').addEventListener('click', function () {
        document.getElementById('nav-menu').classList.toggle('open');
    });
</script>
@stack('scripts')
</body>
</html>
