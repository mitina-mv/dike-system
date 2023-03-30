<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testlogs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('testlog_date');
            $table->float('testlog_mark')->nullable();
            $table->timestamp('testlog_time')->nullable();
            $table->foreignId('user_id')
                ->constrained('users');
            $table->foreignId('test_id')
                ->constrained('tests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testlogs');
    }
}
