<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\TokoSetting;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::create([
            'id_staff' => 'ADM_1',
            'name'     => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'status'   => 'on_air',
            'email'    => 'admin@madurastore.id',
        ]);
        User::create([
            'id_staff' => 'KSR_1',
            'name'     => 'Kasir 1',
            'username' => 'kasir',
            'password' => Hash::make('kasir123'),
            'role'     => 'kasir',
            'status'   => 'on_air',
        ]);

        TokoSetting::create([
            'nama_toko' => "Madura's Store",
            'alamat'    => 'Jl. Contoh No. 1, Jakarta',
        ]);

        $kategori = [
            ['nama' => 'Sembako',               'warna' => '#f87171', 'icon' => 'bi-bag-fill'],
            ['nama' => 'Kebutuhan Rumah Tangga', 'warna' => '#c084fc', 'icon' => 'bi-house-fill'],
            ['nama' => 'Makanan & Minuman',      'warna' => '#22d3ee', 'icon' => 'bi-cup-straw'],
            ['nama' => 'Rokok',                  'warna' => '#4ade80', 'icon' => 'bi-emoji-smile'],
            ['nama' => 'Perawatan',              'warna' => '#fbbf24', 'icon' => 'bi-stars'],
        ];
        foreach ($kategori as $k) Kategori::create($k);

        $produk = [
            ['kode' => 'YKT150', 'nama' => 'Yakult',          'merk' => 'Yakult',    'kategori_id' => 3, 'harga_awal' => 10000, 'harga_jual' => 15000],
            ['kode' => 'MKR200', 'nama' => 'Mie Kuah',        'merk' => 'Indomie',   'kategori_id' => 3, 'harga_awal' => 2800,  'harga_jual' => 4000],
            ['kode' => 'RST100', 'nama' => 'Roti Tawar',      'merk' => 'Sari Roti', 'kategori_id' => 3, 'harga_awal' => 8000,  'harga_jual' => 12000],
            ['kode' => 'SNK500', 'nama' => 'Snack Chitato',   'merk' => 'Chitato',   'kategori_id' => 3, 'harga_awal' => 7000,  'harga_jual' => 10000],
            ['kode' => 'BRS250', 'nama' => 'Beras 5kg',       'merk' => 'Rose Brand', 'kategori_id' => 1,'harga_awal' => 58000, 'harga_jual' => 68000],
            ['kode' => 'KPI300', 'nama' => 'Kecap Bango',     'merk' => 'Bango',     'kategori_id' => 1, 'harga_awal' => 8000,  'harga_jual' => 12000],
        ];
        foreach ($produk as $p) Produk::create($p);
    }
}
