@extends('template.main_sneat')
@section('tittle')
Lead Register
@endsection
@section('pageName')
Lead Register
@endsection
@section('head_css')
<!--datepicker-->
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}"/>
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
<style type="text/css">
	.bg-orange-custom {
	  background-color: #f2562b!important;
	  color: white;
	  opacity:35%;
	}

	.bg-aqua-custom{
		background-color:#04dda3!important;
		color: white;
		opacity:35%;
	}

	.bg-yellow-custom{
		background-color:#f7e127!important;
		color: white;
		opacity:35%;
	}

	.bg-green-custom{
		background-color:#246d18!important;
		color: white;
	}
	.bg-red-custom{
		background-color:#e5140d!important;
		color: white;
	}

	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
	  -webkit-appearance: none;
	  margin: 0;
	}

	/* Firefox */
	input[type=number] {
	  -moz-appearance: textfield;

	}

	.dataTables_filter {
		display: none!important;
	}

	.needs-validation .select2-selection {
	    border-color: rgb(185, 74, 72) !important;
	}

	.select2{
		width: 100%;
	}

	.btn-width-custom{
		width: 50px;
		margin-right: 5px;
		margin-bottom: 5px;
	}

	.status-initial{
		padding: .35em;
	    font-size: 75%;
	    font-weight: 700;
	    color: #fff;
	    text-align: center;
	    white-space: nowrap;
	    vertical-align: center;
	    border-radius: .25em;
	    background-color: #7735a3;
	    text-align: center;
	    width: 50px;
	    color: white;
	}

	.status-open{
	    padding: .35em;
	    font-size: 75%;
	    font-weight: 700;
	    color: #fff;
	    text-align: center;
	    white-space: nowrap;
	    vertical-align: center;
	    border-radius: .25em;
	    background-color: #f2562b;
	    text-align: center;
	    width: 50px;
	    color: white;
	}
	.status-pending{
		padding: .35em;
	    font-size: 75%;
	    font-weight: 700;
	    color: #fff;
	    text-align: center;
	    white-space: nowrap;
	    vertical-align: center;
	    border-radius: .25em;
	    background-color: #ced2d9;
	    text-align: center;
	    width: 50px;
	    color: white;
	}
	.status-sd{
	    padding: .35em;
	    font-size: 75%;
	    font-weight: 700;
	    color: #fff;
	    text-align: center;
	    white-space: nowrap;
	    vertical-align: center;
	    border-radius: .25em;
	    background-color: #04dda3;
	    text-align: center;
	    width: 50px;
	    color: white;
	}
	.status-tp{
	    padding: .35em;
	    font-size: 75%;
	    font-weight: 700;
	    color: #fff;
	    text-align: center;
	    white-space: nowrap;
	    vertical-align: center;
	    border-radius: .25em;
	    background-color: #f7e127;
	    text-align: center;
	    width: 50px;
	    color: white;
	}
	.status-win{
	    padding: .35em;
	    font-size: 75%;
	    font-weight: 700;
	    color: #fff;
	    text-align: center;
	    white-space: nowrap;
	    vertical-align: center;
	    border-radius: .25em;
	    background-color: #246d18;
	    text-align: center;
	    width: 50px;
	    color: white;
	}
	.status-lose{
	    padding: .35em;
	    font-size: 75%;
	    font-weight: 700;
	    color: #fff;
	    text-align: center;
	    white-space: nowrap;
	    vertical-align: center;
	    border-radius: .25em;
	    background-color: #e5140d;
	    text-align: center;
	    width: 50px;
	    color: white;
	}

	.form-group{
		margin-bottom: 15px;
	}

	.swal2-container {
	    z-index: 999999!important;
	}
