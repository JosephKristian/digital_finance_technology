<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        PaymentMethod::create([
            'name' => 'Cash',
            'description' => 'Pembayaran menggunakan uang tunai',
        ]);

        PaymentMethod::create([
            'name' => 'Transfer',
            'description' => 'Pembayaran menggunakan transfer bank',
        ]);

        PaymentMethod::create([
            'name' => 'QRIS',
            'description' => 'Pembayaran menggunakan QRIS',
        ]);
    }
}
