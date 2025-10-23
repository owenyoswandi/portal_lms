<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_subtopic_test extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tbl_subtopic_test';
    protected $fillable = [
        'test_st_id',
        'test_pertanyaan_id'
    ];
}
