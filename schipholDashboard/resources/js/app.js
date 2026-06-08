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

//!!terms verify functions!!
//!!scroll functions!!
const verifyScrollContainer = document.getElementById('verify-termsScrollBox');
const verifyAgreeCheckbox = document.getElementById('verify-dashboardAgreeCheckbox');
const verifyAcceptBtn = document.getElementById('verify-prettyAcceptBtn');
const verifyDeclineBtn = document.getElementById('verify-prettyDeclineBtn');
const verifyAgreeWrapper = document.getElementById('verify-agreeWrapper');
const verifyTermsLink = document.getElementById('verify-termsLink');
const verifyPrivacyLink = document.getElementById('verify-privacyLink');
const verifyToastEl = document.getElementById('verify-toast');

let verifyHasScrolledToBottom = false;
function verifyIsScrolledToBottom(){
    if (!verifyScrollContainer) return false;
    const scrollTop = verifyScrollContainer.scrollTop;
    const clientHeight = verifyScrollContainer.clientHeight;
    const scrollHeight = verifyScrollContainer.scrollHeight;
    return (scrollTop + clientHeight + 3) >= scrollHeight;
}

function verifyUpdateScrollRequirementState() {
    const atBottom = verifyIsScrolledToBottom();
    if (atBottom && !verifyHasScrolledToBottom) {
        verifyHasScrolledToBottom = true;
        // checkbox + wrapper active
        verifyAgreeCheckbox.disabled = false;
        verifyAgreeWrapper.classList.remove("verify-disabled-checkbox");
        verifyAgreeWrapper.classList.add("verify-enabled-checkbox");
        
        verifyAcceptBtn.disabled = false;
        if (verifyTermsLink) verifyTermsLink.classList.remove('verify-disabled-link');
        if (verifyPrivacyLink) verifyPrivacyLink.classList.remove('verify-disabled-link');
        //toast
        verifyShowToast("Je hebt de volledige voorwaarden doorlopen. Je kunt nu akkoord gaan.", true);
    } 
    else if (!atBottom && !verifyHasScrolledToBottom) {
        verifyAgreeCheckbox.disabled = true;
        verifyAgreeCheckbox.checked = false;
        verifyAgreeWrapper.classList.add("verify-disabled-checkbox");
        verifyAgreeWrapper.classList.remove("verify-enabled-checkbox");
        verifyAcceptBtn.disabled = true;
        if (verifyTermsLink) verifyTermsLink.classList.add('verify-disabled-link');
        if (verifyPrivacyLink) verifyPrivacyLink.classList.add('verify-disabled-link');
    }

    if (verifyHasScrolledToBottom){
        verifyAgreeCheckbox.disabled = false;
        verifyAgreeWrapper.classList.remove("verify-disabled-checkbox");
        verifyAgreeWrapper.classList.add("verify-enabled-checkbox");
        verifyAcceptBtn.disabled = false;
        if (verifyTermsLink) verifyTermsLink.classList.remove('verify-disabled-link');
        if (verifyPrivacyLink) verifyPrivacyLink.classList.remove('verify-disabled-link');
    }
}

function verifyShowToast(message, isSuccess = true) {
    verifyToastEl.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg> ${message}`;
    verifyToastEl.classList.add('verify-show');
    setTimeout(() => verifyToastEl.classList.remove('verify-show'), 3500);
}

if (verifyScrollContainer){
    verifyScrollContainer.addEventListener('scroll', verifyUpdateScrollRequirementState);
    window.addEventListener('resize', () => verifyUpdateScrollRequirementState());
    setTimeout(verifyUpdateScrollRequirementState, 100);
}

// toc actief met scrolle
function verifySetActive(el){
    document.querySelectorAll('.verify-toc-item').forEach(i => i.classList.remove('verify-active'));
    el.classList.add('verify-active');
}

const verifySections = document.querySelectorAll('.verify-section[id]');
const verifyItems = document.querySelectorAll('.verify-toc-item');

window.addEventListener('scroll', () =>{
    let cur = '';
    verifySections.forEach(s => { 
        if (window.scrollY >= s.offsetTop - 120) cur = s.id.replace('verify-', ''); 
    });
    verifyItems.forEach(i =>{ 
        i.classList.toggle('verify-active', i.getAttribute('href') === '#verify-' + cur); 
    });
},{passive: true });

//accept & toast msgs
verifyAcceptBtn.addEventListener('click', (e) => {
    e.preventDefault();
    if (!verifyHasScrolledToBottom) {
        verifyShowToast("Je moet eerst volledig door de voorwaarden scrollen voordat je akkoord kan gaan.", false);
        return;
    }
    if (!verifyAgreeCheckbox.checked) {
        verifyShowToast("Je moet het akkoordvakje aanvinken.", false);
        return;
    }
    const verifyAcceptForm = document.getElementById('verify-acceptForm');
    const verifyHiddenAgree = document.getElementById('verify-backendAgreeHidden');
    if (verifyHiddenAgree) verifyHiddenAgree.value = '1';
    verifyAcceptForm.submit();
    verifyShowToast("Verwerking... je wordt doorgestuurd.");
});

verifyDeclineBtn.addEventListener('click',(e) =>{
    e.preventDefault();
    const verifyRejectForm = document.getElementById('verify-rejectForm');
    verifyRejectForm.submit();
    verifyShowToast("Je hebt de voorwaarden niet geaccepteerd. Je wordt omgeleid.");
});

verifyUpdateScrollRequirementState();