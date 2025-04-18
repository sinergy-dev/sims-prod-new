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

        .pull-right{
            float:right;
        }

    </style>
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
    <div class="container-xxl container-p-y flex-grow-1">
        <section class="content">
            <div class="card">
                <div class="card-header with-border">
                    <div class="row">
                        <div class="col-md-4 col-xs-12 pull-right" style="display:flex;row-gap: 10px;justify-content: space-between;" id="search-table">
                            <div style="display: inline;flex: 1;">
                                <button class="btn btn-sm text-bg-primary" id="btnExportList"><i class="bx bx-download"> </i>&nbsp Export Excel</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style="display:inline;flex: 2;margin-right: 10px;">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <i class="bx bx-calendar"></i>
                                    </div>
                                    <input name="filterDateRange" id="filterDateRange" class="form-control">
                                </div>
                            </div>
                        </div>
                            
                        <div class="col-md-4">
                            <div class="form-group" style="display:inline;flex: 3;">
                                <div class="input-group">
                                    <button type="button" id="btnShowSettlement" class="btn btn-sm btn-outline-secondary btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                      Show 10 entries
                                    </button>
                                    <ul class="dropdown-menu">
                                      <li><a href="#" onclick="$('#table_list_pbc').DataTable().page.len(10).draw();$('#btnShowSettlement').html('Show 10 entries')">10</a></li>
                                      <li><a href="#" onclick="$('#table_list_pbc').DataTable().page.len(25).draw();$('#btnShowSettlement').html('Show 25 entries')">25</a></li>
                                      <li><a href="#" onclick="$('#table_list_pbc').DataTable().page.len(50).draw();$('#btnShowSettlement').html('Show 50 entries')">50</a></li>
                                      <li><a href="#" onclick="$('#table_list_pbc').DataTable().page.len(100).draw();$('#btnShowSettlement').html('Show 100 entries')">100</a></li>
                                    </ul>
                                    <input id="searchBar" type="text" class="form-control" placeholder="Search Anything">
                                    <button id="applyFilterSearch" type="button" class="btn btn-sm btn-outline-secondary btn-md" onclick="searchBar('searchBar','table_list_pbc')">
                                      <i class="bx bx-fw bx-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
              
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="table_list_pbc"></table>
                    </div>
                </div>
            </div>
        </section>
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
@endsection

