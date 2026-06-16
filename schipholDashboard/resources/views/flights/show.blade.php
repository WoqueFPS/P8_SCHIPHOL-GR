<div style="max-width:600px; margin:2rem auto;">
    <h1>Vlucht naar: {{ $flight->destination }}</h1>

    <p><strong>Luchtvaartmaatschappij:</strong> {{ $flight->airline }}</p>
    <p><strong>Vluchtnummer:</strong> {{ $flight->flight_number }}</p>
    <p><strong>Vertrek vanaf:</strong> {{ $flight->origin }}</p>
    <p><strong>Geplande tijd:</strong> {{ \Illuminate\Support\Carbon::parse($flight->scheduled_time)->format('H:i') }}</p>
    <p><strong>Gate:</strong> {{ $flight->gate ?? '-' }}</p>

    <hr style="margin:2rem 0;">

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
</div>