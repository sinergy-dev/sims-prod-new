@extends('template.main_sneat')
@section('tittle')
Partnership
@endsection
@section('pageName')
Partnership Detail
@endsection
@section('head_css')
  	<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  	<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
  	<link rel="preload" href="{{asset('assets/css/simplePagination.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
  	<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
	<style type="text/css">
		.iframe-cont {
			position: relative;
			width: 100%;
			overflow: hidden;
			;
			/* 3:2 Aspect Ratio */
		}

		.responsive-iframe {
			position: absolute;
			top: 0;
			left: 0;
			bottom: 0;
			right: 0;
			width: 100%;
			height: 100%;
			border: none;
		}

		.image-preview {
			max-width: 576px;
		}

		@media only screen and (max-width: 600px) {
			.image-preview {
				width: 100%;
				display: block;
			}

			margin:20px auto;
		}

		iframe {
			max-width: 100vw;
			max-height: 56.25vw;
			/* 315/560 = .5625 */
		}

		input {
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			-o-user-select: none;
			user-select: none;
		}

		.select2-container--default.select2-container--disabled .select2-selection--multiple {
			background-color: rgba(0, 0, 0, 0) !important;
			outline: 0;
			border-width: 0 0 1px !important;
			/*borde-color:  grey !important;*/
		}

		.select2-container--default .select2-selection--multiple {
			outline: 0;
			border-width: 0 0 2px !important;
			border-color: #00c0ef;
		}

		/*	input[readonly]{
			background-color:rgba(0,0,0,0) !important;
	    border:none !important;
		}*/

		.form-control[disabled] {
			background-color: rgba(0, 0, 0, 0) !important;
			border: none !important;
		}

		input.transparent-input {
			/*	outline: 0;
		  border-width: 0 0 2px;
		  border-color: #00c0ef*/
			background-color: rgba(0, 0, 0, 0) !important;
			border: none !important;
		}

		select.transparent-input {
			outline: 0;
			border-width: 0 0 2px;
			border-color: #00c0ef;
		}

		table#table-detail td {
			border: none !important;
		}

		.avatar-upload {
			display: inline-block;
			position: relative;
			max-width: 205px;
			margin: 20px auto;
			margin-right: 10px;
		}

		.avatar-upload .avatar-edit {
			position: absolute;
			right: -5px;
			z-index: 1;
			top: -10px;
		}

		.avatar-upload .avatar-edit input {
			display: none;
		}

		.avatar-upload .avatar-edit input+label {
			display: inline-block;
			width: 34px;
			height: 34px;
			margin-bottom: 0;
			border-radius: 100%;
			background: #FFFFFF;
			border: 1px solid transparent;
			card-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
			cursor: pointer;
			font-weight: normal;
			transition: all 0.2s ease-in-out;
		}

		.avatar-upload .avatar-edit input+label:hover {
			background: #f1f1f1;
			border-color: #d6d6d6;
		}

		.avatar-upload .avatar-edit input+label:after {
			content: "\f040";
			font-family: 'FontAwesome';
			color: #757575;
			position: absolute;
			top: 10px;
			left: 0;
			right: 0;
			text-align: center;
			margin: auto;
		}

		.avatar-upload .avatar-preview {
			width: 192px;
			height: 192px;
			position: relative;
			border-radius: 10%;
			border: 6px solid #F8F8F8;
			card-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
		}

		.avatar-upload .avatar-preview>div {
			width: 100%;
			height: 100%;
			border-radius: 10%;
			background-size: contain;
			background-repeat: no-repeat;
			background-position: center;
		}

		.avatar-upload-mini {
			display: inline-block;
			position: relative;
			/*max-width: 105px;*/
			margin: 20px auto;
		}

		.avatar-upload-mini span {
			position: absolute;
			visibility: hidden;
		}

		.avatar-upload-mini :hover span {
			visibility: visible;
			top: 0;
			left: 100px;
			z-index: 1;
		}

		.avatar-upload-mini .avatar-edit {
			position: absolute;
			right: -5px;
			z-index: 1;
			top: -10px;
		}

		.avatar-upload-mini .avatar-edit input {
			display: none;
		}

		.avatar-upload-mini .avatar-edit input+label {
			display: inline-block;
			width: 34px;
			height: 34px;
			margin-bottom: 0;
			border-radius: 100%;
			background: #FFFFFF;
			border: 1px solid transparent;
			card-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
			cursor: pointer;
			font-weight: normal;
			transition: all 0.2s ease-in-out;
		}

		.avatar-upload-mini .avatar-edit input+label:hover {
			background: #f1f1f1;
			border-color: #d6d6d6;
		}

		.avatar-upload-mini .avatar-edit input+label:after {
			content: "\f040";
			font-family: 'FontAwesome';
			color: #757575;
			position: absolute;
			top: 10px;
			left: 0;
			right: 0;
			text-align: center;
			margin: auto;
		}

		.avatar-upload-mini .avatar-preview {
			width: 92px;
			height: 92px;
			position: relative;
			border-radius: 10%;
			border: 6px solid #F8F8F8;
			card-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
		}

		.avatar-upload-mini .avatar-preview>div {
			width: 100%;
			height: 100%;
			border-radius: 10%;
			background-size: contain;
			background-repeat: no-repeat;
			background-position: center;
		}

		.simple-pagination ul {
			margin: 0 0 20px;
			padding: 0;
			list-style: none;
			text-align: center;
		}

		.simple-pagination li {
			display: inline-block;
			margin-right: 5px;
		}

		.simple-pagination li a,
		.simple-pagination li span {
			color: #666;
			text-decoration: none;
			border: 1px solid #EEE;
			background-color: #3c8dbc;
			card-shadow: 0px 0px 10px 0px #EEE;
		}

		.simple-pagination .current {
			color: #FFF;
			background-color: #3c8dbc;
			border-color: #3c8dbc;
		}

		.simple-pagination .prev.current,
		.simple-pagination .next.current {
			background: #3c8dbc;
		}

		.pull-left{
			float: left;
		}

		.pull-right{
			float: right;
		}

		.form-group{
			margin-bottom: 15px;
		}

		.todo-list {
	      margin: 0;
	      padding: 0;
	      list-style: none;
	      overflow: auto;
	    }

	    .todo-list > li:last-of-type {
	      margin-bottom: 0;
	    }

	    .todo-list > li {
	      border-radius: 2px;
	      padding: 10px;
	      background: #f4f4f4;
	      margin-bottom: 2px;
	      border-left: 2px solid #e6e7e8;
	      color: #444;
	    }

	    .todo-list .handle {
	      display: inline-block;
	      cursor: move;
	      margin: 0 5px;
	    }

	    .todo-list > li > input[type="checkbox"] {
	      margin: 0 10px 0 5px;
	    }

	    .todo-list > li .text {
	      display: inline-block;
	      margin-left: 5px;
	      font-weight: 600;
	    }

	    .todo-list > li .badge {
	      margin-left: 10px;
	      font-size: 9px;
	    }

	    .swal2-container{
	    	z-index: 99999!important;
	    }
	</style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
	<section class="content">
	<div class="row mb-4">
		<div class="col-md-4 col-xs-12">
			<div class="card card-primary">
				<div class="card-body">
					<form id="formEdit" enctype="multipart/form-data">
						@csrf
						<div style="align-items: center" class="mb-3">
							<div style="margin: auto;display:table;">
								<div class="avatar-upload">
									<div class="avatar-edit" style="display:none">
										<input type='file' id="imageUpload" name="logo" accept=".png, .jpg, .jpeg" />
										<label for="imageUpload"></label>
									</div>
									<div class="avatar-preview">
										@if($data->logo == "")
										<div id="imagePreview" name="logo"
											style="background-image: url('{{ asset('image/logo_partnership/logo_placeholder.png')}}')">
										</div>
										@else
										<div id="imagePreview" name="logo"
											style="background-image: url('{{ asset('image/logo_partnership/'.$data->logo)}}')">
										</div>
										@endif
									</div>
								</div>
								<div class="avatar-upload-mini">
									<div class="avatar-edit" style="display:none">
										<input type='file' id="imageBadge" name="logo" accept=".png, .jpg, .jpeg" />
										<label for="imageBadge"></label>
									</div>
									<div class="avatar-preview">
										@if($data->badge == "")
										<div id="badgePreview" name="logo"
											style="background-image: url('{{ asset('image/badge_partnership/badge_placeholder.png')}}')">
										</div>
										@else
										<div id="badgePreview" name="logo"
											style="background-image: url('{{ asset('image/badge_partnership/'.$data->badge)}}')">
										</div>
										<span><img width="250px"
												src="{{asset('image/badge_partnership/'.$data->badge)}}"
												alt=""></span></a>
										@endif
									</div>
								</div>
							</div>
						</div>
						<div style="padding:10px">
							<table id="table-detail">
								<tr>
									<input type="" name="id_edit" id="id_edit" value="{{$data->id_partnership}}"
										style="display:none">
									<td style="vertical-align: middle;">Partner Name</td>
									<th><input class="form-control transparent-input" readonly type="text"
											id="partner_edit" name="partner_edit" value="{{$data->partner}}"></th>
								</tr>
								<tr>
									<td style="vertical-align: middle;">Standarization Website</td>
									<th>
										<select class="form-control transparent-input" id="standarization_edit" name="standarization_edit"
											disabled>
											<option value="Seasoned" @if($data->standarization == 'Seasoned') selected
												@endif>Seasoned</option>
											<option value="Stalwart" @if($data->standarization == 'Stalwart') selected
												@endif>Stalwart</option>
											<option value="Trending" @if($data->standarization == 'Trending') selected
												@endif>Trending</option>
											<option value="Featuring" @if($data->standarization == 'Featuring') selected
												@endif>Featuring</option>
										</select>
									</th>
								</tr>
								<tr>
									<td style="vertical-align: middle;">Level</td>
									<th><input class="form-control transparent-input" readonly type="text"
											id="levelling_edit" name="levelling_edit" value="{{$data->levelling}}"></th>
								</tr>
								<tr>
									<td style="vertical-align: middle;">Current Level</td>
									<th><input class="form-control transparent-input" readonly type="text"
											id="level_edit" name="level_edit" value="{{$data->level}}"></th>
								</tr>
								<tr>
									<td style="vertical-align: middle;">Type</td>
									<th>
										<select class="form-control transparent-input" id="type_edit" name="type_edit"
											disabled>
											<option value="">Select Type</option>
											<option value="Distributor" @if($data->type == 'Distributor') selected
												@endif>Distributor</option>
											<option value="Principal" @if($data->type == 'Principal') selected
												@endif>Principal</option>
										</select>
									</th>
								</tr>
								<tr>
									<td style="vertical-align: middle;">Renewal Date</td>
									<th><input class="form-control transparent-input" readonly type="date"
											id="renewal_edit" name="renewal_edit" value="{{$data->renewal_date}}"></th>
								</tr>
								<tr>
									<td style="vertical-align: middle;">Renewal Fee</td>
									<th><input class="form-control transparent-input" readonly type="text"
											id="annual_edit" name="annual_edit" value="{{$data->annual_fee}}"></th>
								</tr>
								<tr>
									<td style="vertical-align: middle;">CAM</td>
									<th><input class="form-control transparent-input" readonly type="text" id="cam_edit"
											name="cam_edit" value="{{$data->cam_name}}"></th>
								</tr>
								<tr>
									<td style="vertical-align: middle;">CAM Phone</td>
									<th><input class="form-control transparent-input" readonly type="text"
											id="phone_edit" name="phone_edit" value="{{$data->cam_phone}}"></th>
								</tr>
								<tr>
									<td style="vertical-align: middle;">CAM Email</td>
									<th><input class="form-control transparent-input" readonly type="text"
											id="email_edit" name="email_edit" value="{{$data->cam_email}}"></th>
								</tr>
								<tr>
									<td style="vertical-align: middle;">Email Support</td>
									<th><input class="form-control transparent-input" readonly type="text"
											id="support_edit" name="support_edit" value="{{$data->email_support}}"></th>
								</tr>
								<tr>
									<td style="vertical-align: middle;">ID Mitra</td>
									<th><input class="form-control transparent-input" readonly type="text"
											id="mitra_edit" name="mitra_edit" value="{{$data->id_mitra}}"></th>
								</tr>
								<tr>
									<td style="vertical-align: middle;">Partner Portal URL</td>
									<th><input class="form-control transparent-input" readonly type="text"
											id="partner_portal_edit" name="partner_portal_edit"
											value="{{$data->portal_partner}}"></th>
								</tr>
								<tr>
									<td style="vertical-align: middle;">Technology Tag</td>
									<th>
										<select class="form-control" id="technologyTag_edit" name="technologyTag_edit"
											style="width: 100%;" disabled></select>
									</th>
								</tr>
							</table>
					</form>
					<div class="d-grid col-12 mx-auto mt-4">
						<button class="btn btn-outline-primary btn-lg" id="btn-edit" style="display: none!important;" type="button">Edit</button>
					</div>
					<div class="alert alert-warning alert-dismissible mt-4">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<h6><i class="icon bx bx-warning"></i> Alert!</h6>
						If you want to delete this partnership data, please contact developer, thank you. <br><br>

						or email : development@sinergy.co.id<br><br>

						Best Regards,<br>
						Tim Developer.
					</div>
					<!-- <a href="{{url('show_cuti')}}" class="btn btn-danger btn-block" id="btn-delete" type="button"><b>Delete</b></a> -->
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-8 col-xs-12">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li>
					<a class="nav-link active" href="#tab_1" data-bs-toggle="tab">Certification List</a>
				</li>
				<li><a class="nav-link" href="#tab_2" data-bs-toggle="tab">Proof of Partnership</a></li>
				<li><a class="nav-link" href="#tab_3" data-bs-toggle="tab">Target</a></li>
				<li><a class="nav-link" href="#tab_4" data-bs-toggle="tab">Log Activity</a></li>

				<!-- 	<li class="pull-right">
							<a href="#" class="dropdown-toggle" data-bs-toggle="dropdown"><i class="bx bx-gear"></i></a>
							<ul class="dropdown-menu">
								<li role="presentation"><a role="menuitem" tabindex="-1" href="#" id="btnAddCert"><i class="bx bx-plus"></i> Certification</a></li>
							</ul>
						</li> -->
			</ul>
			<div class="tab-content">
				<div class="tab-pane show active" id="tab_1">
					<div class="row mb-4">
						<div class="col-md-12">
							<a class="text-primary pull-right" id="btnAddCert" style="cursor:pointer;display: none;margin-right: 10px;"><i class="bx bx-plus"></i> &nbspCertification</a>
						</div>
					</div>
					<div class="divider">
					  <div class="divider-text"></div>
					</div>
					<div id="list-cert" style="margin-top:10px">
					</div>
				</div>

				<div class="tab-pane" id="tab_2">
					<div class="card card-solid">
						<div class="card-header with-border">
							<h6 class="card-header-title"><i class="bx bx-image"></i>&nbspCertificate Partner</h6>
							<div class="card-header-elements ms-auto">
								<a id="btnAddCertPartner" class="text-primary" style="cursor:pointer;display: none;text-align: right;"><i class="bx bx-plus"></i>&nbspCertificate Partner</a>
							</div>
						</div>

						<div class="card-body">
							<div class="post">
								<div class="row mb-4">
									<div class="col-md-8">
										<div class="img-preview">

										</div>
										<!-- <img class="img-responsive" style="border: 1px solid " id="img-preview" src="{{asset('image/logo_partnership/certificate_placeholder.png')}}" alt="Photo"> -->
									</div>
									<div class="paging col-md-4">
										<div class="row mb-4" style="margin-bottom: 10px;" id="idCertList">
										</div>
										<div id="pagination-container" class="text-center" style="margin-top: 10px;">
										</div>
									</div>
								</div>

								<div class="row">
									<!-- <span class="time pull-right"><i class="bx bx-clock-o"></i></span> -->
									<div class="col-md-12 timeline-body" style="margin-bottom:10px">
									</div>
									<div class="timeline-footer mt-4">

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab_3">
					<div class="row mb-4">
						<div class="col-md-12">
							<a class="text-primary" onclick="btnTarget('{{$data->id_partnership}}')" id="btnAddTarget"
								style="display: none;cursor:pointer;float: right;margin-right: 10px;"><i
									class="bx bx-plus"></i> &nbspTarget</a>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-md-12">
							<fieldset id="listTarget">
								<div class="card">
									<div class="card-body">
										<ul class="todo-list">
										</ul>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab_4">
					<div class="card">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered nowrap table-striped dataTable" id="tbLog"
									style="width: 100%" cellspacing="0">
									<thead>
										<tr>
											<th>No</th>
											<th>Activity</th>
											<th>Created at</th>
											<th>PIC</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	<!--Modal-->
	<div class="modal fade" id="modalAddCert" role="dialog">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
					<h6 class="modal-title">Add Engineer</h6>
				</div>
				<div class="modal-body">
					<form id="formAddCert">
						@csrf
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<input hidden type="" name="id_partnership" value="{{$data->id_partnership}}">
										<th>Certificate Level</th>
										<th>Certificate Name</th>
										<th>Expired Date</th>
										<th>Certificate</th>
										<th>Person</th>
										<td class="text-center">
											<button class="btn btn-xs btn-primary" onclick="addListCert()" type="button"
												style="border-radius:50%;width: 25px;height: 25px;">
												<i class="bx bx-plus"></i>
											</button>
										</td>
									</tr>
								</thead>
								<tbody id="tbListCert">
								</tbody>
							</table>
						</div>
					</form>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-primary" id="btnSubmitCert">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--Modal Cert Partner-->
	<div class="modal fade" id="modalAddCertPartner" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
					<h6 class="modal-title">Add Certificate Partner</h6>
				</div>
				<div class="modal-body">
					<form id="formAddCertPartner" enctype="multipart/form-data">
						@csrf
						<input type="text" class="form-control" name="idCertPartner" id="idCertPartner"
							value="{{$data->id_partnership}}" style="display: none;">

						<div class="form-group">
							<label>Title</label>
							<input type="text" class="form-control" name="inputTitleCert" id="inputTitleCert" d>
							<span class="help-block" style="display:none;">Please Fill Title!</span>
						</div>
						<div class="form-group">
							<label>Certificate File (image/jpg/png)</label>
							<input type="file" id="imgCertPartner" name="imgCertPartner" accept="image">
							<input type="file" id="imgCertPartner" name="imgCertPartner" style="display:none;">
							<span class="help-block" style="display:none;">Please Upload File Certificate!</span>
						</div>
					</form>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-primary" id="btnSubmitCertPartner">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	</section>
