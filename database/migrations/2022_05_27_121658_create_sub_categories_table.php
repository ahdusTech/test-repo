<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('image_singlePage')->nullable();
            $table->string('image_title')->nullable();
            $table->string('image_price')->nullable();
            $table->integer('sort')->nullable();
            $table->string('status')->nullable();
            $table->string('dpiImage')->nullable();
            $table->string('originalImage')->nullable();
            $table->integer('height')->nullable();
            $table->integer('width')->nullable();


            $table->unsignedBigInteger('category_id');

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('sub_categories');
    }
}
