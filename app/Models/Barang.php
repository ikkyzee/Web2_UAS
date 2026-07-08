<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['kategori_id', 'kode_barang', 'nama_barang', 'ukuran', 'warna'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function rolls()
    {
        return $this->hasMany(Roll::class);
    }

    public function getStokKiloanAttribute()
    {
        return $this->rolls()->where('status', 'di_gudang')->sum('berat_kg');
    }

    public function pengirimans()
    {
        return $this->belongsToMany(Pengiriman::class, 'detail_pengirimans')
                    ->withPivot('jumlah_kiloan')
                    ->withTimestamps();
    }
}
