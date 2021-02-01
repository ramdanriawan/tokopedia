<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnggotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggotas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('no_identitas')->nullable();
            $table->string('kelas_id');
            $table->string('nama')->nullable();
            $table->string('jenis_kelamin');
            $table->text('alamat')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('status');
            $table->string('dibuat')->nullable();
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('anggotas');
    }
}
