<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CoaTemplatesSeeder extends Seeder
{

    public function run()
    {

        // Bersihkan tabel sebelum seeding
        DB::transaction(function () {
            DB::table('coa_templates')->delete();
            DB::table('coa_sub_template')->delete();
            DB::table('coa_types_template')->delete();
            DB::table('coa_types')->delete();
        });

        // Seeder untuk coa_types
        $coaTypes = [
            ['coa_type_id' => 1, 'type_name' => 'ASET', 'created_at' => now(), 'updated_at' => now()],
            ['coa_type_id' => 2, 'type_name' => 'LIABILITAS', 'created_at' => now(), 'updated_at' => now()],
            ['coa_type_id' => 3, 'type_name' => 'EKUITAS', 'created_at' => now(), 'updated_at' => now()],
            ['coa_type_id' => 4, 'type_name' => 'PENDAPATAN', 'created_at' => now(), 'updated_at' => now()],
            ['coa_type_id' => 5, 'type_name' => 'BEBAN', 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('coa_types')->insert($coaTypes);

        $coaTypesTemplate = [
            ['id' => 1, 'type_name' => 'ASET', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'type_name' => 'LIABILITAS', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'type_name' => 'EKUITAS', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'type_name' => 'PENDAPATAN', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'type_name' => 'BEBAN', 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('coa_types_template')->insert($coaTypesTemplate);

        // Seeder untuk coa_sub_template
        $coaSubs = [
            ['id' => 1, 'coa_type_id' => 1, 'sub_name' => 'AKTIVA', 'parent_id' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'coa_type_id' => 1, 'sub_name' => 'PIUTANG', 'parent_id' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'coa_type_id' => 1, 'sub_name' => 'PERSEDIAAN', 'parent_id' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'coa_type_id' => 1, 'sub_name' => 'PENGELUARAN DIBAYAR DI MUKA', 'parent_id' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'coa_type_id' => 1, 'sub_name' => 'AKTIVA TETAP', 'parent_id' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'coa_type_id' => 1, 'sub_name' => 'AKUMULASI PENYUSUSTAN', 'parent_id' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'coa_type_id' => 2, 'sub_name' => 'PASIVA', 'parent_id' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'coa_type_id' => 2, 'sub_name' => 'HUTANG', 'parent_id' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'coa_type_id' => 2, 'sub_name' => 'HUTANG BANK DAN INSTITUSI', 'parent_id' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'coa_type_id' => 3, 'sub_name' => 'MODAL', 'parent_id' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'coa_type_id' => 4, 'sub_name' => 'PENDAPATAN', 'parent_id' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'coa_type_id' => 4, 'sub_name' => 'DISKON PENJUALAN', 'parent_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'coa_type_id' => 4, 'sub_name' => 'RETUR PENJUALAN',  'parent_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'coa_type_id' => 5, 'sub_name' => 'HPP', 'parent_id' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'coa_type_id' => 5, 'sub_name' => 'PEMBELIAN', 'parent_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'coa_type_id' => 5, 'sub_name' => 'DISKON PEMBELIAN', 'parent_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'coa_type_id' => 5, 'sub_name' => 'RETUR PEMBELIAN', 'parent_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'coa_type_id' => 5, 'sub_name' => 'BEBAN PENGELUARAN', 'parent_id' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'coa_type_id' => 4, 'sub_name' => 'PENDAPATAN LAIN-LAIN', 'parent_id' => NULL, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'coa_type_id' => 5, 'sub_name' => 'BEBAN LAIN-LAIN', 'parent_id' => NULL, 'created_at' => now(), 'updated_at' => now()],

        ];
        DB::table('coa_sub_template')->insert($coaSubs);

        // Seeder untuk coa_templates
        $coaTemplates = [
            ['coa_sub_id' => 1, 'account_name' => 'Kas Kecil', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 1, 'account_name' => 'Kas', 'category' => 'current', 'is_default_receipt' => true, 'is_default_expense' => false],
            ['coa_sub_id' => 1, 'account_name' => 'Bank', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => true],

            ['coa_sub_id' => 2, 'account_name' => 'Piutang Usaha', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],

            ['coa_sub_id' => 3, 'account_name' => 'Persediaan Barang Dagang', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 3, 'account_name' => 'Perlengkapan Kantor', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],

            ['coa_sub_id' => 4, 'account_name' => 'Asuransi Dibayar Di Muka', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 4, 'account_name' => 'Sewa Dibayar Di Muka', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],

            ['coa_sub_id' => 5, 'account_name' => 'Perangkat Komputer', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 5, 'account_name' => 'Mesin', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 5, 'account_name' => 'Furnitur', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 5, 'account_name' => 'Mobil dan Motor', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 5, 'account_name' => 'Leasehold Improvements', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 5, 'account_name' => 'Peralatan Produksi', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],

            ['coa_sub_id' => 6, 'account_name' => 'Akumulasi Penyusutan Perangkat Komputer', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 6, 'account_name' => 'Akumulasi Penyusutan Mesin', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 6, 'account_name' => 'Akumulasi Penyusutan Furnitur', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 6, 'account_name' => 'Akumulasi Penyusutan Mobil dan Motor', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 6, 'account_name' => 'Akumulasi Penyusutan Lain-Lain', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => false],

            ['coa_sub_id' => 8, 'account_name' => 'Hutang Dagang', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 8, 'account_name' => 'Pendapatan Diterima di Muka', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 8, 'account_name' => 'PPN Masukan', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 8, 'account_name' => 'PPN Keluaran', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],

            ['coa_sub_id' => 9, 'account_name' => 'Hutang Bank Jangka Panjang', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 9, 'account_name' => 'Hutang Institusi Jangka Pendek', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],

            ['coa_sub_id' => 10, 'account_name' => 'Modal Pemilik', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 10, 'account_name' => 'Laba Ditahan', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 10, 'account_name' => 'Laba Periode Berjalan', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 10, 'account_name' => 'Prive', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],


            ['coa_sub_id' => 11, 'account_name' => 'Pendapatan - Semua Produk', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 11, 'account_name' => 'Pendapatan - Produk 1', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 11, 'account_name' => 'Pendapatan - Produk 2', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 11, 'account_name' => 'Pendapatan - Produk 3', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 11, 'account_name' => 'Pendapatan - Lain-lain', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],

            ['coa_sub_id' => 12, 'account_name' => 'Diskon Penjualan - Semua Produk', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 12, 'account_name' => 'Diskon Penjualan - Produk 1', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 12, 'account_name' => 'Diskon Penjualan - Produk 2', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 12, 'account_name' => 'Diskon Penjualan - Produk 3', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],

            ['coa_sub_id' => 13, 'account_name' => 'Retur Penjualan - Semua Produk', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 13, 'account_name' => 'Retur Penjualan - Produk 1', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 13, 'account_name' => 'Retur Penjualan - Produk 2', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 13, 'account_name' => 'Retur Penjualan - Produk 3', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],

            ['coa_sub_id' => 14, 'account_name' => 'HPP - Semua Produk', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 14, 'account_name' => 'HPP - Produk 1', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 14, 'account_name' => 'HPP - Produk 2', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 14, 'account_name' => 'HPP - Produk 3', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],

            ['coa_sub_id' => 15, 'account_name' => 'Pembelian - Semua Produk', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 15, 'account_name' => 'Pembelian - Produk 1', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 15, 'account_name' => 'Pembelian - Produk 2', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 15, 'account_name' => 'Pembelian - Produk 3', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],

            ['coa_sub_id' => 16, 'account_name' => 'Diskon Pembelian - Semua Produk', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 16, 'account_name' => 'Diskon Pembelian - Produk 1', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 16, 'account_name' => 'Diskon Pembelian - Produk 2', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],
            ['coa_sub_id' => 16, 'account_name' => 'Diskon Pembelian - Produk 3', 'category' => 'current', 'is_default_receipt' => false, 'is_default_expense' => false],

            ['coa_sub_id' => 17, 'account_name' => 'Retur Pembelian - Semua Produk', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 17, 'account_name' => 'Retur Pembelian - Produk 1', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 17, 'account_name' => 'Retur Pembelian - Produk 2', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 17, 'account_name' => 'Retur Pembelian - Produk 3', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],



            ['coa_sub_id' => 18, 'account_name' => 'Beban - Gaji Karyawan', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 18, 'account_name' => 'Beban - Administrasi', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 18, 'account_name' => 'Beban - Listrik, Air, Telpon', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 18, 'account_name' => 'Beban - Sewa Kantor', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 18, 'account_name' => 'Beban - Asuransi', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 18, 'account_name' => 'Beban - Service dan Perawatan', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 18, 'account_name' => 'Beban - Perlengkapan Kantor', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 18, 'account_name' => 'Beban - Penyusutan Perlengkapan Kantor', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 18, 'account_name' => 'Beban - Penyusutan Mobil dan Motor', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 18, 'account_name' => 'Beban - Lain-Lain', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],

            ['coa_sub_id' => 17, 'account_name' => 'Bunga Bank', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],

            ['coa_sub_id' => 20, 'account_name' => 'Beban - Bunga Bank', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],
            ['coa_sub_id' => 20, 'account_name' => 'Administrasi Bank', 'category' => 'non_current', 'is_default_receipt' => false, 'is_default_expense' => true],


        ];



        DB::transaction(function () use ($coaTemplates) {
            // Daftar kode parent untuk tiap coa_sub_id
            $parentCodes = [
                1100, // Aktiva (coa_sub_id = 1)
                1200, // Piutang (coa_sub_id = 2)
                1300, // Persediaan (coa_sub_id = 3)
                1400, // Pengeluaran Dibayar di Muka (coa_sub_id = 4)
                1500, // Aktiva Tetap (coa_sub_id = 5)
                1600, // Akumulasi Penyusutan (coa_sub_id = 6)
                2000, // Pasiva (coa_sub_id = 7)
                2100, // Hutang (coa_sub_id = 8)
                2200, // Hutang Bank dan Institusi (coa_sub_id = 9)
                3100, // Modal (coa_sub_id = 10)
                4100, // Pendapatan (coa_sub_id = 11)
                4200, // Diskon Penjualan (coa_sub_id = 12)
                4300, // Retur Penjualan (coa_sub_id = 13)
                5100, // HPP (coa_sub_id = 14)
                5200, // Pembelian (coa_sub_id = 15)
                5300, // Diskon Pembelian (coa_sub_id = 16)
                5400, // Retur Pembelian (coa_sub_id = 17)
                6100, // Beban Pengeluaran (coa_sub_id = 18)
                7100, // Pendapatan Lain-lain (coa_sub_id = 19)
                8000, // Beban Pengeluaran Lain-lain (coa_sub_id = 20)
            ];

            // Inisialisasi counter untuk setiap coa_sub_id
            $counts = array_fill(0, count($parentCodes), 1);

            foreach ($coaTemplates as &$template) {
                $subId = $template['coa_sub_id'];

                // Validasi bahwa coa_sub_id sesuai dengan parentCodes
                if (isset($parentCodes[$subId - 1])) {
                    $parentCode = $parentCodes[$subId - 1];

                    // Ambil account_code terakhir dari database untuk coa_sub_id ini
                    $lastCode = DB::table('coa_templates')
                        ->where('coa_sub_id', $subId)
                        ->max('account_code');

                    $existingCodes = DB::table('coa_templates')
                        ->where('coa_sub_id', $subId)
                        ->pluck('account_code')
                        ->toArray();

                    do {
                        if ($lastCode) {
                            $newCode = $lastCode + 10;
                        } else {
                            $newCode = $parentCode + $counts[$subId - 1] * 10;
                            $counts[$subId - 1]++;
                        }
                    } while (in_array($newCode, $existingCodes));

                    $template['account_code'] = $newCode;
                } else {
                    throw new Exception("Invalid coa_sub_id: {$subId}");
                }

                // Tambahkan data tambahan
                $template['created_at'] = now();
                $template['updated_at'] = now();
                $template['parent_id'] = null; // Sesuaikan dengan hierarki jika diperlukan

                // Masukkan data ke tabel
                DB::table('coa_templates')->insert($template);
            }
        });

        /**
         * Fungsi untuk menghasilkan account_code.
         *
         * @param int $parentCode
         * @param int $count
         * @return int
         */
        function generateAccountCode($parentCode, $count)
        {
            return $parentCode + $count * 10;
        }
    }



    // public function run()
    // {
    //     function generateAccountCode($coa_type_id, $coa_sub_id)
    //     {
    //         do {
    //             // Hitung jumlah baris untuk coa_sub_id tertentu
    //             $count = DB::table('coa_templates')
    //                 ->where('coa_sub_id', $coa_sub_id)
    //                 ->count();

    //             // Generate account_code
    //             $account_code = str_pad($coa_type_id, 1, '0', STR_PAD_LEFT)
    //                 . str_pad($coa_sub_id, 2, '0', STR_PAD_LEFT)
    //                 . str_pad($count + 1, 3, '0', STR_PAD_LEFT);

    //             // Periksa apakah account_code unik
    //             $exists = DB::table('coa_templates')
    //                 ->where('account_code', $account_code)
    //                 ->exists();

    //             if (!$exists) {
    //                 break;
    //             }

    //             $count++;
    //         } while (true);

    //         Log::info('Generated account_code: ' . $account_code);
    //         return $account_code;
    //     }

    //     // Bersihkan tabel sebelum seeding
    //     DB::transaction(function () {
    //         DB::table('coa_templates')->delete();
    //         DB::table('coa_sub_template')->delete();
    //         DB::table('coa_types_template')->delete();
    //         DB::table('coa_types')->delete();
    //     });


    //     // Seeder untuk coa_types
    //     // Seeder untuk coa_types_template
    //     DB::table('coa_types_template')->insert([
    //         ['id' => 1, 'type_name' => 'Asset'],
    //         ['id' => 2, 'type_name' => 'Liability'],
    //         ['id' => 3, 'type_name' => 'Equity'],
    //         ['id' => 4, 'type_name' => 'Revenue'],
    //         ['id' => 5, 'type_name' => 'Expense'],
    //     ]);


    //     // Seeder untuk coa_sub_template
    //     DB::table('coa_sub_template')->insert([
    //         // Asset
    //         ['coa_type_id' => 1, 'sub_name' => 'Current Assets', 'parent_id' => null],
    //         ['coa_type_id' => 1, 'sub_name' => 'Fixed Assets', 'parent_id' => null],
    //         ['coa_type_id' => 1, 'sub_name' => 'Accounts Receivable', 'parent_id' => 1],
    //         ['coa_type_id' => 1, 'sub_name' => 'Cash and Cash Equivalents', 'parent_id' => 1],

    //         // Liability
    //         ['coa_type_id' => 2, 'sub_name' => 'Current Liabilities', 'parent_id' => null],
    //         ['coa_type_id' => 2, 'sub_name' => 'Long-term Liabilities', 'parent_id' => null],
    //         ['coa_type_id' => 2, 'sub_name' => 'Accounts Payable', 'parent_id' => 5],

    //         // Equity
    //         ['coa_type_id' => 3, 'sub_name' => 'Retained Earnings', 'parent_id' => null],

    //         // Revenue
    //         ['coa_type_id' => 4, 'sub_name' => 'Service Revenue', 'parent_id' => null],
    //         ['coa_type_id' => 4, 'sub_name' => 'Product Revenue', 'parent_id' => null],

    //         // Expense
    //         ['coa_type_id' => 5, 'sub_name' => 'Cost of Goods Sold', 'parent_id' => null],
    //         ['coa_type_id' => 5, 'sub_name' => 'Operating Expenses', 'parent_id' => null],
    //         ['coa_type_id' => 5, 'sub_name' => 'Salaries and Wages', 'parent_id' => 13],
    //     ]);

    //     // Seeder untuk coa_templates
    //     DB::transaction(function () {
    //         $templates = [
    //             [
    //                 'coa_sub_id' => 1, // Current Assets
    //                 'account_name' => 'Kas',
    //                 'parent_id' => null,
    //                 'category' => 'current',
    //                 'is_default_receipt' => true,
    //                 'is_default_expense' => false,
    //             ],
    //             [
    //                 'coa_sub_id' => 1, // Current Assets
    //                 'account_name' => 'Piutang Usaha',
    //                 'parent_id' => null,
    //                 'category' => 'current',
    //                 'is_default_receipt' => false,
    //                 'is_default_expense' => false,
    //             ],
    //         ];

    //         foreach ($templates as $template) {
    //             $template['account_code'] = generateAccountCode(1, $template['coa_sub_id']);
    //             $template['created_at'] = now();
    //             $template['updated_at'] = now();

    //             DB::table('coa_templates')->insert($template);
    //         }
    //     });
    // }
}
