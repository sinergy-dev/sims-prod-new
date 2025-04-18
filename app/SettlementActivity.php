<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettlementActivity extends Model
{
    protected $table = 'tb_settlement_activity';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'date_time',
        'id_settlement',
        'status',
        'operator',
        'activity'
    ];

    public $timestamps = false;
}
