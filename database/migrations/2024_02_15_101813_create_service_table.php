<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tempat');
            $table->string('lokasi');
            $table->string('nama_proyek');
            $table->string('trainset');
            $table->string('car');
            $table->string('perawatan');
            $table->date('perawatan_mulai');
            $table->date('perawatan_selesai');
            $table->string('komponen_diganti');
            $table->string('tanggal_komponen');
            $table->string('pic');
            $table->string('keterangan');
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
        Schema::dropIfExists('service');
    }
}
