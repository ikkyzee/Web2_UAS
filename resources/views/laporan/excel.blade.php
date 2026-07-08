<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor OC</th>
            <th>Nomor Roll</th>
            <th>Kode Barang</th>
            <th>Jenis / Kategori</th>
            <th>Warna</th>
            <th>Kiloan (Kg)</th>
            <th>Status</th>
            <th>Tujuan Toko</th>
        </tr>
    </thead>
    <tbody>
        @forelse($barangs as $barang)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $barang->penerimaan->kode_oc ?? '-' }}</td>
            <td>{{ $barang->penerimaanRoll->nomor_roll ?? '-' }}</td>
            <td>{{ $barang->kode_barang }}</td>
            <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
            <td>{{ $barang->warna }}</td>
            <td>{{ $barang->penerimaanRoll->kiloan ?? 0 }}</td>
            <td>{{ $barang->status == 'di_gudang' ? 'Di Gudang' : 'Dikirim' }}</td>
            <td>
                @if($barang->status === 'dikirim' && $barang->detailPengirimans->count() > 0)
                    {{ $barang->detailPengirimans->last()->pengiriman->toko->nama_toko ?? '-' }}
                @else
                    -
                @endif
            </td>
        </tr>
        @empty
        @endforelse
    </tbody>
</table>
