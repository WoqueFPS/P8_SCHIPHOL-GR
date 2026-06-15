<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boekingsbevestiging - Schiphol Dashboard</title>
    <link rel="icon" href="{{ asset('images/logo/schiphol.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Expires" content="0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

{{-- NAVBAR --}}
@include('partials.navbar')

{{-- SUCCES HEADER --}}
<section class="confirmation-hero">
    <div class="confirmation-hero__inner">
        <div class="confirmation-hero__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 6L9 17l-5-5"/>
            </svg>
        </div>
        <h1 class="confirmation-hero__title">Boeking bevestigd!</h1>
        <p class="confirmation-hero__desc">
            Een bevestiging is verstuurd naar <strong>{{ $booking->email }}</strong>.
            Bewaar je boekingsnummer goed.
        </p>
        <div class="confirmation-hero__number">
            <span class="confirmation-hero__number-label">Boekingsnummer</span>
            <span class="confirmation-hero__number-value">{{ $booking->booking_number }}</span>
        </div>
    </div>
</section>

{{-- BEVESTIGING / TICKET --}}
<section class="confirmation">
    <div class="confirmation__container">

        {{-- Acties --}}
        <div class="confirmation__actions">
            <button type="button" id="printBookingBtn" class="confirmation__btn confirmation__btn--primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 6 2 18 2 18 9"/>
                    <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>
                    <rect x="6" y="14" width="12" height="8"/>
                </svg>
                Boeking printen
            </button>
            <a href="{{ route('dashboard') }}" class="confirmation__btn confirmation__btn--ghost">
                Naar dashboard
            </a>
        </div>

        {{-- Ticket --}}
        <div class="confirmation__ticket" id="bookingTicket">

            {{-- Ticket header --}}
            <div class="confirmation__ticket-header">
                <div class="confirmation__ticket-brand">
                    <div class="confirmation__ticket-logo">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.5l-10-13-10 13"/>
                            <path d="M2 16.5h20"/>
                            <path d="M12 3.5v13"/>
                        </svg>
                    </div>
                    <span>Gatekeepers Schiphol</span>
                </div>
                <div class="confirmation__ticket-number">
                    <span>Boekingsnr.</span>
                    <strong>{{ $booking->booking_number }}</strong>
                </div>
            </div>

            {{-- Vluchtgegevens --}}
            <div class="confirmation__ticket-body">
                @if($booking->flight)
                    <div class="confirmation__flight">

                        <div class="confirmation__flight-main">
                            <span class="confirmation__airline-badge">
                                @if($booking->flight->airline_logo)
                                    <img src="{{ asset('storage/'.$booking->flight->airline_logo) }}" alt="{{ $booking->flight->airline }}">
                                @else
                                    {{ $booking->flight->airline_code }}
                                @endif
                            </span>
                            <div>
                                <div class="confirmation__flight-number">{{ $booking->flight->flight_number }}</div>
                                <div class="confirmation__flight-airline">{{ $booking->flight->airline }}</div>
                            </div>
                        </div>

                        <div class="confirmation__flight-route">
                            <div class="confirmation__flight-point">
                                <span class="confirmation__flight-label">Vertrek</span>
                                <span class="confirmation__flight-value">{{ $booking->flight->origin }}</span>
                            </div>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="confirmation__flight-arrow">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                            <div class="confirmation__flight-point confirmation__flight-point--right">
                                <span class="confirmation__flight-label">Aankomst</span>
                                <span class="confirmation__flight-value">{{ $booking->flight->destination }}</span>
                            </div>
                        </div>

                        <div class="confirmation__flight-details">
                            <div class="confirmation__detail">
                                <span class="confirmation__detail-label">
                                    {{ $booking->flight->type === 'departing' ? 'Vertrektijd' : 'Aankomsttijd' }}
                                </span>
                                <span class="confirmation__detail-value">
                                    {{ \Carbon\Carbon::parse($booking->flight->scheduled_time)->format('H:i') }}
                                </span>
                            </div>
                            <div class="confirmation__detail">
                                <span class="confirmation__detail-label">Terminal</span>
                                <span class="confirmation__detail-value">{{ $booking->flight->terminal ?? '—' }}</span>
                            </div>
                            <div class="confirmation__detail">
                                <span class="confirmation__detail-label">Gate</span>
                                <span class="confirmation__detail-value">{{ $booking->flight->gate ?? '—' }}</span>
                            </div>
                            <div class="confirmation__detail">
                                <span class="confirmation__detail-label">Status</span>
                                <span class="confirmation__detail-value">
                                    {{ ucfirst(str_replace('-', ' ', $booking->flight->status)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="confirmation__no-flight">
                        Voor deze boeking zijn nog geen vluchtgegevens gekoppeld.
                    </p>
                @endif

                {{-- Geperforeerde scheidingslijn --}}
                <div class="confirmation__divider">
                    <span class="confirmation__divider-notch confirmation__divider-notch--left"></span>
                    <span class="confirmation__divider-notch confirmation__divider-notch--right"></span>
                </div>

                {{-- Reizigersgegevens --}}
                <div class="confirmation__passenger">
                    <h2 class="confirmation__section-title">Reiziger</h2>
                    <div class="confirmation__passenger-grid">
                        <div class="confirmation__detail">
                            <span class="confirmation__detail-label">Naam</span>
                            <span class="confirmation__detail-value">{{ $booking->first_name }} {{ $booking->last_name }}</span>
                        </div>
                        <div class="confirmation__detail">
                            <span class="confirmation__detail-label">E-mail</span>
                            <span class="confirmation__detail-value">{{ $booking->email }}</span>
                        </div>
                        <div class="confirmation__detail">
                            <span class="confirmation__detail-label">Telefoon</span>
                            <span class="confirmation__detail-value">{{ $booking->phone }}</span>
                        </div>
                        <div class="confirmation__detail confirmation__detail--wide">
                            <span class="confirmation__detail-label">Adres</span>
                            <span class="confirmation__detail-value">{{ $booking->address }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ticket footer --}}
            <div class="confirmation__ticket-footer">
                <span>Gatekeepers Schiphol Dashboard</span>
                <span>Aangemaakt op {{ $booking->created_at->format('d-m-Y H:i') }}</span>
            </div>
        </div>

    </div>
</section>

{{-- FOOTER --}}
@include('partials.footer')

</body>
</html>