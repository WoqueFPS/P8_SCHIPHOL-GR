<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schiphol Directeur Dashboard</title>
</head>
<body>
    <h1>Schiphol Directeur Dashboard</h1>
    <hr>
    <h2>Dashboard Overzicht</h2>
    <p>Totaal Vluchtcoördinatoren: {{ $totaalCoordinatoren }}</p>
    <p>Actieve Vluchten: {{ $actieveVluchten }}</p>
    <p>Open Meldingen: {{ $openMeldingen }}</p>
    <hr>
    
    <h2>Vluchtcoördinatoren</h2>
    <a href="{{ route('staff.reports.create') }}">
        <button>Nieuwe Coördinator Toevoegen</button>
    </a>
    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Afdeling</th>
                <th>Status</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coordinatoren as $coordinator)
            <tr>
                <td>{{ $coordinator->id }}</td>
                <td>{{ $coordinator->name }}</td>
                <td>{{ $coordinator->department }}</td>
                <td>Actief</td>
                <td>
                    <a href="{{ route('staff.reports.edit', $coordinator->id) }}">
                        <button>Wijzigen</button>
                    </a>

                    <form action="{{ route('staff.reports.destroy', $coordinator->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Weet je het zeker?')">
                            Verwijderen
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <form action="{{ route('staff.logout') }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit">Uitloggen</button>
    </form>
</body>
</html>