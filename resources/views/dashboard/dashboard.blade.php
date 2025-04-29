@extends('template.main_sneat')
@section('tittle')
Dashboard
@endsection
@section('pageName')
Dashboard | &nbsp<small><b id="waktu"></b></small>
@endsection
@section('head_css')
  <!-- <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'"> -->
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />

  <style type="text/css">
    .icon{
      width: 90px;
    }
    
    .table-sip tbody tr:first-child td {
        background-color: #ffd324;
    }

    .table-msp tbody tr:first-child td {
        background-color: #ffd324;
    }

    .table-sip-ter tbody tr:first-child td{
      background-color: dodgerblue;
      color: white;
    }

    .table-sip-ter tbody tr:first-child td a i{
      color: white;
    }

    #table-win-project-territory-non-detail tr td{
      color: white;
    }

    #table-win-project-territory tr td{
      color: white!important;
    }

    .outer-reset {
      position: relative;
      width: 100%;
      height: 150px;
      background: red;
    }

    .inner-reset {
      position: absolute;
      top: 50%; left: 50%;
      transform: translate(-50%,-50%);
      padding: 2rem;
      font-size: 60px;
    }

    .div-filter-year .btn-flat{
        border-radius: 5px!important;
        color: #999;
        font-weight: 400;
        width: 100%!important;
        background-color: #fff;
    }

    .div-filter-year .btn-flat i {
      color: lightgray;
    }

    .div-filter-year .btn-flat:active{
        color: black;
        font-weight: 500;
        width: 100%!important;
        background-color: #fff;
        border-color: #696cff!important;
    }

    .div-filter-year .btn-flat:hover{
        color: black;
        font-weight: 500;
        width: 100%!important;
        background-color: #fff;
        border: 1px solid #696cff!important;
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);
    }

    .div-filter-year .btn-flat:hover i {
      color: slategray;
    }

    .div-filter-year .btn-flat.isClicked {
      color: black;
      font-weight: 500;
      width: 100%!important;
      background-color: #fff;
      border:3px solid #696cff!important;
    }

    .div-filter-year .btn-flat.isClicked i {
      color: slategrey;
    }

    .div-filter-year .select2-container--default .select2-selection--single{
        border-radius: 5px!important;
    }

    .text-bg-blue{
        background-color: #0077b5!important;
    }

    .form-group{
      margin-bottom: 15px;
    }
    .swal2-deny{
      display: none!important;
    }
  </style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <!-- <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="javascript:void(0);">Dashboard</a>
      </li>
      <li class="breadcrumb-item">
        <a href="javascript:void(0);">Home</a>
      </li>
    </ol>
  </nav> -->
  <section class="content">
    <!--Box-->
    <div class="row" style="display: none;" id="divSelectYear">
      <div class="col-md-4">
        <div class="div-filter-year form-group">
            <button class="btn btn-sm btn-flat btn-outline-primary" id="btnThisYear" onclick="clickYear(this.value)"><i class="bx bx-filter"></i> &nbspThis Year</button>
        </div>
      </div>
      <div class="col-md-4">
        <div class="div-filter-year form-group">
            <button class="btn btn-sm btn-flat btn-outline-primary" id="btnLastYear" onclick="clickYear(this.value)"><i class="bx bx-filter"></i> &nbspLast Year</button>
        </div>
      </div>
      <div class="col-md-4">
        <div class="div-filter-year form-group">
            <select class="select2 form-select" style="width: 100%!important;" id="selectYear" onchange="clickYear(this.value)"><option></option></select>
        </div>
      </div>
    </div>
    <!--  <div style="margin-bottom: 10px;display: none;" id="divSelectYear">
      <select class="form-control" id="selectYear" style="width: 100%!important;">
        <option></option>
      </select>
    </div> -->
    <div class="row mb-4" id="BoxId" style="display:none!important;"><!-- ./col --> </div>

    <!--Chart-->
    <div class="row g-6" id="BoxTopWin" style="display:none!important;">
      <!-- <div class="col-md-6 mb-4" id="sipTop5" style="display:none!important;">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h6 class="m-0 me-2">TOP 5 (WIN Projects) - SIP</h6>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <?php $no_sip = 1; ?>
              <table class="table card-table table-border-top-0">
                <thead>
                  <tr>
                    <th width="5%"><center>No.</center></th>
                    <th><center>Sales Name</center></th>
                    <th width="20%"><center>Total Amount</center></th>
                    <th width="10%"><center>Total</center></th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tbody-table-sip-win">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div> -->
      <div class="col-lg-6 col-xs-12 mb-4">
        <div class="card card-primary">
          <div class="card-header with-border">
            <h6 class="card-title"><i>WIN Projects Per Territory</i></h6>
            <h6 class="card-title pull-right"><b>SIP</b></h6>
          </div>
          <div class="card-body">
            <?php $no_sip = 1; $territory= ""?>
            <table class="table table-bordered table-sip-all-ter" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th width="5%"><center>No.</center></th>
                  <th><center>Territory</center></th>
                  <th width="20%" align="right"><center>Total Amount</center></th>
                  <th width="10%"><center>Total</center></th>
                </tr>
              </thead>
              <tbody id="table-win-project-territory">
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-6 mb-4" id="BoxTopWinTerritoryNonDetail" style="display:none!important;">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h6 class="m-0 me-2">WIN Projects Per Territory - SIP</h6>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <?php $no_sip = 1; $territory= ""?>
              <table class="table card-table table-border-top-0 table-sip-all-ter-non-detail">
                <thead>
                  <tr>
                    <th width="5%"><center>No.</center></th>
                    <th><center>Territory</center></th>
                    <th width="20%" align="right"><center>Total Amount</center></th>
                    <th width="10%"><center>Total</center></th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="table-win-project-territory-non-detail">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 mb-4" id="mspTop5" style="display:none!important;">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h6 class="m-0 me-2">TOP 5 (WIN Projects) - MSP</h6>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <?php $no_msp = 1; ?>
              <table class="table card-table table-border-top-0">
                <thead>
                  <tr>
                    <th width="5%"><center>No.</center></th>
                    <th><center>Sales Name</center></th>
                    <th width="20%"><center>Total Amount</center></th>
                    <th width="10%"><center>Total</center></th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tbody-table-msp-win">
                </tbody>
              </table>
            </div>
          </div>
        </div> 
        <!--     <div class="card h-100">
          <div class="card-body pb-4">
            <span class="d-block fw-medium mb-1">Order</span>
            <h6 class="card-title mb-0">276k</h6>
          </div>
          <div id="growthChart"></div>
        </div> -->
      </div>

 <!--      <div class="col-md-6 mb-4" id="salesWinTerritory" style="display:none!important;">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h6 class="m-0 me-2">WIN Projects {{Auth::User()->id_territory}} - SIP</h6>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <?php $no_sip = 1; ?>
              <table class="table card-table table-border-top-0">
                <thead>
                  <tr>
                    <th width="5%"><center>No.</center></th>
                    <th><center>Sales Name</center></th>
                    <th width="20%"><center>Total Amount</center></th>
                    <th width="10%"><center>Total</center></th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="tbody-table-sip-ter">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>  -->
    </div>

    <div class="row mb-4" id="BoxTopWinTerritory" style="display:none!important;">
      <!--       <div class="col-lg-3 col-xs-12" id="boxCharPietWinLose">
        <div class="box box-danger">
            <div class="box-header with-border">
              <h6 class="box-title">Win/Lose</h6>
            </div>
            <div class="box-body">
              <canvas id="myDoughnutChart" width="100%" height="100%"></canvas>
          </div>
        </div>
      </div> -->

      <div class="col-xxl-6 col-xs-12" id="boxCharPietWinLose">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h6 class="m-0 me-2">Win/Lose</h6>
            </div>
          </div>
          <div class="card-body">
            <div id="myDoughnutChart" width="100%" height="600px"></div>
            <!-- <canvas id="myDoughnutChart" width="100%" height="100%"></canvas> -->
          </div>
        </div>
      </div>

      <div class="col-xxl-6 col-xs-12">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h6 class="m-0 me-2">Status Lead Register</h6>
            </div>
          </div>
          <div class="card-body">
            <div id="myPieChart" width="100%" height="100%"></div>
            <!-- <canvas id="myPieChart" width="100%" height="100%"></canvas> -->
          </div>
        </div>
      </div>
    </div>        
      
    <div class="row" id="BoxTotalLead" style="display:none!important;margin-top: 20px;">
      <div class="col-xxl-6 col-xs-12" id="boxChartTotalAmountLead">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h6 class="m-0 me-2">Total Amount Lead Register (Deal Price)</h6>
            </div>
          </div>
          <div class="card-body">
            <div id="AreaChart2019"></div>
            <!-- <canvas id="AreaChart2019"></canvas> -->
          </div>
        </div>
      </div>

      <div class="col-xxl-6 col-xs-12" id="boxChartTotalLead">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h6 class="m-0 me-2">Total Lead Register</h6>
            </div>
          </div>
          <div class="card-body">
            <div id="myBarChart"></div>
            <!-- <canvas id="myBarChart"></canvas> -->
          </div>
        </div>
      </div>
    </div>

    <div class="row" style="margin-top: 20px;">
      <div class="col-xxl-12 col-xs-12" id="boxChartTotalAmountLeadByStatus" style="display:none!important;">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h6 class="m-0 me-2">Total Amount Lead Register (By Status)</h6>
            </div>
          </div>
          <div class="card-body">
            <div id="barChartByStatus"></div>
          </div>
        </div>
      </div> 
    </div>

    <div class="row" id="BoxTotalLeadByStatus" style="display:none!important;">
      <div class="col-xxl-12 col-xs-12" id="boxChartTotalAmountLeadByStatus" style="display:none!important;">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h6 class="m-0 me-2">Total Amount Lead Register (By Status)</h6>
            </div>
          </div>
          <div class="card-body">
            <canvas id="barChartByStatus"></canvas>
          </div>
        </div>
      </div> 

      <div class="col-xxl-3 col-xs-12" id="boxChartDonutWinLose2" style="display:none!important;">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h6 class="m-0 me-2">Win/Lose</h6>
            </div>
          </div>
          <div class="card-body">
            <canvas id="myDoughnutChart2"></canvas>
          </div>
        </div>
      </div>

      <div class="col-xxl-3 col-xs-12" id="boxCharPietWinLose2" style="display:none!important;">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h6 class="m-0 me-2">Status Lead Register</h6>
            </div>
          </div>
          <div class="card-body">
            <canvas id="myPieChart2"></canvas>
          </div>
        </div>
      </div>       
    </div>
  </section>

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="exampleModalLabel">Ready to Leave?</h6>
          <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          Select "Logout" below if you are ready to end your current session.
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="{{ url('/login')}}">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <div id="popUp" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal">
          </button>
          <h6 class="modal-title">ANNOUNCEMENT</h6>
        </div>
        <div class="modal-body">
          <h6 class="box-title text-center">
            <b>SALES APP</b><br><i>(Tender Process)</i>
          </h6>
          <div class="row">
            <div class="col-md-12">
              <h6>
                Dear all Sales,<br><br>
                Terdapat beberapa penyesuaian untuk Lead Register dengan rincian sebagai berikut:<br><br>
                <ul>
                  <li>Submitted Price adalah harga nego.<br></li>
                  <li>Deal Price adalah harga sesuai PO.<br><br></li>
                </ul>
                <b>Penyesuaian untuk Request PID :</b><br>
                <p>Lead yang memiliki tanggal PO tahun lalu (backdate) harap email manual pada Bu Anee seperti proses manual sebelumnya, re:<i>yuliane@sinergy.co.id</i>. Dikarenakan semua PID yang melalui sistem hanya di peruntukkan untuk tanggal PO di tahun ini</p>
                <br>
                Untuk pengisian proses "Tender Process" terdapat beberapa perubahan:<br><br>
                <ul>
                  <li>Terdapat penambahan status Project Class (Multiyears / Blanket / Normal) yang wajib diisi.<br></li>
                  <li>Project Class Normal untuk project dalam tahun ini, Multiyears project beberapa tahun, dan Blanket adalah project dengan model kontrak payung.<br></li>
                  <li>Jumlah Tahun & Deal Price Total wajib diisi saat memilih Project Class Multiyears / Blanket.<br></li>
                  <li>Untuk status Normal, Deal Price adalah nominal sesuai PO.<br></li>
                  <li>Untuk status Multiyears / Blanket, Deal Price adalah PO tahun ini dan Deal Price Total adalah total nominal PO keseluruhan<br><br></li>
                </ul>
                <b>Mohon Deal Price diisi untuk perhitungan dan report.</b><br><br>
                
                Terkait perubahan tersebut, Lead Register yang ber-status Win bisa di edit kembali untuk pengisian Deal Price.<br><br>
                Terimakasih.
              </h6>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

  <div id="changePasswordAlert" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header outer-reset">
          <button type="button" class="btn-close" style="width: 20px;" data-bs-dismiss="modal"></button>
          <div class="inner-reset">
            <i class="bx bx-error bx-lg" style="color: white;font-size: larger!important;"></i>
          </div>
        </div>
        <div class="modal-body">
          <h6 style="text-align: center;"><b>Please change default password to protect your account !</b></h6>
            <a href="{{url('/profile_user')}}#changePassword" style="margin:80px">
              <span class="btn btn-sm btn-info btn-block" style="border-radius: 24px">Change Password</span>
            </a>
          <span data-bs-dismiss="modal" style="cursor: pointer;">
            <h6 class="text-center" style="color: #00acd6">Skip Now</h6>
          </span>
        </div>
        <div class="modal-footer">
          <p class="text-center">©SIMS - {{date('Y')}}</p>              
        </div>
      </div>
    </div>
  </div>

  <div id="ideaHub" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content modal-style">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal">
          </button>
          <h6 class="modal-title">IDEA HUB</h6>
        </div>
        <div class="modal-body">
          <h6 class="box-title text-center">
            <b>You have a business idea?</b><br>Please fill in the form below
          </h6>
          <form action="">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="">Idea*</label>
                  <input type="text" class="form-control" name="idea" id="idea" placeholder="Input ide anda" onkeyup="fillInput('idea')" required>
                  <span class="invalid-feedback" style="display:none!important;">Please fill Idea!</span>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="">Business Concept*</label>
                  <textarea class="form-control" name="konsep_bisnis" id="konsep_bisnis" cols="30" rows="10" onkeyup="fillInput('konsep_bisnis')" required></textarea>
                  <span class="invalid-feedback" style="display:none!important;">Please fill Business Concept!</span>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="">Reference*</label>
                  <textarea class="form-control" name="referensi_bisnis" id="referensi_bisnis" cols="30" rows="10" onkeyup="fillInput('referensi')" required></textarea>
                  <span class="invalid-feedback" style="display:none!important;">Please fill Reference!</span>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-sm btn-primary" id="submitIdea">Submit</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scriptImport')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script> -->
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
<!-- Vendors JS -->
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection
@section('script')
<script type="text/javascript">
  let accesable = @json($feature_item);
  console.log(accesable)
  accesable.forEach(function(item,index){
    $("#" + item).show()
    $("." + item).show()
  })

  let cardColor, headingColor, legendColor, labelColor, shadeColor, borderColor;

  if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    headingColor = config.colors_dark.headingColor;
    legendColor = config.colors_dark.bodyColor;
    labelColor = config.colors_dark.textMuted;
    borderColor = config.colors_dark.borderColor;
  } else {
    cardColor = config.colors.cardColor;
    headingColor = config.colors.headingColor;
    legendColor = config.colors.bodyColor;
    labelColor = config.colors.textMuted;
    borderColor = config.colors.borderColor;
  }

  $(document).ready(function(){
    startTime()
    initiateSmallBox(moment().year(),"initiate")

    let userDivision = "{{ Auth::User()->id_division }}";
    let dontLoad = sessionStorage.getItem("dontLoad");

    if (dontLoad === null || dontLoad === 'null') {
      if (userDivision === "SALES") {
        $("#ideaHub").modal("show");

        $("#ideaHub").on("hidden.bs.modal", function () {
          $("#popUp").modal("show");
        });
      } else {
        $("#ideaHub").modal("show");
      }
      sessionStorage.setItem("dontLoad", "true");
      console.log(dontLoad);
    }else{
      $("#ideaHub").modal("show");
    }

    if("{{Auth::User()->isDefaultPassword}}" == 'true'){
      // $("#changePasswordAlert").modal('show')
      $("#changePasswordAlert").modal('show')
    }


    $("#submitIdea").click(function () {
      let idea = $("#idea").val();
      let konsepBisnis = $("#konsep_bisnis").val();
      let deskripsiBisnis = $("#deskripsi_bisnis").val();
      let referensiBisnis = $("#referensi_bisnis").val();

      if (!idea) {
        $("#idea").closest('.form-group').addClass('needs-validation')
        $("#idea").next('.invalid-feedback').show();
        $("#idea").prev('.input-group-text').css("background-color","red");
      }else if(!konsepBisnis){
        $("#konsep_bisnis").closest('.form-group').addClass('needs-validation')
        $("#konsep_bisnis").next('.invalid-feedback').show();
        $("#konsep_bisnis").prev('.input-group-text').css("background-color","red");
      }else if(!referensiBisnis){
        $("#referensi_bisnis").closest('.form-group').addClass('needs-validation')
        $("#referensi_bisnis").next('.invalid-feedback').show();
        $("#referensi_bisnis").prev('.input-group-text').css("background-color","red");
      }else{
        $.ajax({
          url: "{{ url('/idea_hub/store') }}",
          type: "POST",
          data: {
            _token: "{{ csrf_token() }}",
            idea: idea,
            konsep_bisnis: konsepBisnis,
            referensi_bisnis: referensiBisnis
          },
          beforeSend: function () {
            $("#submitIdea").prop("disabled", true).text("Mengirim...");
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
          success: function (response) {
            Swal.close();
            Swal.fire(
                    'Successfully!',
                    'Your Idea has been submited.',
                    'success'
            )
            $("#ideaHub").modal("hide");
            sessionStorage.setItem("dontLoad", "true");
          },
          error: function (xhr) {
            Swal.fire(
                    'Error!',
                    'Something Went Wrong, Please Try Again!',
                    'error'
            )
            console.error(xhr.responseText);
          },
          complete: function () {
            $("#submitIdea").prop("disabled", false).text("Submit");
          }
        });
      }
    });

    $("#ideaHub").on("hidden.bs.modal", function () {
      let userRole = "{{ Auth::User()->id_division }}";
      if (userRole === "SALES") {
        $("#popUp").modal("show");
      }
    });
  });

  function startTime() {
      var today = new Date();
      var time = moment(today).format('MMMM Do YYYY, h:mm:ss a');
      var h = today.getHours();
      var m = today.getMinutes();
      var s = today.getSeconds();
      m = checkTime(m);
      s = checkTime(s);
      document.getElementById('waktu').innerHTML =  time;
      var t = setTimeout(startTime, 500);
  }

  let i = 0
  function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
  }

  function fillInput(val) {
    if (val == "idea") {
      $("#idea").closest('.form-group').removeClass('needs-validation')
      $("#idea").closest('.form-group').find('.invalid-feedback').attr('style','display:none!important');
      $("#idea").prev('.input-group-text').css("background-color", "red");
    } else if (val == "konsep_bisnis") {
      $("#konsep_bisnis").closest('.form-group').closest('.form-group').removeClass('needs-validation')
      $("#konsep_bisnis").closest('.form-group').find('.invalid-feedback').attr('style','display:none!important');
      $("#konsep_bisnis").prev('.input-group-text').css("background-color", "red");
    } else if (val == "referensi") {
      $("#referensi_bisnis").closest('.form-group').closest('.form-group').removeClass('needs-validation')
      $("#referensi_bisnis").closest('.form-group').find('.invalid-feedback').attr('style','display:none!important');
      $("#referensi_bisnis").prev('.input-group-text').css("background-color", "red");
    }
  }

  function initiateSmallBox(year,status){
    $.ajax({
      type:"GET",
      url:"{{url('/getDashboardBox')}}?year="+year,
      success: function(result){
        var colors = []
        var prepend = ""  

        if ("{{Auth::User()->name == 'TECH HEAD'}}") {
            var ArrColors = [
              {name:'Lead Register',color:'bg-aqua',icon:'bx bx-list-ul',count:result.lead,url:"report_range/All?year="+ year},
              {name:'Occuring',color:'bg-orange',icon:'bx bx-book',count:result.open,url:"report_range/OPEN?year="+ year},
              {name:'Win',color:'bg-green',icon:'bx bx-calendar-check',count:result.win,url:"report_range/WIN?year="+ year},
              {name:'Lose',color:'bg-red',icon:"bx bx-calendar-x",count:result.lose,url:"report_range/LOSE?year="+ year}
            ]
            colors.push(ArrColors)
        }else{
          var ArrColors = [
            {name:'Lead Register',color:'bg-aqua',icon:'bx bx-list-ul',count:result.lead,url:"report_range/ALL?year="+ year},
            {name:'Occuring',color:'bg-orange',icon:'bx bx-book',count:result.open,url:"report_range/OPEN?year="+ year},
            {name:'Win',color:'bg-green',icon:'bx bx-calendar-check',count:result.win,url:"report_range/WIN?year="+ year},
            {name:'Lose',color:'bg-red',icon:"bx bx-calendar-x",count:result.lose,url:"report_range/LOSE?year="+ year}]
            colors.push(ArrColors)
        }

        $.each(colors[0], function(key, value){
          prepend = prepend + '<div class="col-lg-3 col-xs-6 clickDiv" data-value="'+ key +'" onclick="clickableDiv('+"'"+ value.url +"'"+')">'
            prepend = prepend + '<div class="card card-border-shadow-primary h-100">'
            prepend = prepend + '  <div class="card-body">'
            prepend = prepend + '    <div class="d-flex align-items-center mb-2">'
            prepend = prepend + '      <div class="avatar me-4">'
            prepend = prepend + '        <span class="avatar-initial rounded bg-label-primary"><i class="'+value.icon+' icon-lg"></i></span>'
            prepend = prepend + '      </div>'
            prepend = prepend + '      <h4 class="mb-0">'+value.count+'</h4>'
            prepend = prepend + '    </div>'
            prepend = prepend + '    <p class="mb-2">'+value.name+'</p>'
            prepend = prepend + '    <p class="mb-0">'
            prepend = prepend + '    </p>'
            prepend = prepend + '  </div>'
            prepend = prepend + '</div>'
          prepend = prepend + '</div>'
        })

        if (status == "initiate") {
          $("#BoxId").prepend(prepend)
        }else{
          $.each(colors[0], function(key, value){
            $(".counter[data-value='"+ key +"']").text(value.count)
            $(".clickDiv[data-value='"+ key +"']").attr('onclick','clickableDiv('+"'"+ value.url +"'"+')')
          })
        }

        $('.counter').each(function () {
          var size = $(this).text().split(".")[1] ? $(this).text().split(".")[1].length : 0;
          $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
          }, {
            duration: 1000,
            step: function (func) {
               $(this).text(parseFloat(func).toFixed(size));
            }
          });
        });

        var counterValue = $(".counter").text().split(".")[1] ? $(this).text().split(".")[1].length : 0;
        var targetValue = $(".counter").text().split(".")[1] ? $(this).text().split(".")[1].length : 0; // Change this to your desired final value
        var animationDuration = 2000; // Animation duration in milliseconds
        var intervalDuration = 20; // Interval duration for smooth animation

        var interval = setInterval(function() {
            counterValue += Math.ceil(targetValue / (animationDuration / intervalDuration));
            if (counterValue >= targetValue) {
                counterValue = targetValue;
                clearInterval(interval);
            }
            $(".counter").text(counterValue);
        }, intervalDuration);
      }
    })
  }

  function clickableDiv(url){
    window.location = "{{url('/project/index')}}/?status=" + url.split('/')[1]
    // localStorage.setItem('status_lead',url.split('/')[1])
  }

  function initiateTopWinTer(year, status) {
    $.ajax({
      url: "{{url('/getTopWinSipTer')}}?year=" + year,
      type: "GET",
      success: function(result) {
        $("#tbody-table-sip-ter").empty();
        var append = "";
        var no = 1;

        $.each(result, function(territory, dataArray) {
          $.each(dataArray, function(index, data) {
            append += '<tr>';
            append += '<td>' + no++ + '</td>';
            append += '<td>' + data.id_territory + '</td>';
            append += '<td align="right"><i>' + new Intl.NumberFormat('id').format(data.sum_amounts) + '</i></td>';
            append += '<td><center>(' + data.leads_total + ')</center></td>';
            append += '</tr>';

            $.each(data.details, function(detailKey, detailValue) {
              append += '<tr>';
              append += '<td colspan="2" style="padding-left: 20px;">' + detailValue.name + '</td>';
              append += '<td align="right">' + new Intl.NumberFormat('id').format(detailValue.deal_prices) + '</td>';
              append += '<td><center>' + detailValue.leads + '</center></td>';
              append += '</tr>';
            });
          });
        });

        $("#tbody-table-sip-ter").html(append);
      }
    });
  }

  function initiateTopWinEachTerNonDetail(year, status) {
    $.ajax({
      url: "{{url('/getTopWinSipTerNonDetail')}}?year=" + year,
      type: "GET",
      success: function(result) {
        $("#table-win-project-territory-non-detail").empty();
        var append = "";
        var no = 1;

        $.each(result, function(key, value) {
            append += '<tr class="text-bg-primary">';
            append += '<td>' + no++ + '</td>';
            append += '<td>' + key + '</td>';
            append += '<td align="right"><i>' + new Intl.NumberFormat('id').format(value[0].sum_amounts) + '</i></td>';
            append += '<td><center>(' + value[0].leads_total + ')</center></td>';
            append += '</tr>';

            append += '<tr>';
            append += '<td colspan="4" class="hiddenRow">';
            append += '<div id="details-' + key.replace(/\s+/g, '-') + '" class="collapse">';

            append += '<table class="table table-condensed">';
            append += '<thead>';
            append += '<tr>';
            append += '<th>Name</th>';
            append += '<th>Total Amount</th>';
            append += '<th>Total Leads</th>';
            append += '</tr>';
            append += '</thead>';
            append += '</table>';
            append += '</div>';
            append += '</td>';
            append += '</tr>';
        });

        $("#table-win-project-territory-non-detail").html(append);
      }
    });
  }

  function initiateTopWinEachTer(year, status) {
    $.ajax({
      url: "{{url('/getTopWinSipTer')}}?year=" + year,
      type: "GET",
      success: function(result) {
        $("#table-win-project-territory").empty();
        var append = "";
        var no = 1;

        $.each(result, function(key, value) {
          if (key === "TOTAL") {
            append += '<tr class="text-bg-primary">';
            append += '<td>' + no++ + '</td>';
            append += '<td>' + key + '</td>';
            append += '<td align="right"><i>' + new Intl.NumberFormat('id').format(value[0].sum_amounts) + '</i></td>';
            append += '<td><center>(' + value[0].leads_total + ')</center></td>';
            append += '</tr>';
          } else {
            append += '<tr data-bs-toggle="collapse" data-bs-target="#details-' + key.replace(/\s+/g, '-') + '" class="text-bg-primary accordion-toggle">';
            append += '<td>' + no++ + '</td>';
            append += '<td>' + key + '</td>';
            append += '<td align="right"><i>' + new Intl.NumberFormat('id').format(value[0].sum_amounts) + '</i></td>';
            append += '<td><center>(' + value[0].leads_total + ')</center></td>';
            append += '</tr>';

            append += '<tr>';
            append += '<td colspan="4" class="hiddenRow">';
            append += '<div id="details-' + key.replace(/\s+/g, '-') + '" class="collapse">';

            append += '<table class="table table-condensed">';
            append += '<thead>';
            append += '<tr>';
            append += '<th>Name</th>';
            append += '<th>Total Amount</th>';
            append += '<th>Total Leads</th>';
            append += '</tr>';
            append += '</thead>';
            append += '<tbody>';

            $.each(value[0].details, function(detailKey, detailValue) {
              append += '<tr class="text-bg-primary">';
              append += '<td>' + detailValue.name + '</td>';
              append += '<td align="right">' + new Intl.NumberFormat('id').format(detailValue.deal_prices) + '</td>';
              append += '<td><center>' + detailValue.leads + '</center></td>';
              append += '</tr>';
            });

            append += '</tbody>';
            append += '</table>';
            append += '</div>';
            append += '</td>';
            append += '</tr>';

            // Remove the collapse toggle behavior
            // append += '<tr style="background-color:dodgerblue;color: white;">';
            // append += '<td>' + no++ + '</td>';
            // append += '<td>' + key + '</td>';
            // append += '<td align="right"><i>' + new Intl.NumberFormat('id').format(value[0].sum_amounts) + '</i></td>';
            // append += '<td><center>(' + value[0].leads_total + ')</center></td>';
            // append += '</tr>';

            // append += '<tr>';
            // append += '<td colspan="4">';
            // // Display the details without collapsing
            // append += '<table class="table table-condensed">';
            // append += '<thead>';
            // append += '<tr>';
            // append += '<th>Name</th>';
            // append += '<th>Total Amount</th>';
            // append += '<th>Total Leads</th>';
            // append += '</tr>';
            // append += '</thead>';
            // append += '<tbody>';

            // $.each(value[0].details, function(detailKey, detailValue) {
            //   append += '<tr>';
            //   append += '<td>' + detailValue.name + '</td>';
            //   append += '<td align="right">' + new Intl.NumberFormat('id').format(detailValue.deal_prices) + '</td>';
            //   append += '<td><center>' + detailValue.leads + '</center></td>';
            //   append += '</tr>';
            // });

            // append += '</tbody>';
            // append += '</table>';
            // append += '</td>';
            // append += '</tr>';
          }
        });

        $("#table-win-project-territory").html(append);
      }
    });
  }

  initiateTableSipWin(moment().year())
  function initiateTableSipWin(year){
    $.ajax({
      url:"{{url('/getTopWinSip')}}?year="+year,
      type:"GET",
      success:function(result){
        $("#tbody-table-sip-win").empty()
          var append = ""
          var no = 1

        $.each(result, function(key, value){
          append = append + '<tr>'
            append = append + '<td>'+ no++ +'</td>'
            append = append + '<td>'+value.name+'</td>'
            append = append + '<td align="right">'
            append = append + '<i>'+ new Intl.NumberFormat('id').format(value.deal_prices) +'</i>'
            append = append + '</td>'
            append = append + '<td><center>('+value.leads+')</center></td>'
          append = append + '</tr>'
        });

        $("#tbody-table-sip-win").html(append)
      }
    })
  }

  initiateTableMspWin(moment().year())
  function initiateTableMspWin(year){
    $.ajax({
      url:"{{url('/getTopWinMsp')}}?year="+year,
      type:"GET",
      success:function(result){
        $("#tbody-table-msp-win").empty()
          var append = ""
          var no = 1

        $.each(result, function(key, value){
          append = append + '<tr>'
            append = append + '<td>'+ no++ +'</td>'
            append = append + '<td>'+value.name+'</td>'
            append = append + '<td align="right">'
            append = append + '<i>'+ new Intl.NumberFormat('id').format(value.deal_prices) +'</i>'
            append = append + '</td>'
            append = append + '<td><center>('+value.leads+')</center></td>'
          append = append + '</tr>'
        });

        $("#tbody-table-msp-win").html(append)
      }
    })
  }

  var barThickness = "15"
  if (accesable.includes('boxChartDonutWinLose2')) {
    barThickness = "8"
    $("#boxChartTotalAmountLeadByStatus").removeClass('col-lg-12 col-xs-12').addClass('col-lg-6 col-xs-12')
  }

    var ctx = document.getElementById("AreaChart");
    var ctx2 = document.getElementById("myBarChart");
    var ctx3 = document.getElementById("myBarChart2");
    var ctx4 = document.getElementById("myBarChart3");
    var ctx5 = document.getElementById("myPieChart");
    var ctx6 = document.getElementById("myPieChart2");
    var ctx7 = document.getElementById("myDoughnutChart");
    var ctx18 = document.getElementById("myDoughnutChart2");
    var ctx8 = document.getElementById("DoughnutchartClaim");
    var ctx9 = document.getElementById("AreaChart2");
    var ctx10 = document.getElementById("Chartempty");
    var ctx13 = document.getElementById("AreaChartEmpty");
    var ctx14 = document.getElementById("AreaChart2019")
    var ctx15 = document.getElementById("myPieChartEmpty");
    var ctx16 = document.getElementById("AreaChart2018");
    var ctx17 = document.getElementById("barChartByStatus");

    //Apex chart
    var chart18 = document.querySelector("#myDoughnutChart");

    initiateAmountLead(moment().year())
    var initiateMybarChartByStatus = ''
    function initiateAmountLead(year){
      if (initiateMybarChartByStatus) {
        console.log("destroy dulu")
        initiateMybarChartByStatus.destroy()
      }

      $.ajax({
        type:"GET",
        url:"{{url('getChartByStatus?year=')}}"+year,
        success:function(result){
          var INITIAL = result.data.map(function(e) {
            return e.INITIAL
          })

          var OPEN = result.data.map(function(e) {
              return e.OPEN
          })

          var SD = result.data.map(function(e) {
              return e.SD
          })

          var TP = result.data.map(function(e) {
              return e.TP
          })

          var WIN = result.data.map(function(e) {
              return e.WIN
          })

          var LOSE = result.data.map(function(e) {
              return e.LOSE
          })

          var amount_INITIAL = result.data.map(function(e) {
              return e.amount_INITIAL
          })

          var amount_OPEN = result.data.map(function(e) {
              return e.amount_OPEN
          })

          var amount_SD = result.data.map(function(e) {
              return e.amount_SD
          })

          var amount_TP = result.data.map(function(e) {
              return e.amount_TP
          })

          var amount_WIN = result.data.map(function(e) {
              return e.amount_WIN
          })

          var amount_LOSE = result.data.map(function(e) {
              return e.amount_LOSE
          })

          // var barChartByStatus = new Chart(ctx17, {
          //   type: 'bar',
          //   data: {
          //         labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "Oktober", "November", "Desember"],
          //         labels2:[amount_INITIAL,amount_OPEN,amount_SD,amount_TP,amount_WIN,amount_LOSE],        
          //     datasets: [{
          //         label: "INITIAL",
          //         backgroundColor: "#7735a3",
          //         borderColor: "#7735a3",
          //         data: INITIAL,
          //         barPercentage: 0.10,
          //         barThickness: barThickness,
          //     },
          //     {
          //         label: "OPEN",
          //           backgroundColor: "#f2562b",
          //           borderColor: "#f2562b",
          //         data: OPEN,
          //         barPercentage: 0.10,
          //         barThickness: barThickness,
          //     },
          //     {
          //         label: "SD",
          //           backgroundColor: "#04dda3",
          //           borderColor: "#04dda3",
          //         data: SD,
          //         barPercentage: 0.10,
          //         barThickness: barThickness,
          //     },
          //     {
          //         label: "TP",
          //           backgroundColor: "#f7e127",
          //           borderColor: "#f7e127",
          //         data: TP,
          //         barPercentage: 0.10,
          //         barThickness: barThickness,
          //     },
          //     {
          //         label: "WIN",
          //           backgroundColor: "#246d18",
          //           borderColor: "#246d18",
          //         data: WIN,
          //         barPercentage: 0.10,
          //         barThickness: barThickness,
          //     },
          //     {
          //         label: "LOSE",
          //           backgroundColor: "#e5140d",
          //           borderColor: "#e5140d",
          //         data: LOSE,
          //         barPercentage: 0.10,
          //         barThickness: barThickness,
          //     },
          //     ]
          //   },
          //   options: {
          //       tooltips: {
          //         callbacks: {
          //           title: function(tooltipItem, data) {
          //             return ['Rp.' + data['labels2'][tooltipItem[0].datasetIndex][tooltipItem[0]['index']].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")]
          //           },
          //           label: function(tooltipItem, data) {
          //             return data.datasets[tooltipItem.datasetIndex].label
          //           },
          //           footer: function(tooltipItem, data) {
          //             return ['Total : ' + data['datasets'][tooltipItem[0].datasetIndex]['data'][tooltipItem[0]['index']]];
          //           },
          //           afterLabel: function(tooltipItem, data) {
          //           }
          //         }
          //       },
          //   }
          // });

          var TOTAL_AMOUNT = [amount_INITIAL, amount_OPEN, amount_SD, amount_TP, amount_WIN, amount_LOSE]; // Example totals for each month
          console.log(INITIAL)

          var options = {
            series: [
              {
                name: "INITIAL",
                data: INITIAL // Data for WIN
              },
              {
                name: "OPEN",
                data: OPEN // Data for LOSE
              },
              {
                name: "SD",
                data: SD // Data for WIN
              },
              {
                name: "TP",
                data: TP // Data for LOSE
              },
              {
                name: "WIN",
                data: WIN // Data for LOSE
              },
              {
                name: "LOSE",
                data: LOSE // Data for LOSE
              }
            ],
            chart: {
              type: 'bar',
              // width:'100%',
              height: 330,
              toolbar: {
                show: true // Enable toolbar for zooming/exporting
              }
            },
            plotOptions: {
              bar: {
                columnWidth: '70%',
                borderRadius: 5,
              }
            },
            colors: ['#7735a3', '#f2562b', '#04dda3','#f7e127','#246d18','#e5140d'], // WIN (green), LOSE (red), Additional colors if   needed
            dataLabels: {
              enabled: false // Disable value labels on bars
            },
            tooltip: {
              enabled: true,
              custom: function({ series, seriesIndex, dataPointIndex, w }) {
                const value = TOTAL_AMOUNT[seriesIndex][dataPointIndex];
                const total = series[seriesIndex][dataPointIndex];
                const label = w.config.series[seriesIndex].name
                return `
                  <div style="padding: 8px; background: #fff; border: 1px solid #ddd; border-radius: 5px;">
                    <b>${label}</b>: Rp.${value.toLocaleString('id-ID')}<br>
                    <b>Total</b>: ${total}
                  </div>
                `;
              }
            },
            xaxis: {
              categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul','Aug','Sep','Oct','Nov','Dec'], // Month labels
              labels: {
                rotate: -45 // Rotate labels for better readability
              }
            },
            yaxis: {
              // labels: {
              //   formatter: function (value) {
              //     return `Rp.${value.toLocaleString('id-ID')}`; // Format values with "Rp."
              //   }
              // }
              show:false
            },
            legend: {
              position: 'top',
              horizontalAlign: 'left'
            },
            stroke: {
              show: true,
              width: 5,
              colors: ['transparent']
            },
          };

          // var options = {
          // series: [
          //   {
          //     name: 'Net Profit',
          //     data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
          //   }, {
          //     name: 'Revenue',
          //     data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
          //   }, {
          //     name: 'Free Cash Flow',
          //     data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
          //   },
          //   {
          //     name: 'Revenue',
          //     data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
          //   }, {
          //     name: 'Free Cash Flow',
          //     data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
          //   }
          // ],
          //   chart: {
          //   type: 'bar',
          //   height: 350
          // },
          // plotOptions: {
          //   bar: {
          //     horizontal: false,
          //     columnWidth: '55%',
          //     borderRadius: 5,
          //     borderRadiusApplication: 'end'
          //   },
          // },
          // dataLabels: {
          //   enabled: false
          // },
          // stroke: {
          //   show: true,
          //   width: 2,
          //   colors: ['transparent']
          // },
          // xaxis: {
          //   categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
          // },
          // yaxis: {
          //   title: {
          //     text: '$ (thousands)'
          //   }
          // },
          // fill: {
          //   opacity: 1
          // },
          // tooltip: {
          //   y: {
          //     formatter: function (val) {
          //       return "$ " + val + " thousands"
          //     }
          //   }
          // }
          // };

          // Render Chart
          // if (!window.barChartByStatus) {
            const barChartByStatus = new ApexCharts(document.querySelector('#barChartByStatus'), options);
            barChartByStatus.render();
            // window.barChartByStatus = true;

            return initiateMybarChartByStatus = barChartByStatus
          // }
          
        }
      })   
    }

    initiateTotalLead(moment().year())

    var initiateMyBarChart = ''
    function initiateTotalLead(year){
      $.ajax({
        type:"GET",
        url:"{{url('/getChart')}}?year="+year,
        success:function(result){
          if (initiateMyBarChart) {
            initiateMyBarChart.destroy()
            console.log("destroy dulu")
          }
          //   var myBarChart = new Chart(ctx2, {
          //   type: 'bar',
          //   data: {
          //     labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "Oktober", "November", "Desember"],
          //     datasets: [{
          //       label: "Lead Register "+year,
          //       backgroundColor: "#00a65a",
          //       borderColor: "#00a65a",
          //       data: result,
          //     }],
          //   },
          //   options: {
          //     tooltips: {
          //     callbacks: {
          //       title: function(tooltipItem, data) {
          //         return [tooltipItem[0].label]
          //       },
          //       label: function(tooltipItem, data) {
          //        return ['Total : ' + tooltipItem.value]
          //       },
          //       footer: function(tooltipItem, data) {
                  
          //       },
          //       afterLabel: function(tooltipItem, data) {
          //       }
          //     }
          //   },
          //   }
          // });

          var options = {
            chart: {
                type: 'bar',
                height: 350,
            },
            series: [
                {
                    name: "Lead Register " + year,
                    data: result // Data from the AJAX response
                }
            ],
            xaxis: {
                categories: [
                    "Jan", "Feb", "Mar", "Apr", "May", 
                    "Jun", "Jul", "Aug", "Sep", "Oct", 
                    "Nov", "Dec"
                ]
            },
            colors: ['#00a65a'], // Bar color
            tooltip: {
                y: {
                    title: {
                        formatter: function() {
                            return ""; // Hide series name in tooltip
                        }
                    },
                    formatter: function(value) {
                        return "Total: " + value; // Tooltip format
                    }
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%', // Adjust bar width
                }
            },
            legend: {
                show: false
            },
          };

          // if (!window.myBarChart) {
            myBarChart = new ApexCharts(document.querySelector("#myBarChart"), options);
            myBarChart.render();
            // window.myBarChart = true;

            return initiateMyBarChart = myBarChart

          // }
        }
      })
    }

    initiateTotalAmountLead(moment().year())
    var initiateAreaChart = ''
    function initiateTotalAmountLead(year){
      $.ajax({
        type:"GET",
        url:"{{url('/getAreaChart2019')}}?year="+year,
        success:function(result){
          if (initiateAreaChart) {
            initiateAreaChart.destroy()
          }
          // var AreaChart = new Chart(ctx14, {
          // type: 'line',
          // data: {
          //   labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "Oktober", "November", "Desember"],
          //   datasets: [{
          //     label: "Amount "+year,
          //     lineTension: 0.3,
          //     backgroundColor: "rgba(2,117,216,0.2)",
          //     borderColor: "rgba(2,117,216,1)",
          //     pointRadius: 5,
          //     pointBackgroundColor: "rgba(2,117,216,1)",
          //     pointBorderColor: "rgba(255,255,255,0.8)",
          //     pointHoverRadius: 5,
          //     pointHoverBackgroundColor: "rgba(2,117,216,1)",
          //     pointHitRadius: 20,
          //     pointBorderWidth: 2,
          //     data: result,
          //   }],
          // },
          // options: {
          // legend: {
          //   display: true
          //   },
          // tooltips: {
          //  mode: 'label',
          //  label: 'Rp',
          //  callbacks: {
          //      label: function(tooltipItem, data) {
          //          return "Rp." + tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
          // },
          // scales: {
          //     yAxes: [{
          //       ticks: {
          //         beginAtZero:true,
          //         userCallback: function(value, index, values) {
          //           // Convert the number to a string and splite the string every 3 charaters from the end
          //           value = value.toString();
          //           value = value.split(/(?=(?:...)*$)/);
          //           value = value.join(',');
          //           return value;
          //         }
          //       }
          //     }],
          //     xAxes: [{
          //       ticks: {
          //       }
          //     }]
          //   },
          // },
          // });

          var options = {
            chart: {
                type: 'line',
                height: 350,
                parentHeightOffset: 0,
                parentWidthOffset: 0,
                dropShadow: {
                  enabled: true,
                  top: 10,
                  left: 5,
                  blur: 3,
                  color: config.colors.primary,
                  opacity: 0.15
                },
                toolbar: {
                  show: false
                }
            },
            series: [
                {
                    name: "Amount " + year, // Series label
                    data: result // Data from the AJAX response
                }
            ],
            xaxis: {
                categories: [
                    "Jan", "Feb", "Mar", "Apr", "May", 
                    "Jun", "Jul", "Aug", "Sep", "Oct", 
                    "Nov", "Dec"
                ]
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        // Format y-axis values with commas
                        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                },
                title: {
                    text: 'Amount'
                }
            },
            tooltip: {
                y: {
                    title: {
                        formatter: function() {
                            return ""; // Hide series name in tooltip
                        }
                    },
                    formatter: function(value) {
                        // Format tooltip values with currency format
                        return "Rp. " + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }
            },
            stroke: {
                curve: 'smooth', // Simulates lineTension
                width: 2,
                colors: ["rgba(2,117,216,1)"]
            },
            markers: {
              size: 5,
              // colors: ["rgba(2,117,216,1)"],
              // strokeColors: "#fff",
              colors: 'transparent',
              strokeColors: 'transparent',
              strokeWidth: 2,
              hover: {
                  size: 7
              },
              discrete: [
                {
                  fillColor: config.colors.white,
                  seriesIndex: 0,
                  dataPointIndex: 5,
                  strokeColor: config.colors.warning,
                  strokeWidth: 8,
                  size: 8,
                  radius: 8
                }
              ],
            },
            // fill: {
            //     type: 'gradient',
            //     gradient: {
            //         shadeIntensity: 1,
            //         opacityFrom: 0.2,
            //         opacityTo: 0.5,
            //     }
            // },
            legend: {
                show: true,
                position: 'top',
            },
            colors: [config.colors.warning],
            stroke: {
              width: 4,
              curve: 'smooth'
            },

          };

          // if (!window.areaChart) {
            let areaChart = new ApexCharts(document.querySelector("#AreaChart2019"), options);
            areaChart.render();
            // window.areaChart = true;

            return initiateAreaChart = areaChart
          // }
        }
      })
    }
    
    initiateStatusLead(moment().year())
    var initiateMyPieChart = ''
    function initiateStatusLead(year){
      $.ajax({
        type:"GET",
        url:"getPieChart?year="+year,
        success:function(result){
          if (initiateMyPieChart) {
            initiateMyPieChart.destroy()
          }
        // var myPieChart = new Chart(ctx5, {
        //   type: 'pie',
        //   data: {
        //     labels: ["INITIAL", "OPEN", "SD", "TP", "WIN", "LOSE"],
        //     indexLabel: "#percent%",
        //     percentFormatString: "#0.##",
        //     toolTipContent: "{y} (#percent%)",
        //     datasets: [{
        //       data: result,
        //       backgroundColor: ['#7735a3', '#f2562b', '#04dda3', '#f7e127', '#246d18', '#e5140d'],
        //     }],
        //   },
        //   options: {
        //     legend: {
        //       display: true
        //     },
        //     tooltips: {
        //       mode: 'label',
        //       label: 'mylabel',
        //       callbacks: {
        //       label: function(tooltipItem, data) {
        //         return data['datasets'][0]['data'][tooltipItem['index']].toFixed(2) + ' %';},},
        //       },
        //     },
        //   });

          var options = {
              chart: {
                  type: 'pie',
                  height: 350,
              },
              labels: ["INITIAL", "OPEN", "SD", "TP", "WIN", "LOSE"],
              series: result, // Data from the AJAX response
              colors: ['#7735a3', '#f2562b', '#04dda3', '#f7e127', '#246d18', '#e5140d'],
              tooltip: {
                  y: {
                      formatter: function(value) {
                          return value.toFixed(2) + " %"; // Format tooltip value
                      }
                  }
              },
              legend: {
                  show: true,
                  position: 'bottom'
              }
          };

          // if (!window.myPieChart) {
            var myPieChart = new ApexCharts(document.querySelector("#myPieChart"), options);
            myPieChart.render();
            // window.myPieChart = true;

            return initiateMyPieChart = myPieChart
          // }
        }
      })

      // $.ajax({
      //   type:"GET",
      //   url:"getPieChart?year="+year,
      //   success:function(result){
      //       var myPieChart = new Chart(ctx6, {
      //       type: 'pie',
      //       data: {
      //         labels: ["INITIAL", "OPEN", "SD", "TP", "WIN", "LOSE"],
      //         indexLabel: "#percent%",
      //         percentFormatString: "#0.##",
      //         toolTipContent: "{y} (#percent%)",
      //         datasets: [{
      //           data: result,
      //           backgroundColor: ['#7735a3', '#f2562b', '#04dda3', '#f7e127', '#246d18', '#e5140d'],
      //         }],
      //       },
      //       options: {
      //       legend: {
      //         display: true
      //         },
      //       tooltips: {
      //        mode: 'label',
      //        label: 'mylabel',
      //        callbacks: {
      //         label: function(tooltipItem, data) {
      //           return data['datasets'][0]['data'][tooltipItem['index']].toFixed(2) + ' %';},},
      //         },
      //       },
      //     });
      //   }
      // })
    }

    initiateChartWinLose(moment().year())
    var initiateMyDoughnutChart = ''
    function initiateChartWinLose(year){
      $.ajax({
        type:"GET",
        url:"getDoughnutChart?year="+year,
        beforeSend:function(argument) {
          $('.layout-container').block({
            message: '<div class="spinner-border text-white" role="status"></div>',
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
        success:function(result){
          if (initiateMyDoughnutChart) {
            console.log("destroy dulu")
            initiateMyDoughnutChart.destroy()
          }
          // var myDoughnutChart = new Chart(ctx7, {
          //     type: 'doughnut',
          //     data: {
          //       labels: ["WIN", "LOSE"],
          //       indexLabel: "#percent%",
          //       percentFormatString: "#0.##",
          //       datasets: [{
          //         data: result,
          //         backgroundColor: ['#246d18', '#e5140d'],
          //       }],
          //     },
          //     options: {
          //     showTooltips: true,
          //     legend: {
          //       display: true
          //       },
          //     tooltips: {
          //      mode: 'label',
          //      label: 'mylabel',
          //      callbacks: {
          //         label: function(tooltipItem, data) {
          //           return data['datasets'][0]['data'][tooltipItem['index']].toFixed(2) + '%';
          //         },
          //       },
          //     },
          //   },
          // });

        var options = {
          chart: {
            type: 'donut',
            height: 350,
            parentHeightOffset: 0,
          },
          series: result, // Data values
          labels: ['WIN', 'LOSE'], // Legends
          colors: [
            '#3A7D44', '#FF2929'
          ], // Custom colors
          stroke: {
            width: 0
          },
          legend: {
            position: 'bottom',
            markers: {
              width: 10,
              height: 10,
              radius: 12, // Rounded markers
            },
          },
          tooltip: {
            enabled: false, // Hide the default tooltip
            custom: function({ series, seriesIndex }) {
              // Center text (percentage and label)
              return `
                <div class="custom-tooltip">
                  <span>${series[seriesIndex]}%</span>
                  <span>${options.labels[seriesIndex].toFixed(2)}</span>
                </div>
              `;
            },
          },
          plotOptions: {
            pie: {
              donut: {
                size: '75%',
                labels: {
                  show: true,
                  value: {
                    fontSize: '1.5rem',
                    fontFamily: 'Public Sans',
                    color: headingColor,
                    fontWeight: 500,
                    offsetY: -15,
                    formatter: function (val) {
                      return parseInt(val) + '%';
                    }
                  },
                  name: {
                    offsetY: 20,
                    fontFamily: 'Public Sans'
                  },
                  // total: {
                  //   show: true,
                  //   fontSize: '15px',
                  //   fontFamily: 'Public Sans',
                  //   label: 'Average',
                  //   color: legendColor,
                  //   formatter: function (w) {
                  //     return '25%';
                  //   }
                  // }
                }
              }
            }
          }
          // plotOptions: {
          //   pie: {
          //     donut: {
          //       size: '65%', // Inner circle size
          //       labels: {
          //         show: true,
          //         total: {
          //           show: true, // Show total label
          //           label: 'Total', // Label for the center text
          //           fontSize: '16px', // Font size for center text
          //           color: '#555', // Color for center text
          //           formatter: function(w) {
          //             return w.globals.seriesTotals.reduce((a, b) => a + b, 0).toFixed(2); // Sum of all values
          //           },
          //         },
          //       },
          //     },
          //   },
          // },
        };

        // if (!window.myDoughnutChart) {
          var myDoughnutChart = new ApexCharts(document.querySelector("#myDoughnutChart"), options);
          myDoughnutChart.render();
          // window.myDoughnutChart = true;

          return initiateMyDoughnutChart = myDoughnutChart

        // }
        // var myDoughnutChart = new ApexCharts(document.querySelector("#myDoughnutChart"), options1);
        // myDoughnutChart.render();

          // Render the first chart in a container with ID #chart1
          // var myDoughnutChart = new ApexCharts(document.querySelector("#myDoughnutChart"), options1);
          // myDoughnutChart.render();

          // $.ajax({
          //   type:"GET",
          //   url:"getDoughnutChart?year="+year,
          //   success:function(result){
          //     var myDoughnutChart2 = new Chart(ctx18, {
          //       type: 'doughnut',
          //       data: {
          //         labels: ["WIN", "LOSE"],
          //         indexLabel: "#percent%",
          //         percentFormatString: "#0.##",
          //         datasets: [{
          //           data: result,
          //           backgroundColor: ['#246d18', '#e5140d'],
          //         }],
          //       },
          //       options: {
          //       showTooltips: true,
          //       legend: {
          //         display: true
          //         },
          //       tooltips: {
          //        mode: 'label',
          //        label: 'mylabel',
          //        callbacks: {
          //           label: function(tooltipItem, data) {
          //             return data['datasets'][0]['data'][tooltipItem['index']].toFixed(2) + '%';
          //           },
          //         },
          //       },
          //     },
          //     });
          //   }
          // });
        }
      });
    }

    if("{{Auth::User()->id_division}}" == 'SALES'){ 
      if (sessionStorage.getItem('dontLoad') == null){
          $("#popUp").modal("show");
      }
      sessionStorage.setItem('dontLoad', 'true');
    }

    $(document).keyup(function(e) {
      if (e.keyCode == 27) {
          $('#popUp').modal('hide');
          $("#ideaHub").modal("hide");
      }
    });

    const d = new Date();
    let year = d.getFullYear();
    initiateSelectYear(year)

    function initiateSelectYear(year){
      $("#btnThisYear").val(year)
      $("#btnLastYear").val(year-1)
      clickYear(year)
      $.ajax({
        url:"{{url('/loopYear')}}",
        success:function(result){
          var othYear = []

          result.forEach(function(item){
            if (item.id != year && item.id != year-1 && item.id != null) {
              othYear.push({id:item.id,text:item.text})
            }
          })

          $("#selectYear").select2({
            data:othYear,
            placeholder:"Other Year"
          })
        }
      })
    }

    function clickYear(year){
      if (year != "") {
        if ($("#btnThisYear").hasClass("isClicked")) {
            $("#btnThisYear").removeClass("isClicked")
        }else if ($("#btnLastYear").hasClass("isClicked")) {
            $("#btnLastYear").removeClass("isClicked")
        }

        if ($("#selectYear").val() != "") {
            if (year != $("#selectYear").val()) {
                $("#selectYear").val("").trigger("change")
            }

            if ($("#btnThisYear").val() == year) {
                $("#btnThisYear").addClass("isClicked")
            }else if ($("#btnLastYear").val() == year) {
                $("#btnLastYear").addClass("isClicked")
            }
        }else{
            if ($("#btnThisYear").val() == year) {
                $("#btnThisYear").addClass("isClicked")
            }else if ($("#btnLastYear").val() == year) {
                $("#btnLastYear").addClass("isClicked")
            }
        }

        initiateSmallBox(year,"filter")
        initiateTableSipWin(year)
        initiateTableMspWin(year)
        initiateChartWinLose(year)
        initiateStatusLead(year)
        initiateTotalAmountLead(year)
        initiateTotalLead(year)
        initiateAmountLead(year)

        if (accesable.includes('salesWinTerritory')) {
          initiateTopWinTer(year,"initiate")
          // initiateTopWinTer(moment().year(),"initiate")
        }

        if (accesable.includes('BoxTopWinTerritoryNonDetail')) {
          initiateTopWinEachTerNonDetail(year,"initiate")
          // initiateTopWinTer(moment().year(),"initiate")
        }

        if (accesable.includes('BoxTopWinTerritory')) {
          var top_win_sip_ter =  JSON.parse('@json($top_win_sip_ter)')
          initiateTopWinEachTer(year,"initiate")
          // initiateTopWinEachTer(moment().year(),"initiate")
        }

        if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','VP Solutions & Partnership Management')->exists()}}") {
          $("#BoxTopWin").find('.col-lg-6').removeClass('col-lg-6 col-xs-12').addClass('col-lg-12 col-xs-12')
        }
      }
    }
</script>
@endsection