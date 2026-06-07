// clock
const MONTHS = ['JAN', 'FEB', 'MRT', 'APR', 'MEI', 'JUN', 'JUL', 'AUG', 'SEP', 'OKT', 'NOV', 'DEC'];
function updateClock(){
    const now = new Date();
    const clock = document.getElementById('clock');
    const dateline = document.getElementById('dateline');
    const h = String(now.getUTCHours()).padStart(2, '0');
    const m = String(now.getUTCMinutes()).padStart(2, '0');
    const s = String(now.getUTCSeconds()).padStart(2, '0');

    if (clock) {
        clock.textContent = `${h}:${m}:${s} UTC`;
    }

    if (dateline) {
        const day = String(now.getUTCDate()).padStart(2, '0');
        const month = MONTHS[now.getUTCMonth()];
        const year = now.getUTCFullYear();
        dateline.textContent = `${day} ${month} ${year}`;
    }
}

updateClock();
setInterval(updateClock, 1000);

// password toggle
const toggleBtn = document.getElementById('togglePw');
if (toggleBtn) {
    toggleBtn.onclick = function () {
        const input = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        if (!input) return;
        if (input.type === 'password') {
            input.type = 'text';

            if (eyeOpen)eyeOpen.style.display = 'none';
            if (eyeClosed)eyeClosed.style.display = '';
        } else {
            input.type = 'password';
            if (eyeOpen)eyeOpen.style.display = '';
            if (eyeClosed) eyeClosed.style.display = 'none';
        }
    };
}

// submit loading
const form = document.querySelector('form');
if (form){
    form.onsubmit = function () {
        const btn = document.getElementById('submitBtn');
        if (btn) {
            btn.disabled = true;
            btn.classList.add('loading');
        }
    };
}

// radar
const canvas = document.getElementById('radar-canvas');
if (canvas){
    const ctx = canvas.getContext('2d');
    const size = 700;
    const centerX = size / 2;
    const centerY = size / 2;
    const radius = 320;

    canvas.width = size;
    canvas.height = size;

    let rotation = 0;
    const blips = [];

    for (let i = 0; i < 12; i++) {
        blips.push({
            r: Math.random() * radius * 0.85 + 30,
            a: Math.random() * Math.PI * 2,
            life: Math.random()
        });
    }

    function renderRadar(){
        ctx.clearRect(0, 0, size, size);
        // circles
        ctx.strokeStyle = 'rgba(92,184,122,0.25)';
        ctx.lineWidth = 1;
        const rings = [0.25, 0.5, 0.75, 1];

        for (let i = 0; i < rings.length; i++) {
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius * rings[i], 0, Math.PI * 2);
            ctx.stroke();
        }

        // crosshair
        ctx.strokeStyle = 'rgba(92,184,122,0.15)';
        ctx.beginPath();
        ctx.moveTo(centerX - radius, centerY);
        ctx.lineTo(centerX + radius, centerY);
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo(centerX, centerY - radius);
        ctx.lineTo(centerX, centerY + radius);
        ctx.stroke();

        // sweep
        ctx.save();
        ctx.translate(centerX, centerY);
        ctx.rotate(rotation);

        const gradient = ctx.createRadialGradient(0, 0, 0, 0, 0, radius);
        gradient.addColorStop(0, 'rgba(92,184,122,0)');
        gradient.addColorStop(0.5, 'rgba(92,184,122,0.18)');
        gradient.addColorStop(1, 'rgba(92,184,122,0.08)');

        ctx.fillStyle = gradient;
        ctx.beginPath();
        ctx.moveTo(0, 0);
        ctx.arc(0, 0, radius, -0.05, 1.1);
        ctx.closePath();
        ctx.fill();
        ctx.restore();

        // line
        ctx.strokeStyle = 'rgba(92,184,122,0.6)';
        ctx.lineWidth = 1.5;

        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.lineTo(centerX + Math.cos(rotation) * radius,centerY + Math.sin(rotation) * radius);
        ctx.stroke();

        // blips
        for (let i = 0; i < blips.length; i++) {
            const b = blips[i];
            let diff = (b.a - rotation) % (Math.PI * 2);

            if (diff < 0){
                diff += Math.PI * 2;
            }
            if (diff < 0.3){
                b.life = 1;
            }

            if (b.life > 0){
                ctx.fillStyle = `rgba(92,184,122,${b.life * 0.9})`;
                ctx.beginPath();
                ctx.arc(
                    centerX + Math.cos(b.a) * b.r,
                    centerY + Math.sin(b.a) * b.r,
                    3,
                    0,
                    Math.PI * 2
                );

                ctx.fill();
                b.life -= 0.005;
                if (b.life < 0) {
                    b.life = 0;
                }
            }
        }
        rotation += 0.012;
        if (rotation > Math.PI * 2) { rotation = 0;} requestAnimationFrame(renderRadar);
    }
    renderRadar();
}

//hulpmiddelen
//https://codepen.io/?utm_source
//https://developer.mozilla.org/en-US/docs/Web/API/Window/requestAnimationFrame?utm_source
//https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API?utm_source
