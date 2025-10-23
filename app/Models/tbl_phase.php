<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_phase extends Model
{
    use HasFactory;
    protected $primaryKey = 'phase_id';
    protected $table = 'tbl_phases';
    protected $fillable = [
        'phase_id',
        'project_id',
        'phase_name',
        'phase_desc',
        'status',
        'start_date',
        'end_date',
        'status'
    ];

    public function project()
    {
        return $this->belongsTo(tbl_project::class, 'project_id');
    }

    public function activities()
    {
        return $this->hasMany(tbl_activities::class, 'phase_id');
    }

    public function calculateCompletion()
    {
        $activities = $this->activities;
        if ($activities->isEmpty()) {
            return 0;
        }

        $totalCompletion = 0;
        $activityCount = $activities->count();

        foreach ($activities as $activity) {
            $completionValue = str_replace('%', '', $activity->completion);
            $totalCompletion += (float)$completionValue;
        }

        return $activityCount > 0 ? round($totalCompletion / $activityCount, 2) : 0;
    }
}
