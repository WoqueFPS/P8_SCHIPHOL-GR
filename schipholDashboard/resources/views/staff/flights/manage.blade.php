<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schiphol Dashboard</title>
    <link rel="icon" href="{{ asset('images/logo/schiphol.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Expires" content="0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="fc-body">
{{-- NAVBAR --}}
@include('partials.navbar')
<div class="ff-page">

    <div class="ff-header">
        <h1 class="ff-title">{{ $flight->exists ? 'Vlucht wijzigen' : 'Vlucht toevoegen' }}</h1>
    </div>

    @if ($errors->any())
        <div class="ff-errors">
            <ul class="ff-errors__list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="ff-card">
        <form method="POST" action="{{ $flight->exists ? route('staff.flights.update', $flight) : route('staff.flights.store') }}" enctype="multipart/form-data">
            @csrf
            @if ($flight->exists)
                @method('PUT')
            @endif

            <div class="ff-section-label">Vluchtidentificatie</div>
            <div class="ff-field-row">
                <div class="ff-field">
                    <label class="ff-label" for="flight_number">Vluchtnummer</label>
                    <input class="ff-input" type="text" id="flight_number" name="flight_number"
                           value="{{ old('flight_number', $flight->flight_number) }}" placeholder="bv. KL1023">
                </div>
                <div class="ff-field">
                    <label class="ff-label" for="airline">Luchtvaartmaatschappij</label>
                    <input class="ff-input" type="text" id="airline" name="airline"
                           value="{{ old('airline', $flight->airline) }}" placeholder="bv. KLM">
                </div>
                <div class="ff-field ff-field--small">
                    <label class="ff-label" for="airline_code">IATA Code</label>
                    <input class="ff-input ff-input--mono" type="text" id="airline_code" name="airline_code"
                           value="{{ old('airline_code', $flight->airline_code) }}" placeholder="KL">
                </div>
            </div>

            <div class="ff-field">
                <label class="ff-label" for="airline_logo">Logo maatschappij</label>
                <input class="ff-input ff-input--file" type="file" id="airline_logo" name="airline_logo">
                @if($flight->airline_logo)
                    <div class="ff-logo-preview">
                        <span class="ff-logo-preview__label">Huidig logo:</span>
                        <img class="ff-logo-preview__img" src="{{ asset('storage/' . $flight->airline_logo) }}" alt="Logo">
                    </div>
                @endif
            </div>

            <div class="ff-divider"></div>
            <div class="ff-section-label">Route</div>

            <div class="ff-field-row">
                <div class="ff-field">
                    <label class="ff-label" for="origin">Herkomst</label>
                    <input class="ff-input" type="text" id="origin" name="origin"
                           value="{{ old('origin', $flight->origin) }}" placeholder="bv. Amsterdam">
                </div>
                <div class="ff-field">
                    <label class="ff-label" for="destination">Bestemming</label>
                    <input class="ff-input" type="text" id="destination" name="destination"
                           value="{{ old('destination', $flight->destination) }}" placeholder="bv. Madrid">
                </div>
                <div class="ff-field ff-field--small">
                    <label class="ff-label" for="type">Type vlucht</label>
                    <select class="ff-select" id="type" name="type">
                        <option value="departing" {{ old('type', $flight->type) === 'departing' ? 'selected' : '' }}>Vertrekkend</option>
                        <option value="arriving"  {{ old('type', $flight->type) === 'arriving'  ? 'selected' : '' }}>Aankomend</option>
                    </select>
                </div>
            </div>

            <div class="ff-divider"></div>
            <div class="ff-section-label">Planning & Gate</div>

            <div class="ff-field-row">
                <div class="ff-field ff-field--small">
                    <label class="ff-label" for="scheduled_time">Geplande tijd</label>
                    <input class="ff-input ff-input--mono" type="time" id="scheduled_time" name="scheduled_time"
                           value="{{ old('scheduled_time', $flight->scheduled_time ? \Carbon\Carbon::parse($flight->scheduled_time)->format('H:i') : '') }}">
                </div>
                <div class="ff-field ff-field--small">
                    <label class="ff-label" for="terminal">Terminal</label>
                    <input class="ff-input ff-input--mono" type="text" id="terminal" name="terminal"
                           value="{{ old('terminal', $flight->terminal) }}" placeholder="bv. 2">
                </div>
                <div class="ff-field ff-field--small">
                    <label class="ff-label" for="gate">Gate nummer</label>
                    <input class="ff-input ff-input--mono" type="text" id="gate" name="gate"
                           value="{{ old('gate', $flight->gate) }}" placeholder="bv. B03">
                </div>
                <div class="ff-field">
                    <label class="ff-label" for="gate_type">Gate grootte</label>
                    <select class="ff-select" id="gate_type" name="gate_type">
                        <option value="standaard" {{ old('gate_type', $flight->gate_type) === 'standaard'  ? 'selected' : '' }}>Standaard Gate</option>
                        <option value="uitgebreid" {{ old('gate_type', $flight->gate_type) === 'uitgebreid' ? 'selected' : '' }}>Uitgebreid (Widebody)</option>
                    </select>
                </div>
            </div>

            <div class="ff-divider"></div>
            <div class="ff-section-label">Status</div>

            <div class="ff-field-row">
                <div class="ff-field ff-field--small">
                    <label class="ff-label" for="delay_minutes">Vertraging (min)</label>
                    <input class="ff-input ff-input--mono" type="number" id="delay_minutes" name="delay_minutes"
                           value="{{ old('delay_minutes', $flight->delay_minutes ?? 0) }}" min="0">
                </div>
                <div class="ff-field">
                    <label class="ff-label" for="status">Actuele status</label>
                    <select class="ff-select" id="status" name="status">
                        @php
                            $statuses = [
                                'op-tijd'     => 'Op tijd',
                                'vertraging'  => 'Vertraging',
                                'boarding'    => 'Boarding',
                                'geland'      => 'Geland',
                                'geannuleerd' => 'Geannuleerd',
                                'gepland'     => 'Gepland (Aanwezigheid)',
                                'toekomstig'  => 'Toekomstig (Verlanglijst)',
                            ];
                        @endphp
                        @foreach ($statuses as $value => $label)
                            <option value="{{ $value }}" {{ old('status', $flight->status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="ff-actions">
                <a href="{{ route('staff.flights.manage') }}">
                    <button type="button" class="fc-btn fc-btn--ghost">Annuleren</button>
                </a>
                <button type="submit" class="fc-btn fc-btn--primary">
                    {{ $flight->exists ? 'Opslaan' : 'Vlucht toevoegen' }}
                </button>
            </div>

        </form>
    </div>
</div>
{{-- FOOTER --}}
@include('partials.footer')
</body>
</html>