<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Models\Kategori;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; //nama, ktegri, brnd, unit unik

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
            'unit',
            'suppliers',
        ])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {

                    $q->where('kode_sparepart', 'like', "%{$search}%")
                        ->orWhere('nama_sparepart', 'like', "%{$search}%")

                        ->orWhereHas('suppliers', function ($supplier) use ($search) {
                            $supplier->where('kode_supplier', 'like', "%{$search}%")
                                ->orWhere('nama_supplier', 'like', "%{$search}%")
                                ->orWhere('alamat', 'like', "%{$search}%")
                                ->orWhere('notlp', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('stok', 'like', "%{$search}%");
                        });
                });
            })

            ->when($status, function ($query) use ($status) {

                if ($status == 'out_stock') {
                    $query->where('stok', 0);
                }

                if ($status == 'low_stock') {
                    $query->where('stok', '>', 0)
                        ->whereColumn('stok', '<=', 'min_stok');
                }

                if ($status == 'safe_stock') {
                    $query->whereColumn('stok', '>', 'min_stok');
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

        $suppliers = Supplier::where(
            'status_supplier',
            'aktif'
        )
            ->orderBy('nama_supplier')
            ->get();

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
                'unit',
                'suppliers'
            )
        );
    }

    public function show(Sparepart $sparepart)
    {
        $sparepart->load([
            'kategori',
            'brand',
            'unit',
            'suppliers',
            'transaksiDetails.transaksi.user',
            'transaksiDetails.transaksi.supplier',
        ]);

        return view(
            'spareparts.show',
            compact('sparepart')
        );
    }

    /**
     * Detail Sparepart dari Trash
     */
    public function showTrash($id)
    {
        $sparepart = Sparepart::withTrashed()
            ->with([
                'kategori',
                'brand',
                'unit',
                'suppliers',
                'transaksiDetails.transaksi.user',
                'transaksiDetails.transaksi.supplier',
            ])
            ->findOrFail($id);


        return view(
            'spareparts.trash-show',
            compact('sparepart')
        );
    }


    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'nama_sparepart' => [
                    'required',
                    'max:100',
                    Rule::unique('spareparts')
                        ->where(function ($query) use ($request) {
                            return $query
                                ->where('kategori_id', $request->kategori_id)
                                ->where('brand_id', $request->brand_id)
                                ->where('unit_id', $request->unit_id);
                        }),
                ],

                'kategori_id' => 'required|exists:kategoris,id',
                'brand_id' => 'required|exists:brands,id',
                'unit_id' => 'required|exists:units,id',
                'min_stok' => 'required|integer|min:0',
                'deskripsi' => 'nullable|string',

                'suppliers' => 'required|array|min:1',
                'suppliers.*.supplier_id' => 'required|exists:suppliers,id',
                'suppliers.*.harga_beli' => 'required|numeric|min:0',
            ],

            [
                'nama_sparepart.unique' =>
                'Sparepart dengan nama, kategori, brand, dan unit yang sama sudah terdaftar.',
            ]
        );

        $data['kode_sparepart'] = Sparepart::generateKode();

        // stok awal selalu 0
        $data['stok'] = 0;

        $supplierIds = collect($request->suppliers)
            ->pluck('supplier_id');

        if ($supplierIds->count() !== $supplierIds->unique()->count()) {

            return back()
                ->withInput()
                ->withErrors([
                    'suppliers' => 'Supplier tidak boleh dipilih lebih dari satu kali.'
                ]);
        }

        // simpan sparepart
        $sparepart = Sparepart::create([

            'kode_sparepart' => $data['kode_sparepart'],
            'nama_sparepart' => $data['nama_sparepart'],
            'kategori_id' => $data['kategori_id'],
            'brand_id' => $data['brand_id'],
            'unit_id' => $data['unit_id'],
            'min_stok' => $data['min_stok'],
            'stok' => $data['stok'],
            'deskripsi' => $data['deskripsi'],
        ]);
        //  Simpan relasi ke tbl pivor

        $pivotData = [];

        foreach ($request->suppliers as $supplier) {
            $pivotData[$supplier['supplier_id']] = [
                'harga_beli' => $supplier['harga_beli']
            ];
        }

        $sparepart->suppliers()->sync($pivotData);

        return redirect()
            ->route('spareparts.index')
            ->with(
                'success',
                'Sparepart berhasil ditambahkan.'
            );
    }

    public function edit(Sparepart $sparepart)
    {
        $kodeSparepart = Sparepart::generateKode();

        $suppliers = Supplier::where(
            'status_supplier',
            'aktif'
        )
            ->orderBy('nama_supplier')
            ->get();

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
                'unit',
                'kodeSparepart',
                'suppliers'   // <-- WAJIB ditambahkan
            )
        );
    }
    /**
     * Update
     */
    public function update(Request $request, Sparepart $sparepart)
    {
        $data = $request->validate(
            [
                'nama_sparepart' => [
                    'required',
                    'max:100',
                    Rule::unique('spareparts')
                        ->ignore($sparepart->id)
                        ->where(function ($query) use ($request) {
                            return $query
                                ->where('kategori_id', $request->kategori_id)
                                ->where('brand_id', $request->brand_id)
                                ->where('unit_id', $request->unit_id);
                        }),
                ],
                'kategori_id' => 'required|exists:kategoris,id',
                'brand_id' => 'required|exists:brands,id',
                'unit_id' => 'required|exists:units,id',
                'min_stok' => 'required|integer|min:0',
                'deskripsi' => 'nullable|string',

                'suppliers' => 'required|array|min:1',
                'suppliers.*.supplier_id' => 'required|exists:suppliers,id',
                'suppliers.*.harga_beli' => 'required|numeric|min:0',
            ],

            [
                'nama_sparepart.unique' =>
                'Sparepart dengan nama, kategori, brand, dan unit yang sama sudah terdaftar.',
            ]
        );

        /* g boleh update stok dari halaman master. */

        $supplierIds = collect($request->suppliers)
            ->pluck('supplier_id');

        if ($supplierIds->count() !== $supplierIds->unique()->count()) {

            return back()
                ->withInput()
                ->withErrors([
                    'suppliers' => 'Supplier tidak boleh dipilih lebih dari satu kali.'
                ]);
        }

        $sparepart->update([
            'nama_sparepart' => $data['nama_sparepart'],
            'kategori_id'    => $data['kategori_id'],
            'brand_id'       => $data['brand_id'],
            'unit_id'        => $data['unit_id'],
            'min_stok'       => $data['min_stok'],
            'deskripsi'      => $data['deskripsi'],
        ]);

        $pivotData = [];

        foreach ($request->suppliers as $supplier) {
            $pivotData[$supplier['supplier_id']] = [
                'harga_beli' => $supplier['harga_beli']
            ];
        }

        $sparepart->suppliers()->sync($pivotData);

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
        if ($sparepart->transaksiDetails()->exists()) {

            return back()->with(
                'error',
                'Sparepart memiliki riwayat transaksi sehingga tidak dapat dihapus.'
            );
        }

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

        if ($sparepart->transaksiDetails()->exists()) {

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
