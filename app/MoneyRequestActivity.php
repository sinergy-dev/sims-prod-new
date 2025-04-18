<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyRequestActivity extends Model
{
    protected $table = 'tb_money_request_activity';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'date_time',
        'id_money_request',
        'status',
        'operator',
        'activity'
    ];
    public $timestamps = false;
}
