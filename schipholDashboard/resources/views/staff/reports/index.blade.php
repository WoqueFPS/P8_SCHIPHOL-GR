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

    <div class="reports-dsh-app-shell">
        <main class="reports-dsh-main" style="width:100%;">

            <div class="reports-dsh-topbar">
                <div>
                    <h2>Schiphol Directeur Dashboard</h2>
                    <p>Live overzicht van vluchtcoördinatoren en operationele status.</p>
                </div>
                <div class="reports-dsh-topbar-actions">
                    <a href="{{ route('staff.reports.create') }}">
                        <button class="reports-dsh-btn reports-dsh-btn-primary">
                            <span>&#43;</span> Nieuwe coördinator toevoegen
                        </button>
                    </a>
                </div>
            </div>

            {{-- STAT CARDS --}}
            <section class="reports-dsh-stats-grid">
                <div class="reports-dsh-stat-card">
                    <div class="reports-dsh-stat-top">
                        <div class="reports-dsh-stat-icon">&#128101;</div>
                        <span class="reports-dsh-stat-trend">Totaal</span>
                    </div>
                    <div class="reports-dsh-stat-value">{{ $totaalCoordinatoren }}</div>
                    <div class="reports-dsh-stat-label">Vluchtcoördinatoren</div>
                </div>

                <div class="reports-dsh-stat-card">
                    <div class="reports-dsh-stat-top">
                        <div class="reports-dsh-stat-icon">&#9992;</div>
                        <span class="reports-dsh-stat-trend">Vandaag</span>
                    </div>
                    <div class="reports-dsh-stat-value">{{ $actieveVluchten }}</div>
                    <div class="reports-dsh-stat-label">Actieve vluchten</div>
                </div>

                <div class="reports-dsh-stat-card">
                    <div class="reports-dsh-stat-top">
                        <div class="reports-dsh-stat-icon">&#10071;</div>
                        <span class="reports-dsh-stat-trend">Open</span>
                    </div>
                    <div class="reports-dsh-stat-value">{{ $openMeldingen }}</div>
                    <div class="reports-dsh-stat-label">Open meldingen</div>
                </div>
            </section>

            {{-- COORDINATOR TABLE --}}
            <section class="reports-dsh-panel">
                <div class="reports-dsh-panel-header">
                    <div>
                        <h3>Vluchtcoördinatoren</h3>
                        <p>Beheer alle coördinatoren: toevoegen, wijzigen en verwijderen.</p>
                    </div>
                </div>
                <div class="reports-dsh-panel-body">
                    <div class="reports-dsh-table-wrap">
                        <table class="reports-dsh-coordinators">
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
                                        <div class="reports-dsh-coord-name">
                                            <div class="reports-dsh-avatar">{{ strtoupper(substr($coordinator->name, 0, 1)) }}</div>
                                            <div>{{ $coordinator->name }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $coordinator->department }}</td>
                                    <td>
                                        <span class="reports-dsh-badge reports-dsh-badge-actief"><span class="reports-dsh-badge-dot"></span>Actief</span>
                                    </td>
                                    <td>
                                        <div class="reports-dsh-row-actions" style="justify-content:flex-end;">
                                            <a href="{{ route('staff.reports.show', $coordinator->id) }}">
                                                <button type="button" class="reports-dsh-btn reports-dsh-btn-icon reports-dsh-btn-ghost" title="Bekijken">&#128065;</button>
                                            </a>
                                            <a href="{{ route('staff.reports.edit', $coordinator->id) }}">
                                                <button type="button" class="reports-dsh-btn reports-dsh-btn-icon reports-dsh-btn-edit" title="Wijzigen">&#9998;</button>
                                            </a>
                                            <form action="{{ route('staff.reports.destroy', $coordinator->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="reports-dsh-btn reports-dsh-btn-icon reports-dsh-btn-delete" title="Verwijderen" onclick="return confirm('Weet je het zeker?')">
                                                    &#128465;
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="reports-dsh-empty-state">
                                            <div class="reports-dsh-stat-icon" style="margin:0 auto 14px;">&#128101;</div>
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

            {{--  DIRECTOR-EXCLUSIVE CONTROL PANEL  --}}
            <section class="reports-dsh-panel reports-dsh-director-exclusive" style="margin-top: 2rem;">
                <div class="reports-dsh-panel-header" style="border-bottom: none; padding-bottom: 0;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                            <h3 style="margin:0;"> Directeur Beheerconsole</h3>
                            <span class="reports-dsh-director-badge">Alleen directeuren</span>
                            <span class="reports-dsh-live-indicator"> Bevoegdheid: Hoog</span>
                        </div>
                        <p style="margin-top: 6px;">Strategische aanpassingen &amp; airport-wide beslissingen - exclusief voor de directie van Schiphol.</p>
                    </div>
                </div>
                <div class="reports-dsh-panel-body">
                    <div class="reports-dsh-control-grid">
                        <!-- CARD 1: Noodmodus & operationele status -->
                        <div class="reports-dsh-director-card">
                            <div class="reports-dsh-card-header">
                                <div class="reports-dsh-card-title">
                                    <span></span> Luchthavenstatus
                                </div>
                                <label class="reports-dsh-switch-toggle">
                                    <input type="checkbox" id="reports-dsh-noodModusToggle" {{ $noodmodus ? 'checked' : '' }}>
                                    <span class="reports-dsh-slider"></span>
                                </label>
                            </div>
                            <div id="reports-dsh-noodStatusText" style="font-weight: 600; margin-bottom: 8px;">
                                {{ $noodmodus ? ' NOODMODUS ACTIEF - alle niet-essentiële vluchten opgeschort' : ' Normale exploitatie - standaard procedures hervat' }}
                            </div>
                            <div style="font-size: 0.75rem; color: #4a5b6e;">Noodmodus activeert crisisprotocollen & prioriteitslijnen voor alle afdelingen.</div>
                            <div class="reports-dsh-quick-action-group" style="margin-top: 12px;">
                                <button id="reports-dsh-activateProtocolBtn" class="reports-dsh-director-btn" style="background:#7c2d1e;"> Stel code rood in</button>
                            </div>
                        </div>

                        <!-- CARD 2: Prioriteit & Strategische Toewijzing -->
                        <div class="reports-dsh-director-card">
                            <div class="reports-dsh-card-header">
                                <div class="reports-dsh-card-title">
                                    <span></span> Prioriteit & Toewijzing
                                </div>
                                <span style="font-size:0.7rem; background:#eef2ff; padding:2px 8px; border-radius:20px;">Directiebesluit</span>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="font-size:0.75rem; font-weight:600; margin-bottom:6px;"> Vliegtuigprioriteit</div>
                                <div class="reports-dsh-priority-group">
                                    <button data-priority="intercontinentaal" class="reports-dsh-priority-btn {{ $prioriteit == 'intercontinentaal' ? 'active' : '' }}"> Intercontinentaal</button>
                                    <button data-priority="europees" class="reports-dsh-priority-btn {{ $prioriteit == 'europees' ? 'active' : '' }}"> Europees</button>
                                    <button data-priority="cargo" class="reports-dsh-priority-btn {{ $prioriteit == 'cargo' ? 'active' : '' }}"> Cargo / Vracht</button>
                                </div>
                                <div id="reports-dsh-priorityStatus" style="font-size:0.7rem; background:#f1f5f9; padding:6px 8px; border-radius:16px; margin-top:8px;">
                                    Huidige focus: <strong id="reports-dsh-activePriorityLabel">
                                        @if($prioriteit == 'intercontinentaal') Intercontinentaal
                                        @elseif($prioriteit == 'europees') Europees
                                        @else Cargo / Vracht
                                        @endif
                                    </strong>
                                </div>
                            </div>
                            <hr style="margin: 12px 0; border-color:#e9edf2;">
                            <div>
                                <div style="font-size:0.75rem; font-weight:600; margin-bottom:8px;"> Herverdeling coördinatieteams</div>
                                <div id="reports-dsh-teamAllocationContainer">
                                    <div class="reports-dsh-team-row">
                                        <span class="reports-dsh-team-name"> Platform Oost</span>
                                        <span class="reports-dsh-badge-team" id="reports-dsh-teamOostStatus">{{ $teamAllocations['oost'] ?? 4 }} coördinatoren</span>
                                        <button class="reports-dsh-director-btn-outline" style="padding:0.2rem 0.8rem; font-size:0.7rem;" data-team="oost">+ Versterk</button>
                                    </div>
                                    <div class="reports-dsh-team-row">
                                        <span class="reports-dsh-team-name"> Platform West</span>
                                        <span class="reports-dsh-badge-team" id="reports-dsh-teamWestStatus">{{ $teamAllocations['west'] ?? 3 }} coördinatoren</span>
                                        <button class="reports-dsh-director-btn-outline" style="padding:0.2rem 0.8rem; font-size:0.7rem;" data-team="west">+ Versterk</button>
                                    </div>
                                    <div class="reports-dsh-team-row">
                                        <span class="reports-dsh-team-name"> Vracht & Logistiek</span>
                                        <span class="reports-dsh-badge-team" id="reports-dsh-teamCargoStatus">{{ $teamAllocations['cargo'] ?? 2 }} coördinatoren</span>
                                        <button class="reports-dsh-director-btn-outline" style="padding:0.2rem 0.8rem; font-size:0.7rem;" data-team="cargo">+ Versterk</button>
                                    </div>
                                </div>
                                <button id="reports-dsh-resetTeamsBtn" class="reports-dsh-director-btn-outline" style="width:100%; margin-top:12px; justify-content:center;">⟳ Reset naar standaardbezetting</button>
                            </div>
                        </div>

                        <!-- CARD 3: Directiecirkel -->
                        <div class="reports-dsh-director-card">
                            <div class="reports-dsh-card-header">
                                <div class="reports-dsh-card-title">
                                    <span></span> Directiecirkel
                                </div>
                            </div>
                            <textarea id="reports-dsh-directorMessage" rows="2" style="width:100%; border-radius: 18px; border: 1px solid #cbd5e1; padding: 8px 12px; font-size:0.85rem;" placeholder="Typ een bericht voor alle coördinatoren en grondpersoneel..."></textarea>
                            <div class="reports-dsh-quick-action-group" style="margin-top: 12px;">
                                <button id="reports-dsh-broadcastMsgBtn" class="reports-dsh-director-btn"> Uitzenden naar alle terminals</button>
                                <button id="reports-dsh-resetMessageBtn" class="reports-dsh-director-btn reports-dsh-director-btn-outline"> Wissen</button>
                            </div>
                            <div id="reports-dsh-lastBroadcastPreview" style="margin-top: 12px; font-size: 0.7rem; background: #f1f5f9; padding: 8px; border-radius: 14px; color:#2d3e50;">
                                <em> Laatste directiebericht:</em> 
                                <span id="reports-dsh-broadcastHistory">
                                    @if($activeBroadcast && $activeBroadcast->message)
                                        "{{ substr($activeBroadcast->message, 0, 65) }}" ({{ $activeBroadcast->created_at->format('d-m-Y H:i') }})
                                    @else
                                        Nog geen bericht verzonden
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Extra director quick actions --}}
                    <div style="margin-top: 2rem; background:#eef3fa; border-radius: 20px; padding: 1rem 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                            <div>
                                <span style="font-weight:800;"> Alleen directeur: operationele herstart</span>
                                <div style="font-size:0.75rem;">Herstart wachtrijen en coördinatortaken bij extreme drukte</div>
                            </div>
                            <div style="display: flex; gap:10px;">
                                <button id="reports-dsh-resetCoordTasks" class="reports-dsh-director-btn-outline" style="background:white; border:1px solid #9aaebf;">Herstart coördinatieronde</button>
                                <button id="reports-dsh-exportDirectorSnapshot" class="reports-dsh-director-btn" style="background:#0b3b5f;"> Exporteer operationeel log</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <form action="{{ route('staff.logout') }}" method="POST" style="margin: 28px 0 20px 0;">
                @csrf
                <button type="submit" class="reports-dsh-btn reports-dsh-btn-ghost">Uitloggen</button>
            </form>

        </main>
    </div>

    @include('partials.footer')
</body>
</html>