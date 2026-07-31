/**
 * user.js
 * Cuma dipake di halaman Manajemen User.
 * Ganti tampilan dot + teks status "Aktif/Nonaktif" pas toggle switch di tabel diklik.
 * NOTE: ini baru visual doang, blm ada request ke server. Nanti pas Laravel-in,
 * tinggal tambah fetch/axios ke route update status di sini.
 */
document.querySelectorAll(".js-user-status-toggle").forEach(toggle => {

    toggle.addEventListener("change", function () {

        const row = this.closest("tr");

        const dot = row.querySelector(".user-status-dot");

        const text = row.querySelector(".user-status-text");

        const userId = this.dataset.id;

        fetch(`/users/${userId}/toggle-status`, {

            method: "PATCH",

            headers: {

                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .content,

                "Accept": "application/json",

                "Content-Type": "application/json"

            }

        })

        .then(res => res.json())

        .then(data => {

            if (!data.success) return;

            if (data.status === "aktif") {

                dot.classList.remove("user-status-dot-inactive");

                dot.classList.add("user-status-dot-active");

                text.textContent = "Aktif";

                this.checked = true;

            } else {

                dot.classList.remove("user-status-dot-active");

                dot.classList.add("user-status-dot-inactive");

                text.textContent = "Nonaktif";

                this.checked = false;

            }

        })

        .catch(() => {

            this.checked = !this.checked;

        });

    });

});

document.addEventListener("DOMContentLoaded", () => {
    const alerts = document.querySelectorAll(".alert");

    alerts.forEach((alert) => {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 3000);
    });
});


document.querySelectorAll(".btn-toggle-password").forEach(button => {

    button.addEventListener("click", function () {

        const input = document.getElementById(this.dataset.target);

        const icon = this.querySelector(".material-symbols-outlined");

        if (input.type === "password") {

            input.type = "text";

            icon.textContent = "visibility_off";

        } else {

            input.type = "password";

            icon.textContent = "visibility";

        }

    });

});



function showToast(message,type){

    const old=document.querySelector(".dynamic-alert");

    if(old) old.remove();

    const alert=document.createElement("div");

    alert.className=
        `alert alert-${type} alert-dismissible fade show dynamic-alert`;

    alert.innerHTML=`
        ${message}
        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>
    `;

    document
        .querySelector(".content-wrapper")
        ?.prepend(alert);

    setTimeout(()=>{

        bootstrap.Alert
            .getOrCreateInstance(alert)
            .close();

    },3000);

}