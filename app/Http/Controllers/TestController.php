<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Sales;
use Mail;
use App\Mail\EmailRemainderWeekly;
use App\Mail\MailResult;
use App\Mail\mailPID;
use App\Mail\CreateLeadRegister;
use App\Mail\AssignPresales;
use App\Mail\RaiseTender;
use App\Mail\AddContribute;
use App\Cuti;
use App\SalesChangeLog;
use App\SbeConfig;
use App\SbeActivity;
use App\PRDraft;


use App\Mail\RequestNewAssetHr;
use App\Notifications\Testing;
use Notification;
use App\Notifications\NewLead;
use App\PID;
use Auth;
use DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

use HttpOz\Roles\Models\Role;
use App\Mail\CutiKaryawan;


use App\PresenceHistory;
use App\PresenceLocationUser;
use Illuminate\Support\Facades\Storage;

use PDF;

use DatePeriod;
use DateInterval;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Carbon\Carbon;

use DateTime;
use App\PresenceShiftingUser;
use App\PresenceShifting;

use App\Mail\EmailChangeNominal;


// use App\Notifications\Result;


class TestController extends Controller
{

	public function getWorkDays(Request $request){
        $client = new Client();
        $api_response = $client->get('https://www.googleapis.com/calendar/v3/calendars/en.indonesian%23holiday%40group.v.calendar.google.com/events?key='.env('GCALENDAR_API_KEY'));
        // $api_response = $client->get('https://aws-cron.sifoma.id/holiday.php?key='.env('GOOGLE_API_KEY'));
        // $api_response = $client->get('https://aws-cron.sifoma.id/holiday.php?key=AIzaSyBNVCp8lA_LCRxr1rCYhvFIUNSmDsbcGno');
        $json = (string)$api_response->getBody();
        $holiday_indonesia = json_decode($json, true);

        $startDate = Carbon::now()->startOfYear()->format("Y-m-d");
        $endDate = Carbon::now()->endOfYear()->format("Y-m-d");

        $holiday_indonesia_final_detail = collect();
        $holiday_indonesia_final_date = collect();
        // return $holiday_indonesia;
        
        foreach ($holiday_indonesia["items"] as $value) {
            if(( ( $value["start"]["date"] >= $startDate ) && ( $value["start"]["date"] <= $endDate ) && (strstr($value['summary'], "Joint")) || ( $value["start"]["date"] >= $startDate ) && ( $value["start"]["date"] <= $endDate ) && ($value["summary"] == 'Boxing Day') )){
                $holiday_indonesia_final_detail->push(["start_date" => $value["start"]["date"],"activity" => $value["summary"]]);
                $holiday_indonesia_final_date->push($value["start"]["date"]);
            }
        }

        return $holiday_indonesia_final_date;


        $period = new DatePeriod(
             new DateTime($startDate),
             new DateInterval('P1D'),
             new DateTime($endDate . '23:59:59')
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
            // return ["date" => $item];
            // return (object) array('date' => $item);
            return $item;
        });

