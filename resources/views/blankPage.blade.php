@extends('template.main_sneat')

{{-- Tittle harus di descripsikan sesuai dengan menu yang di buka --}}
@section('tittle')
Ticketing
@endsection

@section('head_css')
	<style type="text/css">
		/*Buat style bisa mulai di tulis di sini*/
		h1 {
			color: red;
		}
	</style>
	<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
@endsection

@section('content')
	<!-- Content Header bisa di isi dengan Title Menu dan breadcrumb -->
<div class="container-xxl flex-grow-1 container-p-y">
	<section class="content-header">
		<h1>
			Tiltle Menu
		</h1>
		<ol class="breadcrumb">
			<li>
				<a href="{{url('dashboard')}}">
					<i class="fa fa-fw fa-dashboard"></i>Dashboard
				</a>
			</li>
			<li>
				<a href="#">Example Page</a>
			</li>
			<li class="active">
				<a href="{{url('/')}}">Blank Page</a>
			</li>
		</ol>
	</section>

	<!-- Untuk Content bisa dimulai dengan box -->
	<section class="content">
		<div class="box">
			<div class="box-body">
				<h1>This is Box Body</h1>
				<select id="formtabs-country" class="select2 form-select" data-allow-clear="true" style="margin-top: 20px;">
	                <option value="">Select</option>
	                <option value="Australia">Australia</option>
	                <option value="Bangladesh">Bangladesh</option>
	                <option value="Belarus">Belarus</option>
	                <option value="Brazil">Brazil</option>
	                <option value="Canada">Canada</option>
	                <option value="China">China</option>
	                <option value="France">France</option>
	                <option value="Germany">Germany</option>
	                <option value="India">India</option>
	                <option value="Indonesia">Indonesia</option>
	                <option value="Israel">Israel</option>
	                <option value="Italy">Italy</option>
	                <option value="Japan">Japan</option>
	                <option value="Korea">Korea, Republic of</option>
	                <option value="Mexico">Mexico</option>
	                <option value="Philippines">Philippines</option>
	                <option value="Russia">Russian Federation</option>
	                <option value="South Africa">South Africa</option>
	                <option value="Thailand">Thailand</option>
	                <option value="Turkey">Turkey</option>
	                <option value="Ukraine">Ukraine</option>
	                <option value="United Arab Emirates">United Arab Emirates</option>
	                <option value="United Kingdom">United Kingdom</option>
	                <option value="United States">United States</option>
	            </select>
			</div>
		</div> 
	</section>
</div>
@endsection

@section('scriptImport')
    <script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <!-- <script src="{{asset('assets/js/form-layouts.js')}}"></script> -->
@endsection

@section('script')
<script type="text/javascript">
	// Script yang import dari CDN ato Local ada di sini
	console.log('Hi')
	$("#formtabs-country").select2()
</script>
@endsection