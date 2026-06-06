//homepage js functionaliteiten klok en zoekfunctie 
document.addEventListener('DOMContentLoaded', () => {

    const clockEl = document.getElementById('homepage-liveClock');
    const dateEl  = document.getElementById('homepage-liveDate');

    const days = ['zondag', 'maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag'];
    const months = ['jan', 'feb', 'mrt', 'apr', 'mei', 'jun', 'jul', 'aug', 'sep', 'okt', 'nov', 'dec'];

    function updateClock() {
        const now = new Date();
        let hh = now.getHours();
        let mm = now.getMinutes();
        
        //geprobeerd
        //if (hh < 10) hh = '0' + hh;
        hh = String(hh).padStart(2, '0');
        mm = String(mm).padStart(2, '0');
        
        if (clockEl) clockEl.textContent = hh + ':' + mm;
        
        if (dateEl) {
            const dagNaam = days[now.getDay()];
            const dagNum = now.getDate();
            const maand = months[now.getMonth()];
            const jaar = now.getFullYear();
            dateEl.textContent = dagNaam + ' ' + dagNum + ' ' + maand + ' ' + jaar;
        }
    }

    updateClock();
    setInterval(updateClock, 1000);

    // ZOEKFUNCTIE - werkt maar kan sneller denk ik
    const searchInput = document.getElementById('homepage-searchInput');
    const searchBtn = document.querySelector('.homepage-hero__search-btn');

    function filterFlights(){
        let searchTerm = '';
        
        if (searchInput) {
            searchTerm = searchInput.value.trim().toLowerCase();
        }
        
        const allRows = document.querySelectorAll('.homepage-flight-row[data-search]');
        
        if (searchTerm === '') {
            allRows.forEach(row => {
                row.style.opacity = '1';
            });
        } else {
            //filter
            allRows.forEach(row => {
                const searchData = row.dataset.search || '';
                if (searchData.includes(searchTerm)) {
                    row.style.opacity = '1';
                } else {
                    row.style.opacity = '0.2';
                }
            });
        }
    }

    //zoek of eventlisteners bestaan voor errors
    if (searchInput) {
        searchInput.addEventListener('input', filterFlights);
    }
    
    if (searchBtn) {
        searchBtn.addEventListener('click', filterFlights);
    }
    
    // fix als je zoekt en leegmaakt dat t blijft werken
});


//wachtwoord toggle login en register
window.toggleLoginPassword = function() {
    const input = document.getElementById('login_password');
    const eyeIcon = document.getElementById('login-eye-icon');
    
    if (!input || !eyeIcon) return;
    
    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94z"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19z"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        input.type = 'password';
        eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
};

window.toggleRegisterPassword = function() {
    const input = document.getElementById('register_password');
    const eyeIcon = document.getElementById('register-eye-icon-pw');
    
    if (!input || !eyeIcon) return;
    
    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94z"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19z"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        input.type = 'password';
        eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
};

window.toggleRegisterPasswordConfirm = function() {
    const input = document.getElementById('register_password_confirmation');
    const eyeIcon = document.getElementById('register-eye-icon-confirm');
    
    if (!input || !eyeIcon) return;
    
    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94z"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19z"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        input.type = 'password';
        eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
};