@extends('template.main_sneat')
@section('tittle')
SBE
@endsection
@section('pageName')
SBE
@endsection
@section('head_css')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
	<style type="text/css">
		.dataTables_filter {
		    display: none;
		}
	</style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <section class="content">
        <div class="card">
            <div class="card-body">
		        <div class="row">
                    <div class="col-md-6 pull-left">
                        <a class='btn btn-sm btn-primary' style='margin-bottom: 10px;display: none;' href='{{url("/sbe_create?create")}}/' id="btnAddConfig"><i class="bx bx-plus"></i>&nbsp Create Config</a>
                    </div>
		            <div class="col-md-6 pull-right" id="search-table">
                        
		              <div class="input-group">
                        <div class="btn-group" role="group">
                            <button
                              id="btnShowSbe"
                              type="button"
                              class="btn btn-sm btn-secondary dropdown-toggle"
                              data-bs-toggle="dropdown"
                              aria-haspopup="true"
                              aria-expanded="false">
                              Show 10 entries
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnShowSbe">
                              <a class="dropdown-item" onclick="$('#tbListSBE').DataTable().page.len(10).draw();$('#btnShowSbe').html('Show 10 entries')">10</a>
                              <a class="dropdown-item" onclick="$('#tbListSBE').DataTable().page.len(25).draw();$('#btnShowSbe').html('Show 10 entries')">25</a>
                              <a class="dropdown-item" onclick="$('#tbListSBE').DataTable().page.len(50).draw();$('#btnShowSbe').html('Show 10 entries')">50</a>
                              <a class="dropdown-item" onclick="$('#tbListSBE').DataTable().page.len(100).draw();$('#btnShowSbe').html('Show 10 entries')">100</a>
                            </div>
                        </div>
		                <input id="searchBarList" type="text" class="form-control" placeholder="Search Anything" onkeyup="searchCustom('tbListSBE','searchBarList')">
    	                   <button id="applyFilterTableSearch" onclick="searchCustom('tbListSBE','searchBarList')" type="button" class="btn btn-secondary" style="width: 40px;height:37px">
    	                    <i class="bx bx-fw bx-search"></i>
    	                  </button>
		              </div>
		            </div>
		        </div>
		        <div class="table-responsive mt-2">
                    <table class="table table-striped" width="100%" id="tbListSBE">
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scriptImport')
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('script')
<script type="text/javascript">
    var formatter = new Intl.NumberFormat(['ban', 'id']);
	// var data = "data":
    var accesable = @json($feature_item);

    accesable.forEach(function(item,index){
      
      $("#" + item).show()
    })

	var table = $('#tbListSBE').DataTable({	
        "ajax":{
            "type":"GET",
            "url":"{{url('/sbe/getDataSbe')}}",
        },
        columns: [
            {
              title: "Lead ID",
              data: "lead_id"
            },
            {
              title: "Project Name",
              data: "opp_name"
            },
            {
              title: "SOL Staff",
              data: "presales"
            },
            {
              title: "Status",
              // data: "nominal",
              render:function(data,type,row){
                if (row.status == 'Temporary') {
                    var label_bg = 'label-info'
                }else{
                    var label_bg = 'label-success'
                }
                return "<span class='label "+ label_bg +"'>"+ row.status +"</span>"
              }
            },
            {
              title: "Amount",
              // data: "nominal",
              render:function(data,type,row){
                return formatter.format(row.detail_config_nominal)
              }
            },
            {
              title: "Action",
              render:function(data, type, row)
	          {
	          	return '<a class="btn btn-sm btn-primary btnDetail" style="margin-right:5px" data-value="'+ row.id +'" href="{{url("/sbe_detail")}}/'+ row.id +'?'+ row.lead_id +'" id="btnDetail"><i class="bx bxs-show"></i></a>'
	          },
              data: null
            },
        ],
        "drawCallback": function( settings ) {
            var api = this.api();
            
            $.each(api.rows({page:'current'}).data(),function(index,item){
                
                if (item.status == "Fixed") {
                    
                    $(".btnDetail[data-value='"+ item.id +"']").next().remove()
                    $(".btnDetail[data-value='"+ item.id +"']").after('<a class="btn btn-sm btn-success" href="'+ item.link_document +'" target="_blank"><i class="bx bxs-file-pdf"></i></a>')
                }
            })
            // Output the data for the visible rows to the browser's console
            
        },
        initComplete:function(){
            if (!accesable.includes('colSolStaff')) {
                table.columns(2).visible(false);
            }
        },
        "bFilter": true,
        "bSort":true,
        "bLengthChange": false,
        "bInfo": false
    });

    function searchCustom(id_table,id_seach_bar){
        $("#" + id_table).DataTable().search($('#' + id_seach_bar).val()).draw();
    }
</script>
@endsection