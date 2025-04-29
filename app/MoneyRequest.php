<?php

namespace App;
use DB;
use App\User;

use Illuminate\Database\Eloquent\Model;

class MoneyRequest extends Model
{
    protected $table = 'tb_money_request';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'no_monreq',
        'issuane',
        'nominal',
        'account_number',
        'account_name',
        'req_transfer_date',
        'status',
        'date',
        'parent_id_drive',
        'proof_of_transfer',
        'date_add'
    ];

    public $timestamps = false;

    protected $appends = ['circularBy'];

    public function getCircularByAttribute()
    {
        $data = DB::table('tb_money_request')->where('id',$this->id)->first();

        $unapproved = DB::table('tb_money_request_activity')
            ->where('tb_money_request_activity.id_money_request', $this->id)
            ->where('tb_money_request_activity.status', "UNAPPROVED")
            ->orderBy('tb_money_request_activity.id',"DESC")
            ->get();

        $tb_money_request_activity = DB::table('tb_money_request_activity')
            ->where('tb_money_request_activity.id_money_request', $this->id);

        if(count($unapproved) != 0){
            $tb_money_request_activity->where('tb_money_request_activity.id','>',$unapproved->first()->id);
        }
            
        $tb_money_request_activity->where(function($query){
            $query
                ->where('tb_money_request_activity.status', 'CIRCULAR')
                ->orWhere('tb_money_request_activity.status', 'APPROVED');
        });

        $sign = User::join('role_user', 'role_user.user_id', '=', 'users.nik')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select(
                    'users.name', 
                    'roles.name as position', 
                    'ttd',
                    'email',
                    'avatar',
                    DB::raw("IFNULL(SUBSTR(`temp_tb_money_request_activity`.`date_time`,1,10),'-') AS `date_sign`"),
                    DB::raw('IF(ISNULL(`temp_tb_money_request_activity`.`date_time`),"false","true") AS `signed`')
                )
            ->leftJoinSub($tb_money_request_activity,'temp_tb_money_request_activity',function($join){
                // $join->on("temp_tb_pr_activity.operator","=","users.name");
                $join->on("users.name","LIKE",DB::raw("CONCAT('%', temp_tb_money_request_activity.operator, '%')"));
            })
            ->where('id_company', '1')
            ->where('status_karyawan','!=','dummy');

        foreach ($sign->get() as $key => $value) {
            $sign->whereRaw("(`roles`.`name` = 'Project Management Office Manager' OR `roles`.`name` = 'VP Program & Project Management' OR `roles`.`name` = 'Chief Operating Officer')")
            ->orderByRaw('FIELD(position, "Project Management Office Manager", "VP Program & Project Management", "Chief Operating Officer")');
        }

        return empty($sign->get()->where('signed','false')->first()->name)?'-':$sign->get()->where('signed','false')->first()->name;
    }
}
