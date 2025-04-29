<?php


namespace App\Http\Controllers;


use App\CertificationList;
use App\CertificationListActivity;
use App\CertificationListDetail;
use App\Mail\MailCertificationList;
use App\Partnership;
use App\PartnershipCertification;
use Illuminate\Support\Str;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Support\Facades\Mail;

class CertificationListController extends Controller
{
    public function __construct()
    {
    }

    public function dashboard()
    {
        return view('certification_list.dashboard')->with(['initView' => $this->initMenuBase()]);
    }

    public function getChartExamByStatus(Request $request)
    {
        $data = DB::table('tb_certification_list')
            ->join('tb_certification_list_detail', 'tb_certification_list.id', '=', 'tb_certification_list_detail.certification_list_id')
            ->select('tb_certification_list.status', DB::raw('COUNT(tb_certification_list_detail.id) as total'))
            ->groupBy('tb_certification_list.status')
            ->where('tb_certification_list.status', '!=', 'Saved');

        if ($request->startDate != null && $request->endDate != null){
            $data = $data->whereDate('tb_certification_list.created_at', '>=', $request->startDate)
                ->whereDate('tb_certification_list.created_at', '<=', $request->endDate);
        }

        $data = $data->get();

        return $data;
    }

    public function getChartExam(Request $request)
    {
        $dataExamDate = DB::table('tb_certification_list')
            ->join('tb_certification_list_detail', 'tb_certification_list.id', '=', 'tb_certification_list_detail.certification_list_id')
            ->whereNotNull('tb_certification_list_detail.exam_date')
            ->where('tb_certification_list.status', '!=', 'Saved');

        $dataRequestDate = DB::table('tb_certification_list')
            ->join('tb_certification_list_detail', 'tb_certification_list.id', '=', 'tb_certification_list_detail.certification_list_id')
            ->whereNull('tb_certification_list_detail.exam_date')
            ->where('tb_certification_list.status', '!=', 'Saved');

        if ($request->startDate && $request->endDate) {
            $dataExamDate = $dataExamDate->whereBetween('tb_certification_list.created_at', [$request->startDate, $request->endDate]);
            $dataRequestDate = $dataRequestDate->whereBetween('tb_certification_list.created_at', [$request->startDate, $request->endDate]);
        }

        $data = [
            [
                'status' => 'Exam Date',
                'total' => $dataExamDate->count(),
            ],
            [
                'status' => 'Request Date',
                'total' => $dataRequestDate->count(),
            ],
        ];

        return response()->json($data);
    }

    public function getChartExamByPurpose(Request $request)
    {
        $data = DB::table('tb_certification_list')
            ->join('tb_certification_list_detail', 'tb_certification_list.id', '=', 'tb_certification_list_detail.certification_list_id')
            ->select('tb_certification_list.exam_purpose as purpose', DB::raw('COUNT(tb_certification_list_detail.id) as total'))
            ->groupBy('tb_certification_list.exam_purpose')
            ->where('tb_certification_list.status', '!=', 'Saved');

        if ($request->startDate != null && $request->endDate != null){
            $data = $data->whereDate('tb_certification_list.created_at', '>=', $request->startDate)
                ->whereDate('tb_certification_list.created_at', '<=', $request->endDate);
        }

        $data = $data->get();

        return $data;
    }

    public function getChartExamByDivision(Request $request)
    {
        $data = DB::table('tb_certification_list')
            ->join('tb_certification_list_detail', 'tb_certification_list.id', '=', 'tb_certification_list_detail.certification_list_id')
            ->join('role_user as ru', 'tb_certification_list_detail.participant_nik', 'ru.user_id')
            ->join('roles as r', 'ru.role_id', 'r.id')
            ->select('r.group as division', DB::raw('COUNT(tb_certification_list_detail.id) as total'))
            ->groupBy('r.group')
            ->where('tb_certification_list.status', '!=', 'Saved');

        if ($request->startDate != null && $request->endDate != null){
            $data = $data->whereDate('tb_certification_list.created_at', '>=', $request->startDate)
                ->whereDate('tb_certification_list.created_at', '<=', $request->endDate);
        }

        $data = $data->get();

        return $data;
    }

    public function getChartExamByPartner(Request $request)
    {
        $data = DB::table('tb_certification_list')
            ->join('tb_certification_list_detail', 'tb_certification_list.id', '=', 'tb_certification_list_detail.certification_list_id')
            ->select('tb_certification_list.vendor as partner', DB::raw('COUNT(tb_certification_list_detail.id) as total'))
            ->groupBy('tb_certification_list.vendor')
            ->where('tb_certification_list.status', '!=', 'Saved');

        if ($request->startDate != null && $request->endDate != null){
            $data = $data->whereDate('tb_certification_list.created_at', '>=', $request->startDate)
                ->whereDate('tb_certification_list.created_at', '<=', $request->endDate);
        }

        $data = $data->get();

        return $data;
    }

