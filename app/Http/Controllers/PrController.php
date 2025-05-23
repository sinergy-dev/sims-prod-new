<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\PR;
use App\SalesProject;
use App\PrIdProject;
use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
// use Excel;
use Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        set_time_limit(8000000);
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

        $pops = PR::select('no_pr')->orderBy('created_at','desc')->first();

        if ($ter != null) {
            $notif = DB::table('sales_lead_register')
            ->select('opp_name','nik')
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

        $tahun = date("Y");

        $sidebar_collapse = true;

        $year_before = PR::select(DB::raw('YEAR(created_at) year'))->orderBy('year','desc')->groupBy('year')->get();

        $pid = SalesProject::join('sales_lead_register', 'sales_lead_register.lead_id', '=', 'tb_id_project.lead_id')->join('users', 'users.nik', '=', 'sales_lead_register.nik')->select('id_project')->where('id_company', '1')->get();

        $user = User::select('name', 'nik')->where('id_company', '1')->where('status_karyawan', '!=', 'dummy')->orderBy('name','asc')->get();

        return view('admin/pr', compact('notif','notifOpen','notifsd','notiftp' ,'pops', 'sidebar_collapse','year_before','tahun','pid', 'user'))->with(['initView'=> $this->initMenuBase()]);
    }

    public function getCountPr(Request $request)
    {
        $total_pr = PR::select('no_pr', 'amount')->whereYear('date', $request->year);

        $count_all = $total_pr->whereRaw("(`status` is NULL OR `status` != 'Cancel')")->count('no_pr');
        $count_ipr = $total_pr->where('type_of_letter', 'IPR')->whereRaw("(`status` is NULL OR `status` != 'Cancel')")->count('no_pr');
        $count_epr = PR::select('no_pr', 'amount')->whereYear('date', $request->year)->where('type_of_letter', 'EPR')->whereRaw("(`status` is NULL OR `status` != 'Cancel')")->count('no_pr');
        $amount_all = PR::select('no_pr', 'amount')->whereYear('date', $request->year)->whereRaw("(`status` is NULL OR `status` != 'Cancel')")->sum('amount');
        $amount_ipr = $total_pr->where('type_of_letter', 'IPR')->whereRaw("(`status` is NULL OR `status` != 'Cancel')")->sum('amount');
        $amount_epr = PR::select('no_pr', 'amount')->whereYear('date', $request->year)->where('type_of_letter', 'EPR')->whereRaw("(`status` is NULL OR `status` != 'Cancel')")->sum('amount');

        return collect([
            'all'=>[$count_all,strpos((string)$amount_all,".",0) ? (string)$amount_all : (string)$amount_all . ".00"],
            'ipr'=>[$count_ipr,strpos((string)$amount_ipr,".",0) ? (string)$amount_ipr : (string)$amount_ipr . ".00"],
            'epr'=>[$count_epr,strpos((string)$amount_epr,".",0) ? (string)$amount_epr : (string)$amount_epr . ".00"]
        ]);
    }

    
    public function create()
    {
        //
    }

    public function store_pr(Request $request)
    {
        $tahun = date("Y");
        $cek = DB::table('tb_pr')
                ->where('date','like',$tahun."%")
                ->count('no');

        $type = $request['type'];
        $posti = $request['position'];

        $edate = strtotime($_POST['date']); 
        $edate = date("Y-m-d",$edate);

        $month_pr = substr($edate,5,2);
        $year_pr = substr($edate,0,4);

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
        $bln = $array_bln[$month_pr];

        $getnumber = PR::orderBy('no', 'desc')->where('date','like',$tahun."%")->count();

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

        $no = $akhirnomor.'/'.$posti .'/'. $type.'/' . $bln .'/'. $year_pr;
        $nom = PR::select('no')->orderBy('no','desc')->first();

        $tambah = new PR();
        $tambah->no = $nom->no+1;
        $tambah->no_pr = $no;
        $tambah->position = $posti;
        $tambah->type_of_letter = $type;
        $tambah->month = $bln;
        $tambah->date = $edate;
        $tambah->to = $request['to'];
        $tambah->attention = $request['attention'];
        $tambah->title = $request['title'];
        $tambah->project = $request['project'];
        $tambah->description = $request['description'];
        $tambah->from = $request['from_user'];
        // $tambah->division = $request['division'];
        $tambah->division = 'PMO';
        $tambah->issuance = Auth::User()->nik;
        $tambah->amount = str_replace(',', '', $request['amount']);
        if ($request['project_id'] == null) {
            $tambah->project_id = $request['project_idInputNew'];
        }else{
            $tambah->project_id = $request['project_id'];
        }
        $tambah->category = $request['category'];
        $tambah->result = 'T';
        $tambah->status = 'On Progress';
        $tambah->save();

        return redirect('pr')->with('success', 'Created Purchase Request Successfully!');       
    }

    public function reportPr()
    {
        $year = date("Y");
        $sidebar_collapse = true;
        $year_before = PR::select(DB::raw('YEAR(created_at) year'))->orderBy('year','desc')->groupBy('year')->get();

        return view('admin/report_pr', compact('year', 'sidebar_collapse', 'year_before'))->with(['initView'=> $this->initMenuBase()]);
    }

    public function getTotalPr()
    {
        $year = date('Y');
        $pie = 0;
        $total = PR::orderby('type_of_letter')->whereYear('date',$year)->whereRaw("( `status` = 'Done')")->get();

        $hasil2 = [0,0];
        if (count($total) == 0) {
            $hasil2 = $hasil2;
        }else{
            $first = $total[0]->type_of_letter;
            $hasil = [0,0];
            $type_pr = ['IPR', 'EPR'];

            foreach ($type_pr as $key => $value2) {
                foreach ($total as $value) {
                        if ($value->type_of_letter == $value2) {
                            $hasil[$key]++;
                            $pie++;
                        }
                    }
            }

            foreach ($hasil as $key => $value) {
                $hasil2[$key] = ($value/$pie)*100;
            }
        }

        return $hasil2;
    }

    public function getAmountByCategory()
    {
        $year = date('Y');

        $sum_all = PR::selectRaw('SUM(`amount`) as `sum_all`')
            ->whereYear('date', date('Y'))
            // ->whereRaw("(`status` is NULL OR `status` != 'Cancel')")
            ->whereRaw("( `status` = 'Done')")
            ->first();

        if (!is_null($sum_all->sum_all)) {
            $sum_cat = PR::select('category')
            // ->selectRaw('SUM(`amount`) as `sum`')
            ->selectRaw('SUM(`amount`)/' . $sum_all->sum_all . '*100 as `precentage`')
            ->orderBy('precentage','DESC')
            ->whereYear('date', date('Y'))
            // ->whereRaw("(`status` is NULL OR `status` != 'Cancel')")
            ->whereRaw("( `status` = 'Done')")
            ->groupBy('category')->get();

            return array("label"=>$sum_cat->pluck('category'), "precentage"=>$sum_cat->pluck('precentage'));
        }else{
            return array("label"=>"", "precentage"=>0);
        }

        

    }

    public function getTotalPrByMonth()
    {
        $data = DB::table('tb_pr_activity')->join('tb_pr_activity as t2','t2.id_draft_pr','tb_pr_activity.id_draft_pr')->join('tb_pr','tb_pr.id_draft_pr','tb_pr_activity.id_draft_pr')->select('t2.id_draft_pr','month_formatting','type_of_letter','no_pr')->where('tb_pr_activity.status','SAVED')->where('t2.status','SENDED')->whereYear('date',date('Y'))->orderBy('month_formatting','asc');

        // return $data->get();

        $data = $data->select('month_formatting',
                DB::raw('COUNT(IF(`tb_pr`.`type_of_letter` = "IPR",1,NULL)) AS "IPR"'),
                DB::raw('COUNT(IF(`tb_pr`.`type_of_letter` = "EPR",1,NULL)) AS "EPR"'),
            )->groupby('month_formatting');

        return array("data"=>$data->get());
    }

    public function getTotalAmountByType()
    {
        $data = PR::select('month_formatting',
                DB::raw('SUM(IF(`tb_pr`.`type_of_letter` = "IPR",amount,"")) AS "amount_IPR"'),
                DB::raw('SUM(IF(`tb_pr`.`type_of_letter` = "EPR",amount,"")) AS "amount_EPR"')
            )
            // ->whereRaw("(`status` is NULL OR `status` != 'Cancel')")
            ->whereRaw("( `status` = 'Done')")
            ->whereYear('date', date('Y'))
            ->groupBy('month_formatting');

        return array("data" => $data->get());
    }

    public function getTotalNominalByCat()
    {
        $data = PR::select(
                DB::raw('COUNT(no_pr) as total'),
                DB::raw('SUM(amount) as nominal'),
                'category'
            )
            ->whereYear('date', date('Y'))
            // ->whereRaw("(`status` is NULL OR `status` != 'Cancel')")
            ->whereRaw("( `status` = 'Done')")
            ->orderBy('nominal', 'desc')
            ->groupBy('category');

        return array("data" => $data->get());
    }

    public function getTotalNominalByPid()
    {
        // $data = PR::select(
        //             DB::raw('COUNT(no_pr) as total'),
        //             DB::raw('SUM(amount) as nominal'),
        //             'project_id'
        //         )
        //         ->whereRaw("(`project_id` != 'internal' AND `project_id` != '-')")
        //         ->whereYear('date', date('Y'))
        //         ->whereRaw("(`status` is NULL OR `status` != 'Cancel')")
        //         ->groupBy('project_id');

        $data =  PrIdProject::join('sales_lead_register', 'sales_lead_register.lead_id', 'tb_id_project.lead_id')
                    ->join('users', 'users.nik', 'sales_lead_register.nik')
                    ->join('tb_pr', 'tb_pr.project_id', 'tb_id_project.id_project')
                    ->select(
                        DB::raw('COUNT(no_pr) as total'),
                        DB::raw('SUM(`tb_pr`.`amount`) as nominal'),
                        'id_project'
                    )
                    ->whereYear('tb_pr.date', date('Y'))
                    ->where('id_company', '1')
                    ->whereRaw("(`project_id` != 'internal' AND `project_id` != '-')")
                    // ->whereRaw("(`tb_pr`.`status` is NULL OR `tb_pr`.`status` != 'Cancel')")
                    ->whereRaw("( `tb_pr`.`status` = 'Done')")
                    ->groupBy('project_id');

        // $data = SalesProject::join('sales_lead_register', 'sales_lead_register.lead_id', 'tb_id_project.lead_id')
        //         ->join('users', 'users.nik', 'sales_lead_register.nik')
        //         ->join('tb_pr', 'tb_pr.project_id', 'tb_id_project.id_project')
        //         ->select(
        //             DB::raw('COUNT(no_pr) as total'),
        //             DB::raw('SUM(`tb_pr`.`amount`) as nominal'),
        //             'project_id'
        //         )
        //         ->where('id_company', '1')
        //         ->whereRaw("(`project_id` != 'internal' AND `project_id` != '-')")
        //         ->whereYear('tb_pr.date', date('Y'))
        //         ->whereRaw("(`tb_pr`.`status` is NULL OR `tb_pr`.`status` != 'Cancel')")
        //         ->groupBy('project_id');

        return array("data" => $data->get());
    }

    public function getPrByPid(Request $request)
    {
        $data = PR::join('tb_id_project', 'tb_id_project.id_project', 'tb_pr.project_id')
                ->select('tb_pr.title', 'tb_pr.no_pr', 'tb_pr.amount')
                ->where('tb_id_project.id_project', $request->pid)
                ->get();

        return $data;
    }

    public function getTotalNominalByCatIpr()
    {
        $data = PR::select(
                DB::raw('COUNT(no_pr) as total'),
                DB::raw('SUM(amount) as nominal'),
                'category'
            )
            ->whereYear('date', date('Y'))
            ->where('type_of_letter', 'IPR')
            // ->whereRaw("(`status` is NULL OR `status` != 'Cancel')")
            ->whereRaw("( `status` = 'Done')")
            ->orderBy('nominal', 'desc')
            ->groupBy('category');

        return array("data" => $data->get());
    }

    public function getTotalNominalByCatEpr()
    {
        $data = PR::select(
                DB::raw('COUNT(no_pr) as total'),
                DB::raw('SUM(amount) as nominal'),
                'category'
            )
            ->whereYear('date', date('Y'))
            ->where('type_of_letter', 'EPR')
            ->whereRaw("(`status` is NULL OR `status` != 'Cancel')")
            ->orderBy('nominal', 'desc')
            ->groupBy('category');

        return array("data" => $data->get());
    }

    public function getTopFiveSupplier()
    {
        $data = PR::select(
                DB::raw('COUNT(no_pr) as total'),
                DB::raw('SUM(amount) as nominal'),
                // 'to'
                DB::raw("REPLACE(`to`,'.','') as `to_replace`") 
            )
            ->whereYear('date', date('Y'))
            // ->whereYear('date', '2022')
            // ->whereRaw("(`status` is NULL OR `status` != 'Cancel')")
            ->whereRaw("( `status` = 'Done')")
            ->orderBy('nominal', 'desc')
            ->groupBy('to_replace')
            ->take(5);

        return array("data" => $data->get());
    }

    public function getTotalPrYear(Request $request)
    {
        $pie = 0;
        $total = PR::orderby('type_of_letter')->whereYear('date', $request->year)->whereRaw("( `status` = 'Done')")->get();

        $first = $total[0]->type_of_letter;
        $hasil = [0,0];
        $type_pr = ['IPR', 'EPR'];

        foreach ($type_pr as $key => $value2) {
            foreach ($total as $value) {
                    if ($value->type_of_letter == $value2) {
                        $hasil[$key]++;
                        $pie++;
                    }
                }
        }

        $hasil2 = [0,0];
        foreach ($hasil as $key => $value) {
            $hasil2[$key] = ($value/$pie)*100;
        }

        $sum_all = PR::selectRaw('SUM(`amount`) as `sum_all`')
            ->whereYear('date',  $request->year)
            // ->whereRaw("(`status` is NULL OR `status` != 'Cancel')")
            ->whereRaw("( `status` = 'Done')")
            ->first();

        $sum_cat = PR::select('category')
            // ->selectRaw('SUM(`amount`) as `sum`')
            ->selectRaw('SUM(`amount`)/' . $sum_all->sum_all . '*100 as `precentage`')
            ->orderBy('precentage','DESC')
            ->whereYear('date',  $request->year)
            // ->whereRaw("(`status` is NULL OR `status` != 'Cancel')")
            ->whereRaw("( `status` = 'Done')")
            ->groupBy('category')->get();

        $data = PR::select(
                DB::raw('COUNT(IF(`tb_pr`.`type_of_letter` = "IPR",1,NULL)) AS "IPR"'),
                DB::raw('COUNT(IF(`tb_pr`.`type_of_letter` = "EPR",1,NULL)) AS "EPR"'), 'month'
            )
            // ->whereRaw("(`status` is NULL OR `status` != 'Cancel')")
            ->whereRaw("( `status` = 'Done')")
            ->whereYear('date',  $request->year)
            ->groupBy('month')
            ->get();

        $totalAmount = PR::select(
                DB::raw('SUM(IF(`tb_pr`.`type_of_letter` = "IPR",amount,"")) AS "amount_IPR"'),
                DB::raw('SUM(IF(`tb_pr`.`type_of_letter` = "EPR",amount,"")) AS "amount_EPR"'), 'month'
            )
            // ->whereRaw("(`status` is NULL OR `status` != 'Cancel')")
            ->whereRaw("( `status` = 'Done')")
            ->whereYear('date', $request->year)
            ->groupBy('month')
            ->get();


        return [ "dataTotalPr"=> [ "data" => $hasil2, "label" => $type_pr], 
                 "dataAmountByCat" => ["label"=>$sum_cat->pluck('category'), "precentage"=>$sum_cat->pluck('precentage')], 
                 "dataTotalPrByCat" => $data,
                 "dataAmountPrByType" => $totalAmount];
    }

    public function getTotalNominalByCatYear(Request $request)
    {
        $data = PR::select(
                DB::raw('COUNT(no_pr) as total'),
                DB::raw('SUM(amount) as nominal'),
                'category'
            )
            // ->whereRaw("(`status` is NULL OR `status` != 'Cancel')")
            ->whereRaw("( `status` = 'Done')")
            ->orderBy('nominal', 'desc')
            ->whereYear('date', $request->year)
            ->groupBy('category');

        return array("data" => $data->get());
    }

    public function getTopFiveSupplierYear(Request $request)
    {
        $data = PR::select(
                DB::raw('COUNT(no_pr) as total'),
                DB::raw('SUM(amount) as nominal'),
                // 'to'
                DB::raw("REPLACE(`to`,'.','') as `to_replace`") 
            )
            ->whereYear('date', $request->year)
            // ->whereRaw("(`status` is NULL OR `status` != 'Cancel')")
            ->whereRaw("( `status` = 'Done')")
            ->orderBy('nominal', 'desc')
            ->groupBy('to_replace')
            ->take(5);

        return array("data" => $data->get());
    }

    public function getTotalNominalByPidYear(Request $request)
    {
        // $data = PR::select(
        //         DB::raw('COUNT(no_pr) as total'),
        //         DB::raw('SUM(amount) as nominal'),
        //         'project_id as id_project'
        //     )
        //     ->whereRaw("(`project_id` != 'internal' AND `project_id` != '-')")
        //     ->whereYear('date', $request->year)
        //     ->whereRaw("(`status` is NULL OR `status` != 'Cancel')")
        //     ->groupBy('project_id');


        $data = PrIdProject::join('sales_lead_register', 'sales_lead_register.lead_id', 'tb_id_project.lead_id')
                    ->join('users', 'users.nik', 'sales_lead_register.nik')
                    ->join('tb_pr', 'tb_pr.project_id', 'tb_id_project.id_project')
                    ->select(
                        DB::raw('COUNT(no_pr) as total'),
                        DB::raw('SUM(`tb_pr`.`amount`) as nominal'),
                        'id_project'
                    )
                    ->whereYear('tb_pr.date', $request->year)
                    ->where('id_company', '1')
                    ->whereRaw("(`project_id` != 'internal' AND `project_id` != '-')")
                    // ->whereRaw("(`tb_pr`.`status` is NULL OR `tb_pr`.`status` != 'Cancel')")
                    ->whereRaw("( `tb_pr`.`status` = 'Done')")
                    ->groupBy('project_id');

        return array("data" => $data->get());
    }

    public function getTotalNominalByCatIprYear(Request $request)
    {
        $data = PR::select(
                DB::raw('COUNT(no_pr) as total'),
                DB::raw('SUM(amount) as nominal'),
                'category'
            )
            ->whereYear('date', $request->year)
            ->where('type_of_letter', 'IPR')
            // ->whereRaw("(`status` is NULL OR `status` != 'Cancel')")
            ->whereRaw("( `status` = 'Done')")
            ->orderBy('nominal', 'desc')
            ->groupBy('category');

        return array("data" => $data->get());
    }

    public function getTotalNominalByCatEprYear(Request $request)
    {
        $data = PR::select(
                DB::raw('COUNT(no_pr) as total'),
                DB::raw('SUM(amount) as nominal'),
                'category'
            )
            ->whereYear('date', $request->year)
            ->where('type_of_letter', 'EPR')
            // ->whereRaw("(`status` is NULL OR `status` != 'Cancel')")
            ->whereRaw("( `status` = 'Done')")
            ->orderBy('nominal', 'desc')
            ->groupBy('category');

        return array("data" => $data->get());
    }
    
    public function update_pr(Request $request)
    {
        $no = $request['edit_no_pr'];

        $type = $request['edit_type'];
        $posti = $request['edit_position'];

        $edate = strtotime($_POST['edit_date']); 
        $edate = date("Y-m-d",$edate);

        $month_pr = substr($edate,5,2);
        $year_pr = substr($edate,0,4);

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
        $bln = $array_bln[$month_pr];

        $getno = PR::where('no', $no)->first()->no_pr;
        $getnumberPr =  explode("/",$getno)[0];

        // return $getnumberPr;

        $no_update = $getnumberPr.'/'.$posti .'/'. $type.'/' . $bln .'/'. $year_pr;

        $update = PR::where('no',$no)->first();
        // $update->no_pr = $no_update;
        $update->position = $posti;
        $update->type_of_letter = $type;
        $update->month = $bln;
        $update->date = $edate;
        $update->to = $request['edit_to'];
        $update->attention = $request['edit_attention'];
        $update->title = $request['edit_title'];
        $update->description = $request['edit_description'];
        $update->project_id = $request['edit_project_id'];
        $update->note = $request['edit_note'];
        $amount = str_replace('.', '', $request['edit_amount']);
        $update->status = $request['edit_status'];
        $update->amount = $amount;
        $update->invoice_customer = $request['statusInvoiceCustomer'];
        $update->notes_invoice_customer = nl2br($request['notesInvoiceCustomer']);
        $update->invoice_vendor = $request['statusInvoiceVendor'];
        $update->notes_invoice_vendor = nl2br($request['notesInvoiceVendor']);


        $update->update();

        return redirect('pr')->with('update', 'Updated Purchase Request Data Successfully!');
    }

    public function getfilteryear(Request $request)
    {
        $filter_pr = DB::table('tb_pr')
                        ->join('users as user_from', 'user_from.nik', '=', 'tb_pr.from')
                        ->join('users as issuance', 'issuance.nik', '=', 'tb_pr.issuance')
                        ->select('no','no_pr', 'position', 'type_of_letter', 'month', 'date', 'to', 'attention', 'title', 'description', 'division', 'project_id', 'user_from.name as user_from', 'note', 'issuance.name as issuance', 'category', 'status', 'amount','id_draft_pr','isRupiah','request_method',DB::raw("(CASE WHEN (invoice_customer is null) THEN '-' ELSE invoice_customer END) as invoice_customer"),DB::raw("(CASE WHEN (invoice_vendor is null) THEN '-' ELSE invoice_vendor END) as invoice_vendor"),DB::raw("(CASE WHEN (notes_invoice_customer is null) THEN '-' ELSE notes_invoice_customer END) as notes_invoice_customer"),DB::raw("(CASE WHEN (notes_invoice_vendor is null) THEN '-' ELSE notes_invoice_vendor END) as notes_invoice_vendor"))
                        ->where('result', '!=', 'R')
                        ->whereYear('tb_pr.created_at', $request->data)
                        ->get();

        return array("data" => $filter_pr);
    }

    public function getdatapr(Request $request)
    {
        $tahun = date("Y"); 

        $data = PR::join('users as user_from', 'user_from.nik', '=', 'tb_pr.from')
                                ->join('users as issuance', 'issuance.nik', '=', 'tb_pr.issuance')
                                ->select('no','no_pr', 'position', 'type_of_letter', 'month', 'date', 'to', 'attention', 'title', 'description', 'division', 'project_id', 'user_from.name as user_from', 'note', 'issuance.name as issuance', 'category', 'issuance as issuance_nik', 'amount', 'status','id_draft_pr','isRupiah','request_method',DB::raw("(CASE WHEN (invoice_customer is null) THEN '-' ELSE invoice_customer END) as invoice_customer"),DB::raw("(CASE WHEN (invoice_vendor is null) THEN '-' ELSE invoice_vendor END) as invoice_vendor"),DB::raw("(CASE WHEN (notes_invoice_customer is null) THEN '-' ELSE notes_invoice_customer END) as notes_invoice_customer"),DB::raw("(CASE WHEN (notes_invoice_vendor is null) THEN '-' ELSE notes_invoice_vendor END) as notes_invoice_vendor"))
                                ->where('result', '!=', 'R')
                                ->where('date','like',$tahun."%")
                                ->get();

        return array("data" => $data);
    }

    public function destroy_pr($no)
    {
        $hapus = PR::find($no);
        $hapus->delete();

        return redirect('pr')->with('alert', 'Deleted!');
    }

    public function PrAdmin()
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
            ->select('opp_name','nik')
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

        $datas = DB::table('tb_pr')
                        ->join('users','users.nik','=','tb_pr.from')
                        ->select('tb_pr.no','tb_pr.no_pr', 'tb_pr.position', 'tb_pr.type_of_letter', 'tb_pr.month', 'tb_pr.date', 'tb_pr.to', 'tb_pr.attention', 'tb_pr.title', 'tb_pr.project', 'tb_pr.description', 'tb_pr.from', 'tb_pr.division', 'tb_pr.issuance', 'tb_pr.project_id', 'users.name')
                        ->get();

        return view('report/pr', compact('notif','notifOpen','notifsd','notiftp','id_pro', 'datas'));
    }

    public function downloadExcelPr(Request $request) {

        $spreadsheet = new Spreadsheet();

        $prSheet = new Worksheet($spreadsheet,'Purchase Request');
        $spreadsheet->addSheet($prSheet);
        $spreadsheet->removeSheetByIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:Q1');
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

        $sheet->getStyle('A1:Q1')->applyFromArray($titleStyle);
        $sheet->setCellValue('A1','Purchase Request');

        $headerStyle = $normalStyle;
        $headerStyle['font']['bold'] = true;
        $sheet->getStyle('A2:Q2')->applyFromArray($headerStyle);;

        $headerContent = ["No", "NO PR", "POSITION", "TYPE OF LETTER", "MONTH",  "DATE", "KATEGORI", "TO" , "ATTENTION", "TITLE", "PROJECT", "DESCRIPTION", "FROM", "ISSUANCE" ,"ID PROJECT", "AMOUNT",'STATUS'];
        $sheet->fromArray($headerContent,NULL,'A2');

        $dataPR = PR::leftJoin('users as user_from', 'user_from.nik', '=', 'tb_pr.from')
            ->leftJoin('users as issuance', 'issuance.nik', '=', 'tb_pr.issuance')
            ->select('no_pr','position','type_of_letter', 'month', 'date', 'category', 'to', 'attention', 'title','project','description','user_from.name as user_from','issuance.name as issuance','project_id','amount', 'status')
            ->whereYear('tb_pr.date', $request->year)
            ->where('status','!=','Cancel')
            ->get();

        foreach ($dataPR as $key => $data) {
            $data->amount = number_format((int)$data->amount,2,",",".");
            $sheet->fromArray(array_merge([$key + 1],array_values($data->toArray())),NULL,'A' . ($key + 3));
        }


        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setWidth(35);
        $sheet->getColumnDimension('I')->setWidth(25);
        $sheet->getColumnDimension('J')->setWidth(50);
        $sheet->getColumnDimension('K')->setWidth(25);
        $sheet->getColumnDimension('L')->setWidth(25);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setWidth(25);
        $sheet->getColumnDimension('O')->setWidth(45);
        $sheet->getColumnDimension('P')->setWidth(25);
        $sheet->getColumnDimension('Q')->setWidth(25);


        $fileName = 'Daftar Buku Admin (PR) ' . date('Y') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);
        ob_end_clean();
        return $writer->save("php://output");
    }
}
