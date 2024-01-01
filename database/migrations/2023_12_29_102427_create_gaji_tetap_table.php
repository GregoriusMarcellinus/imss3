<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGajiTetapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gaji_tetap', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_karyawan');
            $table->foreign('id_karyawan')->references('id')->on('karyawan')->onDelete('cascade');
            $table->integer('id_gaji');
            $table->string('golongan');
            $table->integer('kredit_poin');
            $table->integer('kehadiran');
            $table->integer('hari_kerja');
            $table->integer('nilai_ikk');
            $table->integer('dana_ikk');
            $table->integer('penyesuaian_penambahan');
            $table->integer('penyesuaian_pengurangan');
            $table->integer('ppip_mandiri');
            $table->integer('jam_hilang');
            $table->integer('kopinka');
            $table->integer('keuangan');
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
        Schema::dropIfExists('gaji_tetap');
    }
}
