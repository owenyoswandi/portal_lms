<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_hasil_test_detail extends Model
{
    use HasFactory;
	public $timestamps = false;
    protected $table = 'tbl_hasil_test_detail';
    protected $primaryKey = 'hasil_id_detail';
    protected $fillable = [
        'hasil_id_detail','hasil_id','pertanyaan_id','jawaban_id','jawaban_isian','nilai_jawaban_isian'
    ];
}
