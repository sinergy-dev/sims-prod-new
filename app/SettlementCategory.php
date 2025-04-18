<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettlementCategory extends Model
{
    protected $table = 'tb_settlement_category';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'category',
        'title',
        'type',
        'date_add'
    ];

    public $timestamps = false;
}
