@extends('template.main_sneat')
@section('tittle')
	Presence Shifting
@endsection
@section('pageName')
  Presence Shifting
@endsection
@section('head_css')
	<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
	<!-- <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.5/fullcalendar.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<link rel="preload" media="print" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.5/fullcalendar.print.css" as="style" onload="this.onload=null;this.rel='stylesheet'"> -->
	<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
	<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmSAQhPWId5Nd6QxE8To4ADjM2a6n0BrqQdisZ/RPUlm0YycDzvNL1HHAh1nKZqI0kSbif+5upQ==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
	<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
	<!-- <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.17/css/AdminLTE.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'"> -->
	<style>
		.swal2-margin {
			margin: .3125em;
		}
		.loader {
			border: 16px solid #f3f3f3;
			border-radius: 50%;
			border-top: 16px solid #3498db;
			width: 120px;
			height: 120px;
			-webkit-animation: spin 2s linear infinite;
			animation: spin 2s linear infinite;
			margin: auto;	
			position: absolute;
			top:0;
			bottom: 0;
			left: 0;
			right: 0;
		}

		.libur, .Libur, .cuti, .Cuti {
			background-color: #dd4b39 !important;
			border-color: #dd4b39 !important;
			color: #fff !important;
		}

		.Off-Site {
			background-color: #b5bbc8 !important;
			border-color: #b5bbc8 !important;
			color: black !important;
		}

		.On-Site {
			background-color: #f39c12 !important;
			border-color: #f39c12 !important;
			color: #fff !important;
		}

		.Helpdesk, .ho, .HO {
			background-color: #ca195a !important;
			border-color: #ca195a !important;
			color: #fff !important;
		}

		.ho, .HO {
			background-color: #605ca8 !important;
			border-color: #605ca8 !important;
			color: #fff !important;
		}

		.sore, .Sore {
			background-color: #f39c12 !important;
			border-color: #f39c12 !important;
			color: #fff !important;
		}

		.malam, .Malam {
			background-color: #0073b7 !important;
			border-color: #0073b7 !important;
			color: #fff !important;
		}

		.custom, .Custom {
			background-color: #b5bbc8 !important;
			border-color: #b5bbc8 !important;
			color: #000 !important;
		}

		.pagi, .Pagi {
			background-color: #00a65a !important;
			border-color: #00a65a !important;
			color: #fff !important;
		}

		@-webkit-keyframes spin {
			0% { -webkit-transform: rotate(0deg); }
			100% { -webkit-transform: rotate(360deg); }
		}

		@keyframes spin {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(360deg); }
		}

		.cover {
			position: fixed;
			top: 0;
			left: 0;
			background: rgba(0,0,0,0.6);
			z-index: 5000;
			width: 100%;
			height: 100%;
			display: none;
		}

		.fc-time{
		   display : none;
		}

		td.fc-day.fc-past {
			background-color: #EEEEEE;
		}
		td.fc-day.fc-today {
			background-color: #ffeaa7;
		}

		.display-none{
			display: none;
		}

		.display-block{
			display: block;
		}

		.padding-10{
			padding: 10px;
		}

		/* The switch - the card around the slider */
		.switch {
			position: relative;
			display: inline-block;
			width: 40px;
			height: 22px;
		}

		/* Hide default HTML checkbox */
		.switch input {
			opacity: 0;
			width: 0;
			height: 0;
		}

		/* The slider */
		.slider {
			position: absolute;
			cursor: pointer;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-color: #ccc;
			-webkit-transition: .4s;
			transition: .4s;
		}

		.slider:before {
			position: absolute;
			content: "";
			height: 16px;
			width: 16px;
			left: 4px;
			bottom: 3px;
			background-color: white;
			-webkit-transition: .4s;
			transition: .4s;
		}

		input:checked + .slider {
			background-color: #2196F3;
		}

		input:focus + .slider {
			card-shadow: 0 0 1px #2196F3;
		}

		input:checked + .slider:before {
			-webkit-transform: translateX(16px);
			-ms-transform: translateX(16px);
			transform: translateX(16px);
		}

		/* Rounded sliders */
		.slider.round {
			border-radius: 34px;
		}

		.slider.round:before {
			border-radius: 50%;
		}

        .external-event {
		  padding: 5px 10px;
		  font-weight: bold;
		  margin-bottom: 4px;
		  box-shadow: 0 1px 1px rgba(0,0,0,0.1);
		  text-shadow: 0 1px 1px rgba(0,0,0,0.1);
		  border-radius: 3px;
		  cursor: move;
		}

		.bg-green{
			color: white;
			background-color: #00a65a !important;
		}

		.bg-orange{
			color: white;
			background-color: #FF851B !important;
		}

		.bg-blue{
			color: white;
			background-color: #0073b7 !important;
		}

		.bg-red{
			color: white;
			background-color: #dd4b39 !important;
		}

		.bg-purple{
			color: white;
			background-color: #605ca8 !important;
		}

		.bg-gray-active{
			color: #000;
  			background-color: #b5bbc8 !important;
		}

		.form-group{
			margin-bottom: 15px;
		}

		.pull-right{
			float: right;
		}

		.list-group-item:hover{
			color: #444;
  			background: #f7f7f7;
		}
	</style>
