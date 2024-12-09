<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu
            $table->dropForeign(['coa_id']);

            // Ubah nama kolom dari coa_id menjadi information
            $table->renameColumn('coa_id', 'information');

            // Ubah tipe data kolom information menjadi text
            $table->text('information')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Kembalikan perubahan jika migrasi di-rollback
            $table->char('information', 36)->nullable()->change();

            // Ubah nama kolom kembali menjadi coa_id
            $table->renameColumn('information', 'coa_id');

            // Tambahkan kembali foreign key
            $table->foreign('coa_id')->references('id')->on('coa')->onDelete('cascade');
        });
    }
};
