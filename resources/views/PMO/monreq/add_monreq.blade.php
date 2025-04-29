@extends('template.main_sneat')
@section('tittle')
PMO Money Request 
@endsection
@section('pageName')
Money Request
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
				<div class="row">
					<div class="col-md-4 col-xs-12">
						<div class="form-group">
							<label>Account Number*</label>
							<input onkeyup="validationCheck(this)" type="text" name="input_acc_number" id="input_acc_number" class="form-control input_acc_number" data-rowid="0">
							<span class="invalid-feedback"></span>
						</div>
					</div>
					<div class="col-md-4 col-xs-12">
						<div class="form-group">
							<label>Account Name*</label>
							<input onkeyup="validationCheck(this)" type="text" name="input_acc_name" id="input_acc_name" class="form-control input_acc_name" data-rowid="0">
							<span class="invalid-feedback"></span>
						</div>
					</div>
					<div class="col-md-4 col-xs-12">
						<div class="form-group">
							<label>Request Transfer Date*</label>
							<div class="input-group">
								<span class="input-group-text">
									<i class="bx bx-calendar"></i>	
								</span>
								<input type="text" name="input_transfer_date" id="input_transfer_date" data-rowid="0" class="form-control input_transfer_date">
							</div>
							<span class="invalid-feedback"></span>
						</div>
					</div>
				</div>	
				<hr>
				<div class="row divPID" data-rowid="0">
					<div class="col-md-9 col-xs-12">
						<div class="row">
							<div class="col-md-2 col-xs-12">
								<div class="form-group">
									<label>Project ID*</label>
									<select onchange="validationCheck(this)" style="width:100%!important;min-width: 100%!important;max-width: 100%!important;" data-rowid="0" type="text" name="input_pid" id="input_pid" class="form-control input_pid"><option></option></select>
									<span class="invalid-feedback"></span>
								</div>
							</div>
							<div class="col-md-10 col-xs-12 divItemGroup" data-rowid='divPID-0'>
								<div class="row divItem" data-rowid="0">
									<div class="col-md-3 col-xs-12">
										<div class="form-group">
											<label>Category*</label>
											<select onchange="validationCheck(this)" style="width:100%!important;min-width: 100%!important;max-width: 100%!important;" data-rowid="0" type="text" name="input_category" id="input_category" class="form-control input_category" disabled>
												<option></option>
											</select>
											<span class="invalid-feedback"></span>
										</div>
									</div>
									<div class="col-md-1 col-xs-12" style="padding-left:0px!important;padding-right: 0px!important;">
										<div class="form-group">
											<label>Qty*</label>
											<input onkeyup="validationCheck(this,0)" type="text" name="input_qty" id="input_qty" data-id="0-0" data-rowid="0" class="form-control input_qty">
											<span class="invalid-feedback"></span>
										</div>
									</div>
									<div class="col-md-2 col-xs-12">
										<div class="form-group">
											<label>Unit*</label>
											<select onchange="validationCheck(this)" style="width:100%!important;" data-rowid="0" type="text" name="input_unit" id="input_unit" class="form-control input_unit"><option></option>
											</select>
											<span class="invalid-feedback"></span>
										</div>
									</div>
									<div class="col-md-2 col-xs-12">
										<div class="form-group">
											<label>Price*</label>
											<input onkeyup="validationCheck(this,0)" type="text" name="input_price" id="input_price" data-id="0-0" data-rowid="0" class="form-control input_price money">
											<span class="invalid-feedback"></span>
										</div>
										<div class="form-group label_total_dinamis" style="float: right;">
											<label>Total</label>
										</div>
									</div>
									<div class="col-md-3 col-xs-12">
										<div class="form-group">
											<label>Total Price*</label>
											<input type="text" name="input_total_price" id="input_total_price" data-rowid="0" data-id="0-0" class="form-control input_total_price money" disabled>
											<span class="invalid-feedback"></span>
										</div>
										<div class="form-group div_total_dinamis">
											<input type="text" name="input_total_price_item" id="input_total_price_item" data-rowid="0"  class="form-control input_total_price_item money" disabled>
											<span class="invalid-feedback"></span>
										</div>
									</div>
									<div class="col-md-1 col-xs-12">
										<div class="form-group">
											<button style="width:40px;margin-top:15px" class="btn btn-sm text-bg-primary pull-right addRow" data-rowid="0" onclick="addRowItem(0)" disabled><i class="bx bx-plus"></i></button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-xs-12">
						<div style="display: flex;flex-direction: column;gap:5px">
							<div class="form-group">
								<label>Start Date - End Date*</label>
								<div class="input-group">
									<span class="input-group-text">
										<i class="bx bx-calendar"></i>
									</span>
									<input onchange="validationCheck(this)" type="text" name="input_date_range" id="input_date_range" data-rowid="0" class="form-control input_date_range">
									<span class="invalid-feedback"></span>
								</div>
							</div>
							<div class="form-group">
								<label>Team Name*</label>
								<textarea onkeyup="validationCheck(this)" class="form-control textarea_team_name" id="textarea_team_name" data-rowid="0" name="textarea_team_name"></textarea>
								<span class="invalid-feedback"></span>
							</div>
							<div class="form-group">
								<label>Event Detail*</label>
								<textarea onkeyup="validationCheck(this)" class="form-control textarea_event_detail" id="textarea_event_detail" data-rowid="0" name="textarea_event_detail"></textarea>
								<span class="invalid-feedback"></span>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div style="text-align:center;margin-top: 20px;">
						<button class="btn btn-sm text-bg-primary btnAddRowPid" onclick="addRowPID(1)"><i class="bx bx-plus"></i> Project ID</button>
						<button class="btn btn-sm text-bg-danger" disabled="disabled" id="btnDeleteRowPID" onclick="deleteRowPID(1)" ><i class="bx bx-trash"></i></button>
					</div>
				</div>
				<div class="row">
					<div style="display: flex;margin-right: 15px;float: right;gap:5px">
						<button class="btn btn-sm text-bg-danger" onclick="btnBack()">Cancel</button>
						<button class="btn btn-sm text-bg-primary" id="submitMonreq">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
