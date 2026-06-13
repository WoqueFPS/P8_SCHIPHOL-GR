<div class="container" style="max-width:1000px; margin:2rem auto; padding: 0 1rem;">
    <h1>Actuele Vluchten Schiphol</h1>
    <p>Overzicht van alle geplande aankomsten en vertrekken.</p>

    <table style="width:100%; border-collapse:collapse; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <thead>
            <tr style="text-align:left; border-bottom:2px solid #ccc; background: #f8fafc;">
                <th style="padding:12px 8px">Vluchtnummer</th>
                <th style="padding:12px 8px">Maatschappij</th>
                <th style="padding:12px 8px">Herkomst / Bestemming</th>
                <th style="padding:12px 8px">Type</th>
                <th style="padding:12px 8px">Status</th>
                <th style="padding:12px 8px">Actie</th>
            </tr>
        </thead>

        <tbody>
            @forelse($flights as $flight)
                <tr style="border-bottom:1px solid #eee">
                    <td style="padding:12px 8px; font-weight: bold;">{{ $flight->flight_number }}</td>
                    
                    <td style="padding:12px 8px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            @if($flight->airline_logo)
                                <img src="{{ asset('storage/' . $flight->airline_logo) }}" width="25" height="25" style="object-fit:contain;">
                            @endif
                            <span>{{ $flight->airline }}</span>
                        </div>
                    </td>
                    
                    <td style="padding:12px 8px">
                        {{ $flight->type === 'arriving' ? $flight->origin : $flight->destination }}
                    </td>
                    <td style="padding:12px 8px">
                        {{ $flight->type === 'arriving' ? 'Aankomst' : 'Vertrek' }}
                    </td>
                    <td style="padding:12px 8px">
                        @if($flight->status === 'toekomstig')
                        <span style="background: #fef3c7; color: #d97706; padding: 2px 6px; border-radius: 4px; font-size: 12px; font-weight: bold;">Verlanglijst</span>
                        @elseif($flight->status === 'gepland')
                        <span style="background: #e0f2fe; color: #0369a1; padding: 2px 6px; border-radius: 4px; font-size: 12px; font-weight: bold;">Gepland</span>
                        @else
                        <span style="background: #e2e8f0; color: #475569; padding: 2px 6px; border-radius: 4px; font-size: 12px;">{{ ucfirst($flight->status) }}</span>
                        @endif
                    </td>
                    <td style="padding:12px 8px">
                        <a href="{{ route('flights.show', $flight->id) }}">
                            <button type="button" style="padding: 4px 8px; cursor: pointer;">Meer info</button>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="padding:16px; text-align:center; color:#888;">Geen vluchten beschikbaar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>