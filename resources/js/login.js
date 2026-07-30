// =========================================================
// LOGIN PAGE - Sparepart Manager
// Fungsinya cuma buat toggle show/hide password
// =========================================================

document.addEventListener('DOMContentLoaded', function () {
    const btnToggle = document.getElementById('btnTogglePassword');
    const inputPassword = document.getElementById('password');
    const iconToggle = document.getElementById('iconTogglePassword');

    if (!btnToggle || !inputPassword || !iconToggle) {
        return; // kalau elemennya ga ada, ga usah lanjut
    }

    btnToggle.addEventListener('click', function () {
        const isPasswordHidden = inputPassword.type === 'password';

        // ganti tipe input & icon-nya
        inputPassword.type = isPasswordHidden ? 'text' : 'password';
        iconToggle.textContent = isPasswordHidden ? 'visibility_off' : 'visibility';
    });
});
