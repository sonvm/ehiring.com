<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecruitingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruitings', function (Blueprint $table) {
            $table->id();
            $table->integer('owner_id');
            $table->string('title');
            $table->text('description');
            $table->integer('criteria');
            $table->dateTime('starting_date');
            $table->dateTime('closing_date');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recruitings');
    }
}
