<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimEntertain extends Model
{
    protected $table = 'tb_claim_entertain';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'sub_category',
        'id_claim',
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
        'notes',
        'date_add'
    ];

    public $timestamps = false;
}
