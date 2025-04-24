@extends('template.main_sneat')
@section('tittle')
PMO Settlement
@endsection
@section('pageName')
Settlement
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

	.grid-container {
	  display: grid;
	  grid-template-columns: repeat(4, 1fr);
	  gap: 10px; /* Gap between grid items */
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
	  <h6><button class="btn btn-sm text-bg-danger" onclick="btnBack()"><i class="bx bx-chevron-left"></i> Back </button> <span>PMO - Settlement</span></h6>
	</section>
	<section class="content">
		<div class="card">
			<div class="card-body">
				<div class="divPID" data-rowid='0'>
					<div class="row mb-4">
						<div class="col-md-6 col-xs-12">
							<div class="form-group">
								<input type="" name="id_pid" id="id_pid" style="display:none!important;">
								<label>Money Request*</label>
								<select class="form-control input_money_request" name="input_money_request" data-rowid="0" style="width: 100%!important;" onchange="validationCheck(this)">
									<option></option>
								</select>
								<span class="invalid-feedback" style="display:none!important"></span>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="form-group">
								<label>Project ID*</label>
								<select class="form-control input_pid" name="input_pid" data-rowid="0" style="width:100%!important" onchange="validationCheck(this)" disabled>
									<option></option>
								</select>
								<span class="invalid-feedback" style="display:none!important"></span>
							</div>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-md-12">
							<div class="form-group divCheckbox" data-rowid="0">
								<!-- <div style="display:flex;flex-direction:row;gap:30px;"> -->
									<!-- <div class="checkbox" style="margin-top: -5px;">
										<label>
											<input type="checkbox" class="cbCategory" name="cbCategory" value="Transport" data-rowid="0">
											Transport
										</label>
									</div>
									<div class="checkbox">
										<label>
											<input type="checkbox" class="cbCategory" name="cbCategory" value="Allowance/Overtime(KPHL)" data-rowid="0">
											Allowance/Overtime(KPHL)
										</label>
									</div>
									<div class="checkbox">
										<label>
											<input type="checkbox" class="cbCategory" name="cbCategory" value="Entertain" data-rowid="0">
											Entertain
										</label>
									</div>
									<div class="checkbox">
										<label>
											<input type="checkbox" class="cbCategory" name="cbCategory" value="Others" data-rowid="0">
											Others
										</label>
									</div> -->
								<!-- </div> -->
							</div>
						</div>
					</div>	
					<div class="row mb-4 divTabPane" data-rowid="0" style="display: none;">
						<div class="col-md-12 col-xs-12">
							<div class="nav-tabs-custom" data-rowid="0">
							</div>
						</div>
					</div>
				</div>
				<div class="divTabPane" data-rowid="0" style="display:none!important">
					<hr>
					<div class="row mb-4">
						<div class="col-md-12 col-xs-12">
							<div style="display: flex;float: right;gap:5px">
								<a><button class="btn btn-sm text-bg-danger" onclick="btnBack()">Cancel</button></a>
								<button class="btn btn-sm text-bg-primary btnSave">Save</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row mb-4" id="divButtonAddRowPid" style="display:none!important;">
					<div style="text-align:center;margin-top: 20px;">
						<button class="btn btn-sm text-bg-primary" onclick="addRowPID()"><i class="bx bx-plus"></i> Project ID</button>
						<button class="btn btn-sm text-bg-danger" disabled="disabled" id="btnDeleteRowPID" onclick="deleteRowPID()" ><i class="bx bx-trash"></i></button>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
@section('scriptImport')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/jquery.mask.js')}}"></script>
@endsection
@section('script')
	<script type="text/javascript">
    var formatter = new Intl.NumberFormat(['ban', 'id']);

		$(document).ready(function(){
			if (window.location.href.split("/")[5].split("?")[1] != undefined) {
				checkBoxCategorySelected(window.location.href.split("&")[1].split("=")[1])
				$(".input_money_request").prop("disabled",true)
				$(".btnSave").text('Update')
				$(".btnSave").removeClass('text-bg-primary')
				$(".btnSave").addClass('btn-warning')
				$(".btnSave").attr('onclick','updateSettlement()')
				$("#btnCancelEdit").closest("a").attr("href","{{url('/pmo/settlement/detail_settlement?id_settlement=')}}"+window.location.href.split("/")[5].split("?")[1].split("&")[0].split("=")[1])
			}else{
				$('input[type="checkbox"]').prop('checked', false)
				$(".btnSave").removeClass('btn-warning')
				$(".btnSave").addClass('text-bg-primary')
				$("#divButtonAddRowPid").show()
				$(".btnSave").attr('onclick','submitSettlement()')
				initSelect2(0)
			}
		})		

		function initSelect2(i){
			$(".idRole[data-rowid='"+ i +"']").select2({
				placeholder:"Select Name",
				ajax: {
          url: '{{url("/pmo/settlement/getRoleByPid")}}',
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              pid:$(".input_pid[data-rowid='"+ i +"']").val(),
              q:params.term
            };
          },
          processResults: function(data, params) {
            params.page = params.page || 1;
            return {
                results: data,
                pagination: {
                    more: (params.page * 10) < data.count_filtered
                }
            };
          },
        }
			})

			$(".idNameEmployee[data-rowid='"+ i +"']").select2({
				placeholder:"Select Name",
				ajax: {
          url: '{{url("/pmo/settlement/getUser")}}',
          dataType: 'json',
          delay: 250,
          processResults: function(data, params) {
            params.page = params.page || 1;
            return {
                results: data,
                pagination: {
                    more: (params.page * 10) < data.count_filtered
                }
            };
          },
        }
			})

			let id_monreq = ''

			$(".input_money_request[data-rowid='"+ i +"']").select2({
				placeholder:"Select Money Request",
				ajax: {
          url: '{{url("/pmo/settlement/getMonReqforSettlement")}}',
          dataType: 'json',
          delay: 250,
          processResults: function(data, params) {
            params.page = params.page || 1;
            return {
                results: data,
                pagination: {
                    more: (params.page * 10) < data.count_filtered
                }
            };
          },
        }
			}).on("select2:select",function(e){
				id_monreq = e.params.data.id

				if (id_monreq != "") {
					$(".input_pid[data-rowid="+ i +"]").prop("disabled",false)		
					$(".divCheckbox[data-rowid="+ i +"]").empty("")		
					$(".divTabPane[data-rowid="+ i +"]").attr('style','display:none!important')	
					$(".divTabPane:nth-child(2)").attr('style','display:none!important') 	
				}
			})

			$(".input_pid[data-rowid='"+ i +"']").select2({
				placeholder:"Select Project ID",
				ajax: {
          url: '{{url("/pmo/settlement/getPIDforSettlement")}}',
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              id_money_request:$(".input_money_request").val(),
              q:params.term
            };
          },
          processResults: function(data, params) {
            params.page = params.page || 1;
            return {
                results: data,
                pagination: {
                    more: (params.page * 10) < data.count_filtered
                }
            };
          },
        }
			}).on('select2:select', function (e) {
				$(".divCheckbox[data-rowid="+ i +"]").empty("")		
				$(".divTabPane[data-rowid="+ i +"]").attr('style','display:none!important')	
				$(".divTabPane:nth-child(2)").attr('style','display:none!important') 	
				initCheckboxCategory(i,e.params.data.id,$(".input_money_request[data-rowid='"+ i +"']").val())
			})
		}

		function addRowItem(n,key,value){
			var count = $('.tab-content[data-rowid="'+ n +'"] .tab-pane.'+ value +' .divContent_'+ value +'[data-rowid="'+ n +'"]').length

			++count

			var append = ""
			//konten
				append = append + '<div class="body_content_'+ value + ' divContent_'+ value +'" data-id="'+ n + '_'+ key +'" data-rowid="'+ n +'">'
					append = append + '<div class="row mb-4">'
						append = append + '<div class="col-md-3">'
							append = append + '<div class="form-group">'
							append = append + '<label>'+ value.replace(/([A-Z])/g, ' $1') +'*</label>'
								append = append + '<select class="form-control select_category_'+ value + '" style="width:100%!important" id="select_category" data-rowid="'+ count +'" name="select_category" data-id="'+ n + "_" + count +'"><option></option></select>'
								if (value == "Others") {
							  	append = append + '<a style="cursor:pointer" onclick="initFormCategory('+ "'" + 'Others' + "'" + ','+ "'" + 'Others' + "'" + ','+n+','+key+','+count+','+ false +')">reset category</a>'
							  }
							append = append + '</div>'
						append = append + '</div>'
						append = append + '<div class="col-md-9">'
							append = append + '<div class="row mb-4 divFormCategory'+ value.replaceAll(" ", "") + n + '_'+ count +'" data-id="'+ n + '_'+ count +'" data-rowid="'+ n +'">'
								append = append + '</div>'	
						append = append + '</div>'
					append = append + '</div>'
				append = append + '</div>'
			//
			$(".divContent_"+ value + '[data-rowid="'+ n +'"]:last').after(append)

			if (value == 'Transport') {
				detail_category = 'Toll'
			}else if (value == 'Entertainment' || value == 'CommunicationPlan'){
				detail_category = 'Struk Manual'
			}else if (value == 'Allowance'){
				detail_category = 'Allowance'
			}else{
				detail_category = 'Others'
			}
			initFormCategory(value,detail_category,n,key,count,false)
			initSelect2(count)
		}

		function deleteRowItem(elements){
			$(elements).closest(".row").closest(".col-md-9").closest(".row").remove()
		}

		function addRowPID(){
			var count = $(".divPID").length
			var append = ''

			append = append + '<hr>'
			append = append + '<div class="divPID" data-rowid="'+ count+'">'
				append = append + '<div class="row mb-4">'
					append = append + '<div class="col-md-6 col-xs-12">'
						append = append + '<div class="form-group">'
							append = append + '<label>Money Request*</label>'
								append = append + '<select class="form-control input_money_request" name="input_money_request" data-rowid="'+ count +'" style="width:100%!important;" onchange="validationCheck(this)">'
								append = append + '<option></option>'
							append = append + '</select>'
							append = append + '<span class="invalid-feedback" style="display:none!important"></span>'
						append = append + '</div>'
					append = append + '</div>'
					append = append + '<div class="col-md-6 col-xs-12">'
						append = append + '<div class="form-group">'
							append = append + '<label>Project ID*</label>'
							append = append + '<select class="form-control input_pid" name="input_pid" data-rowid="'+ count +'" style="width:100%!important" onchange="validationCheck(this)" disabled>'
								append = append + '<option></option>'
							append = append + '</select>'
							append = append + '<span class="invalid-feedback" style="display:none!important"></span>'
						append = append + '</div>'
					append = append + '</div>'
				append = append + '</div>'
				append = append + '<div class="row mb-4">'
					append = append + '<div class="col-md-12">'
						append = append + '<div class="form-group divCheckbox" data-rowid="'+ count +'">'
						append = append + '</div>'
					append = append + '</div>'
				append = append + '</div>	'
				append = append + '<div class="row mb-4 divTabPane" style="display: none;" data-rowid="'+count +'">'
					append = append + '<div class="col-md-12 col-xs-12">'
						append = append + '<div class="nav-tabs-custom" data-rowid="'+ count +'">'
						append = append + '</div>'
					append = append + '</div>'
				append = append + '</div>'
			append = append + '</div>'

			$(".divPID:last").after(append)

			if ($(".divPID").length > 1) {
				$("#btnDeleteRowPID").prop("disabled",false)
			}else{
				$("#btnDeleteRowPID").prop("disabled",true)
			}

			initSelect2(count)
		}

		function deleteRowPID(){
			$(".divPID:last").prev('hr').remove()
			$(".divPID:last").remove()

			if ($(".divPID").length > 1) {
				$("#btnDeleteRowPID").prop("disabled",false)
			}else{
				$("#btnDeleteRowPID").prop("disabled",true)	
			}
		}

		function initCheckboxCategory(n,pid,id_money_request){
			$.ajax({
				type:"GET",
				url:"{{url('/pmo/settlement/getCheckCategory')}}",
				data:{
					pid:pid,
					id_money_request:id_money_request
				},
				success:function(result){
					$(".divCheckbox[data-rowid="+ n +"]").empty("")
					var append = ""
					append = append + '<label>Check Category</label>'
						append = append + '<div class="form-group" style="display:flex;flex-direction:row;gap:30px;">'
							$.each(result.data,function(key,value){
								console.log("berapa kali return")
								if (key == 0) {
								append = append + '<div class="checkbox">'
								}else{
								append = append + '<div class="checkbox" style="margin-top:10px">'
								}
									append = append + '<label>'
										append = append + '<input type="checkbox" class="cbCategory" name="cbCategory" value="'+ value.category +'" data-rowid="'+ n +'">'
										append = append + value.category
									append = append + '</label>'
								append = append + '</div>'
							})

							if (result.isMonreq) {
								append = append + '<div class="checkbox" style="margin-top:10px">'
									append = append + '<label>'
										append = append + '<input type="checkbox" class="cbCategory" name="cbCategory" value="Others" data-rowid="'+ n +'">'
										append = append + 'Others'
									append = append + '</label>'
								append = append + '</div>'
							}

						append = append + '</div>' 

					$(".divCheckbox[data-rowid="+ n +"]").append(append)
					
					let nPosition = "arr"+n, arrCategory = {[nPosition]:[]};

					$(".cbCategory[data-rowid='"+ n +"']").click(function(value){
						//show or hide tab pane
						// if ($(".cbCategory[data-rowid='"+ n +"']:checked").length <= 0) {
						// 	$(".divTabPane[data-rowid='"+ n +"']").attr('style','display:none!important')
						// }else{
						// 	$(".divTabPane[data-rowid='"+ n +"']").show()
						// }

						if (arrCategory[nPosition].indexOf($(this).val()) === -1) {
						  arrCategory[nPosition].push($(this).val())
						}			

						if ($(this).is(":checked")) {
							console.log("siniii")
							initCheckbox(n,this.value,arrCategory)
							$(".divTabPane[data-rowid='"+ n +"']").show()
							if (result.isMonreq == false) {
								$(".divWarningPid[data-rowid="+ n +"]").show()
							}
						}else{
							Swal.fire({
			            title: 'Are you Sure?',
			            text: 'If you uncheck this, you will lost all data!',
			            icon: 'warning', // You can also use 'success', 'warning', 'error', or 'question'
			            confirmButtonText: 'Okay',
			            cancelButtonText: 'Cancel',
			            showCancelButton: true,
			            allowOutsideClick: false
			        }).then((result)=>{
			        	if (result.value) {
									initCheckbox(n,this.value,arrCategory,'none')
			        	}else{
			        		$(this).prop('checked',true)
			        		Swal.close()
			        	}
			        });
						}
					})
				}
			})
		}
		
		function initCheckbox(i,values,arrCategory,status){
			let type = 'text', triggerValidation = ''
			if (!$(".nav-tabs-custom[data-rowid='"+ i +"']").is(":visible")) {
				$(".nav-tabs-custom[data-rowid='"+ i +"']").empty('')
			}

			var append = '', appendChildTab = '', appendChildContent = '', dataIdRow = ''

			append = append + '<ul class="nav nav-tabs" data-rowid="'+ i +'">'
			arrCategory["arr"+i].forEach((value, key) => {
				if (values == value) {
					if (key == 0) {
						append = append + '<li class="nav-item"><a href="#tab'+ i + '_'+ key +'" class="tab'+ i + '_'+ key + ' ' + value.replaceAll(" ","") +' nav-link active" data-bs-toggle="tab" data-rowid="'+ i +'">'+ value +'</a></li>'
					}
				}
			})
			append = append + '</ul>'
			append = append + '<div class="tab-content" data-rowid="'+ i +'">'

			arrCategory["arr"+i].forEach((value, key) => {
				if (values == value) {
					if (key == 0) {
						append = append + '<div class="tab-pane '+ value.replaceAll(" ","") +' show active" id="tab'+ i + '_'+ key +'"  data-rowid="'+ i +'">'
							if (values == 'Others') {
								append = append + '<div class="alert alert-danger">Warning! You add unplanned category</div>'
							}else{
								append = append + '<div class="alert alert-danger divWarningPid" data-rowid="'+ i +'" style="display:none!important">Warning! This category from PID non monreq</div>'
							}
							//konten
							append = append + '<div class="body_content_'+ value.replaceAll(" ","") + ' divContent_'+ value.replaceAll(" ","") +'" data-rowid="'+ i +'" data-id="'+ i + '_'+ 0 +'">'
								append = append + '<div class="row mb-4">'
									append = append + '<div class="col-md-3 col-xs-12">'
										append = append + '<div class="form-group">'
											append = append + '<label>'+ value +'*</label>'
											append = append + '<select class="form-control select_category_'+ value.replaceAll(" ","") +'" style="width:100%!important;" id="select_category" name="select_category" data-rowid="'+ i +'" data-id="'+ i + "_" + key +'"><option></option></select>'
											if (value == "Others") {
										  	append = append + '<a style="cursor:pointer" onclick="initFormCategory('+ "'" + 'Others' + "'" + ','+ "'" + 'Others' + "'" + ','+i+','+key+','+ false +')">reset category</a>'
										  }
										append = append + '</div>'
									append = append + '</div>'
									append = append + '<div class="col-md-9 col-xs-12">'

									append = append + '<div class="row mb-4 divFormCategory'+ value.replaceAll(" ","") + i + '_'+ 0 +'" data-id="'+ i + '_'+ 0 +'" data-rowid="'+ i +'">'

											if (value == 'Transport') {
												detail_category = 'Toll'
											}else if (value == 'Entertainment'){
												detail_category = 'Struk Manual'
											}else if (value == 'Allowance'){
												detail_category = 'Allowance'
											}else{
												detail_category = 'Others'
											}

											initFormCategory(value,detail_category,i,key,false)
										append = append + '</div>'														
									append = append + '</div>'
								append = append + '</div>'
							append = append + '</div>'
							//total
							append = append + '<div class="row mb-4">'
								append = append + '<div class="col-md-10" style="width:81%">'
									append = append + '<label class="pull-right" style="margin-top:5px">Total</label>'
								append = append + '</div>'
								append = append + '<div class="col-md-3 pull-right" style="width:19%">'
									append = append + '<input class="form-control inputTotalPid" data-id="'+ i + "_" + key +'" data-rowid="'+ i +'" disabled>'
								append = append + '</div>'
							append = append + '</div>'
							//	
							append = append + '<div class="row mb-4">'
								append = append + '<div style="text-align: center;">'
										append = append + '<button class="btn btn-sm text-bg-primary" style="text-align: center;" onclick="addRowItem('+ i +','+ key +','+ "'" + value.replaceAll(" ","") + "'"+')"><i class="bx bx-plus"></i> Sub Category</button>'
								append = append + '</div>'
							append = append + '</div>'								
					}
				}
					append = append + '</div>'						
			})
			append = append + '</div>'

			if (!$(".nav-tabs-custom[data-rowid='"+ i +"']").is(":visible")) {
				$(".nav-tabs-custom[data-rowid='"+ i +"']").append(append)
			}

			arrCategory["arr"+i].forEach((value, key) => {
				if (values == value) {
						appendChildTab = appendChildTab + '<li><a href="#tab'+ i + '_'+ key +'" class="tab'+ i + '_'+ key + ' ' + value.replaceAll(" ","") +'" data-bs-toggle="tab" data-rowid="'+ i +'">'+ value +'</a></li>'

						appendChildContent = appendChildContent + '<div class="tab-pane '+ value.replaceAll(" ","") +'" id="tab'+ i + '_'+ key +'" data-rowid="'+ i +'">'

						if (values == 'Others') {
							appendChildContent = appendChildContent + '<div class="alert alert-danger">Warning! You add unplanned categories</div>'
						}else{
							appendChildContent = appendChildContent + '<div class="alert alert-danger divWarningPid" data-rowid="'+ i +'" style="display:none!important">Warning! This category from PID non monreq</div>'
						}
						//konten
						appendChildContent = appendChildContent + '<div class="row mb-4 body_content_'+ value.replaceAll(" ","") +' divContent_'+ value.replaceAll(" ","") +'" data-rowid="'+ i +'" data-id="'+ i + '_'+ 0 +'">'
							appendChildContent = appendChildContent + '<div class="col-md-3 col-xs-12">'
								appendChildContent = appendChildContent + '<div class="form-group">'
								appendChildContent = appendChildContent + '<label>'+ value +'*</label>'
									appendChildContent = appendChildContent + '<select class="form-control select_category_'+ value.replaceAll(" ","") +'" data-rowid="'+ i +'" style="width:100%!important" id="select_category" name="select_category" data-id="'+ i + "_" + key +'"><option></option></select>'
									if (value == "Others") {
								  	appendChildContent = appendChildContent + '<a style="cursor:pointer" onclick="initFormCategory('+ "'" + 'Others' + "'" + ','+ "'" + 'Others' + "'" + ','+i+','+key+','+ false +')">reset category</a>'
								  }
								appendChildContent = appendChildContent + '</div>'
							appendChildContent = appendChildContent + '</div>'
							//buat content tengah
							appendChildContent = appendChildContent + '<div class="col-md-9 col-xs-12">'
								// appendChildContent = appendChildContent + '<div style="display:flex;flex-direction:row;gap:15px;">'
								// appendChildContent = appendChildContent + '<div class="grid-container">'
								appendChildContent = appendChildContent + '<div class="row mb-4 divFormCategory'+ value.replaceAll(" ","") + i + '_'+ 0 +'" data-rowid="'+ i +'" data-id="'+ i + '_'+ 0 +'">'

									if (value == 'Transport') {
										detail_category = 'Toll'
									}else if (value == 'Entertainment'){
										detail_category = 'Struk Manual'
									}else if (value == 'Allowance'){
										detail_category = 'Allowance'
									}else{
										detail_category = 'Others'
									}

									initFormCategory(value,detail_category,i,key,false)
								appendChildContent = appendChildContent + '</div>'								
								// appendChildContent = appendChildContent + '</div>'
							appendChildContent = appendChildContent + '</div>'
							//
						appendChildContent = appendChildContent + '</div>'
						//

						//total
						appendChildContent = appendChildContent + '<div class="row mb-4">'
							appendChildContent = appendChildContent + '<div class="col-md-10" style="width:81%">'
								appendChildContent = appendChildContent + '<label class="pull-right" style="margin-top:5px">Total</label>'
							appendChildContent = appendChildContent + '</div>'
							appendChildContent = appendChildContent + '<div class="col-md-3 pull-right" style="width:19%">'
								appendChildContent = appendChildContent + '<input class="form-control inputTotalPid" data-id="'+ i + "_" + key +'" data-rowid="'+ i +'" disabled>'
							appendChildContent = appendChildContent + '</div>'
						appendChildContent = appendChildContent + '</div>'

						// 	appendChildContent = appendChildContent + '<div class="pull-right" style="margin-right:15px;display:flex">'
						// 		appendChildContent = appendChildContent + '<label>Total</label>'
						// 		appendChildContent = appendChildContent + '<input class="form-control" style="margin-left:30px;width:240px">'
						// 	appendChildContent = appendChildContent + '</div>'
						// appendChildContent = appendChildContent + '</div>'
						//

						appendChildContent = appendChildContent + '<div class="row mb-4">'
						appendChildContent = appendChildContent + '<div style="text-align: center;">'
								appendChildContent = appendChildContent + '<button class="btn btn-sm text-bg-primary" style="text-align: center;" onclick="addRowItem('+ i +','+ key + ',' +"'" + value.replaceAll(" ","") + "'"+')"><i class="bx bx-plus"></i> Sub Category</button>'
							appendChildContent = appendChildContent + '</div>'
						appendChildContent = appendChildContent + '</div>'

						appendChildContent = appendChildContent + '</div>'	
				}
			})

			if (status == "none") {
				if ($(".nav-tabs-custom[data-rowid='0']").find("ul li").length > 1) {
					$(".divTabPane[data-rowid='"+ i +"']").find('.'+ values.replaceAll(" ","") +'[data-rowid='+ i +']').closest('li').remove()
					$(".divTabPane[data-rowid='"+ i +"']").find('.'+ values.replaceAll(" ","") +'[data-rowid='+ i +']').closest('li').remove()
					$(".divTabPane[data-rowid='"+ i +"']").find('div.'+ values.replaceAll(" ","") +'[data-rowid='+ i +']').remove()
				}else{
					$(".divTabPane[data-rowid='"+ i +"']").find('.'+ values.replaceAll(" ","") +'[data-rowid='+ i +']').closest('li').attr('style','display:none!important')
					$(".divTabPane[data-rowid='"+ i +"']").find('.'+ values.replaceAll(" ","") +'[data-rowid='+ i +']').closest('li').removeClass('active')
					$(".divTabPane[data-rowid='"+ i +"']").find('div.'+ values.replaceAll(" ","") +'[data-rowid='+ i +']').removeClass('active')
					if ($(".divTabPane[data-rowid='"+ i +"']").find('a[data-rowid='+ i +']:visible').length == 1) {
						$(".divTabPane[data-rowid='"+ i +"']").find('a[data-rowid='+ i +']:visible').closest("li").addClass('active')
						$($(".divTabPane[data-rowid='"+ i +"']").find('a[data-rowid='+ i +']:visible').attr('href')).addClass('active')
					}
				}
			}else{
				if ($(".nav-tabs-custom[data-rowid='"+ i +"']").is(":visible")) {
					if ($(".divTabPane[data-rowid='"+ i +"']").find('.'+ values.replaceAll(" ","") +'[data-rowid='+ i +']').length == 0) {
						$(".nav-tabs[data-rowid='"+ i +"'] li:last").after(appendChildTab)
						$(".tab-content[data-rowid='"+ i +"'] .tab-pane:last").after(appendChildContent)

						if ($(".divTabPane[data-rowid='"+ i +"']").find('a[data-rowid='+ i +']:visible').length == 1) {
							$(".divTabPane[data-rowid='"+ i +"']").find('.'+ values.replaceAll(" ","") +'[data-rowid='+ i +']').closest('li').show()
							$(".divTabPane[data-rowid='"+ i +"']").find('.'+ values.replaceAll(" ","") +'[data-rowid='+ i +']').closest('li').addClass('active')
							$(".divTabPane[data-rowid='"+ i +"']").find('div.'+ values.replaceAll(" ","") +'[data-rowid='+ i +']').addClass('active')
						}
					}else{
						if ($(".divTabPane[data-rowid='"+ i +"']").find('a[data-rowid='+ i +']:visible').length == 0) {							
							$(".divTabPane[data-rowid='"+ i +"']").find('.'+ values.replaceAll(" ","") +'[data-rowid='+ i +']').closest('li').show()
							$(".divTabPane[data-rowid='"+ i +"']").find('.'+ values.replaceAll(" ","") +'[data-rowid='+ i +']').closest('li').addClass('active')
							$(".divTabPane[data-rowid='"+ i +"']").find('div.'+ values.replaceAll(" ","") +'[data-rowid='+ i +']').addClass('active')
						}else{
							$(".divTabPane[data-rowid='"+ i +"']").find('.'+ values.replaceAll(" ","") +'[data-rowid='+ i +']').closest('li').show()
						}

					}
				}
			}	
		}

		let isRequestInProgress = false,hasNewAjaxBeenCalled = false; 
		function initFormCategory(value,detail_category,i,key,countRow,isSubCat){
			if (detail_category == 'Allowance' || detail_category == 'KPHL') {
				category = 'Allowance'
				detail_category = 'Allowance'
			}if (detail_category == 'Transport') {
				category = 'Transport'
				detail_category = 'Toll'
			}else if(detail_category == 'Communication Plan' || detail_category == 'Struk Manual' || detail_category == 'Struk Digital'){
				category = 'Entertainment'
				if (detail_category == 'Communication Plan') {
					detail_category = 'Struk Manual'
				}else { 
					detail_category = detail_category
				}
			}else{
				if (detail_category == "Allowance") {
					category = "Allowance"
				}else{
					category = value
				}
			}
			if (isRequestInProgress) return;

      isRequestInProgress = true; // Set the flag
      $.ajax({
				type:"GET",
				url:"{{url('/pmo/settlement/getCategorySettlement')}}",
				data:{
					category:category,
					detail_category:detail_category,
					id_money_request:$(".input_money_request[data-rowid="+ i +"]").val(),
					pid:$(".input_pid[data-rowid="+ i +"]").val()
				},
				success:function(result) {
					console.log(detail_category)

					let append = '', select2Form = '', divFormCat = '', bodyContent = '', dataId = ''

					bodyContent = $(".body_content_"+value.replaceAll(" ", "")+"[data-rowid="+ i +"]").attr("data-id")					

					if (countRow) {
						select2Form = $(".select_category_"+ value.replaceAll(" ", "") +"[data-id='"+ i + "_" + countRow +"']")
						divFormCat = $(".divFormCategory"+ value.replaceAll(" ", "") + i + '_' + countRow)
						dataId = i + "_" + key
					}else{
						select2Form = $(".select_category_"+ value.replaceAll(" ", "") +"[data-id='"+ i + "_" + key +"']")
						divFormCat = $(".divFormCategory"+ value.replaceAll(" ", "") + bodyContent)
						dataId = i + "_" + key
					}
					// select2Form = $(".select_category[data-rowid='"+ i +"']")
					// divFormCat = $(".divFormCategory"+ value.replaceAll(" ", "") + '_'+ i + '_'+ key)
			    $(select2Form).empty('')

			    if (isSubCat) {
			    	detail_category = localStorage.getItem('detail_category')
			    }else{
			    	detail_category = detail_category
			    }

			    console.log(result.category)

					select2Form.select2({
						data:result.category,
						placeholder:"Select Category",
						allowClear:true
					}).on('select2:select', function (e) {
						console.log(e.params.data.id)
						if (!hasNewAjaxBeenCalled) {
              hasNewAjaxBeenCalled = true;
              arraySubCat = ['Toll','Gasoline','Parking','Online Transport','Struk Manual','Struk Digital','Others','KPHL']
              if (arraySubCat.includes(e.params.data.id)) {
              	isSubCat = true
              	localStorage.setItem('detail_category',e.params.data.id)
              }else{
              	isSubCat = false
              }
							initFormCategory(value,e.params.data.id,i,key,countRow,isSubCat)
						}
					}).val(detail_category).trigger("change")

					divFormCat.empty("")

					$.each(result.detailCategory,function(keyData,valueData){
						$.each(valueData,function(keyValue,dataValue){
							let element = dataValue.element

							if (keyValue == 3) {
								append = append + '<div class="col-md-3">'
									append = append + '<div class="form-group">'
										
											append = append + 	'<label>'+ dataValue.title +'*</label>'

										if (dataValue.type == 'file' || dataValue.type == 'date') {
											triggerValidation = 'onchange="validationCheck(this,'+ i +')"'
										}else if (dataValue.type == 'text') {
											if (element == 'select') {
												triggerValidation = 'onchange="validationCheck(this,'+ i +')"'
											}else{
												triggerValidation = 'onkeyup="validationCheck(this,'+ i +')"'
											}
										}

										append = append + '<div class="row mb-4">'
											append = append + '<div class="col-md-10">'
												if (element == 'select') {
													append = append + 	'<select class="form-control '+ dataValue.id_input +'" type="'+ dataValue.type +'" id="'+ dataValue.id_input +'" name="'+ dataValue.id_input +'" '+ triggerValidation +' data-rowid="'+ key +'" style="width:100%!important" data-id="'+ dataId +'"></select>'
												}else if(element == 'textarea'){
													append = append + 	'<textarea class="form-control '+ dataValue.id_input +'" type="'+ dataValue.type +'" id="'+ dataValue.id_input +'" name="'+ dataValue.id_input +'" '+ triggerValidation +' data-rowid="'+ key +'" style="width:100%!important" data-id="'+ dataId +'"></textarea>'
												}else{
													if (dataValue.id_input == 'idNominal') {
														var disabled = "disabled"
														if (detail_category == 'Allowance') {
															disabled = disabled
														}else{
															disabled = ""
														}
														append = append + 	'<input class="form-control '+ dataValue.id_input +' money" type="'+ dataValue.type +'" id="'+ dataValue.id_input +'" name="'+ dataValue.id_input +'" '+ triggerValidation +' data-rowid="'+ key +'" data-id="'+ dataId +'" style="width:100%!important" '+ disabled +'>'
													}
												}
											append = append + '</div>'

											append = append + '<div class="col-md-2">'
												if (countRow) {
													append = append + '<button class="btn btn-sm btn-danger" style="float:inline-end" onclick="deleteRowItem(this)"><i class="bx bx-trash"></i></button>'
												}else{
													append = append + '<button disabled class="btn btn-sm btn-danger" style="float:inline-end"><i class="bx bx-trash"></i></button>'
												}
											append = append + '</div>'

											append = append + 	'<span class="invalid-feedback" style="display:none!important;margin-right:18px;padding-left:15px">Help block with error</span>'
										append = append + '</div>'										
									append = append + '</div>'
								append = append + '</div>'
							}else{
								append = append + '<div class="col-md-3">'
									append = append + '<div class="form-group">'
										
										if (dataValue.id_input == 'idReceiptGrab') {
											append = append + 	'<label>'+ dataValue.title +'</label>'
										} else {
											append = append + 	'<label>'+ dataValue.title +'*</label>'
										}

										if (dataValue.type == 'file' || dataValue.type == 'date') {
											triggerValidation = 'onchange="validationCheck(this,'+ i +')"'
										}else if (dataValue.type == 'text') {
											if (element == 'select') {
												triggerValidation = 'onchange="validationCheck(this,'+ i +')"'
											}else{
												triggerValidation = 'onkeyup="validationCheck(this,'+ i +')"'
											}
										}

										if (element == 'select') {
											append = append + 	'<select class="form-control '+ dataValue.id_input +'" type="'+ dataValue.type +'" id="'+ dataValue.id_input +'" name="'+ dataValue.id_input +'" '+ triggerValidation +' data-rowid="'+ i +'" style="width:100%!important" data-id="'+ dataId +'"></select>'
										}else if(element == 'textarea'){
											append = append + 	'<textarea class="form-control '+ dataValue.id_input +'" type="'+ dataValue.type +'" id="'+ dataValue.id_input +'" name="'+ dataValue.id_input +'" '+ triggerValidation +' data-rowid="'+ i +'" style="width:100%!important" data-id="'+ dataId +'"></textarea>'
										}else{
											if (dataValue.id_input == 'idNominal') {
												append = append + 	'<input class="form-control '+ dataValue.id_input +' money" type="'+ dataValue.type +'" id="'+ dataValue.id_input +'" name="'+ dataValue.id_input +'" '+ triggerValidation +' data-rowid="'+ i +'" data-id="'+ dataId +'" style="width:100%!important"></select>'
											}else{
												append = append + 	'<input class="form-control '+ dataValue.id_input +'" type="'+ dataValue.type +'" id="'+ dataValue.id_input +'" name="'+ dataValue.id_input +'" '+ triggerValidation +' data-rowid="'+ i +'" style="width:100%!important" data-id="'+ dataId +'"></select>'
											}
										}
										
										append = append + 	'<span class="invalid-feedback" style="display:none!important">Help block with error</span>'
									append = append + '</div>'
								append = append + '</div>'
							}
							
						})
					})
					
					divFormCat.append(append)		
					initSelect2(i)	
    			$('.money').mask('#.##0', {reverse: true})		
				}, 
				complete: function () {
          isRequestInProgress = false; // Reset the flag when done
          hasNewAjaxBeenCalled = false; // Reset the new AJAX flag after the request is complete
        }
			})
			
		}

		function contentCheckboxSelected(i,key,categories,sub_category){
			if (!$(".nav-tabs-custom[data-rowid='"+ i +"']").is(":visible")) {
				$(".nav-tabs-custom[data-rowid='"+ i +"']").empty('')
			}

			var append = '', active = '', appendChildTab = '', appendChildContent = '', categoryEdit = window.location.href.split("&")[2].split("=")[1], triggerValidation = '', selectValue = "", optionValue = ""

			if (categories == categoryEdit) {
				active = 'active'
			}else{
				active = active
			}

			$("#id_pid").val(sub_category.id_pid)

			if(key == 0){
				append = append + '<ul class="nav nav-tabs" data-rowid="'+ key +'">'
					append = append + '<li class="nav-item"><a href="#tab'+ i + '_'+ key +'" class="tab'+ i + '_'+ key + ' ' + categories.split("/")[0] +' nav-link active" data-bs-toggle="tab" data-rowid="'+ key +'">'+ categories +'</a></li>'
					append = append + '</ul>'
				append = append + '<div class="tab-content" data-rowid="'+ i +'">'
					append = append + '<div class="tab-pane '+ categories.split("/")[0] + ' ' + active +' show active" id="tab'+ i + '_'+ key +'"  data-rowid="'+ i +'">'
							//konten
							var count = 0

							$.each(sub_category.details, function(category, items) {
							// sub_category.details.forEach((data, index) => {
								selectValue = "select2"+category
								optionValue = "option"+category
								$.each(items,function(keys,value_category){
									if (value_category.category == categories) {
										append = append + '<div class="body_content_'+ categories.split("/")[0] +' divContent_'+ categories.split("/")[0] +'" data-id="'+ i + '_'+ key +'" data-rowid="'+ 0 +'">'
												append = append + '<div class="row mb-4">'
												append = append + '<div class="col-md-3 col-xs-12">'
													append = append + '<div class="form-group">'
													  append = append + '<label>'+ value_category.category +'*</label>'
													  append = append + '<select style="width:100%!important" class="form-control select_category_'+ categories +'" data-rowid="'+ count++ +'" id="select_category" name="select_category" data-id="'+ i + "_" + key +'" value=""><option></option></select>'
													  	if (value_category.notes != "-" && value_category.notes != null) {
													  		append = append + '<span class="text-red"> with notes '+ value_category.notes +'</span>'
													  	}
													append = append + '</div>'
												append = append + '</div>'

												initSelect2ContentCheckbox(selectValue,optionValue,categories,category,i,count,"sub_category")		

												var subCategory = value_category.sub_category
												// Find the index of the object with `title: "Nominal"`
												let nominalIndex = sub_category.inputField[subCategory].findIndex(item => item.title === "Nominal");

												// If found and not already at index 3
												if (nominalIndex !== -1 && nominalIndex !== 3) {
												  // Remove the object from its current position
												  let nominalItem = sub_category.inputField[subCategory].splice(nominalIndex, 1)[0];

												  // Insert the object back at index 3
												  sub_category.inputField[subCategory].splice(3, 0, nominalItem);
												}

												append = append + '<div class="col-md-9 col-xs-12">'
													//tampilan form 9 input text
													append = append + '<div class="row mb-4 divFormCategory'+ categories + i + "_" + key +'" data-id="'+ i + "_" + key +'">'
														$.each(sub_category.inputField, function(inputFieldsCategory, itemsField) {
															if (inputFieldsCategory == value_category.sub_category) {
																$.each(itemsField,function(keys,value){
													  			append = append + '<div class="col-md-3">'
																  	if (value.type == 'date') {
																			triggerValidation = 'onchange="validationCheck(this,'+ i +')"'
																		}else if (value.type == 'file') {
																			triggerValidation = 'onchange="validationCheck(this,'+ i +')"'
																		}else if (value.type == 'text') {
																			if (value.element == 'select') {
																				triggerValidation = 'onchange="validationCheck(this,'+ i +')"'
																			}else{
																				if (value.element == 'select') {
																					triggerValidation = 'onchange="validationCheck(this,'+ i +')"'
																				}else{
																					triggerValidation = 'onkeyup="validationCheck(this,'+ i +')"'
																				}
																			}
																		}
																		append = append + '<div class="form-group">'
																		append = append + 	'<label>' + value.title + '*</label>'

																		Object.keys(value_category).forEach(function(key_category) {
																				if (value.id_input.replace("id","").replace(/([a-z])([A-Z])/g, '$1_$2').toLowerCase().includes(key_category)){
																					if (value.element == 'input') {
																						if (value.id_input == 'idNominal') {
																							var disabled = ""
																							if (inputFieldsCategory == "Allowance") {
																								disabled = "disabled"
																							}else{
																								disabled = disabled
																							}
																							append = append + 	'<input class="money form-control '+ value.id_input +'" id="'+ value.id_input +'" name="'+ value.id_input +'" type="'+ value.type +'" '+ triggerValidation +' value="'+ formatter.format(value_category[key_category]) +'" data-rowid="'+ count +'" data-id="'+ key_category + "_" + inputFieldsCategory.replace(" ","") + "_" + count +'" '+ disabled +'>'
																						}else{
																							if (value.type == 'file') {
																								initSelect2ContentCheckbox(selectValue,optionValue,value_category.sub_category,value_category[key_category],key_category,count,"items_file")
																									append = append + '<div class="input-group">'
																										append = append + 	'<input class="form-control '+ value.id_input +'" id="'+ value.id_input +'" name="'+ value.id_input +'" type="'+ value.type +'" '+ triggerValidation +' value="'+ value_category[key_category] +'" data-rowid="'+ count +'" data-id="'+ key_category + "_" + inputFieldsCategory.replace(" ","") + "_" + count +'">'
																										append = append + '<span class="input-group-addon">'
																											append = append + '<a href="" style="display:none!important" class="linkFile" data-rowid="'+ count +'" data-id="'+ key_category + "_" + inputFieldsCategory.replace(" ","") + "_" + count +'" target="_blank"><i class="bx bx-link"></i></a>'
																										append = append + '</span>'
																									append = append + '</div>'
																							}else{
																								if (value.id_input == 'idDate') {
																									inputValue = moment(value_category[key_category]).format('YYYY-MM-DD')
																								}else{
																									inputValue = value_category[key_category]
																								}

																								append = append + 	'<input class="form-control '+ value.id_input +'" id="'+ value.id_input +'" name="'+ value.id_input +'" type="'+ value.type +'" '+ triggerValidation +' value="'+ inputValue +'" data-rowid="'+ count +'" data-id="'+ key_category + "_" + inputFieldsCategory.replace(" ","") + "_" + count +'">'
																							}
																						}
																					}else if (value.element == 'textarea') {
																						append = append + '<textarea class="form-control '+ value.id_input +'" id="'+ value.id_input +'" type="'+ value.type +'" name="'+ value.id_input +'" '+ triggerValidation +' data-rowid="'+ count +'" data-id="'+ key_category + "_" + inputFieldsCategory.replace(" ","") + "_" + count +'" rows="3">'+ value_category[key_category].replace(/<br\s*\/?>/gi, '\n') + '</textarea>'
																					}else{
																						append = append + 	'<select style="width:100%!important" class="form-control '+ value.id_input +'" id="'+ value.id_input +'" name="'+ value.id_input +'" type="'+ value.type +'" '+ triggerValidation +' value="'+ value_category[key_category] +'" data-rowid="'+ count +'" data-id="'+ key_category + "_" + inputFieldsCategory.replace(" ","") + "_" + count +'"></select>'

																						initSelect2ContentCheckbox(selectValue,optionValue,value_category.sub_category,value_category[key_category],key_category,count,"items_select")
																					}
																			}
																    });
																			
																			append = append + '<span class="invalid-feedback" style="display:none!important">Help block with error</span>'

																    	// console.log(value_category.notes)
																			// if (value_category.notes != null && value_category.notes != "-") {
																			// 	if (value.id_input == 'idNominal') {
																			// 		append = append + '<span class="invalid-feedback text-red" style="display:block">'+ value_category.notes +'</span>'
																			// 	}
																			// }else{
																			// 	append = append + '<span class="invalid-feedback" style="display:none!important">Help block with error</span>'
																			// }
																		append = append + '</div>'
																	append = append + '</div>'
															  });
															}
														})
													append = append + '</div>'
												append = append + '</div>'

											append = append + '</div>'
										append = append + '</div>'							
									}
								})
							});
							append = append + '<div class="row mb-4">'
								append = append + '<div class="col-md-10" style="width:81%">'
									append = append + '<label class="pull-right" style="margin-top:5px">Total</label>'
								append = append + '</div>'
								append = append + '<div class="col-md-3 pull-right" style="width:19%">'
									append = append + '<input class="form-control inputTotalPid" data-id="'+ i + "_" + key +'" data-rowid="'+ i +'" disabled>'
								append = append + '</div>'
							append = append + '</div>'
						//
					append = append + '</div>'	
				append = append + '</div>'

			}

			if (!$(".nav-tabs-custom[data-rowid='"+ i +"']").is(":visible")) {
				$(".nav-tabs-custom[data-rowid='"+ i +"']").append(append)
			}

			if (key != 0) {
				appendChildTab = appendChildTab + '<li class="nav-item"><a href="#tab'+ i + '_'+ key +'" class="tab'+ i + '_'+ key + ' ' + categories.split("/")[0] +' nav-link active" data-bs-toggle="tab" data-rowid="'+ key +'">'+ categories +'</a></li>'
					appendChildContent = appendChildContent + '<div class="tab-pane '+ categories.split("/")[0] + ' ' + active + '" id="tab'+ i + '_'+ key +'" data-rowid="'+ i +'">'

					var countChild = 0
					$.each(sub_category.details, function(category, items) {
						selectValue = "select2"+category
						optionValue = "option"+category

					// sub_category.details.forEach((data, index) => {
						//konten
						$.each(items,function(keys,value_category){
							if (value_category.category == categories) {
								appendChildContent = appendChildContent + '<div class="body_content_'+ categories.split("/")[0] +' divContent_'+ categories.split("/")[0] +'" data-rowid="'+ 0 +'" data-id="'+ i + '_'+ key +'">'
									appendChildContent = appendChildContent + '<div class="row mb-4">'
										appendChildContent = appendChildContent + '<div class="col-md-3 col-xs-12">'
											appendChildContent = appendChildContent + '<div class="form-group">'
												appendChildContent = appendChildContent + '<label>'+ value_category.category +'*</label>'
												appendChildContent = appendChildContent + '<select class="form-control select_category_'+ categories +'" style="width:100%!important" id="select_category" name="select_category" data-rowid="'+ countChild++ +'" data-id="'+ i + "_" + key +'"><option></option></select>'
												if (value_category.notes != "-" && value_category.notes != null) {
										  		appendChildContent = appendChildContent + '<span class="text-red"> with notes '+ value_category.notes +'</span>'
										  	}
											appendChildContent = appendChildContent + '</div>'
										appendChildContent = appendChildContent + '</div>'

										initSelect2ContentCheckbox(selectValue,optionValue,categories,category,key,countChild,"sub_category")

										appendChildContent = appendChildContent + '<div class="col-md-9 col-xs-12">'
											appendChildContent = appendChildContent + '<div class="row mb-4 divFormCategory'+ categories + i + "_" + key +'" data-id="'+ i + "_" + key +'">'

												$.each(sub_category.inputField, function(inputFieldsCategory, itemsField) {
													if (inputFieldsCategory == value_category.sub_category) {
														$.each(itemsField,function(keys,value){
															appendChildContent = appendChildContent + '<div class="col-md-3 col-xs-12">'
																if (value.type == 'date') {
																	triggerValidation = 'onchange="validationCheck(this)"'
																}else if (value.type == 'file') {
																	triggerValidation = 'onchange="validationCheck(this)"'
																}else if (value.type == 'text') {
																	if (value.element == 'select') {
																		triggerValidation = 'onchange="validationCheck(this,'+ i +')"'
																	}else{
																		triggerValidation = 'onkeyup="validationCheck(this,'+ i +')"'
																	}
																}
																appendChildContent = appendChildContent + '<div class="form-group">'
																	appendChildContent = appendChildContent + 	'<label>'+ value.title +'*</label>'

																	Object.keys(value_category).forEach(function(key_category) {
																			//image diganti receipt aja disamain id nya
																			if (value.id_input.replace("id","").replace(/([a-z])([A-Z])/g, '$1_$2').toLowerCase().includes(key_category)) {
																				if (value.element == 'input') {
																					var disabled = "", money = ""
																					if (inputFieldsCategory == "Allowance") {
																						if (value.id_input == "idNominal") {
																							disabled = "disabled"
																							money = "money"
																						}
																					}else{
																						if (value.id_input == "idNominal") {
																							money = "money"
																						}
																						disabled = disabled
																					}

																					if (value.type == 'file') {
																						initSelect2ContentCheckbox(selectValue,optionValue,value_category.sub_category,value_category[key_category],key_category,countChild,"items_file")
																						appendChildContent = appendChildContent + '<div class="input-group">'
																							appendChildContent = appendChildContent + '<input class="'+ money +' form-control '+ value.id_input +'" id="'+ value.id_input +'" type="'+ value.type +'" name="'+ value.id_input +'" '+ triggerValidation +' value="'+ value_category[key_category] +'" data-rowid="'+ countChild +'" data-id="'+ key_category + "_" + inputFieldsCategory.replace(" ","") + "_" + countChild +'" '+ disabled +'>'
																							appendChildContent = appendChildContent + '<span>'
																								appendChildContent = appendChildContent + '<a href="" style="display:none!important" class="linkFile" data-rowid="'+ countChild +'" data-id="'+ key_category + "_" + inputFieldsCategory.replace(" ","") + "_" + countChild +'" target="_blank"><i class="bx bx-link"></i></a>'
																							appendChildContent = appendChildContent + '</span>'
																						appendChildContent = appendChildContent + '</div>'
																						
																					}else{
																						appendChildContent = appendChildContent + '<input class="'+ money +' form-control '+ value.id_input +'" id="'+ value.id_input +'" type="'+ value.type +'" name="'+ value.id_input +'" '+ triggerValidation +' value="'+ value_category[key_category] +'" data-rowid="'+ countChild +'" data-id="'+ key_category + "_" + inputFieldsCategory.replace(" ","") + "_" + countChild +'" '+ disabled +'>'
																					}
																				}else if (value.element == 'textarea') {
																					appendChildContent = appendChildContent + '<textarea class="form-control '+ value.id_input +'" id="'+ value.id_input +'" type="'+ value.type +'" name="'+ value.id_input +'" '+ triggerValidation +' data-rowid="'+ countChild +'" data-id="'+ key_category + "_" + inputFieldsCategory.replace(" ","") + "_" + countChild +'" rows="1">'+ value_category[key_category] + '</textarea>'
																				}else{
																					appendChildContent = appendChildContent + '<select class="form-control '+ value.id_input +'" id="'+ value.id_input +'" type="'+ value.type +'" name="'+ value.id_input +'" '+ triggerValidation +' data-rowid="'+ countChild +'" style="width:100%!important" data-id="'+ key_category + "_" + inputFieldsCategory.replace(" ","") + "_" + countChild +'"></select>'
																				}

																				initSelect2ContentCheckbox(selectValue,optionValue,value_category.sub_category,value_category[key_category],key_category,countChild,"items_select")
																			}
																	})
																	
																	appendChildContent = appendChildContent + '<span class="invalid-feedback" style="display:none!important">Help block with error</span>'

																	// if (value_category.notes != null && value_category.notes != "-") {
																	// 	if (value.id_input == "idNominal") {
																	// 		appendChildContent = appendChildContent + '<span class="invalid-feedback text-red" style="display:block">'+ value_category.notes +'</span>'
																	// 	}
																	// }else{
																	// 	appendChildContent = appendChildContent + '<span class="invalid-feedback" style="display:none!important">Help block with error</span>'
																	// }
																	
																appendChildContent = appendChildContent + '</div>'
															appendChildContent = appendChildContent + '</div>'
														})
													}	
												})	
											appendChildContent = appendChildContent + '</div>'
										appendChildContent = appendChildContent + '</div>'							
									appendChildContent = appendChildContent + '</div>'
								appendChildContent = appendChildContent + '</div>'
							}
						})						
					})
					appendChildContent = appendChildContent + '<div class="row mb-4">'
						appendChildContent = appendChildContent + '<div class="col-md-10" style="width:81%">'
							appendChildContent = appendChildContent + '<label class="pull-right" style="margin-top:5px">Total</label>'
						appendChildContent = appendChildContent + '</div>'
						appendChildContent = appendChildContent + '<div class="col-md-3 pull-right" style="width:19%">'
							appendChildContent = appendChildContent + '<input class="form-control inputTotalPid" data-id="'+ i + "_" + key +'" data-rowid="'+ i +'" disabled>'
						appendChildContent = appendChildContent + '</div>'
					appendChildContent = appendChildContent + '</div>'
					//
				appendChildContent = appendChildContent + '</div>'	
			}

			$(".nav-tabs[data-rowid='"+ i +"'] li:last").after(appendChildTab)
			$(".tab-content[data-rowid='"+ i +"'] .tab-pane:last").after(appendChildContent)

			$(".divTabPane[data-rowid='0']").show()

    	$('.money').mask('#.##0', {reverse: true})		
		}

		function delay(ms) {
		    return new Promise(resolve => setTimeout(resolve, ms));
		}

		function initSelect2ContentCheckbox(selectValue,optionValue,values,input,key,index,element){
			if (element == "sub_category") {
				--index
				setTimeout(function() {
        	$('.select_category_'+ values +'[data-rowid='+ index +']').select2().prop("disabled",true)

					selectValue = $('.select_category_'+ values +'[data-rowid='+ index +']');
		      optionValue = new Option(input,input, true, true);
		      selectValue.append(optionValue).trigger('change');
		    }, 1000);	
			}else if (element == 'items_select') {
				var selectValueRole = "selectRole"+ values + "_" + key + "_" + index, 
						optionRole = "optionRole"+values + "_" + key + "_" + index, 
						selectValueName = "selectRole"+values + "_" + key + "_" + index, 
						optionName = "optionName"+values + "_" + key + "_" + index

				setTimeout(function() {
					$(".idRole[data-rowid='"+ index +"']").select2({
						placeholder:"Select Name",
						ajax: {
		          url: '{{url("/pmo/settlement/getRoleByPid")}}',
		          dataType: 'json',
		          delay: 250,
		          data: function (params) {
		            return {
		              pid:$(".input_pid[data-rowid=0]").val(),
		            };
		          },
		          processResults: function(data, params) {
		            params.page = params.page || 1;
		            return {
		                results: data,
		                pagination: {
		                    more: (params.page * 10) < data.count_filtered
		                }
		            };
		          },
		        }
					})

					selectValueRole = $(".idRole[data-id='"+ key + "_" + values.replace(" ","") + "_" + index +"']")
		      optionRole = new Option(input,input, true, true)
		      selectValueRole.append(optionRole).trigger('change')

					$(".idNameEmployee[data-rowid='"+ index +"']").select2({
						placeholder:"Select Name",
						ajax: {
		          url: '{{url("/pmo/settlement/getUser")}}',
		          dataType: 'json',
		          delay: 250,
		          processResults: function(data, params) {
		            params.page = params.page || 1;
		            return {
		                results: data,
		                pagination: {
		                    more: (params.page * 10) < data.count_filtered
		                }
		            };
		          },
		        }
					})

		      selectValueName = $(".idNameEmployee[data-id='"+ key + "_" + values.replace(" ","") + "_" + index +"']")
		      optionName = new Option(input,input, true, true);
		      selectValueName.append(optionName).trigger('change');
	    	}, 2000)

  		}else if (element == 'items_file'){
				var fileDoc = "fileDoc"+ values.replace(" ","") + "_" + "_" + key.replace(" ","") + "_" + index,
				dataTransfer = "dataTransfer"+ values.replace(" ","") + "_" + "_" + key.replace(" ","") + "_" + index

				setTimeout(function() {
					fileDoc = document.querySelector("input[type='file'][data-id='"+ key + "_" + values.replace(" ","") + "_" + index +"']")

          myFileDoc = new File(['/document'], 'document/file/pmo/settlement/'+key, {type: 'text/plain'})

          // Now let's create a DataTransfer to get a FileList
          dataTransfer = new DataTransfer();
          dataTransfer.items.add(myFileDoc);
          fileDoc.files = dataTransfer.files;

          if (input != null) {
          	$(".linkFile[data-id='"+ key + "_" + values.replace(" ","") + "_" + index +"']").show()
          	$(".linkFile[data-id='"+ key + "_" + values.replace(" ","") + "_" + index +"']").html("<i class='bx bx-link'></i>")
          	$(".linkFile[data-id='"+ key + "_" + values.replace(" ","") + "_" + index +"']").attr("href",input)
          }
		    },1000);	
  		}		
		}

		function checkBoxCategorySelected(pid){
			$(".cbCategory").prop("disabled",true)

			$.ajax({
				type:"GET",
				url:"{{url('/pmo/settlement/getDetailbyPid')}}",
				data:{
					pid:pid,
					id_settlement:window.location.href.split("/")[5].split("?")[1].split("&")[0].split("=")[1],
					category:window.location.href.split("&")[2].split("=")[1], 
					id_sub_category:window.location.href.split("&")[3].split("=")[1]
				},
				success:function(result) {
					var select2Monreq = $(".input_money_request");
          var option = new Option(result.settlement.no_monreq, result.settlement.id, true, true);
          select2Monreq.append(option).trigger('change');

          var select2Pid = $(".input_pid");
          var option = new Option(result.settlement.pid, result.settlement.pid, true, true);
          select2Pid.append(option).trigger('change');

					$.each(result.settlement.sub_category,function(key,value){
						$(".cbCategory").val(value.sub_category).prop("checked",true)
						//sub category contains category and nominal per category, pid_details contains detail_category and inputField
						contentCheckboxSelected(0,key,value.sub_category,result.settlement.pid_details[0])
      			$(".inputTotalPid[data-id=0"+ "_" + key +"]").val(formatter.format(value.total_nominal))
					})

				}
			})
		}

		function submitSettlement(){
			let allInputsFilled = '', allSelectsFilled = ''
			if ($(".nav-tabs li:visible").length > 1) {
				allInputsFilled = $("input:not(.select2-search__field)[name!='_token'][name!='nik'][name!='idReceiptGrab'][name!='id_pid'][type!='checkbox'],input[type='date'],input[type='text'],textarea").toArray().every(function(input) {
				    return $(input).val() !== "";  // Check if each input is not empty
				});

				allSelectsFilled = $("select").toArray().every(function(input) {
				    return $(input).val() !== "";  // Check if each input is not empty
				});
			}else{
				allInputsFilled = $("input:not(.select2-search__field)[name!='_token'][name!='nik'][name!='idReceiptGrab'][name!='id_pid'][type!='checkbox']:visible,input[type='date']:visible,input[type='text']:visible,textarea:visible").toArray().every(function(input) {
			    return $(input).val() !== "";  // Check if each input is not empty
				});

				allSelectsFilled = $("select:visible").toArray().every(function(input) {
				    return $(input).val() !== "";  // Check if each input is not empty
				});
			}
			

			if (allInputsFilled && allSelectsFilled) {
			  let arrPid = [], objContent = {}, arrMonreq = {}

		    let formData = new FormData();  // Initialize FormData to store all form data including files

				$(".input_money_request").each((moneyRequestIndex, moneyRequestElement) => {
				    var moneyRequestKey = $(moneyRequestElement).val(); // Get the value of the money request
				    arrMonreq[moneyRequestKey] = arrMonreq[moneyRequestKey] || {}; // Initialize if not exists

				    // For each money request, get the related PID
				    $(".input_pid[data-rowid=" + moneyRequestIndex + "]").each((pidIndex, pidElement) => {
				        var pidKey = $(pidElement).val(); // Get the pid value

				        // Initialize the PID grouping within each money request
				        arrMonreq[moneyRequestKey][pidKey] = arrMonreq[moneyRequestKey][pidKey] || { item: {}, detail: { nominal: {} } };

				        // Now process the tabs and the nested content related to the pid
				        $(".nav-tabs[data-rowid=" + moneyRequestIndex + "] li:visible a").each(function() {
				            var tabPane = $(this).text().trim().replaceAll(" ","");
				            var rowId = $(this).attr("data-rowid");

				            if (!arrMonreq[moneyRequestKey][pidKey].item[tabPane.replace(" ","")]) {
				                arrMonreq[moneyRequestKey][pidKey].item[tabPane.replace(" ","")] = {}; // Initialize tabPane.replace(" ","") if not exists
				            }

				            // Initialize an object to track the tabIndexCounter for each category independently
	            			var tabIndexCounters = {};

				            // Process body content for each tabPane.replace(" ","")
				            $(".body_content_" + tabPane.replace(" ","").replace(" ","") + "[data-rowid=" + moneyRequestIndex + "]").each(function(tabIndex, tabElement) {
				            		var category = ''
				            		if ($(this).find(".col-md-3 .form-group:first select").val() == 'Others') {
				            			category = tabPane
				            		}else{
				            			  if($(this).find(".col-md-3 .form-group:first select").val() != undefined){
												      if ($(this).find(".col-md-3 .form-group:first").find("select").val().includes('ATK')) {
																category = "ATK"
															}else if($(this).find(".col-md-3 .form-group:first").find("select").val().includes('IKN')){
																//khusus IKN
																category = $(this).find(".col-md-3 .form-group:first select").val().split("-")[0].trim()
															}else{
						            				category = $(this).find(".col-md-3 .form-group:first select").val().replace(" ","");
															}
												    }
				            		}
				                
				                var dataId = $(this).find(".col-md-9 .row").attr("data-id");

				                // If the category doesn't have a counter yet, initialize it to 1
				                if (!tabIndexCounters[category]) {
				                    tabIndexCounters[category] = 1;
				                }

				                var inputTotalPid = $(this).closest(".tab-pane").find(".inputTotalPid").val()
				                    .replace(/\./g, '')
				                    .replace(',', '.')
				                    .replace(' ', '');

				                // Store the nominal value in detail object
				                arrMonreq[moneyRequestKey][pidKey].detail.nominal[tabPane.replace(" ","")] = inputTotalPid;

				                if (!arrMonreq[moneyRequestKey][pidKey].item[tabPane.replace(" ","")][category]) {
				                    arrMonreq[moneyRequestKey][pidKey].item[tabPane.replace(" ","")][category] = [];
				                }

				                // Initialize the variable to track the last processed category
	            					var lastCategory = '';
				                // Collect form data in valueData object
				                var valueData = {}
				                $(this).find(".col-md-9 .divFormCategory" + tabPane.replace(" ","") + dataId).find("input,select,textarea").each(function() {
				                    var inputId = $(this).attr("id");
				                    var inputValue = $(this).val();

				                    if (inputId == "idNominal") {
				                        valueData[inputId] = inputValue.replace(/\./g, '').replace(',', '.').replace(' ', '');
				                    } else if (inputId == "idTeamEksternal" || inputId == "idTeamInternal") {
				                        valueData[inputId] = inputValue.replace(/\n/g, "<br>")
				                    } else if ($(this).attr("type") == 'file') {
				                        var file = $(this).prop('files')[0];  // Get the file
				                        if (file) {
				                            // Append the file to FormData
				                            formData.append('file_' + moneyRequestKey + '_' + pidKey + '_' + category.replace(" ","_") + '_' + inputId + '_' + tabIndexCounters[category], file);
				                        }
				                    } else {
				                        valueData[inputId] = inputValue;
				                    }
				                });

	                			tabIndexCounters[category]++;

				                // Push the collected data into the respective category array
				                arrMonreq[moneyRequestKey][pidKey].item[tabPane.replace(" ","")][category].push(valueData);
				            });
				        });
				    });
				});

				console.log(arrMonreq)

				// Optionally append the entire arrMonreq as JSON data to the FormData
	      formData.append("_token","{{ csrf_token() }}")

	     	swalAccept = Swal.fire({
	        title: 'Are You Sure?',
	        text: 'Add Settlement',
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes',
	        cancelButtonText: 'No',
	      })

	      formData.append("arrDataSettlement",JSON.stringify(arrMonreq))

	      savePost(swalAccept,url="{{url('pmo/settlement/storeSettlement')}}",formData)
			} else {
				Swal.fire({
          title: 'Error Message!',
          text: 'Please fill all mandatory fields in every category',
          icon: 'error',
          confirmButtonText: 'OK'
        });

				$("input[name!='id_pid']").map((key,item)=> {
			    if (item.value == '') {
			    	if (item.id == 'idNominal') {
			    		$(item).closest("div").next("div").next('.invalid-feedback').show()
							$(item).closest("div").next("div").next('.invalid-feedback').text('Please fill '+ $(item).closest("div").closest(".row").prev('label').text().replace(/[*]/g, "") + '!')
							$(item).closest("div").closest("div").closest(".form-group").addClass('needs-validation')
			    	}else{
			    		$(item).next('.invalid-feedback').show()
							$(item).next('.invalid-feedback').text('Please fill '+ $(item).prev('label').text().replace(/[*]/g, "") + '!')
							$(item).closest(".form-group").addClass('needs-validation')
			    	}
					}
				})

				$("select").map((key,item)=> {
			    if (item.value == '') {
						$(item).next().next('.invalid-feedback').show()
						$(item).next().next('.invalid-feedback').text('Please fill '+ $(item).prev('label').text().replace(/[*]/g, "") + '!')
						$(item).closest(".form-group").addClass('needs-validation')
					}
				})
			}
		}

		function updateSettlement(){
			let allInputsFilled = '', allSelectsFilled = ''

			if ($(".nav-tabs li:visible").length > 1) {
				allInputsFilled = $("input,textarea").toArray().every(function(input) {
				    return $(input).val() !== "";  // Check if each input is not empty
				});

				allSelectsFilled = $("select").toArray().every(function(input) {
				    return $(input).val() !== "";  // Check if each input is not empty
				});
			}else{
				allInputsFilled = $("input:visible,textarea:visible").toArray().every(function(input) {
			    return $(input).val() !== "";  // Check if each input is not empty
				});

				allSelectsFilled = $("select:visible").toArray().every(function(input) {
				    return $(input).val() !== "";  // Check if each input is not empty
				});
			}

			if (allInputsFilled && allSelectsFilled) {
			  swalAccept = Swal.fire({
	        title: 'Are You Sure?',
	        text: 'Update Settlement',
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes',
	        cancelButtonText: 'No',
	      })

	      let arrPid = {}, objContent = {}

				var formData = new FormData()

			 	$(".input_pid").map((key,value) => {
			    var keys = value.value

	        arrPid[keys] = arrPid[keys] || { item: {}, detail: { id_money_request: "", nominal: {} } }; 

					$(".nav-tabs[data-rowid="+ key +"]").find("li:visible").find("a").each(function(){
						tabPane = $(this).text().trim().replaceAll(" ","_");;

						if (!arrPid[keys].item[tabPane]) {
	              arrPid[keys].item[tabPane] = {}; // Initialize parent category if it doesn't exist
	          }
						$(".body_content_"+tabPane+"[data-rowid="+ key +"]").each(function(){
							var category = ''
							if ($(this).find(".col-md-3 .form-group:first").find("select").val() == "Others") {
								category = tabPane
							}else{
								category = $(this).find(".col-md-3 .form-group:first").find("select").val().replace(" ","_")
							}
							var dataId = $(this).find(".col-md-9").find(".row").attr("data-id")

							var inputTotalPid = $(this).closest(".tab-pane").find(".inputTotalPid").val().replace(/\./g,'').replace(',','.').replace(' ','')
							// Initialize the key, tab, and index only when needed
							arrPid[keys].detail.nominal[tabPane] = inputTotalPid

							if (!arrPid[keys].item[tabPane][category]) {
	              arrPid[keys].item[tabPane][category] = [];
	            }

	            arrPid[keys].item[tabPane] = arrPid[keys].item[tabPane] || {};
	            // arrPid[keys].item[tabPane][category] = arrPid[keys].item[tabPane][category] || {};
							var valueData = {}
			      	$(this).find(".col-md-9").find('.divFormCategory'+tabPane+dataId).find("input,select,textarea").each(function() {
		            var inputId = $(this).attr('id'); // e.g., "toll", "date", "x", "y"
		            var inputValue = $(this).val(); // Get the value entered in the input

		            if (inputId == "idNominal") {
                  	valueData[inputId] = inputValue.replace(/\./g, '').replace(',', '.').replace(' ', '');
                }else if (inputId == "idTeamEksternal" || inputId == "idTeamInternal") {
                    valueData[inputId] = inputValue.replace(/\n/g, "<br>")
                } else if ($(this).attr("type") == 'file') {
                  	 var file = $(this).prop('files')[0];  // Get the file
                    if (file) {
                        // Append the file to FormData
                        formData.append('file_' + category.replace(" ","_") + '_' + inputId, file);
                    }
                } else {
                    valueData[inputId] = inputValue;
                }          
		          });
		          arrPid[keys].item[tabPane][category].push(valueData);
						})				
					})

					$(".input_money_request[data-rowid="+ key +"]").each(function() {
						arrPid[keys].detail["id_money_request"] = $(this).val();
					})
				})

	      formData.append("_token","{{ csrf_token() }}")
	      formData.append("id_settlement",window.location.href.split("&")[0].split("=")[1])
	      formData.append("category",window.location.href.split("&")[2].split("=")[1])
	      formData.append("id_sub_category",window.location.href.split("&")[3].split("=")[1])
	      formData.append("id_pid",$("#id_pid").val())
	      formData.append("arrDataSettlement",JSON.stringify(Object.assign({}, arrPid)))

	      savePost(swalAccept,url="{{url('pmo/settlement/updateSettlement')}}",formData)
			} else {
				Swal.fire({
          title: 'Error Message!',
          text: 'Please fill all mandatory fields in every category',
          icon: 'error',
          confirmButtonText: 'OK'
        });

				$("input[type='file'],input[type='date'],input[type='text']").map((key,item)=> {
			    if (item.value == '') {
			    	if (item.id == 'idNominal') {
			    		$(item).closest("div").next("div").next('.invalid-feedback').show()
							$(item).closest("div").next("div").next('.invalid-feedback').text('Please fill '+ $(item).closest("div").closest(".row").prev('label').text().replace(/[*]/g, "") + '!')
							$(item).closest("div").closest("div").closest(".form-group").addClass('needs-validation')
			    	}else{
			    		$(item).next('.invalid-feedback').show()
							$(item).next('.invalid-feedback').text('Please fill '+ $(item).prev('label').text().replace(/[*]/g, "") + '!')
							$(item).closest(".form-group").addClass('needs-validation')
			    	}
			    }
				})

				$("select").map((key,item)=> {
			    if (item.value == '') {
						$(item).next().next('.invalid-feedback').show()
						$(item).next().next('.invalid-feedback').text('Please fill '+ $(item).prev('label').text().replace(/[*]/g, "") + '!')
						$(item).closest(".form-group").addClass('needs-validation')
					}
				})
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
            	var id = result.tid

              Swal.showLoading()
              Swal.fire(
                'Successfully!',
                'success'
              ).then((result) => {
                if (result.value) {
                	window.location.assign('{{url("pmo/settlement/detail_settlement?id_settlement=")}}'+id);
                }
              })
            },
            error: function(xhr, status, error) {
		          // Handle errors
		        }
          }) 
        }        
      })
		}

		function validationCheck(data,i){
			if ($(data).val() != '') {
				$(data).next('.invalid-feedback').attr('style','display:none!important')
				$(data).next().next('.invalid-feedback').attr('style','display:none!important')
				$(data).closest(".form-group").removeClass('needs-validation')

				if (data.id == "idNominal") {
					$(data).closest("div").next("div").next('.invalid-feedback').attr('style','display:none!important')
					$(data).closest("div").closest("div").closest(".form-group").removeClass('needs-validation')

					let dataRowId = $(data).attr("data-rowid")

					let dataId 		= $(data).attr("data-id")

					var priceTotal = 0, priceGrandTotal = 0

					priceTotal += 
						($(".idNominal[data-id="+ dataId +"]").val() != 0 ? parseInt($(".idNominal[data-id="+ dataId +"]").val().trim().replace(/\./g,'').replace(',','.')) : 0)

					$(".inputTotalPid[data-id="+ dataId +"]").val(formatter.format(priceTotal))

					$(".idNominal[data-id='"+ dataId +"']").closest(".tab-pane").find(".idNominal").each(function(){
						if ($(this).val() != "") {
							if ($(this).val().length == 1) {
								priceGrandTotal = 0
							}else{
								priceGrandTotal += parseInt($(this).val().trim().replace(/\./g,'').replace(',','.'))
							}
						}
					})

					$(".idNominal[data-id='"+ dataId +"']").closest(".tab-pane").find(".inputTotalPid").val(formatter.format(priceGrandTotal)) 
					// formatter.format(priceGrandTotal)

    			$('.money').mask('#.##0', {reverse: true})
				}else if (data.type == "file") {
					console.log("sinii")
				 	var f = data.files[0]
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
				}else if (data.id == "idStartDate" || data.id == "idEndDate") {
					$(data).closest("div").next("div").next('.invalid-feedback').attr('style','display:none!important')
					$(data).closest("div").closest("div").closest(".form-group").removeClass('needs-validation')

					let dataRowId = $(data).attr("data-rowid")

					let dataId 		= $(data).attr("data-id")

					var priceGrandTotal = 0

					if (data.id == "idStartDate") {
						if ($(data).closest(".col-md-3").next(".col-md-3").find(".idEndDate").val() != "") {
							if ($(data).val() > $(data).closest(".col-md-3").next(".col-md-3").find(".idEndDate").val()) {
								Swal.fire('Start date must not be greater than End date!').then((result) => {
									$(data).val("")
									$(data).closest(".tab-pane").find(".inputTotalPid").val("")
								})
							}else{
								$.ajax({
									type:"GET",
									url:"{{url('pmo/settlement/calculateAllowance')}}",
									data:{
										idStartDate:$(data).val(),
										idEndDate:$(data).closest(".col-md-3").next(".col-md-3").find(".idEndDate").val()
									},
									success:function(result) {
										$(data).closest(".col-md-3").next("div").next("div").next("div").find(".idNominal").val(result)

										$(data).closest(".tab-pane").find(".idNominal").each(function(){
											console.log(this.value)
											priceGrandTotal += parseInt(this.value.trim().replace(/\./g,'').replace(',','.'))
										})

										$(data).closest(".tab-pane").find(".inputTotalPid").val(formatter.format(priceGrandTotal)) 
									}
								})
							}
						}
					}

					if (data.id == "idEndDate") {
						if ($(data).closest(".col-md-3").prev(".col-md-3").find(".idStartDate").val() != "") {
							if ($(data).val() < $(data).closest(".col-md-3").prev(".col-md-3").find(".idStartDate").val()) {
								Swal.fire('Start date must not be greater than End date!').then((result) => {
									$(data).val("")
									$(data).closest(".tab-pane").find(".inputTotalPid").val("")
								})
							}else{
								$.ajax({
									type:"GET",
									url:"{{url('pmo/settlement/calculateAllowance')}}",
									data:{
										idStartDate:$(data).closest(".col-md-3").prev(".col-md-3").find(".idStartDate").val(),
										idEndDate:$(data).val()
									},
									success:function(result) {
										console.log(result)
										$(data).closest(".col-md-3").next("div").next("div").find(".idNominal").val(result)

										$(data).closest(".tab-pane").find(".idNominal").each(function(){
											console.log(this.value)
											priceGrandTotal += parseInt(this.value.trim().replace(/\./g,'').replace(',','.'))
										})
										$(data).closest(".tab-pane").find(".inputTotalPid").val(formatter.format(priceGrandTotal)) 
									}
								})
							}
						}
					}
				}
			}
		}

		function btnBack() {
			if (window.location.href.split("?")[1] === undefined) {
				location.href = "{{url('pmo/settlement/index')}}"
			}else{
				location.href = "{{url('pmo/settlement/detail_settlement?id_settlement=')}}"+window.location.href.split("?")[1].split("&")[0].split("=")[1]
			}
		}
</script>
@endsection