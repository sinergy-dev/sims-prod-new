@extends('template.main_sneat')
@section('tittle')
Report Presales
@endsection
@section('pageName')
Report Presales
@endsection
@section('head_css')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
  <style type="text/css">
    .btn-warning-export{
      background-color: #ffc107;
      border-color: #ffc107;
    }

    .dataTables_paging {
     display: none;
    }

    /* Hide buttons initially */
    .scroll-btn.hidden {
        display: none;
    }

    .nav-tabs-wrapper {
        overflow-x: auto;
        white-space: nowrap;
        display: flex;
        scroll-behavior: smooth;
        scrollbar-width: none; /* Hide scrollbar for Firefox */
    }

    .nav-tabs-wrapper::-webkit-scrollbar {
        display: none; /* Hide scrollbar for Chrome, Safari */
    }

    /* Shadowed Buttons */
    .scroll-btn btn-sm {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.8);
        border: none;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
    }

    .scroll-btn:hover {
        background: white;
    }
  </style>
@endsection
@section('content') 
  <div class="container-xxl flex-grow-1 container-p-y">
    <section class="content">
      <div class="row mb-4">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header with-border">
              <h6 class="card-title"><i class="bx bx-table"></i> Report Presales</h6>
            </div>
            <div class="card-body">
              <div class="row mb-4">
                <div class="col-md-2">
                  <div class="form-group">
                    <select style="width: 70%!important" class="form-control select2" id="year_filter" placeholder="Select Filter Year">
                      @foreach($years as $data)
                        <option value="{{$data->year}}">{{$data->year}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <button class="btn btn-sm btn-success" onclick="exportExcel()"><i class="bx bx-download"></i> Excel</button>
                  </div>
                </div>
              </div>            
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-lg-12">
          <div class="card card-primary">
            <div class="card-header with-border">
              <h6 class="card-title"><i>Total Lead</i></h6>
            </div>
            <div class="card-body">
              <!-- <div class="table-responsive"> -->
                <?php $no_sip = 1; ?>
                <table class="table table-bordered table-striped" width="100%" cellspacing="0" id="table_lead_presales">
                  <thead>
                    <tr>
                      <!-- <th width="5%"><center>No.</center></th> -->
                      <th><center>Presales Name</center></th>
                      <th ><center>Total INITIAL</center></th>
                      <th ><center>Total OPEN</center></th>
                      <th ><center>Total SD</center></th>
                      <th ><center>Total TP</center></th>
                      <th ><center>Total WIN</center></th>
                      <th ><center>Total LOSE</center></th>
                      <th ><center>Total HOLD</center></th>
                      <th ><center>Total CANCEL</center></th>
                      <th ><center>Total SPESIAL</center></th>
                      <th ><center>Total LEAD</center></th>
                    </tr>
                  </thead>
                  <tbody id="body_sip" name="body_sip">
                  </tbody>
                </table>
              <!-- </div> -->
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-lg-6">
          <div class="card card-primary">
            <div class="card-header with-border">
            <h6 class="card-title">Solution Design</h6>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="data_sd" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="5%"><center>No.</center></th>
                      <th><center>Presales Name</center></th>
                      <th width="20%"><center>Total Amount</center></th>
                      <th width="10%"><center>Total</center></th>
                    </tr>
                  </thead>
                  <tbody id="report_sd" name="report_sd">
                    <?php $no = 1; ?>
                    @foreach($lead_sd as $sds)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $sds->name }}</td>
                        <td align="right">
                          @if($sds->amounts != NULL)
                            <i class="money">{{ $sds->amounts }}</i>
                          @endif
                        </td>
                        <td><center>{{ $sds->leads }}</center></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card card-warning">
            <div class="card-header with-border">
            <h6 class="card-title">Tender Process</h6>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="data_tp" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="5%"><center>No.</center></th>
                      <th><center>Presales Name</center></th>
                      <th width="20%"><center>Total Amount</center></th>
                      <th width="10%"><center>Total</center></th>
                    </tr>
                  </thead>
                  <tbody id="report_tp" name="report_tp">
                    <?php $no = 1; ?>
                    @foreach($lead_tp as $tps)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $tps->name }}</td>
                        <td align="right">
                          @if($tps->amounts != NULL)
                            <i class="money">{{ $tps->amounts }}</i>
                          @endif
                        </td>
                        <td><center>{{ $tps->leads }}</center></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-lg-6">
          <div class="card card-success">
            <div class="card-header with-border">
            <h6 class="card-title">Win</h6>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="data_win" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="5%"><center>No.</center></th>
                      <th><center>Presales Name</center></th>
                      <th width="20%"><center>Total Amount</center></th>
                      <th width="10%"><center>Total</center></th>
                    </tr>
                  </thead>
                  <tbody id="report_win" name="report_win">
                    <?php $no = 1; ?>
                    @foreach($lead_win as $wins)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $wins->name }}</td>
                        <td align="right">
                          @if($wins->amounts != NULL)
                            <i class="money">{{ $wins->deal_prices }}</i>
                          @endif
                        </td>
                        <td><center>{{ $wins->leads }}</center></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card card-danger">
            <div class="card-header with-border">
            <h6 class="card-title">Lose</h6>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="data_lose" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="5%"><center>No.</center></th>
                      <th><center>Presales Name</center></th>
                      <th width="20%"><center>Total Amount</center></th>
                      <th width="10%"><center>Total</center></th>
                    </tr>
                  </thead>
                  <tbody id="report_lose" name="report_lose">
                    <?php $no = 1; ?>
                    @foreach($lead_lose as $loses)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $loses->name }}</td>
                        <td align="right">
                          @if($loses->amounts != NULL)
                            <i class="money">{{ $loses->amounts }}</i>
                          @endif
                        </td>
                        <td><center>{{ $loses->leads }}</center></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-lg-12">
          <div class="card card-danger">
            <div class="card-header with-border">
              <h6 class="card-title">Lead Register</h6>
            </div>

            <div class="card-body">
              <div class="nav-tabs-custom">
                <button class="scroll-btn btn-sm left-btn btn-sm hidden" onclick="scrollTabs(-100)">&#9664;</button>
                <div class="nav-tabs-wrapper" id="scrollableTabs">
                  <ul class="nav nav-tabs" id="myTab">
                    @foreach($users as $key => $user)
                        @if($key == 0)
                          @if($user->name == 'Ganjar Pramudya Wijaya')
                            <li class="nav-item">
                              <a class="nav-link active" id="{{ $user }}-tab" data-bs-toggle="tab" href="#{{ $user->nik }}" role="tab" aria-controls="{{ $user }}" aria-selected="true" onclick="changeLeadPresales('{{$user->nik}}')">
                          @else
                            <li class="nav-item">
                              <a class="nav-link active" id="{{ $user }}-tab" data-bs-toggle="tab" href="#{{ $user->nik }}" role="tab" aria-controls="{{ $user }}" aria-selected="true" onclick="changeLeadPresales('{{$user->nik}}')">
                          @endif
                              {{ $user->name }}
                             </a>
                            </li>
                        @else
                          @if($user->name == 'Ganjar Pramudya Wijaya')
                            <li class="nav-item">
                              <a class="nav-link active" id="{{ $user }}-tab" data-bs-toggle="tab" href="#{{ $user->nik }}" role="tab" aria-controls="{{ $user }}" aria-selected="true" onclick="changeLeadPresales('{{$user->nik}}')">
                          @else
                            <li class="nav-item">
                              <a class="nav-link" id="{{ $user }}-tab" data-bs-toggle="tab" href="#{{ $user->nik }}" role="tab" aria-controls="{{ $user }}" aria-selected="true" onclick="changeLeadPresales('{{$user->nik}}')">
                          @endif
                              {{ $user->name }}
                             </a>
                            </li>
                        @endif
                    @endforeach
                  </ul>
                </div>
                <button class="scroll-btn btn-sm right-btn btn-sm hidden" onclick="scrollTabs(100)">&#9654;</button>

                <div class="tab-content">
                  <div class="tab-pane show active"  role="tabpanel">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped" id="data_lead" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th><center>Lead Id</center></th>
                            <th><center>Customer</center></th>
                            <th><center>Opty Name</center></th>
                            <th><center>Owner</center></th>
                            <th><center>Amount</center></th>
                            <th><center>Amount</center></th>
                            <th><center>Status</center></th>
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
@endsection
@section('scriptImport')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/jquery.mask.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script></script>
<script type="text/javascript" src="{{asset('assets/js/sum().js')}}"></script>
<!-- bootstrap datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
@endsection
@section('script')
<script>
    $('.money').mask('000,000,000,000,000,000', {reverse: true});
    $('.total').mask('000,000,000,000,000,000.00', {reverse: true});

    numeral.register('locale', 'id', {
        delimiters: {
            thousands: '.',
            decimal: ','
        },
        abbreviations: {
            thousand: 'k',
            million: 'm',
            billion: 'b',
            trillion: 't'
        },
        currency: {
            symbol: 'Rp '
        }
    });

    $("#startdate").on('change',function(){
	    $("#enddate").attr('disabled',false)
	    
	    $("#enddate").on('change',function(){
	        $("#filter_submit").attr('disabled',false)
	    });
    });

    $("#data_sd").DataTable({
    })

    $("#data_tp").DataTable({
    })

    $("#data_win").DataTable({
    })

    $("#data_lose").DataTable({
    })

    initLeadTable();

    initPresalesTable();

    function initPresalesTable() {
      $("#data_lead").DataTable({
        "ajax":{
          "type":"GET",
          "url":"{{url('get_lead_init_presales')}}",
          "dataSrc": function (json){

            // switch between locales
            numeral.locale('id');

            json.data.forEach(function(data,index){
              data.amount_formated = numeral(data.amount).format('$0,0.00');
            });
            return json.data;
          }
        },
        "columns": [
          // { "data": "name" },
          { "data": "lead_id" },
          { "data": "brand_name" },
          { "data": "opp_name" },
          { "data": "name" },
          { 
            "data": "amount_formated",
            "className": "text-right",
            "orderData" : [ 5 ],
          },
          { 
            "data": "amount",
            "targets":[4],
            "visible": false,
          },
          /*{ 
            "data": "amount",
            "targets": [ 5 ] ,
            "visible": false ,
            "searchable": true
          },*/
          // { "data": "amount" },
          { "data": "results" },
        ],
        "searching": true,
        "lengthChange": false,
        // "paging": false,
        "info":false,
        "scrollX": false,
        "order": [[ 5, "asc" ]]
      })
    }

  	function initLeadTable(){

  		$("#table_lead_presales").DataTable({
  			"ajax":{
  				"type":"GET",
  				"url":"{{url('getdatalead')}}",
  			},
  			"columns": [
  				// { "data": "name" },
  				{ "data": "name" },
  				{ "data": "INITIAL" },
  				{ "data": "OPEN" },
  				{ "data": "SD" },
  				{ "data": "TP" },
  				{ "data": "WIN" },
  				{ "data": "LOSE" },
  				{ "data": "HOLD" },
  				{ "data": "CANCEL" },
  				{ "data": "SPESIAL" },
  				{ "data": "All" },
  			],
  			"searching": true,
  			"lengthChange": false,
  			// "paging": false,
  			"info":false,
  			"scrollX": true,
  			"order": [[ 1, "desc" ]]
  		})

	  }

    function changeLeadPresales(nik) {
      $('#data_lead').DataTable().ajax.url("{{url('filter_presales_each_year')}}?nik=" + nik + "&" + "year=" + $('#year_filter').val()).load();
    }

    // $('#enddate').datepicker({
    //     autoclose: true
    // })

    // $('#startdate').datepicker({
    //     autoclose: true
    // })

    var url = {!! json_encode(url('/')) !!}

    function exportExcel() {
      type = encodeURI($("#year_filter").val())
      myUrl = url+"/report_excel_presales?year=" + type
      location.assign(myUrl)
    }

    $('#filter_submit').click(function() {
	    var type = this.value;
	    console.log(this.value);
	      $.ajax({
	        type:"GET",
	        url:"/getfiltersdpresales",
	        data:{
	          data:this.value,
	          type:type,
	          // start:moment($( "#startdate" ).datepicker("getDate")).format("YYYY-MM-DD 00:00:00"),
	          // end:moment($( "#enddate" ).datepicker("getDate")).format("YYYY-MM-DD 23:59:59")
	        },
	        success: function(result){
	          $('#report_sd').empty();

	          var table = "";
	          var no = 1;

	          $.each(result, function(key, value){
	            table = table + '<tr>';
	            table = table + '<td>'+ no++ +'</td>';
	            table = table + '<td>' +value.name+ '</td>';
	            table = table + '<td align="right"><i>' +value.amounts.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")+ '.00</i></td>';
	            table = table + '<td><center>(' +value.leads+ ')</center></td>';
	            table = table + '</tr>';

	          });
	          $('#report_sd').append(table);
	          
	        },
	      });

      $.ajax({
        type:"GET",
        url:"/getfiltertppresales",
        data:{
          data:this.value,
          type:type,
          // start:moment($( "#startdate" ).datepicker("getDate")).format("YYYY-MM-DD 00:00:00"),
          // end:moment($( "#enddate" ).datepicker("getDate")).format("YYYY-MM-DD 23:59:59")
        },
        success: function(result){
          $('#report_tp').empty();

          var table = "";
          var no = 1;

          $.each(result, function(key, value){
            table = table + '<tr>';
            table = table + '<td>'+ no++ +'</td>';
            table = table + '<td>' +value.name+ '</td>';
            if(value.amounts == null) {
              table = table + '<td><center> - </center></td>';
            } else {
              table = table + '<td align="right"><i>' +value.amounts.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")+ '.00</i></td>';
            }
            table = table + '<td><center>(' +value.leads+ ')</center></td>';
            table = table + '</tr>';

          });
          $('#report_tp').append(table);
          
        },
      });

      $.ajax({
        type:"GET",
        url:"/getfilterwinpresales",
        data:{
          data:this.value,
          type:type,
          // start:moment($( "#startdate" ).datepicker("getDate")).format("YYYY-MM-DD 00:00:00"),
          // end:moment($( "#enddate" ).datepicker("getDate")).format("YYYY-MM-DD 23:59:59")
        },
        success: function(result){
          $('#report_win').empty();

          var table = "";
          var no = 1;

          $.each(result, function(key, value){
            table = table + '<tr>';
            table = table + '<td>'+ no++ +'</td>';
            table = table + '<td>' +value.name+ '</td>';
            table = table + '<td align="right"><i>' +value.amounts.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")+ '.00</i></td>';
            table = table + '<td><center>(' +value.leads+ ')</center></td>';
            table = table + '</tr>';

          });
          $('#report_win').append(table);
          
        },
      });

      $.ajax({
        type:"GET",
        url:"/getfilterlosepresales",
        data:{
          data:this.value,
          type:type,
          // start:moment($( "#startdate" ).datepicker("getDate")).format("YYYY-MM-DD 00:00:00"),
          // end:moment($( "#enddate" ).datepicker("getDate")).format("YYYY-MM-DD 23:59:59")
        },
        success: function(result){
          $('#report_lose').empty();

          var table = "";
          var no = 1;

          $.each(result, function(key, value){
            table = table + '<tr>';
            table = table + '<td>'+ no++ +'</td>';
            table = table + '<td>' +value.name+ '</td>';
            table = table + '<td align="right"><i>' +value.amounts.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")+ '.00</i></td>';
            table = table + '<td><center>(' +value.leads+ ')</center></td>';
            table = table + '</tr>';

          });
          $('#report_lose').append(table);
          
        },
      });

    });

    $('#year_filter2').change(function(){
	    var type = this.value;
	    $.ajax({
	      type:"GET",
	      url:"/getfiltersdyearpresales",
	      data:{
	        data:this.value,
	        type:type,
	      },
	      success: function(result){
	        $('#report_sd').empty();

	        var table = "";
	        var no = 1;

	        $.each(result, function(key, value){
	          table = table + '<tr>';
	          table = table + '<td>'+ no++ +'</td>';
	          table = table + '<td>' +value.name+ '</td>';
	          table = table + '<td align="right"><i>' +value.amounts.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")+ '.00</i></td>';
	          table = table + '<td><center>(' +value.leads+ ')</center></td>';
	          table = table + '</tr>';

	        });
	        $('#report_sd').append(table);
	        
	      },
	    });

	    $.ajax({
	      type:"GET",
	      url:"/getfiltertpyearpresales",
	      data:{
	        data:this.value,
	        type:type,
	      },
	      success: function(result){
	        $('#report_tp').empty();

	        var table = "";
	        var no = 1;

	        $.each(result, function(key, value){
	          table = table + '<tr>';
	          table = table + '<td>'+ no++ +'</td>';
	          table = table + '<td>' +value.name+ '</td>';
	          if(value.amounts == null) {
	            table = table + '<td><center> - </center></td>';
	          } else {
	            table = table + '<td align="right"><i>' +value.amounts.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")+ '.00</i></td>';
	          }
	          table = table + '<td><center>(' +value.leads+ ')</center></td>';
	          table = table + '</tr>';

	        });
	        $('#report_tp').append(table);
	        
	      },
	    });

	    $.ajax({
	      type:"GET",
	      url:"/getfilterwinyearpresales",
	      data:{
	        data:this.value,
	        type:type,
	      },
	      success: function(result){
	        $('#report_win').empty();

	        var table = "";
	        var no = 1;

	        $.each(result, function(key, value){
	          table = table + '<tr>';
	          table = table + '<td>'+ no++ +'</td>';
	          table = table + '<td>' +value.name+ '</td>';
	          table = table + '<td align="right"><i>' +value.amounts.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")+ '.00</i></td>';
	          table = table + '<td><center>(' +value.leads+ ')</center></td>';
	          table = table + '</tr>';

	        });
	        $('#report_win').append(table);
	        
	      },
	    });

	    $.ajax({
	      type:"GET",
	      url:"/getfilterloseyearpresales",
	      data:{
	        data:this.value,
	        type:type,
	      },
	      success: function(result){
	        $('#report_lose').empty();

	        var table = "";
	        var no = 1;

	        $.each(result, function(key, value){
	          table = table + '<tr>';
	          table = table + '<td>'+ no++ +'</td>';
	          table = table + '<td>' +value.name+ '</td>';
	          table = table + '<td align="right"><i>' +value.amounts.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")+ '.00</i></td>';
	          table = table + '<td><center>(' +value.leads+ ')</center></td>';
	          table = table + '</tr>';

	        });
	        $('#report_lose').append(table);
	        
	      },
	    });

    });

    $('#data_summary').DataTable();
    $('#data_all_sales').DataTable();

    $('#data_all').DataTable({
	    "retrive" : true,
	    "order": [[ 2, "desc" ]],
	    "orderCellsTop": true,

	    "footerCallback": function( row, data, start, end, display ) {

	      var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp ' ).display;

	      var api = this.api(),data;

	      var total = api.column(5, {page:'current'}).data().sum();

	      var filtered = api.column( 5, {"filter": "applied"} ).data().sum();

	      var totalpage = api.column(6).data().sum();

	          $( api.column( 4 ).footer() ).html("<p align='right'>Total Amount: </p>");

	          $( api.column( 5 ).footer() ).html("<p align='right'>"+ numFormat(totalpage) + "</p>");

	          $( api.column( 5 ).footer() ).html("<p align='right'>"+ numFormat(filtered) + "</p>" +'');
	    },

	    initComplete: function () {
	      this.api().columns([[4],[6]]).every( function () {
	          var column = this;
	          var select = $('<select class="form-control kat_drop" id="kat_drop" style="width:100%" name="kat_drop"><option value="">Filter</option></select>')
	              .appendTo($("#status").find("th").eq(column.index()))
	              .on('change', function () {
	              var val = $.fn.dataTable.util.escapeRegex(
	              $(this).val());                                     

	              column.search(val ? '^' + val + '$' : '', true, false)
	                  .draw();
	          });
	          
	          console.log(select);

	          column.data().unique().sort().each(function (d, j) {
	              select.append('<option>' + d + '</option>')
	          });

	          initkat();
	      });
	    }

    });

  	function initkat(){
  	    $('.kat_drop').select2();
  	}

  	$('#dropdown').select2();


  	$('#year_filter').select2().change(function(){
      $('#data_lead').DataTable().ajax.url("{{url('filter_presales_each_year')}}?nik=1110492070&year=" + this.value).load();
	    console.log(this.value);
	    var tahun = this.value;
	    $.ajax({
	      type:"GET",
	      url:"filter_lead_presales",
	      data:{
	        data:this.value,
	        type:tahun,
	      },
	      success: function(result){
	        $('#body_sip').empty();
	        var table = "";
	        var no = 1;

	        $.each(result, function(key, value){

	          table = table + '<tr>';
	          // table = table + '<td>' + no++ + '</td>';
	          table = table + '<td>' + value.name + '</td>';
	          table = table + '<td>' + value.INITIAL + '</td>';
	          table = table + '<td>' + value.OPEN + '</td>';
	          table = table + '<td>' + value.SD + '</td>';
	          table = table + '<td>' + value.TP + '</td>';
	          table = table + '<td>' + value.WIN + '</td>';
	          table = table + '<td>' + value.LOSE + '</td>';
	          table = table + '<td>' + value.HOLD + '</td>';
	          table = table + '<td>' + value.CANCEL + '</td>';
	          table = table + '<td>' + value.SPESIAL + '</td>';
	          table = table + '<td>' + value.All + '</td>';
	          table = table + '</tr>';

	        });

	        $('#body_sip').append(table);
	      },
	    });

	    $.ajax({
	      type:"GET",
	      url:"getfiltersdyearpresales",
	      data:{
	        data:this.value,
	        type:tahun,
	      },
	      success: function(result){
	        $('#report_sd').empty();

	        var table = "";
	        var no = 1;

	        $.each(result, function(key, value){
	          table = table + '<tr>';
	          table = table + '<td>'+ no++ +'</td>';
	          table = table + '<td>' +value.name+ '</td>';
	          table = table + '<td align="right"><i>' +value.amounts.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")+ '.00</i></td>';
	          table = table + '<td><center>(' +value.leads+ ')</center></td>';
	          table = table + '</tr>';

	        });
	        $('#report_sd').append(table);
	        
	      },
	    });

	    $.ajax({
	      type:"GET",
	      url:"getfiltertpyearpresales",
	      data:{
	        data:this.value,
	        type:tahun,
	      },
	      success: function(result){
	        $('#report_tp').empty();

	        var table = "";
	        var no = 1;

	        $.each(result, function(key, value){
	          table = table + '<tr>';
	          table = table + '<td>'+ no++ +'</td>';
	          table = table + '<td>' +value.name+ '</td>';
	          if(value.amounts == null) {
	            table = table + '<td><center> - </center></td>';
	          } else {
	            table = table + '<td align="right"><i>' +value.amounts.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")+ '.00</i></td>';
	          }
	          table = table + '<td><center>(' +value.leads+ ')</center></td>';
	          table = table + '</tr>';

	        });
	        $('#report_tp').append(table);
	        
	      },
	    });

	    $.ajax({
	      type:"GET",
	      url:"getfilterwinyearpresales",
	      data:{
	        data:this.value,
	        type:tahun,
	      },
	      success: function(result){
	        $('#report_win').empty();

	        var table = "";
	        var no = 1;

	        $.each(result, function(key, value){
	          table = table + '<tr>';
	          table = table + '<td>'+ no++ +'</td>';
	          table = table + '<td>' +value.name+ '</td>';
	          table = table + '<td align="right"><i>' +value.amounts.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")+ '.00</i></td>';
	          table = table + '<td><center>(' +value.leads+ ')</center></td>';
	          table = table + '</tr>';

	        });
	        $('#report_win').append(table);
	        
	      },
	    });

	    $.ajax({
	      type:"GET",
	      url:"getfilterloseyearpresales",
	      data:{
	        data:this.value,
	        type:tahun,
	      },
	      success: function(result){
	        $('#report_lose').empty();

	        var table = "";
	        var no = 1;

	        $.each(result, function(key, value){
	          table = table + '<tr>';
	          table = table + '<td>'+ no++ +'</td>';
	          table = table + '<td>' +value.name+ '</td>';
	          table = table + '<td align="right"><i>' +value.amounts.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")+ '.00</i></td>';
	          table = table + '<td><center>(' +value.leads+ ')</center></td>';
	          table = table + '</tr>';

	        });
	        $('#report_lose').append(table);
	        
	      },
	    });
  	});

    function scrollTabs(distance) {
      document.getElementById("scrollableTabs").scrollLeft += distance;
    }
</script>
@endsection