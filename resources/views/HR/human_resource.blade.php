@extends('template.main_sneat')
@section('tittle')
Human Resources
@endsection
@section('pageName')
Employees
@endsection
@section('head_css')
	@php
	    use Illuminate\Support\Str;
	@endphp
  	<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  	<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
  	<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
	<style type="text/css">
	    .margin-left-custom-psw{
	      margin-left: 45px;
	    }
		.input-container {
		  display: -ms-flexbox; /* IE10 */
		  display: flex;
		  width: 100%;
		  margin-bottom: 15px;
		}

		.icon {
		  padding: 10px;
		  background: dodgerblue;
		  color: white;
		  min-width: 50px;
		  text-align: center;
		}

		.input-field {
		  width: 100%;
		  padding: 10px;
		  outline: none;
		}

		.input-field:focus {
		  border: 2px solid dodgerblue;
		}

		.current {
		  color: green;
		}

		#pagin li {
		  display: inline-block;
		}

		.prev {
		  cursor: pointer;
		}

		.next {
		  cursor: pointer;
		}

		.last{
		  cursor:pointer;
		  margin-left:5px;
		}

		.first{
		  cursor:pointer;
		  margin-right:5px;
		}

		.margin-left-custom2{
	    margin-left: 15px;
	    }
	    .margin-left-custom3{
	      margin-left: 17px;
	    }
	    hr.new4 {
	      border: 0.5px solid #007bff!important;
	      margin-top: 40px;
	    }

	    .zoom{
	    	padding: 50px;
	  		transition: transform .2s;
	  		margin: 0 auto;
	    }

	    .zoom:hover{
	    	-ms-transform: scale(1.5); /* IE 9 */
	  		-webkit-transform: scale(1.5); /* Safari 3-8 */
	  		transform: scale(1.5); 
	    }

	    .img-hover-zoom{
	    	overflow: hidden;
	    }

	    .select2{
		    width: 100%!important;
		}

		.dropbtn {
	      background-color: #f0ad4e;
	      color: white;
	      padding: 5px;
	      font-size: 13px;
	      width: 120px;
	      border: none;
	    }

	    /* The container <div> - needed to position the dropdown content */
	    .dropdown {
	      position: relative;
	      display: inline-block;
	    }

	    /* Dropdown Content (Hidden by Default) */
	    .dropdown-content {
	      display: none;
	      position: absolute;
	      background-color: #f1f1f1;
	      min-width: 120px;
	      card-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
	      z-index: 1;
	    }

	    /* Links inside the dropdown */
	    .dropdown-content a {
	      color: black;
	      padding: 12px 16px;
	      text-decoration: none;
	      display: block;
	    }

	    /* Change color of dropdown links on hover */
	    .dropdown-content a:hover {background-color: #ddd;}

	    /* Show the dropdown menu on hover */
	    .dropdown:hover .dropdown-content {display: block;}

	    /* Change the background color of the dropdown button when the dropdown content is shown */
	    .dropdown:hover .dropbtn {background-color: #f0ad4e;}

	    .pull-right{
	    	float: right;
	    }

	    .form-group{
	    	margin-bottom: 15px;
	    }

	    .nav-tabs-wrapper {
            overflow-x: auto;
            white-space: nowrap;
            display: flex;
            scroll-behavior: smooth;
            scrollbar-width: none; /* Hide scrollbar for Firefox */
        }

        .nav-tabs-wrapper::-webkit-scrollbar {
            display: none; /* Hide scrollbar for Chrome, Safari */
        }

        /* Shadowed Buttons */
        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.8);
            border: none;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .scroll-btn:hover {
            background: white;
        }

        .left-btn {
            left: 0;
        }

        .right-btn {
            right: 0;
        }

        /* Hide buttons initially */
        .scroll-btn.hidden {
            display: none;
        }

        .swal2-container {
		    z-index: 9999 !important;
		}
	</style>
@endsection
@section('content')
	<div class="container-xxl flex-grow-1 container-p-y">
		<section class="content">
			@if (session('update'))
			  <div class="alert alert-warning" id="alert">
			      {{ session('update') }}
			  </div>
			    @endif

			    @if (session('success'))
			  <div class="alert alert-success" id="alert">
			      {{ session('success') }}
			  </div>
			    @endif

			    @if (session('alert'))
			  <div class="alert alert-danger" id="alert">
			      {{ session('alert') }}
			  </div>
			@endif

			<div class="card">
				<div class="card-header with-border">
					<h6 class="card-title"><i class="bx bx-table"></i>&nbsp<b>SIP Employees</b></h6>
				</div>
			  <div class="card-body">
			    <div class="nav-tabs-custom" id="SIP" role="tabpanel" aria-labelledby="sip-tab">
			      <div class="row mb-4">
			      	<div class="col-md-12">
			      		<div class="pull-right" style="margin-right:10px">
			      			<!-- <a href="{{action('HRController@exportExcelEmployee')}}"><button class="btn btn-xs btn-warning" style=" margin-bottom: 5px;" id="btnExport"><i class="bx bx-print"></i> EXCEL </button></a> -->
			      			<button class="btnExport btn btn-sm btn-warning dropdown-toggle" data-bs-toggle="dropdown" id="btnExport" aria-haspopup="true" aria-expanded="false" style=" margin-bottom: 5px;"><i class="bx bx-print"> </i>&nbspExcel<span class="caret"></span></button>
				            <ul class="dropdown-menu">
							    <li><a class="dropdown-item" href="{{action('HRController@exportExcelEmployee')}}">All</a></li>
							    <li><a class="dropdown-item" href="{{action('HRController@exportExcelResignEmployee')}}">Resign</a></li>
							</ul>
				        	<button class="btn btn-xs btn-primary" onclick="showTabAdd(0)" id="btnAddEmployee" style="margin-bottom: 5px;display: none"><i class="bx bx-plus"></i>&nbsp Employee</button>
			      		</div>			        
				    </div>
			      </div>
			      
			      <button class="scroll-btn left-btn hidden" onclick="scrollTabs(-100)">&#9664;</button>
			      <div class="nav-tabs-wrapper" id="scrollableTabs">
			      	<ul class="nav nav-tabs" id="myTab" role="tablist">
				        <li class="nav-item active">
				          <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">ALL</a>
				        </li>
				        <li class="nav-item">
				          <a class="nav-link" id="management-tab" data-bs-toggle="tab" href="#management" role="tab" aria-controls="all" aria-selected="true">Management</a>
				        </li>
				        <li class="nav-item">
				          <a class="nav-link" id="ae1-tab" data-bs-toggle="tab" href="#ae1" role="tab" aria-controls="all" aria-selected="true">AE1</a>
				        </li>
				        <li class="nav-item">
				          <a class="nav-link" id="ae2-tab" data-bs-toggle="tab" href="#ae2" role="tab" aria-controls="all" aria-selected="true">AE2</a>
				        </li>
				        <li class="nav-item">
				          <a class="nav-link" id="ae3-tab" data-bs-toggle="tab" href="#ae3" role="tab" aria-controls="all" aria-selected="true">AE3</a>
				        </li>
				        @foreach ($group as $item)
						    <li class="nav-item">
						        <a class="nav-link" id="{{ Str::slug($item->acronym, '-') }}-tab" 
						           data-bs-toggle="tab" 
						           href="#{{ Str::slug($item->acronym, '-') }}" 
						           role="tab" 
						           aria-controls="{{ Str::slug($item->acronym, '-') }}" 
						           aria-selected="false">
						           {{ ($item->acronym) }}
						        </a>
						    </li>
						@endforeach
				        <li class="nav-item">
				          <a class="nav-link" id="resign-tab" data-bs-toggle="tab" href="#resign" role="tab" aria-controls="all" aria-selected="true">Resign</a>
				        </li>
				      </ul>
			      </div>
			      <button class="scroll-btn right-btn hidden" onclick="scrollTabs(100)">&#9654;</button>

			    <div class="tab-content" id="myTabContentSIP">
			        <div class="tab-pane show active" id="all" role="tabpanel" aria-labelledby="all-tab">
				        <div class="row mb-4">
				        	<div class="col-md-12">
				        		<div class="col-md-6 ms-auto pull-right">
				        			<div class="input-group">
					                    <input id="searchBarAll" type="text" class="form-control" onkeyup="searchCustom('data_all','searchBarAll')" placeholder="Search Anything">
					                      <button type="button" id="btnShowAll" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_all').DataTable().page.len(10).draw();$('#btnShowAll').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_all').DataTable().page.len(25).draw();$('#btnShowAll').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_all').DataTable().page.len(50).draw();$('#btnShowAll').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_all').DataTable().page.len(100).draw();$('#btnShowAll').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_all','searchBarAll')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
				        		
				        	</div>			        	
				        </div>			        	
			            <div class="table-responsive">		            	
			                <table class="table table-bordered table-striped dataTable" id="data_all" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Mulai Bekerja</th>
			                      <th hidden></th>
			                      <th>Lama Bekerja</th>
			                      <th>Status Karyawan</th>
			                      <th>KTP</th>
			                      <th>KK</th>
			                      <th>NPWP</th>
			                      <th>Attach File</th>
			                      <!-- <th>NPWP File</th> -->
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
				                    @if($data->id_company == '1')
				                    <tr>
				                      <td><?=str_replace('/', '', $data->nik)?></td>
				                      <td>{{ucwords(strtolower($data->name))}}</td>
				                      <td>{{$data->roles}}</td>
				                      <td>{{date('Y-m-d', strtotime($data->date_of_entry))}}</td>
				                      <td hidden>{{$data->date_of_entrys}}</td>
				                      <td>
				                      	@if($data->date_of_entrys > 365)
				                      		Masa kerja : {{floor($data->date_of_entrys / 365)}} Tahun {{floor($data->date_of_entrys % 365 / 30)}} Bulan
				                      	@elseif($data->date_of_entrys > 31)
				                      		Masa kerja : {{floor($data->date_of_entrys / 30)}} Bulan
				                      	@else
				                      		Masa kerja : {{floor($data->date_of_entrys)}} Hari 
				                      	@endif
				                      </td>
				                      <td>
				                      	@if($data->status_kerja == 'Tetap')
				                      	Karyawan Tetap 
				                      	@elseif($data->status_kerja == 'Kontrak')
				                      	Karyawan Kontrak
				                      	@elseif($data->status_kerja == 'Outsource')
				                      	Karyawan Outsource 
				                      	@else
				                      	-
				                      	<!-- <i class="bx bx-pencil modal_edit_status" style="color: #f39c12;cursor: pointer;"></i> -->
				                      	@endif
				                      </td>
				                      <td>
				                      	{{ $data->no_ktp }}
				                      </td>
				                      <td>
				                      	{{ $data->no_kk }}
				                      </td>
				                      <td>{{ $data->no_npwp }}</td>
				                      <td>
				                      	<button class="btn btn-xs btn-xs btn-primary btn-attach" value="{{$data->nik}}" name="edit_hurec" style="vertical-align: top;"><i class="bx bx-upload"></i>&nbspUpload</button>
				                      </td>
				                      <td>
				                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" id="btnEdit" data-value="0" value="{{$data->nik}}" name="edit_hurec" style="vertical-align: top;"><i class="bx bx-search"></i>&nbspEdit</button>
				                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
				                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
				                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
				                      </td>
				                    </tr>
				                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div> 
			        </div>
			        <div class="tab-pane" id="management" role="tabpanel" aria-labelledby="management-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
				        		<div class="col-md-6 ms-auto pull-right">
						        	<div class="input-group">
					                    <input id="searchManagement" type="text" class="form-control" onkeyup="searchCustom('data_sales','searchManagement')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_sales','searchManagement')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			             </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_sales" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
			                    @if(Str::contains($data->roles, ['VP', 'Chief']))
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>
			                        {{$data->roles}}
			                      </td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

			                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
			                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
			                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
			                      </td>
			                    </tr>
			                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			        <div class="tab-pane" id="ae1" role="tabpanel" aria-labelledby="ae1-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
				        		<div class="col-md-6 ms-auto pull-right">
						        	<div class="input-group">
					                    <input id="searchAe1" type="text" class="form-control" onkeyup="searchCustom('data_ae1','searchAe1')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_ae1','searchAe1')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			             </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_ae1" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
			                    @if($data->id_territory == 'TERRITORY 1' && $data->id_position != 'MANAGER')
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>
			                        {{$data->roles}}
			                      </td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

			                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
			                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
			                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
			                      </td>
			                    </tr>
			                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			        <div class="tab-pane" id="ae2" role="tabpanel" aria-labelledby="ae2-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
				        		<div class="col-md-6 ms-auto pull-right">
				        			<div class="input-group">
					                    <input id="searchAe2" type="text" class="form-control" onkeyup="searchCustom('data_ae2','searchAe2')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_ae2','searchAe2')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			             </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_ae2" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
			                    @if($data->id_territory == 'TERRITORY 2' && $data->id_position != 'MANAGER')
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>
			                        {{$data->roles}}
			                      </td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

			                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
			                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
			                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
			                      </td>
			                    </tr>
			                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			        <div class="tab-pane" id="ae3" role="tabpanel" aria-labelledby="ae3-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
				        		<div class="col-md-6 pull-right ms-auto">
				        			<div class="input-group">
					                    <input id="searchAe3" type="text" class="form-control" onkeyup="searchCustom('data_ae3','searchAe3')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_ae3','searchAe3')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			             </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_ae3" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
			                    @if($data->id_territory == 'TERRITORY 3' && $data->id_position != 'MANAGER')
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>
			                        {{$data->roles}}
			                      </td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

			                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
			                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
			                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
			                      </td>
			                    </tr>
			                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			        <div class="tab-pane" id="acc" role="tabpanel" aria-labelledby="acc-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
				        		<div class="col-md-6 pull-right ms-auto">
				        			<div class="input-group">
					                    <input id="searchAcc" type="text" class="form-control" onkeyup="ssearchCustom('data_acc','searchAcc')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_ae3','searchAe3')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			            </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_acc" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
			                    @if($data->mini_group == 'Accounting')
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>{{$data->roles}}</td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

			                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
			                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
			                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
			                      </td>
			                    </tr>
			                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			        <div class="tab-pane" id="fns" role="tabpanel" aria-labelledby="fns-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
				        		<div class="col-md-6 pull-right ms-auto">
				        			<div class="input-group">
					                    <input id="searchFns" type="text" class="form-control" onkeyup="searchCustom('data_fns','searchFns')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_ae3','searchAe3')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			            </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_fns" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
			                    @if($data->mini_group == 'Finance Support')
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>{{$data->roles}}</td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

			                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
			                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
			                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
			                      </td>
			                    </tr>
			                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			        <div class="tab-pane" id="sss" role="tabpanel" aria-labelledby="sss-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
					        	<div class="col-md-6 pull-right ms-auto">
				        			<div class="input-group">
					                    <input id="searchSss" type="text" class="form-control" onkeyup="searchCustom('data_sss','searchSss')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_ae3','searchAe3')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			            </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_sss" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
			                    @if($data->mini_group == 'Synergy System & Services')
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>{{$data->roles}}</td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

			                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
			                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
			                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
			                      </td>
			                    </tr>
			                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			        <div class="tab-pane" id="ssa" role="tabpanel" aria-labelledby="ssa-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
					        	<div class="col-md-6 pull-right ms-auto">
				        			<div class="input-group">
					                    <input id="searchSsa" type="text" class="form-control" onkeyup="searchCustom('data_ssa','searchSsa')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_ae3','searchAe3')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			            </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_ssa" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
			                    @if($data->mini_group == 'Synergy System Architecture')
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>{{$data->roles}}</td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

			                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
			                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
			                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
			                      </td>
			                    </tr>
			                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			        <div class="tab-pane" id="ssd" role="tabpanel" aria-labelledby="ssd-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
					        	<div class="col-md-6 pull-right ms-auto">
				        			<div class="input-group">
					                    <input id="searchSsd" type="text" class="form-control" onkeyup="searchCustom('data_ssd','searchSsd')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_ae3','searchAe3')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			            </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_ssd" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
			                    @if($data->mini_group == 'Synergy System Delivery')
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>{{$data->roles}}</td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

			                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
			                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
			                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
			                      </td>
			                    </tr>
			                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			        <div class="tab-pane" id="sci" role="tabpanel" aria-labelledby="sci-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
					        	<div class="col-md-6 ms-auto pull-right">
						        	<div class="input-group">
					                    <input id="searchSci" type="text" class="form-control" onkeyup="searchCustom('data_sci','searchSci')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_ae1','searchAe1')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			            </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_sci" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
			                    @if($data->mini_group == 'Supply Chain & IT Support')
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>{{$data->roles}}</td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

			                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
			                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
			                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
			                      </td>
			                    </tr>
			                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			        <div class="tab-pane" id="ios" role="tabpanel" aria-labelledby="ios-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
					        	<div class="col-md-6 ms-auto pull-right">
						        	<div class="input-group">
					                    <input id="searchIos" type="text" class="form-control" onkeyup="searchCustom('data_ios','searchIos')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_ae1','searchAe1')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			            </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_ios" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
			                    @if($data->mini_group == 'Internal Operation Support')
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>{{$data->roles}}</td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

			                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
			                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
			                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
			                      </td>
			                    </tr>
			                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			        <div class="tab-pane" id="ads" role="tabpanel" aria-labelledby="ads-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
					        	<div class="col-md-6 ms-auto pull-right">
						        	<div class="input-group">
					                    <input id="searchAds" type="text" class="form-control" onkeyup="searchCustom('data_ads','searchAds')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_ae1','searchAe1')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			            </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_ads" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
			                    @if($data->mini_group == 'Application Development Specialist')
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>{{$data->roles}}</td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

			                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
			                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
			                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
			                      </td>
			                    </tr>
			                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			        <div class="tab-pane" id="pds" role="tabpanel" aria-labelledby="pds-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
					        	<div class="col-md-6 ms-auto pull-right">
						        	<div class="input-group">
					                    <input id="searchPds" type="text" class="form-control" onkeyup="searchCustom('data_pds','searchPds')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_ae1','searchAe1')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			            </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_pds" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
			                    @if($data->mini_group == 'Product Development Specialist')
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>{{$data->roles}}</td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

			                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
			                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
			                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
			                      </td>
			                    </tr>
			                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			        <div class="tab-pane" id="pmo" role="tabpanel" aria-labelledby="pmo-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
					        	<div class="col-md-6 ms-auto pull-right">
						        	<div class="input-group">
					                    <input id="searchPmo" type="text" class="form-control" onkeyup="searchCustom('data_pmo','searchPmo')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_ae1','searchAe1')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			            </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_pmo" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
			                    @if($data->mini_group == 'Project Management Office')
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>{{$data->roles}}</td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

			                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
			                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
			                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
			                      </td>
			                    </tr>
			                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			        <div class="tab-pane" id="sdc" role="tabpanel" aria-labelledby="sdc-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
					        	<div class="col-md-6 ms-auto pull-right">
						        	<div class="input-group">
					                    <input id="searchSdc" type="text" class="form-control" onkeyup="searchCustom('data_sdc','searchSdc')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_ae1','searchAe1')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			            </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_sdc" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
			                    @if($data->mini_group == 'Service Desk Center')
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>{{$data->roles}}</td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

			                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
			                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
			                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
			                      </td>
			                    </tr>
			                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			        <div class="tab-pane" id="opd" role="tabpanel" aria-labelledby="opd-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
					        	<div class="col-md-6 ms-auto pull-right">
						        	<div class="input-group">
					                    <input id="searchOpd" type="text" class="form-control" onkeyup="searchCustom('data_opd','searchOpd')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_ae1','searchAe1')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			            </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_opd" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
			                    @if($data->mini_group == 'Organizational & People Development')
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>
			                         {{$data->roles}}
			                      </td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>
			                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
			                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
			                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
			                      </td>
			                    </tr>
			                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			        <div class="tab-pane" id="pos" role="tabpanel" aria-labelledby="pos-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
					        	<div class="col-md-6 ms-auto pull-right">
						        	<div class="input-group">
					                    <input id="searchPos" type="text" class="form-control" onkeyup="searchCustom('data_pos','searchPos')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_ae1','searchAe1')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			            </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_pos" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($hr as $data)
			                    @if($data->mini_group == 'People Operations & Services')
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>
			                         {{$data->roles}}
			                      </td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary" onclick="showEditTab(this.value,0)" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>
			                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
			                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
			                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
			                      </td>
			                    </tr>
			                    @endif
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			        <div class="tab-pane" id="resign" role="tabpanel" aria-labelledby="resign-tab">
			        	<div class="row mb-4">
				        	<div class="col-md-12">
					        	<div class="col-md-6 pull-right ms-auto">
				        			<div class="input-group">
					                    <input id="searchResign" type="text" class="form-control" onkeyup="searchCustom('data_resign','searchResign')" placeholder="Search Anything">
					                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					                        Show 10 entries
					                      </button>
					                      <ul class="dropdown-menu">
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
					                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
					                      </ul>
					                      <button onclick="searchCustom('data_ae3','searchAe3')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
					                        <i class="bx bx-fw bx-search"></i>
					                      </button>
				                  	</div>
				        		</div>
			                </div>
			            </div>
			            <div class="table-responsive">
			                <table class="table table-bordered table-striped dataTable" id="data_resign" width="100%" cellspacing="0">
			                  <thead>
			                    <tr>
			                      <th>NIK</th>
			                      <th>Employees Name</th>
			                      <th>Position</th>
			                      <th>Action</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    @foreach($data_resign as $data)
			                    <tr>
			                      <td><?=str_replace('/', '', $data->nik)?></td>
			                      <td>{{ucwords(strtolower($data->name))}}</td>
			                      <td>
			                         {{$data->roles}}
			                      </td>
			                      <td>
			                        <button class="btn btn-xs btn-xs btn-primary"  onclick="showEditTab(this.value,0)" value="{{$data->nik}}"><i class="bx bx-search"></i>&nbspShow</button>
			                      </td>
			                    </tr>
			                    @endforeach
			                  </tbody>
			                </table>
			            </div>
			        </div>
			    </div>

			    </div>
			  </div>
			</div>

			@if(Auth::User()->id_division == 'FINANCE' || Auth::User()->id_division == 'HR')
			@else
			<div class="card">
			  <div class="card-header with-border">
			    <h6 class="card-title"><i class="bx bx-table"></i>&nbsp<b>MSP Employees</b></h6>
			  </div>

			  <div class="card-body">
			  	<div class="row mb-4">
			  		<div class="col-md-12">
			  			<div class="nav-tabs-custom">
			  				<ul class="nav nav-tabs" id="myTabs" role="tablist">
						        <li class="nav-item active">
						          <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all-msp" role="tab" aria-controls="all" aria-selected="true">ALL</a>
						        </li>
						        <li class="nav-item">
						          <a class="nav-link" id="sales-tab" data-bs-toggle="tab" href="#sales-msp" role="tab" aria-controls="sales" aria-selected="false">SALES</a>
						        </li>
						        <li class="nav-item">
						          <a class="nav-link" id="operation-tab" data-bs-toggle="tab" href="#operation-msp" role="tab" aria-controls="operation" aria-selected="false">OPERATION</a>
						        </li>
						        <li class="nav-item">
						          <a class="nav-link" id="hr-tab" data-bs-toggle="tab" href="#warehouse-msp" role="tab" aria-controls="hr" aria-selected="false">WAREHOUSE</a>
						        </li>
						        <li class="nav-item">
						          <a class="nav-link" id="resign-tab" data-bs-toggle="tab" href="#resign-msp" role="tab" aria-controls="resign" aria-selected="false">RESIGN</a>
						        </li>
						    </ul>

						    <div class="tab-content" id="myTabContentMSP">
						    	<div class="tab-pane show active" id="all-msp" role="tabpanel" aria-labelledby="all-tab">
						    		<div class="row mb-4">
				        				<div class="col-md-12">
								    		<div class="col-md-6 ms-auto pull-right">
									        	<div class="input-group">
								                    <input id="searchALLMSP" type="text" class="form-control" onkeyup="searchCustom('data_all_msp','searchALLMSP')" placeholder="Search Anything">
								                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
								                        Show 10 entries
								                      </button>
								                      <ul class="dropdown-menu">
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
								                      </ul>
								                      <button onclick="searchCustom('data_ae1','searchAe1')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
								                        <i class="bx bx-fw bx-search"></i>
								                      </button>
							                  	</div>
							        		</div>
						                </div>
						            </div>
						            <div class="table-responsive">
						                <table class="table table-bordered table-striped dataTable" id="data_all_msp" width="100%" cellspacing="0">
						                  <thead>
						                    <tr>
						                      <th>NIK</th>
						                      <th>Employees Name</th>
						                      <th>Position</th>
						                      <th>Mulai Bekerja</th>
						                      <th>Status Karyawan</th>
						                      <th>KTP</th>
						                      <th>KK</th>
						                      <th>NPWP</th>
						                      <th>Attach File</th>
						                      <!-- <th>NPWP File</th> -->
						                      <th>Action</th>
						                    </tr>
						                  </thead>
						                  <tbody>
						                    @foreach($hr_msp as $data)
							                    <tr>
							                      <td><?=str_replace('/', '', $data->nik)?></td>
							                      <td>{{ucwords(strtolower($data->name))}}</td>
							                      @if($data->id_position != '')
							                      <td>{{$data->id_division}} {{$data->id_position}}</td>
							                      @else
							                      <td>&#8212</td>
							                      @endif
							                      <td>{{date('Y-m-d', strtotime($data->date_of_entry))}}</td>
							                      <td>
							                      	@if($data->status_kerja == 'Tetap')
							                      	Karyawan Tetap 
							                      	@elseif($data->status_kerja == 'Kontrak')
							                      	Karyawan Kontrak 
							                      	@elseif($data->status_kerja == 'Outsource')
				                      				Karyawan Outsource
							                      	@else
							                      	-
							                      	@endif
							                      </td>
							                      <td>
							                      	{{ $data->no_ktp }}
							                      </td>
							                      <td>
							                      	{{ $data->no_kk }}
							                      </td>
							                      <td>{{ $data->no_npwp }}</td>
							                      <td>
							                      	<button class="btn btn-xs btn-xs btn-primary btn-attach" value="{{$data->nik}}" name="edit_hurec" style="vertical-align: top;"><i class="bx bx-upload"></i>&nbspUpload</button>
							                      </td>

							                      <!-- <td><img src="{{ asset('image/'.$data->npwp_file) }}" style="max-height:200px;max-width:200px;margin-top:10px;"></td> -->
							                      <td>
							                        <button class="btn btn-xs btn-xs btn-primary btn-editan" onclick="showEditTab(this.value,0)"  id="btnEdit" value="{{$data->nik}}" name="edit_hurec" style="vertical-align: top;"><i class="bx bx-search"></i>&nbspEdit</button>

							                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
							                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
							                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
							                      </td>
							                    </tr>
						                    @endforeach
						                  </tbody>
						                </table>
						            </div> 
						        </div>
						        <div class="tab-pane" id="sales-msp" role="tabpanel" aria-labelledby="sales-tab">
						        	<div class="row mb-4">
				        				<div class="col-md-12">
								        	<div class="col-md-6 ms-auto pull-right">
									        	<div class="input-group">
								                    <input id="searchSalesMsp" type="text" class="form-control" onkeyup="searchCustom('data_sales_msp','searchSalesMsp')" placeholder="Search Anything">
								                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
								                        Show 10 entries
								                      </button>
								                      <ul class="dropdown-menu">
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
								                      </ul>
								                      <button onclick="searchCustom('data_ae1','searchAe1')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
								                        <i class="bx bx-fw bx-search"></i>
								                      </button>
							                  	</div>
							        		</div>
						                </div>
						            </div>
						            <div class="table-responsive">
						                <table class="table table-bordered table-striped dataTable" id="data_sales_msp" width="100%" cellspacing="0">
						                  <thead>
						                    <tr>
						                      <th>NIK</th>
						                      <th>Employees Name</th>
						                      <th>Position</th>
						                      <th>Action</th>
						                    </tr>
						                  </thead>
						                  <tbody>
						                    @foreach($hr_msp as $data)
						                    @if($data->id_territory == 'SALES MSP')
						                    <tr>
						                      <td><?=str_replace('/', '', $data->nik)?></td>
						                      <td>{{ucwords(strtolower($data->name))}}</td>
						                      @if($data->id_position != '')
						                      <td>
						                        {{$data->id_position}}
						                      </td>
						                      @else
						                      <td>&#8212</td>
						                      @endif
						                      <td>
						                        <button class="btn btn-xs btn-xs btn-primary btn-editan" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

						                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
						                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
						                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
						                      </td>
						                    </tr>
						                    @endif
						                    @endforeach
						                  </tbody>
						                </table>
						            </div>
						        </div>
						        <div class="tab-pane" id="operation-msp" role="tabpanel" aria-labelledby="operation-tab">
						        	<div class="row mb-4">
				        				<div class="col-md-12">
								        	<div class="col-md-6 ms-auto pull-right">
									        	<div class="input-group">
								                    <input id="searchOPMSP" type="text" class="form-control" onkeyup="searchCustom('data_op_msp','searchOPMSP')" placeholder="Search Anything">
								                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
								                        Show 10 entries
								                      </button>
								                      <ul class="dropdown-menu">
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
								                      </ul>
								                      <button onclick="searchCustom('data_ae1','searchAe1')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
								                        <i class="bx bx-fw bx-search"></i>
								                      </button>
							                  	</div>
							        		</div>
						                </div>
						            </div>
						            <div class="table-responsive">
						                <table class="table table-bordered table-striped dataTable" id="data_op_msp" width="100%" cellspacing="0">
						                  <thead>
						                    <tr>
						                      <th>NIK</th>
						                      <th>Employees Name</th>
						                      <th>Position</th>
						                      <th>Action</th>
						                    </tr>
						                  </thead>
						                  <tbody>
						                    @foreach($hr_msp as $data)
							                    @if($data->id_division == 'PMO' || $data->id_division == 'TECHNICAL')
							                    <tr>
							                      <td><?=str_replace('/', '', $data->nik)?></td>
							                      <td>{{ucwords(strtolower($data->name))}}</td>
							                      @if($data->id_position != '')
							                      <td>
							                       {{$data->id_position}}
							                      </td>
							                      @else
							                      <td>&#8212</td>
							                      @endif
							                      <td>
							                        <button class="btn btn-xs btn-xs btn-primary btn-editan" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

							                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
							                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
							                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
							                      </td>
							                    </tr>
							                    @endif
						                    @endforeach
						                  </tbody>
						                </table>
						            </div>
						        </div>
						        <div class="tab-pane" id="warehouse-msp" role="tabpanel" aria-labelledby="warehouse-tab">
						        	<div class="row mb-4">
				        				<div class="col-md-12">
								        	<div class="col-md-6 ms-auto pull-right">
									        	<div class="input-group">
								                    <input id="searchWarehouseMsp" type="text" class="form-control" onkeyup="searchCustom('data_warehouse_msp','searchWarehouseMsp')" placeholder="Search Anything">
								                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
								                        Show 10 entries
								                      </button>
								                      <ul class="dropdown-menu">
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
								                      </ul>
								                      <button onclick="searchCustom('data_ae1','searchAe1')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
								                        <i class="bx bx-fw bx-search"></i>
								                      </button>
							                  	</div>
							        		</div>
						                </div>
						            </div>
						            <div class="table-responsive">
						                <table class="table table-bordered table-striped dataTable" id="data_warehouse_msp" width="100%" cellspacing="0">
						                  <thead>
						                    <tr>
						                      <th>NIK</th>
						                      <th>Employees Name</th>
						                      <th>Position</th>
						                      <th>Action</th>
						                    </tr>
						                  </thead>
						                  <tbody>
						                    @foreach($hr_msp as $data)
						                    @if($data->id_division == '-')
						                    <tr>
						                      <td><?=str_replace('/', '', $data->nik)?></td>
						                      <td>{{ucwords(strtolower($data->name))}}</td>
						                      @if($data->id_position != '')
						                      <td>
						                         {{$data->id_position}}
						                      </td>
						                      @else
						                      <td>&#8212</td>
						                      @endif
						                      <td>
						                        <!-- <button class="btn btn-xs btn-xs btn-primary btn-editan" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button> -->

						                        <button class="btn btn-xs btn-xs btn-primary btn-editan" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspEdit</button>

						                        <a href="{{ url('delete_hr', $data->nik) }}"><button class="btn btn-xs btn-xs btn-danger" style="vertical-align: top;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
						                        <i class="bx bx-trash"></i>&nbspDelete</button></a>
						                        <button class="btn btn-xs btn-xs btn-warning btnReset" id="btnReset" value="{{$data->nik}}" name="btnReset" style="vertical-align: top;"><i class="bx bx-refresh"></i>&nbspReset</button>
						                      </td>
						                    </tr>
						                    @endif
						                    @endforeach
						                  </tbody>
						                </table>
						            </div>
						        </div>
						        <div class="tab-pane" id="resign-msp" role="tabpanel" aria-labelledby="resign-tab">
							       	<div class="row mb-4">
				        				<div class="col-md-12">
								        	<div class="col-md-6 ms-auto pull-right">
									        	<div class="input-group">
								                    <input id="searchResignMSP" type="text" class="form-control" onkeyup="searchCustom('data_resign_msp','searchResignMSP')" placeholder="Search Anything">
								                      <button type="button" id="btnShowEntryRoleUser" class="btn btn-xs btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
								                        Show 10 entries
								                      </button>
								                      <ul class="dropdown-menu">
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(10).draw();$('#btnShowEntryRoleUser').html('Show 10 entries')">10</a></li>
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(25).draw();$('#btnShowEntryRoleUser').html('Show 25 entries')">25</a></li>
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(50).draw();$('#btnShowEntryRoleUser').html('Show 50 entries')">50</a></li>
								                        <li><a class="dropdown-item" href="#" onclick="$('#data_sales').DataTable().page.len(100).draw();$('#btnShowEntryRoleUser').html('Show 100 entries')">100</a></li>
								                      </ul>
								                      <button onclick="searchCustom('data_ae1','searchAe1')" type="button" class="btn btn-xs btn-outline-secondary btn-flat">
								                        <i class="bx bx-fw bx-search"></i>
								                      </button>
							                  	</div>
							        		</div>
						                </div>
						            </div>
						            <div class="table-responsive">
						                <table class="table table-bordered table-striped dataTable" id="data_resign_msp" width="100%" cellspacing="0">
						                  <thead>
						                    <tr>
						                      <th>NIK</th>
						                      <th>Employees Name</th>
						                      <th>Position</th>
						                      <th>Action</th>
						                    </tr>
						                  </thead>
						                  <tbody>
						                    @foreach($data_resign_msp as $data)
						                    <tr>
						                      <td><?=str_replace('/', '', $data->nik)?></td>
						                      <td>{{ucwords(strtolower($data->name))}}</td>
						                      @if($data->id_position != '')
						                      <td>
						                         {{$data->id_position}}
						                      </td>
						                      @else
						                      <td>&#8212</td>
						                      @endif
						                      <td>
						                        <button class="btn btn-xs btn-xs btn-primary btn-editan2" value="{{$data->nik}}" name="edit_hurec"><i class="bx bx-search"></i>&nbspShow</button>
						                      </td>
						                    </tr>
						                    @endforeach
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
			@endif

			<div class="modal fade" id="modalAdd" role="dialog">
			    <div class="modal-dialog modal-md">
			      <!-- Modal content-->
			      <div class="modal-content modal-md">
			        <div class="modal-header">
			        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          				</button>
			          	<h6 class="modal-title">Add Employees</h6>
			        </div>
			        <div class="modal-body">
			        	<form class="form-horizontal" id="formAdd">
		                @csrf

		                <div class="tab-add" style="display: none;">
		                	<div class="form-group row">
			                    <label class="col-md-4 control-label">{{ __('Employees Name') }}</label>

			                    <div class="col-md-8">
			                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

			                        @if ($errors->has('name'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('name') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="email" class="col-md-4 control-label">{{ __('E-Mail Address') }}</label>

			                    <div class="col-md-8">
			                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

			                        @if ($errors->has('email'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('email') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="email_personal" class="col-md-4 control-label">{{ __('Personal E-Mail') }}</label>

			                    <div class="col-md-8">
			                        <input id="email_personal" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email_personal" value="{{ old('email') }}" required>

			                        @if ($errors->has('email'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('email') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="password" class="col-md-4 control-label">{{ __('Password') }}</label>

			                    <div class="col-md-8">
			                        <div class="input-group">
			                        	<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} float-left" name="password" required>
				                        <span class="input-group-addon">
				                        	<i toggle="#password-field" class="bx bx-fw fa-eye  toggle-password"></i>
				                        </span>
				                        @if ($errors->has('password'))
				                            <span class="invalid-feedback">
				                                <strong>{{ $errors->first('password') }}</strong>
				                            </span>
				                        @endif
			                        </div>

			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="password-confirm" class="col-md-4 control-label">{{ __('Confirm Password') }}</label>

			                    <div class="col-md-8">
			                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="tempat_lahir" class="col-md-4 control-label">{{ __('Place of Birth') }}</label>

			                    <div class="col-md-8">
			                        <input id="tempat_lahir" type="text" class="form-control" name="tempat_lahir" value="{{ old('tempat_lahir') }}" autofocus>
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="date_of_birth" class="col-md-4 control-label">{{ __('Date Of Birth') }}</label>

			                    <div class="col-md-8">
			                        <input id="date_of_birth" type="date" class="form-control{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" name="date_of_birth" value="{{ old('date_of_birth') }}" onkeyup="copytextbox();" required autofocus>

			                        @if ($errors->has('date_of_birth'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('date_of_birth') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="jenis_kelamin" style="padding-top: 7px;" class="col-md-4 control-label">{{ __('Gender') }}</label>
			                    <div class="col-md-8 form-group" style="padding-left: 28px; padding-top: 7px">
			                    	<div class="form-check">
									  <label class="form-check-label" for="flexRadioDefault1"><input class="form-check-input" type="radio" name="jenis_kelamin" id="flexRadioDefault1" value="Pria">Male</label>
									  
									  <label class="form-check-label" for="flexRadioDefault2"><input class="form-check-input" type="radio" name="jenis_kelamin" style="margin-left: 25px;" id="flexRadioDefault2"  value="Wanita">Female</label>
									</div>
			                    </div>
			                </div>		                
		                </div>

		                <div class="tab-add" style="display: none;">
		                	<div class="form-group row">
			                    <label for="address" class="col-md-4 control-label">{{ __('Residence Address') }}</label>

			                    <div class="col-md-8">
			                        <textarea id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address') }}" autofocus></textarea>

			                        @if ($errors->has('address'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('address') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="address_ktp" class="col-md-4 control-label">{{ __('ID Address') }}</label>

			                    <div class="col-md-8">
			                        <textarea id="address_ktp" rows="5" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address_ktp" value="{{ old('address_ktp') }}" autofocus></textarea>

			                        @if ($errors->has('address'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('address') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="phone_number" class="col-md-4 control-label">{{ __('Phone Number') }}</label>

			                    <div class="col-md-8">
			                        <input id="phone_number" type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number') }}" autofocus>

			                        @if ($errors->has('phone_number'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('phone_number') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

		                	<div class="form-group row">
		                   		<label for="company" class="col-md-4 control-label">{{ __('Company') }}</label>

			                    <div class="col-md-8">
			                        <select id="company" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" name="company" value="{{ old('company') }}" onkeyup="copytextbox();" required autofocus>
			                            <option value="">-- Select Company --</option>
			                            <option value="1" data-target="sip" id="1">SIP</option>
			                            <option value="2" data-target="msp" id="2">MSP</option>
			                        </select>
			                        @if ($errors->has('company'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('company') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <!--SIP-->

			                <div class="form-group row"  style="display:none;"  id="company-sip">
			                    <label for="division" class="col-md-4 control-label margin-bottom" style="margin-bottom: 15px;">{{ __('Division') }}</label>

			                    <div class="col-md-8 margin-bottom">
			                        <select id="division" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="division_sip" value="{{ old('division') }}" autofocus>
			                            <option value="">-- Select division --</option>
			                            <!-- <option value="TECHNICAL" data-target="technical" id="technical">TECHNICAL</option> -->
			                            <option value="FINANCE" data-target="finance" id="finance">FINANCE and ACCOUNTING</option>
			                            <option value="HR" data-target="hr" id="hr">HUMAN RESOURCE</option>
			                            <option value="SALES" data-target="sales" id="sales">SALES</option>
			                            <option value="OPERATION" data-target="operation" id="operation">OPERATION</option>
			                            <!-- <option value="BCD" data-target="bcd" id="bcd">BUSINESS CHANNEL DEVELOPEMNT</option> -->
			                            <!-- <option value="SPECIALIST" data-target="specialist" id="specialist">OTHER</option> -->
			                            <option value="NULL" data-target="director" id="director">NONE</option>
			                        </select>
			                        @if ($errors->has('division'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('division') }}</strong>
			                            </span>
			                        @endif
			                    </div>

			                    <label for="roles_user" class="col-md-4 control-label margin-top">{{ __('Roles') }}</label>

			                    <div class="col-md-8 margin-top">
			                        <select id="roles_user" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="roles_user" value="{{ old('division') }}" autofocus>
			                            <option value="">-- Select Roles --</option>
			                            @foreach($roles as $data)
			                            <option value="{{$data->id}}">{{$data->name}}</option>
			                            @endforeach
			                        </select>
			                    </div>
			                </div>

			                <!--DIRECTOR-->
			                <div class="form-group row"  style="display:none;"  id="division-director">
			                    <label for="position" class="col-md-4 control-label margin-bottom">{{ __('Position') }}</label>

			                    <div class="col-md-8">
			                        <select id="position-dir" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="pos_dir" value="{{ old('division') }}" autofocus>
			                            <option value="">-- Select Position --</option>
			                        </select>
			                        @if ($errors->has('division'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('division') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <!--expert sales-->
			                <div class="form-group row"  style="display:none;"  id="division-specialist" >

			                    <label for="territory" class="col-md-4 control-label margin-bottom" style="margin-bottom: 15px;">{{ __('Territory') }}</label>

			                    <div class="col-md-8 margin-bottom">
			                        <select id="territory-expert-sales" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="territory_expert" value="{{ old('expert_sales') }}" autofocus>
			                            <option value="">-- Select Territory --</option>
			                        </select>
			                        @if ($errors->has('territory'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('territory') }}</strong>
			                            </span>
			                        @endif
			                    </div>

			                    <label for="position" class="col-md-4 control-label">{{ __('Position') }}</label>

			                    <div class="col-md-8">
			                        <select id="position-expert-sales" class="form-control{{ $errors->has('position') ? ' is-invalid' : '' }}" name="pos_expert_sales" value="{{ old('expert_sales') }}" autofocus>
			                            <option value="">-- Select Position --</option>
			                            <option value="EXPERT SALES">EXPERT SALES</option>
			                            <option value="EXPERT ENGINEER">EXPERT ENGINEER</option>
			                            <option value="COURIER">COURIER</option>
			                        </select>
			                    </div>
			                </div>
			                
			                <!-- Technical -->
			                <div class="form-group row"  style="display:none;"  id="division-technical">
			                    <label for="division" class="col-md-4 control-label margin-bottom" style="margin-bottom: 15px;">{{ __('Sub Division') }}</label>

			                    <div class="col-md-8 margin-bottom">
			                        <select id="subdivision-tech" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="id_sub_division_tech" value="{{ old('division') }}" autofocus>
			                            <option value="">-- Select Sub Division --</option>
			                            <option value="DPG" data-target="dvg" id="dvg">IMPLEMENTATION</option>
			                            <option value="PRESALES" data-target="dpg" id="dpg">PRESALES</option>
			                            <option value="DVG" data-target="dvg" id="dvg">DEVELOPMENT</option>
			                            <option value="NONE" data-target="dpg" id="dpg">NONE</option>
			                        </select>
			                        @if ($errors->has('division'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('division') }}</strong>
			                            </span>
			                        @endif
			                    </div>

			                    <label for="position" class="col-md-4 control-label margin-top">{{ __('Position') }}</label>

			                    <div class="col-md-8 margin-top">
			                        <select id="position-tech" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="pos_tech" value="{{ old('division') }}" autofocus>
			                            <option value="">-- Select Position --</option>
			                        </select>
			                        @if ($errors->has('division'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('division') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <!-- Sales -->
			                <div class="form-group row"  style="display:none;"  id="division-sales" >

			                    <label for="territory" class="col-md-4 control-label margin-bottom" style="margin-bottom: 15px;">{{ __('Territory') }}</label>

			                    <div class="col-md-8 margin-bottom">
			                        <select id="territory-sales" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="territory" value="{{ old('division') }}" autofocus>
			                            <option value="">-- Select Territory --</option>
			                        </select>
			                        @if ($errors->has('division'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('division') }}</strong>
			                            </span>
			                        @endif
			                    </div>

			                    <label for="position" class="col-md-4 control-label margin-top">{{ __('Position') }}</label>

			                    <div class="col-md-8 margin-top">
			                        <select id="position-sales" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="pos_sales" value="{{ old('division') }}" autofocus>
			                            <option value="">-- Select Position --</option>
			                            <option value="MANAGER">MANAGER</option>
			                            <option value="STAFF">STAFF</option>
			                            <option value="ADMIN">ADMIN</option>
			                        </select>
			                        @if ($errors->has('division'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('division') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <!-- Finance -->
			                <div class="form-group row"  style="display:none;"  id="division-finance">
			                    <label for="division" class="col-md-4 control-label margin-bottom" style="margin-bottom: 15px;">{{ __('Sub Division') }}</label>

			                    <div class="col-md-8 margin-bottom">
			                        <select id="subdivision-finance" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="id_sub_division_finance" value="{{ old('division') }}" autofocus>
			                            <option value="">-- Select Sub Division --</option>
			                            <option value="FINANCE" data-target="dvg" id="dvg">FINANCE</option>
			                            <option value="ACC" data-target="dpg" id="dpg">ACCOUNTING</option>
			                        </select>
			                        @if ($errors->has('division'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('division') }}</strong>
			                            </span>
			                        @endif
			                    </div>

			                    <label for="division" class="col-md-4 control-label margin-top">{{ __('Position') }}</label>

			                    <div class="col-md-8 margin-top">
			                        <select id="position-finance" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="pos_finance" value="{{ old('division') }}" autofocus>
			                            <option value="">-- Select Position --</option>
			                        </select>
			                        @if ($errors->has('division'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('division') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <!-- Operation -->
			                <div class="form-group row "  style="display:none;"  id="division-operation">
			                    <label for="division" class="col-md-4 control-label margin-bottom" style="margin-bottom: 15px;">{{ __('Sub Division') }}</label>

			                    <div class="col-md-8 margin-bottom">
			                        <select id="subdivision-operation" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="id_sub_division_operation" value="{{ old('division') }}" autofocus>
			                            <option value="">-- Select Sub Division --</option>
			                            <option value="SOL" data-target="SOL" id="SOL">SOL</option>
			                            <option value="PMO" data-target="PMO" id="PMO">PMO</option>
			                            <option value="SID" data-target="SID" id="SID">SID</option>
			                            <option value="BCD" data-target="BCD" id="BCD">BCD</option>
			                            <option value="MSM" data-target="MSM" id="MSM">MSM</option>
			                            <option value="DP" data-target="DP" id="DP">DP</option>
			                            <option value="DIR" data-target="DIR" id="DIR">NONE</option>
			                        </select>
			                        @if ($errors->has('division'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('division') }}</strong>
			                            </span>
			                        @endif
			                    </div>

			                    <label for="division" class="col-md-4 control-label margin-top">{{ __('Position') }}</label>

			                    <div class="col-md-8 margin-top">
			                        <select id="position-operation" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="pos_operation" autofocus>
			                          <option value="">-- Select position --</option>
			                        </select>
			                        @if ($errors->has('division'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('division') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <!-- HR -->
			                <div class="form-group row"  style="display:none;"  id="division-hr">
			                    <label for="position" class="col-md-4 control-label margin-bottom" style="margin-bottom: 15px;">{{ __('Position') }}</label>

			                    <div class="col-md-8 margin-bottom">
			                        <select id="position-hr" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="pos_hr" value="{{ old('division') }}" autofocus>
			                        </select>
			                        @if ($errors->has('division'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('division') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <!-- MSP -->

			                <div class="form-group row"  style="display:none;"  id="company-msp">
			                    <label for="division-msp" class="col-md-4 control-label" style="margin-bottom: 15px;">{{ __('Division') }}</label>

			                    <div class="col-md-8">
			                        <select id="division-msp" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="division_msp" value="{{ old('division') }}" autofocus>
			                            <option value="">-- Select Division --</option>
			                            <option value="SALES_MSP" data-target="sales_msp" id="sales_msp">SALES</option>
			                            <option value="TECHNICAL" data-target="TECHNICAL_MSP" id="TECHNICAL_MSP">TECHNICAL</option>
			                            <option value="WAREHOUSE_MSP" data-target="sales_msp" id="warehouse_msp">WAREHOUSE</option>
			                            <option value="OPERATION_MSP" data-target="sales_msp" id="operation_msp">OPERATION</option>
			                            <option value="HUMAN_RESOURCE" data-target="sales_msp" id="operation_msp">HUMAN RESOURCE</option>
			                            <option value="ADMIN_MSP" data-target="sales_msp">NONE</option>
			                        </select>
			                        @if ($errors->has('division'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('division') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <div class="form-group row"  style="display:none;"  id="division-msp-sales_msp">
			                  <label for="position" class="col-md-4 control-label" style="margin-bottom: 15px;">{{ __('Position') }}</label>

			                    <div class="col-md-8">
			                        <select id="position-sales-msp" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="pos_sales_msp" value="{{ old('division') }}" autofocus>
			                        </select>
			                        @if ($errors->has('division'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('division') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <div class="form-group row"  style="display:none;"  id="division-msp-TECHNICAL_MSP">
			                    <label for="division" class="col-md-4 control-label" style="margin-bottom: 15px;">{{ __('Sub Division') }}</label>

			                    <div class="col-md-8 margin-bottom">
			                        <select id="subdivision-tech-msp" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="id_sub_division_tech_msp" value="{{ old('division') }}" autofocus>
			                            <option value="">-- Select Sub Division --</option>
			                            <option value="PRESALES" data-target="dpg" id="dpg">PRESALES</option>
			                            <option value="NONE_MSP" data-target="dpg" id="dpg">NONE</option>
			                        </select>
			                        @if ($errors->has('division'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('division') }}</strong>
			                            </span>
			                        @endif
			                    </div>

			                    <label for="position" class="col-md-4 control-label margin-top">{{ __('Position') }}</label>

			                    <div class="col-md-8 margin-top">
			                        <select id="position-tech-msp" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="pos_tech_msp" value="{{ old('division') }}" autofocus>
			                            <option value="">-- Select Position --</option>
			                        </select>
			                        @if ($errors->has('division'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('division') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>
		                </div>	                

		                
		                <div class="tab-add" style="display: none;">   
			                <div class="form-group row">
			                    <label for="date_of_entry" class="col-md-4 control-label">{{ __('Date Of Entry') }}</label>

			                    <div class="col-md-8">
			                        <input id="date_of_entry" type="date" class="form-control{{ $errors->has('date_of_entry') ? ' is-invalid' : '' }}" name="date_of_entry" value="{{ old('date_of_entry') }}" onkeyup="copytextbox();" required autofocus>

			                        @if ($errors->has('date_of_entry'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('date_of_entry') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="status_karyawan" class="col-md-4 control-label">{{ __('Employee Status') }}</label>

			                    <div class="col-md-8">
			                        <select id="status_kerja" class="form-control" name="status_kerja" onchange="statusSelect(this)">
			                            <option value="">-- Select Status --</option>
			                            <option value="Tetap">Karyawan Tetap</option>
			                            <option value="Kontrak">Karyawan Kontrak</option>
			                            <option value="Magang">Karyawan Magang</option>
			                            <option value="Outsource">Karyawan Outsource</option>
			                        </select>
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="akhir_kontrak" class="col-md-4 control-label">{{ __('Last Contract Date') }}</label>

			                     <div class="col-md-8">
			                        <input id="akhir_kontrak" type="date" class="form-control" name="akhir_kontrak" onkeyup="copytextbox();" required autofocus>

			                        @if ($errors->has('last_contract date'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('last_contract date') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>	                        
			                
			                <div class="form-group row">
			                    <label for="pend_terakhir" class="col-md-4 control-label">{{ __('Last Education') }}</label>

			                    <div class="col-md-8">
			                        <input id="pend_terakhir" type="text" class="form-control" name="pend_terakhir" value="{{ old('pend_terakhir') }}" autofocus>
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="no_ktp" class="col-md-4 control-label">{{ __('KTP') }}</label>

			                    <div class="col-md-8">
			                        <input id="no_ktp" type="number" class="form-control" name="no_ktp" value="{{ old('no_ktp') }}" autofocus>
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="no_kk" class="col-md-4 control-label">{{ __('KK') }}</label>

			                    <div class="col-md-8">
			                        <input id="no_kk" type="number" class="form-control" name="no_kk" value="{{ old('no_kk') }}" autofocus>
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="no_npwp" class="col-md-4 control-label">{{ __('NPWP') }}</label>

			                    <div class="col-md-8">
			                        <input type="text" class="form-control" id="no_npwp" name="no_npwp" value="{{ old('no_npwp') }}" data-inputmask='"mask": "99.999.999.9-999.999"' data-mask autofocus>
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="bpjs_kes" class="col-md-4 control-label">{{ __('BPJS KESEHATAN') }}</label>

			                    <div class="col-md-8">
			                        <input id="bpjs_kes" type="number" class="form-control" name="bpjs_kes" value="{{ old('bpjs_kes') }}" autofocus>
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="bpjs_ket" class="col-md-4 control-label">{{ __('BPJS KETENAGAKERJAAN') }}</label>

			                    <div class="col-md-8">
			                        <input id="bpjs_ket" type="number" class="form-control" name="bpjs_ket" value="{{ old('bpjs_ket') }}" autofocus>
			                    </div>
			                </div>

			                <hr>
		                    <span>Contact Emergency</span>
		                    <hr>

		                    <div class="form-group row">
		                        <label for="name_ec" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

		                        <div class="col-md-8">
		                            <input id="name_ec" type="text" class="form-control" name="name_ec" value="{{ old('pend_terakhir') }}" autofocus>
		                        </div>
		                    </div>

		                    <div class="form-group row">
		                        <label for="hubungan_ec" class="col-md-4 col-form-label text-md-right">{{ __('Relationship') }}</label>

		                        <div class="col-md-8">
		                            <input id="hubungan_ec" type="text" class="form-control" name="hubungan_ec" value="{{ old('pend_terakhir') }}" autofocus>
		                        </div>
		                    </div>

		                    <div class="form-group row">
			                    <label for="phone_ec" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

			                    <div class="col-md-8">
			                        <input id="phone_ec" type="text" class="form-control{{ $errors->has('phone_ec') ? ' is-invalid' : '' }}" name="phone_ec" value="{{ old('phone_ec') }}" autofocus>

			                        @if ($errors->has('phone_number'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('phone_number') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>
			            </div>

		                <div class="modal-footer">
		                	<button type="button" class="btn btn-xs btn-outline-secondary" id="prevBtnAdd" onclick="NextPrevAdd()">Back</button>
							<button type="button" class="btn btn-xs btn-primary" id="nextBtnAdd" onclick="NextPrevAdd()">Next</button>
		                 <!--  <button type="button" class="btn btn-xs btn-outline-secondary" data-bs-dismiss="modal">Close</button>
		                  <button type="submit" class="btn btn-xs btn-primary"> -->
		                  </button>
		                </div>
			          </form>
			        </div>
			      </div>
			    </div>
			</div>
				
			<div class="modal fade" id="modal_update" role="dialog">
			    <div class="modal-dialog modal-md">		    
			      <!-- Modal content-->
			      <div class="modal-content">
			        <div class="modal-header">
			          	<button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
			          	<h6 class="modal-title">Detail Employees</h6>
			        </div>
			        <div class="modal-body">
			          <!-- <form method="POST" id="formUpdate" enctype="multipart/form-data"> -->
			                <!-- @csrf -->
			            <div class="tab" style="display: none;">
			            	<div class="mb-3 form-group row">
			            		<label for="nik" class="col-md-4 col-form-label text-md-right">{{ __('NIK') }}</label>
			            		<div class="col-md-8">
		                        	<input id="nik_update" type="text" class="col-md-8 form-control{{ $errors->has('nik') ? ' is-invalid' : '' }}" name="nik_update" value="{{ old('nik') }}" readonly autofocus>
			            		</div>
			            		@if ($errors->has('nik'))
		                            <span class="invalid-feedback">
		                                <strong>{{ $errors->first('nik') }}</strong>
		                            </span>
		                        @endif
			            	</div>
			            	<div class="mb-3 form-group row">
			                    <label for="name" class="col-md-4 col-form-label">{{ __('Employees Name') }}</label>
			                    <div class="col-md-8">
			                        <input id="name_update" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name_update" value="{{ old('name') }}" autofocus>

			                        @if ($errors->has('name'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('name') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>
			                <div class="mb-3 form-group row">
			                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

			                    <div class="col-md-8">
			                        <input id="email_update" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email_update" value="{{ old('email') }}" required>

			                        @if ($errors->has('email'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('email') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>
			                <div class="mb-3 form-group row">
			                    <label for="email_personal" class="col-md-4 col-form-label text-md-right">{{ __('Personal E-Mail') }}</label>

			                    <div class="col-md-8">
			                        <input id="email_personal_update" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email_personal_update" value="{{ old('email') }}" required>

			                        @if ($errors->has('email'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('email') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>
			                <div class="mb-3 form-group row">
			                    <label for="date_of_entry" class="col-md-4 col-form-label text-md-right">{{ __('Date Of Entry') }}</label>

			                    <div class="col-md-8">
			                        <input id="date_of_entry_update" type="date" class="form-control{{ $errors->has('date_of_entry') ? ' is-invalid' : '' }}" name="date_of_entry_update" value="{{ old('date_of_entry') }}" onkeyup="copytextbox();" required autofocus>

			                        @if ($errors->has('date_of_entry'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('date_of_entry') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>
			                <div class="mb-3 form-group row">
		                        <label for="tempat_lahir" class="col-md-4 col-form-label text-md-right">{{ __('Place of Birth') }}</label>

		                        <div class="col-md-8">
		                            <input id="tempat_lahir_update" type="text" class="form-control" name="tempat_lahir_update" value="{{ old('tempat_lahir') }}" autofocus>
		                        </div>
		                    </div>
		                    <div class="mb-3 form-group row">
			                    <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">{{ __('Date Of Birth') }}</label>

			                    <div class="col-md-8">
			                        <input id="date_of_birth_update" type="date" class="form-control{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" name="date_of_birth_update" value="{{ old('date_of_birth') }}" onkeyup="copytextbox();" required autofocus>

			                        @if ($errors->has('date_of_birth'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('date_of_birth') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>
			                <div class="mb-3 form-group row">
			                    <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Residence Address') }}</label>

			                    <div class="col-md-8">
			                        <textarea id="address_update" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address_update" value="{{ old('address') }}" autofocus></textarea>

			                        @if ($errors->has('address'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('address') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <div class="mb-3 form-group row">
		                        <label for="address_ktp" class="col-md-4 col-form-label text-md-right">{{ __('ID Address') }}</label>

		                        <div class="col-md-8">
		                            <textarea id="address_ktp_update" rows="5" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address_ktp_update" value="{{ old('address_ktp') }}" autofocus></textarea>

		                            @if ($errors->has('address'))
		                                <span class="invalid-feedback">
		                                    <strong>{{ $errors->first('address') }}</strong>
		                                </span>
		                            @endif
		                        </div>
		                    </div>

			                <div class="mb-3 form-group row">
			                    <label for="phone_number" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

			                    <div class="col-md-8">
			                        <input id="phone_number_update" type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number_update" value="{{ old('phone_number') }}" autofocus>

			                        @if ($errors->has('phone_number'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('phone_number') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>
			            </div>              

			            <div class="tab" style="display: none;">
			            	<div class="form-group row">
			                    <label for="status_karyawan" class="col-md-4 col-form-label text-md-right">{{ __('Employee Status') }}</label>

			                    <div class="col-md-4" id="div_status_karyawan_update">
			                    	<input id="status_karyawan_update" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required readonly>
			                	</div>

			                    <div class="col-md-4">
			                        <select id="status_kerja_update" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" name="status_kerja_update" value="{{ old('company') }}" onchange="statusSelect(this)">
			                            <option value="">-- Select Status --</option>
			                            <option value="Tetap">Karyawan Tetap</option>
			                            <option value="Kontrak">Karyawan Kontrak</option>
			                            <option value="Magang">Karyawan Magang</option>
			                            <option value="Outsource">Karyawan Outsource</option>
			                        </select>
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="akhir_kontrak_update" class="col-md-4 col-form-label text-md-right">{{ __('Last Contract Date') }}</label>

			                     <div class="col-md-8">
			                        <input id="akhir_kontrak_update" type="date" class="form-control{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" name="akhir_kontrak_update" onkeyup="copytextbox();" autofocus>

			                        @if ($errors->has('last_contract date'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('last_contract date') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="company" class="col-md-4 col-form-label text-md-right">{{ __('Company') }}</label>

			                    <div class="col-md-4" id="div_company_view_update">
			                    	<input id="company_view_update" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required readonly>
			                	</div>

			                    <div class="col-md-4">
			                        <select id="company_update" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" name="company_update" value="{{ old('company') }}" onchange="companySelect(this)" autofocus>
			                            <option value="">-- Select Company --</option>
			                            <option value="1" data-target="sip" id="1">SIP</option>
			                            <option value="2" data-target="msp" id="2">MSP</option>
			                        </select>
			                        @if ($errors->has('company'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('company') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <!--tampilkan divisi berdasarkan divisi-->
			                <div class="form-group row">
			                    <label for="divisi" class="col-md-4 col-form-label text-md-right">{{ __('Division') }}</label>

			                    <div class="col-md-4" id="div_divisi_view_update">
			                    	<input id="divisi_view_update" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required readonly>
			                	</div>

			                    <div class="col-md-4">
			                        <select id="divisi_update" onchange="divisiSelect(this)" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" name="divisi_update" value="{{ old('company') }}" autofocus>
			                        </select>
			                        @if ($errors->has('company'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('company') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <!--tampilkan divisi berdasarkan sub-divisi-->
			                <div class="form-group row">
			                    <label for="divisi" class="col-md-4 col-form-label text-md-right">{{ __('Sub-Division') }}</label>

			                    <div class="col-md-4" id="div_subdivisi_view_update">
			                    	<input id="sub_divisi_view_update" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"  value="{{ old('email') }}" required readonly>
			                	</div>

			                    <div class="col-md-4">
			                        <select id="sub_divisi_update" onchange="subdivisiSelect(this)" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" name="sub_divisi_update" value="{{ old('company') }}" autofocus>
			                        </select>
			                        @if ($errors->has('company'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('company') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <!--tampilkan divisi berdasarkan posisi-->
			                <div class="form-group row">
			                    <label for="posisi" class="col-md-4 col-form-label text-md-right">{{ __('Position') }}</label>

			                    <div class="col-md-4" id="div_posisi_view_update">
			                    	<input id="posisi_view_update" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"  value="{{ old('email') }}" required readonly>
			                	</div>

			                    <div class="col-md-4">
			                        <select id="posisi_update" onchange="posisiSelect(this)" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" name="posisi_update" value="{{ old('company') }}" autofocus>
			                        </select>
			                        @if ($errors->has('company'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('company') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>

			                <!--tampilkan roles berdasarkan user-->
			                <div class="form-group row" id="div_roles">
			                	<label for="roles_user" class="col-md-4 control-label margin-top">{{ __('Roles') }}</label>

			                	<div class="col-md-4" id="div_roles_view_update">
			                    	<input id="roles_view_update" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"  required readonly>
			                	</div>

			                    <div class="col-md-4 margin-top">
			                        <select id="roles_user_update" onchange="roleSelect(this)" class="form-control{{ $errors->has('division') ? ' is-invalid' : '' }}" name="roles_user" autofocus>
			                        	<option value="" selected>--Select Roles--</option>
			                            @foreach($roles as $data)
			                            <option value="{{$data->id}}">{{$data->name}}</option>
			                            @endforeach
			                        </select>
			                    </div>
			                </div>
			                
			                  
			                <div class="form-group row">
		                        <label for="pend_terakhir" class="col-md-4 col-form-label text-md-right">{{ __('Last Education') }}</label>

		                        <div class="col-md-8">
		                            <input id="pend_terakhir_update" type="text" class="form-control" name="pend_terakhir_update" value="{{ old('pend_terakhir') }}" autofocus>
		                        </div>
		                    </div>

			            </div>

			            <div class="tab" style="display:none;">
			            	<div class="form-group row">
			                    <label for="no_ktp" class="col-md-4 col-form-label text-md-right">{{ __('KTP') }}</label>

			                    <div class="col-md-8">
			                        <input id="no_ktp_update" type="text" class="form-control" name="no_ktp_update" value="{{ old('no_ktp') }}" autofocus>
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="no_kk" class="col-md-4 col-form-label text-md-right">{{ __('KK') }}</label>

			                    <div class="col-md-8">
			                        <input id="no_kk_update" type="text" class="form-control" name="no_kk_update" value="{{ old('no_kk') }}" autofocus>
			                    </div>
			                </div>

			                <div class="form-group row">
			                    <label for="no_npwp" class="col-md-4 col-form-label text-md-right">{{ __('NPWP') }}</label>

			                    <div class="col-md-8">
			                        <input id="no_npwp_update" type="text" class="form-control" name="no_npwp_update" value="{{ old('no_npwp') }}" data-inputmask='"mask": "99.999.999.9-999.999"' data-mask autofocus>
			                    </div>
			                </div>

			                <div class="form-group row">
		                        <label for="bpjs_kes" class="col-md-4 col-form-label text-md-right">{{ __('BPJS KESEHATAN') }}</label>

		                        <div class="col-md-8">
		                            <input id="bpjs_kes_update" type="text" class="form-control" name="bpjs_kes_update" value="{{ old('bpjs_kes') }}" autofocus>
		                        </div>
		                    </div>

		                    <div class="form-group row">
		                        <label for="bpjs_ket" class="col-md-4 col-form-label text-md-right">{{ __('BPJS KETENAGAKERJAAN') }}</label>

		                        <div class="col-md-8">
		                            <input id="bpjs_ket_update" type="text" class="form-control" name="bpjs_ket_update" value="{{ old('bpjs_ket') }}" autofocus>
		                        </div>
		                    </div>

			            	<hr>
		                    <span>Contact Emergency</span>
		                    <hr>

		                    <div class="form-group row">
		                        <label for="name_ec_update" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

		                        <div class="col-md-8">
		                            <input id="name_ec_update" type="text" class="form-control" name="name_ec_update" value="{{ old('pend_terakhir') }}" autofocus>
		                        </div>
		                    </div>

		                    <div class="form-group row">
		                        <label for="hubungan_ec_update" class="col-md-4 col-form-label text-md-right">{{ __('Relationship') }}</label>

		                        <div class="col-md-8">
		                            <input id="hubungan_ec_update" type="text" class="form-control" name="hubungan_ec_update" value="{{ old('pend_terakhir') }}" autofocus>
		                        </div>
		                    </div>

		                    <div class="form-group row">
			                    <label for="phone_ec_update" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

			                    <div class="col-md-8">
			                        <input id="phone_ec_update" type="text" class="form-control{{ $errors->has('phone_ec_update') ? ' is-invalid' : '' }}" name="phone_ec_update" value="{{ old('phone_ec_update') }}" autofocus>

			                        @if ($errors->has('phone_number'))
			                            <span class="invalid-feedback">
			                                <strong>{{ $errors->first('phone_number') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                </div>
			            </div>             
	                 

			            <div class="modal-footer">
			            	<button type="button" class="btn btn-xs btn-secondary" id="prevBtn" onclick="nextPrev()">Back</button>
							<button type="button" class="btn btn-xs btn-primary" id="nextBtn" onclick="nextPrev()">Next</button>
			             <!--  <button type="button" class="btn btn-xs btn-outline-secondary" data-bs-dismiss="modal">Close</button>
			              <button type="submit" class="btn btn-xs btn-primary btn-submit-update">
			                  {{ __('Update') }}
			              </button> -->
			            </div>
			          <!-- </form> -->
			        </div>
			      </div>		      
			    </div>
			</div>

			<div class="modal fade" id="modal_edit_status" role="dialog">
				<div class="modal-dialog modal-md">
		      <div class="modal-content">
		        <div class="modal-header">
		          <h6 class="modal-title">Ubah Status Employees</h6>
		        </div>
			        <div class="modal-body">
			        	<div class="form-group row">
		                    <label for="Entry" class="col-md-4 col-form-label text-md-right">{{ __('Mulai Bekerja') }}</label>

		                    <div class="col-md-8">
		                        <input id="mulai_kerja" type="text" class="form-control" name="mulai_kerja" required>
		                    </div>
		                </div>
			        </div>
			    </div>
			</div>
			</div>

			<div class="modal fade" id="modal_update_file" role="dialog">
		    <div class="modal-dialog modal-lg">
		    
		      <!-- Modal content-->
		      <div class="modal-content">
		        <div class="modal-header">
		          <h6 class="modal-title">Attach File</h6>
		        </div>
		        <div class="modal-body">
		          	<form method="POST" action="{{url('/update_profile_npwp') }}" enctype="multipart/form-data">
		                @csrf
	                    <div class="form-group row">
	                        <label for="nik" class="col-md-4 col-form-label text-md-right">{{ __('NIK') }}</label>

	                        <div class="col-md-8">
	                            <input id="nik_update_attach" type="text" class="form-control{{ $errors->has('nik') ? ' is-invalid' : '' }}" name="nik_profile" value="{{ old('nik') }}" readonly autofocus>

	                            @if ($errors->has('nik'))
	                                <span class="invalid-feedback">
	                                    <strong>{{ $errors->first('nik') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>

	                    <div class="form-group row">
	                        <label for="npwp_file" class="col-md-4 col-form-label text-md-right">{{ __('NPWP File') }}</label>
	                        <div class="col-md-8">
	                            <input id="inputgambarnpwp_update" type="file" class="form-control" name="npwp_file" value="{{ old('npwp_file') }}" class="validate" autofocus>
	                        </div>
	                    </div>

	                    <center>
	                    <div class="form-group row">
	                        <div class="col-md-12">
	                            <img src="{{url('image/img_nf.png')}}" class="zoom center" id="showgambarnpwp_update" style="max-width:400px;max-height:400px;">
	                        </div>
	                    </div>
	                    </center>

	                    <div class="form-group row">
	                    	<label for="ktp_file" class="col-md-4 col-form-label text-md-right">{{ __('KTP')}}</label>
	                    	<div class="col-md-8">
	                    		<input id="inputgambarktp_update" type="file" class="form-control" name="ktp_file" value="{{old('ktp_file')}}" class="validate" autofocus>
	                    	</div>
	                    </div>

	                    <center>
	                    	<div class="form-group row">
	                    		<div class="col-md-12">
	                    			<img src="{{url('image/img_nf.png')}}" class="zoom center" id="showgambarktp_update" style="max-width: 400px; max-height: 400px;">
	                    		</div>
	                    	</div>
	                    </center>

	                    <div class="form-group row">
	                    	<label for="ktp_file" class="col-md-4 col-form-label text-md-right">{{ __('BPJS Kesehatan')}}</label>
	                    	<div class="col-md-8">
	                    		<input id="inputgambarbpjs_kes_update" type="file" class="form-control" name="bpjs_kes" value="{{old('bpjs_kes')}}" class="validate" autofocus>
	                    	</div>
	                    </div>

	                    <center>
	                    	<div class="form-group row">
	                    		<div class="col-md-12">
	                    			<img src="{{url('image/img_nf.png')}}" class="zoom center" id="showgambarbpjs_kes_update" style="max-width: 400px; max-height: 400px;">
	                    		</div>
	                    	</div>
	                    </center>


	                    <div class="form-group row">
	                        <label for="bpjs_ket" class="col-md-4 col-form-label text-md-right">{{ __('BPJS Ketenagakerjaan') }}</label>

	                        <div class="col-md-8">
	                            <input id="inputgambarbpjs_ket_update" type="file" class="form-control" name="bpjs_ket" value="{{ old('bpjs_ket') }}" class="validate" autofocus>
	                        </div>
	                    </div>

	                    <center>
	                    <div class="form-group row">
	                        <div class="col-md-12">
	                            <img src="{{url('image/img_nf.png')}}" class="zoom center" id="showgambarbpjs_ket_update" style="max-width:400px;max-height:400px;">
	                        </div>
	                    </div>
	                    </center>

		                <div class="modal-footer">
		                  <button type="button" class="btn btn-xs btn-outline-secondary" data-bs-dismiss="modal">Close</button>
		                  <button type="submit" class="btn btn-xs btn-primary btn-submit-update">
		                      {{ __('Update') }}
		                  </button>
		                </div>
		          	</form>
		        </div>
		      </div>
		      
		    </div>
			</div>
		</section>
	</div>
@endsection
@section('scriptImport')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.js" integrity="sha512-SSQo56LrrC0adA0IJk1GONb6LLfKM6+gqBTAGgWNO8DIxHiy0ARRIztRWVK6hGnrlYWOFKEbSLQuONZDtJFK0Q==" crossorigin="anonymous"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
@endsection
@section('script')
<script type="">
	function searchCustom(id_table,id_seach_bar){
		$("#" + id_table).DataTable().search($('#' + id_seach_bar).val()).draw();
	}

	$(document).ready(function(){
		localStorage.clear();

        var accesable = @json($feature_item);
        accesable.forEach(function(item,index){
          $("#" + item).show()          
        })  
        
        // if (accesable.includes('btnEdit') == false) {
	       //  var column1 = table1.column(9);
	       //  column1.visible(!column1.visible());

	       //  var column2 = table2.column(3);
	       //  column2.visible(!column2.visible());

	       //  var column3 = table3.column(3);
	       //  column3.visible(!column3.visible());

	       //  var column4 = table4.column(3);
	       //  column4.visible(!column4.visible());

	       //  var column5 = table5.column(3);
	       //  column5.visible(!column5.visible());

	       //  var column6 = table6.column(3);
	       //  column6.visible(!column6.visible());
        // }

        if (accesable.length == 0){
        	var column1 = table1.column(10);
	        column1.visible(false);

	        var column2 = table1.column(11);
	        column2.visible(false);

	        var column3 = table3.column(4);
	        column3.visible(false);

	        var column4 = table4.column(4);
	        column4.visible(false);

	        var column5 = table5.column(4);
	        column5.visible(false);
        }
    })

	$(":input").inputmask();
	$("#phone_number").inputmask({"mask": "(+62) 999-9999-9999"});
	$("#phone_number_update").inputmask({"mask": "(+62) 999-9999-9999"});
	$("#phone_ec_update").inputmask({"mask": "(+62) 999-9999-9999"});
	$("#phone_ec").inputmask({"mask": "(+62) 999-9999-9999"});

	$("#roles_user").select2({
		dropdownParent:$("#modalAdd")
	});

	$("#roles_user_update").select2({
		dropdownParent:$("#modal_update")
	})

	$(document).ready(function(){
		$("[data-mask]").inputmask();
	})

    $(".btn-submit-update").click(function(){
   	 $('#modal_update_file').delay(1000).fadeOut(450);

	 setTimeout(function(){
	    $('#modal_update_file').modal("hide");
	 }, 1500);
   	  // $("#modal_update_file").modal("hide");
   	  // $("#modal_update").modal("hide");
    })

    $(".modal_edit_status").click(function(){
   		$("#modal_edit_status").modal("show");
   	})

   	function showTabAdd(n){
		var x = document.getElementsByClassName("tab-add");
		x[n].style.display = "inline";

   		if (n == 0) {
			document.getElementById("prevBtnAdd").style.display = "none";
			$("#prevBtnAdd").addClass('d-none')
		} else {
			document.getElementById("prevBtnAdd").style.display = "inline";
			$("#prevBtnAdd").removeClass('d-none')
		}
		if (n == (x.length - 1)) {
			document.getElementById("nextBtnAdd").innerHTML = "Register";
			$("#nextBtnAdd").attr('onclick','submitRegEmp()');				
		} else {
			
			$("#nextBtnAdd").attr('onclick','nextPrevAdd(1)');
			$("#prevBtnAdd").attr('onclick','nextPrevAdd(-1)')
			document.getElementById("nextBtnAdd").innerHTML = "Next";
			$("#nextBtnAdd").prop("disabled",false)
		}
   		$("#modalAdd").modal("show")
   	}

    $('.btn-attach').click(function(){
        $.ajax({
          type:"GET",
          url:"{{url('/hu_rec/get_hu')}}",
          data:{
            id_hu:this.value,
          },
          "processing": true,
	      "language": {
            'loadingRecords': '&nbsp;',
            'processing': '<i class="bx bx-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
          },
          success: function(result){
            $.each(result[0], function(key, value){
            	$("#nik_update_attach").val(value.nik);
               if (value.npwp_file == null) {
               	$("#showgambarnpwp_update").attr("src","http://placehold.it/100x100");
               } else {
               	$("#showgambarnpwp_update").attr("src","image/"+value.npwp_file);
               }
            });

             $.each(result[0], function(key, value){
            	$("#nik_update_attach").val(value.nik);
               if (value.ktp_file == null) {
               	$("#showgambarktp_update").attr("src","http://placehold.it/100x100");
               } else {
               	$("#showgambarktp_update").attr("src","image/"+value.ktp_file);
               }
            });

            $.each(result[0], function(key, value){
            	$("#nik_update_attach").val(value.nik);
               if (value.bpjs_kes == null) {
               	$("#showgambarbpjs_kes_update").attr("src","http://placehold.it/100x100");
               } else {
               	$("#showgambarbpjs_kes_update").attr("src","image/"+value.bpjs_kes);
               }
            });

            $.each(result[0], function(key, value){
            	$("#nik_update_attach").val(value.nik);
               if (value.bpjs_ket == null) {
               	$("#showgambarbpjs_ket_update").attr("src","http://placehold.it/100x100");
               } else {
               	$("#showgambarbpjs_ket_update").attr("src","image/"+value.bpjs_ket);
               }
            });

          }
        }); 
        $("#modal_update_file").modal("show");
    });

    // $(".close").click(function(){
    // 	$("#modal_update").modal('hide')
	// 	window.localStorage.clear()
    // 	var x = document.getElementsByClassName("tab");
    //     $.each(x, function(key, value){
	// 	    value.style.display = "none"
	// 	})
    // })

    document.getElementById('modalAdd').addEventListener('hidden.bs.modal', function () {
	    document.querySelectorAll('.tab-add').forEach(element => {
	        element.style.display = "none";
	    });
	});

	document.getElementById('modal_update').addEventListener('hidden.bs.modal', function () {
	    document.querySelectorAll('.tab').forEach(element => {
	        element.style.display = "none";
	    });
	});


    $('#modal_update').on('hidden.bs.modal', function () {
    	currentTab = 0
      	n = 0
    })

	localStorage.setItem("divisi_update", "")
	localStorage.setItem("sub_divisi_update", "")
	localStorage.setItem("posisi_update", "")
	localStorage.setItem("roles_update", "")

    var currentTab = 0
    function showEditTab(value,n){ 
    	if (n == 0) {
		document.getElementById("prevBtn").style.display = "none";
		$("#prevBtn").addClass('d-none')

		} else {
			document.getElementById("prevBtn").style.display = "inline";
			$("#prevBtn").removeClass('d-none')
		}
		var x = document.getElementsByClassName("tab");
		x[n].style.display = "inline";
		if (n == (x.length - 1)) {
			document.getElementById("nextBtn").innerHTML = "Update";
			$("#nextBtn").attr('onclick','submitBtnEmp()');				
		} else {
			$("#nextBtn").attr('onclick','nextPrev('+value+',1)');
			$("#prevBtn").attr('onclick','nextPrev('+value+',-1)')
			document.getElementById("nextBtn").innerHTML = "Next";
			$("#nextBtn").prop("disabled",false)
		}
		$.ajax({
          type:"GET",
          url:"{{url('/hu_rec/get_hu')}}",
          data:{
            id_hu:value,
          },
          "processing": true,
	      "language": {
            'loadingRecords': '&nbsp;',
            'processing': '<i class="bx bx-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
          },
          success: function(result){
          	$.each(result[0], function(key, value){
          		
          	   if (value.id_company == '2') {
          	   	$("#div_roles").hide()
          	   }else{
          	   	$("#div_roles").show()
          	   }

               if (value.status_delete == "D") {
               	 	if (n == 2) {
						document.getElementById("nextBtn").style.display = "none";
               	 	}else{
						document.getElementById("nextBtn").style.display = "inline";
               	 	}
               	   $("#nik_update").val(value.nik).prop("readonly", true);
	               $("#name_update").val(value.name).prop("readonly", true);
	               $("#email_update").val(value.email).prop("readonly", true);
	               $("#date_of_entry_update").val(value.date_of_entry).prop("readonly", true);
	               $("#date_of_birth_update").val(value.date_of_birth).prop("readonly", true);
	               $("#akhir_kontrak_update").val(value.akhir_kontrak).prop("readonly", true);
	               $("#address_update").val(value.address).prop("readonly", true);
	               $("#phone_number_update").val(value.phone).prop("readonly", true);
	               $("#no_ktp_update").val(value.no_ktp).prop("readonly", true);
	               $("#no_kk_update").val(value.no_kk).prop("readonly", true);
	               $("#no_npwp_update").val(value.no_npwp).prop("readonly", true);
	               $("#tempat_lahir_update").val(value.tempat_lahir).prop("readonly", true);
	               $("#email_personal_update").val(value.email_pribadi).prop("readonly", true);
	               $("#bpjs_ket_update").val(value.bpjs_ket).prop("readonly", true);
	               $("#bpjs_kes_update").val(value.bpjs_kes).prop("readonly", true);
	               $("#address_ktp_update").val(value.alamat_ktp).prop("readonly", true);
	               $("#pend_terakhir_update").val(value.pend_terakhir).prop("readonly", true);
	               $("#name_ec_update").val(value.name_ec).prop("readonly", true);
	               $("#phone_ec_update").val(value.phone_ec).prop("readonly", true);
	               $("#hubungan_ec_update").val(value.hubungan_ec).prop("readonly", true);

	               $("#company_update").prop("disabled", true);
	               $("#divisi_update").prop("disabled", true);
	               $("#sub_divisi_update").prop("disabled", true);
	               $("#posisi_update").prop("disabled", true);
	               $("#roles_user_update").prop("disabled", true);
	               $("#status_kerja_update").prop("disabled", true);

	               if (value.status_kerja == 'Tetap') {
	               	$("#status_karyawan_update").val("Karyawan Tetap").prop("readonly", true);
	               }else if (value.status_kerja == 'Kontrak') {
	               	$("#status_karyawan_update").val("Karyawan Kontrak").prop("readonly", true);
	               }else if (value.status_kerja == 'Magang') {
	               	$("#status_karyawan_update").val("Karyawan Magang").prop("readonly", true);
	               }else if (value.status_kerja == 'Outsource') {
	               	$("#status_karyawan_update").val("Karyawan Outsource").prop("readonly", true);
	               }else{
	               	$("#status_karyawan_update").val("").prop("readonly", true);
	               }
	               if (value.npwp_file == null) {
	               	$("#showgambarnpwp_update").attr("src","img/img_nf.png");
	               } else {
	               	$("#showgambarnpwp_update").attr("src","image/"+value.npwp_file);
	               }
	               if (value.ktp_file == null) {
	               	$("#showgambarktp_update").attr("src","img/img_nf.png");
	               } else {
	               	$("#showgambarktp_update").attr("src","image/"+value.ktp_file);
	               }
	               if (value.bpjs_kes == null) {
	               	$("#showgambarbpjs_kes_update").attr("src","img/img_nf.png");
	               } else {
	               	$("#showgambarbpjs_kes_update").attr("src","image/"+value.bpjs_kes);
	               }
	               if (value.bpjs_ket == null) {
	               	$("#showgambarbpjs_ket_update").attr("src","img/img_nf.png");
	               } else {
	               	$("#showgambarbpjs_ket_update").attr("src","image/"+value.bpjs_ket);
	               }
	               

	               $("#password_update").val(value.password).prop("readonly", true);
	               $("#divisi_view_update").val(value.id_division).prop("readonly", true);
	               $("#sub_divisi_view_update").val(value.id_territory).prop("readonly", true);
	               if (value.id_company == 1) {
	               	$("#company_view_update").val("SIP").prop("readonly", true);
	               }else{
	               	$("#company_view_update").val("MSP").prop("readonly", true);
	               }
	               $("#posisi_view_update").val(value.id_position).prop("readonly", true);
	               
               }else{               		
				   $("#nik_update").val(value.nik);
				   if (!localStorage.getItem("name_update") == true) {
	               	$("#name_update").val(value.name);
				   	localStorage.setItem("name_update", $("#name_update").val())
				   }else{
				   	localStorage.setItem("name_update", $("#name_update").val())
				   }

				   if (!localStorage.getItem("email_update") == true) {
	               	$("#email_update").val(value.email);
				   	localStorage.setItem("email_update", $("#email_update").val())
				   }else{
				   	localStorage.setItem("email_update", $("#email_update").val())
				   }

				   if (!localStorage.getItem("date_of_entry_update") == true) {
	               	$("#date_of_entry_update").val(value.date_of_entry).prop("readonly",true);
				   	localStorage.setItem("date_of_entry_update", $("#date_of_entry_update").val())
				   }else{
				   	localStorage.setItem("date_of_entry_update", $("#date_of_entry_update").val())
				   }

				   if (!localStorage.getItem("date_of_birth_update") == true) {
	               	$("#date_of_birth_update").val(value.date_of_birth).prop("readonly",true);
				   	localStorage.setItem("date_of_birth_update", $("#date_of_birth_update").val())
				   }else{
				   	localStorage.setItem("date_of_birth_update", $("#date_of_birth_update").val())
				   }

				   if (!localStorage.getItem("akhir_kontrak_update") == true) {
	               	$("#akhir_kontrak_update").val(value.akhir_kontrak);
				   	localStorage.setItem("akhir_kontrak_update", $("#akhir_kontrak_update").val())
				   }else{
				   	localStorage.setItem("akhir_kontrak_update", $("#akhir_kontrak_update").val())
				   }

				   localStorage.setItem("address_update", $("#address_update").val())
				   if (!localStorage.getItem("address_update") == true) {
				   	localStorage.setItem("address_update", $("#address_update").val())
				   	if (value.address != "" && value.address != null) {
	               		$("#address_update").val(value.address);
				   	}else{
	               		$("#address_update").val(localStorage.getItem("address_update"));
				   	}
				   }else{
				   	localStorage.setItem("address_update", $("#address_update").val())
				   }

				   	localStorage.setItem('address_ktp_update', $("#address_ktp_update").val())
				   	if (!localStorage.getItem("addres_ktp_update") == true) {
				   	localStorage.setItem('address_ktp_update', $("#address_ktp_update").val());
				   	if (value.alamat_ktp != "" && value.alamat_ktp != null) {
				   		console.log(value.alamat_ktp)
	               		$("#address_ktp_update").val(value.alamat_ktp);
				   	}else{
	               		$("#address_ktp_update").val(localStorage.getItem("address_ktp_update"));
				   	}
				   }else{
				   	localStorage.setItem("address_ktp_update", $("#address_ktp_update").val())
				   }

				   // if (!localStorage.getItem("address_update") == true) {
				   // 	localStorage.setItem("address_update", $("#address_update").val())
	      //          	$("#address_update").val(value.address);
				   // }else{
				   // 	localStorage.setItem("address_update", $("#address_update").val())
				   // }

				   if (!localStorage.getItem("phone_number_update") == true) {
	               	$("#phone_number_update").val(value.phone);
				   	localStorage.setItem("phone_number_update", $("#phone_number_update").val())
				   }else{
				   	localStorage.setItem("phone_number_update", $("#phone_number_update").val())
				   }

				   if (!localStorage.getItem("no_ktp_update") == true) {
	               	$("#no_ktp_update").val(value.no_ktp);
				   	localStorage.setItem("no_ktp_update", $("#no_ktp_update").val())
				   }else{
				   	localStorage.setItem("no_ktp_update", $("#no_ktp_update").val())
				   }

				   if (!localStorage.getItem("no_kk_update") == true) {
	               	$("#no_kk_update").val(value.no_kk);
				   	localStorage.setItem("no_kk_update", $("#no_kk_update").val())
				   }else{
				   	localStorage.setItem("no_kk_update", $("#no_kk_update").val())
				   }

				   if (!localStorage.getItem("no_npwp_update") == true) {
	               	$("#no_npwp_update").val(value.no_npwp);
				   	localStorage.setItem("no_npwp_update", $("#no_npwp_update").val())
				   }else{
				   	localStorage.setItem("no_npwp_update", $("#no_npwp_update").val())
				   }

				   if (!localStorage.getItem("tempat_lahir_update") == true) {
	               	$("#tempat_lahir_update").val(value.tempat_lahir);
				   	localStorage.setItem("tempat_lahir_update", $("#tempat_lahir_update").val())
				   }else{
				   	localStorage.setItem("tempat_lahir_update", $("#tempat_lahir_update").val())
				   }

				   if (!localStorage.getItem("email_personal_update") == true) {
	               	$("#email_personal_update").val(value.email_pribadi);
				   	localStorage.setItem("email_personal_update", $("#email_personal_update").val())
				   }else{
				   	localStorage.setItem("email_personal_update", $("#email_personal_update").val())
				   }

				   if (!localStorage.getItem("bpjs_ket_update") == true) {
	               	$("#bpjs_ket_update").val(value.bpjs_ket);
				   	localStorage.setItem("bpjs_ket_update", $("#bpjs_ket_update").val())
				   }else{
				   	localStorage.setItem("bpjs_ket_update", $("#bpjs_ket_update").val())
				   }

				   if (!localStorage.getItem("bpjs_kes_update") == true) {
	               	$("#bpjs_kes_update").val(value.bpjs_kes);
				   	localStorage.setItem("bpjs_kes_update", $("#bpjs_kes_update").val())
				   }else{
				   	localStorage.setItem("bpjs_kes_update", $("#bpjs_kes_update").val())
				   }

				   // if (!localStorage.getItem("address_ktp_update") == true) {
	               // 	$("#address_ktp_update").val(value.alamat_ktp);
				   // 	localStorage.setItem("address_ktp_update", $("#address_ktp_update").val())
				   // }else{
				   // 	localStorage.setItem("address_ktp_update", $("#address_ktp_update").val())
				   // }

				   if (!localStorage.getItem("pend_terakhir_update") == true) {
				   	localStorage.setItem("pend_terakhir_update", $("#pend_terakhir_update").val())
				   	if (value.pend_terakhir != "") {
	               		$("#pend_terakhir_update").val(value.pend_terakhir);
				   	}else{
	               		$("#pend_terakhir_update").val(localStorage.getItem("pend_terakhir_update"));
				   	}
				   }else{
				   	localStorage.setItem("pend_terakhir_update", $("#pend_terakhir_update").val())
				   }

				   if (!localStorage.getItem("name_ec_update") == true) {
	               	$("#name_ec_update").val(value.name_ec);
				   	localStorage.setItem("name_ec_update", $("#name_ec_update").val())
				   }else{
				   	localStorage.setItem("name_ec_update", $("#name_ec_update").val())
				   }

				   if (!localStorage.getItem("phone_ec_update") == true) {
	               	$("#phone_ec_update").val(value.phone_ec);
				   	localStorage.setItem("phone_ec_update", $("#phone_ec_update").val())
				   }else{
				   	localStorage.setItem("phone_ec_update", $("#phone_ec_update").val())
				   }

				   if (!localStorage.getItem("hubungan_ec_update") == true) {
	               	$("#hubungan_ec_update").val(value.hubungan_ec);
				   	localStorage.setItem("hubungan_ec_update", $("#hubungan_ec_update").val())
				   }else{
				   	localStorage.setItem("hubungan_ec_update", $("#hubungan_ec_update").val())
				   }

	               if (value.status_kerja == 'Tetap') {
	               	$("#status_karyawan_update").val("Karyawan Tetap");
	               }else if (value.status_kerja == 'Kontrak') {
	               	$("#status_karyawan_update").val("Karyawan Kontrak");
	               }else if (value.status_kerja == 'Magang') {
	               	$("#status_karyawan_update").val("Karyawan Magang");
	               }else if (value.status_kerja == 'Outsource') {
	               	$("#status_karyawan_update").val("Karyawan Outsource");
	               }else{
	               	$("#status_karyawan_update").val("");
	               }

	               if (value.npwp_file == null) {
	               	$("#showgambarnpwp_update").attr("src","img/img_nf.png");
	               } else {
					   if (!localStorage.getItem("showgambarnpwp_update") == true) {
		               	$("#showgambarnpwp_update").attr("src","image/"+value.npwp_file);
	               		localStorage.setItem("showgambarnpwp_update", $("#showgambarnpwp_update").val())
					   }
	               	
	               }
	               if (value.ktp_file == null) {
	               	$("#showgambarktp_update").attr("src","img/img_nf.png");
	               } else {
					   if (!localStorage.getItem("showgambarktp_update") == true) {
		               	$("#showgambarktp_update").attr("src","image/"+value.ktp_file);
	               		localStorage.setItem("showgambarktp_update", $("#showgambarktp_update").val())
					   }
	               }
	               if (value.bpjs_kes == null) {
	               	$("#showgambarbpjs_kes_update").attr("src","img/img_nf.png");
	               } else {
					   if (!localStorage.getItem("showgambarbpjs_kes_update") == true) {
		               	$("#showgambarbpjs_kes_update").attr("src","image/"+value.bpjs_kes);
	               		localStorage.setItem("showgambarbpjs_kes_update", $("#showgambarbpjs_kes_update").val())
					   }
	               }
	               if (value.bpjs_ket == null) {
	               	$("#showgambarbpjs_ket_update").attr("src","img/img_nf.png");
	               } else {
					   if (!localStorage.getItem("showgambarbpjs_ket_update") == true) {
	               		$("#showgambarbpjs_ket_update").attr("src","image/"+value.bpjs_ket);
	               		localStorage.setItem("showgambarbpjs_ket_update", $("#showgambarbpjs_ket_update").val())
		               }
	               }
	               
				   	if (!localStorage.getItem("password_update") == true) {
               			$("#password_update").val(value.password);
               			localStorage.setItem("password_update", $("#password_update").val())
	               	}

		            $("#roles_view_update").val(value.roles).prop("readonly", true);
	              	if (!localStorage.getItem("roles_update") == true) {
	               		if ($("#roles_user_update").val() != "") {
			            	localStorage.setItem("roles_update",$("#roles_user_update").val())
			            }else{
			            	localStorage.setItem("roles_update",value.role_id)
			            }
	               	}
		            
		            if (value.id_company == "1") {
		            	
		             	$("#company_view_update").val("SIP").prop("readonly", true);
	               		localStorage.setItem("company_update", 1)
		            }else{
		               	$("#company_view_update").val("MSP").prop("readonly", true);
	               		localStorage.setItem("company_update", 2)

		            }

		            $("#divisi_view_update").val(value.id_division).prop("readonly", true);
	              	if (!localStorage.getItem("divisi_update") == true) {
	               		if ($("#divisi_update").val() != "") {
			            	localStorage.setItem("divisi_update",$("#divisi_update").val())
			            }else{
			            	localStorage.setItem("divisi_update",value.id_division)
			            }
	               	}
		            
		      		$("#sub_divisi_view_update").val(value.id_territory).prop("readonly", true);
	              	if (!localStorage.getItem("sub_divisi_update") == true) {
	               		if ($("#sub_divisi_update").val() != "") {
			            	localStorage.setItem("sub_divisi_update",$("#sub_divisi_update").val())
			            }else{
			            	localStorage.setItem("sub_divisi_update",value.id_division)
			            }
	               	}	      

		       		$("#posisi_view_update").val(value.id_position).prop("readonly", true);
	              	if (!localStorage.getItem("posisi_update") == true) {
	               		if ($("#posisi_update").val() != "") {
			            	localStorage.setItem("posisi_update",$("#posisi_update").val())
			            }else{
			            	localStorage.setItem("posisi_update",value.id_position)
			            }
	               	}           
               
               }
               
            });
          }
        });
        $("#modal_update").modal("show")
        // .modal({
	    //     backdrop: 'static',
	    //     keyboard: false,
	    //     show: true // added property here
    	// });
    }

    function nextPrev(value,n) {
		var x = document.getElementsByClassName("tab");
        x[currentTab].style.display = "none";
        currentTab = currentTab + n;
        if (currentTab >= x.length) {
          x[n].style.display = "none";
          currentTab = 0;
        }

		showEditTab(value,currentTab);
    }

    function nextPrevAdd(n) {
		var x = document.getElementsByClassName("tab-add");

    	x[currentTab].style.display = "none";
		currentTab = currentTab + n;
		if (currentTab >= x.length) {
			// $("#exampleModalCenter").modal('hide');
			x[n].style.display = "none";
			currentTab = 0;
		} 
		showTabAdd(currentTab);
    }

    function submitBtnEmp()
    {
    	Swal.fire({
	      title: 'Update Employee Data',
	      text: "Are you sure?",
	      icon: 'warning',
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
	            url: "{{'/hu_rec/update'}}",
	            type: 'post',
	            // dataType: 'application/json',
	            data: {
	        		"_token": "{{ csrf_token() }}",
	        		nik_update:$("#nik_update").val(),
	        		name_update:localStorage.getItem("name_update"),
	        		date_of_entry_update:localStorage.getItem("date_of_entry_update"),
	        		date_of_birth_update:localStorage.getItem("date_of_birth_update"),
	        		email_update:localStorage.getItem("email_update"),
	        		pend_terakhir_update:localStorage.getItem("pend_terakhir_update"),
	        		tempat_lahir_update:localStorage.getItem("tempat_lahir_update"),
	        		email_personal_update:localStorage.getItem("email_personal_update"),
	        		bpjs_ket_update:$("#bpjs_ket_update").val(),
	        		bpjs_kes_update:$("#bpjs_kes_update").val(),
	        		address_ktp_update:localStorage.getItem("address_ktp_update"),
	        		company_update:$("#company_update").val(),
	        		divisi_update:localStorage.getItem("divisi_update"),//$("#divisi_update").val(),
	        		sub_divisi_update:localStorage.getItem("sub_divisi_update"),//$("#sub_divisi_update").val(),
	        		posisi_update:localStorage.getItem("posisi_update"),//$("#posisi_update").val(),
	        		roles_update:localStorage.getItem("roles_update"),//$("#posisi_update").val(),
	        		address_update:localStorage.getItem("address_update"),
	        		phone_number_update:localStorage.getItem("phone_number_update"),
	        		no_npwp_update:localStorage.getItem("no_npwp_update"),
	        		no_ktp_update:$("#no_ktp_update").val(),
					no_kk_update:$("#no_kk_update").val(),
					no_npwp_update:$("#no_npwp_update").val(),
					name_ec_update:$("#name_ec_update").val(),
					phone_ec_update:$("#phone_ec_update").val(),
					hubungan_ec_update:$("#hubungan_ec_update").val(),
					status_kerja_update:$("#status_kerja_update").val(),
					akhir_kontrak_update:$("#akhir_kontrak_update").val()
	            },
	            success: function(result) {
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

	function submitRegEmp()
	{
		Swal.fire({
	      title: 'Add Employee Data',
	      text: "Are you sure?",
	      icon: 'warning',
	      showCancelButton: true,
	      confirmButtonColor: '#3085d6',
	      cancelButtonColor: '#d33',
	      confirmButtonText: 'Yes',
	      cancelButtonText: 'No',
	    }).then((result) => {
	      if (result.value) {
	        $.ajax({
	            url: "{{'/hu_rec/store'}}",
	            type: 'POST',
				// contentType: "application/json",
				// dataType: "json",
	            data: $("#formAdd").serialize(),
	            beforeSend:function(){
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
	            },
	            // data: JSON.stringify($("#formAdd").serializeArray()),
		        success: function(data) {
		          	Swal.showLoading()
		            Swal.fire(
		              'Add user success!',
		              'Please for new users to try the account that has been created',
		              'sucess'
		            ).then((result) => {
						if (result.value) {
							location.reload()
						}
		            })
		        },
		        error: function(jqXHR,error,errorThrown) {
		        	console.log(jqXHR.status) 
		        	console.log(error) 
		        	// Handle error
	                if (jqXHR.status === 500) {
	                    // Display the custom error message returned from Laravel
	                    const errorMessage = jqXHR.responseJSON.message;
	                    Swal.showLoading()
						Swal.fire(
							error,
							errorMessage,
							'error'
						)
	                }else{
		                var errorMessage = getKeyValueString(jqXHR.responseJSON.errors)

						function getKeyValueString(obj){
							return Object.entries(obj).map(function([key, value]) {
	        					return `${value}`;
	    					});
						}						

						Swal.showLoading()
						Swal.fire(
							jqXHR.responseJSON.message,
							errorMessage.join("<br>"),
							'error'
						)
	                }
	        		 
					// if(jqXHR.status && jqXHR.status == 400){
					// 	Swal.showLoading()
					// 	Swal.fire(
					// 		data.message,
					// 		Object.values(data.errors)[0],
					// 		'error'
					// 	)
					// } else if (jqXHR.status && jqXHR.status == 422){
					// 	var errorMessage = getKeyValueString(jqXHR.responseJSON.errors)

					// 	function getKeyValueString(obj){
					// 		return Object.entries(obj).map(function([key, value]) {
	        		// 			return `${value}`;
	    			// 		});
					// 	}						

					// 	Swal.showLoading()
					// 	Swal.fire(
					// 		jqXHR.responseJSON.message,
					// 		errorMessage.join("<br>"),
					// 		'error'
					// 	)
					// }else{
					// 	alert("Something went wrong");
					// }
				}
				// statusCode: {
				// 	422: function(data,textStatus,jqXHR) {
				// 		Swal.showLoading()
				// 		Swal.fire(
				// 			data.message,
				// 			Object.values(data.errors)[0],
				// 			'error'
				// 		).then((result) => {

				// 		})
				// 		// data=data.message;
				
				// 	}
				// }
	        }); 
	      }    
    	})
	}

  //   $('.btn-editan2').click(function(n){    	
		// var currentTab = 0

		
  //       $.ajax({
  //         type:"GET",
  //         url:"{{url('/hu_rec/get_hu')}}",
  //         data:{
  //           id_hu:this.value,
  //         },
  //         "processing": true,
	 //      "language": {
  //           'loadingRecords': '&nbsp;',
  //           'processing': '<i class="bx bx-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
  //         },
  //         success: function(result){
  
  //           $.each(result[0], function(key, value){
  //              $("#nik_update").val(value.nik).prop("readonly", true);
  //              $("#name_update").val(value.name).prop("readonly", true);
  //              $("#email_update").val(value.email).prop("readonly", true);
  //              $("#date_of_entry_update").val(value.date_of_entry).prop("readonly", true);
  //              $("#date_of_birth_update").val(value.date_of_birth).prop("readonly", true);
  //              $("#akhir_kontrak_update").val(value.akhir_kontrak).prop("readonly", true);
  //              $("#address_update").val(value.address).prop("readonly", true);
  //              $("#phone_number_update").val(value.phone).prop("readonly", true);
  //              $("#no_ktp_update").val(value.no_ktp).prop("readonly", true);
  //              $("#no_kk_update").val(value.no_kk).prop("readonly", true);
  //              $("#no_npwp_update").val(value.no_npwp).prop("readonly", true);
  //              $("#tempat_lahir_update").val(value.tempat_lahir).prop("readonly", true);
  //              $("#email_personal_update").val(value.email_pribadi).prop("readonly", true);
  //              $("#bpjs_ket_update").val(value.bpjs_ket).prop("readonly", true);
  //              $("#bpjs_kes_update").val(value.bpjs_kes).prop("readonly", true);
  //              $("#address_ktp_update").val(value.alamat_ktp).prop("readonly", true);
  //              $("#pend_terakhir_update").val(value.pend_terakhir).prop("readonly", true);
  //              $("#name_ec_update").val(value.name_ec)
  //              $("#phone_ec_update").val(value.phone_ec)
  //              $("#hubungan_ec_update").val(value.hubungan_ec)
  //              if (value.status_kerja == 'Tetap') {
  //              	$("#status_karyawan_update").val("Karyawan Tetap").prop("readonly", true);
  //              }else if (value.status_kerja == 'Kontrak') {
  //              	$("#status_karyawan_update").val("Karyawan Kontrak").prop("readonly", true);
  //              }else{
  //              	$("#status_karyawan_update").val("").prop("readonly", true);
  //              }
  //              if (value.npwp_file == null) {
  //              	$("#showgambarnpwp_update").attr("src","img/img_nf.png");
  //              } else {
  //              	$("#showgambarnpwp_update").attr("src","image/"+value.npwp_file);
  //              }
  //              if (value.ktp_file == null) {
  //              	$("#showgambarktp_update").attr("src","img/img_nf.png");
  //              } else {
  //              	$("#showgambarktp_update").attr("src","image/"+value.ktp_file);
  //              }
  //              if (value.bpjs_kes == null) {
  //              	$("#showgambarbpjs_kes_update").attr("src","img/img_nf.png");
  //              } else {
  //              	$("#showgambarbpjs_kes_update").attr("src","image/"+value.bpjs_kes);
  //              }
  //              if (value.bpjs_ket == null) {
  //              	$("#showgambarbpjs_ket_update").attr("src","img/img_nf.png");
  //              } else {
  //              	$("#showgambarbpjs_ket_update").attr("src","image/"+value.bpjs_ket);
  //              }
               

  //              $("#password_update").val(value.password).prop("readonly", true);
  //              $("#divisi_view_update").val(value.id_division).prop("readonly", true);
  //              $("#subdivisi_view_update").val(value.id_territory).prop("readonly", true);
  //              if (value.id_company == '1') {
  //              	$("#company_view_update").val("SIP").prop("readonly", true);
  //              }else{
  //              	$("#company_view_update").val("MSP").prop("readonly", true);
  //              }
  //              $("#posisi_view_update").val(value.id_position).prop("readonly", true);

               
  //           });

  //         }
  //       }); 
  //       $(".btn-submit-update").hide();
  //       $("#status_kerja_update").hide();
  //       $("#company_update").hide();
  //       $("#divisi_update").hide();
  //       $("#sub_divisi_update").hide();
  //       $("#posisi_update").hide();
  //       $('#div_company_view_update').removeClass('col-md-4');
  //       $('#div_company_view_update').addClass('col-md-8');
  //       $('#div_status_karyawan_update').removeClass('col-md-4');
  //       $('#div_status_karyawan_update').addClass('col-md-8');
  //       $('#div_divisi_view_update').removeClass('col-md-4');
  //       $('#div_divisi_view_update').addClass('col-md-8');
  //       $('#div_subdivisi_view_update').removeClass('col-md-4');
  //       $('#div_subdivisi_view_update').addClass('col-md-8');
  //       $('#div_posisi_view_update').removeClass('col-md-4');
  //       $('#div_posisi_view_update').addClass('col-md-8');
  //       $("#modal_update").modal("show");
  //   });

	$('.btnReset').click(function(){
		var swalAccept = Swal.fire({
	      title: 'Reset Password',
	      text: "Are you sure?",
	      icon: 'warning',
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
	          type:"POST",
	          url:"{{url('resetPassword')}}",
	          data:{
	            "_token": "{{ csrf_token() }}",
	            nik:this.value,
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
	        }) 
	      }        
	    })
	})

    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    });

    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
    $("#alert").slideUp(300);
    });

  	$(document).ready(function(){
    	$('#company').on('change', function() {
         var target=$(this).find(":selected").attr("data-target");
         var id=$(this).attr("id");
        $("div[id^='"+id+"']").hide();
        $("#"+id+"-"+target).show();
        $("#division-director").hide();
        $("#division-specialist").hide();
        $("#division-technical").hide();
        $("#division-sales").hide();
        $("#division-finance").hide();
        $("#division-operation").hide();
        $("#division-hr").hide();
      });
  	});

    $(document).ready(function(){
      $('#division').on('change', function() {
         var target=$(this).find(":selected").attr("data-target");
         var id=$(this).attr("id");
        $("div[id^='"+id+"']").hide();
       $("#"+id+"-"+target).show();
       $("#"+id+"-"+target).show();
      });
  	});

    $(document).ready(function(){
      $('#division-msp').on('change', function() {
         var target=$(this).find(":selected").attr("data-target");
         var id=$(this).attr("id");
        $("div[id^='"+id+"']").hide();
        $("#"+id+"-"+target).show();
      });
  	});

  	$('#division').change(function(){
          $.ajax({
          type:"GET",
          url:'/dropdownTech',
          data:{
            id_assign:this.value,
          },
          success: function(result){
            $('#position-dir').html(append)
            var append = "<option > -- Select Position -- </option>";

            if (result[1] == 'NULL') {
            $.each(result[0], function(key, value){
              append = append + "<option>" + value.name_position + "</option>";
            });
            }

            $('#position-dir').html(append);
          },
      });
  	});

    $('#subdivision-tech').change(function(){
              $.ajax({
              type:"GET",
              url:'/dropdownTech',
              data:{
                id_assign:this.value,
              },
              success: function(result){
                $('#position-tech').html(append)
                var append = "<option> </option>";

                if (result[1] == 'DPG') {
                $.each(result[0], function(key, value){
                  append = append + "<option>" + value.name_position + "</option>";
                });
                } else if (result[1] == 'PRESALES') {
                  $.each(result[0], function(key, value){
                  append = append + "<option>" + value.name_position + "</option>";
                });
                } else if (result[1] == 'DVG') {
                  $.each(result[0], function(key, value){
                  append = append + "<option>" + value.name_position + "</option>";
                });
                } else if (result[1] == 'NONE') {
                  $.each(result[0], function(key, value){
                  append = append + "<option>" + value.name_position + "</option>";
                });
                }


                $('#position-tech').html(append);
              },
        });
    });

  	$('#subdivision-finance').change(function(){
          $.ajax({
          type:"GET",
          url:'/dropdownTech',
          data:{
            id_assign:this.value,
          },
          success: function(result){
            $('#position-finance').html(append)
            var append = "<option > -- Select Position -- </option>";

            if (result[1] == 'FINANCE') {
              $.each(result[0], function(key, value){
              append = append + "<option>" + value.name_position + "</option>";
            });
            } else if (result[1] == 'ACC') {
              $.each(result[0], function(key, value){
              append = append + "<option>" + value.name_position + "</option>";
            });
            } 

            $('#position-finance').html(append);
          },
      });
  	});

  	$('#division').change(function(){
          $.ajax({
          type:"GET",
          url:'/dropdownTech',
          data:{
            id_assign:this.value,
          },
          success: function(result){
            $('#territory-expert-sales').html(append)
            var append = "<option> </option>";

            if (result[1] == 'SPECIALIST') {
            $.each(result[0], function(key, value){
              append = append + "<option>" + value.name_territory + "</option>";
            });
            } 

            $('#territory-expert-sales').html(append);
          },
      });
  	});

  	$('#division').change(function(){
          $.ajax({
          type:"GET",
          url:'/dropdownTech',
          data:{
            id_assign:this.value,
          },
          success: function(result){
            $('#territory-sales').html(append)
            var append = "<option> -- Select Territory </option>";

            if (result[1] == 'SALES') {
            $.each(result[0], function(key, value){
              append = append + "<option>" + value.name_territory + "</option>";
            });
            } 

            $('#territory-sales').html(append);
          },
      });
  	});

  	$('#subdivision-operation').change(function(){
          $.ajax({
          type:"GET",
          url:'/dropdownTech',
          data:{
            id_assign:this.value,
          },
          success: function(result){
            $('#position-operation').html(append)
            var append = "<option > -- Select Position -- </option>";

            if (result[1] == 'MSM') {
	            $.each(result[0], function(key, value){
	              append = append + "<option>" + value.name_position + "</option>";
	            });
            } else if (result[1] == 'PMO') {
              	$.each(result[0], function(key, value){
	              append = append + "<option>" + value.name_position + "</option>";
	            });
            } else if (result[1] == 'SID') {
             //  	$.each(result[0], function(key, value){
	            //   append = append + "<option>" + value.name_position + "</option>";
	            // });
	            append = append + "<option value='MANAGER'> MANAGER </option>";
            	append = append + "<option value='ENGINEER SPV'> ENGINEER SPV </option>";
            	append = append + "<option value='ENGINEER CO-SPV'> ENGINEER CO-SPV </option>";
            	append = append + "<option value='ENGINEER STAFF'> ENGINEER STAFF </option>";
            } else if (result[1] == 'DIR') {
              	$.each(result[0], function(key, value){
	              append = append + "<option>" + value.name_position + "</option>";
	            });
            } else if (result[1] == 'BCD') {
            	append = append + "<option value='MANAGER'> MANAGER </option>";
            	append = append + "<option value='PROCUREMENT'> PROCUREMENT </option>";
            	append = append + "<option value='STAFF'> STAFF </option>";
            	append = append + "<option value='ADMIN'> ADMIN </option>";
            } else if (result[1] == 'DP') {
            	append = append + "<option value='DP'> DP </option>";
            } else {
            	append = append + "<option value='MANAGER'> MANAGER </option>";
            	append = append + "<option value='STAFF'> STAFF </option>";
            	append = append + "<option value='ADMIN'> ADMIN </option>";
            }

            $('#position-operation').html(append);
          },
      });
  	});


  	$('#division').change(function(){
          $.ajax({
          type:"GET",
          url:'/dropdownTech',
          data:{
            id_assign:this.value,
          },
          success: function(result){
            $('#position-hr').html(append)
            var append = "<option > -- Select Position -- </option>";

            if (result[1] == 'HR') {
            $.each(result[0], function(key, value){
              append = append + "<option>" + value.name_position + "</option>";
            });
            }

            $('#position-hr').html(append);
          },
      });
  	});


  	$('#division-msp').change(function(){
          $.ajax({
          type:"GET",
          url:'/dropdownTech',
          data:{
            id_assign:this.value,
          },
          success: function(result){
            $('#position-sales-msp').html(append)
            var append = "<option value=''> -- Select Option --</option>";

            if (result[1] == 'SALES_MSP') {
            $.each(result[0], function(key, value){
              append = append + "<option >" + value.name_position + "</option>";
            });
            } else if (result[1] == 'ADMIN_MSP') {
              $.each(result[0], function(key, value){
              
              append = append + "<option>" + value.name_position + "</option>";
            });
            } else if (result[1] == 'WAREHOUSE_MSP') {
              $.each(result[0], function(key, value){
              
              append = append + "<option>" + value.name_position + "</option>";
            });
            } else if (result[1] == 'OPERATION_MSP') {
              $.each(result[0], function(key, value){
              
              append = append + "<option>" + value.name_position + "</option>";
            });
            } else {
              $.each(result[0], function(key, value){
              
              append = append + "<option>" + value.name_position + "</option>";
            });
            }

            $('#position-sales-msp').html(append);
          },
      });
  	});

  	$('#subdivision-tech-msp').change(function(){
          $.ajax({
          type:"GET",
          url:'/dropdownTech',
          data:{
            id_assign:this.value,
          },
          success: function(result){
            $('#position-tech-msp').html(append)
            var append = "<option value=''> -- Select Option --</option>";

            if (result[1] == 'PRESALES') {
            $.each(result[0], function(key, value){
              append = append + "<option>" + value.name_position + "</option>";
            });
            } else if (result[1] == 'NONE_MSP') {
              $.each(result[0], function(key, value){
              
              append = append + "<option>" + value.name_position + "</option>";
            });
            }

            $('#position-tech-msp').html(append);
          },
      });
  	});

      //update
    $(document).ready(function(){
        $('#company_update').on('change', function() {
             var target=$(this).find(":selected").attr("data-target");
             var id=$(this).attr("id");
        $("div[id^='"+id+"']").hide();
        $("#"+id+"-"+target).show();
        $("#division_update-director").hide();
        $("#division_update-technical").hide();
        $("#division_update-sales").hide();
        $("#division_update-operation").hide();
        $("#division_update-hr").hide();
      });
    });

    $(document).ready(function(){
          $('#division_update').on('change', function() {
             var target=$(this).find(":selected").attr("data-target");
             var id=$(this).attr("id");
            $("div[id^='"+id+"']").hide();
           $("#"+id+"-"+target).show();
           $("#"+id+"-"+target).show();
          });
    });

  	$(document).ready(function(){
      $('#division-msp-update').on('change', function() {
         var target=$(this).find(":selected").attr("data-target");
         var id=$(this).attr("id");
        $("div[id^='"+id+"']").hide();
       $("#"+id+"-"+target).show();
       $("#"+id+"-"+target).show();
      });
  	});

    $('#division_update').change(function(){
        $.ajax({
          type:"GET",
          url:'/dropdownTech',
          data:{
            id_assign:this.value,
          },
          success: function(result){
            $('#position-dir-update').html(append)
            var append = "<option value=''> </option>";

            if (result[1] == 'NULL') {
            $.each(result[0], function(key, value){
              append = append + "<option>" + value.name_position + "</option>";
            });
            }

            $('#position-dir-update').html(append);
          },
      });
    });

    $('#subdivision-tech-update').change(function(){
              $.ajax({
              type:"GET",
              url:'/dropdownTech',
              data:{
                id_assign:this.value,
              },
              success: function(result){
                $('#position-tech-update').html(append)
                var append = "<option value=''> </option>";

                if (result[1] == 'DPG') {
                $.each(result[0], function(key, value){
                  append = append + "<option>" + value.name_position + "</option>";
                });
                } else if (result[1] == 'PRESALES') {
                  $.each(result[0], function(key, value){
                  append = append + "<option>" + value.name_position + "</option>";
                });
                } else if (result[1] == 'DVG') {
                  $.each(result[0], function(key, value){
                  append = append + "<option>" + value.name_position + "</option>";
                });
                } else if (result[1] == 'NONE') {
                  $.each(result[0], function(key, value){
                  append = append + "<option>" + value.name_position + "</option>";
                });
                }


                $('#position-tech-update').html(append);
              },
        });
    });

    $('#subdivision-finance-update').change(function(){
        $.ajax({
          type:"GET",
          url:'/dropdownTech',
          data:{
            id_assign:this.value,
          },
          success: function(result){
            $('#position-finance-update').html(append)
            var append = "<option value=''> </option>";

            if (result[1] == 'FINANCE') {
              $.each(result[0], function(key, value){
              append = append + "<option>" + value.name_position + "</option>";
            });
            } else if (result[1] == 'ACC') {
              $.each(result[0], function(key, value){
              
              append = append + "<option>" + value.name_position + "</option>";
            });
            } 

            $('#position-finance-update').html(append);
          },
        });
    });

    $('#division_update').change(function(){
        $.ajax({
          type:"GET",
          url:'/dropdownTech',
          data:{
            id_assign:this.value,
          },
          success: function(result){
            $('#territory-sales-update').html(append)
            var append = "<option value=''> </option>";

            if (result[1] == 'SALES') {
            $.each(result[0], function(key, value){
              append = append + "<option>" + value.name_territory + "</option>";
            });
            } 

            $('#territory-sales-update').html(append);
          },
        });
    });

    $('#subdivision-operation-update').change(function(){
        $.ajax({
          type:"GET",
          url:'/dropdownTech',
          data:{
            id_assign:this.value,
          },
          success: function(result){
            $('#position-operation-update').html(append)
            var append = "<option value=''> </option>";

            if (result[1] == 'MSM') {
            $.each(result[0], function(key, value){
              append = append + "<option>" + value.name_position + "</option>";
            });
            } else if (result[1] == 'PMO') {
              $.each(result[0], function(key, value){
              
              append = append + "<option>" + value.name_position + "</option>";
            });
            } else if (result[1] == 'DIR') {
              $.each(result[0], function(key, value){
              
              append = append + "<option>" + value.name_position + "</option>";
            });
            }


            $('#position-operation-update').html(append);
          },
        });
    });

    $('#division_update').change(function(){
        $.ajax({
          type:"GET",
          url:'/dropdownTech',
          data:{
            id_assign:this.value,
          },
          success: function(result){
            $('#position-hr-update').html(append)
            var append = "<option > </option>";

            if (result[1] == 'HR') {
            $.each(result[0], function(key, value){
              append = append + "<option>" + value.name_position + "</option>";
            });
            }

            $('#position-hr-update').html(append);
          },
        });
    });

    $('#division-msp-update').change(function(){
        $.ajax({
              type:"GET",
              url:'/dropdownTech',
              data:{
                id_assign:this.value,
              },
              success: function(result){
                $('#position-sales-msp-update').html(append)
                var append = "<option value=''>-- Select Option --</option>";

                if (result[1] == 'SALES_MSP') {
                $.each(result[0], function(key, value){
                  append = append + "<option>" + value.name_position + "</option>";
                });
                } else if (result[1] == 'ADMIN_MSP') {
                $.each(result[0], function(key, value){
                  append = append + "<option>" + value.name_position + "</option>";
                });
                } else if (result[1] == 'WAREHOUSE_MSP') {
                $.each(result[0], function(key, value){
                  append = append + "<option>" + value.name_position + "</option>";
                });
                } else if (result[1] == 'OPERATION_MSP') {
                  $.each(result[0], function(key, value){
                  
                  append = append + "<option>" + value.name_position + "</option>";
                });
                }

                $('#position-sales-msp-update').html(append);
              },
      });
    });

    $('#subdivision-tech-msp_update').change(function(){
        $.ajax({
          type:"GET",
          url:'/dropdownTech',
          data:{
            id_assign:this.value,
          },
          success: function(result){
            $('#position-tech-msp-update').html(append)
            var append = "<option value=''>-- Select Option --</option>";

            if (result[1] == 'PRESALES') {
            $.each(result[0], function(key, value){
              append = append + "<option>" + value.name_position + "</option>";
            });
            } else if (result[1] == 'NONE_MSP') {
            $.each(result[0], function(key, value){
              append = append + "<option>" + value.name_position + "</option>";
            });
            }

            $('#position-tech-msp-update').html(append);
          },
      });
    });
  

    var table1 = $('#data_all').DataTable({
    	"lengthChange": false,
        "paging": true,
        "order": [],
        sDom: 'lrtip',
        "columnDefs": [
	    	{ "orderData": [ 4 ], "targets": 5},
	  	]
    });

  	var table2 = $('#data_all_msp').DataTable({
  		"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

  	var table3 = $('#data_tech').DataTable({
  		"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

  	var table4 = $('#data_finance').DataTable({
  		"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

  	var table5 = $('#data_management').DataTable({
  		"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

  	var table6 = $('#data_operation').DataTable({
  		"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    var table7 = $('#data_resign').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

  	var table9 = $('#data_sales_msp').DataTable({
  		"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

  	var table10 = $('#data_op_msp').DataTable({
  		"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

  	var table11 = $('#data_warehouse_msp').DataTable({
  		"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    var table12 = $('#data_resign_msp').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    var table13 = $('#data_pmo').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    var table14 = $('#data_acc').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    $('#data_fns').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    $('#data_opd').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    $('#data_pos').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    $('#data_ios').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    $('#data_ads').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    $('#data_sci').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    $('#data_ae1').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    $('#data_ae2').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    $('#data_ae3').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    $('#data_pds').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    $('#data_sss').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    $('#data_ssa').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    $('#data_ssd').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

    $('#data_sdc').DataTable({
    	"lengthChange": false,
        "paging": true,
        sDom: 'lrtip',
    });

  	$(".Search").keyup(function(){
      	var dInput = this.value;
      	var dLength = dInput.length;
    	
    	if (dLength < 1) {
    		var value = $(this).val().toLowerCase();
		    $("#all #alls2").filter(function() {
		      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		    });

		    @foreach($division as $datas)
			    $("#{{$datas->id_division}} #alls3").filter(function() {
			      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			    });
		    @endforeach
    	}else{
    		// $("#all").empty();
    		var value = $(this).val().toLowerCase();
		    $("#all #alls2").filter(function() {
		      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		    });

		    @foreach($division as $datas)
			    $("#{{$datas->id_division}} #alls3").filter(function() {
			      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			    });
		    @endforeach

    	}
  	})

  //Pagination
	pageSize = 4;
	incremSlide = 5;
	startPage = 0;
	numberPage = 0;

	var pageCount =  $(".line-content").length / pageSize;
	var totalSlidepPage = Math.floor(pageCount / incremSlide);
	    
	for(var i = 0 ; i<pageCount;i++){
	    $("#pagin").append('<li><a href="#">'+(i+1)+'</a></li> ');
	    if(i>pageSize){
	       $("#pagin li").eq(i).hide();
	    }
	}

	var prev = $("<li/>").addClass("prev").html("Prev").click(function(){
	   startPage-=5;
	   incremSlide-=5;
	   numberPage--;
	   slide();
	});

	prev.hide();

	var next = $("<li/>").addClass("next").html("Next").click(function(){
	   startPage+=5;
	   incremSlide+=5;
	   numberPage++;
	   slide();
	});

	$("#pagin").prepend(prev).append(next);

	$("#pagin li").first().find("a").addClass("current");

	slide = function(sens){
	   $("#pagin li").hide();
	   
	   for(t=startPage;t<incremSlide;t++){
	     $("#pagin li").eq(t+1).show();
	   }
	   if(startPage == 0){
	     next.show();
	     prev.hide();
	   }else if(numberPage == totalSlidepPage ){
	     next.hide();
	     prev.show();
	   }else{
	     next.show();
	     prev.show();
	   }
	   
	    
	}

	showPage = function(page) {
		  $(".line-content").hide();
		  $(".line-content").each(function(n) {
		      if (n >= pageSize * (page - 1) && n < pageSize * page)
		          $(this).show();
		  });        
	}
	    
	showPage(1);
	$("#pagin li a").eq(0).addClass("current");

	$("#pagin li a").click(function() {
		 $("#pagin li a").removeClass("current");
		 $(this).addClass("current");
		 showPage(parseInt($(this).text()));
	});

	function statusSelect(id)
	{
		
		if (id.value == 'Tetap') {
			$("#status_karyawan_update").val("Karyawan Tetap");
		}else if (id.value == 'Kontrak') {
			$("#status_karyawan_update").val("Karyawan Kontrak");
		}else if (id.value == 'Magang') {
			$("#status_karyawan_update").val("Karyawan Magang");
		}else if (id.value == 'Outsource') {
			$("#status_karyawan_update").val("Karyawan Outsource");
		}else{
			$("#status_karyawan_update").val("");
		}
	}

	function companySelect(id)
	{
		
		if (id.value == '1') {
			$('#divisi_update').html(append)
            var append = "<option value=''>-- Select Option --</option>";
            
            //append = append + "<option value='TECHNICAL'>" + "TECHNICAL" + "</option>";
            append = append + "<option value='FINANCE'>" + "FINANCE/ACCOUNTING" + "</option>";
            append = append + "<option value='HR'>" + "HUMAN RESOURCE" + "</option>";
            append = append + "<option value='SALES'>" + "SALES" + "</option>";
            //append = append + "<option value='BCD'>" + "BUSINESS CHANNEL DEV" + "</option>";
            append = append + "<option value='OPERATION'>" + "OPERATION" + "</option>";
            append = append + "<option value=''>" + "NONE" + "</option>";

            $("#company_view_update").val("SIP");

            $('#divisi_update').html(append);		
		}else{
			$('#divisi_update').html(append)
            var append = "<option value=''>-- Select Option --</option>";
            
            append = append + "<option value='SALES'>" + "SALES" + "</option>";
            append = append + "<option value='TECHNICAL'>" + "TECHNICAL" + "</option>";
            append = append + "<option value='OPERATION'>" + "OPERATION" + "</option>";
            append = append + "<option value='ADMIN'>" + "NONE" + "</option>";

            $('#divisi_update').html(append);

            $("#company_view_update").val("MSP");
		}
	}

	function divisiSelect(id)
	{
		
		$('#sub_divisi_update').html(append)

        if (id.value == 'TECHNICAL') {
        	var append = "<option value=''>-- Select Option --</option>";
            
            append = append + "<option value='DPG'>" + "IMPLEMENTATION" + "</option>";
            append = append + "<option value='PRESALES'>" + "PRESALES" + "</option>";
            append = append + "<option value='DVG'>" + "DEVELOPMENT" + "</option>";
            append = append + "<option value=''>" + "NONE" + "</option>";

        }else if(id.value == 'FINANCE'){
        	var append = "<option value=''>-- Select Option --</option>";

            append = append + "<option value='FINANCE'>" + "FINANCE" + "</option>";
            append = append + "<option value='ACC'>" + "ACCOUNTING" + "</option>";	
			
		}else if(id.value == 'OPERATION'){
        	var append = "<option value=''>-- Select Option --</option>";

            append = append + "<option value='SOL'>" + "SOL" + "</option>";	
            append = append + "<option value='PMO'>" + "PMO" + "</option>";	
            append = append + "<option value='SID'>" + "SID" + "</option>";	
            append = append + "<option value='BCD'>" + "BCD" + "</option>";	
            append = append + "<option value='DP'>" + "DP" + "</option>";	
            append = append + "<option value='MSM'>" + "MSM" + "</option>";	        	
            append = append + "<option value='NONE'>" + "NONE" + "</option>";	
			
		}else if(id.value == 'HR'){
			var append = "<option value=''>-- Select Option --</option>";

            append = append + "<option value='VP HUMAN CAPITAL'>" + "VP HUMAN CAPITAL" + "</option>";
    		append = append + "<option value='HR MANAGER'>" + "HR MANAGER" + "</option>";
            append = append + "<option value='HR STAFF'>" + "STAFF HR" + "</option>";
            append = append + "<option value='STAFF GA'>" + "STAFF GA" + "</option>";
            append = append + "<option value='WAREHOUSE'>" + "WAREHOUSE" + "</option>";
            append = append + "<option value='ADMIN'>" + "ADMIN" + "</option>";

		}else if(id.value == 'SALES'){
			var append = "<option value=''>-- Select Option --</option>";
            
            append = append + "<option value='TERRITORY 1'>" + "TERRITORY 1" + "</option>";
            append = append + "<option value='TERRITORY 2'>" + "TERRITORY 2" + "</option>";
            append = append + "<option value='TERRITORY 3'>" + "TERRITORY 3" + "</option>";
            append = append + "<option value='TERRITORY 4'>" + "TERRITORY 4" + "</option>";
            append = append + "<option value='TERRITORY 5'>" + "TERRITORY 5" + "</option>";	
            append = append + "<option value='SALES MSP'>" + "SALES MSP" + "</option>";	
		}

		$('#sub_divisi_update').html(append);

		$('#posisi_update').html(append)

		if(id.value == ''){
			var append = "<option value=''>-- Select Option --</option>";

    		append = append + "<option value='DIRECTOR'>" + "DIRECTOR" + "</option>";

		}else if(id.value == 'WAREHOUSE'){
			var append = "<option value=''>-- Select Option --</option>";

    		append = append + "<option value='MANAGER'>" + "MANAGER" + "</option>";
            append = append + "<option value='STAFF'>" + "STAFF" + "</option>";

            $("#divisi_view_update").val('');
		}else if (id.value == 'HUMAN RESOURCE') {
			var append = "<option value=''>-- Select Option --</option>";

            append = append + "<option value='MANAGER'>" + "MANAGER" + "</option>";
            append = append + "<option value='STAFF'>" + "STAFF" + "</option>";
            append = append + "<option value='ADMIN'>" + "ADMIN" + "</option>";
		}
		$('#posisi_update').html(append);

		$("#divisi_view_update").val($("#divisi_update").val());

		localStorage.setItem("divisi_update", $("#divisi_update").val())
	}

	function subdivisiSelect(id){
		$('#posisi_update').html(append)
        var append = "<option value=''>-- Select Option --</option>";
    	if (id.value == '') {

    		append = append + "<option value='HEAD'>" + "HEAD" + "</option>";
            append = append + "<option value='ADMIN'>" + "ADMIN" + "</option>";

    	}else if(id.value == 'MSM'){

    		append = append + "<option value='MANAGER'>" + "MANAGER" + "</option>";
            append = append + "<option value='ADMIN'>" + "ADMIN" + "</option>";
            // append = append + "<option value='SERVICE PROJECT(HEAD)'>" + "SERVICE PROJECT (HEAD)" + "</option>";
            //append = append + "<option value='SERVICE PROJECT(STAFF)'>" + "SERVICE PROJECT (STAFF)" + "</option>";
            append = append + "<option value='SUPPORT ENGINEER'>" + "SUPPORT ENGINEER" + "</option>";
            append = append + "<option value='SUPPORT ENGINEER SPV'>" + " SUPPORT ENGINEER SPV" + "</option>";
            append = append + "<option value='SUPPORT ENGINEER CO-SPV'>" + " SUPPORT ENGINEER CO-SPV" + "</option>";
            append = append + "<option value='HELP DESK SPV'>" + "HELP DESK SPV" + "</option>";
            append = append + "<option value='HELP DESK'>" + "HELP DESK" + "</option>";
            append = append + "<option value='CALL SO'>" + "CALL SO" + "</option>";

    	}else if (id.value == 'PMO') {
    		append = append + "<option value='MANAGER'>" + "MANAGER" + "</option>";
            append = append + "<option value='PM SPV'>" + "PM SPV" + "</option>";
            append = append + "<option value='PM'>" + "PM" + "</option>";
    		append = append + "<option value='SERVICE PROJECT SPV'>" + "SERVICE PROJECT SPV" + "</option>"
    		append = append + "<option value='SERVICE PROJECT'>" + "SERVICE PROJECT" + "</option>"
            append = append + "<option value='ADMIN'>" + "ADMIN" + "</option>";

    	}else if (id.value == 'OPERATION') {

    		append = append + "<option value='DIRECTOR'>" + "DIRECTOR" + "</option>";

    	}else if (id.value == 'BCD'){
        
            append = append + "<option value='MANAGER'>" + "MANAGER" + "</option>";
            append = append + "<option value='STAFF'>" + "STAFF" + "</option>";
            append = append + "<option value='PROCUREMENT'>" + "PROCUREMENT" + "</option>";
            append = append + "<option value='ADMIN'>" + "ADMIN" + "</option>";

        } else if (id.value == 'SID'){
        
            append = append + "<option value='MANAGER'>" + "MANAGER" + "</option>";
            append = append + "<option value='ENGINEER SPV'>" + "ENGINEER SPV" + "</option>";
            append = append + "<option value='ENGINEER CO-SPV'>" + "ENGINEER CO-SPV" + "</option>";
            append = append + "<option value='ENGINEER STAFF'>" + " ENGINEER STAFF" + "</option>";
            append = append + "<option value='ADMIN'>" + "ADMIN" + "</option>";

        }else if (id.value == 'DP'){
        
            append = append + "<option value='DP'>" + "DP" + "</option>";

        }else{
        
            append = append + "<option value='MANAGER'>" + "MANAGER" + "</option>";
            append = append + "<option value='STAFF'>" + "STAFF" + "</option>";
            append = append + "<option value='ADMIN'>" + "ADMIN" + "</option>";

        }
        
        $('#posisi_update').html(append);

        $("#sub_divisi_view_update").val($("#sub_divisi_update").val());

		localStorage.setItem("sub_divisi_update", $("#sub_divisi_update").val())


    }

    function posisiSelect(id){
    	$("#posisi_view_update").val($("#posisi_update").val());

		localStorage.setItem("posisi_update", $("#posisi_update").val())
    }

    function roleSelect(id){
    	
    	$("#roles_view_update").val($("#roles_user_update option:selected").text());

		localStorage.setItem("roles_update", $("#roles_user_update").val())
    }

    function readURL(input) {
		if (input.files && input.files[0]) {
  			var reader = new FileReader();

  			reader.onload = function (e) {
  				$('#showgambarnpwp_update').attr('src', e.target.result);
  			}

  			reader.readAsDataURL(input.files[0]);
  		}
  	}

  	function readURL(input) {
		if (input.files && input.files[0]) {
  			var reader = new FileReader();

  			reader.onload = function (e) {
  				$('#showgambarktp_update').attr('src', e.target.result);
  			}

  			reader.readAsDataURL(input.files[0]);
  		}
  	}

  	function readURL(input) {
  		if (inpu.files && input.files[0]) {
  			var reader = new FileReader();

  			reader.onload = function (e) {
  				$('#showgambarbpjs_kes_update').attr('src', e.target.result);
  			}

  			reader.readAsDataURL(input.files[0]);
  		}
  	}

  	function readURL(input) {
  		if (inpu.files && input.files[0]) {
  			var reader = new FileReader();

  			reader.onload = function (e) {
  				$('#showgambarbpjs_ket_update').attr('src', e.target.result);
  			}

  			reader.readAsDataURL(input.files[0]);
  		}
  	}

  	$("#inputgambarnpwp_update").change(function () {
  		readURL(this);
  	});

  	$("#inputgambarktp_update").change(function () {
  		readURL(this);
  	});

  	$('#inputgambarbpjs_kes_update').change(function () {
  		readURL(this);
  	});

  	$('#inputgambarbpjs_ket_update').change(function () {
  		readURL(this);
  	});

  	function scrollTabs(distance) {
        document.getElementById("scrollableTabs").scrollLeft += distance;
    }
</script>
@endsection