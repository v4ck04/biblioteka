<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') – Biblioteka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #212529; }
        .sidebar .nav-link { color: #adb5bd; padding: .5rem 1rem; border-radius: .375rem; margin-bottom: .125rem; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background-color: #343a40; }
        .sidebar .nav-link i { width: 1.25rem; }
        .sidebar-heading { color: #6c757d; font-size: .7rem; text-transform: uppercase; letter-spacing: .08em; padding: .75rem 1rem .25rem; }
        .main-content { min-height: 100vh; }
        .overdue-row { background-color: #fff3f3 !important; }
    </style>
</head>
<body>
<div class="d-flex">

    {{-- Sidebar --}}
    <nav class="sidebar d-flex flex-column flex-shrink-0 p-3" style="width: 240px;">
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 text-white text-decoration-none">
            <i class="bi bi-book-half fs-4 me-2"></i>
            <span class="fw-semibold fs-5">Biblioteka</span>
        </a>
        <hr class="border-secondary">

        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>

            <div class="sidebar-heading mt-2">Knjige</div>
            <li>
                <a href="{{ route('admin.books.index') }}"
                   class="nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                    <i class="bi bi-book me-2"></i>Sve knjige
                </a>
            </li>
            <li>
                <a href="{{ route('admin.books.create') }}"
                   class="nav-link">
                    <i class="bi bi-plus-circle me-2"></i>Dodaj knjigu
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}"
                   class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tag me-2"></i>Kategorije
                </a>
            </li>

            <div class="sidebar-heading mt-2">Pozajmice</div>
            <li>
                <a href="{{ route('admin.borrowings.index') }}"
                   class="nav-link {{ request()->routeIs('admin.borrowings.index') ? 'active' : '' }}">
                    <i class="bi bi-clock me-2"></i>Aktivne
                </a>
            </li>
            <li>
                <a href="{{ route('admin.borrowings.overdue') }}"
                   class="nav-link {{ request()->routeIs('admin.borrowings.overdue') ? 'active' : '' }}">
                    <i class="bi bi-exclamation-triangle me-2 text-danger"></i>Kasne
                </a>
            </li>
            <li>
                <a href="{{ route('admin.borrowings.all') }}"
                   class="nav-link {{ request()->routeIs('admin.borrowings.all') ? 'active' : '' }}">
                    <i class="bi bi-list-ul me-2"></i>Istorija
                </a>
            </li>
            <li>
                <a href="{{ route('admin.borrowings.create') }}"
                   class="nav-link">
                    <i class="bi bi-plus-circle me-2"></i>Nova pozajmica
                </a>
            </li>
        </ul>

        <hr class="border-secondary">
        <div class="text-secondary small mb-2">{{ Auth::user()->name }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary btn-sm w-100">
                <i class="bi bi-box-arrow-right me-1"></i>Odjavi se
            </button>
        </form>
    </nav>

    {{-- Main content --}}
    <div class="main-content flex-grow-1 p-4">
        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
