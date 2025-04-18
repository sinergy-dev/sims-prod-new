<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimOther extends Model
{
    protected $table = 'tb_claim_others';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'sub_category',
        'id_claim',
        'pid',
        'description',
        'name',
        'role',
        'nominal',
        'image',
        'receipt',
        'notes',
        'date_add',
        'date'
    ];

    public $timestamps = false;
}
