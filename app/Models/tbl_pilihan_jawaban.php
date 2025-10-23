<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_pilihan_jawaban extends Model
{
    use HasFactory;
	public $timestamps = false;
    protected $table = 'tbl_pilihan_jawaban';
	protected $primaryKey = 'pilihan_id';
    protected $fillable = [
        'pilihan_id','pertanyaan_id','teks_pilihan','is_jawaban_benar','maks_nilai'
    ];
}
