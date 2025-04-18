@extends('template.main_sneat')
@section('tittle')
PMO Money Request
@endsection
@section('pageName')
Money Request
@endsection
@section('head_css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
<style type="text/css">
	.dataTables_length{
    	display: none
  	}
  
  	.dataTables_filter {
    	display: none;
  	}
</style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
	<section class="content">
		<div class="card">
		    <div class="card-header">
		        <div class="pull-right">
		        </div>
		    </div>

	    	<div class="card-body">
	    		<div class="row mb-4">
		    		<div class="col-md-8 col-xs-12" id="search-table">
	    				@if(isset($isHadSettlement))
		    				@if($isHadSettlement->status_settlement)
		    					<a href="{{url('/pmo/monreq/add_monreq')}}"><button class="btn btn-sm btn-primary" style="width:180px;display:none!important;" id="btnAddMonreq"><i class="bx bx-plus"></i> Money Request</button></a>
		    				@else
		    					<button class="btn btn-sm btn-primary" style="width:180px" disabled><i class="bx bx-plus"></i> Money Request</button>
		    				@endif
		    			@else
		    				<a href="{{url('/pmo/monreq/add_monreq')}}"><button class="btn btn-sm btn-primary" style="width:180px;display:none!important;" id="btnAddMonreq"><i class="bx bx-plus"></i> Money Request</button></a>
		    			@endif
		    		</div>
	    			<div class="col-md-4 ms-auto">
              <div class="input-group">
                <button type="button" id="btnShowMonreq" class="btn btn-sm btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  Show 10 entries
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" onclick="$('#table-pid').DataTable().page.len(10).draw();$('#btnShowMonreq').html('Show 10 entries')">10</a></li>
                  <li><a class="dropdown-item" href="#" onclick="$('#table-pid').DataTable().page.len(25).draw();$('#btnShowMonreq').html('Show 25 entries')">25</a></li>
                  <li><a class="dropdown-item" href="#" onclick="$('#table-pid').DataTable().page.len(50).draw();$('#btnShowMonreq').html('Show 50 entries')">50</a></li>
                  <li><a class="dropdown-item" href="#" onclick="$('#table-pid').DataTable().page.len(100).draw();$('#btnShowMonreq').html('Show 100 entries')">100</a></li>
                </ul>
                <input id="searchBar" type="text" class="form-control" placeholder="Search Anything" onkeyup="searchBar('searchBar','table_settlement')">
                <button id="applyFilterTablePerformance" type="button" class="btn btn-outline-secondary btn-sm" onclick="searchBar('searchBar','table_settlement')">
                  <i class="bx bx-fw bx-search"></i>
                </button>
              </div>
            </div>
	    		</div>
	    		<div class="row mb-4">
	    			@if(isset($isLastMonreqDone))
	    				@if($isLastMonreqDone->status_monreq)
	    					@if(isset($isHadSettlement))
				    			@if(!$isHadSettlement->status_settlement)
				    			<div class="col-md-12">
				    				<div class="alert alert-danger">Your money request has not settlement, please create settlement for request new money request! <a href="{{url('/pmo/settlement/add_settlement')}}"><i class="bx bx-plus"></i> Settlement</a></div>
				    			</div>
				    			@endif
			    			@endif
	    				@else
				    		<div class="col-md-12">
	    						@if($isLastMonreqDone->status == 'CIRCULAR' || $isLastMonreqDone->status == 'NEW')
		    						<div class="alert alert-danger">Please wait for approval process!</div>
		    					@elseif($isLastMonreqDone->status == 'APPROVED')
		    						<div class="alert alert-danger">Please wait for finance upload proof of transfer process!</div>
		    					@endif
		    				</div>
	    				@endif
	    			@endif
	    			<div class="col-md-12 table-responsive">
	    				<table class="table table-bordered table-striped" id="table_monreq" width="100%" cellspacing="0">
		          </table>
	    			</div>
	    		</div>
	    	</div>
	    </div>
	</section>
</div>
@endsection
@section('scriptImport')
		<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
		<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  	<script type="text/javascript" src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('script')
	<script type="text/javascript">
    var formatter = new Intl.NumberFormat(['ban', 'id']);

    var accesable = @json($feature_item);
    accesable.forEach(function(item,index){
      $("#" + item).show()          
    })  

    console.log(accesable)

		$("#table_monreq").DataTable({
			ajax:"{{url('pmo/monreq/getMonReq')}}",
	    columns: [
        { title: 'No',
        	data: 'no_monreq'  
        	// render: function ( data, type, row, meta ) {
          //     return meta.row+1;
          // } 
        },
        { title: 'Date', 
        	data: 'date' 
        },
        { title: 'Created By', 
        	data: 'name' 
        },
        { title: 'Total Price', 
        	data: 'nominal',
          render: $.fn.dataTable.render.number('.', '.', 0, 'Rp ')
        },
        { title: 'Status', 
        	render: function ( data, type, row ) {
        		var status = '',circularBy = ''
        		if (row.status == 'NEW') {
        			status = '<span class="badge text-bg-info">' + row.status + '</span>'
        		} else if (row.status == 'CIRCULAR') {
        			status = '<span class="badge text-bg-warning">'+ row.status +'</span>'
        		} else if (row.status == 'UNAPPROVED') {
        			status = '<span class="badge text-bg-danger">'+ row.status +'</span>'
        		} else if (row.status == 'APPROVED') {
        			status = '<span class="badge text-bg-success">'+ row.status +'</span>'
        		}else if (row.status == 'DONE') {
        			status = '<span class="badge text-bg-success">'+ row.status +'</span>'
        		}

        		if (row.circularBy == '-') {
        			circularBy = circularBy
        		}else{
        			circularBy = '<br>' + '<small> Circular on ' + row.circularBy + '</small>'
        		}

        		if (row.isCircular == 'True') {
        			return status + circularBy
        		}else{
        			return status
        		}
          },
          class:'text-center' 
        },
        { title: 'Settlement Status', 
        	render: function ( data, type, row ) {
        		if (row.status_settlement == null) {
        			return 'Tba'
        		} else if (row.status_settlement == 'VERIFIED') {
        			return '<span class="badge text-bg-warning">'+ row.status_settlement +'</span>'
        		} else if (row.status_settlement == 'NEW') {
        			return '<span class="badge text-bg-info">'+ row.status_settlement +'</span>'
        		} else if (row.status_settlement == 'CIRCULAR') {
        			return '<span class="badge text-bg-warning">'+ row.status_settlement +'</span>'
        		} else if (row.status_settlement == 'UNAPPROVED') {
        			return '<span class="badge text-bg-danger">'+ row.status_settlement +'</span>'
        		}	else if (row.status_settlement == 'APPROVED') {
        			return '<span class="badge text-bg-success">'+ row.status_settlement +'</span>'
        		} else if (row.status_settlement == 'DONE') {
        			return '<span class="badge text-bg-success">'+ row.status_settlement +'</span>'
        		}
          },
          class:'text-center' 
        },
        { title: 'Action', 
        	render: function ( data, type, row ) {
              return '<a href="{{url("/pmo/monreq/detail_monreq?id_detail=")}}'+ row.id +'"><button class="btn btn-sm btn-primary">Detail</button></a>';
          }
        }
	  	],
	  	columnDefs: [
        { "orderable": false, "targets": 0 }  // Disable ordering on the first column (index 0)
    	],
    	"aaSorting": []
		})

		function searchBar(id_seach_bar,id_table){
			$("#"+id_table).DataTable().search($('#' + id_seach_bar).val()).draw();
		}
	</script>
@endsection