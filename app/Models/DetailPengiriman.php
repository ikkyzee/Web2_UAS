<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPengiriman extends Model
{
    use HasFactory;

    protected $table = 'detail_pengirimans';

    protected $fillable = [
        'pengiriman_id',
        'roll_id',
    ];

    public function pengiriman()
    {
        return $this->belongsTo(Pengiriman::class);
    }

    public function roll()
    {
        return $this->belongsTo(Roll::class);
    }
}
