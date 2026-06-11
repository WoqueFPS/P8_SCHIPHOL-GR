<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Nieuwe Coördinator Toevoegen</title>
</head>
<body>
    <h1>Nieuwe Coördinator Toevoegen</h1>
    <hr>

    <form action="{{ route('staff.reports.store') }}" method="POST">
        @csrf

        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label for="naam">Naam:</label><br>
        <input type="text" id="naam" name="naam" value="{{ old('naam') }}" required><br><br>

        <label for="afdeling">Afdeling:</label><br>
        <select id="afdeling" name="afdeling" required>
            <option value="">-- Kies een afdeling --</option>
            <option value="Nationaal" {{ old('afdeling') == 'Nationaal' ? 'selected' : '' }}>Nationaal</option>
            <option value="Internationaal" {{ old('afdeling') == 'Internationaal' ? 'selected' : '' }}>Internationaal</option>
        </select><br><br>

        <button type="submit">Opslaan</button>
        <a href="{{ route('staff.reports.index') }}">Annuleren</a>
    </form>
</body>
</html>