console.log("Kategori JS Loaded");

document.addEventListener("DOMContentLoaded", () => {

    document
        .querySelectorAll(".js-kategori-status-toggle")
        .forEach(toggle => {

            console.log("Checkbox ditemukan");

            toggle.addEventListener("change", function () {

                const kategoriId = this.dataset.id;

                console.log("Toggle diklik");
                console.log("ID:", kategoriId);

                fetch(`/kategori/${kategoriId}/toggle-status`, {
                    method: "PATCH",
                    headers: {
                        "X-CSRF-TOKEN":
                            document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json"
                    }
                })
                .then(res => {
                    console.log("Status:", res.status);
                    return res.json();
                })
                .then(data => {
                    console.log("Response:", data);
                })
                .catch(err => {
                    console.error(err);
                });

            });

        });

});