<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */ public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $unit = Unit::withCount('spareparts')

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('kode_unit', 'like', "%{$search}%")
                        ->orWhere('nama_unit', 'like', "%{$search}%");
                });
            })

            ->when($status, function ($query) use ($status) {

                $query->where('status_unit', $status);
            })

            ->latest()

            ->paginate(10)

            ->withQueryString();

        return view(
            'unit.index',
            compact('unit')
        );
    }

    public function toggleStatus(Unit $unit)
    {
        $unit->status_unit =
            $unit->status_unit == 'aktif'
            ? 'nonaktif'
            : 'aktif';

        $unit->save();

        return response()->json([
            'success' => true,
            'status' => $unit->status_unit,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        //
    }
}
