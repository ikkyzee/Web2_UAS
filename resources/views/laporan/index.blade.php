@extends('layouts.app')

@section('title', 'Laporan Stok - KT Inventory')
@section('page_heading', 'Laporan Stok Barang (Serialized)')

@section('content')
<div class="space-y-6">
    <!-- Header Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="bg-brand-50 p-2 rounded-lg text-brand-600">
                    <i class="fas fa-file-alt text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Data Laporan Stok</h3>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                @if(auth()->check() && auth()->user()->role !== 'admin_toko')
                <form action="{{ route('laporan.index') }}" method="GET" class="w-full sm:w-auto">
                    <select name="status" class="block w-full sm:w-auto pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm rounded-lg" onchange="this.form.submit()">
                        <option value="">Semua Data</option>
                        <option value="di_gudang" {{ $status == 'di_gudang' ? 'selected' : '' }}>Masih di Gudang</option>
                        <option value="dikirim" {{ $status == 'dikirim' ? 'selected' : '' }}>Terkirim ke Toko</option>
                    </select>
                </form>
                @endif
                
                <div class="flex gap-2 w-full sm:w-auto">
                    <a href="{{ route('laporan.export.pdf', ['status' => $status]) }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-red-50 text-red-700 border border-red-200 rounded-lg font-semibold text-xs uppercase tracking-widest hover:bg-red-100 transition-all shadow-sm">
                        <i class="fas fa-file-pdf mr-2"></i> PDF
                    </a>
                    <a href="{{ route('laporan.export.excel', ['status' => $status]) }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-green-50 text-green-700 border border-green-200 rounded-lg font-semibold text-xs uppercase tracking-widest hover:bg-green-100 transition-all shadow-sm">
                        <i class="fas fa-file-excel mr-2"></i> Excel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor OC</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Roll</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Barang</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis / Kategori</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Warna</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Kiloan</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan Toko</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($barangs as $barang)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $barang->penerimaan->kode_oc ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                            {{ $barang->penerimaanRoll->nomor_roll ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-brand-600">
                            {{ $barang->kode_barang }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $barang->kategori->nama_kategori ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $barang->warna }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-700 text-right">
                            {{ number_format($barang->penerimaanRoll->kiloan ?? 0, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($barang->status === 'di_gudang')
                                <span class="px-2 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-box mr-1"></i> Di Gudang
                                </span>
                            @else
                                <span class="px-2 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <i class="fas fa-truck mr-1"></i> Dikirim
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($barang->status === 'dikirim' && $barang->detailPengirimans->count() > 0)
                                {{ $barang->detailPengirimans->last()->pengiriman->toko->nama_toko ?? '-' }}
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-folder-open text-4xl mb-3 text-gray-300"></i>
                                <p>Tidak ada data untuk laporan ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
