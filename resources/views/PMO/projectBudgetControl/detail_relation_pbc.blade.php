@extends('template.main_sneat')
@section('tittle')
Project Budget Control
@endsection
@section('pageName')
Project Budget Control
@endsection
@section('head_css')
    <style type="text/css">
        .select2{
            width:100%!important;
        }
        .selectpicker{
            width:100%!important;
        }

        .dataTables_length{
            display: none
        }
      
        .dataTables_filter {
            display: none;
        }

        .form-group{
            margin-bottom: 15px;
        }

        .pull-right{
            float: right;
        }
    </style>
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
@endsection
@section('content')
    <div class="container-xxl container-p-y flex-grow-1">
        <section class="content-header">
            <h6><a onclick="btnBack()"><button class="btn btn-sm btn-danger"><i class="bx bx-chevron-left"></i> Back</button></a>
                <span id="titleViewPBC"></span></h6>
        </section>
        <section class="content">
            <div class="card">
                <div class="card-header with-border">
                    <div class="row">
                        <div class="col-md-4 col-xs-12 pull-right" style="display:flex;row-gap: 10px;justify-content: space-between;" id="search-table">
                            <div class="form-group" style="display:inline;flex: 3;">
                                <div class="input-group">
                                    <button type="button" id="btnShow" class="btn btn-sm btn-outline-secondary btn-flat dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                      Show 10 entries
                                    </button>
                                    <ul class="dropdown-menu">
                                      <li><a class="dropdown-item" href="#" onclick="$('#table_list_pbc').DataTable().page.len(10).draw();$('#btnShow').html('Show 10 entries')">10</a></li>
                                      <li><a class="dropdown-item" href="#" onclick="$('#table_list_pbc').DataTable().page.len(25).draw();$('#btnShow').html('Show 25 entries')">25</a></li>
                                      <li><a class="dropdown-item" href="#" onclick="$('#table_list_pbc').DataTable().page.len(50).draw();$('#btnShow').html('Show 50 entries')">50</a></li>
                                      <li><a class="dropdown-item" href="#" onclick="$('#table_list_pbc').DataTable().page.len(100).draw();$('#btnShow').html('Show 100 entries')">100</a></li>
                                    </ul>
                                  <input id="searchBar" type="text" class="form-control" placeholder="Search Anything" onkeyup="searchBar('searchBar','table_list_pbc')">
                                    <button id="applyFilterTable" type="button" class="btn btn-sm btn-outline-secondary btn-md" onclick="searchBar('searchBar','table_list_pbc')">
                                      <i class="bx bx-fw bx-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
              
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="table_list_pbc">
                    </table>
                </div>
            </div>
        </section>
    </div>

    <div class="modal" id="modalUpdateRolesEng">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <h6 class="modal-title">Update Data</h6>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label>Engineer Name</label>
                <input type="" name="" id="idInputNameUpdate" class="form-control" disabled>
            </div>

            <div class="form-group">
                <label>Roles</label>
                <select id="idSelectRoleUpdate" class="form-control">
                    <option></option>
                </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-outline-secondary pull-left" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-sm btn-primary" id="saveUpdate">Save changes</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
