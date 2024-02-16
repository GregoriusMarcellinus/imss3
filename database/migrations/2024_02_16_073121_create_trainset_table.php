<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainsetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainset', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tempat');
            $table->string('nama_proyek');
            $table->string('proyek');
            $table->string('trainset_kode');
            $table->string('trainset_nama');
            $table->string('car_nomor');
            $table->string('car_nama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainset');
    }
}
