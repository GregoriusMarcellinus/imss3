<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGangguanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gangguan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tempat');
            $table->string('lokasi');
            $table->date('perkiraan_mulai');
            $table->date('perkiraan_selesai');
            $table->string('kondisi');
            $table->string('nama_proyek');
            $table->string('trainset');
            $table->string('car');
            $table->string('perawatan');
            $table->date('tanggal_gangguan');
            $table->string('perkiraan_gangguan');
            $table->string('penyebab_gangguan');
            $table->string('jenis_gangguan');
            $table->string('nama_barang');
            $table->string('jumlah');
            $table->string('satuan');
            $table->string('tindak_lanjut');
            $table->string('hasil_tindak_lanjut');
            $table->string('pelapor');
            $table->string('status');
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
        Schema::dropIfExists('gangguan');
    }
}
