<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Boekingen - Schiphol Dashboard</title>
    <link rel="icon" href="{{ asset('images/logo/schiphol.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@include('partials.navbar')

{{-- PAGINA HEADER --}}
<section class="bookings-hero">
    <div class="bookings-hero__inner">
        <span class="bookings-hero__eyebrow">Reiziger</span>
        <h1 class="bookings-hero__title">Mijn boekingen</h1>
        <p class="bookings-hero__desc">
            Overzicht van al je gemaakte boekingen. Klik op een boeking voor details of print je ticket.
        </p>
    </div>
</section>

{{-- BOEKINGEN OVERZICHT --}}
<section class="bookings">
    <div class="bookings__container">

        @if($bookings->isEmpty())
            <div class="bookings__empty">
                <div class="bookings__empty-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <h2 class="bookings__empty-title">Geen boekingen gevonden</h2>
                <p class="bookings__empty-desc">Je hebt nog geen vluchten geboekt. Bekijk het aanbod en maak je eerste boeking.</p>
                <a href="{{ route('flights.index') }}" class="bookings__empty-btn">Vluchten bekijken</a>
            </div>
        @else
            <div class="bookings__grid">
                @foreach($bookings as $booking)
                <div class="bookings__card">

                    <div class="bookings__card-header">
                        <div class="bookings__card-number">
                            <span class="bookings__card-number-label">Boekingsnr.</span>
                            <span class="bookings__card-number-value">{{ $booking->booking_number }}</span>
                        </div>
                        <span class="bookings__card-date">
                            {{ $booking->created_at->format('d-m-Y') }}
                        </span>
                    </div>

                    @if($booking->flight)
                        <div class="bookings__card-flight">
                            <div class="bookings__card-airline">
                                <span class="bookings__card-badge">
                                    {{ $booking->flight->airline_code }}
                                </span>
                                <div>
                                    <div class="bookings__card-flight-number">{{ $booking->flight->flight_number }}</div>
                                    <div class="bookings__card-flight-airline">{{ $booking->flight->airline }}</div>
                                </div>
                            </div>

                            <div class="bookings__card-route">
                                <div class="bookings__card-point">
                                    <span class="bookings__card-point-label">Van</span>
                                    <span class="bookings__card-point-value">{{ $booking->flight->origin }}</span>
                                </div>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="bookings__card-arrow">
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                    <polyline points="12 5 19 12 12 19"/>
                                </svg>
                                <div class="bookings__card-point">
                                    <span class="bookings__card-point-label">Naar</span>
                                    <span class="bookings__card-point-value">{{ $booking->flight->destination }}</span>
                                </div>
                            </div>

                            <div class="bookings__card-details">
                                <div class="bookings__card-detail">
                                    <span class="bookings__card-detail-label">Tijd</span>
                                    <span class="bookings__card-detail-value">
                                        {{ \Carbon\Carbon::parse($booking->flight->scheduled_time)->format('H:i') }}
                                    </span>
                                </div>
                                <div class="bookings__card-detail">
                                    <span class="bookings__card-detail-label">Terminal</span>
                                    <span class="bookings__card-detail-value">{{ $booking->flight->terminal ?? '—' }}</span>
                                </div>
                                <div class="bookings__card-detail">
                                    <span class="bookings__card-detail-label">Gate</span>
                                    <span class="bookings__card-detail-value">{{ $booking->flight->gate ?? '—' }}</span>
                                </div>
                                <div class="bookings__card-detail">
                                    <span class="bookings__card-detail-label">Status</span>
                                    <span class="bookings__card-detail-value bookings__status bookings__status--{{ $booking->flight->status }}">
                                        {{ ucfirst(str_replace('-', ' ', $booking->flight->status)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="bookings__card-no-flight">Geen vluchtgegevens beschikbaar.</p>
                    @endif

                    <div class="bookings__card-passenger">
                        <span class="bookings__card-passenger-name">
                            {{ $booking->first_name }} {{ $booking->last_name }}
                        </span>
                        <span class="bookings__card-passenger-email">{{ $booking->email }}</span>
                    </div>

                    <div class="bookings__card-actions">
                        <a href="{{ route('bookings.confirmation', $booking->booking_number) }}" class="bookings__card-btn bookings__card-btn--ghost">
                            Details bekijken
                        </a>
                        <a href="{{ route('bookings.confirmation', $booking->booking_number) }}" class="bookings__card-btn bookings__card-btn--primary" onclick="setTimeout(() => window.print(), 300); return true;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 6 2 18 2 18 9"/>
                                <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>
                                <rect x="6" y="14" width="12" height="8"/>
                            </svg>
                            Printen
                        </a>
                    </div>

                </div>
                @endforeach
            </div>
        @endif

    </div>
</section>

@include('partials.footer')

</body>
</html>