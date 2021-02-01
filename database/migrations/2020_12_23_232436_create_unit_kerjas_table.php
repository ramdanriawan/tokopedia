<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUnitKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_kerjas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('bagian_id');
            $table->string('nama')->nullable();
            $table->string('jenis_kelamin');
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
        Schema::drop('unit_kerjas');
    }
}
