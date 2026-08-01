/**
 * user.js
 * Cuma dipake di halaman Manajemen User.
 * Ganti tampilan dot + teks status "Aktif/Nonaktif" pas toggle switch di tabel diklik.
 * NOTE: ini baru visual doang, blm ada request ke server. Nanti pas Laravel-in,
 * tinggal tambah fetch/axios ke route update status di sini.
 */
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.js-user-status-toggle').forEach(function (toggle) {
        toggle.addEventListener('change', function () {
            const row = this.closest('tr');
            if (!row) return;

            const dot  = row.querySelector('.user-status-dot');
            const text = row.querySelector('.user-status-text');

            if (this.checked) {
                dot.classList.remove('user-status-dot-inactive');
                dot.classList.add('user-status-dot-active');
                text.textContent = 'Aktif';
            } else {
                dot.classList.remove('user-status-dot-active');
                dot.classList.add('user-status-dot-inactive');
                text.textContent = 'Nonaktif';
            }
        });
    });
});
