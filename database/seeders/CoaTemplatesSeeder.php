<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoaTemplatesSeeder extends Seeder
{
    public function run()
    {
        // Seeder untuk coa_types_template
        DB::table('coa_types')->insert([
            ['type_name' => 'Asset'],
            ['type_name' => 'Liability'],
            ['type_name' => 'Equity'],
            ['type_name' => 'Revenue'],
            ['type_name' => 'Expense'],
        ]);

        DB::table('coa_types_template')->insert([
            ['type_name' => 'Asset'],
            ['type_name' => 'Liability'],
            ['type_name' => 'Equity'],
            ['type_name' => 'Revenue'],
            ['type_name' => 'Expense'],
        ]);

        // Seeder untuk coa_sub_template
        DB::table('coa_sub_template')->insert([
            // Asset
            ['coa_type_id' => 1, 'sub_name' => 'Current Assets', 'parent_id' => null],
            ['coa_type_id' => 1, 'sub_name' => 'Fixed Assets', 'parent_id' => null],

            // Liability
            ['coa_type_id' => 2, 'sub_name' => 'Current Liabilities', 'parent_id' => null],
            ['coa_type_id' => 2, 'sub_name' => 'Long-Term Liabilities', 'parent_id' => null],

            // Revenue
            ['coa_type_id' => 4, 'sub_name' => 'Sales Revenue', 'parent_id' => null],

            // Expense
            ['coa_type_id' => 5, 'sub_name' => 'Operational Expenses', 'parent_id' => null],
            ['coa_type_id' => 5, 'sub_name' => 'Cost of Goods Sold', 'parent_id' => null],

            // Equity (Modal)
            ['coa_type_id' => 3, 'sub_name' => 'Owner’s Equity', 'parent_id' => null],
            ['coa_type_id' => 3, 'sub_name' => 'Retained Earnings', 'parent_id' => null], 
        ]);

        DB::table('coa_templates')->insert([

            // Current Assets
            [
                'coa_sub_id' => 1, // Current Assets
                'account_code' => '10101',
                'account_name' => 'Kas', // Diganti ke bahasa Indonesia

                'parent_id' => null,
                'category' => 'current',
                'is_default_receipt' => true,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coa_sub_id' => 1, // Current Assets
                'account_code' => '10102',
                'account_name' => 'Piutang Usaha', // Diganti ke bahasa Indonesia

                'parent_id' => null,
                'category' => 'current',
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coa_sub_id' => 1, // Current Assets
                'account_code' => '10103',
                'account_name' => 'Persediaan', // Diganti ke bahasa Indonesia

                'parent_id' => null,
                'category' => 'current',
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coa_sub_id' => 1, // Current Assets
                'account_code' => '10104',
                'account_name' => 'Biaya Dibayar Dimuka', // Diganti ke bahasa Indonesia

                'parent_id' => null,
                'category' => 'current',
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Fixed Assets
            [
                'coa_sub_id' => 2, // Fixed Assets
                'account_code' => '10201',
                'account_name' => 'Peralatan Kantor', // Diganti ke bahasa Indonesia

                'parent_id' => null,
                'category' => 'non_current',
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coa_sub_id' => 2, // Fixed Assets
                'account_code' => '10202',
                'account_name' => 'Akumulasi Penyusutan - Peralatan Kantor', // Diganti ke bahasa Indonesia

                'parent_id' => null,
                'category' => 'non_current',
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Current Liabilities
            [
                'coa_sub_id' => 3, // Current Liabilities
                'account_code' => '20101',
                'account_name' => 'Utang Usaha', // Diganti ke bahasa Indonesia

                'parent_id' => null,
                'category' => 'current',
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coa_sub_id' => 3, // Current Liabilities
                'account_code' => '20102',
                'account_name' => 'Pinjaman Jangka Pendek', // Diganti ke bahasa Indonesia

                'parent_id' => null,
                'category' => 'current',
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Long-Term Liabilities
            [
                'coa_sub_id' => 4, // Long-Term Liabilities
                'account_code' => '20201',
                'account_name' => 'Pinjaman Jangka Panjang', // Diganti ke bahasa Indonesia

                'parent_id' => null,
                'category' => 'non_current',
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Revenue
            [
                'coa_sub_id' => 5, // Sales Revenue
                'account_code' => '40101',
                'account_name' => 'Pendapatan Penjualan', // Diganti ke bahasa Indonesia

                'parent_id' => null,
                'category' => 'current',
                'is_default_receipt' => true,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'coa_sub_id' => 5, // Sales Revenue
                'account_code' => '40102',
                'account_name' => 'Pendapatan Lain - lain', // Diganti ke bahasa Indonesia

                'parent_id' => null,
                'category' => 'current',
                'is_default_receipt' => true,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Expense

            [
                'coa_sub_id' => 6, // Operational Expenses
                'account_code' => '50101',
                'account_name' => 'Biaya Gaji', // Diganti ke bahasa Indonesia

                'parent_id' => null,
                'category' => 'current',
                'is_default_receipt' => false,
                'is_default_expense' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coa_sub_id' => 6,
                'account_code' => '50102',
                'account_name' => 'Biaya Sewa', // Diganti ke bahasa Indonesia

                'parent_id' => null,
                'category' => 'current',
                'is_default_receipt' => false,
                'is_default_expense' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coa_sub_id' => 7, // Cost of Goods Sold
                'account_code' => '50201',
                'account_name' => 'Harga Pokok Penjualan', // Diganti ke bahasa Indonesia

                'parent_id' => null,
                'category' => 'current',
                'is_default_receipt' => false,
                'is_default_expense' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coa_sub_id' => 7, // Operational Expenses
                'account_code' => '50202',
                'account_name' => 'Biaya Utilitas', // Diganti ke bahasa Indonesia

                'parent_id' => null,
                'category' => 'current',
                'is_default_receipt' => false,
                'is_default_expense' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Equity
            [
                'coa_sub_id' => 8, // Equity (Modal)
                'account_code' => '30101',
                'account_name' => 'Modal Pemilik', // Diganti ke bahasa Indonesia
                'parent_id' => null,
                'category' => 'non_current', // Biasanya Equity termasuk kategori non-current
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'coa_sub_id' => 8, // Equity (Modal)
                'account_code' => '30102',
                'account_name' => 'Laba Ditahan', // Diganti ke bahasa Indonesia
                'parent_id' => null,
                'category' => 'non_current',
                'is_default_receipt' => false,
                'is_default_expense' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
