<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_team_members extends Model
{
    use HasFactory;
    protected $table = "tbl_team_members";
    protected $primary_key = "member_id";
    public $fillable = [
        'member_id',
        'user_id',
        'rolep_id',
        'project_id',
        'assigned_date',
        'created_at',
        'updated_at'
    ];

    public function role()
    {
        return $this->belongsTo(tbl_role_project::class, 'rolep_id');
    }

    public function user()
    {
        return $this->belongsTo(tbl_user::class, 'user_id');
    }
}
