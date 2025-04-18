@extends('template.main_sneat')
@section('tittle')
Lead Setting
@endsection
@section('pageName')
Lead Setting
@endsection
@section('content')
@section('head_css')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
<style type="text/css">
	.transparant{
		background-color: Transparent;
		background-repeat:no-repeat;
		border: none;
		cursor:pointer;
		overflow: hidden;
		outline:none;
		width: 25px;
	}
	.alert-box {
			color:#555;
			border-radius:10px;
			font-family:Tahoma,Geneva,Arial,sans-serif;font-size:14px;
			padding:10px 36px;
			margin:10px;
	}
	.alert-box span {
			font-weight:bold;
			text-transform:uppercase;
	}
	.error {
			background:#ffecec;
			border:1px solid #f5aca6;
	}
	.success {
			background:#e9ffd9 ;
			border:1px solid #a6ca8a;
	}
	.warning {
			background:#fff8c4 ;
			border:1px solid #f2c779;
	}
	.notice {
			background:#e3f7fc;
			border:1px solid #8ed9f6;
	}

	.row:before, .row:after{
		display: inline-block; !important;
	}

	.dropbtn {
		background-color: #4CAF50;
		color: white;
		font-size: 12px;
		border: none;
		width: 140px;
		height: 30px;
		border-radius: 5px;
	}

	.dropbtn-date {
		background-color: #4CAF50;
		color: white;
		font-size: 12px;
		border: none;
		width: 150px;
		height: 35px;
		border-radius: 5px;
	}

	.dropbtn-add {
		background-color: #2fa8d8;
		color: white;
		font-size: 12px;
		border: none;
		width: 140px;
		height: 30px;
		border-radius: 5px;
	}
	.dropdown-content {
		display: none;
		position: absolute;
		background-color: #f1f1f1;
		min-width: 140px;
		card-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
		z-index: 1;
	}
	.dropdown-content .year:hover {background-color: #ddd;}
	.dropdown:hover .dropdown-content {display: block;}
	.dropdown:hover .dropbtn {background-color: #3e8e41;}
	.transparant-filter{
		background-color: Transparent;
		background-repeat:no-repeat;
		border: none;
		cursor:pointer;
		overflow: hidden;
		outline:none;
	}
	div div ol li a{font-size: 14px;}
	div div i{font-size: 14px;}
	background-color:dodgerBlue;}
	.inputWithIconn.inputIconBg i{
		background-color:#aaa;
		color:#fff;
		padding:7px 4px;
		border-radius:4px 0 0 4px;
	}
	.inputWithIconn{
		position:relative;
	}
	.inputWithIconn i{
		position:absolute;
		left:0;
		top:28px;
		padding:9px 8px;
		color:#aaa;
		transition:.3s;
	}

	.modalIcon i{
		top:25px;
	}

	.inputWithIconn input[type=text]{
		padding-left:40px;
	}
	label.status-lose:hover{
		border-radius: 10%;
		background-color: grey;
	 ;
		width: 75px;
		height: 30px;
		color: white;
		padding-top: 3px;
		cursor: zoom-in;
	}
	table.center{
	;
	}
	.stats_item_number {
		white-space: nowrap;
		font-size: 2.25rem;
		line-height: 2.5rem;
		
		&:before {
			display: none;
		}
	}

	.txt_success {
		color: #2EAB6F;
	}

	.txt_warn {
		color: #f2562b;
	}

	.txt_sd {
		color: #04dda3;
	}

	.txt_tp{
		color: #f7e127;
	}

	.txt_win{
		color: #246d18;
	}

	.txt_lose{
		color: #e5140d;
	}

	.txt_smaller {
		font-size: .75em;
	}

	.flipY {
		transform: scaleY(-1);
		border-bottom-color: #fff;
	}

	.txt_faded {
		opacity: .65;
	}

	.txt_primary{
		color: #007bff;
	}

	.select2{
			width: 100%!important;
	}
	tr.group,
	tr.group:hover {
		background-color: #ddd !important;
	}
	tr.groupSort:hover {
		cursor: pointer;
	}
	.vertical-alignment-helper {
		display:table;
		height: 100%;
		width: 100%;
		pointer-events:none;
	}
	.vertical-align-center {
		display: table-cell;
		vertical-align: middle;
		pointer-events:none;
	}
	.modal-content {
		width:inherit;
		max-width:inherit; 
		height:inherit;
		margin: 0 auto;
		pointer-events: all;
	}
	.btn-change {
		width: auto;
	}
	.modal {
		overflow-y:auto;
	}
	#swal2-content {
		text-align: left !important; 
	}
	.swal2-popup {
		width:50em !important;
	}

	.pull-right{
		float: right;
	}
