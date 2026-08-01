<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierSparepart extends Model
{
    protected $table = 'supplier_spareparts';

    protected $fillable = [
        'supplier_id',
        'sparepart_id',
        'harga_beli',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }
}