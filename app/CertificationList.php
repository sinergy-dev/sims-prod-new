<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class CertificationList extends Model
{

    protected $table = 'tb_certification_list';
    protected $fillable = [
        'nik',
        'vendor',
        'exam_purpose',
        'status_renewal',
        'lead_id',
        'pid',
        'project_title',
        'nik_manager',
        'is_rejected',
        'reject_note',
        'status',
        'is_circular',
        'circular_on',
        'is_approved',
        'project_phase'
    ];
    public $timestamps = true;
}