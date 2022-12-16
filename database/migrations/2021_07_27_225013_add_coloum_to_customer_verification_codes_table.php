<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColoumToCustomerVerificationCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_verification_codes', function (Blueprint $table) {
            $table->string('new_email')->after('email')->nullable();
            $table->string('phone_code')->after('new_email')->nullable();
            $table->string('phone_number')->after('phone_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_verification_codes', function (Blueprint $table) {
            $table->dropColumn('new_email');
            $table->dropColumn('phone_code');
            $table->dropColumn('phone_number');
        });
    }
}
