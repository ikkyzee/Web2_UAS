<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function penerimaan()
    {
        return $this->belongsTo(Penerimaan::class);
    }

    public function penerimaanRoll()
    {
        return $this->belongsTo(PenerimaanRoll::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function detailPengirimans()
    {
        return $this->hasMany(DetailPengiriman::class);
    }
}
