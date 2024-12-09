<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateUmkmsTable extends Migration
{
    public function up()
    {
        Schema::create('umkms', function (Blueprint $table) {
            $table->char('id', 36)->default(DB::raw('UUID()'))->primary();
            $table->char('user_id', 36)->nullable();
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('tax_id')->nullable();
            $table->string('business_type')->nullable();
            $table->string('pdf_path')->nullable();
            $table->boolean('approve')->nullable()->default(false);


            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('umkms');
    }
}
