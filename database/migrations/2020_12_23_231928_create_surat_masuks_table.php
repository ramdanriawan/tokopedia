<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSuratMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_masuks', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('sifat_surat_id');
            $table->string('waktu_masuk')->nullable();
            $table->string('nomor')->nullable();
            $table->string('pengirim')->nullable();
            $table->string('perihal')->nullable();
            $table->string('isi_ringkas')->nullable();
            $table->string('lampiran')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('surat_masuks');
    }
}
