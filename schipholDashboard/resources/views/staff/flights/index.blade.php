<div class="container">
    <h1>Actuele Vluchten Schiphol</h1>
    <p>Overzicht van alle geplande aankomsten en vertrekken.</p>

    <table>
        <thead>
            <tr>
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
                <tr>
                    <td>{{ $flight->flight_number }}</td>
                    <td>{{ $flight->airline }}</td>
                    <td>
                        {{ $flight->type === 'arriving' ? $flight->origin : $flight->destination }}
                    </td>
                    <td>
                        {{ $flight->type === 'arriving' ? 'Aankomst' : 'Vertrek' }}
                    </td>
                    <td>{{ $flight->status }}</td>
                    <td>
                        <a href="{{ route('flights.show', $flight->id) }}">
                            Bekijken
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        Geen vluchten beschikbaar.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>