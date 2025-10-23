<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPhasesTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_phases', function (Blueprint $table) {
            $table->id('phase_id');
            $table->unsignedBigInteger('project_id');
            $table->string('phase_name');
            $table->text('phase_desc')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();

            $table->foreign('project_id')->references('project_id')->on('tbl_projects')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_phases');
    }
}