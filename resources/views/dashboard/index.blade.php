@extends('layouts.app')

@section('title', 'Dashboard - KT Inventory')
@section('page_heading', 'Dashboard Overview')

@section('content')
<div class="space-y-6">
    <!-- Highlight Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 transition-all hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Roll di Gudang</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $widgets['total_barang'] ?? 0 }}</h3>
                </div>
                <div class="p-3 bg-brand-50 text-brand-600 rounded-lg">
                    <i class="fas fa-box text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-500 font-medium flex items-center"><i class="fas fa-arrow-up mr-1"></i> Terkatalog</span>
                <span class="text-gray-400 ml-2">Total Barang</span>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 transition-all hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Toko</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $widgets['total_toko'] ?? 0 }}</h3>
                </div>
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                    <i class="fas fa-store text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-indigo-500 font-medium">Toko Cabang Tujuan</span>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 transition-all hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Pengiriman Barang</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $widgets['total_pengiriman'] ?? 0 }}</h3>
                </div>
                <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                    <i class="fas fa-truck-loading text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-400">Total Transaksi Pengiriman</span>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 transition-all hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Armada Aktif</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $widgets['total_armada'] ?? 0 }}</h3>
                </div>
                <div class="p-3 bg-rose-50 text-rose-600 rounded-lg">
                    <i class="fas fa-truck text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-400">Kendaraan & Supir</span>
            </div>
        </div>
    </div>

    <!-- Chart and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart Container -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800"><i class="fas fa-chart-line text-brand-500 mr-2"></i> Tren Pengiriman</h3>
            </div>
            <div class="p-6 relative h-72">
                <canvas id="pengirimanChart"></canvas>
            </div>
        </div>

        <!-- Quick Actions & Welcome -->
        <div class="space-y-6">
            <div class="bg-gradient-to-br from-sidebar to-gray-900 rounded-xl shadow-sm border border-gray-800 text-white overflow-hidden relative">
                <div class="absolute right-0 bottom-0 opacity-10">
                    <i class="fas fa-warehouse text-9xl -mr-4 -mb-4"></i>
                </div>
                <div class="p-6 relative z-10">
                    <h3 class="text-2xl font-bold mb-2">Data Stock Gudang</h3>
                    <p class="text-gray-300 mb-4 max-w-sm text-sm">Sistem pelacakan fisik barang per-Roll terintegrasi.</p>
                    <div class="flex gap-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-brand-500/20 text-brand-300 border border-brand-500/30">
                            v2.0 (Tailwind)
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800 text-sm"><i class="fas fa-bolt text-amber-400 mr-2"></i> Akses Cepat</h3>
                </div>
                <div class="p-4 grid grid-cols-2 gap-3">
                    <a href="{{ url('/penerimaans') }}" class="flex flex-col items-center justify-center p-3 border border-gray-200 rounded-lg hover:bg-brand-50 hover:border-brand-200 transition-colors group">
                        <i class="fas fa-arrow-circle-down text-gray-400 group-hover:text-brand-600 text-xl mb-2"></i>
                        <span class="text-xs font-medium text-gray-700 text-center">Inbound</span>
                    </a>
                    <a href="{{ url('/barangs') }}" class="flex flex-col items-center justify-center p-3 border border-gray-200 rounded-lg hover:bg-brand-50 hover:border-brand-200 transition-colors group">
                        <i class="fas fa-box-open text-gray-400 group-hover:text-brand-600 text-xl mb-2"></i>
                        <span class="text-xs font-medium text-gray-700 text-center">Katalog</span>
                    </a>
                    <a href="{{ url('/pengirimans/create') }}" class="flex flex-col items-center justify-center p-3 border border-gray-200 rounded-lg hover:bg-brand-50 hover:border-brand-200 transition-colors group">
                        <i class="fas fa-truck text-gray-400 group-hover:text-brand-600 text-xl mb-2"></i>
                        <span class="text-xs font-medium text-gray-700 text-center">Outbound</span>
                    </a>
                    <a href="{{ url('/laporan-stok') }}" class="flex flex-col items-center justify-center p-3 border border-gray-200 rounded-lg hover:bg-brand-50 hover:border-brand-200 transition-colors group">
                        <i class="fas fa-file-alt text-gray-400 group-hover:text-brand-600 text-xl mb-2"></i>
                        <span class="text-xs font-medium text-gray-700 text-center">Laporan</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('pengirimanChart').getContext('2d');
        
        // Data dari Controller
        const labels = {!! json_encode($chartData['labels'] ?? []) !!};
        const dataPoints = {!! json_encode($chartData['data'] ?? []) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Pengiriman per Bulan',
                    data: dataPoints,
                    borderColor: '#2563eb', // brand-600
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#2563eb',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        padding: 12,
                        titleFont: { size: 13, family: "'Inter', sans-serif" },
                        bodyFont: { size: 13, family: "'Inter', sans-serif" },
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' Transaksi Pengiriman';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6',
                            drawBorder: false
                        },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 11 },
                            color: '#6b7280',
                            stepSize: 10
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 11 },
                            color: '#6b7280'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    });
</script>
@endpush
@endsection
