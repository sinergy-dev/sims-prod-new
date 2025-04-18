@extends('template.main_sneat')
@section('tittle')
Project Budget Control
@endsection
@section('pageName')
Detail Project Budget Control
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

        .table tr:first-child th:first-child { /* Top-left corner */
            border-top-left-radius: 10px;
        }
        .table tr:first-child th:last-child { /* Top-right corner */
            border-top-right-radius: 10px;
        }
        .table tr:last-child td:first-child { /* Bottom-left corner */
            border-bottom-left-radius: 10px;
        }
        .table tr:last-child td:last-child { /* Bottom-right corner */
            border-bottom-right-radius: 10px;
        }

        .table tr, th, td {
            border: 1px solid #ccc;!important;
        }

        .table tr th {
            border-top: 1px solid #ccc;!important;
            text-align: center;
        }

        .table-header{
            background-color: #403a7a!important;
            color: white;
        }

        .form-group{
            margin-bottom: 15px;
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
        <section class="content-header">
            <h6><a href="{{url('/pmo/pbc/index')}}"><button class="btn btn-sm btn-danger"><i class="bx bx-chevron-left"></i> Back</button></a>
                <span id="titleViewPBC"> Project Budget Control (PID) </span></h6>
        </section>

        <section class="content">
            <div class="card">
                <div class="card-body">
                    <div style="text-align: center;">
                        <h6 class="project_name">Project Name</h6>
                        <h6 class="customer_name">Customer Name</h6>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Project Owner</label>
                                <input type="text" class="form-control project_owner" name="" value="Herta Putra" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="display: flex;">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Project Type</label>
                                <input type="text" class="form-control project_type" name="" value="Supply Only" disabled>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="pull-right" style="margin-top: 25px;">
                                <button class="btn btn-sm text-bg-primary" id="btnViewDetail"><i class="bx bx-show-alt"></i> View Detail</button>
                                <button class="btn btn-sm text-bg-primary" id="btnExportPdf" style="display:none!important;"><i class="bx bx-download"> </i> Export PDF</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 table-responsive">
                        </div>
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
   <script>
        var accesable = @json($feature_item);
        accesable.forEach(function(item,index){
          $("#" + item).show()          
        })  

        var formatter = new Intl.NumberFormat(['ban', 'id']);

        $(document).ready(function(argument) {
            $.ajax({
                url:"{{url('/pmo/pbc/getDetailProjectBudgetControl')}}",
                data:{
                    id_pmo:window.location.href.split("?")[1].split("&")[0].split("=")[1],
                    id_project:window.location.href.split("?")[1].split("&")[1].split("=")[1]
                },
                type:"GET",
                success:function(result){
                    $('.project_name').text(result[0].name_project)
                    $('.customer_name').text(result[0].customer_name)
                    $('.project_owner').val(result[0].owner)
                    $('.project_type').val(result[0].type_project)
                    let id_pmo = window.location.href.split("?")[1].split("&")[0].split("=")[1];
                    let projectId = window.location.href.split("?")[1].split("&")[1].split("=")[1];
                    url = `{{ url('pmo/pbc/view_detail') }}?id_pmo=${id_pmo}&id_project=${projectId}`;
                    $("#btnViewDetail").attr("onclick", `viewDetail('${url}')`)

                    if (result[0].type_project == 'Maintenance & Managed Service') {
                        var url = "{{action('PMOBudgetingController@exportPdfMaintenance')}}?id_project=" + result[0].id_project + "&id_pmo=" + result[0].id
                        $("#btnExportPdf").attr("onclick","btnExportPdf('"+ url +"')")
                    }else if(result[0].type_project == 'Implementation + Maintenance & Managed Service'){
                        var url = "{{action('PMOBudgetingController@exportPdfImpMaintenance')}}?id_project=" + result[0].id_project + "&id_pmo=" + result[0].id 
                        $("#btnExportPdf").attr("onclick","btnExportPdf('"+ url +"')")
                    }else if(result[0].type_project == 'Implementation'){
                        var url = "{{action('PMOBudgetingController@exportPdfImplementation')}}?id_project=" + result[0].id_project + "&id_pmo=" + result[0].id 

                        $("#btnExportPdf").attr("onclick","btnExportPdf('"+ url +"')")
                    }else if(result[0].type_project == 'Supply Only'){
                        var url = "{{action('PMOBudgetingController@exportPdfSupplyOnly')}}?id_project=" + result[0].id_project + "&id_pmo=" + result[0].id 

                        $("#btnExportPdf").attr("onclick","btnExportPdf('"+ url +"')")
                    }

                    if (result[0].sbe.length == 0) {
                        $(".table-responsive").html("<div style='display:flex;justify-content:center;align-item:center;height:100vh'><div style='display:flex;justify-content:center;align-item:center;width:200px;height:100px;margin-top:150px'>Empty Data!</div></div>")
                    }else{
                        $.each(result[0].sbe,function(key,value){
                            var appendByType = "", appendByItems = "", tableStyle = "", tableHeader = ""

                            if (value.project_type == 'Implementation') {
                                tableStyle = 'border: 1px solid #5b9bd5!important;' 
                                tableHeader = 'background-color: #5b9bd5!important;color: white;'
                            }else if (value.project_type == 'Maintenance') {
                                tableStyle = 'border: 1px solid red!important;' 
                                tableHeader = 'background-color: red!important;color: white;'
                            }else if (value.project_type == 'Supply Only') {
                                tableStyle = 'border: 1px solid #ffc000!important;' 
                                tableHeader = 'background-color: #ffc000!important;color: white;'
                            }

                            appendByType = appendByType + '<table class="table">'
                                appendByType = appendByType + '<tr>'
                                    appendByType = appendByType + '<th colspan="7" class="text-center" style="'+ tableHeader +'">'
                                        appendByType = appendByType + value.project_type
                                    appendByType = appendByType + '</th>'
                                appendByType = appendByType + '</tr>'
                                appendByType = appendByType + '<tr style="'+ tableHeader +'" class="header-table-'+ value.project_type.replaceAll(" ","-") +'">'
                                    appendByType = appendByType + '<th>No</th>'
                                    appendByType = appendByType + '<th>Items</th>'
                                    appendByType = appendByType + '<th>Detail Items</th>'
                                    appendByType = appendByType + '<th>Plan Mandays</th>'
                                    appendByType = appendByType + '<th>Actual Mandays</th>'
                                    appendByType = appendByType + '<th>Plan SBE</th>'
                                    appendByType = appendByType + '<th>Actual SBE</th>'
                                appendByType = appendByType + '</tr>'

                                //append by items
                                $.each(value.items_sbe.detail_sbe,function(keys,values) {
                                    $.each(values,function(key_item,value_item) {
                                        if (key_item == 0) {
                                            appendByItems = appendByItems + '<tr class="table-body">'
                                            appendByItems = appendByItems + '<td></td>'
                                            appendByItems = appendByItems + '<td rowspan="'+ values.length +'" style="text-align:center;vertical-align: middle;">'+ keys +'</td>'
                                            appendByItems = appendByItems + '<td>'+ value_item.detail_item +'</td>'
                                            appendByItems = appendByItems + '<td class="text-center">'+ value_item.plan_mandays +'</td>'
                                            appendByItems = appendByItems + '<td class="text-center">'+ value_item.actual_mandays +'</td>'
                                            appendByItems = appendByItems + '<td class="text-right">'+ formatter.format(value_item.plan_sbe) +'</td>'
                                            appendByItems = appendByItems + '<td class="text-right">'+ formatter.format(value_item.actual_sbe) +'</td>'
                                            appendByItems = appendByItems + '</tr>'
                                        }else{
                                            //loop untuk detail item
                                            appendByItems = appendByItems + '<tr class="table-body">'
                                                appendByItems = appendByItems + '<td></td>'
                                                appendByItems = appendByItems + '<td>'+ value_item.detail_item +'</td>'
                                                appendByItems = appendByItems + '<td class="text-center">'+ value_item.plan_mandays +'</td>'
                                                appendByItems = appendByItems + '<td class="text-center">'+ value_item.actual_mandays +'</td>'
                                                appendByItems = appendByItems + '<td class="text-right">'+ formatter.format(value_item.plan_sbe) +'</td>'
                                                appendByItems = appendByItems + '<td class="text-right">'+ formatter.format(value_item.actual_sbe) +'</td>'
                                            appendByItems = appendByItems + '</tr>'
                                        }
                                        //footer
                                        //sampai sini
                                    })

                                    $.each(value.items_sbe.grouped_sums,function(key_sum,value_sum) {
                                        if (key_sum == keys) {
                                            appendByItems = appendByItems + '<tr style="'+ tableHeader +'">'
                                                appendByItems = appendByItems + '<th colspan="5">Total Cost</th>'
                                                appendByItems = appendByItems + '<th style="text-align:right!important">'+ formatter.format(value_sum.total_plan_sbe) +'</th>'
                                                appendByItems = appendByItems + '<th style="text-align:right!important">'+ formatter.format(value_sum.total_actual_sbe) +'</th>'
                                            appendByItems = appendByItems + '</tr>'
                                            appendByItems = appendByItems + '<tr>'
                                                appendByItems = appendByItems + '<th colspan="7"></th>'
                                            appendByItems = appendByItems + '</tr>'
                                        }
                                    })
                                })
                                
                                appendByType = appendByType + '<tr style="'+ tableHeader +'">'
                                    appendByType = appendByType + '<th colspan="5">Function</th>'
                                    appendByType = appendByType + '<th>Total Plan SBE</th>'
                                    appendByType = appendByType + '<th>Total Actual SBE</th>'
                                appendByType = appendByType + '</tr>'
                                //<!-- loop data-->
                                $.each(value.items_sbe.grouped_sums,function(key_sum,value_sum) {
                                    appendByType = appendByType + '<tr>'
                                        appendByType = appendByType + '<td colspan="5">'+ key_sum +'</td>'
                                        appendByType = appendByType + '<td class="text-right">'+ formatter.format(value_sum.total_plan_sbe)  +'</td>'
                                        appendByType = appendByType + '<td class="text-right">'+ formatter.format(value_sum.total_actual_sbe) +'</td>'
                                    appendByType = appendByType + '</tr>'
                                })

                                appendByType = appendByType + '<tr style="'+ tableHeader +'">'
                                    appendByType = appendByType + '<th colspan="5">Total '+ value.project_type +' Budget</th>'
                                    appendByType = appendByType + '<th style="text-align:right!important">'+ formatter.format(value.items_sbe.function_cost_plan_sbe) +'</th>'
                                    appendByType = appendByType + '<th style="text-align:right!important">'+ formatter.format(value.items_sbe.function_cost_actual_sbe) +'</th>'
                                appendByType = appendByType + '</tr>'
                            appendByType = appendByType + '</table>'

                            $(".table-responsive").append(appendByType)
                            $(".header-table-"+value.project_type.replaceAll(" ","-")).after(appendByItems)

                        })
                    }
                    
                }
            })
        })

        function viewDetail(url) {
            // Open the URL in a new tab
            window.open(url, "_blank");
        }

        function btnExportPdf(url) {
            let year = new Date().getFullYear()
            window.open(url, '_blank')
            // window.location = url + "?year=" + year;
        }
   </script>
@endsection