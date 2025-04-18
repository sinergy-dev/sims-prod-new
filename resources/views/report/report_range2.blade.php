@extends('template.template_admin-lte')
@section('content')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{asset("template2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")}}">

  <style type="text/css">
    .btn-warning-export{
      background-color: #ffc107;
      border-color: #ffc107;
    }
    .dataTables_paging {
     display: none;
    }

    .dataTables_wrapper .dt-buttons {
      float:none;  
      text-align:center;
      margin-left: 5px;
      /*margin-bottom: 10px;*/
    }

    .margin-left{
      margin-left: 10px;
    }

  </style>

  <section class="content-header">
    <h1>
      Report Range by Deal Price
    </h1>
    <ol class="breadcrumb">
      <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Report Range by Deal Price</li>
    </ol>
  </section>

  <section class="content">

    @if(Auth::User()->id_division == "SALES" && Auth::User()->id_position != 'ADMIN' || Auth::User()->id_division == "TECHNICAL PRESALES" || Auth::User()->id_position == "DIRECTOR" || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER')
      <div class="row mb-3">
        <div class="col-lg-2 col-xs-6">
  
          <div class="small-box bg-purple">
              <div class="inner">
                <div id="lead_2019" class="txt_serif stats_item_number"><center><h6 class="counter">{{$total_lead}}</h6></center></div>
  
                <center><p>Lead Register</p></center>
  
              </div>
          </div>
  
        </div>
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
              <div class="inner">
                <div id="open_2019" class="txt_serif stats_item_number"><center><h6 class="counter">{{$total_open}}</h6></center></div>
  
                <center><p>Open</p></center>
  
              </div>
          </div>
        </div>
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
  
          <div class="small-box bg-aqua">
              <div class="inner">
                <div id="sd_2019" class="txt_serif stats_item_number"><center><h6 class="counter">{{$total_sd}}</h6></center></div>
  
                <center><p>Solution Design</p></center>
  
              </div>
          </div>
  
        </div>
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
  
          <div class="small-box bg-yellow">
              <div class="inner">
                <div id="tp_2019" class="txt_serif stats_item_number"><center><h6 class="counter">{{$total_tp}}</h6></center></div>
  
                <center><p>Tender Process</p></center>
  
              </div>
          </div>
  
        </div>
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
  
          <div class="small-box bg-green">
              <div class="inner">
                <div id="win_2019" class="txt_serif stats_item_number"><center><h6 class="counter">{{$total_win}}</h6></center></div>
  
                <center><p>Win</p></center>
  
              </div>
          </div>
  
        </div>
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
  
          <div class="small-box bg-red">
              <div class="inner">
                <div id="lose_2019" class="txt_serif stats_item_number"><center><h6 class="counter">{{$total_lose}}</h6></center></div>
  
                <center><p>Lose</p></center>
  
              </div>
          </div>
  
        </div>
      </div>
    @endif

    <div class="box">
      <div class="box-header with-border">

          @if(Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_division == 'SALES' || Auth::User()->id_division == 'TECHNICAL PRESALES')
          <div class="box-body">
            
            {{-- <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker">
            </div> --}}

            <div id="coba" class="row">
              <legend><b>Filter Data Between Range Date Below</b></legend>

              <!-- <label style="margin-top: 5px;margin-right: 5px">Filter Year</label>
              <select name="year_dif" id="year_dif" class="btn btn-md btn-default fa" style="font-size: 14px;border-style: none;height: 30px;width: 145px">
                @foreach($year as $years)
                  @if($years->year < $year_now)
                    <option value="{{$years->year}}"> &#xf073 &nbsp&nbsp{{$years->year}}</option>
                  @endif
                @endforeach
                <option selected value="{{$year_now}}"> &#xf073 &nbsp&nbsp{{$year_now}}</option>
              </select> -->

              <label style="margin-top: 5px;margin-right: 5px">&nbsp&nbspStart Date</label>
              <input type="text" id="startdate" class="form-control" style="width:200px" placeholder="DD/MM/YYYY">
              <p class="pull-right" style="margin-top: 5px">&nbsp&nbsp</p>
              <label style="margin-top: 5px;margin-right: 5px;margin-left: 5px">End Date</label>
              <input type="text" id="enddate" class="form-control pull-right" style="width:200px;margin-right: 10px" placeholder="DD/MM/YYYY">
              <span id="btn-pdf" style="margin-right: 10px"></span>
              <span id="btn-excel"></span>
            </div>
          </div>

          @endif

      </div>

      <div class="box-body">
        <!-- <div id="div_2018" style="display: none;">
          <div class="table-responsive">
            <h6>Total Deal Price: <b><i>Rp</i><i class="money">{{ $total_deal_price->deal_prices }}</i><i>.00</i></b></h6>
            <table class="table table-bordered table-striped dataTable" style="border-collapse: noseparate !important;" id="data_2018" width="100%" cellspacing="0">
                <thead>
                	<tr>
                	  <th hidden></th>
                    <th colspan="2">Filter by Territory</th>
                    <th>Filter by Sales</th>
                    <th colspan="2">Filter by Presales</th>
                    <th width="10%">Filter by Priority</th>
                    <th>Filter by Win Probability</th>
                    <th>Filter by Status</th>
                	</tr>
                	<tr id="status" style="border-bottom: solid;">
                    <td hidden></td>
                    <td colspan="2"></td>
                    <td></td>
                    <td colspan="2"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th>Lead ID</th>
                    <th hidden=""></th>
                    <th hidden=""></th>  
                    <th hidden=""></th>
                    <th hidden=""></th>
                    <th hidden></th>
                    <th hidden></th>
                    <th>Owner</th>  
                    <th width="20%">Opty Name</th>
                    <th>Customer</th>
                    <th>Create Date</th>
                    <th>Closing Date</th>
                    <th>Amount IDR</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="report" name="report">
                  @foreach($lead as $data)
                  <tr>
                    <td class="lead_id">{{ $data->lead_id }}</td>
                    <td hidden>{{ $data->name_territory }}</td>
                    <td hidden>{{ $data->name }}</td> 
                    <td hidden>
                      @if($data->nik_presales == $st->nik)
                        Satria Teguh Sentosa Mulyono
                      @elseif($data->nik_presales == $rk->nik)
                        Muhammad Rizki Kurniawan
                      @elseif($data->nik_presales == $gp->nik)
                        Ganjar Pramudya Wijaya
                      @elseif($data->nik_presales == $rz->nik)
                        Rizaldo Frendy Kurniawan
                      @endif
                    </td> 
                    <td hidden>{{ $data->priority}}</td>
                    <td hidden>{{ $data->win_prob}}</td>
                    <td hidden>
                      @if($data->result == 'OPEN')
                        <label class="status-initial">INITIAL</label>
                      @elseif($data->result == '')
                        <label class="status-open">OPEN</label>
                      @elseif($data->result == 'SD')
                        <label class="status-sd">SD</label>
                      @elseif($data->result == 'TP')
                        <label class="status-tp">TP</label>
                      @elseif($data->result == 'WIN')
                        <label class="status-win">WIN</label>
                      @elseif($data->result == 'LOSE')
                        <label class="status-lose">LOSE</label>
                      @elseif($data->result == 'CANCEL')
                       <label class="status-lose" style="background-color: #071108">CANCEL</label>
                      @elseif($data->result == 'HOLD')
                        <label class="status-initial" style="background-color: #919e92">HOLD</label>
                      @elseif($data->result == 'SPECIAL')
                        <label class="btn-xs status-initial" style="background-color: #ddc23b">SPECIAL</label>
                      @endif
                    </td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->opp_name }}</td>
                    <td >{{ $data->brand_name }}</td> 
                    <td>{!!substr($data->created_at,0,10)!!}</td>
                    <td>{{ $data->closing_date }}</td>
                    <td align="right">
                      <i class="money">{{ $data->deal_price }}</i>
                    </td>
                    <td>
                      @if($data->result == 'OPEN')
                        <label class="status-initial">INITIAL</label>
                      @elseif($data->result == '')
                        <label class="status-open">OPEN</label>
                      @elseif($data->result == 'SD')
                        <label class="status-sd">SD</label>
                      @elseif($data->result == 'TP')
                        <label class="status-tp">TP</label>
                      @elseif($data->result == 'WIN')
                        <label class="status-win">WIN</label>
                      @elseif($data->result == 'LOSE')
                        <label class="status-lose">LOSE</label>
                      @elseif($data->result == 'CANCEL')
                       <label class="status-lose" style="background-color: #071108">CANCEL</label>
                      @elseif($data->result == 'HOLD')
                        <label class="status-initial" style="background-color: #919e92">HOLD</label>
                      @elseif($data->result == 'SPECIAL')
                        <label class="btn-xs status-initial" style="background-color: #ddc23b">SPECIAL</label>
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="5"></td>
                    <td hidden=""></td>
                    <td hidden=""></td>
                    <td hidden=""></td>
                    <td hidden=""></td>
                    <td hidden=""></td>
                    <td hidden=""></td>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </tfoot>
            </table>
          </div>
        </div> -->
        <div id="div_now" >
          <div class="table-responsive">
            <h6>Total Deal Price: <b><i>Rp</i><i class="money">{{ $total_deal_price->deal_prices }}</i><i>.00</i></b></h6>
            <table class="table table-bordered table-striped dataTable" style="border-collapse: noseparate !important;" id="data_now" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th hidden></th>
                    <th colspan="2">Filter by Territory</th>
                    <th>Filter by Sales</th>
                    <th colspan="2">Filter by Presales</th>
                    <th width="10%">Filter by Priority</th>
                    <th>Filter by Win Probability</th>
                    <th>Filter by Status</th>
                  </tr>
                  <tr id="status" style="border-bottom: solid;">
                    <td hidden></td>
                    <td colspan="2"></td>
                    <td></td>
                    <td colspan="2"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th>Lead ID</th>
                    <th hidden=""></th>
                    <th hidden=""></th>  
                    <th hidden=""></th>
                    <th hidden=""></th>
                    <th hidden></th>
                    <th hidden></th>
                    <th>Owner</th>  
                    <th width="20%">Opty Name</th>
                    <th>Customer</th>
                    <th>Create Date</th>
                    <th>Closing Date</th>
                    <th>Amount IDR</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="report" name="report">
                  @foreach($leads_now as $data)
                  <tr>
                    <td class="lead_id">{{ $data->lead_id }}</td>
                    <td hidden>{{ $data->name_territory }}</td>
                    <td hidden>{{ $data->name }}</td> 
                    <td hidden>
                      @if($data->nik_presales == $st->nik)
                        Satria Teguh Sentosa Mulyono
                      @elseif($data->nik_presales == $rk->nik)
                        Muhammad Rizki Kurniawan
                      @elseif($data->nik_presales == $gp->nik)
                        Ganjar Pramudya Wijaya
                      @elseif($data->nik_presales == $rz->nik)
                        Rizaldo Frendy Kurniawan
                      @endif
                    </td> 
                    <td hidden>{{ $data->priority}}</td>
                    <td hidden>{{ $data->win_prob}}</td>
                    <td hidden>
                      @if($data->result == 'OPEN')
                        <label class="status-initial">INITIAL</label>
                      @elseif($data->result == '')
                        <label class="status-open">OPEN</label>
                      @elseif($data->result == 'SD')
                        <label class="status-sd">SD</label>
                      @elseif($data->result == 'TP')
                        <label class="status-tp">TP</label>
                      @elseif($data->result == 'WIN')
                        <label class="status-win">WIN</label>
                      @elseif($data->result == 'LOSE')
                        <label class="status-lose">LOSE</label>
                      @elseif($data->result == 'CANCEL')
                       <label class="status-lose" style="background-color: #071108">CANCEL</label>
                      @elseif($data->result == 'HOLD')
                        <label class="status-initial" style="background-color: #919e92">HOLD</label>
                      @elseif($data->result == 'SPECIAL')
                        <label class="btn-xs status-initial" style="background-color: #ddc23b">SPECIAL</label>
                      @endif
                    </td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->opp_name }}</td>
                    <td >{{ $data->brand_name }}</td> 
                    <td>{!!substr($data->created_at,0,10)!!}</td>
                    <td>{{ $data->closing_date }}</td>
                    <td align="right">
                      <i class="money">{{ $data->deal_price }}</i>
                    </td>
                    <td>
                      @if($data->result == 'OPEN')
                        <label class="status-initial">INITIAL</label>
                      @elseif($data->result == '')
                        <label class="status-open">OPEN</label>
                      @elseif($data->result == 'SD')
                        <label class="status-sd">SD</label>
                      @elseif($data->result == 'TP')
                        <label class="status-tp">TP</label>
                      @elseif($data->result == 'WIN')
                        <label class="status-win">WIN</label>
                      @elseif($data->result == 'LOSE')
                        <label class="status-lose">LOSE</label>
                      @elseif($data->result == 'CANCEL')
                       <label class="status-lose" style="background-color: #071108">CANCEL</label>
                      @elseif($data->result == 'HOLD')
                        <label class="status-initial" style="background-color: #919e92">HOLD</label>
                      @elseif($data->result == 'SPECIAL')
                        <label class="btn-xs status-initial" style="background-color: #ddc23b">SPECIAL</label>
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="5"></td>
                    <td hidden=""></td>
                    <td hidden=""></td>
                    <td hidden=""></td>
                    <td hidden=""></td>
                    <td hidden=""></td>
                    <td hidden=""></td>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection

