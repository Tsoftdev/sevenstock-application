<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employeeId')->nullable()->unsigned();
            $table->foreign('employeeId')->nullable()->references('id')->on('employees')->onDelete('cascade');
            $table->string('category', 255)->nullable();
            $table->string('invoicenumber', 255)->nullable();
            $table->integer('companyId')->nullable()->unsigned();
            $table->foreign('companyId')->nullable()->references('id')->on('companies')->onDelete('cascade');
            $table->enum('status', ['A', 'P', 'R', 'PP'])->default('P');
            $table->enum('payment', ['CD', 'CH'])->default('CH');
            $table->date('issueddate')->nullable();
            $table->string('bankname', 255)->nullable();
            $table->string('bankinformation', 255)->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('receipts');
    }
}
