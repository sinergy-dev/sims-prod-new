@extends('template.main_sneat')
@section('tittle')
HR Number
@endsection
@section('pageName')
Admin (HR)
@endsection
@section('head_css')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-fixedcolumns-bs5/fixedcolumns.bootstrap5.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}"/>
  <style type="text/css">
    .DTFC_LeftBodyLiner {
      overflow: hidden;
    }
    th {
      text-align: center;
    }
    .transparant{
      background-color: Transparent;
      background-repeat:no-repeat;
      border: none;
      cursor:pointer;
      overflow: hidden;
      outline:none;
      width: 25px;
    }

    .btnPR{
      color: #fff;
      background-color: #007bff;
      border-color: #007bff;
      width: 170px;
      padding-top: 4px;
      padding-left: 10px;
    }

    @media screen and (max-width: 768px) {
      .btn-action-letter{
        float: left!important;
      }
    }
    .pull-right{
      float: right;
    }

    .form-group{
      margin-bottom: 15px;
    }
  </style>
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
          <div class="alert alert-success notification-bar"><span>Notice : </span> {{ session('success') }}<button type="button" class="dismisbar transparant pull-right"><i class="bx bx-x fa-lg"></i></button><br>Get your Number HR :<h6> {{$pops->no_letter}}</h6></div>
        @endif

        @if (session('alert'))
          <div class="alert alert-success" id="alert">
            {{ session('alert') }}
          </div>
        @endif

    <div class="card">
      <div class="card-header with-border">
        <h6 class="card-title"><i class="bx bx-table"></i> Admin (HR)</h6>
      </div>

      <div class="card-body">
        <div class="row">
          <div class="col-md-2 col-xs-12">
            <div class="form-group">
              <select style="margin-right: 5px;width: 100px" class="form-control btn-primary" id="year_filter">
                <option value="{{$year}}">&nbsp{{$year}}</option>
                @foreach($year_before as $years)
                  @if($years->year != $year)
                    <option value="{{$years->year}}">&nbsp{{$years->year}}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-sm-10 col-xs-12">
            <div class="form-group btn-action-letter" style="float:right;">
              <button type="button" class="btn btn-sm btn-success pull-right" id="" data-bs-target="#modal_pr" data-bs-toggle="modal" style="width: 180px;color: white"><i class="bx bx-plus"> </i>&nbsp Number HR</button>
              <button class="btn btn-sm btn-warning btn-flat" onclick="exportHrNumber('{{action('HRNumberController@downloadExcelAdminHR')}}')" style="margin-right: 10px;"><i class="bx bx-download"></i>&nbsp Excel</button>
            </div>
          </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered nowrap table-striped dataTable" id="data_Table" width="100%" cellspacing="0">
              <thead>
                <tr style="text-align: center;">
                  <th>No</th>
                  <th>Type</th>
                  <th>PT</th>
                  <th>Month</th>
                  <th>Date</th>
                  <th>To</th>
                  <th>Attention</th>
                  <th>Title</th>
                  <th>Project</th>
                  <th>Description</th>
                  <th>From</th>
                  <th>Division</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
      </div>
    </div>
  </section>
</div>

<!--MODAL ADD PROJECT-->
<div class="modal fade" id="modal_pr" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h6 class="modal-title">Add Number HR</h6>
        </div>
        <form method="POST" action="{{url('/store_admin_hr')}}" id="modal_pr" name="modal_pr">
          @csrf
          <div class="modal-body">            
              <div class="form-group">
                <label for="">Type of Letter</label>
                <select type="text" class="custom-form-control-select w-100" placeholder="Select Type of Letter" name="type" id="type" required>
                    <option value="PKWT">PKWT</option>
                    <option value="PKWTT">PKWTT</option>
                    <option value="SK">SK</option>
                    <option value="SP">SP</option>
                    <option value="IDS">IDS</option>
                    <option value="Legal">Legal</option>
                    <option value="PKM">PKM</option>
                    <option value="NDA">NDA</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Company</label>
                <select type="text" class="custom-form-control-select w-100" placeholder="Select PT" name="pt" id="pt" required>
                    <option>SIP</option>
                    <option>MSP</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Date</label>
                <div class="input-group">
                  <div class="input-group-text">
                    <i class="bx bx-calendar"></i>
                  </div>
                  <input type="text" class="form-control date" name="date" id="date_hr">
                </div>
              </div>
              <div class="form-group">
                <label for="">To</label>
                <input type="text" class="form-control" placeholder="To" name="to" id="to" required>
              </div> 
              <div class="form-group">
                <label for="">Attention</label>
                <input type="text" class="form-control" placeholder="Enter Attention" name="attention" id="attention" >
              </div> 
              <div class="form-group">
                <label for="">Title</label>
                <input type="text" class="form-control" placeholder="Enter Title" name="title" id="title" >
              </div>
              <div class="form-group">
                <label for="">Project</label>
                <input type="text" class="form-control" placeholder="Enter Project" name="project" id="project" >
              </div>
              <div class="form-group">
                <label for="">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Enter Description"></textarea>
              </div>
              <div class="form-group">
                <label for="">Division</label>
                <select type="text" class="custom-form-control-select w-100" placeholder="Select Division" name="division" id="division" required>
                    <option>PPM</option>
                    <option>SSM</option>
                    <option>SPM</option>
                    <option>ICM</option>
                    <option>FAT</option>
                    <option>HCM</option>
                    <option>SAL</option>
                </select>
              </div>
              <!-- <div class="form-group">
                <label for="">Project ID</label>
                <input type="text" class="form-control" placeholder="Project ID" name="project_id" id="project_id">
              </div> -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal"><i class=" bx bx-x"></i>&nbspClose</button>
            <button type="submit" class="btn btn-sm btn-primary"><i class="bx bx-check"> </i>&nbspSubmit</button>
          </div>
        </form>

      </div>
    </div>