@section('script')
<script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.fixedColumns.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/button.download.js')}}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="{{asset('template2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="{{asset('js/sum().js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script> -->

<script type = "text/javascript" >

  $('.select2').select2();

  $('#enddate').datepicker({
      autoclose: true
  })

  $('#startdate').datepicker({
      autoclose: true
  })

  $('.money').mask('000,000,000,000,000', {reverse: true});

  $("#dropdown2").on('change', function() {
    if ($(this).find('option:selected').text() == "Select Option")
        $("#btnSubmit").attr('disabled', true)
    else
        $("#btnSubmit").attr('disabled', false)
  });

  var enableDisableSubmitBtn = function() {
        var startVal = $('#startdate').val().trim();
        var endVal = $('#enddate').val().trim();
        var disableBtn = startVal.length == 0 || endVal.length == 0;
        $('#dropdown').attr('disabled', disableBtn);
  }

  function exportPdf() {
    type = encodeURI($("#dropdown").val())
    date_start = encodeURI(moment($("#startdate").datepicker("getDate")).format("YYYY-MM-DD HH:mm:ss"))
    date_end = encodeURI(moment($("#enddate").datepicker("getDate")).format("YYYY-MM-DD HH:mm:ss"))
    dropdown2 = encodeURI($("#dropdown2").val())
    myUrl = url + "/getCustomerbyDate2?type=" + type + "&customer=" + dropdown2 + "&start=" + date_start + "&end=" + date_end
    location.assign(myUrl)
  }

