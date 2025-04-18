@extends('template.main_sneat')
@section('tittle')
    Leaving Permite
@endsection
@section('pageName')
    Leaving Permit {{ $year}}
@endsection
@section('head_css')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-fixedcolumns-bs5/fixedcolumns.bootstrap5.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}"/>
  <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmSAQhPWId5Nd6QxE8To4ADjM2a6n0BrqQdisZ/RPUlm0YycDzvNL1HHAh1nKZqI0kSbif+5upQ==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
  <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
  <style type="text/css">
    .flatpickr-day.flatpickr-disabled.hari_libur {
      color: red !important;
    }

    #info_libur{
      text-align: left;
      padding-left: 15px;
    }

    .swal-wide{
        width:850px !important;
    }
    
    #tooltip{
      display: none!important;
      position: absolute;
      cursor: pointer;
      left: 100px;
      top: 35px;
      border: solid 1px #eee;
      background-color: #ffffdd;
      padding: 20px;
      z-index: 1000;
    }

    time.icon
    {
      font-size: 1em;
      display: block;
      position: relative;
      width: 10em;
      height: 10em;
      background-color: #fff;
      border-radius: 0.6em;
      card-shadow: 0 1px 0 #bdbdbd, 0 2px 0 #fff, 0 3px 0 #bdbdbd, 0 4px 0 #fff, 0 5px 0 #bdbdbd, 0 0 0 1px #bdbdbd;
      overflow: hidden;
    }

    time.icon *
    {
      display: block;
      width: 100%;
      font-size: 1em;
      font-weight: bold;
      font-style: normal;
      text-align: center;
    }

    time.icon strong
    {
      position: absolute;
      top: 0;
      padding: 0.4em 0;
      color: #fff;
      background-color: #f7024c;
      border-bottom: 1px dashed #ffffff;
      card-shadow: 0 2px 0 #ffffff;
    }

    time.icon em
    {
      position: absolute;
      bottom: 0.2em;
      color: #f7024c;
    }

    time.icon span
    {
      font-size: 3em;
      letter-spacing: -0.05em;
      padding-top: 0.8em;
      color: #2f2f2f;
    }

    .dataTables_paging {
      display: none!important;
    }

/*    .nav-tabs .badge{
      position: absolute;
      top: -10px;
      right: -10px;
      background: red;
    }*/

    .pull-right{
      float: right;
    }

    .pull-left{
      float: left;
    }

    .form-group{
      margin-bottom: 15px;
    }
  </style>
