<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_discipline', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained('users');
            $table->foreignId('discipline_id')
                ->constrained('disciplines');
            $table->string('key', 100);
            $table->primary(['user_id', 'discipline_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_discipline');
    }
}
