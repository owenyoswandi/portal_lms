<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_projects', function (Blueprint $table) {
            $table->id('project_id');
            $table->string('project_name');
            $table->text('project_desc')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_projects');
    }
}