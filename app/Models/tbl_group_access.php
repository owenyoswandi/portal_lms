<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_group_access extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tbl_group_access';
    protected $fillable = [
        'group_id',
        'product_id'
    ];
}
