document.querySelectorAll('.js-flash').forEach((element) => {
    const type = element.dataset.alertType === 'error' ? 'error' : 'success';
    if (window.Swal) {
        Swal.fire({ icon: type, title: type === 'success' ? 'All set' : 'Something needs attention', text: element.dataset.alertMessage, confirmButtonColor: '#1463d8', background: document.documentElement.dataset.theme === 'dark' ? '#172235' : '#ffffff', color: document.documentElement.dataset.theme === 'dark' ? '#edf2f7' : '#172033' });
        element.remove();
    }
});

document.querySelectorAll('[data-confirm]').forEach((element) => {
    element.addEventListener('click', (event) => {
        event.preventDefault();
        if (!window.Swal) { window.location.href = element.href; return; }
        Swal.fire({ title: 'Are you sure?', text: element.dataset.confirm, icon: 'warning', showCancelButton: true, confirmButtonText: 'Yes, continue', cancelButtonText: 'Cancel', confirmButtonColor: '#d94a5c', background: document.documentElement.dataset.theme === 'dark' ? '#172235' : '#ffffff', color: document.documentElement.dataset.theme === 'dark' ? '#edf2f7' : '#172033' }).then((result) => { if (result.isConfirmed) window.location.href = element.href; });
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
