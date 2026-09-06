document.querySelectorAll('[data-confirm]').forEach((element) => {
    element.addEventListener('click', (event) => {
        if (!window.confirm(element.dataset.confirm)) event.preventDefault();
    });
});

const themeToggle = document.querySelector('.theme-toggle');
if (themeToggle) {
    const setThemeIcon = () => {
        const isDark = document.documentElement.dataset.theme === 'dark';
        themeToggle.innerHTML = `<i class="fa-solid fa-${isDark ? 'sun' : 'moon'}"></i>`;
        themeToggle.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to night mode');
        themeToggle.setAttribute('title', isDark ? 'Switch to light mode' : 'Switch to night mode');
    };
    setThemeIcon();
    themeToggle.addEventListener('click', () => {
        const isDark = document.documentElement.dataset.theme === 'dark';
        document.documentElement.dataset.theme = isDark ? 'light' : 'dark';
        localStorage.setItem('moneymap-theme', isDark ? 'light' : 'dark');
        setThemeIcon();
    });
}
