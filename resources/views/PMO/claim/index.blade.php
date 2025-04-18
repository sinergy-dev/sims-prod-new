@extends('template.main_sneat')
@section('tittle')
PMO Claim
@endsection
@section('pageName')
Claim
@endsection
@section('head_css')
	<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
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
	    			<div class="col-md-6 col-xs-12" id="search-table">
		    			<a href="{{url('pmo/claim/add_claim')}}" class="btn btn-sm btn-primary" style="width:130px;display: none!important;" id="btnAddClaim"><i class="bx bx-plus"></i> Claim</a>
            </div>
            <div class="col-md-6 col-xs-12 ms-auto">
            	<div class="form-group">
                <div class="input-group">
                  <button type="button" id="btnShowClaim" class="btn btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Show 10 entries
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" onclick="$('#table_claim').DataTable().page.len(10).draw();$('#btnShowClaim').html('Show 10 entries')">10</a></li>
                    <li><a class="dropdown-item" href="#" onclick="$('#table_claim').DataTable().page.len(25).draw();$('#btnShowClaim').html('Show 25 entries')">25</a></li>
                    <li><a class="dropdown-item" href="#" onclick="$('#table_claim').DataTable().page.len(50).draw();$('#btnShowClaim').html('Show 50 entries')">50</a></li>
                    <li><a class="dropdown-item" href="#" onclick="$('#table_claim').DataTable().page.len(100).draw();$('#btnShowClaim').html('Show 100 entries')">100</a></li>
                  </ul>
                  <input id="searchBar" type="text" class="form-control" placeholder="Search Anything" onkeyup="searchBar('searchBar','table_claim')">
                  <button id="applyFilterTablePerformance" type="button" class="btn btn-outline-secondary btn-sm" onclick="searchBar('searchBar','table_claim')">
                    <i class="bx bx-fw bx-search"></i>
                  </button>
                </div>
              </div>
            </div>
	    		</div>
	    		<div class="row">
	    			<div class="col-md-12 table-responsive">
	    				<table class="table table-bordered table-striped" id="table_claim" width="100%" cellspacing="0">
		           </table>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('script')
	<script type="text/javascript">
		var accesable = @json($feature_item);
		accesable.forEach(function(item,index){
      $("#" + item).show()          
    }) 

    console.log(accesable)

		$("#table_claim").DataTable({
			ajax:"{{url('/pmo/claim/getDataClaim')}}",
      columns: [
          { title: 'No Claim', 
          	data: 'no_claim' 
          },
          { title: 'Date', 
          	data: 'date' 
          },
          { title: 'Nominal', 
          	data: 'nominal',
            render: $.fn.dataTable.render.number('.', '.', 0, 'Rp ')
          },
          { title: 'Status', 
          	render: function ( data, type, row ) {
        			var status = '',circularBy = ''

          		if (row.status == 'NEW') {
	        			status = '<span class="badge text-bg-info">'+ row.status +'</span>'
	        		} else if (row.status == 'CIRCULAR') {
	        			status = '<span class="badge text-bg-warning">'+ row.status +'</span>'
	        		} else if (row.status == 'UNAPPROVED') {
	        			status = '<span class="badge text-bg-danger">'+ row.status +'</span>'
	        		}	else if (row.status == 'APPROVED') {
	        			status = '<span class="badge text-bg-success">'+ row.status +'</span>'
	        		} else if (row.status == 'DONE') {
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
          { title: 'Created By', 
          	data: 'name' 
          },
          { title: 'Action', 
          	render: function ( data, type, row ) {
                return '<a href="{{url("pmo/claim/detail_claim?id_claim=")}}'+ row.id +'"><button class="btn btn-sm btn-primary">Detail</button></a>';
            }
          }
    	],
    	"aaSorting":[]
		})

		function searchBar(id_seach_bar,id_table){
			$("#"+id_table).DataTable().search($('#' + id_seach_bar).val()).draw();
		}
	</script>
@endsection