@endsection

@section('content')
	<!-- Content Header bisa di isi dengan Title Menu dan breadcrumb -->
	<div class="container-xxl flex-grow-1 container-p-y">
		<section class="content-header">
			<a href="#" class="text-danger" data-bs-toggle="modal" data-bs-target="#modal-addusershifting" id="buttonAddUserShifting" style="display:none">
				<i class="bx bx-plus"></i> Modify User Shifting
			</a>
			<a href="#" class="text-success" data-bs-toggle="modal" data-bs-target="#modal-settingOption" id="buttonEditShiftingOption" style="display:none">
				<i class="bx bx-plus"></i> Modify Shifting Option
			</a>
			<a href="#" class="text-warning" data-bs-toggle="modal" data-bs-target="#modal-addProject" id="buttonAddProject" style="display:none">
				<i class="bx bx-plus"></i> Add Project
			</a>		
			<br id="newLineModify" style="display:none">
		</section>

		<section class="content">
			<div class="row mt-4">
				<section class="col-lg-3 col-xs-12" id="panel_simple">
					<div class="card mb-4">
						<div class="card-header">
							<h6 class="card-title" id="indicatorMonth">Shifting Users on {{date('F')}}</h6>
						</div>
						<div class="card-body" id="listProject">
							<ul class="list-group" id="listProjectContent">
								<li class="list-group-item">
									<a href="#" onclick="showLog()">Log Activity</a>
								</li>
								<li class="list-group-item">
									<a href="#" onclick="showReporting()">Reporting</a>
								</li>
							</ul>
						</div>
						<div class="card-body" id="listName" style="display: none;">
							<p id="name"></p>
							<ul class="list-group" id="ulUser"></ul>
							<br>
							<button class="btn btn-sm btn-outline-secondary" id="buttonBack">Back</button>
						</div>

						<div class="card-body" id="external" style="display: none;">
							<p id="name"></p>
							<div id="external-events">
								<p id="name2"></p>
								<input type="hidden" id="nickname">
								<!-- <input id="nickname"> -->
								<br id="external-event-br">
								<br>
								<button class="btn btn-sm btn-outline-secondary" id="buttonBack2">
									Back
								</button>
							</div>
						</div>
					</div>
					<div class="card bg-label-danger" id="deletePlace" style="display: none;">
						<div class="card-body">Drop here to delete</div>
					</div>
				</section>

				<section class="col-lg-9 col-xs-12" id="panel_simple2">
					
					<div class="card card-default">
						<div class="card-body no-padding">
							<div id="calendar"></div>
							<div id="log-activity" class="display-none table-responsive padding-10">
								<table id="table-log" class="table DataTable table-stripped">
									<thead>
										<tr>
											<th>No</th>
											<th>Activity</th>
											<th>Date/Time</th>
											<th>Changed by</th>
										</tr>
									</thead>
									<tbody id="log-content">
									</tbody>
								</table>
							</div>
							<div id="reporting" class="display-none table-responsive padding-10">
								<h2>Reporting</h2>
								<label>Select Year</label>
								<select id="yearReport" class="form-control" style="width: 200px;">
									<option>Chose One</option>
									<option value="2020">2020</option>
									<option value="2021">2021</option>
									<option value="2022">2022</option>
									<option value="2023">2023</option>
									<option value="2024">2024</option>
								</select>
								<br>
								<label>Select Month</label>
								<select id="monthReport" class="form-control" style="width: 200px;">
									<option>Chose One</option>
									<option value="01">Jan</option>
									<option value="02">Feb</option>
									<option value="03">Mar</option>
									<option value="04">Apr</option>
									<option value="05">Mei</option>
									<option value="06">Jun</option>
									<option value="07">Jul</option>
									<option value="08">Aug</option>
									<option value="09">Sep</option>
									<option value="10">Oct</option>
									<option value="11">Nov</option>
									<option value="12">Des</option>
								</select>
								<br>
								<button type="button" class="btn btn-sm btn-secondary" id="daterange-btn">
									<i class="bx bx-calendar"></i> Date range for Latest Update
									<span>
										<i class="bx bx-caret-down"></i>
									</span>
								</button>
								<br>
								<br>
								<button type="button" class="btn btn-sm btn-info" id="downloadReportBtn">
									<i class="bx bx-download"></i> Download
								</button>
							</div>
						</div>
					</div>	
				</section>			
			</div>	
		</section>	
	</div>

	<div class="modal fade" id="modal-addusershifting" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title">Modify User Shifting</h6>
				</div>
				<form method="POST" action="{{url('presence/shifting/modifyUserShifting')}}" enctype="multipart/form-data">
				<!-- <form method="POST" action="{{url('testaddUserShifting')}}" enctype="multipart/form-data"> -->
					@csrf
					<div class="modal-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Users Name</label>
									<select class="form-control select2" name="id_user" id="listUsers" style="width: 100%" >
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Project Name</label>
										<select class="form-control select2" name="on_project" id="listProjectForUser" style="width: 100%" >
										</select>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-secondary pull-left" data-bs-dismiss="modal">Close</button>						
						<button type="submit" class="btn btn-sm btn-primary">Modify user</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-settingOption" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title">Modify Shifting Option</h6>
				</div>
				<div class="modal-body" id="modal-settingOption-body">
					<?php
						$inc = 0;
						$incBody = 0;
					?>
					@foreach($shiftingOptions as $shiftingOptionKey => $shiftingOptionValues)
					<div class="row">
						<div class="col-md-12">
							<div class="card card-primary collapsed-box mb-4">
								<div class="card-header with-border" style="display:flex;justify-content: space-between;">
									<h6 class="card-title">{{$shiftingOptionKey}}</h6>
									<div class="card-tools pull-right">
										<button type="button" class="btn btn-sm" onclick="editShifting({{$shiftingOptionValues[0]['id_project']}})">
											<i class="bx bx-cog"></i>
										</button>
										<button type="button" class="btn btn-sm" data-bs-toggle="collapse" data-bs-target="#accordion{{$inc++}}">
											<i class="bx bx-plus"></i>
										</button>
									</div>
								</div>
								<div class="card-body collapse" id="accordion{{$incBody++}}">
									<form class="form-horizontal">
										<div class="card-body">
											@foreach($shiftingOptionValues as $shiftingOptionValue)
											<div class="row form-group">
												<label class="col-sm-3 control-label label-input-{{$shiftingOptionValue['id_project']}}" style="text-align:center;align-content: center;">
													<small class="badge bg-{{$shiftingOptionValue['class_shifting']}}" style="font-size: 100%;">{{$shiftingOptionValue["name_option"]}}</small>
												</label>

												<div class="col-sm-3 div-input-{{$shiftingOptionValue['id_project']}}" style="display: none">
													<input type="text" class="form-control input-{{$shiftingOptionValue['id_project']}}" value="{{$shiftingOptionValue['name_option']}}" placeholder="label">
												</div>

												<div class="col-sm-3">
													<input type="text" class="form-control checkin-input-{{$shiftingOptionValue['id_project']}} option-{{$shiftingOptionValue['id']}}" value="{{$shiftingOptionValue['start_shifting']}}" placeholder="Start">
												</div>
												<div class="col-sm-3">
													<input type="text" class="form-control checkout-input-{{$shiftingOptionValue['id_project']}} option-{{$shiftingOptionValue['id']}}" value="{{$shiftingOptionValue['end_shifting']}}" placeholder="End">
												</div>

												<div class="col-sm-3 text-center" style="align-content: center;">
													<label class="switch">
														<input class="featureItemCheck checkbox-{{$shiftingOptionValue['id_project']}} option-{{$shiftingOptionValue['id']}}" type="checkbox" {{ $shiftingOptionValue['status'] == 'ACTIVE' ? 'checked' : '' }}>
														<span class="slider round"></span>
													</label>
												</div>
											</div>
											@endforeach
											<div class="row form-group new-form-{{$shiftingOptionValues[0]['id_project']}}" style="display:none">
												<div class="col-sm-3 div-input-new-{{$shiftingOptionValues[0]['id_project']}}">
													<input type="text" class="form-control input-new-{{$shiftingOptionValues[0]['id_project']}}" placeholder="Input New Option Here">
												</div>

												<div class="col-sm-3">
													<input type="text" class="form-control checkin-input-new-{{$shiftingOptionValues[0]['id_project']}} option-new-{{$shiftingOptionValues[0]['id_project']}}" placeholder="Start">
												</div>
												<div class="col-sm-3">
													<input type="text" class="form-control checkout-input-new-{{$shiftingOptionValues[0]['id_project']}} option-new-{{$shiftingOptionValues[0]['id_project']}}" placeholder="End">
												</div>

												<div class="col-sm-3 text-center">
													<label class="switch">
														<input class="featureItemCheck checkbox-new-{{$shiftingOptionValues[0]['id_project']}} option-new-{{$shiftingOptionValues[0]['id_project']}}" type="checkbox" {{ $shiftingOptionValue['status'] == 'ACTIVE' ? 'checked' : '' }}>
														<span class="slider round"></span>
													</label>
												</div>
											</div>
										</div>
										<div class="card-footer">
											<button type="button" class="btn btn-sm btn-info pull-right" onclick="saveChangeShiftingOption({{$shiftingOptionValue['id_project']}})">Save Change</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary pull-left" data-bs-dismiss="modal">Close</button>						
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-addProject" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title">Add Project</h6>
				</div>
				<div class="modal-body" id="modal-settingOption-body">
					<form>
						<div class="form-group">
							<label for="exampleInputEmail1">Name Project</label>
							<input type="email" class="form-control" id="addNameProject" placeholder="ex : BPJS Kesehatan">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Location</label>
							<select class="form-control select2" style="width: 100%;" id="addLocationProjects"></select>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-success pull-right" data-bs-dismiss="modal" onclick="saveAddProject()">Save</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scriptImport')
