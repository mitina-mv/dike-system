<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUncorrectTextAnswersToTestlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('testlogs', function (Blueprint $table) {
            $table->json('uncorrect_answers')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('testlogs', function (Blueprint $table) {
            $table->dropColumn('uncorrect_answers');
        });
    }
}
