<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tasks', function (Blueprint $table) {
            $table->id('task_id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('phase_id');
            $table->string('task_name');
            $table->text('task_desc')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('pending');
            $table->string('priority')->default('medium');
            $table->timestamps();

            // Foreign keys
            $table->foreign('project_id')->references('project_id')->on('tbl_projects')->onDelete('cascade');
            $table->foreign('phase_id')->references('phase_id')->on('tbl_phases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_tasks');
    }
}
