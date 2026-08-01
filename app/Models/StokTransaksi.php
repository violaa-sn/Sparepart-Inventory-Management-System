<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokTransaksi extends Model
{
    protected $fillable = [
        'kode_transaksi',
        'supplier_id',
        'user_id',
        'tipe',
        'tanggal_transaksi',
        'status_transaksi',
        'catatan'
    ];

    public function details()
    {
        return $this->hasMany(
            StokTransaksiDetail::class
        );
    }

    //kalau 2 ini di soft delelte, tetep mcul di histori
    public function user()
    {
        return $this->belongsTo(User::class)
            ->withTrashed();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)
            ->withTrashed();
    }
}
