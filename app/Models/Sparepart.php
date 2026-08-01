<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sparepart extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode_sparepart',
        'nama_sparepart',
        'kategori_id',
        'brand_id',
        'unit_id',
        'stok',
        'min_stok',
        'deskripsi'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function suppliers()
    {
        return $this->belongsToMany(
            Supplier::class,
            'supplier_spareparts'
        )
            ->withPivot('harga_beli')
            ->withTimestamps();
    }

    public function transaksiDetails()
    {
        return $this->hasMany(StokTransaksiDetail::class);
    }

    public static function generateKode()
    {
        $last = self::withTrashed()
            ->latest('id')
            ->first();

        $number = $last
            ? intval(substr($last->kode_sparepart, 3)) + 1
            : 1;

        return 'SPR' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function isLowStock()
    {
        return $this->stok <= $this->min_stok;
    }
}
