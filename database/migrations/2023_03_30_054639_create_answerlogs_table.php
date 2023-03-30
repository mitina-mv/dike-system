<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answerlogs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->float('answerlog_mark');
            $table->foreignId('question_id')
                ->constrained('questions');
            $table->foreignId('testlog_id')
                ->constrained('testlogs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answerlogs');
    }
}
