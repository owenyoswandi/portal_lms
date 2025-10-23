<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_project extends Model
{
    use HasFactory;
    protected $primaryKey = 'project_id';
    protected $table = 'tbl_projects';
    protected $fillable = [
        'project_id',
        'user_id',
        'project_name',
        'project_desc',
        'start_date',
        'end_date',
        'status',
        'created_at',
        'updated_at'
    ];

    public function phases()
    {
        return $this->hasMany(tbl_phase::class, 'project_id');
    }

    public function role_projects()
    {
        return $this->hasMany(tbl_role_project::class, 'project_id');
    }
    public function team_members()
    {
        return $this->hasMany(tbl_team_members::class, 'project_id');
    }

    public function calculateCompletion(){
        $phases = $this->phases;
        if($phases->isEmpty()){
            return 0;
        }

        $totalCompletion = 0;
        $phaseCount= $phases->count();

        foreach ($phases as $phase) {
            $totalCompletion += $phase->calculateCompletion();
        }
        return $phaseCount > 0 ? round($totalCompletion / $phaseCount, 2) : 0; 
    }

}
