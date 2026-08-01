<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'kode_unit',
        'nama_unit',
        'status_unit'
    ];

    public function spareparts()
    {
        return $this->hasMany(Sparepart::class);
    }
}