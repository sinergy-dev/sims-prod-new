<?php

namespace App\Console\Commands;
use DB;
use Carbon\Carbon;

use Illuminate\Console\Command;

class remindPKWT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remindPKWT:remindpkwt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind PKWT Karyawan';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.name','roles.name as role','status_karyawan','status_kerja','akhir_kontrak','nik','email')->where('id_company','1')->get();

        foreach ($data as $key => $value) {
            if (!$value->akhir_kontrak) continue;

            $cek_role = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.name','roles.name as name_role','group','mini_group','nik','email')->where('nik',$value->nik)->first();
            $territory = DB::table('users')->select('id_territory')->where('nik', $value->nik)->first();
            $ter = $territory->id_territory;
            $division = DB::table('users')->select('id_division')->where('nik', $value->nik)->first();
            $div = $division->id_division;

            $today = Carbon::now();
            $endContract = Carbon::parse($value->akhir_kontrak);
            $diffInMonths = $today->diffInMonths($endContract, false);

            $shouldSend = false;

            if ($value->status_kerja === 'Magang' && $diffInMonths === 1) {
                $shouldSend = true;
            } elseif ($value->status_kerja === 'Kontrak' && $diffInMonths === 3) {
                $shouldSend = true;
            }

            if ($cek_role->name_role == 'Account Executive') {
                $kirim = DB::table('users')->select('users.email')->where('id_territory',$ter)->where('id_position','MANAGER')->where('id_division',$div)->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
            } elseif ($cek_role->group == 'Financial And Accounting') {
                $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('status_karyawan','!=','dummy')->where('id_company','1')->where('roles.name','VP Financial & Accounting')->first();
            } else {
                if ($cek_role->name_role == 'Channeling Partnership & Marketing' || $cek_role->mini_group == 'Supply Chain Management') {
                    $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('roles.name','like', 'VP%')->where('group',$cek_role->group)->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
                } else {
                    if ($cek_role->mini_group == 'Organizational & People Development') {
                        $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')
                        ->whereRaw(
                            "(`roles`.`name` = ?)", 
                            ['VP Human Capital Management']
                        )
                        ->where('status_karyawan','!=','dummy')->where('id_company','1')->get()->pluck('email');
                    } else {
                        $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')
                            ->whereRaw(
                                "(`roles`.`mini_group` = ? AND `roles`.`name` LIKE ? AND `roles`.`name` != ? OR `roles`.`group` = ? AND `roles`.`name` LIKE ?)", 
                                [$cek_role->mini_group, '%Manager', 'Delivery Project Manager', $cek_role->group, 'VP%']
                            )
                            ->where('status_karyawan','!=','dummy')->where('id_company','1')->get()->pluck('email');
                    }
                }
            }

            $emailHc = DB::table('users')->join('role_user','users.nik','role_user.user_id')->join('roles','roles.id','role_user.role_id')->select('email')->where('group','Human Capital Management')->get()->pluck('email');

            if ($shouldSend) {
                $recipients = collect([
                    $value->email,
                    $kirim,
                    $emailHc
                ])->flatten()->filter()->unique()->toArray();

                $data = [
                    'name' => $value->name,
                    'akhir_kontrak' => $value->akhir_kontrak,
                    'role' => $value->role,
                    'status_kerja' => $value->status_kerja,
                ];

                Mail::to($recipients)->send(new \App\Mail\ReminderKontrakMail($data));
            }
        }
    }
}
