<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schiphol Dashboard - Voorwaarden Accepteren</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <h1>Algemene Voorwaarden & Privacybeleid</h1>
        
        <p>Welkom bij Schiphol Dashboard! Lees de volgende voorwaarden goed door.</p>
        
        <p>Door akkoord te gaan, ga je ermee akkoord dat:</p>
        <ul>
            <li>Je persoonlijke gegevens worden verwerkt volgens ons privacybeleid</li>
            <li>Je verantwoordelijk bent voor de veiligheid van je account</li>
            <li>Je de platform regels naleeft</li>
        </ul>
        
        <form method="POST" action="/terms/accept" id="acceptForm">
            @csrf
            <label>
                <input type="checkbox" name="agree" id="agreeCheckbox" required>
                Ik ga akkoord met de 
                <a href="{{ route('terms.show') }}" target="_blank">Algemene Voorwaarden</a> 
                en het 
                <a href="/privacy" target="_blank">Privacybeleid</a>.
            </label>
            <br><br>
            <button type="submit">Akkoord</button>
        </form>

        <br>
        
        <form method="POST" action="/terms/reject" id="rejectForm">
            @csrf
            <button type="submit" class="reject-btn">Niet akkoord</button>
        </form>
    </div>
</body>
</html>