@extends('layouts.app')

@section('title', 'Buat Pengiriman - KT Inventory')
@section('page_heading', 'Buat Pengiriman Baru (Outbound)')

@section('content')
<div class="max-w-6xl">
    <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
        <form action="{{ route('pengirimans.store') }}" method="POST">
            @csrf
            
            <div class="p-6">
                <div class="bg-amber-50 border-l-4 border-amber-500 p-4 mb-8 rounded-r-md">
                    <div class="flex">
                        <div class="flex-shrink-0"><i class="fas fa-truck text-amber-500 mt-0.5"></i></div>
                        <div class="ml-3">
                            <p class="text-sm text-amber-800">
                                <strong>Fase Outbound:</strong> Pilih barang (yang mewakili 1 Roll fisik) yang akan dikirim secara spesifik dari katalog.
                            </p>
                        </div>
                    </div>
                </div>

                <h5 class="text-base font-bold text-gray-900 mb-4 border-b pb-2">Informasi Pengiriman</h5>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kirim <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_kirim" value="{{ old('tanggal_kirim', date('Y-m-d')) }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm {{ $errors->has('tanggal_kirim') ? 'border-red-500' : '' }}">
                        @error('tanggal_kirim') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Toko Tujuan <span class="text-red-500">*</span></label>
                        <select name="toko_id" required class="block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm {{ $errors->has('toko_id') ? 'border-red-500' : '' }}">
                            <option value="">-- Pilih Toko --</option>
                            @foreach($tokos as $toko)
                                <option value="{{ $toko->id }}">{{ $toko->nama_toko }} ({{ str()->limit($toko->alamat_toko, 30) }})</option>
                            @endforeach
                        </select>
                        @error('toko_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Armada Kendaraan <span class="text-red-500">*</span></label>
                        <select name="armada_id" required class="block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm {{ $errors->has('armada_id') ? 'border-red-500' : '' }}">
                            <option value="">-- Pilih Armada --</option>
                            @foreach($armadas as $armada)
                                <option value="{{ $armada->id }}">{{ $armada->plat_nomor }} - {{ $armada->jenis_kendaraan }} ({{ $armada->nama_supir }})</option>
                            @endforeach
                        </select>
                        @error('armada_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div x-data="pengirimanForm()">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-200 pb-3 mb-4 gap-4">
                        <h5 class="text-base font-bold text-brand-600 mb-0">Pilih Barang (Checkbox)</h5>
                        <div class="relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" x-model="searchQuery" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Cari kode/nomor roll...">
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6">
                        <div class="overflow-x-auto max-h-[400px] overflow-y-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50 sticky top-0 z-10 shadow-sm">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-16">
                                            <input type="checkbox" x-model="selectAll" @change="toggleAll" class="h-4 w-4 text-brand-600 focus:ring-brand-500 border-gray-300 rounded cursor-pointer">
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Barang</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Roll</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Batch</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis / Kategori</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Warna</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kiloan (Kg)</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <template x-for="item in filteredItems" :key="item.id">
                                        <tr class="hover:bg-brand-50 cursor-pointer transition-colors" @click="toggleItem(item.id)">
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <input type="checkbox" name="barang_id[]" :value="item.id" x-model="selectedItems" @click.stop class="h-4 w-4 text-brand-600 focus:ring-brand-500 border-gray-300 rounded cursor-pointer">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-brand-600" x-text="item.kode_barang"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900" x-text="item.nomor_roll"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="item.kode_oc"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="item.kategori"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="item.warna"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-700" x-text="item.kiloan"></td>
                                        </tr>
                                    </template>
                                    <tr x-show="filteredItems.length === 0">
                                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                            <p x-text="items.length === 0 ? 'Tidak ada barang yang terdaftar di katalog dan tersedia di gudang.' : 'Tidak ada barang yang cocok dengan pencarian.'"></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="text-sm text-gray-600">
                            Total Barang Dipilih: <span class="font-bold text-lg text-brand-600 ml-1" x-text="selectedItems.length"></span> barang
                        </div>
                        <div class="flex gap-3 w-full sm:w-auto">
                            <a href="{{ route('pengirimans.index') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i> Batal
                            </a>
                            <button type="submit" :disabled="selectedItems.length === 0" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-brand-600 hover:bg-brand-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                <i class="fas fa-paper-plane mr-2"></i> Proses Pengiriman
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('pengirimanForm', () => ({
            searchQuery: '',
            selectAll: false,
            selectedItems: [],
            items: [
                @foreach($barangs as $barang)
                {
                    id: '{{ $barang->id }}',
                    kode_barang: '{{ $barang->kode_barang }}',
                    nomor_roll: '{{ $barang->penerimaanRoll->nomor_roll ?? '-' }}',
                    kode_oc: '{{ $barang->penerimaan->kode_oc ?? '-' }}',
                    kategori: '{{ $barang->kategori->nama_kategori ?? '-' }}',
                    warna: '{{ $barang->warna }}',
                    kiloan: '{{ number_format($barang->penerimaanRoll->kiloan ?? 0, 2) }}',
                    searchString: '{{ strtolower($barang->kode_barang . ' ' . ($barang->penerimaanRoll->nomor_roll ?? '') . ' ' . ($barang->penerimaan->kode_oc ?? '')) }}'
                },
                @endforeach
            ],
            
            get filteredItems() {
                if (this.searchQuery === '') {
                    return this.items;
                }
                const query = this.searchQuery.toLowerCase();
                return this.items.filter(item => item.searchString.includes(query));
            },
            
            toggleAll() {
                if (this.selectAll) {
                    this.selectedItems = this.filteredItems.map(item => item.id);
                } else {
                    this.selectedItems = [];
                }
            },
            
            toggleItem(id) {
                const index = this.selectedItems.indexOf(id);
                if (index > -1) {
                    this.selectedItems.splice(index, 1);
                } else {
                    this.selectedItems.push(id);
                }
            },
            
            init() {
                this.$watch('selectedItems', value => {
                    this.selectAll = this.filteredItems.length > 0 && value.length === this.filteredItems.length;
                });
                
                this.$watch('searchQuery', () => {
                    this.selectAll = false;
                    // Optionally clear selection on search, or keep it. Keeping it is better UX.
                });
            }
        }))
    })
</script>
@endpush
@endsection
