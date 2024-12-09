<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTransactionDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->char('id', 36)->default(DB::raw('UUID()'))->primary();
            $table->char('transaction_id', 36);
            $table->char('product_id', 36);
            $table->integer('quantity');
            $table->decimal('price', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();

            $table->foreign('transaction_id')->references('transaction_id')->on('transactions')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaction_details');
    }
}
