<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokTransaksiDetail extends Model
{
    protected $fillable = [
        'stok_transaksi_id',
        'sparepart_id',
        'qty',
        'harga_perunit'
    ];

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class)
            ->withTrashed();
    }

    public function transaksi()
    {
        return $this->belongsTo(
            StokTransaksi::class,
            'stok_transaksi_id'
        );
    }
}
