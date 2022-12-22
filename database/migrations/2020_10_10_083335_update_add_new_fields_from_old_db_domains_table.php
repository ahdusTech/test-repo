<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddNewFieldsFromOldDbDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->integer('adomino_com_id')->nullable();
            $table->string('title')->nullable();
            $table->json('info')->nullable();
            $table->string('landingpage_mode', 50)->default('request_offer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->dropColumn(['adomino_com_id', 'title', 'info', 'landingpage_mode']);
        });
    }
}
