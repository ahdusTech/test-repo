<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->string('domain');
            $table->integer('start_price');
            $table->integer('end_price');
            $table->integer('days');
            $table->integer('steps');
            $table->unsignedBigInteger('fix_price')->nullable();
            $table->unsignedBigInteger('auction_area');
            $table->unsignedBigInteger('average_per_day');
            $table->longText('hired_for')->nullable()->comment('Number of days for which auction is showing value');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auctions');
    }
}
