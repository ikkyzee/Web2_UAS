@extends('layouts.app')

@section('title', 'Katalog Barang - KT Inventory')
@section('page_heading', 'Katalog Resmi Barang (1 Barang = 1 Roll)')

@section('content')
<div class="space-y-6">
    <!-- Header Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <h3 class="text-lg font-bold text-gray-800">Daftar Barang</h3>
                @if(auth()->user() && in_array(auth()->user()->role, ['admin', 'admin_pusat']))
                <a href="{{ route('barangs.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-brand-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-all shadow-sm">
                    <i class="fas fa-plus mr-2"></i> Daftarkan Barang
                </a>
                @endif
            </div>
            
            <form action="{{ route('barangs.index') }}" method="GET" class="w-full sm:w-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ $search ?? '' }}" class="block w-full sm:w-80 pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-brand-500 focus:border-brand-500 sm:text-sm" placeholder="Cari kode/OC/jenis...">
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor OC</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Roll</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Barang</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis / Kategori</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Warna</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kiloan (Kg)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        @if(auth()->user() && in_array(auth()->user()->role, ['admin', 'admin_pusat']))
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($barangs as $barang)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $loop->iteration + $barangs->firstItem() - 1 }}
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-700">
                            {{ number_format($barang->penerimaanRoll->kiloan ?? 0, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
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
                        @if(auth()->user() && in_array(auth()->user()->role, ['admin', 'admin_pusat']))
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            @if($barang->status === 'di_gudang')
                            <a href="{{ route('barangs.edit', $barang->id) }}" class="text-amber-600 hover:text-amber-900 bg-amber-50 hover:bg-amber-100 px-3 py-1.5 rounded-md transition-colors inline-block mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('barangs.destroy', $barang->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin mencabut barang ini dari katalog? (Fisik Roll akan kembali ke status belum ter-katalog)');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @else
                            <button disabled class="text-gray-400 bg-gray-100 px-3 py-1.5 rounded-md cursor-not-allowed">
                                <i class="fas fa-ban"></i>
                            </button>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-box-open text-4xl mb-3 text-gray-300"></i>
                                <p>Belum ada barang di katalog resmi.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($barangs->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $barangs->links('pagination::tailwind') }}
        </div>
        @endif
    </div>
</div>
@endsection