</style>
@endsection
	<div class="container-xxl container-p-y flex-grow-1">	
		<section class="content">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Lead Register Setting</h6>
				</div>
				<div class="card-body">
					<table id="tableSetting" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>name</th>
								<th>lead_id</th>
								<th>opp_name</th>
								<th>brand_name</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</section>
	</div>

	<div class="modal fade" id="modal-show-lead">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog vertical-align-center">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						<h6 class="modal-title">Change Sales Lead</h6>
					</div>
					<div class="modal-body">
						<p id="sales-name"></p>
						<ul id="list-lead">
						</ul>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary pull-left" data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" onclick="saveChange()">Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-select-sales">
		<div class="vertical-alignment-helper">
			<div class="modal-dialog vertical-align-center">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						<h6 class="modal-title">Chose Sales</h6>
					</div>
					<div class="modal-body">
						<p>Chose selected sales for this change</p>
						<p id="leadName"></p>
						<input type="hidden" id="leadId">
						<input type="hidden" id="leadSales">
						<div class="form-group" id="list-sales">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary pull-left" data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" onclick="changeSales()">Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scriptImport')
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('script')	
	<script>
		var groupColumn = 0;
		var table = $('#tableSetting').DataTable({
			"ajax" : {
				"url":"{{url('sales/lead_setting/getDataLead')}}",
				"type":"GET",
				"dataSrc": function (json){
					json.data.forEach(function(data,idex){
						data.lead_id = "<a href='https://app.sinergy.co.id/detail_project/" + data.lead_id + "' target='_blank'>" + data.lead_id + "</a>"
					})
					return json.data
				}
			},
			"columns" : [
				{data:'name'},{data:'lead_id'},{data:'opp_name'},{data:'brand_name'}
			],
			"columnDefs": [
				{ "visible": false, "targets": groupColumn }
			],
			"order": [[ groupColumn, 'asc' ]],
			"displayLength": 25,
			"drawCallback": function ( settings ) {
				var api = this.api();
				var rows = api.rows( {page:'current'} ).nodes();
				var last=null;
	 
				api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
					if ( last !== group ) {
						$(rows).eq( i ).before(
							'<tr class="group">' + 
							'	<td colspan="5">' + 
									'<span class="groupSort">' +
										group + 
									'</span> <span class="pull-right btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-show-lead" data-sales-name="' + group + '">Edit</span>' +
								'</td>' +
							'</tr>'
						);
						last = group;
					}
				});
			}
		});

		// $('input[type="checkcard"].flat-red, input[type="radio"].flat-red').iCheck({
		// 	checkcardClass: 'icheckcard_flat-blue',
		// 	radioClass: 'iradio_flat-blue'
		// });

		document.addEventListener('DOMContentLoaded', function () {
		  const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
		  popoverTriggerList.map(function (el) {
		    return new bootstrap.Popover(el);
		  });
		});

		$('#modal-select-sales').on('show.bs.modal', function (event) {
			$(this).find('#leadName').text($(event.relatedTarget).data('lead-name'))
			$(this).find('#leadId').val($(event.relatedTarget).data('lead-id'))
			$(this).find('#leadSales').val($(event.relatedTarget).data('lead-sales'))
			$.ajax({
				type:"GET",
				url:"{{url('sales/lead_setting/getDataListSales')}}",
				success: function(result){
					$("#list-sales").empty()
					var append = ""
					var first = ""
					$.each(result,function(key,value){
						var temp = ""
						temp = temp + '<div style="display:flex;margin-bottom:5px">'
						temp = temp + '	<label>'
						if(value.name == $(event.relatedTarget).data('lead-sales')){
							temp = temp + '		<input type="radio" name="salesRadio" class="flat-red" value="' + value.name + '" checked>'
						} else {
							temp = temp + '		<input type="radio" name="salesRadio" class="flat-red" value="' + value.name + '">'
						}
						temp = temp + '		' + value.name
						temp = temp + '	</label>'
						temp = temp + '	<a class="btn text-bg-secondary btn-xs" style="margin-left:auto" role="button" tabindex="0" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-trigger="focus" data-bs-content="Active : ' + value.ACTIVE + '<br>Win : ' + value.WIN + '<br>Lose : ' + value.LOSE + '<br>All : ' + value.ALL + '" data-bs-html="true">Detail</a>'
						temp = temp + '</div>'
						if(value.name == $(event.relatedTarget).data('lead-sales')){
							first = temp
						} else {
							append = append + temp
						}
					})
					$("#list-sales").append(first)
					$("#list-sales").append(append)
				},
				complete: function(){
					const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
					popoverTriggerList.map(function (el) {
					  return new bootstrap.Popover(el);
					});
					// $('[data-bs-toggle="popover"]').popover()
					// $('input[type="checkcard"].flat-red, input[type="radio"].flat-red').iCheck({
					// 	checkcardClass: 'icheckcard_flat-blue',
					// 	radioClass: 'iradio_flat-blue'
					// });
				}
			})
		})

		$('#modal-show-lead').on('show.bs.modal', function (event) {
			$.ajax({
				type:"GET",
				url:"{{url('sales/lead_setting/getDataLeadPerSales')}}",
				data:{
					salesName:$(event.relatedTarget).data('sales-name')
				},
				success: function(result){
					$("#sales-name").text("This is Sales Lead own by " + $(event.relatedTarget).data('sales-name'))
					$("#list-lead").empty()
					var append = ""
					$.each(result.data,function(key,value){
						append = append + '<li>'
						append = append + '	<span class="pull-right">'
						append = append + '		<button class="btn btn-primary btn-xs btn-change btn-change-' + value.lead_id+ '" data-bs-toggle="modal" data-bs-target="#modal-select-sales" type="button" data-lead-name="' + value.opp_name + '" data-lead-id="' + value.lead_id + '" data-lead-sales="' + value.name + '">Change Owner</button>'
						append = append + '	</span>'
						append = append + '	<span class="span-' + value.lead_id + '">'
						append = append + '		<b>[<a href="https://app.sinergy.co.id/detail_project/' + value.lead_id + '" target="_blank">' + value.lead_id + '</a>] ' + value.opp_name + '</b>'
						append = append + '		<br>Customer : <span>' + value.brand_name + '</span>'
						append = append + '	</span>'
						append = append + '</li>'
					})
					$("#list-lead").append(append)
				}
			})
		})

		function changeSales(){
			$("input[name='salesRadio']:checked").val()
			$(".btn-change-" + $("#leadId").val()).removeClass("btn-primary").addClass("btn-danger")
			$(".btn-change-" + $("#leadId").val()).text("Changed to " + $("input[name='salesRadio']:checked").val())
			$(".span-" + $("#leadId").val() + ">b").addClass('change-selected')
			console.log($(".span-" + $("#leadId").val() + ">b").text())
		}

		function saveChange(){
			var sales = []
			var lead = []
			var changes = []
			$.each($(".btn-change.btn-danger"),function(key,value){
				sales.push(value.innerText)
			})
			$.each($(".change-selected"),function(key,value){
				lead.push(value.innerText)
			})
			var message = "<table style=width:100%>"
			$.each(lead,function(key,value){
				message = message + "<tr><td>" + value + "</td><td style='text-align:right'><b>" + sales[key] + "</b></td><tr>"
				changes.push({id_lead: value,to_sales:sales[key]})
			})
			message = message + "</table>"
			// var changes = [
			// 	{id_lead: "AAAAAAA",to_sales:"BBBBBB"},
			// 	{id_lead: "CCCCCCC",to_sales:"DDDDDD"},
			// 	{id_lead: "EEEEEEE",to_sales:"FFFFFF"},
			// ]
			Swal.fire({
				title: "Are you sure for this change?",
				html: "" + message + "",
				type:"warning",
				showCancelButton: true,
				allowOutsideClick: false,
				allowEscapeKey: false,
				allowEnterKey: false,
				confirmButtonText: 'Yes',
				cancelButtonText: 'No'
			}).then((result) => {
				if (result.value){
					Swal.fire({
						title: 'Please Wait..!',
						html: "<p style='text-align:center;'>It's sending..</p>",
						allowOutsideClick: false,
						allowEscapeKey: false,
						allowEnterKey: false,
						onOpen: () => {
							Swal.showLoading()
						}
					})
					$.ajax({
						type:"POST",
						url:"{{url('sales/lead_setting/postUpdateSales')}}",
						data:{
							data:changes,
							_token:"{{ csrf_token() }}"
						},
						success: function(){
							Swal.hideLoading()
							Swal.fire({
								title: 'Success!',
								html: "<p style='text-align:center;'>Lead Changes Saved</p>",
								type: 'success',
								confirmButtonText: 'Reload',
							}).then((result) => {
								$("#modal-show-lead").modal('hide')
								$("#tableSetting").DataTable().ajax.url("{{url('sales/lead_setting/getDataLead')}}").load();
							})
						}
					})
				}
			})
		}
	</script> button-change-sales1
@endsection