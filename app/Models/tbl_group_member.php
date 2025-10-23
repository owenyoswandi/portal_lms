<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_group_member extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tbl_group_member';
    protected $fillable = [
        'group_id',
        'user_id'
    ];
}
