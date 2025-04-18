<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SettlementPID extends Model
{
    protected $table = 'tb_settlement_pid';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_settlement',
        'pid',
        'nominal',
        'date_add'
    ];

    protected $appends = ['name_project'];

    public function getNameProjectAttribute()
    {
        $data = DB::table('sales_lead_register')
            ->join('tb_id_project','tb_id_project.lead_id','=','sales_lead_register.lead_id')
            ->join('tb_contact', 'tb_contact.id_customer', '=', 'sales_lead_register.id_customer')
            ->select(
                    DB::raw('CONCAT(tb_contact.code," - ",tb_id_project.name_project) AS name_project'),
                    DB::raw('CONCAT(tb_id_project.id_project," - ",tb_id_project.name_project) AS id_project_name'),
                    'code as code_company'
            )
            ->where('tb_id_project.id_project', $this->pid)
            ->first();

        return $data;
    }

    public $timestamps = false;
}
