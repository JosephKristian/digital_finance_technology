<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->char('id', 36)->default(DB::raw('UUID()'))->primary();
            $table->char('umkm_id', 36);
            $table->string('name');
            $table->decimal('purchase_price', 15, 2);
            $table->decimal('selling_price', 15, 2);
            $table->integer('stock_quantity')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->foreign('umkm_id')->references('id')->on('umkms')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
