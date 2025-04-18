<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettlementEntertain extends Model
{
    protected $table = 'tb_settlement_entertain';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'sub_category',
        'id_settlement',
        'pid',
        'resto_name',
        'date',
        'role',
        'time',
        'team_internal',
        'team_eksternal',
        'location',
        'nominal',
        'name',
        'role',
        'image',
        'receipt',
        'receipt_2',
        'notes',
        'date_add'
    ];

    public $timestamps = false;
}
