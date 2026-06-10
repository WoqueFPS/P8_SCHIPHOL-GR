//homepage js functionaliteiten klok en zoekfunctie 
import './nav.js';
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

    if (clockEl || dateEl) {
        updateClock();
        setInterval(updateClock, 1000);
    }

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


    //!!terms verify functions register!!
    //terms public functions & bit of a mess but it works and is only for the terms page so it's fine for now.
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
        if (!verifyScrollContainer || !verifyAgreeCheckbox || !verifyAcceptBtn) return;

        const atBottom = verifyIsScrolledToBottom();
        if (atBottom && !verifyHasScrolledToBottom) {
            verifyHasScrolledToBottom = true;
            // checkbox + wrapper active
            verifyAgreeCheckbox.disabled = false;
            if (verifyAgreeWrapper) {
                verifyAgreeWrapper.classList.remove("verify-disabled-checkbox");
                verifyAgreeWrapper.classList.add("verify-enabled-checkbox");
            }
            
            verifyAcceptBtn.disabled = false;
            if (verifyTermsLink) verifyTermsLink.classList.remove('verify-disabled-link');
            if (verifyPrivacyLink) verifyPrivacyLink.classList.remove('verify-disabled-link');
            //toast
            verifyShowToast("Je hebt de volledige voorwaarden doorlopen. Je kunt nu akkoord gaan.", true);
        } 
        else if (!atBottom && !verifyHasScrolledToBottom) {
            verifyAgreeCheckbox.disabled = true;
            verifyAgreeCheckbox.checked = false;
            if (verifyAgreeWrapper) {
                verifyAgreeWrapper.classList.add("verify-disabled-checkbox");
                verifyAgreeWrapper.classList.remove("verify-enabled-checkbox");
            }
            verifyAcceptBtn.disabled = true;
            if (verifyTermsLink) verifyTermsLink.classList.add('verify-disabled-link');
            if (verifyPrivacyLink) verifyPrivacyLink.classList.add('verify-disabled-link');
        }

        if (verifyHasScrolledToBottom){
            verifyAgreeCheckbox.disabled = false;
            if (verifyAgreeWrapper) {
                verifyAgreeWrapper.classList.remove("verify-disabled-checkbox");
                verifyAgreeWrapper.classList.add("verify-enabled-checkbox");
            }
            verifyAcceptBtn.disabled = false;
            if (verifyTermsLink) verifyTermsLink.classList.remove('verify-disabled-link');
            if (verifyPrivacyLink) verifyPrivacyLink.classList.remove('verify-disabled-link');
        }
    }

    function verifyShowToast(message, isSuccess = true) {
        if (!verifyToastEl) return;
        verifyToastEl.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg> ${message}`;
        verifyToastEl.classList.add('verify-show');
        setTimeout(() => verifyToastEl.classList.remove('verify-show'), 3500);
    }

    if (verifyScrollContainer){
        verifyScrollContainer.addEventListener('scroll', verifyUpdateScrollRequirementState);
        window.addEventListener('resize', () => verifyUpdateScrollRequirementState());
        setTimeout(verifyUpdateScrollRequirementState, 100);
    }

    //accept & toast msgs
    if (verifyAcceptBtn){
        verifyAcceptBtn.addEventListener('click', (e) =>{
            e.preventDefault();
            if (!verifyHasScrolledToBottom) {
                verifyShowToast("Je moet eerst volledig door de voorwaarden scrollen voordat je akkoord kan gaan.", false);
                return;
            }
            if (verifyAgreeCheckbox && !verifyAgreeCheckbox.checked) {
                verifyShowToast("Je moet het akkoordvakje aanvinken.", false);
                return;
            }
            const verifyAcceptForm = document.getElementById('verify-acceptForm');
            const verifyHiddenAgree = document.getElementById('verify-backendAgreeHidden');
            if (verifyHiddenAgree) verifyHiddenAgree.value = '1';
            if (verifyAcceptForm) verifyAcceptForm.submit();
            verifyShowToast("Verwerking... je wordt doorgestuurd.");
        });
    }

    if (verifyDeclineBtn){
        verifyDeclineBtn.addEventListener('click',(e) =>{
            e.preventDefault();
            const verifyRejectForm = document.getElementById('verify-rejectForm');
            if (verifyRejectForm) verifyRejectForm.submit();
            verifyShowToast("Je hebt de voorwaarden niet geaccepteerd. Je wordt omgeleid.");
        });
    }

    if (verifyScrollContainer) {
        verifyUpdateScrollRequirementState();
    }

    //terms public functions
    const termsSections = document.querySelectorAll('.terms-section');
    const termsTocItems = document.querySelectorAll('.terms-toc-item');

    if (termsSections.length > 0 && termsTocItems.length > 0){
        const termsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.id;
                    termsTocItems.forEach(item => {
                        item.classList.toggle('terms-active', item.getAttribute('href') === '#' + id);
                    });
                }
            });
        }, { rootMargin: '-20% 0px -70% 0px' });

        termsSections.forEach(section => termsObserver.observe(section));
    }

    //copy
    const copyLinkBtn = document.querySelector('button[onclick="copyLink(event)"]') || document.querySelector('.terms-btn-secondary:last-of-type');

    if (copyLinkBtn){
        copyLinkBtn.removeAttribute('onclick');
        copyLinkBtn.addEventListener('click', (event) =>{
            if (event) event.preventDefault();

            navigator.clipboard.writeText(window.location.href).then(() =>{
                const originalContent = copyLinkBtn.innerHTML;
                copyLinkBtn.innerHTML = `
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Gekopieerd!
                `;
                
                setTimeout(() =>{
                    copyLinkBtn.innerHTML = originalContent;
                }, 2000);
            }).catch(err =>{
                console.error('Kopieren mislukt: ', err);
            });
        });
    }
});


//wachtwoord toggle login and register
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

// toc actief met scrolle
const verifySections = document.querySelectorAll('.verify-section[id]');
const verifyItems = document.querySelectorAll('.verify-toc-item');

if (verifySections.length > 0 && verifyItems.length > 0){
    window.addEventListener('scroll', () =>{
        let cur= '';
        verifySections.forEach(s => { 
            if (window.scrollY >= s.offsetTop - 120) cur = s.id.replace('verify-', ''); 
        });
        verifyItems.forEach(i =>{ 
            i.classList.toggle('verify-active', i.getAttribute('href') === '#verify-' + cur); 
        });
    },{passive: true });
}