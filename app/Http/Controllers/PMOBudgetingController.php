<?php

namespace App\Http\Controllers;
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

use App\PR;
use App\Sbe;
use App\Settlement;
use App\SettlementAllowance;
use App\SettlementEntertain;
use App\SettlementOther;
use App\SettlementTransport;
use App\Claim;
use App\ClaimAllowance;
use App\ClaimEntertain;
use App\ClaimOther;
use App\ClaimTransport;
use App\PMO;
use App\Timesheet;
use App\User;
use App\RoleUser;
use App\PrProduct;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

use Illuminate\Http\Request;

class PMOBudgetingController extends Controller
{
    //
    public function index(){
        $sidebar_collapse = true;
        
        return view('PMO/projectBudgetControl/index')->with(['initView'=> $this->initMenuBase()]);
    }

    public function getBudgetList(Request $request)
    {
        
    }

    public function detail($value='')
    {
        return view('PMO/projectBudgetControl/detail_pbc')->with(['initView'=> $this->initMenuBase(),'feature_item'=>$this->RoleDynamic('pmo_project_budget')]);
    }

    public function view_detail(Request $request)
    {
        // $data_roles_engineer = DB::table('tb_id_project')
        //         ->join('tb_sbe','tb_id_project.lead_id','=','tb_sbe.lead_id')
        //         ->join('tb_sbe_config','tb_sbe.id','=','tb_sbe_config.id_sbe')
        //         ->join('tb_sbe_detail_config','tb_sbe_config.id','=','tb_sbe_detail_config.id_config_sbe')
        //         ->where('tb_id_project.id_project',$request['id_project'])
        //         ->where('tb_sbe.status','Fixed')
        //         ->where('tb_sbe_config.status','Choosed')
        //         ->select(DB::raw('tb_sbe_detail_config.item as id','tb_sbe_detail_config.item as text'))
        //         ->get();

        return view('PMO/projectBudgetControl/detail_relation_pbc')->with(['initView'=> $this->initMenuBase()]);
    }

    public function getItemSbe(Request $request)
    {
        $data_roles_engineer = DB::table('tb_id_project')
                ->join('tb_sbe','tb_id_project.lead_id','=','tb_sbe.lead_id')
                ->join('tb_sbe_config','tb_sbe.id','=','tb_sbe_config.id_sbe')
                ->join('tb_sbe_detail_config','tb_sbe_config.id','=','tb_sbe_detail_config.id_config_sbe')
                ->join('tb_sbe_detail_item','tb_sbe_detail_config.detail_item','=','tb_sbe_detail_item.id')
                ->where('tb_id_project.id_project',$request['id_project'])
                ->where('tb_sbe.status','Fixed')
                ->where('tb_sbe_config.status','Choosed')
                ->where('tb_sbe_detail_item.detail_item','like','%Travel%')
                ->where('tb_sbe_detail_config.item','like','%'.request('q').'%')
                ->select('tb_sbe_detail_config.item as id','tb_sbe_detail_config.item as text')
                ->distinct()
                ->get();

        return $data_roles_engineer;
    }

    public function updateRole(Request $request)
    {
        $updateRole = PrProduct::where('id',$request->id_product)->first();
        $updateRole->roles_engineer = $request->role;
        $updateRole->update();
    }