        return collect(["holiday" => $holiday_indonesia_final_detail, "workdays" => $workDaysMinHolidayKeyed]);
        
    }

    public function testSideBar()
    {
        $getName = DB::table('features')->pluck('name')->unique()->values();

            // return $listMenuAll;

            $getGroupAll = DB::table('features')->select('group')->whereIn('id',DB::table('roles_feature')
                    ->whereIn('role_id',DB::table('role_user')
                        ->where('user_id',Auth::User()->nik)
                        ->pluck('role_id'))
                    ->pluck('feature_id'))->groupBy('group');

            $getChildAll = DB::table($getGroupAll, 'temp')->join('features','features.group','temp.group')
                ->whereIn('id',DB::table('roles_feature')
                ->whereIn('role_id',DB::table('role_user')
                    ->where('user_id',Auth::User()->nik)
                    ->pluck('role_id'))
                ->pluck('feature_id'))
                ->select('features.group','url','icon_group','notif_status',DB::raw("REPLACE(`name`,'-','') as `name`"),'features.index_of')
                ->orderBy('index_of','ASC')->get()->groupBy('group');

            // return dd($getGroupAll);


        $getGroupChild = DB::table('features')->select('group')->whereIn('group',$getName)->whereIn('id',DB::table('roles_feature')
                ->whereIn('role_id',DB::table('role_user')
                    ->where('user_id',Auth::User()->nik)
                    ->pluck('role_id'))
                ->pluck('feature_id'))->groupBy('group');

        $getChildLevelTwo = DB::table($getGroupChild, 'temp')->join('features','features.group','temp.group')
            ->whereIn('id',DB::table('roles_feature')
            ->whereIn('role_id',DB::table('role_user')
                ->where('user_id',Auth::User()->nik)
                ->pluck('role_id'))
            ->pluck('feature_id'))
            ->select('features.group','url','icon_group','notif_status',DB::raw("REPLACE(`name`,'-','') as `name`"),'features.index_of')
            ->orderBy('index_of','ASC')->get()->groupBy('group');
        // $getChildLevelTwo->pluck('group')->unique()->values();
        // return $getChildLevelTwo->keys()->toArray();

        foreach ($getChildAll as $allData) {
            foreach ($allData as $key => $value) {
                $modified = $value->name;

                // Ensure child is added correctly only if the parent exists in the second level.
                if (in_array($value->name, $getChildLevelTwo->keys()->toArray())) {
                    // Add the child structure for the matching parent group
                    $value->child[$modified] = $getChildLevelTwo[$value->name];
                    $value->count = count($getChildLevelTwo[$value->name]);
                } else {
                    // Ensure empty child and set count to "0" if no child exists.
                    $value->child = [];
                    $value->count = '0';
                }
            }
        }

        $childGroups = [
            'Dashboard' => ['SAL', 'ICM', 'SPM', 'HCM'],
            'General Affair' => ['Consumable'],
            'PMO' => ['Project Budget']
        ];

        foreach ($childGroups as $parentGroup => $children) {
            if (isset($getChildAll[$parentGroup])) {
                foreach ($children as $childGroup) {
                    if (isset($getChildAll[$childGroup])) {
                        foreach ($getChildAll[$parentGroup] as &$parentItem) {
                            if ($parentItem->name === $childGroup) {
                                $parentItem->child[$childGroup] = $getChildAll[$childGroup];
                                $parentItem->count = count($getChildAll[$childGroup]);
                            }
                        }
                        unset($getChildAll[$childGroup]);
                    }
                }
            }
        }

        // return $getChildAll;


        $role_user = DB::table('role_user')->where('user_id','=',Auth::User()->nik)->first();
        if(!$role_user){
            $role_user = 1;
        } else {
            $role_user = $role_user->role_id;
        }

        $authUserName = Auth::user()->name;
        $allPRs = PRDraft::where('status', 'CIRCULAR')->get();

        $countPRByCircularBy = 0;
        if ($allPRs->isNotEmpty()) {
            $countPRByCircularBy = $allPRs->filter(function ($pr) use ($authUserName) {
                return $pr->circularby === $authUserName;
            })->count();
        }

        return collect([
            'userRole' => DB::table('roles')->where('id','=',$role_user)->first(),
            'listMenu' => $getChildAll, 
            'countPRByCircularBy' => $countPRByCircularBy
        ]);

    }

	public function send_mail(){
		// $email = 'faiqoh@sinergy.co.id';
	//       Notification::route('mail', $email)->notify(new NewLead($email));  

				$to = User::select('email','name')->where('id_position', 'STAFF')->where('id_division', 'TECHNICAL')->where('id_territory', 'DVG')->get();

				$users = User::select('name')->where('id_division','FINANCE')->where('id_position','MANAGER')->first();

				$pid_info = Sales::join('sales_tender_process','sales_tender_process.lead_id','=','sales_lead_register.lead_id')
									->join('tb_pid','tb_pid.lead_id','=','sales_lead_register.lead_id')
									->select('sales_lead_register.lead_id','no_po','amount_pid','quote_number2')
									->first(); 
						// Mail::to($users, new Result());

				// foreach ($to as $data) {
				// 	Mail::to($data->email)->send(new MailResult($users,$pid_info));
				// }
									$pid_info->url_create = "hahahaha";
				return new MailResult($users,$pid_info);

				// return Mail::to('tito@sinergy.co.id')->send(new MailResult($users,$pid_info));
	}

	public function getLastStatusPr()
	{
		// $data = DB::table('tb_pr_activity')->join('tb_pr','tb_pr.id_draft_pr','tb_pr_activity.id_draft_pr')->select('tb_pr_activity.id_draft_pr','tb_pr_activity.id','tb_pr_activity.status')->where('tb_pr.status','On Progress')->where('date','>','2022-11-01');

		// $getLastId = DB::table($data,'temp')->groupBy('id_draft_pr')->selectRaw('MAX(`temp`.`id`) as `id`')->selectRaw('id_draft_pr');

		// return $data = DB::table($getLastId, 'temp2')
        //     ->join('tb_pr_activity','tb_pr_activity.id','temp2.id')
        //     ->join('tb_pr','tb_pr.id_draft_pr','temp2.id_draft_pr')->select('no_pr','to','title','amount','tb_pr_activity.status')->get();

		$twoMonthsAgo = now()->subMonths(2)->format('Y-m-d');

        $years = [date('Y'),date('Y', strtotime('-1 year'))];
        // $years = [date('Y')];

        $getId = DB::table('sales_lead_register')->join('sales_change_log','sales_change_log.lead_id','sales_lead_register.lead_id')->select('sales_change_log.lead_id','id','year','sales_change_log.result')->where('sales_lead_register.nik','like','1%')->whereIn('year',$years);
        $getLastId = DB::table($getId,'temp')->groupBy('lead_id')->selectRaw('MAX(`temp`.`id`) as `last_id_log`')->selectRaw('lead_id');

        // return $getLastId->get();

        $data = DB::table($getLastId, 'temp2')->join('sales_change_log','sales_change_log.id','temp2.last_id_log')->join('sales_lead_register','sales_change_log.lead_id','sales_lead_register.lead_id')->select('status','sales_change_log.id','sales_change_log.created_at','sales_change_log.lead_id','sales_lead_register.result','sales_change_log.id','sales_change_log.result as result_log')
            ->where('sales_change_log.created_at', '<=', $twoMonthsAgo)
            ->whereRaw("(`sales_lead_register`.`result` = 'INITIAL' OR `sales_lead_register`.`result` = 'SD' OR `sales_lead_register`.`result` = '' OR `sales_lead_register`.`result` = 'TP')")->get();

        // return $data;
        // foreach ($data as $key => $value) {
        // 	$updateLead = Sales::where('lead_id',$value['lead_id'])->first();
        // 	$updateLead->result = 'HOLD';
        // 	$updateLead->save();
        // }

        // foreach ($data as $key => $value) {
        // 	$result = Sales::where('lead_id',$value->lead_id)->first()->result;
        // 	if ($result == '') {
        // 		$result = 'OPEN';
        // 	} elseif ($result == 'OPEN') {
        // 		$result = 'INITIAL';
        // 	} else {
        // 		$result = $result;
        // 	}
        // 	$updateLog = SalesChangeLog::where('id',$value->id)->first();
        // 	$updateLog->result = $result;
        // 	$updateLog->save();
        // }

        return response()->json($data);
	}

	public function getWin(Request $request)
	{
  //       // return $getRole = DB::table('roles')->join('role_user','role_user.role_id','roles.id')->select('roles.name')->where('user_id',Auth::User()->nik)->first()->name;
		// return Cuti::join('users','users.nik','=','tb_cuti.nik')
  //                   ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
  //                   ->join('tb_position','tb_position.id_position','=','users.id_position')
  //                   ->join('tb_division','tb_division.id_division','=','users.id_division')
  //                   ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division',
  //                       DB::raw("(CASE WHEN (users.id_division = 'TECHNICAL' AND id_territory = 'OPERATION') THEN 'OPERATION'  WHEN (users.id_position = 'ENGINEER STAFF' OR users.id_position = 'ENGINEER MANAGER') THEN 'SID' ELSE users.id_division END) as id_division"),
  //                       'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
  //                   ->orderBy('date_req','DESC')
  //                   ->groupby('tb_cuti.id_cuti')
  //                   ->whereYear('date_req',date('Y'))
  //                   ->groupby('nik')->get();


		$nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $years = DB::table('sales_lead_register')
        		->select('year')
        		->where('year','!=',NULL)
        		->groupBy('year')
                ->orderBy('year','desc')
                ->get();

        $currentYear = Date('Y');

        $presales = '';   


		$getPresales = DB::table('sales_solution_design')->join('users', 'users.nik', '=','sales_solution_design.nik')->selectRaw('GROUP_CONCAT(`users`.`name`) AS `name_presales`, GROUP_CONCAT(`sales_solution_design`.`nik`) AS `nik_presales`, GROUP_CONCAT(`sales_solution_design`.`priority`) AS `priority`')->selectRaw('lead_id')->groupBy('lead_id');

        $leadsnow = DB::table('sales_lead_register')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->leftJoinSub($getPresales, 'tb_presales',function($join){
                    $join->on("sales_lead_register.lead_id", '=', 'tb_presales.lead_id');
                })
                ->join('users as u_sales', 'u_sales.nik', '=', 'sales_lead_register.nik')
                ->join('tb_territory','tb_territory.id_territory','=','u_sales.id_territory')
                ->join('tb_company', 'tb_company.id_company', '=', 'u_sales.id_company')
                ->Leftjoin('tb_pid', 'tb_pid.lead_id', '=', 'sales_lead_register.lead_id')
                ->leftjoin('sales_tender_process','sales_tender_process.lead_id','=','sales_lead_register.lead_id')
                ->select('sales_tender_process.win_prob',
                    'sales_lead_register.lead_id', 
                    'tb_contact.id_customer', 
                    'tb_contact.code', 
                    'sales_lead_register.opp_name',
                    'tb_contact.customer_legal_name', 
                    'tb_contact.brand_name', 
                    'sales_lead_register.created_at', 
                    'sales_lead_register.amount',
                     'u_sales.name as name','sales_lead_register.nik',
                     'sales_lead_register.keterangan','sales_lead_register.year', 
                     'sales_lead_register.closing_date', 
                     'sales_lead_register.deal_price',
                     'u_sales.id_territory', 
                     'tb_pid.status',
                     'tb_presales.name_presales', 
                     'code_company',
                      'name_territory',
                     'tb_presales.priority', 
                     DB::raw("(CASE WHEN (result = 'OPEN') THEN 'INITIAL' WHEN (result = '') THEN 'OPEN' WHEN (result = 'SD') THEN 'SD' WHEN (result = 'TP') THEN 'TP' WHEN (result = 'WIN') THEN 'WIN' WHEN( result = 'LOSE') THEN 'LOSE' WHEN( result = 'HOLD') THEN 'HOLD' WHEN( result = 'SPECIAL') THEN 'SPECIAL' WHEN(result = 'CANCEL') THEN 'CANCEL' END) as result_modif"))
                ->orderByRaw('FIELD(result, "OPEN", "", "SD", "TP", "WIN", "LOSE", "CANCEL", "HOLD")')
                ->where('result','!=','hmm')
                ->where('status_karyawan','!=','dummy')
                // ->whereIn('year',$year)
                // ->where('year', $year)
                ->orderBy('created_at', 'desc'); 

        // $total_deal_price = Sales::join('users as u_sales', 'u_sales.nik', '=', 'sales_lead_register.nik')
        //                         ->join('tb_company', 'tb_company.id_company', '=', 'u_sales.id_company')
        //                         ->select(DB::raw('SUM(sales_lead_register.deal_price) as deal_prices'))
        //                         ->where('code_company', 'MSP')
        //                         ->where('result','!=','hmm'); 

        $total_deal_price = DB::table('sales_lead_register')
                ->join('users as u_sales', 'u_sales.nik', '=', 'sales_lead_register.nik')
                ->join('tb_company', 'tb_company.id_company', '=', 'u_sales.id_company')
                ->leftJoinSub($getPresales, 'tb_presales',function($join){
                    $join->on("sales_lead_register.lead_id", '=', 'tb_presales.lead_id');
                })
                ->leftjoin('sales_tender_process','sales_tender_process.lead_id','=','sales_lead_register.lead_id')
                ->where('result', '!=', 'hmm');

        if($ter != null){
            return $leads = $leadsnow->where('u_sales.id_company', '1')->get();

            $total_deal_price = $total_deal_price->where('u_sales.id_company', '1')->first();
            if ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
                $leads = $leadsnow->where('nik_presales', $nik)->get();

                // $total_deal_price = $total_deal_price->where('nik_presales', $nik)->first();

            } else if ($div == 'SALES') {
                $leads = $leadsnow->where('u_sales.id_territory', $ter)->get();
                // $total_deal_price = $total_deal_price->where('u_sales.id_territory', $ter)->first();
            }        
        }else{
            $leads = $leadsnow->get();
            
            $total_deal_price = $total_deal_price->sum('deal_price');
        }  

        // return $leads;


	}

	public function reportPdfTag(Request $request) {
        $pdf = PDF::loadView('report.report_tag_pdf');
        return view('report.report_tag_pdf');
        // return $pdf->download('report tagging'.date("d-m-Y").'.pdf');
    }

	public function mailCuti(){
				$id_cuti = 181;
				

				$name_cuti = DB::table('tb_cuti')
								->join('users','users.nik','=','tb_cuti.nik')
								->select('users.name')
								->first();                 

				
						$cuti_accept_data = DB::table('tb_cuti')
								->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
								->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.status',DB::raw('group_concat(date_off) as dates'),"decline_reason")
								->groupby('tb_cuti_detail.id_cuti')->where('tb_cuti_detail.status','ACCEPT')
								->where('tb_cuti.id_cuti', $id_cuti)
								->first();
						
						$ardetil_after = ""; 
				
						$cuti_reject_data = "";  

				$hari = collect(['cuti_accept'=>$cuti_accept_data,'cuti_reject'=>$cuti_reject_data]);
			
				$ardetil = explode(',', $cuti_accept_data->dates); 

				return new CutiKaryawan(
					$name_cuti,
					$hari,
					$ardetil,
					$ardetil_after,
					'[SIMS-App] Approve - Permohonan Cuti'
				); 
	}

	public function testNewLead(){
		// $data = DB::table('sales_lead_register')
		//                 ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
		//                 ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
		//                 ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'sales_lead_register.opp_name','sales_lead_register.amount', 'users.name')
		//                 ->where('lead_id','AEON200201')
		//                 ->first();
		// $data = DB::table('sales_lead_register')
		//   ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
		//   ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
		//   ->select(
		//       'sales_lead_register.lead_id',
		//       'tb_contact.customer_legal_name', 
		//       'sales_lead_register.opp_name',
		//       'sales_lead_register.amount', 
		//       'users.name')
		//   ->where('lead_id',"BMRI210403")
		//   ->first();
		// return new CreateLeadRegister($data); 

		// $total = Sales::join('users','sales_lead_register.nik','=','users.nik')
		//                 ->Leftjoin('sales_solution_design','sales_solution_design.lead_id','=','sales_lead_register.lead_id')
		//                 // ->whereRaw("(`sales_lead_register`.`result` = 'OPEN' OR `sales_lead_register`.`result` = 'SD')")
		//                 ->whereRaw("(`sales_lead_register`.`result` = '' AND 'sales_solution_design.nik','1110492070')")   
		//                 // ->where('sales_solution_design.nik','1110492070')
		//                 ->where('sales_lead_register.year',date('Y'))
		//                 ->where('users.id_company', '1')                    
		//                 ->count('sales_lead_register.lead_id');   

						$sales_sd_filtered = DB::table('sales_solution_design');

						// $total = Sales::join('users','users.nik','=','sales_lead_register.nik')
						//         ->leftJoinSub($sales_sd_filtered, 'sales_sd_filtered', function ($join) {
						//             $join->on('sales_sd_filtered.lead_id','=','sales_lead_register.lead_id');
						//         })
						//         ->selectRaw("COUNT(IF(`sales_lead_register`.`result` = 'SD',1,IF(`sales_lead_register`.`result` = 'OPEN',1,IF(`sales_lead_register`.`result` = '',1,NULL)))) AS `progress_counted`")
						//         ->where('year',date('Y'))
						//         ->where('id_company','1')
						//         ->where('sales_sd_filtered.nik','=','1110492070')
						//         ->orWhereRaw('`sales_sd_filtered`.`nik` IS NULL');

					$total = Sales::join('users','users.nik','=','sales_lead_register.nik')
										->leftJoinSub($sales_sd_filtered, 'sales_sd_filtered', function ($join) {
												$join->on('sales_sd_filtered.lead_id','=','sales_lead_register.lead_id');
										})
										->selectRaw("COUNT(IF(`sales_lead_register`.`result` = 'SD',1,IF(`sales_lead_register`.`result` = 'OPEN',1,IF(`sales_lead_register`.`result` = '',1,NULL)))) AS `progress_counted`")
										->where('year',date('Y'))
										->where('id_company','1')
										->where('sales_sd_filtered.nik','=','1110492070')
										->orWhereRaw('`sales_sd_filtered`.`nik` IS NULL');


						$test = Sales::join('users','users.nik','=','sales_lead_register.nik')
										->whereRaw("(`sales_lead_register`.`result` = 'OPEN')")
										->where('year',date('Y'))
										->where('id_company','1')
										->count('sales_lead_register.lead_id');
		return $total->first()->progress_counted;
										// return $test;

		// return Mail::to('tito@sinergy.co.id')->send(new CreateLeadRegister($data));

	}

	public function testAssignPresales(){
		$data = DB::table('sales_lead_register')
										->join('sales_solution_design','sales_solution_design.lead_id','sales_lead_register.lead_id')
										->join('users as sales', 'sales.nik', '=', 'sales_lead_register.nik')
										->join('users as presales','presales.nik','=','sales_solution_design.nik')
										->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
										->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'sales_lead_register.opp_name','sales_lead_register.amount', 'sales.name as sales_name','presales.name as presales_name')
										->where('sales_lead_register.lead_id','AEON200201')
										->first();
		$status = 'reAssign';


		// return new AssignPresales($data,$status);

		return Mail::to('tito@sinergy.co.id')->send(new AssignPresales($data,$status));

	}

	public function testRaiseToTender(){
		$data = DB::table('sales_lead_register')
										->join('sales_solution_design','sales_solution_design.lead_id','sales_lead_register.lead_id')
										->join('users as sales', 'sales.nik', '=', 'sales_lead_register.nik')
										->join('users as presales','presales.nik','=','sales_solution_design.nik')
										->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
										->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'sales_lead_register.opp_name','sales_lead_register.amount', 'sales.name as sales_name','presales.name as presales_name')
										->where('sales_lead_register.lead_id','AEON200201')
										->first();

		return Mail::to('tito@sinergy.co.id')->send(new RaiseTender($data));

		// $return =  new RaiseTender($parameterEmail);
		// Mail::to('agastya@sinergy.co.id')->send($return);
		// Mail::to('tito@sinergy.co.id')->send($return);

		// return new RaiseTender($data);      

	}

	public function testEmailPeminjaman(){

			$to = User::select('email')->where('id_division','WAREHOUSE')->where('id_position','WAREHOUSE')->get();

			$users = User::select('name')->where('id_division','WAREHOUSE')->where('id_position','WAREHOUSE')->first();


			Mail::to($to)->send(new RequestNewAssetHr($users,'[SIMS-APP] Permohonan untuk Peminjaman Asset'));

	}

	public function testRemainderEmail(){
		$parameterEmail = collect([
			// "to" => DB::table('users')->where('nik',1150991080)->first()->name,
			"to" => DB::table('users')->where('name','Rama Agastya')->first()->name,
			"proses_count" => DB::table('sales_lead_register')->where('nik',1150991080)->whereRaw('(`result` = "SD" OR `result` = "TP")')->count(),
			"tp_count" => DB::table('sales_lead_register')->where('nik',1150991080)->where('result' ,'TP')->count(),
			"tp_detail" => DB::table('sales_lead_register')
				->select('sales_lead_register.lead_id','tb_contact.brand_name','sales_lead_register.opp_name')
				->join('tb_contact','sales_lead_register.id_customer','=','tb_contact.id_customer')
				->where('nik',1150991080)
				->where('result' ,'TP')
				->get(),
			"sd_count" => DB::table('sales_lead_register')->where('nik',1150991080)->where('result' ,'SD')->count(),
			"sd_detail" => DB::table('sales_lead_register')
				->select('sales_lead_register.lead_id','tb_contact.brand_name','sales_lead_register.opp_name')
				->join('tb_contact','sales_lead_register.id_customer','=','tb_contact.id_customer')
				->where('nik',1150991080)
				->where('result' ,'SD')
				->get(),
		]);

		$return =  new EmailRemainderWeekly($parameterEmail);
		Mail::to('agastya@sinergy.co.id')->send($return);
		Mail::to('tito@sinergy.co.id')->send($return);

		// return Mail::to('tito@sinergy.co.id')->send(new EmailRemainderWeekly($parameterEmail));

		return $return;
	}

	public function authentication($id)
	{
		Auth::loginUsingId($id);
		return redirect()->back();
	}

	public function view_mail_to_sales(){
		// $pid_info = DB::table('tb_id_project')
		//         ->where('id_pro',111)
		//         ->select(
		//             'lead_id',
		//             'name_project',
		//             'no_po_customer',
		//             'sales_name',
		//             'no_po_customer',
		//             'tb_id_project.id_project'
		//         )->first();

		// if($pid_info->lead_id == "MSPQUO"){
		//   $pid_info->no_quote = $pid_info->no_po_customer;
		//   $pid_info->no_po_customer = "-";
		// }else {
		//   $pid_info->no_quote = "-";
		// }

		// return new mailPID($pid_info);

		return redirect('/salesproject');
		
	}

	public function view_mail_to_finance(){
	
		$pid_info = DB::table('sales_lead_register')
			->join('sales_tender_process','sales_tender_process.lead_id','=','sales_lead_register.lead_id')
			->join('tb_pid','tb_pid.lead_id','=','sales_lead_register.lead_id')
			->join('users','users.nik','=','sales_lead_register.nik')
			->where('sales_lead_register.lead_id','BBJB190401')
			->select(
					'sales_lead_register.lead_id',
					'sales_lead_register.opp_name',
					'users.name',
					'tb_pid.amount_pid',
					'tb_pid.id_pid',
					'tb_pid.no_po',
					'sales_tender_process.quote_number2'
			)->first();

		if($pid_info->lead_id == "MSPQUO"){
			$pid_info->url_create = "/salesproject";
		}else {
			$pid_info->url_create = "/salesproject#acceptProjectID?" . $pid_info->id_pid;
		}

		$users = User::select('name')->where('name','Rama Agastya')->first();



		return new MailResult($users,$pid_info);
	}

	public function postEventCalendar(Request $request){
		// $calenderId = "kfo8st45f546hr112s6ia4mgmo@group.calendar.google.com";
		$calenderId = $request->group;

		$client = new Client();
		$url = "https://www.googleapis.com/calendar/v3/calendars/".$calenderId."/events?key=".env('APPSINERGY_GOOGLE_API_KEY')."&sendNotifications=true";
		$token = $this->getOauth2AccessToken();

		$response =  $client->request(
					'POST', 
					$url,        
					[
						// 'form_params' => [
						//     'sendNotifications' => true,
						// ],
						'headers' => [
							'Content-Type'=>'application/json',
							'Authorization'=>$token
						],'json' => [
								"summary" => $request->summary,
								"start" => array(
									'dateTime' => $request->startDateTime,
								),
								"end" => array(
									'dateTime' => $request->endDateTime,
								),
								"description" => $request->description,
								'reminders' => array(
									'useDefault' => FALSE,
									'overrides' => array(
										array('method' => 'email', 'minutes' => 24 * 60),
										array('method' => 'popup', 'minutes' => 10),
									),
								),
								'attendees'=> array(
									array('email'=> $request->email),
								),
						]
					]
		);

		return $response->getBody();
	}

	public function getOauth2AccessToken(){
		$client = new Client();

		$response = $client->request(
				'POST',
				'https://oauth2.googleapis.com/token',
				[
					'headers' => [
						'Content-Type' => 'application/x-www-form-urlencoded',
					],
					'form_params' => [
						'grant_type' => 'refresh_token',
						'client_id' => env('GCALENDER_CLIENT_ID'),
						'client_secret' => env('GCALENDER_CLIENT_SECRET'),
						'refresh_token' => env('GCALENDER_REFRESH_TOKEN')
					]
				]
			);

		$response = json_decode($response->getBody());

		return "Bearer " . $response->access_token;
		// if(Cache::store('file')->has('webex_access_token')){
		//   Log::info('Webex Access Token still falid');
		//   return "Bearer " . Cache::store('file')->get('webex_access_token');
		// } else {
		//   Log::error('Webex Access Token not falid. Try to refresh token');
		//   $client = new Client();
		//   $response = $client->request(
		//     'POST',
		//     'https://webexapis.com/v1/access_token',
		//     [
		//       'headers' => [
		//         'Content-Type' => 'application/x-www-form-urlencoded',
		//       ],
		//       'form_params' => [
		//         'grant_type' => 'refresh_token',
		//         'client_id' => env('WEBEX_CLIENT_ID'),
		//         'client_secret' => env('WEBEX_CLIENT_SECRET'),
		//         'refresh_token' => env('WEBEX_REFRESH_TOKEN')
		//       ]
		//     ]
		//   );

		//   $response = json_decode($response->getBody());

		//   if(isset($response->access_token)){
		//     Log::info('Refresh Token success. Save token to cache file');
		//     Cache::store('file')->put('webex_access_token',$response->access_token,now()->addSeconds($response->expires_in));
		//     return "Bearer " . Cache::store('file')->get('webex_access_token');
		//   } else {
		//     Log::error('Refresh Token failed. Please to try change "refresh token"');
		//   }
		// }
	}

	public function getListEvent(){
		$client = new Client();
		$url = "https://www.googleapis.com/calendar/v3/calendars/primary/events?key=".env('APPSINERGY_GOOGLE_API_KEY');
		$token = $this->getOauth2AccessToken();

		$response = $client->request(
			'GET',
			$url,
			[
				'headers' => [
					'Accept'=>'application/json',
					'Content-Type'=>'application/json',
					'Authorization'=>$token
				]
			]
		);

		return $response->getBody();
	}

	public function getCalendarList(){
		$client = new Client();
		$url = "https://www.googleapis.com/calendar/v3/users/me/calendarList?key=".env('APPSINERGY_GOOGLE_API_KEY');
		$token = $this->getOauth2AccessToken();

		$response = $client->request(
			'GET',
			$url,
			[
				'headers' => [
					'Accept'=>'application/json',
					'Content-Type'=>'application/json',
					'Authorization'=>$token
				]
			]
		);

		$json = (string)$response->getBody();
		$responses = json_decode($json,true);

		return $responses;
	}

	public function storeEvents(Request $request){
		$client = $this->getClient();   
		$service  = new Google_Service_Calendar($client);

		$calendarId = $request->group;
		$event    = new Google_Service_Calendar_Event(array(
				'summary' => $request->summary,
				// 'location' => 'Gelora Bung Karno',
				'description' => $request->description,
				"start" => array(
					'dateTime' => $request->startDateTime,
				),
				"end" => array(
					'dateTime' => $request->endDateTime,
				),
				'attendees' => array(
					array('email' => $request->email),
				),
				'reminders' => array(
					'useDefault' => FALSE,
					'overrides' => array(
						array('method' => 'email', 'minutes' => 24 * 60),
						array('method' => 'popup', 'minutes' => 10),
					),
				),
		));

		$optParams = Array(
			'sendNotifications' => true,
		);

		$event = $service->events->insert($calendarId, $event, $optParams);
		printf('Event created: %s\n', $event->htmlLink); 
	}

	public function getClient(){
		$client = new Google_Client();
		$client->setScopes(Google_Service_Calendar::CALENDAR);
		// $client->setAuthConfig('/home/dinar/sims-dev/app/Http/Controllers/client_secrets.json');
		$tokenPath = '/home/dinar/sims-dev/app/Http/Controllers/token.json';
		echo "string";

		if (file_exists($tokenPath)) {
				$accessToken = json_decode(file_get_contents($tokenPath), true);
				$client->setAccessToken($accessToken);
		}

		if (!$client->isAccessTokenExpired()) {
				// echo "string";
				return $client;
				// $service = new Google_Service_Calendar($client);

				// Print the next 10 events on the user's calendar.
				// $optParams = array(
				//   'maxResults' => 10,
				//   'orderBy' => 'startTime',
				//   'singleEvents' => true,
				//   'timeMin' => date('c'),
				// );
				// $results = $service->events->listEvents($calendarId, $optParams);
				// $events = $results->getItems();

				// if (empty($events)) {
				//     print "No upcoming events found.\n";
				// } else {
				//     print "Upcoming events:\n";
				//     foreach ($events as $event) {
				//         $start = $event->start->dateTime;
				//         if (empty($start)) {
				//             $start = $event->start->date;
				//         }
				//         printf("%s (%s)\n", $event->getSummary(), $start);
				//     }
				// }

				
		} else {
			$redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . '/oauth2callback';
			return redirect()->away($redirect_uri);
		}
														
	}

	public function testJson(){
		$client = $this->getClient();   
		$service  = new Google_Service_Calendar($client);

			$calendarId = "gbivof9sl2pmd7vok9bopi03oc@group.calendar.google.com";
			$event    = new Google_Service_Calendar_Event(array(
					'summary' => 'Hari Kartono',
					'location' => 'Gelora Bung Karno',
					'description' => 'A chance to hear more about Google\'s developer products.',
					'start' => array(
						'dateTime' => '2021-04-22T09:00:00+07:00',
						'timeZone' => 'Asia/Jakarta',
					),
					'end' => array(
						'dateTime' => '2021-04-22T17:00:00+07:00',
						'timeZone' => 'Asia/Jakarta',
					),
					'recurrence' => array(
						'RRULE:FREQ=DAILY;COUNT=2'
					),
					'attendees' => array(
						array('email' => 'faiqoh11.fa@gmail.com'),
						array('email' => 'ladinarnanda@gmail.com'),
					),
					'reminders' => array(
						'useDefault' => FALSE,
						'overrides' => array(
							array('method' => 'email', 'minutes' => 24 * 60),
							array('method' => 'popup', 'minutes' => 10),
						),
					),
			));

			$optParams = Array(
				'sendNotifications' => true,
			);

			$event = $service->events->insert($calendarId, $event, $optParams);
			printf('Event created: %s\n', $event->htmlLink); 
	}

	public function oauth2callback(Request $request){
		$client = new Google_Client();
		$client->setAuthConfigFile('/home/dinar/sims-dev/app/Http/Controllers/client_secrets.json');
		$client->setRedirectUri('https://' . $_SERVER['HTTP_HOST'] . '/oauth2callback');

		$client->setScopes(Google_Service_Calendar::CALENDAR);

		if (! isset($_GET['code'])) {
			$auth_url = $client->createAuthUrl();
			return redirect()->away($auth_url);
			echo "stringss";
		} else {
			$client->authenticate($_GET['code']);
			echo "string";
			$request->session()->put('access_token',$client->getAccessToken());
			$tokenPath = '/home/dinar/sims-dev/app/Http/Controllers/token.json';
			if (!file_exists(dirname($tokenPath))) {
					mkdir(dirname($tokenPath), 0700, true);
			}
			file_put_contents($tokenPath, json_encode($client->getAccessToken()));
			$redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . '/';
			return redirect()->away($redirect_uri);
		}
	}

	public function testPermission(){
		return view('testPermission')->with(['initView'=> $this->initMenuBase()]);
	}

	public function testPermissionConfig(){ 
		return view('testPermissionConfig')->with(['initView'=> $this->initMenuBase()]);
	}

	public function getUserList(){

		$checkForAllFeatureItem = [7,33,17,39];

		$permitted = false;
		if(in_array(DB::table('role_user')->where('user_id',Auth::User()->nik)->first()->role_id,$checkForAllFeatureItem)){
			$permitted = true;
		}

		return collect([ "data" => DB::table('role_user')
			->select(
					'role_user.*',
					DB::raw('`roles`.`group` AS `name_group`'),
					DB::raw('`roles`.`name` AS `name_roles`'),
					'users.name',
					'roles_feature_each.each_feature'
				)
			->join('users','role_user.user_id','=','users.nik')
			->join('roles','role_user.role_id','=','roles.id')
			->joinSub(DB::table('roles_feature')
				->select(
					'roles_feature.role_id',
					DB::raw('GROUP_CONCAT(`features`.`name`) AS `each_feature`')
				)
				->join('features','features.id','=','roles_feature.feature_id')
				->groupBy('roles_feature.role_id'), 'roles_feature_each', function ($join) {
				$join->on('roles.id', '=', 'roles_feature_each.role_id');
			})
			->where('status_karyawan', '!=', 'dummy')
			// ->take(1)
			->get(),"permitted" => $permitted]);
	}

	public function getParameter(){
		$name = DB::table('users')
			->select(
					DB::raw('`nik` AS `id`'),
					DB::raw('`name` AS `text`'),
				)
			->where('id_company','=','1')
			->where('status_karyawan','=','cuti')
			->get();

		$roles = DB::table('roles')
			->select(
				DB::raw('`id` AS `id`'),
				DB::raw('`name` AS `text`'),
				DB::raw('`group` AS `group`'),
			)->get();

			$groups = [];
			foreach($roles->pluck('group')->unique()->values() as $group){
				array_push($groups, ["text" => strtoupper($group),"children" => $roles->where('group',$group)->values()]);
			}

			// return collect(["result" => ["text" => "Sales","children" => [["id"=>1],["id"=>2]]]]);
			// return $groups;
		return collect(['name' => $name,'roles' => $groups]);
	}

	public function getParameterRoles(){
			$roles = DB::table('roles')
			->select(
				DB::raw('`id` AS `id`'),
				DB::raw('`name` AS `text`'),
				DB::raw('`group` AS `group`'),
			)->get();

			$groups = [];
			foreach($roles->pluck('group')->unique()->values() as $group){
				array_push($groups, ["text" => strtoupper($group),"children" => $roles->where('group',$group)->values()]);
			}
			// return collect(["result" => ["text" => "Sales","children" => [["id"=>1],["id"=>2]]]]);
			// return $groups;
		return collect(['roles' => $groups]);
	}

	public function getParameterFeature(Request $req){
			$features = DB::table('features')
			->select(
				DB::raw('`features`.`id` AS `id`'),
				DB::raw('`name` AS `text`'),
				DB::raw('`group` AS `group`'),
			)->whereNotIn('id', function($query) use ($req){
				$query->select('feature_id')
							->from('roles_feature')->where('role_id',$req->roles_id);
			})
			->get();

			$groupsFeature = [];
			foreach($features->pluck('group')->unique()->values() as $group){
				array_push($groupsFeature, ["text" => strtoupper($group),"children" => $features->where('group',$group)->values()]);
			}

			// return collect(["result" => ["text" => "Sales","children" => [["id"=>1],["id"=>2]]]]);
			// return $groups;
		return collect(['features' => $groupsFeature]);
	}


	public function getFeatureRole(){
		return DB::table('roles')
			->select(
					DB::raw('`roles`.`group` AS `name_group`'),
					DB::raw('`roles`.`name` AS `name_roles`'),
					DB::raw('`roles_feature_each`.`each_feature` AS `feature_name`')
				)
			// ->join('features','features.id','=','roles_feature.feature_id')
			->joinSub(DB::table('roles_feature')
				->select(
					'roles_feature.role_id',
					DB::raw('GROUP_CONCAT(`features`.`name`) AS `each_feature`')
				)
				->join('features','features.id','=','roles_feature.feature_id')
				->groupBy('roles_feature.role_id'), 'roles_feature_each', function ($join) {
				$join->on('roles.id', '=', 'roles_feature_each.role_id');
			})
			->get();
		// return DB::table('roles')->get();
	}

	public function setRoles(Request $req){
		foreach ($req->id_role as $id_role) {
			User::find($req->id_user)->attachRole(Role::find($id_role));
		}
		// return $req->id_role;
		return "Success";
	}

	public function setRolesFeature(Request $req){
		foreach ($req->id_feature as $id_feature) {
			DB::table('roles_feature')->insert([
				'role_id' => Role::find($req->id_role)->id,
				'feature_id' => $id_feature
			]);
			// Role::find($req->id_role)->attachRole(DB::table('features')->find($id_feature));
		}
		// return $req->id_role;
		return "Success";
	}

	public function addConfigRoles(Request $req){
		DB::table('roles')->insert([
				'name' => $req->name,
				'slug' => $req->slug,
				'description' => $req->description,
				'group' => $req->group
		]);

		return "Success";
	}

	public function addConfigFeature(Request $req){
		if ($req->id_feature) {
			$group_name = DB::table('features')->where('id',$req->id_feature)->first();

			$groupId = DB::table('features')->select('id')->where('group',$group_name->group)->get();

			foreach($groupId as $groupId){
				DB::table('features')
					->where('id',$groupId->id)
					->update([
					'icon' => $req->icon,
					'icon_group' => $req->icon,
				]);
			}
		}else{
			$index_of = DB::table('features')->latest('index_of')->first()->index_of + 1;

			DB::table('features')->insert([
				'name' => $req->name,
				'description' => $req->description,
				'group' => $req->group,
				'index_of'=> $index_of,
				'url'=>$req->url,
				'icon' => $req->icon,
				'icon_group' => $req->icon,
			]);
		}
		

		return "Success";
	}

	public function addConfigFeatureItem(Request $req){
		DB::table('feature_item')->insert([
			'item_id' => $req->item_id,
			'group' => $req->group,
		]);

		return "Success";
	}

	public function getRoles(Request $req){
		return DB::table('roles')->get();
	}

	public function getFeature(Request $req){
		return DB::table('features')->get();
	}

	public function getConfigFeature(Request $req){
		return DB::table('features')->where('id',$req->id)->get();
	}

	// public function getWorkDays(Request $request){
 //        return $data = DB::table('tb_timesheet')->select('users.name')->join('users','users.nik','tb_timesheet.nik')->whereMonth('start_date','7')->groupby('tb_timesheet.nik')->get();
 //    }

	public function getRoleDetail(Request $req){
		return collect([
			'role' => DB::table('roles')->where('id','=',$req->id)->get()->first(),
			'holder' => DB::table('role_user')
				->select('users.name')
				->join('users','role_user.user_id','=','users.nik')
				->where('role_id','=',$req->id)
				->get()
		]);
	}

	public function getFeatureItem(Request $req){
		$column = DB::table('roles')->selectRaw('`id`,`name` AS `title`, REPLACE(`slug`,".","_") AS `name`,CONCAT("condition_",REPLACE(`slug`,".","_")) AS `data`');
		if($req->group == "All") {
			$column2 = $column->get();
		} else {
			$column2 = $column->where('group','=',$req->group)
				->get();
		}

		$column = $column2->map(function ($item, $key) {
				$item->class = "text-center";
				return $item;
		})->filter(function ($item, $key) {
			return $item->title != "Admin";
		})->sortBy('title')->values();

		// return $column;

		$return = DB::table('feature_item')
			->select("feature_item.*");
			
		foreach ($column as $key => $value) {
			$return = $return->addSelect($value->name . ".condition_" . $value->name);
			$leftJoin = DB::table('roles_feature_item')
				->where('roles_id','=',$value->id);

			$join = DB::table('feature_item')
				->selectRaw('`feature_item`.`id`, CONCAT("' . "<label class='switch'><input class='featureItemCheck' type='checkbox' id='" . $value->id . "-" . '",' . '`feature_item`.`id`' . ',"\' ",' . "IF(`roles_feature_item_filtered`.`id` > 0,'checked','')" . ',"' . "><span class='slider round'></span></label>" . '") AS `condition_' . $value->name . '`')
				->leftJoinSub($leftJoin,'roles_feature_item_filtered',function($join){
					$join->on('roles_feature_item_filtered.feature_item_id','=','feature_item.id');
				});
			$return = $return->joinSub($join,$value->name,function($join) use ($value){
				$join->on($value->name . '.id','=','feature_item.id');
			});

			// $return = $return->selectRaw('CONCAT("' . "<label class='switch'><input type='checkbox' id='checkbox1'><span class='slider round'></span></label>" . '") AS `' . $value->name . '`');
			
			// $return = $return->selectRaw('CONCAT("' . "<label class='switch'><input type='checkbox' id='checkbox1'><span class='slider round'></span></label>" . '") AS `' . $value->name . '`');
		}

		$column->prepend(['title' => "Item",'data' => "item_id"]);
		$column->prepend(['title' => "Feature",'data' => "group"]);

		// return $return->get();

		return collect(['data' => $return->get(),'column' => $column]);

		// return DB::table('feature_item')
		//   ->selectRaw("*")
		//   ->selectRaw('CONCAT("' . "<label class='switch'><input type='checkbox' id='checkbox1'><span class='slider round'></span></label>" . '") AS `director`')
		//   ->selectRaw('CONCAT("' . "<label class='switch'><input type='checkbox' id='checkbox1'><span class='slider round'></span></label>" . '") AS `staff`')
		//   ->selectRaw('CONCAT("' . "<label class='switch'><input type='checkbox' id='checkbox1'><span class='slider round'></span></label>" . '") AS `admin`')
		//   ->selectRaw('CONCAT("' . "<label class='switch'><input type='checkbox' id='checkbox1'><span class='slider round'></span></label>" . '") AS `hrstaff`')
		//   ->selectRaw('CONCAT("' . "<label class='switch'><input type='checkbox' id='checkbox1'><span class='slider round'></span></label>" . '") AS `hrga`')
		//   ->selectRaw('CONCAT("' . "<label class='switch'><input type='checkbox' id='checkbox1'><span class='slider round'></span></label>" . '") AS `pmostaff`')
		//   ->get();
	}

	public function getFeatureItemParameterByRoleGroup(){
		// return DB::table('roles')->select('group')->groupBy('group')->pluck('group')->toArray();
		// return gettype(DB::table('roles')->select('group')->groupBy('group')->pluck('group')->toArray());

		// dd(DB::table('role_user')->where('user_id',Auth::User()->nik)->first());
		// return DB::table('roles')->where('id',DB::table('role_user')->where('user_id',Auth::User()->nik)->first()->role_id)->pluck('group')->toArray();

		// $checkForAllFeatureItem = DB::table('roles_feature_item')
		// 	->where('roles_id',DB::table('role_user')->where('user_id',Auth::User()->nik)->first()->role_id)
		// 	->where('feature_item_id',124)
		// 	->first();


		// For Production
		$checkForAllFeatureItem = [7,33,17,39];

		// For Development
		// $checkForAllFeatureItem = [7,33,17,28];

		if(in_array(DB::table('role_user')->where('user_id',Auth::User()->nik)->first()->role_id,$checkForAllFeatureItem)){
			$data = DB::table('roles')->where('group','<>','default')->select('group')->groupBy('group')->pluck('group')->toArray();
			array_unshift($data, "All");
		} else {
			$data = DB::table('roles')->where('id',DB::table('role_user')->where('user_id',Auth::User()->nik)->first()->role_id)->pluck('group')->toArray();
			// array_unshift($data, "");
		}

		return $data;
	}

	public function getFeatureItemParameterByFeatureItem(){
		// return DB::table('roles')->select('group')->groupBy('group')->pluck('group')->toArray();
		// return gettype(DB::table('roles')->select('group')->groupBy('group')->pluck('group')->toArray());
		$data = DB::table('feature_item')->select('group')->groupBy('group')->pluck('group')->toArray();
		array_unshift($data, "", "All");
		return $data;
	}

	public function changeFeatureItem(Request $req){
		sleep(1);
		$roleFeatureItem = DB::table('roles_feature_item')
			->where('roles_id','=',$req->role)
			->where('feature_item_id','=',$req->feature);

		if($roleFeatureItem->exists()){
			$roleFeatureItem->delete();
			return "deleted";
		} else {
			DB::table('roles_feature_item')
				->insert([
					'roles_id' => $req->role,
					'feature_item_id' => $req->feature
				]);
			return "added";
		}
	}

	public function getReportCuti (){
		$spreadsheet = new Spreadsheet();

		$spreadsheet->removeSheetByIndex(0);
		$spreadsheet->addSheet(new Worksheet($spreadsheet,'All Leaving Permit'));
		$summarySheet = $spreadsheet->setActiveSheetIndex(0);

		// $summarySheet->mergeCells('B1:Y1');
		$normalStyle = [
			'font' => [
				'name' => 'Calibri',
				'size' => 8
			],
		];

		$titleStyle = $normalStyle;
		$titleStyle['alignment'] = ['horizontal' => Alignment::HORIZONTAL_CENTER];
		// $titleStyle['alignment'] = ['vertical' => Alignment::VERTICAL_CENTER];
		$titleStyle['borders'] = ['outline' => ['borderStyle' => Border::BORDER_THIN]];
		// $titleStyle['fill'] = ['fillType' => Fill::FILL_SOLID, 'startColor' => ["argb" => "FFFCD703"]];
		$titleStyle['font']['bold'] = true;

		$headerStyle = $normalStyle;
		$headerStyle['font']['bold'] = true;
		$headerStyle['fill'] = ['fillType' => Fill::FILL_SOLID, 'startColor' => ["argb" => "FFC9C9C9"]];
		$headerStyle['borders'] = ['allBorders' => ['borderStyle' => Border::BORDER_THIN]];

		$summarySheet->getStyle('A1:Y1')->applyFromArray($titleStyle);
		$summarySheet->getStyle('A2:Y2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$summarySheet->getStyle('A2:Y2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$summarySheet->getStyle('C2:Y2')->getAlignment()->setWrapText(true);
		$summarySheet->getStyle('C2:Y2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$summarySheet->setCellValue('B1','PT. SINERGY INFORMASI PRATAMA');
		$summarySheet->setCellValue('D1','Report cuti per ' . Carbon::now()->format("d M Y"));



		$headerContent = ["No","NAMA","Tanggal Mulai Masuk","Hak Cuti 2020","Sisa Cuti 2020","Hak Cuti Tahunan","Cuti Bersama","Hak Cuti 2021","Cuti yg Diminta","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Aug","Sep","Okt","Nov","Des","Tgl Kerja Kembali","TOTAL Cuti yg telah diambil","Sisa Cuti 2021","Jenis Cuti / Keterangan"];
		$summarySheet->getStyle('A2:Y2')->applyFromArray($headerStyle);
		$summarySheet->getStyle('E2')->getFont()->getColor()->setARGB("FF0B24FB");
		$summarySheet->getStyle('F2')->getFont()->getColor()->setARGB("FF0B24FB");
		$summarySheet->getStyle('V2')->getFont()->getColor()->setARGB("FF0B24FB");
		$summarySheet->getStyle('X2')->getFont()->getColor()->setARGB("FF0B24FB");
		$summarySheet->getStyle('Y2')->getFont()->getColor()->setARGB("FF0B24FB");

		$summarySheet->getStyle('G2')->getFont()->getColor()->setARGB("FFF32229");
		$summarySheet->getStyle('W2')->getFont()->getColor()->setARGB("FFF32229");
		$summarySheet->fromArray($headerContent,NULL,'A2');

		// $startDate = Carbon::now()->subMonths(1)->format("Y-m-16");
		// $endDate = Carbon::now()->format("Y-m-16");

		// $presenceController = new PresenceController();

		// $workDays = $presenceController->getWorkDays($startDate,$endDate)["workdays"]->values();

		// $parameterUser = PresenceHistory::groupBy('nik')
		//   ->whereRaw('`presence_actual` BETWEEN "' . $startDate . '" AND "' . $endDate . '"')
		//   ->pluck('nik');

		// // return $parameterUser;

		// $presenceHistoryAll = collect();
		// foreach ($parameterUser as $value) {
		//   $presenceHistoryTemp = PresenceHistory::select(
		//     DB::raw("*"),
		//     DB::raw("CAST(`presence_actual` AS DATE) AS `presence_actual_date`")
		//   )->whereRaw('`nik` = ' . $value)
		//   ->whereRaw('`presence_actual` BETWEEN "' . $startDate . '" AND "' . $endDate . '"');

		//   $presenceHistory = DB::table(DB::raw("(" . $presenceHistoryTemp->toSql() . ") AS `presence__history_temp`"))
		//     ->join('users','users.nik','=','presence__history_temp.nik')
		//     ->select('presence__history_temp.nik','users.name')
		//     ->selectRaw("CAST(MIN(`presence__history_temp`.`presence_actual`) AS DATE) AS `date`")
		//     ->selectRaw("MIN(`presence__history_temp`.`presence_schedule`) AS `schedule`")
		//     ->selectRaw("RIGHT(MIN(`presence__history_temp`.`presence_actual`),8) AS `checkin`")
		//     ->selectRaw("IF(MAX(`presence__history_temp`.`presence_actual`) = MIN(`presence__history_temp`.`presence_actual`), '-', RIGHT(MAX(`presence__history_temp`.`presence_actual`),8)) AS `checkout`")
		//     ->selectRaw("MAX(`presence__history_temp`.`presence_condition`) AS `condition`")
		//     ->groupBy('presence__history_temp.presence_actual_date');

		//   $presenceHistoryAll = $presenceHistoryAll->merge($presenceHistory->get());

		//   $presenceHistoryAbsent = $workDays->diff($presenceHistory->get()->pluck('date')->values())->values();
		//   $presenceHistoryAbsentTemp = collect();
		//   foreach ($presenceHistoryAbsent as $key => $absentDate) {
		//     $presenceHistoryAll->push((object) [
		//       "nik" => $value,
		//       "name" => $presenceHistory->first()->name,
		//       "date" => $absentDate,
		//       "schedule" => "08:00:00",
		//       "checkin" =>  "00:00:00",
		//       "checkout" =>  "00:00:00",
		//       "condition" => "Absent"
		//     ]);
		//   }
		// }

		// $presenceHistoryAllLate = $presenceHistoryAll->where('condition','Late');
		// $presenceHistoryAllAbsent = $presenceHistoryAll->where('condition','Absent');
		// $presenceHistoryAllUnCheckout = $presenceHistoryAll->where('checkout','=','-');
		// $presenceHistoryAllUnCheckout->each(function ($item, $key) {
		//   if($item->condition != "Late" && $item->condition != "Absent"){
		//     $item->condition = "Uncheckout";
		//   }
		// });

		// if($typeData == "all"){
		//   return collect([
		//     "data" => $presenceHistoryAll->merge($presenceHistoryAllUnCheckout)->unique(),
		//   ]);
		// } else {
		//   return collect([
		//     "data" => $presenceHistoryAllLate->merge($presenceHistoryAllUnCheckout)->merge($presenceHistoryAllAbsent)->unique(),
		//   ]);
		// }

		$jumlah_cuti = "7";
		$total_cuti = "12";
		$cuti_bersama = "2";
		$jumlah_cuti_now = "10";
		// $request_cuti = "5";

		$dataFiltered = DB::table('tb_cuti')
			->select(
				"tb_cuti.id_cuti",
				"tb_cuti.nik"
			)->where('status','=','v');

		$dataLeavingPermitCount = DB::table('tb_cuti_detail')
			->select(
				"tb_cuti_filtered.nik", 
				DB::raw("COUNT(`tb_cuti_detail`.`date_off`) AS `counted`")
			)->joinSub($dataFiltered,'tb_cuti_filtered',function($join){
				$join->on('tb_cuti_filtered.id_cuti','=','tb_cuti_detail.id_cuti');
			})->whereRaw("`tb_cuti_detail`.`date_off` BETWEEN '2021-01-01' AND '2021-12-31'")
			->groupBy('nik');

		$dataLeavingPermit = User::select(
				'users.nik',
				DB::raw('`roles`.`name` AS `role`'),
				'users.name',
				'users.date_of_entry',
				DB::raw($jumlah_cuti . ' AS `bersih_cuti_' . date('Y', strtotime("-1 year")) . '`'),
				DB::raw('`users`.`cuti2` AS `sisah_cuti_' . date('Y', strtotime("-1 year")) . '`'),
				DB::raw($total_cuti . ' AS `total_cuti_' . date('Y') . '`'),
				DB::raw($cuti_bersama . ' AS `cuti_bersama_' . date('Y') . '`'),
				DB::raw($jumlah_cuti_now . ' AS `bersih_cuti_' . date('Y') . '`'),
				DB::raw("IFNULL(`cuti_requested`.`counted`, 0) AS `request_cuti_" . date('Y') . "`"),
				// DB::raw($request_cuti . ' AS `request_cuti_' . date('Y') . '`')
			)->join('role_user','role_user.user_id','=','users.nik')
			->join('roles','role_user.role_id','=','roles.id')
			->leftJoinSub($dataLeavingPermitCount,'cuti_requested',function($join){
				$join->on('cuti_requested.nik','=','users.nik');
			})->orderBy('roles.index','DESC')
			->orderBy('users.name','DESC')
			->where('status_karyawan','<>','dummy')
			// ->where('nik','=',1170498100)
			// ->limit(1)
			->get();

		$cuti_processed = DB::table(function($query){
				$query->from('tb_cuti')
					->select(
						DB::raw("RIGHT(`tb_cuti_detail`.`date_off`,2) AS `date_off`"),
						"tb_cuti.nik",
						DB::raw("MONTH(`tb_cuti_detail`.`date_off`) AS `month`")
					)
					->join("tb_cuti_detail","tb_cuti_detail.id_cuti","=","tb_cuti.id_cuti")
					->where("tb_cuti.status","=","v")
					// ->where("tb_cuti.nik","=",1170498100)
					->whereRaw("`tb_cuti_detail`.`date_off` BETWEEN '2021-01-01' AND '2021-12-31'");
			}, 'tb_cuti_counted')
			->select('tb_cuti_counted.nik','tb_cuti_counted.month')
			->selectRaw("GROUP_CONCAT(`tb_cuti_counted`.`date_off`) AS `summarize`")
			->selectRaw("COUNT(*) AS `counted`")
			->groupBy("tb_cuti_counted.nik","tb_cuti_counted.month");

		$cuti_summary = DB::table(function($query){
				$query->from('month')
				->select(
					'users.nik',
					'month.id',
				)->leftJoin('users','month.id','<>','users.nik')
				// ->where("users.nik","=",1170498100)
				->where('users.status_karyawan','<>','dummy');
			},'users_filtered')
			->leftJoinSub($cuti_processed, 'cuti_processed', function ($join) {
				$join->on('cuti_processed.nik', '=', 'users_filtered.nik')
					->on('cuti_processed.month', '=', 'users_filtered.id');
			})
			->select(
				"users_filtered.nik",
				DB::raw("`users_filtered`.`id` AS `month`"),
				"cuti_processed.summarize",
				"cuti_processed.counted",
			)->get()->sortBy('month')->groupBy('nik');
			// return $cuti_summary;


		// return $dataLeavingPermit;

		$itemStyle = $normalStyle;
		// $itemStyle['font']['bold'] = true;
		$itemStyle['fill'] = ['fillType' => Fill::FILL_SOLID, 'startColor' => ["argb" => "FFFFFE9F"]];
		$itemStyle['borders'] = ['allBorders' => ['borderStyle' => Border::BORDER_THIN]];
		// echo "<pre>";
		$dataLeavingPermit->map(function($item,$key) use ($summarySheet,$itemStyle,$cuti_summary){
			$item_filtered = array_values($item->toArray());
			unset($item_filtered[0]);
			unset($item_filtered[1]);
			// print_r($item_filtered);
			// print_r(array_merge(array_merge([$key + 1],array_values($item_filtered)),$cuti_summary[$item->nik]->pluck('summarize')->toArray()));
			$summarySheet->fromArray(array_merge(array_merge([$key + 1],array_values($item_filtered)),$cuti_summary[$item->nik]->pluck('summarize')->toArray()),NULL,'A' . ($key + 3));
			$item->cuti_summary = $cuti_summary[$item->nik]->pluck('summarize');
			$summarySheet->getStyle('A' . ($key + 3) . ':Y' . ($key + 3))->applyFromArray($itemStyle);
			$summarySheet->getStyle('A' . ($key + 3) . ':Y' . ($key + 3))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
			$summarySheet->getStyle('C' . ($key + 3) . ':Y' . ($key + 3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$summarySheet->getStyle('C' . ($key + 3) . ':Y' . ($key + 3))->getAlignment()->setWrapText(true);
			$summarySheet->getStyle('C' . ($key + 3) . ':Y' . ($key + 3))->getFont()->setBold(true);
			$summarySheet->getStyle('J' . ($key + 3) . ':U' . ($key + 3))->getFont()->getColor()->setARGB("FFF32229");

			$summarySheet->getStyle('G' . ($key + 3))->getFont()->getColor()->setARGB("FFF32229");

		});
		// echo "</pre>";

		// return ;
		// return $dataLeavingPermit;

		$summarySheet->getColumnDimension('A')->setAutoSize(true);
		$summarySheet->getColumnDimension('B')->setAutoSize(true);
		$summarySheet->getColumnDimension('C')->setWidth(8);
		$summarySheet->getColumnDimension('D')->setWidth(8);
		$summarySheet->getColumnDimension('E')->setWidth(8);
		$summarySheet->getColumnDimension('F')->setWidth(8);
		$summarySheet->getColumnDimension('G')->setWidth(8);
		$summarySheet->getColumnDimension('H')->setWidth(8);
		$summarySheet->getColumnDimension('I')->setWidth(8);
		$summarySheet->getColumnDimension('J')->setWidth(8);
		$summarySheet->getColumnDimension('K')->setWidth(8);
		$summarySheet->getColumnDimension('L')->setWidth(8);
		$summarySheet->getColumnDimension('M')->setWidth(8);
		$summarySheet->getColumnDimension('N')->setWidth(8);
		$summarySheet->getColumnDimension('O')->setWidth(8);
		$summarySheet->getColumnDimension('P')->setWidth(8);
		$summarySheet->getColumnDimension('Q')->setWidth(8);
		$summarySheet->getColumnDimension('R')->setWidth(8);
		$summarySheet->getColumnDimension('S')->setWidth(8);
		$summarySheet->getColumnDimension('T')->setWidth(8);
		$summarySheet->getColumnDimension('U')->setWidth(8);
		$summarySheet->getColumnDimension('V')->setWidth(8);
		$summarySheet->getColumnDimension('W')->setWidth(8);
		$summarySheet->getColumnDimension('X')->setWidth(8);
		$summarySheet->getColumnDimension('Y')->setWidth(8);

		// $dataPresenceIndividual = $dataPresence->groupBy('name');

		// $indexSheet = 0;
		// foreach ($dataPresenceIndividual as $key => $item) {
		//   $spreadsheet->addSheet(new Worksheet($spreadsheet,$key));
		//   $detailSheet = $spreadsheet->setActiveSheetIndex($indexSheet + 1);

		//   $detailSheet->getStyle('A1:J1')->applyFromArray($titleStyle);
		//   $detailSheet->setCellValue('A1','Presence Report ' . $key);
		//   $detailSheet->mergeCells('A1:J1');

		//   $headerContent = ["No", "Nik", "Name", "Date","Schedule","Check-In","Check-Out","Condition","Valid","Reason"];
		//   $detailSheet->getStyle('A2:J2')->applyFromArray($headerStyle);
		//   $detailSheet->fromArray($headerContent,NULL,'A2');

		//   foreach ($item as $key => $eachPresence) {
		//     $detailSheet->fromArray(array_merge([$key + 1],array_values(get_object_vars($eachPresence))),NULL,'A' . ($key + 3));
		//   }
		//   $detailSheet->getColumnDimension('A')->setAutoSize(true);
		//   $detailSheet->getColumnDimension('B')->setAutoSize(true);
		//   $detailSheet->getColumnDimension('C')->setAutoSize(true);
		//   $detailSheet->getColumnDimension('D')->setAutoSize(true);
		//   $detailSheet->getColumnDimension('E')->setAutoSize(true);
		//   $detailSheet->getColumnDimension('F')->setAutoSize(true);
		//   $detailSheet->getColumnDimension('G')->setAutoSize(true);
		//   $detailSheet->getColumnDimension('H')->setAutoSize(true);
		//   $detailSheet->getColumnDimension('I')->setAutoSize(true);
		//   $detailSheet->getColumnDimension('J')->setAutoSize(true);
		//   $indexSheet = $indexSheet + 1;
		// }

		$spreadsheet->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="asdfadfasd.xlsx"');
		header('Cache-Control: max-age=0');
		
		$writer = new Xlsx($spreadsheet);
		return $writer->save("php://output");
		// return "adfasdass";
	}

	public function testRole() {
		return $this->RoleDynamic('bookmark');
	}

	public function testBladeNew() {
		return view('testBladeNew')->with(['initView' => $this->initMenuBase()]);
	}

	public function checkIn(Request $req) {
		$history = new PresenceHistory();

		if (isset(Auth::User()->nik)) {
			$req->nik = Auth::User()->nik;
		}

		$setting_schedule = User::with('presence_setting')
			->where('nik',$req->nik)
			->first()
			->presence_setting;

		if (PresenceShiftingUser::where('nik',$req->nik)->exists()){
			$setting_schedule = $this->makeShiftingSchedule($req->nik,"15");
		}

		$history->nik = $req->nik;
		$history->presence_setting = $setting_schedule->id;
		$history->presence_schedule = $setting_schedule->setting_on_time;
		$history->presence_actual = $req->presence_actual;
		$history->presence_location = 1;
		$history->presence_condition = $this->checkPresenceCondition($req->presence_actual,$setting_schedule);
		$history->presence_type = "Check-In";

		// return $history;
		// return $setting_schedule;

		$history->save();
	}

	public function checkOut(Request $req) {
		$history = new PresenceHistory();
		if (isset(Auth::User()->nik)) {
			$req->nik = Auth::User()->nik;
		}

		$setting_schedule = User::with('presence_setting')
			->where('nik',$req->nik)
			->first()
			->presence_setting;

		if (PresenceShiftingUser::where('nik',$req->nik)->exists()){
			$setting_schedule = $this->makeShiftingSchedule($req->nik,"15");
		}

		$history->nik = $req->nik;
		$history->presence_setting = $setting_schedule->id;
		$history->presence_schedule = $setting_schedule->setting_check_out;
		$history->presence_actual = $req->presence_actual;
		$history->presence_location = 1;
		$history->presence_condition = "-";
		$history->presence_type = "Check-Out";

		$history->save();
		}

	public function checkPresenceCondition($presenceActual,$settingSchedule){
		$actual = new DateTime($presenceActual);
		if ($actual->diff(new DateTime($settingSchedule->setting_on_time))->format('%R') == '+') {
			return "On-Time";
		} else if ($actual->diff(new DateTime($settingSchedule->setting_on_time))->format('%R') == '-' && $actual->diff(new DateTime($settingSchedule->setting_injury_time))->format('%R') == '+') {
			return "Injury-Time";
		} else {
			return "Late";
		}
	}

	public function makeShiftingSchedule($nik,$span){
		$shiftingSchedule = PresenceShifting::where('nik',$nik)
			->where('tanggal_shift',date('Y-m-d'))
			->first();

		$start = substr($shiftingSchedule->start, 11,8);
		$shiftingSchedule->setting_on_time = $start;
		$shiftingSchedule->setting_injury_time = date("H:i:s",strtotime('+' . $span . ' minutes',strtotime($start)));
		$shiftingSchedule->setting_late = date("H:i:s",strtotime('+' . $span . ' minutes +1 seconds',strtotime($start)));
		$shiftingSchedule->setting_check_out = substr($shiftingSchedule->end, 11,8);

		return $shiftingSchedule;
	}

	public function modifyUserShifting(Request $request){
		$date = date('Y-m-d h:i:s', time());

		if($request->on_project == "0"){
			DB::table('presence__shifting_user')
				->where('nik','=',$request->id_user)
				->delete();
			return redirect('presence/shifting')->with('message', "Delete User " . " success.");
		} else {
			if (DB::table('presence__shifting_user')->where('nik',$request->id_user)->where('shifting_project',$request->on_project)->get() == NULL){
				DB::table('presence__shifting_user')
				->insert([
						'nik' => $request->id_user,
						'shifting_project' => $request->on_project,
					]);
			} else {
				DB::table('presence__shifting_user')
					->where('nik','=',$request->id_user)
					->delete();

				DB::table('presence__shifting_user')
					->insert([
						'nik' => $request->id_user,
						'shifting_project' => $request->on_project,
					]);
			}
			return redirect('presence/shifting')->with('message', "Add User " . " success.");
		}
	}

	public function testRequestChange(){
		$mail = new EmailChangeNominal(collect([
                    "to" => "Aurellia Quartas Geraldine",
                    "requestor" => "Timurta Bagus Prapditya Laksana",
                    "lead_id" => "UIP2220601",
                    "project" => "Upgrade Server AMR dan Rapsodi yang sudah Obsolete di Kantor Induk UIP2B",
                    "customer" => "PLN UIP2B",
                    "created_at" => "2022-06-08",
                    "nominal_before" => "Rp. 1.500.000.000",
                    "nominal_after" => "Rp. 1.650.000.000",
					"reason" => "Adanya pemecahan PO dimana Server ARM diganti dengan PO nomor A1, dan Rapsodi diganti dengan PO A2 dengan pembayaran yang berbeda",
					"url" =>  url("/requestChange?id_requestChange=2")
                ])
            );

		return $mail;
	}

	public function getDataIcon(Request $request){
		// $jsonFilePath = 'app'; // Path to the JSON file within the storage directory

	 //    // Check if the file exists
	 //    if (Storage::exists($jsonFilePath)) {
	 //        $jsonData = Storage::get($jsonFilePath);
	 //        $decodedData = json_decode($jsonData, true);

	 //        return response()->json($decodedData);
	 //    } else {
	 //        return response()->json(['error' => 'File not found'], 404);
	 //    }

		$directoryPath = 'app'; // Replace with the name of the directory you want to list

		if (Storage::exists($directoryPath)) {
		    $files = Storage::files($directoryPath);
		    $directories = Storage::directories($directoryPath);

		    // List files
		    echo "Files in $directoryPath:<br>";
		    foreach ($files as $file) {
		        echo $file . "<br>";
		    }

		    // List subdirectories
		    echo "<br>Subdirectories in $directoryPath:<br>";
		    foreach ($directories as $dir) {
		        echo $dir . "<br>";
		    }
		} else {
		    echo "Directory $directoryPath does not exist.";
		}
	}

    public function testSbePdf(Request $request)
    {
        $id_sbe = $request->id_sbe;

        $getFunction = SbeConfig::where('status','Choosed')->where('id_sbe',$id_sbe)->orderByRaw('FIELD(project_type, "Supply Only", "Implementation", "Maintenance")')->get()->makeHidden(['detail_config','detail_all_config_choosed'])->groupby('project_type');

        $getPresales = DB::table('tb_sbe')->join('sales_solution_design','sales_solution_design.lead_id','tb_sbe.lead_id')->where('id',$id_sbe)->first();

        $getAll = DB::table('tb_sbe_config')->join('tb_sbe','tb_sbe.id','tb_sbe_config.id_sbe')->join('sales_lead_register','sales_lead_register.lead_id','tb_sbe.lead_id')->join('users','users.nik','sales_lead_register.nik')->join('tb_contact','tb_contact.id_customer','sales_lead_register.id_customer')->select('tb_sbe.lead_id','users.name as owner','project_location','estimated_running','duration','opp_name','tb_sbe.nominal as grand_total','customer_legal_name')->where('id_sbe',$id_sbe)->first();

        // $getNominal = SBE::where('id',$request->id_sbe)->first()->detail_config_nominal;

        $getNominalConfig = DB::table('tb_sbe')->join('tb_sbe_config','tb_sbe_config.id_sbe','tb_sbe.id')->join('tb_sbe_detail_config','tb_sbe_detail_config.id_config_sbe','tb_sbe_config.id')->select('item','detail_item','total_nominal','qty','price','manpower')->where('tb_sbe.id',$id_sbe)->where('tb_sbe_config.status','Choosed')->orderBy('item','asc')->distinct()->get();

        $getNominal = 0;
            foreach($getNominalConfig as $key_point => $valueSumPoint){
            $getNominal += $valueSumPoint->total_nominal;
        }

        $getIdConfigSbe = DB::table('tb_sbe_config')->join('tb_sbe_detail_config','tb_sbe_detail_config.id_config_sbe','tb_sbe_config.id')->select('id_sbe','id_config_sbe')->where('tb_sbe_config.status','Choosed')->where('id_sbe',$id_sbe)->get();

        $getConfig = SbeConfig::where('status','Choosed')->where('id_sbe',$id_sbe)->orderByRaw('FIELD(project_type, "Supply Only", "Implementation", "Maintenance")')->get()->makeHidden(['detail_config'])->groupby('project_type');



        $user = SbeActivity::where('id_sbe',$id_sbe)->first()->operator;

        $cek_role = DB::table('role_user')->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->select('name', 'roles.group','user_id')->where('user_id', $user)->first();

        $getSign = User::join('role_user', 'role_user.user_id', '=', 'users.nik')
                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->select(
                        'users.name', 
                        'roles.name as position', 
                        'roles.group as group',
                        'users.ttd as ttd_digital',
                        'users.email',
                        'users.avatar'
                    )
                    ->where('users.id_company', '1')
                    ->where('users.status_karyawan', '!=', 'dummy');

        if ($cek_role->name == 'Technology Alliance') {
            $getSign = $getSign->whereRaw("(`users`.`nik` = '" . $getPresales->nik_ta . "' OR `roles`.`name` = 'VP Product Management & Development Solution')")
            ->orderByRaw('FIELD(position, "Technology Alliance","VP Product Management & Development Solution","Presales")')->take(2)
            ->get();
        }else {
            $getSign = $getSign->whereRaw("(`users`.`nik` = '" . $getPresales->nik . "' OR `roles`.`name` = 'VP Product Management & Development Solution')")
            ->orderByRaw('FIELD(position, "Presales","System Designer","VP Product Management & Development Solution")')
            ->get();
        }  

        collect(["data"=>$getAll,"function"=>$getFunction,"config"=>$getConfig,"sign"=>$getSign,"grand_total" => $getNominal]);

        $pdf = PDF::loadView('solution.PDF.sbePdf', compact('getAll','getFunction','getConfig','getSign','getNominal'));
        $fileName = 'SBE ' . $getAll->lead_id . '.pdf';

        return $pdf->stream($fileName);
        // return $pdf->output();
    }

    public function saveMode(Request $request)
    {
        $updateMode          = User::where('nik',Auth::User()->nik)->first();
        $updateMode->is_mode = $request->mode;
        $updateMode->update();
    }

    //testtttt
    //testttt
    //testttt
    //tesssttt

}
