<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColoumsToCustomerAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_auctions', function (Blueprint $table) {
            $table->string('bid_type')->after('auction_id')->nullable();
            $table->unsignedBigInteger('current_price')->after('bid_type')->nullable();
            $table->unsignedBigInteger('bid_price')->after('current_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_auctions', function (Blueprint $table) {
            $table->dropColumn('bid_type');
            $table->dropColumn('current_price');
            $table->dropColumn('bid_price');
        });
    }
}
