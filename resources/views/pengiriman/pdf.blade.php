<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengiriman</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; margin: 0; }
        .subtitle { font-size: 14px; margin: 5px 0 0 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
        .text-center { text-align: center; }
        .badge { padding: 3px 6px; border-radius: 3px; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <p class="title">PT KARUNIA TEXTILE</p>
        <p class="subtitle">Laporan Rekapitulasi Pengiriman Barang</p>
        <p style="margin-top:5px; font-size:10px;">Dicetak pada: {{ now()->format('d M Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th width="20%">Toko Tujuan</th>
                <th width="15%">Armada</th>
                <th width="12%">Status</th>
                <th width="36%">Detail Barang (Nama - Jumlah Kg)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengirimans as $pengiriman)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($pengiriman->tanggal_kirim)->format('d/m/Y') }}</td>
                <td>{{ $pengiriman->toko->nama_toko ?? '-' }}</td>
                <td>{{ $pengiriman->armada->plat_nomor ?? '-' }}</td>
                <td class="text-center">{{ ucfirst($pengiriman->status) }}</td>
                <td>
                    <ul style="margin:0; padding-left:15px;">
                        @foreach($pengiriman->detailPengirimans as $detail)
                            <li>{{ $detail->roll->nomor_roll }} - {{ $detail->roll->barang->nama_barang }} ({{ $detail->roll->berat_kg }} Kg)</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data pengiriman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
