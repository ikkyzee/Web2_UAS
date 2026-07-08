@extends('layouts.app')

@section('title', 'Laporan Stok Barang - KT Inventory')
@section('page_heading', 'Laporan Stok Barang')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
        <div class="row align-items-center">
            <div class="col-md-4 d-flex align-items-center mb-3 mb-md-0">
                <h5 class="fw-bold text-secondary mb-0 me-3">Posisi Stok Gudang</h5>
            </div>
            <div class="col-md-8">
                <form action="{{ route('laporan.stok') }}" method="GET" class="d-flex justify-content-md-end">
                    <a href="{{ route('laporan.export.csv') }}" class="btn btn-outline-success btn-sm shadow-sm me-2"><i class="fas fa-file-excel"></i> Export</a>
                    <div class="input-group" style="max-width: 300px;">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama atau kode..." value="{{ $search ?? '' }}">
                        <button class="btn btn-outline-secondary btn-sm" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered">
                <thead class="table-light text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Kode Barang</th>
                        <th width="25%">Nama Barang</th>
                        <th width="15%">Kategori</th>
                        <th width="10%">Ukuran</th>
                        <th width="15%">Warna</th>
                        <th width="15%">Sisa Stok (Kg)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $barang)
                    <tr>
                        <td class="text-center">{{ $barangs->firstItem() + $loop->index }}</td>
                        <td class="text-center fw-bold">{{ $barang->kode_barang }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td class="text-center">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td class="text-center">{{ $barang->ukuran }}</td>
                        <td class="text-center">{{ $barang->warna }}</td>
                        <td class="text-end pe-3 fw-bold {{ $barang->stok_kiloan < 50 ? 'text-danger' : 'text-success' }}">
                            {{ number_format($barang->stok_kiloan, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada data barang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($barangs->hasPages())
        <div class="mt-4 border-top pt-3">
            {{ $barangs->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection
