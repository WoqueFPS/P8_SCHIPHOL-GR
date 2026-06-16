<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boeking - {{ $flight->flight_number }} - Schiphol Dashboard</title>
    <link rel="icon" href="{{ asset('images/logo/schiphol.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@include('partials.navbar')

<section class="booking-form">
    <div class="booking-form__card">
        
        <h1 class="booking-form__title">Vlucht boeken</h1>
        <p class="booking-form__subtitle">
            {{ $flight->flight_number }} - {{ $flight->airline }}
            <br>
            <small>{{ $flight->origin }} → {{ $flight->destination }}</small>
        </p>

        <div class="booking-form__seats">
            🪑 <span>{{ $flight->seats_available ?? 100 }}</span> beschikbare stoelen
        </div>

        @if(($flight->seats_available ?? 100) > 0)
            <h3 style="font-size: 1rem; color: var(--gray-700); margin-bottom: 16px;">Persoonlijke gegevens invullen om te boeken:</h3>

            <form method="POST" action="{{ route('bookings.store') }}">
                @csrf
                <input type="hidden" name="flight_id" value="{{ $flight->id }}">

                <div class="booking-form__row">
                    <div class="booking-form__group">
                        <label class="booking-form__label">Voornaam</label>
                        <input type="text" name="first_name" class="booking-form__input" placeholder="Jouw voornaam" required>
                    </div>

                    <div class="booking-form__group">
                        <label class="booking-form__label">Achternaam</label>
                        <input type="text" name="last_name" class="booking-form__input" placeholder="Jouw achternaam" required>
                    </div>
                </div>

                <div class="booking-form__group">
                    <label class="booking-form__label">Adres</label>
                    <input type="text" name="address" class="booking-form__input" placeholder="Straat + huisnummer + postcode + woonplaats" required>
                </div>

                <div class="booking-form__row">
                    <div class="booking-form__group">
                        <label class="booking-form__label">E-mail</label>
                        <input type="email" name="email" class="booking-form__input" placeholder="jouw@email.nl" required>
                    </div>

                    <div class="booking-form__group">
                        <label class="booking-form__label">Telefoonnummer</label>
                        <input type="text" name="phone" class="booking-form__input" placeholder="06 12 34 56 78" required>
                    </div>
                </div>

                <label class="booking-form__checkbox">
                    <input type="checkbox" name="confirm" value="1" required>
                    <span class="booking-form__checkbox-label">Ik ga akkoord met de kosten</span>
                </label>

                <button type="submit" class="booking-form__btn">
                    ✅ Vlucht definitief boeken
                </button>
            </form>
        @else
            <div class="booking-form__sold-out">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                Deze vlucht is helaas volgeboekt.
            </div>
        @endif

        @if(($flight->seats_available ?? 100) <= 0 && isset($alternativeFlights) && $alternativeFlights->count())
            <div class="booking-form__alternatives">
                <h3 class="booking-form__alternatives-title"> Alternatieve vluchten</h3>
                
                @foreach($alternativeFlights as $alternative)
                    <div class="booking-form__alternative">
                        <div class="booking-form__alternative-info">
                            <span class="booking-form__alternative-flight">
                                {{ $alternative->flight_number }} - {{ $alternative->airline }}
                            </span>
                            <span class="booking-form__alternative-route">
                                {{ $alternative->origin }} → {{ $alternative->destination }}
                            </span>
                            <span class="booking-form__alternative-seats">
                                 {{ $alternative->seats_available }} stoelen beschikbaar
                            </span>
                        </div>
                        <a href="{{ route('flights.show', $alternative->id) }}" class="booking-form__alternative-btn">
                            Selecteer
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</section>

@include('partials.footer')

</body>
</html>