<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGajiPkwtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gaji_pkwt', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_karyawan');
            $table->foreign('id_karyawan')->references('id')->on('karyawan')->onDelete('cascade');
            $table->integer('id_gaji');
            $table->integer('kehadiran');
            $table->integer('hari_kerja');
            $table->integer('nilai_ikk');
            $table->integer('dana_ikk');
            $table->integer('penyesuaian_penambahan');
            $table->integer('penyesuaian_pengurangan');
            $table->integer('jam_hilang');
            $table->integer('tunjangan_profesional');
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
        Schema::dropIfExists('gaji_pkwt');
    }
}
