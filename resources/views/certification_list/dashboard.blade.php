@extends('template.main_sneat')
@section('title')
    Dashboard Certification
@endsection
@section('pageName')
    Dashboard Certification
@endsection
@section('head_css')
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-fixedcolumns-bs5/fixedcolumns.bootstrap5.css')}}" />    <link rel="preload" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmSAQhPWId5Nd6QxE8To4ADjM2a6n0BrqQdisZ/RPUlm0YycDzvNL1HHAh1nKZqI0kSbif+5upQ==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
    <link rel="preload" href="{{asset('/plugins/iCheck/all.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.2.4/themes/blue/pace-theme-flash.min.css" />
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.min.css" integrity="sha512-Bhi4560umtRBUEJCTIJoNDS6ssVIls7oiYyT3PbhxZV+9uBbLVO/mWo56hrBNNbIfMXKvtIPJi/Jg+vpBpA7sg==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" onload="this.onload=null;this.rel='stylesheet'"/>

    <style type="text/css">
        html,body,buttons,input,textarea,etc {
            font-family: inherit;
        }

        p > strong::before{
            content: "@";
        }

        input[type=file]::-webkit-file-upload-button {
            display: none;
        }

        input::file-selector-button {
            display: none;
        }

        .cbDraft:disabled,
        .cbDraft[disabled]{
            border-color: rgba(118, 118, 118, 0.3);
            background: #3c8dbc !important;
            color: #3c8dbc !important;
        }

        .icheckbox_minimal-blue:disabled{
            background: #3c8dbc !important;
        }
        .icheckbox_minimal-blue:disabled{
            background: #3c8dbc !important;
            border: 1px solid #d4d4d5;
        }
    </style>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-4  mb-4">
                    <div class="form-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-flat pull-left" style="width:100%" id="inputRangeDate">
                            <i class="bx bx-calendar"></i> Date range picker
                        <span>
                            <i class="bx bx-caret-down"></i>
                        </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row mb-2">
            <div class="col-sm-6 ">
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h3 class="card-title">Total Exam By Status</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <div class="chart-responsive">
                                    <canvas id="doughnutChartExamByStatus" height="300" width="400" style="width: 400px; height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 ">
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h3 class="card-title">Total Exam</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <div class="chart-responsive">
                                    <canvas id="pieChartExam" height="300" width="400" style="width: 400px; height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h3 class="card-title">Total Exam By Purpose</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <div class="chart-responsive">
                                    <canvas id="barChartExamByPurpose" height="300" width="400" style="width: 400px; height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 ">
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h3 class="card-title">Total Exam By Division</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <div class="chart-responsive">
                                    <canvas id="barChartExamByDivision" height="300" width="400" style="width: 400px; height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-6 ">
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h3 class="card-title">Total Exam By Partner</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <div class="chart-responsive">
                                    <canvas id="pieChartExamByPartner" height="300" width="400" style="width: 400px; height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 ">
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h3 class="card-title">Total Exam By Level</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <div class="chart-responsive">
                                    <canvas id="doughnutChartExamByLevel" height="300" width="400" style="width: 400px; height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h3 class="card-title">Top 10 Expired Certificate</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="nav-tabs-custom">
                                <div class="tab-content">
                                    <div class="tab-pane show active" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-bordered nowrap table-striped dataTable data" id="top10ExpiredCertificate" width="100%" cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Certificate</th>
                                                    <th>Expired Date</th>
                                                </tr>
                                                </thead>
                                            </table>
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
@endsection
@section('scriptImport')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.2.4/pace.min.js"></script>
    <script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
    <script type="text/javascript" src="{{asset('/plugins/iCheck/icheck.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.all.min.js" integrity="sha512-ng0ComxRUMJeeN1JS62sxZ+eSjoavxBVv3l7SG4W/gBVbQj+AfmVRdkFT4BNNlxdDCISRrDBkNDxC7omF0MBLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.js" integrity="sha512-SSQo56LrrC0adA0IJk1GONb6LLfKM6+gqBTAGgWNO8DIxHiy0ARRIztRWVK6hGnrlYWOFKEbSLQuONZDtJFK0Q==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
