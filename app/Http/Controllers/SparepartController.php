<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Models\Kategori;
use App\Models\Brand;
use App\Models\Unit;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    /**
     * Daftar Sparepart
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $spareparts = Sparepart::with([
            'kategori',
            'brand',
            'unit'
        ])

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('kode_sparepart', 'like', "%{$search}%")
                        ->orWhere('nama_sparepart', 'like', "%{$search}%");
                });
            })

            ->when($status, function ($query) use ($status) {

                if ($status == 'low_stock') {

                    $query->whereColumn(
                        'stok',
                        '<=',
                        'min_stok'
                    );
                }

                if ($status == 'safe_stock') {

                    $query->whereColumn(
                        'stok',
                        '>',
                        'min_stok'
                    );
                }
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
            
        $kodeSparepart = Sparepart::generateKode();

        $kategori = Kategori::where(
            'status_kategori',
            'aktif'
        )
            ->orderBy('nama_kategori')
            ->get();


        $brand = Brand::where(
            'status_brand',
            'aktif'
        )
            ->orderBy('nama_brand')
            ->get();

        $unit = Unit::where(
            'status_unit',
            'aktif'
        )
            ->orderBy('nama_unit')
            ->get();

        return view(
            'spareparts.index',
            compact(
                'spareparts',
                'kodeSparepart',
                'kategori',
                'brand',
                'unit'
            )
        );
    }

    /**
     * Form tambah
     */
    public function create()
    {
        $kodeSparepart = Sparepart::generateKode();

        $kategori = Kategori::where(
            'status_kategori',
            'aktif'
        )
            ->orderBy('nama_kategori')
            ->get();

        $brand = Brand::where(
            'status_brand',
            'aktif'
        )
            ->orderBy('nama_brand')
            ->get();

        $unit = Unit::where(
            'status_unit',
            'aktif'
        )
            ->orderBy('nama_unit')
            ->get();

        return view(
            'spareparts.create',
            compact(
                'kodeSparepart',
                'kategori',
                'brand',
                'unit'
            )
        );
    }

    public function show(Sparepart $sparepart)
    {
        $sparepart->load([
            'kategori',
            'brand',
            'unit',
            'suppliers'
        ]);

        // $sparepart->load([
        //     'kategori',
        //     'brand',
        //     'unit',
        //     'suppliers',
        //     'stokTransaksi'
        // ]);

        return view(
            'spareparts.show',
            compact('sparepart')
        );
    }


    public function store(Request $request)
    {
        $data = $request->validate([

            'nama_sparepart' => 'required|max:100',

            'kategori_id' => 'required|exists:kategoris,id',

            'brand_id' => 'required|exists:brands,id',

            'unit_id' => 'required|exists:units,id',

            'min_stok' => 'required|integer|min:0',

            'deskripsi' => 'nullable|string'

        ]);

        $data['kode_sparepart'] = Sparepart::generateKode();

        /*
            STOK SELALU DIMULAI DARI 0

            nanti bertambah
            melalui Barang Masuk
        */

        $data['stok'] = 0;

        Sparepart::create($data);

        return redirect()

            ->route('spareparts.index')

            ->with(
                'success',
                'Sparepart berhasil ditambahkan.'
            );
    }

    /**
     * Form edit
     */
    public function edit(Sparepart $sparepart)
    {
        $kategori = Kategori::where(
            'status_kategori',
            'aktif'
        )
            ->orderBy('nama_kategori')
            ->get();

        $brand = Brand::where(
            'status_brand',
            'aktif'
        )
            ->orderBy('nama_brand')
            ->get();

        $unit = Unit::where(
            'status_unit',
            'aktif'
        )
            ->orderBy('nama_unit')
            ->get();

        return view(
            'spareparts.edit',
            compact(
                'sparepart',
                'kategori',
                'brand',
                'unit'
            )
        );
    }

    /**
     * Update
     */
    public function update(Request $request, Sparepart $sparepart)
    {
        $data = $request->validate([

            'nama_sparepart' => 'required|max:100',

            'kategori_id' => 'required|exists:kategoris,id',

            'brand_id' => 'required|exists:brands,id',

            'unit_id' => 'required|exists:units,id',

            'min_stok' => 'required|integer|min:0',

            'deskripsi' => 'nullable|string'

        ]);

        /*
            Tidak boleh update stok
            dari halaman master.
        */

        $sparepart->update($data);

        return redirect()

            ->route('spareparts.index')

            ->with(
                'success',
                'Sparepart berhasil diperbarui.'
            );
    }

    /**
     * Soft Delete
     */
    public function destroy(Sparepart $sparepart)
    {
        $sparepart->delete();

        return back()->with(
            'success',
            'Sparepart berhasil dipindahkan ke Trash.'
        );
    }

    /**
     * Trash
     */
    public function trash()
    {
        $spareparts = Sparepart::onlyTrashed()

            ->with([
                'kategori',
                'brand',
                'unit'
            ])

            ->latest()

            ->paginate(10);

        return view(
            'spareparts.trash',
            compact('spareparts')
        );
    }

    /**
     * Restore
     */
    public function restore($id)
    {
        $sparepart = Sparepart::onlyTrashed()

            ->findOrFail($id);

        $sparepart->restore();

        return redirect()

            ->route('spareparts.trash')

            ->with(
                'success',
                'Sparepart berhasil dipulihkan.'
            );
    }

    /**
     * Hapus permanen
     */
    public function forceDelete($id)
    {
        $sparepart = Sparepart::onlyTrashed()
            ->findOrFail($id);

        /*
    |--------------------------------------------------------------------------
    | Tidak boleh dihapus permanen apabila:
    | 1. Masih terhubung dengan supplier
    | 2. Sudah pernah memiliki transaksi stok
    |--------------------------------------------------------------------------
    */

        if ($sparepart->suppliers()->exists()) {

            return back()->with(
                'error',
                'Sparepart tidak dapat dihapus permanen karena masih memiliki relasi dengan supplier.'
            );
        }

        if ($sparepart->stokTransaksi()->exists()) {

            return back()->with(
                'error',
                'Sparepart tidak dapat dihapus permanen karena sudah memiliki riwayat transaksi.'
            );
        }

        $sparepart->forceDelete();

        return redirect()
            ->route('spareparts.trash')
            ->with(
                'success',
                'Sparepart berhasil dihapus permanen.'
            );
    }
}
