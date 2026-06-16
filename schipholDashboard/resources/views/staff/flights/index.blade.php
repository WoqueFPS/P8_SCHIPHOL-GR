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
<body class="fc-body">
{{-- NAVBAR --}}
@include('partials.navbar')
<div class="fc-page">
    <div class="fc-header">
        <h1 class="fc-title">Vluchtcoördinatie</h1>
        <a href="{{ route('staff.flights.create') }}">
            <button type="button" class="fc-btn fc-btn--primary">+ Vlucht toevoegen</button>
        </a>
    </div>

    @if (session('success'))
        <div class="fc-alert fc-alert--success">
            {{ session('success') }}
        </div>
    @endif

    <div class="fc-table-wrap">
        <table class="fc-table">
            <thead>
                <tr>
                    <th>Vlucht</th>
                    <th>Maatschappij</th>
                    <th>Route</th>
                    <th>Tijd</th>
                    <th>Gate (Grootte)</th>
                    <th>Status</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($flights as $flight)
                    <tr class="fc-row">
                        <td class="fc-cell fc-cell--mono">{{ $flight->flight_number }}</td>

                        <td class="fc-cell">
                            <div class="fc-airline">
                                @if($flight->airline_logo)
                                    <img class="fc-airline__logo" src="{{ asset('storage/' . $flight->airline_logo) }}" alt="Logo">
                                @endif
                                <span class="fc-airline__name">{{ $flight->airline }} ({{ $flight->airline_code }})</span>
                            </div>
                        </td>

                        <td class="fc-cell fc-cell--route">{{ $flight->origin }} → {{ $flight->destination }}</td>
                        <td class="fc-cell fc-cell--mono">{{ \Illuminate\Support\Carbon::parse($flight->scheduled_time)->format('H:i') }}</td>

                        <td class="fc-cell">
                            <span class="fc-gate">
                                {{ $flight->gate ?? '-' }}
                                (T{{ $flight->terminal ?? '-' }})
                                – {{ ucfirst($flight->gate_type ?? 'standaard') }}
                            </span>
                        </td>

                        <td class="fc-cell">
                            @if($flight->status === 'toekomstig')
                                <span class="fc-badge fc-badge--future">Toekomstig</span>
                            @elseif($flight->status === 'gepland')
                                <span class="fc-badge fc-badge--planned">Gepland</span>
                            @else
                                <span class="fc-badge fc-badge--default">{{ ucfirst($flight->status) }}</span>
                            @endif
                        </td>

                        <td class="fc-cell fc-cell--actions">
                            <a href="{{ route('staff.flights.edit', $flight) }}">
                                <button type="button" class="fc-btn fc-btn--ghost">Wijzigen</button>
                            </a>
                            <form method="POST" action="{{ route('staff.flights.destroy', $flight) }}" onsubmit="return confirm('Vlucht verwijderen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="fc-btn fc-btn--danger">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="fc-empty">Geen vluchten gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{-- FOOTER --}}
@include('partials.footer')
</body>
</html>