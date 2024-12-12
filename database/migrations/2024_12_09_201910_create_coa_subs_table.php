<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('coa_subs', function (Blueprint $table) {
        //     $table->unsignedBigInteger('coa_sub_id'); // Primary key
        //     $table->unsignedBigInteger('coa_type_id');
        //     $table->char('umkm_id', 36); // ID UMKM
        //     $table->string('sub_name');  // Nama sub-akun
        //     $table->timestamps();

        //     $table->primary(['umkm_id', 'coa_sub_id']);

        //     $table->foreign('umkm_id')->references('id')->on('umkms')->onDelete('cascade');
        //     // Tambahkan foreign key untuk 'coa_type_id'
        //     $table->foreign('coa_type_id')
        //         ->references('coa_type_id')
        //         ->on('coa_types')
        //         ->onDelete('cascade');

        //     // Tambahkan composite key pada umkm_id dan coa_sub_id
        //     $table->unique(['umkm_id', 'coa_sub_id'], 'umkm_coa_unique');
        // });
        Schema::create('coa_subs', function (Blueprint $table) {
            $table->unsignedBigInteger('coa_sub_id'); // ID unik untuk setiap sub-akun
            $table->char('umkm_id', 36); // ID UMKM
            $table->unsignedBigInteger('coa_type_id'); // Tipe akun
            $table->string('sub_name'); // Nama sub-akun
            $table->unsignedBigInteger('parent_id')->nullable(); // Parent akun jika ada
            $table->timestamps();
        
            // Kombinasi umkm_id dan coa_sub_id sebagai primary key
            $table->primary(['coa_sub_id', 'umkm_id']);
        
            // Relasi dengan tabel lain
            $table->foreign('umkm_id')->references('id')->on('umkms')->onDelete('cascade');
            $table->foreign('coa_type_id')->references('coa_type_id')->on('coa_types')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coa_subs');
    }
};
