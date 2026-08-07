<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $brand = Brand::withCount('spareparts')

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('kode_brand', 'like', "%{$search}%")
                        ->orWhere('nama_brand', 'like', "%{$search}%");
                });
            })

            ->when($status, function ($query) use ($status) {

                $query->where('status_brand', $status);
            })

            ->latest()

            ->paginate(10)

            ->withQueryString();

        $kodeBrand = Brand::generateKode();

        return view('brand.index', compact('brand', 'kodeBrand'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kodeBrand = Brand::generateKode();

        return view('brand.create', compact('kodeBrand'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_brand' => 'required|string|max:100'
        ]);

        $data['kode_brand'] = Brand::generateKode();

        $data['status_brand'] =
            $request->has('status_brand')
            ? 'aktif'
            : 'nonaktif';

        Brand::create($data);

        return redirect()
            ->route('brand.index')
            ->with('success', 'brand berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'nama_brand' => 'required|string|max:100'
        ]);

        $data['status_brand'] = $request->has('status_brand')
            ? 'aktif'
            : 'nonaktif';

        $brand->update($data);

        return redirect()
            ->route('brand.index')
            ->with('success', 'brand berhasil diperbarui.');
    }

    public function toggleStatus(Brand $brand)
    {
        $brand->status_brand =
            $brand->status_brand == 'aktif'
            ? 'nonaktif'
            : 'aktif';

        $brand->save();

        return response()->json([

            'success' => true,
            'status' => $brand->status_brand

        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        if ($brand->spareparts()->exists()) {

            return back()->with(
                'error',
                'brand masih digunakan oleh sparepart.'
            );
        }

        $brand->delete();

        return back()->with(
            'success',
            'brand berhasil dihapus.'
        );
    }

    public function trash(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $brand = Brand::onlyTrashed()
            ->withCount('spareparts')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode_brand', 'like', "%{$search}%")
                        ->orWhere('nama_brand', 'like', "%{$search}%");
                });
            })

            ->when($status, function ($query) use ($status) {
                $query->where('status_brand', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'brand.trash',
            compact('brand')
        );
    }

    public function restore($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);

        $brand->restore();

        return redirect()->route('brand.trash')
            ->with('success', 'brand berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $brand = Brand::onlyTrashed()
            ->findOrFail($id);

        if ($brand->spareparts()->withTrashed()->exists()) {
            return back()->with(
                'error',
                'brand masih memiliki relasi sparepart.'
            );
        }

        $brand->forceDelete();

        return redirect()
            ->route('brand.trash')
            ->with(
                'success',
                'brand berhasil dihapus permanen.'
            );
    }
}
