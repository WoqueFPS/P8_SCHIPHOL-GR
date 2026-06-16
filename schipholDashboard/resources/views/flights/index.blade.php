<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vluchten - Schiphol Dashboard</title>
    <link rel="icon" href="{{ asset('images/logo/schiphol.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Expires" content="0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

{{-- NAVBAR --}}
@include('partials.navbar')

{{-- PAGINA HEADER --}}
<section class="schedule-hero">
    <div class="schedule-hero__inner">
        <span class="schedule-hero__eyebrow">Vluchten</span>
        <h1 class="schedule-hero__title">Vluchtschema</h1>
        <p class="schedule-hero__desc">
            Overzicht van alle geplande vluchten met vertrek- en aankomsttijden,
            luchtvaartmaatschappij, terminal en gate.
        </p>
        <div class="flights-hero__search">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="flightsSearch" placeholder="Zoek op bestemming, vluchtnummer of maatschappij...">
        </div>
    </div>
</section>

{{-- VLUCHTEN --}}
<section class="flights">
    <div class="flights__container">

        <div class="flights__toolbar">
            <div class="flights__tabs">
                <button type="button" class="flights__tab flights__tab--active" data-filter="all">Alle vluchten</button>
                <button type="button" class="flights__tab" data-filter="departing">Vertrekkend</button>
                <button type="button" class="flights__tab" data-filter="arriving">Aankomend</button>
            </div>
            <span class="flights__count" id="flightsCount">{{ $flights->count() }} vluchten</span>
        </div>

        @forelse($flights as $flight)
        <div class="flights__card"
             data-type="{{ $flight->type }}"
             data-search="{{ strtolower($flight->flight_number.' '.$flight->airline.' '.$flight->origin.' '.$flight->destination) }}">

            {{-- Links: badge + vluchtnummer --}}
            <div class="flights__card-left">
                <div class="flights__card-badge">
                    @if($flight->airline_logo)
                        <img src="{{ asset('storage/'.$flight->airline_logo) }}" alt="{{ $flight->airline }}">
                    @else
                        {{ $flight->airline_code }}
                    @endif
                </div>
                <div class="flights__card-info">
                    <div class="flights__card-number">{{ $flight->flight_number }}</div>
                    <div class="flights__card-airline">{{ $flight->airline }}</div>
                </div>
            </div>

            {{-- Route --}}
            <div class="flights__card-route">
                <div class="flights__card-point">
                    <span class="flights__card-point-label">{{ $flight->type === 'departing' ? 'Vertrek' : 'Van' }}</span>
                    <span class="flights__card-point-value">{{ $flight->origin }}</span>
                </div>
                <div class="flights__card-route-line">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </div>
                <div class="flights__card-point flights__card-point--right">
                    <span class="flights__card-point-label">{{ $flight->type === 'arriving' ? 'Aankomst' : 'Naar' }}</span>
                    <span class="flights__card-point-value">{{ $flight->destination }}</span>
                </div>
            </div>

            {{-- Details --}}
            <div class="flights__card-details">
                <div class="flights__card-detail">
                    <span class="flights__card-detail-label">Tijd</span>
                    <span class="flights__card-detail-value">
                        {{ \Carbon\Carbon::parse($flight->scheduled_time)->format('H:i') }}
                        @if($flight->delay_minutes > 0)
                            <span class="flights__card-delay">+{{ $flight->delay_minutes }}m</span>
                        @endif
                    </span>
                </div>
                <div class="flights__card-detail">
                    <span class="flights__card-detail-label">Gate</span>
                    <span class="flights__card-detail-value">{{ $flight->gate ?? '—' }}</span>
                </div>
                <div class="flights__card-detail">
                    <span class="flights__card-detail-label">Terminal</span>
                    <span class="flights__card-detail-value">{{ $flight->terminal ?? '—' }}</span>
                </div>
                <div class="flights__card-detail">
                    <span class="flights__card-detail-label">Prijs</span>
                    <span class="flights__card-detail-value flights__card-price">
                        € {{ number_format($flight->price, 2, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Status + actie --}}
            <div class="flights__card-right">
                <span class="flights__card-status flights__card-status--{{ $flight->status }}">
                    {{ ucfirst(str_replace('-', ' ', $flight->status)) }}
                </span>

                @if($flight->is_bookable)
                    @auth
                        <a href="{{ route('flights.show', $flight->id) }}" class="flights__card-btn">
                            Boek nu
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="flights__card-btn flights__card-btn--ghost">
                            Inloggen om te boeken
                        </a>
                    @endauth
                @else
                    <span class="flights__card-btn flights__card-btn--disabled">
                        Niet beschikbaar
                    </span>
                @endif
            </div>

        </div>
        @empty
        <div class="flights__empty">
            <p>Geen vluchten gevonden.</p>
        </div>
        @endforelse

    </div>
</section>

{{-- FOOTER --}}
@include('partials.footer')

</body>
</html>