<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>{{ $flight->exists ? 'Vlucht wijzigen' : 'Vlucht toevoegen' }}</title>
    @vite('resources/css/app.css')
</head>
<body>

<div style="max-width:550px;margin:2rem auto">
    <h1>{{ $flight->exists ? 'Vlucht wijzigen' : 'Vlucht toevoegen' }}</h1>

    @if (session('success'))
        <div style="background:#eaf3de;color:#27500a;padding:10px;border-radius:6px;margin-bottom:1rem">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background:#fdecea;color:#a32d2d;padding:10px;border-radius:6px;margin-bottom:1rem">
            <ul style="margin:0;padding-left:1.2rem">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $flight->exists ? route('staff.flights.update', $flight) : route('staff.flights.store') }}">
        @csrf
        @if ($flight->exists)
            @method('PUT')
        @endif

        <div style="margin-bottom:1rem">
            <label>Vluchtnummer</label><br>
            <input type="text" name="flight_number" value="{{ old('flight_number', $flight->flight_number) }}" style="width:100%" placeholder="bv. KL1023">
        </div>

        <div style="display:flex;gap:10px;margin-bottom:1rem">
            <div style="flex:1">
                <label>Maatschappij</label><br>
                <input type="text" name="airline" value="{{ old('airline', $flight->airline) }}" style="width:100%" placeholder="bv. KLM">
            </div>
            <div style="width:90px">
                <label>Code</label><br>
                <input type="text" name="airline_code" value="{{ old('airline_code', $flight->airline_code) }}" style="width:100%" placeholder="KL">
            </div>
        </div>

        <div style="display:flex;gap:10px;margin-bottom:1rem">
            <div style="flex:1">
                <label>Herkomst</label><br>
                <input type="text" name="origin" value="{{ old('origin', $flight->origin) }}" style="width:100%" placeholder="bv. Amsterdam">
            </div>
            <div style="flex:1">
                <label>Bestemming</label><br>
                <input type="text" name="destination" value="{{ old('destination', $flight->destination) }}" style="width:100%" placeholder="bv. Madrid">
            </div>
        </div>

        <div style="display:flex;gap:10px;margin-bottom:1rem">
            <div style="flex:1">
                <label>Type</label><br>
                <select name="type" style="width:100%">
                    <option value="departing" {{ old('type', $flight->type) === 'departing' ? 'selected' : '' }}>Vertrekkend</option>
                    <option value="arriving" {{ old('type', $flight->type) === 'arriving' ? 'selected' : '' }}>Aankomend</option>
                </select>
            </div>
            <div style="flex:1">
                <label>Geplande tijd</label><br>
                <input type="time" name="scheduled_time" value="{{ old('scheduled_time', \Carbon\Carbon::parse($flight->scheduled_time)->format('H:i')) }}" style="width:100%">
            </div>
        </div>

        <div style="display:flex;gap:10px;margin-bottom:1rem">
            <div style="flex:1">
                <label>Terminal</label><br>
                <input type="text" name="terminal" value="{{ old('terminal', $flight->terminal) }}" style="width:100%" placeholder="bv. 2">
            </div>
            <div style="flex:1">
                <label>Gate</label><br>
                <input type="text" name="gate" value="{{ old('gate', $flight->gate) }}" style="width:100%" placeholder="bv. B03">
            </div>
            <div style="flex:1">
                <label>Vertraging (min)</label><br>
                <input type="number" name="delay_minutes" value="{{ old('delay_minutes', $flight->delay_minutes ?? 0) }}" style="width:100%" min="0">
            </div>
        </div>

        <div style="margin-bottom:1.5rem">
            <label>Status</label><br>
            <select name="status" style="width:100%">
                @php
                    $statuses = [
                    'op-tijd'      => 'Op tijd',
                    'vertraging'   => 'Vertraging',
                    'boarding'     => 'Boarding',
                    'geland'       => 'Geland',
                    'geannuleerd'  => 'Geannuleerd',
                    ];
                @endphp
                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" {{ old('status', $flight->status) === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:8px">
            <a href="{{ route('staff.flights.manage') }}">
                <button type="button">Annuleren</button>
            </a>
            <button type="submit">{{ $flight->exists ? 'Opslaan' : 'Toevoegen' }}</button>
        </div>
    </form>
</div>

</body>
</html>