    public function getChartExamByLevel(Request $request)
    {
        $data = DB::table('tb_certification_list')
            ->join('tb_certification_list_detail', 'tb_certification_list.id', '=', 'tb_certification_list_detail.certification_list_id')
            ->select('tb_certification_list_detail.level as level', DB::raw('COUNT(tb_certification_list_detail.id) as total'))
            ->groupBy('tb_certification_list_detail.level')
            ->where('tb_certification_list.status', '!=', 'Saved')
            ->whereNotNull('tb_certification_list_detail.level');

        if ($request->startDate != null && $request->endDate != null){
            $data = $data->whereDate('tb_certification_list.created_at', '>=', $request->startDate)
                ->whereDate('tb_certification_list.created_at', '<=', $request->endDate);
        }

        $data = $data->get();

        return $data;
    }

    public function index()
    {
        $leadId = DB::table('sales_lead_register')
            ->whereRaw("(`result` = 'INITIAL' OR `result` = '' OR  `result` = 'SD' OR `result` = 'TP')")
            ->select('lead_id','opp_name')
            ->orderByDesc('created_at')
            ->get();

        $pid = DB::table('tb_id_project')->where('status', 'NEW')
            ->select('id_project', 'name_project')
            ->orderByDesc('id_pro')
            ->get();

        $role = Auth::user()->roles()->first()->name;

        return view('certification_list.index',compact('leadId', 'pid','role'))->with(['initView'=> $this->initMenuBase()]);
    }

    public function getDataTopExpiring(Request $request)
    {
        $query = DB::table('tb_certification_list as c')
            ->join('tb_certification_list_detail as cd', 'c.id', 'cd.certification_list_id')
            ->join('users as u', 'c.nik', 'u.nik')
            ->select('u.name', 'cd.exam_name', 'cd.expired_date')
            ->whereBetween('cd.expired_date', [
                Carbon::now()->startOfDay(),
                Carbon::now()->addMonths(3)->endOfDay()
            ])
//            ->whereNotNull('cd.expired_date')
            ->orderBy('cd.expired_date')
            ->limit(10)
            ->get();

        return array('data' => $query);
    }
    public function getDataByFilter(Request $request)
    {
        $role = Auth::user()->roles()->first()->name;
        $nik = Auth::user()->nik;
        $query = DB::table('tb_certification_list as c')
            ->join('users as u', 'c.nik', 'u.nik')
            ->leftJoin('users as u2', 'c.circular_on', 'u2.nik')
            ->select('u.name', 'c.vendor', 'c.exam_purpose', 'u2.name as circular', 'c.is_circular', 'c.status','c.nik','c.id',
            DB::raw('DATE(c.created_at) as date'));

        if ($role == 'Chief Operating Officer' || $role == 'People Operations & Services Manager' ||
            $role == 'Learning & HR Technology' || $role == 'VP Solutions & Partnership Management'){
            $query = $query;
        }else if(str_contains($role, 'Manager')){
            $query = $query->where('c.nik_manager', $nik)->orwhere('c.nik', $nik);
        }else{
            $query = $query->where('c.nik', $nik);
        }

        if($request->startDate != '' && $request->endDate != '' ){
            $query = $query->whereDate('c.created_at', '>=', $request->startDate)
                ->whereDate('c.created_at', '<=', $request->endDate);
        }

        $result = $query->orderByDesc('c.created_at')->get();

        return array('data' => $result);
    }

    public function getRequestDetail(Request $request)
    {
        $detail = DB::table('tb_certification_list as c')
            ->join('tb_certification_list_detail as cd', 'c.id', 'cd.certification_list_id')
            ->select('cd.exam_name as name', 'cd.exam_code as code', 'cd.level', 'cd.exam_deadline as deadline', 'cd.id')
            ->where('c.id', $request['id_request'])
            ->get();

        return collect(['data' => $detail]);
    }

    public function getDetailById(Request $request)
    {
        $detail = DB::table('tb_certification_list_detail as cd')
            ->select('cd.exam_name as name', 'cd.exam_code as code', 'cd.level', 'cd.exam_deadline as deadline', 'cd.id')
            ->where('cd.id', $request['id'])
            ->get();

        return $detail;
    }

    public function getDetail(Request $request)
    {
        $detail = DB::table('tb_certification_list as c')
            ->join('users as u', 'c.nik', 'u.nik')
            ->select('u.name as request_name', 'c.vendor', 'c.exam_purpose', 'c.status_renewal','c.lead_id', 'c.project_phase',
            'c.pid', 'c.project_title', DB::raw('DATE(c.created_at) as request_date'))
            ->where('c.id', $request['id_request'])
            ->first();
        return collect(['request' => $detail]);
    }

    public function getActivity(Request $request)
    {
        $activity = CertificationListActivity::where('certification_list_id', $request['id_request'])
            ->orderByDesc('id')->get();
        return collect(['data' => $activity]);
    }

    public function getParticipantList(Request $request)
    {
        $participant = CertificationListDetail::where('certification_list_id', $request['id_request'])
            ->get();
        return collect(['data' => $participant]);
    }

    public function getPreview(Request $request)
    {
        $id = $request['id_request'];

        $exam = CertificationList::find($id);
        $examDetail = CertificationListDetail::where('certification_list_id', $id)->get();
        return collect(['request' => $exam, 'detail' => $examDetail]);
    }

