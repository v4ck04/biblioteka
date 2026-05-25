<!DOCTYPE html>
<html lang="sr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Biblioteka') – Gradska Biblioteka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #0a2342;
            --primary-mid:  #1565c0;
            --accent:       #e8a838;
        }

        body { font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; }

        /* ── Navbar ─────────────────────────────────── */
        .navbar-brand .brand-icon { font-size: 1.6rem; color: var(--accent); }
        .navbar-brand .brand-text { font-weight: 700; letter-spacing: .02em; }
        .nav-link-custom {
            font-weight: 500;
            padding: .4rem .9rem !important;
            border-radius: .375rem;
            transition: background .15s, color .15s;
        }
        .nav-link-custom:hover, .nav-link-custom.active {
            background: rgba(21, 101, 192, .1);
            color: var(--primary-mid) !important;
        }
        [data-bs-theme="dark"] .nav-link-custom:hover,
        [data-bs-theme="dark"] .nav-link-custom.active {
            background: rgba(255,255,255,.1);
            color: #fff !important;
        }

        /* ── Book cards ─────────────────────────────── */
        .book-card {
            transition: transform .2s ease, box-shadow .2s ease;
            height: 100%;
            border: none;
        }
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .75rem 2rem rgba(0,0,0,.15) !important;
        }
        .book-cover {
            height: 210px;
            object-fit: cover;
            width: 100%;
        }
        .book-cover-placeholder {
            height: 210px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            color: #90a4ae;
        }
        [data-bs-theme="light"] .book-cover-placeholder { background: linear-gradient(135deg, #e8eaf6, #cfd8dc); }
        [data-bs-theme="dark"]  .book-cover-placeholder { background: linear-gradient(135deg, #263238, #37474f); }

        /* ── Hero ───────────────────────────────────── */
        .hero-section {
            background: linear-gradient(135deg, #0a2342 0%, #1565c0 60%, #0d47a1 100%);
            min-height: 480px;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .hero-stat-card {
            background: rgba(255,255,255,.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,.2);
            border-radius: .75rem;
        }

        /* ── Section heading ────────────────────────── */
        .section-heading { position: relative; display: inline-block; }
        .section-heading::after {
            content: '';
            position: absolute; bottom: -6px; left: 0;
            width: 48px; height: 3px;
            background: var(--primary-mid);
            border-radius: 2px;
        }

        /* ── Filter sidebar ─────────────────────────── */
        .filter-card { border: none; border-radius: .75rem; }

        /* ── Footer ─────────────────────────────────── */
        .footer-brand { font-size: 1.25rem; font-weight: 700; }
        .footer-link { color: #90a4ae; text-decoration: none; transition: color .15s; }
        .footer-link:hover { color: #fff; }

        /* ── Pagination ─────────────────────────────── */
        .page-link { border-radius: .375rem !important; margin: 0 2px; }

        /* ── Dark mode toggle ───────────────────────── */
        #theme-toggle { border: none; background: transparent; font-size: 1.15rem; cursor: pointer; }
        [data-bs-theme="light"] #theme-toggle .icon-moon  { display: inline; }
        [data-bs-theme="light"] #theme-toggle .icon-sun   { display: none; }
        [data-bs-theme="dark"]  #theme-toggle .icon-moon  { display: none; }
        [data-bs-theme="dark"]  #theme-toggle .icon-sun   { display: inline; }

        @media (max-width: 576px) {
            .hero-section { min-height: 360px; }
        }
    </style>
    @stack('head')
</head>
<body>

{{-- ═══════════ NAVBAR ═══════════ --}}
<nav class="navbar navbar-expand-lg sticky-top shadow-sm" style="background: var(--bs-body-bg); border-bottom: 1px solid var(--bs-border-color);">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('home') }}">
            <i class="bi bi-book-half brand-icon"></i>
            <span class="brand-text text-dark" style="color: var(--bs-body-color) !important;">Biblioteka</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav mx-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">
                        <i class="bi bi-house me-1"></i>Početna
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->routeIs('books.*') ? 'active' : '' }}"
                       href="{{ route('books.index') }}">
                        <i class="bi bi-journal-text me-1"></i>Knjige
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->is('kontakt') ? 'active' : '' }}"
                       href="#kontakt">
                        <i class="bi bi-envelope me-1"></i>Kontakt
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2">
                <button id="theme-toggle" class="btn btn-sm" title="Promeni temu">
                    <i class="bi bi-moon-stars-fill icon-moon"></i>
                    <i class="bi bi-sun-fill icon-sun text-warning"></i>
                </button>
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-shield-lock me-1"></i>Admin
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- ═══════════ CONTENT ═══════════ --}}
@yield('content')

{{-- ═══════════ FOOTER ═══════════ --}}
<footer id="kontakt" class="bg-dark text-white pt-5 pb-4 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-book-half fs-4" style="color: var(--accent);"></i>
                    <span class="footer-brand">Gradska Biblioteka</span>
                </div>
                <p class="text-secondary small mb-0">
                    Vaš prozor u svet knjiga. Bogat fond knjiga, ljubazno osoblje i ugodan prostor za čitanje i učenje.
                </p>
            </div>

            <div class="col-lg-2 col-6">
                <h6 class="text-uppercase fw-semibold mb-3" style="color: var(--accent); font-size: .75rem; letter-spacing: .1em;">Navigacija</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('home') }}" class="footer-link"><i class="bi bi-chevron-right me-1"></i>Početna</a></li>
                    <li class="mb-2"><a href="{{ route('books.index') }}" class="footer-link"><i class="bi bi-chevron-right me-1"></i>Katalog knjiga</a></li>
                    <li class="mb-2"><a href="#kontakt" class="footer-link"><i class="bi bi-chevron-right me-1"></i>Kontakt</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-6">
                <h6 class="text-uppercase fw-semibold mb-3" style="color: var(--accent); font-size: .75rem; letter-spacing: .1em;">Kontakt</h6>
                <ul class="list-unstyled small text-secondary">
                    <li class="mb-2"><i class="bi bi-geo-alt me-2 text-warning"></i>Ulica knjiga 1, Beograd</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2 text-warning"></i>+381 11 123 456</li>
                    <li class="mb-2"><i class="bi bi-envelope me-2 text-warning"></i>info@biblioteka.rs</li>
                </ul>
            </div>

            <div class="col-lg-3">
                <h6 class="text-uppercase fw-semibold mb-3" style="color: var(--accent); font-size: .75rem; letter-spacing: .1em;">Radno vreme</h6>
                <ul class="list-unstyled small text-secondary">
                    <li class="mb-1"><span class="text-white">Pon – Pet:</span> 08:00 – 20:00</li>
                    <li class="mb-1"><span class="text-white">Subota:</span> 09:00 – 16:00</li>
                    <li class="mb-1"><span class="text-white">Nedelja:</span> Zatvoreno</li>
                </ul>
            </div>
        </div>

        <hr class="border-secondary my-4">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
            <p class="text-secondary small mb-0">&copy; {{ date('Y') }} Gradska Biblioteka. Sva prava zadržana.</p>
            <p class="text-secondary small mb-0">Napravljeno sa <i class="bi bi-heart-fill text-danger"></i> za ljubitelje knjiga</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Dark mode toggle
    const html   = document.documentElement;
    const toggle = document.getElementById('theme-toggle');
    const saved  = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-bs-theme', saved);

    toggle.addEventListener('click', () => {
        const next = html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-bs-theme', next);
        localStorage.setItem('theme', next);
    });
</script>
@stack('scripts')
</body>
</html>
