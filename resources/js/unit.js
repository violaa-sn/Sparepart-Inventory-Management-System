console.log("Unit JS Loaded");

document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(".js-unit-status-toggle").forEach(toggle => {

        toggle.addEventListener("change", function () {

            const row = this.closest("tr");

            const dot = row.querySelector(".user-status-dot");

            const text = row.querySelector(".user-status-text");

            const unitId = this.dataset.id;

            fetch(`/unit/${unitId}/toggle-status`, {

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

});
