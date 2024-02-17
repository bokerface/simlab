<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SurveyAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_answers', function (Blueprint $table) {
            $table->id('survey_answer_id');
            $table->foreignId('participant_id');
            $table->foreignId('survey_id');
            $table->foreignId('survey_question_id');
            $table->foreignId('survey_question_variant_id')->nullable(true);
            $table->string('question_item_other')->nullable(true);
            $table->string('answer_text')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_answers');
    }
}
