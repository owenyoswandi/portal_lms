<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_topic extends Model
{
    use HasFactory;
	public $timestamps = false;
    protected $primaryKey = 't_id';
    protected $table = 'tbl_topic';
    protected $fillable = [
        't_id',
        't_p_id',
        't_name',
        't_creadate',
        't_modidate'
    ];

    public function subtopics()
    {
        return $this->hasMany(tbl_subtopic::class, 'st_t_id');
    }
}
