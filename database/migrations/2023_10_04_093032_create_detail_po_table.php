<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_po', function (Blueprint $table) {
            $table->id();
            $table->integer('id_po');
            $table->integer('id_pr');
            $table->integer('id_detail_pr');
            $table->date('batas_akhir')->nullable();
            $table->string('harga')->nullable();
            $table->string('mata uang')->nullable();
            $table->string('vat')->nullable();
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
        Schema::dropIfExists('detail_po');
    }
}
