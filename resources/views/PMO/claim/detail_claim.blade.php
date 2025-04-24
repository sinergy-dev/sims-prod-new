@extends('template.main_sneat')
@section('tittle')
Claim
@endsection
@section('pageName')
Claim
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
</style>
@endsection
@section('content')
<div class="container-xxl container-p-y flex-grow-1">
	<section class="content-header">
	  <h6><a href="{{url('pmo/claim/index')}}"><button class="btn btn-sm text-bg-danger"><i class="bx bx-chevron-left"></i> Back </button></a> <span id="titleClaim"> XXX/PMO/CLM/X/2024 </span></h6>
	</section>
	<section class="content">
		<div class="row mb-4">
			<div class="col-md-9 col-xs-12">
				<div class="card">
					<div class="card-body">
						
						<div class="row mb-4">
							<div class="col-md-5 col-xs-12">
								<div class="form-group">
									<label>Account Number</label>
									<input type="text" name="account_number" id="account_number" class="form-control" disabled>
								</div>
							</div>
							<div class="col-md-5 col-xs-12">
								<div class="form-group">
									<label>Account Name</label>
									<input type="text" name="account_name" id="account_name" class="form-control" disabled>
								</div>
							</div>
							<div class="col-md-2 col-xs-12" style="padding-top:20px">
								<div class="form-group pull-right">
									<a class="btn btn-sm text-bg-primary" style="display: none;" id="btnExportClaim" target="_blank"><i class="bx bx-download"></i> Export Pdf</a>
								</div>
							</div>
						</div>
						<div class="table-responsive" style="min-width:100%">
							<div style="max-width: 100%;overflow-x: scroll;">
								<table class="table table-bordered table-striped" id="table_detail_claim" style="width: 100%;" cellspacing="0">
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
							<button class="btn btn-sm btn-danger" style="display:none!important;" id="btnRejectClaim" onclick="rejectClaim()" disabled>Reject</button>
							<button class="btn btn-sm btn-primary" id="btnApproveClaim" style="display:none!important;" disabled>Approve</button>
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
				<button type="button" class="btn btn-primary" fdprocessedid="wzghmt" onclick="submitNotes()">Submit</button>
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
				<h6 class="modal-title">Reject Claim</h6>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Reason</label>
					<textarea class="form-control" id="reasonRejectSirkular" name="reasonRejectSirkular" rows="4"></textarea>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
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

  console.log(accesable)

  var formatter = new Intl.NumberFormat(['ban', 'id']);

	$(document).ready(function(){
		initTimeline()
		getDetailClaim()
	})

	function initTimeline(){
		var append = ''
		$.ajax({
			type:"GET",
			url:"{{url('/pmo/claim/getActivityClaim')}}",
			data:{
				id_claim:window.location.href.split("?")[1].split("=")[1]
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
				append = append + '<th>Image</th>'
				append = append + '<th width="20%">Note</th>'
				if(results.claim.status == 'UNAPPROVED'){
					if (results.claim.issuance == "{{Auth::User()->nik}}") {
						append = append + '<th>Action</th>'	
					}				
				}
			append = append + '</tr>'
		append = append + '</thead>'
		$.each(contentTable,function(key,value){
			append = append + '<tbody class="table" style="width:100%;white-space:nowrap">'
				$.each(value.details,function(keys,values){
					append = append + '<tr>'
						append = append + '<td>'+ ++keys +'</td>'
						append = append + '<td>'+ values.date +'</td>'
						append = append + '<td><span style="display:inline">'+ values.pid +'</span></td>'
							$.each(headerTable,function(key,value){
								if (value.sub_category == values.sub_category) {
									if (values.status == 'NEW') {
										append = append + '<td><span style="background-color:red;color:white">Rp.'+ formatter.format(values.nominal) +'</span></td>'
									}else{
										append = append + '<td>Rp.'+ formatter.format(values.nominal) +'</td>'
									}
								}else{
									append = append + '<td> - </td>'
								}
							})
						append = append + '<td>Rp.'+ formatter.format(values.nominal) +'</td>'
						if (values.sub_category == 'Entertainment' || values.sub_category == 'KPHL' ) {
							var url = ''
							console.log(values.pid)
							if (values.sub_category == 'Entertainment') {
								url = "{{url('pmo/claim/getExportEntertainClaim?id_claim=')}}"+ window.location.href.split("?")[1].split("=")[1] + "&isEntertainExport=entertain&id_sub_category="+ values.id+'&pid='+values.pid
							}else if (values.sub_category == 'KPHL') {
								url = "{{url('pmo/claim/getExportKPHLClaim?id_claim=')}}"+ window.location.href.split("?")[1].split("=")[1] + "&isAllowanceExport=KPHL&id_sub_category="+ values.id+'&pid='+values.pid
							}

							if (results.claim.status == 'DONE' || results.claim.status == 'APPROVED') {
								append = append + '<td><div style="display:flex;gap:10px"><span style="display:inline">'+ values.sub_category +'</span><a href="'+ url +'" target="_blank"><button class="btn btn-xs text-bg-primary" style="display:inline;float:right"><i class="bx bx-mail-forward"></i></button></a><div></td>'
							}else{
								append = append + '<td>'+ values.description +'</td>'
							}
						}else{
							append = append + '<td>'+ values.description +'</td>'
						}
						append = append + '<td>'
							if (values.receipt) {
								append = append + '<a style="font-size:11px" href="'+ values.receipt +'" target="_blank"><i class="bx bx-note"></> Receipt</a>'
							}else{
								append = append + ' - '
							}
						append = append + '</td>'
						append = append + '<td>'
							if (values.image) {
								append = append + '<a style="font-size:11px" href="'+ values.image +'" target="_blank"><i class="bx bx-images"></> Image</a>'
							}else{
								append = append + ' - '
							}
						append = append + '</td>'
						append = append + '<td class="text-red" width="20%" style="white-space:nowrap">'+ values.notes +'</td>'
						if(results.claim.status == 'UNAPPROVED'){
							if (results.claim.issuance == "{{Auth::User()->nik}}") {
								append = append + '<td>'	
									append = append + '<a href="{{url("/pmo/claim/add_claim?edit_claim=")}}'+ results.claim.id +'&pid='+ values.pid +'&category='+ values.category + '&id_sub_category='+ values.id + '" class="btn btn-sm btn-warning btnEditClaim" id="btnEditClaim" style="display:none"><i class="bx bx-pencil"></i> Edit</a>'
								append = append + '</td>'
							}
						}
					append = append + '</tr>'
				append = append + '</tbody>'
				})
			append = append + '<tr>'
				append = append + '<th colspan="3" style="text-align:right">Grand Total</th>'
				colLenght = headerTable.length + 6
				$.each(headerTable,function(keyFooter,valueFooter){
					$.each(valueFooter.total_by_pid,function(keysFooter,valuesFooter){
						if (keysFooter == value.pid) {
							append = append + '<th>Rp.'+ formatter.format(valuesFooter) +'</th>'
						}
					})
				})
				append = append + '<th>Rp.'+ formatter.format(results.claim.nominal) +'</th>'
				append = append + '<td colspan="6"></td>'
			append = append + '</tr>'
		})
				
		$("#table_detail_claim").append(append)
		$("#total").text(formatter.format(1000000))
		$("#total_price").text(formatter.format(20000))

		$("#input_acc_number").val(20000)
		$("#input_acc_name").val(20000)
		$("#input_transfer_date").daterangepicker()
		$("#input_transfer_date").val(moment().format('YYYY-MM-DD'))

		accesable.forEach(function(item,index){
	    $("." + item).show()          
	  }) 
	}

	function rejectClaim(){
		$("#modal-reject").modal('show')
	}

	function submitReject(){
		swalAccept = Swal.fire({
      title: 'Are you sure',
      text: 'Reject Claim',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No',
    })

    formData = new FormData()
    formData.append('_token','{{csrf_token()}}')
	  formData.append('reasonRejectSirkular',$("#reasonRejectSirkular").val())
	  formData.append('id_claim',window.location.href.split("?")[1].split("=")[1])

    savePost(swalAccept,url="{{url('pmo/claim/rejectClaim')}}",formData)
	}

	function approveClaim(){
		swalAccept = Swal.fire({
      title: 'Are you sure',
      text: 'Approve Claim',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No',
    })

    formData = new FormData()
    formData.append('_token','{{csrf_token()}}')
	  formData.append('id_claim',window.location.href.split("?")[1].split("=")[1])

    savePost(swalAccept,url="{{url('pmo/claim/approveClaim')}}",formData)
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
            var id = result.tid

            Swal.showLoading()
            Swal.fire(
              'Successfully!',
              'success'
            ).then((result) => {
              if (result.value) {
                window.location.assign('{{url("pmo/claim/detail_claim?id_claim=")}}'+id);
              }
            })
          },
          error: function(xhr, status, error) {
          	console.log(xhr.responseJSON.data)
	          // Handle errors
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

	function getDetailClaim(){
		$.ajax({
			url:"{{url('pmo/claim/getDetailClaim')}}",
			data:{
				id_claim:window.location.href.split("?")[1].split("=")[1]
			},
			success:function(result) {
				$("#titleClaim").text(result.claim.no_claim)
				$("#account_number").val(result.claim.account_number)
				$("#account_name").val(result.claim.account_name)

				initTableDetail(result.claim.pid_details,result.claim.sub_category,result)

				if (result.claim.status == 'APPROVED' || result.claim.status == 'DONE') {
					$("#btnExportClaim").show()
					$("#btnExportClaim").attr("href","{{url('/pmo/claim/getExportClaim?id_claim=')}}"+window.location.href.split("=")[1]+'&isClaimExport=claim')
				}

				var append = ""
				if (result.show_ttd.length > 0) {
					append = append + '<div class="form-group">'
						append = append + '<label>Approver Sign</label>'
							append = append + '<div style="display:flex;flex-direction:row;gap:100px">'
							$.each(result.show_ttd,function(key,value) {
									append = append + '<div class="form-group">'
										append = append + '<img src="{{url("/")}}/'+ value.ttd +'" style="width:100px;height:100px"><br>'
										append = append + '<label>'+ value.name +'</label>'
									append = append + '</div>'
							})
							append = append + '</div>'

					append = append + '</div>'
				}else{
					append = append + '<div><i>Sign No Available..</i></div>'
				}

				$("#divSign").append(append)

				if (
					"{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','like','%Manager%')->exists()}}" || "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','like','%VP%')->exists()}}" || "{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.group','like','%Financial And Accounting%')->exists()}}"
				) {
					$("#btnApproveClaim").text("Approve")
					$("#btnApproveClaim").attr("onclick","approveClaim()")
				}else if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.name','like','%Director%')->exists()}}") {
					$("#btnApproveClaim").text("Acknowledge")
					$("#btnApproveClaim").attr("onclick","approveClaim()")
				}

				if (result.claim.issuance != "{{Auth::User()->nik}}") {
					if(result.claim.status == 'CIRCULAR' || result.claim.status == 'NEW' || result.claim.status == 'APPROVED'){
						if (result.getSign == "{{Auth::User()->name}}") {
							$("#btnApproveClaim").prop("disabled",false)
							$("#btnRejectClaim").prop("disabled",false)
						} else {
							if ("{{App\RoleUser::where('user_id',Auth::User()->nik)->join('roles','roles.id','=','role_user.role_id')->where('roles.group','like','%Financial And Accounting%')->exists()}}") {
								$("#btnApproveClaim").prop("disabled",false)
								$("#btnRejectClaim").prop("disabled",false)
							}
						}
					}else{
						$("#btnApproveClaim").prop("disabled",true)
						$("#btnRejectClaim").prop("disabled",true)
					}
				}else{
					$("#btnApproveClaim").attr('style','display:none!important')
					$("#btnRejectClaim").attr('style','display:none!important')
				}
			}
		})
	}

</script>
@endsection