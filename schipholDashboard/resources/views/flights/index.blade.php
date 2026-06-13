<div class="container" style="max-width:1000px; margin:2rem auto;">
    <h1>Actuele Vluchten Schiphol</h1>
    <p>Overzicht van alle geplande aankomsten en vertrekken.</p>

    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="text-align:left; border-bottom:1px solid #ccc">
                <th>Vluchtnummer</th>
                <th>Maatschappij</th>
                <th>Herkomst / Bestemming</th>
                <th>Type</th>
                <th>Status</th>
                <th>Actie</th>
            </tr>
        </thead>
        <tbody>
            @forelse($flights as $flight)
                <tr style="border-bottom:1px solid #eee">
                    <td style="padding:8px">{{ $flight->flight_number }}</td>
                    <td>{{ $flight->airline }}</td>
                    <td>
                        {{ $flight->type === 'arriving' ? $flight->origin : $flight->destination }}
                    </td>
                    <td>
                        {{ $flight->type === 'arriving' ? 'Aankomst' : 'Vertrek' }}
                    </td>
                    <td>{{ ucfirst($flight->status) }}</td>
                    <td style="padding:8px">
                        <a href="{{ route('flights.show', $flight->id) }}">
                            <button type="button">Bekijken & Boeken</button>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="padding:12px; text-align:center;">Geen vluchten beschikbaar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>