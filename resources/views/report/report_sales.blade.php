@extends('template.main_sneat')
@section('tittle')
Report Sales
@endsection
@section('pageName')
Report Sales
@endsection
@section('head_css')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}"/>
  <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmSAQhPWId5Nd6QxE8To4ADjM2a6n0BrqQdisZ/RPUlm0YycDzvNL1HHAh1nKZqI0kSbif+5upQ==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
  <style type="text/css">
    .btn-warning-export{
      background-color: #ffc107;
      border-color: #ffc107;
    }
    .dataTables_paging {
     display: none;
    }
  </style>
@endsection
@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <section class="content">
        <div class="row mb-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header with-border">
                  <h6 class="card-title"><i class="bx bx-table"></i> Report Sales</h6>
              </div>
              <div class="card-body">
                <div class="row mb-4">
                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-text">
                          <i class="bx bx-calendar"></i>
                        </div>
                        <input type="text" class="form-control" style="width: 70%" id="reportrange" name="Dates" autocomplete="off" placeholder="Select days" required />
                        <span class="input-group-text" style="cursor: pointer" type="button" id="daterange-btn"><i class="bx bx-caret-down"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <button class="btn btn-sm btn-info reload-table" id="reload-table"><i class="bx bx-refresh"></i> Refresh</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-4">
          <div style="display: none;" id="col-large">
            <div class="card card-primary">
              <div class="card-header with-border">
                <h6 class="card-title"><i>TOP 5 SIP</i></h6>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped" id="data_top_sip" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="5%"><center>No.</center></th>
                      <th><center>Sales Name</center></th>
                      <th width="20%"><center>Total Amount</center></th>
                      <th width="10%"><center>Total</center></th>
                      <th width="10%"><center>Total</center></th>
                      <th width="10%"><center>Total</center></th>
                    </tr>
                  </thead>
                  <tbody id="" name="">
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="card card-primary" id="card-msp" style="display: none;">
              <div class="card-header with-border">
                <h6 class="card-title"><i>TOP 5 MSP</i></h6>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped" id="data_top_msp" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="5%"><center>No.</center></th>
                      <th><center>Sales Name</center></th>
                      <th width="20%"><center>Total Amount</center></th>
                      <th width="10%"><center>Total</center></th>
                      <th width="10%"><center>Total</center></th>
                      <th width="10%"><center>Total</center></th>
                    </tr>
                  </thead>
                  <tbody id="" name="">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        
        <!-- <div class="row mb-4">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header with-border">
                <form action="" method="get" class="margin-bottom">
                  <div class="row mb-4">
                    <div class="col-md-12">
                      <select style="width: 100px;float: left;" class="form-control" id="year_filter2">
                      @foreach($years as $data)
                      <option value="{{$data->year}}">{{$data->year}}</option>
                      @endforeach
                      </select>
                      <div class="col-md-2">
                        <input type="text" id="startdate" class="form-control" autocomplete="off" placeholder="DD/MM/YYYY">          
                      </div>
                      <div style="float: left;margin-top: 5px">
                        <small>TO</small>
                      </div>
                      <div class="col-md-2">
                        <input type="text" id="enddate" class="form-control" autocomplete="off" placeholder="DD/MM/YYYY" disabled>
                      </div>
                      <div class="col-md-2">
                        <input type="button" name="filter_submit" id="filter_submit" value="Filter" class="btn btn-sm btn-primary" disabled>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div> -->

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
                        <th><center>Sales Name</center></th>
                        <th width="15%"><center>Company</center></th>
                        <th width="20%"><center>Total Amount</center></th>
                        <th width="10%"><center>Total</center></th>                    
                        <th width="10%"><center>Total</center></th>
                        <th width="10%"><center>Total</center></th>
                      </tr>
                    </thead>
                    <tbody id="report_sd" name="report_sd">
                    </tbody>
                    <tfoot>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tfoot>
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
                        <th><center>Sales Name</center></th>
                        <th width="15%"><center>Company</center></th>
                        <th width="20%"><center>Total Amount</center></th>
                        <th width="10%"><center>Total</center></th>
                        <th width="10%"><center>Total</center></th>
                        <th width="10%"><center>Total</center></th>
                      </tr>
                    </thead>
                    <tbody id="report_tp" name="report_tp">
                    </tbody>
                    <tfoot>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tfoot>
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
                        <th><center>Sales Name</center></th>
                        <th width="15%"><center>Company</center></th>
                        <th width="20%"><center>Total Amount</center></th>
                        <th width="10%"><center>Total</center></th>
                        <th width="10%"><center>Total</center></th>
                        <th width="10%"><center>Total</center></th>
                      </tr>
                    </thead>
                    <tbody id="report_win" name="report_win">
                    </tbody>
                    <tfoot>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tfoot>
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
                        <th><center>Sales Name</center></th>
                        <th width="15%"><center>Company</center></th>
                        <th width="20%"><center>Total Amount</center></th>
                        <th width="10%"><center>Total</center></th>
                        <th width="10%"><center>Total</center></th>
                        <th width="10%"><center>Total</center></th>
                      </tr>
                    </thead>
                    <tbody id="report_lose" name="report_lose">
                    </tbody>
                    <tfoot>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tfoot>
                  </table>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script></script>
