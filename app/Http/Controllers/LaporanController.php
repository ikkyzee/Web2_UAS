<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class LaporanController extends Controller
{
    public function stok(Request $request)
    {
        $search = $request->search;
        $barangs = Barang::with('kategori')
            ->when($search, function ($query, $search) {
                return $query->where('nama_barang', 'like', "%{$search}%")
                             ->orWhere('kode_barang', 'like', "%{$search}%")
                             ->orWhereHas('kategori', function ($q) use ($search) {
                                 $q->where('nama_kategori', 'like', "%{$search}%");
                             });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
            
        return view('laporan.stok', compact('barangs', 'search'));
    }

    public function exportStokCsv()
    {
        $barangs = Barang::with('kategori')->orderBy('nama_barang')->get();
        
        $filename = "Laporan_Stok_Barang_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        
        $columns = ['No', 'Kode Barang', 'Kategori', 'Nama Barang', 'Ukuran', 'Warna', 'Sisa Stok (Kg)'];
        
        $callback = function() use($barangs, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            $no = 1;
            foreach ($barangs as $barang) {
                $row = [
                    $no++,
                    $barang->kode_barang,
                    $barang->kategori->nama_kategori ?? '-',
                    $barang->nama_barang,
                    $barang->ukuran,
                    $barang->warna,
                    $barang->stok_kiloan
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
