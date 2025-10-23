<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_tasks extends Model
{
    use HasFactory;
    protected $table = "tbl_tasks";
    protected $primary_key = "task_id";
    public $fillable = [
        'task_id',
        'project_id',
        "phase_id",
        "task_name",
        "task_desc",
        "start_date",
        "end_date",
        "status",
        "priority",
        "level",
        "created_at",
        "updated_at"
    ];
}