</script>

<script type = "text/javascript" >
  $.fn.dataTable.ext.search.push(
      function(settings, data, dataIndex) {
          var min = $('#startdate').datepicker("getDate");
          var max = $('#enddate').datepicker("getDate");
          var startDate = new Date(data[10]);
          if (min == null && max == null) {
              return true;
          }
          if (min == null && startDate <= max) {
              return true;
          }
          if (max == null && startDate >= min) {
              return true;
          }
          if (startDate <= max && startDate >= min) {
              return true;
          }
          return false;
      }
  );

  $("#startdate").datepicker({
      onSelect: function() {
          table.draw();
      },
      changeMonth: true,
      changeYear: true,
      autoclose: true
  });
  $("#enddate").datepicker({
      onSelect: function() {
          table.draw();
      },
      changeMonth: true,
      changeYear: true,
      autoclose: true
  });

  $('#startdate, #enddate').change(function() {
      table.draw();
  });

  /*$('#year_dif').on('change', function() {

    if ($('#year_dif').val() == new Date().getFullYear()) {
      $('#div_now').css("display", "block");
      $('#div_2018').css("display", "none");
    }else{
      $('#div_now').css("display", "none");
      $('#div_2018').css("display", "block");
    }

    table.draw();

    var product = $('#year_dif').val();

    $.ajax({
      type:"GET",
      url:'/year_initial',
      data:{
        product:this.value,
      },
      success: function(result){
        $.each(result[0], function(key, value){
        if (result[0] == "null") {
          $('#lead_all').text('0');    
        }else{
          $('#lead_all').text(result[0].length);
        }
        });
         
      }
    });

    $.ajax({
      type:"GET",
      url:'/year_open',
      data:{
        product:this.value,
      },
      success: function(result){
        $.each(result[0], function(key, value){
          if (result[0] == "null") {
            $('#lead_open').text('0');    
          }else{
            $('#lead_open').text(result[0].length);    
          }
        });
         
      }
    });

    $.ajax({
      type:"GET",
      url:'/year_sd',
      data:{
        product:this.value,
      },
      success: function(result){
        $.each(result[0], function(key, value){
          if (result[0] == "null") {
            $('#lead_sd').text('0');    
          }else{
            $('#lead_sd').text(result[0].length);
          }
        });
         
      }
    });

    $.ajax({
      type:"GET",
      url:'/year_tp',
      data:{
        product:this.value,
      },
      success: function(result){
        $.each(result[0], function(key, value){
          if (result[0] == "null") {
            $('#lead_tp').text('0');    
          }else{
             $('#lead_tp').text(result[0].length);
          }
        });
         
      }
    });

    $.ajax({
      type:"GET",
      url:'/year_win',
      data:{
        product:this.value,
      },
      success: function(result){
        $.each(result[0], function(key, value){
         if (result[0] == "null") {
            $('#lead_win').text('0');    
          }else{
            $('#lead_win').text(result[0].length);
          }
        });
         
      }
    });


    $.ajax({
      type:"GET",
      url:'/year_lose',
      data:{
        product:this.value,
      },
      success: function(result){
        $.each(result[0], function(key, value){
         if (result[0] == "null") {
            $('#lead_lose').text('0');    
          }else{
            $('#lead_lose').text(result[0].length);
          }
        });
         
      }
    });
  });*/


  var table = $('#data_2018').DataTable({
    "retrive": true,
    "order": [
        [10, "desc"]
    ],
    // "orderCellsTop": true,
    fixedHeader: true,
    pageLength: 50,
    "bLengthChange": false,
    initComplete: function() {
        this.api().columns([
            [1],
            [2],
            [3],
            [4],
            [5],
            [6],
            [7]
        ]).every(function() {
            var column = this;
            var title = $(this).text();
            var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Filter</option></select>')
                .appendTo($("#status").find("td").eq(column.index()))
                .on('change', function() {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val());

                    column.search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });

            console.log(select);

            column.data().unique().sort().each(function(d, j) {
                select.append('<option>' + d + '</option>')
            });

            initkat();

        });
    },
    "footerCallback": function( row, data, start, end, display ) {
        
          var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp' ).display;

          var api = this.api(),data;
            // Remove the formatting to get integer data for summation
          var intVal = function ( i ) {
          return typeof i === 'string' ?
            i.replace(/[\$,]/g, '')*1 :
          typeof i === 'number' ?
            i : 0;
          };

          var filtered = api.column( 12, {"filter": "applied"} ).data().sum();

          $( api.column( 11 ).footer() ).html("Total Amount");
         
          $( api.column( 12 ).footer() ).html(numFormat(filtered));

    },
  });

  var table = $('#data_now').DataTable({
    "retrive": true,
    "order": [
        [10, "desc"]
    ],
    // "orderCellsTop": true,
    fixedHeader: true,
    pageLength: 50,
    "bLengthChange": false,
    initComplete: function() {
        this.api().columns([
            [1],
            [2],
            [3],
            [4],
            [5],
            [6],
            [7]
        ]).every(function() {
            var column = this;
            var title = $(this).text();
            var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop" ><option value="" selected>Filter</option></select>')
                .appendTo($("#status").find("td").eq(column.index()))
                .on('change', function() {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val());

                    column.search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });

            console.log(select);

            column.data().unique().sort().each(function(d, j) {
                select.append('<option>' + d + '</option>')
            });

            initkat();

        });
    },
    "footerCallback": function( row, data, start, end, display ) {
        
          var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp' ).display;

          var api = this.api(),data;
            // Remove the formatting to get integer data for summation
          var intVal = function ( i ) {
          return typeof i === 'string' ?
            i.replace(/[\$,]/g, '')*1 :
          typeof i === 'number' ?
            i : 0;
          };

          var filtered = api.column( 12, {"filter": "applied"} ).data().sum();

          $( api.column( 11 ).footer() ).html("Total Amount");
         
          $( api.column( 12 ).footer() ).html(numFormat(filtered));

    },
  });

  var buttons = new $.fn.dataTable.Buttons(table, {
    buttons: [{
        text: '<i class="fa fa-cloud-download"></i> <b>PDF</b>',
        filename: function(){
          var today = new Date();
          // var n = d.getTime();
          var dd = today.getDate();
          var mm = today.getMonth() + 1; //January is 0!

          var yyyy = today.getFullYear();
          if (dd < 10) {
            dd = '0' + dd;
          } 
          if (mm < 10) {
            mm = '0' + mm;
          } 
          var today = dd + '-' + mm + '-' + yyyy;
          return 'Report PDF' + ' ' + '(' + today + ')';
        },
        extend: 'pdfHtml5',
        footer:true,
        className: 'btn btn-warning',
        title: 'Report PDF',
        customize: function(doc) {
          //pageMargins [left, top, right, bottom] 
          doc.pageMargins = [ 30, 20, 30, 20 ];
          doc.styles['td:nth-child(5)'] = { 
             width: '100px',
             'max-width': '100px'
           }
        },
        pageSize: 'A4',
        pageMargins: [0, 0, 0, 0], // try #1 setting margins
        margin: [0, 0, 0, 0],
        content: [{
            style: 'fullWidth'
        }],
        styles: { // style for printing PDF body
            fullWidth: {
                fontSize: 14,
                bold: true,
                alignment: 'right',
                margin: [0, 0, 0, 0]
            }
        },

        exportOptions: {
            order: 'applied',
            stripHtml: true,
            modifier: {
                pageMargins: [0, 0, 0, 0], // try #3 setting margins
                margin: [0, 0, 0, 0], // try #4 setting margins
                alignment: 'center'
            },
            body: {
                margin: [0, 0, 0, 0],
                pageMargins: [0, 0, 0, 0]
            } // try #5 setting margins         
            ,
            columns: [0, 8, 9, 10, 11, 12, 13] //column id visible in PDF    
            ,
            format: {
                body: function ( data, row, column, node ) {
                    data = data.replace(/<.*?>/g, "");
                    return $.trim(data);

                    column
                }
            },
            columnGap: 1,
        },
      
    }],
  }).container().appendTo($('#btn-pdf'));

  var buttonsexcel = new $.fn.dataTable.Buttons(table, {
    buttons: [{
      text: '<i class="fa fa-cloud-download"></i> <b>Excel</b>',
        filename: function(){
          var today = new Date();
          var dd = today.getDate();
          var mm = today.getMonth() + 1; //January is 0!

          var yyyy = today.getFullYear();
          if (dd < 10) {
            dd = '0' + dd;
          } 
          if (mm < 10) {
            mm = '0' + mm;
          } 
          var today = dd + '-' + mm + '-' + yyyy;
          return 'Report Excel' + ' ' + '(' + today + ')';
        },
        extend: 'excelHtml5',
        footer:true,
        className: 'btn btn-success',
        title: 'Report Excel',
        exportOptions: {
          columns: [0, 8, 9, 10, 11, 12, 13], 
        },
    }],
  }).container().appendTo($('#btn-excel'));

  $('.buttons.pdfHtml5').each(function() {
      $(this).removeClass('btn-default').addClass('btn btn-md btn-warning')
  })

  $('.buttonsexcel.excelHtml5').each(function() {
    $(this).removeClass('btn-default').addClass('btn btn-excel btn-md btn-success')
  })

  function initkat() {
      $('.kat_drop').select2();
  }

</script>

@endsection