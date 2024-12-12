<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(ProductSeeder::class);
        $this->call(CustomersSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(CoaTemplatesSeeder::class);
        User::factory()->create([
            'name' => 'SuperAdmin Digital Financial Technology',
            'email' => 'sa@digifintech.com',
            'password' => 'sa123#',
            'role' => 'admin',
        ]);
    }
}
