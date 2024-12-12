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
        Schema::create('coa_sub_template', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('coa_type_id'); // Foreign Key ke coa_types_template
            $table->string('sub_name'); // Nama sub kategori (Current Assets, Fixed Assets, etc.)
            $table->unsignedBigInteger('parent_id')->nullable(); // Hierarki parent (opsional)
            $table->timestamps();

            $table->foreign('coa_type_id')->references('id')->on('coa_types_template')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('coa_sub_template')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coa_sub_template');
    }
};
