@extends('template.main_sneat')
@section('tittle')
Record Log History
@endsection
@section('pageName')
Record Log History
@endsection
@section('head_css')
	<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmSAQhPWId5Nd6QxE8To4ADjM2a6n0BrqQdisZ/RPUlm0YycDzvNL1HHAh1nKZqI0kSbif+5upQ==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
	<!-- Select2 -->
	<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
@endsection
@section('content')
<div class="container-xxl container-p-y flex-grow-1">	
	<section class="content">
	<div class="row">
	    <div class="col-md-12">
	      	<div class="card">
		        <div class="card-header with-border">
		          <h6 class="card-title"><i class="bx bx-table"></i> Last Logged In Users</h6>
		        </div>
		        <div class="card-body">
		        		<div class="row">
		        			<div class="col-md-3" id="divFilterByPerson" style="display: none;">
			              <label>Filter by Person</label>
			              <select class="form-control capitalize" style="width: 100%;max-width: 250px" id="searchTagsPerson"></select>
			            </div>
			            <div class="col-md-3" id="divFilterByDate" style="display: none;">
					          <label>Filter by Date</label>
					          <div class="input-group">
					            <span class="input-group-text">
					              <i class="bx bx-calendar"></i>
					            </span>
					            <input type="text" class="form-control" id="reportrange" name="Dates" autocomplete="off" placeholder="Select days" required />
					            <span class="input-group-text" style="cursor: pointer" type="button" id="daterange-btn"><i class="bx bx-caret-down"></i></span>
					          </div>
					        </div>			            
				        	<div class="col-md-3">
				          	<button class="btn btn-sm btn-primary" id="apply-btn" style="margin-top: 25px"><i class="bx bx-check-circle"></i> Apply</button>
				           	<button class="btn btn-sm btn-info reload-table" id="reload-table" style="margin-top: 25px"><i class="bx bx-refresh"></i> Refresh</button>
				        	</div>
				        </div>
	            	<div class="table-responsive">
		              	<table class="table table-bordered table-striped" id="table_login_today" width="100%" cellspacing="0">
		                <thead>
		                  <tr class="header">
		                    <th>Name</th>
		                    <th>Email</th>                  
		                    <th>Last Login at</th>
		                    <th>IP Adress</th>
		                  </tr>
		                </thead>
		                <tbody>
		                	<tr>
		                		<td>Faiqoh</td>
		                		<td>Faiqoh@sinergy.co.id</td>
		                		<td>2020-09-23 13:50:22</td>
		                		<td>192.168.2.57</td>
		                	</tr>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
	<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		var accesable = @json($feature_item);
		accesable.forEach(function(item,index){
			$("#" + item).show()
		})
	})

	initTableBefore();

	function initTableBefore(){
		$("#table_login_today").DataTable({
			"ajax":{
	      "type":"GET",
        "url":"{{url('/get_auth_login_users')}}",
      },
      "columns": [
        { "data": "name" },  
        { "data": "email" },  
        { "data": "datetime" },
        { "data": "ip_address" }         
      ],
      "scrollX": false,
      "ordering": false,
      "processing": true,
      "serverSide":true,
		});

	}	

	$.ajax({
        url:"sales/getAllEmployee",
        type:"GET",
        success:function(result){
          $("#searchTagsPerson").select2().val("");
          var arr = result;
          var selectOption = [];
          var data = {
              id: 2,
              text: 'All'
          };

          selectOption.push(data)
          $.each(arr,function(key,value){
            selectOption.push(value)
          })

          var TagPersona = $("#searchTagsPerson").select2({
            placeholder: " Select Person",
            allowClear: true,
            multiple:true,
            data:selectOption,
            templateSelection: function(selection,container) {
              console.log(selection)
              if (selection.text == 'All') {
                return $.parseHTML('<span>' + selection.text + '</span>');
              }else{
                var selectedOption = $(selection.element).parent('optgroup').attr('label');
                  if(selectedOption == 'Sales') {
                      $(container).css("background-color", "#e6a715");
                      $(container).css("border-color","#e6a715");
                      return selection.text;
                  }else if (selectedOption == 'Presales') {
                      $(container).css("background-color", "#e0511d");
                      $(container).css("border-color","#e0511d");
                      return $.parseHTML('<span>' + selection.text.toLowerCase() + '</span>');
                  }else{
                      return $.parseHTML('<span>' + selection.text + '</span>');
                  }
              }
            
            }
          })

        }
    
    })

    var start = moment().startOf('year');
    var end = moment().endOf('year');

    function cb(start,end){
        $('#reportrange').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'))

        start_date  = start.format("YYYY-MM-DD 00:00:00");
        end_date    = end.format("YYYY-MM-DD 00:00:00");
    }

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
      cb);

    cb(start,end);

    $("#apply-btn").click(function(){
    	var TagsPersona = $("#searchTagsPerson").val();
    	console.log(TagsPersona);

    	if (TagsPersona == "") {
    		$('#table_login_today').DataTable().ajax.url("{{url('getFilterRecordAuth')}}?start_date=" + start_date + "&" + "end_date=" + end_date).load();
    	}else{
    		$('#table_login_today').DataTable().clear().destroy();

    		$("#table_login_today").DataTable({
				"ajax":{
          "type":"GET",
          "url":"{{url('/getFilterRecordAuth')}}",
          "data":{
          	"TagsPersona":TagsPersona,
          		"start_date":start_date,
          		"end_date":end_date
          }
        },
        "columns": [
          { "data": "name" },  
          { "data": "email" },  
          { "data": "datetime" },
          { "data": "ip_address" }         
        ],
        "scrollX": false,
        "ordering": false,
        "processing": true,
			});
    	}
    });

    $("#reload-table").click(function(){
      $('#table_login_today').DataTable().clear().destroy();
      $("#table_login_today").DataTable({
				"ajax":{
          "type":"GET",
          "url":"{{url('/get_auth_login_users')}}",
        },
        "columns": [
          { "data": "name" },  
          { "data": "email" },  
          { "data": "datetime" },
          { "data": "ip_address" }         
        ],
        "scrollX": false,
        "ordering": false,
        "processing": true,
      	"serverSide":true,
		});

      	$("#searchTagsPerson").val(null).trigger("change");
    })


	// $("#table_login_7_days").DataTable({
	// 	"ajax":{
 //            "type":"GET",
 //            "url":"{{url('/get_auth_login_users')}}",
 //            "data":{
 //            }
 //          },
 //          "columns": [
 //            { "data": "name" },  
 //            { "data": "email" },  
 //            { "data": "datetime" },
 //            { "data": "ip_address" }         
 //          ],
 //          "scrollX": false,
 //          "ordering": false,
 //          "processing": true,
 //          "paging": false,
	// });
</script>
@endsection