@extends('template.main_sneat')
@section('tittle')
PMO
@endsection
@section('pageName')
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
            font-size: 12px;
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

        .text-bg-blue{
            background-color: #0077b5!important;
        }
    </style>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <section class="content">
            <div class="row mb-4">
                <div class="col-md-4">
                  <div class="div-filter-year form-group">
                      <button class="btn btn-sm btn-flat btn-outline-secondary" id="btnThisYear" onclick="clickYear(this.value)"><i class="bx bx-filter"></i> This Year</button>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="div-filter-year form-group">
                      <button class="btn btn-sm btn-flat btn-outline-secondary" id="btnLastYear" onclick="clickYear(this.value)"><i class="bx bx-filter"></i> Last Year</button>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="div-filter-year form-group">
                      <select class="select2 form-control" style="width: 100%!important;" id="selectYear" onchange="clickYear(this.value)"><option></option></select>
                  </div>
                </div>
            </div>

            <div class="row mb-4" id="BoxId">
                <!--card id-->
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">Total Project</h6>
                        </div>
                        <div class="card-body chartBoxTotalProject">
                            <canvas id="totalProjectCanvas" width="400" height="150"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row mb-4">
                <div class="col-md-12 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">Total Nilai Project</h6>
                        </div>
                        <div class="card-body chartBoxTotalNilaiProject">
                            <canvas id="totalNilaiProjectCanvas" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="row mb-4">
                <div class="col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">Health Status</h6>
                        </div>
                        <div class="card-body chartBoxProjectHealth">
                            <canvas id="ProjectHealthCanvas" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">Handover to PMO</h6>
                        </div>
                        <div class="card-body chartBoxHandoverProject">
                        <canvas id="handoverCanvas" width="400" height="200"></canvas>  
                    </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">Project Status</h6>
                        </div>
                        <div class="card-body chartBoxProjectStatus">
                            <canvas id="projectStatusCanvas" width="400" height="200"></canvas>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">Project Phase</h6>
                        </div>
                        <div class="card-body chartBoxProjectPhase">
                        <canvas id="projectPhaseCanvas" width="400" height="200"></canvas>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">Project Type</h6>
                        </div>
                        <div class="card-body chartBoxProjectType">
                            <canvas id="projectTypeCanvas" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">Market Segment</h6>
                        </div>
                        <div class="card-body chartBoxMarketSegment">
                            <canvas id="marketSegmentCanvas" width="400" height="200"></canvas>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">Project Value</h6>
                            
                        </div>
                        <div class="card-body chartBoxProjectvalue">
                            <canvas id="projectValueCanvas" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">Total Nilai Project</h6>
                        </div>
                        <div class="card-body chartBoxTotalNilaiProject">
                            <canvas id="totalNilaiProjectCanvas" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scriptImport')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('script')
    <script type="text/javascript">
        function DashboardCount(year){
            // $("#BoxId").empty()
            var i = 0
            var append = ""
            var colors = []

            $.ajax({
                type:"GET",
                url:"{{url('/PMO/getCountDashboard')}}",
                data:{
                    year:year
                },
                beforeSend:function(){
                    $('.layout-container').block({
                      message: '<div class=""spinner-border text-white"" role=""status""></div>',
                      timeout: 1000,
                      css: {
                        backgroundColor: 'transparent',
                        border: '0'
                      },
                      overlayCSS: {
                        opacity: 0.5
                      }
                    });
                },
                success:function(result){
                    var ArrColors = [{
                        name: 'Initiating',style: 'color:white', color: 'text-bg-primary', icon: 'time',status:"NA",index: 0,value: result.countInitiating
                        },
                        {
                            name: 'Planning',style: 'color:white', color: 'text-bg-info', icon: 'task',status:"OG",index: 1,value: result.countPlanning
                        },
                        {
                            name: 'Executing',style: 'color:white', color: 'text-bg-danger', icon: 'calendar-x',status:"DO",index: 2,value: result.countExecuting
                        },
                        {
                            name: 'Closing',style: 'color:white', color: 'text-bg-blue', icon: 'calendar-check',status:"ALL",index: 3,value: result.countClosing
                        },
                        {
                            name: 'Done',style: 'color:white', color: 'text-bg-success', icon: 'list-check',status:"DO",index: 2,value: result.countDone
                        },
                        {
                            name: 'Ongoing',style: 'color:white', color: 'text-bg-warning', icon: 'list-ul',status:"ALL",index: 3,value: result.countOnGoing
                        },
                    ]

                    colors.push(ArrColors)
                    append = append + '<div class="col-lg-12 col-xs-12">'
                        append = append + '<div class="card mb-6">'
                            append = append + '<div class="card-widget-separator-wrapper">'
                              append = append + '<div class="card-body card-widget-separator">'
                                append = append + '<div class="row gy-4 gy-sm-1">'
                                    $.each(colors[0], function(key, value){
                                        //     append = append + '<div class="small-card '+ value.color +'">'
                                        //     append = append + '    <div class="inner">'
                                        //     append = append + '        <h6 class="counter" data-value="'+ key +'">'+ value.value +'</h6>'
                                        //     append = append + '        <p>'+ value.name +'</p>'
                                        //     append = append + '    </div>'
                                        //     append = append + '    <div class="icon">'
                                        //     append = append + '        <i class="'+ value.icon +'" style="'+ value.style +';opacity:0.4"></i>'
                                        //     append = append + '    </div>'
                                        //     append = append + '</div>'
                                        append = append + '<div class="col-sm-6 col-lg-2">'
                                            append = append + '<div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">'
                                              append = append + '<div>'
                                                append = append + '<p class="mb-1">'+ value.name +'</p>'
                                                append = append + '<h6 class="mb-1 counter" data-value="'+ key +'">'+ value.value +'</h6>'
                                              append = append + '</div>'
                                              append = append + '<span class="avatar me-sm-6">'
                                                append = append + '<span class="avatar-initial rounded w-px-44 h-px-44 '+ value.color +'">'
                                                  append = append + '<i class="icon-base bx bx-'+ value.icon +' icon-lg text-white"></i>'
                                                append = append + '</span>'
                                              append = append + '</span>'
                                            append = append + '</div>'
                                            append = append + '<hr class="d-none d-sm-block d-lg-none me-6">'
                                        append = append + '</div>'
                                    })
                                    append = append + '</div>'
                                  append = append + '</div>'
                                append = append + '</div>'
                            append = append + '</div>'
                        append = append + '</div>'

                      // $("#BoxId").append(append)

                    if ($("#BoxId").children().length == 0) {
                        $("#BoxId").append(append)
                    }else{
                        $.each(colors[0], function(key, value){
                            $(".counter[data-value='"+ key +"']").text(value.value)
                        })
                    }

                    $('.counter').each(function () {
                      var size = $(this).text().split(".")[1] ? $(this).text().split(".")[1].length : 0;
                      $(this).prop('Counter', 0).animate({
                        Counter: $(this).text()
                      }, {
                        duration: 1000,
                        step: function (func) {
                           $(this).text(parseFloat(func).toFixed(size));
                        }
                      });
                    });

                    var counterValue = $(".counter").text().split(".")[1] ? $(this).text().split(".")[1].length : 0;
                    var targetValue = $(".counter").text().split(".")[1] ? $(this).text().split(".")[1].length : 0; // Change this to your desired final value
                    var animationDuration = 2000; // Animation duration in milliseconds
                    var intervalDuration = 20; // Interval duration for smooth animation

                    var interval = setInterval(function() {
                        counterValue += Math.ceil(targetValue / (animationDuration / intervalDuration));
                        if (counterValue >= targetValue) {
                            counterValue = targetValue;
                            clearInterval(interval);
                        }
                        $(".counter").text(counterValue);
                    }, intervalDuration);

                    
                }
            })
        }

        // var ctxTotalProjectCanvas = document.getElementById("totalProjectCanvas");
        // var ctxHealthStatusCanvas = document.getElementById("healthStatusCanvas");
        // var ctxHandoverCanvas = document.getElementById("handoverCanvas");
        // var ctxProjectStatusCanvas = document.getElementById("projectStatusCanvas");
        // var ctxProjectPhaseCanvas = document.getElementById("projectPhaseCanvas");
        // var ctxProjectValueCanvas = document.getElementById("projectValueCanvas");
        // var ctxTotalNilaiProjectCanvas = document.getElementById("totalNilaiProjectCanvas");

        let initiateMyChartIdCanvasDouble = ''
        function createDataDouble(label,datas,datasWIP,backgroundColor,borderColor,className,idCanvas){
            const data = {
            labels: label,
            datasets: [{
                label: 'Done',
                data: datas,
                backgroundColor: [
                    '#5eb565',
                    '#5eb565',
                    '#5eb565',
                    '#5eb565',
                    '#5eb565',
                    '#5eb565',
                    '#5eb565',
                    '#5eb565',
                    '#5eb565'
                ],
                borderColor: [
                    '#404540',
                    '#404540',
                    '#404540',
                    '#404540',
                    '#404540',
                    '#404540',
                    '#404540',
                    '#404540',
                    '#404540'                                                  
                ],
                borderWidth: 1,
                minBarLength: 2,
                barThickness: 30,
                },
                {
                    label: 'WIP',
                    data: datasWIP,
                    backgroundColor: [
                        '#3629a6',
                        '#3629a6',                                                
                        '#3629a6',
                        '#3629a6',
                        '#3629a6',
                        '#3629a6',
                        '#3629a6',
                        '#3629a6',
                        '#3629a6'                        
                    ],
                    borderColor: [
                        '#404540',
                        '#404540',                                                      
                        '#404540',
                        '#404540',
                        '#404540',
                        '#404540',
                        '#404540',
                        '#404540',
                        '#404540' 
                    ],
                    borderWidth: 1,
                    minBarLength: 2,
                    barThickness: 30,
                }],
            };

            const config = {
                type:'bar',
                data:data,
                options: {
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true

                        }
                    }
                }
            }

            if (initiateMyChartIdCanvasDouble) {
              initiateMyChartIdCanvasDouble.destroy()
            }

            var ctx_idCanvas = document.getElementById(idCanvas);
            var myChartidCanvas = new Chart(ctx_idCanvas, config);

            const chartBox = document.querySelector('.'+className);

            let tableDiv = '', table = ''

            if (tableDiv == '' ) {
                if ($(".tableDiv").length == 0) {
                    tableDiv = document.createElement('DIV');
                    tableDiv.setAttribute('class','tableDiv');
                }
            }
            
            if (table == '') {
                table = document.createElement('TABLE')
            }

            // const tableDiv = document.createElement('DIV');
            // tableDiv.setAttribute('class','tableDiv');
            
            // const table = document.createElement('TABLE');
            table.classList.add('chartjsTotalProject-table');

            const thead = table.createTHead();
            thead.classList.add('chartjsTotalProject-thead');

            thead.insertRow(0);

            for(let i = 0;i < data.labels.length;i++){
                thead.rows[0].insertCell(i).innerText = data.labels[i];
            }
            thead.rows[0].insertCell(0).innerText = 'Label'

            const tbody = table.createTBody();
            tbody.classList.add('chartjsTotalProject-tbody')

            data.datasets.map((dataset,index) => {

                let value = index + 1;
                let color = ''
                tbody.insertRow(index);
                for (let i = 0; i < data.datasets[0].data.length; i++) {
                    tbody.rows[index].insertCell(i).innerText = dataset.data[i]   
                }

                if (dataset.label == 'WIP') {
                    color = "<div style='background-color:#3629a6;width:15px;height:15px;display:inline;float:left'></div>&nbsp"
                }else{
                    color = "<div style='background-color:#5eb565;width:15px;height:15px;display:inline;float:left'></div>&nbsp"
                }

                tbody.rows[index].insertCell(0).innerHTML = color + '<span style="display:inline">'+ dataset.label +'</span>'
            })
            // chartBox.appendChild(tableDiv);
            // tableDiv.appendChild(table);

            if ($(".tableDiv").length == 0) {
                chartBox.appendChild(tableDiv);
                tableDiv.appendChild(table);
                tableDiv.style.paddingTop = "20px"
            }else{
                $(".tableDiv").empty()
                $(".tableDiv").append(table)
            }

            return initiateMyChartIdCanvasDouble = myChartidCanvas
        }

        let initiateMyChartProjectType = '',
        initiateMyChartSegmentMarket = '' ,
        initiateMyChartProjectValue = '',
        initiateMyChartTotalNilaiProject = '', 
        initiateMyChartProjectPhase = '', 
        initiateMyChartProjectStatus = '', 
        initiateMyChartProjectHealth = '', 
        initiateMyChartHandoverProject = ''

        function createDataSingle(label,datas,backgroundColors,borderColors,labelData,className,idCanvas){
            var formatter = new Intl.NumberFormat(['ban', 'id']);

            var dataSingle_className = {
                labels: label,
                datasets: [{
                    label: labelData,
                    data: datas,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 1,
                    minBarLength: 2,
                    barThickness: 30,
                }],
            };

            const config = {
              type: 'bar',
              data: dataSingle_className,
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              },
            };

            var ctx_idCanvas = document.getElementById(idCanvas);

            if (idCanvas == 'projectTypeCanvas') {
                resetCanvas(initiateMyChartProjectType)
                var myChartidCanvasidCanvas = new Chart(ctx_idCanvas, config);

            }else if (idCanvas == 'marketSegmentCanvas') {
                resetCanvas(initiateMyChartSegmentMarket)
                var myChartidCanvasidCanvas = new Chart(ctx_idCanvas, config);

            }else if (idCanvas == 'projectStatusCanvas') {
                resetCanvas(initiateMyChartProjectStatus)
                var myChartidCanvasidCanvas = new Chart(ctx_idCanvas, config);

            }else if (idCanvas == 'projectPhaseCanvas') {
                resetCanvas(initiateMyChartProjectPhase)
                var myChartidCanvasidCanvas = new Chart(ctx_idCanvas, config);

            }else if (idCanvas == 'projectValueCanvas') {
                resetCanvas(initiateMyChartProjectValue)
                var myChartidCanvasidCanvas = new Chart(ctx_idCanvas, config);

            }else if (idCanvas == 'totalNilaiProjectCanvas') {
                resetCanvas(initiateMyChartTotalNilaiProject)
                var myChartidCanvasidCanvas = new Chart(ctx_idCanvas, config);

            }else if (idCanvas == 'ProjectHealthCanvas') {
                resetCanvas(initiateMyChartProjectHealth)
                var myChartidCanvasidCanvas = new Chart(ctx_idCanvas, config);

            }else if (idCanvas == 'handoverCanvas') {
                resetCanvas(initiateMyChartHandoverProject)
                var myChartidCanvasidCanvas = new Chart(ctx_idCanvas, config);

            } 

            const chartBox = document.querySelector('.'+className);

            const tableDiv = document.createElement('DIV');
            tableDiv.setAttribute('class','table-responsive');
            $(tableDiv).addClass(className)
            
            const table = document.createElement('TABLE');

            table.setAttribute('class','table')
            table.classList.add('chartjs-table');

            const thead = table.createTHead();
            thead.classList.add('chartjs-thead');

            thead.insertRow(0);

            for(let i = 0;i < dataSingle_className.labels.length;i++){
                thead.rows[0].insertCell(i).innerText = dataSingle_className.labels[i];
            }
            thead.rows[0].insertCell(0).innerText = 'Label'

            const tbody = table.createTBody();
            tbody.classList.add('chartjs-tbody')

            dataSingle_className.datasets.map((dataset,index) => {

                let value = index + 1;
                let color = ''
                tbody.insertRow(index);

                if (className == "chartBoxTotalNilaiProject") {
                    for (let i = 0; i < dataSingle_className.datasets[0].data.length; i++) {
                        tbody.rows[index].insertCell(i).innerText = formatter.format(dataset.data[i])   
                    }
                }else{
                    for (let i = 0; i < dataSingle_className.datasets[0].data.length; i++) {
                        tbody.rows[index].insertCell(i).innerText = dataset.data[i]   
                    }
                }

                color = "<div style='background-color:#3629a6;width:15px;height:15px;display:inline;float:left'></div>&nbsp"

                tbody.rows[index].insertCell(0).innerHTML = color + '<span style="display:inline">'+ dataset.label +'</span>'
            })

            if ($(".table-responsive."+className).length == 0) {
                // $("."+className).find("canvas").after(tableDiv)
                chartBox.appendChild(tableDiv);
                tableDiv.appendChild(table);
                tableDiv.style.paddingTop = "20px"
            }else{
                $(".table-responsive."+className).remove()
                $(".table-responsive."+className).empty()
                $(".table-responsive."+className).append(table)
                // $("."+className).find("canvas").after(tableDiv)

                chartBox.appendChild(tableDiv);
                tableDiv.appendChild(table);
            }   

            if (idCanvas == 'projectTypeCanvas') {                
                return initiateMyChartProjectType = myChartidCanvasidCanvas
            }else if (idCanvas == 'marketSegmentCanvas') {                
                return initiateMyChartSegmentMarket = myChartidCanvasidCanvas
            }else if (idCanvas == 'projectStatusCanvas') {                
                return initiateMyChartProjectStatus = myChartidCanvasidCanvas
            }else if (idCanvas == 'projectPhaseCanvas') {                
                return initiateMyChartProjectPhase = myChartidCanvasidCanvas
            }else if (idCanvas == 'projectValueCanvas') {                
                return initiateMyChartProjectValue = myChartidCanvasidCanvas
            }else if (idCanvas == 'totalNilaiProjectCanvas') {                
                return initiateMyChartTotalNilaiProject = myChartidCanvasidCanvas
            }else if (idCanvas == 'ProjectHealthCanvas') {                
                return initiateMyChartProjectHealth = myChartidCanvasidCanvas
            }else if (idCanvas == 'handoverCanvas') {                
                return initiateMyChartHandoverProject = myChartidCanvasidCanvas
            } 
        }

        function resetCanvas(chart) {
            // Destroy canvas
            if (chart) {
                chart.destroy();
            }  
        }

        // function createTableTotalProject(){
        //     const chartBox = document.querySelector('.chartBoxTotalProject');
        //     const tableDiv = document.createElement('DIV');
        //     tableDiv.setAttribute('class','tableDiv');
            
        //     const table = document.createElement('TABLE');
        //     table.classList.add('chartjsTotalProject-table');

        //     const thead = table.createTHead();
        //     thead.classList.add('chartjsTotalProject-thead');

        //     thead.insertRow(0);

        //     for(let i = 0;i < data.labels.length;i++){
        //         thead.rows[0].insertCell(i).innerText = data.labels[i];
        //     }
        //     thead.rows[0].insertCell(0).innerText = 'Label'

        //     const tbody = table.createTBody();
        //     tbody.classList.add('chartjsTotalProject-tbody')

        //     data.datasets.map((dataset,index) => {

        //         let value = index + 1;
        //         let color = ''
        //         tbody.insertRow(index);
        //         for (let i = 0; i < data.datasets[0].data.length; i++) {
        //             tbody.rows[index].insertCell(i).innerText = dataset.data[i]   
        //         }

        //         if (dataset.label == 'WIP') {
        //             color = "<div style='background-color:#3629a6;width:15px;height:15px;display:inline;float:left'></div>&nbsp"
        //         }else{
        //             color = "<div style='background-color:#5eb565;width:15px;height:15px;display:inline;float:left'></div>&nbsp"
        //         }

        //         tbody.rows[index].insertCell(0).innerHTML = color + '<span style="display:inline">'+ dataset.label +'</span>'
        //     })
        //     chartBox.appendChild(tableDiv);
        //     tableDiv.appendChild(table);
        // }

        function createTableProjectType(year){
            $.ajax({
                type:"GET",
                url:"{{url('/PMO/getTotalProjectType')}}",
                data:{
                    year:year
                },
                beforeSend:function(){
                    $('.layout-container').block({
                      message: '<div class=""spinner-border text-white"" role=""status""></div>',
                      timeout: 1000,
                      css: {
                        backgroundColor: 'transparent',
                        border: '0'
                      },
                      overlayCSS: {
                        opacity: 0.5
                      }
                    });
                },
                success:function(result){
                    let label = []
                    let datas = []
                    let backgroundColor = []
                    let borderColor = []

                    result.data.map(x => label.push(x.project_type))
                    result.data.map(x => datas.push(x.count))
                    result.data.map(x => backgroundColor.push("#3629a6"))
                    result.data.map(x => borderColor.push("#404540"))

                    createDataSingle(label,datas,backgroundColor,borderColor,labelData="Qty",className="chartBoxProjectType",idCanvas="projectTypeCanvas")
                }
            })
        }

        function createTableMarketSegment(year){
            $.ajax({
                type:"GET",
                url:"{{url('/PMO/getMarketSegment')}}",
                data:{
                    year:year
                },
                beforeSend:function(){
                    $('.layout-container').block({
                      message: '<div class=""spinner-border text-white"" role=""status""></div>',
                      timeout: 1000,
                      css: {
                        backgroundColor: 'transparent',
                        border: '0'
                      },
                      overlayCSS: {
                        opacity: 0.5
                      }
                    });
                },
                success:function(result){
                    let label = []
                    let datas = []
                    let backgroundColor = []
                    let borderColor = []

                    result.data.map(x => label.push(x.market_segment))
                    result.data.map(x => datas.push(x.count))
                    result.data.map(x => backgroundColor.push("#3629a6"))
                    result.data.map(x => borderColor.push("#404540"))

                    createDataSingle(label,datas,backgroundColor,borderColor,labelData="Qty",className="chartBoxMarketSegment",idCanvas="marketSegmentCanvas")
                }
            })
        }

        function createTableTotalNilaiProject(year){
            $.ajax({
                type:"GET",
                url:"{{url('/PMO/getNominalByPeople')}}",
                data:{
                    year:year
                },
                beforeSend:function(){
                    $('.layout-container').block({
                      message: '<div class=""spinner-border text-white"" role=""status""></div>',
                      timeout: 1000,
                      css: {
                        backgroundColor: 'transparent',
                        border: '0'
                      },
                      overlayCSS: {
                        opacity: 0.5
                      }
                    });
                },
                success:function(result){
                    let label = []
                    let datas = []
                    let backgroundColor = []
                    let borderColor = []

                    result.data.map(x => label.push(x.name))
                    result.data.map(x => datas.push(x.amount))
                    result.data.map(x => backgroundColor.push("#3629a6"))
                    result.data.map(x => borderColor.push("#404540"))

                    createDataSingle(label,datas,backgroundColor,borderColor,labelData="Total Nilai Project",className="chartBoxTotalNilaiProject",idCanvas="totalNilaiProjectCanvas")
                }
            })
        }

        function createTableProjectPhase(year){
            $.ajax({
                type:"GET",
                url:"{{url('/PMO/getProjectPhase')}}",
                data:{
                    year:year
                },
                beforeSend:function(){
                    $('.layout-container').block({
                      message: '<div class=""spinner-border text-white"" role=""status""></div>',
                      timeout: 1000,
                      css: {
                        backgroundColor: 'transparent',
                        border: '0'
                      },
                      overlayCSS: {
                        opacity: 0.5
                      }
                    });
                },
                success:function(result){
                    let label = []
                    let datas = []
                    let backgroundColor = []
                    let borderColor = []

                    result.data.map(x => label.push(x.label))
                    result.data.map(x => datas.push(x.count))
                    result.data.map(x => backgroundColor.push("#3629a6"))
                    result.data.map(x => borderColor.push("#404540"))

                    createDataSingle(label,datas,backgroundColor,borderColor,labelData="Qty",className="chartBoxProjectPhase",idCanvas="projectPhaseCanvas")
                }
            })
        }

        function createTableProjectStatus(year){
            $.ajax({
                type:"GET",
                url:"{{url('/PMO/getProjectStatus')}}",
                data:{
                    year:year
                },
                beforeSend:function(){
                    $('.layout-container').block({
                      message: '<div class=""spinner-border text-white"" role=""status""></div>',
                      timeout: 1000,
                      css: {
                        backgroundColor: 'transparent',
                        border: '0'
                      },
                      overlayCSS: {
                        opacity: 0.5
                      }
                    });
                },
                success:function(result){
                    let label = []
                    let datas = []
                    let backgroundColor = []
                    let borderColor = []

                    result.data.map(x => label.push(x.label))
                    result.data.map(x => datas.push(x.count))
                    result.data.map(x => backgroundColor.push("#3629a6"))
                    result.data.map(x => borderColor.push("#404540"))

                    createDataSingle(label,datas,backgroundColor,borderColor,labelData="Qty",className="chartBoxProjectStatus",idCanvas="projectStatusCanvas")
                }
            })
        }

        function createTableProjectValue(year){
            $.ajax({
                type:"GET",
                url:"{{url('/PMO/getProjectValue')}}",
                data:{
                    year:year
                },
                beforeSend:function(){
                    $('.layout-container').block({
                      message: '<div class=""spinner-border text-white"" role=""status""></div>',
                      timeout: 1000,
                      css: {
                        backgroundColor: 'transparent',
                        border: '0'
                      },
                      overlayCSS: {
                        opacity: 0.5
                      }
                    });
                },
                success:function(result){
                    let label = []
                    let datas = []
                    let backgroundColor = []
                    let borderColor = []

                    result.data.map(x => label.push(x.label))
                    result.data.map(x => datas.push(x.count))
                    result.data.map(x => backgroundColor.push("#3629a6"))
                    result.data.map(x => borderColor.push("#404540"))

                    createDataSingle(label,datas,backgroundColor,borderColor,labelData="Qty",className="chartBoxProjectvalue",idCanvas="projectValueCanvas")
                }
            })
        }

        function createTableTotalProject(year){
            $.ajax({
                type:"GET",
                url:"{{url('/PMO/getTotalProject')}}",
                data:{
                    year:year
                },
                beforeSend:function(){
                    $('.layout-container').block({
                      message: '<div class=""spinner-border text-white"" role=""status""></div>',
                      timeout: 1000,
                      css: {
                        backgroundColor: 'transparent',
                        border: '0'
                      },
                      overlayCSS: {
                        opacity: 0.5
                      }
                    });
                },
                success:function(result){
                    let label = []
                    let datasDone = []
                    let datasWIP = []
                    let backgroundColor = []
                    let borderColor = []

                    result.map(x => label.push(x.name))
                    result.map(x => datasDone.push(x.finished))
                    result.map(x => datasWIP.push(x.on_going))                    
                    result.map(x => backgroundColor.push("#3629a6"))
                    result.map(x => borderColor.push("#404540"))

                    createDataDouble(label,datasDone,datasWIP,backgroundColor,borderColor,className="chartBoxTotalProject",idCanvas="totalProjectCanvas")
                }
            })
        }

        function createTableProjectHealth(year){
            $.ajax({
                type:"GET",
                url:"{{url('/PMO/getProjectHealth')}}",
                data:{
                    year:year
                },
                beforeSend:function(){
                    $('.layout-container').block({
                      message: '<div class=""spinner-border text-white"" role=""status""></div>',
                      timeout: 1000,
                      css: {
                        backgroundColor: 'transparent',
                        border: '0'
                      },
                      overlayCSS: {
                        opacity: 0.5
                      }
                    });
                },
                success:function(result){
                    let label = []
                    let datas = []
                    let backgroundColor = []
                    let borderColor = []

                    result.data.map(x => label.push(x.label))
                    result.data.map(x => datas.push(x.count))
                    result.data.map(x => backgroundColor.push("#3629a6"))
                    result.data.map(x => borderColor.push("#404540"))

                    createDataSingle(label,datas,backgroundColor,borderColor,labelData="Qty",className="chartBoxProjectHealth",idCanvas="ProjectHealthCanvas")
                }
            })
        }

        function createTableHandoverProject(year){
            $.ajax({
                type:"GET",
                url:"{{url('/PMO/getHandoverProject')}}",
                data:{
                    year:year
                },
                beforeSend:function(){
                    $('.layout-container').block({
                      message: '<div class=""spinner-border text-white"" role=""status""></div>',
                      timeout: 1000,
                      css: {
                        backgroundColor: 'transparent',
                        border: '0'
                      },
                      overlayCSS: {
                        opacity: 0.5
                      }
                    });
                },
                success:function(result){
                    let label = []
                    let datas = []
                    let backgroundColor = []
                    let borderColor = []

                    result.data.map(x => label.push(x.label))
                    result.data.map(x => datas.push(x.count))
                    result.data.map(x => backgroundColor.push("#3629a6"))
                    result.data.map(x => borderColor.push("#404540"))

                    createDataSingle(label,datas,backgroundColor,borderColor,labelData="Qty",className="chartBoxHandoverProject",idCanvas="handoverCanvas")
                }
            })
        }

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
                beforeSend:function(){
                    $('.layout-container').block({
                      message: '<div class=""spinner-border text-white"" role=""status""></div>',
                      timeout: 1000,
                      css: {
                        backgroundColor: 'transparent',
                        border: '0'
                      },
                      overlayCSS: {
                        opacity: 0.5
                      }
                    });
                },
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
                DashboardCount(year)
                createTableProjectType(year)
                createTableMarketSegment(year)
                createTableProjectValue(year)
                createTableTotalNilaiProject(year)
                createTableProjectPhase(year)
                createTableProjectStatus(year)
                createTableProjectHealth(year)
                createTableTotalProject(year)
                createTableHandoverProject(year)

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
            }
        }
    </script>
@endsection