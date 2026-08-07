import "./bootstrap";
import "./users";
import "./login";
import "./kategori";
import "./brand";
import "./unit";
import "./supplier";
import "./sparepart";
import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.css";
import "./transaksi";

import * as bootstrap from "bootstrap";

window.bootstrap = bootstrap;

// Efek "ditekan" pas klik tombol/link, biar interaktif dikit
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("a, button").forEach(function (el) {
        el.addEventListener("mousedown", function () {
            el.classList.add("is-pressed");
            setTimeout(function () {
                el.classList.remove("is-pressed");
            }, 150);
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", function () {
            const submitButtons = form.querySelectorAll(
                'button[type="submit"], input[type="submit"]',
            );

            submitButtons.forEach((btn) => {
                // kalau sudah pernah diklik, hentikan
                if (btn.disabled) return;

                btn.disabled = true;

                // simpan isi tombol
                btn.dataset.originalHtml = btn.innerHTML;

                btn.innerHTML = `
                    <span class="spinner-border spinner-border-sm me-2"></span>
                    Memproses...
                `;
            });
        });
    });
});



document.addEventListener("click", function (e) {
    const link = e.target.closest(".js-disable-link");

    if (!link) return;

    if (link.classList.contains("disabled")) {
        e.preventDefault();
        return;
    }

    link.classList.add("disabled");
    link.style.pointerEvents = "none";
    link.style.opacity = "0.6";
});
