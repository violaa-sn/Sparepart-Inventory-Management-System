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
        $kategori = Kategori::withCount('barang')
            ->latest()
            ->paginate(10);

        $search = $request->search;

        $kategori = Kategori::withCount('barang')
            ->when($search, function ($query) use ($search) {

                $query->where('nama_kategori', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100'
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategori.index')
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
        $request->validate([
            'nama_kategori' => 'required|string|max:100'
        ]);

        $kategori->update($request->all());

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Kategori $kategori)
   {
    if ($kategori->barang()->exists()) {
        return back()->with(
            'error',
            'Kategori masih digunakan oleh barang sehingga tidak dapat dihapus.'
        );
    }

    $kategori->delete();

    return back()->with('success', 'Kategori berhasil dihapus.');
    }

    public function trash()
    {
        $kategori = Kategori::onlyTrashed()
            ->latest()
            ->paginate(10);

        return view('kategori.trash', compact('kategori'));
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
        $kategori = Kategori::onlyTrashed()->findOrFail($id);

        $kategori->forceDelete();

        return redirect()->route('kategori.trash')
            ->with('success', 'Kategori berhasil dihapus permanen.');
    }
}
