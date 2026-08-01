<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;
use Illuminate\Database\Eloquent\SoftDeletes;


class Kategori extends Model
{
      protected $fillable = ['nama_kategori', 'status_kategori'];

    use SoftDeletes;

    public function barang() {
        return $this->hasMany(Barang::class);
    }

   protected static function boot()
   {
    parent::boot();

    static::creating(function ($kategori) {

        $inisial = collect(explode(' ', $kategori->nama_kategori))
            ->map(function ($kata) {
                return strtoupper(substr($kata, 0, 1));
            })
            ->join('');

            $tanggal = now()->format('dmy');

        $lastKategori = Kategori::withTrashed()->latest('id')->first();

        $counter = $lastKategori ? $lastKategori->id + 1 : 1;

        $kategori->kode_kategori =
            'KAT' . $inisial . $tanggal. str_pad($counter, 3, '0', STR_PAD_LEFT);
    });
    }
}
