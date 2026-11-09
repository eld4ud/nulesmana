// Pembatas tanggal berita Nulesmana, berdasarkan zona waktu WIB (Asia/Jakarta).
// Hanya mengatur UI. Validasi final tetap dilakukan server Laravel.
(() => {
    const fields = document.querySelectorAll('input[type="date"][data-nulesmana-date-limit]');
    if (!fields.length) return;

    const formatter = new Intl.DateTimeFormat('en-US', {
        timeZone: 'Asia/Jakarta', year: 'numeric', month: '2-digit', day: '2-digit',
    });

    function todayWIB() {
        const parts = Object.fromEntries(
            formatter.formatToParts(new Date()).map(part => [part.type, part.value])
        );
        return `${parts.year}-${parts.month}-${parts.day}`;
    }

    for (const field of fields) {
        const refresh = () => {
            const limit = todayWIB();
            field.max = limit;
            field.setCustomValidity(field.value && field.value > limit
                ? 'Tanggal berita tidak boleh melewati hari ini (WIB).'
                : '');
        };
        field.addEventListener('input', refresh);
        field.addEventListener('change', refresh);
        field.addEventListener('focus', refresh);
        window.addEventListener('focus', refresh);
        // Jika halaman admin terbuka sampai lewat tengah malam WIB.
        window.setInterval(refresh, 60_000);
        refresh();
    }
})();
