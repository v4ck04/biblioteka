<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava – Biblioteka Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            background: #080E1C;
            -webkit-font-smoothing: antialiased;
            overflow: hidden;
        }

        /* ─── LEFT PANEL ─────────────────────────── */
        .login-left {
            flex: 0 0 480px;
            background: linear-gradient(160deg, #0C1829 0%, #0F1E35 40%, #102040 100%);
            border-right: 1px solid rgba(255,255,255,.06);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.5rem 3rem;
            position: relative;
            overflow: hidden;
        }

        /* Background mesh orbs */
        .left-orb-1 {
            position: absolute;
            top: -80px; left: -60px;
            width: 320px; height: 320px;
            background: radial-gradient(circle, rgba(37,99,235,.22) 0%, transparent 65%);
            border-radius: 50%;
            pointer-events: none;
        }

        .left-orb-2 {
            position: absolute;
            bottom: -60px; right: -60px;
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(124,58,237,.18) 0%, transparent 65%);
            border-radius: 50%;
            pointer-events: none;
        }

        .left-orb-3 {
            position: absolute;
            top: 50%; left: 55%;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(16,185,129,.1) 0%, transparent 65%);
            border-radius: 50%;
            pointer-events: none;
        }

        /* Subtle dot grid */
        .left-grid {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
        }

        .left-content { position: relative; z-index: 1; }

        /* Brand */
        .login-brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 3rem;
        }

        .login-brand-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, #2563EB, #3B82F6);
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.1rem;
            box-shadow: 0 4px 16px rgba(37,99,235,.55);
        }

        .login-brand-name {
            font-size: 1.1rem;
            font-weight: 800;
            color: #F1F5F9;
            letter-spacing: -.02em;
        }

        .login-brand-sub {
            font-size: .65rem;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        /* Hero text */
        .login-hero-label {
            font-size: .7rem;
            font-weight: 700;
            color: rgba(255,255,255,.35);
            text-transform: uppercase;
            letter-spacing: .12em;
            margin-bottom: .875rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .login-hero-label::before {
            content: '';
            display: block;
            width: 20px; height: 2px;
            background: #2563EB;
            border-radius: 1px;
        }

        .login-hero-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #F1F5F9;
            letter-spacing: -.05em;
            line-height: 1.1;
            margin-bottom: 1.25rem;
        }

        .login-hero-title span {
            background: linear-gradient(135deg, #60A5FA 0%, #818CF8 50%, #A78BFA 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-hero-sub {
            font-size: .9rem;
            color: rgba(255,255,255,.38);
            line-height: 1.7;
            max-width: 320px;
            margin-bottom: 2.5rem;
        }

        /* Feature list */
        .login-features {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: .75rem;
        }

        .login-feature {
            display: flex;
            align-items: center;
            gap: .75rem;
            font-size: .835rem;
            color: rgba(255,255,255,.45);
            font-weight: 500;
        }

        .login-feature-dot {
            width: 28px; height: 28px;
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-size: .8rem;
            flex-shrink: 0;
        }

        /* Footer */
        .left-footer {
            position: relative; z-index: 1;
        }

        .left-footer p {
            font-size: .72rem;
            color: rgba(255,255,255,.18);
            margin: 0;
        }

        /* ─── RIGHT PANEL ────────────────────────── */
        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #080E1C;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        /* Right bg orbs */
        .right-orb-1 {
            position: absolute;
            top: 10%; right: -100px;
            width: 350px; height: 350px;
            background: radial-gradient(circle, rgba(37,99,235,.08) 0%, transparent 65%);
            border-radius: 50%;
            pointer-events: none;
        }

        .right-orb-2 {
            position: absolute;
            bottom: 5%; left: -80px;
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(124,58,237,.07) 0%, transparent 65%);
            border-radius: 50%;
            pointer-events: none;
        }

        /* Login card */
        .login-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            background: rgba(255,255,255,.04);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,.09);
            border-radius: 20px;
            padding: 2.5rem 2.25rem;
            box-shadow:
                0 8px 40px rgba(0,0,0,.5),
                0 1px 0 rgba(255,255,255,.07) inset,
                0 -1px 0 rgba(0,0,0,.2) inset;
        }

        .login-card-title {
            font-size: 1.375rem;
            font-weight: 800;
            color: #F1F5F9;
            letter-spacing: -.035em;
            margin-bottom: .25rem;
        }

        .login-card-sub {
            font-size: .8rem;
            color: #475569;
            font-weight: 500;
            margin-bottom: 1.875rem;
        }

        /* Fields */
        .field-label {
            display: block;
            font-size: .72rem;
            font-weight: 700;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: .07em;
            margin-bottom: .4rem;
        }

        .field-input {
            width: 100%;
            background: rgba(255,255,255,.06) !important;
            border: 1px solid rgba(255,255,255,.09) !important;
            border-radius: 10px !important;
            color: #F1F5F9 !important;
            font-size: .875rem !important;
            padding: .675rem .9rem !important;
            font-family: inherit;
            transition: all .18s ease;
            outline: none;
        }

        .field-input::placeholder { color: #334155 !important; }

        .field-input:hover {
            border-color: rgba(255,255,255,.14) !important;
        }

        .field-input:focus {
            background: rgba(37,99,235,.1) !important;
            border-color: rgba(59,130,246,.5) !important;
            box-shadow: 0 0 0 3px rgba(37,99,235,.15) !important;
            color: #F1F5F9 !important;
        }

        .field-input.is-invalid {
            border-color: rgba(239,68,68,.55) !important;
            box-shadow: 0 0 0 3px rgba(239,68,68,.1) !important;
        }

        .field-error {
            font-size: .75rem;
            color: #F87171;
            margin-top: .3rem;
            display: block;
        }

        .form-check-label {
            color: #475569;
            font-size: .82rem;
        }

        .form-check-input {
            background-color: rgba(255,255,255,.06);
            border-color: rgba(255,255,255,.15);
        }

        .form-check-input:checked {
            background-color: #2563EB;
            border-color: #2563EB;
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: .725rem 1rem;
            background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: .9rem;
            font-weight: 700;
            letter-spacing: -.01em;
            cursor: pointer;
            transition: all .2s ease;
            display: flex; align-items: center; justify-content: center;
            gap: .5rem;
            font-family: inherit;
            box-shadow: 0 4px 16px rgba(37,99,235,.5), 0 1px 0 rgba(255,255,255,.1) inset;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(37,99,235,.6), 0 1px 0 rgba(255,255,255,.1) inset;
        }

        .btn-submit:active {
            transform: scale(.98) translateY(0);
        }

        .login-divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,.07);
            margin: 1.5rem 0 1.125rem;
        }

        .back-link {
            color: #334155;
            font-size: .78rem;
            font-weight: 500;
            text-decoration: none;
            display: flex; align-items: center; justify-content: center;
            gap: .4rem;
            transition: color .15s;
        }

        .back-link:hover { color: #64748B; }

        /* Hide left panel on mobile */
        @media (max-width: 860px) {
            .login-left { display: none; }
            body { overflow: auto; }
            .login-right { min-height: 100vh; }
        }
    </style>
</head>
<body>

{{-- ═══ LEFT PANEL ═══ --}}
<div class="login-left">
    <div class="left-orb-1"></div>
    <div class="left-orb-2"></div>
    <div class="left-orb-3"></div>
    <div class="left-grid"></div>

    <div class="left-content">
        <div class="login-brand">
            <div class="login-brand-icon"><i class="bi bi-book-half"></i></div>
            <div>
                <div class="login-brand-name">Biblioteka</div>
                <div class="login-brand-sub">Admin Panel</div>
            </div>
        </div>

        <div class="login-hero-label">Dobrodošli</div>
        <h1 class="login-hero-title">
            Upravljajte<br><span>bibliotekom</span><br>sa lakoćom.
        </h1>
        <p class="login-hero-sub">
            Sistem za evidenciju knjiga i pozajmica dizajniran za efikasno upravljanje bibliotekom.
        </p>

        <ul class="login-features">
            <li class="login-feature">
                <div class="login-feature-dot" style="background:rgba(37,99,235,.15);">
                    <i class="bi bi-journals" style="color:#60A5FA;"></i>
                </div>
                Evidencija knjiga i kategorija
            </li>
            <li class="login-feature">
                <div class="login-feature-dot" style="background:rgba(16,185,129,.12);">
                    <i class="bi bi-clock-history" style="color:#34D399;"></i>
                </div>
                Praćenje pozajmica u realnom vremenu
            </li>
            <li class="login-feature">
                <div class="login-feature-dot" style="background:rgba(239,68,68,.12);">
                    <i class="bi bi-exclamation-triangle" style="color:#F87171;"></i>
                </div>
                Upozorenja za kasne povrate
            </li>
            <li class="login-feature">
                <div class="login-feature-dot" style="background:rgba(245,158,11,.12);">
                    <i class="bi bi-bar-chart-line" style="color:#FCD34D;"></i>
                </div>
                Pregled i izveštaji o fondu
            </li>
        </ul>
    </div>

    <div class="left-footer">
        <p>&copy; {{ date('Y') }} Gradska Biblioteka. Sva prava zadržana.</p>
    </div>
</div>

{{-- ═══ RIGHT PANEL ═══ --}}
<div class="login-right">
    <div class="right-orb-1"></div>
    <div class="right-orb-2"></div>

    <div class="login-card">
        <h2 class="login-card-title">Prijava</h2>
        <p class="login-card-sub">Unesite vaše podatke za pristup panelu</p>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="field-label">Email adresa</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="field-input @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    placeholder="admin@biblioteka.rs"
                    autofocus
                    required
                >
                @error('email')
                    <span class="field-error"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="field-label">Lozinka</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="field-input @error('password') is-invalid @enderror"
                    placeholder="••••••••"
                    required
                >
                @error('password')
                    <span class="field-error"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 form-check" style="padding-left:0; display:flex; align-items:center; gap:.5rem;">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" style="margin:0; flex-shrink:0;">
                <label class="form-check-label" for="remember">Zapamti me</label>
            </div>

            <button type="submit" class="btn-submit">
                <i class="bi bi-box-arrow-in-right"></i>
                Prijavi se
            </button>

        </form>

        <hr class="login-divider">

        <a href="{{ route('home') }}" class="back-link">
            <i class="bi bi-arrow-left"></i>
            Nazad na sajt biblioteke
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
