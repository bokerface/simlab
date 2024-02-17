<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SurveyQuestionItemVariants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_question_item_variants', function (Blueprint $table) {
            $table->id('survey_question_variant_id');
            $table->foreignId('survey_question_id');
            $table->string('variant', 255);
            $table->smallInteger('sort_order')->nullable(true);
            $table->smallInteger('vote')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_question_item_variants');
    }
}
