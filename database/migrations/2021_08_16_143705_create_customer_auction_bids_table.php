<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAuctionBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_auction_bids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('customer_auction_id')->nullable();
            $table->unsignedBigInteger('auction_id')->nullable();
            $table->string('bid_type')->nullable();
            $table->integer('current_price')->nullable();
            $table->integer('bid_price')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('customer_auction_id')->references('id')->on('customer_auctions')->onDelete('cascade');
            $table->foreign('auction_id')->references('id')->on('auctions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_auction_bids');
    }
}
