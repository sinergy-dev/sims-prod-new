@extends('template.main_sneat')
@section('tittle')
PMO Money Request Detail
@endsection
@section('pageName')
Money Request Detail
@endsection
@section('head_css')
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmSAQhPWId5Nd6QxE8To4ADjM2a6n0BrqQdisZ/RPUlm0YycDzvNL1HHAh1nKZqI0kSbif+5upQ==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}"/>
<style type="text/css">
	textarea{
		resize: vertical;
		width: 100%;
	}
</style>
@endsection
@section('content')
<div class="container-xxl container-p-y flex-grow-1">
	<section class="content-header">
	  <h6><a href="{{url('pmo/monreq/index')}}"><button class="btn btn-sm text-bg-danger"><i class="bx bx-chevron-left"></i> Back </button></a> <span id="titleMonreq"> XXX/PMO/MR/X/2024 </span></h6>
	</section>
	<section class="content">
		<div class="row mb-4">
			<div class="col-md-9 col-xs-12">
				<div class="card">
					<div class="card-body">
						<div class="row mb-4">
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label>Account Number</label>
									<input type="text" name="input_acc_number" id="input_acc_number" class="form-control" disabled>
								</div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label>Account Name</label>
									<input type="text" name="input_acc_name" id="input_acc_name" class="form-control" disabled>
								</div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="form-group">
									<label>Request Transfer Date</label>
									<div class="input-group">
										<span class="input-group-text">
											<i class="bx bx-calendar"></i>	
										</span>
										<input type="text" name="input_transfer_date" id="input_transfer_date" class="form-control" disabled>
									</div>
								</div>
							</div>
							<div class="col-md-3 col-xs-12" style="padding-top:20px">
								<a class="pull-right">
									<button id="btnEditMonreq" class="btn btn-sm btn-warning" style="display: none!important;"><i class="bx bx-pencil"></i> Edit</button>
								</a>
								<a class="pull-right" target="_blank">
									<button class="btn btn-sm text-bg-primary" id="btnExportMonreq" style="display:none!important;"><i class="bx bx-file-pdf"></i> Export Pdf</button>
								</a>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table_detail_monreq" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>No</th>
										<th>PID</th>
										<th>Category</th>
										<th>Team Name</th>
										<th>Qty</th>
										<th>Price</th>
										<th>Total</th>
										<th>Event Detail</th>
										<th>Start Date</th>
										<th>End Date</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
								<tfoot>
									<tr>
										<th colspan="6" style="text-align:right;">Grand Total</th>
										<td colspan="4">Rp.<span id="total_price"></span></td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="col-md-12 col-xs-12">
							<hr>
							<div style="display: flex;grid-auto-columns: 2;margin: 0 auto;column-gap: 100px;" id="divSign">
							</div>
							<hr>
							<div class="form-group" id="divPoT">
								
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="pull-right">
							<button class="btn btn-sm btn-warning" style="display:none!important" onclick="holdMonreq()" id="btnHoldMonreq">Hold</button>
							<button class="btn btn-sm text-bg-primary" style="display:none!important" onclick="uploadReceipt()" id="btnUploadReceipt">Upload Receipt</button>
							<button class="btn btn-sm btn-danger" style="display:none!important" onclick="rejectMonreq()" id="btnRejectMonreq">Reject</button>
							<button class="btn btn-sm btn-primary" style="display:none!important" onclick="approveMonreq()" id="btnApproveMonreq">Approve/Acknowledge</button>
						</div>
					</div>
				</div>	
			</div>
			<div class="col-md-3 col-xs-12">
				<div class="card">
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
<div class="modal fade in" id="modal-upload-receipt">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" fdprocessedid="f2n9a">
				<span aria-hidden="true">×</span></button>
				<h6 class="modal-title">Upload Receipt</h6>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<input type="file" name="upload_receipt" class="form-control" id="upload_receipt" onchange="validationCheck(this)">
					<span class="invalid-feedback" style="display:none!important;"></span>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" fdprocessedid="hapzj">Cancel</button>
				<button type="button" class="btn btn-primary" fdprocessedid="wzghmt" onclick="submitUpload()">Upload</button>
			</div>
		</div>
	</div>
</div>

<!--modal reject-->
<div class="modal fade in" id="modal-reject">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" fdprocessedid="f2n9a">
				<span aria-hidden="true">×</span></button>
				<h6 class="modal-title">Reject Money Request</h6>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Reason</label>
					<textarea class="form-control" id="reason_reject" name="reason_reject" rows="4" onkeyup="validationCheck(this)"></textarea>
					<span class="invalid-feedback" style="display:none!important;"></span>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal" fdprocessedid="hapzj">Cancel</button>
				<button type="button" class="btn btn-danger" fdprocessedid="wzghmt" onclick="submitReject()">Reject</button>
			</div>
		</div>
	</div>
