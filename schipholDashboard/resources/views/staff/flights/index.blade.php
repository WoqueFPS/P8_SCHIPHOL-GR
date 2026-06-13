<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Vluchtcoordinatie</title>
    @vite('resources/css/app.css')
</head>
<body>

<div style="max-width:1000px;margin:2rem auto">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
        <h1>Vluchtcoordinatie</h1>
        <a href="{{ route('staff.flights.create') }}">
            <button type="button">+ Vlucht toevoegen</button>
        </a>
    </div>

    @if (session('success'))
        <div style="background:#eaf3de;color:#27500a;padding:10px;border-radius:6px;margin-bottom:1rem">
            {{ session('success') }}
        </div>
    @endif

    <table style="width:100%;border-collapse:collapse">
        <thead>
            <tr style="text-align:left;border-bottom:1px solid #ccc">
                <th style="padding:8px">Vlucht</th>
                <th style="padding:8px">Maatschappij</th>
                <th style="padding:8px">Route</th>
                <th style="padding:8px">Tijd</th>
                <th style="padding:8px">Gate</th>
                <th style="padding:8px">Status</th>
                <th style="padding:8px">Acties</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($flights as $flight)
                <tr style="border-bottom:1px solid #eee">
                    <td style="padding:8px">{{ $flight->flight_number }}</td>
                    <td style="padding:8px">{{ $flight->airline }} ({{ $flight->airline_code }})</td>
                    <td style="padding:8px">{{ $flight->origin }} &rarr; {{ $flight->destination }}</td>
                    <td style="padding:8px">{{ \Illuminate\Support\Carbon::parse($flight->scheduled_time)->format('d-m-Y H:i') }}</td>
                    <td style="padding:8px">{{ $flight->gate ?? '-' }} (T{{ $flight->terminal ?? '-' }})</td>
                    <td style="padding:8px">{{ ucfirst($flight->status) }}</td>
                    <td style="padding:8px;white-space:nowrap">
                        <a href="{{ route('staff.flights.edit', $flight) }}">
                            <button type="button">Wijzigen</button>
                        </a>
                        <form method="POST" action="{{ route('staff.flights.destroy', $flight) }}" onsubmit="return confirm('Vlucht verwijderen?')" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Verwijderen</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="padding:12px;text-align:center;color:#888">Geen vluchten gevonden.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>