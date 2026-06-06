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
</head>
<body>

<div class="register-wrapper">

    {{-- linker paneel --}}
    <div class="register-panel">
        <div class="register-panel__blob register-panel__blob--1"></div>
        <div class="register-panel__blob register-panel__blob--2"></div>

        <div class="register-panel__logo">
            <div class="register-panel__logo-mark">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/>
                    <path d="M2 12l10 5 10-5"/>
                </svg>
            </div>
            <span class="register-panel__logo-text">Schiphol Dashboard</span>
        </div>

        <div class="register-panel__body">
            <h2 class="register-panel__tagline">
                Word <em>onderdeel</em> van<br>
                Gatekeepers Schiphol
            </h2>
            <p class="register-panel__sub">
                Registreer als medewerker en krijg toegang tot vluchtbeheer, gate coördinatie en realtime rapportages.
            </p>
        </div>

        <div class="register-panel__footer">
            <div class="register-panel__stat">
                <span class="register-panel__stat-num">24/7</span>
                <span class="register-panel__stat-label">Beschikbaar</span>
            </div>
            <div class="register-panel__stat">
                <span class="register-panel__stat-num">256-bit</span>
                <span class="register-panel__stat-label">Versleuteling</span>
            </div>
            <div class="register-panel__stat">
                <span class="register-panel__stat-num">✓ AMS</span>
                <span class="register-panel__stat-label">Schiphol</span>
            </div>
        </div>
    </div>

    {{-- rechterkant formulier --}}
    <div class="register-form-panel">
        <div class="register-card">

            <h1 class="register-card__heading">Registreren</h1>
            <p class="register-card__sub">
                Al een account?
                <a href="{{ route('login') }}">Inloggen</a>
            </p>

            @if ($errors->any())
                <div class="register-alert register-alert--danger" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf

                {{-- naam --}}
                <div class="register-form-group">
                    <label class="register-form-label" for="register_name">Volledige naam</label>
                    <div class="register-input-wrap">
                        <svg class="register-input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <input id="register_name" type="text" name="name" class="register-form-control @error('name') register-is-invalid @enderror" value="{{ old('name') }}" required autofocus placeholder="Peter Parker">
                    </div>
                    @error('name')
                        <p class="register-form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- email --}}
                <div class="register-form-group">
                    <label class="register-form-label" for="register_email">E-mailadres</label>
                    <div class="register-input-wrap">
                        <svg class="register-input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="M2 7l10 7 10-7"/>
                        </svg>
                        <input id="register_email" type="email" name="email" class="register-form-control @error('email') register-is-invalid @enderror" value="{{ old('email') }}" required placeholder="peter.parker@schiphol.nl">
                    </div>
                    @error('email')
                        <p class="register-form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- wachtwoord --}}
                <div class="register-form-group">
                    <label class="register-form-label" for="register_password">Wachtwoord</label>
                    <div class="register-input-wrap">
                        <svg class="register-input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input id="register_password" type="password" name="password" class="register-form-control @error('password') register-is-invalid @enderror" required placeholder="••••••••">
                        <button type="button" class="register-password-toggle" aria-label="Wachtwoord tonen/verbergen" onclick="toggleRegisterPassword()">
                            <svg id="register-eye-icon-pw" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="register-form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- wachtwoord bevestigen --}}
                <div class="register-form-group">
                    <label class="register-form-label" for="register_password_confirmation">Bevestig wachtwoord</label>
                    <div class="register-input-wrap">
                        <svg class="register-input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input id="register_password_confirmation" type="password" name="password_confirmation" class="register-form-control" required placeholder="••••••••">
                        <button type="button" class="register-password-toggle" aria-label="Wachtwoord tonen/verbergen" onclick="toggleRegisterPasswordConfirm()">
                            <svg id="register-eye-icon-confirm" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- submit knop --}}
                <button type="submit" class="register-btn-primary">
                    Registreer als medewerker
                </button>

                {{-- of ga verder met --}}
                <div class="register-divider">of registreer met</div>

                <button type="button" class="register-btn-sso" onclick="window.location.href='{{ url('/auth/google') }}'">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Doorgaan met Google
                </button>

            </form>
        </div>
    </div>

</div>

</body>
</html>