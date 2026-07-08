<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengirimans';

    protected $fillable = ['user_id', 'toko_id', 'armada_id', 'tanggal_kirim', 'tanggal_diterima', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function armada()
    {
        return $this->belongsTo(Armada::class);
    }

    public function detailPengirimans()
    {
        return $this->hasMany(DetailPengiriman::class);
    }

    public function barangs()
    {
        return $this->belongsToMany(Barang::class, 'detail_pengirimans')
                    ->withPivot('jumlah_kiloan')
                    ->withTimestamps();
    }
}
