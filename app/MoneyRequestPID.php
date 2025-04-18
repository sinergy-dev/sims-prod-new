<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyRequestPID extends Model
{
    protected $table = 'tb_money_request_pid';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_money_request',
        'pid',
        'nominal',
        'start_date',
        'end_date',
        'team_name',
        'event_detail',
        'date_add'
    ];

    public $timestamps = false;
}
