<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    use HasFactory;

    protected $table = 'penerimaans';
    protected $guarded = ['id'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function penerimaanRolls()
    {
        return $this->hasMany(PenerimaanRoll::class);
    }

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
