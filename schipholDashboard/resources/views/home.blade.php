<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schiphol Dashboard</title>
    <link rel="icon" href="{{ asset('images/logo/schiphol.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- cache uitzetten anders blijft het hangen --}}
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Expires" content="0">
    <link rel="icon" type="image/png" href="{{ asset('img/schiphol-logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

{{-- NAVBAR --}}
@include('partials.navbar')

{{-- HERO --}}
<section class="homepage-hero">
    <div class="homepage-hero__overlay"></div>

    {{-- ticker bandje --}}
    <div class="homepage-hero__ticker">
        <span class="homepage-hero__ticker-label">LIVE</span>
        <div class="homepage-hero__ticker-track">
            @foreach($arriving->merge($departing) as $f)
                <span>
                    {{ $f->flight_number }}
                    {{ $f->type === 'arriving' ? $f->origin : $f->destination }}
                    · {{ ucfirst($f->status) }}
                    @if($f->gate) · Gate {{ $f->gate }} @endif
                </span>
            @endforeach
        </div>
    </div>

    <div class="homepage-hero__content">
        <div class="homepage-hero__meta">
            <span class="homepage-hero__meta-item" id="homepage-liveClock">--:--</span>
            <span class="homepage-hero__meta-sep">|</span>
            <span class="homepage-hero__meta-item">Amsterdam Schiphol · AMS</span>
            <span class="homepage-hero__meta-sep">|</span>
            <span class="homepage-hero__meta-item" id="homepage-liveDate">--</span>
        </div>

        <h1 class="homepage-hero__title">
            <span class="homepage-hero__icon">✈︎</span>
            Gatekeepers Schiphol Dashboard
        </h1>
        <p class="homepage-hero__description">
            Welkom bij het Gatekeepers Schiphol Dashboard. Via dit systeem kunnen reizigers
            vluchten zoeken en boeken, vluchtcoördinatoren vluchten en gates beheren, en
            directieleden rapportages en gebruikers beheren.
        </p>

        <div class="homepage-hero__search">
            <span class="homepage-hero__search-icon">🔍︎</span>
            <input
                type="text"
                class="homepage-hero__search-input"
                placeholder="Zoek op bestemming, vluchtnummer of luchtvaartmaatschappij..."
                id="homepage-searchInput"
            >
            <button class="homepage-hero__search-btn">Zoeken</button>
        </div>

        {{-- Stats --}}
        <div class="homepage-hero__stats">
            <div class="homepage-hero__stat">
                <span class="homepage-hero__stat-num">{{ $stats['total'] }}</span>
                <span class="homepage-hero__stat-label">Vluchten vandaag</span>
            </div>
            <div class="homepage-hero__stat-divider"></div>
            <div class="homepage-hero__stat">
                <span class="homepage-hero__stat-num">
                    @if($stats['total'] > 0)
                        {{ round(($stats['on_time'] / $stats['total']) * 100) }}%
                    @else
                        0%
                    @endif
                </span>
                <span class="homepage-hero__stat-label">Op tijd</span>
            </div>
            <div class="homepage-hero__stat-divider"></div>
            <div class="homepage-hero__stat">
                <span class="homepage-hero__stat-num">{{ $stats['terminals'] }}</span>
                <span class="homepage-hero__stat-label">Terminals</span>
            </div>
            <div class="homepage-hero__stat-divider"></div>
            <div class="homepage-hero__stat">
                <span class="homepage-hero__stat-num">{{ $stats['destinations'] }}</span>
                <span class="homepage-hero__stat-label">Bestemmingen</span>
            </div>
        </div>

        {{-- Quick links --}}
        <div class="homepage-hero__cards">
            <a href="{{ route('flights.index') }}" class="homepage-hero-card homepage-hero-card--dark">
                <span class="homepage-hero-card__icon">FL</span>
                <strong class="homepage-hero-card__title">Vluchten bekijken</strong>
                <span class="homepage-hero-card__sub">Bekijk alle beschikbare vluchten</span>
            </a>

            {{-- Boeking maken button met check of ingelogd --}}
            @auth
                <a href="{{ route('flights.index') }}" class="homepage-hero-card homepage-hero-card--dark">
                    <span class="homepage-hero-card__icon">BK</span>
                    <strong class="homepage-hero-card__title">Boeking maken</strong>
                    <span class="homepage-hero-card__sub">Ga naar dashboard om te boeken</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="homepage-hero-card homepage-hero-card--dark">
                    <span class="homepage-hero-card__icon">BK</span>
                    <strong class="homepage-hero-card__title">Boeking maken</strong>
                    <span class="homepage-hero-card__sub">Log eerst in om een boeking te maken</span>
                </a>
            @endauth

            {{-- Medewerkers Knop (vangt staff guard op) --}}
            @auth('staff')
            <a href="{{ route('staff.redirect') }}" class="homepage-hero-card homepage-hero-card--light">
                <span class="homepage-hero-card__icon">ST</span>
                <strong class="homepage-hero-card__title">Medewerkers Portaal</strong>
                <span class="homepage-hero-card__sub">Je bent ingelogd. Ga naar dashboard</span>
            </a>
            @else
            <a href="{{ route('staff.login') }}" class="homepage-hero-card homepage-hero-card--light">
                <span class="homepage-hero-card__icon">ST</span>
                <strong class="homepage-hero-card__title">Medewerkers Portaal</strong>
                <span class="homepage-hero-card__sub">Login voor coördinatoren & directie</span>
            </a>
            @endauth
        </div>
    </div>
