<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $supplier = Supplier::withCount('spareparts')

            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode_supplier', 'like', "%{$search}%")
                        ->orWhere('nama_supplier', 'like', "%{$search}%")
                        ->orWhere('alamat', 'like', "%{$search}%")
                        ->orWhere('notlp', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })

            ->when($status, function ($query) use ($status) {
                $query->where('status_supplier', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $kodeSupplier = Supplier::generateKode();

        return view('supplier.index', compact('supplier', 'kodeSupplier'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_supplier'    => 'required|string|max:100',
            'alamat'  => 'required|string|max:255',
            'notlp' => 'required|string|max:20',
            'status_supplier'  => 'nullable',
            'email' => 'required|email|unique:suppliers,email',
        ]);

        $data['kode_supplier'] = Supplier::generateKode();

        $data['status_supplier'] =
            $request->has('status_supplier')
            ? 'aktif'
            : 'nonaktif';

        Supplier::create($data);

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'nama_supplier'    => 'required|string|max:100',
            'alamat'  => 'required|string|max:255',
            'notlp' => 'required|string|max:20',
            'status_supplier'  => 'nullable',
            'email' => 'required|email|unique:suppliers,email,' . $supplier->id
        ]);

        $data['status_supplier'] = $request->has('status_supplier')
            ? 'aktif'
            : 'nonaktif';

        $supplier->update($data);

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    public function toggleStatus(Supplier $supplier)
    {
        $supplier->status_supplier =
            $supplier->status_supplier == 'aktif'
            ? 'nonaktif'
            : 'aktif';

        $supplier->save();

        return response()->json([

            'success' => true,
            'status' => $supplier->status_supplier

        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        if ($supplier->stokTransaksis()->exists()) {

            return back()->with(
                'error',
                'Supplier memiliki riwayat transaksi.'
            );
        }

        if ($supplier->spareparts()->exists()) {

            return back()->with(
                'error',
                'Supplier masih digunakan oleh sparepart.'
            );
        }

        $supplier->delete();

        return back()->with(
            'success',
            'Supplier berhasil dihapus.'
        );
    }

    public function trash(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $supplier = Supplier::onlyTrashed()
            ->withCount('spareparts')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode_supplier', 'like', "%{$search}%")
                        ->orWhere('nama_supplier', 'like', "%{$search}%");
                });
            })

            ->when($status, function ($query) use ($status) {
                $query->where('status_supplier', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'supplier.trash',
            compact('supplier')
        );
    }

    public function restore($id)
    {
        $supplier = Supplier::onlyTrashed()->findOrFail($id);

        $supplier->restore();

        return redirect()->route('supplier.trash')
            ->with('success', 'Supplier berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $supplier = Supplier::onlyTrashed()
            ->findOrFail($id);

        if ($supplier->stokTransaksis()->exists()) {
            return back()->with(
                'error',
                'Supplier memiliki riwayat transaksi.'
            );
        }

        if ($supplier->spareparts()->withTrashed()->exists()) {
            return back()->with(
                'error',
                'Supplier masih memiliki relasi sparepart.'
            );
        }

        $supplier->forceDelete();

        return redirect()
            ->route('supplier.trash')
            ->with(
                'success',
                'Supplier berhasil dihapus permanen.'
            );
    }
}
