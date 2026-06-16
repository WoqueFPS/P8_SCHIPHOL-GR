<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Dashboard - Schiphol</title>
    <link rel="icon" href="{{ asset('images/logo/schiphol.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="fc-body">
{{-- NAVBAR --}}
@include('partials.navbar')
 
<div class="dash-hero">
    <div class="dash-hero__inner">
        <span class="dash-hero__eyebrow">Mijn account</span>
        <h1 class="dash-hero__title">Welkom terug, {{ $user->name }}</h1>
        <p class="dash-hero__desc">Hier vind je een overzicht van je boekingen en wishlist.</p>
    </div>
</div>
 
<div class="dash-page">
    <div class="dash-page__container">
 
        @if (session('success'))
            <div class="fc-alert fc-alert--success">
                {{ session('success') }}
            </div>
        @endif
 
        {{-- STATISTIEKEN --}}
        <div class="dash-stats-grid">
            <div class="dash-stat-card">
                <div class="dash-stat-card__icon">❤️</div>
                <div class="dash-stat-card__value">{{ $wishlistCount }}</div>
                <div class="dash-stat-card__label">Wishlist items</div>
            </div>
            <div class="dash-stat-card dash-stat-card--action">
                <a href="{{ route('bookings.index') }}" class="dash-stat-card__cta">
                    Mijn boekingen →
                </a>
            </div>
            <div class="dash-stat-card dash-stat-card--action">
                <a href="{{ route('flights.index') }}" class="dash-stat-card__cta">
                    Vlucht zoeken →
                </a>
            </div>
        </div>
 
        {{-- MIJN WISHLIST --}}
        <div class="dash-panel">
            <div class="dash-panel__header">
                <h2 class="dash-panel__title">Mijn wishlist</h2>
                <a href="{{ route('wishlist.index') }}" class="dash-panel__link">Volledige wishlist →</a>
            </div>
 
            <div class="dash-panel__body">
                @forelse ($recentWishlist as $flight)
                    <div class="dash-booking-row">
                        <div class="dash-booking-row__main">
                            <span class="dash-booking-row__number">{{ $flight->flight_number }}</span>
                            <span class="dash-booking-row__route">
                                {{ $flight->origin }} → {{ $flight->destination }}
                            </span>
                        </div>
                        <div class="dash-booking-row__meta">
                            <a href="{{ route('flights.show', $flight) }}" class="dash-booking-row__btn">
                                Bekijken
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="dash-empty">Je wishlist is leeg. <a href="{{ route('flights.index') }}">Bekijk vluchten</a> en sla ze op voor later.</p>
                @endforelse
            </div>
        </div>
 
        <form method="POST" action="{{ route('logout') }}" style="margin: 28px 0 20px 0;">
            @csrf
            <button type="submit" class="reports-dsh-btn reports-dsh-btn-ghost">Uitloggen</button>
        </form>
 
    </div>
</div>
 
{{-- FOOTER --}}
@include('partials.footer')
</body>
</html>