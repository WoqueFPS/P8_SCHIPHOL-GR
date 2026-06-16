<div style="max-width:600px; margin:2rem auto;">
    <h1>Vlucht naar: {{ $flight->destination }}</h1>

    <p><strong>Luchtvaartmaatschappij:</strong> {{ $flight->airline }}</p>
    <p><strong>Vluchtnummer:</strong> {{ $flight->flight_number }}</p>
    <p><strong>Vertrek vanaf:</strong> {{ $flight->origin }}</p>
    <p><strong>Geplande tijd:</strong> {{ \Illuminate\Support\Carbon::parse($flight->scheduled_time)->format('H:i') }}</p>
    <p><strong>Gate:</strong> {{ $flight->gate ?? '-' }}</p>

    <p>
        <strong>Beschikbare stoelen:</strong>
        {{ $flight->seats_available }}
    </p>

    <hr style="margin:2rem 0;">

    @if($flight->seats_available > 0)
        <h3>Persoonlijke gegevens invullen om te boeken:</h3>

        <form method="POST" action="{{ route('bookings.store') }}">
            @csrf
            <input type="hidden" name="flight_id" value="{{ $flight->id }}">

            <div style="margin-bottom:1rem">
                <input type="text" name="first_name" placeholder="Voornaam" required style="width:100%; padding:8px; margin-bottom:5px;">
                <input type="text" name="last_name" placeholder="Achternaam" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:1rem">
                <input type="text" name="address" placeholder="Adres" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:1rem">
                <input type="email" name="email" placeholder="E-mail" required style="width:100%; padding:8px; margin-bottom:5px;">
                <input type="text" name="phone" placeholder="Telefoonnummer" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:1rem">
                <label>
                    <input type="checkbox" name="confirm" value="1" required>
                    Ik ga akkoord met de kosten
                </label>
            </div>

            <button type="submit" style="background:#2563eb; color:white; padding:10px 20px; border:none; border-radius:4px; cursor:pointer;">
                Vlucht definitief boeken
            </button>
        </form>
    @else
        <div style="padding:15px; background:#fee2e2; border:1px solid #ef4444; border-radius:4px;">
            Deze vlucht is volgeboekt.
        </div>
    @endif

    @if($flight->seats_available <= 0)
        <hr style="margin:2rem 0;">

        <h2>Alternatieve vluchten</h2>

        @if($alternativeFlights->count())
            @foreach($alternativeFlights as $alternative)
                <div style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
                    <h3>{{ $alternative->flight_number }} - {{ $alternative->airline }}</h3>

                    <p>
                        {{ $alternative->origin }}
                        →
                        {{ $alternative->destination }}
                    </p>

                    <p>
                        Beschikbare stoelen:
                        {{ $alternative->seats_available }}
                    </p>

                    <a
                        href="{{ route('flights.show', $alternative->id) }}"
                        style="display:inline-block;background:#16a34a;color:white;padding:8px 12px;text-decoration:none;border-radius:4px;"
                    >
                        Selecteer deze vlucht
                    </a>
                </div>
            @endforeach
        @else
            <p>Geen alternatieve vluchten beschikbaar.</p>
        @endif
    @endif
</div>