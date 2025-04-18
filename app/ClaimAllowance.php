<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimAllowance extends Model
{
    protected $table = 'tb_claim_allowance';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'sub_category',
        'id_claim',
        'pid',
        'start_date',
        'end_date',
        'role',
        'nominal',
        'name',
        'location',
        'date',
        'link_drive',
        'notes',
        'date_add'
    ];

    public $timestamps = false;
}
