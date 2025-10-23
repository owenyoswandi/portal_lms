<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_detail_profile extends Model
{
	public $timestamps = false;
    protected $primaryKey = 'detail_id';
	protected $table = 'tbl_detail_profile';
    protected $fillable = [
		'detail_id','user_id','jenjang_pendidikan','nama_institusi','tahun_masuk','tahun_lulus','gelar','bidang_studi','nama_perusahaan','posisi','periode_mulai','periode_selesai','tanggung_jawab','linkedin','twitter','instagram','facebook','github','nama_keahlian','sumber_keahlian','sertifikasi'
    ];

}
