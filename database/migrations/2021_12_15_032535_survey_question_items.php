<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SurveyQuestionItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_question_items', function (Blueprint $table) {
            $table->id('survey_question_id');
            $table->foreignId('survey_id');
            $table->string('question', 255);
            $table->smallInteger('question_type_id');
            $table->smallInteger('is_active');
            $table->smallInteger('is_required')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_question_items');
    }
}
