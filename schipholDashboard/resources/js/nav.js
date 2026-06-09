document.addEventListener('DOMContentLoaded', function () {
    const btn  = document.getElementById('siteNavHamburger');
    const menu = document.getElementById('siteNavMobile');
 
    if (!btn || !menu) return;
 
    btn.addEventListener('click', function () {
        const isOpen = btn.getAttribute('aria-expanded') === 'true';
        btn.setAttribute('aria-expanded', String(!isOpen));
 
        if (isOpen) {
            menu.setAttribute('hidden', '');
        } else {
            menu.removeAttribute('hidden');
        }
    });
 
    // Sluit menu bij klik buiten de nav
    document.addEventListener('click', function (e) {
        if (!btn.closest('.site-nav').contains(e.target)) {
            btn.setAttribute('aria-expanded', 'false');
            menu.setAttribute('hidden', '');
        }
    });
});
 
