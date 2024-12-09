<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoaTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('coa_templates')->insert([
            // Asset Accounts
            [
                'id' => (string) Str::uuid(),
                'account_code' => '1001',
                'account_name' => 'Kas',
                'account_type' => 'asset',
                'parent_id' => null,
                'category' => 'current', // Kategori 'current' untuk Kas
                'is_default_receipt' => true,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'account_code' => '1002',
                'account_name' => 'Bank',
                'account_type' => 'asset',
                'parent_id' => null,
                'category' => 'current', // Kategori 'current' untuk Bank
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'account_code' => '1003',
                'account_name' => 'Piutang Dagang',
                'account_type' => 'asset',
                'parent_id' => null,
                'category' => 'current', // Kategori 'current' untuk Piutang Dagang
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        
            // Liability Accounts
            [
                'id' => (string) Str::uuid(),
                'account_code' => '2001',
                'account_name' => 'Utang Dagang',
                'account_type' => 'liability',
                'parent_id' => null,
                'category' => 'current', // Kategori 'current' untuk Utang Dagang
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'account_code' => '2002',
                'account_name' => 'Utang Bank',
                'account_type' => 'liability',
                'parent_id' => null,
                'category' => 'non_current', // Kategori 'non_current' untuk Utang Bank
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        
            // Income Accounts
            [
                'id' => (string) Str::uuid(),
                'account_code' => '4001',
                'account_name' => 'Pendapatan Penjualan',
                'account_type' => 'income',
                'parent_id' => null,
                'category' => 'current', // Kategori 'current' untuk Pendapatan Penjualan
                'is_default_receipt' => true,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'account_code' => '4002',
                'account_name' => 'Pendapatan Bunga',
                'account_type' => 'income',
                'parent_id' => null,
                'category' => 'non_current', // Kategori 'non_current' untuk Pendapatan Bunga
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        
            // Expense Accounts
            [
                'id' => (string) Str::uuid(),
                'account_code' => '5001',
                'account_name' => 'Beban Operasional',
                'account_type' => 'expense',
                'parent_id' => null,
                'category' => 'current', // Kategori 'current' untuk Beban Operasional
                'is_default_receipt' => false,
                'is_default_expense' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'account_code' => '5002',
                'account_name' => 'Beban Gaji',
                'account_type' => 'expense',
                'parent_id' => null,
                'category' => 'current', // Kategori 'current' untuk Beban Gaji
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'account_code' => '5003',
                'account_name' => 'Beban Bunga',
                'account_type' => 'expense',
                'parent_id' => null,
                'category' => 'non_current', // Kategori 'non_current' untuk Beban Bunga
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        
            // Equity Accounts
            [
                'id' => (string) Str::uuid(),
                'account_code' => '3001',
                'account_name' => 'Modal Pemilik',
                'account_type' => 'equity',
                'parent_id' => null,
                'category' => 'non_current', // Kategori 'non_current' untuk Modal Pemilik
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'account_code' => '3002',
                'account_name' => 'Laba Ditahan',
                'account_type' => 'equity',
                'parent_id' => null,
                'category' => 'non_current', // Kategori 'non_current' untuk Laba Ditahan
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
    }
}
