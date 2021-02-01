<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDisposisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposisis', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('surat_masuk_id')->nullable();
            $table->string('unit_kerja_sub_bagian_id');
            $table->string('rekrutmen_jabatan_id');
            $table->string('waktu_disposisi')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('disposisis');
    }
}
