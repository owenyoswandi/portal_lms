<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_transaction extends Model
{
    use HasFactory;
	public $timestamps = false;
    protected $table = 'tbl_transaction';
    protected $fillable = [
        't_id', 't_transaction_id', 't_code',   't_user_id', 't_p_id', 't_type', 't_amount', 't_status', 't_user_proof', 't_admin_proof', 't_created_date','t_modified_date'
    ];

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(tbl_user::class, 't_user_id');
    }
    // Relationship with course
    public function course()
    {
        return $this->belongsTo(tbl_product::class, 't_p_id');
    }
}
