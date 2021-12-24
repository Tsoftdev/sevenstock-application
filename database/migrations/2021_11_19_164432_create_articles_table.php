<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id')->nullable()->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->text('title')->collation('utf8_unicode_ci');;
            $table->string('slug', 300)->nullable()->collation('utf8_unicode_ci');;
            $table->longText('description')->collation('utf8_unicode_ci');
            $table->string('website_url',200)->nullable()->collation('utf8_unicode_ci');;
            $table->text('image')->nullable()->collation('utf8_unicode_ci');;
            $table->string('name',250)->collation('utf8_unicode_ci');;
            $table->enum('comment_on_off',['on', 'off'])->default('off')->collation('utf8_unicode_ci');
            $table->text('comment_title')->nullable();
            $table->longText('comment_description')->nullable()->collation('utf8_unicode_ci');;
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
        Schema::dropIfExists('articles');
    }
}
