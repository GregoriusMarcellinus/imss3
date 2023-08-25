<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->string('no_po');
            $table->date('tanggal_po');
            $table->string('incoterm');
            $table->string('pr_no');
            $table->string('ref_sph')->nullable();
            $table->string('no_just')->nullable();
            $table->string('no_nego')->nullable();
            $table->date('batas_po');
            $table->string('ref_po')->nullable();
            $table->string('term_pay');
            $table->string('garansi')->nullable();
            $table->integer('proyek_id');
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
        Schema::dropIfExists('purchase_order');
    }
}
