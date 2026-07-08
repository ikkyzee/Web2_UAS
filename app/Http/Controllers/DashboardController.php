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

        // Dummy Data untuk Chart: Tren "Total Pengiriman per Bulan"
        $chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            'data' => [15, 22, 18, 30, 25, 40]
        ];

        return view('dashboard.index', compact('widgets', 'chartData'));
    }
}
