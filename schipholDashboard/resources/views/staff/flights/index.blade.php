<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Vluchtcoordinatie</title>
    @vite('resources/css/app.css')
</head>
<body>

<div>
    <div>
        <h1>Vluchtcoordinatie</h1>
        <a href="{{ route('staff.flights.create') }}">
            <button type="button">+ Vlucht toevoegen</button>
        </a>
    </div>

    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <table>
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
                <tr>
                    <td>{{ $flight->flight_number }}</td>
                    
                    <td>
                        <div>
                            @if($flight->airline_logo)
                                <img src="{{ asset('storage/' . $flight->airline_logo) }}" alt="Logo">
                            @endif
                            <span>{{ $flight->airline }} ({{ $flight->airline_code }})</span>
                        </div>
                    </td>
                    
                    <td>{{ $flight->origin }} &rarr; {{ $flight->destination }}</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($flight->scheduled_time)->format('H:i') }}</td>
                    
                    <td>
                        {{ $flight->gate ?? '-' }} 
                        (T{{ $flight->terminal ?? '-' }}) 
                        - {{ ucfirst($flight->gate_type ?? 'standaard') }}
                    </td>
                    
                    <td>
                        @if($flight->status === 'toekomstig')
                            <span>Toekomstig (Verlanglijst)</span>
                        @elseif($flight->status === 'gepland')
                            <span>Gepland (Aanwezigheid)</span>
                        @else
                            <span>{{ ucfirst($flight->status) }}</span>
                        @endif
                    </td>
                    
                    <td>
                        <a href="{{ route('staff.flights.edit', $flight) }}">
                            <button type="button">Wijzigen</button>
                        </a>
                        <form method="POST" action="{{ route('staff.flights.destroy', $flight) }}" onsubmit="return confirm('Vlucht verwijderen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Verwijderen</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Geen vluchten gevonden.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>