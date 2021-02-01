<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetailPeminjamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_peminjamen', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('buku_id');
            $table->integer('jumlah')->nullable();
            $table->string('status');
            $table->foreign('buku_id')->references('id')->on('Buku')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('detail_peminjamen');
    }
}
