<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_submission extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'sm_id';
    protected $table = 'tbl_submission';
    protected $fillable = [
        'sm_id',
        'sm_st_id',
        'sm_user_id',
        'sm_file',
        'sm_comment',
        'sm_status',
        'sm_grade',
        'sm_feedback_comment',
        'sm_creadate',
        'sm_modidate'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(tbl_user::class, 'sm_user_id');
    }
}
