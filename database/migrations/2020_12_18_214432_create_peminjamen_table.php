<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePeminjamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('anggota_id');
            $table->string('user_petugas_id');
            $table->string('tanggal')->nullable();
            $table->string('tanggal_pengembalian')->nullable();
            $table->string('status');
            $table->foreign('anggota_id')->references('id')->on('Anggota')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_petugas_id')->references('id')->on('User')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('peminjamen');
    }
}
