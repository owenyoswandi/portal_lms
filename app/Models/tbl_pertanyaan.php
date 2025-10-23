<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_pertanyaan extends Model
{
    use HasFactory;
	public $timestamps = false;
    protected $table = 'tbl_pertanyaan';
	// Tentukan nama kolom primary key
    protected $primaryKey = 'pertanyaan_id';
    protected $fillable = [
        'pertanyaan_id','course_id','kategori','teks_pertanyaan','tipe_pertanyaan','maks_nilai'
    ];    
}
