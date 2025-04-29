@extends('template.main_sneat')
@section('tittle')
PMO Settlement
@endsection
@section('pageName')
Detail Settlement
@endsection
@section('head_css')
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmSAQhPWId5Nd6QxE8To4ADjM2a6n0BrqQdisZ/RPUlm0YycDzvNL1HHAh1nKZqI0kSbif+5upQ==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
<style type="text/css">
	textarea{
		resize: vertical;
		width: 100%;
	}

	.form-group{
		margin-bottom: 15px;
	}

	.pull-right{
		float: right;
	}
</style>
@endsection
@section('content')
<div class="container-xxl container-p-y flex-grow-1">
	<section class="content-header">
	  <h6><a href="{{url('pmo/settlement/index')}}"><button class="btn btn-sm text-bg-danger"><i class="bx bx-chevron-left"></i> Back </button></a> <span id="titleMonreq"> XXX/PMO/MR/X/2024 </span></h6>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-9 col-xs-12">
				<div class="card">
					<div class="card-body">
						<div class="form-group pull-right">
								<a id="btnExportSettlement" class="btn btn-sm text-bg-primary" target="_blank"><i class="bx bx-download"></i> Export Pdf</a>
						</div>
						<div class="table-responsive" style="min-width:100%">
							<div style="max-width: 100%;overflow-x: scroll;">
								<table class="table table-bordered" id="table_detail_settlement" style="width: 100%;" cellspacing="0">
								</table>
							</div>
						</div>
						<div class="col-md-12 col-xs-12">
							<hr>
							<div style="display: flex;grid-auto-columns: 2;margin: 0 auto;column-gap: 100px;" id="divSign">
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="pull-right">
							<button class="btn btn-sm btn-danger" onclick="rejectSettlement()" id="btnRejectSettlement" style="display:none!important;" disabled>Reject</button>
							<button class="btn btn-sm btn-primary" onclick="approveSettlement()" id="btnApproveSettlement" style="display:none!important;" disabled>Approve/Verify/Acknowledge</button>
						</div>
					</div>
				</div>	
			</div>
			<div class="col-md-3 col-xs-12">
				<div class="card" style="height:750px;overflow-y: scroll;">
					<div class="card-header">
						<h6 class="card-title">Change Log</h6>
					</div>
					<div class="card-body">
						<ul class="timeline">
						</ul>
					</div>
				</div>	
			</div>
		</div>
	</section>
</div>

<!--modal upload receipt-->
<div class="modal fade in" id="modal-notes-settlement">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" fdprocessedid="f2n9a"></button>
				<h6 class="modal-title">Notes Settlement</h6>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Reason</label>
					<textarea class="form-control" rows="4" id="notes_settlement"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" fdprocessedid="hapzj">Cancel</button>
				<button type="button" class="btn btn-primary" fdprocessedid="wzghmt" id="btnSubmitNotes" onclick="submitNotes()">Submit</button>
			</div>
		</div>
	</div>
</div>

<!--modal reject-->
<div class="modal fade in" id="modal-reject">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" fdprocessedid="f2n9a"></button>
				<h6 class="modal-title">Reject Settlement</h6>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Reason</label>
					<textarea class="form-control" id="reason_reject" name="reason_reject" rows="4" onkeyup="validationCheck(this)"></textarea>
					<span class="help-block" style="display:none!important;"></span>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" fdprocessedid="hapzj">Cancel</button>
				<button type="button" class="btn btn-danger" fdprocessedid="wzghmt" onclick="submitReject()">Reject</button>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scriptImport')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.js" integrity="sha512-SSQo56LrrC0adA0IJk1GONb6LLfKM6+gqBTAGgWNO8DIxHiy0ARRIztRWVK6hGnrlYWOFKEbSLQuONZDtJFK0Q==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
