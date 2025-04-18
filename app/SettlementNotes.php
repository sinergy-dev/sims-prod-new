<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettlementNotes extends Model
{
    protected $table = 'tb_settlement_notes';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_sub_category',
        'id_settlement',
        'notes',
        'status',
        'date_add'
    ];

    public $timestamps = false;
}
