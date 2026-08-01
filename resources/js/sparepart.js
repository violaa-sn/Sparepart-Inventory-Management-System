// =========================================================
// SPAREPART.JS
// Ngatur baris supplier yang dinamis di form Tambah Sparepart
// (tambah baris, hapus baris, cegah supplier dipilih dobel)
// =========================================================

document.addEventListener("DOMContentLoaded", function () {
    var supplierContainer = document.getElementById("supplier-container");
    var btnTambahSupplier = document.getElementById("btn-tambah-supplier");

    // kalau elemennya ga ada di halaman ini, ga usah lanjut
    if (!supplierContainer || !btnTambahSupplier) {
        return;
    }

    // pasang event listener buat baris yang udah ada dari blade
    pasangEventSupplierRow();
    updateOpsiSupplier();

    // event pas tombol "Tambah Supplier" diklik
    btnTambahSupplier.addEventListener("click", function () {
        tambahSupplierRow();
    });

    // fungsi buat nambah baris supplier baru
    function tambahSupplierRow() {
        var semuaRow = supplierContainer.querySelectorAll(".supplier-row");
        var rowPertama = semuaRow[0];

        // baris baru dibikin dari copy baris pertama
        var rowBaru = rowPertama.cloneNode(true);

        // kosongin select & input di baris baru biar ga kebawa punya baris pertama
        var selectBaru = rowBaru.querySelector("select");
        var inputBaru = rowBaru.querySelector("input");
        selectBaru.value = "";
        inputBaru.value = "";

        // aktifin lagi semua option di baris baru (jaga-jaga ada yang disabled pas di-clone)
        var semuaOption = selectBaru.querySelectorAll("option");
        semuaOption.forEach(function (option) {
            option.disabled = false;
        });

        supplierContainer.appendChild(rowBaru);

        pasangEventSupplierRow();
        updateIndexSupplier();
        updateTombolHapus();
        updateOpsiSupplier();
    }

    // fungsi buat hapus satu baris supplier
    function hapusSupplierRow(tombol) {
        var semuaRow = supplierContainer.querySelectorAll(".supplier-row");

        // minimal harus ada 1 baris supplier, jadi ga boleh dihapus semua
        if (semuaRow.length <= 1) {
            return;
        }

        var row = tombol.closest(".supplier-row");
        row.remove();

        updateIndexSupplier();
        updateTombolHapus();
        updateOpsiSupplier();
    }

    // pasang ulang event listener ke semua tombol hapus & select yang ada
    function pasangEventSupplierRow() {
        var semuaTombolHapus = supplierContainer.querySelectorAll(
            ".btn-hapus-supplier",
        );
        semuaTombolHapus.forEach(function (tombol) {
            tombol.onclick = function () {
                hapusSupplierRow(tombol);
            };
        });

        var semuaSelect =
            supplierContainer.querySelectorAll(".select-supplier");
        semuaSelect.forEach(function (select) {
            select.onchange = function () {
                updateOpsiSupplier();
            };
        });
    }

    // update index nama input biar urut lagi
    // contoh: suppliers[0][supplier_id], suppliers[1][supplier_id], dst
    function updateIndexSupplier() {
        var semuaRow = supplierContainer.querySelectorAll(".supplier-row");

        semuaRow.forEach(function (row, index) {
            var title = row.querySelector(".supplier-title");
            var select = row.querySelector(".select-supplier");
            var input = row.querySelector(".input-harga-beli");

            title.textContent = "Supplier " + (index + 1);

            select.setAttribute(
                "name",
                "suppliers[" + index + "][supplier_id]",
            );

            input.setAttribute("name", "suppliers[" + index + "][harga_beli]");
        });
    }

    // kalau baris tinggal 1, tombol hapus dimatiin biar ga bisa dihapus semua
    function updateTombolHapus() {
        var semuaTombolHapus = supplierContainer.querySelectorAll(
            ".btn-hapus-supplier",
        );

        if (semuaTombolHapus.length === 1) {
            semuaTombolHapus[0].disabled = true;
        } else {
            semuaTombolHapus.forEach(function (tombol) {
                tombol.disabled = false;
            });
        }
    }

    // biar supplier yang udah dipilih di baris lain ga bisa dipilih lagi
    function updateOpsiSupplier() {
        var semuaSelect =
            supplierContainer.querySelectorAll(".select-supplier");

        // kumpulin dulu semua supplier yang udah kepilih
        var supplierTerpilih = [];
        semuaSelect.forEach(function (select) {
            if (select.value !== "") {
                supplierTerpilih.push(select.value);
            }
        });

        // cek satu-satu tiap option di tiap select
        semuaSelect.forEach(function (select) {
            var semuaOption = select.querySelectorAll("option");

            semuaOption.forEach(function (option) {
                // lewatin option "Pilih Supplier"
                if (option.value === "") {
                    return;
                }

                var sudahDipilihDiBarisLain =
                    supplierTerpilih.includes(option.value) &&
                    select.value !== option.value;

                option.disabled = sudahDipilihDiBarisLain;
            });
        });
    }
});
