<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettlementTransport extends Model
{
    protected $table = 'tb_settlement_transport';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'sub_category',
        'id_settlement',
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
