<?php


namespace App\Console\Commands;


use App\CertificationListDetail;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;


class remindExpiredCertificate extends Command
{
    /**
     * The name and signature of the console command.
     *da
     * @var string
     */
    protected $signature = 'remindExpiredCertificate:3month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind Expired Certificate Last 3 Month';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $threeMonthsLater = Carbon::now()->addMonths(3);

        $data = DB::table('tb_certification_list_detail as cld')
            ->join('users as u', 'cld.participant_nik', 'u.nik')
            ->select('u.name', 'u.email', 'cld.expired_date', 'cld.exam_name', 'cld.level','cld.id','cld.remind_expired')
            ->where('cld.status_exam', 'Pass')
            ->whereBetween(DB::raw("STR_TO_DATE(cld.expired_date, '%Y-%m-%d')"), [$now, $threeMonthsLater])
            ->get();


        $nikLHR = $this->getNikByRole('Learning & HR Technology');
        $dataLHR = $this->getUserByNik($nikLHR->nik);

        foreach ($data as $key => $value) {
            if ($value->remind_expired != 1){

                $recipients = collect([
                    $value->email,
                    $dataLHR->email,
                ])->flatten()->filter()->unique()->toArray();

                $dataEmail = [
                    'name' => $value->name,
                    'expired_date' => $value->expired_date,
                    'exam_name' => $value->exam_name,
                    'level' => $value->level
                ];

                Mail::to($recipients)->cc('hcm@sinergy.co.id')->send(new \App\Mail\ReminderCertificationExpiredMail($dataEmail));

                $updateData = CertificationListDetail::find($value->id);
                $updateData->update([
                    'remind_expired' => 1
                ]);
            }
        }
    }

    public function getNikByRole($role)
    {
        $getNik = DB::table('roles as r')->join('role_user as ru', 'r.id', 'ru.role_id')
            ->join('users as u', 'ru.user_id', 'u.nik')
            ->select('u.nik')
            ->where('r.name', $role)
            ->where('u.status_karyawan', '!=', 'dummy')
            ->first();
        return $getNik;
    }

    public function getUserByNik($nik)
    {
        $data = DB::table('users')->where('nik', $nik)->first();

        return $data;
    }
}

