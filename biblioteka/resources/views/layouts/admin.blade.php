<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') – Biblioteka</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-theme.css') }}">
</head>
<body>

<div class="bg-mesh" aria-hidden="true"></div>
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

{{-- ═══════════ SIDEBAR ═══════════ --}}
<aside class="sidebar" id="sidebar">

    <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <i class="bi bi-book-half"></i>
        </div>
        <div>
            <span class="sidebar-logo-name">Biblioteka</span>
            <span class="sidebar-logo-sub">Admin Panel</span>
        </div>
    </a>

    <nav class="sidebar-nav">

        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2 si"></i>Dashboard
        </a>

        <div class="sidebar-section">Knjige</div>

        <a href="{{ route('admin.books.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.books.index') ? 'active' : '' }}">
            <i class="bi bi-journals si"></i>Sve knjige
        </a>
        <a href="{{ route('admin.books.create') }}"
           class="sidebar-link {{ request()->routeIs('admin.books.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle si"></i>Dodaj knjigu
        </a>
        <a href="{{ route('admin.categories.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-bookmark si"></i>Kategorije
        </a>

        <div class="sidebar-section">Pozajmice</div>

        <a href="{{ route('admin.borrowings.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.borrowings.index') ? 'active' : '' }}">
            <i class="bi bi-clock si"></i>Aktivne
        </a>
        <a href="{{ route('admin.borrowings.overdue') }}"
           class="sidebar-link link-danger {{ request()->routeIs('admin.borrowings.overdue') ? 'active' : '' }}">
            <i class="bi bi-exclamation-triangle si"></i>Kasne
        </a>
        <a href="{{ route('admin.borrowings.all') }}"
           class="sidebar-link {{ request()->routeIs('admin.borrowings.all') ? 'active' : '' }}">
            <i class="bi bi-list-ul si"></i>Istorija
        </a>
        <a href="{{ route('admin.borrowings.create') }}"
           class="sidebar-link {{ request()->routeIs('admin.borrowings.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle si"></i>Nova pozajmica
        </a>

        <div class="sidebar-section">Čitaoci</div>

        <a href="{{ route('admin.requests.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.requests.*') ? 'active' : '' }}">
            <i class="bi bi-send si"></i>Zahtevi
            @if($pendingRequestsCount > 0)
                <span class="sidebar-badge">
                    {{ $pendingRequestsCount > 99 ? '99+' : $pendingRequestsCount }}
                </span>
            @endif
        </a>

    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user-row">
            <div class="sidebar-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
            <span class="sidebar-username">{{ Auth::user()->name }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i>Odjavi se
            </button>
        </form>
    </div>

</aside>

{{-- ═══════════ MAIN WRAPPER ═══════════ --}}
<div class="main-wrapper">

    <div class="main-topbar">
        <div class="topbar-left">
            <button class="nav-toggle" onclick="openSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <i class="bi bi-book-half" style="color:var(--primary);font-size:.85rem;"></i>
            <span>Biblioteka</span>
            <i class="bi bi-chevron-right" style="font-size:.55rem;opacity:.35;margin:0 .1rem;"></i>
            <span style="color:var(--ink-1);font-weight:700;">@yield('title', 'Admin')</span>
        </div>
        <div class="topbar-right">

            {{-- ── Bell notification ── --}}
            <div class="notif-wrap" id="notifWrap">
                <button class="notif-btn" id="notifBtn" title="Zahtevi čitalaca">
                    <i class="bi bi-bell"></i>
                    @if($pendingRequestsCount > 0)
                        <span class="notif-badge">
                            {{ $pendingRequestsCount > 99 ? '99+' : $pendingRequestsCount }}
                        </span>
                    @endif
                </button>

                <div class="notif-dropdown" id="notifDropdown">
                    <div class="notif-head">
                        <span class="notif-head-title">Zahtevi čitalaca</span>
                        @if($pendingRequestsCount > 0)
                            <span class="notif-head-count">{{ $pendingRequestsCount }} na čekanju</span>
                        @endif
                    </div>

                    @if($recentPendingRequests->isEmpty())
                        <div class="notif-empty">
                            <i class="bi bi-bell-slash" style="font-size:1.5rem;opacity:.2;display:block;margin-bottom:.5rem;"></i>
                            Nema novih zahteva
                        </div>
                    @else
                        @foreach($recentPendingRequests as $req)
                        <a href="{{ route('admin.requests.index') }}" class="notif-item">
                            <div class="notif-dot"></div>
                            <div>
                                <div class="notif-name">{{ $req->reader_name }}</div>
                                <div class="notif-meta">
                                    {{ $req->book->title ?? '—' }}
                                    &middot; {{ $req->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                        @endforeach
                    @endif

                    <div class="notif-footer">
                        <a href="{{ route('admin.requests.index') }}">Vidi sve zahteve →</a>
                    </div>
                </div>
            </div>

            <div class="topbar-user-pill">
                <div class="topbar-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <span class="topbar-name">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </div>

    <main class="main-content">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-x-circle-fill"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openSidebar() {
        document.getElementById('sidebar').classList.add('show');
        document.getElementById('sidebarOverlay').classList.add('show');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('show');
        document.getElementById('sidebarOverlay').classList.remove('show');
    }

    // ── Notification bell ──────────────────────────────────────
    (function () {
        const btn      = document.getElementById('notifBtn');
        const dropdown = document.getElementById('notifDropdown');
        const wrap     = document.getElementById('notifWrap');

        if (!btn) return;

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('open');
        });

        document.addEventListener('click', function (e) {
            if (!wrap.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') dropdown.classList.remove('open');
        });
    })();
</script>
@stack('scripts')
</body>
</html>

