<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Toko;
use App\Models\Kategori;
use App\Models\Armada;
use App\Models\Barang;
use App\Models\Pengiriman;
use App\Models\DetailPengiriman;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Buat 20 Toko
        $tokos = [];
        for ($i = 0; $i < 20; $i++) {
            $tokos[] = Toko::create([
                'nama_toko' => 'Toko ' . $faker->company,
                'alamat_toko' => $faker->address,
            ]);
        }

        // 2. Buat Admin User (Pusat) & 20 Admin Toko
        User::create([
            'name' => 'Admin Pusat',
            'email' => 'admin@karunia.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        User::create([
            'name' => 'Petugas Gudang',
            'email' => 'petugas@karunia.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        $users = [];
        foreach ($tokos as $toko) {
            $users[] = User::create([
                'name' => 'Admin ' . $toko->nama_toko,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'toko_id' => $toko->id,
                'role' => 'admin_toko',
            ]);
        }

        // 3. Buat 20 Kategori
        $kategoris = [];
        for ($i = 0; $i < 20; $i++) {
            $kategoris[] = Kategori::create([
                'nama_kategori' => 'Kategori ' . $faker->word,
                'deskripsi' => $faker->sentence,
            ]);
        }

        // 4. Buat 20 Armada
        $armadas = [];
        for ($i = 0; $i < 20; $i++) {
            $armadas[] = Armada::create([
                'plat_nomor' => strtoupper($faker->bothify('D #### ??')),
                'jenis_kendaraan' => $faker->randomElement(['Engkel', 'Box', 'Fuso', 'Blind Van']),
                'nama_supir' => $faker->name,
            ]);
        }

        // 5. Buat 20 Barang
        $barangs = [];
        $ukuranEnum = ['16s', '20s', '24s', '30s', '40s'];
        for ($i = 0; $i < 20; $i++) {
            $barangs[] = Barang::create([
                'kategori_id' => $kategoris[array_rand($kategoris)]->id,
                'kode_barang' => strtoupper($faker->unique()->bothify('BRG-#####')),
                'nama_barang' => 'Kain ' . $faker->colorName,
                'ukuran' => $faker->randomElement($ukuranEnum),
                'warna' => $faker->colorName,
            ]);
        }

        // 6. Buat Supplier
        $suppliers = [];
        for ($i = 0; $i < 10; $i++) {
            $suppliers[] = \App\Models\Supplier::create([
                'nama_supplier' => $faker->company,
                'kontak_person' => $faker->name,
                'no_telepon' => $faker->phoneNumber,
                'alamat' => $faker->address,
            ]);
        }

        // 7. Buat Penerimaan dan Rolls
        $rolls = [];
        for ($i = 0; $i < 30; $i++) {
            $penerimaan = \App\Models\Penerimaan::create([
                'supplier_id' => $suppliers[array_rand($suppliers)]->id,
                'tanggal_masuk' => $faker->dateTimeBetween('-2 months', '-1 week')->format('Y-m-d'),
                'kode_batch' => strtoupper($faker->unique()->bothify('BATCH-#####')),
            ]);

            $jumlahRoll = rand(3, 10);
            for ($j = 0; $j < $jumlahRoll; $j++) {
                $rolls[] = \App\Models\Roll::create([
                    'penerimaan_id' => $penerimaan->id,
                    'barang_id' => $barangs[array_rand($barangs)]->id,
                    'nomor_roll' => strtoupper($faker->unique()->bothify('R-########')),
                    'berat_kg' => $faker->randomFloat(2, 20, 35),
                    'status' => 'di_gudang',
                ]);
            }
        }

        // 8. Buat Pengiriman beserta detailnya
        $statusEnum = ['diproses', 'dikirim', 'diterima'];
        for ($i = 0; $i < 20; $i++) {
            $pengiriman = Pengiriman::create([
                'user_id' => User::where('role', 'petugas')->first()->id,
                'toko_id' => $tokos[array_rand($tokos)]->id,
                'armada_id' => $armadas[array_rand($armadas)]->id,
                'tanggal_kirim' => $faker->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
                'tanggal_diterima' => $faker->optional(0.7)->dateTimeBetween('-1 week', 'now'),
                'status' => $faker->randomElement($statusEnum),
            ]);

            // Pilih beberapa roll yang masih di gudang
            $availableRolls = array_filter($rolls, function($r) {
                return $r->status === 'di_gudang';
            });
            $availableRolls = array_values($availableRolls); // Re-index

            if(count($availableRolls) > 0) {
                $jumlahBarang = min(rand(1, 5), count($availableRolls));
                $selectedKeys = (array) array_rand($availableRolls, $jumlahBarang);
                foreach ($selectedKeys as $key) {
                    $roll = $availableRolls[$key];
                    DetailPengiriman::create([
                        'pengiriman_id' => $pengiriman->id,
                        'roll_id' => $roll->id,
                    ]);
                    // Update status roll secara lokal dan database
                    $roll->update(['status' => 'dikirim']);
                    $roll->status = 'dikirim';
                }
            }
        }
    }
}
