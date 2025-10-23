<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_subtopic extends Model
{
    use HasFactory;
	public $timestamps = false;
    protected $primaryKey = 'st_id';
    protected $table = 'tbl_subtopic';
    protected $fillable = [
        't_id',
        'st_t_id',
        'st_jenis',
        'st_name',
        'st_file',
        'st_start_date',
        'st_due_date',
        'st_duration',
        'st_attemp_allowed',
        'st_is_shuffle',
        'st_jumlah_shuffle',
        'st_creadate',
        'st_modidate'
    ];

    // Relationship with Topic
    public function topic()
    {
        return $this->belongsTo(tbl_topic::class, 'st_t_id');
    }

    public function subtopicTest()
    {
        return $this->hasMany(tbl_subtopict_test::class, 'st_id', 'test_st_id'); // Relasi ke tbl_subtopic_test
    }
}
