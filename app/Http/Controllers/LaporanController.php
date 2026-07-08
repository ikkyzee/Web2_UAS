<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanStokExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;

        if (auth()->check() && auth()->user()->role === 'admin_toko') {
            $status = 'di_gudang'; // Force to di_gudang for admin_toko
        }

        $query = Barang::with(['penerimaan', 'penerimaanRoll', 'kategori']);

        if ($status === 'di_gudang') {
            $query->where('status', 'di_gudang');
        } elseif ($status === 'dikirim') {
            $query->where('status', 'dikirim')->with('detailPengirimans.pengiriman.toko');
        } else {
            // Jika Semua Data, ambil juga detail pengiriman untuk yang statusnya dikirim
            $query->with('detailPengirimans.pengiriman.toko');
        }

        $barangs = $query->latest()->get();

        return view('laporan.index', compact('barangs', 'status'));
    }

    public function exportPdf(Request $request)
    {
        $status = $request->status;
        
        if (auth()->check() && auth()->user()->role === 'admin_toko') {
            $status = 'di_gudang'; // Force to di_gudang for admin_toko
        }

        $query = Barang::with(['penerimaan', 'penerimaanRoll', 'kategori']);

        if ($status === 'di_gudang') {
            $query->where('status', 'di_gudang');
        } elseif ($status === 'dikirim') {
            $query->where('status', 'dikirim')->with('detailPengirimans.pengiriman.toko');
        } else {
            $query->with('detailPengirimans.pengiriman.toko');
        }

        $barangs = $query->latest()->get();

        $pdf = Pdf::loadView('laporan.pdf', compact('barangs', 'status'))->setPaper('a4', 'landscape');
        return $pdf->download('Laporan_Stok_Barang_' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $status = $request->status;
        
        if (auth()->check() && auth()->user()->role === 'admin_toko') {
            $status = 'di_gudang'; // Force to di_gudang for admin_toko
        }

        return Excel::download(new LaporanStokExport($status), 'Laporan_Stok_Barang_' . date('Y-m-d') . '.xlsx');
    }
}
