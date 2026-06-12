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

@include('partials.navbar')

<div class="reports-show-app-shell">
    <main class="reports-show-main" style="width:100%;">

        <div class="reports-show-topbar">
            <div>
                <h2>Coördinator details</h2>
                <p>Volledig overzicht van deze vluchtcoördinator.</p>
            </div>
            <div class="reports-show-topbar-actions">
                <a href="{{ route('staff.reports.index') }}">
                    <button class="reports-show-btn reports-show-btn-ghost">&larr; Terug naar overzicht</button>
                </a>
            </div>
        </div>

        <section class="reports-show-panel">
            <div class="reports-show-panel-header">
                <div>
                    <h3>{{ $coordinator->name }}</h3>
                    <p>Vluchtcoördinator &middot; {{ $coordinator->department }}</p>
                </div>
                <span class="reports-show-badge reports-show-badge-actief"><span class="reports-show-badge-dot"></span>Actief</span>
            </div>

            <div class="reports-show-panel-body">
                <div style="display:flex; align-items:center; gap:18px; margin-bottom:24px;">
                    <div class="reports-show-avatar" style="width:64px; height:64px; font-size:24px;">
                        {{ strtoupper(substr($coordinator->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:18px; font-weight:700; color:var(--green-900);">{{ $coordinator->name }}</div>
                        <div style="font-size:13px; color:var(--gray-600);">{{ $coordinator->email }}</div>
                    </div>
                </div>

                <div class="reports-show-form-grid">
                    <div class="reports-show-field">
                        <label>ID</label>
                        <div style="padding:10px 12px; background:var(--gray-50); border:1px solid var(--gray-200); border-radius:9px;">
                            {{ $coordinator->id }}
                        </div>
                    </div>

                    <div class="reports-show-field">
                        <label>Rol</label>
                        <div style="padding:10px 12px; background:var(--gray-50); border:1px solid var(--gray-200); border-radius:9px; text-transform:capitalize;">
                            {{ $coordinator->role }}
                        </div>
                    </div>

                    <div class="reports-show-field">
                        <label>Afdeling</label>
                        <div style="padding:10px 12px; background:var(--gray-50); border:1px solid var(--gray-200); border-radius:9px;">
                            {{ $coordinator->department }}
                        </div>
                    </div>

                    <div class="reports-show-field">
                        <label>E-mailadres</label>
                        <div style="padding:10px 12px; background:var(--gray-50); border:1px solid var(--gray-200); border-radius:9px;">
                            {{ $coordinator->email }}
                        </div>
                    </div>

                    <div class="reports-show-field">
                        <label>Toegevoegd op</label>
                        <div style="padding:10px 12px; background:var(--gray-50); border:1px solid var(--gray-200); border-radius:9px;">
                            {{ $coordinator->created_at->translatedFormat('j F Y, H:i') }}
                        </div>
                    </div>

                    <div class="reports-show-field">
                        <label>Laatst bijgewerkt</label>
                        <div style="padding:10px 12px; background:var(--gray-50); border:1px solid var(--gray-200); border-radius:9px;">
                            {{ $coordinator->updated_at->translatedFormat('j F Y, H:i') }}
                        </div>
                    </div>
                </div>

                <div class="reports-show-modal-footer" style="justify-content:flex-start; margin-top:24px;">
                    <a href="{{ route('staff.reports.edit', $coordinator->id) }}">
                        <button type="button" class="reports-show-btn reports-show-btn-edit">&#9998; Wijzigen</button>
                    </a>

                    <form action="{{ route('staff.reports.destroy', $coordinator->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="reports-show-btn reports-show-btn-delete" onclick="return confirm('Weet je het zeker?')">
                            &#128465; Verwijderen
                        </button>
                    </form>
                </div>
            </div>
        </section>

    </main>
</div>

@include('partials.footer')
</body>
</html>