@extends('template.main_sneat')
@section('tittle')
    Certification List Detail
@endsection
@section('pageName')
    Certification List Detail
@endsection
@section('head_css')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-fixedcolumns-bs5/fixedcolumns.bootstrap5.css')}}" />    <link rel="preload" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmSAQhPWId5Nd6QxE8To4ADjM2a6n0BrqQdisZ/RPUlm0YycDzvNL1HHAh1nKZqI0kSbif+5upQ==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
{{--    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.2.4/themes/blue/pace-theme-barber-shop.min.css" integrity="sha512-7qRUmettmzmL6BrHrw89ro5Ki8CZZQSC/eBJTlD3YPHVthueedR4hqJyYqe1FJIA4OhU2mTes0yBtiRMCIMkzw==" crossorigin="anonymous" referrerpolicy="no-referrer"  as="style" onload="this.onload=null;this.rel='stylesheet'"/>--}}

    <style type="text/css">

        p > strong::before{
            content: "@";
        }

        input[type=file]::-webkit-file-upload-button {
            display: none;
        }

        input::file-selector-button {
            display: none;
        }

        .cbDraft:disabled,
        .cbDraft[disabled]{
            border-color: rgba(118, 118, 118, 0.3);
            background: #3c8dbc !important;
            color: #3c8dbc !important;
        }

        .icheckbox_minimal-blue:disabled{
            background: #3c8dbc !important;
        }
        .icheckbox_minimal-blue:disabled{
            background: #3c8dbc !important;
            border: 1px solid #d4d4d5;
        }

        .swal2-deny{
            display: none!important;
        }
    </style>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
    <section class="content-header">
        <h1>
            <a id="BtnBack"><button class="btn btn-sm btn-danger"><i class="bx bx-arrow-back"></i>&nbspBack</button></a>
        </h1>
    </section>
    <section class="content">
        @if($certification->is_rejected == 1)
            <div class="alert alert-danger divReasonRejectRevision" style="display: block;">
                <h4>Note Reject</h4>
               <p style="font-size: 14px;" class="reason_reject_revision"> {!! $certification->reject_note !!} </p>
           </div>
        @endif
        <div class="row mb-2" id="showDetail">
        </div>
        <div class="row mb-2" id="participantList">
            <div class="col-md-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Exam Participant</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mb-4" style="width: 100%">
                            <table id="tbParticipantList" class="table table-striped table-bordered">

                            </table>
                        </div>
                        <button id="saveExamDetail" class="btn btn-primary mt-4 " style="float: right; display: none;">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="changeLog">
            <div class="col-md-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Change Log</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="width: 100%">
                            <table id="tbChangeLog" class="table table-striped table-bordered">

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>

    <div class="modal fade" id="ModalRejectRequest" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reject Request</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="" name="">
                        <div class="form-group mb-3">
                            <label>Reject Note</label>
                            <textarea class="form-control" style="resize: vertical;" onkeyup="fillInput('reject_note')"  id="rejectNote" name="rejectNote"></textarea>
                            <span class="help-block" style="display:none;">Please fill Reason!</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" onclick="rejectRequest()" class="btn btn-danger">Reject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAssignManager" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Assign Manager</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="" name="">
                        <div class="form-group mb-2">
                            <label>Assign Manager</label>
                            <select class="form-control select2" onchange="fillInput('assign_manager')" style="width: 100%" id="assignManager" name="assignManager">
                                <option value="">--Choose Manager--</option>
                                @foreach($manager as $data)
                                    <option value="{{$data->nik}}">{{$data->name}}</option>
                                @endforeach
                            </select>
                            <span class="help-block" style="display:none;">Please fill Manager!</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btnSubmitAssignManager">Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAdd" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-md">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()">
                        <span aria-hidden="true"></span></button>
                    <h4 class="modal-title">Add Request</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="modalAddRequest" name="modalAddRequest">
                        @csrf
                        <div class="tab-add" style="display: none;">
                            <div class="tabGroup">
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Exam Purpose*</label>
                                            <select name="examPurpose[]" id="examPurpose" class="form-control select2" required style="width: 100%" onchange="fillInput('exam_purpose')">
                                                <option value=""></option>
                                                <option value="Project">Project</option>
                                                {{--                                                <option value="Project (ongoing)">Project (On Going)</option>--}}
                                                <option value="Partnership">Partnership</option>
                                                <option value="Self Enhancement">Self Enhancement</option>
                                                <option value="Renewal">Renewal</option>
                                            </select>
                                            <span class="invalid-feedback" style="display:none;">Please fill Exam Purpose!</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Vendor*</label>
                                            <input type="text" name="vendor" id="vendor" class="form-control" placeholder="" onkeyup="fillInput('vendor')" required>
                                            <span class="invalid-feedback" style="display:none;">Please fill Vendor!</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Project Phase</label>
                                            <select name="projectPhase" id="projectPhase" class="custom-form-control-select w-100" style="width: 100%; " onchange="fillInput('projectPhase')" disabled>
                                                <option value="">--Choose Project Phase--</option>
                                                <option value="Opportunity">Opportunity</option>
                                                <option value="Tender Submission">Tender Submission</option>
                                                <option value="On Going">On Going</option>
                                            </select>
                                            <span class="invalid-feedback" style="display:none;">Please fill Project Phase!</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group" id="leadIdGroup">
                                            <label for="">Lead ID</label>
                                            <select name="leadId" id="leadId" class="form-control" style="width: 100%" onchange="fillInput('lead_id')">
                                                <option value="">--Choose Lead ID--</option>
                                                @foreach($leadId as $lead)
                                                    <option value="{{$lead->lead_id}}">{{$lead->lead_id . ' - ' . $lead->opp_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback" style="display:none;">Please fill Lead ID!</span>
                                        </div>
                                        <div class="form-group" style="display: none;" id="pidGroup">
                                            <label for="">PID</label>
                                            <select name="pid" id="pid" class="form-control" style="width: 100%" onchange="fillInput('pid')">
                                                <option value="">--Choose PID--</option>
                                                @foreach($pid as $p)
                                                    <option value="{{$p->id_project}}">{{$p->id_project . ' - ' . $p->name_project}}</option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback" style="display:none;">Please fill PID!</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Project Title</label>
                                            <input type="text" class="form-control" name="projectTitle" id="projectTitle" placeholder="" readonly>
                                            <span class="invalid-feedback" style="display: none;">Please fill Project Title!</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Status Renewal</label>
                                            <select name="renewal" id="renewal" class="custom-form-control-select w-100" style="width: 100%" onchange="fillInput('renewal')">
                                                <option value="">--Choose Status Renewal--</option>
                                                <option value="1">Renewal ke-1</option>
                                                <option value="2">Renewal ke-2</option>
                                                <option value="3">Renewal ke-3</option>
                                                <option value="4">Renewal ke-4</option>
                                                <option value="5">Renewal ke-5</option>
                                                <option value="6">Renewal ke-6</option>
                                                <option value="7">Renewal ke-7</option>
                                            </select>
                                            <span class="invalid-feedback" style="display:none;">Please fill Status Renewal!</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-add" style="display: none;">
                            <div class="tabGroup">
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Exam Name*</label>
                                            <input autocomplete="off" type="text" name="examName" class="form-control" id="examName" placeholder="" onkeyup="fillInput('exam_name')">
                                            <span class="invalid-feedback" style="display:none;">Please fill Exam Name!</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Exam Code*</label>
                                            <input autocomplete="off" type="text" name="examCode" class="form-control" id="examCode" placeholder="" onkeyup="fillInput('exam_code')">
                                            <span class="invalid-feedback" style="display:none;">Please fill Exam Code!</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Exam Deadline</label>
                                            <input autocomplete="off" type="date" name="examDeadline" class="form-control" id="examDeadline" placeholder="" onkeyup="fillInput('exam_deadline')">
                                            <span class="invalid-feedback" style="display:none;">Please fill Exam Deadline!</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="margin-bottom:10px">
                                        <label>Level</label>
                                        <select style="width:100%;display:inline;" class="custom-form-control-select w-100" id="level" placeholder="" onchange="fillInput('level')">
                                            <option value="">--Choose Level--</option>
                                            <option value="Associate">Associate</option>
                                            <option value="Professional">Professional</option>
                                            <option value="Expert">Expert</option>
                                        </select>
                                        <span class="invalid-feedback" style="display:none;">Please fill Level!</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-add" style="display:none">
                            <div class="tabGroup table-responsive">
                                <table class="table">
                                    <thead>
                                    <th>No</th>
                                    <th>Exam Name</th>
                                    <th>Exam Code</th>
                                    <th>Level</th>
                                    <th>Exam Deadline</th>
                                    <th><a class="pull-right" onclick="refreshTable()"><i class="bx bx-refresh"></i>&nbsp</a></th>
                                    </thead>
                                    <tbody id="tbodyPreview">
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group" style="display:flex;margin-top: 10px;">
                                <button class="btn btn-sm btn-primary" style="margin: 0 auto;" type="button" id="addParticipant"><i class="bx bx-plus"></i>&nbsp Add New Exam</button>
                            </div>
                        </div>
                        <div class="tab-add" style="display:none">
                            <div class="tabGroup">
                                <div class="row">
                                    <div class="col-md-12" id="headerPreviewFinal">

                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table" style="white-space: nowrap;">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Exam Name</th>
                                                <th>Exam Code</th>
                                                <th>Level</th>
                                                <th>Exam Deadline</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tbodyPreviewFinal">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="prevBtnAdd">Back</button>
                            <button type="button" class="btn btn-primary" id="nextBtnAdd">Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalProofExam" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Proof of Exam</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="" name="">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Exam Date*</label>
                                    <input type="date" class="form-control" id="proofExamDate" >
                                    <span class="invalid-feedback" style="display:none;">Please fill Exam Date!</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Exam Code*</label>
                                    <input type="text" class="form-control" id="proofExamCode" value=""/>
                                    <span class="invalid-feedback" style="display:none;">Please fill Exam Code!</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Expired Date*</label>
                                    <input type="date" class="form-control" id="proofExpiredDate" value="">
                                    <div class="form-check mt-1">
                                        <input type="checkbox" class="form-check-input" id="lifetimeCheck">
                                        <label class="form-check-label" for="lifetimeCheck">Lifetime</label>
                                    </div>
                                    <span class="invalid-feedback" style="display:none;">Please fill Expired Date!</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status Exam*</label>
                                    <select name="" id="proofStatusExam" class="custom-form-control-select w-100">
                                        <option value="">-- Choose Status Exam --</option>
                                        <option value="Pass">Pass</option>
                                        <option value="Fail">Fail</option>
                                    </select>
                                    <span class="invalid-feedback" style="display:none;">Please fill Status Exam!</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Level*</label>
                                    <select name="" id="proofLevel" class="custom-form-control-select w-100">
                                        <option value="">-- Choose Level --</option>
                                        <option value="Associate">Associate</option>
                                        <option value="Professional">Professional</option>
                                        <option value="Expert">Expert</option>
                                    </select>
                                    <span class="invalid-feedback" style="display:none;">Please fill Level!</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Upload Proof of Exam*</label>
                                <input type="file" class="form-control" id="proofExam">
                                <span class="invalid-feedback" style="display:none;">Please fill Proof of Exam!</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="btnSubmitProofExam">Submit</button>
                </div>
                </div>
            </div>
        </div>
@endsection
@section('scriptImport')
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    {{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap.min.js"></script>--}}
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.2.4/pace.min.js" integrity="sha512-2cbsQGdowNDPcKuoBd2bCcsJky87Mv0LEtD/nunJUgk6MOYTgVMGihS/xCEghNf04DPhNiJ4DZw5BxDd1uyOdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
    <script src="{{ url('js/jquery.slimscroll.min.js')}}"></script>
    <script src="{{ url('js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ url('js/roman.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
    <script src="{{asset('js/jquery.events.input.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.elastic.js')}}" type="text/javascript"></script>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#BtnBack").click(function(){
                $("#BtnBack").attr("href", "{{url('/certification_list')}}")
            })
            $("#examPurpose").change(function () {
                let selectedOptions = $(this).val();
                if (selectedOptions.includes("Project")) {
                    $("#projectPhase").prop("disabled", false);
                }else {
                    $("#projectPhase").prop("disabled", true);
                    $("#projectPhase").val("");
                }
            });

            $("#projectPhase").change(function () {
                let selectedOptions = $(this).val();
                if (selectedOptions.includes("On Going")) {
                    $("#leadIdGroup").hide().prop("disabled", true);
                    $("#pidGroup").show().prop("disabled", false);
                }else{
                    $("#leadIdGroup").show().prop("disabled", false);
                    $("#pidGroup").hide().prop("disabled", true);
                }
            })

            function updateProjectTitle() {
                var leadText = $("#leadId option:selected").text();
                var pidText = $("#pid option:selected").text();

                if ($("#leadIdGroup").is(":visible") && leadText !== "--Choose Lead ID--") {
                    $("#projectTitle").val(leadText.split(' - ')[1]); // Ambil nama proyek setelah "-"
                } else if ($("#pidGroup").is(":visible") && pidText !== "--Choose PID--") {
                    $("#projectTitle").val(pidText.split(' - ')[1]); // Ambil nama proyek setelah "-"
                } else {
                    $("#projectTitle").val("");
                }
            }

            $("#leadId, #pid").change(updateProjectTitle);

            $("#examPurpose").select2({
                placeholder: " Select Exam Purpose",
                allowClear: true,
                multiple:true,
                closeOnSelect:true,
                dropdownParent:$("#modalAdd")
            });
            $("#examPurpose option[value='']").remove();

            $('#leadId').select2({
                dropdownParent:$("#modalAdd")
            });
            $('#pid').select2({
                dropdownParent:$("#modalAdd")
            });
            $('#assignManager').select2({
                dropdownParent:$("#modalAssignManager")
            });

            $("#lifetimeCheck").change(function () {
                if (this.checked) {
                    $("#proofExpiredDate").val('').prop("disabled", true);
                } else {
                    $("#proofExpiredDate").prop("disabled", false);
                }
            });

            $('#modalAdd').on('hidden.bs.modal', function () {
                $(".tab-add").css('display','none')
                currentTab = 0
                n = 0
                $(this)
                    .find("input,textarea,select")
                    .val('')
                    .prop("disabled",false)
                    .end()
                    .find("input[type=checkbox], input[type=radio]")
                    .prop("checked", "")
                    .end();
                localStorage.setItem('firstLaunch', true);
                localStorage.setItem('isStore',false);
                localStorage.setItem('isEditParticipant',false)
            })

            // Pace.restart()
            // Pace.track(function () {
                showDetail()
            // })

            function showDetail(){
                localStorage.setItem('id_request', window.location.href.split("/")[5]);
                loadDataSubmitted(localStorage.getItem('id_request'))

                append = ""
                append = append + '<div class="col-md-12 tabGroup">'
                append = append + '<div class="row">'
                append = append + '<div class="col-md-12">'
                append = append + '<div class="card">'
                append = append + '<div class="card-body">'
                append = append + '<div class="row">'
                append = append + '<div class="col-md-12">'
                append = append + '<span><b>Action</b></span><br>'
                @if($certification->nik == $userNik)
                    append = append + '<button class="btn btn-sm btn-primary" style="margin-right:5px" id="btnEdit" data-bs-target="#modalAdd" data-bs-toggle="modal" onclick="unfinishedDraft(0, ' + window.location.href.split("/")[5] + ', null)" ><i class="bx bx-pencil"></i> Edit</button>'
                @endif
                @if ($certification->circular_on == $userNik)
                    append = append + '<button class="btn btn-sm btn-danger" style="margin-right:5px" id="btnReject" data-bs-target="#ModalRejectRequest" data-bs-toggle="modal">Reject</button>';
                    append = append + '<button class="btn btn-sm btn-success" style="margin-right:5px" id="btnApprove" onclick="approveRequest()">Approve</button>';
                @endif
                @if ($role == 'Learning & HR Technology' && $certification->status != 'Approved' && $certification->is_approved != 1)
                    append = append + '<button class="btn btn-sm btn-primary" style="margin-right:5px" id="btnAssignManager" data-bs-target="#modalAssignManager" data-bs-toggle="modal"><i class="bx bx-plus"></i> Assign Manager</button>';
                @endif

                @if($certification->is_approved == 1)
                    append = append + '<a href="{{url('certification_list/generatePDF?id='.$certification->id)}}" id="btnShowPdf" target="_blank" class="btn btn-sm btn-warning pull-right" >Show PDF</a>'
                @endif
                    append = append + '</div>'
                append = append + '</div>'
                append = append + '<hr>'
                append = append + '<div class="row">'
                append = append + '<div class="col-md-12">'
                append = append + '<div id="headerPreview">'
                append = append + '</div>'
                append = append + '</div>'
                append = append + '</div>'

                append = append + '</div>'
                append = append + '</div>'
                append = append + '</div>'
                append = append + '</div>'
                append = append + '</div>'

                $("#showDetail").append(append)

                var no = 0
                var appendResolve = ''

                $("#btnAddNotes").click(function(){
                    $(".modal-dialog").removeClass('modal-lg')
                    $("#ModalAddNote").modal("show")
                })
            }

            function loadDataSubmitted(id){
                $.ajax({
                    type: "GET",
                    url: "{{url('/certification_list/getDetail')}}",
                    data: {
                        id_request:id
                    },
                    success: function(result) {
                        $("#headerPreview").empty();

                        var appendHeader = ""
                        appendHeader = appendHeader + '<div class="row">'
                        appendHeader = appendHeader + '    <div class="col-md-6 form-group mb-2">'
                        appendHeader = appendHeader + '        <label>Requestor Name</label>'
                        appendHeader = appendHeader + '        <input value="'+result.request.request_name+'" class="form-control" readonly/>'
                        appendHeader = appendHeader + '    </div>'
                        appendHeader = appendHeader + '    <div class="col-md-6 form-group mb-2">'
                        appendHeader = appendHeader + '        <label>Vendor</label>'
                        appendHeader = appendHeader + '        <input value="'+result.request.vendor+'" class="form-control" readonly/>'
                        appendHeader = appendHeader + '    </div>'
                        appendHeader = appendHeader + '    <div class="col-md-6 form-group mb-2">'
                        appendHeader = appendHeader + '        <label>Exam Purpose</label>'
                        appendHeader = appendHeader + '        <input value="'+result.request.exam_purpose+'" class="form-control" readonly/>'
                        appendHeader = appendHeader + '    </div>'
                        appendHeader = appendHeader + '    <div class="col-md-6 form-group mb-2">'
                        appendHeader = appendHeader + '        <label>Project Phase</label>'

                        if (result.request.project_phase !== null){
                            appendHeader = appendHeader + '        <input value="'+result.request.project_phase+'" class="form-control" readonly/>'
                        }else {
                            appendHeader = appendHeader + '        <input value="-" class="form-control" readonly/>'
                        }
                        appendHeader = appendHeader + '    </div>'
                        appendHeader = appendHeader + '    <div class="col-md-6 form-group mb-2">'
                        appendHeader = appendHeader + '        <label>Status Renewal</label>'
                        if (result.request.status_renewal !== null){
                            appendHeader = appendHeader + '        <input value="Renewal ke '+result.request.status_renewal+'" class="form-control" readonly/>'
                        }else {
                            appendHeader = appendHeader + '        <input value="-" class="form-control" readonly/>'
                        }
                        appendHeader = appendHeader + '    </div>'
                        appendHeader = appendHeader + '    <div class="col-md-6 form-group mb-2">'
                        appendHeader = appendHeader + '        <label>Project Title</label>'
                        if (result.request.project_title !== null){
                            appendHeader = appendHeader + '        <input value="'+result.request.project_title+'" class="form-control" readonly />'
                        }else {
                            appendHeader = appendHeader + '        <input value="-" class="form-control" readonly/>'
                        }
                        appendHeader = appendHeader + '    </div>'
                        if (result.request.lead_id !== null){
                            appendHeader = appendHeader + '    <div class="col-md-6 form-group mb-2">'
                            appendHeader = appendHeader + '        <label>Lead ID</label>'
                            appendHeader = appendHeader + '        <input value="'+result.request.lead_id+'" class="form-control" readonly/>'
                            appendHeader = appendHeader + '    </div>'
                        }
                        if (result.request.pid !== null){
                            appendHeader = appendHeader + '    <div class="col-md-6 form-group mb-2">'
                            appendHeader = appendHeader + '        <label>PID</label>'
                            appendHeader = appendHeader + '        <input value="'+result.request.pid+'" class="form-control" readonly/>'
                            appendHeader = appendHeader + '    </div>'
                        }
                        appendHeader = appendHeader + '    <div class="col-md-6 form-group mb-2">'
                        appendHeader = appendHeader + '        <label>Request Date</label>'
                        appendHeader = appendHeader + '        <input value="'+result.request.request_date+'" class="form-control" readonly/>'
                        appendHeader = appendHeader + '    </div>'
                        appendHeader = appendHeader + '    </div>'
                        appendHeader = appendHeader + '</div>'

                        $("#headerPreview").append(appendHeader)

                    }
                })
            }

            $("#tbChangeLog").DataTable({
                "ajax":{
                    "type":"GET",
                    "url":"{{url('/certification_list/getActivity')}}",
                    "data":{
                        id_request:window.location.href.split("/")[5]
                    }
                },
                columns: [
                    {
                        title: "Name",
                        data: "operator",
                        orderable: false
                    },
                    {
                        title: "Activity",
                        data: "activity"
                    },
                    {
                        title: "Status",
                        data: "status"
                    },
                    {
                        title: "Date",
                        data: "date"
                    },
                ],
                "aaSorting": [],
                "bFilter": true,
                "bSort":true,
                // "bLengthChange": false,
                "pageLength": 10,
                "bInfo": false,
                initComplete: function () {

                }
            });
            let userRole =  "{!! $role !!}";
            let columns = [
                {
                    title: "Participant Name",
                    data: "participant_name",
                    render: function (data, type, row) {
                        return data
                            ? `<span class="select-placeholder">${data}</span>`
                            : `<span class="select-placeholder">No participant</span>`;
                    }
                },
                {
                    title: "Exam Name",
                    data: "exam_name",
                },
                {
                    title: "Exam Code",
                    data: "exam_code"
                },
                {
                    title: "Exam Deadline",
                    data: "exam_deadline"
                },
                {
                    title: "Level",
                    data: "level"
                },
            ];

            if (userRole.toLowerCase().includes("manager") && (userRole !== 'People Operations & Services Manager' && userRole !== 'Delivery Project Manager') ) {
                columns.unshift({
                    title: "",
                    data: null,
                    render: function (data, type, row) {
                        if (row.participant_name === null) {
                            return `<button class="btn btn-sm btn-success add-select">+</button>
                                `;
                        } else {
                            return `<button class="btn btn-sm btn-danger remove-select">-</button>`;
                        }
                    },
                    orderable: false
                });
                $("#saveExamDetail").show();
            }

            let examStatus = "{{$certification->status}}"
            let nik = "{{$certification->nik}}"

            if (examStatus.toLowerCase() !== "approved" && (nik === "{{$userNik}}" || userRole === 'Learning & HR Technology')) {
                columns.push({
                    title: "Action",
                    data: null,
                    render: function (data, type, row) {
                        return `<button class="btn btn-sm btn-danger delete-participant" data-id="${row.id}">Delete</button>`;
                    },
                    orderable: false
                });
            }

            {{--if (examStatus.toLowerCase() === "approved" && (nik === "{{$userNik}}" || userRole === 'Learning & HR Technology' || row.nik === "{{$userNik}}")) {--}}
            {{--    columns.push({--}}
            {{--        title: "Action",--}}
            {{--        data: null,--}}
            {{--        render: function (data, type, row) {--}}
            {{--            return `<button class="btn btn-sm btn-primary upload-proof" data-id="${row.id}">Proof of Exam</button>`;--}}
            {{--        },--}}
            {{--        orderable: false--}}
            {{--    });--}}
            {{--}--}}

            columns.push({
                title: "Action",
                data: null,
                render: function (data, type, row) {
                    const isApproved = examStatus.toLowerCase() === "approved";
                    const isUserMatch = row.participant_nik === "{{$userNik}}" || nik === "{{$userNik}}" || userRole === 'Learning & HR Technology';

                    if (isApproved && isUserMatch) {
                        return `<button class="btn btn-sm btn-primary upload-proof" data-id="${row.id}">Proof of Exam</button>`;
                    } else {
                        return ''; // or return '-' if you want a placeholder
                    }
                },
                orderable: false
            });


            $("#tbParticipantList").DataTable({
                "ajax":{
                    "type":"GET",
                    "url":"{{url('/certification_list/getParticipantList')}}",
                    "data":{
                        id_request:window.location.href.split("/")[5]
                    }
                },
                columns: columns,
                "aaSorting": [],
                "bFilter": true,
                "bSort":true,
                "pageLength": 10,
                "bInfo": false,
                initComplete: function () {

                }
            });

            let changedRows = {};

            $("#tbParticipantList tbody").on("click", ".add-select", function () {
                let row = $(this).closest("tr");
                let rowData = $("#tbParticipantList").DataTable().row(row).data();
                $(this).removeClass('btn-success add-select')
                    .addClass('btn-danger remove-select')
                    .text('-');

                $.ajax({
                    url: "/certification_list/getAllUser",
                    type: "GET",
                    success: function (response) {
                        let options = '<option value="">Select Participant</option>';
                        response.forEach(user => {
                            options += `<option value="${user.nik}">${user.name}</option>`;
                        });

                        let cell = row.find("td").eq(userRole.toLowerCase().includes("manager") ? 1 : 0);
                        cell.html(`
                            <select class="form-control participant-select select2" style="width: 100%">
                                ${options}
                            </select>
                        `);

                        cell.find("select").select2({
                            // dropdownParent: $('#tbParticipantList')
                        });


                    }
                });
            });

            $('#tbParticipantList tbody').on('click', '.remove-select', function () {
                let row = $(this).closest('tr');

                row.find('.participant-select').remove();

                row.find('td').eq(1).html(`<span class="select-placeholder">No participant</span>`);

                $(this).removeClass('btn-danger remove-select')
                    .addClass('btn-success add-select')
                    .text('+');
            });

            $("#tbParticipantList tbody").on("change", ".participant-select", function () {
                let row = $(this).closest("tr");
                let rowData = $("#tbParticipantList").DataTable().row(row).data();
                let selectedName = $(this).find("option:selected").text();
                row.addClass('edited');

                // Simpan ke array sementara
                changedRows[rowData.id] = selectedName;
            });

            $("#saveExamDetail").on("click", function () {
                let dataToSave = [];

                $('#tbParticipantList tbody tr.edited').each(function () {
                    let row = $(this);
                    let rowData = $('#tbParticipantList').DataTable().row(row).data();

                    let participantSelect = row.find('.participant-select');
                    let participantNik = participantSelect.val();
                    let participantName = participantSelect.find('option:selected').text();
                    const currentUrl = window.location.href;
                    const segments = currentUrl.split('/');
                    const certificationId = segments.pop() || segments.pop();

                    if (participantNik) {
                        dataToSave.push({
                            certification_id: certificationId,
                            id: rowData.id,
                            participant_name: participantName,
                            participant_nik: participantNik
                        });
                    }
                });

                if (dataToSave.length === 0) {
                    Swal.fire({
                        title: 'Warning',
                        type: 'warning',
                        icon:'warning',
                        text: 'No changes to save',
                        confirmButtonText: 'OK',
                    })
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Save Exam Participant",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                            title: 'Please Wait..!',
                            text: "It's sending..",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            customClass: {
                                popup: 'border-radius-0',
                            },
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        })
                        $.ajax({
                            url: "{{ url('/certification_list/saveParticipantChanges') }}",
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                participants: dataToSave
                            },
                            success: function (response) {
                                if(response.status === 'success'){
                                    Swal.fire({
                                        title: 'Success',
                                        type: 'success',
                                        icon:'success',
                                        confirmButtonText: 'OK',
                                    }).then((result) => {
                                        $('#tbParticipantList').DataTable().ajax.reload();
                                    })
                                }

                            },
                            error: function () {
                                Swal.fire({
                                    title: 'Error',
                                    type: 'error',
                                    icon:'error',
                                    confirmButtonText: 'OK',
                                })
                            }
                        });
                    }
                })
            });

            $("#tbParticipantList tbody").on("click", ".upload-proof", function () {
                const id = $(this).data("id");

                $("#modalProofExam input, #modalProofExam select").val("");

                $("#modalProofExam").data("participant-id", id);
                $("#modalProofExam").modal("show");

                $.ajax({
                    url: `/certification_list/getProofExam/${id}`,
                    type: "GET",
                    success: function (data) {
                        if (data !== null) {
                            $("#proofExamDate").val(data.exam_date);
                            $("#proofExamCode").val(data.exam_code);
                            $("#proofExpiredDate").val(data.expired_date);
                            $("#proofStatusExam").val(data.status_exam);
                            $("#proofLevel").val(data.level);

                        }
                    }
                });
            });

            $("#btnSubmitProofExam").click(function () {
                const id = $("#modalProofExam").data("participant-id");

                const formData = new FormData();
                formData.append("exam_date", $("#proofExamDate").val());
                formData.append("exam_code", $("#proofExamCode").val());
                formData.append("expired_date", $("#lifetimeCheck").is(":checked") ? "Lifetime" : $("#proofExpiredDate").val());
                formData.append("status_exam", $("#proofStatusExam").val());
                formData.append("level", $("#proofLevel").val());
                formData.append("proof_exam", $("#proofExam")[0].files[0]);
                formData.append("_token", "{{csrf_token()}}");

                if($('#proofExamDate').val() === ""){
                    $('#proofExamDate').closest('.form-group').addClass('needs-validation')
                    $('#proofExamDate').closest('.form-group').find('span').show();
                    $('#proofExamDate').prev('.input-group-addon').css("background-color","red");
                }else if($('#proofExamCode').val() === ""){
                    $('#proofExamCode').closest('.form-group').addClass('needs-validation')
                    $('#proofExamCode').closest('.form-group').find('span').show();
                    $('#proofExamCode').prev('.input-group-addon').css("background-color","red");
                }else if($('#proofStatusExam').val() === ""){
                    $('#proofStatusExam').closest('.form-group').addClass('needs-validation')
                    $('#proofStatusExam').closest('.form-group').find('span').show();
                    $('#proofStatusExam').prev('.input-group-addon').css("background-color","red");
                }else if($('#proofExam').val() === ""){
                    $('#proofExam').closest('.form-group').addClass('needs-validation')
                    $('#proofExam').closest('.form-group').find('span').show();
                    $('#proofExam').prev('.input-group-addon').css("background-color","red");
                }else if($('#proofLevel').val() === ""){
                    $('#proofLevel').closest('.form-group').addClass('needs-validation')
                    $('#proofLevel').closest('.form-group').find('span').show();
                    $('#proofLevel').prev('.input-group-addon').css("background-color","red");
                }else if(!$("#lifetimeCheck").is(":checked") && $("#proofExpiredDate").val() === ""){
                    $('#proofExpiredDate').closest('.form-group').addClass('needs-validation')
                    $('#proofExpiredDate').closest('.form-group').find('span').show();
                    $('#proofExpiredDate').prev('.input-group-addon').css("background-color","red");
                }else {

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Save Proof of Exam",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                    }).then((result) => {
                        if (result.value) {
                            Swal.fire({
                                title: 'Please Wait..!',
                                text: "It's sending..",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                customClass: {
                                    popup: 'border-radius-0',
                                },
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                            })
                            $.ajax({
                                url: `/certification_list/uploadProofExam/${id}`,
                                type: "POST",
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function (response) {
                                    if (response.status === 'success') {
                                        Swal.fire({
                                            title: 'Success',
                                            type: 'success',
                                            icon: 'success',
                                            confirmButtonText: 'OK',
                                        }).then((result) => {
                                            $('#tbParticipantList').DataTable().ajax.reload();
                                        })
                                    }
                                    $("#modalProofExam").modal("hide");
                                    $('#tbParticipantList').DataTable().ajax.reload(null, false);
                                },
                                error: function (xhr) {
                                    Swal.fire({
                                        title: 'Error',
                                        type: 'error',
                                        icon: 'error',
                                        confirmButtonText: 'OK',
                                    })
                                }
                            });
                        }
                    })
                }
            });

            $(document).on('click', '.delete-participant', function () {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete exam detail",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                            title: 'Please Wait..!',
                            text: "It's sending..",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            customClass: {
                                popup: 'border-radius-0',
                            },
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        })
                        $.ajax({
                            url: `/certification_list/deleteParticipant/${id}`,
                            type: "POST",
                            data: {
                                '_token': "{{csrf_token()}}",
                            },
                            success: function (res) {
                                Swal.fire({
                                    title: 'Success',
                                    type: 'success',
                                    icon:'success',
                                    confirmButtonText: 'OK',
                                }).then((result) => {
                                    location.reload()
                                })
                            },
                            error: function () {
                                Swal.fire({
                                    title: 'Error',
                                    type: 'Something went wrong!',
                                    icon:'error',
                                    confirmButtonText: 'OK',
                                })
                            }
                        });
                    }
                })
            });
        })

        function unfinishedDraft(n, val, status){
            var idRequest = "";
            if (val !== ''){
                localStorage.setItem('id_request', val);
            }
            $.ajax({
                type: 'GET',
                url: '/certification_list/getPreview',
                data: {
                    id_request: localStorage.getItem('id_request')
                },
                success: function (data) {
                    let x = document.getElementsByClassName("tab-add");
                    x[n].style.display = "inline";
                    if (n == 0) {
                        document.getElementById("prevBtnAdd").style.display = "none";
                        if (data.detail.length > 0){
                            $("#nextBtnAdd").attr('onclick', 'nextPrevUnfinished(2)')
                        }else{
                            $("#nextBtnAdd").attr('onclick', 'nextPrevUnfinished(1)')
                        }
                        if (data.request.lead_id !== null){
                            $('#leadId').val(data.request.lead_id).trigger('change')
                        }
                        if (data.request.pid !== null){
                            $('#pid').val(data.request.pid).trigger('change')
                        }
                        let examPurposeString = data.request.exam_purpose;

                        let examPurposeArray = examPurposeString
                            ? examPurposeString.split(',').map(item => item.trim())
                            : [];

                        $('#examPurpose').val(examPurposeArray).trigger('change');
                        $('#vendor').val(data.request.vendor);
                        $('#renewal').val(data.request.status_renewal);
                        $('#projectTitle').val(data.request.project_title);

                    } else if (n == 1) {
                        $("#nextBtnAdd").attr('onclick', 'nextPrevUnfinished(1)')
                        $("#prevBtnAdd").attr('onclick', 'nextPrevUnfinished(-1)')
                        document.getElementById('prevBtnAdd').innerText = "Back";
                        document.getElementById("prevBtnAdd").style.display = "inline";
                    } else if (n == 2) {
                        $("#nextBtnAdd").attr('onclick', 'nextPrevUnfinished(1)')
                        $("#prevBtnAdd").attr('onclick', 'nextPrevUnfinished(-2)')
                        $("#addParticipant").attr('onclick', 'nextPrevUnfinished(-1)')
                        document.getElementById('prevBtnAdd').innerText = "Back";
                        document.getElementById("prevBtnAdd").style.display = "inline";
                    } else if (n == 3){
                        $("#prevBtnAdd").attr('onclick','nextPrevUnfinished(-1)')
                        document.getElementById("prevBtnAdd").style.display = "inline";
                        $("#headerPreviewFinal").empty()
                        document.getElementById("nextBtnAdd").innerText = "Create";
                        $("#nextBtnAdd").attr('onclick','createRequest()');

                        var appendHeader = ""
                        appendHeader = appendHeader + '<div class="row mb-2">'
                        appendHeader = appendHeader + '    <div class="col-md-6 mb-2">'
                        appendHeader = appendHeader + '        <div class="form-group">'
                        appendHeader = appendHeader + '        <label>Exam Purpose</label>'
                        appendHeader = appendHeader + '         <input class="form-control" type="text" value="'+data.request.exam_purpose+'" readonly/>'
                        appendHeader = appendHeader + '        </div>'
                        appendHeader = appendHeader + '    </div>'
                        appendHeader = appendHeader + '    <div class="col-md-6 mb-2">'
                        appendHeader = appendHeader + '        <div class="form-group">'
                        appendHeader = appendHeader + '        <label>Vendor</label>'
                        appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+data.request.vendor+'" readonly/>'
                        appendHeader = appendHeader + '        </div>'
                        appendHeader = appendHeader + '    </div>'
                        if (data.request.project_phase !== null){
                            appendHeader = appendHeader + '    <div class="col-md-6 mb-2">'
                            appendHeader = appendHeader + '        <div class="form-group">'
                            appendHeader = appendHeader + '        <label>Project Phase</label>'
                            appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+data.request.project_phase+'" readonly/>'
                            appendHeader = appendHeader + '        </div>'
                            appendHeader = appendHeader + '    </div>'
                        }
                        if (data.request.lead_id !== null){
                            appendHeader = appendHeader + '    <div class="col-md-6 mb-2">'
                            appendHeader = appendHeader + '        <div class="form-group">'
                            appendHeader = appendHeader + '        <label>Lead Id</label>'
                            appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+data.request.lead_id+'" readonly/>'
                            appendHeader = appendHeader + '        </div>'
                            appendHeader = appendHeader + '    </div>'
                        }else if (data.request.pid !== null){
                            appendHeader = appendHeader + '    <div class="col-md-6 mb-2">'
                            appendHeader = appendHeader + '        <div class="form-group">'
                            appendHeader = appendHeader + '        <label>PID</label>'
                            appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+data.request.pid+'" readonly/>'
                            appendHeader = appendHeader + '        </div>'
                            appendHeader = appendHeader + '    </div>'
                        }

                        if(data.request.status_renewal !== null){
                            appendHeader = appendHeader + '    <div class="col-md-6 mb-2">'
                            appendHeader = appendHeader + '        <div class="form-group">'
                            appendHeader = appendHeader + '        <label>Status Renewal</label>'
                            appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+data.request.status_renewal+'" readonly/>'
                            appendHeader = appendHeader + '        </div>'
                            appendHeader = appendHeader + '    </div>'
                        }

                        if(data.request.project_title !== null){
                            appendHeader = appendHeader + '    <div class="col-md-12 mb-2">'
                            appendHeader = appendHeader + '        <div class="form-group">'
                            appendHeader = appendHeader + '        <label>Project Title</label>'
                            appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+data.request.project_title+'" readonly/>'
                            appendHeader = appendHeader + '        </div>'
                            appendHeader = appendHeader + '    </div>'
                        }

                        if (window.matchMedia("(max-width: 768px)").matches)
                        {
                            appendHeader = appendHeader + '    <div class="col-md-6 mb-2">'
                            // The viewport is less than 768 pixels wide

                        } else {
                            appendHeader = appendHeader + '    <div class="col-md-6 mb-2" style="text-align:end">'
                            // The viewport is at least 768 pixels wide

                        }
                        appendHeader = appendHeader + '    </div>'
                        appendHeader = appendHeader + '</div>'

                        $("#headerPreviewFinal").append(appendHeader)

                        $("#tbodyPreviewFinal").empty()
                        var append = ""
                        var i = 0
                        $.each(data.detail,function(value,item){
                            i++
                            append = append + '<tr>'
                            append = append + '<td>'
                            append = append + '<span style="font-size: 12px; important">'+ i +'</span>'
                            append = append + '</td>'
                            append = append + '<td>'
                            append = append + "<input id='' data-value='' readonly style='font-size: 12px; important' class='form-control' type='' name='' value='"+ item.exam_name + "'>"
                            append = append + '</td>'
                            append = append + '<td>'
                            append = append + '<input id="" data-value="" readonly style="font-size: 12px; " class="form-control" type="text" name="" value="'+ item.exam_code +'">'
                            append = append + '</td>'
                            append = append + '<td>'
                            append = append + '<input id="" readonly data-value="" style="font-size: 12px;" class="form-control" type="" name="" value="'+ item.level +'">'
                            append = append + '</td>'
                            append = append + '<td>'
                            append = append + '<input id="" readonly data-value="" style="font-size: 12px;" class="form-control   " type="" name="" value="'+ item.exam_deadline +'">'
                            append = append + '</td>'
                            append = append + '</tr>'
                        })
                        $("#tbodyPreviewFinal").append(append)
                    }
                }

            })
        }
        let currentTab = 0;
        function nextPrevUnfinished(n, val) {
            valueEdit = val
            if (valueEdit == undefined) {
                if (valueEdit == 0) {
                    $(".tabGroupInitiateAdd").hide()
                    $(".tab-add")[1].style.display = 'inline'
                }
            }else{
                valueEdit = valueEdit
                if (valueEdit == true) {
                    valueEdit = 'true'
                }else if (valueEdit == false) {
                    valueEdit = 'false'
                }else{
                    valueEdit = parseFloat(valueEdit)
                }
                if (!isNaN(valueEdit)) {
                    $(".tabGroupInitiateAdd").hide()
                    $(".tab-add")[1].style.display = 'inline'
                    $.ajax({
                        type: "GET",
                        url: "{{url('/certification_list/getDetailById')}}",
                        data: {
                            id:valueEdit,
                        },
                        success: function(result) {
                            $.each(result,function(value,item){
                                isStartScroll = false
                                $("#prevBtnAdd").css("display", "none");
                                localStorage.setItem('isEditDetail',true)
                                localStorage.setItem('id_detail',item.id)
                                $("#examName").val(item.name)
                                $("#examCode").val(item.code)
                                $("#examDeadline").val(item.deadline)
                                $('#level').val(item.level)
                            })
                        }
                    })
                }
            }

            if (currentTab == 0){
                if($('#examPurpose').val() === ""){
                    $('#examPurpose').closest('.form-group').addClass('invalid-feedback')
                    $('#examPurpose').closest('.form-group').find('span').show();
                    $('#examPurpose').prev('.input-group-addon').css("background-color","red");
                }else if($('#vendor').val() === ""){
                    $('#vendor').closest('.form-group').addClass('invalid-feedback')
                    $('#vendor').closest('.form-group').find('span').show();
                    $('#vendor').prev('.input-group-addon').css("background-color","red");
                }else{
                    if($('#examPurpose').val().includes('Project')){
                        if($('#projectPhase').val() === ""){
                            $('#projectPhase').closest('.form-group').addClass('needs-validation')
                            $('#projectPhase').closest('.form-group').find('span').show();
                            $('#projectPhase').prev('.input-group-addon').css("background-color","red");
                            return;
                        }else if ($('#projectPhase').val().includes('Opportunity') || $('#projectPhase').val().includes('Tender Submission')){
                            if($('#leadId').val() === ""){
                                $('#leadId').closest('.form-group').addClass('needs-validation')
                                $('#leadId').closest('.form-group').find('span').show();
                                $('#leadId').prev('.input-group-addon').css("background-color","red");
                                return;
                            }
                        }else if ($('#projectPhase').val().includes('On Going')){
                            if($('#pid').val() === ""){
                                $('#pid').closest('.form-group').addClass('needs-validation')
                                $('#pid').closest('.form-group').find('span').show();
                                $('#pid').prev('.input-group-addon').css("background-color","red");
                                return;
                            }
                        }
                    }else if($('#examPurpose').val().includes('Renewal')){
                        if($('#renewal').val() === ""){
                            $('#renewal').closest('.form-group').addClass('needs-validation')
                            $('#renewal').closest('.form-group').find('span').show();
                            $('#renewal').prev('.input-group-addon').css("background-color","red");
                            return;
                        }
                    }
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Save Exam Request",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                    }).then((result)=>{
                        if(result.isConfirmed){
                            $.ajax({
                                type: "POST",
                                url: "/certification_list/updateRequest",
                                data: {
                                    _token:'{{ csrf_token() }}',
                                    lead_id: $('#leadId').val(),
                                    vendor: $('#vendor').val(),
                                    exam_purpose: $('#examPurpose').val(),
                                    pid: $('#pid').val(),
                                    status_renewal: $('#renewal').val(),
                                    project_title: $('#projectTitle').val(),
                                    project_phase: $('#projectPhase').val(),
                                    id_request: localStorage.getItem('id_request')
                                },
                                beforeSend:function(){
                                    Swal.fire({
                                        title: 'Please Wait..!',
                                        text: "It's sending..",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        allowEnterKey: false,
                                        customClass: {
                                            popup: 'border-radius-0',
                                        },
                                        didOpen: () => {
                                            Swal.showLoading()
                                        }
                                    })
                                },
                                success: function (result) {
                                    Swal.close();
                                    localStorage.setItem('id_request', result);
                                    localStorage.setItem('isStore', true);
                                    var x = document.getElementsByClassName("tab-add");
                                    x[currentTab].style.display = "none";
                                    currentTab = currentTab + n;
                                    unfinishedDraft(currentTab, localStorage.getItem('id_request'));
                                }, error: function () {
                                    Swal.close()
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Something went wrong, please try again',
                                        icon: 'error'
                                    })
                                }
                            })
                        }
                    })
                }
            } else if(currentTab === 1){
                if(n === 1){
                    if($('#examName').val() === ""){
                        $('#examName').closest('.form-group').addClass('invalid-feedback')
                        $('#examName').closest('.form-group').find('span').show();
                        $('#examName').prev('.input-group-addon').css("background-color","red");
                    }else if($('#examCode').val() === ""){
                        $('#examCode').closest('.form-group').addClass('invalid-feedback')
                        $('#examCode').closest('.form-group').find('span').show();
                        $('#examCode').prev('.input-group-addon').css("background-color","red");
                    }else {
                        if (localStorage.getItem('isEditDetail') === true || localStorage.getItem('isEditDetail') === 'true'){
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "Save Exam Information",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes',
                                cancelButtonText: 'No',
                            }).then((result)=>{
                                if(result.isConfirmed){
                                    $.ajax({
                                        type: "POST",
                                        url: "/certification_list/updateRequestDetail",
                                        data: {
                                            _token:'{{ csrf_token() }}',
                                            exam_name: $('#examName').val(),
                                            exam_code: $('#examCode').val(),
                                            exam_deadline: $('#examDeadline').val(),
                                            level: $('#level').val(),
                                            id_request: localStorage.getItem('id_request'),
                                            id_detail:localStorage.getItem('id_detail')
                                        },
                                        beforeSend:function(){
                                            Swal.fire({
                                                title: 'Please Wait..!',
                                                text: "It's sending..",
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                allowEnterKey: false,
                                                customClass: {
                                                    popup: 'border-radius-0',
                                                },
                                                didOpen: () => {
                                                    Swal.showLoading()
                                                }
                                            })
                                        },
                                        success: function (result) {
                                            Swal.close();
                                            var x = document.getElementsByClassName("tab-add");
                                            x[currentTab].style.display = "none";
                                            currentTab = currentTab + n;
                                            unfinishedDraft(currentTab, localStorage.getItem('id_request'));
                                            addTable(0);
                                            localStorage.setItem('isEditDetail', null);
                                            $('#examName').val('')
                                            $('#examCode').val('')
                                            $('#level').val('')
                                            $('#examDeadline').val('')
                                        }, error: function () {
                                            Swal.close()
                                            Swal.fire({
                                                title: 'Error!',
                                                text: 'Something went wrong, please try again',
                                                icon: 'error'
                                            })
                                        }
                                    })
                                }
                            })
                        }else {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "Save Exam Information",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes',
                                cancelButtonText: 'No',
                            }).then((result)=>{
                                if(result.isConfirmed){
                                    $.ajax({
                                        type: "POST",
                                        url: "/certification_list/storeRequestDetail",
                                        data: {
                                            _token:'{{ csrf_token() }}',
                                            exam_name: $('#examName').val(),
                                            exam_code: $('#examCode').val(),
                                            exam_deadline: $('#examDeadline').val(),
                                            level: $('#level').val(),
                                            id_request: localStorage.getItem('id_request')
                                        },
                                        beforeSend:function(){
                                            Swal.fire({
                                                title: 'Please Wait..!',
                                                text: "It's sending..",
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                allowEnterKey: false,
                                                customClass: {
                                                    popup: 'border-radius-0',
                                                },
                                                didOpen: () => {
                                                    Swal.showLoading()
                                                }
                                            })
                                        },
                                        success: function (result) {
                                            Swal.close();
                                            var x = document.getElementsByClassName("tab-add");
                                            x[currentTab].style.display = "none";
                                            currentTab = currentTab + n;
                                            unfinishedDraft(currentTab, localStorage.getItem('id_request'));
                                            addTable(0);
                                            $('#examName').val('')
                                            $('#examCode').val('')
                                            $('#level').val('')
                                            $('#examDeadline').val('')
                                        }, error: function () {
                                            Swal.close()
                                            Swal.fire({
                                                title: 'Error!',
                                                text: 'Something went wrong, please try again',
                                                icon: 'error'
                                            })
                                        }
                                    })
                                }
                            })
                        }
                    }
                }else{
                    var x = document.getElementsByClassName("tab-add");
                    x[currentTab].style.display = "none";
                    currentTab = currentTab + n;
                    if (currentTab >= x.length) {
                        x[n].style.display = "none";
                        currentTab = 0;
                    }
                    unfinishedDraft(currentTab, localStorage.getItem('id_request'));
                }
            }else if (currentTab === 2){
                var x = document.getElementsByClassName("tab-add");
                x[currentTab].style.display = "none";
                currentTab = currentTab + n;
                if (currentTab >= x.length) {
                    x[n].style.display = "none";
                    currentTab = 0;
                }
                unfinishedDraft(currentTab, localStorage.getItem('id_request'));
            }else if(currentTab === 3) {
                var x = document.getElementsByClassName("tab-add");
                x[currentTab].style.display = "none";
                currentTab = currentTab + n;
                if (currentTab >= x.length) {
                    x[n].style.display = "none";
                    currentTab = 0;
                }
                unfinishedDraft(currentTab, localStorage.getItem('id_request'));
            }
        }

        function createRequest() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Submit Request",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: 'Please Wait..!',
                        text: "It's sending..",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        customClass: {
                            popup: 'border-radius-0',
                        },
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })
                    $.ajax({
                        type:"POST",
                        url:"{{url('/certification_list/updateLastStepRequest')}}",
                        data:{
                            _token:"{{csrf_token()}}",
                            id_request:localStorage.getItem('id_request'),
                        },
                        success: function(result){
                            localStorage.setItem('id_request', '')
                            localStorage.setItem('isStore',false);
                            Swal.fire({
                                title: 'Add Request Success',
                                html: "<p style='text-align:center;'>Your Request will be verified by HC soon, please wait for further progress</p>",
                                type: 'success',
                                confirmButtonText: 'Reload',
                            }).then((result) => {
                                localStorage.setItem('status','')
                                location.replace("{{url('certification_list')}}")
                            })
                        },
                        error: function () {
                            Swal.close()
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong, please try again',
                                icon: 'error'
                            })
                        }
                    })
                }
            })
        }

        function refreshTable(){
            addTable(0)
        }

        function scrollTopModal(){
            var savedScrollPosition = localStorage.getItem('scrollPosition');
            var scrollableElement = document.getElementById('modalAdd');
            scrollableElement.scrollTop = savedScrollPosition;
        }

        function addTable(n){
            $.ajax({
                type: "GET",
                url: '{{url('/certification_list/getRequestDetail')}}',
                data: {
                    id_request:localStorage.getItem('id_request'),
                },
                success: function(result) {
                    var i = 0
                    var valueEdit = 0
                    var append = ""
                    $("#tbodyPreview").empty()
                    $.each(result.data,function(value,item){
                        i++;
                        valueEdit++;
                        append = append + '<tr>'
                        append = append + '<td>'
                        append = append + '<span style="font-size: 12px; important">'+ i +'</span>'
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + "<input id='inputExamName' data-value='' readonly style='font-size: 12px; important' class='form-control' type='' name='' value='"+ item.name + "'>"
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + '<input id="inputExamCode" data-value="" readonly style="font-size: 12px; important;width:70px" class="form-control" type="text" name="" value="'+ item.code +'">'
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + '<input id="inputExamDeadline" readonly data-value="" style="font-size: 12px;width:100px" class="form-control" type="text" name="" value="'+ item.level +'">'
                        append = append + '</td>'
                        append = append + '<td>'
                        append = append + '<input id="inputLevel" readonly data-value="" style="font-size: 12px;width:100px" class="form-control   " type="" name="" value="'+ item.deadline +'">'
                        append = append + '</td>'
                        append = append + '<td>'
                        btnNext = 'nextPrevUnfinished(-1,'+ item.id +')'
                        append = append + '<button type="button" onclick="'+ btnNext +'" id="btnEditDetail" data-id="'+ value +'" data-value="'+ valueEdit +'" class="btn btn-xs btn-warning bx bx-edit btnEditDetail" style="width:25px;height:25px;margin-bottom:5px"></button>'
                        @if($role == 'Learning & HR Technology' || $role == 'Channeling Partnership & Marketing')
                            append = append + '<button id="btnDeleteDetail" type="button" data-id="'+ item.id+'" data-value="'+ value +'" class="btn btn-xs btn-danger bx bx-trash" style="width:25px;height:25px"></button>'
                        @endif
                            append = append + '</td>'
                        append = append + '</tr>'
                    })

                    $("#tbodyPreview").append(append)

                    scrollTopModal()

                    $(document).on("click", "#btnDeleteDetail", function() {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Deleting Request Detail",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No',
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    type: "POST",
                                    url: "{{url('/certification_list/deleteDetail')}}",
                                    data:{
                                        _token:'{{ csrf_token() }}',
                                        id:$(this).data("id")
                                    },
                                    beforeSend:function(){
                                        Swal.fire({
                                            title: 'Please Wait..!',
                                            text: "It's sending..",
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                            allowEnterKey: false,
                                            customClass: {
                                                popup: 'border-radius-0',
                                            },
                                        })
                                        Swal.showLoading()
                                    },
                                    success: function(result) {
                                        Swal.fire(
                                            'Successfully!',
                                            'Delete Detail.',
                                            'success'
                                        ).then((result) => {
                                            refreshTable()
                                        })
                                    }
                                })
                            }
                        })
                    })
                }
            })
        }

        function approveRequest() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Approve Request",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: 'Please Wait..!',
                        text: "It's sending..",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        customClass: {
                            popup: 'border-radius-0',
                        },
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })
                    $.ajax({
                        type: "POST",
                        url: "{{url('/certification_list/approveRequest')}}",
                        data: {
                            _token: "{{csrf_token()}}",
                            id_request: localStorage.getItem('id_request'),
                        },
                        success: function (result) {
                            if(result.status === 'success'){
                                Swal.fire({
                                    title: 'Approve request success',
                                    type: 'success',
                                    icon:'success',
                                    confirmButtonText: 'OK',
                                }).then((result) => {
                                    location.reload()
                                })
                            }else if(result.status === 'warning'){
                                Swal.fire({
                                    title: 'Attention',
                                    type: 'warning',
                                    icon:'warning',
                                    text: result.message,
                                    confirmButtonText: 'OK',
                                }).then((result) => {

                                })
                            }else if(result.status === 'error'){
                                Swal.fire({
                                    title: 'Error',
                                    type: 'error',
                                    icon:'error',
                                    text: result.message,
                                    confirmButtonText: 'OK',
                                })
                            }

                        },
                        error: function () {
                            Swal.close()
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong, please try again',
                                icon: 'error'
                            })
                        }
                    })
                }
            })
        }
        
        function rejectRequest() {
            if($('#rejectNote').val() === ""){
                $('#rejectNote').closest('.form-group').addClass('invalid-feedback')
                $('#rejectNote').closest('.form-group').find('span').show();
                $('#rejectNote').prev('.input-group-addon').css("background-color","red");
            }else {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Reject Request",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                            title: 'Please Wait..!',
                            text: "It's sending..",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            customClass: {
                                popup: 'border-radius-0',
                            },
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        })
                        $.ajax({
                            type: "POST",
                            url: "{{url('/certification_list/rejectRequest')}}",
                            data: {
                                _token: "{{csrf_token()}}",
                                id_request: localStorage.getItem('id_request'),
                                note: $('#rejectNote').val()
                            },
                            success: function (result) {
                                Swal.fire({
                                    title: 'Reject request success',
                                    type: 'success',
                                    icon:'success',
                                    confirmButtonText: 'OK',
                                }).then((result) => {
                                    location.reload()
                                })
                            },
                            error: function () {
                                Swal.close()
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong, please try again',
                                    icon: 'error'
                                })
                            }
                        })
                    }
                })
            }
        }

        function fillInput(val) {
            if (val == "vendor") {
                $("#vendor").closest('.form-group').removeClass('invalid-feedback')
                $("#vendor").closest('.form-group').find('.help-block').hide();
                $("#vendor").prev('.input-group-addon').css("background-color","red");
            }else if (val == "exam_purpose") {
                $("#examPurpose").closest('.form-group').removeClass('invalid-feedback')
                $("#examPurpose").closest('.form-group').find('.help-block').hide();
                $("#examPurpose").prev('.input-group-addon').css("background-color","red");
            }else if (val == "lead_id") {
                $("#leadId").closest('.form-group').removeClass('invalid-feedback')
                $("#leadId").closest('.form-group').find('.help-block').hide();
                $("#leadId").prev('.input-group-addon').css("background-color","red");
            }else if (val == "pid") {
                $("#pid").closest('.form-group').removeClass('invalid-feedback')
                $("#pid").closest('.form-group').find('.help-block').hide();
                $("#pid").prev('.input-group-addon').css("background-color","red");
            }else if (val == "renewal") {
                $("#renewal").closest('.form-group').removeClass('invalid-feedback')
                $("#renewal").closest('.form-group').find('.help-block').hide();
                $("#renewal").prev('.input-group-addon').css("background-color","red");
            }else if (val == "assign_manager") {
                $("#assignManager").closest('.form-group').removeClass('invalid-feedback')
                $("#assignManager").closest('.form-group').find('.help-block').hide();
                $("#assignManager").prev('.input-group-addon').css("background-color","red");
            }else if (val == "reject_note") {
                $("#rejectNote").closest('.form-group').removeClass('invalid-feedback')
                $("#rejectNote").closest('.form-group').find('.help-block').hide();
                $("#rejectNote").prev('.input-group-addon').css("background-color","red");
            }else if(val == "projectPhase"){
                $("#projectPhase").closest('.form-group').removeClass('needs-validation')
                $("#projectPhase").closest('.form-group').find('.invalid-feedback').hide();
                $("#projectPhase").prev('.input-group-addon').css("background-color","red");
            }
        }

        $(document).ready(function() {
            $('#btnSubmitAssignManager').on('click', function () {
                if($('#assignManager').val() === ""){
                    $('#assignManager').closest('.form-group').addClass('invalid-feedback')
                    $('#assignManager').closest('.form-group').find('span').show();
                    $('#assignManager').prev('.input-group-addon').css("background-color","red");
                }else {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Assign Manager",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                    }).then((result) => {
                        if (result.value) {
                            Swal.fire({
                                title: 'Please Wait..!',
                                text: "It's sending..",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                customClass: {
                                    popup: 'border-radius-0',
                                },
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                            })
                            $.ajax({
                                type: "POST",
                                url: "{{url('/certification_list/assignManager')}}",
                                data: {
                                    _token: "{{csrf_token()}}",
                                    id_request: localStorage.getItem('id_request'),
                                    manager: $('#assignManager').val()
                                },
                                success: function (result) {
                                    Swal.fire({
                                        title: 'Assign Manager Success',
                                        type: 'success',
                                        icon:'success',
                                        confirmButtonText: 'OK',
                                    }).then((result) => {
                                        location.reload()
                                    })
                                },
                                error: function () {
                                    Swal.close()
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Something went wrong, please try again',
                                        icon: 'error'
                                    })
                                }
                            })
                        }
                    })
                }
            })
        })
    </script>


@endsection