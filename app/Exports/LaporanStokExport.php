<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanStokExport implements FromView, ShouldAutoSize
{
    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function view(): View
    {
        $query = Barang::with(['penerimaan', 'penerimaanRoll', 'kategori']);

        if ($this->status === 'di_gudang') {
            $query->where('status', 'di_gudang');
        } elseif ($this->status === 'dikirim') {
            $query->where('status', 'dikirim')->with('detailPengirimans.pengiriman.toko');
        } else {
            $query->with('detailPengirimans.pengiriman.toko');
        }

        return view('laporan.excel', [
            'barangs' => $query->latest()->get(),
            'status' => $this->status
        ]);
    }
}
