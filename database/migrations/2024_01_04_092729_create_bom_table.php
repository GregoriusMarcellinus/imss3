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
            $table->integer('proyek_id');
            $table->string('nomor');
            $table->string('proyek');
            $table->string('tanggal');
            $table->string('kode_material');
            $table->date('deskripsi_material');
            $table->date('spesifikasi');
            $table->string('p1');
            $table->string('p3');
            $table->string('p6');
            $table->string('p12');
            $table->string('p24');
            $table->string('p36');
            $table->string('p48');
            $table->string('p60');
            $table->string('p72');
            $table->string('protective_part');
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
