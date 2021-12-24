<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicephotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoicephotos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('receiptId')->nullable()->unsigned();
            $table->foreign('receiptId')->nullable()->references('id')->on('receipts')->onDelete('cascade');
            $table->string('photo', 255)->nullable();
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
        Schema::dropIfExists('invoicephotos');
    }
}
