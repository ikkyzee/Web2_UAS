@extends('layouts.app')

@section('title', 'Buat Pengiriman - KT Inventory')
@section('page_heading', 'Buat Pengiriman Baru')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('pengirimans.store') }}" method="POST">
                    @csrf
                    
                    <h5 class="border-bottom pb-2 mb-4 text-primary">Informasi Pengiriman</h5>
                    
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

                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                        <h5 class="text-primary mb-0">Pilih Roll Barang (Outbound)</h5>
                        <div class="input-group w-25">
                            <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Cari kode/nomor roll...">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                    </div>

                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover align-middle table-sm" id="rollTable">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th width="5%" class="text-center">
                                        <input class="form-check-input" type="checkbox" id="checkAll">
                                    </th>
                                    <th width="20%">Nomor Roll</th>
                                    <th width="30%">Nama Barang</th>
                                    <th width="15%">Kategori</th>
                                    <th width="15%">Warna/Ukuran</th>
                                    <th width="15%">Berat (Kg)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rolls as $roll)
                                <tr>
                                    <td class="text-center">
                                        <input class="form-check-input roll-checkbox" type="checkbox" name="roll_id[]" value="{{ $roll->id }}">
                                    </td>
                                    <td class="fw-bold text-primary">{{ $roll->nomor_roll }}</td>
                                    <td>{{ $roll->barang->kode_barang }} - {{ $roll->barang->nama_barang }}</td>
                                    <td>{{ $roll->barang->kategori->nama_kategori ?? '-' }}</td>
                                    <td>{{ $roll->barang->warna }} / {{ $roll->barang->ukuran }}</td>
                                    <td>{{ number_format($roll->berat_kg, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">Tidak ada roll barang yang tersedia di gudang.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2 text-muted small">
                        Total dipilih: <span id="selectedCount" class="fw-bold">0</span> roll
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('pengirimans.index') }}" class="btn btn-light border"><i class="fas fa-arrow-left me-1"></i> Batal</a>
                        <button type="submit" class="btn btn-primary" id="btnSubmit" disabled><i class="fas fa-paper-plane me-1"></i> Proses Pengiriman</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const checkAll = document.getElementById('checkAll');
        const checkboxes = document.querySelectorAll('.roll-checkbox');
        const selectedCount = document.getElementById('selectedCount');
        const btnSubmit = document.getElementById('btnSubmit');

        // Live Search
        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#rollTable tbody tr');
            
            rows.forEach(row => {
                if(row.children.length > 1) { // Abaikan row empty state
                    const text = row.textContent.toLowerCase();
                    if(text.includes(filter)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });

        // Check/Uncheck All (Hanya yang terlihat)
        checkAll.addEventListener('change', function() {
            const isChecked = this.checked;
            const rows = document.querySelectorAll('#rollTable tbody tr');
            
            rows.forEach(row => {
                if(row.style.display !== 'none' && row.children.length > 1) {
                    const cb = row.querySelector('.roll-checkbox');
                    if(cb) cb.checked = isChecked;
                }
            });
            updateCount();
        });

        // Update Count on individual checkbox change
        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateCount);
        });

        function updateCount() {
            const checkedCount = document.querySelectorAll('.roll-checkbox:checked').length;
            selectedCount.textContent = checkedCount;
            btnSubmit.disabled = checkedCount === 0;
            
            // Update checkAll status
            const visibleCheckboxes = Array.from(document.querySelectorAll('#rollTable tbody tr')).filter(row => row.style.display !== 'none' && row.children.length > 1).map(row => row.querySelector('.roll-checkbox'));
            const allVisibleChecked = visibleCheckboxes.length > 0 && visibleCheckboxes.every(cb => cb.checked);
            const someVisibleChecked = visibleCheckboxes.some(cb => cb.checked);
            
            checkAll.checked = allVisibleChecked;
            checkAll.indeterminate = someVisibleChecked && !allVisibleChecked;
        }
    });
</script>
@endpush
@endsection
