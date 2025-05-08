@extends('template.main_sneat')
@section('title')
    Certification List
@endsection
@section('head_css')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-fixedcolumns-bs5/fixedcolumns.bootstrap5.css')}}" />    <link rel="preload" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmSAQhPWId5Nd6QxE8To4ADjM2a6n0BrqQdisZ/RPUlm0YycDzvNL1HHAh1nKZqI0kSbif+5upQ==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
{{--    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.2.4/themes/blue/pace-theme-barber-shop.min.css" integrity="sha512-7qRUmettmzmL6BrHrw89ro5Ki8CZZQSC/eBJTlD3YPHVthueedR4hqJyYqe1FJIA4OhU2mTes0yBtiRMCIMkzw==" crossorigin="anonymous" referrerpolicy="no-referrer"  as="style" onload="this.onload=null;this.rel='stylesheet'"/>--}}
    <style type="text/css">
        .DTFC_LeftBodyLiner {
            overflow: hidden;
        }
        th{
            text-align: center;
        }
        td>.truncate{
            /*word-wrap: break-word; */
            word-break:break-all;
            white-space: normal;
            width:200px;
        }
        @media screen and (max-width: 768px) {
            .btn-action-letter{
                float: left!important;
            }
        }

        .swal2-deny{
            display: none!important;
        }
    </style>
@endsection
@section('pageName')
    Certification List
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <section class="content">
            @if (session('update'))
                <div class="alert alert-warning" id="alert">
                    {{ session('update') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success notification-bar"><span>Notice : </span> {{ session('success') }}<button type="button" class="dismisbar transparant pull-right"><i class="bx bx-times fa-lg"></i></button><br>Get your Quote Number :<h4> {{$pops->quote_number}}</h4></div>
            @endif

            @if (session('sukses'))
                <div class="alert alert-success notification-bar"><span>Notice : </span> {{ session('success') }}<button type="button" class="dismisbar transparant pull-right"><i class="bx bx-times fa-lg"></i></button><br>Get your Quote Number :<h4> {{$pops2->quote_number}}</h4></div>
            @endif

            @if (session('alert'))
                <div class="alert alert-success" id="alert">
                    {{ session('alert') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row" style="margin-bottom:10px" id="filterBox">
                                <div class="col-md-3" >
                                    <div class="form-group">
                                        <label>Range Date Certification : </label>
                                        <button type="button" class="btn btn-sm btn-outline-secondary btn-flat pull-left" style="width:100%" id="inputRangeDate">
                                            <i class="bx bx-calendar"></i> Date range picker
                                            <span>
                                                <i class="bx bx-caret-down"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <div class="form-group btn-action-letter" style="float:right;">
                                        <button type="button" id="btnAddRequest" class="btn btn-sm btn-success btn-flat" style="width: 150px;" data-bs-target="#modalAdd" data-bs-toggle="modal" onclick="addRequest(0)"><i class="bx bx-plus"> </i> &nbsp Add Request </button>
                                    </div>
                                </div>
                            </div>
                            <div class="nav-tabs-custom">
                                <div class="tab-content">
                                    <div class="tab-pane show active" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-bordered nowrap table-striped dataTable data" id="data_all" width="100%" cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Vendor</th>
                                                    <th>Request Date</th>
                                                    <th>Purpose</th>
                                                    <th>Status</th>
                                                    <th>Approval</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                                            <select name="projectPhase" id="projectPhase" class="form-control" style="width: 100%;" onchange="fillInput('projectPhase')" disabled>
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
                                            <select name="renewal" id="renewal" class="form-control" style="width: 100%" onchange="fillInput('renewal')">
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
                                        <select style="width:100%;display:inline;" class="form-control" id="level" placeholder="" onchange="fillInput('level')">
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
@endsection
@section('scriptImport')
    <script src="{{asset('assets/js/extended-ui-blockui.js')}}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
{{--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap.min.js"></script>--}}
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.2.4/pace.min.js" integrity="sha512-2cbsQGdowNDPcKuoBd2bCcsJky87Mv0LEtD/nunJUgk6MOYTgVMGihS/xCEghNf04DPhNiJ4DZw5BxDd1uyOdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
    <script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.js" integrity="sha512-SSQo56LrrC0adA0IJk1GONb6LLfKM6+gqBTAGgWNO8DIxHiy0ARRIztRWVK6hGnrlYWOFKEbSLQuONZDtJFK0Q==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
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
        });

        $('#inputRangeDate').daterangepicker({
            ranges: {
                'Today'       : [moment(), moment()],
                'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
        },function (start, end) {
            $('#inputRangeDate').html("")
            $('#inputRangeDate').html('<i class="bx bx-calendar"></i> <span>' + start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY') + '</span>&nbsp<i class="bx bx-caret-down"></i>');

            var startDay = start.format('YYYY-MM-DD');
            var endDay = end.format('YYYY-MM-DD');

            $("#startDateFilter").val(startDay)
            $("#endDateFilter").val(endDay)

            startDate = start.format('D MMMM YYYY');
            endDate = end.format('D MMMM YYYY');

            if (startDay != undefined && endDay != undefined) {
                searchCustom(startDay,endDay)
            }
        });

        function searchCustom(startDate,endDate){
            var  tempStartDate = 'startDate=', tempEndDate = 'endDate='


            if (startDate != undefined) {
                tempStartDate = tempStartDate + startDate
            }else{
                localStorage.removeItem("arrFilterBack")
            }

            if (endDate != undefined) {
                tempEndDate = tempEndDate + endDate
            }else{
                localStorage.removeItem("arrFilterBack")
            }

            var temp = "?" + tempStartDate + '&' + tempEndDate
            showFilterData(temp)
            // DashboardCounterFilter(temp)

            return localStorage.setItem("arrFilter", temp)
        }

        function showFilterData(temp,arrStatusBack,arrTypeBack){
            $('.layout-container').block({
            message: '<div class=""spinner-border text-white"" role=""status""></div>',
                timeout: 1000,
                css: {
                backgroundColor: 'transparent',
                    border: '0'
            },
            overlayCSS: {
                opacity: 0.5
            }
        });
            $("#data_all").DataTable().ajax.url("{{url('/certification_list/getDataByFilter')}}" + temp).load()

        }

        initCertificationTable();

        function initCertificationTable(temp) {
            var temp = ''
            if (temp == undefined) {
                temp = '?' + temp
            }else{
                temp = ''
            }
            let roleName = "";
            $("#data_all").DataTable({
                "ajax":{
                    "type":"GET",
                    "url":"{{url('/certification_list/getDataByFilter')}}" + temp,
                },
                "columns": [
                    {  "data": null,
                        "width": "5%",
                        "render": function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { "data": "name","width": "25%" },
                    { "data": "vendor","width": "25%" },
                    { "data": "date","width": "15%" },
                    { "data": "exam_purpose" },
                    { "data": "status" },
                    { "render": function (data, type, row) {
                         if (row.is_circular === 1){
                             return 'on '+ row.circular
                         }else {
                             return '-';
                         }
                        }},
                    { "width": "8%",
                        "render": function (data, type, row) {
                            if (row.status == 'Saved'){
                                var status = 'saved';
                                if(row.nik === "{{Auth::user()->nik}}"){
                                    return `<button style='width:70px' class="btn btn-xs btn-warning btnDraft" data-bs-target="#modalAdd" data-bs-toggle="modal" onclick="unfinishedDraft(0, ${row.id}, '${status}')">Draft</button>`;
                                }else{
                                    return `<button style='width:70px' class="btn btn-xs btn-warning btnDraft" disabled >Draft</button>`;
                                }
                            }else{
                                if (row.status !== 'Approved' && row.status !== 'Cancelled'){
                                    return `<a href="/certification_list/detail/${row.id}" target="_blank" style='width:70px' class="btn btn-xs btn-primary btnDetail">Detail</a>
                                            <button onclick="cancelRequest(${row.id})" style='width:70px' class="btn btn-xs btn-danger btnCancel">Cancel</button>`;
                                }else{
                                    return `<a href="/certification_list/detail/${row.id}" target="_blank" style='width:70px' class="btn btn-xs btn-primary btnDetail">Detail</a>
                                            <button onclick="cancelRequest(${row.id})" style='width:70px' class="btn btn-xs btn-danger btnCancel" disabled>Cancel</button>`;
                                }
                            }
                        },
                    },
                ],
                "searching": true,
                // "scrollX": true,
                // "order": [[0, "desc"]],
                "ordering": true,
                "pageLength": 20,
            });
        }

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

        function cancelRequest(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Cancel Exam Request",
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        type: "POST",
                        url: "/certification_list/cancelRequest",
                        data: {
                            _token:'{{ csrf_token() }}',
                           id: id
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
                            Swal.fire({
                                title: 'Success',
                                text: 'Exam Request has been cancelled',
                                icon: 'success'
                            }).then((result) =>{
                                location.reload()
                            })
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

        function addRequest(n) {
            let x = document.getElementsByClassName("tab-add");
            x[n].style.display = "inline"
            x[n].classList.remove("d-none")
            if(n == 0){
                document.getElementById("prevBtnAdd").style.display = "none";
                $("#nextBtnAdd").attr('onclick','nextPrevAdd(1)')
            }else if(n == 1){
                $("#nextBtnAdd").attr('onclick', 'nextPrevAdd(1)')
                $("#prevBtnAdd").attr('onclick','nextPrevAdd(-1)')
                document.getElementById('prevBtnAdd').innerText = "Back";
                document.getElementById("prevBtnAdd").style.display = "inline";
            }else if(n == 2){
                $("#nextBtnAdd").attr('onclick', 'nextPrevAdd(1)')
                $("#prevBtnAdd").attr('onclick','nextPrevUnfinished(-2)')
                $("#addParticipant").attr('onclick','nextPrevUnfinished(-1)')
                document.getElementById('prevBtnAdd').innerText = "Back";
                document.getElementById("prevBtnAdd").style.display = "inline";
            }else if(n == 3){
                $("#prevBtnAdd").attr('onclick','nextPrevUnfinished(-1)')
                document.getElementById("prevBtnAdd").style.display = "inline";
                $("#headerPreviewFinal").empty()
                document.getElementById("nextBtnAdd").innerText = "Create";
                $("#nextBtnAdd").attr('onclick','createRequest()');

                $.ajax({
                    type: "GET",
                    url: "{{url('/certification_list/getPreview')}}",
                    data: {
                        id_request:localStorage.getItem('id_request'),
                    },
                    success: function(result) {
                        var appendHeader = ""
                        appendHeader = appendHeader + '<div class="row">'
                        appendHeader = appendHeader + '    <div class="col-md-6 mb-3">'
                        appendHeader = appendHeader + '        <div class="form-group">'
                        appendHeader = appendHeader + '        <label>Exam Purpose</label>'
                        appendHeader = appendHeader + '         <input class="form-control" type="text" value="'+result.request.exam_purpose+'" readonly/>'
                        appendHeader = appendHeader + '        </div>'
                        appendHeader = appendHeader + '    </div>'
                        appendHeader = appendHeader + '    <div class="col-md-6 mb-3">'
                        appendHeader = appendHeader + '        <div class="form-group">'
                        appendHeader = appendHeader + '        <label>Vendor</label>'
                        appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+result.request.vendor+'" readonly/>'
                        appendHeader = appendHeader + '        </div>'
                        appendHeader = appendHeader + '    </div>'
                        if (result.request.project_phase !== null){
                            appendHeader = appendHeader + '    <div class="col-md-6 mb-3">'
                            appendHeader = appendHeader + '        <div class="form-group">'
                            appendHeader = appendHeader + '        <label>Project Phase</label>'
                            appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+result.request.project_phase+'" readonly/>'
                            appendHeader = appendHeader + '        </div>'
                            appendHeader = appendHeader + '    </div>'
                        }
                        if (result.request.lead_id !== null){
                            appendHeader = appendHeader + '    <div class="col-md-6 mb-3">'
                            appendHeader = appendHeader + '        <div class="form-group">'
                            appendHeader = appendHeader + '        <label>Lead Id</label>'
                            appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+result.request.lead_id+'" readonly/>'
                            appendHeader = appendHeader + '        </div>'
                            appendHeader = appendHeader + '    </div>'
                        }else if (result.request.pid !== null){
                            appendHeader = appendHeader + '    <div class="col-md-6 mb-3">'
                            appendHeader = appendHeader + '        <div class="form-group">'
                            appendHeader = appendHeader + '        <label>PID</label>'
                            appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+result.request.pid+'" readonly/>'
                            appendHeader = appendHeader + '        </div>'
                            appendHeader = appendHeader + '    </div>'
                        }

                        if(result.request.status_renewal !== null){
                            appendHeader = appendHeader + '    <div class="col-md-6 mb-3">'
                            appendHeader = appendHeader + '        <div class="form-group">'
                            appendHeader = appendHeader + '        <label>Status Renewal</label>'
                            appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+result.request.status_renewal+'" readonly/>'
                            appendHeader = appendHeader + '        </div>'
                            appendHeader = appendHeader + '    </div>'
                        }

                        if(result.request.project_title !== null){
                            appendHeader = appendHeader + '    <div class="col-md-12 mb-3">'
                            appendHeader = appendHeader + '        <div class="form-group">'
                            appendHeader = appendHeader + '        <label>Project Title</label>'
                            appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+result.request.project_title+'" readonly/>'
                            appendHeader = appendHeader + '        </div>'
                            appendHeader = appendHeader + '    </div>'
                        }

                        if (window.matchMedia("(max-width: 768px)").matches)
                        {
                            appendHeader = appendHeader + '    <div class="col-md-6 mb-3">'
                            // The viewport is less than 768 pixels wide

                        } else {
                            appendHeader = appendHeader + '    <div class="col-md-6 mb-3" style="text-align:end">'
                            // The viewport is at least 768 pixels wide

                        }
                        appendHeader = appendHeader + '    </div>'
                        appendHeader = appendHeader + '</div>'

                        $("#headerPreviewFinal").append(appendHeader)

                        $("#tbodyPreviewFinal").empty()
                        var append = ""
                        var i = 0
                        $.each(result.detail,function(value,item){
                            i++
                            append = append + '<tr>'
                            append = append + '<td>'
                            append = append + '<span style="font-size: 12px; important">'+ i +'</span>'
                            append = append + '</td>'
                            append = append + '<td>'
                            append = append + "<input id='' data-value='' readonly style='font-size: 12px; important' class='form-control' type='' name='' value='"+ item.exam_name + "'>"
                            append = append + '</td>'
                            append = append + '<td>'
                            append = append + '<input id="" data-value="" readonly style="font-size: 12px;" class="form-control" type="text" name="" value="'+ item.exam_code +'">'
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
                })
            }
        }

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
                        $('#projectPhase').val(data.request.project_phase);


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
                            appendHeader = appendHeader + '<div class="row">'
                            appendHeader = appendHeader + '    <div class="col-md-6 mb-3">'
                            appendHeader = appendHeader + '        <div class="form-group">'
                            appendHeader = appendHeader + '        <label>Exam Purpose</label>'
                            appendHeader = appendHeader + '         <input class="form-control" type="text" value="'+data.request.exam_purpose+'" readonly/>'
                            appendHeader = appendHeader + '        </div>'
                            appendHeader = appendHeader + '    </div>'
                            appendHeader = appendHeader + '    <div class="col-md-6 mb-3">'
                            appendHeader = appendHeader + '        <div class="form-group">'
                            appendHeader = appendHeader + '        <label>Vendor</label>'
                            appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+data.request.vendor+'" readonly/>'
                            appendHeader = appendHeader + '        </div>'
                            appendHeader = appendHeader + '    </div>'
                            if (data.request.project_phase !== null){
                                appendHeader = appendHeader + '    <div class="col-md-6 mb-3">'
                                appendHeader = appendHeader + '        <div class="form-group">'
                                appendHeader = appendHeader + '        <label>Project Phase</label>'
                                appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+data.request.project_phase+'" readonly/>'
                                appendHeader = appendHeader + '        </div>'
                                appendHeader = appendHeader + '    </div>'
                            }
                            if (data.request.lead_id !== null){
                                appendHeader = appendHeader + '    <div class="col-md-6 mb-3">'
                                appendHeader = appendHeader + '        <div class="form-group">'
                                appendHeader = appendHeader + '        <label>Lead Id</label>'
                                appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+data.request.lead_id+'" readonly/>'
                                appendHeader = appendHeader + '        </div>'
                                appendHeader = appendHeader + '    </div>'
                            }else if (data.request.pid !== null){
                                appendHeader = appendHeader + '    <div class="col-md-6 mb-3">'
                                appendHeader = appendHeader + '        <div class="form-group">'
                                appendHeader = appendHeader + '        <label>PID</label>'
                                appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+data.request.pid+'" readonly/>'
                                appendHeader = appendHeader + '        </div>'
                                appendHeader = appendHeader + '    </div>'
                            }

                            if(data.request.status_renewal !== null){
                                appendHeader = appendHeader + '    <div class="col-md-6 mb-3">'
                                appendHeader = appendHeader + '        <div class="form-group">'
                                appendHeader = appendHeader + '        <label>Status Renewal</label>'
                                appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+data.request.status_renewal+'" readonly/>'
                                appendHeader = appendHeader + '        </div>'
                                appendHeader = appendHeader + '    </div>'
                            }

                            if(data.request.project_title !== null){
                                appendHeader = appendHeader + '    <div class="col-md-12 mb-3">'
                                appendHeader = appendHeader + '        <div class="form-group">'
                                appendHeader = appendHeader + '        <label>Project Title</label>'
                                appendHeader = appendHeader + '         <input class="form-control"  type="text" value="'+data.request.project_title+'" readonly/>'
                                appendHeader = appendHeader + '        </div>'
                                appendHeader = appendHeader + '    </div>'
                            }

                            if (window.matchMedia("(max-width: 768px)").matches)
                            {
                                appendHeader = appendHeader + '    <div class="col-md-6 mb-3">'
                                // The viewport is less than 768 pixels wide

                            } else {
                                appendHeader = appendHeader + '    <div class="col-md-6 mb-3" style="text-align:end">'
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

        function nextPrevAdd(n){
            if (currentTab == 0){
                if($('#examPurpose').val() === ""){
                    $('#examPurpose').closest('.form-group').addClass('needs-validation')
                    $('#examPurpose').closest('.form-group').find('span').show();
                    $('#examPurpose').prev('.input-group-text').css("background-color","red");
                }else if($('#vendor').val() === ""){
                    $('#vendor').closest('.form-group').addClass('needs-validation')
                    $('#vendor').closest('.form-group').find('span').show();
                    $('#vendor').prev('.input-group-text').css("background-color","red");
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
                        isStore = localStorage.getItem('isStore');
                        if (isStore == 'false' || isStore == null){
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "Save Exam Request",
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Yes',
                            }).then((result)=>{
                                if(result.isConfirmed){
                                    $.ajax({
                                        type: "POST",
                                        url: "/certification_list/storeRequest",
                                        data: {
                                            _token:'{{ csrf_token() }}',
                                            lead_id: $('#leadId').val(),
                                            vendor: $('#vendor').val(),
                                            exam_purpose: $('#examPurpose').val(),
                                            pid: $('#pid').val(),
                                            status_renewal: $('#renewal').val(),
                                            project_title: $('#projectTitle').val(),
                                            project_phase: $('#projectPhase').val(),
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
                                            addRequest(currentTab);
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
                        } else {
                            var x = document.getElementsByClassName("tab-add");
                            x[currentTab].style.display = "none";
                            currentTab = currentTab + n;
                            if (currentTab >= x.length) {
                                x[n].style.display = "none";
                                currentTab = 0;
                            }
                            addRequest(currentTab);
                        }
                }
            }else if(currentTab == 1){
                if(n === 1){
                    if($('#examName').val() === ""){
                        $('#examName').closest('.form-group').addClass('needs-validation')
                        $('#examName').closest('.form-group').find('span').show();
                        $('#examName').prev('.input-group-addon').css("background-color","red");
                    }else if($('#examCode').val() === ""){
                        $('#examCode').closest('.form-group').addClass('needs-validation')
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
                                            addRequest(currentTab);
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
                                            addRequest(currentTab);
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
                    addRequest(currentTab);
                }
            }else if (currentTab == 2){
                var x = document.getElementsByClassName("tab-add");
                x[currentTab].style.display = "none";
                currentTab = currentTab + n;
                if (currentTab >= x.length) {
                    x[n].style.display = "none";
                    currentTab = 0;
                }
                addRequest(currentTab);
            }else if(currentTab == 3) {

            }
        }

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
                    $('#examPurpose').closest('.form-group').addClass('needs-validation')
                    $('#examPurpose').closest('.form-group').find('span').show();
                    $('#examPurpose').prev('.input-group-addon').css("background-color","red");
                }else if($('#vendor').val() === ""){
                    $('#vendor').closest('.form-group').addClass('needs-validation')
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
                        $('#examName').closest('.form-group').addClass('needs-validation')
                        $('#examName').closest('.form-group').find('span').show();
                        $('#examName').prev('.input-group-addon').css("background-color","red");
                    }else if($('#examCode').val() === ""){
                        $('#examCode').closest('.form-group').addClass('needs-validation')
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

        function fillInput(val) {
            if (val == "vendor") {
                $("#vendor").closest('.form-group').removeClass('needs-validation')
                $("#vendor").closest('.form-group').find('.invalid-feedback').hide();
                $("#vendor").prev('.input-group-addon').css("background-color","red");
            }else if (val == "exam_purpose") {
                $("#examPurpose").closest('.form-group').removeClass('needs-validation')
                $("#examPurpose").closest('.form-group').find('.invalid-feedback').hide();
                $("#examPurpose").prev('.input-group-addon').css("background-color","red");
            }else if (val == "lead_id") {
                $("#leadId").closest('.form-group').removeClass('needs-validation')
                $("#leadId").closest('.form-group').find('.invalid-feedback').hide();
                $("#leadId").prev('.input-group-addon').css("background-color","red");
            }else if (val == "pid") {
                $("#pid").closest('.form-group').removeClass('needs-validation')
                $("#pid").closest('.form-group').find('.invalid-feedback').hide();
                $("#pid").prev('.input-group-addon').css("background-color","red");
            }else if (val == "renewal") {
                $("#renewal").closest('.form-group').removeClass('needs-validation')
                $("#renewal").closest('.form-group').find('.invalid-feedback').hide();
                $("#renewal").prev('.input-group-addon').css("background-color","red");
            }else if(val == "projectPhase"){
                $("#projectPhase").closest('.form-group').removeClass('needs-validation')
                $("#projectPhase").closest('.form-group').find('.invalid-feedback').hide();
                $("#projectPhase").prev('.input-group-addon').css("background-color","red");
            }
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
                        url:"{{url('/certification_list/storeLastStepRequest')}}",
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

    </script>

@endsection