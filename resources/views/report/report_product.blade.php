@extends('template.main_sneat')
@section('tittle')
Report Brands
@endsection
@section('pageName')
Report Brands
@endsection
@section('head_css')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
  <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmSAQhPWId5Nd6QxE8To4ADjM2a6n0BrqQdisZ/RPUlm0YycDzvNL1HHAh1nKZqI0kSbif+5upQ==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
  <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
  <style type="text/css">
    .header th:first-child{
      background-color: #003A95 !important;
      color: white!important;
    }

    .header th:nth-child(2){
      background-color: #4C4CA6 !important;
      color: white!important;
    }

    .header th:nth-child(3){
      background-color: #7561B8 !important;
      color: white!important;
    }

    .header th:nth-child(4){
      background-color: #9A76C9 !important;
      color: white!important;
    }

    .header th:nth-child(5){
      background-color: #BD8EDB!important;
      color: white!important;
    }

    .header th:nth-child(6){
      background-color: #DFA6ED !important;
      color: white!important;
    }

    .header th:nth-child(7){
      background-color: #FFC0FF !important;
      color: #801d0f;
    }

    .green1-color{
      background-color: #003A95 !important;
      color: white!important;
    }

    .green2-color{
      background-color: #4C4CA6 !important;
      color: white!important;
    }

    .green3-color{
      background-color: #7561B8 !important;
      color: white!important;
    }

    .green4-color{
      background-color: #9A76C9 !important;
      color: white!important;
    }

    .green5-color{
      background-color: #BD8EDB!important;
      color: white!important;
    }

    .green6-color{
      background-color: #DFA6ED !important;
      color: white!important;
    }

    .green7-color{
      background-color: #FFC0FF !important;
      color: #801d0f;
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
              <h6 class="card-title"><i class="bx bx-table"></i> Report Brands</h6>
            </div>         
            <div class="card-body">  
              <div class="row mb-4">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Date</label>
                      <div class="input-group">
                        <div class="input-group-text">
                          <i class="bx bx-calendar"></i>
                        </div>
                        <input type="text" class="form-control dates" id="reportrange" name="Dates" autocomplete="off" placeholder="Select days" required />
                        <span class="input-group-text" style="cursor: pointer" type="button" id="daterange-btn"><i class="bx bx-caret-down"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Brand</label>
                      <select class="select2 form-control" style="width:100%;" id="select2Product" name="select2Product">                 
                      </select>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="form-group" style="margin-top:17px">
                      <button class="btn btn-sm btn-primary btnApply"><i class="bx bx-check-circle"></i> Apply</button> 
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Search</label>
                      <div class="input-group">
                        <input id="searchBrand" type="text" class="form-control" onkeyup="searchCustom('data_product','searchBrand')" placeholder="Search Anything">
                        
                        <button type="button" id="btnShowEntryRoleUser" class="btn btn-sm btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                          Show 10 entries
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="#" onclick="$('#data_product').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
                          <li><a class="dropdown-item" href="#" onclick="$('#data_product').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
                          <li><a class="dropdown-item" href="#" onclick="$('#data_product').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
                          <li><a class="dropdown-item" href="#" onclick="$('#data_product').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
                        </ul>
                        <button onclick="searchCustom('data_product','searchBrand')" type="button" class="btn btn-sm btn-outline-secondary btn-flat">
                          <i class="bx bx-fw bx-search"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group" style="margin-top:17px">
                      <button class="btn btn-sm btn-info" onclick="reloadTable()"><i class="bx bx-refresh"></i> Refresh</button>
                    </div>
                  </div>           
              </div>
              <div class="row mb-4">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Note: Untuk total amount dan total perhitungan yang tampil adalah total amount dan total perhitungan pertagging, yang diisi oleh presales atau sales ketika proses SD atau ketika akan submit Result WIN.</label>
                  </div>
                </div>
              </div>            
              <!-- <div class="table-responsive"> -->
                <table class="table table-bordered table-striped" id="data_product" width="100%" cellspacing="0">
                  <thead>
                    <tr class="header">
                      <th>BRANDS</th>
                      @foreach($territory_loop as $data)
                      <th><center>{{$data->id_territory}}</center></th>
                      @endforeach
                      <th><center>TOTAL</center></th>
                    </tr>
                  </thead>
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
              <!-- </div> -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/sum().js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.datatables.net/rowgroup/1.1.2/js/dataTables.rowGroup.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('script')
<script type="text/javascript">
  function initproduct(){
      $('.dates').daterangepicker({
        startDate: moment().startOf('year'),
        endDate  : moment().endOf('year'),
        locale: {
          format: 'DD/MM/YYYY'
        }
      },function (start, end) {
          start: moment();
          end  : moment();

          start_date  = start.format("YYYY-MM-DD 00:00:00");
          end_date    = end.format("YYYY-MM-DD 00:00:00");

          // $('#report_territory').DataTable().ajax.url("{{url('getFilterDateTerritory')}}?start_date=" + start_date + "&" + "end_date=" + end_date).load();
          // $('#data_product').DataTable().ajax.url("{{url('/getFilterProduct')}}?start_date=" + start_date + "&" + "end_date=" + end_date + "&" + "name_product=" + $("#select2Product").val()).load();


          // $('#data_product').DataTable().ajax.url("{{url('filter_presales_each_year')}}?nik=" + nik + "&" + "year=" + $('#year_filter').val()).load();

      });

      $('#daterange-btn').daterangepicker(
        {
          ranges   : {
            'This Month'   : [moment().startOf('month'), moment().endOf('month')],
            'Last 3 Month' : [moment().startOf('month').subtract(3, 'months'), moment().endOf('month')],
            'Last 6 Month' : [moment().startOf('month').subtract(6, 'months'), moment().endOf('month')],
            'Last Year'    : [moment().startOf('year').subtract(1, 'year'),moment().endOf('year').subtract(1, 'year')],
            'This Year'    : [moment().startOf('year'),moment().endOf('year')],
          },
          locale: {
            format: 'DD/MM/YYYY'
          }
        },
        function (start, end) {
          $('#reportrange').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'))

          start_date  = start.format("YYYY-MM-DD 00:00:00");
          end_date    = end.format("YYYY-MM-DD 00:00:00");

          // $('#data_product').DataTable().ajax.url("{{url('/getFilterProduct')}}?start_date=" + start_date + "&" + "end_date=" + end_date + "&" + "name_product=" + $("#select2Product").val()).load();
        }
      )

      var tables = $('#data_product').dataTable({
      "ajax":{
              "type":"GET",
              "url":"{{url('/getreportproduct')}}",
            },
            "scrollX":true,
            "columns": [
              {
                render: function ( data, type, row ) {
                  return '<i>'+ row.name_product +'</i>';
                  
                }
              },  
              // { "data": "name_product" },
              {
                render: function ( data, type, row ) {
                  return '<center> <b>[' + row.countTerOp + ']</b><br>' + $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display(row.operation_price) + '</p></center>';
                  
                }
              },  
              {
                render: function ( data, type, row ) {
                  return '<center> <b>[' + row.countTer1 + ']</b><br>' + $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display(row.ter1_price) + '</p></center>';
                  
                }
              },  
              {
                render: function ( data, type, row ) {
                  return '<center> <b>[' + row.countTer2 + ']</b><br>' + $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display(row.ter2_price) + '</p></center>';
                  
                }
              },  
              {
                render: function ( data, type, row ) {
                  return '<center> <b>[' + row.countTer3 + ']</b><br>' + $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display(row.ter3_price) + '</p></center>';
                  
                }
              },  
              {
                render: function ( data, type, row ) {
                  return '<center> <b>[' + row.countTer4 + ']</b><br>' + $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display(row.ter4_price) + '</p></center>';
                  
                }
              },    
              {
                render: function ( data, type, row ) {
                  return '<center> <b>[' + row.countTer5 + ']</b><br>' + $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display(row.ter5_price) + '</p></center>';
                  
                }
              }, 
              {
                render: function ( data, type, row ) {
                  return '<center> <b>[' + row.total_lead + ']</b><br>' + $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display(row.total_price) + '</p></center>';
                  
                }
              },       
            ],
            "scrollX": false,
            "ordering": false,
            "processing": true,
            "lengthChange": false,
            "paging": true,
            sDom: 'lrtip',
            "rowCallback": function( row, data ) {
              $('td', row).eq(0).addClass('green1-color');
              $('td', row).eq(1).addClass('green2-color');
              $('td', row).eq(2).addClass('green3-color');
              $('td', row).eq(3).addClass('green4-color');
              $('td', row).eq(4).addClass('green5-color');
              $('td', row).eq(5).addClass('green6-color');
              $('td', row).eq(6).addClass('green7-color');
          },
          rowGroup: {
              startRender: null,
              endRender: function ( rows, group ) {
                var intVal = function ( i ) {
                  return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                          i : 0;
                };

                var amount_operation = rows
                    .data()
                    .pluck('operation_price')
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                var amount_ter1 = rows
                    .data()
                    .pluck('ter1_price')
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                var amount_ter2 = rows
                    .data()
                    .pluck('ter2_price')
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                var amount_ter3 = rows
                    .data()
                    .pluck('ter3_price')
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                var amount_ter4 = rows
                    .data()
                    .pluck('ter4_price')
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                var amount_ter5 = rows
                    .data()
                    .pluck('ter5_price')
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                return $('<tr><td>'+ '<b>' + 'Total Amount : ' + '</td>' + '<td>' + '<center><b>' + $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display( amount_operation ) + '</b></center>' +'</td>' + '<td>' + '<center><b>' + $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display( amount_ter1 ) + '</b></center>' +'</td>' + '<td>' + '<center><b>' + $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display( amount_ter2 ) + '</b></center>' +'</td>' + '<td>' + '<center><b>' + $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display( amount_ter3 ) + '</b></center>' +'</td>' + '<td>' + '<center><b>' + $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display( amount_ter4 ) + '</b></center>' +'</td>' + '<td>' + '<center><b>' + $.fn.dataTable.render.number(',', '.', 0, 'Rp.').display( amount_ter5 ) + '</b></center>' +'</td>' + '</tr>');
              }
          }
      });
  }
  
  function searchCustom(id_table,id_seach_bar){
    $("#" + id_table).DataTable().search($('#' + id_seach_bar).val()).draw();
  }

  function reloadTable(){
    $('#data_product').DataTable().search("").draw()
    $('#data_product').DataTable().ajax.url("{{url('/getreportproduct')}}").load();
    $('#select2Product').empty();
    initSelectCustomer()
  }

  function initSelectCustomer(){
    $.ajax({
      url: "{{url('/project/getProductTag')}}",
      type: "GET",
      success: function(result) {
        var arr = result.results;
        var selectOption = [];
        var otherOption;

        var data = {
          id: -1,
          text: 'All Brand'
        };

        selectOption.push(data)
        $.each(arr,function(key,value){
          selectOption.push(value)
        })

        $("#select2Product").select2({
          placeholder:"Select Customer",
          // multiple:true,
          data:selectOption
        })
      }
    })
  }

  $(document).ready(function (){  
    initproduct()
    initSelectCustomer()
    $.ajax({
      url: "{{url('/getTerritory')}}",
      type: "GET",
      success: function(result) {
        $("#select2Territory").select2({
          placeholder:"Select Sales",
          // multiple:true,
          data:result.data
        })
      }
    })

     

    start_date = moment().startOf('year').format("YYYY-MM-DD 00:00:00")
    end_date = moment().endOf('year').format("YYYY-MM-DD 00:00:00")

    $(".btnApply").click(function(){
      $(".btnApply").attr("onclick",ApplyFilter($("#select2Product").val()))
    })

    function ApplyFilter(val){
      if (val == -1) {
        // $('#data_product').DataTable().ajax.url("{{url('/getreportproduct')}}").load();
        $('#data_product').DataTable().ajax.url("{{url('/getFilterProduct')}}?start_date=" + start_date + "&" + "end_date=" + end_date).load();
      }else{
        $('#data_product').DataTable().ajax.url("{{url('/getFilterProduct')}}?start_date=" + start_date + "&" + "end_date=" + end_date + "&" + "name_product=" + $("#select2Product").val()).load();
      }
      
    }    
  })
</script>
@endsection