<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Armada extends Model
{
    use HasFactory;

    protected $fillable = ['plat_nomor', 'jenis_kendaraan', 'nama_supir'];

    public function pengirimans()
    {
        return $this->hasMany(Pengiriman::class);
    }
}