    public function storeRequest(Request $request)
    {
        $examPurpose = $request['exam_purpose'];
        $vendor = $request['vendor'];
        $leadId = $request['lead_id'];
        $statusRenewal = $request['status_renewal'];
        $pid = $request['pid'];
        $projectTitle = $request['project_title'];
        $projectPhase = $request['project_phase'];
        $nik = Auth::user()->nik;
        $examPurposeString = implode(", ", $examPurpose);

        try {
            DB::beginTransaction();
            $examRequest = new CertificationList();
            $examRequest->nik = $nik;
            $examRequest->vendor = $vendor;
            $examRequest->exam_purpose = $examPurposeString;
            $examRequest->status = 'Saved';
            if ($leadId != null || !empty($leadId)){
                $examRequest->lead_id = $leadId;
                $examRequest->project_title = $projectTitle;
            }elseif ($pid != null || !empty($leadId)){
                $examRequest->pid = $pid;
                $examRequest->project_title = $projectTitle;
            }
            if ($statusRenewal != null || !empty($statusRenewal)){
                $examRequest->status_renewal = $statusRenewal;
            }
            if ($projectPhase != null){
                $examRequest->project_phase = $projectPhase;
            }
            $examRequest->save();

            DB::commit();
            return $examRequest->id;
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getTraceAsString());
            return $e->getMessage();
        }
    }

    public function updateRequest(Request $request)
    {
        $examPurpose = $request['exam_purpose'];
        $vendor = $request['vendor'];
        $leadId = $request['lead_id'];
        $statusRenewal = $request['status_renewal'];
        $pid = $request['pid'];
        $projectTitle = $request['project_title'];
        $projectPhase = $request['project_phase'];
        $nik = Auth::user()->nik;
        $examPurposeString = implode(", ", $examPurpose);

        try {
            DB::beginTransaction();
            $examRequest = CertificationList::find($request['id_request']);
            $examRequest->nik = $nik;
            $examRequest->vendor = $vendor;
            $examRequest->exam_purpose = $examPurposeString;
            $examRequest->status = 'Saved';
            if ($leadId != null || !empty($leadId)){
                $examRequest->lead_id = $leadId;
                $examRequest->project_title = $projectTitle;
            }elseif ($pid != null || !empty($leadId)){
                $examRequest->pid = $pid;
                $examRequest->project_title = $projectTitle;
            }
            if ($statusRenewal != null || !empty($statusRenewal)){
                $examRequest->status_renewal = $statusRenewal;
            }
            if ($projectPhase != null){
                $examRequest->project_phase = $projectPhase;
            }
            $examRequest->save();
            DB::commit();
            return $examRequest->id;
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getTraceAsString());
            return $e->getMessage();
        }
    }

    public function storeRequestDetail(Request $request)
    {
        $examName = $request['exam_name'];
        $examCode = $request['exam_code'];
        $examDeadline = $request['exam_deadline'];
        $level = $request['level'];
        $idRequest = $request['id_request'];
        $role = Auth::user()->roles()->first();
        $nik = Auth::user()->nik;
        $name = Auth::user()->name;
        try {
            DB::beginTransaction();
            $exam = CertificationList::find($idRequest);
            $examDetail = new CertificationListDetail();
            $examDetail->certification_list_id = $idRequest;
            $examDetail->exam_code = $examCode;
            $examDetail->exam_name = $examName;
            $examDetail->level = $level;
            $examDetail->exam_deadline = $examDeadline;
            if ($role->name == 'Learning & HR Technology' || $role->name == 'Channeling Partnership & Marketing'){
                if (strpos($exam->exam_purpose, "Self Enhancement") !== false) {
                    $examDetail->participant_name = $name;
                    $examDetail->participant_nik = $nik;
                    $examDetail->departement = $role->mini_group;
                }
            }else {
                $examDetail->participant_name = $name;
                $examDetail->participant_nik = $nik;
                $examDetail->departement = $role->mini_group;
            }
            $examDetail->save();
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getTraceAsString());
            return $e->getMessage();
        }
    }

    public function updateRequestDetail(Request $request)
    {
        $examName = $request['exam_name'];
        $examCode = $request['exam_code'];
        $examDeadline = $request['exam_deadline'];
        $level = $request['level'];
        $idRequest = $request['id_request'];
        $idDetail = $request['id_detail'];
        try {
            DB::beginTransaction();
            $examDetail = CertificationListDetail::find($idDetail);
            $examDetail->update([
               'exam_name' => $examName,
               'exam_code' => $examCode,
               'exam_deadline' => $examDeadline,
               'level' => $level
            ]);

            DB::commit();
        }catch (\Exception $exception)
        {
            DB::rollBack();
            Log::error($e->getTraceAsString());
            return $exception->getMessage();
        }
    }

    public function storeLastStepRequest(Request $request)
    {
        $id = $request['id_request'];
        $name = Auth::user()->name;
        $role = Auth::user()->roles()->first()->name;
        $nikLHR = $this->getNikByRole('Learning & HR Technology');
        try {
            DB::beginTransaction();
                $exam = CertificationList::find($id);

                if ($role == 'Channeling Partnership & Marketing' || $role == 'Learning & HR Technology'){
                    if ($role == 'Channeling Partnership & Marketing'){
                        if (strpos($exam->exam_purpose, "Self Enhancement") !== false){
                            $manager = $this->getManagerByRole($role);
                            if ($manager == null){
                                $vp = $this->getVpByRole($role);
                                $exam->nik_manager = $vp;
                            }else{
                                $exam->nik_manager = $manager;
                            }
                        }
                    }else{
                        if (strpos($exam->exam_purpose, "Self Enhancement") !== false){
                            $manager = $this->getManagerByRole($role);
                            if ($manager == null){
                                $vp = $this->getVpByRole($role);
                                $exam->nik_manager = $vp;
                            }else{
                                $exam->nik_manager = $manager;
                            }
                        }
                    }
                }else{
                    $manager = $this->getManagerByRole($role);
                    if ($manager == null){
                        $vp = $this->getVpByRole($role);
                        $exam->nik_manager = $vp;
                    }else{
                        $exam->nik_manager = $manager;
                    }
                }

                $exam->status = 'New';
                if ($role != 'Learning & HR Technology'){
                    $exam->is_circular = 1;
                    $exam->circular_on = $nikLHR->nik;
                }

                $exam->save();

                $activity = CertificationListActivity::create([
                    'certification_list_id' => $id,
                    'operator' => $name,
                    'activity' => $name. ' Create new request',
                    'status' => 'New',
                    'date' => Carbon::today()
                ]);

             if ($role != 'Learning & HR Technology'){
                 $userToSend = $this->getUserByNik($nikLHR->nik);
                 $subject = '[SIMS-APP] New Certification Request';
                 Mail::to($userToSend->email)->send(new MailCertificationList($subject, $exam, $userToSend, 'NEW', null));
             }
            DB::commit();
            return 'sukses';
        }catch (\Exception $exception){
            DB::rollBack();
            Log::error($exception->getTraceAsString());
            return $exception->getMessage() . ' - ' . $exception->getTraceAsString();
        }
    }

    public function updateLastStepRequest(Request $request)
    {
        $id = $request['id_request'];
        $name = Auth::user()->name;
        $role = Auth::user()->roles()->first()->name;
        try {
            DB::beginTransaction();
                $exam = CertificationList::find($id);
                $nikLHR = $this->getNikByRole('Learning & HR Technology');
//                if ($role == 'Channeling Partnership & Marketing' || $role == 'Learning & HR Technology'){
//                    if ($role == 'Channeling Partnership & Marketing'){
//                        if (strpos($exam->exam_purpose, "Self Enhancement") !== false){
//                            $manager = $this->getManagerByRole($role);
//                            if ($manager == null){
//                                $vp = $this->getVpByRole($role);
//                                $exam->nik_manager = $vp;
//                            }else{
//                                $exam->nik_manager = $manager;
//                            }
//                        }
//                    }else{
//                        if (strpos($exam->exam_purpose, "Self Enhancement") !== false){
//                            $manager = $this->getManagerByRole($role);
//                            if ($manager == null){
//                                $vp = $this->getVpByRole($role);
//                                $exam->nik_manager = $vp;
//                            }else{
//                                $exam->nik_manager = $manager;
//                            }
//                        }
//                    }
//                }else{
//                    $manager = $this->getManagerByRole($role);
//                    if ($manager == null){
//                        $vp = $this->getVpByRole($role);
//                        $exam->nik_manager = $vp;
//                    }else{
//                        $exam->nik_manager = $manager;
//                    }
//                }
                $exam->is_rejected = null;
                $exam->reject_note = null;
                $exam->is_circular = 1;
                $exam->circular_on = $nikLHR->nik;
                $exam->status = 'Update';

                $exam->save();

                $activity = CertificationListActivity::create([
                    'certification_list_id' => $id,
                    'operator' => $name,
                    'activity' => $name. ' has updated the request',
                    'status' => 'Update',
                    'date' => Carbon::today()
                ]);
            $nikLHR = $this->getNikByRole('Learning & HR Technology');
            $userToSend = $this->getUserByNik($nikLHR->nik);
            $subject = '[SIMS-APP] Update Certification Request';
            Mail::to($userToSend->email)->send(new MailCertificationList($subject, $exam, $userToSend, 'EDIT', null));
            DB::commit();
            return collect(['status' => 'success']);
        }catch (\Exception $exception){
            DB::rollBack();
            Log::error($e->getTraceAsString());
            return $exception->getMessage();
        }
    }

    public function deleteDetail(Request $request)
    {
        $id = $request['id'];
        try {
            DB::beginTransaction();
            $examDetail = CertificationListDetail::find($id);
            $examDetail->delete();
            DB::commit();
            return 'Sukses';
        }catch (\Exception $exception){
            DB::rollBack();
            Log::error($e->getTraceAsString());
            return $exception->getMessage();
        }
    }

    public function detail($id)
    {
        $leadId = DB::table('sales_lead_register')
            ->whereRaw("(`result` = 'INITIAL' OR `result` = '' OR  `result` = 'SD' OR `result` = 'TP')")
            ->select('lead_id','opp_name')
            ->orderByDesc('created_at')
            ->get();

        $pid = DB::table('tb_id_project')->where('status', 'NEW')
            ->select('id_project', 'name_project')
            ->orderByDesc('id_pro')
            ->get();

        $userNik = Auth::user()->nik;
        $role = Auth::user()->roles()->first()->name;
        $certification = CertificationList::find($id);
        $manager = DB::table('users as u')->join('role_user as ru', 'u.nik', 'ru.user_id')
            ->join('roles as r', 'ru.role_id', 'r.id')
            ->select('u.name', 'u.nik')
            ->where('u.status_karyawan', '!=', 'dummy')
            ->where('u.id_company', 1)
            ->where(function($query) {
                $query->where('r.name', 'like', '%Manager')
                    ->orWhere('r.name', 'like', 'VP%');
            })
            ->orderBy('u.name')
            ->get();
        return view('certification_list.detail', compact('role','userNik', 'certification','leadId','pid','manager'))->with(['initView'=> $this->initMenuBase()]);;
    }

    public function assignManager(Request $request)
    {
        $id = $request['id_request'];
        $manager = $request['manager'];
        $getData = $this->getUserByNik($manager);
        $name = Auth::user()->name;
        $getNikLHR = $this->getNikByRole('Learning & HR Technology');
        try {
            DB::beginTransaction();
            $exam = CertificationList::find($id);

            if($exam->nik_manager != null){
                $exam->nik_manager = $manager;
                $exam->circular_on = $manager;
                $exam->status = 'Circular';
                $exam->is_circular = 1;
                $exam->is_rejected = null;
                $exam->reject_note = null;

                $examActivity = CertificationListActivity::create([
                    'certification_list_id' => $exam->id,
                    'operator' => $name,
                    'activity' => $name. ' has re-assigned manager to '. $getData->name,
                    'status' => 'Re-Assign Manager',
                    'date' => Carbon::today()
                ]);
                    $status = 'CIRCULAR';
                    $subject = '[SIMS-APP] Request Certification is Ready to Approve';
                    Mail::to($getData->email)->send(new MailCertificationList($subject, $exam, $getData, $status, null));

            }else{
                $exam->nik_manager = $manager;

                $examActivity = CertificationListActivity::create([
                    'certification_list_id' => $exam->id,
                    'operator' => $name,
                    'activity' => $name. ' has assigned manager to '. $getData->name,
                    'status' => 'Assign Manager',
                    'date' => Carbon::today()
                ]);

                if ($exam->nik == $getNikLHR->nik){
                    $exam->circular_on = $manager;
                    $exam->status = 'Circular';
                    $exam->is_circular = 1;
                    $status = 'CIRCULAR';
                    $subject = '[SIMS-APP] Request Certification is Ready to Approve';
                    Mail::to($getData->email)->send(new MailCertificationList($subject, $exam, $getData, $status, null));

                }
            }
            $exam->save();
            DB::commit();
            return collect(['status' => 'success']);
        }catch (\Exception $exception){
            DB::rollBack();
            Log::error($e->getTraceAsString());
            return $exception->getMessage();
        }
    }

    public function saveParticipantChanges(Request $request)
    {
        $participants = $request->input('participants');

        foreach ($participants as $data) {
            $departement = $this->getRoleByNik($data['participant_nik']);

            $certificationDetail = CertificationListDetail::find($data['id']);
            $participantOld = $certificationDetail->participant_name;
            $certification = CertificationList::find($certificationDetail->certification_list_id);
            $certificationDetail->update([
                    'participant_nik' => $data['participant_nik'],
                    'participant_name' => $data['participant_name'],
                    'departement' => $departement->mini_group
                ]);
            if ($certification->status == 'Approved' && $certification->is_approved == 1){
                CertificationListActivity::create([
                    'certification_list_id' => $data['certification_id'],
                    'operator' => Auth::user()->name,
                    'activity' => Auth::user()->name . ' has re-assigned participant exam from '. $participantOld . ' to ' . $data['participant_name'],
                    'status' => 'Re-Assign Participant',
                    'date' => Carbon::today()
                ]);
            }elseif ($participantOld != null){
                CertificationListActivity::create([
                    'certification_list_id' => $data['certification_id'],
                    'operator' => Auth::user()->name,
                    'activity' => Auth::user()->name . ' has re-assigned participant exam from '. $participantOld . ' to ' . $data['participant_name'],
                    'status' => 'Re-Assign Participant',
                    'date' => Carbon::today()
                ]);
            }else{
                CertificationListActivity::create([
                    'certification_list_id' => $data['certification_id'],
                    'operator' => Auth::user()->name,
                    'activity' => Auth::user()->name . ' has assigned exam '. $certificationDetail->exam_name . ' to ' . $data['participant_name'],
                    'status' => 'Assign Participant',
                    'date' => Carbon::today()
                ]);
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function rejectRequest(Request $request)
    {
        $id = $request['id_request'];
        $note = $request['note'];
        $name = Auth::user()->name;

        try {
            DB::beginTransaction();
            $exam = CertificationList::find($id);
            $exam->is_rejected = 1;
            $exam->reject_note = $note;
            $exam->is_circular = null;
            $exam->circular_on = null;
            $exam->status = 'Rejected';
            $exam->save();

            $examActivity = CertificationListActivity::create([
                'certification_list_id' => $exam->id,
                'operator' => $name,
                'activity' => 'Request has rejected by '. $name,
                'status' => 'Reject Request',
                'date' => Carbon::today()
            ]);
            DB::commit();
            $nik = $exam->nik;
            $userToSend = $this->getUserByNik($nik);
            $subject = '[SIMS-APP] Request Certification Rejected by ' . $name;
            Mail::to($userToSend->email)->cc('hcm@sinergy.co.id')->send(new MailCertificationList($subject, $exam, $userToSend, 'REJECTED', $note));
            return collect(['status' => 'success']);
        }catch (\Exception $exception){
            DB::rollBack();
            Log::error($e->getTraceAsString());
            return $exception->getMessage();
        }
    }

    public function approveRequest(Request $request)
    {
        $id = $request['id_request'];
        $name = Auth::user()->name;
        $role = Auth::user()->roles()->first()->name;
        $nik = Auth::user()->nik;
        $nikCOO = $this->getNikByRole('Chief Operating Officer');
        $nikPOS = $this->getNikByRole('People Operations & Services Manager');
        $nikVpSPM = $this->getNikByRole('VP Solutions & Partnership Management');
        try {
            DB::beginTransaction();
            $exam = CertificationList::find($id);
            $manager = $exam->nik_manager;

            if ($role == 'Learning & HR Technology'){
                if ($exam->nik_manager == null) {
                    return collect(['status' => 'warning', 'message' => 'You need to assign manager first, before approve this request']);
                }
                $exam->status = 'Circular';
                $exam->is_circular = 1;
                $userToSend = $this->getUserByNik($manager);
                $exam->circular_on = $manager;
                $status = 'CIRCULAR';
                $subject = '[SIMS-APP] Request Certification is Ready to Approve';
            }else if($role == 'People Operations & Services Manager'){
                if(strpos($exam->exam_purpose, "Partnership") !== false) {
                    $exam->status = 'Approved';
                    $exam->is_approved = 1;
                    $exam->is_circular = null;
                    $exam->circular_on = null;
                    $userToSend = $this->getUserByNik($exam->nik);
                    $status = 'APPROVED';
                    $subject = '[SIMS-APP] Request Certification is Approved by '. $name;
                }else{
                    $exam->circular_on = $nikCOO->nik;
                    $exam->status = 'Circular';
                    $exam->is_circular = 1;
                    $userToSend = $this->getUserByNik($nikCOO->nik);
                    $status = 'CIRCULAR';
                    $subject = '[SIMS-APP] Request Certification is Approved by '. $name;
                }
            }else if($role == 'Chief Operating Officer'){
                $exam->status = 'Approved';
                $exam->is_approved = 1;
                $exam->is_circular = null;
                $exam->circular_on = null;
                $userToSend = $this->getUserByNik($exam->nik);
                $status = 'APPROVED';
                $subject = '[SIMS-APP] Request Certification is Approved by '. $name;
            }else if($role == 'VP Solutions & Partnership Management'){
                $exam->circular_on = $nikPOS->nik;
                $exam->status = 'Circular';
                $exam->is_circular = 1;
                $userToSend = $this->getUserByNik($nikPOS->nik);
                $status = 'CIRCULAR';
                $subject = '[SIMS-APP] Request Certification is Approved by '. $name;
            } else{
                if ($exam->nik_manager == $nik){
                    $detail = CertificationListDetail::where('certification_list_id', $exam->id)->get();
                    foreach ($detail as $d){
                        if ($d->participant_name == null){
                            return collect(['status' => 'warning', 'message' => 'You need to assign exam participant first, before approve this request']);
                        }
                    }
                }
                if(strpos($exam->exam_purpose, "Partnership") !== false) {
                    $userToSend = $this->getUserByNik($nikVpSPM->nik);
                    $exam->circular_on = $nikVpSPM->nik;
                }else{
                    $userToSend = $this->getUserByNik($nikPOS->nik);
                    $exam->circular_on = $nikPOS->nik;
                }
//                $exam->circular_on = $nikPOS->nik;
                $exam->status = 'Circular';
                $exam->is_circular = 1;
//                $userToSend = $this->getUserByNik($nikPOS->nik);
                $status = 'CIRCULAR';
                $subject = '[SIMS-APP] Request Certification is Approved by '. $name;
            }
            $exam->save();

            $examActivity = CertificationListActivity::create([
                'certification_list_id' => $exam->id,
                'operator' => $name,
                'activity' => 'Request has approved by '. $name,
                'status' => 'Approve Request',
                'date' => Carbon::today()
            ]);
            Mail::to($userToSend->email)->send(new MailCertificationList($subject, $exam, $userToSend, $status, null));
            DB::commit();
            return collect(['status' => 'success']);
        }catch (\Exception $exception){
            DB::rollBack();
            Log::error($e->getTraceAsString());
            return $exception->getMessage();
        }
    }

    public function deleteParticipant($id)
    {
        $name = Auth::user()->name;
        $nik = Auth::user()->nik;
        $roles = Auth::user()->roles()->first();
        try {
            DB::beginTransaction();
            $certificationDetail = CertificationListDetail::find($id);

            $certificationActivity = CertificationListActivity::create([
                'certification_list_id' => $certificationDetail->certification_list_id,
                'operator' => $name,
                'activity' => $name . ' has deleted exam ' . $certificationDetail->exam_name,
                'status' => 'Delete exam detail',
                'date' => Carbon::today()
            ]);
            $certificationDetail->delete();
            DB::commit();

        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getTraceAsString());
            return $e->getMessage();
        }
    }

    public function getProofExam($id)
    {
        $detailExam = CertificationListDetail::find($id);

        if (!$detailExam) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json([
            'exam_date'    => $detailExam->exam_date,
            'exam_code'    => $detailExam->exam_code,
            'expired_date' => $detailExam->expired_date,
            'status_exam'  => $detailExam->status_exam,
            'level' => $detailExam->level
        ]);
    }

    public function uploadProofExam(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $examDetail = CertificationListDetail::find($id);
            $exam = CertificationList::find($examDetail->certification_list_id);
            $participantName = $examDetail->participant_name;
            $examDetail->exam_code = $request->exam_code;
            $examDetail->exam_date = $request->exam_date;
            $examDetail->expired_date = $request->expired_date;
            $examDetail->status_exam = $request->status_exam;
            $examDetail->level = $request->level;

            if ($request->hasFile('proof_exam')) {
                $file = $request->file('proof_exam');
                $fileName = $file->getClientOriginalName();
                $mimeType = $file->getMimeType();
                $fileContent = file_get_contents($file);
                $parentID = env('GOOGLE_DRIVE_PARENT_ID_Certification');

                if ($file->getClientOriginalExtension() === 'pdf') {
                    $fileId = $this->googleDriveUploadPdf($fileName, $fileContent, $parentID);
                } else {
                    $fileId = $this->googleDriveUploadFile($fileName, $fileContent, $mimeType, $parentID);
                }

                $participantRole = $this->getRoleByNik($examDetail->participant_nik);

                if ($participantRole->group == 'Sales'){
                    $role = 'Sales';
                }else if($participantRole->name == 'Presales Support Architecture'){
                    $role = 'Presales';
                }else{
                    $role = 'Engineer';
                }

                $partnership = DB::table('tb_partnership')
                    ->where('partner',$exam->vendor)
                    ->first();

                if (empty($partnership)){
                    $idPartnership = null;
                }else{
                    $idPartnership = $partnership->id_partnership;
                }

                if ($request->status_exam == 'Pass'){
                    $checkCertificate = DB::table('tb_partnership_certification')
                        ->where('certification_list_detail_id', $id)
                        ->first();
                    if (!empty($checkCertificate)){
                        DB::table('tb_partnership_certification')
                            ->where('certification_list_detail_id', $id)
                            ->update([
                                'id_partnership' => $idPartnership,
                                'name' => $participantName,
                                'level_certification' => $role . ' - ' . $examDetail->level,
                                'name_certification' => $examDetail->exam_name,
                                'expired_date' => $request->expired_date,
                                'certification_link' => $fileId,
                                'certification_list_detail_id' => $examDetail->id
                            ]);
                    }else{
                        DB::table('tb_partnership_certification')->insert([
                            'id_partnership' => $idPartnership,
                            'name' => $participantName,
                            'level_certification' => $role . ' - '. $examDetail->level,
                            'name_certification' => $examDetail->exam_name,
                            'expired_date' => $request->expired_date,
                            'certification_link' => $fileId,
                            'certification_list_detail_id' => $examDetail->id
                        ]);
                    }
                }

                CertificationListActivity::create([
                    'certification_list_id' => $exam->id,
                    'operator' => Auth::user()->name,
                    'activity' => Auth::user()->name . ' has uploaded proof of exam '. $examDetail->exam_name,
                    'status' => 'Uplod proof of exam',
                    'date' => Carbon::today()
                ]);

                $subject = '[SIMS-APP] '. Auth::user()->name . ' has uploaded proof of exam';

                $nikLHR = $this->getNikByRole('Learning & HR Technology');
                $userToSend = $this->getUserByNik($nikLHR->nik);
                Mail::to($userToSend->email)->cc('hcm@sinergy.co.id')->send(
                    (new MailCertificationList($subject, $examDetail, $userToSend, 'Proof of Exam', null))
                    ->attachData($fileContent, $fileName, [
                        'mime' => $mimeType,
                    ])
                );

                $examDetail->certificate = $fileId;
            }
            $examDetail->save();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Success']);
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getTraceAsString());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

    }

    public function getAllUser()
    {
        $role = Auth::user()->roles()->first();
        $user = DB::table('users as u')
            ->join('role_user as ru', 'u.nik', 'ru.user_id')
            ->join('roles as r', 'ru.role_id', 'r.id')
            ->whereNot('u.status_karyawan', 'dummy')
            ->where('u.id_company',1)
            ->where('r.group', $role->group)
            ->when(!is_null($role->mini_group), function ($query) use ($role) {
                return $query->where('r.mini_group', $role->mini_group);
            })
            ->select('u.name', 'u.nik')
            ->get();

        return $user;
    }

    public function getRoleByNik($nik)
    {
        return DB::table('roles as r')->join('role_user as ru', 'r.id', 'ru.role_id')
            ->where('user_id', $nik)
            ->first();
    }

    public function getManagerByRole($role)
    {
        $getMiniGroup = DB::table('roles')->where('name', $role)->first();
        if (Str::of($getMiniGroup->name)->lower()->contains('manager') && !Str::of($getMiniGroup->name)->lower()->contains('delivery project manager')){
            $getNikManager = DB::table('roles as r')
                ->join('role_user as ru', 'r.id', 'ru.role_id')
                ->where('r.name', 'like', 'VP%')
                ->where('r.group', $getMiniGroup->group)
                ->first()->user_id;
        }elseif ($getMiniGroup->mini_group == null && Str::of($getMiniGroup->name)->lower()->startsWith('vp')){
            $getNikManager = DB::table('roles as r')
                ->join('role_user as ru', 'r.id', 'ru.role_id')
                ->join('users as u', 'ru.user_id', 'u.nik')
                ->where('r.name', 'Chief Operating Officer')
                ->whereNot('u.status_karyawan', 'dummy')
                ->first()->user_id;
        }else{
            $getNikManager = DB::table('roles as r')
                ->join('role_user as ru', 'r.id', 'ru.role_id')
                ->where('r.name', 'like', '%Manager')
                ->where('r.mini_group', $getMiniGroup->mini_group)
                ->first()->user_id;
        }

            return $getNikManager;
    }

    public function getVpByRole($role)
    {
        $getGroup = DB::table('roles')->where('name', $role)->first()->group;
        $getNikVp = DB::table('roles as r')
            ->join('role_user as ru', 'r.id', 'ru.role_id')
            ->where('r.name', 'like', 'VP%')
            ->where('r.group', $getGroup)
            ->first()->user_id;

        return $getNikVp;
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

    public function googleDriveMakeFolder($nameFolder){
        $client_folder = $this->getClient();
        $service_folder = new Google_Service_Drive($client_folder);

        $file = new Google_Service_Drive_DriveFile();
        $file->setName($nameFolder);
        $file->setMimeType('application/vnd.google-apps.folder');
        $file->setDriveId(env('GOOGLE_DRIVE_DRIVE_ID'));
        $file->setParents([env('GOOGLE_DRIVE_PARENT_ID_Quotation')]);

        $result = $service_folder->files->create(
            $file,
            array(
                'mimeType' => 'application/octet-stream',
                'uploadType' => 'multipart',
                'supportsAllDrives' => true
            )
        );

        return $result->id;
    }

    public function googleDriveUploadPdf($fileName,$pdf,$parentID){
        try {
            $client = $this->getClient();
            $service = new Google_Service_Drive($client);

            $file = new Google_Service_Drive_DriveFile();
            $file->setName($fileName);
            $file->setParents([$parentID]);

            $result = $service->files->create(
                $file,
                [
                    'data' => $pdf,
                    'mimeType' => 'application/pdf',
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

    public function googleDriveUploadFile($fileName, $fileData, $mimeType, $parentID)
    {
        try {
            $client = $this->getClient();
            $service = new \Google_Service_Drive($client);

            $file = new \Google_Service_Drive_DriveFile();
            $file->setName($fileName);
            $file->setParents([$parentID]);

            $result = $service->files->create(
                $file,
                [
                    'data' => $fileData,
                    'mimeType' => $mimeType,
                    'uploadType' => 'multipart',
                    'supportsAllDrives' => true
                ]
            );

            return $result->id;

        } catch (\Exception $e) {
            \Log::error('Google Drive upload error : ' . $e->getMessage());
            return false;
        }
    }

    public function generatePDF(Request $request)
    {
        $exam = CertificationList::find($request->id);
        $examDetail = CertificationListDetail::where('certification_list_id', $request->id)->get();
        if (strpos($exam->exam_purpose, "Partnership") !== false) {
            $approved = $this->getNikByRole('People Operations & Services Manager');
            $acknowledge = $this->getNikByRole('VP Solutions & Partnership Management');
            $roleApproved = 'People Operations & Services Manager';
            $roleAcknowledge = 'VP Solutions & Partnership Management';
        }else{
            $approved = $this->getNikByRole('Chief Operating Officer');
            $acknowledge = $this->getNikByRole('People Operations & Services Manager');
            $roleAcknowledge = 'People Operations & Services Manager';
            $roleApproved = 'Chief Operating Officer';
        }

        $dataApproved = $this->getUserByNik($approved->nik);
        $dataAcknowledge = $this->getUserByNik($acknowledge->nik);
        $user = $this->getUserByNik($exam->nik);

        $roles = DB::table('role_user as ru')->join('roles as r', 'ru.role_id', 'r.id')
            ->where('ru.user_id', $exam->nik)->first();

        $data = [
            'exam' => $exam,
            'detail' => $examDetail,
            'user' => $user,
            'role' => $roles,
            'approved' => $dataApproved,
            'roleApproved' => $roleApproved,
            'roleAcknowledge' => $roleAcknowledge,
            'acknowledge' => $dataAcknowledge
        ];

        $pdf = PDF::loadView('certification_list.certification_pdf', $data);

        return $pdf->stream('Request Certification Form.pdf');


    }
}