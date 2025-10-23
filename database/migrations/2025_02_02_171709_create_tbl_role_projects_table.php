<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRoleProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_role_projects', function (Blueprint $table) {
            $table->id('rolep_id');
            $table->unsignedBigInteger('project_id');
            $table->string('rolep_name');
            $table->text('rolep_desc')->nullable();
            $table->timestamps();

            $table->foreign('project_id')->references('project_id')->on('tbl_projects')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_role_projects');
    }
}
