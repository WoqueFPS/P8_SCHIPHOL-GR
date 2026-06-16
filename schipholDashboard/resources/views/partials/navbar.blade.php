<nav class="site-nav">
  <div class="site-nav__inner">

    <a href="{{ route('home') }}" class="site-nav__logo">
    <img src="{{ asset('img/schiphol-logo.png') }}"
         alt="Schiphol Logo"
         class="site-nav__logo-image">

    <span class="site-nav__logo-text">
        Gatekeepers <span class="site-nav__logo-accent">Schiphol</span>
    </span>
</a>

    <ul class="site-nav__links">
      <li><a href="{{ route('home') }}" class="site-nav__link {{ request()->routeIs('home') ? 'site-nav__link--active' : '' }}">Home</a></li>
      <li><a href="{{ route('flights.index') }}" class="site-nav__link {{ request()->routeIs('flights.*') ? 'site-nav__link--active' : '' }}">Vluchten</a></li>
      <li><a href="{{ route('contact.index') }}" class="site-nav__link {{ request()->routeIs('contact.index') ? 'site-nav__link--active' : '' }}">Contact</a></li>
      @auth
        <li><a href="{{ route('bookings.index') }}" class="site-nav__link {{ request()->routeIs('bookings.*') ? 'site-nav__link--active' : '' }}">Mijn boekingen</a></li>
      @endauth
    </ul>

    <div class="site-nav__right">
      <span class="site-nav__live-badge">LIVE</span>
      @auth
        <span class="site-nav__btn site-nav__btn--ghost">{{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" style="margin:0">
          @csrf
          <button type="submit" class="site-nav__btn site-nav__btn--primary">Uitloggen</button>
        </form>
      @else
        <a href="{{ route('staff.login') }}" class="site-nav__btn site-nav__btn--ghost">Personeel</a>
        <a href="{{ route('login') }}" class="site-nav__btn site-nav__btn--primary">Inloggen</a>
      @endauth
    </div>

    <button class="site-nav__hamburger" id="siteNavHamburger" aria-label="Menu openen" aria-expanded="false" aria-controls="siteNavMobile">
      <span></span>
      <span></span>
      <span></span>
    </button>

  </div>

  <div class="site-nav__mobile" id="siteNavMobile" hidden>
    <a href="{{ route('home') }}" class="site-nav__mobile-link {{ request()->routeIs('home') ? 'site-nav__mobile-link--active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      Home
    </a>
    <a href="{{ route('flights.index') }}" class="site-nav__mobile-link {{ request()->routeIs('flights.*') ? 'site-nav__mobile-link--active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.5l-10-13-10 13"/><path d="M2 16.5h20"/><path d="M12 3.5v13"/></svg>
      Vluchten bekijken
    </a>
    @auth
      <a href="{{ route('bookings.index') }}" class="site-nav__mobile-link {{ request()->routeIs('bookings.*') ? 'site-nav__mobile-link--active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        Mijn boekingen
      </a>
    @endauth
    <div class="site-nav__mobile-divider"></div>
    @auth
      @if(Auth::user()->role === 'coordinator' || Auth::user()->role === 'admin')
        <a href="{{ route('staff.flights.manage') }}" class="site-nav__mobile-link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          Vluchtbeheer
        </a>
      @endif
      @if(Auth::user()->role === 'directeur' || Auth::user()->role === 'admin')
        <a href="{{ route('staff.reports.index') }}" class="site-nav__mobile-link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          Rapportages
        </a>
      @endif
      <form method="POST" action="{{ route('logout') }}" style="margin:0">
        @csrf
        <button type="submit" class="site-nav__mobile-link site-nav__mobile-link--highlight" style="width:100%; background:none; border:none; cursor:pointer; text-align:left;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          Uitloggen
        </button>
      </form>
    @else
      <a href="{{ route('staff.login') }}" class="site-nav__mobile-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Login personeel
      </a>
      <a href="{{ route('login') }}" class="site-nav__mobile-link site-nav__mobile-link--highlight">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        Inloggen
      </a>
    @endauth
  </div>
</nav>
