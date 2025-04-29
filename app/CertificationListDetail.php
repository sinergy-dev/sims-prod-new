<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class CertificationListDetail extends Model
{
    protected $table = 'tb_certification_list_detail';
    protected $fillable = [
        'certification_list_id',
        'participant_name',
        'participant_nik',
        'exam_name',
        'exam_code',
        'level',
        'exam_deadline',
        'exam_date',
        'expired_date',
        'status_exam',
        'certificate',
        'departement',
        'remind_expired'
    ];

    public $timestamps = true;
}