<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $flight->flight_number }} boeken - Schiphol Dashboard</title>
    <link rel="icon" href="{{ asset('images/logo/schiphol.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Expires" content="0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

{{-- NAVBAR --}}
@include('partials.navbar')

{{-- Niet boekbare vlucht: redirect terug --}}
@if(!$flight->is_bookable)
    <div style="max-width:600px;margin:4rem auto;text-align:center;padding:2rem;">
        <p style="font-size:1.1rem;color:#b91c1c;font-weight:600;margin-bottom:1rem;">
            Deze vlucht is niet beschikbaar voor boeking (status: {{ ucfirst(str_replace('-', ' ', $flight->status)) }}).
        </p>
        <a href="{{ route('flights.index') }}" style="background:#16a34a;color:#fff;padding:10px 22px;border-radius:8px;text-decoration:none;font-weight:600;">
            Terug naar vluchten
        </a>
    </div>
@else

{{-- PAGINA HEADER --}}
<section class="booking-hero">
    <div class="booking-hero__inner">
        <a href="{{ route('flights.index') }}" class="booking-hero__back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Terug naar vluchten
        </a>
        <span class="booking-hero__eyebrow">Vlucht boeken</span>
        <h1 class="booking-hero__title">{{ $flight->origin }} → {{ $flight->destination }}</h1>
        <p class="booking-hero__desc">Vlucht {{ $flight->flight_number }} · {{ $flight->airline }}</p>
    </div>
</section>

