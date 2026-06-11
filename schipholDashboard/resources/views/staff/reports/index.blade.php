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
    <p>Totaal Vluchtcoördinatoren: 12</p>
    <p>Actieve Vluchten: 48</p>
    <p>Open Meldingen: 3</p>
    <hr>
    <h2>Vluchtcoördinatoren</h2>
    <a href="/coordinatoren/create">
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
            <tr>
                <td>1</td>
                <td>Yu Narukami</td>
                <td>Internationaal</td>
                <td>Actief</td>
                <td>
                    <a href="/coordinatoren/1/edit">
                        <button>Wijzigen</button>
                    </a>

                    <form action="/coordinatoren/1" method="POST">
                        @csrf

                        @method('DELETE')

                        <button type="submit">
                            Verwijderen
                        </button>

                    </form>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td>Kiryu Kazuma</td>
                <td>Nationaal</td>
                <td>Actief</td>
                <td>

                    <a href="/coordinatoren/2/edit">
                        <button>Wijzigen</button>
                    </a>

                    <form action="/coordinatoren/2" method="POST">

                        @csrf
                        @method('DELETE')

                        <button type="submit">
                            Verwijderen
                        </button>

                    </form>
                </td>
            </tr>
        </tbody>
    </table>

    <form action="{{ route('staff.logout') }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit">
        Uitloggen
    </button>
    </form>

</body>
</html>