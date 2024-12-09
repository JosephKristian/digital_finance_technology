<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CustomersSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $umkmIds = DB::table('umkms')->pluck('id'); // Ambil semua ID UMKM dari tabel 'umkms'

        foreach ($umkmIds as $umkmId) {
            // Misalkan kita ingin menambahkan 10 customer
            for ($i = 0; $i < 150; $i++) {
                DB::table('customers')->insert([
                    'id' => $faker->uuid,
                    'umkm_id' => $umkmId, // Pastikan umkm_id ini valid dan ada di tabel umkms
                    'name' => $faker->name,
                    'phone' => $faker->phoneNumber,
                    'email' => $faker->email,
                    'address' => $faker->address,
                    'preferred_contact_method' => $faker->randomElement(['phone', 'email']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
