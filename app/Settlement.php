<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Settlement extends Model
{
    protected $table = 'tb_settlement';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'no_monreq',
        'issuane',
        'nominal',
        'status',
        'date',
        'parent_id_drive',
        'isCircular',
        'date_add'
    ];

    public $timestamps = false;

    protected $appends = ['notes_settlement','circularBy'];

    public function getNotesSettlementAttribute()
    {
        $data = DB::table('tb_settlement_notes')
            ->join('tb_settlement','tb_settlement.id','=','tb_settlement_notes.id_settlement')
            ->select(
                'sub_category',
                'notes'
            )
            ->where('tb_settlement_notes.status','NEW')
            ->where('tb_settlement_notes.id_settlement', $this->id)
            ->get();

        return $data;
    }

    public function getCircularByAttribute()
    {
        $data = DB::table('tb_settlement')->where('id',$this->id)->first();

        $unapproved = DB::table('tb_settlement_activity')
            ->where('tb_settlement_activity.id_settlement', $this->id)
            ->where('tb_settlement_activity.status', "UNAPPROVED")
            ->orderBy('tb_settlement_activity.id',"DESC")
            ->get();

        $tb_settlement_activity = DB::table('tb_settlement_activity')
            ->where('tb_settlement_activity.id_settlement', $this->id);

        if(count($unapproved) != 0){
            $tb_settlement_activity->where('tb_settlement_activity.id','>',$unapproved->first()->id);
        }
            
        $tb_settlement_activity->where(function($query){
            $query->where('tb_settlement_activity.status', 'CIRCULAR')
                ->orWhere('tb_settlement_activity.status', 'APPROVED');
        });

        // return $tb_settlement_activity->get();

        $sign = User::join('role_user', 'role_user.user_id', '=', 'users.nik')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select(
                    'users.name', 
                    'roles.name as position', 
                    'ttd',
                    'email',
                    'avatar',
                    DB::raw("IFNULL(SUBSTR(`temp_tb_settlement_activity`.`date_time`,1,10),'-') AS `date_sign`"),
                    DB::raw('IF(ISNULL(`temp_tb_settlement_activity`.`date_time`),"false","true") AS `signed`')
                )
            ->leftJoinSub($tb_settlement_activity,'temp_tb_settlement_activity',function($join){
                // $join->on("temp_tb_pr_activity.operator","=","users.name");
                $join->on("users.name","LIKE",DB::raw("CONCAT('%', temp_tb_settlement_activity.operator, '%')"));
            })
            ->where('id_company', '1')
            ->where('status_karyawan','!=','dummy');

        foreach ($sign->get() as $key => $value) {
            $sign->whereRaw("(`roles`.`name` = 'Project Management Manager' OR `roles`.`name` = 'VP Project Management' OR `roles`.`name` = 'Chief Operating Officer')")
            ->orderByRaw('FIELD(position, "Project Management Manager", "VP Project Management", "Chief Operating Officer")');
        }

        return empty($sign->get()->where('signed','false')->first()->name)?'-':$sign->get()->where('signed','false')->first()->name;
    }

}
