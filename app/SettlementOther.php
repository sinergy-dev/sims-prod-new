<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettlementOther extends Model
{
    protected $table = 'tb_settlement_others';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'sub_category',
        'id_settlement',
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
