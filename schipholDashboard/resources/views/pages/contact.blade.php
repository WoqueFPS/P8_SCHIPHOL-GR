<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact & Ondersteuning</title>
    <link rel="icon" type="image/png" href="{{ asset('img/schiphol-logo.png') }}">
    @vite('resources/css/app.css')
</head>
<body class="fc-body">

@include('partials.navbar')

<div class="ct-page">

    <div class="ct-page-header">
        <h1 class="ct-title">Contact & ondersteuning</h1>
        <p class="ct-subtitle">Neem contact op met het Schiphol-team of stel een vraag via het formulier.</p>
    </div>

    <div class="ct-grid">

        {{-- Links: contactinfo --}}
        <div class="ct-left">

            <div class="ct-card">
                <div class="ct-info-header">
                    <h2 class="ct-info-header__title">Schiphol Operations</h2>
                    <p class="ct-info-header__sub">24/7 bereikbaar voor medewerkers</p>
                </div>
                <div class="ct-info-body">
                    <div class="ct-item">
                        <div class="ct-item__icon">!</div>
                        <div>
                            <div class="ct-item__label">Hoofdlijn</div>
                            <div class="ct-item__value">+31 20 794 0800</div>
                            <div class="ct-item__sub">Ma–vr 07:00–22:00</div>
                        </div>
                    </div>
                    <div class="ct-item">
                        <div class="ct-item__icon">!</div>
                        <div>
                            <div class="ct-item__label">E-mail</div>
                            <div class="ct-item__value">ops@schiphol.nl</div>
                            <div class="ct-item__sub">Reactie binnen 4 uur</div>
                        </div>
                    </div>
                    <div class="ct-item">
                        <div class="ct-item__icon">!</div>
                        <div>
                            <div class="ct-item__label">Locatie</div>
                            <div class="ct-item__value">Evert van de Beekstraat 202</div>
                            <div class="ct-item__sub">1118 CP Schiphol, Nederland</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ct-card ct-dept-card">
                <div class="ct-section-label">Afdelingen</div>
                <div class="ct-dept-list">
                    <div class="ct-dept-item">
                        <span class="ct-dept-item__name">Vluchtcoördinatie</span>
                        <span class="ct-dept-item__phone">794 0811</span>
                    </div>
                    <div class="ct-dept-item">
                        <span class="ct-dept-item__name">Bagageafhandeling</span>
                        <span class="ct-dept-item__phone">794 0822</span>
                    </div>
                    <div class="ct-dept-item">
                        <span class="ct-dept-item__name">Beveiliging</span>
                        <span class="ct-dept-item__phone">794 0833</span>
                    </div>
                    <div class="ct-dept-item">
                        <span class="ct-dept-item__name">IT & Systemen</span>
                        <span class="ct-dept-item__phone">794 0844</span>
                    </div>
                    <div class="ct-dept-item">
                        <span class="ct-dept-item__name">Noodlijn</span>
                        <span class="ct-dept-item__phone ct-dept-item__phone--emergency">112 intern</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- Rechts: formulier --}}
        <div class="ct-card ct-form-card">
            <h2 class="ct-form-title">Stuur een bericht</h2>

            <div class="ct-secure-note">
                Berichten worden alleen intern verwerkt
            </div>

            @if (session('success'))
                <div class="fc-alert fc-alert--success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="ff-errors">
                    <ul class="ff-errors__list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('contact.send') }}">
                @csrf

                <div class="ct-section-label">Uw gegevens</div>

                <div class="ff-field-row">
                    <div class="ff-field">
                        <label class="ff-label" for="first_name">Voornaam</label>
                        <input class="ff-input" type="text" id="first_name" name="first_name"
                               value="{{ old('first_name') }}" placeholder="Tony" required>
                    </div>
                    <div class="ff-field">
                        <label class="ff-label" for="last_name">Achternaam</label>
                        <input class="ff-input" type="text" id="last_name" name="last_name"
                               value="{{ old('last_name') }}" placeholder="Stark" required>
                    </div>
                </div>

                <div class="ff-field-row">
                    <div class="ff-field">
                        <label class="ff-label" for="email">E-mailadres</label>
                        <input class="ff-input" type="email" id="email" name="email"
                               value="{{ old('email') }}" placeholder="tony.stark@schiphol.nl" required>
                    </div>
                    <div class="ff-field">
                        <label class="ff-label" for="department">Afdeling</label>
                        <select class="ff-select" id="department" name="department">
                            <option value="">Selecteer afdeling</option>
                            @foreach(['Vluchtcoördinatie', 'Bagageafhandeling', 'Beveiliging', 'IT & Systemen', 'Directie', 'Overig'] as $dept)
                                <option value="{{ $dept }}" {{ old('department') === $dept ? 'selected' : '' }}>
                                    {{ $dept }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr class="ff-divider">
                <div class="ct-section-label">Uw bericht</div>

                <div class="ff-field">
                    <label class="ff-label" for="subject">Onderwerp</label>
                    <select class="ff-select" id="subject" name="subject" required>
                        <option value="">Kies een onderwerp</option>
                        @foreach(['Vluchtwijziging melden', 'Technische storing', 'Personeelszaak', 'Algemene vraag', 'Overig'] as $subj)
                            <option value="{{ $subj }}" {{ old('subject') === $subj ? 'selected' : '' }}>
                                {{ $subj }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="ff-field">
                    <label class="ff-label" for="message">Bericht</label>
                    <textarea class="ff-input ct-textarea" id="message" name="message"
                              placeholder="Omschrijf uw vraag of melding zo duidelijk mogelijk..."
                              required>{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="fc-btn fc-btn--primary ct-btn-submit">
                    Bericht verzenden
                </button>

            </form>
        </div>

    </div>
</div>

@include('partials.footer')

</body>
</html>