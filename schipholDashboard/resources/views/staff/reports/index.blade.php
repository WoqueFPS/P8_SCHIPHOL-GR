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
<body>

    {{-- NAVBAR --}}
    @include('partials.navbar')

    <div class="app-shell">
        <main class="main" style="width:100%;">

            <div class="topbar">
                <div>
                    <h2>Schiphol Directeur Dashboard</h2>
                    <p>Live overzicht van vluchtcoördinatoren en operationele status.</p>
                </div>
                <div class="topbar-actions">
                    <a href="{{ route('staff.reports.create') }}">
                        <button class="btn btn-primary">
                            <span>&#43;</span> Nieuwe coördinator toevoegen
                        </button>
                    </a>
                </div>
            </div>

            {{-- STAT CARDS --}}
            <section class="stats-grid">
                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-icon">&#128101;</div>
                        <span class="stat-trend">Totaal</span>
                    </div>
                    <div class="stat-value">{{ $totaalCoordinatoren }}</div>
                    <div class="stat-label">Vluchtcoördinatoren</div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-icon">&#9992;</div>
                        <span class="stat-trend">Vandaag</span>
                    </div>
                    <div class="stat-value">{{ $actieveVluchten }}</div>
                    <div class="stat-label">Actieve vluchten</div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-icon">&#10071;</div>
                        <span class="stat-trend">Open</span>
                    </div>
                    <div class="stat-value">{{ $openMeldingen }}</div>
                    <div class="stat-label">Open meldingen</div>
                </div>
            </section>

            {{-- COORDINATOR TABLE --}}
            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h3>Vluchtcoördinatoren</h3>
                        <p>Beheer alle coördinatoren: toevoegen, wijzigen en verwijderen.</p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-wrap">
                        <table class="coordinators">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Naam</th>
                                    <th>Afdeling</th>
                                    <th>Status</th>
                                    <th style="text-align:right;">Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coordinatoren as $coordinator)
                                <tr>
                                    <td>{{ $coordinator->id }}</td>
                                    <td>
                                        <div class="coord-name">
                                            <div class="avatar">{{ strtoupper(substr($coordinator->name, 0, 1)) }}</div>
                                            <div>{{ $coordinator->name }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $coordinator->department }}</td>
                                    <td>
                                        <span class="badge badge-actief"><span class="badge-dot"></span>Actief</span>
                                    </td>
                                    <td>
                                        <div class="row-actions" style="justify-content:flex-end;">
                                            <a href="{{ route('staff.reports.show', $coordinator->id) }}">
                                                <button type="button" class="btn btn-icon btn-ghost" title="Bekijken">&#128065;</button>
                                            </a>

                                            <a href="{{ route('staff.reports.edit', $coordinator->id) }}">
                                                <button type="button" class="btn btn-icon btn-edit" title="Wijzigen">&#9998;</button>
                                            </a>

                                            <form action="{{ route('staff.reports.destroy', $coordinator->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-delete" title="Verwijderen" onclick="return confirm('Weet je het zeker?')">
                                                    &#128465;
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">
                                            <div class="stat-icon" style="margin:0 auto 14px;">&#128101;</div>
                                            Nog geen vluchtcoördinatoren toegevoegd.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <form action="{{ route('staff.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-ghost">Uitloggen</button>
            </form>

        </main>
    </div>

    {{-- FOOTER --}}
    @include('partials.footer')
    </body>
    </html>