</style>
@endsection
@section('content')
	<div class="container-xxl flex-grow-1 container-p-y">
		<section class="content">
			<div class="row mb-4" id="BoxId" style="display:none!important;">
	        <!--card id-->
	  		</div>

		  	<div class="row">
		  		<div class="col-lg-2 col-xs-12">
		  			<section class="sidebar">
		  				<div class="card card-primary">
			  				<div class="card-header with-border">
								<h6 class="card-title"><i class="bx bx-filter"></i>Filter</h6>
							</div>
			  				<div class="card-body" id="filter-body">
		  						<div class="form-group">
									<label>Tahun</label>
									<div id="filter_year_for_dir" style="display:none!important">
										<div class="row">
											<div style="display: inline;padding-right: 5px!important;padding-left: 5px!important;" class="col-md-6">	
												<select class="select2 form-control" style="width:100%;display: inline;float: left;" id="year_dif_dir" multiple>
												@foreach($year as $years)
									              @if($years->year < $year_now-1)
									              {{-- @if($years->year < $year_now) --}}
									                <option id="{{$years->year}}" value="{{$years->year}}">{{$years->year}}</option>
									              @endif
									            @endforeach
									              	<option id="{{date('Y')-1}}" value="{{date('Y')-1}}">{{date("Y")-1}}</option>
										            <option id="{{$year_now}}" selected value="{{$year_now}}">{{$year_now}}</option>
												</select>
											</div>

											<div style="display: inline;padding-right: 5px!important;padding-left: 5px!important;" class="col-md-6">
												<select class="select2 form-control" style="width:100%;display: inline;float: left;" id="year_dif2_dir" multiple>
													@foreach($year as $years)
										              @if($years->year < $year_now-1)
										              {{-- @if($years->year < $year_now) --}}
										                <option id="{{$years->year}}" value="{{$years->year}}">{{$years->year}}</option>
										              @endif
										            @endforeach
										            <option id="{{date('Y')-1}}" value="{{date('Y')-1}}">{{date("Y")-1}}</option>
										            <option id="{{$year_now}}" value="{{$year_now}}">{{$year_now}}</option>
												</select>
											</div>
										</div>
									</div>
									<div id="filter_year_for_oth" style="display:none!important">
										<select class="select2 form-control" style="width:100%;display: inline;float: left;" id="year_dif" multiple>
											@foreach($year as $years)
							              		@if($years->year < $year_now-1)
								              	{{-- @if($years->year < $year_now) --}}
								                	<option value="{{$years->year}}">{{$years->year}}</option>
								              	@endif
								            @endforeach
						              		<option selected value="{{date('Y')-1}}">{{date("Y")-1}}</option>
					            			<option selected value="{{$year_now}}">{{$year_now}}</option>
										</select>
									</div>
								</div>
								<div class="form-group" id="filter-com" style="display:none!important;">								
								</div>
								<div class="form-group" id="filter-territory" style="display:none!important;">								
								</div>
								<div class="form-group" id="filter-sales" style="display:none!important;">
										<label>Sales</label>
								  		<select class="form-control select2" style="width: 100%;" id="filter_sales"  name="filter_sales">
		              					</select>
								</div>
								<div class="form-group" id="filter-sales-manager" style="display:none!important;">
									<label>Sales</label>
								  	<select class="form-control select2" style="width: 100%;" id="filter_sales_manager"  name="filter_sales_manager">
		              				</select>
								</div>
								<div class="form-group" id="filter-ta" style="display:none!important;">
									<label>Technology Alliance</label>
								  	<select class="form-control select2" style="width: 100%;" id="filter_ta"  name="filter_ta">
		              				</select>
								</div>
								<div class="form-group" id="filter-presales" style="display:none!important;">
									<label>Presales</label>
								  	<select class="form-control select2" style="width: 100%;" id="filter_presales"  name="filter_presales">
		              				</select>
								</div>
								<div class="form-group" id="filter-customer">
									<label>Customer</label>
									<select class="form-control select2" style="width: 100%" id="filter_customer" name="filter_customer"></select>
								</div>
								<div class="form-group" id="filter-result">
								</div>
								<div class="form-group">
									<label>Tag Product & Technology</label>
								  	<select class="form-control select2" style="width: 100%;" id="searchTags"  name="searchTags">
		              				</select>
								</div>
							</div>  				
			  			</div>	
		  			</section>
		  		</div>
		  		<div class="col-lg-10 col-xs-12">
		  			<div class="card card-primary">
							<div class="card-header with-border">
								<h6 class="card-title"><i class="bx bx-table"></i> Lead Register</h6>
					    </div>
					    <div class="card-body">
					    	<div class="row">
					    		<dir class="col-md-6" style="margin-bottom: 0px; margin-top: 0px;">	
					    			<button type="button" class="btn btn-sm btn-primary" style="height:30px;display: none;" id="btn_add_sales" onclick="add_lead()"><i class="bx bx-plus"> </i>&nbsp Lead Register</button>		    		
						    	</dir>
								<dir class="col-md-6 text-right" style="margin-bottom: 0px; margin-top: 0px;">
									<div class="input-group">
										<input id="searchLead" type="text" class="form-control" onkeyup="searchCustom('tableLead','searchLead')" placeholder="Search Anything">			
										<button type="button" id="btnShowEntryLead" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
											Show 10 entries
										</button>
										<ul class="dropdown-menu">
											<li><a class="dropdown-item" href="#" onclick="$('#tableLead').DataTable().page.len(10).draw();$('#btnShowEntryLead').html('Show 10 entries')">10</a></li>
											<li><a class="dropdown-item" href="#" onclick="$('#tableLead').DataTable().page.len(25).draw();$('#btnShowEntryLead').html('Show 25 entries')">25</a></li>
											<li><a class="dropdown-item" href="#" onclick="$('#tableLead').DataTable().page.len(50).draw();$('#btnShowEntryLead').html('Show 50 entries')">50</a></li>
											<li><a class="dropdown-item" href="#" onclick="$('#tableLead').DataTable().page.len(100).draw();$('#btnShowEntryLead').html('Show 100 entries')">100</a></li>
										</ul>
										<!--<button onclick="searchCustom('tableLead','searchLead')" type="button" class="btn btn-outline-primary">
											<i class="bx bx-fw bx-search"></i>
										</button> -->
										<button type="button" id="btnShowColumnTicket" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
												Displayed Column
										</button>
										<ul class="dropdown-menu dropdown-menu-end" style="padding-left:5px;padding-right: 5px;" id="selectShowColumnTicket">
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" checked type="checkbox" onclick="changeColumnTable(this)" data-column="0"><span class="text">Lead ID</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" checked type="checkbox" onclick="changeColumnTable(this)" data-column="1"><span class="text">Customer</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" checked type="checkbox" onclick="changeColumnTable(this)" data-column="2"><span class="text">Opty Name</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" checked type="checkbox" onclick="changeColumnTable(this)" data-column="3"><span class="text">Create Date</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" checked type="checkbox" onclick="changeColumnTable(this)" data-column="4"><span class="text">Closing Date</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" checked type="checkbox" onclick="changeColumnTable(this)" data-column="5"><span class="text">Owner</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" checked type="checkbox" onclick="changeColumnTable(this)" data-column="6"><span class="text">Technology Alliance</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" checked type="checkbox" onclick="changeColumnTable(this)" data-column="7"><span class="text">Presales</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" checked type="checkbox" onclick="changeColumnTable(this)" data-column="8"><span class="text">Amount</span></li>
											<li style="cursor: pointer;"><input style="margin: 0 10px 0 5px;" checked type="checkbox" onclick="changeColumnTable(this)" data-column="9"><span class="text">Status</span></li>
										</ul>
									</div>
								</dir>			    		
					    	</div>			    	
					    	<div class="table-responsive mt-4">
					    		<table id="tableLead" class="table table-bordered table-striped display dataTables_wrapper" width="100%" role="grid" aria-describedby="example1_info">
					        	<thead>
									<tr>
										<th>Lead ID</th>
										<th>Customer</th>
										<th>Opty Name</th>
										<th>Create Date</th>
										<th>Closing Date</th>
										<th>Owner</th>
										<th>Technology Alliance</th>
										<th>Presales</th>
										<th>Amount</th>
										<th>Status</th>
										<th>Action</th>
										<th>orderable amount</th>
									</tr>
								</thead>
								<tfoot>
					            <tr>
					                <th colspan="7" style="text-align:right">Total:</th>
					                <th></th>
					                <th colspan="3"></th>
					                <th></th>
					            </tr>
						        </tfoot>
					        </table>
					    	</div>			        	
							</div>		    
						</div> 
		  		</div>
		  		 		
		  	</div> 		
		</section>
	</div>

	<div class="modal fade" id="modal_lead" role="dialog">
	    <div class="modal-dialog modal-md">
	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <h6 class="modal-title">Add Lead Register</h6>
	        </div>
	        <div class="modal-body">
	          <!-- <form method="POST" action="{{url('store')}}" id="modalSalesLead" name="modalSalesLead"> -->
	            @csrf
				  @if(Auth::user()->roles->first()->name != 'VP Solutions & Partnership Management')
					<div class="form-group" style="display:none!important" id="ownerSales">
					  <label for="">Owner</label>
					  <select class="form-control select2" style="width: 100%;" id="owner_sales"  name="owner_sales">
						<option value=""></option>
					  </select>
					  <span class="invalid-feedback" style="display:none!important">Please Choose Owner Sales!</span>
					</div>
				  @endif
	          <div class="form-group">
	            <label for="">Customer (Brand Name)</label>
	             <select class="form-control select2" style="width: 100%;" id="contact" onkeyup="copytextbox();" name="contact" required>
	              <option value=""></option>
	            </select>
	            <span class="invalid-feedback" style="display:none!important">Please Choose Customer!</span>
	          </div>

	          <div class="form-group">
	            <label for="">Opportunity Name</label>
	            <input type="text" class="form-control" placeholder="Enter Opportunity Name" name="opp_name" id="opp_name">
	            <span class="invalid-feedback" style="display:none!important">Please Fill Opportunity Name!</span>
	          </div>

	          <div class="form-group">
	            <label for="">Amount</label>
	            <div class="input-group">
	              <span class="input-group-text" style="background-color:#aaa;color:white">
	                Rp
	              </span>
	              <input type="text" class="form-control money" placeholder="Enter Amount" name="amount" id="amount" pattern= "[0-9]">
	            </div>
	            <span class="invalid-feedback" style="display:none!important">Please Fill Amount!</span>
	          </div>

	          <div class="form-group">
	            <label for="">Closing Date</label>
	            <div class="input-group">
	              <div class="input-group-text" style="background-color:#aaa;color:white">
	                <i class="bx bx-calendar"></i>
	              </div>
	              <input type="text" class="form-control date" name="closing_date" id="closing_date">
	            </div>
	            <span class="invalid-feedback" style="display:none!important">Please Select Date!</span>

	          </div>

	          <div class="form-group">
	            <label for="">Note</label>
	            <input type="text" class="form-control" placeholder="Enter Note" name="note" id="note">
	          </div>
	            <div class="modal-footer">
	              <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal"><i class=" bx bx-x"></i>&nbspClose</button>
	              <button type="button" onclick="submitLead()" class="btn btn-sm btn-primary"><i class="bx bx-check"> </i>&nbspSubmit</button>
	            </div>
	        </form>
	        </div>
	      </div>
	    </div>
	</div>

	<div class="modal fade" id="edit_lead_register" role="dialog">
	    <div class="modal-dialog modal-md">
	        <!-- Modal content-->
	        <div class="modal-content">
	            <div class="modal-header">
	                <h6 class="modal-title">Edit Lead Register</h6>
	            </div>
	            <div class="modal-body">
	                <!-- <form method="POST" action="{{url('update_lead_register')}}" id="modal_edit_saleslead" name="modal_edit_saleslead"> -->
	                    @csrf

	                    <input type="" name="lead_id_edit" id="lead_id_edit" hidden>

	                    <div class="form-group">
	                        <label for="">Opportunity Name</label>
	                        <textarea type="text" class="form-control" placeholder="Enter Opportunity Name" name="opp_name_edit" id="opp_name_edit">
		          						</textarea>
	                    </div>

	                    <div class="form-group">
				            <label for="">Amount</label>
				            <div class="input-group">
				              <span class="input-group-text">
				                Rp
				              </span>
				              <input type="text" class="form-control money" placeholder="Enter Amount" name="amount_edit" id="amount_edit" pattern= "[0-9]">
				            </div>
				            <span class="invalid-feedback" style="display:none!important">Please Fill Amount!</span>
				        </div>

	                    <div class="form-group">
	                        <label for="">Closing Date</label>
	                        <div class="input-group">
	                            <div class="input-group-text">
	                                <i class="bx bx-calendar"></i>
	                            </div>
	                            <input type="text" class="form-control date" name="closing_date_edit" id="closing_date_edit">
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label for="">Note (jika perlu)</label>
	                        <input type="text" class="form-control" placeholder="Enter Note" name="note_edit" id="note_edit">
	                    </div>

	                    <div class="form-group">
	                    	<div class="table-responsive">
			              			<table class="table" id="table-tagging">
				                    <thead>
				                      <tr>
				                      	<th hidden></th>
				                        <th title="Product Tagging is Required!">Brand Tag</th>
				                        <th>Technology Tag</th>
				                        <th>Price</th>
				                        <td class="text-center">
				                          <button class="btn btn-sm btn-primary" id="btn-addTagging" type="button" style="width: 30px;height: 30px;">
							              	<i class="bx bx-plus"></i>
							              </button> 
				                        </td>
				                      </tr>
					                  </thead>
					                  <tbody id="tbtagging">
					                  </tbody>
					                </table>
			              		</div>
	                    </div>

	          <!--           <div class="form-group">
	                        <label>Product Tag</label>
	                        <select class="js-product-multiple select2" style="width:100%" name="product_edit[]" id="product_edit" multiple="multiple">

	                        </select>
	                    </div>

	                    <div>
	                        <label>Technology Tag</label>
	                        <select class="js-technology-multiple select" style="width:100%" name="technology_edit[]" id="technology_edit" multiple="multiple">

	                        </select>
	                    </div> -->

	                    <div class="modal-footer">
	                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal"><i class=" bx bx-x"></i>&nbspClose</button>
	                        <button type="submit" class="btn btn-sm btn-primary" onclick="editLeadRegister()"><i class="bx bx-check"> </i>&nbspSubmit</button>
	                    </div>
	                <!-- </form> -->
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="assignModalTechAlliance" role="dialog">
	  <div class="modal-dialog modal-md">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <h6 class="modal-title">Assign</h6>
	      </div>
	      <div class="modal-body">
	        <input type="text" name="lead_tech_alliance" id="lead_tech_alliance" value="" hidden>
          <input type="text" name="status_tech_alliance" id="status_tech_alliance" value=""  hidden>
	          @csrf
	        <div class="form-group">
	          <label for="">Choose Technology Alliance</label>
	          <select class="form-control" id="select2-tech-alliance" name="select2-tech-alliance" style="width:100%" required>
	            <option value="">-- Choose --</option>
	          </select>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal"><i class="bx bx-x"></i>&nbsp Close</button>
	          <button type="button" class="btn btn-sm btn-primary" id="btnSubmitTechAlliance" onclick="submitAssignTechAlliance()"><i class="bx bx-plus"> </i>&nbspSubmit</button>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="assignModalPresales" role="dialog">
	  <div class="modal-dialog modal-md">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <h6 class="modal-title">Assign</h6>
	      </div>
	      <div class="modal-body">
	        <input type="text" name="lead_id_presales" id="lead_id_presales" value="" hidden>
          <input type="text" name="status_presales" id="status_presales" value=""  hidden>
	          @csrf
	        <div class="form-group">
	          <label for="">Choose Presales or System Designer</label>
	          <select class="form-control" id="select2-presales" name="select2-presales" style="width:100%" required>
	            <option value="">-- Choose --</option>
	          </select>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal"><i class="bx bx-x"></i>&nbsp Close</button>
	          <button type="button" class="btn btn-sm btn-primary" id="btnSubmitAssignPresales" onclick="submitAssignPresales()"><i class="bx bx-plus"> </i>&nbspSubmit</button>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="request_id" role="dialog">
	    <div class="modal-dialog modal-md">
	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <h6 class="modal-title">Request ID Project</h6>
	        </div>
	        <div class="modal-body">
	          <!-- <form method="POST" action="{{url('update_result_idpro')}}"> -->
	            @csrf
	          <div class="form-group">
	            <label for="">Lead ID</label>
	            <input type="text" id="lead_req_pid" name="" class="form-control" readonly>
	          </div>

	          <div class="form-group">
	            <label for="">Project Name</label>
	            <textarea  name="opp_name_req_pid" id="opp_name_req_pid" readonly class="form-control"></textarea>
	          </div>

	          <div class="form-group">
	            <label for="">Amount PO</label>
	            <div class="input-group">
	              <div class="input-group-addon" style="background-color:#aaa;color:white">
	                <b><i>Rp</i></b>
	              </div>
	            	<input type="text" class="form-control money" placeholder="Enter Amount" name="amount_req_pid" id="amount_req_pid" pattern= "[0-9]" required>
	            </div>
	            <span class="invalid-feedback" style="display:none!important">Please Fill Amount!</span>
	          </div>

	          <div class="form-group">
	            <label for="">Date PO</label>
	            <input type="text" name="date_po_req_pid" id="date_po_req_pid" class="form-control date" required>
	          </div>
	   
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal"><i class=" bx bx-x"></i>&nbspClose</button>
              <button type="button" class="btn btn-sm btn-primary" id="submitRequestID"><i class="bx bx-check">&nbsp</i>Submit</button>
            </div>
	        <!-- </form> -->
	        </div>
	      </div>
	    </div>
	</div>
