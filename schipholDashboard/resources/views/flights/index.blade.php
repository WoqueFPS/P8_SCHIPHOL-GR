<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vluchtschema - Schiphol Dashboard</title>
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
        <span class="schedule-hero__eyebrow">Vluchtcoördinator</span>
        <h1 class="schedule-hero__title">Vluchtschema</h1>
        <p class="schedule-hero__desc">
            Overzicht van alle geplande vluchten met vertrek- en aankomsttijden,
            luchtvaartmaatschappij, terminal en gate.
        </p>
    </div>
</section>

{{-- VLUCHTSCHEMA TABEL --}}
<section class="schedule">
    <div class="schedule__container">

        {{-- Toolbar: filter tabs + zoekbalk --}}
        <div class="schedule__toolbar">
            <div class="schedule__tabs" role="tablist">
                <button type="button" class="schedule__tab schedule__tab--active" data-filter="all">Alle</button>
                <button type="button" class="schedule__tab" data-filter="arriving">Aankomend</button>
                <button type="button" class="schedule__tab" data-filter="departing">Vertrekkend</button>
            </div>
            <div class="schedule__search">
                <svg class="schedule__search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="scheduleSearch" placeholder="Zoek op vluchtnummer, maatschappij of bestemming...">
            </div>
        </div>

        {{-- Tabel --}}
        <div class="schedule__table-wrap">
            <table class="schedule__table">
                <thead>
                    <tr>
                        <th>Vlucht</th>
                        <th>Maatschappij</th>
                        <th>Route</th>
                        <th>Vertrek</th>
                        <th>Aankomst</th>
                        <th>Terminal</th>
                        <th>Gate</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="scheduleBody">
                    @forelse($flights as $flight)
                    <tr class="schedule__row"
                        data-type="{{ $flight->type }}"
                        data-search="{{ strtolower($flight->flight_number.' '.$flight->airline.' '.$flight->origin.' '.$flight->destination) }}">

                        {{-- Vluchtnummer + maatschappij badge/logo --}}
                        <td class="schedule__cell--flight">
                            <span class="schedule__airline-badge">
                                @if($flight->airline_logo)
                                    <img src="{{ asset('storage/'.$flight->airline_logo) }}" alt="{{ $flight->airline }}">
                                @else
                                    {{ $flight->airline_code }}
                                @endif
                            </span>
                            <span>{{ $flight->flight_number }}</span>
                        </td>

                        {{-- Maatschappij naam --}}
                        <td>{{ $flight->airline }}</td>

                        {{-- Route --}}
                        <td class="schedule__cell--route">
                            <span>{{ $flight->origin }}</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="schedule__route-arrow">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                            <span>{{ $flight->destination }}</span>
                        </td>

                        {{-- Vertrektijd (alleen bij vertrekkende vluchten) --}}
                        <td class="schedule__cell--time">
                            @if($flight->type === 'departing')
                                <span class="schedule__time">{{ \Carbon\Carbon::parse($flight->scheduled_time)->format('H:i') }}</span>
                                @if($flight->delay_minutes > 0)
                                    <span class="schedule__delay">+{{ $flight->delay_minutes }} min</span>
                                @endif
                            @else
                                <span class="schedule__time-empty">—</span>
                            @endif
                        </td>

                        {{-- Aankomsttijd (alleen bij aankomende vluchten) --}}
                        <td class="schedule__cell--time">
                            @if($flight->type === 'arriving')
                                <span class="schedule__time">{{ \Carbon\Carbon::parse($flight->scheduled_time)->format('H:i') }}</span>
                                @if($flight->delay_minutes > 0)
                                    <span class="schedule__delay">+{{ $flight->delay_minutes }} min</span>
                                @endif
                            @else
                                <span class="schedule__time-empty">—</span>
                            @endif
                        </td>

                        {{-- Terminal --}}
                        <td>{{ $flight->terminal ?? '—' }}</td>

                        {{-- Gate --}}
                        <td>{{ $flight->gate ?? '—' }}</td>

                        {{-- Status --}}
                        <td>
                            <span class="schedule__badge schedule__badge--{{ $flight->status }}">
                                {{ ucfirst(str_replace('-', ' ', $flight->status)) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="schedule__empty">Geen vluchten gevonden.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</section>

{{-- FOOTER --}}
@include('partials.footer')

</body>
</html>