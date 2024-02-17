<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SurveyParticipants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_participants', function (Blueprint $table) {
            $table->id('participant_id');
            $table->foreignId('survey_id');
            $table->string('user_id');
            $table->smallInteger('role');
            $table->dateTime('start_date')->nullable(true);
            $table->dateTime('finish_date')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_participants');
    }
}
