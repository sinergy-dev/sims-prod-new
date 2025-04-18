<?php

namespace App\Http\Controllers;
use App\MoneyRequest;
use App\MoneyRequestPID;
use App\MoneyRequestDetail;
use App\MoneyRequestActivity;
use App\Sales;
use App\SalesProject;
use App\User;
use App\SettlementCategory;
use App\Settlement;
use App\SettlementActivity;
use App\SettlementTransport;
use App\SettlementAllowance;
use App\SettlementEntertain;
use App\SettlementOther;
use App\SettlementPID;
use App\SettlementNotes;
use App\Claim;
use App\ClaimActivity;
use App\ClaimTransport;
use App\ClaimAllowance;
use App\ClaimEntertain;
use App\ClaimOther;
use App\ClaimPID;
use App\Mail\MailPMOMonreq;
use App\Mail\MailPMOSettlement;
use App\Mail\MailPMOClaim;
use Mail;

use Carbon\Carbon;
use Auth;
use DB;
use PDF;

use DatePeriod;
use DateInterval;
use DateTime;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


use Illuminate\Http\Request;

class MonReqController extends Controller
{
    public function monreq_index(){
        $sidebar_collapse = true;

        $isHadSettlement = MoneyRequest::select(
            'issuance',
            DB::raw('CASE 
                WHEN status_settlement is null THEN false
                WHEN status_settlement is not null THEN true
                END AS status_settlement
                '),
            DB::raw('MAX(date_add) as max_date_add')
            )
            ->groupBy('issuance' , 'status_settlement')
            ->orderBy('max_date_add','desc')
            ->limit(1)
            ->where('issuance',Auth::User()->nik)->first();

        $isLastMonreqDone = MoneyRequest::select(
            'issuance',
            DB::raw('CASE 
                WHEN status <> "DONE" THEN false
                WHEN status = "DONE" THEN true
                END AS status_monreq
                '),
            'status',
            DB::raw('MAX(date_add) as max_date_add')
            )
            ->groupBy('issuance','status_monreq','status')
            ->orderBy('max_date_add','desc')
            ->limit(1)
            ->where('issuance',Auth::User()->nik)->first();

        return view('PMO/monreq/index',compact('isHadSettlement','isLastMonreqDone','sidebar_collapse'))->with(['initView'=> $this->initMenuBase(),'feature_item'=>$this->RoleDynamic('pmo_monreq')]);
    }

    public function monreq_add(){
        $sidebar_collapse = true;

        return view('PMO/monreq/add_monreq',compact('sidebar_collapse'))->with(['initView'=> $this->initMenuBase()]);
    }

    public function monreq_detail(){
        $sidebar_collapse = true;

        return view('PMO/monreq/detail_monreq',compact('sidebar_collapse'))->with(['initView'=> $this->initMenuBase(),'feature_item'=>$this->RoleDynamic('pmo_monreq')]);
    }

    public function settlement_index(){
        $sidebar_collapse = true;

        return view('PMO/settlement/index',compact('sidebar_collapse'))->with(['initView'=> $this->initMenuBase(),'feature_item'=>$this->RoleDynamic('pmo_settlement')]);
    }

    public function settlement_add(){
        $sidebar_collapse = true;

        return view('PMO/settlement/add_settlement',compact('sidebar_collapse'))->with(['initView'=> $this->initMenuBase()]);
    }

    public function settlement_detail(){
        $sidebar_collapse = true;

        return view('PMO/settlement/detail_settlement',compact('sidebar_collapse'))->with(['initView'=> $this->initMenuBase(),'feature_item'=>$this->RoleDynamic('pmo_settlement')]);
    }

    public function claim_index(){
        $sidebar_collapse = true;

        return view('PMO/claim/index',compact('sidebar_collapse'))->with(['initView'=> $this->initMenuBase(),'feature_item'=>$this->RoleDynamic('pmo_claim')]);
    }

    public function claim_add(){
        $sidebar_collapse = true;

        return view('PMO/claim/add_claim',compact('sidebar_collapse'))->with(['initView'=> $this->initMenuBase(),'feature_item'=>$this->RoleDynamic('pmo_claim')]);
    }

    public function claim_detail(){
        $sidebar_collapse = true;

        return view('PMO/claim/detail_claim',compact('sidebar_collapse'))->with(['initView'=> $this->initMenuBase(),'feature_item'=>$this->RoleDynamic('pmo_claim')]);
    }

    public function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Drive API PHP Quickstart');
        $client->setAuthConfig(env('AUTH_CONFIG'));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        // $client->setScopes("https://www.googleapis.com/auth/drive");
        $client->setScopes(Google_Service_Drive::DRIVE_READONLY);
        
        $tokenPath = env('TOKEN_PATH');
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            if($accessToken != null){
                $client->setAccessToken($accessToken);
            }
        }

        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                $authUrl = $client->createAuthUrl();

                if(isset($_GET['code'])){
                    $authCode = trim($_GET['code']);
                    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                    $client->setAccessToken($accessToken);

                    echo "Access Token = " . json_encode($client->getAccessToken());

                    if (array_key_exists('error', $accessToken)) {
                        throw new Exception(join(', ', $accessToken));
                    }
                } else {
                    echo "Open the following link in your browser :<br>";
                    echo "<a href='" . $authUrl . "'>google drive create token</a>";
                }

                
            }
            // if (!file_exists(dirname($tokenPath))) {
            //     mkdir(dirname($tokenPath), 0700, true);
            // }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }

