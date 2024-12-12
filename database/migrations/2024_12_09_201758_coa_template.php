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
        Schema::create('coa_templates', function (Blueprint $table) {
            $table->char('id', 36)->default(DB::raw('UUID()'))->primary();
            $table->unsignedBigInteger('coa_sub_id');
            $table->string('account_code')->unique();
            $table->string('account_name');
            
            $table->char('parent_id', 36)->nullable(); // Hierarki akun
            $table->enum('category', ['current', 'non_current'])->nullable();
            $table->boolean('is_default_receipt')->default(false); // Default untuk penerimaan
            $table->boolean('is_default_expense')->default(false); // Default untuk pengeluaran
            $table->timestamps();
        
            $table->foreign('parent_id')->references('id')->on('coa_templates')->onDelete('set null');
            $table->foreign('coa_sub_id')->references('id')->on('coa_sub_template')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coa_templates');
    }
};
