<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode_supplier',
        'nama_supplier',
        'alamat',
        'notlp',
        'email',
        'status_supplier'
    ];

    public function spareparts()
    {
        return $this->belongsToMany(
            Sparepart::class,
            'supplier_spareparts'
        )
            ->withPivot('harga_beli')
            ->withTimestamps();
    }

    public function stokTransaksis()
    {
        return $this->hasMany(StokTransaksi::class);
    }

    public static function generateKode()
    {
        $last = self::withTrashed()
            ->latest('id')
            ->first();

        $number = $last
            ? intval(substr($last->kode_supplier, 3)) + 1
            : 1;

        return 'SUP' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
