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

<div class="login-admin-page">
    <div class="login-admin-wrap">

        {{-- runway panel --}}
        <aside class="login-admin-runway-panel" aria-hidden="true">
            <div class="login-admin-runway-lights" id="login-admin-runwayLights"></div>

            <div class="login-admin-panel-logo">
                <div class="login-admin-panel-logo-mark">AMS</div>
                <div class="login-admin-panel-logo-sub">Amsterdam Airport</div>
            </div>

            <nav class="login-admin-panel-nav">
                @foreach(['Dashboard', 'Vluchten', 'Gates', 'Personeel', 'Beveiliging'] as $item)
                    <div class="login-admin-nav-item login-admin-nav-item--locked">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        {{ $item }}
                    </div>
                @endforeach
            </nav>

            <div class="login-admin-panel-status">
                <div class="login-admin-status-chip">
                    <div class="login-admin-status-dot"></div>
                    Systeem actief
                </div>
            </div>
        </aside>

        {{-- form panel --}}
        <main class="login-admin-form-panel">
            <p class="login-admin-form-eyebrow">Toegangsbeheer</p>
            <h1 class="login-admin-form-title">Beheerder login</h1>
            <p class="login-admin-form-sub">Beveiligde toegang — alleen bevoegd personeel</p>

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="login-admin-alert-error" role="alert">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('staff.login') }}" novalidate id="login-admin-form">
                @csrf

                <div class="login-admin-field-group">
                    <label class="login-admin-field-label" for="login-admin-email">E-mailadres</label>
                    <div class="login-admin-field-wrap">
                        <span class="login-admin-field-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                        </span>
                        <input
                            class="login-admin-field-input"
                            type="email"
                            id="login-admin-email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="bruce.wayne @schiphol.nl"
                            autocomplete="username"
                            required
                            autofocus
                        />
                    </div>
                </div>

                <div class="login-admin-field-group">
                    <label class="login-admin-field-label" for="login-admin-password">Wachtwoord</label>
                    <div class="login-admin-field-wrap">
                        <span class="login-admin-field-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </span>
                        <input
                            class="login-admin-field-input login-admin-field-input--padded-right"
                            type="password"
                            id="login-admin-password"
                            name="password"
                            placeholder="••••••••••"
                            autocomplete="current-password"
                            required
                        />
                        <button type="button" class="login-admin-field-suffix" id="login-admin-togglePass" aria-label="Toon wachtwoord">
                            <svg id="login-admin-eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <div class="login-admin-form-meta">
                    <label class="login-admin-form-check">
                        <input type="checkbox" name="remember" id="login-admin-remember" {{ old('remember') ? 'checked' : '' }} />
                        <span>Onthoud dit apparaat</span>
                    </label>
                    <a href="#" class="login-admin-form-link">Wachtwoord vergeten?</a>
                </div>

                <button type="submit" class="login-admin-btn-login" id="login-admin-loginBtn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8a19.79 19.79 0 01-3.07-8.63A2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 15z" transform="rotate(90 12 12)"/></svg>
                    Inloggen
                </button>
            </form>

            <footer class="login-admin-form-footer">
                <div class="login-admin-footer-badge">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    TLS 1.3 versleuteld
                </div>
                <div class="login-admin-footer-badge">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1a3 3 0 00-3 3v8a3 3 0 006 0V4a3 3 0 00-3-3z"/><path d="M19 10v2a7 7 0 01-14 0v-2"/></svg>
                    2FA vereist
                </div>
                <div class="login-admin-gate-code">GATE·C·12</div>
            </footer>
        </main>

    </div>
</div>

</body>
</html>