{{-- BOEKINGSPAGINA --}}
<section class="booking-page">
    <div class="booking-page__container">

        @php
            $bookable = in_array($flight->status, ['op-tijd', 'vertraging']);

            // Prijs bepalen op basis van vlucht id (random maar consistent per vlucht)
            srand($flight->id * 7);
            $basePrice  = rand(89, 349);
            $taxPrice   = round($basePrice * 0.21);
            $totalPrice = $basePrice + $taxPrice;
            srand();
        @endphp

        <div class="booking-page__grid">

            {{-- LINKS: Vluchtoverzicht --}}
            <div class="booking-page__summary">
                <h2 class="booking-page__section-title">Vluchtoverzicht</h2>

                <div class="booking-summary">
                    <div class="booking-summary__header">
                        <div class="booking-summary__badge">
                            @if($flight->airline_logo)
                                <img src="{{ asset('storage/'.$flight->airline_logo) }}" alt="{{ $flight->airline }}">
                            @else
                                {{ $flight->airline_code }}
                            @endif
                        </div>
                        <div style="flex:1">
                            <div class="booking-summary__number">{{ $flight->flight_number }}</div>
                            <div class="booking-summary__airline">{{ $flight->airline }}</div>
                        </div>
                        <span class="booking-summary__status booking-summary__status--{{ $flight->status }}">
                            {{ ucfirst(str_replace('-', ' ', $flight->status)) }}
                        </span>
                    </div>

                    <div class="booking-summary__route">
                        <div class="booking-summary__point">
                            <span class="booking-summary__point-label">Van</span>
                            <span class="booking-summary__point-value">{{ $flight->origin }}</span>
                        </div>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="booking-summary__arrow">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                        <div class="booking-summary__point booking-summary__point--right">
                            <span class="booking-summary__point-label">Naar</span>
                            <span class="booking-summary__point-value">{{ $flight->destination }}</span>
                        </div>
                    </div>

                    <div class="booking-summary__details">
                        <div class="booking-summary__detail">
                            <span class="booking-summary__detail-label">
                                {{ $flight->type === 'departing' ? 'Vertrektijd' : 'Aankomsttijd' }}
                            </span>
                            <span class="booking-summary__detail-value">
                                {{ \Carbon\Carbon::parse($flight->scheduled_time)->format('H:i') }}
                                @if($flight->delay_minutes > 0)
                                    <span class="booking-summary__delay">+{{ $flight->delay_minutes }} min</span>
                                @endif
                            </span>
                        </div>
                        <div class="booking-summary__detail">
                            <span class="booking-summary__detail-label">Terminal</span>
                            <span class="booking-summary__detail-value">{{ $flight->terminal ?? '—' }}</span>
                        </div>
                        <div class="booking-summary__detail">
                            <span class="booking-summary__detail-label">Gate</span>
                            <span class="booking-summary__detail-value">{{ $flight->gate ?? '—' }}</span>
                        </div>
                        <div class="booking-summary__detail">
                            <span class="booking-summary__detail-label">Type</span>
                            <span class="booking-summary__detail-value">
                                {{ $flight->type === 'departing' ? 'Vertrekkend' : 'Aankomend' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Kostenoverzicht --}}
                <div class="booking-costs">
                    <h3 class="booking-costs__title">Kostenoverzicht</h3>
                    <div class="booking-costs__row">
                        <span>Vliegticket</span>
                        <span>€ {{ number_format($basePrice, 2, ',', '.') }}</span>
                    </div>
                    <div class="booking-costs__row">
                        <span>Luchthavenbelasting (21%)</span>
                        <span>€ {{ number_format($taxPrice, 2, ',', '.') }}</span>
                    </div>
                    <div class="booking-costs__row booking-costs__row--total">
                        <span>Totaal</span>
                        <span>€ {{ number_format($totalPrice, 2, ',', '.') }}</span>
                    </div>
                    <p class="booking-costs__note">
                        Na akkoord op bovenstaande kosten kun je de boeking definitief maken.
                    </p>
                </div>

                {{-- Niet boekbaar melding --}}
                @if(!$bookable)
                    <div class="booking-not-available">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <div>
                            <strong>Deze vlucht is niet boekbaar</strong>
                            <p>
                                Vluchten met status
                                <span class="booking-summary__status booking-summary__status--{{ $flight->status }}" style="display:inline-block; vertical-align:middle;">
                                    {{ ucfirst(str_replace('-', ' ', $flight->status)) }}
                                </span>
                                kunnen niet worden geboekt. Kies een vlucht met status <em>Op tijd</em> of <em>Vertraging</em>.
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- RECHTS: Boekingsformulier --}}
            <div class="booking-page__form">
                <h2 class="booking-page__section-title">Persoonlijke gegevens</h2>

                @if($errors->any())
                    <div class="booking-form__alert">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <div>
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('bookings.store') }}" class="booking-form">
                    @csrf
                    <input type="hidden" name="flight_id" value="{{ $flight->id }}">

                    <div class="booking-form__row">
                        <div class="booking-form__group">
                            <label class="booking-form__label" for="first_name">Voornaam</label>
                            <input
                                type="text"
                                id="first_name"
                                name="first_name"
                                class="booking-form__input {{ $errors->has('first_name') ? 'booking-form__input--error' : '' }}"
                                value="{{ old('first_name') }}"
                                placeholder="Jan"
                                required
                                {{ !$bookable ? 'disabled' : '' }}
                            >
                        </div>
                        <div class="booking-form__group">
                            <label class="booking-form__label" for="last_name">Achternaam</label>
                            <input
                                type="text"
                                id="last_name"
                                name="last_name"
                                class="booking-form__input {{ $errors->has('last_name') ? 'booking-form__input--error' : '' }}"
                                value="{{ old('last_name') }}"
                                placeholder="Jansen"
                                required
                                {{ !$bookable ? 'disabled' : '' }}
                            >
                        </div>
                    </div>

                    <div class="booking-form__group">
                        <label class="booking-form__label" for="address">Adres</label>
                        <input
                            type="text"
                            id="address"
                            name="address"
                            class="booking-form__input {{ $errors->has('address') ? 'booking-form__input--error' : '' }}"
                            value="{{ old('address') }}"
                            placeholder="Straatnaam 1, Amsterdam"
                            required
                            {{ !$bookable ? 'disabled' : '' }}
                        >
                    </div>

                    <div class="booking-form__group">
                        <label class="booking-form__label" for="email">E-mailadres</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="booking-form__input {{ $errors->has('email') ? 'booking-form__input--error' : '' }}"
                            value="{{ old('email', Auth::user()->email ?? '') }}"
                            placeholder="jan@voorbeeld.nl"
                            required
                            {{ !$bookable ? 'disabled' : '' }}
                        >
                    </div>

                    <div class="booking-form__group">
                        <label class="booking-form__label" for="phone">Telefoonnummer</label>
                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            class="booking-form__input {{ $errors->has('phone') ? 'booking-form__input--error' : '' }}"
                            value="{{ old('phone') }}"
                            placeholder="+31 6 12345678"
                            required
                            {{ !$bookable ? 'disabled' : '' }}
                        >
                    </div>

                    @if($bookable)
                        <label class="booking-form__checkbox">
                            <input type="checkbox" name="confirm" value="1" required>
                            <span>Ik ga akkoord met het kostenoverzicht (€ {{ number_format($totalPrice, 2, ',', '.') }}) en de voorwaarden</span>
                        </label>

                        <button type="submit" class="booking-form__submit">
                            Vlucht definitief boeken
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </button>
                    @else
                        <a href="{{ route('flights.index') }}" class="booking-form__submit" style="text-decoration:none; justify-content:center;">
                            Andere vlucht kiezen
                        </a>
                    @endif
                </form>
            </div>

        </div>
    </div>
</section>

@endif

{{-- FOOTER --}}
@include('partials.footer')

</body>
</html>