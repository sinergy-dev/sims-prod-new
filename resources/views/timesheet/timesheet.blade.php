@extends('template.main_sneat')
@section('tittle')
  Timesheet
@endsection
@section('pageName')
  Timesheet
@endsection
@section('head_css')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}"/>
  <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmSAQhPWId5Nd6QxE8To4ADjM2a6n0BrqQdisZ/RPUlm0YycDzvNL1HHAh1nKZqI0kSbif+5upQ==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
  <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
  <style type="text/css">
    .select2{
      width: 100%!important;
    }

    textarea{
      resize: vertical;
    }

    .disabled-day {
      pointer-events: none; /* Disable pointer events for the disabled days */
      cursor: not allowed;
    }

    .highlighted{
      background-color: blue;
    }

    .ui-flatpickr-week-end {
      color: red;
    }

    .date-range-highlight {
      background-color: #C3D3D6; /* Replace with your desired color */
    }

    .custom-date-button {
      background-color: #3498db;
      color: #fff;
      border: none;
      padding: 3px 10px;
      cursor: pointer;
      /*z-index: 999;*/
      display: inline-block;
    }

    .fc-widget-content {
      position: relative;
      padding-bottom: 15px;
    }

    .spanEmoji {
      font-size: calc(4px + 2vw);
      min-width: 1.4em;
      position: absolute;
      bottom: 0; /* Adjust the distance from the bottom */
      left: 0; /* Adjust the distance from the left */
    }

    .spanEmoji::after {
        animation-timing-function: linear;
        animation-iteration-count: infinite;
    }

    .fc-row .fc-content-skeleton {
      min-height: 150px;
      padding-bottom: 50px;
    }

    .emoji {
        font-size: calc(2px + 2vw);
        min-width: 1.4em;
        margin: 0.3em 0.4em;
        text-align: center;
    }

    @media screen and (max-width: 768px) {
      .fc-row .fc-content-skeleton {
        min-height: 150px;
        padding-bottom: 50px;
        padding-top: 30px;
      }

      .spanEmoji {
        font-size: calc(25px + 4vw);
        min-width: 1.4em;
        position:absolute;
        bottom: 0;
        left: 0;
      }

      .emoji {
          font-size: calc(5px + 4vw);
          min-width: 1.4em;
          margin: 0.3em 0.4em;
          text-align: center;
      }
    }

    .emoji::after {
        animation-timing-function: linear;
        animation-iteration-count: infinite;
    }

    .angry::after {
        content: '😠';
        --emoji-1: '😡';
        --emoji-2: '🤬';
        animation-name: threeFrames;
        animation-duration: 1.2s;
    }

    .vommit::after {
        content: '🤢';
        --emoji: '🤮';
        animation-name: twoFrames;
        animation-duration: 1.2s;
    }

    .normal::after {
        content: '😶';
        --emoji: '😐';
        animation-name: twoFrames;
        animation-duration: 1.2s;
    }

    .happy::after {
        content: '🙂';
        --emoji: '😉';
        animation-name: twoFrames;
        animation-duration: 1.2s;
    }

    .very-happy::after {
        content: '😎';
        --emoji: '🤩';
        animation-name: twoFrames;
        animation-duration: 1.2s;
    }

    @keyframes twoFrames {
        50% {
            content: var(--emoji);
        }
    }

    @keyframes threeFrames {
        33.333% {
            content: var(--emoji-1);
        }

        66.666% {
            content: var(--emoji-2);
        }
    }

    input[type="radio"]:checked + label > .emoji{
        border: 2px solid black;
    }

    .emoji:hover{
      border: 2px black solid;
      transition: width .3s;
    }

    .pull-right{
      float: right;
    }

    .pull-left{
      float: left;
    }

    .form-group{
      margin-bottom: 15px;
    }

    #daterange-timesheet{
      text-align: center;
    }

    .swal2-container {
      z-index: 9999 !important;
    }

    .select2-container {
      z-index: 1055 !important; /* modal default: 1050 */
    }

    .select2-dropdown {
      z-index: 1060 !important;
    }
  </style>
@endsection
@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">  
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="alert alert-solid-primary alert-dismissible" id="alertForRemaining">
              <i class="icon bx bx-info-circle"></i> Hai <span>. . .</span>! Your mandays this month is <span>. . .</span>%, Happy Working!!  &#9994; <a href="{{url('timesheet/dashboard')}}" style="cursor: pointer;">See My Dashboard</a>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
              </button>
          </div>
        </div>
      </div>
      <div class="row">
          <div class="col-md-3 col-xs-12">
            <div class="card card-solid mb-4">
              <div class="card-header with-border">
                <h6 class="card-title">Event Color Definition</h6>
              </div>
              <div class="card-body">
                <table class="table">
                  <tr>
                    <th>Status</th>
                    <th>Definition</th>
                  </tr>
                  <tr>
                    <td><span class="badge" style="background-color: #3c8dbc;color:white;">New</span></td>
                    <td>New event created</td>
                  </tr>
                  <tr>
                    <td><span class="badge" style="background-color: #00a65a;color:white;">Done</span></td>
                    <td>Event done</td>
                  </tr>
                  <tr>
                    <td><span class="badge" style="background-color: #f56954;color:white;">Cancel</span></td>
                    <td>Canceled event</td>
                  </tr>
                  <tr>
                    <td><span class="badge" style="background-color: #00c0ef;color:white;">Reschedule</span></td>
                    <td>Rescheduled event</td>
                  </tr>
                  <tr>
                    <td><span class="badge" style="background-color: #f39c12;color:white;">Not-Done</span></td>
                    <td>Not done event</td>
                  </tr>
                  <tr>
                    <td><span class="badge" style="background-color: #605ca8;color:white;">Sick</span></td>
                    <td>Sick</td>
                  </tr>
                  <tr>
                    <td><span class="badge" style="background-color: #605ca8;color:white;">Permit</span></td>
                    <td>Permit</td>
                  </tr>
                  <tr>
                    <td><span class="badge" style="background-color: #605ca8;color:white;">Leaving Permit</span></td>
                    <td>Leaving permit</td>
                  </tr>
                </table>
                <div class="table">
                </div>
              </div>
            </div>

            <div class="card card-solid mb-4">
              <div class="card-header with-border">
                <h6 class="card-title">Lock Duration</h6>
              </div>
              <div class="card-body">
                <div class="badge text-bg-secondary">
                  <i class="bx bx-lock"></i>&nbsp<span id="title_lock_duration"></span>
                </div>
              </div>
            </div>

            <div class="card card-solid" style="display:none!important;">
              <div class="card-header with-border">
                <h6 class="card-title">Timesheet Status</h6>
              </div>
              <div class="card-body">
                <div id="timesheet_status" class="badge">
                </div>
                <button class="btn btn-sm btn-danger" onclick="removeFilter()">Remove Filter</button>                 
              </div>
            </div>

          </div>
          <div class="col-md-9 col-xs-12">
            <div class="card card-primary">
              <div class="card-header">
                <div class="pull-left">
                  <a class="btn btn-sm btn-danger btn-flat" href="{{url('timesheet/dashboard')}}"><i class="bx bx-home"></i>&nbsp&nbspBack to Dashboard</a>
                  <a class="btn btn-sm text-bg-warning btn-flat" id="btn_back_timesheet_spv" style="display:none!important"><i class="bx bx-calendar"></i>&nbsp&nbspMy Timesheet</a>
                  &nbsp&nbsp<h6 class="card-title name_change"></h6>
                </div>
                <div class="pull-right">
                  <button class="btn btn-sm btn-success" onclick="importCsv()" id="uploadTimesheet" style="display:none!important">Upload CSV</button>
                  <button class="btn btn-sm btn-warning" onclick="addPermit()">Permit</button>
                </div>
              </div>
              <div class="card-body no-padding">
                <div id="calendar"></div>
              </div>
            </div>
          </div>
      </div>
    </section> 
  </div>

  <div class="modal fade" id="ModalUpdateTimesheet" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <h6 class="modal-title">Add Activity</h6>
          </div>
          <div class="modal-body">
            <form action="" id="modal_timesheet" name="modal_timesheet">
                @csrf
              <div id="fieldset_refer">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="" name="id_activity" id="id_activity" value="" hidden>
                      <label>Schedule*</label>
                      <select class="form-control select2" name="selectSchedule" id="selectSchedule" onchange="validateInput(this)">
                        <option></option>
                      </select>
                      <span class="invalid-feedback" style="display:none!important">Please select schedule!</span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Date*</label>
                      <input type="text" class="form-control" id="daterange-input" name="" disabled="disabled">
                      <span class="invalid-feedback" style="display:none!important">Please select date!</span>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label>Type*</label>
                  <select class="form-control select2" name="selectType" id="selectType_refer" onchange="validateInput(this)">
                    <option></option>
                  </select>
                  <span class="invalid-feedback" style="display:none!important">Please select Type!</span>
                </div>

                <div class="form-group">
                  <label>PID/Lead ID</label>
                  <select class="form-control" name="selectLead" id="selectLead_refer" placeholder="Select Project Id" onchange="validateInput(this)"><option></option></select>
                  <span class="invalid-feedback" style="display:none!important">Please select Lead ID!</span>
                  <small>Nomor PID tidak tersedia? <a style="cursor: not-allowed;" id="idAddPid_refer">tambahkan disini</a></small>
                  <div class="row" id="divPid_refer" style="display: none;">
                    <div class="col-lg-11 col-xs-11">
                      <input type="inputPid" name="inputPid" id="inputPid_refer" class="form-control">
                    </div>
                    <div class="col-lg-1 col-xs-1" style="padding-left:0px!important;"><i class="bx bx-2x bx-x pull-left" style="color:red" onclick="closePidAdjustment('refer')"></i></div>                    
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Task <small onclick="showHelp('task')"><i class="bx bx-info-circle"></i></small></label>
                      <select class="form-control" name="selectTask" id="selectTask_refer"><option></option></select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Phase <small onclick="showHelp('phase')"><i class="bx bx-info-circle"></i></small></label>
                      <select class="form-control" name="selectPhase" id="selectPhase_refer"><option></option></select>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label>Level <small onclick="showHelp('level')"><i class="bx bx-info-circle"></i></small></label>
                  <select class="form-control" name="selectLevel" id="selectLevel_refer"><option></option></select>
                  <span class="invalid-feedback" style="display:none!important">Please select Level!</span>
                </div>

                <div class="form-group">
                  <label>Activity*</label>
                  <textarea class="form-control" name="textareaActivity" id="textareaActivity_refer" onkeyup="validateInput(this)" disabled></textarea> 
                  <span class="invalid-feedback" style="display:none!important">Please fill Activity!</span>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Duration</label>
                      <select class="form-control" name="selectDuration" id="selectDuration_refer" onchange="validateInput(this)"><option></option></select>
                      <span class="invalid-feedback" style="display:none!important">Please select Duration!</span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Status</label>
                      <select class="form-control" name="selectStatus" id="selectStatus_refer" onchange="validateInput(this)"><option></option></select>
                      <span class="invalid-feedback" style="display:none!important">Please select Status!</span>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <div class="modal-footer">
                <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-sm btn-primary" onclick="saveTimesheet('refer')">Save</button>
            </div>
        </div>
      </div>
    </div>
  </div> 

  <div class="modal fade" id="ModalAddTimesheet" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header" style="padding-bottom: 0px;">
          <div style="padding-bottom: 0px!important;width: 100%;">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-text">
                  <a id="unplannedDate"><i class="bx bx-chevron-left" ></i></a>
                </div>
                <input type="text" name="daterange-timesheet" id="daterange-timesheet" class="form-control">
                <div class="input-group-text">
                  <a id="plannedDate"><i class="bx bx-chevron-right" ></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body">
        <form action="" id="modal_timesheet" name="modal_timesheet">
          @csrf
          <fieldset style="padding-bottom: 5px;" id="fieldset_0">
            <div class="form-group" style="display:inline;">
              <div class="card" style="border-top:none;width: 80%;float: left;border: 1px solid #ccc;">
                <div class="card-header" style="display:flex;justify-content: space-between; align-items: center">
                  <h6 class="card-title" style="font-size:14px">Activity 1</h6>
                  <button type="button" class="btn btn-sm collapse-fieldset" fdprocessedid="gkstjs"><i class="bx bx-minus"></i>
                  </button>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <input type="" name="id_activity" id="id_activity_0" value="" hidden>
                      <div class="form-group">
                        <label>Schedule*</label>
                        <input type="text" name="scheduleInput" id="scheduleInput_0" value="Unplanned" class="form-control" disabled>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Type*</label>
                        <select class="form-control select2" name="selectType" id="selectType_0" onchange="validateInput(this)">
                          <option>  </option>
                        </select>
                        <span class="invalid-feedback" style="display:none!important">Please select Type!</span>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>PID/Lead ID</label>
                    <select class="form-control" name="selectLead" id="selectLead_0" placeholder="Select Project Id" onchange="validateInput(this)"><option></option></select>
                    <span class="invalid-feedback" style="display:none!important">Please select Lead ID!</span>
                    <small>Nomor PID tidak tersedia? <a style="cursor: not-allowed;" id="idAddPid_0" name="idAddPid">tambahkan disini</a></small>
                    <div class="row" id="divPid_0" name="divPid" style="display: none;">
                      <div class="col-lg-11 col-xs-11">
                        <input type="inputPid" name="inputPid" id="inputPid_0" class="form-control">
                      </div>
                      <div class="col-lg-1 col-xs-1" style="padding-left:0px!important;"><i class="bx bx-2x bx-x pull-left" style="color:red" onclick="closePidAdjustment(0)" id="idClosePid_0" name="idClosePid"></i>
                      </div>                    
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Task <small onclick="showHelp('task')"><i class="bx bx-info-circle"></i></small></label>
                        <select class="form-control" name="selectTask" id="selectTask_0"><option></option></select>
                        <!-- <span class="invalid-feedback" style="display:none!important">Please select task!</span> -->
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Phase <small onclick="showHelp('phase')"><i class="bx bx-info-circle"></i></small></label>
                        <select class="form-control" name="selectPhase" id="selectPhase_0"><option></option></select>
                        <!-- <span class="invalid-feedback" style="display:none!important">Please select phase!</span> -->
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Level <small onclick="showHelp('level')"><i class="bx bx-info-circle"></i></small></label>
                    <select class="form-control" name="selectLevel" id="selectLevel_0"><option></option></select>
                    <span class="invalid-feedback" style="display:none!important">Please select Level!</span>
                  </div>

                  <div class="form-group">
                    <label>Activity*</label>
                    <textarea class="form-control" name="textareaActivity" id="textareaActivity_0" onkeyup="validateInput(this)"></textarea> 
                    <span class="invalid-feedback" style="display:none!important">Please fill Activity!</span>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Duration</label>
                        <select class="form-control" name="selectDuration" id="selectDuration_0" onchange="validateInput(this)"><option></option></select>
                        <span class="invalid-feedback" style="display:none!important">Please select Duration!</span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="selectStatus" id="selectStatus_0" onchange="validateInput(this)"><option></option></select>
                        <span class="invalid-feedback" style="display:none!important">Please select Status!</span>
                      </div>
                    </div>
                  </div>

                  <div class="form-group" hidden>
                    <label>exist Date</label><input type="text" class="form-control" id="existingDate_0" name="existingDate">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group" style="display:inline;">
              <button type="button" class="btn btn-sm btn-primary" id="btn_add_activity" style="margin-left: 5px;" value="0"><i class="bx bx-plus"></i></button>
            </div>
          </fieldset>
        </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button class="btn btn-sm btn-primary" onclick="saveTimesheet('add')">Save</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="ModalPermit" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <h6 class="modal-title">Add Permit</h6>
          </div>
          <div class="modal-body">
            <form action="" id="modal_phase" name="modal_phase">
                @csrf
                <div class="form-group">
                  <label>Date*</label>
                  <input class="form-control" name="inputPermitDate" id="inputPermitDate" onchange="validateInput(this)"/>
                  <span class="invalid-feedback" style="display:none!important">Please fill Date!</span>
                </div>
                <div class="form-group">
                  <label>Permit*</label>
                  <select class="form-control select2" name="selectPermit" id="selectPermit" onchange="validateInput(this)">
                    <option></option>
                  </select>
                  <span class="invalid-feedback" style="display:none!important">Please fill Permit!</span>
                </div>
                <div class="form-group">
                  <label>Activity*</label>
                  <textarea class="form-control" name="textareaActivityPermit" id="textareaActivityPermit" placeholder="Enter Activity" onkeyup="validateInput(this)"></textarea>
                  <span class="invalid-feedback" style="display:none!important">Please fill Activity!</span>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button class="btn btn-sm btn-primary" type="button" onclick="storePermit('ModalPermit')">Save</button>
          </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="ModalInfo" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <h6 class="modal-title">Information!</h6>
        </div>
        <div class="modal-body">
          <form action="" id="modal_info" name="modal_info">
            @csrf
            <table class="table table-striped" id="tbInfo">
            </table>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-sm btn-danger" id="btn_delete_permit">Delete</button>
          <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="ModalImport" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <h6 class="modal-title">import CSV!</h6>
          </div>
          <div class="modal-body">
            <form action="" id="" name="">
              @csrf
              <div style="display: flex;">
                <span style="margin: 0 auto;">You can get format of CSV from this <a href="{{url('https://drive.google.com/uc?export=download&id=1EtIvRkBz-xGE6658NbaQ41yfyEzs-VLi')}}" style="cursor:pointer;">link</a></span>
              </div>
              <input type="file" name="inputCsv" id="inputCsv" class="form-control">
            </form>
          </div>
          <div class="modal-footer">
            <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-sm btn-success" onclick="uploadCsv()">Upload</button>
          </div>
      </div>
    </div>
  </div>
