<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblTaskAssigments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_task_assignments', function (Blueprint $table) {
            $table->id('assignment_id');
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('member_id');
            $table->timestamp('assigned_date')->useCurrent();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('task_id')->references('task_id')->on('tbl_tasks')->onDelete('cascade');
            $table->foreign('member_id')->references('member_id')->on('tbl_team_members')->onDelete('cascade');
            
            // Prevent duplicate assignments
            $table->unique(['task_id', 'member_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_task_assignments');
    }
}
