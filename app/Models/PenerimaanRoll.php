<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanRoll extends Model
{
    use HasFactory;

    protected $table = 'penerimaan_rolls';
    protected $guarded = ['id'];

    public function penerimaan()
    {
        return $this->belongsTo(Penerimaan::class);
    }

    public function barang()
    {
        return $this->hasOne(Barang::class);
    }
}