<script type="text/javascript" src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/jquery.mask.js')}}"></script>
<!-- bootstrap flatpickr -->
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('script')
<script>
  var accesable = @json($feature_item);
    if (accesable.includes('col-small')) {
      $('#card-msp').show()
      $('#col-large').show().addClass('col-lg-6')
    }else{
      $('#col-large').addClass('col-lg-12')

    } 

    accesable.forEach(function(item,index){
    $("#" + item).show() 

            
  })
  $("#startdate").on('change',function(){
    $("#enddate").attr('disabled',false)
    
    $("#enddate").on('change',function(){
        $("#filter_submit").attr('disabled',false)
    });
  });

  $('#enddate').flatpickr({
    autoclose: true
  })

  $('#startdate').flatpickr({
    autoclose: true
  })

  $('#reportrange').daterangepicker({
    startDate: moment().startOf('year'),
    endDate  : moment().endOf('year'),
    locale: {
      format: 'DD/MM/YYYY'
    }
  },function (start, end) {
      start: moment();
      end  : moment();

      start  = start.format("YYYY-MM-DD 00:00:00");
      end    = end.format("YYYY-MM-DD 00:00:00");

      $('#data_sd').DataTable().ajax.url("{{url('getfiltersd')}}?start=" + start + "&end=" + end).load();
      $('#data_tp').DataTable().ajax.url("{{url('getfiltertp')}}?start=" + start + "&end=" + end).load();
      $('#data_win').DataTable().ajax.url("{{url('getfilterwin')}}?start=" + start + "&end=" + end).load();
      $('#data_lose').DataTable().ajax.url("{{url('getfilterlose')}}?start=" + start + "&end=" + end).load();
      $('#data_top_sip').DataTable().ajax.url("{{url('get_filter_top_win_sip')}}?start=" + start + "&end=" + end).load();
      $('#data_top_msp').DataTable().ajax.url("{{url('get_filter_top_win_msp')}}?start=" + start + "&end=" + end).load();

  });

  var currentYear = moment().year(); // This Year

  var currentYearStart = moment({
    years: currentYear,
    months: '0',
    date: '1'
  }); // 1st Jan this year

  var currentYearEnd = moment({
    years: currentYear,
    months: '11',
    date: '31'
  });

  var appendDateRange = ''
  var dateRange = {};
  dateRange["Today"] = [moment(), moment()];
  dateRange["This Month"] = [moment().startOf('month'), moment().endOf('month')];
  $.each(JSON.parse('@json($years)'), function(key, value){
    if (value.year == currentYear) {
      dateRange["<i class='bx bx-calendar'></i> " + value.year] = [moment(currentYearStart), moment(currentYearEnd)];
    }else{
      dateRange["<i class='bx bx-calendar'></i> " + value.year] = [moment(currentYearStart.subtract(1, "year")), moment(currentYearEnd.subtract(1, "year"))];
    }
  })


  $('#daterange-btn').daterangepicker({
    ranges : dateRange,
    locale: {
      format: 'DD/MM/YYYY'
    }
  }, 
  function (start, end) {
    $('#reportrange').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'))

    start  = start.format("YYYY-MM-DD 00:00:00");
    end    = end.format("YYYY-MM-DD 00:00:00");

    $('#data_sd').DataTable().ajax.url("{{url('getfiltersd')}}?start=" + start + "&end=" + end).load();
    $('#data_tp').DataTable().ajax.url("{{url('getfiltertp')}}?start=" + start + "&end=" + end).load();
    $('#data_win').DataTable().ajax.url("{{url('getfilterwin')}}?start=" + start + "&end=" + end).load();
    $('#data_lose').DataTable().ajax.url("{{url('getfilterlose')}}?start=" + start + "&end=" + end).load();
    $('#data_top_sip').DataTable().ajax.url("{{url('get_filter_top_win_sip')}}?start=" + start + "&end=" + end).load();
    $('#data_top_msp').DataTable().ajax.url("{{url('get_filter_top_win_msp')}}?start=" + start + "&end=" + end).load();
  })

  // $('#filter_submit').click(function() {
  //   var data = this.value;
  //   var start = moment($( "#startdate" ).flatpickr("getDate")).format("YYYY-MM-DD 00:00:00");
  //   var end = moment($( "#enddate" ).flatpickr("getDate")).format("YYYY-MM-DD 23:59:59");
  //   $('#data_sd').DataTable().ajax.url("{{url('getfiltersd')}}?start=" + start + "&end=" + end).load();
  //   $('#data_tp').DataTable().ajax.url("{{url('getfiltertp')}}?start=" + start + "&end=" + end).load();
  //   $('#data_win').DataTable().ajax.url("{{url('getfilterwin')}}?start=" + start + "&end=" + end).load();
  //   $('#data_lose').DataTable().ajax.url("{{url('getfilterlose')}}?start=" + start + "&end=" + end).load();
  // })

  // $('#year_filter2').change(function() {
  //   var data = this.value;
  //   $('#data_sd').DataTable().ajax.url("{{url('getfiltersdyear')}}?data="+data+"&type=" + data).load();
  //   $('#data_tp').DataTable().ajax.url("{{url('getfiltertpyear')}}?data="+data+"&type=" + data).load();
  //   $('#data_win').DataTable().ajax.url("{{url('getfilterwinyear')}}?data="+data+"&type=" + data).load();
  //   $('#data_lose').DataTable().ajax.url("{{url('getfilterloseyear')}}?data="+data+"&type=" + data).load();
  // })

  $('#reload-table').click(function(){
    $('#reportrange').daterangepicker({
      startDate: moment().startOf('year'),
      endDate  : moment().endOf('year'),
      locale: {
        format: 'DD/MM/YYYY'
      }
    },function (start, end) {
        start: moment();
        end  : moment();

        start  = start.format("YYYY-MM-DD 00:00:00");
        end    = end.format("YYYY-MM-DD 00:00:00");
    });
    $('#data_sd').DataTable().ajax.url("{{url('get_data_sd_report_sales')}}").load();
    $('#data_tp').DataTable().ajax.url("{{url('get_data_tp_report_sales')}}").load();
    $('#data_win').DataTable().ajax.url("{{url('get_data_win_report_sales')}}").load();
    $('#data_lose').DataTable().ajax.url("{{url('get_data_lose_report_sales')}}").load();
    $('#data_top_sip').DataTable().ajax.url("{{url('get_top_win_sip')}}").load();
    $('#data_top_msp').DataTable().ajax.url("{{url('get_top_win_msp')}}").load();
  })

  // $('#data_sd').DataTable();
  var data_sd = $('#data_sd').DataTable({
     "responsive":true,
     // "orderCellsTop": true,
    "ajax":{
        "type":"GET",
        "url":"{{url('get_data_sd_report_sales')}}",
    },
    "columns": [
      { "data": "leads" },
      { "data": "name" },
      { "data": "code_company" },
      { 
        data: null,
        className: "sum",
        render: function ( data, type, row ) {
          // return new Intl.NumberFormat('id').format(row.amounts)
          return $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display(row.amounts)
        },
        "orderData":[4]
      },
      {
        "data":"amounts",
        "targets":[3],
        "searchable":true
      },
      {
        className: "sum2",
        data: null,
        render: function ( data, type, row ) {
           return row.leads 
        }
      },
      {
        className: "sum3",
        data: null,
        render: function ( data, type, row ) {
           return row.amounts 
        }
      }
    ],
    "columnDefs":[
      {
        "targets":[4,6],
        "visible":false
      },
      { targets: 'no-sort', orderable: false }
    ],
    "aaSorting": [],
    "scrollX": true,
    "pageLength": 25,
    "order": [[ 3, "desc" ]],
    "footerCallback": function(row, data, start, end, display) {
        var api = this.api();

        api.columns('.sum3', { page: 'current' }).every(function () {
            var sum = api
                .cells( null, this.index(), { page: 'current'} )
                .render('display')
                .reduce(function (a, b) {
                    var x = parseFloat(a) || 0;
                    var y = parseFloat(b) || 0;
                    return x + y;
                }, 0);
            $("th.sum").last().html($.fn.dataTable.render.number(',', '.', 0, 'Rp.').display(sum));
        });

        api.columns('.sum2', { page: 'current' }).every(function () {
            var sum = api
                .cells( null, this.index(), { page: 'current'} )
                .render('display')
                .reduce(function (a, b) {
                    var x = parseFloat(a) || 0;
                    var y = parseFloat(b) || 0;
                    return x + y;
                }, 0);
            $(this.footer()).html(sum);
        });
    }
  });

  data_sd.on( 'order.dt search.dt', function () {
      data_sd.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      } );
  }).draw();

  var data_tp = $('#data_tp').DataTable({
     "responsive":true,
     "orderCellsTop": true,
     
    "ajax":{
        "type":"GET",
        "url":"{{url('get_data_tp_report_sales')}}",
    },
    "columns": [
      { "data": "leads" },
      { "data": "name" },
      { "data": "code_company" },
      { 
        data: null,
        className: "sum4",
        render: function ( data, type, row ) {
          return $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display(row.amounts)
        },
        "orderData":[4]
      },
      {
        "data":"amounts",
        "targets":[3],
        "searchable":true
      },
      {
        className: "sum5",
        data: null,
        render: function ( data, type, row ) {
           return row.leads 
        }
      },
      {
        className: "sum6",
        data: null,
        render: function ( data, type, row ) {
           return row.amounts 
        }
      }
    ],
    "columnDefs":[
      {
        "targets":[4,6],
        "visible":false
      },
      {
        targets:"no-sort",orderable:false
      }
    ],
    "scrollX": true,
    "pageLength": 25,
    "order": [[ 3, "desc" ]],
    "footerCallback": function(row, data, start, end, display) {
        var api = this.api();

        api.columns('.sum6', { page: 'current' }).every(function () {
            var sum = api
                .cells( null, this.index(), { page: 'current'} )
                .render('display')
                .reduce(function (a, b) {
                    var x = parseFloat(a) || 0;
                    var y = parseFloat(b) || 0;
                    return x + y;
                }, 0);
            $("th.sum4").last().html($.fn.dataTable.render.number(',', '.', 0, 'Rp.').display(sum));
        });

        api.columns('.sum5', { page: 'current' }).every(function () {
            var sum = api
                .cells( null, this.index(), { page: 'current'} )
                .render('display')
                .reduce(function (a, b) {
                    var x = parseFloat(a) || 0;
                    var y = parseFloat(b) || 0;
                    return x + y;
                }, 0);
            $(this.footer()).html(sum);
        });
    }
  });

  data_tp.on( 'order.dt search.dt', function () {
      data_tp.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      } );
  }).draw();

  var data_win = $('#data_win').DataTable({
     "responsive":true,
     "orderCellsTop": true,
     
    "ajax":{
        "type":"GET",
        "url":"{{url('get_data_win_report_sales')}}",
    },
    "columns": [
      { "data": "leads" },
      { "data": "name" },
      { "data": "code_company" },
      { 
        data: null,
        className: "sum7",
        render: function ( data, type, row ) {
          return $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display(row.amounts)
        },
        "orderData":[4]
      },
      {
        "data":"amounts",
        "targets":[3],
        "searchable":true
      },
      {
        className: "sum8",
        data: null,
        render: function ( data, type, row ) {
           return row.leads 
        }
      },
      {
        className: "sum9",
        data: null,
        render: function ( data, type, row ) {
           return row.amounts 
        }
      }
    ],
    "columnDefs":[
      {
        "targets":[4,6],
        "visible":false
      },
      {
        targets:'no-sort',orderable:false
      }
    ],
    "scrollX": true,
    "pageLength": 25,
    "order": [[ 3, "desc" ]],
    "footerCallback": function(row, data, start, end, display) {
        var api = this.api();

        api.columns('.sum9', { page: 'current' }).every(function () {
            var sum = api
                .cells( null, this.index(), { page: 'current'} )
                .render('display')
                .reduce(function (a, b) {
                    var x = parseFloat(a) || 0;
                    var y = parseFloat(b) || 0;
                    return x + y;
                }, 0);
            $("th.sum7").last().html($.fn.dataTable.render.number(',', '.', 0, 'Rp.').display(sum));
        });

        api.columns('.sum8', { page: 'current' }).every(function () {
            var sum = api
                .cells( null, this.index(), { page: 'current'} )
                .render('display')
                .reduce(function (a, b) {
                    var x = parseFloat(a) || 0;
                    var y = parseFloat(b) || 0;
                    return x + y;
                }, 0);
            $(this.footer()).html(sum);
        });
    }
  });

  data_win.on( 'order.dt search.dt', function () {
      data_win.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      } );
  }).draw();

  var data_lose = $('#data_lose').DataTable({
     "responsive":true,
     "orderCellsTop": true,
     
    "ajax":{
        "type":"GET",
        "url":"{{url('get_data_lose_report_sales')}}",
    },
    "columns": [
      { "data": "leads" },
      { "data": "name" },
      { "data": "code_company" },
      { 
        data: null,
        className: "sum10",
        render: function ( data, type, row ) {
          return $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display(row.amounts)
        },
        "orderData":[4]
      },
      {
        "data":"amounts",
        "targets":[3],
        "searchable":true
      },
      {
        className: "sum11",
        data: null,
        render: function ( data, type, row ) {
           return row.leads 
        }
      },
      {
        className: "sum12",
        data: null,
        render: function ( data, type, row ) {
           return row.amounts 
        }
      }
    ],
    "columnDefs":[
      {
        "targets":[4,6],
        "visible":false
      },
      {
        targets:"no-sort",orderable:false
      }
    ],
    "scrollX": true,
    "pageLength": 25,
    "order": [[ 3, "desc" ]],
    "footerCallback": function(row, data, start, end, display) {
        var api = this.api();

        api.columns('.sum12', { page: 'current' }).every(function () {
            var sum = api
                .cells( null, this.index(), { page: 'current'} )
                .render('display')
                .reduce(function (a, b) {
                    var x = parseFloat(a) || 0;
                    var y = parseFloat(b) || 0;
                    return x + y;
                }, 0);
            $("th.sum10").last().html($.fn.dataTable.render.number(',', '.', 0, 'Rp.').display(sum));
        });

        api.columns('.sum11', { page: 'current' }).every(function () {
            var sum = api
                .cells( null, this.index(), { page: 'current'} )
                .render('display')
                .reduce(function (a, b) {
                    var x = parseFloat(a) || 0;
                    var y = parseFloat(b) || 0;
                    return x + y;
                }, 0);
            $(this.footer()).html(sum);
        });
    }
  });

  data_lose.on( 'order.dt search.dt', function () {
      data_lose.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      } );
  }).draw();

  var data_top_sip = $('#data_top_sip').DataTable({
    "ajax":{
        "type":"GET",
        "url":"{{url('get_top_win_sip')}}",
    },
    "columns": [
      { "data": "leads" },
      { "data": "name" },
      { 
        data: null,
        className: "sum10",
        render: function ( data, type, row ) {
          return $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display(row.amounts)
        },
        "orderData":[3]
      },
      {
        "data":"amounts",
        "targets":[2],
        "searchable":true
      },
      {
        data: null,
        render: function ( data, type, row ) {
           return row.leads 
        }
      },
      {
        data: null,
        render: function ( data, type, row ) {
           return row.amounts 
        }
      }
    ],
    "columnDefs":[
      {
        "targets":[3,5],
        "visible":false
      },
      {
        targets:"no-sort",orderable:false
      }
    ],
    "scrollX": true,
    "pageLength": 25,
    "order": [[ 2, "desc" ]],
  });

  data_top_sip.on( 'order.dt search.dt', function () {
      data_top_sip.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      } );
  }).draw();

  var data_top_msp = $('#data_top_msp').DataTable({
    "ajax":{
        "type":"GET",
        "url":"{{url('get_top_win_msp')}}",
    },
    "columns": [
      { "data": "leads" },
      { "data": "name" },
      { 
        data: null,
        className: "sum10",
        render: function ( data, type, row ) {
          return $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display(row.amounts)
        },
        "orderData":[3]
      },
      {
        "data":"amounts",
        "targets":[2],
        "searchable":true
      },
      {
        data: null,
        render: function ( data, type, row ) {
           return row.leads 
        }
      },
      {
        data: null,
        render: function ( data, type, row ) {
           return row.amounts 
        }
      }
    ],
    "columnDefs":[
      {
        "targets":[3,5],
        "visible":false
      },
      {
        targets:"no-sort",orderable:false
      }
    ],
    "scrollX": true,
    "pageLength": 25,
    "order": [[ 2, "desc" ]],
  });

  data_top_msp.on( 'order.dt search.dt', function () {
      data_top_msp.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      } );
  }).draw();

  function initkat(){
    $('.kat_drop').select2();
  }

  $('#dropdown').select2();

  $('.money').mask('000,000,000,000,000,000', {reverse: true});
  $('.total').mask('000,000,000,000,000,000.00', {reverse: true});
</script>
@endsection