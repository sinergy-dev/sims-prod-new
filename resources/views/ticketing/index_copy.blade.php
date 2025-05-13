@extends('template.main_sneat')
@section('tittle')
Ticketing
@endsection
@section('pageName')
Ticketing
@endsection
@section('head_css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css')}}" />
<link rel="preload" href="{{asset('assets/vendor/css/jquery.emailinput.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}"/>
<style type="text/css">
	.table2 > tbody > tr > th, .table2 > tbody > tr > td {
		border-color: #141414;border: 1px solid;padding: 3px;}

	.vertical-alignment-helper {
		display:table;
		height: 100%;
		width: 100%;
		pointer-events:none;
	}
	 {
		display: table-cell;
		vertical-align: middle;
		pointer-events:none;
	}
/*	.modal-content {
		width:inherit;
		max-width:inherit; 
		height:inherit;
		margin: 0 auto;
		pointer-events: all;
	}*/

	.table > tbody > tr > td {
		vertical-align: middle;
	}

	.dataTables_filter {display: none;}
	.border-radius-0 {
		border-radius: 0px !important;
	}
	.swal2-margin {
		margin: .3125em;
	}

	.label {
		border-radius: 0px !important;
	}

	.needs-validation .select2-selection {
		border-color: rgb(185, 74, 72) !important;
	}
	
	body { padding-right: 0 !important }
	.button-edit-periperal {
	 	/*display: none;*/
	 }
	.itemPeriperal:hover {
		background-color: #eaeaea;
		cursor: pointer;
		display: block;
	}
	.severityCounter:hover {
		cursor: pointer;
	} 

	.container {
	  display: block;
	  position: relative;
	  padding-left: 35px;
	  margin-bottom: 12px;
	  cursor: pointer;
	  font-size: 14px;
	  -webkit-user-select: none;
	  -moz-user-select: none;
	  -ms-user-select: none;
	  user-select: none;
	}

	/* Hide the browser's default checkbox */
	.container input {
	  position: absolute;
	  opacity: 0;
	  cursor: pointer;
	  height: 0;
	  width: 0;
	}

	/* Create a custom checkbox */
	.checkmark {
	  position: absolute;
	  top: 0;
	  left: 0;
	  height: 25px;
	  width: 25px;
	  background-color: #eee;
	}

	/* On mouse-over, add a grey background color */
	.container:hover input ~ .checkmark {
	  background-color: #ccc;
	}

	/* When the checkbox is checked, add a blue background */
	.container input:checked ~ .checkmark {
	  background-color: #2196F3;
	}

	/* Create the checkmark/indicator (hidden when not checked) */
	.checkmark:after {
	  content: "";
	  position: absolute;
	  display: none;
	}

	/* Show the checkmark when checked */
	.container input:checked ~ .checkmark:after {
	  display: block;
	}

	/* Style the checkmark/indicator */
	.container .checkmark:after {
	  left: 9px;
	  top: 5px;
	  width: 5px;
	  height: 10px;
	  border: solid white;
	  border-width: 0 3px 3px 0;
	  -webkit-transform: rotate(45deg);
	  -ms-transform: rotate(45deg);
	  transform: rotate(45deg);
	}

	.bg-custom-yellow {
		background-color: #f1c40f;color: #fff !important;
	}

	.bg-orange{
		background-color: #f1c40f;color: #fff !important;
	}

	/* For WebKit-based browsers (Chrome, Safari) */
    .boxDivSite::-webkit-scrollbar {
      width: 2px; /* Width of the scrollbar */
    }

    /* For Firefox */
    .boxDivSite {
      scrollbar-width: thin; /* Thin scrollbar for Firefox */
    }

    /* Track (background of the scrollbar) */
    .boxDivSite::-webkit-scrollbar-track {
      background: #f1f1f1;
    }

    /* Handle (thumb of the scrollbar) */
    .boxDivSite::-webkit-scrollbar-thumb {
      background: #888;
      border-radius: 3px;
    }

	/*.columnCheck {
		margin: 0 10px 0 5px;
	}*/
	.widthBoxPID{
		width: 50%;
	}

	.container_pid{
		display: flex;
	}

	@media screen and (max-width: 500px) { 
      .widthBoxPID { 
          width: 100%; 
      } 

      .container_pid{
      	display: block;
      }
  }

  .widthBoxPID100{
  	width: 100%;
  }

  .resetDate{
  	color: black;
  }

  table#tb_sla_resolution_time,#tb_sla_response_time.dataTable td {
	  font-size: 12px;
	}

	.dataTables_processing {
	  background: rgba(0, 0, 0, 0.5); 
	  color: white;                   
	  font-size: 18px;                
	  padding: 10px;                  
	  border-radius: 5px;             
	  z-index: 10000;                 
	}

	.card {
		width: 100%; 
		border: 1px solid #e0e0e0; 
		border-radius: 0.375rem; 
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
		margin-bottom: 1.5rem; 
		background-color: #fff;
		overflow: hidden; 
	}

	.card-header {
		padding: 0.75rem 1.25rem; 
		background-color: #f7f7f9; 
		border-bottom: 1px solid #e0e0e0; 
		border-top-left-radius: 0.375rem; 
		border-top-right-radius: 0.375rem;
		font-size: 1.25rem; 
		font-weight: 500; 
		white-space: nowrap; 
		text-overflow: ellipsis; 
		overflow: hidden; 
	}

	.card-body {
		padding: 1.25rem; 
		font-size: 1rem; 
		color: #212529; 
		overflow: hidden; 
	}

	.card-footer {
		padding: 0.75rem 1.25rem; 
		background-color: #f7f7f9; 
		border-top: 1px solid #e0e0e0;
		border-bottom-left-radius: 0.375rem; 
		border-bottom-right-radius: 0.375rem;
		text-align: right; 
		overflow: hidden; 
	}

	.control-label{
		padding-top: 7px;
    margin-bottom: 0;
    text-align: right;
	}

	.form-group{
		margin-bottom: 15px;
	}

	.swal2-container {
	  z-index: 99999 !important;
	}

	.swal2-deny{
		display: none!important;
	}
</style>
@endsection
@section('content')
	<div class="container-xxl flex-grow-1 container-p-y">
		<div class="nav-align-top">
      <ul class="nav nav-pills flex-column flex-md-row mb-6">
        <li class="nav-item">
          <a href="#dashboard" 
          	class="nav-link active" 
          	onclick="getDashboard()"
          	role="tab"
		        data-bs-toggle="tab"
		        data-bs-target="#dashboard"
		        aria-controls="dashboard"
		        aria-selected="true"
            ><i class="bx bx-bar-chart-alt-2 bx-sm me-1_5"></i>Dashboard</a
          >
        </li>
        <li class="nav-item">
          <a href="#create" 
          	class="nav-link" 
          	onclick="makeNewTicket()"
          	role="tab"
		        data-bs-toggle="tab"
		        data-bs-target="#create"
		        aria-controls="create"
		        aria-selected="true"
            ><i class="bx bx-paper-plane bx-sm me-1_5"></i>Create</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link" 
          	href="#performance" 
          	id="performanceTab" 
          	onclick="getPerformanceAll()"
          	role="tab"
		        data-bs-toggle="tab"
		        data-bs-target="#performance"
		        aria-controls="performance"
		        aria-selected="true"
            ><i class="bx bx-category bx-sm me-1_5"></i>Performance</a
          >
        </li>
        <li class="nav-item">
          <a href="#setting" 
          	class="nav-link" 
          	role="tab"
		        data-bs-toggle="tab"
		        data-bs-target="#setting"
		        aria-controls="setting"
		        aria-selected="true"
            ><i class="bx bx-wrench bx-sm me-1_5"></i>Setting</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link" 
          	href="#reporting" 
          	role="tab"
		        data-bs-toggle="tab"
		        data-bs-target="#reporting"
		        aria-controls="reporting"
		        aria-selected="true"
            ><i class="bx bx-export bx-sm me-1_5"></i>Reporting</a
          >
        </li>
      </ul>
      <div class="tab-content">
				<div class="tab-pane fade show active" id="dashboard">
					<div class="row g-6">
						<div class="col-lg-8">
							<div class="row g-6">
								<div class="col-md-4 col-xs-12">
									<div class="form-group">
										<label>Filter By Client</label>
										<select type="text" class="form-control" style="width: 100%important!" id="filterDashboardByClient" name="filterDashboardByClient">
											<option></option>
										</select>
									</div>
								</div>
								<div class="col-md-4 col-xs-12">
									<div class="form-group">
										<label>Filter By PID</label>
										<select type="text" class="form-control" style="width: 100%important!" id="filterDashboardByPid" name="filterDashboardByPid">
											<option></option>
										</select>
									</div>
								</div>
								<div class="col-md-4 col-xs-12">
									<div class="form-group">
										<label>Date Range</label>
										<div>
											<input type="hidden" id="startDateFilterDashboard">
				      				<input type="hidden" id="endDateFilterDashboard">
				      				<div class="input-group">
												<input type="text" id="filterDashboardByDate" class="form-control" />
									      <span class="input-group-text" id="basic-addon13">
									      	<a class="resetDate" onclick="reinitializeDateRangePicker()" style="cursor:pointer;">
				      							<i class="bx bx-x"></i>
				      						</a>
									      </span>
									    </div>
				      				<!-- <div class="input-group">
				      					<button type="button" class="btn btn-sm btn-default btn-flat pull-left" style="width:100%" id="filterDashboardByDate">
													<i class="fa fa-calendar"></i> Date range picker
													<span>
														<i class="fa fa-caret-down"></i>
													</span>
												</button>
				      					<span class="input-group-addon">
				      						
				      					</span>
				      				</div> -->
										</div>
									</div>
								</div>
							</div>
							
							<div class="divider">
							  <div class="divider-text">
							    <b>Need Attention</b>
							  </div>
							</div>
							<div class="row g-6">
								<div class="col-md-12">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>ID</th>
												<th>ATM*</th>
												<th>Location</th>
												<th>Last Update</th>
												<th>Severity</th>
												<th>Status</th>
												<th>Operator</th>
											</tr>
										</thead>
										<tbody id="importanTable">
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<!-- 	<div class="row">
								<div class="col-md-12">
									<div class="info-box">
										<div class="box-body">
											<canvas id="pieChart" style="height:250px"></canvas>
										</div>
									</div>
								</div>
							</div> -->
							<b>Occurring</b>
							<div class="row gy-4 gy-sm-1 mt-1 mb-3">
                <div class="col-sm-6 col-lg-4">
                  <div
                    class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                    <div>
                      <h6 class="mb-0" id="countOpen">0</h6>
                      <p class="mb-0" style="font-size:12px">OPEN</p>
                    </div>
                    <span class="avatar w-px-40 h-px-40 p-2 me-sm-4">
											<a onclick="getByStatus('OPEN')" style="cursor:pointer;">
	                      <span class="avatar-initial avatar-shadow-danger rounded-circle">
	                        <i class="bx bx-lock-open bx-lg text-heading"></i>
	                      </span>
	                    </a>
                    </span>
                  </div>
                  <hr class="d-none d-sm-block d-lg-none" />
                </div>
                <div class="col-sm-6 col-lg-4">
                  <div
                    class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
                    <div>
                      <h6 class="mb-0" id="countProgress">0</h6>
                      <p class="mb-0" style="font-size:12px">PROGRESS</p>
                    </div>
                    <span class="avatar w-px-40 h-px-40 p-2 me-sm-4">
											<a onclick="getByStatus('ON PROGRESS')" style="cursor:pointer;">
	                      <span class="avatar-initial avatar-shadow-info rounded-circle">
	                        <i class="bx bx-wrench bx-lg text-heading"></i>
	                      </span>
	                    </a>
                    </span>
                  </div>
                  <hr class="d-none d-sm-block d-lg-none" />
                </div>
                <div class="col-sm-6 col-lg-4">
                  <div
                    class="d-flex justify-content-between align-items-start pb-4 pb-sm-0 card-widget-3">
                    <div>
                      <h6 class="mb-0" id="countPending">0</h6>
                      <p class="mb-0" style="font-size:12px">PENDING</p>
                    </div>
                    <span class="avatar w-px-40 h-px-40 p-2 me-sm-4">
											<a onclick="getByStatus('PENDING')" style="cursor:pointer;">
	                      <span class="avatar-initial avatar-shadow-warning rounded-circle">
	                        <i class="bx bx-time bx-lg text-heading"></i>
	                      </span>
	                    </a>
                    </span>
                  </div>
                </div>
              </div>
							<b>Completed</b>
							<div class="row gy-4 gy-sm-1 mt-1 mb-3">
                <div class="col-sm-6 col-lg-4">
                  <div
                    class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                    <div>
                      <h6 class="mb-0" id="countCancel">0</h6>
                      <p class="mb-0" style="font-size:12px">CANCEL</p>
                    </div>
                    <span class="avatar w-px-40 h-px-40 me-sm-4">
											<a onclick="getByStatus('CANCEL')" style="cursor:pointer;">
	                      <span class="avatar-initial avatar-shadow-primary rounded-circle">
	                        <i class="bx bx-x bx-lg text-heading"></i>
	                      </span>
	                    </a>
                    </span>
                  </div>
                  <hr class="d-none d-sm-block d-lg-none me-6" />
                </div>
                <div class="col-sm-6 col-lg-4">
                  <div
                    class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
                    <div>
                      <h6 class="mb-0" id="countClose">0</h6>
                      <p class="mb-0" style="font-size:12px">CLOSE</p>
                    </div>
                    <span class="avatar w-px-40 h-px-40 p-2 me-lg-4">
											<a onclick="getByStatus('CLOSE')" style="cursor:pointer;">
	                      <span class="avatar-initial avatar-shadow-success rounded-circle">
	                        <i class="bx bx-check-square text-white bx-lg text-heading"></i>
	                      </span>
	                    </a>
                    </span>
                  </div>
                  <hr class="d-none d-sm-block d-lg-none" />
                </div>
                <div class="col-sm-6 col-lg-4">
                  <div
                    class="d-flex justify-content-between align-items-start pb-4 pb-sm-0 card-widget-3">
                    <div>
                      <h6 class="mb-0" id="countAll">0</h6>
                      <p class="mb-0" style="font-size:12px">ALL</p>
                    </div>
                    <span class="avatar w-px-40 h-px-40 p-2 me-sm-4">
											<a onclick="getByStatus('ALL')" style="cursor:pointer;">
	                      <span class="avatar-initial avatar-shadow-dark rounded-circle">
	                        <i class="bx bx-archive text-white bx-lg text-heading"></i>
	                      </span>
	                    </a>
                    </span>
                  </div>
                </div>
              </div>

							<b>Severity</b>
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<a onclick="getSeverity(1)">
										<div class="card text-bg-danger severityCounter">
											<div class="card-body">
								        <h6 class="card-title text-white">Critical</h6>
								        <h6 class="card-subtitle mb-2 text-white" id="countCritical">0</h6>
								        <p class="card-text text-truncate">
													[< 3 hour] Critical impact to business operations
								        </p>
								      </div>
										</div>
									</a>
								</div>
								
								<div class="col-md-6 col-sm-6">
									<a onclick="getSeverity(2)">
										<div class="card text-bg-warning severityCounter">
											<div class="card-body">
								        <h6 class="card-title text-white">Major</h6>
								        <h6 class="card-subtitle mb-2 text-white" id="countMajor">0</h6>
								        <p class="card-text text-truncate">
													[< 8 hour] Significant impact to business operations
								        </p>
								      </div>
										</div>
									</a>
								</div>

								<div class="col-md-6 col-sm-6">
									<a onclick="getSeverity(3)">
										<div class="card severityCounter" style="background-color: #f1c40f;color: #fff !important;">
											<div class="card-body">
								        <h6 class="card-title text-white">Moderate</h6>
								        <h6 class="card-subtitle mb-2 text-white" id="countModerate">0</h6>
								        <p class="card-text text-truncate">
													[1x24 hour] Business operations noticeably impaired 
								        </p>
								      </div>
										</div>
									</a>
								</div>
								<div class="col-md-6 col-sm-6">
									<a onclick="getSeverity(4)">
										<div class="card text-bg-success severityCounter" style="background-color: #f1c40f;color: #fff !important;">
											<div class="card-body">
								        <h6 class="card-title text-white">Minor</h6>
								        <h6 class="card-subtitle mb-2 text-white" id="countMinor">0</h6>
								        <p class="card-text text-truncate">
													[on preventive] Installation, upgrade, or configuration assistance General product information 
								        </p>
								      </div>
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="row"> 
						<div class="col-md-12 col-xs-12">
							<div class="card-datatable table-responsive">
								<table class="table" style="border: solid 1px lightgray;width: 100%;" id="tb_sla_resolution_time">
									<thead>
										<tr>
											<th rowspan="3">Project ID</th>
											<th colspan="8" style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Status SLA Resolution Time
											</th>
											<th colspan="2" rowspan="2" style="text-align: center;vertical-align: middle;font-size: small;">
												Total
											</th>
										</tr>
										<tr>
											<th colspan="2" style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Critical
											</th>
											<th colspan="2" style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Major
											</th>
											<th colspan="2" style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Moderate
											</th>
											<th colspan="2" style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Minor
											</th>
										</tr>
										<tr>
											<th style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Comply
											</th>
											<th style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Not-Comply
											</th>
											<th style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Comply
											</th>
											<th style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Not-Comply
											</th>
											<th style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Comply
											</th>
											<th style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Not-Comply
											</th>
											<th style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Comply
											</th>
											<th style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Not-Comply
											</th>
											<th style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Comply
											</th>
											<th style="text-align: center;vertical-align: middle;font-size: small;">
												Not-Comply
											</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-xs-12">
							<div class="card-datatable table-responsive">
								<table class="table" style="border: solid 1px lightgray;width: 100%;" id="tb_sla_response_time">
									<thead>
										<tr>
											<th rowspan="2" style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Project ID
											</th>
											<th colspan="2" style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Status SLA Response Time
											</th>
											<th rowspan="2" style="text-align: center;vertical-align: middle;font-size: small;">
												Total
											</th>
										</tr>
										<tr>
											<th style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Comply
											</th>
											<th style="text-align: center;vertical-align: middle;border-right: solid 1px lightgray;font-size: small;">
												Not-Comply
											</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane" id="create">
					<button class="btn btn-sm btn-info" id="createIdTicket" onclick="reserveIdTicket()">Reserve ID Ticket</button>
					<div class="row" id="formNewTicket">
						<div class="col-md-8">
							<form class="form-horizontal">
								<input type="hidden" id="inputID">
								<div class="form-group" id="nomorDiv" style="display: none;">
									<div class="row">
										<label for="inputNomor" class="col-sm-2 control-label" >ID Ticket</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputticket" value="" disabled>
										</div>
									</div>
								</div>
								<div class="form-group mt-2" id="typeDiv" style="display: none;">
									<div class="row">
										<label class="col-sm-2 control-label">Type*</label>
											<div class="col-sm-4">
												<select class="form-control" id="inputTypeTicket">
													<option selected="selected" value="">Choose Type</option>
													<option value="Trouble Ticket">Trouble Ticket</option>
													<option value="Preventive Maintenance">Preventive Maintenance Ticket</option>
													<option value="Permintaan Layanan">Permintaan Layanan Ticket</option>
													<option value="Permintaan Penawaran">Permintaan Penawaran</option>
												</select>
												<span class="invalid-feedback" style="margin-bottom: 0px; display: none;">Type ticket must be fill!</span>
											</div>
											<label class="col-sm-2 control-label">Severity*</label>
											<div class="col-sm-4">
												<select class="form-control" id="inputSeverity" style="width:100%">
												</select>
												<span class="invalid-feedback" style="margin-bottom: 0px; display: none;">Severity must be fill!</span>
											</div>
									</div>
								</div>
								<div class="form-group mt-2" id="clientDiv" style="display: none;">
									<div class="row">
										<label class="col-sm-2 control-label">Client*</label>
										<div class="col-sm-4">
											<select class="form-control" id="inputClient" style="width:100%">
											</select>
											<span class="invalid-feedback" style="margin-bottom: 0px; display: none;">Client must be fill!</span>
										</div>
										<!-- <div class="form-group" id="inputATMid"> -->
											<label class="col-sm-2 control-label">Asset</label>
											<div class="col-sm-4">
												<select class="form-control select2" id="inputATM" style="width: 100%"></select>
												<span class="invalid-feedback" style="margin-bottom: 0px; display: none;">Asset must be select!</span>
											</div>
										<!-- </div> -->
									</div>
								</div>
								<div class="form-group mt-2" id="pidDiv" style="display: none;">
									<div class="row">
										<label class="col-sm-2 control-label">PID*</label>
										<div class="col-sm-4">
											<select class="form-control" id="selectPID" style="width:100%!important">
												<option></option>
											</select>
											<span class="invalid-feedback" style="margin-bottom: 0px; display: none;">Project ID must be select!</span>
										</div>
										<label class="col-sm-2 control-label">Asset Category</label>
										<div class="col-sm-4">
											<select class="form-control" id="selectCatAsset" style="width:100%" disabled>
											</select>
											<span class="invalid-feedback" style="margin-bottom: 0px; display: none;">Asset category must be fill!</span>
										</div>
									</div>
								</div>
								<hr id="hrLine" style="display: none">
								<div class="form-group mt-2" id="refrenceDiv" style="display: none;">
									<div class="row">
										<label for="inputDescription" class="col-sm-2 control-label">Reference</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputRefrence" placeholder="">
										</div>
									</div>
								</div>
								<!-- <div class="form-group needs-validation">
									<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> Input with
										error</label>
									<input type="text" class="form-control" id="inputError" placeholder="Enter ...">
								</div> -->
								<div class="form-group mt-2" id="picDiv" style="display: none;">
									<div class="row">
										<label for="inputDescription" class="col-sm-2 control-label">PIC*</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputPIC" placeholder="" required>
											<span class="invalid-feedback" style="margin-bottom: 0px; display: none;">Person In Charge must be fill!</span>
										</div>
									</div>
								</div>
								<div class="form-group mt-2" id="contactDiv" style="display: none;">
									<div class="row">
										<label for="inputDescription" class="col-sm-2 control-label">Contact PIC*</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputContact" placeholder="" required>
											<span class="invalid-feedback" style="margin-bottom: 0px; display: none;">Contact PIC must be fill!</span>
										</div>
									</div>
								</div>
								<div class="form-group mt-2" id="categoryDiv" style="display: none;">
									<div class="row">
										<label for="inputCreator" class="col-sm-2 control-label">Category</label>
										<div class="col-sm-10">
											<select class="form-control" id="inputCategory" required>
												<option selected="selected">Choose problem category</option>
												<option value="Aktivasi">Aktivasi</option>
												<option value="Cash Handler Fatal">Cash Handler Fatal</option>
												<option value="Cassette Fatal">Cassette Fatal</option>
												<option value="EJ Fail">EJ Fail</option>
												<option value="Key Fail">Key Fail</option>
												<option value="Listening">Listening</option>
												<option value="Vandalisme">Vandalisme</option>
												<option value="Softkey">Softkey</option>
												<option value="Dispenser">Dispenser</option>
												<option value="Cartreader">Cartreader</option>
												<option value="Printer">Printer</option>
												<option value="Lain-lain">Lain-lain</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group mt-2" id="problemDiv" style="display: none;">
									<div class="row">
										<label for="inputEmail" class="col-sm-2 control-label">Problem*</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputProblem" placeholder="" required>
											<span class="invalid-feedback" style="margin-bottom: 0px; display: none;">Problem must be fill!</span>
										</div>
									</div>
								</div>
								<div class="form-group mt-2" id="locationDiv" style="display: none;">
									<div class="row">
										<label for="inputEmail" class="col-sm-2 control-label">Location*</label>
										<div class="col-sm-10">
											<select class="form-control select2" id="inputAbsenLocation" style="width: 100%; display: none"></select>
											<select class="form-control select2" id="inputSwitchLocation" style="width: 100%; display: none"></select>
											<input type="text" class="form-control" id="inputLocation" placeholder="" required>
											<span class="invalid-feedback" style="margin-bottom: 0px; display: none;">Location Must be fill!</span>
										</div>
									</div>
								</div>
								<div class="form-group mt-2" id="engineerDiv" style="display: none;">
									<div class="row">
										<label for="inputEngineerOpen" class="col-sm-2 control-label">Engineer</label>
										<div class="col-sm-10">
												<input type="text" class="form-control" id="inputEngineerOpen" placeholder="" required value="">
											<span class="invalid-feedback" style="margin-bottom: 0px; display: none;">Engineer must be fill!</span>
										</div>
									</div>
								</div>
								<div class="form-group mt-2" id="slmDiv" style="display: none;">
									<div class="row">
										<label for="inputEmail" class="col-sm-2 control-label">SLM</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputSlm" disabled>
										</div>
									</div>
								</div>
								<div class="form-group mt-2" id="serialDiv" style="display: none;">
									<div class="row">
										<label for="inputEmail" class="col-sm-2 control-label">Serial Number</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputSerial" placeholder="" disabled>
										</div>
									</div>
								</div>
								<div class="form-group mt-2" id="typeDiv" style="display: none;">
									<div class="row">
										<label for="inputType" class="col-sm-2 control-label">Device Type</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputType" placeholder="">
										</div>
									</div>
								</div>
								<div class="form-group mt-2" id="ipMechineDiv" style="display: none;">
									<div class="row">
										<label for="inputType" class="col-sm-2 control-label">IP Address</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputIpMechine" placeholder="">
										</div>
									</div>
								</div>
								<div class="form-group mt-2" id="ipServerDiv" style="display: none;">
									<div class="row">
										<label for="inputType" class="col-sm-2 control-label">IP Server</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputIpServer" placeholder="">
										</div>
									</div>
								</div>
								<hr id="hrLine2" style="display: none">
								<div class="form-group" id="reportDiv" style="display: none;">
									<div class="row">
										<label for="inputEmail" class="col-sm-2 control-label">Report Time*</label>
										<div class="col-sm-5 mt-2 firstReport">
											<div class="input-group">
									      <input type="text" class="form-control" id="inputReportingTime" placeholder="ex. 01:11:00">
									      <span class="input-group-text">
									      	<i class="icon-base bx bx-time"></i>
									      </span>
									    </div>
											<span class="invalid-feedback" style="margin-bottom: 0px; display: none;">Time must be set!</span>
										</div>
										<div class="col-sm-5 mt-2 secondReport">
											<div class="input-group date">
												<span class="input-group-text">
									      	<i class="icon-base bx bx-calendar"></i>
									      </span>
												<input type="text" class="form-control pull-right" id="inputReportingDate">
											</div>
											<span class="invalid-feedback" style="margin-bottom: 0px; display: none;">Date must be set!</span>
											<!-- <input type="text" class="form-control" id="inputReport" placeholder=""> -->
										</div>
									</div>
								</div>
								<div class="form-group mt-2" id="dateDiv" style="display: none;">
									<div class="row">
										<label for="inputEmail" class="col-sm-2 control-label">Date Open</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputDate" placeholder="" disabled>
										</div>
									</div>
								</div>
								<div class="form-group mt-2" id="noteDiv" style="display: none;">
									<div class="row">
										<label for="inputEmail" class="col-sm-2 control-label">Note Open</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="inputNote" placeholder="">
										</div>
									</div>
								</div>
							</form>
							<i class="btn btn-sm btn-info mt-5" id="createTicket" style="display: none!important;float: right;">Create Ticket</i>
						</div>

						<div class="col-md-4" id="tableTicket" style="display: none;">
							<h5>Preview Ticket : </h5>
							<hr>
							<table class="table table2">
								<tr>
									<th class="text-bg-primary">Ticket ID</th>
									<td id="holderID"></td>
								</tr>
								<tr>
									<th class="text-bg-primary">Refrence</th>
									<td id="holderRefrence"></td>
								</tr>
								<tr>
									<th class="text-bg-primary">Customer</th>
									<td id="holderCustomer"></td>
								</tr>
								<tr>
									<th class="text-bg-primary">PIC</th>
									<td id="holderPIC"></td>
								</tr>
								<tr>
									<th class="text-bg-primary">Contact</th>
									<td id="holderContact"></td>
								</tr>
								<tr>
									<th class="text-bg-primary">Problem</th>
									<td id="holderProblem"></td>
								</tr>
								<tr>
									<th class="text-bg-primary">Location</th>
									<td id="holderLocation"></td>
								</tr>
								
								<tr id="holderIDATM2" style="display: none;">
									<th class="text-bg-primary">Asset</th>
									<td id="holderIDATM"></td>
								</tr>
								<tr>
									<th class="text-bg-primary">Date</th>
									<td id="holderDate"></td>
								</tr>
								<tr id="holderEngineer" style="display: none;">
									<th class="text-bg-primary">Engineer</th>
									<td id="holderEngineerOpen"></td>
								</tr>
								<tr id="holderSerial1">
									<th class="text-bg-primary">Serial number</th>
									<td id="holderSerial"></td>
								</tr>
								<tr id="holderIDATM3" style="display: none;">
									<th class="text-bg-primary">Device Type</th>
									<td id="holderType"></td>
								</tr>
								<tr id="holderIPMechine" style="display: none;">
									<th class="text-bg-primary">IP Address</th>
									<td id="holderIPMechine2"></td>
								</tr>
								<tr id="holderIPServer" style="display: none;">
									<th class="text-bg-primary">IP Server</th>
									<td id="holderIPServer2"></td>
								</tr>
								<tr>
									<th class="text-bg-primary">Severity</th>
									<td id="holderSeverity"></td>
								</tr>
								<tr>
									<th class="text-bg-primary">Status</th>
									<td id="holderStatus" class="text-center text-bg-danger" style="border-bottom: none;"></td>
								</tr>
								<tr>
									<th class="text-bg-primary">Waktu</th>
									<td id="holderWaktu" class="text-center text-bg-danger" style="border-top: none;"></td>
								</tr>
								<tr>
									<th class="text-bg-primary">Note</th>
									<td id="holderNote"></td>
								</tr>
							</table>
							<div class="row">
								<div class="col-md-7 col-xs-12">
									<select class="form-control" id="inputTemplateEmail">
									</select>
								</div>
								<div class="col-md-5 col-xs-12">
									<i style="width:100%" class="btn btn-sm btn-info" id="createEmailBody" onclick="createEmailBody()" disabled>Create Email</i>
									<!-- <i style="width:100%" class="btn btn-sm btn-flat btn-info" id="createEmailBodyNormal" onclick="createEmailBody('normal')">Create Email</i>
									<i style="width:100%" class="btn btn-sm btn-flat btn-success" id="createEmailBodyWincor" onclick="createEmailBody('wincor')">Create Wincor Email</i> -->
								</div>
							</div>
						</div>
					</div>
					<div class="row" id="sendTicket" style="display: none;">
						<div class="col-md-12">
							<div class="form-horizontal">
								<div class="form-group">
									<div class="row">
										<label class="col-sm-1 control-label">
											To : 
										</label>
										<div class="col-sm-11">
											<input class="form-control" name="emailTo" id="emailOpenTo" style="width:100%!important">
										</div>
										<div class="col-sm-11 col-sm-offset-1 invalid-feedback" style="margin-bottom: 0px;">
											Enter the recipient of this open email!
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<label class="col-sm-1 control-label">
											Cc :
										</label>
										<div class="col-sm-11">
											<input class="form-control" name="emailCc" id="emailOpenCc">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<label class="col-sm-1 control-label">
											Subject :
										</label>
										<div class="col-sm-11">
											<input class="form-control" name="emailSubject" id="emailOpenSubject">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<div contenteditable="true" class="form-control mt-5" style="height: 600px;overflow: auto;" id="bodyOpenMail">
											
										</div>
									</div>
								</div>
								<div class="form-group mt-5">
									<div class="col-sm-12">
										<div>
											<!-- <div class="btn btn-sm btn-default btn-file">
												<i class="fa fa-paperclip"></i> Attachment
												<input type="file" name="attachment" id="emailOpenAttachment">
											</div> -->
											<button class="btn btn-sm btn-secondary pull-left" onclick="backOpenEmail()"><i class="fa fa-chevron-left"></i> Back</button>
											<button class="btn btn-sm btn-primary" style="float: right;" onclick="sendOpenEmail()"><i class="fa fa-envelope-o"></i> Send</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane" id="performance">
					<div class="row">
						<div class="col-md-3">
							<b>Filter by Client : </b>
							<div>
								<select class="form-control" id="clientList" style="width:100%;font-size: 12px;" multiple="multiple"></select>
							</div>
						</div>
						<div class="col-md-3" style="display:none">
							<b>Filter by Severity or Type : </b>
							<div>
								<select class="form-control" id="severityFilter" style="width:100%" multiple="multiple"></select>
							</div>
						</div>
						<div class="col-md-3">
							<b>Filter by Type Ticket : </b>
							<div>
								<select class="form-control" id="typeFilter" style="width:100%" multiple="multiple"></select>
							</div>
						</div>
						<div class="col-sm-3">
							<b>Date Range : </b>
							<div>
								<input type="hidden" id="startDateFilter">
					      <input type="hidden" id="endDateFilter">
								<button type="button" class="btn btn-sm btn-outline-secondary btn-flat pull-left" style="width:100%;" id="dateFilter">
									<i class="bx bx-calendar"></i> Date range picker
									<span>
										<i class="bx bx-caret-down"></i>
									</span>
								</button>
							</div>
						</div>
						<div class="col-md-12 mt-2">
							<div class="row">
								<div class="col-md-5 col-xs-12">
									<b>Search Anything</b>
									<div class="input-group mb-4">
									  <input id="searchBarTicket" type="text" class="form-control" placeholder="ex: Ticket ID">
									  <button id="btnShowEntryTicket" class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Show 10 </button>
									 	<ul class="dropdown-menu dropdown-menu-end" id="selectShowEntryTicket">
											<li><a class="dropdown-item" href="#" onclick="changeNumberEntries(10)">10</a></li>
											<li><a class="dropdown-item" href="#" onclick="changeNumberEntries(25)">25</a></li>
											<li><a class="dropdown-item" href="#" onclick="changeNumberEntries(50)">50</a></li>
											<li><a class="dropdown-item" href="#" onclick="changeNumberEntries(100)">100</a></li>
										</ul>
										<button title="Clear Filter" id="clearFilterTable" type="button" class="btn btn-sm btn-secondary btn-flat">
											<i class="bx bx-x"></i>
										</button>
									</div>
								</div>
								<div class="col-md-7 col-xs-12">
									<div class="mt-4">
										<button type="button" id="btnShowColumnTicket" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
											Displayed Column
										</button>
										<ul class="dropdown-menu dropdown-menu-end" style="padding-left:5px;padding-right: 5px;" id="selectShowColumnTicket">
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" type="checkbox" onclick="changeColumnTable(this)" data-column="0"><span class="text">ID Ticket</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" type="checkbox" onclick="changeColumnTable(this)" data-column="1"><span class="text">Asset</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" type="checkbox" onclick="changeColumnTable(this)" data-column="2"><span class="text">Serial Number</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" type="checkbox" onclick="changeColumnTable(this)" data-column="3"><span class="text">Ticket Number</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" type="checkbox" onclick="changeColumnTable(this)" data-column="4"><span class="text">Open</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" type="checkbox" onclick="changeColumnTable(this)" data-column="5"><span class="text">Location - Problem</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" type="checkbox" onclick="changeColumnTable(this)" data-column="6"><span class="text">PIC</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" type="checkbox" onclick="changeColumnTable(this)" data-column="7"><span class="text">Severity</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" type="checkbox" onclick="changeColumnTable(this)" data-column="8"><span class="text">Status</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" type="checkbox" onclick="changeColumnTable(this)" data-column="13"><span class="text">Operator</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" type="checkbox" onclick="changeColumnTable(this)" data-column="9"><span class="text">Response Time</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" type="checkbox" onclick="changeColumnTable(this)" data-column="11"><span class="text">Resolution Time</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" type="checkbox" onclick="changeColumnTable(this)" data-column="10"><span class="text">Status Response Time</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" type="checkbox" onclick="changeColumnTable(this)" data-column="12"><span class="text">Status Resolution Time</span></li>
										</ul>
										<button style="margin-left: 10px;" title="Refresh Table" id="reloadTable" type="button" class="btn btn-sm btn-secondary ">
											<i class="bx bx-refresh"></i>
										</button>
										<button style="margin-left: 10px;" type="button" class="btn btn-sm btn-success">
										  <i class="icon-base bx bx-export me-1"></i> Export to Excel
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-md-12 mt-2">
							<div class="table-responsive no-padding">
								<table class="table table-bordered table-striped dataTable" id="tablePerformance">
									<thead>
										<th style="width: 120px;text-align:center;vertical-align: middle;">
											ID Ticket
										</th>
										<th style="width: 100px;text-align:center;vertical-align: middle;" class="columnIdAtm">
											Asset
										</th>
										<th style="width: 100px;text-align:center;vertical-align: middle;">
											Serial Number
										</th>
										<th style="width: 100px;text-align:center;vertical-align: middle;" class="columnTicketNum">
											Ticket Number
										</th>
										<th style="width: 100px;text-align:center;vertical-align: middle;">
											Open
										</th>
										<th style="vertical-align: middle;">
											Location - Problem
										</th>
										<th style="text-align: center;vertical-align: middle;">
											PIC
										</th>
										<!-- <th style="width: 100px;vertical-align: middle;">
											Location
										</th> -->
										<th style="text-align: center;vertical-align: middle;">
											Severity
										</th>
										<th style="text-align: center;vertical-align: middle;">
											Status
										</th>
										<th style="text-align: center;vertical-align: middle;">
											Response Time
										</th>
										<th style="text-align: center;vertical-align: middle;">
											Status Response Time
										</th>
										<th style="text-align: center;vertical-align: middle;">
											Resolution Time
										</th>
										<th style="text-align: center;vertical-align: middle;">
											Status Resolution Time
										</th>
										<th style="text-align: center;vertical-align: middle;">
											Operator
										</th>
										<th style="text-align: center;vertical-align: middle;">
											Action
										</th>
									</thead>
									<tfoot>
										<th style="width: 120px;text-align:center;vertical-align: middle;">ID Ticket</th>
										<th style="width: 100px;text-align:center;vertical-align: middle;" class="columnIdAtm">Asset</th>
										<th style="width: 100px;text-align:center;vertical-align: middle;">Serial Number</th>
										<th style="width: 100px;text-align:center;vertical-align: middle;" class="columnTicketNum">Ticket Number</th>
										<th style="width: 100px;text-align:center;vertical-align: middle;">Open</th>
										<th style="vertical-align: middle;">Location - Problem</th>
										<th style="text-align: center;vertical-align: middle;">PIC</th>
										<!-- <th style="width: 100px;vertical-align: middle;">Location</th> -->
										<th style="text-align: center;vertical-align: middle;">Severity</th>
										<th style="text-align: center;vertical-align: middle;">Status</th>
										<th style="text-align: center;vertical-align: middle;">SLA Response Time</th>
										<th style="text-align: center;vertical-align: middle;">Status Response Time</th>
										<th style="text-align: center;vertical-align: middle;">SLA Resolution Time</th>
										<th style="text-align: center;vertical-align: middle;">Status Resolution Time</th>
										<th style="text-align: center;vertical-align: middle;">Operator</th>
										<th style="text-align: center;vertical-align: middle;">Action</th>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane" id="setting">
					<div class="row form-group">
						<div class="col-md-8">
							<button class="btn btn-sm btn-secondary" type="button" onclick="emailSetting()">
								Client Email Setting
							</button>
							<button class="btn btn-sm btn-secondary" type="button" onclick="SlmEmailSetting()">
								SLM Email Setting
							</button>
							<button class="btn btn-sm btn-secondary" type="button" onclick="userSetting()">
								User Setting
							</button>
							<button class="btn btn-sm btn-secondary" type="button" onclick="SlaSetting()">
								SLA Setting
							</button>
						</div>
						<div class="col-md-4 settingComponent d-flex" style="display: none!important" id="addEmail2">
							<div class="input-group mb-4">
								<input id="searchBarEmail" type="text" class="form-control">
							  <button class="btn btn-sm btn-outline-primary" type="button" id="applyFilterTableEmail">
							  	<i class="icon-base bx bx-search"></i>
								</button>
							</div>
							<button class="btn btn-sm btn-primary" type="button" onclick="EmailAdd()" id="addEmail" style="margin-left: 10px;display: none;width: 150px;height: 39.5px;">
								Add Email
							</button>
	<!-- 						<button class="btn btn-sm btn-primary" type="button" onclick="EmailSlmAdd()" id="addEmailSlm" style="margin-left: 10px;display: none!important;width: 150px;height: 39.5px;">
								Add Email
							</button> -->
						</div>
					</div>
					<div style="display: none" id="emailSetting" class="row form-group settingComponent mt-5">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-bordered" id="tableEmailSetting">
									<thead>
										<tr>
											<th style="vertical-align: middle;text-align: center;">Project ID</th>
											<th style="vertical-align: middle;text-align: center;">Dear</th>
											<th style="vertical-align: middle;text-align: center;">To</th>
											<th style="vertical-align: middle;text-align: center;">Cc</th>
											<th style="vertical-align: middle;text-align: center;">Action</th>
											
										</tr>
									</thead>
								</table>
							</div>		
						</div>
					</div>
					<div style="display: none" id="SlmEmailSetting" class="row form-group settingComponent mt-5">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-bordered" id="tableSlmEmailSetting">
									<thead>
										<tr>
											<th style="vertical-align: middle;text-align: center;">2nd Level Support</th>
											<th style="vertical-align: middle;text-align: center;">Dear</th>
											<th style="vertical-align: middle;text-align: center;">To</th>
											<th style="vertical-align: middle;text-align: center;">Cc</th>
											<th style="vertical-align: middle;text-align: center;">Action</th>
										</tr>
									</thead>
								</table>
							</div>		
						</div>
					</div>
					<div style="display: none" id="userSetting" class="row form-group settingComponent mt-5">
						<div class="col-md-3 col-xs-12">
							<div class="box box-solid box-default">
								<div class="box-header">
									<label class="box-title"><i class="fa fa-filter"></i> Filter</label>
								</div>
								<div class="box-body">
									<div class="form-group mt-2">
										<label>Assign</label>
										<select id="assignFilter" name="assignFilter" class="form-control select2" style="width: 100%!important;" onchange="assignFilter(this.value)">
											<option value="user">User</option>
											<option value="site">Site</option>
										</select>
									</div>
									<div class="form-group mt-2">
										<label>Location</label>
										<div class="siteFilter">
											
										</div>
									</div>
									<div class="form-group mt-2">
										<label>User</label>
										<select id="userFilter" name="userFilter" class="form-control select2" style="width: 100%!important;">
										</select>
									</div>
									<div class="form-group mt-2">
										<label>Customer</label>
										<select id="customerFilter" name="customerFilter" class="form-control select2" multiple style="width: 100%!important;">
										</select>
									</div>
									<div class="d-grid gap-2 mx-auto mt-2">
										<button class="btn btn-sm btn-primary" id="btnFilterPid" onclick="filterPID()">Filter</button>
										<button class="btn btn-sm btn-secondary" id="btnFilterResetPid" onclick="resetPID()">Reset Filter</button>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-9 col-xs-12">
							<div class="box box-solid">
								<div class="box-header" style="flex-direction: row-reverse;display: flex;">
									<div class="input-group" style="width: 50%;">
										<input id="searchBarAll" type="text" class="form-control" onkeyup="searchCustomAll('searchBarAll')" placeholder="Search PID/Site/User">	
										<span class="input-group-btn">
											<button onclick="searchCustomAll('searchBarAll')" type="button" class="btn btn-sm btn-secondary btn-flat">
												<i class="icon-base bx bx-search"></i>
											</button>
										</span>
									</div>
								</div>
								<div class="box-body boxDivSite" style="overflow: auto;">
									<div class="divSiteBox">
										
									</div>									
								</div>
								<nav class="pull-right" aria-label="Page navigation example" style="margin-top:10px">
								  <ul class="pagination justify-content-center" id="pagination">
								  </ul>
								</nav>
							</div>
						</div>
					</div>
					<div style="display: none" id="SlaSetting" class="row form-group settingComponent my-5">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-bordered" id="tableSlaSetting">
									<thead>
										<tr>
											<th style="vertical-align: middle;text-align: center;">Project ID</th>
											<th style="vertical-align: middle;text-align: center;">SLA Response Time</th>
											<th style="vertical-align: middle;text-align: center;">SLA Resolution Time (Critical)</th>
											<th style="vertical-align: middle;text-align: center;">SLA Resolution Time (Major)</th>
											<th style="vertical-align: middle;text-align: center;">SLA Resolution Time (Moderate)</th>
											<th style="vertical-align: middle;text-align: center;">SLA Resolution Time (Minor)</th>
										</tr>
									</thead>
								</table>
							</div>		
						</div>
					</div>
					<div style="display: none" id="severitySetting" class="row form-group settingComponent mt-5">
						<div class="col-md-12">
							Comming Soon...
						</div>
					</div>
					<div style="display: none" id="clientSetting" class="row form-group settingComponent mt-5">
						<div class="col-md-12">
							Comming Soon...
						</div>
					</div>
				</div>

				<div class="tab-pane" id="reporting">
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<label>Select Type</label>
								<select id="selectReportingType" class="form-control">
									<option>Choose One</option>
									<option value="finishReport">Finish Report</option>
									<option value="finishReportPid">Finish Report PID</option>
									<option value="helpdeskReport">Helpesk Report</option>
									<option value="slmReport">SLM Report</option>
									<option value="slmReportPending">SLM Report Pending</option>
									<!-- <option value="managerReport">Manager Report</option> -->
								</select>
							</div>
						</div>
						<div class="col-md-2 divReportingClient" style="display:none;">
							<div class="form-group">
								<label>Select Client</label>
								<select id="selectReportingClient" style="width:100% !important" class="select2 form-control">
								</option>
								</select>
							</div>
						</div>
						<div class="col-md-2 divPID" style="display:none;">
							<div class="form-group">
								<label>Select PID</label>
								<select class="form-control" id="selectPIDReport">
								</select>
							</div>
						</div>
						<div class="col-md-2 divTypeTicket" style="display:none;">
							<div class="form-group">
								<label>Select Type Ticket</label>
								<select class="form-control" id="selectTypeTicket">
									<option selected="selected" value="none">Choose Type</option>
									<option value="TT">Trouble Ticket</option>
									<option value="PM">Preventive Maintenance Ticket</option>
									<option value="PL">Permintaan Layanan Ticket</option>
									<option value="PP">Permintaan Penawaran</option>
								</select>
							</div>
						</div>
						<div class="col-md-2 divReportingYear" style="display:none;">
							<div class="form-group">
								<label>Select Year</label>
								<select id="selectReportingYear" class="form-control">
								</select>
							</div>
						</div>
						<div class="col-md-2 divReportingMonth" style="display:none;">
							<div class="form-group">
								<label>Select Month</label>
								<select id="selectReportingMonth" class="form-control">
								</select>
							</div>
						</div>
						<div class="col-md-4 divDateRange" style="display:none;">
							<div class="form-group">
								<label>Date range button:</label>

								<div class="input-group">
									<button type="button" class="btn btn-sm btn-secondary pull-right" id="daterange-btn">
										<span>
											<i class="fa fa-calendar"></i> Date range picker
										</span>
										<i class="fa fa-caret-down"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-md-12">
							<!-- <a id="ReportingButtonLink" href=""> -->
								<button id="ReportingButtonGo" class="pull-right btn btn-flat btn-sm btn-primary" style="display: none!important;" onclick="getReport()">
									Goo..
								</button>
								<button id="ReportingButtonGoNew" class="pull-right btn btn-flat btn-sm btn-primary" style="display: none!important;">
									Goo..
								</button>
								<button id="ReportingButtonGoNew2" class="pull-right btn btn-flat btn-sm btn-primary" style="display: none!important;">
									Goo..
								</button>
							<!-- </a> -->
						</div>
					</div>
				</div>
			</div>
    </div>
	</div>

	<div class="modal fade" id="modal-ticket">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="justify-content: space-between;">
					<button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
          <div style="float: left;">
						<h6 class="modal-title" id="modal-ticket-title">Ticket ID </h6>
						<span id="ticketOperator"></span>
					</div>
					<div style="float: right;">
						<div>
							<span class="badge text-bg-secondary" id="ticketType" style="font-size: 15px;"></span>
							<span class="badge text-bg-secondary" id="ticketSeverity" style="font-size: 15px;"></span>
						</div>
						<div style="margin-top: 5px;">
							<span id="ticketLatestStatus" style="float:left;font-size: 12px;"></span> 
							<span class="badge badge-sm text-bg-secondary" style="float: right;" id="ticketStatus"></span>
						</div>
					</div>
					
				</div>
				<div class="modal-body">
					<form role="form">
						<input type="hidden" class="form-control" id="ticketID">
						<input type="hidden" class="form-control" id="ticketOpen">
						<div class="row" id="rowGeneral">
								<div class="col-sm-6">
									<div class="form-group">
										<label>ID ATM</label>
										<input type="text" class="form-control" id="ticketIDATM" disabled>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Serial Number</label>
										<input type="text" class="form-control" id="ticketSerial" style="display: none" disabled> 
										<textarea type="text" class="form-control" id="ticketSerialArea" rows="3" style="display: none" disabled></textarea> 
									</div>
								</div>
							</div>
							<div class="row" id="rowAbsen" style="display: none;" class="mt-2">
								<div class="col-sm-4">
									<div class="form-group">
										<label>IP Machine</label>
										<input type="text" class="form-control" id="ticketIPMachine" disabled>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>IP Server</label>
										<input type="text" class="form-control" id="ticketIPServer" disabled> 
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>Machine Type</label>
										<input type="text" class="form-control" id="ticketMachineType" disabled> 
									</div>
								</div>
							</div>
							<div class="form-group mt-2">
								<div class="form-group">
									<label>Problem</label>
									<input type="text" class="form-control" id="ticketProblem" disabled>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col-sm-6">
									<div class="form-group">
										<label>PIC</label>
										<input type="text" class="form-control" id="ticketPIC" disabled>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Location</label>
										<input type="text" class="form-control" id="ticketLocation" disabled>
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Number Ticket</label>
										<input type="text" class="form-control" id="ticketNumber">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Engineer</label>
										<input type="text" class="form-control" id="ticketEngineer">
									</div>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Severity <small class="text-danger">(change to edit)</small></label>
										<select class="form-control" id="inputTicketSeverity" style="width:100%!important" disabled><option></option></select>
									</div>
								</div>
							</div>
							<div class="form-group mt-2">
								<label>Activity</label>
								<ul id="ticketActivity" style="padding-left: 25px;">
								</ul>
							</div>
							<div class="form-group" id="ticketNoteUpdate">
								<label>Note Activity*</label>
								<textarea class="form-control" rows="1" id="ticketNote" style="resize:vertical;"></textarea>
							</div>
							<div class="form-group mt-2" style="display: none" id="ticketRoute" >
								<label>Root Cause</label>
								<textarea type="text" class="form-control" id="ticketRouteTxt"  disabled></textarea>
							</div>
							<div class="form-group mt-2" style="display: none" id="ticketCouter">
								<label>Counter Measure</label>
								<textarea type="text" class="form-control" id="ticketCouterTxt" disabled></textarea>
							</div>
						</form>
					</div>
					<div class="modal-footer d-flex align-items-center" style="width: 100%;">
					  <!-- Left buttons -->
					  <div class="d-flex align-items-right">
					    <!-- <button type="button" class="btn btn-sm btn-sm btn-secondary me-2" data-bs-dismiss="modal">Exit</button> -->
					    <button type="button" class="btn btn-sm btn-sm btn-danger me-2" style="font-size:12px" id="escalateButton">Escalate</button>
					    <button type="button" class="btn btn-sm btn-sm btn-info me-2" style="font-size:12px" id="reOpenButton" disabled>Re-Open Ticket</button>
					    <button type="button" class="btn btn-sm btn-sm btn-success me-2" style="font-size:12px" id="closeButton">Close</button>
					    <button type="button" class="btn btn-sm btn-sm btn-warning me-2" style="font-size:12px" id="pendingButton">Pending</button>
					    <button type="button" class="btn btn-sm btn-sm btn-dark me-2" style="font-size:12px" id="cancelButton">Cancel</button>
					    <button type="button" class="btn btn-sm btn-sm btn-primary" style="font-size:12px" id="updateButton">Update</button>
					  </div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Pricing Modal -->
  <div class="modal fade" id="pricingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-pricing">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <!-- Pricing Plans -->
          <div class="rounded-top">
            <h6 class="text-center mb-2">Pricing Plans</h6>
            <p class="text-center mb-0">
              All plans include 40+ advanced tools and features to boost your product. Choose the best plan
              to fit your needs.
            </p>
            <div class="d-flex align-items-center justify-content-center flex-wrap gap-2 pt-12 pb-4">
              <label class="switch switch-sm ms-sm-12 ps-sm-12 me-0">
                <span class="switch-label fs-6 text-body">Monthly</span>
                <input type="checkbox" class="switch-input price-duration-toggler" checked />
                <span class="switch-toggle-slider">
                  <span class="switch-on"></span>
                  <span class="switch-off"></span>
                </span>
                <span class="switch-label fs-6 text-body">Annually</span>
              </label>
              <div class="mt-n5 ms-n10 ml-2 mb-10 d-none d-sm-flex align-items-center gap-1">
                <img
                  src="../../assets/img/pages/pricing-arrow-light.png"
                  alt="arrow img"
                  class="scaleX-n1-rtl pt-1"
                  data-app-dark-img="pages/pricing-arrow-dark.png"
                  data-app-light-img="pages/pricing-arrow-light.png" />
                <span class="badge badge-sm text-bg-primary rounded-1 mb-2">Save up to 10%</span>
              </div>
            </div>

            <div class="row gy-6">
              <!-- Basic -->
              <div class="col-xl mb-md-0">
                <div class="card border rounded shadow-none">
                  <div class="card-body pt-12">
                    <div class="mt-3 mb-5 text-center">
                      <img
                        src="../../assets/img/icons/unicons/bookmark.png"
                        alt="Basic Image"
                        width="120" />
                    </div>
                    <h6 class="card-title text-center text-capitalize mb-1">Basic</h6>
                    <p class="text-center mb-5">A simple start for everyone</p>
                    <div class="text-center h-px-50">
                      <div class="d-flex justify-content-center">
                        <sup class="h6 text-body pricing-currency mt-2 mb-0 me-1">$</sup>
                        <h1 class="mb-0 text-primary">0</h1>
                        <sub class="h6 text-body pricing-duration mt-auto mb-1">/month</sub>
                      </div>
                    </div>

                    <ul class="list-group my-5 pt-9">
                      <li class="mb-4 d-flex align-items-center">
                        <span class="badge p-50 w-px-20 h-px-20 rounded-pill text-bg-primary me-2"
                          ><i class="bx bx-check bx-xs"></i></span
                        ><span>100 responses a month</span>
                      </li>
                      <li class="mb-4 d-flex align-items-center">
                        <span class="badge p-50 w-px-20 h-px-20 rounded-pill text-bg-primary me-2"
                          ><i class="bx bx-check bx-xs"></i></span
                        ><span>Unlimited forms and surveys</span>
                      </li>
                      <li class="mb-4 d-flex align-items-center">
                        <span class="badge p-50 w-px-20 h-px-20 rounded-pill text-bg-primary me-2"
                          ><i class="bx bx-check bx-xs"></i></span
                        ><span>Unlimited fields</span>
                      </li>
                      <li class="mb-4 d-flex align-items-center">
                        <span class="badge p-50 w-px-20 h-px-20 rounded-pill text-bg-primary me-2"
                          ><i class="bx bx-check bx-xs"></i></span
                        ><span>Basic form creation tools</span>
                      </li>
                      <li class="mb-0 d-flex align-items-center">
                        <span class="badge p-50 w-px-20 h-px-20 rounded-pill text-bg-primary me-2"
                          ><i class="bx bx-check bx-xs"></i></span
                        ><span>Up to 2 subdomains</span>
                      </li>
                    </ul>

                    <button
                      type="button"
                      class="btn btn-sm btn-text-bg-success d-grid w-100"
                      data-bs-dismiss="modal">
                      Your Current Plan
                    </button>
                  </div>
                </div>
              </div>

              <!-- Pro -->
              <div class="col-xl mb-md-0">
                <div class="card border-primary border shadow-none">
                  <div class="card-body position-relative pt-4">
                    <div class="position-absolute end-0 me-5 top-0 mt-4">
                      <span class="badge text-bg-primary rounded-1">Popular</span>
                    </div>
                    <div class="my-5 pt-6 text-center">
                      <img
                        src="../../assets/img/icons/unicons/wallet-round.png"
                        alt="Pro Image"
                        width="120" />
                    </div>
                    <h6 class="card-title text-center text-capitalize mb-1">Standard</h6>
                    <p class="text-center mb-5">For small to medium businesses</p>
                    <div class="text-center h-px-50">
                      <div class="d-flex justify-content-center">
                        <sup class="h6 text-body pricing-currency mt-2 mb-0 me-1">$</sup>
                        <h1 class="price-toggle price-yearly text-primary mb-0">7</h1>
                        <h1 class="price-toggle price-monthly text-primary mb-0 d-none">9</h1>
                        <sub class="h6 text-body pricing-duration mt-auto mb-1">/month</sub>
                      </div>
                      <small class="price-yearly price-yearly-toggle text-muted">USD 480 / year</small>
                    </div>

                    <ul class="list-group my-5 pt-9">
                      <li class="mb-4 d-flex align-items-center">
                        <span class="badge p-50 w-px-20 h-px-20 rounded-pill text-bg-primary me-2"
                          ><i class="bx bx-check bx-xs"></i></span
                        ><span>Unlimited responses</span>
                      </li>
                      <li class="mb-4 d-flex align-items-center">
                        <span class="badge p-50 w-px-20 h-px-20 rounded-pill text-bg-primary me-2"
                          ><i class="bx bx-check bx-xs"></i></span
                        ><span>Unlimited forms and surveys</span>
                      </li>
                      <li class="mb-4 d-flex align-items-center">
                        <span class="badge p-50 w-px-20 h-px-20 rounded-pill text-bg-primary me-2"
                          ><i class="bx bx-check bx-xs"></i></span
                        ><span>Instagram profile page</span>
                      </li>
                      <li class="mb-4 d-flex align-items-center">
                        <span class="badge p-50 w-px-20 h-px-20 rounded-pill text-bg-primary me-2"
                          ><i class="bx bx-check bx-xs"></i></span
                        ><span>Google Docs integration</span>
                      </li>
                      <li class="mb-0 d-flex align-items-center">
                        <span class="badge p-50 w-px-20 h-px-20 rounded-pill text-bg-primary me-2"
                          ><i class="bx bx-check bx-xs"></i></span
                        ><span>Custom “Thank you” page</span>
                      </li>
                    </ul>

                    <button type="button" class="btn btn-sm btn-primary d-grid w-100" data-bs-dismiss="modal">
                      Upgrade
                    </button>
                  </div>
                </div>
              </div>

              <!-- Enterprise -->
              <div class="col-xl">
                <div class="card border rounded shadow-none">
                  <div class="card-body pt-12">
                    <div class="mt-3 mb-5 text-center">
                      <img
                        src="../../assets/img/icons/unicons/briefcase-round.png"
                        alt="Pro Image"
                        width="120" />
                    </div>
                    <h6 class="card-title text-center text-capitalize mb-1">Enterprise</h6>
                    <p class="text-center mb-5">Solution for big organizations</p>

                    <div class="text-center h-px-50">
                      <div class="d-flex justify-content-center">
                        <sup class="h6 text-body pricing-currency mt-2 mb-0 me-1">$</sup>
                        <h1 class="price-toggle price-yearly text-primary mb-0">16</h1>
                        <h1 class="price-toggle price-monthly text-primary mb-0 d-none">19</h1>
                        <sub class="h6 text-body pricing-duration mt-auto mb-1">/month</sub>
                      </div>
                      <small class="price-yearly price-yearly-toggle text-muted">USD 960 / year</small>
                    </div>

                    <ul class="list-group my-5 pt-9">
                      <li class="mb-4 d-flex align-items-center">
                        <span class="badge p-50 w-px-20 h-px-20 rounded-pill text-bg-primary me-2"
                          ><i class="bx bx-check bx-xs"></i></span
                        ><span>PayPal payments</span>
                      </li>
                      <li class="mb-4 d-flex align-items-center">
                        <span class="badge p-50 w-px-20 h-px-20 rounded-pill text-bg-primary me-2"
                          ><i class="bx bx-check bx-xs"></i></span
                        ><span>Logic Jumps</span>
                      </li>
                      <li class="mb-4 d-flex align-items-center">
                        <span class="badge p-50 w-px-20 h-px-20 rounded-pill text-bg-primary me-2"
                          ><i class="bx bx-check bx-xs"></i></span
                        ><span>File upload with 5GB storage</span>
                      </li>
                      <li class="mb-4 d-flex align-items-center">
                        <span class="badge p-50 w-px-20 h-px-20 rounded-pill text-bg-primary me-2"
                          ><i class="bx bx-check bx-xs"></i></span
                        ><span>Custom domain support</span>
                      </li>
                      <li class="mb-0 d-flex align-items-center">
                        <span class="badge p-50 w-px-20 h-px-20 rounded-pill text-bg-primary me-2"
                          ><i class="bx bx-check bx-xs"></i></span
                        ><span>Stripe integration</span>
                      </li>
                    </ul>

                    <button
                      type="button"
                      class="btn btn-sm btn-label-primary d-grid w-100"
                      data-bs-dismiss="modal">
                      Upgrade
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--/ Pricing Plans -->
      </div>
    </div>
  </div>

	<div class="modal fade" id="modal-next-on-progress">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						
						</button>
						<h6 class="modal-title" id="modal-ticket-title">Send On Progress Ticket</h6>
					</div>
					<div class="modal-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Email To : 
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailTo" id="emailOnProgressTo">
								</div>
								<div class="col-sm-10 col-sm-offset-2 invalid-feedback" style="margin-bottom: 0px;">
									Enter the recipient of this on progress email!
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Email Cc :
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailCc" id="emailOnProgressCc">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Subject :
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailSubject" id="emailOnProgressSubject">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div contenteditable="true" class="form-control" style="height: 600px;overflow: auto;" id="bodyOnProgressMail">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<i class="btn btn-sm btn-flat btn-primary" id="sendOnProgressEmail"><i class="fa fa-envelope-o"></i> Send</i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-cancel">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						
						</button>
						<h6 class="modal-title" id="modal-ticket-title">Cancel Ticket</h6>
					</div>
					<div class="modal-body">
						<form role="form">
							<div class="form-group">
								<label>Reason</label>
								<textarea type="text" class="form-control" id="saveReasonCancel"></textarea>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-flat text-bg-primary " onclick="prepareCancelEmail()">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-close-pending">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						
						</button>
						<h6 class="modal-title" id="modal-ticket-title">Update Progress before Close</h6>
					</div>
					<div class="modal-body">
						<form role="form">
							<div class="form-group">
								<label>Note*</label>
								<textarea type="text" class="form-control" id="saveNotePendingClose"></textarea>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Duration</label>
										<div class="input-group">
											<input type="text" class="form-control timepicker" id="durationPicker">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
										</div>
									</div>
								</div>
					<!-- 			<div class="col-sm-4">
									<div class="bootstrap-timepicker">
										<div class="form-group">
											<label>Start Time*</label>
											<div class="input-group">
												<input type="text" class="form-control timepicker" id="startTimePendingClose">
												<div class="input-group-addon">
													<i class="fa fa-clock-o"></i>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="bootstrap-timepicker">
										<div class="form-group">
											<label>End Time*</label>
											<div class="input-group">
												<input type="text" class="form-control timepicker" id="endTimePendingClose">
												<div class="input-group-addon">
													<i class="fa fa-clock-o"></i>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>Date*</label>
										<div class="input-group date">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<input type="text" class="form-control pull-right" id="datePendingClose">
										</div>
									</div>
								</div> -->
							</div>							
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-flat btn-primary" id="btnPendingClose">Update</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-next-cancel">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						
						</button>
						<h6 class="modal-title" id="modal-ticket-title">Send Cancel Ticket </h6>
					</div>
					<div class="modal-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Email To : 
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailTo" id="emailCancelTo">
								</div>
								<div class="col-sm-10 col-sm-offset-2 invalid-feedback" style="margin-bottom: 0px;">
									Enter the recipient of this cancel email!
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Email Cc :
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailCc" id="emailCancelCc">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Subject :
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailSubject" id="emailCancelSubject">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div contenteditable="true" class="form-control" style="height: 600px;overflow: auto;" id="bodyCancelMail">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<i class="btn btn-sm btn-flat btn-primary" onclick="sendCancelEmail()"><i class="fa fa-envelope-o"></i> Send</i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-pending">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						</button>
						<h6 class="modal-title" id="modal-ticket-title">Pending Ticket</h6>
					</div>
					<div class="modal-body">
						<form role="form">
							<div class="form-group" id="labelPendingReason">
								<label>Reason</label>
								<textarea type="text" class="form-control" id="saveReasonPending"></textarea>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group" style="margin-bottom: 0;" id="labelPendingEstimation">
										<label class="control-label">Estimation pending</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<div class="input-group date">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<input type="text" class="form-control pull-right" id="datePending">
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="bootstrap-timepicker">
										<div class="form-group">
											<div class="input-group">
												<input type="text" class="form-control" id="timePending">

												<div class="input-group-addon">
													<i class="fa fa-clock-o"></i>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row" style="display: none" id="estimationPendingHolder">
								<div class="col-sm-12">
									<p>
										The pending estimate for this ticket has been set to the previous pending on 
										<br><b id="estimationPendingText"></b>
									</p>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-flat btn-warning" onclick="preparePendingEmail()">Pending</button>
						<button type="button" id="updatePendingBtn" class="btn btn-sm btn-flat btn-primary pull-left" onclick="updatePending()">Update Pending</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-next-pending">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						</button>
						<h6 class="modal-title" id="modal-ticket-title">Send Pending Ticket </h6>
					</div>
					<div class="modal-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Email To : 
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailTo" id="emailPendingTo">
								</div>
								<div class="col-sm-10 col-sm-offset-2 invalid-feedback" style="margin-bottom: 0px;">
									Enter the recipient of this pending email!
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Email Cc :
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailCc" id="emailPendingCc">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Subject :
								</label>
								<div class="col-sm-10">
									<input class="form-control" name="emailSubject" id="emailPendingSubject">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div contenteditable="true" class="form-control" style="height: 600px;overflow: auto;" id="bodyPendingMail">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="pull-right">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<i class="btn btn-sm btn-flat btn-primary" onclick="sendPendingEmail()"><i class="fa fa-envelope-o"></i> Send</i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-close">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						
						<h6 class="modal-title" id="modal-ticket-title">Close Ticket </h6>
					</div>
					<div class="modal-body">
						<form role="form">
							<div class="form-group">
								<label>Root Cause</label>
								<textarea type="text" class="form-control" id="saveCloseRoute"></textarea>
							</div>
							<div class="form-group">
								<label>Counter Measure</label>
								<textarea type="text" class="form-control" id="saveCloseCouter"></textarea>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="bootstrap-timepicker">
										<div class="form-group">
											<label>Time</label>

											<div class="input-group">
												<input type="text" class="form-control timepicker" id="timeClose">

												<div class="input-group-addon">
													<i class="fa fa-clock-o"></i>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Date</label>

										<div class="input-group date">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<input type="text" class="form-control pull-right" id="dateClose">
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-flat btn-success " onclick="prepareCloseEmail()">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-next-close">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						</button>
						<h6 class="modal-title" id="modal-ticket-title">Send Close Ticket</h6>
					</div>
					<div class="modal-body">
						<div class="form-horizontal">
							<div class="form-group">
								<div class="row">
									<label class="col-sm-2 control-label">
										Email To : 
									</label>
									<div class="col-sm-10">
										<input class="form-control" name="emailTo" id="emailCloseTo">
									</div>
								</div>
								<div class="col-sm-10 col-sm-offset-2 invalid-feedback" style="margin-bottom: 0px;">
									Enter the recipient of this close email!
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="col-sm-2 control-label">
										Email Cc :
									</label>
									<div class="col-sm-10">
										<input class="form-control" name="emailCc" id="emailCloseCc">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="col-sm-2 control-label">
										Subject :
									</label>
									<div class="col-sm-10">
										<input class="form-control" name="emailSubject" id="emailCloseSubject">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div contenteditable="true" class="form-control" style="height: 600px;overflow: auto;" id="bodyCloseMail">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="pull-right">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<i class="btn btn-sm btn-flat btn-primary" onclick="sendCloseEmail()"><i class="fa fa-envelope-o"></i> Send</i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-escalate">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						</button>
						
						<h6 class="modal-title" id="modal-ticket-title">Escalate Ticket </h6>
					</div>
					<div class="modal-body">
						<form role="form">
							<div class="form-group" >
								<!-- <label>Root Cause Analysis (RCA)</label> -->
								<label>Summary Case</label>
								<textarea type="text" class="form-control" id="escalateRCA" style="resize: vertical;"></textarea>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<label>Next Engineer</label>
									<p>For escalation, you must determine the next engineer who will work on this ticket.</p>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Name</label>
										<input type="text" class="form-control" id="escalateNameEngineer">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Contact (Phone)</label>
										<input type="text" class="form-control pull-right" id="escalateContactEngineer">
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-flat btn-danger" onclick="prepareEscalateEmail()">Escalate</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-next-escalate">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						</button>
						
						<h6 class="modal-title" id="modal-ticket-title">Mail Escalate Ticket</h6>
					</div>
					<div class="modal-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Email To : 
								</label>
								<div class="col-sm-10">
									<input class="form-control" id="emailEscalateTo">
								</div>
								<div class="col-sm-10 col-sm-offset-2 invalid-feedback" style="margin-bottom: 0px;">
									Enter the recipient of this escalate email!
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Email Cc :
								</label>
								<div class="col-sm-10">
									<input class="form-control" id="emailEscalateCc">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">
									Subject :
								</label>
								<div class="col-sm-10">
									<input class="form-control" id="emailEscalateSubject">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div contenteditable="true" class="form-control" style="height: 600px;overflow: auto;" id="bodyEscalateMail">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="pull-right">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<i class="btn btn-sm btn-flat btn-primary" onclick="sendEscalateEmail()"><i class="fa fa-envelope-o"></i> Send</i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- <div class="modal fade" id="modal-add-email">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					</button>
					<h6 class="modal-title"> Add Email </h6>
				</div>
				<div class="modal-body">
					<form role="form">
						<div class="form-group">
							<label>Client Title</label>
							<input type="text" class="form-control" id="clientTitleAdd">
						</div>
						<div class="form-group">
							<label>Client Acronym</label>
							<input type="text" class="form-control" id="clientAcronymAdd" style="text-transform:uppercase" maxlength="4">
						</div>
						<hr>
						<div class="form-group">
							<label>Open Dear</label>
							<input type="text" class="form-control" id="openDearAdd">
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Open To</label>
									<textarea class="form-control" rows="3" id="openToAdd"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Open Cc</label>
									<textarea class="form-control" rows="3" id="openCcAdd"></textarea>
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label>Close Dear</label>
							<input type="text" class="form-control" id="closeDearAdd">
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Close To</label>
									<textarea class="form-control" rows="3" id="closeToAdd"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Close Cc</label>
									<textarea class="form-control" rows="3" id="closeCcAdd"></textarea>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="form-group">
								<div class="col-sm-6">
									<label class="container">Banking
									  <input type="checkbox" id="bankingAdd">
									  <span class="checkmark"></span>
									</label>
									<label class="container">Wincor
									  <input type="checkbox" id="wincorAdd">
									  <span class="checkmark"></span>
									</label>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="saveClient('AddClient')">Save changes</button>
				</div>
			</div>
		</div>
	</div> -->

	<div class="modal fade" id="modal-add-email">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title"> Add Client Email Setting </h6>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          </button>
				</div>
				<div class="modal-body">
					<form role="form">
						<div class="form-group">
							<label>Project ID</label>
							<select type="text" class="form-control" id="selectPidforEmail" name="selectPidforEmail" style="width:100%!important"></select>
							<span class="invalid-feedback" style="display:none;color: red;"></span>
						</div>
						<div class="form-group">
							<label>Client</label>
							<input type="text" disabled class="form-control" id="inputClientforEmail" name="inputClientforEmail" autocomplete="off" value="">
						</div>
						<hr>
						<div class="form-group">
							<label>Dear</label>
							<input type="text" class="form-control" id="dearAdd">
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>To</label>
									<textarea class="form-control" rows="3" id="toAdd"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Cc</label>
									<textarea class="form-control" rows="3" id="ccAdd"></textarea>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="saveEmailbyPID('addEmail')">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<!-- <div class="modal fade" id="modal-setting-email">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					</button>
					<h6 class="modal-title" id="modal-setting-title">Change Setting for </h6>
				</div>
				<div class="modal-body">
					<form role="form">
						<input type="hidden" class="form-control" id="clientId">
						<div class="form-group">
							<label>Client Title</label>
							<input type="text" class="form-control" id="clientTitle">
						</div>
						<div class="form-group">
							<label>Client Acronym</label>
							<input type="text" class="form-control" id="clientAcronym">
						</div>
						<hr>
						<div class="form-group">
							<label>Open Dear</label>
							<input type="text" class="form-control" id="openDear">
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Open To</label>
									<textarea class="form-control" rows="3" id="openTo"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Open Cc</label>
									<textarea class="form-control" rows="3" id="openCc"></textarea>
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label>Close Dear</label>
							<input type="text" class="form-control" id="closeDear">
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Close To</label>
									<textarea class="form-control" rows="3" id="closeTo"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Close Cc</label>
									<textarea class="form-control" rows="3" id="closeCc"></textarea>
								</div>
							</div>
						</div>

						<hr>
						<div class="row">
							<div class="form-group">
								<div class="col-sm-6">
									<label class="container">Situation
									  <input type="checkbox" id="situation">
									  <span class="checkmark"></span>
									</label>
									<label class="container">Banking
									  <input type="checkbox" id="banking">
									  <span class="checkmark"></span>
									</label>
									<label class="container">Wincor
									  <input type="checkbox" id="wincor">
									  <span class="checkmark"></span>
									</label>
								</div>
							</div>
						</div>

					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="saveClient('EditClient')">Save changes</button>
				</div>
			</div>
		</div>
	</div> -->

	<div class="modal fade" id="modal-setting-email-client">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title modal-setting-title">Change Setting for </h6>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          </button>
				</div>
				<div class="modal-body">
					<form role="form">
						<div class="form-group">
							<input type="text" class="form-control" id="idEmailEdit" style="display:none;">

							<label>Project ID</label>
							<select class="form-control" style="width: 100%!important;" id="selectPidforEmailEdit" disabled></select>
							<span class="invalid-feedback" style="display:none;color: red;"></span>
						</div>
						<div class="form-group">
							<label>Client Acronym</label>
							<input type="text" class="form-control" id="inputClientforEmailEdit" disabled>
						</div>
						<hr>
						<div class="form-group">
							<label>Dear</label>
							<input type="text" class="form-control" id="dearEdit">
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>To</label>
									<textarea class="form-control" rows="3" id="toEdit"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Cc</label>
									<textarea class="form-control" rows="3" id="ccEdit"></textarea>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="saveEmailbyPID('editEmail')">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-add-slm-email">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title"> Add SLM Email Setting </h6>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          </button>
				</div>
				<div class="modal-body">
					<form role="form">
						<div class="form-group">
							<label>2nd Level Support</label>
							<select id="selectLevelSupport" name="selectLevelSupport" style="width:100%!important"></select>
							<span class="invalid-feedback" style="display:none;color: red;"></span>
						</div>
						<hr>
						<div class="form-group">
							<label>Dear</label>
							<input type="text" class="form-control" id="dearAddSlm">
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>To</label>
									<textarea class="form-control" rows="3" id="toAddSlm"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Cc</label>
									<textarea class="form-control" rows="3" id="ccAddSlm"></textarea>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary " data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="saveSlmEmail('addEmail')">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-setting-email-slm">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title modal-setting-title">Change Setting for </h6>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          </button>
				</div>
				<div class="modal-body">
					<form role="form">
						<div class="form-group">
							<input type="text" class="form-control" id="idSlmEdit" style="display:none;">

							<label>2nd Level Support</label>
							<select id="selectLevelSupportEdit" name="selectLevelSupportEdit" style="width:100%!important" disabled></select>
              <span class="invalid-feedback" style="display:none;color: red;"></span>
						</div>
						<hr>
						<div class="form-group">
							<label>Dear</label>
							<input type="text" class="form-control" id="dearSlmEdit">
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>To</label>
									<textarea class="form-control" rows="3" id="toSlmEdit"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Cc</label>
									<textarea class="form-control" rows="3" id="ccSlmEdit"></textarea>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="saveSlmEmail('editEmail')">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-setting-atm-add">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					
					</button>
					<h6 class="modal-title modal-setting-title">ATM Add</h6>
				</div>
				<div class="modal-body">
					<form role="form">
						<input type="hidden" id="idAddAtm">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Owner</label>
									<select class="form-control" id="atmAddOwner"></select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>ATM ID</label>
									<input type="text" class="form-control" id="atmAddID">
									<select class="form-control select2" id="ATMadd" style="width: 100%;display: none"></select>
								</div>
							</div>
						</div>
						<div id="atmAddForm">
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label>Serial Number</label>
										<input type="text" class="form-control" id="atmAddSerial">
									</div>
								</div>
								<div class="col-sm-8">
									<div class="form-group">
										<label>Location ATM</label>
										<input type="text" class="form-control" id="atmAddLocation">
									</div>
								</div>
							</div>
							<div class="row">
							    <div class="col-sm-4">
							        <div class="form-group">
							            <label>ATM Version</label>
							            <input type="text" class="form-control" id="atmAddVersion">
							        </div>
							    </div>
							    <div class="col-sm-8">
							        <div class="form-group">
							            <label>ATM OS</label>
							            <input type="text" class="form-control" id="atmAddOS">
							        </div>
							    </div>
							</div>
							<div class="form-group">
								<label>Machine Type</label>
								<input type="text" class="form-control" id="atmAddType">
							</div>
							<div class="form-group">
								<label>Address</label>
								<textarea type="text" class="form-control" id="atmAddAddress"></textarea>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label>Activation Date</label>
										<input type="text" class="form-control" id="atmAddActivation">
									</div>
								</div>
								<div class="col-sm-8">
									<div class="form-group">
										<label>Note</label>
										<input type="text" class="form-control" placeholder="ex : Kanwil II" id="atmAddNote">
									</div>
								</div>
							</div>
						</div>
						<div id="peripheralAddForm" style="display: none;">
							<div class="row">
								<!-- <div class="col-sm-4">
									<div class="form-group">
										<label>ID Peripheral</label>
										<input type="text" class="form-control" id="atmAddPeripheralID">
									</div>
								</div> -->
								<div class="col-sm-6">
									<div class="form-group">
										<label>Serial Number</label>
										<input type="text" class="form-control" id="atmAddPeripheralSerial">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Mechine Type</label>
										<input type="text" class="form-control" id="atmAddPeripheralType">
									</div>
								</div>
							</div>
						</div>
						<div id="peripheralAddFormCCTV" style="display: none;">
							<hr>
							<label>DVR</label>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Serial Number</label>
										<input type="text" class="form-control" id="atmAddPeripheralSerialCCTVDVR">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Mechine Type</label>
										<input type="text" class="form-control" id="atmAddPeripheralTypeCCTVDVR">
									</div>
								</div>
							</div>
							<label>CCTV Eksternal</label>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Serial Number</label>
										<input type="text" class="form-control" id="atmAddPeripheralSerialCCTVBesar">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Mechine Type</label>
										<input type="text" class="form-control" id="atmAddPeripheralTypeCCTVBesar">
									</div>
								</div>
							</div>
							<label>CCTV Internal</label>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Serial Number</label>
										<input type="text" class="form-control" id="atmAddPeripheralSerialCCTVKecil">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Mechine Type</label>
										<input type="text" class="form-control" id="atmAddPeripheralTypeCCTVKecil">
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="addAssignEngineer">Engineer</label>
									<select class="form-control assignEngineerAtm" name="addAssignEngineer" id="addAssignEngineer" style="width:100%!important"><option></option></select>
								</div>
							</div>
						</div>
						<!-- 
						<div class="form-group">
							<label>Serial Number</label>
							<input type="text" class="form-control" id="atmSerial2">
						</div>
						<div class="form-group">
							<label>Location ATM</label>
							<input type="text" class="form-control" id="atmLocation2">
						</div> -->
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-flat btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-flat btn-success" onclick="newPeripheral()" id="peripheralAddFormButton" style="display: none;">Add Peripheral</button>
					<button type="button" class="btn btn-sm btn-flat btn-primary" onclick="newAtm()" id="atmAddFormButton">Add</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-setting-atm">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					
					</button>
					<h6 class="modal-title modal-setting-title">Change ATM Detail</h6>
				</div>
				<div class="modal-body">
					<form role="form">
						<input type="hidden" id="idEditAtm">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Owner</label>
									<select class="form-control" id="atmEditOwner"></select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>ATM ID</label>
									<input type="text" class="form-control" id="atmEditID">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label>Serial Number</label>
									<input type="text" class="form-control" id="atmEditSerial">
								</div>
							</div>
							<div class="col-sm-8">
								<div class="form-group">
									<label>Location ATM</label>
									<input type="text" class="form-control" id="atmEditLocation">
								</div>
							</div>
						</div>
						<div class="row">
						    <div class="col-sm-4">
						        <div class="form-group">
						            <label>ATM Version</label>
						            <input type="text" class="form-control" id="atmEditVersion">
						        </div>
						    </div>
						    <div class="col-sm-8">
						        <div class="form-group">
						            <label>ATM OS</label>
						            <input type="text" class="form-control" id="atmEditOS">
						        </div>
						    </div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label>Mechine Type</label>
									<input type="text" class="form-control" id="atmEditType">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Address</label>
							<textarea type="text" class="form-control" id="atmEditAddress"></textarea>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label>Activation Date</label>
									<input type="text" class="form-control" id="atmEditActivation">
								</div>
							</div>
							<div class="col-sm-8">
								<div class="form-group">
									<label>Note</label>
									<input type="text" class="form-control" placeholder="ex : Kanwil II" id="atmEditNote">
								</div>
							</div>
						</div>
						<div id="atmEditPeripheral" style="display: none;">
							<div class="row">
								<div class="col-sm-12" >
									<div class="form-group">
										<label>ATM Peripheral</label>
										<ul id="atmEditPeripheralField">
										</ul>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="editAssignEngineer">Engineer</label>
									<select class="form-control assignEngineerAtm" name="editAssignEngineer" id="editAssignEngineer" style="width:100%!important"><option></option></select>
								</div>
							</div>							
						</div>
						<!-- <div class="form-group">
							<label>Serial Number</label>
							<input type="text" class="form-control" id="atmSerial">
						</div>
						<div class="form-group">
							<label>Location ATM</label>
							<input type="text" class="form-control" id="atmLocation">
						</div> -->
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-flat btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-flat btn-danger pull-left" onclick="deleteAtm()">Delete</button>
					<button type="button" class="btn btn-sm btn-flat btn-primary" onclick="saveAtm()">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-assign-engineer-atm">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					
					</button>
					<h6 class="modal-title">Assign Engineer ATM</h6>
				</div>
				<div class="modal-body">
					<form role="form">
						<div class="row listEngineerAssign">
							<div class="col-sm-5">
								<div class="form-group">
									<label>Engineer*</label>
									<select class="form-control assignEngineerAtm" style="width:100%!important" name="assignEngineerAtm"><option></option></select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>ATM Id*</label>
									<select class="form-control selectAssignAtmId" style="width:100%!important" name="selectAssignAtmId" multiple="multiple"></select>
								</div>
							</div>
							<div class="col-sm-0">
								<div class="form-group">
									<label>Action</label>
									<button class="btn btn-sm btn-flat btn-danger deleteRowAssign" style="width:40px" disabled><i class="fa fa-trash"></i></button>
								</div>
							</div>
						</div>
					</form>
					<div class="form-group">
						<button class="btn btn-sm text-bg-primary" style="margin:0 auto;display: block;" onclick="addRowAssignEngineerAtm()"><i class="fa fa-plus" style="margin-right:5px"></i>Assign</button>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-flat btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-flat btn-primary" onclick="submitAssignEngineerAtm()" id="atmAddFormButton">Save</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-setting-absen-add">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					
					</button>
					<h6 class="modal-title modal-setting-title">Absen Add</h6>
				</div>
				<div class="modal-body">
					<form role="form">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Nama Cabang</label>
									<input type="text" class="form-control" id="absenAddNamaCabang">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Nama Kantor</label>
									<input type="text" class="form-control" id="absenAddNamaKantor">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label>Machine Type</label>
									<input class="form-control" id="absenAddMachineType">
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label>IP Machine</label>
									<input type="text" class="form-control" id="absenAddIPMachine">
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label>IP Server</label>
									<input type="text" class="form-control" id="absenAddIPServer">
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-flat btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-flat btn-primary" onclick="newAbsen()" id="atmAddFormButton">Add</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-setting-absen">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					
					</button>
					<h6 class="modal-title modal-setting-title">Change Absen Detail</h6>
				</div>
				<div class="modal-body">
					<form role="form">
						<input type="hidden" id="idEditAbsen">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Nama Cabang</label>
									<input type="text" class="form-control" id="absenEditNamaCabang">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Nama Kantor</label>
									<input type="text" class="form-control" id="absenEditNamaKantor">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label>Machine Type</label>
									<input class="form-control" id="absenEditMachineType">
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label>IP Machine</label>
									<input type="text" class="form-control" id="absenEditIPMachine">
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label>IP Server</label>
									<input type="text" class="form-control" id="absenEditIPServer">
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-flat btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-flat btn-danger pull-left" onclick="deleteAbsen()">Delete</button>
					<button type="button" class="btn btn-sm btn-flat btn-primary" onclick="saveAbsen()">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-setting-switch-add">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					
					</button>
					<h6 class="modal-title modal-setting-title">Switch Add</h6>
				</div>
				<div class="modal-body">
					<form role="form">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Type Switch</label>
									<input type="text" class="form-control" id="switchAddType" placeholder="ex: Ruckus">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Port</label>
									<input type="text" class="form-control" id="switchAddPort" placeholder="24/48 Port">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Serial Number</label>
									<input class="form-control" id="switchAddSerialNumber" placeholder="FA123123">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>IP Management</label>
									<input type="text" class="form-control" id="switchAddIPManagement" placeholder="192.168.2.xxx">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Location</label>
									<input type="text" class="form-control" id="switchAddLocation" placeholder="Pekanbaru">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Cabang</label>
									<input type="text" class="form-control" id="switchAddCabang" placeholder="Simpang Empat">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label>Note</label>
									<input type="text" class="form-control" id="switchAddNote">
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-flat btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-flat btn-primary" onclick="newSwitch()" id="switchAddFormButton">Add</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-setting-switch">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					
					</button>
					<h6 class="modal-title modal-setting-title">Change Switch Detail</h6>
				</div>
				<div class="modal-body">
					<form role="form">
						<input type="hidden" id="idEditSwitch">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Type Switch</label>
									<input type="text" class="form-control" id="switchEditType" placeholder="ex: Ruckus">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Port</label>
									<input type="text" class="form-control" id="switchEditPort" placeholder="24/48 Port">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Serial Number</label>
									<input class="form-control" id="switchEditSerialNumber" placeholder="FA123123">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>IP Management</label>
									<input type="text" class="form-control" id="switchEditIPManagement" placeholder="192.168.2.xxx">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Location</label>
									<input type="text" class="form-control" id="switchEditLocation" placeholder="Pekanbaru">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Cabang</label>
									<input type="text" class="form-control" id="switchEditCabang" placeholder="Simpang Empat">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label>Note</label>
									<input type="text" class="form-control" id="switchEditNote">
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-flat btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-flat btn-danger pull-left" onclick="deleteSwitch()">Delete</button>
					<button type="button" class="btn btn-sm btn-flat btn-primary" onclick="saveSwitch()">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Start SLM Changes Modal Approval Pending and Modal Detail Trip Request  -->
	<div class="modal fade" id="modal-approval-pending">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" style="margin-left: 5px;">×</span>
					</button>
					<div class="modal-tools pull-right" style="text-align: right";>
						<div>
							<span class="badge text-bg-secondary" id="pendingTicketType" style="font-size: 15px;"></span>
							<span class="badge text-bg-secondary" id="pendingTicketSeverity" style="font-size: 15px;"></span>
						</div>
						<div style="margin-top: 5px;">
							<span id="pendingTicketLatestStatus"></span> 
							<span class="badge text-bg-secondary" id="pendingTicketStatus"></span>
						</div>
					</div>
					<div>
						<h6 class="modal-title" id="modal-ticket-title-pending">Ticket ID </h6>
					</div>
				</div>
				<div class="modal-body">
					<form role="form">
						<input type="hidden" class="form-control" id="pendingTicketID">
						<input type="hidden" class="form-control" id="pendingTicketOpen">
						<div class="row" id="rowGeneral">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Type</label>
									<input type="text" class="form-control" id="pendingType" disabled>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Estimated Pending</label>
									<input type="text" class="form-control" id="pendingEstimated" disabled> 
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Reason</label>
							<input type="text" class="form-control" id="pendingReason" disabled>
						</div>
						<div class="form-group">
							<label>Foto</label>
							<img src="" id="pendingPhoto" alt="">
							<p>Jika foto tidak tampil: <a href="" id="pendingPhotoURL" target="_blank">Lihat disini</a></p>
						</div>
						<div class="row" id="requestPart" style="display:none;">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Part Name</label>
									<input type="text" class="form-control" id="pendingPartName" disabled>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Image</label>
									<img src="" alt="Part Image" id="pendingPartImage">
									<p>Jika foto tidak tampil: <a href="" id="pendingPartImageURL" target="_blank">Lihat disini</a></p>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-flat btn-secondary pull-left" data-bs-dismiss="modal">Exit</button>
					<button type="button" class="btn btn-sm btn-flat btn-danger" id="rejectButton">Reject</button>
					<button type="button" class="btn btn-sm btn-flat btn-success" id="approveButton">Approve</button>
				</div>
			</div>
		</div>
	</div>

	<!-- <div class="modal fade" id="modal-detail-trip-request">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" style="margin-left: 5px;">×</span>
					</button>
					<div>
						<h6 class="modal-title" id="modal-title-trip-request">Trip Request </h6>
					</div>
				</div>
				<div class="modal-body">
				<div id="headerTripRequestContainer">
						<div class="form-group">
							<label for="">Type</label>
							<input type="text" class="form-control" name="typeTripRequest" id="typeTripRequest" disabled>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="">Start Date</label>
									<input type="text" class="form-control" name="startDateTripRequest" id="startDateTripRequest" disabled>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="">End Date</label>
									<input type="text" class="form-control" name="endDateTripRequest" id="endDateTripRequest" disabled>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="">From</label>
									<textarea name="" class="form-control" id="fromTripRequest" disabled></textarea>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="">To</label>
									<textarea name="" class="form-control" id="toTripRequest" disabled></textarea>
								</div>
							</div>
						</div>
					</div>

					<div class="card card-statistic-1 bg-secondary detailTripRequest">
						<div class="card-header">
							<span style="color: black; font-size: 16px; float: left;" >Transport Bus</span>
							<span style="color: black; font-size: 16px; float: right;">Rp. 900.000</span>
						</div>
						
					</div>

					

					<div id="detailTripRequestContainer" style="display: none;">
						<div class="form-group">
							<label for="request">Request</label>
							<input type="text" name="request" id="request" class="form-control" disabled>
						</div>
						<div class="form-group">
							<label for="nominal">Nominal</label>
							<input type="text" name="nominal" id="nominal" class="form-control" disabled>
						</div>
						<div class="form-group">
							<label for="">File </label>

							<label for="file" class="custom-file-upload">
							<div class="upload-icon">
								<i class="fas fa-cloud-upload-alt" id="uploadTextIcon"></i>
								<p id="uploadText" >File</p>
								<div id="previewContainer1" class="preview-container" style="display: none;">
									<img id="previewImage1" src="" alt="Preview Image 1" >
								</div>
								<div id="previewContainer2" class="preview-container" style="display: none;">
									<img id="previewImage2" src="" alt="Preview Image 2">
								</div>
								<button id="removeImageBtn" style="display: none;" class="btn btn-sm btn-danger btn-sm">Remove</button>
							</div>
							</label>
						</div>
						<div class="form-group">
						<input type="checkbox" name="rejectTripRequest" class="rejectTripRequest form-control" id="rejectTripRequest">Reject</input>
						</div>
					</div>

					<div class="row">
						<p>Log History</p>
						<div class="timeline">

						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-flat btn-secondary pull-left" data-bs-dismiss="modal">Exit</button>
					<button type="button" class="btn btn-sm btn-flat btn-danger" id="tripRequestRejectButton">Reject</button>
					<button type="button" class="btn btn-sm btn-flat btn-success" id="tripRequestApproveButton">Approve</button>
				</div>
			</div>
		</div>
	</div> -->
	<!-- End SLM Changes  -->
@endsection
@section('scriptImport')
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
<script src="{{asset('assets/js/extended-ui-blockui.js')}}" type="text/javascript"></script>
<!-- <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js" integrity="sha512-2xXe2z/uA+2SyT/sTSt9Uq4jDKsT0lV4evd3eoE/oxKih8DSAsOF6LUb+ncafMJPAimWAXdu9W+yMXGrCVOzQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>
<script src="{{asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js')}}" /></script>
<script src="{{asset('assets/vendor/js/jquery.emailinput.min.js')}}"></script>
<script src="{{asset('assets/vendor/js/roman.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/jquery.simplePagination.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
@endsection
@section('script')
<script type="text/javascript">
	var accesable = @json($feature_item);

	console.log($.fn.emailinput);
      
  accesable.forEach(function(item,index){
    $("#" + item).show()
  })

	var swalWithCustomClass

	$(document).ready(function(){
		initTablePerformance()
		// getTripRequestAll()
		// var hash = location.hash.replace(/^#/, '');
		// if (hash) {
		// 	$('.nav-tabs a[href="#' + hash + '"]').tab('show');
		// }

		if (window.location.href.split("?")[1] == "client") {
			$('a[href="#setting"]').tab('show')
			emailSetting()
		}else if (window.location.href.split("?")[1] == "Slm") {
			$('a[href="#setting"]').tab('show')
			SlmEmailSetting()
		}

		//$('#tableTripRequest').attr('style','display:none!important');

		// $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
		// 	var target = $(e.target).attr("href"); // Dapatkan target tab yang diklik

		// 	// Jika tab yang diklik adalah `#tripRequest`, tampilkan tabel
		// 	if (target === "#tripRequest") {
		// 		$('#tableTripRequest').fadeIn();  // Tampilkan tabel dengan efek fade
		// 	} else {
		// 		$('#tableTripRequest').attr('style','display:none!important');    // Sembunyikan tabel jika tab lain aktif
		// 	}
		// });

		$("#startDateFilter").val("")
		$("#endDateFilter").val("")
		getDashboard()

		// $("#inputReportingTime").val(moment().format('HH:mm:ss'))
		$("#inputReportingTime").timepicker({
			defaultTime: '00:00',
			startTime: '00:00',
			snapToStep: true,
			showInputs: false,
			minuteStep: 1,
			minTime: '00:00',
			maxHours: 24,
			showMeridian: false,
		});

		// $('#inputReportingDate').datepicker({
		// 	autoclose: true,
		// 	format: 'dd/mm/yyyy'
		// })

		// $('#inputReportingDate').flatpickr({
    //   monthSelectorType: 'static',
    //   // defaultDate: date,
    //   dateFormat: 'd/m/Y'
    // });

    flatpickr("#inputReportingDate", {
		  dateFormat: "d/m/Y",           // Show date as DD/MM/YYYY
		  monthSelectorType: "static",   // Static month dropdown (no scroll)
		  // defaultDate: "01/04/2025"   // Optional: uncomment and provide if needed
		});

		// $('#bodyOpenMail').slimScroll({
		// 	height: '600px'
		// });
		// $('#bodyCloseMail').slimScroll({
		// 	height: '600px'
		// });
		
		swalWithCustomClass = Swal.mixin({
			customClass: {
				confirmButton: 'btn btn-flat btn-primary swal2-margin',
				cancelButton: 'btn btn-flat btn-danger swal2-margin',
				denyButton: 'btn btn-flat btn-danger swal2-margin',
				popup: 'border-radius-0',
			},
			buttonsStyling: false,
		})

		$("#timePending").timepicker({
			defaultTime: '00:00',
			snapToStep: true,
			showInputs: false,
			minuteStep: 15,
			maxHours: 24,
			showMeridian: false,
		});

		// $("#startTimePendingClose").timepicker({
		// 	showInputs: false,
		// 	minuteStep: 1,
		// 	maxHours: 24,
		// 	showMeridian: false,
		// });

		// $("#endTimePendingClose").timepicker({
		// 	showInputs: false,
		// 	minuteStep: 1,
		// 	maxHours: 24,
		// 	showMeridian: false,
		// });

		$("#atmAddActivation, #atmEditActivation").inputmask("date");

		$('#searchBarTicket').keydown(function(e){
			// // if(e.keyCode == 13){
			// // }
			// if($('#searchBarTicket').val() == ""){
			// 	$("#tablePerformance").DataTable().ajax.reload()
			// } else {
				$("#tablePerformance").DataTable().search($('#searchBarTicket').val()).draw();
			// }
		});

		// $('#searchBarTicket').

		$('#searchBarEmail').keypress(function(e){
			if(e.keyCode == 13){
				console.log("sini le")
				if ($("#searchBarEmail").next(".input-group-btn").find("button.btn-primary").is(":visible")) {
					if ($("#searchBarEmail").closest('div').next("button.btn-primary:visible")[0].id  == 'addEmail') {
						$("#tableEmailSetting").DataTable().search($('#searchBarEmail').val()).draw();
					}else if ($("#searchBarEmail").closest('div').next("button.btn-primary:visible")[0].id  == 'addEmailSlm') {
						$("#tableSlmEmailSetting").DataTable().search($('#searchBarEmail').val()).draw();
					}else {
						$("#tableSlaSetting").DataTable().search($('#searchBarEmail').val()).draw();
					}
				}else{
					$("#tableSlaSetting").DataTable().search($('#searchBarEmail').val()).draw();
				}
			}
		});

		$('#searchBarATM').keypress(function(e){
			if(e.keyCode == 13){
				$("#tableAtm").DataTable().search($('#searchBarATM').val()).draw();
			}
		});

		$('#searchBarAbsen').keypress(function(e){
			if(e.keyCode == 13){
				$("#tableAbsen").DataTable().search($('#searchBarAbsen').val()).draw();
			}
		});

		$('#searchBarSwitch').keypress(function(e){
			if(e.keyCode == 13){
				$("#tableSwitch").DataTable().search($('#searchBarSwitch').val()).draw();
			}
		});

		// $('#applyFilterTablePerformance').click(function(){
		// 	$("#tablePerformance").DataTable().search($('#searchBarTicket').val()).draw();
		// })

		$('#applyFilterTableATM').click(function(){
			$("#tableAtm").DataTable().search($('#searchBarATM').val()).draw();
		})

		$('#applyFilterTableAbsen').click(function(){
			$("#tableAbsen").DataTable().search($('#searchBarAbsen').val()).draw();
		})

		$('#applyFilterTableSwitch').click(function(){
			$("#tableSwitch").DataTable().search($('#searchBarSwitch').val()).draw();
		})

		$('#applyFilterTableEmail').click(function(){
			if ($("#searchBarEmail").closest('div').next("button.btn-primary:visible")[0].id  == 'addEmail') {
				$("#tableEmailSetting").DataTable().search($('#searchBarEmail').val()).draw();
			}else if ($("#searchBarEmail").closest('div').next("button.btn-primary:visible")[0].id  == 'addEmailSlm') {
				$("#tableSlmEmailSetting").DataTable().search($('#searchBarEmail').val()).draw();
			}
		})

		$('#clearFilterTable').click(function(){
			$('#clientList').val([]).trigger('change'); 
			$('#typeFilter').val([]).trigger('change'); 
			$("#searchBarTicket").val('')
			$("#dateFilter").html("")
			$("#dateFilter").html("<i class='fa fa-calendar'></i> Date range picker <span><i class='fa fa-caret-down'></i></span>")			
			getPerformanceByFilter([],[],[],[])
		});

		$('#reloadTable').click(function(){
			getPerformanceByFilter([],[],[],[])	
		});

		$('#filterDashboardByClient').select2({
			allowClear: true,
      placeholder: 'Select Client',
      ajax: {
          url: '{{url("/ticketing/getClient")}}',
          dataType: 'json',
          delay: 250,
          processResults: function(data, params) {
              params.page = params.page || 1;
              return {
                  results: data,
                  pagination: {
                      more: (params.page * 10) < data.count_filtered
                  }
              };
          },
      }
    }).on('change', function(e) {
    		initiateFilterPid($(this).val())
    		var client = $(this).val()
    		var pid = ''

    		if ($("#filterDashboardByPid").val() == null) {
    			pid = pid
    		}else{
    			pid = $("#filterDashboardByPid").val()
    		}

		    var startDay 	= moment($("#filterDashboardByDate").data('daterangepicker').startDate).format("YYYY-MM-DD") 
				var endDay 		= moment($("#filterDashboardByDate").data('daterangepicker').endDate).format("YYYY-MM-DD") 
				getDashboardByFilter(client,pid,startDay,endDay)
		});

		if ($("#filterDashboardByClient").val() == "") {
			initiateFilterPid(code="")
		}

    function initiateFilterPid(code){
    	$('#filterDashboardByPid').empty('')

    	$('#filterDashboardByPid').select2({
				allowClear: true,
	      placeholder: 'Select Project ID',
	      ajax: {
	          url: '{{url("/ticketing/getPid")}}',
	          dataType: 'json',
	          delay: 250,
	          data: function (params) {
	            return {
	              code:code,
	              q:params.term
	            };
	          },
	          processResults: function(data, params) {
	              params.page = params.page || 1;
	              return {
	                  results: data,
	                  pagination: {
	                      more: (params.page * 10) < data.count_filtered
	                  }
	              };
	          },
	      }
	    }).on('change', function(e) {
	    		var pid = $(this).val()
	    		var client = $("#filterDashboardByClient").val()

	    		console.log($(this).val())
			    var startDay 	= moment($("#filterDashboardByDate").data('daterangepicker').startDate).format("YYYY-MM-DD") 
					var endDay 		= moment($("#filterDashboardByDate").data('daterangepicker').endDate).format("YYYY-MM-DD") 
					getDashboardByFilter(client,pid,startDay,endDay)
			});
    }		

    $('#filterDashboardByDate').daterangepicker({
      opens: 'center',
			ranges: {
				'Today'       : [moment(), moment()],
				'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month'  : [moment().startOf('month'), moment().endOf('month')],
				'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			startDate: moment().startOf('year'),
			endDate: moment().endOf('year')
		},
		function (start, end) {
			$('#filterDashboardByDate').html("")
			$('#filterDashboardByDate').html('<i class="fa fa-calendar"></i> <span>' + start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY') + '</span>');

			var pid = ''
			var startDay = start.format('YYYY-MM-DD');
			var endDay = end.format('YYYY-MM-DD');
			if ($("#filterDashboardByPid").val() != null) {
				pid = $("#filterDashboardByPid").val()
			}else{
				pid = pid
			}
			var client = $("#filterDashboardByClient").val()

			$("#startDateFilterDashboard").val(startDay)
			$("#endDateFilterDashboard").val(endDay)

			startDate = start.format('D MMMM YYYY');
			endDate = end.format('D MMMM YYYY');

			getDashboardByFilter(client,pid,startDay,endDay)
		});
	})
	
	function reinitializeDateRangePicker() {
			console.log("tesss")
      // Destroy existing Date Range Picker instance
      $('#filterDashboardByDate').data('daterangepicker').remove();
      $("#filterDashboardByDate").html("")
			$("#filterDashboardByDate").html("<i class='fa fa-calendar'></i> Date range picker <span><i class='fa fa-caret-down'></i></span>")	

      // Reinitialize Date Range Picker with new settings
      var startDay = '', endDay = '', pid = '', client = ''
      $('#filterDashboardByDate').daterangepicker({
          opens: 'center',
					ranges: {
						'Today'       : [moment(), moment()],
						'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
						'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
						'Last 30 Days': [moment().subtract(29, 'days'), moment()],
						'This Month'  : [moment().startOf('month'), moment().endOf('month')],
						'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
					},
					startDate: moment().subtract(29, 'days'),
					endDate: moment()
      },function(start,end){
      	startDay = start.format('YYYY-MM-DD');
				endDay = end.format('YYYY-MM-DD');
				if ($("#filterDashboardByPid").val() != null) {
					pid = $("#filterDashboardByPid").val()
				}else{
					pid = pid
				}
				client = $("#filterDashboardByClient").val()
      });

      getDashboardByFilter(client,pid,startDay,endDay)
  }

	function getDashboard(){
		$.ajax({
			type:"GET",
			url:"{{url('ticketing/getDashboard')}}",
			beforeSend:function(){
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
				$("#countCritical").text(result.counter_severity.Critical);
				$("#countMajor").text(result.counter_severity.Major);
				$("#countModerate").text(result.counter_severity.Moderate);
				$("#countMinor").text(result.counter_severity.Minor);

				var clientList = [{id:0,text:"Choose the client"}]

				$.each(result.customer_list,function(key,value){
					clientList.push({
						id:value.id,
						text:value.client_acronym + " - " + value.client_name
					})
				});

				$("#clientList").select2({data:clientList})

				var severityFilter = []

				$.each(result.severity_label,function(key,value){
					severityFilter.push({
						id:value.id,
						text:value.name
					})
				});

				var severityFilterAll = [
					{
						text:"Choose the Severity", 
						children:severityFilter
					},{
						text:"Choose the Type", 
						children:[
							{
								id:"TT",
								text:"TT - Trouble Ticket",
							},
							{
								id:"PM",
								text:"PM - Preventive Maintenance"
							},
							{
								id:"PL",
								text:"PL - Permintaan Layanan"
							},
							{
								id:"PP",
								text:"PP - Permintaan Penawaran"
							}
						]
					}
				]

				$("#severityFilter").select2({data:severityFilterAll})

				var typeFilter = [
					{
						id:"TT",
						text:"Trouble Ticket",
					},
					{
						id:"PM",
						text:"Preventive Maintenance"
					},
					{
						id:"PL",
						text:"Permintaan Layanan"
					},
					{
						id:"PP",
						text:"Permintaan Penawaran"
					}
				]

				$("#typeFilter").select2({data:typeFilter})

				// var appendSLaResponseTime = '';
				// $("#tb_sla_response_time").empty(appendSLaResponseTime)
				// $.each(result.response_time.data,function(key,value){
				// 	appendSLaResponseTime = appendSLaResponseTime + '<tr>';
				// 		appendSLaResponseTime = appendSLaResponseTime + '<td style="text-align: center;vertical-align: middle;border: solid 1px lightgray;">' + value.pid + '</td>';
				// 		appendSLaResponseTime = appendSLaResponseTime + '<td style="text-align: center;vertical-align: middle;border: solid 1px lightgray;">' + value.comply + '</td>';
				// 		appendSLaResponseTime = appendSLaResponseTime + '<td style="text-align: center;vertical-align: middle;border: solid 1px lightgray;">' + value.not_comply + '</td>';
				// 		appendSLaResponseTime = appendSLaResponseTime + '<td style="text-align: center;vertical-align: middle;border: solid 1px lightgray;">' + value.total + '</td>';
				// 	appendSLaResponseTime = appendSLaResponseTime + '</tr>';
				// });
				// $("#tb_sla_response_time").append(appendSLaResponseTime);

				// var appendSLaResolutionTime = '';
				// $("#tb_sla_resolution_time").empty(appendSLaResolutionTime)
				// $.each(result.resolution_time.data,function(key,value){
				// 	appendSLaResolutionTime = appendSLaResolutionTime + '<tr>'
				// 		appendSLaResolutionTime = appendSLaResolutionTime + '<td style="text-align: center;vertical-align: middle;border: solid 1px lightgray;">'+ value.pid +'</td>'
				// 		appendSLaResolutionTime = appendSLaResolutionTime + '<td style="text-align: center;vertical-align: middle;border: solid 1px lightgray;">'+ value.critical.comply +'</td>'
				// 		appendSLaResolutionTime = appendSLaResolutionTime + '<td style="text-align: center;vertical-align: middle;border: solid 1px lightgray;">'+ value.critical.not_comply +'</td>'
				// 		appendSLaResolutionTime = appendSLaResolutionTime + '<td style="text-align: center;vertical-align: middle;border: solid 1px lightgray;">'+ value.major.comply +'</td>'
				// 		appendSLaResolutionTime = appendSLaResolutionTime + '<td style="text-align: center;vertical-align: middle;border: solid 1px lightgray;">'+ value.major.not_comply  +'</td>'
				// 		appendSLaResolutionTime = appendSLaResolutionTime + '<td style="text-align: center;vertical-align: middle;border: solid 1px lightgray;">'+ value.moderate.comply +'</td>'
				// 		appendSLaResolutionTime = appendSLaResolutionTime + '<td style="text-align: center;vertical-align: middle;border: solid 1px lightgray;">'+ value.moderate.not_comply +'</td>'
				// 		appendSLaResolutionTime = appendSLaResolutionTime + '<td style="text-align: center;vertical-align: middle;border: solid 1px lightgray;">'+ value.minor.comply +'</td>'
				// 		appendSLaResolutionTime = appendSLaResolutionTime + '<td style="text-align: center;vertical-align: middle;border: solid 1px lightgray;">'+ value.minor.not_comply +'</td>'
				// 		appendSLaResolutionTime = appendSLaResolutionTime + '<td style="text-align: center;vertical-align: middle;border: solid 1px lightgray;">'+ value.total.comply +'</td>'
				// 		appendSLaResolutionTime = appendSLaResolutionTime + '<td style="text-align: center;vertical-align: middle;border: solid 1px lightgray;">'+ value.total.not_comply +'</td>'
				// 	appendSLaResolutionTime = appendSLaResolutionTime + '</tr>'
				// });
				
				// $("#tb_sla_resolution_time").append(appendSLaResolutionTime);

				// var config = {
				// 	type: 'doughnut',
				// 	data: {
				// 		labels: result.chart_data.label,
				// 		datasets: [{
				// 			data: result.chart_data.data,
				// 			backgroundColor: [
				// 			"#EA2027",
				// 			"#EE5A24",
				// 			"#F79F1F",
				// 			"#FFC312",
				// 			"#C4E538",
				// 			"#A3CB38",
				// 			"#009432",
				// 			"#006266",
				// 			"#1B1464",
				// 			"#0652DD",
				// 			// "#1289A7",
				// 			// "#12CBC4",
				// 			// "#FDA7DF",
				// 			// "#D980FA",
				// 			// "#9980FA",
				// 			// "#5758BB"
				// 			],
				// 		}]
				// 	},
				// 	options: {
				// 		responsive: true,
				// 		legend: {
				// 			position:'right',
				// 			display: true,
				// 			labels: {
				// 				generateLabels: function(chart) {
				// 					var data = chart.data;
				// 					if (data.labels.length && data.datasets.length) {
				// 						return data.labels.map(function(label, i) {
				// 							var meta = chart.getDatasetMeta(0);
				// 							var ds = data.datasets[0];
				// 							var arc = meta.data[i];
				// 							var custom = arc && arc.custom || {};
				// 							var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
				// 							var arcOpts = chart.options.elements.arc;
				// 							var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
				// 							var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
				// 							var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

				// 							// We get the value of the current label
				// 							var value = chart.config.data.datasets[arc._datasetIndex].data[arc._index];

				// 							return {
				// 								// Instead of `text: label,`
				// 								// We add the value to the string
				// 								text: label + " : " + value,
				// 								fillStyle: fill,
				// 								strokeStyle: stroke,
				// 								lineWidth: bw,
				// 								hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
				// 								index: i
				// 							};
				// 						});
				// 					} else {
				// 						return [];
				// 					}
				// 				}
				// 			}
				// 		}
				// 	},
				// 	centerText: {
				// 		display: true,
				// 		text: ""
				// 	}
				// };

				// var ctx = document.getElementById("pieChart").getContext("2d");
				// window.myDoughnut = new Chart(ctx, config);

				var hash = location.hash.replace(/^#/, '');
				if (hash) {
					$('.nav-tabs a[href="#' + hash + '"]').tab('show');
				}
			},
		});

		$.ajax({
			type:"GET",
			url:"{{url('/getDashboardByActivity')}}",
			success:function(result){
				$("#countOpen").text(result.counter_condition.OPEN);
				$("#countProgress").text(result.counter_condition.PROGRESS);
				$("#countPending").text(result.counter_condition.PENDING);
				$("#countClose").text(result.counter_condition.CLOSE);
				$("#countCancel").text(result.counter_condition.CANCEL); 
				$("#countAll").text(result.counter_condition.ALL);
			}
		})

		if ($("#filterDashboardByPid").val() == null) {
			pid = ''
		}else{
			pid = $("#filterDashboardByPid").val()
		}

		$.ajax({
			type:"GET",
			url:"{{url('/getDashboardNeedAttention')}}?pid=" + pid + "&start="+ moment().startOf('year').format('YYYY-MM-DD') + "&end=" + moment().endOf('year').format('YYYY-MM-DD'),
			beforeSend:function(){
				$("#importanTable").html("<tr><td colspan=7 style='text-align:center'>Loading...</td></tr>");
      },
			success:function(result){
				var append = '';
				$("#importanTable").empty(append);
				$.each(result.occurring_ticket,function(key,value){
					append = append + '<tr>';
						append = append + '<td>' + value.id_ticket + '</td>';
						append = append + '<td>' + value.id_atm + '</td>';
						append = append + '<td>' + value.location + '</td>';
						append = append + '<td>' + moment(value.date).format('D MMM HH:mm') + '</td>';

						if(value.severity == 1)
							append = append + '<td><span class="badge text-bg-danger">Critical</span></td>';
						else if (value.severity == 2)
							append = append + '<td><span class="badge" style="background-color:#e67e22 !important">Major</span></td>';
						else if (value.severity == 3)
							append = append + '<td><span class="badge" style="background-color:#f1c40f !important">Moderate</span></td>';
						else if (value.severity == 4)
							append = append + '<td><span class="badge text-bg-success">Minor</span></td>';
						else
							append = append + '<td><span class="badge text-bg-secondary">N/A</span></td>';

						if(value.activity == "OPEN")
							append = append + '<td><span class="badge text-bg-danger">' + value.activity + '</span></td>'
						else if(value.activity == "ON PROGRESS") 
							append = append + '<td><span class="badge text-bg-info">' + value.activity + '</span></td>'
						else if(value.activity == "PENDING") 
							append = append + '<td><span class="badge text-bg-warning">' + value.activity + '</span></td>'
						else if(value.activity == "CANCEL") 
							append = append + '<td><span class="badge text-bg-primary">' + value.activity + '</span></td>'
						else if(value.activity == "CLOSE") 
							append = append + '<td><span class="badge text-bg-success">' + value.activity + '</span></td>'
						
						append = append + '<td>' + value.operator + '</td>';
					append = append + '</tr>';
				});

				if (result.occurring_ticket.length > 1) {
					append = append + '<tr>'
						append = append + '<td colspan="7" class="text-center"><a onclick="getPerformanceByNeedAttention()" style="cursor:pointer">Show All</a></td>'
					append = append + '</tr>'
				}else{
					append = append + '<tr>'
						append = append + '<td colspan="7" class="text-center" style="color:gray">No Data Available in Table. . .</td>'
					append = append + '</tr>'
				}

				$("#importanTable").append(append);
			}
		})

		if (!$.fn.dataTable.isDataTable("#tb_sla_response_time")) {
		// if ($("#tb_sla_response_time").length) {
			$("#tb_sla_response_time").DataTable({
				"ajax":{
		        "type":"GET",
		        "url":"{{url('/getDashboardResponse')}}?start="+moment().startOf('year').format("YYYY-MM-DD")+"&end="+moment().endOf('year').format("YYYY-MM-DD")
		    },
		    "columns": [
		      { 
		        "data": "pid",
		        "className": "text-center" 
		      },
		      { 
		        "data": "comply",
		        "className": "text-center" 
		      },
		      {
		        "data": "not_comply",
		        "className": "text-center" 
		      },
		      {
		        "data": "total",
		        "className": "text-center" 
		      },
		    ],
		    "scrollX": true,
		    "pageLength": 10,
		    "order": []
			})
		}

		if (!$.fn.dataTable.isDataTable("#tb_sla_resolution_time")) {
		// if ($("#tb_sla_resolution_time").length) {
			$("#tb_sla_resolution_time").DataTable({
			  "ajax": {
			    "type": "GET",
			    "url": "{{ url('/getDashboardResolution') }}?start=" + moment().startOf('year').format("YYYY-MM-DD") + "&end=" + moment().endOf('year').format("YYYY-MM-DD"),
			    "dataSrc": function (json) {
			      if (!Array.isArray(json)) {
			        console.error("Invalid data:", json);
			        return [];
			      }
			      return json;
			    }
			  },
			  "columns": [
		      { 
		        "data": "pid",
		        "className": "text-center"
		      },
		      { 
		        "data": "critical.comply", 
		        "className": "text-center" 
		      },
		      { 
		        "data": "critical.not_comply", 
		        "className": "text-center"
		      },
		      { 
		        "data": "major.comply",
		        "className": "text-center" 
		      },
		      { 
		        "data": "major.not_comply",
		        "className": "text-center" 
		      },
		      { 
		        "data": "moderate.comply",
		        "className": "text-center" 
		      },
		      { 
		        "data": "moderate.not_comply",
		        "className": "text-center" 
		      },
		      { 
		        "data": "minor.comply",
		        "className": "text-center" 
		      },
		      { 
		        "data": "minor.not_comply",
		        "className": "text-center" 
		      },
		      { 
		        "data": "total.comply",
		        "className": "text-center" 
		      },
		      { 
		        "data": "total.not_comply",
		        "className": "text-center" 
		      },
		    ],
			  "aaSorting": [],
			  "scrollX": true,
			  "pageLength": 10,
			  "stateSave": false
			});
		}
	}

	function getDashboardByFilter(client,pid,start,end){
		$.ajax({
			type:"GET",
			url:"{{url('/getDashboardByFilter')}}",
			data:{
				client:client,
				pid:pid,
				start:start,
				end:end
			},
			success:function(result){
				$("#countCritical").text("-")
				$("#countCritical").text(result.counter_severity.Critical);
				$("#countMajor").text("-")
				$("#countMajor").text(result.counter_severity.Major);
				$("#countModerate").text("-")
				$("#countModerate").text(result.counter_severity.Moderate);
				$("#countMinor").text("-")
				$("#countMinor").text(result.counter_severity.Minor);

				var clientList = [{id:0,text:"Choose the client"}]

				$.each(result.customer_list,function(key,value){
					clientList.push({
						id:value.id,
						text:value.client_acronym + " - " + value.client_name
					})
				});

				$("#clientList").select2({data:clientList})

				var severityFilter = []

				$.each(result.severity_label,function(key,value){
					severityFilter.push({
						id:value.id,
						text:value.name
					})
				});

				var severityFilterAll = [
					{
						text:"Choose the Severity", 
						children:severityFilter
					},{
						text:"Choose the Type", 
						children:[
							{
								id:"TT",
								text:"TT - Trouble Ticket",
							},
							{
								id:"PM",
								text:"PM - Preventive Maintenance"
							},
							{
								id:"PL",
								text:"PL - Permintaan Layanan"
							},
							{
								id:"PP",
								text:"PP - Permintaan Penawaran"
							}
						]
					}
				]

				$("#severityFilter").select2({data:severityFilterAll})

				var typeFilter = [
					{
						id:"TT",
						text:"Trouble Ticket",
					},
					{
						id:"PM",
						text:"Preventive Maintenance"
					},
					{
						id:"PL",
						text:"Permintaan Layanan"
					},
					{
						id:"PP",
						text:"Permintaan Penawaran"
					}
				]

				$("#typeFilter").select2({data:typeFilter})

				var hash = location.hash.replace(/^#/, '');
				if (hash) {
					$('.nav-tabs a[href="#' + hash + '"]').tab('show');
				}
			},
		});

		$.ajax({
			type:"GET",
			url:"{{url('/getDashboardByActivity')}}",
			data:{
				client:client,
				pid:pid,
				start:start,
				end:end
			},
			success:function(result){
				$("#countOpen").text("-")
				$("#countOpen").text(result.counter_condition.OPEN);
				$("#countProgress").text("-")
				$("#countProgress").text(result.counter_condition.PROGRESS);
				$("#countPending").text("-")
				$("#countPending").text(result.counter_condition.PENDING);
				$("#countClose").text("-")
				$("#countClose").text(result.counter_condition.CLOSE);
				$("#countCancel").text("-")
				$("#countCancel").text(result.counter_condition.CANCEL); 
				$("#countAll").text("-")
				$("#countAll").text(result.counter_condition.ALL);
			}
		})

		$.ajax({
			type:"GET",
			url:"{{url('/getDashboardNeedAttention')}}",
			data:{
				client:client,
				pid:pid,
				start:start,
				end:end
			},
			success:function(result){
				var append = '';
				$("#importanTable").empty(append);
				$.each(result.occurring_ticket,function(key,value){
					append = append + '<tr>';
						append = append + '<td>' + value.id_ticket + '</td>';
						append = append + '<td>' + value.id_atm + '</td>';
						append = append + '<td>' + value.location + '</td>';
						append = append + '<td>' + moment(value.date).format('D MMM HH:mm') + '</td>';
						if(value.severity == 1)
							append = append + '<td><span class="badge text-bg-danger">Critical</span></td>';
						else if (value.severity == 2)
							append = append + '<td><span class="badge" style="background-color:#e67e22 !important">Major</span></td>';
						else if (value.severity == 3)
							append = append + '<td><span class="badge" style="background-color:#f1c40f !important">Moderate</span></td>';
						else if (value.severity == 4)
							append = append + '<td><span class="badge text-bg-success">Minor</span></td>';
						else
							append = append + '<td><span class="badge text-bg-secondary">N/A</span></td>';

						if(value.activity == "OPEN")
							append = append + '<td><span class="badge text-bg-danger">' + value.activity + '</span></td>'
						else if(value.activity == "ON PROGRESS") 
							append = append + '<td><span class="badge text-bg-info">' + value.activity + '</span></td>'
						else if(value.activity == "PENDING") 
							append = append + '<td><span class="badge text-bg-warning">' + value.activity + '</span></td>'
						else if(value.activity == "CANCEL") 
							append = append + '<td><span class="badge text-bg-primary">' + value.activity + '</span></td>'
						else if(value.activity == "CLOSE") 
							append = append + '<td><span class="badge text-bg-success">' + value.activity + '</span></td>'

						append = append + '<td>' + value.operator + '</td>';
					append = append + '</tr>';
				});

				if (result.occurring_ticket.length != 0) {
					append = append + '<tr>'
						append = append + '<td colspan="7" class="text-center"><a onclick="getPerformanceByNeedAttention()" style="cursor:pointer">Show All</a></td>'
					append = append + '</tr>'
				}
				
				$("#importanTable").append(append);
			}
		})

    $('#tb_sla_response_time').DataTable().ajax.url("{{url('/getDashboardResponse?pid=')}}"+pid+"&start="+start+"&end="+end+'&client='+client).load();

    $('#tb_sla_resolution_time').DataTable().ajax.url("{{url('/getDashboardResolution?pid=')}}"+pid+"&start="+start+"&end="+end+'&client='+client).load();
	}

	var whichPageFor = '', tabTrigger = ''
	tabTrigger = new bootstrap.Tab(document.querySelector('#performanceTab'));
	function getByStatus(activity){
		tabTrigger.show();		
		whichPageFor = 'activity'
		initTablePerformance('activity')
		changePerformance(whichPageFor,activity)
	}

	function getSeverity(severity){
		tabTrigger.show();		
		whichPageFor = 'severity'
		initTablePerformance('severity')
		changePerformance(whichPageFor,severity)
	}

	function getPerformanceByNeedAttention(){
		tabTrigger.show();		
		whichPageFor = 'attention'
		initTablePerformance('attention')
		changePerformance(whichPageFor,'attention')
	}

	function reserveIdTicket() {
		if("{Auth::check()}"){
			$("#formNewTicket").show();
			$("#createIdTicket").addClass('d-none');
			$("#typeDiv").show();
			$("#nomorDiv").show();
			$("#clientDiv").show();
			$("#pidDiv").show();
			$("#inputTypeTicket").val("")

			$.ajax({
				type:"GET",
				url:"{{url('ticketing/create/getReserveIdTicket')}}",
				success: function(result){
					$("#inputticket").val(result);
					$("#inputID").val(result);
					$("#inputDate").val(moment().format("DD-MMM-YY HH:mm"));
				},
			});
		} else {
			window.location('/login');
		}
	}

	var firstTimeTicket = 0;
	var clientBanking = 0;
	var clientWincor = 0;

	$("#inputClient").change(function(){
		if ($(this).val() != "") {
			showInputDetailTicket()
			var acronym_client = $("#inputClient option:selected").text().split(" - ")[0];	

			InitPID(acronym_client)
			$("#selectPID").attr("disabled",false)
			$("#selectCatAsset").attr("disabled",false)

    	if ($('#selectCatAsset').data("select2")) {
    		$('#selectCatAsset').select2('destroy');
    	}

      $('#selectCatAsset').empty();
      $('#selectCatAsset').append('<option></option>');
	    $('#selectCatAsset').val("");

	    $("div").removeClass('needs-validation')
			$(".invalid-feedback").attr('style','display:none!important')

			if ($("#inputATM").next().next(".invalid-feedback").next("a")) {
	    	$("#inputATM").next().next(".invalid-feedback").next("a").remove()
	    }

    	if ($('#inputATM').data("select2")) {
    		$('#inputATM').select2('destroy');
	      $('#inputATM').empty();
	      $('#inputATM').append('<option></option>');
    	}

			$("#inputATM").select2({
				ajax: {
	        url: '{{url("/ticketing/create/getAssetByClient")}}',
	        data: function (params) {
	          var query = {
	            q: params.term,
	            client:$("#inputClient").val()
	          }
	          // Query parameters will be ?search=[term]&type=public
	          return query;
	        },
	        processResults: function (data) {
	          // Transforms the top-level key of the response object from 'items' to 'results'
	          return {
	            results: data
	          };
	        },
	      },
	      placeholder: 'Select Asset',
	      allowClear:true
			});

			$("#inputATM").change(function(){
				if(this.value == ""){
					$("#inputLocation").val("");
					$("#inputATMAddres").val("");
					$("#inputSerial").val("");
					$("#inputType").val("");
					$("#inputSlm").val("");
					$("#slmDiv").attr('style','display:none!important');
					$("#selectPID").attr("disabled",false)
					$("#selectCatAsset").attr("disabled",true)
					$("#inputLocation").attr("disabled",false)
					InitPID(acronym_client)

					if ($("#inputATM").next().next(".invalid-feedback").next("a")) {
          	$("#inputATM").next().next(".invalid-feedback").next("a").remove()
          	$("div").removeClass('needs-validation')
						$(".invalid-feedback").attr('style','display:none!important')
          }
				} else {
					$.ajax({
						type:"GET",
						url:"{{url('ticketing/create/getDetailAsset')}}",
						data:{
							id_asset:this.value,
							client:$("#inputClient").val()
						},
						success: function(result){
							//trigger pid
							$("#selectPID").attr("disabled",true)
              var selectPID = $("#selectPID");
              var option = new Option(result.pid, result.pid, true, true);
              selectPID.append(option).trigger('change');

							//trigger asset category
							$("#selectCatAsset").attr("disabled",true)
							$("#selectCatAsset").empty()
              var selectCatAsset = $("#selectCatAsset");
              var option = new Option(result.category	, result.category, true, true);
              selectCatAsset.append(option).trigger('change');

							//isian bawah
							$("#inputLocation").val(result.alamat_lokasi);
							$("#inputType").val(result.type_device);
							$("#inputSerial").val(result.serial_number);
							$("#slmDiv").show();
							$("#inputSlm").val(result.second_level_support);
							// if($('#inputEngineerOpen').val() === null){
							// 	$("#inputEngineerOpen").val(result.engineer_atm);
							// }

							if ($('#inputEngineerOpen').val() == "") {
								if (Array.isArray(result.engineers) && result.engineers.length > 0 && (result.second_level_support === "SIP" || result.second_level_support === "SIP EOS")) {
									if (!$('#inputEngineerOpen').is('select')) {
										$('#inputEngineerOpen').replaceWith('<select class="form-control" id="inputEngineerOpen"></select>');
									}

									var selectEngineer = $('#inputEngineerOpen');
									selectEngineer.empty();
									selectEngineer.append(new Option('Choose Engineer', '',true))

									result.engineers.forEach(function(engineer) {
										selectEngineer.append(new Option(engineer.engineer_atm, engineer.engineer_atm));
									});

									// selectEngineer.val(result.engineer_atm);
								} else {
									if (!$('#inputEngineerOpen').is('input')) {
										$('#inputEngineerOpen').replaceWith('<input type="text" class="form-control" id="inputEngineerOpen" placeholder="" required value="">');
									}
								}
							}
							
							$("#inputLocation").attr("disabled",true)
							localStorage.setItem("id_device_customer",result.id_device_customer)

							console.log("siniii")
						},
						error: function(xhr, status, error) {
		          // Handle errors
		          $("#inputATM").addClass('needs-validation')
		          if ($("#inputATM").next().next(".invalid-feedback").next("a")) {
		          	$("#inputATM").next().next(".invalid-feedback").next("a").remove()
		          }

		          $("#selectPID").attr("disabled",false)
							$("#selectCatAsset").attr("disabled",true)
							InitPID(acronym_client)

		          $("#inputATM").closest("div").addClass('needs-validation')
							$("#inputATM").next().next(".invalid-feedback").show().text(xhr.responseJSON.data).after("<a href='{{url('/ticketing#setting?Slm')}}' target='_blank'>here</a>")
							$("#inputLocation").val("");
							$("#inputType").val("");
							$("#inputSerial").val("");
							$("#slmDiv").attr('style','display:none!important');
							$("#inputSlm").val("");
							$("#inputEngineerOpen").val("");
		        }
					});
				}
			});

			function InitPID(acronym_client){
				if(firstTimeTicket == 0){
					if (acronym_client == "INTERNAL") {
						acronym_client = "INTR"
					}else{
						acronym_client = acronym_client
					}
					
					$("#inputticket").val($("#inputticket").val() + "/" + acronym_client + moment().format("/MMM/YYYY"));
					if ($('#selectPID').data("select2")) {
		    		$('#selectPID').select2('destroy');
			      $('#selectPID').empty();
			      $('#selectPID').append('<option></option>');
		    	}

					$.ajax({
					type:"GET",
					url:"{{url('ticketing/create/getPidByPic')}}",
					data:{
						client_acronym:acronym_client
					},
					success: function(result){
						$("#selectPID").select2({
							placeholder:"Select Project ID",
							data:result
						}).change(function(){
							if ($(this).val() != "") {
								$.ajax({
									type:"GET",
									url:"{{url('ticketing/setting/checkPidReserve')}}",
									data:{
										pid:$(this).val()
									},success: function(result){
										if (result.data) {
											$.ajax({
												beforeSend: function(request) {
													request.setRequestHeader("Accept", "application/json");
												},
												type:"GET",
												url:"{{url('ticketing/create/setReserveIdTicket')}}",
												data:{
													id_ticket:$("#inputticket").val().trim(),
													acronym_client:acronym_client,
													id_client:$("#inputClient").val(),
													pid:$("#selectPID").val(),
													operator:"{{(Auth::check())?Auth::user()->name:'-'}}",
												}
											});
											$("#showInputDetailTicket").attr("disabled",false)
											if ($("#hrLine").next().is(":visible") == true) {
												getBankAtm(clientBanking)
											}else{
												showInputDetailTicket()
											}
										}else{
											$("#showInputDetailTicket").attr("disabled",true)
											Swal.fire({
					              title: "<strong>Oopzz!</strong>",
					              icon: "info",
					              allowOutsideClick: false,
												allowEscapeKey: false,
					              html: `
					                Please add Client Email Setting for this PID!
					              `,
					            }).then((result) => {
				                if (result.value) {
				                	 window.open('{{url("/ticketing#setting?client")}}', '_blank');
			                		$('#selectPID').select2('destroy');
										      $('#selectPID').empty();
										      $('#selectPID').append('<option></option>');
				                	$("#inputClient").val("").trigger("change")
													// $("#inputATMid").attr('style','display:none!important');
				         					// $('#hrLine').nextUntil('#createTicket').each(function() {
													//   $(this).attr('style','display:none!important')
													// });
													// $("#createTicket").attr('style','display:none!important')
				                }
				              })
										}
									}
								})
							}
						})
					}
					})
				} else {
					var temp = $("#inputticket").val().split('/')
					temp[1] = acronym_client
					var changeResult = temp.join('/')
					// clientBanking = result.banking
					// clientWincor = result.wincor
					$("#inputticket").val(changeResult);
					if ($('#selectPID').data("select2")) {
						$('#selectPID').select2('destroy');
		      	$('#selectPID').empty();
		      	$('#selectPID').append('<option></option>');
					}
					$.ajax({
						type:"GET",
						url:"{{url('ticketing/create/getPidByPic')}}",
						data:{
							client_acronym:acronym_client
						},
						success: function(result){
							$("#selectPID").select2({
								placeholder:"Select Project ID",
								data:result
							}).change(function(){
								if ($(this).val() != "") {		      
									$.ajax({
										type:"GET",
										url:"{{url('ticketing/setting/checkPidReserve')}}",
										data:{
											pid:$(this).val()
										},success: function(result){
											if (result.data) {
												$.ajax({
													type:"GET",
													url:"{{url('ticketing/create/putReserveIdTicket')}}",
													data:{
														id_ticket_before:$("#inputticket").val().trim(),
														id_ticket_after:changeResult,
														id_client:$("#inputClient").val(),
														pid:$("#selectPID").val(),
														acronym_client:acronym_client,
													}
												});
												$("#showInputDetailTicket").attr("disabled",false)
												if ($("#hrLine").next().is(":visible")) {
													getBankAtm(clientBanking)
												}else{
													showInputDetailTicket()
												}
											}else{
												$("#showInputDetailTicket").attr("disabled",true)
												Swal.fire({
						              title: "<strong>Oopzz!</strong>",
						              icon: "info",
						              allowOutsideClick: false,
	  											allowEscapeKey: false,
						              html: `
						                Please add Client Email Setting for this PID!
						              `,
						            }).then((result) => {
					                if (result.value) {
					                	window.open('{{url("/ticketing#setting?client")}}', '_blank');
				                		$('#selectPID').select2('destroy');
											      $('#selectPID').empty();
											      $('#selectPID').append('<option></option>');
					                  $("#inputClient").val("").trigger("change")
														// $("#inputATMid").attr('style','display:none!important');
					         					// $('#hrLine').nextUntil('#createTicket').each(function() {
														//     $(this).attr('style','display:none!important')
														// });
														// $("#createTicket").attr('style','display:none!important')
					                }
					              })
											}
										}
									})
								}
								
							})
						}
					})
				}
			}

			// $("#selectCatAsset").empty("")
			// $("#selectCatAsset").select2({
			// 	ajax: {
	  //       url: '{{url("/ticketing/create/getCategorybyAsset")}}',
	  //       data: function (params) {
	  //         var query = {
	  //           q: params.term,
	  //           id_asset:$("#inputATM").val()
	  //         }
	  //         // Query parameters will be ?search=[term]&type=public
	  //         return query;
	  //       },
	  //       processResults: function (data) {
	  //         // Transforms the top-level key of the response object from 'items' to 'results'
	  //         var results = data.map(function(item) {
	  //           return {
	  //               id: item.id,
	  //               text: item.text // Assuming the data has an attribute 'name'
	  //           };
	  //         });

	  //         // Trigger a custom event after processing results
	  //         $('#selectCatAsset').trigger('select2:data-loaded', [results]);

	  //         return {
	  //           results: data,
	  //         };
	  //       },
	  //     },
	  //     placeholder: 'Select Asset Category',
			// })
			
			// $("#selectCatAsset").empty("")
			// $("#selectCatAsset").select2({
			// 	ajax: {
	  //       url: '{{url("/ticketing/create/getCategorybyAsset")}}',
	  //       data: function (params) {
	  //         var query = {
	  //           q: params.term,
	  //           id_asset:$("#inputATM").val()
	  //         }
	  //         // Query parameters will be ?search=[term]&type=public
	  //         return query;
	  //       },
	  //       processResults: function (data) {
	  //         // Transforms the top-level key of the response object from 'items' to 'results'
	  //         var results = data.map(function(item) {
	  //           return {
	  //               id: item.id,
	  //               text: item.text // Assuming the data has an attribute 'name'
	  //           };
	  //         });

	  //         // Trigger a custom event after processing results
	  //         $('#selectCatAsset').trigger('select2:data-loaded', [results]);

	  //         return {
	  //           results: data,
	  //         };
	  //       },
	  //     },
	  //     placeholder: 'Select Asset Category',
			// }).change(function(){
			// 	if($("#hrLine").next().is(":visible")){
			// 		if ($(this).val() == "ATM" || $(this).val() == "CRM") {
			// 			$("#categoryDiv").show();
			// 		}
			// 	}

			// 	$("#inputATM").empty()
			// 	getBankAtm(clientBanking)
			// })

			if (acronym_client == "INTERNAL" || acronym_client == "ADMF") {
				$("#selectCatAsset").closest("div").prev("label").text("Asset Category")
			}else{
				$("#categoryDiv").attr('style','display:none!important');
			}

	    // $('#selectCatAsset').on('select2:data-loaded', function(e, data) {
	    //   if (data.length > 0) {
					// $("#selectCatAsset").closest("div").prev("label").text("Asset Category*")
	    //   } else {
	    //   	$("div").removeClass('needs-validation')
					// $(".invalid-feedback").attr('style','display:none!important')
					// $("#selectCatAsset").closest("div").prev("label").text("Asset Category")
	    //   }
	    // });

			// $("#selectCatAsset").select2('open');

			// if($("#inputSeverity").val() != "Choose the severity"){
			// 	showInputDetailTicket();
			// 	getBankAtm(clientBanking);
			// }

			firstTimeTicket = 1;
		}
	});

	$("#inputTypeTicket").change(function(){
		// $("#inputATMid").show();
		// $("#categoryDiv").show();
		$("#inputSeverity").attr("disabled",false)
		$("#problemDiv label").text("Problem*")
		$("#reportDiv label").text("Report Time*")
		$("#engineerDiv").attr('style','display:none!important');
		if($(this).val() == "Preventive Maintenance"){
			$("#inputSeverity").attr("enabled",true)
			prepareNewParameter()
			$("#problemDiv label").text("Activity*")
			$("#reportDiv label").text("Schedule PM*")
			$("#engineerDiv").show();
			$("#inputLocation").val("")
			$("#inputSerial").val("")
			$("#inputEngineerOpen").val("")
			$("#inputSeverity").closest("div").prev("label").text("Severity")

			showInputDetailTicket()
		} else if ($(this).val() == "Trouble Ticket") {
			prepareNewParameter()
			$("#engineerDiv").show();
			$("#inputLocation").val("")
			$("#inputSerial").val("")
			$("#inputEngineerOpen").val("")
			$("#inputSeverity").closest("div").prev("label").text("Severity*")

			showInputDetailTicket()
		} else if ($(this).val() == "Permintaan Layanan") {
			$("#problemDiv label").text("Activity*")
			if($("#inputSeverity option").length > 2) {
				$("#inputSeverity option")[1].remove()
				$("#inputSeverity option")[1].remove()
				$("#inputSeverity option")[1].remove()
			}
			$("#inputSeverity").closest("div").prev("label").text("Severity*")

		} else if ($(this).val() == "Permintaan Penawaran") {
			$("#inputSeverity").attr("enabled",true)
			prepareNewParameter()
			$("#engineerDiv").show();
			$("#inputLocation").val("")
			$("#inputSerial").val("")
			$("#inputEngineerOpen").val("")
			$("#inputSeverity").closest("div").prev("label").text("Severity")

			showInputDetailTicket()
		} else {
			prepareNewParameter()
		}
	})

	$("#inputSeverity").change(function(){
		showInputDetailTicket()
	});

	function showInputDetailTicket(){
		$("#hrLine").show();
		$("#hrLine2").show();
		$("#refrenceDiv").show();
		$("#picDiv").show();
		$("#contactDiv").show();
		$("#problemDiv").show();
		$("#locationDiv").show();
		$("#dateDiv").show();
		$("#noteDiv").show();
		$("#serialDiv").show();
		$("#reportDiv").show();
		// $("#slmDiv").attr('style','display:none!important');
		$("#inputRefrence").val("");
		$("#inputPIC").val("");
		$("#inputContact").val("");
		$("#inputProblem").val("");
		$("#inputLocation").val("");
		$("#inputSerial").val("");
		$("#inputSlm").val("");
		$("#inputReportingDate").val("");		
		$("#inputLocation").attr("disabled",false)

		$("#createTicket").show();
		var onclick = "createTicket(" + clientBanking + ")"
		$("#createTicket").attr("onclick",onclick);
		
		getBankAtm(clientBanking)

		if($("#inputTypeTicket").val() != "none"){
			//ngga kepake harusnyaa
			// if($("#inputClient option:selected").text().includes("Absensi")){
			// 	$("#serialDiv").attr('style','display:none!important');
			// 	$("#slmDiv").attr('style','display:none!important');
			// 	$("#inputSlm").val("");
			// 	$("#typeDiv").show();
			// 	$("#inputAbsenLocation").show();
			// 	$("#inputSwitchLocation").attr('style','display:none!important');
			// 	$("#inputLocation").remove();
			// 	$("#ipMechineDiv").show();
			// 	$("#ipServerDiv").show();
			// } 

			//ngga kepake harusnya
			// if($("#inputClient option:selected").text().includes("Switch")){
				// $("#serialDiv").attr('style','display:none!important');
				// $("#inputLocation").remove();
				// $("#typeDiv").show();
				// $("#inputAbsenLocation").show();
				// $("#ipMechineDiv").show();
				// $("#ipServerDiv").show();

				// $("#inputLocation").remove();
				// $("#typeDiv").show();
				// $("#inputSwitchLocation").show();
				// $("#inputAbsenLocation").attr('style','display:none!important');
				// $("#ipMechineDiv").show();
				// $("#slmDiv").attr('style','display:none!important')
				// $("#inputSlm").val("");
				// $("#ipServerDiv").show();
			// } 

			//ngga kepake harusnyaa
			// if(!$("#inputClient option:selected").text().includes("Switch") && !$("#inputClient option:selected").text().includes("Absensi")) {
			// 	$("#inputAbsenLocation").remove();
			// 	$("#inputSwitchLocation").remove();
			// 	$("#inputLocation").show();
			// }
		}
	}

	function createTicket(clientBanking){
		$("div").removeClass('needs-validation')
		$(".invalid-feedback").attr('style','display:none!important')

		if ($("#inputATM").next().next(".invalid-feedback").next("a")) {
    	$("#inputATM").next().next(".invalid-feedback").next("a").remove()
    }

		var inputAtmValue = $("#inputATM").val()
		if (inputAtmValue != null && inputAtmValue != "") {
			$("#inputATM").val(inputAtmValue).trigger("change")
		}		
		
		if ($("#inputTypeTicket").val() == "") {
		    console.log($("#inputPIC"));
		    $("#inputTypeTicket").closest("div").addClass('needs-validation');
		    $("#inputTypeTicket").next(".invalid-feedback").show();

		} else if ($("#inputClient").val() == "") {
		    console.log($("#inputPIC"));
		    $("#inputClient").closest("div").addClass('needs-validation');
		    $("#inputClient").next().next(".invalid-feedback").show();

		} else if ($("#inputSeverity").closest("div").prev("label").text().includes("*")) {
		    // Nested condition is now within the same `else if`
		    if ($("#inputSeverity").val() == "") {
		        $("#inputSeverity").closest("div").addClass('needs-validation');
		        $("#inputSeverity").next().next(".invalid-feedback").show();
		    }
		} 

		if ($("#selectPID").val() == "") {
		    $("#selectPID").closest("div").addClass('needs-validation');
		    $("#selectPID").next().next(".invalid-feedback").show();
		} else if ($("#selectCatAsset").closest("div").prev("label").text().includes("*")) {
			if ($("#selectCatAsset").val() == "" || $("#selectCatAsset").val() == null){
				$("#selectCatAsset").closest("div").addClass('needs-validation')
				$("#selectCatAsset").next().next(".invalid-feedback").show()
		  }
		} else if($("#inputPIC").val() == "" ){
			console.log($("#inputPIC"))
			$("#picDiv").addClass('needs-validation')
			$("#picDiv .col-sm-10 .invalid-feedback").show()
		} else if($("#inputContact").val() == "" ){
			$("#contactDiv").addClass('needs-validation')
			$("#contactDiv .col-sm-10 .invalid-feedback").show()
		} else if($("#inputProblem").val() == "" ){
			$("#problemDiv").addClass('needs-validation')
			$("#problemDiv .col-sm-10 .invalid-feedback").show()
		} 
		// else if($("#inputATMid").is(':visible') && $("#inputATM").val() == null){
		// 	$("#inputATMid").addClass('needs-validation')
		// 	$("#inputATMid .col-sm-10 .invalid-feedback").show()
		// } 
		else if($("#inputLocation").val() == "" ){
			$("#locationDiv").addClass('needs-validation')
			$("#locationDiv .col-sm-10 .invalid-feedback").show()
		} else if($("#inputReportingTime").val() == "" ){
			$("#reportDiv").addClass('needs-validation')
			$("#reportDiv .col-sm-5.firstReport .invalid-feedback").show()

			$("#inputReportingDate").css("border-color",'#d2d6de')
			$("#reportDiv .col-sm-5.secondReport .input-group .input-group-addon").css("border-color",'#d2d6de')
			$("#reportDiv .col-sm-5.secondReport .input-group .input-group-addon i").css("color",'#555')
		} else if($("#inputTypeTicket").val() != "Preventive Maintenance" && $("#inputTypeTicket").val() != "Permintaan Penawaran" && $("#inputSeverity").val() == "Choose the severity"){
			$("#inputSeverity").parent().parent().addClass('needs-validation')
			// $("#reportDiv").addClass('needs-validation')
			// $("#reportDiv .col-sm-5.secondReport .invalid-feedback").show()

			// $("#inputReportingTime").css("border-color",'#d2d6de')
			// $("#reportDiv .col-sm-5.firstReport .input-group .input-group-addon").css("border-color",'#d2d6de')
			// $("#reportDiv .col-sm-5.firstReport .input-group .input-group-addon i").css("color",'#555')
		} else if($("#inputReportingDate").val() == "" ){
			$("#reportDiv").addClass('needs-validation')
			$("#reportDiv .col-sm-5.secondReport .invalid-feedback").show()

			$("#inputReportingTime").css("border-color",'#d2d6de')
			$("#reportDiv .col-sm-5.firstReport .input-group .input-group-addon").css("border-color",'#d2d6de')
			$("#reportDiv .col-sm-5.firstReport .input-group .input-group-addon i").css("color",'#555')
		} else {
			$("div").removeClass('needs-validation')
		  $(".invalid-feedback").attr('style','display:none!important')

			$(".needs-validation").removeClass('needs-validation')
			var waktu = moment(($("#inputDate").val()), "DD-MMM-YY HH:mm").format("D MMMM YYYY");
			var waktu2 = moment(($("#inputDate").val()), "DD-MMM-YY HH:mm").format("HH:mm");
			var schedule_date = moment(($("#inputReportingTime").val() + " " + $("#inputReportingDate").val()), "HH:mm:ss DD/MM/YYYY ").format("D MMMM YYYY");
			var schedule_time = moment(($("#inputReportingTime").val() + " " + $("#inputReportingDate").val()), "HH:mm:ss DD/MM/YYYY ").format("HH:mm");

			if ($("div").hasClass('needs-validation')) {
				$("#tableTicket").attr('style','display:none!important');
			}else{
				$("#tableTicket").show();
			}
			$("#holderID").text($("#inputticket").val());
			$("#holderRefrence").text($("#inputRefrence").val());
			$("#holderCustomer").text($("#inputClient option:selected").text().split(" - ")[1]);
			$("#holderPIC").text($("#inputPIC").val());
			$("#holderContact").text($("#inputContact").val());
			$("#holderProblem").text($("#inputProblem").val());
			$("#holderLocation").text($("#inputLocation").val());
			$("#holderDate").text(waktu);
			$("#holderSerial").html($("#inputSerial").val());
			$("#holderType").html($("#inputType").val());
			
			// $("#holderRoot").text($("#inputticket").val();
			$("#holderNote").text($("#inputNote").val());
			$("#holderProblem").prev().text("Problem")
			$("#holderDate").parent().show()
			$("#holderEngineer").attr('style','display:none!important');
			$("#holderSeverity").parent().show()
			$("#holderStatus").prev().text("Status")
			$("#holderWaktu").prev().text("Time")

			if($("#inputTypeTicket").val() == "Preventive Maintenance"){
				$("#holderStatus").html("<b>" + waktu + "</b>");
				$("#holderWaktu").html("<b>" + waktu2 + "</b>");
				$("#holderEngineer").show();
				$("#holderEngineerOpen").html($("#inputEngineerOpen").val());
				$("#holderSeverity").text($("#inputSeverity").val());

				$("#holderProblem").prev().text("Activity")
				$("#holderStatus").prev().text("Date")
				$("#holderWaktu").prev().text("Time")
				$("#holderDate").parent().attr('style','display:none!important')
				$("#holderSeverity").parent().attr('style','display:none!important')
			} else if($("#inputTypeTicket").val() == "Permintaan Penawaran"){
				$("#holderStatus").html("<b>" + waktu + "</b>");
				$("#holderWaktu").html("<b>" + waktu2 + "</b>");
				$("#holderEngineer").show();
				$("#holderEngineerOpen").html($("#inputEngineerOpen").val());
				$("#holderSeverity").text($("#inputSeverity").val());

				$("#holderProblem").prev().text("Activity")
				$("#holderStatus").prev().text("Date")
				$("#holderWaktu").prev().text("Time")
				$("#holderDate").parent().attr('style','display:none!important')
				$("#holderSeverity").parent().attr('style','display:none!important')
			} else {
				if($("#inputTypeTicket").val() == "Permintaan Layanan"){
					$("#holderProblem").prev().text("Activity")
				}
				$("#holderSeverity").text($("#inputSeverity").val());
				$("#holderStatus").html("<b>OPEN</b>");
				$("#holderWaktu").html("<b>" + waktu2 + "</b>");
			}

			if(clientBanking){
				if($("#inputClient option:selected").text().includes("CCTV")){
					$("#holderIDATM2").insertAfter($("#holderIDATM2").next())
					$("#holderIDATM2").show();
					$("#holderIDATM3").show();

					$("#holderSerial").html($("#inputSerial").val());
					$("#holderType").html($("#inputType").val());
					$("#holderType").html($("#inputType").val());

					$("#holderSerial1 th").text("CCTV Serial")
					// $("#holderIDATM2 th").text("ID CCTV")
					$("#holderIDATM3 th").text("CCTV Mechine Type")
					$("#holderIDATM").text($("#inputATM").select2('data')[0].text.split(' -')[0]);
				} if($("#inputClient option:selected").text().includes("UPS")){
					$("#holderIDATM2").insertAfter($("#holderIDATM2").next())
					$("#holderIDATM2").show();
					$("#holderIDATM3").show();

					$("#holderSerial").html($("#inputSerial").val());
					$("#holderType").html($("#inputType").val());
					$("#holderType").html($("#inputType").val());

					$("#holderSerial1 th").text("UPS Serial")
					// $("#holderIDATM2 th").text("ID UPS")
					$("#holderIDATM3 th").text("UPS Mechine Type")
					$("#holderIDATM").text($("#inputATM").select2('data')[0].text.split(' -')[0]);
				} else {
					$("#holderIDATM2").show();
					$("#holderIDATM3").show();
					$("#holderIDATM").text($("#inputATM").select2('data')[0].text.split(' -')[0]);
					$("#holderType").html($("#inputType").val());
				}
			} else {

				if($("#inputClient option:selected").text().includes("Absensi")){
					$("#holderIDATM2").attr('style','display:none!important');
					$("#holderSerial1").attr('style','display:none!important');
					$("#holderIDATM3").show();
					$("#holderIPMechine").show();
					$("#holderIPMechine2").text($("#inputIpMechine").val());
					$("#holderIPServer").show();
					$("#holderIPServer2").text($("#inputIpServer").val());
					$("#holderLocation").text($("#inputAbsenLocation").select2('data')[0].text);
				} else if($("#inputClient option:selected").text().includes("Switch")){
					$("#holderIDATM2").attr('style','display:none!important');
					$("#holderSerial1").show();
					$("#holderIDATM3").show();
					$("#holderIPMechine").show();
					$("#holderIPMechine2").text($("#inputIpMechine").val());
					// $("#holderIPServer").show();
					// $("#holderIPServer2").text($("#inputIpServer").val());
					$("#holderLocation").text($("#inputSwitchLocation").select2('data')[0].text);
				} else {
					$("#holderIDATM2").attr('style','display:none!important');
					$("#holderIDATM3").attr('style','display:none!important');
				}
			}
			// if(clientWincor == 1){
			// 	$("#createEmailBodyWincor").show()
			// 	$("#createEmailBodyNormal").attr('style','display:none!important')
			// } else {
			// 	$("#createEmailBodyWincor").attr('style','display:none!important')
			// 	$("#createEmailBodyNormal").show()
			// }
		}
	}

	function clearFormNewTicket(){
		$("#inputRefrence").val('');
		$("#inputPIC").val('');
		$("#inputContact").val('');
		$("#inputCategory").val('');
		$("#inputProblem").val('');
		if ($('#inputATM').hasClass("select2-hidden-accessible")) {
			$("#inputATM").select2('destroy');
		}
		$("#inputATM").empty()
		$("#inputLocation").val('');
		$("#inputSerial").val('');
		$("#inputEngineerOpen").val('');
		// $("#inputReportingTime").val('');
		$("#inputReportingTime").val(moment().format('HH:mm:ss'))
		$("#inputReportingDate").val('');
		$("#inputDate").val('');
		$("#inputNote").val('');
		$("#typeDiv").attr('style','display:none!important')
		$("#hrLine").show();
		$("#hrLine2").show();

		$("#nomorDiv").attr('style','display:none!important')
		$("#clientDiv").attr('style','display:none!important')
		$("#pidDiv").attr('style','display:none!important')
		$("#refrenceDiv").attr('style','display:none!important')
		$("#picDiv").attr('style','display:none!important')
		$("#contactDiv").attr('style','display:none!important')
		$("#categoryDiv").attr('style','display:none!important')
		$("#problemDiv").attr('style','display:none!important')
		$("#inputATMid").attr('style','display:none!important')
		$("#locationDiv").attr('style','display:none!important')
		$("#serialDiv").attr('style','display:none!important')
		$("#engineerDiv").attr('style','display:none!important')
		$("#typeDiv").attr('style','display:none!important')
		$("#reportDiv").attr('style','display:none!important')
		$("#dateDiv").attr('style','display:none!important')
		$("#noteDiv").attr('style','display:none!important')
		$("#createTicket").attr('style','display:none!important')

		$("#holderID").text('');
		$("#holderRefrence").text('');
		$("#holderCustomer").text('');
		$("#holderPIC").text('');
		$("#holderContact").text('');
		$("#holderProblem").text('');
		$("#holderLocation").text('');
		$("#holderEngineer").text('');
		$("#holderDate").text('');
		$("#holderSerial").html('');
		$("#holderType").html('');
		$("#holderIPServer2").html('');
		$("#holderIPMechine2").html('');
		$("#holderType").html('');
		$("#holderSeverity").text('');
		// $("#holderRoot").text($("#inputticket").val();
		$("#holderNote").text('');
		$("#holderStatus").html('');
		$("#holderWaktu").html('');

		$("#holderIDATM2").attr('style','display:none!important');
		$("#holderIDATM3").attr('style','display:none!important');
		$("#holderIPMechine").attr('style','display:none!important');
		$("#holderIPServer").attr('style','display:none!important');
		$("#holderIDATM").text('');
		
		$("#tableTicket").attr('style','display:none!important');

		$('.emailMultiSelector').remove()
		$("#emailOpenTo").val('')
		$("#emailOpenCc").val('')
		$("#emailOpenSubject").val('')
		$("#bodyOpenMail").empty()
		$("#sendTicket").attr('style','display:none!important')

		$("#formNewTicket").attr('style','display:none!important');
		$("#createIdTicket").show();
	}

	function makeNewTicket(){
		if(firstTimeTicket !== 0){
			swalWithCustomClass.fire({
				title: 'Reset Create Ticket',
				text: "This information of create ticket will be reset!",
				icon: 'warning',
				confirmButtonText: 'Reset',
			}).then((result) => {
				firstTimeTicket = 0
				window.location.assign("https://app.sinergy.co.id/ticketing#create");
				location.reload();

				// clearFormNewTicket()
				// prepareNewParameter()
			})
		} else {
			prepareNewParameter()
		}	
	}

	function prepareNewParameter(){
		$.ajax({
			type:"GET",
			url:"{{url('ticketing/create/getParameter')}}",
			success: function (result){
				var appendEmailTemplate = "<option selected='selected' value='none'>Choose Template Email</option> ";

				var arrayClient = []
				var arraySeverity = []

				$.each(result.client,function(key,value){
					arrayClient.push({
						id:value.id,
						text:value.code + " - " + value.brand_name
					})
				});

				$.each(result.severity,function(key,value){
					arraySeverity.push({
						id:value.id + " (" + value.name + ")",
						text:value.name + " - (" + value.description +")"
					})
				});

				$.each(result.email_template,function(key,value){
					appendEmailTemplate = appendEmailTemplate + "<option value='" + value.name + "'>" + value.name +" - " + value.type + "</option>";
				});

				var temp = "";
				if ($('#inputClient').hasClass("select2-hidden-accessible")) {
					temp = $('#inputClient').val()
					$("#inputClient").select2('destroy');
				}

				$("#inputClient").append("<option></option>")
				$("#inputClient").select2({
					data:arrayClient,
					placeholder:"Choose the client"
				})

				$("#inputSeverity").append("<option></option>")
				$("#inputSeverity").select2({
					data:arraySeverity,
					placeholder:"Choose the severity"
				});

				$("#inputTemplateEmail").html(appendEmailTemplate)
			},
		});
	}

	function getBankAtm(clientBanking){
		// $("#inputATM").empty()
		$("#typeDiv").show();

		if ($("#inputATM").next().next(".invalid-feedback").next("a")) {
    	$("#inputATM").next().next(".invalid-feedback").next("a").remove()
    	// $("div").removeClass('needs-validation')
			// $(".invalid-feedback").attr('style','display:none!important')
    }

		if ($("#inputTypeTicket").val() != "") {
			// $("div").removeClass('needs-validation')
			// $(".invalid-feedback").attr('style','display:none!important')
			if ($("#selectCatAsset").closest("div").prev("label").text().includes("*")) {
				if ($("#inputClient").val() == "INTERNAL" || $("#inputClient").val() == "ADMF") {
						$("#inputATMid").attr('style','display:none!important');
				}else{
					if ($("#hrLine").next().is(":visible")) {
						$("#inputATMid").show();
					}
				}
			}

			if($("#hrLine").next().is(":visible")){
				if ($("#selectCatAsset").val() == "ATM" || $("#selectCatAsset").val() == "CRM") {
					$("#categoryDiv").show();
				}else{
					$("#categoryDiv").attr('style','display:none!important');
				}
			}
		}

		$("#locationDiv .col-sm-2").text('Location')
		// if(clientBanking){
		// 	$("#inputATM").empty()
		// 	$("#typeDiv").show();
		// 	if ($("#inputTypeTicket").val() != "") {
		// 		$("#inputATMid").show();
		// 		$("#categoryDiv").show();
		// 	}
		// 	if ($('#inputATM').hasClass("select2-hidden-accessible")) {
		// 		$("#inputATM").select2('destroy');
		// 	}			
		// 	$("#locationDiv .col-sm-2").text('Location')
		// 	$("#inputATM").select2({
		// 		ajax: {
	 //        url: '{{url("/ticketing/create/getAssetByPid")}}',
	 //        data: function (params) {
	 //          var query = {
	 //            q: params.term,
	 //            pid:$("#selectPID").val()
	 //          }

	 //          // Query parameters will be ?search=[term]&type=public
	 //          return query;
	 //        },
	 //        processResults: function (data) {
	 //          // Transforms the top-level key of the response object from 'items' to 'results'
	 //          return {
	 //            results: data
	 //          };
	 //        },
	 //      },
	 //      placeholder: 'Select One',
		// 	});
		// } else {
		// 	if($("#inputClient option:selected").text().includes("Absensi")){
		// 		$.ajax({
		// 			type:"GET",
		// 			url:"{{url('/ticketing/create/getAssetByPid')}}",
		// 			data:{
		// 				pid:$("#selectPID").val(),
		// 			},
		// 			success: function(result){
		// 				$("#inputATMid").attr('style','display:none!important');

		// 				$('#inputSwitchLocation').attr('style','display:none!important')
		// 				if ($('#inputSwitchLocation').select2()) {
		// 					$('#inputSwitchLocation').select2('destroy')
		// 				}

		// 				$('#inputAbsenLocation').show()
		// 				if ($('#inputAbsenLocation').is(":visible")) {
		// 					$('#inputAbsenLocation').empty()
		// 					if ($('#inputAbsenLocation').hasClass("select2-hidden-accessible")) {
		// 						$("#inputAbsenLocation").select2('destroy');
		// 					}
		// 					result.unshift('Select One')

		// 					$("#inputAbsenLocation").select2({
		// 						data:result
		// 					});
		// 				}
		// 			}
		// 		})
		// 		// $.ajax({
		// 		// 	type:"GET",
		// 		// 	url:"{{url('ticketing/create/getAbsenId')}}",
		// 		// 	success: function(result){
		// 		// 		if ($('#inputAbsenLocation').hasClass("select2-hidden-accessible")) {
		// 		// 			$("#inputAbsenLocation").select2('destroy');
		// 		// 		}
		// 		// 		result.unshift('Select One')

		// 		// 		$("#inputAbsenLocation").select2({
		// 		// 			data:result
		// 		// 		});
		// 		// 	}
		// 		// });
		// 	} else if($("#inputClient option:selected").text().includes("Switch")){
		// 		$.ajax({
		// 			type:"GET",
		// 			url:"{{url('/ticketing/create/getAssetByPid')}}",
		// 			data:{
		// 				pid:$("#selectPID").val(),
		// 			},
		// 			success: function(result){
		// 				$("#inputATMid").attr('style','display:none!important');

		// 				$('#inputAbsenLocation').attr('style','display:none!important')
		// 				if ($('#inputAbsenLocation').select2()) {
		// 					$('#inputAbsenLocation').select2('destroy')
		// 				}

		// 				$('#inputSwitchLocation').show()
		// 				if ($('#inputSwitchLocation').is(":visible")) {
		// 					$('#inputSwitchLocation').empty()
		// 					if ($('#inputSwitchLocation').hasClass("select2-hidden-accessible")) {
		// 						$("#inputSwitchLocation").select2('destroy');
		// 					}
		// 					result.unshift('Select One')

		// 					$("#inputSwitchLocation").select2({
		// 						data:result
		// 					});
		// 				}
		// 			}
		// 		})
		// 		// $.ajax({
		// 		// 	type:"GET",
		// 		// 	url:"{{url('ticketing/create/getSwitchId')}}",
		// 		// 	success: function(result){
		// 		// 		if ($('#inputSwitchLocation').hasClass("select2-hidden-accessible")) {
		// 		// 			$("#inputSwitchLocation").select2('destroy');
		// 		// 		}
		// 		// 		result.unshift('Select One')

		// 		// 		$("#inputSwitchLocation").select2({
		// 		// 			data:result
		// 		// 		});
		// 		// 	}
		// 		// });
		// 	} else {
		// 		$("#locationDiv .col-sm-2").text('Location*')
		// 		$("#inputATM").val("");
		// 		$("#inputSerial").val("");
		// 		$("#inputLocation").val("");
		// 		$("#inputATMid").attr('style','display:none!important');
		// 	}
		// }
	}

	// $("#inputAbsenLocation").change(function(){
	// 	if(this.value === "Select One"){
	// 		$("#inputType").val("");
	// 		$("#inputIpMechine").val("");
	// 		$("#inputIpServer").val("");
	// 	} else {
	// 		// $.ajax({
	// 		// 	type:"GET",
	// 		// 	url:"{{url('/ticketing/create/getAbsenDetail')}}",
	// 		// 	data:{
	// 		// 		id_absen:this.value
	// 		// 	},
	// 		// 	success: function(result){
	// 		// 		$("#inputType").val(result.type_machine);
	// 		// 		$("#inputIpMechine").val(result.ip_machine);
	// 		// 		$("#inputIpServer").val(result.ip_server);
	// 		// 	}
	// 		// });
	// 		$.ajax({
	// 			type:"GET",
	// 			url:"{{url('/ticketing/create/getDetailAsset')}}",
	// 			data:{
	// 				id_absen:this.value
	// 			},
	// 			success: function(result){
	// 				$("#inputType").val(result.type_device);
	// 				$("#inputIpMechine").val(result.ip_address);
	// 				$("#inputIpServer").val(result.server);
	// 			}
	// 		});
	// 	}
	// })

	// $("#inputSwitchLocation").change(function(){
	// 	if(this.value === "Select One"){
	// 		$("#inputSerial").val("");
	// 		$("#inputType").val("");
	// 		$("#inputIpMechine").val("");
	// 	} else {
	// 		// $.ajax({
	// 		// 	type:"GET",
	// 		// 	url:"{{url('/ticketing/create/getSwitchDetail')}}",
	// 		// 	data:{
	// 		// 		id_switch:this.value
	// 		// 	},
	// 		// 	success: function(result){
	// 		// 		$("#inputSerial").val(result.serial_number);
	// 		// 		$("#inputType").val(result.type + " - " + result.port);
	// 		// 		$("#inputIpMechine").val(result.ip_management);
	// 		// 		// $("#inputIpServer").val(result.ip_server);
	// 		// 	}
	// 		// });
	// 		$.ajax({
	// 			type:"GET",
	// 			url:"{{url('/ticketing/create/getDetailAsset')}}",
	// 			data:{
	// 				id_switch:this.value
	// 			},
	// 			success: function(result){
	// 				$("#inputSerial").val(result.serial_number);
	// 				$("#inputType").val(result.type_device + " - " + result.port);
	// 				$("#inputIpMechine").val(result.ip_address);
	// 				$("#inputIpServer").val(result.server);
	// 			}
	// 		});
	// 	}
	// })

	$("#inputTemplateEmail").change(function(){
		if($("#inputTemplateEmail").val() != "none"){
			$("#createEmailBody").removeAttr("disabled")
		} else {
			$("#createEmailBody").attr("disabled",true)
		}
	})

	function createEmailBody(){
		if($("#inputTemplateEmail").val() != "none"){
			$("#sendTicket").show();
			$("#formNewTicket").attr('style','display:none!important');

			$("#createEmailBody").removeAttr("disabled")

			$.ajax({
				url:"{{url('ticketing/mail/getEmailTemplate')}}",
				data:{
					email_type:$("#inputTypeTicket").val(),
					email_name:$("#inputTemplateEmail").val(),
					email_activity:"Open"
				},
				type:"GET",
				beforeSend:function(){
          Swal.fire({
              title: 'Please Wait..!',
              text: "Preparing for send email..",
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
				success: function (result){
					$("#bodyOpenMail").html(result);
					$.ajax({
						type:"GET",
						url:"{{url('ticketing/mail/getEmailData')}}",
						data:{
							client:$("#selectPID").val(),
							slm:$("#inputSlm").val()
						},
						success: function(result){
							Swal.close()
							if($("#inputTemplateEmail").val() != "Wincor Template"){
								if($("#inputClient option:selected").text().includes("Absensi")){
									var subject = "Open Tiket " + $("#inputAbsenLocation").select2('data')[0].text + " [" + $("#inputProblem").val() +"]"
								} else if($("#inputClient option:selected").text().includes("Switch")){
									var subject = "Open Tiket " + $("#inputSwitchLocation").select2('data')[0].text + " [" + $("#inputProblem").val() +"]"
								} else if ($("#inputTemplateEmail").val() == "ATM Template"){
									var subject = "Permohonan Open Tiket " + $("#inputATM").select2('data')[0].text.split(' -')[0] + " " + result.client_name.split(' - ')[0] + " " + $("#inputLocation").val()
								} else if ($("#inputTemplateEmail").val() == "PTT Template"){
									var subject = "Request Support - " + $("#inputATM").select2('data')[0].text.split(' -')[0] + " - " + $("#inputProblem").val() + " (" + moment(($("#inputDate").val()), "DD-MMM-YY HH:mm").format("DD/MM/YYYY") + ")"
								} else if ($("#inputTemplateEmail").val() == "On Call Template - Permintaan Penawaran"){
									var subject = "[Penawaran On call - "+ $("#inputticket").val() +" - "+ localStorage.getItem("id_device_customer") +" - SLM]"
								} else {
									var subject = "Open Tiket " + $("#inputLocation").val() + " [" + $("#inputProblem").val() +"]"
								}
							} else {
								var subject = "#ATC - Permohonan Open Ticket"
							}

							$('.emailMultiSelector').remove()

							$("#emailOpenTo").val(result.open_to)
							$("#emailOpenTo").emailinput({ onlyValidValue: true, delim: ';' });
							$("#emailOpenCc").val(result.open_cc)
							$("#emailOpenCc").emailinput({ onlyValidValue: true, delim: ';' });
							$(".emailMultiSelector").css('height','37.1px')

							
							$("#emailOpenSubject").val(subject);
							if($("#inputClient option:selected").text().includes("Absensi")){
								$("#emailOpenHeader").html("Dear <b>" + result.open_dear + "</b><br>Berikut terlampir Open Tiket untuk <b>" + $("#inputAbsenLocation").select2('data')[0].text + "</b> : ");
							} else if($("#inputClient option:selected").text().includes("Switch")){
								$("#emailOpenHeader").html("Dear <b>" + result.open_dear + "</b><br>Berikut terlampir Open Tiket untuk <b>" + $("#inputSwitchLocation").select2('data')[0].text + "</b> : ");
							} else if($("#inputTemplateEmail").val() == "ATM Template") {
								$("#emailOpenHeader").html("Dear " + result.open_dear + ", ");
							} else if($("#inputTemplateEmail").val() == "Wincor Template") {
								$("#emailOpenHeader").html("Dear " + result.open_dear + ", ");
							} else {
								$("#emailOpenHeader").html("Dear <b>" + result.open_dear + "</b><br>Berikut terlampir Open Tiket untuk <b>" + $("#inputLocation").val() + "</b> : ");
							}
							$(".holderCustomer").text($("#inputClient option:selected").text().split(" - ")[1]);
						}
					});

					if(!$("#inputATM").val()){
						$("#inputATM").val(" - ");
					} else {
						$(".holderIDATM2").show();
						$(".holderIDATM3").show();
						$(".holderIDATM").text($("#inputATM").select2('data')[0].text.split(' -')[0]);
						$(".holderType").html($("#inputType").val());
					}

					if(!$("#inputSerial").val()){
						$("#inputSerial").val(" - ");
					}

					if(!$("#inputRefrence").val()){
						$("#inputRefrence").val(" - ");
					}

					if(!$("#inputNote").val()){
						$("#inputNote").val(" - ");
					}
					
					var waktu = moment(($("#inputDate").val()), "DD-MMM-YY HH:mm").format("D MMMM YYYY");
					var waktu2 = moment(($("#inputDate").val()), "DD-MMM-YY HH:mm").format("HH:mm");
					var schedule = moment(($("#inputReportingTime").val() + " " + $("#inputReportingDate").val()), "HH:mm:ss DD/MM/YYYY ").format("HH:mm - D MMMM YYYY");

					if($("#inputClient option:selected").text().includes("CCTV")){
						$(".holderIDATM2").insertAfter($(".holderIDATM2").next());
						$(".holderIDATM2 th").text("ATM ID");
						$(".holderIDATM3 th").text("CCTV Type");
						$(".holderSerial").prev().text("CCTV Serial")
						$(".holderSerial").html($("#inputSerial").val());
					} else if ($("#inputClient option:selected").text().includes("UPS")){
						$(".holderIDATM2").insertAfter($(".holderIDATM2").next());
						$(".holderIDATM2 th").text("ATM ID");
						$(".holderIDATM3 th").text("UPS Type");
						$(".holderSerial").prev().text("UPS Serial")
						$(".holderSerial").html($("#inputSerial").val());
					} else {
						if($("#inputTemplateEmail").val() != "Wincor Template"){
							$(".holderSerial").html($("#inputSerial").val());
						} else {
							$(".holderSerial").html($("#inputSerial").val() + ";");
						}
					}

					$(".holderID").text($("#inputticket").val());
					
					$(".holderRefrence").text($("#inputRefrence").val());
					if($("#inputTemplateEmail").val() != "Wincor Template"){
						$("#locationProblem").text($("#inputLocation").val())
						$(".holderPIC").text($("#inputPIC").val());
						$(".holderContact").text($("#inputContact").val());
						$(".holderLocation").text($("#inputLocation").val());
						$(".holderProblem").text($("#inputProblem").val());
						$(".holderType").html($("#inputType").val());
					} else {
						$("#locationProblem").text($("#inputLocation").val() + ";")
						$(".holderPIC").text($("#inputPIC").val() + ";");
						$(".holderContact").text($("#inputContact").val() + ";");
						$(".holderLocation").text($("#inputLocation").val() + ";");
						$(".holderProblem").text($("#inputProblem").val() + ";");
						$(".holderType").html($("#inputType").val() + ";");
					}

					if($("#inputClient option:selected").text().includes("Absensi")){
						$(".holderIDATM3").show();
						$(".holderType").html($("#inputType").val());
						$(".holderIPMechine3").show();
						$(".holderIPMechine4").text($("#inputIpMechine").val());
						$(".holderLocation").text($("#inputAbsenLocation").select2('data')[0].text);
						$(".holderIPServer3").show();
						$(".holderIPServer4").text($("#inputIpServer").val());
					} 

					if($("#inputClient option:selected").text().includes("Switch")){
						$(".holderIDATM3").show();
						$(".holderType").html($("#inputType").val());
						$(".holderIPMechine3").show();
						$(".holderIPMechine4").text($("#inputIpMechine").val());
						$(".holderLocation").text($("#inputSwitchLocation").select2('data')[0].text);
						// $(".holderIPServer3").show();
						// $(".holderIPServer4").text($("#inputIpServer").val());
					}
					

					$(".holderSeverity").text($("#inputSeverity").val());
					$(".holderNote").text($("#inputNote").val());
					
					$(".holderDate").text(waktu);
					$(".holderName").html("{{Auth::user()->name}}")
					$(".holderPhone").html("{{Auth::user()->phone}}")

					$(".holderStatus").html("<b>OPEN</b>");
					$(".holderWaktu").html("<b>" + waktu2 + "</b>");

					if($("#inputTypeTicket").val() == "Preventive Maintenance"){
						var schedule_date = moment(($("#inputReportingTime").val() + " " + $("#inputReportingDate").val()), "HH:mm:ss DD/MM/YYYY ").format("D MMMM YYYY");
						var schedule_time = moment(($("#inputReportingTime").val() + " " + $("#inputReportingDate").val()), "HH:mm:ss DD/MM/YYYY ").format("HH:mm");

						$(".holderStatus").html("<b>" + waktu + "</b>");
						$(".holderWaktu").html("<b>" + waktu2 + "</b>");

						$(".holderActivity").html($("#inputProblem").val())
						$(".holderEngineer").html($("#inputEngineerOpen").val())
					} else if($("#inputTemplateEmail").val() == "PTT Template"){
						$(".holderDate").html("<b>" + moment(($("#inputDate").val()), "DD-MMM-YY HH:mm").format("DD/MM/YY - hh:mm:ss") + "</b>");
						$(".holderAddress").html(($("#inputATMAddres").val() == "" ? "-" : $("#inputATMAddres").val()))
						
					}
				}
			})
		}
	}

	function backOpenEmail(){
		$("#sendTicket").attr('style','display:none!important');
		$("#formNewTicket").show();

		$("#createEmailBody").attr("disabled","true")
	}

	function sendOpenEmail(){
		if($("#emailOpenTo").val() == ""){
			$("#emailOpenTo").parent().parent().addClass("needs-validation")
			$("#emailOpenTo").parent().siblings().last().show()
			swalWithCustomClass.fire('Error',"You have to fill in the email to to open a ticket!",'error');
		} else {
			$("#emailOpenTo").parent().parent().removeClass("needs-validation")
			$("#emailOpenTo").parent().siblings().last().attr('style','display:none!important')
			var customerAcronym = $("#inputticket").val().split('/')[1];
			// if(
			// 	customerAcronym == "BJBR" 
			// 	|| customerAcronym == "BSBB" 
			// 	|| customerAcronym == "BRKR" 
			// 	|| customerAcronym == "BJTG" 
			// 	|| customerAcronym == "BDIY"
			// 	){
			// 	var id_atm = $("#inputATM").select2('data')[0].text.split(' -')[0]
			// } else {
			var id_atm = $("#inputATM").val()
			// }
			var typeAlert = 'warning'
			var typeActivity = 'Open'
			var typeAjax = "GET"
			var urlAjax = "{{url('ticketing/mail/sendEmailOpen')}}"
			if ($('#inputAbsenLocation').hasClass("select2-hidden-accessible")) {
				var absen = $("#inputAbsenLocation").select2('data')[0].id
				var location = $("#inputAbsenLocation").select2('data')[0].text
			} else if ($('#inputSwitchLocation').hasClass("select2-hidden-accessible")) {
				var switchLocation = $("#inputSwitchLocation").select2('data')[0].id
				var location = $("#inputSwitchLocation").select2('data')[0].text
			} else {
				var absen = "-";
				var switchLocation = "-";
				var location = $("#inputLocation").val();
			}

			var type_ticket = ""
			var problem = $("#inputProblem").val()
			var severity = $("#inputSeverity").val()
			if($("#inputTypeTicket").val() == "Trouble Ticket"){
				type_ticket = "TT"
				engineer = $("#inputEngineerOpen").val()
			}else if($("#inputTypeTicket").val() == "Preventive Maintenance"){
				type_ticket = "PM"
				engineer = $("#inputEngineerOpen").val()
				severity = "0"
			}else if($("#inputTypeTicket").val() == "Permintaan Layanan"){
				type_ticket = "PL"
				engineer = $("#inputEngineerOpen").val()
			}else if($("#inputTypeTicket").val() == "Permintaan Penawaran"){
				type_ticket = "PP"
				engineer = $("#inputEngineerOpen").val()
			}

			if ($("#selectPID").select2("data")[0] == undefined) {
      	var pid = ""
			}else{
	      var pid = $("#selectPID").select2("data")[0].id
      }

			var dataAjax = {
				body:$("#bodyOpenMail").html(),
				subject: $("#emailOpenSubject").val(),
				to: $("#emailOpenTo").val(),
				cc: $("#emailOpenCc").val(),
				attachment: $("#emailOpenAttachment").val(),
				id_ticket:$("#inputticket").val(),

				id:$("#inputID").val(),
				client:$("#inputClient option:selected").text().split(" - ")[0],
				clientID:$("#inputClient").select2('data')[0].id,

				id_atm:id_atm,
				refrence:$("#inputRefrence").val(),
				pic:$("#inputPIC").val(),
				contact_pic:$("#inputContact").val(),
				switchLocation:switchLocation,
				location:location,
				absen:absen,
				problem:problem,
				engineer:engineer,
				serial_device:$("#inputSerial").val(),
				note:$("#inputNote").val(),
				report:moment($("#inputReportingDate").val(),'DD/MM/YYYY').format("YYYY-MM-DD") + " " + moment($("#inputReportingTime").val(),'HH:mm:ss').format("HH:mm:ss.000000"),
				severity:severity,
				type_ticket:type_ticket,
				pid:pid
			}
			console.log(dataAjax.report)
			var textSwal = ""
			if($("#emailOpenCc").val() == ""){
				textSwal = "This ticket does not have a CC on the email recipient for this " + typeActivity + " ticket!"
			} else {
				textSwal = "Make sure there is nothing wrong to send this " + typeActivity + " ticket!"
			}
			swalPopUp(typeAlert,typeActivity,typeAjax,urlAjax,dataAjax,textSwal,function(){
				tabTrigger.show();
				// $("#modal-cancel").modal('toggle');
				// $("#modal-next-cancel").modal('toggle');
				// $("#modal-ticket").modal('toggle');
			})
		}
	}

	function swalPopUp(typeAlert,typeActivity,typeAjax,urlAjax,dataAjax,textSwal,callback){
		swalWithCustomClass.fire({
			title: 'Are you sure?',
			text: textSwal,
			icon: typeAlert,
			showCancelButton: false,
    	showDenyButton: false,
			allowOutsideClick: false,
			allowEscapeKey: false,
			allowEnterKey: false,
			confirmButtonText: 'Yes',
			cancelButtonText: 'No',
			}).then((result) => {
				if (result.value){
					$.ajax({
						type: typeAjax,
						url: urlAjax,
						data: dataAjax,
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
						success: function(resultAjax){
							Swal.hideLoading()
							swalWithCustomClass.fire({
								title: 'Success!',
								text: typeActivity + " Ticket Sended.",
								icon: 'success',
								confirmButtonText: 'Reload',
							}).then((result) => {
								callback()
								// getPerformanceByFilter([resultAjax.client_id_filter],[],[],[])
								$("#clientList").val(resultAjax.client_id_filter).trigger('change')
							})
						},
						error: function(resultAjax,errorStatus,errorMessage){
							Swal.hideLoading()
							swalWithCustomClass.fire({
								title: 'Error!',
								text: "Something went wrong, please try again!",
								icon: 'error',
								confirmButtonText: 'Try Again',
							}).then((result) => {
								$.ajax(this)
							})
						}
					});
				}
		});
			
		if (swalWithCustomClass) {
			document.querySelector('.swal2-deny')?.remove();
		}
	}

	var dataTicket = []; tablePerformance = ''

	function initTablePerformance(whichPageFor,id){
		if($.fn.dataTable.isDataTable("#tablePerformance")){
		// if($("#tablePerformance").length){
			$(".buttonFilter").removeClass('btn-primary').addClass('btn-secondary')
			// if (id == 'performance') {
			// 	$("#tablePerformance").DataTable().ajax.url("{{url('ticketing/getPerformanceAll')}}").load();
			// }
		}else{
			tablePerformance = $("#tablePerformance").DataTable({
				processing: true,
				ajax:{
					type:"GET",
					url:"{{url('ticketing/getPerformanceAll')}}",
					dataSrc: function (json){
						json.data.forEach(function(data,idex){
							data.open_time = moment(data.first_activity_ticket.date,'YYYY-MM-DD, HH:mm:ss').format('D MMMM YYYY HH:mm')
							data.pic = data.pic + ' - ' + data.contact_pic
							if(data.lastest_activity_ticket.activity == "OPEN"){
								data.lastest_status_numerical = 1
								data.lastest_status = '<span class="badge text-bg-danger">' + data.lastest_activity_ticket.activity + '</span> <p><small>'+ data.duration_from_last_activity + '</p></small>'
							} else if(data.lastest_activity_ticket.activity == "ON PROGRESS") {
								data.lastest_status_numerical = 2
								data.lastest_status = '<span class="badge text-bg-info">' + data.lastest_activity_ticket.activity + '</span> <p><small>'+ data.duration_from_last_activity + '</p></small>'
							} else if(data.lastest_activity_ticket.activity == "PENDING") {
								data.lastest_status_numerical = 3
								data.lastest_status = '<span class="badge text-bg-warning">' + data.lastest_activity_ticket.activity + '</span> <p><small>'+ data.duration_from_last_activity + '</p></small>'
							} else if(data.lastest_activity_ticket.activity == "CANCEL") {
								data.lastest_status_numerical = 4
								data.lastest_status = '<span class="badge text-bg-primary">' + data.lastest_activity_ticket.activity + '</span>'
							} else if(data.lastest_activity_ticket.activity == "CLOSE") {
								data.lastest_status_numerical = 5
								data.lastest_status = '<span class="badge text-bg-success">' + data.lastest_activity_ticket.activity + '</span>'
							} 
							data.lastest_operator = data.lastest_activity_ticket.operator

							//SLM Changes
							if(("{{Auth::user()->id_position}}" == "ENGINEER SPV" && data.request_pending == "Y")){
								data.action = '<button class="btn btn-sm btn-secondary btn-flat btn-sm" onclick="approvalPending(' + data.id_detail.id + ')">Approval Pending</button>'	
							}else{
								data.action = '<button class="btn btn-sm btn-secondary btn-flat btn-sm" onclick="showTicket(' + data.id_detail.id + ')">Detail</button>'	
							}
							
							data.problem = "<b>" + data.location + "</b> - " + data.problem

							if(data.type_ticket == "TT"){
								data.type_ticket = "Trouble Ticket"
							} else if (data.type_ticket == "PM"){
								data.type_ticket = "Preventive Maintenance"
							} else if (data.type_ticket == "PL"){
								data.type_ticket = "Permintaan Layanan"
							} else if (data.type_ticket == "PP"){
								data.type_ticket = "Permintaan Penawaran"
							}

							//serial_device
							if (data.serial_device == null || data.serial_device == '') {
								data.serial_device = ' - '
							}else{
								data.serial_device = data.serial_device
							}

							if(data.severity == 1){
								data.severity_numerical = 1
								data.severity = '<span class="badge text-bg-danger">' + data.type_ticket + ' - Critical</span>'
							} else if(data.severity == 2) {
								data.severity_numerical = 2
								data.severity = '<span class="badge bg-orange">' + data.type_ticket + ' - Major</span>'
							} else if(data.severity == 3) {
								data.severity_numerical = 3
								data.severity = '<span class="badge bg-custom-yellow">' + data.type_ticket + ' - Moderate</span>'
							} else if(data.severity == 4) {
								data.severity_numerical = 4
								data.severity = '<span class="badge text-bg-success">' + data.type_ticket + ' - Minor</span>'
							} else if(data.severity == 0){
								data.severity_numerical = 0
								data.severity = '<span class="badge text-bg-secondary">' + data.type_ticket + '</span>'
							}
						})
						return json.data
					}
				},
				// stateSave: true,
				columns:[
					{
						data:'id_ticket',
						width:"12.5%"
					},
					{ 	
						data:'id_atm',
						className:'text-center',
						width:"5%"
					},
					{ 	
						data:'serial_device',
						className:'text-center',
						width:"5%"
					},
					{
						data:'ticket_number_3party',
						className:'text-center',
						width:"5%"
					},
					{ 
						data:'open_time',
						className:'text-center',
						width:"7%"
					},
					{
						data:'problem',
						width:"40%"
					},
					{ 
						data:'pic',
						className:'text-center',
						width:"10%"
					},
					// {
					// 	data:'location',
					// 	width:"12%"
					// },
					{ 
						data:'severity',
						className:'text-center',
						orderData:[ 16 ],
						width:"3%"
					},
					{ 
						data:'lastest_status',
						className:'text-center',
						orderData:[ 15 ],
						width:"3%"
					},
					{ 
	          data:'response_time_percentage',
						className:'text-center',
						width:"3%"
					},
					{ 
	          data:'highlight_sla_response',
						className:'text-center',
						width:"3%"
					},
					{ 
	          data:'sla_resolution_percentage',
						className:'text-center',
						width:"3%"
					},
					{ 
	          data:'highlight_sla_resolution',
						className:'text-center',
						width:"3%"
					},
					{ 
						data:'lastest_operator',
						className:'text-center',
						width:"3%"
					},
					{
						data:'action',
						className:'text-center',
						orderable: false,
						searchable: true,
						width:"3%"
					},
					{ 
						data: "lastest_status_numerical",
						targets: [ 8 ] ,
						visible: false ,
						searchable: true
					},
					{ 
						data: "severity_numerical",
						targets: [ 7 ] ,
						visible: false ,
						searchable: true
					},
				],
				// order: [[10, "DESC" ]],
	      "createdRow": function(row, data, dataIndex) {
	        if (data.highlight_sla_response == "Not-Comply") {
	          $('td', row).eq(10).css('color', '#ff0a23')
	          // $('td', row).eq(9).css('color', '#ff0a23')
	        } 

	        if (data.highlight_sla_resolution == "Not-Comply") {
	          $('td', row).eq(12).css('color', '#ff0a23')
	          // $('td', row).eq(11).css('color', '#ff0a23')
	        }
	      },
				autoWidth:false,
				lengthChange: false,
				searching:true,
				initComplete: function () {
					var condition_available = ["OPEN","ON PROGRESS","PENDING","CANCEL","CLOSE"]
					this.api().columns().every( function () {
						if(this.index() == 13){
							var column = this;
							var select = $('<select class="form-control"><option value="">Show All</option></select>')
								.appendTo( $(column.footer()).empty() )
								.on( 'change', function () {
									var val = $.fn.dataTable.util.escapeRegex(
										$(this).val()
									);
									column.search( val ? '^'+val+'$' : '', true, false ).draw();
								} );

							
							column.data().unique().each( function ( d, j ) {
								select.append( '<option value="' + d + '">' + d +'</option>' )
							})
						} else if (this.index() == 8){
							var column = this;
							var select = $('<select class="form-control"><option value="">Show All</option></select>')
								.appendTo( $(column.footer()).empty() )
								.on( 'change', function () {
									var val = $.fn.dataTable.util.escapeRegex(
										$(this).val()
									);
									column.search( val ? val : '', true, false ).draw();
								} );

							condition_available.forEach( function ( d, j ) {
								select.append( '<option value="' + d + '">' + d +'</option>' )
							})
						}
					})

					$.each($("#selectShowColumnTicket li input"),function(index,item){
						var column = $("#tablePerformance").DataTable().column(index)
						// column.visible() ? $(item).addClass('active') : $(item).removeClass('active')
						$(item).prop('checked', column.visible())
					})
				},
				"aaSorting": [],
				// language: {
    //       processing: "<img src='loader.gif' alt='Loading...'>",  // Custom loading image or text
    //       loadingRecords: "Please wait - loading..."
    //     }
			})
		}
	}

	function getPerformanceAll(){
		whichPageFor = 'performance'
		initTablePerformance('performance')
		changePerformance(whichPageFor,'initPerformance')
	}

	$("#clientList").change(function(){
		if ($("#filterDashboardByClient").val() == "") {
			getPerformanceByFilter($(this).val(),[],[],[])
		}
		var start = "", end = "", pid = ''
		if ($("#filterDashboardByDate").val() != '') {
			start = moment($("#filterDashboardByDate").data('daterangepicker').startDate).format("YYYY-MM-DD")
			end = moment($("#filterDashboardByDate").data('daterangepicker').endDate).format("YYYY-MM-DD") 
		}else if ($("#startDateFilter").val() != '' && $("#endDateFilter").val() != '') {
			start = $("#startDateFilter").val()
			end = $("#endDateFilter").val()
		}else{
			start = start
			end = end
		}

		if($("#filterDashboardByPid").val() != null){
			pid = $("#filterDashboardByPid").val()
		}

		var urlAjax = '{{url("/ticketing/report/performance")}}?client=' + $(this).val() + '&pid=' + pid + '&start=' + start + '&end=' + end
		$("#exportTablePerformance").attr('onclick',"getReport('" + urlAjax + "')")
	})

	$("#severityFilter").change(function(){
		getPerformanceByFilter([],$(this).val(),[],[])
	})

	$("#typeFilter").change(function(){
		var start = "", end = "", pid = ""
		getPerformanceByFilter([],[],[],$(this).val())
		if ($("#filterDashboardByDate").val() != '') {
			start = moment($("#filterDashboardByDate").data('daterangepicker').startDate).format("YYYY-MM-DD")
			end = moment($("#filterDashboardByDate").data('daterangepicker').endDate).format("YYYY-MM-DD") 
		}else if ($("#startDateFilter").val() != '' && $("#endDateFilter").val() != '') {
			start = $("#startDateFilter").val()
			end = $("#endDateFilter").val()
		}else{
			start = start
			end = end
		}

		if($("#filterDashboardByPid").val() != null){
			pid = $("#filterDashboardByPid").val()
		}

		var urlAjax = '{{url("/ticketing/report/performance")}}?client=' + $("#clientList").val() + '&pid=' + pid + '&start=' + start + '&end=' + end + '&type=' + $(this).val()
		$("#exportTablePerformance").attr('onclick',"getReport('" + urlAjax + "')")
	})

	var startDateFilter = "", endDateFilter = ""
	$('#dateFilter').daterangepicker({
		ranges: {
			'Today'       : [moment(), moment()],
			'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			'This Month'  : [moment().startOf('month'), moment().endOf('month')],
			'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		},
		startDate: moment().subtract(29, 'days'),
		endDate: moment()
	},
	function (start, end) {
		$('#dateFilter').html("")
		$('#dateFilter').html('<i class="fa fa-calendar"></i> <span>' + start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY') + '</span>');

		var startDay = start.format('YYYY-MM-DD');
		var endDay = end.format('YYYY-MM-DD');

		$("#startDateFilter").val(startDay)
		$("#endDateFilter").val(endDay)

		startDate = start.format('D MMMM YYYY');
		endDate = end.format('D MMMM YYYY');

		if ($("#filterDashboardByDate").val() == "" || $("#filterDashboardByDate").val() == null) {
			getPerformanceByFilter([],[],[{start:start,end:start}],[])
			changePerformance('performance','filter')
		}
	});

	function getPerformanceByFilter(client,severity,date,type){
		var url_ajax = "{{url('/ticketing/getPerformanceByFilter?')}}"

		if($("#clientList").val().length !== 0){
			var match = false;
			$("#clientList").select2('data').forEach(function(item,index){ 
				if(item.text.includes("Absensi")){
					match = true;
				}
			})
			
			var client_param = jQuery.param({client: $("#clientList").val()});

			// if($.fn.dataTable.isDataTable("#tablePerformance")){
			if($("#tablePerformance").length){
				if(match){
					$("#tablePerformance").DataTable().column(1).visible(false)
					$("#tablePerformance").DataTable().column(2).visible(false)
				} else {
					$("#tablePerformance").DataTable().column(1).visible(true)
					$("#tablePerformance").DataTable().column(2).visible(true)
				}
			} else {
				if(match){
					$(".columnIdAtm").attr('style','display:none!important')
					$(".columnTicketNum").attr('style','display:none!important')
				} else {
					$(".columnIdAtm").show()
					$(".columnTicketNum").show()
				}
			}
			url_ajax = url_ajax + client_param
		} else if(client.length != 0){
			var client_param = jQuery.param({client: client});
			url_ajax = url_ajax + client_param
		}

		if($("#severityFilter").val().length !== 0){
			var severity_param = jQuery.param({severity: $("#severityFilter").val()});
			url_ajax = url_ajax + "&" + severity_param
		}

		if($("#typeFilter").val().length !== 0){
			var type_param = jQuery.param({type: $("#typeFilter").val()});
			url_ajax = url_ajax + "&" + type_param
		}

		if($("#startDateFilter").val() !== "" && $("#endDateFilter").val() !== ""){
			var date_param = "startDate=" + $("#startDateFilter").val() + "&endDate=" + $("#endDateFilter").val();
			url_ajax = url_ajax + "&" + date_param
		}

		
		// $('#clientList').find(".buttonFilter" + client).removeClass('btn-secondary').addClass('btn-primary')
		// $('#clientList').find(":not(.buttonFilter" + client + ")").removeClass('btn-primary').addClass('btn-secondary')
		$("#tablePerformance").DataTable().clear().draw();
		$(".dataTables_empty").text("Please wait, the data is being processed...");
		$("#tablePerformance").DataTable().ajax.url(url_ajax).load();

		//on done
		$(".select2-selection__choice[title='TT - Trouble Ticket']").css({"background-color": "#dd4b39","border-color": "#c84231"})
		$(".select2-selection__choice[title='PM - Preventive Maintenance']").css({"background-color": "#dd4b39","border-color": "#c84231"})
		$(".select2-selection__choice[title='PL - Permintaan Layanan']").css({"background-color": "#dd4b39","border-color": "#c84231"})
	
	}

	function changeNumberEntries(number){
		$("#btnShowEntryTicket").html('Show ' + number + ' <span class="fa fa-caret-down"></span>')
		$("#tablePerformance").DataTable().page.len( number ).draw();
	}

	function changeColumnTable(data){
		var column = $("#tablePerformance").DataTable().column($(data).attr("data-column"))
		column.visible( ! column.visible() );
		// $(data).prop('checked', column.visible())
		// column.visible() ? $(data).addClass('active') : $(data).removeClass('active')
	}

	//Start SLM Changes
	function detailTripRequest(id){
		$.ajax({
			type: 'GET',
			url: '{{url("ticketing/getDetailTripRequest")}}',
			data:{
				idMoneyRequest: id
			},
			success: function(result){
				$('#typeTripRequest').val(result.data.type)
				$('#startDateTripRequest').val(result.data.start_date)
				$('#endDateTripRequest').val(result.data.end_date)
				$('#fromTripRequest').text(result.data.from)
				$('#toTripRequest').text(result.data.to)


				$('#tripRequestRejectButton').attr('onclick', 'tripRequestReject()');
				$('#tripRequestApproveButton').attr('onclick', 'tripRequestApprove()');
			}
		})
		$('#modal-detail-trip-request').modal('toggle');
	}

	function approvalPending(id){
		$.ajax({
			type: "GET",
			url:"{{url('ticketing/getRequestPending')}}",
			data:{
				idTicket:id,
			},
			beforeSend:function(){
				Swal.fire({
					title: 'Please Wait..!',
					text: "Process data..",
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
				Swal.close()
				$("#approveButton").attr("onclick","approvePending('" + result.id_ticket + "','" + result.pending.reason +"')")
				$("#rejectButton").attr("onclick","rejectPending('" + result.id_ticket + "')")

				var severityType = "", severityClass = ""
				if(result.severity == 1){
					severityType = "Critical"
					severityClass = "label text-bg-danger"
				} else if(result.severity == 2){
					severityType = "Major"
					severityClass = "label text-bg-warning"
				} else if(result.severity == 3){
					severityType = "Moderate"
					severityClass = "label text-bg-info"
				} else if(result.severity == 4){
					severityType = "Minor"
					severityClass = "label text-bg-success"
				} else {
					severityType = "N/A"
					severityClass = "label text-bg-secondary"
				}

				if(result.type_ticket == "TT"){
					ticketType = "Trouble Ticket"
					ticketClass = "label text-bg-danger"
				} else if(result.type_ticket == "PM"){
					ticketType = "Preventive Maintenance"
					ticketClass = "label text-bg-warning"
				} else if(result.type_ticket == "PL"){
					ticketType = "Permintaan Layanan"
					ticketClass = "label text-bg-success"
				} else {
					ticketType = "N/A"
					ticketClass = "label text-bg-secondary"
				}

				$('#pendingTicketID').val(result.id_ticket);
				// $('#pendingTicketOpen').val(moment(result.first_activity_ticket.date).format("D MMMM YYYY (HH:mm)"))
				$("#pendingTicketOperator").html(" latest by: <b>" + result.lastest_activity_ticket.operator + "</b>");
				$("#pendingTicketSeverity").text(severityType);
				$("#pendingTicketType").text(ticketType);
				$("#pendingTicketSeverity").attr('class',severityClass);
				$("#pendingTicketType").attr('class',ticketClass);

				$("#pendingTicketLatestStatus").text(moment(result.lastest_activity_ticket.date).format('D MMMM YYYY (HH:mm)'));
				$("#pendinTicketStatus").text(result.lastest_activity_ticket.activity);
				$("#pendingTicketStatus").attr('style','');
				$("#modal-ticket-title-pending").html("Ticket ID <b>" + result.id_ticket + "</b>");
				$('#pendingType').val(result.pending.type);
				$('#pendingReason').val(result.pending.reason);
				$('#pendingEstimated').val(result.pending.estimated_pending);
				$('#pendingPartName').val(result.pending.part_name);
				if(result.pending.part_image){
					$('#pendingPartImage').attr('src', 'https://drive.google.com/file/d/'+result.pending.part_image+'/view?usp=sharing');
					$('#pendingPartImageURL').attr('href', 'https://drive.google.com/file/d/'+result.pending.part_image+'/view?usp=sharing');
				}
				if(result.pending.pending_image){

					$('#pendingPhoto').attr('src', 'https://drive.google.com/uc?export=view&id='+result.pending.pending_image);
					$('#pendingPhotoURL').attr('href', 'https://drive.google.com/file/d/'+result.pending.pending_image+'/view?usp=sharing');
				}
				if(result.pending.type === "Request Part"){
					$('#requestPart').show()
				}else{
					$('#requestPart').attr('style','display:none!important')
				}
				$('#modal-approval-pending').modal('toggle');
			}
		})
	}

	function approvePending(id,reason){
		Swal.fire({
			title: 'Are you sure?',
			text: "The status of this ticket will remain pending for some time.",
			icon: "warning",
			showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
				confirmButtonText: 'Yes',
		cancelButtonText: 'No',
			}).then((params) => {
				if (params.value) {
					$.ajax({
						type:"POST",
						url:"{{url('/ticketing/approvePending')}}",
						data:{
							id_ticket:id,
							reason:reason,
							_token: '{{ csrf_token() }}' 
						},
						beforeSend:function(){
							Swal.fire({
								title: 'Please Wait..!',
								text: "Process data..",
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
						success: function(response){
							if(response.status === 'success'){
								Swal.close();
								Swal.fire({
									title: 'Success',
									icon: 'success',
									text: response.message 
								}).then(() => {
									$('#modal-approval-pending').modal('toggle');
									$("#clientList").val(response.id_client).trigger('change')
								})
							}
						},
						error: function(response){
							Swal.close();
							Swal.fire({
								title: 'Error',
								icon: 'error',
								text: 'Something went wrong!'
							})
						}
					});
				}
			})

	}

	function rejectPending(id, reason = null){
		Swal.fire({
			title: 'Are you sure?',
			text: "This ticket will continue job if you rejected the request.",
			icon: "warning",
			showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
				confirmButtonText: 'Yes',
		cancelButtonText: 'No',
			}).then((params) => {
				if (params.value) {
					Swal.fire({
                            title: 'Reason for Reject',
                            input: 'text',
                            inputLabel: 'Please provide a reason for reject the request:',
                            inputPlaceholder: 'Enter your reason here',
                            showCancelButton: true,
                            confirmButtonText: 'Continue',
                            cancelButtonText: 'Cancel'
                        }).then((inputResult) => {
                            if (inputResult.isConfirmed && inputResult.value) {
								$.ajax({
								type:"POST",
								url:"{{url('/ticketing/rejectPending')}}",
								data:{
									id_ticket:id,
									reason:inputResult.value,
									_token: '{{ csrf_token() }}' 
								},
								beforeSend:function(){
									Swal.fire({
										title: 'Please Wait..!',
										text: "Process data..",
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
								success: function(response){
									if(response.status === 'success'){
										Swal.close();
										Swal.fire({
											title: 'Success',
											icon: 'success',
											text: response.message 
										}).then(() => {
											$('#modal-approval-pending').modal('toggle');
											$("#clientList").val(response.id_client).trigger('change')
										})
									}
								},
								error: function(response){
									Swal.close();
									Swal.fire({
										title: 'Error',
										icon: 'error',
										text: 'Something went wrong!'
									})
								}
							});
                            } else if (inputResult.dismiss === Swal.DismissReason.cancel) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Cancelled',
                                    text: 'Action has been cancelled.',
                                });
                            }
                        });
				}
			})
	}
	//end SLM Changes

	function showTicket(id){
		$.ajax({
			type:"GET",
			url:"{{url('/ticketing/getPerformanceByTicket')}}",
			data:{
				idTicket:id,
			},
			beforeSend:function(){
        Swal.fire({
            title: 'Please Wait..!',
            text: "Process data..",
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

				Swal.close()
				$("#escalateButton").attr("onclick","escalateTicket('" + result.id_ticket + "')")
				$("#updateButton").attr("onclick","updateTicket('" + result.id_ticket + "')");
				$("#cancelButton").attr("onclick","cancelTicket('" + result.id_ticket + "')");
				$("#pendingButton").attr("onclick","pendingTicket('" + result.id_ticket + "')");
				$("#closeButton").attr("onclick","closeTicket('" + result.id_ticket + "','" + result.lastest_activity_ticket.activity + "','" + result.lastest_activity_ticket.date + "')");
				
				if (accesable.includes('inputTicketSeverity')) {
					$("#inputTicketSeverity").attr("disabled",false)
				}

				$("#inputTicketSeverity").empty()
				$("#inputTicketSeverity").select2({
					placeholder:"Select Severity",
					data:[
						{
							id:1,
							text:"Critical"
						},
						{
							id:2,
							text:"Major"
						},
						{
							id:3,
							text:"Moderate"
						},
						{
							id:4,
							text:"Minor"
						},
						{
							id:0,
							text:"-"
						}
					]
				}).val(result.severity).trigger("change")

				$("#inputTicketSeverity").on('select2:select', function (e) {
			    var data = e.params.data;

					if (result.lastest_activity_ticket.activity == 'PENDING') {
						if ($(this).val() != result.severity) {
							Swal.fire({
								title: 'Are you sure?',
			          icon: 'warning',
								text: 'change the severity?',
								showCancelButton: true,
		        		confirmButtonColor: '#3085d6',
		        		cancelButtonColor: '#d33',
								confirmButtonText: 'Yes',
		        		cancelButtonText: 'No',
							}).then((params) => {
								if (params.value) {
									$.ajax({
										type:"GET",
										url:"{{url('/ticketing/setting/setUpdateSeverity')}}",
										data:{
											id_ticket:result.id_ticket,
											severity:data.id,
										},
										success: function(result){
											$("#modal-ticket").modal('toggle')
											$("#clientList").val(result.client_id_filter).trigger('change')
										}
									});
								}else{
									$("#inputTicketSeverity").val(result.severity).trigger("change")
								}
							})
						}
					}
				})

				var severityType = "", severityClass = ""
				if(result.severity == 1){
					severityType = "Critical"
					severityClass = "badge text-bg-danger"
				} else if(result.severity == 2){
					severityType = "Major"
					severityClass = "badge text-bg-warning"
				} else if(result.severity == 3){
					severityType = "Moderate"
					severityClass = "badge text-bg-info"
				} else if(result.severity == 4){
					severityType = "Minor"
					severityClass = "badge text-bg-success"
				} else {
					severityType = "N/A"
					severityClass = "badge text-bg-secondary"
				}

				if(result.type_ticket == "TT"){
					ticketType = "Trouble Ticket"
					ticketClass = "badge text-bg-danger"
				} else if(result.type_ticket == "PM"){
					ticketType = "Preventive Maintenance"
					ticketClass = "badge text-bg-warning"
				} else if(result.type_ticket == "PL"){
					ticketType = "Permintaan Layanan"
					ticketClass = "badge text-bg-success"
				} else {
					ticketType = "N/A"
					ticketClass = "badge text-bg-secondary"
				}

				$('#ticketID').val(result.id_ticket);
				$('#ticketOpen').val(moment(result.first_activity_ticket.date).format("D MMMM YYYY (HH:mm)"))
				$("#modal-ticket-title").html("Ticket ID <b>" + result.id_ticket + "</b>");
				$("#ticketOperator").html(" latest by: <b>" + result.lastest_activity_ticket.operator + "</b>");
				$("#ticketSeverity").text(severityType);
				$("#ticketType").text(ticketType);
				$("#ticketSeverity").attr('class',severityClass);
				$("#ticketType").attr('class',ticketClass);

				$("#ticketLatestStatus").text(moment(result.lastest_activity_ticket.date).format('D MMMM YYYY (HH:mm)'));
				$("#ticketStatus").text(result.lastest_activity_ticket.activity);
				$("#ticketStatus").attr('style','');

				$("#ticketIDATM").val(result.id_atm);
				var regex = /<br\s*[\/]?>/gi;
				// $("#mydiv").html(str.replace(regex, "\n"));
				$("#rowGeneral").show()
				$("#rowAbsen").attr('style','display:none!important')
				$("#ticketLocation").val(result.location);

				if($("#inputClient option:selected").text().includes("CCTV")){
					$("#ticketSerialArea").show()
					$("#ticketSerial").attr('style','display:none!important')
					$("#ticketSerialArea").val(result.serial_device.substring(0, result.serial_device.length - 4).replace(regex, "\n"));
				} else if (result.id_ticket.split("/")[1] == "BTNI" && result.id_detail.id_client == 29) {
					// $("#ticketSerialArea").show()
					$("#rowAbsen").show()
					$("#rowGeneral").attr('style','display:none!important')
					if(result.machine_absen == null){
						swalWithCustomClass.fire(
							'Absen Machine is not found!',
							'This can happen because the absent machine has been deleted or has been edited.',
							'error'
						)
						$("#ticketIPMachine").val("Not Found")
						$("#ticketIPServer").val("Not Found")
						$("#ticketMachineType").val("Not Found")
						$("#ticketLocation").val("Not Found")
					} else {
						$("#ticketIPMachine").val(result.machine_absen.ip_machine)
						$("#ticketIPServer").val(result.machine_absen.ip_server)
						$("#ticketMachineType").val(result.machine_absen.type_machine)
						$("#ticketLocation").val(result.machine_absen.nama_cabang + " - " + result.machine_absen.nama_kantor)
					}


					// $("#ticketSerialArea").val(result.serial_device.substring(0, result.serial_device.length - 4).replace(regex, "\n"));
				} else {
					$("#ticketSerial").show()
					$("#ticketSerialArea").attr('style','display:none!important')
					$("#ticketSerial").val(result.serial_device);
				}
				$("#ticketProblem").val(result.problem);
				$("#ticketPIC").val(result.pic + ' - ' + result.contact_pic);

				$("#ticketNote").val("");

				var engineers = result.engineer;
				if (!$('#ticketEngineer').is('input')) {
					$('#ticketEngineer').replaceWith('<input type="text" class="form-control" id="ticketEngineer" placeholder="" required value="">');
					$("#ticketEngineer").val(engineers);
				}else{
					$("#ticketEngineer").val(engineers);
				}

				if(engineers === null || engineers === ''){
					$.ajax({
						type:"GET",
						url:"{{url('/ticketing/getDataAssignEngineer')}}",
						data:{
							id_atm:result.id_atm,
							serial_number:result.serial_device
						},
						success: function(result){
							if (Array.isArray(result.data) && result.data.length > 0 && (result.second_level_support === "SIP" || result.second_level_support === "SIP EOS")) {
								if (!$('#ticketEngineer').is('select')) {
									$('#ticketEngineer').replaceWith('<select class="form-control" id="ticketEngineer"></select>');
								}

								var selectEngineer = $('#ticketEngineer');
								selectEngineer.empty();
								selectEngineer.append(new Option('Choose Engineer', '', true));
								let engineerFound = false;

								result.data.forEach(function(engineer) {
									if (String(engineer.engineer_atm).trim() === String(engineers).trim()) {
										engineerFound = true;
									}
									selectEngineer.append(new Option(engineer.engineer_atm, engineer.engineer_atm, false));
								});

								if (!engineerFound && engineers) {
									selectEngineer.append(new Option(engineers, engineers, false));
								}

								selectEngineer.select2({
									placeholder: 'Choose Engineer',
									allowClear: true,
									width: '100%',
									dropdownParent: $('#modal-ticket .modal-body')
								});

								selectEngineer.val(engineers).trigger('change');

							} else {
								if (!$('#ticketEngineer').is('input')) {
									$('#ticketEngineer').replaceWith('<input type="text" class="form-control" id="ticketEngineer" placeholder="" required value="">');
									$("#ticketEngineer").val(engineers);
								}
							}

							if ($('#ticketEngineer').is('select')) {
								$("#ticketEngineer").val(result.engineer).trigger("change")
								// if (result.engineer) {
								// 	var engineerOpt = $("#ticketEngineer");
								//   var optiEngineer = new Option(result.engineer, result.engineer, true, true);
								//   engineerOpt.append(optiEngineer).trigger('change');
								// }
							}
						},
						error: function(){
							$("#ticketEngineer").val(engineers);
						}
					});
				}



				$("#ticketNumber").val(result.ticket_number_3party);

				$("#ticketActivity").empty();
				var textColor = "", valueDate = "";
				$.each(result.all_activity_ticket,function(key,value){
					valueDate = moment(value.date).format("DD MMMM - HH:mm")

					if(value.activity == "PENDING"){
						console.log(value.pending_remind)
						textColor = 'text-yellow'
						if (value.pending_remind != null) {
							valueDate = moment(value.date).format("DD MMMM - HH:mm") + " (estimasi progress di " + moment(value.pending_remind.remind_time).format("DD MMMM - HH:mm") + " )"
						}else{
							valueDate = moment(value.date).format("DD MMMM - HH:mm")
						}
					} else if(value.activity == "CLOSE"){
						textColor = 'text-success'
						valueDate = moment(value.date).format("DD MMMM - HH:mm")
					} else if(value.activity == "OPEN"){
						textColor = 'text-danger'
						valueDate = moment(value.date).format("DD MMMM - HH:mm")
					} else if(value.activity == "CANCEL"){
						textColor = 'text-purple'
						valueDate = moment(value.date).format("DD MMMM - HH:mm")
					} else if(value.activity == "ON PROGRESS"){
						textColor = 'text-primary'
						valueDate = moment(value.date).format("DD MMMM - HH:mm")
					} else {
						textColor = ''
						valueDate = moment(value.date).format("DD MMMM - HH:mm")
					}
					$("#ticketActivity").append('<li><b class="' + textColor + '">' + valueDate + ' [' + value.operator + ']</b><br>' + value.note + '</li>');
				});

				if(result.reporting_time != "Invalid date"){
					$("#ticketActivity").append('<li><b class="text-muted">' + moment(result.reporting_time).format("DD MMMM - HH:mm") + ' - Reporting time</b></li>');
				} else {
					$("#ticketActivity").append('<li><b class="text-muted">' + result.reporting_time + ' - Reporting time</b></li>');
				}

				$(".holderCloseSeverity").text(result.severity + " (" + severityType + ")");
				$(".holderPendingSeverity").text(result.severity + " (" + severityType + ")");
				$(".holderCancelSeverity").text(result.severity + " (" + severityType + ")");

				$("#ticketNoteUpdate").show();

				$("#ticketCouter").attr('style','display:none!important');
				$("#ticketRoute").attr('style','display:none!important');

				$("#updatePendingBtn").prop('disabled',true);
				if(result.lastest_activity_ticket.activity == "OPEN"){
					$("#ticketStatus").attr('class','badge text-bg-danger');
					
					$("#pendingButton").prop('disabled',true);
					$("#closeButton").prop('disabled',true);
					$("#updateButton").prop('disabled',false);
				} else if(result.lastest_activity_ticket.activity == "PENDING") {
					$("#ticketStatus").attr('class','badge text-bg-warning');
					
					$("#pendingButton").prop('disabled',false);
					$("#closeButton").prop('disabled',false);
					$("#updatePendingBtn").prop('disabled',false);
					// $('#datePending').flatpickr({
					// 	autoclose: true,
					// 	startDate: moment().format("MM/DD/YYYY")
					// }).on('hide',function(result){
					// 	$('#datePending').val(moment(result.date).format("DD/MM/YYYY"))
					// });
					// $('#dateClose').flatpickr({
					// 	autoclose: true,
					// 	// startDate: moment(result.first_activity_ticket.date).format("MM/DD/YYYY"),
					// 	endDate: moment().format("MM/DD/YYYY")
					// }).on('hide',function(result){
					// 	$('#dateClose').val(moment(result.date).format("DD/MM/YYYY"))
					// });

					// $('#datePendingClose').flatpickr({
					// 	autoclose: true,
					// 	// startDate: moment(result.first_activity_ticket.date).format("MM/DD/YYYY"),
					// 	endDate: moment().format("MM/DD/YYYY")
					// }).on('hide',function(result){
					// 	$('#datePendingClose').val(moment(result.date).format("DD/MM/YYYY"))
					// });
					// Date format: DD/MM/YYYY for display
					const displayFormat = "d/m/Y"; // Flatpickr format for 01/04/2025
					const momentFormat = "YYYY-MM-DD"; // Moment.js format

					// #datePending
					flatpickr("#datePending", {
					  dateFormat: "m/d/Y", // internal format to start from today (MM/DD/YYYY)
					  defaultDate: moment().format("MM/DD/YYYY"),
					  onClose: function(selectedDates, dateStr, instance) {
					    if (selectedDates[0]) {
					      $('#datePending').val(moment(selectedDates[0]).format(momentFormat));
					    }
					  }
					});

					// #dateClose
					flatpickr("#dateClose", {
					  dateFormat: "m/d/Y",
					  maxDate: moment().format("MM/DD/YYYY"),
					  onClose: function(selectedDates, dateStr, instance) {
					    if (selectedDates[0]) {
					      $('#dateClose').val(moment(selectedDates[0]).format(momentFormat));
					    }
					  }
					});

					// #datePendingClose
					flatpickr("#datePendingClose", {
					  dateFormat: "m/d/Y",
					  maxDate: moment().format("MM/DD/YYYY"),
					  onClose: function(selectedDates, dateStr, instance) {
					    if (selectedDates[0]) {
					      $('#datePendingClose').val(moment(selectedDates[0]).format(momentFormat));
					    }
					  }
					});
				} else if(result.lastest_activity_ticket.activity == "CLOSE"){
					$("#ticketStatus").attr('class','badge text-bg-success');
					
					$("#pendingButton").prop('disabled',true);
					$("#closeButton").prop('disabled',true);
					$("#updateButton").prop('disabled',true);
					$("#cancelButton").prop('disabled',true);
					$("#reOpenButton").prop('disabled',false);
					$("#reOpenButton").attr("onclick","reOpenTicket('" + result.id_ticket + "','CLOSE')");
					
					$("#ticketNoteUpdate").attr('style','display:none!important');
					$("#ticketCouter").show();
					$("#ticketRoute").show();
					$("#ticketCouterTxt").val(result.resolve.counter_measure);
					$("#ticketRouteTxt").val(result.resolve.root_couse);
				} else if(result.lastest_activity_ticket.activity == "ON PROGRESS"){
					$("#ticketStatus").attr('class','badge text-bg-info');
					
					$("#updateButton").prop('disabled',false);
					$("#closeButton").prop('disabled',false);
					$("#cancelButton").prop('disabled',false);
					$("#pendingButton").prop('disabled',false);

					// $('#datePending').flatpickr({
					// 	autoclose: true,
					// 	startDate: moment().format("MM/DD/YYYY")
					// }).on('hide',function(result){
					// 	$('#datePending').val(moment(result.date).format("DD/MM/YYYY"))
					// });
					// $('#dateClose').flatpickr({
					// 	autoclose: true,
					// 	// startDate: moment(result.first_activity_ticket.date).format("MM/DD/YYYY"),
					// 	endDate: moment().format("MM/DD/YYYY")
					// }).on('hide',function(result){
					// 	$('#dateClose').val(moment(result.date).format("DD/MM/YYYY"))
					// });

					const momentFormat = "YYYY-MM-DD";

					// #datePending: set default date as today
					flatpickr("#datePending", {
					  dateFormat: "m/d/Y", // format Flatpickr understands
					  defaultDate: moment().format("YYYY-MM-DD"),
					  onClose: function(selectedDates) {
					    if (selectedDates[0]) {
					      $('#datePending').val(moment(selectedDates[0]).format(momentFormat));
					    }
					  }
					});

					// #dateClose: set max date as today
					flatpickr("#dateClose", {
					  dateFormat: "m/d/Y",
					  maxDate: moment().format("MM/DD/YYYY"),
					  onClose: function(selectedDates) {
					    if (selectedDates[0]) {
					      $('#dateClose').val(moment(selectedDates[0]).format(momentFormat));
					    }
					  }
					});
				} else if(result.lastest_activity_ticket.activity == "CANCEL"){
					$("#ticketStatus").attr('class','badge text-bg-primary');
					$("#ticketStatus").attr('style','background-color: #555299 !important;');
					$("#ticketNoteUpdate").attr('style','display:none!important');
					
					$("#pendingButton").prop('disabled',true);
					$("#closeButton").prop('disabled',true);
					$("#updateButton").prop('disabled',true);
					$("#cancelButton").prop('disabled',true);
					$("#reOpenButton").prop('disabled',false);
					$("#reOpenButton").attr("onclick","reOpenTicket('" + result.id_ticket + "','CANCEL')");
				}

				$('#modal-ticket').modal('toggle');
			}
		});
	}

	function reOpenTicket(id_ticket,status){
		$('#modal-ticket').modal('toggle');
		var reason = ""
		swalWithCustomClass.fire({
			title: "Are you sure to re-open this ticket from " + status + "?",
			html: "By re-opening this ticket, an email will be sent to your supervisor as permission for this activity.<br>Then you must write down your reasons why the ticket in must be reopened below.",
			input: 'text',
			icon: 'warning',
			preConfirm: (login) => {
				reason = login
			},
		}).then((result) => {
			if(result.value){
				Swal.fire({
					title: 'Please Wait..!',
					text: "It's sending",
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

				$.ajax({
					type:"GET",
					url:"{{url('/ticketing/reOpenTicket')}}",
					data:{
						id_ticket:id_ticket,
						reason:reason
					},
					success: function(resultAjax){
						Swal.hideLoading()
						swalWithCustomClass.fire({
							title: 'Request for a re-open ticket has been sent!',
							text: "Please wait for a reply and response from your manager.",
							icon: 'success',
							confirmButtonText: 'Reload',
						}).then((result) => {
							// $("#modal-setting-atm").modal('toggle');
							// $("#tableAtm").DataTable().ajax.url("/ticketing/setting/getAllAtm").load();
						})
					}
				});
			} else {
				swalWithCustomClass.fire({
					title: "Reason must be filled",
					html: "You must fill in your reason which will be conveyed to the manager for this reopen ticket.",
					icon: 'error',
					showCancelButton: true
				})
			}
		})
	}

	function updateTicket(id){
		if($("#ticketNote").val() == ""){
			swalWithCustomClass.fire({
				title: 'Error',
				text: "Please give you note before Update!",
				icon: 'error',
				showCancelButton: true,
			})
		} else {
			if($("#ticketStatus").text() == "PENDING"){
				swalWithCustomClass.fire({
					title: 'Are you sure?',
					text: "to continue this ticket from pending?",
					icon: 'warning',
					showCancelButton: true,
				}).then((result) => {
					if(result.value){
						swalWithCustomClass.fire({
							title: 'Would you like?',
							text: "to send an on-progress email to notify the user?",
							icon: 'warning',
							showDenyButton: true,
							denyButton: 'btn btn-flat btn-sm btn-danger swal2-margin',
							confirmButton: 'btn btn-flat btn-sm btn-success swal2-margin',
							confirmButtonText: 'Yes',
						}).then((result) => {
							if (result.isConfirmed) {
								$("#ticketNote").val("Continue from pending - " + $("#ticketNote").val())
								onProgressTicket()
							} else if (result.isDenied) {
								updateTicketAjax(moment().format("YYYY-MM-DD HH:mm:ss"))
							}
						})
					}
				})
			} else {
				swalWithCustomClass.fire({
					title: 'Are you sure?',
					text: "Are you sure to update this ticket?",
					icon: 'warning',
					showCancelButton: true,
				}).then((result) => {
					if(result.value){
						updateTicketAjax(moment().format("YYYY-MM-DD HH:mm:ss"))
					}
				})
			}
		}
	}

	function updateTicketAjax(timeOnProgress){
		$.ajax({
			type:"GET",
			url:"{{url('/ticketing/setUpdateTicket')}}",
			data:{
				id_ticket:$('#ticketID').val(),
				ticket_number_3party:$("#ticketNumber").val(),
				severity:$("#inputTicketSeverity").val(),
				engineer:$("#ticketEngineer").val(),
				note:$("#ticketNote").val(),
				timeOnProgress:timeOnProgress
			},
			success: function(result){
				$("#ticketActivity").prepend('<li>' + moment(result.date).format("DD MMMM - HH:mm") + ' [' + result.operator + '] - ' + result.note + '</li>');
				$("#ticketNote").val("")
				$("#ticketStatus").attr('class','badge text-bg-info');
				$("#ticketStatus").text('ON PROGRESS')
				$("#updateButton").prop('disabled',false);
				$("#closeButton").prop('disabled',false);
				$("#cancelButton").prop('disabled',false);
				$("#pendingButton").prop('disabled',false);
				$("#modal-ticket").modal('toggle')
				$("#clientList").val(result.client_id_filter).trigger('change')
				// getPerformanceByFilter([result.client_id_filter],[],[],[])
				swalWithCustomClass.fire(
					'Success',
					'Update Completed!',
					'success'
				)
			}
		});
	}

	function onProgressTicket(){
		$(".invalid-feedback").attr('style','display:none!important')
		$.ajax({
			url:"{{url('/ticketing/mail/getOnProgressMailTemplate')}}",
			type:"GET",
			beforeSend:function(){
        Swal.fire({
            title: 'Please Wait..!',
            text: "Preparing for send email..",
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
			success: function (result){
				$("#bodyOnProgressMail").html(result);
			}
		})

		$.ajax({
			url:"{{url('/ticketing/mail/getEmailData')}}",
			type:"GET",
			data:{
				id_ticket:$('#ticketID').val()
			},
			success: function (result){
				// Holder Cancel
				Swal.close()
				$("#modal-next-on-progress").modal('toggle');
				setTimeout(function() {
					$(".holderOnProgressID").text($('#ticketID').val());
					$(".holderOnProgressRefrence").text(result.ticket_data.refrence);
					$(".holderOnProgressPIC").text(result.ticket_data.pic);
					$(".holderOnProgressContact").text(result.ticket_data.contact_pic);
					$(".holderOnProgressLocation").text(result.ticket_data.location);
					$(".holderOnProgressProblem").text(result.ticket_data.problem);
					$(".holderOnProgressSerial").text(result.ticket_data.serial_device);
					$(".holderOnProgressSeverity").text(result.ticket_data.severity_detail.id + " (" + result.ticket_data.severity_detail.name + ")")

					$(".holderOnProgressIDATM").text(result.ticket_data.id_atm);

					$(".holderOnProgressNote").text("");
					$(".holderOnProgressEngineer").text(result.ticket_data.engineer);

					var waktu = moment((result.ticket_data.first_activity_ticket.date), "YYYY-MM-DD HH:mm:ss").format("D MMMM YYYY (HH:mm)");

					$(".holderOnProgressDate").text(waktu);

					$(".holderOnProgressStatus").html("<b>ON PROGRESS</b>");
					$(".holderOnProgressStatus").html("<b>ON PROGRESS</b>");

					$(".holderNumberTicket").text($("#ticketNumber").val());

					// Email Reciver
					$('.emailMultiSelector ').remove()

					$("#emailOnProgressTo").val(result.ticket_reciver.close_to)
					$("#emailOnProgressTo").emailinput({ onlyValidValue: true, delim: ';' });
					$("#emailOnProgressCc").val(result.ticket_reciver.close_cc)
					$("#emailOnProgressCc").emailinput({ onlyValidValue: true, delim: ';' });
					$(".emailMultiSelector").css('height','37.1px')


					$("#emailOnProgressSubject").val("On Progress Tiket " + $(".holderOnProgressLocation").text() + " [" + $(".holderOnProgressProblem").text() +"]");
					$("#emailOnProgressHeader").html("Dear <b>" + result.ticket_reciver.close_dear + "</b><br>Berikut terlampir On Progress Tiket untuk <b>" + $(".holderOnProgressLocation").text() + "</b> : ");
					$(".holderOnProgressCustomer").text(result.ticket_reciver.client_name);
					var timeOnProgress = moment()
					$(".holderOnProgressWaktu").html("<b>" + timeOnProgress.format("DD MMMM YYYY (HH:mm)") + "</b>");
					
					if(
						result.ticket_reciver.client_acronym  == "BJBR" || 
						result.ticket_reciver.client_acronym  == "BSBB" || 
						result.ticket_reciver.client_acronym  == "BRKR" || 
						result.ticket_reciver.client_acronym  == "BPRKS" || 
						result.ticket_reciver.client_acronym  == "BDIY"
						){
						$(".holderOnProgressIDATM2").show();
						$(".holderNumberTicket2").show();
					} else {
						$(".holderOnProgressIDATM2").attr('style','display:none!important');
						$(".holderNumberTicket2").attr('style','display:none!important');
					}
					$(".holderOnProgressNote").text($("#ticketNote").val());
					$("#sendOnProgressEmail").attr('onclick','sendOnProgressEmail("' + timeOnProgress.format("YYYY-MM-DD HH:mm:ss") + '")')
				},1000)
			}
		})
	}

	function sendOnProgressEmail(timeOnProgress){
		if($("#emailOnProgressTo").val() == ""){
			$("#emailOnProgressTo").parent().parent().addClass("needs-validation")
			$("#emailOnProgressTo").parent().siblings().last().show()
			swalWithCustomClass.fire('Error',"You have to fill in the email to to on progress a ticket!",'error');
		} else {
			$("#emailOnProgressTo").parent().parent().removeClass("needs-validation")
			$("#emailOnProgressTo").parent().siblings().last().attr('style','display:none!important')
			var typeAlert = 'warning'
			var typeActivity = 'On Progress'
			var typeAjax = "GET"
			var urlAjax = "{{url('/ticketing/setUpdateTicket')}}"
			var dataAjax = {
				email:"true",
				id_ticket:$('#ticketID').val(),
				ticket_number_3party:$("#ticketNumber").val(),
				severity:$("#inputTicketSeverity").val(),
				engineer:$("#ticketEngineer").val(),
				note:$("#ticketNote").val(),
				timeOnProgress:timeOnProgress,
				subject: $("#emailOnProgressSubject").val(),
				to: $("#emailOnProgressTo").val(),
				cc: $("#emailOnProgressCc").val(),
				body:$("#bodyOnProgressMail").html(),
			}
			var textSwal = ""
			if($("#emailOnProgressCc").val() == ""){
				textSwal = "This ticket does not have a CC on the email recipient for this " + typeActivity + " ticket!"
			} else {
				textSwal = "Make sure there is nothing wrong to send this " + typeActivity + " ticket!"
			}
			swalPopUp(typeAlert,typeActivity,typeAjax,urlAjax,dataAjax,textSwal,function(){
				$("#modal-next-on-progress").modal('toggle');
				$("#modal-ticket").modal('toggle');
			})
		}
	}

	function cancelTicket(id){
		$('#saveReasonCancel').val('')
		$('#modal-cancel').modal('toggle');
	}

	function prepareCancelEmail() {
		if($("#saveReasonCancel").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill cancel reason!',
				'error'
			)
		} else {
			swalWithCustomClass.fire({
				title: 'Are you sure?',
				text: "Are you sure to cancel this ticket?",
				icon: 'warning',
				showCancelButton: true,
			}).then((result) => {
				if (result.value) {
					$(".invalid-feedback").attr('style','display:none!important')
					$.ajax({
						url:"{{url('/ticketing/mail/getCancelMailTemplate')}}",
						type:"GET",
						beforeSend:function(){
              Swal.fire({
                  title: 'Please Wait..!',
                  text: "Preparing for send email..",
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
						success: function (result){
							$("#bodyCancelMail").html(result);

							$.ajax({
								url:"{{url('/ticketing/mail/getEmailData')}}",
								type:"GET",
								data:{
									id_ticket:$('#ticketID').val(),
									id_atm:$("#ticketIDATM").val(),
								},
								success: function (result){
									// Holder Cancel
									Swal.close()
									$(".holderCancelID").text($('#ticketID').val());
									$(".holderCancelRefrence").text(result.ticket_data.refrence);
									$(".holderCancelPIC").text(result.ticket_data.pic);
									$(".holderCancelContact").text(result.ticket_data.contact_pic);
									$(".holderCancelLocation").text(result.ticket_data.location);
									$(".holderCancelProblem").text(result.ticket_data.problem);
									$(".holderCancelSerial").text(result.ticket_data.serial_device);
									if (result.ticket_data.type_ticket != 'PM') {
										$(".holderCancelSeverity").text(result.ticket_data.severity_detail.id + " (" + result.ticket_data.severity_detail.name + ")")
									}
									$(".holderCancelIDATM").text(result.ticket_data.id_atm);

									$(".holderCancelNote").text("");
									$(".holderCancelEngineer").text(result.ticket_data.engineer);

									var waktu = moment((result.ticket_data.first_activity_ticket.date), "YYYY-MM-DD HH:mm:ss").format("D MMMM YYYY (HH:mm)");

									$(".holderCancelDate").text(waktu);

									$(".holderCancelStatus").html("<b>CANCEL</b>");
									$(".holderNumberTicket").text($("#ticketNumber").val());

									// Email Reciver
									$('.emailMultiSelector ').remove()

									$("#emailCancelTo").val(result.ticket_reciver.close_to)
									$("#emailCancelTo").emailinput({ onlyValidValue: true, delim: ';' });
									$("#emailCancelCc").val(result.ticket_reciver.close_cc)
									$("#emailCancelCc").emailinput({ onlyValidValue: true, delim: ';' });
									$(".emailMultiSelector").css('height','37.1px');


									$("#emailCancelSubject").val("Cancel Tiket " + $(".holderCancelLocation").text() + " [" + $(".holderCancelProblem").text() +"]");
									$("#emailCancelHeader").html("Dear <b>" + result.ticket_reciver.close_dear + "</b><br>Berikut terlampir Cancel Tiket untuk <b>" + $(".holderCancelLocation").text() + "</b> : ");
									$(".holderCancelCustomer").text(result.ticket_reciver.client_name);

									if(
										result.ticket_reciver.client_acronym  == "BJBR" || 
										result.ticket_reciver.client_acronym  == "BSBB" || 
										result.ticket_reciver.client_acronym  == "BRKR" || 
										result.ticket_reciver.client_acronym  == "BPRKS" || 
										result.ticket_reciver.client_acronym  == "BDIY"
										){
										$(".holderCancelIDATM2").show();
										$(".holderNumberTicket2").show();
									} else {
										$(".holderCancelIDATM2").attr('style','display:none!important');
										$(".holderNumberTicket2").attr('style','display:none!important');
									}
									$(".holderCancelNote").text($("#saveReasonCancel").val());
								},
								complete: function(){
									$("#modal-next-cancel").modal('toggle');
								}
							})
						}
					})

					
				}
			})
		}
	}

	function sendCancelEmail(id){
		if($("#emailCancelTo").val() == ""){
			$("#emailCancelTo").parent().parent().addClass("needs-validation")
			$("#emailCancelTo").parent().siblings().last().show()
			swalWithCustomClass.fire('Error',"You have to fill in the email to to cancel a ticket!",'error');
		} else {
			$("#emailCancelTo").parent().parent().removeClass("needs-validation")
			$("#emailCancelTo").parent().siblings().last().attr('style','display:none!important')

			var typeAlert = 'warning'
			var typeActivity = 'Cancel'
			var typeAjax = "GET"
			var urlAjax = "{{url('/ticketing/mail/sendEmailCancel')}}"
			var dataAjax = {
				id_ticket:$('#ticketID').val(),
				subject: $("#emailCancelSubject").val(),
				to: $("#emailCancelTo").val(),
				cc: $("#emailCancelCc").val(),
				note_cancel: $("#saveReasonCancel").val(),
				body:$("#bodyCancelMail").html(),
			}
			var textSwal = ""
			if($("#emailCancelCc").val() == ""){
				textSwal = "This ticket does not have a CC on the email recipient for this " + typeActivity + " ticket!"
			} else {
				textSwal = "Make sure there is nothing wrong to send this " + typeActivity + " ticket!"
			}
			swalPopUp(typeAlert,typeActivity,typeAjax,urlAjax,dataAjax,textSwal,function(){
				$("#modal-cancel").modal('toggle');
				$("#modal-next-cancel").modal('toggle');
				$("#modal-ticket").modal('toggle');
			})
		}
	}

	function pendingTicket(id){
		$("#saveReasonPending").val('')
		$(".invalid-feedback").attr('style','display:none!important')
		if($("#ticketStatus").text() == "PENDING"){
			$.ajax({
				url:"{{'/ticketing/getPendingTicketData'}}",
				data:{
					id_ticket:$('#ticketID').val()
				},
				success:function(result){
					$("#estimationPendingHolder").show()
					// $("#timePending").val(moment(result.remind_time).format("hh:mm"))
					$("#datePending").val(moment(result.remind_time).format("YYYY-MM-DD"))
					$("#estimationPendingText").text(moment(result.remind_time).format("D MMMM YYYY") + " at " + moment(result.remind_time).format("HH:mm"))
					$('#modal-pending').modal('toggle');
				}
			})
		} else {
			$('#modal-pending').modal('toggle');
		}
	}

	function preparePendingEmail(){
		if($("#saveReasonPending").val() == "" && $("#datePending").val() == "" && $("#timePending").val() == ""){
			$("#labelPendingReason, #labelPendingEstimation").addClass('needs-validation')
			$("#datePending").parent().parent().addClass('needs-validation')
			$("#timePending").parent().parent().addClass('needs-validation')
			swalWithCustomClass.fire(
				'Error',
				'You must fill in reason and estimation for make this Pending Ticket!',
				'error'
			)
		} else if($("#saveReasonPending").val() == ""){
			$("#labelPendingReason").addClass('needs-validation')
			swalWithCustomClass.fire(
				'Error',
				'You must fill in reason for make this Pending Ticket!',
				'error'
			)
		} else if($("#datePending").val() == "" || $("#timePending").val() == ""){
			$("#labelPendingEstimation").addClass('needs-validation')
			$("#datePending").parent().parent().addClass('needs-validation')
			$("#timePending").parent().parent().addClass('needs-validation')
			swalWithCustomClass.fire(
				'Error',
				'You must fill in estimation for make this Pending Ticket!',
				'error'
			)
		} else if (moment($("#datePending").val() + " " + $("#timePending").val() + ":00", "DD/MM/YYYY hh:mm:ss").isBefore(moment())){
			$("#labelPendingEstimation").addClass('needs-validation')
			$("#datePending").parent().parent().addClass('needs-validation')
			$("#timePending").parent().parent().addClass('needs-validation')
			swalWithCustomClass.fire(
				'Error',
				"You set time before now! (Can't backdate)",
				'error'
			)
		} else {
			$("#labelPendingReason, #labelPendingEstimation").removeClass('needs-validation')
			$("#datePending").parent().parent().removeClass('needs-validation')
			$("#timePending").parent().parent().removeClass('needs-validation')
			swalWithCustomClass.fire({
				title: 'Are you sure?',
				text: "Are you sure to pending this ticket?",
				icon: 'warning',
				showCancelButton: true,
			}).then((result) => {
				if (result.value) {
					$.ajax({
						url:"{{url('/ticketing/mail/getPendingMailTemplate')}}",
						type:"GET",
						beforeSend:function(){
              Swal.fire({
                  title: 'Please Wait..!',
                  text: "Preparing for send email..",
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
						success: function (result){
							$("#bodyPendingMail").html(result);

							$.ajax({
								url:"{{url('/ticketing/mail/getEmailData')}}",
								type:"GET",
								data:{
									id_ticket:$('#ticketID').val()
								},
								success: function (result){
									// Holder Pending
									Swal.close()
									$(".holderPendingID").text(result.ticket_data.id_ticket);
									$(".holderPendingRefrence").text(result.ticket_data.refrence);
									$(".holderPendingPIC").text(result.ticket_data.pic);
									$(".holderPendingContact").text(result.ticket_data.contact_pic);
									$(".holderPendingLocation").text(result.ticket_data.location);
									$(".holderPendingProblem").text(result.ticket_data.problem);
									$(".holderPendingSerial").text(result.ticket_data.serial_device);
									$(".holderPendingSeverity").text(result.ticket_data.severity_detail.id + " (" + result.ticket_data.severity_detail.name + ")")

									$(".holderPendingIDATM").text(result.ticket_data.id_atm);

									$(".holderPendingNote").text("");
									$(".holderPendingEngineer").text(result.ticket_data.engineer);

									var waktu = moment((result.ticket_data.first_activity_ticket.date), "YYYY-MM-DD HH:mm:ss").format("D MMMM YYYY (HH:mm)");

									$(".holderPendingDate").text(waktu);

									$(".holderPendingStatus").html("<b>PENDING</b>");
									$(".holderNumberTicket").text($("#ticketNumber").val());

									// Email Reciver
									$('.emailMultiSelector ').remove()

									$("#emailPendingTo").val(result.ticket_reciver.close_to)
									$("#emailPendingTo").emailinput({ onlyValidValue: true, delim: ';' });

									$("#emailPendingCc").val(result.ticket_reciver.close_cc)
									$("#emailPendingCc").emailinput({ onlyValidValue: true, delim: ';' });
									$(".emailMultiSelector").css('height','37.1px');


									$("#emailPendingSubject").val("Pending Tiket " + $(".holderPendingLocation").text() + " [" + $(".holderPendingProblem").text() +"]");
									$("#emailPendingHeader").html("Dear <b>" + result.ticket_reciver.close_dear + "</b><br>Berikut terlampir Pending Tiket untuk <b>" + $(".holderPendingLocation").text() + "</b> : ");
									$(".holderPendingCustomer").text(result.ticket_reciver.client_name);

									if(
										result.ticket_reciver.client_acronym  == "BJBR" || 
										result.ticket_reciver.client_acronym  == "BSBB" || 
										result.ticket_reciver.client_acronym  == "BRKR" || 
										result.ticket_reciver.client_acronym  == "BPRKS"  || 
										result.ticket_reciver.client_acronym  == "BDIY" 
										){
										$(".holderPendingIDATM2").show();
										$(".holderNumberTicket2").show();
									} else {
										$(".holderPendingIDATM2").attr('style','display:none!important');
										$(".holderNumberTicket2").attr('style','display:none!important');
									}
									$(".holderCancelNote").text($("#saveReasonCancel").val());
									$(".holderPendingNote").text($("#saveReasonPending").val());
								},
								complete: function(){
									$("#modal-next-pending").modal('toggle');
								}
							})
						}
					})

					
				}
			})
		}
	}

	function updatePending(){
		if($("#saveReasonPending").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill pending reason!',
				'error'
			)
		} else {
			swalWithCustomClass.fire({
				title: 'Are you sure?',
				text: "Are you sure to update this pending?",
				icon: 'warning',
				showCancelButton: true,
			}).then((result) => {
				$.ajax({
					url:"{{url('/ticketing/setUpdateTicketPending')}}",
					data:{
						updatePending:$("#saveReasonPending").val(),
						id_ticket:$('#ticketID').val(),
						estimationPending:moment($("#datePending").val(),"YYYY-MM-DD").format("DD-MM-YYYY") + " " + $("#timePending").val() + ":00"
					},
					success:function(resultAjax){
						// swalWithCustomClass.fire(
						// 	'Success',
						// 	'Update Completed!',
						// 	'success'
						// )
						swalWithCustomClass.fire({
							title: 'Success!',
							text: 'Update pending success',
							icon: 'success',
							confirmButtonText: 'Reload',
						}).then((result) => {
							$('#modal-pending').modal('toggle');
							$("#modal-ticket").modal('toggle');
							$("#clientList").val(resultAjax.client_id_filter).trigger('change')
						})
						
					}
				})
			})
		}
	}

	function sendPendingEmail(){
		if($("#emailPendingTo").val() == ""){
			$("#emailPendingTo").parent().parent().addClass("needs-validation")
			$("#emailPendingTo").parent().siblings().last().show()
			swalWithCustomClass.fire('Error',"You have to fill in the email to to pending a ticket!",'error');
		} else {
			$("#emailPendingTo").parent().parent().removeClass("needs-validation")
			$("#emailPendingTo").parent().siblings().last().attr('style','display:none!important')
			var typeAlert = 'warning'
			var typeActivity = 'Pending'
			var typeAjax = "GET"
			var urlAjax = "{{url('/ticketing/mail/sendEmailPending')}}"
			var dataAjax = {
				id_ticket:$('#ticketID').val(),
				subject: $("#emailPendingSubject").val(),
				to: $("#emailPendingTo").val(),
				cc: $("#emailPendingCc").val(),
				note_pending: $("#saveReasonPending").val(),
				body:$("#bodyPendingMail").html(),
				estimationPending:moment($("#datePending").val(),"YYYY-MM-DD").format("DD-MM-YYYY") + " " + $("#timePending").val() + ":00",
			}

			var textSwal = ""
			if($("#emailPendingCc").val() == ""){
				textSwal = "This ticket does not have a CC on the email recipient for this " + typeActivity + " ticket!"
			} else {
				textSwal = "Make sure there is nothing wrong to send this " + typeActivity + " ticket!"
			}

			swalPopUp(typeAlert,typeActivity,typeAjax,urlAjax,dataAjax,textSwal,function(){
				$("#modal-next-pending").modal('toggle');
				$("#modal-pending").modal('toggle');
				$("#modal-ticket").modal('toggle');
			})
		}
	}

	function closeTicket(id,activity,date){
		if (activity == 'PENDING') {
			$('#modal-close-pending').modal('toggle');
			$('#btnPendingClose').attr("onclick","closePendingTicket('"+ id +"','"+ activity +"')")

			$("#durationPicker").daterangepicker({
		    timePicker: true,
		    timePicker24Hour: true,
		    minDate:moment(date, 'YYYY-MM-DD HH:mm').add(1, 'minutes'),
		    startDate: moment(date, 'YYYY-MM-DD HH:mm').add(1, 'minutes'),
		    endDate: moment(date, 'YYYY-MM-DD HH:mm').add(1, 'hour'),
		    // endDate: moment().startOf('hour').add(32, 'hour'),
		    locale: {
		      format: 'YYYY-MM-DD HH:mm'
		    }
		  });
		}else{
			// console.log(date)
			// console.log(moment(date).add(5, 'minutes').format('HH:mm'))
			$("#timeClose").timepicker({
				showInputs: false,
				minuteStep: 1,
				maxHours: 24,
				showMeridian: false,
			});

			$('#timeClose').timepicker('setTime',moment(date).add(1, 'minutes').format('HH:mm'))

			// $('#dateClose').flatpickr({
			// 	autoclose: true,
			// 	// startDate: moment(result.first_activity_ticket.date).format("MM/DD/YYYY"),
			// 	minDate: moment().format("YYYY-MM-DD"),
			// 	startDate: moment().format("YYYY-MM-DD"),
			// 	locale: {
		  //     format: 'YYYY-MM-DD'
		  //   }
			// })

			flatpickr("#dateClose", {
			  dateFormat: "Y-m-d", // equivalent to 'YYYY-MM-DD'
			  // minDate: moment().format("YYYY-MM-DD"), // today's date
			  defaultDate: moment().format("YYYY-MM-DD") // start from today
			});

			$("#saveCloseRoute").val('')
			$("#saveCloseCouter").val('')
			$('#modal-close').modal('toggle');
		}
	}

	function closePendingTicket(id,activity){
		if($("#saveNotePendingClose").val() == "" ){
			// $("#saveNotePendingClose, #startTimePendingClose, #endTimePendingClose, #datePendingClose").addClass('needs-validation')
			$("#saveNotePendingClose").parent().addClass('needs-validation')
			swalWithCustomClass.fire(
				'Error',
				'You must fill in note for make this Progress Ticket!',
				'error'
			)
		}else if($("#startTimePendingClose").val() == ""){
			$("#startTimePendingClose").parent().addClass('needs-validation')
			swalWithCustomClass.fire(
				'Error',
				'You must fill in start time for make this Progress Ticket!',
				'error'
			)
		}else if($("#endTimePendingClose").val() == ""){
			$("#endTimePendingClose").parent().addClass('needs-validation')
			swalWithCustomClass.fire(
				'Error',
				'You must fill in end time for make this Progress Ticket!',
				'error'
			)
		}else if($("#datePendingClose").val() == ""){
			$("#datePendingClose").parent().addClass('needs-validation')
			swalWithCustomClass.fire(
				'Error',
				'You must fill in date for make this Progress Ticket!',
				'error'
			)
		}else{
			formData = new FormData;
	    formData.append("_token","{{csrf_token()}}")
	    formData.append("id_ticket",id)
	    formData.append("saveNotePendingClose",$("#saveNotePendingClose").val())
	    formData.append("startDateTimePendingClose",moment($("#durationPicker").data('daterangepicker').startDate).format("YYYY-MM-DD HH:mm:ss") )
	    formData.append("endDateTimePendingClose",moment($("#durationPicker").data('daterangepicker').endDate).format("YYYY-MM-DD HH:mm:ss"))

	    $.ajax({
	      url:"{{url('/ticketing/updateTicketPendingBeforeClose')}}",
	      type:"POST",
	      processData: false,
	      contentType: false,
	      data:formData,
	      beforeSend:function(){
	        Swal.fire({
	            title: 'Please Wait..!',
	            text: "It's sending..",
	            allowOutsideClick: false,
	            allowEscapeKey: false,
	            allowEnterKey: false,
	            customClass: {
	                popup: 'border-radius-0',
	            },
	        })
	        Swal.showLoading()
	      },success:function(result){
	      	if (result) {
	      		Swal.close()
						$('#modal-close-pending').modal('hide');
		        closeTicket(id,"CLOSE",result)
	      	}
	      }
	    })
		}
	}

	function prepareCloseEmail() {
		if($("#saveCloseRoute").val() == "" && $("#saveCloseCouter").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill root cause and counter measure!',
				'error'
			)
		} else if($("#saveCloseCouter").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill counter measure!',
				'error'
			)
		} else if($("#saveCloseRoute").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill root cause!',
				'error'
			)
		} else if($("#timeClose").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill time!',
				'error'
			)
		} else if($("#dateClose").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill date!',
				'error'
			)
		} else {
			swalWithCustomClass.fire({
				title: 'Are you sure?',
				text: "Are you sure to close this ticket?",
				icon: 'warning',
				showCancelButton: true,
			}).then((result) => {
				$('#modal-close').modal('toggle');
				if (result.value) {
					$(".invalid-feedback").attr('style','display:none!important')
					$.ajax({
						url:"{{url('/ticketing/mail/getCloseMailTemplate')}}",
						type:"GET",
						beforeSend:function(){
              Swal.fire({
                  title: 'Please Wait..!',
                  text: "Preparing for send email..",
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
						success: function (result){
							$("#bodyCloseMail").html(result);
							$.ajax({
								url:"{{url('/ticketing/mail/getEmailData')}}",
								type:"GET",
								data:{
									id_ticket:$('#ticketID').val()
								},
								success: function (result){
									// Holder Close
									Swal.close()
									if(result.ticket_data.type_ticket == "PM"){
										$(".holderCloseProblem").siblings().first().text("Action")
									}

									$(".holderCloseID").text(result.ticket_data.id_ticket);
									$(".holderCloseRefrence").text(result.ticket_data.refrence);
									$(".holderClosePIC").text(result.ticket_data.pic);
									$(".holderCloseContact").text(result.ticket_data.contact_pic);
									$(".holderCloseLocation").text(result.ticket_data.location);
									$(".holderCloseProblem").text(result.ticket_data.problem);
									$(".holderCloseSerial").html(result.ticket_data.serial_device);
									if(result.ticket_data.severity_detail != null){
										$(".holderCloseSeverity").text(result.ticket_data.severity_detail.id + " (" + result.ticket_data.severity_detail.name + ")")
									}
									
									$(".holderCloseIDATM").text(result.ticket_data.id_atm);
									$(".holderCloseNote").text("");
									$(".holderCloseEngineer").text(result.ticket_data.engineer);

									var waktu = moment((result.ticket_data.first_activity_ticket.date), "YYYY-MM-DD HH:mm:ss").format("D MMMM YYYY (HH:mm)");

									$(".holderCloseDate").text(waktu);

									$(".holderCloseStatus").html("<b>CLOSE</b>");
									$(".holderNumberTicket").text($("#ticketNumber").val());

									// Email Reciver
									$('.emailMultiSelector ').remove()

									$("#emailCloseTo").val(result.ticket_reciver.close_to)
									$("#emailCloseTo").emailinput({ onlyValidValue: true, delim: ';' });

									$("#emailCloseCc").val(result.ticket_reciver.close_cc)
									$("#emailCloseCc").emailinput({ onlyValidValue: true, delim: ';' });
									$(".emailMultiSelector").css('height','37.1px');


									$("#emailCloseSubject").val("Close Tiket " + $(".holderCloseLocation").text() + " [" + $(".holderCloseProblem").text() +"]");
									$("#emailCloseHeader").html("Dear <b>" + result.ticket_reciver.close_dear + "</b><br>Berikut terlampir Close Tiket untuk <b>" + $(".holderCloseLocation").text() + "</b> : ");
									$(".holderCloseCustomer").text(result.ticket_reciver.client_name);

									$(".holderCloseIDATM2").show();
									$(".holderNumberTicket2").show();

									// if(result.ticket_reciver.banking == 1){
									// 	$(".holderCloseIDATM2").show();
									// 	$(".holderNumberTicket2").show();
									// } else {
									// 	$(".holderCloseIDATM2").attr('style','display:none!important');
									// 	$(".holderNumberTicket2").attr('style','display:none!important');
									// }

									// if(result.ticket_reciver.client_name.includes("UPS")) {
									// 	$(".holderCloseIDATM2").show();
									// 	$(".holderCloseUPSSerial2").show()
									// 	console.log(result.ticket_data.atm_detail)
									// 	if (result.ticket_data.atm_detail != null) {
									// 		$(".holderCloseUPSSerial").text(result.ticket_data.atm_detail.serial_number)
									// 		$(".holderCloseUPSType").text(result.ticket_data.atm_detail.type_device)
									// 	}
									// 	$(".holderCloseUPSType2").show()
									// 	$(".holderCloseSerial").parent().attr('style','display:none!important')	
									// } else if (result.ticket_reciver.client_name.includes("CCTV")) {
									// }

									$(".holderCloseCounter").text($("#saveCloseCouter").val());
									$(".holderCloseRoot").text($("#saveCloseRoute").val());
									$(".holderCloseWaktu").html("<b>" + moment($("#dateClose").val(),'YYYY-MM-DD').format("DD MMMM YYYY") + " " + moment($("#timeClose").val(),'HH:mm:ss').format("(HH:mm)") + "</b>");
								},
								complete: function(){
									$("#modal-next-close").modal('toggle');
								}
							})
						}
					})

					
				}
			})
		}
	}

	function sendCloseEmail(){
		if($("#emailCloseTo").val() == ""){
			$("#emailCloseTo").parent().parent().addClass("needs-validation")
			$("#emailCloseTo").parent().siblings().last().show()
			swalWithCustomClass.fire('Error',"You have to fill in the email to to close a ticket!",'error');
		} else {
			$("#emailCloseTo").parent().parent().removeClass("needs-validation")
			$("#emailCloseTo").parent().siblings().last().attr('style','display:none!important')
			var typeAlert = 'warning'
			var typeActivity = 'Close'
			var typeAjax = "GET"
			var urlAjax = "{{url('/ticketing/mail/sendEmailClose')}}"
			var dataAjax = {
				id_ticket:$('#ticketID').val(),
				root_cause:$("#saveCloseRoute").val(),
				couter_measure:$("#saveCloseCouter").val(),
				finish:moment($("#dateClose").val(),'YYYY-MM-DD').format("YYYY-MM-DD") + " " + moment($("#timeClose").val(),'HH:mm:ss').format("HH:mm:ss.000000"),
				body:$("#bodyCloseMail").html(),
				subject: $("#emailCloseSubject").val(),
				to: $("#emailCloseTo").val(),
				cc: $("#emailCloseCc").val(),
			}

			var textSwal = ""
			if($("#emailCloseCc").val() == ""){
				textSwal = "This ticket does not have a CC on the email recipient for this " + typeActivity + " ticket!"
			} else {
				textSwal = "Make sure there is nothing wrong to send this " + typeActivity + " ticket!"
			}

			swalPopUp(typeAlert,typeActivity,typeAjax,urlAjax,dataAjax,textSwal,function(){
				$("#modal-next-close").modal('toggle');
				$("#modal-close").modal('hide');
				$("#modal-ticket").modal('toggle');
			})
		}
	}

	function escalateTicket(id){
		$("#modal-escalate").modal('toggle');
	}

	function prepareEscalateEmail() {
		if($("#escalateRCA").val() == "" && $("#escalateNameEngineer").val() == "" && $("#escalateContactEngineer").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill RCA, Name and Contact Engineer!',
				'error'
			)
		} else if($("#escalateRCA").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill RCA!',
				'error'
			)
		} else if($("#escalateNameEngineer").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill Name Next Engineer!',
				'error'
			)
		} else if($("#escalateContactEngineer").val() == ""){
			swalWithCustomClass.fire(
				'Error',
				'You must fill Contact Next  Engineer!',
				'error'
			)
		} else {
			swalWithCustomClass.fire({
				title: 'Would you like?',
				text: "do you want to send this ecalate email?",
				icon: 'warning',
				showDenyButton: true,
				denyButton: 'btn btn-flat btn-sm btn-danger swal2-margin',
				confirmButton: 'btn btn-flat btn-sm btn-success swal2-margin',
				confirmButtonText: 'Yes',
			}).then((result) => {
				if (result.isConfirmed) {
					$(".invalid-feedback").attr('style','display:none!important')
					$.ajax({
						url:"{{url('/ticketing/mail/getEscalateMailTemplate')}}",
						type:"GET",
						beforeSend:function(){
              Swal.fire({
                  title: 'Please Wait..!',
                  text: "Preparing for send email..",
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
						success: function (result){
							$("#bodyEscalateMail").html(result);

							$.ajax({
								url:"{{url('/ticketing/mail/getEmailData')}}",
								type:"GET",
								data:{
									id_ticket:$('#ticketID').val()
								},
								success: function (result){
									// Holder Escalate
									Swal.close()
									$(".holderEscalateID").text(result.ticket_data.id_ticket);
									$(".holderEscalateRefrence").text(result.ticket_data.refrence);
									$(".holderEscalatePIC").text(result.ticket_data.pic);
									$(".holderEscalateContact").text(result.ticket_data.contact_pic);
									$(".holderEscalateLocation").text(result.ticket_data.location);
									$(".holderEscalateLocationHeader").text(result.ticket_data.location);
									$(".holderEscalateProblem").text(result.ticket_data.problem);
									$(".holderEscalateProblemHeader").text(result.ticket_data.problem);
									$(".holderEscalateSerial").text(result.ticket_data.serial_device);
									$(".holderEscalateSeverity").text(result.ticket_data.severity_detail.id + " (" + result.ticket_data.severity_detail.name + ")")
									
									$(".holderEscalateIDATM").text(result.ticket_data.id_atm);

									$(".holderEscalateNote").text("");
									$(".holderEscalateEngineer").text(result.ticket_data.engineer);

									var waktu = moment((result.ticket_data.first_activity_ticket.date), "YYYY-MM-DD HH:mm:ss").format("D MMMM YYYY (HH:mm)");

									$(".holderEscalateDate").text(waktu);

									$(".holderEscalateStatus").html("<b>ESCALATE</b>");
									$(".holderNumberTicket").text($("#ticketNumber").val());

									// Email Reciver
									$('.emailMultiSelector ').remove()
									// $("#emailEscalateTo").val(result.ticket_reciver.close_to)
									$("#emailEscalateTo").emailinput({ onlyValidValue: true, delim: ';' });
									// $("#emailEscalateCc").val(result.ticket_reciver.close_cc)
									$("#emailEscalateCc").emailinput({ onlyValidValue: true, delim: ';' });
									$('.emailMultiSelector').css('height','37.1px')


									$("#emailEscalateSubject").val("Escalate Tiket " + $(".holderEscalateProblem").text() + " [" + $(".holderEscalateLocation").text() +"]");
									
									$(".emailEscalateHeader").html($("#escalateNameEngineer").val());
									$(".holderEscalateNote").html("-");
									$(".holderEscalateRCA").html($("#escalateRCA").val());

									$(".holderEscalateCustomer").text(result.ticket_reciver.client_name);

									if(result.ticket_reciver.client_acronym  == "BJBR" || 
										result.ticket_reciver.client_acronym  == "BSBB" || 
										result.ticket_reciver.client_acronym  == "BRKR" || 
										result.ticket_reciver.client_acronym  == "BPRKS"
										){
										$(".holderEscalateIDATM2").show();
										$(".holderNumberTicket2").show();
									} else {
										$(".holderEscalateIDATM2").attr('style','display:none!important');
										$(".holderNumberTicket2").attr('style','display:none!important');
									}

									$(".holderEscalateWaktu").html("<b>" + moment().format("DD MMMM YYYY (HH:mm)") + "</b>");
								},
								complete: function(){
									$("#modal-next-escalate").modal('toggle');
								}
							})
						}
					})

					
				} else if (result.isDenied) {
					 var dataAjax = {
						id_ticket:$("#ticketID").val(),
						contactEngineer:$("#escalateContactEngineer").val(),
						nameEngineer:$("#escalateNameEngineer").val(),
						rca:$("#escalateRCA").val(),
					}

					swalPopUp(
						"warning",
						"Escalate",
						"GET",
						"{{url('/ticketing/saveEscalate')}}",
						dataAjax,
						"Make sure the RCA, Name and Contact for the next engineer are correct and appropriate.",
						function(){
							$("#modal-escalate").modal('toggle')
							$("#modal-ticket").modal('toggle');

						}
					)
				}
			})
		}
	}

	function sendEscalateEmail(){
		if($("#emailEscalateTo").val() == ""){
			$("#emailEscalateTo").parent().parent().addClass("needs-validation")
			$("#emailEscalateTo").parent().siblings().last().show()
			swalWithCustomClass.fire('Error',"You have to fill in the 'email to' for escalating a ticket!",'error');
		} else {
			$("#emailEscalateTo").parent().parent().removeClass("needs-validation")
			$("#emailEscalateTo").parent().siblings().last().attr('style','display:none!important')

			var typeAlert = 'warning'
			var typeActivity = 'Escalate'
			var typeAjax = "GET"
			var urlAjax = "{{url('/ticketing/mail/sendEmailEscalate')}}"
			var dataAjax = {
				id_ticket:$("#ticketID").val(),
				contactEngineer:$("#escalateContactEngineer").val(),
				nameEngineer:$("#escalateNameEngineer").val(),
				rca:$("#escalateRCA").val(),
				body:$("#bodyEscalateMail").html(),
				subject: $("#emailEscalateSubject").val(),
				to: $("#emailEscalateTo").val(),
				cc: $("#emailEscalateCc").val(),
			}

			var textSwal = ""
			if($("#emailEscalateCc").val() == ""){
				textSwal = "This ticket does not have a CC on the email recipient for this " + typeActivity + " ticket!"
			} else {
				textSwal = "Make sure the name and contact for the next engineer are correct and appropriate."
			}

			swalPopUp(typeAlert,typeActivity,typeAjax,urlAjax,dataAjax,textSwal,function(){
				$("#modal-next-escalate").modal('toggle');
				$("#modal-escalate").modal('toggle');
				$("#modal-ticket").modal('toggle');
			})
		}
	}

	function emailSetting(){
		$("#searchBarEmail").attr("placeholder","Search Client")
		$(".settingComponent").attr('style','display:none!important')
		$("#emailSetting").show()
		$("#addEmail2").removeClass('d-none')
		$("#addEmail2").show()
		$("#addEmail").show()
		$("#addEmail").removeClass('d-none')
		$("#addEmailSlm").attr('id','addEmail')
		$("#addEmail").attr('onclick','EmailAdd()')
		// if($.fn.dataTable.isDataTable("#tableClient")){

		// } else {
		// 	$("#tableClient").DataTable({
		// 		ajax:{
		// 			type:"GET",
		// 			url:"{{url('/ticketing/mail/getSettingEmail')}}",
		// 			dataSrc: function (json){
		// 				json.data.forEach(function(data,idex){
		// 					data.action = '<button type="button" class="btn btn-sm btn-flat btn-block btn-secondary" onclick="editClient('+ data.id + ')">Edit</button>'
		// 				})
		// 				return json.data
		// 			}
		// 		},
		// 		columns:[
		// 			{
		// 				data:'client_name',
		// 			},
		// 			{ 	
		// 				data:'client_acronym',
		// 			},
		// 			{
		// 				data:'open_dear',
		// 			},
		// 			{ 
		// 				data:'open_to',
		// 			},
		// 			{ 
		// 				data:'open_cc',
		// 			},
		// 			{ 
		// 				data:'close_dear',
		// 			},
		// 			{ 
		// 				data:'close_to',
		// 			},
		// 			{ 
		// 				data:'close_cc',
		// 			},
		// 			{
		// 				data:'action',
		// 				className:'text-center',
		// 				orderable: false,
		// 				searchable: true,
		// 			}
		// 		],
		// 		// order: [[10, "DESC" ]],
		// 		autoWidth:false,
		// 		lengthChange: false,
		// 		searching:true,
		// 		"processing": true,
		// 		"ColumnDefs":[
		// 	        { targets: 'no-sort', orderable: false }
		// 	    ],
		// 	    "aaSorting": [],
		// 	})
		// }

		if ($.fn.dataTable.isDataTable("#tableEmailSetting")) {
		// if ($("#tableEmailSetting").length) {

		} else {
			const dataSet = [
		    {
		    	'id':1,
		      'pid':'106/BRKS/SIP/XI/2023',
		      'open_dear':'Team BRKS',
		      'open_to':'msm@sinergy.co.id',
		      'open_cc':'	helpdesk@sinergy.co.id',
		      'close_dear':'Team BRKS',
		      'close_to':'msm@sinergy.co.id',
		      'close_cc':'helpdesk@sinergy.co.id',
		    },
		    {
		    	'id':2,
		      'pid':'040/BBJB/SIP/VI/2023',
		      'open_dear':'Team',
		      'open_to':'saputranova@gmail.com',
		      'open_cc':'inurhasan@gmail.com',
		      'close_dear':'Tim Monitoring BJB',
		      'close_to':'inurhasan@gmail.com',
		      'close_cc':'helpdesk@sinergy.co.id',
		    }
		  ];
			$("#tableEmailSetting").DataTable({
				ajax:{
					type:"GET",
					url:"{{url('/ticketing/mail/getSettingEmailbyPID')}}",
				},
				columns:[
					{ 	
						data:'pid',
					},
					{
						data:'dear',
					},
					{ 
						data:'to',
					},
					{ 
						data:'cc',
					},
					{
						render: function ( data, type, row){
							return '<button type="button" class="btn btn-sm btn-flat btn-sm btn-block btn-secondary" style="width:60" onclick="editClientEmail('+ row.id + ')">Edit</button>'
						},
						data:'action',
						className:'text-center',
						orderable: false,
						searchable: true,
						width: '45px'
					}
				],
				autoWidth:false,
				lengthChange: false,
				searching:true,
				"processing": true,
				"ColumnDefs":[
		       { targets: 'no-sort', orderable: false }
		    ],
		    "aaSorting": [],
			})
		}
	}

	function SlmEmailSetting(){
		$("#searchBarEmail").attr("placeholder","Search Client")
		$(".settingComponent").attr('style','display:none!important')
		$("#SlmEmailSetting").show()
		$("#addEmail2").removeClass('d-none')
		$("#addEmail").removeClass('d-none')
		$("#addEmail2").show()
		$("#addEmail").show()
		$("#addEmail").attr('id','addEmailSlm')
		$("#addEmailSlm").attr('onclick','EmailSlmAdd()')

		if ($.fn.dataTable.isDataTable("#tableSlmEmailSetting")) {
		// if ($("#tableSlmEmailSetting").length) {

		} else {
			const dataSet = [
		    {
		    	'id':1,
		      'slm':'Qualita',
		      'open_dear':'Team Qualita',
		      'open_to':'msm@sinergy.co.id',
		      'open_cc':'	helpdesk@sinergy.co.id',
		      'close_dear':'Team BRKS',
		      'close_to':'msm@sinergy.co.id',
		      'close_cc':'helpdesk@sinergy.co.id',
		    },
		    {
		    	'id':2,
		      'slm':'PTT',
		      'open_dear':'Team',
		      'open_to':'saputranova@gmail.com',
		      'open_cc':'inurhasan@gmail.com',
		      'close_dear':'Tim Monitoring BJB',
		      'close_to':'inurhasan@gmail.com',
		      'close_cc':'helpdesk@sinergy.co.id',
		    }
		  ];
			$("#tableSlmEmailSetting").DataTable({
				ajax:{
					type:"GET",
					url:"{{url('/ticketing/mail/getSettingEmailSLM')}}",
				},
				columns:[
					{ 	
						data:'second_level_support',
					},
					{
						data:'dear',
					},
					{ 
						data:'to',
					},
					{ 
						data:'cc',
					},
					{
						render: function ( data, type, row){
							return '<button type="button" class="btn btn-sm btn-flat btn-sm btn-block btn-secondary" onclick="editSlmEmail('+ row.id + ')">Edit</button>'
						},
						className:'text-center',
						orderable: false,
						searchable: true,
						width: '45px'
					}
				],
				autoWidth:false,
				lengthChange: false,
				searching:true,
				"processing": true,
				"ColumnDefs":[
		       { targets: 'no-sort', orderable: false }
		    ],
		    "aaSorting": [],
			})
		}
	}

	function editClient(id){
		$.ajax({
			type:"GET",
			url:"{{url('/ticketing/setting/getSettingClient')}}",
			data: {
				id:id,
			},
			success : function(result){
				$('#modal-setting-email').modal('toggle');
				$(".modal-setting-title").html("Change Setting for <b>" + result[0].client_name + "</b>");

				$("#clientId").val("");
				$("#clientTitle").val("");
				$("#clientAcronym").val("");
				$("#openDear").val("");
				$('.emailMultiSelector ').remove()
				$("#openTo").val("");
				$("#openCc").val("");
				$("#closeDear").val("");
				$("#closeTo").val("");

				$("#clientId").val(id);
				$("#clientTitle").val(result[0].client_name);
				$("#clientAcronym").val(result[0].client_acronym);

				if (result[0].situation == 1) {
					$('#situation').prop('checked', true);
				}

				if (result[0].banking == 1) {
					$('#banking').prop('checked', true);
				}

				if (result[0].wincor == 1) {
					$('#wincor').prop('checked', true);
				}

				$('.emailMultiSelector').remove()
				
				$("#openDear").val(result[0].open_dear);
				$("#openTo").val(result[0].open_to);
				$("#openTo").emailinput({ onlyValidValue: true, delim: ';' })
				$("#openCc").val(result[0].open_cc);
				$("#openCc").emailinput({ onlyValidValue: true, delim: ';' })

				$("#closeDear").val(result[0].close_dear);
				$("#closeTo").val(result[0].close_to);
				$("#closeTo").emailinput({ onlyValidValue: true, delim: ';' })
				$("#closeCc").val(result[0].close_cc);
				$("#closeCc").emailinput({ onlyValidValue: true, delim: ';' })

				$('.emailMultiSelector').css('height','37.1px')

			},
		});
	}

	function saveClient(value){
		if (value == 'AddClient') {
			if ($('input#bankingAdd').is(':checked')) {
				$('input#bankingAdd').val(1)
			}else{
				$('input#bankingAdd').val(0)
			}

			if ($('input#wincorAdd').is(':checked')) {
				$('input#wincorAdd').val(1)
			}else{
				$('input#wincorAdd').val(0)
			}

			$.ajax({
				type:"POST",
				url:"{{url('/ticketing/mail/storeAddMail')}}",
				data:{
					"_token": "{{ csrf_token() }}",
					client_name:$("#clientTitleAdd").val(),
					client_acronym:$("#clientAcronymAdd").val(),
					open_dear:$("#openDearAdd").val(),
					open_to:$("#openToAdd").val(),
					open_cc:$("#openCcAdd").val(),
					close_dear:$("#closeDearAdd").val(),
					close_to:$("#closeToAdd").val(),
					close_cc:$("#closeCcAdd").val(),
					banking:$("#bankingAdd").val(),
					wincor:$("#wincorAdd").val()
				},
				success : function(){
					swalWithCustomClass.fire({
						title: 'Success!',
						text: "Email Client Add Successfully!",
						icon: 'success',
						confirmButtonText: 'Reload',
					}).then((result) => {
						$('#modal-add-email').modal('toggle');
						$('#tableClient').DataTable().ajax.url("{{url('/ticketing/mail/getSettingEmail')}}").load();
						getPerformanceByFilter(resultAjax.client_id_filter,[],[],[])
					})
				}
			});
		}else{
			if ($('input#banking').is(':checked')) {
				$('input#banking').val(1)
			}else{
				$('input#banking').val(0)
			}

			if ($('input#wincor').is(':checked')) {
				$('input#wincor').val(1)
			}else{
				$('input#wincor').val(0)
			}

			if ($('input#situation').is(':checked')) {
				$('input#situation').val(1)
			}else{
				$('input#situation').val(0)
			}

			$.ajax({
				type:"POST",
				url:"{{url('/ticketing/setting/setSettingClient')}}",
				data:{
					"_token": "{{ csrf_token() }}",
					id:$("#clientId").val(),
					client_name:$("#clientTitle").val(),
					client_acronym:$("#clientAcronym").val(),
					open_dear:$("#openDear").val(),
					open_to:$("#openTo").val(),
					open_cc:$("#openCc").val(),
					close_dear:$("#closeDear").val(),
					close_to:$("#closeTo").val(),
					close_cc:$("#closeCc").val(),
					banking:$("#banking").val(),
					wincor:$("#wincor").val(),
					situation:$("#situation").val()
				},
				success : function(){
					swalWithCustomClass.fire({
						title: 'Success!',
						text: "Email Client Update Successfully!",
						icon: 'success',
						confirmButtonText: 'Reload',
					}).then((result) => {
						$('#modal-setting-email').modal('toggle');
						$('#tableClient').DataTable().ajax.url("{{url('/ticketing/mail/getSettingEmail')}}").load();
					})
				}
			});
		}
	}

	function atmSetting(){
		$(".settingComponent").attr('style','display:none!important')
		$("#atmSetting").show()
		$("#addAtm").show()
		$("#addAtm2").show()

		if($.fn.dataTable.isDataTable("#tableAtm")){
		// if($("#tableAtm").length){

		} else {
			$("#tableAtm").DataTable({
				ajax:{
					type:"GET",
					url:"{{url('/ticketing/setting/getAllAtm')}}",
					dataSrc: function (json){
						json.data.forEach(function(data,idex){
							data.action = '<button type="button" class="btn btn-sm btn-flat btn-sm btn-block btn-secondary" onclick="editAtm('+ data.id + ')">Edit</button>'
						})
						return json.data
					}
				},
				columns:[
					{
						data:'owner',
						className:'text-center',
					},
					{ 	
						data:'atm_id',
						className:'text-center',
					},
					{
						data:'serial_number',
						className:'text-center',
					},
					{ 
						data:'location',
						className:'text-center',
					},
					{ 
						data:'activation',
						className:'text-center',
					},
					{
						data:'action',
						className:'text-center',
						orderable: false,
						searchable: true,
					}
				],
				// order: [[10, "DESC" ]],
				autoWidth:false,
				lengthChange: false,
				searching:true,
			})
		}

	}

	function EmailAdd(){
		$("#modal-add-email").modal('toggle');
		$("#selectPidforEmail").select2({
			ajax: {
        url: '{{url("asset/getPid")}}',
        processResults: function (data) {
          // Transforms the top-level key of the response object from 'items' to 'results'
          return {
            results: data
          };
        },
      },
      placeholder: 'Select Project ID',
      dropdownParent: $("#modal-add-email")
		}).on("change", function () {
			var pid = $(this).val()
			$.ajax({
				type:"GET",
				url:"{{url('/ticketing/mail/getClientByPid')}}",
				data:{
					pid:pid
				},
				success:function(result){
					$("#inputClientforEmail").val(result[0].id)
				}
			})
		})

		console.log($('.emailMultiSelector'))
		console.log('halo le')


		$('.emailMultiSelector').remove()

		$("#selectPidforEmail").empty()
		$("#selectPidforEmail").next("span").next("span.invalid-feedback").attr('style','display:none!important')
		$("#inputClientforEmail").val("")
		$("#dearAdd").val("")
		$("#toAdd").val("")
		$("#ccAdd").val("")
		$("#toAdd").emailinput({ onlyValidValue: true, delim: ';' })
		$("#ccAdd").emailinput({ onlyValidValue: true, delim: ';' })
		$('.emailMultiSelector').css('height','37.1px')
		// $("#closeToAdd").emailinput({ onlyValidValue: true, delim: ';' })
		// $("#closeCcAdd").emailinput({ onlyValidValue: true, delim: ';' })
	}

	function EmailSlmAdd(){
		$("#modal-add-slm-email").modal('toggle');
		$("#selectLevelSupport").select2({
			ajax: {
        url: '{{url("asset/getLevelSupport")}}',
        processResults: function (data) {
          // Transforms the top-level key of the response object from 'items' to 'results'
          return {
            results: data
          };
        },
      },
      placeholder: 'Select Second Level Support',
      dropdownParent: $("#modal-add-slm-email")
		})

		$('.emailMultiSelector').remove()

		$("#selectLevelSupport").empty()
		$("#selectLevelSupport").next("span").next("span.invalid-feedback").attr('style','display:none!important')
		$("#dearAddSlm").val("")
		$("#toAddSlm").val("")
		$("#ccAddSlm").val("")
		$("#toAddSlm").emailinput({ onlyValidValue: true, delim: ';' })
		$("#ccAddSlm").emailinput({ onlyValidValue: true, delim: ';' })
		$('.emailMultiSelector').css('height','37.1px')

		// $("#closeToAddSlm").emailinput({ onlyValidValue: true, delim: ';' })
		// $("#closeCcAddSlm").emailinput({ onlyValidValue: true, delim: ';' })
	}

	// function atmAdd(){
	// 	$.ajax({
	// 		type:"GET",
	// 		url:"{{url('/ticketing/setting/getParameterAddAtm')}}",
	// 		success:function(result){
	// 			$("#atmAddOwner").empty()
	// 			$.each(result, function (key,value){
	// 				$("#atmAddOwner").append("<option value='" + value.id + "'>(" + value.client_acronym + ") " + value.client_name + "</option>")
	// 			});
	// 		},
	// 		complete: function(){
	// 			$("#modal-setting-atm-add input.form-control, #modal-setting-atm-add textarea.form-control").val("")
	// 			$("#modal-setting-atm-add").modal('toggle');

	// 			settingListEngineerAssign("add",null,"modal-setting-atm-add")
	// 		}
	// 	});
	// }

	$("#atmAddOwner").change(function(){
		if(this.value == 26 || this.value == 27 || this.value == '54'){
			$.ajax({
				type:"GET",
				url:"{{url('/ticketing/create/getAtmId')}}",
				data:{
					acronym:$("#atmAddOwner option:selected").text().split("(")[1].split(")")[0],
				},
				success: function(result){
					$("#ATMadd").show()
					$("#ATMadd").select2({
						data:result
					});
					
					$("#atmAddID").attr('style','display:none!important')
				}
			});
			if(this.value == 26) {
				$("#peripheralAddFormCCTV, #peripheralAddFormButton").show()
				$("#peripheralAddForm").attr('style','display:none!important')
			} else {
				$("#peripheralAddForm, #peripheralAddFormButton").show()
				$("#peripheralAddFormCCTV").attr('style','display:none!important')
			}
			$("#atmAddForm, #atmAddFormButton").attr('style','display:none!important')
		} else {
			$("#peripheralAddForm, #peripheralAddFormCCTV, #peripheralAddFormButton").attr('style','display:none!important')
			$("#atmAddForm, #atmAddFormButton").show()
			if($('#ATMadd').hasClass("select2-hidden-accessible")){
				$("#ATMadd").select2('destroy')
			}
			$("#ATMadd").attr('style','display:none!important')
			$("#atmAddID").show()
		}
	})

	function newAtm(){
		var atmType = ($("#atmAddType").val() == "" ? "-" : $("#atmAddType").val())
		$.ajax({
			type:"GET",
			url:"{{url('/ticketing/setting/newAtm')}}",
			data:{
				atmOwner:$("#atmAddOwner").val(),
				atmID:$("#atmAddID").val(),
				atmSerial:$("#atmAddSerial").val(),
				atmLocation:$("#atmAddLocation").val(),
				atmVersion:$("#atmAddVersion").val(),
				atmOS:$("#atmAddOS").val(),
				atmType:atmType,
				atmAddress:$("#atmAddAddress").val(),
				atmActivation:$("#atmAddActivation").val(),
				atmNote:$("#atmAddNote").val(),
				atmEngineer:$("#addAssignEngineer").val()
			},
			success: function (data){
				if(!$.isEmptyObject(data.error)){
					var errorMessage = ""
					data.error.forEach(function(data,index){
						errorMessage = errorMessage + data + "<br>";
					})
          swalWithCustomClass.fire(
						'Error',
						errorMessage,
						'error'
					)
        } else {
          swalWithCustomClass.fire(
						'Success',
						'ATM Added',
						'success'
					)
					$("#modal-setting-atm-add").modal('toggle');
					$("#tableAtm").DataTable().ajax.url("/ticketing/setting/getAllAtm").load();
        }
			},
		})
	}

	function newPeripheral(){
		if($("#atmAddOwner").val() == 26){
			$.ajax({
				type:"GET",
				url:"{{url('/ticketing/setting/newAtmPeripheral')}}",
				data:{
					atmOwner:$("#atmAddOwner").val(),
					atmID:$("#ATMadd").select2('data')[0].text.split(' -')[0],
					peripheralID:"-",
					// peripheralMachineType:$("#atmAddPeripheralType").val(),
					// peripheralSerial:$("#atmAddPeripheralSerial").val(),

					peripheral_cctv_dvr_sn:$("#atmAddPeripheralSerialCCTVDVR").val(),
					peripheral_cctv_dvr_type:$("#atmAddPeripheralTypeCCTVDVR").val(),
					peripheral_cctv_besar_sn:$("#atmAddPeripheralSerialCCTVBesar").val(),
					peripheral_cctv_besar_type:$("#atmAddPeripheralTypeCCTVBesar").val(),
					peripheral_cctv_kecil_sn:$("#atmAddPeripheralSerialCCTVKecil").val(),
					peripheral_cctv_kecil_type:$("#atmAddPeripheralTypeCCTVKecil").val()
				},
				success: function (data){
	        swalWithCustomClass.fire(
						'Success',
						'ATM CCTV Added',
						'success'
					)
					$("#modal-setting-atm-add").modal('toggle');
					$("#tableAtm").DataTable().ajax.url("/ticketing/setting/getAllAtm").load();
				},
			})
		} else {
			$.ajax({
				type:"GET",
				url:"{{url('/ticketing/setting/newAtmPeripheral')}}",
				data:{
					atmOwner:$("#atmAddOwner").val(),
					atmID:$("#ATMadd").select2('data')[0].text.split(' -')[0],
					peripheralID:"-",
					peripheralMachineType:$("#atmAddPeripheralType").val(),
					peripheralSerial:$("#atmAddPeripheralSerial").val(),
				},
				success: function (data){
	        swalWithCustomClass.fire(
						'Success',
						'ATM UPS Added',
						'success'
					)
					$("#modal-setting-atm-add").modal('toggle');
					$("#tableAtm").DataTable().ajax.url("/ticketing/setting/getAllAtm").load();
				},
			})
		}
	}

	function editAtm(atm_id){
		$.ajax({
			type:"GET",
			url:"{{url('/ticketing/setting/getDetailAtm')}}",
			data:{
				id_atm:atm_id
			},
			success:function(result){
				$.each(result.client, function (key,value){
					$("#atmEditOwner").append("<option value='" + value.id + "'>(" + value.client_acronym + ") " + value.client_name + "</option>")
				});
				$("#idEditAtm").val(atm_id);
				$("#atmEditOwner").val(result.atm.owner);
				$("#atmEditID").val(result.atm.atm_id);
				$("#atmEditSerial").val(result.atm.serial_number);
				$("#atmEditLocation").val(result.atm.location);
				$("#atmEditAddress").val(result.atm.address);
				$("#atmEditActivation").val(moment(result.atm.activation,'YYYY-MM-DD').format('DD/MM/YYYY'));
				$("#atmEditNote").val(result.atm.note);
				$("#atmEditType").val(result.atm.machine_type);

				if(result.atm.owner == 19 || result.atm.owner == 48){
					var append = ""
					$.each(result.atm.peripheral,function (key,value){
						if(value.type == "CCTV"){
							if(value.cctv_dvr_type != ""){
								append = append + "<li class='itemPeriperal itemPeriperalEach" + value.id + "-" + 1 + "'>"
								append = append + "<span class='pull-right button-edit-periperal'><button onclick='editAtmPeriperal(" + value.id + "," + 1 + ")' class='btn btn-primary btn-flat btn-xs' type='button'>Edit</button></span>"
								append = append + "<span>"
								append = append + "<b>[" + value.type + " DVR] <span class='itemPeriperalEach" + value.id + "-" + 1 + "-type'>" + value.cctv_dvr_type + "</span></b>"
								append = append + "<br>"
								append = append + "Serial Number : <span class='itemPeriperalEach" + value.id + "-" + 1 + "-sn'>" + value.cctv_dvr_sn + "</span>"
								append = append + "</span>"
							}

							if(value.cctv_besar_type != ""){
								append = append + "</li>"
								append = append + "<li class='itemPeriperal itemPeriperalEach" + value.id + "-" + 2 + "'>"
								append = append + "<span class='pull-right button-edit-periperal'><button onclick='editAtmPeriperal(" + value.id + "," + 2 + ")' class='btn btn-primary btn-flat btn-xs' type='button'>Edit</button></span>"
								append = append + "<span>"
								append = append + "<b>[" + value.type + " Eksternal] <span class='itemPeriperalEach" + value.id + "-" + 2 + "-type'>" + value.cctv_besar_type + "</span></b><br>"
								append = append + "Serial Number : <span class='itemPeriperalEach" + value.id + "-" + 2 + "-sn'>" + value.cctv_besar_sn + "</span>"
								append = append + "</span>"
								append = append + "</li>"
							}
							if(value.cctv_kecil_type != ""){
								append = append + "<li class='itemPeriperal itemPeriperalEach" + value.id + "-" + 3 + "'>"
								append = append + "<span class='pull-right button-edit-periperal'><button onclick='editAtmPeriperal(" + value.id + "," + 3 + ")' class='btn btn-primary btn-flat btn-xs' type='button'>Edit</button></span>"
								append = append + "<span>"
								append = append + "<b>[" + value.type + " Internal] <span class='itemPeriperalEach" + value.id + "-" + 3 + "-type'>" + value.cctv_kecil_type + "</span></b><br>"
								append = append + "Serial Number : <span class='itemPeriperalEach" + value.id + "-" + 3 + "-sn'>" + value.cctv_kecil_sn + "</span>"
								append = append + "</span>"
								append = append + "</li>"
							}
						} else {
							if(value.machine_type != ""){
								append = append + "<li class='itemPeriperal itemPeriperalEach" + value.id + "-" + 4 + "'>"
								append = append + "<span class='pull-right button-edit-periperal'><button onclick='editAtmPeriperal(" + value.id + "," + 4 + ")' class='btn btn-primary btn-flat btn-xs' type='button'>Edit</button></span>"
								append = append + "<span>"
								append = append + "	<b>[" + value.type + "] <span class='itemPeriperalEach" + value.id + "-" + 4 + "-type'>" + value.machine_type + "</span></b><br>"
								append = append + "	Serial Number : <span class='itemPeriperalEach" + value.id + "-" + 4 + "-sn'>" + value.serial_number + "</span>"
								append = append + "</span>"
								append = append + "</li>"
							}
						}
					})
					$("#atmEditPeripheralField").empty()
					$("#atmEditPeripheralField").append(append)
					$("#atmEditPeripheral").show()
				} else {
					$("#atmEditPeripheral").attr('style','display:none!important')
				}

				$("#modal-setting-atm").modal('toggle');
				settingListEngineerAssign("edit",result.atm.engineer_atm,"modal-setting-atm")
			}
		});
	}

	function saveAtm(){
		$.ajax({
			type:"GET",
			url:"{{url('/ticketing/setting/setAtm')}}",
			data:{
				idAtm:$("#idEditAtm").val(),
				atmOwner:$("#atmEditOwner").val(),
				atmID:$("#atmEditID").val(),
				atmSerial:$("#atmEditSerial").val(),
				atmLocation:$("#atmEditLocation").val(),
				atmVersion:$("#atmEditVersion").val(),
				atmOS:$("#atmEditOS").val(),
				atmAddress:$("#atmEditAddress").val(),
				atmActivation:$("#atmEditActivation").val(),
				atmType:$("#atmEditType").val(),
				atmNote:$("#atmEditNote").val(),
				atmEngineer:$("#editAssignEngineer").val()
			},
			success: function (data){
				if(!$.isEmptyObject(data.error)){
					var errorMessage = ""
					data.error.forEach(function(data,index){
						errorMessage = errorMessage + data + "<br>";
					})
                    swalWithCustomClass.fire(
						'Error',
						errorMessage,
						'error'
					)
                } else {
                	 swalWithCustomClass.fire(
						'Success',
						'ATM Changed',
						'success'
					)
					$("#modal-setting-atm").modal('toggle');
					$("#tableAtm").DataTable().ajax.url("/ticketing/setting/getAllAtm").load();
                }
			}
		})
	}

	function deleteAtm(){
		swalWithCustomClass.fire({
			title: 'Are you sure?',
			text: "To delete this ATM?",
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
						text: "It's Deleting",
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

					$.ajax({
						type:"GET",
						url:"{{url('/ticketing/setting/deleteAtm')}}",
						data:{
							idAtm:$("#idEditAtm").val(),
						},
						success: function(resultAjax){
							Swal.hideLoading()
							swalWithCustomClass.fire({
								title: 'Success!',
								text: "ATM Deleted",
								icon: 'success',
								confirmButtonText: 'Reload',
							}).then((result) => {
								$("#modal-setting-atm").modal('toggle');
								$("#tableAtm").DataTable().ajax.url("/ticketing/setting/getAllAtm").load();
							})
						}
					});
				}
			}
		);
	}

	function editAtmPeriperal(id,type){
		var selector = ".itemPeriperalEach" + id + "-" + type
		
		var cancleHolderPeriperal = "$(selector).html()"

		var append = ""
		append = append + '<li class="itemPeriperalEachEdit' + id + '-' + type + '">'
		append = append + '<span class="pull-right button-edit-periperal">'
		selectorHolder = "'" + selector + "'" 
		holder = "'.itemPeriperalEachEdit" + id + "-" + type + "'"
		append = append + '	<button onclick="saveAtmPeriperal(' + selectorHolder +  ',' + holder + ',' + id + ',' + type +')" class="btn btn-sm btn-success btn-flat btn-xs" type="button">Save</button>'
		append = append + '	<button onclick="deleteAtmPeriperal(' + selectorHolder +  ',' + holder + ',' + id + ',' + type +')" class="btn btn-sm btn-danger btn-flat btn-xs" type="button">Delete</button>'
		append = append + '	<button onclick="cancelAtmPeriperal(' + selectorHolder +  ',' + holder + ',' + id + ',' + type +')" class="btn btn-sm btn-secondary btn-flat btn-xs" type="button">Cancel</button>'
		append = append + '</span>'
		append = append + '<span>'
		type = (type == 1 ? "CCTV DVR" : (type == 2 ? "CCTV Eksternal" : (type == 3 ? "CCTV Internal" : "UPS")))
		append = append + '	<b>[' + type + ']</b> <input type="text" class="from-control editPeripheralType" value="' + $(selector + "-type").text() + '"><br>'
		append = append + '	Serial Number : <input type="text" class="from-control editPeripheralSerial" value="' + $(selector + "-sn").text() + '">'
		append = append + '</span>'
		append = append + '</li>'
		$(selector).attr('style','display:none!important')
		$(append).insertAfter(selector)
	}

	function cancelAtmPeriperal(selector, holder){
		$(selector).show()
		$(holder).remove()
	}

	function saveAtmPeriperal(selector,holder,id,type){
		swalWithCustomClass.fire({
			title: 'Are you sure?',
			text: "Make sure there is nothing wrong from editing this preriperal!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: 'Yes',
			cancelButtonText: 'No'
		}).then((result) => {
			if (result.value){
				Swal.fire({
					title: 'Please Wait..!',
					text: "It's editing..",
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
				$.ajax({
					type: "GET",
					url: "{{url('/ticketing/setting/editAtmPeripheral')}}",
					data: {
						id:id,
						type:type,
						typeEdit:$(holder + " input.editPeripheralType").val(),
						serialEdit:$(holder + " input.editPeripheralSerial").val(),
					},
					success: function(resultAjax){
						Swal.hideLoading()
						swalWithCustomClass.fire({
							title: 'Success!',
							text: "Periperal save.",
							icon: 'success',
							confirmButtonText: 'Reload',
						}).then((result) => {
							$(selector).show()
							$(selector + "-type").text($(holder + " input.editPeripheralType").val())
							$(selector + "-sn").text($(holder + " input.editPeripheralSerial").val())
							$(holder).remove()
						})
					}
				});
			}
		})
	}

	function deleteAtmPeriperal(selector,holder,id,type){
		swalWithCustomClass.fire({
			title: 'Are you sure?',
			text: "Make sure there is nothing wrong to delete this preriperal!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: 'Yes',
			cancelButtonText: 'No'
		}).then((result) => {
			if (result.value){
				Swal.fire({
					title: 'Please Wait..!',
					text: "It's deleting..",
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
				$.ajax({
					type: "GET",
					url: "{{url('/ticketing/setting/deleteAtmPeripheral')}}",
					data: {
						id:id,
						type:type
					},
					success: function(resultAjax){
						Swal.hideLoading()
						swalWithCustomClass.fire({
							title: 'Success!',
							text: "Periperal deleted.",
							icon: 'success',
							confirmButtonText: 'Reload',
						}).then((result) => {
							$(selector).remove()
							$(holder).remove()
						})
					}
				});
			}
			
		})
	}

	function absenSetting(){
		$(".settingComponent").attr('style','display:none!important')
		$("#absenSetting").show()
		$("#addAbsen").show()
		$("#addAbsen2").show()

		if($.fn.dataTable.isDataTable("#tableAbsen")){
		// if($("#tableAbsen").length){

		} else {
			$("#tableAbsen").DataTable({
				ajax:{
					type:"GET",
					url:"{{url('/ticketing/setting/getAllAbsen')}}",
					dataSrc: function (json){
						json.data.forEach(function(data,idex){
							data.action = '<button type="button" class="btn btn-sm btn-flat btn-block btn-secondary" onclick="editAbsen(' + data.id + ')">Edit</button>'
						})
						return json.data
					}
				},
				columns:[
					{
						data:'nama_cabang',
						className:'text-center',
					},
					{ 	
						data:'nama_kantor',
						className:'text-center',
					},
					{
						data:'type_machine',
						className:'text-center',
					},
					{ 
						data:'ip_machine',
						className:'text-center',
					},
					{ 
						data:'ip_server',
						className:'text-center',
					},
					{
						data:'action',
						className:'text-center',
						orderable: false,
						searchable: true,
					}
				],
				// order: [[10, "DESC" ]],
				autoWidth:false,
				lengthChange: false,
				searching:true,
			})
		}
	}

	function absenAdd(){
		$("#modal-setting-absen-add input.form-control").val("")
		$("#modal-setting-absen-add").modal('toggle');
	}

	function newAbsen(){
		$.ajax({
			type:"GET",
			url:"{{url('/ticketing/setting/newAbsen')}}",
			data:{
				absenAddNamaCabang:$("#absenAddNamaCabang").val(),
				absenAddNamaKantor:$("#absenAddNamaKantor").val(),
				absenAddMachineType:$("#absenAddMachineType").val(),
				absenAddIPMachine:$("#absenAddIPMachine").val(),
				absenAddIPServer:$("#absenAddIPServer").val()
			},
			success: function (data){
				if(!$.isEmptyObject(data.error)){
					var errorMessage = ""
					data.error.forEach(function(data,index){
						errorMessage = errorMessage + data + "<br>";
					})
                    swalWithCustomClass.fire(
						'Error',
						errorMessage,
						'error'
					)
                } else {
                	 swalWithCustomClass.fire(
						'Success',
						'Absen Added',
						'success'
					)
					$("#modal-setting-absen-add").modal('toggle');
					$("#tableAbsen").DataTable().ajax.url("/ticketing/setting/getAllAbsen").load();
                }
			},
		})
	}

	function editAbsen(absen_id){
		$.ajax({
			type:"GET",
			url:"{{url('/ticketing/setting/getDetailAbsen')}}",
			data:{
				id_absen:absen_id
			},
			success:function(result){
				$("#idEditAbsen").val(result.absen.id)
				$("#absenEditNamaCabang").val(result.absen.nama_cabang)
				$("#absenEditNamaKantor").val(result.absen.nama_kantor)
				$("#absenEditMachineType").val(result.absen.type_machine)
				$("#absenEditIPMachine").val(result.absen.ip_machine)
				$("#absenEditIPServer").val(result.absen.ip_server)

				$("#modal-setting-absen").modal('toggle');
			}
		});
	}

	function saveAbsen(){
		$.ajax({
			type:"GET",
			url:"{{url('/ticketing/setting/setAbsen')}}",
			data:{
				idAbsen:$("#idEditAbsen").val(),
				absenEditNamaCabang:$("#absenEditNamaCabang").val(),
				absenEditNamaKantor:$("#absenEditNamaKantor").val(),
				absenEditMachineType:$("#absenEditMachineType").val(),
				absenEditIPMachine:$("#absenEditIPMachine").val(),
				absenEditIPServer:$("#absenEditIPServer").val()
			},
			success: function (data){
				if(!$.isEmptyObject(data.error)){
					var errorMessage = ""
					data.error.forEach(function(data,index){
						errorMessage = errorMessage + data + "<br>";
					})
                    swalWithCustomClass.fire(
						'Error',
						errorMessage,
						'error'
					)
                } else {
                	 swalWithCustomClass.fire(
						'Success',
						'Absen Changed',
						'success'
					)
					$("#modal-setting-absen").modal('toggle');
					$("#tableAbsen").DataTable().ajax.url("/ticketing/setting/getAllAbsen").load();
                }
			}
		})
	}

	function deleteAbsen(){
		swalWithCustomClass.fire({
			title: 'Are you sure?',
			text: "To delete this Absen?",
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
						text: "It's Deleting",
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

					$.ajax({
						type:"GET",
						url:"{{url('/ticketing/setting/deleteAbsen')}}",
						data:{
							idAbsen:$("#idEditAbsen").val(),
						},
						success: function(resultAjax){
							Swal.hideLoading()
							swalWithCustomClass.fire({
								title: 'Success!',
								text: "Absen Deleted",
								icon: 'success',
								confirmButtonText: 'Reload',
							}).then((result) => {
								$("#modal-setting-absen").modal('toggle');
								$("#tableAbsen").DataTable().ajax.url("/ticketing/setting/getAllAbsen").load();
							})
						}
					});
				}
			}
		);
	}

	$('#daterange-btn').daterangepicker(
		{
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			startDate: moment().subtract(29, 'days'),
			endDate: moment()
		},
		function (start, end) {
			$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			if ($("#selectReportingType").val() == "slmReport") {
				var urlAjax = '{{url("/ticketing/report/makeSLM")}}?type=' + $("#selectTypeTicket").val() + '&start=' + $('#daterange-btn').data('daterangepicker').startDate.format('YYYY-MM-DD') + '&end=' + $('#daterange-btn').data('daterangepicker').endDate.format('YYYY-MM-DD')
				$("#ReportingButtonGo").attr('onclick',"getReport('" + urlAjax + "')")

				$("#ReportingButtonGo").show()
			}else if($("#selectReportingType").val() == "slmReportPending"){
				var urlAjax = '{{url("/ticketing/report/makeSLMPending")}}?type=' + $("#selectTypeTicket").val() + '&start=' + $('#daterange-btn').data('daterangepicker').startDate.format('YYYY-MM-DD') + '&end=' + $('#daterange-btn').data('daterangepicker').endDate.format('YYYY-MM-DD')
				$("#ReportingButtonGo").attr('onclick',"getReport('" + urlAjax + "')")

				$("#ReportingButtonGo").show()
			}else{
				$("#ReportingButtonGoNew").show()
			}
		}
	);

	$('#daterange-btn2').daterangepicker(
		{
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			startDate: moment().subtract(29, 'days'),
			endDate: moment()
		},
		function (start, end) {
			$('#daterange-btn2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			$("#ReportingButtonGoNew2").show()
		}
	);

	function switchSetting(){
		$(".settingComponent").attr('style','display:none!important')
		$("#switchSetting").show()
		$("#addSwitch").show()
		$("#addSwitch2").show()

		if($("#tableSwitch").length){

		} else {
			$("#tableSwitch").DataTable({
				ajax:{
					type:"GET",
					url:"{{url('/ticketing/setting/getAllSwitch')}}",
					dataSrc: function (json){
						json.data.forEach(function(data,idex){
							data.action = '<button type="button" class="btn btn-sm btn-flat btn-block btn-secondary" onclick="editSwitch(' + data.id + ')">Edit</button>'
						})
						return json.data
					}
				},
				columns:[
					{
						data:'location',
						className:'text-center',
					},
					{ 	
						data:'cabang',
						className:'text-center',
					},
					{
						data:'type',
						className:'text-center',
					},
					{ 
						data:'port',
						className:'text-center',
					},
					{ 
						data:'serial_number',
						className:'text-center',
					},
					{ 
						data:'ip_management',
						className:'text-center',
					},
					{
						data:'action',
						className:'text-center',
						orderable: false,
						searchable: true,
					}
				],
				// order: [[10, "DESC" ]],
				autoWidth:false,
				lengthChange: false,
				searching:true,
			})
		}
	}

	function switchAdd(){
		$("#modal-setting-switch-add input.form-control").val("")
		$("#modal-setting-switch-add").modal('toggle');
	}

	function newSwitch(){
		$.ajax({
			type:"GET",
			url:"{{url('/ticketing/setting/newSwitch')}}",
			data:{
				switchAddType:$("#switchAddType").val(),
				switchAddPort:$("#switchAddPort").val(),
				switchAddSerialNumber:$("#switchAddSerialNumber").val(),
				switchAddIPManagement:$("#switchAddIPManagement").val(),
				switchAddLocation:$("#switchAddLocation").val(),
				switchAddCabang:$("#switchAddCabang").val(),
				switchAddNote:$("#switchAddNote").val()
			},
			success: function (data){
				if(!$.isEmptyObject(data.error)){
					var errorMessage = ""
					data.error.forEach(function(data,index){
						errorMessage = errorMessage + data + "<br>";
					})
                    swalWithCustomClass.fire(
						'Error',
						errorMessage,
						'error'
					)
                } else {
                	 swalWithCustomClass.fire(
						'Success',
						'Absen Added',
						'success'
					)
					$("#modal-setting-switch-add").modal('toggle');
					$("#tableSwitch").DataTable().ajax.url("/ticketing/setting/getAllSwitch").load();
                }
			},
		})
	}

	function editSwitch(switch_id){
		$.ajax({
			type:"GET",
			url:"{{url('/ticketing/setting/getDetailSwitch')}}",
			data:{
				id_switch:switch_id
			},
			success:function(result){
				$("#switchEditType").val(result.switch.type)
				$("#switchEditPort").val(result.switch.port)
				$("#switchEditSerialNumber").val(result.switch.serial_number)
				$("#switchEditIPManagement").val(result.switch.ip_management)
				$("#switchEditLocation").val(result.switch.location)
				$("#switchEditCabang").val(result.switch.cabang)
				$("#switchEditNote").val(result.switch.note)
				$("#idEditSwitch").val(result.switch.id)

				$("#modal-setting-switch").modal('toggle');
			}
		});
	}

	function saveSwitch(){
		$.ajax({
			type:"GET",
			url:"{{url('/ticketing/setting/setSwitch')}}",
			data:{
				idSwitch:$("#idEditSwitch").val(),
				switchEditType:$("#switchEditType").val(),
				switchEditPort:$("#switchEditPort").val(),
				switchEditSerialNumber:$("#switchEditSerialNumber").val(),
				switchEditIPManagement:$("#switchEditIPManagement").val(),
				switchEditLocation:$("#switchEditLocation").val(),
				switchEditCabang:$("#switchEditCabang").val(),
				switchEditNote:$("#switchEditNote").val(),
			},
			success: function (data){
				if(!$.isEmptyObject(data.error)){
					var errorMessage = ""
					data.error.forEach(function(data,index){
						errorMessage = errorMessage + data + "<br>";
					})
                    swalWithCustomClass.fire(
						'Error',
						errorMessage,
						'error'
					)
                } else {
                	 swalWithCustomClass.fire(
						'Success',
						'Absen Changed',
						'success'
					)
					$("#modal-setting-switch").modal('toggle');
					$("#tableSwitch").DataTable().ajax.url("/ticketing/setting/getAllSwitch").load();
                }
			}
		})
	}

	function deleteSwitch(){
		swalWithCustomClass.fire({
			title: 'Are you sure?',
			text: "To delete this Switch?",
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
						text: "It's Deleting",
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

					$.ajax({
						type:"GET",
						url:"{{url('/ticketing/setting/deleteSwitch')}}",
						data:{
							idSwitch:$("#idEditSwitch").val(),
						},
						success: function(resultAjax){
							Swal.hideLoading()
							swalWithCustomClass.fire({
								title: 'Success!',
								text: "Switch Deleted",
								icon: 'success',
								confirmButtonText: 'Reload',
							}).then((result) => {
								$("#modal-setting-switch").modal('toggle');
								$("#tableSwitch").DataTable().ajax.url("/ticketing/setting/getAllSwitch").load();
							})
						}
					});
				}
			}
		);
	}

	$.ajax({
		type:"GET",
		url:"{{url('/ticketing/report/getParameter')}}",
		success:function(result){
			$("#selectReportingClient").append("<option>Select Client</option>")
			$("#selectReportingMonth").append("<option>Select Month</option>")
			$("#selectReportingYear").append("<option>Select Year</option>")

			let dataClient = []

			result.client_data.forEach(function(data,index){
				dataClient.push({id: data.id, text: '[' + data.client_acronym + '] - ' + data.client_name})
			})

			$("#selectReportingClient").select2({
        placeholder: " Select Client",
        data:dataClient,
      }).change(function(){
				var acronym_client = $("#selectReportingClient option:selected").text().split(" - ")[0].replace(/\[|\]/g, '');
      	if ($("#selectReportingType").val() == "finishReportPid") {
      		$.ajax({
						type:"GET",
						url:"{{url('/ticketing/report/getPidAssigned')}}",
						data:{
							client_acronym:acronym_client
						},
						success:function(result){
							$("#selectPIDReport").empty("")
							$("#selectPIDReport").select2({
								placeholder:"Select PID",
								data:result,
								multiple:true
							})
						}
					})
      	}
      })

			result.ticket_year.forEach(function(data,index){
				$("#selectReportingYear").append("<option value='" + data.year + "'>" + data.year + "</option>")
			})

			// $("#selectReportingMonth").empty()
			moment.months().forEach(function(data,index){
				if(index < moment().format('M')){
					$("#selectReportingMonth").append("<option value='" + index + "'>" + data + "</option>")
				}else{
					$("#selectReportingMonth").append("<option value='" + index + "'>" + data + "</option>")
				}
			})
		}
	})

	$("#selectReportingType").change(function(){
		$("#selectReportingClient").val("").trigger("change")
		$("#ReportingButtonGo, #ReportingButtonGoNew, #ReportingButtonGoNew2").attr('style','display:none!important')
		if($(this).val() == 'finishReport'){
			$(".divReportingClient").show()
			$(".divTypeTicket").show()
			$(".divReportingYear").show()
			$(".divReportingMonth").show()
			$(".divPID").attr('style','display:none!important')
			$(".divDateRange").attr('style','display:none!important')
		} else if($(this).val() == 'helpdeskReport'){
			$(".divTypeTicket").show()
			$(".divDateRange").show()
			$(".divReportingClient").attr('style','display:none!important')
			$(".divReportingYear").attr('style','display:none!important')
			$(".divReportingMonth").attr('style','display:none!important')
			$(".divPID").attr('style','display:none!important')
		} else if ($(this).val() == 'finishReportPid') {
			$("#selectPIDReport").empty("")

			$(".divReportingClient").show()
			$(".divPID").show()
			$(".divTypeTicket").show()
			$(".divReportingYear").show()
			$(".divReportingMonth").show()
			$(".divDateRange").attr('style','display:none!important')
		}else if ($(this).val() == 'slmReport' || $(this).val() == 'slmReportPending') {
			$("#selectPIDReport").empty("")

			$(".divReportingClient").attr('style','display:none!important')
			$(".divPID").attr('style','display:none!important')
			$(".divTypeTicket").show()
			$(".divReportingYear").attr('style','display:none!important')
			$(".divReportingMonth").attr('style','display:none!important')
			$(".divDateRange").show()
		} else {
			$(".divReportingClient").attr('style','display:none!important')
			$(".divPID").attr('style','display:none!important')
			$(".divTypeTicket").attr('style','display:none!important')
			$(".divReportingYear").attr('style','display:none!important')
			$(".divReportingMonth").attr('style','display:none!important')
			$(".divDateRange").attr('style','display:none!important')
		}
	})

	$("#selectReportingYear").change(function(){
		$("#selectReportingMonth").empty()

		if ($("#selectReportingYear").val() !== moment().format('YYYY') && $("#selectReportingYear").val() !== "Select Year"){
			$("#selectReportingMonth").append("<option>Select Month</option>")
			moment.months().forEach(function(data,index){
				$("#selectReportingMonth").append("<option value='" + index + "'>" + data + "</option>")
			})
		} else if ($("#selectReportingYear").val() === moment().format('YYYY')){
			$("#selectReportingMonth").append("<option>Select Month</option>")
			moment.months().forEach(function(data,index){
				if(index < moment().format('M')){
					$("#selectReportingMonth").append("<option value='" + index + "'>" + data + "</option>")
				}
			})
		}

		if ($("#selectReportingType").val() == "finishReport") {
			var urlAjax = '{{url("/ticketing/report/make")}}?client=' + $("#selectReportingClient").val() + '&type=' + $("#selectTypeTicket").val() + '&year=' + $("#selectReportingYear").val() + '&month=' 

			$("#ReportingButtonGo").attr('onclick',"getReport('" + urlAjax + "')")

			$("#ReportingButtonGo").show()			
		}else if ($("#selectReportingType").val() == "finishReportPid") {
			var urlAjax = '{{url("/ticketing/report/makePID")}}?client=' + $("#selectReportingClient").val() + '&pid=' + $("#selectPIDReport").val() + '&type=' + $("#selectTypeTicket").val() + '&year=' + $("#selectReportingYear").val() + '&month=' 

			$("#ReportingButtonGo").attr('onclick',"getReport('" + urlAjax + "')")

			$("#ReportingButtonGo").show()			
		}

		$("#selectReportingMonth").change(function(){
			if ($("#selectReportingType").val() == "finishReport") {
				var urlAjax = '{{url("/ticketing/report/make")}}?client=' + $("#selectReportingClient").val() + '&type=' + $("#selectTypeTicket").val() + '&year=' + $("#selectReportingYear").val() + '&month=' + $("#selectReportingMonth").val()

				$("#ReportingButtonGo").attr('onclick',"getReport('" + urlAjax + "')")

				$("#ReportingButtonGo").show()			
			}else if ($("#selectReportingType").val() == "finishReportPid") {
				var urlAjax = '{{url("/ticketing/report/makePID")}}?client=' + $("#selectReportingClient").val() + '&pid=' + $("#selectPIDReport").val() + '&type=' + $("#selectTypeTicket").val() + '&year=' + $("#selectReportingYear").val() + '&month=' + $("#selectReportingMonth").val()

				$("#ReportingButtonGo").attr('onclick',"getReport('" + urlAjax + "')")

				$("#ReportingButtonGo").show()			
			}		
		})
	})

	function getReport(urlAjax){
		swalWithCustomClass.fire({
			title: 'Are you sure?',
			text: "Make sure there is nothing wrong to get this report ticket!",
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

					$.ajax({
						type: "GET",
						url: urlAjax,
						success: function(result){
							Swal.hideLoading()
							if(result == 0){
								swalWithCustomClass.fire({
									//icon: 'error',
									title: 'Error!',
									text: "The file is unavailable",
									type: 'error',
									//confirmButtonText: '<a style="color:#fff;" href="report/' + result.slice(1) + '">Get Report</a>',
								})
							}else{
								swalWithCustomClass.fire({
									title: 'Success!',
									text: "You can get your file now",
									type: 'success',
									confirmButtonText: '<a style="color:#fff;" href="report/' + result + '">Get Report</a>',
									// confirmButtonText: '<a style="color:#fff;" href="' + result + '">Get Report</a>',
								})
							}
						}
					});
				}
			}
		);
	}

	$("#ReportingButtonGoNew").on('click',function(){
		swalWithCustomClass.fire({
			title: 'Are you sure?',
			text: "Make sure there is nothing wrong to get this report bayu!",
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

					$.ajax({
						type:"GET",
						url:"{{url('/ticketing/report/new')}}",
						data:{
							type:$("#selectTypeTicket").val(),
							start:$('#daterange-btn').data('daterangepicker').startDate.format('YYYY-MM-DD'),
							end:$('#daterange-btn').data('daterangepicker').endDate.format('YYYY-MM-DD')
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
									confirmButtonText: '<a style="color:#fff;" href="report/bayu/' + result + '">Get Report</a>',
								})
							}
						}
					})
				}
			}
		);
	})

	$("#ReportingButtonGoNew2").on('click',function(){
		swalWithCustomClass.fire({
			title: 'Are you sure?',
			text: "Make sure there is nothing wrong to get this report denny!",
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

					$.ajax({
						type:"GET",
						url:"{{url('/ticketing/report/newDeny')}}",
						data:{
							start:$('#daterange-btn2').data('daterangepicker').startDate.format('YYYY-MM-DD 00:00:00'),
							end:$('#daterange-btn2').data('daterangepicker').endDate.format('YYYY-MM-DD 23:59:59')
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
									confirmButtonText: '<a style="color:#fff;" href="report/denny/' + result + '">Get Report</a>',
								})
							}
						}
					})
				}
			}
		);
	})

	function userSetting() {
		///////
		$("#emailSetting").attr('style','display:none!important')
		$("#SlmEmailSetting").attr('style','display:none!important')
		$("#SlaSetting").attr('style','display:none!important')
		$("#addEmail2").addClass('d-none')
		$("#addEmail").addClass('d-none')
		$("#userSetting").show()
		showDivSiteBox($("#assignFilter").val(),"/ticketing/setting/getUserShifting")
    	initiateFilter()
	}

	function showDivSiteBox(defaultAssign,url){		
		$.ajax({
			type:"GET",
			url:"{{url('/')}}"+url,
			success:function(result){
				$(".divSiteBox").empty("")

				let append = "", nik = []
				let columnCount = 0

  			append = append + "<div style='column-count:2;column-gap:10px' id='container_pid'></div>"
  			// append = append + "<div class='container_pid' id='container_pid'></div>"
				$(".divSiteBox").append(append)	

				result.forEach(function	(index,items){
					nik.push({
						"nik": index.nik
					})
				})	

    		$.each(result,function(item,value){
    			// if (item % 3 === 0) {
    			// $("#container_pid").append("<div class='widthBoxPID column_pid'></div>")
    				// columnCount++
						// append = append + "<div style='width:50%'></div>"
    			// }

  				let append_column = ""
    			append_column = append_column + "<div class='alert bg-gray disabled' style='margin-bottom:10px!important;break-inside:avoid;'>"
						append_column = append_column + "<div style='position:relative'>"
							append_column = append_column + "<span class='showPID' data-value='"+ item +"' onclick='showPID("+ item +"," + '['+ nik[item].nik + "]" +")' style='position:absolute;right:0;top:0'><i class='fa fa-2x fa-angle-right'></i></span>"
							append_column = append_column + "	<h6><b class='titleh6' data-value='"+ item +"'></b></h6>"
							append_column = append_column + "	<p class='titleP' data-value='"+ item +"'></p>"
							append_column = append_column + "<div style='position:relative'>"
								append_column = append_column + "<span class='badge text-bg-primary' style='position:absolute;right:0;bottom:0'>"+ value.count +"</span>"
							append_column = append_column + "</div>"
								append_column = append_column + "<div class='divPID' data-value='"+ item +"' style='overflow:x;padding:8px;border-radius:5px;display:none;margin-top:25px'>"
									append_column = append_column + "<div class='row'>"
										append_column = append_column + "<div class='col-md-12'>"
											append_column = append_column + "<div>"
												append_column = append_column + "<div style='display: flex;'><div class='input-group searchTablePID' style='flex-direction: row; margin: 10px; width: 50% !important;' data-value='"+ item +"'><input class='form-control' placeholder='Search Cutsomer/PID/Project Name' id='searchbarPID' onkeyup='searchCustomPID("+ item + ")' data-value='"+ item +"'><span class='input-group-btn'><button onclick='searchCustomPID("+ item + ")' type='button' class='btn btn-secondary btn-flat' fdprocessedid='f23lya'>	<i class='fa fa-fw fa-search'></i></button></span></div>"
													append_column = append_column + "<span style='margin-top: 19px;' data-toggle='tooltip' data-placement='top' title='Please search for more PID list!'><i class='fa fa-question-circle' style='font-size: 1.2em;color: #579bcf;'></i></span>"
												append_column = append_column + "</div>"
											append_column = append_column + "</div>"
											append_column = append_column + "<div class='boxPID' data-value='"+ item +"'>"
											append_column = append_column + "</div>"
											append_column = append_column + "<button class='btn btn-sm text-bg-primary btnSavePID pull-right' data-value='"+ item +"' style='margin:10px;display:none'>"
												append_column = append_column + "Save"
											append_column = append_column + "</button>"
										append_column = append_column + "</div>"					
									append_column = append_column + "</div>"
								append_column = append_column + "</div>"
							append_column = append_column + "</div>"
						append_column = append_column + "</div>"
					append_column = append_column + "</div>"

					// $(".column_pid").eq(columnCount - 1).append(append_column)
					$("#container_pid").append(append_column)

					if (defaultAssign == 'user') {
						$(".titleh6[data-value='"+ item +"']").text(value.name )
						$(".titleP[data-value='"+ item +"']").html(value.project_name).css('height', '30px')
	  				}else if(defaultAssign == 'site'){
	  					$(".titleh6[data-value='"+ item +"']").text(value.project_name)
							$(".titleP[data-value='"+ item +"']").html(value.name.replaceAll(",","<br>")).css("height","100px")
	  				}	
    		})

				if (result.length == 0) {
					$("#container_pid").html("<span style='display:flex;flex-direction:row-reverse'>Empty Data!</span>")
					$("#pagination").attr('style','display:none!important')
				}else{
					$("#pagination").show()
				}

				var items = $(".divSiteBox .alert");
				var numItems = items.length;
				var perPage = 6;

				items.slice(perPage).attr('style','display:none!important');

				$('#pagination').pagination({
					items: numItems,
					itemsOnPage: perPage,
					prevText: "&laquo;",
					nextText: "&raquo;",
					onPageClick: function (pageNumber) {
						var showFrom = perPage * (pageNumber - 1);
						var showTo = showFrom + perPage;
						items.attr('style','display:none!important').slice(showFrom, showTo).show();
					}
				});

			}
		})		
	}

	function showPID(item,nik){
		let append = ""

		if (!$("#tablePID[data-value='"+ item +"']").is(":visible")) {
			append = append + "<table id='tablePID' name='"+ item +"' data-value='"+ item +"' class='table table-condensed'>"
				append = append + "<tr>"
					append = append + "<th>"
						append = append + "PID"
					append = append + "</th>"
					append = append + "<th>"
						append = append + "Project Name"
					append = append + "</th>"
				append = append + "</tr>"
				append = append + "<tfoot>"
					append  = append + "<tr>"
						append = append + "<td colspan='2'>"
							append = append + "<div class='checkbox'>"
								append = append + "	<label>"
									append = append + "		<input type='checkbox' data-value='"+ item +"'>"
									append = append + "		Check All"
								append = append + "	</label>"
							append = append + "</div>"
						append = append + "</td>"
					append  = append + "</tr>"
				append = append + "</tfoot>"
			append = append + "</table>"

			$(".divPID[data-value='"+ item +"']").fadeIn('slow').css('width','')
			$(".searchTablePID[data-value='"+ item +"']").show()
			$(".btnSavePID[data-value='"+ item +"']").show()
			$(".showPID[data-value='"+ item +"'] i").removeClass("fa-angle-right").addClass("fa-angle-down")
			$(".boxPID[data-value='"+ item +"']").append(append)
			$(".boxPID[data-value='"+ item +"']").closest(".divPID").css({'background-color':'white','padding':'8px'});

			if ($("#customerFilter").val().length > 0) {
				var arrCust = "customer[]=", url = "/ticketing/setting/getFilterPIDByCustomer?"

		    $.each($('#customerFilter').val(),function(key,value){
					if(arrCust == 'customer[]=') {
		        arrCust = arrCust + value
		      }else{
		        arrCust = arrCust + '&customer[]=' + valuee
		      }
		    })
			}else{
				var url = "/ticketing/setting/getAllPid?"
			}
		

			$("#tablePID[data-value='"+ item +"']").DataTable({
				"ajax":{
	        "type":"GET",
	        "url":"{{url('/')}}"+url + arrCust,
	        "data":{
			    	nik:nik,
		        assign:$("#assignFilter").val(),
			    }
	      },
	      "columns": [
	        { 
	        	render: function (data, type, row, meta){
	        		if (row.result_modif == "Selected") {
	        			return "<label>"
								+ "<input type='checkbox' checked value='"+ row.id_project +"'> "
								+ row.id_project
								+ "	</label>" 
	        		}else{
	        			return "<label>"
								+ "<input type='checkbox' value='"+ row.id_project +"'> "
								+ row.id_project
								+ "	</label>" 
	        		}
	        		
	        	},
	        	"title":"PID",
	        	"width":"30%"
	        },
	        { "data": "name_project","title":"Name Project"},
	        { "data": "brand_name","title":"Name Project"},
	        { "data": "customer_legal_name","title":"Name Project"},

	      ],
	      fixedHeader:{
	      	footer:true
	      },
	      "initComplete": function(settings,json){
	      	$(".dataTables_paginate.paging_simple_numbers").css("display","none")
			    var input = $('.dataTable[data-value="'+ item +'"] tbody input[type="checkbox"]')
	      	checkInputCheked()

	      	function checkInputCheked(){
	      		var isInputChecked = $(".btnSavePID[data-value='"+ item +"']").closest(".row").closest(".row").find(".col-sm-12").find(".dataTable[data-value='"+ item +"'] tbody input[type='checkbox']").is(":checked");
	      		if (isInputChecked) {
				      $(".btnSavePID[data-value='"+ item +"']").prop("disabled",false)
		      	}else{
				      $(".btnSavePID[data-value='"+ item +"']").prop("disabled",true)
		      	}	
	      	}

	      	var inputCheckAll = $('.dataTable[data-value="'+ item +'"] tfoot input[type="checkbox"]');

	      	$(inputCheckAll).on('change', function() {
			        if ($(this).is(':checked')) {
			        	if ($("#searchbarPID[data-value='"+ item +"']").val() == '') {
			        		$(".btnSavePID[data-value='"+ item +"']").prop("disabled",false)
		            	$(input).prop("checked",true)
				        }else{
				        	var table = $('.dataTable[data-value="'+ item +'"]').DataTable()

				        	var filteredCheckboxes = table.rows({ search: 'applied' }).nodes().to$().find('label input[type="checkbox"]');
								  filteredCheckboxes.prop('checked', true);

			        		$(".btnSavePID[data-value='"+ item +"']").prop("disabled",false)
				        }
		        		
			        } else {
			        	if ($("#searchbarPID[data-value='"+ item +"']").val() == '') {
		            	$(input).prop("checked",false)
			        		$(".btnSavePID[data-value='"+ item +"']").prop("disabled",true)

				        }else{
				        	var table = $('.dataTable[data-value="'+ item +'"]').DataTable()

				        	var filteredCheckboxes = table.rows({ search: 'applied' }).nodes().to$().find('label input[type="checkbox"]');
								  filteredCheckboxes.prop('checked', false);

			        		$(".btnSavePID[data-value='"+ item +"']").prop("disabled",true)
				        }
		        		
			        }
			    });

	      	$(input).on('change', function() {
	      		if ($(this).is(':checked')) {
	      			checkInputCheked()
		        } else {
		        	checkInputCheked()
		        	$(inputCheckAll).prop("checked",false)
		        }
	      	})

	      	if (accesable.includes('checkboxPID')) {
	      		$(input).prop("disabled",false)
	      		$(inputCheckAll).prop("disabled",false)
	      		$(".btnSavePID[data-value='"+ item +"']").prop("disabled",false)
	      	}else{
	      		$(input).prop("disabled",true)
	      		$(inputCheckAll).prop("disabled",true)
	      		$(".btnSavePID[data-value='"+ item +"']").prop("disabled",true)
	      	}

	      },
	      "footerCallback": function( tfoot, data, start, end, display ) {
	      	var api = this.api();
	      	// console.log(api)
			  },
			  "columnDefs": [
		      {
		        "targets": [2, 3], // Columns indices to hide (0-based index)
		        "visible": false // Set to true if you want them visible by default
		      }
		      // Add more "targets" objects to hide/show multiple columns if needed
		    ],
	      "pageLength" : 50,
	      "bLengthChange": false,
	      "bInfo": false,
	      "ordering":false,
	      "aaSorting": [],
	      "scrollCollapse": true,
    		"scrollY": '200px'
			})

			$(".btnSavePID[data-value='"+ item +"']").click(function(){
				// var input = $('.dataTable[data-value="'+ $(this).attr("data-value") +'"] tbody input[type="checkbox"]:checked')
				var table = $('.dataTable[data-value="'+ $(this).attr("data-value") +'"]')

				let arr_pid = []

				var checkboxes = table.DataTable().column(0).nodes().to$().find('label input[type="checkbox"]:checked')

				checkboxes.each(function() {
			    if ($(this).prop('checked')) {
						arr_pid.push($(this).val())
			    }
			  });

				// $.each(input,function(item,value){
				// 	arr_pid.push($(value).attr("value"))
				// })

				formData = new FormData
        formData.append("_token","{{ csrf_token() }}")
        formData.append("pid",JSON.stringify(arr_pid))
        formData.append("nik",JSON.stringify(nik))
        formData.append("assign",$("#assignFilter").val())

        // Initialize the HTML content variable
				let htmlContent = '<span style="font-size:14px"><label>'+ $(".showPID[data-value='0']").next().next().text() + '</label>' + ' assigned to selected PID : <div style="max-height:100px;overflow:auto"><ul style="text-align:start;">'; // Start an unordered list

				// Loop through the array to create HTML content for each element
				arr_pid.forEach(item => {
				    htmlContent += `<li>${item}</li>`; // Add each array element as a list item
				});

				htmlContent += '</ul><div></span>';

        swalFireCustom = {
          title: 'Are you sure?',
          html: htmlContent,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No',
        }

        swalSuccess = {
            icon: 'success',
            title: 'Assigned PID Successfully!',
            text: 'Click Ok to reload page',
        } 

        createPost(swalFireCustom,formData,swalSuccess,url="/ticketing/setting/storeAssign")
			})
		}else{
			$(".divPID[data-value='"+ item +"']").attr('style','display:none!important')
			$(".searchTablePID[data-value='"+ item +"']").attr('style','display:none!important')
			$(".btnSavePID[data-value='"+ item +"']").attr('style','display:none!important')
			$(".showPID[data-value='"+ item +"'] i").removeClass("fa-angle-down").addClass("fa-angle-right")
			$(".boxPID[data-value='"+ item +"']").empty("")
			$(".boxPID[data-value='"+ item +"']").closest(".divPID").css('background-color', '');
		}

		// var contentWidth = $(".boxPID[data-value='"+ item +"']").width();
  // 	// Set the div's width to match the content width
  // 	$(".divPID[data-value='"+ item +"']").width(contentWidth);
	}

  function initiateFilter(){
  	//filter site
  	$.ajax({
  		type:"GET",
  		url:"{{url('/ticketing/setting/getSiteShifting')}}",
			success:function(result){
				$(".siteFilter").empty("")
				let append = ""

				$.each(result,function(item,value){
					append = append	+ "<div class='checkbox'>"
					append = append + "<label>"
					append = append + " <input type='checkbox' name='siteFilter' id='siteFilter' value='"+ value.project_name +"'>" + value.project_name
					append = append + "</label>" 
					append = append	+ "</div>"

				})

				$(".siteFilter").append(append)
  		}
  	})

  	//filter user
  	$.ajax({
  		type:"GET",
  		url:"{{url('/ticketing/setting/getUser')}}",
			success:function(result){
				$("#userFilter").select2({
					multiple:true,
					placeholder:"Select User",
					data:result.data
				})
  		}
  	})

  	//filter user
  	$.ajax({
  		type:"GET",
  		url:"{{url('/ticketing/setting/getCustomer')}}",
			success:function(result){
				$("#customerFilter").select2({
					multiple:true,
					placeholder:"Select Customer",
					data:result.data
				})
  		}
  	})
  	
  }

  function createPost(swalFireCustom,data,swalSuccess,url){
  	Swal.fire(swalFireCustom).then((resultFire) => {
      if (resultFire.value) {
      	$.ajax({
		      type:"POST",
		      url:"{{url('/')}}"+url,
		      processData: false,
		      contentType: false,
		      data:data,
		      beforeSend:function(){
		        Swal.fire({
		            title: 'Please Wait..!',
		            text: "It's sending..",
		            allowOutsideClick: false,
		            allowEscapeKey: false,
		            allowEnterKey: false,
		            customClass: {
		                popup: 'border-radius-0',
		            },
		        })
		        Swal.showLoading()
		      },
		      success: function(results)
		      {
            Swal.fire(swalSuccess).then((result,data) => {
            		filterPID()
            })
		      }
		    })
      }
    })
  }

  function assignFilter(val){
  	if (val == "site") {
  		$("#userFilter").closest(".form-group").attr('style','display:none!important')
  		$('#userFilter').val(null).trigger('change');
  	}else{
  		$("#userFilter").closest(".form-group").show()
  	}
  }

  function searchCustomPID(item){
  	var inputCheckAll = $('.dataTable[data-value="'+ item +'"] tfoot input[type="checkbox"]');
  	inputCheckAll.prop("checked",false)
  	$('.dataTable[data-value="'+ item +'"]').DataTable().search($("#searchbarPID[data-value='"+ item +"']").val()).draw();
  }

  function searchCustomAll(idInput){
		showDivSiteBox($("#assignFilter").val(),"/ticketing/setting/getSearchAllData?assign="+$("#assignFilter").val() + "&searchAll=" + $("#"+idInput).val())
  }

  function filterPID(){
  	var arrSite = "location[]=", arrCust = "customer[]=", arrUser = "user[]=", assign = "assign="

  	if(assign == 'assign=') {
      assign = assign + $("#assignFilter").val()
    }else{
      assign = assign + '&assign=' + $("#assignFilter").val()
    }

  	if (value == null) {
  		$.each($('#customerFilter').val(),function(key,value){
				if(arrCust == 'customer[]=') {
	        arrCust = arrCust + value
	      }else{
	        arrCust = arrCust + '&customer[]=' + valuee
	      }
	    })

	  	$("input[name='siteFilter']").each(function(idx,values){
	      if ($(values).is(":checked") == true) {
	  			if(arrSite == 'location[]=') {
	          arrSite = arrSite + values.value
	        }else{
	          arrSite = arrSite + '&location[]=' + values.value
	        }
	      }
	    })

	    $.each($('#userFilter').val(),function(key,value){
	      if(arrUser == 'user[]=') {
	        arrUser = arrUser + value
	      }else{
	        arrUser = arrUser + '&user[]=' + value
	      }
	    })
  	}

  	showDivSiteBox($("#assignFilter").val(),"/ticketing/setting/getFilterDataAll?" + '&' + arrSite + '&' + arrCust + '&' + arrUser + '&' + assign)
  }

  function resetPID(){
  	$('#customerFilter').val(null).trigger('change');
  	$('#userFilter').val(null).trigger('change');
  	$("input[name='siteFilter']").each(function(idx,values){
  		$(values).prop("checked",false)
    })
    filterPID("reset")
  }
  
	function showDivSiteBox(defaultAssign,url){		
		$.ajax({
			type:"GET",
			url:"{{url('/')}}"+url,
			success:function(result){
				$(".divSiteBox").empty("")

				let append = "", nik = []
				let columnCount = 0

  			append = append + "<div style='column-count:2;column-gap:10px' id='container_pid' class='mt-5'></div>"
  			// append = append + "<div class='container_pid' id='container_pid'></div>"
				$(".divSiteBox").append(append)	

				result.forEach(function	(index,items){
					nik.push({
						"nik": index.nik
					})
				})	

    		$.each(result,function(item,value){
    			// if (item % 3 === 0) {
    			// $("#container_pid").append("<div class='widthBoxPID column_pid'></div>")
    				// columnCount++
						// append = append + "<div style='width:50%'></div>"
    			// }

  				let append_column = ""
    			append_column = append_column + "<div class='alert bg-gray disabled' style='margin-bottom:10px!important;break-inside:avoid;'>"
						append_column = append_column + "<div style='position:relative'>"
							append_column = append_column + "<span class='showPID' data-value='"+ item +"' onclick='showPID("+ item +"," + '['+ nik[item].nik + "]" +")' style='position:absolute;right:0;top:0'><i class='fa fa-2x fa-angle-right'></i></span>"
							append_column = append_column + "	<h6><b class='titleh6' data-value='"+ item +"'></b></h6>"
							append_column = append_column + "	<p class='titleP' data-value='"+ item +"'></p>"
							append_column = append_column + "<div style='position:relative'>"
								append_column = append_column + "<span class='badge text-bg-primary' style='position:absolute;right:0;bottom:0'>"+ value.count +"</span>"
							append_column = append_column + "</div>"
								append_column = append_column + "<div class='divPID' data-value='"+ item +"' style='overflow:x;padding:8px;border-radius:5px;display:none;margin-top:25px'>"
									append_column = append_column + "<div class='row'>"
										append_column = append_column + "<div class='col-md-12'>"
											append_column = append_column + "<div>"
												append_column = append_column + "<div style='display: flex;'><div class='input-group searchTablePID' style='flex-direction: row; margin: 10px; width: 50% !important;' data-value='"+ item +"'><input class='form-control' placeholder='Search Cutsomer/PID/Project Name' id='searchbarPID' onkeyup='searchCustomPID("+ item + ")' data-value='"+ item +"'><span class='input-group-btn'><button onclick='searchCustomPID("+ item + ")' type='button' class='btn btn-secondary btn-flat' fdprocessedid='f23lya'>	<i class='fa fa-fw fa-search'></i></button></span></div>"
													append_column = append_column + "<span style='margin-top: 19px;' data-toggle='tooltip' data-placement='top' title='Please search for more PID list!'><i class='fa fa-question-circle' style='font-size: 1.2em;color: #579bcf;'></i></span>"
												append_column = append_column + "</div>"
											append_column = append_column + "</div>"
											append_column = append_column + "<div class='boxPID' data-value='"+ item +"'>"
											append_column = append_column + "</div>"
											append_column = append_column + "<button class='btn btn-sm text-bg-primary btnSavePID pull-right' data-value='"+ item +"' style='margin:10px;display:none'>"
												append_column = append_column + "Save"
											append_column = append_column + "</button>"
										append_column = append_column + "</div>"					
									append_column = append_column + "</div>"
								append_column = append_column + "</div>"
							append_column = append_column + "</div>"
						append_column = append_column + "</div>"
					append_column = append_column + "</div>"

					// $(".column_pid").eq(columnCount - 1).append(append_column)
					$("#container_pid").append(append_column)

					if (defaultAssign == 'user') {
						$(".titleh6[data-value='"+ item +"']").text(value.name )
						$(".titleP[data-value='"+ item +"']").text(value.project_name).css("height","")
  				}else if(defaultAssign == 'site'){
  					$(".titleh6[data-value='"+ item +"']").text(value.project_name)
						$(".titleP[data-value='"+ item +"']").html(value.name.replaceAll(",","<br>")).css("height","100px")
  				}	
    		})

				if (result.length == 0) {
					$("#container_pid").html("<span style='display:flex;flex-direction:row-reverse'>Empty Data!</span>")
					$("#pagination").attr('style','display:none!important')
				}else{
					$("#pagination").show()
				}

				var items = $(".divSiteBox .alert");
				var numItems = items.length;
				var perPage = 6;

				items.slice(perPage).attr('style','display:none!important');

				$('#pagination').pagination({
					items: numItems,
					itemsOnPage: perPage,
					prevText: "&laquo;",
					nextText: "&raquo;",
					onPageClick: function (pageNumber) {
						var showFrom = perPage * (pageNumber - 1);
						var showTo = showFrom + perPage;
						items.attr('style','display:none!important').slice(showFrom, showTo).show();
					}
				});

			}
		})		
	}

	function showPID(item,nik){
		let append = ""

		if (!$("#tablePID[data-value='"+ item +"']").is(":visible")) {
			append = append + "<table id='tablePID' name='"+ item +"' data-value='"+ item +"' class='table table-condensed'>"
				append = append + "<tr>"
					append = append + "<th>"
						append = append + "PID"
					append = append + "</th>"
					append = append + "<th>"
						append = append + "Project Name"
					append = append + "</th>"
				append = append + "</tr>"
				append = append + "<tfoot>"
					append  = append + "<tr>"
						append = append + "<td colspan='2'>"
							append = append + "<div class='checkbox'>"
								append = append + "	<label>"
									append = append + "		<input type='checkbox' data-value='"+ item +"'>"
									append = append + "		Check All"
								append = append + "	</label>"
							append = append + "</div>"
						append = append + "</td>"
					append  = append + "</tr>"
				append = append + "</tfoot>"
			append = append + "</table>"

			$(".divPID[data-value='"+ item +"']").fadeIn('slow').css('width','')
			$(".searchTablePID[data-value='"+ item +"']").show()
			$(".btnSavePID[data-value='"+ item +"']").show()
			$(".showPID[data-value='"+ item +"'] i").removeClass("fa-angle-right").addClass("fa-angle-down")
			$(".boxPID[data-value='"+ item +"']").append(append)
			$(".boxPID[data-value='"+ item +"']").closest(".divPID").css({'background-color':'white','padding':'8px'});

			if ($("#customerFilter").val().length > 0) {
				var arrCust = "customer[]=", url = "/ticketing/setting/getFilterPIDByCustomer?"

		    $.each($('#customerFilter').val(),function(key,value){
					if(arrCust == 'customer[]=') {
		        arrCust = arrCust + value
		      }else{
		        arrCust = arrCust + '&customer[]=' + valuee
		      }
		    })
			}else{
				var url = "/ticketing/setting/getAllPid?"
			}
		

			$("#tablePID[data-value='"+ item +"']").DataTable({
				"ajax":{
	        "type":"GET",
	        "url":"{{url('/')}}"+url + arrCust,
	        "data":{
			    	nik:nik,
		        assign:$("#assignFilter").val(),
			    }
	      },
	      "columns": [
	        { 
	        	render: function (data, type, row, meta){
	        		if (row.result_modif == "Selected") {
	        			return "<label>"
								+ "<input type='checkbox' checked value='"+ row.id_project +"'> "
								+ row.id_project
								+ "	</label>" 
	        		}else{
	        			return "<label>"
								+ "<input type='checkbox' value='"+ row.id_project +"'> "
								+ row.id_project
								+ "	</label>" 
	        		}
	        		
	        	},
	        	"title":"PID",
	        	"width":"30%"
	        },
	        { "data": "name_project","title":"Name Project"},
	        { "data": "brand_name","title":"Name Project"},
	        { "data": "customer_legal_name","title":"Name Project"},

	      ],
	      fixedHeader:{
	      	footer:true
	      },
	      "initComplete": function(settings,json){
	      	$(".dataTables_paginate.paging_simple_numbers").css("display","none")
			    var input = $('.dataTable[data-value="'+ item +'"] tbody input[type="checkbox"]')
	      	checkInputCheked()

	      	function checkInputCheked(){
	      		var isInputChecked = $(".btnSavePID[data-value='"+ item +"']").closest(".row").closest(".row").find(".col-sm-12").find(".dataTable[data-value='"+ item +"'] tbody input[type='checkbox']").is(":checked");
	      		if (isInputChecked) {
				      $(".btnSavePID[data-value='"+ item +"']").prop("disabled",false)
		      	}else{
				      $(".btnSavePID[data-value='"+ item +"']").prop("disabled",true)
		      	}	
	      	}

	      	var inputCheckAll = $('.dataTable[data-value="'+ item +'"] tfoot input[type="checkbox"]');

	      	$(inputCheckAll).on('change', function() {
			        if ($(this).is(':checked')) {
			        	if ($("#searchbarPID[data-value='"+ item +"']").val() == '') {
			        		$(".btnSavePID[data-value='"+ item +"']").prop("disabled",false)
		            	$(input).prop("checked",true)
				        }else{
				        	var table = $('.dataTable[data-value="'+ item +'"]').DataTable()

				        	var filteredCheckboxes = table.rows({ search: 'applied' }).nodes().to$().find('label input[type="checkbox"]');
								  filteredCheckboxes.prop('checked', true);

			        		$(".btnSavePID[data-value='"+ item +"']").prop("disabled",false)
				        }
		        		
			        } else {
			        	if ($("#searchbarPID[data-value='"+ item +"']").val() == '') {
		            	$(input).prop("checked",false)
			        		$(".btnSavePID[data-value='"+ item +"']").prop("disabled",true)

				        }else{
				        	var table = $('.dataTable[data-value="'+ item +'"]').DataTable()

				        	var filteredCheckboxes = table.rows({ search: 'applied' }).nodes().to$().find('label input[type="checkbox"]');
								  filteredCheckboxes.prop('checked', false);

			        		$(".btnSavePID[data-value='"+ item +"']").prop("disabled",true)
				        }
		        		
			        }
			    });

	      	$(input).on('change', function() {
	      		if ($(this).is(':checked')) {
	      			checkInputCheked()
		        } else {
		        	checkInputCheked()
		        	$(inputCheckAll).prop("checked",false)
		        }
	      	})

	      	if (accesable.includes('checkboxPID')) {
	      		$(input).prop("disabled",false)
	      		$(inputCheckAll).prop("disabled",false)
	      		$(".btnSavePID[data-value='"+ item +"']").prop("disabled",false)
	      	}else{
	      		$(input).prop("disabled",true)
	      		$(inputCheckAll).prop("disabled",true)
	      		$(".btnSavePID[data-value='"+ item +"']").prop("disabled",true)
	      	}

	      },
	      "footerCallback": function( tfoot, data, start, end, display ) {
	      	var api = this.api();
	      	// console.log(api)
			  },
			  "columnDefs": [
		      {
		        "targets": [2, 3], // Columns indices to hide (0-based index)
		        "visible": false // Set to true if you want them visible by default
		      }
		      // Add more "targets" objects to hide/show multiple columns if needed
		    ],
	      // "pageLength" : false,
	      "paging": false,
	      "bLengthChange": false,
	      "bInfo": true,
	      "ordering":false,
	      "aaSorting": [],
	      "scrollCollapse": true,
    		"scrollY": '200px'
			})

			$(".btnSavePID[data-value='"+ item +"']").click(function(){
				// var input = $('.dataTable[data-value="'+ $(this).attr("data-value") +'"] tbody input[type="checkbox"]:checked')
				var table = $('.dataTable[data-value="'+ $(this).attr("data-value") +'"]')

				let arr_pid = []

				var checkboxes = table.DataTable().column(0).nodes().to$().find('label input[type="checkbox"]:checked')

				checkboxes.each(function() {
			    if ($(this).prop('checked')) {
						arr_pid.push($(this).val())
			    }
			  });

				// $.each(input,function(item,value){
				// 	arr_pid.push($(value).attr("value"))
				// })

				formData = new FormData
        formData.append("_token","{{ csrf_token() }}")
        formData.append("pid",JSON.stringify(arr_pid))
        formData.append("nik",JSON.stringify(nik))
        formData.append("assign",$("#assignFilter").val())

        // Initialize the HTML content variable
				let htmlContent = '<span style="font-size:14px"><label>'+ $(".showPID[data-value='0']").next().next().text() + '</label>' + ' assigned to selected PID : <div style="max-height:100px;overflow:auto"><ul style="text-align:start;">'; // Start an unordered list

				// Loop through the array to create HTML content for each element
				arr_pid.forEach(item => {
				    htmlContent += `<li>${item}</li>`; // Add each array element as a list item
				});

				htmlContent += '</ul><div></span>';

        swalFireCustom = {
          title: 'Are you sure?',
          html: htmlContent,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No',
        }

        swalSuccess = {
            icon: 'success',
            title: 'Assigned PID Successfully!',
            text: 'Click Ok to reload page',
        } 

        createPost(swalFireCustom,formData,swalSuccess,url="/ticketing/setting/storeAssign")
			})
		}else{
			$(".divPID[data-value='"+ item +"']").attr('style','display:none!important')
			$(".searchTablePID[data-value='"+ item +"']").attr('style','display:none!important')
			$(".btnSavePID[data-value='"+ item +"']").attr('style','display:none!important')
			$(".showPID[data-value='"+ item +"'] i").removeClass("fa-angle-down").addClass("fa-angle-right")
			$(".boxPID[data-value='"+ item +"']").empty("")
			$(".boxPID[data-value='"+ item +"']").closest(".divPID").css('background-color', '');
		}

		// var contentWidth = $(".boxPID[data-value='"+ item +"']").width();
  // 	// Set the div's width to match the content width
  // 	$(".divPID[data-value='"+ item +"']").width(contentWidth);
	}

  function initiateFilter(){
  	//filter site
  	$.ajax({
  		type:"GET",
  		url:"{{url('/ticketing/setting/getSiteShifting')}}",
			success:function(result){
				$(".siteFilter").empty("")
				let append = ""

				$.each(result,function(item,value){
					append = append	+ "<div class='checkbox'>"
					append = append + "<label>"
					append = append + " <input class='form-check-input' type='checkbox' name='siteFilter' id='siteFilter' value='"+ value.project_name +"'>" + value.project_name
					append = append + "</label>" 
					append = append	+ "</div>"

				})

				$(".siteFilter").append(append)
  		}
  	})

  	//filter user
  	$.ajax({
  		type:"GET",
  		url:"{{url('/ticketing/setting/getUser')}}",
			success:function(result){
				$("#userFilter").select2({
					multiple:true,
					placeholder:"Select User",
					data:result.data
				})
  		}
  	})

  	//filter user
  	$.ajax({
  		type:"GET",
  		url:"{{url('/ticketing/setting/getCustomer')}}",
			success:function(result){
				$("#customerFilter").select2({
					multiple:true,
					placeholder:"Select Customer",
					data:result.data,
					allowClear:true,
				})
  		}
  	})
  	
  }

  function createPost(swalFireCustom,data,swalSuccess,url){
  	Swal.fire(swalFireCustom).then((resultFire) => {
      if (resultFire.value) {
      	$.ajax({
		      type:"POST",
		      url:"{{url('/')}}"+url,
		      processData: false,
		      contentType: false,
		      data:data,
		      beforeSend:function(){
		        Swal.fire({
		            title: 'Please Wait..!',
		            text: "It's sending..",
		            allowOutsideClick: false,
		            allowEscapeKey: false,
		            allowEnterKey: false,
		            customClass: {
		                popup: 'border-radius-0',
		            },
		        })
		        Swal.showLoading()
		      },
		      success: function(results)
		      {
            Swal.fire(swalSuccess).then((result,data) => {
            		filterPID()
            })
		      }
		    })
      }
    })
  }

  function assignFilter(val){
  	if (val == "site") {
  		$("#userFilter").closest(".form-group").attr('style','display:none!important')
  		$('#userFilter').val(null).trigger('change');
  	}else{
  		$("#userFilter").closest(".form-group").show()
  	}
  }

  function searchCustomPID(item){
  	var inputCheckAll = $('.dataTable[data-value="'+ item +'"] tfoot input[type="checkbox"]');
  	inputCheckAll.prop("checked",false)
  	$('.dataTable[data-value="'+ item +'"]').DataTable().search($("#searchbarPID[data-value='"+ item +"']").val()).draw();
  }

  function searchCustomAll(idInput){
		showDivSiteBox($("#assignFilter").val(),"/ticketing/setting/getSearchAllData?assign="+$("#assignFilter").val() + "&searchAll=" + $("#"+idInput).val())
  }

  function filterPID(){
  	var arrSite = "location[]=", arrCust = "customer[]=", arrUser = "user[]=", assign = "assign="

    $.each($('#customerFilter').val(),function(key,value){
			if(arrCust == 'customer[]=') {
        arrCust = arrCust + value
      }else{
        arrCust = arrCust + '&customer[]=' + valuee
      }
    })

  	$("input[name='siteFilter']").each(function(idx,values){
      if ($(values).is(":checked") == true) {
  			if(arrSite == 'location[]=') {
          arrSite = arrSite + values.value
        }else{
          arrSite = arrSite + '&location[]=' + values.value
        }
      }
    })

    $.each($('#userFilter').val(),function(key,value){
      if(arrUser == 'user[]=') {
        arrUser = arrUser + value
      }else{
        arrUser = arrUser + '&user[]=' + value
      }
    })

    if(assign == 'assign=') {
      assign = assign + $("#assignFilter").val()
    }else{
      assign = assign + '&assign=' + $("#assignFilter").val()
    }

  	showDivSiteBox($("#assignFilter").val(),"/ticketing/setting/getFilterDataAll?" + '&' + arrSite + '&' + arrCust + '&' + arrUser + '&' + assign)
  }

  function resetPID(){
  	$('#customerFilter').val(null).trigger('change');
  	$('#userFilter').val(null).trigger('change');
  	$('#assignFilter').val("user").trigger('change');
  	$("input[name='siteFilter']").each(function(idx,values){
  		$(values).prop("checked",false)
    })
  	showDivSiteBox($("#assignFilter").val(),"/ticketing/setting/getUserShifting")
  }

  function addRowAssignEngineerAtm(){
  	
  	var cloneRow = $(".listEngineerAssign:last").clone()
  	cloneRow.find(".deleteRowAssign").removeAttr("disabled").end()

  	$(".listEngineerAssign").last().after(cloneRow)

  	cloneRow.children("select")
            .select2("destroy")
            .val("")
            .end()

  	$(".deleteRowAssign").click(function(){
  		$(this).closest(".listEngineerAssign").remove()
  	})

  	settingListEngineerAssign("add",null,"modal-assign-engineer-atm")
  	settingListAtmId()
  }

  function assignEngineerAtm(){
  	$("#modal-assign-engineer-atm").modal("show")
  	settingListAtmId()
  	settingListEngineerAssign("add",null,"modal-assign-engineer-atm")
  }

  function submitAssignEngineerAtm(){
  	var inputs = document.querySelectorAll('.listEngineerAssign .form-control');
		var arrListEnginner = [],engineer = [], atm_id = [];
		// Iterate over each input element

		var isEmptyField = true, InputLengthEmpty = 0,inputLength = inputs.length
		
		inputs.forEach(function(input) {
				if ($(input).val() == "") {
					isEmptyField = true
					InputLengthEmpty-=1
				}else{
					InputLengthEmpty+=1
					if (InputLengthEmpty < inputLength) {
						isEmptyField = true
					}else{
						isEmptyField = false
					}
				}
		    // Push the value of each input to the arrListEnginner array
		    if(input.name == 'assignEngineerAtm'){
		        engineer.push(input.value);
		    }

		    if(input.name == 'selectAssignAtmId'){
		        atm_id.push($(input).val());
		    }
		    
		});

		for (var i = 0; i < engineer.length; i++) {
		    // Construct object with elements from both arrays
		    var combinedObject = {
		        engineer: engineer[i],
		        atm_id: atm_id[i]
		    };
		    // Push the combined object into the resulting array
		    arrListEnginner.push(combinedObject);
		}

		if (isEmptyField == false) {
			formData = new FormData
	    formData.append("_token","{{ csrf_token() }}")        
	    formData.append("arrListEngineerAssign",JSON.stringify(arrListEnginner)) 

	    swalFireCustom = {
	      title: 'Are you sure?',
	      text: "Submit Assign Engineer ATM",
	      icon: 'warning',
	      showCancelButton: true,
	      confirmButtonColor: '#3085d6',
	      cancelButtonColor: '#d33',
	      confirmButtonText: 'Yes',
	      cancelButtonText: 'No',
	    }

	    swalSuccess = {
	        icon: 'success',
	        title: 'Assign Engineer Successfully!',
	        text: 'Click Ok to reload page',
	    }

	    Swal.fire(swalFireCustom).then((result) => {
	      if (result.value) {
	        $.ajax({
	          type:"POST",
	          url:"{{url('/ticketing/setting/assignEngineer')}}",
	          processData: false,
	          contentType: false,
	          data:formData,
	          beforeSend:function(){
	            Swal.fire({
	                title: 'Please Wait..!',
	                text: "It's sending..",
	                allowOutsideClick: false,
	                allowEscapeKey: false,
	                allowEnterKey: false,
	                customClass: {
	                    popup: 'border-radius-0',
	                },
	            })
	            Swal.showLoading()
	          },
	          success: function(result)
	          {
	            Swal.fire(swalSuccess).then((result) => {
	              if (result.value) {
	                location.reload()
	              }
	            })
	          }
	        })
	      }
	    })
		}else{
			alert("Fill Empty Input Field!")
		}
  	
  }

  function settingListEngineerAssign(status,name,id_modal){
  	console.log(name)
  	$.ajax({
  		type:"GET",
  		url:"{{url('/ticketing/setting/getEngineer')}}",
  		success:function(result){
  			var selectEngineer = $(".assignEngineerAtm")

  			selectEngineer.select2({
		      placeholder: 'Select Engineer Name',
		      dropdownParent: $("#"+id_modal),
		  		data:result
		  	})

  			if (status == "edit") {
		  		if (name != null) {
		  			selectEngineer.val(name).trigger('change');
		  		}else{
		  			selectEngineer
		  		}
		  	}else{
		  		selectEngineer
		  	}

		  	$(".assignEngineerAtm").next().next().remove()
  		}
  	})
  	
  	// selectEngineer.select2({
   //    placeholder: 'Select Engineer Name',
   //    dropdownParent: $("#"+id_modal),
  	// 	ajax: {
   //        url: '{{url("/ticketing/setting/getEngineer")}}',
   //        dataType: 'json',
   //        // delay: 250,
   //        processResults: function(data, params) {
   //            params.page = params.page || 1;
			// 		    return {
			// 		        results: data,
			// 		        pagination: {
			// 		            more: (params.page * 10) < data.count_filtered
			// 		        }
			// 		    };
   //        },
   //    }
  	// })
  	
  }

  function settingListAtmId(){
  	$(".selectAssignAtmId").select2({
      placeholder: 'Select ATM Id',
  		ajax: {
          url: '{{url("/ticketing/setting/getIdAtm")}}',
          dataType: 'json',
          delay: 250,
          processResults: function(data, params) {
              params.page = params.page || 1;
					    return {
					        results: data,
					        pagination: {
					            more: (params.page * 10) < data.count_filtered
					        }
					    };
          },
      },
    	// data:[{
    	// 	id:"VMABC",
    	// 	text:"VMABC"
    	// },
    	// {
    	// 	id:"VMBCD",
    	// 	text:"VMBCD"
    	// },
    	// {
    	// 	id:"VMBHG",
    	// 	text:"VMBHG"
    	// }],
  	}).on("change", function () {
  		 var selectedValues = [];
		    $('.selectAssignAtmId').not(this).each(function() {
		      selectedValues = selectedValues.concat($(this).val() || []);
		    });

		    // Check if any selected value is selected in another Select
		    var currentSelect = $(this);
		    var alertShown = false; 
		    $(this).find('option:selected').each(function() {
		      var value = $(this).val();
		      var text = $(this).text();

		      if (selectedValues.includes(value)) {
		        // Unselect the value in the current Select
		        currentSelect.find('option[value="' + value + '"]').prop('selected', false);
		        currentSelect.trigger('change');
		        alert('ATM Id ' + text + ' cannot duplicate Assign!');
          	alertShown = true;
		      }
		    });
  	})

  	$(".selectAssignAtmId").next().next().remove()
  }

  function saveEmailbyPID(type){
  	swalFireCustom = {
      title: 'Are you sure?',
      text: "Save Email Client Setting",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No',
    }

    var url = '', swalSuccess = '', id = '', modalClose = '', data = '', element = ''
    if (type == 'addEmail') {
    	url = '{{url("/ticketing/mail/storeAddMailSetting")}}'
    	modalClose = $('#modal-add-email')

    	swalSuccess = {
        title: 'Success!',
				text: "Email Client Add Successfully!",
				icon: 'success',
				confirmButtonText: 'Reload',
      }

      data = {
				"_token": "{{ csrf_token() }}",
				pid:$("#selectPidforEmail").val(),
				client_acronym:$("#inputClientforEmail").val(),
				dear:$("#dearAdd").val(),
				to:$("#toAdd").val(),
				cc:$("#ccAdd").val()
			}

			element = 'selectPidforEmail'
    }else{
    	url = '{{url("/ticketing/setting/updateEmailSetting")}}'
    	id = $('#idEmailEdit').val()
    	modalClose = $('#modal-setting-email-client')

    	data = {
				"_token": "{{ csrf_token() }}",
				id:id,
				pid:$("#selectPidforEmailEdit").val(),
				client_acronym:$("#inputClientforEmailEdit").val(),
				dear:$("#dearEdit").val(),
				to:$("#toEdit").val(),
				cc:$("#ccEdit").val()
			}

    	swalSuccess = {
        title: 'Success!',
				text: "Email Client Edit Successfully!",
				icon: 'success',
				confirmButtonText: 'Reload',
      }

      element = 'selectPidforEmailEdit'
    }

    Swal.fire(swalFireCustom).then((result) => {
      if (result.value) {
		  	$.ajax({
					type:"POST",
					url:url,
					data:data,
					success : function(){
						Swal.fire(swalSuccess).then((result) => {
							modalClose.modal('hide')
							$('#tableEmailSetting').DataTable().ajax.url("{{url('/ticketing/mail/getSettingEmailbyPID')}}").load();
						})
					},error : function(req, status, error){
						$("#"+element).next("span").next("span.invalid-feedback").show()
	          $("#"+element).next("span").next("span.invalid-feedback").text(req.responseJSON.data)
					}
				});
		  }
		})
  }

  function saveSlmEmail(type){
  	swalFireCustom = {
      title: 'Are you sure?',
      text: "Save Email SLM Setting",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No',
    }

    var url = '',id = '', swalSuccess = '', modalClose = '', data = '', element = ''
    if (type == 'addEmail') {
    	url = "{{url('/ticketing/mail/storeAddMailSLM')}}"
    	modalClose = $('#modal-add-slm-email')

    	swalSuccess = {
        title: 'Success!',
				text: "Email SLM Add Successfully!",
				icon: 'success',
				confirmButtonText: 'Reload',
      }

      data = {
				"_token": "{{ csrf_token() }}",
				secondLevelSupport:$("#selectLevelSupport").val(),
				dear:$("#dearAddSlm").val(),
				to:$("#toAddSlm").val(),
				cc:$("#ccAddSlm").val(),
				// close_dear:$("#closeDearAddSlm").val(),
				// close_to:$("#closeToAddSlm").val(),
				// close_cc:$("#closeCcAddSlm").val(),
			}

			element = 'selectLevelSupport'
    }else{
    	url = "{{url('/ticketing/setting/updateEmailSLM')}}"
    	id 	= $("#idSlmEdit").val()
    	modalClose = $('#modal-setting-email-slm')
    	data = {
				"_token": "{{ csrf_token() }}",
				id:id,
				secondLevelSupport:$("#selectLevelSupportEdit").val(),
				dear:$("#dearSlmEdit").val(),
				to:$("#toSlmEdit").val(),
				cc:$("#ccSlmEdit").val(),
			}

    	swalSuccess = {
        title: 'Success!',
				text: "Email SLM Edit Successfully!",
				icon: 'success',
				confirmButtonText: 'Reload',
      }

      element = 'selectLevelSupportEdit'
    }

    Swal.fire(swalFireCustom).then((result) => {
      if (result.value) {
		  	$.ajax({
					type:"POST",
					url:url,
					data:data,
					success : function(){
						Swal.fire(swalSuccess).then((result) => {
							modalClose.modal('hide')
							$('#tableSlmEmailSetting').DataTable().ajax.url("{{url('/ticketing/mail/getSettingEmailSLM')}}").load();
						})
					},error : function(req, status, error){
						$("#"+element).next("span").next("span.invalid-feedback").show()
            $("#"+element).next("span").next("span.invalid-feedback").text(req.responseJSON.data)
					}
				});
		  }
		})
  }

  function editClientEmail(id){
		$.ajax({
			type:"GET",
			url:"{{url('/ticketing/setting/getSettingEmailClientById')}}",
			data: {
				id:id,
			},
			success : function(result){
				$('#modal-setting-email-client').modal('show');
				$(".modal-setting-title").html("Change Setting for <b>" + result[0].client + "</b>");

				$("#idEmailEdit").val("");
				$("#inputClientforEmailEdit").val("");
				$('.emailMultiSelector ').remove()
				$("#toEdit").val("");
				$("#ccEdit").val("");
				$("#dearEdit").val("");

				$("#selectPidforEmailEdit").select2({
					ajax: {
	        url: '{{url("asset/getPid")}}',
	        processResults: function (data) {
	          // Transforms the top-level key of the response object from 'items' to 'results'
	          return {
	            results: data
	          };
	        },
	      },
	      placeholder: 'Select Project ID',
	      dropdownParent: $("#modal-setting-email-client")
				}).on("change", function () {
					var pid = $(this).val()
					$.ajax({
						type:"GET",
						url:"{{url('/ticketing/mail/getClientByPid')}}",
						data:{
							pid:pid
						},
						success:function(result){
							$("#inputClientforEmailEdit").val(result[0].id)
						}
					})
				})

				if (result[0].pid != null) {
          var pidSelect = $("#selectPidforEmailEdit");
          var option = new Option(result[0].pid, result[0].pid, true, true);
          pidSelect.append(option).trigger('change');
        }
				$("#idEmailEdit").val(id);
				$("#inputClientforEmailEdit").val(result[0].client);
				
				$("#dearEdit").val(result[0].dear);
				$("#toEdit").val(result[0].to);
				$("#toEdit").emailinput({ onlyValidValue: true, delim: ';' })
				$("#ccEdit").val(result[0].cc);
				$("#ccEdit").emailinput({ onlyValidValue: true, delim: ';' })
				$(".emailMultiSelector").css('height','37.1px')
				$(".ei_box").css('font-size','13px')
			},
		});
	}

	function editSlmEmail(id){
		$.ajax({
			type:"GET",
			url:"{{url('/ticketing/setting/getSettingEmailSLMById')}}",
			data: {
				id:id,
			},
			beforeSend:function(argument) {
				Swal.fire({
				    title: 'Please wait...',
				    text: 'Load data...',
				    allowOutsideClick: false,
				    didOpen: () => {
				        Swal.showLoading();
				    }
				});
			},
			success : function(result){
				Swal.close();
				$('#modal-setting-email-slm').modal('toggle');
				$(".modal-setting-title").html("Change Setting for <b>" + result[0].second_level_support + "</b>");
				$("#selectLevelSupportEdit").val("");
				$("#dearSlmEdit").val("");
				$("#toSlmEdit").val("");
				$("#ccSlmEdit").val("");
				$('.emailMultiSelector ').remove()
				$("#idSlmEdit").val(id);
				
				$("#selectLevelSupportEdit").select2({
					ajax: {
		        url: '{{url("asset/getLevelSupport")}}',
		        processResults: function (data) {
		          // Transforms the top-level key of the response object from 'items' to 'results'
		          return {
		            results: data
		          };
		        },
		      },
		      placeholder: 'Select Second Level Support',
		      dropdownParent: $("#modal-setting-email-slm")
				})

				if (result[0].second_level_support != null) {
					console.log(result[0].second_level_support)
          var secondLevelSelect = $("#selectLevelSupportEdit");
          var option = new Option(result[0].second_level_support, result[0].second_level_support, true, true);
          secondLevelSelect.append(option).trigger('change');
        }

				$("#dearSlmEdit").val(result[0].dear);
				$("#toSlmEdit").val(result[0].to);
				$("#toSlmEdit").emailinput({ onlyValidValue: true, delim: ';' })
				$("#ccSlmEdit").val(result[0].cc);
				$("#ccSlmEdit").emailinput({ onlyValidValue: true, delim: ';' })
				$(".emailMultiSelector").css('height','37.1px')
				$(".ei_box").css('font-size','13px')
			},
		});
	}

	function SlaSetting(){
		$("#searchBarEmail").attr("placeholder","Search SLA")
		$(".settingComponent").attr('style','display:none!important')
		$("#SlaSetting").show()
		$("#addEmail2").removeClass('d-none')
		$("#addEmail").addClass('d-none')
		$("#addEmailSlm").addClass('d-none')
		$("#addEmail").attr('style','display:none!important')


		if ($.fn.dataTable.isDataTable("#tableSlaSetting")) {
		} else {
			$("#tableSlaSetting").DataTable({
				ajax:{
					type:"GET",
					url:"{{url('/ticketing/setting/getSLAProject')}}",
				},
				columns:[
					{ 	
						data:'pid',
					},
					{
						data:'sla_response',
					},
					{ 
						data:'sla_resolution_critical',
					},
					{ 
						data:'sla_resolution_major',
					},
					{ 
						data:'sla_resolution_moderate',
					},
					{ 
						data:'sla_resolution_minor',
					},
				],
				autoWidth:false,
				lengthChange: false,
				searching:true,
				"processing": true,
				"ColumnDefs":[
		       { targets: 'no-sort', orderable: false }
		    ],
		    "aaSorting": [],
			})
		}
	}

	function changePerformance(whichPageFor,id){
		console.log(whichPageFor)
		var start = '',end = '', pid = ''
		if ($("#filterDashboardByDate").data('daterangepicker').startDate != '') {
			start = moment($("#filterDashboardByDate").data('daterangepicker').startDate).format("YYYY-MM-DD")
			end = moment($("#filterDashboardByDate").data('daterangepicker').endDate).format("YYYY-MM-DD") 
		}else if ($("#startDateFilter").val() != '' && $("#endDateFilter").val() != '') {
			start = $("#startDateFilter").val()
			end = $("#endDateFilter").val()
		}else{
			start = moment().startOf('year').format('YYYY-MM-DD')
			end = moment().endOf('year').format('YYYY-MM-DD')
			pid = pid
		}

		if($("#filterDashboardByPid").val() != null){
			pid = $("#filterDashboardByPid").val()
		}

		if (whichPageFor == 'performance') {
			if($("#tablePerformance").length){
				$(".buttonFilter").removeClass('btn-primary').addClass('btn-secondary')
				if (id != 'initPerformance' && id != 'filter') {
					$("#tablePerformance").DataTable().ajax.url("{{url('ticketing/getPerformanceAll')}}").load();
				}

				var urlAjax = '{{url("/ticketing/report/performance")}}?client=' + $("#clientList").val() + '&pid=' + pid + '&start=' + start + '&end=' + end
			}
		}else if (whichPageFor == 'activity') {
			$("#tablePerformance").DataTable().ajax.url("{{url('ticketing/getPerformanceByActivity?activity=')}}" + id + '&pid=' + pid + '&start=' + start + '&end=' + end).load()
			
			var urlAjax = '{{url("/ticketing/report/performance")}}?client=' + $("#clientList").val() + '&pid=' + pid + '&start=' + start + '&end=' + end + '&activity=' + id
		}else if (whichPageFor == 'severity') {
			$("#tablePerformance").DataTable().ajax.url("{{url('ticketing/getPerformanceBySeverity?severity=')}}" + id + '&pid=' + pid + '&start=' + start + '&end=' + end).load()
			
			var urlAjax = '{{url("/ticketing/report/performance")}}?client=' + $("#clientList").val() + '&pid=' + pid + '&start=' + start + '&end=' + end + '&severity=' + id
		}else if (whichPageFor == 'attention') {
			$.ajax({
				type:"GET",
				url:"{{url('getPerformanceByNeedAttention?client=')}}" + $("#filterDashboardByClient").val(),
				success:function(result) {
					if (result.id_client != '') {
						$("#clientList").val(result.id_client).trigger("change")
					}
				}
			})

			if ($("#filterDashboardByDate").data('daterangepicker').startDate) {
				$('#dateFilter').data('daterangepicker').setStartDate(moment($("#filterDashboardByDate").data('daterangepicker').startDate).format('YYYY-MM-DD'));
				$('#dateFilter').data('daterangepicker').setEndDate(moment($("#filterDashboardByDate").data('daterangepicker').endDate).format('YYYY-MM-DD'));
				$('#dateFilter').html('<i class="fa fa-calendar"></i> <span>' + moment($("#filterDashboardByDate").data('daterangepicker').startDate).format('D MMM YYYY') + ' - ' + moment($("#filterDashboardByDate").data('daterangepicker').endDate).format('D MMM YYYY') + '</span>');
			}

			$("#tablePerformance").DataTable().ajax.url("{{url('getPerformanceByNeedAttention?')}}" + 'pid=' + pid + '&start=' + start + '&end=' + end + '&client=' + $("#filterDashboardByClient").val()).load()
			
			var urlAjax = '{{url("/ticketing/report/performance")}}?client=' + $("#clientList").val() + '&pid=' + pid + '&start=' + start + '&end=' + end + '&attention=attention'
		}
		$("#exportTablePerformance").attr('onclick',"getReport('" + urlAjax + "')")
	}	

	function getTripRequestAll()
	{
		if ($("#tableTripRequest").length) {
		} else {
			$("#tableTripRequest").DataTable({
				ajax:{
					type:"GET",
					url:"{{url('/ticketing/getTripRequestAll')}}",
					dataSrc: function(json){
						json.data.forEach(function(data,index){
							data.action = '<button class="btn btn-sm btn-secondary" type="button" onclick="detailTripRequest('+ data.id +')">Detail</button>'
						})
						return json.data;
					}
				},
				
				columns:[
					{ 	
						data:'id_ticket',
					},
					{
						data:'request_by',
					},
					{ 
						data:'from',
					},
					{ 
						data:'to',
					},
					{ 
						data:'start_date',
					},
					{ 
						data:'end_date',
					},
					{
						data:'type'
					},
					{
						data:'nominal'
					},
					{
						data:'nominal_settlement'
					},
					{
						data: 'action'
					}
				],
				autoWidth:false,
				lengthChange: false,
				searching:true,
				"processing": true,
				"ColumnDefs":[
		       { targets: 'no-sort', orderable: false }
		    ],
		    "aaSorting": [],
			})
		}
	}
</script>
@endsection