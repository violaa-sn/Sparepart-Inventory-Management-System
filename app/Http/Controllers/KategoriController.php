<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $kategori = Kategori::withCount('spareparts')

            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode_kategori', 'like', "%{$search}%")
                        ->orWhere('nama_kategori', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status_kategori', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $kodeKategori = Kategori::generateKode();

        return view('kategori.index', compact('kategori', 'kodeKategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kodeKategori = Kategori::generateKode();

        return view('kategori.create', compact('kodeKategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'status_kategori' => 'nullable'
        ]);

        $data['kode_kategori'] = Kategori::generateKode();

        $data['status_kategori'] =
            $request->has('status_kategori')
            ? 'aktif'
            : 'nonaktif';

        Kategori::create($data);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'status_kategori' => 'nullable'
        ]);

        $data['status_kategori'] = $request->has('status_kategori')
            ? 'aktif'
            : 'nonaktif';

        $kategori->update($data);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function toggleStatus(Kategori $kategori)
    {
        $kategori->status_kategori =
            $kategori->status_kategori == 'aktif'
            ? 'nonaktif'
            : 'aktif';

        $kategori->save();

        return response()->json([

            'success' => true,
            'status' => $kategori->status_kategori

        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        if ($kategori->spareparts()->exists()) {

            return back()->with(
                'error',
                'Kategori masih digunakan oleh sparepart.'
            );
        }

        $kategori->delete();

        return back()->with(
            'success',
            'Kategori berhasil dihapus.'
        );
    }

    public function trash(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $kategori = Kategori::onlyTrashed()
            ->withCount('spareparts')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode_kategori', 'like', "%{$search}%")
                        ->orWhere('nama_kategori', 'like', "%{$search}%");
                });
            })

            ->when($status, function ($query) use ($status) {
                $query->where('status_kategori', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'kategori.trash',
            compact('kategori')
        );
    }

    public function restore($id)
    {
        $kategori = Kategori::onlyTrashed()->findOrFail($id);

        $kategori->restore();

        return redirect()->route('kategori.trash')
            ->with('success', 'Kategori berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $kategori = Kategori::onlyTrashed()
            ->findOrFail($id);

        if ($kategori->spareparts()->withTrashed()->exists()) {
            return back()->with(
                'error',
                'Kategori masih memiliki relasi sparepart.'
            );
        }

        $kategori->forceDelete();

        return redirect()
            ->route('kategori.trash')
            ->with(
                'success',
                'Kategori berhasil dihapus permanen.'
            );
    }
}
