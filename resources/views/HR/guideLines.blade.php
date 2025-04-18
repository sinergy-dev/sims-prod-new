@extends('template.main_sneat')
@section('tittle')
	Bookmark
@endsection
@section('pageName')
	Bookmark
@endsection
@section('head_css')
	<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}"/>
	<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
	<style type="text/css">
		.form-group{
			margin-bottom: 15px;
		}

		.pull-right{
			float: right;
		}
	</style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
	<section class="content">
		<div class="card">
		    <div class="card-header with-border">
		        <div class="pull-right">
	            	<button class="btn btn-xs btn-success pull-right" id="AddGuide" style="display: none">
	            		<i class="bx bx-plus"> </i>&nbsp Bookmark
	            	</button>
		        </div>
		    </div>

		    <div class="card-body">
		    	<div class="nav-tabs-custom">
		            <ul class="nav nav-tabs" id="myTab">
		              <li class="nav-item" id="tab_1"><a class="nav-link active" type="button" data-bs-target="#kebijakan" data-bs-toggle="tab" onclick="changeTab('kebijakan')" aria-expanded="false">Kebijakan</a></li>
		              <li class="nav-item" id="tab_2"><a class="nav-link" type="button" data-bs-target="#peraturan" data-bs-toggle="tab" onclick="changeTab('peraturan')" aria-expanded="true">Peraturan</a></li>
		              <li class="nav-item" id="tab_3"><a class="nav-link" type="button" data-bs-target="#panduan" data-bs-toggle="tab" onclick="changeTab('panduan')" aria-expanded="true">Panduan</a></li>
		              <li class="nav-item" id="tab_4"><a class="nav-link" type="button" data-bs-target="#product" data-bs-toggle="tab" onclick="changeTab('product')" aria-expanded="true">Product Update</a></li>
		              <li class="nav-item" id="tab_5"><a class="nav-link" type="button" data-bs-target="#other" data-bs-toggle="tab" onclick="changeTab('other')" aria-expanded="false">Other</a></li>
		            </ul>
		            <div class="tab-content">
		              <div class="tab-pane show active" id="kebijakan">
		              	<div class="table-responsive">
							        <table class="table table-bordered table-striped" id="tableIndex" width="100%" cellspacing="0">
							          <thead>
							            <tr>
							            <th width="5%">No</th>
							            <th width="20%">Title</th>
							            <th>Description</th>
							            <th width="30%">Source of Information</th>
							            <th width="15%">Action</th>
							            <th width="15%">Action</th>				            
							            </tr>
							          </thead>
							          <tbody>
							          </tbody>
							          <tfoot>
							          </tfoot>
							        </table>
					    			</div>
		              </div>
		            </div>
		        </div>
		  	</div>
	    </div>
	</section>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="AddGuideModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="titleModal">Add Bookmark</h6>
      </div>
      <div class="modal-body" id="modal-body">
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-xs btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-xs btn-primary" id="submitGuide">Submit</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scriptImport')
	<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
	<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
	<script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		var accesable = @json($feature_item);
		accesable.forEach(function(item,index){
			$("#" + item).show()
		})

		if (accesable.includes('AddGuide')) {
			var columns = datatable.columns(5)
			columns.visible(!columns.visible()) 
		}else{
			var columns = datatable.columns(4)
			columns.visible(!columns.visible())
		}
	})
	
	autosizeWow() 

	function autosizeWow(){
		autosize(document.getElementById("description"));
		autosize(document.getElementById("link"));
	}	

	$("#AddGuide").click(function(){
		$('#titleModal').text('Add Bookmark')
		$('#submitGuide').show().attr("onclick","submitGuide('','submit')")

		$('#efective-date-form').show()

		$('#AddGuideModal').modal('show')		
		$('#modal-body').empty()
		prepend = ''
		prepend = prepend + '<div class="form-group" id="select-type">'
      		prepend = prepend + '<label>Type</label>'
      		prepend = prepend + '<select id="type" name="type" class="select2 form-control" style="width: 100%!important">'
      			prepend = prepend + '<option value="">Select Type...</option>'
      			prepend = prepend + '<option value="kebijakan">Kebijakan</option>'
      			prepend = prepend + '<option value="peraturan">Peraturan</option>'
      			prepend = prepend + '<option value="panduan">Panduan</option>'
      			prepend = prepend + '<option value="product">Product Update</option>'      			
      			prepend = prepend + '<option value="other">Other</option>'
      		prepend = prepend + '</select>'
      	prepend = prepend + '</div>'
      	prepend = prepend + '<div class="form-group" id="title-form">'
      		prepend = prepend + '<label>Title</label>'
      		prepend = prepend + '<textarea class="form-control" id="title" name="title" placeholder="Enter Title" height></textarea>'
      	prepend = prepend + '</div>'
      	prepend = prepend + '<div class="form-group" id="desc-form">'
      		prepend = prepend + '<label>Description</label>'
      		prepend = prepend + '<textarea class="form-control" id="description" placeholder="Enter Description" name="description" height></textarea>'
      	prepend = prepend + '</div>'
      	prepend = prepend + '<div class="form-group" id="source-form">'
      		prepend = prepend + '<label>Document Link</label>'
      		prepend = prepend + '<textarea class="form-control" id="link" name="link" placeholder="Enter Document Link"></textarea>'
      	prepend = prepend + '</div>'
      	prepend = prepend + '<div class="form-group" id="efective-date-form">'
      		prepend = prepend + '<label>Efective Date</label>'
      		prepend = prepend + '<div class="input-group">'
	          prepend = prepend + '<div class="input-group-text">'
	            prepend = prepend + '<i class="bx bx-calendar"></i>'
	          prepend = prepend + '</div>'
	      	  prepend = prepend + '<input type="text" class="form-control" name="efective_date" id="efective_date">'
	        prepend = prepend + '</div>'
      	prepend = prepend + '</div>'

      	$('#modal-body').html(prepend)

		title = 'Buat Kebijakan dan Peraturan'
		initDate()
		initSelect()
	})

	function viewGuide(id){
		$('#AddGuideModal').modal('show')
		document.getElementById("submitGuide").classList.add('d-none') 
		$('#modal-body').empty()
		
		$.ajax({
	        url:"getGuideIndexById",
	        type:"GET",
	        data:{
	        	id:id,
	        },
	        success:function(result){
	        	console.log(result)
	        	prepend = ''
				$('#titleModal').html('<label>'+result[0].title_guide+'</label>')
				prepend = prepend + '<div class="form-group"><label>Description</label>'
				prepend = prepend + '<div>' + result[0].description + '</div>'
				prepend = prepend + '</div>'

				prepend = prepend + '<div class="form-group"><label>Efective Date</label>' + '<div>' + moment(result[0].efective_date).format('LL') + '</div>' + '</div>'
				prepend = prepend + '<hr>'
				prepend = prepend + '<div class="form-group">'
				prepend = prepend + '<label>Source of Information</label>'
				prepend = prepend + '<div><a href='+result[0].link_url+' target="_blank"><i class="bx bx-external-link fa-2x"></i>'+result[0].link_url + '</a></div>'
				prepend = prepend + '</div>'

				$('#modal-body').html(prepend)
        	},
    	})
		$('#submitGuide').hide()
	}

	function editGuide(id){		
		$('#titleModal').text('Update Bookmark')
		document.getElementById("submitGuide").classList.remove('d-none') 
		$('#AddGuideModal').modal('show')

		$('#modal-body').empty()
		prepend = ''
      	prepend = prepend + '<div class="form-group" id="title-form">'
      		prepend = prepend + '<label>Title</label>'
      		prepend = prepend + '<textarea placeholder="Enter Title" class="form-control" id="title" name="title" height></textarea>'
      	prepend = prepend + '</div>'
      	prepend = prepend + '<div class="form-group" id="desc-form">'
      		prepend = prepend + '<label>Description</label>'
      		prepend = prepend + '<textarea class="form-control" id="description" name="description" placeholder="Enter Description" height></textarea>'
      	prepend = prepend + '</div>'
      	prepend = prepend + '<div class="form-group" id="source-form">'
      		prepend = prepend + '<label>Document Link</label>'
      		prepend = prepend + '<textarea class="form-control" id="link" placeholder="Enter Document Link" name="link"></textarea>'
      	prepend = prepend + '</div>'
      	$('#modal-body').html(prepend)

		$.ajax({
	        url:"getGuideIndexById",
	        type:"GET",
	        data:{
	        	id:id,
	        },
	        success:function(result){
	        	console.log(result)
	        	$('#description').val(result[0].description)
				$('#efective_date').val(result[0].efective_date)
				$('#link').val(result[0].link_url)
				$('#title').val(result[0].title_guide)
        	},
    	})
		
		initDate()
		initSelect()
		autosizeWow()
		$('#submitGuide').show().attr("onclick","submitGuide('"+id+"','update')")
		title = 'Update Kebijakan dan Peraturan'
	}

	function deleteGuide(id){
		Swal.fire({
		  title: 'Hapus Kebijakan & Peraturan?',
		  text: "Anda Yakin?",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Ya, Hapus!'
		}).then((result) => {
			if (result.value) {
  		        Swal.fire({
	              title: 'Please Wait..!',
	              text: "Deleting..",
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
	              type:"GET",
	              url:"{{url('deleteGuide')}}",
	              data:{
	              	id:id
	              },
	              success: function(result){
	                Swal.showLoading()
	                Swal.fire(
	                  'Successfully!',
	                  'success'
	                ).then((result) => {
	                  if (result.value) {
	                    datatable.columns.adjust().draw();
	                    if (window.location.hash.replace('#','') == "") {
      						datatable.ajax.url("{{url('getGuideIndex')}}?type=kebijakan").load();
	                    }else{
      						datatable.ajax.url("{{url('getGuideIndex')}}?type="+window.location.hash.replace('#','')).load();
	                    }
	                  }
	                })
	              },
	            });
          	}	
		})
	}
	
	function initDate(){
		$("#efective_date").flatpickr({
			autoclose: true,
		})
	}
	
	function initSelect(){
		$(".select2").select2({
				dropdownParent:$("#AddGuideModal")
		})
	}

	datatable = $("#tableIndex").DataTable({
		"processing": true,
		"ajax":{
		    "type":"GET",
		    "url":"{{url('getGuideIndex')}}",
	    },
	    "columns": [
	      { 
	      	render: function (data,type,row,meta){
	      		return meta.row+1
	      	}
	      },
	      { "data": "title_guide" },
	      {
	      	render: function(data,type,row,meta){
	      		return row.description;
	      	}
	      },
	      { 
	      	render: function(data,type,row,meta){
	      		return "<a href="+ row.link_url+" target='_blank'><u><i>"+ row.link_url.substring(0, 50) + ". . ." +"</i></u></a>"

	      	}
	      },
	      { 
	      	render: function ( data, type, row, meta ) {
	      		return '<button class="btn btn-xs btn-primary" style="width:35px;margin-right:5px" onclick="viewGuide('+row.id+')"><i class="bx bx-show"></i></button><button class="btn btn-xs btn-warning" style="width:35px;margin-right:5px" onclick="editGuide('+row.id+')"><i class="bx bx-edit"></i></button><button class="btn btn-xs btn-danger" style="width:35px;margin-right:5px"  onclick="deleteGuide('+row.id+')"><i class="bx bx-trash"></i></button>'  	            
	        }
	      },
	      {
	      	render: function (data, type, row, meta){
	      		return '<button class="btn btn-xs btn-primary" style="width:35px;margin-right:5px" onclick="viewGuide('+row.id+')"><i class="bx bx-show"></i></button>'

	      	}
	      },
	    ],
	})

	function submitGuide(id,status){
	  type = $('#type').val()

	  if ($('#type').val() == '') {
	  	 Swal.fire({
          title: 'Type is not selected',
	        text: "Please select type first!",
	        icon: 'warning',
	        showCancelButton: false,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes',
        })
	  }else if ($('#title').val() == '') {
	  	Swal.fire({
        title: 'Title is not filled',
        text: "Please fill Title first!",
        icon: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
      })

	  }else if ($('#description').val() == '') {
	  	Swal.fire({
        title: 'Description is not filled',
        text: "Please fill Description first!",
        icon: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
      })

	  }else if ($('#link').val() == '') {
	  	Swal.fire({
        title: 'Link Source is not filled',
        text: "Please fill source first!",
        icon: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
      })

	  }else if($('#efective_date').val() == ''){
	  	Swal.fire({
        title: 'Date is not selected',
        text: "Please select Date first!",
        icon: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
      })

	  }else{
	  	if (status == 'submit') {
				swalAccept = Swal.fire({
	        title: title,
	        text: "Yakin?",
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes',
	        cancelButtonText: 'No',
	      })

	      url = "{{url('storeGuide')}}"
			}else{
				swalAccept = Swal.fire({
		          title: title,
		          text: "Yakin?",
		          icon: 'warning',
		          showCancelButton: true,
		          confirmButtonColor: '#3085d6',
		          cancelButtonColor: '#d33',
		          confirmButtonText: 'Yes',
		          cancelButtonText: 'No',
		        })

		        url = "{{url('updateGuide')}}"
			}		

	    swalAccept.then((result) => {
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
	            type:"GET",
	            url:url,
	            data:{
	            	id:id,
	              description:$('#description').val(),
	              link:$('#link').val(),
	              title:$('#title').val(),	                
	              type:$('#type').val(),
	              efective_date:moment($('#efective_date').val()).format('YYYY-MM-DD')
	            },
	            success: function(result){
	              Swal.showLoading()
		              Swal.fire(
		                'Successfully!',
		                'success'
		              ).then((result) => {
		                if (result.value) {
		                  $("#AddGuideModal").modal('toggle')
		                  datatable.columns.adjust().draw();
		  					datatable.ajax.url("{{url('getGuideIndex')}}?type="+type).load();
		  					if (type == 'kebijakan') {
		  						$('#tab_1').addClass('active')
		  						$('#tab_2').removeClass('active')
		  						$('#tab_3').removeClass('active')
		  						$('#tab_4').removeClass('active')
		  					}else if (type == 'peraturan') {
		  						$('#tab_1').removeClass('active')
		  						$('#tab_2').addClass('active')
		  						$('#tab_3').removeClass('active')
		  					}else if(type == 'panduan'){
		  						$('#tab_1').removeClass('active')
		  						$('#tab_2').removeClass('active')
		  						$('#tab_3').addClass('active')
		  						$('#tab_4').removeClass('active')
		  					}else{
		  						$('#tab_1').removeClass('active')
		  						$('#tab_2').removeClass('active')
		  						$('#tab_3').removeClass('active')
		  						$('#tab_4').addClass('active')
		  					}
		                }
		              })
		            },
				      });
				    }	        
				  })
		  	}		
	}

	function changeTab(id){
		console.log(id)
		$(".tab-pane").attr("id",id)
		$(".tab-pane").addClass("active show")
		datatable.clear().draw();
    datatable.ajax.url("{{url('getGuideIndex')}}?type="+id).load();
	}

  // $('#myTab a').click(function(e) {
  //   e.preventDefault();
  //   $(this).tab('show');
  // });

  // store the currently selected tab in the hash value
  // $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
  //   var id = $(e.target).attr("href").substr(1);
  //   window.location.hash = id;
  // });

  // on load of the page: switch to the currently selected tab
  // var hash = window.location.hash;
  // $('#myTab a[href="' + hash + '"]').tab('show');

  if (window.location.hash.replace('#','') != "") {
    datatable.ajax.url("{{url('getGuideIndex')}}?type="+window.location.hash.replace('#','')).load();
		// datatable.ajax.url("{{url('getGuideIndex')}}?type=kebijakan").load();
	}
  </script>
</script>
@endsection
