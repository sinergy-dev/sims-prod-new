@extends('template.main_sneat')
@section('tittle')
Partnership
@endsection
@section('pageName')
Partnership
@endsection
@section('head_css')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
  <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
  <style type="text/css">
    .dataTables_filter {
     display: none;
    }

    .small-card h2 {
      font-size: 50px;
      font-weight: bold;
      margin: 20px 0 0 0;
      /*white-space: nowrap;*/
      padding: 0;
    }

    .small-card h6 {
      word-break: break-all;
      word-spacing: 999px;
      font-size: 30px;
      font-weight: bold;
    }

    .vcenter {
      display: flex;
      vertical-align: middle;
      float: right;
    }

    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }

    .dt-aligment-middle{
      vertical-align: middle;
      text-align: center;
    }

    /* The container <div> - needed to position the dropdown content */
    .dropdown {
      position: relative;
      display: inline-block;
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f1f1f1;
      min-width: 120px;
      card-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {background-color: #ddd;}

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {display: block;}

    .dropdown:hover .dropbtn {background-color: #F0AD4E;}  

    .pull-left{
      float: left;
    }  

    .pull-right{
      float: right;
    }

    .form-group{
      margin-bottom: 15px;
    }

    .todo-list {
      margin: 0;
      padding: 0;
      list-style: none;
      overflow: auto;
    }

    .todo-list > li:last-of-type {
      margin-bottom: 0;
    }

    .todo-list > li {
      border-radius: 2px;
      padding: 10px;
      background: #f4f4f4;
      margin-bottom: 2px;
      border-left: 2px solid #e6e7e8;
      color: #444;
    }

    .todo-list .handle {
      display: inline-block;
      cursor: move;
      margin: 0 5px;
    }

    .todo-list > li > input[type="checkbox"] {
      margin: 0 10px 0 5px;
    }

    .todo-list > li .text {
      display: inline-block;
      margin-left: 5px;
      font-weight: 600;
    }

    .todo-list > li .badge {
      margin-left: 10px;
      font-size: 9px;
    }

    .products-list {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .product-list-in-box > .item {
      -webkit-box-shadow: none;
      box-shadow: none;
      border-radius: 0;
      border-bottom: 1px solid #f4f4f4;
    }

    .products-list .product-img img {
      width: 50px;
      height: 50px;
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
        <div class="alert alert-primary" id="alert">
            {{ session('success') }}
        </div>
      @endif

      @if (session('alert'))
        <div class="alert alert-success" id="alert">
            {{ session('alert') }}
        </div>
      @endif

      <div class="card">
        <div class="card-header">
          <h6 class="card-title"><i class="bx bx-table"></i> Partnership</h6>
            <!--<div class="pull-left">
              <button type="button" class="btn btn-sm btn-primary pull-right float-right margin-left-custom" id="btnAdd" onclick="showTabAdd(0)" style="display: none;" style="width: 120px;"><i class="bx bx-plus"> </i> &nbspPartnership
                </button>  
              <div class="pull-right dropdown" style="margin-right: 5px;display: none;" id="divExport">
                <button class="btn btn-sm btn-success"><i class="bx bx-download"> </i>&nbspExport</button>
                <div class="dropdown-content">
                  <a href="{{action('PartnershipController@downloadpdf')}}" style="cursor:pointer">PDF</a>
                  <a onclick="exportExcel()" style="cursor:pointer">Excel</a>
                </div>
              </div> 
            </div> -->
        </div>

        <div class="card-body">
          <div class="row mb-4">
            <div class="col-md-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="nav-item">
                    <button type="button" class="nav-link active" href="#tab_1" id="tabDashboard" data-bs-toggle="tab" aria-expanded="true">
                      <span class="d-none d-sm-inline-flex align-items-center">
                        Dashboard
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1_5 badge-notif">0</span>
                      </span>
                    </button>
                  </li>
                  <li class="nav-item">
                    <button type="button" class="nav-link" href="#tab_2" data-bs-toggle="tab" id="tabList_partnership" aria-expanded="false">List Partnership</button>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane show active" id="tab_1">
                    <div class="row mb-4" id="cardId">
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-6">
                        <div class="card card-primary">
                          <div class="card-header with-border">
                            <h6 class="card-title">Total Certificate per Partner</h6>
                          </div>
                          <div class="chart-container" style="position: relative;padding: 20px;border-radius: 5px;">
                            <canvas id="brandPieChart" height="350" width="787"></canvas>
                          </div>
                        </div>
                        
                      </div>
                      <div class="col-md-6">
                        <div class="card card-primary">
                          <div class="card-header with-border">
                            <h6 class="card-title">Total Sales/Engineer Certification</h6>
                          </div>
                          <div class="chart-container" style="position: relative;padding: 20px;border-radius: 5px;">
                            <canvas id="certPieChart" height="350" width="787"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-12">                     
                        <div class="card card-primary">
                          <div class="card-header with-border">
                            <i class="ion ion-arrow-graph-up-right"></i> 
                            <h6 class="card-title">Need Attention</h6>
                          </div>
                          <div class="card-body">
                            <ul class="attention-list products-list product-list-in-box">
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-12">                      
                        <div class="card card-primary">
                          <div class="card-header">
                            <i class="ion ion-clipboard"></i>

                            <h6 class="card-title">To Do List</h6>
                          </div>
                          <div class="card-body">
                            <ul class="todo-list">
                            </ul>
                          </div>
                        </div> 
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="tab_2">
                    <div class="row mb-4">
                      <div class="col-md-6 mx-auto" style="margin-bottom: 0px; margin-top: 0px;"> 
                        <button type="button" class="btn btn-sm btn-primary margin-left-custom" id="btnAdd" onclick="showTabAdd(0)" style="display: none!important;" style="width: 120px;"><i class="bx bx-plus"> </i> &nbspPartnership
                          </button>  
                        <div class="dropdown" style="margin-right: 5px;display: none!important;" id="divExport">
                          <button class="btn btn-sm btn-success"><i class="bx bx-download"> </i>&nbspExport</button>
                          <div class="dropdown-content">
                            <!-- <a href="{{action('PartnershipController@downloadpdf')}}" style="cursor:pointer">PDF</a> -->
                            <a onclick="exportExcel()" style="cursor:pointer">Excel</a>
                          </div>
                        </div>           
                      </div>
                      <div class="col-md-6 ms-auto" style="margin-bottom: 0px; margin-top: 0px;">
                        <div class="input-group">
                          <input id="searchPartnership" type="text" class="form-control" onkeyup="searchCustom('tablePartnerhip','searchPartnership')" placeholder="Search Anything">  
                            <button type="button" id="btnShowPartnership" class="btn btn-sm btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                              Show 10 entries
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="#" onclick="$('#tablePartnerhip').DataTable().page.len(10).draw();$('#btnShowPartnership').html('Show 10 entries')">10</a></li>
                              <li><a class="dropdown-item" href="#" onclick="$('#tablePartnerhip').DataTable().page.len(25).draw();$('#btnShowPartnership').html('Show 25 entries')">25</a></li>
                              <li><a class="dropdown-item" href="#" onclick="$('#tablePartnerhip').DataTable().page.len(50).draw();$('#btnShowPartnership').html('Show 50 entries')">50</a></li>
                              <li><a class="dropdown-item" href="#" onclick="$('#tablePartnerhip').DataTable().page.len(100).draw();$('#btnShowPartnership').html('Show 100 entries')">100</a></li>
                            </ul>
                            <button onclick="searchCustom('tablePartnerhip','searchPartnership')" type="button" class="btn btn-sm btn-outline-secondary">
                              <i class="bx bx-fw bx-search"></i>
                          </span>
                        </div>
                      </div>  
                    </div>
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped dataTable" id="tablePartnerhip" style="width: 100%;" cellspacing="0">
                        <thead>
                          <tr>
                            <th hidden>No</th>
                            <th>Partnership Name</th>
                            <th>Type (Distributor or Principal)</th>
                            <th>Level</th>
                            <th>Renewal Date</th>
                            <th>Target Progress</th>
                            <th>Number of Certification</th>
                            <th hidden></th>
                            <th id="th-action">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
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

  <!--MODAL-->
  <div class="modal fade" id="uploadFile" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h6 class="modal-title">Upload File .pdf</h6>
        </div>

        <div class="modal-body">
          <form action="/upload/proses" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
              <input type="text" id="upload_id_partnership" name="upload_id_partnership" hidden>
              <input type="text" id="upload_doc" name="upload_doc" hidden>
            </div>
            <div class="form-group">
              <input type="file" id="file" name="file">
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal"><i class=" bx bx-x"></i>&nbspClose</button>
              <button type="submit" class="btn btn-sm btn-primary"><i class="bx bx-check"> </i>&nbspSubmit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!--MODAL ADD INCIDENT-->
  <div class="modal fade" id="modalAddPartnership" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
              <h6 class="modal-title">Add Partnership</h6>
          </div>
          <div class="modal-body">
            <form enctype="multipart/form-data" id="modalAdd" name="modalAdd">
              @csrf

              <div class="tab" style="display: none;">
                <div class="row mb-4">
                  <div class="col-md-12">
                    <h6>Basic Information</h6>
                    <hr>
                  </div>                    
                </div>
                <div class="row mb-4">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Type<span style="color:red">*</span></label>
                      <select class="form-control" id="type" name="type" onchange="checkType()">
                          <option value="">Select Type</option>
                          <option value="Distributor">Distributor</option>
                          <option value="Principal">Principal</option>
                          <!-- <option value="Other">Other</option> -->
                      </select>
                      <span class="help-block" style="display:none;">Please Choose Type!</span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Partner<span style="color:red">*</span></label>
                      <input class="form-control" placeholder="ex: Cisco" id="partner" name="partner" onkeyup="fillInput('partner')">
                      <span class="help-block" style="display:none;">Please Fill Partner Name!</span>
                    </div>  
                  </div>
                </div>           

                <div class="form-group">
                    <label>List Level<span style="color:red">*</span></label>
                    <input class="form-control" placeholder="ex: Beginner, Intermediate, Advanced" id="levelling" name="levelling" onkeyup="fillInput('levelling')">
                    <span class="help-block" style="display:none;">Please Fill Levelling!</span>
                </div>

                <div class="form-group">
                    <label>Current Level<span style="color:red">*</span></label>
                    <input class="form-control" placeholder="ex: Beginner" id="level" name="level" onkeyup="fillInput('level')">
                    <span class="help-block" style="display:none;">Please Fill Level!</span>
                </div>

                <div class="form-group">
                    <label>Renewal Date<span style="color:red">*</span></label>
                    <input type="date" class="form-control" id="renewal_date" name="renewal_date" onchange="fillInput('renewal')">
                    <span class="help-block" style="display:none;">Please Fill Renewal Date!</span>
                </div>

                <div class="form-group">
                    <label>Annual Fee</label>
                    <input class="form-control" placeholder="ex: USD 2.000" id="annual_fee" name="annual_fee">
                </div>

                <div class="form-group">
                  <label>Partner Portal URL</label>
                  <input class="form-control" placeholder="ex: https://www.cisco.com/c/en_id/partners.html" id="portal_partner" name="portal_partner">
                </div>

                <div class="form-group">
                  <label>ID Mitra</label>
                  <input class="form-control" placeholder="ex: PartnerId 12345" id="id_mitra" name="id_mitra">
                </div>

                <div class="form-group">
                  <label>Technology</label>
                  <select class="form-control" id="id_technology" name="id_technology" style="width: 100%;"></select>
                </div>

               <!--  <div class="form-group">
                    <label>Sales Target</label>
                    <input class="form-control" placeholder="Enter Sales Target" id="sales_target" name="sales_target">
                </div> -->
              </div>
              <div class="tab" style="display:none;">
                <div class="row mb-4">
                  <div class="col-md-12">
                    <h6>CAM (Country Account Manager) Information</h6>
                    <hr>
                  </div>                    
                </div>
                <div class="row mb-4">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>CAM</label>
                        <input class="form-control" placeholder="Enter CAM" id="cam" name="cam">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>CAM Phone</label>
                        <input class="form-control" placeholder="Enter CAM Phone" id="cam_phone" name="cam_phone">
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>CAM Email</label>
                        <input class="form-control" placeholder="Enter CAM Email" id="cam_email" name="cam_email">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Email Support</label>
                        <input class="form-control" placeholder="Enter Email Support" id="email_support" name="email_support">
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab" style="display: none;">
                <div class="row mb-4">
                  <div class="col-md-12">
                    <h6>Certification & Target/Requirement</h6>
                    <hr>
                  </div>                    
                </div>
                <i class="bx bx-table"></i><label>&nbspCertification list</label> 
                <table class="table">
                  <thead>
                    <tr>
                      <th>Certificate Level</th>
                      <th>Certificate Name</th>
                      <th>Person</th>
                      <td class="text-center">
                        <button class="btn btn-sm btn-primary" onclick="addListCert()" type="button" style="border-radius:50%;width: 25px;height: 25px;">
                          <i class="bx bx-plus"></i>
                        </button> 
                      </td>
                    </tr>
                  </thead>
                  <tbody id="tbListCert">
                  </tbody>
                </table>
                <i class="bx bx-table"></i><label>&nbspTarget</label> 
                <table class="table">
                  <thead>
                    <tr>
                      <th>Target</th>
                      <th>Countable</th>
                      <!-- <th>Description</th> -->
                      <td class="text-center">
                        <button class="btn btn-sm btn-primary" onclick="addSalesTarget()" type="button" style="border-radius:50%;width: 25px;height: 25px;">
                          <i class="bx bx-plus"></i>
                        </button> 
                      </td>
                    </tr>
                  </thead>
                  <tbody id="tbSalesTarget">
                  </tbody>
                </table>
              </div>         
               
              <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" id="prevBtn" onclick="nextPrev()">Back</button>
                <button type="button" class="btn btn-sm btn-primary" id="nextBtn" onclick="nextPrev()">Next</button>
              </div>
          </form>
          </div>
        </div>
      </div>
  </div>

  <!--MODAL EDIT INCIDENT-->
  <div class="modal fade" id="modalEdit" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h6 class="modal-title">Edit Partnership</h6>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/update_partnership')}}" id="modalEditPartnership" name="modalEditPartnership">
            @csrf

            <input type="text" name="edit_id" id="edit_id" hidden>

            <div class="form-group">
                <label>Type</label>
                <select class="form-control" id="edit_type" name="edit_type" required>
                      <option value="Distributor">Distributor</option>
                      <option value="Principal">Principal</option>
                      <!-- <option value="Other">Other</option> -->
                  </select>
            </div>

            <div class="form-group">
                <label>Partner</label>
                <input class="form-control" id="edit_partner" name="edit_partner" required>
            </div>

            <div class="form-group">
                <label>Level</label>
                <input class="form-control" id="edit_level" name="edit_level" required>
            </div>

            <div class="form-group">
                <label>Renewal Date</label>
                <input type="date" class="form-control" id="edit_renewal_date" name="edit_renewal_date">
            </div>

            <div class="form-group">
                <label>Annual Fee</label>
                <input class="form-control" id="edit_annual_fee" name="edit_annual_fee">
            </div>

            <div class="form-group">
                <label>Target</label>
                <input class="form-control" id="edit_sales_target" name="edit_sales_target">
            </div>

            <div class="form-group">
                <label>Sales Certification</label>
                <input class="form-control" id="edit_sales_certification" name="edit_sales_certification">
            </div>

            <div class="form-group">
                <label>Engineer Certification</label>
                <input class="form-control" id="edit_engineer_certification" name="edit_engineer_certification">
            </div>
             
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal"><i class=" bx bx-x"></i>&nbspClose</button>
              <button type="submit" class="btn btn-sm btn-success"><i class="bx bx-check"> </i>&nbspUpdate</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scriptImport')
 <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
 <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
 <script type="text/javascript" src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('assets/js/jquery.mask.js')}}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.17/js/adminlte.min.js"></script>
@endsection
@section('script')  
  <script type="text/javascript">
    $(document).ready(function(){
      var accesable = @json($feature_item);
      accesable.forEach(function(item,index){
        $("#" + item).show()
      })
      showTablePartnership(accesable)
      chart()
      card()
      showTodo()
      showAttention()

      $('.nav-tabs a[href="#tab_2"]').tab('show');

    })

    function chart(){
      var pieBrand = document.getElementById("brandPieChart");
      var pieCertificate = document.getElementById("certPieChart");

      var theHelp = Chart.helpers;
      $.ajax({
        type:"GET",
        url:"{{url('/partnership/getCertByBrand')}}",
        success:function(result){
          var totalCertBrand = new Chart(pieBrand, {
            type: 'pie',
            data: {
              labels: result.label,
              indexLabel: "#percent%",
              percentFormatString: "#0.##",
              toolTipContent: "{y} (#percent%)",
              datasets: [{
                data: result.percentage,
                backgroundColor: ["#4589ff","#a56eff","#002d9c","#009d9a","#fa4d56","#9f1853","#f1c21b","#ff832b","#570408","#8a3800"],
              }],
            },
            options: {
              responsive: true, // Enable responsiveness
              maintainAspectRatio: false, 
              legend: {
                display: true
              },
              tooltips: {
                mode: 'label',
                label: 'mylabel',
                callbacks: {
                  label: function(tooltipItem, data) {
                    var percent = data['datasets'][0]['data'][tooltipItem['index']]
                    return percent + "%"
                  },
                },
              },
            },
          });
        }
      }) 

      $.ajax({
        type:"GET",
        url:"{{url('/partnership/getCertByCategory')}}",
        success:function(result){
          var totalCertBrand = new Chart(pieCertificate, {
            type: 'pie',
            data: {
              labels: result.label,
              indexLabel: "#percent%",
              percentFormatString: "#0.##",
              toolTipContent: "{y} (#percent%)",
              datasets: [{
                data: result.percentage,
                backgroundColor: ["#4589ff","#a56eff","#002d9c","#009d9a","#fa4d56","#9f1853","#f1c21b","#ff832b","#570408","#8a3800"],
              }],
            },
            options: {
              responsive: true, // Enable responsiveness
              maintainAspectRatio: false, 
              legend: {
                display: true,
                position:'right',
                labels: {
                  generateLabels: function(chart) {
                    var data = chart.data;
                    if (data.labels.length && data.datasets.length) {
                      return data.labels.map(function(label, i) {
                        var meta = chart.getDatasetMeta(0);
                        var ds = data.datasets[0];
                        var arc = meta.data[i];
                        var custom = arc && arc.custom || {};
                        var getValueAtIndexOrDefault = theHelp.getValueAtIndexOrDefault;
                        var arcOpts = chart.options.elements.arc;
                        var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
                        var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
                        var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);
                        return {
                          text: label + ": " + parseFloat(ds.data[i]).toFixed(2) + "% ",
                          fillStyle: fill,
                          strokeStyle: stroke,
                          lineWidth: bw,
                          hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
                          index: i
                        };
                      });
                    }
                    return [];
                  }
                }
              },
              tooltips: {
                mode: 'label',
                label: 'mylabel',
                callbacks: {
                  label: function(tooltipItem, data) {
                    var percent = data['datasets'][0]['data'][tooltipItem['index']]
                    return percent + "%"
                  },
                },
              },
            },
          });
        }
      })
    }

    function card(){
      $.ajax({
        type:"GET",
        url:"{{url('/partnership/getCountDashboard')}}",
        beforeSend:function(){
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
        },
        success: function(result){
          var prepend = ''
          $.each(result, function(key, value){
            prepend = prepend + '<div class="col-lg-4 col-xs-6">'
              prepend = prepend + '<div class="card text-'+ value.color +'">'
                prepend = prepend + '<div class="card-body">'
                  prepend = prepend + '<div class="d-flex justify-content-between">'
                    prepend = prepend + '<div class="card-info">'
                      prepend = prepend + '<div class="d-flex align-items-center mb-1">'
                        prepend = prepend + '<h5 class="card-title text-white mb-0 me-2 counter">'+ value.title +'</h5>'
                      prepend = prepend + '</div>'
                      prepend = prepend + '<h4 class="text-white">'+ value.count+'</h4>'
                    prepend = prepend + '</div>'
                  prepend = prepend + '</div>'
                prepend = prepend + '</div>'
              prepend = prepend + '</div>'
            prepend = prepend + '</div>'
          })

          $("#cardId").prepend(prepend)

          // $('.counter').each(function () {
          //   var size = $(this).text().split(".")[1] ? $(this).text().split(".")[1].length : 0;
          //   $(this).prop('Counter', 0).animate({
          //     Counter: $(this).text()
          //   }, {
          //     duration: 5000,
          //     step: function (func) {
          //        $(this).text(parseFloat(func).toFixed(size));
          //     }
          //   });
          // });
        }
      })
    }

    function showTodo(){
      var appendList = ""
      $.ajax({
        type:"GET",
        url:"{{url('/partnership/getToDoList')}}",
        success: function(result){
          $('.todo-list').empty("")
          $.each(result.data, function(key,value){
              if(value.status == 'Done'){
                status = 'done'
              }else{
                status = ''
              }

              appendList = appendList + '<li class="' + status + '">'
                appendList = appendList + '<div class="d-flex">'
                  appendList = appendList + ' <span class="handle">'
                    appendList = appendList + '   <i class="bx bx-dots-vertical"></i>'
                      appendList = appendList + ' </span>'
                        appendList += '<div class="form-check">'
                          appendList = appendList + ' <input type="checkbox" style="display:inline" id="checklistBox" class="checked-'+ key + ' form-check-input" data-value="'+ value.id +'">'
                          appendList = appendList + ' <span style="display:inline-block;word-wrap:break-word;width:1060px" class="text form-check-label" id="textList" data-value='+key+'>' + '<b>[' + value.partner + ']</b> - ' + value.target + ' - ' + value.countable + '</span>'
                        appendList += '</div>'
                appendList = appendList + '</div>'
                appendList = appendList + ' <span style="margin-left:30px"> '+ ' created at ' + value.created_at +' </span> '
                appendList = appendList + ' <small class="badge text-bg-warning status-'+ key + ' pull-right">'+ value.status +'</small>'
                appendList = appendList + '</li>'


              return value.id
          })            
          $('.todo-list').append(appendList)

          var accesable = @json($feature_item);

          $.each(result.data, function(key,value){
            if(accesable.includes('checklistBox')){
              $("#checklistBox[data-value='"+ value.id +"']").prop('disabled',false)

            }else{
              $("#checklistBox[data-value='"+ value.id +"']").prop('disabled',true)
            }
          })

          $.each(result.data,function(key,value){
            if(value.status == "Done"){
              $(".checked-"+key).attr("checked","true")
              $(".checked-"+key).prop("disabled",true)
            }

            $('.todo-list').todoList({
              onCheck  : function () {
                $.ajax({
                  type:"POST",
                  url:"{{url('/partnership/updateStatusTarget')}}",
                  data:{
                    _token:"{{csrf_token()}}",
                    id:$(this).data('value')
                  }
                })
                $(".checked-"+key).prop("disabled",true)
                $("small.status-"+key).text("Done")
              },
              onUnCheck: function () {
              }
            });
          })        

          $('.todo-list').sortable({
            placeholder         : 'sort-highlight',
            handle              : '.handle',
            forcePlaceholderSize: true,
            zIndex              : 999999
          });

        },
      }) 
    }

    function showAttention(){
      $.ajax({
        type:"GET",
        url:"{{url('/partnership/getNeedAttention')}}",
        success: function(result){
          var prepend = ''
          $.each(result.data, function(key, value){
            // prepend = prepend + '<li class="item">'
            //   prepend = prepend + ' <div class="product-img">'
            //       if(value.logo == null){
            //         prepend = prepend + '<img class="img-responsive img-circle" src="https://img.freepik.com/premium-vector/default-image-icon-vector-missing-picture-page-website-design-mobile-app-no-photo-available_87543-11093.jpg" style="border:solid #3c8dbc 1.5px" alt="Yuki" style="width: 50px;height:50px;position: relative;">'
            //       }else{
            //         prepend = prepend + '<img class="img-responsive img-circle" style="border:solid #3c8dbc 1.5px" src="{{asset("image/logo_partnership")}}/'+ value.logo+'" alt="Yuki" style="position: relative;object-fit:cover">'
            //       }
            //       prepend = prepend + '</div>'
            //       prepend = prepend + '<div class="product-info">'
            //       prepend = prepend + '<a href="{{url("partnership_detail/")}}/'+ value.id_partnership +'" class="product-title">' + value.partner 
            //       prepend = prepend + '<h6>'
            //       prepend = prepend + '<span class="badge text-bg-warning pull-right">'+ value.level +'</span></a>'
            //       prepend = prepend + '</h6>'
            //       prepend = prepend + '<span class="product-description">'
            //       prepend = prepend + moment(value.renewal_date).format("Do MMMM YYYY")
            //     prepend = prepend + '</span>'
            //   prepend = prepend + '</div>'
            // prepend = prepend + '</li>'

            prepend = prepend + '<div class="list-group">'
              prepend = prepend + '<div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer">'
                if(value.logo == null){
                  prepend = prepend + '<img src="src="https://img.freepik.com/premium-vector/default-image-icon-vector-missing-picture-page-website-design-mobile-app-no-photo-available_87543-11093.jpg" alt="User Image" class="rounded-circle me-3" width="38">'
                }else{
                  prepend = prepend + '<img src="{{asset("image/logo_partnership")}}/'+ value.logo+'" alt="Image not found" class="rounded-circle me-3" width="38">'
                }
                prepend = prepend + '<a href="{{url("partnership_detail/")}}/'+ value.id_partnership +'"'
                  prepend = prepend + '<div class="w-100">'
                    prepend = prepend + '<div class="d-flex justify-content-between">'
                      prepend = prepend + '<div class="user-info">'
                        prepend = prepend + '<h6 class="mb-1 fw-normal">'+ value.partner +'</h6>'
                        prepend = prepend + '<small class="text-body-secondary">'+ moment(value.renewal_date).format("Do MMMM YYYY") +'</small>'
                      prepend = prepend + '</div>'
                      prepend = prepend + '<div class="add-btn">'
                        prepend = prepend + '<h6><span class="badge badge-sm text-bg-warning">'+ value.level  +'</span></h6>'
                      prepend = prepend + '</div>'
                    prepend = prepend + '</div>'
                  prepend = prepend + '</div>'
                prepend = prepend + '</div>'
              prepend = prepend + '</a>'
            prepend = prepend + '</div>'
          })

          $(".attention-list").prepend(prepend)

          if (result.data.length > 0) {
            $("#tabDashboard").find('.badge-notif').text(result.data.length)
          }
        }
      })
    }

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e){
       $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
    });

    function searchCustom(id_table,id_seach_bar){
      $("#" + id_table).DataTable().search($('#' + id_seach_bar).val()).draw();
    }

    function exportExcel(){
      Swal.fire({
        title: 'Are you sure?',
        text: "Make sure there is nothing wrong to get this report!",
        icon: "warning",
        showCancelButton: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        timer: 2000,
      }).then((result) => {
        if (result.value){
          Swal.fire({
            title: 'Please Wait..!',
            text: "Prossesing Data Report",
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
            type:"GET",
            url:"{{url('/downloadExcelPartnership')}}",
            success: function(result){
              Swal.hideLoading()
              if(result == 0){
                Swal.fire({
                  //icon: 'error',
                  title: 'Success!',
                  text: "The file is unavailable",
                  type: 'error',
                  //confirmButtonText: '<a style="color:#fff;" href="report/' + result.slice(1) + '">Get Report</a>',
                })
              }else{
                Swal.fire({
                  title: 'Success!',
                  text: "You can get your file now",
                  type: 'success',
                  confirmButtonText: '<a style="color:#fff;" href="report/partnership/' + result + '">Get Report</a>',
                })
              }
            }
          })        
        }
      })
    }

    function showTablePartnership(accesable){
      var table = $('#tablePartnerhip').DataTable({
        "ajax":{
          "type":"GET",
          "url":"{{url('/partnership/getDataPartnership')}}",
        },
        "columns": [
          { 
            render: function (data, type, row, meta){
              return ++meta.row             
            },
            "visible":false
          },
          { "data": "partner" },
          { "data": "type" },
          { "data": "level"},
          { "data": "renewal_date"},
          { "data": "target"},
          { 
            render: function (data, type, row, meta){
              var append = ""
              $.each(row.total_cert,function(key,value){
                append += "<span>"+row.total_cert[key].combine+"</span>"
              })
              return append;         
            },
            "orderData":[7]
          },
          {
            "data":"total_cert_integer.total_cert",
            "targets":[6],
            "visible":false,
            "searchable":true
          },//number of certification
          { 
            render: function (data, type, row, meta){
              return "<td><a href='{{url('/partnership_detail')}}/"+row.id_partnership+"'><button class='btn btn-sm btn-primary'><i class='bx bx-search-plus'></i> Detail</button></a>&nbsp<button class='btn btn-sm btn-danger btnDeletePartnership' style='vertical-align: top;display:none' onclick='deletePartnership("+ row.id_partnership +")'>Delete</button></td>"
            }
          },//action  
        ],
        "initComplete": function () {
          accesable.forEach(function(item,index){
            $("." + item).show()
          })                    
        },
        columnDefs: [
          { 
            className: "dt-aligment-middle", targets: [1,2,3,4,5,6] 
          }
        ],
        "order": [7, 'desc'],
        "scrollX": true,
        "pageLength":25,
        "visible":false,
        "searchable":true,
        // "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        // "bInfo": false,
        "fixedHeader": true
      })

      if (!(accesable.includes('th-action'))) {
        var column1 = table.column(7);
        column1.visible(!column1.visible());
      }else{
        var column1 = table.column(7);
        column1.visible(column1.visible());
      }
    }  
    
    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
       $("#alert").slideUp(300);
    });

    $('.money').mask('000,000,000,000,000.00', {reverse: true});

    function deletePartnership(id){
      Swal.fire({
        title: 'Delete Certificate User',
        text: "Are you sure?",
        icon: 'question',
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
              url: "{{url('/delete_partnership')}}",
              type: 'post',
              data:{
                "_token": "{{ csrf_token() }}",
                id:id
              },
            success: function(data)
            {
                Swal.showLoading()
                  Swal.fire(
                    'Successfully!',
                    'success'
                  ).then((result) => {
                    if (result.value) {
                      location.reload()
                    }
                })
            }
          }); 
        }    
      })
    }

    function partnership(id_partnership,type,partner,level,renewal_date,annual_fee,sales_target,sales_certification,engineer_certification) {
      $('#edit_id').val(id_partnership);
      $('#edit_type').val(type);
      $('#edit_partner').val(partner);
      $('#edit_level').val(level);
      $('#edit_renewal_date').val(renewal_date);
      $('#edit_annual_fee').val(annual_fee);
      $('#edit_sales_target').val(sales_target);
      $('#edit_sales_certification').val(sales_certification);
      $('#edit_engineer_certification').val(engineer_certification);
    }

    function upload(id_partnership, doc) {
      $('#upload_id_partnership').val(id_partnership);
      $('#upload_doc').val(doc);
    }

    var i = 0;
    function addListCert(){
      i++;
      var append = ""
      append = append + "<tr class='new-list'>"
      append = append + " <td>"
      append = append + " <input data-value='" + i + "' name='cert_type[]' id='cert_type' class='form-control' type='text' placeholder='Ex: Engineer - Profesional'>"
      append = append + " </td>"
      append = append + " <td>"
      append = append + "<input data-value='" + i + "' name='cert_name[]' id='cert_name' class='form-control' type='text' placeholder='Ex: 350-401 ENCOR'>"
      append = append + " </td>"
      append = append + " <td style='white-space: nowrap'>"
      append = append + " <select class='select2 form-control select2-person' data-value='" + i + "' id='select2-person' style='width: 100%!important' name='cert_person[]'></select> "
      append = append + " </td>"
      append = append + " <td class='text-center'>"
      append = append + " <button type='button' style='width: auto !important;' class='btn btn-danger btn-flat btn-trash-list'>"
      append = append + " <i class='bx bx-trash'></i>"
      append = append + " </button>"
      append = append + " </td>"
      append = append + "</tr>"
      
      $("#tbListCert").append(append)
      $.ajax({
        url: "{{url('/partnership/getUser')}}",
        type: "GET",
        success: function(result) {
          var arr = result.data;
          var selectOption = [];
          var otherOption;

          var data = {
            id: '',
            text: 'Select Person'
          };

          selectOption.push(data)
          $.each(arr,function(key,value){
            selectOption.push(value)
          })

          $("#select2-person[data-value='" + i + "']").select2({
              dropdownParent: $('#modalAddPartnership'),
              data: selectOption
          })
        }
      }) 
    }

    $.ajax({
      url: "{{url('/project/getTechTag')}}",
      type: "GET",
      success: function(result) {
        $("#id_technology").select2({
            dropdownParent: $('#modalAddPartnership'),
            placeholder: "Select Technology",
            data: result.results,
            multiple:true
        })
      }
    }) 

    function addSalesTarget(){
      i++;
      var append = ""
      append = append + "<tr class='new-list'>"
      append = append + " <td>"
      append = append + " <input data-value='" + i + "' name='sales_target[]' id='sales_target' class='form-control' type='text' placeholder='ex: Renewal Cisco Gold Partner'>"
      append = append + " </td>"
      append = append + " <td>"
      append = append + "<input data-value='" + i + "' name='countable[]' id='countable' class='form-control' type='text' placeholder='es: USD 2.00 or 4 Specialist'>"
      append = append + " </td>"
      append = append + " </td>"
      // append = append + " <td>"
      // append = append + "<input data-value='" + i + "' name='description[]' id='description' class='form-control' type='text' placeholder='Enter description'>"
      // append = append + " </td>"
      append = append + " <td class='text-center'>"
      append = append + " <button type='button' style='width: auto !important;' class='btn btn-danger btn-flat btn-trash-list'>"
      append = append + " <i class='bx bx-trash'></i>"
      append = append + " </button>"
      append = append + " </td>"
      append = append + "</tr>"
      
      $("#tbSalesTarget").append(append)
    }

    $(document).on('click', '.btn-trash-list', function() {
      $(this).closest("tr").remove();
    });

    var currentTab = 0

    $('#btnAdd').click(function(n){
      showTabAdd(0)
      $('#modalAddPartnership').modal('show')
      // .modal({
      //     backdrop: 'static',
      //     keyboard: false
      // });
    });

    function showTabAdd(n){
      if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
      } else {
        document.getElementById("prevBtn").style.display = "inline";
      }
      var x = document.getElementsByClassName("tab");
      x[n].style.display = "inline";
      for (var i = 0; i < x.length; i++){
          x[n].style.display = "inline";
      }


      if (n == (x.length - 1)) {
        document.getElementById("nextBtn").innerHTML = "Submit";  
        $("#nextBtn").attr('onclick','submitBtnAdd()');
        for (var i = 0; i < x.length; i++){
          x[n].style.display = "inline";
        }       
      } else {
        $("#nextBtn").attr('onclick','nextPrev(1)');
        $("#prevBtn").attr('onclick','nextPrev(-1)')
        document.getElementById("nextBtn").innerHTML = "Next";
        $("#nextBtn").prop("disabled",false)
      }
    } 

    function nextPrev(n){
      if ($("#type").val() == "") {
        $("#type").closest('.form-group').addClass('has-error')
        $("#type").closest('select').next('span').show();
        $("#type").prev('.input-group-addon').css("background-color","red");
      }else if ($("#partner").val() == "") {
        $("#partner").closest('.form-group').addClass('has-error')
        $("#partner").closest('input').next('span').show();
        $("#partner").prev('.input-group-addon').css("background-color","red");
      }else if ($("#levelling").val() == "") {
        $("#levelling").closest('.form-group').addClass('has-error')
        $("#levelling").closest('input').next('span').show();
        $("#levelling").prev('.input-group-addon').css("background-color","red");
      }else if ($("#level").val() == "") {
        $("#level").closest('.form-group').addClass('has-error')
        $("#level").closest('input').next('span').show();
        $("#level").prev('.input-group-addon').css("background-color","red");
      }else if($("#renewal_date").val() == "") {
        $("#renewal_date").closest('.form-group').addClass('has-error')
        $("#renewal_date").closest('input').next('span').show();
        $("#renewal_date").prev('.input-group-addon').css("background-color","red");
      }else{
        var x = document.getElementsByClassName("tab");

        x[currentTab].style.display = "none";
        currentTab = currentTab + n;
        if (currentTab >= x.length) {
          x[n].style.display = "none";
          currentTab = 0;
        } 
        showTabAdd(currentTab);
      }
      
    }

    function checkType(val){
      if (val != "") {
        $("#type").closest('.form-group').removeClass('has-error')
        $("#type").closest('select').next('span').attr('style','display:none!important');
        $("#type").prev('.input-group-addon').css("background-color","red");
      }
    }

    function fillInput(val){
      if (val == "levelling") {
        $("#levelling").closest('.form-group').removeClass('has-error')
        $("#levelling").closest('input').next('span').attr('style','display:none!important');
        $("#levelling").prev('.input-group-addon').css("background-color","red");
      } else if (val == "partner") {
        $("#partner").closest('.form-group').removeClass('has-error')
        $("#partner").closest('input').next('span').attr('style','display:none!important');
        $("#partner").prev('.input-group-addon').css("background-color","red");
      } else if (val == "level") {
        $("#level").closest('.form-group').removeClass('has-error')
        $("#level").closest('input').next('span').attr('style','display:none!important');
        $("#level").prev('.input-group-addon').css("background-color","red");
      } else if (val == "renewal") {
        $("#renewal_date").closest('.form-group').removeClass('has-error')
        $("#renewal_date").closest('input').next('span').attr('style','display:none!important');
        $("#renewal_date").prev('.input-group-addon').css("background-color","red");
      }
    }

    function submitBtnAdd(){
      Swal.fire({
        title: 'Add New Partnership',
        text: "Are you sure?",
        icon: 'question',
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
          var tagCertList = []
          var select2 = ""
          if ($('#tbListCert tr').length != 0) {
            $('#tbListCert tr').each(function() {
              tagCertList.push({
                cert_type:$("#cert_type").val(),
                cert_name:$("#cert_name").val(),
                cert_person:$("#select2-person").select2('data')[0].text
              })
            });
          }

          var tagSalesTarget = []
          if ($('#tbSalesTarget tr').length != 0) {
            $('#tbSalesTarget tr').each(function() {
              tagSalesTarget.push({
                sales_target:$("#sales_target").val(),
                countable:$("#countable").val(),
                description:$("#description").val()
              })
            });
          }

          var tagData = {
            tagCertList:tagCertList,
            tagSalesTarget:tagSalesTarget,
          }

          $.ajax({
              url:"{{'/store_partnership'}}",
              type:'post',
              data:{
                type:$("#type").val(),
                partner:$("#partner").val(),
                levelling:$("#levelling").val(),
                level:$("#level").val(),
                renewal_date:$("#renewal_date").val(),
                annual_fee:$("#annual_fee").val(),
                cam:$("#cam").val(),
                cam_phone:$("#cam_phone").val(),
                cam_email:$("#cam_email").val(),
                email_support:$("#email_support").val(),
                id_mitra:$("#id_mitra").val(),
                tagData:tagData,
                portal_partner:$("#portal_partner").val(),
                _token:"{{ csrf_token() }}",
                id_technology:$("#id_technology").val()
              }, // serializes the form's elements.
            success: function(response)
            { 
                Swal.showLoading()
                Swal.fire({
                  title: 'Success!',
                  text: 'Lanjutkan ke halaman detail partner',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK',
                  cancelButtonText: 'NO',
                }).then((result) => {
                  if (result.value) {
                    window.location.href = "{{url('partnership_detail')}}/" + response
                  }else{
                    location.reload()
                  }
                });
            }
          }); 
        }    
      })
    }

  </script>
@endsection