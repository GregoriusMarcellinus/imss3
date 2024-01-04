<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyek', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tempat');
            $table->string('nama_tempat');
            $table->string('lokasi');
            $table->string('nama_proyek');
            $table->date('proyek_mulai');
            $table->date('proyek_selesai');
            $table->string('proyek_status');
            $table->string('trainset_kode');
            $table->string('trainset_nama');
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
        Schema::dropIfExists('proyek');
    }
}
