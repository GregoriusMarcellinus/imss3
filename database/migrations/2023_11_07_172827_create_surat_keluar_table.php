<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratKeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->string('direksi');
            $table->integer('type');
            $table->string('no_surat');
            $table->string('tujuan');
            $table->string('uraian');
            $table->integer('id_user');
            $table->string('file')->nullable()->default(null);
            $table->integer('status')->nullable()->default(0)->comment('0: pending, 1: ada, 2: cancel');
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
        Schema::dropIfExists('surat_keluar');
    }
}
