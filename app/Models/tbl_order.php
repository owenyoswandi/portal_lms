<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbl_order extends Model
{
	public $timestamps = false;
    protected $table = 'tbl_order';
    protected $fillable = [
        'or_id', 'p_id', 'user_id',   'or_status', 'or_created_date', 'or_modified_date'
    ];
}
