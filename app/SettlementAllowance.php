<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettlementAllowance extends Model
{
    protected $table = 'tb_settlement_allowance';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'sub_category',
        'id_settlement',
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