</section>

{{-- Vlucht info --}}
<section class="homepage-flights">
    <div class="homepage-flights__container">
        <h2 class="homepage-flights__heading">Actuele vluchtinformatie</h2>

        <div class="homepage-flights__grid">

            {{-- Aankomst --}}
            <div class="homepage-flight-card homepage-flight-card--active">
                <div class="homepage-flight-card__header">
                    <span class="homepage-flight-card__badge">↓</span>
                    <div>
                        <h3 class="homepage-flight-card__title">Aankomende vluchten</h3>
                        <span class="homepage-flight-card__subtitle">
                            {{ $arriving->pluck('terminal')->unique()->filter()->sort()->implode(' & ') ?: 'Meerdere terminals' }}
                        </span>
                    </div>
                </div>
                <div class="homepage-flight-card__list">
                    @forelse($arriving as $f)
                        <div class="homepage-flight-row" data-search="{{ strtolower($f->origin.' '.$f->flight_number.' '.$f->airline) }}">
                            <div class="homepage-flight-row__airline">{{ $f->airline_code }}</div>
                            <div class="homepage-flight-row__info">
                                <span class="homepage-flight-row__city">{{ $f->origin }}</span>
                                <span class="homepage-flight-row__code">
                                    {{ $f->flight_number }}
                                    @if($f->gate) · Gate {{ $f->gate }} @endif
                                    @if($f->delay_minutes > 0) · +{{ $f->delay_minutes }} min @endif
                                </span>
                            </div>
                            <div class="homepage-flight-row__right">
                                <span class="homepage-flight-row__time">{{ \Carbon\Carbon::parse($f->scheduled_time)->format('H:i') }}</span>
                                <span class="homepage-flight-row__status homepage-flight-row__status--{{ $f->status }}">
                                    {{ ucfirst($f->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="homepage-flight-card__empty">Geen aankomende vluchten gevonden.</p>
                    @endforelse
                </div>
            </div>

            {{-- Vertrek --}}
            <div class="homepage-flight-card">
                <div class="homepage-flight-card__header">
                    <span class="homepage-flight-card__badge">↑</span>
                    <div>
                        <h3 class="homepage-flight-card__title">Vertrekkende vluchten</h3>
                        <span class="homepage-flight-card__subtitle">
                            {{ $departing->pluck('terminal')->unique()->filter()->sort()->implode(' & ') ?: 'Meerdere terminals' }}
                        </span>
                    </div>
                </div>
                <div class="homepage-flight-card__list">
                    @forelse($departing as $f)
                        <div class="homepage-flight-row" data-search="{{ strtolower($f->destination.' '.$f->flight_number.' '.$f->airline) }}">
                            <div class="homepage-flight-row__airline">{{ $f->airline_code }}</div>
                            <div class="homepage-flight-row__info">
                                <span class="homepage-flight-row__city">{{ $f->destination }}</span>
                                <span class="homepage-flight-row__code">
                                    {{ $f->flight_number }}
                                    @if($f->gate) · Gate {{ $f->gate }} @endif
                                    @if($f->delay_minutes > 0) · +{{ $f->delay_minutes }} min @endif
                                </span>
                            </div>
                            <div class="homepage-flight-row__right">
                                <span class="homepage-flight-row__time">{{ \Carbon\Carbon::parse($f->scheduled_time)->format('H:i') }}</span>
                                <span class="homepage-flight-row__status homepage-flight-row__status--{{ $f->status }}">
                                    {{ ucfirst($f->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="homepage-flight-card__empty">Geen vertrekkende vluchten gevonden.</p>
                    @endforelse
                </div>
            </div>

            {{-- Populaire bestemmingen --}}
            <div class="homepage-flight-card">
                <div class="homepage-flight-card__header">
                    <span class="homepage-flight-card__badge">★</span>
                    <div>
                        <h3 class="homepage-flight-card__title">Populaire bestemmingen</h3>
                        <span class="homepage-flight-card__subtitle">Vandaag</span>
                    </div>
                </div>
                <div class="homepage-flight-card__list">
                    @forelse($popularDestinations as $dest)
                        <div class="homepage-flight-row homepage-flight-row--dest">
                            <div class="homepage-flight-row__info">
                                <span class="homepage-flight-row__city">{{ $dest->destination }}</span>
                                <span class="homepage-flight-row__code">{{ $dest->total }} vluchten/dag</span>
                            </div>
                            <span class="homepage-dest-trend homepage-dest-trend--stable">→</span>
                        </div>
                    @empty
                        <p class="homepage-flight-card__empty">Geen bestemmingen gevonden.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</section>

{{-- FOOTER --}}
@include('partials.footer')

</body>
</html>
