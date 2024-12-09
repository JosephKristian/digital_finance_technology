<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product; // Pastikan model Product sudah ada
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $umkmIds = DB::table('umkms')->pluck('id'); // Ambil semua ID UMKM dari tabel 'umkms'

        foreach ($umkmIds as $umkmId) {
            for ($i = 0; $i < 300; $i++) {
                Product::create([
                    'id' => (string) Str::uuid(),
                    'umkm_id' => $umkmId,
                    'name' => 'Product ' . Str::random(5),
                    'purchase_price' => rand(1000, 100000),
                    'selling_price' => rand(6000, 100000000),
                    'stock_quantity' => rand(1, 200),
                    'status' => 'active',
                ]);
            }
        }
    }
}