@endsection
@section('script')
	<script type="text/javascript">
		var accesable = @json($feature_item);
		accesable.forEach(function(item,index){
      $("#" + item).show()          
    }) 

    var formatter = new Intl.NumberFormat(['ban', 'id']);

		$(document).ready(function(){
			initTimeline()
			getDetailSettlement()
		})

		function initTimeline(){
			var append = ''

			$.ajax({
				type:"GET",
				url:"{{url('/pmo/settlement/getActivitySettlement')}}",
				data:{
					id_settlement:window.location.href.split("?")[1].split("=")[1]
				},
				success:function(result) {

					$.each(result,function(key,value){
					append = append + '<li class="timeline-item timeline-item-transparent">'
							if (value.status == 'DONE' || value.status == 'APPROVED' || value.status == 'VERIFIED') {
								append = append + '<span class="timeline-point timeline-point-success"></span>'
							}else if (value.status == 'CIRCULAR') {
								append = append + '<span class="timeline-point timeline-point-warning"></span>'
							}else{
								append = append + '<span class="timeline-point timeline-point-primary"></span>'
							}

							append = append + '<div class="timeline-event">'
	              append = append + '<div class="timeline-header mb-3">'
	                append = append + '<h6 class="mb-0">'+ value.operator +'</h6>'
	                append = append + '<small class="text-body-secondary">'+ value.date_format +'</small>'
	              append = append + '</div>'
	              append = append + '<p class="mb-2">'+ value.activity +'</p>'
	            append = append + '</div>'
						append = append + '</li>'
					})
					
					$(".timeline").append(append)
				}
			})
		}

		function getDetailSettlement(){
			$.ajax({
				type:"GET",
				url:"{{url('/pmo/settlement/getDetailSettlement')}}",
				data:{
					id_settlement:window.location.href.split("?")[1].split("=")[1]
				},
				success:function(result){
					$("#titleMonreq").text(result.settlement.no_monreq)
					initTableDetail(result.settlement.pid_details,result.settlement.sub_category,result)

					$("#btnExportSettlement").attr('style','display:none!important')
					if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Project Management Manager')->exists()}}" || "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','VP Project Management')->exists()}}" || "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.group','Financial And Accounting')->exists()}}") {
						$("#btnApproveSettlement").text('Approve')
					}else if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Chief Operating Officer')->exists()}}") {
						$("#btnApproveSettlement").text('Acknowledge')
					}else if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','PMO Officer')->exists()}}") {
						$("#btnApproveSettlement").text('Verify')
					}

					if(result.settlement.status == "NEW" || result.settlement.status == 'UNAPPROVED'){
						if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','PMO Officer')->exists()}}") {
							$("#btnApproveSettlement").prop("disabled",false)
							$("#btnRejectSettlement").prop("disabled",false)
						}
					}else if(result.settlement.status == 'CIRCULAR' || result.settlement.status == 'VERIFIED' || result.settlement.status == 'UNAPPROVED'){
						if (result.getSign == "{{Auth::User()->name}}") {
							$("#btnApproveSettlement").prop("disabled",false)
							$("#btnRejectSettlement").prop("disabled",false)
						}
					}else if(result.settlement.status == 'APPROVED'){
						if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.group','Financial And Accounting')->exists()}}") {
							$("#btnApproveSettlement").prop("disabled",false)
							$("#btnRejectSettlement").prop("disabled",false)
						}

						$("#btnExportSettlement").show()
						$("#btnExportSettlement").attr("href","{{url('/pmo/settlement/getExportSettlement?id_settlement=')}}"+window.location.href.split("=")[1]+'&isSettlementExport=settlement')
					}else{
						$("#btnApproveSettlement").prop("disabled",true)
						$("#btnRejectSettlement").prop("disabled",true)

						$("#btnExportSettlement").show()
						$("#btnExportSettlement").attr("href","{{url('/pmo/settlement/getExportSettlement?id_settlement=')}}"+window.location.href.split("=")[1]+'&isSettlementExport=settlement')
					}

					if (result.settlement.status == 'NEW' || result.settlement.status == 'VERIFIED' || result.settlement.status == 'DONE') {
						$(".btnEditSettlement").prop("disabled",true)
					}else if (result.settlement.status == 'UNAPPROVED') {
						$(".btnEditSettlement").prop("disabled",false)
					}

					var append = ""
					if (result.show_ttd.length > 0) {
						$.each(result.show_ttd,function(key,value) {
							if (result.show_ttd.length < 3) {
								append = append + '<div class="form-group">'
									if (key == 0) {
										append = append + '<label>Approved By</label>'
									}else{
										append = append + '<label style="visibility:hidden">Approved By</label>'
									}
									append = append + '<div style="display: flex;flex-direction: row;gap:50px">'
										append = append + '<div class="form-group">'
											append = append + '<img src="{{url("/")}}/'+ value.ttd +'" style="width:100px;height:100px"><br>'
											append = append + '<label>'+ value.name +'</label>'
										append = append + '</div>'
									append = append + '</div>'
								append = append + '</div>'
							}else{
								append = append + '<div class="form-group">'
									if (key == 2) {
										append = append + '<label>Acknowledge By</label>'
									}else{
										if (key == 0) {
											append = append + '<label>Approved By</label>'
										}else{
											append = append + '<label style="visibility:hidden">Approved By</label>'
										}
									}
									append = append + '<div class="form-group">'
										append = append + '<img src="{{url("/")}}/'+ value.ttd +'" style="width:100px;height:100px"><br>'
										append = append + '<label>'+ value.name +'</label>'
									append = append + '</div>'
								append = append + '</div>'
							}
						})
					}else{
						append = append + '<div><i>Sign No Available..</i></div>'
					}

					$("#divSign").append(append)
				}
			})
		}

		function initTableDetail(contentTable,headerTable,results){
			var append = '',colLenght = ''

			append = append + '<thead>'
				append = append + '<tr>'
					append = append + '<th>No</th>'
					append = append + '<th>Date</th>'
					append = append + '<th>PID</th>'
					$.each(headerTable,function(key,value){
						append = append + '<th style="white-space:nowrap">'+ value.sub_category +'</th>'
					})
					append = append + '<th>Total</th>'
					append = append + '<th style="width:30%">Description</th>'
					append = append + '<th>Receipt</th>'
					append = append + '<th>Receipt Grab</th>'
					append = append + '<th>Image</th>'
					append = append + '<th width="20%">Note</th>'
					if(accesable.includes('col-action-detail')){
						append = append + '<th>Action</th>'					
					}
				append = append + '</tr>'
			append = append + '</thead>'
			append = append + '<tbody class="table" style="white-space:nowrap">'
				$.each(contentTable,function(key,value){
					$.each(value.details,function(keys,values){
						append = append + '<tr>'
							append = append + '<td>'+ ++keys +'</td>'
							append = append + '<td>'+ values.date +'</td>'
							append = append + '<td><span style="display:inline">'+ values.pid +'</span></td>'
								$.each(headerTable,function(key,valueHeader){
									if (valueHeader.sub_category == values.sub_category) {
										if (values.status == 'NEW') {
											append = append + '<td><span style="background-color:red;color:white">Rp.'+ formatter.format(values.nominal) +'</span></td>'
										}else{
											append = append + '<td>Rp.'+ formatter.format(values.nominal) +'</td>'
										}
									}else{
										append = append + '<td> - </td>'
									}
								})
							append = append + '<td>'+ formatter.format(values.nominal) +'</td>'
							if (values.sub_category == 'Entertainment' || values.sub_category == 'KPHL' ) {
								var url = ''
								if (values.sub_category == 'Entertainment') {
									url = "{{url('pmo/settlement/getExportEntertain?id_settlement=')}}"+ window.location.href.split("?")[1].split("=")[1] + "&isEntertainExport=entertain&id_sub_category="+ values.id+'&pid='+values.pid
								}else if (values.sub_category == 'KPHL') {
									url = "{{url('pmo/settlement/getExportKPHL?id_settlement=')}}"+ window.location.href.split("?")[1].split("=")[1] + "&isAllowanceExport=KPHL&id_sub_category="+ values.id+'&pid='+values.pid
								}

								if (results.settlement.status == 'DONE') {
									append = append + '<td><div style="display:flex;gap:10px"><span style="display:inline">'+ values.sub_category +'</span><a href="'+ url +'" target="_blank"><button class="btn btn-xs text-bg-primary" style="display:inline;float:right"><i class="bx bx-paper-plane" style="font-size:14px"></i></button></a><div></td>'
								}else{
									append = append + '<td>'+ values.description +'</td>'
								}
							}else{
								append = append + '<td>'+ values.description +'</td>'
							}
							append = append + '<td style="width:20px">'
								if (values.receipt) {
									append = append + '<a style="font-size:11px" href="'+ values.receipt +'" target="_blank"><i class="bx bx-images" style="font-size:14px"></i> Receipt</a>'
								}else{
									append = append + ' - '
								}
							append = append + '</td>'
							append = append + '<td style="width:20px">'
								if (values.receipt_grab) {
									append = append + '<a style="font-size:11px" href="'+ values.receipt_grab +'" target="_blank"><i class="bx bx-images"  style="font-size:14px"></i> Receipt Grab</a>'
								}else{
									append = append + ' - '
								}
							append = append + '</td>'
							append = append + '<td style="text-align:left">'
								if (values.image) {
									append = append + '<a style="font-size:11px" href="'+ values.image +'" target="_blank"><i class="bx bx-images"  style="font-size:14px"></i> Image</a>'
								}else{
									append = append + ' - '
								}
							append = append + '</td>'
							append = append + '<td class="text-red" width="20%" style="white-space:nowrap">'+ values.notes +'</td>'
							if(accesable.includes('col-action-detail')){
								append = append + '<td>'
									append = append + '<div style="display:flex;gap:5px">'
										if (accesable.includes('btnEditSettlement')) {
											if (values.notes != '-' && values.notes !=  null || results.settlement.status == "UNAPPROVED") {
												//ini di or unapproved ketika reject dari selain pmo officer
												append = append + '<a href="{{url("/pmo/settlement/add_settlement?edit_settlement=")}}'+ results.settlement.id +'&pid='+ values.pid +'&category='+ values.category + '&id_sub_category='+ values.id + '"><button class="btn btn-sm btn-warning btnEditSettlement" id="btnEditSettlement"><i class="fa fa-pencil"></i> Edit</button></a>'
											}else{
												append = append + '-'
											}
										}else if (accesable.includes('btnResolve')) {
											console.log(results.settlement.status)
											if (results.settlement.status == 'VERIFIED' || results.settlement.status == 'CIRCULAR' || results.settlement.status == 'APPROVED' || results.settlement.status == 'DONE') {
												append = append + ' - '
											}else{
												if (values.status == 'NEW') {
													append = append + '<button class="btn btn-sm btn-warning btnEditNotes" onclick="editNotes('+ values.id +','+"'"+ values.sub_category +"'"+')"><i class="fa fa-pencil"></i></button>'
													append = append + '<button class="btn btn-sm btn-success btnResolveNotes" onclick="resolveNotes('+ values.id +','+"'"+ values.sub_category +"'"+')"><i class="fa fa-check"></i></button>'
												}else{
													append = append + '<button class="btn btn-sm btn-primary btnAddNotes" onclick="addNotes('+ values.id +','+"'"+ values.sub_category +"'"+')"><i class="fa fa-plus"></i></button>'
												}
											}
										}										
									append = append + '</div>'
								append = append + '</td>'
							}
						append = append + '</tr>'
					})
					append = append + '<tr>'
						append = append + '<th colspan="3" style="text-align:right">Total</th>'
						colLenght = headerTable.length + 6
						$.each(headerTable,function(keyFooter,valueFooter){
							$.each(valueFooter.total_by_pid,function(keysFooter,valuesFooter){
								if (keysFooter == value.pid) {
									append = append + '<th>Rp.'+ formatter.format(valuesFooter) +'</th>'
								}
							})
						})
						append = append + '<td colspan="7"></td>'
					append = append + '</tr>'
				})
			append = append + '</tbody>'

			append = append + '<tfoot>'
				append = append + '<tr>'
					append = append + '<th colspan="'+ colLenght +'">Transferred from finance</th>'
					append = append + '<td colspan="3">Rp.'+ formatter.format(results.tf_from_finance) +'</td>'
				append = append + '</tr>'
				append = append + '<tr>'
					append = append + '<th colspan="'+ colLenght +'">Used amount</th>'
					append = append + '<td colspan="3">Rp.'+ formatter.format(results.used_amount) +'</td>'
				append = append + '</tr>'
				append = append + '<tr>'
					append = append + '<th colspan="'+ colLenght +'">Remaining funds</th>'
					append = append + '<td colspan="3">Rp.'+ formatter.format(results.remaining_funds) +'</td>'
				append = append + '</tr>'
			append = append + '</tfoot>'
				
			$("#table_detail_settlement").append(append)
			$("#total").text(formatter.format(1000000))
			$("#total_price").text(formatter.format(20000))
			$("#input_acc_number").val(20000)
			$("#input_acc_name").val(20000)
			$("#input_transfer_date").daterangepicker()
			$("#input_transfer_date").val(moment().format('YYYY-MM-DD'))
		}

		function rejectSettlement(){
			$("#modal-reject").modal('show')
		}

		function submitReject(){
      if ($("#reason_reject").val() == "") {
      	$("#reason_reject").next('.help-block').show()
      	$("#reason_reject").next('.help-block').text("Please fill "+ $("#reason_reject").prev('label').text().replace(/[*]/g, "") + '!')
      	$("#reason_reject").closest('.form-group').addClass('has-error')
      }else{
      	swalAccept = Swal.fire({
	        title: 'Are you sure',
	        text: 'Reject Settlement',
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes',
	        cancelButtonText: 'No',
	      })

	      formData = new FormData()
	      formData.append("_token","{{csrf_token()}}")
	      formData.append("id_settlement",window.location.href.split("?")[1].split("=")[1])
	      formData.append("reasonRejectSirkular",$("#reason_reject").val())

      	savePost(swalAccept,url="{{url('pmo/settlement/rejectSettlement')}}",formData)
      }
		}

		function approveSettlement(){
			formData = new FormData()
	    formData.append('_token','{{csrf_token()}}')
	    formData.append('id_settlement',window.location.href.split("?")[1].split("=")[1])
	    formData.append('isHasNotes',$("#table_detail_settlement").find("tbody").find("td:last").find("div").find("button.btnEditNotes").is(":visible"))

			if ($("#btnApproveSettlement").text() == 'Verify') {
				if ($("#table_detail_settlement").find("tbody").find("td:last").find("div").find("button.btnEditNotes").is(":visible")) {
					text = "You will verify settlement with notes!"
				}else{
					text = "You will verify settlement without notes!"
				}

				url = "{{url('pmo/settlement/verifySettlement')}}"

				SwalAccept = Swal.fire({
	        title: 'Are you sure',
	        text: text,
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes',
	        cancelButtonText: 'No',
	      })
			}else{
				url = "{{url('pmo/settlement/approveSettlement')}}"

				SwalAccept = Swal.fire({
	        title: 'Are you sure',
	        text: 'Approve Settlement',
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes',
	        cancelButtonText: 'No',
	      })
			}

      savePost(SwalAccept,url,formData)
		}

		function addNotes(id_sub_category,sub_category){
			$("#modal-notes-settlement").modal("show")

			$("#btnSubmitNotes").attr("onclick","submitNotes('"+ id_sub_category +"','"+ sub_category +"')")
		}

		function editNotes(id_sub_category,sub_category){
			$("#modal-notes-settlement").modal("show")

			$("#btnSubmitNotes").attr("onclick","submitNotes('"+ id_sub_category +"','"+ sub_category +"')")
		}

		function resolveNotes(id_sub_category,sub_category){
			swalAccept = Swal.fire({
	      title: 'Are You Sure?',
	      text: 'Resolve Notes Settlement',
	      icon: 'warning',
	      showCancelButton: true,
	      confirmButtonColor: '#3085d6',
	      cancelButtonColor: '#d33',
	      confirmButtonText: 'Yes',
	      cancelButtonText: 'No',
	    })

	    var formData = new FormData()
	   	formData.append("_token","{{ csrf_token() }}")
	    formData.append("idSettlement",window.location.href.split("?")[1].split("=")[1])
	    formData.append("idSubCategory",id_sub_category)
	    formData.append("subCategory",sub_category)

	    savePost(swalAccept,url="{{url('pmo/settlement/resolveNotes')}}",formData)
		}

		function submitNotes(id_sub_category,sub_category){
			swalAccept = Swal.fire({
	      title: 'Are You Sure?',
	      text: 'Add Notes Settlement',
	      icon: 'warning',
	      showCancelButton: true,
	      confirmButtonColor: '#3085d6',
	      cancelButtonColor: '#d33',
	      confirmButtonText: 'Yes',
	      cancelButtonText: 'No',
	    })

	    var formData = new FormData()
	   	formData.append("_token","{{ csrf_token() }}")
	    formData.append("idSettlement",window.location.href.split("?")[1].split("=")[1])
	    formData.append("idSubCategory",id_sub_category)
	    formData.append("subCategory",sub_category)
	    formData.append("inputNotes",$("#notes_settlement").val())

	    savePost(swalAccept,url="{{url('pmo/settlement/storeNotesSettlement')}}",formData)
		}

		function savePost(swalAccept,url,data){
      swalAccept.then((result) => {
        if (result.value) {
          $.ajax({
            type:"POST",
            url:url,
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
            	var id = result.tid
              Swal.showLoading()
              Swal.fire(
                'Successfully!',
                'success'
              ).then((result) => {
                if (result.value) {
                  window.location.assign('{{url("pmo/settlement/detail_settlement?id_detail=")}}'+id);
                }
              })
            },
            error: function(xhr, status, error) {
            	console.log(xhr)
		          // Handle errors
		            // Capture the error message from the backend
						    let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : "Something went wrong, please try again!";
						    
						    // Display the error using SweetAlert
						    Swal.fire({
						      title: 'Error!',
						      text: errorMessage,  // Use the error message from the backend
						      icon: 'error',
						      confirmButtonText: 'Try Again'
						    });
		        }
          }) 
        }        
      })
		}

		function validationCheck(data){
			if ($(data).val() != '') {
				$(data).next('.help-block').attr('style','display:none!important')
				$(data).next().next('.help-block').attr('style','display:none!important')
				$(data).closest(".form-group").removeClass('has-error')
			}
		}
</script>
@endsection