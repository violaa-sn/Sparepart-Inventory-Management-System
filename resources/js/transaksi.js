import TomSelect from "tom-select";

document.addEventListener("DOMContentLoaded", () => {
    console.log("TRANSAKSI JS LOADED");

    const supplierSelect = document.getElementById("supplier-select");
    const sparepartSelect = document.getElementById("sparepart-select");

    // ===============================
    // BARANG MASUK
    // ===============================
    if (supplierSelect && sparepartSelect) {
        initBarangMasuk();
    }

    // ===============================
    // BARANG KELUAR
    // ===============================
    if (!supplierSelect && sparepartSelect) {
        initBarangKeluar();
    }
});

// =====================================================
// HELPER PESAN ERROR (dipakai bareng di masuk & keluar)
// =====================================================

function tampilkanError(pesan) {
    const pesanError = document.getElementById("pesan-error-item");
    if (!pesanError) return;

    pesanError.textContent = pesan;
    pesanError.classList.remove("d-none");
}

function sembunyikanError() {
    const pesanError = document.getElementById("pesan-error-item");
    if (!pesanError) return;

    pesanError.classList.add("d-none");
    pesanError.textContent = "";
}

// =====================================================
// BARANG MASUK
// =====================================================

function initBarangMasuk() {
    const stok = document.getElementById("stok-saat-ini");
    const hargaSupplier = document.getElementById("harga-supplier");
    const harga = document.getElementById("harga-perunit");
    const qty = document.getElementById("qty-masuk");
    const subtotal = document.getElementById("subtotal-preview");

    const btnTambah = document.getElementById("btn-tambah-item");

    const tbody = document.getElementById("tabel-daftar-item");

    const totalItem = document.getElementById("ringkasan-total-item");
    const totalQty = document.getElementById("ringkasan-total-qty");
    const grandTotal = document.getElementById("ringkasan-grand-total");

    const hiddenInput = document.getElementById("hidden-input-item");

    const supplierTom = new TomSelect("#supplier-select", {
        create: false,
        sortField: "text",
        placeholder: "Pilih Supplier...",
    });

    const sparepartTom = new TomSelect("#sparepart-select", {
        create: false,
        placeholder: "Pilih Sparepart...",
    });

    sparepartTom.disable();

    let items = [];

    supplierTom.on("change", (supplierId) => {
        sparepartTom.clear();

        sparepartTom.clearOptions();

        sparepartTom.disable();

        stok.value = "";
        hargaSupplier.value = "";
        harga.value = "";
        qty.value = "";
        subtotal.textContent = "Rp 0";

        sembunyikanError();

        if (!supplierId) return;

        fetch(`/transaksi/barang-masuk/supplier/${supplierId}/spareparts`)
            .then((res) => res.json())

            .then((data) => {
                data.forEach((item) => {
                    sparepartTom.addOption({
                        value: item.id,

                        text: `${item.kode_sparepart} - ${item.nama_sparepart}`,

                        stok: item.stok,

                        harga: item.pivot.harga_beli,

                        kode: item.kode_sparepart,

                        nama: item.nama_sparepart,
                    });
                });

                sparepartTom.enable();

                sparepartTom.refreshOptions(false);
            });
    });

    sparepartTom.on("change", () => {
        sembunyikanError();

        const id = sparepartTom.getValue();

        const item = sparepartTom.options[id];

        if (!item) return;

        stok.value = item.stok;

        hargaSupplier.value = item.harga;

        harga.value = item.harga;

        hitungSubtotal();
    });

    qty.addEventListener("input", hitungSubtotal);

    harga.addEventListener("input", hitungSubtotal);

    function hitungSubtotal() {
        const total = Number(harga.value || 0) * Number(qty.value || 0);

        subtotal.textContent = "Rp " + total.toLocaleString("id-ID");
    }

    // cek apakah sparepart ini udah pernah ditambahin ke daftar item
    function sudahAdaDiDaftar(sparepartId) {
        return items.some((item) => item.id == sparepartId);
    }

    btnTambah.addEventListener("click", () => {
        sembunyikanError();

        const id = sparepartTom.getValue();

        const item = sparepartTom.options[id];

        if (!item) {
            tampilkanError("Pilih sparepart terlebih dahulu.");
            return;
        }

        if (!qty.value || qty.value <= 0) {
            tampilkanError("Qty harus diisi.");
            return;
        }

        // ini bagian yang tadinya belum ada - cegah sparepart yang sama
        // ditambahin dua kali sebagai baris terpisah
        if (sudahAdaDiDaftar(item.value)) {
            tampilkanError(
                "Sparepart ini sudah ada di daftar item. Hapus baris yang lama dulu kalau mau ubah qty atau harganya.",
            );
            return;
        }

        items.push({
            id: item.value,

            kode: item.kode,

            nama: item.nama,

            harga: Number(harga.value),

            qty: Number(qty.value),

            subtotal: Number(harga.value) * Number(qty.value),
        });

        // nonaktifkan option yang sudah dipilih
        sparepartTom.removeOption(id);

        // refresh dropdown
        sparepartTom.refreshOptions(false);

        renderTable();

        sparepartTom.clear();

        qty.value = "";

        harga.value = "";

        stok.value = "";

        subtotal.textContent = "Rp 0";
    });

    function renderTable() {
        tbody.innerHTML = "";

        items.forEach((item, index) => {
            tbody.innerHTML += `

            <tr>

                <td>${index + 1}</td>

                <td>${item.kode}</td>

                <td>${item.nama}</td>

                <td class="text-end">
                    ${item.qty}
                </td>

                <td class="text-end">
                    Rp ${item.harga.toLocaleString("id-ID")}
                </td>

                <td class="text-end">
                    Rp ${item.subtotal.toLocaleString("id-ID")}
                </td>

                <td>

                    <button
                    type="button"
                    class="btn-hapus-item"
                    data-index="${index}">
                    Hapus
                    </button>

                </td>

            </tr>

            `;
        });

        hiddenInput.innerHTML = `

        <input type="hidden"
        name="items"
        value='${JSON.stringify(items)}'>

        `;

        totalItem.textContent = items.length + " Jenis";

        totalQty.textContent = items.reduce((a, b) => a + b.qty, 0) + " pcs";

        grandTotal.textContent =
            "Rp " +
            items.reduce((a, b) => a + b.subtotal, 0).toLocaleString("id-ID");
    }

    tbody.addEventListener("click", (e) => {
        if (e.target.classList.contains("btn-hapus-item")) {
            items.splice(e.target.dataset.index, 1);

            renderTable();
        }
    });
}

