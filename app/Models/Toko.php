<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Toko extends Model
{
    use HasFactory;

    protected $fillable = ['nama_toko', 'alamat_toko'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function pengirimans()
    {
        return $this->hasMany(Pengiriman::class);
    }
}
