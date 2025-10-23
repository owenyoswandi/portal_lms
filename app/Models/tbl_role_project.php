<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_role_project extends Model
{
    use HasFactory;
    protected $primaryKey = 'rolep_id';
    protected $table = 'tbl_role_projects';
    protected $fillable = [
        'rolep_id',
        'project_id',
        'rolep_name',
        'rolep_desc',
        'add_activity_ability',
        'mark_done_activity'
    ];

    public function project()
    {
        return $this->belongsTo(tbl_project::class, 'project_id');
    }
}
