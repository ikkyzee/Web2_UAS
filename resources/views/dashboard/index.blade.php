@extends('layouts.app')

@section('title', 'Data Stock - Gudang')
@section('page_heading', 'Data Stock Gudang')

@section('content')
    <!-- Widget Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card card-stats text-white bg-primary shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="card-title text-uppercase opacity-75">Total Barang</h6>
                    <h2 class="mb-0 fw-bold">{{ $widgets['total_barang'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats text-white bg-success shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="card-title text-uppercase opacity-75">Total Toko</h6>
                    <h2 class="mb-0 fw-bold">{{ $widgets['total_toko'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats text-white bg-warning shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="card-title text-uppercase opacity-75">Total Armada</h6>
                    <h2 class="mb-0 fw-bold">{{ $widgets['total_armada'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats text-white bg-info shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="card-title text-uppercase opacity-75">Total Pengiriman</h6>
                    <h2 class="mb-0 fw-bold">{{ $widgets['total_pengiriman'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
            <h5 class="fw-bold text-secondary">Tren Pengiriman per Bulan</h5>
        </div>
        <div class="card-body">
            <div style="height: 350px;">
                <canvas id="pengirimanChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('pengirimanChart').getContext('2d');
    const chartData = @json($chartData);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Total Pengiriman',
                data: chartData.data,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.15)',
                borderWidth: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#0d6efd',
                pointRadius: 4,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush
