<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'kode_user',
    'nama_user',
    'email',
    'nomor_telepon',
    'password',
    'role',
    'status_user'
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use SoftDeletes;
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function stokTransaksis()
    {
        return $this->hasMany(StokTransaksi::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {

            $tanggal = now()->format('dmy');

            $lastUser = User::withTrashed()
                ->latest('id')
                ->first();

            $counter = $lastUser
                ? $lastUser->id + 1
                : 1;

            $user->kode_user =
                'USR' .
                $tanggal .
                str_pad($counter, 3, '0', STR_PAD_LEFT);
        });
    }

    public static function generateKode()
    {
        $tanggal = now()->format('dmy');

        $lastUser = self::withTrashed()
            ->latest('id')
            ->first();

        $counter = $lastUser ? $lastUser->id + 1 : 1;

        return 'USR' . $tanggal . str_pad($counter, 3, '0', STR_PAD_LEFT);
    }

    public function isActive()
    {
        return $this->status_user === 'aktif';
    }
}
