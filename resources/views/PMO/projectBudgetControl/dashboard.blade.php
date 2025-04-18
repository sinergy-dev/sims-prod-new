@extends('template.main_sneat')
@section('tittle')
PMO
@endsection
@section('tittle')
Dashboard
@endsection
@section('head_css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmSAQhPWId5Nd6QxE8To4ADjM2a6n0BrqQdisZ/RPUlm0YycDzvNL1HHAh1nKZqI0kSbif+5upQ==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
    <style type="text/css">
        .select2{
            width:100%!important;
        }
        .selectpicker{
            width:100%!important;
        }

        .chartjsTotalProject-table, th, td{
            border-collapse: collapse;
            border: 1px solid black;
            padding: 10px;
        }

        .chartjsTotalProject-thead{
            font-weight: bold;
            text-align: center;
        }

        .chartjsTotalProject-tbody{
            text-align: center;
        }

        .tableDiv{
            display: grid;
        }

        .chartjs-thead{
            font-weight: bold;
        }

        .table{
            border-top: solid 1px;
        }

        .div-filter-year .btn-flat{
            border-radius: 5px!important;
            color: #999;
            font-weight: 400;
            width: 100%!important;
            background-color: #fff;
        }

        .div-filter-year .btn-flat i {
          color: lightgray;
        }

        .div-filter-year .btn-flat:active{
            color: black;
            font-weight: 500;
            width: 100%!important;
            background-color: #fff;
            border-color: #696cff!important;
        }

        .div-filter-year .btn-flat:hover{
            color: black;
            font-weight: 500;
            width: 100%!important;
            background-color: #fff;
            border: 1px solid #696cff!important;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);
        }

        .div-filter-year .btn-flat:hover i {
          color: slategray;
        }

        .div-filter-year .btn-flat.isClicked {
          color: black;
          font-weight: 500;
          width: 100%!important;
          background-color: #fff;
          border:3px solid #696cff!important;
        }

        .div-filter-year .btn-flat.isClicked i {
          color: slategrey;
        }

        .div-filter-year .select2-container--default .select2-selection--single{
            border-radius: 5px!important;
        }

        /*#totalProjectByHealthAllCanvas {
            width: 100% !important;
            height: 600px !important;
        }*/
        

        /*#totalProjectRunCloseAllCanvas {
            width: 500px !important;
            height: 500px !important;
        }*/

        .chart-container {
            display: flex;
            margin: auto;
            width: 400px;
            height: 400px;
        }
    </style>
@endsection
@section('content')
<div class="container-xxl container-p-y flex-grow-1">
    <section class="content">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="div-filter-year form-group">
                    <button class="btn btn-sm btn-flat btn-outline-primary" id="btnThisYear" onclick="clickYear(this.value)"><i class="bx bx-filter"></i> &nbspThis Year</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="div-filter-year form-group">
                    <button class="btn btn-sm btn-flat btn-outline-primary" id="btnLastYear" onclick="clickYear(this.value)"><i class="bx bx-filter"></i> &nbspLast Year</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="div-filter-year form-group">
                    <select class="select2 form-select" style="width: 100%!important;" id="selectYear" onchange="clickYear(this.value)"><option></option></select>
                </div>
            </div>
        </div>

        <div class="row mb-4" id="BoxId">
            <!--card id-->
        </div>

        <div class="row mb-4">
            <div class="col-md-6 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Total Project Based on Health Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="totalProjectByHealthAllCanvas" width="100%" height="100%"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Total Project Running and Closing</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="totalProjectRunCloseAllCanvas" width="100%" height="100%"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Total Project PM/PC by Health Status</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="totalProjectHealthByPMCanvas" width="400" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
      <!--   <div class="row mb-4">
            <div class="col-md-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Total Project PM/PC by Actual Mandays</h6>
                    </div>
                    <div class="card-body chartBoxTotalProject">
                        <canvas id="totalProjectMandaysByPMCanvas" width="400" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div> -->
    </section>
</div>
@endsection
@section('scriptImport')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('script')
<script type="text/javascript">
    const d = new Date();
    let year = d.getFullYear();

    initiateSelect2Year(year)
    function initiateSelect2Year(year){
        $("#btnThisYear").val(year)
        $("#btnLastYear").val(year-1)
        clickYear(year)
        $.ajax({
            url:"{{url('/PMO/getYearFilter')}}",
            type:"GET",
            success:function(result){
                let yearFilter = []
                result.forEach(function(item){
                    if (year != item.id && year-1 != item.id) {
                        yearFilter.push({id:item.id,text:item.text})
                    }
                })
                $("#selectYear").select2({
                    placeholder:"Other Year",
                    data:yearFilter
                })
            }
        })
    }

    function clickYear(year){
        if (year != "") {
            if ($("#btnThisYear").hasClass("isClicked")) {
                $("#btnThisYear").removeClass("isClicked")
            }else if ($("#btnLastYear").hasClass("isClicked")) {
                $("#btnLastYear").removeClass("isClicked")
            }

            if ($("#selectYear").val() != "") {
                if (year != $("#selectYear").val()) {
                    $("#selectYear").val("").trigger("change")
                }

                if ($("#btnThisYear").val() == year) {
                    $("#btnThisYear").addClass("isClicked")
                }else if ($("#btnLastYear").val() == year) {
                    $("#btnLastYear").addClass("isClicked")
                }
            }else{
                if ($("#btnThisYear").val() == year) {
                    $("#btnThisYear").addClass("isClicked")
                }else if ($("#btnLastYear").val() == year) {
                    $("#btnLastYear").addClass("isClicked")
                }
            }

            initDashboard(year)
        }
    }

    let initChartProjectHealth = null, initChartProjectRunningClosing = null, initChartProjectHealthByPM = null
    function initDashboard(year){
        $.ajax({
            type:"GET",
            url:"{{url('/pmo/pbc/getDashboardChart')}}",
            data:{
                year:year,
            },
            beforeSend:function(result){
                var canvasA = document.getElementById('totalProjectByHealthAllCanvas')
                const ctxA = canvasA.getContext('2d');
                ctxA.clearRect(0, 0, canvasA.width, canvasA.height);

                var canvasB = document.getElementById('totalProjectRunCloseAllCanvas')
                const ctxB = canvasB.getContext('2d');
                ctxB.clearRect(0, 0, canvasB.width, canvasB.height);

                var canvasC = document.getElementById('totalProjectHealthByPMCanvas')
                const ctxC = canvasC.getContext('2d');
                ctxC.clearRect(0, 0, canvasC.width, canvasC.height);
                // initDashboardRunClose(result.totalProjectRunningClosing)
                // initDashboardProjectHealthByPM(result.totalPMByHealthStatus)
            },
            success:function(result) {
                console.log(result.totalProjectBasedHealthStatus)
                initDashboardProjectHealth(result.totalProjectBasedHealthStatus)
                initDashboardRunClose(result.totalProjectRunningClosing)
                initDashboardProjectHealthByPM(result.totalPMByHealthStatus)
            }
        })
    }
    
    function initDashboardProjectHealth(dataChart) {
        if (initChartProjectHealth) {
            initChartProjectHealth.destroy()        
        }

        ctx_projectHealth = document.getElementById('totalProjectByHealthAllCanvas');

        const data = {
            labels: dataChart.labels,
            datasets: [{
                label: 'My First Dataset',
                data: dataChart.dataSet.data,
                backgroundColor: dataChart.dataSet.backgroundColor,
                hoverOffset: 4
            }],
        };

        const config = {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false, // Disable aspect ratio to allow custom sizes
                plugins: {
                    legend: {
                        position: 'bottom',  // Position the legend at the bottom
                        labels: {
                          cardWidth: 20,
                          padding: 10,
                          font: {
                            size: 14,  // Adjust font size if necessary
                          },
                          cardHeight: 20, // Control the height of the card next to each legend item
                        },
                        align:'start'
                    }
                },
            }
        };

        myChartProjectHealth = new Chart(ctx_projectHealth, config);

        return initChartProjectHealth = myChartProjectHealth    
    }

    function initDashboardRunClose(dataChart) {
        if (initChartProjectRunningClosing) {
            initChartProjectRunningClosing.destroy()        
        }

        const data = {
          labels: dataChart.labels,
          datasets: [{
            label: 'My First Dataset',
            data: dataChart.dataSet.data,
            backgroundColor: dataChart.dataSet.backgroundColor,
            hoverOffset: 4
          }]
        };

        const config = {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false, // Disable aspect ratio to allow custom sizes
                plugins: {
                    legend: {
                        position: 'bottom',  // Position the legend at the bottom
                        labels: {
                          cardWidth: 20,
                          padding: 10,
                          font: {
                            size: 14,  // Adjust font size if necessary
                          },
                          cardHeight: 20, // Control the height of the card next to each legend item
                        },
                        align:'center'
                    }
                },
            }
        };

        ctx_running_closing = document.getElementById('totalProjectRunCloseAllCanvas');
        myChartProjectRunningClosing = new Chart(ctx_running_closing, config);

        return initChartProjectRunningClosing = myChartProjectRunningClosing    
    }

    function initDashboardProjectHealthByPM(dataChart) {
        if (initChartProjectHealthByPM) {
            initChartProjectHealthByPM.destroy()        
        }
            
        var arrayDataSet = []
        $.each(dataChart.dataSet,function(keyData,resultData) {
            arrayDataSet.push(
                {
                    label:keyData,
                    data:resultData.data,
                    backgroundColor:resultData.backgroundColor,
                    borderColor:resultData.borderColor,
                    borderWidth:resultData.borderWidth
                }
            )              
        })

        const data = {
            labels: dataChart.labels,  // Categories for x-axis
            datasets: arrayDataSet
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Set the step size to 1 (gap between each tick)
                        }
                    },
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Set the step size for X-axis if needed
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            // Customize the title
                            title: function (tooltipItems) {
                                return tooltipItems[0].label.split(",")[0];
                            },
                            // Customize each label
                            label: function (tooltipItem) {
                                return tooltipItem.dataset.label + ' : ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            },
        };

        ctx_running_closing = document.getElementById('totalProjectHealthByPMCanvas');
        myChartProjectHealthByPM = new Chart(ctx_running_closing, config);

        return initChartProjectHealthByPM = myChartProjectHealthByPM 
    }

    function initDashboardActualMandaysByPM(argument) {
        // body...
    }
</script>
@endsection