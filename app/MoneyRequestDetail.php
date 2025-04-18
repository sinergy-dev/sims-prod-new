<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyRequestDetail extends Model
{
    protected $table = 'tb_money_request_detail';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_money_req_pid',
        'category',
        'qty',
        'unit',
        'price',
        'total_price',
        'date_add'
    ];

    public $timestamps = false;
}
