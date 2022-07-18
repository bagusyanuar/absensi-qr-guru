<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsenDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absen_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('absen_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->time('waktu');
            $table->string('tipe');
            $table->text('keterangan')->default('');
            $table->timestamps();
            $table->foreign('absen_id')->references('id')->on('absen');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absen_detail');
    }
}