@section('scriptImport')
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/jquery.mask.js')}}"></script>
@endsection
@section('script')
	<script type="text/javascript">
    var formatter = new Intl.NumberFormat(['ban', 'id']);

		$(document).ready(function(){
    	$('.money').mask('#.##0', {reverse: true})
			initSelect2(0,0)
		})

		function initSelect2(i,n,pid_text,pid_value,data){
			let pid = ''

			if (pid_value) {
				pid = pid_value
				$(".addRow[data-rowid='"+ i +"']").prop("disabled",false)					
			}else{
				pid = $(".input_pid[data-rowid='"+ n +"']").val()
			}


			$(".input_pid[data-rowid='"+ i +"']").select2({
				// data:dataPID,
				placeholder:"Select Project ID",
				ajax: {
          url: '{{url("/pmo/monreq/getPid")}}',
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
				pid = e.params.data.id
				if (pid != "") {
				$(".input_category[data-rowid='"+ i +"']").prop("disabled",false)	
				$(".addRow[data-rowid='"+ i +"']").prop("disabled",false)					
				}
			})

			console.log(i)
			var pid_selected = $(".input_pid[data-rowid='"+ i +"']");
      var option = new Option(pid_text, pid_value, true, true);
      pid_selected.append(option).trigger('change');

			if (i > 0) {
				$(".input_category[data-rowid='"+ i +"']").prop("disabled",false)
			}

			$(".input_category[data-rowid='"+ i +"']").select2({
				// data:dataCategory,
				placeholder:"Select Category",
				ajax: {
					url: '{{url("/pmo/monreq/getItemSbe")}}',
					dataType: 'json',
					delay: 250,
					data: function (params) {
            return {
              pid:pid,
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
				},
			})


			$(".input_unit[data-rowid='"+ i +"']").select2({
				data:[
					{
						id:"Hari",
						text:"Hari",
					},
					{
						id:"Pcs",
						text:"Pcs"
					}
				],
				placeholder:"Select Unit"
			})

			$.each(data,function(key,value) {
				var cat_selected = $(".input_category[data-id='"+ i + '-' + key +"']");
	      var optionCat = new Option(value.category, value.category, true, true);
	      cat_selected.append(optionCat).trigger('change');

	      var unit_selected = $(".input_unit[data-id='"+ i + '-' + key +"']");
      	var optionUnit = new Option(value.unit, value.unit, true, true);
      	unit_selected.append(optionUnit).trigger('change');
			})

			$(".input_date_range[data-rowid='"+ i +"']").daterangepicker({
				minDate:moment(),
        startDate:moment()
			})

			$(".input_transfer_date[data-rowid='"+ i +"']").flatpickr({
        autoclose: true,
        minDate:0,
        startDate:new Date()
      })
		}

		function addRowItem(n){
			var count = $(".divItem").length

			var append = ""

			append = append + '<div class="row divItem" data-rowid="'+ count +'">'
				append = append + '<div class="col-md-3 col-xs-12">'
					append = append + '<div class="form-group">'
							append = append + '<label style="display:none">Category*</label>'
							append = append + '<select onchange="validationCheck(this)" style="width:100%!important;min-width: 100%!important;max-width: 100%!important;" data-id="'+ count + '-' + n +'" data-rowid="'+ count +'" type="text" name="input_category" id="input_category" class="form-control input_category" disabled>'
							append = append + '<option></option>'
						append = append + '</select>'
						append = append + '<span class="invalid-feedback"></span>'
					append = append + '</div>'
				append = append + '</div>'
				append = append + '<div class="col-md-1 col-xs-12" style="padding-left:0px!important;padding-right:0px!important">'
					append = append + '<div class="form-group">'
						append = append + '<label style="display:none">Qty*</label>'
						append = append + '<input onkeyup="validationCheck(this,'+ n +')" type="text" name="input_qty" id="input_qty" data-id="'+ n + '-' + count +'" data-rowid="'+ count +'" class="form-control input_qty">'
						append = append + '<span class="invalid-feedback"></span>'
					append = append + '</div>'
				append = append + '</div>'
				append = append + '<div class="col-md-2 col-xs-12">'
					append = append + '<div class="form-group">'
							append = append + '<label style="display:none">Unit*</label>'
						 	append = append + '<select onchange="validationCheck(this)" style="width:100%!important;" data-id="'+ n + '-' + count +'" data-rowid="'+ count +'" type="text" name="input_unit" id="input_unit" class="form-control input_unit"><option></option>'
						append = append + '</select>'
						append = append + '<span class="invalid-feedback"></span>'
					append = append + '</div>'
				append = append + '</div>'
				append = append + '<div class="col-md-2 col-xs-12">'
					append = append + '<div class="form-group">'
						append = append + '<label style="display:none">Price*</label>'
						append = append + '<input onkeyup="validationCheck(this,'+ n +')" type="text" name="input_price" id="input_price" data-id="'+ n + '-' + count +'" data-rowid="'+ count +'" class="form-control input_price money">'
						append = append + '<span class="invalid-feedback"></span>'
					append = append + '</div>'
					append = append + '<div class="form-group label_total_dinamis" style="float: right;">'
						append = append + '<label>Total</label>'
					append = append + '</div>'
				append = append + '</div>'
				append = append + '<div class="col-md-3 col-xs-12">'
					append = append + '<div class="form-group">'
						append = append + '<label style="display:none">Total Price*</label>'
						append = append + '<input type="text" name="input_total_price" id="input_total_price" data-rowid="'+ count +'" class="form-control input_total_price money" disabled data-id="'+ n + '-' + count +'">'
						append = append + '<span class="invalid-feedback"></span>'
					append = append + '</div>'
					append = append + '<div class="form-group div_total_dinamis">'
						append = append + '<input type="text" name="input_total_price_item" id="input_total_price_item" data-rowid="'+ n +'" class="form-control input_total_price_item money" disabled>'
						append = append + '<span class="invalid-feedback"></span>'
					append = append + '</div>'
				append = append + '</div>'
				append = append + '<div class="col-md-1 col-xs-12">'
					append = append + '<div class="form-group">'
						append = append + '<button style="width:40px;" class="btn btn-sm text-bg-danger pull-right" onclick="deleteRowItem('+ count +')"><i class="bx bx-trash"></i></button>'
					append = append + '</div>'
				append = append + '</div>'
			append = append + '</div>'

			$(".divItemGroup[data-rowid='divPID-"+ n +"'] .divItem:last").after(append)

			$(".divItem[data-rowid="+ count +"]").prev(".divItem").find('div.form-group.label_total_dinamis').attr('style','display:none!important')
			$(".divItem[data-rowid="+ count +"]").prev(".divItem").find('div.form-group.div_total_dinamis').attr('style','display:none!important')

			initSelect2(count,n)
    	$('.money').mask('#.##0', {reverse: true})
		}

		function deleteRowItem(count){
			$(".divItem[data-rowid='"+ count +"']").prev(".divItem").find('div.form-group.label_total_dinamis').show()
			$(".divItem[data-rowid='"+ count +"']").prev(".divItem").find('div.form-group.div_total_dinamis').show()
			$(".divItem[data-rowid='"+ count +"']").remove()
		}

		function addRowPID(n){
			var count = $(".divPID").length

			var append = ''

			append = append + '<hr>'
			append = append + '<div class="row divPID" data-rowid="'+ count +'">'
				append = append + '<div class="col-md-9 col-xs-12">'
					append = append + '<div class="row">'
						append = append + '<div class="col-md-2 col-xs-12">'
							append = append + '<div class="form-group">'
								append = append + '<label>Project ID*</label>'
									append = append + '<select style="width:100%!important;min-width: 100%!important;max-width: 100%!important;" data-rowid="'+ count +'" type="text" name="input_pid" id="input_pid" class="form-control input_pid" onchange="validationCheck(this)"><option></option></select>'
									append = append + '<span class="invalid-feedback"></span>'
							append = append + '</div>'
						append = append + '</div>'
						append = append + '<div class="col-md-10 col-xs-12 divItemGroup" data-rowid="divPID-'+ count +'">'
							append = append + '<div class="row divItem" data-rowid="'+ count +'">'
								append = append + '<div class="col-md-3 col-xs-12">'
									append = append + '<div class="form-group">'
										append = append + '<label>Category*</label>'
											append = append + '<select onchange="validationCheck(this)" style="width:100%!important;min-width: 100%!important;max-width: 100%!important;" data-rowid="'+ count +'" type="text" name="input_category" id="input_category" class="form-control input_category" disabled>'
											append = append + '<option></option>'
										append = append + '</select>'
										append = append + '<span class="invalid-feedback"></span>'
									append = append + '</div>'
								append = append + '</div>'
								append = append + '<div class="col-md-1 col-xs-12" style="padding-left:0px!important;padding-right:0px!important">'
									append = append + '<div class="form-group">'
										append = append + '<label>Qty*</label>'
										append = append + '<input onkeyup="validationCheck(this,'+ count +')" type="text" name="input_qty" id="input_qty" data-id="'+ count + '-' + '0' +'" data-rowid="'+ count +'" class="form-control input_qty">'
										append = append + '<span class="invalid-feedback"></span>'
									append = append + '</div>'
								append = append + '</div>'
								append = append + '<div class="col-md-2 col-xs-12">'
									append = append + '<div class="form-group">'
										append = append + '<label>Unit*</label>'
											append = append + '<select onchange="validationCheck(this)" style="width:100%!important;" data-rowid="'+ count +'" type="text" name="input_unit" id="input_unit" class="form-control input_unit"><option></option>'
										append = append + '</select>'
										append = append + '<span class="invalid-feedback"></span>'
									append = append + '</div>'
								append = append + '</div>'
								append = append + '<div class="col-md-2 col-xs-12">'
									append = append + '<div class="form-group">'
										append = append + '<label>Price*</label>'
										append = append + '<input onkeyup="validationCheck(this,'+ count +')" type="text" name="input_price" id="input_price" data-id="'+ count + '-' + '0' +'" data-rowid="'+ count +'" class="form-control input_price money">'
										append = append + '<span class="invalid-feedback"></span>'
									append = append + '</div>'
									append = append + '<div class="form-group label_total_dinamis" style="float: right;">'
										append = append + '<label>Total</label>'
									append = append + '</div>'
								append = append + '</div>'
								append = append + '<div class="col-md-3 col-xs-12">'
									append = append + '<div class="form-group">'
										append = append + '<label>Total Price*</label>'
											append = append + '<input type="text" name="input_total_price" id="input_total_price" data-id="'+ count + '-' + '0' +'" data-rowid="'+ count +'" class="form-control input_total_price money" disabled>'
											append = append + '<span class="invalid-feedback"></span>'
									append = append + '</div>'
									append = append + '<div class="form-group div_total_dinamis">'
										append = append + '<input type="text" name="input_total_price_item" id="input_total_price_item" data-rowid="'+ count +'" class="form-control input_total_price_item money" disabled>'
										append = append + '<span class="invalid-feedback"></span>'
									append = append + '</div>'
								append = append + '</div>'
								append = append + '<div class="col-md-1 col-xs-12">'
									append = append + '<div class="form-group">'
										append = append + '<button style="width:40px;margin-top:15px" class="btn btn-sm text-bg-primary pull-right addRow" onclick="addRowItem('+ count +')" disabled data-rowid="'+ count +'"><i class="bx bx-plus"></i></button>'
									append = append + '</div>'
								append = append + '</div>'
							append = append + '</div>'
						append = append + '</div>'
					append = append + '</div>'
				append = append + '</div>'
				append = append + '<div class="col-md-3 col-xs-12">'
					append = append + '<div style="display: flex;flex-direction: column;gap:5px">'
						append = append + '<div class="form-group">'
							append = append + '<label>Start Date - End Date*</label>'
							append = append + '<div class="input-group">'
								append = append + '<span class="input-group-text">'
									append = append + '<i class="bx bx-calendar"></i>'
								append = append + '</span>'
								append = append + '<input onchange="validationCheck(this)" type="text" name="input_date_range" id="input_date_range" data-rowid="'+ count +'" class="form-control input_date_range">'
								append = append + '<span class="invalid-feedback"></span>'
							append = append + '</div>'
						append = append + '</div>'
						append = append + '<div class="form-group">'
							append = append + '<label>Team Name*</label>'
								append = append + '<textarea onkeyup="validationCheck(this)" class="form-control textarea_team_name" id="textarea_team_name" data-rowid="'+ count +'" name="textarea_team_name"></textarea>'
								append = append + '<span class="invalid-feedback"></span>'
						append = append + '</div>'
						append = append + '<div class="form-group">'
							append = append + '<label>Event Detail*</label>'
							 	append = append + '<textarea onkeyup="validationCheck(this)" class="form-control textarea_event_detail" id="textarea_event_detail" data-rowid="'+ count +'" name="textarea_event_detail"></textarea>'
								append = append + '<span class="invalid-feedback"></span>'
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
    	$('.money').mask('#.##0', {reverse: true})
		}

		function deleteRowPID(){
			Swal.fire({
        title: 'Are you Sure?',
        text: 'You will delete this row and Dont forget to save change to delete permanently!',
        icon: 'warning', // You can also use 'success', 'warning', 'error', or 'question'
        confirmButtonText: 'Okay',
        cancelButtonText: 'Cancel',
        showCancelButton: true,
        allowOutsideClick: false
      }).then((result)=>{
      	if (result.value) {
					$(".divPID:last").prev('hr').remove()
					$(".divPID:last").remove()

					if ($(".divPID").length > 1) {
						$("#btnDeleteRowPID").prop("disabled",false)
					}else{
						$("#btnDeleteRowPID").prop("disabled",true)	
					}
      	}else{
      		Swal.close()
      	}
      });
		}

		if (window.location.href.split("?")[1] != undefined) {
			if (window.location.href.split("?")[1].split("=")[1]) {
				$("#submitMonreq").text("Update")
				$("#submitMonreq").removeClass("text-bg-primary")
				$("#submitMonreq").addClass("btn-warning")
				$("#submitMonreq").attr("onclick","updateMonreq("+ window.location.href.split("?")[1].split("=")[1] +")")
				showEditMonreq(window.location.href.split("?")[1].split("=")[1])
			}else{
				$("#submitMonreq").text("Submit")
				$("#submitMonreq").removeClass("btn-warning")
				$("#submitMonreq").addClass("text-bg-primary")
				$("#submitMonreq").attr("onclick","submitMonreq()")
			}
		}else{
			$("#submitMonreq").text("Submit")
			$("#submitMonreq").removeClass("btn-warning")
			$("#submitMonreq").addClass("text-bg-primary")
			$("#submitMonreq").attr("onclick","submitMonreq()")
		}

		function updateMonreq(id){
			let allInputsFilled = $("input[type='text']:visible,input[type='date']:visible").toArray().every(function(input) {
			    return $(input).val() !== "";  // Check if each input is not empty
			});

			let allTextAreasFilled = $("textarea:visible").toArray().every(function(input) {
			    return $(input).val() !== "";  // Check if each input is not empty
			});

			let allSelectsFilled = $("select:visible").toArray().every(function(input) {
			    return $(input).val() !== "";  // Check if each input is not empty
			});

			if (allInputsFilled && allSelectsFilled && allTextAreasFilled) {
			  swalAccept = Swal.fire({
	        title: 'Are You Sure?',
	        text: 'Update Monreq',
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes',
	        cancelButtonText: 'No',
	      })

	      let arrPid = [], objContentMonreq = {}

			  $(".input_pid").map((key,value)=>{
					arrPid.push(value.value)
				})

				$('.divItemGroup:visible').each(function() {
			    let rowId = $(this).attr('data-rowid'); // Get the data-row-id attribute for each divItemGroup
			    let idGroup = rowId.split("-")[1] 
			    let newRowId = arrPid[idGroup] 

			    console.log(idGroup)
			    // Initialize a group for this row-id if it doesn't exist
			    if (!objContentMonreq[newRowId]) {
			        objContentMonreq[newRowId] = [
			        	{
			        		"input_date_range_start":moment($(".input_date_range[data-rowid="+ idGroup +"]:visible").data('daterangepicker').startDate).format("YYYY-MM-DD"),
			        		"input_date_range_end":moment($(".input_date_range[data-rowid="+ idGroup +"]:visible").data('daterangepicker').endDate).format("YYYY-MM-DD"),
			        		"textarea_team_name":$(".textarea_team_name[data-rowid="+ idGroup +"]:visible").val(),
			        		"textarea_event_detail":$(".textarea_event_detail[data-rowid="+ idGroup +"]:visible").val(),
			        		"input_total_price_pid":$(".input_total_price_item[data-rowid="+ idGroup +"]:last").val().replace(/\./g,'').replace(',','.').replace(' ',''),
			        	}
			        ];
			    }

			    // Iterate over each row within this divItemGroup
			    $(this).find('.divItem').each(function() {
			        let rowObject = {}; // Create an object to hold inputs for this specific row

			        // Iterate over all input elements within this row
			        $(this).find('select,input[name!="input_total_price_item"]').each(function() {
			            let inputId = $(this).attr('id'); // Get the input field's id attribute
			            let value = $(this).val();        // Get the input field's value

			            // Assign the input value to the corresponding input id key
			            if (inputId == 'input_price' || inputId == 'input_total_price') {
			            	rowObject[inputId] = value.replace(/\./g,'').replace(',','.').replace(' ','');
			            }else{
			            	rowObject[inputId] = value;
			            }
			            
			        });

			        // Push this row's object into the objContentMonreq for the current row-id
			        objContentMonreq[newRowId].push(rowObject);
			    });
				});

	  		var formData = new FormData()

	      formData.append("_token","{{ csrf_token() }}")
	      formData.append("id_money_request",id)
	      formData.append("inputAccNumber",$("#input_acc_number").val())
	      formData.append("inputAccName",$("#input_acc_name").val())
	      formData.append("inputTransferDate",moment($("#input_transfer_date").val()).format('YYYY-MM-DD'))
	      formData.append("arrDataMonreq",JSON.stringify(objContentMonreq))
	      console.log(formData)

	      savePost(swalAccept,url="{{url('pmo/monreq/updateMonReq')}}",formData)
			} else {
				Swal.fire({
          title: 'Error Message!',
          text: 'Please fill all mandatory fields in every category',
          icon: 'error',
          confirmButtonText: 'OK'
        });

				$("input,textarea").map((key,item)=> {
			    if (item.value == '') {
						$(item).next('.invalid-feedback').show()
						$(item).next('.invalid-feedback').text('Please fill '+ $(item).prev('label').text().replace(/[*]/g, "") + '!')
						$(item).closest(".form-group").addClass('needs-validation')
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

		function submitMonreq(){
			let allInputsFilled = $("input[type='text']:visible,input[type='date']:visible").toArray().every(function(input) {
			    return $(input).val() !== "";  // Check if each input is not empty
			});

			let allTextAreasFilled = $("textarea:visible").toArray().every(function(input) {
			    return $(input).val() !== "";  // Check if each input is not empty
			});

			let allSelectsFilled = $("select:visible").toArray().every(function(input) {
			    return $(input).val() !== "";  // Check if each input is not empty
			});

			if (allInputsFilled && allSelectsFilled && allTextAreasFilled) {
			  swalAccept = Swal.fire({
	        title: 'Are You Sure?',
	        text: 'Add Monreq',
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes',
	        cancelButtonText: 'No',
	      })

			  let arrPid = [], objContentMonreq = {}

			  $(".input_pid").map((key,value)=>{
					arrPid.push(value.value)
				})

				$('.divItemGroup').each(function() {
			    let rowId = $(this).attr('data-rowid'); // Get the data-row-id attribute for each divItemGroup
			    let idGroup = rowId.split("-")[1] 
			    let newRowId = arrPid[idGroup] 

			    // Initialize a group for this row-id if it doesn't exist
			    if (!objContentMonreq[newRowId]) {
			    		console.log(idGroup)
			    		console.log($("#textarea_team_name[data-rowid="+ idGroup +"]").val())
			        objContentMonreq[newRowId] = [
			        	{
			        		"input_date_range_start":moment($(".input_date_range[data-rowid="+ idGroup +"]").data('daterangepicker').startDate).format("YYYY-MM-DD"),
			        		"input_date_range_end":moment($(".input_date_range[data-rowid="+ idGroup +"]").data('daterangepicker').endDate).format("YYYY-MM-DD"),
			        		"textarea_team_name":$(".textarea_team_name[data-rowid="+ idGroup +"]").val(),
			        		"textarea_event_detail":$(".textarea_event_detail[data-rowid="+ idGroup +"]").val(),
			        		"input_total_price_pid":$(".input_total_price_item[data-rowid="+ idGroup +"]:last").val().replace(/\./g,'').replace(',','.').replace(' ',''),
			        	}
			        ];
			    }

			    // Iterate over each row within this divItemGroup
			    $(this).find('.divItem').each(function() {
			        let rowObject = {}; // Create an object to hold inputs for this specific row

			        // Iterate over all input elements within this row
			        $(this).find('select,input[name!="input_total_price_item"]').each(function() {
			            let inputId = $(this).attr('id'); // Get the input field's id attribute
			            let value = $(this).val();        // Get the input field's value

			            // Assign the input value to the corresponding input id key
			            if (inputId == 'input_price' || inputId == 'input_total_price') {
			            	rowObject[inputId] = value.replace(/\./g,'').replace(',','.').replace(' ','');
			            }else{
			            	rowObject[inputId] = value;
			            }
			            
			        });

			        // Push this row's object into the objContentMonreq for the current row-id
			        objContentMonreq[newRowId].push(rowObject);
			    });
				});

	  		var formData = new FormData()

	      formData.append("_token","{{ csrf_token() }}")
	      formData.append("inputAccNumber",$("#input_acc_number").val())
	      formData.append("inputAccName",$("#input_acc_name").val())
	      formData.append("inputTransferDate",moment($("#input_transfer_date").val()).format('YYYY-MM-DD'))
	      formData.append("arrDataMonreq",JSON.stringify(objContentMonreq))
	      
	      savePost(swalAccept,url="{{url('pmo/monreq/storeMonReq')}}",formData)
			} else {
				Swal.fire({
          title: 'Error Message!',
          text: 'Please fill all mandatory fields in every category',
          icon: 'error',
          confirmButtonText: 'OK'
        });

				$("input,textarea").map((key,item)=> {
			    if (item.value == '') {
						$(item).next('.invalid-feedback').show()
						$(item).next('.invalid-feedback').text('Please fill '+ $(item).prev('label').text().replace(/[*]/g, "") + '!')
						$(item).closest(".form-group").addClass('needs-validation')
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
                  window.location.assign('{{url("pmo/monreq/detail_monreq?id_detail=")}}'+id);
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

		function validationCheck(data,i){
			if ($(data).val() != '') {

				$(data).next('.invalid-feedback').attr('style','display:none!important')
				$(data).next().next('.invalid-feedback').attr('style','display:none!important')
				$(data).closest(".form-group").removeClass('needs-validation')

				if (data.id == "input_price" || data.id == "input_qty") {
					let dataRowId = $(data).attr("data-rowid")

					let dataId 		= $(data).attr("data-id")

					var priceTotal = 0, priceGrandTotal = 0

					console.log("sinii")
					priceTotal += 
						($(".input_qty[data-id="+ dataId +"]:visible").val() != "" ? 
							parseInt($(".input_qty[data-id="+ dataId +"]:visible").val().trim().replace(/\./g,'').replace(',','.')) * parseInt($(".input_price[data-id="+ dataId +"]:visible").val().trim().replace(/\./g,'').replace(',','.') != "" ? $(".input_price[data-id="+ dataId +"]:visible").val().trim().replace(/\./g,'').replace(',','.') : 0) : 0
						)

					console.log($(".input_price[data-id="+ dataId +"]:visible").val().trim().replace(/\./g,'').replace(',','.'))
					$(".input_total_price[data-id="+ dataId +"]").val(formatter.format(priceTotal))

					$(".divItemGroup[data-rowid='divPID-"+ i +"']:visible").find(".input_total_price:visible").each(function(){
						if ($(this).val() != "") {
							priceGrandTotal += parseInt($(this).val().trim().replace(/\./g,'').replace(',','.'))
						}else{
							priceGrandTotal = priceGrandTotal
						}
					})

					$(".divItemGroup:visible[data-rowid=divPID-"+ i +"]").find(".input_total_price_item:visible").val(formatter.format(priceGrandTotal))
					// formatter.format(priceGrandTotal)
    			$('.money').mask('#.##0', {reverse: true})
				}

				if (data.id == "input_acc_number" || data.id == "input_qty") {
					$(data).val($(data).val().replace(/[^0-9.-]/g, '').replace(/(?!^)-|(\..*?)\./g, ''))
				}
			}
		}

		function contentEditMonreq(count,data,dataSelect,dataRow){
			$(".divPID:first").attr('style','display:none!important')
			// $(".divPID:first").closest(".card-body").find(".row:first-child").show()
			var append = ''
			//pid yang di loop
			append = append + '<div class="row divPID" data-rowid="'+ count +'">'
				append = append + '<div class="col-md-9 col-xs-12">'
					append = append + '<div class="row">'

						append = append + '<div class="col-md-2 col-xs-12">'
							append = append + '<div class="form-group">'
								append = append + '<label>Project ID*</label>'
									append = append + '<select style="width:100%!important;min-width: 100%!important;max-width: 100%!important;" data-rowid="'+ count +'" type="text" name="input_pid" id="input_pid" class="form-control input_pid" onchange="validationCheck(this,'+ count +')"><option></option></select>'
									append = append + '<span class="invalid-feedback"></span>'
							append = append + '</div>'
						append = append + '</div>'

						append = append + '<div class="col-md-10 col-xs-12 divItemGroup" data-rowid="divPID-'+ count +'">'
							$.each(data,function(key,value){
								append = append + '<div class="row divItem" data-rowid="'+ count +'">'
								append = append + '<div class="col-md-3 col-xs-12">'
									append = append + '<div class="form-group">'
											if (key == 0) {
												append = append + '<label>Category*</label>'
											}
											append = append + '<select style="width:100%!important;min-width: 100%!important;max-width: 100%!important;" data-rowid="'+ count +'" type="text" name="input_category" id="input_category" class="form-control input_category" onchange="validationCheck(this,'+ count +')" data-id="'+ count + '-' + key +'">'
											append = append + '<option></option>'
										append = append + '</select>'
										append = append + '<span class="invalid-feedback"></span>'
									append = append + '</div>'
								append = append + '</div>'
								append = append + '<div class="col-md-1 col-xs-12" style="padding-left:0px!important;padding-right:0px!important">'
									append = append + '<div class="form-group">'
										if (key == 0) {
											append = append + '<label>Qty*</label>'
										}
										append = append + '<input type="text" name="input_qty" id="input_qty" data-id="'+ count + '-' + key +'" data-rowid="'+ count +'" class="form-control input_qty" onkeyup="validationCheck(this,'+ count +')" value="'+ value.qty +'">'
										append = append + '<span class="invalid-feedback"></span>'
									append = append + '</div>'
								append = append + '</div>'
								append = append + '<div class="col-md-2 col-xs-12">'
									append = append + '<div class="form-group">'
											if (key == 0) {
												append = append + '<label>Unit*</label>'
											}
											append = append + '<select style="width:100%!important;" data-rowid="'+ count +'" type="text" name="input_unit" id="input_unit" class="form-control input_unit" onchange="validationCheck(this,'+ count +')" data-id="'+ count + '-' + key +'"><option></option>'
										append = append + '</select>'
										append = append + '<span class="invalid-feedback"></span>'
									append = append + '</div>'
								append = append + '</div>'
								append = append + '<div class="col-md-2 col-xs-12">'
									append = append + '<div class="form-group">'
										if (key == 0) {
											append = append + '<label>Price*</label>'
										}
										append = append + '<input type="text" name="input_price" id="input_price" data-id="'+ count + '-' + key +'" data-rowid="'+ count +'" class="form-control input_price money" onkeyup="validationCheck(this,'+ count +')" value="'+ formatter.format(value.price) +'">'
										append = append + '<span class="invalid-feedback"></span>'
									append = append + '</div>'

									if (key === data.length - 1) {
										append = append + '<div class="form-group label_total_dinamis">'
											append = append + '<label class="pull-right">Total</label>'
										append = append + '</div>'
									}
								append = append + '</div>'
								append = append + '<div class="col-md-3 col-xs-12">'
									append = append + '<div class="form-group">'
											if (key == 0) {
												append = append + '<label>Total Price*</label>'
											}
											append = append + '<input type="text" name="input_total_price" id="input_total_price" data-rowid="'+ count +'" class="form-control input_total_price money" data-id="'+ count + '-' + key +'" value="'+ formatter.format(value.total_price) +'" disabled>'
											append = append + '<span class="invalid-feedback"></span>'
									append = append + '</div>'
									if (key === data.length - 1) {
										append = append + '<div class="form-group div_total_dinamis">'
											append = append + '<input type="text" name="input_total_price_item" id="input_total_price_item" data-rowid="'+ count +'" class="form-control input_total_price_item money" disabled value="'+ formatter.format(dataRow.nominal) +'">'
											append = append + '<span class="invalid-feedback"></span>'
										append = append + '</div>'
									}
								append = append + '</div>'

								if (key == 0) {
									append = append + '<div class="col-md-1 col-xs-12">'
										append = append + '<div class="form-group">'
											append = append + '<button style="width:40px;margin-top:15px" class="btn btn-sm text-bg-primary pull-right addRow" onclick="addRowItem('+ count +')" disabled data-rowid="'+ count +'"><i class="bx bx-plus"></i></button>'
										append = append + '</div>'
									append = append + '</div>'
								}

							append = append + '</div>'
							})
						append = append + '</div>'

					append = append + '</div>'

				append = append + '</div>'
				append = append + '<div class="col-md-3 col-xs-12">'
					append = append + '<div style="display: flex;flex-direction: column;gap:5px">'
						append = append + '<div class="form-group">'
							append = append + '<label>Start Date - End Date*</label>'
							append = append + '<div class="input-group">'
								append = append + '<span class="input-group-text">'
									append = append + '<i class="bx bx-calendar"></i>'
								append = append + '</span>'
								append = append + '<input type="text" name="input_date_range" id="input_date_range" data-rowid="'+ count +'" class="form-control input_date_range" onchange="validationCheck(this)">'
								append = append + '<span class="invalid-feedback"></span>'
							append = append + '</div>'
						append = append + '</div>'
						append = append + '<div class="form-group">'
							append = append + '<label>Team Name*</label>'
								append = append + '<textarea class="form-control textarea_team_name" id="textarea_team_name" data-rowid="'+ count +'" name="textarea_team_name" onkeyup="validationCheck(this)">'+ dataRow.team_name +'</textarea>'
								append = append + '<span class="invalid-feedback"></span>'
						append = append + '</div>'
						append = append + '<div class="form-group">'
							append = append + '<label>Event Detail*</label>'
							 	append = append + '<textarea class="form-control textarea_event_detail" id="textarea_event_detail" data-rowid="'+ count +'" name="textarea_event_detail" onkeyup="validationCheck(this)">'+ dataRow.event_detail +'</textarea>'
								append = append + '<span class="invalid-feedback"></span>'
						append = append + '</div>'
					append = append + '</div>'
				append = append + '</div>'
			append = append + '</div>'
			//
			$(".divPID:first").after(append)

			initSelect2(count,'',dataSelect.pid_text,dataSelect.pid,data)
			$('.input_date_range[data-rowid="'+ count +'"]').data('daterangepicker').setStartDate(moment(dataRow.start_date).format('MM/DD/YYYY'));
    	$('.input_date_range[data-rowid="'+ count +'"]').data('daterangepicker').setEndDate(moment(dataRow.end_date).format('MM/DD/YYYY'));
			
		}

		function showEditMonreq(id){
			$.ajax({
				type:"GET",
				url:"{{url('/pmo/monreq/getDetailMonReq')}}",
				data:{
					id_money_request:id
				},
				success:function(result) {

					console.log(result.monReq.pid_details)
					$("#btnDeleteRowPID").prop("disabled",false)
					$(".input_acc_number[data-rowid=0]").val(result.monReq['account_number'])
					$(".input_acc_name[data-rowid=0]").val(result.monReq['account_name'])
					$(".input_transfer_date[data-rowid=0]").val(moment(result.monReq['req_transfer_date']).format('MM/DD/YYYY'))

					result.monReq.pid_details.forEach((value, key) => {
						contentEditMonreq(key,value.details,value,result.monReq.pid_details[key])
					})					
				}
			})
		}

		function btnBack() {
			if (window.location.href.split("?")[1] === undefined) {
				location.href = "{{url('pmo/monreq/index')}}"
			}else{
				location.href = "{{url('pmo/monreq/detail_monreq?id_monreq=')}}"+ window.location.href.split("=")[1]
			}
		}
	</script>
@endsection