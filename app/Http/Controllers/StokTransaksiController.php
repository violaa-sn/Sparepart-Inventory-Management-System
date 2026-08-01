<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\StokTransaksi;
use App\Models\Sparepart;
use App\Models\StokTransaksiDetail;
use Exception;
use Illuminate\Support\Facades\DB;

class StokTransaksiController extends Controller
{
    // halaman daftar barang masuk
    public function barangMasuk(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        $query = StokTransaksi::with([
            'supplier',
            'user',
            'details'
        ])
            ->where('tipe', 'in');

        $query->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_transaksi', 'like', "%{$search}%")
                    ->orWhereHas('supplier', function ($supplier) use ($search) {
                        $supplier->where('nama_supplier', 'like', "%{$search}%");
                    });
            });
        });

        $query->when($status, function ($query) use ($status) {
            $query->where('status_transaksi', $status);
        });

        $query->when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
            $query->whereBetween(
                'tanggal_transaksi',
                [$tanggalAwal, $tanggalAkhir]
            );
        });

        $transaksis = $query
            ->latest('tanggal_transaksi')
            ->paginate(10)
            ->withQueryString();

        return view(
            'transaksi.barang-masuk.index',
            compact('transaksis')
        );
    }

    public function createBarangMasuk()
    {
        $suppliers = Supplier::where('status_supplier', 'aktif')
            ->orderBy('nama_supplier')
            ->get();

        return view(
            'transaksi.barang-masuk.create',
            compact('suppliers')
        );
    }

    public function getSparepartsBySupplier(Supplier $supplier)
    {
        $spareparts = $supplier->spareparts()
            ->select(
                'spareparts.id',
                'kode_sparepart',
                'nama_sparepart',
                'stok'
            )
            ->withPivot('harga_beli')
            ->orderBy('nama_sparepart')
            ->get();

        return response()->json($spareparts);
    }

    // simpan barang masuk
    public function storeBarangMasuk(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => [
                'required',
                'date'
            ],

            'supplier_id' => [
                'required',
                'exists:suppliers,id'
            ],
            'items' => [
                'required',
                'json'
            ]
        ]);

        DB::beginTransaction();

        try {

            $items = json_decode($request->items, true);

            if (!$items || count($items) == 0) {
                return back()->with('error', 'Belum ada sparepart yang dipilih');
            }


            $transaksi = StokTransaksi::create([
                'kode_transaksi' => 'TRX-IN-' . now()->format('YmdHis'),
                'user_id' => auth()->id(),
                'supplier_id' => $request->supplier_id,
                'tipe' => 'in',
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'status_transaksi' => 'selesai',
                'catatan' => $request->catatan
            ]);


            foreach ($items as $item) {

                $sparepart = Sparepart::findOrFail($item['id']);


                // cek supplier memang menyediakan sparepart tersebut
                $supplierSparepart = $sparepart
                    ->suppliers()
                    ->where('supplier_id', $request->supplier_id)
                    ->first();


                if (!$supplierSparepart) {
                    throw new Exception(
                        "Sparepart {$sparepart->nama_sparepart} tidak tersedia dari supplier ini"
                    );
                }


                // simpan detail transaksi
                StokTransaksiDetail::create([
                    'stok_transaksi_id' => $transaksi->id,
                    'sparepart_id' => $sparepart->id,
                    'qty' => $item['qty'],
                    'harga_perunit' => $item['harga']
                ]);


                // update stok barang masuk
                $sparepart->increment(
                    'stok',
                    $item['qty']
                );
            }


            DB::commit();


            return redirect()
                ->route('transaksi.barang-masuk')
                ->with(
                    'success',
                    'Barang masuk berhasil disimpan'
                );
        } catch (Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    public function cancel(StokTransaksi $transaksi)
    {
        DB::beginTransaction();

        try {

            if ($transaksi->status_transaksi == 'dibatalkan') {
                return back()->with(
                    'error',
                    'Transaksi sudah dibatalkan'
                );
            }

            foreach ($transaksi->details as $detail) {

                $sparepart = $detail->sparepart;

                if ($transaksi->tipe == 'in') {

                    // Barang masuk dibatalkan → stok dikurangi
                    if ($sparepart->stok < $detail->qty) {
                        throw new Exception(
                            "Stok {$sparepart->nama_sparepart} tidak mencukupi untuk pembatalan"
                        );
                    }

                    $sparepart->decrement(
                        'stok',
                        $detail->qty
                    );
                } elseif ($transaksi->tipe == 'out') {

                    // Barang keluar dibatalkan → stok dikembalikan
                    $sparepart->increment(
                        'stok',
                        $detail->qty
                    );
                }
            }

            $transaksi->update([
                'status_transaksi' => 'dibatalkan'
            ]);

            DB::commit();

            return back()->with(
                'success',
                'Transaksi berhasil dibatalkan'
            );
        } catch (Exception $e) {

            DB::rollBack();

            return back()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    public function showBarangMasuk(StokTransaksi $transaksi)
    {
        $transaksi->load([
            'supplier',
            'user',
            'details.sparepart'
        ]);


        if ($transaksi->tipe != 'in') {

            abort(404);
        }


        return view(
            'transaksi.barang-masuk.show',
            compact('transaksi')
        );
    }

    // halaman daftar barang keluar
    public function barangKeluar(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;


        $query = StokTransaksi::with([
            'user',
            'details'
        ])
            ->where('tipe', 'out');


        $query->when($search, function ($query) use ($search) {

            $query->where(function ($q) use ($search) {

                $q->where(
                    'kode_transaksi',
                    'like',
                    "%{$search}%"
                );
            });
        });


        $query->when($status, function ($query) use ($status) {

            $query->where(
                'status_transaksi',
                $status
            );
        });


        $query->when(
            $tanggalAwal && $tanggalAkhir,
            function ($query) use ($tanggalAwal, $tanggalAkhir) {

                $query->whereBetween(
                    'tanggal_transaksi',
                    [
                        $tanggalAwal,
                        $tanggalAkhir
                    ]
                );
            }
        );


        $transaksis = $query
            ->latest('tanggal_transaksi')
            ->paginate(10)
            ->withQueryString();


        return view(
            'transaksi.barang-keluar.index',
            compact('transaksis')
        );
    }

    public function createBarangKeluar()
    {
        $spareparts = Sparepart::where('stok', '>', 0)
            ->orderBy('nama_sparepart')
            ->get();

        return view(
            'transaksi.barang-keluar.create',
            compact('spareparts')
        );
    }

    // simpan barang keluar
    public function storeBarangKeluar(Request $request)
    {
        $request->validate([

            'tanggal_transaksi' => [
                'required',
                'date'
            ],

            'items' => [
                'required',
                'json'
            ]

        ]);


        DB::beginTransaction();


        try {


            $items = json_decode(
                $request->items,
                true
            );


            if (!$items || count($items) == 0) {

                return back()
                    ->with(
                        'error',
                        'Belum ada sparepart dipilih'
                    );
            }



            $transaksi = StokTransaksi::create([

                'kode_transaksi' =>
                'TRX-OUT-' . now()->format('YmdHis'),

                'user_id' =>
                auth()->id(),

                'supplier_id' =>
                null,

                'tipe' =>
                'out',

                'tanggal_transaksi' =>
                $request->tanggal_transaksi,

                'status_transaksi' =>
                'selesai',

                'catatan' =>
                $request->catatan

            ]);



            foreach ($items as $item) {


                $sparepart = Sparepart::findOrFail(
                    $item['id']
                );



                // cek stok cukup

                if ($sparepart->stok < $item['qty']) {

                    throw new Exception(

                        "Stok {$sparepart->nama_sparepart} tidak mencukupi"

                    );
                }



                StokTransaksiDetail::create([

                    'stok_transaksi_id' =>
                    $transaksi->id,

                    'sparepart_id' =>
                    $sparepart->id,

                    'qty' =>
                    $item['qty'],

                    'harga_perunit' =>
                    0

                ]);



                // kurangi stok

                $sparepart->decrement(

                    'stok',

                    $item['qty']

                );
            }



            DB::commit();


            return redirect()

                ->route('transaksi.barang-keluar')

                ->with(

                    'success',

                    'Barang keluar berhasil disimpan'

                );
        } catch (Exception $e) {


            DB::rollBack();


            return back()

                ->withInput()

                ->with(

                    'error',

                    $e->getMessage()

                );
        }
    }

    public function showBarangKeluar(StokTransaksi $transaksi)
    {
        $transaksi->load([
            'user',
            'details.sparepart'
        ]);


        if ($transaksi->tipe != 'out') {

            abort(404);
        }


        return view(
            'transaksi.barang-keluar.show',
            compact('transaksi')
        );
    }

    // riwayat semua transaksi
    public function riwayat() {}
}