// =====================================================
// BARANG KELUAR
// =====================================================

function initBarangKeluar() {
    const select = document.querySelector("#sparepart-select");

    const sparepartTom = new TomSelect(select, {
        create: false,
        placeholder: "Pilih Sparepart...",
    });

    // ambil data option blade
    Object.values(sparepartTom.options).forEach((item) => {
        const option = select.querySelector(`option[value="${item.value}"]`);

        if (option) {
            item.stok = Number(option.dataset.stok);
            item.kode = option.dataset.kode;
            item.nama = option.dataset.nama;
        }
    });

    const stok = document.getElementById("stok-saat-ini");

    const qty = document.getElementById("qty-keluar");

    const sisa = document.getElementById("sisa-stok-preview");

    const btnTambah = document.getElementById("btn-tambah-item");

    const tbody = document.getElementById("tabel-daftar-item");

    const hiddenInput = document.getElementById("hidden-input-item");

    const totalItem = document.getElementById("ringkasan-total-item");

    const totalQty = document.getElementById("ringkasan-total-qty");

    let items = [];

    // ambil qty yang udah kepake sparepart ini di daftar item (kalau ada)
    function qtyYangSudahDiambil(sparepartId) {
        const existing = items.find((i) => i.id == sparepartId);
        return existing ? existing.qty : 0;
    }

    // =========================
    // PILIH SPAREPART
    // =========================

    sparepartTom.on("change", () => {
        sembunyikanError();

        const id = sparepartTom.getValue();

        const item = sparepartTom.options[id];

        if (!item) {
            stok.value = "";
            sisa.textContent = "-";

            return;
        }

        stok.value = item.stok;

        qty.value = "";

        sisa.textContent = item.stok + " pcs";
    });

    // =========================
    // HITUNG SISA STOK
    // =========================

    qty.addEventListener("input", () => {
        const id = sparepartTom.getValue();

        const item = sparepartTom.options[id];

        if (!item) return;

        // sisa stok yang beneran tersedia, dikurangin qty yang
        // udah "dijatah" ke sparepart ini di daftar item sebelumnya
        const stokTersisaUntukInput =
            item.stok - qtyYangSudahDiambil(item.value);
        const hasil = stokTersisaUntukInput - Number(qty.value || 0);

        if (hasil < 0) {
            sisa.textContent = "Stok tidak cukup";
        } else {
            sisa.textContent = hasil + " pcs";
        }
    });

    // =========================
    // TAMBAH ITEM
    // =========================

    btnTambah.addEventListener("click", () => {
        sembunyikanError();

        const id = sparepartTom.getValue();

        const item = sparepartTom.options[id];

        if (!item) {
            tampilkanError("Pilih sparepart terlebih dahulu.");
            return;
        }

        if (!qty.value || qty.value <= 0) {
            tampilkanError("Qty keluar harus diisi.");
            return;
        }

        const jumlah = Number(qty.value);

        // ini bagian yang diperbaiki: validasi stok sekarang ngitung
        // sisa stok yang beneran ada, bukan cuma ngebandingin ke
        // stok awal doang (biar ga kebablasan kalau sparepart yang
        // sama ditambah lagi berkali-kali)
        const stokTersisa = item.stok - qtyYangSudahDiambil(item.value);

        if (jumlah > stokTersisa) {
            tampilkanError(
                `Qty melebihi stok tersedia. Sisa stok untuk sparepart ini: ${stokTersisa} pcs.`,
            );
            return;
        }

        const existing = items.find((i) => i.id == item.value);

        if (existing) {
            existing.qty += jumlah;

            existing.sisa = existing.stok - existing.qty;
        } else {
            items.push({
                id: item.value,

                kode: item.kode,

                nama: item.nama,

                stok: item.stok,

                qty: jumlah,

                sisa: item.stok - jumlah,
            });
            sparepartTom.removeOption(item.value);
            sparepartTom.refreshOptions(false);
        }

        renderTable();

        sparepartTom.clear();

        stok.value = "";

        qty.value = "";

        sisa.textContent = "-";
    });

    // =========================
    // RENDER TABLE
    // =========================

    function renderTable() {
        tbody.innerHTML = "";

        items.forEach((item, index) => {
            tbody.innerHTML += `

            <tr>

                <td class="text-center">
                    ${index + 1}
                </td>


                <td>
                    ${item.kode}
                </td>


                <td>
                    ${item.nama}
                </td>


                <td class="text-end">
                    ${item.stok}
                </td>


                <td class="text-end">
                    ${item.qty}
                </td>


                <td class="text-end">
                    ${item.sisa}
                </td>


                <td class="text-center">

                    <button
                    type="button"
                    class="btn btn-sm btn-danger btn-hapus-item"
                    data-index="${index}">
                    Hapus
                    </button>

                </td>


            </tr>

            `;
        });

        hiddenInput.innerHTML = `

        <input type="hidden"
        name="items"
        value='${JSON.stringify(items)}'>

        `;

        updateSummary();
    }

    // =========================
    // HAPUS ITEM
    // =========================

    tbody.addEventListener("click", (e) => {
        if (e.target.classList.contains("btn-hapus-item")) {
            const index = e.target.dataset.index;

            items.splice(index, 1);

            renderTable();
        }
    });

    function updateSummary() {
        totalItem.textContent = items.length + " Jenis";

        totalQty.textContent =
            items.reduce((total, item) => total + item.qty, 0) + " pcs";
    }
}
