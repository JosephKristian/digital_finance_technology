<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->char('id', 36)->default(DB::raw('UUID()'))->primary();
            $table->string('transaction_id')->unique();
            $table->char('umkm_id', 36);
            $table->char('customer_id', 36);
            $table->date('transaction_date');
            $table->decimal('total_amount', 15, 2);
            $table->boolean('status')->nullable()->default(false);
            $table->timestamps();

            $table->foreign('umkm_id')->references('id')->on('umkms')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
