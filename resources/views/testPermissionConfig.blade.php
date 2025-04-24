@extends('template.main_sneat')
@section('tittle')
Permission Config
@endsection
@section('pageName')
Permission Configuration
@endsection
@section('head_css')
	<!-- Select2 -->
  	<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  	<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
	<style type="text/css">
		.text-lowercase{
			text-transform: lowercase;
		}

		.text-capitalize{
			text-transform: capitalize;
		}

		#permissionRoleToUser_wrapper .row:first-child, 
		#featureRoleTableCustom_wrapper .row:first-child, 
		#rolesTable_wrapper .row:first-child,
		#featureItemTable_wrapper .row:first-child, 
		#featureTable_wrapper .row:first-child {
			display: none
		}

		 /* The switch - the box around the slider */
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
			box-shadow: 0 0 1px #2196F3;
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
		tr.group,
		tr.group:hover {
			background-color: #ddd !important;
		}

		.form-group{
			margin-bottom: 15px;
		}
		
	</style>
@endsection
@section('content')
	<div class="container-xxl flex-grow-1 container-p-y">
		<section class="content">
			<div class="card">
				<div class="card-body">
				<div class="row mb-4">
					<div class="col-md-12">
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
								<li class="nav-item">
									<a class="nav-link active" href="#list_user" data-bs-toggle="tab" onclick="changeTab('list')">Role To User</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#list_fature" data-bs-toggle="tab" onclick="changeTab('list_fature')">Roles To Feature</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#cofig_role" data-bs-toggle="tab" onclick="changeTab('role')">Configure Role</a>
								</li>
								<li class="nav-item" id="tabFeature" style="display:none;">
									<a class="nav-link" href="#config_fature" data-bs-toggle="tab" onclick="changeTab('feature')">Configure Feature</a>
								</li>
								<li class="nav-item" id="tabFeatureroles" style="display:none;">
									<a class="nav-link" href="#config_fature_item" data-bs-toggle="tab" onclick="changeTab('feature_item')">Configure Feature Item</a>
								</li>
								{{-- <li class="pull-right"> --}}
									{{-- <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-add-role">Change User Role</button> --}}
									{{-- <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-add-feature">Change Feature Role</button> --}}
									{{-- <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal-config-role">Add Role</button> --}}
									{{-- <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal-config-feature">Add Feature</button> --}}
								{{-- </li> --}}
							</ul>
							<div class="tab-content">
								<div class="tab-pane show active" id="list_user">
									<div class="row mb-4">
										<dir class="col-md-8" style="margin-bottom: 0px; margin-top: 0px;">
											<button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-add-role">
												Change Role User
											</button>
										</dir>
										<dir class="col-md-4 text-right" style="margin-bottom: 0px; margin-top: 0px;">
											<div class="input-group pull-right">
												<input id="searchBarRoleUser" type="text" class="form-control" onkeyup="searchCustom('permissionRoleToUser','searchBarRoleUser')" placeholder="Search Anything">
												<button type="button" id="btnShowEntryRoleUser" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
													Show 10 entries
												</button>
												<ul class="dropdown-menu">
													<li><a class="dropdown-item" href="#" onclick="$('#permissionRoleToUser').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
													<li><a class="dropdown-item" href="#" onclick="$('#permissionRoleToUser').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
													<li><a class="dropdown-item" href="#" onclick="$('#permissionRoleToUser').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
													<li><a class="dropdown-item" href="#" onclick="$('#permissionRoleToUser').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
												</ul>
												<button onclick="searchCustom('permissionRoleToUser','searchBarRoleUser')" type="button" class="btn btn-sm btn-outline-secondary btn-sm">
													<i class="bx bx-fw bx-search"></i>
												</button>
											</div>
										</dir>
									</div>
									<div class="row mb-4">
										<dir class="col-md-12" style="margin-bottom: 0px; margin-top: 0px;">
											<table class="table table-bordered table-striped display" id="permissionRoleToUser" style="width: 100%"></table>
										</dir>
									</div>
								</div>
								<div class="tab-pane" id="list_fature">
									<div class="row mb-4">
										<dir class="col-md-8" style="margin-bottom: 0px; margin-top: 0px;">
											<button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-add-feature">
												Change Feature Role
											</button>
										</dir>
										<dir class="col-md-4 text-right" style="margin-bottom: 0px; margin-top: 0px;">
											<div class="input-group pull-right">
												<input id="searchBarRoleFeature" type="text" class="form-control" onkeyup="searchCustom('featureRoleTableCustom','searchBarRoleFeature')" placeholder="Search Anything">
												<button type="button" id="btnShowEntryRoleFeature" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
													Show 10 entries
												</button>
												<ul class="dropdown-menu">
													<li><a class="dropdown-item" href="#" onclick="$('#featureRoleTableCustom').DataTable().page.len(10).draw();$('#btnShowEntryRoleFeature').html('Show 10 entries')">10</a></li>
													<li><a class="dropdown-item" href="#" onclick="$('#featureRoleTableCustom').DataTable().page.len(25).draw();$('#btnShowEntryRoleFeature').html('Show 25 entries')">25</a></li>
													<li><a class="dropdown-item" href="#" onclick="$('#featureRoleTableCustom').DataTable().page.len(50).draw();$('#btnShowEntryRoleFeature').html('Show 50 entries')">50</a></li>
													<li><a class="dropdown-item" href="#" onclick="$('#featureRoleTableCustom').DataTable().page.len(100).draw();$('#btnShowEntryRoleFeature').html('Show 100 entries')">100</a></li>
												</ul>
												<button onclick="searchCustom('featureRoleTableCustom','searchBarRoleFeature')" type="button" class="btn btn-sm btn-outline-secondary btn-sm">
													<i class="bx bx-fw bx-search"></i>
												</button>
											</div>
										</dir>
									</div>
									<div class="row table-responsive no-padding">
										<dir class="col-md-12" style="margin-bottom: 0px; margin-top: 0px;">
											<table class="table table-bordered table-striped" id="featureRoleTableCustom" style="width: 100%"></table>
										</dir>
									</div>
								</div>
								<div class="tab-pane" id="cofig_role">
									<div class="row mb-4">
										<dir class="col-md-8" style="margin-bottom: 0px; margin-top: 0px;">
											<button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal-config-role">
												Add Role
											</button>
										</dir>
										<dir class="col-md-4 text-right" style="margin-bottom: 0px; margin-top: 0px;">
											<div class="input-group pull-right">
												<input id="searchBarRole" type="text" class="form-control" onkeyup="searchCustom('rolesTable','searchBarRole')" placeholder="Search Anything">
												<button type="button" id="btnShowEntryRole" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
													Show 10 entries
												</button>
												<ul class="dropdown-menu">
													<li><a class="dropdown-item" href="#" onclick="$('#rolesTable').DataTable().page.len(10).draw();$('#btnShowEntryRole').html('Show 10 entries')">10</a></li>
													<li><a class="dropdown-item" href="#" onclick="$('#rolesTable').DataTable().page.len(25).draw();$('#btnShowEntryRole').html('Show 25 entries')">25</a></li>
													<li><a class="dropdown-item" href="#" onclick="$('#rolesTable').DataTable().page.len(50).draw();$('#btnShowEntryRole').html('Show 50 entries')">50</a></li>
													<li><a class="dropdown-item" href="#" onclick="$('#rolesTable').DataTable().page.len(100).draw();$('#btnShowEntryRole').html('Show 100 entries')">100</a></li>
												</ul>
												<button onclick="searchCustom('rolesTable','searchBarRole')" type="button" class="btn btn-sm btn-outline-secondary btn-sm">
													<i class="bx bx-fw bx-search"></i>
												</button>
											</div>
										</dir>
									</div>
									<div class="row mb-4">
										<dir class="col-md-12" style="margin-bottom: 0px; margin-top: 0px;">
											<table class="table table-bordered table-striped display" id="rolesTable" style="width: 100%"></table>
										</dir>
									</div>
								</div>
								<div class="tab-pane" id="config_fature">
									<div class="row mb-4">
										<dir class="col-md-8" style="margin-bottom: 0px; margin-top: 0px;">
											<button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal-config-feature">
												Add Feature
											</button>
										</dir>
										<dir class="col-md-4 text-right" style="margin-bottom: 0px; margin-top: 0px;">
											<div class="input-group pull-right">
												<input id="searchBarFeature" type="text" class="form-control" onkeyup="searchCustom('featureTable','searchBarFeature')" placeholder="Search Anything">
												<button type="button" id="btnShowEntryFeature" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
													Show 10 entries
												</button>
												<ul class="dropdown-menu">
													<li><a class="dropdown-item" href="#" onclick="$('#featureTable').DataTable().page.len(10).draw();$('#btnShowEntryFeature').html('Show 10 entries')">10</a></li>
													<li><a class="dropdown-item" href="#" onclick="$('#featureTable').DataTable().page.len(25).draw();$('#btnShowEntryFeature').html('Show 25 entries')">25</a></li>
													<li><a class="dropdown-item" href="#" onclick="$('#featureTable').DataTable().page.len(50).draw();$('#btnShowEntryFeature').html('Show 50 entries')">50</a></li>
													<li><a class="dropdown-item" href="#" onclick="$('#featureTable').DataTable().page.len(100).draw();$('#btnShowEntryFeature').html('Show 100 entries')">100</a></li>
												</ul>
												<button onclick="searchCustom('featureTable','searchBarFeature')" type="button" class="btn btn-sm btn-outline-secondary btn-sm">
													<i class="bx bx-fw bx-search"></i>
												</button>
											</div>
										</dir>
									</div>
									<div class="row mb-4">
										<dir class="col-md-12" style="margin-bottom: 0px; margin-top: 0px;">
											{{-- <table class="table table-bordered table-striped display" id="rolesTable" style="width: 100%"></table> --}}
											<table class="table table-bordered table-striped display" id="featureTable" style="width: 100%"></table>
										</dir>
									</div>
								</div>
								<div class="tab-pane" id="config_fature_item">
									<div class="row mb-4">
										<dir class="col-md-8 d-flex gap-2">
											<button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal-config-feature-item">
												<i class="bx bx-plus"></i>
											</button>
											<select class="form-control" id="filterByRoleGroup"><option></option></select>
											<select class="form-control" id="filterByFeature"></select>
										</dir>
										<dir class="col-md-4 text-right" style=" margin-top: 0px;">
											<div class="input-group pull-right">
												<input id="searchBarFeatureItem" type="text" class="form-control" onkeyup="searchCustom('featureItemTable','searchBarFeatureItem')" placeholder="Search Anything">
												<button type="button" id="btnShowEntryFeatureItem" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
													Show 10 entries
												</button>
												<ul class="dropdown-menu">
													<li><a class="dropdown-item" href="#" onclick="$('#featureItemTable').DataTable().page.len(10).draw();$('#btnShowEntryFeatureItem').html('Show 10 entries')">10</a></li>
													<li><a class="dropdown-item" href="#" onclick="$('#featureItemTable').DataTable().page.len(25).draw();$('#btnShowEntryFeatureItem').html('Show 25 entries')">25</a></li>
													<li><a class="dropdown-item" href="#" onclick="$('#featureItemTable').DataTable().page.len(50).draw();$('#btnShowEntryFeatureItem').html('Show 50 entries')">50</a></li>
													<li><a class="dropdown-item" href="#" onclick="$('#featureItemTable').DataTable().page.len(100).draw();$('#btnShowEntryFeatureItem').html('Show 100 entries')">100</a></li>
												</ul>
												<button onclick="searchCustom('featureItemTable','searchBarFeatureItem')" type="button" class="btn btn-sm btn-outline-secondary btn-sm">
													<i class="bx bx-fw bx-search"></i>
												</button>
											</div>
										</dir>
									</div>
									<div class="row mb-4">
										<div class="col-md-12 table-responsive">
											<table class="table table-bordered table-striped" id="featureItemTable" style="width: 100%"></table>
											{{-- <table class="table table-bordered" style="width: 100%">
												<tr>
													<th>Feature</th>
													<th>Item</th>
													<th class="text-center">Director</th>
													<th class="text-center">Manager</th>
													<th class="text-center">Admin</th>
													<th class="text-center">Staff</th>
												</tr>
												<tr>
													<td rowspan="5" style="vertical-align: middle;">Presence</td>
													<td>Checkin</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox" id="checkbox1"><span class="slider round"></span></label>
													</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
												</tr>
												<tr>
													<td>Checkout</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
												</tr>
												<tr>
													<td>Personal History</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
												</tr>
												<tr>
													<td>Team History</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
												</tr>
												<tr>
													<td>Reporting</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
													<td class="text-center">
														<label class="switch"><input type="checkbox"><span class="slider round"></span></label>
													</td>
												</tr>
											</table> --}}

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>	
			</div>
		</section>
	</div>

	<div class="modal fade" id="modal-add-role">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></span>
					</button>
					<h6 class="modal-title">Change Role User</h6>
				</div>
				<div class="modal-body">
					<p>To change role you must set name and role corenspondance</p>
					<div class="form-group">
						<label>Name</label>
						<select class="form-control select2" id="selectUser" style="width: 100%;"></select>
					</div>
					<div class="form-group">
						<label>Roles</label>
						<select class="form-control select2" id="selectRole" style="width: 100%;" multiple="multiple"></select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="setRoles()">Create</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-config-role">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></span>
					</button>
					<h6 class="modal-title">Add New Role</h6>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Name</label>
						<input type="" name="" class="form-control text-capitalize" id="name-config">
					</div>
					<div class="form-group">
						<label>Slug</label>
						<input type="" name="" class="form-control text-lowercase" id="slug-config">
					</div>
					<div class="form-group">
						<label>Group</label>
						<input type="" name="" class="form-control" id="group-config">
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea class="form-control" id="description-config"></textarea>
					</div>					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="addConfigRoles()">Create</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-edit-config-feature">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></span>
					</button>
					<h6 class="modal-title">Edit Feature</h6>
				</div>
				<div class="modal-body">
					<input type="" name="" id="id-feature-edit" hidden="">
					<div class="form-group">
						<label>Name</label>
						<input type="" name="" class="form-control text-capitalize" id="name-feature-edit" disabled placeholder="ex: 'Presence Personal'">
					</div>
					<div class="form-group">
						<label>Group</label>
						<input type="" name="" class="form-control" id="group-feature-edit" disabled placeholder="ex: 'Presence'">
					</div>
					<div class="form-group">
						<label>Url</label>
						<input type="" name="" class="form-control text-lowercase" disabled id="url-feature-edit" placeholder="ex: 'presence/personal'">
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea class="form-control" id="description-feature-edit" disabled placeholder="ex: Digunakan untuk absen personal"></textarea>
					</div>
					<div class="form-group">
						<label>Icon</label>
						<select class="form-control" id="icon-feature-edit" style="width:100%!important" placeholder="ex: bx bx-pencil"><select/>
					</div>					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="editConfigFeature()">Create</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-config-feature-item">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></span>
					</button>
					<h6 class="modal-title">Add New Feature Item</h6>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Item ID</label>
						<input type="" name="" class="form-control" id="id-feature-item" placeholder="ex: 'btn_presnce_personal'">
					</div>
					<div class="form-group">
						<label>Group</label>
						<input type="" name="" class="form-control" id="group-feature-item" placeholder="ex: 'presence_personal'">
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea class="form-control" id="description-feature-item" placeholder="ex: Button presence personal"></textarea>
					</div>					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="addConfigFeatureItem()">Create</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-add-feature">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></span>
					</button>
					<h6 class="modal-title">Change Feature Role</h6>
				</div>
				<div class="modal-body">
					<p>To connect feature you must set role corenspondance</p>
					<div class="form-group">
						<label>Role</label>
						<select class="form-control select2" id="selectRoleFeature" style="width: 100%;"></select>
					</div>
					<div class="form-group">
						<label>Features</label>
						<select class="form-control select2" id="selectFeature" style="width: 100%;" multiple="multiple"></select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="setFeatures()">Create</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-edit-role"> 
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></span>
					</button>
					<h6 class="modal-title">Edit Role</h6>
				</div>
				<div class="modal-body">
					<p>In here there will be details for each role as well as the holder</p>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Name</label>
								<input class="form-control" id="editRoleName" style="width: 100%;">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Slug</label>
								<input class="form-control" id="editRoleSlug" style="width: 100%;">
							</div>
						</div>
					</div>
					<div>
						<div class="form-group">
							<label>Holder</label>
							<ul id="editRoleHolder">
							</ul>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary">Update</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-config-feature">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></span>
					</button>
					<h6 class="modal-title">Add New Feature</h6>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Name</label>
						<input type="" name="" class="form-control text-capitalize" id="name-feature" placeholder="ex: 'Presence Personal'">
					</div>
					<div class="form-group">
						<label>Group</label>
						<input type="" name="" class="form-control" id="group-feature" placeholder="ex: 'Presence'">
					</div>
					<div class="form-group">
						<label>Url</label>
						<input type="" name="" class="form-control text-lowercase" id="url-feature" placeholder="ex: 'presence/personal'">
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea class="form-control" id="description-feature" placeholder="ex: Digunakan untuk absen personal"></textarea>
					</div>
					<div class="form-group">
						<label>Icon</label>
						<select id="icon-feature" style="width:100%!important" class="form-control"></select>
						<!-- <input class="form-control" id="icon-feature" placeholder="ex: bx bx-pencil"/> -->
					</div>						
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="addConfigFeature()">Create</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-edit-config-feature">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h6 class="modal-title">Edit Feature</h6>
				</div>
				<div class="modal-body">
					<input type="" name="" id="id-feature-edit" hidden="">
					<div class="form-group">
						<label>Name</label>
						<input type="" name="" class="form-control text-capitalize" id="name-feature-edit" disabled placeholder="ex: 'Presence Personal'">
					</div>
					<div class="form-group">
						<label>Group</label>
						<input type="" name="" class="form-control" id="group-feature-edit" disabled placeholder="ex: 'Presence'">
					</div>
					<div class="form-group">
						<label>Url</label>
						<input type="" name="" class="form-control text-lowercase" disabled id="url-feature-edit" placeholder="ex: 'presence/personal'">
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea class="form-control" id="description-feature-edit" disabled placeholder="ex: Digunakan untuk absen personal"></textarea>
					</div>
					<div class="form-group">
						<label>Icon</label>
						<select class="form-control" id="icon-feature-edit" style="width:100%!important" placeholder="ex: bx bx-pencil"><select/>
					</div>					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary pull-left" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="editConfigFeature()">Create</button>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scriptImport')
	<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
	<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
@endsection
@section('script')
	<script>
		$(document).ready(function(){
			var accesable = @json($feature_item);
		    accesable.forEach(function(item,index){
		      $("#" + item).show()  
		    })
		})

		function changeTab(id){
			if (id == 'list') {
				$('#permissionRoleToUser').DataTable().ajax.url("{{url('permission/getUserList')}}").load();
			}else if (id == 'role') {
				$('#rolesTable').DataTable().ajax.url("{{url('permission/getRoles')}}").load();
			}else if (id == 'feature'){
				$('#permissionRoleToUser').DataTable().ajax.url("{{url('permission/getUserList')}}").load();
			}else{
				// $('#featureRoleTable').DataTable().ajax.url("{{url('permission/getUserList')}}").load();
			}
		}

		function searchCustom(id_table,id_seach_bar){
			$("#" + id_table).DataTable().search($('#' + id_seach_bar).val()).draw();
		}

		$('#permissionRoleToUser').DataTable({
			ajax: {
				url:"{{url('permission/getUserList')}}",
				dataSrc:function (json){
					if(json.permitted){
						json.data.forEach(function(value,idex){
							value.user_id = "<a href='" + '{{url("authLogin")}}'+ "/" + value.user_id + "'>" + value.user_id + "</a>"
						})
					} else {
						json.data.forEach(function(value,idex){
							value.user_id = "<b>" + value.user_id + "</b>"
						})
					}
					json = json.data
					return json
				}
			},
			columns: [
				{ 
					title: "NIK",
					data: "user_id"
				},
				{ 
					title: "Name",
					data: "name"
				},
				{ 
					title: "Group",
					data: "name_group" 
				},
				{ 
					title: "Role",
					data: "name_roles"
				}				
			],
			lengthChange: false
		});

		$('#rolesTable').DataTable( {
			ajax: {
				url:"{{url('permission/getRoles')}}",
				"dataSrc":""
			},
			columns: [
				{ 
					title: "Name",
					data: "name"
				},
				{ 
					title: "Slug",
					data: "slug"
				},
				{ 
					title: "Description",
					data: "description" 
				},
				{ 
					title: "Group",
					data: "group"
				},
				{
					class:"text-center",
					title: "Action",
					render: function ( data, type, row ) {
						return '<button class="btn btn-sm btn-sm btn-secondary" onclick="editRoles(' + row.id + ')">Edit</button>';
					}
				}
			]
		});

		$('#featureTable').DataTable( {
			ajax: {
				url:"{{url('permission/getFeature')}}",
				"dataSrc":""
			},
			columns: [
				{ 
					title: "Name",
					data: "name"
				},
				{ 
					title: "Group",
					data: "group"
				},
				{ 
					title: "Description",
					data: "description" 
				},
				{ 
					title: "Url",
					data: "url"
				},
				{
					class:"text-center",
					title: "Action",
					render: function ( data, type, row ) {
						return '<button class="btn btn-sm btn-sm btn-secondary" onclick="editFeature(' + row.id + ')">Edit</button>';
					}
				}
			]
		});
		var dataTableFeatureItem;
		var firstGroup = ""
		function getFeatureItemByRoleGroup(group){
			if(group != firstGroup){
				dataTableFeatureItem.destroy();
				$("#featureItemTable").empty();
			}
			$.ajax({
				type:"GET",
				url:"{{url('permission/getFeatureItem')}}",
				data:{
					group:group
				},
				beforeSend: function(){
					if($.fn.dataTable.isDataTable("#featureItemTable")){
						dataTableFeatureItem.destroy();
						$("#featureItemTable").empty();
					}
				},
				success:function(result){
					console.log(result.data.length)
					if (result.data.length == 0) {
						dataTableFeatureItem = $("#featureItemTable").DataTable({
							columns: [
							    { title: 'Feature' },
							    { title: 'Item' }
							]
						})
					}else{
						dataTableFeatureItem = $("#featureItemTable").DataTable({
							data: result.data,
							order: [[ 0, 'asc' ]],
							columns: result.column,
							paging: false,
							drawCallback: function ( settings ) {
								var api = this.api();
								var rows = api.rows( {page:'current'} ).nodes();
								var last = null;

								// console.log(api)

								api.column(0, {page:'current'} ).data().each( function ( group, i ) {
									if ( last !== group ) {
										var append = ''
										append = append + '<tr class="group">'
										append = append + '	<td colspan="' + (result.column.length + 1) + '">'
										append = append + '		<b>Feature : <i title="' + group + '">' + group + '</i></b>'
										append = append + '	</td>'
										append = append + '</tr>'
										$(rows).eq( i ).before(
											append
										);

										last = group;
									}
								});
							},
							pageLength:100,
							fixedHeader: true
							// columnDefs: [{
							// 	// The `data` parameter refers to the data for the cell (defined by the
							// 	// `data` option, which defaults to the column being worked with, in
							// 	// this case `data: 0`.
							// 	"render": function ( data, type, row ) {
							// 		return data +' ('+ row[3]+')';
							// 	},
							// 	"targets": 0
							// }]
						})
					}
					
				},
				complete:function(){
					$('.featureItemCheck').click(function() {
						var data = this.id
						changeFeatureItem(data.split("-")[0],data.split("-")[1])
					});
				}
			})	
		}

		function getFeatureItemByFeatureItem(group){
			if(group == "All"){
				$("#featureItemTable").DataTable().search("").draw();
			} else {
				$("#featureItemTable").DataTable().search(group).draw();
			}
		}

		select2Icon("icon-feature")

		function changeFeatureItem(role,feature){
			$.ajax({
				type:"GET",
				url:"permission/changeFeatureItem",
				data:{
					role:role,
					feature:feature
				},
				success:function(result){
					
				}
			})
		}

		$("#filterByRoleGroup").change(function(){
			console.log($("#filterByRoleGroup").val())
			getFeatureItemByRoleGroup($("#filterByRoleGroup").val())
		})
		

		

		$.ajax({
			type:"GET",
			url:"{{url('permission/getFeatureItemParameterByRoleGroup')}}",
			success:function(result){
				firstGroup = "All"
				console.log(firstGroup)
				$("#filterByRoleGroup").select2({
					placeholder: "Filter by Position",
					data:result,
					// dropdownParent:$("#modal-config-feature-item")
				})
			},
			complete:function(){
				getFeatureItemByRoleGroup("All")
			}

		})

		

		$("#filterByFeature").change(function(){
			console.log($("#filterByFeature").val())
			getFeatureItemByFeatureItem($("#filterByFeature").val())
		})
		

		$.ajax({
			type:"GET",
			url:"{{url('permission/getFeatureItemParameterByFeatureItem')}}",
			success:function(result){
				$("#filterByFeature").select2({
					placeholder: "Filter by Feature Item",
					data:result,
					// dropdownParent:$("#modal-config-feature-item")
				})
			}
		})

		// $("#featureItemTable").DataTable({
		// 	ajax: {
		// 		url:"{{url('permission/getFeatureItem')}}",
		// 		dataSrc:function(json){
		// 			// json.forEach(function(data,idex){
		// 			// 	data.director = '<label class="switch"><input type="checkbox" id="checkbox1"><span class="slider round"></span></label>'
		// 			// })
		// 			return json
		// 		}
		// 	},
		// 	columns: [
		// 		{
		// 			title: "Feature",
		// 			data: "group",
		// 			visible: false
		// 		},
		// 		{
		// 			title: "Item",
		// 			data: "item_id"
		// 		},
		// 		{
		// 			class:"text-center",
		// 			title: "Director",
		// 			data: "director"
		// 		},
		// 		{
		// 			class:"text-center",
		// 			title: "director", 
		// 			data:"director"
		// 		},
		// 		{
		// 			class:"text-center",
		// 			title: "staff", 
		// 			data:"staff"
		// 		},
		// 		{
		// 			class:"text-center",
		// 			title: "admin", 
		// 			data:"admin"
		// 		},
		// 		{
		// 			class:"text-center",
		// 			title: "hr.staff", 
		// 			data:"hrstaff"
		// 		},
		// 		{
		// 			class:"text-center",
		// 			title: "hr.ga", 
		// 			data:"hrga"
		// 		},
		// 		{
		// 			class:"text-center",
		// 			title: "pmo.staff", 
		// 			data:"pmostaff"
		// 		}
		// 	],
		// 	order: [[ 0, 'asc' ]],
		// 	drawCallback: function ( settings ) {
		// 		var api = this.api();
		// 		var rows = api.rows( {page:'current'} ).nodes();
		// 		var last = null;

		// 		api.column(0, {page:'current'} ).data().each( function ( group, i ) {
		// 			if ( last !== group ) {
		// 				$(rows).eq( i ).before(
		// 					'<tr class="group"><td colspan="8"><b>Feature : ' + group + '</b></td></tr>'
		// 				);

		// 				last = group;
		// 			}
		// 		} );
		// 	}
		// })

		$('#example tbody').on( 'click', 'tr.group', function () {
			var currentOrder = table.order()[0];
			if ( currentOrder[0] === 0 && currentOrder[1] === 'asc' ) {
				table.order( [ 0, 'desc' ] ).draw();
			}
			else {
				table.order( [ 0, 'asc' ] ).draw();
			}
		} );

		// $.ajax({
		// 	type:"GET",
		// 	url:"{{url('permission/getFeatureRole')}}",
		// 	success: function(result){
		// 		var append = "<tr>"
		// 		result.forEach(function(item,index){
		// 			append = append + "<th>" + item.name + "</th>"
		// 		})
		// 		append = append + "</tr>"
		// 		$("#featureRoleTableCustom").html(append)
		// 		console.log(result)
		// 	}
		// })

		$('#featureRoleTableCustom').DataTable( {
			ajax: {
				url:"{{url('permission/getFeatureRole')}}",
				"dataSrc":""
			},
			columns: [
				{ 
					title: "Role",
					data: "name_roles"
				},
				{ 
					title: "Group",
					data: "name_group" 
				},
				{ 
					title: "Features",
					data: "feature_name"
				}
			
			],
			lengthChange: false
		});

		$.ajax({
			type:"GET",
			url:"{{url('permission/getParameter')}}",
			success: function(result) {
				$("#selectUser").select2({
					data:result.name,
					dropdownParent:$("#modal-add-role")
				});
				$("#selectRole").select2({
					data:result.roles,
					dropdownParent:$("#modal-add-role")
				});

				// console.log(result.roles)
			}
		})

		$.ajax({
			type:"GET",
			url:"{{url('permission/getParameterRoles')}}",
			success:function(result){
				$("#selectRoleFeature").select2({
					data:result.roles,
					dropdownParent:$("#modal-add-feature")
				})

				$("#selectFeature").select2()
				
			}
		})

		$("#selectRoleFeature").on('select2:select', function (e) {
			var roles_id = e.params.data.id
			// console.log(e.params.data.id)
			$("#inputJobPic").prop("disabled", false)
			$.ajax({
				type:"GET",
				url: "{{url('permission/getParameterFeature')}}?roles_id=" + roles_id,
				success:function(result){
					$("#selectFeature").select2({
						data:result.features,
						dropdownParent:$("#modal-add-feature")
					})
				}
			})
		});


		function setRoles(){
			$.ajax({
				type:"GET",
				url:"{{url('permission/setRoles')}}",
				data:{
					id_user:$("#selectUser").val(),
					id_role:$("#selectRole").val(),
				},
				success: function(result) {
					// console.log(result)
					$("#modal-add-role").modal('hide')
				}
			})
		}

		function setFeatures(){
			$.ajax({
				type:"GET",
				url:"{{url('permission/setRolesFeature')}}",
				data:{
					id_role:$("#selectRoleFeature").val(),
					id_feature:$("#selectFeature").val(),
				},
				success: function(result) {
					// console.log(result)
					$("#modal-add-feature").modal('hide')
				}
			})
		}

		function addConfigRoles(){
			$.ajax({
				type:"GET",
				url:"{{url('permission/addConfigRoles')}}",
				data:{
					name:$("#name-config").val(),
					slug:$("#slug-config").val(),
					group:$("#group-config").val(),
					description:$("#description-config").val(),
				},
				success: function(result) {
					// console.log(result)
					$("#modal-config-role").modal('hide')
				}
			})
		}

		function addConfigFeature(){
			$.ajax({
				type:"GET",
				url:"{{url('permission/addConfigFeature')}}",
				data:{
					name:$("#name-feature").val(),
					url:$("#url-feature").val(),
					group:$("#group-feature").val(),
					description:$("#description-feature").val(),
					icon:$("#icon-feature").val()
				},
				success: function(result) {
					// console.log(result)
					$("#modal-config-feature").modal('hide')
				}
			})
		}

		function editConfigFeature(){
			$.ajax({
				type:"GET",
				url:"{{url('permission/addConfigFeature')}}",
				data:{
					id_feature:$("#id-feature-edit").val(),
					name:$("#name-feature-edit").val(),
					url:$("#url-feature-edit").val(),
					group:$("#group-feature-edit").val(),
					description:$("#description-feature-edit").val(),
					icon:$("#icon-feature-edit").val()
				},
				success: function(result) {
					// console.log(result)
					$("#modal-edit-config-feature").modal('hide')
				}
			})
		}

		function addConfigFeatureItem(){
			$.ajax({
				type:"GET",
				url:"{{url('permission/addConfigFeatureItem')}}",
				data:{
					item_id:$("#id-feature-item").val(),
					group:$("#group-feature-item").val(),
					description:$("#description-feature-item").val(),
				},
				success: function(result) {
					// console.log(result)
					$("#modal-config-feature-item").modal('hide')
				}
			})
		}

		function editRoles(id){
			$.ajax({
				type:"GET",
				url:"{{url('permission/getRoleDetail')}}",
				data:{
					id:id
				},
				success: function(result){
					$("#editRoleName").val(result.role.name)
					$("#editRoleSlug").val(result.role.slug)
					$("#editRoleHolder").empty()
					var append = ""
					result.holder.forEach(function(item,index){
						append = append + "<li>" + item.name + "</li>"
					})
					$("#editRoleHolder").append(append)
				},
				complete: function(){
					$("#modal-edit-role").modal('show')
				}
			})
		}

		function editFeature(id){
			$.ajax({
				type:"GET",
				url:"{{url('permission/getConfigFeature')}}",
				data:{
					id:id
				},
				success: function(result){
					select2Icon("icon-feature-edit")
					$.each(result,function(index,item){
						console.log(item.url)
						$("#id-feature-edit").val(item.id)
						$("#icon-feature-edit").val(item.icon_group).trigger('change')
						$("#description-feature-edit").val(item.description)
						$("#url-feature-edit").val(item.url)
						$("#group-feature-edit").val(item.group)
						$("#name-feature-edit").val(item.name)
					})
				},
				complete: function(){
					$("#modal-edit-config-feature").modal('show')
				}
			})
		}

		// $.ajax({
		// 	type:"GET",
		// 	dataType:"json",
		// 	url:"{{asset('/json/iconData.json')}}",
		// 	success: function(result){
		// 		console.log("hhhhh")
		// 		$('#icon-feature-edit').select2({
		// 	        data: result,
		// 	        escapeMarkup: function (markup) {
		// 	            return markup;
		// 	        }
		// 	    });

		// 	    $('#icon-feature').select2({
		// 	        data: result,
		// 	        escapeMarkup: function (markup) {
		// 	            return markup;
		// 	        }
		// 	    });
		// 	},
		// })

		function select2Icon(id){
			$.ajax({
				type:"GET",
				dataType:"json",
				url:"{{asset('public/json/iconData.json')}}",
				success: function(result){
					$('#'+id).select2({
				        data: result,
				        escapeMarkup: function (markup) {
				            return markup;
				        }
				    });
				},
			})
		}
		
	</script>
@endsection