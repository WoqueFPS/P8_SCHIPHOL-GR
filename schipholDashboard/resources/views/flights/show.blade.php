<h1>Vlucht naar: {{ $flight->destination }}</h1>

<p><strong>Luchtvaartmaatschappij:</strong> {{ $flight->airline }}</p>
<p><strong>Vluchtnummer:</strong> {{ $flight->flight_number }}</p>
<p><strong>Vertrek vanaf:</strong> {{ $flight->origin }}</p>
<p><strong>Geplande tijd:</strong> {{ $flight->scheduled_time }}</p>

<hr>

<h3>Persoonlijke gegevens invullen om te boeken:</h3>

<form method="POST" action="{{ route('bookings.store') }}">
    @csrf

    <input type="text" name="first_name" placeholder="Voornaam" required>
    <input type="text" name="last_name" placeholder="Achternaam" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="text" name="phone" placeholder="Telefoonnummer" required>

    <button type="submit">
        Vlucht boeken
    </button>
</form>
