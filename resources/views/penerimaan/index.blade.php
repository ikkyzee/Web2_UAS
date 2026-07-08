@extends('layouts.app')

@section('title', 'Penerimaan Roll Barang - KT Inventory')
@section('page_heading', 'Penerimaan Roll Barang')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-3">
        <div class="row align-items-center">
            <div class="col-md-4 d-flex align-items-center mb-3 mb-md-0">
                <h5 class="fw-bold text-secondary mb-0 me-3">Penerimaan Roll</h5>
                <button type="button" class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPenerimaan">
                    <i class="fas fa-plus me-1"></i> Tambah Inbound
                </button>
            </div>
            <div class="col-md-8">
                <form action="{{ route('penerimaans.index') }}" method="GET" class="d-flex justify-content-md-end">
                    <div class="input-group" style="max-width: 300px;">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari batch atau supplier..." value="{{ $search ?? '' }}">
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
                        <th width="15%">Kode Batch</th>
                        <th width="15%">Tanggal Masuk</th>
                        <th width="20%">Supplier</th>
                        <th width="10%">Total Roll</th>
                        <th width="15%">Total Berat (Kg)</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penerimaans as $p)
                    <tr>
                        <td>{{ $loop->iteration + $penerimaans->firstItem() - 1 }}</td>
                        <td class="fw-bold text-primary">{{ $p->kode_batch }}</td>
                        <td>{{ $p->tanggal_masuk->format('d M Y') }}</td>
                        <td>{{ $p->supplier->nama_supplier ?? '-' }}</td>
                        <td>{{ $p->rolls->count() }} Roll</td>
                        <td>{{ number_format($p->rolls->sum('berat_kg'), 2) }}</td>
                        <td class="text-center">
                            <form action="{{ route('penerimaans.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus penerimaan ini beserta semua roll di dalamnya?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger shadow-sm mb-1"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada data penerimaan roll.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            {{ $penerimaans->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Modal Tambah Penerimaan -->
<div class="modal fade" id="modalTambahPenerimaan" tabindex="-1" aria-labelledby="modalTambahPenerimaanLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-bottom-0">
                <h5 class="modal-title fw-bold" id="modalTambahPenerimaanLabel">Tambah Data Penerimaan Roll</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('penerimaans.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Kode Batch <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="kode_batch" required placeholder="Contoh: BATCH-001" value="{{ old('kode_batch') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal_masuk" required value="{{ old('tanggal_masuk', date('Y-m-d')) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Supplier <span class="text-danger">*</span></label>
                            <select class="form-select" name="supplier_id" required>
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3 border-bottom pb-2">Detail Roll (Serialized Items)</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="tableRoll">
                            <thead class="table-light">
                                <tr>
                                    <th width="35%">Jenis Barang</th>
                                    <th width="35%">Nomor Roll Unik</th>
                                    <th width="20%">Berat (Kg)</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-select" name="barang_id[]" required>
                                            <option value="">-- Pilih Barang --</option>
                                            @foreach($barangs as $barang)
                                                <option value="{{ $barang->id }}">{{ $barang->kode_barang }} - {{ $barang->nama_barang }} ({{ $barang->warna }})</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="nomor_roll[]" placeholder="Contoh: R-123456" required>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" class="form-control" name="berat_kg[]" placeholder="0.00" required>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-success btn-tambah-baris"><i class="fas fa-plus"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-top-0 bg-light">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Inbound</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#tableRoll tbody');
    
    document.addEventListener('click', function(e) {
        if(e.target.closest('.btn-tambah-baris')) {
            const row = e.target.closest('tr');
            const newRow = row.cloneNode(true);
            newRow.querySelector('input[name="nomor_roll[]"]').value = '';
            newRow.querySelector('input[name="berat_kg[]"]').value = '';
            
            // Ubah tombol plus menjadi minus
            const btn = newRow.querySelector('.btn-tambah-baris');
            btn.classList.remove('btn-success', 'btn-tambah-baris');
            btn.classList.add('btn-danger', 'btn-hapus-baris');
            btn.innerHTML = '<i class="fas fa-minus"></i>';
            
            tableBody.appendChild(newRow);
        }
        
        if(e.target.closest('.btn-hapus-baris')) {
            e.target.closest('tr').remove();
        }
    });

    @if($errors->any())
        var myModal = new bootstrap.Modal(document.getElementById('modalTambahPenerimaan'));
        myModal.show();
    @endif
});
</script>
@endsection
