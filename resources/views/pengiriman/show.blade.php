@extends('layouts.app')

@section('title', 'Detail Surat Jalan - KT Inventory')
@section('page_heading', 'Detail Surat Jalan')

@section('content')
<div class="flex flex-col md:flex-row gap-6">
    <div class="w-full md:w-3/4">
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden mb-6">
            <div class="p-8 print:p-0">
                <!-- Header Surat Jalan -->
                <div class="flex flex-col sm:flex-row justify-between border-b border-gray-200 pb-6 mb-6">
                    <div>
                        <h3 class="text-2xl font-black text-brand-700 mb-1 tracking-tight">PT KARUNIA TEXTILE</h3>
                        <p class="text-gray-500 text-sm font-medium">Warehouse Inventory & Distribution</p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:text-right">
                        <h4 class="text-xl font-bold text-gray-800 mb-1">SURAT JALAN</h4>
                        <p class="text-sm text-gray-600 mb-1"><span class="font-bold text-gray-700">No:</span> SJ-{{ date('Ymd', strtotime($pengiriman->tanggal_kirim)) }}-{{ str_pad($pengiriman->id, 4, '0', STR_PAD_LEFT) }}</p>
                        <p class="text-sm text-gray-600"><span class="font-bold text-gray-700">Tanggal:</span> {{ \Carbon\Carbon::parse($pengiriman->tanggal_kirim)->format('d F Y') }}</p>
                    </div>
                </div>

                <!-- Info Tujuan -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-8">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <h6 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tujuan Pengiriman:</h6>
                        <h5 class="text-lg font-bold text-gray-900 mb-1">{{ $pengiriman->toko->nama_toko }}</h5>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $pengiriman->toko->alamat_toko }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <h6 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Informasi Armada:</h6>
                        <p class="text-sm text-gray-600 mb-1"><span class="font-bold text-gray-700">Supir:</span> {{ $pengiriman->armada->nama_supir }}</p>
                        <p class="text-sm text-gray-600 mb-1"><span class="font-bold text-gray-700">Kendaraan:</span> {{ $pengiriman->armada->jenis_kendaraan }}</p>
                        <p class="text-sm text-gray-600"><span class="font-bold text-gray-700">Plat Nomor:</span> <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-gray-200 text-gray-800 border border-gray-300">{{ $pengiriman->armada->plat_nomor }}</span></p>
                    </div>
                </div>

                <!-- Detail Barang -->
                <div class="border border-gray-200 rounded-lg overflow-hidden mb-8">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider w-12">No</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Kode Barang</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Nomor Roll</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Barang</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Warna</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Berat (Kg)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php $totalKg = 0; @endphp
                            @foreach($pengiriman->detailPengirimans as $detail)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-500 text-center">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-sm font-bold text-brand-600 text-center">{{ $detail->barang->kode_barang }}</td>
                                <td class="px-4 py-3 text-sm font-bold text-gray-900 text-center">{{ $detail->barang->penerimaanRoll->nomor_roll ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->barang->kategori->nama_kategori ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500 text-center">{{ $detail->barang->warna }}</td>
                                <td class="px-4 py-3 text-sm font-bold text-gray-700 text-right">{{ number_format($detail->barang->penerimaanRoll->kiloan ?? 0, 2) }}</td>
                            </tr>
                            @php $totalKg += $detail->barang->penerimaanRoll->kiloan ?? 0; @endphp
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-sm font-bold text-gray-900 text-right">
                                    TOTAL KESELURUHAN ({{ count($pengiriman->detailPengirimans) }} Roll)
                                </td>
                                <td class="px-4 py-3 text-sm font-black text-brand-700 text-right">
                                    {{ number_format($totalKg, 2) }} Kg
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- TTD -->
                <div class="grid grid-cols-3 gap-4 text-center mt-12 mb-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-16">Dibuat Oleh,</p>
                        <p class="font-bold text-gray-900 border-b border-gray-300 inline-block px-4 pb-1">({{ $pengiriman->user->name }})</p>
                        <p class="text-xs text-gray-500 mt-1">Petugas Gudang</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-16">Supir Pengirim,</p>
                        <p class="font-bold text-gray-900 border-b border-gray-300 inline-block px-4 pb-1">({{ $pengiriman->armada->nama_supir }})</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-16">Diterima Oleh,</p>
                        <p class="font-bold text-gray-900 border-b border-gray-300 inline-block px-4 pb-1">(.......................)</p>
                        <p class="text-xs text-gray-500 mt-1">Admin Toko</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4 print:hidden">
                <a href="{{ route('pengirimans.index') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <div class="flex gap-2 w-full sm:w-auto">
                    <button onclick="window.print()" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 shadow-sm transition-colors text-sm font-medium">
                        <i class="fas fa-print mr-2"></i> Print
                    </button>
                    <!-- Form Update Status -->
                    <form action="{{ route('pengirimans.update', $pengiriman->id) }}" method="POST" class="inline-block w-full sm:w-auto">
                        @csrf
                        @method('PUT')
                        @if($pengiriman->status === 'diproses')
                            <input type="hidden" name="status" value="dikirim">
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 shadow-sm transition-colors text-sm font-medium">
                                <i class="fas fa-truck mr-2"></i> Tandai Sedang Dikirim
                            </button>
                        @elseif($pengiriman->status === 'dikirim')
                            <input type="hidden" name="status" value="diterima">
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 shadow-sm transition-colors text-sm font-medium" onclick="return confirm('Konfirmasi bahwa barang telah diterima di toko?');">
                                <i class="fas fa-check mr-2"></i> Konfirmasi Diterima
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="w-full md:w-1/4 print:hidden">
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden sticky top-6">
            <div class="p-5">
                <h6 class="text-sm font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 pb-3 mb-4">Status Pengiriman</h6>
                
                @if($pengiriman->status === 'diproses')
                    <div class="rounded-lg bg-gray-50 p-4 border border-gray-200 flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-box text-gray-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-gray-800">Sedang Diproses Gudang</h3>
                            <p class="text-xs text-gray-500 mt-1">Surat jalan telah dicetak dan barang sedang disiapkan.</p>
                        </div>
                    </div>
                @elseif($pengiriman->status === 'dikirim')
                    <div class="rounded-lg bg-yellow-50 p-4 border border-yellow-200 flex items-start animate-pulse">
                        <div class="flex-shrink-0">
                            <i class="fas fa-truck text-yellow-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-yellow-800">Dalam Perjalanan</h3>
                            <p class="text-xs text-yellow-600 mt-1">Barang sedang dikirim menuju toko tujuan.</p>
                        </div>
                    </div>
                @else
                    <div class="rounded-lg bg-green-50 p-4 border border-green-200 flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                        <div class="ml-3 w-full">
                            <h3 class="text-sm font-bold text-green-800">Telah Diterima</h3>
                            <p class="text-xs text-green-600 mt-1">Barang telah sampai tujuan.</p>
                            <div class="mt-3 pt-3 border-t border-green-200 w-full">
                                <p class="text-xs font-medium text-green-800">
                                    <i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($pengiriman->tanggal_diterima)->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .max-w-6xl, .max-w-6xl * {
            visibility: visible;
        }
        .max-w-6xl {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .shadow-sm { box-shadow: none !important; }
        .border-gray-100 { border-color: #e5e7eb !important; }
    }
</style>
@endsection