@endsection
@section('script')
    <script>

        let chartExamByStatus = document.getElementById("doughnutChartExamByStatus");
        let chartExam = document.getElementById("pieChartExam");
        let chartExamByPurpose = document.getElementById("barChartExamByPurpose");
        let chartExamByDivision = document.getElementById("barChartExamByDivision");
        let chartExamByPartner = document.getElementById("pieChartExamByPartner");
        let chartExamByLevel = document.getElementById("doughnutChartExamByLevel");
        var arrColorStatus = [], arrColorExam = [], arrColorPurpose = [], arrColorDivision = [], arrColorPartner = [], arrColorLevel = []
        $(document).ready(function () {
            initGetDataChartStatus();
            initGetDataChartExam();
            initGetDataChartPurpose();
            initGetDataChartDivision();
            initGetDataChartPartner();
            initGetDataChartLevel();
            initCertificationTable();

            $('#inputRangeDate').daterangepicker({
                ranges: {
                    'Today'       : [moment(), moment()],
                    'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                    'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },function (start, end) {
                $('#inputRangeDate').html("")
                $('#inputRangeDate').html('<i class="fa fa-calendar"></i> <span>' + start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY') + '</span>&nbsp<i class="fa fa-caret-down"></i>');

                var startDay = start.format('YYYY-MM-DD');
                var endDay = end.format('YYYY-MM-DD');

                $("#startDateFilter").val(startDay)
                $("#endDateFilter").val(endDay)

                startDate = start.format('D MMMM YYYY');
                endDate = end.format('D MMMM YYYY');

                if (startDay != undefined && endDay != undefined) {
                    initGetDataChartStatus(startDay, endDay);
                    initGetDataChartExam(startDay, endDay);
                    initGetDataChartPurpose(startDay, endDay);
                    initGetDataChartDivision(startDay, endDay);
                    initGetDataChartPartner(startDay, endDay);
                    initGetDataChartLevel(startDay, endDay);
                }
            });

            $.ajax({
                url:"{{url('asset/getColor')}}",
                type:"GET",
                success:function(result){
                    $.each(result.colors,function(item,value){
                        if (value.hex != "000000" && value.hex != "0000FF") {
                            arrColorDivision.push("#"+value.hex)
                            arrColorExam.push("#"+value.hex)
                            arrColorPartner.push("#"+value.hex)
                            arrColorPurpose.push("#"+value.hex)
                            arrColorLevel.push("#"+value.hex)
                            arrColorStatus.push("#"+value.hex)

                        }
                    })

                    arrColorDivision  = arrColorDivision
                    arrColorExam = arrColorExam
                    arrColorPartner = arrColorPartner
                    arrColorPurpose = arrColorPurpose
                    arrColorLevel = arrColorLevel
                    arrColorStatus = arrColorStatus

                },
                async: false
            })

            function initGetDataChartStatus(startDate, endDate) {
                $.ajax({
                    url:"{{url('certification_list/getChartExamByStatus')}}",
                    type:"GET",
                    data:{
                        startDate: startDate,
                        endDate: endDate
                    },
                    success:function(response){
                        InitiateChartStatus(arrColorStatus,response,"doughnutChartExamByStatus")
                    }
                })
            }

            let initiateStatusChart = null;

            function InitiateChartStatus(arrColor, result, chartCanvasId) {
                if (initiateStatusChart) {
                    initiateStatusChart.destroy();
                }

                const totalAll = result.reduce((sum, item) => sum + item.total, 0);

                const sortedData = [...result].sort((a, b) => b.total - a.total);
                const top10 = sortedData.slice(0, 10);
                const top10Status = top10.map(item => item.status);

                const labels = result.map(item => item.status);
                const values = result.map(item => item.total);
                const percentages = result.map(item =>
                    ((item.total / totalAll) * 100).toFixed(2)
                );

                const backgroundColor = result.map(item => {
                    switch (item.status.toLowerCase()) {
                        case 'approved':
                            return '#1e7e34';
                        case 'new':
                            return '#0056b3';
                        case 'rejected':
                            return '#a71d2a';
                        case 'circular':
                            return '#b38f00';
                        default:
                            return '#6c757d';
                    }
                });
                const chartData = {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: backgroundColor,
                        hoverOffset: 4
                    }]
                };

                const options = {
                    plugins: {
                        legend: {
                            position: 'right',
                            display: true,
                            labels: {
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    const filtered = data.labels.map((label, i) => {
                                        if (top10Status.includes(label)) {
                                            const value = chart.data.datasets[0].data[i];
                                            const percent = percentages[i];
                                            const color = chart.data.datasets[0].backgroundColor[i];

                                            return {
                                                text: `${label} : ${value} (${percent}%)`,
                                                fillStyle: color,
                                                strokeStyle: color,
                                                lineWidth: 1,
                                                index: i
                                            };
                                        }
                                    }).filter(Boolean);

                                    return filtered;
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label;
                                    const value = context.raw;
                                    const percent = percentages[context.dataIndex];
                                    return `${label} - ${value} (${percent}%)`;
                                }
                            }
                        }
                    }
                };

                const ctx = document.getElementById(chartCanvasId).getContext("2d");
                initiateStatusChart = new Chart(ctx, {
                    type: "doughnut",
                    data: chartData,
                    options: options
                });
            }

            function initGetDataChartExam(startDate, endDate) {
                $.ajax({
                    url:"{{url('certification_list/getChartExam')}}",
                    type:"GET",
                    data:{
                        startDate: startDate,
                        endDate: endDate
                    },
                    success:function(response){
                        InitiateChartExam(arrColorExam,response,"pieChartExam")
                    }
                })
            }

            let initiateExamChart = null;

            function InitiateChartExam(arrColor, result, chartCanvasId) {
                if (initiateExamChart) {
                    initiateExamChart.destroy();
                }

                const totalAll = result.reduce((sum, item) => sum + item.total, 0);

                const sortedData = [...result].sort((a, b) => b.total - a.total);
                const top10Status = sortedData.slice(0, 10).map(item => item.status);

                const labels = result.map(item => item.status);
                const values = result.map(item => item.total);
                const percentages = result.map(item =>
                    ((item.total / totalAll) * 100).toFixed(2)
                );

                const backgroundColor = result.map(item => {
                    switch (item.status.toLowerCase()) {
                        case 'request date':
                            return '#e4b731 '; // Dark yellow
                        case 'exam date':
                            return '#1e7e34'; // Dark green
                        default:
                            return '#6c757d'; // Grey fallback
                    }
                });

                const chartData = {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: backgroundColor,
                        hoverOffset: 4
                    }]
                };

                const options = {
                    plugins: {
                        legend: {
                            position: 'right',
                            display: true,
                            labels: {
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    return data.labels.map((label, i) => {
                                        const value = data.datasets[0].data[i];
                                        const percent = percentages[i];
                                        const color = data.datasets[0].backgroundColor[i];

                                        return {
                                            text: `${label} : ${value} (${percent}%)`,
                                            fillStyle: color,
                                            strokeStyle: color,
                                            lineWidth: 1,
                                            index: i
                                        };
                                    });
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label;
                                    const value = context.raw;
                                    const percent = percentages[context.dataIndex];
                                    return `${label} - ${value} (${percent}%)`;
                                }
                            }
                        }
                    }
                };

                const ctx = document.getElementById(chartCanvasId).getContext("2d");
                initiateExamChart = new Chart(ctx, {
                    type: "pie",
                    data: chartData,
                    options: options
                });
            }

            function initGetDataChartPurpose(startDate, endDate) {
                $.ajax({
                    url:"{{url('certification_list/getChartExamByPurpose')}}",
                    type:"GET",
                    data:{
                        startDate: startDate,
                        endDate: endDate
                    },
                    success:function(response){
                        InitiateChartPurpose(arrColorPurpose,response,"barChartExamByPurpose")
                    }
                })
            }

            let initiateChartPurpose = null;

            function InitiateChartPurpose(arrColor, result, chartCanvasId) {
                if (initiateChartPurpose) {
                    initiateChartPurpose.destroy();
                }

                const totalAll = result.reduce((sum, item) => sum + item.total, 0);

                const labels = result.map(item => item.purpose);
                const values = result.map(item => item.total);
                const percentages = result.map(item =>
                    ((item.total / totalAll) * 100).toFixed(2)
                );

                let backgroundColor = ""

                if (result[0].label == '-') {
                    backgroundColor = "#f2f2f2"
                }else{
                    backgroundColor = arrColorPurpose.slice(0, result.length)
                }


                const chartData = {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: backgroundColor,
                        borderWidth: 1,
                        hoverOffset: 4
                    }]
                };

                const options = {
                    legend: {
                      display: false,
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true, // ⬅️ Ini penting untuk Chart.js v2
                                min: 0,
                                stepSize: 1
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Total'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Purpose'
                            }
                        }]
                    }
                };

                const ctx = document.getElementById(chartCanvasId).getContext("2d");
                initiateChartPurpose = new Chart(ctx, {
                    type: "bar",
                    data: chartData,
                    options: options
                });
            }

            function initGetDataChartDivision(startDate, endDate) {
                $.ajax({
                    url:"{{url('certification_list/getChartExamByDivision')}}",
                    type:"GET",
                    data:{
                        startDate: startDate,
                        endDate: endDate
                    },
                    success:function(response){
                        InitiateChartDivision(arrColorPurpose,response,"barChartExamByDivision")
                    }
                })
            }

            let initiateChartDivision = null;

            function InitiateChartDivision(arrColor, result, chartCanvasId) {
                if (initiateChartDivision) {
                    initiateChartDivision.destroy();
                }

                const totalAll = result.reduce((sum, item) => sum + item.total, 0);

                const labels = result.map(item => item.division);
                const values = result.map(item => item.total);
                const percentages = result.map(item =>
                    ((item.total / totalAll) * 100).toFixed(2)
                );

                let backgroundColor = ""

                if (result[0].label == '-') {
                    backgroundColor = "#f2f2f2"
                }else{
                    backgroundColor = arrColorDivision.slice(0, result.length)
                }


                const chartData = {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: backgroundColor,
                        borderWidth: 1,
                        hoverOffset: 4
                    }]
                };

                const options = {
                    legend: {
                        display: false,
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                min: 0,
                                stepSize: 1
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Total'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Division'
                            }
                        }]
                    }
                };

                const ctx = document.getElementById(chartCanvasId).getContext("2d");
                initiateChartDivision = new Chart(ctx, {
                    type: "bar",
                    data: chartData,
                    options: options
                });
            }

            function initGetDataChartPartner(startDate, endDate) {
                $.ajax({
                    url:"{{url('certification_list/getChartExamByPartner')}}",
                    type:"GET",
                    data:{
                        startDate: startDate,
                        endDate: endDate
                    },
                    success:function(response){
                        InitiateChartPartner(arrColorPartner,response,"pieChartExamByPartner")
                    }
                })
            }

            let initiateChartPartner = null;

            function InitiateChartPartner(arrColor, result, chartCanvasId) {
                if (initiateChartPartner) {
                    initiateChartPartner.destroy();
                }

                const totalAll = result.reduce((sum, item) => sum + item.total, 0);

                const labels = result.map(item => item.partner);
                const values = result.map(item => item.total);
                const percentages = result.map(item =>
                    ((item.total / totalAll) * 100).toFixed(2)
                );

                let backgroundColor = ""

                if (result[0].label == '-') {
                    backgroundColor = "#f2f2f2"
                }else{
                    backgroundColor = arrColorDivision.slice(0, result.length)
                }

                const chartData = {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: backgroundColor,
                        hoverOffset: 4
                    }]
                };

                const options = {
                    plugins: {
                        legend: {
                            position: 'right',
                            display: true,
                            labels: {
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    return data.labels.map((label, i) => {
                                        const value = data.datasets[0].data[i];
                                        const percent = percentages[i];
                                        const color = data.datasets[0].backgroundColor[i];

                                        return {
                                            text: `${label} : ${value} (${percent}%)`,
                                            fillStyle: color,
                                            strokeStyle: color,
                                            lineWidth: 1,
                                            index: i
                                        };
                                    });
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label;
                                    const value = context.raw;
                                    const percent = percentages[context.dataIndex];
                                    return `${label} - ${value} (${percent}%)`;
                                }
                            }
                        }
                    }
                };

                const ctx = document.getElementById(chartCanvasId).getContext("2d");
                initiateChartPartner = new Chart(ctx, {
                    type: "pie",
                    data: chartData,
                    options: options
                });
            }

            function initGetDataChartLevel(startDate, endDate) {
                $.ajax({
                    url:"{{url('certification_list/getChartExamByLevel')}}",
                    type:"GET",
                    data:{
                        startDate: startDate,
                        endDate: endDate
                    },
                    success:function(response){
                        InitiateChartLevel(arrColorStatus,response,"doughnutChartExamByLevel")
                    }
                })
            }

            let initiateLevelChart = null;

            function InitiateChartLevel(arrColor, result, chartCanvasId) {
                if (initiateLevelChart) {
                    initiateLevelChart.destroy();
                }

                const totalAll = result.reduce((sum, item) => sum + item.total, 0);

                const sortedData = [...result].sort((a, b) => b.total - a.total);
                const top10 = sortedData.slice(0, 10);
                const top10Status = top10.map(item => item.level);

                const labels = result.map(item => item.level);
                const values = result.map(item => item.total);
                const percentages = result.map(item =>
                    ((item.total / totalAll) * 100).toFixed(2)
                );

                const backgroundColor = result.map(item => {
                    switch (item.level.toLowerCase()) {
                        case 'expert':
                            return '#1e7e34';
                        case 'profesional':
                            return '#0056b3';
                        case 'associate':
                            return '#b38f00';
                        default:
                            return '#6c757d';
                    }
                });
                const chartData = {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: backgroundColor,
                        hoverOffset: 4
                    }]
                };

                const options = {
                    plugins: {
                        legend: {
                            position: 'right',
                            display: true,
                            labels: {
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    const filtered = data.labels.map((label, i) => {
                                        if (top10Status.includes(label)) {
                                            const value = chart.data.datasets[0].data[i];
                                            const percent = percentages[i];
                                            const color = chart.data.datasets[0].backgroundColor[i];

                                            return {
                                                text: `${label} : ${value} (${percent}%)`,
                                                fillStyle: color,
                                                strokeStyle: color,
                                                lineWidth: 1,
                                                index: i
                                            };
                                        }
                                    }).filter(Boolean);

                                    return filtered;
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label;
                                    const value = context.raw;
                                    const percent = percentages[context.dataIndex];
                                    return `${label} - ${value} (${percent}%)`;
                                }
                            }
                        }
                    }
                };

                const ctx = document.getElementById(chartCanvasId).getContext("2d");
                initiateLevelChart = new Chart(ctx, {
                    type: "doughnut",
                    data: chartData,
                    options: options
                });
            }

            function initCertificationTable() {
                $("#top10ExpiredCertificate").DataTable({
                    "ajax":{
                        "type":"GET",
                        "url":"{{url('/certification_list/getDataTopExpiring')}}",
                    },
                    "columns": [
                        {  "data": null,
                            "width": "5%",
                            "render": function (data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        { "data": "name","width": "25%" },
                        { "data": "exam_name","width": "25%" },
                        { "data": "expired_date","width": "15%" },
                    ],
                });
            }


        })

    </script>

@endsection