</div>
@endsection
@section('scriptImport')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
 <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/jquery.simplePagination.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.17/js/adminlte.min.js"></script>
@endsection
@section('script')
<script type="text/javascript">
	localStorage.setItem("status", "initial")
	$(document).ready(function () {
		// getDetail()

		// var list = [
		// 	{"name" : "Yuni","status":"done","value" : "checked"},
		// 	{"name" : "Triza","status":"","value" : ""},
		// 	{"name" : "Dinar","status":"done","value" : "checked"},
		// 	{"name" : "Faiqoh","status":"","value" : ""},
		// 	{"name" : "Rama","status":"done","value" : "checked"}
		// ]

		// var newAppend = ""

		// list = list.sort((a, b) => a.status.localeCompare(b.status))
		// // console.log(list)

		// list.forEach(function(data,index){
		// 	newAppend = newAppend + '<li class="' + data.status + '">'
		// 	newAppend = newAppend + '	<span class="handle">'
		// 	newAppend = newAppend + '		<i class="bx bx-dots-vertical"></i>'
		// 	newAppend = newAppend + '		<i class="bx bx-dots-vertical"></i>'
		// 	newAppend = newAppend + '	</span>'
		// 	newAppend = newAppend + '	<input type="checkcard" class="checked-'+ data.name + '">'
		// 	newAppend = newAppend + '	<span class="text">' + data.name + '</span>'
		// 	newAppend = newAppend + '	<small class="label label-danger"><i class="bx bx-clock-o"></i> 2 mins</small>'
		// 	newAppend = newAppend + '	<div class="tools">'
		// 	newAppend = newAppend + '		<i class="bx bx-edit"></i>'
		// 	newAppend = newAppend + '		<i class="bx bx-trash-o"></i>'
		// 	newAppend = newAppend + '	</div>'
		// 	newAppend = newAppend + '</li>'
		// })

		// $('.todo-list').append(newAppend)

		// $('.todo-list').sortable({
		// 	placeholder         : 'sort-highlight',
		// 	handle              : '.handle',
		// 	forcePlaceholderSize: true,
		// 	zIndex              : 999999
		// });

		// $('.todo-list').todoList({
		// 	onCheck  : function () {
		// 		window.console.log($(this), 'The element has been checked');
		// 	},
		// 	onUnCheck: function () {
		// 		window.console.log($(this), 'The element has been unchecked');
		// 	}
		// });

		// list.forEach(function(data,index){
		// 	if(data.status == "done"){
		// 		$(".checked-" + data.name).attr("checked","true")
		// 	}
		// })

		var accesable = @json($feature_item);
		accesable.forEach(function (item, index) {
			$("#" + item).show()

			if (!accesable.includes('listTarget')) {
				$("#listTarget").attr("disabled", true)
			}
		})
		showEngCert()
		showTargetList(accesable)
		showCertList()
		TagTechnology()
	})

	$("#tbLog").DataTable({
		"ajax": {
			"type": "GET",
			"url": "{{url('/partnership/getDataLog')}}",
			"data": {
				id_partnership: window.location.href.split("/")[4].split("#")[0]
			}
		},
		"columns": [{
				render: function (data, type, row, meta) {
					return ++meta.row
				}
			},
			{
				"data": "description"
			},
			{
				"data": "created_at"
			},
			{
				"data": "name"
			},
		],
	})

	$("#btn-edit").click(function () {
		if (localStorage.getItem("status") == "initial") {
			$("#btn-edit").removeClass("btn-primary").addClass("btn-warning").html("Save").css('font-weight',
				'bold')
			localStorage.setItem("status", "update");
			$(":input[type=date],:input[type=text][readonly='readonly']").attr("readonly", false)
			$("#type_edit").attr("disabled", false)
			$("#standarization_edit").attr("disabled", false);
			$("#technologyTag_edit").attr("disabled", false);
			$(":input[type=text]").focus()
			$(".avatar-edit").css("display", "block")
		} else {
			$("btn-edit").attr("onclick", btnUpdate())
		}
	})

	function TagTechnology() {
		$.ajax({
			url: "{{url('/project/getTechTag')}}",
			type: "GET",
			success: function (result) {
				var arr = result.results;
				var selectOption = [];
				var otherOption;

				var data = {
					id: '',
					text: 'Select Technology'
				};

				selectOption.push(data)
				$.each(arr, function (key, value) {
					selectOption.push(value)
				})

				$("#technologyTag_edit").select2({
					data: selectOption,
					multiple: true
				})

				var data = JSON.parse('@json($data)')
				var array = JSON.parse("[" + data.id_tech + "]");

				$("#technologyTag_edit").val(array).trigger("change")
			}
		})
	}

	function btnUpdate() {
		const fileupload = $('#imageUpload').prop('files')[0];

		var nama_file = $('#imageUpload').val();
		var formData = new FormData();

		if (nama_file != "" && fileupload != "") {
			formData.append('fileupload', fileupload);
			formData.append('nama_file', nama_file);
		}

		const badgeupload = $('#imageBadge').prop('files')[0];

		var nama_badge = $('#imageBadge').val();
		if (nama_badge != "" && badgeupload != "") {
			formData.append('badgeupload', badgeupload);
			formData.append('nama_badge', nama_badge);
		}

		formData.append('_token', "{{csrf_token()}}")
		formData.append('id_edit', $("#id_edit").val())
		formData.append('partner_edit', $("#partner_edit").val())
		formData.append('standarization_edit', $("#standarization_edit").val())
		formData.append('levelling_edit', $("#levelling_edit").val())
		formData.append('level_edit', $("#level_edit").val())
		formData.append('type_edit', $("#type_edit").val())
		formData.append('renewal_edit', $("#renewal_edit").val())
		formData.append('annual_edit', $("#annual_edit").val())
		formData.append('cam_edit', $("#cam_edit").val())
		formData.append('phone_edit', $("#phone_edit").val())
		formData.append('email_edit', $("#email_edit").val())
		formData.append('support_edit', $("#support_edit").val())
		formData.append('mitra_edit', $("#mitra_edit").val())
		formData.append('partner_portal_edit', $("#partner_portal_edit").val())
		formData.append('technologyTag_edit', JSON.stringify($("#technologyTag_edit").val()))

		Swal.fire({
			title: 'Update partnership detail',
			text: "Are you sure?",
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes',
			cancelButtonText: 'No',
		}).then((result) => {
			if (result.value) {
				Swal.fire({
					title: 'Please Wait..!',
					text: "It's updating..",
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
					url: "{{'/update_partnership'}}",
					type: 'POST',
					processData: false,
					contentType: false,
					// dataType: 'application/json',
					data: formData, // serializes the form's elements.
					success: function (data) {
						Swal.showLoading()
						Swal.fire(
							'Successfully!',
							'success'
						).then((result) => {
							if (result.value) {
								localStorage.setItem("status", "initial");
								$("#btn-edit").removeClass("btn-warning").addClass(
									"btn-primary").html("Edit").css('font-weight', 'bold')
								location.reload();
							}
						})
					}
				});
			}
		})
	}

	var i = 0;

	function addListCert() {
		i++;
		var append = ""
		append = append + "<tr class='new-list'>"
		append = append + " <td>"
		append = append + " <input data-value='" + i +
			"' name='cert_type[]' id='cert_type' class='form-control' type='text' placeholder='Ex: Engineer - Profesional'>"
		append = append + " </td>"
		append = append + " <td>"
		append = append + "<input data-value='" + i +
			"' name='cert_name[]' id='cert_name' class='form-control' type='text' placeholder='Ex: 350-401 ENCOR'>"
		append = append + " </td>"
		append = append + " <td>"
		append = append + "	<input data-value='" + i +
			"' name='expired_date[]' id='expired_date' class='form-control' type='date'>"
		append = append +
			"		<div class='checkcard'><label><input id='cbLifetimeAddCert' class='cbLifetimeAddCert' type='checkbox'>Check for Lifetime Date</label></div>"
		append = append + " </td>"
		append = append + " <td>"
		append = append + "		<input data-value='" + i +
			"' name='certificate_eng[]' id='certificate_eng' class='form-control' type='file'>"
		append = append + " </td>"
		append = append + " <td style='white-space: nowrap'>"
		append = append + " <select class='form-control select2-person' data-value='" + i +
			"' style='width: 100%!important' name='cert_person[]'></select> "
		append = append + " </td>"
		append = append + " <td class='text-center'>"
		append = append +
			" <button type='button' style='width: auto !important;' class='btn btn-danger btn-flat btn-trash-list'>"
		append = append + " <i class='bx bx-trash'></i>"
		append = append + " </button>"
		append = append + " </td>"
		append = append + "</tr>"

		$("#tbListCert").append(append)
		$.ajax({
			url: "{{url('/partnership/getUser')}}",
			type: "GET",
			success: function (result) {
				$(".select2-person[data-value='" + i + "']").select2({
					dropdownParent: $('#modalAddCert'),
					placeholder: "Select Person",
					data: result.data
				})
			}
		})
	}

	$(document).on('click', '.btn-trash-list', function () {
		$(this).closest("tr").remove();
	});

	function showEngCert() {
		append = ""
		$.ajax({
			url: "{{url('/partnership/getCert')}}",
			data: {
				id: "{{$data->id_partnership}}"
			},
			type: "GET",
			success: function (result) {
				var countable = 0
				$('#list-cert').empty("")
				append = append + "<div class='row mb-4'>"
				append = append + "<div class='col-md-12'>"
				$.each(result.data.cert_user, function (key, value) {
					countable++
					append = append + "<div>"
					append = append + ' <div class="card-header with-border">'
					append = append + '		<h2 class="card-title" style="font-size:20px;display:inline-block"><b>' + key +
						'</b></h6>'
					append = append + '		<div class="card-tools pull-right">'
					if (countable == 1) {
						var classIcon = "bx bx-chevron-down"
						var classHidden = "display:block"
					} else {
						var classIcon = "bx bx-chevron-up"
						var classHidden = "display:none"
					}
					append = append +
						'			<button type="button" class="btn btn-sm btn-primary btn-dropdown-toggle" data-widget="collapse"><i class="' +
						classIcon + '"></i>'
					append = append + '			</button>'
					append = append + '		</div>'
					append = append + '	</div>'

					append = append + '<div class="card-body" style="' + classHidden + '">'
					append = append + '	<div class="row mb-4">'
					$.each(value, function (key, data) {
						append = append + "<div class='col-md-6 mb-4'>"
						append = append + '<div class="card card-info">'
						append = append +
							'<div class="card-header with-border" style="height:100px">'
						append = append + '<h6 class="card-title">' + data.name_certification +
							'</h6>'
						append = append + '</div>'
						append = append + '<div class="card-body">'
						append = append + '<div style="float: left;width:150px">'
						append = append + '<span><b>' + data.name + '</b></span><br>'
						append = append + '<span><i>Exp date</i>:<br>' + data.expired_date +
							'</span>'
						// append = append + ''
						append = append + '</div>'
						append = append + '<div style="float: right;">'
						if (data.avatar != null) {
							append = append +
								' <img class="profile-user img-responsive img-circle" src="' +
								data.avatar +
								'" alt="" style="width: 100px;height:100px;position: relative;">'
						} else if (data.gambar != null && data.gambar != "-") {
							append = append +
								' <img class="profile-user img-responsive img-circle" src="{{ asset("image")}}/' +
								data.gambar +
								'" alt="" style="width: 100px;height:100px;position: relative;">'
						} else {
							append = append +
								' <img class="profile-user img-responsive" src="https://www.mycustomer.com/sites/all/modules/custom/sm_pp_user_profile/img/default-user.png" alt="" style="width: 100px;height:100px;position: relative;">'
						}
						append = append + '</div>'
						append = append + '</div>'

						append = append + '<div class="card-footer">'
						append = append + '<button value="' + data.id +
							'" class="btn btn-xs btn-danger pull-right margin-left btn-delete-eng" style="vertical-align: top; width: 60px;display:none"><i class="bx bx-trash"></i> Delete</button>'
						if(data.certification_link != null){
							append = append +
									'<a target="_blank" href="https://drive.google.com/uc?export=download&id=' +
									data.certification_link +

									'"><button class="btn btn-xs btn-info pull-left"><i class="bx bx-download"></i> Download</button></a>'
						}else{
							if (data.certificate != null) {
								append = append +
										'<a target="_blank" href="{{url("image/certificate_engineer/")}}/' +
										data.certificate +

										'"><button class="btn btn-xs btn-info pull-left"><i class="bx bx-download"></i> Download</button></a>'
							} else {
								append = append +
										'<button class="btn btn-xs btn-outline-secondary pull-left disabled" title="Certificate is Empty!"><i class="bx bx-download"></i> Download</button>'
							}
						}
						append = append +
							'<button class="btn btn-xs btn-primary pull-right btn-edit-eng" value="' +
							data.id + "," + data.name + "," + data.name_certification + "," +
							data.expired_date +

							'" name="edit_hurec" style="vertical-align: top; width: 60px;margin-right:10px;display:none"><i class="bx bx-pencil"></i> Edit</button>'
						append = append + '</div>'
						append = append + '</div>'
						append = append + "</div>"
					})
					append = append + '	</div>'
					append = append + '</div>'

					append = append + "</card>"
				})
				append = append + "</div>"
				append = append + "</div>"

				$("#list-cert").append(append)

				var accesable = @json($feature_item);
				accesable.forEach(function (item, index) {
					$("." + item).show()
				})

				$(".btn-edit-eng").click(function () {
					var name = this.value.split(",")[1]
					appendModal = ""
					appendModal = appendModal +
						'			<div class="modal fade" id="myModal" role="dialog">'
					appendModal = appendModal + '				<div class="modal-dialog modal-xl">'
					appendModal = appendModal + '					<div class="modal-content">'
					appendModal = appendModal + '				<div class="modal-header">'
					appendModal = appendModal + '          <h6>Edit Engineer Certificate</h6>'
					appendModal = appendModal + '       </div>'
					appendModal = appendModal + '   		<div class="modal-body">'
					appendModal = appendModal + '    		<input hidden id="id_cert_edit" value="' + this
						.value.split(",")[0] + '">'
					appendModal = appendModal + '				<table class="table">'
					appendModal = appendModal + '				<tr>'
					appendModal = appendModal + "					<td>"
					appendModal = appendModal + "						<label>Certification Name</label>"
					appendModal = appendModal +
						"						<textarea id='cert_name_edit' cols='50' rows='3' class='form-control' style='resize:horizontal;overflow:hidden' type='text' placeholder='Enter Certificate Type'></textarea>"
					appendModal = appendModal + " 				</td>"
					appendModal = appendModal + " 				<td>"
					appendModal = appendModal + "						<label>Person</label>"
					appendModal = appendModal +
						" 					<select class='form-control select2' id='cert_user_edit' style='width:100%!important'></select> "
					appendModal = appendModal + " 				</td>"
					appendModal = appendModal + " 				<td>"
					appendModal = appendModal + "						<label>Expired Date</label>"
					appendModal = appendModal +
						"<input class='form-control' type='date' id='exp_date_edit' />"
					appendModal = appendModal +
						"<div class='checkcard'><label><input id='cbLifetime' type='checkbox'>Check for Lifetime Date</label></div>"
					appendModal = appendModal + " 	</td>"
					appendModal = appendModal + " 	<td>"
					appendModal = appendModal + "		<label>Certificate</label>"
					appendModal = appendModal + " 	<input data-value='" + i +
						"' id='cert_eng_edit' class='form-control' type='file'>"
					appendModal = appendModal + " 	</td>"
					appendModal = appendModal + '				</tr>'
					appendModal = appendModal + '				</table>'
					appendModal = appendModal + '			<div class="modal-footer">'
					appendModal = appendModal +
						'		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>'
					appendModal = appendModal +
						'		<button type="button" class="btn btn-primary" onClick="btnEditcert()">Submit</button>'
					appendModal = appendModal + '	</div>'
					appendModal = appendModal + '        </div>'
					appendModal = appendModal + '       </div>'
					appendModal = appendModal + '   </div>'
					appendModal = appendModal + '</div>'
					//here you force modal to be open

					$("body").append(appendModal);
					if (this.value.split(",")[3] == 'Lifetime') {
						$("#exp_date_edit").prop("disabled", true)
						$("#exp_date_edit").val("")
						$("#cbLifetime").prop("checked", true)
					} else {
						$("#exp_date_edit").prop("disabled", false)
						$("#cbLifetime").prop("checked", false)
						$("#exp_date_edit").val(moment(this.value.split(",")[3]).format("YYYY-MM-DD"))
					}
					$.ajax({
						url: "{{url('/partnership/getUser')}}",
						type: "GET",
						success: function (result) {
							$("#cert_user_edit").select2({
								dropdownParent: $('#myModal'),
								placeholder: "Select Person",
								data: result.data
							})

							$("#cert_user_edit").val(name).trigger("change")
						}
					})
					$("#cert_name_edit").val(this.value.split(",")[2])
					$("#myModal").modal('show')
				})

				$('body').on('keyup', '#cert_name_edit', function () {
					this.style.height = "1px";
					this.style.height = (25 + this.scrollHeight) + "px";
				})

				$(".btn-delete-eng").click(function () {
					Swal.fire({
						title: 'Delete Certificate User',
						text: "Are you sure?",
						icon: 'question',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Yes',
						cancelButtonText: 'No',
					}).then((result) => {
						if (result.value) {
							Swal.fire({
								title: 'Please Wait..!',
								text: "It's updating..",
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
								url: "{{url('/partnership/deleteCertPerson')}}",
								type: 'post',
								data: {
									"_token": "{{ csrf_token() }}",
									id: this.value
								},
								success: function (data) {
									Swal.showLoading()
									Swal.fire(
										'Successfully!',
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
				})

				$(".btn-dropdown-toggle").click(function () {
					if ($(this).closest("div").closest(".card-header").next().is(":visible")) {
						$(this).closest("div").closest(".card-header").next().attr('style','display:none!important')
						$(this).find("i").removeClass('bx bx-chevron-down').addClass(
							'bx bx-chevron-up')
					} else {
						$(this).closest("div").closest(".card-header").next().show()
						$(this).find("i").removeClass('bx bx-chevron-up').addClass(
							'bx bx-chevron-down')
					}
				})
			}
		})
	}

	var lifetimaDate = ''
	$('body').on('click', '#cbLifetime', function () {
		if ($('#cbLifetime').is(':checked')) {
			$("#exp_date_edit").prop("disabled", true)
			lifetimaDate = true
		} else {
			$("#exp_date_edit").prop("disabled", false)
			lifetimaDate = false
		}
	})

	function btnEditcert() {
		let formData = new FormData();

		const fileupload = $('#cert_eng_edit').prop('files')[0];
		var nama_file = $('#cert_eng_edit').val();
		if (nama_file != "" && fileupload != "") {
			formData.append('cert_eng_edit', fileupload);
			formData.append('nama_file', nama_file);
		}

		formData.append("_token", "{{ csrf_token() }}")
		formData.append("id_cert_edit", $("#id_cert_edit").val())
		formData.append("cert_name_edit", $("#cert_name_edit").val())
		formData.append("cert_user_edit", $("#cert_user_edit").val())
		if (lifetimaDate == true) {
			formData.append("cert_exp_date", "Lifetime")
		} else {
			formData.append("cert_exp_date", $("#exp_date_edit").val())
		}

		Swal.fire({
			title: 'Update Certification User',
			text: "Are you sure?",
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes',
			cancelButtonText: 'No',
		}).then((result) => {
			if (result.value) {
				Swal.fire({
					title: 'Please Wait..!',
					text: "It's updating..",
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
					url: "{{'/partnership/updateCertPerson'}}",
					type: 'post',
					data: formData,
					processData: false,
					contentType: false,
					success: function (data) {
						Swal.showLoading()
						Swal.fire(
							'Successfully!',
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

	function showTargetList(accesable) {
		var appendList = ""
		$.ajax({
			type: "GET",
			url: "{{url('/partnership/getTargetPartnership')}}",
			data: {
				id_partnership: window.location.href.split("/")[4].split("#")[0],
			},
			success: function (result) {
				$('.todo-list').empty("")
				$.each(result.data, function (key, value) {
					if (value.status == 'Done') {
						status = 'done'
					} else {
						status = ''
					}

					appendList = appendList + '<li class="' + status + ' delete-' + key + '">'
					appendList = appendList + '	<span class="handle">'
					appendList = appendList + '		<i class="bx bx-dots-vertical"></i>'
					appendList = appendList + '	</span>'
					appendList = appendList + '	<input id="cbTarget" type="checkbox" class="checked-' + key +
						'" data-value="' + value.id + '">'
					appendList = appendList + '	<span class="text" id="textList" data-value=' + key +
						'>' + value.target + ' - ' + value.countable + '</span>'
					appendList = appendList + ' <small class="badge text-bg-warning status-' + key +
						'">' + value.status + '</small>'
					appendList = appendList + '	<div id="targetTools" style="float:right" class="tools activeTrash-' +
						key + '">'
					appendList = appendList + '	<i class="bx bx-edit text-warning" onClick="editTarget(' + value
						.id + ')"></i>'
					appendList = appendList + '		<i class="bx bx-trash text-danger" onClick="deleteTarget(' +
						key + ',' + value.id + ')"></i>'
					appendList = appendList + '	</div>'
					appendList = appendList + '</li>'
				})
				$('.todo-list').append(appendList)

				$.each(result.data, function (key, value) {
					if (value.status == "Done") {
						$(".checked-" + key).attr("checked", "true")
						$(".checked-" + key).prop("disabled", true)
						$(".activeTrash-" + key).attr('style','display:none!important')
					} else {
						if (accesable.includes('targetTools')) {
							$(".activeTrash-" + key).show()
						} else {
							$(".activeTrash-" + key).attr('style','display:none!important')
						}
					}

					$('.todo-list').todoList({
						onCheck: function () {
							$.ajax({
								type: "POST",
								url: "{{url('/partnership/updateStatusTarget')}}",
								data: {
									_token: "{{csrf_token()}}",
									id: $(this).data('value')
								}
							})
							$(".checked-" + key).prop("disabled", true)
							$(".activeTrash-" + key).attr('style','display:none!important')
							$("small.status-" + key).text("Done")

						},
						onUnCheck: function () {
						}
					});

					cbTargetChecked(key)
				})

				$('.todo-list').sortable({
					placeholder: 'sort-highlight',
					handle: '.handle',
					forcePlaceholderSize: true,
					zIndex: 999999
				});

			},
		})
	}

	function editTarget(id) {
		var id_target = ''
		var targetValue = []
		var targetValue2 = []
		$.ajax({
			type: "GET",
			url: "{{url('/partnership/getTargetById')}}",
			data: {
				id: id,
			},
			success: function (result) {
				id_target = result.data.id
				Swal.fire({
					title: "Update Target",
					html: '<h6 style="float:left">Target:</h6><input id="target_sales" value="' +
						result.data.target +
						'" placeholder="[Renewal] Cisco Gold Partner" class="swal2-input">' +
						'<h6 style="float:left">Countable:</h6><input id="countable_target" value="' +
						result.data.countable +
						'" placeholder="USD 2.00 or 4 Specialist" class="swal2-input">',
					focusConfirm: false,
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'SUBMIT',
					cancelButtonText: 'CANCEL',
					preConfirm: () => {
						targetValue.push(document.getElementById('target_sales').value),
							targetValue2.push(document.getElementById('countable_target').value)
					},
				}).then((result) => {
					if (result.value) {
						Swal.fire({
							title: 'Please Wait..!',
							text: "It's updating..",
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
							type: "POST",
							url: "{{url('/partnership/updateTarget')}}",
							data: {
								_token: "{{csrf_token()}}",
								id: id_target,
								target: targetValue.splice("")[0],
								countable: targetValue2.splice("")[0],
							},
							success: function (result) {
								Swal.showLoading()
								Swal.fire(
									'Successfully!',
									'success'
								).then((result) => {
									showTargetList()
									// $("#listTarget").html(appendList)
								})
							},
						})
					}
				})
			}

		})
	}

	function deleteTarget(key, id) {
		$.ajax({
			type: "POST",
			url: "{{url('/partnership/deleteTarget')}}",
			data: {
				_token: "{{csrf_token()}}",
				id: id
			},
			success: function (result) {
				$('.delete-' + key).remove()
			},
		})
	}

	function cbTargetChecked(key) {
		if ($(".checked-"+key).is(':checked')) {
			$("#textList[data-value='" + key + "']").css("text-decoration", "line-through");
			$("#cbTarget[data-value='" + key + "']").prop("disabled", true)

			// $("#liList[data-value='"+key+"']").prependTo($("#liList[data-value='"+key+"']").parent())
			$("#liList[data-value='" + key + "']").appendTo("#listTarget").addClass("todo-list ui-sortable")

		} else {
			$(this).closest("span").css("text-decoration", "none");

		}
	}

	function showCertList() {
		// $(".img-preview").html("<iframe frameborder='0' class='frame' style='border: 1px solid;' id='img-preview' src='{{asset('image/logo_partnership/certificate_placeholder.png')}}'></iframe>")
		$(".img-preview").html(
			"<div class='iframe-cont'><iframe id='img-preview' width='400' height='300' src='{{asset('image/logo_partnership/certificate_placeholder.png')}}' frameborder='0' allowfullscreen></iframe></div>"
		)
		appendCertList = ''
		$.ajax({
			type: "GET",
			url: "{{url('/partnership/getCertPartnership')}}",
			data: {
				id_partnership: window.location.href.split("/")[4].split("#")[0],
			},
			success: function (result) {
				$.each(result.data, function (key, value) {
					appendCertList = appendCertList + '<div class="col-sm-12 col-xs-12">'
					pdf = value.certificate
					if (pdf.split(".").pop() == "pdf") {
						appendCertList = appendCertList +
							'<iframe style="cursor: pointer;" width="150" height="100"  src="{{asset("image/cert_partnership")}}/' +
							value.certificate + '" alt="Photo"><button value="' + value.certificate +
							'"></iframe><button style="margin-right:5px" value="' + value.certificate +
							'" class="btn btn-xs btn-info" id="btnPreview"><i class="bx bx-search"></i> zoom</button>'
					} else {
						appendCertList = appendCertList +
							'<img style="cursor: pointer;width:100%;height:200px;" src="{{asset("image/cert_partnership")}}/' +
							value.certificate + '" alt="Photo"><button value="' + value.certificate +
							'" style="margin-top:5px;margin-right:5px" class="btn btn-xs btn-info" id="btnPreview"><i class="bx bx-search"></i> zoom</button>'
					}
					appendCertList = appendCertList + '<small hidden>' + value.title + '</small>'
					appendCertList = appendCertList + '<small hidden>' + value.id + '</small>'
					if (value.title.length > 20) {
						appendCertList = appendCertList + '<small>' + value.title.substr(0, 20) +
							'...</small>'
					} else {
						appendCertList = appendCertList + '<small>' + value.title + '</small>'
					}
					appendCertList = appendCertList + '</div>'
				})
				$("#idCertList").append(appendCertList)



				var items = $(".post .row .paging .row .col-sm-6");
				var numItems = items.length;
				var perPage = 2;

				items.slice(perPage).attr('style','display:none!important');

				$('#pagination-container').pagination({
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
			},
		})
	}



	$('body').on('click', '#btnPreview', function () {
		src = this.value
		$("#img-preview").attr("src", "{{asset('image/cert_partnership')}}/" + src)
		// $("#img-preview").attr("src",imgs);

		$(".timeline-body").html(
			"<div class='row'><div class='col-md-6'><textarea id='txEditTitle' disabled class='form-control'>" +
			$(this).next("small").text() + "</textarea></div></div>")
		$(".timeline-footer").html(
			"<a class='btn btn-sm text-bg-warning btn-flat' style='display:none' id='btnUpdateCert' onClick='btnUpdateCert(" +
			$(this).next("small").next("small").text() +
			")'>Update</a> <a class='btn btn-sm text-bg-danger btn-flat' style='display:none' id='btnDeleteCert' onClick='btnDelCert(" +
			$(this).next("small").next("small").text() + ")'>Delete</a>")
		var accesable = @json($feature_item);
		accesable.forEach(function (item, index) {
			$("#" + item).show()

			if (accesable.includes("txEditTitle")) {
				$("#txEditTitle").prop("disabled", false)
			}
		})
	})

	$("#btnAddCertPartner").click(function () {
		$("#modalAddCertPartner").modal("show")
	})

	function btnTarget(id_partnership) {
		var titleStatus = 'Next Target'
		targetValue = []
		targetValue2 = []
		targetStatus = "Not-Done"
		Swal.fire({
			title: titleStatus,
			html: '<h6 style="float:left">Target:</h6><input id="target_sales" placeholder="[Renewal] Cisco Gold Partner" class="swal2-input">' +
				'<h6 style="float:left">Countable:</h6><input id="countable_target" placeholder="USD 2.00 or 4 Specialist" class="swal2-input">',
			focusConfirm: false,
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'SUBMIT',
			cancelButtonText: 'CANCEL',
			preConfirm: () => {
				targetValue.push(document.getElementById('target_sales').value),
					targetValue2.push(document.getElementById('countable_target').value)
			},
		}).then((result) => {
			if (result.value) {
				Swal.fire({
					title: 'Please Wait..!',
					text: "It's updating..",
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
					type: "POST",
					url: "{{url('/partnership/store_target')}}",
					data: {
						_token: "{{csrf_token()}}",
						id_partnership: id_partnership,
						target: targetValue.splice("")[0],
						countable: targetValue2.splice("")[0],
						status: targetStatus,
					},
					success: function (result) {
						Swal.showLoading()
						Swal.fire(
							'Successfully!',
							'success'
						).then((result) => {
							showTargetList()
							// $("#listTarget").html(appendList)
						})
					},
				})
			}
		})
	}

	$(".cbTarget").click(function () {

	})

	$("#btnAddCert").click(function () {
		$("#modalAddCert").modal("show")
	})

	$('body').on('click', '#cbLifetimeAddCert', function () {
		if ($(this).is(':checked')) {
			$(this).closest("div").closest("td").find("input#expired_date").prop("readonly", true)
		} else {
			$(this).closest("div").closest("td").find("input#expired_date").prop("readonly", false)
		}
	})

	$("#btnSubmitCert").click(function () {
		// const fileupload = $('#certificate_eng').prop('files')[0];

		// var nama_file = $('#certificate_eng').val();
		let formData = new FormData();

		// if (nama_file!="" && fileupload!="") {
		// 	formData.append('certificate_eng', fileupload);
		//    	formData.append('nama_file', nama_file);
		// }

		var cert_eng = [],
			lifetimeArr = [],
			lifetime = ''
		if ($(".cbLifetimeAddCert").length > 1) {
			// $(".cbLifetimeAddCert").each(function(index,itemLifeTime){
			// 	if ($(itemLifeTime).is(':checked')) {
			//   			lifetimeArr.push("Lifetime")
			//   		}else{
			//   			lifetimeArr.push($(itemLifeTime).closest("div").closest("td").find("input#expired_date").val())
			//   		}
			//  	})

			$('#tbListCert .new-list').each(function (index, item) {
				if ($(item).find(".cbLifetimeAddCert") == true) {
					cert_eng.push({
						cert_type: $(item).find("#cert_type").val(),
						cert_name: $(item).find('#cert_name').val(),
						expired_date: "Lifetime",
						nama_file: $(item).find('#certificate_eng').val(),
						cert_person: $(item).find('.select2-person').val(),
						// certificate_eng:$(item).find('#certificate_eng').prop('files')[0],
					})
				} else {
					cert_eng.push({
						cert_type: $(item).find("#cert_type").val(),
						cert_name: $(item).find('#cert_name').val(),
						expired_date: $(item).find(".cbLifetimeAddCert").closest("div").closest(
							"td").find("input#expired_date").val(),
						nama_file: $(item).find('#certificate_eng').val(),
						cert_person: $(item).find('.select2-person').val(),
						// certificate_eng:$(this).find('#certificate_eng').prop('files')[0],
					})
				}
			});
		} else {
			if ($(".cbLifetimeAddCert").is(':checked')) {
				lifetime = "Lifetime"
			} else {
				lifetime = $(".cbLifetimeAddCert").closest("div").closest("td").find("input#expired_date").val()
			}

			$('#tbListCert .new-list').each(function (index, item) {
				cert_eng.push({
					cert_type: $(this).find("#cert_type").val(),
					cert_name: $(this).find('#cert_name').val(),
					expired_date: lifetime,
					nama_file: $(this).find('#certificate_eng').val(),
					cert_person: $(this).find('.select2-person').val(),
					// certificate_eng:$(this).find('#certificate_eng').prop('files')[0],
				})
			});
		}

		$('#tbListCert .new-list').each(function () {
			formData.append('imageData', $(this).find('#certificate_eng').prop('files')[0])
		});

		// var engData = {
		//   cert_eng:JSON.stringify(cert_eng),
		//   cert_image:cert_image
		// }

		formData.append('engData', JSON.stringify(cert_eng))
		// formData.append('cert_type', $("#cert_type").val());
		// formData.append('cert_name', $("#cert_name").val());
		// formData.append('expired_date', $("#expired_date").val());
		formData.append('_token', "{{csrf_token()}}")
		formData.append('id_partnership', window.location.href.split("/")[4].split("#")[0])
		// formData.append('cert_person',JSON.stringify($('#select2-person').val()))  

		Swal.fire({
			title: 'Add New Engineer',
			text: "Are you sure?",
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes',
			cancelButtonText: 'No',
		}).then((result) => {
			if (result.value) {
				Swal.fire({
					title: 'Please Wait..!',
					text: "It's updating..",
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
					url: "{{'/partnership/addCertList'}}",
					type: 'post',
					processData: false,
					contentType: false,
					data: formData, // serializes the form's elements.
					success: function (data) {
						Swal.showLoading()
						Swal.fire(
							'Successfully!',
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
	})

	$("#btnSubmitCertPartner").click(function () {
		const fileupload = $('#imgCertPartner').prop('files')[0];

		var nama_file = $('#imgCertPartner').val();
		let formData = new FormData();

		if (nama_file != "" && fileupload != "") {
			formData.append('imgCertPartner', fileupload);
			formData.append('nama_file', nama_file);
		}


		if ($("#inputTitleCert").val() == "") {
			$("#inputTitleCert").closest('.form-group').addClass('has-error')
			$("#inputTitleCert").closest('input').next('span').show();
			$("#inputTitleCert").prev('.input-group-addon').css("background-color", "red");
		} else if ($("#imgCertPartner").val() == "") {
			$("#imgCertPartner").closest('.form-group').addClass('has-error')
			$("#imgCertPartner").closest('input').next('span').show();
			$("#imgCertPartner").prev('.input-group-addon').css("background-color", "red");
		} else {
			formData.append('_token', "{{csrf_token()}}")
			formData.append('idCertPartner', $("#idCertPartner").val())
			formData.append('inputTitleCert', $("#inputTitleCert").val())

			Swal.fire({
				title: 'Add Certificate',
				text: "Are you sure?",
				icon: 'question',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes',
				cancelButtonText: 'No',
			}).then((result) => {
				if (result.value) {
					Swal.fire({
						title: 'Please Wait..!',
						text: "It's updating..",
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
						url: "{{'/partnership/addCert'}}",
						type: 'post',
						processData: false,
						contentType: false,
						data: formData, // serializes the form's elements.
						success: function (data) {
							Swal.showLoading()
							Swal.fire(
								'Successfully!',
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
	})

	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
				$('#imagePreview').attr('style','display:none!important');
				$('#imagePreview').fadeIn(650);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	$("#imageUpload").change(function () {
		readURL(this);
		$("#imageUpload").val()
	});

	function readBadgeURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#badgePreview').css('background-image', 'url(' + e.target.result + ')');
				$('#badgePreview').attr('style','display:none!important');
				$('#badgePreview').fadeIn(650);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	$("#imageBadge").change(function () {
		readBadgeURL(this);
		$("#imageBadge").val()
	});

	// $('body').on('click','.imgList',function(){
	// 	console.log("iframe")
	// 	var imgs = $(this).attr('src');
	//    var height = $(this).attr('height',$(this).height());
	//    var width = $(this).attr('width',$(this).width());
	//    $("#img-preview").attr({'src':imgs,'height': height,'width': width});
	// 	// $("#img-preview").attr("src",imgs);

	//    $(".timeline-body").html("<div class='row'><div class='col-md-6'><textarea id='txEditTitle' disabled class='form-control'>"+  $(this).next("small").text() +"</textarea></div></div>")
	//    $(".timeline-footer").html("<a class='btn btn-warning btn-flat btn-xs' style='display:none' id='btnUpdateCert' onClick='btnUpdateCert("+ $(this).next("small").next("small").text() +")'>Update</a> <a class='btn btn-danger btn-flat btn-xs' style='display:none' id='btnDeleteCert' onClick='btnDelCert("+ $(this).next("small").next("small").text()+")'>Delete</a>")
	//    var accesable = @json($feature_item);
	//    accesable.forEach(function(item,index){
	//      $("#" + item).show()

	//      if (accesable.includes("txEditTitle")) {
	//      	$("#txEditTitle").prop("disabled",false)
	//      }
	//    })
	// })

	function btnUpdateCert(id) {
		Swal.fire({
			title: 'Update Certificate Title',
			text: "Are you sure?",
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes',
			cancelButtonText: 'No',
		}).then((result) => {
			if (result.value) {
				Swal.fire({
					title: 'Please Wait..!',
					text: "It's updating..",
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
					type: "POST",
					url: "{{url('/partnership/updateTitleCert')}}",
					data: {
						_token: "{{csrf_token()}}",
						id: id,
						title: $("#txEditTitle").val()
					},
					success: function (data) {
						Swal.showLoading()
						Swal.fire(
							'Successfully!',
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

	function btnDelCert(id) {
		Swal.fire({
			title: 'Delete Certificate',
			text: "Are you sure?",
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes',
			cancelButtonText: 'No',
		}).then((result) => {
			if (result.value) {
				Swal.fire({
					title: 'Please Wait..!',
					text: "It's updating..",
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
					type: "POST",
					url: "{{url('/partnership/deleteCertPartner')}}",
					data: {
						_token: "{{csrf_token()}}",
						id: id
					},
					success: function (data) {
						Swal.showLoading()
						Swal.fire(
							'Successfully!',
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
</script>
@endsection