@section('script')
    <script type="text/javascript">

    $(document).ready(function(){
        $("#btnExportList").attr("onclick","exportPbcList()")
    })

    const jsonData = {
        "034/REVO/SIP/V/2023" : [{
            "health_status": "On Budget",
            "pid": "034/REVO/SIP/V/2023",
            "customer_name": "Bank Jateng",
            "project_name": "Pengadaan Oracle Database",
            "pm": "Rendi",
            "pc": "-",
            "project_type": "Supply Only",
            "plan_sbe":1000000,
            "actual_sbe":700000
        }],
        "081/BJTG/SIP/IX/2024" : [{
            "health_status": "Almost Over Budget",
            "pid": "081/BJTG/SIP/IX/2024",
            "customer_name": "Bank Jateng",
            "project_name": "Pengadaan Module SFP",
            "pm": "-",
            "pc": "Friska Marchellina",
            "project_type": "Maintenance",
            "plan_sbe":1000000,
            "actual_sbe":950000
        }],
        "020/PPPR/SIP/III/2023" : [
            {
                "health_status": "Over Budget",
                "pid": "020/PPPR/SIP/III/2023",
                "customer_name": "Paspamres",
                "project_name": "Pemeliharaan dan Perawatan LED Display Utama Tahun 2023",
                "pm": "Rendi Ronaldo",
                "pc": "-",
                "project_type": "Implementation + Maintenance",
                "plan_sbe":1000000,
                "actual_sbe":1500000
            },
            {
                "health_status": "Over Budget",
                "pid": "020/PPPR/SIP/III/2023",
                "customer_name": "Paspamres",
                "project_name": "Pemeliharaan dan Perawatan LED Display Utama Tahun 2023",
                "pm": "-",
                "pc": "Herta Putra",
                "project_type": "Implementation + Maintenance",
                "plan_sbe":1000000,
                "actual_sbe":2000000
            }
        ],
    }

    const flattenedData = [];
    for (const key in jsonData) {
        jsonData[key].forEach(item => {
            flattenedData.push(item);
        });
    }
    
    var table = $('#table_list_pbc').DataTable({
        processing: true,
        serverSide: true,
        "bLengthChange": false,
        ajax:{
            url:"{{url('pmo/pbc/getListProjectBudgetControl')}}",               
        },
        columns: [
            {
                title: "Health Status",
                render: function (data, type, row) {
                  let badgeClass = '';

                  switch (row.health_status) {
                    case 'Almost Over Budget':
                      badgeClass = 'text-bg-warning';
                      break;
                    case 'Over Budget':
                      badgeClass = 'text-bg-danger';
                      break;
                    case 'On Budget':
                      badgeClass = 'text-bg-success';
                      break;
                    default:
                      badgeClass = 'text-bg-secondary';
                  }

                  return `<span class="badge ${badgeClass} px-2 py-1 rounded-pill" style="font-size: 0.75rem; font-weight: bold;">
                    ${row.health_status}
                  </span>`;
                },
                className: "text-center"
            },
              {
                title: "Project ID",
                data: 'id_project'
              },
              {
                title: "Customer Name",
                data: 'customer_name'
              },
              {
                title: "Project Name",
                data: 'name_project'
              },
              {
                title: "PM/PC",
                render: function (data, type, row) {
                  if (row.project_type === 'maintenance') {
                    return row.project_pc;
                  } else if (row.project_type === 'supply_only' || row.project_type === 'implementation') {
                    return row.project_pm;
                  } else {
                    return '-';
                  }
                }
              },
              {
                title: "Project Type",
                data: 'type_project',
                defaulContent:'-'
              },
              {
                title: "Plan SBE",
                data: 'plan_sbe',
                render: function(data, type, row) {
                    return data != null ? $.fn.dataTable.render.number(',', '.', 0, 'Rp ').display(data) : 'Rp 0';
                }
              },
              {
                title: "Actual SBE",
                data: 'actual_sbe',
                render: function(data, type, row) {
                    return data != null ? $.fn.dataTable.render.number(',', '.', 0, 'Rp ').display(data) : 'Rp 0';
                }
              },
              {
                title: "Action",
                render: function (data, type, row) {
                  return `
                    <a target="_blank" href="{{url('pmo/pbc/detail?id_pmo=')}}${row.id}&id_project=${row.id_project}">
                      <button class="btn btn-sm btn-primary">
                        Detail
                      </button>
                    </a>`;
                },
                className: "text-center"
              }
        ],
        columnDefs: [
            { width: "8%", targets: 0},
            { width: "10%", targets: 4},
            { width: "8%", targets: 6},
            { width: "8%", targets: 7}
        ],
        // createdRow: function(row, data, dataIndex) {
        //     // Merge columns and add the "Details" button
        //     var table = this.api(); // Access DataTable instance
        //     var rows = table.rows().data(); 

        //     if (dataIndex > 0) {
        //         var previousData = table.row(dataIndex - 1).data();
        //         console.log(previousData)
        //         console.log(data.pid)

        //         if (previousData.pid === data.pid) {
        //             // Merge the cells (hide the duplicate rows and set rowspan)
        //             var rowspan = table.row(dataIndex - 1).nodes().to$().find('td:eq(9)').attr('rowspan') || 1;
        //             $(row).find('td:eq(9)').attr('rowspan', parseInt(rowspan) + 1);
        //         }
        //     }
        // },
        // "aaSorting": []
        order: [[1, 'asc']]
    });

    function exportPbcList(){
        let startDate = moment($("#filterDateRange").data('daterangepicker').startDate).format("YYYY-MM-DD"),
        endDate = moment($("#filterDateRange").data('daterangepicker').endDate).format("YYYY-MM-DD")

        let url = "{{url('pmo/pbc/exportExcelProjectBudgetList?startDate=')}}" + startDate + "&endDate=" + endDate + "&searchFor=" + $("#searchBar").val()

        window.location = url;
    }

    // function searchBar(search,id_table) {
    //     $('#table_list_pbc').DataTable().ajax.url("{{url('/pmo/pbc/getListProjectBudgetControl')}}?searchFor="+$("#searchBar").val()).load()
    //     // $("#" + id_table).DataTable().search($('#' + search).val()).draw();
    // }

    $('#applyFilterSearch').click(function(){
      $('#table_list_pbc').DataTable().ajax.url("{{url('/pmo/pbc/getListProjectBudgetControl')}}?searchFor="+$("#searchBar").val()+"&startDate="+ $('#filterDateRange').data('daterangepicker').startDate.format('YYYY-MM-DD') +"&endDate="+ $('#filterDateRange').data('daterangepicker').endDate.format('YYYY-MM-DD')).load()
    })  

    $('#searchBar').keypress(function(e){
      if (e.which == 13) {
        console.log($("#searchBar").val())
        $('#table_list_pbc').DataTable().ajax.url("{{url('/pmo/pbc/getListProjectBudgetControl')}}?searchFor="+$("#searchBar").val()+"&startDate="+ $('#filterDateRange').data('daterangepicker').startDate.format('YYYY-MM-DD') +"&endDate="+ $('#filterDateRange').data('daterangepicker').endDate.format('YYYY-MM-DD')).load();

        return false;    //<---- Add this line
      }
    })

    $('#filterDateRange').daterangepicker({
        // Set a default start and end date
        startDate: moment().startOf('year'),
        endDate: moment().endOf('year'),

        // Add predefined custom ranges
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        },

        // Allow custom date ranges
        showCustomRangeLabel: true,

        // Custom year dropdown
        isCustomDate: function (date) {
            // This function can be used for custom logic if needed
            return null;
        },

        locale: {
            format: 'YYYY-MM-DD', // Set the display format for the selected date
        },

    }, function (start, end, label) {
        // Callback function when a date range is selected
        $('#table_list_pbc').DataTable().ajax.url("{{url('/pmo/pbc/getListProjectBudgetControl')}}?searchFor="+$("#searchBar").val()+"&startDate="+ start.format('YYYY-MM-DD') +"&endDate="+ end.format('YYYY-MM-DD')).load();
        console.log('Selected date range: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });

</script>
@endsection