import './bootstrap';
import './users';
import './login';
import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;

/**
 * app.js
 * JS umum yg dipake di semua halaman.
 * Untuk toggle submenu "Transaksi" di sidebar udah dihandle otomatis
 * sama Bootstrap Collapse (data-bs-toggle="collapse"), jadi ga perlu JS manual lagi.
 */

// Efek "ditekan" pas klik tombol/link, biar interaktif dikit
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('a, button').forEach(function (el) {
        el.addEventListener('mousedown', function () {
            el.classList.add('is-pressed');
            setTimeout(function () {
                el.classList.remove('is-pressed');
            }, 150);
        });
    });
});
