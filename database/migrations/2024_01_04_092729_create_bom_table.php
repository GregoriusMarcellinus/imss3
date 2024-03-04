<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bom', function (Blueprint $table) {
            $table->id();
            $table->integer('id_service');
            $table->integer('proyek_id');
            // $table->string('nomor');
            $table->string('proyek');
            $table->string('tanggal');
            $table->string('kode_material');
            $table->string('deskripsi_material');
            $table->string('spesifikasi');
            $table->string('jenis_perawatan');
            $table->string('trainset');
            $table->string('car');
            $table->string('corrective_part');
            $table->string('jumlah');
            $table->string('satuan');
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
        Schema::dropIfExists('bom');
    }
}
