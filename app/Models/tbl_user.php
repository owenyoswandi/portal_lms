<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_user extends Model
{
	use HasFactory;
	public $timestamps = false;
    protected $primaryKey = 'user_id';
	protected $table = 'tbl_user';
    protected $fillable = [
        'user_id',
		'username',
		'password',
		'nama',
		'alamat',
		'no_hp',
		'email',
		'jk',
		'tgl_lhr',
		'role',
		'updated_at',
		'api_token',
		'token_type',
		'provinsi',
		'kelurahan',
		'kecamatan',
		'kota_kab',
		'rumah_sakit'
    ];

	public function transactions()
    {
        return $this->hasMany(tbl_transaction::class, 't_user_id');
    }
	
    public function courses()
    {
        return $this->belongsToMany(tbl_product::class, 'transactions');
    }

	public function submissions()
    {
        return $this->hasMany(tbl_submission::class, 'sm_user_id');
    }

}
