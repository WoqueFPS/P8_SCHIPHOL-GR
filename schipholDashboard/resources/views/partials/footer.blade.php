<footer class="site-footer">
  <div class="site-footer__inner">

    <div class="site-footer__grid">

      <div class="site-footer__brand">
        <a href="{{ route('home') }}" class="site-footer__logo">
          <div class="site-footer__logo-mark">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 16.5l-10-13-10 13"/>
              <path d="M2 16.5h20"/>
              <path d="M12 3.5v13"/>
            </svg>
          </div>
          <span>Gatekeepers Schiphol</span>
        </a>
        <p class="site-footer__brand-desc">Het centrale dashboard voor reizigers, vluchtcoördinatoren en directieleden van Amsterdam Schiphol · AMS.</p>
        <div class="site-footer__socials">
          <a href="#" class="site-footer__social" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.5" fill="currentColor"/></svg>
          </a>
          <a href="#" class="site-footer__social" aria-label="LinkedIn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
          </a>
          <a href="https://www.schiphol.nl" class="site-footer__social" aria-label="Schiphol.nl" target="_blank" rel="noopener">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
          </a>
        </div>
      </div>

      <div class="site-footer__col">
        <h4 class="site-footer__col-heading">Reiziger</h4>
        <ul class="site-footer__col-list">
          <li><a href="{{ route('flights.index') }}">Vluchten zoeken</a></li>
          <li><a href="{{ route('login') }}">Boeking maken</a></li>
          <li><a href="{{ route('terms.show') }}">Gebruiksvoorwaarden</a></li>
        </ul>
      </div>

      <div class="site-footer__col">
        <h4 class="site-footer__col-heading">Personeel</h4>
        <ul class="site-footer__col-list">
          <li><a href="{{ route('staff.login') }}">Personeel login</a></li>
          @auth
            @if(Auth::user()->role === 'coordinator' || Auth::user()->role === 'admin')
              <li><a href="{{ route('staff.flights.manage') }}">Vluchtbeheer</a></li>
            @endif
            @if(Auth::user()->role === 'directeur' || Auth::user()->role === 'admin')
              <li><a href="{{ route('staff.reports.index') }}">Rapportages</a></li>
            @endif
          @endauth
        </ul>
      </div>

      <div class="site-footer__col">
        <h4 class="site-footer__col-heading">Informatie</h4>
        <ul class="site-footer__col-list">
          <li><a href="{{ route('terms.show') }}">Voorwaarden</a></li>
          <li><a href="https://www.schiphol.nl" target="_blank" rel="noopener">Schiphol.nl ↗</a></li>
        </ul>
      </div>

    </div>

    <div class="site-footer__bottom">
      <p class="site-footer__copy">© {{ date('Y') }} Gatekeepers Schiphol Dashboard. Alle rechten voorbehouden.</p>
      <ul class="site-footer__legal">
        <li><a href="{{ route('terms.show') }}">Gebruiksvoorwaarden</a></li>
      </ul>
    </div>

  </div>
</footer>