<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
        'status_kategori'
    ];

    public function spareparts() {
        return $this->hasMany(Sparepart::class);
    }

    public static function generateKode()
    {
        $last = self::withTrashed()
            ->latest('id')
            ->first();

        $number = $last
            ? intval(substr($last->kode_kategori, 3)) + 1
            : 1;

        return 'KTG' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