@endsection
@section('scriptImport')
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  {{--  Calendar  --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.43/moment-timezone-with-data-10-year-range.js" integrity="sha512-QSV7x6aYfVs/XXIrUoerB2a7Ea9M8CaX4rY5pK/jVV0CGhYiGSHaDCKx/EPRQ70hYHiaq/NaQp8GtK+05uoSOw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js" integrity="sha512-o0rWIsZigOfRAgBxl4puyd0t6YKzeAw9em/29Ag7lhCQfaaua/mDwnpE2PVzwqJ08N7/wqrgdjc2E0mwdSY2Tg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('script')
  <script type="text/javascript"> 
    ///////
    window.mobilecheck = function() {
      var check = false;
      (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
      return check;
    };

    if (window.matchMedia("(max-width: 767px)").matches) 
    {
        // The viewport is less than 768 pixels wide
        // $("#ModalAddTimesheet").find(".btn-flat").closest(".form-group").css("float","")
        $("#ModalAddTimesheet").find("#scheduleInput").closest(".form-group").css("float","")
        $("#ModalAddTimesheet").find(".input-group").css("width","")
        $("#ModalAddTimesheet").find(".collapsed-card").css("width","")
    } else {
        
        // The viewport is at least 768 pixels wide
        // $("#ModalAddTimesheet").find(".btn-flat").closest(".form-group").css("float","right")
        // $("#ModalAddTimesheet").find("#scheduleInput").closest(".form-group").css("float","right")
        // $("#ModalAddTimesheet").find(".input-group").css("width","75%")
        $("#ModalAddTimesheet").find(".collapsed-card").css("width","85%")
    }

    var nik = "{{Auth::User()->nik}}"
    if (window.location.href.split("/")[4].split("=")[1] == undefined) {
      nik = nik
    }else if (window.location.href.split("/")[4].split("?")[1].split("=")[0] == "nik"){
      nik = window.location.href.split("/")[4].split("=")[1]
    }

    var email = '', name = ''
    $.ajax({
      type:"GET",
      url:"{{url('/timesheet/getNameByNik')}}",
      data:{
        nik:nik
      },success:function(result){
        return email = result.email
      }
    })

    var calendar
    $(document).ready(function(){
      localStorage.removeItem('arrFilter');
      var accesable = @json($feature_item);
      
      accesable.forEach(function(item,index){
        $("#" + item).show()
      })

      if (nik == '{{Auth::User()->nik}}') {
        $('#btn_back_timesheet_spv').attr('style','display:none!important')
      }

      if(nik == "{{Auth::User()->nik}}"){
        $("#alertForRemaining").show()
      }else{
        $("#alertForRemaining").attr('style','display:none!important')
      }

      calendar = $('#calendar').fullCalendar({
        timezone:'Asia/Jakarta',
        defaultView:"month",
      });
      loadData()

      //cek is fill feeling
      if (nik == "{{Auth::User()->nik}}") {
        $.ajax({
          type:"GET",
          url:"{{url('timesheet/isFillFeeling')}}",
          success:function(result){
            if(result[0] == "false"){
              howWasYou()
            }
          }
        })
      }
    })

    // $('#daterange-timesheet').on('apply.daterangepicker',(e,picker) => {
    //   var range = moment().isBetween(picker.startDate, picker.endDate);

    //   if (range) {
    //     if (moment(picker.endDate).format("YYYY-MM-DD") != moment(moment()).format("YYYY-MM-DD")) {
    //       Swal.fire(
    //         'Date is not appropriated!',
    //         'Select range date with correct schedule type',
    //         'error'
    //       ).then(() => {
    //         var start = moment(moment()).format('MM/DD/YYYY')
    //         var end = moment(moment()).format('MM/DD/YYYY') 

    //         $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
    //         $('#daterange-timesheet').data('daterangepicker').setEndDate(end);
    //         eventUpdateTimesheet()
    //       })
    //     }else {
    //       $("input[name='scheduleInput']").val("Unplanned")
    //       $("select[name='selectDuration']").prev("label").after("<span>*</span>")
    //       $("select[name='selectStatus']").prev("label").after("<span>*</span>")
    //       $("select[name='selectDuration']").prop("disabled",false)
    //       $("select[name='selectStatus']").prop("disabled",false)

    //       Swal.fire({
    //         title: 'Loading...',
    //         allowEscapeKey: false,
    //         allowOutsideClick: false,
    //         confirmButtonText:'',
    //         showConfirmButton:false,
    //         didOpen: () => {
    //           // Delayed task using setTimeout
    //           setTimeout(() => {
    //             // Close the loading indicator
    //             var start = moment(picker.startDate).format('MM/DD/YYYY')
    //             var end = moment(picker.endDate).format('MM/DD/YYYY') 

    //             $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
    //             $('#daterange-timesheet').data('daterangepicker').setEndDate(end);

    //             eventUpdateTimesheet();
    //             Swal.close();
    //           }, 2000); // Delayed execution after 2000ms (2 seconds)
    //         }
    //       });
    //     }
    //   }else{
    //     if (picker.startDate > moment()) {
    //       $("input[name='scheduleInput']").val("Planned")
    //       $("select[name='selectDuration']").prev("span").remove()
    //       $("select[name='selectStatus']").prev("span").remove()
    //       $("select[name='selectDuration']").prop("disabled",true)
    //       $("select[name='selectStatus']").prop("disabled",true)

    //       Swal.fire({
    //         title: 'Loading...',
    //         allowEscapeKey: false,
    //         allowOutsideClick: false,
    //         confirmButtonText:'',
    //         showConfirmButton:false,
    //         didOpen: () => {
    //           // Delayed task using setTimeout
    //           setTimeout(() => {
    //             // Close the loading indicator
    //             var start = moment(picker.startDate).format('MM/DD/YYYY')
    //             var end = moment(picker.endDate).format('MM/DD/YYYY') 

    //             $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
    //             $('#daterange-timesheet').data('daterangepicker').setEndDate(end);

    //             eventUpdateTimesheet();
    //             Swal.close();
    //           }, 2000); // Delayed execution after 2000ms (2 seconds)
    //         }
    //       });
    //     }else if (picker.startDate <= moment()) {
    //       $("input[name='scheduleInput']").val("Unplanned")
    //       $("select[name='selectDuration']").prev("label").after("<span>*</span>")
    //       $("select[name='selectStatus']").prev("label").after("<span>*</span>")
    //       $("select[name='selectDuration']").prop("disabled",false)
    //       $("select[name='selectStatus']").prop("disabled",false)

    //       Swal.fire({
    //         title: 'Loading...',
    //         allowEscapeKey: false,
    //         allowOutsideClick: false,
    //         confirmButtonText:'',
    //         showConfirmButton:false,
    //         didOpen: () => {
    //           // Delayed task using setTimeout
    //           setTimeout(() => {
    //             // Close the loading indicator
    //             var start = moment(picker.startDate).format('MM/DD/YYYY')
    //             var end = moment(picker.endDate).format('MM/DD/YYYY') 

    //             $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
    //             $('#daterange-timesheet').data('daterangepicker').setEndDate(end);

    //             eventUpdateTimesheet();
    //             Swal.close();
    //           }, 2000); // Delayed execution after 2000ms (2 seconds)
    //         }
    //       });
    //     }
    //   }
    // });

    // $('#daterange-timesheet').on('cancel.daterangepicker',(e,picker) => {
    //   var start = moment(picker.startDate).format('MM/DD/YYYY')
    //   var end = moment(picker.endDate).format('MM/DD/YYYY') 

    //   $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
    //   $('#daterange-timesheet').data('daterangepicker').setEndDate(end);
    // })

    function howWasYou(){
      Swal.fire({
        title: '<strong>How was your day?</strong>',
        icon: 'question',
        html:
          '<div style="display:inline;">'+
          '  <input id="radio1" type="radio" name="radio" value="radio1" hidden onclick="selectEmoji('+"'angry'"+')">'+
          '  <label for="radio1" id="circle">'+
          '   <span class="emoji angry" role="img" aria-label="angry"></span>' +
          '  </label>'+
          '</div>'+
          '<div style="display:inline;">'+
          '  <input id="radio2" type="radio" name="radio" value="radio2" hidden onclick="selectEmoji('+"'vommit'"+')">'+
          '  <label for="radio2" id="circle">'+
              '<span class="emoji vommit" role="img" aria-label="vommit"></span>' +
          '  </label>'+
          '</div>'+
          '<div style="display:inline;">'+
          '  <input id="radio3" type="radio" name="radio" value="radio3" hidden onclick="selectEmoji('+"'normal'"+')">'+
          '  <label for="radio3" id="circle">'+
          '     <span class="emoji normal" role="img" aria-label="normal"></span>' +
          '  </label>'+
          '</div>'+
          '<div style="display:inline;">'+
          '  <input id="radio4" type="radio" name="radio" value="radio4" hidden onclick="selectEmoji('+"'happy'"+')">'+
          '  <label for="radio4" id="circle">'+
          '     <span class="emoji happy" role="img" aria-label="happy"></span>' +
          '  </label>'+
          '</div>'+
          '<div style="display:inline;">'+
          '  <input id="radio5" type="radio" name="radio" value="radio5" hidden onclick="selectEmoji('+"'very-happy'"+')">'+
          '  <label for="radio5" id="circle">'+
          '     <span class="emoji very-happy" role="img" aria-label="very-happy"></span>'+
          '  </label>'+
          '</div>',
        showCloseButton: true,
        showCancelButton: true,
        showConfirmButton:false,
        focusConfirm: false,
        confirmButtonText:
          '<i class="bx bx-thumbs-up"></i> Save!',
        cancelButtonText:
          'Ask me, later!',
      }).then((result) => {
        if (result.isDismissed) {
          if ($('input[type="radio"]:checked').length == 0){
            formData = new FormData
            formData.append("_token","{{ csrf_token() }}")
            formData.append("code_feeling","-")    
            createPost(swalFireCustom="",formData,swalSuccess="",url="/timesheet/storeFeeling",postParam="")
          }          

        }
      });
    }

    function selectEmoji(value){
      formData = new FormData
      formData.append("_token","{{ csrf_token() }}")
      formData.append("code_feeling",value)     

      createPost(swalFireCustom="",formData,swalSuccess="",url="/timesheet/storeFeeling",postParam="")
    }

    $("#btn_back_timesheet_spv").click(function(){
      window.location.href = '{{url("timesheet/timesheet")}}';
    })

    var currentDate = new Date(); // Get the current date
    var tomorrow = new Date()

    tomorrow.setDate(currentDate.getDate() + 1)
    var endDate = currentDate.toLocaleDateString();

    function loadData(valDate){
      var arrFilter = localStorage.getItem("arrFilter",arrFilter)
      var arrFilter = "", dateDifYear = "date=", year = ""

      if (valDate != undefined) {
        if (dateDifYear == "date=") {
          dateDifYear = dateDifYear + valDate
        }else{
          dateDifYear = dateDifYear + '&date=' + valDate
        }

        var year = valDate.split("-")[0]
      }else{
        var dateDifYear = '&date='
        var year = year
      }

      if(arrFilter == null || arrFilter == ""){
        $("#timesheet_status").html('<i class="bx bx-filter"></i>&nbspFilter Off')
        $("#timesheet_status").addClass('text-bg-danger')
      }else{
        arrFilter = arrFilter

        $("#timesheet_status").html('<i class="bx bx-filter"></i>&nbspFilter On')
        $("#timesheet_status").addClass('text-bg-success')
      }

      let startFullcalendar = calendar.fullCalendar('getView').start.format('YYYY-MM-DD');
      let endFullcalendar = calendar.fullCalendar('getView').end.format('YYYY-MM-DD');

      $.ajax({
        type:"GET",
        url:"{{'/timesheet/getAllActivityByUser'}}"+ "?nik=" + nik + arrFilter + '&' + dateDifYear + '&dateStart=' + startFullcalendar + '&dateEnd=' + endFullcalendar,
        success:function(results){
          $.ajax({
            type:"GET",
            url:"{{url('/getListCalendarEvent')}}"+ "?nik=" + nik + '&year=' + year + '&dateStart=' + startFullcalendar + '&dateEnd=' + endFullcalendar,
            success:function(result){
              const apiKey = '{{env("GOOGLE_API_KEY_APP")}}';
              const timeMin = new Date(new Date().setFullYear(new Date().getFullYear() - 1)).toISOString(); // 1 year ago
              const timeMax = new Date(new Date().setFullYear(new Date().getFullYear() + 1)).toISOString();

              var events = [], disabledDates = []

              $.ajax({
                url:"https://www.googleapis.com/calendar/v3/calendars/en.indonesian%23holiday%40group.v.calendar.google.com/events",
                data: {
                  key: apiKey,
                  timeMin: timeMin,
                  timeMax: timeMax,
                  singleEvents: true,
                  orderBy: 'startTime'
                },
                success: function(response){
                  const data = response.items;
                  if (data.length) {
                    data.forEach(data => {
                      if(data.description == "Public holiday"){
                        const start = data.start.dateTime || data.start.date;

                        if (data.summary.indexOf('Joint') == -1) {
                          console.log(start + data.summary)
                          // disabledDates.push(moment.utc(start, 'YYYY-MM-DD'))

                          return events.push({
                            id:data.id,
                            title:data.summary,
                            start:start,
                            end:start,
                            activity:data.summary,
                            remarks:"Cuti Bersama",
                            refer:null
                          })
                        }
                        if (data.summary.indexOf('Idul Fitri') !== -1 || data.summary.indexOf('carding Day') !== -1) {
                          console.log(start + data.summary)
                          return events.push({
                            id:data.id,
                            title:data.summary,
                            start:start,
                            end:start,
                            activity:data.summary,
                            remarks:"Cuti Bersama",
                            refer:null
                          })
                        }
                      }
                    });
                  }
                },
                error: function(error) {
                    console.error('Error fetching events:', error);
                }
              })

              console.log(events)

              if (results.data.length > 0) {
                $.each(results.data,function(idx,value){
                  if (value.remarks != null) {
                    events.push({
                      id:value.id,
                      title:value.activity,
                      start:value.start_date,
                      end:value.end_date,
                      activity:value.activity,
                      remarks:value.remarks,
                      refer:null
                    })   

                    disabledDates.push(moment.utc(value.start_date, 'YYYY-MM-DD'))
                  }else{
                    events.push({
                      title:value.activity,
                      start:value.start_date,
                      originalStartDate:value.start_date,
                      end:value.end_date,
                      end:moment(value.end_date).endOf('day'),
                      // moment(value.end_date).endOf('day')
                      id:value.id,
                      type:value.type,
                      task:value.task,
                      schedule:value.schedule,
                      pid:value.pid,
                      phase:value.phase,
                      level:value.level,
                      duration:value.duration,
                      status:value.status,
                      status_pid:value.status_pid,
                      planned:value.planned,
                      unplanned:value.unplanned,
                      refer:null
                    }) 
                  }
                })
              }

              var lock_activity = [{"lock_activity":results.lock_duration}]
              var emoji = results.emoji
              var week = " Week"
              if (results.lock_duration < 7) {
                if (results.lock_duration > 1) {
                  week = " Days"
                }else{
                  week = " Day"
                }
                $("#title_lock_duration").text(results.lock_duration + week)
              }else{
                week = week

                $("#title_lock_duration").text((parseInt(results.lock_duration) / 7) + week)
              }

              var arrayData = []

              function convertToYMD(dateTime) {
                const date = new Date(dateTime);

                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
                const day = String(date.getDate()).padStart(2, '0');

                return `${year}-${month}-${day}`;
              }

              var startDate = "", endDate = ""
              if (result != "") {
                result.items.map(item => {
                  if (item.creator != undefined) {
                    if (Object.keys(item.creator).length == 2) {
                      if (item.creator.self == true) {
                        isCreator = true

                        if (item.start.dateTime || item.end.dateTime) {
                          startDate = convertToYMD(item.start.dateTime)
                          endDate = convertToYMD(item.end.dateTime)
                        }else{
                          startDate = item.start.date
                          endDate = moment(item.end.date).subtract(1,'day')
                        }

                        if (startDate != endDate && item.title === item.title) {
                          var start = moment(startDate);
                          var end = moment(endDate);
                          // const newEndDate = end.subtract(1, 'day');

                          var dateRange = [];

                          var currentDate = moment(start);
                          while (currentDate.isSameOrBefore(end)) {
                              dateRange.push(currentDate.format('YYYY-MM-DD'))
                              currentDate.add(1, 'day');
                          }
                          // Output the array of dates
                          dateRange.forEach(function(date) {
                              arrayData.push({
                                id:item.id,
                                title: item.summary,
                                start: moment(date).format("YYYY-MM-DD"), // Use the appropriate start date/time property from the API response
                                end: moment(date).format("YYYY-MM-DD"), // Use the appropriate end date/time property from the API response
                                activity: item.summary,
                                refer:"gcal",
                                phase:null
                              })
                          });
                        }else{
                          arrayData.push({
                            id:item.id,
                            title: item.summary,
                            start: startDate, // Use the appropriate start date/time property from the API response
                            end: endDate, // Use the appropriate end date/time property from the API response
                            activity: item.summary,
                            refer:"gcal",
                            phase:null
                          })
                        }                                                 
                      }
                    }
                  }
                 
                  $.each(item.attendees,function(index,itemX){
                    if (itemX.responseStatus == "accepted") {
                      if (itemX.email == email) {
                        if (item.start.dateTime || item.end.dateTime) {
                          startDate = convertToYMD(item.start.dateTime)
                          endDate = convertToYMD(item.end.dateTime)
                        } else {
                          startDate = item.start.date
                          endDate = moment(item.end.date).subtract(1,'day')
                        }

                        if (startDate != endDate && item.title === item.title) {
                          var start = moment(startDate);
                          var end = moment(endDate);
                          // const newEndDate = end.subtract(1, 'day');
                          // Create an array to store the dates
                          var dateRange = [];
                          // Iterate over the dates within the range and add them to the array

                          var currentDate = moment(start);
                          while (currentDate.isSameOrBefore(end)) {
                              dateRange.push(currentDate.format('YYYY-MM-DD'))
                              currentDate.add(1, 'day');
                          }
                          // Output the array of dates
                          dateRange.forEach(function(date) {
                            arrayData.push({
                              id:item.id,
                              title: item.summary,
                              start: moment(date).format("YYYY-MM-DD"), // Use the appropriate start date/time property from the API response
                              end: moment(date).format("YYYY-MM-DD"), // Use the appropriate end date/time property from the API response
                              activity: item.summary,
                              refer:"gcal",
                              phase:null
                            })
                          });
                        }else{
                          arrayData.push({
                            id:item.id,
                            title: item.summary,
                            start: startDate, // Use the appropriate start date/time property from the API response
                            end: endDate, // Use the appropriate end date/time property from the API response
                            activity: item.summary,
                            refer:"gcal",
                            phase:null
                          })
                        }  
                      }
                    }
                  })
                })
              }
              // Merge the arrays

              console.log(events)
              console.log(arrayData)

              const mergedEvents = [...events, ...arrayData];

              function removeDuplicates(arr) {
                  let gcalNullFound = false;
                  let titleStartMap = {};
                  let result = [];

                  for (let i = 0; i < arr.length; i++) {
                      let current = arr[i];

                      let title = current.title.endsWith(' ') == true ? current.title.trimEnd() : current.title
                      let key = title + current.start;

                      // Check if the current item's refer is "gcal" and phase is null
                      if (current.refer === "gcal" && current.phase === null) {
                          // Check if we already found such an item
                          if (gcalNullFound) {
                              gcalNullFound = true;
                              titleStartMap[key] = true;
                              // result.push(current);

                              continue; // Skip adding this item to the result
                          }
                      }

                      // Check if the title and start combination is already added
                      if (!titleStartMap[key] || current.refer !== "gcal") {
                          titleStartMap[key] = true;
                          result.push(current);
                      }
                  }

                  return result;
              }

              var filteredData = removeDuplicates(mergedEvents);

              return showEvents(filteredData,lock_activity,disabledDates,emoji,valDate)
            },
            complete:function(){
              // Pace.stop();
            }
          })
          // })
        }
      })
    }

    var checkDate = ""
    var NewCalendar
    function showEvents(events,lock_activity,disabledDates,emoji,valDate){
      if (events) {
        $.ajax({
          type:"GET",
          url:"{{url('/timesheet/getNameByNik')}}",
          data:{
            nik:nik
          },success:function(result){
            $(".name_change").html('As '+ result.name + " <small>Timesheet</small>")
          }
        })

        var today = new Date(); // Get today's date
        var startOfWeek = new Date(today); // Create a new date object representing the start of the week
        var isJustOneDay = true

        if (lock_activity[0].lock_activity == 1) {
          var daysToSubtract = today.getDay(); // Add 7 to ensure we get to the first day of the next two-week period
          var incDate = 0
          isJustOneDay = isJustOneDay
        }else if (lock_activity[0].lock_activity == 7) {
          var daysToSubtract = today.getDay(); // Add 7 to ensure we get to the first day of the next two-week period
          var incDate = 7
          isJustOneDay = false

        }else if (lock_activity[0].lock_activity == 14) {
          var daysToSubtract = today.getDay() + 7; // Add 7 to ensure we get to the first day of the next two-week period
          var incDate = 14
          isJustOneDay = false

        }else if(lock_activity[0].lock_activity == 21){
          var daysToSubtract = today.getDay() + 14; // Add 7 to ensure we get to the first day of the next two-week period
          var incDate = 21
          isJustOneDay = false

        }else if(lock_activity[0].lock_activity == 28){
          var daysToSubtract = today.getDay() + 21;
          // startOfWeek.setDate(1)
          var incDate = 28
          isJustOneDay = false

        }else if(lock_activity[0].lock_activity == 35){
          // startOfWeek.setDate(1) //lock activity 1 month
          var daysToSubtract = today.getDay() + 28;
          var incDate = 35
          isJustOneDay = false

        }else if(lock_activity[0].lock_activity == 42){
          var daysToSubtract = today.getDay() + 35;
          var incDate = 42
          isJustOneDay = false

        }else if(lock_activity[0].lock_activity == 49){
          var daysToSubtract = today.getDay() + 42;
          var incDate = 49
          isJustOneDay = false

        }else if(lock_activity[0].lock_activity == 56){
          // startOfWeek.setDate(1) //lock activity 2 month
          var daysToSubtract = today.getDay() + 49;
          var incDate = 56
          isJustOneDay = false

        }else if(lock_activity[0].lock_activity == 84){
          // startOfWeek.setDate(1) //lock activity 3 month
          var daysToSubtract = today.getDay() + 77;
          var incDate = 84
          isJustOneDay = false

        }

        var datesInWeek = []; // Array to store the dates in the week

        // Set the date to the first day of the two-week or three-week period
        if (isJustOneDay == true) {
          datesInWeek.push(moment())
          var allowedDates = datesInWeek
        }else{
          var startOfWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() - daysToSubtract);
          for (var i = 0; i < incDate; i++) {
            var currentDate = new Date(startOfWeek);
            currentDate.setDate(startOfWeek.getDate() + i); // Set the date to each day within the week
            
            datesInWeek.push(moment(currentDate)); // Add the date to the array
          }

          var allowedDates = datesInWeek
          var currDate = moment().startOf('day');
        }
      }
      
      var isCustomButtonClick = false;

      calendar.fullCalendar('destroy');
      var eventRenderDataPlanned = {};
      var eventRenderDataUnplanned = {};
      var eventRenderDeviation = {};
      var eventRenderEmoji = {};
      // Calculate the sums for each day
      events.forEach(function(event) {
        if (event.start && event.unplanned !== undefined) {
          // Get the start date of the event in the 'YYYY-MM-DD' format
          var startDate = event.start;
          // Initialize the sum for this day if it doesn't exist
          if (!eventRenderDataUnplanned[startDate]) {
            eventRenderDataUnplanned[startDate] = 0;
          }

          // Accumulate the value for this day
          eventRenderDataUnplanned[startDate] += parseFloat(event.unplanned);
        }

        if (event.start && event.planned !== undefined) {
          // Get the start date of the event in the 'YYYY-MM-DD' format
          var startDate = event.start;
          // Initialize the sum for this day if it doesn't exist

          if (!eventRenderDataPlanned[startDate]) {
            eventRenderDataPlanned[startDate] = 0;
          }

          // Accumulate the value for this day
          eventRenderDataPlanned[startDate] += parseFloat(event.planned);
        }

        if (event.start && event.planned !== undefined) {
          // Get the start date of the event in the 'YYYY-MM-DD' format
          var startDate = event.start;
          // Initialize the sum for this day if it doesn't exist

          if (!eventRenderDeviation[startDate]) {
            eventRenderDeviation[startDate] = 0;
          }

          // Accumulate the value for this day
          eventRenderDeviation[startDate] += parseFloat(event.planned+event.unplanned);
        }
      });

      emoji.forEach(function(emoji){
        if (emoji.code_feeling != '-') {
          var startDate = moment(emoji.date_add).format("YYYY-MM-DD");

          if (!eventRenderEmoji[startDate]) {
            eventRenderEmoji[startDate] = emoji.code_feeling;
          }

          // Accumulate the value for this day
          eventRenderEmoji[startDate] = emoji.code_feeling;
        }
      })

      var calendarElement = $('#calendar').fullCalendar({
        // customButtons: {
        //   myCustomButton: {
        //     text: 'custom!',
        //     click: function() {
        //       alert('clicked the custom button!');
        //     }
        //   }
        // },
        timezone: 'Asia/Jakarta',
        // header: {
        //   left: 'myCustomButton',
        //   center: 'title',
        //   // right: 'month,agendaWeek,agendaDay'
        // }, 
        defaultView:"month",
        eventOrder: 'start',
        // defaultDate: '2023-08-01', // Set the initial visible date
        // validRange: {
        //   start: '2023-08-01',
        //   end: '2023-08-31'
        // },
        dayClick: function(date, jsEvent, view) { 
          // if (!$(jsEvent.target).hasClass('fc-day-top')) {   
            localStorage.setItem("isAddTimesheet",true)
            $("#daterange-timesheet").prop("disabled",false)
            $("#daterange-timesheet").next().css({"background-color":"","cursor":""})
            $("#daterange-timesheet").prev().css({"background-color":"","cursor":""})

            var start = date
            var end = date
            checkDate = moment(datesInWeek[0])
            // var position = "{{Auth::User()->id_position}}"
            if ("{{Auth::User()->nik}}" !== nik) {
              return false
            }else{
              var clickedDate = moment(date).format("YYYY-MM-DD"); 
              // Check if the clicked date is in the allowedDates array
              var isAllowedDate = datesInWeek.some(function(date) {
                return date.isSame(clickedDate, 'day');
              });

              if (isAllowedDate) {
                var isClickedDate = moment(date)
                  if (isClickedDate.isSameOrBefore(moment())) {
                    setHoliday(start,end,checkDate)
                      $("#ModalAddTimesheet").modal("show")

                      $("#unplannedDate").attr("onclick",'unplannedDate('+ "'" +moment(datesInWeek[0]).format('MM/DD/YYYY') + "'" +')')
                      $("#plannedDate").attr("onclick",'plannedDate('+ "'" + moment(datesInWeek[0]).format('MM/DD/YYYY') + "'" +')')

                      setDuration(0)
                      setLevel(0)
                      setStatus(0)
                      setType(0)
                      setTask(0)
                      setPhase(0)

                      $("#id_activity_0").val('')
                      $('#selectSchedule_0').val('').trigger('change')
                      $('#selectType_0').val('').trigger('change').prop("disabled",false)
                      $('#selectLead_0').val('').trigger('change').prop("disabled",false)
                      $('#selectTask_0').val('').trigger('change').prop("disabled",false)
                      $('#selectPhase_0').val('').trigger('change').prop("disabled",false)
                      $('#selectLevel_0').val('').trigger('change').prop("disabled",false)
                      $('#textareaActivity_0').val('').prop("disabled",false)
                      $('#selectDuration_0').val('').trigger('change').prop("disabled",false)
                      $('#selectStatus_0').val('').trigger('change').prop("disabled",false)

                      $("input[name='scheduleInput']").val("Unplanned")
                      $("select[name='selectDuration']").prev("label").after("<span>*</span>")
                      $("select[name='selectStatus']").prev("label").after("<span>*</span>")
                      $("select[name='selectStatus']").prop("disabled",false)

                      $("#ModalAddTimesheet").find('.modal-footer').show()

                      if ($("#ModalAddTimesheet").find('.modal-footer').find(".btn-warning")) {
                        $("#ModalAddTimesheet").find('.modal-footer').find(".btn-warning").removeClass("btn-warning").addClass("btn-primary").text('Save')
                      }

                      if ($("#ModalAddTimesheet").find('.modal-footer').find(".btn-danger")) {
                        $("#ModalAddTimesheet").find('.modal-footer').find(".btn-danger").remove()
                      }
                    }
              } else {
                // Disable the day click event for disallowed dates
                return false;
              }  
            }
        },
        eventClick: function(calEvent, jsEvent, view) {
            localStorage.setItem("isAddTimesheet",false) 
            $("#daterange-timesheet").prop("disabled",true)
            $("#unplannedDate").attr("onclick",'unplannedDate('+ "'" +moment(datesInWeek[0]).format('MM/DD/YYYY') + "'" +')')
            $("#plannedDate").attr("onclick",'plannedDate('+ "'" + moment(datesInWeek[0]).format('MM/DD/YYYY') + "'" +')')
            // $("#daterange-timesheet").next().css({"background-color":"#eee","cursor":"not-allowed"})
            // $("#daterange-timesheet").prev().css({"background-color":"#eee","cursor":"not-allowed"})

            var start = calEvent.start
            var end = calEvent.start
            checkDate = moment(datesInWeek[0])

            var clickedDate = calEvent.start 
            // Check if the clicked date is in the allowedDates array
            var isAllowedDate = datesInWeek.some(function(date) {
              return date.isSame(clickedDate, 'day');
            });

            //set holiday merupakan function untuk semua tanggal libur
            setHoliday(start,end,checkDate)
            if (isAllowedDate) {
              var isClickedDate = moment(calEvent.start)
                if (isClickedDate.isSameOrBefore(moment())) {
                  if (disabledDates.some(function(disabledDate) {
                    return calEvent.start.isSame(disabledDate, 'day');
                  })) {
                    if (calEvent.schedule == "Planned" || calEvent.schedule == "Unplanned") {
                      eventUpdateTimesheet(calEvent)
                    }else{
                      $("#ModalInfo").modal("show")
                      if (calEvent.remarks == 'Sick' || calEvent.remarks == 'Permit') {
                        $("#btn_delete_permit").show()
                        $("#btn_delete_permit").attr("onclick","deletePermit('"+ calEvent.id +"')")
                      }else{
                        $("#btn_delete_permit").attr('style','display:none!important')
                      }
                      $(".modal-title").text("Information")
                      $("#tbInfo").empty()
                      var append = ""
                      append = append + '<tr>'
                      append = append + '  <th width="100px">Date</th>'
                      append = append + '  <td>'+ moment(calEvent.start).format('YYYY-MM-DD')  +'</td>'
                      append = append + '</tr>'
                      append = append + '<tr>'
                      append = append + '  <th width="100px">Activity</th>'
                      append = append + '  <td>'+ calEvent.activity  +'</td>'
                      append = append + '</tr>'

                      $("#tbInfo").append(append)
                    }
                  }else{
                    if (calEvent.refer) {
                      $("#ModalUpdateTimesheet").modal("show")
                      $(".modal-title").text("Update Timesheet")
                      $("#ModalUpdateTimesheet").find('.modal-footer').find(".btn-primary").removeClass("btn-primary").addClass("btn-warning").text('Update')
                      $("#ModalupdateTimesheet").find('.modal-footer').show()
                      $("select[name='selectDuration']").prev("label").after("<span>*</span>")
                      $("select[name='selectStatus']").prev("label").after("<span>*</span>")

                      $("#id_activity").val(calEvent.id)
                      $('#selectSchedule').prop("disabled",true)
                      $('#textareaActivity_refer').val(calEvent.title).trigger('change') 

                      setSchedule(calEvent.start)
                      setDuration("refer")
                      setStatus("refer")
                      setType("refer")
                      setTask("refer")
                      setPhase("refer")
                      setLevel("refer")

                      $('#selectSchedule').val('Planned').trigger('change')
                      $('#daterange-input').prop("disabled",true)    

                      if(nik != "{{Auth::User()->nik}}"){
                        //spv/manager
                        var momentDate = moment(start); // Replace with your own moment date
                        // Get today's date
                        var today = moment();
                        var isSameDateToday = momentDate.isSame(today, 'day');
                        // if (isSameDateToday) {
                        //   $('#selectType_refer').prop("disabled",false)
                        //   $('#selectLead_refer').prop("disabled",false)
                        //   $('#selectTask_refer').prop("disabled",false)
                        //   $('#selectPhase_refer').prop("disabled",false)
                        //   $('#selectLevel_refer').prop("disabled",false)
                        //   $('#textareaActivity_refer').prop("disabled",true)
                        //   $('#selectDuration_refer').prop("disabled",false)
                        //   $('#selectStatus_refer').prop("disabled",false)
                        //   $("#ModalUpdateTimesheet").find('.modal-footer').attr('style','display:none!important')
                        // }else{
                          $('#selectType_refer').prop("disabled",false)
                          $('#selectLead_refer').prop("disabled",false)
                          $('#selectTask_refer').prop("disabled",false)
                          $('#selectPhase_refer').prop("disabled",false)
                          $('#selectLevel_refer').prop("disabled",false)
                          $('#textareaActivity_refer').prop("disabled",true)
                          $('#selectDuration_refer').prop("disabled",false)
                          $('#selectStatus_refer').prop("disabled",false)
                          $("#ModalUpdateTimesheet").find('.modal-footer').show()
                        // }
                      }else{
                        var momentDate = moment(start); // Replace with your own moment date
                        // Get today's date
                        var today = moment();
                        // Compare the date components
                        var isSameDateToday = momentDate.isSame(today, 'day');
                        // if (isSameDateToday) {
                        //   $('#selectType_refer').prop("disabled",false)
                        //   $('#selectLead_refer').prop("disabled",false)
                        //   $('#selectTask_refer').prop("disabled",false)
                        //   $('#selectPhase_refer').prop("disabled",false)
                        //   $('#selectLevel_refer').prop("disabled",false)
                        //   $('#textareaActivity_refer').prop("disabled",true)
                        //   $('#selectDuration_refer').prop("disabled",false)
                        //   $('#selectStatus_refer').prop("disabled",false)
                        //   $("#ModalUpdateTimesheet").find('.modal-footer').attr('style','display:none!important')
                        // }else{
                          $('#selectType_refer').prop("disabled",false)
                          $('#selectLead_refer').prop("disabled",false)
                          $('#selectTask_refer').prop("disabled",false)
                          $('#selectPhase_refer').prop("disabled",false)
                          $('#selectLevel_refer').prop("disabled",false)
                          $('#textareaActivity_refer').prop("disabled",true)
                          $('#selectDuration_refer').prop("disabled",false)
                          $('#selectStatus_refer').prop("disabled",false)
                          $("#ModalUpdateTimesheet").find('.modal-footer').show()
                        // }
                      }  
                    }else{
                      eventUpdateTimesheet(calEvent)
                    }
                  }
                } else {
                  eventUpdateTimesheet(calEvent)
                }
              // Handle the selection event for allowed dates
            } else {
              if (disabledDates.some(function(disabledDate) {
                return calEvent.start.isSame(disabledDate, 'day');
              })) {
                if (calEvent.schedule == "Planned" || calEvent.schedule == "Unplanned") {
                  eventUpdateTimesheet(calEvent)
                }else{
                  $("#ModalInfo").modal("show")
                  if (calEvent.remarks == 'Sick' || calEvent.remarks == 'Permit') {
                    $("#btn_delete_permit").show()
                    $("#btn_delete_permit").attr("onclick","deletePermit('"+ calEvent.id +"')")
                  }else{
                    $("#btn_delete_permit").attr('style','display:none!important')
                  }
                  $(".modal-title").text("Information")
                  $("#tbInfo").empty()
                  var append = ""
                  append = append + '<tr>'
                  append = append + '  <th width="100px">Date</th>'
                  append = append + '  <td>'+ moment(calEvent.start).format('YYYY-MM-DD')  +'</td>'
                  append = append + '</tr>'
                  append = append + '<tr>'
                  append = append + '  <th width="100px">Activity</th>'
                  append = append + '  <td>'+ calEvent.activity  +'</td>'
                  append = append + '</tr>'

                  $("#tbInfo").append(append)
                }
              }else{
                if (calEvent.originalStartDate > moment().format('YYYY-MM-DD')) {
                  $('#daterange-timesheet').data('daterangepicker').setStartDate(moment(calEvent.originalStartDate).format('MM/DD/YYYY'));
                  $('#daterange-timesheet').data('daterangepicker').setEndDate(moment(calEvent.originalStartDate).format('MM/DD/YYYY'));
                  eventUpdateTimesheet(calEvent)
                }else{
                  $("#ModalUpdateTimesheet").modal("show")
                  $("#ModalUpdateTimesheet").find('.modal-footer').find(".btn-primary").removeClass("btn-primary").addClass("btn-warning").text('Update')
                  $("#ModalUpdateTimesheet").find('.modal-footer').attr('style','display:none!important')

                  setSchedule(calEvent.start)
                  setDuration("refer")
                  setStatus("refer")
                  setType("refer")
                  setTask("refer")
                  setPhase("refer")
                  setLevel("refer")

                  //cek kenapa task dan phase munculnya lama untuk data select2!!
                  $("#id_activity").val(calEvent.id)
                  $('#selectSchedule').prop("disabled",true)
                  $('#textareaActivity_refer').val(calEvent.title).trigger('change') 
                  $('#selectLevel_refer').val(calEvent.level).trigger('change')
                  $('#selectTask_refer').val(calEvent.task).trigger('change')
                  $('#selectPhase_refer').val(calEvent.phase).trigger('change')
                  $('#selectDuration_refer').val(calEvent.duration).trigger('change')
                  $('#selectStatus_refer').val(calEvent.status).trigger('change')
                  $('#selectType_refer').val(calEvent.type).trigger('change')

                  $('#selectSchedule').val('Planned').trigger('change')
                  $('#daterange-input').prop("disabled",true)    

                  $('#selectType_refer').prop("disabled",true)
                  $('#selectLead_refer').prop("disabled",true)
                  $('#selectTask_refer').prop("disabled",true)
                  $('#selectPhase_refer').prop("disabled",true)
                  $('#selectLevel_refer').prop("disabled",true)
                  $('#textareaActivity_refer').prop("disabled",true)
                  $('#selectDuration_refer').prop("disabled",true)
                  $('#selectStatus_refer').prop("disabled",true)
                }
              }
            }
        },
        eventRender: function (event, element, view) {  
          // Change event color
          if (event.remarks != null) {
            element.css('color', '#FFFFFF');
            preventDayClick = false
            if (event.remarks == 'Sick' || event.remarks == 'Permit' || event.remarks == 'Leaving Permit') {
              element.css('background-color', '#605ca8'); // Set background color
              element.css('border-color', '#605ca8');
            }else{
              element.css('background-color', '#f94877'); // Set background color
              element.css('border-color', '#f94877');
            }
          }else if(event.refer == 'gcal'){
            element.css('background-color', 'white'); // Set background color
            element.css('border-color', '#00c0ef');
            element.css('color', '#00c0ef');
          }else{
            element.find('.fc-time').remove();

            if (event.schedule == "Unplanned") {
              element.find('.fc-title').html('<span class="badge" style="color:red;background-color:white">U</span> ' + event.title);
            }else{
              element.find('.fc-title').html('<span class="badge" style="color:green;background-color:white">P</span> ' + event.title);
            }
            element.css('color', '#FFFFFF');
            if (event.status == 'Done') {
              element.css('background-color', '#00a65a'); // Set background color
              element.css('border-color', '#00a65a')
            }else if (event.status == 'Cancel') {
              element.css('background-color', '#f56954'); // Set background color
              element.css('border-color', '#f56954')
            }else if (event.status == 'Reschedule') {
              element.css('background-color', '#00c0ef'); // Set background color
              element.css('border-color', '#00c0ef')
            }else if (event.status == 'Undone') {
              element.css('background-color', '#f39c12'); // Set background color
              element.css('border-color', '#f39c12')
            }
          }
          
           // Set text color
        },
        dayRender: function (date, cell) {
          var formattedDate = date.format('YYYY-MM-DD');

          if (eventRenderDataPlanned[formattedDate] != undefined) {
            var valuePlanned = 0, valueUnplanned = 0, deviation = 0
            if (isNaN(eventRenderDataPlanned[formattedDate])) {
              valuePlanned = valuePlanned
            }else{
              valuePlanned = eventRenderDataPlanned[formattedDate]
            }

            if (isNaN(eventRenderDataUnplanned[formattedDate])) {
              valueUnplanned = valueUnplanned
            }else{
              valueUnplanned = eventRenderDataUnplanned[formattedDate]
            }

            if (isNaN(eventRenderDeviation[formattedDate])) {
              deviation = deviation
            }else{
              deviation = 1 - eventRenderDeviation[formattedDate]
            }

            var customButton = $(!window.mobilecheck() ? '<span class="label" style="color:red;background-color:white;border:solid 1px red">U '+ valueUnplanned.toFixed(2) +'</span> <span class="label" style="color:green;background-color:white;border:solid 1px green">P '+ valuePlanned.toFixed(2)+'</span>' + ' <span class="label" style="color:orange;background-color:white;border:solid 1px orange">D '+ deviation.toFixed(2)+'</span>' : '<span class="label" style="color:red;background-color:white;border:solid 1px red">U '+ valueUnplanned.toFixed(2) +'</span><br><span class="label" style="color:green;background-color:white;border:solid 1px green">P '+ valuePlanned.toFixed(2)+'</span><br>'+ ' <span class="label" style="color:orange;background-color:white;border:solid 1px orange">D '+ deviation.toFixed(2)+'</span>');
          }
         
          if (eventRenderEmoji[formattedDate]) {
            var spanEmoji = $('<span class="spanEmoji '+ eventRenderEmoji[formattedDate] +'" role="img" aria-label="angry"></span>');
          }

          $(cell).append(customButton);
          $(cell).append(spanEmoji);
          // $(cell).append(emojiElement);
          var currentDate = moment.utc(date);

          // // Your condition to determine whether dayClick should be prevented
          if (disabledDates.some(function(disableDate) {            
              return currentDate.isSame(disableDate, 'day');
          })) {
              cell.css('background-color', '#EEE');
          }
          if (datesInWeek.some(function(dates) {            
              return currentDate.isSame(moment(dates).endOf('day'), 'day');
          })) {
            cell.addClass('date-range-highlight');
          }
          // if (datesInWeek.includes(date)) {
          //   cell.addClass('date-range-highlight');
          // }

          // var todays = new Date()
          // // var today = moment().startOf('day'); // Get the current date
          // // var cellDate = moment(date).startOf('day'); // Get the date being rendered

          // if (cellDate.isAfter(todays)) {
          //   cell.css('background-color', '#EEE'); // Set background color for days after today
          //   cell.addClass('disabled-day'); // Add a class to indicate disabled days
          // }
        },
        eventDataTransform: function(event) {
          if (moment(event.start).format('YYYY-MM-DD') > moment(datesInWeek[0]).format('YYYY-MM-DD')) {
            if (event.schedule == 'Unplanned') {
              event.editable = true;
            }else{
              if (event.remarks != null || event.refer == 'gcal' || event.status == 'Done') {
                event.editable = false;
              }else{
                event.editable = true;
              }
            }
          }else{
            event.editable = false
          }

          return event;
        },
        eventDrop: function(event, delta, revertFunc) {
          var droppedEvent = event.start;
          var originalStartDate = event.originalStartDate;
          if (moment(datesInWeek[0]).format('YYYY-MM-DD') > moment(event.start).format('YYYY-MM-DD')) {
            Swal.fire({
              icon: 'warning',
              title: 'Sorry this date is out of lock duration!',
              text: 'Click Ok to reload page',
            }).then((result,data) => {
              if (result.value) {
                revertFunc();
              }
            })
          }else{
            if(event.schedule == "Unplanned"){
              if (event.start > moment()) {
                Swal.fire({
                  icon: 'warning',
                  title: 'Sorry unplanned schedule just move on back date!',
                  text: 'Click Ok to reload page',
                }).then((result,data) => {
                  if (result.value) {
                    revertFunc();
                  }
                })
              }else{
                formData = new FormData
                formData.append("_token","{{ csrf_token() }}")
                formData.append("dates",moment(event.start).format('YYYY-MM-DD'))
                formData.append("id",event.id)    

                createPost(swalFireCustom="",formData,swalSuccess="",url="/timesheet/updateDateEvent",postParam="update_dates",modalName="")
              }
            }else{
              if (moment(event.start).format('YYYY-MM-DD') < moment(event.originalStartDate).format('YYYY-MM-DD')) {
                if (moment(event.start).format('YYYY-MM-DD') <= moment().format('YYYY-MM-DD')) {
                  Swal.fire({
                    icon: 'warning',
                    title: 'Sorry planned schedule just move on forward date!',
                    text: 'Click Ok to reload page',
                  }).then((result,data) => {
                    if (result.value) {
                      revertFunc()
                    }
                  })
                }else{
                  formData = new FormData
                  formData.append("_token","{{ csrf_token() }}")
                  formData.append("dates",moment(event.start).format('YYYY-MM-DD'))
                  formData.append("id",event.id)      

                  createPost(swalFireCustom="",formData,swalSuccess="",url="/timesheet/updateDateEvent",postParam="update_dates",modalName="")
                }
              }else{
                formData = new FormData
                formData.append("_token","{{ csrf_token() }}")
                formData.append("dates",moment(event.start).format('YYYY-MM-DD'))
                formData.append("id",event.id)      

                createPost(swalFireCustom="",formData,swalSuccess="",url="/timesheet/updateDateEvent",postParam="update_dates",modalName="")
              }
            }
          }
        },
        viewRender: function(view, element) {
          var savedScrollPosition = localStorage.getItem("savedScrollPosition") 
          if (savedScrollPosition !== null) {
            var calendar = $("#calendar")
            calendar.find('.fc-scroller').scrollTop(savedScrollPosition);
            savedScrollPosition = null;
          }
        }
      })
      
      if (valDate) {
        if (calendarElement.data("fullCalendar")) {
          $("#calendar").fullCalendar('gotoDate',valDate)
        }

        let date = moment(valDate).format("YYYY-MM-DD")

        showAlertRemaining(date)
      }else{
        showAlertRemaining(moment.utc(new Date(), 'YYYY-MM-DD').format('YYYY-MM-DD'))
      }

      $('.fc-prev-button').on('click', function() {
        var currentView = calendar.fullCalendar('getView');
        var startDate = currentView.intervalStart;
        
        var month = startDate.format('MMMM');
        var year = startDate.format('YYYY');

        $($("#alertForRemaining").find("span")[1]).text(". . .")
        loadData(startDate.format('YYYY-MM-DD'))
      });

      $('.fc-next-button').on('click', function() {
        var currentView = calendar.fullCalendar('getView');
        var startDate = currentView.intervalStart;
        
        var month = startDate.format('MMMM');
        var year = startDate.format('YYYY');

        $($("#alertForRemaining").find("span")[1]).text(". . .")
        loadData(startDate.format('YYYY-MM-DD'))
      });

      var view = calendar.fullCalendar('getView');
      var currentTimeZone = view.options.timezone;

      $('#calendar').fullCalendar('addEventSource', events)
      $('#calendar').fullCalendar('rerenderEvents')
  
      if (window.location.href.split("/")[4].split("?")[1] != undefined) {
         if (window.location.href.split("/")[4].split("?")[1].split("=")[0] == "id") {
            $("#ModalAddTimesheet").modal("show")
            setHoliday(moment(window.location.href.split("/")[4].split("?")[1].split("=")[2]),moment(window.location.href.split("/")[4].split("?")[1].split("=")[2]),checkDate)
            eventUpdateTimesheet(calEvent="",id=window.location.href.split("/")[4].split("?")[1].split("=")[1].split("&")[0])
        }
      }
    } 

    function openModalAddTimesheet(id,title,schedule,type,pid,level,duration,status,start,end,refer,task,phase,status_pid){
      $("#ModalAddTimesheet").modal('show')
      if ($.fn.select2 !== undefined) {
        setHoliday()
        setSchedule(start)
        setDuration()
        setLevel()
        setStatus()
        setType()
        setTask()
        setPhase()
        var isSelect2Initialized = $("#selectSchedule").hasClass("select2-hidden-accessible")
        if (isSelect2Initialized == false) {
        }
      }
      
      $('#daterange-input').daterangepicker().data('daterangepicker').setStartDate(moment(start, 'YYYY-MM-DD'))
      if (refer) {
        $('#daterange-input').daterangepicker().data('daterangepicker').setEndDate(moment(end, 'YYYY-MM-DD'))
      }else{
        $('#daterange-input').daterangepicker().data('daterangepicker').setEndDate(moment(start, 'YYYY-MM-DD'))
      }

      if (refer) {
        $("#id_activity").val(id)
        $('#selectSchedule').prop("disabled",true)
        $('#selectSchedule').val('Planned').trigger('change')
        $('#daterange-input').prop("disabled",true)    
        $('#textareaActivity').val(title).trigger('change') 

        if(nik != "{{Auth::User()->nik}}"){
          //spv/manager
          var momentDate = moment(start); // Replace with your own moment date
          // Get today's date
          var today = moment();
          var isSameDateToday = momentDate.isSame(today, 'day');
          if (isSameDateToday) {
            $('#selectType').prop("disabled",true)
            $('#selectLead').prop("disabled",true)
            $('#selectTask').prop("disabled",true)
            $('#selectPhase').prop("disabled",true)
            $('#selectLevel').prop("disabled",true)
            $('#textareaActivity').prop("disabled",true)
            $('#selectDuration').prop("disabled",true)
            $('#selectStatus').prop("disabled",true)
            $("#ModalUpdateTimesheet").find('.modal-footer').attr('style','display:none!important')
          }else{
            $('#selectType').prop("disabled",false)
            $('#selectLead').prop("disabled",false)
            $('#selectTask').prop("disabled",false)
            $('#selectPhase').prop("disabled",false)
            $('#selectLevel').prop("disabled",false)
            $('#textareaActivity').prop("disabled",false)
            $('#selectDuration').prop("disabled",false)
            $('#selectStatus').prop("disabled",false)
            $("#ModalUpdateTimesheet").find('.modal-footer').attr('style','display:none!important')
          }
        }else{
          var momentDate = moment(start); // Replace with your own moment date
          // Get today's date
          var today = moment();
          // Compare the date components
          var isSameDateToday = momentDate.isSame(today, 'day');
          $('#selectType').prop("disabled",false)
          $('#selectLead').prop("disabled",false)
          $('#selectTask').prop("disabled",false)
          $('#selectPhase').prop("disabled",false)
          $('#selectLevel').prop("disabled",false)
          $('#textareaActivity').prop("disabled",false)
          $('#selectDuration').prop("disabled",false)
          $('#selectStatus').prop("disabled",false)
          $("#ModalUpdateTimesheet").find('.modal-footer').show()
        }                         
      }else{
        $('#selectSchedule').val(schedule).trigger('change')
        $('#selectSchedule').prop("disabled",true)
        $('#daterange-input').prop("disabled",true)

        //supervisor
        if("{{App\RoleUser::where("user_id",Auth::User()->nik)->join("roles","roles.id","=","role_user.role_id")->where('roles.name','like','%SPV')->exists()}}" || "{{App\RoleUser::where("user_id",Auth::User()->nik)->join("roles","roles.id","=","role_user.role_id")->where('roles.name','like','%MANAGER')->exists()}}"){
          $('#selectType').prop("disabled",false)
          $('#selectLead').prop("disabled",false)
          $('#selectTask').prop("disabled",false)
          $('#selectPhase').prop("disabled",false)
          $('#selectLevel').prop("disabled",false)
          $('#textareaActivity').prop("disabled",false)
          $('#selectDuration').prop("disabled",false)
          $('#selectStatus').prop("disabled",false)  
          $("#ModalAddTimesheet").find('.modal-footer').show()
        }else{
          var momentDate = moment(start); // Replace with your own moment date
          // Get today's date
          var today = moment();
          // Compare the date components
          var isSameDateToday = momentDate.isSame(today, 'day');
          if (isSameDateToday) {
            $('#selectDuration').prop("disabled",false)
            $('#selectStatus').prop("disabled",false)
            $("#ModalAddTimesheet").find('.modal-footer').show()
          }else{
            //awalnya untuk staff di hide, tapi sesuai banyaknya permintaan jadi diaktifkan
            // $("#ModalAddTimesheet").find('.modal-footer').attr('style','display:none!important')
            $("#ModalAddTimesheet").find('.modal-footer').show()
            $('#selectDuration').prop("disabled",true)
            $('#selectStatus').prop("disabled",true)
          }
        }

        $("#id_activity").val(id)
        //staff
        $('#selectType').prop("disabled",false)
        $('#selectLead').prop("disabled",false)
        $('#selectTask').prop("disabled",false)
        $('#selectPhase').prop("disabled",false)
        $('#selectLevel').prop("disabled",false)
        $('#textareaActivity').prop("disabled",false)
        $('#selectDuration').prop("disabled",false)
        $('#selectStatus').prop("disabled",false) 

        $('#selectType').val(type).trigger('change')
        if (type == "Project") {
          if (status_pid == 'true') {
            setPid(pid)
          }else{
            $("#divPid").show()
            $("#inputPid").val(pid)
          }
        }else if(type == "Approach"){
          setLeadId(pid)
        }
        $('#selectLevel').val(level).trigger('change')
        $('#textareaActivity').val(title).trigger('change')
        $('#selectDuration').val(duration).trigger('change')
        $('#selectStatus').val(status).trigger('change')
        $('#selectTask').val(task).trigger('change')
        $('#selectPhase').val(phase).trigger('change')
      }
    }

    function addPermit(){
      $("#ModalPermit").modal('show')
      $(".modal-title").text('Add Permit')

      // $("#inputPermitDate").daterangepicker({
      //   maxDate:currentDate
      // })
      $("#inputPermitDate").flatpickr({
        disable: [
            function(date) {
                // Menonaktifkan hari Minggu (0) dan Sabtu (6)
                return (date.getDay() === 0 || date.getDay() === 6);
            }
        ],
        maxDate: currentDate, // Mengatur batas akhir ke tanggal saat ini
        mode: "multiple", // Memungkinkan pemilihan beberapa tanggal
        dateFormat: "Y-m-d" // Format tanggal yang umum digunakan
      });

      $("#selectPermit").select2({
        placeholder:"Select Permit",
        data: [{
            id: 'Sick',
            text: 'Sick'
        },
        {
            id: 'Permit',
            text: 'Permit'
        }],
        dropdownParent: $("#ModalPermit")
      })
    }

    function deletePermit(id){
      swalFireCustom = {
        title: 'Are you sure?',
        text: "Delete Permit this User!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
      }

      swalSuccess = {
          icon: 'success',
          title: 'Delete Permit Successfully!',
          text: 'Click Ok to reload page',
      } 

      formData = new FormData
      formData.append("_token","{{ csrf_token() }}")
      formData.append("id",id)        

      var postParam = 'delete_permit'
      var modalName = "ModalInfo"

      createPost(swalFireCustom,formData,swalSuccess,url="/timesheet/deletePermit",postParam,modalName)
    }

    function storePermit(modalName){
      if ($("#inputPermitDate").val() == "") {
        $("#inputPermitDate").closest("div").find("span").show()
        $("#inputPermitDate").closest("div").addClass("has-error")
      }else if($("#selectPermit").val() == ""){
        $("#selectPermit").closest("div").find("span").show()
        $("#selectPermit").closest("div").addClass("has-error")
      }else if($("#textareaActivityPermit").val() == ""){
        $("#textareaActivityPermit").closest("div").find("span").show()
        $("#textareaActivityPermit").closest("div").addClass("has-error")
      }else{
        // var dateRangePicker = $('#inputPermitDate').data('daterangepicker');
        // var inputPermitStartDate = dateRangePicker.startDate.format('YYYY-MM-DD');
        // var inputPermitEndDate = dateRangePicker.endDate.format('YYYY-MM-DD');
        datePermit = []
        datePermit.push($("#inputPermitDate").val().split(','))
        formData = new FormData
        formData.append("_token","{{ csrf_token() }}")
        // formData.append("inputPermitStartDate",inputPermitStartDate)
        // formData.append("inputPermitEndDate",inputPermitEndDate)
        formData.append("nik",nik)        
        formData.append("inputDatePermit",JSON.stringify($("#inputPermitDate").val().split(',')))
        formData.append("selectPermit",$("#selectPermit").val())        
        formData.append("textareaActivityPermit",$("#textareaActivityPermit").val())   

        swalFireCustom = {
          title: 'Are you sure?',
          text: "Save this Permit Activity!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No',
        }

        swalSuccess = {
            icon: 'success',
            title: 'Create Timesheet for Permit Successfully!',
            text: 'Click Ok to reload page',
        } 

        var postParam = 'permit'
        createPost(swalFireCustom,formData,swalSuccess,url="/timesheet/storePermit",postParam,modalName)
      }
    }

    function showHelp(params){
      if (params == 'level') {
        $("#ModalAddTimesheet").find('.modal-footer').next("div").attr('style','display:none!important')

        var appendHelp = ""
        appendHelp = appendHelp + '<div class="alert alert-secondary alert-dismissible" style="margin:15px">'
          appendHelp = appendHelp + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>'
            appendHelp = appendHelp + '<div class="form-group">'
              appendHelp = appendHelp + '<label><i class="bx bx-info-square"></i> Help</label>'
              appendHelp = appendHelp + '<table class="table">'
                appendHelp = appendHelp + '<tr>'
                  appendHelp = appendHelp + '<th width="20" class="text-bg-primary">' + 'A'
                  appendHelp = appendHelp + '</th>'
                  appendHelp = appendHelp + '<td>' + 'Pekerjaan/aktivitas yang bersifat kritikal,rumit, atau pertama kali dilakukan'
                  appendHelp = appendHelp + '</td>'
                appendHelp = appendHelp + '</tr>'
                appendHelp = appendHelp + '<tr>'
                  appendHelp = appendHelp + '<th width="20" class="text-bg-primary">' + 'B'
                  appendHelp = appendHelp + '</th>'
                  appendHelp = appendHelp + '<td>' + 'Pekerjaan/aktivitas dengan level sulit, namun sudah pernah dilakukan sebelumnya'
                  appendHelp = appendHelp + '</td>'
                appendHelp = appendHelp + '</tr>'
                appendHelp = appendHelp + '<tr>'
                  appendHelp = appendHelp + '<th width="20" class="text-bg-primary">' + 'C'
                  appendHelp = appendHelp + '</th>'
                  appendHelp = appendHelp + '<td>' + 'Pekerjaan/aktivitas yang sudah sering dilakukan'
                  appendHelp = appendHelp + '</td>'
                appendHelp = appendHelp + '</tr>'
                appendHelp = appendHelp + '<tr>'
                  appendHelp = appendHelp + '<th width="20" class="text-bg-primary">' + 'D'
                  appendHelp = appendHelp + '</th>'
                  appendHelp = appendHelp + '<td>' + 'Pekerjaan/aktivitas yang setiap hari dilakukan'
                  appendHelp = appendHelp + '</td>'
                appendHelp = appendHelp + '</tr>'
                appendHelp = appendHelp + '<tr>'
                  appendHelp = appendHelp + '<th width="20" class="text-bg-primary">' + 'E'
                  appendHelp = appendHelp + '</th>'
                  appendHelp = appendHelp + '<td>' + 'Pekerjaan/aktivitas yang membutuhkan usaha sangat sedikit / effortless'
                  appendHelp = appendHelp + '</td>'
                appendHelp = appendHelp + '</tr>'
              appendHelp = appendHelp + '</table>'
            appendHelp = appendHelp + '</div>'
        appendHelp = appendHelp + '</div>'

        $("#ModalAddTimesheet").find('.modal-footer').after(appendHelp)
      }else {
        $("#ModalAddTimesheet").find('.modal-footer').next("div").attr('style','display:none!important')

        var appendHelp = ""
        $.ajax({
          type:"GET",
          url:"{{url('/timesheet/getTaskPhaseByDivisionForTable')}}",
          success:function(result){
            
             appendHelp = appendHelp + '<div class="alert alert-secondary alert-dismissible" style="margin:15px">'
                appendHelp = appendHelp + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>'
                  appendHelp = appendHelp + '<div class="form-group">'
                    appendHelp = appendHelp + '<label><i class="bx bx-info-square"></i> Help</label>'
                    appendHelp = appendHelp + '<table class="table">'
                    $.each(result,function(index,values){
                        if (index.toLowerCase() == params) {
                          $.each(values,function(idx,value){
                            appendHelp = appendHelp + '<tr>'
                              appendHelp = appendHelp + '<th width="20" class="text-bg-primary">' + value.title
                              appendHelp = appendHelp + '</th>'
                              appendHelp = appendHelp + '<td>' + value.description
                              appendHelp = appendHelp + '</td>'
                            appendHelp = appendHelp + '</tr>'
                          })
                        }
                    })
                    appendHelp = appendHelp + '</table>'
                        appendHelp = appendHelp + '</div>'
                    appendHelp = appendHelp + '</div>'
            $("#ModalAddTimesheet").find('.modal-footer').after(appendHelp)
          }
        })
      }
    }

    function setDuration(idValue){
      var arrDuration = []
      const range = Array.from({ length: 1445 });
      // Loop through the array using forEach
      range.forEach((_, index) => {
        if (index % 5 === 0 && index != 0 || index % 5 === 0 && index == 1440) {
          // Action to perform on every multiple of 5
          if (index % 60 == 0) {
             arrDuration.push({id:index,text:index+" menit ("+ Math.floor(index/60) +" Jam)"})
          }else{
            if (index % 15 == 0) {
              if (index > 60) {
                arrDuration.push({id:index,text:index+" menit ("+ Math.floor(index/60) +" Jam "+ index % 60 +" Menit)"})
              }else{
                arrDuration.push({id:index,text:index+" menit"})
              }
            }else{
              arrDuration.push({id:index,text:index+" menit"})
            }
          }
        }
      });
      if(idValue === 'refer'){
        dropdownParent = $("#ModalUpdateTimesheet .modal-body")
      }else{
        dropdownParent = $("#ModalAddTimesheet .modal-body")
      }
      $("#selectDuration_"+idValue).select2({
          placeholder:"Select Duration",
          data:arrDuration,
          // dropdownParent: $("#fieldset_"+idValue)
          dropdownParent:dropdownParent
      })
    }

    function setLeadId(pid,idValue){
      if ($("#selectLead_"+idValue).data('select2')) {
        // Select2 is initialized, so destroy it
        $("#selectLead_"+idValue).select2('destroy');
        $("#selectLead_"+idValue).empty()
        // Set the placeholder attribute to the desired value
        $("#selectLead_"+idValue).attr('placeholder','Select Lead Id')
      }
      $.ajax({
        type:"GET",
        url:"{{url('/timesheet/getLeadId')}}",
        success:function(result){
          function isSelect2Loaded() {
            if(idValue === 'refer'){
              dropdownParent = $("#ModalUpdateTimesheet .modal-body")
            }else{
              dropdownParent = $("#ModalAddTimesheet .modal-body")
            }
            var Select2 = $("#selectLead_"+idValue).select2({
              placeholder:"Select Lead Id",
              data:result,
              // dropdownParent: $("#fieldset_"+idValue)
              dropdownParent:dropdownParent
            })

            return typeof Select2 !== 'undefined';
          }

          $(document).ready(function() {
              if (isSelect2Loaded()) {
                  // Select2 script has been loaded
                  // You can proceed with using Select2
                if(idValue === 'refer'){
                  dropdownParent = $("#ModalUpdateTimesheet .modal-body")
                }else{
                  dropdownParent = $("#ModalAddTimesheet .modal-body")
                }
                  $("#selectLead_"+idValue).select2({
                    placeholder:"Select Lead Id",
                    data:result,
                    // dropdownParent: $("#fieldset_"+idValue)
                    dropdownParent:dropdownParent
                  })

                  if (pid != undefined) {
                    $("#selectLead_"+idValue).val(pid).trigger("change")
                  }
              } else {
                  console.error('Select2 script is not loaded.');
              }
          });          
        }
      })
    }

    function setPid(pid,idValue){
      var pid = pid
      var idValue = idValue

      $.ajax({
        type:"GET",
        url:"{{url('/timesheet/getPidByPic')}}",
        success:function(result){
          if (result[0] == 'Alert') {
            $("#selectLead_"+idValue).closest("div").find("span").show()
            $("#selectLead_"+idValue).closest("div").addClass("has-error")
            $("#selectLead_"+idValue).closest("div").find(".invalid-feedback").text(result[1]) 
          }else{
            if ($("#selectLead_"+idValue).data('select2')) {
              $("#selectLead_"+idValue).select2('destroy');
              $("#selectLead_"+idValue).empty()
              $("#selectLead_"+idValue).attr('placeholder','Select Project Id')
            }

            function isSelect2Loaded() {      
              var Select2 = $("#selectLead_"+idValue).select2({
                placeholder:"Select Project Id",
                data:result,
                dropdownParent: $("#fieldset_"+idValue)
              })

              return typeof Select2 !== 'undefined';
            }

            $(document).ready(function() {
                if (isSelect2Loaded()) {
                  if(idValue === 'refer'){
                    dropdownParent = $("#ModalUpdateTimesheet .modal-body")
                  }else{
                    dropdownParent = $("#ModalAddTimesheet .modal-body")
                  }
                    // Select2 script has been loaded
                    // You can proceed with using Select2
                    $("#selectLead_"+idValue).select2({
                      placeholder:"Select Project Id",
                      data:result,
                      // dropdownParent: $("#fieldset_"+idValue)
                      dropdownParent:dropdownParent
                    })

                    if (pid != undefined) {
                      $("#selectLead_"+idValue).val(pid).trigger("change")
                    }
                } else {
                    console.error('Select2 script is not loaded.');
                }
            });


          }
        }
      })
    }

    function setTask(idValue,value){
      $.ajax({
        type:"GET",
        url:"{{url('/timesheet/getTaskByDivision')}}",
        success:function(result){
          if(idValue === 'refer'){
            dropdownParent = $("#ModalUpdateTimesheet .modal-body")
          }else{
            dropdownParent = $("#ModalAddTimesheet .modal-body")
          }
          var selectTask =  $("#selectTask_"+idValue).select2({
              placeholder:"Select Task",
              data:result,
              // dropdownParent: $("#fieldset_"+idValue)
              dropdownParent:dropdownParent
          })

          if (value) {
            $("#selectTask_"+idValue).val(value).trigger("change")    
          }    
        }
      })
      
    }

    function setPhase(idValue,value){
      $.ajax({
        type:"GET",
        url:"{{url('/timesheet/getPhaseByDivision')}}",
        success:function(result){
          if(idValue === 'refer'){
            dropdownParent = $("#ModalUpdateTimesheet .modal-body")
          }else{
            dropdownParent = $("#ModalAddTimesheet .modal-body")
          }
          var selectPhase =  $("#selectPhase_"+idValue).select2({
            placeholder:"Select Phase",
            data:result,
            // dropdownParent: $("#fieldset_"+idValue)
            dropdownParent:dropdownParent
          })

          if (value) {
            $("#selectPhase_"+idValue).val(value).trigger("change")    
          }
        }
      })
    }

    function setLevel(idValue){
      if(idValue === 'refer'){
        dropdownParent = $("#ModalUpdateTimesheet .modal-body")
      }else{
        dropdownParent = $("#ModalAddTimesheet .modal-body")
      }
      $("#selectLevel_"+idValue).select2({
        placeholder:"Select Level",
        data:[
          {
            id:"A",
            text:"A"
          },
          {
            id:"B",
            text:"B"
          },
          {
            id:"C",
            text:"C"
          },
          {
            id:"D",
            text:"D"
          },
          {
            id:"E",
            text:"E"
          },
        ],
        // dropdownParent: $("#fieldset_"+idValue)
        dropdownParent:dropdownParent
      })
    }

    function setStatus(idValue){
      if(idValue === 'refer'){
        dropdownParent = $("#ModalUpdateTimesheet .modal-body")
      }else{
        dropdownParent = $("#ModalAddTimesheet .modal-body")
      }
      $("#selectStatus_"+idValue).select2({
        placeholder:"Select Status",
        data:[
          {
            id:"Done",
            text:"Done"
          },
          {
            id:"Cancel",
            text:"Cancel"
          },
          {
            id:"Reschedule",
            text:"Reschedule"
          },
          {
            id:"Undone",
            text:"Not-Done"
          },
        ],
        // dropdownParent: $("#fieldset_"+idValue)
        dropdownParent:dropdownParent
      })
    }

    function setType(idValue){
      if(idValue === 'refer'){
        dropdownParent = $("#ModalUpdateTimesheet .modal-body")
      }else{
        dropdownParent = $("#ModalAddTimesheet .modal-body")
      }
      $("#selectType_"+idValue).select2({
        placeholder:"Select Type",
        data: [{
            id: 'Project',
            text: 'Project'
        },
        {
            id: 'Internal',
            text: 'Internal'
        },{
            id: 'Approach',
            text: 'Approach'
        }],
        // dropdownParent: $("#fieldset_"+idValue)
        dropdownParent: dropdownParent
      }).on('change', function() {
        var selectedOption = $(this).val();
        // Perform action based on the selected option
        if (selectedOption === 'Project') {
          $("#idAddPid_"+idValue).attr("onclick","clickPIDAdjustment("+ idValue +")")
          $("#idAddPid_"+idValue).css("cursor","pointer")
          setPid("",idValue)
        } else if (selectedOption === 'Internal') {
          $("#selectLead_"+idValue).val(null)
          if ($("#selectLead_"+idValue).data("select2")) {
            $("#selectLead_"+idValue).empty()
            $("#selectLead_"+idValue).select2("destroy")
          }
          $("#selectLead_"+idValue).next().attr('style','display:none!important')
          $("#selectLead_"+idValue).closest("div").removeClass("has-error")
          $("#idAddPid_"+idValue).removeAttr("onclick","clickPIDAdjustment("+ idValue +")")
          $("#idAddPid_"+idValue).css("cursor","not-allowed")

        } else if (selectedOption === 'Approach') {
          setLeadId("",idValue)
          $("#idAddPid_"+idValue).removeAttr("onclick","")
          $("#idAddPid_"+idValue).css("cursor","not-allowed")
        }
      })
    }

    setHoliday()
    function setHoliday(start,end,checkDate){
      var disabledDates = [], disDate = ''
      // $.ajax({
      //   type:"GET",
      //   url:"{{url('timesheet/getHoliday')}}",
      //   success:function(result){
      //     $.each(result,function (idx,value) {
      //       disabledDates.push(value.start_date)
      //     })
      //     return disDate = disabledDates
      //   }
      // })

      const apiKey = '{{env("GOOGLE_API_KEY_APP")}}';
      const timeMin = new Date(new Date().setFullYear(new Date().getFullYear() - 1)).toISOString(); // 1 year ago
      const timeMax = new Date().toISOString();

      $.ajax({
        url:"https://www.googleapis.com/calendar/v3/calendars/id.indonesian%23holiday@group.v.calendar.google.com/events",
        data: {
          key: apiKey,
          timeMin: timeMin,
          timeMax: timeMax,
          singleEvents: true,
          orderBy: 'startTime'
        },
        success: function(response){
          const events = response.items;
          if (events.length) {
              events.forEach(event => {
                  const start = event.start.dateTime || event.start.date;
                  disabledDates.push(start)

                  // console.log(start + event.summary)
              });
              return disDate = disabledDates
          }
        },
        error: function(error) {
            console.error('Error fetching events:', error);
        }
      })

      function isDateDisabled(date, disabledDate) {
        if (disabledDate.indexOf('/') !== -1) {
          // Date range format: start_date/end_date
          var range = disabledDate.split('/');
          return (date >= range[0] && date <= range[1]);
        } else {
          // Single date format
          return (date === disabledDate);
        }
      }

      $('#daterange-timesheet').daterangepicker({
        startDate: start,
        endDate: end,
        minDate: checkDate,// Prevent closing when clicking outside
        isInvalidDate: function(date) {
          var formattedDate = date.format('YYYY-MM-DD');
          for (var i = 0; i < disDate.length; i++) {
            if (isDateDisabled(formattedDate, disDate[i])) {
              return true;
            }
          }
          return false;
        }
      }).change(function(){
        if ($('#daterange-timesheet').data('daterangepicker')) {
          var range = moment().isBetween($('#daterange-timesheet').data('daterangepicker').startDate, $('#daterange-timesheet').data('daterangepicker').endDate);

          if (range) {
            if (moment($('#daterange-timesheet').data('daterangepicker').endDate).format("YYYY-MM-DD") != moment(moment()).format("YYYY-MM-DD")) {
              Swal.fire(
                'Date is not appropriated!',
                'Select range date with correct schedule type',
                'error'
              ).then(() => {
                var start = moment(moment()).format('MM/DD/YYYY')
                var end = moment(moment()).format('MM/DD/YYYY') 

                $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
                $('#daterange-timesheet').data('daterangepicker').setEndDate(end);
                eventUpdateTimesheet()
              })
            }else {
              $("input[name='scheduleInput']").val("Unplanned")
              $("select[name='selectDuration']").prev("label").after("<span>*</span>")
              $("select[name='selectStatus']").prev("label").after("<span>*</span>")
              $("select[name='selectDuration']").prop("disabled",false)
              $("select[name='selectStatus']").prop("disabled",false)

              Swal.fire({
                title: 'Loading...',
                allowEscapeKey: false,
                allowOutsideClick: false,
                confirmButtonText:'',
                showConfirmButton:false,
                didOpen: () => {
                  // Delayed task using setTimeout
                  setTimeout(() => {
                    // Close the loading indicator
                    var start = moment($('#daterange-timesheet').data('daterangepicker').startDate).format('MM/DD/YYYY')
                    var end = moment($('#daterange-timesheet').data('daterangepicker').endDate).format('MM/DD/YYYY') 

                    $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
                    $('#daterange-timesheet').data('daterangepicker').setEndDate(end);

                    eventUpdateTimesheet();
                    Swal.close();
                  }, 2000); // Delayed execution after 2000ms (2 seconds)
                }
              });
            }
          }else{
            if ($('#daterange-timesheet').data('daterangepicker').startDate > moment()) {
              $("input[name='scheduleInput']").val("Planned")
              $("select[name='selectDuration']").prev("span").remove()
              $("select[name='selectStatus']").prev("span").remove()
              $("select[name='selectDuration']").prop("disabled",true)
              $("select[name='selectStatus']").prop("disabled",true)

              Swal.fire({
                title: 'Loading...',
                allowEscapeKey: false,
                allowOutsideClick: false,
                confirmButtonText:'',
                showConfirmButton:false,
                didOpen: () => {
                  // Delayed task using setTimeout
                  setTimeout(() => {
                    // Close the loading indicator
                    var start = moment($('#daterange-timesheet').data('daterangepicker').startDate).format('MM/DD/YYYY')
                    var end = moment($('#daterange-timesheet').data('daterangepicker').endDate).format('MM/DD/YYYY') 

                    $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
                    $('#daterange-timesheet').data('daterangepicker').setEndDate(end);

                    eventUpdateTimesheet();
                    Swal.close();
                  }, 2000); // Delayed execution after 2000ms (2 seconds)
                }
              });
            }else if ($('#daterange-timesheet').data('daterangepicker').startDate <= moment()) {
              $("input[name='scheduleInput']").val("Unplanned")
              $("select[name='selectDuration']").prev("label").after("<span>*</span>")
              $("select[name='selectStatus']").prev("label").after("<span>*</span>")
              $("select[name='selectDuration']").prop("disabled",false)
              $("select[name='selectStatus']").prop("disabled",false)

              Swal.fire({
                title: 'Loading...',
                allowEscapeKey: false,
                allowOutsideClick: false,
                confirmButtonText:'',
                showConfirmButton:false,
                didOpen: () => {
                  // Delayed task using setTimeout
                  setTimeout(() => {
                    // Close the loading indicator
                    var start = moment($('#daterange-timesheet').data('daterangepicker').startDate).format('MM/DD/YYYY')
                    var end = moment($('#daterange-timesheet').data('daterangepicker').endDate).format('MM/DD/YYYY') 

                    $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
                    $('#daterange-timesheet').data('daterangepicker').setEndDate(end);

                    eventUpdateTimesheet();
                    Swal.close();
                  }, 2000); // Delayed execution after 2000ms (2 seconds)
                }
              });
            }
          }
        }
      })

      // $('#daterange-input').daterangepicker({
      //   isInvalidDate: function(date) {
      //     var formattedDate = date.format('YYYY-MM-DD');
      //     for (var i = 0; i < disDate.length; i++) {
      //       if (isDateDisabled(formattedDate, disDate[i])) {
      //         return true;
      //       }
      //     }
      //     return false;
      //   }
      // })
    } 

    function setSchedule(date,param){
      $("#selectSchedule").select2({
        placeholder:"Select Schedule",
        data: [{
            id: 'Planned',
            text: 'Planned'
        },
        {
            id: 'Unplanned',
            text: 'Unplanned'
        }],
        // dropdownParent: $("#ModalAddTimesheet")
        dropdownParent:$("#ModalAddTimesheet .modal-body")
      }).on('change', function() {
        var selectedOption = $(this).val();
        // Perform action based on the selected option
        if (selectedOption === 'Planned') {
          $("#selectDuration_0").prev("span").remove()
          $("#selectStatus_0").prev("span").remove()
          $("#selectDuration_0").val("").trigger("change")
          $("#selectStatus_0").val("").trigger("change")
          $("#daterange-input").prop("disabled",false)
          if (param == 'add') {
            $('#daterange-input').daterangepicker({
              minDate: tomorrow,
              startDate: tomorrow,
              endDate: tomorrow,
            })
          }else{
            $('#daterange-input').daterangepicker({
              minDate: date,
              startDate: date,
              endDate: date,
            })
          }
          if (date)  {
            // $('#daterange-input').on('apply.daterangepicker', function(ev, picker) {
            //   $(this).data('daterangepicker').minDate = tomorrow; // Update minDate
            //   $(this).data('daterangepicker').startDate = tomorrow;   // Update maxDate
            //   $(this).data('daterangepicker').endDate = tomorrow;   // Update maxDate
            // });
          }
          else{
            
          }

          // function isDateDisabled(date, disabledDate) {
          //   if (disabledDate.indexOf('/') !== -1) {
          //     // Date range format: start_date/end_date
          //     var range = disabledDate.split('/');
          //     return (date >= range[0] && date <= range[1]);
          //   } else {
          //     // Single date format
          //     return (date === disabledDate);
          //   }
          // }
          
        } else if (selectedOption === 'Unplanned') {
          $("select[name='selectDuration']").prev("label").after("<span>*</span>")
          $("select[name='selectStatus']").prev("label").after("<span>*</span>")
          $("#selectDuration").prop("disabled",false)
          $("#selectStatus").prop("disabled",false)
          $("#daterange-input").prop("disabled",true)
          // $('#daterange-input').on('apply.daterangepicker', function(ev, picker) {
          //   $(this).data('daterangepicker').startDate = date;   // Update maxDate
          //   $(this).data('daterangepicker').endDate = date;   // Update maxDate
          // });
          // 
          $('#daterange-input').daterangepicker({
            // startDate: moment().subtract(29, 'days'),
            startDate: date,
            endDate: date,
          })
        }
      });
    }

    function validateInput(val,idValue){
      if ($(val).is("select")) {
          if (val.value != "") {
              $(val).next().next().attr('style','display:none!important')
              $(val).closest("div").removeClass("has-error")
          }
      }else{
        $("#"+val.id).next().attr('style','display:none!important')
        $("#"+val.id).closest("div").removeClass("has-error")
      }
    }

    function saveTimesheet(param){
      if (param == "refer") {
        if ($("#selectSchedule").val() == "") {
          $("#selectSchedule").closest("div").find("span").show()
          $("#selectSchedule").closest("div").addClass("has-error")
        }else if($("#daterange-input").val() == ""){
          $("#daterange-input").closest("div").find("span").show()
          $("#daterange-input").closest("div").addClass("has-error")
        }else if($("#selectType_refer").val() == ""){
          $("#selectType_refer").closest("div").find("span").show()
          $("#selectType_refer").closest("div").addClass("has-error")
        }else if($("#selectType_refer").val() == "Project"){
          // if ($("#selectLead_refer").val() == "") {
          //   $("#selectLead_refer").closest("div").find("span").show()
          //   $("#selectLead_refer").closest("div").addClass("has-error")
          //   // $("#selectLead_refer").closest("div").find("span").text("Please select Project ID!")
          //   $("#selectLead_refer").closest("div").find(".invalid-feedback").text("Please select Project ID!")          
          // }else 
          if($("#textareaActivity_refer").val() == ""){
            $("#textareaActivity_refer").closest("div").find("span").show()
            $("#textareaActivity_refer").closest("div").addClass("has-error")
          }else{
            storeTimesheet(param,"ModalUpdateTimesheet")
          }
        }else if($("#selectType_refer").val() == "Approach"){
          // if ($("#selectLead_refer").val() == "") {
          //   $("#selectLead_refer").closest("div").find("span").show()
          //   $("#selectLead_refer").closest("div").addClass("has-error")
          //   $("#selectLead_refer").closest("div").find(".invalid-feedback").text("Please select Lead ID!")
          // }else 
          if($("#textareaActivity_refer").val() == ""){
            $("#textareaActivity_refer").closest("div").find("span").show()
            $("#textareaActivity_refer").closest("div").addClass("has-error")
          }else{
            storeTimesheet(param,"ModalUpdateTimesheet")
          }
        }else if($("#textareaActivity_refer").val() == ""){
          $("#textareaActivity_refer").closest("div").find("span").show()
          $("#textareaActivity_refer").closest("div").addClass("has-error")
        }else{
          if ($("#selectSchedule").val() == 'Planned') {
            if ($("#selectDuration_refer").val() == '') {
              $("#selectDuration_refer").closest("div").find("span").show()
              $("#selectDuration_refer").closest("div").addClass("has-error")
            }else if ($("#selectStatus_refer").val() == '') {
              $("#selectStatus_refer").closest("div").find("span").show()
              $("#selectStatus_refer").closest("div").addClass("has-error")
            }else{
              storeTimesheet(param,"ModalUpdateTimesheet")
            }
          }else{
            storeTimesheet(param,"ModalUpdateTimesheet")
          }
        }
      }else{
        $.each($("fieldset"),function(index,items){
          if ($(items).find(".card-body").find("#selectType_"+index).val() == "") {
            $("#selectType_"+index).closest("div").find("span").show()
            $("#selectType_"+index).closest("div").addClass("has-error")
          }else if ($(items).find(".card-body").find("#selectType_"+index).val() == "Project" || $(items).find(".card-body").find("#selectType_"+index).val() == "Approach") {
            if ($(items).find(".card-body").find("#selectLead_"+index).val() == "") {
              if ($(items).find(".card-body").find("#selectType_"+index).val() == "Project") {
                // if ($(items).find(".card-body").find("#inputPid_"+index).val() == "") {
                //   $("#selectLead_"+index).closest("div").find("span").show()
                //   $("#selectLead_"+index).closest("div").addClass("has-error")
                // }else{
                  if($(items).find(".card-body").find("#textareaActivity_"+index).val() == ""){
                    $("#textareaActivity_"+index).closest("div").find("span").show()
                    $("#textareaActivity_"+index).closest("div").addClass("has-error")
                  }else{
                    if ($(items).find(".card-body").find("#scheduleInput_"+index).val() == 'Unplanned') {
                      if ($(items).find(".card-body").find("#selectDuration_"+index).val() == '') {
                        $("#selectDuration_"+index).closest("div").find("span").show()
                        $("#selectDuration_"+index).closest("div").addClass("has-error")
                      }else if ($(items).find(".card-body").find("#selectStatus_"+index).val() == '') {
                        $("#selectStatus_"+index).closest("div").find("span").show()
                        $("#selectStatus_"+index).closest("div").addClass("has-error")
                      }else{
                        if (index === $("fieldset").length - 1) {
                          storeTimesheet(param,"ModalAddTimesheet")
                        }
                      }
                    }else{
                      if (index === $("fieldset").length - 1) {
                        storeTimesheet(param,"ModalAddTimesheet")
                      }
                    }
                  }
                // }
                // $("#selectLead_"+index).closest("div").find(".invalid-feedback").text("Please select Project ID!")          
              }else{
                // $("#selectLead_"+index).closest("div").find(".invalid-feedback").text("Please select Lead ID!")          
              }
            }else if($(items).find(".card-body").find("#textareaActivity_"+index).val() == ""){
              $("#textareaActivity_"+index).closest("div").find("span").show()
              $("#textareaActivity_"+index).closest("div").addClass("has-error")
            }else{
              if ($(items).find(".card-body").find("#scheduleInput_"+index).val() == 'Unplanned') {
                if ($(items).find(".card-body").find("#selectDuration_"+index).val() == '') {
                  $("#selectDuration_"+index).closest("div").find("span").show()
                  $("#selectDuration_"+index).closest("div").addClass("has-error")
                }else if ($(items).find(".card-body").find("#selectStatus_"+index).val() == '') {
                  $("#selectStatus_"+index).closest("div").find("span").show()
                  $("#selectStatus_"+index).closest("div").addClass("has-error")
                }else{
                  if (index === $("fieldset").length - 1) {
                    storeTimesheet(param,"ModalAddTimesheet")
                  }
                }
              }else{
                if (index === $("fieldset").length - 1) {
                  storeTimesheet(param,"ModalAddTimesheet")
                }
              }
            }
          }else if ($(items).find(".card-body").find("#textareaActivity_"+index).val() == "") {
            $("#textareaActivity_"+index).closest("div").find("span").show()
            $("#textareaActivity_"+index).closest("div").addClass("has-error")
          }else{
            if ($(items).find(".card-body").find("#scheduleInput_"+index).val() == 'Unplanned') {
              if ($(items).find(".card-body").find("#selectDuration_"+index).val() == '') {
                $("#selectDuration_"+index).closest("div").find("span").show()
                $("#selectDuration_"+index).closest("div").addClass("has-error")
              }else if ($(items).find(".card-body").find("#selectStatus_"+index).val() == '') {
                $("#selectStatus_"+index).closest("div").find("span").show()
                $("#selectStatus_"+index).closest("div").addClass("has-error")
              }else{
                if (index === $("fieldset").length - 1) {
                  storeTimesheet(param,"ModalAddTimesheet")
                }
              }
            }else{
              if (index === $("fieldset").length - 1) {
                storeTimesheet(param,"ModalAddTimesheet")
              }
            }
          }
        })
      }
      // if ($("#selectSchedule").val() == "") {
      //   $("#selectSchedule").closest("div").find("span").show()
      //   $("#selectSchedule").closest("div").addClass("has-error")
      // }else if($("#daterange-input").val() == ""){
      //   $("#daterange-input").closest("div").find("span").show()
      //   $("#daterange-input").closest("div").addClass("has-error")
      // }else if($("#selectType").val() == ""){
      //   $("#selectType").closest("div").find("span").show()
      //   $("#selectType").closest("div").addClass("has-error")
      // }else if($("#selectType").val() == "Project"){
      //   if ($("#selectLead").val() == "") {
      //     $("#selectLead").closest("div").find("span").show()
      //     $("#selectLead").closest("div").addClass("has-error")
      //     // $("#selectLead").closest("div").find("span").text("Please select Project ID!")
      //     $("#selectLead").closest("div").find(".invalid-feedback").text("Please select Project ID!")          
      //   }else if($("#textareaActivity").val() == ""){
      //     $("#textareaActivity").closest("div").find("span").show()
      //     $("#textareaActivity").closest("div").addClass("has-error")
      //   }else{
      //     storeTimesheet()
      //   }
      // }else if($("#selectType").val() == "Approach"){
      //   if ($("#selectLead").val() == "") {
      //     $("#selectLead").closest("div").find("span").show()
      //     $("#selectLead").closest("div").addClass("has-error")
      //     $("#selectLead").closest("div").find(".invalid-feedback").text("Please select Lead ID!")
      //   }else if($("#textareaActivity").val() == ""){
      //     $("#textareaActivity").closest("div").find("span").show()
      //     $("#textareaActivity").closest("div").addClass("has-error")
      //   }else{
      //     storeTimesheet()
      //   }
      // }else if($("#textareaActivity").val() == ""){
      //   $("#textareaActivity").closest("div").find("span").show()
      //   $("#textareaActivity").closest("div").addClass("has-error")
      // }else{
      //   if ($("#selectSchedule").val() == 'Unplanned') {
      //     if ($("#selectDuration").val() == '') {
      //       $("#selectDuration").closest("div").find("span").show()
      //       $("#selectDuration").closest("div").addClass("has-error")
      //     }else if ($("#selectStatus").val() == '') {
      //       $("#selectStatus").closest("div").find("span").show()
      //       $("#selectStatus").closest("div").addClass("has-error")
      //     }else{
      //       storeTimesheet()
      //     }
      //   }else{
      //     storeTimesheet()
      //   }
      // }
      // timesheet/addTimesheet      
      function storeTimesheet(param,modalName){
        formData = new FormData
        formData.append("_token","{{ csrf_token() }}")

        if (param == "refer") {
          var dateRangePicker = $('#daterange-input').data('daterangepicker');
          var startDate = dateRangePicker.startDate.format('YYYY-MM-DD');
          var endDate = dateRangePicker.endDate.format('YYYY-MM-DD');

          formData.append("isGCal",true)
          formData.append("selectSchedule",$("#selectSchedule").val())
          formData.append("startDate",startDate)
          formData.append("endDate",endDate)    
          formData.append("selectType",$("#selectType_refer").val())   
          if ($("#inputPid").val() != "") {
            formData.append("selectLead",$("#inputPid_refer").val())        
          } else {
            formData.append("selectLead",$("#selectLead_refer").val())        
          }    
          formData.append("selectTask",$("#selectTask_refer").val())  
          formData.append("selectPhase",$("#selectPhase_refer").val())        
          formData.append("selectLevel",$("#selectLevel_refer").val())        
          formData.append("textareaActivity",$("#textareaActivity_refer").val())        
          formData.append("selectDuration",$("#selectDuration_refer").val())        
          formData.append("selectStatus",$("#selectStatus_refer").val())
          if (isNaN($("#id_activity").val()) == false) {
            formData.append("id_activity",$("#id_activity").val()) 
          }else{
            formData.append("id_activity","") 
          }

          var postParam = 'refer'

          swalSuccess = {
            icon: 'success',
            title: 'Add Timesheet Succesfully!',
            text: 'Click OK to reload',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK',
          } 
        }else{
          var postParam = 'timesheet'

          var arrTimesheet = []

          var dateRangePicker = $('#daterange-timesheet').data('daterangepicker');
          var startDate = dateRangePicker.startDate.format('YYYY-MM-DD');
          var endDate = dateRangePicker.endDate.format('YYYY-MM-DD');

          $.each($("fieldset"),function(index,items){
            if ($(items).find(".card-body").find("#inputPid_"+index).val() != "") {
              var lead_id = $(items).find(".card-body").find("#inputPid_"+index).val()    
            } else {
              var lead_id = $(items).find(".card-body").find("#selectLead_"+index).val()      
            } 

            if ($(items).find(".card-body").find("#id_activity_"+index).val() != "") {
              arrTimesheet.push({
                id_activity:$(items).find(".card-body").find("#id_activity_"+index).val(),
                selectSchedule:$(items).find(".card-body").find("#scheduleInput_"+index).val(),
                startDate:$("#existingDate_"+index).data('daterangepicker').startDate.format('YYYY-MM-DD'),
                endDate:$("#existingDate_"+index).data('daterangepicker').endDate.format('YYYY-MM-DD'),
                selectType:$(items).find(".card-body").find("#selectType_"+index).val(),
                selectLead:lead_id,
                selectTask:$(items).find(".card-body").find("#selectTask_"+index).val(),
                selectPhase:$(items).find(".card-body").find("#selectPhase_"+index).val(),
                selectLevel:$(items).find(".card-body").find("#selectLevel_"+index).val(),
                textareaActivity:$(items).find(".card-body").find("#textareaActivity_"+index).val(),
                selectDuration:$(items).find(".card-body").find("#selectDuration_"+index).val(),
                selectStatus:$(items).find(".card-body").find("#selectStatus_"+index).val(),
              })
            }else{
              arrTimesheet.push({
                selectSchedule:$(items).find(".card-body").find("#scheduleInput_"+index).val(),
                startDate:startDate,
                endDate:endDate,
                selectType:$(items).find(".card-body").find("#selectType_"+index).val(),
                selectLead:lead_id,
                selectTask:$(items).find(".card-body").find("#selectTask_"+index).val(),
                selectPhase:$(items).find(".card-body").find("#selectPhase_"+index).val(),
                selectLevel:$(items).find(".card-body").find("#selectLevel_"+index).val(),
                textareaActivity:$(items).find(".card-body").find("#textareaActivity_"+index).val(),
                selectDuration:$(items).find(".card-body").find("#selectDuration_"+index).val(),
                selectStatus:$(items).find(".card-body").find("#selectStatus_"+index).val(),
              })
            }
          })

          formData.append("arrTimesheet",JSON.stringify(arrTimesheet))
          formData.append("isGCal",false)

          swalSuccess = {
            icon: 'success',
            title: 'Do you want to add timesheet again?',
            text: 'if you do not add timesheet again, select "No" to quit',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
          } 
        }

        // swalFireCustom = {
        //   title: 'Are you sure?',
        //   text: "Save this Timesheet!",
        //   icon: 'warning',
        //   showCancelButton: true,
        //   confirmButtonColor: '#3085d6',
        //   cancelButtonColor: '#d33',
        //   confirmButtonText: 'Yes',
        //   cancelButtonText: 'No',
        // }

        // if ($("#"+modalName).find('.modal-footer').find(".btn-primary").length) {
        //   swalSuccess = {
        //       icon: 'success',
        //       title: 'Do you want to add timesheet again?',
        //       text: 'if you do not add timesheet again, select No',
        //       showCancelButton: true,
        //       confirmButtonColor: '#3085d6',
        //       cancelButtonColor: '#d33',
        //       confirmButtonText: 'Yes',
        //       cancelButtonText: 'No',
        //   } 
        // }else{
        //   swalSuccess = {
        //       icon: 'success',
        //       title: 'Update Timesheet Succesfully!',
        //       text: 'Do you want to add timesheet again?',
        //       showCancelButton: true,
        //       confirmButtonColor: '#3085d6',
        //       cancelButtonColor: '#d33',
        //       confirmButtonText: 'Yes',
        //       cancelButtonText: 'No',
        //   } 
        // }
        
        createPost('',formData,swalSuccess,url="/timesheet/addTimesheet",postParam,modalName)
      }
    }

    function createPost(swalFireCustom,data,swalSuccess,url,postParam,modalName){
      localStorage.setItem("savedScrollPosition",$(".fc-scroller").scrollTop())

      if (swalFireCustom == '') {
        if (swalSuccess == '') {
          $.ajax({
            type:"POST",
            url:"{{url('/')}}"+url,
            processData: false,
            contentType: false,
            data:data,
            success: function(results)
            {
              Swal.close()
              loadData()
            }
          })
        }else{
          $.ajax({
            type:"POST",
            url:"{{url('/')}}"+url,
            processData: false,
            contentType: false,
            data:data,
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
            success: function(results)
            {
              Swal.fire(swalSuccess).then((result,data) => {
                const dateString = calendar.fullCalendar('getView').title
                const date = moment(dateString, "MMMM YYYY");
                date.endOf('month');
                // Convert to ISO format
                const isoDateString = date.toISOString(); 

                if (postParam == 'refer') {
                  loadData(isoDateString)
                  Swal.close()
                  if (modalName) {
                    $("#"+modalName).modal("hide")
                  }
                }else{
                  if (result.isConfirmed) {
                    loadData(isoDateString)
                    Swal.close()
                    eventUpdateTimesheet()
                  }else{
                    loadData(isoDateString)
                    if (window.location.href.split("/")[4].split("?")[1]) {
                      history.replaceState(null, '', "{{url('timesheet/timesheet')}}")
                    }
                    if (modalName) {
                      $("#"+modalName).modal("hide")
                    }  
                  }
                }
              })
            }
          })
        }
      }else{
        Swal.fire(swalFireCustom).then((resultFire) => {
          if (resultFire.value) {
            $.ajax({
              type:"POST",
              url:"{{url('/')}}"+url,
              processData: false,
              contentType: false,
              data:data,
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
              success: function(results)
              {
                Swal.fire(swalSuccess).then((result,data) => {
                  if (postParam == 'timesheet') {
                    if (result.value) {
                      Swal.close()
                      $("#ModalAddTimesheet").find('.modal-footer').find(".btn-primary").removeClass("btn-primary").addClass("btn-warning").text('Update')
                    }else{
                      $("#"+modalName).modal('hide')
                      loadData()
                    }
                  }else if (postParam == 'permit') {
                    if (result.value) {
                      var newEvents = []

                      if (postParam == 'permit') {
                        $.each(results,function(idx,value){
                          newEvents.push({"title":value.activity,"start":value.start_date,"end":value.end_date,"id":value.id,"remarks":value.status})
                        }) 

                        newEvents.forEach(function(event) {  
                            $('#calendar').fullCalendar('renderEvent', event, true);
                            $('#calendar').fullCalendar('refetchEvents');
                        })

                        $("#ModalPermit").modal('hide')
                      }else{
                        $("#ModalInfo").modal('hide')
                      }

                      loadData()  
                    }
                  }else if(postParam == "delete_activity"){
                      loadData()
                      Swal.close()
                      $("#fieldset_"+url.split("=")[1]).remove()

                      var j = 1
                      var last = $('fieldset').last()
                      var countable = parseInt($(last).attr("id").split("_")[1])

                      $.each($("fieldset:not(:first)"),function(index,items){
                        $(items).find(".card-title").text("Activity "+ ++j)
                      })

                      $.each($("fieldset"),function(index,items){
                        $(items).attr("id","fieldset_"+index)
                        $.each($("#"+$(items).attr("id")),function(idx,itemIdx){
                          $(itemIdx).find("input[name='id_activity']").attr("id","id_activity_"+index)
                          $(itemIdx).find("input[name='scheduleInput']").attr("id","scheduleInput_"+index)
                          $(itemIdx).find("input[name='inputPid']").attr("id","inputPid_"+index)
                          $(itemIdx).find("select[name='selectType']").attr("id","selectType_"+index)
                          $(itemIdx).find("select[name='selectLead']").attr("id","selectLead_"+index)
                          $(itemIdx).find("select[name='selectTask']").attr("id","selectTask_"+index)
                          $(itemIdx).find("select[name='selectPhase']").attr("id","selectPhase_"+index)
                          $(itemIdx).find("select[name='selectLevel']").attr("id","selectLevel_"+index)
                          $(itemIdx).find("textarea[name='textareaActivity']").attr("id","textareaActivity_"+index)
                          $(itemIdx).find("select[name='selectDuration']").attr("id","selectDuration_"+index)
                          $(itemIdx).find("select[name='selectStatus']").attr("id","selectStatus_"+index)
                        })
                      })

                      if ($(last).find('.form-group').last().find("#btn_add_activity").length == 0) {
                        $("#fieldset_"+countable).find('.form-group').last().append('<button style="margin-left:5px" type="button" class="btn btn-sm btn-primary btn-flat" id="btn_add_activity" value="'+countable+'"><i class="bx bx-plus"></i></button>')
                      }
                  }else{
                    location.reload()
                  }
                  
                })
                
              }
            })
          }
        })
      }
    }

    function showAlertRemaining(date){
      $($("#alertForRemaining").find("span")[1]).text(". . .")

      $.ajax({
        type:"GET",
        url:"{{url('timesheet/getPercentage')}}?date="+date,
        success:function(result){
          $($("#alertForRemaining").find("span")[0]).text(result.name)
          $($("#alertForRemaining").find("span")[1]).text(result.percentage)
        }
      })
    }

    function importCsv(url){
      $("#inputCsv").val("")
      $("#ModalImport").modal("show")
      // '{{action('TimesheetController@uploadCSV')}}'
      // window.open(url, "_blank");
    }

    function uploadCsv(){
      if ($("#inputCsv").val() == "") {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Please upload your csv!',
        })
      }else{
        var data = new FormData();
        data.append('csv_file',$('#inputCsv').prop('files')[0]);
        data.append('_token','{{ csrf_token() }}');

        $.ajax({
          type:"POST",
          url:"{{url('/timesheet/uploadCSV')}}",
          processData: false,
          contentType: false,
          data:data,
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
          success: function(results)
          {
            if (results.status == "Error") {
              Swal.fire({
                icon: 'error',
                title: 'Error! '+ results.text,
                text: 'Please check again!',
              })
            }else{
              Swal.fire({
                icon: 'success',
                title: 'Create Timesheet Succesfully!',
                text: 'Click Ok to reload page',
              }).then((result,data) => {
                if (result.value) {
                  $("#ModalImport").modal("hide")
                  const dateString = calendar.fullCalendar('getView').title
                  const date = moment(dateString, "MMMM YYYY");
                  date.endOf('month');
                  // Convert to ISO format
                  const isoDateString = date.toISOString(); 
                  loadData(isoDateString)              
                }
              })
            } 
          },
          error: function(xhr, status, error) {
            Swal.fire({
              icon: 'error',
              title: 'Error! ',
              text: 'Please check again!',
            })
          }
        })
      }
    }

    $('input[type="file"][name="inputCsv"]').change(function(){
      var f=this.files[0]
      var filePath = f;

      var ext = filePath.name.split(".");
      ext = ext[ext.length-1].toLowerCase();      
      var arrayExtensions = ["csv"];


      if (arrayExtensions.lastIndexOf(ext) == -1) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Invalid file type, just allow csv file',
        }).then((result) => {
          this.value = ''
        })
      }
    })

    function clickPIDAdjustment(idValue){
      $("#divPid_"+idValue).show()
      $("#divPid_"+idValue).closest(".form-group").removeClass('has-error')
      $("#divPid_"+idValue).closest(".form-group").find('.invalid-feedback').attr('style','display:none!important')
    }

    function closePidAdjustment(idValue){
      Swal.fire({
        icon: 'warning',
        title: 'Are you sure!',
        text: 'If you close this input, you will lose your PID!',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel',
      }).then((result,data) => {
        if (result.value) {
          $("#divPid_"+idValue).attr('style','display:none!important')
          $("#inputPid_"+idValue).val("")       
        }else{
          Swal.close()
        }
      }) 
    }

    $('#ModalAddTimesheet').on('hidden.bs.modal', function () {
      $("a[name='divPid']").attr('style','display:none!important')

      $("#fieldset_0").find(".card-body").show("slow")
      $("#fieldset_0").find(".card-header").find("i").removeClass('bx bx-plus').addClass('bx bx-minus')

      $('#ModalAddTimesheet').find(".modal-body").find("fieldset:not(:first)").remove()
      if ($("#fieldset_0").find('.form-group').last().find('#btn_add_activity').length == 0) {
        $("#fieldset_0").find('.form-group').last().append('<button style="margin-left:5px" type="button" class="btn btn-sm btn-primary btn-flat" id="btn_add_activity" value="0"><i class="bx bx-plus"></i></button>')
      }
    })

    $('#ModalUpdateTimesheet').on('hidden.bs.modal', function () {
      $("input").val('')
      $("select").val('').trigger("change")
      // $("select").prop("disabled",false)
      // $("textarea").prop("disabled",false)
    })

    $('#daterange-timesheet').on('hide.daterangepicker',(e,picker) => {
      var range = moment().isBetween(picker.startDate, picker.endDate);

      if (range) {
        if (moment(picker.endDate).format("YYYY-MM-DD") != moment(moment()).format("YYYY-MM-DD")) {
          Swal.fire(
            'Date is not appropriated!',
            'Select range date with correct schedule type',
            'error'
          ).then(() => {
            var start = moment(moment()).format('MM/DD/YYYY')
            var end = moment(moment()).format('MM/DD/YYYY') 

            $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
            $('#daterange-timesheet').data('daterangepicker').setEndDate(end);
            eventUpdateTimesheet()
          })
        }else {
          $("input[name='scheduleInput']").val("Unplanned")
          $("select[name='selectDuration']").prev("label").after("<span>*</span>")
          $("select[name='selectStatus']").prev("label").after("<span>*</span>")
          $("select[name='selectDuration']").prop("disabled",false)
          $("select[name='selectStatus']").prop("disabled",false)

          Swal.fire({
            title: 'Loading...',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText:'',
            showConfirmButton:false,
            didOpen: () => {
              // Delayed task using setTimeout
              setTimeout(() => {
                // Close the loading indicator
                var start = moment(picker.startDate).format('MM/DD/YYYY')
                var end = moment(picker.endDate).format('MM/DD/YYYY') 

                $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
                $('#daterange-timesheet').data('daterangepicker').setEndDate(end);

                eventUpdateTimesheet();
                Swal.close();
              }, 2000); // Delayed execution after 2000ms (2 seconds)
            }
          });
        }
      }else{
        if (picker.startDate > moment()) {
          $("input[name='scheduleInput']").val("Planned")
          $("select[name='selectDuration']").prev("span").remove()
          $("select[name='selectStatus']").prev("span").remove()
          $("select[name='selectDuration']").prop("disabled",true)
          $("select[name='selectStatus']").prop("disabled",true)

          Swal.fire({
            title: 'Loading...',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText:'',
            showConfirmButton:false,
            didOpen: () => {
              // Delayed task using setTimeout
              setTimeout(() => {
                // Close the loading indicator
                var start = moment(picker.startDate).format('MM/DD/YYYY')
                var end = moment(picker.endDate).format('MM/DD/YYYY') 

                $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
                $('#daterange-timesheet').data('daterangepicker').setEndDate(end);

                eventUpdateTimesheet();
                Swal.close();
              }, 2000); // Delayed execution after 2000ms (2 seconds)
            }
          });
        }else if (picker.startDate <= moment()) {
          $("input[name='scheduleInput']").val("Unplanned")
          $("select[name='selectDuration']").prev("label").after("<span>*</span>")
          $("select[name='selectStatus']").prev("label").after("<span>*</span>")
          $("select[name='selectDuration']").prop("disabled",false)
          $("select[name='selectStatus']").prop("disabled",false)

          Swal.fire({
            title: 'Loading...',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText:'',
            showConfirmButton:false,
            didOpen: () => {
              // Delayed task using setTimeout
              setTimeout(() => {
                // Close the loading indicator
                var start = moment(picker.startDate).format('MM/DD/YYYY')
                var end = moment(picker.endDate).format('MM/DD/YYYY') 

                $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
                $('#daterange-timesheet').data('daterangepicker').setEndDate(end);

                eventUpdateTimesheet();
                Swal.close();
              }, 2000); // Delayed execution after 2000ms (2 seconds)
            }
          });
        }
      }
    })

    $('#ModalAddTimesheet').on('click', '#btn_add_activity', function() {
      var i = this.value
      var count_title = parseInt(this.value) + 2
      var appendfieldset = ''

      appendfieldset = appendfieldset + '  <fieldset style="padding-bottom: 5px;" id="fieldset">'
      appendfieldset = appendfieldset + '    <div class="form-group" style="display:inline;">'
      appendfieldset = appendfieldset + '      <div class="card bg-outline-secondary" style="border-top:none;width: 80%;float: left;border: 1px solid #ccc;">'
      appendfieldset = appendfieldset + '        <div class="card-header with-border d-flex">'
      appendfieldset = appendfieldset + '          <h6 class="card-title" style="margin-top:5px;font-size:14px">Activity '+ count_title +'</h6>'
      appendfieldset = appendfieldset + '          <button type="button" class="btn btn-sm collapse-fieldset ms-auto" data-widget="collapse" fdprocessedid="gkstjs"><i class="bx bx-minus"></i>'
      appendfieldset = appendfieldset + '          </button>'
      appendfieldset = appendfieldset + '        </div>'
      appendfieldset = appendfieldset + '        <div class="card-body">'
      appendfieldset = appendfieldset + '        <div class="row">'
      appendfieldset = appendfieldset + '          <div class="col-md-6">'
      appendfieldset = appendfieldset + '           <input type="" name="id_activity" id="id_activity" hidden>'
      appendfieldset = appendfieldset + '            <div class="form-group">'
      appendfieldset = appendfieldset + '              <label>Schedule*</label>'
      appendfieldset = appendfieldset + '              <input type="text" name="scheduleInput" id="scheduleInput" value="Unplanned" class="form-control" disabled>'
      appendfieldset = appendfieldset + '            </div>'
      appendfieldset = appendfieldset + '          </div>'
      appendfieldset = appendfieldset + '          <div class="col-md-6">'
      appendfieldset = appendfieldset + '            <div class="form-group">'
      appendfieldset = appendfieldset + '              <label>Type*</label>'
      appendfieldset = appendfieldset + '              <select class="form-control select2" name="selectType" id="selectType" onchange="validateInput(this)">'
      appendfieldset = appendfieldset + '                <option>  </option>'
      appendfieldset = appendfieldset + '              </select>'
      appendfieldset = appendfieldset + '              <span class="invalid-feedback" style="display:none!important">Please select Type!</span>'
      appendfieldset = appendfieldset + '            </div>'
      appendfieldset = appendfieldset + '          </div>'
      appendfieldset = appendfieldset + '        </div>'
      appendfieldset = appendfieldset + '          <div class="form-group">'
      appendfieldset = appendfieldset + '            <label>PID/Lead ID</label>'
      appendfieldset = appendfieldset + '            <select class="form-control" name="selectLead" id="selectLead" placeholder="Select Project Id" onchange="validateInput(this)"><option></option></select>'
      appendfieldset = appendfieldset + '            <span class="invalid-feedback" style="display:none!important">Please select Lead ID!</span>'
      appendfieldset = appendfieldset + '            <small>Nomor PID tidak tersedia? <a style="cursor: not-allowed;" id="idAddPid" name="idAddPid">tambahkan disini</a></small>'
      appendfieldset = appendfieldset + '            <div class="row" id="divPid" name="divPid" style="display: none;">'
      appendfieldset = appendfieldset + '              <div class="col-lg-11 col-xs-11">'
      appendfieldset = appendfieldset + '                <input type="inputPid" name="inputPid" id="inputPid" class="form-control" onchange="validateInput(this)">'
      appendfieldset = appendfieldset + '              </div>'
      appendfieldset = appendfieldset + '              <div class="col-lg-1 col-xs-1" style="padding-left:0px!important;"><i class="bx bx-2x bx-x pull-left" style="color:red" id="idClosePid_" name="idClosePid"></i></div>                    '
      appendfieldset = appendfieldset + '            </div>'
      appendfieldset = appendfieldset + '          </div>'
      appendfieldset = appendfieldset + '          <div class="row">'
      appendfieldset = appendfieldset + '            <div class="col-md-6">'
      appendfieldset = appendfieldset + '              <div class="form-group">'
      appendfieldset = appendfieldset + '                <label>Task <small onclick="showHelp("task")"><i class="bx bx-info-circle"></i></small></label>'
      appendfieldset = appendfieldset + '                <select class="form-control" name="selectTask" id="selectTask"><option></option></select>'
      appendfieldset = appendfieldset + '                <!-- <span class="invalid-feedback" style="display:none!important">Please select task!</span> -->'
      appendfieldset = appendfieldset + '              </div>'
      appendfieldset = appendfieldset + '            </div>'
      appendfieldset = appendfieldset + '            <div class="col-md-6">'
      appendfieldset = appendfieldset + '              <div class="form-group">'
      appendfieldset = appendfieldset + '                <label>Phase <small onclick="showHelp("phase")"><i class="bx bx-info-circle"></i></small></label>'
      appendfieldset = appendfieldset + '                <select class="form-control" name="selectPhase" id="selectPhase"><option></option></select>'
      appendfieldset = appendfieldset + '                <!-- <span class="invalid-feedback" style="display:none!important">Please select phase!</span> -->'
      appendfieldset = appendfieldset + '              </div>'
      appendfieldset = appendfieldset + '            </div>'
      appendfieldset = appendfieldset + '          </div>'
      appendfieldset = appendfieldset + '          <div class="form-group">'
      appendfieldset = appendfieldset + '            <label>Level <small onclick="showHelp("level")"><i class="bx bx-info-circle"></i></small></label>'
      appendfieldset = appendfieldset + '            <select class="form-control" name="selectLevel" id="selectLevel"><option></option></select>'
      appendfieldset = appendfieldset + '            <span class="invalid-feedback" style="display:none!important">Please select Level!</span>'
      appendfieldset = appendfieldset + '          </div>'
      appendfieldset = appendfieldset + '          <div class="form-group">'
      appendfieldset = appendfieldset + '            <label>Activity*</label>'
      appendfieldset = appendfieldset + '            <textarea class="form-control" name="textareaActivity" id="textareaActivity" onkeyup="validateInput(this)"></textarea> '
      appendfieldset = appendfieldset + '            <span class="invalid-feedback" style="display:none!important">Please fill Activity!</span>'
      appendfieldset = appendfieldset + '          </div>'
      appendfieldset = appendfieldset + '          <div class="row">'
        appendfieldset = appendfieldset + '            <div class="col-md-6">'
          appendfieldset = appendfieldset + '              <div class="form-group">'
          appendfieldset = appendfieldset + '                <label>Duration</label>'
          appendfieldset = appendfieldset + '                <select class="form-control" name="selectDuration" id="selectDuration" onchange="validateInput(this)"><option></option></select>'
          appendfieldset = appendfieldset + '                <span class="invalid-feedback" style="display:none!important">Please select Duration!</span>'
          appendfieldset = appendfieldset + '              </div>'
        appendfieldset = appendfieldset + '            </div>'
        appendfieldset = appendfieldset + '            <div class="col-md-6">'
          appendfieldset = appendfieldset + '              <div class="form-group">'
          appendfieldset = appendfieldset + '                <label>Status</label>'
          appendfieldset = appendfieldset + '                <select class="form-control" name="selectStatus" id="selectStatus" onchange="validateInput(this)"><option></option></select>'
          appendfieldset = appendfieldset + '                <span class="invalid-feedback" style="display:none!important">Please select Status!</span>'
          appendfieldset = appendfieldset + '              </div>'
        appendfieldset = appendfieldset + '            </div>'
      appendfieldset = appendfieldset + '          </div>'
      appendfieldset = appendfieldset + '<div class="form-group" hidden>'
        appendfieldset = appendfieldset + '<label>exist date</label><input class="form-control" name="existingDate">'
      appendfieldset = appendfieldset + '</div>'
      appendfieldset = appendfieldset + '        </div>'
      appendfieldset = appendfieldset + '      </div>'
      appendfieldset = appendfieldset + '    </div>'
      appendfieldset = appendfieldset + '    <div class="form-group" style="display:inline;">'
      appendfieldset = appendfieldset + '      <button type="button" class="btn btn-sm btn-danger" id="btn_delete_activity" style="margin-left:5px"><i class="bx bx-trash"></i></button>'
      appendfieldset = appendfieldset + '      <button type="button" class="btn btn-sm btn-primary" id="btn_add_activity"><i class="bx bx-plus"></i></button>'
      appendfieldset = appendfieldset + '    </div>'
      appendfieldset = appendfieldset + '  </fieldset>'

      $("#fieldset_"+i).after(appendfieldset)
      $("#fieldset_"+i).find(".card-body").hide("slow")

      if ($("#fieldset_"+i).find(".card-header").next().is(":visible")) {
        $("#fieldset_"+i).find(".card-header").next().attr('style','display:none!important')
        $("#fieldset_"+i).find(".card-header").find("i").removeClass('bx bx-minus').addClass('bx bx-plus')
      }

      $("#btn_add_activity[value='"+ i +"']").remove()
      var countable = ++i
      $("#fieldset").attr("id","fieldset_"+countable)

      $("#fieldset_"+countable).find($("select[name='selectType']")).attr("id","selectType_"+countable)
      $("#fieldset_"+countable).find($("select[name='selectLead']")).attr("id","selectLead_"+countable)
      $("#fieldset_"+countable).find($("input[name='scheduleInput']")).attr("id","scheduleInput_"+countable)
      $("#fieldset_"+countable).find($("select[name='selectTask']")).attr("id","selectTask_"+countable)
      $("#fieldset_"+countable).find($("select[name='selectPhase']")).attr("id","selectPhase_"+countable)
      $("#fieldset_"+countable).find($("select[name='selectLevel']")).attr("id","selectLevel_"+countable)
      $("#fieldset_"+countable).find($("select[name='selectDuration']")).attr("id","selectDuration_"+countable)
      $("#fieldset_"+countable).find($("select[name='selectStatus']")).attr("id","selectStatus_"+countable)
      $("#fieldset_"+countable).find($("input[name='inputPid']")).attr("id","inputPid_"+countable)
      $("#fieldset_"+countable).find($("a[name='idAddPid']")).attr("id","idAddPid_"+countable)
      $("#fieldset_"+countable).find($("div[name='divPid']")).attr("id","divPid_"+countable)
      $("#fieldset_"+countable).find($("i[name='idClosePid']")).attr("onclick","closePidAdjustment("+countable+")")
      $("#fieldset_"+countable).find($("input[name='id_activity']")).attr("id","id_activity_"+countable)
      $("#fieldset_"+countable).find($("textarea[name='textareaActivity']")).attr("id","textareaActivity_"+countable)
      $("#fieldset_"+countable).find($("input[name='existingDate']")).attr("id","existingDate"+countable)

      $("#fieldset_"+countable).find($("input[name='id_activity']")).val("")
      $("#fieldset_"+countable).find("#btn_add_activity").val(countable)
      $("#fieldset_"+countable).find("#btn_delete_activity").val(countable)

      if ($("#daterange-timesheet").data('daterangepicker').startDate._d > moment()) {
        $("#scheduleInput_"+countable).val("Planned")
        $("select[name='selectDuration']").prop("disabled",true)
        $("select[name='selectStatus']").prop("disabled",true)
        $("select[name='selectDuration']").prev("label").find("span").remove()
        $("select[name='selectStatus']").prev("label").find("span").remove()
      }else if ($("#daterange-timesheet").data('daterangepicker').startDate._d <= moment()) {
        $("#scheduleInput_"+countable).val("Unplanned")
        $("select[name='selectDuration']").prev("label").after("<span>*</span>")
        $("select[name='selectStatus']").prev("label").after("<span>*</span>")
        $("select[name='selectDuration']").prop("disabled",false)
        $("select[name='selectStatus']").prop("disabled",false)
      }

      if ($("#fieldset_"+countable)) {
        setType(countable)
        setDuration(countable)
        setLevel(countable)
        setStatus(countable)
        setTask(countable)
        setPhase(countable)
      }
    })

    $('#ModalAddTimesheet').on('click', '#btn_delete_activity', function() {
      if ($(this).hasClass("editBtn")) {
        deleteActivity($("#id_activity_"+this.value).val(),this.value)
      }else{
        $("#fieldset_"+this.value).remove()

        var j = 1
        var last = $('fieldset').last()
        var countable = parseInt($(last).attr("id").split("_")[1])

        $.each($("fieldset:not(:first)"),function(index,items){
          $(items).find(".card-title").text("Activity "+ ++j)
        })

        if ($(last).find('.form-group').last().find("#btn_add_activity").length == 0) {
          $("#fieldset_"+countable).find('.form-group').last().append('<button style="margin-left:5px" type="button" class="btn btn-sm btn-primary btn-flat" id="btn_add_activity" value="'+countable+'"><i class="bx bx-plus"></i></button>')
        }
      }
    })

    $("#ModalAddTimesheet").on("click", '.collapse-fieldset', function() {
      if ($(this).closest("div").closest(".card-header").next().is(":visible")) {
        $(this).closest("div").closest(".card-header").next().attr('style','display:none!important')
        $(this).find("i").removeClass('bx bx-minus').addClass('bx bx-plus')
      }else{
        $(this).closest("div").closest(".card-header").next().show()
        $(this).find("i").removeClass('bx bx-plus').addClass('bx bx-minus')
      }
    });    

    function unplannedDate(lock_date){
      if (moment($('#daterange-timesheet').data('daterangepicker').startDate).format('MM/DD/YYYY') <= lock_date) {
        Swal.fire(
          'Out of the Date!',
          'You have limit of lock duration',
          'warning'
        )
      }else{
        var range = moment(moment().format('MM/DD/YYYY'),'MM/DD/YYYY').isBetween(moment($('#daterange-timesheet').data('daterangepicker').startDate).subtract(1, 'd').format('MM/DD/YYYY'), moment($('#daterange-timesheet').data('daterangepicker').endDate).subtract(1, 'd').format('MM/DD/YYYY'), undefined, '[)');

        if (range) {
          if (moment($('#daterange-timesheet').data('daterangepicker').endDate.subtract(1, 'd')).format("YYYY-MM-DD") != moment(moment()).format("YYYY-MM-DD")) {
            Swal.fire(
              'Date is not appropriated!',
              'Select range date with correct schedule type',
              'error'
            ).then(() => {
              var start = moment(moment()).format('MM/DD/YYYY')
              var end = moment(moment()).format('MM/DD/YYYY') 

              $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
              $('#daterange-timesheet').data('daterangepicker').setEndDate(end);
              eventUpdateTimesheet()
            })
          }else {
            if ($("#ModalAddTimesheet").find(".modal-footer").find(".btn-primary").text() == "Save") {
              swalAlert = {
                icon: "warning",
                title: "Are you sure skip this date!",
                text: "If you do not save this activity before move to another date! you will lose this activity!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
              }
            }else{
              swalAlert = {
                icon: "warning",
                title: "You want to select another date!",
                text: "If you select 'Yes', you will save all changes this timesheet before!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
              }
            }

            Swal.fire(swalAlert).then((result,data) => {
              if (result.value) {
                Swal.fire({
                  title: 'Loading...',
                  allowEscapeKey: false,
                  allowOutsideClick: false,
                  confirmButtonText:'',
                  showConfirmButton:false,
                  didOpen: () => {
                    // Delayed task using setTimeout
                    setTimeout(() => {
                      // Close the loading indicator
                      var start = moment($('#daterange-timesheet').data('daterangepicker').startDate).subtract(1, 'd').format('MM/DD/YYYY')
                      var end = moment($('#daterange-timesheet').data('daterangepicker').endDate).subtract(1, 'd').format('MM/DD/YYYY') 

                      $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
                      $('#daterange-timesheet').data('daterangepicker').setEndDate(end);

                      eventUpdateTimesheet()
                      Swal.close();
                    }, 2000); // Delayed execution after 2000ms (2 seconds)
                  }
                });
              }else{
                Swal.close()
              }
            })        
          }
        }else{
          if ($("#ModalAddTimesheet").find(".modal-footer").find(".btn-primary").text() == "Save") {
            swalAlert = {
              icon: "warning",
              title: "Are you sure skip this date!",
              text: "If you do not save this activity before move to another date! you will lose this activity!",
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes',
              cancelButtonText: 'No',
            }
          }else{
            swalAlert = {
              icon: "warning",
              title: "You want to select another date!",
              text: "If you select 'Yes', you will save all changes this timesheet before!",
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes',
              cancelButtonText: 'Cancel',
            }
          }

          Swal.fire(swalAlert).then((result,data) => {
            if (result.value) {
              Swal.fire({
                title: 'Loading...',
                allowEscapeKey: false,
                allowOutsideClick: false,
                confirmButtonText:'',
                showConfirmButton:false,
                didOpen: () => {
                  // Delayed task using setTimeout
                  setTimeout(() => {
                    // Close the loading indicator
                    var start = moment($('#daterange-timesheet').data('daterangepicker').startDate).subtract(1, 'd').format('MM/DD/YYYY')
                    var end = moment($('#daterange-timesheet').data('daterangepicker').endDate).subtract(1, 'd').format('MM/DD/YYYY') 

                    $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
                    $('#daterange-timesheet').data('daterangepicker').setEndDate(end);

                    eventUpdateTimesheet()                    
                    Swal.close();
                  }, 2000); // Delayed execution after 2000ms (2 seconds)
                }
              });
            }else{
              Swal.close()
            }
          })
        }
      }
    }

    function plannedDate(){
      var range = moment(moment().format('MM/DD/YYYY'),'MM/DD/YYYY').isBetween(moment($('#daterange-timesheet').data('daterangepicker').startDate).add(1, 'd').format('MM/DD/YYYY'), moment($('#daterange-timesheet').data('daterangepicker').endDate).add(1, 'd').format('MM/DD/YYYY'), undefined, '[)');

      if (range) {
        if (moment($('#daterange-timesheet').data('daterangepicker').endDate.add(1, 'd')).format("YYYY-MM-DD") != moment(moment()).format("YYYY-MM-DD")) {
          Swal.fire(
            'Date is not appropriated!',
            'Select range date with correct schedule type',
            'error'
          ).then(() => {
            var start = moment(moment()).format('MM/DD/YYYY')
            var end = moment(moment()).format('MM/DD/YYYY') 

            $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
            $('#daterange-timesheet').data('daterangepicker').setEndDate(end);
            eventUpdateTimesheet()
          })
        }else {
          if ($("#ModalAddTimesheet").find(".modal-footer").find(".btn-primary").text() == "Save") {
            swalAlert = {
              icon: "warning",
              title: "Are you sure skip this date!",
              text: "If you do not save this activity before move to another date! you will lose this activity!",
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes',
              cancelButtonText: 'No',
            }
          }else{
            swalAlert = {
              icon: "warning",
              title: "You want to select another date!",
              text: "If you select 'Yes', you will save all changes this timesheet before!",
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes',
              cancelButtonText: 'Cancel',
            }
          }

          Swal.fire(swalAlert).then((result,data) => {
            if (result.value) {
              Swal.fire({
                title: 'Loading...',
                allowEscapeKey: false,
                allowOutsideClick: false,
                confirmButtonText:'',
                showConfirmButton:false,
                didOpen: () => {
                  // Delayed task using setTimeout
                  setTimeout(() => {
                    // Close the loading indicator
                    // var start = moment($('#daterange-timesheet').data('daterangepicker').startDate).add(1, 'd').format('MM/DD/YYYY')
                    // var end = moment($('#daterange-timesheet').data('daterangepicker').endDate).add(1, 'd').format('MM/DD/YYYY') 

                    $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
                    $('#daterange-timesheet').data('daterangepicker').setEndDate(end);

                    eventUpdateTimesheet()
                    Swal.close();
                  }, 2000); // Delayed execution after 2000ms (2 seconds)
                }
              });
            }else{
              Swal.close()
            }
          })        
        }
      }else{
        if ($("#ModalAddTimesheet").find(".modal-footer").find(".btn-primary").text() == "Save") {
          swalAlert = {
            icon: "warning",
            title: "Are you sure skip this date!",
            text: "If you do not save this activity before move to another date! you will lose this activity!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
          }
        }else{
          swalAlert = {
            icon: "warning",
            title: "You want to select another date!",
            text: "If you select 'Yes', you will save all changes this timesheet before!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
          }
        }

        Swal.fire(swalAlert).then((result,data) => {
          if (result.value) {
            Swal.fire({
              title: 'Loading...',
              allowEscapeKey: false,
              allowOutsideClick: false,
              confirmButtonText:'',
              showConfirmButton:false,
              didOpen: () => {
                // Delayed task using setTimeout
                setTimeout(() => {
                  // Close the loading indicator
                  var start = moment($('#daterange-timesheet').data('daterangepicker').startDate).add(1, 'd').format('MM/DD/YYYY')
                  var end = moment($('#daterange-timesheet').data('daterangepicker').endDate).add(1, 'd').format('MM/DD/YYYY') 

                  $('#daterange-timesheet').data('daterangepicker').setStartDate(start);
                  $('#daterange-timesheet').data('daterangepicker').setEndDate(end);

                  eventUpdateTimesheet()
                  Swal.close();
                }, 2000); // Delayed execution after 2000ms (2 seconds)
              }
            });
          }else{
            Swal.close()
          }
        })
      }
    }

    function showUpdateTimesheet(result,calEvent){
      var append = ""
      $.each(result,function(index,item){
        var countable = index

        append = append + '<fieldset style="padding-bottom: 5px;" id="fieldset_'+ index +'">'
          append = append + '<div class="form-group" style="display:inline;">'
            append = append + '<div class="card bg-outline-secondary" style="border-top:none;width: 80%;float: left;border: 1px solid #ccc;">'
              append = append + '<div class="card-header with-border d-flex">'
                append = append + '<h6 class="card-title" style="font-size:14px;margin-top:5px">Activity '+ ++countable +'</h6>'
                  append = append + '<button type="button" class="btn btn-sm ms-auto collapse-fieldset" fdprocessedid="gkstjs"><i class="bx bx-plus"></i>'
                  append = append + '</button>'
              append = append + '</div>'
              append = append + '<div class="card-body" style="display:none!important">'
                append = append + '<div class="row">'
                  append = append + '<div class="col-md-6">'
                    append = append + '<input type="" name="id_activity" id="id_activity_'+ index +'" hidden>'
                    append = append + '<div class="form-group">'
                      append = append + '<label>Schedule*</label>'
                      append = append + '<input type="text" name="scheduleInput" id="scheduleInput_'+ index +'" class="form-control" disabled>'
                    append = append + '</div>'
                  append = append + '</div>'
                  append = append + '<div class="col-md-6">'
                    append = append + '<div class="form-group">'
                      append = append + '<label>Type*</label>'
                      append = append + '<select class="form-control select2" name="selectType" id="selectType_'+ index +'" onchange="validateInput(this)">'
                        append = append + '<option>  </option>'
                      append = append + '</select>'
                      append = append + '<span class="invalid-feedback" style="display:none!important">Please select Type!</span>'
                    append = append + '</div>'
                  append = append + '</div>'
                append = append + '</div>'
                append = append + '<div class="form-group">'
                  append = append + '<label>PID/Lead ID</label>'
                   append = append + '<select class="form-control" name="selectLead" id="selectLead_'+ index +'" placeholder="Select Project Id" onchange="validateInput(this)"><option></option></select>'
                  append = append + '<span class="invalid-feedback" style="display:none!important">Please select Lead ID!</span>'
                    append = append + '<small>Nomor PID tidak tersedia? <a style="cursor: not-allowed;" id="idAddPid_'+ index +'" name="idAddPid">tambahkan disini</a></small>'
                  append = append + '<div class="row" id="divPid_'+ index +'" name="divPid" style="display: none;">'
                    append = append + '<div class="col-lg-11 col-xs-11">'
                      append = append + '<input type="inputPid" name="inputPid" id="inputPid_'+ index +'" class="form-control">'
                    append = append + '</div>'
                    append = append + '<div class="col-lg-1 col-xs-1" style="padding-left:0px!important;"><i class="bx bx-2x bx-x pull-left" style="color:red" onclick="closePidAdjustment('+ index +')" id="idClosePid_'+ index +'" name="idClosePid"></i></div>                    '
                  append = append + '</div>'
                append = append + '</div>'
                append = append + '<div class="row">'
                  append = append + '<div class="col-md-6">'
                    append = append + '<div class="form-group">'
                      append = append + '<label>Task <small onclick="showHelp("task")"><i class="bx bx-info-circle"></i></small></label>'
                      append = append + '<select class="form-control" name="selectTask" id="selectTask_'+ index +'"><option></option></select>'
                      append = append + '<span class="invalid-feedback" style="display:none!important">Please select task!</span>'
                    append = append + '</div>'
                  append = append + '</div>'
                  append = append + '<div class="col-md-6">'
                    append = append + '<div class="form-group">'
                      append = append + '<label>Phase <small onclick="showHelp("phase")"><i class="bx bx-info-circle"></i></small></label>'
                      append = append + '<select class="form-control" name="selectPhase" id="selectPhase_'+ index +'"><option></option></select>'
                      append = append + '<span class="invalid-feedback" style="display:none!important">Please select phase!</span>'
                    append = append + '</div>'
                  append = append + '</div>'
                append = append + '</div>'
                append = append + '<div class="form-group">'
                  append = append + '<label>Level <small onclick="showHelp("level")"><i class="bx bx-info-circle"></i></small></label>'
                  append = append + '<select class="form-control" name="selectLevel" id="selectLevel_'+ index +'"><option></option></select>'
                  append = append + '<span class="invalid-feedback" style="display:none!important">Please select Level!</span>'
                append = append + '</div>'
                append = append + '<div class="form-group">'
                  append = append + '<label>Activity*</label>'
                  append = append + '<textarea class="form-control" name="textareaActivity" id="textareaActivity_'+ index +'" onkeyup="validateInput(this)"></textarea> '
                  append = append + '<span class="invalid-feedback" style="display:none!important">Please fill Activity!</span>'
                append = append + '</div>'
                append = append + '<div class="row">'
                  append = append + '<div class="col-md-6">'
                    append = append + '<div class="form-group">'
                      append = append + '<label>Duration</label>'
                        append = append + '<select class="form-control" name="selectDuration" id="selectDuration_'+ index +'" onchange="validateInput(this)"><option></option></select>'
                      append = append + '<span class="invalid-feedback" style="display:none!important">Please select Duration!</span>'
                    append = append + '</div>'
                  append = append + '</div>'
                  append = append + '<div class="col-md-6">'
                    append = append + '<div class="form-group">'
                      append = append + '<label>Status</label>'
                       append = append + '<select class="form-control" name="selectStatus" id="selectStatus_'+ index +'" onchange="validateInput(this)"><option></option></select>'
                      append = append + '<span class="invalid-feedback" style="display:none!important">Please select Status!</span>'
                    append = append + '</div>'
                  append = append + '</div>'
                append = append + '</div>'
                append = append + '<div class="form-group" hidden>'
                  append = append + '<label>exist date</label><input class="form-control" id="existingDate_'+ index +'">'
                append = append + '</div>'
              append = append + '</div>'
            append = append + '</div>'
          append = append + '</div>'
          append = append + '<div class="form-group" style="display:inline;">'
            if (index > 0) {
              append = append + '<button type="button" style="margin-left:5px" class="btn btn-sm btn-danger btn-flat editBtn" id="btn_delete_activity" value="'+ index +'"><i class="bx bx-trash"></i></button>'
            } 

            if (index === result.length - 1) {
              append = append + '<button type="button" style="margin-left:5px" class="btn btn-sm btn-primary btn-flat" id="btn_add_activity" value="'+ index +'"><i class="bx bx-plus"></i></button>'

            }                               
          append = append + '</div>'
        append = append + '</fieldset>'
      })

      $("#ModalAddTimesheet").find("#modal_timesheet").append(append)

      $.each(result,function(index,item){
        setDuration(index)
        setLevel(index)
        setStatus(index)
        setType(index)
        setTask(index,item.task)
        setPhase(index,item.phase)

        if (moment($('#daterange-timesheet').data('daterangepicker').startDate._d).format("YYYY-MM-DD") > moment().format("YYYY-MM-DD")) {
          // $('#scheduleInput_'+index).val("Planned")
          $('#selectDuration_'+index).prev("span").remove()
          $('#selectStatus_'+index).prev("span").remove()
          $('#selectDuration_'+index).prop("disabled",true)
          $('#selectStatus_'+index).prop("disabled",true)
        }else if(moment($('#daterange-timesheet').data('daterangepicker').startDate._d).format("YYYY-MM-DD") <= moment().format("YYYY-MM-DD")){
          // $('#scheduleInput_'+index).val("Unplanned")
          $('#selectDuration_'+index).prev("label").after("<span>*</span>")
          $('#selectStatus_'+index).prev("label").after("<span>*</span>")
          $('#selectDuration_'+index).prop("disabled",false)
          $('#selectStatus_'+index).prop("disabled",false)
        }

        $('#scheduleInput_'+index).val(item.schedule)
        $("#id_activity_"+index).val(item.id)
        $('#textareaActivity_'+index).val(item.activity).trigger('change') 
        $('#selectLevel_'+index).val(item.level).trigger('change')
        $('#selectDuration_'+index).val(item.duration).trigger('change')
        $('#selectStatus_'+index).val(item.status).trigger('change')
        $('#selectType_'+index).val(item.type).trigger('change')

        $("#existingDate_"+index).daterangepicker()

        if ($("#id_activity_"+index).val() != '') {
          $("#existingDate_"+index).data('daterangepicker').setStartDate(moment(item.start_date).format('MM/DD/YYYY')); // Set start date for second daterangepicker
          $("#existingDate_"+index).data('daterangepicker').setEndDate(moment(item.start_date).format('MM/DD/YYYY'));
        }

        if (item.type == "Project") {
          if (item.status_pid == 'true') {
            setPid(item.pid,index)
          }else{
            $("#divPid_"+index).show()
            $("#inputPid_"+index).val(item.pid)
          }
        }else if(item.type == "Approach"){
          setLeadId(item.pid,index)
        }

        if ($('#selectLead_'+index).data('select2')) {
          $('#selectLead_'+index).val(item.pid).trigger('change')
        } 

        if (calEvent) {
          if ($("#id_activity_"+index).val() == calEvent.id) {
            $("#id_activity_"+index).closest(".card-body").show()
            $("#id_activity_"+index).closest(".card-body").prev(".card-header").find("i").removeClass('bx bx-plus').addClass('bx bx-minus')
          }
        }        
      })
    }

    function eventUpdateTimesheet(calEvent,id){
      var start_date = moment($('#daterange-timesheet').data('daterangepicker').startDate._d).format("YYYY-MM-DD")
      if (calEvent != undefined) {
        if (isNaN(calEvent.id) == true) {
          Swal.fire({
            icon: "error",
            title: "Can't Update Now!",
            text: "Please Update after time has started!",
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK',
          })
        }else{
          var start_date = moment(calEvent.start._d).format("YYYY-MM-DD")
          $("#ModalAddTimesheet").modal("show")
          $("#ModalAddTimesheet").find("#modal_timesheet").empty("")
        }
      }  

      if (id != undefined || id != null || id != "") {
        id = id
        $('#daterange-timesheet').prop("disabled",true)
      }else{
        id = ""
        $('#daterange-timesheet').prop("disabled",false)
      }

      $.ajax({
        type:"GET",
        url:"{{url('timesheet/getActivitybyDate')}}",
        data:{
          start_date:start_date,
          nik:nik,
          id:id
        },
        success:function(result){
          if (result.length != 0) {
            $("#ModalAddTimesheet").find('.modal-footer').find(".btn-primary").removeClass("btn-primary").addClass("btn-warning").text('Update')
            $("#ModalAddTimesheet").find("#modal_timesheet").empty("")
            showUpdateTimesheet(result,calEvent,id)
            if (moment($('#daterange-timesheet').data('daterangepicker').startDate._d).format("YYYY-MM-DD") > moment(moment()._d).format("YYYY-MM-DD")) {
              $("select[name='scheduleInput']").val('Planned')
              $("select[name='selectDuration']").prev("span").remove()
              $("select[name='selectStatus']").prev("span").remove()
              $("select[name='selectDuration']").prop("disabled",true)
              $("select[name='selectStatus']").prop("disabled",true)
            }else if(moment($('#daterange-timesheet').data('daterangepicker').startDate._d).format("YYYY-MM-DD") <= moment(moment()._d).format("YYYY-MM-DD")){
              $("select[name='scheduleInput']").val('Unplanned')
              $("select[name='selectDuration']").prev("label").after("<span>*</span>")
              $("select[name='selectStatus']").prev("label").after("<span>*</span>")
              $("select[name='selectDuration']").prop("disabled",false)
              $("select[name='selectStatus']").prop("disabled",false)
            }
          }else{       
            $("#daterange-timesheet").prop("disabled",false)
            $("#ModalAddTimesheet").find('.modal-footer').find(".btn-warning").removeClass("btn-warning").addClass("btn-primary").text('Save')

            if (moment($('#daterange-timesheet').data('daterangepicker').startDate._d).format("YYYY-MM-DD") > moment(moment()._d).format("YYYY-MM-DD")) {
              $("#scheduleInput_0").val('Planned')
              $("select[name='selectDuration']").prev("span").remove()
              $("select[name='selectStatus']").prev("span").remove()
              $("select[name='selectDuration']").prop("disabled",true)
              $("select[name='selectStatus']").prop("disabled",true)
            }else if(moment($('#daterange-timesheet').data('daterangepicker').startDate._d).format("YYYY-MM-DD") <= moment(moment()._d).format("YYYY-MM-DD")){
              $("#scheduleInput_0").val('Unplanned')
              $("select[name='selectDuration']").prev("label").after("<span>*</span>")
              $("select[name='selectStatus']").prev("label").after("<span>*</span>")
              $("select[name='selectDuration']").prop("disabled",false)
              $("select[name='selectStatus']").prop("disabled",false)
            }

            $("#id_activity_0").val('')
            $('#selectType_0').val('').trigger('change').prop("disabled",false)
            $('#selectLead_0').val('').trigger('change').prop("disabled",false)
            $('#selectTask_0').val('').trigger('change').prop("disabled",false)
            $('#selectPhase_0').val('').trigger('change').prop("disabled",false)
            $('#selectLevel_0').val('').trigger('change').prop("disabled",false)
            $('#selectDuration_0').val('').trigger('change')
            $('#selectStatus_0').val('').trigger('change')
            $('#textareaActivity_0').val('').prop("disabled",false)

            $("fieldset:not(:first)").remove()
            if (!$("#fieldset_0").find('.form-group').last().find('#btn_add_activity').length) {
              $("#fieldset_0").find('.form-group').last().append('<button type="button" class="btn btn-sm btn-primary btn-flat" id="btn_add_activity" value="0"><i class="bx bx-plus"></i></button>')
            }

            $("#id_activity_0").closest(".card-body").show()
            $("#id_activity_0").closest(".card-body").prev(".card-header").find("i").removeClass('bx bx-plus').addClass('bx bx-minus')
          }
        }
      })   
    }

    function deleteEvent(startDate){
      swalFireCustom = {
        title: 'Are you sure?',
        text: "Delete all activity on this day!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
      }

      swalSuccess = {
          icon: 'success',
          title: 'Delete Successfully!',
          text: 'Click Ok to reload page',
      } 

      formData = new FormData
      formData.append("_token","{{ csrf_token() }}")
      formData.append("nik",nik)
      formData.append("startDate",startDate)     

      createPost(swalFireCustom,formData,swalSuccess,url="/timesheet/deleteAllActivity",postParam="delete_event",modalName="ModalAddTimesheet")
    }

    function deleteActivity(id,btnId){
      swalFireCustom = {
        title: 'Are you sure?',
        text: "Delete activity!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
      }

      swalSuccess = {
          icon: 'success',
          title: 'Delete Successfully!',
          text: 'Click Ok to reload page',
      } 

      formData = new FormData
      formData.append("_token","{{ csrf_token() }}")
      formData.append("id",id)     

      createPost(swalFireCustom,formData,swalSuccess,url="/timesheet/deleteActivity?id="+btnId,postParam="delete_activity",modalName="ModalAddTimesheet")
    }

    function removeFilter(){
      localStorage.clear()
      loadData()
      $("#timesheet_status").html('<i class="bx bx-filter"></i>&nbspFilter Off')
      $("#timesheet_status").addClass('text-bg-danger')
    }    

    // const apiKey = '{{env("GOOGLE_API_KEY_APP")}}';
    // const calendarId = 'id.indonesian%23holiday@group.v.calendar.google.com';
    // const timeMin = new Date(new Date().setFullYear(new Date().getFullYear() - 1)).toISOString(); // 1 year ago
    // const timeMax = new Date().toISOString();

    // $.ajax({
    //   url:"https://www.googleapis.com/calendar/v3/calendars/id.indonesian%23holiday@group.v.calendar.google.com/events",
    //   data: {
    //     key: apiKey,
    //     timeMin: timeMin,
    //     timeMax: timeMax,
    //     singleEvents: true,
    //     orderBy: 'startTime'
    //   },
    //   success: function(response){
    //     const events = response.items;
    //     if (events.length) {
    //         events.forEach(event => {
    //             const start = event.start.dateTime || event.start.date;
    //             console.log(start + event.summary)
    //         });
    //     } else {
    //         $('#events').append('<p>No past events found.</p>');
    //     }
    //   },
    //   error: function(error) {
    //       console.error('Error fetching events:', error);
    //   }
    // })
  </script>
@endsection