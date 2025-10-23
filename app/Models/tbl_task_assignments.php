<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_task_assignments extends Model
{
    use HasFactory;
    protected $table = "tbl_task_assignments";
    protected $primary_key = "assignment_id";
    public $fillable = [
        'assignment_id',
        'task_id',
        'member_id',
        'assigned_date',
        'created_at',
        'updated_at'
    ];

    public function task()
    {
        return $this->belongsTo(tbl_tasks::class, 'task_id');
    }

    public function team_member()
    {
        return $this->belongsTo(tbl_team_members::class, 'member_id');
    }
}
