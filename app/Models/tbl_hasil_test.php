<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_hasil_test extends Model
{
    use HasFactory;
	public $timestamps = false;
    protected $table = 'tbl_hasil_test';
    protected $primaryKey = 'hasil_id';
    protected $fillable = [
        'hasil_id','peserta_id','subtopic_id','waktu_respon', 'waktu_submit'
    ];
}
