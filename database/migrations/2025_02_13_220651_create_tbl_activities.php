<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_activities', function (Blueprint $table) {
            $table->id('activity_id');
            $table->unsignedBigInteger('phase_id');
            $table->string('activity_name');
            $table->text('activity_desc')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('complexity');
            $table->string('status');
            $table->time('duration');
            $table->string('completion');
            $table->integer('user_id');
            $table->timestamps();

            $table->foreign('phase_id')->references('phase_id')->on('tbl_phases')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('tbl_user')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_activities');
    }
}