@endsection
@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <section class="content">
    	@if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
       @endif

      {{-- <div class="card">
        <div class="card-header with-border">
          <h6 class="card-title">Hari Libur Nasional Tahun {{$year}}</h6>
          <div class="card-tools pull-right">
            <i class="bx bx-fw bx-lg bx-chevron-left field-icon toggle-arrow"></i>
          </div>
        </div>
          <div class="card-body div-libur" style="display: none!important;"></div>
      </div> --}}

      <div class="card">
        <div class="card-header">
          <div class="pull-right">
            @if($cek_cuti->status_karyawan == 'cuti')
              @if($total_cuti > 0)
              	@if($cek->status == null)
                  <button type="button" class="btn btn-md text-bg-dark pull-right add_cuti" value="{{Auth::User()->nik}}" style="margin-left: 10px;width: 120px">
                    <i class="bx bx-plus" style="margin-right: 5px"> </i> Permission
                  </button>
                  <button class="btn btn-md text-bg-danger show-sisa-cuti" style="width: 150px">
                    Show Sisa Cuti
                  </button>
  	            @elseif($cek_cuti->status == 'v' || $cek_cuti->status == 'd' || $cek_cuti->status == 'c')
      	          <button type="button" class="btn btn-md text-bg-dark pull-right add_cuti" value="{{Auth::User()->nik}}" style="margin-left: 10px;width: 120px">
                    <i class="bx bx-plus" style="margin-right: 5px"> </i> Permission
                  </button>
    	            <button class="btn btn-md text-bg-danger show-sisa-cuti" style="width: 150px">
                    Show Sisa Cuti
                  </button>
  	            @else
                  <button type="button" class="btn btn-md text-bg-dark pull-right disabled disabled-permission" style="margin-left: 10px;width: 100px">
                    <i class="bx bx-plus" style="margin-right: 5px"> </i> Permission
                  </button>
              	@endif
              @else
                <button type="button" class="btn btn-md text-bg-dark pull-right disabled disabled-permission" style="margin-left: 10px;width: 100px">
                  <i class="bx bx-plus" style="margin-right: 5px"> </i> Permission
                </button>
              @endif
            @endif
              
            <!-- <a href="{{action('HRGAController@cutipdf')}}" target="_blank" onclick="print()">
              <button class="btn btn-md btn-danger disabled" style="width: 120px">
                <i class="bx bx-file-pdf-o" style="margin-right: 5px"></i>Preview PDF
              </button>
            </a>  -->
            <button class="btn btn-md text-bg-primary" id="btnConfigPublicHoliday" style="margin-left: 10px;display: none!important;">
              <i class="bx bx-plus" style="margin-right: 5px"></i>Public Holiday (tambahan)
            </button>
           <!--  <button class="btn btn-md text-bg-primary" id="btnSetCuti" style="margin-left: 10px; display: none!important;" data-bs-toggle="modal" data-bs-target="#setting_cuti">
              <i class="bx bx-wrench" style="margin-right: 5px"></i>Total Cuti
            </button> -->
            <select class="form-control text-bg-info pull-left" style="width: 100px; margin-right: 10px; display: none!important;" id="filter_com">
              <option value="all">All</option>
              <option value="1">SIP</option>
              <option value="2">MSP</option>
            </select>
          </div>
        </div>

        <div class="card-body">         
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" style="margin-top: 10px" id="cutis">
              <li class="nav-item">
                <a class="nav-link" style="display: none!important;" href="#bos" id="tab-list-cuti" data-bs-toggle="tab" onclick="changeTabs('all_lis')">List Cuti Karyawan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="#cuti" id="cuti_tab" data-bs-toggle="tab" onclick="changeTabs('request')">
                  <span class="d-none d-sm-inline-flex align-items-center">
                    Request Cuti {{$bulan}}
                    <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1_5 count_cuti"></span>
                  </span>
                </a>
              </li>
              <li class="nav-item">
                {{-- @if("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','People Operations & Services Manager')->exists()}}")
                  <a class="nav-link" href="#staff" data-bs-toggle="tab" onclick="changeTabs('report_')">Report Cuti</a>
                @else
                  <a class="nav-link" href="#staff" data-bs-toggle="tab" onclick="changeTabs('history')">History Cuti</a>
                @endif --}}
                  <a class="nav-link" href="#staff" data-bs-toggle="tab" onclick="changeTabs('history')">History Cuti</a>
              </li>
            </ul>

            <div class="tab-content">
              <div class="tab-pane" id="bos"> 
                <div class="table-responsive">
                  <table class="table table-bordered table-striped dataTable" id="datatables" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th rowspan="2"><center>Employees Name</center></th>
                        <th rowspan="2"><center>Email</center></th>
                        <th rowspan="2"><center>Division</center></th>
                        <th rowspan="2"><center>Tanggal Masuk Kerja</center></th>
                        <th rowspan="2"><center>Lama Bekerja</center></th>
                        <th rowspan="2"><center>Cuti sudah diambil</center></th>
                        <th colspan="2"><center>Sisa Cuti</center></th>
                      </tr>
                        <tr>
                          {{-- <th>{{$tahun_lalu}}<small>(*s/d 31 maret {{$tahun_ini}})</small></th> --}}
                          <th>{{$tahun_lalu}}</th>
                          <th>{{$tahun_ini}}</th>
                        </tr>
                    </thead>
                    <tbody id="all_cuti" name="all_cuti">
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="tab-pane show active" id="cuti">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped dataTable" id="datatablew" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Employees Name</th>
                        <th>Role</th>
                        <th id="col-cuti-request">Cuti Request</th>
                        <th>Request Date</th>
                        <!-- <th>Date of Request</th>
                        <th>Time Off</th> -->
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="tab-pane" id="staff">
                <div class="row" style="margin-bottom: 10px; display: none!important;" id="div_filter">
                  <div class="col-md-12 ms-auto pull-right" style="display: flex;gap: 3;">
                    <div class="input-group date" style="width: 300px;margin-left: 15px;float: right;">
                      <div class="input-group-text">
                        <i class="bx bx-calendar"></i>
                      </div>
                      <input type="text" class="form-control" id="datesReport" name="dates">
                    </div>

                    <div  class="input-group date disabled" style="width: 300px;margin-left: 15px;float: right;">
                      <div class="input-group-text">
                        <i class="bx bx-filter"></i>
                      </div>
                      <select class="form-control" id="division_cuti" name="division_cuti">
                        <option value="alldeh">ALL DIVISION</option>
                        @foreach($division as $data)
                          @if($data->id_division != 'NULL')
                            @if($data->id_division == '-')
                              <option value="{{$data->id_division}}">WAREHOUSE</option>
                            @else
                              <option value="{{$data->id_division}}">{{$data->id_division}}</option>
                            @endif
                          @endif
                        @endforeach
                      </select>
                    </div>

                    <button class="btn btn-md text-bg-success" style="float: left;margin-left: 15px" onclick="exportExcel()">&nbspExport to <i class="bx bx-download"></i></button>
                    </div>
                  
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped dataTable" id="datatableq" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Employees Name</th>
                        <th>Role</th>
                        <th>Request Date</th>
                        <th>Dates</th>
                        <th>Approved Date</th>
                        <th>Approved By</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody id="report" name="report">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

    <!--MODAL ADD-->  
    <div class="modal fade" id="modalCuti" role="dialog">
      <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content modal-md">
          <div class="modal-header">
            <h6 class="modal-title">Leaving Permit</h6>
          </div>
          <div class="modal-body">
              @csrf
              <form id="form-submit-cuti">
              <div class="form-group" style="display: none!important">
                <label>Sisa Cuti : </label>
                <span name="sisa_cuti" id="sisa_cuti"></span><!-- 
                <input type="text" name="sisa_cuti" id="sisa_cuti" style="width: 50px;color: black;text-decoration: bold" class="form-control sisa_cuti" value="" disabled=""> -->
              </div>
              <div class="row">
                <div class="col-md-9">
                  <div class="form-group">
                      <label>Date</label>
                      <div class="input-group date form-group">
                        <input type="text" class="form-control" id="date_start" name="date_start" autocomplete="Off" required>
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i><span class="count"></span></span>
                      </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                      <label>Available Days</label>
                      <input type="text" class="form-control" id="avaliableDays" disabled="true">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Jenis Cuti</label><br>
                  <input type="radio" name="jenis_cuti" value="tahunan" required=""> Tahunan<br>
                  <input type="radio" name="jenis_cuti" value="melahirkan"> Melahirkan<br>
                  <input type="radio" name="jenis_cuti" value="other"> Other<br> 
              </div>

              <div id="tooltip">
              Anda melewati batas sisa cuti!
              </div>

              <div class="form-group">
                  <label>Note</label>
                  <textarea class="form-control" type="text" id="reason" name="reason"></textarea>
              </div>

              <input type="" name="lihat_hasil" id="lihat_hasil" class="lihat_hasil" hidden>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class=" bx bx-times"></i>&nbspClose</button>
               <!--  <button type="submit" class="btn btn-primary" id="btn-save" value="add"  data-bs-dismiss="modal" >Submit</button>
                <input type="hidden" id="lead_id" name="lead_id" value="0"> -->
                <button type="button" class="btn btn-primary btn-submit disabled" data-placement="top" id="btn-submit"><i class="bx bx-check"> </i>&nbspSubmit</button>
              </div>
              </form>
          </div>
        </div>
      </div>
    </div>

    @foreach($cuti as $data)
    @if(Auth::User()->nik == $data->nik)
    <!--MODAL EDIT-->  
    <div class="modal fade" id="modalCuti_edit" role="dialog">
      <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title">Leaving Permit</h6>
          </div>
          <div class="modal-body">
              @csrf
              <input type="" name="id_cuti" id="id_cuti" value="" hidden>

              <div class="form-group">
                  <label>Reason For Leave</label>
                  <textarea class="form-control" type="text" id="reason_edit" name="reason_edit" required></textarea>
              </div>  

              <div class="form-group">
                  <label>Date Off Before</label>

                  <div class="input-group date form-group" id="datepicker">
                    <input type="text" class="form-control" id="Dates_update" name="Dates" autocomplete="off" placeholder="Select days" disabled/>
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i><span class="count"></span></span>
                  </div> 
              </div> 

              <div class="form-group">
                  <label>Date Off After</label>
                  <div class="input-group date form-group" id="datepicker">
                    <input type="text" class="form-control" id="Dates" name="Dates" id="date-tooltip" data-toggle="tooltip" title="Jumlah hari yang kamu masukkan melebihi Date Off Before!" autocomplete="off" placeholder="Select days" required />
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i><span class="count"></span></span>
                  </div> 
              </div>
               
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
                <button type="submit" class="btn btn-primary btn-sm btn-submit-update" id="btn-submit-update"><i class="fa fa-check"> </i>&nbspSubmit</button>
              </div>
          </div>
        </div>
      </div>
    </div>
    @endif
    @endforeach

    <!--Modal Detail-->
    <div class="modal fade" id="detail_cuti" role="dialog">
        <div class="modal-dialog modal-md">
          <!-- Modal content-->
          <div class="modal-content modal-md">
            <div class="modal-header">
              <h6 class="modal-title">Leaving Permit</h6>
            </div>
            <div class="modal-body">
                <input type="" name="id_cuti_detil" id="id_cuti_detil" hidden="">
                <input type="" name="nik_cuti" id="nik_cuti" hidden="">
                <div class="form-group">
                    <label>Date Of Request</label>
                    <input type="text" class="form-control" id="date_request_detil" name="date_request_detil" disabled>
                </div>

                <div class="form-group">
                    <label>List Request Date Off<i style="color: red">(mark date for approve)</i></label>
                    <table class="table table-bordered" id="detil_cuy" style="margin-top: 10px">
                      <tbody id="tanggal_cuti" class="tanggal_cuti">
                        
                      </tbody>
                    </table>

                    <input type="text" id="cuti_fix" name="cuti_fix" hidden>
                    <input type="text" id="cuti_fix_accept" name="cuti_fix_accept" hidden> 
                    <input type="text" id="cuti_fix_reject" name="cuti_fix_reject" hidden> 
                </div>

                <div class="form-group" style="display: none!important;" id="alasan_reject">
                  <span style="color: red"><sup>*harus diisi</sup></span>
                  <label>Notes Reject Cuti (Pengurangan tanggal cuti)</label>
                  <textarea class="form-control" class="reason_reject" name="reason_reject" id="reason_reject" rows="5" style="resize: none;overflow-y: auto;"></textarea>
                </div>

                <div class="form-group">
                    <label>Jenis Cuti/Keterangan</label>
                    <textarea class="form-control" type="text" id="reason_detil" name="reason_detil" disabled rows="5" style="resize: none;overflow-y: auto;"></textarea>
                </div>      
                 
                <div class="modal-footer">
                  <button type="submit" id="submit_approve" disabled class="btn btn-success"><i class=" fa fa-check"></i>&nbspApprove</button>
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
                </div>
            </div>
          </div>
        </div>
    </div>


    <!--Modal Detail-->
    <div class="modal fade" id="details_cuti" role="dialog">
        <div class="modal-dialog modal-md">
          <!-- Modal content-->
          <div class="modal-content modal-md">
            <div class="modal-header">
              <h6 class="modal-title">Detail Leaving Permit</h6>
            </div>
            <div class="modal-body">
              <form>
                @csrf
                <input type="" name="id_cuti_detil" hidden="">
                <div class="form-group">
                    <label>Date Of Request</label>
                    <input type="text" class="form-control" id="date_request_detils" name="date_request_detil" disabled>
                </div>

                <div class="form-group">
                    <label>List Request Date Off</label>
                      <table class="table table-bordered" style="margin-top: 10px">
                        <tbody id="tanggal_cutis" class="tanggal_cuti">
                          
                        </tbody>
                      </table>
                </div>
                
                <div class="form-group">
                    <label>Jenis Cuti/Keterangan</label>
                    <textarea class="form-control" type="text" id="reason_detils" name="reason_detil" disabled rows="5" style="resize: none;overflow-y: auto;"></textarea>
                </div>   

                <div class="form-group" style="display: none!important;" id="alasan_reject_detail">
                	<label>Notes <span style="color: red">(Pengurangan jumlah cuti)</span></label>
                	<textarea class="form-control" class="reason_reject" disabled="" id="reason_reject_detil" rows="5" style="resize: none;overflow-y: auto;"></textarea>
                </div>
   
                 
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class=" bx bx-times"></i>&nbspClose</button>
                </div>
            </form>
            </div>
          </div>
        </div>
    </div>

    <!--Modal Set Total Cuti-->
    <div class="modal fade" id="setting_cuti" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title">Setting Penggunaan Cuti</h6>
          </div>
          <div class="modal-body">
            <!-- <form method="POST" action="{{url('/set_total_cuti')}}">
                @csrf
                <div class="form-group">
                    <label>Masukkan Pengurangan Jatah Cuti Tahun ini (optional)</label>
                    <input type="" name="pengurangan_cuti" id="pengurangan_cuti" class="form-control" style="width: 60px">
                </div>
                <button class="btn btn-primary btn-xs" style="width: 60px">Submit</button>
                <button type="button" class="btn btn-outline-secondary btn-xs" data-bs-dismiss="modal" style="width: 60px"><i class=" fa fa-times"></i>&nbspClose</button>
            </form> -->
            <form method="POST" action="{{url('/setting_total_cuti')}}">
            <div class="form-group">
                <label>Masukkan Pengurangan Jatah Cuti Tahun ini (optional)</label>
                <input type="" name="pengurangan_cuti" id="pengurangan_cuti" class="form-control" style="width: 60px">
            </div>
          </div>
          <div class="modal-body">
            @csrf
              <div class="form-group" style="margin-top: 20px">
                <div class="row">
                  <div class="col-md-4">
                    <label>Employees</label>
                      <select class="form-control users" id="users" name="users" style="width: 100%!important">
                        <option value="all_emp">All Employees</option>
                        @foreach($owner as $data)
                          @if($data->status_karyawan != 'dummy')
                          <option value="{{$data->nik}}">{{$data->name}}</option>
                          @endif
                        @endforeach
                      </select>
                      <label >Status Karyawan</label>
                      <select class="form-control users" id="status" name="status" style="width: 100%!important" required>
                        <option selected="" disabled="">Pilih Status!</option>
                        <option value="belum_cuti">1 tahun</option>
                        <option value="cuti"> < 1 tahun</option>
                      </select>
                  </div>
                  <div class="col-md-4">
                    <label>Lama Kerja</label>
                    <input readonly="" type="" name="lama_kerja" id="lama_kerja" class="form-control">
                    <label>Tahun Masuk Kerja</label>
                    <input readonly="" type="" name="tahun_masuk" id="tahun_masuk" class="form-control">
                  </div>
                  <div class="col-md-2">
                    <label>Sisa Cuti</label>
                    <input type="" readonly="" name="current_cuti" id="current_cuti" class="form-control" style="width: 60px">
                  </div>
                  <div class="col-md-2">
                    <label>Set Cuti</label>
                    <input type="" name="set_cuti" id="set_cuti" class="form-control" style="width: 60px">
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary btn-xs">Submit</button>
            <button type="button" class="btn btn-outline-secondary btn-xs" data-bs-dismiss="modal" style="width: 60px"><i class=" fa fa-times"></i>&nbspClose</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="config_cuti" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title">Config Cuti</h6>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{url('/setting_total_cuti')}}">
            <div class="form-group">
                <label>Masukkan Tanggal Cuti (Public Holiday) Tambahan Tahun ini</label>
                <input type="" name="cuti_tambahan" id="cuti_tambahan" class="form-control">
            </div>
            <div class="form-group">
              <label>Description</label>
              <textarea class="form-control" id="description_addition_cuti" style="resize: vertical;"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i>&nbspClose</button>
            <button type="submit" class="btn btn-success" onclick="submitConfigCuti()"><i class="fa fa-check"></i>&nbsp Submit</button>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="reason_decline" role="dialog">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title">Decline Information</h6>
            </div>
            <div class="modal-body">
              <!-- <form method="POST" action="{{url('/decline_cuti')}}" id="reason_decline" name="reason_decline"> -->
                @csrf
              <input type="" name="id_cuti_decline" id="id_cuti_decline" hidden>
              <div class="form-group">
                <label for="sow">Decline reason</label>
                <textarea name="keterangan" id="keterangan" class="form-control" required="" rows="5" style="resize: none;overflow-y: auto;"></textarea>
              </div>
            <!-- </form> -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i>&nbspClose</button>
              <button type="button" class="btn btn-success-absen" onclick="submitDecline()"><i class="fa fa-check"></i>&nbsp Decline</button>
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="decline_reason" role="dialog">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title">Decline Information</h6>
            </div>
            <div class="modal-body">
              <form method="" action="" id="decline_reason" name="decline_reason">
                @csrf
              <div class="form-group">
                <label for="sow">Decline reason</label>
                <textarea name="keterangan_decline" id="keterangan_decline" class="form-control" readonly rows="5" style="resize: none;overflow-y: auto;"></textarea>
              </div>
            </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i>&nbspClose</button><!-- 
              <button type="submit" class="btn btn-success-absen"><i class="fa fa-check"></i>&nbsp Decline</button> -->
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="tunggu" role="dialog">
      <div class="modal-dialog modal-sm">
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-body">
            <div class="form-group">
              <div class="">Sedang memproses. . .</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="announcement" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                    <h6 class="modal-title">Announcement</h6>
                </div>
                <div class="modal-body">
                    <h6 class="box-title text-center">
                        <b><i>Announcement</i></b>
                    </h6>
                    <div class="row">
                        <div class="col-md-12">
                            <h6>
                                Sehubungan dengan kebijakan baru terkait penggunaan cuti, kami ingin menginformasikan hal-hal berikut:
                            </h6>
                            <br>
                            <h6>
                                <b>Batas Waktu Pengajuan Cuti</b>: Jika mengajukan permohonan cuti sebelum tanggal 31 Maret 2025, namun tanggal cuti yang diminta jatuh setelah tanggal 31 Maret 2025, maka pemotongan cuti akan diambil dari cuti tahun berjalan.

                            </h6>
                            <br>
                            <h6>
                                <b>Penting untuk Diperhatikan</b>: Pastikan untuk mengajukan cuti sesuai dengan kebijakan yang berlaku dan memperhatikan tanggal permohonan serta tanggal cuti yang diminta agar tidak terjadi kekeliruan dalam pemotongan hari cuti.
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptImport')
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('script')
<script type="text/javascript">

    var liburNasionalException = []

    $(document).ready(function(){
      var accesable = @json($feature_item);
      accesable.forEach(function(item,index){
        $("#" + item).show()
      })
      if (accesable.includes('col-cuti-request')) {
        var column = monthCuti.column(2).header();
        $(column).text('Cuti Request');
        var column2 = monthCuti.column(3).header();
        $(column2).text('Request Date');
      }else{
        var column = monthCuti.column(2).header();
        $(column).text('Date of Request');
        var column2 = monthCuti.column(3).header();
        $(column2).text('Time Off');
      }

      $("#announcement").modal("show");
    })

    function submitConfigCuti(){
      date_tambahan = []
      date_tambahan.push($("#cuti_tambahan").val().split(','))
      formData = new FormData
      formData.append("_token","{{ csrf_token() }}") 
      formData.append("cuti_tambahan",JSON.stringify($("#cuti_tambahan").val().split(',')))
      formData.append("description",$("#description_addition_cuti").val())

      swalFireCustom = {
        title: 'Are you sure?',
        text: "Save this Additional Public Holiday!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
      }

      Swal.fire(swalFireCustom).then((resultFire) => {
        if (resultFire.value) {
          $.ajax({
            type:"POST",
            url:"{{url('/storeCutiAddition')}}",
            processData: false,
            contentType: false,
            data:formData,
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
                Swal.fire({
                  icon: 'success',
                  title: 'Adding Public Holiday Succesfully!',
                  text: 'Click Ok to reload page',
                }).then((result,data) => {
                  if (result.value) {
                    location.reload()              
                  }
                })
            }
          })
        }
      }) 
    }

    $.ajax({
      type:"GET",
      url:"https://www.googleapis.com/calendar/v3/calendars/en.indonesian%23holiday%40group.v.calendar.google.com/events?key={{env('GOOGLE_API_KEY_APP')}}",
      // url:"https://www.googleapis.com/calendar/v3/calendars/en.indonesian%23holiday%40group.v.calendar.google.com/events?key=AIzaSyB0MWK6KLjhJlY7cL7G6STOCVGnxzjapXU",
      success: function(resultGoogle){
        $(".show-sisa-cuti").click(function(){
          $.ajax({
            type:"GET",
            url:"getCutiAuth",
            success: function(result){
              var year_before = new Date().getFullYear() - 1;
              var year_now = new Date().getFullYear();
              var swal_html = ''
              
              swal_html = swal_html + '<div class="panel" style="background:aliceblue;font-weight:bold">'
              swal_html = swal_html + '  <div class="panel-heading panel-info text-center btn-info">'
              swal_html = swal_html + '    <b>Berikut Info total cuti : </b>'
              swal_html = swal_html + '  </div>'
              swal_html = swal_html + '  <div class="panel-body">'
              swal_html = swal_html + '    <table class="text-center">'
              swal_html = swal_html + '      <b>'
              swal_html = swal_html + '        <p style="font-weight:bold">Total cuti ' + year_before + ' (*digunakan s/d 31 Maret) : ' + result[0].cuti + '</p>'
              swal_html = swal_html + '        <p style="font-weight:bold">Total cuti ' + year_now + ' : ' + result[0].cuti2 + '</p>'
              swal_html = swal_html + '      </b>'
              swal_html = swal_html + '    </table>'
              swal_html = swal_html + '  </div>'
              swal_html = swal_html + '  </div>'
              swal_html = swal_html + '</div>'

              // INFORMASI LIBUR NASIONAL DI BUTTON SISA CUTI

              // swal_html = swal_html + '<div class="panel" style="background:LavenderBlush;font-weight:bold">'
              // swal_html = swal_html + '  <div class="panel-heading panel-danger text-center btn-danger">'
              // swal_html = swal_html + '    <b>Informasi Libur Nasional </b>'
              // swal_html = swal_html + '  </div>'
              // swal_html = swal_html + '  <div class="panel-body">'
              // swal_html = swal_html + '    <table>'
              // swal_html = swal_html + '      <b>'

              // $.each(resultGoogle.items,function(key,value){
              //   if(value.description == "Public holiday" && value.start.date.includes(year_now) && !(value.summary.includes("Joint Holiday"))){
              //     if(!liburNasionalException.includes(value.start.date)){
              //       swal_html = swal_html + '        <p style="font-weight:bold">' + value.summary + ' <br>(' + moment( value.start.date).format("L") + ')</p>'
              //     }
              //   }
              // })

              // swal_html = swal_html + '      </b>'
              // swal_html = swal_html + '    </table>'
              // swal_html = swal_html + '  </div>'
              // swal_html = swal_html + '  </div>'
              // swal_html = swal_html + '</div>'
              swal.fire({title: "Hai, " + result[0].name, html: swal_html})
            },
          });
        });
        
      }
    })
    

    // var tables = $('#datatables').DataTable();
    // var tablew = $("#datatablew").DataTable({
    //   "columnDefs":[
    //         {"width": "20%", "targets":0},
    //         {"width": "10%", "targets":2},
    //         {"width": "10%", "targets":3},
    //         {"width": "10%", "targets":4},
    //        ],
    //     "order": [[ "4", "desc" ]],
    // });

    var table  = $('#datatable').DataTable({
       "columnDefs":[
            {"width": "30%", "targets":0},
            {"width": "10%", "targets":2},
            {"width": "10%", "targets":3},
            {"width": "10%", "targets":4},
           ],
        "order": [[ "2", "desc" ]],
        "scrollX":true,
        // // "bPaginate": false,
        // "pageLength": 25,
        // "paging": false,
         // "bFilter": false,
    });

    $(".users").select2();

    $("#date_end").on("change",function(e){
      var start = $('#date_start').flatpickr('getDate');
      var end = $('#date_end').flatpickr('getDate');
      if (!start || !end) return;
      var days = (end - start) / 1000 / 60 / 60 / 24;
      $('#lihat_hasil').val(e.dates.length);
    });

    $(".add_cuti").click(function(){
      $.ajax({
        type:"GET",
        url:"getCutiUsers",
        data:{
          nik:this.value,
        },
        success: function(result){
          $("#form-submit-cuti").trigger("reset");
          if (result.parameterCuti[0].total_cuti == 0) {
            $("#sisa_cuti").text(0).style.color = "#ff0000";
          } else {
            $("#sisa_cuti").text(result.parameterCuti[0].total_cuti);
            if (result.parameterCuti[0].total_cuti > 5) {
              document.getElementById("sisa_cuti").style.color = "blue";
            } else {
              document.getElementById("sisa_cuti").style.color = "#ff0000";
            }
          }

          var disableDate = []
          $.each(result.allCutiDate,function(key,value){
            disableDate.push(moment(value).format("L"))
          })

          $.each(hari_libur_nasiona_tambahan,function(key,value){
            disableDate.push(value)
          })

          if(result.shiftingUser){
            var daysOfWeekDisabled = ""
            var daysOfWeekHighlighted = []
          } else {
            var daysOfWeekDisabled = "0,6"
            var daysOfWeekHighlighted = [0,6]
          }

          const formattedDisableDate = disableDate.map(date => moment(date, "MM/DD/YYYY").format("YYYY-MM-DD"));
          const formattedLiburNasional = hari_libur_nasional.map(date => moment(date, "MM/DD/YYYY").format("YYYY-MM-DD"));

          changeMonth = true
          flatpickr("#date_start", {
              mode: "multiple", // Enable multi-date selection
              dateFormat: "d/m/Y", // Equivalent to moment().format("L")
              minDate: "today", // Start date from today
              disableMobile: true, // Ensures proper UI on mobile
              weekNumbers: true, // Shows week numbers
              locale: {
                firstDayOfWeek: 1 // Week starts on Monday
              },
              disable: [
                function(date) {
                  const formatted = moment(date).format("YYYY-MM-DD");
                  return formattedDisableDate.includes(formatted) ||
                  formattedLiburNasional.includes(formatted) ||
                  daysOfWeekDisabled.includes(date.getDay())
                }
              ],
              // Styling and tooltip on each day
              onDayCreate: function(dObj, dStr, fp, dayElem) {
                const date = dayElem.dateObj;
                const formatted = moment(date).format("YYYY-MM-DD");
                const formattedL = moment(date).format("L");

                // Add tooltip and styling for national holidays
                if (formattedLiburNasional.includes(formatted)) {
                  dayElem.classList.add("hari_libur");
                  dayElem.setAttribute("title", hari_libur_nasional_tooltip[hari_libur_nasional.indexOf(formattedL)] || "Hari Libur Nasional");
                }

                // Add tooltip and styling for personal leave
                if (formattedDisableDate.includes(formatted)) {
                  dayElem.classList.add("cuti_pribadi");
                  dayElem.setAttribute("title", "Cuti Pribadi");
                }
              },
              onChange: function(selectedDates, dateStr, instance) {
                  $("#lihat_hasil").val(selectedDates.length);
                  
                  let cutis = parseFloat($("#sisa_cuti").text());
                  let cutiss = parseFloat($(".lihat_hasil").val());

                  $("#avaliableDays").val(result.parameterCuti[0].total_cuti - cutiss);

                  if (selectedDates.length > 0) {
                      if (cutis >= cutiss) {
                          $(".btn-submit").removeClass("disabled");
                          $("#tooltip").hide();
                      } else {
                          $(".btn-submit").addClass("disabled");
                          $("#tooltip").show();
                      }
                  } else {
                      $(".btn-submit").addClass("disabled");
                      $("#tooltip").show().text("Mohon untuk menginput tanggal cuti Anda!");
                  }
              },
              onMonthChange: function(selectedDates, dateStr, instance) {
                changeMonth = false;
                
                // `instance.currentYear` and `instance.currentMonth` are available
                const currentDate = new Date(instance.currentYear, instance.currentMonth, 1);
                showKeteranganLibur(currentDate); // or use custom handling
              },
              onOpen: function(selectedDates, dateStr, instance) {
                const container = instance.calendarContainer;

                // Append info container if not already there
                if (!container.querySelector('#info_libur')) {
                  const infoDiv = document.createElement('div');
                  infoDiv.id = 'info_libur';
                  infoDiv.style = 'margin-top: 4px; color: #ff0000; max-width: 100%;';
                  container.appendChild(infoDiv);
                }

                if (changeMonth) {
                  const currentDate = new Date(instance.currentYear, instance.currentMonth, 1);
                  showKeteranganLibur(currentDate);
                }
              }
          });

        },
      });

      function showKeteranganLibur(date){
        const array = hari_libur_nasional_2;

        const array_combine = hari_libur_nasional_combine_tooltip

        const substring = moment(date).format("MM/YYYY");
        $('#info_libur').empty()

        array_combine.forEach(function(item){
          if (item.date.includes(substring)) {               
            $('#info_libur').append('<b>'+item.date+' - '+item.summary+'</b><br>')
          }
        })
      }

      $("#modalCuti").modal("show");

      $(document).on('click',"button[id^='btn-submit']",function(e){
          if($("input[name='jenis_cuti']:checked").val()){
            Swal.fire({
            title: 'Are you sure?',
            text: "Submit your leaving permit",
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
                  url:"{{url('/store_cuti')}}",
                  data:{
                     _token: "{{ csrf_token() }}",
                    reason:$("#reason").val(),
                    jenis_cuti:$("input[name='jenis_cuti']:checked").val(),
                    date_start:$("#date_start").val(),
                    reason_edit:$("#reason_edit").val(),
                    status_update:'R',
                  },
                  success: function(result){
                    Swal.showLoading()
                    Swal.fire(
                      'Successfully!',
                      'Leaving permit has been created.',
                      'success'
                    ).then((result) => {
                      if (result.value) {
                        $("#modalCuti").modal('hide');
                      }
                    }),setTimeout(function(){
                      $('#datatablew').DataTable().ajax.url("{{url('get_cuti_byMonth')}}").load();
                    },2000);
                  }
                })
              }else if(result.dismiss === Swal.DismissReason.cancel){
                $("#modalCuti").modal('hide');
              }
            }) 
          }else{
            // $("input[name='jenis_cuti']").prop('required',true);
            Swal.fire(
              'canceled',
              'Silahkan pilih jenis cuti lebih dahulu!',
              'error'
              )
          }
      })
    })

    $("#btnConfigPublicHoliday").click(function(){
      var disableDate = []

      $.each(hari_libur_nasiona_tambahan,function(key,value){
        disableDate.push(value)
      })

      $.each(hari_libur_nasional,function(key,value){
        disableDate.push(value)
      })

      $('#cuti_tambahan').flatpickr({
        weekStart: 1,
        // daysOfWeekDisabled: daysOfWeekDisabled,
        // daysOfWeekHighlighted: daysOfWeekHighlighted,
        todayHighlight: true,
        multidate: true,
        datesDisabled: disableDate,
        beforeShowDay: function(date){
          var index = hari_libur_nasional.indexOf(moment(date).format("L"))
          if(index > 0){
            return {
              // enabled: false,
              tooltip: hari_libur_nasional_tooltip[index],
              classes: 'hari_libur'
            };
          } else if(disableDate.indexOf(moment(date).format("L")) > 0) {
            return {
              enabled: false,
              tooltip: 'Cuti Pribadi',
            };
          } 

          if ($.inArray(moment(date).format("YYYY-MM-DD"), disableDate) !== -1) {
            return {
              enabled: false,
              classes: 'hari_libur',
            };
          }
        },
      })

      // $("#cuti_tambahan").flatpickr({
      //   multidate: true,
      // })

      $("#config_cuti").modal("show")
    })

    $(document).on('click',"button[class^='approve_date']",function(e) {
        $.ajax({
          type:"GET",
          url:'{{url("/detilcuti")}}',
          data:{
            cuti:this.value,
          },
          success: function(result){
                var table = "";

                var date_default = []

              $.each(result[0], function(key, value){
                  $("#id_cuti_detil").val(value.id_cuti);
                  $("#nik_cuti").val(value.nik);
                  $("#date_request_detil").val(moment(value.date_req).format('LL'));
                  $("#reason_detil").val(value.reason_leave);
                  $("#time_off").val(value.days);
                  $('#tanggal_cuti').empty();

                  table = table + '<tr>';
                  table = table + '<td width="5%">' + '<input type="checkcard" class="check_date" name="check_date[]"' +'</td>';
                  table = table + '<td hidden>' + value.idtb_cuti_detail +'</td>';
                  table = table + '<td>' + moment(value.date_off).format('LL'); +'</td>';
                  table = table + '</tr>';
                  
                  date_default.push(value.idtb_cuti_detail)
                  $("#cuti_fix_reject").val(date_default)
                });                

                var date_check = result[0].length;

                $('#tanggal_cuti').append(table);

                var countChecked = function() {
                var n = $( ".check_date:checked" ).length;

                if ($(".check_date:checked" ).length < 1) {
                  $("#submit_approve").prop("disabled",true);
                  $("#reason_reject").prop('required',true);
                  $("#alasan_reject").css("display", "block");                  
                }else{
                  if ($(".check_date:checked" ).length == result[0].length) {
                    $("#alasan_reject").css("display", "none");
                  }else{
                    $("#alasan_reject").css("display", "block");
                  }
                  $("#submit_approve").prop("disabled",false);
                  $("#reason_reject").prop('required',false);
                }
              };
              // countChecked();
             
              $(".check_date").on("click", function(){  
                  countChecked()
                  $("#cuti_fix_accept").val("")
                  $("#cuti_fix_reject").val("")
                  var accept = [];
                  var selector1 = '#detil_cuy tr input:checked'; 
                  var reject = [];
                  var selector2 = '#detil_cuy tr input:checkcard:not(:checked)'
                  $.each($(selector1), function(idx, val) {
                    var id = $(this).parent().siblings(":first").text();
                    accept.push(id);
                    $("#cuti_fix_accept").val(accept)
                  });
                  $.each($(selector2), function(idx, val) {   
                    var id = $(this).parent().siblings(":first").text();                    
                    reject.push(id);
                    $("#cuti_fix_reject").val(reject)
                  });
              
              })
            }
        });

            $("#detail_cuti").modal("show");
    });
    
    $(document).on('click',"button[id^='btn-edit']",function(e) {
      $.ajax({
          type:"GET",
          url:'{{url("/detilcuti")}}',
          data:{
            cuti:this.value,
          },
          success: function(result){
            var table = "";

            var array = [];

            $.each(result[0], function(key, value){
              $("#id_cuti").val(value.id_cuti);
              $("#reason_edit").val(value.reason_leave);
              array.push(value.date_off);

              $("#Dates_update").val(array);

              $('#Dates').tooltip("disable");

              var disableDate = []
                $.each(result.allCutiDate,function(key,value){
                  disableDate.push(moment(value).format("L"))
              })

              $("#Dates").flatpickr({
                weekStart: 1,
                // daysOfWeekDisabled: "0,6",
                daysOfWeekHighlighted: [0,6],
                minDate:'0',
                startDate: moment().format("YYYY-MM-DD"),
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                multidate: true,
                datesDisabled: disableDate,
                beforeShowDay: function(date){
                  var index = hari_libur_nasional.indexOf(moment(date).format("L"))
                  if(index > 0){
                    return {
                      enabled: false,
                      tooltip: hari_libur_nasional_tooltip[index],
                      classes: 'hari_libur'
                    };
                  } else if(disableDate.indexOf(moment(date).format("L")) > 0) {
                    return {
                      enabled: false,
                      tooltip: 'Cuti Pribadi',
                    };
                  }
                },
              }).flatpickr('setDate', array).on('changeDate', function(e) {
                if (e.dates.length > 0) {
                  if (parseFloat(array.length) >= parseFloat(e.dates.length)) {
                    e.preventDefault();     
                    $(".btn-submit-update").prop('disabled', false);
                    $('#Dates').tooltip("disable");
                  } else if (parseFloat(array.length) < parseFloat(e.dates.length)) {
                    $(".btn-submit-update").prop('disabled', true);
                    $('#Dates').tooltip("enable");
                  }
                }else{
                  $(".btn-submit-update").prop('disabled', true);
                  $('#Dates').attr('title', 'Mohon untuk menginput tanggal cuti Anda!')
                  .tooltip('fixTitle')
                  .tooltip('enable');
                  // $('#Dates').tooltip("enable");
                  // $('#Dates').prop('tooltipText', 'Mohon untuk menginput tanggal cuti Anda!');
                }
              });
            });

        $("#modalCuti_edit").modal("show");
        }
      });

      $(document).on('click',"button[id^='btn-submit-update']",function(e){
        
        if ($("#Dates").val() == '') {
          var dates_after = 'kosong';
        }else{
          var dates_after = $("#Dates").val();
        }

        Swal.fire({
          title: 'Are you sure?',
          text: "Update your leaving permite",
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
              url:"{{url('/update_cuti')}}",
              data:{
                 _token: "{{ csrf_token() }}",
                id_cuti:$("#id_cuti").val(),
                dates_after:dates_after,
                dates_before:$("#Dates_update").val(),
                reason_edit:$("#reason_edit").val(),
                status_update:'R',
              },
              success: function(result){
                Swal.showLoading()
                Swal.fire(
                  'Updated!',
                  'Leaving permite has been update.',
                  'success'
                ).then((result) => {
                  if (result.value) {
                    $("#modalCuti_edit").modal('hide');
                  }
                }),
                setTimeout(function(){
                  $('#datatablew').DataTable().ajax.url("{{url('get_cuti_byMonth')}}").load();
                },2000);
              }
            })
          }
        })        
      })

    });


    function edit_cuti(id_cuti,date_start,date_end,reason_leave){
      $("#id_cuti").val(id_cuti);
      $("#date_start_edit").val(date_start);
      $("#date_end_edit").val(date_end);
      $("#reason_edit").val(reason_leave);
    }

    function detil_cuti(id_cuti){
      $("#reason_detil").val(id_cuti);
    }

    function decline(id_cuti,decline_reason){
      $.ajax({
        type:"GET",
        url:'{{url("/detilcuti")}}',
        data:{
          cuti:id_cuti,
        },
        success: function(result){
          var table = "";
          $.each(result[0], function(key, value){
            $("#keterangan_decline").val(value.decline_reason);
          });
        }
      });
      $('#decline_reason').modal('show')
    }

    function decline_cuti(id_cuti,decline_reason){
      $.ajax({
        type:"GET",
        url:'{{url("/detilcuti")}}',
        data:{
          cuti:id_cuti,
        },
        success: function(result){
          var table = "";
          $.each(result[0], function(key, value){
            $("#id_cuti_decline").val(value.id_cuti);
            $("#keterangan").val(value.decline_reason);
          });
        }
      });
      $('#reason_decline').modal('show')
    }

    // $('#cutis a').click(function(e) {
    //   e.preventDefault();
    //   $(this).tab('show');
    // });

    // store the currently selected tab in the hash value
    $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
      var id = $(e.target).attr("href").substr(1);
      window.location.hash = id;
    });

    // on load of the page: switch to the currently selected tab
    // var hash = window.location.hash;
    // $('#cutis a[href="' + hash + '"]').tab('show');


    // $('#submit_approve').click(function(){
    //   var updates = [];
    //   var selector = '#detil_cuy tr input:checked'; 
    //   $.each($(selector), function(idx, val) {
    //     var id = $(this).parent().siblings(":first").text();
    //     updates.push(id);
    //   });

    //   $("#cuti_fix").val(updates.join(","));

    //   Swal.fire({
    //     title: 'Approve Cuti',
    //     text: "kamu yakin?",
    //     icon: 'warning',
    //     showCancelButton: true,
    //     confirmButtonColor: '#3085d6',
    //     cancelButtonColor: '#d33',
    //     confirmButtonText: 'Yes',
    //     cancelButtonText: 'No',
    //   }).then((result) => {
    //     if (result.value) {
    //       Swal.fire({
    //         title: 'Please Wait..!',
    //         text: "It's updating..",
    //         allowOutsideClick: false,
    //         allowEscapeKey: false,
    //         allowEnterKey: false,
    //         customClass: {
    //           popup: 'border-radius-0',
    //         },
    //         onOpen: () => {
    //           Swal.showLoading()
    //         }
    //       })
    //       $.ajax({
    //         type:"POST",
    //         url:"{{url('approve_cuti')}}",
    //         data:{
    //           _token:"{{csrf_token()}}",
    //           id_cuti_detil:$('#id_cuti_detil').val(),

    //           nik_cuti:$('#nik_cuti').val(),
    //           reason_reject:$('#reason_reject').val(),
    //           cuti_fix:$('#cuti_fix').val()
    //         },
    //         success: function(result){
    //           Swal.showLoading()
    //           Swal.fire(
    //             'Successfully!',
    //             'success'
    //           ).then((result) => {
    //             if (result.value) {
    //               location.reload()
    //               $("#detail_cuti").modal('toggle')
    //             }
    //           })
    //         },
    //       });
    //     }        
    //   })

    //   // document.getElementById("cuti_fix").innerHTML = updates.join(",") ;
    // })

    $('#submit_approve').click(function(){  
      // $("#cuti_fix").val(updates.join(","));
      Swal.fire({
        title: 'Are you sure',
        text: "Submit the permite?",
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
            text: "It's updating..",
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            customClass: {
              popup: 'border-radius-0',
            },
            onOpen: () => {
              Swal.showLoading()
            }
          })
          $.ajax({
            type:"POST",
            url:"{{url('approve_cuti')}}",
            data:{
              _token:"{{csrf_token()}}",
              id_cuti_detil:$('#id_cuti_detil').val(),
              nik_cuti:$('#nik_cuti').val(),
              reason_reject:$('#reason_reject').val(),
              // cuti_fix:$('#cuti_fix').val()
              cuti_fix_accept:$('#cuti_fix_accept').val(),
              cuti_fix_reject:$('#cuti_fix_reject').val()
            },
            success: function(result){
              Swal.showLoading()
              Swal.fire(
                'Successfully!',
                'success'
              ).then((result) => {
                if (result.value) {
                  location.reload()
                  $("#detail_cuti").modal('toggle')
                }
              })
            },
          });
        }        
      })

      // document.getElementById("cuti_fix").innerHTML = updates.join(",") ;
    })

    var url = {!! json_encode(url('/')) !!}

    function exportExcel() {
      filter      = encodeURI($("#pilih").val())
      division    = encodeURI($("#division_cuti").val())
      date_start  = encodeURI(moment($('#datesReport').val().slice(0,10)).format("YYYY-MM-DD"))
      date_end    = encodeURI(moment($('#datesReport').val().slice(13,23)).format("YYYY-MM-DD"))
      myUrl       = url+"/downloadCutiReport?division="+division+"&date_start="+date_start+"&date_end="+date_end+"&filter="+filter
      location.assign(myUrl)
    }

    var start_date = moment().startOf('year');
    var end_date = moment().endOf('year');
    var monthCuti;

    get_list_cuti();
    get_cuti_byMonth();
    get_history_cuti($("#filter_com").val(),"alldeh",moment($('#datesReport').val().slice(0,10)).format("YYYY-MM-DD"),moment($('#datesReport').val().slice(13,23)).format("YYYY-MM-DD"))

    function get_cuti_byMonth(){
      monthCuti = $("#datatablew").DataTable({
        "ajax":{
          "type":"GET",
          "url":"{{url('get_cuti_byMonth')}}",
        },
        "columns": [
          { 
              data: "name",
              render: function (data, type, row) {
                  return data ? data.toUpperCase() : "-";
              },
              defaultContent: "-"
          },
          { 
              data: "id_division",
              render: function (data, type, row) {
                  return (data === '-') ? 'Admin' : data;
              },
              defaultContent: "-"  
          },
          { 
              data: "date_req",
              defaultContent: "-" 
          },
          { 
              data: "id_cuti", // Ensure this exists in the dataset
              render: function (data, type, row) {
                  return `
                      <button name="date_off" id="date_off" class="date_off" value="${data}" style="outline: none; background-color: transparent; border: none;">
                          ${row.days} Days <i class="glyphicon glyphicon-zoom-in" style="padding-left: 5px"></i>
                      </button>`;
              },
              defaultContent: "-" 
          },
          {
              data: "status",
              render: function (data, type, row) {
                  if (data === 'v') {
                      return '<span class="badge text-bg-success">Approved</span>';
                  } else if (data === 'd') {
                      return `<span class="badge text-bg-danger" onclick="decline(${row.id_cuti})">Declined</span>`;
                  } else if (data === 'n' || data === 'R') {
                      return '<span class="badge text-bg-warning">Pending</span>';
                  } else {
                      return '<span class="badge text-bg-danger">Cancel</span>';
                  }
              },
              defaultContent: "-"  
          },
          {
              data: "nik", // Ensure this exists in the dataset
              render: function (data, type, row) {
                  let userNik = "{{ Auth::User()->nik }}"; // Pass from PHP correctly
                  
                  if (userNik == row.nik) {
                      if (row.status === 'n' || row.status === 'R') {
                          return `
                              <button type="button" class="btn btn-xs btn-primary" style="width: 70px" id="btn-edit" data-bs-toggle="tooltip" title="Edit" value="${row.id_cuti}">
                                  <i class="bx bx-edit" style="margin-right: 5px"></i>Edit
                              </button>
                              <button type="button" class="btn btn-xs btn-danger btn_delete" style="margin-left: 10px; width: 70px" data-bs-toggle="tooltip" title="Delete" value="${row.id_cuti}">
                                  <i class="bx bx-trash" style="margin-right: 5px"></i>Delete
                              </button>
                              <button type="button" class="btn btn-xs btn-success btn_fu" style="margin-left: 10px; width: 80px" data-bs-toggle="tooltip" title="Follow Up Cuti" value="${row.id_cuti}">
                                  <i class="bx bx-paper-plane" style="margin-right: 5px"></i>Follow Up
                              </button>`;
                      } else {
                          return '-';
                      }
                  } else {
                      if (row.status === 'n' || row.status === 'R') {
                          return `
                              <button name="approve_date" id="approve_date" class="approve_date btn btn-success btn-xs" style="width: 60px" value="${row.id_cuti}">Approve</button>
                              <button class="btn btn-xs btn-danger btn_decline" style="width: 60px; margin-left: 5px" value="${row.id_cuti}" onclick="decline_cuti(${row.id_cuti})">Decline</button>`;
                      } else {
                          return `
                              <button class="btn btn-xs btn-success disabled" style="width: 60px">Approve</button>
                              <button class="btn btn-xs btn-danger disabled" style="width: 60px; margin-left: 5px">Decline</button>`;
                      }
                  }
              },
              defaultContent: "-"  
            }
          ],
        initComplete: function() {
          if (this.api().data().length) 
          {
            $('.count_cuti').text(this.api().data().length)
          }
          // if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.group','Director Operational')->exists()}}" || 
          //   "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','People Operations & Services Manager')->exists()}}") 
          // {
          //   if (this.api().data().length) 
          //   {
          //     $('.count_cuti').text(this.api().data().length)
          //   }else{
          //     activeTab('cuti') 
          //   }
          // }else{
          //   activeTab('cuti')
          // }
        },
        "searching": true,
        "lengthChange": true,
        "order": [[ 0, "asc" ]],
        "fixedColumns":   {
            leftColumns: 1
        },
        scrollX:true,
        "pageLength": 25,
      })
    }

    function get_history_cuti(com,division,start_date,end_date){
      $("#datatableq").DataTable({
        "destroy":true,
        "ajax":{
          "data":{
            "com":com,
            "start_date":start_date,
            "end_date":end_date,
            "division":division
          },
          "type":"GET",
          "url":"{{url('get_history_cuti')}}",
        },
        "columns": [
            { 
                data: "name",
                defaultContent: "-",
                render: function (data, type, row) {
                    return data ? data.toUpperCase() : "-";
                }
            },
            { data: "id_division", defaultContent: "-" },
            { data: "date_req", defaultContent: "-" },
            { 
                data: "id_cuti", 
                defaultContent: "-",
                render: function (data, type, row) {
                    return data !== "-" ? `
                        <button name="date_off" id="date_off" class="date_off btn btn-link p-0" value="${data}" style="border: none;">
                            ${row.days} Days <i class="bx bx-zoom-in ms-1"></i>
                        </button>` : "-";
                }
            },
            { data: "updated_at", defaultContent: "-" },
            { data: "pic", defaultContent: "-" },
            {
                data: "status",
                defaultContent: "-",
                render: function (data, type, row) {
                    if (data === 'v') {
                        return '<span class="badge bg-success">Approved</span>';
                    } else if (data === 'd') {
                        return `<span class="badge bg-danger" onclick="decline(${row.id_cuti})">Declined</span>`;
                    } else if (data === 'n' || data === 'R') {
                        return '<span class="badge bg-warning text-dark">Pending</span>';
                    } else {
                        return '<span class="badge bg-danger">Cancel</span>';
                    }
                }
            }
        ],
        "searching": true,
        "lengthChange": true,
        // "order": [[ 2, "desc" ]],
        "order": [],
        "fixedColumns":   {
            leftColumns: 1
        },
        scrollX:true,
        "pageLength": 10,
      })
    }

    // function activeTab(tab){
    //   $('#cutis a[href="#' + tab + '"]').tab('show');
    // }

    function submitDecline(){
      Swal.fire({
      title: 'Are you sure?',
      text: "Decline permite!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes!'
      }).then((result) => {
        if (result.value) {
          var id_cuti = this.value;
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
              url:"{{url('decline_cuti')}}",
              data:{
                _token: "{{ csrf_token() }}",
                id_cuti:($("#id_cuti_decline").val()),
                decline_reason:($("#keterangan").val()),
              },
              success: function(result){
                $('#reason_decline').modal('hide')
                Swal.fire(
                  'Declined!',
                  'Your permite has been declined.',
                  'success'
                ),                 
                setTimeout(function(){
                  $('#datatablew').DataTable().ajax.url("{{url('get_cuti_byMonth')}}").load();
                },2000);
              }
            })
        }
      })
      // $.ajax({
      //   type:"POST",
      //   url:"{{url('/decline_cuti')}}",
      //   data:{
      //     _token: "{{ csrf_token() }}",
      //     id_cuti:($("#id_cuti_decline").val()),
      //     decline_reason:($("#keterangan").val()),
      //   },
      //   success:function(result){
      //     $('#tunggu').modal('hide');
      //     $('#reason_decline').modal('hide')
      //     location.reload()
      //   }
      // })
    }

    $('#datatablew').on('click', '.btn_delete', function(e){
      Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes!'
      }).then((result) => {
        if (result.value) {
          var id_cuti = this.value;
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
              type:"GET",
              url:"{{url('delete_cuti/')}}/"+id_cuti,
              success: function(result){
                $('#tunggu').modal('hide');
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                ),                 
                setTimeout(function(){
                    $('#datatablew').DataTable().ajax.url("{{url('get_cuti_byMonth')}}").load();
                },2000);
              }
            })
        }
      }) 
    })


    $('#datatablew').on('click', '.btn_fu', function(e){
        Swal.fire({
        title: 'Are you sure?',
        text: "Follow Up Your Permite!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
      }).then((result) => {

        if (result.value) {
          var id_cuti = this.value;
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
            type:"GET",
            url:"{{url('follow_up')}}?id_cuti="+id_cuti,
            success: function(result){
              Swal.fire(
                'Successfully!',
                'Your request has been sent.',
                'success'
              ),
              setTimeout(function(){
                $('#datatablew').DataTable().ajax.url("{{url('get_cuti_byMonth')}}").load();
              },2000);
            }
          })
        }
      })
        
    })

    function get_list_cuti(){
      $("#datatables").DataTable({
        "ajax":{
          "type":"GET",
          "url":"{{url('get_list_cuti')}}",
        },
        "columns": [
          { 
              data: "name",
              defaultContent: "-",
              render: function (data, type, row) {
                  return data ? data.toUpperCase() : "-";
              } 
          },
          { data: "email", defaultContent: "-" },
          { 
              data: "id_division",
              defaultContent: "-",
              render: function (data, type, row) {
                  return row.id_division === '-' ? 'Admin' : row.id_division;
              } 
          },
          { 
              data: "date_of_entry",
              defaultContent: "-",
              render: function (data, type, row) {
                  return data ? moment(data).format('L') : "-";
              } 
          },
          { 
              data: "date_of_entrys",
              defaultContent: "-",
              render: function (data, type, row) {
                  if (!data || isNaN(data)) return "-";
                  if (data > 365) {
                      return Math.floor(data / 365) + ' Tahun ' + Math.floor(data % 365 / 30) + ' Bulan';
                  } else if (data > 31) {
                      return Math.floor(data / 30) + ' Bulan';
                  } else {
                      return data + ' Hari';
                  }
              } 
          },
          { 
              data: "niks",
              defaultContent: "-",
              render: function (data, type, row) {
                  if (data < 1) {
                      return '1 Hari';
                  } else if (data === undefined || data === null) {
                      return "-";
                  } else {
                      return data + ' Hari';
                  }
              } 
          },
          { 
              data: "cuti",
              defaultContent: "-",
              render: function (data, type, row) {
                  return data !== null ? data + ' Hari' : "-";
              } 
          },
          { 
              data: "cuti2",
              defaultContent: "-",
              render: function (data, type, row) {
                  return row.status_karyawan === 'belum_cuti' ? "-" : data + ' Hari';
              } 
          },
          { 
              data: "date_of_entrys",
              visible: false,
              searchable: false
          }
        ],
        "searching": true,
        "lengthChange": true,
        "order": [[ 0, "asc" ]],
        "scrollX": true,
        "fixedColumns": {
            leftColumns: 1
        },
        "columnDefs": [
            { orderData: [8], targets: [3] },
            { orderData: [8], targets: [4] },
            {
                targets: [8],
                visible: false,
                searchable: false
            }
        ],
        "pageLength": 10
      })
    }

    function cb(start_date,end_date,url,division){
        start  = start_date.format("YYYY-MM-DD 00:00:00");
        end    = end_date.format("YYYY-MM-DD 00:00:00");

        $.ajax({
              type:"GET",
              url:url,
              data:{
                division:division,
                start:start,
                end:end
              },
              success: function(result){
                $('#datatable').DataTable({
                   "destroy": true,
                   "columnDefs":[
                        {"width": "30%", "targets":0},
                        {"width": "10%", "targets":2},
                        {"width": "10%", "targets":3},
                        {"width": "10%", "targets":4},
                       ],
                    "order": [[ "2", "desc" ]],
                    "lengthChange": false,
                    "paging": false,
                });
                $('#report').empty();

                var table = "";

                $.each(result, function(key, value){
                  table = table + '<tr>';
                  table = table + '<td>' +value.name+ '</td>';
                  table = table + '<td>' +value.id_division+ '</td>';
                  table = table + '<td>' +value.date_req+ '</td>';
                  table = table + '<td>' +'<button name="date_off" id="date_off" class="date_off" value="'+value.id_cuti+'" style="outline: none;background-color: transparent;background-repeat:no-repeat;border: none;">'+ value.days + ' Hari' + '<i class="glyphicon glyphicon-zoom-in" style="padding-left: 5px"/>'+'</button>'+'</td>';
                  if (value.updated_at == null) {
                    table = table + '<td> - </td>';
                    table = table + '<td> - </td>';
                  }else{
                    table = table + '<td>' +value.updated_at+ '</td>';
                    table = table + '<td>' +value.pic+ '</td>';
                  }
                  if (value.status == 'v') {
                    table = table + '<td>' +'<label class="label label-success">Approved</label>'+ '</td>';
                  }else if (value.status == 'd') {
                    table = table + '<td>' +'<label class="label label-danger" onclick="decline('+value.id_cuti+')">Declined</label>'+ '</td>';
                  }else if (value.status == 'n') {
                    table = table + '<td>' +'<label class="label label-warning">Pending</label>'+ '</td>';
                  }else {
                    table = table + '<td>' +'<label class="label label-danger">Cancel</label>'+ '</td>';
                  }

                  // table = table + '<td>' +' '+ '</td>';
                  
                  table = table + '</tr>';

                });
                $('#report').append(table);
                
              },
        });

    }

    cb(start_date,end_date,"{{url('/getFilterCom')}}?filter_com="+$("#filter_com").val(),$("#division_cuti").val());

    $('#datesReport').daterangepicker({
      startDate: start_date,
      endDate: end_date,
      locale: {
        format: 'L'
      },
      }, function(start, end, label) {
        start_date  = moment(start).format("YYYY-MM-DD")
        end_date    = moment(end).format("YYYY-MM-DD")
        
        var companyString = $(".nav-link.active").children().attr('onclick').slice(12,19)
        get_history_cuti($("#filter_com").val(),$("#division_cuti").val(),start_date,end_date)
    });

    $("#pilih").change(function(){
      if(this.value == 'date'){
        table.draw();
        $("#datesReport").prop('disabled', false);
        $("#division_cuti").prop('disabled', true);
         $('#datesReport').daterangepicker({

        }, function(start, end, label) {
            $.ajax({
                  type:"GET",
                  url:"/getfilterCutiByDate",
                  data:{
                    start:start.format('YYYY-MM-DD'),
                    end:end.format('YYYY-MM-DD')
                  },
                  success: function(result){
                    $('#datatable').DataTable({
                       "destroy": true,
                 "columnDefs":[
                      {"width": "30%", "targets":0},
                      {"width": "10%", "targets":2},
                      {"width": "10%", "targets":3},
                      {"width": "10%", "targets":4},
                     ],
                  "order": [[ "2", "desc" ]],
                  "lengthChange": false,
                  "paging": false,
              });
                    $('#report').empty();

                    var table = "";

                    $.each(result, function(key, value){
                      table = table + '<tr>';
                      table = table + '<td>' +value.name+ '</td>';
                      table = table + '<td>' +value.id_division+ '</td>';
                      table = table + '<td>' +'<button name="date_off" id="date_off" class="date_off" value="'+value.id_cuti+'" style="outline: none;background-color: transparent;background-repeat:no-repeat;border: none;">'+ value.days + ' Hari' + '<i class="glyphicon glyphicon-zoom-in" style="padding-left: 5px"/>'+'</button>'+'</td>';
                      table = table + '<td>' +value.date_req+ '</td>';
                      if (value.updated_at == null) {
                        table = table + '<td> - </td>';
                        table = table + '<td> - </td>';
                      }else{
                        table = table + '<td>' +value.updated_at+ '</td>';
                        table = table + '<td>' +value.pic+ '</td>';
                      }
                      if (value.status == 'v') {
                        table = table + '<td>' +'<label class="label-success">Approved</label>'+ '</td>';
                      }else if (value.status == 'd') {
                        table = table + '<td>' +'<label class="label-danger">Declined</label>'+ '</td>';
                      }else if (value.status == 'n'){
                        table = table + '<td>' +'<label class="label-warning">Pending</label>'+ '</td>';
                      } else {
                        table = table + '<td>' +'<label class="label-danger">Cancel</label>'+ '</td>';
                      }
                      
                      table = table + '<td>' +' '+ '</td>';
                      
                      table = table + '</tr>';

                    });
                    $('#report').append(table);
                    
                  },
              });
        });

      }else if (this.value == 'div') {
        $("#datesReport").prop('disabled', true);
        $("#division_cuti").prop('disabled', false);

        table.draw();
        $('#datatable').DataTable({
           "destroy": true,
         "columnDefs":[
              {"width": "30%", "targets":0},
              {"width": "10%", "targets":2},
              {"width": "10%", "targets":3},
              {"width": "10%", "targets":4},
             ],
          "order": [[ "2", "desc" ]],
          "lengthChange": true,
          "paging": true,
      });

        $("#division_cuti").change(function(){
          $.ajax({
              type:"GET",
              url:"{{url('/getfilterCutiByDiv')}}",
              data:{
                division:this.value,
              },
              success: function(result){
                $('#datatable').DataTable({
                   "destroy": true,
                   "columnDefs":[
                        {"width": "30%", "targets":0},
                        {"width": "10%", "targets":2},
                        {"width": "10%", "targets":3},
                        {"width": "10%", "targets":4},
                       ],
                    "order": [[ "2", "desc" ]],
                    "lengthChange": false,
                    "paging": false,
                });

                $('#report').empty();

                var table = "";

                $.each(result, function(key, value){
                  table = table + '<tr>';
                  table = table + '<td>' +value.name+ '</td>';
                  table = table + '<td>' +value.id_division+ '</td>';
                  table = table + '<td>' +'<button name="date_off" id="date_off" class="date_off" value="'+value.id_cuti+'" style="outline: none;background-color: transparent;background-repeat:no-repeat;border: none;">'+ value.days + ' Hari' + '<i class="glyphicon glyphicon-zoom-in" style="padding-left: 5px"/>'+'</button>'+'</td>';
                  table = table + '<td>' +value.date_req+ '</td>';
                  if (value.updated_at == null) {
                    table = table + '<td> - </td>';
                    table = table + '<td> - </td>';
                  }else{
                    table = table + '<td>' +value.updated_at+ '</td>';
                    table = table + '<td>' +value.pic+ '</td>';
                  }
                 if (value.status == 'v') {
                    table = table + '<td>' +'<label class="label-success">Approved</label>'+ '</td>';
                  }else if (value.status == 'd') {
                    table = table + '<td>' +'<label class="label-danger">Declined</label>'+ '</td>';
                  }else if (value.status == 'n'){
                    table = table + '<td>' +'<label class="label-warning">Pending</label>'+ '</td>';
                  } else {
                    table = table + '<td>' +'<label class="label-danger">Cance</label>'+ '</td>';
                  }
                  table = table + '<td>' +' '+ '</td>';
                  
                  table = table + '</tr>';

                });
                $('#report').append(table);
              },
          });
            
      });

        $("#datesReport").daterangepicker(
           $("#datesReport").val('')
        )
      }else{
        $("#datesReport").prop('disabled', false);
        $("#division_cuti").prop('disabled', false);

        // table.draw();
        $('#datatable').DataTable({
           "destroy": true,
         "columnDefs":[
              {"width": "30%", "targets":0},
              {"width": "10%", "targets":2},
              {"width": "10%", "targets":3},
              {"width": "10%", "targets":4},
             ],
          "order": [[ "2", "desc" ]],
          "lengthChange": true,
          "paging": true,
      });

      }
    })

    @if("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->whereIn('roles.name',['People Operations & Services Manager', 'VP Human Capital Management'])->exists()}}")
      $(document).on('click',"button[class^='date_off']",function(e) {
          $.ajax({
            type:"GET",
            url:'{{url("/detilcuti")}}',
            data:{
              pilih:$("#pilih").val(),
              date_start:moment($('#datesReport').val().slice(0,10)).format("YYYY-MM-DD"),
              date_end:moment($('#datesReport').val().slice(13,23)).format("YYYY-MM-DD"),
              cuti:this.value,
              status:"detil"
            },
            success: function(result){
              var table = "";

              $.each(result[0], function(key, value){
                $("#date_request_detils").val(moment(value.date_req).format('LL'));
                $("#reason_detils").val(value.reason_leave);
                $('#tanggal_cutis').empty();
                table = table + '<tr>';
                if (value.status_detail == 'ACCEPT') {
                  table = table + '<td>' + moment(value.date_off).format('LL') +' <b style="color:green">('+ value.status_detail +')</b></td>'
                }else{
                  table = table + '<td>' + moment(value.date_off).format('LL') +' <b style="color:red">('+ value.status_detail +')</b></td>'
                }
                table = table + '</tr>';
              });

              $('#tanggal_cutis').append(table);

            }
          });

          $("#details_cuti").modal("show");
       });
    @else
      $(document).on('click',"button[class^='date_off']",function(e) {
        $.ajax({
          type:"GET",
          url:'{{url("/detilcuti")}}',
          data:{
            cuti:this.value,
            status:'detil'
          },
          success: function(result){
            var table = "";

            $.each(result[0], function(key, value){
              $("#date_request_detils").val(moment(value.date_req).format('LL'));
              $("#reason_detils").val(value.reason_leave);
              $('#tanggal_cutis').empty();
              table = table + '<tr>';
              if (value.status_detail == 'ACCEPT') {
                table = table + '<td>' + moment(value.date_off).format('LL') +' <b style="color:green">('+ value.status_detail +')</b></td>'
              }else{
                table = table + '<td>' + moment(value.date_off).format('LL') +' <b style="color:red">('+ value.status_detail +')</b></td>'
              }
              table = table + '</tr>';

              if (value.decline_reason != null) {
                $("#alasan_reject_detail").css("display","block");
                $("#reason_reject_detil").val(value.decline_reason);
              }else if(value.status == 'v'){
                $("#alasan_reject_detail").css("display","none");
              }
            });

            $('#tanggal_cutis').append(table);

          }
        });

        $("#details_cuti").modal("show");
      });
    @endif
    
    $("#users").change(function(){
      $.ajax({
        type:"GET",
        url:"getCutiUsers",
        data:{
          nik:this.value,
        },
        success: function(result){
          $.each(result, function(key, value){
            $("#lama_kerja").val(Math.floor(value.parameterCuti.date_of_entrys / 365) + ' Tahun ' + value.parameterCuti.date_of_entrys % 365 +' Hari');
            $("#current_cuti").val(value.parameterCuti.total_cuti);
            $("#tahun_masuk").val(moment(value.parameterCuti.date_of_entry).format('ll'));
          });
        },
      });
    });

    var hari_libur_nasional = []
    var hari_libur_nasiona_tambahan = []
    var hari_libur_nasional_2 = []
    var hari_libur_nasional_tooltip = []
    var hari_libur_nasional_combine_tooltip = []


    $.ajax({
      type:"GET",
      url:"{{url('/getPublicHolidayAdjustment')}}",
      success:function(resultException){
        liburNasionalException = resultException
        hari_libur_nasiona_tambahan = liburNasionalException
        $.ajax({
          type:"GET",
          url:"https://www.googleapis.com/calendar/v3/calendars/en.indonesian%23holiday%40group.v.calendar.google.com/events?key={{env('GOOGLE_API_KEY_APP')}}",
          success: function(result){
            $.each(result.items,function(key,value){
              if(value.description == "Public holiday"){
                if (value.summary.indexOf('Joint') == -1) {
                  if(!liburNasionalException.includes(value.start.date)){
                    hari_libur_nasional.push(moment(value.start.date).format("L"))
                    hari_libur_nasional_2.push(moment(value.start.date).format("DD/MM/YYYY"))
                    hari_libur_nasional_tooltip.push(value.summary)
                    hari_libur_nasional_combine_tooltip.push({"date":moment(value.start.date).format("DD/MM/YYYY"),"summary":value.summary})
                  }
                }
                if (value.summary.indexOf('Idul Fitri') !== -1 || value.summary.indexOf('carding Day') !== -1) {
                  if(!liburNasionalException.includes(value.start.date)){
                    hari_libur_nasional.push(moment(value.start.date).format("L"))
                    hari_libur_nasional_2.push(moment(value.start.date).format("DD/MM/YYYY"))
                    hari_libur_nasional_tooltip.push(value.summary)
                    hari_libur_nasional_combine_tooltip.push({"date":moment(value.start.date).format("DD/MM/YYYY"),"summary":value.summary})
                  }
                }
              }
            })

            hari_libur_nasional_combine_tooltip = removeDuplicates(hari_libur_nasional_combine_tooltip, 'date');
          }
        })
      }
    })

    function removeDuplicates(arr, prop) {
      var uniqueValues = {};
      return $.grep(arr, function (element) {
        if (!uniqueValues[element[prop]]) {
          uniqueValues[element[prop]] = true;
          return true;
        }
        return false;
      });
    }

    $(".toggle-arrow").click(function(){
      $(this).toggleClass("bx-chevron-down");
      $(".div-libur").toggle('1000');
    })

    $(".toggle-password").click(function(){
      $(this).toggleClass("bx-chevron-down");
    })

    function print()
    {
      window.print();
    }


    $("#filter_com").change(function(){
      var filter_com = this.value;
      var companyString = $(".nav-link.active").children().attr('onclick').slice(12,19)
      if (companyString == "all_lis") {
        $('#datatables').DataTable().ajax.url("{{url('getFilterCom')}}?filter_com="+filter_com+"&id=" + companyString).load();
      } else if (companyString == "request") {
        $('#datatablew').DataTable().ajax.url("{{url('getFilterCom')}}?filter_com="+filter_com+"&id=" + companyString).load();
      } else if (companyString == "report_"){
        if($('#datesReport').length){
          var start_date = $('#datesReport').data('daterangepicker').startDate
          var end_date = $('#datesReport').data('daterangepicker').endDate
          cb(start_date,end_date,"{{url('getFilterCom')}}?filter_com="+filter_com+"&id=" + companyString,$("#division_cuti").val());
        } else {
          cb(moment().startOf('year'),moment().endOf('year'),"{{url('getFilterCom')}}?filter_com="+filter_com+"&id=" + companyString,$("#division_cuti").val());
        }
        
      } else {
        get_history_cuti($("#filter_com").val(),$("#division_cuti").val(),moment($('#datesReport').val().slice(0,10)).format("YYYY-MM-DD"),moment($('#datesReport').val().slice(13,23)).format("YYYY-MM-DD"))
        // $("#filter_com").val()
      }
    });

    $("#division_cuti").change(function(){
      var companyString = $(".nav-link.active").children().attr('onclick').slice(12,19)
      get_history_cuti($("#filter_com").val(),$("#division_cuti").val(),moment($('#datesReport').val().slice(0,10)).format("YYYY-MM-DD"),moment($('#datesReport').val().slice(13,23)).format("YYYY-MM-DD"))
    });

    function changeTabs(id) {
      com = ($("#filter_com").val() != undefined ? $("#filter_com").val() : "all") 
      if (id == "all_lis") {
        $('#datatables').DataTable().ajax.url("{{url('getFilterCom')}}?filter_com="+com+"&id="+id).load();
      } else if(id == "request") {
        @if("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->whereIn('roles.name',['People Operations & Services Manager', 'VP Human Capital Management'])->exists()}}")
          $('#datatablew').DataTable().ajax.url("{{url('getFilterCom')}}?filter_com="+com+"&id="+id).load();
        @else 
          $('#datatablew').DataTable().ajax.url("{{url('getFilterCom')}}?filter_com=1&id="+id).load();
        @endif
      } else if(id == "report_") {
        if($('#datesReport').length){
          var start_date = $('#datesReport').data('daterangepicker').startDate
          var end_date = $('#datesReport').data('daterangepicker').endDate
          cb(start_date,end_date,"{{url('getFilterCom')}}?filter_com="+com+"&id="+id,$("#division_cuti").val());
        } else {
          cb(moment().startOf('year'),moment().endOf('year'),"{{url('getFilterCom')}}?filter_com="+com+"&id="+id,$("#division_cuti").val());
        }
      } else {
        get_history_cuti($("#filter_com").val(),$("#division_cuti").val(),moment($('#datesReport').val().slice(0,10)).format("YYYY-MM-DD"),moment($('#datesReport').val().slice(13,23)).format("YYYY-MM-DD"))
      }
    }

    $(".disabled-permission").on('click',function(){
      Swal.fire("Not Allowed",'You still have a leaving permit that is in process<br>It must be completed first to make a new leaving permit.','error');
    });

    $(document).ready(function(){
  	  $('[data-bs-toggle="tooltip"]').tooltip(); 
  	});

    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert").slideUp(300);
    });
    

  </script>
@endsection
