<h1>Alle boekingen</h1>

<table border="1">
    <tr>
        <th>Naam</th>
        <th>Email</th>
        <th>Telefoon</th>
        <th>Datum</th>
    </tr>

    @foreach($bookings as $booking)
        <tr>
            <td>{{ $booking->first_name }} {{ $booking->last_name }}</td>
            <td>{{ $booking->email }}</td>
            <td>{{ $booking->phone }}</td>
            <td>{{ $booking->created_at }}</td>
        </tr>
    @endforeach
</table>
