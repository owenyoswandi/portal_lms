<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_activities extends Model
{
    use HasFactory;
    protected $primaryKey  = 'activity_id';
    protected $table = 'tbl_activities';
    protected $fillable = [
        'activity_id',
        'phase_id',
        'activity_name',
        'activity_desc',
        'start_date',
        'end_date',
        'complexity',
        'status',
        'actual_start_date',
        'actual_end_date',
        'duration',
        'completion',
        'user_id',
    ];

    public function phase()
    {
        return $this->belongsTo(tbl_phase::class, 'phase_id');
    }
}
