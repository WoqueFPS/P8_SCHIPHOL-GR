document.addEventListener('DOMContentLoaded', function(){
    // runway lights effects
    const runwayContainer = document.getElementById('login-admin-runwayLights');
    if (runwayContainer){
        for (let i = 0; i< 16; i++){
            const dot = document.createElement('div');
            dot.className = 'login-admin-runway-dot';
            dot.style.animationDelay = `${i * 0.15}s`;
            runwayContainer.appendChild(dot);
        }
    }

    // password visibility toggle
    const toggleBtn = document.getElementById('login-admin-togglePass');
    const passwordInput = document.getElementById('login-admin-password');
    const eyeIcon = document.getElementById('login-admin-eyeIcon');

    if (toggleBtn && passwordInput && eyeIcon) {
        toggleBtn.addEventListener('click', function(){
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            toggleBtn.setAttribute('aria-label', isPassword ? 'Verberg wachtwoord' : 'Toon wachtwoord');

            if (isPassword) {
                eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            }else{
                eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        });
    }

    const loginBtn = document.getElementById('login-admin-loginBtn');
    const loginForm = document.getElementById('login-admin-form');
    if (loginForm && loginBtn){
        loginForm.addEventListener('submit', function() {
            loginBtn.disabled = true;
            loginBtn.innerHTML = `
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     style="animation: login-admin-spin 0.8s linear infinite">
                    <path d="M21 12a9 9 0 11-6.219-8.56"/>
                </svg>
                Verbinden…
            `;
        });
    }
});
