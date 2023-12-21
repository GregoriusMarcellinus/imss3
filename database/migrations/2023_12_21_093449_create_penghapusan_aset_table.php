<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenghapusanAsetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penghapusan_aset', function (Blueprint $table) {
            $table->id();
            $table->integer('kode_aset_id');
            $table->integer('tipe');
            $table->string('nomor_aset');
            $table->string('jenis_aset');
            $table->string('merek')->nullable();
            $table->string('no_seri')->nullable();
            $table->string('kondisi');
            $table->string('lokasi');
            $table->string('pengguna')->nullable();
            $table->date('tanggal_perolehan');
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('penghapusan_aset');
    }
}
