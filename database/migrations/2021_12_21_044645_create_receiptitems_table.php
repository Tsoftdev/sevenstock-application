<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receiptitems', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('receiptId')->nullable()->unsigned();
            $table->foreign('receiptId')->nullable()->references('id')->on('receipts')->onDelete('cascade');
            $table->string('item', 255)->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('price')->nullable();
            $table->integer('total')->nullable();
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
        Schema::dropIfExists('receiptitems');
    }
}
