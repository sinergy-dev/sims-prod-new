@extends('template.main_sneat')
@section('tittle')
PMO
@endsection
@section('pageName')
Detail Project
@endsection
@section('head_css')
	<!-- <link rel="stylesheet" href="https://docs.dhtmlx.com/gantt/codebase/dhtmlxgantt.css?v=6.0.0"> -->
	<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  	<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
	<link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css" type="text/css"> 
	<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}"/>
	<link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ url('assets/css/jquery.emailinput.min.css') }}">
	<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
	<style type="text/css">
		.alertFinalProject{
			width: fit-content!important;
		    margin: 0 auto;
		    float: inline-end;
		    display: none;
		}

		.alertFinalProject:hover{
			cursor: pointer;
		}

		.rowColorRed .table-striped{
			background-color:#e83410;
			/*color: red;*/
		}

		.rowColorGreen .table-striped{
			background-color:green;
			/*color: red;*/
		}

		.modal-body label {
			font-size: 12px;
		}
		/* Chrome, Safari, Edge, Opera */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
		  -webkit-appearance: none;
		  margin: 0;
		}

		/* Firefox */
		input[type=number] {
		  -moz-appearance: textfield;
		}

		.select2,input[type=text],input[type=number],input[type=checkbox],textarea.form-control {
		  font-size: 12px;
		}

		.card-primary > .card-header{
			background-color: #3c8dbc;
	    	color: white;
		}

		button[type="button"]{
			font-size: 12px;
		}

		.card .card-primary {
			border-top-width: 0px;
		    border-top-style: solid;
		    border-top-color: rgb(210, 214, 222);
		}

		textarea{
			resize: vertical;
		  	font-size: 12px;
		}

		#tbTermsPayment>tbody>tr>th{
			padding: 0px!important;
		}

		#tbTermsPayment>tbody>tr>td{
			padding: 0px!important;
			padding-top: 8px!important;
			padding-right: 8px!important;
		}

		#tableUploadDoc td{
	    	padding-right: 0px!important;
	    	padding-left: 8px!important;
	    }

	    #tableWeeklyIssue td{
	    	padding: 0px!important;
	    	padding-top: 15px!important;
	    }

	    #tableWeeklyRisk td{
	    	padding: 0px!important;
	    	padding-top: 15px!important;
	    }

	    #modal_weekly input,#modal_weekly span,#modal_weekly textarea{
	    	font-size: 12px;
	    }

	    .invalid-feedback{
	    	font-size: 12px;
	    }

	    table tr th{
	    	font-size: 12px;
	    }

	    table tr td{
	    	font-size: 12px;
	    }

	    #tbInternalStakeholderRegister tr td select, #tbInternalStakeholderRegister tr td input, #tbodyTermsPayment tr td input{
			font-size: 12px;
		}

		.timelines {
		  width: 100%;
		  height: 100px;
		  max-width: 800px;
		  margin: 0 auto;
		  display: flex;      
		  justify-content: center;  
		}  

		.timelines .events {
		  position: relative;
		  background-color: #606060;
		  height: 3px;
		  width: 100%;
		  border-radius: 4px;
		  margin: 3em 0;
		 }

		.timelines .events ul {
		  list-style: none;
		}

		.timelines .events ul li:first-child {
		  display: inline-block;
		  width: 24.65%;
		  margin: 0;
		  padding: 0;
		}

		.timelines .events ul li a:first-child {
		  right:70px ;
		  /*font-family: 'Arapey', sans-serif;*/
		  font-style: italic;
		  font-size: 1em;
		  color: #606060;
		  text-decoration: none;
		  position: relative;
		  top: -32px;
		}

		.timelines .events ul li:nth-child(2) {
		  display: inline-block;
		  width: 28%;
		  margin: 0;
		  padding: 0;
		}

		.timelines .events ul li:nth-child(2) a{
		  left:20px ;
		  /*font-family: 'Arapey', sans-serif;*/
		  font-style: italic;
		  font-size: 1em;
		  color: #606060;
		  text-decoration: none;
		  position: relative;
		  top: -32px;
		}

		.timelines .events ul li:nth-child(3) {
		  display: inline-block;
		  width: 40%;
		  margin: 0;
		  padding: 0;
		}

		.timelines .events ul li:nth-child(3) a{
		  left:50px ;
		  /*font-family: 'Arapey', sans-serif;*/
		  font-style: italic;
		  font-size: 1em;
		  color: #606060;
		  text-decoration: none;
		  position: relative;
		  top: -32px;
		}

		.timelines .events ul li:nth-child(4) {
		  display: inline-block;
		  width: 0%;
		  margin: 0;
		  padding: 0;
		}

		.timelines .events ul li:nth-child(4) a{
		  left:20px ;
		  /*font-family: 'Arapey', sans-serif;*/
		  font-style: italic;
		  font-size: 1em;
		  color: #606060;
		  text-decoration: none;
		  position: relative;
		  top: -32px;
		}

		.timelines .events ul li a:after {
		  content: '';
		  position: absolute;
		  bottom: -25px;
		  left: 50%;
		  right: auto;
		  height: 20px;
		  width: 20px;
		  border-radius: 50%;
		  border: 3px solid #606060;
		  background-color: #fff;
		  transition: 0.3s ease;
		  transform: translateX(-50%);
		}

		.timelines .events ul li a:hover::after {
		  background-color: #194693;
		  border-color: #194693;
		}

		.timelines .events ul li a.selected:after {
		  background-color: #194693;
		  border-color: #194693;
		}	

		#tbStage > thead, #tbStage > tbody {
			text-align: center;
		}

		#tbMilestoneFinal, #tbMilestoneFinal > tr > td {
			font-size: 12px;
			padding: 5px;
		}

		.select2{
      width:100%!important;
  	}

  	.form-group{
  		margin-bottom: 15px;
  	}

  	.gantt_container {
        height: 600px;
    }

    .gantt_cal_light {
	    position: fixed !important; /* Fixed positioning to center on the screen */
	    top: 50% !important;       /* Move to the middle vertically */
	    left: 50% !important;      /* Move to the middle horizontally */
	    transform: translate(-50%, -50%) !important; /* Center it exactly */
	    z-index: 10001;            /* Ensure it stays above the overlay */
		}

		.swal2-container{
			z-index: 99999!important;
		}

	/*	.gantt_cal_cover {
		    z-index: 10000; /* Ensure the overlay is below the lightbox */
		}*/

	</style> 
@endsection
@section('content')
	<div class="container-xxl flex-grow-1 container-p-y">
		<section class="content-header" style="display:none!important">
	        <h6>
	    		<button class="btn btn-sm btn-danger" type="button" onclick="btnBack()" id="btnBack"><i class="bx bx-chevron-left"></i>&nbsp Back</button>
	            <span class="content-title"></span>
	        </h6>
	    </section>

	    <section class="content" style="display:none!important">
	    	<div class="detail_project">
		    	<div class="card mb-4">
		            <div class="card-header">
		            	<div class="row">
		            		<div class="col-md-6 col-xs-12">
		            			<button class="btn btn-sm btn-primary" id="btnAddMilestone" style="display:none!important"><i class="bx bx-plus"></i>&nbspMilestone</button>
		                		<button class="btn btn-sm text-bg-success" id="btnAddWeekly" style="display:none!important"><i class="bx bx-plus"></i>&nbspWeekly Report</button>
		            		</div>
		            		<div class="col-md-6 col-xs-12" style="text-align:right;">
		            			<!-- <button class="btn btn-sm btn-vk" onclick="btnShowProjectCharter()"><i class="bx bx-show"></i>&nbspShow Project Charter</button> -->
			                	<!-- <button class="btn btn-sm btn-warning"><i class="bx bx-forward"></i>&nbspNext Phase</button> -->
			                	<button class="btn btn-sm btn-primary" style="display:none!important" disabled id="btnSendCSS" onclick="showEmail()"><i class="bx bx-paper-plane"></i>&nbspSend CSS</button>
			                	<button class="btn btn-sm text-bg-success" disabled id="btnFinalProject" style="display:none!important"><i class="bx bx-plus"></i>&nbspFinal Project</button>		                	
			                	<!-- <div id="tooltip">
								    Please Make Done Your Issue and Risks Before Create Final Project Report!
								</div> -->
		            		</div>
		            	</div>
		            	<div class="alertFinalProject">
		            		<div class="alert alert-warning alert-dismissible">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
								<i class="icon bx bx-warning"></i>Please Make Done Your Issue and Risks Before Create Final Project Report!
							</div>
		            	</div>
		            </div>

		            <div class="card-body">
		            	<div class="row">
			            	<div class="col-md-12 col-sm-12">
			            		<div class="progress progress-md active" style="height:30px">
									<div class="progress-bar progress-bar-striped" id="progressbar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
										<span class="sr-only">20% Complete</span>
									</div>
								</div>
			            	</div>	            	
			            </div>

		                <div class="table-responsive">
		                    <table class="table table-striped" width="100%" id="tbMilestone">
		                        <thead>
		                        	<tr>
		                                <th style="text-align:center;">Initiating</th>
		                                <th style="text-align:center;">Planning</th>
		                                <th style="text-align:center;">Executing</th>
		                                <th style="text-align:center;">Closing</th>
		                            </tr>
		                        </thead>
		                        <tbody id="tbodyMilestone">
		                        </tbody>
		                    </table>
		                </div>
		            </div>
		        </div>

		        <div class="card mb-4">
		            <div class="card-header">
		            	<h6 class="card-title">Task on Going</h6>
		            </div>

		            <div class="card-body">
		                <div class="table-responsive">
		                    <table class="table table-striped" width="100%" id="tbStageWeekly">
				                <thead>
				                	<tr>
				                        <th>No</th>
				                        <th>Milestone</th>
				                        <th>Sub Task</th>
				                        <th>Periode</th>
				                        <th>Action</th>
				                    </tr>
				                </thead>
				                <tbody>
				                </tbody>
				            </table>
		                </div>
		            </div>
		        </div>

		        <div class="card mb-4">
		            <div class="card-header">
		            	<h6 class="card-title">Issue & Problems</h6>
		                <div class="card-tools">
		                	<button class="btn btn-sm text-bg-success" onclick="exportExcelIssue()"><i class="bx bx-download"></i> Excel</button>
		                	<button class="btn btn-sm btn-primary" id="btnAddIssue" style="display:none!important;" onclick="btnAddIssue()"><i class="bx bx-plus"></i>&nbspIssue</button>
		                </div>
		            </div>

		            <div class="card-body">
		                <div class="table-responsive">
		                    <table class="table table-striped" width="100%" id="tbIssue">
		                        <thead>
		                        </thead>
		                        <tbody class="tbodyIssue">
		                        </tbody>
		                    </table>
		                </div>
		            </div>
		        </div>

		        <div class="card mb-4">
		            <div class="card-header">
		            	<h6 class="card-title">Risk</h6>
		                <div class="card-tools">
		                	<button class="btn btn-sm text-bg-success" onclick="exportExcelRisk()"><i class="bx bx-download"></i> Excel</button>
		                	<button class="btn btn-sm btn-primary" id="btnAddRisk" style="display:none!important" onclick="btnAddRisk()"><i class="bx bx-plus"></i>&nbspRisk</button>
		                </div>
		            </div>

		            <div class="card-body">
		                <div class="table-responsive">
		                    <table class="table" width="100%" id="tbRisk">
		                        <thead>
		                            <tr>
		                                <th>No</th>
		                                <th>Risk Description</th>
		                                <th>Risk Owner</th>
		                                <th>Impact</th>
		                                <th>Likelihood</th>
		                                <th>Rank</th>
		                                <th>Impact Description</th>
		                                <th>Response</th>
		                                <th>Due Date</th>
		                                <th>Review Date</th>
		                                <th>Status</th>
		                                <th>Action</th>
		                            </tr>
		                        </thead>
		                        <tbody class="tbodyRisk">
		                        </tbody>
		                    </table>
		                </div>
		            </div>
		        </div>

		        <div class="card mb-4">
		            <div class="card-header">
		            	<h6 class="card-title">Documents</h6>
		                <div class="card-tools">
		                	<button class="btn btn-sm btn-primary" style="display:none!important" id="btnUploadDocument" onclick="btnUploadNewDocument()"><i class="bx bx-upload"></i>&nbspUpload Document</button>
		                </div>
		            </div>

		            <div class="card-body">
		                <div class="table-responsive">
		                    <table class="table table-striped" width="100%" id="tbDocuments">
		                    </table>
		                </div>
		            </div>
		        </div>

		        <div class="card mb-4">
		            <div class="card-header">
		            	<h6 class="card-title">Gantt Chart</h6>
		                <div class="card-tools">
		                	<button class="btn btn-sm text-bg-success" onclick="exportExcelGantt()"><i class="bx bx-download"></i>&nbspExport</button>
		                	<button class="btn btn-sm btn-primary" style="display:none!important;" id="btnAddBaseline" onclick="btnAddBaseline()"><i class="bx bx-plus"></i>&nbspBaseline</button>

		                </div>
		            </div>

		            <div class="card-body">
		                <div id="gantt_here" style='width:100%;height: 600px;'></div>
		            </div>
		        </div>

		        <div class="card mb-4">
		            <div class="card-header">
		            	<h6 class="card-title">Change log</h6>
		            </div>

		            <div class="card-body">
		                <div class="table-responsive">
		                    <table class="table table-striped" width="100%" id="tbChangeLog">
		                    </table>
		                </div>
		            </div>
		        </div>
	    	</div>

	    	<div class="show_project_charter" style="display:none!important">
	    		<div class="card mb-4">
	    			<div class="card-header">
	    				<h6 class="card-title">Project Charter</h6>
	    				<div class="card-tools">
	    					<button class="btn btn-sm btn-danger" id="btnRejectNotes" style="display:none!important;" onclick="btnRejectNotes()"><i class="bx bx-x"></i>&nbspReject</button>
	    					<a class="btn btn-sm btn-primary" style="display:none!important;" href="{{action('PMProjectController@downloadProjectCharterPdf')}}"><i class="bx bxs-file-pdf"></i>&nbspShow PDF</a>
	    				</div>
	    			</div>
	    			<div class="card-body" id="showBodyProjectCharter">
	    				
	    			</div>
	    		</div>
	    	</div>

	    	<div class="milestone" style="display:none!important;">
	    		<!-- <div class="row">
	    			<div class="col-md-12 col-xs-12">
	    				<div class="timelines">
					      <div class="events">
					          <ul>
					            <li>
					              <a href="#0" class="selected">Initiating</a>
					            </li>
					            <li>
					              <a href="#1">Planning</a>
					            </li>
					            <li>
					              <a href="#2">Executing</a>
					            </li>
					            <li>
					              <a href="#3">Closing</a>
					            </li>
					          </ul>
					      </div>
					    </div>
	    			</div>
	    		</div> -->
	    		<div id="milestone-container">
	    			
	    		</div>
	    	</div>

	    	<div class="showEmail" style="display:none!important">
	    	</div>
		</section>
	</div>

	<div class="modal fade" id="ModalReject" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">

	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true"></span></button>
	        <h6 class="modal-title">Reject</h6>
	      </div>
	      <div class="modal-body">
	        <form action="" id="modal_reject" name="modal_reject">
	          @csrf
	          <div class="form-group">
	            <label for="">Reject Notes</label>
	            <textarea id="rejectNotes" name="rejectNotes" class="form-control" placeholder="Reject Notes"></textarea>
	            <span class="invalid-feedback" style="display:none!important;">Please fill reject notes!</span>
	          </div> 
	      </div>                           
          <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-sm btn-danger" id="saveReasonReject" >Reject</button>
          </div>
        </form>
	    </div>
	  </div>
	</div>

	<!--modal issue-->
	<div class="modal fade" id="ModalIssue" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">

	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true"></span></button>
	        <h6 class="modal-title">Issue & Problems</h6>
	      </div>
	      <div class="modal-body">
	        <form action="" id="modal_issue" name="modal_issue">
	          @csrf
	          	<input type="" id="id_issue" name="" style="display: none;">
		        <div class="form-group">
		          	<label>Issue Description*</label>
		          	<textarea id="textareaDescIssue" name="textareaDescIssue" class="form-control" placeholder="Issue" onkeyup="validationCheck(this)"></textarea>
	                <span class="invalid-feedback" style="display:none!important;">Please fill Issue Description!</span>
	          	</div>
	          	<div class="form-group">
		          	<label>Solution Plan*</label>
		          	<textarea class="form-control" placeholder="Solution Plan" name="textareaSolutionPlan" id="textareaSolutionPlan" onkeyup="validationCheck(this)"></textarea>
	                <span class="invalid-feedback" style="display:none!important;">Please fill Solution Plan!</span>
		        </div>
		        <div class="form-group">
		          	<label>Owner*</label>
		          	<input type="text" class="form-control" placeholder="Owner" id="inputOwnerIssue" name="inputOwnerIssue" onkeyup="validationCheck(this)"/>
	                <span class="invalid-feedback" style="display:none!important;">Please fill Owner!</span>
		        </div>
	          	<div class="row">
	          		<div class="col-md-6 form-group">
                	<label>Expected Solved Date*</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                        <input type="text" name="expected_date" id="expected_date" class="form-control" placeholder="Select Expected Date" onchange="validationCheck(this)"/>
                      </div>
                        <span class="invalid-feedback" style="display:none!important;">Please fill Expected Solved Date!</span>
                    </div>
                    <div class="col-md-6 form-group">
                    <label>Actual Solved Date</label>
                      <div class="input-group">

                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                        <input type="text" name="actual_date" id="actual_date" class="form-control" placeholder="Select Actual Date" onchange="validationCheck(this)"/>
                      </div>
                        <span class="invalid-feedback" style="display:none!important;">Please fill Actual Solved Date!</span>
                    </div>
                </div>  
                <div class="row">
                	<div class="col-md-6 col-xs-12">
	                    <div class="form-group">
	                      	<label>Rating/Severity* &nbsp<i style="color:#f39c12;" class="bx bx-info-circle help-btn-rating" value="rating"></i></label>
		                    <input type="number" min="1" max="5" placeholder="1-5" name="inputRatingIssue" id="inputRatingIssue" class="form-control" onkeyup="validationCheck(this)"/>
	                        <span class="invalid-feedback" style="display:none!important;">Please fill Rating/Severity!</span>
	                    </div>
                  	</div>
                  	<div class="col-md-6 col-xs-12">
	                    <div class="form-group">
	                      <label>Status</label>
	                      <select class="form-control" name="selectStatusIssue" id="selectStatusIssue" placeholder="Select status" onchange="validationCheck(this)">
	                        <option value="open">Open</option>
	                        <option value="close">Close</option>
	                      </select>
	                      <span class="invalid-feedback" style="display:none!important;">Please fill Status!</span>
	                    </div>
                  </div>
                </div>
	      	</div>
          	<div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" onclick="saveIssue()">Save</button>
          	</div>
	        </form>
	    </div>
	  </div>
	</div>

	<!--modal risk-->
	<div class="modal fade" id="ModalRisk" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">

	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true"></span></button>
	        <h6 class="modal-title">Initial Risk</h6>
	      </div>
	      <div class="modal-body">
	        <form action="" id="modal_risk" name="modal_risk">
	          @csrf
	          	<div class="tabGroup">
                    <div class="form-group">
                      <label>Risk Description*</label>
                      <textarea class="form-control" id="textAreaRisk" name="textAreaRisk" placeholder="Risk Description"></textarea>
                      <span class="invalid-feedback" style="display:none!important;">Please fill Risk Description!</span>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                          <label>Owner*</label> 
                          <input type="text" class="form-control" id="inputOwner" name="inputOwner" placeholder="Owner"/>
                          <span class="invalid-feedback" style="display:none!important;">Please fill Owner!</span>
                        </div>
                      </div>
                      <div class="col-md-3 col-xs-12">
                        <div class="form-group">

                          <label>Impact*&nbsp<i style="color:#f39c12;" class="bx bx-info-circle help-btn-impact" value="impact"></i></label> 
                          <input max="5" min="1" type="number" class="form-control" onkeyup="validationCheck(this)" id="inputImpact" name="inputImpact" placeholder="1-5"/>
                          <span class="invalid-feedback" style="display:none!important;">Please fill Impact!</span>
                        </div>
                      </div>
                      <div class="col-md-3 col-xs-12">
                        <div class="form-group">

                          <label>Likelihood*&nbsp<i style="color:#f39c12;" class="bx bx-info-circle help-btn-likelihood" value="likelihood"></i></label> 
                          <input max="5" min="1" type="number" class="form-control" id="inputLikelihood" name="inputLikelihood" placeholder="1-5" onkeyup="validationCheck(this)"/>
                          <span class="invalid-feedback" style="display:none!important;">Please fill Likelihood!</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Rank*</label>
                      <input class="form-control" type="text" placeholder="Rank" id="inputRank" name="inputRank" disabled />
                    </div>
                    <div class="form-group">
                      <label>Impact Description*</label>
                      <textarea class="form-control" placeholder="Description" id="textareaDescription" name="textareaDescription"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                          <div class="form-group">
                            <label>Response*</label> 
                            <textarea class="form-control" id="textareaResponse" name="textareaResponse" placeholder="Response"></textarea>
                            <span class="invalid-feedback" style="display:none!important;">Please fill Risk Response!</span>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                          <label>Due Date*</label>
                          <div class="input-group">

                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                            <input type="text" name="due_date" id="due_date" class="form-control" id="due_date" placeholder="Select Due Date" />
                          </div>
                            <span class="invalid-feedback" style="display:none!important;">Please fill Due Date!</span>
                        </div>
                      </div>
                      <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                          <label>Review Date*</label>
                          <div class="input-group">

                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                            <input type="text" name="review_date" id="review_date" class="form-control" id="review_date" placeholder="Select Review Date" />
                          </div>
                            <span class="invalid-feedback" style="display:none!important;">Please fill Review Date!</span>
                        </div>
                      </div>
                      <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                          <label>Status*</label>
                          <select class="form-control" id="selectStatusRisk" name="selectStatusRisk">
                            <option value="Active">Active</option>
                            <option value="Obsolete">Obsolete</option>
                            <option value="Accepted">Accepted</option>
                          </select>
                          <span class="invalid-feedback" style="display:none!important;">Please fill Status!</span>
                        </div>
                      </div>
                    </div>
              	</div> 
	      		</div>

              	<input type="" name="" id="id_risk" style="display:none!important">                         
	          	<div class="modal-footer">

	              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
	              <button type="button" class="btn btn-primary" onclick="saveRisk()">Save</button>
	          	</div>
	        </form>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="ModalUploadNewDocument" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">

	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true"></span></button>
	        <h6 class="modal-title">Upload Document</h6>
	      </div>
	      <div class="modal-body">
	        <form action="" id="modal_upload_document" name="modal_upload_document">
	          @csrf
	          <div class="form-group">
	            <label for="">Sub Task*</label>
	            <select id="sub_task_document" name="sub_task_document" class="form-control" onchange="validationCheck(this)">
	            	<option></option>
	            </select>
	            <span class="invalid-feedback" style="display:none!important;">Please Select Sub Task!</span>
	          </div> 

	          <div class="table-responsive">
	          <table id="tableUploadDoc" class="table border-collapse:collapse" style="width:100%;white-space: nowrap;">
	            <tbody  id="tbodyUploadDoc">
	              <tr class="trDoc">
	                <td>
	                	<div class="form-group">
	                		<div style="padding:5px;border:solid 1px #cccc;width: 300px;">

			                    <label for="inputDoc_0" class="bx bx-upload" id="title_doc_0" data-value="0">&nbsp; <span>Upload Document</span>
			                      <input type="file" class="document" name="inputDoc" id="inputDoc_0" data-value="0" style="display: none;" onchange="validationCheck(this)">
			                    </label>
			                  </div>
			                  <span class="invalid-feedback" style="display:none!important;color: red;">Please upload document!</span>
	                	</div>
	                </td>
	                <td>
		                <div class="form-group">
		                	<input id="inputDocTitle_0" name="inputDocName" data-value="0" type="text" name="" class="form-control" style="width:250px" placeholder="Document Name" onkeyup="validationCheck(this)">
		                  	<span class="invalid-feedback" style="display:none!important;color: red;">Please fill document name!</span>
		              	</div>
	                </td>
	              </tr>
	            </tbody>
	          </table>
	          </div>   

	          <div class="form-group" style="display: flex;margin-top: 20px;">

	            <button type="button" id="btnAddDoc" style="margin:0 auto" class="btn btn-sm btn-primary" onclick="addDocPendukung()"><i class="bx bx-plus"></i>&nbsp Document</button>
	          </div>  
	      	  </div>
	          <div class="modal-footer">
	              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
	              <button type="button" class="btn btn-primary" onclick="saveDocument()">Save</button>
	          </div>
	        </form>
	    </div>
	  </div>
	</div>

	<!--modal weekly-->
	<div class="modal fade" id="ModalWeekly" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">

	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true"></span></button>
	        <h6 class="modal-title">Weekly Report</h6>
	      </div>
	      	<div class="modal-body">
	        <form action="" id="modal_weekly" name="modal_weekly">
	          @csrf
	          	<div class="tab-add">
	          		<label style="margin-bottom:0px!important">Document Distribution</label>
		          	<hr style="margin-bottom: 10px;margin-top: 5px;border-color: #f4f4f4;">
		          	<table id="tbWeeklyReport" class="table" style="width:100%">
		          		<thead>
		          			<th>Recipient</th>
		          			<th>Company</th>
		          			<th>Title</th>
		          			<th>Email</th>

		          			<th><button type="button" onclick="addDistiInfo()" style="background:transparent;border: none;"><i class="bx bx-plus"></i></button></th>
		          		</thead>
		          		<tbody id="tbodyWeeklyDistiInformation">
		          			<tr>
			          			<td>
			          				<input type="text" placeholder="Recipient" name="inputRecipientDisti" id="inputRecipientDisti" class="form-control">
			          			</td>
			          			<td>
			          				<input type="text" placeholder="Company" name="inputCompanyDisti" id="inputCompanyDisti" class="form-control">
			          			</td>
			          			<td>
			          				<input type="text" placeholder="Title" name="inputTitleDisti" id="inputTitleDisti" class="form-control">
			          			</td>
			          			<td>
			          				<input type="text" placeholder="Email" name="inputEmailDisti" id="inputEmailDisti" class="form-control">
			          			</td>
			          			<td>

			          				<button class="btnRemove" type="button" style="background:transparent;border: none;color: red;"><i class="bx bx-trash"></i></button>
			          			</td>
			          		</tr>
		          		</tbody>		          		
		          	</table>
	          	</div>
	          	<div class="tab-add" style="display:none!important">
	          		<label style="margin-bottom:0px!important">Project Information</label>
		          	<hr style="margin-bottom: 10px;margin-top: 5px;border-color: #f4f4f4;">
		          	<div class="row">
		          		<div class="col-md-6">
		          			<div class="form-group">
		                      <label>Reporting Date*</label>
		                      <div class="input-group">

		                      	<span class="input-group-text"><i class="bx bx-calendar"></i></span>
		                      	<input type="text" class="form-control" id="date_report_date" name="date_report_date" placeholder="Select report date" onchange="validationCheck(this)">
		                      </div>
		                      <span class="invalid-feedback" style="display:none!important;">Please fill Reporting Date!</span>
		                    </div>
		          		</div>
		          		<div class="col-md-6">
		          			<div class="form-group">
		                      <label>Overall Progress*</label>
		                      <input type="text" id="overall_progress" name="overall_progress" class="form-control" placeholder="Describe what percentage the project progress" name="" onkeyup="validationCheck(this)" disabled>
		                      <span class="invalid-feedback" style="display:none!important;">Please fill Risk Description!</span>
		                    </div>
		          		</div>
		          	</div>    

		          	<div class="form-group">
	                  <label>Project Indicator*</label>
	                  <div class="radio">
	                  	<label><input type="radio" id="radioProjectIndicator" value="onTrack" name="radioProjectIndicator" onchange="validationCheck(this)">&nbsp&nbspSchedule on track, no major issue(s), no high risk(s)</label>
	                  </div>
	                  <div class="radio">
	                  	<label><input type="radio" value="mightDelay" id="radioProjectIndicator" name="radioProjectIndicator" onchange="validationCheck(this)">&nbsp&nbspSchedule might delay, some issue(s), potential risk(s)</label>
	                  </div>
	                  <div class="radio">
	                  	<label><input type="radio" value="delayed" name="radioProjectIndicator" id="radioProjectIndicator" onchange="validationCheck(this)">&nbsp&nbspSchedule is delayed, major issue(s), and/or potential risk(s)</label>
	                  </div>
		              <span class="invalid-feedback" style="display:none!important;">Please fill Project Indicator!</span>
	              	</div>

	                <div class="form-group">
	                  	<label>Project Status Summary</label>
	                  	<textarea class="form-control" id="textareaStatusSummary" name="textareaStatusSummary" placeholder="Describe summary of progress project during this period" onkeyup="validationCheck(this)"></textarea>
		              	<span class="invalid-feedback" style="display:none!important;">Please fill Status Summary!</span>
	                </div>

		            <label style="margin-bottom:0px!important">Project Health Status</label>
		          	<hr style="margin-bottom: 10px;margin-top: 5px;border-color: #f4f4f4;">

		          	<div id="cbProjectHealthStatus">
		          	
		          	</div>		          	
	          	</div>	                    
	        <!--   	<div class="tab-add" style="display:none!important">
	          		<label style="margin-bottom:0px!important">Issue</label>
		          	<table id="tableWeeklyIssue" class="table" style="width:100%;border-collapse: separate;border-spacing: 0;">
		          		<tbody id="tbodyWeeklyIssue">
		          			<tr>
			          			<td>
			          				<div class="form-group">
						          		<label>Issue Description</label>
						          		<textarea class="form-control" id="textAreaIssueDesc" name="textAreaIssueDesc" placeholder="Describe summary of progress project during this period" onkeyup="validationCheck(this)" data-value="0"></textarea>
		                      			<span class="invalid-feedback" style="display:none!important;">Please fill Issue Description!</span>
						          	</div>
						          	<div class="form-group">
						          		<label>Solution Plan</label>
						          		<textarea class="form-control" id="textareaSolutionPlanIssue" name="textareaSolutionPlanIssue" placeholder="Describe summary of progress project during this period" onkeyup="validationCheck(this)" data-value="0"></textarea>
		                      			<span class="invalid-feedback" style="display:none!important;">Please fill Solution Plan!</span>
						          	</div>
						          	<div class="form-group">
				          				<label>Owner</label>
				          				<input type="text" class="form-control" name="inputOwnerIssue" id="inputOwnerIssue" placeholder="Owner" onkeyup="validationCheck(this)" data-value="0">
		                      			<span class="invalid-feedback" style="display:none!important;">Please fill Owner!</span>
				          			</div>
						          	<div class="row">
						          		<div class="col-md-3">
						          			<div class="form-group">
						          				<label>Rating/Severity</label>
						          				<input type="number" class="form-control" name="inputRatingIssue" onkeyup="validationCheck(this)" id="inputRatingIssue" placeholder="1-5" max="5" min="1" data-value="0">
		                      					<span class="invalid-feedback" style="display:none!important;">Please fill Rating!</span>
						          			</div>
						          		</div>	
						          		<div class="col-md-3">
						          			<div class="form-group">
						          				<label>Expected Solved Date*</label>
						                      <div class="input-group">

						                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
						                        <input type="text" name="expected_date_issue" id="expected_date_issue" class="form-control" placeholder="Select Expected Date" onchange="validationCheck(this)" data-value="0"/>
					                     	 </div>
					                        <span class="invalid-feedback" style="display:none!important;">Please fill Expected Solved Date!</span>
						          			</div>
					                    </div>
					                    <div class="col-md-3">
					                    	<div class="form-group">
					                    		<label>Actual Solved Date*</label>
							                      <div class="input-group">

							                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
							                        <input type="text" name="actual_date_issue" id="actual_date_issue" class="form-control" placeholder="Select Actual Date" onchange="validationCheck(this)" data-value="0"/>
							                      </div>
						                        <span class="invalid-feedback" style="display:none!important;">Please fill Actual Solved Date!</span>
					                    	</div>
					                    </div>	
						          		<div class="col-md-3">
						          			<div class="form-group">
						          				<label>Status</label>
						          				<select data-value="0" class="form-control" name="status_issue" id="status_issue" style="width:100%" onchange="validationCheck(this)">
						          					<option value="open">Open</option>
						          					<option value="close">Close</option>
						          				</select>
		                      					<span class="invalid-feedback" style="display:none!important;">Please fill Status!</span>
						          			</div>
						          		</div>	
						          	</div>
			          			</td>
			          		</tr>
		          		</tbody>		          		
		          	</table>
		          	<div style="display: flex;margin-bottom:15px">

		          		<button type="button" class="btn btn-sm btn-primary" style="margin:0 auto;" onclick="addIssueWeekly()"><i class="bx bx-plus" ></i>&nbspIssue</button>
		          	</div>
	          	</div>
	          	<div class="tab-add" style="display:none!important">
	          		<label style="margin-bottom:0px!important">Risks</label>
	          		<table id="tableWeeklyRisk" class="table" style="width:100%;border-collapse:separate;white-space: nowrap;">
	          			<tbody id="tbodyRiskWeekly">
	          				<tr>
	          					<td>
	          						<div class="form-group">
					          			<label>Risk Description</label>
					          			<textarea class="form-control" data-value="0" placeholder="Risk Description" id="textareaDescriptionRisk" name="textareaDescriptionRisk" onkeyup="validationCheck(this)"></textarea>
		                      			<span class="invalid-feedback" style="display:none!important;">Please fill Risk Description!</span>
					          		</div>
					          		<div class="form-group">
					          			<label>Response Plan</label>
					          			<textarea class="form-control" data-value="0" placeholder="Response Plan" id="textareaResponseRisk" name="textareaResponseRisk" onkeyup="validationCheck(this)"></textarea>
		                      			<span class="invalid-feedback" style="display:none!important;">Please fill Response Plan!</span>
					          		</div>
					          		<div class="row">
						          		<div class="col-md-3">
						          			<div class="form-group">
						          				<label>Owner</label>
						          				<input type="text" data-value="0" class="form-control" name="inputOwnerRisk" id="inputOwnerRisk" placeholder="Owner" onkeyup="validationCheck(this)">
						          			</div>
		                      				<span class="invalid-feedback" style="display:none!important;">Please fill Owner!</span>
						          		</div>	
						          		<div class="col-md-3">
						          			<div class="form-group">
						          				<label>Rating/Severity</label>
						          				<input type="text" data-value="0" class="form-control" name="inputRatingRisk" id="inputRatingRisk" placeholder="1-5" max="5" min="1" onkeyup="validationCheck(this)">
						          			</div>
		                      				<span class="invalid-feedback" style="display:none!important;">Please fill Rating!</span>
						          		</div>	
						          		<div class="col-md-3">
						          			<div class="form-group">
						          				<label>Due Date</label>
						          				<div class="input-group">
						          					<div class="input-group-text">

						          						<i type="text" class="bx bx-calendar" name=""></i>
						          					</div>
						          					<input type="text" data-value="0" class="form-control " name="due_date_risk" id="due_date_risk" placeholder="Select Due Date" onchange="validationCheck(this)">
						          				</div>
		                      					<span class="invalid-feedback" style="display:none!important;">Please fill Due Date!</span>
						          			</div>
						          		</div>	
						          		<div class="col-md-3">
						          			<div class="form-group">
					                          	<label>Status</label><br>
					                          	<select data-value="0" class="form-control" id="status_risk" name="status_risk" onchange="validationCheck(this)">
					                            	<option value="active">Active</option>
					                            	<option value="obsolete">Obsolete</option>
					                            	<option value="accepted">Accepted</option>
					                          	</select>
		                      					<span class="invalid-feedback" style="display:none!important;">Please fill Status!</span>
											</div>	
						          		</div>
						          	</div>
	          					</td>
	          				</tr>
	          			</tbody>
	          		</table>
	          		<div style="display: flex;margin-bottom:15px">

		          		<button type="button" class="btn btn-sm btn-primary" style="margin:0 auto;" onclick="addRiskWeekly()"><i class="bx bx-plus" ></i>&nbspRisk</button>
		          	</div>
	          	</div> -->
	        <!--   	<div class="tab-add" style="display:none!important;">
	          		<div class="form-group">
	          			<label>Schedule Management</label>
	          			<textarea class="form-control" placeholder="File Name of WBS Project timeline (.mpp) from"></textarea>
	          		</div>
	          	</div> -->
	      		</div>
	          	<div class="modal-footer">

	              <button type="button" class="btn btn-outline-secondary" id="prevBtnWeekly">Cancel</button>
	              <button type="button" class="btn btn-primary" id="nextBtnWeekly" >Next</button>
	          	</div>
	        </form>
	    </div>
	  </div>
	</div>

	<!--modal final project-->
	<div class="modal fade" id="ModalFinalProject" role="dialog">
	  	<div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">

		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
		        <span aria-hidden="true"></span></button>
		        <h6 class="modal-title">Project Information</h6>
		      	</div>
		      	<div class="modal-body">
		        <form action="" id="modal_final_report" name="modal_final_report">
		          @csrf
		        	<div class="tab-add-final" style="display:none!important;">
		          		<div class="tabGroup">
		          		<div class="form-group">
				        	<label>Customer</label>
				          	<input type="text" class="form-control" placeholder="Name of The Customer's Company" name="customer_name_final_project" id="customer_name_final_project" disabled>
				        </div>
			          	<div class="row">
			          		<div class="col-md-6">
			          			<div class="form-group">
			          				<label>Project ID Number</label>
			          				<input name="PID_final_project" id="PID_final_project" class="form-control" disabled />
			          			</div>
			          		</div>
				          	<div class="col-md-6">
				          		<div class="form-group">
				          			<label>Project Value</label>
				          			<input type="text" class="form-control" placeholder="Project Value"  name="projectValueFinal" id="projectValueFinal" disabled>
				          		</div>
				          	</div>
			          	</div>
			          	<div class="form-group">
			          		<label>Project Name</label>
			          		<input type="text" class="form-control" placeholder="Name of The Project" name="projectNameFinal" id="projectNameFinal" disabled>
			          	</div>
			          	<div class="row">
				          	<div class="col-md-6">
				          		<div class="form-group">
				          			<label>Project Manager</label>
				          			<input type="text" class="form-control" id="projectManagerFinal" name="projectManagerFinal" disabled/>
				          		</div>
				          	</div>
				          	<div class="col-md-6">
				          		<div class="form-group">
				          			<label>Project Coordinator</label>
				          			<input type="text" class="form-control" id="projectCoordinatorFinal" name="projectCoordinatorFinal" disabled/>
				          		</div>
				          	</div>
			          	</div>
			          	<div class="form-group">
			          		<label>Project Description</label>
			          		<textarea class="form-control" placeholder="Description of The Project" name="textareaProjectDescFinal" id="textareaProjectDescFinal" disabled></textarea>
			          	</div>
		          		</div>
			          	
			          	<!-- <div class="form-group">
			          		<label>Schedule Summary</label>
			          		<select id="selectScheduleSummaryFinal" name="selectScheduleSummaryFinal" class="form-control">
		                      <option></option>
		                    </select>
			          	</div> -->
		          	</div>
		          	<div class="tab-add-final" style="display:none!important;">
		          		<div class="tabGroup">
		          			<div class="form-group">
				          		<table id="tbMilestoneFinal" class="table" style="width:100%;border-collapse: collapse;">
				          			
				          		</table>
				          		<div class="form-group">
					          		<label>Schedule Summary</label>
					          		<select id="selectScheduleSummaryFinal" name="selectScheduleSummaryFinal" class="form-control">
				                      <option></option>
				                    </select>
					          	</div>
			          		</div>
		          		</div>
		          	</div>
		          	<div class="tab-add-final" style="display:none!important;">
		          		<div class="tabGroup">
		          			<div id="divShowChecklist">
		          		
		          			</div>
		          		</div>
		          	</div>
		      	</form>
		      	</div>
		      	<div class="modal-footer">
		      		<button class="btn btn-sm btn-outline-secondary" id="prevBtnFinal">Back</button>
		      		<button class="btn btn-sm btn-primary" id="nextBtnFinal">Next</button>
		      	</div>
		  </div>
		</div>
	</div>

	<!--modal custom task-->
	<div class="modal fade" id="ModalTypeMilestone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
	      <div class="modal-header">

	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	        <h6 class="modal-title">Milestone</h6>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
	        	<label>Milestone Type</label>
	        	<select class="form-control" id="selectTypeMilestone" name="selectTypeMilestone">
	        		<option></option>
	        	</select>
                <span class="invalid-feedback" style="display:none!important">Please Select Milestone Type!</span>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary" onclick="saveTypeMilestone()">Save</button>
	      </div>
	    </div>
	  </div>
	</div>

@endsection
@section('scriptImport')
<!-- <script type="text/javascript" src="https://docs.dhtmlx.com/gantt/codebase/dhtmlxgantt.js?v=6.0.0"></script> -->
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script type="text/javascript" src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>
<script src="https://export.dhtmlx.com/gantt/api.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>
<script src="{{ url('assets/js/jquery.emailinput.min.js')}}"></script>
@endsection 
@section('script')
<script type="text/javascript">
	var accesable = @json($feature_item);
    accesable.forEach(function(item,index){
      $("#" + item).show()
    })

    $('input[class="document"]').change(function(){
	    var f=this.files[0]
	    var filePath = f;
	 
	    // Allowing file type
	    var allowedExtensions =
	    /(\.pdf)$/i;

	    var ErrorText = []
	    // 
	    if (f.size > 30000000|| f.fileSize > 30000000) {
	      Swal.fire({
	        icon: 'error',
	        title: 'Oops...',
	        text: 'Invalid file size, just allow file with size less than 30MB!',
	      }).then((result) => {
	        this.value = ''
	      })
	    }

	    var ext = filePath.name.split(".");
	    ext = ext[ext.length-1].toLowerCase();      
	    var arrayExtensions = ["pdf"];

	    if (arrayExtensions.lastIndexOf(ext) == -1) {
	      Swal.fire({
	        icon: 'error',
	        title: 'Oops...',
	        text: 'Invalid file type, just allow pdf file',
	      }).then((result) => {
	        this.value = ''
	      })
	    }
	}) 

    $(document).ready(function(){
    	gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";
    	gantt.config.show_links = true;
        
    	gantt.init("gantt_here");

        gantt.plugins({ export: true });
    	gantt.config.columns=[
		    {name:"text",  	label:"Milestone",  tree:true, resize:true,width:300, min_width:140 },
		    {name:"baseline_start", label:"Baseline Start", align: "center", width:150, min_width:100 },
		    {name:"baseline_end",   label:"Baseline End",   align: "center", width:150, min_width:100 },
		    {name:"start_date",     label:"Start", align: "center", width:150, min_width:100 },
		    {name:"end_date",       label:"End", align: "center",width:150, min_width:100  },
		    {name:"add",  			label:"" }
		];

		gantt.config.grid_resize = true; 
		gantt.config.autoscroll = false;
		gantt.config.layout = {
		  	css: "gantt_container",
		  	rows:[
		      {
		        cols: [
		          {view: "grid", id: "grid", scrollX:"scrollHor", scrollY:"scrollVer"},
		          {resizer: true, width: 1},
		          {view: "timeline", id: "timeline", scrollX:"scrollHor", scrollY:"scrollVer"},
		          {view: "scrollbar", scroll: "y", id:"scrollVer"}
		        ]
		       },
		      {view: "scrollbar", scroll: "x", id:"scrollHor", height:20}
		    ]
		  // cols: [
		  //   {
		  //     width:400,
		  //     min_width: 300,
		  //     rows:[
		  //       {view: "grid", scrollX: "gridScroll", scrollable: true, scrollY: "scrollVer"}, 
		 
		  //        // horizontal scrollbar for the grid
		  //       {view: "scrollbar", id: "gridScroll", group:"horizontal"}, 
		  //       {view: "scrollbar", id: "scrollHor"}
		  //     ]
		  //   },
		  //   {resizer: true, width: 1},
		  //   {
		  //     rows:[
		  //       {view: "timeline", scrollX: "scrollHor", scrollY: "scrollVer"},
		 
		  //       // horizontal scrollbar for the timeline
		  //       {view: "scrollbar", id: "scrollHor", group:"horizontal"},
		  //       {view: "scrollbar", id: "scrollHor"}

		  //     ]
		  //   },
		  //   {view: "scrollbar", id: "scrollVer"},
		  //   {view: "scrollbar", id: "scrollHor"}

		  // ]
		};
		gantt.config.grid_elastic_columns = true;

	    gantt.load("{{url('/PMO/getGantt')}}/?id_pmo="+window.location.href.split("/")[5].split("?")[0]);
	    gantt.config.resize_rows = true;
	    gantt.config.autofit = true;

	    var dp = new gantt.dataProcessor("{{url('/api')}}");
	    dp.init(gantt);
	    dp.setTransactionMode("REST");

	    // export to .mpp cant just .xml

		(function () {
	    const startDatepicker = (node) => $(node).find("input[name='start']");
	    const endDateInput = (node) => $(node).find("input[name='end']");
	 
	    gantt.form_blocks["datepicker"] = {
	        render: (sns) => {
	          const height = sns.height || 45;
	            return "<div class='gantt-lb-datepicker' style='height:" + height + "px;padding-left:12px;padding-right:12px'>"+
	            			"<div class='row'>" +
	            				"<div class='col-md-5'>"+
	            					"<div class='form-group'>" + 
				            			"<div class='input-group'>" +

				            				"<span class='input-group-text'><i class='bx bx-calendar'></i></span>" +
				            				"<input type='text' name='start' class='form-control' style='height:35px'>"+
				            			"</div>" +
			            			"</div>" +
	            				"</div>" +
	            				"<div class='col-md-1'><span>To<span></div>" +
	            				"<div class='col-md-5'>"+
	            					"<div class='form-group'>" + 
				            			"<div class='input-group'>" +

				            				"<span class='input-group-text'><i class='bx bx-calendar'></i></span>" +
				            				"<input type='text' name='end' class='form-control' style='height:35px'>"+
				            			"</div>" +
			            			"</div>" +
	            				"</div>"+
	            			"</div>" +
	            				
	                    "</div>";;
	        },
	        set_value: (node, value, task, section) => {
            const datepickerConfig = { 
                format: 'yyyy-mm-dd',
                autoclose: true,
                container: gantt.$container
            };
            const startPicker = startDatepicker(node).flatpickr(datepickerConfig);
						startPicker.setDate(value ? value.start_date : task.start_date);

						const endPicker = endDateInput(node).flatpickr(datepickerConfig);
						endPicker.setDate(value ? value.end_date : task.end_date);

						startPicker.config.onChange.push(function(selectedDates) {
					    const startValue = selectedDates[0];
					    const endValue = endPicker.selectedDates[0];

					    if (startValue && endValue && endValue.valueOf() <= startValue.valueOf()) {
					        endPicker.setDate(
					            gantt.calculateEndDate({
					                start_date: startValue,
					                duration: 1,
					                task: task
					            })
					        );
					    }
						});
	        },
	        get_value: (node, task, section) => {
	          const startPicker = startDatepicker(node).flatpickr();
						const endPicker = endDateInput(node).flatpickr();

						const start = startPicker.selectedDates[0]; 
						let end = endPicker.selectedDates[0]; 

						if (start && end && end.valueOf() <= start.valueOf()) {
						    end = gantt.calculateEndDate({
						        start_date: start,
						        duration: 1,
						        task: task
						    });
						}

						if (task.start_date && task.end_date) {
						    task.start_date = start;
						    task.end_date = end;                 
						}

						task.duration = gantt.calculateDuration(task);

						return {
						    start_date: start,
						    end_date: end,
						    duration: task.duration
						};

	        },
	        focus: (node) => {
	        }
	    }
		})();

		gantt.config.lightbox.sections = [
		  { name: "description", height: 70, map_to: "text", type: "textarea", focus: true },
		  { name: "time", height: 45, map_to: "auto", type: "datepicker" }
		];

		showMilestoneData()
		getProgressBar()
		
    	if (window.location.search.split("?")[1] == 'showProject') {
    		btnShowProjectCharter(window.location.href.split("/")[5].split("?")[0])
    	}else{
    		$(".content-header").show()
    		$(".content").show()

    		if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Project Management Office Manager')->exists()}}" || "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','VP Program & Project Management')->exists()}}") {
    			$("#btnAddMilestone").find("i").removeClass('bx-plus').addClass('bx-show')
    			$("#btnFinalProject").find("i").removeClass('bx-plus').addClass('bx-show')
    		}else{
    			$("#btnAddMilestone").attr("onclick","btnAddMilestone()")
    		}

    		if (window.location.search.split("=")[1] == "supply_only") {
    			$("#btnFinalProject").attr('style','display:none!important')
    			$("#btnAddWeekly").attr('style','display:none!important')
    			$("#btnSendCSS").attr('style','display:none!important')
    		}
    	}
    })
	
	function exportExcelGantt(){
    	gantt.exportToExcel({
		   name:"document.xlsx", 
		});
    }	
		
	var dataSet = [
	    ['1', 'Pengadaan Peremajaan Storage File System DC DRC', 'Pemeliharaan Storage','link','monitoring'],
	    ['2', 'Document Final Prokect', 'Closing','link','closing'],

	];

	$('#tbDocuments').DataTable({
		ajax:{
        	url:"{{url('/PMO/getShowDocument')}}",
        	data:{
        		id_pmo:window.location.href.split("/")[5].split("?")[0]
        	},
        	dataSrc:"data"
      	},
        "columns": [
            {title: "No",width:"5%",
            	render:function(data, type, row,meta)
                {	
                	return ++meta.row                     
                },
        	},
            {title: "Document Name",data:"document_name"},
            {title: "Sub Task",
           		render:function(data, type, row)
                {	
                	if (!row.sub_task) {
                		return "Project Charter"
                	}else{
                		return row.text
                	}
                    
                },
            },
            {
                "title":"Link",
                "data": null,
                render:function(data, type, row)
                {	
                	return '<a href="'+ row.link_drive +'" target="_blank"><button class="btn btn-sm btn-primary"><i class="bx bx-file-pdf-o"></i>&nbspShow Pdf</button></a>'
                    
                },
            },
            {
                "title":"Action",
                "data": null,
                render:function(data, type, row)
                {	

                	if("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Project Transformation Officer')->exists()}}") {
						return '<button class="btn btn-sm btn-danger disabled" ><i class="bx bx-trash"></i>&nbspDelete</button>'
					} else {
						return '<button class="btn btn-sm btn-danger" onclick="deleteDoc('+ row.id_document +')"><i class="bx bx-trash"></i>&nbspDelete</button>'
					}
                },
            },
        ],
	})

    let firstPage = ''
    function btnBack(){
    	console.log(firstPage)
    	if (firstPage) {
    		$(".content-header").attr('style','display:none!important')
    		$(".content").attr('style','display:none!important')
    		window.location.href = "{{url('PMO/project')}}"
    		// $(".content-title").text("Detail Project")
    		// showMilestoneData()
    	}else{
    		Swal.fire({
		        title: 'Are you sure?',
		        text: "You have unsaved changes. Do you want to leave the page?",
		        icon: 'warning',
		        showCancelButton: true,
		        confirmButtonText: 'Yes, leave',
		        cancelButtonText: 'Cancel',
		        reverseButtons: true // Optional: to reverse the positions of buttons
		    }).then((result) => {
		        // If user clicks 'Yes'
		        if (result.isConfirmed) {
		            // Allow the user to leave
		            firstPage = true
		            // location.reload()
		    		$(".content-title").text("Detail Project")
		    		showMilestoneData()
		    		$(".milestone").attr('style','display:none!important')
		    		$(".show_project_charter").attr('style','display:none!important')
		    		$(".detail_project").show()
		        } else {
		            // Cancel the navigation (stay on the current page)
		            event.returnValue = false; // Cancel the default action
		        }
		    });
    		// location.reload()
    	}
    }

    function btnAddMilestone(status){    	
    	if (status == 'add') {
    		$("#ModalTypeMilestone").modal('show')
    		$("#selectTypeMilestone").select2({
    			placeholder:"Select Milestone Type",
    			data:[{
    				id:"Defined",
    				text:"Defined"
    			},
    			{
    				id:"Custom",
    				text:"Custom"
    			}
    			],
    			dropdownParent:$("#ModalTypeMilestone")
    		})
    	}else{
    		milestone(status)
    		$(".milestone").show()
    		$(".detail_project").attr('style','display:none!important')
    	}
    }

	function saveTypeMilestone(){
		if ($("#selectTypeMilestone").val() == "") {
			$("#selectTypeMilestone").closest("div").find("span").show()
            $("#selectTypeMilestone").closest("div").addClass("needs-validation")
		}else{
			if ($("#selectTypeMilestone").val() == 'Defined') {
				milestone('Defined')
				function updateQueryParam(param, value) {
				  var url = new URL(window.location.href);
				  var params = new URLSearchParams(url.search);

				  // Update the parameter value in the URL
				  params.set(param, value);

				  // Construct the new URL with the updated parameter
				  var newURL = url.origin + url.pathname + '?' + params.toString();

				  // Change the URL without refreshing the page using replaceState
				  window.history.replaceState(null, '', newURL);
				}

				// Usage example
				updateQueryParam('type_milestone', 'defined');
			}else{
				milestone('Custom')
				function updateQueryParam(param, value) {
				  var url = new URL(window.location.href);
				  var params = new URLSearchParams(url.search);

				  // Update the parameter value in the URL
				  params.set(param, value);

				  // Construct the new URL with the updated parameter
				  var newURL = url.origin + url.pathname + '?' + params.toString();

				  // Change the URL without refreshing the page using replaceState
				  window.history.replaceState(null, '', newURL);
				}

				// Usage example
				updateQueryParam('type_milestone', 'custom');
			}
			$(".milestone").show()
			$("#ModalTypeMilestone").modal("hide")
	    	$(".detail_project").attr('style','display:none!important')
		}
		
	}

    function btnshowMilestone(status,ganttstatus){
    	$(".milestone").show()
    	$(".detail_project").attr('style','display:none!important')

    	if (ganttstatus == "custom") {
    		function updateQueryParam(param, value) {
			  var url = new URL(window.location.href);
			  var params = new URLSearchParams(url.search);

			  // Update the parameter value in the URL
			  params.set(param, value);

			  // Construct the new URL with the updated parameter
			  var newURL = url.origin + url.pathname + '?' + params.toString();

			  // Change the URL without refreshing the page using replaceState
			  window.history.replaceState(null, '', newURL);
			}

			// Usage example
			updateQueryParam('type_milestone', 'custom');
    	}else{
    		function updateQueryParam(param, value) {
			  var url = new URL(window.location.href);
			  var params = new URLSearchParams(url.search);

			  // Update the parameter value in the URL
			  params.set(param, value);

			  // Construct the new URL with the updated parameter
			  var newURL = url.origin + url.pathname + '?' + params.toString();

			  // Change the URL without refreshing the page using replaceState
			  window.history.replaceState(null, '', newURL);
			}

			// Usage example
			updateQueryParam('type_milestone', 'defined');
    	}
    	milestone(status,ganttstatus)
    }

    function getProgressBar(){
    	$.ajax({
    		type:"GET",
            url:"{{url('/PMO/getProgressBar')}}",
            data:{
            	id_pmo:window.location.href.split("/")[5].split("?")[0]
            },success:function(result){
            	if (result.progress.lates_progress_milestone == 'Initiating') {
            		$("#progressbar").addClass('progress-bar-primary')
            		if (result.progress.is_update_current_milestone == "True") {
            			$(".fieldset_Initiating").attr("disabled",true)
            		}
            	}else if (result.progress.lates_progress_milestone == 'Planning') {
            		$("#progressbar").addClass('progress-bar-warning')
            		$(".fieldset_Initiating").attr("disabled",true)
            		if (result.progress.is_update_current_milestone == "True") {
            			$(".fieldset_Planning").attr("disabled",true)
            		}
            	}else if (result.progress.lates_progress_milestone == 'Executing') {
            		$("#progressbar").addClass('progress-bar-danger')
            		$(".fieldset_Initiating").attr("disabled",true)
            		$(".fieldset_Planning").attr("disabled",true)
            		if (result.progress.is_update_current_milestone == "True") {
            			$(".fieldset_Executing").attr("disabled",true)
            		}
            	}else if (result.progress.lates_progress_milestone == 'Closing') {
            		$("#progressbar").addClass('progress-bar-success')
            		$(".fieldset_Initiating").attr("disabled",true)
            		$(".fieldset_Planning").attr("disabled",true)
            		$(".fieldset_Executing").attr("disabled",true)
            		if (result.progress.is_update_current_milestone == "True") {
            			$(".fieldset_Closing").attr("disabled",true)
            		}
            		if (result.progress.bobot == 100) {
	            		$(".fieldset_Closing").attr("disabled",true)
            		}
            	}else{
            		$("#progressbar").addClass('progress-bar-success').css('color','#d2d6de')
            	}          	

            	$("#overall_progress").val(result.progress.bobot + '%')
            	$("#progressbar").css("width",result.progress.bobot + '%')
            	$("#progressbar").text(result.progress.bobot + '% complete')
            	
            	if (result.progress.bobot == 100) {
            		gantt.config.disabled = true;
            	}
            }
        })
    	
    }

    /////////
    function showMilestoneData(){
    	firstPage = true
    	if (window.location.search.split("?")[1] != 'showProject') {
    		window.history.pushState(null,null,location.protocol + '//' + location.host + location.pathname + "?project_type=" + window.location.href.split("?")[1].split("&")[0].split("=")[1])
    	}
    	let dateInitiating = '',datePlanning = '',dateExecuting = '',dateClosing = ''
    	$.ajax({
    		type:"GET",
            url:"{{url('/PMO/getMilestone')}}",
            data:{
            	id_pmo:window.location.href.split("/")[5].split("?")[0]
            },success:function(result){
       			$("#tbodyMilestone").empty("")
       			$("#tbodyMilestone").next("tfoot").empty("")

            	$(".content-title").text("Detail Project " + "[" + result.data.pid + "]")
            	
            	if (result.data.milestone == 'true') {  
    				if (window.location.search.split("=")[1].split("&")[0] == "supply_only") {
            			$("#btnAddMilestone").attr('style','display:none!important')
            		}else{
            			$("#btnAddMilestone").find("i").removeClass('bx-plus').addClass('bx-show')
            			if (result.data.ganttStatus == "custom") {
    						$("#btnAddMilestone").attr("onclick","btnshowMilestone('show','custom')")
            			}else{
    						$("#btnAddMilestone").attr("onclick","btnshowMilestone('show','defined')")
            			}

    					if (result.data.kickoff == 'true') {
		            		$("#btnAddMilestone").attr('style','display:none!important')
		            	}else{
		        			if (accesable.includes('btnAddMilestone')) {
		    					$("#btnAddMilestone").show()
		            		}
		            	}
            		}
            	}else{
            		if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Project Management Office Manager')->exists()}}" || "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','VP Program & Project Management')->exists()}}") {

		    			$("#btnAddMilestone").find("i").removeClass('bx-plus').addClass('bx-show')
		    			$("#btnFinalProject").find("i").removeClass('bx-plus').addClass('bx-show')
		    			if (result.data.ganttStatus == "custom") {
    						$("#btnAddMilestone").attr("onclick","btnshowMilestone('show','custom')")
            			}else{
    						$("#btnAddMilestone").attr("onclick","btnshowMilestone('show','defined')")
            			}
		    		}else{
    					$("#btnAddMilestone").attr("onclick","btnAddMilestone('add')")
		    		}
            	}

            	if (result.data.sendCss == 'false') {
            		table.rows().every(function() {
		                var rowData = this.data()
		                if (rowData.milestone == "Submit Customer Satisfaction Survey (CSS)") {
		                	$("#btnSendCSS").prop("disabled",false)
	            			  $("input[name='cbTaskDone'][value="+ rowData.id_gantt +"]").closest("div").addClass("disabled")
	            			  $("input[name='cbTaskDone'][value="+ rowData.id_gantt +"]").prop("disabled",true)
		                }
		            }); 
            	}else{
            		$("#btnSendCSS").prop("disabled",true)
            	}

            	if (result.data.finalreport == 'true') {
            		if (result.data.approveFinalReport == 'true') {
	            		$("#btnAddIssue").prop("disabled",true)
	            		$("#btnAddRisk").prop("disabled",true)
	            		$("#btnAddBaseline").prop("disabled",true)
	            		$("#btnUploadDocument").prop("disabled",true)
	            		$("#btnAddMilestone").prop("disabled",true)
		            	$("#btnAddWeekly").prop("disabled",true)
		            	$("#btnFinalProject").attr("disabled")

		            	table.rows().every(function() {
			            	if (table.data().count() == 1) {
			                	var rowData = this.data()
			                	$("input[name='cbTaskDone'][value="+ rowData.id_gantt +"]").closest("div").removeClass("disabled")
			                	$("input[name='cbTaskDone'][value="+ rowData.id_gantt +"]").prop("disabled",false)

			                }
		                })
	            	}else{
	            		table.rows().every(function() {
			            	if (table.data().count() == 1) {
			                	var rowData = this.data()
			                	$("input[name='cbTaskDone'][value="+ rowData.id_gantt +"]").closest("div").removeClass("disabled")
			                	$("input[name='cbTaskDone'][value="+ rowData.id_gantt +"]").prop("disabled",false)

			                }
		                })

	            		if (accesable.includes('btnAddIssue')) { //yg punya btnAddIssue kecuali pmo manager
		            		$("#btnFinalProject").attr("disabled")
		            	}else{
		            		$("#btnFinalProject").removeAttr("disabled")
		            		$("#btnFinalProject").attr("onclick",'btnFinalProject(0,"verify")')
		            	}
	            	}

	            	
            	}else{
            		if (accesable.includes('btnAddIssue')) { //yg punya btnAddIssue kecuali pmo manager
	            		if (result.data.approveFinalReport == 'false') {
	            			$("#btnFinalProject").attr("onclick",'btnFinalProject(0,"update")')
	            			$("#btnFinalProject").find("i").removeClass("bx bx-plus").addClass("bx bx-wrench")
	            			$("#btnFinalProject").removeAttr("disabled")
	            			table.rows().every(function() {
				                var rowData = this.data()
				                if (rowData.milestone == "Submit Final Project Closing Report") {
			                		$("input[name='cbTaskDone'][value="+ rowData.id_gantt +"]").closest("div").addClass("disabled")
				                	$("input[name='cbTaskDone'][value="+ rowData.id_gantt +"]").prop("disabled",true)
				                }

				                if (rowData.length == 1) {
			                		$("input[name='cbTaskDone'][value="+ rowData.id_gantt +"]").closest("div").addClass("disabled")
				                	$("input[name='cbTaskDone'][value="+ rowData.id_gantt +"]").prop("disabled",true)
				                }
				            });
	            		}else if (result.data.approveFinalReport == '') {
	            			// if (table.data().count() > 0) {
	            				table.rows().every(function() {
					                var rowData = this.data();					              	
					                if (table.data().count() == 1) {
					                	if (window.location.href.split("?")[1].split("&")[0].split("=")[1] == 'supply_only' ) {
			                				$("input[name='cbTaskDone'][value="+ rowData.id_gantt +"]").closest("div").removeClass("disabled")
					                		$("input[name='cbTaskDone'][value="+ rowData.id_gantt +"]").prop("disabled",false)
					                	}else{
			                				$("input[name='cbTaskDone'][value="+ rowData.id_gantt +"]").closest("div").addClass("disabled")
					                		$("input[name='cbTaskDone'][value="+ rowData.id_gantt +"]").prop("disabled",true)
					                	}

					                	if (result.data.isIssueRiskClear == "false") {
						            		$(".alertFinalProject").show()
					            			$("#btnFinalProject").attr("disabled")
						            	}else{
					            			$("#btnFinalProject").removeAttr("disabled")
				            				$("#btnFinalProject").attr("onclick",'btnFinalProject(0,"create")')
						            	}
					                }

					                // else {
									// 	if (window.location.href.split("?")[1].split("&")[0].split("=")[1] == 'supply_only' ) {
					                // 		$("input[name='cbTaskDone'][value="+ rowData.id_gantt +"]").prop("disabled",false)
					                // 	}else{
					                // 		$("input[name='cbTaskDone'][value="+ rowData.id_gantt +"]").prop("disabled",true)
					                // 	}

					                // 	if (result.data.isIssueRiskClear == "false") {
						            // 		$(".alertFinalProject").show()
					            	// 		$("#btnFinalProject").attr("disabled")
						            // 	}else{
					            	// 		$("#btnFinalProject").removeAttr("disabled")
				            		// 		$("#btnFinalProject").attr("onclick",'btnFinalProject(0,"create")')
						            // 	}
									// }
					            });


					        // }
	            		}else{
	            			$("#btnFinalProject").attr("disabled")
	            		}
	            	}else{
	            		$("#btnFinalProject").attr("disabled")
	            	}	            
            	}

            	if (result.data.isProgressReport == 'true'){
            		$("#btnAddWeekly").attr("onclick","btnAddWeekly(0,'update')")
            	}else{
            		$("#btnAddWeekly").attr("onclick","btnAddWeekly(0,'create')")
            	}
            	
            	append = ""

            	let statusInitiating = '', statusPlanning = '', statusExecuting = '', statusClosing = ''
            	$.each(result,function(idx,item){
		            append = append + '		<tr style="text-align:center">'
		            
		            let end_date = ''
		            if (item.Initiating != null) {
		            	if (item.Initiating.end_date_final == null) {
		            		end_date = 'On Going'
		            		statusInitiating = 'Ongoing'

		            	}else{
		            		end_date = moment(item.Initiating.end_date_final).format('LL')
		            		statusInitiating = 'Done'
		            	}

		            	if (item.Initiating.start_date != null) {
		            		dateInitiating = '('+ moment(item.Initiating.start_date).format('LL') + ' - ' + end_date +')'
		            	}else{
		            		dateInitiating = '-'
		            	}

		            	if (item.Initiating.last_end_date != null) {
		            		last_end_date = moment(item.Initiating.last_end_date).format('LL')
		            	}else{
		            		last_end_date = '-'
		            	}
		            	lastActivityDateInitiating = '(<small style="color:blue">'+ item.Initiating.last_sub_task +' / ' + last_end_date + '</small>)' 	
		            }else{
		            	dateInitiating = '-'
		            	lastActivityDateInitiating = '-'
		            	statusInitiating = 'Ongoing'
		            }

		            if (item.Planning != null) {
		            	if (item.Planning.end_date_final == null) {
		            		end_date = 'On Going'
		            		statusPlanning = 'Ongoing'

		            	}else{
		            		end_date = moment(item.Planning.end_date_final).format('LL')
		            		statusPlanning = 'Done'
		            	}

		            	if (item.Planning.start_date != null) {
		            		datePlanning = '('+ moment(item.Planning.start_date).format('LL') + ' - ' + end_date +')'
		            	}else{
		            		datePlanning = '-'
		            	}

		            	if (item.Planning.last_end_date != null) {
		            		last_end_date = moment(item.Planning.last_end_date).format('LL')
		            	}else{
		            		last_end_date = '-'
		            	}
		            	lastActivityDatePlanning = '(<small style="color:blue">'+ item.Planning.last_sub_task +' / ' + last_end_date + '</small>)' 	
		            }else{
		            	datePlanning = '-'
		            	statusPlanning = 'Ongoing'
		            	lastActivityDatePlanning = ' - ' 
		            }

		            if (item.Executing != null) {
		            	if (item.Executing.end_date_final == null) {
		            		end_date = 'On Going'
		            		statusExecuting = 'Ongoing'

		            	}else{
		            		end_date = moment(item.Executing.end_date_final).format('LL')
		            		statusExecuting = 'Done'

		            	}

		            	if (item.Executing.start_date != null) {
		            		dateExecuting = '('+ moment(item.Executing.start_date).format('LL') + ' - ' + end_date +')'
		            	}else{
		            		dateExecuting = '-'
		            	}

		            	if (item.Executing.last_end_date != null) {
		            		last_end_date = moment(item.Executing.last_end_date).format('LL')
		            	}else{
		            		last_end_date = '-'
		            	}

		            	lastActivityDateExecuting = '(<small style="color:blue">'+ item.Executing.last_sub_task +' / ' + last_end_date + '</small>)' 	
		            }else{
		            	dateExecuting = '-'
		            	statusExecuting = 'Ongoing'
		            	lastActivityDateExecuting = ' - ' 
		            }

		            if (item.Closing != null) {
		            	if (item.Closing.end_date_final == null) {
		            		end_date = 'On Going'
		            		statusClosing = 'Ongoing'
		            	}else{
		            		end_date = moment(item.Closing.end_date_final).format('LL')
		            		statusClosing = 'Done'

		            	}

		            	if (item.Closing.start_date != null) {
		            		dateClosing = '('+ moment(item.Closing.start_date).format('LL') + ' - ' + end_date +')'
		            	}else{
		            		dateClosing = '-'
		            	}

		            	if (item.Closing.last_end_date != null) {
		            		last_end_date = moment(item.Closing.last_end_date).format('LL')
		            	}else{
		            		last_end_date = '-'
		            	}
		            	lastActivityDateClosing = '(<small style="color:blue">'+ item.Closing.last_sub_task +' / ' + last_end_date + '</small>)' 	
		            }else{
		            	dateClosing = '-'
		            	statusClosing = 'ongoing'
		            	lastActivityDateClosing = ' - ' 
		            }
		            append = append + '            <td>'+ dateInitiating +'</td>'
		            append = append + '            <td>'+ datePlanning +'</td>'
		            append = append + '            <td>'+ dateExecuting +'</td>'
		            append = append + '            <td>'+ dateClosing +'</td>'
		            append = append + '        </tr>'
		            append = append + '        <tr style="text-align:center">'
		            append = append + '            <td> ' + lastActivityDateInitiating +' </td>'
		            append = append + '            <td> ' + lastActivityDatePlanning +' </td>'
		            append = append + '            <td> ' + lastActivityDateExecuting +'</td>'
		            append = append + '            <td> ' + lastActivityDateClosing +'</td>'
		            append = append + '      </tr>'
            	})

            	$("#tbodyMilestone").append(append)

            	$("#tbodyMilestone").after("<tfoot><th style='text-align:center'>"+ statusInitiating +"</th><th style='text-align:center'>"+ statusPlanning +"</th><th style='text-align:center'>"+ statusExecuting +"</th><th style='text-align:center'>"+ statusClosing +"</th></tfoot>")
            }
        })
    }

    function milestone(status,ganttstatus){ 	
    	firstPage = false
    	$(".content-title").text("Milestone")
    	$("#milestone-container").empty("")
    	if (status == "show") {
    		url  = "/PMO/getMilestoneById"
    		data = {
    			id_pmo:window.location.href.split("/")[5].split("?")[0],
    			type:window.location.search.split("=")[1]
    		}

    		if (ganttstatus == "custom") {
    			width = "1100px"
	    		marginRight = "margin-right: 152px;"

    		}else{
	    		width = "900px"
    			marginRight = ""
	    		
    		}
    	}else{
    		if (status == "Defined") {
    			url = "/PMO/getDefaultTask"
    			width = "900px"
    			marginRight = ""
    		}else{
    			url = "/PMO/getPhase"
	    		width = "1100px"
	    		marginRight = "margin-right: 152px;"
    		}
    		data = {
    			id_pmo:window.location.href.split("/")[5].split("?")[0],
    			type:window.location.search.split("=")[1]    			
	    	}
    		
    	}
    	
    	$.ajax({
    		url:"{{url('/')}}"+url,
    		type:"GET",
    		data:data,
    		success:function(result){
    			// function updateQueryParam(param, value) {
				//   var url = new URL(window.location.href);
				//   var params = new URLSearchParams(url.search);

				//   // Update the parameter value in the URL
				//   params.set(param, value);

				//   // Construct the new URL with the updated parameter
				//   var newURL = url.origin + url.pathname + '?' + params.toString();

				//   // Change the URL without refreshing the page using replaceState
				//   window.history.replaceState(null, '', newURL);
				// }

				// // Usage example
				// updateQueryParam('type_milestone', window.location.href.split("&")[1].split("=")[1]);
    			window.onbeforeunload = null  
    			// Listen for back navigation attempts
				window.addEventListener('popstate', function(event) {
				    // When the user tries to go back, push the same URL again
				    history.pushState(null, null, window.location.href);
				});
  			
    			// window.onbeforeunload = function(event) {
    			// 	 // Recommended
				// 	  // Included for legacy support, e.g. Chrome/Edge < 119
				// 	event.returnValue = true;

				// 	console.log(event.returnValue)

				//     if (event.returnValue) {
				//     	console.log(firstPage)
				    	
				//     }
				// };

				arrWeightSupplyOnly = ["10","20","60","10"]
    			arrWeightImplementation = ["5","15","75","5"]
    			arrWeightMaintenance = ["10","20","60","10"]

    			let type = window.location.search.split("=")[1], resultAddingWeight = ''
    			let inc = 0;
    			let isExecutingWithSolution = false

				var startDate = '' , endDate = '', bobot = ''    				
    			append = ""
    			append = append +' <div style="white-space: nowrap;overflow-x: auto;">'
    			$.each(result,function(index,value){

    				if (index == 'Executing') {
    					console.log(isNaN(parseFloat(Object.keys(value))))
    				}
    				console.log(isNaN(parseFloat(Object.keys(value))))
	    			let incIdx = 0

    				if (type == "supply_only") {
	    				resultAddingWeight = arrWeightSupplyOnly
	    			}else if (type == "maintenance") {
	    				resultAddingWeight = arrWeightMaintenance
	    			}else{
	    				resultAddingWeight = arrWeightImplementation
	    			}
    				
					// for ($i = 0; $i < 4; $i++){
					append = append +'<div style="width: 50%;width:'+ width +';display:inline-block;margin-right: 20px;vertical-align:top">'
	    				append = append + '<fieldset class="fieldset_'+ index +'">'
							append = append +' <div class="card mb-4">'
							append = append +'  <div class="card-header">'
							append = append +'   <h6 class="card-title">'+ index +'</h6>'
							append = append + '	  <div class="card-tools">'
							append = append + '	    <div class="pull-right"><label style="margin-right:10px;display:inline">Weight</label><input class="form-control" id="inputWeight" name="inputWeight" value="'+ resultAddingWeight[inc++] +'" type="text" minlength="1" maxlength="2" placeholder="75%" style="display:inline;width:60px;" disabled></div>		'
							append = append + '		</div>'
							append = append +'   </div>'
							append = append +'<div class="card-body">'
								if (index == "Executing") {
									if (status == "show") {
										if (ganttstatus == "custom") {
											append = append +'<form class="form_'+ index +'">'
											$.each(value,function(idx,values){
												if (values.start_date != null) {
							    					startDate = moment(values.start_date).format('MM/DD/YYYY')
							    				}else{
							    					startDate = ''
							    				}

							    				if (values.end_date != null) {
							    					endDate = moment(values.end_date).format('MM/DD/YYYY')
							    				}else{
							    					endDate = ''
							    				}

							    				if (values.bobot != null) {
							    					bobot = values.bobot
							    				}else{
							    					bobot = ''
							    				}

												append = append +' 	<div class="form-group form_group_'+index+'">'
													append = append +' 		<div class="row">'
													append = append +' 			<div class="col-md-4">'
													append = append +'				<input class="form-control" type="text" name="inputLabelTask" class="form-control" id="inputLabelTask" data-value="'+ idx +'" placeholder="Enter Task Name" value="'+ values.text +'">'
													append = append +' 			</div>'
													append = append +' 			<div class="col-md-2">'
													append = append +' 				<div class="input-group" style="margin-left: -15px;">'
													append = append +'					<span class="input-group-text"><i class="bx bx-calendar"></i></span>'
													append = append +'					<input style="display:inline;" type="text" name="startDateMilestone" class="form-control" id="startDateMilestone_'+ index +'" data-value="'+ idx +'" placeholder="Select Start date" value="'+ startDate +'">'
													append = append +'				</div>'
													append = append +' 			</div>'
													append = append +' 			<div class="col-md-2">'
													append = append +' 				<div class="input-group" style="margin-left: -15px;">'
													append = append +'					<span class="input-group-text"><i style="display:inline" class="bx bx-calendar"></i></span>'
													append = append +'					<input style="display:inline;font-size:12px;" placeholder="Select Finish date" type="text" name="finishDateMilestone" class="form-control" id="finishDateMilestone_'+ index +'" data-value="'+ idx +'" value="'+ endDate +'">'
													append = append +'				</div>'
													append = append +' 			</div>'
													append = append +' 			<div class="col-md-1">'
													append = append +' 				<input class="form-control" type="text" minlength="1" maxlength="4" id="weightMilestone" name="weightMilestone_'+ index +'" placeholder="weight %" style="display:inline;width:60px;float:right;font-size:12px;margin-left: -15px;" data-value="'+ idx +'" value="'+ bobot +'">'
													append = append +' 			</div>'
													append = append +'			<div class="col-md-2">'
													if (values.deliverable_document == "true") {
														append = append +'				<div class="form-group" style="margin-left: -15px;margin-top: 5px;">'
														append = append +'					<label><input data-value="'+ idx +'" id="cbDocMilestone_'+index+'" name="cbDocMilestone" style="height: 15px;width: 15px;" type="checkbox" checked> Deliverable Doc.<br></label>'
														append = append +'				</div>'
													}else{
														append = append +'				<div class="form-group" style="margin-left: -15px;margin-top: 5px;">'
														append = append +'					<label><input data-value="'+ idx +'" id="cbDocMilestone_'+index+'" name="cbDocMilestone" style="height: 15px;width: 15px;" type="checkbox"> Deliverable Doc.<br></label>'
														append = append +'				</div>'
													}
													append = append +' 			</div>'
														append = append + '		<div class="col-sm-1">				'
														if (idx != 0) {
															append = append + '			<button class="btn btn-sm btn-danger" type="button" onclick="btnDeleteTaskCustom(this)"><i class="bx bx-trash"></i></button>'
														}
														append = append + '		</div>'
													append = append + '</div>'
													append = append +	'<span class="invalid-feedback" style="display:none!important;color:red"></span>'
												append = append +' 	</div>'
											})
											append = append + '<div  style="display:flex;justify-content:center">'
											append = append +'	<button type="button" class="btn btn-sm btn-primary" id="btnAddTask_'+index+'"><i class="bx bx-plus"></i>&nbspTask</button>' 
											append = append + '</div>'

											append = append +'</form>'
										}else{
											if (window.location.search.split("=")[1].split("&")[0] == "implementation") {
												if (isNaN(parseFloat(Object.keys(value)))) {
													$.each(value,function(idx,values){
														incIdx++								

														append = append +'<form class="form_'+ index +'">'
														isExecutingWithSolution = true
														append = append + "<div class='form-group'>"
														append = append + "	<label>Solution Name</label>"
														append = append + "	<input class='form-control' placeholder='Fill solution name' id='inputSolutionMilestone' name='inputSolutionMilestone' value='"+ idx +"'>"
														append = append + "	<span style='display:none!important;color:red' class='invalid-feedback'></span>"
														append = append + "</div>"	
														$.each(values,function(idx,valuesExecuting){
															var startDateExecuting = '', endDateExecuting = ''

															if (valuesExecuting.start_date != null) {
										    					startDateExecuting = moment(valuesExecuting.start_date).format('MM/DD/YYYY')
										    				}else{
										    					startDateExecuting = ''
										    				}

										    				if (valuesExecuting.end_date != null) {
										    					endDateExecuting = moment(valuesExecuting.end_date).format('MM/DD/YYYY')
										    				}else{
										    					endDateExecuting = ''
										    				}	

										    				if (valuesExecuting.bobot != null) {
										    					bobot = valuesExecuting.bobot
										    				}else{
										    					bobot = ''
										    				}

															append = append +' 	<div class="form-group">'
																append = append +' 	<label>'+ valuesExecuting.text +'</label>'
																append = append +' 	<div class="row">'
																	append = append +' 			<div class="col-md-5">'
																	append = append +' 				<div class="input-group">'

																	append = append +'					<span class="input-group-text"><i class="bx bx-calendar"></i></span>'
																	append = append +'					<input style="display:inline" type="text" name="startDateMilestone" class="form-control" id="startDateMilestone_'+ index +'" value="'+ startDateExecuting +'" data-value="'+ incIdx +'" placeholder="Select Start Date">'
																	append = append +'				</div>'
																	append = append +' 			</div>'
																	append = append +' 			<div class="col-md-5" style="margin-left: -10px !important;">'
																	// append = append +' 				<div class="input-group">'

																	// append = append +'					<span class="input-group-text"><i style="display:inline" class="bx bx-clock-o"></i></span>'
																	// append = append +'					<input value="1" style="display:inline;font-size:12px;width:80px" placeholder="duration" type="text" name="durationMilestone" class="form-control" id="durationMilestone" data-value="'+ valuesExecuting[0].index +'">'
																	// append = append +'				</div>'
																	append = append +' 				<div class="input-group">'
																	append = append +'					<span class="input-group-text"><i style="display:inline" class="bx bx-calendar"></i></span>'
																	append = append +'					<input style="display:inline;font-size:12px;" placeholder="Select Finish Date" type="text" name="finishDateMilestone" class="form-control" id="finishDateMilestone_'+ index +'" value="'+ endDateExecuting +'" data-value="'+ incIdx +'">'
																	append = append +'				</div>'
																	append = append +' 			</div>'
																	append = append +' 			<div class="col-md-1" style="padding-right:0px">'
																	append = append +' 				<input value="'+ bobot +'" class="form-control click" type="text" minlength="1" maxlength="4" name="weightMilestone_'+ index +'" id="weightMilestone" placeholder="weight %" style="display:inline;width:75px;float:right;font-size:12px" data-value="'+ incIdx +'"><input type="text" name="deliverable_document" class="form-control" id="deliverable_document" data-value="'+ incIdx +'" value="' + valuesExecuting.deliverable_document +'" style="display:none!important">'
																	append = append +' 			</div>'
																	append = append + '			<div class="col-md-1">				'

																		append = append + '<button class="btn btn-sm btn-danger" type="button" onclick="btnDeleteTaskCustom(this)"><i class="bx bx-trash"></i></button>'
																	append = append + '			</div>'
																append = append +' 	</div>'
																append = append +' <span class="invalid-feedback" style="display:none!important;color:red"></span>'
															append = append +' 	</div>'
														})

														append = append +'</form>'
													})
												}else{
													append = append +'<form class="form_'+ index +'">'
													$.each(value,function(idx,values){
														var startDateExecuting = '', endDateExecuting = ''
														incIdx++
														if (values.start_date != null) {
									    					startDateExecuting = moment(values.start_date).format('MM/DD/YYYY')
									    				}

									    				if (values.end_date != null) {
									    					endDateExecuting = moment(values.end_date).format('MM/DD/YYYY')
									    				}	

									    				if (values.bobot != null) {
									    					bobot = values.bobot
									    				}else{
									    					bobot = ''
									    				}

														append = append +' 	<div class="form-group">'
															append = append +' 		<label>'+ values.text +'</label>'
															append = append +' 		<div class="row">'
																append = append +' 			<div class="col-md-5">'
																append = append +' 				<div class="input-group">'

																append = append +'					<span class="input-group-text"><i class="bx bx-calendar"></i></span>'
																append = append +'					<input style="display:inline" type="text" name="startDateMilestone" class="form-control" id="startDateMilestone_'+ index +'" value="'+ startDateExecuting +'" data-value="'+ incIdx +'" placeholder="Select Start Date">'
																append = append +'				</div>'
																append = append +' 			</div>'
																append = append +' 			<div class="col-md-5" style="margin-left: -10px !important;">'
																// append = append +' 				<div class="input-group">'

																// append = append +'					<span class="input-group-text"><i style="display:inline" class="bx bx-clock-o"></i></span>'
																// append = append +'					<input value="1" style="display:inline;font-size:12px;width:80px" placeholder="duration" type="text" name="durationMilestone" class="form-control" id="durationMilestone" data-value="'+ values[0].index +'">'
																// append = append +'				</div>'
																append = append +' 				<div class="input-group">'
																append = append +'					<span class="input-group-text"><i style="display:inline" class="bx bx-calendar"></i></span>'
																append = append +'					<input style="display:inline;font-size:12px;" placeholder="Select Finish Date" type="text" name="finishDateMilestone" class="form-control" id="finishDateMilestone_'+ index +'" value="'+ endDateExecuting +'" data-value="'+ incIdx +'">'
																append = append +'				</div>'
																append = append +' 			</div>'
																append = append +' 			<div class="col-md-1" style="padding-right:0px">'
																append = append +' 				<input value="'+ bobot +'" class="form-control click" type="text" minlength="1" maxlength="4" name="weightMilestone_'+ index +'" id="weightMilestone" placeholder="weight %" style="display:inline;width:60px;float:right;font-size:12px" data-value="'+ incIdx +'"><input type="text" name="deliverable_document" class="form-control" id="deliverable_document" value="' + values.deliverable_document +'" style="display:none!important" data-value="'+ incIdx +'">'
																append = append +' 			</div>'
																append = append + '<div class="col-md-1">				'
																	if (incIdx != 0) {

																	append = append + '<button class="btn btn-sm btn-danger" type="button" onclick="btnDeleteTaskDefined(this)"><i class="bx bx-trash"></i></button>'
																	}
																append = append + '</div>'												
															append = append +' 	</div>'
														append = append +'		<span class="invalid-feedback" style="display:none!important;color:red"></span>'
														append = append +' </div>'
													})
													append = append +'</form>'
												}
											}else{
												append = append +'<form class="form_'+ index +'">'
												$.each(value,function(idx,values){
													incIdx++
													var startDateExecuting = '', endDateExecuting = ''

													if (values.start_date != null) {
								    					startDateExecuting = moment(values.start_date).format('MM/DD/YYYY')
								    				}else{
								    					startDateExecuting = ''
								    				}

								    				if (values.end_date != null) {
								    					endDateExecuting = moment(values.end_date).format('MM/DD/YYYY')
								    				}else{
								    					endDateExecuting = ''
								    				}

													append = append + "<div class='form-group'>"

													append = append +' 		<label>'+ values.text +'</label>'
													append = append +' 		<div class="row">'
														append = append +' 			<div class="col-md-5">'
														append = append +' 				<div class="input-group">'

														append = append +'					<span class="input-group-text"><i class="bx bx-calendar"></i></span>'
														append = append +'					<input style="display:inline" type="text" name="startDateMilestone" class="form-control" id="startDateMilestone_'+ index +'" value="' + startDateExecuting +'" data-value="'+ incIdx +'" placeholder="Select Start Date">'
														append = append +'				</div>'
														append = append +' 			</div>'
														append = append +' 			<div class="col-md-5" style="margin-left:-10px">'
														// append = append +' 				<div class="input-group">'

														// append = append +'					<span class="input-group-text"><i style="display:inline" class="bx bx-clock-o"></i></span>'
														// append = append +'					<input value="1" style="display:inline;font-size:12px;width:80px" placeholder="duration" type="text" name="durationMilestone" class="form-control" id="durationMilestone" data-value="'+ values[0].index +'">'
														// append = append +'				</div>'
														append = append +' 				<div class="input-group">'
														append = append +'					<span class="input-group-text"><i style="display:inline" class="bx bx-calendar"></i></span>'
														append = append +'					<input style="display:inline;font-size:12px;" placeholder="Select Finish Date" type="text" name="finishDateMilestone" class="form-control" id="finishDateMilestone_'+ index +'" value="' + endDateExecuting +'" data-value="'+ incIdx +'">'
														append = append +'				</div>'
														append = append +' 			</div>'
														append = append +' 			<div class="col-md-1" style="padding-right:0px">'
														append = append +' 				<input value="'+ values.bobot +'" class="form-control click" type="text" minlength="1" maxlength="4" name="weightMilestone_'+ index +'" id="weightMilestone" placeholder="weight %" style="display:inline;width:60px;float:right;font-size:12px" data-value="'+ incIdx +'"><input type="text" name="deliverable_document" class="form-control" id="deliverable_document" value="' + values.deliverable_document +'" style="display:none!important" data-value="'+ incIdx +'">'
														append = append +' 			</div>'
														append = append + '<div class="col-md-1">				'

															append = append + '<button class="btn btn-sm btn-danger" type="button" onclick="btnDeleteTaskDefined(this)"><i class="bx bx-trash"></i></button>'
														append = append +' </div>'	
													append = append +' 	</div>'
													append = append +'		<span class="invalid-feedback" style="display:none!important;color:red"></span>'					
													append = append +' 	</div>'
												})
												append = append +'</form>'
											}
										}
									}else if (status == "Defined") {
										append = append +'<form class="form_'+ index +'">'
											$.each(value,function(idx,values){
											append = append +' 	<div class="form-group">'
												append = append +' 		<label>'+ values.sub_task +'</label>'

												append = append +' 		<div class="row">'
													append = append +' 			<div class="col-md-5">'
													append = append +' 				<div class="input-group">'

													append = append +'					<span class="input-group-text"><i class="bx bx-calendar"></i></span>'
													append = append +'					<input style="display:inline" type="text" name="startDateMilestone" class="form-control" id="startDateMilestone_'+ index +'" data-value="'+idx+'" placeholder="Select start date" value="">'
													append = append +'				</div>'
													append = append +' 			</div>'
													append = append +' 			<div class="col-md-5" style="margin-left: -10px !important;">'
													// append = append +' 				<div class="input-group">'

													// append = append +'					<span class="input-group-text"><i style="display:inline" class="bx bx-clock-o"></i></span>'
													// append = append +'					<input value="1" style="display:inline;font-size:12px;width:80px" placeholder="duration" type="text" name="finishDateMilestone" class="form-control" id="finishDateMilestone" data-value="'+idx+'">'
													// append = append +'				</div>'
													append = append +' 				<div class="input-group">'
													append = append +'					<span class="input-group-text"><i style="display:inline" class="bx bx-calendar"></i></span>'
													append = append +'					<input style="display:inline;font-size:12px;" placeholder="Select finish date" type="text" name="finishDateMilestone" class="form-control" id="finishDateMilestone_'+ index +'" data-value="'+idx+'" value="">'
													append = append +'				</div>'
													append = append +' 			</div>'
													append = append +' 			<div class="col-md-1" style="padding-right:0px">'
													append = append +' 				<input value="'+ values.bobot +'" class="form-control click" type="text" minlength="1" maxlength="4" name="weightMilestone_'+ index +'" id="weightMilestone" placeholder="weight %" style="display:inline;width:60px;float:right;font-size:12px" data-value="'+idx+'"><input type="text" name="deliverable_document" class="form-control" id="deliverable_document" value="' + values.deliverable_document +'" style="display:none!important" data-value="'+ incIdx +'">'
													append = append +' 			</div>'
													append = append + '<div class="col-md-1">				'

														append = append + '<button class="btn btn-sm btn-danger" type="button" onclick="btnDeleteTaskDefined(this)"><i class="bx bx-trash"></i></button>'
													append = append +'</div>'
												append = append +' 	</div>'
												append = append +'		<span class="invalid-feedback" style="display:none!important;color:red"></span>'
											append = append +' 	</div>'
											})
										append = append +'</form>'
									}else{
										append = append +'<form class="form_'+ index +'">'
										append = append +' 	<div class="form-group form_group_'+index+'">'
											append = append +' 		<div class="row">'
												append = append +' 			<div class="col-md-4">'
												append = append +'				<input class="form-control" type="text" name="inputLabelTask" class="form-control" id="inputLabelTask" data-value="0" placeholder="Enter Task Name" value="">'
												append = append +' 			</div>'
												append = append +' 			<div class="col-md-2">'
												append = append +' 				<div class="input-group" style="margin-left: -15px;">'

												append = append +'					<span class="input-group-text"><i class="bx bx-calendar"></i></span>'
												append = append +'					<input style="display:inline;" type="text" name="startDateMilestone" class="form-control" id="startDateMilestone_'+ index +'" data-value="0" placeholder="Start date" value="">'
												append = append +'				</div>'
												append = append +' 			</div>'
												append = append +' 			<div class="col-md-2">'
												append = append +' 				<div class="input-group" style="margin-left: -15px;">'

												append = append +'					<span class="input-group-text"><i style="display:inline" class="bx bx-calendar"></i></span>'
												append = append +'					<input style="display:inline;font-size:12px;" placeholder="Finish date" type="text" name="finishDateMilestone" class="form-control" id="finishDateMilestone_'+ index +'" data-value="0" value="">'
												append = append +'				</div>'
												append = append +' 			</div>'
												append = append +' 			<div class="col-md-1">'
												append = append +' 				<input class="form-control" type="text" minlength="1" maxlength="4" id="weightMilestone" name="weightMilestone_'+ index +'" placeholder="weight %" style="display:inline;width:60px;float:right;font-size:12px;margin-left: -15px;" data-value="0"><input type="text" name="deliverable_document" class="form-control" id="deliverable_document" style="display:none!important">'
												append = append +' 			</div>'
												append = append +'			<div class="col-md-2">'
												append = append +'				<div class="form-group" style="margin-left: -15px;margin-top: 5px;">'
												append = append +'					<label><input id="cbDocMilestone_'+index+'" name="cbDocMilestone" style="height: 15px;width: 15px;" type="checkbox"> Deliverable Doc.<br></label>'
												append = append +'				</div>'
												append = append +' 			</div>'
												append = append + '<div class="col-sm-1">				'

													append = append + '<button class="btn btn-sm btn-danger" type="button" onclick="btnDeleteTaskDefined(this)" disabled><i class="bx bx-trash"></i></button>'
												append = append +' </div>'
											append = append +' 	</div>'
											append = append +'		<span class="invalid-feedback" style="display:none!important;color:red"></span>'
										append = append + '</div>' 
										append = append + '<div  style="display:flex;justify-content:center">'

											append = append +'	<button type="button" class="btn btn-sm btn-primary" id="btnAddTask_'+index+'"><i class="bx bx-plus"></i>&nbspTask</button>' 
										append = append + '</div>'
										append = append +'</form>'
									}
								}else{
									if (status == "show") {
										if (ganttstatus == "custom") {
											append = append +'<form class="form_'+ index +'">'
											$.each(value,function(idx,values){
												incIdx++

												if (values.start_date != null) {
							    					startDate = moment(values.start_date).format('MM/DD/YYYY')
							    				}else{
							    					startDate = ''
							    				}

							    				if (values.end_date != null) {
							    					endDate = moment(values.end_date).format('MM/DD/YYYY')
							    				}else{
							    					endDate = ''
							    				}

							    				if (values.bobot != null) {
							    					bobot = values.bobot
							    				}else{
							    					bobot = ''
							    				}

												append = append +' 	<div class="form-group form_group_'+index+'">'
													append = append +' 		<div class="row">'
													append = append +' 			<div class="col-md-4">'
													append = append +'				<input class="form-control" type="text" name="inputLabelTask" class="form-control" id="inputLabelTask" data-value="'+ idx +'" placeholder="Enter Task Name" value="'+ values.text +'">'
													append = append +' 			</div>'
													append = append +' 			<div class="col-md-2">'
													append = append +' 				<div class="input-group" style="margin-left: -15px;">'

													append = append +'					<span class="input-group-text"><i class="bx bx-calendar"></i></span>'
													append = append +'					<input style="display:inline;" type="text" name="startDateMilestone" class="form-control" id="startDateMilestone_'+ index +'" data-value="'+ idx +'" placeholder="Select Start date" value="' + startDate +'">'
													append = append +'				</div>'
													append = append +' 			</div>'
													append = append +' 			<div class="col-md-2">'
													append = append +' 				<div class="input-group" style="margin-left: -15px;">'

													append = append +'					<span class="input-group-text"><i style="display:inline" class="bx bx-calendar"></i></span>'
													append = append +'					<input style="display:inline;font-size:12px;" placeholder="Select Finish date" type="text" name="finishDateMilestone" class="form-control" id="finishDateMilestone_'+ index +'" value="' + endDate +'">'
													append = append +'				</div>'
													append = append +' 			</div>'
													append = append +' 			<div class="col-md-1">'
													append = append +' 				<input class="form-control" type="text" minlength="1" maxlength="4" id="weightMilestone" name="weightMilestone_'+ index +'" placeholder="weight %" style="display:inline;width:60px;float:right;font-size:12px;margin-left: -15px;" data-value="'+ idx +'" value="'+ bobot +'">'
													append = append +' 			</div>'
													append = append +'			<div class="col-md-2">'
													if (values.deliverable_document == "true") {
														append = append +'				<div class="form-group" style="margin-left: -15px;margin-top: 5px;">'
														append = append +'					<label><input data-value="'+ idx +'" id="cbDocMilestone_'+index+'" name="cbDocMilestone" style="height: 15px;width: 15px;" type="checkbox" checked data-value="'+ incIdx +'"> Deliverable Doc.<br></label>'
														append = append +'				</div>'
													}else{
														append = append +'				<div class="form-group" style="margin-left: -15px;margin-top: 5px;">'
														append = append +'					<label><input data-value="'+ idx +'" id="cbDocMilestone_'+index+'" name="cbDocMilestone" style="height: 15px;width: 15px;" type="checkbox" data-value="'+ idx +'"> Deliverable Doc.<br></label>'
														append = append +'				</div>'
													}
													append = append +' 			</div>'
														append = append + '		<div class="col-sm-1">				'
														if (idx != 0) {

															append = append + '			<button class="btn btn-sm btn-danger" type="button" onclick="btnDeleteTaskCustom(this)"><i class="bx bx-trash"></i></button>'
														}
														append = append + '		</div>'
													append = append + '</div>'
													append = append +'		<span class="invalid-feedback" style="display:none!important;color:red"></span>'
												append = append +' 	</div>'
											})
											append = append + '<div  style="display:flex;justify-content:center">'

											append = append +'	<button type="button" class="btn btn-sm btn-primary" id="btnAddTask_'+index+'"><i class="bx bx-plus"></i>&nbspTask</button>' 
											append = append + '</div>'

											append = append +'</form>'
										}else{
											append = append +'<form class="form_'+ index +'">'
												$.each(value,function(idx,values){
													incIdx++					
													if (values.start_date != null) {
								    					startDate = moment(values.start_date).format('MM/DD/YYYY')
								    				}else{
								    					startDate = ''
								    				}

								    				if (values.end_date != null) {
								    					endDate = moment(values.end_date).format('MM/DD/YYYY')
								    				}else{
								    					endDate = ''
								    				}

								    				if (values.bobot != null) {
								    					bobot = values.bobot
								    				}else{
								    					bobot = ''
								    				}

													append = append +' 	<div class="form-group">'
														append = append +' 		<label>'+ values.text +'</label>'
														append = append +' 		<div class="row">'
														append = append +' 			<div class="col-md-5">'
														append = append +' 				<div class="input-group">'

														append = append +'					<span class="input-group-text"><i class="bx bx-calendar"></i></span>'
														append = append +'					<input style="display:inline" type="text" name="startDateMilestone" class="form-control" id="startDateMilestone_'+ index +'" value="'+ startDate +'" data-value="'+ incIdx +'" placeholder="Select Start Date">'
														append = append +'				</div>'
														append = append +' 			</div>'
														append = append +' 			<div class="col-md-5" style="margin-left: -10px !important;">'
														// append = append +' 				<div class="input-group">'

														// append = append +'					<span class="input-group-text"><i style="display:inline" class="bx bx-clock-o"></i></span>'
														// append = append +'					<input value="1" style="display:inline;font-size:12px;width:80px" placeholder="duration" type="text" name="durationMilestone" class="form-control" id="durationMilestone" data-value="'+ values[0].index +'">'
														// append = append +'				</div>'
														append = append +' 				<div class="input-group">'
														append = append +'					<span class="input-group-text"><i style="display:inline" class="bx bx-calendar"></i></span>'
														append = append +'					<input style="display:inline;font-size:12px;" placeholder="Select Finish Date" type="text" name="finishDateMilestone" class="form-control" id="finishDateMilestone_'+ index +'" value="' + endDate +'" data-value="'+ incIdx +'">'
														append = append +'				</div>'
														append = append +' 			</div>'
														append = append +' 			<div class="col-md-1" style="padding-right:0px">'
														append = append +' 				<input value="'+ bobot +'" class="form-control click" type="text" minlength="1" maxlength="4" name="weightMilestone_'+ index +'" id="weightMilestone" placeholder="weight %" style="display:inline;width:60px;float:right;font-size:12px" data-value="'+ incIdx +'"><input type="text" name="deliverable_document" class="form-control" id="deliverable_document" value="' + values.deliverable_document +'" style="display:none!important" data-value="'+ incIdx +'">'
														append = append +' 			</div>'
														append = append + '<div class="col-md-1">				'

															append = append + '<button class="btn btn-sm btn-danger" type="button" onclick="btnDeleteTaskCustom(this)"><i class="bx bx-trash"></i></button>'
														append = append + '	</div>'
														append = append +' 		</div>'
														append = append +'		<span class="invalid-feedback" style="display:none!important;color:red"></span>'					
													append = append +' 	</div>'
												})
											append = append +'</form>'
										}
									}else if (status == "Defined") {
										append = append +'<form class="form_'+ index +'">'
											$.each(value,function(idx,values){
												append = append +' 	<div class="form-group">'
													append = append +' 		<label>'+ values.sub_task +'</label>'
													append = append +' 		<div class="row">'
														append = append +' 			<div class="col-md-5">'
														append = append +' 				<div class="input-group">'

														append = append +'					<span class="input-group-text"><i class="bx bx-calendar"></i></span>'
														append = append +'					<input style="display:inline" type="text" name="startDateMilestone" class="form-control" id="startDateMilestone_'+ index +'" data-value="'+idx+'" placeholder="Select start date" value="">'
														append = append +'				</div>'
														append = append +' 			</div>'
														append = append +' 			<div class="col-md-5" style="margin-left: -10px !important;">'
														// append = append +' 				<div class="input-group">'

														// append = append +'					<span class="input-group-text"><i style="display:inline" class="bx bx-clock-o"></i></span>'
														// append = append +'					<input value="1" style="display:inline;font-size:12px;width:80px" placeholder="duration" type="text" name="finishDateMilestone" class="form-control" id="finishDateMilestone" data-value="'+idx+'">'
														// append = append +'				</div>'
														append = append +' 				<div class="input-group">'
														append = append +'					<span class="input-group-text"><i style="display:inline" class="bx bx-calendar"></i></span>'

														append = append +'					<input style="display:inline;font-size:12px;" placeholder="Select finish date" type="text" name="finishDateMilestone" class="form-control" id="finishDateMilestone_'+ index +'" data-value="'+idx+'" value="">'
														append = append +'				</div>'
														append = append +' 			</div>'
														append = append +' 			<div class="col-md-1" style="padding-right:0px">'
														append = append +' 				<input value="'+ values.bobot +'" class="form-control click" type="text" minlength="1" maxlength="4" name="weightMilestone_'+ index +'" id="weightMilestone" placeholder="weight %" style="display:inline;width:60px;float:right;font-size:12px" data-value="'+idx+'"><input type="text" name="deliverable_document" class="form-control" id="deliverable_document" value="' + values.deliverable_document +'" style="display:none!important" data-value="'+ idx +'">'
														append = append +' 			</div>'
														append = append + '<div class="col-md-1">				'

															append = append + '<button class="btn btn-sm btn-danger" type="button" onclick="btnDeleteTaskDefined(this)"><i class="bx bx-trash"></i></button>'

														append = append +' </div>'
													append = append +' 	</div>'
													append = append +'		<span class="invalid-feedback" style="display:none!important;color:red"></span>'
												append = append +' 	</div>'
											})
										append = append +'</form>'
									}else{
										append = append +'<form class="form_'+ index +'">'
										append = append +' 	<div class="form-group form_group_'+index+'">'
											append = append +' 	<div class="row">'
												append = append +' 			<div class="col-md-4">'
												append = append +'				<input class="form-control" type="text" name="inputLabelTask" class="form-control" id="inputLabelTask" data-value="" placeholder="Enter Task Name" value="">'
												append = append +' 			</div>'
												append = append +' 			<div class="col-md-2">'
												append = append +' 				<div class="input-group" style="margin-left: -15px;">'

												append = append +'					<span class="input-group-text"><i class="bx bx-calendar"></i></span>'

												append = append +'					<input style="display:inline;" type="text" name="startDateMilestone" class="form-control" id="startDateMilestone_'+ index +'" data-value="0" placeholder="Start date" value="">'
												append = append +'				</div>'
												append = append +' 			</div>'
												append = append +' 			<div class="col-md-2">'
												append = append +' 				<div class="input-group" style="margin-left: -15px;">'

												append = append +'					<span class="input-group-text"><i style="display:inline" class="bx bx-calendar"></i></span>'

												append = append +'					<input style="display:inline;font-size:12px;" placeholder="Finish date" type="text" name="finishDateMilestone" class="form-control" id="finishDateMilestone_'+ index +'" data-value="0" value="">'
												append = append +'				</div>'
												append = append +' 			</div>'
												append = append +' 			<div class="col-md-1">'
												append = append +' 				<input class="form-control" type="text" minlength="1" maxlength="4" id="weightMilestone" name="weightMilestone_'+index+'" placeholder="weight %" style="display:inline;width:60px;float:right;font-size:12px;margin-left: -15px;" data-value="">'
												append = append +' 			</div>'
												append = append +'			<div class="col-md-2">'
												append = append +'				<div class="form-group" style="margin-left: -15px;margin-top: 5px;">'
												append = append +'					<label><input id="cbDocMilestone_'+index+'" name="cbDocMilestone" type="checkbox" class="" style="height: 15px;width: 15px;"> Deliverable Doc.<br></label>'
												append = append +'				</div>'
												append = append +' 			</div>'
												append = append + '<div class="col-sm-1">'

													append = append + '<button class="btn btn-sm btn-danger" type="button" onclick="btnDeleteTaskDefined(this)" disabled><i class="bx bx-trash"></i></button>'

												append = append +'</div>'
											append = append +' 	</div>'
											append = append +'		<span class="invalid-feedback" style="display:none!important;color:red"></span>'
										append = append +' 	</div>'
										append = append + '<div  style="display:flex;justify-content:center">'

										append = append +'	<button type="button" class="btn btn-sm btn-primary" id="btnAddTask_'+index+'" name="btnAddTask"><i class="bx bx-plus"></i>&nbspTask</button>'

										append = append + '</div>'
										append = append +'</form>'
									}
								}	
							append = append +'	<div style="margin-top:20px">'
							//buat button save hanya di closing
							// if (index == "Closing") {
							append = append + '<button class="btn btn-sm btn-primary pull-right saveMilestone" style="display:none!important" id="saveMilestone">Save</button>'
							// }
							if (index == "Executing") {
								// if (status == "Defined") {
									if (window.location.search.split("=")[1].split("&")[0] != "supply_only") {
										append = append +'		<div style="display:flex;justify-content:center">'
										let text = ''
										if (window.location.search.split("=")[1].split("&")[0] == 'implementation') {
											text = 'Solution'
										}else{
											text = 'PM'
										}

										if (isExecutingWithSolution == true) {

											append = append +'			<button style="" class="btn btn-sm btn-primary" id="btnAddSolution" name="btnAddSolution"><i class="bx bx-plus"></i> '+ text + ' </button><button style="margin-left:5px" id="removeCloneExecuting" value="'+ text +'" class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>'
											append = append +'		</div>'
										}else{
											append = append +'			<button style="" class="btn btn-sm btn-primary" id="btnAddSolution" name="btnAddSolution"><i class="bx bx-plus"></i> '+ text + ' </button>'

											append = append +'		</div>'
										}
									}
								// }
														
							}
							append = append +'	</div>'
							append = append +'   		</div>'
							append = append +'   	</div>'
						append = append + '</fieldset>'					
					append = append +'	</div>'

						// }
	    			})

					append = append +'</div>'


    			$("#milestone-container").append(append)

    			$("input[name='startDateMilestone'],input[name='finishDateMilestone']").flatpickr({
					autoclose: true,
					orientation: "bottom",
					allowInput:true,
					dateFormat: "Y-m-d",
					onClose: function(selectedDates, dateStr, instance) {
		        // Check if dateStr is in valid format (Y-m-d)
		        const isValid = /^\d{4}-\d{2}-\d{2}$/.test(dateStr);
		        
		        if (!isValid) {
		            instance.clear(); // Clear the input
		        }
			    }
				});

    			$.each(result,function(index,value){
    				let incIdx = 0
    				$.each(value,function(idx,values){
    					incIdx++
						if (status == "show") {
							idx = incIdx
						}else{
							idx = idx
						}

    					validationDate(idx)
	    			})
					
					var incStartMil = 0
					var incFinishMil = 0

					$("#btnAddTask_"+index).click(function(e){
						var appendCloneForm = $(".form_"+e.target.id.split("_")[1]).find('.form_group_'+index).last().clone()
						appendCloneForm.find(":input").val('').end()
						appendCloneForm.find(':input[name="startDateMilestone"]').attr('data-value', function(i, val) {
				            return incStartMil+=$(".form_"+e.target.id.split("_")[1]).find('.form_group_'+index).siblings().length
 				        });

 				        appendCloneForm.find(':input[name="finishDateMilestone"]').attr('data-value', function(i, val) {
				            return incFinishMil+=$(".form_"+e.target.id.split("_")[1]).find('.form_group_'+index).siblings().length
 				        });

 				        appendCloneForm.find(":button").prop("disabled",false).end()

						$(".form_"+e.target.id.split("_")[1]).find('.form_group_'+index).last().after(appendCloneForm)

						if (window.location.href.split("/")[5].split('?')[1].split('=')[2] == undefined) {
							if ($("#btnDeleteTask_"+index).length === 0) {

								$("#btnAddTask_"+index).after("<button type='button' class='btn btn-sm btn-danger bx bx-trash' style='margin-left:5px;width:35px' id='btnDeleteTask_"+ index +"'></button>")
							}
						}

						$("#btnDeleteTask_"+index).click(function(){
							$(".form_"+e.target.id.split("_")[1]).find('.form_group_'+index).last().remove()

							if ($(".form_"+e.target.id.split("_")[1]).find('.form_group_'+index).length == 1) {
								$("#btnDeleteTask_"+index).remove()
							}
						})

						$("input[name='startDateMilestone'],input[name='finishDateMilestone']").flatpickr({
							autoclose: true,
							orientation: "bottom",
							allowInput:true,
							dateFormat: "Y-m-d",
							onClose: function(selectedDates, dateStr, instance) {
				        // Check if dateStr is in valid format (Y-m-d)
				        const isValid = /^\d{4}-\d{2}-\d{2}$/.test(dateStr);
				        
				        if (!isValid) {
				            instance.clear(); // Clear the input
				        }
					    } 
						});

						validationDate(incStartMil)
					})
    			})

    			if (accesable.includes('saveMilestone')) {
    				getProgressBar()
    				$(".saveMilestone").show()
    			}

    			if (!accesable.includes("saveMilestone")) {
		    		$("fieldset").attr("disabled",true)
		    	} 

    			let count = 0, incLabel = 1
				$("#btnAddSolution").click(function(){
					$("#removeCloneExecuting").remove()
			        count++;
					++incLabel;
					if ($(this)[0].innerText.replace(" ","") == 'PM') {
						$("input[name='weightMilestone_Executing']:last").closest("div").closest(".row").next("span").attr('style','display:none!important')
						let countLastCloneStart = parseInt($('.form_Executing:last').find(".form-group:last").find("#startDateMilestone_Executing").attr("data-value"))
						let countLastCloneEnd = parseInt($('.form_Executing:last').find(".form-group:last").find("#finishDateMilestone_Executing").attr("data-value"))
						let countLastWeight = parseInt($('.form_Executing:last').find(".form-group:last").find("#weightMilestone").attr("data-value"))
						let countLastDeliverable = parseInt($('.form_Executing:last').find(".form-group:last").find("#deliverable_document").attr("data-value")) 

						var append = ''

						// kode kalau 3 terbawah tidak dihapus
						// $(".form_Executing:last").find(".form-group:nth-last-child(-n+3)").each(function(idx,item){
						// 	$(item).find("label").each(function(idx,label){
						// 		// label.innerHTML.replace(count-1,count)
						// 		append = append + '<div class="form-group">'
						// 			append = append + '<label>'+ label.innerHTML.replace(label.innerHTML.split("-")[1].replace(" ",""),parseInt(label.innerHTML.split("-")[1].replace(" ",""))+1) +'</label>'
						// 			append = append + '<div class="row"> 			'
						// 					append = append + '<div class="col-md-5"> 				'
						// 						append = append + '<div class="input-group">					'

						// 							append = append + '<span class="input-group-text"><i class="bx bx-calendar"></i></span>		'			

						// 								append = append + '<input style="display:inline" type="text" name="startDateMilestone" class="form-control" id="startDateMilestone_Executing" data-value="'+ ++countLastCloneStart +'" placeholder="Select start date" value="">'
						// 						append = append + '</div> 			'
						// 					append = append + '</div> 			'
						// 					append = append + '<div class="col-md-5" style="margin-left: -10px;"> 				'
						// 						append = append + '<div class="input-group">					'

						// 							append = append + '<span class="input-group-text"><i style="display:inline" class="bx bx-calendar"></i></span>	'				

						// 								append = append + '<input value="" style="display:inline;font-size:12px;" placeholder="Select finish date" type="text" name="finishDateMilestone" class="form-control" id="finishDateMilestone_Executing" data-value="'+ ++countLastCloneEnd +'">'
						// 						append = append + '</div> 			'
						// 					append = append + '</div> 			'
						// 					append = append + '<div class="col-md-1" style="padding-right: 0px;"> 				'
						// 						append = append + '<input value="" class="form-control click" type="text" minlength="1" maxlength="4" name="weightMilestone_Executing" id="weightMilestone" placeholder="weight %" style="display:inline;width:60px;float:right;font-size:12px" data-value=""><input type="text" name="deliverable_document" class="form-control" id="deliverable_document" value="false" style="display:none!important"> 			'
						// 					append = append + '</div> '
						// 					append = append + '<div class="col-md-1" style="float: right;padding-left: 25px;">'
						// 						append = append + '<div class="checkbox">'
						// 							append = append + '<span>'
						// 								append = append + '<input type="checkbox">'
						// 								append = append + 'Doc.'
						// 							append = append + '</span>'
						// 						append = append + '</div>'
						// 					append = append + '</div>'
						// 				append = append + '</div>'
						// 				append = append +'<span class="invalid-feedback" style="display:none!important;color:red"></span>'
						// 			append = append + '</div>'
						// 		append = append + '</div>'
						// 	})
						// })

						//kode kalau 3 terbawah dihapus
						var isPM = (!isNaN(parseInt($(".form_Executing:last").find(".form-group:last").find("label").text().split(" - ")[1]))) 
						var arrVarExecutingPM = ["Preventive Maintenance period - ","Submit Preventive Maintenance report period - ","BA PM - "]

						if (isPM) {
							var labelCount = parseInt($(".form_Executing:last").find(".form-group:last").find("label").text().split(" - ")[1])+1
						}else{
							var labelCount = 1
						}

						$.each(arrVarExecutingPM,function(index,value){
							append = append + '<div class="form-group">'
								append = append + '<label>'+ value + labelCount +'</label>'
								append = append + '<div class="row"> '
									append = append + '<div class="col-md-5"> '
										append = append + '<div class="input-group">					'

											append = append + '<span class="input-group-text"><i class="bx bx-calendar"></i></span>		'
												append = append + '<input style="display:inline" type="text" name="startDateMilestone" class="form-control" id="startDateMilestone_Executing" placeholder="Select start date" value="">'
										append = append + '</div> 			'
									append = append + '</div> 			'
									append = append + '<div class="col-md-5" style="margin-left: -10px;"> 				'
										append = append + '<div class="input-group">					'

											append = append + '<span class="input-group-text"><i style="display:inline" class="bx bx-calendar"></i></span>	'				

												append = append + '<input value="" style="display:inline;font-size:12px;" placeholder="Select finish date" type="text" name="finishDateMilestone" class="form-control" id="finishDateMilestone_Executing" >'
										append = append + '</div> 			'
									append = append + '</div> 			'
									append = append + '<div class="col-md-1" style="padding-right: 0px;"> 				'
										append = append + '<input value="" class="form-control click" type="text" minlength="1" maxlength="4" name="weightMilestone_Executing" id="weightMilestone" placeholder="weight %" style="display:inline;width:60px;float:right;font-size:12px" >			'
									append = append + '</div> '
									append = append + '<div class="col-md-1">'
										append = append + '<div class="checkbox">'
											append = append + '<label class="labelDocMil">'
												append = append + '<input type="checkbox" id="deliverable_document" name="deliverable_document" value=""> '
												append = append + 'Doc.'
											append = append + '</label>'
										append = append + '</div>'
									append = append + '</div>'
								append = append + '</div>'
								append = append +'<span class="invalid-feedback" style="display:none!important;color:red"></span>'
							append = append + '</div>'
						})

				  		$(".form_Executing:last").find(".form-group:last").after(append)

				  		$(".form_Executing:last").find(':input[name="startDateMilestone"]').attr('data-value', function(i, val) {
				            return ++countLastCloneStart
 				        });

		        		$(".form_Executing:last").find(':input[name="finishDateMilestone"]').attr('data-value', function(i, val) {
				            return ++countLastCloneEnd
 				        });

 				        $(".form_Executing:last").find(':input[name="weightMilestone_Executing"]').attr('data-value', function(i, val) {
				            return ++countLastWeight
 				        });

 				        $(".form_Executing:last").find(':input[name="cbDocMilestone"]').attr('data-value', function(i, val) {
				            return ++countLastDeliverable
 				        });

 				        $("input[name='startDateMilestone'],input[name='finishDateMilestone']").flatpickr({
									autoclose: true,
									orientation: "bottom",
									allowInput:true,
									dateFormat: "Y-m-d",
									onClose: function(selectedDates, dateStr, instance) {
						        // Check if dateStr is in valid format (Y-m-d)
						        const isValid = /^\d{4}-\d{2}-\d{2}$/.test(dateStr);
						        
						        if (!isValid) {
						            instance.clear(); // Clear the input
						        }
							    }
								});

						$.each($(".form_Executing"),function(idx,item){
				        	$(item).find("input[name='startDateMilestone'],input[name='finishDateMilestone']").each(function(idx,itemData){
				        		$("#finishDateMilestone_Executing[data-value='"+ $(itemData).attr("data-value") +"']").change(function(){
				    				if (Date.parse(moment(this.value).format("YYYY-MM-DD")) < Date.parse(moment($('#startDateMilestone_Executing[data-value="'+ $(this).data("value") +'"]').val()).format("YYYY-MM-DD"))) {
				    					$(this).removeAttr('value')
				    					$(this).closest(".form-group").find("span.invalid-feedback").show().text("Please enter the valid finish date, cannot less than start date")
				    				}else{
				    					$(this).closest(".form-group").find("span.invalid-feedback").attr('style','display:none!important')
				    					$(this).closest(".form-group").find("span.invalid-feedback").text()
				    				}
				    			})

				    			$("#startDateMilestone_Executing[data-value='"+ $(itemData).attr("data-value") +"']").change(function(){
				    				if (Date.parse(moment(this.value).format("YYYY-MM-DD")) > Date.parse(moment($('#finishDateMilestone_Executing[data-value="'+ $(this).data("value") +'"]').val()).format("YYYY-MM-DD"))) {
				    					$(this).removeAttr('value')
				    					$(this).closest(".form-group").find("span.invalid-feedback").show().text("Please enter the valid start date, cannot greater than finish date")
				    				}else{
				    					$(this).closest(".form-group").find("span.invalid-feedback").attr('style','display:none!important')
				    					$(this).closest(".form-group").find("span.invalid-feedback").text()
				    				}
				    			})
				        	})
				        })
					}else{
						// if ($("#inputSolutionMilestone").length == 0) {
						// 	$(".form_Executing").find(".form-group:first").before("<div class='form-group'><label>Solution Name</label><input class='form-control' placeholder='Fill solution name' id='inputSolutionMilestone' name='inputSolutionMilestone'><span style='display:none!important;color:red' class='invalid-feedback'></span></div>")
						// }

						$.ajax({
							type:"GET",
							url:"{{url('/PMO/getDefaultTask')}}",
							data:{
								assign:"assign",
								id_pmo:window.location.href.split("/")[5].split("?")[0],
    							type:window.location.search.split("=")[1]  
							},success:function(result){
								let countLastCloneFinish = parseInt($('.form_Executing:last').find(".form-group:last").find("#finishDateMilestone_Executing").attr("data-value"))

						        let countLastCloneStart = parseInt($('.form_Executing:last').find(".form-group:last").find("#startDateMilestone_Executing").attr("data-value"))

						        let countLastWeightMilestone = parseInt($('.form_Executing:last').find(".form-group:last").find("#weightMilestone").attr("data-value"))

						        let countLastDeliverable = parseInt($('.form_Executing:last').find(".form-group:last").find("#deliverable_document").attr("data-value")) 

						        if ($("#inputSolutionMilestone").length == 0) {
									$(".form_Executing").find(".form-group:first").before("<div class='form-group'><label>Solution Name</label><input class='form-control' placeholder='Fill solution name' id='inputSolutionMilestone' name='inputSolutionMilestone'><span style='display:none!important;color:red' class='invalid-feedback'></span></div>")
								}

								var append = ""

								append = append + '<form class="form_Executing">'
									append = append + '<div class="form-group">'
										append = append + '<label>Solution Name</label>'
										append = append + '<input class="form-control" placeholder="Fill solution name" id="inputSolutionMilestone" name="inputSolutionMilestone">'
										append = append + '<span style="display:none!important;color:red" class="invalid-feedback"></span>'
									append = append + '</div>'
								$.each(result.Executing,function(index,value){
									append = append + '<div class="form-group">'
										append = append + '<label>'+ value.sub_task +'</label>'
										append = append + '<div class="row"> '
											append = append + '<div class="col-md-4">'
												append = append + '<div class="input-group">'

													append = append + '<span class="input-group-text"><i class="bx bx-calendar"></i></span>		'
														append = append + '<input style="display:inline" type="text" name="startDateMilestone" class="form-control" id="startDateMilestone_Executing" placeholder="Select start date" value="">'
												append = append + '</div>'
											append = append + '</div> '
											append = append + '<div class="col-md-4" style="margin-left: -10px;"> '
												append = append + '<div class="input-group">					'

													append = append + '<span class="input-group-text"><i style="display:inline" class="bx bx-calendar"></i></span>	'				

														append = append + '<input value="" style="display:inline;font-size:12px;" placeholder="Select finish date" type="text" name="finishDateMilestone" class="form-control" id="finishDateMilestone_Executing">'
												append = append + '</div> 			'
											append = append + '</div> '
											append = append + '<div class="col-md-1" style="padding-right: 0px;"> '
												append = append + '<input value="'+ value.bobot +'" class="form-control click" type="text" minlength="1" maxlength="4" name="weightMilestone_Executing" id="weightMilestone" placeholder="weight %" style="display:inline;width:60px;float:right;font-size:12px">	'
											append = append + '</div> '
											append = append + '<div class="col-md-2">'
												append = append + '<div class="checkbox">'
													append = append + '<label class="labelDocMil">'
														append = append + '<input type="checkbox" id="deliverable_document" name="deliverable_document" value="">'
														append = append + 'Deliverable Doc.'
													append = append + '</label>'
												append = append + '</div>'
											append = append + '</div>'
											append = append + '<div class="col-sm-1">'

												append = append + '<button class="btn btn-sm btn-danger" type="button" onclick="btnDeleteTaskCustom(this)"><i class="bx bx-trash"></i></button>'
											append = append + '</div>'	
										append = append + '</div>'
										append = append +'<span class="invalid-feedback" style="display:none!important;color:red"></span>'
									append = append + '</div>'
								})
								append = append + '</form>'

						        $(".form_Executing:last").after(append)

						       	$(".form_Executing:last").find(':input[name="startDateMilestone"]').attr('data-value', function(i, val) {
						            return ++countLastCloneStart
		 				        });

				        		$(".form_Executing:last").find(':input[name="finishDateMilestone"]').attr('data-value', function(i, val) {
						            return ++countLastCloneFinish
		 				        });

		 				        $(".form_Executing:last").find(':input[name="weightMilestone_Executing"]').attr('data-value', function(i, val) {
						            return ++countLastWeightMilestone
		 				        });

		 				        $(".form_Executing:last").find(':input[name="cbDocMilestone"]').attr('data-value', function(i, val) {
						            return ++countLastDeliverable
		 				        });
						        

						        $(".form_Executing").closest(".card-body").find(".form_Executing:last").before("<hr>")

						        $("input[name='startDateMilestone'],input[name='finishDateMilestone']").flatpickr({
											autoclose: true,
											orientation: "bottom",
											allowInput:true,
											dateFormat: "Y-m-d",
											onClose: function(selectedDates, dateStr, instance) {
								        // Check if dateStr is in valid format (Y-m-d)
								        const isValid = /^\d{4}-\d{2}-\d{2}$/.test(dateStr);
								        
								        if (!isValid) {
								            instance.clear(); // Clear the input
								        }
										  }
										});

								$.each($(".form_Executing"),function(idx,item){
						        	$(item).find("input[name='startDateMilestone'],input[name='finishDateMilestone']").each(function(idx,itemData){
						        		$("#finishDateMilestone_Executing[data-value='"+ $(itemData).attr("data-value") +"']").change(function(){
						    				if (Date.parse(moment(this.value).format("YYYY-MM-DD")) < Date.parse(moment($('#startDateMilestone_Executing[data-value="'+ $(this).data("value") +'"]').val()).format("YYYY-MM-DD"))) {
						    					$(this).removeAttr('value')
						    					$(this).closest(".form-group").find("span.invalid-feedback").show().text("Please enter the valid finish date, cannot less than start date")
						    				}else{
						    					$(this).closest(".form-group").find("span.invalid-feedback").attr('style','display:none!important')
						    					$(this).closest(".form-group").find("span.invalid-feedback").text()
						    				}
						    			})

						    			$("#startDateMilestone_Executing[data-value='"+ $(itemData).attr("data-value") +"']").change(function(){
						    				if (Date.parse(moment(this.value).format("YYYY-MM-DD")) > Date.parse(moment($('#finishDateMilestone_Executing[data-value="'+ $(this).data("value") +'"]').val()).format("YYYY-MM-DD"))) {
						    					$(this).removeAttr('value')
						    					$(this).closest(".form-group").find("span.invalid-feedback").show().text("Please enter the valid start date, cannot greater than finish date")
						    				}else{
						    					$(this).closest(".form-group").find("span.invalid-feedback").attr('style','display:none!important')
						    					$(this).closest(".form-group").find("span.invalid-feedback").text()
						    				}
						    			})
						        	})
						        })

							}
						})

						// let countLastCloneFinish = parseInt($('.form_Executing:last').find(".form-group:last").find("#finishDateMilestone_Executing").attr("data-value"))

						  //       let countLastCloneStart = parseInt($('.form_Executing:last').find(".form-group:last").find("#startDateMilestone_Executing").attr("data-value"))

						  //       let countLastWeightMilestone = parseInt($('.form_Executing:last').find(".form-group:last").find("#weightMilestone").attr("data-value"))

						  //       let countLastDeliverable = parseInt($('.form_Executing:last').find(".form-group:last").find("#deliverable_document").attr("data-value")) 	
							
								// var source = $('.form_Executing:first')
						  //       clone = source.clone();
						  //       clone.find(".form-group").find(".row").find(".col-md-5").removeClass("col-md-5").addClass("col-md-4")
						  //       clone.find(".form-group").find(".row").find("input[name='startDateMilestone']")
						  //       clone.find(".form-group").find(".row").find("input[name='finishDateMilestone']")
						  //       clone.find(".form-group").find(".row").find("input[name='weightMilestone_Executing']").val(0)

								// clone.find(".row").find(".col-md-1:first").after('<div class="col-md-2"><div class="checkbox"><label class="labelDocMil"><input type="checkbox" id="cbDocMilestone" name="cbDocMilestone">Deliverable Doc.</label></div></div>')

						  //       clone.find(':input[name="startDateMilestone"]').attr('data-value', function(i, val) {
						  //           return ++countLastCloneStart
		 				 //        });

				    //     		clone.find(':input[name="finishDateMilestone"]').attr('data-value', function(i, val) {
						  //           return ++countLastCloneFinish
		 				 //        });

		 				 //        clone.find(':input[name="weightMilestone_Executing"]').attr('data-value', function(i, val) {
						  //           return ++countLastWeightMilestone
		 				 //        });

		 				 //        clone.find(':input[name="cbDocMilestone"]').attr('data-value', function(i, val) {
						  //           return ++countLastDeliverable
		 				 //        });

						  //       $(".form_Executing:last").after(clone)

						  //       $(".form_Executing").closest(".card-body").find(".form_Executing:last").before("<hr>")
					}

					$("#btnAddSolution").after("<button style='margin-left:5px' id='removeCloneExecuting' value='"+ $(this)[0].innerText.replace(" ","") +"' class='btn btn-sm btn-danger'><i class='bx bx-trash'></></button>")
				})

				$(document).on("click","#removeCloneExecuting",function() {
					if (this.value == 'PM') {
						$(".form_Executing:last").find(".form-group:nth-last-child(-n+3)").remove()
						if (count == 1) {
							$("#removeCloneExecuting").remove()
						}
					}else{
						$(".form_Executing:last").remove()
						$(".form_Executing:last").closest("div").find("hr:last").remove()
						if ($(".form_Executing").length == 1) {
							$(".form_Executing").find(".form-group:first").remove()
						}

						if ($(".form_Executing").length == 1) {
							$("#removeCloneExecuting").remove()
						}
					}
					--count;
					--incLabel;
				})	

				let sumWeight = 0
				let sumInitiating = 0
				let sumPlanning = 0
				let sumExecuting = 0
				let sumClosing = 0

				let arrInitiatingCountNull = []
				let arrPlanningCountNull = []
				let arrExecutingCountNull = []
				let arrClosingCountNull = []

				// let isReadyPost = false

				$(document).on("click","#saveMilestone",function() {
					// window.onbeforeunload = function () {
					//   // blank function do nothing
					// }

					let arrInitiatingCountNull = []
					let arrPlanningCountNull = []
					let arrExecutingCountNull = []
					let arrClosingCountNull = []

					if($(this).closest("div").prev("form").attr("class") == "form_Initiating"){
						$(".form_Initiating").each(function(){
						    $(this).find('input[type!="checkbox"]').each(function(index,value){
						        if(value.value == ""){
						            arrInitiatingCountNull.push(value.value)
						        }
						    })
						})

						if (arrInitiatingCountNull.length  > 0) {
							validationEmptyMilestone("weightMilestone_Initiating",false)
						}else {
							// if ($("input[name='weightMilestone_Initiating']:last").closest("div").closest(".row").next("span").text() == "Please Fill Empty Milestone Date/Weight!") {
								validationEmptyMilestone("weightMilestone_Initiating",true)
							// }

							$.each($("input[name='weightMilestone_Initiating']"),function(index,value){
								sumInitiating += parseFloat(value.value.replace(',','.'))
							})


							var valueInputWeight = $(this).closest(".card-body").closest(".card").find("input[name='inputWeight']").val()

							validationMilestone(sumInitiating,valueInputWeight,"weight_0")
						}
					}
					
					if($(this).closest("div").prev("form").attr("class") == "form_Planning"){
						$(".form_Planning").each(function(){
						    $(this).find('input[type!="checkbox"]').each(function(index,value){
						        if(value.value == ""){
						            arrPlanningCountNull.push(value.value)
						        }
						    })
						})

						if (arrPlanningCountNull.length > 0) {
							validationEmptyMilestone("weightMilestone_Planning",false)
						}else {
							// if ($("input[name='weightMilestone_Planning']:last").closest("div").closest(".row").next("span").text() == "Please Fill Empty Milestone Date/Weight!") {
								validationEmptyMilestone("weightMilestone_Planning",true)
							// }

							$.each($("input[name='weightMilestone_Planning']"),function(index,value){
						        if(value.value != ""){
									sumPlanning += parseFloat(value.value.replace(',','.'))
						        }
							})


							var valueInputWeight = $(this).closest(".card-body").closest(".card").find("input[name='inputWeight']").val()

							validationMilestone(sumPlanning,valueInputWeight,"weight_1")
						} 
					}
					
					if($(this).closest("div").prev("form").attr("class") == "form_Executing"){
						$(".form_Executing").each(function(){
						    $(this).find('input[type!="checkbox"]').not('#deliverable_document').each(function(index,value){
						        if(value.value == ""){
						            arrExecutingCountNull.push(value.value)
						        }
						    })
						})

						if (arrExecutingCountNull.length > 0) {
							console.log(arrExecutingCountNull)
							validationEmptyMilestone("weightMilestone_Executing",false)	
						}else {
							console.log(arrExecutingCountNull)

							validationEmptyMilestone("weightMilestone_Executing",true)
							// if ($("input[name='weightMilestone_Executing']:last").closest("div").closest(".row").next("span").text() == "Please Fill Empty Milestone Date/Weight!") {
								
							// }
							$.each($("input[name='weightMilestone_Executing']"),function(index,value){
								if (value.value != '') {
									sumExecuting += parseFloat(value.value.replace(',','.'))
								}
							})


							var valueInputWeight = $(this).closest(".card-body").closest(".card").find("input[name='inputWeight']").val()

							validationMilestone(sumExecuting,valueInputWeight,"weight_2")
						}

						
					}
						
					if($(this).closest("div").prev("form").attr("class") == "form_Closing"){
						$(".form_Closing").each(function(){
						    $(this).find('input[type!="checkbox"]').each(function(index,value){
						        if(value.value == ""){
						            arrClosingCountNull.push(value.value)
						        }
						    })
						})

						if (arrClosingCountNull.length > 0) {
							validationEmptyMilestone("weightMilestone_Closing",false)
						}else {
							// if ($("input[name='weightMilestone_Closing']:last").closest("div").closest(".row").next("span").text() == "Please Fill Empty Milestone Date/Weight!") {
								validationEmptyMilestone("weightMilestone_Closing",true)
							// }

							$.each($("input[name='weightMilestone_Closing']"),function(index,value){
								if (value.value != '') {
									sumClosing += parseFloat(value.value.replace(',','.'))
								}
							})

							var valueInputWeight = $(this).closest(".card-body").closest(".card").find("input[name='inputWeight']").val()

							validationMilestone(sumClosing,valueInputWeight,"weight_3")
						}
					}

					$.each($("input[name='inputWeight']"),function(index,value){
						if (value.value != "") {
							sumWeight += parseFloat(value.value)
							// let x = "weight_"+index

							// switch(x){
							//   case "weight_0":
							//   	validationMilestone(sumInitiating,value.value,x)
							//     break;
							//   case "weight_1":
							//   	validationMilestone(sumPlanning,value.value,x)
							//     break;
							//   case "weight_2":
							//   	validationMilestone(sumExecuting,value.value,x)
							//     break;
							//   case "weight_3":
							//   	validationMilestone(sumClosing,value.value,x)
							//     break;
							//   default:
							// }
						}
					})

					if (sumWeight == 0 || sumWeight > 100) {
						sumWeight = 0
						alert("Your weight must be 100%")
					}											

					var classForm = $(this).closest("div").prev("form").attr("class")
					if ($("."+classForm).find(".form-group").find(".invalid-feedback").is(":visible") == false) {
						readyToPostMilestone(classForm)
					}else{
						Swal.fire({
				            title: 'Wrong Action!',
				            text: "Please Check Your Milestone",
				            icon: 'error',
				            showCancelButton: false,
				            confirmButtonColor: '#3085d6',
				            cancelButtonColor: '#d33',
				            confirmButtonText: 'OK',
				        })
					}


					// if (sumWeight == 100) {
					
					// 	readyToPostMilestone()
					// }

					sumWeight = 0
					sumInitiating = 0
					sumPlanning = 0
					sumExecuting = 0
					sumClosing = 0

				})	

				function validationMilestone(values,inputValue,x){
					if (values > inputValue) {
						if (x == "weight_0") {
							$("input[name='weightMilestone_Initiating']:last").closest("div").closest(".row").next("span").show().text("Weight child is greater than Weight Total!").css("display","inline")
							$("input[name='weightMilestone_Initiating']:last").closest("div").closest(".row").next("span").next("span").text("")

							$("input[name='weightMilestone_Initiating']:last").closest("div").closest(".row").next("span").show().after("<span style='display:inline;float:right;color:red'>Weight More than "+ parseInt(values - inputValue)  +" point</span>")
						}else if (x == "weight_1") {
							$("input[name='weightMilestone_Planning']:last").closest("div").closest(".row").next("span").show().text("Weight child is greater than Weight Total!").css("display","inline")
							$("input[name='weightMilestone_Planning']:last").closest("div").closest(".row").next("span").next("span").text("")

							$("input[name='weightMilestone_Planning']:last").closest("div").closest(".row").next("span").show().after("<span style='display:inline;float:right;color:red'>Weight More than "+ parseInt(values - inputValue)  +" point</span>")
						}else if (x == 'weight_2') {
							$("input[name='weightMilestone_Executing']:last").closest("div").closest(".row").next("span").show().text("Weight child is greater than Weight Total!").css("display","inline")
							$("input[name='weightMilestone_Executing']:last").closest("div").closest(".row").next("span").next("span").text("")

							$("input[name='weightMilestone_Executing']:last").closest("div").closest(".row").next("span").show().after("<span style='display:inline;float:right;color:red'>Weight More than "+ parseInt(values - inputValue)  +" point</span>")
						}else if (x == 'weight_3') {
							$("input[name='weightMilestone_Closing']:last").closest("div").closest(".row").next("span").show().text("Weight child is greater than Weight Total!").css("display","inline")
							$("input[name='weightMilestone_Closing']:last").closest("div").closest(".row").next("span").next("span").text("")

							$("input[name='weightMilestone_Closing']:last").closest("div").closest(".row").next("span").after("<span style='display:inline;float:right;color:red'>Weight More than "+ parseInt(values - inputValue)  +" point</span>").show()
						}
					}else if(values < inputValue){
						if (x == "weight_0") {
							$("input[name='weightMilestone_Initiating']:last").closest("div").closest(".row").next("span").show().text("Weight child is less than Weight Total!").css("display","inline")
							$("input[name='weightMilestone_Initiating']:last").closest("div").closest(".row").next("span").next("span").text("")
							$("input[name='weightMilestone_Initiating']:last").closest("div").closest(".row").next("span").after("<span style='display:inline;float:right;color:red'>Weight less than "+ - (parseInt(values - inputValue))  +" point</span>").show()
						}else if (x == "weight_1") {
							$("input[name='weightMilestone_Planning']:last").closest("div").closest(".row").next("span").show().text("Weight child is less than Weight Total!").css("display","inline")
							$("input[name='weightMilestone_Planning']:last").closest("div").closest(".row").next("span").next("span").text("")
							$("input[name='weightMilestone_Planning']:last").closest("div").closest(".row").next("span").after("<span style='display:inline;float:right;color:red'>Weight less than "+ - (parseInt(values - inputValue))  +" point</span>").show()
						}else if (x == 'weight_2') {
							$("input[name='weightMilestone_Executing']:last").closest("div").closest(".row").next("span").show().text("Weight child is less than Weight Total!").css("display","inline")
							$("input[name='weightMilestone_Executing']:last").closest("div").closest(".row").next("span").next("span").text("")

							$("input[name='weightMilestone_Executing']:last").closest("div").closest(".row").next("span").after("<span style='display:inline;float:right;color:red'>Weight less than "+ - (parseInt(values - inputValue))  +" point</span>").show()
						}else if (x == 'weight_3') {
							$("input[name='weightMilestone_Closing']:last").closest("div").closest(".row").next("span").show().text("Weight child is less than Weight Total!").css("display","inline")
							$("input[name='weightMilestone_Closing']:last").closest("div").closest(".row").next("span").next("span").text("")

							$("input[name='weightMilestone_Closing']:last").closest("div").closest(".row").next("span").after("<span style='display:inline;float:right;color:red'>Weight less than "+ - (parseInt(values - inputValue))  +" point</span>").show()
						}
					}else{
						if (x == "weight_0") {
							$("input[name='weightMilestone_Initiating']:last").closest("div").closest(".row").next("span").attr('style','display:none!important')
							$("input[name='weightMilestone_Initiating']:last").closest("div").closest(".row").next("span").next("span").attr('style','display:none!important')

							// $("input[name='weightMilestone_Initiating']:last").closest("div").closest(".row").next("span").text("")
						}else if (x == "weight_1") {
							$("input[name='weightMilestone_Planning']:last").closest("div").closest(".row").next("span").attr('style','display:none!important')
							$("input[name='weightMilestone_Planning']:last").closest("div").closest(".row").next("span").next("span").attr('style','display:none!important')

							// $("input[name='weightMilestone_Planning']:last").closest("div").closest(".row").next("span").text("")
						}else if (x == 'weight_2') {
							$("input[name='weightMilestone_Executing']:last").closest("div").closest(".row").next("span").attr('style','display:none!important')
							$("input[name='weightMilestone_Executing']:last").closest("div").closest(".row").next("span").next("span").attr('style','display:none!important')

							// $("input[name='weightMilestone_Executing']:last").closest("div").closest(".row").next("span").text("")
						}else if (x == 'weight_3') {
							$("input[name='weightMilestone_Closing']:last").closest("div").closest(".row").next("span").attr('style','display:none!important')
							$("input[name='weightMilestone_Closing']:last").closest("div").closest(".row").next("span").next("span").attr('style','display:none!important')

							// $("input[name='weightMilestone_Closing']:last").closest("div").closest(".row").next("span").text("")
						}
					}
				}

				function validationEmptyMilestone(x,status){
					console.log(status)
					if (status == true) {
						$.each($("input[name='inputSolutionMilestone']"),function(index,item){
							$(item).next("span").attr('style','display:none!important')
							$(item).next("span").text("")
						})

						$.each($("input[name='"+ x +"']"),function(index,item){
							$.each($(item).closest("form").find("input").not('#deliverable_document').not('input[name="cbDocMilestone"]'),function(idx,items){
								if(items.value != ""){
									$(items).closest("div").closest(".row").next("span").attr('style','display:none!important')
									$(items).closest("div").closest(".row").next("span").text("")
								}
							})
						})
					}else{
						$.each($("input[name='inputSolutionMilestone']"),function(index,item){
							if ($(item).val() == "") {
								$(item).next("span").show().text("Please Fill Empty Solution Name!")
							}
						})

						$.each($("input[name='"+ x +"']"),function(index,item){
							 $.each($(item).closest("form").find("input").not('#deliverable_document').not('input[name="cbDocMilestone"]'),function(idx,items){
						        if(items.value == ""){
						            $(items).closest("div").closest(".row").next("span").show().text("Please Fill Empty Milestone Date/Weight!")
						        }
						    })
						})
							// $("input[name='"+ x +"']:last").closest("div").closest(".row").next("span").show().text("Please Fill Empty Milestone Date/Weight!")
					}
				}

				function validationDate(idx){
					$("#finishDateMilestone_Initiating[data-value='"+ idx +"']").change(function(){
	    				if (Date.parse(moment(this.value).format("YYYY-MM-DD")) < Date.parse(moment($('#startDateMilestone_Initiating[data-value="'+ $(this).data("value") +'"]').val()).format("YYYY-MM-DD"))) {
	    					$(this).removeAttr('value')
	    					$(this).closest(".form-group").find("span.invalid-feedback").show().text("Please enter the valid finish date, cannot less than start date")
	    				}else{
	    					$(this).closest(".form-group").find("span.invalid-feedback").attr('style','display:none!important')
	    					$(this).closest(".form-group").find("span.invalid-feedback").text()
	    				}
	    			})

	    			$("#finishDateMilestone_Planning[data-value='"+ idx +"']").change(function(){
	    				if (Date.parse(moment(this.value).format("YYYY-MM-DD")) < Date.parse(moment($('#startDateMilestone_Planning[data-value="'+ $(this).data("value") +'"]').val()).format("YYYY-MM-DD"))) {
	    					$(this).removeAttr('value')
	    					$(this).closest(".form-group").find("span.invalid-feedback").show().text("Please enter the valid finish date, cannot less than start date")
	    				}else{
	    					$(this).closest(".form-group").find("span.invalid-feedback").attr('style','display:none!important')
	    					$(this).closest(".form-group").find("span.invalid-feedback").text()
	    				}
	    			})

	    			$("#finishDateMilestone_Executing[data-value='"+ idx +"']").change(function(){
	    				if (Date.parse(moment(this.value).format("YYYY-MM-DD")) < Date.parse(moment($('#startDateMilestone_Executing[data-value="'+ $(this).data("value") +'"]').val()).format("YYYY-MM-DD"))) {
	    					$(this).removeAttr('value')
	    					$(this).closest(".form-group").find("span.invalid-feedback").show().text("Please enter the valid finish date, cannot less than start date")
	    				}else{
	    					$(this).closest(".form-group").find("span.invalid-feedback").attr('style','display:none!important')
	    					$(this).closest(".form-group").find("span.invalid-feedback").text()
	    				}
	    			})

	    			$("#finishDateMilestone_Closing[data-value='"+ idx +"']").change(function(){
	    				if (Date.parse(moment(this.value).format("YYYY-MM-DD")) < Date.parse(moment($('#startDateMilestone_Closing[data-value="'+ $(this).data("value") +'"]').val()).format("YYYY-MM-DD"))) {
	    					$(this).removeAttr('value')
	    					$(this).closest(".form-group").find("span.invalid-feedback").show().text("Please enter the valid finish date, cannot less than start date")
	    				}else{
	    					$(this).closest(".form-group").find("span.invalid-feedback").attr('style','display:none!important')
	    					$(this).closest(".form-group").find("span.invalid-feedback").text()
	    				}
	    			})

	    			$("#startDateMilestone_Initiating[data-value='"+ idx +"']").change(function(){
	    				if (Date.parse(moment(this.value).format("YYYY-MM-DD")) > Date.parse(moment($('#finishDateMilestone_Initiating[data-value="'+ $(this).data("value") +'"]').val()).format("YYYY-MM-DD"))) {
	    					$(this).removeAttr('value')
	    					$(this).closest(".form-group").find("span.invalid-feedback").show().text("Please enter the valid start date, cannot greater than finish date")
	    				}else{
	    					$(this).closest(".form-group").find("span.invalid-feedback").attr('style','display:none!important')
	    					$(this).closest(".form-group").find("span.invalid-feedback").text()
	    				}
	    			})

	    			$("#startDateMilestone_Planning[data-value='"+ idx +"']").change(function(){
						
	    				if (Date.parse(moment(this.value).format("YYYY-MM-DD")) > Date.parse(moment($('#finishDateMilestone_Planning[data-value="'+ $(this).data("value") +'"]').val()).format("YYYY-MM-DD"))) {
	    					$(this).removeAttr('value')
	    					$(this).closest(".form-group").find("span.invalid-feedback").show().text("Please enter the valid start date, cannot greater than finish date")
	    				}else{
	    					$(this).closest(".form-group").find("span.invalid-feedback").attr('style','display:none!important')
	    					$(this).closest(".form-group").find("span.invalid-feedback").text()
	    				}
	    			})

	    			$("#startDateMilestone_Executing[data-value='"+ idx +"']").change(function(){
						
	    				if (Date.parse(moment(this.value).format("YYYY-MM-DD")) > Date.parse(moment($('#finishDateMilestone_Executing[data-value="'+ $(this).data("value") +'"]').val()).format("YYYY-MM-DD"))) {
	    					$(this).removeAttr('value')
	    					$(this).closest(".form-group").find("span.invalid-feedback").show().text("Please enter the valid start date, cannot greater than finish date")
	    				}else{
	    					$(this).closest(".form-group").find("span.invalid-feedback").attr('style','display:none!important')
	    					$(this).closest(".form-group").find("span.invalid-feedback").text()
	    				}
	    			})

	    			$("#startDateMilestone_Closing[data-value='"+ idx +"']").change(function(){
							console.log(this.value + "closing")
	    				const startDate = moment(this.value).format("YYYY-MM-DD");
					    const finishDate = moment($('#finishDateMilestone_Closing[data-value="'+ $(this).data("value") +'"]').val()).format("YYYY-MM-DD");

					    if (Date.parse(startDate) > Date.parse(finishDate)) {
					        console.log("harusnya merah");
					        $(this).val('');
					        $(this).closest(".form-group").find("span.invalid-feedback")
					            .show().text("Please enter a valid start date; it cannot be later than the finish date.");
					    } else {
					        $(this).closest(".form-group").find("span.invalid-feedback")
					            .hide().text('');
					    }
	    			})
				}

				function readyToPostMilestone(id){
					var arrInitiating = [], arrPlanning = [], arrExecuting = [], arrClosing = [], arrMainMilestone = [], arrSolutionMilestone = []
					var arrExecutingFinal = ''

					// let isInitiatingHide = $("input[name='weightMilestone_Initiating']:last").closest("div").closest(".row").next("span").is(':hidden')
					// let isPlanningHide = $("input[name='weightMilestone_Planning']:last").closest("div").closest(".row").next("span").is(':hidden')
					// let isExecutingHide = $("input[name='weightMilestone_Executing']:last").closest("div").closest(".row").next("span").is(':hidden')
					// let isClosingHide = $("input[name='weightMilestone_Closing']:last").closest("div").closest(".row").next("span").is(':hidden')

					// if (isInitiatingHide == true && isPlanningHide == true && isExecutingHide == true && isClosingHide == true) {
						swalFireCustom = {
				          title: 'Are you sure?',
				          text: "Submit Milestone",
				          icon: 'warning',
				          showCancelButton: true,
				          confirmButtonColor: '#3085d6',
				          cancelButtonColor: '#d33',
				          confirmButtonText: 'Yes',
				          cancelButtonText: 'No',
				        }

				        let startdateMilestone = '', finishDateMilestone = '', weightMilestone = '', labelTask = '', deliverableDoc = '', solutionMilestone = '', arrExecutingNew = ''

				        arrMainMilestone = ['Initiating','Planning','Executing','Closing']

						if (window.location.href.split("/")[5].split('?')[1].split('=')[2] == "custom") {
							$.each(arrMainMilestone,function(index,value){
								$(".form_"+value).find(".form_group_"+value).each(function(idx,item){
							        if (value == "Initiating") {

							        	$(item).find("div.row").find("#inputLabelTask").each(function(idx,itemsTask){
								            // arrInitiating.push({"dateMilestone":itemsDate.value})
								            itemTaskMilestone = itemsTask.value
								            
								        })

									    $(item).find("div.row").find("#startDateMilestone_"+value).each(function(idx,itemsDate){
								            // arrInitiating.push({"dateMilestone":itemsDate.value})
								            startDateMilestone = moment(itemsDate.value).format('YYYY-MM-DD')
								            
								        })

								        $(item).find("div.row").find("#finishDateMilestone_"+value).each(function(idx,itemsDuration){
								            
								            finishDateMilestone = moment(itemsDuration.value).format('YYYY-MM-DD')
								            // arrInitiating.push({"finishDateMilestone":itemsDuration.value})
								        })
								    
								        $(item).find("div.row").find("#weightMilestone").each(function(idx,itemsWeight){
								            
								            weightMilestone = itemsWeight.value
								            // arrInitiating.push({"weightMilestone":itemsWeight.value})
								            
								        })

								        $(item).find("div.row").find("#cbDocMilestone_"+value).each(function(idx,itemsDeliverDoc){
								        	if ($(itemsDeliverDoc).is(":checked")) {
								        		cbDocMilestone = "true"
								        	}else{
								        		cbDocMilestone = "false"
								        	}
								        })

							        	arrInitiating.push({"inputTaskMilestone":itemTaskMilestone,"startDateMilestone":startDateMilestone,"finishDateMilestone":finishDateMilestone,"weightMilestone":weightMilestone,"deliverableDoc":cbDocMilestone})
							        }else if (value == "Planning") {
							        	$(item).find("div.row").find("#inputLabelTask").each(function(idx,itemsTask){
							            // arrInitiating.push({"dateMilestone":itemsDate.value})
								            itemTaskMilestone = itemsTask.value
								            
								        })

									    $(item).find("div.row").find("#startDateMilestone_"+value).each(function(idx,itemsDate){
								            // arrInitiating.push({"dateMilestone":itemsDate.value})
								            startDateMilestone = moment(itemsDate.value).format('YYYY-MM-DD')
								            
								        })

								        $(item).find("div.row").find("#finishDateMilestone_"+value).each(function(idx,itemsDuration){
								            
								            finishDateMilestone = moment(itemsDuration.value).format('YYYY-MM-DD')
								            // arrInitiating.push({"finishDateMilestone":itemsDuration.value})
								        })
								    
								        $(item).find("div.row").find("#weightMilestone").each(function(idx,itemsWeight){
								            
								            weightMilestone = itemsWeight.value
								            // arrInitiating.push({"weightMilestone":itemsWeight.value})
								            
								        })

								        $(item).find("div.row").find("#cbDocMilestone_"+value).each(function(idx,itemsDeliverDoc){
								        	if ($(itemsDeliverDoc).is(":checked")) {
								        		cbDocMilestone = "true"
								        	}else{
								        		cbDocMilestone = "false"
								        	}
								            
								        })
							        	arrPlanning.push({"inputTaskMilestone":itemTaskMilestone,"startDateMilestone":startDateMilestone,"finishDateMilestone":finishDateMilestone,"weightMilestone":weightMilestone,"deliverableDoc":cbDocMilestone})
							        }else if (value == "Executing") {
							        	$(item).find("div.row").find("#inputLabelTask").each(function(idx,itemsTask){
								            // arrInitiating.push({"dateMilestone":itemsDate.value})
								            itemTaskMilestone = itemsTask.value
								            
								        })

									    $(item).find("div.row").find("#startDateMilestone_"+value).each(function(idx,itemsDate){
								            // arrInitiating.push({"dateMilestone":itemsDate.value})
								            startDateMilestone = moment(itemsDate.value).format('YYYY-MM-DD')
								            
								        })

								        $(item).find("div.row").find("#finishDateMilestone_"+value).each(function(idx,itemsDuration){
								            
								            finishDateMilestone = moment(itemsDuration.value).format('YYYY-MM-DD')
								            // arrInitiating.push({"finishDateMilestone":itemsDuration.value})
								        })
								    
								        $(item).find("div.row").find("#weightMilestone").each(function(idx,itemsWeight){
								            
								            weightMilestone = itemsWeight.value
								            // arrInitiating.push({"weightMilestone":itemsWeight.value})
								            
								        })

								        $(item).find("div.row").find("#cbDocMilestone_"+value).each(function(idx,itemsDeliverDoc){
								        	if ($(itemsDeliverDoc).is(":checked")) {
								        		cbDocMilestone = "true"
								        	}else{
								        		cbDocMilestone = "false"
								        	}
								            
								        })

							        	arrExecuting.push({"inputTaskMilestone":itemTaskMilestone,"startDateMilestone":startDateMilestone,"finishDateMilestone":finishDateMilestone,"weightMilestone":weightMilestone,"deliverableDoc":cbDocMilestone})
							        }else{
							        	$(item).find("div.row").find("#inputLabelTask").each(function(idx,itemsTask){
								            // arrInitiating.push({"dateMilestone":itemsDate.value})
								            itemTaskMilestone = itemsTask.value
								            
								        })

									    $(item).find("div.row").find("#startDateMilestone_"+value).each(function(idx,itemsDate){
								            // arrInitiating.push({"dateMilestone":itemsDate.value})
								            startDateMilestone = moment(itemsDate.value).format('YYYY-MM-DD')
								            
								        })

								        $(item).find("div.row").find("#finishDateMilestone_"+value).each(function(idx,itemsDuration){
								            
								            finishDateMilestone = moment(itemsDuration.value).format('YYYY-MM-DD')
								            // arrInitiating.push({"finishDateMilestone":itemsDuration.value})
								        })
								    
								        $(item).find("div.row").find("#weightMilestone").each(function(idx,itemsWeight){
								            
								            weightMilestone = itemsWeight.value
								            // arrInitiating.push({"weightMilestone":itemsWeight.value})
								            
								        })

								        $(item).find("div.row").find("#cbDocMilestone_"+value).each(function(idx,itemsDeliverDoc){
								        	if ($(itemsDeliverDoc).is(":checked")) {
								        		cbDocMilestone = "true"
								        	}else{
								        		cbDocMilestone = "false"
								        	}
								        })

							        	arrClosing.push({"inputTaskMilestone":itemTaskMilestone,"startDateMilestone":startDateMilestone,"finishDateMilestone":finishDateMilestone,"weightMilestone":weightMilestone,"deliverableDoc":cbDocMilestone})
							        }
							        
								})
							})
							
						}else{
							$(".form_Initiating").find(".form-group").each(function(idx,item){
							    $(item).find("label").each(function(idx,label){
							    	$(item).find("label").each(function(idx,label){
							            // arrInitiating.push({"dateMilestone":itemsDate.value})
							            labelTask = label.innerHTML
							        })
							        
							        $(item).find("div.row").find("#startDateMilestone_Initiating").each(function(idx,itemsDate){
							            // arrInitiating.push({"dateMilestone":itemsDate.value})
							            startDateMilestone = moment(itemsDate.value).format('YYYY-MM-DD')
							            
							        })

							        $(item).find("div.row").find("#finishDateMilestone_Initiating").each(function(idx,itemsDuration){
							            
							            finishDateMilestone = moment(itemsDuration.value).format('YYYY-MM-DD')
							            // arrInitiating.push({"finishDateMilestone":itemsDuration.value})
							        })
							    
							        $(item).find("div.row").find("#weightMilestone").each(function(idx,itemsWeight){
							            
							            weightMilestone = itemsWeight.value
							            // arrInitiating.push({"weightMilestone":itemsWeight.value})
							            
							        })

							        $(item).find("div.row").find("#deliverable_document").each(function(idx,itemsDeliverDoc){
							            deliverableDoc = itemsDeliverDoc.value
							            // arrInitiating.push({"weightMilestone":itemsWeight.value})
							            
							        })

							        arrInitiating.push({"labelTask":labelTask,"startDateMilestone":startDateMilestone,"finishDateMilestone":finishDateMilestone,"weightMilestone":weightMilestone,"deliverableDoc":deliverableDoc})
							    })
							})
						
							$(".form_Planning").find(".form-group").each(function(idx,item){
							    $(item).find("label").each(function(idx,label){
							    	$(item).find("label").each(function(idx,label){
							            // arrInitiating.push({"dateMilestone":itemsDate.value})
							            labelTask = label.innerHTML
							        })
							        // create an empty array of length n
							        $(item).find("div.row").find("#startDateMilestone_Planning").each(function(idx,itemsDate){
							            // arrInitiating.push({"dateMilestone":itemsDate.value})
							            startDateMilestone = moment(itemsDate.value).format('YYYY-MM-DD')
							            
							        })

							        $(item).find("div.row").find("#finishDateMilestone_Planning").each(function(idx,itemsDuration){
							            
							            finishDateMilestone = moment(itemsDuration.value).format('YYYY-MM-DD')
							            // arrInitiating.push({"finishDateMilestone":itemsDuration.value})
							        })
							    
							        $(item).find("div.row").find("#weightMilestone").each(function(idx,itemsWeight){
							            
							            weightMilestone = itemsWeight.value
							            // arrInitiating.push({"weightMilestone":itemsWeight.value})
							            
							        })

							        $(item).find("div.row").find("#deliverable_document").each(function(idx,itemsDeliverDoc){
							            deliverableDoc = itemsDeliverDoc.value
							            // arrInitiating.push({"weightMilestone":itemsWeight.value})
							            
							        })

							        arrPlanning.push({"labelTask":labelTask,"startDateMilestone":startDateMilestone,"finishDateMilestone":finishDateMilestone,"weightMilestone":weightMilestone,"deliverableDoc":deliverableDoc})
							    })
							})
							
							arrExecutingNew = ''

							for (var i = 0; i <= $(".form_Executing").length-1 ; i++) {		
								if ($(".form_Executing").length > 1) {
									$(".form_Executing:eq("+ i +")").find(".form-group").not(":eq(0)").each(function(idx,item){
										// if (label.innerHTML != 'Solution Name') {
											// arrExecuting[i] =  new Array()
											$(item).each(function(idx,label){
												$(".form_Executing:eq("+ i +")").find(".form-group").eq(0).each(function(idx,itemLabelSol){
										            $(itemLabelSol).find("input[name='inputSolutionMilestone']").each(function(idx,label){
									            		solutionMilestone = label.value
										            })
										        })

												$(item).find("label").each(function(idx,label){
										            if (label.innerHTML != 'Solution Name' && !$(label).hasClass('labelDocMil')) {
										            	if (label.innerHTML.split(" - ")[1] != undefined) {
										            		labelTask = label.innerHTML.split(" - ")[1]
										            	}else{
										            		labelTask = label.innerHTML
										            	}
										            	
										            }
										        })

										     	$(item).find("div.row").find("#startDateMilestone_Executing").each(function(idx,itemsDate){
										            startDateMilestone = moment(itemsDate.value).format('YYYY-MM-DD')
										        })

										        $(item).find("div.row").find("#finishDateMilestone_Executing").each(function(idx,itemsDuration){
										            finishDateMilestone = moment(itemsDuration.value).format('YYYY-MM-DD')
										        })
										    
										        $(item).find("div.row").find("#weightMilestone").each(function(idx,itemsWeight){
										            weightMilestone = itemsWeight.value										            
										        })

										        $(item).find("div.row").find("#deliverable_document").each(function(idx,itemsDeliverDoc){
										        	if (itemsDeliverDoc.value != "") {
										        		deliverableDoc = itemsDeliverDoc.value 
										        	}else{
										        		if ($(itemsDeliverDoc).is(":checked")) {
															deliverableDoc = "true"
														}else{
															deliverableDoc = "false"
														}
										        	}    
											    })

											    // if (arrExecuting[i] == null)
										     //        arrExecuting[i] = arrExecutingSolution;
										     //    else
										        arrExecuting.push({"labelSolution":solutionMilestone,"labelTask":labelTask,"startDateMilestone":startDateMilestone,"finishDateMilestone":finishDateMilestone,"weightMilestone":weightMilestone,"deliverableDoc":deliverableDoc});
											})
									        // arrExecuting[i].push({"labelTask":labelTask,"startDateMilestone":startDateMilestone,"finishDateMilestone":finishDateMilestone,"weightMilestone":weightMilestone,"deliverableDoc":deliverableDoc})	

									    // }

									})
									// const groupBy = (array, key) => {
									//   // Return the end result
									//   return array.reduce((result, currentValue) => {
									//     // If an array already present for key, push it to the array. Else create an array and push the object
									//     (result[currentValue[key]] = result[currentValue[key]] || []).push(
									//       currentValue
									//     );
									//     // Return the current iteration `result` value, this will be taken as next iteration `result` value and accumulate
									//     return result;
									// 	console.log(result)

									//   }, {}); // empty object is the initial value for result object
									// };

									arrExecutingNew = arrExecuting.reduce((result, currentValue) => {
									    // If an array already present for key, push it to the array. Else create an array and push the object
									    (result[currentValue['labelSolution']] = result[currentValue['labelSolution']] || []).push(
									      currentValue
									    );
									    // Return the current iteration `result` value, this will be taken as next iteration `result` value and accumulate
									    return result;
									}, {});
								}else{
									$(".form_Executing:eq("+ i +")").find(".form-group").each(function(idx,item){
									// if (label.innerHTML != 'Solution Name') {
										// arrExecuting[i] =  new Array()
										$(item).each(function(idx,label){
											$(item).find("label").each(function(idx,label){
									            if (label.innerHTML != 'Solution Name' && !$(label).hasClass('labelDocMil')) {
									            	labelTask = label.innerHTML
									            }
									        })

									     	$(item).find("div.row").find("#startDateMilestone_Executing").each(function(idx,itemsDate){
									            // arrInitiating.push({"dateMilestone":itemsDate.value})
									            startDateMilestone = moment(itemsDate.value).format('YYYY-MM-DD')
									            
									        })

									        $(item).find("div.row").find("#finishDateMilestone_Executing").each(function(idx,itemsDuration){
									            
									            finishDateMilestone = moment(itemsDuration.value).format('YYYY-MM-DD')
									            // arrInitiating.push({"finishDateMilestone":itemsDuration.value})
									        })
									    
									        $(item).find("div.row").find("#weightMilestone").each(function(idx,itemsWeight){
									            
									            weightMilestone = itemsWeight.value
									            // arrInitiating.push({"weightMilestone":itemsWeight.value})
									            
									        })

									        $(item).find("div.row").find("#deliverable_document").each(function(idx,itemsDeliverDoc){
									        	if (itemsDeliverDoc.value != "") {
									        		deliverableDoc = itemsDeliverDoc.value 
									        	}else{
									        		if ($(itemsDeliverDoc).is(":checked")) {
														deliverableDoc = "true"
													}else{
														deliverableDoc = "false"
													}
									        	}
										            // deliverableDoc = itemsDeliverDoc.value
										            // arrInitiating.push({"weightMilestone":itemsWeight.value})
										            
										    })

										    // if (arrExecuting[i] == null)
									     //        arrExecuting[i] = arrExecutingSolution;
									     //    else
									            arrExecuting.push({"labelTask":labelTask,"startDateMilestone":startDateMilestone,"finishDateMilestone":finishDateMilestone,"weightMilestone":weightMilestone,"deliverableDoc":deliverableDoc});
										})


								        // arrExecuting[i].push({"labelTask":labelTask,"startDateMilestone":startDateMilestone,"finishDateMilestone":finishDateMilestone,"weightMilestone":weightMilestone,"deliverableDoc":deliverableDoc})	

								    // }

									})
								}	
							}
						
							$(".form_Closing").find(".form-group").each(function(idx,item){
							    $(item).find("label").each(function(idx,label){
							    	$(item).find("label").each(function(idx,label){
							            // arrInitiating.push({"dateMilestone":itemsDate.value})
							            labelTask = label.innerHTML
							        })// create an empty array of length n
							        $(item).find("div.row").find("#startDateMilestone_Closing").each(function(idx,itemsDate){
							            // arrInitiating.push({"dateMilestone":itemsDate.value})
							            startDateMilestone = moment(itemsDate.value).format('YYYY-MM-DD')
							            
							        })

							        $(item).find("div.row").find("#finishDateMilestone_Closing").each(function(idx,itemsDuration){
							            
							            finishDateMilestone = moment(itemsDuration.value).format('YYYY-MM-DD')
							            // arrInitiating.push({"finishDateMilestone":itemsDuration.value})
							        })
							    
							        $(item).find("div.row").find("#weightMilestone").each(function(idx,itemsWeight){
							            
							            weightMilestone = itemsWeight.value
							            // arrInitiating.push({"weightMilestone":itemsWeight.value})
							            
							        })

							        $(item).find("div.row").find("#deliverable_document").each(function(idx,itemsDeliverDoc){
							            deliverableDoc = itemsDeliverDoc.value
							            // arrInitiating.push({"weightMilestone":itemsWeight.value})
							            
							        })

							        arrClosing.push({"labelTask":labelTask,"startDateMilestone":startDateMilestone,"finishDateMilestone":finishDateMilestone,"weightMilestone":weightMilestone,"deliverableDoc":deliverableDoc})
							    })
							})
						}
						
						formData = new FormData
						formData.append("_token","{{ csrf_token() }}")		
						formData.append("id_pmo",window.location.href.split("/")[5].split("?")[0])		
						formData.append("arrMainMilestone",JSON.stringify(arrMainMilestone))		
						formData.append("arrInitiating",JSON.stringify(arrInitiating))		
						formData.append("arrPlanning",JSON.stringify(arrPlanning))
						if (arrExecutingNew != '') {
							formData.append("arrExecuting",JSON.stringify(arrExecutingNew))		
						}else{
							formData.append("arrExecuting",JSON.stringify(arrExecuting))		
						}	
						formData.append("arrClosing",JSON.stringify(arrClosing))	
						formData.append("type_milestone",window.location.href.split("/")[5].split('?')[1].split('=')[2])
						formData.append("current_save",id)		


				        swalSuccess = {
				        	icon: 'success',
          					title: 'Milestone has been saved!',
          					// text: 'Click Ok to reload page',
          					text: 'You can create/saved another milestone!',
				        }

				        if (window.location.href.split("/")[5].split('?')[1].split('=')[2] == "custom") {
							createPost(swalFireCustom,formData,swalSuccess,url="/PMO/storeCustomMilestone")
				        }else{
							createPost(swalFireCustom,formData,swalSuccess,url="/PMO/storeMilestone")
				        }
					// }
				}

				$("input[name='startDateMilestone'],input[name='finishDateMilestone']").flatpickr({
					autoclose: true,
					orientation: "bottom",
					allowInput: true,
					dateFormat: "Y-m-d",
					onClose: function(selectedDates, dateStr, instance) {
		        // Check if dateStr is in valid format (Y-m-d)
		        const isValid = /^\d{4}-\d{2}-\d{2}$/.test(dateStr);
		        
		        if (!isValid) {
		            instance.clear(); // Clear the input
		        }
			    }
				});
				
    		}
    	})
    }

    function btnAddBaseline(){
    	Swal.fire({
            title: 'Are you sure?',
            text: "to create the baseline start date,end date based of create date,end date",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
              $.ajax({
                url: "{{'/PMO/createBaseline'}}",
                type: 'post',
                data:{
                  _token:"{{ csrf_token() }}",
                  id_pmo:window.location.href.split("/")[5].split("?")[0],
                },
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
	                  	didOpen: () => {
	                      Swal.showLoading()
	                  	}
	              	})
	            },
                success: function(data)
                {
                  Swal.showLoading()
                  Swal.fire(
                      'Baseline start date, end date has been created!',
                      'Successfully',
                      'success'
                  ).then((result) => {
                      if (result.value) {
                        location.reload()
                      }
                  })
                }
              });
            }
        })
    }
   	
    function btnShowProjectCharter(id_pmo){
    	firstPage = true
    	$(".content-header").show()
    	$(".content").show()
    	$(".content-title").text("Verify Project Charter")

    	$(".show_project_charter").show()
    	$(".detail_project").attr('style','display:none!important')
    	$("input[name='cbShowProjectCharter']").attr('disabled','disabled').closest('div').css('cursor','not-allowed')

    	$("#showBodyProjectCharter").empty("")
    	$.ajax({
    		type:"GET",
    		url:"{{url('/PMO/showProjectCharter')}}",
    		data:{
    			id_pmo:id_pmo
    		},
    		success:function(result){
    			var append = ""
				append = append + '	<div class="row">'
				append = append + '	<div class="col-md-6">'
				append = append + '		<div class="row mb-4">'
				append = append + '			<div class="col-md-12">'

				append = append + '				<div class="card">'
				append = append + '				    <div class="card-header text-bg-primary">'
				append = append + '				      <h6 class="card-title text-white">Customer Information</h6>'
				append = append + '				    </div>'
				append = append + '				    <div class="card-body mt-4">'
				append = append + '				    	<fieldset disabled>'
				append = append + '				    		<div class="form-group">'
				append = append + '			                    <label for="">Customer*</label>'
				append = append + '			                    <input autocomplete="off" type="text" class="form-control" placeholder="Customer" id="" value="'+ result[0].customer_name +'" name="">'
				append = append + '			                </div> '
				append = append + '		                  	<div class="form-group">'
				append = append + '			                    <label for="">Address*</label>'
				append = append + '			                    <textarea class="form-control" placeholder="Address" id="" name="">'+ result[0].customer_address +'</textarea>'
				append = append + '			                </div> '
				append = append + '		                  	<div class="form-group">'
				append = append + '			                    <label for="">Phone*</label>'
				append = append + '			                    <input autocomplete="off" type="number" class="form-control" placeholder="Customer Phone" id="" name="" value="'+ result[0].customer_phone +'" >'
				append = append + '			                </div> '
				append = append + '			                <div class="row">'
				append = append + '			                    <div class="col-sm-6">'
				append = append + '			                      <div class="form-group">'
				append = append + '			                        <label for="">Contact Person*</label>'
				append = append + '			                        <input autocomplete="off" class="form-control" id="" type="text" name="inputContactPerson" placeholder="Contact Person" value="'+ result[0].customer_cp +'">'
				append = append + '			                      </div>'
				append = append + '			                    </div>'
				append = append + '			                    <div class="col-sm-6">'
				append = append + '			                      <div class="form-group">'
				append = append + '			                        <label for="">Email*</label>'
				append = append + '			                        <input autocomplete="off" type="text" class="form-control" placeholder="Email" name="" id="" value="'+ result[0].customer_email +'">'
				append = append + '			                      </div>'
				append = append + '			                    </div>'
				append = append + '			                </div> '
				append = append + '			                <div class="row">'
				append = append + '			                    <div class="col-sm-6">'
				append = append + '			                      <div class="form-group">'
				append = append + '			                        <label for="">CP Phone*</label>'
				append = append + '			                        <input autocomplete="off" class="form-control" id="" type="" name="" placeholder="Contact Person Phone" value="'+ result[0].customer_cp_phone +'">'
				append = append + '			                      </div>'
				append = append + '			                    </div>'
				append = append + '			                    <div class="col-sm-6">'
				append = append + '			                      <div class="form-group">'
				append = append + '			                        <label for="">CP Title*</label>'
				append = append + '			                        <input autocomplete="off" type="text" class="form-control" placeholder="Contact Person Title" name="" id="" value="'+ result[0].customer_cp_title +'">'
				append = append + '			                      </div>'
				append = append + '			                    </div>'
				append = append + '			                </div>'
				append = append + '				    	</fieldset>'
				append = append + '					</div>'
				append = append + '			  	</div>'
				append = append + '			</div>'
				append = append + '		</div>'

				append = append + '		<div class="row mb-4">'
				append = append + '			<div class="col-md-12">'

				append = append + '				<div class="card">'
				append = append + '				    <div class="card-header text-bg-primary">'
				append = append + '				      <h6 class="card-title text-white">Initial Identified Risk</h6>'
				append = append + '				    </div>'
				append = append + '				    <div class="card-body">'
				append = append + '						<fieldset disabled id="showRiskProjectCharter">'
				
				append = append + '					    </fieldset>'
				append = append + '				    </div>'
				append = append + '			  	</div>'
				append = append + '			</div>'
				append = append + '		</div>'
				append = append + '		<div class="row">'
				append = append + '			<div class="col-md-12 col-xs-12">'

				append = append + '				<div class="card">'
				append = append + '				    <div class="card-header">'
				append = append + '				      <h6 class="card-title">Approval</h6>'
				append = append + '				    </div>'
				append = append + '				    <div class="card-body">'
				append = append + '				    <fieldset disabled>'
				append = append + '	             <div class="row" id="rowSign">'

				var appendSign = ""
				
				$.ajax({
					url:"{{url('PMO/getSignProjectCharter')}}",
					type:"GET",
					data:{
						id_pmo:window.location.href.split("/")[5].split("?")[0]
					},
					success:function(result){
						var position = '', ttd = ''

						$.each(result,function(index,item){
							if (item.position == 'Project Manager') {
								position = 'Project Manager'
								label = 'Prepared By'
							}else if (item.position == 'Project Management Manager') {
								position = 'Project Management Manager'	

								label = 'Approved By'						
							}else if (item.position == 'Project Coordinator') {
								position = 'Project Coordinator'	
								label = 'Prepared By'						
							}else{
								position = 'Project Owner'	
								label = 'Approved By'						
							}

							if (item.signed == 'false') {
								ttd = 'image/placeholder-sign-3.png'
							}else{
								ttd = item.ttd_digital
							}

							appendSign = appendSign + '            <div class="col-md-4 col-xs-12">'
							appendSign = appendSign + '           		<div style="display: flex;">'
							appendSign = appendSign + '            		<label style="margin: 0 auto;vertical-align: middle;">'+ label +'</label>'
							appendSign = appendSign + '           		</div>'
							appendSign = appendSign + '           		<div style="display: flex;padding-top:40px ;">'
							appendSign = appendSign + '           			<img src="{{asset("/")}}'+ ttd +'" style="width:150px;height:150px;margin:0 auto;object-fit:contain" />'
							appendSign = appendSign + '           		</div>'
							appendSign = appendSign + '   				<div style="display:flex;padding-top: 40px;">'
							appendSign = appendSign + '   					<label style="margin: 0 auto;font-size:12px">'+ item.name +'</label>'
							appendSign = appendSign + '   				</div>'
							appendSign = appendSign + '   				<div style="display:grid;">'						
							appendSign = appendSign + '            		<label style="text-align: center;font-size:12px">'+ position +'</label>'
							appendSign = appendSign + '   				</div>'
							appendSign = appendSign + '            </div>'
						})

						$("#rowSign").append(appendSign)
					}
				})

				append = append + '	                  </div>  '
				append = append + '				    </fieldset>  '

				append = append + '				    <button class="btn btn-sm btn-primary pull-right" style="display:none!important;margin-top:20px" type="button" id="btnApproveSign" style="margin-top:20px">Approve</button>'
				append = append + '				    </div>'
				append = append + '			  	</div>'
				append = append + '			</div>'
				append = append + '		</div>'
				append = append + '	</div>'

				append = append + '	<div class="col-md-6">'
				append = append + '	  <div class="card">'
				append = append + '	    <div class="card-header text-bg-primary">'
				append = append + '	      <h6 class="card-title text-white">Project Information</h6>'
				append = append + '	    </div>'
				append = append + '	    <div class="card-body">'
				append = append + '	    	<fieldset disabled>'
					append = append + '		      	<div class="row mt-4">'
						append = append + '                    <div class="col-md-6">'
						append = append + '                      <div class="form-group">'
						append = append + '                        <label>Project ID Number*</label>'
						append = append + '                        <select autocomplete="off" type="text" name="" class="form-control" id="" placeholder=""><option selected>'+ result[0].project_id.project_id 
						append = append + '                          <option/>'
						append = append + '                        </select>'
						append = append + '                      </div>'
						append = append + '                    </div>'

						append = append + '                    <div class="col-md-6">'
						append = append + '                      <div class="form-group">'
						append = append + '                        <label>PO/SPK Number*</label> '
						append = append + '                        <input type="text" name="" id="" class="form-control" placeholder="PO/SPK Number" value="'+ result[0].no_po_customer +'">'
						append = append + '                      </div>'
						append = append + '                    </div>'
					append = append + '           </div>'

					append = append + '           <div class="form-group">'
						append = append + '              <label>Project Name*</label>'
						append = append + '              <input autocomplete="off" placeholder="Project Name" type="text" name="" class="form-control" id="" value="'+ result[0].project_id.name_project +'">'
					append = append + '            </div>'

					append = append + '            <div class="form-group">'
						append = append + '              	<label>Project Type*</label>'
						append = append + '                 	<div style="padding:10px;border:solid 1px #cccc;background: #eee;">'
						append = append + '                        <label style="margin-right: 15px;"><input autocomplete="off" type="checkbox" name="cbShowProjectCharterProjectType" value="supply_only" id=""> Supply Only</label>'
						append = append + '                        <label style="margin-right: 15px;"><input autocomplete="off" type="checkbox" name="cbShowProjectCharterProjectType" value="implementation" id=""> Implementation</label>'
						append = append + '                        <label><input autocomplete="off" type="checkbox" name="cbShowProjectCharterProjectType" id="" value="maintenance"> Maintenance & Managed Service</label>'
						append = append + '                   </div>'
						append = append + '           </div>'

						append = append + '           <div class="form-group">'
							append = append + '                   	<label>Project Owner*</label>'
							append = append + '                   	<input autocomplete="off" type="text" placeholder="Project Owner" name="" class="form-control" id="" value="'+ result[0].owner +'">'
						append = append + '           </div>'

						append = append + '           <div class="row">'
						append = append + '                    <div class="col-md-6">'
						append = append + '                      <div class="form-group">'
						append = append + '                        <label>Project Manager*</label>'
						append = append + '                        <select disabled class="form-control" id=""><option selected>'+ result[0].project_pm +'</option></select>'
						append = append + '                      </div> '
						append = append + '                    </div>'

						append = append + '                    <div class="col-md-6">'
						append = append + '                      <div class="form-group">'
						append = append + '                        <label>Project Coordinator*</label>'
						append = append + '                        <select disabled class="form-control" id=""><option selected>'+ result[0].project_pc +'</option></select>'
						append = append + '                      </div> '
						append = append + '                    </div>'
					append = append + '            </div>'

					append = append + '            <div class="form-group">'
						append = append + '              <label>Project Description*</label>'
						append = append + '              <textarea  autocomplete="off" type="number" name="" class="form-control" id="" placeholder="ex. 5" >'+ result[0].project_description +'</textarea>'
					append = append + '            </div>'

					append = append + '            <div class="form-group">'
						append = append + '               <label>Project Objectives*</label>'
						append = append + '               <textarea  autocomplete="off" type="number" name="" class="form-control" id="" placeholder="ex. 5" >'+ result[0].project_objectives +'</textarea>'
					append = append + '            </div> '

					append = append + '			<div class="form-group">'
						append = append + '      <label>Technology Use*</label>'
						append = append + '		<div class="row" style="border:solid 1px #cccc;padding-left:5px!important;padding: 10px;margin-bottom: 15px;background-color: #eee;margin:0px">'
							append = append + '  <div class="col-md-3 col-xs-12" style="padding-left:5px!important;">'
								append = append + '    <label class="form-check-label"><input autocomplete="off" disabled type="checkbox" name="cbShowProjectCharterTechUse" value="Data Center" class="form-check-input" id=""> Data Center</label><br>'
								append = append + '    <label class="form-check-label"><input autocomplete="off" disabled type="checkbox" name="cbShowProjectCharterTechUse" value="Security" class="form-check-input" id=""> Security</label><br>'
								append = append + '    <label class="form-check-label"><input autocomplete="off" disabled type="checkbox" name="cbShowProjectCharterTechUse" value="IoT" class="form-check-input" id=""> IoT</label>'
							append = append + '  </div>'

							append = append + '  <div class="col-md-5 col-xs-12" style="padding-left:5px!important">   '
								append = append + '    <label class="form-check-label"><input autocomplete="off" disabled type="checkbox" name="cbShowProjectCharterTechUse" value="ATM/CRM" class="form-check-input" id=""> ATM/CRM</label><br>'
								append = append + '    <label class="form-check-label"><input autocomplete="off" disabled type="checkbox" name="cbShowProjectCharterTechUse" value="Application Development" class="form-check-input" id=""> Application Development</label><br>'
								append = append + '    <label class="form-check-label"><input autocomplete="off" disabled type="checkbox" name="cbShowProjectCharterTechUse" value="Cloud Computing" class="form-check-input"id=""> Cloud Computing</label>'
							append = append + '  </div>'

							append = append + '  <div class="col-md-4 col-xs-12" style="padding-left:5px!important;">'
								append = append + '    <label class="form-check-label"><input autocomplete="off" disabled type="checkbox" name="cbShowProjectCharterTechUse" value="Borderless Network" class="form-check-input" id=""> Borderless Network</label><br>'
								append = append + '    <label class="form-check-label"><input autocomplete="off" disabled type="checkbox" name="cbShowProjectCharterTechUse" value="Collaboration" class="form-check-input" id=""> Collaboration</label>'
							append = append + '  </div>'
						append = append + '</div>'
					append = append + '			</div>'

					append = append + '			<div class="row">'
						append = append + '           <div class="col-md-4">'
							append = append + '                      <div class="form-group">'
							append = append + '                        <label>Estimated Start Date*</label>'
							append = append + '                        <div style="padding: 5px;border: solid 1px #ccc;background-color: #eee;">'

							append = append + '                        	<i class="bx bx-calendar" style="display: inline;"></i>&nbsp'
							append = append + '                        	<span style="display:inline;font-size:12px">'+ result[0].estimated_start_date +'</span>'
							append = append + '                        </div>'
							append = append + '                      </div>'
						append = append + '           </div>'

						append = append + '           <div class="col-md-4">'
							append = append + '                    	<div class="form-group">'
							append = append + '	                        <label>Estimated Finish Date*</label>'
							append = append + '	                        <div style="padding: 5px;border: solid 1px #ccc;background-color: #eee;">'

							append = append + '	                        	<i class="bx bx-calendar" style="display: inline;"></i>&nbsp'
							append = append + '	                        	<span style="display:inline;font-size:12px">'+ result[0].estimated_end_date +'</span>'
							append = append + '	                        </div>'
							append = append + '                      </div>'
						append = append + '           </div>'

						append = append + '           <div class="col-md-4">'
							append = append + '                      <div class="form-group">'
							append = append + '                        <label>Flexibility*</label>'
							append = append + '                        <input type="text" disabled name="flexibility" id="flexibility" class="form-control" value="'+ result[0].flexibility +'">'
							append = append + '                      </div>'
						append = append + '           </div>'
					append = append + '			</div>'

					append = append + '           <div class="form-group">'
						append = append + '             <label>Market Segment*</label>'
						append = append + '             <input type="text" disabled name="market_segment" id="market_segment" class="form-control" value="'+ result[0].market_segment +'">'
					append = append + '           </div>'

					append = append + '           <div class="form-group">'
						append = append + '                    <label>Scope of Work*</label>'
						append = append + '                    <textarea disabled class="form-control" id="" name="" placeholder="Scope of Work">'+ result[0].scope_of_work +'</textarea>'
					append = append + '           </div>'

					append = append + '           <div class="form-group">'
						append = append + '                    <label>Out Of Scope*</label> '
						append = append + '                    <textarea disabled class="form-control" id="" name="" placeholder="Out of Work">'+ result[0].out_of_scope +'</textarea>'
					append = append + '           </div>'

					append = append + '           <div class="form-group">'
						append = append + '                    <label>Customer Requirement*</label> '
						append = append + '                    <textarea disabled class="form-control" id="" name="" placeholder="Customer Requirement">'+ result[0].customer_requirement +'</textarea>'
					append = append + '           </div>'

					append = append + '           <div class="form-group">'
						append = append + '                    <label>Term of Payment*</label>'
						append = append + '                    <textarea disabled class="form-control" id="" name="" placeholder="Customer Requirement">'+ result[0].terms_of_payment +'</textarea>'
					append = append + '           </div>'

					append = append + '           <div class="form-group">'
						append = append + '                <label>Internal Stakeholder Register*</label>'
						append = append + '                <div class="table-responsive">'
						append = append + '                  	<table class="table" style="border-collapse:collapse;width: 100%;white-space: nowrap;" id="tbInternalStakeholderRegister">'
						append = append + '                    		<tr>'
						append = append + '                   			<th>Name</th>'
						append = append + '                    			<th>Roles</th>'
						append = append + '                    			<th>Phone</th>'
						append = append + '                    			<th>Email</th>'
						append = append + '                    		</tr>'
						append = append + '                    		<tbody id="tbodyIStakeholderShowProjectCharter">'
						append = append + '                    		</tbody>'
						append = append + '                   	</table>'
						append = append + '                 </div>'
					append = append + '           </div>'

						if (result[0].pid !== null){
							append = append + '                <div class="form-group">'
								append = append + '                    <label>SLA Project*</label>'
								append = append + '                    <div class="table-responsive">'
									append = append + '                    	<table class="table" style="border-collapse:collapse;width: 100%;white-space: nowrap;" id="tbInternalStakeholderRegister">'
									append = append + '                    		<tr>'
									append = append + '                    			<th>SLA Response</th>'
									append = append + '                    			<th>SLA Resolution Critical</th>'
									append = append + '                    			<th>SLA Resolution Major</th>'
									append = append + '                    			<th>SLA Resolution Moderate</th>'
									append = append + '                    			<th>SLA Resolution Minor</th>'
									append = append + '                    		</tr>'
									append = append + '                    		<tbody id="tbodySLAProjectCharter">'
									append = append + '                    		</tbody>'
									append = append + '                    	</table>'
								append = append + '                    </div>'
							append = append + '                </div>'
						}

				append = append + '	    	</fieldset>'
				append = append + '	    </div>'
				append = append + '	  </div>'
				append = append + '	</div>'

				append = append + '</div>'

				$("#showBodyProjectCharter").append(append)
    			

    			// $('input[type="checkbox"].minimal').iCheck({
			    //   checkboxClass: 'icheckbox_minimal-blue',
			    // })

    			$.each(result[0].type_project_array,function(item,value){
		            $("input[name='cbShowProjectCharterProjectType'][value='"+ value.project_type +"']").prop('checked',true)

		        })

			    $("input[name='cbShowProjectCharterProjectType']").prop("disabled",true).closest('div').css('cursor','not-allowed')

			    $("input[name='cbShowProjectCharterTechUse']").prop("disabled",true).closest('div').css('cursor','not-allowed')

			    $.each(result[0].technology_used,function(idx,item){
			    	$("input[name='cbShowProjectCharterTechUse'][value='"+ item.technology_used +"']").prop('checked',true)
			    })

			    if (result[0].project_type == 'implementation') {

			    }

				var appendSla = ""
				if(result[0].pid !== null || result[0].pid !== ""){
					let slaResponse = result[0].sla_response;
					let slaRsolutionCritical = result[0].sla_resolution_critical;
					let slaRsolutionMajor = result[0].sla_resolution_major;
					let slaRsolutionModerate = result[0].sla_resolution_moderate;
					let slaRsolutionMinor = result[0].sla_resolution_minor;

					let formattedSlaResponse = slaResponse < 1
							? Math.round(slaResponse * 60) + " Menit"
							: slaResponse + " Jam";

					let formattedSlaResolutionCritical = slaRsolutionCritical < 1
							? Math.round(slaRsolutionCritical * 60) + " Menit"
							: slaRsolutionCritical + " Jam";

					let formattedSlaResolutionMajor = slaRsolutionMajor < 1
							? Math.round(slaRsolutionMajor * 60) + " Menit"
							: slaRsolutionMajor + " Jam";
					let formattedSlaResolutionModerate = slaRsolutionModerate < 1
							? Math.round(slaRsolutionModerate * 60) + " Menit"
							: slaRsolutionModerate + " Jam";
					let formattedSlaResolutionMinor = slaRsolutionMinor < 1
							? Math.round(slaRsolutionMinor * 60) + " Menit"
							: slaRsolutionMinor + " Jam";

					appendSla = appendSla + '<tr>'
					appendSla = appendSla + '<td><input disabled type="text" name="" class="form-control" value="'+formattedSlaResponse+'"></td>'
					appendSla = appendSla + '<td><input disabled type="text" name="" class="form-control" value="'+formattedSlaResolutionCritical+'"></td>'
					appendSla = appendSla + '<td><input disabled type="text" name="" class="form-control" value="'+ formattedSlaResolutionMajor+'"></td>'
					appendSla = appendSla + '<td><input disabled type="text" name="" class="form-control" value="'+formattedSlaResolutionModerate+'"></td>'
					appendSla = appendSla + '<td><input disabled type="text" name="" class="form-control" value="'+formattedSlaResolutionMinor+'"></td>'
					appendSla = appendSla + '</tr>'

					$('#tbodySLAProjectCharter').append(appendSla)
				}

			    var appendRisk = ""

			    $.each(result[0].risk,function(idx,item){
			    	appendRisk = appendRisk + '						      	<div class="form-group">'
					appendRisk = appendRisk + '	                              <label>Risk Description</label>'
					appendRisk = appendRisk + '	                              <textarea class="form-control" id="" name="" placeholder="Risk Description">'+ item.risk_description +'</textarea>'
					appendRisk = appendRisk + '	                            </div>'
					appendRisk = appendRisk + '	                            <div class="row">'
					appendRisk = appendRisk + '	                              <div class="col-md-6 col-xs-12">'
					appendRisk = appendRisk + '	                                <div class="form-group">'
					appendRisk = appendRisk + '	                                  <label>Owner</label> '
					appendRisk = appendRisk + '	                                  <input type="text" class="form-control" id="" name="" placeholder="Owner" value="'+ item.risk_owner +'"/>'
					appendRisk = appendRisk + '	                                </div>'
					appendRisk = appendRisk + '	                              </div>'
					appendRisk = appendRisk + '	                              <div class="col-md-3 col-xs-12">'
					appendRisk = appendRisk + '	                                <div class="form-group">'
					appendRisk = appendRisk + '	                                  <label>Impact</label> '
					appendRisk = appendRisk + '	                                  <input max="5" min="1" type="number" class="form-control" id="" name="" placeholder="1-5" value="'+ item.impact +'"/>'
					appendRisk = appendRisk + '	                                </div>'
					appendRisk = appendRisk + '	                              </div>'
					appendRisk = appendRisk + '	                              <div class="col-md-3 col-xs-12">'
					appendRisk = appendRisk + '	                                <div class="form-group">'
					appendRisk = appendRisk + '	                                  <label>Likelihood</label> '
					appendRisk = appendRisk + '	                                  <input max="5" min="1" type="number" class="form-control" id="" name="" placeholder="1-5" value="'+ item.likelihood +'"/>'
					appendRisk = appendRisk + '	                                </div>'
					appendRisk = appendRisk + '	                              </div>'
					appendRisk = appendRisk + '	                            </div>'
					// appendRisk = appendRisk + '	                            <div class="form-group">'
					// appendRisk = appendRisk + '	                              <label>Rank</label>'
					// appendRisk = appendRisk + '	                              <input class="form-control" placeholder="Rank" id="" value="'+ item.rank +'" />'
					// appendRisk = appendRisk + '	                            </div>'
					appendRisk = appendRisk + '	                            <div class="form-group">'
					appendRisk = appendRisk + '	                              <label>Impact Description</label>'
					appendRisk = appendRisk + '	                              <textarea class="form-control" placeholder="Impact Description" id="" >'+ item.impact_description +'</textarea>'
					appendRisk = appendRisk + '	                            </div>'
					appendRisk = appendRisk + '	                            <div class="row">'
					appendRisk = appendRisk + '	                                <div class="col-md-12 col-xs-12">'
					appendRisk = appendRisk + '	                                  <div class="form-group">'
					appendRisk = appendRisk + '	                                    <label>Response</label> '
					appendRisk = appendRisk + '	                                    <textarea class="form-control" id="" name="" placeholder="Risk Response">'+ item.risk_response +'</textarea>'
					appendRisk = appendRisk + '	                                  </div>'
					appendRisk = appendRisk + '	                                </div>'
					appendRisk = appendRisk + '	                            </div>'
					appendRisk = appendRisk + '	                            <div class="row">'
					appendRisk = appendRisk + '	                              <div class="col-md-4 col-xs-12">'
					appendRisk = appendRisk + '	                                <div class="form-group">'
					appendRisk = appendRisk + '	                                  <label>Due Date</label>'
					appendRisk = appendRisk + '	                                  <div class="input-group">'

					appendRisk = appendRisk + '	                                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>'
					appendRisk = appendRisk + '	                                    <input type="text" name="" class="form-control" id="" value="'+ item.due_date +'"/>'
					appendRisk = appendRisk + '	                                  </div>'
					appendRisk = appendRisk + '	                                </div>'
					appendRisk = appendRisk + '	                              </div>'
					appendRisk = appendRisk + '	                              <div class="col-md-4 col-xs-12">'
					appendRisk = appendRisk + '	                                <div class="form-group">'
					appendRisk = appendRisk + '	                                  <label>Review Date</label>'
					appendRisk = appendRisk + '	                                  <div class="input-group">'

					appendRisk = appendRisk + '	                                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>'
					appendRisk = appendRisk + '	                                    <input type="text" name="" class="form-control" id="" value="'+ item.review_date +'"/>'
					appendRisk = appendRisk + '	                                  </div>'
					appendRisk = appendRisk + '	                                </div>'
					appendRisk = appendRisk + '	                              </div>'
					appendRisk = appendRisk + '	                              <div class="col-md-4 col-xs-12">'
					appendRisk = appendRisk + '	                                <div class="form-group">'
					appendRisk = appendRisk + '	                                  <label>Status</label>'
					appendRisk = appendRisk + '	                                  <select class="form-control" id="">'
					appendRisk = appendRisk + '	                                    <option selected>'+ item.status +'</option>'
					appendRisk = appendRisk + '	                                  </select>'
					appendRisk = appendRisk + '	                                </div>'
					appendRisk = appendRisk + '	                              </div>'
					appendRisk = appendRisk + '	                            </div>'
					appendRisk = appendRisk + '<hr>'
			    })

				$("#showRiskProjectCharter").append(appendRisk)

				var appendTbody = ""

				$.each(result[0].internal_stakeholder.data,function(idx,item){
					appendTbody = appendTbody + ' <tr>'
					appendTbody = appendTbody + '  <td><input disabled type="text" name="" class="form-control" value="'+ item.name +'"></td>'
					appendTbody = appendTbody + '  <td><input disabled type="text" name="" class="form-control" value="'+ item.role +'"></td>'
					appendTbody = appendTbody + '  <td><input disabled type="text" name="" class="form-control" value="'+ item.email +'"></td>'
					appendTbody = appendTbody + '  <td><input disabled type="text" name="" class="form-control" value="'+ item.phone +'"></td>'
					appendTbody = appendTbody + ' </tr>'

				})

				$("#tbodyIStakeholderShowProjectCharter").append(appendTbody)

				if (result[0].get_sign == '{{Auth::User()->name}}') {
					
					if (true) {}
					$("#btnApproveSign").show()
				}else{
					$("#btnRejectNotes").attr('style','display:none!important')
				}

			    $("#btnApproveSign").click(function(){
			   		Swal.fire({
			            title: 'Are you sure?',
			            text: "Approve this Project Charter",
			            icon: 'warning',
			            showCancelButton: true,
			            confirmButtonColor: '#3085d6',
			            cancelButtonColor: '#d33',
			            confirmButtonText: 'Yes',
			            cancelButtonText: 'No',
			        }).then((result) => {
			            if (result.value) {
			              $.ajax({
			                url: "{{'/PMO/approveProjectCharter'}}",
			                type: 'post',
			                data:{
			                  _token:"{{ csrf_token() }}",
			                  id_pmo:window.location.href.split("/")[5].split("?")[0],
			                },
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
				                  	didOpen: () => {
				                      Swal.showLoading()
				                  	}
				              	})
				            },
			                success: function(data)
			                {
			                  Swal.showLoading()
			                  Swal.fire(
			                      'Project Charter has been Approve!',
			                      'Successfully',
			                      'success'
			                  ).then((result) => {
			                      if (result.value) {
			                      	window.
			                        location.replace('/PMO/project')
			                      }
			                  })
			                }
			              });
			            }
			        })
			   	})
    		}
    	})
    }

    function btnRejectNotes(value){
    	
    	if (value == 'ModalFinal') {
    		$("#ModalFinalProject").modal('hide')
    		$(".modal-title").text("Reject Notes")
    	}
    	$("#ModalReject").modal("show")
    	$("#saveReasonReject").attr("value",value)
    }

    $("#saveReasonReject").click(function(){
    	if ($("#rejectNotes").val() == "") {
    		$("#rejectNotes").closest("div").addClass("needs-validation")
        	$("#rejectNotes").next("span").show()
    	}else{
    		if (this.value == 'ModalFinal') {
    			swalAlert = {
    				title: 'Are you sure?',
		            text: "Reject this Final Report",
		            icon: 'warning',
		            showCancelButton: true,
		            confirmButtonColor: '#3085d6',
		            cancelButtonColor: '#d33',
		            confirmButtonText: 'Yes',
		            cancelButtonText: 'No',
    			}

    			url = "{{'/PMO/rejectFinalReport'}}"
    		}else{
    			swalAlert = {
    				title: 'Are you sure?',
		            text: "Reject this Project Charter",
		            icon: 'warning',
		            showCancelButton: true,
		            confirmButtonColor: '#3085d6',
		            cancelButtonColor: '#d33',
		            confirmButtonText: 'Yes',
		            cancelButtonText: 'No',
    			}

    			url = "{{'/PMO/rejectProjectCharter'}}"
    		}

    		Swal.fire(swalAlert).then((result) => {
	            if (result.value) {
	              $.ajax({
	                url: url,
	                type: 'post',
	                data:{
	                  _token:"{{ csrf_token() }}",
	                  id_pmo:window.location.href.split("/")[5].split("?")[0],
	                  reason:$("#rejectNotes").val()
	                },
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
		                  	didOpen: () => {
		                      Swal.showLoading()
		                  	}
		              	})
		            },
	                success: function(data)
	                {
	                  Swal.showLoading()
	                  Swal.fire(
	                      'Document has been rejected with notes!',
	                      'Successfully',
	                      'success'
	                  ).then((result) => {
	                      if (result.value) {
	                        window.location.href = "{{url('PMO/project')}}";
	                      }
	                  })
	                }
	              });
	            }
	        })
    	}
   	})

    let arrReason = []
  	function reasonReject(item,display,nameClass,typeCallout=""){
	    $(".divReasonRejectRevision").remove()
	      arrReason.push(item)

	      var textTitle = ""
	      var className = ""

	      if (nameClass == 'tabGroup') {
	        textTitle = "Note Final Report!"
	        className = "tabGroup"
	      }

	      var append = ""
	      
	      append = append + '<div class="callout callout-danger divReasonRejectRevision" style="display:none!important">'

	        append = append + '<h6><i class="icon bx bx-cross"></i>'+ textTitle +'</h6>'
	        if (arrReason.length > 0) {
	        	$.each(arrReason,function(item,value){
		          append = append + '<p class="reason_reject_revision">'+ value.split(":")[0] + ":<br>" + "- " + value.split(":")[1].replaceAll("\n","<br>")+'</p>'
		        })
	        }
	        
	      append = append + '</div>'

	      $("." + nameClass).prepend(append)
	      

	      if (display == "block") {
	        $(".divReasonRejectRevision").show()
	    }
  	}

    $("#tbIssue").DataTable({
    	"ajax":{
          "type":"GET",
          "url":"{{url('/PMO/getIssue')}}",
          "data":{
          	"id_pmo":window.location.href.split("/")[5].split("?")[0]
          }
        },
        "columns": [
            { 
            	title:"No",
              	render: function (data, type, row, meta){
                	return ++meta.row
              	}
            },
            { 
            	title:"Issue Description",
            	data:"issue_description"
            },
            { 
            	title:"Solution Plan",
            	data:"solution_plan" 
            },
            { 
            	title:"Owner",
            	data:"owner" 
            },
            { 
            	title:"Rating/Severity",
            	data:"rating_severity",
            	width:10
            },
            { 
            	title:"Expected/Actual Solved Date",
              	render: function (data, type, row, meta){
              		if (row.actual_date == null) {
                		return row.expected_date + '/ TBA' 
              		}else{
                		return row.expected_date + '/' + row.actual_date 
              		}
             	}
            },
            { 
            	title:"Status",
            	data:"status"
            },
            { 
            	title:"Action",
              	render: function (data, type, row, meta){

                	return '<button class="btn btn-xs btn-warning" name="btnUpdateStatusIssue" onclick="btnUpdateStatusIssue('+ row.id +')" disabled><i class="bx bx-edit"></i>&nbspUpdate</button>'
              	}
            },
        ],
        drawCallback: function(settings) {
	        if (accesable.includes("btnAddIssue")) {
	          $("button[name='btnUpdateStatusIssue']").prop("disabled",false)	
	        }else{
            	gantt.config.disabled = true;
	        }
      	},
      	"columnDefs": [{
		    "targets": 4,
		    "createdCell": function (td, cellData, rowData, row, col) {
		      if ( cellData >= 1 && cellData <= 5) {
		        $(td).css('background-color', '#3C79F5')
		        $(td).css('color', '#FFFFFF')

		      }else if ( cellData >= 6 && cellData <= 10) {
		        $(td).css('background-color', '#54B435')
		        $(td).css('color', '#FFFFFF')

		      }if ( cellData >= 11 && cellData <= 15) {
		        $(td).css('background-color', '#FFEA20')
		        $(td).css('color', '#FFFFFF')

		      }if ( cellData >= 16 && cellData <= 20) {
		        $(td).css('background-color', '#F49D1A')
		        $(td).css('color', '#FFFFFF')

		      }else if (cellData >= 21 && cellData <= 25) {
		        $(td).css('background-color', '#DC0000')
		        $(td).css('color', '#FFFFFF')

		      }
		    }
		}]
    })

    $("#inputRatingIssue").keyup(function(){
    	if (this.value > 5) {
    		$("#inputRatingIssue").val("")
    	}
    })

    $("#inputImpact").keyup(function(){
    	if (this.value > 5) {
    		$("#inputImpact").val("")
    	}
    })

    $("#inputLikelihood").keyup(function(){
    	if (this.value > 5) {
    		$("#inputLikelihood").val("")
    	}
    })

    $("#tbRisk").DataTable({
    	"ajax":{
          "type":"GET",
          "url":"{{url('/PMO/getRisk')}}",
          "data":{
          	"id_pmo":window.location.href.split("/")[5].split("?")[0]
          }
        },
        "columns": [
            { 
              render: function (data, type, row, meta){
                return ++meta.row
              }
            },
            { "data":"risk_description" },
            { "data":"risk_owner"},
            { "data":"impact" },
            { "data":"likelihood" },
            { "data":"impact_rank" },
            { 
            	render: function(data, type, row, meta){
            		return row.impact_description.replaceAll('\n','<br>')
            	}
            },
            { 
            	render: function(data, type, row, meta){
            		return row.risk_response.replaceAll('\n','<br>')
            	}
            },
            { "data":"due_date" },
            { "data":"review_date"},
            { "data":"status" },
            { 
              render: function (data, type, row, meta){

                return '<button class="btn btn-xs btn-warning" name="btnUpdateStatusRisk" disabled onclick="btnUpdateStatusRisk('+ row.id +')"><i class="bx bx-edit"></i>&nbspUpdate</button>'
              }
            },
        ],
        drawCallback: function(settings) {
	        if (accesable.includes("btnAddIssue")) {
	          $("button[name='btnUpdateStatusRisk']").prop("disabled",false)
	        }
      	},
  //     	"createdRow": function( row, data, dataIndex ) {
  //     		console.log(row)
		//     if (  data.impact_rank > 5 && data.impact_rank < 10 ) {
		//     	console.log("wow")
		//       $(row).addClass( 'rowColorGreen' )
		//     }else if (data.impact_rank > 10) {
		//       $(row).addClass( 'rowColorRed' )
		//     }
		// },
		"columnDefs": [{
		    "targets": 5,
		    "createdCell": function (td, cellData, rowData, row, col) {
		      if ( cellData >= 1 && cellData <= 5) {
		        $(td).css('background-color', '#3C79F5')
		        $(td).css('color', '#FFFFFF')

		      }else if ( cellData >= 6 && cellData <= 10) {
		        $(td).css('background-color', '#54B435')
		        $(td).css('color', '#FFFFFF')

		      }if ( cellData >= 11 && cellData <= 15) {
		        $(td).css('background-color', '#FFEA20')
		        $(td).css('color', '#FFFFFF')

		      }if ( cellData >= 16 && cellData <= 20) {
		        $(td).css('background-color', '#F49D1A')
		        $(td).css('color', '#FFFFFF')

		      }else if (cellData >= 21 && cellData <= 25) {
		        $(td).css('background-color', '#DC0000')
		        $(td).css('color', '#FFFFFF')

		      }
		    }
		}]
    })

    let table = $("#tbStageWeekly").DataTable({
    	"ajax":{
          "type":"GET",
          "url":"{{url('/PMO/getStageWeekly')}}",
          "data":{
          	"id_pmo":window.location.href.split("/")[5].split("?")[0]
          }
        },
        "columns": [
            { 
            	title:"No",
              	render: function (data, type, row, meta){
                	return ++meta.row
              	}
            },
            { 
            	// data:"milestone" 
            	render: function (data, type, row, meta){
              		let warning = ''
              		if (row.deliverable_document == "true") {
              			warning = '<small style="color:red">Deliverable document is required!</small>'
              		}else if(row.deliverable_document == "tentative"){
              			warning = '<small style="color:red">Please upload deliverable document if it ready!</small>'
              		}
                	return row.milestone + '<br>' + warning
              	}
            },
            { 
            	data:"text_parent" 
            },
            { 
            	data:"periode"
            },
            { 
            	title:"Action",
              	render: function (data, type, row, meta){
                	if (row.deliverable_document == "true") {
                		return '<input type="checkbox" disabled name="cbTaskDone" id="cbTaskDone" value="'+ row.id_gantt +'"> Task Done'
              		}else{
                		return '<input type="checkbox" name="cbTaskDone" id="cbTaskDone" value="'+ row.id_gantt +'"> Task Done'
              		}
              	}
            },
        ],
        "rowCallback": function( row, data ) {
      		if (accesable.includes("cbTaskDone")) {
          		if (data.deliverable_document != "true") {
          			$('td:eq(4)', row).html( '<input type="checkbox" name="cbTaskDone" id="cbTaskDone" value="'+ data.id_gantt +'"> Task Done');
          			// $("input[name='cbTaskDone'][value="+ data.id_gantt +"]").prop("disabled",false)
          			// $("input[name='cbTaskDone'][value="+ data.id_gantt +"]").closest("div").removeClass("disabled").prop("disabled",false)
          		}else{
          			$("input[name='cbTaskDone']").closest("div").css("cursor","not-allowed")	          
          		}
      		}else{
          		$("#cbTaskDone").closest("div").css("cursor","not-allowed")

      		}
		    // if (table.row(0).data().milestone == "Submit Final Project Closing Report") {
		    //   $("#btnFinalProject").prop("disabled",false)
		    // }
		    },
        drawCallback: function(settings) {
        	if (!accesable.includes("cbTaskDone")) {	
	        	var api = this.api();
	          api.columns(4).visible(false);    
	        }


	        // $('input[type="checkbox"].minimal').iCheck({
		    //   checkboxClass: 'icheckbox_minimal-blue',
		    // })

		    $('#tbStageWeekly #cbTaskDone').on('change', function() {
		    	if ($(this).prop('checked')) {
				    Swal.fire({
			            title: 'Are you sure?',
			            text: "Finish this task",
			            icon: 'warning',
			            showCancelButton: true,
			            confirmButtonColor: '#3085d6',
			            cancelButtonColor: '#d33',
			            confirmButtonText: 'Yes',
			            cancelButtonText: 'No',
			        }).then((result) => {
			            if (result.value) {
			            	$(this).prop("disabled",true)
			    			$(this).closest("div").css("cursor","not-allowed")
			              	$.ajax({
				                url: "{{'/PMO/updateStatusTask'}}",
				                type: 'post',
				                data:{
				                  _token:"{{ csrf_token() }}",
				                  id_task:$(this).closest("tr").find("td:nth-child(5)").find("input").attr("value"),
				                  id_pmo:window.location.href.split("/")[5].split("?")[0]
				                },
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
					                  	didOpen: () => {
					                      Swal.showLoading()
					                  	}
					              	})
					            },
				                success: function(data)
				                {
				                  Swal.showLoading()
				                  Swal.fire(
				                      'Congratulation!',
				                      'You`ve worked hard. Stay on track and let`s finish your next task',
				                      'success'
				                  ).then((result) => {
				                      if (result.value) {
				                        location.reload()
				                      }
				                  })
				                }
				            });
			            }else{
			            	$(this).prop('checked',false)
			            }
			        })
			    }
			});
      	},
    })

    function btnUploadNewDocument(){
    	$("#ModalUploadNewDocument").modal("show")
    	$(".modal-title").text("Upload Document")

    	$.ajax({
    		url: "{{'/PMO/getDeliverableDocument'}}",
            type: 'GET',
            data:{
              id_pmo:window.location.href.split("/")[5].split("?")[0],
            },success:function(result){
            	$('#sub_task_document').select2({
            		dropdownParent:$("#ModalUploadNewDocument"),
		            data:result.data,
		            placeholder:"Select Sub Task",
		        });
            }
    	})
    	
    }

    let incrementDoc = 0
    function addDocPendukung(){
      incrementDoc++

      append = ""
      append = append + '<tr class="trDoc" style="margin-top:5px">'
      append = append + '<td>'
	  append = append + '<div class="form-group">'
      append = append + '<span style="display: inline;'
      append = append + '"'
      append = append + 'class="btnRemoveDoc_'+ incrementDoc +'"'

      append = append + '><i class="bx bx-x" style="'
      append = append + '    margin-top: 10px;'
      append = append + '    color: red;'
      append = append + '"></i>'
      append = append + '</span>'

      append = append + '    &nbsp;<div style="display: inline;float: right;padding:5px;border:solid 1px #cccc;width: 280px;"> <label for="inputDoc_'+ incrementDoc +'" class="bx bx-upload" id="title_doc_'+ incrementDoc +'" data-value="'+ incrementDoc +'">&nbsp; <span>Upload Document</span> <input type="file" class="document" name="inputDoc" onchange="validationCheck(this)" id="inputDoc_'+ incrementDoc +'" data-value="'+ incrementDoc +'" style="display: none;color:red"></label></div><span class="invalid-feedback" style="display:none!important;color:red">Please upload document!</span></div>' 
      append = append + '  </td>'
      append = append + '  <td>'
	  append = append + '<div class="form-group">'
      append = append + '   <input placeholder="Document Name" onkeyup="validationCheck(this)" name="inputDocName" type="text" id="inputDocTitle_'+ incrementDoc +'" class="form-control" style="width:250px" data-value="'+ incrementDoc +'"><span class="invalid-feedback" style="display:none!important;color:red">Please fill document name!</span></div>'
      append = append + '  </td>'
      append = append + '</tr>'
      $("#tableUploadDoc").append(append) 

      $("#btnAddDoc").prop("disabled",true) 
      $("#tableUploadDoc .trDoc").each(function(){
        let inputData = $(this)
        
        $("#inputDoc_"+ $(this).find('input[name="inputDoc"]').attr('data-value')).change(function(){
          
          if (this.value != "") {
            $("#title_doc_"+ inputData.find('input[name="inputDoc"]').attr('data-value')).find("span").remove()
            $("#inputDoc_"+ inputData.find('input[name="inputDoc"]').attr('data-value')).css("display","inline")
          }
        })

        $('#inputDocTitle_'+ inputData.find('input[name="inputDoc"]').attr('data-value')).keydown(function(){
          
          
          if (this.value == "") {
            $("#btnAddDoc").prop("disabled",true)
          }else{
            $("#btnAddDoc").prop("disabled",false)
          }
        })  

        $(".btnRemoveDoc_"+inputData.find('input[name="inputDoc"]').attr('data-value')).click(function(){
          let incrementDocBefore = parseInt(inputData.find('input[name="inputDoc"]').data('value'))-1
          
          $(".btnRemoveDoc_"+inputData.find('input[name="inputDoc"]').data('value')).closest("tr").remove();
          if ($("#inputDocTitle_"+ incrementDocBefore).val() == "") {
            $("#btnAddDoc").prop("disabled",true)
          }else{
            $("#btnAddDoc").prop("disabled",false)
          }


          // Swal.fire({
          //   title: 'Are you sure?',
          //   text: "Deleting document",
          //   icon: 'warning',
          //   showCancelButton: true,
          //   confirmButtonColor: '#3085d6',
          //   cancelButtonColor: '#d33',
          //   confirmButtonText: 'Yes',
          //   cancelButtonText: 'No',
          // }).then((result) => {
          //     if (result.value) {
          //       $.ajax({
          //         type:"POST",
          //         url:"{{url('/admin/deleteDokumen/')}}",
          //         data:{
          //           _token:"{{ csrf_token() }}",
          //           id:this.value
          //         },beforeSend:function(){
          //           Swal.fire({
          //               title: 'Please Wait..!',
          //               text: "It's sending..",
          //               allowOutsideClick: false,
          //               allowEscapeKey: false,
          //               allowEnterKey: false,
          //               customClass: {
          //                   popup: 'border-radius-0',
          //               },
          //               didOpen: () => {
          //                   Swal.showLoading()
          //               }
          //           })
          //         },
          //         success: function(data)
          //         {
          //           Swal.showLoading()
          //           Swal.fire(
          //               'Document has been deleted!',
          //               'You can adding another document files',
          //               'success'
          //           ).then((result) => {
          //             if (result.value) {
          //               $(".btnRemoveDoc_"+incrementDoc).closest("tr").remove();
          //             }
          //           })
          //         }
          //       })
          //     }
          // })
        })

      })   
    }    

    $("#inputDoc_0").change(function(){      
      if (this.value != "") {
        $("#title_doc_0").find("span").remove()
        $("#inputDoc_0").css("display","inline")
      }
    })

    function btnAddIssue(id){
    	$("input[name='expected_date'],input[name='actual_date']").flatpickr({
    		autoclose:true
    	})

      	$("#ModalIssue").find('form').find("input[type=text],input[type=number],input[type=email],input[type=file],textarea,select").val("")
    	$(".select2").select2()
    	$("#ModalIssue").modal("show")
    	$(".modal-title").text("Issue & Problems")

		$("#selectStatusIssue").select2({
			placeholder:"Select Issue",
			dropdownParent:$("#ModalIssue")
		})

    	$("#expected_date,#actual_date").flatpickr()
    }

    function btnAddRisk(result){
    	$("input[name='due_date'],input[name='review_date']").flatpickr({
    		autoclose:true
    	})

      	$("#ModalRisk").find('form').find("input[type=text],input[type=number],input[type=email],input[type=file],textarea,select").val("")
    	$(".select2").select2()
    	$("#ModalRisk").modal("show")
    	$(".modal-title").text("Risk")
    }

    function btnUpdateStatusRisk(id){
    	$("input[name='due_date'],input[name='review_date']").flatpickr({
    		autoclose:close
    	})

    	$.ajax({
    		url:"{{url('/PMO/getDetailRisk')}}",
    		type:"GET",
    		data:{
    			id:id
    		},success:function(result){
    			$("#id_risk").val(result[0].id)
    			$("#textAreaRisk").val(result[0].risk_description)
    			$("#inputOwner").val(result[0].risk_owner)
    			$("#inputImpact").val(result[0].impact)
    			$("#inputLikelihood").val(result[0].likelihood)
    			$("#inputRank").val(result[0].impact_rank)
    			$("#textareaDescription").val(result[0].impact_description)
    			$("#textareaResponse").val(result[0].risk_response)
    			$("#due_date").val(moment(result[0].due_date).format('MM/DD/YYYY'))
    			$("#review_date").val(moment(result[0].review_date).format('MM/DD/YYYY'))
    			$("#selectStatusRisk").select2().val(result[0].status.toLowerCase()).trigger("change")

    			$("#selectStatusRisk").select2({
		    		dropdownParent:$("#ModalRisk")
		    	})
    		}
    	})

    	$("#ModalRisk").modal("show")	
    	$(".modal-title").text("Update Risk")
    }

    function btnUpdateStatusIssue(id){
    	$("input[name='expected_date'],input[name='actual_date']").flatpickr({
    		autoclose:true
    	})

    	$.ajax({
    		url:"{{url('/PMO/getDetailIssue')}}",
    		type:"GET",
    		data:{
    			id:id
    		},success:function(result){
    			$("#id_issue").val(result[0].id)
    			$("#textareaDescIssue").val(result[0].issue_description)
    			$("#textareaSolutionPlan").val(result[0].solution_plan)
    			$("#inputOwnerIssue").val(result[0].owner)
    			$("#inputRatingIssue").val(result[0].rating_severity)
    			$("#expected_date").val(moment(result[0].expected_date).format('MM/DD/YYYY'))
    			$("#actual_date").val(moment(result[0].actual_date).format('MM/DD/YYYY'))
    			$("#selectStatusIssue").select2().val(result[0].status).trigger("change")

    			$("#selectStatusIssue").select2({
		    		placeholder:"Select Issue",
		    		dropdownParent:$("#ModalIssue")
		    	})
    		}
    	})

    	$("#ModalIssue").modal("show")	
    	$(".modal-title").text("Update Issue & Problems")
    }

    let incrementIssue = 0
    function addIssueWeekly(){
		incrementIssue++

    	append = ""
		append = append +'<tr>'
		append = append +'<td>'

		append = append + '<i class="bx bx-trash pull-right btnRemove" style="color:red" id="btnRemoveIssueWeekly"></i>'
		append = append +'	<div class="form-group">'
		append = append +'      		<label>Issue Description</label>'
		append = append +'      		<textarea class="form-control" data-value="' + incrementIssue +'" id="textAreaIssueDesc" name="textAreaIssueDesc" placeholder="Describe summary of progress project during this period" onkeyup="validationCheck(this)"></textarea>'
		append = append +'     			<span class="invalid-feedback" style="display:none!important;">Please fill Issue Description!</span>'
		append = append +'      	</div>'
		append = append +'      	<div class="form-group">'
		append = append +'      		<label>Solution Plan</label>'
		append = append +'      		<textarea class="form-control" data-value="' + incrementIssue +'" id="textareaSolutionPlanIssue" name="textareaSolutionPlanIssue" placeholder="Describe summary of progress project during this period" onkeyup="validationCheck(this)"></textarea>'
		append = append +'     			<span class="invalid-feedback" style="display:none!important;">Please fill Solution Plan!</span>'
		append = append +'      	</div>'
		append = append +'      	<div class="form-group">'
		append = append +' 				<label>Owner</label>'
		append = append +' 				<input type="text" data-value="' + incrementIssue +'" class="form-control" name="inputOwnerIssue" id="inputOwnerIssue" placeholder="Owner" onkeyup="validationCheck(this)">'
		append = append +'     			<span class="invalid-feedback" style="display:none!important;">Please fill Owner!</span>'
		append = append +' 			</div>'
		append = append +'      	<div class="row">'
		append = append +'      		<div class="col-md-3">'
		append = append +'      			<div class="form-group">'
		append = append +'      				<label>Rating/Severity* </label>'
		append = append +'      				<input type="number" data-value="' + incrementIssue +'" class="form-control" name="inputRatingIssue" onkeyup="validationCheck(this)" id="inputRatingIssue" placeholder="1-5" max="5" min="1">'
		append = append +'     					<span class="invalid-feedback" style="display:none!important;">Please fill Rating!</span>'
		append = append +'      			</div>'
		append = append +'      		</div>	'
		append = append +'      		<div class="col-md-3">'
		append = append +'      			<div class="form-group">'
		append = append +'      				<label>Expected Solved Date*</label>'
		append = append +'                  <div class="input-group">'

		append = append +'                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>'

		append = append +'                    <input type="text" data-value="' + incrementIssue +'" name="expected_date_issue" id="expected_date_issue" class="form-control" placeholder="Select Expected Date" onchange="validationCheck(this)"/>'
		append = append +'                	 </div>'
		append = append +'                   <span class="invalid-feedback" style="display:none!important;">Please fill Expected Solved Date!</span>'
		append = append +'      			</div>'
		append = append +'               </div>'
		append = append +'               <div class="col-md-3">'
		append = append +'               	<div class="form-group">'
		append = append +'               		<label>Actual Solved Date</label>'
		append = append +'                   <div class="input-group">'

		append = append +'                     <span class="input-group-text"><i class="bx bx-calendar"></i></span>'
		append = append +'                     <input type="text" data-value="' + incrementIssue +'" name="actual_date_issue" id="actual_date_issue" class="form-control" placeholder="Select Actual Date"onchange="validationCheck(this)"/>'
		append = append +'                   </div>'
		append = append +'                    <span class="invalid-feedback" style="display:none!important;">Please fill Actual Solved Date!</span>'
		append = append +'               	</div>'
		append = append +'               </div>	'
		append = append +'      		<div class="col-md-3">'
		append = append +'      			<div class="form-group">'
		append = append +'      				<label>Status</label>'
		append = append +'      				<select data-value="' + incrementIssue +'" class="form-control" name="status_issue" id="status_issue" style="width:100%" onchange="validationCheck(this)">'
		append = append +'      					<option value="open">Open</option>'
		append = append +'      					<option value="close">Close</option>'
		append = append +'      				</select>'
		append = append +'     					<span class="invalid-feedback" style="display:none!important;">Please fill Status!</span>'
		append = append +'      			</div>'
		append = append +'      		</div>	'
		append = append +'      	</div>'
		append = append +'</td>'
		append = append +'/tr>'

		$("#tbodyWeeklyIssue").append(append)

		$("input[name='due_date_issue']").flatpickr({
			autoclose:true
		})

		$(".select2").select2()
		
    }

    $(".help-btn-rating,.help-btn-likelihood,.help-btn-impact").click(function() {
    // Animation complete.
    	
    	if ($("#divInfoRisk").length == 0 || $("#divInfoImpact").length == 0 && $("#divInfoIssue").length == 0 ) {
    		if ($(this).attr('value') == 'rating') {
    			if ($("#divInfoIssue").length == 0) {
	    			$("#inputRatingIssue").closest(".row").after("<div class='form-group' id='divInfoIssue'> (5) <b>Critical</b> - Disaster with potential to lead to business failure.<br>(4) <b>Major</b> - Major event which will be endured with proper management.<br>(3) <b>Moderate</b> - Significant event which can be managed under normal circumstances.<br>(2) <b>Minor</b> - Event with consequences which can be readily absorbed but requires management effort to minimise the impact.<br>(1) <b>Insignificant</b> - Low level risk. Existing controls and procedures will cope with event.</div>")
	    		}else{
	    			
	    			if ($('#divInfoIssue').is(':hidden')) {
		    			$("#divInfoIssue").show()
		    		}else{
		    			$("#divInfoIssue").attr('style','display:none!important')
	    			}
	    		}	    		

    		}else {
    			if ($("#divInfoImpact").length == 0) {
    				$("#selectStatusRisk").closest(".row").after("<div class='form-group' id='divInfoImpact'> (5) <b>Critical</b> - Disaster with potential to lead to business failure.<br>(4) <b>Major</b> - Major event which will be endured with proper management.<br>(3) <b>Moderate</b> - Significant event which can be managed under normal circumstances.<br>(2) <b>Minor</b> - Event with consequences which can be readily absorbed but requires management effort to minimise the impact.<br>(1) <b>Insignificant</b> - Low level risk. Existing controls and procedures will cope with event.</div>")
    			
    				
    			}
    			
    			if ($("#divInfoRisk").length == 0) {
    				$("#selectStatusRisk").closest(".row").after("<div class='form-group' id='divInfoRisk'>(5) <b>Almost certain</b> - The event is expected to occur in most circumstances (daily / weekly)High level of known incidents (records / experiences)Strong likelihood of re-occurring, with high opportunities / means to re-occur<br>(4) <b>Likely</b> - The event will probably occur in most circumstances (monthly) Regular incidents known (recorded / experienced) Considerable opportunity, means to occur<br>(3) <b>Moderate</b> - The event should occur at some time (over 12 months) Few infrequent, random occurrences (recorded / experienced)Some opportunity or means to occur<br>(2) <b>Unlikely</b> - The event could occur at some time (2-5 years)No known incidents recorded or experienced Little opportunity, mean or reason to occur<br>(1) <b>Rare</b> - The event may occur only in exceptional circumstances (10 years) Highly unheard of Almost no opportunity to occur</div>")

    			}


				if ($(this).attr('value') == 'impact') {
    				$("#divInfoRisk").attr('style','display:none!important')
    			}

    			if ($(this).attr('value') == 'likelihood') {
    				$("#divInfoImpact").attr('style','display:none!important')
    			}
    			

    			
    		}
    		

    		// $("#inputRatingIssue").closest(".row").after("<div class='form-group' id='divInfoIssue'> (5)<b>Critical</b> - Disaster with potential to lead to business failure.<br>(4) <b>Major</b> - Major event which will be endured with proper management.<br>(3) <b>Moderate</b> - Significant event which can be managed under normal circumstances.<br>(2)<b>Minor</b> - Event with consequences which can be readily absorbed but requires management effort to minimise the impact.<br>(1) <b>Insignificant</b> - Low level risk. Existing controls and procedures will cope with event.</div>")
    	}else{
    		if ($(this).attr('value') == 'impact') {
	    		if ($('#divInfoImpact').is(':hidden')) {
	    			$("#divInfoImpact").show()
	    			$("#divInfoRisk").attr('style','display:none!important')
	    		}else{
	    			$("#divInfoImpact").attr('style','display:none!important')
	    		}
    		}else if($(this).attr('value') == 'likelihood'){
	    		if ($('#divInfoRisk').is(':hidden')) {
	    			$("#divInfoRisk").show()
	    			$("#divInfoImpact").attr('style','display:none!important')
	    		}else{
	    			$("#divInfoRisk").attr('style','display:none!important')
	    		}
    		}
    	}
  	});    

    let incrementRisk = 0
    function addRiskWeekly(){
		incrementRisk++

    	append = ""
		append = append + '<tr>'
		append = append + '			<td>'

		append = append + '<i class="bx bx-trash pull-right btnRemove" style="color:red" id="btnRemoveRiskWeekly"></i>'
		append = append + '				<div class="form-group">'
		append = append + '      			<label>Risk Description</label>'
		append = append + '      			<textarea class="form-control" data-value="' + incrementRisk +'" placeholder="Risk Description" id="textareaDescriptionRisk" name="textareaDescriptionRisk" onkeyup="validationCheck(this)"></textarea>'
		append = append + '      			<span class="invalid-feedback" style="display:none!important;">Please fill Risk Description!</span>'
		append = append + '      		</div>'
		append = append + '      		<div class="form-group">'
		append = append + '      			<label>Response Plan</label>'
		append = append + '      			<textarea class="form-control" data-value="' + incrementRisk +'" placeholder="Response Plan" id="textareaResponseRisk" name="textareaResponseRisk" onkeyup="validationCheck(this)"></textarea>'
		append = append + '      			<span class="invalid-feedback" style="display:none!important;">Please fill Response Plan!</span>'
		append = append + '      		</div>'
		append = append + '      		<div class="row">'
		append = append + '          		<div class="col-md-3">'
		append = append + '          			<div class="form-group">'
		append = append + '          				<label>Owner</label>'
		append = append + '          				<input type="text" data-value="' + incrementRisk +'" class="form-control" name="inputOwnerRisk" id="inputOwnerRisk" placeholder="Owner" onkeyup="validationCheck(this)">'
		append = append + '          			</div>'
		append = append + '      				<span class="invalid-feedback" style="display:none!important;">Please fill Owner!</span>'
		append = append + '          		</div>	'
		append = append + '          		<div class="col-md-3">'
		append = append + '          			<div class="form-group">'
		append = append + '          				<label>Rating/Severity</label>'
		append = append + '          				<input type="text" data-value="' + incrementRisk +'" class="form-control" name="inputRatingRisk" id="inputRatingRisk" placeholder="1-5" max="5" min="1" onkeyup="validationCheck(this)">'
		append = append + '          			</div>'
		append = append + '      				<span class="invalid-feedback" style="display:none!important;">Please fill Rating!</span>'
		append = append + '          		</div>	'
		append = append + '          		<div class="col-md-3">'
		append = append + '          			<div class="form-group">'
		append = append + '          				<label>Due Date</label>'
		append = append + '          				<div class="input-group">'
		append = append + '          					<div class="input-group-text">'

		append = append + '          						<i type="text" class="bx bx-calendar" name=""></i>'
		append = append + '          					</div>'
		append = append + '          					<input type="text" data-value="' + incrementRisk +'" class="form-control " name="due_date_risk" id="due_date_risk" placeholder="Select Due Date" onchange="validationCheck(this)">'
		append = append + '          				</div>'
		append = append + '      					<span class="invalid-feedback" style="display:none!important;">Please fill Due Date!</span>'
		append = append + '          			</div>'
		append = append + '          		</div>	'
		append = append + '          		<div class="col-md-3">'
		append = append + '          			<div class="form-group">'
		append = append + '                      	<label>Status</label><br>'
		append = append + '                      	<select data-value="' + incrementRisk +'" class="form-control" id="status_risk" name="status_risk" onchange="validationCheck(this)">'
		append = append + '                        	<option value="Active">Active</option>'
		append = append + '                        	<option value="Obsolete">Obsolete</option>'
		append = append + '                        	<option value="Accepted">Accepted</option>'
		append = append + '                      	</select>'
		append = append + '      					<span class="invalid-feedback" style="display:none!important;">Please fill Status!</span>'
		append = append + '					</div>	'
		append = append + '          		</div>'
		append = append + '          	</div>'
		append = append + '			</td>'
		append = append + '		</tr>'

		$("#tbodyRiskWeekly").append(append)

		$("input[name='due_date_risk']").flatpickr({
			autoclose:true
		})

		$(".select2").select2()
    }

    let currentTab = 0;
    function btnAddWeekly(n,status){
	    let x = document.getElementsByClassName("tab-add");

	  	//   x[n].style.display = "inline";

	   //  	if (n == (x.length - 1)) {
		  //     	document.getElementById("prevBtnWeekly").style.display = "inline";
		  //       document.getElementById("nextBtnWeekly").innerHTML = "Save";
		  //       document.getElementById("prevBtnWeekly").innerHTML = "Back";
		  //       $("#prevBtnWeekly").attr('onclick','nextPrevAddWeekly(-1)')
		  //       $("#nextBtnWeekly").attr('onclick','saveWeekly()');  

	  	// 		$(".modal-dialog").removeClass('modal-lg')
		  //       // let arrHealthStatus = ""
		  //       let arrLabelHealtStatus = ["Project","Schedule","Technical","Scope","Resource","Partner"]
		  //       appends = ""
		  //       appends = appends + '<div class="row">'
		  //       arrLabelHealtStatus.forEach((item) => {
		  //       		appends = appends + '<div class="col-md-4">'
		  //       			appends = appends + '  	<div class="form-group">'
				// 			appends = appends + '  		<label>'+ item +'</label>'
				// 			appends = appends + '         		<div class="radio">'
				// 			appends = appends + '         			<label><input value="R" type="radio" name="radioProject_'+ item +'" onchange="validationCheck(this)">R</label>&nbsp&nbsp&nbsp'
				// 			appends = appends + '     				<label><input value="Y" type="radio" name="radioProject_'+ item +'" onchange="validationCheck(this)">Y</label>&nbsp&nbsp&nbsp'
				// 			appends = appends + '     				<label><input value="G" type="radio" name="radioProject_'+ item +'" onchange="validationCheck(this)">G</label>'
				// 			appends = appends + '         		</div>	'
		  //                   appends = appends + '   <span class="invalid-feedback" style="display:none!important;">Please fill '+ item +'!</span>'			
				// 			appends = appends + '  	</div>'
		  //       		appends = appends + '</div>'
		  //       })
		  //       appends = appends + '</div>'

		  //       if ($("#cbProjectHealthStatus").find(".row:nth-child(1)").length == 0) {
		  //       	$("#cbProjectHealthStatus").append(appends)
		  //       }

		  //       getProgressBar()

		  //       let arrHealthStatus = []

				// let arrRadioCek = []
		  //       $("#cbProjectHealthStatus").find("input.minimal:checked").each(function(index,value){
				//     arrHealthStatus.push({text:$( this ).attr("name"),value:$("input[name='"+ $( this ).attr("name") +"']:checked").val()})
				// 	arrRadioCek.push(value.value)
				// })

				// if ((jQuery.inArray("R", arrRadioCek)) == -1 && (jQuery.inArray("Y", arrRadioCek)) == -1) {
				// 	$("#cbProjectHealthStatus").next("div .form-group").text("")
			 //    }

		  //       let initCount = 0
				// $("#cbProjectHealthStatus").find("input.minimal").click(function(){
				// 	let radioCountDefine = 6
				// 	let minimalCount = ++initCount
				// 	let arrRadio = []
				// 	$("#cbProjectHealthStatus").find("input.minimal:checked").each(function(index,value){
					     
				// 	     arrRadio.push(value.value)
				// 	})

				// 	let countG = arrRadio.filter(x => x == "G").length
				// 	let countY = arrRadio.filter(x => x == "Y").length
				// 	let countR = arrRadio.filter(x => x == "R").length

				// 	if (minimalCount == radioCountDefine) {
				// 		if((jQuery.inArray("R", arrRadio)) != -1 || (jQuery.inArray("Y", arrRadio)) != -1){
				// 			$("#cbProjectHealthStatus").after("<div class='form-group'><label>Note Summary Health Status</label><textarea placeholder='Give explanation if there is any yellow / red status' class='form-control' id='textareaNoteSummaryHealth' name=areaNoteSummaryHealth'></textarea></div>")
				// 		}else if (countG == 6) {
				// 		    $("#cbProjectHealthStatus").next("div .form-group").text("")
				// 		}

				// 	}else if (minimalCount > 6) {
				// 		if (countG == 6) {
				// 			$("#cbProjectHealthStatus").next("div .form-group").text("")
				// 		}else{
				// 			if ($("#textareaNoteSummaryHealth").length == 0) {
				// 				$("#cbProjectHealthStatus").after("<div class='form-group'><label>Note Summary Health Status</label><textarea class='form-control' id='textareaNoteSummaryHealth' name=areaNoteSummaryHealth'></textarea></div>")
				// 			}
				// 		}	
				// 	}
				// })

		  //       // document.getElementById("prevBtnWeekly").innerHTML = "Back";
	   //      	// document.getElementById("nextBtnWeekly").innerHTML = "Next";
		  //       // $("#nextBtnWeekly").attr('onclick','nextPrevAddWeekly(1)')
		  //       // $("#prevBtnWeekly").attr('onclick','nextPrevAddWeekly(-1)')
		  //   }else{
		  //     	if (n == 0) {
		  //     		$("input[name='date_report_date']").flatpickr({autoclose:true})
			 //        document.getElementById("prevBtnWeekly").innerHTML = "Cancel";
		  //       	document.getElementById("nextBtnWeekly").innerHTML = "Next";

			 //        $("#nextBtnWeekly").attr('onclick','nextPrevAddWeekly(1)')
			 //        $("#prevBtnWeekly").attr('onclick','cancelModal("ModalWeekly")')

			 //        $(".modal-dialog").removeClass('modal-lg')
			 //    }
		  //   }
	    if (status == "create") {
	    	x[n].style.display = "inline";

	    	if (n == (x.length - 1)) {
		      	document.getElementById("prevBtnWeekly").style.display = "inline";
		        document.getElementById("nextBtnWeekly").innerHTML = "Save";
		        document.getElementById("prevBtnWeekly").innerHTML = "Back";
		        $("#prevBtnWeekly").attr('onclick','nextPrevAddWeekly(-1,"'+ status +'")')
		        $("#nextBtnWeekly").attr('onclick','saveWeekly()');  

	  			$(".modal-dialog").removeClass('modal-lg')
		        // let arrHealthStatus = ""
		        let arrLabelHealtStatus = ["Project","Schedule","Technical","Scope","Resource","Partner"]
		        appends = ""
		        appends = appends + '<div class="row">'
		        arrLabelHealtStatus.forEach((item) => {
		        		appends = appends + '<div class="col-md-4">'
		        			appends = appends + '  	<div class="form-group">'
							appends = appends + '  		<label>'+ item +'</label>'
							appends = appends + '         		<div class="radio">'
							appends = appends + '         			<label><input value="R" type="radio" name="radioProject_'+ item +'" onchange="validationCheck(this)">R</label>&nbsp&nbsp&nbsp'
							appends = appends + '     				<label><input value="Y" type="radio" name="radioProject_'+ item +'" onchange="validationCheck(this)">Y</label>&nbsp&nbsp&nbsp'
							appends = appends + '     				<label><input value="G" type="radio" name="radioProject_'+ item +'" onchange="validationCheck(this)">G</label>'
							appends = appends + '         		</div>	'
		                    appends = appends + '   <span class="invalid-feedback" style="display:none!important;">Please fill '+ item +'!</span>'			
							appends = appends + '  	</div>'
		        		appends = appends + '</div>'
		        })
		        appends = appends + '</div>'

		        if ($("#cbProjectHealthStatus").find(".row:nth-child(1)").length == 0) {
		        	$("#cbProjectHealthStatus").append(appends)
		        }

		        getProgressBar()

		        let arrHealthStatus = []

					let arrRadioCek = []
		        $("#cbProjectHealthStatus").find("input:checked").each(function(index,value){
				    arrHealthStatus.push({text:$( this ).attr("name"),value:$("input[name='"+ $( this ).attr("name") +"']:checked").val()})
						arrRadioCek.push(value.value)
					})

					if ((jQuery.inArray("R", arrRadioCek)) == -1 && (jQuery.inArray("Y", arrRadioCek)) == -1) {
						$("#cbProjectHealthStatus").next("div .form-group").text("")
			    }

		      let initCount = 0
					$("#cbProjectHealthStatus").find("input").click(function(){
						let radioCountDefine = 6
						let minimalCount = ++initCount
						let arrRadio = []
						$("#cbProjectHealthStatus").find("input:checked").each(function(index,value){
					     
					  arrRadio.push(value.value)
					})

					let countG = arrRadio.filter(x => x == "G").length
					let countY = arrRadio.filter(x => x == "Y").length
					let countR = arrRadio.filter(x => x == "R").length

					if (minimalCount == radioCountDefine) {
						if((jQuery.inArray("R", arrRadio)) != -1 || (jQuery.inArray("Y", arrRadio)) != -1){

							console.log("sinii")
						  $("#cbProjectHealthStatus").next("div .form-group").text("")

							$("#cbProjectHealthStatus").after("<div class='form-group'><label>Note Summary Health Status</label><textarea placeholder='Give explanation if there is any yellow / red status' class='form-control' id='textareaNoteSummaryHealth' name=areaNoteSummaryHealth'></textarea></div>")
						}else if (countG == 6) {
						    $("#cbProjectHealthStatus").next("div .form-group").text("")
						}

					}else if (minimalCount > 6) {
						if (countG == 6) {
							$("#cbProjectHealthStatus").next("div .form-group").text("")
						}else{
							if ($("#textareaNoteSummaryHealth").length == 0) {
						    	$("#cbProjectHealthStatus").next("div .form-group").text("")

								$("#cbProjectHealthStatus").after("<div class='form-group'><label>Note Summary Health Status</label><textarea class='form-control' id='textareaNoteSummaryHealth' name=areaNoteSummaryHealth'></textarea></div>")
							}
						}	
					}
				})

		        // document.getElementById("prevBtnWeekly").innerHTML = "Back";
	        	// document.getElementById("nextBtnWeekly").innerHTML = "Next";
		        // $("#nextBtnWeekly").attr('onclick','nextPrevAddWeekly(1)')
		        // $("#prevBtnWeekly").attr('onclick','nextPrevAddWeekly(-1)')
		    }else{
		      	if (n == 0) {
		      		$("input[name='date_report_date']").flatpickr({autoclose:true})
			        document.getElementById("prevBtnWeekly").innerHTML = "Cancel";
		        	document.getElementById("nextBtnWeekly").innerHTML = "Next";

			        $("#nextBtnWeekly").attr('onclick','nextPrevAddWeekly(1,"'+ status +'")')
			        $("#prevBtnWeekly").attr('onclick','cancelModal("ModalWeekly")')

			        $(".modal-dialog").removeClass('modal-lg')
			    }
		    }

	    }else{
	    	x[1].style.display = "inline";
	    	x[0].style.display = "none";

		    $("input[name='date_report_date']").flatpickr({autoclose:true})

		    document.getElementById("nextBtnWeekly").innerHTML = "Save";
		    $("#nextBtnWeekly").attr('onclick','saveWeekly()');  
			$("#prevBtnWeekly").attr('onclick','cancelModal("ModalWeekly")')

	    	let arrLabelHealtStatus = ["Project","Schedule","Technical","Scope","Resource","Partner"]
	        appends = ""
	        appends = appends + '<div class="row">'
	        arrLabelHealtStatus.forEach((item) => {
	        		appends = appends + '<div class="col-md-4">'
	        			appends = appends + '  	<div class="form-group">'
						appends = appends + '  		<label>'+ item +'</label>'
						appends = appends + '         		<div class="radio">'
						appends = appends + '         			<label><input value="R" type="radio" name="radioProject_'+ item +'" onchange="validationCheck(this)">R</label>&nbsp&nbsp&nbsp'
						appends = appends + '     				<label><input value="Y" type="radio" name="radioProject_'+ item +'" onchange="validationCheck(this)">Y</label>&nbsp&nbsp&nbsp'
						appends = appends + '     				<label><input value="G" type="radio" name="radioProject_'+ item +'" onchange="validationCheck(this)">G</label>'
						appends = appends + '         		</div>	'
	                    appends = appends + '   <span class="invalid-feedback" style="display:none!important;">Please fill '+ item +'!</span>'			
						appends = appends + '  	</div>'
	        		appends = appends + '</div>'
	        })
	        appends = appends + '</div>'

	        if ($("#cbProjectHealthStatus").find(".row:nth-child(1)").length == 0) {
	        	$("#cbProjectHealthStatus").append(appends)
	        }

	        getProgressBar()
	        
	        let arrHealthStatus = []

				let arrRadioCek = []
	        $("#cbProjectHealthStatus").find("input:checked").each(function(index,value){
			    arrHealthStatus.push({text:$( this ).attr("name"),value:$("input[name='"+ $( this ).attr("name") +"']:checked").val()})
					arrRadioCek.push(value.value)
				})

				if ((jQuery.inArray("R", arrRadioCek)) == -1 && (jQuery.inArray("Y", arrRadioCek)) == -1) {
					$("#cbProjectHealthStatus").next("div .form-group").text("")
		    }

	      let initCount = 0
				$("#cbProjectHealthStatus").find("input").click(function(){
				let radioCountDefine = 6
				let minimalCount = ++initCount
				let arrRadio = []
				$("#cbProjectHealthStatus").find("input:checked").each(function(index,value){
				     
				     arrRadio.push(value.value)
				})

				let countG = arrRadio.filter(x => x == "G").length
				let countY = arrRadio.filter(x => x == "Y").length
				let countR = arrRadio.filter(x => x == "R").length

				if (minimalCount == radioCountDefine) {
					if((jQuery.inArray("R", arrRadio)) != -1 || (jQuery.inArray("Y", arrRadio)) != -1){
						$("#cbProjectHealthStatus").after("<div class='form-group'><label>Note Summary Health Status</label><textarea placeholder='Give explanation if there is any yellow / red status' class='form-control' id='textareaNoteSummaryHealth' name=areaNoteSummaryHealth'></textarea></div>")
					}else if (countG == 6) {
					    $("#cbProjectHealthStatus").next("div .form-group").text("")
					}

				}else if (minimalCount > 6) {
					if (countG == 6) {
						$("#cbProjectHealthStatus").next("div .form-group").text("")
					}else{
						if ($("#textareaNoteSummaryHealth").length == 0) {
							$("#cbProjectHealthStatus").after("<div class='form-group'><label>Note Summary Health Status</label><textarea class='form-control' id='textareaNoteSummaryHealth' name=areaNoteSummaryHealth'></textarea></div>")
						}
					}	
				}
			})
	    } 

      $("#ModalWeekly").modal("show") 
    }

    function saveWeekly(){
    	if($("#date_report_date").val() == ""){
          $("#date_report_date").closest("div .form-group").addClass("needs-validation")
          $("#date_report_date").closest("div .form-group").find(".invalid-feedback").show()
        }else if($("#overall_progress").val() == ""){
          $("#overall_progress").closest("div").addClass("needs-validation")
          $("#overall_progress").next("span").show()
        }else if($("input[name='radioProjectIndicator']:checked").length == 0){
          $("#radioProjectIndicator:last").closest("div .form-group").addClass('needs-validation')
          $("#radioProjectIndicator:last").closest("div .form-group").find(".invalid-feedback").show()
        }else if($("#textareaStatusSummary").val() == ""){
          $("#textareaStatusSummary").closest("div").addClass("needs-validation")
          $("#textareaStatusSummary").next("span").show()
        }else if($("input[name='radioProject_Project']:checked").length == 0){
          $("input[name='radioProject_Project']:last").closest("div .form-group").addClass("needs-validation")
          $("input[name='radioProject_Project']:last").closest("div .form-group").find(".invalid-feedback").show()
        }else if($("input[name='radioProject_Schedule']:checked").length == 0){
          $("input[name='radioProject_Schedule']:last").closest("div .form-group").addClass("needs-validation")
          $("input[name='radioProject_Schedule']:last").closest("div .form-group").find(".invalid-feedback").show()
        }else if($("input[name='radioProject_Technical']:checked").length == 0){
          $("input[name='radioProject_Technical']:last").closest("div .form-group").addClass("needs-validation")
          $("input[name='radioProject_Technical']:last").closest("div .form-group").find(".invalid-feedback").show()
        }else if($("input[name='radioProject_Scope']:checked").length == 0){
          $("input[name='radioProject_Scope']:last").closest("div .form-group").addClass("needs-validation")
          $("input[name='radioProject_Scope']:last").closest("div .form-group").find(".invalid-feedback").show()
        }else if($("input[name='radioProject_Resource']:checked").length == 0){
          $("input[name='radioProject_Resource']:last").closest("div .form-group").addClass("needs-validation")
          $("input[name='radioProject_Resource']:last").closest("div .form-group").find(".invalid-feedback").show()
        }else if($("input[name='radioProject_Partner']:checked").length == 0){
          $("input[name='radioProject_Partner']:last").closest("div .form-group").addClass("needs-validation")
          $("input[name='radioProject_Partner']:last").closest("div .form-group").find(".invalid-feedback").show()
        }else{
        	let arrDisti = [], arrWeeklyIssue = [], arrWeeklyRisk = []
	    		let cbProjectIndicator = '', cbProject = '', cbSchedule = '', cbTechnical = '', cbScope = '', cbResource = '', cbPartner = ''
	    		$("#tbodyWeeklyDistiInformation tr").each(function(){
	          	arrDisti.push({
		            "recipient":$(this).find("#inputRecipientDisti").val(),
		            "company":$(this).find("#inputCompanyDisti").val(),
		            "title":$(this).find("#inputTitleDisti").val(),
		            "email":$(this).find("#inputEmailDisti").val()
	        	})
	        })

	        $("input[name='radioProjectIndicator']:checked").each(function(){
	        	cbProjectIndicator = $(this).attr('value')
	        })

	        $("input[name='radioProject_Project']:checked").each(function(){
	        	cbProject = $(this).attr('value')
	        })

	        $("input[name='radioProject_Schedule']:checked").each(function(){
	        	cbSchedule = $(this).attr('value')
	        })

	        $("input[name='radioProject_Technical']:checked").each(function(){
	        	cbTechnical = $(this).attr('value')
	        })

	        $("input[name='radioProject_Scope']:checked").each(function(){
	        	cbScope = $(this).attr('value')
	        })

	        $("input[name='radioProject_Resource']:checked").each(function(){
	        	cbResource = $(this).attr('value')
	        })

	        $("input[name='radioProject_Partner']:checked").each(function(){
	        	cbPartner = $(this).attr('value')
	        })


	        // $("#tbodyWeeklyIssue tr").each(function(){
	        //   arrWeeklyIssue.push({
	        //     "textAreaIssueDesc":$(this).find("#textAreaIssueDesc").val(),
	        //     "textareaSolutionPlanIssue":$(this).find("#textareaSolutionPlanIssue").val(),
	        //     "inputOwnerIssue":$(this).find("#inputOwnerIssue").val(),
	        //     "inputRatingIssue":$(this).find("#inputRatingIssue").val(),
	        //     "expected_date_issue":moment($(this).find("#expected_date_issue").val()).format("YYYY-MM-DD"),
	        //     "actual_date_issue":moment($(this).find("#actual_date_issue").val()).format("YYYY-MM-DD"),
	        //     "status_issue":$(this).find("#status_issue").val()
	        //   })
	        // })

	        // $("#tbodyRiskWeekly tr").each(function(){
	        //   arrWeeklyRisk.push({
	        //     "textareaDescriptionRisk":$(this).find("#textareaDescriptionRisk").val(),
	        //     "textareaResponseRisk":$(this).find("#textareaResponseRisk").val(),
	        //     "inputOwnerRisk":$(this).find("#inputOwnerRisk").val(),
	        //     "inputRatingRisk":$(this).find("#inputRatingRisk").val(),
	        //     "due_date_risk":moment($(this).find("#due_date_risk").val()).format("YYYY-MM-DD"),
	        //     "status_risk":$(this).find("#status_risk").val()
	        //   })
	        // })

	        swalFireCustom = {
	          title: 'Are you sure?',
	          text: "Submit Weekly Progress",
	          icon: 'warning',
	          showCancelButton: true,
	          confirmButtonColor: '#3085d6',
	          cancelButtonColor: '#d33',
	          confirmButtonText: 'Yes',
	          cancelButtonText: 'No',
	        }

        	formData = new FormData
        	formData.append('_token',"{{ csrf_token() }}")
        	formData.append('id_pmo',window.location.href.split("/")[5].split("?")[0])
        	formData.append('date_report_date',moment($("#date_report_date").val()).format('YYYY-MM-DD'))
	        formData.append('overall_progress',$("#overall_progress").val())
	        formData.append('textareaStatusSummary',$("#textareaStatusSummary").val())
	        formData.append('cbProjectIndicator',cbProjectIndicator)
	        if ($("#textareaNoteSummaryHealth").length == 1) {
	        	formData.append('textareaNoteSummaryHealth',$("#textareaNoteSummaryHealth").val())
	        }else{
	        	formData.append('textareaNoteSummaryHealth','-')
	        }
	        formData.append('arrDisti',JSON.stringify(arrDisti))
	        // formData.append('arrWeeklyIssue',JSON.stringify(arrWeeklyIssue))
	        // formData.append('arrWeeklyRisk',JSON.stringify(arrWeeklyRisk))
	        formData.append('cbProject',cbProject)
					formData.append('cbSchedule',cbSchedule)
					formData.append('cbTechnical',cbTechnical)
					formData.append('cbScope',cbScope)
					formData.append('cbResource',cbResource)
					formData.append('cbPartner',cbPartner)	        

	        swalSuccess = {
	          icon: 'success',
	          title: 'Weekly Report has been created!',
	          text: 'Reload Page',
	        }

		    createPost(swalFireCustom,formData,swalSuccess,url="/PMO/storeWeeklyReport") 

        }
    		
    	// $("#tbodyRiskWeekly tr").each(function() {
     //      if ($("#textareaDescriptionRisk[data-value='"+ $(this).find('#textareaDescriptionRisk').data("value") +"']").val() == "") {
     //        $("#textareaDescriptionRisk[data-value='"+ $(this).find('#textareaDescriptionRisk').data("value") +"']").closest("div").addClass("needs-validation")
     //        $("#textareaDescriptionRisk[data-value='"+ $(this).find('#textareaDescriptionRisk').data("value") +"']").next("span").show()
     //      }else if ($("#textareaResponseRisk[data-value='"+ $(this).find('#textareaResponseRisk').data("value") +"']").val() == "") {
     //        $("#textareaResponseRisk[data-value='"+ $(this).find('#textareaResponseRisk').data("value") +"']").closest("div").addClass("needs-validation")
     //        $("#textareaResponseRisk[data-value='"+ $(this).find('#textareaResponseRisk').data("value") +"']").next("span").show()
     //      }else if ($("#inputOwnerRisk[data-value='"+ $(this).find('#inputOwnerRisk').data("value") +"']").val() == "") {
     //        $("#inputOwnerRisk[data-value='"+ $(this).find('#inputOwnerRisk').data("value") +"']").closest("div .form-group").addClass("needs-validation")
     //        $("#inputOwnerRisk[data-value='"+ $(this).find('#inputOwnerRisk').data("value") +"']").closest("div .form-group").next(".invalid-feedback").show()
     //      }else if ($("#inputRatingRisk[data-value='"+ $(this).find('#inputRatingRisk').data("value") +"']").val() == "") {
     //        $("#inputRatingRisk[data-value='"+ $(this).find('#inputRatingRisk').data("value") +"']").closest("div .form-group").addClass("needs-validation")
     //        $("#inputRatingRisk[data-value='"+ $(this).find('#inputRatingRisk').data("value") +"']").closest("div .form-group").next(".invalid-feedback").show()
     //      }else if ($("#due_date_risk[data-value='"+ $(this).find('#due_date_risk').data("value") +"']").val() == "") {
     //        $("#due_date_risk[data-value='"+ $(this).find('#due_date_risk').data("value") +"']").closest("div .form-group").addClass("needs-validation")
     //        $("#due_date_risk[data-value='"+ $(this).find('#due_date_risk').data("value") +"']").closest("div .form-group").find(".invalid-feedback").show()
     //      }else if ($("#status_risk[data-value='"+ $(this).find('#status_risk').data("value") +"']").val() == "") {
     //        $("#status_risk[data-value='"+ $(this).find('#status_risk').data("value") +"']").closest("div .form-group").addClass("needs-validation")
     //        $("#status_risk[data-value='"+ $(this).find('#status_risk').data("value") +"']").closest("div .form-group").find(".invalid-feedback").show()
     //      }else{
            
     //      }
     //    })
    	   	
    }

    function addDistiInfo(){
    	append = ""
		append = append +	'<tr>'
		append = append +	'<td>'
		append = append +	'	<input class="form-control" type="text" placeholder="Recipient" name="inputRecipientDisti" id="inputRecipientDisti">'
		append = append +	'</td>'
		append = append +	'<td>'
		append = append +	'	<input class="form-control" type="text" placeholder="Company" name="inputCompanyDisti" id="inputCompanyDisti">'
		append = append +	'</td>'
		append = append +	'<td>'
		append = append +	'	<input class="form-control" type="text" placeholder="Title" name="inputTitleDisti" id="inputTitleDisti">'
		append = append +	'</td>'
		append = append +	'<td>'
		append = append +	'	<input class="form-control" type="text" placeholder="Email" name="inputEmailDisti" id="inputEmailDisti">'
		append = append +	'</td>'
		append = append +	'<td>'

		append = append +	'	<button type="button" class="btnRemove" style="background:transparent;border:none;color:red"><i class="bx bx-trash"></i></button>'
		append = append +	'</td>'
		append = append +	'/tr>'
    	
    	$("#tbodyWeeklyDistiInformation").append(append)
    }

    $(document).on('click', '.btnRemove', function() {
      $(this).closest("tr").remove();
    })

    function nextPrevAddWeekly(n,status){
    	if (currentTab == 1) {
    		if (n == 1) {
    			if($("#date_report_date").val() == ""){
		          $("#date_report_date").closest("div .form-group").addClass("needs-validation")
		          $("#date_report_date").closest("div .form-group").find(".invalid-feedback").show()
		        }else if($("#overall_progress").val() == ""){
		          $("#overall_progress").closest("div").addClass("needs-validation")
		          $("#overall_progress").next("span").show()
		        }else if($("input[name='radioProjectIndicator']:checked").length == 0){
		          $("#radioProjectIndicator:last").closest("div .form-group").addClass('needs-validation')
		          $("#radioProjectIndicator:last").closest("div .form-group").find(".invalid-feedback").show()
		        }else if($("#textareaStatusSummary").val() == ""){
		          $("#textareaStatusSummary").closest("div").addClass("needs-validation")
		          $("#textareaStatusSummary").next("span").show()
		        }else if($("input[name='radioProject_Project']:checked").length == 0){
		          $("input[name='radioProject_Project']:last").closest("div .form-group").addClass("needs-validation")
		          $("input[name='radioProject_Project']:last").closest("div .form-group").find(".invalid-feedback").show()
		        }else if($("input[name='radioProject_Schedule']:checked").length == 0){
		          $("input[name='radioProject_Schedule']:last").closest("div .form-group").addClass("needs-validation")
		          $("input[name='radioProject_Schedule']:last").closest("div .form-group").find(".invalid-feedback").show()
		        }else if($("input[name='radioProject_Technical']:checked").length == 0){
		          $("input[name='radioProject_Technical']:last").closest("div .form-group").addClass("needs-validation")
		          $("input[name='radioProject_Technical']:last").closest("div .form-group").find(".invalid-feedback").show()
		        }else if($("input[name='radioProject_Scope']:checked").length == 0){
		          $("input[name='radioProject_Scope']:last").closest("div .form-group").addClass("needs-validation")
		          $("input[name='radioProject_Scope']:last").closest("div .form-group").find(".invalid-feedback").show()
		        }else if($("input[name='radioProject_Resource']:checked").length == 0){
		          $("input[name='radioProject_Resource']:last").closest("div .form-group").addClass("needs-validation")
		          $("input[name='radioProject_Resource']:last").closest("div .form-group").find(".invalid-feedback").show()
		        }else if($("input[name='radioProject_Partner']:checked").length == 0){
		          $("input[name='radioProject_Partner']:last").closest("div .form-group").addClass("needs-validation")
		          $("input[name='radioProject_Partner']:last").closest("div .form-group").find(".invalid-feedback").show()
		        }else{
		          	let x = document.getElementsByClassName("tab-add");
			        x[currentTab].style.display = "none";
			        currentTab = currentTab + n;
			        if (currentTab >= x.length) {
			          x[n].style.display = "none";
			          currentTab = 0;
			        }
			        btnAddWeekly(currentTab,status);
		        }
    		}else{
    			let x = document.getElementsByClassName("tab-add");
		        x[currentTab].style.display = "none";
		        currentTab = currentTab + n;
		        if (currentTab >= x.length) {
		          x[n].style.display = "none";
		          currentTab = 0;
		        }
		        btnAddWeekly(currentTab,status);
    		}  		
    	}else if (currentTab == 2) {
    		if (n == 1) {
    			$("#tbodyWeeklyIssue tr").each(function() {
		          if ($("#textAreaIssueDesc[data-value='"+ $(this).find('#textAreaIssueDesc').data("value") +"']").val() == "") {
		            $("#textAreaIssueDesc[data-value='"+ $(this).find('#textAreaIssueDesc').data("value") +"']").closest("div").addClass("needs-validation")
		            $("#textAreaIssueDesc[data-value='"+ $(this).find('#textAreaIssueDesc').data("value") +"']").next("span").show()
		          }else if ($("#textareaSolutionPlanIssue[data-value='"+ $(this).find('#textareaSolutionPlanIssue').data("value") +"']").val() == "") {
		            $("#textareaSolutionPlanIssue[data-value='"+ $(this).find('#textareaSolutionPlanIssue').data("value") +"']").closest("div").addClass("needs-validation")
		            $("#textareaSolutionPlanIssue[data-value='"+ $(this).find('#textareaSolutionPlanIssue').data("value") +"']").next("span").show()
		          }else if ($("#inputOwnerIssue[data-value='"+ $(this).find('#inputOwnerIssue').data("value") +"']").val() == "") {
		            $("#inputOwnerIssue[data-value='"+ $(this).find('#inputOwnerIssue').data("value") +"']").closest("div").addClass("needs-validation")
		            $("#inputOwnerIssue[data-value='"+ $(this).find('#inputOwnerIssue').data("value") +"']").next("span").show()
		          }else if ($("#inputRatingIssue[data-value='"+ $(this).find('#inputRatingIssue').data("value") +"']").val() == "") {
		            $("#inputRatingIssue[data-value='"+ $(this).find('#inputRatingIssue').data("value") +"']").closest("div").addClass("needs-validation")
		            $("#inputRatingIssue[data-value='"+ $(this).find('#inputRatingIssue').data("value") +"']").next("span").show()
		          }else if ($("#expected_date_issue[data-value='"+ $(this).find('#expected_date_issue').data("value") +"']").val() == "") {
		            $("#expected_date_issue[data-value='"+ $(this).find('#expected_date_issue').data("value") +"']").closest("div").addClass("needs-validation")
		            $("#expected_date_issue[data-value='"+ $(this).find('#expected_date_issue').data("value") +"']").next("span").show()
		          }else if ($("#actual_date_issue[data-value='"+ $(this).find('#actual_date_issue').data("value") +"']").val() == "") {
		            $("#actual_date_issue[data-value='"+ $(this).find('#actual_date_issue').data("value") +"']").closest("div").addClass("needs-validation")
		            $("#actual_date_issue[data-value='"+ $(this).find('#actual_date_issue').data("value") +"']").next("span").show()
		          }else if ($("#status_issue[data-value='"+ $(this).find('#status_issue').data("value") +"']").val() == "") {
		            $("#status_issue[data-value='"+ $(this).find('#status_issue').data("value") +"']").closest("div").addClass("needs-validation")
		            $("#status_issue[data-value='"+ $(this).find('#status_issue').data("value") +"']").next("span").show()
		          }else{
		            let x = document.getElementsByClassName("tab-add");
			        x[currentTab].style.display = "none";
			        currentTab = currentTab + n;
			        if (currentTab >= x.length) {
			          x[n].style.display = "none";
			          currentTab = 0;
			        }
			        btnAddWeekly(currentTab);
		          }
		        })
    		}else{
    			let x = document.getElementsByClassName("tab-add");
		        x[currentTab].style.display = "none";
		        currentTab = currentTab + n;
		        if (currentTab >= x.length) {
		          x[n].style.display = "none";
		          currentTab = 0;
		        }
		        btnAddWeekly(currentTab,status);
    		}
    	}else {
    		let x = document.getElementsByClassName("tab-add");
	        x[currentTab].style.display = "none";
	        currentTab = currentTab + n;
	        if (currentTab >= x.length) {
	          x[n].style.display = "none";
	          currentTab = 0;
	        }
	        btnAddWeekly(currentTab,status); 
    	}
    }

    var formatter = new Intl.NumberFormat(['ban', 'id'])

    function btnFinalProject(n,status){  
		$("#divShowChecklist").next("#group-adding").remove()

	    let x = document.getElementsByClassName("tab-add-final");
	    x[n].style.display = "inline";
	    document.getElementById("nextBtnFinal").innerHTML = "Next";
	    $("#btnRejectFinal").remove()

	    $.ajax({
	    	url:"{{url('/PMO/getFinalReportById')}}",
        	type:"GET",
        	data:{
        		id_pmo:window.location.href.split("/")[5].split("?")[0]
        	},success:function(result){
        		arrReason = []
        		
        		if (n == (x.length - 1)) {
			      	$(".modal-title").text('Project Document')
			      	document.getElementById("prevBtnFinal").style.display = "inline";
			      	if(accesable.includes('btnRejectFinal')){
			      		document.getElementById("nextBtnFinal").innerHTML = "save";
			        	$("#nextBtnFinal").before('<button class="btn btn-sm btn-danger" id="btnRejectFinal">Reject</button>')
			        	$("#btnRejectFinal").attr('onclick',"btnRejectNotes("+ '"ModalFinal"' +")") 
			        	$("#nextBtnFinal").attr('onclick',"saveFinal("+ '"ModalFinal"' +")") 
			      	}else{
			      		document.getElementById("nextBtnFinal").innerHTML = "Save";
			        	$("#nextBtnFinal").attr('onclick',"saveFinal("+ '"ModalSave"' +")"); 
			      	}
			        
			      	let type = window.location.search.split("=")[1]

			      	$.ajax({
			    		url:"{{url('/PMO/getProjectDocument')}}",
			    		type:"GET",
			    		data:{
			    			id_pmo:window.location.href.split("/")[5].split("?")[0]
			    		},
			    		success:function(resultDoc){
			      			$("#divShowChecklist").empty("")
			      			append = ""
			      			append = append + '<table id="tbShowChecklistFinal">'
			    			$.each(resultDoc.data,function(idx,item){
			    				append = append + '<tr>	'
					      			append = append + '<td width="450px">'
					      				append = append + '<label>'+ item.text +'</label>'
					      			append = append + '</td>'
					      			append = append + '<td>'
					      				append = append + '			<div class="radio" style="float:right;">'
					      				if (item.deliverable_document == 'Done') {
					      					append = append + '				<label style="display:inline;"><input type="radio" disabled name="radio_'+ item.text.split(' ').join('_') +'" checked value="yes" name="">&nbsp Yes</label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'
											append = append + '				<label style="display:inline;"><input type="radio" disabled name="radio_'+ item.text.split(' ').join('_') +'"  value="no" name="">&nbsp No</label>'
					      				}else{
					      					append = append + '				<label style="display:inline;"><input type="radio" disabled name="radio_'+ item.text.split(' ').join('_') +'" value="yes" name="">&nbsp Yes</label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'
											append = append + '				<label style="display:inline;"><input type="radio" disabled name="radio_'+ item.text.split(' ').join('_') +'" checked value="no" name="">&nbsp No</label>'
					      				}
										append = append + '			</div>'
					      			append = append + '</td>'
					      		append = append + '</tr>'
			    			})		    			
			      			append = append + '</table>'
			      			$("#divShowChecklist").append(append)	
			    		}
		    		})

		      		append2 = ""
	    			append2 = append2 + '<div id="group-adding">'
	      			append2 = append2 + '	<div class="row">'
	      			append2 = append2 + ' 		<div class="col-md-12" id="divAddTerms"></div>'
					append2 = append2 + '	</div>'
					append2 = append2 + '   <div class="form-group">'
					append2 = append2 + '   	<label>Customer Satisfaction Survey</label>'
					append2 = append2 + ' 		<input type="text" class="form-control" id="link_feedback" name="link_feedback" placeholder="Link G-sheet result feedback" />'
					append2 = append2 + ' 		<span class="needs-validation" style="display:none!important">Please fill link feedback!</span>'
					append2 = append2 + '   </div>'
					append2 = append2 + '   <div class="form-group">'
					append2 = append2 + '   	<label>Lesson Learnt</label>'
					append2 = append2 + '   	<textarea class="form-control" placeholder="List Down Both Positive and Negative Lesson Learnt" id="textareaLessonLearn" name="textareaLessonLearn"></textarea>'
					append2 = append2 + ' 		<span class="invalid-feedback" style="display:none!important">Please fill Lesson Learnt!</span>'
					append2 = append2 + '   </div>'
					append2 = append2 + '   <div class="form-group">'
					append2 = append2 + '   	<label>Recommendation for Future Project</label>'
					append2 = append2 + '   	<textarea placeholder="Recomendation for future project" class="form-control" id="textareaRecommendation" name="textareaRecomendation"></textarea>'
					append2 = append2 + ' 		<span class="invalid-feedback" style="display:none!important">Please fill Recomendation for future project!</span>'
					append2 = append2 + '   </div>'
					append2 = append2 + '   <div class="form-group">'
					append2 = append2 + '   	<label>Additional Notes/Comments</label>'
					append2 = append2 + '   	<textarea placeholder="Additional Notes/Comment" class="form-control" id="textareaAdditionalNote" name="textareaAdditionalNote"></textarea>'
					append2 = append2 + '   </div>'
					append2 = append2 + '</div>'
					$("#divShowChecklist").after(append2) 	

					append3 = ''
					$("#divAddTerms").empty("")

					append3 = append3 + '<table class="table" id="tbTermsPayment" style="width:100%;white-space:nowrap;">'
					append3 = append3 + '<tr>'
					append3 = append3 + '<th>Term Of Payment</th>'
					append3 = append3 + '<th>Payment Date</th>'
					append3 = append3 + '<th><button type="button" id="btnAddTerms" style="background-color:transparent;border:none" onclick="addTermsPayment()"><i class="bx bx-plus"></i></button></th>'
					append3 = append3 + '</tr>'
					append3 = append3 + '<tbody id="tbodyTermsPayment"></tbody>'
					append3 = append3 + '</table>'

					$("#divAddTerms").append(append3)
					if (status == 'verify') {
						$("#btnAddTerms").attr('style','display:none!important')
						let arrTerms = [], arrPayment = []
		        		

						// $.each(JSON.parse(result[0].term_payment),function(idx,item){
		    //     			arrTerms.push({"termPayment":item.termPayment.replace("\n","")})
		    //     		})

		    //     		$.each(JSON.parse(result[0].payment_date),function(idx,item){
		    //     			arrPayment.push({"payDate":item.payDate.replace("\n","")})
		    //     		})

		    			$.each(result[0].term_payment,function(idx,item){
		        			arrTerms.push({"termPayment":item.termPayment.replace("\n","")})
		        		})

		        		$.each(result[0].payment_date,function(idx,item){
		        			arrPayment.push({"payDate":item.payDate.replace("\n","")})
		        		})
						
						let arrCombine = arrTerms.map((item, i) => Object.assign({}, item, arrPayment[i]))
						
						$("#tbodyTermsPayment").empty()
						$.each(arrCombine,function(idx,item){
		        			
		        			append4 = ''

							append4 = append4 + '<tr>'
							append4 = append4 + '<td>'
							append4 = append4 + '<input class="form-control" value="'+ item.termPayment +'" id="inputTermsPayment" disabled />'
							append4 = append4 + '</td>'
							append4 = append4 + '<td>'
							if (item.payDate == '-') {
								append4 = append4 + '<input type="text" disabled class="form-control" id="inputDatePayment" value="' + item.payDate +'"/>'
							}else{
								append4 = append4 + '<input type="text" disabled class="form-control" id="inputDatePayment" value="'+ moment(item.payDate).format("YYYY-MM-DD") +'"/>'
							}
							
							append4 = append4 + '</td>'
							append4 = append4 + '<td>'
							append4 = append4 + '</td>'
							append4 = append4 + '</tr>'

							$("#tbodyTermsPayment").append(append4)
		        		})
						$("#link_css").remove()
						// if (result.length > 0) {
	        			$("#link_feedback").val(result[0].css).prop("disabled",true).after("<a target='_blank' id='link_css' href="+ result[0].css +"><i class='bx bx-link'></i> Link Feedback Css</a>")
						$("#textareaAdditionalNote").val(result[0].additional_notes).prop("disabled",true)
						$("#textareaRecommendation").val(result[0].recommendation_future).prop("disabled",true)
						$("#textareaLessonLearn").val(result[0].lesson_learn).prop("disabled",true)

						
					}else if (status == 'update') {
              			reasonReject(result[0].note_reject,"block","tabGroup")
              			let arrTerms = [], arrPayment = []
		        		

						$.each(result[0].term_payment,function(idx,item){
		        			arrTerms.push({"termPayment":item.termPayment.replace("\n","")})
		        		})

		        		$.each(result[0].payment_date,function(idx,item){
		        			arrPayment.push({"payDate":item.payDate.replace("\n","")})
		        		})

						let arrCombine = arrTerms.map((item, i) => Object.assign({}, item, arrPayment[i]))
						
						$("#tbodyTermsPayment").empty()

              			$.each(arrCombine,function(idx,item){
		        			
		        			append4 = ''

							append4 = append4 + '<tr>'
							append4 = append4 + '<td>'
							append4 = append4 + '<input class="form-control" value="'+ item.termPayment +'" id="inputTermsPayment" disabled />'
							append4 = append4 + '</td>'
							append4 = append4 + '<td>'
							if (item.payDate == '-') {
								append4 = append4 + '<input disabled class="form-control" id="inputDatePayment" value="' + item.payDate +'"/>'
							}else{
								append4 = append4 + '<input disabled class="form-control" id="inputDatePayment" value="'+ moment(item.payDate).format("YYYY-MM-DD") +'"/>'
							}
							
							append4 = append4 + '</td>'
							append4 = append4 + '<td>'
							append4 = append4 + '<button type="button" id="btnRemoveTermsPayment" style="background-color:transparent;border:none"><i class="bx bx-trash" style="color:red"></i></button>'
							append4 = append4 + '</td>'
							append4 = append4 + '</tr>'

							$("#tbodyTermsPayment").append(append4)
		        		})
						// $("#tbodyTermsPayment").empty()

						// let arrCombine = []
		    

						// $.each(JSON.parse(result[0].term_payment),function(idx,item){
	

						$("#link_css").remove()
						if (result.length > 0) {
		        			$("#link_feedback").val(result[0].css).after("<a target='_blank' id='link_css' href="+ result[0].css +"><i class='bx bx-link'></i> Link Feedback Css</a>")
							$("#textareaAdditionalNote").val(result[0].additional_notes)
							$("#textareaRecomendation").val(result[0].recommendation_future)
							$("#textareaLessonLearn").val(result[0].lesson_learn)
							
						}
					}				

			    }else {
			      	if (n == 0) {
			      		$(".modal-title").text('Project Information')
				        document.getElementById("prevBtnFinal").innerHTML = "Cancel";
				        $("#nextBtnFinal").attr('onclick','nextPrevAddFinal(1,"'+ status +'")')
				        $("#prevBtnFinal").attr('onclick','cancelModal("ModalFinalProject")')

				        $(".modal-dialog").removeClass('modal-lg')

				        $.ajax({
				        	url:"{{url('/PMO/showProjectCharter')}}",
				        	type:"GET",
				        	data:{
				        		id_pmo:window.location.href.split("/")[5].split("?")[0]
				        	},success:function(item){
				        		$("#customer_name_final_project").val(item[0].customer_name)
				        		$("#PID_final_project").val(item[0].project_id.project_id)
				        		$("#projectValueFinal").val(formatter.format(item[0].project_id.amount))
				        		$("#projectNameFinal").val(item[0].project_id.name_project)
				        		$("#projectManagerFinal").val(item[0].project_pm)
				        		$("#projectCoordinatorFinal").val(item[0].project_pc)
				        		$("#textareaProjectDescFinal").val(item[0].project_description)

				        	}
				        })

				        if (result.length > 0) {
				        	if (result[0].status == "Reject") {
	              				reasonReject(result[0].note_reject,"block","tabGroup")
					        }
				        }
				    }else if (n == 1) {
			      		$(".modal-title").text('Project Milestone')
				        $(".modal-dialog").removeClass('modal-lg')
				        document.getElementById("prevBtnFinal").innerHTML = "Back";

				        let dataFix = []

				        dataTypeSupply = ["Project Award","Device arrived at WH SIP","Device Delivery to User","DO Approved submitted to Finance"]

				        dataTypeImplementation = ["Project Award","Device arrived at WH SIP","Device Delivery to User","DO Approved submitted to Finance","Project Closing"]

				        dataTypeMaintenance = ["Project Award","BAST License / Warranty","PM-1","PM-2","Project Closing"]

				        dataTypeImplementAdditional = ["PM-3","PM-4"]

				        let idx = 3
				        let type = "maintenance"

				        dataTypeImplementAdditional.forEach((item) => {
				        	idx++
				        	dataTypeMaintenance.splice(idx, 0, item)
				        })
				        dataTypeMaintenance.forEach((item) => { dataFix.push(item) })

					   	$("#tbMilestoneFinal").empty("")
				    	
				    	$.ajax({
				    		url:"{{url('/PMO/getMilestoneById')}}",
				    		type:"GET",
				    		data:{
				    			id_pmo:window.location.href.split("/")[5].split("?")[0]
				    		},
				    		beforeSend:function(){
				                Swal.showLoading()
				            },
				    		success:function(results){
				                Swal.hideLoading()

					    		append = ""
				    				$.each(results,function(index,value){

					    			append = append + '<tr>'
									    append = append + '	<th colspan="3">'
									    	append = append + '<legend>' + index + '</legend>'
				    						$.each(value,function(idx,values){
				    						append = append + '<tr>'
									    	append = append + '<td>'
									    	append = append + '<span>' + values.text + '</span>'
									    	append = append + '	</td>'
									    	append = append + '	<td>'
									    	append = append + ' <label>Baseline Finish Date</label>'
											append = append + ' <div class="input-group">'
											append = append + ' 	<div class="input-group-text">'
											append = append + ' 		<i class="bx bx-calendar"></i>'
											append = append + ' 	</div>'
											append = append + ' 	<input style="font-size:12px" class="form-control" value="'+ moment(values.baseline_end).format('YYYY-MM-DD') +'" id="planned_date" name="planned_date" disabled/>'
											append = append + ' </div>'
									    	append = append + '	</td>'
									    	append = append + '	<td>'
									    	append = append + '<label>Actual Finish Date</label>'
									    	append = append + ' <div class="input-group">'
											append = append + ' 	<div class="input-group-text">'
											append = append + ' 		<i class="bx bx-calendar"></i>'
											append = append + ' 	</div>'
											append = append + ' 	<input style="font-size:12px" class="form-control" id="actual_date" name="actual_date" value="'+ moment(values.end_date).format('YYYY-MM-DD')+ '" disabled/>'
											append = append + ' </div>'
									    	append = append + '	</td>'
									    	append = append + '</tr>'
				    						})
									    	append = append + '	<th>'
				    					append = append + '<tr>'				    			
								    })
					   			$("#tbMilestoneFinal").append(append)

					   			let planned = Date.parse($("input[name='planned_date']:last").val())
							   	let actual = Date.parse($("input[name='actual_date']:last").val())
							   	if (planned > actual) {
							   		selectScheduleSummary("AheadSchedule")
							   	}else if (planned == actual) {
							   		selectScheduleSummary("OnSchedule")
							   	}else{
							   		selectScheduleSummary("BehindSchedule")
							   	}

							   	localStorage.setItem("cachedTextScheduleRemarks", $("#textareaScheduleRemarks").val());
					   			$("#textareaScheduleRemarks").closest(".form-group").remove()

							   	$("#tbMilestoneFinal").closest(".form-group").find("#selectScheduleSummaryFinal").closest("div .form-group").after("<div class='form-group'><label>Schedule Remarks</label><textarea class='form-control' id='textareaScheduleRemarks' placeholder='Schedule remarks'></textarea><span class='invalid-feedback' style='display:none!important'>Please fill Schedule Remarks!</span></div>")

							   	console.log($("#textareaScheduleRemarks").is(":visible"))
							   	console.log(localStorage.getItem('cachedTextScheduleRemarks'))

							   	setTimeout(function() {
							   		if (localStorage.getItem('cachedTextScheduleRemarks') != "undefined") {
								    	$("#textareaScheduleRemarks").val(localStorage.getItem('cachedTextScheduleRemarks'))
							   		}
								}, 1000);

							   	if (status == 'verify') {
							   		if (result.length > 0) {
							   			if (result[0].schedule_remarks == null) {
							   				$("#textareaScheduleRemarks").val("-").prop("disabled",true)
									   	}else{
											$("#textareaScheduleRemarks").val(result[0].schedule_remarks).prop("disabled",true)
									   	}
								   	}
							   	}else{
							   		if (result.length > 0) {
							   			if (result[0].schedule_remarks == null) {
							   				$("#textareaScheduleRemarks").val("-").prop("disabled",true)
									   	}else{
											$("#textareaScheduleRemarks").val(result[0].schedule_remarks).prop("disabled",true)
									   	}
              				reasonReject(result[0].note_reject,"block","tabGroup")
								   	}
							   	}
							   	
				    		}		    	
				    	})


					   	$("input[name='planned_date'],input[name='actual_date']").flatpickr({
					   		autoclose:true
					   	})

					   	$("input[name='actual_date']:last").change(function(){
					   		let planned = Date.parse($("input[name='planned_date']:last").val())
						   	let actual = Date.parse($("input[name='actual_date']:last").val())

						   	if (planned > actual) {
						   		selectScheduleSummary("AheadSchedule")
						   	}else if (planned == actual) {
						   		selectScheduleSummary("OnSchedule")
						   	}else{
						   		selectScheduleSummary("BehindSchedule")
						   	}
						})	

						$("#textareaScheduleRemarks").closest(".form-group").removeClass(".needs-validation")
						$("#textareaScheduleRemarks").next("span").attr('style','display:none!important')

				        $("#nextBtnFinal").attr('onclick','nextPrevAddFinal(1,"'+ status +'")')
				        $("#prevBtnFinal").attr('onclick','nextPrevAddFinal(-1,"'+ status +'")')
				    }
			    }
        	}
	    })
	   

      $("#ModalFinalProject").modal("show") 
    }

    function selectScheduleSummary(value){
    	let data = [
	        {
	          id: "AheadSchedule",
	          text: "Ahead Schedule"
	        },
	        {
	          id: "OnSchedule",
	          text: "On Schedule"
	        },
	        {
	          id: "BehindSchedule",
	          text: "Behind Schedule"
	        },
	    ];

      	$("#selectScheduleSummaryFinal").select2({
        	data:data,
        	placeholder:"Select Status"
      	}).val(value).trigger("change").prop("disabled",true)
    }

    function saveFinal(status){
    	let arrToP = [], arrPayDate = [], arrMilestoneFinal = [], arrChecklist = []
    	let pays = '', labelTask = '', plannedDate = '', actualDate = '', radio = ''
		$("#tbTermsPayment tr").each(function(){
			if ($(this).find("#inputTermsPayment").val() != undefined) {
				let terms = $(this).find("#inputTermsPayment").val() + "\n"
				arrToP.push({"termPayment":terms})

				if ($(this).find("#inputDatePayment").val() != "") {
					pays = $(this).find("#inputDatePayment").val() + "\n"
				}else{
					pays = "-" + "\n"
				}
				arrPayDate.push({"payDate":pays})
			}			
		})

		$("#tbMilestoneFinal tr").each(function(){
		    $(this).find("td:first").each(function(idx,item){
		        labelTask = item.innerHTML
		    })

		    $(this).find("td:nth-child(2)").find("input").each(function(idx,item){
		        plannedDate = item.value
		    })

		    $(this).find("td:nth-child(3)").find("input").each(function(idx,item){
		        actualDate = item.value
		    })

	        arrMilestoneFinal.push({"labelTask":labelTask,"plannedDate":plannedDate,"actualDate":actualDate})

		})

		$("#tbShowChecklistFinal tr").each(function(){
		    $(this).find("td:first").find("label").each(function(idx,item){
		        labelTask = item.innerHTML
		    })

		    $(this).find("td:nth-child(2)").find("input[type='radio']:checked").each(function(idx,item){
		        radio = item.value
		    })

		    arrChecklist.push({"labelTask":labelTask,"radioValue":radio})
		})

		if (status == 'ModalFinal') {
			swalFireCustom = {
	          title: 'Are you sure?',
	          text: "Approve Project Final",
	          icon: 'warning',
	          showCancelButton: true,
	          confirmButtonColor: '#3085d6',
	          cancelButtonColor: '#d33',
	          confirmButtonText: 'Yes',
	          cancelButtonText: 'No',
	        }

	        swalSuccess = {
	        	icon: 'success',
		        title: 'Final Report Has been Approved!',
		        text: 'Reload Pages',
	        }

	        formData = new FormData

	    	formData.append("_token","{{csrf_token()}}")
	    	formData.append("id_pmo",window.location.href.split("/")[5].split("?")[0])

	    	url = "/PMO/storeApproveFinalReport"
		}else{
			if ($("#link_feedback").val() == "") {
				$("#link_feedback").next("span").show()
				$("#link_feedback").closest(".form-group").addClass("needs-validation")
			}else if($("#textareaLessonLearn").val() == ""){
				$("#textareaLessonLearn").next("span").show()
				$("#textareaLessonLearn").closest(".form-group").addClass("needs-validation")
			}else if ($("#textareaRecommendation").val() == "") {
				$("#textareaRecommendation").next("span").show()
				$("#textareaRecommendation").closest(".form-group").addClass("needs-validation")
			}else{
				$("#link_feedback").next("span").attr('style','display:none!important')
				$("#link_feedback").closest(".form-group").removeClass("needs-validation")

				$("#textareaLessonLearn").next("span").attr('style','display:none!important')
				$("#textareaLessonLearn").closest(".form-group").removeClass("needs-validation")

				$("#textareaRecommendation").next("span").attr('style','display:none!important')
				$("#textareaRecommendation").closest(".form-group").removeClass("needs-validation")

				swalFireCustom = {
		          title: 'Are you sure?',
		          text: "Submit Project Final",
		          icon: 'warning',
		          showCancelButton: true,
		          confirmButtonColor: '#3085d6',
		          cancelButtonColor: '#d33',
		          confirmButtonText: 'Yes',
		          cancelButtonText: 'No',
		        }

		        swalSuccess = {
		        	icon: 'success',
			        title: 'Final Report Has been Created!',
			        text: 'Final Report will processed soon, please wait for further progress',
		        }

		        formData = new FormData

		    	formData.append("_token","{{csrf_token()}}")
		    	formData.append("id_pmo",window.location.href.split("/")[5].split("?")[0])
		    	formData.append("selectScheduleSummaryFinal",$("#selectScheduleSummaryFinal").val())
				formData.append("textareaScheduleRemarks",$("#textareaScheduleRemarks").val())
				formData.append("link_feedback",$("#link_feedback").val())
				formData.append("textareaLessonLearn",$("#textareaLessonLearn").val())
				formData.append("textareaAdditionalNote",$("#textareaAdditionalNote").val())
				formData.append("textareaRecomendation",$("#textareaRecommendation").val())
				formData.append("arrPayDate",JSON.stringify(arrPayDate))
				formData.append("arrToP",JSON.stringify(arrToP))
				formData.append("arrMilestoneFinal",JSON.stringify(arrMilestoneFinal))
				formData.append("arrChecklist",JSON.stringify(arrChecklist))
				formData.append("status","final")

		    	url = "/PMO/storeFinalReport"
			}

		}

   //      data = {
   //      	_token:"{{csrf_token()}}",
   //      	id_pmo:window.location.href.split("/")[5].split("?")[0],
   //      	selectScheduleSummaryFinal:$("#selectScheduleSummaryFinal").val(),
			// textareaScheduleRemarks:$("#textareaScheduleRemarks").val(),
			// link_feedback:$("#link_feedback").val(),
			// textareaLessonLearn:$("#textareaLessonLearn").val(),
			// textareaAdditionalNote:$("#textareaAdditionalNote").val(),
			// textareaRecomendation:$("#textareaRecomendation").val(),
			// arrPayDate:JSON.stringify(arrPayDate).replace("[", "").replace("]", ""),
			// arrToP:JSON.stringify(arrToP).replace("[", "").replace("]", ""),
			// arrMilestoneFinal:JSON.stringify(arrMilestoneFinal),
			// arrChecklist:JSON.stringify(arrChecklist)
   //      }

	    createPost(swalFireCustom,formData,swalSuccess,url=url)

    }

    function sendEmail(){
    	swalFireCustom = {
          title: 'Are you sure?',
          text: "Send Customer Satisfaction Survey",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No',
        }

        formData = new FormData
        formData.append("_token","{{ csrf_token() }}")
        formData.append("id_pmo",window.location.href.split("/")[5].split("?")[0])
        formData.append("bodyOpenMail",$("#bodyOpenMail").html())
        formData.append("emailOpenSubject",$("#emailOpenSubject").val())
        formData.append("emailOpenTo",$("#emailOpenTo").val())
        formData.append("emailOpenCc",$("#emailOpenCc").val())

        swalSuccess = {
        	icon: 'success',
	        title: 'Email Sended!',
	        text: 'Click Ok to reload page',
        }	        

        createPost(swalFireCustom,formData,swalSuccess,url="/PMO/sendMailCss")
    }

    let incTermsPay = 0
    function addTermsPayment(){
		incTermsPay++
		append4 = ''

		append4 = append4 + '<tr>'
		append4 = append4 + '<td>'
		append4 = append4 + '<input class="form-control" id="inputTermsPayment" data-value="'+ incTermsPay +'" name="inputTermsPayment_'+ incTermsPay +'" placeholder="[XX% - ]" />'
		append4 = append4 + '</td>'
		append4 = append4 + '<td>'
		append4 = append4 + '<input class="form-control" id="inputDatePayment" name="inputDatePayment_'+ incTermsPay +'" placeholder="Select Date" />'
		append4 = append4 + '</td>'
		append4 = append4 + '<td>'
		append4 = append4 + '<button type="button" id="btnRemoveTermsPayment" style="background-color:transparent;border:none"><i class="bx bx-trash" style="color:red"></i></button>'
		append4 = append4 + '</td>'
		append4 = append4 + '</tr>'

		$("#tbodyTermsPayment").append(append4)

		$("input[name='inputDatePayment_"+ incTermsPay +"']").flatpickr({autoclose:true})
	}

	$(document).on('click', '#btnRemoveTermsPayment', function() {
      $(this).closest("tr").remove();
    })

    function nextPrevAddFinal(n,status){
    	if (currentTab == 1) {
    		if (n == 1) {
    			if (status == 'update') {
    				if ($("#textareaScheduleRemarks").val() == "") {
		    			$("#textareaScheduleRemarks").closest(".form-group").addClass("needs-validation")
		    			$("#textareaScheduleRemarks").next("span").show()
		    		}else{
		    			formData = new FormData;
				        formData.append("_token","{{csrf_token()}}")
				        formData.append("id_pmo",window.location.href.split("/")[5].split("?")[0])
				        formData.append("selectScheduleSummaryFinal",$("#selectScheduleSummaryFinal").val())
				        formData.append("textareaScheduleRemarks",$("#textareaScheduleRemarks").val())

				        $.ajax({
				            url:"{{url('/PMO/storeScheduleRemarksFinalReport')}}",
				            type:"POST",
				            processData: false,
				            contentType: false,
				            data:formData
				            ,success:function(){
				              let x = document.getElementsByClassName("tab-add-final");
						        x[currentTab].style.display = "none";
						        currentTab = currentTab + n;
						        if (currentTab >= x.length) {
						          x[n].style.display = "none";
						          currentTab = 0;
						        }
						        btnFinalProject(currentTab,status); 
				            }
				        })
		    		}
    			}else{
    	console.log("sini")
    				if ($("#textareaScheduleRemarks").val() == "") {
		    			$("#textareaScheduleRemarks").closest(".form-group").addClass("needs-validation")
		    			$("#textareaScheduleRemarks").next("span").show()
		    		}else{
		    			let x = document.getElementsByClassName("tab-add-final");
				        x[currentTab].style.display = "none";
				        currentTab = currentTab + n;
				        if (currentTab >= x.length) {
				          x[n].style.display = "none";
				          currentTab = 0;
				        }
				        btnFinalProject(currentTab,status);
		    		}
    			}
    		}else{
    	console.log("situ")
    			let x = document.getElementsByClassName("tab-add-final");
		        x[currentTab].style.display = "none";
		        currentTab = currentTab + n;
		        if (currentTab >= x.length) {
		          x[n].style.display = "none";
		          currentTab = 0;
		        }
		        btnFinalProject(currentTab,status); 
    		}    		
    	}else if (currentTab == 2) {
    		if (status == 'update') {
    			let arrToP = [], arrPayDate = [], arrMilestoneFinal = [], arrChecklist = []
		    	let pays = '', labelTask = '', plannedDate = '', actualDate = '', radio = ''
				$("#tbTermsPayment tr").each(function(){
					if ($(this).find("#inputTermsPayment").val() != undefined) {
						let terms = $(this).find("#inputTermsPayment").val() + "\n"
						arrToP.push({"termPayment":terms})

						if ($(this).find("#inputDatePayment").val() != "") {
							pays = $(this).find("#inputDatePayment").val() + "\n"
						}else{
							pays = "-" + "\n"
						}
						arrPayDate.push({"payDate":pays})
					}			
				})

				// $("#tbMilestoneFinal tr").each(function(){
				//     $(this).find("td:first").each(function(idx,item){
				//         labelTask = item.innerHTML
				//     })

				//     $(this).find("td:nth-child(2)").find("input").each(function(idx,item){
				//         plannedDate = item.value
				//     })

				//     $(this).find("td:nth-child(3)").find("input").each(function(idx,item){
				//         actualDate = item.value
				//     })

			 //        arrMilestoneFinal.push({"labelTask":labelTask,"plannedDate":plannedDate,"actualDate":actualDate})

				// })

				$("#tbShowChecklistFinal tr").each(function(){
				    $(this).find("td:first").find("label").each(function(idx,item){
				        labelTask = item.innerHTML
				    })

				    $(this).find("td:nth-child(2)").find("input[type='radio']:checked").each(function(idx,item){
				        radio = item.value
				    })

				    arrChecklist.push({"labelTask":labelTask,"radioValue":radio})
				})

				formData = new FormData;
		        formData.append("_token","{{csrf_token()}}")
		        formData.append("id_pmo",window.location.href.split("/")[5].split("?")[0])
		        formData.append("link_feedback",$("#link_feedback").val())
				formData.append("textareaLessonLearn",$("#textareaLessonLearn").val())
				formData.append("textareaAdditionalNote",$("#textareaAdditionalNote").val())
				formData.append("textareaRecomendation",$("#textareaRecomendation").val())
				formData.append("arrPayDate",JSON.stringify(arrPayDate))
				formData.append("arrToP",JSON.stringify(arrToP))
				// formData.append("arrMilestoneFinal",JSON.stringify(arrMilestoneFinal))
				formData.append("arrChecklist",JSON.stringify(arrChecklist))
				formData.append("status","draft")

		        $.ajax({
		            url:"{{url('/PMO/storeFinalReport')}}",
		            type:"POST",
		            processData: false,
		            contentType: false,
		            data:formData
		            ,success:function(){
		              let x = document.getElementsByClassName("tab-add-final");
				        x[currentTab].style.display = "none";
				        currentTab = currentTab + n;
				        if (currentTab >= x.length) {
				          x[n].style.display = "none";
				          currentTab = 0;
				        }
				        btnFinalProject(currentTab,status); 
		            }
		        })
			}else{
				let x = document.getElementsByClassName("tab-add-final");
		        x[currentTab].style.display = "none";
		        currentTab = currentTab + n;
		        if (currentTab >= x.length) {
		          x[n].style.display = "none";
		          currentTab = 0;
		        }
		        btnFinalProject(currentTab,status); 
			}
    	}else{
			let x = document.getElementsByClassName("tab-add-final");
	        x[currentTab].style.display = "none";
	        currentTab = currentTab + n;
	        if (currentTab >= x.length) {
	          x[n].style.display = "none";
	          currentTab = 0;
	        }

	        btnFinalProject(currentTab,status);
    	}
    	
    }

    function cancelModal(value){
      $("#"+value).modal("hide")
      currentTab = 0
    }

    function saveIssue(){
    	if ($("#textareaDescIssue").val() == "") {
    		$("#textareaDescIssue").closest("div").addClass("needs-validation")
        	$("#textareaDescIssue").next("span").show()
    	}else if ($("#textareaSolutionPlan").val() == "") {
    		$("#textareaSolutionPlan").closest("div").addClass("needs-validation")
        	$("#textareaSolutionPlan").next("span").show()
    	}else if ($("#inputOwnerIssue").val() == "") {
    		$("#inputOwnerIssue").closest("div").addClass("needs-validation")
        	$("#inputOwnerIssue").next("span").show()
    	}else if ($("#inputRatingIssue").val() == "") {
    		$("#inputRatingIssue").closest("div").addClass("needs-validation")
        	$("#inputRatingIssue").next("span").show()
    	}else if ($("#expected_date").val() == "") {
    		$("#expected_date").closest(".form-group").addClass("needs-validation")
          	$("#expected_date").closest(".form-group").find("span.invalid-feedback").show()
    	}
    	// else if ($("#actual_date").val() == "") {
    	// 	$("#actual_date").closest(".form-group").addClass("needs-validation")
     //     	$("#actual_date").closest(".form-group").find("span.invalid-feedback").show()
    	// }
    	else if ($("#selectStatusIssue").val() == null) {
    		$("#selectStatusIssue").closest("div").addClass("needs-validation")
        	$("#selectStatusIssue").next("span").next(".invalid-feedback").show()
    	}else{
        	swalFireCustom = {
	          title: 'Are you sure?',
	          text: "Submit Issue & Problems",
	          icon: 'warning',
	          showCancelButton: true,
	          confirmButtonColor: '#3085d6',
	          cancelButtonColor: '#d33',
	          confirmButtonText: 'Yes',
	          cancelButtonText: 'No',
	        }

	        formData = new FormData
	          formData.append("_token","{{ csrf_token() }}")
	          formData.append("id",$("#id_issue").val())
	          formData.append("id_pmo",window.location.href.split("/")[5].split("?")[0])
	          formData.append("textareaDescIssue",$("#textareaDescIssue").val())
	          formData.append("textareaSolutionPlan",$("#textareaSolutionPlan").val())
	          formData.append("inputOwnerIssue",$("#inputOwnerIssue").val())
	          formData.append("inputRatingIssue",$("#inputRatingIssue").val())
	          formData.append("expected_date",$("#expected_date").val())
	          formData.append("actual_date",$("#actual_date").val())
	          formData.append("selectStatusIssue",$("#selectStatusIssue").val())

	        // data = {
	        //   _token:"{{ csrf_token() }}",
	        //   id_pmo:window.location.href.split("/")[5].split("?")[0],
	        //   textareaDescIssue:$("#textareaDescIssue").val(),
	        //   textareaSolutionPlan:$("#textareaSolutionPlan").val(),
	        //   inputOwnerIssue:$("#inputOwnerIssue").val(),
	        //   inputRatingIssue:$("#inputRatingIssue").val(),
	        //   expected_date:$("#expected_date").val(),
	        //   actual_date:$("#actual_date").val(),
	        //   selectStatusIssue:$("#selectStatusIssue").val(),
	        // }

	        if ($("#id_risk").val() != '') {
	        	swalSuccess = {
		        	icon: 'success',
			        title: 'Issue & Problems has been updated!',
			        text: 'Click Ok to reload page',
		        }
	        }else{
	        	swalSuccess = {
		        	icon: 'success',
			        title: 'Issue & Problems has been added!',
			        text: 'Click Ok to reload page',
		        }
	        }
	        

	        createPost(swalFireCustom,formData,swalSuccess,url="/PMO/postIssueProblems")
        }
    }

    function saveDocument(){
    	if ($("#sub_task_document").val() == "") {
        	$("#sub_task_document").closest("div").addClass("needs-validation")
        	$("#sub_task_document").closest(".form-group").find(".invalid-feedback").show()
        }else{
        	$numItems = $("#tbodyUploadDoc tr").length;
			$i = 0;

        	$("#tbodyUploadDoc tr").each(function(){
        		if ($(this).find('input[name="inputDoc"]').val() == "") {
        			$(this).find('input[name="inputDoc"]').closest("div").next(".invalid-feedback").show()
        		}else if ($(this).find('input[name="inputDocName"]').val() == "") {
        			$(this).find('input[name="inputDocName"]').next(".invalid-feedback").show()
        		}else{
        			if(++$i === $numItems) {
				       saveTab()
				    }
        		}
        		
        	})

        	function saveTab(){
        		formData = new FormData
        	
	        	let arrInputDoc = []
				$("#tbodyUploadDoc tr").each(function(){
	        		formData.append('inputDoc[]',$(this).find('input[name="inputDoc"]').prop('files')[0])
			        arrInputDoc.push({
			           nameDoc:$(this).find('input[name="inputDocName"]').val(),
			        })
	        	})

	        	formData.append("_token","{{ csrf_token() }}")
		        formData.append("arrInputDoc",JSON.stringify(arrInputDoc))
		        formData.append("id_pmo",window.location.href.split("/")[5].split("?")[0])
		        formData.append("sub_task",$("#sub_task_document").val())

	        	swalFireCustom = {
		          title: 'Are you sure?',
		          text: "Submit Document",
		          icon: 'warning',
		          showCancelButton: true,
		          confirmButtonColor: '#3085d6',
		          cancelButtonColor: '#d33',
		          confirmButtonText: 'Yes',
		          cancelButtonText: 'No',
		        }


		        swalSuccess = {
		        	icon: 'success',
			        title: 'Document has been added!',
			        text: 'Click Ok to reload page',
		        }

				createPost(swalFireCustom,formData,swalSuccess,url="/PMO/storeDocument")  
        	}

        }
    }

    function saveRisk(){
    	if ($("#textAreaRisk").val() == "") {
	        $("#textAreaRisk").closest("div").addClass("needs-validation")
	        $("#textAreaRisk").next("span").show()
	    }else if ($("#inputOwner").val() == "") {
	        $("#inputOwner").closest("div").addClass("needs-validation")
	        $("#inputOwner").next("span").show()
	    }else if ($("#inputImpact").val() == "") {
	        $("#inputImpact").closest("div").addClass("needs-validation")
	        $("#inputImpact").next("span").show()
	    }else if ($("#inputLikelihood").val() == "") {
	        $("#inputLikelihood").closest("div").addClass("needs-validation")
	        $("#inputLikelihood").next("span").show()
	    }else if ($("#inputRank").val() == "") {
	        $("#inputRank").closest("div").addClass("needs-validation")
	        $("#inputRank").next("span").show()
	    }else if ($("#textareaDescription").val() == "") {
	        $("#textareaDescription").closest("div").addClass("needs-validation")
	        $("#textareaDescription").next("span").show()
	    }else if ($("#textareaResponse").val() == "") {
	        $("#textareaResponse").closest("div").addClass("needs-validation")
	        $("#textareaResponse").next("span").show()
	    }else if ($("#due_date").val() == "") {
	        $("#due_date").closest(".form-group").addClass("needs-validation")
	        $("#due_date").closest(".form-group").find("span").show()
	    }else if ($("#review_date").val() == "") {
	        $("#review_date").closest(".form-group").addClass("needs-validation")
	        $("#review_date").closest(".form-group").find("span").show()
	    }else if ($("#selectStatusRisk").val() == null) {
	        $("#selectStatusRisk").closest("div").addClass("needs-validation")
	        $("#selectStatusRisk").next("span").show()
	    }else{
	    	swalFireCustom = {
	          title: 'Are you sure?',
	          text: "Submit Risk",
	          icon: 'warning',
	          showCancelButton: true,
	          confirmButtonColor: '#3085d6',
	          cancelButtonColor: '#d33',
	          confirmButtonText: 'Yes',
	          cancelButtonText: 'No',
	        }

	        formData = new FormData
	          formData.append("_token","{{ csrf_token() }}")
	          formData.append("id",$("#id_risk").val())
	          formData.append("id_pmo",window.location.href.split("/")[5].split("?")[0])
	          formData.append("textAreaRisk",$("#textAreaRisk").val())
	          formData.append("inputOwner",$("#inputOwner").val())
	          formData.append("inputImpact",$("#inputImpact").val())
	          formData.append("inputLikelihood",$("#inputLikelihood").val())
	          formData.append("inputRank",$("#inputRank").val())
	          formData.append("textareaDescription",$("#textareaDescription").val())
	          formData.append("textareaResponse",$("#textareaResponse").val())
	          formData.append("due_date",$("#due_date").val())
	          formData.append("review_date",$("#review_date").val())
	          formData.append("selectStatusRisk",$("#selectStatusRisk").val())

	        // data = {
	        //   _token:"{{ csrf_token() }}",
	        //   id_pmo:window.location.href.split("/")[5].split("?")[0],
	        //   textAreaRisk:$("#textAreaRisk").val(),
	        //   inputOwner:$("#inputOwner").val(),
	        //   inputImpact:$("#inputImpact").val(),
	        //   inputLikelihood:$("#inputLikelihood").val(),
	        //   inputRank:$("#inputRank").val(),
	        //   textareaDescription:$("#textareaDescription").val(),
	        //   textareaResponse:$("#textareaResponse").val(),
	        //   due_date:$("#due_date").val(),
	        //   review_date:$("#review_date").val(),
	        //   selectStatusRisk:$("#selectStatusRisk").val(),
	        // }

	        if ($("#id_risk").val() != '') {
	        	swalSuccess = {
		        	icon: 'success',
			        title: 'Risk has been updated!',
			        text: 'Click Ok to reload page',
		        }
	        }else{
	        	swalSuccess = {
		        	icon: 'success',
			        title: 'Risk has been added!',
			        text: 'Click Ok to reload page',
		        }
	        }	        

	        createPost(swalFireCustom,formData,swalSuccess,url="/PMO/postRisk")
	    }
    }

    function createPost(swalFireCustom,data,swalSuccess,url){
    	Swal.fire(swalFireCustom).then((result) => {
          if (result.value) {
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
	                  	didOpen: () => {
	                      Swal.showLoading()
	                  	}
	              	})
	            },
              	success: function(result){
            		Swal.fire(swalSuccess).then((result) => {
                  		if (result.value) {
                  			// window.history.pushState(null,null,location.protocol + '//' + location.host + location.pathname + "?project_type=" + window.location.href.split("?")[1].split("&")[0].split("=")[1])
                  			// window.history.pushState(null,null,location.protocol + '//' + location.host + location.pathname + "?" + window.location.href.split("?")[1])
                  			if (window.location.href.split("&")[1] === undefined) {
                    			location.reload() 
                  			}
                    		Swal.close()                   
                  		}
            		})
          		},
          		error: function(xhr,status,error){
          			// Log the error for debugging purposes
			        console.log('Error Status:', status);
			        console.log('XHR:', xhr);
			        console.log('Error:', error);

			        // Show an alert or error message to the user
			        alert('An error occurred: ' + xhr.responseJSON.message);
          		}
            })
          }else{
          	if (url == "/PMO/storeMilestone") {
          		// window.onbeforeunload = function() { 
				// 	return "Your work will be lost."; 
				// };
          	}          	
          }
      })
    }

    function validationCheck(data){    	
    	if($("#"+ $(data).attr('id')).val() != ""){
          $("#"+ $(data).attr('id')).closest(".form-group").removeClass("needs-validation")
          $("#"+ $(data).attr('id')).next("span.invalid-feedback").attr('style','display:none!important')

          $("#"+ $(data).attr('id')).closest(".form-group").removeClass("needs-validation")
          $("#"+ $(data).attr('id')).closest(".form-group").find("span.invalid-feedback").attr('style','display:none!important')

          $("input[name='"+ $(data).attr('name') + "']").closest(".form-group").removeClass("needs-validation")
          $("input[name='"+ $(data).attr('name') + "']").closest(".form-group").find("span.invalid-feedback").attr('style','display:none!important')
        }

        if ($("#"+ $(data).attr('id')).attr("id") == "inputImpact" || $("#"+ $(data).attr('id')).attr("id") == "inputLikelihood") {
        	$("#inputRank").val(parseInt($("#inputImpact").val()) * parseInt($("#inputLikelihood").val())) 
        }
    }

    $('#ModalWeekly').on('hidden.bs.modal', function () {
      $(".tab-add").css('display','none')
      currentTab = 0
      n = 0
    })

    $('#ModalFinalProject').on('hidden.bs.modal', function () {
      $(".tab-add-final").css('display','none')
      currentTab = 0
      n = 0
    })

 	function showEmail(){
	    firstPage = false
    	$(".content-title").text("Send Customer Satisfaction Survey")
    	$(".detail_project").attr('style','display:none!important')
    	$(".showEmail").show()
    	$(".showEmail").empty("")
	    append = ""
	    append = append + '<div class="row">'
		    append = append + '<div class="col-md-12">'
		      append = append + '<div class="card mb-4">'
		        append = append + '<div class="card-body">'
		          append = append + '<div class="form-horizontal">'
		            append = append + '<div class="form-group">'
		              append = append + '<label class="col-sm-1 control-label">'
		                append = append + 'To : '
		              append = append + '</label>'
		              append = append + '<div class="col-sm-11">'
		                append = append + '<input class="form-control" name="emailTo" id="emailOpenTo">'
		              append = append + '</div>'
		              append = append + '<div class="col-sm-11 col-sm-offset-1 invalid-feedback" style="margin-bottom: 0px;">'
		              append = append + '</div>'
		            append = append + '</div>'
		            append = append + '<div class="form-group">'
		              append = append + '<label class="col-sm-1 control-label">'
		                append = append + 'Cc :'
		              append = append + '</label>'
		              append = append + '<div class="col-sm-11">'
		                append = append + '<input class="form-control" name="emailCc" id="emailOpenCc">'
		              append = append + '</div>'
		            append = append + '</div>'
		            append = append + '<div class="form-group">'
		              append = append + '<label class="col-sm-1 control-label">'
		                append = append + 'Subject :'
		              append = append + '</label>'
		              append = append + '<div class="col-sm-11">'
		                append = append + '<input class="form-control" name="emailSubject" id="emailOpenSubject">'
		              append = append + '</div>'
		            append = append + '</div>'
		            append = append + '<div class="form-group">'
		              append = append + '<div class="col-sm-12">'
		                append = append + '<div contenteditable="true" class="form-control" style="height: 600px;overflow: auto;" id="bodyOpenMail">'
		                append = append + '</div>'
		              append = append + '</div>'
		            append = append + '</div>'
		            append = append + '<div class="form-group">'
		              append = append + '<div class="col-sm-12">'
		                  append = append + '<button class="btn btn-flat btn-primary pull-right" style="display:inline" onclick="sendEmail()"><i class="bx bx-envelope-o"></i> Send</button>'
		                append = append + '</div>'
		              append = append + '</div>'
		            append = append + '</div>'
		          append = append + '</div>'
		        append = append + '</div>'
		      append = append + '</div>'      
		    append = append + '</div>'
	    append = append + '</div>'

	    $(".showEmail").append(append)

	    createEmailBody()
  	}



  	function createEmailBody(){
	  	$('.emailMultiSelector').remove()
	    
	    // $.ajax({
	    //   url:"{{url('/admin/getEmailTemplate')}}",
	    //   data:{
	    //     no_pr:window.location.href.split("/")[5],
	    //   },
	    //   type:"GET",
	    //   success: function (result){ 
	    //   }
	    // })  

	    $("#emailOpenTo").emailinput({ onlyValidValue: true, delim: ';' });
        $("#emailOpenCc").emailinput({ onlyValidValue: true, delim: ';' });

	    $.ajax({
	      type:"GET",
	      url:"{{url('/PMO/showProjectCharter')}}",
	      data:{
	        id_pmo:window.location.href.split("/")[5].split("?")[0],
	      },
	      success: function(result){
	        // arrEmailCc = []
	        // $.each(result.cc,function(value,item){
	          
	        //   arrEmailCc.push(item.email)
	        // })
	        // arrEmailCcJoin = arrEmailCc.filter(function(i) {
	        //     if (i != null || i != false)
	        //         return i;
	        // }).join(";")

	        $("#bodyOpenMail").html("<span style='font-family: Lucida Sans Unicode, sans-serif;'>Dear <b>"+ result[0].customer_name +"</b></span><br><br><span style='font-family: Lucida Sans Unicode, sans-serif;'>Dengan ini Project "+ result[0].project_type +" pada "+ result[0].customer_name +" telah selesai sesuai dengan tenggat waktu yang ditentukan. Berikut ini terlampir link CSS (Customer Satisfaction Survey), diharapkan pihak "+ result[0].customer_name +" bisa mengisi CSS yang sudah diberikan.</span><br><br>" + "<span style='color:blue'>{Mohon timpa dengan link google form CSS}</span><br><br> Terima Kasih.") 
	       
	        // $("#emailOpenTo").val(result.to)
	        // $("#emailOpenCc").val(arrEmailCcJoin)
	        // $("#emailOpenSubject").val(result.subject);
	      }
	      // ,complete: function(){
	      //   $("#emailOpenTo").emailinput({ onlyValidValue: true, delim: ';' });
	      //   $("#emailOpenCc").emailinput({ onlyValidValue: true, delim: ';' });
	      // }
	    })
  	}

  	var url = {!! json_encode(url('/')) !!}
  	function exportExcelRisk(){
      	myUrl       = url+"/PMO/exportRiskExcel?id_pmo="+window.location.href.split("/")[5].split("?")[0]
      	location.assign(myUrl)
  	}

  	function exportExcelIssue(){
  		myUrl       = url+"/PMO/exportIssueExcel?id_pmo="+window.location.href.split("/")[5].split("?")[0]
      	location.assign(myUrl)
  	}

  	function deleteDoc(id_document){
		swalFireCustom = {
          title: 'Are you sure?',
          text: "Delete this document",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No',
        }

        formData = new FormData
        formData.append("_token","{{ csrf_token() }}")
        formData.append("id_doc",id_document)
        formData.append("id_pmo",window.location.href.split("/")[5].split("?")[0])

        swalSuccess = {
        	icon: 'success',
	        title: 'Document has been deleted!',
	        text: 'Click Ok to reload page',
        }	        

        createPost(swalFireCustom,formData,swalSuccess,url="/PMO/deleteDoc")
  	}

  	$('#tbChangeLog').DataTable({
		ajax:{
        	url:"{{url('PMO/getAllActivity')}}",
        	data:{
        		id_pmo:window.location.href.split("/")[5].split("?")[0]
        	},
        	dataSrc:"data"
      	},
        "columns": [
            {title: "No",width:"5%",
            	render:function(data, type, row,meta)
                {	
                	return ++meta.row                     
                },
        	},
            {title: "Activity",data:"activity"},
            {title: "Operator",data:"operator"},
            {title: "Date",data:"date_time"},
        ],
	})

	function btnDeleteTaskCustom(val){
        var whichtr = val.closest("div").closest(".row").closest(".form-group");
        whichtr.remove();  
	}

	function btnDeleteTaskDefined(val){
        var whichtr = val.closest("div").closest(".row").closest(".form-group");
        whichtr.remove();  
	}


	setTimeout(function() {
		if (firstPage) {
			if (window.location.href.indexOf("id_risk") != -1){
			//from email
				btnUpdateStatusRisk(window.location.href.split("?")[1].split("=")[1])
		      	$('#ModalRisk').on('hidden.bs.modal', function () {
		        	window.history.pushState(null,null,location.protocol + '//' + location.host + location.pathname + "?project_type=" + window.location.href.split("?")[1].split("&")[0].split("=")[1])
		      	})
			}else if (window.location.href.indexOf("status") != -1) {
				btnFinalProject(0,window.location.href.split("?")[1].split("&")[1].split("=")[1])
				$('#ModalFinalProject').on('hidden.bs.modal', function () {
		        	window.history.pushState(null,null,location.protocol + '//' + location.host + location.pathname + "?project_type=" + window.location.href.split("?")[1].split("&")[0].split("=")[1])
		      	})
			}else if (window.location.href.split("?")[1].split("&")[1] != undefined) {
				if (window.location.href.split("?")[1].split("&")[1].split("=")[1] == 'defined') {
					btnshowMilestone('show','defined')
				}else{
					btnshowMilestone('show','custom')
				}
			}
		} 
	}, 1000);
</script>
@endsection
