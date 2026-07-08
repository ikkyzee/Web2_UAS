<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roll extends Model
{
    use HasFactory;

    protected $fillable = [
        'penerimaan_id',
        'barang_id',
        'nomor_roll',
        'berat_kg',
        'status',
    ];

    public function penerimaan()
    {
        return $this->belongsTo(Penerimaan::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function detailPengirimans()
    {
        return $this->hasMany(DetailPengiriman::class);
    }
}
