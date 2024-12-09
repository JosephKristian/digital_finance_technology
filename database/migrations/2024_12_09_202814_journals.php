<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->char('id', 36)->default(DB::raw('UUID()'))->primary();
            $table->char('transaction_id', 36)->nullable();
            $table->char('coa_id', 36); // Referensi ke akun COA
            $table->char('umkm_id', 36); // Menambahkan kolom umkm_id
            $table->text('description');
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['debit', 'credit']);
            $table->timestamps();
        
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('coa_id')->references('id')->on('coa')->onDelete('cascade');
            $table->foreign('umkm_id')->references('id')->on('umkms')->onDelete('cascade'); // Menambahkan foreign key untuk umkm_id
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
