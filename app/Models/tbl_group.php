<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_group extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'group_id';
    protected $table = 'tbl_group';
    protected $fillable = [
        'group_id',
        'group_name',
        'group_logo',
        'group_email',
        'group_phone',
        'group_alamat',
        'group_creaby',
        'group_modiby',
        'group_creadate',
        'group_modidate'
    ];

    public function accesses()
    {
        return $this->hasMany(tbl_group_access::class, 'group_id', 'group_id');
    }

    public function members()
    {
        return $this->hasMany(tbl_group_member::class, 'group_id', 'group_id');
    }
}
