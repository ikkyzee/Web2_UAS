@extends('layouts.app')

@section('title', isset($barang) ? 'Edit Master Barang' : 'Tambah Master Barang (Cataloging)')
@section('page_heading', isset($barang) ? 'Edit Master Barang' : 'Pendaftaran Master Barang (Cataloging)')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6">
            <form action="{{ isset($barang) ? route('barangs.update', $barang->id) : route('barangs.store') }}" method="POST">
                @csrf
                @if(isset($barang)) @method('PUT') @endif
                
                @if(!isset($barang))
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-md">
                    <div class="flex">
                        <div class="flex-shrink-0"><i class="fas fa-info-circle text-blue-500 mt-0.5"></i></div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Fase Cataloging (1 Barang = 1 Roll):</strong> Pilih Nomor OC, lalu pilih fisik Roll yang belum diregistrasi, lengkapi datanya untuk masuk ke katalog resmi.
                            </p>
                        </div>
                    </div>
                </div>

                <div x-data="{
                        ocId: '{{ old('penerimaan_id') }}',
                        rollId: '{{ old('penerimaan_roll_id') }}',
                        rolls: [],
                        loading: false,
                        selectedKiloan: 0,
                        selectedKategori: '{{ old('kategori_id') }}',
                        selectedWarna: '{{ old('warna') }}',
                        
                        fetchRolls() {
                            if (!this.ocId) {
                                this.rolls = [];
                                this.rollId = '';
                                this.selectedKiloan = 0;
                                this.selectedKategori = '';
                                this.selectedWarna = '';
                                return;
                            }
                            this.loading = true;
                            fetch(`/api/oc-rolls/${this.ocId}`)
                                .then(res => res.json())
                                .then(data => {
                                    this.rolls = data.rolls;
                                    if(data.kategori_id) this.selectedKategori = data.kategori_id;
                                    if(data.warna) this.selectedWarna = data.warna;
                                    
                                    // Reset selected roll if it doesn't exist in new batch
                                    if(!this.rolls.find(r => r.id == this.rollId)) {
                                        this.rollId = '';
                                        this.selectedKiloan = 0;
                                    } else {
                                        this.updateKiloan();
                                    }
                                    this.loading = false;
                                });
                        },
                        
                        updateKiloan() {
                            let selected = this.rolls.find(r => r.id == this.rollId);
                            this.selectedKiloan = selected ? selected.kiloan : 0;
                        }
                    }" x-init="if(ocId) fetchRolls()" class="space-y-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-brand-600 mb-1">Pilih Nomor OC (Staging) <span class="text-red-500">*</span></label>
                            <select name="penerimaan_id" x-model="ocId" @change="fetchRolls" required class="block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm {{ $errors->has('penerimaan_id') ? 'border-red-500' : '' }}">
                                <option value="">-- Pilih OC --</option>
                                @foreach($ocs as $oc)
                                    <option value="{{ $oc->id }}">OC: {{ $oc->kode_oc }} | Tgl: {{ \Carbon\Carbon::parse($oc->tanggal_masuk)->format('d/m/Y') }}</option>
                                @endforeach
                            </select>
                            @error('penerimaan_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Fisik Roll Terkait <span class="text-red-500">*</span></label>
                            <select name="penerimaan_roll_id" x-model="rollId" @change="updateKiloan" :disabled="!ocId || loading" required class="block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed {{ $errors->has('penerimaan_roll_id') ? 'border-red-500' : '' }}">
                                <option value="" x-text="loading ? '-- Loading... --' : (!ocId ? '-- Pilih OC Terlebih Dahulu --' : (rolls.length === 0 ? '-- Tidak ada roll tersisa --' : '-- Pilih Roll --'))"></option>
                                <template x-for="roll in rolls" :key="roll.id">
                                    <option :value="roll.id" x-text="'Roll: ' + roll.nomor_roll + ' (' + parseFloat(roll.kiloan).toFixed(2) + ' Kg)'"></option>
                                </template>
                            </select>
                            @error('penerimaan_roll_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="border-t border-gray-200 mt-6 pt-6">
                        <h5 class="text-base font-bold text-gray-900 mb-4">Informasi Katalog Resmi</h5>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Barang Resmi <span class="text-red-500">*</span></label>
                                <input type="text" name="kode_barang" value="{{ old('kode_barang') }}" required placeholder="Contoh: BRG-001" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm {{ $errors->has('kode_barang') ? 'border-red-500' : '' }}">
                                @error('kode_barang') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis / Kategori <span class="text-red-500">*</span></label>
                                <select name="kategori_id" x-model="selectedKategori" required class="block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm bg-gray-50 pointer-events-none text-gray-600 {{ $errors->has('kategori_id') ? 'border-red-500' : '' }}" tabindex="-1">
                                    <option value="">-- Otomatis terisi dari OC --</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Warna <span class="text-red-500">*</span></label>
                                <input type="text" name="warna" x-model="selectedWarna" required readonly placeholder="Otomatis terisi dari OC" class="block w-full border-gray-300 rounded-md shadow-sm bg-gray-50 text-gray-600 focus:border-brand-500 focus:ring-brand-500 sm:text-sm {{ $errors->has('warna') ? 'border-red-500' : '' }}">
                                @error('warna') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-6 w-full sm:w-1/3">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Kiloan Fisik (Otomatis)</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" x-model="selectedKiloan" readonly class="bg-gray-50 flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-l-md border border-gray-300 sm:text-sm text-gray-500 cursor-not-allowed">
                                <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-100 text-gray-500 sm:text-sm">Kg</span>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-gray-50 border-l-4 border-gray-400 p-4 mb-6 rounded-r-md">
                    <h3 class="text-gray-700">
                        <i class="fas fa-edit mr-2 text-amber-500"></i> 
                        Edit Barang untuk Roll: <strong>{{ $barang->penerimaanRoll->nomor_roll }}</strong> (OC: {{ $barang->penerimaan->kode_oc }})
                    </h3>
                </div>

                <div class="space-y-6">
                    <h5 class="text-base font-bold text-gray-900 mb-4 border-b pb-2">Informasi Katalog Resmi</h5>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Barang Resmi <span class="text-red-500">*</span></label>
                            <input type="text" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" required placeholder="Contoh: BRG-001" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                            @error('kode_barang') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis / Kategori <span class="text-red-500">*</span></label>
                            <select name="kategori_id" required class="block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ (old('kategori_id', $barang->kategori_id) == $kategori->id) ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Warna <span class="text-red-500">*</span></label>
                            <input type="text" name="warna" value="{{ old('warna', $barang->warna) }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                            @error('warna') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-6 w-full sm:w-1/3">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Kiloan Fisik (Otomatis)</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" value="{{ $barang->penerimaanRoll->kiloan }}" readonly class="bg-gray-50 flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-l-md border border-gray-300 sm:text-sm text-gray-500 cursor-not-allowed">
                            <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-100 text-gray-500 sm:text-sm">Kg</span>
                        </div>
                    </div>
                </div>
                @endif

                <div class="mt-8 flex justify-end gap-3 pt-5 border-t border-gray-100">
                    <a href="{{ route('barangs.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2 mt-1"></i> Kembali
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-brand-600 hover:bg-brand-700 transition-colors">
                        <i class="fas fa-save mr-2 mt-1"></i> {{ isset($barang) ? 'Simpan Perubahan' : 'Daftarkan ke Katalog' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
