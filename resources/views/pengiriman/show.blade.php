@extends('layouts.app')

@section('title', 'Detail Surat Jalan - KT Inventory')
@section('page_heading', 'Detail Surat Jalan')

@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-5">
                <!-- Header Surat Jalan -->
                <div class="row border-bottom pb-4 mb-4">
                    <div class="col-sm-6">
                        <h3 class="fw-bold text-primary mb-1">PT KARUNIA TEXTILE</h3>
                        <p class="text-muted mb-0">Warehouse Inventory & Distribution</p>
                    </div>
                    <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                        <h4 class="text-secondary mb-1">SURAT JALAN</h4>
                        <strong>No:</strong> SJ-{{ date('Ymd', strtotime($pengiriman->tanggal_kirim)) }}-{{ str_pad($pengiriman->id, 4, '0', STR_PAD_LEFT) }}<br>
                        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pengiriman->tanggal_kirim)->format('d F Y') }}
                    </div>
                </div>

                <!-- Info Tujuan -->
                <div class="row mb-5">
                    <div class="col-sm-6">
                        <h6 class="fw-bold text-muted mb-3">TUJUAN PENGIRIMAN:</h6>
                        <h5 class="fw-bold mb-1">{{ $pengiriman->toko->nama_toko }}</h5>
                        <p class="mb-0">{{ $pengiriman->toko->alamat_toko }}</p>
                    </div>
                    <div class="col-sm-6 mt-4 mt-sm-0 text-sm-end">
                        <h6 class="fw-bold text-muted mb-3">INFORMASI ARMADA:</h6>
                        <p class="mb-1"><strong>Supir:</strong> {{ $pengiriman->armada->nama_supir }}</p>
                        <p class="mb-1"><strong>Kendaraan:</strong> {{ $pengiriman->armada->jenis_kendaraan }}</p>
                        <p class="mb-0"><strong>Plat Nomor:</strong> {{ $pengiriman->armada->plat_nomor }}</p>
                    </div>
                </div>

                <!-- Detail Barang -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead class="table-light text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Nomor Roll</th>
                                <th width="15%">Kode Barang</th>
                                <th width="30%">Nama Barang</th>
                                <th width="15%">Warna/Ukuran</th>
                                <th width="15%">Berat (Kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalKg = 0; @endphp
                            @foreach($pengiriman->detailPengirimans as $detail)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center fw-bold">{{ $detail->roll->nomor_roll }}</td>
                                <td class="text-center">{{ $detail->roll->barang->kode_barang }}</td>
                                <td>{{ $detail->roll->barang->nama_barang }}</td>
                                <td class="text-center">{{ $detail->roll->barang->warna }} / {{ $detail->roll->barang->ukuran }}</td>
                                <td class="text-end pe-4">{{ number_format($detail->roll->berat_kg, 2) }}</td>
                            </tr>
                            @php $totalKg += $detail->roll->berat_kg; @endphp
                            @endforeach
                        </tbody>
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td colspan="5" class="text-end pe-3">TOTAL KESELURUHAN ({{ count($pengiriman->detailPengirimans) }} Roll)</td>
                                <td class="text-end pe-4">{{ number_format($totalKg, 2) }} Kg</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- TTD -->
                <div class="row mt-5 text-center">
                    <div class="col-4">
                        <p class="mb-5">Dibuat Oleh,</p>
                        <p class="fw-bold mb-0">({{ $pengiriman->user->name }})</p>
                        <p class="text-muted small">Petugas Gudang</p>
                    </div>
                    <div class="col-4">
                        <p class="mb-5">Supir Pengirim,</p>
                        <p class="fw-bold mb-0">({{ $pengiriman->armada->nama_supir }})</p>
                    </div>
                    <div class="col-4">
                        <p class="mb-5">Diterima Oleh,</p>
                        <p class="fw-bold mb-0">(.......................)</p>
                        <p class="text-muted small">Admin Toko</p>
                    </div>
                </div>
            </div>
            
            <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center">
                <a href="{{ route('pengirimans.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
                <div>
                    <!-- Tombol cetak browser sederhana -->
                    <button onclick="window.print()" class="btn btn-dark me-2"><i class="fas fa-print me-1"></i> Print</button>
                    <!-- Form Update Status -->
                    <form action="{{ route('pengirimans.update', $pengiriman->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        @if($pengiriman->status === 'diproses')
                            <input type="hidden" name="status" value="dikirim">
                            <button type="submit" class="btn btn-warning shadow-sm"><i class="fas fa-truck me-1"></i> Tandai Sedang Dikirim</button>
                        @elseif($pengiriman->status === 'dikirim')
                            <input type="hidden" name="status" value="diterima">
                            <button type="submit" class="btn btn-success shadow-sm" onclick="return confirm('Konfirmasi bahwa barang telah diterima di toko?');"><i class="fas fa-check me-1"></i> Konfirmasi Diterima</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="fw-bold text-muted border-bottom pb-2 mb-3">Status Pengiriman</h6>
                
                @if($pengiriman->status === 'diproses')
                    <div class="alert alert-secondary">
                        <i class="fas fa-box me-2"></i> Sedang Diproses Gudang
                    </div>
                @elseif($pengiriman->status === 'dikirim')
                    <div class="alert alert-warning">
                        <i class="fas fa-truck me-2"></i> Dalam Perjalanan (Dikirim)
                    </div>
                @else
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i> Telah Diterima
                        <hr class="my-2">
                        <small>Pada: {{ \Carbon\Carbon::parse($pengiriman->tanggal_diterima)->format('d M Y H:i') }}</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
