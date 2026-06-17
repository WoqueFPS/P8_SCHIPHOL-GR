<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schiphol Dashboard</title>
    <link rel="icon" href="{{ asset('images/logo/schiphol.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- cache uitzetten anders blijft het hangen --}}
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Expires" content="0">
    <link rel="icon" type="image/png" href="{{ asset('img/schiphol-logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

{{-- HERO — COMPACTERE VERSIE (kleiner & strakker) --}}
<div class="verify-hero">
    <div class="verify-hero-inner">
        <div class="verify-hero-eyebrow"><span>✦</span> Legal</div>
        <h1>Algemene Voorwaarden & Privacybeleid</h1>
        <p class="verify-hero-sub">
            Welkom bij Schiphol Dashboard. Door akkoord te gaan, ga je akkoord met de verwerking van persoonsgegevens, 
            de veiligheid van je account en de platformregels.
        </p>
        <div class="verify-hero-meta">
            <span class="verify-meta-item"><span class="verify-meta-dot"></span>Versie 4.2</span>
            <span class="verify-meta-item"><span class="verify-meta-dot"></span>Geldig vanaf 1 januari 2025</span>
            <span class="verify-meta-item"><span class="verify-meta-dot"></span>Nederlands recht</span>
        </div>
    </div>
</div>

<div class="verify-layout">
    <aside class="verify-sidebar">
        <div class="verify-sidebar-card">
            <div class="verify-sidebar-title">Inhoudsopgave</div>
            <a class="verify-toc-item verify-active" href="#verify-s1" onclick="verifySetActive(this)"><span class="verify-toc-num">1</span>Definities</a>
            <a class="verify-toc-item" href="#verify-s2" onclick="verifySetActive(this)"><span class="verify-toc-num">2</span>Toegang &amp; Gebruik</a>
            <a class="verify-toc-item" href="#verify-s3" onclick="verifySetActive(this)"><span class="verify-toc-num">3</span>Verplichtingen Passagier</a>
            <a class="verify-toc-item" href="#verify-s4" onclick="verifySetActive(this)"><span class="verify-toc-num">4</span>Privacy &amp; Data</a>
            <a class="verify-toc-item" href="#verify-s5" onclick="verifySetActive(this)"><span class="verify-toc-num">5</span>Digitale Diensten</a>
            <a class="verify-toc-item" href="#verify-s6" onclick="verifySetActive(this)"><span class="verify-toc-num">6</span>Aansprakelijkheid</a>
            <a class="verify-toc-item" href="#verify-s7" onclick="verifySetActive(this)"><span class="verify-toc-num">7</span>Beveiligingsmaatregelen</a>
            <a class="verify-toc-item" href="#verify-s8" onclick="verifySetActive(this)"><span class="verify-toc-num">8</span>Toepasselijk recht</a>
        </div>

        {{-- ACCEPT PANEL (scroll requirement intern, zonder expliciet scroll-blokje) --}}
        <div class="verify-sidebar-card">
            <div class="verify-sidebar-title">Akkoord & voltooien</div>
            
            <div id="verify-agreeWrapper" class="verify-agree-checkbox-wrapper verify-disabled-checkbox">
                <label for="verify-dashboardAgreeCheckbox">
                    <input type="checkbox" id="verify-dashboardAgreeCheckbox" disabled>
                    <span>Ik ga akkoord met de 
                        <a href="{{ route('terms.show') }}" target="_blank" class="verify-inline-link" id="verify-termsLink">Algemene Voorwaarden</a>
                    </span>
                </label>
            </div>
            <button class="verify-accept-btn" id="verify-prettyAcceptBtn" disabled>Akkoord</button>
            <button class="verify-decline-btn" id="verify-prettyDeclineBtn">Niet akkoord</button>
            <div class="verify-helper-text">Je moet eerst volledig door de voorwaarden scrollen (rechterkolom) om akkoord te kunnen gaan.</div>
        </div>

        <div class="verify-sidebar-card" style="background:var(--verify-green-50);border-color:var(--verify-green-100)">
            <div class="verify-sidebar-title" style="color:var(--verify-green-600)">Hulp nodig?</div>
            <p style="font-size:.75rem;color:var(--verify-green-700);line-height:1.5;">
                legal@schiphol.nl
            </p>
        </div>
    </aside>

    <main class="verify-content">
        {{-- SCROLLABLE TERMS & CONDITIONS (vereist volledig scrollen) --}}
        <div class="verify-terms-scrollable-area">
            <div id="verify-termsScrollBox" class="verify-terms-scroll-box">
                <div class="verify-section" id="verify-s1">
                    <div class="verify-section-header">
                        <div class="verify-section-icon"><svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg></div>
                        <div><div class="verify-section-num">Sectie 01</div><h2>Definities</h2></div>
                    </div>
                    <p>In deze Algemene Voorwaarden wordt verstaan onder: "Schiphol" of "wij": Amsterdam Airport Schiphol N.V., ingeschreven bij de Kamer van Koophandel onder nummer 34046996. "Passagier": elke natuurlijke persoon die gebruikmaakt van de luchthaven of digitale diensten. "Dashboard": het Schiphol Dashboard platform inclusief alle bijbehorende functionaliteiten.</p>
                    <div class="verify-highlight-box"><p>Door gebruik te maken van Schiphol Dashboard ga je akkoord met de verwerking van persoonsgegevens zoals beschreven in ons privacybeleid.</p></div>
                </div>
         
                <div class="verify-section" id="verify-s2">
                    <div class="verify-section-header"><div class="verify-section-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg></div><div><div class="verify-section-num">Sectie 02</div><h2>Toegang &amp; Gebruik Dashboard</h2></div></div>
                    <p>Toegang tot het Schiphol Dashboard is alleen toegestaan na acceptatie van deze voorwaarden. Gebruikers dienen te allen tijde de veiligheidsinstructies op te volgen en hun accountgegevens vertrouwelijk te behandelen.</p>
                    <ul class="verify-terms-list"><li>Je bent verantwoordelijk voor alle activiteiten die plaatsvinden via jouw account.</li><li>Het delen van inloggegevens met derden is verboden.</li><li>Schiphol behoudt zich het recht voor de toegang te ontzeggen bij niet-naleving.</li></ul>
                </div>
         
                <div class="verify-section" id="verify-s3">
                    <div class="verify-section-header"><div class="verify-section-icon"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div><div><div class="verify-section-num">Sectie 03</div><h2>Verplichtingen Passagier <span class="verify-tag verify-tag-important">Belangrijk</span></h2></div></div>
                    <p>Als gebruiker van het Dashboard ga je akkoord met de platformregels: je zult geen misbruik maken van het systeem, geen schadelijke code verspreiden en de rechten van andere gebruikers respecteren.</p>
                    <div class="verify-highlight-box"><p>Overtreding kan leiden tot onmiddellijke blokkering van het account en verdere juridische stappen.</p></div>
                </div>
         
                <div class="verify-section" id="verify-s4">
                    <div class="verify-section-header"><div class="verify-section-icon"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div><div><div class="verify-section-num">Sectie 04</div><h2>Privacy &amp; Gegevensverwerking <span class="verify-tag verify-tag-new">Geüpdatet</span></h2></div></div>
                    <p>Schiphol verwerkt persoonsgegevens in overeenstemming met de Algemene Verordening Gegevensbescherming (AVG). Door akkoord te gaan ga je ermee akkoord dat persoonsgegevens worden verwerkt ten behoeve van het Dashboard, beveiliging en optimalisatie.</p>
                    <ul class="verify-terms-list"><li>Je hebt recht op inzage, correctie en verwijdering van jouw gegevens.</li><li>Gegevens worden niet aan derden verkocht voor commerciële doeleinden.</li><li>Bewaartermijnen: maximaal 12 maanden tenzij wettelijk anders vereist.</li></ul>
                </div>
         
                <div class="verify-section" id="verify-s5"><div class="verify-section-header"><div class="verify-section-icon"><svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg></div><div><div class="verify-section-num">Sectie 05</div><h2>Digitale Diensten &amp; Dashboard Functionaliteit</h2></div></div><p>Het Dashboard biedt realtime informatie, reisupdates en persoonlijke instellingen. Schiphol kan de beschikbaarheid van het Dashboard tijdelijk beperken voor onderhoud. Schiphol is niet aansprakelijk voor indirecte schade door technische storingen.</p></div>
         
                <div class="verify-section" id="verify-s6"><div class="verify-section-header"><div class="verify-section-icon"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div><div><div class="verify-section-num">Sectie 06</div><h2>Beperking Aansprakelijkheid</h2></div></div><p>Schiphol is niet aansprakelijk voor verlies van gegevens of schade voortvloeiend uit het niet kunnen raadplegen van het Dashboard, tenzij sprake is van opzet of grove schuld. Gebruikers dienen zelf back-ups te bewaren.</p></div>
         
                <div class="verify-section" id="verify-s7"><div class="verify-section-header"><div class="verify-section-icon"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg></div><div><div class="verify-section-num">Sectie 07</div><h2>Beveiligingsmaatregelen</h2></div></div><p>Schiphol hanteert passende technische en organisatorische maatregelen om persoonsgegevens te beveiligen. Gebruikers zijn verplicht om verdachte activiteiten onmiddellijk te melden via legal@schiphol.nl.</p></div>
         
                <div class="verify-section" id="verify-s8"><div class="verify-section-header"><div class="verify-section-icon"><svg viewBox="0 0 24 24"><path d="M3 12a9 9 0 1 0 18 0 9 9 0 0 0-18 0"/><path d="M3.6 9h16.8M3.6 15h16.8M11.5 3a17 17 0 0 0 0 18M12.5 3a17 17 0 0 1 0 18"/></svg></div><div><div class="verify-section-num">Sectie 08</div><h2>Toepasselijk recht & Geschillen</h2></div></div><p>Op deze voorwaarden is Nederlands recht van toepassing. Geschillen worden voorgelegd aan de bevoegde rechter in Amsterdam. Schiphol behoudt zich het recht voor deze voorwaarden te wijzigen; wijzigingen worden via het Dashboard gecommuniceerd.</p></div>
                
                <div id="verify-endOfTermsMarker" style="height: 2px; width: 100%;"></div>
            </div>
        </div>
    </main>
</div>

<div id="verify-toast"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>Voorwaarden geaccepteerd</div>

{{-- backend forms (ongewijzigd) --}}
<div class="verify-backend-forms">
    <form method="POST" action="/terms/accept" id="verify-acceptForm">
        @csrf
        <input type="hidden" name="agree" id="verify-backendAgreeHidden" value="1">
    </form>
    <form method="POST" action="/terms/reject" id="verify-rejectForm">
        @csrf
    </form>
</div>
</body>
</html>