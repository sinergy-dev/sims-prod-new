<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Barang;
use Auth;
use App\Cuti;
use App\Task;
use App\User;
use App\CutiDetil;
// use App\Notifications\CutiKaryawan;
use App\Mail\CutiKaryawan;
use Mail;
// use Notification;
use Excel;
use GuzzleHttp\Client;
use App\Messenger;
use App\DetailMessenger;
use App\PublicHolidayAdjustment;
use PDF;
use Log;

use DatePeriod;
use DateInterval;
use DateTime;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Carbon\Carbon;

class HRGAController extends Controller
{
    ////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
    	$nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position; 


        if($ter != null){
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name', 'tb_contact.brand_name','sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho')
                ->where('id_territory', $ter)
                ->get();
        } elseif($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_solution_design.nik', 'sales_lead_register.status_sho')
                ->where('sales_solution_design.nik', $nik)
                ->get();
        }elseif($div == 'PMO' && $pos == 'MANAGER') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho')
                ->where('sales_lead_register.result','WIN')
                ->get();
        }elseif($div == 'PMO' && $pos == 'STAFF') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('tb_pmo','sales_lead_register.lead_id','=','tb_pmo.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','tb_pmo.pmo_nik')
                ->where('sales_lead_register.result','WIN')
                ->where('tb_pmo.pmo_nik',$nik)
                ->get();
        }
        elseif($div == 'FINANCE' && $pos == 'MANAGER') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name','sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.nik')
                ->where('sales_lead_register.result','WIN')
                ->get();
        }
        elseif($div == 'FINANCE' && $pos == 'STAFF') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name','sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.nik')
                ->where('sales_lead_register.result','WIN')
                ->get();
        }
        elseif($pos == 'ENGINEER MANAGER') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name','sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.nik','sales_lead_register.status_engineer')
                ->where('sales_lead_register.result','WIN')
                ->where('sales_lead_register.status_sho','PMO')
                ->get();
        }
        elseif($pos == 'ENGINEER STAFF') {
            $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->join('tb_engineer','sales_lead_register.lead_id','=','tb_engineer.lead_id')
                ->select('sales_lead_register.lead_id','tb_contact.customer_legal_name', 'tb_contact.brand_name', 'sales_lead_register.opp_name','sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.nik','sales_lead_register.status_engineer')
                ->where('sales_lead_register.result','WIN')
                 ->where('tb_engineer.nik',$nik)
                ->get();
        }
        else {
              $lead = DB::table('sales_lead_register')
                ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                ->join('tb_contact', 'sales_lead_register.id_customer', '=', 'tb_contact.id_customer')
                ->select('sales_lead_register.lead_id', 'tb_contact.id_customer', 'tb_contact.code', 'sales_lead_register.opp_name','tb_contact.customer_legal_name', 'tb_contact.brand_name',
                'sales_lead_register.created_at', 'sales_lead_register.amount', 'users.name', 'sales_lead_register.result', 'sales_lead_register.status_sho','sales_lead_register.nik')
                ->get();
        }

        /*  $presales = DB::table('sales_solution_design')
                    ->join('users','users.nik','=','sales_solution_design.nik')
                    ->select('sales_solution_design.lead_id','sales_solution_design.nik','sales_solution_design.assessment','sales_solution_design.pov','sales_solution_design.pd','sales_solution_design.pb','sales_solution_design.priority','sales_solution_design.project_size','users.name','sales_solution_design.status', 'sales_solution_design.assessment_date', 'sales_solution_design.pd_date', 'sales_solution_design.pov_date')*/
        if ($ter != null) {
            $total_ter = DB::table("sales_lead_register")
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->where('id_territory', $ter)
                        ->sum('amount');
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $total_ter = DB::table("sales_lead_register")
                        ->join('users', 'users.nik', '=', 'sales_lead_register.nik')
                        ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
                        ->where('sales_solution_design.nik', $nik)
                        ->sum('amount');
        }else{
            $total_ter = DB::table("sales_lead_register")
                        ->sum('amount');
        }

        if ($ter != null) {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notif = DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik')
            ->where('result','OPEN')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }else{
             $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'MANAGER') {
            $notifOpen= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'STAFF') {
            $notifOpen= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'MANAGER') {
            $notifsd= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','SD')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'STAFF') {
            $notifsd= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','SD')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'MANAGER') {
            $notiftp= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','TP')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'STAFF') {
            $notiftp= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','TP')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }

        $datas = Barang::orderBy('id_item', 'DESC')->paginate(5);

        $tasks = DB::table('tb_task')
                ->select('id_task','task_name','description','task_date')
                ->first();

        return view('HRGA/hrga', compact('lead', 'total_ter','notif','notifOpen','notifsd','notiftp','id_pro','datas','tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_delivery_person()
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position; 

        

         if ($ter != null) {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notif = DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik')
            ->where('result','OPEN')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }else{
             $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'MANAGER') {
            $notifOpen= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'STAFF') {
            $notifOpen= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'MANAGER') {
            $notifsd= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','SD')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'STAFF') {
            $notifsd= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','SD')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'MANAGER') {
            $notiftp= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','TP')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'STAFF') {
            $notiftp= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','TP')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }
        

        $data = DB::table('tb_messenger')
                ->join('users','users.nik','=','tb_messenger.nik')
                ->select('book_date','activity','status','pic_name','pic_contact','note','book_time','lokasi','item','users.nik','users.name')
                ->get();

        return view('delivery/delivery_person',compact('notif','notifOpen','notifsd','notiftp','data'));
    }

    public function getDataMessenger(Request $request){

        if ($request->id == 'done') {
             return array("data" => DB::table('tb_messenger')
                ->join('users as u1','u1.nik','=','tb_messenger.nik')
                ->join('users as u2','u2.nik','=','tb_messenger.nik_request')
                ->select('book_date','activity','status','pic_name','pic_contact','note','book_time','lokasi','item','u1.nik','nik_request','u1.name as name1','id_messenger','u2.name as name2','u2.id_division')
                ->where('status','done')
                ->get());
        }else if ($request->id == 'requested') {
             return array("data" => DB::table('tb_messenger')
                ->join('users as u1','u1.nik','=','tb_messenger.nik')
                ->join('users as u2','u2.nik','=','tb_messenger.nik_request')
                ->select('book_date','activity','status','pic_name','pic_contact','note','book_time','lokasi','item','u1.nik','nik_request','u1.name as name1','id_messenger','u2.name as name2','u2.id_division')
                ->where('book_date','!=',date("Y-m-d"))
                ->get());
        }else if ($request->id == 'today') {
             return array("data" => DB::table('tb_messenger')
                ->join('users as u1','u1.nik','=','tb_messenger.nik')
                ->join('users as u2','u2.nik','=','tb_messenger.nik_request')
                ->select('book_date','activity','status','pic_name','pic_contact','note','book_time','lokasi','item','u1.nik','nik_request','u1.name as name1','id_messenger','u2.name as name2','u2.id_division')
                ->where('book_date',date('Y-m-d'))
                ->where('tb_messenger.status','!=','done')
                ->get());
        }

        return array("data" => DB::table('tb_messenger')
                ->join('users as u1','u1.nik','=','tb_messenger.nik')
                ->join('users as u2','u2.nik','=','tb_messenger.nik_request')
                ->select('book_date','activity','status','pic_name','pic_contact','note','book_time','lokasi','item','u1.nik','nik_request','u1.name as name1','id_messenger','u2.name as name2','u2.id_division')
                ->where('book_date',date('Y-m-d'))
                ->where('tb_messenger.status','!=','done')
                ->get());
        
    }

    public function detail_delivery_person($id_messenger)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position; 

         if ($ter != null) {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notif = DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik')
            ->where('result','OPEN')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }else{
             $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'MANAGER') {
            $notifOpen= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'STAFF') {
            $notifOpen= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'MANAGER') {
            $notifsd= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','SD')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'STAFF') {
            $notifsd= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','SD')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'MANAGER') {
            $notiftp= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','TP')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'STAFF') {
            $notiftp= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','TP')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }

        

        $datas = DB::table('tb_messenger')
                ->join('users as u1','u1.nik','=','tb_messenger.nik')
                ->join('users as u2','u2.nik','=','tb_messenger.nik_request')
                ->join('tb_detail_messenger','tb_detail_messenger.id_messenger','=','tb_messenger.id_messenger')
                ->select('book_date','activity','pic_name','pic_contact','tb_messenger.note','book_time','lokasi','item','u1.nik','u1.name as name1','u2.name as name2','finish_time','tb_detail_messenger.note as notes','tb_messenger.status as statusm','tb_detail_messenger.status as statusd','tb_messenger.id_messenger')
                ->where('tb_messenger.id_messenger',$id_messenger)
                ->orderBy('tb_detail_messenger.created_at','desc')
                ->first();

        $data = DB::table('tb_messenger')
                ->join('users as u1','u1.nik','=','tb_messenger.nik')
                ->join('users as u2','u2.nik','=','tb_messenger.nik_request')
                ->join('tb_detail_messenger','tb_detail_messenger.id_messenger','=','tb_messenger.id_messenger')
                ->select('book_date','activity','pic_name','pic_contact','tb_messenger.note','book_time','lokasi','item','u1.nik','u1.name as name1','u2.name as name2','finish_time','tb_detail_messenger.note as notes','tb_messenger.status as statusm','tb_detail_messenger.status as statusd','tb_messenger.id_messenger')
                ->where('tb_messenger.id_messenger',$id_messenger)
                ->get();

        return view('delivery/detail_delivery_person',compact('notif','notifOpen','notifsd','notiftp','data','datas'));
    }

    public function getDateMessenger(){
        $getAllCutiDate = DB::table('tb_cuti_detail')
            ->select('date_off')
            ->whereIn('id_cuti',function($query){
                $query->select('id_cuti')
                    ->from('tb_cuti')
                    ->where('nik','=','1171290010')
                    ->orwhere('nik','=','1180400040');
            })
            ->pluck('date_off');

        return collect(["allCutiDate" => $getAllCutiDate]);
    }

    public function getMessenger(Request $request){
        $cek = DB::table('users')
            ->join("tb_messenger","tb_messenger.nik","=","users.nik")
            ->select('name','book_date',DB::raw('COUNT(`tb_messenger`.`book_date`) AS "book_date"'),'users.nik')
            ->whereIn('users.nik',function($query){
                $query->select('users.nik')
                    ->from('tb_messenger');
            })
            ->groupby("users.nik")
            ->groupby("book_date")
            ->where("book_date",$request->tanggal)
            ->get();

        $cek2 = array(DB::table('users')
            ->select('name','nik')
            ->where('id_position','courier')
            ->whereNotIn('nik',function($query){
                $query->select('nik')
                    ->from('tb_messenger');
            })
            ->get());

        $getAllCutiDate = DB::table('tb_cuti_detail')
            ->select('date_off')
            ->whereIn('id_cuti',function($query){
                $query->select('id_cuti')
                    ->from('tb_cuti')
                    ->where('nik','=','1171290010')
                    ->orwhere('nik','=','1180400040');
            })
            ->pluck('date_off');   

        $cutiAll = collect(["allCutiDate" => $getAllCutiDate]);     

        $getOldData = DB::table('tb_messenger')
                ->join('users','users.nik','=','tb_messenger.nik')
                ->select('book_date','activity','status','pic_name','pic_contact','note','book_time','lokasi','item','users.nik','users.name','id_messenger')
                ->where('id_messenger',$request->id_messenger)
                ->get();


        $messenger = DB::table('users')
            ->select('name','nik')
            ->where('id_position','courier')
            ->get();

        if ($cek->isEmpty()) {
            return array($messenger,"courier",$cutiAll,$getOldData);
        }else{
            return array($cek,$cek2,$cutiAll,$getOldData);
        }
       
    }

    public function store_messenger(Request $request){

        $store = new Messenger();
        $format_start_s     = strtotime($request['book_date']);
        $store->book_date   = date("Y-m-d",$format_start_s);
        $store->activity    = $request['activity'];
        $store->status      = 'new';
        $store->pic_name    = $request['pic_name'];
        $store->pic_contact = $request['pic_contact'];
        $store->note        = $request['note'];
        $store->book_time   = $request['book_time'];
        $store->lokasi      = $request['lokasi'];
        $store->item        = $request['items'];
        $store->nik         = $request['messenger_name'];
        $store->nik_request = Auth::User()->nik;
        $store->save();

        $store_detail = new DetailMessenger();
        $store_detail->id_messenger = $store->id_messenger;
        $store_detail->finish_time  = $request['book_time'];
        $store_detail->note         = 'Permintaan plan schedule messenger berhasil di buat';
        $store_detail->status       = 'new';
        $store_detail->save();

        return redirect()->back();

    }

    public function update_messenger(Request $request){

        $update = Messenger::where('id_messenger',$request->id_messenger)->first();
        $format_start_s      = strtotime($request['book_date_edit']);
        $update->book_date   = date("Y-m-d",$format_start_s);
        $update->activity    = $request['activity_edit'];
        $update->status      = 'edited';
        $update->pic_name    = $request['pic_name_edit'];
        $update->pic_contact = $request['pic_contact_edit'];
        $update->note        = $request['note_edit'];
        $update->book_time   = $request['book_time_edit'];
        $update->lokasi      = $request['lokasi_edit'];
        $update->item        = $request['items_edit'];
        $update->nik         = $request['messenger_name_edit'];
        $update->update();

        $update_detail = new DetailMessenger();
        $update_detail->id_messenger = $update->id_messenger;
        $update_detail->status       = "edited";
        $update_detail->note         = 'Terjadi perubahan plan schedule messenger';
        $update_detail->finish_time  = $request['book_time_edit'];
        $update_detail->save();

        return redirect()->back();
    }

    public function update_progress(Request $request){
        if ($request['btn-submit'] == 'done') {
            $update_detail = new DetailMessenger();
            $update_detail->id_messenger = $request->id_messenger;
            $update_detail->status       = "done";
            $update_detail->note         = $request['note_edit'];
            $update_detail->finish_time  = date("H:i:s");
            $update_detail->save();

            $update = Messenger::where('id_messenger',$request->id_messenger)->first();
            $update->status      = 'done';
            $update->update();
        }else{
            $update_detail = new DetailMessenger();
            $update_detail->id_messenger = $request->id_messenger;
            $update_detail->status       = "progress";
            $update_detail->note         = $request['note_edit'];
            $update_detail->finish_time  = date("H:i:s");
            $update_detail->save();

            $update = Messenger::where('id_messenger',$request->id_messenger)->first();
            $update->status      = 'onroad';
            $update->update();
        }
        

        return redirect()->back();
    }

    public function delete_messenger($id_messenger){
        $hapus = Messenger::find($id_messenger);
        $hapus->delete();

        return redirect()->back();
    }

    public function show_cuti(Request $request)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $cek_role = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.name','roles.name as name_role')->where('user_id',$nik)->first();

        $cek = User::join('tb_cuti','tb_cuti.nik','=','users.nik','left')
                ->select('users.nik','cuti','cuti2','status_karyawan','status')->where('users.nik',$nik)->first();

        if ($cek->status == null) {
            $cek_cuti = User::select('users.nik','status_karyawan')->where('users.nik',$nik)->first();
        }else{
            $cek_cuti = User::join('tb_cuti','tb_cuti.nik','=','users.nik','left')
                ->select('users.nik','cuti','cuti2','status_karyawan','status')->where('users.nik',$nik)->orderBy('tb_cuti.id_cuti','desc')->first();
        }

        $total_cuti = $cek->cuti + $cek->cuti2;

        $year = date('Y');

        $cuti_index = '';
        $cuti_list = '';
        $detail_cuti = '';

        if ($ter != NULL) {
            if($div == 'SALES' && $pos == 'MANAGER'){
                $cuti = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
                ->orderBy('tb_cuti.date_req','DESC')
                ->where('id_territory', $ter)
                ->groupby('id_cuti')
                ->get();


                $cuti2 = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory')
                    ->orderBy('date_req','DESC')
                    ->groupby('tb_cuti.id_cuti')
                    ->where('id_territory', $ter)
                    
                    ->groupby('nik')
                    ->get();
            } elseif($div == 'TECHNICAL' && $pos == 'ENGINEER MANAGER' && $ter == 'DPG'){
                $cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
                    ->groupby('id_cuti')
                    ->orderBy('tb_cuti.date_req','DESC')
                    ->where('users.id_division','TECHNICAL')
                    ->where('users.id_territory','DPG')
                    ->get();

                $cuti2 = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory')
                    ->orderBy('date_req','DESC')
                    ->groupby('tb_cuti.id_cuti')
                    ->where('users.id_division','TECHNICAL')
                    ->where('users.id_territory','DPG')
                    
                    ->groupby('nik')
                    ->get();
            } elseif($div == 'BCD' && $ter == 'OPERATION' && $pos == 'MANAGER'){
                $cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at') 
                    ->where('users.id_division','BCD')
                    ->orderBy('tb_cuti.date_req','DESC')
                    ->groupby('id_cuti')
                    ->orderBy('id_cuti','desc')
                    ->get();

                $cuti2 = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory')
                    ->orderBy('date_req','DESC')
                    ->groupby('tb_cuti.id_cuti')
                    ->where('users.id_division','BCD')
                    ->groupby('nik')
                    ->get();

                $detail_cuti = DB::table('tb_cuti')
                            ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                            ->select('date_req','tb_cuti_detail.date_off','tb_cuti_detail.id_cuti')
                            ->where('tb_cuti_detail.id_cuti')
                            ->get();
            } elseif ($div == 'PMO' && $ter == 'OPERATION' && $pos == 'MANAGER') {
                $cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at') 
                    ->where('users.id_division','PMO')
                    ->orderBy('tb_cuti.date_req','DESC')
                    ->groupby('id_cuti')
                    ->orderBy('id_cuti','desc')
                    ->get();


                $cuti2 = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory')
                    ->orderBy('date_req','DESC')
                    ->groupby('tb_cuti.id_cuti')
                    ->where('users.id_division','PMO')
                    
                    ->groupby('nik')
                    ->get();
            } elseif ($div == 'MSM' && $ter == 'OPERATION' && $pos == 'MANAGER') {
                $cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at') 
                    ->where('users.id_division','MSM')
                    ->orderBy('tb_cuti.date_req','DESC')
                    ->groupby('id_cuti')
                    ->orderBy('id_cuti','desc')
                    ->get();


                $cuti2 = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory')
                    ->orderBy('date_req','DESC')
                    ->groupby('tb_cuti.id_cuti')
                    ->where('users.id_division','MSM')
                    
                    ->groupby('nik')
                    ->get();
            } elseif ($pos == 'OPERATION DIRECTOR') {
                $cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at') 
                    ->where('users.id_position','MANAGER')
                    ->where('users.id_territory','OPERATION')
                    ->orwhere('users.id_position','OPERATION DIRECTOR')
                    ->orwhere('users.id_division','WAREHOUSE')
                    ->orderBy('tb_cuti.date_req','DESC')
                    ->groupby('id_cuti')
                    ->orderBy('id_cuti','desc')
                    ->get();


                $cuti2 = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory')
                    ->orderBy('date_req','DESC')
                    ->groupby('tb_cuti.id_cuti')
                    ->where('users.id_position','MANAGER')
                    ->where('users.id_territory','OPERATION')
                    ->orwhere('users.id_position','OPERATION DIRECTOR')
                    ->orwhere('users.id_division','WAREHOUSE')
                    ->groupby('nik')
                    ->get();
            } elseif($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER'){
                $cuti = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','tb_cuti.pic','tb_cuti.updated_at')
                ->where('users.id_territory','PRESALES')
                ->groupby('id_cuti')
                ->orderBy('id_cuti','desc')
                ->get();


                $cuti2 = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory')
                    ->orderBy('date_req','DESC')
                    ->groupby('tb_cuti.id_cuti')
                    
                    ->where('users.id_territory','PRESALES')
                    ->groupby('nik')
                    ->get();
            } elseif($div == 'FINANCE' && $pos == 'MANAGER'){
                $cuti = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
                ->where('users.id_division','FINANCE')
                ->groupby('id_cuti')
                ->orderBy('id_cuti','desc')
                ->get();


                $cuti2 = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory')
                    ->orderBy('date_req','DESC')
                    ->groupby('tb_cuti.id_cuti')
                    ->where('users.id_division','FINANCE')
                    ->groupby('nik')
                    
                    ->get();
            }else if($cek_role->name_role == 'Chief Operating Officer'){
                $cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
                    // ->where('users.id_division','TECHNICAL')
                    // ->where('users.id_position','MANAGER')
                    // ->orwhere('users.id_position','ENGINEER MANAGER')
                    ->whereRaw("(`users`.`id_division` = 'TECHNICAL' AND `users`.`id_position` = 'MANAGER' OR `users`.`id_position` = 'ENGINEER MANAGER' OR `users`.`id_division` = 'TECHNICAL PRESALES' AND `users`.`id_position` = 'MANAGER' OR `users`.`id_territory` = 'OPERATION' AND `users`.`id_position` = 'MANAGER' OR `users`.`id_position` = 'HR MANAGER')")
                    ->groupby('id_cuti')
                    ->orderBy('id_cuti','desc')
                    ->get();


                $cuti2 = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory')
                    ->where('users.id_division','TECHNICAL')
                    ->where('users.id_position','MANAGER')
                    ->orwhere('users.id_position','ENGINEER MANAGER')
                    ->orwhere('users.id_position','MANAGER')
                    ->orwhere('users.id_division','WAREHOUSE')
                    ->orWhere('users.id_position', 'HR MANAGER')
                    ->orderBy('date_req','DESC')
                    ->groupby('tb_cuti.id_cuti')
                    ->where('tb_cuti.status','n')
                    ->orWhere('tb_cuti.status','R')
                    ->groupby('nik')
                    ->get();
            }else{
                $cuti = DB::table('tb_cuti')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at') 
                ->groupby('id_cuti')
                ->orderBy('tb_cuti.date_req','DESC')
                ->where('users.nik',$nik)
                ->orderBy('id_cuti','desc')
                ->get();

                $cuti2 = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory')
                    ->orderBy('date_req','DESC')
                    ->groupby('tb_cuti.id_cuti')
                    
                    ->where('users.nik',$nik)
                    ->groupby('nik')
                    ->get();

                $detail_cuti = DB::table('tb_cuti')
                            ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                            ->select('date_req','tb_cuti_detail.date_off','tb_cuti_detail.id_cuti')
                            ->where('tb_cuti_detail.id_cuti')
                            ->get();
            }
        }elseif($div == 'TECHNICAL' && $pos == 'MANAGER'){
            $cuti = DB::table('tb_cuti')
            ->join('users','users.nik','=','tb_cuti.nik')
            ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
            ->join('tb_position','tb_position.id_position','=','users.id_position')
            ->join('tb_division','tb_division.id_division','=','users.id_division')
            ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
            // ->where('users.id_division','TECHNICAL')
            // ->where('users.id_position','MANAGER')
            // ->orwhere('users.id_position','ENGINEER MANAGER')
            ->whereRaw("(`users`.`id_division` = 'TECHNICAL' AND `users`.`id_position` = 'MANAGER' OR `users`.`id_position` = 'ENGINEER MANAGER' OR `users`.`id_division` = 'TECHNICAL PRESALES' AND `users`.`id_position` = 'MANAGER' OR `users`.`id_territory` = 'OPERATION' AND `users`.`id_position` = 'MANAGER' OR `users`.`id_position` = 'HR MANAGER')")
            ->groupby('id_cuti')
            ->orderBy('id_cuti','desc')
            ->get();


            $cuti2 = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory')
                ->where('users.id_division','TECHNICAL')
                ->where('users.id_position','MANAGER')
                ->orwhere('users.id_position','ENGINEER MANAGER')
                ->orwhere('users.id_position','MANAGER')
                ->orwhere('users.id_division','WAREHOUSE')
                ->orWhere('users.id_position', 'HR MANAGER')
                ->orderBy('date_req','DESC')
                ->groupby('tb_cuti.id_cuti')
                ->where('tb_cuti.status','n')
                ->orWhere('tb_cuti.status','R')
                ->groupby('nik')
                ->get();
        }elseif($pos == 'STAFF'|| $pos == 'ADMIN' || $pos == 'STAFF GA' || $pos == 'HR STAFF' || $pos == 'STAFF HR'){
        	$cuti = DB::table('tb_cuti')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at') 
                ->groupby('id_cuti')
                ->orderBy('tb_cuti.date_req','DESC')
                ->where('users.nik',$nik)
                ->orderBy('id_cuti','desc')
                ->get();

            $cuti2 = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory')
                ->orderBy('date_req','DESC')
                ->groupby('tb_cuti.id_cuti')
                ->where('tb_cuti.status','n')
                ->orWhere('tb_cuti.status','R')
                ->where('users.nik',$nik)
                ->groupby('nik')
                ->get();
        }elseif($div == 'HR' && $pos == 'HR MANAGER'){
	        $cuti = DB::table('tb_cuti')
	            ->join('users','users.nik','=','tb_cuti.nik')
	            ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
	            ->join('tb_position','tb_position.id_position','=','users.id_position')
	            ->join('tb_division','tb_division.id_division','=','users.id_division')
	            ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
                ->orderBy('date_req','DESC')
	            ->where('tb_cuti.status','v')
                ->orwhere('tb_position.id_position','not like', '%STAFF%')
	            ->groupby('tb_cuti.id_cuti')
	            ->groupby('nik')
	            ->get();

            $cuti2 = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory')
                ->orderBy('date_req','DESC')
                ->groupby('tb_cuti.id_cuti')
                ->where('tb_cuti.status','n')
                ->orWhere('tb_cuti.status','R')
                ->groupby('nik')
                ->get();


	        $cuti_index = DB::table('users')
	            ->join('tb_cuti','tb_cuti.nik','=','users.nik')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
	            ->join('tb_position','tb_position.id_position','=','users.id_position')
	            ->join('tb_division','tb_division.id_division','=','users.id_division')
	            ->select('users.nik','users.date_of_entry','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','users.cuti',DB::raw('COUNT(tb_cuti_detail.id_cuti) as niks'),DB::raw('DATEDIFF(NOW(),date_of_entry) AS date_of_entrys'),'users.email','users.cuti2','users.status_karyawan')
	            ->groupby('tb_cuti.nik')
                ->where('status_karyawan','!=','dummy')
	            ->get();

	        $cuti_list = DB::table('users')
	            ->join('tb_position','tb_position.id_position','=','users.id_position')
	            ->join('tb_division','tb_division.id_division','=','users.id_division')
	            ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','users.cuti','users.date_of_entry',DB::raw('DATEDIFF(NOW(),date_of_entry) AS date_of_entrys'),'users.email','users.cuti2','users.status_karyawan')
                ->where('status_karyawan','!=','dummy')
	            ->whereNotIn('nik',function($query) { 
	            	$query->select('nik')->from('tb_cuti');
	            })
	            ->get();

            }elseif ($pos == 'DIRECTOR') {
            $cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
                    ->groupby('id_cuti')
                    ->orderBy('id_cuti','desc')
                    ->where('users.id_position','MANAGER')
                    ->where('users.id_division','!=','MSM')
                    ->orwhere('users.id_position','=','OPERATION DIRECTOR')
                    ->orwhere('users.id_position','=','HR MANAGER')
                    ->get();

            $cuti2 = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory')
                    ->orderBy('date_req','DESC')
                    ->groupby('tb_cuti.id_cuti')
                    ->where('users.id_position','MANAGER')
                    ->where('users.id_division','!=','MSM')
                    ->orwhere('users.id_position','=','OPERATION DIRECTOR')
                    ->orwhere('users.id_position','=','HR MANAGER')
                    ->groupby('nik')
                    ->get();
        }else{
        	$cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
                    ->groupby('id_cuti')
                    ->orderBy('id_cuti','desc')
                    ->get();

            $cuti2 = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory')
                    ->orderBy('date_req','DESC')
                    ->groupby('tb_cuti.id_cuti')
                    ->groupby('nik')
                    ->get();
        } 

        $bulan = date('F');
        $tahun_ini = date('Y');
        $tahun_lalu = date('Y') - 1;

        if ($ter != null) {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','OPEN')
            ->orderBy('created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_lead_register.lead_id')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_lead_register.lead_id')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }else{
            $notifOpen= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_lead_register.lead_id')
            ->where('result','')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_lead_register.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_lead_register.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'MANAGER') {
            $notifsd= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','SD')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'STAFF') {
            $notifsd= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','SD')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notifsd= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_lead_register.lead_id')
            ->where('result','SD')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }

        if ($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER') {
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'TECHNICAL PRESALES' && $pos == 'STAFF') {
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'MANAGER') {
            $notiftp= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','TP')
            ->orderBy('created_at','desc')
            ->get();
        }elseif ($div == 'SALES' && $pos == 'STAFF') {
            $notiftp= DB::table('sales_lead_register')
            ->select('opp_name','nik','lead_id')
            ->where('result','TP')
            ->orderBy('created_at','desc')
            ->get();
        }else{
            $notiftp= DB::table('sales_lead_register')
            ->join('sales_solution_design', 'sales_solution_design.lead_id', '=', 'sales_lead_register.lead_id')
            ->select('sales_lead_register.opp_name','sales_solution_design.nik','sales_solution_design.lead_id')
            ->where('result','TP')
            ->orderBy('sales_lead_register.created_at','desc')
            ->get();
        }

        return view('HR/cuti', compact('notif','notifOpen','notifsd','notiftp','cuti','cuti_index','cuti_list','detail_cuti','cek_cuti','total_cuti','year','bulan','tahun_ini','tahun_lalu','cuti2','cek'))->with(['initView'=> $this->initMenuBase(),'feature_item'=>$this->RoleDynamic('cuti')]);
    }

    public function detil_cuti(Request $request)
    {
        $cuti = $request->cuti;

        if ($request->pilih == 'date') {
            return array(DB::table('tb_cuti_detail')
                ->join('tb_cuti','tb_cuti.id_cuti','=','tb_cuti_detail.id_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->select('date_off','reason_leave','date_req','tb_cuti_detail.id_cuti','users.nik')
                ->where('tb_cuti_detail.id_cuti',$cuti)
                ->whereBetween('date_off',array($request->date_start,$request->date_end))
                ->orderBy('date_off')
                ->get(),(int)$request->$cuti);
        }else{
            if ($request->status == 'detil') {
                return array(DB::table('tb_cuti_detail')
                    ->join('tb_cuti','tb_cuti.id_cuti','=','tb_cuti_detail.id_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->select('date_off','reason_leave','date_req','tb_cuti_detail.id_cuti','users.nik','decline_reason','tb_cuti.status','tb_cuti_detail.status as status_detail','idtb_cuti_detail')
                    ->where('tb_cuti_detail.id_cuti',$cuti)
                    ->orderBy('date_off')
                    ->get(),(int)$request->$cuti);
            }else{
                return array(DB::table('tb_cuti_detail')
                    ->join('tb_cuti','tb_cuti.id_cuti','=','tb_cuti_detail.id_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->select('date_off','reason_leave','date_req','tb_cuti_detail.id_cuti','users.nik','decline_reason','tb_cuti.status','tb_cuti_detail.status as status_detail','idtb_cuti_detail')
                    ->where('tb_cuti_detail.id_cuti',$cuti)
                    ->whereRaw("(`tb_cuti_detail`.`status` = 'NEW' OR `tb_cuti_detail`.`status` = 'ACCEPT' OR `tb_cuti_detail`.`status` = 'REJECT')")
                    ->orderBy('date_off')
                    ->get(),(int)$request->$cuti);
            }
            
        }
        
    }

    public function getPublicHolidayAdjustment(){
        return DB::table('tb_cuti_adjustment')->pluck('date');
    }

    //gantii backend

    //store cuti lama
    // public function store_cuti(Request $request)
    // {
    //     $nik = Auth::User()->nik;
    //     $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
    //     $ter = $territory->id_territory;
    //     $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
    //     $div = $division->id_division;
    //     $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
    //     $pos = $position->id_position; 
    //     $company = DB::table('users')->select('id_company')->where('nik',$nik)->first();
    //     $com = $company->id_company;

    //     $nik = Auth::User()->nik;
    //     $date_now = date('Y-m-d');
        
    //     $array =  explode(',', $_POST['date_start']);

    //     $hitung = sizeof($array);

    // 	$tambah = new Cuti();
    //     $tambah->nik = $nik;
    //     $tambah->date_req = $date_now;
    //     $tambah->reason_leave = $request['reason'];
    //     $tambah->jenis_cuti = $request['jenis_cuti'];
    //     $tambah->status = 'n';
    //     $tambah->save();

    //     foreach ($array as $dates) {
    //         $store = new CutiDetil();
    //         $store->id_cuti = $tambah->id_cuti;
    //         $format_start_s = strtotime($dates);
    //         $store->date_off = date("Y-m-d",$format_start_s);
    //         $store->save();
    //     }

    //     $id_cuti    = $tambah->id_cuti;
    //     $getStatus  = Cuti::select('status')->where('id_cuti',$id_cuti)->first();
    //     $status     = $getStatus->status;

    //     if ($ter != NULL) {
    //         if ($pos == 'MANAGER' || $pos == 'ENGINEER MANAGER' || $pos == 'OPERATION DIRECTOR') {
    //             if ($div == 'PMO' || $div == 'MSM') {
    //                 $nik_kirim = DB::table('users')->select('users.email')->where('email','nabil@sinergy.co.id')->where('id_company','1')->first();
    //             } else if ($div == 'FINANCE' || $div == 'SALES' || $div == 'OPERATION') {
    //                 $nik_kirim = DB::table('users')->select('users.email')->where('email','rony@sinergy.co.id')->where('id_company','1')->first();
    //             }else{
    //                 $nik_kirim = DB::table('users')->select('users.email')->where('email','nabil@sinergy.co.id')->where('id_company','1')->first();
    //             }
    //         }else if ($ter == 'DPG') {
    //             $nik_kirim = DB::table('users')->select('users.email')->where('id_position','ENGINEER MANAGER')->where('id_company','1')->first();
    //         }else if ($div == 'WAREHOUSE'){
    //             $nik_kirim = DB::table('users')->select('users.email')->where('email','brillyan@sinergy.co.id')->where('id_company','1')->first();
    //         }else{
    //             $nik_kirim = DB::table('users')->select('users.email')->where('id_territory',Auth::User()->id_territory)->where('id_position','MANAGER')->where('id_division',Auth::User()->id_division)->where('id_company','1')->first();
    //         }
        	

    //         if ($pos == "MANAGER" && $div == "MSM"){
    //             $kirim = [User::where('email', $nik_kirim->email)->first()->email,'rony@sinergy.co.id'];
    //         } else {
    //             $kirim = User::where('email', $nik_kirim->email)->first()->email;
    //         }
    //         // $kirim = User::where('email', 'ladinar@sinergy.co.id')->first()->email;

    //         $name_cuti = DB::table('tb_cuti')
    //             ->join('users','users.nik','=','tb_cuti.nik')
    //             ->select('users.name')
    //             ->where('id_cuti', $id_cuti)->first();

    //         $hari = DB::table('tb_cuti')
    //                 ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //                 ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.status',DB::raw('group_concat(date_off) as dates'))
    //                 ->groupby('tb_cuti_detail.id_cuti')
    //                 ->where('tb_cuti.id_cuti', $id_cuti)
    //                 ->first();

    //         $ardetil = explode(',',$hari->dates);

    //         $ardetil_after = "";

    //         Mail::to($kirim)->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[SIMS-App] Permohonan Cuti'));
            
            
    //     }else{
    //         if ($div == 'HR') {
    //             if($pos == 'HR MANAGER'){
    //                 $nik_kirim = DB::table('users')->select('users.email')->where('email','rony@sinergy.co.id')->where('id_company','1')->first();
    //             }else{
    //                 $nik_kirim = DB::table('users')->select('users.email')->where('id_position','HR MANAGER')->where('id_division',Auth::User()->id_division)->where('id_company','1')->first();
    //             }
    //         }else if($pos == 'MANAGER'){
    //             $nik_kirim = DB::table('users')->select('users.email')->where('email','rony@sinergy.co.id')->where('id_company','1')->first();
    //         }else{
    //             $nik_kirim = DB::table('users')->select('users.email')->where('id_position','MANAGER')->where('id_division',Auth::User()->id_division)->where('id_company','1')->first();
    //         }
        	
    // 		// $kirim = User::where('email', 'ladinar@sinergy.co.id')->get();
    //         //

    //         $name_cuti = DB::table('tb_cuti')
    //             ->join('users','users.nik','=','tb_cuti.nik')
    //             ->select('users.name')
    //             ->where('id_cuti', $id_cuti)->first();

    //         $hari = DB::table('tb_cuti')
    //                 ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //                 ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.status',DB::raw('group_concat(date_off) as dates'))
    //                 ->groupby('tb_cuti_detail.id_cuti')
    //                 ->where('tb_cuti.id_cuti', $id_cuti)
    //                 ->first();

    //         $ardetil = explode(',',$hari->dates);

    //         $ardetil_after = "";

    //         Mail::to($nik_kirim)->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[SIMS-App] Permohonan Cuti'));


        	
    //     }

    //     return redirect()->back();
    
    // }

    //store cuti baru
    public function store_cuti(Request $request)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position; 
        $company = DB::table('users')->select('id_company')->where('nik',$nik)->first();
        $com = $company->id_company;

        $cek_role = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.name','roles.name as name_role','group','mini_group')->where('user_id',$nik)->first();

        $nik = Auth::User()->nik;
        $date_now = date('Y-m-d');
        
        $array =  explode(',', $_POST['date_start']);

        $hitung = sizeof($array);

        $tambah = new Cuti();
        $tambah->nik = $nik;
        $tambah->date_req = $date_now;
        $tambah->reason_leave = $request['reason'];
        $tambah->jenis_cuti = $request['jenis_cuti'];
        $tambah->status = 'n';
        $tambah->save();

        foreach ($array as $dates) {
            $store = new CutiDetil();
            $store->id_cuti     = $tambah->id_cuti;
            $format_start_s     = strtotime($dates);
            $store->date_off    = date("Y-m-d",$format_start_s);
            $store->status      = 'NEW';
            $store->save();
        }

        $id_cuti    = $tambah->id_cuti;
        $getStatus  = Cuti::select('status')->where('id_cuti',$id_cuti)->first();
        $status     = $getStatus->status;

        if(Str::contains($cek_role->name_role, 'VP')){
            $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('roles.name','Chief Operating Officer')->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
        } elseif(Str::contains($cek_role->name_role, 'Manager')){
            if ($cek_role->name_role == 'VP Sales' || $cek_role->name_role == 'VP Financial & Accounting'){
                $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('roles.name','Chief Executive Officer')->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
            } else {
                $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('roles.name','like', 'VP%')->where('group',$cek_role->group)->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
            }
        } elseif(!Str::contains($cek_role->name_role, 'Manager') && !Str::contains($cek_role->name_role, 'Director')) {
            if ($cek_role->name_role == 'Account Executive') {
                $kirim = DB::table('users')->select('users.email')->where('id_territory',$ter)->where('id_position','MANAGER')->where('id_division',$div)->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
            } elseif ($cek_role->group == 'Financial And Accounting') {
                $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('status_karyawan','!=','dummy')->where('id_company','1')->where('roles.name','VP Financial & Accounting')->first();
            } else {
                if ($cek_role->name_role == 'Channeling Partnership & Marketing' || $cek_role->mini_group == 'Supply Chain Management') {
                    $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('roles.name','like', 'VP%')->where('group',$cek_role->group)->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
                } else {
                    if ($hitung >= 1) {
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
                                    "(`roles`.`mini_group` = ? AND `roles`.`name` LIKE ?  AND `roles`.`name` != ?)", 
                                    [$cek_role->mini_group, '%Manager', 'Delivery Project Manager']
                                )
                                ->where('status_karyawan','!=','dummy')->where('id_company','1')->get()->pluck('email');
                        }
                    }
                }
            }
        } elseif($cek_role->name_role == 'Chief Operating Officer'){
            $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('roles.name','Chief Executive Officer')->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
        }
        
        $name_cuti = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->select('users.name')
                ->where('id_cuti', $id_cuti)->first();

        $hari_cuti = DB::table('tb_cuti')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.status',DB::raw('group_concat(date_off) as dates'))
                ->groupby('tb_cuti_detail.id_cuti')
                ->where('tb_cuti.id_cuti', $id_cuti)
                ->first();

        $ardetil = explode(',',$hari_cuti->dates);

        $ardetil_after = "";

        $hari = collect(['cuti_accept'=>$hari_cuti]);

        $hr_manager = DB::table('role_user')->join('users','users.nik','=','role_user.user_id')->select('users.email')->where('role_id','2')->first();

        Mail::to($kirim)->cc($hr_manager)->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[SIMS-App] Permohonan Cuti'));

        return redirect()->back();
    
    }

    //Approve lama
    // public function approve_cuti(Request $request)
    // {
    //     $nik = Auth::User()->nik;
    //     $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
    //     $ter = $territory->id_territory;
    //     $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
    //     $div = $division->id_division;
    //     $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
    //     $pos = $position->id_position; 
    //     $company = DB::table('users')->select('id_company')->where('nik',$nik)->first();
    //     $com = $company->id_company;
        
    //     $id_cuti = $request['id_cuti_detil'];
    //     $nik = $request['nik_cuti'];

    //     $update = Cuti::where('id_cuti',$id_cuti)->first();
    //     $update->decline_reason = $request['reason_reject'];
    //     $update->pic            = Auth::User()->name;
    //     $update->updated_at     = date('Y-m-d');
    //     $update->status = 'v';
    //     $update->update();

    //     $array =  explode(',', $_POST['cuti_fix']);

    //     $delete = CutiDetil::where('id_cuti',$id_cuti)->delete();

    //     foreach ($array as $dates) {
    //         $update = new CutiDetil();
    //         $update->id_cuti = $id_cuti;
    //         $format_start_s = strtotime($dates);
    //         $update->date_off = date("Y-m-d",$format_start_s);
    //         $update->save();
    //     }

    //     $hitung = sizeof($array);

    //     $update_cuti = User::where('nik',$nik)->first();
        
    //     Log::debug("$hitung = " . $hitung);
    //     Log::debug("$update_cuti->cuti = " . $update_cuti->cuti);
    //     if ($hitung >= $update_cuti->cuti) {
    //         Log::debug("$hitung >= $update_cuti->cuti");

    //         $ambil2020 = $hitung - $update_cuti->cuti;
    //         Log::debug("$ambil2020 = " . $ambil2020);            

    //         $hasilsisa = $update_cuti->cuti2 - $ambil2020;
    //         Log::debug("$hasilsisa = " . $hasilsisa); 

    //         if ($ambil2020 == 0) {
    //             $update_cuti->cuti = $update_cuti->cuti - $hitung;
    //         }else{
    //             $update_cuti->cuti = 0;
    //             $update_cuti->cuti2 = $hasilsisa;
    //         }

    //     }else{
    //         $update_cuti->cuti = $update_cuti->cuti - $hitung;
    //     }
        
    //     $update_cuti->update();

    //     $getStatus  = Cuti::select('status')->where('id_cuti',$id_cuti)->first();
    //     $status     = $getStatus->status;

    //     $nik_kirim = DB::table('tb_cuti')->join('users','users.nik','=','tb_cuti.nik')->select('users.email')->where('id_cuti',$id_cuti)->first();
    //     $kirim = User::where('email',$nik_kirim->email)
    //                     ->get();

    //     $name_cuti = DB::table('tb_cuti')
    //             ->join('users','users.nik','=','tb_cuti.nik')
    //             ->select('users.name')
    //             ->where('id_cuti', $id_cuti)->first();

    //     $hari = DB::table('tb_cuti')
    //             ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //             ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.status',DB::raw('group_concat(date_off) as dates'),"decline_reason")
    //             ->groupby('tb_cuti_detail.id_cuti')
    //             ->where('tb_cuti.id_cuti', $id_cuti)
    //             ->first();

    //     $ardetil = explode(',', $hari->dates); 

    //     $ardetil_after = "";

    //     Mail::to($kirim)->cc('elfi@sinergy.co.id')->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[SIMS-App] Approve - Permohonan Cuti'));        

    //     // Notification::send($kirim, new CutiKaryawan($id_cuti,$status));

    //     return redirect()->back();
    
    // }

    //approve baru
    public function approve_cuti(Request $request)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position; 
        $company = DB::table('users')->select('id_company')->where('nik',$nik)->first();
        $com = $company->id_company;
        
        $id_cuti = $request['id_cuti_detil'];
        $nik = $request['nik_cuti'];

        try {
            DB::beginTransaction();
            $update = Cuti::where('id_cuti',$id_cuti)->first();
            $update->decline_reason = $request['reason_reject'];
            $update->pic            = Auth::User()->name;
            $update->updated_at     = date('Y-m-d');
            $update->status = 'v';
            $update->update();

            $cuti_accept = explode(',', $request['cuti_fix_accept']);
            $cuti_reject = explode(',', $request['cuti_fix_reject']);

            $hitung = sizeof($cuti_accept);

//        update cuti old
//        $update_cuti = User::where('nik',$nik)->first();
//        if ($hitung >= $update_cuti->cuti) {
//            Log::debug("$hitung >= $update_cuti->cuti");
//
//            $ambil2020 = $hitung - $update_cuti->cuti;
//            Log::debug("$ambil2020 = " . $ambil2020);
//
//            $hasilsisa = $update_cuti->cuti2 - $ambil2020;
//            Log::debug("$hasilsisa = " . $hasilsisa);
//
//            if ($ambil2020 == 0) {
//                $update_cuti->cuti = $update_cuti->cuti - $hitung;
//            }else{
//                $update_cuti->cuti = 0;
//                $update_cuti->cuti2 = $hasilsisa;
//            }
//
//        }else{
//            $update_cuti->cuti = $update_cuti->cuti - $hitung;
//        }
//
//        $update_cuti->update();

            $getStatus  = Cuti::select('status')->where('id_cuti',$id_cuti)->first();
            $status     = $getStatus->status;

            $nik_kirim = DB::table('tb_cuti')->join('users','users.nik','=','tb_cuti.nik')->select('users.email')->where('id_cuti',$id_cuti)->first();
            $kirim = User::where('email',$nik_kirim->email)
                ->get();

            $name_cuti = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->select('users.name')
                ->where('id_cuti', $id_cuti)->first();

            if ($cuti_accept[0] != "") {
                foreach ($cuti_accept as $accept_dates) {
                    $update = CutiDetil::where('idtb_cuti_detail',$accept_dates)->first();
                    $cutiDate = Carbon::parse($update->date_off);
                    $march31 = Carbon::create(null, 3, 31);
                    $update_cuti = User::where('nik',$nik)->first();
                    if($cutiDate->lessThanOrEqualTo($march31) && $update_cuti->cuti > 0){
                        $update_cuti->cuti = $update_cuti->cuti - 1;
                    }else {
                        if ($update_cuti->cuti2 == 0){
                            DB::rollBack();
                            return response()->json(['status' => 'error', 'message' => 'Jumlah request cuti melebihi jumlah sisa cuti']);
                        }
                        $update_cuti->cuti2 = $update_cuti->cuti2 - 1;
                    }
                    $update_cuti->update();
                    $update->status = 'ACCEPT';
                    $update->update();
                }

                $cuti_accept_data = DB::table('tb_cuti')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.status',DB::raw('group_concat(date_off) as dates'),"decline_reason")
                    ->groupby('tb_cuti_detail.id_cuti')->where('tb_cuti_detail.status','ACCEPT')
                    ->where('tb_cuti.id_cuti', $id_cuti)
                    ->first();
            }else{
                $ardetil_after = "";

                $cuti_accept_data = "";
            }


            if ($cuti_reject[0] != "") {
                foreach ($cuti_reject as $reject_dates) {
                    $update = CutiDetil::where('idtb_cuti_detail',$reject_dates)->first();
                    $update->status = 'REJECT';
                    $update->update();
                }

                $cuti_reject_data = DB::table('tb_cuti')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.status',DB::raw('group_concat(date_off) as dates'),"decline_reason")
                    ->groupby('tb_cuti_detail.id_cuti')->where('tb_cuti_detail.status','REJECT')
                    ->where('tb_cuti.id_cuti', $id_cuti)
                    ->first();

                $ardetil_after = explode(',', $cuti_reject_data->dates);

            }else{
                $ardetil_after = "";

                $cuti_reject_data = "";
            }

            $hari = collect(['cuti_accept'=>$cuti_accept_data,'cuti_reject'=>$cuti_reject_data]);

            $ardetil = explode(',', $cuti_accept_data->dates);

            $hr_manager = DB::table('role_user')->join('users','users.nik','=','role_user.user_id')->select('users.email')->where('role_id','2')->first();

            Mail::to($kirim)->cc($hr_manager)->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[SIMS-App] Approve - Permohonan Cuti'));
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Cuti berhasil diapprove']);
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()]);
        }


    
    }

    public function decline_cuti(Request $request)
    {
        $id_cuti = $request['id_cuti'];
        $decline_reason = $request['decline_reason'];

        $update = Cuti::where('id_cuti',$id_cuti)->first();
        $update->decline_reason = $decline_reason;
        $update->status         = 'd';
        $update->pic            = Auth::User()->name;
        $update->updated_at     = date('Y-m-d');
        $update->update();

        $decline_id = CutiDetil::where('id_cuti',$id_cuti)->get();

        // return $decline_id;

        foreach ($decline_id as $decline_id) {
            $udpate_detil = CutiDetil::where('idtb_cuti_detail',$decline_id->idtb_cuti_detail)->update(array('status' => 'REJECT'));            
        }


        // $kirim = User::where('email', 'ladinar@sinergy.co.id')->get();
        $nik_kirim = DB::table('tb_cuti')->join('users','users.nik','=','tb_cuti.nik')->select('users.email')->where('id_cuti',$id_cuti)->first();
            //
        $kirim = User::where('email', $nik_kirim->email)->first()->email;

        $name_cuti = DB::table('tb_cuti')
            ->join('users','users.nik','=','tb_cuti.nik')
            ->select('users.name')
            ->where('id_cuti', $id_cuti)->first();

        $hari_decline = DB::table('tb_cuti')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.status','tb_cuti.decline_reason',DB::raw('group_concat(date_off) as dates'))
                ->groupby('tb_cuti_detail.id_cuti')
                ->where('tb_cuti.id_cuti', $id_cuti)
                ->first();

        $hari = collect(['cuti_accept'=>$hari_decline]);

        $ardetil = explode(',', $hari_decline->dates); 

        $ardetil_after = "";

        Mail::to($kirim)->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[SIMS-App] Decline - Permohonan Cuti'));

        return redirect()->back();
    
    }

    //update cuti lama
    // public function update_cuti(Request $request)
    // {
    //     $nik = Auth::User()->nik;
    //     $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
    //     $ter = $territory->id_territory;
    //     $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
    //     $div = $division->id_division;
    //     $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
    //     $pos = $position->id_position; 
    //     $company = DB::table('users')->select('id_company')->where('nik',$nik)->first();
    //     $com = $company->id_company;

    //     $id_cuti = $request['id_cuti'];

    //     $dates_after = $request['dates_after'];

    //     $dates_before = $request['dates_before'];

    //     if ($dates_after == 'kosong') {
    //         $update = Cuti::where('id_cuti',$id_cuti)->first();
    //         $update->reason_leave = $request['reason_edit'];
    //         // $update->status = $request['status_update'];
    //         $update->update();
        
    //     }else{
    //         $array =  explode(',', $dates_after);

    //         $array2 =  explode(',', $dates_before);

    //         foreach ($array2 as $dates2) {
    //             $delete = CutiDetil::where('date_off',$dates2)->where('id_cuti',$id_cuti)->delete();
    //         }

    //         foreach ($array as $dates) {
    //             $add = new CutiDetil();
    //             $add->id_cuti = $id_cuti;
    //             $format_start_s = strtotime($dates);
    //             $add->date_off = date("Y-m-d",$format_start_s);
    //             $add->save();
    //         }

    //         $update = Cuti::where('id_cuti',$id_cuti)->first();
    //         $update->reason_leave = $request['reason_edit'];
    //         $update->status = $request['status_update'];
    //         $update->update();

    //         if ($ter != NULL) {
    //             if ($pos == 'MANAGER' || $pos == 'ENGINEER MANAGER' || $pos == 'OPERATION DIRECTOR') {
    //                 if ($div == 'PMO' || $div == 'MSM') {
    //                     $nik_kirim = DB::table('users')->select('users.email')->where('email','firman@sinergy.co.id')->where('id_company','1')->first();
    //                 }else if ($div == 'FINANCE' || $div == 'SALES' || $div == 'OPERATION') {
    //                     $nik_kirim = DB::table('users')->select('users.email')->where('email','rony@sinergy.co.id')->where('id_company','1')->first();
    //                 }else{
    //                     $nik_kirim = DB::table('users')->select('users.email')->where('email','nabil@sinergy.co.id')->where('id_company','1')->first();
    //                 }
    //             }else if ($ter == 'DPG') {
    //                 $nik_kirim = DB::table('users')->select('users.email')->where('id_position','ENGINEER MANAGER')->where('id_company','1')->first();
    //             }else if ($div == 'WAREHOUSE'){
    //                 $nik_kirim = DB::table('users')->select('users.email')->where('email','firman@sinergy.co.id')->where('id_company','1')->first();
    //             }else{
    //                 $nik_kirim = DB::table('users')->select('users.email')->where('id_territory',Auth::User()->id_territory)->where('id_position','MANAGER')->where('id_division',Auth::User()->id_division)->where('id_company','1')->first();
    //             }
                
    //             $kirim = User::where('email', $nik_kirim->email)->first()->email;

    //             $name_cuti = DB::table('tb_cuti')
    //                 ->join('users','users.nik','=','tb_cuti.nik')
    //                 ->select('users.name','status')
    //                 ->where('id_cuti', $id_cuti)->first();

    //             $hari = DB::table('tb_cuti')
    //                     ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //                     ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave',DB::raw("(CASE WHEN (status = 'n') THEN 'R' ELSE status END) as status"),DB::raw('group_concat(date_off) as dates'))
    //                     ->groupby('tb_cuti_detail.id_cuti')
    //                     ->where('tb_cuti.id_cuti', $id_cuti)
    //                     ->first();

    //             $hari_before = $_POST['dates_before'];

    //             $ardetil = explode(',',$hari_before);

    //             $hari_after = $_POST['dates_after'];

    //             $ardetil_after = explode(',',$hari_after);

    //             Mail::to($kirim)->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[SIMS-App] Reschedule - Permohonan Cuti'));            
            
    //         }else{
    //             if ($div == 'HR') {
    //                 if($pos == 'HR MANAGER'){
    //                     $nik_kirim = DB::table('users')->select('users.email')->where('email','rony@sinergy.co.id')->where('id_company','1')->first();
    //                 }else{
    //                     $nik_kirim = DB::table('users')->select('users.email')->where('id_position','HR MANAGER')->where('id_division',Auth::User()->id_division)->where('id_company','1')->first();
    //                 }
    //             }else if($pos == 'MANAGER'){
    //                 $nik_kirim = DB::table('users')->select('users.email')->where('email','rony@sinergy.co.id')->where('id_company','1')->first();
    //             }else{
    //                 $nik_kirim = DB::table('users')->select('users.email')->where('id_position','MANAGER')->where('id_division',Auth::User()->id_division)->where('id_company','1')->first();
    //             }
                
    //             //
    //             $kirim = User::where('email', $nik_kirim->email)->first()->email;

    //             $name_cuti = DB::table('tb_cuti')
    //                 ->join('users','users.nik','=','tb_cuti.nik')
    //                 ->select('users.name','status')
    //                 ->where('id_cuti', $id_cuti)->first();

    //             $hari = DB::table('tb_cuti')
    //                     ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //                     ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave',DB::raw("(CASE WHEN (status = 'n') THEN 'R' ELSE status END) as status"),DB::raw('group_concat(date_off) as dates'))
    //                     ->groupby('tb_cuti_detail.id_cuti')
    //                     ->where('tb_cuti.id_cuti', $id_cuti)
    //                     ->first();

    //             $hari_before = $_POST['dates_before'];

    //             $ardetil = explode(',',$hari_before);

    //             $hari_after = $_POST['dates_after'];

    //             $ardetil_after = explode(',',$hari_after);
                
    //             Mail::to($kirim)->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[SIMS-App] Reschedule - Permohonan Cuti'));
            
    //         }
        
    //     }
    //     return 'success';

    //     // return redirect()->back();
    // }

    //update cuti baru
    public function update_cuti(Request $request)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position; 
        $company = DB::table('users')->select('id_company')->where('nik',$nik)->first();
        $com = $company->id_company;

        $cek_role = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.name','roles.name as name_role','group','mini_group')->where('user_id',$nik)->first();

        $id_cuti = $request['id_cuti'];

        $dates_after = $request['dates_after'];

        $dates_before = $request['dates_before'];

        if ($dates_after == 'kosong') {
            $update = Cuti::where('id_cuti',$id_cuti)->first();
            $update->reason_leave = $request['reason_edit'];
            $update->status = $request['status_update'];
            $update->update();
        
        }else{
            $array2 = explode(',', $dates_after);

            $array  = explode(',', $dates_before);

            $resultA = array_diff($array, $array2);
            $resultB = array_diff($array2, $array);

            if ($resultA) {

                foreach ($resultA as $dates) {
                    $update_cuti            = CutiDetil::where('date_off',$dates)->where('id_cuti',$id_cuti)->first();
                    $update_cuti->status    = 'CANCEL';
                    $update_cuti->update();
                }

                foreach ($resultB as $dates) {
                    if (CutiDetil::where('id_cuti',$id_cuti)->whereIn('date_off',$resultB)->get() == '[]') {
                        $add            = new CutiDetil();
                        $add->id_cuti   = $id_cuti;
                        $format_start_s = strtotime($dates);
                        $add->date_off  = date("Y-m-d",$format_start_s);
                        $add->status    = 'NEW';
                        $add->save();  
                    } else {
                        $add            = new CutiDetil();
                        $add->id_cuti   = $id_cuti;
                        $format_start_s = strtotime($dates);
                        $add->date_off  = date("Y-m-d",$format_start_s);
                        $add->status    = 'NEW';
                        $add->save(); 
                    }                                 

                    // CutiDetil::where('id_cuti',$id_cuti)->whereIn('date_off',$array2)->update(['status' => 'NEW']);
                }
            }

            $update = Cuti::where('id_cuti',$id_cuti)->first();
            $update->reason_leave = $request['reason_edit'];
            $update->status = $request['status_update'];
            $update->update();

            if(Str::contains($cek_role->name_role, 'VP')){
                $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('status_karyawan','!=','dummy')->where('roles.name','Chief Operating Officer')->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
            } elseif(Str::contains($cek_role->name_role, 'Manager')){
                if($cek_role->name_role == 'People Operations & Services Manager' &&  $cek_role->name_role == 'Organizational & People Development Manager'){
                    $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('roles.name','VP Human Capital Management')->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
                } elseif ($cek_role->name_role == 'Chief Operating Officer' || $cek_role->name_role == 'VP Sales' || $cek_role->name_role == 'VP Financial & Accounting'){
                    $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('roles.name','Chief Executive Officer')->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
                } else {
                    $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('roles.name','like', 'VP%')->where('group',$cek_role->group)->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
                }
            } elseif(!Str::contains($cek_role->name_role, 'Manager') && !Str::contains($cek_role->name_role, 'Director')) {
                if ($cek_role->name_role == 'Account Executive') {
                    $kirim = DB::table('users')->select('users.email')->where('id_territory',$ter)->where('id_position','MANAGER')->where('id_division',$div)->where('id_company','1')->first();
                } elseif ($cek_role->group == 'Financial And Accounting') {
                    $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('status_karyawan','!=','dummy')->where('id_company','1')->where('roles.name','VP Financial & Accounting')->first();
                }  else {
                    if ($cek_role->name_role == 'Channeling Partnership & Marketing' || $cek_role->mini_group == 'Supply Chain Management') {
                        $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('roles.name','like', 'VP%')->where('group',$cek_role->group)->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
                    } else {
                        if (sizeof($resultB) >= 1) {
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
                                    "(`roles`.`mini_group` = ? AND `roles`.`name` LIKE ?  AND `roles`.`name` != ?)", 
                                    [$cek_role->mini_group, '%Manager', 'Delivery Project Manager']
                                )
                                ->where('status_karyawan','!=','dummy')->where('id_company','1')->get()->pluck('email');
                            }
                        }
                    }
                }
            } elseif($cek_role->name_role == 'Chief Operating Officer' ){
                $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('roles.name','Chief Executive Officer')->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
            }

            // $kirim = User::where('email', $nik_kirim->email)->first()->email;

            $name_cuti = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->select('users.name','status')
                ->where('id_cuti', $id_cuti)->first();

            $hari_cuti = DB::table('tb_cuti')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave',DB::raw("(CASE WHEN (tb_cuti.status = 'n') THEN 'R' ELSE tb_cuti.status END) as status"),DB::raw('group_concat(date_off) as dates'))
                    ->groupby('tb_cuti_detail.id_cuti')
                    ->where('tb_cuti.id_cuti', $id_cuti)
                    ->where('tb_cuti_detail.status','NEW')
                    ->first();

            $hari = collect(['cuti_accept'=>$hari_cuti]);

            $hari_before = $_POST['dates_before'];

            $ardetil = explode(',',$hari_before);

            $hari_after = $_POST['dates_after'];

            $ardetil_after = explode(',',$hari_after);

            Mail::to($kirim)->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[SIMS-App] Reschedule - Permohonan Cuti')); 
        
        }
        return 'success';

        // return redirect()->back();
    }

    public function delete_cuti($id_cuti)
    {
        $hapus = Cuti::find($id_cuti);
        $hapus->delete();

        return redirect()->back();
    }

    public function follow_up(Request $request)
    {
        // return $id_cuti;
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position; 
        $company = DB::table('users')->select('id_company')->where('nik',$nik)->first();
        $com = $company->id_company;

        $cek_role = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.name','roles.name as name_role','group','mini_group')->where('user_id',$nik)->first();

        // if ($ter != NULL) {
        //     if ($pos == 'MANAGER' || $pos == 'ENGINEER MANAGER' || $pos == 'OPERATION DIRECTOR') {
        //         if ($div == 'PMO') {
        //             $nik_kirim = DB::table('users')->select('users.email')->where('email','nabil@sinergy.co.id')->where('id_company','1')->first();
        //         }else if ($div == 'FINANCE' || $div == 'SALES' || $div == 'OPERATION') {
        //             $nik_kirim = DB::table('users')->select('users.email')->where('email','rony@sinergy.co.id')->where('id_company','1')->first();
        //         }else{
        //             $nik_kirim = DB::table('users')->select('users.email')->where('email','nabil@sinergy.co.id')->where('id_company','1')->first();
        //         }
        //     }else if ($ter == 'DPG') {
        //         $nik_kirim = DB::table('users')->select('users.email')->where('id_position','ENGINEER MANAGER')->where('id_company','1')->first();
        //     }else if ($div == 'WAREHOUSE'){
        //         $nik_kirim = DB::table('users')->select('users.email')->where('email','elfi@sinergy.co.id')->where('id_company','1')->first();
        //     }else if ($cek_role->name_role == 'Chief Operating Officer'){
        //         $nik_kirim = DB::table('users')->select('users.email')->where('email','rony@sinergy.co.id')->where('id_company','1')->first()->email;
        //     }else{
        //         $nik_kirim = DB::table('users')->select('users.email')->where('id_territory',Auth::User()->id_territory)->where('status_karyawan', '!=', 'dummy')->where('id_position','MANAGER')->where('id_division',Auth::User()->id_division)->where('id_company','1')->first();
        //     }
            
        // }else{
        //     if ($div == 'HR') {
        //         if($pos == 'HR MANAGER'){
        //             $nik_kirim = DB::table('users')->select('users.email')->where('email','nabil@sinergy.co.id')->where('id_company','1')->first();
        //         }else{
        //             $nik_kirim = DB::table('users')->select('users.email')->where('email','elfi@sinergy.co.id')->where('id_company','1')->first();
        //         }
        //     }else if($div == 'MANAGER'){
        //         $nik_kirim = DB::table('users')->select('users.email')->where('email','rony@sinergy.co.id')->where('id_company','1')->first();
        //     }else{
        //         $nik_kirim = DB::table('users')->select('users.email')->where('id_position','MANAGER')->where('id_division',Auth::User()->id_division)->where('id_company','1')->first();
        //     }
            
        // }

        $hitung = CutiDetil::where('id_cuti',$request->id_cuti)->where('status','NEW')->count();

        if(Str::contains($cek_role->name_role, 'VP')){
            $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('roles.name','Chief Operating Officer')->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
        } elseif(Str::contains($cek_role->name_role, 'Manager')){
            if($cek_role->name_role == 'People Operations & Services Manager' &&  $cek_role->name_role == 'Organizational & People Development Manager'){
                $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('roles.name','VP Human Capital Management')->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
            } elseif ($cek_role->name_role == 'Chief Operating Officer' || $cek_role->name_role == 'VP Sales' || $cek_role->name_role == 'VP Financial & Accounting'){
                $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('roles.name','Chief Executive Officer')->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
            } else {
                $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('roles.name','like', 'VP%')->where('group',$cek_role->group)->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
            }
        } elseif(!Str::contains($cek_role->name_role, 'Manager') && !Str::contains($cek_role->name_role, 'Director')) {
            if ($cek_role->name_role == 'Account Executive') {
                $kirim = DB::table('users')->select('users.email')->where('id_territory',$ter)->where('id_position','MANAGER')->where('id_division',$div)->where('id_company','1')->where('status_karyawan','!=','dummy')->first();
            } elseif ($cek_role->group == 'Financial And Accounting') {
                $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('status_karyawan','!=','dummy')->where('id_company','1')->where('roles.name','VP Financial & Accounting')->first();
            }  else {
                if ($cek_role->name_role == 'Channeling Partnership & Marketing' || $cek_role->mini_group == 'Supply Chain Management') {
                    $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('roles.name','like', 'VP%')->where('group',$cek_role->group)->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
                } else {
                    if ($hitung >= 1) {
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
                                    "(`roles`.`mini_group` = ? AND `roles`.`name` LIKE ?  AND `roles`.`name` != ?)", 
                                    [$cek_role->mini_group, '%Manager', 'Delivery Project Manager']
                                )
                                ->where('status_karyawan','!=','dummy')->where('id_company','1')->get()->pluck('email');
                        }
                    }
                }
            }
        } elseif($cek_role->name_role == 'Chief Operating Officer'){
            $kirim = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.email')->where('roles.name','Chief Executive Officer')->where('status_karyawan','!=','dummy')->where('id_company','1')->first();
        }

        $update = Cuti::where('id_cuti',$request->id_cuti)->first();
        $update->status = 'n';
        $update->save(); 

        // $kirim = User::where('email', $nik_kirim->email)->first()->email;

        $name_cuti = DB::table('tb_cuti')
            ->join('users','users.nik','=','tb_cuti.nik')
            ->select('users.name')
            ->where('id_cuti', $request->id_cuti)->first();

        $hari_cuti = DB::table('tb_cuti')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->select(db::raw('count(tb_cuti_detail.id_cuti) as days'),'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.status',DB::raw('group_concat(date_off) as dates'))
                ->groupby('tb_cuti_detail.id_cuti')
                ->where('tb_cuti.id_cuti', $request->id_cuti)
                ->where('tb_cuti_detail.status','NEW')
                ->first();

        $hari = collect(['cuti_accept'=>$hari_cuti]);

        $ardetil = explode(',',$hari_cuti->dates);

        $ardetil_after = "";

        Mail::to($kirim)->send(new CutiKaryawan($name_cuti,$hari,$ardetil,$ardetil_after,'[SIMS-App] Approve - Permohonan Cuti (Follow Up)'));

        return redirect()->back()->with('success','Cuti Kamu udah di follow up ke Bos! Thanks.');
    }

    public function setting_total_cuti(Request $request)
    {

        if ($request->users == 'all_emp') {
            $nik = User::select('nik','status_karyawan',DB::raw('DATEDIFF(NOW(),date_of_entry) AS date_of_entrys'))->get();

            foreach ($nik as $data) {
                if ($request['pengurangan_cuti'] == NULL) {

                    $update = User::where('nik',$data->nik)->first();
                    if ($data->status_karyawan == 'cuti') {
                        if ($data->date_of_entrys < 365) {
                            $update->cuti2 = NULL;
                        }else{
                            $update->cuti2 = $request['set_cuti'];
                        } 
                    }else{
                        $update->cuti = NULL;
                    }
                    $update->update();
                }else{
                    $update = User::where('nik',$data->nik)->first();
                    if ($request['set_cuti'] == NULL) {
                        $update->cuti = $nik->cuti - $request['pengurangan_cuti'];
                    }else{
                        if ($data->status_karyawan == 'cuti') {
                            $update->cuti = $request['set_cuti'] - $request['pengurangan_cuti'];
                        }else{
                            $update->cuti = NULL;
                        }
                    }
                    $update->update();
                }
            }
        }else{
            if ($request['pengurangan_cuti'] == NULL) {
                $update = User::where('nik',$request->users)->first();
                $update->cuti = $request['set_cuti'];
                $update->update();
            }else{
                $update = User::where('nik',$request->users)->first();
                if ($request['set_cuti'] == NULL) {

                    $update->cuti = $nik->cuti - $request['pengurangan_cuti'];
                }else{
                    
                    $update->cuti = $request['set_cuti'] - $request['pengurangan_cuti'];
                }
                
                $update->update();
            }
            
        }

        return redirect()->back();
    }

    public function set_total_cuti(Request $request)
    {

        $nik = User::select('nik','cuti','status_karyawan',DB::raw('DATEDIFF(NOW(),date_of_entry) AS date_of_entrys'))->get();

        foreach ($nik as $data) {
        	$update = User::where('nik',$data->nik)->first();
        	if ($data->status_karyawan == 'cuti') {
		        $update->cuti = $data->cuti - $request['pengurangan_cuti'];
        	}else{
        		$update->cuti = NULL;
        	}
        	$update->update();
        }

        return redirect()->back();
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tambah = new Barang();
        $tambah->id_item = $request['id_item'];
        $tambah->item_name = $request['nama_item'];
        $tambah->quantity = $request['quantity'];
        $tambah->info = $request['info'];
        $tambah->save();

        return view('HRGA/hrga');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapus = Barang::find($id);
                $hapus->delete();

                return redirect()->to('/hrga');
    }

    public function getIdTask()
    {
        return array(DB::table('tb_task')
            ->select('id_task','task_name','description','task_date')
            ->get());
        
    }

    public function getCutiUsers(Request $request){

        $getcuti = User::select(
            'nik',
            DB::raw('DATEDIFF(NOW(),date_of_entry) AS date_of_entrys'),
            DB::raw('(CASE WHEN (cuti IS NULL) THEN 0 ELSE cuti END) as cuti'),
            DB::raw('(CASE WHEN (cuti2 IS NULL) THEN 0 ELSE cuti2 END) as cuti2'),
            DB::raw('sum(IFNULL(`cuti`,0) + IFNULL(`cuti2`,0)) AS total_cuti'),
            'date_of_entry'
        )->where('nik',$request->nik)
        ->groupby('users.nik')
        ->get();

        $getShifingUser = DB::table('presence__shifting_user')->where('nik',$request->nik)->exists();


        $getAllCutiDate = DB::table('tb_cuti_detail')
            ->select('date_off')
            ->whereIn('id_cuti',function($query){
                $query->select('id_cuti')
                    ->from('tb_cuti')
                    ->where('status', '<>', 'd')
                    ->where('nik','=',Auth::user()->nik);
            })
            ->where('tb_cuti_detail.status', 'ACCEPT')
            ->pluck('date_off');

        return collect([
            "parameterCuti" => $getcuti,
            "allCutiDate" => $getAllCutiDate,
            "shiftingUser" => $getShifingUser
        ]);
    }

    public function getCutiAuth(Request $request){

        $getcuti = User::select('nik','name',DB::raw('DATEDIFF(NOW(),date_of_entry) AS date_of_entrys'),DB::raw('(CASE WHEN (cuti IS NULL) THEN 0 ELSE cuti END) as cuti'),DB::raw('(CASE WHEN (cuti2 IS NULL) THEN 0 ELSE cuti2 END) as cuti2'),DB::raw('sum(cuti + cuti2) AS total_cuti'),'date_of_entry','gambar')->where('nik',Auth::User()->nik)->groupby('users.nik')->get();

        return $getcuti;
    }

    public function CutiExcel(Request $request) {
        $dateStart = $request->date_start;
        $dateEnd = $request->date_end;
        $dateStartLastYear = Carbon::createFromDate($request->date_start);
        $dateEndLastYear = Carbon::createFromDate($request->date_end);
        $dateStartLastYear = $dateStartLastYear->copy()->subYear()->format("Y-m-d");
        $dateEndLastYear = $dateEndLastYear->copy()->subYear()->format("Y-m-d");
        $startDate = Carbon::now()->subMonths(1)->format("Y-m-16");
        $endDate = Carbon::now()->format("Y-m-16");

        $total_cuti = "12";
        $cuti_bersama = count($this->getWorkDays($dateStart,$dateEnd)["holiday"]->values());

        // return $this->getWorkDays($dateStart,$dateEnd)["holiday"]->values();
        $getPublicHolidayAdjustment = PublicHolidayAdjustment::whereRaw('`date` BETWEEN "' . $dateStart . '" AND "' . $dateEnd . '"')->whereYear('date',date('Y'))->count();

        $cuti_bersama = $cuti_bersama+$getPublicHolidayAdjustment;

        $cuti_bersama_last_year = count($this->getWorkDays($dateStartLastYear,$dateEndLastYear)["holiday"]->values());

        $getPublicHolidayAdjustmentLastYear = PublicHolidayAdjustment::whereRaw('`date` BETWEEN "' . $dateStart . '" AND "' . $dateEnd . '"')->whereYear('date',date('Y')-1)->count();

        $cuti_bersama_last_year = $cuti_bersama_last_year+$getPublicHolidayAdjustmentLastYear;
        $jumlah_cuti_now = 12 - $cuti_bersama;



        $spreadsheet = new Spreadsheet();

        $spreadsheet->removeSheetByIndex(0);
        $spreadsheet->addSheet(new Worksheet($spreadsheet,'Sinergy informasi Pratama'));
//        $spreadsheet->addSheet(new Worksheet($spreadsheet,'Multi Solusindo Perkasa'));
        // $spreadsheet->addSheet(new Worksheet($spreadsheet,'Detail Report Cuti SIP & MSP'));
        $spreadsheet->addSheet(new Worksheet($spreadsheet,'Rekap Cuti SIP'));
        $spreadsheet->addSheet(new Worksheet($spreadsheet,'History Cuti'));
        $sipSheet = $spreadsheet->setActiveSheetIndex(0);
//        $mspSheet = $spreadsheet->setActiveSheetIndex(1);
        // $detailSheet = $spreadsheet->setActiveSheetIndex(2);
        $rekapSheet = $spreadsheet->setActiveSheetIndex(1);
        $historySheet = $spreadsheet->setActiveSheetIndex(2);

        $sipSheet->mergeCells('A1:H1');
//        $mspSheet->mergeCells('A1:H1');
        // $detailSheet->mergeCells('A1:H1');
        $normalStyle = [
            'font' => [
                'name' => 'Calibri',
                'size' => 11
            ],
        ];

        $titleStyle = $normalStyle;
        $titleStyle['alignment'] = ['horizontal' => Alignment::HORIZONTAL_CENTER];
        $titleStyle['borders'] = ['outline' => ['borderStyle' => Border::BORDER_THIN]];
        $titleStyle['fill'] = ['fillType' => Fill::FILL_SOLID, 'startColor' => ["argb" => "FFFCD703"]];
        $titleStyle['font']['bold'] = true;

        $headerStyle = $normalStyle;
        $headerStyle['font']['bold'] = true;

        // $client = new Client();
        // $client = $client->get('https://www.googleapis.com/calendar/v3/calendars/en.indonesian%23holiday%40group.v.calendar.google.com/events?key=' . env('GCALENDAR_API_KEY'));
        // $variable = json_decode($client->getBody())->items;

        // $hitung_cuti_bersama = 0;
        // foreach ($variable as $key => $value) {
        //   if(strpos($value->summary,'Cuti Bersama') === 0){
        //     // echo $value->start->date . "<br>";
        //     if(strpos($value->start->date ,date('Y')) === 0){
        //       // echo $value->start->date . " " . strpos($value->summary,'Cuti Bersama') . ' - ' . $value->summary . "<br>";
        //       $hitung_cuti_bersama++;
        //     }
        //   }
        // }


        $sipSheet->getStyle('A1:H1')->applyFromArray($titleStyle);
        $sipSheet->setCellValue('A1','Report Cuti SIP');

        $sipCutiData = User::select(
                'users.name',
                DB::raw('CONCAT(12, " Hari") AS `hak_cuti`'),
                DB::raw('CONCAT(' . $cuti_bersama . ', " Hari") AS `cuti_bersama_' . date('Y') . '`'),
                // DB::raw('CONCAT(' . $hitung_cuti_bersama . ', " Hari") AS `cuti_bersama_' . date('Y') . '`'),
                DB::raw('IF(`tb_cuti_counted`.`cuti_diambil` > 0,CONCAT(`tb_cuti_counted`.`cuti_diambil`, " Hari"),"-") AS `cuti_diambil_' . date('Y') . '`'),
                DB::raw('IF(`users`.`cuti` > 0,CONCAT(`users`.`cuti`, " Hari"),"-") AS `sisah_cuti_' . (date('Y')-1) . '`'),
                DB::raw('IF(`users`.`cuti2` > 0,CONCAT(`users`.`cuti2`, " Hari"),"-") AS `sisah_cuti_' . date('Y') . '`'),
                DB::raw('IF(`users`.`status_karyawan` = "belum_cuti","Belum 1 tahun",IF((`users`.`cuti` + `users`.`cuti2`) = 0,"Habis","Cuti")) AS `status`')
            )
            ->leftJoinSub(DB::table('tb_cuti')
                ->select('nik',DB::raw('COUNT(*) as `cuti_diambil`'))
                ->join('tb_cuti_detail','tb_cuti.id_cuti', '=', 'tb_cuti_detail.id_cuti')
                ->where('tb_cuti.status','=','v')
                // ->where('date_req','>','2021-03-16')
                // ->where('date_req','<','2021-04-15')
                // ->whereRaw('`date_off` BETWEEN "' . $startDate . '" AND "' . $endDate . '"')
                // ->whereYear('date_req',date('Y'))
                ->groupBy('nik')
                ,'tb_cuti_counted','users.nik','=','tb_cuti_counted.nik')
            ->where('users.status_karyawan','!=','dummy')
            ->where('users.id_company','1')
            ->orderBy('users.name', 'ASC')
            ->get();


        $headerContent = ["No","Nama Karyawan", "Hak Cuti Tahunan","Cuti Bersama", "Cuti Sudah diambil", "Sisa Cuti ", "Sisa Cuti " . date('Y'),"Status Hak Cuti Karyawan"];
        $sipSheet->getStyle('A2:H2')->applyFromArray($headerStyle);
        $sipSheet->fromArray($headerContent,NULL,'A2');


        $sipCutiData->map(function($item,$key) use ($sipSheet){
            $sipSheet->fromArray(array_merge([$key + 1],array_values($item->toArray())),NULL,'A' . ($key + 3));
        });

        $sipSheet->getColumnDimension('A')->setAutoSize(true);
        $sipSheet->getColumnDimension('B')->setAutoSize(true);
        $sipSheet->getColumnDimension('C')->setAutoSize(true);
        $sipSheet->getColumnDimension('D')->setAutoSize(true);
        $sipSheet->getColumnDimension('E')->setAutoSize(true);
        $sipSheet->getColumnDimension('F')->setAutoSize(true);
        $sipSheet->getColumnDimension('G')->setAutoSize(true);
        $sipSheet->getColumnDimension('H')->setAutoSize(true);

        $historySheet->getStyle('A1:I1')->applyFromArray($titleStyle);
        $historySheet->setCellValue('A1','History Cuti SIP');

        $headerHistoryContent = ["No","Nama Karyawan","Tanggal Request", "Jumlah Hari Request","Detail Request", "Jumlah Hari Approve","Detail Approve", "Tanggal Approve ", "Diapprove Oleh"];
        $historySheet->getStyle('A2:I2')->applyFromArray($headerStyle);
        $historySheet->fromArray($headerHistoryContent,NULL,'A2');

        $sipHistoryData = Cuti::join('tb_cuti_detail', 'tb_cuti.id_cuti', 'tb_cuti_detail.id_cuti')
            ->join('users', 'tb_cuti.nik', 'users.nik')
            ->select(
                DB::raw('ANY_VALUE(users.name) as name'),
                'tb_cuti.date_req',

                DB::raw('CONCAT(COUNT(tb_cuti_detail.id_cuti), " hari") as jumlah_hari_request'),
                DB::raw('(
                    SELECT GROUP_CONCAT(DATE_FORMAT(cd4.date_off, "%d-%m-%Y") SEPARATOR ", ")
                    FROM tb_cuti_detail cd4
                    WHERE cd4.id_cuti = tb_cuti.id_cuti
                ) as detail_request'),
                DB::raw('(
                    SELECT CONCAT(COUNT(*), " hari")
                    FROM tb_cuti_detail cd2
                    WHERE cd2.id_cuti = tb_cuti.id_cuti
                    AND cd2.status = "ACCEPT"
                ) as jumlah_hari_cuti'),
                DB::raw('(
                    SELECT GROUP_CONCAT(DATE_FORMAT(cd3.date_off, "%d-%m-%Y") SEPARATOR ", ")
                    FROM tb_cuti_detail cd3
                    WHERE cd3.id_cuti = tb_cuti.id_cuti
                    AND cd3.status = "ACCEPT"
                ) as detail'),

                'tb_cuti.updated_at',
                'tb_cuti.pic'
            )
            ->where('tb_cuti.status','v')
            ->where('tb_cuti.date_req', '>=', $dateStart)
            ->where('tb_cuti.date_req', '<=', $dateEnd)
            ->where('users.id_company','1')
            ->orderBy('users.name')
            ->groupBy('tb_cuti.id_cuti', 'tb_cuti.date_req', 'tb_cuti.updated_at', 'tb_cuti.pic')
            ->get()
            ->makeHidden(['remarks']);

        $sipHistoryData->map(function ($item,$key) use ($historySheet){
            $historySheet->fromArray(array_merge([$key + 1],array_values($item->toArray())),NULL,'A' . ($key + 3));
        });
        $historySheet->getStyle('A1:I' . ($sipHistoryData->count() + 2))->getAlignment()->setWrapText(true);
        for ($row = 3; $row <= $sipHistoryData->count() + 2; $row++) {
            $historySheet->getRowDimension($row)->setRowHeight(-1);
        }
        $historySheet->getStyle('D3:D' . ($sipHistoryData->count() + 2))
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $historySheet->getStyle('F3:F' . ($sipHistoryData->count() + 2))
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $historySheet->getColumnDimension('A')->setAutoSize(true);
        $historySheet->getColumnDimension('B')->setAutoSize(true);
        $historySheet->getColumnDimension('C')->setAutoSize(true);
        $historySheet->getColumnDimension('D')->setAutoSize(true);
        $historySheet->getColumnDimension('E')->setWidth(50);
        $historySheet->getColumnDimension('F')->setAutoSize(true);
        $historySheet->getColumnDimension('G')->setWidth(50);
        $historySheet->getColumnDimension('H')->setAutoSize(true);
        $historySheet->getColumnDimension('I')->setAutoSize(true);

//        $mspSheet->getStyle('A1:H1')->applyFromArray($titleStyle);
//        $mspSheet->setCellValue('A1','Report Cuti MSP');
//
//        $mspCutiData = User::select(
//                'users.name',
//                DB::raw('CONCAT(12, " Hari") AS `hak_cuti`'),
//                DB::raw('CONCAT(' . $cuti_bersama . ', " Hari") AS `cuti_bersama_' . date('Y') . '`'),
//                DB::raw('IF(`tb_cuti_counted`.`cuti_diambil` > 0,CONCAT(`tb_cuti_counted`.`cuti_diambil`, " Hari"),"-") AS `cuti_diambil_' . date('Y') . '`'),
//                DB::raw('IF(`users`.`cuti` > 0,CONCAT(`users`.`cuti`, " Hari"),"-") AS `sisah_cuti_' . (date('Y')-1) . '`'),
//                DB::raw('IF(`users`.`cuti2` > 0,CONCAT(`users`.`cuti2`, " Hari"),"-") AS `sisah_cuti_' . date('Y') . '`'),
//                DB::raw('IF(`users`.`status_karyawan` = "belum_cuti","Belum 1 tahun",IF((`users`.`cuti` + `users`.`cuti2`) = 0,"Habis","-")) AS `status`')
//            )
//            ->leftJoinSub(DB::table('tb_cuti')
//                ->select('nik',DB::raw('COUNT(*) as `cuti_diambil`'))
//                ->join('tb_cuti_detail','tb_cuti.id_cuti', '=', 'tb_cuti_detail.id_cuti')
//                ->where('tb_cuti.status','=','v')
//                // ->where('date_req','>','2021-03-16')
//                // ->where('date_req','<','2021-04-15')
//                // ->whereYear('date_req',date('Y'))
//                // ->whereRaw('`date_off` BETWEEN "' . $startDate . '" AND "' . $endDate . '"')
//                ->groupBy('nik')
//                ,'tb_cuti_counted','users.nik','=','tb_cuti_counted.nik')
//            ->where('users.status_karyawan','!=','dummy')
//            ->where('users.id_company','2')
//            ->orderBy('users.name', 'ASC')
//            ->get();

//        $headerContent = ["No","Nama Karyawan", "Hak Cuti Tahunan","Cuti Bersama", "Cuti Sudah diambil", "Sisa Cuti ", "Sisa Cuti " . date('Y'),"Status Hak Cuti Karyawan"];
//        $mspSheet->getStyle('A2:H2')->applyFromArray($headerStyle);
//        $mspSheet->fromArray($headerContent,NULL,'A2');
//
//        $mspCutiData->map(function($item,$key) use ($mspSheet){
//            $mspSheet->fromArray(array_merge([$key + 1],array_values($item->toArray())),NULL,'A' . ($key + 3));
//        });
//
//        $mspSheet->getColumnDimension('A')->setAutoSize(true);
//        $mspSheet->getColumnDimension('B')->setAutoSize(true);
//        $mspSheet->getColumnDimension('C')->setAutoSize(true);
//        $mspSheet->getColumnDimension('D')->setAutoSize(true);
//        $mspSheet->getColumnDimension('E')->setAutoSize(true);
//        $mspSheet->getColumnDimension('F')->setAutoSize(true);
//        $mspSheet->getColumnDimension('G')->setAutoSize(true);
//        $mspSheet->getColumnDimension('H')->setAutoSize(true);

        // $detailSheet->getStyle('A1:H1')->applyFromArray($titleStyle);
        // $detailSheet->setCellValue('A1','Detail Report Bulanan Cuti');

        // $detailCutiData = Cuti::join('users','users.nik','=','tb_cuti.nik')
        //     ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
        //     ->join('tb_position','tb_position.id_position','=','users.id_position')
        //     ->join('tb_division','tb_division.id_division','=','users.id_division')
        //     ->join('tb_company','tb_company.id_company','=','users.id_company')
        //     ->select(
        //         'users.name',
        //         'code_company',
        //         'tb_division.name_division',
        //         DB::raw('CONCAT(COUNT(`tb_cuti_detail`.`id_cuti`), " Hari") AS `days`'),
        //         DB::raw('REPLACE(GROUP_CONCAT(`date_off`),"-","/") AS `date_off`'),
        //         'tb_cuti.date_req',
        //         DB::raw('CONCAT("[ ",`jenis_cuti`," ]/[ ",`reason_leave`," ]") AS `detail`')
        //     )
        //     ->where('tb_cuti.status','v')
        //     // ->whereBetween('date_off',array($request->date_start,$request->date_end))
        //     // ->where('date_off','>','2021-03-16')
        //     // ->where('date_off','<','2021-04-15')
        //     ->whereRaw('`date_off` BETWEEN "' . $startDate . '" AND "' . $endDate . '"')
        //     ->groupby('tb_cuti.id_cuti')
        //     ->get();

        // $headerContent = ["No", "Nama Karyawan","Company", "Division", "Request Cuti", "Date Off", "Tanggal Request", "[Jenis Cuti]/[keterangan]"];
        // $detailSheet->getStyle('A2:H2')->applyFromArray($headerStyle);
        // $detailSheet->fromArray($headerContent,NULL,'A2');

        // $detailCutiData->map(function($item,$key) use ($detailSheet){
        //     $detailSheet->fromArray(array_merge([$key + 1],array_values($item->toArray())),NULL,'A' . ($key + 3));
        // });

        // $detailSheet->getColumnDimension('A')->setAutoSize(true);
        // $detailSheet->getColumnDimension('B')->setAutoSize(true);
        // $detailSheet->getColumnDimension('C')->setAutoSize(true);
        // $detailSheet->getColumnDimension('D')->setAutoSize(true);
        // $detailSheet->getColumnDimension('E')->setAutoSize(true);
        // $detailSheet->getColumnDimension('F')->setAutoSize(true);
        // $detailSheet->getColumnDimension('G')->setAutoSize(true);
        // $detailSheet->getColumnDimension('H')->setAutoSize(true);

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

        $rekapSheet->getStyle('A1:V1')->applyFromArray($titleStyle);
        $rekapSheet->getStyle('A2:V2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $rekapSheet->getStyle('A2:V2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $rekapSheet->getStyle('C2:V2')->getAlignment()->setWrapText(true);
        $rekapSheet->getStyle('C2:V2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $rekapSheet->setCellValue('B1','PT. SINERGY INFORMASI PRATAMA');
        $rekapSheet->setCellValue('D1','Report cuti per ' . Carbon::now()->format("d M Y"));

        $headerContent = ["No","NAMA","Tanggal Mulai Masuk","Hak Cuti ".date('Y', strtotime("-1 year")),"Sisa Cuti ".date('Y', strtotime("-1 year")),"Hak Cuti Tahunan","Cuti Bersama","Hak Cuti ". date('Y'),"Cuti yg Diminta","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Aug","Sep","Okt","Nov","Des"];
        $rekapSheet->getStyle('A2:U2')->applyFromArray($headerStyle);
        $rekapSheet->getStyle('E2')->getFont()->getColor()->setARGB("FF0B24FB");
        $rekapSheet->getStyle('F2')->getFont()->getColor()->setARGB("FF0B24FB");
        $rekapSheet->getStyle('U2')->getFont()->getColor()->setARGB("FF0B24FB");
        $rekapSheet->getStyle('W2')->getFont()->getColor()->setARGB("FF0B24FB");
//        $rekapSheet->getStyle('V2')->getFont()->getColor()->setARGB("FF0B24FB");

        $rekapSheet->getStyle('G2')->getFont()->getColor()->setARGB("FFF32229");
        $rekapSheet->fromArray($headerContent,NULL,'A2');

        // $jumlah_cuti = "7";
        
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
            })->whereRaw('`tb_cuti_detail`.`date_off` BETWEEN "' . $dateStart . '" AND "' . $dateEnd . '"')
            ->groupBy('nik');

        $dataLeavingPermit = User::select(
                'users.nik',
                DB::raw('`roles`.`name` AS `role`'),
                'users.name',
                'users.date_of_entry',
                DB::raw($total_cuti . ' AS `bersih_cuti_' . date('Y', strtotime("-1 year")) . '`'),
                DB::raw('`users`.`cuti` AS `sisah_cuti_' . date('Y', strtotime("-1 year")) . '`'),
                DB::raw($total_cuti . ' AS `total_cuti_' . date('Y') . '`'),
                DB::raw($cuti_bersama . ' AS `cuti_bersama_' . date('Y') . '`'),
                DB::raw('`users`.`cuti2` AS `bersih_cuti_' . date('Y') . '`'),
                DB::raw("IFNULL(`cuti_requested`.`counted`, 0) AS `request_cuti_" . date('Y') . "`"),
                DB::raw("`cuti` AS `cuti_now`"),
                DB::raw("`cuti2` AS `cuti_sisah`")
                // DB::raw($request_cuti . ' AS `request_cuti_' . date('Y') . '`')
            )->join('role_user','role_user.user_id','=','users.nik')
            ->join('roles','role_user.role_id','=','roles.id')
            ->leftJoinSub($dataLeavingPermitCount,'cuti_requested',function($join){
                $join->on('cuti_requested.nik','=','users.nik');
            })
//            ->orderBy('roles.index','DESC')
            ->orderBy('users.name','ASC')
            ->where('status_karyawan','<>','dummy')
            ->where('users.id_company','1')
            // ->where("users.nik","=",1170498100)
            // ->limit(1)
            ->get();

        $cuti_processed = DB::table(function($query) use ($dateStart,$dateEnd){
                $query->from('tb_cuti')
                    ->select(
                        DB::raw("RIGHT(`tb_cuti_detail`.`date_off`,2) AS `date_off`"),
                        "tb_cuti.nik",
                        DB::raw("MONTH(`tb_cuti_detail`.`date_off`) AS `month`")
                    )
                    ->join("tb_cuti_detail","tb_cuti_detail.id_cuti","=","tb_cuti.id_cuti")
                    ->where("tb_cuti.status","=","v")
                    // ->where("tb_cuti.nik","=",1170498100)
                    // ->whereRaw("`tb_cuti_detail`.`date_off` BETWEEN '2021-01-01' AND '2021-12-31'");
                    ->whereRaw('`tb_cuti_detail`.`date_off` BETWEEN "' . $dateStart . '" AND "' . $dateEnd . '"');
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
        $dataLeavingPermit->map(function($item,$key) use ($rekapSheet,$itemStyle,$cuti_summary){
            $item_filtered = array_values($item->toArray());
            print_r($item_filtered[10]+ $item_filtered[11]);
//            $total_sisah = array($item_filtered[10] + $item_filtered[11]);
            unset($item_filtered[0]);
            unset($item_filtered[1]);
            unset($item_filtered[10]);
            unset($item_filtered[11]);
            // print_r($item_filtered);
            $cuti_summary_individual = array_merge($cuti_summary[$item->nik]->pluck('summarize')->toArray());
            // array_push($cuti_summary_individual,$total_sisah);
            // print_r(
            //     array_merge(
            //         array_merge(
            //             [$key + 1],
            //             array_values($item_filtered)
            //             ),
            //         $cuti_summary_individual
            //     )
            // );
            $rekapSheet->fromArray(
                array_merge(
                    array_merge(
                        [$key + 1],
                        array_values($item_filtered)
                    ),
                    $cuti_summary_individual
                ),
                NULL,
                'A' . ($key + 3)
            );
            $item->cuti_summary = $cuti_summary[$item->nik]->pluck('summarize');
            $rekapSheet->getStyle('A' . ($key + 3) . ':U' . ($key + 3))->applyFromArray($itemStyle);
            $rekapSheet->getStyle('A' . ($key + 3) . ':U' . ($key + 3))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $rekapSheet->getStyle('C' . ($key + 3) . ':U' . ($key + 3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $rekapSheet->getStyle('C' . ($key + 3) . ':U' . ($key + 3))->getAlignment()->setWrapText(true);
            $rekapSheet->getStyle('C' . ($key + 3) . ':U' . ($key + 3))->getFont()->setBold(true);
            $rekapSheet->getStyle('J' . ($key + 3) . ':T' . ($key + 3))->getFont()->getColor()->setARGB("FFF32229");

            $rekapSheet->getStyle('G' . ($key + 3))->getFont()->getColor()->setARGB("FFF32229");

            // $rekapSheet->setCellValue('X' . ($key + 3),'=H'. ($key + 3) . '-I' . ($key + 3));
            // $rekapSheet->setCellValue('X' . ($key + 3),'=H'. ($key + 3) . '-I' . ($key + 3));

        });
        // echo "</pre>";

        // return ;
        // return $dataLeavingPermit;

        $rekapSheet->getColumnDimension('A')->setAutoSize(true);
        $rekapSheet->getColumnDimension('B')->setAutoSize(true);
        $rekapSheet->getColumnDimension('C')->setWidth(8);
        $rekapSheet->getColumnDimension('D')->setWidth(8);
        $rekapSheet->getColumnDimension('E')->setWidth(8);
        $rekapSheet->getColumnDimension('F')->setWidth(8);
        $rekapSheet->getColumnDimension('G')->setWidth(8);
        $rekapSheet->getColumnDimension('H')->setWidth(8);
        $rekapSheet->getColumnDimension('I')->setWidth(8);
        $rekapSheet->getColumnDimension('J')->setWidth(8);
        $rekapSheet->getColumnDimension('K')->setWidth(8);
        $rekapSheet->getColumnDimension('L')->setWidth(8);
        $rekapSheet->getColumnDimension('M')->setWidth(8);
        $rekapSheet->getColumnDimension('N')->setWidth(8);
        $rekapSheet->getColumnDimension('O')->setWidth(8);
        $rekapSheet->getColumnDimension('P')->setWidth(8);
        $rekapSheet->getColumnDimension('Q')->setWidth(8);
        $rekapSheet->getColumnDimension('R')->setWidth(8);
        $rekapSheet->getColumnDimension('S')->setWidth(8);
        $rekapSheet->getColumnDimension('T')->setWidth(8);
        $rekapSheet->getColumnDimension('U')->setWidth(8);
//        $rekapSheet->getColumnDimension('V')->setWidth(8);

        $spreadsheet->setActiveSheetIndex(0);

        $fileName = 'Report Cuti SIP & MSP '. date('F') .' '. date('Y') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);
        ob_end_clean();
        return $writer->save("php://output");
    }

    public function getWorkDays($startDate,$endDate){
        $client = new Client();

        $formattedStartDate = Carbon::parse($startDate)->toISOString();
        $formattedEndDate   = Carbon::parse($endDate)->toISOString();

//        $api_response = $client->get('https://www.googleapis.com/calendar/v3/calendars/en.indonesian%23holiday%40group.v.calendar.google.com/events?timeMin='. $formattedStartDate .'&timeMax='. $formattedEndDate .'&key=AIzaSyB0MWK6KLjhJlY7cL7G6STOCVGnxzjapXU');
        $api_response = $client->get('https://www.googleapis.com/calendar/v3/calendars/en.indonesian%23holiday%40group.v.calendar.google.com/events?timeMin='. $formattedStartDate .'&timeMax='. $formattedEndDate .'&key='.env('GCALENDAR_API_KEY'));
        // $api_response = $client->get('https://aws-cron.sifoma.id/holiday.php?key='.env('GOOGLE_API_KEY'));
        // $api_response = $client->get('https://aws-cron.sifoma.id/holiday.php?key=AIzaSyBNVCp8lA_LCRxr1rCYhvFIUNSmDsbcGno');
        $json = (string)$api_response->getBody();
        $holiday_indonesia = json_decode($json, true);

        $holiday_indonesia_final_detail = collect();
        $holiday_indonesia_final_details = collect();
        $holiday_indonesia_final_date = collect();
        $holiday_indonesia_final_dates = collect();
        // return $holiday_indonesia;
        
        foreach ($holiday_indonesia["items"] as $value) {
            // if(( ( $value["start"]["date"] >= $startDate ) && ( $value["start"]["date"] <= $endDate ) && (strstr($value['summary'], "Joint")) || ( $value["start"]["date"] >= $startDate ) && ( $value["start"]["date"] <= $endDate ) && ($value["summary"] == 'Boxing Day') )){
            //     $holiday_indonesia_final_detail->push(["start_date" => $value["start"]["date"],"activity" => $value["summary"]]);
            //     $holiday_indonesia_final_date->push($value["start"]["date"]);
            // }
            if(( (( $value["start"]["date"] >= $startDate ) && ( $value["start"]["date"] <= $endDate )) && (($value['summary'] == 'Idul Fitri Joint Holiday') || ($value['summary'] == 'Boxing Day')) )){
                $holiday_indonesia_final_details->push(["start_date" => $value["start"]["date"],"activity" => $value["summary"],"remarks" => "Cuti Bersama"]);
                $holiday_indonesia_final_dates->push($value["start"]["date"]);
            }
        }

        $holiday_indonesia_final_detail = $holiday_indonesia_final_detail->merge($holiday_indonesia_final_details);

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

    //baru
    public function getFilterCom(Request $request)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $cek_role = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.name','roles.name as name_role','group')->where('user_id',$nik)->first();

        if ($request->id == 'all_lis') {
            $cuti_index = DB::table('users')
                ->join('tb_cuti','tb_cuti.nik','=','users.nik')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('role_user as ru', 'users.nik', 'ru.user_id')
                ->join('roles as r', 'ru.role_id', 'r.id')
                ->select('users.nik','users.date_of_entry','users.name','r.name as id_division',
                    'users.cuti',DB::raw('COUNT(tb_cuti_detail.id_cuti) as niks'),DB::raw('DATEDIFF(NOW(),date_of_entry) AS date_of_entrys'),'users.email','users.cuti2','users.status_karyawan')
                ->groupBy('users.nik', 'users.date_of_entry', 'users.name', 'r.name',
                    'users.cuti', 'users.email', 'users.cuti2', 'users.status_karyawan')
                ->where('status_karyawan','!=','dummy');

            $cuti_list = DB::table('users')
                ->join('role_user as ru', 'users.nik', 'ru.user_id')
                ->join('roles as r', 'ru.role_id', 'r.id')
                ->select('users.nik','users.name','users.cuti','r.name as id_division','users.date_of_entry',DB::raw('DATEDIFF(NOW(),date_of_entry) AS date_of_entrys'),'users.email','users.cuti2','users.status_karyawan')
                ->where('status_karyawan','!=','dummy')
                ->whereNotIn('nik',function($query) { 
                    $query->select('nik')->from('tb_cuti');
                });

            if ($request->filter_com == 'all') {
                $cuti_index = $cuti_index->get();
                $cuti_list = $cuti_list->get();
            } else {
                $cuti_index = $cuti_index
                    ->where('users.id_company',$request->filter_com)->get();
                $cuti_list = $cuti_list
                    ->where('users.id_company',$request->filter_com)->get();
            }

            return array("data"=>$cuti_index->merge($cuti_list));
        } elseif ($request->id == 'request') {
            $getCutiDetail = Cuti::join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')->select(DB::raw('group_concat(date_off) as dates'),'nik','tb_cuti.id_cuti',DB::raw('COUNT(`tb_cuti_detail`.`id_cuti`) as days'))->where('tb_cuti_detail.status','NEW')->groupBy('id_cuti');

            // return $getCutiDetail->get();

            $data = Cuti::join('users','users.nik','=','tb_cuti.nik')
                    ->joinSub($getCutiDetail, 'total_cuti',function($join){
                        $join->on("total_cuti.id_cuti", '=', 'tb_cuti.id_cuti');
                    })
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->leftJoin('role_user','role_user.user_id','users.nik')->leftJoin('roles','roles.id','role_user.role_id')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division',
                        'roles.name as id_division',
                        'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason','total_cuti.days','users.cuti','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
                    ->orderBy('date_req','DESC')
                    // ->groupby('tb_cuti.id_cuti')
                    ->whereYear('date_req',date('Y')) 
                    ->whereRaw("(`tb_cuti`.`status` = 'R' OR `tb_cuti`.`status` = 'n')")
                    ->where('tb_cuti_detail.status','NEW');

            if ($request->filter_com == 'all') {

                if($div == 'SALES' && $pos == 'MANAGER'){
                    $data = $data
                        ->where('users.id_company',$request->filter_com)
                        ->where('id_territory', $ter);
                }  elseif ($cek_role->group == 'Solutions & Partnership Management') {
                    if ($cek_role->name_role == 'VP Solutions & Partnership Management') {
                        $data = $data->where('group','Solutions & Partnership Management');
                    } elseif($cek_role->name_role == 'Application Development Specialist Manager'){
                        $data = $data->whereRaw("(`mini_group` = 'Application Development Specialist' OR `tb_cuti`.`nik` = $nik)");
                        // ->where('mini_group','Application Development')-;
                    } elseif($cek_role->name_role == 'Product Development Specialist Manager'){
                        $data = $data
                        ->where('mini_group','Product Development Specialist');
                    } else {
                        $data = $data->where('users.nik',$nik);
                    }
                    
                } elseif ($cek_role->group == 'Program & Project Management') {
                    if ($cek_role->name_role == 'VP Program & Project Management') {
                        $data = $data->whereRaw("(`group` = 'Program & Project Management')");
                        // ->where('group','Project Management')->orWhere('group','Human Capital');
                    } elseif($cek_role->name_role == 'Project Management Office Manager'){
                        $data = $data
                        ->where('mini_group','Project Management Office');
                    }elseif ($cek_role->name_role == 'Service Desk Center Manager'){
                        $data = $data
                            ->where('mini_group','Service Desk Center');
                    } else {
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
                    if ($cek_role->name_role == 'Organizational & People Development Manager') {
                        $data = $data
                        ->where('mini_group','Organizational & People Development');
                    } elseif($cek_role->name_role == 'People Operations & Services Manager'){
                        $data = $data;
                    }  elseif($cek_role->name_role == 'VP Human Capital Management'){
                        $data = $data
                        ->where('group','Human Capital Management');
                    } else {
                        $data = $data->where('users.nik',$nik);
                    }
                } elseif($div == 'FINANCE' && $pos == 'MANAGER'){
                    $data = $data
                        ->where('users.id_division','FINANCE');
                } else if($cek_role->name_role == 'Chief Operating Officer'){
                    $data =  $data->where('roles.name','like','VP%')->orWhere('users.nik',$nik);
                        // ->get();
                }elseif ($cek_role->name_role == 'Chief Executive Officer') {
                    $data = $data->whereRaw("(`roles`.`name` = 'Chief Operating Officer' OR `roles`.`name` = 'VP Sales')");
                } else{
                    $data = $data
                        ->where('users.nik',$nik);
                        // ->get();
                }
            } else {
                // if ($ter != NULL) {
                    if($div == 'SALES' && $pos == 'MANAGER'){
                        $data = $datas
                            ->where('users.id_company',$request->filter_com)
                            ->where('id_territory', $ter);
                    }  elseif ($cek_role->group == 'Solutions & Partnership Management') {
                        if ($cek_role->name_role == 'VP Solutions & Partnership Management') {
                            $data = $data->where('group','Solutions & Partnership Management');
                        } elseif($cek_role->name_role == 'Application Development Specialist Manager'){
                            $data = $data->whereRaw("(`mini_group` = 'Application Development Specialist' OR `tb_cuti`.`nik` = $nik)");
                            // ->where('mini_group','Application Development')-;
                        } elseif($cek_role->name_role == 'Product Development Specialist Manager'){
                            $data = $data
                            ->where('mini_group','Product Development Specialist');
                        } else {
                            $data = $data->where('users.nik',$nik);
                        }
                        
                    } elseif ($cek_role->group == 'Program & Project Management') {
                        if ($cek_role->name_role == 'VP Program & Project Management') {
                            $data = $data->whereRaw("(`group` = 'Program & Project Management')");
                            // ->where('group','Project Management')->orWhere('group','Human Capital');
                        } elseif($cek_role->name_role == 'Project Management Office Manager'){
                            $data = $data
                            ->where('mini_group','Project Management Office');
                        }elseif ($cek_role->name_role == 'Service Desk Center Manager'){
                            $data = $data
                                ->where('mini_group','Service Desk Center');
                        } else {
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
                            $cuti = $cuti
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
                        if ($cek_role->name_role == 'Organizational & People Development Manager') {
                            $data = $data
                            ->where('mini_group','Organizational & People Development');
                        } elseif($cek_role->name_role == 'People Operations & Services Manager'){
                            $data = $data;
                        } elseif ( $cek_role->name_role = 'VP Human Capital Management'){
                            $data = $data;
                        }else {
                            $data = $data->where('users.nik',$nik);
                        }
                    } elseif($div == 'FINANCE' && $pos == 'MANAGER'){
                        $data = $data
                            ->where('users.id_division','FINANCE');
                    } else if($cek_role->name_role == 'Chief Operating Officer'){
                        $data = $data->where('roles.name','like','VP%')->orWhere('users.nik',$nik);
                            // ->get();
                    }elseif ($cek_role->name_role == 'Chief Executive Officer') {
                        $data = $data->whereRaw("(`roles`.`name` = 'Chief Operating Officer' OR `roles`.`name` = 'VP Sales' OR `roles`.`name` = 'VP Financial & Accounting')");
                    } else{
                        $data = $data
                            ->where('users.nik',$nik);
                            // ->get();
                    }
                // } 
            }

            return array("data"=>$data->distinct()->get());
        } else if ($request->id == 'report_') {
            $cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division',
                        DB::raw("(CASE WHEN (users.id_division = 'TECHNICAL' AND id_territory = 'OPERATION') THEN 'OPERATION'  WHEN (users.id_position = 'ENGINEER STAFF' OR users.id_position = 'ENGINEER MANAGER' OR users.id_position = 'ENGINEER SPV' OR users.id_position = 'ENGINEER CO-SPV') THEN 'SID'  WHEN (users.id_division = 'TECHNICAL PRESALES' ) THEN 'SOL' ELSE users.id_division END) as id_division"),
                        'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti','tb_cuti.pic','tb_cuti.updated_at')
                    ->where('date_off', '>=', $request->start)
                    ->where('date_off', '<=', $request->end)
                    ->groupby('tb_cuti.id_cuti');
            if ($request->filter_com != 'all') {
                $cuti = $cuti->where('users.id_company',$request->filter_com);
            } 
            if ($request->division != "alldeh") {
                $cuti = $cuti->where('users.id_division',$request->division);
            }

            return $cuti->get();
        } else {
            $tb_cuti_filtered = DB::table('tb_cuti_detail')
                ->where('status','=','ACCEPT');

            $cuti = Cuti::join('users','users.nik','=','tb_cuti.nik')
                    ->joinSub($tb_cuti_filtered, 'tb_cuti_detail_filterd', function ($join) {
                        $join->on('tb_cuti_detail_filterd.id_cuti','=','tb_cuti.id_cuti');
                    })
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason','users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at', 
                        DB::raw("(CASE WHEN (users.id_division = 'TECHNICAL' AND id_territory = 'OPERATION') THEN 'OPERATION'  WHEN (users.id_position = 'ENGINEER STAFF' OR users.id_position = 'ENGINEER MANAGER' OR users.id_position = 'ENGINEER SPV' OR users.id_position = 'ENGINEER CO-SPV') THEN 'SID'  WHEN (users.id_division = 'TECHNICAL PRESALES' ) THEN 'SOL' ELSE users.id_division END) as id_division"),
                        DB::raw('COUNT(`tb_cuti_detail_filterd`.`id_cuti`) as days'))
                    ->orderBy('tb_cuti.date_req','DESC')
                    ->groupby('id_cuti');

            if ($request->division != null) {
               if ($request->division == 'alldeh') {
                    $cuti = $cuti->get();
                }else{
                    $cuti = $cuti
                        ->where('tb_division.id_division',$request->division)
                        ->get();
                }
            }else{
                if ($ter != NULL) {
                    if($div == 'SALES' && $pos == 'MANAGER'){
                        $cuti = $cuti
                            ->where('users.id_company',$request->filter_com)
                            ->where('id_territory', $ter)
                            ->get();
                    } elseif ($div == 'TECHNICAL' && $pos == 'ENGINEER MANAGER' && $ter == 'DPG') {
                        $cuti = $cuti
                            ->where('users.id_company',$request->filter_com)
                            ->where('users.id_division','TECHNICAL')
                            ->where('users.id_territory','DPG')
                            ->get();
                    } elseif ($div == 'BCD' && $ter == 'OPERATION' && $pos == 'MANAGER') {
                        $cuti = $cuti
                            ->where('users.id_company',$request->filter_com)
                            ->whereRaw("(`users`.`id_division` = 'BCD')")
                            ->get();
                    } elseif ($div == 'MSM' && $ter == 'OPERATION' && $pos == 'MANAGER') {
                        $cuti = $cuti
                            ->where('users.id_company',$request->filter_com)
                            ->where('users.id_division','MSM')
                            ->get();
                    } elseif ($pos == 'OPERATION DIRECTOR') {
                        $cuti = $cuti
                            ->where('users.id_company',$request->filter_com)
                            ->where('users.id_position','MANAGER')
                            ->where('users.id_territory','OPERATION')
                            ->orwhere('users.id_position','OPERATION DIRECTOR')
                            ->orwhere('users.id_division','WAREHOUSE')
                            ->orwhere('users.id_division','PROCUREMENT')
                            ->get();
                    } elseif($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER'){
                        $cuti = $cuti
                            ->where('users.id_company',$request->filter_com)
                            ->where('users.id_territory','PRESALES')
                            ->get();
                    } elseif($div == 'FINANCE' && $pos == 'MANAGER'){
                        $cuti = $cuti
                            ->where('users.id_company',$request->filter_com)
                            ->where('users.id_division','FINANCE')
                            ->get();
                    }  else if($cek_role->name_role == 'Chief Operating Officer'){
                        $cuti = $cuti
                            ->where('users.id_company',$request->filter_com)
                            ->get();
                    }else{
                        $cuti = $cuti
                            ->where('users.id_company',$request->filter_com)
                            ->where('users.nik',$nik)
                            ->get();
                    }
                    
                } elseif ($div == 'HR' && $pos == 'HR MANAGER' ) {
                    $cuti = $cuti
                        ->where('users.id_company',$request->filter_com)
                        ->get();
                } elseif ($pos == 'DIRECTOR') {
                    $cuti = $cuti
                        ->where('users.id_company',$request->filter_com)
                        // ->whereRaw("(`users`.`id_position` = 'MANAGER' AND `users`.`id_division` = 'SALES')")->orWhereRaw("(`users`.`id_position` = 'MANAGER' AND `users`.`id_division` = 'TECHNICAL' AND `users`.`id_territory` is null) ")
                        ->get();
                } elseif($div == 'TECHNICAL DVG' && $pos == 'STAFF' || $div == 'TECHNICAL DPG' && $pos == 'ENGINEER STAFF' || $div == 'TECHNICAL PRESALES' && $pos == 'STAFF' || $div == 'FINANCE' && $pos == 'STAFF' || $div == 'PMO' && $pos == 'STAFF' || $pos == 'ADMIN' || $div == 'HR' && $pos == 'STAFF GA' || $div == 'HR' && $pos == 'HR STAFF' || $pos == 'STAFF HR'){
                        $cuti = $cuti
                            ->where('users.id_company',$request->filter_com)
                            ->where('users.nik',$nik)
                            ->get();
                } elseif ($div == 'TECHNICAL' && $pos == 'MANAGER') {  
                    $cuti = $cuti
                            ->where('users.id_company',$request->filter_com)
                            ->get();
                } else {
                    $cuti = $cuti
                        ->where('users.id_company',$request->filter_com)
                        ->get();
                }
                   
            }

            

            return array("data"=>$cuti);
        }
        
    }

    public function get_history_cuti(Request $request)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        // return $request->division;

        $cek_role = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.name','roles.name as name_role','group')->where('user_id',$nik)->first();

        if ($request->com == 'all') {
            $com = ['1','2'];
        }else{
            $com = $request->com;
        }

        $tb_cuti_filtered = DB::table('tb_cuti_detail');

        $getCutiDetail = Cuti::join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')->select(DB::raw('COUNT(`tb_cuti_detail`.`id_cuti`) as days'),'nik','tb_cuti.id_cuti')->groupBy('tb_cuti_detail.id_cuti');
        // return $getCutiDetail->get();

        $cuti = Cuti::join('users','users.nik','=','tb_cuti.nik')
                    ->joinSub($getCutiDetail, 'total_cuti',function($join){
                        $join->on("total_cuti.id_cuti", '=', 'tb_cuti.id_cuti');
                    })
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','tb_cuti.id_cuti')
                    ->leftJoin('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')
                    ->select('users.nik','users.name','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason','tb_cuti.pic','tb_cuti.updated_at','roles.name as id_division','total_cuti.days')
                    ->orderByRaw('FIELD(tb_cuti.status, "n", "v", "c", "d")')               
                    ->orderBy('tb_cuti.date_req','DESC')
                    ->where('users.id_company',$com)
                    ->where('status_karyawan','!=','dummy');


        if ($request->division == "alldeh") {
            // if ($ter != NULL) {
                if($div == 'SALES' && $pos == 'MANAGER'){
                    $cuti = $cuti
                        ->where('id_territory', $ter);
                } elseif ($cek_role->group == 'Solutions & Partnership Management') {
                    if ($cek_role->name_role == 'VP Solutions & Partnership Management') {
                        $cuti = $cuti
                        ->where('group','Solutions & Partnership Management');
                    } elseif($cek_role->name_role == 'Application Development Specialist Manager'){
                        $cuti = $cuti
                        ->where('mini_group','Application Development Specialist');
                    } elseif($cek_role->name_role == 'Product Development Specialist Manager'){
                        $cuti = $cuti
                        ->where('mini_group','Product Development Specialist');
                    } else {
                        $cuti = $cuti->where('users.nik',$nik);
                    }
                    
                } elseif ($cek_role->group == 'Program & Project Management') {
                    if ($cek_role->name_role == 'VP Program & Project Management') {
                        $cuti = $cuti
                        ->where('group','Program & Project Management');
                    } elseif($cek_role->name_role == 'Project Management Office Manager'){
                        $cuti = $cuti
                        ->where('mini_group','Project Management Office');
                    }elseif ($cek_role->name_role == 'Service Desk Center Manager'){
                        $cuti = $cuti
                            ->where('mini_group','Service Desk Center');
                    }else {
                        $cuti = $cuti->where('users.nik',$nik);
                    }

                } elseif ($cek_role->group == 'Synergy System Management') {
                    if ($cek_role->name_role == 'VP Synergy System Management') {
                        $cuti = $cuti
                        ->where('group','Synergy System Management');
                    } elseif($cek_role->name_role == 'Synergy System & Services Manager'){
                        $cuti = $cuti
                        ->where('mini_group','Synergy System & Services');
                    } elseif($cek_role->name_role == 'Synergy System Architecture Manager'){
                        $cuti = $cuti
                        ->where('mini_group','Synergy System Architecture');
                    } elseif($cek_role->name_role == 'Synergy System Delivery Manager'){
                        $cuti = $cuti
                        ->where('mini_group','Synergy System Delivery');
                    }else {
                        $cuti = $cuti->where('users.nik',$nik);
                    }

                } elseif ($cek_role->group == 'Internal Chain Management') {
                    if ($cek_role->name_role == 'VP Internal Chain Management') {
                        $cuti = $cuti
                        ->where('group','Internal Chain Management');
                    } elseif($cek_role->name_role == 'Supply Chain & IT Support Manager'){
                        $cuti = $cuti
                        ->where('mini_group','Supply Chain & IT Support');
                    } elseif($cek_role->name_role == 'Internal Operation Support Manager'){
                        $cuti = $cuti
                        ->where('mini_group','Internal Operation Support');
                    } elseif($cek_role->name_role == 'Supply Chain Manager'){
                        $cuti = $cuti
                        ->where('mini_group','Supply Chain Management');
                    }else {
                        $cuti = $cuti->where('users.nik',$nik);
                    }

                } elseif ($cek_role->group == 'Human Capital Management') {
                    if ($cek_role->name_role == 'Organizational & People Development Manager') {
                        $cuti = $cuti
                        ->where('mini_group','Organizational & People Development');
                    } elseif($cek_role->name_role == 'People Operations & Services Manager' || $cek_role->name_role == 'VP Human Capital Management'){
                        $cuti = $cuti->where('date_off', '>=', $request->start_date)
                            ->where('date_off', '<=', $request->end_date);
                    }else {
                        $cuti = $cuti->where('users.nik',$nik);
                    }

                } elseif($div == 'FINANCE' && $pos == 'MANAGER'){
                    $cuti = $cuti
                        ->where('users.id_division','FINANCE');
                } else if($cek_role->name_role == 'Chief Operating Officer' || $cek_role->name_role == 'Chief Executive Officer'){
                     $cuti = $cuti;
                        // ->where('date_off', '>=', $request->start_date)
                        // ->where('date_off', '<=', $request->end_date);
                        // ->get();
                }else{
                    $cuti = $cuti
                        ->where('users.nik',$nik);
                        // ->get();
                }
            // } 
            // elseif ($div == 'HR' && $pos == 'HR MANAGER' || $pos == 'DIRECTOR' || $div == 'TECHNICAL' && $pos == 'MANAGER') {
            //     $cuti = $cuti
            //         ->where('date_off', '>=', $request->start_date)
            //         ->where('date_off', '<=', $request->end_date)
            //         ->get();
            // } elseif($div == 'TECHNICAL DVG' && $pos == 'STAFF' || $div == 'TECHNICAL DPG' && $pos == 'ENGINEER STAFF' || $div == 'TECHNICAL PRESALES' && $pos == 'STAFF' || $div == 'FINANCE' && $pos == 'STAFF' || $div == 'PMO' && $pos == 'STAFF' || $pos == 'ADMIN' || $div == 'HR' && $pos == 'STAFF GA' || $div == 'HR' && $pos == 'HR STAFF' || $pos == 'STAFF HR'){
            //         $cuti = $cuti
            //             ->where('users.nik',$nik)
            //             ->get();
            // } else {
            //     $cuti = $cuti
            //         ->get();
            // }
        }else{
            if ($div == 'HR' && $pos == 'HR MANAGER' ) {
                $cuti = $cuti
                ->where('date_off', '>=', $request->start_date)
                ->where('date_off', '<=', $request->end_date)
                ->where('users.id_division',$request->division); 
            }
            // else{
            //     $cuti = $cuti
            //     ->where('users.id_division',$request->division)
            //     ->get(); 
                
            // }           
                  
        }
        return array("data"=>$cuti->distinct()->get());
    }

    public function get_list_cuti(Request $request)
    {

        $cuti_index = DB::table('users')
            ->join('tb_cuti','tb_cuti.nik','=','users.nik')
            ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
            ->join('role_user as ru', 'users.nik', 'ru.user_id')
            ->join('roles as r', 'ru.role_id', 'r.id')
            ->select('users.nik','users.date_of_entry','users.name','r.name as id_division',
                'users.cuti',DB::raw('COUNT(tb_cuti_detail.id_cuti) as niks'),DB::raw('DATEDIFF(NOW(),date_of_entry) AS date_of_entrys'),'users.email','users.cuti2','users.status_karyawan')
            ->groupBy('users.nik', 'users.date_of_entry', 'users.name', 'r.name',
                'users.cuti', 'users.email', 'users.cuti2', 'users.status_karyawan')
            ->where('status_karyawan','!=','dummy')
            ->get();

        $cuti_list = DB::table('users')
            ->join('role_user as ru', 'users.nik', 'ru.user_id')
            ->join('roles as r', 'ru.role_id', 'r.id')
            ->select('users.nik','users.name','r.name as id_division',
                'users.cuti','users.date_of_entry',DB::raw('DATEDIFF(NOW(),date_of_entry) AS date_of_entrys'),'users.email','users.cuti2','users.status_karyawan')
            ->where('status_karyawan','!=','dummy')
            ->whereNotIn('nik',function($query) {
                $query->select('nik')->from('tb_cuti');
            })
            ->get();

        return array("data"=>$cuti_index->merge($cuti_list));
    }

    //lama
    // public function get_request_cuti_byMonth(Request $request)
    // {
    //     $nik = Auth::User()->nik;
    //     $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
    //     $ter = $territory->id_territory;
    //     $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
    //     $div = $division->id_division;
    //     $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
    //     $pos = $position->id_position;

    //     if ($ter != NULL) {
    //         if($div == 'SALES' && $pos == 'MANAGER'){
    //             return array("data"=>Cuti::join('users','users.nik','=','tb_cuti.nik')
    //                 ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //                 ->join('tb_position','tb_position.id_position','=','users.id_position')
    //                 ->join('tb_division','tb_division.id_division','=','users.id_division')
    //                 ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
    //                 ->orderBy('date_req','DESC')
    //                 ->groupby('tb_cuti.id_cuti')
    //                 ->where('id_territory', $ter)
    //                 ->where('tb_cuti.status','n')
    //                 ->groupby('nik')
    //                 ->get());
    //         } elseif ($div == 'TECHNICAL' && $pos == 'ENGINEER MANAGER' && $ter == 'DPG') {
    //             return array("data"=>Cuti::join('users','users.nik','=','tb_cuti.nik')
    //                 ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //                 ->join('tb_position','tb_position.id_position','=','users.id_position')
    //                 ->join('tb_division','tb_division.id_division','=','users.id_division')
    //                 ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
    //                 ->orderBy('date_req','DESC')
    //                 ->groupby('tb_cuti.id_cuti')
    //                 ->where('users.id_division','TECHNICAL')
    //                 ->where('users.id_territory','DPG')
    //                 ->where('tb_cuti.status','n')
    //                 ->groupby('nik')
    //                 ->get());
    //         } elseif ($div == 'TECHNICAL' && $ter == 'DVG' && $pos == 'MANAGER') {
    //             return array("data"=>Cuti::join('users','users.nik','=','tb_cuti.nik')
    //                 ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //                 ->join('tb_position','tb_position.id_position','=','users.id_position')
    //                 ->join('tb_division','tb_division.id_division','=','users.id_division')
    //                 ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
    //                 ->orderBy('date_req','DESC')
    //                 ->groupby('tb_cuti.id_cuti')
    //                 ->whereRaw("(`users`.`id_division` = 'TECHNICAL' AND `users`.`id_territory` = 'DVG'  AND `users`.`id_company` = '1' AND `tb_cuti`.`status` = 'n')")->orwhereRaw("(`users`.`id_position` = 'WAREHOUSE'  AND `users`.`id_company` = '1' AND `tb_cuti`.`status` = 'n')")
    //                 ->groupby('nik')
    //                 ->get());
    //         }elseif ($div == 'PMO' && $ter == 'OPERATION' && $pos == 'MANAGER') {
    //             return array("data" => Cuti::join('users','users.nik','=','tb_cuti.nik')
    //                 ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //                 ->join('tb_position','tb_position.id_position','=','users.id_position')
    //                 ->join('tb_division','tb_division.id_division','=','users.id_division')
    //                 ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
    //                 ->orderBy('date_req','DESC')
    //                 ->groupby('tb_cuti.id_cuti')
    //                 ->where('users.id_division','PMO')
    //                 ->where('tb_cuti.status','n')
    //                 ->groupby('nik')
    //                 ->get());
    //         } elseif ($div == 'MSM' && $ter == 'OPERATION' && $pos == 'MANAGER') {
    //             return array("data" => Cuti::join('users','users.nik','=','tb_cuti.nik')
    //                 ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //                 ->join('tb_position','tb_position.id_position','=','users.id_position')
    //                 ->join('tb_division','tb_division.id_division','=','users.id_division')
    //                 ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
    //                 ->orderBy('date_req','DESC')
    //                 ->groupby('tb_cuti.id_cuti')
    //                 ->where('users.id_division','MSM')
    //                 ->where('tb_cuti.status','n')
    //                 ->groupby('nik')
    //                 ->get());
    //         } elseif ($pos == 'OPERATION DIRECTOR') {
    //             return array("data" => Cuti::join('users','users.nik','=','tb_cuti.nik')
    //                 ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //                 ->join('tb_position','tb_position.id_position','=','users.id_position')
    //                 ->join('tb_division','tb_division.id_division','=','users.id_division')
    //                 ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
    //                 ->orderBy('date_req','DESC')
    //                 ->groupby('tb_cuti.id_cuti')
    //                 ->where('users.id_position','MANAGER')
    //                 ->where('users.id_territory','OPERATION')
    //                 ->orwhere('users.id_position','OPERATION DIRECTOR')
    //                 ->orwhere('users.id_division','WAREHOUSE')
    //                 ->where('tb_cuti.status','n')
    //                 ->groupby('nik')
    //                 ->get());
    //         } elseif($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER'){
    //             return array("data"=>Cuti::join('users','users.nik','=','tb_cuti.nik')
    //                 ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //                 ->join('tb_position','tb_position.id_position','=','users.id_position')
    //                 ->join('tb_division','tb_division.id_division','=','users.id_division')
    //                 ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
    //                 ->orderBy('date_req','DESC')
    //                 ->groupby('tb_cuti.id_cuti')
    //                 ->where('tb_cuti.status','n')
    //                 ->where('users.id_territory','PRESALES')
    //                 ->groupby('nik')
    //                 ->get());
    //         } elseif($div == 'FINANCE' && $pos == 'MANAGER'){
    //             return array("data"=>Cuti::join('users','users.nik','=','tb_cuti.nik')
    //                 ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //                 ->join('tb_position','tb_position.id_position','=','users.id_position')
    //                 ->join('tb_division','tb_division.id_division','=','users.id_division')
    //                 ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
    //                 ->orderBy('date_req','DESC')
    //                 ->groupby('tb_cuti.id_cuti')
    //                 ->where('users.id_division','FINANCE')
    //                 ->where('tb_cuti.status','n')
    //                 ->groupby('nik')
    //                 ->get());
    //         }else{
    //             return array("data" => Cuti::join('users','users.nik','=','tb_cuti.nik')
    //                 ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //                 ->join('tb_position','tb_position.id_position','=','users.id_position')
    //                 ->join('tb_division','tb_division.id_division','=','users.id_division')
    //                 ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
    //                 ->orderBy('date_req','DESC')
    //                 ->groupby('tb_cuti.id_cuti')
    //                 ->where('tb_cuti.status','n')
    //                 ->where('users.nik',$nik)
    //                 ->groupby('nik')
    //                 ->get());
    //         }
    //     } elseif ($div == 'HR' && $pos == 'HR MANAGER' ) {
    //         return array("data" => Cuti::join('users','users.nik','=','tb_cuti.nik')
    //             ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //             ->join('tb_position','tb_position.id_position','=','users.id_position')
    //             ->join('tb_division','tb_division.id_division','=','users.id_division')
    //             ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
    //             ->orderBy('date_req','DESC')
    //             ->groupby('tb_cuti.id_cuti')
    //             ->where('tb_cuti.status','n')
    //             ->groupby('nik')
    //             ->get());
    //     } elseif ($pos == 'DIRECTOR') {

    //         return array("data"=>Cuti::join('users','users.nik','=','tb_cuti.nik')
    //                 ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //                 ->join('tb_position','tb_position.id_position','=','users.id_position')
    //                 ->join('tb_division','tb_division.id_division','=','users.id_division')
    //                 ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
    //                 ->orderBy('date_req','DESC')
    //                 ->groupby('tb_cuti.id_cuti')
    //                 ->whereRaw("(`users`.`id_position` = 'MANAGER' AND `users`.`id_division` = 'SALES' AND `tb_cuti`.`status` = 'n')")->orwhereRaw("(`users`.`id_position` = 'MANAGER' AND `users`.`id_division` = 'TECHNICAL' AND `users`.`id_territory` is null AND `tb_cuti`.`status` = 'n')")
    //                 ->groupby('nik')
    //                 ->get());
            
    //     } elseif($div == 'TECHNICAL DVG' && $pos == 'STAFF' || $div == 'TECHNICAL DPG' && $pos == 'ENGINEER STAFF' || $div == 'TECHNICAL PRESALES' && $pos == 'STAFF' || $div == 'FINANCE' && $pos == 'STAFF' || $div == 'PMO' && $pos == 'STAFF' || $pos == 'ADMIN' || $div == 'HR' && $pos == 'STAFF GA' || $div == 'HR' && $pos == 'STAFF HR'){
    //         return array("data" => Cuti::join('users','users.nik','=','tb_cuti.nik')
    //             ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //             ->join('tb_position','tb_position.id_position','=','users.id_position')
    //             ->join('tb_division','tb_division.id_division','=','users.id_division')
    //             ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
    //             ->orderBy('date_req','DESC')
    //             ->groupby('tb_cuti.id_cuti')
    //             ->where('tb_cuti.status','n')
    //             ->where('users.nik',$nik)
    //             ->groupby('nik')
    //             ->get());
    //     } elseif ($div == 'TECHNICAL' && $pos == 'MANAGER') {
    //         return array("data" => Cuti::join('users','users.nik','=','tb_cuti.nik')
    //             ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //             ->join('tb_position','tb_position.id_position','=','users.id_position')
    //             ->join('tb_division','tb_division.id_division','=','users.id_division')
    //             ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
    //             ->where('users.id_division','WAREHOUSE')
    //             ->where('users.id_position','ENGINEER MANAGER')
    //             ->orwhere('users.id_position','MANAGER')
    //             ->orderBy('date_req','DESC')
    //             ->groupby('tb_cuti.id_cuti')
    //             ->where('tb_cuti.status','n')
    //             ->where('users.id_company', '1')
    //             ->groupby('nik')
    //             ->get());
    //     } else {
    //         return array("data" => Cuti::join('users','users.nik','=','tb_cuti.nik')
    //                 ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
    //                 ->join('tb_position','tb_position.id_position','=','users.id_position')
    //                 ->join('tb_division','tb_division.id_division','=','users.id_division')
    //                 ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti',DB::raw('COUNT(tb_cuti.id_cuti) as niks'),DB::raw('group_concat(date_off) as dates'),'users.id_position','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
    //                 ->orderBy('date_req','DESC')
    //                 ->groupby('tb_cuti.id_cuti')
    //                 ->where('tb_cuti.status','n')
    //                 ->groupby('nik')
    //                 ->get());
    //     }
        
    // }

    //baru
    public function get_request_cuti_byMonth(Request $request)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $cek_role = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.name','roles.name as name_role','group')->where('user_id',$nik)->first();

        $getCutiDetail = Cuti::join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')->select(DB::raw('group_concat(date_off) as dates'),'nik','tb_cuti.id_cuti',DB::raw('COUNT(`tb_cuti_detail`.`id_cuti`) as days'))->where('tb_cuti_detail.status','NEW')->groupBy('id_cuti');

        // return $getCutiDetail->get();

        $data = Cuti::join('users','users.nik','=','tb_cuti.nik')
                    ->joinSub($getCutiDetail, 'total_cuti',function($join){
                        $join->on("total_cuti.id_cuti", '=', 'tb_cuti.id_cuti');
                    })
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->leftJoin('role_user','role_user.user_id','users.nik')
                    ->leftJoin('roles','roles.id','role_user.role_id')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division',
                        'roles.name as id_division',
                        'tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason','total_cuti.days','users.cuti','users.email','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
                    ->orderBy('date_req','DESC')
                    // ->groupby('tb_cuti.id_cuti')
                    ->whereYear('date_req',date('Y')) 
                    ->whereRaw("(`tb_cuti`.`status` = 'R' OR `tb_cuti`.`status` = 'n')")
                    ->where('tb_cuti_detail.status','NEW');

        if($div == 'SALES' && $pos == 'MANAGER'){
            $data = $data->where('id_territory', $ter);
        } elseif ($cek_role->group == 'Solutions & Partnership Management') {
            if ($cek_role->name_role == 'VP Solutions & Partnership Management') {
                $data = $data->where('group','Solutions & Partnership Management');
            } elseif($cek_role->name_role == 'Application Development Specialist Manager'){
                // $data = $data
                $data = $data->whereRaw("(`mini_group` = 'Application Development Specialist')");
            } elseif($cek_role->name_role == 'Product Development Specialist Manager'){
                $data = $data->where('mini_group','Product Development Specialist');
            } else {
                $data = $data->where('users.nik',$nik);
            }
            
        } elseif ($cek_role->group == 'Program & Project Management') {
            if ($cek_role->name_role == 'VP Program & Project Management') {
                $data = $data->whereRaw("(`group` = 'Program & Project Management')");
                // ->where('group','Project Management')->orWhere('group','Human Capital');
            } elseif($cek_role->name_role == 'Project Management Office Manager'){
                $data = $data->where('mini_group','Project Management Office');
            }elseif ($cek_role->name_role == 'Service Desk Center Manager'){
                $data = $data
                    ->where('mini_group','Service Desk Center');
            }else {
                $data = $data->where('users.nik',$nik);
            }
        } elseif ($cek_role->group == 'Synergy System Management') {
            if ($cek_role->name_role == 'VP Synergy System Management') {
                $data = $data->where('group','Synergy System Management');
            } elseif($cek_role->name_role == 'Synergy System & Services Manager'){
                $data = $data->where('mini_group','Synergy System & Services');
            } elseif($cek_role->name_role == 'Synergy System Architecture Manager'){
                $data = $data->where('mini_group','Synergy System Architecture');
            } elseif($cek_role->name_role == 'Synergy System Delivery Manager'){
                $data = $data->where('mini_group','Synergy System Delivery');
            }else {
                $data = $data->where('users.nik',$nik);
            }
        } elseif ($cek_role->group == 'Internal Chain Management') {
            if ($cek_role->name_role == 'VP Internal Chain Management') {
                $data = $data->where('group','Internal Chain Management');
            } elseif($cek_role->name_role == 'Supply Chain & IT Support Manager'){
                $data = $data->where('mini_group','Supply Chain & IT Support');
            } elseif($cek_role->name_role == 'Internal Operation Support Manager'){
                $data = $data->where('mini_group','Internal Operation Support');
            } elseif($cek_role->name_role == 'Supply Chain Manager'){
                $data = $data->where('mini_group','Supply Chain Management');
            }else {
                $data = $data->where('users.nik',$nik);
            }
        } elseif ($cek_role->group == 'Human Capital Management') {
            if ($cek_role->name_role == 'Organizational & People Development Manager') {
                $data = $data->where('mini_group','Organizational & People Development');
            } elseif($cek_role->name_role == 'People Operations & Services Manager'){
                $data = $data;
            } elseif($cek_role->name_role == 'VP Human Capital Management'){
                $data = $data->where('group','Human Capital Management');
            }else {
                $data = $data->where('users.nik',$nik);
            }
        } elseif($div == 'FINANCE' && $pos == 'MANAGER'){
            $data = $data->where('users.id_division','FINANCE');
        } else if($cek_role->name_role == 'Chief Operating Officer'){
            $data = $data->where('roles.name','like','VP%')->orWhere('users.nik',$nik);
                // ->get();
        }elseif ($cek_role->name_role == 'Chief Executive Officer') {
            $data = $data->whereRaw("(`roles`.`name` = 'Chief Operating Officer' OR `roles`.`name` = 'VP Sales' OR `roles`.`name` = 'VP Financial & Accounting')");
        } else{
            $data = $data->where('users.nik',$nik);
                // ->get();
        }

        // if ($ter != NULL) {
            // if($div == 'SALES' && $pos == 'MANAGER'){
            //     $data = $data->where('id_territory', $ter);
            // } elseif ($div == 'TECHNICAL' && $pos == 'ENGINEER MANAGER' && $ter == 'DPG') {

            // } elseif ($div == 'BCD' && $ter == 'OPERATION' && $pos == 'MANAGER') {

            // } elseif ($div == 'PMO' && $ter == 'OPERATION' && $pos == 'MANAGER') {

            // } elseif ($div == 'MSM' && $ter == 'OPERATION' && $pos == 'MANAGER') {

            // } elseif ($pos == 'OPERATION DIRECTOR') {

            // } elseif($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER'){

            // } elseif($div == 'FINANCE' && $pos == 'MANAGER'){
            //     $data = $data->where('users.id_division','FINANCE');
            // } elseif ($cek_role->name_role == 'Chief Operating Officer') {
            //     $data = $data->whereRaw("(`users`.`id_position` = 'ENGINEER MANAGER' OR `users`.`id_position` = 'MANAGER' AND `users`.`id_territory` = 'DVG' OR `users`.`id_position` = 'MANAGER' AND `users`.`id_territory` = 'PRESALES' OR `users`.`id_position` = 'MANAGER' AND `users`.`id_territory` = 'OPERATION' OR `users`.`id_position` = 'HR MANAGER')")->whereRaw("(`tb_cuti`.`status` = 'n' OR `tb_cuti`.`status` = 'R')");
            // }else{
            //     $data = $data->where('users.nik',$nik);
            // }
        // } 
        // elseif ($div == 'HR' && $pos == 'HR MANAGER' ) {
        //     $data = $data;
        // } elseif ($pos == 'DIRECTOR') {
        //     $data = $data->whereRaw("(`users`.`id_position` = 'MANAGER' AND `users`.`id_division` = 'SALES' OR `users`.`id_position` = 'MANAGER' AND `users`.`id_division` = 'FINANCE' OR `users`.`id_position` = 'MANAGER' AND `users`.`id_division` = 'TECHNICAL' AND `users`.`id_territory` = 'OPERATION')")->whereRaw("(`tb_cuti`.`status` = 'n' OR `tb_cuti`.`status` = 'R')");
            
        // } elseif($div == 'TECHNICAL DVG' && $pos == 'STAFF' || $div == 'TECHNICAL DPG' && $pos == 'ENGINEER STAFF' || $div == 'TECHNICAL PRESALES' && $pos == 'STAFF' || $div == 'FINANCE' && $pos == 'STAFF' || $div == 'PMO' && $pos == 'STAFF' || $pos == 'ADMIN' || $div == 'HR' && $pos == 'STAFF GA' || $div == 'HR' && $pos == 'HR STAFF' || $pos == 'STAFF HR'){
        //     $data = $data->where('users.nik',$nik);

        // } elseif ($div == 'TECHNICAL' && $pos == 'MANAGER') {
        //     $data = $data->whereRaw("(`users`.`id_position` = 'ENGINEER MANAGER' OR `users`.`id_position` = 'MANAGER' AND `users`.`id_territory` = 'DVG' OR `users`.`id_position` = 'MANAGER' AND `users`.`id_territory` = 'PRESALES' OR `users`.`id_position` = 'MANAGER' AND `users`.`id_territory` = 'OPERATION' OR `users`.`id_position` = 'HR MANAGER')")->whereRaw("(`tb_cuti`.`status` = 'n' OR `tb_cuti`.`status` = 'R')");
        // } else {
        //     $data = $data;
        // }

        return array("data"=>$data->distinct()->get());
        
    }

    public function filterByDate(Request $request)
    {
        $nik = Auth::User()->nik;
        $territory = DB::table('users')->select('id_territory')->where('nik', $nik)->first();
        $ter = $territory->id_territory;
        $division = DB::table('users')->select('id_division')->where('nik', $nik)->first();
        $div = $division->id_division;
        $position = DB::table('users')->select('id_position')->where('nik', $nik)->first();
        $pos = $position->id_position;

        $cek_role = DB::table('users')->join('role_user','role_user.user_id','users.nik')->join('roles','roles.id','role_user.role_id')->select('users.name','roles.name as name_role')->where('user_id',$nik)->first();

        if ($ter != NULL) {
            if($div == 'SALES' && $pos == 'MANAGER'){
                $cuti = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
                ->orderBy('tb_cuti.date_req','DESC')
                ->where('id_territory', $ter)
                ->where('date_off', '>=', $request->start)
                ->where('date_off', '<=', $request->end)
                ->groupby('tb_cuti.id_cuti')
                ->get();
            } elseif ($div == 'TECHNICAL' && $pos == 'ENGINEER MANAGER' && $ter == 'DPG'){
                $cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
                    ->orderBy('tb_cuti.date_req','DESC')
                    ->where('users.id_division','TECHNICAL')
                    ->where('users.id_territory','DPG')
                    ->where('date_off', '>=', $request->start)
                    ->where('date_off', '<=', $request->end)
                    ->groupby('tb_cuti.id_cuti')
                    ->get();
            } elseif($div == 'BCD' && $ter == 'OPERATION' && $pos == 'MANAGER'){
                $cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
                    ->where('users.id_division','BCD')
                    ->orderBy('tb_cuti.date_req','DESC')
                    ->where('date_off', '>=', $request->start)
                    ->where('date_off', '<=', $request->end)
                    ->groupby('tb_cuti.id_cuti')
                    ->orderBy('id_cuti','desc')
                    ->get();
            } elseif ($div == 'PMO' && $ter == 'OPERATION' && $pos == 'MANAGER') {
                $cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at') 
                    ->where('users.id_division','PMO')
                    ->orderBy('tb_cuti.date_req','DESC')
                    ->where('date_off', '>=', $request->start)
                    ->where('date_off', '<=', $request->end)
                    ->groupby('tb_cuti.id_cuti')
                    ->orderBy('id_cuti','desc')
                    ->get();
            } elseif ($div == 'MSM' && $ter == 'OPERATION' && $pos == 'MANAGER') {
                $cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at') 
                    ->where('users.id_division','MSM')
                    ->orderBy('tb_cuti.date_req','DESC')
                    ->where('date_off', '>=', $request->start)
                    ->where('date_off', '<=', $request->end)
                    ->groupby('tb_cuti.id_cuti')
                    ->orderBy('id_cuti','desc')
                    ->get();
            } elseif ($pos == 'OPERATION DIRECTOR') {
                $cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at') 
                    ->where('users.id_position','MANAGER')
                    ->where('users.id_territory','OPERATION')
                    ->orwhere('users.id_position','OPERATION DIRECTOR')
                    ->orwhere('users.id_division','WAREHOUSE')
                    ->where('date_off', '>=', $request->start)
                    ->where('date_off', '<=', $request->end)
                    ->orderBy('tb_cuti.date_req','DESC')
                    ->groupby('tb_cuti.id_cuti')
                    ->orderBy('id_cuti','desc')
                    ->get();
            } elseif($div == 'TECHNICAL PRESALES' && $pos == 'MANAGER'){
                $cuti = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','tb_cuti.pic','tb_cuti.updated_at')
                ->where('users.id_territory','PRESALES')
                ->where('date_off', '>=', $request->start)
                ->where('date_off', '<=', $request->end)
                ->groupby('tb_cuti.id_cuti')
                ->orderBy('id_cuti','desc')
                ->get();
            } elseif($div == 'FINANCE' && $pos == 'MANAGER'){
                $cuti = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
                ->where('users.id_division','FINANCE')
                ->where('date_off', '>=', $request->start)
                ->where('date_off', '<=', $request->end)
                ->groupby('tb_cuti.id_cuti')
                ->orderBy('id_cuti','desc')
                ->get();
            } elseif($cek_role->name_role == 'Chief Operating Officer') {
                $cuti = DB::table('tb_cuti')
                        ->join('users','users.nik','=','tb_cuti.nik')
                        ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                        ->join('tb_position','tb_position.id_position','=','users.id_position')
                        ->join('tb_division','tb_division.id_division','=','users.id_division')
                        ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
                        ->groupby('tb_cuti.id_cuti')
                        ->where('date_off', '>=', $request->start)
                        ->where('date_off', '<=', $request->end)
                        ->orderBy('id_cuti','desc')
                        ->get();
            }else{
                $cuti = DB::table('tb_cuti')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at') 
                ->groupby('tb_cuti.id_cuti')
                ->orderBy('tb_cuti.date_req','DESC')
                ->where('users.nik',$nik)
                ->where('date_off', '>=', $request->start)
                ->where('date_off', '<=', $request->end)
                ->orderBy('id_cuti','desc')
                ->get();
            }
        } elseif($div == 'TECHNICAL' && $pos == 'MANAGER'){
            $cuti = DB::table('tb_cuti')
            ->join('users','users.nik','=','tb_cuti.nik')
            ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
            ->join('tb_position','tb_position.id_position','=','users.id_position')
            ->join('tb_division','tb_division.id_division','=','users.id_division')
            ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
            ->where('users.id_division','TECHNICAL')
            ->where('users.id_position','MANAGER')
            ->orwhere('users.id_position','ENGINEER MANAGER')
            ->where('date_off', '>=', $request->start)
            ->where('date_off', '<=', $request->end)
            ->groupby('tb_cuti.id_cuti')
            ->orderBy('id_cuti','desc')
            ->get();
        } elseif($div == 'TECHNICAL DVG' && $pos == 'STAFF' || $div == 'TECHNICAL DPG' && $pos == 'ENGINEER STAFF' || $div == 'TECHNICAL PRESALES' && $pos == 'STAFF' || $div == 'FINANCE' && $pos == 'STAFF' || $div == 'PMO' && $pos == 'STAFF' || $pos == 'ADMIN' || $div == 'HR' && $pos == 'STAFF GA' || $div == 'HR' && $pos == 'HR STAFF' || $pos == 'STAFF HR'){
                $cuti = DB::table('tb_cuti')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at') 
                    ->groupby('tb_cuti.id_cuti')
                    ->orderBy('tb_cuti.date_req','DESC')
                    ->where('users.nik',$nik)
                    ->where('date_off', '>=', $request->start)
                    ->where('date_off', '<=', $request->end)
                    ->orderBy('id_cuti','desc')
                    ->get();
        } elseif ($div == 'HR' && $pos == 'HR MANAGER') {
            $cuti = DB::table('tb_cuti')
                ->join('users','users.nik','=','tb_cuti.nik')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti','tb_cuti.pic','tb_cuti.updated_at')
                // ->where('status','v')
                ->where('date_off', '>=', $request->start)
                ->where('date_off', '<=', $request->end)
                ->groupby('tb_cuti.id_cuti')
                ->get();
        } elseif ($pos == 'DIRECTOR') {
            $cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
                    ->groupby('tb_cuti.id_cuti')
                    ->orderBy('id_cuti','desc')
                    ->where('users.id_position','MANAGER')
                    ->where('users.id_division','!=','MSM')
                    ->orwhere('users.id_position','=','OPERATION DIRECTOR')
                    ->orwhere('users.id_position','=','HR MANAGER')
                    ->where('date_off', '>=', $request->start)
                    ->where('date_off', '<=', $request->end)
                    ->get();
        } else {
            $cuti = DB::table('tb_cuti')
                    ->join('users','users.nik','=','tb_cuti.nik')
                    ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                    ->join('tb_position','tb_position.id_position','=','users.id_position')
                    ->join('tb_division','tb_division.id_division','=','users.id_division')
                    ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.id_position','users.id_territory','tb_cuti.pic','tb_cuti.updated_at')
                    ->groupby('tb_cuti.id_cuti')
                    ->where('date_off', '>=', $request->start)
                    ->where('date_off', '<=', $request->end)
                    ->orderBy('id_cuti','desc')
                    ->get();
        }

	    return $cuti;
    }

    public function filterByDateDiv(Request $request)
    {
    	if ($request->division == 'alldeh'){
    		$cuti = DB::table('tb_cuti')
	            ->join('users','users.nik','=','tb_cuti.nik')
	            ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
	            ->join('tb_position','tb_position.id_position','=','users.id_position')
	            ->join('tb_division','tb_division.id_division','=','users.id_division')
	            ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti','tb_cuti.pic','tb_cuti.updated_at')
	            // ->where('status','v')
	            ->where('date_off', '>=', $request->start)
                ->where('date_off', '<=', $request->end)
	            ->groupby('tb_cuti.id_cuti')
	            ->get();
    	}else{
    		$cuti = DB::table('tb_cuti')
	            ->join('users','users.nik','=','tb_cuti.nik')
	            ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
	            ->join('tb_position','tb_position.id_position','=','users.id_position')
	            ->join('tb_division','tb_division.id_division','=','users.id_division')
	            ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti','tb_cuti.pic','tb_cuti.updated_at')
	            // ->where('status','v')
	            ->where('tb_division.id_division',$request->division)
	            ->where('date_off', '>=', $request->start)
                ->where('date_off', '<=', $request->end)
	            ->groupby('tb_cuti.id_cuti')
	            ->get();
    	}
    	

	    return $cuti;
    }

    public function filterByDiv(Request $request)
    {

    	if ($request->division == 'alldeh') {
    		$cuti = DB::table('tb_cuti')
	            ->join('users','users.nik','=','tb_cuti.nik')
	            ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
	            ->join('tb_position','tb_position.id_position','=','users.id_position')
	            ->join('tb_division','tb_division.id_division','=','users.id_division')
	            ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti')
	            // ->where('status','v')
	            ->whereYear('date_req',date('Y'))
	            ->groupby('tb_cuti.id_cuti')
	            ->get();
    	}else{
    		$cuti = DB::table('tb_cuti')
	            ->join('users','users.nik','=','tb_cuti.nik')
	            ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
	            ->join('tb_position','tb_position.id_position','=','users.id_position')
	            ->join('tb_division','tb_division.id_division','=','users.id_division')
	            ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','tb_cuti.date_req','tb_cuti.reason_leave','tb_cuti.date_start','tb_cuti.date_end','tb_cuti.id_cuti','tb_cuti.status','tb_cuti.decline_reason',DB::raw('COUNT(tb_cuti_detail.id_cuti) as days'),'users.cuti')
	            // ->where('status','v')
	            ->whereYear('date_req',date('Y'))
	            ->where('tb_division.id_division',$request->division)
	            ->groupby('tb_cuti.id_cuti')
	            ->get();
    	}
    	

	    return $cuti;
    }

    public function cutipdf(Request $request)
    {
         $year = date('Y');

        $cuti_index = DB::table('users')
                ->join('tb_cuti','tb_cuti.nik','=','users.nik')
                ->join('tb_cuti_detail','tb_cuti_detail.id_cuti','=','tb_cuti.id_cuti')
                ->join('tb_position','tb_position.id_position','=','users.id_position')
                ->join('tb_division','tb_division.id_division','=','users.id_division')
                ->select('users.nik','users.date_of_entry','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','users.cuti',DB::raw('COUNT(tb_cuti_detail.id_cuti) as niks'),DB::raw('DATEDIFF(NOW(),date_of_entry) AS date_of_entrys'))
                ->groupby('tb_cuti.nik')
                ->get();

        $cuti_list = DB::table('users')
            ->join('tb_position','tb_position.id_position','=','users.id_position')
            ->join('tb_division','tb_division.id_division','=','users.id_division')
            ->select('users.nik','users.name','tb_position.name_position','tb_division.name_division','tb_division.id_division','users.cuti','users.date_of_entry',DB::raw('DATEDIFF(NOW(),date_of_entry) AS date_of_entrys'))
            ->whereNotIn('nik',function($query) { 
                $query->select('nik')->from('tb_cuti');
            })
            ->get();

        /*$pdf = PDF::loadView('HR.cuti_pdf', compact('cuti_index', 'cuti_list', 'year'));
        return $pdf->download('report_cuti-'.date("d-m-Y").'.pdf');*/
        return view('HR.cuti_pdf', compact('cuti_index', 'cuti_list', 'year'));
    }

    public function storeCutiAddition(Request $request){
        $date = json_decode($request->cuti_tambahan,true);
        foreach ($date as $value) {
            $format_date           = strtotime($value);
            $store                 = new PublicHolidayAdjustment();
            $store->date           = date("Y-m-d",$format_date);
            $store->description    = $request->description;
            $store->reason         = '-';
            $store->date_add       = Carbon::now()->toDateTimeString();
            $store->save();
        }
    }

}