    public function storeMonReq(Request $request)
    {
        try{
            $edate = date("Y-m-d");

            $month = substr($edate,5,2);
            $year = substr($edate,0,4);

            $array_bln = array('01' => "I",
                        '02' => "II",
                        '03' => "III",
                        '04' => "IV",
                        '05' => "V",
                        '06' => "VI",
                        '07' => "VII",
                        '08' => "VIII",
                        '09' => "IX",
                        '10' => "X",
                        '11' => "XI",
                        '12' => "XII");
            $bln = $array_bln[$month];

            $getnumber = MoneyRequest::orderBy('id', 'desc')->where('date','like',$year."%")->count();

            if($getnumber == NULL){
                $getlastnumber = 1;
                $lastnumber = $getlastnumber;
            } else{
                $lastnumber = $getnumber+1;
            }

            if($lastnumber < 10){
               $akhirnomor = '000' . $lastnumber;
            }elseif($lastnumber > 9 && $lastnumber < 100){
               $akhirnomor = '00' . $lastnumber;
            }elseif($lastnumber >= 100 && $lastnumber < 1000){
               $akhirnomor = '0' . $lastnumber;
            } elseif ($lastnumber >= 1000) {
                $akhirnomor = $lastnumber;
            }

            $no = $akhirnomor .'/MR/PMO/' . $bln .'/'. $year;

            $store = new MoneyRequest();
            $store->no_monreq = $no;
            $store->issuance = Auth::User()->nik;
            $store->date = date('Y-m-d');
            $store->account_number = $request->inputAccNumber;
            $store->account_name = $request->inputAccName;
            $store->req_transfer_date = $request->inputTransferDate;
            $store->status = 'NEW';
            $store->date_add = Carbon::now()->toDateTimeString();
            $store->isCircular = 'True';
            $store->save();

            $data = json_decode($request['arrDataMonreq'],true);
            foreach ($data as $mainKey => $dataArray) {

                $firstObject = $dataArray[0];

                $storeMonReq = new MoneyRequestPID();
                $storeMonReq->id_money_request = $store->id;
                $storeMonReq->pid = $mainKey;
                $storeMonReq->date_add = Carbon::now()->toDateTimeString();
                $storeMonReq->start_date = $firstObject['input_date_range_start'];
                $storeMonReq->end_date = $firstObject['input_date_range_end'];
                $storeMonReq->team_name = $firstObject['textarea_team_name'];
                $storeMonReq->event_detail = $firstObject['textarea_event_detail'];
                $storeMonReq->nominal = $firstObject['input_total_price_pid'];
                $storeMonReq->save();

                foreach (array_slice($dataArray, 1) as $detailKey => $value) {
                    $storeMonReqDetail = new MoneyRequestDetail();
                    $storeMonReqDetail->id_money_req_pid = $storeMonReq->id;
                    $storeMonReqDetail->category = $value['input_category'];
                    $storeMonReqDetail->qty = $value['input_qty'];
                    $storeMonReqDetail->unit = $value['input_unit'];
                    $storeMonReqDetail->price = $value['input_price'];
                    $storeMonReqDetail->total_price = $value['input_total_price'];
                    $storeMonReqDetail->date_add = Carbon::now()->toDateTimeString();
                    $storeMonReqDetail->save();
                }

                // $updateNominalPid = MoneyRequestPID::where('id',$store->storeMonReq)->first();
                // $updateNominalPid->nominal = DB::table('tb_money_request_detail')->select('total_price')->where('id_money_req_pid',$storeMonReq->id)->sum('total_price');
                // $updateNominalPid->save();
            }

            $updateNominalMonReq = MoneyRequest::where('id',$store->id)->first();
            $updateNominalMonReq->nominal = DB::table('tb_money_request_pid')->select('nominal')->where('id_money_request',$store->id)->sum('nominal');
            $updateNominalMonReq->save();

            $storeActivity = new MoneyRequestActivity();
            $storeActivity->id_money_request = $store->id;
            $storeActivity->date_time = Carbon::now()->toDateTimeString();
            $storeActivity->status = 'NEW';
            $storeActivity->operator = Auth::User()->name;
            $storeActivity->activity = 'Add New Money Request';
            $storeActivity->save();

            $kirim_user = User::join('role_user', 'role_user.user_id', '=', 'users.nik')->join('roles', 'roles.id', '=', 'role_user.role_id')->select('email', 'users.name as name_receiver')->where('roles.name', 'Project Management Office Manager')->where('status_karyawan', '!=', 'dummy')->first();

            $detail = MoneyRequest::join('users','users.nik','tb_money_request.issuance')->select('users.name','tb_money_request.status','tb_money_request.nominal', 'no_monreq', 'proof_of_transfer','id','tb_money_request.date')->where('id',$store->id)->first();

            Mail::to($kirim_user)->send(new MailPMOMonreq($detail,$kirim_user,'[SIMS-APP] New Money Request ' .$detail->no_monreq, 'detail_approver', 'next_approver'));

            return response()->json([
                "action"=> "inserted",
                "tid" => $store->id
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateMonReq(Request $request)
    {
        try{
            $getPid = MoneyRequestPID::where('id_money_request',$request->id_money_request)->get();

            foreach ($getPid as $key => $value) {
                MoneyRequestPID::where('id',$value['id'])->delete();
                $detailPid = MoneyRequestDetail::where('id_money_req_pid',$value['id'])->get();
                foreach ($detailPid as $key => $value) {
                    MoneyRequestDetail::where('id',$value['id'])->delete();
                }
            }

            $data = json_decode($request['arrDataMonreq'],true);
            foreach ($data as $mainKey => $dataArray) {

                $firstObject = $dataArray[0];

                $storeMonReq = new MoneyRequestPID();
                $storeMonReq->id_money_request = $request->id_money_request;
                $storeMonReq->pid = $mainKey;
                $storeMonReq->date_add = Carbon::now()->toDateTimeString();
                $storeMonReq->start_date = $firstObject['input_date_range_start'];
                $storeMonReq->end_date = $firstObject['input_date_range_end'];
                $storeMonReq->team_name = $firstObject['textarea_team_name'];
                $storeMonReq->event_detail = $firstObject['textarea_event_detail'];
                $storeMonReq->nominal = $firstObject['input_total_price_pid'];
                $storeMonReq->save();

                foreach (array_slice($dataArray, 1) as $detailKey => $value) {
                    $storeMonReqDetail = new MoneyRequestDetail();
                    $storeMonReqDetail->id_money_req_pid = $storeMonReq->id;
                    $storeMonReqDetail->category = $value['input_category'];
                    $storeMonReqDetail->qty = $value['input_qty'];
                    $storeMonReqDetail->unit = $value['input_unit'];
                    $storeMonReqDetail->price = $value['input_price'];
                    $storeMonReqDetail->total_price = $value['input_total_price'];
                    $storeMonReqDetail->date_add = Carbon::now()->toDateTimeString();
                    $storeMonReqDetail->save();
                }
            }

            $updateNominalMonReq = MoneyRequest::where('id',$request->id_money_request)->first();
            $updateNominalMonReq->account_number = $request->inputAccNumber;
            $updateNominalMonReq->account_name = $request->inputAccName;
            $updateNominalMonReq->req_transfer_date = $request->inputTransferDate;
            $updateNominalMonReq->nominal = DB::table('tb_money_request_pid')->select('nominal')->where('id_money_request',$request->id_money_request)->sum('nominal');
            $updateNominalMonReq->status = 'NEW';
            $updateNominalMonReq->save();

            $storeActivity = new MoneyRequestActivity();
            $storeActivity->id_money_request = $request->id_money_request;
            $storeActivity->date_time = Carbon::now()->toDateTimeString();
            $storeActivity->status = 'NEW';
            $storeActivity->operator = Auth::User()->name;
            $storeActivity->activity = 'Updated Money Request';
            $storeActivity->save();

            $kirim_user = User::join('role_user', 'role_user.user_id', '=', 'users.nik')->join('roles', 'roles.id', '=', 'role_user.role_id')->select('email', 'users.name as name_receiver')->where('roles.name', 'Project Management Office Manager')->where('status_karyawan', '!=', 'dummy')->first();

            $detail = MoneyRequest::join('users','users.nik','tb_money_request.issuance')->select('users.name','tb_money_request.status','tb_money_request.nominal', 'no_monreq', 'proof_of_transfer','id','tb_money_request.date','issuance')->where('id',$request->id_money_request)->first();

            Mail::to($kirim_user)->send(new MailPMOMonreq($detail,$kirim_user,'[SIMS-APP] Updated Money Request ' .$detail->no_monreq, 'detail_approver', 'next_approver'));

            return response()->json([
                "action"=> "updated",
                "tid" => $request->id_money_request
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getPid(Request $request)
    {
        $nik = Auth::User()->nik;
        $cek_role = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.name','roles.name as name_role','group','mini_group')->where('user_id',$nik)->first();

        $getPid = DB::table('ticketing__user')->where('nik',Auth::User()->nik)->get()->pluck('pid');
        $getPidPm = DB::table('tb_pmo')->join('tb_pmo_assign','tb_pmo_assign.id_project','tb_pmo.id')->join('role_user','role_user.user_id','tb_pmo_assign.nik')->join('roles','roles.id','role_user.role_id')->where('nik',Auth::User()->nik)->where('name','!=','Asset Management')->get()->pluck('project_id');

        $getAllPid = SalesProject::join('sales_lead_register', 'sales_lead_register.lead_id', '=', 'tb_id_project.lead_id')->join('users', 'users.nik', '=', 'sales_lead_register.nik')->select('id_project as id',DB::raw("CONCAT(`id_project`,' - ',`name_project`) AS text"))->where('id_company', '1')->where('id_project','like','%'.request('q').'%')->orderBy('tb_id_project.created_at','desc');

        if ($cek_role->name_role == 'Project Manager' || $cek_role->name_role == 'Project Coordinator') {
            $getAllPid = $getAllPid->whereIn('id_project',$getPidPm)->get();
        } else {
            $getAllPid = $getAllPid->get();
        }

        return response()->json($getAllPid);
    }

    public function getItemSbe(Request $request)
    {
        $lead = DB::table('tb_id_project')->select('lead_id')->where('id_project',$request->pid)->first();

        $sbe = DB::table('tb_sbe')->join('tb_sbe_config','tb_sbe_config.id_sbe','tb_sbe.id')->join('tb_sbe_detail_config','tb_sbe_config.id','tb_sbe_detail_config.id_config_sbe')->where('tb_sbe_config.status','Choosed')->join('tb_sbe_detail_item','tb_sbe_detail_item.id','tb_sbe_detail_config.detail_item')->select('tb_sbe_detail_item.detail_item as id','tb_sbe_detail_item.detail_item as text')->where('lead_id',$lead->lead_id)->where('tb_sbe_detail_item.detail_item','like','%'.request('q').'%')->distinct()->get();

        return response()->json($sbe);
    }

    public function getMonReq(Request $request)
    {
        $nik = Auth::User()->nik;
        $cek_role = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.name','roles.name as name_role','group','mini_group')->where('user_id',$nik)->first();

        if ($cek_role->name_role == 'Project Manager' || $cek_role->name_role == 'Project Coordinator') {
            $data = MoneyRequest::join('users','users.nik','tb_money_request.issuance')->select('no_monreq','users.name','tb_money_request.date','tb_money_request.status','nominal','status_settlement','tb_money_request.id','isCircular')->where('nik',$nik)->orderby('tb_money_request.id','desc')->get();
        } else {
            $data = MoneyRequest::join('users','users.nik','tb_money_request.issuance')->select('no_monreq','users.name','tb_money_request.date','tb_money_request.status','nominal','status_settlement','tb_money_request.id','isCircular')->orderby('tb_money_request.id','desc')->get();
        }

        return array("data"=>$data->sortByDesc('date')->values()->all());
    }

    public function getActivityMonReq(Request $request)
    {
        $getActivity = MoneyRequestActivity::select('activity', 'operator', 'status', 'date_time')
                ->selectRaw("SUBSTR(`tb_money_request_activity`.`date_time`,1,10) AS `date_format`")->where('id_money_request', $request->id_money_request)->orderBy('date_time', 'desc')->get();

        // return [$getActivity->groupBy('date_format')];
        return response()->json($getActivity);
    }

    public function getDetailMonReq(Request $request)
    {
        $getDetail = MoneyRequest::select('account_name','account_number','req_transfer_date','nominal','no_monreq','status','id','proof_of_transfer','date as request_date')->where('id',$request->id_money_request)->first();

        $pid = MoneyRequestPID::join('tb_id_project','tb_id_project.id_project','tb_money_request_pid.pid')->select('pid','nominal','start_date','end_date','team_name','event_detail',DB::raw("CONCAT(id_project, ' - ', name_project) as pid_text"))->where('id_money_request',$request->id_money_request)->get();

        $getDetailPid = MoneyRequestDetail::join('tb_money_request_pid','tb_money_request_pid.id','tb_money_request_detail.id_money_req_pid')->join('tb_id_project','tb_id_project.id_project','tb_money_request_pid.pid')->select('category',DB::raw("CONCAT(qty, ' - ', unit) as unit_concat"),'unit','qty','price','total_price','pid',DB::raw("CONCAT(id_project, ' - ', name_project) as pid_text"))->where('id_money_request',$request->id_money_request)->get()->groupby('pid');

        $pid->each(function ($item) use ($getDetailPid) {
            $item->details = $getDetailPid->get($item->pid) ?? collect();
        });

        $getDetail->pid_details = $pid;

        $activity = DB::table('tb_money_request_activity')->select(DB::raw('DATE(date_time) AS date_time'),DB::raw('DATE(DATE_ADD(date_time, INTERVAL 14 DAY)) AS date_plus_14_days'))->where('id_money_request',$request->id_money_request)->where('status','DONE')->first();

        if (isset($activity)) {
            $tf_from_finance = $activity->date_time;
            $settlement_date_plan = $activity->date_plus_14_days;
        } else {
            $tf_from_finance = '-';
            $settlement_date_plan = '-';
        }

        $getDetail->tf_from_finance = $tf_from_finance;
        $getDetail->settlement_date_plan = $settlement_date_plan;

        $unapproved = DB::table('tb_money_request_activity')
            ->where('tb_money_request_activity.id_money_request', $request->id_money_request)
            ->where('tb_money_request_activity.status', "UNAPPROVED")
            ->orderBy('tb_money_request_activity.id',"DESC")
            ->get();

        $tb_money_request_activity = DB::table('tb_money_request_activity')
            ->where('tb_money_request_activity.id_money_request', $request->id_money_request);

        if(count($unapproved) != 0){
            $tb_money_request_activity->where('tb_money_request_activity.id','>',$unapproved->first()->id);
        }
            
        $tb_money_request_activity->where(function($query){
            $query->where('tb_money_request_activity.status', 'CIRCULAR')
                ->orWhere('tb_money_request_activity.status', 'APPROVED');
        });

        $sign = User::join('role_user', 'role_user.user_id', '=', 'users.nik')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('ttd', 'users.name')
                ->leftJoinSub($tb_money_request_activity,'temp_tb_money_request_activity',function($join){
                    $join->on("users.name","LIKE",DB::raw("CONCAT('%', temp_tb_money_request_activity.operator, '%')"));
                })
                ->where('activity', 'Approval')->orderBy('date_time','asc')->get();

        if ($getDetail->status == 'APPROVED' || $getDetail->status == 'HOLD' || $getDetail->status == 'DONE') {
            $get_ttd = $this->getSignMonReq($request->id_money_request,'show_ttd');
        } else {
            $get_ttd = $this->getSignMonReq($request->id_money_request,'getSign');
        }

        return collect([
            'monReq' => $getDetail,
            // 'show_ttd' => $this->getSignMonReq($request->id_money_request,'show_ttd'),
            'show_ttd' => $sign,
            'getSign' => $get_ttd
        ]);
    }

    public function rejectMonReq(Request $request)
    {
        try {
            $storeActivity = new MoneyRequestActivity();
            $storeActivity->id_money_request = $request->id_money_request;
            $storeActivity->date_time = Carbon::now()->toDateTimeString();
            $storeActivity->status = 'UNAPPROVED';
            $storeActivity->operator = Auth::User()->name;
            $storeActivity->activity = 'The circulation process was stopped because it was rejected for the following reasons: ' . $request['reasonRejectSirkular'];
            $storeActivity->save();

            $update = MoneyRequest::where('id', $request->id_money_request)->first();
            $update->isCircular = 'False';
            $update->status = 'UNAPPROVED';
            $update->save();

            $detail = MoneyRequest::join('users','users.nik','tb_money_request.issuance')->select('users.name','tb_money_request.status','tb_money_request.nominal', 'no_monreq', 'proof_of_transfer','id','tb_money_request.date','issuance')->where('id',$request->id_money_request)->first();

            $detail->notes = $request['reasonRejectSirkular'];

            $kirim_user = User::select('email', 'users.name as name_receiver')->where('nik', $detail->issuance)->first();

            Mail::to($kirim_user->email)->send(new MailPMOMonreq($detail,$kirim_user,'[SIMS-APP] Reject Money Request ' .$detail->no_monreq, 'detail_approver', 'next_approver'));

            return response()->json([
                "action"=> "inserted",
                "tid" => $request->id_money_request
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function approveSettlement(Request $request)
    {
        try{
            $nik = Auth::User()->nik;
            $cek_role = DB::table('role_user')->join('roles', 'roles.id', '=', 'role_user.role_id')
                        ->select('name', 'group')->where('user_id', $nik)->first();

            $cek_sign = SettlementActivity::where('id_settlement', $request->id_settlement)->where('operator', Auth::User()->name)->whereRaw("(`status` =  'CIRCULAR' OR `status` = 'APPROVED')")->first();

            if (SettlementActivity::where('id_settlement', $request->id_settlement)->where('operator', Auth::User()->name)->whereRaw("(`status` =  'CIRCULAR' OR `status` = 'APPROVED')")->exists()) {
                SettlementActivity::where('id', $cek_sign->id)->delete(); 
            }

            $storeActivity = new SettlementActivity();
            $storeActivity->id_settlement = $request->id_settlement;
            $storeActivity->date_time = Carbon::now()->toDateTimeString();
            if ($cek_role->name == 'Chief Operating Officer') {
                $storeActivity->status = 'APPROVED';
            }else if ($cek_role->group == 'Financial And Accounting') {
                $storeActivity->status = 'DONE';
            }else {
                $storeActivity->status = 'CIRCULAR';
            }
            $storeActivity->operator = Auth::User()->name;
            $storeActivity->activity = 'Approval';
            $storeActivity->save();

            if ($storeActivity->status == 'APPROVED') {
                $update = Settlement::where('id', $request->id_settlement)->first();
                $update->isCircular = 'False';
                $update->status = 'APPROVED';
                $update->save();

                $getIdMoneReq = Settlement::where('id',$request->id_settlement)->first()->no_monreq;

                $updateStatusMonreq = MoneyRequest::where('id',$getIdMoneReq)->first();
                $updateStatusMonreq->status_settlement = 'DONE';
                $updateStatusMonreq->save();

                $detail = Settlement::join('users','users.nik','tb_settlement.issuance')->join('tb_money_request','tb_money_request.id','tb_settlement.no_monreq')->select('users.name','tb_settlement.status','tb_settlement.nominal', 'tb_money_request.no_monreq', 'tb_settlement.id','tb_settlement.date','tb_settlement.issuance')->where('tb_settlement.id',$request->id_settlement)->first();

                $kirim_user = User::join('role_user', 'role_user.user_id', '=', 'users.nik')->join('roles', 'roles.id', '=', 'role_user.role_id')->select('email', 'users.name as name_receiver')->where('users.name', 'Marlina Sentosa')->where('status_karyawan', '!=', 'dummy')->first();

                $next_approver = $this->getSignSettlement($request->id_settlement, 'show_ttd');

                $email_cc = User::select('email')
                        ->where('nik',$detail->issuance)
                        ->get()->pluck('email');

                Mail::to($kirim_user)->cc($email_cc)->send(new MailPMOSettlement($detail,$kirim_user,'[SIMS-APP] Settlement ' .$detail->no_monreq. ' is Approved By ' . Auth::User()->name . ' And Ready To APPROVED', 'detail_approver', $next_approver));

            } else if ($storeActivity->status == 'DONE') {
                $update = Settlement::where('id', $request->id_settlement)->first();
                $update->isCircular = 'False';
                $update->status = 'DONE';
                $update->save();

                $detail = Settlement::join('users','users.nik','tb_settlement.issuance')->join('tb_money_request','tb_money_request.id','tb_settlement.no_monreq')->select('users.name','tb_settlement.status','tb_settlement.nominal', 'tb_money_request.no_monreq', 'tb_settlement.id','tb_settlement.date','tb_settlement.issuance')->where('tb_settlement.id',$request->id_settlement)->first();

                $kirim_user = User::select('email', 'name as name_receiver')                        
                    ->where('nik',$detail->issuance)
                    ->first();User::select('email');

                $email_cc = User::join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('email','roles.name as name_role')
                        ->whereRaw("(`nik` = '".$detail->issuance."')")
                        ->get()->pluck('email');

                Mail::to($kirim_user)->cc($email_cc)->send(new MailPMOSettlement($detail,$kirim_user,'[SIMS-APP] Settlement ' .$detail->no_monreq. ' is Approved By ' . Auth::User()->name, 'detail_approver', ''));
            } else {
                $update = Settlement::where('id', $request->id_settlement)->first();
                $update->isCircular = 'True';
                $update->status = 'CIRCULAR';
                $update->save();

                $detail = Settlement::join('users','users.nik','tb_settlement.issuance')->join('tb_money_request','tb_money_request.id','tb_settlement.no_monreq')->select('users.name','tb_settlement.status','tb_settlement.nominal', 'tb_money_request.no_monreq', 'tb_settlement.id','tb_settlement.date','tb_settlement.issuance')->where('tb_settlement.id',$request->id_settlement)->first();

                $kirim_user = User::select('email', 'name as name_receiver')->where('name', $this->getSignSettlement($request->id_settlement, 'detail'))->first();
                $next_approver = $this->getSignSettlement($request->id_settlement, 'detail');
                $detail_approver = $this->getSignSettlement($request->id_settlement, 'show_ttd');

                $cek_role = DB::table('role_user')->join('roles', 'roles.id', '=', 'role_user.role_id')
                            ->select('name', 'roles.group')->where('user_id', $detail->issuance)->first(); 

                if ($next_approver == 'Muhammad Nabil') {
                    $email_cc = User::join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('email','roles.name as name_role')
                        ->whereRaw("(`nik` = '".$detail->issuance."')")
                        ->get()->pluck('email');
                    $email_cc = $email_cc->put('4','felicia@sinergy.co.id');

                } else {
                    $email_cc = User::join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('email','roles.name as name_role')
                        ->whereRaw("(`nik` = '".$detail->issuance."')")
                        ->get()->pluck('email');
                }

                Mail::to($kirim_user)->cc($email_cc)->send(new MailPMOSettlement($detail,$kirim_user,'[SIMS-APP] Settlement ' .$detail->no_monreq. ' is Approved By ' . Auth::User()->name, $detail_approver, $next_approver));
            }

            $approver = 'Signed by '.Auth::User()->name;

            return response()->json([
                "action"=> "inserted",
                "tid" => $request->id_settlement
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        
    }

    public function rejectSettlement(Request $request)
    {
        try {
            $storeActivity = new SettlementActivity();
            $storeActivity->id_settlement = $request->id_settlement;
            $storeActivity->date_time = Carbon::now()->toDateTimeString();
            $storeActivity->status = 'UNAPPROVED';
            $storeActivity->operator = Auth::User()->name;
            $storeActivity->activity = 'The circulation process was stopped because it was rejected for the following reasons: ' . $request['reasonRejectSirkular'];
            $storeActivity->save();

            $update = Settlement::where('id', $request->id_settlement)->first();
            $update->isCircular = 'False';
            $update->status = 'UNAPPROVED';
            $update->save();

            $detail = Settlement::join('users','users.nik','tb_settlement.issuance')->join('tb_money_request','tb_money_request.id','tb_settlement.no_monreq')->select('users.name','tb_settlement.status','tb_settlement.nominal', 'tb_money_request.no_monreq', 'tb_settlement.id','tb_settlement.date','tb_settlement.issuance')->where('tb_settlement.id',$request->id_settlement)->first();

            $detail->notes = $request['reasonRejectSirkular'];

            $kirim_user = User::select('email', 'users.name as name_receiver')->where('nik', $detail->issuance)->first();

            $email_cc = User::join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('email','roles.name as name_role')
                        ->where('roles.name','PMO Officer')
                        ->get()->pluck('email');

            Mail::to($kirim_user->email)->cc($email_cc)->send(new MailPMOSettlement($detail,$kirim_user,'[SIMS-APP] Reject Settlement ' .$detail->no_monreq. ' by ' . Auth::User()->name , 'detail_approver', 'next_approver'));

            return response()->json([
                "action"=> "inserted",
                "tid" => $request->id_settlement
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getSignMonReq($id_money_request,$status){
        $data = MoneyRequest::where('id',$id_money_request)->first();

        $unapproved = DB::table('tb_money_request_activity')
            ->where('tb_money_request_activity.id_money_request', $id_money_request)
            ->where('tb_money_request_activity.status', "UNAPPROVED")
            ->orderBy('tb_money_request_activity.id',"DESC")
            ->get();

        $tb_money_request_activity = DB::table('tb_money_request_activity')
            ->where('tb_money_request_activity.id_money_request', $id_money_request);

        if(count($unapproved) != 0){
            $tb_money_request_activity->where('tb_money_request_activity.id','>',$unapproved->first()->id);
        }
            
        $tb_money_request_activity->where(function($query){
            $query->where('tb_money_request_activity.status', 'CIRCULAR')
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

        if ($status == 'show_ttd') {
            return $sign->get();
        } else{
            return $sign->get()->where('signed','false')->first()->name;
        }
    }

    public function holdMonReq(Request $request)
    {
        try{
            $storeActivity = new MoneyRequestActivity();
            $storeActivity->id_money_request = $request->id_money_request;
            $storeActivity->date_time = Carbon::now()->toDateTimeString();
            $storeActivity->status = 'HOLD';
            $storeActivity->operator = Auth::User()->name;
            $storeActivity->activity = 'The process was holded because for the following reasons: ' . $request['reasonHold'];
            $storeActivity->save();

            $update = MoneyRequest::where('id', $request->id_money_request)->first();
            // $update->isCircular = 'False';
            $update->status = 'HOLD';
            $update->save();

            return response()->json([
                "action"=> "inserted",
                "tid" => $storeActivity->id
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function approveMonReq(Request $request)
    {
        try{
            $nik = Auth::User()->nik;
            $cek_role = DB::table('role_user')->join('roles', 'roles.id', '=', 'role_user.role_id')
                        ->select('name')->where('user_id', $nik)->first(); 

            $cek_sign = MoneyRequestActivity::where('id_money_request', $request->id_money_request)->where('operator', Auth::User()->name)->whereRaw("(`status` =  'CIRCULAR' OR `status` = 'APPROVED')")->first();

            if (MoneyRequestActivity::where('id_money_request', $request->id_money_request)->where('operator', Auth::User()->name)->whereRaw("(`status` =  'CIRCULAR' OR `status` = 'APPROVED')")->exists()) {
                MoneyRequestActivity::where('id', $cek_sign->id)->delete(); 
            }

            $storeActivity = new MoneyRequestActivity();
            $storeActivity->id_money_request = $request->id_money_request;
            $storeActivity->date_time = Carbon::now()->toDateTimeString();
            if ($cek_role->name == 'Chief Operating Officer') {
                $storeActivity->status = 'APPROVED';
            }else {
                $storeActivity->status = 'CIRCULAR';
            }
            $storeActivity->operator = Auth::User()->name;
            $storeActivity->activity = 'Approval';
            $storeActivity->save();

            if ($storeActivity->status == 'APPROVED') {
                $update = MoneyRequest::where('id', $request->id_money_request)->first();
                $update->isCircular = 'False';
                $update->status = 'APPROVED';
                $update->save();

                $detail = MoneyRequest::join('users', 'users.nik', '=', 'tb_money_request.issuance')->select('users.name as name', 'nominal', 'account_name', 'tb_money_request.status','tb_money_request.date','tb_money_request.account_number','tb_money_request.issuance','proof_of_transfer','id','tb_money_request.date')->where('tb_money_request.id', $request->id_money_request)->first();

                $kirim_user = User::join('role_user', 'role_user.user_id', '=', 'users.nik')->join('roles', 'roles.id', '=', 'role_user.role_id')->select('email', 'users.name as name_receiver')->where('users.name', 'Marlina Sentosa')->where('status_karyawan', '!=', 'dummy')->first();

                $next_approver = $this->getSignMonReq($request->id_money_request, 'show_ttd');

                $email_cc = User::select('email')
                        ->where('nik',$detail->issuance)
                        ->get()->pluck('email');

                Mail::to($kirim_user)->cc($email_cc)->send(new MailPMOMonreq($detail,$kirim_user,'[SIMS-APP] Money Request ' .$detail->no_monreq. ' is Approved By ' . Auth::User()->name . ' And Ready To APPROVED', 'detail_approver', $next_approver));

            } else {
                $update = MoneyRequest::where('id', $request->id_money_request)->first();
                $update->isCircular = 'True';
                $update->status = 'CIRCULAR';
                $update->save();

                $detail = MoneyRequest::join('users', 'users.nik', '=', 'tb_money_request.issuance')->select('users.name as name', 'nominal', 'account_name', 'tb_money_request.status','tb_money_request.date','tb_money_request.account_number','tb_money_request.issuance','proof_of_transfer','id','tb_money_request.date')->where('tb_money_request.id', $request->id_money_request)->first();

                $kirim_user = User::select('email', 'name as name_receiver')->where('name', $this->getSignMonReq($request->id_money_request, 'detail'))->first();
                $next_approver = $this->getSignMonReq($request->id_money_request, 'detail');
                $detail_approver = $this->getSignMonReq($request->id_money_request, 'show_ttd');

                $cek_role = DB::table('role_user')->join('roles', 'roles.id', '=', 'role_user.role_id')
                            ->select('name', 'roles.group')->where('user_id', $detail->issuance)->first(); 

                if ($next_approver == 'Muhammad Nabil') {
                    $email_cc = User::join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('email','roles.name as name_role')
                        ->whereRaw("(`nik` = '".$detail->issuance."')")
                        ->get()->pluck('email');
                    $email_cc = $email_cc->put('4','felicia@sinergy.co.id');

                } else {
                    $email_cc = User::join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('email','roles.name as name_role')
                        ->whereRaw("(`nik` = '".$detail->issuance."')")
                        ->get()->pluck('email');
                }

                Mail::to($kirim_user)->cc($email_cc)->send(new MailPMOMonreq($detail,$kirim_user,'[SIMS-APP] Money Request ' .$detail->no_monreq. ' is Approved By ' . Auth::User()->name, $detail_approver, $next_approver));
            }

            $approver = 'Signed by '.Auth::User()->name;

            return $approver;
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        
    }

    public function uploadReceipt(Request $request)
    {
        try{

            $detail = MoneyRequest::join('users','users.nik','tb_money_request.issuance')->select('users.name','tb_money_request.status','tb_money_request.nominal', 'no_monreq', 'proof_of_transfer','id','tb_money_request.date','issuance')->where('id',$request->id_money_request)->first();

            $allowedfileExtension   = ['jpg','png', 'jpeg', 'JPG', 'PNG', 'pdf', 'PDF'];
            $file                   = $request->file('upload_receipt');
            $fileName               = 'Proof of Transfer MonReq '.$detail->no_monreq.' '.$file->getClientOriginalExtension();
            $filePath               = $file->getRealPath();
            $extension              = $file->getClientOriginalExtension();

            $update = MoneyRequest::where('id',$request->id_money_request)->first();

            if ($update->parent_id_drive == null) {
                $parentID = $this->googleDriveMakeFolder($update->no_monreq);
            } else {
                $parentID = [];
                $parent_id = explode('"', $update->parent_id_drive)[1];
                array_push($parentID,$parent_id);
            }

            $update->proof_of_transfer = $this->googleDriveUploadCustom($fileName,$filePath,$parentID);
            $update->parent_id_drive = $parentID;
            $update->status = 'DONE';
            $update->save();

            $storeActivity = new MoneyRequestActivity();
            $storeActivity->id_money_request = $request->id_money_request;
            $storeActivity->date_time = Carbon::now()->toDateTimeString();
            $storeActivity->status = 'DONE';
            $storeActivity->operator = Auth::User()->name;
            $storeActivity->activity = 'Proof of Transfer Uploaded';
            $storeActivity->save();

            $kirim_user = User::select('email', 'users.name as name_receiver')->where('nik', $detail->issuance)->first();

            Mail::to($kirim_user)->send(new MailPMOMonreq($detail,$kirim_user,'[SIMS-APP] Money Request ' .$detail->no_monreq . ' Has Been Transferred', 'detail_approver', 'next_approver'));
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function uploadToLocal($file,$directory,$nameFile){
        try {
            if ($file && $file->isValid()) {
                $file->move($directory, $nameFile);
                return true;
            } else {
                Log::error('File is invalid or not properly uploaded'.$file);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            return false;
        }
    }

    public function googleDriveMakeFolderSettlement($nameFolder){
        $client_folder = $this->getClient();
        $service_folder = new Google_Service_Drive($client_folder);

        $file = new Google_Service_Drive_DriveFile();
        $file->setName($nameFolder);
        $file->setMimeType('application/vnd.google-apps.folder');
        $file->setDriveId(env('GOOGLE_DRIVE_DRIVE_ID'));
        $file->setParents([env('GOOGLE_DRIVE_PARENT_ID_Settlement')]);

        $result = $service_folder->files->create(
            $file, 
            array(
                'mimeType' => 'application/octet-stream',
                'uploadType' => 'multipart',
                'supportsAllDrives' => true
            )
        );

        // $fileId = $result->id;

        // $permission = new Google_Service_Drive_Permission();
        // $permission->setType('anyone');
        // $permission->setRole('reader');

        // $service->permissions->create($fileId, $permission, 
        //     [
        //         'data' => file_get_contents($locationFile),
        //         'mimeType' => mime_content_type($locationFile),
        //         'uploadType' => 'multipart',
        //         'supportsAllDrives' => true
        //     ]
        // );

        return array($result->id);
    }

    public function googleDriveMakeFolderClaim($nameFolder){
        $client_folder = $this->getClient();
        $service_folder = new Google_Service_Drive($client_folder);

        $file = new Google_Service_Drive_DriveFile();
        $file->setName($nameFolder);
        $file->setMimeType('application/vnd.google-apps.folder');
        $file->setDriveId(env('GOOGLE_DRIVE_DRIVE_ID'));
        $file->setParents([env('GOOGLE_DRIVE_PARENT_ID_Claim')]);

        $result = $service_folder->files->create(
            $file, 
            array(
                'mimeType' => 'application/octet-stream',
                'uploadType' => 'multipart',
                'supportsAllDrives' => true
            )
        );

        return array($result->id);
    }

    public function googleDriveMakeFolder($nameFolder){
        $client_folder = $this->getClient();
        $service_folder = new Google_Service_Drive($client_folder);

        $file = new Google_Service_Drive_DriveFile();
        $file->setName($nameFolder);
        $file->setMimeType('application/vnd.google-apps.folder');
        $file->setDriveId(env('GOOGLE_DRIVE_DRIVE_ID'));
        $file->setParents([env('GOOGLE_DRIVE_PARENT_ID_Monreq')]);

        $result = $service_folder->files->create(
            $file, 
            array(
                'mimeType' => 'application/octet-stream',
                'uploadType' => 'multipart',
                'supportsAllDrives' => true
            )
        );

        return array($result->id);
    }

    public function googleDriveUploadCustom($fileName,$locationFile,$parentID){
        try {
            $client = $this->getClient();
            $service = new Google_Service_Drive($client);

            $file = new Google_Service_Drive_DriveFile();
            $file->setName($fileName);
            $file->setParents($parentID);

            $result = $service->files->create(
                $file, 
                [
                    'data' => file_get_contents($locationFile),
                    'mimeType' => mime_content_type($locationFile),
                    'uploadType' => 'multipart',
                    'supportsAllDrives' => true
                ]
            );

            unlink($locationFile);

            $optParams = [
                'fields' => 'files(webViewLink)',
                'q' => 'name="'.$fileName.'"',
                'supportsAllDrives' => true,
                'includeItemsFromAllDrives' => true
            ];

            $link = $service->files->listFiles($optParams)->getFiles()[0]->getWebViewLink();
            return $link;

        } catch (\Exception $e) {
            Log::error('Google Drive upload error: ' . $e->getMessage());
            return false;
        }
    }

    public function googleDriveUploadCustomSettlement($fileName,$locationFile,$parentID){
        try {
            $client = $this->getClient();
            $service = new Google_Service_Drive($client);

            $file = new Google_Service_Drive_DriveFile();
            $file->setName($fileName);
            $file->setParents($parentID);

            $result = $service->files->create(
                $file, 
                [
                    'data' => file_get_contents($locationFile),
                    'mimeType' => mime_content_type($locationFile),
                    'uploadType' => 'multipart',
                    'supportsAllDrives' => true
                ]
            );

            $fileId = $result->id;

            return $fileId;

        } catch (\Exception $e) {
            Log::error('Google Drive upload error: ' . $e->getMessage());
            return false;
        }
    }

    public function getMonReqforSettlement(Request $request)
    {
        $data = DB::table('tb_money_request')->select('id as id', 'no_monreq as text')->where('issuance',Auth::User()->nik)->where('status_settlement',null)->where('status','DONE')->where('no_monreq','like','%'.request('q').'%')->get();

        return response()->json($data);
    }

    public function getPIDforSettlement(Request $request)
    {
        $data = DB::table('tb_money_request')->join('tb_money_request_pid','tb_money_request_pid.id_money_request','tb_money_request.id')->select('pid as id',DB::raw("CONCAT(pid, ' - [Money Request]') as text"))->where('id_money_request',$request->id_money_request)
            ->where(DB::raw("CONCAT(pid, ' - [Money Request]')"),'like','%'.request('q').'%')
            ->get();

        $getPidSBE = DB::table('tb_id_project')->join('tb_sbe','tb_sbe.lead_id','tb_id_project.lead_id')->select('id_project')->get()->pluck('id_project');

        $getPidPm = DB::table('tb_pmo')->join('tb_pmo_assign','tb_pmo_assign.id_project','tb_pmo.id')->join('role_user','role_user.user_id','tb_pmo_assign.nik')->join('roles','roles.id','role_user.role_id')->select('project_id as id','project_id as text')
            ->where('project_id','like','%'.request('q').'%')
            ->where('nik',Auth::User()->nik)
            ->whereNotIn('project_id',$data->pluck('id'))
            ->where('name','!=','Asset Management')
            ->whereIn('project_id',$getPidSBE)
            ->get();

        return collect($data)->merge($getPidPm);
    }

    public function getCategorySettlement(Request $request)
    {
        if($request->category == 'Communication Plan'){
            $request->category = 'Entertainment';
        } elseif(str_contains($request->category, 'Allowance')){
            $request->category = 'Allowance';
        }

        $sub_category= [];

        if ($request->category == 'Transport' || $request->category == 'Entertainment' || $request->category == 'Allowance') {
            $dataCategory = DB::table('tb_settlement_category')->select('sub_category as id','sub_category as text')->where('category',$request->category)->distinct()->get();

            $detailCategory = DB::table('tb_settlement_category')->select('sub_category','title','type','id_input','element')->where('sub_category',$request->detail_category)->get()->groupby('sub_category');

            // return $request->detail_category;
        } else if($request->category == 'Others'){
            $dataCategory = MoneyRequest::join('tb_money_request_pid','tb_money_request_pid.id_money_request','tb_money_request.id')->join('tb_money_request_detail','tb_money_request_detail.id_money_req_pid','tb_money_request_pid.id')->select('category')->where('pid',$request->pid)->where('id_money_request',$request->id_money_request)->distinct()->get()->pluck('category');

            // $sub_category = DB::table('tb_settlement_category')->select('sub_category as id','sub_category as text')->where('category',$request->category)->distinct()->get();

            $lead = DB::table('tb_id_project')->select('lead_id')->where('id_project',$request->pid)->first();

            $dataCategory = DB::table('tb_sbe')
                ->join('tb_sbe_config','tb_sbe_config.id_sbe','tb_sbe.id')
                ->join('tb_sbe_detail_config','tb_sbe_config.id','tb_sbe_detail_config.id_config_sbe')
                ->where('tb_sbe_config.status','Choosed')
                ->join('tb_sbe_detail_item','tb_sbe_detail_item.id','tb_sbe_detail_config.detail_item')
                ->select('tb_sbe_detail_item.detail_item as id','tb_sbe_detail_item.detail_item as text')
                ->where('lead_id',$lead->lead_id)
                ->where('tb_sbe_detail_item.detail_item','like','%'.request('q').'%')
                ->where('tb_sbe_detail_item.detail_item','not like', 'Travel%')
                ->where('tb_sbe_detail_item.detail_item','not like','Pengiriman%')
                ->where('tb_sbe_detail_item.detail_item','not like','Mandays%')
                ->where('tb_sbe_detail_item.detail_item','not like','Accom%')
                ->where('tb_sbe_detail_item.detail_item','not like','Call%')
                ->whereNotIn('tb_sbe_detail_item.detail_item',$dataCategory)->distinct()->get();
                
            $detailCategory = DB::table('tb_settlement_category')->select('sub_category','title','type','id_input','element')->where('sub_category','Others')->get()->groupby('sub_category');
        }else {
            $dataCategory = DB::table('tb_settlement_category')->select('sub_category as id','sub_category as text')->where('category','Others')->distinct()->get();

            $detailCategory = DB::table('tb_settlement_category')->select('sub_category','title','type','id_input','element')->where('sub_category','Others')->get()->groupby('sub_category');
        }
        
        return response()->json(collect(['category'=>$dataCategory,'sub_category'=>$sub_category,'detailCategory'=>$detailCategory]));
    }

    public function getRoleByPid(Request $request)
    {
        $lead = DB::table('tb_id_project')->select('lead_id')->where('id_project',$request->pid)->first();
        // $term = $request->get('term');

        $sbe = DB::table('tb_sbe')->join('tb_sbe_config','tb_sbe_config.id_sbe','tb_sbe.id')->join('tb_sbe_detail_config','tb_sbe_config.id','tb_sbe_detail_config.id_config_sbe')->where('tb_sbe_config.status','Choosed')->join('tb_sbe_detail_item','tb_sbe_detail_item.id','tb_sbe_detail_config.detail_item')->select('tb_sbe_detail_config.item as id','tb_sbe_detail_config.item as text')->where('lead_id',$lead->lead_id)->where('tb_sbe_detail_config.item','like','%'.request('q').'%')->distinct()->get();

        return response()->json($sbe);
    }

    public function getUser(Request $request)
    {
        $getUser = collect(User::select(DB::raw('`users`.`name` AS `id`,`name` AS `text`'))->where('id_company', '1')->where('status_karyawan', '!=', 'dummy')->where('status_karyawan','!=','D')->where('name','like','%'.request('q').'%')->get());

        return $getUser;
    }

    public function getDataSettlement(Request $request)
    {
        $nik = Auth::User()->nik;
        $cek_role = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.name','roles.name as name_role','group','mini_group')->where('user_id',$nik)->first();

        if ($cek_role->name_role == 'Project Manager' || $cek_role->name_role == 'Project Coordinator') {
            $data = Settlement::join('tb_money_request','tb_money_request.id','tb_settlement.no_monreq')->join('users','users.nik','tb_settlement.issuance')->select('users.name as issuance','tb_money_request.no_monreq','tb_settlement.date','tb_settlement.status','tb_settlement.nominal','tb_settlement.id','tb_settlement.isCircular')->where('tb_settlement.issuance',Auth::User()->nik)->get()->makeHidden(['notes_settlement']);
        } else {
            $data = Settlement::join('tb_money_request','tb_money_request.id','tb_settlement.no_monreq')->join('users','users.nik','tb_settlement.issuance')->select('users.name as issuance','tb_money_request.no_monreq','tb_settlement.date','tb_settlement.status','tb_settlement.nominal','tb_settlement.id','tb_settlement.isCircular')->get()->makeHidden(['notes_settlement']);
        }

        return array("data"=>$data->sortByDesc('date')->values()->all());
    }

    public function getDetailSettlement(Request $request)
    {
        $data = Settlement::join('tb_money_request','tb_money_request.id','tb_settlement.no_monreq')->select('tb_money_request.no_monreq','tb_settlement.nominal','tb_settlement.id','tb_settlement.status','account_name','account_number','tb_settlement.issuance',DB::raw('DATE(tb_settlement.date_add) AS date'))->where('tb_settlement.id',$request->id_settlement)->first();

        $pid = SettlementPID::select('pid','nominal')
            ->where('tb_settlement_pid.id_settlement',$request->id_settlement);

        if (isset($request->pid)) {
            $pid = $pid->where('tb_settlement_pid.pid',$request->pid)->get();
        }else{
            $pid = $pid->get();
        }

        $latestIdNotes = DB::table('tb_settlement_notes')
        ->select('id_sub_category','sub_category', DB::raw('MAX(id) as latest_id'))
        ->where('status','NEW')
        ->where('id_settlement',$request->id_settlement)
        ->groupBy('id_sub_category','sub_category');
        
        $dataTransport = DB::table('tb_settlement_notes')
            ->joinSub($latestIdNotes, 'latest_data', function($join) {
                $join->on('tb_settlement_notes.id', '=', 'latest_data.latest_id');
            })
            ->rightJoin('tb_settlement_transport',function($join){
                 $join->on('tb_settlement_notes.id_sub_category', '=', 'tb_settlement_transport.id')
                ->on('tb_settlement_notes.sub_category', '=', 'tb_settlement_transport.sub_category');
            })->leftJoin('tb_settlement','tb_settlement.id','tb_settlement_transport.id_settlement')
            ->select('tb_settlement_transport.id','tb_settlement_transport.nominal', DB::raw("(CASE WHEN (tb_settlement_transport.sub_category = 'Toll') THEN toll_gate WHEN (tb_settlement_transport.sub_category = 'Gasoline') THEN tb_settlement_transport.sub_category WHEN (tb_settlement_transport.sub_category = 'Parking') THEN location WHEN (tb_settlement_transport.sub_category = 'Online Transport') THEN CONCAT(from_transport, ' - ', to_transport) END) as description"),'image','pid',DB::raw("(CASE WHEN (tb_settlement_transport.date is null) THEN '-' ELSE tb_settlement_transport.date END) as date"),'tb_settlement_transport.sub_category',DB::raw("CASE WHEN tb_settlement_notes.notes IS NULL THEN '-' ELSE tb_settlement_notes.notes END as notes"),'tb_settlement_notes.status','tb_settlement_transport.category','id_pid')
            ->where('tb_settlement_transport.id_settlement',$request->id_settlement)->get()->groupby('pid');

        $dataAllowance = DB::table('tb_settlement_notes')
            ->joinSub($latestIdNotes, 'latest_data', function($join) {
                $join->on('tb_settlement_notes.id', '=', 'latest_data.latest_id');
            })
            ->rightJoin('tb_settlement_allowance',function($join){
                 $join->on('tb_settlement_notes.id_sub_category', '=', 'tb_settlement_allowance.id')
                ->on('tb_settlement_notes.sub_category', '=', 'tb_settlement_allowance.sub_category');
            })->leftJoin('tb_settlement','tb_settlement.id','tb_settlement_allowance.id_settlement')
            ->select('tb_settlement_allowance.id','tb_settlement_allowance.nominal',DB::raw('CONCAT(tb_settlement_allowance.sub_category, " - ",name) AS description'),'file as image','pid','tb_settlement_allowance.sub_category',DB::raw("CASE WHEN tb_settlement_notes.notes IS NULL THEN '-' ELSE tb_settlement_notes.notes END as notes"),'tb_settlement_notes.status','tb_settlement_allowance.category',DB::raw("(CASE WHEN (tb_settlement_allowance.date is null) THEN '-' ELSE tb_settlement_allowance.date END) as date"),
                'start_date','id_pid',
                DB::raw('DATEDIFF(end_date, start_date) + 1 as days_diff'),
                DB::raw('
                    CASE 
                        WHEN tb_settlement_allowance.sub_category = "KPHL" 
                            THEN 150000
                    END AS sub_total
                '),
                DB::raw('
                    CASE 
                        WHEN tb_settlement_allowance.sub_category = "KPHL" 
                            THEN (DATEDIFF(end_date, start_date) + 1) * 150000
                    END AS total
                ')

            )
            ->where('tb_settlement_allowance.id_settlement',$request->id_settlement);

        $dataOthers = DB::table('tb_settlement_notes')
            ->joinSub($latestIdNotes, 'latest_data', function($join) {
                $join->on('tb_settlement_notes.id', '=', 'latest_data.latest_id');
            })
            ->rightJoin('tb_settlement_others',function($join){
                 $join->on('tb_settlement_notes.id_sub_category', '=', 'tb_settlement_others.id')
                ->on('tb_settlement_notes.sub_category', '=', 'tb_settlement_others.sub_category');
            })->leftJoin('tb_settlement','tb_settlement.id','tb_settlement_others.id_settlement')
            ->select('tb_settlement_others.id','tb_settlement_others.nominal','description','image','receipt','pid','tb_settlement_others.sub_category',DB::raw("CASE WHEN tb_settlement_notes.notes IS NULL THEN '-' ELSE tb_settlement_notes.notes END as notes"),'id_pid','tb_settlement_notes.status','tb_settlement_others.category',DB::raw("(CASE WHEN (tb_settlement_others.date is null) THEN '-' ELSE tb_settlement_others.date END) as date"))
            ->where('tb_settlement_others.id_settlement',$request->id_settlement);

        $dataEntertain = DB::table('tb_settlement_notes')
            ->joinSub($latestIdNotes, 'latest_data', function($join) {
                $join->on('tb_settlement_notes.id', '=', 'latest_data.latest_id');
            })
            ->rightJoin('tb_settlement_entertain',function($join){
                 $join->on('tb_settlement_notes.id_sub_category', '=', 'tb_settlement_entertain.id')
                ->on('tb_settlement_notes.sub_category', '=', 'tb_settlement_entertain.category');
            })->leftJoin('tb_settlement','tb_settlement.id','tb_settlement_entertain.id_settlement')
            ->select('tb_settlement_entertain.id','tb_settlement_entertain.nominal','resto_name as description','location','image','receipt','receipt_grab','pid',DB::raw("(CASE WHEN (tb_settlement_entertain.date is null) THEN '-' ELSE tb_settlement_entertain.date END) as date"),'id_pid',
                DB::raw("CASE WHEN tb_settlement_notes.notes IS NULL THEN '-' ELSE tb_settlement_notes.notes END as notes"),
                DB::raw("CASE WHEN tb_settlement_entertain.entertainment IS NULL THEN '-' ELSE tb_settlement_entertain.entertainment END as entertainment"),
                DB::raw("
                    (CASE 
                        WHEN (tb_settlement_entertain.sub_category like '%Digital') THEN 'Entertainment' 
                        WHEN (tb_settlement_entertain.sub_category like '%Manual') THEN 'Entertainment' 
                    END) as sub_category"
                ),
                'tb_settlement_notes.status','tb_settlement_entertain.category','tb_settlement_entertain.team_internal','tb_settlement_entertain.team_eksternal')  
            ->where('tb_settlement_entertain.id_settlement',$request->id_settlement);

        if (isset($request->isSettlementExport)) {
            $dataAllowance = $dataAllowance->get();
            $dataEntertain = $dataEntertain->get();
            $dataOthers    = $dataOthers->get();

            $dataAllowance->each(function ($item) {
                $item->sub_category = "Others";
            });

            $dataEntertain->each(function ($item) {
                $item->sub_category = "Others";
            });

            $dataOthers->each(function ($item) {
                $item->sub_category = "Others";
            });

            $dataAllowance = $dataAllowance->groupby('pid');
            $dataEntertain = $dataEntertain->groupby('pid');
            $dataOthers    = $dataOthers->groupby('pid');

            $pid->each(function ($item) use ($dataTransport,$dataAllowance,$dataOthers,$dataEntertain) {
                $item->details = collect();

                if ($dataTransport->get($item->pid)) {
                    $item->details = $item->details->merge($dataTransport->get($item->pid));
                }

                if ($dataAllowance->get($item->pid)) {
                    $item->details = $item->details->merge($dataAllowance->get($item->pid));
                }

                if ($dataOthers->get($item->pid)) {
                    $item->details = $item->details->merge($dataOthers->get($item->pid));
                }

                if ($dataEntertain->get($item->pid)) {
                    $item->details = $item->details->merge($dataEntertain->get($item->pid));
                }
            });

            $dataSubCatTransport = Settlement::join('tb_settlement_transport','tb_settlement_transport.id_settlement','tb_settlement.id')->select('sub_category')->where('id_settlement',$request->id_settlement)->distinct()->get();
            $dataSubCatAllowance = Settlement::join('tb_settlement_allowance','tb_settlement_allowance.id_settlement','tb_settlement.id')->select('sub_category')->where('id_settlement',$request->id_settlement)->distinct()->get();
            $dataSubCatOthers = Settlement::join('tb_settlement_others','tb_settlement_others.id_settlement','tb_settlement.id')->select('sub_category')->where('id_settlement',$request->id_settlement)->distinct()->get();
            $dataSubCatEntertain = Settlement::join('tb_settlement_entertain','tb_settlement_entertain.id_settlement','tb_settlement.id')->select('category as sub_category')->where('id_settlement',$request->id_settlement)->get();

            $getSubCategory = collect();

            $getSubCategory = $getSubCategory
                ->merge($dataSubCatTransport)
                ->merge($dataSubCatAllowance)
                ->merge($dataSubCatOthers)
                ->merge($dataSubCatEntertain);

            $getSubCategory->map(function ($subCat) {
                if ($subCat->sub_category != "Toll" && $subCat->sub_category != "Gasoline" && $subCat->sub_category != "Online Transport" && $subCat->sub_category != "Parking") {
                    $subCat->sub_category = "Others";
                }
            });
 
            $getSubCategory = $getSubCategory->unique('sub_category');
        } else {
            if (isset($request->isAllowanceExport)) {
                $dataAllowance = $dataAllowance->where('pid',$request->pid)->where('tb_settlement_allowance.id',$request->id_sub_category)->get()->groupby('pid');
            }else{
                $dataAllowance = $dataAllowance->get()->groupby('pid');
            }

            if (isset($request->isEntertainExport)) {
                $dataEntertain = $dataEntertain->where('pid',$request->pid)->where('tb_settlement_entertain.id',$request->id_sub_category)->get()->groupby('pid');
            }else{
                $dataEntertain = $dataEntertain->get()->groupby('pid');
            }

            $dataOthers = $dataOthers->get()->groupby('pid');

            $pid->each(function ($item) use ($dataTransport, $dataAllowance, $dataOthers, $dataEntertain) {
                $item->details = collect(); // Inisialisasi sebagai koleksi kosong

                if ($dataTransport->get($item->pid)) {
                    $item->details = $item->details->merge($dataTransport->get($item->pid));
                }

                if ($dataAllowance->get($item->pid)) {
                    $item->details = $item->details->merge($dataAllowance->get($item->pid));
                }

                if ($dataOthers->get($item->pid)) {
                    $item->details = $item->details->merge($dataOthers->get($item->pid));
                }

                if ($dataEntertain->get($item->pid)) {
                    $item->details = $item->details->merge($dataEntertain->get($item->pid));
                }
            });


            $dataSubCatTransport = Settlement::join('tb_settlement_transport','tb_settlement_transport.id_settlement','tb_settlement.id')->select('sub_category')->where('id_settlement',$request->id_settlement)->distinct()->get();
            $dataSubCatAllowance = Settlement::join('tb_settlement_allowance','tb_settlement_allowance.id_settlement','tb_settlement.id')->select('sub_category')->where('id_settlement',$request->id_settlement)->distinct()->get();
            $dataSubCatOthers = Settlement::join('tb_settlement_others','tb_settlement_others.id_settlement','tb_settlement.id')->select('sub_category')->where('id_settlement',$request->id_settlement)->distinct()->get();
            $dataSubCatEntertain = Settlement::join('tb_settlement_entertain','tb_settlement_entertain.id_settlement','tb_settlement.id')->select('category as sub_category')->where('id_settlement',$request->id_settlement)->get();

            $getSubCategory = collect();

            $getSubCategory = $getSubCategory
                ->merge($dataSubCatTransport)
                ->merge($dataSubCatAllowance)
                ->merge($dataSubCatOthers)
                ->merge($dataSubCatEntertain)
                ->unique('sub_category'); 
        }

        $nominalSumsByPidAndSubCategory = collect();

        $pid->each(function ($item) use (&$nominalSumsByPidAndSubCategory) {
            $item->details->each(function ($detail) use ($item, &$nominalSumsByPidAndSubCategory) {
                if (!isset($nominalSumsByPidAndSubCategory[$item->pid])) {
                    $nominalSumsByPidAndSubCategory[$item->pid] = collect();
                }

                $subCategory = $detail->sub_category;
                $nominalSumsByPidAndSubCategory[$item->pid][$subCategory] = isset($nominalSumsByPidAndSubCategory[$item->pid][$subCategory])
                    ? $nominalSumsByPidAndSubCategory[$item->pid][$subCategory] + $detail->nominal
                    : $detail->nominal;
            });
        });

        $subCategoriesByPid = $getSubCategory->map(function ($subCat) use ($nominalSumsByPidAndSubCategory) {
            $subCat->total_by_pid = collect();

            foreach ($nominalSumsByPidAndSubCategory as $pid => $nominals) {
                if (isset($nominals[$subCat->sub_category])) {
                    $subCat->total_by_pid[$pid] = $nominals[$subCat->sub_category];
                } else {
                    $subCat->total_by_pid[$pid] = 0;
                }
            }

            return $subCat;
        });

        // Sum 'nominal' by sub_category
        // $nominalSums = collect();

        // // Sum for transport
        // $dataTransport->each(function ($group) use (&$nominalSums) {
        //     $group->each(function ($item) use (&$nominalSums) {
        //         $nominalSums[$item->sub_category] = isset($nominalSums[$item->sub_category]) 
        //             ? $nominalSums[$item->sub_category] + $item->nominal 
        //             : $item->nominal;
        //     });
        // });

        // // Sum for allowance
        // $dataAllowance->each(function ($group) use (&$nominalSums) {
        //     $group->each(function ($item) use (&$nominalSums) {
        //         $nominalSums[$item->sub_category] = isset($nominalSums[$item->sub_category]) 
        //             ? $nominalSums[$item->sub_category] + $item->nominal 
        //             : $item->nominal;
        //     });
        // });

        // // Sum for others
        // $dataOthers->each(function ($group) use (&$nominalSums) {
        //     $group->each(function ($item) use (&$nominalSums) {
        //         $nominalSums[$item->sub_category] = isset($nominalSums[$item->sub_category]) 
        //             ? $nominalSums[$item->sub_category] + $item->nominal 
        //             : $item->nominal;
        //     });
        // });

        // // Sum for entertainment
        // $dataEntertain->each(function ($group) use (&$nominalSums) {
        //     $group->each(function ($item) use (&$nominalSums) {
        //         $nominalSums[$item->sub_category] = isset($nominalSums[$item->sub_category]) 
        //             ? $nominalSums[$item->sub_category] + $item->nominal 
        //             : $item->nominal;
        //     });
        // });

        // // Attach the sum to each sub_category
        // $getSubCategory = $getSubCategory->map(function ($subCat) use ($nominalSums) {
        //     $subCat->total_nominal = isset($nominalSums[$subCat->sub_category]) 
        //         ? $nominalSums[$subCat->sub_category] 
        //         : 0;
        //     return $subCat;
        // });

        $data->pid_details = $pid;
        $data->sub_category = $subCategoriesByPid;

        $unapproved = DB::table('tb_settlement_activity')
            ->where('tb_settlement_activity.id_settlement', $request->id_settlement)
            ->where('tb_settlement_activity.status', "UNAPPROVED")
            ->orderBy('tb_settlement_activity.id',"DESC")
            ->get();

        $tb_settlement_activity = DB::table('tb_settlement_activity')
            ->where('tb_settlement_activity.id_settlement', $request->id_settlement);

        if(count($unapproved) != 0){
            $tb_settlement_activity->where('tb_settlement_activity.id','>',$unapproved->first()->id);
        }
            
        $tb_settlement_activity->where(function($query){
            $query->where('tb_settlement_activity.status', 'CIRCULAR')
                ->orWhere('tb_settlement_activity.status', 'APPROVED');
        });

        $sign = User::join('role_user', 'role_user.user_id', '=', 'users.nik')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('ttd', 'users.name')
                ->leftJoinSub($tb_settlement_activity,'temp_tb_settlement_activity',function($join){
                    $join->on("users.name","LIKE",DB::raw("CONCAT('%', temp_tb_settlement_activity.operator, '%')"));
                })
                ->where('activity', 'Approval')->orderBy('date_time','asc')->get();

        if ($data->status == 'APPROVED' || $data->status == 'HOLD' || $data->status == 'DONE') {
            $get_ttd = $this->getSignSettlement($request->id_settlement,'show_ttd');

            if (isset($request->isAllowanceExport) || isset($request->isEntertainExport)) {
                $get_ttd = $get_ttd->push(collect(User::join('role_user', 'role_user.user_id', '=', 'users.nik')
                        ->join('roles', 'roles.id', '=', 'role_user.role_id')
                        ->select(
                            'users.name', 
                            'roles.name as position', 
                            'ttd',
                            'email',
                            'avatar'
                        )
                    ->where('nik',$data->issuance)->get()));
            }else{
                $get_ttd = $get_ttd;
            }
        } else {
            $get_ttd = $this->getSignSettlement($request->id_settlement,'getSign');
        }

        $nominal_monreq = DB::table('tb_settlement')->join('tb_money_request','tb_money_request.id','tb_settlement.no_monreq')->where('tb_settlement.id',$request->id_settlement)->select('tb_money_request.nominal')->first();

        if ($data->nominal > $nominal_monreq->nominal) {
            $remaining_funds = $data->nominal - $nominal_monreq->nominal;
        } else {
            $remaining_funds = $nominal_monreq->nominal - $data->nominal;
        }

        return collect([
            'settlement' => $data,
            // 'show_ttd' => $this->getSignMonReq($request->id_money_request,'show_ttd'),
            'tf_from_finance' => (int)$nominal_monreq->nominal,
            'used_amount' => (int)$data->nominal,
            'remaining_funds' =>$remaining_funds,
            'show_ttd' => $sign,
            'getSign' => $get_ttd
        ]);

        // return response()->json($data);
    }

    public function getActivitySettlement(Request $request)
    {
        $getActivity = SettlementActivity::select('activity', 'operator', 'status', 'date_time')
                ->selectRaw("SUBSTR(`tb_settlement_activity`.`date_time`,1,10) AS `date_format`")->where('id_settlement', $request->id_settlement)->orderBy('date_time', 'desc')->get();

        return response()->json($getActivity);
    }

    public function storeNotesSettlement(Request $request)
    {
        $store = new SettlementNotes();
        $store->id_settlement = $request->idSettlement;
        $store->id_sub_category = $request->idSubCategory;
        $store->sub_category = $request->subCategory;
        $store->notes = $request->inputNotes;
        $store->status = 'NEW';
        $store->save();

        return response()->json([
            "action"=> "inserted",
            "tid" => $store->id_settlement
        ]);
    }

    public function resolveNotes(Request $request)
    {
        $data = SettlementNotes::where('id_settlement',$request->idSettlement)->where('id_sub_category',$request->idSubCategory)->where('sub_category',$request->subCategory)->where('status','NEW');

        foreach($data->get() as $data){
            $data->status = 'RESOLVE';
            $data->save();
        }

        $dataId = SettlementNotes::where('id_settlement',$request->idSettlement)->where('id_sub_category',$request->idSubCategory)->where('sub_category',$request->subCategory);

        return response()->json([
            "action"=> "updated",
            "tid" => $dataId->first()->id_settlement
        ]);
    }

    public function getCheckCategory(Request $request)
    {
        $isMonreq = false;

        $data = MoneyRequest::join('tb_money_request_pid','tb_money_request_pid.id_money_request','tb_money_request.id')->join('tb_money_request_detail','tb_money_request_detail.id_money_req_pid','tb_money_request_pid.id')->select('category')->where('pid',$request->pid)->where('id_money_request',$request->id_money_request)->distinct()->get();

        if (count($data)>0) {
            $isMonreq = true;
        } else {
            $lead = DB::table('tb_id_project')->select('lead_id')->where('id_project',$request->pid)->first();

            $data = DB::table('tb_sbe')
                ->join('tb_sbe_config','tb_sbe_config.id_sbe','tb_sbe.id')
                ->join('tb_sbe_detail_config','tb_sbe_config.id','tb_sbe_detail_config.id_config_sbe')
                ->where('tb_sbe_config.status','Choosed')
                ->join('tb_sbe_detail_item','tb_sbe_detail_item.id','tb_sbe_detail_config.detail_item')
                ->select('tb_sbe_detail_item.detail_item as category')
                ->where('lead_id',$lead->lead_id)
                ->where('tb_sbe_detail_item.detail_item','like','%'.request('q').'%')
                ->where('tb_sbe_detail_item.detail_item','not like', 'Travel%')
                ->where('tb_sbe_detail_item.detail_item','not like','Pengiriman%')
                ->where('tb_sbe_detail_item.detail_item','not like','Mandays%')
                ->where('tb_sbe_detail_item.detail_item','not like','Accom%')
                ->where('tb_sbe_detail_item.detail_item','not like','Call%')->distinct()->get();
            $isMonreq = false;
        }

        return response()->json(collect(["data"=>$data,"isMonreq"=>$isMonreq]));
    }

    public function getNotes(Request $request)
    {
        $data = SettlementNotes::where('id_sub_category',$request->idSubCategory)
            ->select('notes','status')
            ->orderBy('id','desc')
            ->first();

        return response()->json($data);
    }

    public function getSignSettlement($id_settlement,$status){
        $data = Settlement::where('id',$id_settlement)->first();
        // $status = 'show_ttd';

        $unapproved = DB::table('tb_settlement_activity')
            ->where('tb_settlement_activity.id_settlement', $id_settlement)
            ->where('tb_settlement_activity.status', "UNAPPROVED")
            ->orderBy('tb_settlement_activity.id',"DESC")
            ->get();

        $tb_settlement_activity = DB::table('tb_settlement_activity')
            ->where('tb_settlement_activity.id_settlement', $id_settlement);

        if(count($unapproved) != 0){
            $tb_settlement_activity->where('tb_settlement_activity.id','>',$unapproved->first()->id);
        }
            
        $tb_settlement_activity->where(function($query){
            $query->where('tb_settlement_activity.status', 'CIRCULAR')
                ->orWhere('tb_settlement_activity.status', 'APPROVED');
        });

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
            $sign->whereRaw("(`roles`.`name` = 'Project Management Office Manager' OR `roles`.`name` = 'VP Program & Project Management' OR `roles`.`name` = 'Chief Operating Officer')")
            ->orderByRaw('FIELD(position, "Project Management Office Manager", "VP Program & Project Management", "Chief Operating Officer")');
        }

        if ($status == 'show_ttd') {
            return $sign->get();
        } else{
            return $sign->get()->where('signed','false')->first()->name;
        }
    }

    public function getExportMonreq(request $request)
    {
        DB::enableQueryLog();
        $dataPost['id_money_request'] = $request->id_money_request;

        // $request = Request::create('/getDetailMonReq', 'POST', $dataPost);
        $newRequest = new Request($dataPost);

        $data = $this->getDetailMonReq($newRequest);
        $queries = DB::getQueryLog();
        // dd($data);

        $pdf = PDF::loadView('PMO.monreq.Pdf.monreq_pdf',compact('data'));

        return $pdf->stream();

        // return $pdf->download();
    }

    public function getDetailbyPid(Request $request)
    {
        $getId = SettlementPID::select('id_settlement','nominal')
            ->where('tb_settlement_pid.pid',$request->pid)
            ->first()->id_settlement;

        $data = Settlement::join('tb_money_request','tb_money_request.id','tb_settlement.no_monreq')->join('tb_settlement_pid','tb_settlement_pid.id_settlement','tb_settlement.id')->select('tb_money_request.no_monreq','tb_settlement_pid.nominal','tb_settlement.id','tb_settlement.status','pid')->where('tb_settlement.id',$getId)->first();

        $pid = SettlementPID::select('id as id_pid','pid','nominal')
            ->where('tb_settlement_pid.pid',$request->pid)
            ->where('tb_settlement_pid.id_settlement',$request->id_settlement)
            ->get();

        $latestIdNotes = DB::table('tb_settlement_notes')
        ->select('id_sub_category','sub_category', DB::raw('MAX(id) as latest_id'))
        ->where('status','NEW')
        ->groupBy('id_sub_category','sub_category');

        $dataTransport = DB::table('tb_settlement_notes')
            ->joinSub($latestIdNotes, 'latest_data', function($join) {
                $join->on('tb_settlement_notes.id', '=', 'latest_data.latest_id');
            })
            ->rightJoin('tb_settlement_transport',function($join){
                 $join->on('tb_settlement_notes.id_sub_category', '=', 'tb_settlement_transport.id')
                ->on('tb_settlement_notes.sub_category', '=', 'tb_settlement_transport.sub_category');
            })->leftJoin('tb_settlement','tb_settlement.id','tb_settlement_transport.id_settlement')
            ->select('tb_settlement_transport.id','tb_settlement_transport.nominal','image as receipt','pid','tb_settlement_transport.date','tb_settlement_transport.sub_category',DB::raw("CASE WHEN tb_settlement_notes.notes IS NULL THEN '-' ELSE tb_settlement_notes.notes END as notes"),'tb_settlement_notes.status','toll_gate','time','name as name_employee','role','location','from_transport','to_transport','driver_name','tb_settlement_transport.category','id_pid')
            ->where('tb_settlement_transport.pid',$request->pid)->where('tb_settlement_transport.id_settlement',$request->id_settlement)->where('tb_settlement_transport.id',$request->id_sub_category)->where('tb_settlement_transport.category',$request->category)->get()->groupby('pid');

        $dataAllowance = DB::table('tb_settlement_notes')
            ->joinSub($latestIdNotes, 'latest_data', function($join) {
                $join->on('tb_settlement_notes.id', '=', 'latest_data.latest_id');
            })
            ->rightJoin('tb_settlement_allowance',function($join){
                 $join->on('tb_settlement_notes.id_sub_category', '=', 'tb_settlement_allowance.id')
                ->on('tb_settlement_notes.sub_category', '=', 'tb_settlement_allowance.sub_category');
            })->leftJoin('tb_settlement','tb_settlement.id','tb_settlement_allowance.id_settlement')
            ->select('tb_settlement_allowance.id','tb_settlement_allowance.nominal','file','pid','tb_settlement_allowance.sub_category',DB::raw("CASE WHEN tb_settlement_notes.notes IS NULL THEN '-' ELSE tb_settlement_notes.notes END as notes"),'tb_settlement_notes.status','tb_settlement_allowance.start_date','tb_settlement_allowance.end_date','tb_settlement_allowance.location','name as name_employee','role','tb_settlement_allowance.category','id_pid')
            ->where('tb_settlement_allowance.pid',$request->pid)->where('tb_settlement_allowance.id_settlement',$request->id_settlement)->where('tb_settlement_allowance.id',$request->id_sub_category)
            ->where('tb_settlement_allowance.category',$request->category)->get()->groupby('pid');

        $dataEntertain = DB::table('tb_settlement_notes')
            ->joinSub($latestIdNotes, 'latest_data', function($join) {
                $join->on('tb_settlement_notes.id', '=', 'latest_data.latest_id');
            })
            ->rightJoin('tb_settlement_entertain',function($join){
                 $join->on('tb_settlement_notes.id_sub_category', '=', 'tb_settlement_entertain.id')
                ->on('tb_settlement_notes.sub_category', '=', 'tb_settlement_entertain.sub_category');
            })->leftJoin('tb_settlement','tb_settlement.id','tb_settlement_entertain.id_settlement')
            ->select('tb_settlement_entertain.id','tb_settlement_entertain.nominal as grand_total','tb_settlement_entertain.nominal as nominal','image as resto_image','receipt','receipt_grab','pid','tb_settlement_entertain.date',DB::raw("CASE WHEN tb_settlement_notes.notes IS NULL THEN '-' ELSE tb_settlement_notes.notes END as notes"),
                DB::raw("CASE WHEN tb_settlement_entertain.entertainment IS NULL THEN '-' ELSE tb_settlement_entertain.entertainment END as entertainment"),
                // DB::raw("(CASE WHEN (tb_settlement_entertain.sub_category like '%Digital') THEN 'Entertainment' WHEN (tb_settlement_entertain.sub_category like '%Manual') THEN 'Entertainment' END) as sub_category"),
                'tb_settlement_entertain.sub_category', 'tb_settlement_entertain.category',
                'tb_settlement_notes.status','resto_name','time','team_internal','team_eksternal','location','name as name_employee','role','id_pid')
            ->where('tb_settlement_entertain.pid',$request->pid)->where('tb_settlement_entertain.id_settlement',$request->id_settlement)->where('tb_settlement_entertain.id',$request->id_sub_category)
            ->where('tb_settlement_entertain.category',$request->category)
            ->get()->groupby('pid');

        $dataOthers = DB::table('tb_settlement_notes')
            ->joinSub($latestIdNotes, 'latest_data', function($join) {
                $join->on('tb_settlement_notes.id', '=', 'latest_data.latest_id');
            })
            ->rightJoin('tb_settlement_others',function($join){
                 $join->on('tb_settlement_notes.id_sub_category', '=', 'tb_settlement_others.id')
                ->on('tb_settlement_notes.sub_category', '=', 'tb_settlement_others.sub_category');
            })->leftJoin('tb_settlement','tb_settlement.id','tb_settlement_others.id_settlement')
            ->select('tb_settlement_others.id','tb_settlement_others.nominal','description','image','receipt','pid','tb_settlement_others.category as sub_category',DB::raw("CASE WHEN tb_settlement_notes.notes IS NULL THEN '-' ELSE tb_settlement_notes.notes END as notes"),'tb_settlement_notes.status','name','role','tb_settlement_others.category','tb_settlement_others.date_add as date','id_pid')
            ->where('tb_settlement_others.pid',$request->pid)->where('tb_settlement_others.id_settlement',$request->id_settlement)->where('tb_settlement_others.id',$request->id_sub_category)
            ->where('tb_settlement_others.category',$request->category)->get()->groupby('pid');

        $pid->each(function ($item) use ($dataTransport, $dataAllowance, $dataEntertain, $dataOthers, $request) {
            $item->details = collect();

            if ($dataTransport->get($item->pid)) {
                $item->details = $item->details->merge($dataTransport->get($item->pid));
            }

            if ($dataAllowance->get($item->pid)) {
                $item->details = $item->details->merge($dataAllowance->get($item->pid));
            }

            if ($dataEntertain->get($item->pid)) {
                $item->details = $item->details->merge($dataEntertain->get($item->pid));
            }

            if ($dataOthers->get($item->pid)) {
                $item->details = $item->details->merge($dataOthers->get($item->pid));
            }

            $item->details = $item->details->groupBy(function ($detail) {
                return $detail->sub_category;
            });

            $item->inputField = collect();

            $subCategories = $item->details->keys()->toArray();

            $detailCategory = DB::table('tb_settlement_category')
                ->select('sub_category', 'title', 'type', 'id_input', 'element')
                ->whereIn('sub_category', $subCategories)
                ->get()
                ->groupBy('sub_category');

            if ($detailCategory->isNotEmpty()) {
                $detailCategory->each(function ($fields, $subCategory) use ($item) {
                    if ($item->details->has($subCategory)) {
                        $item->inputField[$subCategory] = $fields;
                    }
                });
            }

            if ($item->inputField->has('Others')) {
                $others = $item->inputField->pull('Others');
                $item->inputField->put('Others', $others);
            }
        });


        // $dataSubCatTransport = Settlement::join('tb_settlement_transport', 'tb_settlement_transport.id_settlement', 'tb_settlement.id')
        $dataSubCatTransport = DB::table('tb_settlement_transport')
            ->select(DB::raw("category as sub_category"), 'nominal as total_nominal'
                // DB::raw('SUM(tb_settlement_transport.nominal) as total_nominal'),
            )
            ->where('tb_settlement_transport.id_settlement',$request->id_settlement)->where('tb_settlement_transport.id',$request->id_sub_category)->where('tb_settlement_transport.category',$request->category)->where('pid',$request->pid)
            // ->groupBy('sub_category','total_nominal')
            ->get();

        // $dataSubCatAllowance = Settlement::join('tb_settlement_allowance', 'tb_settlement_allowance.id_settlement', 'tb_settlement.id')
        $dataSubCatAllowance = DB::table('tb_settlement_allowance')
            ->select(DB::raw("category as sub_category"),'nominal as total_nominal'
                // DB::raw('SUM(tb_settlement_allowance.nominal) as total_nominal')
            )
            ->where('tb_settlement_allowance.id_settlement',$request->id_settlement)->where('tb_settlement_allowance.id',$request->id_sub_category)->where('pid',$request->pid)->where('tb_settlement_allowance.category',$request->category)
            // ->groupBy('sub_category','total_nominal')
            ->get();

        // $dataSubCatOthers = Settlement::join('tb_settlement_others', 'tb_settlement_others.id_settlement', 'tb_settlement.id')
        $dataSubCatOthers = DB::table('tb_settlement_others')
            ->select(DB::raw("category as sub_category"),'nominal as total_nominal'
                // DB::raw('SUM(tb_settlement_others.nominal) as total_nominal')
            )
            ->where('tb_settlement_others.id_settlement',$request->id_settlement)->where('tb_settlement_others.id',$request->id_sub_category)->where('pid',$request->pid)->where('tb_settlement_others.category',$request->category)
            // ->groupBy('sub_category','total_nominal')
            ->get();

        // $dataSubCatEntertain = Settlement::join('tb_settlement_entertain', 'tb_settlement_entertain.id_settlement', 'tb_settlement.id')
        $dataSubCatEntertain = DB::table('tb_settlement_entertain')
            ->select(DB::raw("category as sub_category"),'nominal as total_nominal'
                // DB::raw('SUM(tb_settlement_entertain.nominal) as total_nominal')
            )
            ->where('tb_settlement_entertain.id_settlement',$request->id_settlement)->where('tb_settlement_entertain.id',$request->id_sub_category)->where('pid',$request->pid)->where('tb_settlement_entertain.category',$request->category)
            ->where(function ($query) {
                $query->where('tb_settlement_entertain.sub_category', 'like', '%Digital')
                      ->orWhere('tb_settlement_entertain.sub_category', 'like', '%Manual');
            })
            // ->groupBy('sub_category','total_nominal')
            ->get();

        $getSubCategory = collect();

        $getSubCategory = $getSubCategory
            ->merge($dataSubCatTransport)
            ->merge($dataSubCatAllowance)
            ->merge($dataSubCatEntertain)
            ->merge($dataSubCatOthers);

        // $getSubCategory = $getSubCategory->groupBy('sub_category')->map(function ($categoryGroup) {
        //     return [
        //         'sub_category' => $categoryGroup->first()->sub_category,
        //         'total_nominal' => $categoryGroup->sum('total_nominal'),
        //     ];
        // })->values();

        $data->pid_details = $pid;
        $data->sub_category = $getSubCategory;

        $nominal_monreq = DB::table('tb_settlement')->join('tb_money_request','tb_money_request.id','tb_settlement.no_monreq')->where('tb_settlement.id',$getId)->select('tb_money_request.nominal')->first();

        if ($data->nominal > $nominal_monreq->nominal) {
            $remaining_funds = $data->nominal - $nominal_monreq->nominal;
        } else {
            $remaining_funds = $nominal_monreq->nominal - $data->nominal;
        }

        return collect([
            'settlement' => $data
            // 'show_ttd' => $this->getSignMonReq($request->id_money_request,'show_ttd'),
            // 'tf_from_finance' => $nominal_monreq->nominal,
            // 'used_amount' => $data->nominal,
            // 'remaining_funds' =>$remaining_funds
        ]);
    }

    public function getDetailSettlementById(Request $request)
    {
        $id = $request->id;
        $sub_category = $request->sub_category;

        if ($sub_category == 'Toll') {
            $data = DB::table('tb_settlement_transport')->leftJoin('tb_settlement','tb_settlement.id','tb_settlement_transport.id_settlement')
            ->select('tb_settlement_transport.id','tb_settlement_transport.nominal','image','pid','tb_settlement_transport.date','tb_settlement_transport.sub_category','toll_gate','time','name','role','tb_settlement_transport.category')
            ->where('tb_settlement_transport.id',$id)->get();
        } elseif ($sub_category == 'Gasoline') {
            // code...
        } elseif ($sub_category == 'Parking') {
            // code...
        } elseif ($sub_category == 'Online Transport') {
            // code...
        } elseif ($sub_category == 'Allowance') {
            // code...
        } elseif ($sub_category == 'KPHL') {
            // code...
        } elseif ($sub_category == 'Struk Manual') {
            // code...
        } elseif ($sub_category == 'Struk Digital') {
            // code...
        } else {

        }
        return $data;
    }

    public function storeSettlement(Request $request)
    {
        try{
            $data = json_decode($request['arrDataSettlement'],true);
            // $customKey = 0;
            $customKey2 = 0;

            foreach ($data as $mainKey => $dataArray) {

                $getMonReq = DB::table('tb_money_request')->where('id',$mainKey)->select('no_monreq')->first()->no_monreq;

                $store = new Settlement();
                $store->issuance = Auth::User()->nik;
                $store->date = date('Y-m-d');
                $store->no_monreq = $mainKey;
                $store->status = 'NEW';
                $store->isCircular = 'False';
                $store->date_add = Carbon::now()->toDateTimeString();
                $store->save();

                MoneyRequest::where('id', $mainKey)->update(['status_settlement' => 'NEW']);

                foreach ($dataArray as $keyPid => $value) {
                    $storeSettlementPID = new SettlementPID();
                    $storeSettlementPID->id_settlement = $store->id;
                    $storeSettlementPID->pid = $keyPid;
                    $storeSettlementPID->date_add = Carbon::now()->toDateTimeString();
                    $nominalSum = 0;
                    $nominalSum = array_reduce(
                        $value['detail']['nominal'] ?? [],
                        fn($sum, $amount) => is_numeric($amount) ? $sum + intval($amount) : $sum,
                        0
                    );
                    $storeSettlementPID->nominal = $nominalSum;
                    $storeSettlementPID->save();

                    foreach (['Toll', 'Gasoline', 'OnlineTransport', 'Parking'] as $category) {
                        foreach ($value['item'] as $keyCategory => $settlement) {
                            if (isset($settlement[$category])) {
                                $customKey2=0;
                                foreach ($settlement[$category] as $data) {
                                    $subCategory = ($category === 'OnlineTransport') ? 'Online Transport' : $category;
                                    $customKey2++;
                                    $toll = $data['idTollGate'] ?? null;
                                    $storeTransport = new SettlementTransport([
                                        'id_settlement' => $store->id,
                                        'pid' => $keyPid,
                                        'date' => $data['idDate'] ?? null,
                                        'time' => $data['idTime'] ?? null,
                                        'name' => $data['idNameEmployee'] ?? null,
                                        'role' => $data['idRole'] ?? null,
                                        // 'toll_gate' => $data['idTollGate'] ?? null,
                                        'from_transport' => $data['idFromTransport'] ?? null,
                                        'to_transport' => $data['idToTransport'] ?? null,
                                        'driver_name' => $data['idDriverName'] ?? null,
                                        'location' => $data['idLocation'] ?? null,
                                        'nominal' => isset($data['idNominal']) ? str_replace('.', '', $data['idNominal']) : null,
                                        'sub_category' => $subCategory,
                                        'id_pid' => $storeSettlementPID->id,
                                        'date_add' => now()->toDateTimeString(),
                                    ]);
                                    $image = $this->handleFileUpload($request, $mainKey, $keyPid, $category, $customKey2, $data, $store);
                                    $storeTransport->save();
                                    SettlementTransport::where('id', $storeTransport->id)->update(['image' => $image,'category'=>'Transport','toll_gate'=>$toll]);
                                }
                            }
                        }
                    }

                    foreach (['Allowance', 'KPHL'] as $allowanceCategory) {
                        foreach ($value['item'] as $keyCategory => $settlement) {
                            if (isset($settlement[$allowanceCategory])) {
                                $customKey2=0;
                                foreach ($settlement[$allowanceCategory] as $data) {
                                    $customKey2++;
                                    log::info(['info_allowance',$customKey2]);
                                    $storeAllowance = new SettlementAllowance([
                                        'id_settlement' => $store->id,
                                        'pid' => $keyPid,
                                        'start_date' => $data['idStartDate'] ?? null,
                                        'end_date' => $data['idEndDate'] ?? null,
                                        'name' => $data['idNameEmployee'] ?? null,
                                        'role' => $data['idRole'] ?? null,
                                        'location' => $data['idLocation'] ?? null,
                                        'nominal' => isset($data['idNominal']) ? str_replace('.', '', $data['idNominal']) : null,
                                        'category' => 'Allowance',
                                        'sub_category' => $allowanceCategory,
                                        'id_pid' => $storeSettlementPID->id,
                                        'date_add' => now()->toDateTimeString(),
                                    ]);
                                    $file = $this->handleFileUpload($request, $mainKey, $keyPid, $allowanceCategory, $customKey2, $data, $store);
                                    $storeAllowance->save();
                                    SettlementAllowance::where('id', $storeAllowance->id)->update(['file' => $file,'category'=>'Allowance']);
                                }
                            }
                        }
                    }

                    foreach (['StrukManual', 'StrukDigital'] as $entertainCategory) {
                        foreach ($value['item'] as $keyCategory => $settlement) {
                            if (isset($settlement[$entertainCategory])) {
                                $customKey2=0;
                                foreach ($settlement[$entertainCategory] as $data) {
                                    $subCategory = ($entertainCategory === 'StrukManual') ? 'Struk Manual' : (($entertainCategory === 'StrukDigital') ? 'Struk Digital' : $entertainCategory);
                                    $customKey2++;
                                    log::info(['info_entertain',$customKey2]);
                                    $storeEntertain = new SettlementEntertain([
                                        'id_settlement' => $store->id,
                                        'pid' => $keyPid,
                                        'resto_name' => $data['idRestoName'] ?? null,
                                        'date' => $data['idDate'] ?? null,
                                        'time' => $data['idTime'] ?? null,
                                        'name' => $data['idNameEmployee'] ?? null,
                                        'role' => $data['idRole'] ?? null,
                                        'team_internal' => $data['idTeamInternal'] ?? null,
                                        'team_eksternal' => $data['idTeamEksternal'] ?? null,
                                        'location' => $data['idLocation'] ?? null,
                                        'entertainment' => $data['idEntertainment'] ?? null,
                                        'nominal' => isset($data['idNominal']) ? str_replace('.', '', $data['idNominal']) : null,
                                        'receipt_grab' => $data['idReceiptGrab'] ?? null,
                                        'date_add' => now()->toDateTimeString(),
                                        'id_pid' => $storeSettlementPID->id,
                                        'sub_category' => $subCategory
                                    ]);
                                    if ($subCategory == 'Struk Manual') {
                                        $image = $this->handleFileUpload($request, $mainKey, $keyPid, $entertainCategory, $customKey2, $data, $store);
                                    } else {
                                        $image = null;
                                    }
                                    $receipt = $this->handleFileUploadReceipt($request, $mainKey, $keyPid, $entertainCategory, $customKey2, $data, $store);
                                    // $storeEntertain->save();
                                    // SettlementEntertain::where('id', $storeEntertain->id)->update(['image' => $image,'receipt'=>$receipt,'category'=>'Entertainment']);
                                    $receipt_grab = $this->handleFileUploadReceiptGrab($request, $mainKey, $keyPid, $entertainCategory, $customKey2, $data, $store);
                                    $storeEntertain->save();
                                    SettlementEntertain::where('id', $storeEntertain->id)->update(['image' => $image,'receipt'=>$receipt,'receipt_grab'=>$receipt_grab,'category'=>'Entertainment']);
                                }
                            }
                        }
                    }

                    foreach (['ATK','MaterialSupport','Messanger'] as $othersCategory) {
                        foreach ($value['item'] as $keyCategory => $settlement) {
                            if (isset($settlement[$othersCategory])) {
                                $customKey2=0;
                                foreach ($settlement[$othersCategory] as $data) {
                                    $subCategory = ($othersCategory === 'MaterialSupport') ? 'Material Support' : $othersCategory;
                                    $customKey2++;
                                    log::info(['info_others',$customKey2]);
                                    $storeOthers = new SettlementOther([
                                        'id_settlement' => $store->id,
                                        'pid' => $keyPid,
                                        'description' => $data['idDescription'] ?? null,
                                        'name' => $data['idNameEmployee'] ?? null,
                                        'role' => $data['idRole'] ?? null,
                                        'nominal' => isset($data['idNominal']) ? str_replace('.', '', $data['idNominal']) : null,
                                        'date_add' => now()->toDateTimeString(),
                                        'date' => $data['idDate'] ?? null,
                                        'id_pid' => $storeSettlementPID->id,
                                        'sub_category' => $subCategory
                                    ]);
                                    $receipt = $this->handleFileUpload($request, $mainKey, $keyPid, $othersCategory, $customKey2, $data, $store);
                                    $image = $this->handleFileUploadReceipt($request, $mainKey, $keyPid, $othersCategory, $customKey2, $data, $store);
                                    $storeOthers->save();
                                    SettlementOther::where('id', $storeOthers->id)->update(['image' => $image,'receipt'=>$receipt,'category'=>'Others']);
                                }
                            }
                        }
                    }

                    // foreach ($value['item'] as $keyCategory => $settlement) {
                    //     // ++$customKey;
                    //     // if (isset($settlement['Toll'])) {
                    //     //     foreach ($settlement['Toll'] as $keyItem => $data) {
                    //     //         ++$customKey2;
                    //     //         $storeTransport = new SettlementTransport();
                    //     //         $storeTransport->id_settlement =  $store->id;
                    //     //         $storeTransport->pid =  $keyPid;
                    //     //         $storeTransport->date = isset($data['idDate']) ? $data['idDate'] : null;
                    //     //         $storeTransport->time = isset($data['idTime']) ? $data['idTime'] : null;
                    //     //         $storeTransport->name = isset($data['idNameEmployee']) ? $data['idNameEmployee'] : null;
                    //     //         $storeTransport->role = isset($data['idRole']) ? $data['idRole'] : null;
                    //     //         $storeTransport->nominal = isset($data['idNominal']) ? str_replace('.', '',$data['idNominal']) : null;
                    //     //         $storeTransport->toll_gate = isset($data['idTollGate']) ? $data['idTollGate'] : null;
                    //     //         $storeTransport->date_add =  Carbon::now()->toDateTimeString();
                    //     //         $storeTransport->category =  'Transport';
                    //     //         $storeTransport->sub_category =  'Toll';
                    //     //         if ($request->hasFile('file_'.$mainKey.'_'.$keyPid.'_Toll_idUploadReceipt_'.$customKey2)) {
                    //     //             $file                   = $request->file('file_'.$mainKey.'_'.$keyPid.'_Toll_idUploadReceipt_'.$customKey2);
                    //     //             $fileName               = 'Toll '.$data['idTollGate'].'.'.$file->getClientOriginalExtension();
                    //     //             $filePath               = $file->getRealPath();
                    //     //             $extension              = $file->getClientOriginalExtension();

                    //     //             $update = Settlement::where('id',$store->id)->first();

                    //     //             if ($update->parent_id_drive == null) {
                    //     //                 $parentID = $this->googleDriveMakeFolderSettlement($getMonReq);
                    //     //             } else {
                    //     //                 $parentID = [];
                    //     //                 $parent_id = explode('"', $update->parent_id_drive)[1];
                    //     //                 array_push($parentID,$parent_id);
                    //     //             }
                    //     //             Log::info($fileName);

                    //     //             $update->parent_id_drive = $parentID;
                    //     //             $update->save();
                    //     //             $storeTransport->image = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                    //     //             Log::Info('file_'.$mainKey.'_'.$keyPid.'_Toll_idUploadReceipt_'.$customKey2);
                    //     //         } 
                    //     //         $storeTransport->save();
                    //     //         Log::info('stored');
                    //     //     }
                    //     // }
                    //     // if (isset($settlement['Gasoline'])) {
                    //     //     $customKey2 = 0;
                    //     //     foreach ($settlement['Gasoline'] as $keyItem => $data) {
                    //     //         ++$customKey2;
                    //     //         $storeTransport = new SettlementTransport();
                    //     //         $storeTransport->id_settlement =  $store->id;
                    //     //         $storeTransport->pid =  $keyPid;
                    //     //         $storeTransport->date = isset($data['idDate']) ? $data['idDate'] : null;
                    //     //         $storeTransport->name = isset($data['idNameEmployee']) ? $data['idNameEmployee'] : null;
                    //     //         $storeTransport->role = isset($data['idRole']) ? $data['idRole'] : null;
                    //     //         $storeTransport->nominal = isset($data['idNominal']) ? str_replace('.', '',$data['idNominal']) : null;
                    //     //         $storeTransport->date_add =  Carbon::now()->toDateTimeString();
                    //     //         $storeTransport->category =  'Transport';
                    //     //         $storeTransport->sub_category =  'Gasoline';

                    //     //         if ($request->hasFile('file_'.$mainKey.'_'.$keyPid.'_Gasoline_idUploadReceipt_'.$customKey2)) {
                    //     //             $file                   = $request->file('file_'.$mainKey.'_'.$keyPid.'_Gasoline_idUploadReceipt_'.$customKey2);
                    //     //             $fileName               = 'Gasoline.'.$file->getClientOriginalExtension();
                    //     //             $filePath               = $file->getRealPath();
                    //     //             $extension              = $file->getClientOriginalExtension();

                    //     //             $update = Settlement::where('id',$store->id)->first();
                    //     //             if ($update->parent_id_drive == null) {
                    //     //                 $parentID = $this->googleDriveMakeFolderSettlement($getMonReq);
                    //     //             } else {
                    //     //                 $parentID = [];
                    //     //                 $parent_id = explode('"', $update->parent_id_drive)[1];
                    //     //                 array_push($parentID,$parent_id);
                    //     //             }

                    //     //             Log::info($fileName);

                    //     //             $update->parent_id_drive = $parentID;
                    //     //             $update->save();
                    //     //             $storeTransport->image = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                    //     //             Log::Info('file_'.$mainKey.'_'.$keyPid.'_Gasoline_idUploadReceipt_'.$customKey2);
                    //     //         } 
                    //     //         $storeTransport->save();
                    //     //         Log::info('stored');
                    //     //     }
                    //     // }
                    //     // if (isset($settlement['Online_Transport'])) {
                    //     //     $customKey2 = 0;
                    //     //     foreach ($settlement['Online_Transport'] as $keyItem => $data) {
                    //     //         ++$customKey2;
                    //     //         $storeTransport = new SettlementTransport();
                    //     //         $storeTransport->id_settlement =  $store->id;
                    //     //         $storeTransport->pid =  $keyPid;
                    //     //         $storeTransport->date = isset($data['idDate']) ? $data['idDate'] : null;
                    //     //         $storeTransport->name = isset($data['idNameEmployee']) ? $data['idNameEmployee'] : null;
                    //     //         $storeTransport->role = isset($data['idRole']) ? $data['idRole'] : null;
                    //     //         $storeTransport->nominal = isset($data['idNominal']) ? str_replace('.', '',$data['idNominal']) : null;
                    //     //         $storeTransport->from_transport = isset($data['idFromTransport']) ? $data['idFromTransport'] : null;
                    //     //         $storeTransport->to_transport = isset($data['idToTransport']) ? $data['idToTransport'] : null;
                    //     //         $storeTransport->driver_name = isset($data['idDriverName']) ? $data['idDriverName'] : null;
                    //     //         $storeTransport->date_add =  Carbon::now()->toDateTimeString();
                    //     //         $storeTransport->category =  'Transport';
                    //     //         $storeTransport->sub_category = 'Online Transport';

                    //     //         if ($request->hasFile('file_'.$mainKey.'_'.$keyPid.'_Online_Transport_idUploadReceipt_'.$customKey2)) {
                    //     //             Log::info('ada file ojol');
                    //     //             $file                   = $request->file('file_'.$mainKey.'_'.$keyPid.'_Online_Transport_idUploadReceipt_'.$customKey2);
                    //     //             $fileName               = 'Ojol '.$data['idDriverName'].'.'.$file->getClientOriginalExtension();
                    //     //             $filePath               = $file->getRealPath();
                    //     //             $extension              = $file->getClientOriginalExtension();

                    //     //             $update = Settlement::where('id',$store->id)->first();
                    //     //             if ($update->parent_id_drive == null) {
                    //     //                 $parentID = $this->googleDriveMakeFolderSettlement($getMonReq);
                    //     //             } else {
                    //     //                 $parentID = [];
                    //     //                 $parent_id = explode('"', $update->parent_id_drive)[1];
                    //     //                 array_push($parentID,$parent_id);
                    //     //             }

                    //     //             $update->parent_id_drive = $parentID;
                    //     //             $update->save();
                    //     //             $storeTransport->image = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                    //     //             Log::Info('file_'.$mainKey.'_'.$keyPid.'_Online_Transport_idUploadReceipt_'.$customKey);
                    //     //         } 
                    //     //         $storeTransport->save();
                    //     //         Log::info('stored');
                    //     //     }
                    //     // }
                    //     // if (isset($settlement['Parking'])) {
                    //     //     $customKey2 = 0;
                    //     //     foreach ($settlement['Parking'] as $keyItem => $data) {
                    //     //         ++$customKey2;
                    //     //         $storeTransport = new SettlementTransport();
                    //     //         $storeTransport->id_settlement =  $store->id;
                    //     //         $storeTransport->pid =  $keyPid;
                    //     //         $storeTransport->date = isset($data['idDate']) ? $data['idDate'] : null;
                    //     //         $storeTransport->name = isset($data['idNameEmployee']) ? $data['idNameEmployee'] : null;
                    //     //         $storeTransport->role = isset($data['idRole']) ? $data['idRole'] : null;
                    //     //         $storeTransport->nominal = isset($data['idNominal']) ? str_replace('.', '',$data['idNominal']) : null;
                    //     //         $storeTransport->location = isset($data['idLocation']) ? $data['idLocation'] : null;
                    //     //         $storeTransport->date_add =  Carbon::now()->toDateTimeString();
                    //     //         $storeTransport->category =  'Transport';
                    //     //         $storeTransport->sub_category =  'Parking';
                    //     //         if ($request->hasFile('file_'.$mainKey.'_'.$keyPid.'_Parking_idUploadReceipt_'.$customKey2)) {
                    //     //             $file                   = $request->file('file_'.$mainKey.'_'.$keyPid.'_Parking_idUploadReceipt_'.$customKey2);
                    //     //             $fileName               = 'Parking '.$data['idLocation'].'.'.$file->getClientOriginalExtension();
                    //     //             $filePath               = $file->getRealPath();
                    //     //             $extension              = $file->getClientOriginalExtension();

                    //     //             $update = Settlement::where('id',$store->id)->first();
                    //     //             if ($update->parent_id_drive == null) {
                    //     //                 $parentID = $this->googleDriveMakeFolderSettlement($getMonReq);
                    //     //             } else {
                    //     //                 $parentID = [];
                    //     //                 $parent_id = explode('"', $update->parent_id_drive)[1];
                    //     //                 array_push($parentID,$parent_id);
                    //     //             }

                    //     //             $update->parent_id_drive = $parentID;
                    //     //             $update->save();
                    //     //             $storeTransport->image = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                    //     //         } 
                    //     //         $storeTransport->save();
                    //     //         Log::info('stored');
                    //     //     }
                    //     // }
                    //     // if (isset($settlement['Allowance'])) {
                    //     //     $customKey2 = 0;
                    //     //     foreach ($settlement['Allowance'] as $keyItem => $data) {
                    //     //         ++$customKey2;
                    //     //         $storeAllowance = new SettlementAllowance();
                    //     //         $storeAllowance->id_settlement =  $store->id;
                    //     //         $storeAllowance->pid =  $keyPid;
                    //     //         $storeAllowance->start_date = isset($data['idStartDate']) ? $data['idStartDate'] : null;
                    //     //         $storeAllowance->end_date = isset($data['idEndDate']) ? $data['idEndDate'] : null;
                    //     //         $storeAllowance->name = isset($data['idNameEmployee']) ? $data['idNameEmployee'] : null;
                    //     //         $storeAllowance->role = isset($data['idRole']) ? $data['idRole'] : null;
                    //     //         $storeAllowance->location = isset($data['idLocation']) ? $data['idLocation'] : null;
                    //     //         $storeAllowance->nominal = isset($data['idNominal']) ? str_replace('.', '',$data['idNominal']) : null;
                    //     //         $storeAllowance->date_add =  Carbon::now()->toDateTimeString();
                    //     //         $storeAllowance->category =  'Allowance';
                    //     //         $storeAllowance->sub_category =  'Allowance';
                    //     //         if ($request->hasFile('file_'.$mainKey.'_'.$keyPid.'_Allowance_idUploadFile_'.$customKey2)) {
                    //     //             $file                   = $request->file('file_'.$mainKey.'_'.$keyPid.'_Allowance_idUploadFile_'.$customKey2);
                    //     //             $fileName               = 'Allowance '.$data['idNameEmployee'].'.'.$file->getClientOriginalExtension();
                    //     //             $filePath               = $file->getRealPath();
                    //     //             $extension              = $file->getClientOriginalExtension();

                    //     //             $update = Settlement::where('id',$store->id)->first();
                    //     //             if ($update->parent_id_drive == null) {
                    //     //                 $parentID = $this->googleDriveMakeFolderSettlement($getMonReq);
                    //     //             } else {
                    //     //                 $parentID = [];
                    //     //                 $parent_id = explode('"', $update->parent_id_drive)[1];
                    //     //                 array_push($parentID,$parent_id);
                    //     //             }

                    //     //             $update->parent_id_drive = $parentID;
                    //     //             $update->save();
                    //     //             $storeAllowance->file = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                    //     //         } 
                    //     //         $storeAllowance->save();
                    //     //         Log::info('stored');
                    //     //     }
                    //     // }
                    //     // if (isset($settlement['KPHL'])) {
                    //     //     $customKey2 = 0;
                    //     //     foreach ($settlement['KPHL'] as $keyItem => $data) {
                    //     //         ++$customKey2;
                    //     //         $storeAllowance = new SettlementAllowance();
                    //     //         $storeAllowance->id_settlement =  $store->id;
                    //     //         $storeAllowance->pid =  $keyPid;
                    //     //         $storeAllowance->start_date = isset($data['idStartDate']) ? $data['idStartDate'] : null;
                    //     //         $storeAllowance->end_date = isset($data['idEndDate']) ? $data['idEndDate'] : null;
                    //     //         $storeAllowance->name = isset($data['idNameEmployee']) ? $data['idNameEmployee'] : null;
                    //     //         $storeAllowance->role = isset($data['idRole']) ? $data['idRole'] : null;
                    //     //         $storeAllowance->location = isset($data['idLocation']) ? $data['idLocation'] : null;
                    //     //         $storeAllowance->nominal = isset($data['idNominal']) ? str_replace('.', '',$data['idNominal']) : null;
                    //     //         $storeAllowance->date_add =  Carbon::now()->toDateTimeString();
                    //     //         $storeAllowance->category =  'Allowance';
                    //     //         $storeAllowance->sub_category =  'KPHL';
                    //     //         if ($request->hasFile('file_'.$mainKey.'_'.$keyPid.'_KPHL_idUploadFile_'.$customKey2)) {
                    //     //             $file                   = $request->file('file_'.$mainKey.'_'.$keyPid.'_Allowance_idUploadFile_'.$customKey2);
                    //     //             $fileName               = 'KPHL '.$data['idNameEmployee'].'.'.$file->getClientOriginalExtension();
                    //     //             $filePath               = $file->getRealPath();
                    //     //             $extension              = $file->getClientOriginalExtension();

                    //     //             $update = Settlement::where('id',$store->id)->first();
                    //     //             if ($update->parent_id_drive == null) {
                    //     //                 $parentID = $this->googleDriveMakeFolderSettlement($getMonReq);
                    //     //             } else {
                    //     //                 $parentID = [];
                    //     //                 $parent_id = explode('"', $update->parent_id_drive)[1];
                    //     //                 array_push($parentID,$parent_id);
                    //     //             }

                    //     //             $update->parent_id_drive = $parentID;
                    //     //             $update->save();
                    //     //             $storeAllowance->file = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                    //     //         } 
                    //     //         $storeAllowance->save();
                    //     //         Log::info('stored');
                    //     //     }
                    //     // }
                    //     // if (isset($settlement['Struk Manual'])) {
                    //     //     $customKey2 = 0;
                    //     //     foreach ($settlement['Struk Manual'] as $keyItem => $data) {
                    //     //         ++$customKey2;
                    //     //         $storeEntertain = new SettlementEntertain();
                    //     //         $storeEntertain->id_settlement =  $store->id;
                    //     //         $storeEntertain->pid =  $keyPid;
                    //     //         $storeEntertain->resto_name = isset($data['idRestoName']) ? $data['idRestoName'] : null;
                    //     //         $storeEntertain->date = isset($data['idDate']) ? $data['idDate'] : null;
                    //     //         $storeEntertain->time = isset($data['idTime']) ? $data['idTime'] : null;
                    //     //         $storeEntertain->name = isset($data['idNameEmployee']) ? $data['idNameEmployee'] : null;
                    //     //         $storeEntertain->role = isset($data['idRole']) ? $data['idRole'] : null;
                    //     //         $storeEntertain->team_internal = isset($data['idTeamInternal']) ? $data['idTeamInternal'] : null;
                    //     //         $storeEntertain->team_eksternal = isset($data['idTeamEksternal']) ? $data['idTeamEksternal'] : null;
                    //     //         $storeEntertain->location = isset($data['idLocation']) ? $data['idLocation'] : null;
                    //     //         $storeEntertain->entertainment = isset($data['idEntertainment']) ? $data['idEntertainment'] : null;
                    //     //         $storeEntertain->nominal = isset($data['idNominal']) ? str_replace('.', '',$data['idNominal']) : null;
                    //     //         $storeEntertain->date_add =  Carbon::now()->toDateTimeString();
                    //     //         $storeEntertain->category =  'Entertainment';
                    //     //         $storeEntertain->sub_category =  'Struk Manual';
                    //     //         if ($request->hasFile('file_'.$mainKey.'_'.$keyPid.'_Struk Manual_idRestoImage_'.$customKey2)) {
                    //     //             $file                   = $request->file('file_'.$mainKey.'_'.$keyPid.'_Struk Manual_idRestoImage_'.$customKey2);
                    //     //             $fileName               = 'Entertain '.$data['idRestoName'].'.'.$file->getClientOriginalExtension();
                    //     //             $filePath               = $file->getRealPath();
                    //     //             $extension              = $file->getClientOriginalExtension();

                    //     //             $update = Settlement::where('id',$store->id)->first();
                    //     //             if ($update->parent_id_drive == null) {
                    //     //                 $parentID = $this->googleDriveMakeFolderSettlement($getMonReq);
                    //     //             } else {
                    //     //                 $parentID = [];
                    //     //                 $parent_id = explode('"', $update->parent_id_drive)[1];
                    //     //                 array_push($parentID,$parent_id);
                    //     //             }

                    //     //             $update->parent_id_drive = $parentID;
                    //     //             $update->save();
                    //     //             $storeEntertain->image = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                    //     //         } 

                    //     //         if ($request->hasFile('file_'.$mainKey.'_'.$keyPid.'_Struk Manual_idReceiptImage_'.$customKey2)) {
                    //     //             $file                   = $request->file('file_'.$mainKey.'_'.$keyPid.'_Struk Manual_idReceiptImage_'.$customKey2);
                    //     //             $fileName               = 'Entertain '.$data['idRestoName'].'.'.$file->getClientOriginalExtension();
                    //     //             $filePath               = $file->getRealPath();
                    //     //             $extension              = $file->getClientOriginalExtension();

                    //     //             $update = Settlement::where('id',$store->id)->first();
                    //     //             if ($update->parent_id_drive == null) {
                    //     //                 $parentID = $this->googleDriveMakeFolderSettlement($getMonReq);
                    //     //             } else {
                    //     //                 $parentID = [];
                    //     //                 $parent_id = explode('"', $update->parent_id_drive)[1];
                    //     //                 array_push($parentID,$parent_id);
                    //     //             }

                    //     //             $update->parent_id_drive = $parentID;
                    //     //             $update->save();
                    //     //             $storeEntertain->receipt = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                    //     //         } 
                    //     //         $storeEntertain->save();
                    //     //         Log::info('stored');
                    //     //     }
                    //     // }
                    //     // if (isset($settlement['Struk Digital'])) {
                    //     //     $customKey2 = 0;
                    //     //     foreach ($settlement['Struk Digital'] as $keyItem => $data) {
                    //     //         ++$customKey2;
                    //     //         $storeEntertain = new SettlementEntertain();
                    //     //         $storeEntertain->id_settlement =  $store->id;
                    //     //         $storeEntertain->pid =  $keyPid;
                    //     //         $storeEntertain->resto_name = isset($data['idRestoName']) ? $data['idRestoName'] : null;
                    //     //         $storeEntertain->date = isset($data['idDate']) ? $data['idDate'] : null;
                    //     //         $storeEntertain->time = isset($data['idTime']) ? $data['idTime'] : null;
                    //     //         $storeEntertain->name = isset($data['idNameEmployee']) ? $data['idNameEmployee'] : null;
                    //     //         $storeEntertain->role = isset($data['idRole']) ? $data['idRole'] : null;
                    //     //         $storeEntertain->team_internal = isset($data['idTeamInternal']) ? $data['idTeamInternal'] : null;
                    //     //         $storeEntertain->team_eksternal = isset($data['idTeamEksternal']) ? $data['idTeamEksternal'] : null;
                    //     //         $storeEntertain->location = isset($data['idLocation']) ? $data['idLocation'] : null;
                    //     //         $storeEntertain->nominal = isset($data['idNominal']) ? str_replace('.', '',$data['idNominal']) : null;
                    //     //         $storeEntertain->entertainment = isset($data['idEntertainment']) ? $data['idEntertainment'] : null;
                    //     //         $storeEntertain->date_add =  Carbon::now()->toDateTimeString();
                    //     //         $storeEntertain->category =  'Entertainment';
                    //     //         $storeEntertain->sub_category =  'Struk Digital';

                    //     //         if ($request->hasFile('file_'.$mainKey.'_'.$keyPid.'_Struk Digital_idReceiptImage_'.$customKey2)) {
                    //     //             $file                   = $request->file('file_'.$mainKey.'_'.$keyPid.'_Struk Digital_idReceiptImage_'.$customKey2);
                    //     //             $fileName               = 'Entertain '.$data['idRestoName'].'.'.$file->getClientOriginalExtension();
                    //     //             $filePath               = $file->getRealPath();
                    //     //             $extension              = $file->getClientOriginalExtension();

                    //     //             $update = Settlement::where('id',$store->id)->first();
                    //     //             if ($update->parent_id_drive == null) {
                    //     //                 $parentID = $this->googleDriveMakeFolderSettlement($getMonReq);
                    //     //             } else {
                    //     //                 $parentID = [];
                    //     //                 $parent_id = explode('"', $update->parent_id_drive)[1];
                    //     //                 array_push($parentID,$parent_id);
                    //     //             }

                    //     //             $update->parent_id_drive = $parentID;
                    //     //             $update->save();
                    //     //             $storeEntertain->receipt = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                    //     //         } 
                    //     //         $storeEntertain->save();
                    //     //         Log::info('stored');
                    //     //     }
                    //     // }
                    //     // if (isset($settlement['Others'])) {
                    //     //     $customKey2 = 0;
                    //     //     foreach ($settlement['Others'] as $keyItem => $data) {
                    //     //         ++$customKey2;
                    //     //         $storeOthers = new SettlementOther();
                    //     //         $storeOthers->id_settlement =  $store->id;
                    //     //         $storeOthers->pid =  $keyPid;
                    //     //         $storeOthers->description = isset($data['idDescription']) ? $data['idDescription'] : null;
                    //     //         $storeOthers->date = isset($data['idDate']) ? $data['idDate'] : null;
                    //     //         $storeOthers->name = isset($data['idNameEmployee']) ? $data['idNameEmployee'] : null;
                    //     //         $storeOthers->role = isset($data['idRole']) ? $data['idRole'] : null;
                    //     //         $storeOthers->nominal = isset($data['idNominal']) ? str_replace('.', '',$data['idNominal']) : null;
                    //     //         $storeOthers->date_add =  Carbon::now()->toDateTimeString();
                    //     //         $storeOthers->category =  'Others';
                    //     //         $storeOthers->sub_category =  $keyItem;
                    //     //         if ($request->hasFile('file_'.$mainKey.'_'.$keyPid.'_Others_idUploadReceipt_'.$customKey2)) {
                    //     //             $file                   = $request->file('file_'.$mainKey.'_'.$keyPid.'_Others_idUploadReceipt_'.$customKey2);
                    //     //             $fileName               = 'Others '.$data['idDescription'].'.'.$file->getClientOriginalExtension();
                    //     //             $filePath               = $file->getRealPath();
                    //     //             $extension              = $file->getClientOriginalExtension();

                    //     //             $update = Settlement::where('id',$store->id)->first();
                    //     //             if ($update->parent_id_drive == null) {
                    //     //                 $parentID = $this->googleDriveMakeFolderSettlement($getMonReq);
                    //     //             } else {
                    //     //                 $parentID = [];
                    //     //                 $parent_id = explode('"', $update->parent_id_drive)[1];
                    //     //                 array_push($parentID,$parent_id);
                    //     //             }

                    //     //             $update->parent_id_drive = $parentID;
                    //     //             $update->save();
                    //     //             $storeOthers->receipt = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';

                    //     //         } 

                    //     //         if ($request->hasFile('file_'.$mainKey.'_'.$keyPid.'_Others_idUploadImage_'.$customKey2)) {
                    //     //             $file                   = $request->file('file_'.$mainKey.'_'.$keyPid.'_Others_idUploadImage_'.$customKey2);
                    //     //             $fileName               = 'Others '.$data['idDescription'].'.'.$file->getClientOriginalExtension();
                    //     //             $filePath               = $file->getRealPath();
                    //     //             $extension              = $file->getClientOriginalExtension();

                    //     //             $update = Settlement::where('id',$store->id)->first();
                    //     //             if ($update->parent_id_drive == null) {
                    //     //                 $parentID = $this->googleDriveMakeFolderSettlement($getMonReq);
                    //     //             } else {
                    //     //                 $parentID = [];
                    //     //                 $parent_id = explode('"', $update->parent_id_drive)[1];
                    //     //                 array_push($parentID,$parent_id);
                    //     //             }

                    //     //             $update->parent_id_drive = $parentID;
                    //     //             $update->save();
                    //     //             $storeOthers->image = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                    //     //         }
                    //     //         $storeOthers->save();
                    //     //         Log::info('stored');
                    //     //     }
                    //     // }
                    // }
                }
            }

            $updateNominalSettlement = Settlement::where('id',$store->id)->first();
            $updateNominalSettlement->nominal = DB::table('tb_settlement_pid')->select('nominal')->where('id_settlement',$store->id)->sum('nominal');
            $updateNominalSettlement->save();

            $storeActivity = new SettlementActivity();
            $storeActivity->id_settlement = $store->id;
            $storeActivity->date_time = Carbon::now()->toDateTimeString();
            $storeActivity->status = 'NEW';
            $storeActivity->operator = Auth::User()->name;
            $storeActivity->activity = 'Add New Settlement';
            $storeActivity->save();

            $kirim_user = User::join('role_user', 'role_user.user_id', '=', 'users.nik')->join('roles', 'roles.id', '=', 'role_user.role_id')->select('email', 'users.name as name_receiver')->where('roles.name', 'PMO Officer')->where('status_karyawan', '!=', 'dummy')->first();

            $detail = Settlement::join('users','users.nik','tb_settlement.issuance')->join('tb_money_request','tb_money_request.id','tb_settlement.no_monreq')->select('users.name','tb_settlement.status','tb_settlement.nominal', 'tb_money_request.no_monreq', 'tb_settlement.id','tb_settlement.date','tb_settlement.issuance')->where('tb_settlement.id',$store->id)->first();

            Mail::to($kirim_user->email)->send(new MailPMOSettlement($detail,$kirim_user,'[SIMS-APP] New Settlement ' .$detail->no_monreq . ' ready to check and verify!', 'detail_approver', 'next_approver'));

            return response()->json([
                "action"=> "inserted",
                "tid" => $store->id
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function handleFileUpload($request, $mainKey, $keyPid, $category, $customKey, $data, $store)
    {
        $getMonReq = DB::table('tb_money_request')->where('id',$mainKey)->select('no_monreq')->first()->no_monreq;
        if ($category == 'Allowance' || $category == 'KPHL') {
            $fileKey = "file_{$mainKey}_{$keyPid}_{$category}_idUploadFile_{$customKey}";
        } else if ($category == 'StrukManual') {
            $fileKey = "file_{$mainKey}_{$keyPid}_{$category}_idRestoImage_{$customKey}";
        } else {
            $fileKey = "file_{$mainKey}_{$keyPid}_{$category}_idUploadReceipt_{$customKey}";
        }
        if ($request->hasFile($fileKey)) {
            $file = $request->file($fileKey);
            $fileName = ucfirst($category) . ' ' . ($data['idNameEmployee'] ?? '') . '.' . $file->getClientOriginalExtension();

            $update = Settlement::where('id',$store->id)->first();
            if ($update->parent_id_drive == null) {
                $parentID = $this->googleDriveMakeFolderSettlement($getMonReq);
            } else {
                $parentID = [];
                $parent_id = explode('"', $update->parent_id_drive)[1];
                array_push($parentID,$parent_id);
            }
            $update->update(['parent_id_drive' => $parentID]);

            $fileId = $this->googleDriveUploadCustomSettlement($fileName, $file->getRealPath(), $parentID);
            $image = "https://drive.google.com/file/d/{$fileId}/view?usp=drivesdk";
        }
        return $image;
    }

    public function handleFileUploadReceipt($request, $mainKey, $keyPid, $category, $customKey, $data, $store)
    {
        $getMonReq = DB::table('tb_money_request')->where('id',$mainKey)->select('no_monreq')->first()->no_monreq;
        if ($category == 'StrukManual' || $category == 'StrukDigital') {
            $fileKey = "file_{$mainKey}_{$keyPid}_{$category}_idReceiptImage_{$customKey}";
            // $fileGrab = "file_{$mainKey}_{$keyPid}_{$category}_idReceiptGrab_{$customKey}";
        } else {
            $fileKey = "file_{$mainKey}_{$keyPid}_{$category}_idUploadImage_{$customKey}";
        }

        if ($request->hasFile($fileKey)) {
            $file = $request->file($fileKey);
            $fileName = ucfirst($category) . ' ' . ($data['idNameEmployee'] ?? '') . '.' . $file->getClientOriginalExtension();

            $update = Settlement::where('id',$store->id)->first();
            if ($update->parent_id_drive == null) {
                $parentID = $this->googleDriveMakeFolderSettlement($getMonReq);
            } else {
                $parentID = [];
                $parent_id = explode('"', $update->parent_id_drive)[1];
                array_push($parentID,$parent_id);
            }
            $update->update(['parent_id_drive' => $parentID]);

            $fileId = $this->googleDriveUploadCustomSettlement($fileName, $file->getRealPath(), $parentID);
            $image = "https://drive.google.com/file/d/{$fileId}/view?usp=drivesdk";
        }

        // if ($request->hasFile($fileGrab)) {
        //     $file = $request->file($fileGrab);
        //     $fileName = ucfirst($category) . ' ' . ($data['idNameEmployee'] ?? '') . '.' . $file->getClientOriginalExtension();

        //     $update = Settlement::where('id',$store->id)->first();
        //     if ($update->parent_id_drive == null) {
        //         $parentID = $this->googleDriveMakeFolderSettlement($getMonReq);
        //     } else {
        //         $parentID = [];
        //         $parent_id = explode('"', $update->parent_id_drive)[1];
        //         array_push($parentID,$parent_id);
        //     }
        //     $update->update(['parent_id_drive' => $parentID]);

        //     $fileId = $this->googleDriveUploadCustomSettlement($fileName, $file->getRealPath(), $parentID);
        //     $image = "https://drive.google.com/file/d/{$fileId}/view?usp=drivesdk";
        // } else {
        //     $image = "";
        // }
        return $image;
    }

    public function handleFileUploadReceiptGrab($request, $mainKey, $keyPid, $category, $customKey, $data, $store)
    {
        $getMonReq = DB::table('tb_money_request')->where('id',$mainKey)->select('no_monreq')->first()->no_monreq;
        if ( $category == 'StrukDigital') {
            $fileGrab = "file_{$mainKey}_{$keyPid}_{$category}_idReceiptGrab_{$customKey}";
        } else {
            $fileGrab = "file_{$mainKey}_{$keyPid}_{$category}_idUploadGrab_{$customKey}";
        }

        if ($request->hasFile($fileGrab)) {
            $file = $request->file($fileGrab);
            $fileName = ucfirst($category) . ' ' . ($data['idNameEmployee'] ?? '') . '.' . $file->getClientOriginalExtension();

            $update = Settlement::where('id',$store->id)->first();
            if ($update->parent_id_drive == null) {
                $parentID = $this->googleDriveMakeFolderSettlement($getMonReq);
            } else {
                $parentID = [];
                $parent_id = explode('"', $update->parent_id_drive)[1];
                array_push($parentID,$parent_id);
            }
            $update->update(['parent_id_drive' => $parentID]);

            $fileId = $this->googleDriveUploadCustomSettlement($fileName, $file->getRealPath(), $parentID);
            $image = "https://drive.google.com/file/d/{$fileId}/view?usp=drivesdk";
        } else{
            $image = "";
        }
        return $image;
    }

    public function verifySettlement(Request $request)
    {
        try{
            if ($request->isHasNotes == "true") {
                $update = Settlement::where('id',$request->id_settlement)->first();
                $update->status = 'UNAPPROVED';
                $update->isCircular = 'False';
                $update->save();

                $storeActivity                      = new SettlementActivity();
                $storeActivity->id_settlement       = $update->id;
                $storeActivity->date_time           = Carbon::now()->toDateTimeString();
                $storeActivity->status              = 'UNAPPROVED';
                $storeActivity->operator            = Auth::User()->name;
                $storeActivity->activity            = 'Reject Settlement';
                $storeActivity->save();

                $statementStatus = ' has been rejected by PMO Officer!';
            }else{
                $update = Settlement::where('id',$request->id_settlement)->first();
                $update->status = 'VERIFIED';
                $update->isCircular = 'True';
                $update->save();

                $storeActivity                      = new SettlementActivity();
                $storeActivity->id_settlement       = $update->id;
                $storeActivity->date_time           = Carbon::now()->toDateTimeString();
                $storeActivity->status              = 'VERIFIED';
                $storeActivity->operator            = Auth::User()->name;
                $storeActivity->activity            = 'Verify Settlement';
                $storeActivity->save();

                $statementStatus = ' has been verified by PMO Officer!';
            }

            $email_cc = User::join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('email','users.name as name_receiver')
                        ->where("roles.name","Project Management Office Manager")
                        ->first();

            $detail = Settlement::join('users','users.nik','tb_settlement.issuance')->join('tb_money_request','tb_money_request.id','tb_settlement.no_monreq')->select('users.name','tb_settlement.status','tb_settlement.nominal', 'tb_money_request.no_monreq', 'tb_settlement.id','tb_settlement.date','tb_settlement.issuance')->where('tb_settlement.id',$request->id_settlement)->first();

            $detail->pmo_manager = $email_cc->name_receiver;

            $kirim_user = User::join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('email','users.name as name_receiver')
                        ->where("nik",$detail->issuance)
                        ->first();

            if ($update->status == 'UNAPPROVED') {
                Mail::to($kirim_user->email)->send(new MailPMOSettlement($detail,$kirim_user,'[SIMS-APP] Settlement ' .$detail->no_monreq . $statementStatus, 'detail_approver', 'next_approver'));
            }else if($update->status == 'VERIFIED'){
                Mail::to($kirim_user->email)->cc($email_cc->email)->send(new MailPMOSettlement($detail,$kirim_user,'[SIMS-APP] Settlement ' .$detail->no_monreq . $statementStatus, 'detail_approver', 'next_approver'));
            }
            
            return response()->json([
                "action"=> "inserted",
                "tid" => $update->id
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function calculateAllowance(Request $request) {
        $start = Carbon::parse($request->idStartDate);
        $end = Carbon::parse($request->idEndDate);
        $nominalPerDay = '150000';
        $totalAllowance = 0;
        $dayCount = 0;

        $holiday = $this->getWorkDays($start, $end)['holiday']->pluck('start_date')->toArray();

        while ($start->lessThanOrEqualTo($end)) {
            if ($start->isWeekend() || in_array($start->format('Y-m-d'), $holiday)) {
                $start->addDay();
                continue;
            }

            $dayCount++;

            if ($dayCount <= 4) {
                $totalAllowance += $nominalPerDay * 1;
            } elseif ($dayCount >= 5 && $dayCount <= 19) {
                $totalAllowance += $nominalPerDay * 0.75;
            } elseif ($dayCount >= 20 && $dayCount <= 30) {
                $totalAllowance += $nominalPerDay * 0.50;
            }

            $start->addDay();
        }

        return number_format($totalAllowance, 0, ',', '.');
    }

    public function getWorkDays($startDate,$endDate){
        $formattedStartDate = Carbon::parse($startDate)->toISOString();
        $formattedEndDate   = Carbon::parse($endDate)->toISOString();

        $client = new Client();
        $api_response = $client->get('https://www.googleapis.com/calendar/v3/calendars/en.indonesian%23holiday%40group.v.calendar.google.com/events?timeMin='. $formattedStartDate .'&timeMax='. $formattedEndDate .'&key='.env('GCALENDAR_API_KEY'));
        $json = (string)$api_response->getBody();
        $holiday_indonesia = json_decode($json, true);

        $holiday_indonesia_final_detail = collect();
        $holiday_indonesia_final_details = collect();
        $holiday_indonesia_final_date = collect();
        $holiday_indonesia_final_dates = collect();
        
        foreach ($holiday_indonesia["items"] as $value) {
            if(( (( $value["start"]["date"] >= $startDate ) && ( $value["start"]["date"] <= $endDate )) && (($value["description"] == 'Public holiday')) && (!strstr($value['summary'], "Joint")  && ($value["summary"] != 'Boxing Day')) )){
                $holiday_indonesia_final_detail->push(["start_date" => $value["start"]["date"],"activity" => $value["summary"],"remarks" => "Cuti Bersama"]);
                $holiday_indonesia_final_date->push($value["start"]["date"]);
            }
            if(( (( $value["start"]["date"] >= $startDate ) && ( $value["start"]["date"] <= $endDate )) && (($value['summary'] == 'Idul Fitri Joint Holiday') || ($value['summary'] == 'Boxing Day')) )){
                $holiday_indonesia_final_details->push(["start_date" => $value["start"]["date"],"activity" => $value["summary"],"remarks" => "Cuti Bersama"]);
                $holiday_indonesia_final_dates->push($value["start"]["date"]);
            }
        }

        $holiday_indonesia_final_detail = $holiday_indonesia_final_detail->merge($holiday_indonesia_final_details);

        $period = new DatePeriod(
             new DateTime($startDate),
             new DateInterval('P1D'),
             new DateTime($endDate)
        );

        $workDays = collect();
        foreach($period as $date){
            if(!($date->format("N") == 6 || $date->format("N") == 7)){
                $workDays->push($date->format("Y-m-d"));
            }
        }

        // return $period;

        $workDaysMinHoliday = $workDays->diff($holiday_indonesia_final_date->unique());
        $workDaysMinHolidayKeyed = $workDaysMinHoliday->map(function ($item, $key) {
            return $item;
        });

        return collect(["holiday" => $holiday_indonesia_final_detail, "workdays" => $workDaysMinHolidayKeyed]);
        
    }

    public function getExportSettlement(request $request)
    {
        $dataPost['id_settlement'] = $request->id_settlement;
        $dataPost['isSettlementExport']    = 'settlement';

        $request = Request::create('/getDetailSettlement', 'POST', $dataPost);

        $data = $this->getDetailSettlement($request);

        // return $data;

        $pdf = PDF::loadView('PMO.settlement.Pdf.settlement_pdf',compact('data'))->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function getExportKPHL(request $request)
    {
        $dataPost['id_settlement']   = $request->id_settlement;
        $dataPost['isAllowanceExport']       = 'allowance';
        $dataPost['pid']             = $request->pid;
        $dataPost['id_sub_category'] = $request->id_sub_category;

        $request = Request::create('/getDetailSettlement', 'POST', $dataPost);

        $data = $this->getDetailSettlement($request);

        // return $data;

        $pdf = PDF::loadView('PMO.settlement.Pdf.KPHL_pdf',compact('data'));

        return $pdf->stream();
    }

    public function getExportEntertain(request $request)
    {
        $dataPost['id_settlement'] = $request->id_settlement;
        $dataPost['isEntertainExport']       = 'entertain';
        $dataPost['pid']             = $request->pid;
        $dataPost['id_sub_category'] = $request->id_sub_category;

        $request = Request::create('/getDetailSettlement', 'POST', $dataPost);

        $data = $this->getDetailSettlement($request);

        // return $data;

        $pdf = PDF::loadView('PMO.settlement.Pdf.entertain_pdf',compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function updateSettlement(Request $request)
    {
        $data = json_decode($request['arrDataSettlement'],true);

        $parentID = Settlement::select('parent_id_drive')->where('id',$request->id_settlement)->first()->parent_id_drive;

        foreach ($data as $key => $value) {
            foreach ($value['item'] as $key => $dataSettlement) {
                foreach ($dataSettlement as $key => $dataInside) {
                    if ($request->category == 'Transport') {
                        // return $dataInside[0]['idDate'];
                        $update = SettlementTransport::where('id',$request->id_sub_category)->first();
                        $update->date = isset($dataInside[0]['idDate']) ? $dataInside[0]['idDate'] : null;
                        $update->time = isset($dataInside[0]['idTime']) ? $dataInside[0]['idTime'] : null;
                        $update->name = isset($dataInside[0]['idNameEmployee']) ? $dataInside[0]['idNameEmployee'] : null;
                        $update->role = isset($dataInside[0]['idRole']) ? $dataInside[0]['idRole'] : null;
                        $update->nominal = isset($dataInside[0]['idNominal']) ? str_replace('.', '',$dataInside[0]['idNominal']) : null;
                        $update->toll_gate = isset($dataInside[0]['idTollGate']) ? $dataInside[0]['idTollGate'] : null;
                        $update->from_transport = isset($dataInside[0]['idFromTransport']) ? $dataInside[0]['idFromTransport'] : null;
                        $update->to_transport = isset($dataInside[0]['idToTransport']) ? $dataInside[0]['idToTransport'] : null;
                        $update->driver_name = isset($dataInside[0]['idDriverName']) ? $dataInside[0]['idDriverName'] : null;
                        $update->location = isset($dataInside[0]['idLocation']) ? $dataInside[0]['idLocation'] : null;
                        if ($request->hasFile('file_'.$key.'_idUploadReceipt')) {
                            $file                   = $request->file('file_'.$key.'_idUploadReceipt');
                            $fileName               = $key.'.'.$file->getClientOriginalExtension();
                            $filePath               = $file->getRealPath();
                            $extension              = $file->getClientOriginalExtension();

                            $update->image = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                        }
                        $update->save();
                    } elseif ($request->category == 'Entertainment' || $request->category == 'CommunicationPlan' || $request->category == 'Communication Plan') {
                        $update = SettlementEntertain::where('id',$request->id_sub_category)->first();
                        $update->resto_name = isset($dataInside[0]['idRestoName']) ? $dataInside[0]['idRestoName'] : null;
                        $update->date = isset($dataInside[0]['idDate']) ? $dataInside[0]['idDate'] : null;
                        $update->time = isset($dataInside[0]['idTime']) ? $dataInside[0]['idTime'] : null;
                        $update->name = isset($dataInside[0]['idNameEmployee']) ? $dataInside[0]['idNameEmployee'] : null;
                        $update->role = isset($dataInside[0]['idRole']) ? $dataInside[0]['idRole'] : null;
                        $update->team_internal = isset($dataInside[0]['idTeamInternal']) ? $dataInside[0]['idTeamInternal'] : null;
                        $update->team_eksternal = isset($dataInside[0]['idTeamEksternal']) ? $dataInside[0]['idTeamEksternal'] : null;
                        $update->location = isset($dataInside[0]['idLocation']) ? $dataInside[0]['idLocation'] : null;
                        $update->nominal = isset($dataInside[0]['idNominal']) ? str_replace('.', '',$dataInside[0]['idNominal']) : null;
                        if ($request->hasFile('file_'.$key.'_idUploadReceipt')) {
                            $file                   = $request->file('file_'.$key.'_idUploadReceipt');
                            $fileName               = $key.'_'.$dataInside[0]['idRestoName'].'.'.$file->getClientOriginalExtension();
                            $filePath               = $file->getRealPath();
                            $extension              = $file->getClientOriginalExtension();

                            $update->receipt = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                        }
                        if ($request->hasFile('file_'.$key.'_idUploadImage')) {
                            $file                   = $request->file('file_'.$key.'_idUploadImage');
                            $fileName               = $key.'_'.$dataInside[0]['idRestoName'].'.'.$file->getClientOriginalExtension();
                            $filePath               = $file->getRealPath();
                            $extension              = $file->getClientOriginalExtension();

                            $update->image = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                        }
                        $update->save();

                    } elseif ($request->category == 'Allowance') {
                        $update = SettlementAllowance::where('id',$request->id_sub_category)->first();
                        $update->start_date = isset($dataInside[0]['idStartDate']) ? $dataInside[0]['idStartDate'] : null;
                        $update->end_date = isset($dataInside[0]['idEndDate']) ? $dataInside[0]['idEndDate'] : null;
                        $update->name = isset($dataInside[0]['idNameEmployee']) ? $dataInside[0]['idNameEmployee'] : null;
                        $update->role = isset($dataInside[0]['idRole']) ? $dataInside[0]['idRole'] : null;
                        $update->location = isset($dataInside[0]['idLocation']) ? $dataInside[0]['idLocation'] : null;
                        $update->nominal = isset($dataInside[0]['idNominal']) ? str_replace('.', '',$dataInside[0]['idNominal']) : null;
                        if ($request->hasFile('file_'.$key.'_idUploadFile')) {
                            $file                   = $request->file('file_'.$key.'_idUploadFile');
                            $fileName               = $key.'_'.$dataInside[0]['idLocation'].'.'.$file->getClientOriginalExtension();
                            $filePath               = $file->getRealPath();
                            $extension              = $file->getClientOriginalExtension();

                            $update->file = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                        }
                        $update->save();

                    } else {
                        $update = SettlementOther::where('id',$request->id_sub_category)->first();
                        $update->description = isset($dataInside[0]['idDescription']) ? $dataInside[0]['idDescription'] : null;
                        $update->date = isset($dataInside[0]['idDate']) ? $dataInside[0]['idDate'] : null;
                        $update->name = isset($dataInside[0]['idNameEmployee']) ? $dataInside[0]['idNameEmployee'] : null;
                        $update->role = isset($dataInside[0]['idRole']) ? $dataInside[0]['idRole'] : null;
                        $update->nominal = isset($dataInside[0]['idNominal']) ? str_replace('.', '',$dataInside[0]['idNominal']) : null;
                        if ($request->hasFile('file_'.$key.'_idUploadReceipt')) {
                            $file                   = $request->file('file_'.$key.'_idUploadReceipt');
                            $fileName               = $key.'_'.$dataInside[0]['idDescription'].'.'.$file->getClientOriginalExtension();
                            $filePath               = $file->getRealPath();
                            $extension              = $file->getClientOriginalExtension();

                            $update->receipt = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                        }
                        if ($request->hasFile('file_'.$key.'_idUploadImage')) {
                            $file                   = $request->file('file_'.$key.'_idUploadImage');
                            $fileName               = $key.'_'.$dataInside[0]['idDescription'].'.'.$file->getClientOriginalExtension();
                            $filePath               = $file->getRealPath();
                            $extension              = $file->getClientOriginalExtension();

                            $update->image = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                        }
                        $update->save();
                    }
                }
            }

            $nominalTransport = 0;
            $nominalAllowance = 0;
            $nominalEntertain = 0;
            $nominalOther = 0;

            if (DB::table('tb_settlement_transport')->select('nominal')->where('id_settlement',$request->id_settlement)->exists()) {
                if (DB::table('tb_settlement_transport')->select('id_pid')->where('id_pid',$request->id_pid)->exists()) {
                    // $idPid = DB::table('tb_settlement_transport')->select('id_pid')->where('id_pid',$request->id_pid)->first()->id_pid;
                    $nominalTransport = DB::table('tb_settlement_transport')->select('nominal')->where('id_pid',$request->id_pid)->sum('nominal');
                }
            } 
            if (DB::table('tb_settlement_allowance')->select('nominal')->where('id_settlement',$request->id_settlement)->exists()) {
                if (DB::table('tb_settlement_allowance')->select('id_pid')->where('id_pid',$request->id_pid)->exists()) {
                    // $idPid = DB::table('tb_settlement_allowance')->select('id_pid')->where('id_pid',$request->id_pid)->first()->id_pid;
                    $nominalAllowance = DB::table('tb_settlement_allowance')->select('nominal')->where('id_pid',$request->id_pid)->sum('nominal');
                }
            }
            if (DB::table('tb_settlement_entertain')->select('nominal')->where('id_settlement',$request->id_settlement)->exists()) {
                if (DB::table('tb_settlement_entertain')->select('id_pid')->where('id_pid',$request->id_pid)->exists()) {
                    // $idPid = DB::table('tb_settlement_entertain')->select('id_pid')->where('id_pid',$request->id_pid)->first()->id_pid;
                    $nominalEntertain = DB::table('tb_settlement_entertain')->select('nominal')->where('id_pid',$request->id_pid)->sum('nominal');
                }
            }
            if (DB::table('tb_settlement_others')->select('nominal')->where('id_settlement',$request->id_settlement)->exists()) {
                if (DB::table('tb_settlement_others')->select('id_pid')->where('id_pid',$request->id_pid)->exists()) {
                    // $idPid = DB::table('tb_settlement_others')->select('id_pid')->where('id_pid',$request->id_pid)->first()->id_pid;
                    $nominalOther = DB::table('tb_settlement_others')->select('nominal')->where('id_pid',$request->id_pid)->sum('nominal');
                }
            }

            $nominalPid = $nominalTransport + $nominalAllowance + $nominalEntertain + $nominalOther;

            $updateNominalPID = SettlementPID::where('id',$request->id_pid)->first();
            $updateNominalPID->nominal = $nominalPid;
            $updateNominalPID->save();

            $updateNominalSettlement = Settlement::where('id',$request->id_settlement)->first();
            $updateNominalSettlement->nominal = DB::table('tb_settlement_pid')->select('nominal')->where('id_settlement',$request->id_settlement)->sum('nominal');
            $updateNominalSettlement->status = 'NEW';
            $updateNominalSettlement->save();

            $storeActivity = new SettlementActivity();
            $storeActivity->id_settlement = $request->id_settlement;
            $storeActivity->date_time = Carbon::now()->toDateTimeString();
            $storeActivity->status = 'NEW';
            $storeActivity->operator = Auth::User()->name;
            $storeActivity->activity = 'Updated Settlement';
            $storeActivity->save();

             $kirim_user = User::join('role_user', 'role_user.user_id', '=', 'users.nik')->join('roles', 'roles.id', '=', 'role_user.role_id')->select('email', 'users.name as name_receiver')->where('roles.name', 'PMO Officer')->where('status_karyawan', '!=', 'dummy')->first();

            $email_cc = User::join('role_user', 'role_user.user_id', '=', 'users.nik')->join('roles', 'roles.id', '=', 'role_user.role_id')->select('email', 'users.name as name_receiver')->where('roles.name', 'Project Management Office Manager')->where('status_karyawan', '!=', 'dummy')->first();

            $detail = Settlement::join('users','users.nik','tb_settlement.issuance')->join('tb_money_request','tb_money_request.id','tb_settlement.no_monreq')->select('users.name','tb_settlement.status','tb_settlement.nominal', 'tb_money_request.no_monreq', 'tb_settlement.id','tb_settlement.date','tb_settlement.issuance')->where('tb_settlement.id',$request->id_settlement)->first();

            Mail::to($kirim_user->email)->cc($email_cc->email)->send(new MailPMOSettlement($detail,$kirim_user,'[SIMS-APP] Update Settlement ' .$detail->no_monreq . ' ready to check and verify!', 'detail_approver', 'next_approver'));
        }

        return response()->json([
            "action"=> "inserted",
            "tid" => $request->id_settlement
        ]);
    }

    public function getDataClaim(Request $request)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $cek_role = User::join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('roles.name as name_role','group','mini_group')->where('role_user.user_id',$nik)->first();

        $data = Claim::join('users','users.nik','tb_claim.issuance')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('no_claim','nominal','status','users.name','date','tb_claim.id','isCircular');

        if($cek_role->name_role == 'VP Sales'){
            $data = $data
                ->where('id_territory', $ter);
        } elseif ($cek_role->group == 'Solutions & Partnership Management') {
            if ($cek_role->name_role == 'VP Solutions & Partnership Management') {
                $data = $data
                ->where('group','Solutions & Partnership Management');
            } elseif($cek_role->name_role == 'Application Development Specialist Manager'){
                $data = $data
                ->where('mini_group','Application Development Specialist');
            } elseif($cek_role->name_role == 'Customer Relation Manager'){
                $data = $data
                ->where('mini_group','Customer Relationship Management');
            } elseif($cek_role->name_role == 'Product Development Specialist Manager'){
                $data = $data
                ->where('mini_group','Product Development Specialist');
            }else {
                $data = $data->where('users.nik',$nik);
            }
            
        } elseif ($cek_role->group == 'Program & Project Management') {
            if ($cek_role->name_role == 'VP Program & Project Management') {
                $data = $data
                ->where('group','Program & Project Management')->orWhere('group','Human Capital Management');
            } elseif($cek_role->name_role == 'Project Management Office Manager'){
                $data = $data
                ->where('mini_group','Project Management Office');
            }else {
                $data = $data->where('users.nik',$nik);
            }

        } elseif ($cek_role->group == 'Synergy System Management') {
            if ($cek_role->name_role == 'VP Synergy System Management') {
                $data = $data
                ->where('group','Synergy System Management');
            } elseif($cek_role->name_role == 'Synergy System & Services Manager'){
                $data = $data
                ->where('mini_group','Synergy System & Services');
            } elseif($cek_role->name_role == 'Synergy System Architecture Manager'){
                $data = $data
                ->where('mini_group','Synergy System Architecture');
            } elseif($cek_role->name_role == 'Synergy System Delivery Manager'){
                $data = $data
                ->where('mini_group','Synergy System Delivery');
            }else {
                $data = $data->where('users.nik',$nik);
            }

        } elseif ($cek_role->group == 'Internal Chain Management') {
            if ($cek_role->name_role == 'VP Internal Chain Management') {
                $data = $data
                ->where('group','Internal Chain Management');
            } elseif($cek_role->name_role == 'Supply Chain & IT Support Manager'){
                $data = $data
                ->where('mini_group','Supply Chain & IT Support');
            } elseif($cek_role->name_role == 'Internal Operation Support Manager'){
                $data = $data
                ->where('mini_group','Internal Operation Support');
            } elseif($cek_role->name_role == 'Supply Chain Manager'){
                $data = $data
                ->where('mini_group','Supply Chain Management');
            }else {
                $data = $data->where('users.nik',$nik);
            }

        } elseif ($cek_role->group == 'Human Capital Management') {
            if ($cek_role->name_role == 'Human Capital Manager') {
                $data = $data
                ->where('mini_group','Human Capital');
            } elseif($cek_role->name_role == 'People Operations & Services Manager'){
                $data = $data->where('mini_group','People Operations & Services');
            }else {
                $data = $data->where('users.nik',$nik);
            }
        } elseif($cek_role->name_role == 'VP Financial & Accounting'){
            $data = $data
                ->where('name_role','Finance');
        } elseif($nik == '1240288090'){
            $data = $data
                ->where('tb_claim.status','APPROVED');
        } else if($cek_role->name_role == 'Chief Operating Officer' || $cek_role->name_role == 'Chief Executive Officer'){
             $data = $data;
        }else{
            $data = $data
                ->where('users.nik',$nik);
        }
        
        return array("data"=>$data->get()->sortByDesc('date')->values()->all());
    }

    public function getPIDforClaim(Request $request)
    {   
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $get_role_pid = User::join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('roles.name as name','group','mini_group')->where('roles.name','like','VP%')->orWhere('roles.name','like','%Manager%')->where('roles.name','<>','Project Manager')->get();

        $cek_role = User::join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('roles.name as name','group','mini_group')->where('role_user.user_id',Auth::User()->nik)->first();

        $exists = $get_role_pid->contains(function ($item) use ($cek_role) {
            return $item->name === $cek_role->name;
        });

        $getPid = SalesProject::join('sales_lead_register', 'sales_lead_register.lead_id', '=', 'tb_id_project.lead_id')->join('users', 'users.nik', '=', 'sales_lead_register.nik')->select('id_project as id',DB::raw("CONCAT(`id_project`,' - ',`name_project`) AS text"))->where('id_company', '1')->where('id_project','like','%'.request('q').'%')->orderBy('tb_id_project.created_at','desc')->get();

        if ($exists) {
            $data = $getPid->toArray();
        }else{
            if ($cek_role->group == 'sales') {
                $getLeadId = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->select('lead_id as id',DB::raw("CONCAT(`lead_id`,' - ',`opp_name`) AS text"))
                    ->where('result','<>','WIN')
                    ->where('result','<>','LOSE')
                    ->where('year',date('Y'))
                    ->where('sales_lead_register.nik',Auth::User()->nik)
                    ->where(DB::raw("CONCAT(`lead_id`,' - ',`opp_name`)"),'like','%'.request('q').'%')
                    ->get();

                $data = $getLeadId->merge($getPid);
            }else if($cek_role->name_role == 'System Designer Architecture' || $cek_role->name_role == 'Presales Support Architecture' || $cek_role->name_role == 'Synergy System Architecture Manager'){
                $getLeadId = DB::table('sales_lead_register')
                    ->join('sales_solution_design','sales_lead_register.lead_id','=','sales_solution_design.lead_id')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->select('lead_id as id',DB::raw("CONCAT(`lead_id`,' - ',`opp_name`) AS text"))
                    ->where('result','<>','WIN')
                    ->where('result','<>','LOSE')
                    ->where('year',date('Y'))
                    ->where('sales_solution_design.nik',Auth::User()->nik)
                    ->where(DB::raw("CONCAT(`lead_id`,' - ',`opp_name`)"),'like','%'.request('q').'%')
                    ->get();

                $data = $getLeadId->merge($getPid);
            }else if($cek_role->name_role == 'Technology Alliance Solutions'){
                $getLeadId = DB::table('sales_lead_register')
                    ->join('sales_solution_design','sales_lead_register.lead_id','=','sales_solution_design.lead_id')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->select('lead_id as id',DB::raw("CONCAT(`lead_id`,' - ',`opp_name`) AS text"))
                    ->where('result','<>','WIN')
                    ->where('result','<>','LOSE')
                    ->where('year',date('Y'))
                    ->where('sales_solution_design.nik_ta',Auth::User()->nik)
                    ->where(DB::raw("CONCAT(`lead_id`,' - ',`opp_name`)"),'like','%'.request('q').'%')
                    ->get();

                $data = $getLeadId->merge($getPid);
            }else{
                $getLeadId = DB::table('sales_lead_register')
                    ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                    ->select('lead_id as id',DB::raw("CONCAT(`lead_id`,' - ',`opp_name`) AS text"))
                    ->where('result','<>','WIN')
                    ->where('result','<>','LOSE')
                    ->where('year',date('Y'))
                    ->where('id_company', '1')
                    ->where(DB::raw("CONCAT(`lead_id`,' - ',`opp_name`)"),'like','%'.request('q').'%')
                    ->get();

                $data = $getLeadId->merge($getPid);
            }

            $data = $data->toArray();
            // $getAllPid = array(["id"=>"Non-PID","text"=>"Non-PID"]);
        }

        array_unshift($data, ["id"=>"INTERNAL","text"=>"INTERNAL"]);
        // if ($cek_role->name_role == 'Project Manager' || $cek_role->name_role == 'Project Coordinator') {
        //     $getAllPid = $getAllPid->whereIn('id_project',$getPidPm)->get();
        // } else {
            // $getAllPid = $getAllPid->get();
        // }

        return response()->json($data);
    }

    public function getCategoryClaim(Request $request)
    {
        if ($request->type == 'pid') {
            if ($request->pid == 'INTERNAL') {
                $sbe = array(
                    ["id"=>"Transport","text"=>"Transport"],
                    ["id"=>"Allowance","text"=>"Allowance"],
                    ["id"=>"Entertainment","text"=>"Entertainment"],
                    ["id"=>"Others","text"=>"Others"]
                );
            }else{
                $lead = DB::table('tb_id_project')->select('lead_id')->where('id_project',$request->pid)->first();

                $sbe = DB::table('tb_sbe')->join('tb_sbe_config','tb_sbe_config.id_sbe','tb_sbe.id')
                    ->join('tb_sbe_detail_config','tb_sbe_config.id','tb_sbe_detail_config.id_config_sbe')
                    ->join('tb_sbe_detail_item','tb_sbe_detail_item.id','tb_sbe_detail_config.detail_item')
                    ->select('tb_sbe_detail_item.detail_item as id','tb_sbe_detail_item.detail_item as text')
                    ->where('tb_sbe_config.status','Choosed')
                    ->where('tb_sbe.lead_id',$lead->lead_id)
                    ->where('tb_sbe_detail_item.detail_item','like','%'.request('q').'%')
                    ->distinct()->get();
            }
            // $sbe = array(["id"=>"Others","text"=>"Others"]);
        }else{
            $sbe = array(
                    ["id"=>"Transport","text"=>"Transport"],
                    ["id"=>"Allowance","text"=>"Allowance"],
                    ["id"=>"Entertainment","text"=>"Entertainment"],
                    ["id"=>"Others","text"=>"Others"]
                );
        }
        

        return response()->json($sbe);
    }

    public function getSubCategoryClaim(request $request)
    {
        if($request->category == 'Communication Plan'){
            $request->category = 'Entertainment';
        } elseif(str_contains($request->category, 'Allowance')){
            $request->category = 'Allowance';
        }

        $sub_category= [];

        if ($request->category == 'Transport' || $request->category == 'Entertainment' || $request->category == 'Allowance') {
            $dataCategory = DB::table('tb_settlement_category')->select('sub_category as id','sub_category as text')->where('category',$request->category)->distinct()->get();

            if ($request->pid == 'INTERNAL') {
                $detailCategory = DB::table('tb_settlement_category')->select('sub_category','title','type','id_input','element')->where('title','!=','Name')->where('title','<>','Role')->where('sub_category',$request->sub_category)->get()->groupby('sub_category');
            }else{
                $detailCategory = DB::table('tb_settlement_category')->select('sub_category','title','type','id_input','element')->where('title','<>','Name')->where('title','<>','Role')->where('sub_category',$request->sub_category)->get()->groupby('sub_category');
            }
        } else if($request->category == 'Others'){
            // $dataCategory = MoneyRequest::join('tb_money_request_pid','tb_money_request_pid.id_money_request','tb_money_request.id')->join('tb_money_request_detail','tb_money_request_detail.id_money_req_pid','tb_money_request_pid.id')->select('category')->where('pid',$request->pid)->where('id_money_request',$request->id_money_request)->distinct()->get()->pluck('category');
            if ($request->pid == 'INTERNAL') {
                $dataCategory = array(['id'=>'Others','text'=>'Others']);

                $detailCategory = DB::table('tb_settlement_category')->select('sub_category','title','type','id_input','element')->where('title','<>','Name')->where('title','<>','Role')->where('sub_category','Others')->get()->groupby('sub_category');
            }else{
                $lead = DB::table('tb_id_project')->select('lead_id')->where('id_project',$request->pid)->first();

                $dataCategory = DB::table('tb_sbe')
                ->join('tb_sbe_config','tb_sbe_config.id_sbe','tb_sbe.id')
                ->join('tb_sbe_detail_config','tb_sbe_config.id','tb_sbe_detail_config.id_config_sbe')
                ->where('tb_sbe_config.status','Choosed')
                ->join('tb_sbe_detail_item','tb_sbe_detail_item.id','tb_sbe_detail_config.detail_item')
                ->select('tb_sbe_detail_item.detail_item as id','tb_sbe_detail_item.detail_item as text')
                ->where('lead_id',$lead->lead_id)
                ->where('tb_sbe_detail_item.detail_item','like','%'.request('q').'%')
                ->where('tb_sbe_detail_item.detail_item','not like', 'Travel%')
                ->where('tb_sbe_detail_item.detail_item','not like','Pengiriman%')
                ->where('tb_sbe_detail_item.detail_item','not like','Mandays%')
                ->where('tb_sbe_detail_item.detail_item','not like','Accom%')
                ->where('tb_sbe_detail_item.detail_item','not like','Call%')->whereNotIn('tb_sbe_detail_item.detail_item',['Transport','Entertainment','Communication Plan','Allowance'])->distinct()->get();

                $detailCategory = DB::table('tb_settlement_category')->select('sub_category','title','type','id_input','element')->where('title','<>','Name')->where('title','<>','Role')->where('sub_category','Others')->get()->groupby('sub_category');
            }    
        }else {
            $dataCategory = DB::table('tb_settlement_category')->select('sub_category as id','sub_category as text')->where('category','Others')->distinct()->get();

            $detailCategory = DB::table('tb_settlement_category')->select('sub_category','title','type','id_input','element')->where('title','<>','Name')->where('title','<>','Role')->where('sub_category','Others')->get()->groupby('sub_category');
        }
        
        return response()->json(collect(['category'=>$dataCategory,'sub_category'=>$sub_category,'detailCategory'=>$detailCategory]));
    }

    public function getActivityClaim(Request $request)
    {
        $getActivity = ClaimActivity::select('activity', 'operator', 'status', 'date_time')
                ->selectRaw("SUBSTR(`tb_claim_activity`.`date_time`,1,10) AS `date_format`")->where('id_claim', $request->id_claim)->orderBy('date_time', 'desc')->get();

        // return [$getActivity->groupBy('date_format')];
        return response()->json($getActivity);
    }

    public function getDetailClaimById(Request $request)
    {
        $getId = ClaimPID::select('id_claim','nominal')
            ->where('tb_claim_pid.pid',$request->pid)
            ->first()->id_claim;

        $data = Claim::join('tb_claim_pid','tb_claim_pid.id_claim','tb_claim.id')->select('tb_claim_pid.nominal','tb_claim.id','tb_claim.status','pid')->where('tb_claim.id',$getId)->first();

        $pid = ClaimPID::select('pid','nominal')
            ->where('tb_claim_pid.pid',$request->pid)
            ->where('tb_claim_pid.id_claim',$request->id_claim)
            ->get();

        $latestIdNotes = DB::table('tb_claim_notes')
        ->select('id_sub_category','sub_category', DB::raw('MAX(id) as latest_id'))
        ->where('status','NEW')
        ->groupBy('id_sub_category','sub_category');

        $dataTransport = DB::table('tb_claim_notes')
            ->joinSub($latestIdNotes, 'latest_data', function($join) {
                $join->on('tb_claim_notes.id', '=', 'latest_data.latest_id');
            })
            ->rightJoin('tb_claim_transport',function($join){
                 $join->on('tb_claim_notes.id_sub_category', '=', 'tb_claim_transport.id')
                ->on('tb_claim_notes.sub_category', '=', 'tb_claim_transport.sub_category');
            })->leftJoin('tb_claim','tb_claim.id','tb_claim_transport.id_claim')
            ->select('tb_claim_transport.id','tb_claim_transport.nominal','image as receipt','pid','tb_claim_transport.date','tb_claim_transport.sub_category',DB::raw("CASE WHEN tb_claim_notes.notes IS NULL THEN '-' ELSE tb_claim_notes.notes END as notes"),'tb_claim_notes.status','toll_gate','time','name as name_employee','role','location','from_transport','to_transport','driver_name','tb_claim_transport.category')
            ->where('tb_claim_transport.pid',$request->pid)->where('tb_claim_transport.id_claim',$request->id_claim)->where('tb_claim_transport.id',$request->id_sub_category)->where('tb_claim_transport.category',$request->category)->get()->groupby('pid');

        $dataAllowance = DB::table('tb_claim_notes')
            ->joinSub($latestIdNotes, 'latest_data', function($join) {
                $join->on('tb_claim_notes.id', '=', 'latest_data.latest_id');
            })
            ->rightJoin('tb_claim_allowance',function($join){
                 $join->on('tb_claim_notes.id_sub_category', '=', 'tb_claim_allowance.id')
                ->on('tb_claim_notes.sub_category', '=', 'tb_claim_allowance.sub_category');
            })->leftJoin('tb_claim','tb_claim.id','tb_claim_allowance.id_claim')
            ->select('tb_claim_allowance.id','tb_claim_allowance.nominal','file','pid','tb_claim_allowance.sub_category',DB::raw("CASE WHEN tb_claim_notes.notes IS NULL THEN '-' ELSE tb_claim_notes.notes END as notes"),'tb_claim_notes.status','tb_claim_allowance.start_date','tb_claim_allowance.end_date','tb_claim_allowance.location','name as name_employee','role','tb_claim_allowance.category')
            ->where('tb_claim_allowance.pid',$request->pid)->where('tb_claim_allowance.id_claim',$request->id_claim)->where('tb_claim_allowance.id',$request->id_sub_category)
            ->where('tb_claim_allowance.category',$request->category)->get()->groupby('pid');

        $dataEntertain = DB::table('tb_claim_notes')
            ->joinSub($latestIdNotes, 'latest_data', function($join) {
                $join->on('tb_claim_notes.id', '=', 'latest_data.latest_id');
            })
            ->rightJoin('tb_claim_entertain',function($join){
                 $join->on('tb_claim_notes.id_sub_category', '=', 'tb_claim_entertain.id')
                ->on('tb_claim_notes.sub_category', '=', 'tb_claim_entertain.sub_category');
            })->leftJoin('tb_claim','tb_claim.id','tb_claim_entertain.id_claim')
            ->select('tb_claim_entertain.id','tb_claim_entertain.nominal as grand_total','tb_claim_entertain.nominal as nominal','image as resto_image','receipt','pid','tb_claim_entertain.date',DB::raw("CASE WHEN tb_claim_notes.notes IS NULL THEN '-' ELSE tb_claim_notes.notes END as notes"),
                DB::raw("CASE WHEN tb_claim_entertain.entertainment IS NULL THEN '-' ELSE tb_claim_entertain.entertainment END as entertainment"),
                // DB::raw("(CASE WHEN (tb_claim_entertain.sub_category like '%Digital') THEN 'Entertainment' WHEN (tb_claim_entertain.sub_category like '%Manual') THEN 'Entertainment' END) as sub_category"),
                'tb_claim_entertain.sub_category', 'tb_claim_entertain.category',
                'tb_claim_notes.status','resto_name','time','team_internal','team_eksternal','location','name as name_employee','role')
            ->where('tb_claim_entertain.pid',$request->pid)->where('tb_claim_entertain.id_claim',$request->id_claim)->where('tb_claim_entertain.id',$request->id_sub_category)
            ->where('tb_claim_entertain.category',$request->category)
            ->get()->groupby('pid');

        $dataOthers = DB::table('tb_claim_notes')
            ->joinSub($latestIdNotes, 'latest_data', function($join) {
                $join->on('tb_claim_notes.id', '=', 'latest_data.latest_id');
            })
            ->rightJoin('tb_claim_others',function($join){
                 $join->on('tb_claim_notes.id_sub_category', '=', 'tb_claim_others.id')
                ->on('tb_claim_notes.sub_category', '=', 'tb_claim_others.sub_category');
            })->leftJoin('tb_claim','tb_claim.id','tb_claim_others.id_claim')
            ->select('tb_claim_others.id','tb_claim_others.nominal','description','image','receipt','pid','tb_claim_others.category as sub_category',DB::raw("CASE WHEN tb_claim_notes.notes IS NULL THEN '-' ELSE tb_claim_notes.notes END as notes"),'tb_claim_notes.status','name','role','tb_claim_others.category','tb_claim_others.date_add as date')
            ->where('tb_claim_others.pid',$request->pid)->where('tb_claim_others.id_claim',$request->id_claim)->where('tb_claim_others.id',$request->id_sub_category)
            ->where('tb_claim_others.category',$request->category)->get()->groupby('pid');

        $pid->each(function ($item) use ($dataTransport, $dataAllowance, $dataEntertain, $dataOthers, $request) {
            $item->details = collect();

            if ($dataTransport->get($item->pid)) {
                $item->details = $item->details->merge($dataTransport->get($item->pid));
            }

            if ($dataAllowance->get($item->pid)) {
                $item->details = $item->details->merge($dataAllowance->get($item->pid));
            }

            if ($dataEntertain->get($item->pid)) {
                $item->details = $item->details->merge($dataEntertain->get($item->pid));
            }

            if ($dataOthers->get($item->pid)) {
                $item->details = $item->details->merge($dataOthers->get($item->pid));
            }

            $item->details = $item->details->groupBy(function ($detail) {
                return $detail->sub_category;
            });

            $item->inputField = collect();

            $subCategories = $item->details->keys()->toArray();

            $detailCategory = DB::table('tb_settlement_category')
                ->select('sub_category', 'title', 'type', 'id_input', 'element')
                ->where('title','!=','name')
                ->whereIn('sub_category', $subCategories)
                ->get()
                ->groupBy('sub_category');

            if ($detailCategory->isNotEmpty()) {
                $detailCategory->each(function ($fields, $subCategory) use ($item) {
                    if ($item->details->has($subCategory)) {
                        $item->inputField[$subCategory] = $fields;
                    }
                });
            }

            if ($item->inputField->has('Others')) {
                $others = $item->inputField->pull('Others');
                $item->inputField->put('Others', $others);
            }
        });


        // $dataSubCatTransport = Claim::join('tb_claim_transport', 'tb_claim_transport.id_claim', 'tb_claim.id')
        $dataSubCatTransport = DB::table('tb_claim_transport')
            ->select(DB::raw("category as sub_category"), 'nominal as total_nominal'
                // DB::raw('SUM(tb_claim_transport.nominal) as total_nominal'),
            )
            ->where('tb_claim_transport.id_claim',$request->id_claim)->where('tb_claim_transport.id',$request->id_sub_category)->where('tb_claim_transport.category',$request->category)->where('pid',$request->pid)
            // ->groupBy('sub_category','total_nominal')
            ->get();

        // $dataSubCatAllowance = Claim::join('tb_claim_allowance', 'tb_claim_allowance.id_claim', 'tb_claim.id')
        $dataSubCatAllowance = DB::table('tb_claim_allowance')
            ->select(DB::raw("category as sub_category"),'nominal as total_nominal'
                // DB::raw('SUM(tb_claim_allowance.nominal) as total_nominal')
            )
            ->where('tb_claim_allowance.id_claim',$request->id_claim)->where('tb_claim_allowance.id',$request->id_sub_category)->where('pid',$request->pid)->where('tb_claim_allowance.category',$request->category)
            // ->groupBy('sub_category','total_nominal')
            ->get();

        // $dataSubCatOthers = Claim::join('tb_claim_others', 'tb_claim_others.id_claim', 'tb_claim.id')
        $dataSubCatOthers = DB::table('tb_claim_others')
            ->select(DB::raw("category as sub_category"),'nominal as total_nominal'
                // DB::raw('SUM(tb_claim_others.nominal) as total_nominal')
            )
            ->where('tb_claim_others.id_claim',$request->id_claim)->where('tb_claim_others.id',$request->id_sub_category)->where('pid',$request->pid)->where('tb_claim_others.category',$request->category)
            // ->groupBy('sub_category','total_nominal')
            ->get();

        // $dataSubCatEntertain = Claim::join('tb_claim_entertain', 'tb_claim_entertain.id_claim', 'tb_claim.id')
        $dataSubCatEntertain = DB::table('tb_claim_entertain')
            ->select(DB::raw("category as sub_category"),'nominal as total_nominal'
                // DB::raw('SUM(tb_claim_entertain.nominal) as total_nominal')
            )
            ->where('tb_claim_entertain.id_claim',$request->id_claim)->where('tb_claim_entertain.id',$request->id_sub_category)->where('pid',$request->pid)->where('tb_claim_entertain.category',$request->category)
            ->where(function ($query) {
                $query->where('tb_claim_entertain.sub_category', 'like', '%Digital')
                      ->orWhere('tb_claim_entertain.sub_category', 'like', '%Manual');
            })
            // ->groupBy('sub_category','total_nominal')
            ->get();

        $getSubCategory = collect();

        $getSubCategory = $getSubCategory
            ->merge($dataSubCatTransport)
            ->merge($dataSubCatAllowance)
            ->merge($dataSubCatEntertain)
            ->merge($dataSubCatOthers);

        $data->pid_details = $pid;
        $data->sub_category = $getSubCategory;

        return collect([
            'claim' => $data
        ]);
    }

    public function getDetailClaim(Request $request)
    {
        $data = Claim::join('users','users.nik','tb_claim.issuance')->select('tb_claim.nominal','tb_claim.id','tb_claim.status','tb_claim.issuance',DB::raw('DATE(tb_claim.date_add) AS date'),'no_claim','users.name','account_name','account_number')->where('tb_claim.id',$request->id_claim)->first();
        $cek_group = Claim::join('role_user', 'role_user.user_id', '=', 'tb_claim.issuance')->join('roles', 'roles.id', '=', 'role_user.role_id')->select('roles.name', 'roles.group','mini_group')->where('tb_claim.id', $request->id_claim)->first();

        $pid = ClaimPID::select('pid','nominal')
            ->where('tb_claim_pid.id_claim',$request->id_claim);

        if (isset($request->pid)) {
            $pid = $pid->where('tb_claim_pid.pid',$request->pid)->get();
        }else{
            $pid = $pid->get();
        }

        $latestIdNotes = DB::table('tb_claim_notes')
        ->select('id_sub_category','sub_category', DB::raw('MAX(id) as latest_id'))
        ->where('status','NEW')
        ->where('id_claim',$request->id_claim)
        ->groupBy('id_sub_category','sub_category');
        
        $dataTransport = DB::table('tb_claim_notes')
            ->joinSub($latestIdNotes, 'latest_data', function($join) {
                $join->on('tb_claim_notes.id', '=', 'latest_data.latest_id');
            })
            ->rightJoin('tb_claim_transport',function($join){
                 $join->on('tb_claim_notes.id_sub_category', '=', 'tb_claim_transport.id')
                ->on('tb_claim_notes.sub_category', '=', 'tb_claim_transport.sub_category');
            })->leftJoin('tb_claim','tb_claim.id','tb_claim_transport.id_claim')
            ->select('tb_claim_transport.id','tb_claim_transport.nominal', DB::raw("(CASE WHEN (tb_claim_transport.sub_category = 'Toll') THEN toll_gate WHEN (tb_claim_transport.sub_category = 'Gasoline') THEN tb_claim_transport.sub_category WHEN (tb_claim_transport.sub_category = 'Parking') THEN location WHEN (tb_claim_transport.sub_category = 'Online Transport') THEN CONCAT(from_transport, ' - ', to_transport) END) as description"),'image as receipt','pid',DB::raw("(CASE WHEN (tb_claim_transport.date is null) THEN '-' ELSE tb_claim_transport.date END) as date"),'tb_claim_transport.sub_category',DB::raw("CASE WHEN tb_claim_notes.notes IS NULL THEN '-' ELSE tb_claim_notes.notes END as notes"),'tb_claim_notes.status','tb_claim_transport.category')
            ->where('tb_claim_transport.id_claim',$request->id_claim)->get()->groupby('pid');

        $dataAllowance = DB::table('tb_claim_notes')
            ->joinSub($latestIdNotes, 'latest_data', function($join) {
                $join->on('tb_claim_notes.id', '=', 'latest_data.latest_id');
            })
            ->rightJoin('tb_claim_allowance',function($join){
                 $join->on('tb_claim_notes.id_sub_category', '=', 'tb_claim_allowance.id')
                ->on('tb_claim_notes.sub_category', '=', 'tb_claim_allowance.sub_category');
            })->leftJoin('tb_claim','tb_claim.id','tb_claim_allowance.id_claim')
            ->select('tb_claim_allowance.id','tb_claim_allowance.nominal',DB::raw('CONCAT(tb_claim_allowance.sub_category, " - ",name) AS description'),'file as image','pid','tb_claim_allowance.sub_category',DB::raw("CASE WHEN tb_claim_notes.notes IS NULL THEN '-' ELSE tb_claim_notes.notes END as notes"),'tb_claim_notes.status','tb_claim_allowance.category',
                DB::raw("(CASE WHEN (tb_claim_allowance.date is null) THEN '-' ELSE tb_claim_allowance.date END) as date"),
                'tb_claim_allowance.start_date',
                DB::raw('DATEDIFF(end_date, start_date) + 1 as days_diff'),
                DB::raw('
                    CASE 
                        WHEN tb_claim_allowance.sub_category = "KPHL" 
                            THEN 150000
                    END AS sub_total
                '),
                DB::raw('
                    CASE 
                        WHEN tb_claim_allowance.sub_category = "KPHL" 
                            THEN (DATEDIFF(end_date, start_date) + 1) * 150000
                    END AS total
                ')

            )
            ->where('tb_claim_allowance.id_claim',$request->id_claim);

        $dataOthers = DB::table('tb_claim_notes')
            ->joinSub($latestIdNotes, 'latest_data', function($join) {
                $join->on('tb_claim_notes.id', '=', 'latest_data.latest_id');
            })
            ->rightJoin('tb_claim_others',function($join){
                 $join->on('tb_claim_notes.id_sub_category', '=', 'tb_claim_others.id')
                ->on('tb_claim_notes.sub_category', '=', 'tb_claim_others.sub_category');
            })->leftJoin('tb_claim','tb_claim.id','tb_claim_others.id_claim')
            ->select('tb_claim_others.id','tb_claim_others.nominal','description','image','receipt','pid','tb_claim_others.sub_category',DB::raw("CASE WHEN tb_claim_notes.notes IS NULL THEN '-' ELSE tb_claim_notes.notes END as notes"),'tb_claim_notes.status','tb_claim_others.category',DB::raw("(CASE WHEN (tb_claim_others.date is null) THEN '-' ELSE tb_claim_others.date END) as date"))
            ->where('tb_claim_others.id_claim',$request->id_claim);

        $dataEntertain = DB::table('tb_claim_notes')
            ->joinSub($latestIdNotes, 'latest_data', function($join) {
                $join->on('tb_claim_notes.id', '=', 'latest_data.latest_id');
            })
            ->rightJoin('tb_claim_entertain',function($join){
                 $join->on('tb_claim_notes.id_sub_category', '=', 'tb_claim_entertain.id')
                ->on('tb_claim_notes.sub_category', '=', 'tb_claim_entertain.category');
            })->leftJoin('tb_claim','tb_claim.id','tb_claim_entertain.id_claim')
            ->select('tb_claim_entertain.id','tb_claim_entertain.nominal','resto_name as description','location','image','receipt','pid',DB::raw("(CASE WHEN (tb_claim_entertain.date is null) THEN '-' ELSE tb_claim_entertain.date END) as date"),
                DB::raw("CASE WHEN tb_claim_notes.notes IS NULL THEN '-' ELSE tb_claim_notes.notes END as notes"),
                DB::raw("CASE WHEN tb_claim_entertain.entertainment IS NULL THEN '-' ELSE tb_claim_entertain.entertainment END as entertainment"),
                DB::raw("
                    (CASE 
                        WHEN (tb_claim_entertain.sub_category like '%Digital') THEN 'Entertainment' 
                        WHEN (tb_claim_entertain.sub_category like '%Manual') THEN 'Entertainment' 
                    END) as sub_category"
                ),
                'tb_claim_notes.status','tb_claim_entertain.category','tb_claim_entertain.team_internal','tb_claim_entertain.team_eksternal')  
            ->where('tb_claim_entertain.id_claim',$request->id_claim);

        if (isset($request->isClaimExport)) {
            $dataAllowance = $dataAllowance->get();
            $dataEntertain = $dataEntertain->get();
            $dataOthers    = $dataOthers->get();

            $dataAllowance->each(function ($item) {
                $item->sub_category = "Others";
            });

            $dataEntertain->each(function ($item) {
                $item->sub_category = "Others";
            });

            $dataOthers->each(function ($item) {
                $item->sub_category = "Others";
            });

            $dataAllowance = $dataAllowance->groupby('pid');
            $dataEntertain = $dataEntertain->groupby('pid');
            $dataOthers    = $dataOthers->groupby('pid');

            $pid->each(function ($item) use ($dataTransport,$dataAllowance,$dataOthers,$dataEntertain) {
                $item->details = collect();

                if ($dataTransport->get($item->pid)) {
                    $item->details = $item->details->merge($dataTransport->get($item->pid));
                }

                if ($dataAllowance->get($item->pid)) {
                    $item->details = $item->details->merge($dataAllowance->get($item->pid));
                }

                if ($dataOthers->get($item->pid)) {
                    $item->details = $item->details->merge($dataOthers->get($item->pid));
                }

                if ($dataEntertain->get($item->pid)) {
                    $item->details = $item->details->merge($dataEntertain->get($item->pid));
                }
            });

            $dataSubCatTransport = Claim::join('tb_claim_transport','tb_claim_transport.id_claim','tb_claim.id')->select('sub_category')->where('id_claim',$request->id_claim)->distinct()->get();
            $dataSubCatAllowance = Claim::join('tb_claim_allowance','tb_claim_allowance.id_claim','tb_claim.id')->select('sub_category')->where('id_claim',$request->id_claim)->distinct()->get();
            $dataSubCatOthers = Claim::join('tb_claim_others','tb_claim_others.id_claim','tb_claim.id')->select('sub_category')->where('id_claim',$request->id_claim)->distinct()->get();
            $dataSubCatEntertain = Claim::join('tb_claim_entertain','tb_claim_entertain.id_claim','tb_claim.id')->select('category as sub_category')->where('id_claim',$request->id_claim)->get();

            $getSubCategory = collect();

            $getSubCategory = $getSubCategory
                ->merge($dataSubCatTransport)
                ->merge($dataSubCatAllowance)
                ->merge($dataSubCatOthers)
                ->merge($dataSubCatEntertain);

            $getSubCategory->map(function ($subCat) {
                if ($subCat->sub_category != "Toll" && $subCat->sub_category != "Gasoline" && $subCat->sub_category != "Online Transport" && $subCat->sub_category != "Parking") {
                    $subCat->sub_category = "Others";
                }
            });
 
            $getSubCategory = $getSubCategory->unique('sub_category');
        } else {
            if (isset($request->isAllowanceExport)) {
                $dataAllowance = $dataAllowance->where('tb_claim_allowance.id',$request->id_sub_category)->where('pid',$request->pid)->get()->groupby('pid');
            }else{
                $dataAllowance = $dataAllowance->get()->groupby('pid');
            }

            if (isset($request->isEntertainExport)) {
                $dataEntertain = $dataEntertain->where('tb_claim_entertain.id',$request->id_sub_category)->where('pid',$request->pid)->get()->groupby('pid');
            }else{
                $dataEntertain = $dataEntertain->get()->groupby('pid');
            }

            $dataOthers = $dataOthers->get()->groupby('pid');

            $pid->each(function ($item) use ($dataTransport,$dataAllowance,$dataOthers,$dataEntertain) {
                $item->details = collect();

                if ($dataTransport->get($item->pid)) {
                    $item->details = $item->details->merge($dataTransport->get($item->pid));
                }

                if ($dataAllowance->get($item->pid)) {
                    $item->details = $item->details->merge($dataAllowance->get($item->pid));
                }

                if ($dataOthers->get($item->pid)) {
                    $item->details = $item->details->merge($dataOthers->get($item->pid));
                }

                if ($dataEntertain->get($item->pid)) {
                    $item->details = $item->details->merge($dataEntertain->get($item->pid));
                }
            });

            $dataSubCatTransport = Claim::join('tb_claim_transport','tb_claim_transport.id_claim','tb_claim.id')->select('sub_category')->where('id_claim',$request->id_claim)->distinct()->get();
            $dataSubCatAllowance = Claim::join('tb_claim_allowance','tb_claim_allowance.id_claim','tb_claim.id')->select('sub_category')->where('id_claim',$request->id_claim)->distinct()->get();
            $dataSubCatOthers = Claim::join('tb_claim_others','tb_claim_others.id_claim','tb_claim.id')->select('sub_category')->where('id_claim',$request->id_claim)->distinct()->get();
            $dataSubCatEntertain = Claim::join('tb_claim_entertain','tb_claim_entertain.id_claim','tb_claim.id')->select('category as sub_category')->where('id_claim',$request->id_claim)->get();

            $getSubCategory = collect();

            $getSubCategory = $getSubCategory
                ->merge($dataSubCatTransport)
                ->merge($dataSubCatAllowance)
                ->merge($dataSubCatOthers)
                ->merge($dataSubCatEntertain)
                ->unique('sub_category'); 
        }

        $nominalSumsByPidAndSubCategory = collect();

        $pid->each(function ($item) use (&$nominalSumsByPidAndSubCategory) {
            $item->details->each(function ($detail) use ($item, &$nominalSumsByPidAndSubCategory) {
                if (!isset($nominalSumsByPidAndSubCategory[$item->pid])) {
                    $nominalSumsByPidAndSubCategory[$item->pid] = collect();
                }

                $subCategory = $detail->sub_category;
                $nominalSumsByPidAndSubCategory[$item->pid][$subCategory] = isset($nominalSumsByPidAndSubCategory[$item->pid][$subCategory])
                    ? $nominalSumsByPidAndSubCategory[$item->pid][$subCategory] + $detail->nominal
                    : $detail->nominal;
            });
        });

        $subCategoriesByPid = $getSubCategory->map(function ($subCat) use ($nominalSumsByPidAndSubCategory) {
            $subCat->total_by_pid = collect();

            foreach ($nominalSumsByPidAndSubCategory as $pid => $nominals) {
                if (isset($nominals[$subCat->sub_category])) {
                    $subCat->total_by_pid[$pid] = $nominals[$subCat->sub_category];
                } else {
                    $subCat->total_by_pid[$pid] = 0;
                }
            }

            return $subCat;
        });

        $data->pid_details = $pid;
        $data->sub_category = $subCategoriesByPid;

        $unapproved = DB::table('tb_claim_activity')
            ->where('tb_claim_activity.id_claim', $request->id_claim)
            ->where('tb_claim_activity.status', "UNAPPROVED")
            ->orderBy('tb_claim_activity.id',"DESC")
            ->get();

        $tb_claim_activity = DB::table('tb_claim_activity')
            ->where('tb_claim_activity.id_claim', $request->id_claim);

        if(count($unapproved) != 0){
            $tb_claim_activity->where('tb_claim_activity.id','>',$unapproved->first()->id);
        }

        $tb_claim_activity->where(function($query){
            // $query->where('tb_claim_activity.status', 'CIRCULAR')
                $query->where('tb_claim_activity.status', 'APPROVED')->orWhere('tb_claim_activity.status','NEW')->orWhere('tb_claim_activity.status','CIRCULAR');
        });

        $show_ttd = User::join('role_user', 'role_user.user_id', '=', 'users.nik')
                        ->join('roles', 'roles.id', '=', 'role_user.role_id')->leftJoinSub($tb_claim_activity,'temp_tb_claim_activity',function($join){
                $join->on("users.name","LIKE",DB::raw("CONCAT('%', temp_tb_claim_activity.operator, '%')"));
            })
            ->select('ttd', 'users.name','roles.name as position');

        if (Str::contains($cek_group->name, 'VP') || Str::contains($cek_group->name,'Manager')) {
            if (Str::contains($cek_group->name,'Project Manager')) {
                $show_ttd = $show_ttd->where('status','CIRCULAR')->orWhere('status','APPROVED')->orderBy('temp_tb_claim_activity.id','asc')->where('id_claim',$request->id_claim)->get();
            } else {
                $show_ttd = $show_ttd->where('status','NEW')->orWhere('status','CIRCULAR')->orWhere('status','APPROVED')->orderBy('temp_tb_claim_activity.id','asc')->where('id_claim',$request->id_claim)->get();
            }
        } else {
            $show_ttd = $show_ttd->where('status','APPROVED')->orderBy('temp_tb_claim_activity.id','asc')->where('id_claim',$request->id_claim)->get();
        }

        if ($data->status == 'APPROVED' || $data->status == 'HOLD' || $data->status == 'DONE') {
            $get_ttd = $this->getSignClaim($request->id_claim,'show_ttd');

            if (isset($request->isAllowanceExport) || isset($request->isEntertainExport)) {
                $get_ttd = $get_ttd->push(collect(User::join('role_user', 'role_user.user_id', '=', 'users.nik')
                        ->join('roles', 'roles.id', '=', 'role_user.role_id')
                        ->select(
                            'users.name', 
                            'roles.name as position', 
                            'ttd',
                            'email',
                            'avatar'
                        )
                    ->where('nik',$data->issuance)->get()));

                $additional_user = User::join('role_user', 'role_user.user_id', '=', 'users.nik')
                        ->join('roles', 'roles.id', '=', 'role_user.role_id')
                        ->select('ttd', 'users.name','roles.name as position')
                    ->where('nik',$data->issuance)->first();

                if ($additional_user) {
                    $show_ttd->push($additional_user);
                }
            }else{
                $get_ttd = $get_ttd;
            }
        } else {
            $show_ttd = $show_ttd;
            $get_ttd = $this->getSignClaim($request->id_claim,'getSign');
        }

        return collect([
            'claim' => $data,
            // 'show_ttd' => $this->getSignMonReq($request->id_money_request,'show_ttd'),
            // 'tf_from_finance' => (int)$nominal_monreq->nominal,
            // 'used_amount' => (int)$data->nominal,
            // 'remaining_funds' =>$remaining_funds,
            'show_ttd' => $show_ttd,
            'getSign' => $get_ttd
        ]);

        // return response()->json($data);
    }

    public function getSignClaim($id_claim,$status){

        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;

        $data = Claim::where('id',$id_claim)->first();
        // $status = 'show_ttd';

        $cek_group = Claim::join('role_user', 'role_user.user_id', '=', 'tb_claim.issuance')->join('roles', 'roles.id', '=', 'role_user.role_id')->select('roles.name', 'roles.group','mini_group')->where('tb_claim.id', $id_claim)->first();

        $unapproved = DB::table('tb_claim_activity')
            ->where('tb_claim_activity.id_claim', $id_claim)
            ->where('tb_claim_activity.status', "UNAPPROVED")
            ->orderBy('tb_claim_activity.id',"DESC")
            ->get();

        $tb_claim_activity = DB::table('tb_claim_activity')
            ->where('tb_claim_activity.id_claim', $id_claim);

        if(count($unapproved) != 0){
            $tb_claim_activity->where('tb_claim_activity.id','>',$unapproved->first()->id);
        }
            
        $tb_claim_activity->where(function($query){
            $query->where('tb_claim_activity.status', 'NEW')
                ->orWhere('tb_claim_activity.status', 'CIRCULAR')->orWhere('tb_claim_activity.status', 'APPROVED');
        });

        $sign = User::join('role_user', 'role_user.user_id', '=', 'users.nik')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select(
                    'users.name', 
                    'roles.name as position', 
                    'ttd',
                    'email',
                    'avatar',
                    DB::raw("IFNULL(SUBSTR(`temp_tb_claim_activity`.`date_time`,1,10),'-') AS `date_sign`"),
                    DB::raw('IF(ISNULL(`temp_tb_claim_activity`.`date_time`),"false","true") AS `signed`')
                )
            ->leftJoinSub($tb_claim_activity,'temp_tb_claim_activity',function($join){
                $join->on("users.name","LIKE",DB::raw("CONCAT('%', temp_tb_claim_activity.operator, '%')"));
            })
            ->where('id_company', '1')
            ->where('status_karyawan','!=','dummy');

        if(Str::contains($cek_group->name, 'VP')){
            foreach ($sign->get() as $key => $value) {
                $sign->whereRaw("(`roles`.`name` = 'Chief Operating Officer')")
                    ->orderByRaw('FIELD(position, "Chief Operating Officer")');
            }
        } elseif(Str::contains($cek_group->name, 'Manager') && $cek_group->name != 'Project Manager'){
            if($cek_group->name == 'People Operations & Services Manager' &&  $cek_group->name == 'Human Capital Manager'){
                $sign->whereRaw("(`roles`.`name` = 'VP Program & Project Management' OR `roles`.`name` = 'Chief Operating Officer')")->orderByRaw("CASE 
                        WHEN position LIKE 'VP%' THEN 1
                        WHEN position = 'Chief Operating Officer' THEN 2
                        ELSE 3 END ");
            } elseif ($cek_group->name == 'VP Sales' || $cek_group->name == 'VP Financial & Accounting'){
                $sign->where('roles.name','Chief Executive Officer')->orderByRaw('FIELD(position, "Chief Executive Officer")');
            } else {
                $sign->whereRaw(
                    "(`roles`.`name` LIKE ? AND `roles`.`group` = ? OR `roles`.`name` = ? )", 
                    ['VP%', $cek_group->group, 'Chief Operating Officer']
                )->orderByRaw("CASE 
                        WHEN position LIKE 'VP%' THEN 1
                        WHEN position = 'Chief Operating Officer' THEN 2
                        ELSE 3 END");
            }
        } elseif($cek_group->name == 'Chief Operating Officer'){
            $sign->where('roles.name','Chief Executive Officer')->orderByRaw('FIELD(position, "Chief Executive Officer")');
        } else {
            if ($cek_group->mini_group == 'Human Capital') {
                $sign->whereRaw(
                    "(`roles`.`mini_group` = ? AND `roles`.`name` LIKE ? AND `roles`.`name` != ? OR `roles`.`name` = ? OR `roles`.`name` = ?)", 
                    [$cek_group->mini_group, '%Manager', 'Project Manager', 'VP Program & Project Management', 'Chief Operating Officer']
                )->orderByRaw("CASE 
                    WHEN position LIKE '%Manager' THEN 1
                    WHEN position LIKE 'VP%' THEN 2
                    WHEN position = 'Chief Operating Officer' THEN 3
                    ELSE 4 END ");
            } elseif ($cek_group->name == 'Account Executive') {
                $sign->whereRaw(
                    "(`users`.`id_territory` = ? AND `users`.`id_division` = ? AND `users`.`id_position` = ? AND `users`.`status_karyawan` != ?)", 
                    [$ter, $div, 'MANAGER', 'dummy']
                );
            } else if ($cek_group->mini_group == 'Product Development Specialist' || $cek_group->mini_group == 'Supply Chain Management' || $cek_group->mini_group == 'Internal Operation Support') {
                $sign->whereRaw("(`roles`.`name` LIKE 'VP%' OR `roles`.`name` = 'Chief Operating Officer')")
                    ->where('group',$cek_group->group)->orderByRaw("CASE 
                        WHEN position LIKE 'VP%' THEN 1
                        WHEN position = 'Chief Operating Officer' THEN 2
                        ELSE 3 END ");
            } else if ($cek_group->group == 'Project Management') {
                $sign->whereRaw(
                        "(`roles`.`group` = ? AND `roles`.`name` LIKE ?  AND `roles`.`name` != ? OR `roles`.`name` like ? OR `roles`.`name` = ?)", 
                        [$cek_group->group, '%Manager', 'Project Manager', '%VP Program & Project Management%', 'Chief Operating Officer']
                    )
                    ->orderByRaw("CASE 
                        WHEN position LIKE '%Project Management Office Manager%' THEN 1
                        WHEN position LIKE '%VP Program & Project Management%' THEN 2
                        WHEN position = 'Chief Operating Officer' THEN 3
                        ELSE 4 END ");
            } else {
                $sign->whereRaw(
                        "(`roles`.`mini_group` = ? AND `roles`.`name` LIKE ?  AND `roles`.`name` != ? OR `roles`.`name` LIKE ? OR `roles`.`name` = ?)", 
                        [$cek_group->mini_group, '%Manager', 'Project Manager', 'VP%', 'Chief Operating Officer']
                    )
                    ->orderByRaw("CASE 
                        WHEN position LIKE '%Manager' THEN 1
                        WHEN position LIKE 'VP%' THEN 2
                        WHEN position = 'Chief Operating Officer' THEN 3
                        ELSE 4 END ");
            }
        }

        if ($status == 'show_ttd') {
            return $sign->get();
        } else{
            return $sign->get()->where('signed','false')->first()->name;
        }
    }

    public function getRoleByPidClaim(Request $request)
    {
        $lead = DB::table('tb_id_project')->select('lead_id')->where('id_project',$request->pid)->first();

        $sbe = DB::table('tb_sbe')->join('tb_sbe_config','tb_sbe_config.id_sbe','tb_sbe.id')->join('tb_sbe_detail_config','tb_sbe_config.id','tb_sbe_detail_config.id_config_sbe')->where('tb_sbe_config.status','Choosed')->join('tb_sbe_detail_item','tb_sbe_detail_item.id','tb_sbe_detail_config.detail_item')->select('tb_sbe_detail_config.item as id','tb_sbe_detail_config.item as text')->where('lead_id',$lead->lead_id)->where('tb_sbe_detail_config.item','like','%'.request('q').'%')->distinct()->get();

        return response()->json($sbe);
    }

    public function rejectClaim(Request $request)
    {
        try {
            $storeActivity = new ClaimActivity();
            $storeActivity->id_claim = $request->id_claim;
            $storeActivity->date_time = Carbon::now()->toDateTimeString();
            $storeActivity->status = 'UNAPPROVED';
            $storeActivity->operator = Auth::User()->name;
            $storeActivity->activity = 'The circulation process was stopped because it was rejected for the following reasons: ' . $request['reasonRejectSirkular'];
            $storeActivity->save();

            $update = Claim::where('id', $request->id_claim)->first();
            $update->isCircular = 'False';
            $update->status = 'UNAPPROVED';
            $update->save();

            $detail = Claim::join('users','users.nik','tb_claim.issuance')->select('users.name','tb_claim.status','tb_claim.nominal', 'no_claim', 'id','tb_claim.date','issuance')->where('id',$request->id_claim)->first();

            $detail->notes = $request['reasonRejectSirkular'];

            $kirim_user = User::select('email', 'users.name as name_receiver')->where('nik', $detail->issuance)->first();

            Mail::to($kirim_user->email)->send(new MailPMOClaim($detail,$kirim_user,'[SIMS-APP] Reject Claim ' .$detail->no_claim, 'detail_approver', 'next_approver'));

            return response()->json([
                "action"=> "inserted",
                "tid" => $request->id_claim
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function approveClaim(Request $request)
    {
        try{
            $nik = Auth::User()->nik;
            $cek_role = DB::table('role_user')->join('roles', 'roles.id', '=', 'role_user.role_id')
                        ->select('name','group')->where('user_id', $nik)->first();

            $cek_sign = ClaimActivity::where('id_claim', $request->id_claim)->where('operator', Auth::User()->name)->whereRaw("(`status` =  'CIRCULAR' OR `status` = 'APPROVED')")->first();

            if (ClaimActivity::where('id_claim', $request->id_claim)->where('operator', Auth::User()->name)->whereRaw("(`status` =  'CIRCULAR' OR `status` = 'APPROVED')")->exists()) {
                ClaimActivity::where('id', $cek_sign->id)->delete(); 
            }

            $storeActivity = new ClaimActivity();
            $storeActivity->id_claim = $request->id_claim;
            $storeActivity->date_time = Carbon::now()->toDateTimeString();
            if ($cek_role->name == 'Chief Operating Officer' || $cek_role->name == 'Chief Executive Officer') {
                $storeActivity->status = 'APPROVED';
            } elseif ($cek_role->group == 'Financial And Accounting') {
                $storeActivity->status = 'DONE';
            } else {
                $storeActivity->status = 'CIRCULAR';
            }
            $storeActivity->operator = Auth::User()->name;
            $storeActivity->activity = 'Approval';
            $storeActivity->save();

            if ($storeActivity->status == 'APPROVED') {
                $update = Claim::where('id', $request->id_claim)->first();
                $update->status = 'APPROVED';
                $update->isCircular = 'False';
                $update->save();

                $detail = Claim::join('users', 'users.nik', '=', 'tb_claim.issuance')->select('users.name as name', 'nominal', 'tb_claim.status','tb_claim.date','tb_claim.issuance','id','tb_claim.date')->where('tb_claim.id', $request->id_claim)->first();

                $kirim_user = User::join('role_user', 'role_user.user_id', '=', 'users.nik')->join('roles', 'roles.id', '=', 'role_user.role_id')->select('email', 'users.name as name_receiver')->where('users.name', 'Marlina Sentosa')->where('status_karyawan', '!=', 'dummy')->first();

                $next_approver = $this->getSignClaim($request->id_claim, 'show_ttd');

                $email_cc = User::select('email')
                        ->where('nik',$detail->issuance)
                        ->get()->pluck('email');

                Mail::to($kirim_user)->cc($email_cc)->send(new MailPMOClaim($detail,$kirim_user,'[SIMS-APP] Claim ' .$detail->no_claim. ' is Approved By ' . Auth::User()->name . ' And Ready To APPROVED', 'detail_approver', $next_approver));

            } else if ($storeActivity->status == 'DONE') {
                $update = Claim::where('id', $request->id_claim)->first();
                $update->isCircular = 'True';
                $update->status = 'DONE';
                $update->save();

                $detail = Claim::join('users', 'users.nik', '=', 'tb_claim.issuance')->select('users.name as name', 'nominal', 'tb_claim.status','tb_claim.date','tb_claim.issuance','id','tb_claim.date')->where('tb_claim.id', $request->id_claim)->first();

                $kirim_user = User::select('email', 'users.name as name_receiver')->where('nik', $detail->issuance)->first();

                // $next_approver = $this->getSignClaim($request->id_claim, 'show_ttd');

                $email_cc = User::select('email')
                        ->where('nik',$detail->issuance)
                        ->get()->pluck('email');

                Mail::to($kirim_user)->send(new MailPMOClaim($detail,$kirim_user,'[SIMS-APP] Claim ' .$detail->no_claim. ' is Approved By ' . Auth::User()->name . ' And Ready To APPROVED', 'detail_approver', 'next_approver'));

            } else {
                $update = Claim::where('id', $request->id_claim)->first();
                $update->status = 'CIRCULAR';
                $update->save();

                $detail = Claim::join('users', 'users.nik', '=', 'tb_claim.issuance')->select('users.name as name', 'nominal', 'tb_claim.status','tb_claim.date','tb_claim.issuance','id','tb_claim.date')->where('tb_claim.id', $request->id_claim)->first();

                $kirim_user = User::select('email', 'name as name_receiver')->where('name', $this->getSignClaim($request->id_claim, 'detail'))->first();
                $next_approver = $this->getSignClaim($request->id_claim, 'detail');
                $detail_approver = $this->getSignClaim($request->id_claim, 'show_ttd');

                $cek_role = DB::table('role_user')->join('roles', 'roles.id', '=', 'role_user.role_id')
                            ->select('name', 'roles.group')->where('user_id', $detail->issuance)->first(); 

                if ($next_approver == 'Muhammad Nabil') {
                    $email_cc = User::join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('email','roles.name as name_role')
                        ->whereRaw("(`nik` = '".$detail->issuance."')")
                        ->get()->pluck('email');
                    $email_cc = $email_cc->put('4','felicia@sinergy.co.id');

                } else {
                    $email_cc = User::join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('email','roles.name as name_role')
                        ->whereRaw("(`nik` = '".$detail->issuance."')")
                        ->get()->pluck('email');
                }

                Mail::to($kirim_user)->cc($email_cc)->send(new MailPMOClaim($detail,$kirim_user,'[SIMS-APP] Claim ' .$detail->no_claim. ' is Approved By ' . Auth::User()->name, $detail_approver, $next_approver));
            }

            $approver = 'Signed by '.Auth::User()->name;

            return response()->json([
                "action"=> "inserted",
                "tid" => $request->id_claim
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        
    }

    public function updateClaim(Request $request)
    {
        $data = json_decode($request['arrDataClaim'],true);

        $parentID = Claim::select('parent_id_drive')->where('id',$request->id_claim)->first()->parent_id_drive;

        foreach ($data as $key => $value) {
            foreach ($value['item'] as $key => $dataClaim) {
                foreach ($dataClaim as $key => $dataInside) {
                    if ($request->category == 'Transport') {
                        // return $dataInside[0]['idDate'];
                        $update = ClaimTransport::where('id',$request->id_sub_category)->first();
                        $update->date = isset($dataInside[0]['idDate']) ? $dataInside[0]['idDate'] : null;
                        $update->time = isset($dataInside[0]['idTime']) ? $dataInside[0]['idTime'] : null;
                        $update->name = isset($dataInside[0]['idNameEmployee']) ? $dataInside[0]['idNameEmployee'] : null;
                        $update->role = isset($dataInside[0]['idRole']) ? $dataInside[0]['idRole'] : null;
                        $update->nominal = isset($dataInside[0]['idNominal']) ? str_replace('.', '',$dataInside[0]['idNominal']) : null;
                        $update->toll_gate = isset($dataInside[0]['idTollGate']) ? $dataInside[0]['idTollGate'] : null;
                        $update->from_transport = isset($dataInside[0]['idFromTransport']) ? $dataInside[0]['idFromTransport'] : null;
                        $update->to_transport = isset($dataInside[0]['idToTransport']) ? $dataInside[0]['idToTransport'] : null;
                        $update->driver_name = isset($dataInside[0]['idDriverName']) ? $dataInside[0]['idDriverName'] : null;
                        $update->location = isset($dataInside[0]['idLocation']) ? $dataInside[0]['idLocation'] : null;
                        if ($request->hasFile('file_'.$key.'_idUploadReceipt')) {
                            $file                   = $request->file('file_'.$key.'_idUploadReceipt');
                            $fileName               = $key.'.'.$file->getClientOriginalExtension();
                            $filePath               = $file->getRealPath();
                            $extension              = $file->getClientOriginalExtension();

                            $update->image = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                        }
                        $update->save();
                    } elseif ($request->category == 'Entertainment' || $request->category == 'CommunicationPlan' || $request->category == 'Communication Plan') {
                        $update = ClaimEntertain::where('id',$request->id_sub_category)->first();
                        $update->resto_name = isset($dataInside[0]['idRestoName']) ? $dataInside[0]['idRestoName'] : null;
                        $update->date = isset($dataInside[0]['idDate']) ? $dataInside[0]['idDate'] : null;
                        $update->time = isset($dataInside[0]['idTime']) ? $dataInside[0]['idTime'] : null;
                        $update->name = isset($dataInside[0]['idNameEmployee']) ? $dataInside[0]['idNameEmployee'] : null;
                        $update->role = isset($dataInside[0]['idRole']) ? $dataInside[0]['idRole'] : null;
                        $update->team_internal = isset($dataInside[0]['idTeamInternal']) ? $dataInside[0]['idTeamInternal'] : null;
                        $update->team_eksternal = isset($dataInside[0]['idTeamEksternal']) ? $dataInside[0]['idTeamEksternal'] : null;
                        $update->location = isset($dataInside[0]['idLocation']) ? $dataInside[0]['idLocation'] : null;
                        $update->nominal = isset($dataInside[0]['idNominal']) ? str_replace('.', '',$dataInside[0]['idNominal']) : null;
                        if ($request->hasFile('file_'.$key.'_idUploadReceipt')) {
                            $file                   = $request->file('file_'.$key.'_idUploadReceipt');
                            $fileName               = $key.'_'.$dataInside[0]['idRestoName'].'.'.$file->getClientOriginalExtension();
                            $filePath               = $file->getRealPath();
                            $extension              = $file->getClientOriginalExtension();

                            $update->receipt = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                        }
                        if ($request->hasFile('file_'.$key.'_idUploadImage')) {
                            $file                   = $request->file('file_'.$key.'_idUploadImage');
                            $fileName               = $key.'_'.$dataInside[0]['idRestoName'].'.'.$file->getClientOriginalExtension();
                            $filePath               = $file->getRealPath();
                            $extension              = $file->getClientOriginalExtension();

                            $update->image = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                        }
                        $update->save();

                    } elseif ($request->category == 'Allowance') {
                        $update = ClaimAllowance::where('id',$request->id_sub_category)->first();
                        $update->start_date = isset($dataInside[0]['idStartDate']) ? $dataInside[0]['idStartDate'] : null;
                        $update->end_date = isset($dataInside[0]['idEndDate']) ? $dataInside[0]['idEndDate'] : null;
                        $update->name = isset($dataInside[0]['idNameEmployee']) ? $dataInside[0]['idNameEmployee'] : null;
                        $update->role = isset($dataInside[0]['idRole']) ? $dataInside[0]['idRole'] : null;
                        $update->location = isset($dataInside[0]['idLocation']) ? $dataInside[0]['idLocation'] : null;
                        $update->nominal = isset($dataInside[0]['idNominal']) ? str_replace('.', '',$dataInside[0]['idNominal']) : null;
                        if ($request->hasFile('file_'.$key.'_idUploadFile')) {
                            $file                   = $request->file('file_'.$key.'_idUploadFile');
                            $fileName               = $key.'_'.$dataInside[0]['idLocation'].'.'.$file->getClientOriginalExtension();
                            $filePath               = $file->getRealPath();
                            $extension              = $file->getClientOriginalExtension();

                            $update->file = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                        }
                        $update->save();

                    } else {
                        // return $dataInside[0]['idDescription'];
                        $update = ClaimOther::where('id',$request->id_sub_category)->first();
                        $update->description = isset($dataInside[0]['idDescription']) ? $dataInside[0]['idDescription'] : null;
                        $update->date = isset($dataInside[0]['idDate']) ? $dataInside[0]['idDate'] : null;
                        $update->name = isset($dataInside[0]['idNameEmployee']) ? $dataInside[0]['idNameEmployee'] : null;
                        $update->role = isset($dataInside[0]['idRole']) ? $dataInside[0]['idRole'] : null;
                        $update->nominal = isset($dataInside[0]['idNominal']) ? str_replace('.', '',$dataInside[0]['idNominal']) : null;
                        if ($request->hasFile('file_'.$key.'_idUploadReceipt')) {
                            $file                   = $request->file('file_'.$key.'_idUploadReceipt');
                            $fileName               = $key.'_'.$dataInside[0]['idDescription'].'.'.$file->getClientOriginalExtension();
                            $filePath               = $file->getRealPath();
                            $extension              = $file->getClientOriginalExtension();

                            $update->receipt = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                        }
                        if ($request->hasFile('file_'.$key.'_idUploadImage')) {
                            $file                   = $request->file('file_'.$key.'_idUploadImage');
                            $fileName               = $key.'_'.$dataInside[0]['idDescription'].'.'.$file->getClientOriginalExtension();
                            $filePath               = $file->getRealPath();
                            $extension              = $file->getClientOriginalExtension();

                            $update->image = 'https://drive.google.com/file/d/'.$this->googleDriveUploadCustomSettlement($fileName,$filePath,$parentID).'/view?usp=drivesdk';
                        }
                        $update->save();
                    }
                }
            }

            $nominalTransport = 0;
            $nominalAllowance = 0;
            $nominalEntertain = 0;
            $nominalOther = 0;

            if (DB::table('tb_claim_transport')->select('nominal')->where('id_claim',$request->id_claim)->exists()) {
                $nominalTransport = DB::table('tb_claim_transport')->select('nominal')->where('id_claim',$request->id_claim)->sum('nominal');
            } 
            if (DB::table('tb_claim_allowance')->select('nominal')->where('id_claim',$request->id_claim)->exists()) {
                $nominalAllowance = DB::table('tb_claim_allowance')->select('nominal')->where('id_claim',$request->id_claim)->sum('nominal');
            }
            if (DB::table('tb_claim_entertain')->select('nominal')->where('id_claim',$request->id_claim)->exists()) {
                $nominalEntertain = DB::table('tb_claim_entertain')->select('nominal')->where('id_claim',$request->id_claim)->sum('nominal');
            }
            if (DB::table('tb_claim_others')->select('nominal')->where('id_claim',$request->id_claim)->exists()) {
                $nominalOther = DB::table('tb_claim_others')->select('nominal')->where('id_claim',$request->id_claim)->sum('nominal');
            }

            $nominalPid = $nominalTransport + $nominalAllowance + $nominalEntertain + $nominalOther;

            $updateNominalPID = ClaimPID::where('id_claim',$request->id_claim)->first();
            $updateNominalPID->nominal = $nominalPid;
            $updateNominalPID->save();

            $updateNominalClaim = Claim::where('id',$request->id_claim)->first();
            $updateNominalClaim->nominal = DB::table('tb_claim_pid')->select('nominal')->where('id_claim',$request->id_claim)->sum('nominal');
            $updateNominalClaim->status = 'NEW';
            $updateNominalClaim->save();

            $storeActivity = new ClaimActivity();
            $storeActivity->id_claim = $request->id_claim;
            $storeActivity->date_time = Carbon::now()->toDateTimeString();
            $storeActivity->status = 'NEW';
            $storeActivity->operator = Auth::User()->name;
            $storeActivity->activity = 'Updated Claim';
            $storeActivity->save();

            $cek_role = DB::table('role_user')->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->select('roles.name', 'roles.group','roles.mini_group')
                    ->where('user_id', Auth::User()->nik)
                    ->first(); 

            if (stripos($cek_role->name, 'Manager') !== false && stripos($cek_role->name, 'Project Manager') !== true) {
                $kirim_user = User::join('role_user', 'role_user.user_id', '=', 'users.nik')->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('email', 'users.name as name_receiver')
                ->where('roles.group',$cek_role->group )
                ->where('roles.name','like','VP%')
                ->where('status_karyawan', '!=', 'dummy')
                ->first();
            }else if(stripos($cek_role->name, 'VP') !== false) {
                $kirim_user = User::join('role_user', 'role_user.user_id', '=', 'users.nik')->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('email', 'users.name as name_receiver')
                ->where('roles.name', 'Chief Operating Officer')
                ->where('status_karyawan', '!=', 'dummy')
                ->first();
            }else{
                $kirim_user = User::join('role_user', 'role_user.user_id', '=', 'users.nik')->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('email', 'users.name as name_receiver')
                ->where('roles.mini_group',$cek_role->mini_group )
                ->where('roles.name','like','%Manager%')
                ->where('roles.name','<>','%Project Manager%')
                ->where('status_karyawan', '!=', 'dummy')
                ->first();
            }

            $detail = Claim::join('users','users.nik','tb_claim.issuance')->select('users.name','tb_claim.status','tb_claim.nominal', 'tb_claim.no_claim', 'tb_claim.id','tb_claim.date','tb_claim.issuance')->where('tb_claim.id',$request->id_claim)->first();

            Mail::to($kirim_user->email)->send(new MailPMOClaim($detail,$kirim_user,'[SIMS-APP] Update Claim ' .$detail->no_claim . ' ready to check and verify!', 'detail_approver', 'next_approver'));
        }

        return response()->json([
            "action"=> "inserted",
            "tid" => $request->id_claim
        ]);
    }

    public function storeClaim(Request $request)
    {
        try{
            $data = json_decode($request['arrDataClaim'],true);
            $customKey2 = 0;

            $edate = date("Y-m-d");

            $month = substr($edate,5,2);
            $year = substr($edate,0,4);

            $array_bln = array('01' => "I",
                        '02' => "II",
                        '03' => "III",
                        '04' => "IV",
                        '05' => "V",
                        '06' => "VI",
                        '07' => "VII",
                        '08' => "VIII",
                        '09' => "IX",
                        '10' => "X",
                        '11' => "XI",
                        '12' => "XII");
            $bln = $array_bln[$month];

            $getnumber = Claim::orderBy('id', 'desc')->where('date','like',$year."%")->count();

            if($getnumber == NULL){
                $getlastnumber = 1;
                $lastnumber = $getlastnumber;
            } else{
                $lastnumber = $getnumber+1;
            }

            if($lastnumber < 10){
               $akhirnomor = '000' . $lastnumber;
            }elseif($lastnumber > 9 && $lastnumber < 100){
               $akhirnomor = '00' . $lastnumber;
            }elseif($lastnumber >= 100 && $lastnumber < 1000){
               $akhirnomor = '0' . $lastnumber;
            } elseif ($lastnumber >= 1000) {
                $akhirnomor = $lastnumber;
            }

            $nik = Auth::User()->nik;

            $cek_role = User::join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('roles.name','group')->where('nik',$nik)->first();

            if ($cek_role->group == 'Human Capital') {
                $div = 'HCA';
            } elseif ($cek_role->group == 'Solutions & Partnership Management') {
                $div = 'PMD';
            } elseif ($cek_role->group == 'Internal Chain Management') {
                $div = 'SCA';
            } elseif ($cek_role->group == 'Project Management') {
                $div = 'PMO';
            } elseif ($cek_role->group == 'Synergy System Management') {
                $div = 'SIM';
            } elseif ($cek_role->group == 'Sales' || $cek_role->group == 'sales') {
                $div = 'SAL';
            }

            $no = $akhirnomor . '/' . $div .'/CLM/' . $bln .'/'. $year;

            $store = new Claim();
            $store->issuance = Auth::User()->nik;
            $store->date = date('Y-m-d');
            $store->no_claim = $no;
            $store->status = 'NEW';
            $store->isCircular = 'True';
            $store->account_name = $request->account_name;
            $store->account_number = $request->account_number;
            $store->date_add = Carbon::now()->toDateTimeString();
            $store->save();

            foreach ($data as $keyPid => $value) {
                $storeClaimPID = new ClaimPID();
                $storeClaimPID->id_claim = $store->id;
                $storeClaimPID->pid = $keyPid;
                $storeClaimPID->date_add = Carbon::now()->toDateTimeString();
                $nominalSum = 0;
                $nominalSum = array_reduce(
                    $value['detail']['nominal'] ?? [],
                    fn($sum, $amount) => is_numeric($amount) ? $sum + intval($amount) : $sum,
                    0
                );
                $storeClaimPID->nominal = $nominalSum;
                $storeClaimPID->save();

                foreach (['Toll', 'Gasoline', 'OnlineTransport', 'Parking'] as $category) {
                    foreach ($value['item'] as $keyCategory => $claim) {
                        if (isset($claim[$category])) {
                            $customKey2=0;
                            foreach ($claim[$category] as $data) {
                                $subCategory = ($category === 'OnlineTransport') ? 'Online Transport' : $category;
                                $customKey2++;
                                $toll = $data['idTollGate'] ?? null;
                                $storeTransport = new ClaimTransport([
                                    'id_claim' => $store->id,
                                    'pid' => $keyPid,
                                    'date' => $data['idDate'] ?? null,
                                    'time' => $data['idTime'] ?? null,
                                    'name' => Auth::User()->name,
                                    'role' => $data['idRole'] ?? null,
                                    'from_transport' => $data['idFromTransport'] ?? null,
                                    'to_transport' => $data['idToTransport'] ?? null,
                                    'driver_name' => $data['idDriverName'] ?? null,
                                    'location' => $data['idLocation'] ?? null,
                                    'nominal' => isset($data['idNominal']) ? str_replace('.', '', $data['idNominal']) : null,
                                    'sub_category' => $subCategory,
                                    'date_add' => now()->toDateTimeString(),
                                ]);
                                $image = $this->handleFileUploadClaim($request, $keyPid, $category, $customKey2, $data, $store);
                                $storeTransport->save();
                                ClaimTransport::where('id', $storeTransport->id)->update(['image' => $image,'category'=>'Transport','toll_gate'=>$toll]);
                            }
                        }
                    }
                }

                foreach (['Allowance', 'KPHL'] as $allowanceCategory) {
                    foreach ($value['item'] as $keyCategory => $claim) {
                        if (isset($claim[$allowanceCategory])) {
                            $customKey2=0;
                            foreach ($claim[$allowanceCategory] as $data) {
                                $customKey2++;
                                log::info(['info_allowance',$customKey2]);
                                $storeAllowance = new ClaimAllowance([
                                    'id_claim' => $store->id,
                                    'pid' => $keyPid,
                                    'start_date' => $data['idStartDate'] ?? null,
                                    'end_date' => $data['idEndDate'] ?? null,
                                    'name' => Auth::User()->name,
                                    'role' => $data['idRole'] ?? null,
                                    'location' => $data['idLocation'] ?? null,
                                    'nominal' => isset($data['idNominal']) ? str_replace('.', '', $data['idNominal']) : null,
                                    'category' => 'Allowance',
                                    'sub_category' => $allowanceCategory,
                                    'date_add' => now()->toDateTimeString(),
                                ]);
                                $file = $this->handleFileUploadClaim($request, $keyPid, $allowanceCategory, $customKey2, $data, $store);
                                $storeAllowance->save();
                                ClaimAllowance::where('id', $storeAllowance->id)->update(['file' => $file,'category'=>'Allowance']);
                            }
                        }
                    }
                }

                foreach (['StrukManual', 'StrukDigital'] as $entertainCategory) {
                    foreach ($value['item'] as $keyCategory => $claim) {
                        if (isset($claim[$entertainCategory])) {
                            $customKey2=0;
                            foreach ($claim[$entertainCategory] as $data) {
                                $subCategory = ($entertainCategory === 'StrukManual') ? 'Struk Manual' : (($entertainCategory === 'StrukDigital') ? 'Struk Digital' : $entertainCategory);
                                $customKey2++;
                                log::info(['info_entertain',$customKey2]);
                                $storeEntertain = new ClaimEntertain([
                                    'id_claim' => $store->id,
                                    'pid' => $keyPid,
                                    'resto_name' => $data['idRestoName'] ?? null,
                                    'date' => $data['idDate'] ?? null,
                                    'time' => $data['idTime'] ?? null,
                                    'name' => Auth::User()->name,
                                    'role' => $data['idRole'] ?? null,
                                    'team_internal' => $data['idTeamInternal'] ?? null,
                                    'team_eksternal' => $data['idTeamEksternal'] ?? null,
                                    'location' => $data['idLocation'] ?? null,
                                    'entertainment' => $data['idEntertainment'] ?? null,
                                    'nominal' => isset($data['idNominal']) ? str_replace('.', '', $data['idNominal']) : null,
                                    'date_add' => now()->toDateTimeString(),
                                    'sub_category' => $subCategory
                                ]);
                                if ($subCategory == 'Struk Manual') {
                                    $image = $this->handleFileUploadClaim($request, $keyPid, $entertainCategory, $customKey2, $data, $store);
                                } else {
                                    $image = null;
                                }
                                $receipt = $this->handleFileUploadReceiptClaim($request, $keyPid, $entertainCategory, $customKey2, $data, $store);
                                $storeEntertain->save();
                                ClaimEntertain::where('id', $storeEntertain->id)->update(['image' => $image,'receipt'=>$receipt,'category'=>'Entertainment']);
                            }
                        }
                    }
                }

                foreach (['ATK','MaterialSupport','Messanger','Accommodation','Accomodation','Mandays','Others'] as $othersCategory) {
                    foreach ($value['item'] as $keyCategory => $claim) {
                        if (isset($claim[$othersCategory])) {
                            $customKey2=0;
                            foreach ($claim[$othersCategory] as $data) {
                                $subCategory = ($othersCategory === 'MaterialSupport') ? 'Material Support' : $othersCategory;
                                $customKey2++;
                                // log::info(['info_others',$customKey2]);
                                $date = $data['idDate'] ?? null;
                                $storeOthers = new ClaimOther([
                                    'id_claim' => $store->id,
                                    'pid' => $keyPid,
                                    'description' => $data['idDescription'] ?? null,
                                    // 'date' => $data['idDate'] ?? null,
                                    'name' => Auth::User()->name,
                                    'role' => $data['idRole'] ?? null,
                                    'nominal' => isset($data['idNominal']) ? str_replace('.', '', $data['idNominal']) : null,
                                    'date_add' => now()->toDateTimeString(),
                                    'sub_category' => $subCategory
                                ]);

                                $receipt = $this->handleFileUploadClaim($request, $keyPid, $othersCategory, $customKey2, $data, $store);
                                $image = $this->handleFileUploadReceiptClaim($request, $keyPid, $othersCategory, $customKey2, $data, $store);

                                $storeOthers->save();
                                ClaimOther::where('id', $storeOthers->id)->update(['image'=>$image,'receipt'=>$receipt,'category'=>'Others','date'=>$date]);
                            }
                        }
                    }
                }
            }

            $updateNominalClaim = Claim::where('id',$store->id)->first();
            $updateNominalClaim->nominal = DB::table('tb_claim_pid')->select('nominal')->where('id_claim',$store->id)->sum('nominal');
            $updateNominalClaim->save();

            $storeActivity = new ClaimActivity();
            $storeActivity->id_claim = $store->id;
            $storeActivity->date_time = Carbon::now()->toDateTimeString();
            $storeActivity->status = 'NEW';
            $storeActivity->operator = Auth::User()->name;
            $storeActivity->activity = 'Add New Claim';
            $storeActivity->save();

            $cek_role = DB::table('role_user')->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->select('roles.name', 'roles.group','roles.mini_group')
                    ->where('user_id', Auth::User()->nik)
                    ->first(); 

            if (str_contains($cek_role->name, 'Manager') !== false && str_contains($cek_role->name, 'Project Manager') !== true) {
                $kirim_user = User::join('role_user', 'role_user.user_id', '=', 'users.nik')->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('email', 'users.name as name_receiver')
                ->where('roles.group',$cek_role->group )
                ->where('roles.name','like','VP%')
                ->where('status_karyawan', '!=', 'dummy')
                ->first();
            }else if(str_contains($cek_role->name, 'VP') !== false) {
                $kirim_user = User::join('role_user', 'role_user.user_id', '=', 'users.nik')->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('email', 'users.name as name_receiver')
                ->where('roles.name', 'Chief Operating Officer')
                ->where('status_karyawan', '!=', 'dummy')
                ->first();
            }else{

                $isManagerOnMiniGroup = User::select('users.name','users.nik','roles.mini_group as departement','phone')
                                    ->join('role_user','role_user.user_id','=','users.nik')
                                    ->join('roles','roles.id','=','role_user.role_id')
                                    ->where('roles.name','like','%Manager%')
                                    ->where('roles.name','<>','Project Manager')
                                    ->where('roles.mini_group','like','%'.$cek_role->mini_group.'%')
                                    ->first();

                if ($isManagerOnMiniGroup) {
                    $mini_group = $cek_role->mini_group;
                    $kirim_user = User::join('role_user', 'role_user.user_id', '=', 'users.nik')->join('roles', 'roles.id', '=', 'role_user.role_id')
                        ->select('email', 'users.name as name_receiver')
                        ->where('roles.mini_group',$mini_group )
                        ->where('roles.name','like','%Manager%')
                        ->where('roles.name','<>','%Project Manager%')
                        ->where('status_karyawan', '!=', 'dummy')
                        ->first();
                }else{
                    $group = $cek_role->group;
                    $kirim_user = User::join('role_user', 'role_user.user_id', '=', 'users.nik')->join('roles', 'roles.id', '=', 'role_user.role_id')
                        ->select('email', 'users.name as name_receiver')
                        ->where('roles.group',$group)
                        ->where('roles.name','like','%Manager%')
                        ->where('roles.name','<>','%Project Manager%')
                        ->where('status_karyawan', '!=', 'dummy')
                        ->first();
                }
                
            }

            $detail = Claim::join('users','users.nik','tb_claim.issuance')->select('users.name','tb_claim.status','tb_claim.nominal', 'no_claim', 'tb_claim.id','tb_claim.date','tb_claim.issuance')->where('tb_claim.id',$store->id)->first();

            Mail::to($kirim_user->email)->send(new MailPMOClaim($detail,$kirim_user,'[SIMS-APP] New Claim ' .$detail->no_claim . ' ready to check and verify!', 'detail_approver', 'next_approver'));

            return response()->json([
                "action"=> "inserted",
                "tid" => $store->id
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getExportClaim(request $request)
    {
        $dataPost['id_claim'] = $request->id_claim;
        $dataPost['isClaimExport']    = 'claim';

        $request = Request::create('/getDetailClaim', 'POST', $dataPost);

        $data = $this->getDetailClaim($request);

        // return $data;

        $pdf = PDF::loadView('PMO.claim.Pdf.claim_pdf',compact('data'))->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function getExportKPHLClaim(request $request)
    {
        $dataPost['id_claim']   = $request->id_claim;
        $dataPost['isAllowanceExport']       = 'allowance';
        $dataPost['pid']             = $request->pid;
        $dataPost['id_sub_category'] = $request->id_sub_category;

        $request = Request::create('/getDetailClaim', 'POST', $dataPost);

        $data = $this->getDetailClaim($request);

        // return $data;

        $pdf = PDF::loadView('PMO.claim.Pdf.KPHL_pdf',compact('data'));

        return $pdf->stream();
    }

    public function getExportEntertainClaim(request $request)
    {
        $dataPost['id_claim']             = $request->id_claim;
        $dataPost['isEntertainExport']    = 'entertain';
        $dataPost['id_sub_category']      = $request->id_sub_category;
        $dataPost['pid']                  = $request->pid;


        $request = Request::create('/getDetailClaim', 'POST', $dataPost);

        $data = $this->getDetailClaim($request);

        // return $data;

        $pdf = PDF::loadView('PMO.claim.Pdf.entertain_pdf',compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function handleFileUploadReceiptClaim($request, $keyPid, $category, $customKey, $data, $store)
    {
        $getClaim = DB::table('tb_claim')->where('id',$store->id)->select('no_claim')->first()->no_claim;
        if ($category == 'StrukManual' || $category == 'StrukDigital') {
            $fileKey = "file_{$keyPid}_{$category}_idReceiptImage_{$customKey}";
        } else {
            $fileKey = "file_{$keyPid}_{$category}_idUploadImage_{$customKey}";
        }

        if ($request->hasFile($fileKey)) {
            $file = $request->file($fileKey);
            $fileName = ucfirst($category) . ' ' . ($data['idNameEmployee'] ?? '') . '.' . $file->getClientOriginalExtension();

            $update = Claim::where('id',$store->id)->first();
            if ($update->parent_id_drive == null) {
                $parentID = $this->googleDriveMakeFolderClaim($getClaim);
            } else {
                $parentID = [];
                $parent_id = explode('"', $update->parent_id_drive)[1];
                array_push($parentID,$parent_id);
            }
            $update->update(['parent_id_drive' => $parentID]);

            $fileId = $this->googleDriveUploadCustomSettlement($fileName, $file->getRealPath(), $parentID);
            $image = "https://drive.google.com/file/d/{$fileId}/view?usp=drivesdk";
        }else{
            $image = "";
        }

        return $image;
    }

    public function handleFileUploadClaim($request, $keyPid, $category, $customKey, $data, $store)
    {
        $getClaim = DB::table('tb_claim')->where('id',$store->id)->select('no_claim')->first()->no_claim;
        if ($category == 'Allowance' || $category == 'KPHL') {
            $fileKey = "file_{$keyPid}_{$category}_idUploadFile_{$customKey}";
        } else if ($category == 'StrukManual') {
            $fileKey = "file_{$keyPid}_{$category}_idRestoImage_{$customKey}";
        } else {
            $fileKey = "file_{$keyPid}_{$category}_idUploadReceipt_{$customKey}";
        }

        if ($request->hasFile($fileKey)) {
            $file = $request->file($fileKey);
            $fileName = ucfirst($category) . ' ' . ($data['idNameEmployee'] ?? '') . '.' . $file->getClientOriginalExtension();

            $update = Claim::where('id',$store->id)->first();
            if ($update->parent_id_drive == null) {
                $parentID = $this->googleDriveMakeFolderClaim($getClaim);
            } else {
                $parentID = [];
                $parent_id = explode('"', $update->parent_id_drive)[1];
                array_push($parentID,$parent_id);
            }
            $update->update(['parent_id_drive' => $parentID]);

            $fileId = $this->googleDriveUploadCustomSettlement($fileName, $file->getRealPath(), $parentID);
            $image = "https://drive.google.com/file/d/{$fileId}/view?usp=drivesdk";
        }else{
            $image = '';
        }
        return $image;
    }
}