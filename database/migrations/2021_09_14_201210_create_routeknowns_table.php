<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRouteknownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routeknowns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('routeName', 30);
            $table->string('createdBy', 30);
            $table->enum('isApproved', ['Y', 'N'])->default('Y');
            $table->enum('isActive', ['Y', 'N'])->default('Y');
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
        Schema::dropIfExists('routeknowns');
    }
}
