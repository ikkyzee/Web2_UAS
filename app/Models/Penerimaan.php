<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'tanggal_masuk',
        'kode_batch',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function rolls()
    {
        return $this->hasMany(Roll::class);
    }
}
