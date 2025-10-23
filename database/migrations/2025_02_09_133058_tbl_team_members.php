<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblTeamMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_team_members', function (Blueprint $table) {
            $table->id('member_id');
            $table->integer('user_id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('rolep_id');
            $table->timestamp('assigned_date')->useCurrent();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('user_id')->references('user_id')->on('tbl_user')->onDelete('cascade');
            $table->foreign('project_id')->references('project_id')->on('tbl_projects')->onDelete('cascade');
            $table->foreign('rolep_id')->references('rolep_id')->on('tbl_role_projects')->onDelete('cascade');
            
            // Prevent duplicate assignments
            $table->unique(['user_id', 'project_id', 'rolep_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_team_members');
    }
}
