<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode_brand',
        'nama_brand',
        'status_brand'
    ];

    public function spareparts()
    {
        return $this->hasMany(Sparepart::class);
    }

    public static function generateKode()
    {
        $last = self::withTrashed()
            ->latest('id')
            ->first();

        $number = $last
            ? intval(substr($last->kode_brand, 4)) + 1
            : 1;

        return 'BRND' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
