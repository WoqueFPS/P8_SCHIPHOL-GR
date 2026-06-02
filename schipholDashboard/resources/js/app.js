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