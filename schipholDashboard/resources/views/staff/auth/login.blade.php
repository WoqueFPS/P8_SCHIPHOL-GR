<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schiphol Dashboard</title>
    <link rel="icon" href="{{ asset('images/logo/schiphol.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Expires" content="0">
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    @vite(['resources/js/staff-login.js'])
</head>
<body>

    {{-- achtergrond elementen --}}
    <div class="runway-bg" aria-hidden="true">
        <div class="runway-grid"></div>
        <div class="runway-line runway-line--1"></div>
        <div class="runway-line runway-line--2"></div>
        <div class="runway-line runway-line--3"></div>
        <canvas id="radar-canvas"></canvas>
    </div>

    {{-- statusbalk bovenin --}}
    <header class="status-bar">
        <div class="status-bar__left">
            <span class="status-dot" aria-hidden="true"></span>
            <span>AMS EHAM OPERATIONEEL</span>
        </div>
        <div class="status-bar__center">
            <span id="clock">--:--:-- UTC</span>
            <span class="status-bar__sep" aria-hidden="true">//</span>
            <span id="dateline">-- --- ----</span>
        </div>
        <div class="status-bar__right">
            <span>WIND 230° / 14kt</span>
            <span class="status-bar__sep" aria-hidden="true">//</span>
            <span>VIS &gt;10KM</span>
        </div>
    </header>

    <main class="login-wrapper">

        {{-- Loginkaart --}}
        <div class="login-card">

            {{-- !!!hier komt logo!!! --}}
            <div class="login-card__header">
                <div class="schiphol-logo">

                </div>
                <div>
                    <span class="brand-name">SCHIPHOL</span>
                    <span class="brand-sub">OPERATIONS DASHBOARD</span>
                </div>
            </div>

            <div class="login-card__divider">
                <span class="divider-tag">SEC-AUTH // MEDEWERKERS TOEGANG</span>
            </div>

            {{-- foutmeldingen --}}
            @if ($errors->any())
                <div class="alert alert--error" role="alert">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert--error" role="alert">{{ session('error') }}</div>
            @endif

            {{-- formulier --}}
            <form method="POST" action="{{ route('staff.login') }}" novalidate>
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">
                        <span class="label-tag">01</span>
                        Medewerkers e-mailadres
                    </label>
                    <div class="form-input-wrap">
                        <input
                            class="form-input @error('email') form-input--error @enderror"
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            autofocus
                            required
                            placeholder="naam@schiphol.nl">
                        <span class="input-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="3" y="5" width="18" height="14" rx="2"/>
                                <polyline points="3 7 12 13 21 7"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">
                        <span class="label-tag">02</span>
                        Wachtwoord
                    </label>
                    <div class="form-input-wrap">
                        <input
                            class="form-input @error('password') form-input--error @enderror"
                            type="password"
                            id="password"
                            name="password"
                            autocomplete="current-password"
                            required
                            placeholder="••••••••••••">
                        <button type="button" class="input-icon input-icon--btn" id="togglePw" aria-label="Wachtwoord tonen">
                            <svg id="eyeOpen" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eyeClosed" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="display:none">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="form-checkbox">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="checkbox-box" aria-hidden="true"></span>
                        <span>Sessie onthouden</span>
                    </label>
                </div>
                <button type="submit" class="btn-login" id="submitBtn">
                    <span class="btn-login__text">Toegang verkrijgen</span>
                    <span class="btn-login__arrow" aria-hidden="true">→</span>
                    <span class="btn-login__loader" aria-hidden="true"></span>
                </button>
            </form>

            {{-- <textarea name="" id="" cols="30" rows="10"></textarea>erug naar reizigers login --}}
            <div class="login-card__switch">
                Reiziger?
                <a href="{{ route('login') }}">Ga naar de reizigers login</a>
            </div>
            <div class="login-card__footer">
                <span>© {{ date('Y') }} Royal Schiphol Group</span>
                <span class="footer-sep" aria-hidden="true">·</span>
                <a href="#" class="footer-link">Privacybeleid</a>
                <span class="footer-sep" aria-hidden="true">·</span>
                <a href="#" class="footer-link">Ondersteuning</a>
            </div>
        </div>

        {{-- statuspaneel --}}
        <aside class="login-aside" aria-label="Systeem status">
            <div class="aside-block">
                <div class="aside-block__label">SYSTEEM STATUS</div>
                <div class="aside-metric">
                    <div class="metric-dot metric-dot--green" aria-hidden="true"></div>
                    <span>OPS Dashboard</span>
                    <span class="metric-val metric-val--ok">ONLINE</span>
                </div>
                <div class="aside-metric">
                    <div class="metric-dot metric-dot--green" aria-hidden="true"></div>
                    <span>Vluchtdata API</span>
                    <span class="metric-val metric-val--ok">SYNC</span>
                </div>
                <div class="aside-metric">
                    <div class="metric-dot metric-dot--amber" aria-hidden="true"></div>
                    <span>Gate Systeem</span>
                    <span class="metric-val metric-val--warn">ONDERHOUD</span>
                </div>
                <div class="aside-metric">
                    <div class="metric-dot metric-dot--green" aria-hidden="true"></div>
                    <span>Security Module</span>
                    <span class="metric-val metric-val--ok">ACTIEF</span>
                </div>
            </div>

            <div class="aside-block">
                <div class="aside-block__label">TOEGANGSNIVEAUS</div>
                <div class="aside-role aside-role--coordinator">
                    <span class="role-badge">COORD</span>
                    <div>
                        <div class="role-name">Vluchtcoordinator</div>
                        <div class="role-desc">Vluchtbeheer, gates, planning</div>
                    </div>
                </div>
                <div class="aside-role aside-role--directeur">
                    <span class="role-badge role-badge--gold" style="background-color:#4a9e65;">DIR</span>
                    <div>
                        <div class="role-name">Directeur</div>
                        <div class="role-desc">Rapportages, analytics, alles</div>
                    </div>
                </div>
            </div>

            <div class="aside-block aside-block--notice">
                <div class="aside-block__label">OPERATIONELE MEDEDELING</div>
                <p class="aside-notice">Runway 36L gesloten 06:00–08:00 LT. Gebruik 36C voor zwaar verkeer.</p>
            </div>
        </aside>

    </main>
</body>
</html>