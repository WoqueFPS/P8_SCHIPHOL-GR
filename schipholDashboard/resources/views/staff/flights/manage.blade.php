<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>{{ $flight->exists ? 'Vlucht wijzigen' : 'Vlucht toevoegen' }}</title>
    @vite('resources/css/app.css')
</head>
<body>

<div>
    <h1>{{ $flight->exists ? 'Vlucht wijzigen' : 'Vlucht toevoegen' }}</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $flight->exists ? route('staff.flights.update', $flight) : route('staff.flights.store') }}" enctype="multipart/form-data">
        @csrf
        @if ($flight->exists)
            @method('PUT')
        @endif

        <div>
            <label>Vluchtnummer</label>
            <input type="text" name="flight_number" value="{{ old('flight_number', $flight->flight_number) }}" placeholder="bv. KL1023">
        </div>

        <div>
            <label>Luchtvaartmaatschappij</label>
            <input type="text" name="airline" value="{{ old('airline', $flight->airline) }}" placeholder="bv. KLM">
        </div>

        <div>
            <label>IATA Code</label>
            <input type="text" name="airline_code" value="{{ old('airline_code', $flight->airline_code) }}" placeholder="KL">
        </div>

        <div>
            <label>Luchtvaartmaatschappij Logo</label>
            <input type="file" name="airline_logo">
            @if($flight->airline_logo)
                <div>
                    <small>Huidig opgeslagen logo:</small>
                    <img src="{{ asset('storage/' . $flight->airline_logo) }}" alt="Logo">
                </div>
            @endif
        </div>

        <div>
            <label>Herkomst</label>
            <input type="text" name="origin" value="{{ old('origin', $flight->origin) }}" placeholder="bv. Amsterdam">
        </div>

        <div>
            <label>Bestemming</label>
            <input type="text" name="destination" value="{{ old('destination', $flight->destination) }}" placeholder="bv. Madrid">
        </div>

        <div>
            <label>Type Vlucht</label>
            <select name="type">
                <option value="departing" {{ old('type', $flight->type) === 'departing' ? 'selected' : '' }}>Vertrekkend</option>
                <option value="arriving" {{ old('type', $flight->type) === 'arriving' ? 'selected' : '' }}>Aankomend</option>
            </select>
        </div>

        <div>
            <label>Geplande Tijd</label>
            <input type="time" name="scheduled_time" value="{{ old('scheduled_time', $flight->scheduled_time ? \Carbon\Carbon::parse($flight->scheduled_time)->format('H:i') : '') }}">
        </div>

        <div>
            <label>Terminal</label>
            <input type="text" name="terminal" value="{{ old('terminal', $flight->terminal) }}" placeholder="bv. 2">
        </div>

        <div>
            <label>Gate Nummer</label>
            <input type="text" name="gate" value="{{ old('gate', $flight->gate) }}" placeholder="bv. B03">
        </div>

        <div>
            <label>Gate Grootte</label>
            <select name="gate_type">
                <option value="standaard" {{ old('gate_type', $flight->gate_type) === 'standaard' ? 'selected' : '' }}>Standaard Gate</option>
                <option value="uitgebreid" {{ old('gate_type', $flight->gate_type) === 'uitgebreid' ? 'selected' : '' }}>Uitgebreid (Widebody)</option>
            </select>
        </div>

        <div>
            <label>Vertraging (min)</label>
            <input type="number" name="delay_minutes" value="{{ old('delay_minutes', $flight->delay_minutes ?? 0) }}" min="0">
        </div>

        <div>
            <label>Actuele Status</label>
            <select name="status">
                @php
                    $statuses = [
                        'op-tijd'      => 'Op tijd',
                        'vertraging'   => 'Vertraging',
                        'boarding'     => 'Boarding',
                        'geland'       => 'Geland',
                        'geannuleerd'  => 'Geannuleerd',
                        'gepland'      => 'Gepland (Aanwezigheid)',
                        'toekomstig'   => 'Toekomstig (Verlanglijst)',
                    ];
                @endphp
                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" {{ old('status', $flight->status) === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <a href="{{ route('staff.flights.manage') }}">
                <button type="button">Annuleren</button>
            </a>
            <button type="submit">
                {{ $flight->exists ? 'Opslaan' : 'Toevoegen' }}
            </button>
        </div>
    </form>
</div>

</body>
</html>