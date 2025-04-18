<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimActivity extends Model
{
    protected $table = 'tb_claim_activity';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'date_time',
        'id_claim',
        'status',
        'operator',
        'activity'
    ];

    public $timestamps = false;
}
