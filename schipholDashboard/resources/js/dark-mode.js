export function initDarkMode() {
  const html = document.documentElement;
  const toggle = document.getElementById('theme-toggle');

  function applyTheme(isDark) {
    if (isDark) {
      html.classList.add('dark');
    } else {
      html.classList.remove('dark');
    }
  }

  function getStoredTheme() {
    const stored = localStorage.getItem('theme');
    if (stored) return stored === 'dark';
    return window.matchMedia('(prefers-color-scheme: dark)').matches;
  }

  function setTheme(isDark) {
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    applyTheme(isDark);
    updateToggleState(isDark);
  }

  function updateToggleState(isDark) {
    if (toggle) {
      toggle.classList.toggle('dark-mode-active', isDark);
      toggle.setAttribute('aria-pressed', isDark);
      const icon = toggle.querySelector('svg');
      if (icon) {
        icon.style.transform = isDark ? 'rotate(180deg)' : 'rotate(0deg)';
      }
    }
  }

  if (toggle) {
    toggle.addEventListener('click', () => {
      const isDark = !html.classList.contains('dark');
      setTheme(isDark);
    });
  }

  const isDark = getStoredTheme();
  applyTheme(isDark);
  updateToggleState(isDark);

  window.toggleDarkMode = () => {
    const isDark = !html.classList.contains('dark');
    setTheme(isDark);
  };
}