@endsection
@section('scriptImport')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#titleViewPBC").text('Detail PID '+ window.location.href.split("?")[1].split("&")[1].split("=")[1])
        })

        const jsonData = [
            {
                "no": 1,
                "date": "21-10-2024",
                "name": "Bima Aldi Pratama",
                "role": "Network Engineer",
                "category": "Transport",
                "description": "SPBU Kembangan",
                "amount": "500000",
                "receipt":1000000,
                "image":500000,
                "source":"settlement",
                "no_source":"0001/PMO/MR/I/2024",
            },
            {
                "no": 1,
                "date": "21-10-2024",
                "name": "Bima Aldi Pratama",
                "role": "Network Engineer",
                "category": "Transport",
                "description": "SPBU Kembangan",
                "amount": "500000",
                "receipt":1000000,
                "image":500000,
                "source":"settlement",
                "no_source":"0001/PMO/MR/I/2024",
            },
            {
                "no": 1,
                "date": '21-10-2024',
                "name": 'Yohanis Ferdinand',
                "role": null,
                "category": 'Perjalanan Dinas',
                "description": 'Tiket Pesawat PP Bandung',
                "amount":500000,
                "receipt":1000000,
                "image":500000,
                "source":'PR',
                "id_product":14690,
                "id_project":'102/SNRI/SIP/XI/2024',
                "no_source":'0001/PMO/MR/I/2024',
            },
        ]

        var table = $('#table_list_pbc').DataTable({
            ajax:{
                url:"{{url('pmo/pbc/getViewDetailPBC')}}",   
                data:{
                    pid:window.location.href.split("?")[1].split("&")[1].split("=")[1]
                }            
            },
            columns:[
                {
                    title:"No",
                    render: function (data, type, row, meta) {
                        // Only show "Detail" button for the first row of each group (based on PID)
                        return meta.row + 1;
                    }
                },
                {
                    title:"Date",
                    data:'dates'
                },
                {
                    title:"Name",
                    data:'name'
                },
                {
                    title:"Role",
                    render: function (data, type, row) {
                        // Only show "Detail" button for the first row of each group (based on PID)
                        if (row.role == null) {
                            return '-';
                        }else{
                            return row.role;
                        }
                    }
                },
                {
                    title:"Category",
                    data:'category'
                },
                {
                    title:"Description",
                    data:'description'
                },
                {
                    title:"Amount",
                    data:'nominal',
                    render: function(data, type, row) {
                        return data != null ? $.fn.dataTable.render.number(',', '.', 0, 'Rp ').display(data) : 'Rp 0';
                    }
                },
                {
                    title: "Receipt",
                    render: function (data, type, row) {
                        // Only show "Detail" button for the first row of each group (based on PID)
                        return '<a href='+ row.image +' target="_blank"><i class="bx bx-image"></i> link receipt</a>';
                    }
                },
                {
                    title: "Image",
                    render: function (data, type, row) {
                        // Only show "Detail" button for the first row of each group (based on PID)
                        return '<a href='+ row.image +' target="_blank"><i class="bx bx-image"></i> link image</a>';
                    }
                },
                {
                    title: "Reference",
                    render: function (data, type, row) {
                        // Only show "Detail" button for the first row of each group (based on PID)
                        return '<a target="_blank" href="{{url("/")}}/'+ row.link_route +'">'+ row.nomor +'</a>';
                    }
                },
                {
                    title:"Action",
                    render: function (data, type, row) {
                        if (row.role == null) {
                            return '<button class="btn btn-sm btn-warning" onclick="updateRoleEngineer('+ row.id_product +',\''+ row.id_project +'\',\''+row.name+'\')"><i class="bx bx-edit"></i> Edit</button>';
                        }else{
                            return '';
                        }
                    }
                }
            ]
        });

        function updateRoleEngineer(id_product,pid,name) {
            $("#idSelectRoleUpdate").select2({
                placeholder:"Select Role",
                ajax: {
                url: '{{url("/pmo/pbc/getItemSbe")}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                          id_project:window.location.href.split("?")[1].split("&")[1].split("=")[1], 
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
                dropdownParent:$("#modalUpdateRolesEng")
            })
            $("#modalUpdateRolesEng").modal("show")
            $("#idInputNameUpdate").val(name)
            $("#saveUpdate").attr("onclick","saveUpdate('"+ id_product +"')")
        }

        function saveUpdate(id_product) {
            if ($("#idSelectRoleUpdate").val() == "") {
                Swal.fire({
                    icon:"error",
                    text:"Please Select Role!"
                })
            }else{
                swalAccept = Swal.fire({
                    title: 'Its correct roles for?',
                    text: 'roles can update just once time!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                })

                swalAccept.then((result) => {
                if (result.value) {
                  $.ajax({
                    type:"POST",
                    url:"{{url('/pbc/store/updateRole')}}",
                    data:{
                        _token:"{{ csrf_token() }}",
                        id_product:id_product,
                        id_project:window.location.href.split("?")[1].split("&")[1].split("=")[1],
                        role:$("#idSelectRoleUpdate").val() 
                    },
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
                            location.reload()
                        })
                    },
                    error: function(xhr, status, error) {
                          // Handle errors
                    }
                  }) 
                }        
                })
            }
        }

        function btnBack() {
            window.location = "{{url('pmo/pbc/detail?id_pmo=')}}" + window.location.href.split("?")[1].split("&")[0].split("=")[1] +"&id_project=" + window.location.href.split("?")[1].split("&")[1].split("=")[1]
        }

        function searchBar(id_search,id_table) {
            $("#" + id_table).DataTable().search($('#' + id_search).val()).draw();
        }


    </script>

@endsection