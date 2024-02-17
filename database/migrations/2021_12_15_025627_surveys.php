<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Surveys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id('id_survey');
            $table->string('survey_name', 255);
            $table->string('survey_description', 255);
            $table->timestamp('created_at')->nullable(true);
            $table->dateTime('expires_at')->nullable(true);
            $table->smallInteger('is_active')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys');
    }
}
