<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->boolean('question_private')->default(0);
            $table->string('question_text', 511);
            $table->jsonb('question_settings')->default("{}");
            $table->foreignId('org_id')
                ->constrained('orgs');
            $table->foreignId('user_id')
                ->constrained('users');
            $table->foreignId('discipline_id')
                ->constrained('disciplines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
