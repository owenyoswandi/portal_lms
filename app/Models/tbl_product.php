<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_product extends Model
{
	use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'p_id';
    protected $table = 'tbl_product';
    protected $fillable = [
        'p_id',
        'p_jenis',
        'p_judul',
        'p_deskripsi',
        'p_img',
        'p_id_lms',
        'p_url_lms',
        'p_harga',
        'p_status',
        'p_created_date',
        'p_modified_date',
        'p_start_date',
        'p_end_date'
    ];

    // Relationship with user
    public function users()
    {
        return $this->belongsToMany(tbl_user::class, 'transactions');
    }
    // Relationship with transaction
    public function transactions()
    {
        return $this->hasMany(tbl_transaction::class, 't_p_id');
    }
}