<!-- Script yang import dari CDN ato Local ada di sini -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js" integrity="sha512-o0rWIsZigOfRAgBxl4puyd0t6YKzeAw9em/29Ag7lhCQfaaua/mDwnpE2PVzwqJ08N7/wqrgdjc2E0mwdSY2Tg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.17/js/adminlte.min.js"></script> -->
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		var accesable = @json($feature_item);
	    accesable.forEach(function(item,index){
	      $("#" + item).show()
	      $("." + item).show()
	    })
	})

	// Script yang import dari CDN ato Local ada di sini
	var globalIdUser = 0;
	var globalProject = 0;

	var globalIdUser = 0;
	var globalProject = 0;

	swalWithCustomClass = Swal.mixin({
		customClass: {
			confirmButton: 'btn btn-sm btn-flat btn-primary swal2-margin',
			cancelButton: 'btn btn-sm btn-flat btn-danger swal2-margin',
			denyButton: 'btn btn-sm btn-flat btn-danger swal2-margin',
			popup: 'border-radius-0',
		},
		buttonsStyling: false,
	})

	$.ajax({
		type:"GET",
		url:"{{url('presence/setting/showLocationAll')}}",
		beforeSend:function(){
			$("#addLocationProjects").empty()
		},
		success:function(result){
			$("#addLocationProjects").select2({
				placeholder:" Select location",
		        // multiple:true,
		        data:result.data,
		        dropdownParent:$("#modal-addProject")
		    })

		}
	})

	function saveAddProject(){
		$.ajax({
			url:"{{url('presence/shifting/addProject')}}",
			data:{
				name:$("#addNameProject").val(),
				location:$("#addLocationProjects").val()
			},
			beforeSend: function(){
				Swal.fire({
					title: 'Please Wait..!',
					text: "It's sending..",
					allowOutsideClick: false,
					allowEscapeKey: false,
					allowEnterKey: false,
					customClass: {
						popup: 'border-radius-0',
					},
					didOpen: () => {
						Swal.showLoading()
					}
				})
			},
			success: function(result){
			//kasih alert success dan auto refresh samping kiri
				Swal.hideLoading()
				swalWithCustomClass.fire({
					title: 'Success!',
					text: "Shifting Project Added",
					icon: 'success',
					confirmButtonText: 'Reload',
				}).then((result) => {
					initiateGetProject()
				})	
			}
		})
	}


	initiateGetProject()
	function initiateGetProject(argument) {
		$.ajax({
			url:"{{url('presence/shifting/getProject')}}",
			success: function(result){
				$("#listProjectContent").empty("")
				result.forEach( function ( data, key ) {
					var project =  "'" + data.project_name + "','" + data.id + "'"
					$("#listProjectForUser").prepend('<option value="' + data.id + '">' + data.project_name + '</option>')
					$("#listProjectContent").prepend('<li class="list-group-item"><a href="#" onclick="showProject(' + project + ')">' + data.project_name + '</a></li>')
				})
				$("#listProjectForUser").append('<option value="0">--Set For Not Shifting--</option>')
			}
		})
	}
	
	$.ajax({
		url:"{{url('presence/shifting/getOption')}}",
		success: function(result){
			result.forEach( function ( data, key ) {
				$("#external-event-br").after('<div style="display: none; cursor: default;" class="external-event bg-' + data.class_shifting + ' project-' + data.id_project + '">' + data.name_option + ' <span class="pull-right">' + data.start_shifting + ' - ' + data.end_shifting + '</span></div>')
			})

			$('#external-events div.external-event').each(function () {
				var str = $(this).text();
				var shift = str.substr(0,str.indexOf(" "));
				if (shift == "Off-Site" || shift == "On-Site" ) {
					var start = str.split(" ")[1];
					var end = str.split(" ")[3];
				}else{
					var strip = str.indexOf("-");
					var start1 = strip - 6;
					var end1 = strip + 2;
					var start = str.substr(start1,5);
					var end = str.substr(end1,5);
				}
				
				if(shift == "Libur"){
					var eventObject = {
						title: $.trim($(this).text()), 
						startShift: "00:00",
						endShift: "23:59",
						Shift: shift,
					};
				} else {
					var eventObject = {
						title: $.trim($(this).text()), 
						startShift: start,
						endShift: end,
						Shift: shift,
					};
				}
				$(this).data('eventObject', eventObject);

				$(this).draggable({
					zIndex: 1070,
					revert: true, 
					revertDuration: 0 
				});
			});

		}
	})

	$.ajax({
		url:"{{url('presence/shifting/getUsers')}}",
		success: function(result){
			// $("#listUsers").append('<option value="12341234124">sdafadsfa</option>')
			result.forEach( function ( data, key ) {
				$("#listUsers").append('<option value="' + data.nik + '">' + data.name + '</option>')
			})

			$("#listUsers").select2({
				dropdownParent:$("#modal-addusershifting")
			})
		}
	})

	$.ajax({
		url:"{{url('presence/shifting/getOptionGrouped')}}",
		success:function(result){
			for(var key in result){
				result[key].forEach( function ( data, key ) {

				})
			}
		}
	})

	// function showProject(name,idProject){
	// 	$("#listProject").fadeOut(function (){
	// 		$("#listName").fadeIn();
	// 		$("#name").text("for " + name);
	// 		$("#calendar").removeClass('display-none').addClass('display-block');
	// 		$("#log-activity").removeClass('display-block').addClass('display-none');
	// 		$("#table-log").dataTable().fnDestroy();
	// 		$("#calendar").fullCalendar('removeEventSources');
	// 		$("#calendar").fullCalendar('addEventSource', "{{url('schedule/getThisProject')}}?project=" + idProject + "&month=" + moment($("#indicatorMonth").text().split(" ")[3],"MMMM").format('MM'));
	// 		$("." + idProject).show();
	// 		globalProject = idProject;
	// 		$("#buttonBack").attr("onclick","backListProject(" + idProject + ")");
	// 	});
	// };

	var shift_user = [], shift_time = [], shift_date = [];
	var i = 0;
	$('#calendar').fullCalendar({
		header: {
			left: '',
			center: 'title',
		},
		
		editable: false,
		droppable: false,
		events: "{{url('presence/shifting/getThisMonth')}}",
			
		drop: function (date, allDay) { 

			var originalEventObject = $(this).data('eventObject');
			var name3 = $("#nickname").val();
			var copiedEventObject = $.extend({}, originalEventObject);

			copiedEventObject.start = date;
			var waktu = date._d;
			waktu = new Date(waktu);

			var day = moment(waktu).toISOString(true);
			var startShift2 = moment(waktu).format('YYYY-MM-DD') + "T" + originalEventObject.startShift + ":00.000Z";
			var endShift2 = moment(waktu).format('YYYY-MM-DD') + "T" + originalEventObject.endShift + ":00.000Z";
			var start_before = moment(waktu).format('YYYY-MM-DD') + " " + originalEventObject.startShift + ":00";
			var end_before = moment(waktu).format('YYYY-MM-DD') + " " + originalEventObject.endShift + ":00";

			var ketemu = 0;

			var date = $('#calendar').fullCalendar('getCalendar').view
			var start = date.start.format("YYYY-MM-DD")
			var end = date.end.format("YYYY-MM-DD")

			$.ajax({
				type:"GET",
				dataType:"json",
				url:"{{url('presence/shifting/getThisMonth')}}?start=" + start + "&end=" + end,
				success: function(result2){
					for (var i = 0; i < result2.length; i++) {
						if (startShift2 == result2[i].start) {
							var str = result2[i].title;
							var str2 = result2[i].start;
							var shift = str.substr(0,str.indexOf(" "));
							
							if(shift == originalEventObject.Shift){
								if(name3.substr(1,name3.length - 1) == str.substr(str.indexOf(" ") + 3, str.length)){
									ketemu = 1;
								}
							} 
						}
					};

					if(ketemu == 1){
						alert("tanggal sama");
					} else {
						var idEvent = 0;


						$.ajax({
							type: "GET",
							url: "{{url('presence/shifting/createSchedule')}}",
							data:{
								title: originalEventObject.Shift +" - " +  name3,
								name:name3,
								start: startShift2,
								end: endShift2,
								start_before:start_before,
								end_before:end_before,
								shift: originalEventObject.Shift,
								id_project: globalProject,
								nik:globalIdUser

							},
							success: function(result){
								idEvent = result;
								copiedEventObject.id = idEvent;
								refresh_calendar();
							},
						});
					}
				},
			});
		},

		eventDrop: function(event, delta, revertFunc) {
			alert(event.title + " can't move!");
			revertFunc();
		},

		eventDragStop: function(event,jsEvent) {
			var trashEl = $('#deletePlace');
			var ofs = trashEl.offset();

			var x1 = ofs.left;
			var x2 = ofs.left + trashEl.outerWidth(true);
			var y1 = ofs.top;
			var y2 = ofs.top + trashEl.outerHeight(true);

			if (jsEvent.pageX >= x1 && jsEvent.pageX<= x2 &&
				jsEvent.pageY >= y1 && jsEvent.pageY <= y2) {
				if (confirm("Are you sure to delete this events?")) {
					$.ajax({
						type: "GET",
						url: "{{url('presence/shifting/deleteSchedule')}}",
						data:{
							id:event.id
						},
						success: function(result){
							$('#calendar').fullCalendar('removeEvents', event.id);
						},
					});
				}
			}
		},

		viewRender: function (view, element) {
			$("#indicatorMonth").text("Shifting Users on " + moment(view.intervalStart).format("MMMM"));
			
			$.ajax({
				type: "GET",
				// url: "{{url('schedule/changeMonth')}}",
				url: "{{url('presence/shifting/getSummaryThisMonth')}}",
				data: {
					// start:moment(view.intervalStart).format("YYYY-MM-DD"),
					start:moment(view.intervalStart).startOf('month').format('YYYY-MM-DD'),
					// end:moment(view.intervalEnd).format("YYYY-MM-DD")
					end:moment(view.intervalStart).endOf('month').format('YYYY-MM-DD')
				},
				beforeSend:function(){
					$("#calendar").fullCalendar('removeEventSources');
				},
				success: function(result){
					$("#ulUser").empty();
					var append = "";
					result.forEach(function(item,index){
						if (item.nickname) {
							item.nickname = item.nickname.split(" ")[1]
						} 

						if (item.nickname_all) {
							item.nickname = item.nickname_all.split(" ")[0]
						}

						var showDetail = "showDetail('" + item.name + "','" + item.nickname + "','" + item.id + "','" + item.project_id + "')";
						append = append + '	<li class="' + item.project_id + ' list-group-item" style="display:none;cursor:pointer">';
						append = append + '		<a onclick="' + showDetail + '" style="display:ruby">' + item.name;
						append = append + '			<br>';
						if(item.shifting_summary !== undefined){
							item.shifting_summary.forEach(function(itemSummary,indexSummary){
								console.log(itemSummary.class_shifting + '-' + itemSummary.name_option)
								if(itemSummary.class_shifting === null){
									append = append + '			<small class="badge text-bg-primary" style="margin-right: 5px;float:right">' + itemSummary.count + ' </small>';
								} else {
									append = append + '			<small class="badge text-bg-primary' + ' " style="margin-right: 5px;float:right">' + itemSummary.count + ' </small>';
								}
							})
						}
						append = append + '		</a>';
						append = append + '	</li>';
					})
					$("#ulUser").append(append);
					$("." + globalProject).show();
				},
			});
			var date = $('#calendar').fullCalendar('getCalendar').view
			var start = date.start.format("YYYY-MM-DD")
			var end = date.end.format("YYYY-MM-DD")
			if($("#listProject").is(":visible")){
				$("#calendar").fullCalendar('addEventSource', "{{url('presence/shifting/getThisMonth')}}?start=" + start + "&end=" + end);
			}
			if($("#listName").is(":visible")){
				$("#calendar").fullCalendar('addEventSource', '{{url("presence/shifting/getThisProject")}}?project=' + globalProject + '&month=' + moment($("#indicatorMonth").text().split(" ")[3],"MMMM").format('MM'));
			} else {
				$("#calendar").fullCalendar('addEventSource', '{{url("presence/shifting/getThisUser")}}?idUser=' + globalIdUser +'&idProject=' + globalProject + "&month=" + moment($("#indicatorMonth").text().split(" ")[3],"MMMM").format('MM'));
			}
		}
	});

	function showProject(name,idProject){
		$("#listProject").fadeOut(function (){
			$("#listName").fadeIn();
			$("#name").text("for " + name);
			$("#calendar").removeClass('display-none').addClass('display-block');
			$("#log-activity").removeClass('display-block').addClass('display-none');
			$("#reporting").removeClass('display-block').addClass('display-none');
			// $("#table-log").dataTable().fnDestroy();
			$("#calendar").fullCalendar('removeEventSources');
			$("#calendar").fullCalendar('addEventSource', "{{url('presence/shifting/getThisProject')}}?project=" + idProject + "&month=" + moment($("#indicatorMonth").text().split(" ")[3],"MMMM").format('MM'));
			$("." + idProject).show();
			globalProject = idProject;
			$("#buttonBack").attr("onclick","backListProject(" + idProject + ")");
		});
	};

	function backListProject(idProject){
		$("#listName").fadeOut(function (){
			$("#calendar").fullCalendar('removeEventSources');
			var date = $('#calendar').fullCalendar('getCalendar').view
			var start = date.start.format("YYYY-MM-DD")
			var end = date.end.format("YYYY-MM-DD")
			$("#calendar").fullCalendar('addEventSource', "{{url('presence/shifting/getThisMonth')}}?start=" + start + "&end=" + end);
			$("." + idProject).attr('style','display:none!important');
			$("#listProject").fadeIn();
		});
	}

	function showDetail(name,nickname,idUser,idProject){
		$("#listName").fadeOut(function (){
			
			var external2 = ".project-" + idProject;
			$("#external").fadeIn(function(){
				$(external2).show();
			});

			$("#name2").text("for " + name);
			$("#nickname").val(nickname);
			$("#calendar").fullCalendar('removeEventSources');
			$("#calendar").fullCalendar('addEventSource', '{{url("presence/shifting/getThisUser")}}?idUser=' + idUser + '&idProject=' + globalProject + "&month=" + moment($("#indicatorMonth").text().split(" ")[3],"MMMM").format('MM'));
			globalIdUser = idUser;
			$("." + idProject).show();
			$("#buttonBack2").attr("onclick","backListDetail(" + idProject + ")")
			$("#deletePlace").show();
			$("#calendar").fullCalendar('option', {
				editable: true,
				droppable: true,
			});
		});
	}

	function backListDetail(idProject){
		$("#external").fadeOut(function (){
			$(".project-" + idProject).fadeOut();
			$("#calendar").fullCalendar('removeEventSources');
			$("#calendar").fullCalendar('addEventSource', "{{url('presence/shifting/getThisProject')}}?month=" + moment($("#indicatorMonth").text().split(" ")[3],"MMMM").format('MM'));
			$("#buttonBack").attr("onclick","backListProject(" + idProject + ")");
			globalIdUser = 0;
			$("#listName").fadeIn();
			$("#deletePlace").attr('style','display:none!important');
			$("#calendar").fullCalendar('option', {
				editable: false,
				droppable: false,
			});
		});
	}

	function refresh_calendar(){
		$("#calendar").fullCalendar('removeEventSources');
		$("#calendar").fullCalendar('addEventSource', '{{url("presence/shifting/getThisUser")}}?idUser=' + globalIdUser +'&idProject=' + globalProject + "&month=" + moment($("#indicatorMonth").text().split(" ")[3],"MMMM").format('MM'));
	}

	function saveChangeShiftingOption(id_project){

		var optionId = []
		var optionLabel = []
		var checkInValue = []
		var checkOutValue = []
		var optionStatus = []
		var optionStatusNew = []

		$(".input-" + id_project).each(function(index){
			// optionId.push($(this).attr('class').split(" option-")[1])
			optionLabel.push($(this).val())
		})
		$(".checkin-input-" + id_project).each(function(index){
			optionId.push($(this).attr('class').split(" option-")[1])
			checkInValue.push($(this).val())
		})
		$(".checkout-input-" + id_project).each(function(index){
			checkOutValue.push($(this).val())
		})

		$(".checkbox-" + id_project).each(function(index){
			if($(this).is(":checked")){
				optionStatus.push("ACTIVE")
			} else {
				optionStatus.push("NON-ACTIVE")
			}
		})

		// New Option

		if($(".checkbox-new-" + id_project).is(":checked")){
			optionStatusNew = "ACTIVE"
		} else {
			optionStatusNew = "NON-ACTIVE"
		}

		swalWithCustomClass.fire({
			title: 'Are you sure?',
			text: "To Save this shifting option change?",
			icon: 'warning',
			showCancelButton: true,
		}).then((result) => {
			$.ajax({
				type:"GET",
				url:"{{url('/presence/shifting/modifyOptionShifting')}}",
				data:{
					option_id:optionId,
					option_label:optionLabel,
					checkin_value:checkInValue,
					checkout_value:checkOutValue,
					status_value:optionStatus,

					new_label:$(".input-new-" + id_project).val(),
					new_checkin:$(".checkin-input-new-" + id_project).val(),
					new_checkout:$(".checkout-input-new-" + id_project).val(),
					new_value:optionStatusNew,
					new_id_project:id_project,
					new_class_shifting:"gray-active"
				},
				beforeSend: function(){
					Swal.fire({
						title: 'Please Wait..!',
						text: "It's sending..",
						allowOutsideClick: false,
						allowEscapeKey: false,
						allowEnterKey: false,
						customClass: {
							popup: 'border-radius-0',
						},
						didOpen: () => {
							Swal.showLoading()
						}
					})
				},
				success: function(result){
					Swal.hideLoading()
					swalWithCustomClass.fire({
						title: 'Success!',
						text: "Shifting option changed",
						icon: 'success',
						confirmButtonText: 'Reload',
					}).then((result) => {
						location.reload()
					})	
				}
			})
		})
	}

	function showLog(){
		$('#calendar').removeClass('display-block').addClass('display-none');
		$('#reporting').removeClass('display-block').addClass('display-none');
		$('#log-activity').removeClass('display-none').addClass('display-block');


		if($.fn.dataTable.isDataTable("#table-log")){
			$("#table-log").DataTable().ajax.url('{{url('presence/shifting/showLogActivity')}}').load();
		} else {
			$('#table-log').DataTable({
				"ajax": {
				    "url": "{{url('presence/shifting/showLogActivity')}}",
				    "type": "GET"
				},
				"columns": [
					{
			            render: function ( data, type, row, meta ) {
			               return  meta.row+1;
			            }
			        },
			        {
			            render: function ( data, type, row, meta ) {
			            	if (row.status == 'create') {
			            		return "Create Schedule " + row.title + "<br>[" + moment(row.start_before).format('MMMM Do YYYY, h:mm:ss a') + " - " + moment(row.end_before).format('MMMM Do YYYY, h:mm:ss a') + "]";
			            	}else if (row.status == 'update') {
			            		return  "Updated Schedule " + row.title + "<br>[" + moment(row.start_before).format('MMMM Do YYYY, h:mm:ss a')  + " - " + moment(row.end_before).format('MMMM Do YYYY, h:mm:ss a')  + "]" + "<br> menjadi <br>"+ row.className_updated + " [" + moment(row.start_updated).format('MMMM Do YYYY, h:mm:ss a')  + " - " + moment(row.end_updated).format('MMMM Do YYYY, h:mm:ss a')  + "]";
			            	}else{
			            		return  "Deleted Schedule " + row.title + "<br>[" + moment(row.start_before).format('MMMM Do YYYY, h:mm:ss a')  + " - " + moment(row.end_before).format('MMMM Do YYYY, h:mm:ss a')  + "]";
			            	}
			            }
			        },
		            { "data": "created_at" },
		            { "data": "name" },
	        	]
			});
		}
		// $("#log-activity").append(table);
	}

	function showReporting(){
		$('#calendar').removeClass('display-block').addClass('display-none');
		$('#log-activity').removeClass('display-block').addClass('display-none');
		$('#reporting').removeClass('display-none').addClass('display-block');
		// $("#log-activity").append(table);
	}

	$('#daterange-btn').daterangepicker({
		startDate: moment().subtract(29, 'days'),
		endDate: moment()
	},
	function (start, end) {
		$("#shuttle-card").prop("disabled",false)

		$('#daterange-btn btn-sm span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));

		startDay = start.format('YYYY-MM-DD');
		endDay = end.format('YYYY-MM-DD');

		$("#startDate").val(startDay)
		$("#endDate").val(endDay)

		startDate = start.format('D MMMM YYYY');
		endDate = end.format('D MMMM YYYY');

		$("#table_report").empty();
	});

	$("#downloadReportBtn").on('click',function(){
		swalWithCustomClass.fire({
			title: 'Are you sure?',
			text: "Make sure there is nothing wrong to get this report!",
			icon: "warning",
			showCancelButton: true,
			allowOutsideClick: false,
			allowEscapeKey: false,
			allowEnterKey: false,
			confirmButtonText: 'Yes',
			cancelButtonText: 'No',
			}).then((result) => {
				if (result.value){
					Swal.fire({
						title: 'Please Wait..!',
						text: "Prossesing Data Report",
						allowOutsideClick: false,
						allowEscapeKey: false,
						allowEnterKey: false,
						customClass: {
							popup: 'border-radius-0',
						},
						onOpen: () => {
							Swal.showLoading()
						}
					})

					var start = $('#daterange-btn').data('daterangepicker').startDate.format('YYYY-MM-DD 00:00:00')
					var end = $('#daterange-btn').data('daterangepicker').endDate.format('YYYY-MM-DD 23:59:59')
					var year = $("#yearReport").val()
					var month = $("#monthReport").val()
					var url = "{{url('presence/shifting/getReportShifting')}}?start=" + start + "&end=" + end + "&year=" + year + "&month=" + month

					$.ajax({
						type:"GET",
						url:url,
						data:{
							delay:3
						},
						success: function(result){
							Swal.hideLoading()
							if(result == 0){
								swalWithCustomClass.fire({
									//icon: 'error',
									title: 'Success!',
									text: "The file is unavailable",
									type: 'error',
									//confirmButtonText: '<a style="color:#fff;" href="report/' + result.slice(1) + '">Get Report</a>',
								})
							}else{
								swalWithCustomClass.fire({
									title: 'Success!',
									text: "You can get your file now",
									type: 'success',
									confirmButtonText: '<a style="color:#fff;" target="_blank" href="' + url + '">Get Report</a>',
								})
							}
						}
					})
				}
			}
		);
	})

	function editShifting(id_project){
		$(".label-input-" + id_project).toggle()
		$(".div-input-" + id_project).toggle()

		$(".new-form-" + id_project).toggle()
	}

	
</script>
@endsection