<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class CertificationListActivity extends Model
{
    protected $table = 'tb_certification_list_activity';
    protected $fillable = ['certification_list_id','operator','activity','status','date'];
    public $timestamps = false;
}