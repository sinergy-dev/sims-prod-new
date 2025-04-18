<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimTransport extends Model
{
    protected $table = 'tb_claim_transport';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'sub_category',
        'id_claim',
        'pid',
        'date',
        'time',
        'name',
        'role',
        'nominal',
        'location',
        'from_transport',
        'to_transport',
        'driver_name',
        'link_drive',
        'date_add',
        'notes'
    ];

    public $timestamps = false;
}