</div>


<!--Modal Edit-->
<div class="modal fade" id="modaledit" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h6 class="modal-title">Edit </h6>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/update_admin_hr')}}" id="modaledit" name="modaledit">
              @csrf
            <input type="text" hidden placeholder="Enter No PR" name="edit_no_letter" id="edit_no_letter">
            <div class="form-group">
              <label for="">Type of Letter</label>
              <select type="text" class="custom-form-control-select w-100" placeholder="Select Type of Letter" name="edit_type" id="edit_type" required>
                  <option value="PKWT">PKWT</option>
                  <option value="PKWTT">PKWTT</option>
                  <option value="SK">SK</option>
                  <option value="SP">SP</option>
                  <option value="IDS">IDS</option>
                  <option value="Legal">Legal</option>
                  <option value="PKM">PKM</option>
                  <option value="NDA">NDA</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Company</label>
              <select type="text" class="custom-form-control-select w-100" placeholder="Select PT" name="edit_company" id="edit_company" required>
                  <option>SIP</option>
                  <option>MSP</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Date</label>
              <div class="input-group date">
                <div class="input-group-text">
                  <i class="bx bx-calendar"></i>
                </div>
                <input type="date" class="form-control pull-right date" name="edit_date" id="edit_date">
              </div>
            </div>
            <div class="form-group">
              <label for="">To</label>
              <input type="text" class="form-control" placeholder="Enter To" name="edit_to" id="edit_to" >
            </div>
            <div class="form-group">
              <label for="">Attention</label>
              <input type="text" class="form-control" placeholder="Enter Attention" name="edit_attention" id="edit_attention" >
            </div> 
            <div class="form-group">
              <label for="">Title</label>
              <input type="text" class="form-control" placeholder="Enter Title" name="edit_title" id="edit_title" >
            </div> 
            <div class="form-group">
              <label for="">Project</label>
              <input type="text" class="form-control" placeholder="Enter Project" name="edit_project" id="edit_project" >
            </div>
            <div class="form-group">
              <label for="">Description</label>
              <textarea type="text" class="form-control" placeholder="Enter Description" name="edit_description" id="edit_description" > </textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal"><i class=" bx bx-x"></i>&nbspClose</button>
          <button type="submit" class="btn btn-sm btn-primary"><i class="bx bx-check"> </i>&nbspSubmit</button>
        </div>
      </div>
    </div>
</div>

</section>


@endsection

@section('scriptImport')
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
  <script type="text/javascript" src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('assets/js/jquery.mask.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
@endsection

@section('script')
  <script type="text/javascript">
    $('#date_hr').flatpickr({
      autoclose: true,
    })

    function edit_hr_number(no,to,attention,title,project,description,type,company,date) {
      $('#modaledit').modal('show');
      $('#edit_no_letter').val(no);
      $('#edit_type').val(type);
      $('#edit_company').val(company);
      $('#edit_date').val(date);

      if (to == "null") {
        '';
      } else {
        $('#edit_to').val(to);
      }
      if (attention == "null") {
        '';
      } else {
        $('#edit_attention').val(attention);
      }
      if (title == "null") {
        '';
      } else {
        $('#edit_title').val(title);
      }
      if (project == "null") {
        '';
      } else {
        $('#edit_project').val(project);
      }

      if (description == "null") {
        '';
      } else {
        $('#edit_description').val(description);
      }
    }

    initHRTable();

    function initHRTable() {
       $("#data_Table").DataTable({
        "ajax":{
          "type":"GET",
          "url":"{{url('getdatahrnumber')}}",
          "dataSrc": function (json){

            json.data.forEach(function(data,index){
              if("{{Auth::User()->nik}}" == data.from) {
                var x = '"' + data.no + '","' + data.to + '","' + data.attention+ '","' +data.title+ '","' +data.project+ '","' +data.description+ '","' +data.type_of_letter+ '","' +data.pt+ '","' +data.date+ '"'
                data.btn_edit = "<button class='btn btn-sm btn-primary' onclick='edit_hr_number(" + x + ")'>Edit</button>";
              } else {
                data.btn_edit = "<button class='btn btn-sm btn-primary disabled'>Edit</button>";
              }
                
            });
            return json.data;
            
          }
        },
        "columns": [
          { "data": "no_letter" },
          { "data": "type_of_letter" },
          { "data": "pt" },
          { "data": "month" },
          { "data": "date" },
          { "data": "to"},
          { "data": "attention" },
          { "data": "title" },
          { "data": "project" },
          { "data": "description" },
          { "data": "name" },
          { "data": "division" },
          {
            "className": 'btn_edit',
            "orderable": false,
            "data": "btn_edit",
            "defaultContent": ''
          },
        ],
        "searching": true,
        "scrollX": true,
        "order": [[ 0, "desc" ]],
        "fixedColumns":   {
            leftColumns: 1
        },
        "pageLength": 20,
      })
    }

    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
         $("#alert").slideUp(300);
    });

    $("#year_filter").change(function(){
      $('#data_Table').DataTable().ajax.url("{{url('getfilteryearhrnumber')}}?data=" + this.value).load();
    });

    function exportHrNumber(url){
      window.location = url + "?year=" + $("#year_filter").val();
    }

    $(".dismisbar").click(function(){
     $(".notification-bar").slideUp(300);
    }); 
  </script>
@endsection