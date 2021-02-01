<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRekrutmensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekrutmens', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('jabatan_id');
            $table->string('no_pendaftar')->nullable();
            $table->string('nik')->nullable();
            $table->string('nama')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->text('alamat')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('status');
            $table->string('dibuat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rekrutmens');
    }
}
