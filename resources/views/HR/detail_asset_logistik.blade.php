@extends('template.main_sneat')
@section('tittle')
GA Logistik
@endsection
@section('pageName')
General Affair - Detail Logistik
@endsection
@section('head_css')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <section class="content">
    @if (session('update'))
      <div class="alert alert-warning" id="alert">
          {{ session('update') }}
      </div>
    @endif

    @if (session('danger'))
      <div class="alert alert-danger" id="alert">
          {{ session('danger') }}
      </div>
    @endif

    @if (session('success'))
      <div class="alert alert-success" id="alert">
        {{ session('success') }}
      </div>
    @endif

    @if (session('alert'))
      <div class="alert alert-primary" id="alert">
        {{ session('alert') }}
      </div>
    @endif

    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header with-border">
            <h6>Detail Barang</h6>
          </div>

          <div class="card-body">
            <table class="table table-bordered">
              <tr>
                <td style="width:30%">Name</td>
                <td>: {{$data->nama_barang}}</td>
              </tr>
              <tr>
                <td style="width:30%">Current Stock</td>
                <td>: {{$data->qty}} {{$data->unit}}</td>
              </tr>
              <tr>
                <td style="width:30%">Last Activity</td>
                <td>:
                  @if($last_update->status == 'In') 
                    Stock Added 
                  @else 
                    Requested @endif by {{$last_update->name}} at {{date('F, d - Y', strtotime($last_update->created_at))}}
                </td>
              </tr>
            </table>
          </div>
        </div>

        <div class="card card-success">
          <div class="card-header with-border">
          <h6 class="card-title">Summary Transaksi</h6>
          </div>

          <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display no-wrap" id="summary_table" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Month</th>
                      <th>In</th>
                      <th>Out</th>
                    </tr>
                  </thead>
                  <tbody id="products-list" name="products-list">
                  </tbody>
                </table>
            </div>  
          </div>
        </div>

        <div class="card card-success">
          <div class="card-header with-border">
          <h6 class="card-title">Summary Quantity</h6>
          </div>

          <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display no-wrap" id="summary_quantity" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Month</th>
                      <th>In</th>
                      <th>Out</th>
                    </tr>
                  </thead>
                  <tbody id="products-list" name="products-list">
                  </tbody>
                </table>
            </div>  
          </div>
        </div>

        <div class="card card-success">
          <div class="card-header with-border">
          <h6 class="card-title">Most Requested</h6>
          </div>

          <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display no-wrap" id="request_table" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Name</th>
                      <th>Quantity</th>
                    </tr>
                  </thead>
                  <tbody id="products-list" name="products-list">
                  </tbody>
                </table>
            </div>  
          </div>
        </div>
      </div>
      
      <div class="col-lg-6">
        <div class="card card-primary">
          <div class="card-header with-border">
          <h6 class="card-title">Saldo Table</h6>
          </div>

          <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display no-wrap" id="data_Table" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Date</th>
                      <th>In/Out</th>
                      <th>Requested By</th>
                    </tr>
                  </thead>
                  <tbody id="products-list" name="products-list">
                  </tbody>
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
  <script type="text/javascript" src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('assets/js/jquery.mask.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
  <script type="text/javascript" src="http://cdn.datatables.net/plug-ins/1.10.15/dataRender/datetime.js"></script>
@endsection

@section('script')
<script type="text/javascript">
    $('#data_Table').DataTable({
      "ajax":{
          "type":"GET",
          "url":"{{url('/asset_logistik/getSaldoLogistik')}}",
          "data":{
            "id_barang":window.location.href.split("/")[5]
          }
        },
        "columns": [
          { 
            render: function (data, type, row, meta){
              return ++meta.row             
            }
          },
          { 
            render: function (data,type,row){
              return row.created_at.substring(0,10)
            } 
          },
          {
            render: function (data, type, row) {
              if(row.status == 'In'){
               return '+ ' + row.qty + ' ' + row.unit
              }else {
               return '- ' + row.qty + ' ' + row.unit
              }
            }  
          },
          { "data": "name"},
        ],
        columnDefs:[{targets:1, render:function(data){
          return moment(data).format('MMMM');
        }}],
        "order":[],
        "pageLength": 25
    })

    $("#summary_table").dataTable({
      "ajax":{
          "type":"GET",
          "url":"{{url('/asset_logistik/getSummaryLogistik')}}",
          "data":{
            "id_barang":window.location.href.split("/")[5]
          }
        },
        "columns": [
          { 
            render: function (data, type, row, meta){
              return ++meta.row             
            }
          },
          { "data": "month"},
          { "data": "sum_in"},
          { "data": "sum_out"},
        ],
        columnDefs:[{targets:1, render:function(data){
          return moment(data).format('MMMM');
        }}],
        "order":[]
    })

    $("#summary_quantity").dataTable({
      "ajax":{
          "type":"GET",
          "url":"{{url('/asset_logistik/getSummaryQty')}}",
          "data":{
            "id_barang":window.location.href.split("/")[5]
          }
        },
        "columns": [
          { 
            render: function (data, type, row, meta){
              return ++meta.row             
            }
          },
          { "data": "month"},
          { "data": "sum_in"},
          { "data": "sum_out"},
        ],
        columnDefs:[{targets:1, render:function(data){
          return moment(data).format('MMMM');
        }}],
        "order":[]
    })

    $('#request_table').DataTable({
      "ajax":{
          "type":"GET",
          "url":"{{url('/asset_logistik/getMostRequest')}}",
          "data":{
            "id_barang":window.location.href.split("/")[5]
          }
        },
        "columns": [
          { 
            render: function (data, type, row, meta){
              return ++meta.row             
            }
          },
          { "data": "name"},
          { "data": "qty"},
        ],
        "order":[],
      pageLength: 25,
    })
</script>
@endsection