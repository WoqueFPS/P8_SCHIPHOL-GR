<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Coördinator Wijzigen</title>
</head>
<body>
    <h1>Coördinator Wijzigen</h1>
    <hr>

    <form action="{{ route('staff.reports.update', $coordinator->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="naam">Naam:</label><br>
        <input type="text" id="naam" name="naam" value="{{ $coordinator->name }}" required><br><br>

        <label for="afdeling">Afdeling:</label><br>
        <select id="afdeling" name="afdeling" required>
            <option value="Nationaal" {{ $coordinator->department == 'Nationaal' ? 'selected' : '' }}>Nationaal</option>
            <option value="Internationaal" {{ $coordinator->department == 'Internationaal' ? 'selected' : '' }}>Internationaal</option>
        </select><br><br>

        <button type="submit">Bijwerken</button>
        <a href="{{ route('staff.reports.index') }}">Annuleren</a>
    </form>
</body>
</html>