</div>

<!--modal hold-->
<div class="modal fade in" id="modal-hold">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" fdprocessedid="f2n9a">
				<span aria-hidden="true">×</span></button>
				<h6 class="modal-title">Hold Money Request</h6>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Reason</label>
					<textarea class="form-control" id="reason_hold" name="reason_hold" rows="4" onkeyup="validationCheck(this)"></textarea>
					<span class="invalid-feedback" style="display:none!important;"></span>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger pull-left" data-dismiss="modal" fdprocessedid="hapzj">Cancel</button>
				<button type="button" class="btn btn-warning" fdprocessedid="wzghmt" onclick="submitHold()">Hold</button>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scriptImport')
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
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
			getDetailMonreq()
			initTimeline()
		})

		function initTimeline(){
			var append = ''

			$.ajax({
				url:"{{url('/pmo/monreq/getActivityMonReq')}}",
				data:{
					id_money_request:window.location.href.split("?")[1].split("=")[1]
				},
				type:"GET",
				success:function(result){
					$.each(result,function(key,value){
						append = append + '<li class="timeline-item timeline-item-transparent">'
							if (value.status == 'APPROVED') {
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
					append = append + '<li class="timeline-item timeline-item-transparent">'
					append = append + '<span class="timeline-point timeline-point-info"></span>'
						append = append + '<div class="timeline-event">'
                append = append + '<div class="timeline-header mb-3">'
                  append = append + '<h6 class="mb-0">NEW</h6>'
                append = append + '</div>'
                append = append + '<p class="mb-2">Money Request has been created!</p>'
              append = append + '</div>'
					append = append + '</li>'
					
					$(".timeline").append(append)
				}
			})
			
		}

		function getDetailMonreq() {
			$.ajax({
				type:"GET",
				url:"{{url('/pmo/monreq/getDetailMonReq')}}",
				data:{
					id_money_request:window.location.href.split("?")[1].split("=")[1]
				},
				success:function(result) {
					$("#titleMonreq").text(result.monReq['no_monreq'])
					$("#input_acc_number").val(result.monReq['account_number'])
					$("#input_acc_name").val(result.monReq['account_name'])
					$("#input_transfer_date").val(result.monReq['req_transfer_date'])
					$("#total_price").text(formatter.format(result.monReq['nominal']))
					// $("#input_transfer_date").flatpickr()
					initTableDetail(result.monReq.pid_details)

					if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Project Management Manager')->exists()}}" || "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','VP Project Management')->exists()}}") {
						$("#btnUploadReceipt").hide()
						$("#btnHoldMonreq").hide()
						$("#btnApproveMonreq").text('Approve')
					}else if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','Chief Operating Officer')->exists()}}") {
						$("#btnUploadReceipt").hide()
						$("#btnHoldMonreq").hide()
						$("#btnApproveMonreq").text('Acknowledge')
					}else if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.group','Financial And Accounting')->exists()}}") {
						$("#btnUploadReceipt").show()
						if (result.monReq.status == 'APPROVED') {
							$("#btnUploadReceipt").attr("disabled",false)
						}else{
							$("#btnUploadReceipt").attr("disabled",true)
						}
					}else{
						$("#btnHoldMonreq").hide()
						$("#btnUploadReceipt").hide()
					}
					if (result.getSign == "{{Auth::User()->name}}") {
						$("#btnApproveMonreq").prop("disabled",false)
						$("#btnRejectMonreq").prop("disabled",false)
					}else{
						$("#btnApproveMonreq").prop("disabled",true)
						$("#btnRejectMonreq").prop("disabled",true)
					}

					var id_monreq = window.location.href.split("?")[1].split("=")[1]

					if (result.monReq['status'] == 'NEW') {
						$("#btnEditMonreq").hide()
						$("#btnExportMonreq").hide()
					}else if (result.monReq['status'] == 'UNAPPROVED') {
						if (result.monReq['account_name'] == "{{Auth::User()->name}}") {
							$("#btnEditMonreq").show()
						}
						$("#btnEditMonreq").closest("a").attr("href","{{url('/pmo/monreq/add_monreq?edit_monreq=')}}"+id_monreq)
						$("#btnExportMonreq").hide()
						$("#btnRejectMonreq").prop("disabled",true)
						$("#btnApproveMonreq").prop("disabled",true)
					}else if (result.monReq['status'] == 'APPROVED') {
						$("#btnEditMonreq").hide()
						$("#btnExportMonreq").show()
					}else if (result.monReq['status'] == 'DONE') {
						$("#btnExportMonreq").show()
						$("#btnHoldMonreq").hide()
						$("#btnUploadReceipt").hide()
					}

					// $("#btnExportMonreq").closest("a").attr('onclick','exportMonreq('+ id_monreq +')')
					$("#btnExportMonreq").closest("a").attr("href","{{url('/pmo/monreq/getExportMonreq?id_money_request=')}}"+id_monreq)

					var append = "", appendPoT = ""
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

					if (result.monReq['proof_of_transfer'] != null) {
						appendPoT = appendPoT + '<label>Proof of Transfer</label>'
							// $.each(result.show_ttd,function(key,value){
								appendPoT = appendPoT + '<div class="row mb-4">'
									appendPoT = appendPoT + '<div class="col-md-6">'
										appendPoT = appendPoT + '<div class="form-group" style="border: 1px solid #dee2e6 !important;padding: 5px;">'
											appendPoT = appendPoT + '<a href="'+ result.monReq['proof_of_transfer'] +'" target="blank_"><i class="bx bx-fw fa-file-pdf-o"></i>proof_of_transfer.png</a>'
										appendPoT = appendPoT + '</div>'
									appendPoT = appendPoT + '</div>'
								appendPoT = appendPoT + '</div>'
							// })
					}else{
						appendPoT = appendPoT + '<div><i>Proof of Transfer No Available..</i></div>'
					}

					$("#divPoT").append(appendPoT)
				}
			})
		}

		function initTableDetail(data){
			var append = ''

			$.each(data,function(key,value) {
				if (value.details.length > 0) {
					$.each(value.details,function(keys,values){
						append = append + '<tr>'
							append = append + '<td>'+ ++keys +'</td>'
							append = append + '<td>'+ values.pid +'</td>'
							append = append + '<td>'+ values.category +'</td>'
							append = append + '<td>'+ value.team_name.replace(/\n/g, "<br>") +'</td>'
							append = append + '<td>'+ values.unit_concat +'</td>'
							append = append + '<td>Rp.'+ formatter.format(values.price) +'</td>'
							append = append + '<td>Rp.'+ formatter.format(values.total_price) +'</td>'
							append = append + '<td>'+ value.event_detail +'</td>'
							append = append + '<td>'+ value.start_date +'</td>'
							append = append + '<td>'+ value.end_date +'</td>'
						append = append + '</tr>'
					})	
				}
				append = append + '<tr>'
					append = append + '<th colspan="6" style="text-align:right">Total</th>'
					append = append + '<td colspan="4">Rp.'+ formatter.format(value.nominal) +'</td>'
				append = append + '<tr>'
			})
			
			$("#table_detail_monreq").find("tbody").append(append)
		}

		function holdMonreq(){
			$("#modal-hold").modal('show')
		}

		function submitHold(){
			if ($("#reason_hold").val() == "") {
				$("#reason_hold").next('.invalid-feedback').show()
				$("#reason_hold").next('.invalid-feedback').text('Please fill '+ $("#reason_hold").prev('label').text().replace(/[*]/g, "") + '!')
				$("#reason_hold").closest(".form-group").addClass('needs-validation')
			}else{
				swalAccept = Swal.fire({
	        title: 'Are you sure',
	        text: 'Hold Money Request',
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes',
	        cancelButtonText: 'No',
	      })

	      var formData = new FormData()

	      formData.append("_token","{{ csrf_token() }}")
	      formData.append("id_money_request",window.location.href.split("?")[1].split("=")[1])
	      formData.append("reasonHold",$("#reason_hold").val())

	      savePost(swalAccept,url="{{url('pmo/monreq/holdMonReq')}}",formData)
			}
		}

		function rejectMonreq(){
			$("#modal-reject").modal('show')
		}

		function submitReject(){
			if ($("#reason_reject").val() == "") {
				$("#reason_reject").next('.invalid-feedback').show()
				$("#reason_reject").next('.invalid-feedback').text('Please fill '+ $("#reason_reject").prev('label').text().replace(/[*]/g, "") + '!')
				$("#reason_reject").closest(".form-group").addClass('needs-validation')
			}else{
				swalAccept = Swal.fire({
	        title: 'Are you sure',
	        text: 'Reject Money Request',
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes',
	        cancelButtonText: 'No',
	      })

	      var formData = new FormData()

	      formData.append("_token","{{ csrf_token() }}")
	      formData.append("id_money_request",window.location.href.split("?")[1].split("=")[1])
	      formData.append("reasonRejectSirkular",$("#reason_reject").val())

	      savePost(swalAccept,url="{{url('pmo/monreq/rejectMonReq')}}",formData)
			}
		}

		function approveMonreq(){
			swalAccept = Swal.fire({
        title: 'Are you sure',
        text: 'Approve Money Request',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
      })

			var formData = new FormData()

	    formData.append("_token","{{ csrf_token() }}")
	    formData.append("id_money_request",window.location.href.split("?")[1].split("=")[1])
      savePost(swalAccept,url="{{url('pmo/monreq/approveMonReq')}}",formData)
		}

		function uploadReceipt(){
			$("#modal-upload-receipt").modal('show')			
		}

		function submitUpload(){
			if ($("#upload_receipt").val() == "") {
				$("#upload_receipt").next('.invalid-feedback').show()
				$("#upload_receipt").next('.invalid-feedback').text('Please Upload Receipt!')
				$("#upload_receipt").closest(".form-group").addClass('needs-validation')
			}else{
				swalAccept = Swal.fire({
	        title: 'Are you sure',
	        text: 'Submit Receipt',
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes',
	        cancelButtonText: 'No',
	      })

	      var formData = new FormData()

	      formData.append("_token","{{ csrf_token() }}")
	      formData.append("id_money_request",window.location.href.split("?")[1].split("=")[1])
	      formData.append("upload_receipt",$('#upload_receipt').prop('files')[0])

	      savePost(swalAccept,url="{{url('pmo/monreq/uploadReceipt')}}",formData)
			}
		}

		function savePost(swalAccept,url,data){
      swalAccept.then((result) => {
        if (result.value) {
          $.ajax({
            type:"POST",
            url:url,
            data:data,
            processData: false,
            contentType: false,
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
              Swal.showLoading()
              Swal.fire(
                'Successfully!',
                'success'
              ).then((result) => {
                if (result.value) {
                  location.reload()
                }
              })
            },
            error: function(xhr, status, error) {
            	console.log(xhr)
            	// Swal.hideLoading()

            	let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : "Something went wrong, please try again!";
    
					    // Display the error using SweetAlert
					    Swal.fire({
					      title: 'Error!',
					      text: errorMessage,  // Use the error message from the backend
					      icon: 'error',
					      confirmButtonText: 'Try Again'
					    }).then((result) => {
								$.ajax(this)
							})

							// Swal.fire({
							// 	title: 'Error!',
							// 	text: "Something went wrong, please try again!",
							// 	icon: 'error',
							// 	confirmButtonText: 'Try Again',
							// }).then((result) => {
							// 	$.ajax(this)
							// })
		        }
          }) 
        }        
      })
		}

		function validationCheck(data){
			if ($(data).val() != '') {
				$(data).next('.invalid-feedback').hide()
				$(data).next().next('.invalid-feedback').hide()
				$(data).closest(".form-group").removeClass('needs-validation')

				if (data.id == 'upload_receipt') {
					var f= data.files[0]
	        var filePath = f;
	     
	        // Allowing file type
	        var allowedExtensions =
	        /(\.jpg|\.jpeg|\.png)$/i;

	        var ErrorText = []
	        // 
	        if (f.size > 30000000|| f.fileSize > 30000000) {
	          Swal.fire({
	            icon: 'error',
	            title: 'Oops...',
	            text: 'Invalid file size, just allow file with size less than 30MB!',
	          }).then((result) => {
	            data.value = ''
	          })
	        }

	        var ext = filePath.name.split(".");
	        ext = ext[ext.length-1].toLowerCase();      
	        var arrayExtensions = ["jpg" , "jpeg", "png"];

	        if (arrayExtensions.lastIndexOf(ext) == -1) {
	          Swal.fire({
	            icon: 'error',
	            title: 'Oops...',
	            text: 'Invalid file type, just allow png/jpg file',
	          }).then((result) => {
	            data.value = ''
	          })
	        }
				}
			}
		}

		function exportMonreq(id) {
			Swal.fire({
			title: 'Are you sure?',
			text: "You'll get your monreq PDF!",
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
						text: "Please do not wait, we will notify you when it\'s done!",
						icon: "info",
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
						url: "{{url('/pmo/monreq/getExportMonreq?id_money_request=')}}"+id,
						success: function(result){
							Swal.hideLoading()
							if(result == 0){
								Swal.fire({
									//icon: 'error',
									title: 'Success!',
									text: "The file is unavailable",
									type: 'error',
									//confirmButtonText: '<a style="color:#fff;" href="report/' + result.slice(1) + '">Get Report</a>',
								})
							}else{
								Swal.fire({
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
	</script>
@endsection