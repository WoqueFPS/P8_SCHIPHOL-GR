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
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

{{-- NAVBAR --}}
@include('partials.navbar')

<!-- HERO -->
<div class="terms-hero">
    <div class="terms-hero-inner">
        <div class="terms-hero-eyebrow"><span>✦</span> Legal</div>
        <h1>Algemene Voorwaarden &amp; Privacybeleid</h1>
        <p class="terms-hero-sub">
            Welkom bij Schiphol Dashboard. Op deze pagina vind je alle informatie over hoe wij
            omgaan met jouw gegevens, de platformregels en de wettelijke kaders waarbinnen wij opereren.
        </p>
        <div class="terms-hero-meta">
            <span class="terms-hero-meta-item"><span class="terms-hero-meta-dot"></span>Versie 4.2</span>
            <span class="terms-hero-meta-item"><span class="terms-hero-meta-dot"></span>Geldig vanaf 1 januari 2025</span>
            <span class="terms-hero-meta-item"><span class="terms-hero-meta-dot"></span>Nederlands recht</span>
            <span class="terms-hero-meta-item"><span class="terms-hero-meta-dot"></span>Openbaar toegankelijk</span>
        </div>
    </div>
</div>

<div class="terms-layout">
    <!-- SIDEBAR -->
    <aside class="terms-sidebar">
        <div class="terms-sidebar-card">
            <div class="terms-sidebar-title">Inhoudsopgave</div>
            <a class="terms-toc-item terms-active" href="#terms-s1" id="terms-toc1"><span class="terms-toc-num">1</span>Definities</a>
            <a class="terms-toc-item" href="#terms-s2" id="terms-toc2"><span class="terms-toc-num">2</span>Toegang &amp; Gebruik</a>
            <a class="terms-toc-item" href="#terms-s3" id="terms-toc3"><span class="terms-toc-num">3</span>Verplichtingen Passagier</a>
            <a class="terms-toc-item" href="#terms-s4" id="terms-toc4"><span class="terms-toc-num">4</span>Privacy &amp; Data</a>
            <a class="terms-toc-item" href="#terms-s5" id="terms-toc5"><span class="terms-toc-num">5</span>Digitale Diensten</a>
            <a class="terms-toc-item" href="#terms-s6" id="terms-toc6"><span class="terms-toc-num">6</span>Aansprakelijkheid</a>
            <a class="terms-toc-item" href="#terms-s7" id="terms-toc7"><span class="terms-toc-num">7</span>Beveiligingsmaatregelen</a>
            <a class="terms-toc-item" href="#terms-s8" id="terms-toc8"><span class="terms-toc-num">8</span>Toepasselijk recht</a>
        </div>

        <div class="terms-sidebar-card">
            <div class="terms-sidebar-title">Acties</div>
            <div class="terms-action-pill">
                <button class="terms-btn-secondary" onclick="window.print()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Afdrukken
                </button>
                <button class="terms-btn-secondary" onclick="copyLink(event)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                    Kopieer link
                </button>
            </div>
        </div>

        <div class="terms-sidebar-card terms-help-card">
            <div class="terms-sidebar-title">Vragen?</div>
            <p>Neem contact op met onze juridische afdeling:<br>
            <a href="mailto:legal@schiphol.nl">legal@schiphol.nl</a></p>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="terms-content">

        <div class="terms-section" id="terms-s1">
            <div class="terms-section-header">
                <div class="terms-section-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                </div>
                <div><div class="terms-section-num">Sectie 01</div><h2>Definities</h2></div>
            </div>
            <p>In deze Algemene Voorwaarden wordt verstaan onder: <strong>"Schiphol"</strong> of <strong>"wij"</strong>: Amsterdam Airport Schiphol N.V., ingeschreven bij de Kamer van Koophandel onder nummer 34046996. <strong>"Passagier"</strong>: elke natuurlijke persoon die gebruikmaakt van de luchthaven of digitale diensten. <strong>"Dashboard"</strong>: het Schiphol Dashboard platform inclusief alle bijbehorende functionaliteiten.</p>
            <div class="terms-highlight-box">
                <p>Door gebruik te maken van Schiphol Dashboard ga je akkoord met de verwerking van persoonsgegevens zoals beschreven in ons privacybeleid.</p>
            </div>
        </div>

        <div class="terms-section" id="terms-s2">
            <div class="terms-section-header">
                <div class="terms-section-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg></div>
                <div><div class="terms-section-num">Sectie 02</div><h2>Toegang &amp; Gebruik Dashboard</h2></div>
            </div>
            <p>Toegang tot het Schiphol Dashboard is alleen toegestaan na acceptatie van deze voorwaarden. Gebruikers dienen te allen tijde de veiligheidsinstructies op te volgen en hun accountgegevens vertrouwelijk te behandelen.</p>
            <ul class="terms-terms-list">
                <li>Je bent verantwoordelijk voor alle activiteiten die plaatsvinden via jouw account.</li>
                <li>Het delen van inloggegevens met derden is verboden.</li>
                <li>Schiphol behoudt zich het recht voor de toegang te ontzeggen bij niet-naleving.</li>
            </ul>
        </div>

        <div class="terms-section" id="terms-s3">
            <div class="terms-section-header">
                <div class="terms-section-icon"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                <div><div class="terms-section-num">Sectie 03</div><h2>Verplichtingen Passagier <span class="terms-tag terms-tag-imp">Belangrijk</span></h2></div>
            </div>
            <p>Als gebruiker van het Dashboard ga je akkoord met de platformregels: je zult geen misbruik maken van het systeem, geen schadelijke code verspreiden en de rechten van andere gebruikers respecteren.</p>
            <div class="terms-highlight-box">
                <p>Overtreding kan leiden tot onmiddellijke blokkering van het account en verdere juridische stappen.</p>
            </div>
        </div>

        <div class="terms-section" id="terms-s4">
            <div class="terms-section-header">
                <div class="terms-section-icon"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
                <div><div class="terms-section-num">Sectie 04</div><h2>Privacy &amp; Gegevensverwerking <span class="terms-tag terms-tag-new">Geüpdatet</span></h2></div>
            </div>
            <p>Schiphol verwerkt persoonsgegevens in overeenstemming met de Algemene Verordening Gegevensbescherming (AVG). Door akkoord te gaan ga je ermee akkoord dat persoonsgegevens worden verwerkt ten behoeve van het Dashboard, beveiliging en optimalisatie.</p>
            <ul class="terms-terms-list">
                <li>Je hebt recht op inzage, correctie en verwijdering van jouw gegevens.</li>
                <li>Gegevens worden niet aan derden verkocht voor commerciële doeleinden.</li>
                <li>Bewaartermijnen: maximaal 12 maanden tenzij wettelijk anders vereist.</li>
            </ul>
        </div>

        <div class="terms-section" id="terms-s5">
            <div class="terms-section-header">
                <div class="terms-section-icon"><svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg></div>
                <div><div class="terms-section-num">Sectie 05</div><h2>Digitale Diensten &amp; Dashboard Functionaliteit</h2></div>
            </div>
            <p>Het Dashboard biedt realtime informatie, reisupdates en persoonlijke instellingen. Schiphol kan de beschikbaarheid van het Dashboard tijdelijk beperken voor onderhoud. Schiphol is niet aansprakelijk voor indirecte schade door technische storingen.</p>
        </div>

        <div class="terms-section" id="terms-s6">
            <div class="terms-section-header">
                <div class="terms-section-icon"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                <div><div class="terms-section-num">Sectie 06</div><h2>Beperking Aansprakelijkheid</h2></div>
            </div>
            <p>Schiphol is niet aansprakelijk voor verlies van gegevens of schade voortvloeiend uit het niet kunnen raadplegen van het Dashboard, tenzij sprake is van opzet of grove schuld. Gebruikers dienen zelf back-ups te bewaren van hun gegevens.</p>
        </div>

        <div class="terms-section" id="terms-s7">
            <div class="terms-section-header">
                <div class="terms-section-icon"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg></div>
                <div><div class="terms-section-num">Sectie 07</div><h2>Beveiligingsmaatregelen</h2></div>
            </div>
            <p>Schiphol hanteert passende technische en organisatorische maatregelen om persoonsgegevens te beveiligen. Gebruikers zijn verplicht om verdachte activiteiten onmiddellijk te melden via <a href="mailto:legal@schiphol.nl">legal@schiphol.nl</a>.</p>
        </div>

        <div class="terms-section" id="terms-s8">
            <div class="terms-section-header">
                <div class="terms-section-icon"><svg viewBox="0 0 24 24"><path d="M3 12a9 9 0 1 0 18 0 9 9 0 0 0-18 0"/><path d="M3.6 9h16.8M3.6 15h16.8M11.5 3a17 17 0 0 0 0 18M12.5 3a17 17 0 0 1 0 18"/></svg></div>
                <div><div class="terms-section-num">Sectie 08</div><h2>Toepasselijk recht &amp; Geschillen</h2></div>
            </div>
            <p>Op deze voorwaarden is Nederlands recht van toepassing. Geschillen worden voorgelegd aan de bevoegde rechter in Amsterdam. Schiphol behoudt zich het recht voor deze voorwaarden te wijzigen; wijzigingen worden via het Dashboard gecommuniceerd.</p>
        </div>

    </main>
</div>

{{-- FOOTER --}}
@include('partials.footer')

</body>
</html>