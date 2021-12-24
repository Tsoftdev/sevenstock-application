<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150)->nullable();
            $table->integer('age')->nullable();
            $table->string('phonenumber1', 150)->nullable();
            $table->string('phonenumber2', 150)->nullable();
            $table->string('email', 150)->nullable();
            $table->integer('city_id')->nullable()->unsigned();
            $table->foreign('city_id')->nullable()->references('id')->on('cities');
            $table->text('address')->nullable();
            $table->integer('level')->nullable();
            $table->integer('status_id')->nullable();
            $table->date('first_visited_date')->nullable();
            $table->text('note')->nullable();
            $table->integer('routesOfKnownID')->nullable()->unsigned();
            $table->foreign('routesOfKnownID')->nullable()->references('id')->on('routeknowns');
            
            $table->string('investable_liquid_funds', 250)->nullable();
            $table->string('finance', 250)->nullable();
            $table->string('stock_investment_experience', 250)->nullable();
            $table->string('return_on_investment', 250)->nullable();
            $table->string('profit_lose', 250)->nullable();
            $table->string('investment_path', 250)->nullable();
            
            $table->integer('createdBy')->nullable()->unsigned();
            $table->foreign('createdBy')->nullable()->references('id')->on('users');
            $table->integer('updatedBy')->nullable()->unsigned();
            $table->foreign('updatedBy')->nullable()->references('id')->on('users');
            $table->date('date');
            
            $table->enum('isActive', ['Y', 'N'])->default('Y');
            $table->enum('gender', ['M', 'F', 'O'])->default('M');
            $table->integer('customerGroupID')->nullable()->unsigned();
            $table->foreign('customerGroupID')->nullable()->references('id')->on('customergroups');
            $table->string('stockBroker', 150)->nullable();
            $table->string('accountNumber', 150)->nullable();
            $table->enum('isDelete', ['Y', 'N'])->default('N');
            $table->enum('isApproved', ['Y', 'N'])->default('Y');
            $table->integer('groupid')->nullable();
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
        Schema::dropIfExists('customers');
    }
}