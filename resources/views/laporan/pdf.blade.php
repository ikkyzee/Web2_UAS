<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok Barang (Serialized)</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background-color: #f2f2f2; text-align: center; }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .subtitle { font-size: 14px; margin-bottom: 20px; color: #555; }
    </style>
</head>
<body>
    <div class="text-center">
        <div class="title">LAPORAN STOK BARANG (SERIALIZED)</div>
        <div class="subtitle">
            Filter: 
            @if($status == 'di_gudang') Masih di Gudang
            @elseif($status == 'dikirim') Terkirim ke Toko
            @else Semua Data
            @endif
            | Dicetak pada: {{ date('d M Y H:i') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Nomor OC</th>
                <th width="15%">Nomor Roll</th>
                <th width="15%">Kode Barang</th>
                <th width="15%">Jenis / Kategori</th>
                <th width="10%">Warna</th>
                <th width="8%">Kiloan</th>
                <th width="10%">Status</th>
                <th width="10%">Tujuan Toko</th>
            </tr>
        </thead>
        <tbody>
            @php $totalKg = 0; @endphp
            @forelse($barangs as $barang)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $barang->penerimaan->kode_oc ?? '-' }}</td>
                <td class="text-center">{{ $barang->penerimaanRoll->nomor_roll ?? '-' }}</td>
                <td class="text-center"><strong>{{ $barang->kode_barang }}</strong></td>
                <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                <td class="text-center">{{ $barang->warna }}</td>
                <td class="text-end">{{ number_format($barang->penerimaanRoll->kiloan ?? 0, 2) }}</td>
                <td class="text-center">{{ $barang->status == 'di_gudang' ? 'Di Gudang' : 'Dikirim' }}</td>
                <td class="text-center">
                    @if($barang->status === 'dikirim' && $barang->detailPengirimans->count() > 0)
                        {{ $barang->detailPengirimans->last()->pengiriman->toko->nama_toko ?? '-' }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            @php $totalKg += $barang->penerimaanRoll->kiloan ?? 0; @endphp
            @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data untuk laporan ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" class="text-end">Total Kiloan:</th>
                <th class="text-end">{{ number_format($totalKg, 2) }}</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
