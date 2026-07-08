@extends('layouts.app')

@section('title', 'Penerimaan Roll (Staging) - KT Inventory')
@section('page_heading', 'Penerimaan Fisik (Staging OC)')

@section('content')
<div x-data="{ showModal: {{ $errors->any() ? 'true' : 'false' }} }" class="space-y-6">
    <!-- Header Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <h3 class="text-lg font-bold text-gray-800">Penerimaan Barang Fisik</h3>
                <button @click="showModal = true" class="inline-flex items-center justify-center px-4 py-2 bg-brand-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-all shadow-sm">
                    <i class="fas fa-plus mr-2"></i> Tambah Inbound OC
                </button>
            </div>
            
            <form action="{{ route('penerimaans.index') }}" method="GET" class="w-full sm:w-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ $search ?? '' }}" class="block w-full sm:w-80 pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-brand-500 focus:border-brand-500 sm:text-sm" placeholder="Cari OC atau supplier...">
                </div>
            </form>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-16">Detail</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor OC</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Masuk</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Roll</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total (Kg)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($penerimaans as $p)
                    <tbody x-data="{ expanded: false }" class="bg-white divide-y divide-gray-200 hover:bg-gray-50 transition-colors duration-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <button @click="expanded = !expanded" class="text-brand-600 hover:text-brand-900 focus:outline-none transition-transform duration-300 transform" :class="{'rotate-180': expanded}">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $loop->iteration + $penerimaans->firstItem() - 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-brand-600">
                                {{ $p->kode_oc }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($p->tanggal_masuk)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $p->supplier->nama_supplier ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $p->penerimaanRolls->count() }} Roll
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ number_format($p->penerimaanRolls->sum('kiloan'), 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $total = $p->penerimaanRolls->count();
                                    $cataloged = $p->penerimaanRolls->where('is_cataloged', true)->count();
                                @endphp
                                @if($total == 0)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Kosong</span>
                                @elseif($cataloged == $total)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Terkatalog</span>
                                @elseif($cataloged > 0)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Sebagian</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Belum</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <form action="{{ route('penerimaans.destroy', $p->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus OC ini? Semua roll dan barang terkait juga akan terhapus!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        
                        <!-- Expandable Child Row -->
                        <tr x-show="expanded" x-collapse x-cloak>
                            <td colspan="9" class="p-0 bg-gray-50 border-t border-gray-100">
                                <div class="p-6">
                                    <h6 class="text-sm font-bold text-gray-700 mb-4 flex items-center">
                                        <i class="fas fa-boxes text-gray-400 mr-2"></i> Rincian Roll Fisik ({{ $p->kode_oc }})
                                    </h6>
                                    
                                    @if($p->penerimaanRolls->count() > 0)
                                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-100">
                                                    <tr>
                                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase w-16">No</th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor Roll Fisik</th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kiloan (Kg)</th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Katalog</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200">
                                                    @foreach($p->penerimaanRolls as $roll)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-4 py-3 text-sm text-gray-500 text-center">{{ $loop->iteration }}</td>
                                                        <td class="px-4 py-3 text-sm font-bold text-gray-900">{{ $roll->nomor_roll }}</td>
                                                        <td class="px-4 py-3 text-sm text-gray-900">{{ number_format($roll->kiloan, 2) }}</td>
                                                        <td class="px-4 py-3 text-sm">
                                                            @if($roll->is_cataloged)
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                                    <i class="fas fa-check-circle mr-1"></i> Terdaftar
                                                                </span>
                                                            @else
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                    <i class="fas fa-clock mr-1"></i> Menunggu
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="rounded-md bg-blue-50 p-4 border border-blue-100">
                                            <div class="flex">
                                                <div class="flex-shrink-0"><i class="fas fa-info-circle text-blue-400"></i></div>
                                                <div class="ml-3"><p class="text-sm text-blue-700">Belum ada roll terdaftar untuk OC ini.</p></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-box-open text-4xl mb-3 text-gray-300"></i>
                                <p>Belum ada data penerimaan fisik barang.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($penerimaans->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $penerimaans->links('pagination::tailwind') }}
        </div>
        @endif
    </div>

    <!-- Modal Tambah (Alpine.js) -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-xl text-left shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full">
                
                <form action="{{ route('penerimaans.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 rounded-t-xl">
                        <div class="flex justify-between items-center border-b pb-3 mb-4">
                            <h3 class="text-xl font-bold text-gray-900">Tambah Data Penerimaan (Staging)</h3>
                            <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-500">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                        
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-md">
                            <div class="flex">
                                <div class="flex-shrink-0"><i class="fas fa-info-circle text-blue-500"></i></div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Petugas mencatat fisik barang yang masuk (Fase Staging). Nama Barang, Jenis, dan Warna akan didaftarkan per-Roll secara terpisah di menu Master Barang.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor OC <span class="text-red-500">*</span></label>
                                <input type="text" name="kode_oc" required placeholder="Contoh: OC-001" value="{{ old('kode_oc') }}" 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 uppercase {{ $errors->has('kode_oc') ? 'border-red-500' : '' }}">
                                @error('kode_oc') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Masuk <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_masuk" required value="{{ old('tanggal_masuk', date('Y-m-d')) }}" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Supplier <span class="text-red-500">*</span></label>
                                <select name="supplier_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                                    <option value="">-- Pilih Supplier --</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Barang (Kategori) <span class="text-red-500">*</span></label>
                                <select name="kategori_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Warna <span class="text-red-500">*</span></label>
                                <input type="text" name="warna" required placeholder="Contoh: Merah Hati" value="{{ old('warna') }}" 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500">
                            </div>
                        </div>

                        <!-- Repeater Alpine -->
                        <div x-data="{
                            rolls: [{ nomor_roll: '', kiloan: '' }],
                            addRoll() {
                                this.rolls.push({ nomor_roll: '', kiloan: '' });
                            },
                            removeRoll(index) {
                                if (this.rolls.length > 1) {
                                    this.rolls.splice(index, 1);
                                }
                            }
                        }">
                            <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-4">
                                <h6 class="text-base font-bold text-gray-900">Detail Roll Fisik</h6>
                                <button type="button" @click="addRoll" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                                    <i class="fas fa-plus mr-1"></i> Tambah Roll
                                </button>
                            </div>
                            
                            <div class="space-y-3">
                                <template x-for="(roll, index) in rolls" :key="index">
                                    <div class="flex items-center gap-4 bg-gray-50 p-3 rounded-lg border border-gray-200">
                                        <div class="flex-1">
                                            <label class="block text-xs font-medium text-gray-500 mb-1" x-show="index === 0">Nomor Roll Unik</label>
                                            <input type="text" name="nomor_roll[]" x-model="roll.nomor_roll" placeholder="Contoh: R-123456" required class="block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-xs font-medium text-gray-500 mb-1" x-show="index === 0">Kiloan (Kg)</label>
                                            <input type="number" step="0.01" name="kiloan[]" x-model="roll.kiloan" placeholder="0.00" required class="block w-full border-gray-300 rounded-md shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                                        </div>
                                        <div class="pt-1 flex items-end">
                                            <label class="block text-xs text-transparent mb-1" x-show="index === 0">Aksi</label>
                                            <button type="button" @click="removeRoll(index)" x-show="rolls.length > 1" class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-row-reverse border-t border-gray-200 rounded-b-xl gap-3">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-brand-600 text-base font-medium text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 sm:w-auto sm:text-sm transition-colors">
                            <i class="fas fa-save mr-2 mt-0.5"></i> Simpan Inbound Staging
                        </button>
                        <button type="button" @click="showModal = false" class="w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 sm:w-auto sm:text-sm transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
