<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Toko;
use App\Models\Armada;
use App\Models\Pengiriman;

class DashboardController extends Controller
{
    public function index()
    {
        $widgets = [
            'total_barang' => Barang::count(),
            'total_toko' => Toko::count(),
            'total_armada' => Armada::count(),
            'total_pengiriman' => Pengiriman::count(),
        ];

        // Data untuk Chart: Tren "Total Pengiriman per Bulan" (6 bulan terakhir)
        $chartLabels = [];
        $chartValues = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subMonths($i);
            $chartLabels[] = $date->translatedFormat('M Y'); // e.g. "Jul 2026"
            
            $count = Pengiriman::whereYear('tanggal_kirim', $date->year)
                        ->whereMonth('tanggal_kirim', $date->month)
                        ->count();
                        
            $chartValues[] = $count;
        }

        $chartData = [
            'labels' => $chartLabels,
            'data' => $chartValues
        ];

        return view('dashboard.index', compact('widgets', 'chartData'));
    }
}