@endsection
@section('scriptImport')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script> 
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/jquery.mask.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/sum().js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
@endsection
@section('script')
<script type="text/javascript">
	var accesable = @json($feature_item);
	accesable.forEach(function(item,index){
  		$("#" + item).show()
	})

	$(".date").flatpickr({
	  	todayHighlight: true,
	  	autoclose:true
	})

	$('.money').mask('000.000.000.000', {reverse: true});

	var table = $('#tableLead').DataTable({
		"ajax":{
        "type":"GET",
        "url":"{{url('project/getDataLead')}}",
      },
      "columns": [
        { 
        	render: function (data, type, row){
      			if (row.result_modif == 'INITIAL') {
        			return row.lead_id	
        		}else{
    					return '<a href="{{url("project/detailSales")}}/'+row.lead_id+'">'+ row.lead_id + '</a>'
        		}
        	}
        },
        { "data": "brand_name","width":"100px"},
        { "data": "opp_name","width":"550px"},
        { 
        	render: function (data,type,row){
        		return row.created_at.substring(0,10)
        	}	
        },
        { "data": "closing_date"},
        { "data": "name","width":"100px"},
        { "data": "name_ta"},
        { "data": "name_presales"},
        {
	        render: function ( data, type, row ) {
	          return new Intl.NumberFormat('id').format(row.amount)
	        },
	        "orderData":[11]
	      },
        {
          render: function (data, type, row) {
            if(row.result_modif == 'INITIAL'){
             return '<label class="status-initial">INITIAL</label>'
            }else if(row.result_modif == 'OPEN'){
             return '<label class="status-open">OPEN</label>'
            }else if(row.result_modif == 'SD'){
             return '<label class="status-sd">SD</label>'
            }else if(row.result_modif == 'TP') {
             return '<label class="status-tp">TP</label>'
            }else if(row.result_modif == 'WIN') {
             return '<label class="status-win">WIN</label>'
            }else if(row.result_modif == 'LOSE') {
             return '<label class="status-lose">LOSE</label>'
            }else {
             return '<label class="status-pending">'+ row.result_modif +'</label>'

            }
          } 
        },   
        {
        	render: function (data, type, row){
        		btnEdit = '<button class="btn btn-xs btn-warning btnEdit" id="btnEdit" style="display:none!important;"><i class="bx bx-edit"></i> Edit</button>'
        		btnDelete = '<button class="btn btn-xs btn-danger btnDelete" id="btnDelete" style="display:none!important;" ><i class="bx bx-trash"></i> Delete</button>'
        		btnIdProject = '<button class="btn btn-xs btn-primary btnReqIdProject" id="btnReqIdProject" style="display:none!important;"><i class="bx bx-plus-square"></i> ID Project</button>'


        			let loadBtn = ''

        			if (row.result_modif == 'INITIAL') {
        				loadBtn = btnEdit + btnDelete
        			}else{
        				loadBtn = btnEdit
        			}

    				if (row.result_modif == 'WIN' || row.result_modif == 'LOSE' || row.result_modif == 'CANCEL' || row.result_modif == 'TP' || row.result_modif == 'SD') {
    					if (row.status == 'pending') {
								loadBtn = btnIdProject      								
							}else{
								loadBtn = btnEdit
							}        					
    				}else{
    					if (("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','VP Solutions & Partnership Management')->exists() || App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Product Development Specialist Manager')->exists()}}")){
    						if (row.name_ta == '-') {
      						title_assign = '<i class="bx bx-user-plus"></i>Tech Alliance'
		      				onclickAssign = "onclick=btnAssignTechAlliance('assign','"+row.lead_id+"')"
		      				status = 'assign'
		      				if (row.name_presales == '-') {
		      					title_assign_presales = '<i class="bx bx-user-plus"></i>Presales'
			      				onclickAssign_presales = "onclick=btnAssignPresales('assign','"+row.lead_id+"')"
			      				status_presales = 'assign'
		      				}
      					}else{
      						title_assign = '<i class="bx bx-user-minus"></i>Re-Assign'
		      				onclickAssign = "onclick=btnAssignTechAlliance('reassign','"+row.lead_id+"')"
		      				status = 'reassign'

		      				if (row.name_presales == '-') {
		      					title_assign_presales = '<i class="bx bx-user-plus"></i>Presales'
			      				onclickAssign_presales = "onclick=btnAssignPresales('assign','"+row.lead_id+"')"
			      				status_presales = 'assign'
		      				} else {
		      					title_assign_presales = '<i class="bx bx-user-minus"></i>Re-Assign'
			      				onclickAssign_presales = "onclick=btnAssignPresales('reassign','"+row.lead_id+"')"
			      				status_presales = 'reassign'
		      				}
      					}
      					if (("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Product Development Specialist Manager')->exists()}}")){
      						loadBtn = '<button class="btn btn-xs btn-primary"'+ onclickAssign +'>'+ title_assign +'</button>'+btnEdit + btnDelete + '<button class="btn btn-xs btn-primary"'+ onclickAssign_presales +'>'+ title_assign_presales +'</button>'
      					} else {
      						loadBtn = '<button class="btn btn-xs btn-primary"'+ onclickAssign +'>'+ title_assign +'</button>'+btnEdit + btnDelete
      					}
      				}

      				if (("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Technology Alliance Solutions')->exists()}}")){
      					if (row.name_presales == '-') {
      						title_assign = '<i class="bx bx-user-plus"></i>Presales'
		      				onclickAssign = "onclick=btnAssignPresales('assign','"+row.lead_id+"')"
		      				status = 'assign'
      					}else{
      						title_assign = '<i class="bx bx-user-minus"></i>Re-Assign'
		      				onclickAssign = "onclick=btnAssignPresales('reassign','"+row.lead_id+"')"
		      				status = 'reassign'
      					}
      					loadBtn = '<button class="btn btn-xs btn-primary"'+ onclickAssign +'>'+ title_assign +'</button>'+btnEdit + btnDelete
      				}

    				} 

    				return loadBtn    			
      		}
        	
        },
        {
        	"data":"amount",
        	"targets":[8],
        	"visible":false,
        	"searchable":true
        },
      ],
      footerCallback: function( row, data, start, end, display ) {
      	  var api = this.api(), data;

          var intVal = function ( i ) {
              return typeof i === 'string' ?
                  i.replace(/[\$,]/g, '')*1 :
                  typeof i === 'number' ?
                      i : 0;
          };

          var total = api
            .data()
            .pluck('amount')
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

	          var filtered = api.column(6, ).data().sum();

	          var totalpage = api.column(6).data().sum();

	          $( api.column( 5).footer() ).addClass('text-right');
	          $( api.column( 5 ).footer() ).html("Total Amount");

	          $( api.column(8).footer() ).html(new Intl.NumberFormat('id').format(total));
	    },
      initComplete: function () {
      	accesable.forEach(function(item,index){
	    		$("." + item).show()
	  		})        			  		
      },
      "order": [],
      lengthChange:false,
      pageLength:50,
	})

	function changeColumnTable(data){
		var column = $("#tableLead").DataTable().column($(data).attr("data-column"))
		column.visible( ! column.visible() );
		// $(data).prop('checked', column.visible())
		// column.visible() ? $(data).addClass('active') : $(data).removeClass('active')
	}

	$(document).on('click','.paginate_button', function() {
	 	accesable.forEach(function(item,index){
  		$("." + item).show()
		})
	});

	table.on( 'draw', function () {
    accesable.forEach(function(item,index){
  		$("." + item).show()
		})
	});

	$.ajax({
    url: "{{url('/project/getCustomerByLead')}}",
    type: "GET",
    success: function(result) {
      $("#filter_customer").select2({
      	placeholder: "Select Customer",
		  	multiple:true,
		  	data:result.data
		  })       
    }
	})

	$.ajax({
		url: "{{url('/project/getSales')}}",
		type: "GET",
		success:function(result){
			$("#owner_sales").select2({
      	placeholder: "Select sales",
		  	data:result.data
		  })
		}
	})	

	$.ajax({
		url: "{{url('/project/getUserByTerritory')}}",
		type: "GET",
		data:{
			territory:"{{Auth::User()->id_territory}}"
		},
		success:function(result){
			$("#filter_sales_manager").select2({
      	placeholder: "Select sales",
		  	multiple:true,
		  	data:result.data
		  })
		}
	})	

	$.ajax({
    url: "{{url('/project/getCustomer')}}",
    type: "GET",
    success: function(result) {
        $("#contact").select2({
    		placeholder: "Select Contact",
        	data:result.data,
        	dropdownParent:$("#modal_lead")
        })
    }
	})

	function add_lead(){
		initMoney()
		$("#modal_lead").modal('show')
	}

	function submitLead(){
		if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Presales Support Architecture')->exists()}}" || "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Synergy System Delivery Manager')->exists()}}" ) {
			var owner_sales = $("#owner_sales").val()
		}else{
			var owner_sales = 'bukan presales'
		}
		if (owner_sales == '') {
			$("#owner_sales").closest('.form-group').addClass('needs-validation .select2-selection')
			$("#owner_sales").nextAll("span").eq(1).show()

		}else if ($("#contact").val() == '') {
			$("#contact").closest('.form-group').addClass('needs-validation .select2-selection')
			$("#contact").nextAll("span").eq(1).show()

		}else if ($("#opp_name").val() == '') {
			$("#opp_name").closest('.form-group').addClass('needs-validation')
			$("#opp_name").next('span').show()


		}else if ($("#amount").val() == '') {
			$("#amount").closest('.form-group').addClass('needs-validation')
			$("#amount").closest('div div').next('span').show();


		}else if ($("#closing_date").val() == '') {
			$("#closing_date").closest('.form-group').addClass('needs-validation')
			$("#closing_date").closest('div div').next('span').show();

		}else{
			Swal.fire({
			    title: 'Are you sure?',  
			    text: "Submit Lead Register",
			    icon: 'warning',
			    showCancelButton: true,
			    confirmButtonColor: '#3085d6',
			    cancelButtonColor: '#d33',
			    confirmButtonText: 'Yes',
			    cancelButtonText: 'No',
			}).then((result) => {
				if (result.value) {
		      $.ajax({
            type: "POST",
            url: "{{url('/project/storeLead')}}",
            data: {
              	_token: "{{ csrf_token() }}",
				owner_sales:$("#owner_sales").val(),
				contact:$("#contact").val(),
				opp_name:$("#opp_name").val(),
				closing_date:$("#closing_date").val(),
				amount:$("#amount").val(),
				note:$("#note").val(),
            },beforeSend:function(){
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
            success: function(result) {
                Swal.showLoading()
                Swal.fire(
                    'Successfully!',
                   	'Lead Register Created.',
                    'success'
                ).then((result) => {
                    if (result.value) {
                    	location.reload()
                    	$("#modal_lead").modal('hide')
                    }
                })
            }
	        })		      
			  }
			})
		}
	}

	// table.on('click','#btnAssignPresales',function(){
	// 	lead_id = this.value.split(",")[0]
	// 	status = this.value.split(",")[1]
	
	// 	$("#lead_id_presales").val(lead_id)
	// 	$("#status_presales").val(status)

	// 	if (status != "assign") {
	// 		$.ajax({
	// 			type:"GET",
	// 			url:"{{url('/project/getPresalesAssign')}}",
	// 			data:{
	// 				lead_id:lead_id
	// 			},
	// 			success:function(result){
	// 				$("#select2-presales").select2().val("")
	// 				$("#select2-presales").val(result.data.id).trigger("change")
	// 			}
	// 		})
	// 	}

	// 	$("#assignModalPresales").modal('show')		
	// })

	function btnAssignPresales(status,id){
		$("#lead_id_presales").val(id)
		$("#status_presales").val(status)

		if (status == "reassign") {
			$.ajax({
				type:"GET",
				url:"{{url('/project/getPresalesAssign')}}",
				data:{
					lead_id:id
				},
				success:function(result){
					$("#select2-presales").select2({
						dropdownParent:$("#assignModalPresales")
					}).val("")
					$("#select2-presales").val(result.data.id).trigger("change")
				}
			})
		}

		$("#assignModalPresales").modal('show')	
	}

	function btnAssignTechAlliance(status,id){
		$("#lead_tech_alliance").val(id)
		$("#status_tech_alliance").val(status)
		
		if (status == "reassign") {
			$.ajax({
				type:"GET",
				url:"{{url('/project/getTaAssign')}}",
				data:{
					lead_id:id
				},
				success:function(result){
					$("#select2-tech-alliance").select2({
						dropdownParent:$("#assignModalTechAlliance")
					}).val("")
					$("#select2-tech-alliance").val(result.data.id).trigger("change")
				}
			})
		}

		$("#assignModalTechAlliance").modal('show')	
	}

	function submitAssignPresales(){
		Swal.fire({
		    title: 'Are you sure?',
		    text: "Submit for assigned presales",
		    icon: 'warning',
		    showCancelButton: true,
		    confirmButtonColor: '#3085d6',
		    cancelButtonColor: '#d33',
		    confirmButtonText: 'Yes',
		    cancelButtonText: 'No',
		}).then((result) => {
		    if (result.value) {
		        if ($("#status_presales").val() == "assign") {
		        	url = "{{url('/project/assignPresales')}}"
		        }else{
		        	url = "{{url('/project/reassignPresales')}}"
		        }

		      $.ajax({
            type: "POST",
            url: url,
            data: {
                _token: "{{ csrf_token() }}",
                lead_id:$("#lead_id_presales").val(),
                nik_presales:$("#select2-presales").select2("data")[0].id,
                name_presales:$("#select2-presales").select2("data")[0].text
            },beforeSend:function(){
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
            success: function(result) {
              Swal.showLoading()
              Swal.fire(
                  'Successfully!',
                  'Presales has been Assigned.',
                  'success'
              ).then((result) => {
                  if (result.value) {
                  	location.reload()
                  	$("#assignModal").modal('hide')
                  }
              })
            }
	        })
		    }
		})
	}

	function submitAssignTechAlliance(){
		Swal.fire({
		    title: 'Are you sure?',
		    text: "Submit for technology alliance",
		    icon: 'warning',
		    showCancelButton: true,
		    confirmButtonColor: '#3085d6',
		    cancelButtonColor: '#d33',
		    confirmButtonText: 'Yes',
		    cancelButtonText: 'No',
		}).then((result) => {
		    if (result.value) {
		        if ($("#status_tech_alliance").val() == "assign") {
		        	url = "{{url('/project/assignTechnologyAlliance')}}"
		        }else{
		        	url = "{{url('/project/reassignTa')}}"
		        }

		        $.ajax({
		            type: "POST",
		            url: url,
		            data: {
		                _token: "{{ csrf_token() }}",
		                lead_id:$("#lead_tech_alliance").val(),
		                nik_ta:$("#select2-tech-alliance").select2("data")[0].id,
		                name_ta:$("#select2-tech-alliance").select2("data")[0].text
		            },beforeSend:function(){
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
		            success: function(result) {
		                Swal.showLoading()
		                Swal.fire(
		                    'Successfully!',
		                    'Technology Alliance has been Assigned.',
		                    'success'
		                ).then((result) => {
		                    if (result.value) {
		                    	location.reload()
		                    	$("#assignModalTechAlliance").modal('hide')
		                    }
		                })
		            }
		        })
		    }
		})
	}
	
	var i
	table.on('click', '#btnEdit', function () {
    var tr = $(this).closest('tr');
    var value = $(tr).find('td').eq(0)[0].innerHTML;

    if (value.length == 10) {
    	value = value
    }else{
    	value = $(value).text()
    }
     
		$.ajax({
			type:"GET",
			url:"{{url('/project/showEditLead')}}",
			data:{
				lead_id:value,
			},
			success:function(result){
				initMoney()

				$("#lead_id_edit").val(result.data[0].lead_id)
				$("#opp_name_edit").val(result.data[0].opp_name)
				flatpickr("#closing_date_edit", {
				    dateFormat: "Y-m-d",
				    defaultDate: result.data[0].closing_date
				});
				$("#amount_edit").mask('000.000.000.000', {reverse: true})
				$("#amount_edit").val(result.data[0].amount.toString()).trigger("input")
				$("#note_edit").val(result.data[0].keterangan)
				// $("#product_edit").select2().val("");
				// if (result.data[0].id_product_tag != null) {
				// 	let id_product_tag = result.data[0].id_product_tag.split(",")
				// 	var productArr = []
				// 	productArr.push(id_product_tag)
				// 	console.log(productArr)
				// 	$('#product_edit').val(productArr[0]).trigger('change').on("select2:select", function (evt) {
				// 	  var element = evt.params.data.element;
				// 	  var $element = $(element);

				// 	  $element.detach();
				// 	  $(this).append($element);
				// 	  $(this).trigger("change");
				// 	});
				// }
				// $("#technology_edit").select2().val("");
				// if (result.data[0].id_tech != null) {
				// 	let id_tech_tag = result.data[0].id_tech.split(",")
				// 	var angkaArr = []
				// 	angkaArr.push(id_tech_tag)
				// 	$("#technology_edit").val(angkaArr[0]).trigger("change").on("select2:select", function (evt) {
				// 	  var element = evt.params.data.element;
				// 	  var $element = $(element);

				// 	  $element.detach();
				// 	  $(this).append($element);
				// 	  $(this).trigger("change");
				// 	});
				// }

				$("#tbtagging").empty()

		    var idExist = []
  			$.ajax({
		    	url: "{{url('/project/showTagging')}}",
		      type: "GET",
		      data: {
		          lead_id: value,
		      },success: function(result){
	    		var i = 0;
	      	$.each(result, function(key,value){
	      		addTaggingNotEmpty(value.id,value.id_product_tag,value.id_technology_tag,value.price,i++)
	    			idExist.push(value.id)
	      	}) 	 	

		      }
		    })
 			}
		})

		// $("#btn-addTagging").click(function(){
		// 	var append = ""
		// 	showTagging(append)
		// })
    $('#edit_lead_register').modal('show')
	});

	$("#btn-addTagging").click(function(){
		var append = ""
			// loadSelect(i,value)    
	    append = append + "<tr class='new-tagging'>"
	    append = append + " <td><input hidden class='id' name='id' data-value='"+i+"'/>"
	    append = append + " <select class='form-control product_edit' data-value='" + i + "' name='product_edit' style='width: 100%!important' required></select>"
	    append = append + " </td>"
	    append = append + " <td>"
	    append = append + " <select class='form-control technology_edit' data-value='" + i + "' name='technology_edit' style='width: 100%!important' required></select>"
	    append = append + " </td>"
	    append = append + " <td>"
	    append = append + " <div class='input-group'>"
	    append = append + " <input data-value='" + i + "' class='form-control new-price-sol' style='width:200px' name='new-price-sol' type='text' placeholder='Enter Price'>"
	    append = append + " </div>"
	    append = append + " </td>"
	    append = append + " <td class='text-center' style='display:flex'>"
	    append = append + " <button type='button' data-value='"+i+"' style='width: auto !important;' class='btn btn-sm btn-danger btn-flat btn-trash-tagging' value='"+i+"'><i class='bx bx-trash'></i></button><br><button type='button' data-value='"+i+"' style='width: auto !important;margin-left:5px' class='btn btn-sm btn-primary btn-flat disabled'><i class='bx bx-pencil'></i></button>"
	    append = append + " </td>"
	    append = append + "</tr>"
	  	$("#tbtagging").append(append)

	  	$.ajax({
		      url: "{{url('/project/getProductTechTag')}}",
		      type: "GET",
		      success: function(result) {
		          $(".product_edit[data-value='" + i + "']").empty("");
		          $(".technology_edit[data-value='" + i + "']").empty("");
		          var product_tag = result.product_tag;
		          var product_tag_selectOption = [];

		          var technology_tag = result.technology_tag;
		          var technology_tag_selectOption = [];

		          $.each(product_tag, function(key, value) {
		              product_tag_selectOption.push(value)
		          })

		          $.each(technology_tag, function(key, value) {
		              technology_tag_selectOption.push(value)
		          })
		          $(".product_edit[data-value='" + i + "']").select2({
		              dropdownParent: $('#edit_lead_register'),
		              placeholder: "Select Brand",
		              data: product_tag_selectOption,
		              templateSelection: function(selection, container) {
		                  return $.parseHTML('<span>' + selection.text + '</span>');
		              }
		          })
		          
		          $(".technology_edit[data-value='" + i + "']").select2({
		              dropdownParent: $('#edit_lead_register'),
		              placeholder: "Select Tech",
		              data: technology_tag_selectOption,
		              templateSelection: function(selection, container) {
		                  return $.parseHTML('<span>' + selection.text + '</span>');
		              }
		          })
		      }
		  })

	  	// $('#tbtagging tr:last').after('<tr><td>tess</td></tr>');
	    $(".btn-edit-tagging").prop("disabled",true)
	    $(".new-price-sol").mask('000.000.000.000', {reverse: true})
	})

	function addTaggingNotEmpty(id,id_product,id_tech,price,i){
    	var append = ""
      append = append + "<tr class='exist-tagging'>"
      append = append + "<td hidden><input id='tagging_status' data-value='"+ i +"'/><input class='id' name='id' data-value='"+i+"'/></td>"
      append = append + " <td>"
      append = append + " <select disabled class='form-control product_edit' data-value='" + i + "' style='width: 100%!important'></select>"
      append = append + " </td>"
      append = append + " <td>"
      append = append + " <select disabled class='form-control technology_edit' data-value='" + i + "' style='width: 100%!important'></select>"
      append = append + " </td>"
      append = append + " <td>"
      append = append + " <div class='input-group'>"
      append = append + " <input disabled data-value='" + i + "' class='form-control col-xs-12 new-price-sol' type='text' placeholder='Enter Price'>"
      append = append + " </div>"
      append = append + " </td>"
      append = append + " <td class='text-center' style='display:flex'>"
      append = append + " <button type='button' style='width: auto !important;float:left' class='btn btn-sm btn-danger btn-flat btn-trash-tagging'><i class='bx bx-trash'></i></button><button data-value='"+ i +"' type='button' style='width: auto !important;float:right;margin-left:5px' class='btn btn-sm btn-primary btn-flat btn-edit-tagging'><i class='bx bx-pencil'></i></button>"
      append = append + " </td>"
      append = append + "</tr>"

      $("#tbtagging").append(append)	      

  		$.ajax({
        url: "{{url('/project/getProductTechTagDetail')}}",
        type: "GET",
        success: function(result) {
            $(".product_edit[data-value='" + i + "']").empty("");
            $(".technology_edit[data-value='" + i + "']").empty("");
            var product_tag = result.product_tag;
            var product_tag_selectOption = [];

            var technology_tag = result.technology_tag;
            var technology_tag_selectOption = [];

            $.each(product_tag, function(key, value) {

            	if (value.id == "p"+id_product) {
            		value.selected = true
            	}
                product_tag_selectOption.push(value)
            })
            $.each(technology_tag, function(key, value) {
            	if (value.id == "t"+id_tech) {
            		value.selected = true
            	}
                technology_tag_selectOption.push(value)
            })

            var TagProduct = $(".product_edit[data-value='" + i + "']").select2({
                dropdownParent: $('#edit_lead_register'),
                data: product_tag_selectOption,
                templateSelection: function(selection, container) {
                    return $.parseHTML('<span>' + selection.text + '</span>');
                }
            })
            

            var TagProduct = $(".technology_edit[data-value='" + i + "']").select2({
                dropdownParent: $('#edit_lead_register'),
                data: technology_tag_selectOption,
                templateSelection: function(selection, container) {
                    return $.parseHTML('<span>' + selection.text + '</span>');
                }
            })
        }
    	})

  		$("[data-toggle=tooltip][data-value='" + i + "']").mouseenter(function(){
    		var $this = $(this);
        $this.attr('title', 'uang');
    	})  
    	$(".id[data-value='" + i + "']").val(id) 
  		$(".new-price-sol[data-value='" + i + "']").val(price).mask('000.000.000.000', {reverse: true})  
  }

  $(document).on('click', '.btn-edit-tagging', function() {
    	$(this).parents("tr").find(".product_edit").prop("disabled",false)
    	$(this).parents("tr").find(".technology_edit").prop("disabled",false)
    	$(this).parents("tr").find(".new-price-sol").prop("disabled",false)
    	$(this).parents("tr").find(".btn-edit-tagging").removeClass('btn-primary').addClass('btn-warning')
    	$(this).parents("tr").find(".btn-edit-tagging").find('i').removeClass('bx-pencil').addClass('bx-check')
		  id_exist = $(this).parents("tr").find("input[name='id']").val()
    	product = $(this).parents("tr").find(".product_edit").val().substr(1)
    	techno = $(this).parents("tr").find(".technology_edit").val().substr(1)
    	price = $(this).parents("tr").find(".new-price-sol").val()
    	dataValue = $(this).parents("tr").find(".new-price-sol").data("value")
    	id_val = $(this).parents("tr").find("#tagging_status").val()
    	
    	if (id_val == '') {
    		$("#tagging_status[data-value='"+ dataValue +"']").val("pencil"+dataValue)
    	}else if (id_val == "pencil"+dataValue) {
	  		$(this).parents("tr").find(".btn-edit-tagging").attr("onclick",updateTagging(id_exist,product,techno,price,dataValue))
    		$("#tagging_status[data-value='"+ dataValue +"']").val('')
    	}

    	$("#btn-addTagging").prop("disabled",true).attr("data-toggle", "tooltip").attr('title', "You in edit mode!").show()

    	$("#btnSubmitSD").prop("disabled",true)
    	$("#btnRaiseTP").prop("disabled",true)
  })

  var deletedProduct = []

  $(document).on('click', '.btn-trash-tagging', function() {
    $(this).closest("tr").remove();
	  row = $(this).parents("tr").find("input[name='id']").val();
  	deletedProduct.push(row)

  	$(".btn-edit-tagging").prop("disabled",false)
  });

  function updateTagging(id_exist,product,techno,price,dataValue){
  		$.ajax({
        url: "{{url('/project/updateProductTag')}}",
        type: 'post',
        data: {
        	_token:"{{ csrf_token() }}",
        	id_exist:id_exist,
        	id_product:product,
        	id_techno:techno,
        	price:price,
        	lead_id:$("#lead_id_edit").val()
        },
      success: function()
      {
          Swal.showLoading()
            Swal.fire(
              'Successfully!',
              'success'
            ).then((result) => {
              if (result.value) {
              	localStorage.setItem("status_tagging", "pencil");
              	$(".product_edit[data-value='" + dataValue + "']").prop("disabled",true)
		    	$(".technology_edit[data-value='" + dataValue + "']").prop("disabled",true)
		    	$(".new-price-sol[data-value='" + dataValue + "']").prop("disabled",true)
		    	$(".btn-edit-tagging[data-value='" + dataValue + "']").removeClass('btn-warning').addClass('btn-primary')
		    	$(".btn-edit-tagging[data-value='" + dataValue + "']").find("i").removeClass('bx-check').addClass('bx-pencil')
		    	$("#btn-addTagging").prop('disabled',false).tooltip('disable')
              }
          })
      }
    })
  }

	function editLeadRegister(){
		var tagProduct = []
    $('#table-tagging #tbtagging .new-tagging').each(function() {
      tagProduct.push({
        price:$(this).find(".new-price-sol").val().replace(/\D/g, ""),
        productTag:$(this).find('.product_edit').select2("data")[0].id,
        productTagText:$(this).find('.product_edit').select2("data")[0].text,
        technologyTag:$(this).find('.technology_edit').select2("data")[0].id,
        technologyTagText:$(this).find('.technology_edit').select2("data")[0].text

      })
    });
		Swal.fire({
		    title: 'Are you sure?',  
		    text: "Update this Lead",
		    icon: 'warning',
		    showCancelButton: true,
		    confirmButtonColor: '#3085d6',
		    cancelButtonColor: '#d33',
		    confirmButtonText: 'Yes',
		    cancelButtonText: 'No',
		}).then((result) => {
			if (result.value) {	       
	        $.ajax({
	            type: "POST",
	            url: "{{url('/project/update_lead_register')}}",
	            data: {
	              _token: "{{ csrf_token() }}",
	              lead_id_edit:$("#lead_id_edit").val(),
								opp_name_edit:$("#opp_name_edit").val(),
								closing_date_edit:$("#closing_date_edit").val(),
								amount_edit:$("#amount_edit").val(),
								note_edit:$("#note_edit").val(),
								tagProduct:tagProduct,
	      				id:deletedProduct
	            },beforeSend:function(){
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
	            success: function(result) {
	                Swal.showLoading()
	                Swal.fire(
	                    'Successfully!',
	                   	'Lead Register Updated.',
	                    'success'
	                ).then((result) => {
	                    if (result.value) {
	                    	location.reload()
	                    	$("#edit_lead_register").modal('hide')
	                    }
	                })
	            }
	        })		      
		  }
		})
	}

	table.on('click','#btnDelete',function(){
		var tr = $(this).closest('tr');
    var value = $(tr).find('td').eq(0)[0].innerHTML;

    if (value.length == 10) {
    	value = value
    }else{
    	value = $(value).text()
    }

		Swal.fire({
		    title: 'Are you sure?',  
		    text: "Delete this Lead",
		    icon: 'warning',
		    showCancelButton: true,
		    confirmButtonColor: '#3085d6',
		    cancelButtonColor: '#d33',
		    confirmButtonText: 'Yes',
		    cancelButtonText: 'No',
		}).then((result) => {
		    if (result.value) {
	        $.ajax({
            type: "GET",
            url: "{{url('project/deleteLead')}}",
            data: {
            	lead_id:value,
            },beforeSend:function(){
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
            success: function(result) {
                Swal.showLoading()
                Swal.fire(
                    'Successfully!',
                    'Lead Register Deleted.',
                    'success'
                ).then((result) => {
                    if (result.value) {
                    	location.reload()
                    }
                })
            }
	        })
		    }
		})
	})

	table.on('click','#btnReqIdProject',function(){
		var tr = $(this).closest('tr')
		var value = $(tr).find('td').eq(0)[0].innerHTML

		if (value.length == 10) {
    	value = value
    }else{
    	value = $(value).text()
    }

    $.ajax({
    	type:"GET",
    	url:"{{url('/project/getPid')}}",
    	data:{
    		lead_id:value
    	},success:function(result){
    		$("#lead_req_pid").val(result.data[0].lead_id)
    		$("#opp_name_req_pid").val(result.data[0].opp_name)
    		$("#amount_req_pid").val(result.data[0].amount_pid).mask('000.000.000.000', {reverse: true})
    		$("#date_po_req_pid").val(result.data[0].date_po)


		    $("#submitRequestID").click(function(){
		    	$("#submitRequestID").attr("onclick",submitReqPID(result.data[0].lead_id))
		    })
    	}
    })

		$("#request_id").modal("show")
	})

	function submitReqPID(value){
		Swal.fire({
		    title: 'Are you sure?',  
		    text: "Submit Request PID",
		    icon: 'warning',
		    showCancelButton: true,
		    confirmButtonColor: '#3085d6',
		    cancelButtonColor: '#d33',
		    confirmButtonText: 'Yes',
		    cancelButtonText: 'No',
		}).then((result) => {
			if (result.value) {
	      	$.ajax({
	          type: "POST",
	          url: "{{url('/project/updateResultRequestPid')}}",
	          data: {
	            _token: "{{ csrf_token() }}",
	            lead_id:value,
	          },beforeSend:function(){
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
	          success: function(result) {
	            Swal.showLoading()
	            Swal.fire(
	                'Successfully!',
	               	'Request PID Successfully.',
	                'success'
	            ).then((result) => {
	                if (result.value) {
	                	location.reload()
	                	$("#request_id").modal('hide')
	                }
	            })
	          }
	        })		      
		  }
		})
	}

	$.ajax({
	    url:"{{url('/project/getProductTag')}}",
	    type:"GET",
	    success:function(result){
	      var selectProduct = $(".product_edit").select2().val("");
	      var arr = result.results;
	      var selectOption = [];
	      var otherOption;
	      $.each(arr,function(key,value){
	        if (value.text != "Others") {
	          selectOption.push(value)
	        }else{
	          otherOption = value
	        }
	      })
	      selectOption.push(otherOption)
	      $(".product_edit").select2({
	        multiple:true,
	        data:selectOption
	      }).on("select2:select", function (evt) {
				  var element = evt.params.data.element;
				  var $element = $(element);

				  $element.detach();
				  $(this).append($element);
				  $(this).trigger("change");
				});
	    }
	})

  $.ajax({
    url:"{{url('/project/getTechTag')}}",
    type:"GET",
    success:function(result){
      var selectTechnology = $(".technology_edit").select2().val("");
      var arr = result.results;
      var selectOption = [];
      var otherOption;
      $.each(arr,function(key,value){
        if (value.text != "Others") {
          selectOption.push(value)
        }else{
          otherOption = value
        }
      })
      selectOption.push(otherOption)
      $(".technology_edit").select2({
        multiple:true,
        data:selectOption
      }).on("select2:select", function (evt) {
			  var element = evt.params.data.element;
			  var $element = $(element);

			  $element.detach();
			  $(this).append($element);
			  $(this).trigger("change");
			});
    }
  })

  $.ajax({
		url: "{{url('/project/getSalesByTerritory')}}",
		type: "GET",
		success:function(result){
			$("#filter_sales").select2({
      	placeholder: "Select sales",
		  	multiple:true,
		  	data:result.results
		  })
		}
	})

  $("#year_dif_dir").select2({
  	multiple:true
  })

  $("#year_dif").select2({
  	multiple:true
  })

  $('#year_dif_dir').change(function() {
  	$("#year_dif2_dir").select2({
	  	multiple:true
	  })
	  // Trigger change to refresh Select2
	  // $('#year_dif2_dir').trigger('change');
  });

	var countLead = []
	var sumAmount = []
	
	$(document).ready(function(){  
		var year 		= $('#year_dif').val();
		var year_dir 	= $('#year_dif_dir').val();
		var year2_dir 	= $('#year_dif2_dir').val();

		$('#year_dif2_dir option').prop('disabled', false);
		$('#year_dif_dir').val().forEach(function(value) {
	    $('#year_dif2_dir option[value="' + value + '"]').prop('disabled', true);
	  });

		var tempYear = 'year[]='
		
    var i = 0
		var colors = []
		var prepend = ""
		// var bg-orange = "#f2562b"
		// var bg-aqua = "#04dda3"
		// var bg-yellow = "#f7e127"
  	var ArrColors = [{
	        name: 'Lead Register', color: 'bg-label-primary', icon: 'bx bx-list-ul',index: 0, url: "view_lead"
	    },
	    {
	        name: 'Open', color: 'bg-orange-custom', icon: 'bx bx-briefcase',index: 1, url: "view_open"
	    },
	    {
	        name: 'Solution Design', color: 'bg-aqua-custom', icon: 'bx bx-file',index: 2, url: "view_open"
	    },
	    {
	        name: 'Tender Process', color: 'bg-yellow-custom', icon: 'bx bx-area',index: 3, url: "view_open"
	    },
	    {
	        name: 'Win', color: 'bg-label-success', icon: 'bx bx-calendar-check',index: 4, url: "view_win"
	    },
	    {
	        name: 'Lose', color: 'bg-label-danger', icon: "bx bx-calendar-x",index: 5, url: "view_lose"
	    }
		]

		colors.push(ArrColors)

		$.each(colors[0], function(key, value){
			prepend = prepend + '<div class="col-lg-2 col-xs-12">'
			    prepend = prepend + '<div class="card card-border-shadow-primary h-100">'
			        prepend = prepend + '<div class="card-body">'
			          prepend = prepend + '<div class="d-flex align-items-center mb-2">'
			            prepend = prepend + '<div class="avatar me-4">'
			              prepend = prepend + '<span class="avatar-initial rounded '+ value.color + '"><i class="icon-base '+ value.icon +' icon-lg"></i></span>'
			            prepend = prepend + '</div>'
			            prepend = prepend + '<h6 class="mb-0 counter" id="count_lead_'+ value.index +'">0</h6>'
			          prepend = prepend + '</div>'
			          prepend = prepend + '<p class="mb-2">'+ value.name +'</p>'
			          prepend = prepend + '<p class="mb-0">'
			            prepend = prepend + 'Rp.<span class="text-heading fw-medium me-2" id="sum_amount_'+value.index+'">0</span>'
			          prepend = prepend + '</p>'
			        prepend = prepend + '</div>'
			    prepend = prepend + '</div>'
			prepend = prepend + '</div>'	

			id = "count_lead_"+value.index
			sumAm = "sum_amount_"+value.index
			countLead.push(id)
			sumAmount.push(sumAm)
			initMoney()
		})

		$.ajax({
	    url: "{{url('/project/getPresales')}}",
	    type: "GET",
	    success: function(result) {
        $("#select2-presales").select2({
        	data:result.data,
        	dropdownParent:$("#assignModalPresales")
        })

        $("#filter_presales").select2({
        	placeholder:"Select Presales",
        	multiple:true,
        	data:result.data
        })
	    }
		})

		$.ajax({
	    url: "{{url('/project/getTa')}}",
	    type: "GET",
	    success: function(result) {

        $("#select2-tech-alliance").select2({
        	data:result.data,
        	dropdownParent:$("#assignModalTechAlliance")
        })

        $("#filter_ta").select2({
        	placeholder:"Select Technology Alliance",
        	multiple:true,
        	data:result.data
        })
	    }
		})

		$("#BoxId").prepend(prepend)

		if (!document.getElementById("bg-orange") == false) {
			// document.getElementById("bg-orange").style.backgroundColor  = "#f2562b!important";
			$(".bg-orange").addClass('bg-orange')
		}

		if (!document.getElementById("bg-aqua") == false) {

			document.getElementById("bg-aqua").style.backgroundColor  = "#04dda3!important";
			// $(".bg-aqua").css('background-color','#04dda3')
		}

		if (!document.getElementById("bg-yellow") == false) {

			document.getElementById("bg-yellow").style.backgroundColor  = "#f7e127!important";
			// $(".bg-yellow").css('background-color','#f7e127')
		}

		if (accesable.includes('searchTags')) {
			$.ajax({
			    url: "{{url('/project/getProductTechTag')}}",
			    type: "GET",
			    success: function(result) {
			        $("#searchTags").select2().val("");
			        var arr = result;
			        var selectOption = [];
			        var otherOption;
			        var otherTechOption;

			        $.each(arr, function(key, value) {
			            if (value.text != "Others") {
			                selectOption.push(value)
			            } else {
			                otherOption = value
			            }
			        })

			        selectOption.push(otherOption)
			        selectOption.push(otherTechOption)
			        var TagProduct = $("#searchTags").select2({
			            placeholder: " Select Tags",
			            allowClear: true,
			            multiple: true,
			            data: selectOption,
			            templateSelection: function(selection, container) {
			                var selectedOption = selection.id.slice(0, 1);
			                if (selectedOption == 'p') {
			                    $(container).css("background-color", "#32a852");
			                    $(container).css("border-color", "#32a852");
			                    return selection.text;
			                } else {
			                    return $.parseHTML('<span>' + selection.text + '</span>');
			                }
			            }
			        })
			    }

			})
		}

		if (!accesable.includes('columnPresales')) {
			var column1 = table.column(7);
      		column1.visible(!column1.visible());
		}

		if (!accesable.includes('columnTa')) {
			var column1 = table.column(6);
      		column1.visible(!column1.visible());
		}

		if(accesable.includes('columnAmount')){
			var column1 = table.column(8);
      		column1.visible(!column1.visible());
		}
  })	

	$(window).on('load', function() {
			var prependFilterCom = ""
			prependFilterCom = prependFilterCom + '<label>Company</label>'
			$.ajax({
				type:"GET",
				url:'{{url("/project/getCompany")}}',
				success:function(result){
					var checked = ""
					$.each(result,function(key,value){
						prependFilterCom = prependFilterCom + '<div>'
							if (value.company == "Sinergy Informasi Pratama") {
								prependFilterCom = prependFilterCom + '<input type="checkbox" class="cb-company" id="'+ value.id_company +'" name="cb-filter" value="'+value.id_company+'" checked> '
					    	prependFilterCom = prependFilterCom + value.company
							}else{
								prependFilterCom = prependFilterCom + '<input type="checkbox" class="cb-company" id="'+ value.id_company +'" name="cb-filter" value="'+value.id_company+'"> '
					    	prependFilterCom = prependFilterCom + value.company
							}
					  	
					  prependFilterCom = prependFilterCom + '</div>'
					})

					$("#filter-com").append(prependFilterCom)

					$(".cb-company").click(function(){
						searchCustom()
					})
				}
			})

			var prependFilterTer = ""
			prependFilterTer = prependFilterTer + '<label>Territory</label>'
			$.ajax({
				type:"GET",
				url:'{{url("/project/getTerritory")}}',
				success:function(result){
					$.each(result,function(key,value){
						prependFilterTer = prependFilterTer + '<div>'
					  	prependFilterTer = prependFilterTer + '<input type="checkbox" class="cb-territory" name="cb-filter" value="'+value.id_territory+'"> '
					    prependFilterTer = prependFilterTer + value.id_territory
					  prependFilterTer = prependFilterTer + '</div>'
					})

					$("#filter-territory").append(prependFilterTer)
					$(".cb-territory").click(function(){
						var tempTer = []
						$.each($(".cb-territory:checked"),function(key,value){
							tempTer = tempTer + '&territory[]=' + value.value
						})

						if (tempTer.length !== 0) {
							var salesFilterTer = "{{url('/project/getSalesByTerritory')}}?"+tempTer							
						}else{
							var salesFilterTer = "{{url('/project/getSalesByTerritory')}}"
						}
						// $("filter_sales").select2("destroy").select2()

						$.ajax({
							url: salesFilterTer,
							type: "GET",
							beforeSend:function(){
								$("#filter_sales").empty('')
							},
							success:function(result){
								$("#filter_sales").select2({
					      	placeholder: "Select sales",
							  	multiple:true,
							  	data:result.results
							  })
							}
						})	

						searchCustom("tableLead","territory")
										
					})
				}
			})

			var prependFilterStatus = ""
			prependFilterStatus = prependFilterStatus + '<label>Status Lead</label>'
			
			$.ajax({
				type:"GET",
				url:'{{url("/project/getResult")}}',
				success:function(result){
					$.each(result,function(key,value){
						prependFilterStatus = prependFilterStatus + '<div>'
					  	prependFilterStatus = prependFilterStatus + '<input type="checkbox" class="cb-result" name="cb-filter" value="'+value.result_value+'" id="filter_lead_' + value.result_modif + '"> '
					    prependFilterStatus = prependFilterStatus + '<span>' + value.result_modif + '</span>'
					  prependFilterStatus = prependFilterStatus + '</div>'
					})

					$("#filter-result").append(prependFilterStatus)
					$(".cb-result").click(function(){
						searchCustom()
					})

					if (window.location.href.indexOf("status") != -1) {						
						$(".cb-result").each(function(item,value){
							if (window.location.href.split("?")[1].split("=")[1] == 'ALL') {
						    $("#filter_lead_"+value.value).prop("checked", true)
						    $("#filter_lead_INITIAL").prop("checked", true)
							}else{
								if(value.value == window.location.href.split("?")[1].split("=")[1]){
									if (window.location.href.split("?")[1].split("=")[1] == "OPEN") {
						    		$("#filter_lead_OPEN").prop("checked", true)
						    		$("#filter_lead_SD").prop("checked", true)
						    		$("#filter_lead_TP").prop("checked", true)
									}else {
						    		$("#filter_lead_"+value.value).prop("checked", true)
									}
						    }
							}
						})
						searchCustom("tableLead","result")
					}
				}
			})

			if (window.location.href.indexOf("status") == -1) {
				searchCustom("tableLead","company")
			}

			filterFromDashboard()	

			$("#year_dif_dir").change(function(){
				$("#year_dif_dir").attr("onchange",searchCustom())
			})  
			$("#year_dif2_dir").change(function(){
				$("#year_dif2_dir").attr("onchange",searchCustom())
			})
			$("#year_dif").change(function(){
				$("#year_dif").attr("onchange",searchCustom())
			})
			$("#filter_sales").change(function(){
				$("#filter_sales").attr("onchange",searchCustom())
			})
			$("#filter_sales_manager").change(function(){
				$("#filter_sales_manager").attr("onchange",searchCustom())
			})
			$("#filter_ta").change(function(){
				$("#filter_ta").attr("onchange",searchCustom())
			})
			$("#filter_presales").change(function(){
				$("#filter_presales").attr("onchange",searchCustom())
			})
			$("#filter_customer").change(function(){
				$("#filter_customer").attr("onchange",searchCustom())
			})
			$("#searchTags").change(function(){
				$("#searchTags").attr("onchange",searchCustom())
			})
	    // Your code here
	});
	
	var timer
	function searchCustom(id_table,id_search_bar){
		var temp = 'year[]=', tempTa = 'ta_name[]=', tempCom = 'company[]=', tempSales = 'sales_name[]=', tempPresales = 'presales_name[]=', tempTer = 'territory[]=', tempResult = 'result[]=', tempCustomer = 'customer[]=', tempTech = 'tech_tag[]=', tempProduct = 'product_tag[]=', tempSearch = 'search='

		$.each($(".cb-territory:checked"),function(key,value){
			if (tempTer == 'territory[]=') {
		      tempTer = tempTer + value.value
		    }else{
		      tempTer = tempTer + '&territory[]=' + value.value
		    }
		})

	  	$.each($("#filter_sales").val(),function(key,value){
		  	if (tempSales == 'sales_name[]=') {
		      tempSales = tempSales + value
		    }else{
		      tempSales = tempSales + '&sales_name[]='+ value
		    }
		})

		$.each($("#filter_sales_manager").val(),function(key,value){
			if (tempSales == 'sales_name[]=') {
		      tempSales = tempSales + value
		    }else{
		      tempSales = tempSales + '&sales_name[]='+ value
		    }
		})

		temp = 'year[]='
		if ($("#year_dif").val() == '') {
			temp = temp + '&year[]='+ new Date().getFullYear()
		}else{
			$.each($("#year_dif").val(),function(key,value){
				if (temp == 'year[]=') {
			      temp = temp + value
			    }else{
			      temp = temp + '&year[]='+ value
			    }
			})
		}

		if ("{{Auth::User()->id_position}}" == 'DIRECTOR') {
			if ($("#year_dif_dir").is(":visible")) {
				if ($("#year_dif_dir").val().length == 0) {
					temp = temp + '&year[]='+ new Date().getFullYear()
				}else{
					$.each($("#year_dif_dir").val(),function(key,value){
						if (temp == 'year[]=') {
				      temp = temp + value
				    }else{
				      temp = temp + '&year[]='+ value
				    }

						$("#year_dif2_dir option[value="+ value +"]").prop('disabled',true);
					})
				}

				if ($("#year_dif2_dir").val().length == 0) {
					temp = temp + '&year[]='+ new Date().getFullYear()
				}else{
					$.each($("#year_dif2_dir").val(),function(key,value){
						if (temp == 'year[]=') {
				      temp = temp + value
				    }else{
				      temp = temp + '&year[]='+ value
				    }

						$("#year_dif_dir option[value="+ value +"]").prop('disabled',true);
					})
				}
			}
		}


		// if ($("#year_dif").val() == '') {
		// 	temp = temp + '&year[]='+ new Date().getFullYear()
		// }else{
		// 	$.each($("#year_dif").val(),function(key,value){
		// 		if (temp == 'year[]=') {
		//       temp = temp + value
		//     }else{
		//       temp = temp + '&year[]='+ value
		//     }
		// 	})
		// }

		$.each($("#filter_ta").val(),function(key,value){
			if (tempTa == 'ta_name[]=') {
		      tempTa = tempTa + value
		    }else{
		      tempTa = tempTa + '&ta_name[]='+ value
		    }
		})

		$.each($("#filter_presales").val(),function(key,value){
			if (tempPresales == 'presales_name[]=') {
	      tempPresales = tempPresales + value
	    }else{
	      tempPresales = tempPresales + '&presales_name[]='+ value
	    }
		})

	  	$.each($('#searchTags').val(),function(key, value) {
		    if (value.substr(0,1) == 'p') {
		    	if (tempProduct == 'product_tag[]=') {
			      tempProduct = tempProduct + value.substring(1)
			    }else{
			    	tempProduct = tempProduct + '&product_tag[]='+ value.substring(1)
			    }
		    }
		    if (value.substr(0,1) == 't') {
		    	if (tempTech == 'tech_tag[]=') {
			      tempTech = tempTech + value.substring(1)
			    }else{
			    	tempTech = tempTech + '&tech_tag[]='+ value.substring(1)
			    }
		    }
	  	});

		$.each($('#filter_customer').val(),function(key,value){
		  	if (tempCustomer == 'customer[]=') {
		      tempCustomer = tempCustomer + value
		    }else{
		    	tempCustomer = tempCustomer + '&customer[]=' + value
		    }
		})
		
		$.each($(".cb-company:checked"),function(key,value){
			if (tempCom == 'company[]=') {
	      tempCom = tempCom + value.value
	    }else{
	    	tempCom = tempCom + '&company[]=' + value.value
	    }
		})

		var checklist = false
		$.each($(".cb-result:checked"),function(key,value){
			if (tempResult == 'result[]=') {
	      tempResult = tempResult + value.value
	    }else{
	    	tempResult = tempResult + '&result[]=' + value.value
	    }
			checklist = true
		})

		if (id_search_bar == 'company') {
			if (tempCom == 'company[]=') {
	      tempCom = tempCom + 1
	    }
		}

		if (tempSearch == 'search=') {
		  tempSearch = tempSearch + $('#searchLead').val()
		}else{
			tempSearch = tempSearch + '&search=' + $('#searchLead').val()
		}

    	console.log(temp)

		var tempFiltered = '?' + temp + '&' + tempSales + '&' + tempTa + '&' + tempPresales + '&' + tempTer + '&' + tempCom + '&' + tempResult + '&' + tempProduct + '&' + tempTech + '&' + tempCustomer + '&' + tempSearch

		$("#tableLead").DataTable().ajax.url("{{url('project/getSearchLead')}}" + tempFiltered).load();
		dashboardCountFilter(tempFiltered)
	}

	function filterFromDashboard(){
		if (window.location.href.indexOf("status") != -1) {	
			if(window.location.href.split("=")[2]){
				$("#year_dif_dir").val(window.location.href.split("=")[2]).trigger("change")
				$("#year_dif").val(window.location.href.split("=")[2]).trigger("change")
			}else{
				var currentDate = moment();
				// Get the current year
				var currentYear = currentDate.year();
				$('#year_dif').val('').trigger('change')
				$('#year_dif').val(currentYear).trigger('change')
			}
			
		}
	}

	//dashboard count
	function initMoneyHeader(){
		$("#sum_amount_0").mask('000.000.000.000.000', {reverse: true})
		$("#sum_amount_1").mask('000.000.000.000.000', {reverse: true})
		$("#sum_amount_2").mask('000.000.000.000.000', {reverse: true})
		$("#sum_amount_3").mask('000.000.000.000.000', {reverse: true})
		$("#sum_amount_4").mask('000.000.000.000.000', {reverse: true})
		$("#sum_amount_5").mask('000.000.000.000.000', {reverse: true})
	}

	function initMoney(){
    $('.money').mask('000.000.000.000', {reverse: true});
  }


	function initRemoveMask(){
		$("#sum_amount_0").unmask('000.000.000.000.000', {reverse: true}).mask('000.000.000.000.000', {reverse: true})
		$("#sum_amount_1").unmask('000.000.000.000.000', {reverse: true}).mask('000.000.000.000.000', {reverse: true})
		$("#sum_amount_2").unmask('000.000.000.000.000', {reverse: true}).mask('000.000.000.000.000', {reverse: true})
		$("#sum_amount_3").unmask('000.000.000.000.000', {reverse: true}).mask('000.000.000.000.000', {reverse: true})
		$("#sum_amount_4").unmask('000.000.000.000.000', {reverse: true}).mask('000.000.000.000.000', {reverse: true})
		$("#sum_amount_5").unmask('000.000.000.000.000', {reverse: true}).mask('000.000.000.000.000', {reverse: true})
	}

	function dashboardCount(year){	
		var resultComplete
		$.ajax({
			type:"GET",
			url:"{{url('project/getCountLead')}}?"+ year,
			beforeSend:function(argument) {
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
					// Buat Mas ganjar total lead di ganti jadi Lead - Unassigned
					if(result.presales){
						$("#"+countLead[0]).prev().html("<b>Lead - Unassigned </b>")
						$("#"+countLead[0]).text(result.initial)
					} else {
						$("#"+countLead[0]).text(result.lead)
					}
					$("#"+countLead[1]).text(result.open)
					$("#"+countLead[2]).text(result.sd)
					$("#"+countLead[3]).text(result.tp)
					$("#"+countLead[4]).text(result.win)
					$("#"+countLead[5]).text(result.lose)
					$("#"+sumAmount[0]).text(result.amount_lead)
					$("#"+sumAmount[1]).text(result.amount_open)
					$("#"+sumAmount[2]).text(result.amount_sd)
					$("#"+sumAmount[3]).text(result.amount_tp)
					$("#"+sumAmount[4]).text(result.amount_win)
					$("#"+sumAmount[5]).text(result.amount_lose)

					resultComplete = result		

					$("#filter_lead_INITIAL").next().text("INITIAL (" + result.initial + ")")
					$("#filter_lead_OPEN").next().text("OPEN (" + result.open + ")")
					$("#filter_lead_SD").next().text("SD (" + result.sd + ")")
					$("#filter_lead_TP").next().text("TP (" + result.tp + ")")
					$("#filter_lead_WIN").next().text("WIN (" + result.win + ")")
					$("#filter_lead_LOSE").next().text("LOSE (" + result.lose + ")")
					$("#filter_lead_CANCEL").next().text("CANCEL (" + result.cancel + ")")	

				initMoneyHeader()

				$('.counter').each(function () {
				    var size = $(this).text().split(".")[1] ? $(this).text().split(".")[1].length : 0;
				    $(this).prop('Counter', 0).animate({
				      Counter: $(this).text()
				    }, {
				      duration: 5000,
				      step: function (func) {
				         $(this).text(parseFloat(func).toFixed(size));
				      }
				    });
				});
			},
			complete:function(){
				$("#filter_lead_INITIAL").next().text("INITIAL (" + resultComplete.initial + ")")
				$("#filter_lead_OPEN").next().text("OPEN (" + resultComplete.open + ")")
				$("#filter_lead_SD").next().text("SD (" + resultComplete.sd + ")")
				$("#filter_lead_TP").next().text("TP (" + resultComplete.tp + ")")
				$("#filter_lead_WIN").next().text("WIN (" + resultComplete.win + ")")
				$("#filter_lead_LOSE").next().text("LOSE (" + resultComplete.lose + ")")
				$("#filter_lead_CANCEL").next().text("CANCEL (" + resultComplete.cancel + ")")
			}
		})
	}

	function dashboardCountFilter(temp){
		$.ajax({
			type:"GET",
			url:"{{url('/project/filterCountLead')}}" + temp,
			beforeSend:function(argument) {
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
				$.each(result,function(){	
					if(result.presales){
						$("#"+countLead[0]).prev().html("<b>Lead - Unassigned </b>")
						$("#"+countLead[0]).text(result.initial)
					} else {
						$("#"+countLead[0]).text(result.lead)
					}
					$("#"+countLead[1]).text(result.open)
					$("#"+countLead[2]).text(result.sd)
					$("#"+countLead[3]).text(result.tp)
					$("#"+countLead[4]).text(result.win)
					$("#"+countLead[5]).text(result.lose)
					$("#"+sumAmount[0]).text(result.amount_lead)
					$("#"+sumAmount[1]).text(result.amount_open)
					$("#"+sumAmount[2]).text(result.amount_sd)
					$("#"+sumAmount[3]).text(result.amount_tp)
					$("#"+sumAmount[4]).text(result.amount_win)
					$("#"+sumAmount[5]).text(result.amount_lose)

					$("#filter_lead_INITIAL").next().text("INITIAL (" + result.initial_unfiltered + ")")
					$("#filter_lead_OPEN").next().text("OPEN (" + result.open_unfiltered + ")")
					$("#filter_lead_SD").next().text("SD (" + result.sd_unfiltered + ")")
					$("#filter_lead_TP").next().text("TP (" + result.tp_unfiltered + ")")
					$("#filter_lead_WIN").next().text("WIN (" + result.win_unfiltered + ")")
					$("#filter_lead_LOSE").next().text("LOSE (" + result.lose_unfiltered + ")")
					$("#filter_lead_CANCEL").next().text("CANCEL (" + result.cancel_unfiltered + ")")	
				})
				initRemoveMask()

				$('.counter').each(function () {
				    var size = $(this).text().split(".")[1] ? $(this).text().split(".")[1].length : 0;
				    $(this).prop('Counter', 0).animate({
				      Counter: $(this).text()
				    }, {
				      duration: 500,
				      step: function (func) {
				         $(this).text(parseFloat(func).toFixed(size));
				      }
				    });
				});
			}
		})
	}

	$(".select2").select2()

	if (localStorage.getItem('status') == "unread") {
    table.search(localStorage.getItem('lead_id')).draw()
  }

  if (localStorage.getItem('status') == 'read') {
    table.search("").draw()
  }
</script>
@endsection