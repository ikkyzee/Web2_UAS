@extends('layouts.app')

@section('title', 'Transaksi Pengiriman - KT Inventory')
@section('page_heading', 'Transaksi Pengiriman')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
        <div class="row align-items-center">
            <div class="col-md-4 d-flex align-items-center mb-3 mb-md-0">
                <h5 class="fw-bold text-secondary mb-0 me-3">Data Pengiriman</h5>
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'petugas')
                <button type="button" class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPengiriman">
                    <i class="fas fa-plus me-1"></i> Tambah
                </button>
                @endif
            </div>
            <div class="col-md-8">
                <form action="{{ route('pengirimans.index') }}" method="GET" class="d-flex justify-content-md-end">
                    <a href="{{ route('pengirimans.export.pdf') }}" class="btn btn-outline-danger btn-sm shadow-sm me-2"><i class="fas fa-file-pdf"></i> PDF</a>
                    <a href="{{ route('pengirimans.export.excel') }}" class="btn btn-outline-success btn-sm shadow-sm me-2"><i class="fas fa-file-excel"></i> Excel</a>
                    <div class="input-group" style="max-width: 300px;">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari kode, status, armada..." value="{{ $search ?? '' }}">
                        <button class="btn btn-outline-secondary btn-sm" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal Kirim</th>
                        <th width="20%">Toko Tujuan</th>
                        <th width="15%">Armada</th>
                        <th width="15%">Petugas</th>
                        <th width="15%">Status</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengirimans as $pengiriman)
                    <tr>
                        <td>{{ $loop->iteration + $pengirimans->firstItem() - 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($pengiriman->tanggal_kirim)->format('d M Y') }}</td>
                        <td class="fw-bold">{{ $pengiriman->toko->nama_toko ?? '-' }}</td>
                        <td>{{ $pengiriman->armada->plat_nomor ?? '-' }}</td>
                        <td>{{ $pengiriman->user->name ?? '-' }}</td>
                        <td>
                            @if($pengiriman->status === 'diproses')
                                <span class="badge bg-secondary">Diproses</span>
                            @elseif($pengiriman->status === 'dikirim')
                                <span class="badge bg-warning text-dark">Dikirim</span>
                            @else
                                <span class="badge bg-success">Diterima</span>
                                <br><small class="text-muted">{{ \Carbon\Carbon::parse($pengiriman->tanggal_diterima)->format('d/m/Y H:i') }}</small>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('pengirimans.show', $pengiriman->id) }}" class="btn btn-sm btn-info text-white shadow-sm mb-1"><i class="fas fa-eye"></i> Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada riwayat pengiriman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            {{ $pengirimans->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Modal Tambah Pengiriman -->
<div class="modal fade" id="modalTambahPengiriman" tabindex="-1" aria-labelledby="modalTambahPengirimanLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-bottom-0">
                <h5 class="modal-title fw-bold" id="modalTambahPengirimanLabel">Buat Pengiriman Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pengirimans.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <h6 class="border-bottom pb-2 mb-4 text-primary fw-bold">Informasi Pengiriman</h6>
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="tanggal_kirim" class="form-label fw-bold">Tanggal Kirim <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_kirim') is-invalid @enderror" id="tanggal_kirim" name="tanggal_kirim" value="{{ old('tanggal_kirim', date('Y-m-d')) }}" required>
                            @error('tanggal_kirim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="toko_id" class="form-label fw-bold">Toko Tujuan <span class="text-danger">*</span></label>
                            <select class="form-select @error('toko_id') is-invalid @enderror" id="toko_id" name="toko_id" required>
                                <option value="">-- Pilih Toko --</option>
                                @foreach($tokos as $toko)
                                    <option value="{{ $toko->id }}">{{ $toko->nama_toko }} ({{ str()->limit($toko->alamat_toko, 30) }})</option>
                                @endforeach
                            </select>
                            @error('toko_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="armada_id" class="form-label fw-bold">Armada Kendaraan <span class="text-danger">*</span></label>
                            <select class="form-select @error('armada_id') is-invalid @enderror" id="armada_id" name="armada_id" required>
                                <option value="">-- Pilih Armada --</option>
                                @foreach($armadas as $armada)
                                    <option value="{{ $armada->id }}">{{ $armada->plat_nomor }} - {{ $armada->jenis_kendaraan }} ({{ $armada->nama_supir }})</option>
                                @endforeach
                            </select>
                            @error('armada_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <h6 class="border-bottom pb-2 mb-3 text-primary fw-bold d-flex justify-content-between align-items-center">
                        Detail Barang
                        <button type="button" class="btn btn-sm btn-success" id="btn-add-item"><i class="fas fa-plus me-1"></i> Tambah Barang</button>
                    </h6>

                    <div id="items-container">
                        <!-- Baris barang pertama (default) -->
                        <div class="row align-items-end mb-3 item-row">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Pilih Barang <span class="text-danger">*</span></label>
                                <select class="form-select" name="barang_id[]" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}">
                                            [{{ $barang->kode_barang }}] {{ $barang->nama_barang }} (Uk: {{ $barang->ukuran }}, Warn: {{ $barang->warna }}) - Stok: {{ $barang->stok_kiloan }}kg
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Jumlah (Kg) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" name="jumlah_kiloan[]" required placeholder="0.00">
                            </div>
                            <div class="col-md-1 text-end">
                                <button type="button" class="btn btn-danger btn-remove-item" disabled><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 bg-light">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i> Proses Pengiriman</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($errors->any())
            var myModal = new bootstrap.Modal(document.getElementById('modalTambahPengiriman'));
            myModal.show();
        @endif

        const container = document.getElementById('items-container');
        const btnAdd = document.getElementById('btn-add-item');
        
        if (container && btnAdd) {
            // Simpan template row
            const rowTemplate = container.querySelector('.item-row').cloneNode(true);
            rowTemplate.querySelector('select').value = '';
            rowTemplate.querySelector('input').value = '';
            rowTemplate.querySelector('.btn-remove-item').disabled = false;

            btnAdd.addEventListener('click', function() {
                const newRow = rowTemplate.cloneNode(true);
                container.appendChild(newRow);
                attachRemoveEvent(newRow.querySelector('.btn-remove-item'));
            });

            function attachRemoveEvent(button) {
                button.addEventListener('click', function() {
                    if(container.querySelectorAll('.item-row').length > 1) {
                        this.closest('.item-row').remove();
                    }
                });
            }
        }
    });
</script>
@endpush

@endsection
