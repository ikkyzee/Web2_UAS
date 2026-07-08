<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Toko;
use App\Models\Armada;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Penerimaan;
use App\Models\PenerimaanRoll;
use App\Models\Barang;
use App\Models\Pengiriman;
use App\Models\DetailPengiriman;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Toko
        $toko1 = Toko::create([
            'nama_toko' => 'Toko Pusat Tanah Abang',
            'alamat_toko' => 'Blok A Lt. 1 Los B No. 45, Jakarta Pusat'
        ]);

        $toko2 = Toko::create([
            'nama_toko' => 'Toko Cabang Cipadu',
            'alamat_toko' => 'Kawasan Tekstil Cipadu, Tangerang'
        ]);

        // 2. Data Users
        User::create([
            'name' => 'Administrator Gudang',
            'email' => 'admin@karuniatex.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas Lapangan',
            'email' => 'admin_pusat@karuniatex.com',
            'password' => Hash::make('password'),
            'role' => 'admin_pusat',
        ]);

        User::create([
            'name' => 'Admin Toko Tanah Abang',
            'email' => 'toko1@karuniatex.com',
            'password' => Hash::make('password'),
            'role' => 'admin_toko',
            'toko_id' => $toko1->id
        ]);

        // 3. Data Armada
        $armada1 = Armada::create([
            'plat_nomor' => 'B 1234 CD',
            'jenis_kendaraan' => 'Truk Engkel',
            'nama_supir' => 'Budi Santoso'
        ]);
        
        $armada2 = Armada::create([
            'plat_nomor' => 'B 5678 EF',
            'jenis_kendaraan' => 'Mobil Box',
            'nama_supir' => 'Ahmad'
        ]);

        // 4. Data Supplier
        $supplier1 = Supplier::create([
            'nama_supplier' => 'PT Makmur Jaya Tekstil',
            'kontak_person' => 'Pak Andi',
            'no_telepon' => '081234567890',
            'alamat' => 'Kawasan Industri Majalaya, Bandung'
        ]);

        // 5. Data Kategori (Jenis)
        $kat1 = Kategori::create([
            'nama_kategori' => 'Cotton Combed 30s',
            'deskripsi' => 'Bahan katun standar distro'
        ]);
        
        $kat2 = Kategori::create([
            'nama_kategori' => 'Fleece PE',
            'deskripsi' => 'Bahan jaket standar'
        ]);

        // 6. Data Penerimaan (Staging Inbound) - OC-001
        $penerimaan1 = Penerimaan::create([
            'supplier_id' => $supplier1->id,
            'tanggal_masuk' => '2026-07-01',
            'kode_oc' => 'OC-001',
            'kategori_id' => $kat1->id,
            'warna' => 'Merah Cabe'
        ]);

        // 7. Data Rolls Fisik untuk OC-001
        $roll1 = PenerimaanRoll::create(['penerimaan_id' => $penerimaan1->id, 'nomor_roll' => 'R-001-A', 'kiloan' => 25.40, 'is_cataloged' => true]);
        $roll2 = PenerimaanRoll::create(['penerimaan_id' => $penerimaan1->id, 'nomor_roll' => 'R-001-B', 'kiloan' => 25.10, 'is_cataloged' => true]);
        $roll3 = PenerimaanRoll::create(['penerimaan_id' => $penerimaan1->id, 'nomor_roll' => 'R-001-C', 'kiloan' => 24.90, 'is_cataloged' => true]);

        // 8. Data Barang (Katalog) untuk OC-001 (1 Barang = 1 Roll)
        $barang1 = Barang::create([
            'penerimaan_id' => $penerimaan1->id,
            'penerimaan_roll_id' => $roll1->id,
            'kategori_id' => $kat1->id,
            'kode_barang' => 'CTN-30-MRH-01',
            'warna' => 'Merah Cabe',
            'status' => 'di_gudang'
        ]);
        $barang2 = Barang::create([
            'penerimaan_id' => $penerimaan1->id,
            'penerimaan_roll_id' => $roll2->id,
            'kategori_id' => $kat1->id,
            'kode_barang' => 'CTN-30-MRH-02',
            'warna' => 'Merah Cabe',
            'status' => 'di_gudang'
        ]);
        $barang3 = Barang::create([
            'penerimaan_id' => $penerimaan1->id,
            'penerimaan_roll_id' => $roll3->id,
            'kategori_id' => $kat1->id,
            'kode_barang' => 'CTN-30-MRH-03',
            'warna' => 'Merah Cabe',
            'status' => 'dikirim' // Sudah dikirim
        ]);

        // OC-002 (Belum dikatalogkan, murni staging)
        $penerimaan2 = Penerimaan::create([
            'supplier_id' => $supplier1->id,
            'tanggal_masuk' => '2026-07-05',
            'kode_oc' => 'OC-002',
            'kategori_id' => $kat2->id,
            'warna' => 'Hitam Pekat'
        ]);
        PenerimaanRoll::create(['penerimaan_id' => $penerimaan2->id, 'nomor_roll' => 'FL-002-A', 'kiloan' => 30.00, 'is_cataloged' => false]);
        PenerimaanRoll::create(['penerimaan_id' => $penerimaan2->id, 'nomor_roll' => 'FL-002-B', 'kiloan' => 29.50, 'is_cataloged' => false]);

        // 9. Data Pengiriman (Outbound) menggunakan $barang3
        $pengiriman1 = Pengiriman::create([
            'user_id' => 1,
            'toko_id' => $toko1->id,
            'armada_id' => $armada1->id,
            'tanggal_kirim' => '2026-07-06',
            'status' => 'dikirim'
        ]);

        // 10. Data Detail Pengiriman
        DetailPengiriman::create([
            'pengiriman_id' => $pengiriman1->id,
            'barang_id' => $barang3->id
        ]);
    }
}
