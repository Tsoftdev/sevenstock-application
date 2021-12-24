<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('companyName', 255)->nullable();
            $table->string('ownerName', 255)->nullable();
            $table->date('consultdate')->nullable();
            $table->date('reviewdate')->nullable();
            $table->date('enddate')->nullable();
            $table->string('companylogo',100)->nullable();
            $table->string('createdBy', 30);
            $table->enum('isApproved', ['Y', 'N'])->default('Y');
            $table->enum('isActive', ['Y', 'N'])->default('N');
            $table->enum('isDelete', ['Y', 'N'])->default('N');
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
        Schema::dropIfExists('companies');
    }
}
