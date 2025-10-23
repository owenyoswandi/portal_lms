<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_feedback extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'feedback_id';
    protected $table = 'tbl_feedback';
    protected $fillable = [
        'feedback_id',
        'subtopic_id',
        'course_id',
        'user_id',
        'feedback',
        'rating',
        'created_at',
        'modified_at'
    ];
}
