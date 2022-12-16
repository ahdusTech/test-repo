<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_templates', function (Blueprint $table) {

            $table->id();
            $table->string('template_name');
            $table->string('sender_name')->nullable();
            $table->string('sender_email')->nullable();
            $table->text('bcc')->nullable()->comment('Send the emails to these as Blind Carbor Copy');
            $table->string('email_subject')->nullable();
            $table->longText('email_text')->nullable();
            $table->boolean('default')->default(0);
            $table->string('type')->nullable();
            $table->string('lang')->nullable();
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
        Schema::dropIfExists('email_templates');
    }
}
