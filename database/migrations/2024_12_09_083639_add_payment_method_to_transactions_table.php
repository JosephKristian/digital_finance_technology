<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->char('payment_method_id', 36)->nullable(); // Menambahkan kolom payment_method_id
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('set null'); // Foreign key ke payment_methods
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['payment_method_id']); // Drop foreign key
            $table->dropColumn('payment_method_id'); // Drop kolom payment_method_id
        });
    }
};
