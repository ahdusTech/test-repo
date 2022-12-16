<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColoumsToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('phone_code')->after('email')->nullable();
            $table->string('phone_number')->after('phone_code')->nullable();
            $table->boolean('phone_number_verified')->after('phone_number')->nullable();
            $table->string('verification_document')->after('phone_number_verified')->nullable();
            $table->boolean('account_approved')->after('verification_document')->nullable();
            $table->string('tax_no')->unique()->after('lang')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('phone_code');
            $table->dropColumn('phone_number');
            $table->dropColumn('verification_document');
            $table->dropColumn('phone_number_verified');
            $table->dropColumn('account_approved');
            $table->dropColumn('tax_no');
        });
    }
}
