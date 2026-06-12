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

<div class="reports-edit-app-shell">
    <main class="reports-edit-main" style="width:100%;">

        <div class="reports-edit-topbar">
            <div>
                <h2>Coördinator wijzigen</h2>
                <p>Pas de gegevens van {{ $coordinator->name }} aan.</p>
            </div>
            <div class="reports-edit-topbar-actions">
                <a href="{{ route('staff.reports.index') }}">
                    <button type="button" class="reports-edit-btn reports-edit-btn-ghost">&larr; Terug naar overzicht</button>
                </a>
            </div>
        </div>

        <section class="reports-edit-panel">
            <div class="reports-edit-panel-header">
                <div>
                    <h3>Gegevens coördinator</h3>
                    <p>ID #{{ $coordinator->id }} &middot; {{ $coordinator->email }}</p>
                </div>
            </div>

            <div class="reports-edit-panel-body">
                @if ($errors->any())
                    <div class="reports-edit-error-container" style="background:#fdecec; border:1px solid #f5c2c0; color:#c0392b; border-radius:9px; padding:14px 16px; margin-bottom:18px; font-size:13px;">
                        <ul style="margin:0; padding-left:18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('staff.reports.update', $coordinator->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="reports-edit-form-grid">
                        <div class="reports-edit-field reports-edit-field-full">
                            <label for="reports-edit-naam">Naam</label>
                            <input type="text" id="reports-edit-naam" name="naam" value="{{ old('naam', $coordinator->name) }}" required>
                        </div>

                        <div class="reports-edit-field reports-edit-field-full">
                            <label for="reports-edit-afdeling">Afdeling</label>
                            <select id="reports-edit-afdeling" name="afdeling" required>
                                <option value="Nationaal" {{ old('afdeling', $coordinator->department) == 'Nationaal' ? 'selected' : '' }}>Nationaal</option>
                                <option value="Internationaal" {{ old('afdeling', $coordinator->department) == 'Internationaal' ? 'selected' : '' }}>Internationaal</option>
                            </select>
                        </div>
                    </div>

                    <div class="reports-edit-modal-footer" style="justify-content:flex-start;">
                        <button type="submit" class="reports-edit-btn reports-edit-btn-primary">Bijwerken</button>
                        <a href="{{ route('staff.reports.index') }}">
                            <button type="button" class="reports-edit-btn reports-edit-btn-ghost">Annuleren</button>
                        </a>
                    </div>
                </form>
            </div>
        </section>

    </main>
</div>

@include('partials.footer')
</body>
</html>