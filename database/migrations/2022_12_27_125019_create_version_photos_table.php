<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersionPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('version_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('photo_id');
            $table->foreign('photo_id')->references('id')->on('photos')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            $table->string('image_name')->nullable();
            $table->integer('price')->nullable();
            $table->string('color')->nullable();
            $table->integer('counter')->nullable();
            $table->string('WatermMarked_image')->nullable();
            $table->string('small_thumbnail')->nullable();
            $table->string('singleImage')->nullable();
            $table->string('original_image')->nullable();
            $table->string('Edit_original_image')->nullable();



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
        Schema::dropIfExists('version_photos');
    }
}