    public function exportPdfMaintenance(Request $request)
    {
        $dataPost['id_project'] = $request->id_project;
        $dataPost['id_pmo']     = $request->id_pmo;

        $request = Request::create('/getDetailSettlement', 'POST', $dataPost);

        $data = $this->getDetailProjectBudgetControl($request);

        // return $data;

        $pdf = PDF::loadView('PMO.projectBudgetControl.Pdf.export_pbc_maintenance',compact('data'))->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function exportPdfSupplyOnly(Request $request)
    {
        $dataPost['id_project'] = $request->id_project;
        $dataPost['id_pmo']     = $request->id_pmo;

        $request = Request::create('/getDetailSettlement', 'POST', $dataPost);

        $data = $this->getDetailProjectBudgetControl($request);

        // return $data;

        $pdf = PDF::loadView('PMO.projectBudgetControl.Pdf.export_pbc_supply_only',compact('data'))->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function exportPdfImplementation(Request $request)
    {
        $dataPost['id_project'] = $request->id_project;
        $dataPost['id_pmo']     = $request->id_pmo;

        $request = Request::create('/getDetailSettlement', 'POST', $dataPost);

        $data = $this->getDetailProjectBudgetControl($request);

        // return $data;

        $pdf = PDF::loadView('PMO.projectBudgetControl.Pdf.export_pbc_implementation',compact('data'))->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function exportPdfImpMaintenance(Request $request)
    {
        $dataPost['id_project'] = $request->id_project;
        $dataPost['id_pmo']     = $request->id_pmo;

        $request = Request::create('/getDetailSettlement', 'POST', $dataPost);

        $data = $this->getDetailProjectBudgetControl($request);

        // return $data;

        $pdf = PDF::loadView('PMO.projectBudgetControl.Pdf.export_pbc_imp_maintenance',compact('data'))->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function dashboard($value='')
    {
        return view('PMO/projectBudgetControl/dashboard')->with(['initView'=> $this->initMenuBase()]);
    }

    public function getListProjectBudgetControl(Request $request)
    {   
        if ($request->startDate && $request->endDate) {
            $startDate = $request->startDate;
            $endDate = $request->endDate;
        }else{
            $startDate = Carbon::now()->startOfYear()->format('Y-m-d');
            $endDate = Carbon::now()->endOfYear()->format('Y-m-d');
        }

        // $startDate = Carbon::now()->startOfYear()->format('Y-m-d');
        // $endDate = Carbon::now()->endOfYear()->format('Y-m-d');

        $cek_role = User::join('role_user','users.nik','=','role_user.user_id')
                        ->select('roles.name')
                        ->join('roles','role_user.role_id','=','roles.id')
                        ->where('role_user.user_id',Auth::User()->nik)
                        ->first();

        $data = PMO::join('tb_id_project','tb_pmo.project_id','=','tb_id_project.id_project')
            ->whereBetween('tb_pmo.date_time', [$startDate, $endDate])
            ->whereBetween('tb_id_project.created_at', [$startDate, $endDate]);

        if ($cek_role->name == 'Project Manager'){
            $datas = $data
                ->whereIn('project_type',['implementation','supply_only'])
                ->distinct()
                ->get()
                ->makeHidden([
                    'indicator_project',
                    'sign',
                    'owner',
                    'no_po_customer',
                    'type_project_array',
                    'status',
                    'current_phase',
                    'gantt_status',
                    'implementation_type',
                    'lead_id',
                    'id_pro',
                    'nik',
                    'project_id',
                    'amount_usd',
                    'amount_idr',
                    'date',
                    'note',
                    'invoice',
                    'created_at',
                    'updated_at',
                    'progres',
                    'sales_name',
                    'status_po',
                    'parent_id_drive',
                    'project_pc'
                ]);

            $filteredData = $datas->filter(function ($data) {
                return $data->project_pm === Auth::User()->name;// Use the accessor here
            });

                // return $data->project_pm === Auth::User()->name && $data->id_project == '071/ICON/SIP/VIII/2024'; // Use the accessor here


            $data =  $filteredData;
        }else if($cek_role->name == 'Project Coordinator') {
            $datas = $data->where('project_type','maintenance')
                ->distinct()
                ->get()
                ->makeHidden([
                    'indicator_project',
                    'sign',
                    'owner',
                    'no_po_customer',
                    'type_project_array',
                    'status',
                    'current_phase',
                    'gantt_status',
                    'implementation_type',
                    'lead_id',
                    'id_pro',
                    'nik',
                    'project_id',
                    'amount_usd',
                    'amount_idr',
                    'date',
                    'note',
                    'invoice',
                    'created_at',
                    'updated_at',
                    'progres',
                    'sales_name',
                    'status_po',
                    'parent_id_drive',
                    'project_pc'
                ]);

            $filteredData = $datas->filter(function ($data) {
                return $data->project_pc === Auth::User()->name; // Use the accessor here
            });

            $data = $filteredData;
        }else{
            $data = $data
            ->whereIn('project_type',['implementation','supply_only','maintenance'])
            ->distinct()
            ->get()
            ->makeHidden([
                'indicator_project',
                'sign',
                'owner',
                'no_po_customer',
                'type_project_array',
                'status',
                'current_phase',
                'gantt_status',
                'implementation_type',
                'lead_id',
                'id_pro',
                'nik',
                'project_id',
                'amount_usd',
                'amount_idr',
                'date',
                'note',
                'invoice',
                'created_at',
                'updated_at',
                'progres',
                'sales_name',
                'status_po',
                'parent_id_drive',
            ]);
        }

        // $orderByName = 'health_status';
        // switch($orderColumnIndex){
        //     case '1':
        //         $orderByName = 'id_project';
        //         break;
        //     case '2':
        //         $orderByName = 'customer_name';
        //         break;
        //     case '3':
        //         $orderByName = 'name_project';
        //         break;
        //     case '4':
        //         $orderByName = 'project_pm';
        //         break;
        //     case '5':
        //         $orderByName = 'project_pc';
        //         break;
        //     case '6':
        //         $orderByName = 'type_project';
        //         break;
        //     case '7':
        //         $orderByName = 'plan_sbe';
        //         break;
        //     default:
        //         $orderByName = 'actual_sbe';
        //         break;
        // }

        // $searchFields = ['health_status', 'id_project', 'customer_name', 'name_project', 'project_pm', 'project_pc','type_project','plan_sbe','actual_sbe'];

        // Apply sorting
        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderDirection = $request->order[0]['dir'] ?? 'asc';
        $columns = [
            '0' => 'health_status',
            '1' => 'id_project',
            '2' => 'customer_name',
            '3' => 'name_project',
            '4' => 'project_pm',
            '5' => 'project_pc',
            '6' => 'type_project',
            '7' => 'plan_sbe',
            '8' => 'actual_sbe',
        ];
        
        $orderByName = $columns[$orderColumnIndex] ?? 'health_status';
        $searchFor = $request->searchFor ?? '';

        if (!empty($searchFor)) { 
            $data = $data->filter(function ($item) use ($request) {
                return stripos($item->health_status, $request->searchFor) !== false ||
                       stripos($item->id_project, $request->searchFor) !== false ||
                       stripos($item->customer_name, $request->searchFor) !== false ||
                       stripos($item->name_project, $request->searchFor) !== false ||
                       stripos($item->project_type == 'maintenance'?'-':$item->project_pm, $request->searchFor) !== false ||
                       stripos($item->project_type == 'implementation'?'-':$item->project_pc, $request->searchFor) !== false ||
                       stripos($item->type_project, $request->searchFor) !== false ||
                       stripos($item->plan_sbe, $request->searchFor) !== false ||
                       stripos($item->actual_sbe, $request->searchFor) !== false;
            });

            $totalRecords = $data->count();

            $data = $data->sortBy(function ($item) use ($orderByName) {
                return $item->$orderByName;
            }, SORT_REGULAR, $orderDirection === 'desc');

            $start = $request->input('start', 0);
            $pageLength = $request->input('length', 10);
            $data = $data->slice($start, $pageLength);
            $draw = $request->input('draw');

            // $data = $data;

            // $filtered = $data->filter(function ($value, $key) use($request, $searchFields) { 
            //    return stripos($value["health_status"], $request->searchFor) !== false || 
            //         stripos($value["id_project"], $request->searchFor) !== false ||
            //         stripos($value["customer_name"], $request->searchFor) !== false ||
            //         stripos($value["name_project"], $request->searchFor) !== false ||
            //         stripos($value["project_pm"], $request->searchFor) !== false ||
            //         stripos($value["project_pc"], $request->searchFor) !== false ||
            //         stripos($value["type_project"], $request->searchFor) !== false ||
            //         stripos($value["plan_sbe"], $request->searchFor) !== false ||
            //         stripos($value["actual_sbe"], $request->searchFor) !== false;
            // });

            $data = $data->values();

            // $data = $filtered;

            // $totalRecords = $data->count();
            // // Apply pagination
            // $start = $request->input('start', 0);
            // $pageLength = $request->input('length', $request->length); // Number of records per page

            // $draw = $request->input('draw');

            // $outputArray = [];
            // foreach ($data as $item) {
            //     $outputArray[] = collect([
            //         "id"=>$item->id,
            //         "health_status"=>$item->health_status,
            //         "id_project"=>$item->id_project,
            //         "customer_name"=>$item->customer_name,
            //         "name_project"=>$item->name_project,
            //         "project_pm"=>$item->project_pm,
            //         "project_pc"=>$item->project_pc,
            //         "type_project"=>$item->type_project,
            //         "project_type"=>$item->project_type,
            //         "plan_sbe"=>$item->plan_sbe,
            //         "actual_sbe"=>$item->actual_sbe
            //     ]);
            // }

            // $data = $outputArray;

            // if ($request->order) {
            //     if ($request->order[0]['dir'] == 'asc') {
            //         $data = collect($data)->sortByDesc($orderByName)->values()->all();
            //     }else{
            //         $data = collect($data)->sorptByDesc($orderByName)->values()->all();
            //     }
            // }

            // if ($draw > 1) {
            //     $datas = collect($data)->skip($start)->take($pageLength);
            //     $data = [];
            //     $data = array_values($datas->toArray());

            //     // return $data;
            // }else{
            //     $data = collect($data)->skip($start)->take($pageLength);
            // }
        }else{
             // Get the total count before pagination
            // Apply pagination
            $totalRecords = $data->count();
            $start = $request->input('start', 0);
            $pageLength = $request->input('length', $request->length); // Number of records per page
            $draw = $request->input('draw');

            if ($cek_role->name == 'Project Manager' || $cek_role->name == 'Project Coordinator'){
                $data = $data->values()->toArray();
            }else{
                $data = $data;
            }

            if ($request->order) {
                if ($request->order[0]['dir'] == 'asc') {
                    $data = collect($data)->sortBy($orderByName)->values()->all();
                }else{
                    $data = collect($data)->sortByDesc($orderByName)->values()->all();
                }
            }

            if ($draw > 1) {
                $datas = collect($data)->skip($start)->take($pageLength);
                $data = [];
                $data = array_values($datas->toArray());
                // return $data;
            }else{
                $data = collect($data)->skip($start)->take($pageLength);
            }
        }

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'length' => $pageLength,
            'data' => $data,
        ]);

        // return array("data"=>$data);
    }

    public function exportExcelProjectBudgetList(Request $request){
        $spreadsheet = new Spreadsheet();

        $pbcSheet = new Worksheet($spreadsheet,'Project Budget Control');
        $spreadsheet->addSheet($pbcSheet);
        $spreadsheet->removeSheetByIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('A1:J1');
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

        $sheet->getStyle('A1:J1')->applyFromArray($titleStyle);
        $sheet->setCellValue('A1','Project Budget Control');

        $headerStyle = $normalStyle;
        $headerStyle['font']['bold'] = true;
        $sheet->getStyle('A2:J2')->applyFromArray($headerStyle);;

        $headerContent = ["No","Health Status", "Project ID", "Customer Name", "Project Name", "PM/PC", "Project Type", "Plan SBE" , "Actual SBE"];

        $sheet->fromArray($headerContent,NULL,'A2');

        if ($request->startDate && $request->endDate) {
            $startDate = $request->startDate;
            $endDate = $request->endDate;
        }else{
            $startDate = Carbon::now()->startOfYear()->format('Y-m-d');
            $endDate = Carbon::now()->endOfYear()->format('Y-m-d');
        }

        $data = PMO::join('tb_id_project','tb_pmo.project_id','=','tb_id_project.id_project')
            ->whereBetween('tb_pmo.date_time', [$startDate, $endDate])
            ->whereBetween('tb_id_project.created_at', [$startDate, $endDate])
            ->whereIn('project_type',['implementation','supply_only','maintenance'])
            ->distinct()
            ->get()->makeHidden([
                'indicator_project',
                'sign',
                'owner',
                'no_po_customer',
                'type_project_array',
                'status',
                'current_phase',
                'gantt_status',
                'implementation_type',
                'lead_id',
                'project_id',
                'id_pro',
                'nik',
                'amount_usd',
                'amount_idr',
                'date',
                'note',
                'invoice',
                'created_at',
                'updated_at',
                'progres',
                'sales_name',
                'status_po'
            ]);

        if (!empty($request->searchFor)) {
            $data = $data->filter(function ($item) use ($request) {
                return stripos($item->health_status, $request->searchFor) !== false ||
                       stripos($item->id_project, $request->searchFor) !== false ||
                       stripos($item->customer_name, $request->searchFor) !== false ||
                       stripos($item->name_project, $request->searchFor) !== false ||
                       stripos($item->project_type == 'maintenance'?'-':$item->project_pm, $request->searchFor) !== false ||
                       stripos($item->project_type == 'implementation'?'-':$item->project_pc, $request->searchFor) !== false ||
                       stripos($item->type_project, $request->searchFor) !== false ||
                       stripos($item->plan_sbe, $request->searchFor) !== false ||
                       stripos($item->actual_sbe, $request->searchFor) !== false;
            });
        }

        foreach ($data as $key => $item) {
            $outputArray[] = collect([
                "health_status"=>$item->health_status,
                "id_project"=>$item->id_project,
                "customer_name"=>$item->customer_name,
                "name_project"=>$item->name_project,
                "project_pm_pc"=>$item->project_type=='maintenance'?$item->project_pc:$item->project_pm,
                "type_project"=>$item->type_project,
                "plan_sbe"=>number_format((int)$item->plan_sbe,2,",","."),
                "actual_sbe"=>number_format((int)$item->actual_sbe,2,",",".")
            ]);
        }

        $dataPbc = $outputArray;

        foreach ($outputArray as $key => $data) {
           $sheet->fromArray(array_merge([$key + 1],array_values($data->toArray())),NULL,'A' . ($key + 3));
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(10);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);

        $fileName = 'List Project Budget Control ' . date('Y') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);
        ob_end_clean();
        return $writer->save("php://output");
    }

    public function getDetailProjectBudgetControl(Request $request)
    {
        $data = PMO::join('tb_id_project','tb_pmo.project_id','=','tb_id_project.id_project')
            ->where('tb_pmo.project_id',$request->id_project)
            ->where('tb_pmo.id',$request->id_pmo)
            ->get()->makeHidden([
                'indicator_project',
                'sign',
                'no_po_customer',
                'type_project_array',
                'status',
                'current_phase',
                'gantt_status',
                'implementation_type',
                'lead_id',
                'project_id',
                'id_pro',
                'nik',
                'amount_usd',
                'amount_idr',
                'date',
                'note',
                'invoice',
                'created_at',
                'updated_at',
                'progres',
                'sales_name',
                'status_po'
            ]);

        return $data;
    }

    public function getViewDetailProjectBudgetControl(Request $request) //view detail (settlement, claim, pr)
    {
        $data = DB::table('tb_id_project')
            ->join('tb_settlement_allowance', 'tb_id_project.id_project', '=', 'tb_settlement_allowance.pid')
            ->join('tb_settlement_entertain', 'tb_id_project.id_project', '=', 'tb_settlement_entertain.pid')
            ->join('tb_settlement_others', 'tb_id_project.id_project', '=', 'tb_settlement_others.pid')
            ->join('tb_settlement_transport', 'tb_id_project.id_project', '=', 'tb_settlement_transport.pid')
            ->select(
                'tb_id_project.id_project',
                'tb_settlement_allowance.sub_category',
                'tb_settlement_allowance.name as settlement_allowance_name',
                'tb_settlement_allowance.role as settlement_allowance_role',
                'tb_settlement_allowance.nominal as settlement_allowance_nominal',
                'tb_settlement_entertain.resto_name as settlement_entertain_resto_name',
                'tb_settlement_entertain.date as settlement_entertain_date',
                'tb_settlement_entertain.nominal as settlement_entertain_nominal',
                'tb_settlement_entertain.name as settlement_entertain_name',
                'tb_settlement_entertain.role as settlement_entertain_role',
                'tb_settlement_entertain.image as settlement_entertain_image',
                'tb_settlement_entertain.receipt as settlement_entertain_receipt',
                'tb_settlement_entertain.receipt_grab as settlement_entertain_receipt_grab',
                'tb_settlement_others.description as settlement_others_description',
                'tb_settlement_others.name as settlement_others_name',
                'tb_settlement_others.role as settlement_others_role',
                'tb_settlement_others.image as settlement_others_image',
                'tb_settlement_others.receipt as settlement_others_receipt',
                'tb_settlement_others.nominal as settlement_others_nominal',
                'tb_settlement_transport.name as settlement_transport_name',
                'tb_settlement_transport.role as settlement_transport_role',
                'tb_settlement_transport.nominal as settlement_transport_nominal',
                'tb_settlement_transport.image as settlement_transport_image'
            )
            ->paginate(20);  // Paginate with 10 records per page

        return $data;

    }

    public function getDashboardChart(Request $request)
    {   
        $cek_role = RoleUser::join('roles','role_user.role_id','=','roles.id')
                            ->select('roles.name')
                            ->where('role_user.user_id',Auth::User()->nik)->first();
        
        $itemHealthStatus = PMO::whereYear('tb_pmo.date_time',$request->year)
                ->get();

        if ($cek_role->name == 'Project Manager') {
            $itemHealthStatus = $itemHealthStatus->filter(function ($data) {
                return $data->project_pm === Auth::User()->name; // Use the accessor here
            })
            ->unique(function ($data) {
                return $data->project_id; // Use a unique attribute to remove duplicates (e.g., `id`)
            });
        }else if ($cek_role->name == 'Project Coordinator') {
            $itemHealthStatus = $itemHealthStatus->filter(function ($data) {
                return $data->project_pc === Auth::User()->name; // Use the accessor here
            })
            ->unique(function ($data) {
                return $data->project_id; // Use a unique attribute to remove duplicates (e.g., `id`)
            });
        }else{
            $itemHealthStatus = $itemHealthStatus;
        }

        $priority = [
            'On Budget' => 1,
            'Almost Over Budget' => 2,
            'Over Budget' => 3,
            '-' => 4, // Default or unknown value
        ];

        $sortedItems = $itemHealthStatus->sortBy(function ($item) use ($priority) {
            // Use the health_status accessor and map to custom priority
            return $priority[$item->health_status] ?? 999; // Fallback for undefined statuses
        });

        // Count the health statuses
        $healthStatusCounts = $sortedItems->map(function ($item) {
            return $item->health_status; // Uses the accessor 'getHealthStatusAttribute'
        })->countBy();

        // Convert to array if needed
        $healthStatusCounts = $healthStatusCounts->toArray();

        $arrayDataProjectBasedHealthStatus = [];

        $statuses = ['On Budget', 'Almost Over Budget', 'Over Budget'];

        foreach ($statuses as $status) {
            // Push the value or 0 if the key doesn't exist
            $arrayDataProjectBasedHealthStatus[] = isset($healthStatusCounts[$status]) ? $healthStatusCounts[$status] : 0;
        }

        //project running closing
        $statuses_run_closing = ['Running', 'Closing'];

        $itemsRunClosing = DB::table('tb_pmo')
            ->join('tb_pmo_assign','tb_pmo.id','=','tb_pmo_assign.id_project')
            ->selectRaw('
                         COUNT(CASE WHEN current_phase IN ("Initiating","Planning","Executing","Waiting") THEN 1 END) AS running, 
                         COUNT(CASE WHEN current_phase = "Closing" THEN 1 END) AS closing')
            ->whereYear('tb_pmo.date_time',$request->year);

        if ($cek_role->name == 'Project Coordinator' ||  $cek_role->name == 'Project Manager') {
            $itemsRunClosing = $itemsRunClosing->where('tb_pmo_assign.nik',Auth::User()->nik)->get()->first();
        }else{
            $itemsRunClosing = $itemsRunClosing->get()->first();
        }

        // Now you can access the values
        $running = $itemsRunClosing->running;
        $closing = $itemsRunClosing->closing;

        // If you want them in an array format:
        $arrayDataProjectBasedRunClosing = [$running, $closing];

        //project PM by health status
        $itemsPMHealthStatus = PMO::join('tb_id_project','tb_pmo.project_id','=','tb_id_project.id_project')
            ->whereYear('tb_pmo.date_time',$request->year)
            ->whereYear('tb_id_project.created_at',$request->year)
            ->distinct()
            ->get()
            ->makeHidden([
                'indicator_project',
                'sign',
                'owner',
                'no_po_customer',
                'type_project_array',
                'status',
                'current_phase',
                'gantt_status',
                'implementation_type',
                'lead_id',
                'id_pro',
                'nik',
                'project_id',
                'amount_usd',
                'amount_idr',
                'date',
                'note',
                'invoice',
                'created_at',
                'updated_at',
                'progres',
                'sales_name',
                'status_po',
                'parent_id_drive',
            ]);

        $filterHealthStatusPM = $itemsPMHealthStatus->filter(function ($item) {
            return $item->health_status != '-' && $item->project_type == 'implementation';
        });

        $filterHealthStatusPC = $itemsPMHealthStatus->filter(function ($item) {
            return $item->health_status != '-' && $item->project_type == 'maintenance';
        });

        // Group by project_pm and count health_status for each
        $pmCounts = $filterHealthStatusPM->groupBy('project_pm')->map(function ($items) {
            return $items->groupBy('health_status')->map->count();  // Count each health_status per PM
        });         

        // Group by project_pc and count health_status for each
        $pcCounts = $filterHealthStatusPC->groupBy('project_pc')->map(function ($items) {
            return $items->groupBy('health_status')->map->count();  // Count each health_status per PC
        });

        // Filter out the "-" index from pmCounts
        $filteredPmCounts = $pmCounts->filter(function ($value, $key) {
            return $key !== '-'; // Exclude "-"
        });

        // Filter out the "-" index from pcCounts
        $filteredPcCounts = $pcCounts->filter(function ($value, $key) {
            return $key !== '-'; // Exclude "-"
        });

        // Merge the filtered pmCounts and pcCounts, summing counts if keys overlap
        $mergedCounts = $filteredPmCounts->mergeRecursive($filteredPcCounts)
            ->map(function ($counts) {
                // If the value is an array (from mergeRecursive), sum the counts
                return is_array($counts) ? array_sum($counts) : $counts;
        });

        $processedData = collect($mergedCounts)->map(function ($healthStatuses) use ($priority, $statuses) {
            // Ensure all statuses from $statuses exist with default value 0
            $healthStatuses = collect($statuses)
                ->mapWithKeys(function ($status) use ($healthStatuses) {
                    return [$status => $healthStatuses[$status] ?? 0];
                });
            
            // Sort by priority
            return $healthStatuses->sortBy(function ($count, $healthStatus) use ($priority) {
                return $priority[$healthStatus];
            });
        });

        $user_pm_pc = User::join('role_user','users.nik','=','role_user.user_id')
                        ->join('roles','role_user.role_id','=','roles.id')
                        ->select('users.name')
                        ->where('roles.name','Delivery Project Manager')
                        ->orWhere('roles.name','Delivery Project Coordinator')
                        ->where('status_delete','<>','D')
                        ->get();

        // Combine with namesList
        $finalData = collect($user_pm_pc)->mapWithKeys(function ($nameData) use ($processedData, $statuses) {
            $name = $nameData['name'];

            // Get existing data for the name or create default statuses with 0
            $healthStatuses = $processedData->get($name, collect($statuses)
                ->mapWithKeys(fn($status) => [$status => 0]));

            return [$name => $healthStatuses];
        });

        $groupedByStatus = [
            'On Budget' => [],
            'Almost Over Budget' => [],
            'Over Budget' => []
        ];

        foreach($finalData->toArray() as $name => $finalData){
            $totalHealthStatuses = array_sum($finalData);
            $labelProjectByPMHealthStatus[] = [$name, $totalHealthStatuses];
             // Iterate over health statuses for each person
            foreach ($finalData as $status => $count) {
                $groupedByStatus[$status][] = [$count];
            }
        }

        $result = [
          'totalProjectBasedHealthStatus' => collect([
            "labels"=>$statuses,
            "dataSet"=>[
                "data"=>$arrayDataProjectBasedHealthStatus,
                "backgroundColor"=>[
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ]
            ]
          ]),
          'totalProjectRunningClosing' => collect([
            "labels"=>$statuses_run_closing,
            "dataSet"=>[
                "data"=>$arrayDataProjectBasedRunClosing,
                "backgroundColor"=>[
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)'
                ]
            ]
          ]),
          'totalPMByHealthStatus' => collect([
            "labels"=>$labelProjectByPMHealthStatus,
            "dataSet" => collect([
                "On Budget"=>[
                    "data"=>$groupedByStatus['On Budget'],
                    "backgroundColor"=>'rgba(255, 99, 132, 0.2)',
                    "borderColor"=>'rgba(255, 99, 132, 1)',
                    "borderWidth"=>1
                ],
                "Almost Over Budget"=>[
                    "data"=>$groupedByStatus['Almost Over Budget'],
                    "backgroundColor"=>'rgba(54, 162, 235, 0.2)',
                    "borderColor"=>'rgba(54, 162, 235, 1)',
                    "borderWidth"=>1
                ],
                "Over Budget"=>[
                    "data"=>$groupedByStatus['Over Budget'],
                    "backgroundColor"=>'rgba(255, 206, 86, 0.2)',
                    "borderColor"=>'rgba(255, 206, 86, 1)',
                    "borderWidth"=>1
                ],
            ]) 
          ]),
        ];

        return $result;
    }

    public function getViewDetailPBC(Request $request)
    {
        $dataSettlementAllowance = SettlementAllowance::
                join('tb_settlement','tb_settlement_allowance.id_settlement','=','tb_settlement.id')
                ->join('tb_money_request','tb_settlement.no_monreq','=','tb_money_request.id')
                ->where('pid',$request->pid)
                ->select(
                    'tb_settlement.id',
                    'tb_money_request.no_monreq as nomor',
                    'tb_settlement_allowance.date_add as dates',
                    'name',
                    DB::raw("CASE 
                        WHEN role IS NULL 
                        THEN '-' 
                        ELSE role 
                        END as role"),
                    'sub_category as category',
                    DB::raw("CONCAT(tb_settlement_allowance.sub_category, ' - ',name) AS description"),
                    'tb_settlement_allowance.nominal',
                    DB::raw("CASE 
                        WHEN file IS NULL 
                        THEN '-' 
                        ELSE file 
                        END as image")
                    )
                ->where('tb_settlement.status','DONE')
                ->get();

        foreach ($dataSettlementAllowance as $settlementAllowance) {
            $settlementAllowance->receipt = '-';
            $settlementAllowance->link_route = 'pmo/settlement/detail_settlement?id_settlement='.$settlementAllowance->id;
        }

        $dataSettlementTransport = SettlementTransport::
                join('tb_settlement','tb_settlement_transport.id_settlement','=','tb_settlement.id')
                ->join('tb_money_request','tb_settlement.no_monreq','=','tb_money_request.id')
                ->where('pid',$request->pid)
                ->select(
                    'tb_settlement.id',
                    'tb_money_request.no_monreq as nomor',
                    'tb_settlement_transport.date_add as dates',
                    'name',
                    DB::raw("CASE 
                        WHEN role IS NULL 
                        THEN '-' 
                        ELSE role 
                        END as role"),
                    'sub_category as category',
                    DB::raw("(CASE WHEN (tb_settlement_transport.sub_category = 'Toll') THEN toll_gate WHEN (tb_settlement_transport.sub_category = 'Gasoline') THEN tb_settlement_transport.sub_category WHEN (tb_settlement_transport.sub_category = 'Parking') THEN location WHEN (tb_settlement_transport.sub_category = 'Online Transport') THEN CONCAT(from_transport, ' - ', to_transport) END) as description"),
                    'tb_settlement_transport.nominal',
                    DB::raw("CASE 
                        WHEN image IS NULL 
                        THEN '-' 
                        ELSE image 
                        END as image")
                )
                ->where('tb_settlement.status','DONE')
                ->get();

        foreach ($dataSettlementTransport as $settlementTransport) {
            $settlementTransport->receipt = '-';
            $settlementAllowance->link_route = 'pmo/settlement/detail_settlement?id_settlement='.$settlementAllowance->id;
        }

        $dataSettlementOthers = SettlementOther::
                join('tb_settlement','tb_settlement_others.id_settlement','=','tb_settlement.id')
                ->join('tb_money_request','tb_settlement.no_monreq','=','tb_money_request.id')
                ->where('pid',$request->pid)
                ->select(
                    'tb_settlement.id',
                    'tb_money_request.no_monreq as nomor',
                    'tb_settlement_others.date_add as dates',
                    'name',
                    DB::raw("CASE 
                        WHEN role IS NULL 
                        THEN '-' 
                        ELSE role 
                        END as role"),
                    'sub_category as category',
                    DB::raw("CASE 
                        WHEN tb_settlement_others.description IS NULL 
                        THEN '-' 
                        ELSE tb_settlement_others.description 
                        END as description"),
                    'tb_settlement_others.nominal',
                    DB::raw("CASE 
                        WHEN image IS NULL 
                        THEN '-' 
                        ELSE image 
                        END as image"),
                    DB::raw("CASE 
                        WHEN receipt IS NULL 
                        THEN '-' 
                        ELSE receipt 
                        END as receipt"))
                ->where('tb_settlement.status','DONE')
                ->get();

        foreach ($dataSettlementOthers as $settlementOther) {
            $settlementOther->link_route = 'pmo/settlement/detail_settlement?id_settlement='.$settlementOther->id;
        }

        $dataSettlementEntertain = SettlementEntertain::
                join('tb_settlement','tb_settlement_entertain.id_settlement','=','tb_settlement.id')
                ->join('tb_money_request','tb_settlement.no_monreq','=','tb_money_request.id')
                ->where('pid',$request->pid)
                ->select(
                    'tb_settlement.id',
                    'tb_money_request.no_monreq as nomor',
                    'tb_settlement_entertain.date_add as dates',
                    'name',
                    DB::raw("CASE 
                        WHEN role IS NULL 
                        THEN '-' 
                        ELSE role 
                        END as role"),
                    'sub_category as category',
                    DB::raw("CASE 
                        WHEN resto_name IS NULL 
                        THEN '-' 
                        ELSE resto_name
                        END as description"),
                    'tb_settlement_entertain.nominal',
                    DB::raw("CASE 
                        WHEN image IS NULL 
                        THEN '-' 
                        ELSE image 
                        END as image"),
                    DB::raw("CASE 
                        WHEN receipt IS NULL 
                        THEN '-' 
                        ELSE receipt 
                        END as receipt"))
                ->where('tb_settlement.status','DONE')
                ->get();

        foreach ($dataSettlementEntertain as $settlementEntertain) {
            $settlementEntertain->link_route = 'pmo/settlement/detail_settlement?id_settlement='.$settlementEntertain->id;
        }

        $dataClaimAllowance = ClaimAllowance::
                join('tb_claim','tb_claim_allowance.id_claim','=','tb_claim.id')
                ->where('pid',$request->pid)
                ->select(
                    'tb_claim.id',
                    'tb_claim.no_claim as nomor',
                    'tb_claim_allowance.date_add as dates',
                    'name',
                    DB::raw("CASE 
                        WHEN role IS NULL 
                        THEN '-' 
                        ELSE role 
                        END as role"),
                    'sub_category as category',
                    DB::raw("CONCAT(tb_claim_allowance.sub_category, ' - ',name) AS description"),
                    'tb_claim_allowance.nominal',
                    DB::raw("CASE 
                        WHEN file IS NULL 
                        THEN '-' 
                        ELSE file 
                        END as image")
                    )
                ->where('tb_claim.status','DONE')
                ->get();

        foreach ($dataClaimAllowance as $claimAllowance) {
            $claimAllowance->receipt = '-';
            $claimAllowance->link_route = 'pmo/claim/detail_claim?id_claim='.$claimAllowance->id;
        }

        $dataClaimTransport = ClaimTransport::
                join('tb_claim','tb_claim_transport.id_claim','=','tb_claim.id')
                ->where('pid',$request->pid)
                ->select(
                    'tb_claim.id',
                    'tb_claim.no_claim as nomor',
                    'tb_claim_transport.date_add as dates',
                    'name',
                    DB::raw("CASE 
                        WHEN role IS NULL 
                        THEN '-' 
                        ELSE role 
                        END as role"),
                    'sub_category as category',
                    DB::raw("(CASE WHEN (tb_claim_transport.sub_category = 'Toll') THEN toll_gate WHEN (tb_claim_transport.sub_category = 'Gasoline') THEN tb_claim_transport.sub_category WHEN (tb_claim_transport.sub_category = 'Parking') THEN location WHEN (tb_claim_transport.sub_category = 'Online Transport') THEN CONCAT(from_transport, ' - ', to_transport) END) as description"),
                    'tb_claim_transport.nominal',
                    'image as image')
                ->where('tb_claim.status','DONE')
                ->get();

        foreach ($dataClaimTransport as $claimTransport) {
            $claimTransport->receipt = '-';
            $claimTransport->link_route = 'pmo/claim/detail_claim?id_claim='.$claimTransport->id;
        }

        $dataClaimOther = ClaimOther::
                join('tb_claim','tb_claim_others.id_claim','=','tb_claim.id')
                ->where('pid',$request->pid)
                ->select(
                    'tb_claim.id',
                    'tb_claim.no_claim as nomor',
                    'tb_claim_others.date_add as dates',
                    'name',
                    DB::raw("CASE 
                        WHEN role IS NULL 
                        THEN '-' 
                        ELSE role 
                        END as role"),
                    'sub_category as category',
                    DB::raw("CASE 
                        WHEN tb_claim_others.description IS NULL 
                        THEN '-' 
                        ELSE tb_claim_others.description 
                        END as description"),
                    'tb_claim_others.nominal',
                    DB::raw("CASE 
                        WHEN image IS NULL 
                        THEN '-' 
                        ELSE image 
                        END as image"),
                    DB::raw("CASE 
                        WHEN receipt IS NULL 
                        THEN '-' 
                        ELSE receipt 
                        END as receipt"))
                ->where('tb_claim.status','DONE')
                ->get();

        foreach ($dataClaimOther as $dataClaimOther) {
            $dataClaimOther->link_route = 'pmo/claim/detail_claim?id_claim='.$dataClaimOther->id;
        }

        $dataClaimEntertain = ClaimEntertain::
                join('tb_claim','tb_claim_entertain.id_claim','=','tb_claim.id')
                ->where('pid',$request->pid)
                ->select(
                    'tb_claim.id',
                    'tb_claim.no_claim as nomor',
                    'tb_claim_entertain.date_add as dates',
                    'name',
                    DB::raw("CASE 
                        WHEN role IS NULL 
                        THEN '-' 
                        ELSE role 
                        END as role"),
                    'sub_category as category',
                    DB::raw("CASE 
                        WHEN resto_name IS NULL 
                        THEN '-' 
                        ELSE resto_name 
                        END as description"),
                    'tb_claim_entertain.nominal',
                    DB::raw("CASE 
                        WHEN image IS NULL 
                        THEN '-' 
                        ELSE image 
                        END as image"),
                    DB::raw("CASE 
                        WHEN receipt IS NULL 
                        THEN '-' 
                        ELSE receipt 
                        END as receipt"))
                ->where('tb_claim.status','DONE')
                ->get();

        foreach ($dataClaimEntertain as $dataClaimEntertain) {
            $dataClaimEntertain->link_route = 'pmo/claim/detail_claim?id_claim='.$dataClaimEntertain->id;
        }

        $dataPr = PrProduct::join('tb_pr_product_draft','tb_pr_product.id','=','tb_pr_product_draft.id_product')
                    ->join('tb_pr','tb_pr_product_draft.id_draft_pr','=','tb_pr.id_draft_pr')
                    ->select(
                        'tb_pr.id_draft_pr as id',
                        'tb_pr_product.id as id_product',
                        'tb_pr.no_pr as nomor',
                        'tb_pr.date as dates',
                        'tb_pr_product.for as name',
                        'tb_pr.category as category',
                        'tb_pr_product.name_product as description',
                        'tb_pr_product.grand_total as nominal',
                        'roles_engineer as role',
                    )
                    ->whereIn('tb_pr.category',['Perjalanan Dinas','Akomodasi'])
                    ->where('tb_pr.project_id',$request->pid)
                    ->where('tb_pr.type_of_letter','EPR')
                    ->where('tb_pr.status','Done')
                    ->get();

        foreach ($dataPr as $pr) {
            $pr->receipt = '-';
            $pr->image = '-';
            $pr->link_route = 'admin/detail/draftPR/'.$pr->id;
        }

        $collections = collect([
            $dataSettlementAllowance,
            $dataSettlementTransport,
            $dataSettlementOthers,
            $dataSettlementEntertain,
            $dataClaimAllowance,
            $dataClaimTransport,
            $dataClaimOther,
            $dataClaimEntertain,
            $dataPr,
        ]);

        $data = array("data"=>$collections->flatten());

        return $data;
    }
}
