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
            $table->char('coa_id', 36)->nullable(); // Akun default, bisa null
            $table->foreign('coa_id')->references('id')->on('coa')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['coa_id']); // Hapus foreign key
            $table->dropColumn('coa_id'); // Hapus kolom coa_id
        });
    }
};
