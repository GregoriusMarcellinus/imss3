<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNegoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nego', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_nego');
            $table->integer('lampiran');
            $table->integer('vendor_id');
            $table->date('tanggal_nego');
            $table->string('batas_nego');
            $table->string('perihal');
            $table->string('penerima');
            $table->string('alamat');
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
        Schema::dropIfExists('nego');
    }
}
