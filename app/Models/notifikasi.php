<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notifikasi extends Model
{
	public $timestamps = false;
    protected $table = 'notifikasi';
    protected $fillable = [
        'not_id','not_userid','not_deskripsi','not_statusbaca','not_created','not_modified'
    ];
}
