<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePengembaliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('anggota_id');
            $table->string('peminjaman_id');
            $table->string('tanggal')->nullable();
            $table->integer('denda_terlambat')->nullable();
            $table->integer('denda_rusak')->nullable();
            $table->foreign('anggota_id')->references('id')->on('Anggota')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('peminjaman_id')->references('id')->on('Peminjaman')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pengembalians');
    }
}
