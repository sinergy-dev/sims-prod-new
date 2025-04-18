@extends('template.main_sneat')
@section('tittle')
  Presence Report
@endsection
@section('pageName')
  Presence Report
@endsection
@section('head_css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmSAQhPWId5Nd6QxE8To4ADjM2a6n0BrqQdisZ/RPUlm0YycDzvNL1HHAh1nKZqI0kSbif+5upQ==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
<link rel="preload" href="{{ asset('assets/css/jquery.transfer.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<style type="text/css">
	.transfer-double{
		width: 260px!important;
	}

	.transfer-double-content{
		padding: 9px 14px 29px 23px!important;
	}
</style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
	<section class="content">
		<div class="card">
			<div class="card-header with-border">
				<h6 class="card-title"></h6>
				<div style="text-align:right">
								<!-- 		<select class="btn bg-blue" style="width: 80px; margin-left: 10px;" id="filter_com">
			            <option value="">All</option>
			            <option value="SIP">SIP (ALL)</option>
			            <option value="SIP-MSM">SIP (MSM)</option>
			            <option value="MSP">MSP</option>
		          	</select> -->
          	<input type="hidden" id="startDate">
          	<input type="hidden" id="endDate">
				</div>
			</div>
			<div class="card-body">
				<div class="row mb-4">
					<div class="col-md-8 col-xs-12">
						<div class="form-group">
							<button type="button" class="btn btn-sm btn-secondary" id="daterange-btn">
								<i class="bx bx-calendar"></i> Date range picker
								<span>
									<i class="bx bx-caret-down"></i>
								</span>
							</button>
						</div>
					</div>
					<div class="col-md-4 d-flex">
						<div class="ms-auto">
							<button type="button" class="btn btn-sm btn-success" onclick="exportExcel('{{action('PresenceController@getExportReport')}}')">
							<i class='bx bx-download'></i> &nbspExport</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 col-xs-12">
						<div id="shuttle-card" disabled>
					    <div id="transfer3" class="transfer-demo"></div>
						</div><br>
					</div>
					<div class="col-md-9 col-xs-12">
						<div class="table-responsive">
							<table class="table table-bordered table-striped display" id="report_table" style="overflow-x:auto;">
								<thead>
									<tr>
										<th style="width: 7px;">No</th>
										<th>Name</th>
										<th>Location</th>
										<th style="width: 70px;" class="text-center">On Time</th>
										<th style="width: 50px;" class="text-center">Injury</th>
										<th style="width: 50px;" class="text-center">Late</th>
										<th style="width: 50px;" class="text-center">Absent</th>
										<th style="width: 50px;" class="text-center">All</th>
									</tr>
								</thead>
								<tbody id="table_report">
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
	<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script type="text/javascript" src="{{asset('assets/js/jquery.transfer.js')}}"></script>
@endsection
@section('script')
	<script type="text/javascript">
		var selectedUser = []
		var filterUser = []
		var type_date = ""
		var startDay,endDay
		var selectDate = false
		var selectPerson = false

		$(document).ready(function(){  
			$.ajax({
				type:"GET",
				url:"{{url('/presence/report/getDataReportPresence')}}",
				beforeSend:function(){
  				$("#table_report").empty("")
  				$("#table_report").append("<tr><td colspan='8'> <p style='text-align:center'>Loading . . .</p></td></tr>")
				},
				success: function(result){
  				$("#table_report").empty("")

					$(".card-title").text("This Period " + result.range)
					var append = ""
					var no = 1
					$.each(result.data,function(index,data){
						append = append + "<tr>"
						append = append + "	<td>" + no++ + "</td>"
						var name = data.name.split(" ")
						var finalName = []
						name.forEach(function(item,index){
						  finalName.push(item.charAt(0).toUpperCase() + item.slice(1).toLowerCase())
						})

						append = append + "	<td>" + finalName.toString().replaceAll(","," ") + "</td>"
						append = append + "	<td>" + data.where + "</td>"
						append = append + "	<td class='text-center'> <span class='badge text-bg-success'>" + data.ontime + "</span> </td>"
						append = append + "	<td class='text-center'> <span class='badge text-bg-warning'>" + data.injury + "</span> </td>"
						append = append + "	<td class='text-center'> <span class='badge text-bg-danger'>" + data.late + "</span> </td>"
						var absen = 0
						if (data.absen == undefined) {
							absen = absen
						}else{
							absen = data.absen
						}
						append = append + "	<td class='text-center'> <span class='badge text-bg-secondary'>" + absen + "</span> </td>"
						append = append + "	<td class='text-center'> <span class='badge text-bg-primary'>" + data.all + "</span> </td>"
						append = append + "</tr>"
					})

					if (result.data.length == 0) {
						$("#table_report").append("<tr><td colspan='8'> <p style='text-align:center'>Data is empty!</p></td></tr>")
					}else{
						$("#table_report").append(append)
					}
				}
			})
		})

		$('#daterange-btn').daterangepicker({
			ranges: {
				'This Period HRD': [moment("16 " + moment().subtract(1,'months').format("MM YYYY"),"DD MM YYYY"), moment("15 " + moment().format("MM YYYY"),"DD MM YYYY")],
				'This Period MSM': [moment("26 " + moment().subtract(1,'months').format("MM YYYY"),"DD MM YYYY"), moment("25 " + moment().format("MM YYYY"),"DD MM YYYY")],

			}
		},
		function (start, end) {
			// if ($('#daterange-btn').data('daterangepicker').chosenLabel == 'This Period HRD') {
			// 	type = "HRD"
			// }else if ($('#daterange-btn').data('daterangepicker').chosenLabel == 'This Period MSM') {
			// 	type = 'MSM'
			// }else {
			// 	type = ''
			// }
			$("#shuttle-card").prop("disabled",false)

			$('#daterange-btn span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));

			startDay = start.format('YYYY-MM-DD');
			endDay = end.format('YYYY-MM-DD');

			$("#startDate").val(startDay)
			$("#endDate").val(endDay)

			startDate = start.format('D MMMM YYYY');
			endDate = end.format('D MMMM YYYY');

			table_presence()
		});

		$(document).on('change', '.validationCheck', function() {
		    if(!$(this).is(':checked')) {
		    	$(this).closest('tr').find("input[type=text]").prop('disabled',false)
		    } else {
		    	$(this).closest('tr').find("input[type=text]").prop('disabled',true)
		    }
		});

		function exportExcel(url){
			if($("#startDate").val() != "" && $("#endDate") != ""){
				url = url + "?startDate=" + $("#startDate").val() + "&endDate=" + $("#endDate").val() + selectedUser
			}

	    	window.location = url;
	  }

	  $.ajax({
      url:"{{url('/presence/getUser')}}",
      type:"GET",
      beforeSend:function() {
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
      	var settings = {
	        "groupDataArray": result,
	        "groupItemName": "text",
	        "groupArrayName": "children",
	        "itemName": "text",
	        "valueName": "nik",
	        "callable": function (items) {
	        	selectedUser = []
	        	filterUser = []
	        	$.each(items,function(key,value){
	        			if (!filterUser.includes(value.nik)) {
	            		filterUser.push(value.nik)
	            		selectedUser = selectedUser + '&nik[]=' + value.nik
	        			}
	        	})

	        	// var string = JSON.stringify(selectedUser)
	        	// string.replace (/"/g,'')
						$("#table_report").empty();
	        	table_presence()
	        }
	    };

				$("#transfer3").transfer(settings);
				$(".btn-select-arrow:first").find("i").addClass("bx bx-chevron-up")
	  		$(".btn-select-arrow:last").find("i").addClass("bx bx-chevron-down") 
				// table_presence(selectDate = true,selectPerson = true)
  		}
		})

	  function table_presence()
	  {
			$.ajax({
				type:"GET",
				url:"{{url('/presence/report/getFilterReport')}}",
				data: {
					'start' : startDay,
					'end' : endDay,
					'nik' : filterUser,
				},
				beforeSend:function(){
  				$("#table_report").empty("")
  				$("#table_report").append("<tr><td colspan='8'> <p style='text-align:center'>Loading . . .</p></td></tr>")
				},
				success: function(result){
					$("#table_report").empty("")

					$(".card-title").text("This period " + result.range)
					var append = ""
					var no = 1
					$.each(result.data,function(index,value){
						append = append + "<tr>"
						append = append + "	<td>" + no++ + "</td>"

						var name = value.name.split(" ")
						var finalName = []
						name.forEach(function(item,index){
						  finalName.push(item.charAt(0).toUpperCase() + item.slice(1).toLowerCase())
						})

						append = append + "	<td>" + finalName.toString().replaceAll(","," ") + "</td>"
						append = append + "	<td>" + value.where + "</td>"
						append = append + "	<td class='text-center'> <span class='badge text-bg-success'>" + value.ontime + "</span> </td>"
						append = append + "	<td class='text-center'> <span class='badge text-bg-warning'>" + value.injury + "</span> </td>"
						append = append + "	<td class='text-center'> <span class='badge text-bg-danger'>" + value.late + "</span> </td>"
						var absen = 0
						if (value.absen == undefined) {
							absen = absen
						}else{
							absen = value.absen
						}
						append = append + "	<td class='text-center'> <span class='badge text-bg-secondary'>" + absen + "</span> </td>"
						append = append + "	<td class='text-center'> <span class='badge text-bg-primary'>" + value.all + "</span> </td>"
						append = append + "</tr>"
					})

					if (result.data.length == 0) {
						$("#table_report").append("<tr><td colspan='8'> <p style='text-align:center'>Data is empty!</p></td></tr>")
					}else{
						$("#table_report").append(append)
					}
				}
			})	
	  }
	</script>
@endsection