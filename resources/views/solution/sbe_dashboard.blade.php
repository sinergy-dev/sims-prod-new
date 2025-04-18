@extends('template.main_sneat')
@section('tittle')
SBE Dashboard
@endsection
@section('pageName')
Sbe Dashboard
@endsection
@section('head_css')
	<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css"> -->
    <!-- DataTables -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.css"> -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <style>
    	.input-group .select2-container {
            flex: 1; /* Allow Select2 to expand inside input-group */
            width: auto !important; 
        }

        .input-group .select2-container--default .select2-selection--single {
		    border-top-left-radius: 0px !important;
		    border-bottom-left-radius: 0px !important;
		}

        .input-group-text {
            white-space: nowrap; /* Prevents label from breaking */
        }
    </style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <section class="content">
    	<div class="row" style="margin-bottom:20px">
    		<div class="col-md-8">
				<span style="margin-top: 5px;float: right;">
    				<b>Filter Year</b>
    			</span>
			</div>
			<div class="col-md-4">
				<div class="input-group">
					<label class="input-group-text" for="inputGroupSelect01"><i class="icon-base bx bx-calendar"></i></label>
					<select id="filterYear" name="filterYear" class="form-control select2">
					    <option value="">Select a Year</option>
					    @foreach($year as $item)
					        <option value="{{ $item->year }}">
					            {{ $item->year }}
					        </option>
					    @endforeach
					</select> 
    			</div>
			</div>
    	</div>

    	<div class="row mt-4">
    		<div class="col-md-4">
	    		<div class="card">
	    			<div class="card-header">
	    				<h6 class="card-title">Total SBE by Status</h6>
	    			</div>
	    			<div class="card-body">
                        <div id="totalSbeByStatus" width="100%" height="100%"></div>
                        <!-- <canvas id="totalSbeByStatus" width="100%" height="100%"></canvas> -->
	    			</div>
	    		</div>
	    	</div>	
	    	<div class="col-md-4">
	    		<div class="card">
	    			<div class="card-header">
	    				<h6 class="card-title">Total Nominal SBE by Status</h6>
	    			</div>
	    			<div class="card-body">
                        <div id="sumSbeByStatus" width="100%" height="100%"></div>
                        <!-- <canvas id="sumSbeByStatus" width="100%" height="100%"></canvas> -->
	    			</div>
	    		</div>
	    	</div>	
	    	<div class="col-md-4">
	    		<div class="card">
	    			<div class="card-header">
	    				<h6 class="card-title">Total SBE by Type Project</h6>
	    			</div>
	    			<div class="card-body">
                        <div id="totalSbeByType" width="100%" height="100%"></div>
                        <!-- <canvas id="totalSbeByType" width="100%" height="100%"></canvas> -->
	    			</div>
	    		</div>
	    	</div>	
    	</div>

    	<div class="row mt-4">
    		<div class="col-md-6">
	    		<div class="card">
	    			<div class="card-header">
	    				<h6 class="card-title">TOP 5 SBE Project Supply Only</h6>
	    			</div>
	    			<div class="card-body" style="min-height:375px">
	    				<table id="tb_project_supply_only" class="table" width="100%">
	    					
	    				</table>
	    			</div>
	    		</div>
	    	</div>	
    		
	    	<div class="col-md-6">
	    		<div class="card">
	    			<div class="card-header">
	    				<h6 class="card-title">TOP 5 SBE Project Implementation</h6>
	    			</div>
	    			<div class="card-body" style="min-height:375px">
	    				<table id="tb_project_implementation" class="table" width="100%">
	    					
	    				</table>
	    			</div>
	    		</div>
	    	</div>	
    	</div>

    	<div class="row mt-4">
    		<div class="col-md-6">
	    		<div class="card">
	    			<div class="card-header">
	    				<h6 class="card-title">TOP 5 SBE Project Maintenance <i class="fa fa-"></i></h6>
	    			</div>
	    			<div class="card-body" style="min-height:375px">
	    				<table id="tb_project_maintenance" class="table" width="100%">
	    					
	    				</table>
	    			</div>
	    		</div>
	    	</div>	
    		<div class="col-md-6">
	    		<div class="card">
	    			<div class="card-header">
	    				<h6 class="card-title">TOP 5 SBE Project Implementation + Maintenance</h6>
	    			</div>
	    			<div class="card-body" style="min-height:375px">
	    				<table id="tb_project_implementation_maintenance" class="table" width="100%">
	    					
	    				</table>
	    			</div>
	    		</div>
	    	</div>	
	    	
    	</div>
    </section>
</div>
@endsection
@section('scriptImport')
	<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
	<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
	<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
	<script src="{{asset('assets/js/extended-ui-blockui.js')}}" type="text/javascript"></script>
@endsection
@section('script')
	<script type="text/javascript">
		var formatter = new Intl.NumberFormat(['ban', 'id']);
		var currentYear = new Date().getFullYear();
    	let initChartTotalSbeByStatus = null, initChartSumSbeByStatus = null, initChartTotalSbeByType = null

		initDashboard(currentYear)

		$("#filterYear").select2().val(currentYear).trigger('change')
		$("#filterYear").on('change', function() {
			initDashboard(this.value)
		})

		function initDashboard(year) {
			$.ajax({
			"type":"GET",
			"url":"{{url('/sbe/getDataChartSbe')}}",
			"data":{
				year:year
			},
			beforeSend:function(){
				$('.layout-container').block({
			      message: '<div class="spinner-border text-white" role="status"></div>',
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
			success:function (result) {
				$("#tb_project_supply_only").empty("")
				//supply only
				appendSupplyOnly = ''
				appendSupplyOnly = appendSupplyOnly + '<thead>'
					appendSupplyOnly = appendSupplyOnly + '<tr>'
						appendSupplyOnly = appendSupplyOnly + '<th>No</th>'
						appendSupplyOnly = appendSupplyOnly + '<th>Created By</th>'
						appendSupplyOnly = appendSupplyOnly + '<th>Project Name</th>'
						appendSupplyOnly = appendSupplyOnly + '<th>Nominal</th>'
					appendSupplyOnly = appendSupplyOnly + '<tr>'
				appendSupplyOnly = appendSupplyOnly + '<tbody>'
					if (result.top5SbeByStatus.length == 0) {
						appendSupplyOnly = appendSupplyOnly + '<tr>'
							appendSupplyOnly = appendSupplyOnly + '<td colspan="4">'
								appendSupplyOnly = appendSupplyOnly + '<span style="display:flex;justify-content:center;vertical-align:center">'
									appendSupplyOnly = appendSupplyOnly + 'No Data..'
								appendSupplyOnly = appendSupplyOnly + '</span>'
							appendSupplyOnly = appendSupplyOnly + '<td>'
						appendSupplyOnly = appendSupplyOnly + '</tr>'
					}else{
						$.each(result.top5SbeByStatus,function(key,value){
							if (value.project_type == 'Supply Only') {
								if (value.top_nominals.length == 0) {
									appendSupplyOnly = appendSupplyOnly + '<tr>'
										appendSupplyOnly = appendSupplyOnly + '<td colspan="4">'
											appendSupplyOnly = appendSupplyOnly + '<span style="display:flex;justify-content:center;vertical-align:center">'
												appendSupplyOnly = appendSupplyOnly + 'No Data..'
											appendSupplyOnly = appendSupplyOnly + '</span>'
										appendSupplyOnly = appendSupplyOnly + '<td>'
									appendSupplyOnly = appendSupplyOnly + '</tr>'
								}else{
									$.each(value.top_nominals,function(key,values){
										appendSupplyOnly = appendSupplyOnly + '<tr>'
											appendSupplyOnly = appendSupplyOnly + '<td>'+ ++key  +'</td>'
											appendSupplyOnly = appendSupplyOnly + '<td>'+ values.name +'</td>'
											appendSupplyOnly = appendSupplyOnly + '<td style="text-align:justify">'+ values.opp_name +'</td>'
											appendSupplyOnly = appendSupplyOnly + '<td>'+ formatter.format(values.nominal) +'</td>'
										appendSupplyOnly = appendSupplyOnly + '</tr>'
									})
								}
							}
						})
					}
				appendSupplyOnly = appendSupplyOnly + '</tbody>'

				$("#tb_project_supply_only").append(appendSupplyOnly)

				$("#tb_project_implementation").empty("")
				//implementation
				appendImplementation = ''
				appendImplementation = appendImplementation + '<thead>'
					appendImplementation = appendImplementation + '<tr>'
						appendImplementation = appendImplementation + '<th>No</th>'
						appendImplementation = appendImplementation + '<th>Created By</th>'
						appendImplementation = appendImplementation + '<th>Project Name</th>'
						appendImplementation = appendImplementation + '<th>Nominal</th>'
					appendImplementation = appendImplementation + '<tr>'
				appendImplementation = appendImplementation + '</thead>'
				appendImplementation = appendImplementation + '<tbody>'
					if (result.top5SbeByStatus.length == 0) {
						appendImplementation = appendImplementation + '<tr>'
							appendImplementation = appendImplementation + '<td colspan="4">'
								appendImplementation = appendImplementation + '<span style="display:flex;justify-content:center;vertical-align:center">'
									appendImplementation = appendImplementation + 'No Data..'
								appendImplementation = appendImplementation + '</span>'
							appendImplementation = appendImplementation + '<td>'
						appendImplementation = appendImplementation + '</tr>'
					}else{
						$.each(result.top5SbeByStatus,function(key,value){
							if (value.project_type == 'Implementation') {
								if (value.top_nominals.length == 0) {
									appendImplementation = appendImplementation + '<tr>'
										appendImplementation = appendImplementation + '<td colspan="4">'
											appendImplementation = appendImplementation + '<span style="display:flex;justify-content:center;vertical-align:center">'
												appendImplementation = appendImplementation + 'No Data..'
											appendImplementation = appendImplementation + '</span>'
										appendImplementation = appendImplementation + '<td>'
									appendImplementation = appendImplementation + '</tr>'
								}else{
									$.each(value.top_nominals,function(key,values){
										appendImplementation = appendImplementation + '<tr>'
											appendImplementation = appendImplementation + '<td>'+ ++key  +'</td>'
											appendImplementation = appendImplementation + '<td>'+ values.name +'</td>'
											appendImplementation = appendImplementation + '<td style="text-align:justify">'+ values.opp_name +'</td>'
											appendImplementation = appendImplementation + '<td>'+ formatter.format(values.nominal) +'</td>'
										appendImplementation = appendImplementation + '</tr>'
									})
								}
							}
						})
					}
				appendImplementation = appendImplementation + '</tbody>'

				$("#tb_project_implementation").append(appendImplementation)

				$("#tb_project_maintenance").empty('')
				appendMaintenance = ''

				appendMaintenance = appendMaintenance + '<thead>'
					appendMaintenance = appendMaintenance + '<tr>'
						appendMaintenance = appendMaintenance + '<th>No</th>'
						appendMaintenance = appendMaintenance + '<th>Created By</th>'
						appendMaintenance = appendMaintenance + '<th>Project Name</th>'
						appendMaintenance = appendMaintenance + '<th>Nominal</th>'
					appendMaintenance = appendMaintenance + '<tr>'
				appendMaintenance = appendMaintenance + '</thead>'
				appendMaintenance = appendMaintenance + '<tbody>'
					if (result.top5SbeByStatus.length == 0) {
						appendMaintenance = appendMaintenance + '<tr>'
							appendMaintenance = appendMaintenance + '<td colspan="4">'
								appendMaintenance = appendMaintenance + '<span style="display:flex;justify-content:center;vertical-align:center">'
									appendMaintenance = appendMaintenance + 'No Data..'
								appendMaintenance = appendMaintenance + '</span>'
							appendMaintenance = appendMaintenance + '<td>'
						appendMaintenance = appendMaintenance + '</tr>'
					}else{
						$.each(result.top5SbeByStatus,function(key,value){
							if (value.project_type == 'Maintenance') {
								if (value.top_nominals.length == 0) {
									appendMaintenance = appendMaintenance + '<tr>'
										appendMaintenance = appendMaintenance + '<td colspan="4">'
											appendMaintenance = appendMaintenance + '<span style="display:flex;justify-content:center;vertical-align:center">'
												appendMaintenance = appendMaintenance + 'No Data..'
											appendMaintenance = appendMaintenance + '</span>'
										appendMaintenance = appendMaintenance + '<td>'
									appendMaintenance = appendMaintenance + '</tr>'
								}else{
									$.each(value.top_nominals,function(key,values){
										appendMaintenance = appendMaintenance + '<tr>'
											appendMaintenance = appendMaintenance + '<td>'+ ++key +'</td>'
											appendMaintenance = appendMaintenance + '<td>'+ values.name +'</td>'
											appendMaintenance = appendMaintenance + '<td>'+ values.opp_name +'</td>'
											appendMaintenance = appendMaintenance + '<td style="text-align:justify">'+ formatter.format(values.nominal) +'</td>'
										appendMaintenance = appendMaintenance + '</tr>'
									})
								}
							}
						})
					}
				appendMaintenance = appendMaintenance + '</tbody>'		

				$("#tb_project_maintenance").append(appendMaintenance)

				$("#tb_project_implementation_maintenance").empty("")
				//implementation + maintenance
				appendImplementationMain = ''
				appendImplementationMain = appendImplementationMain + '<thead>'
					appendImplementationMain = appendImplementationMain + '<tr>'
						appendImplementationMain = appendImplementationMain + '<th>No</th>'
						appendImplementationMain = appendImplementationMain + '<th>Created By</th>'
						appendImplementationMain = appendImplementationMain + '<th>Project Name</th>'
						appendImplementationMain = appendImplementationMain + '<th>Nominal</th>'
					appendImplementationMain = appendImplementationMain + '<tr>'
				appendImplementationMain = appendImplementationMain + '</thead>'
				appendImplementationMain = appendImplementationMain + '<tbody>'
					if (result.top5SbeByStatus.length == 0) {
						appendImplementationMain = appendImplementationMain + '<tr>'
							appendImplementationMain = appendImplementationMain + '<td colspan="4">'
								appendImplementationMain = appendImplementationMain + '<span style="display:flex;justify-content:center;vertical-align:center">'
									appendImplementationMain = appendImplementationMain + 'No Data..'
								appendImplementationMain = appendImplementationMain + '</span>'
							appendImplementationMain = appendImplementationMain + '<td>'
						appendImplementationMain = appendImplementationMain + '</tr>'
					}else{
						$.each(result.top5SbeByStatus,function(key,value){
							if (value.project_type == 'Implementation + Maintenance') {
								if (value.top_nominals.length == 0) {
									appendImplementationMain = appendImplementationMain + '<tr>'
										appendImplementationMain = appendImplementationMain + '<td colspan="4">'
											appendImplementationMain = appendImplementationMain + '<span style="display:flex;justify-content:center;vertical-align:center">'
												appendImplementationMain = appendImplementationMain + 'No Data..'
											appendImplementationMain = appendImplementationMain + '</span>'
										appendImplementationMain = appendImplementationMain + '<td>'
									appendImplementationMain = appendImplementationMain + '</tr>'
								}else{
									$.each(value.top_nominals,function(key,values){
										appendImplementationMain = appendImplementationMain + '<tr>'
											appendImplementationMain = appendImplementationMain + '<td>'+ ++key  +'</td>'
											appendImplementationMain = appendImplementationMain + '<td>'+ values.name +'</td>'
											appendImplementationMain = appendImplementationMain + '<td style="text-align:justify">'+ values.opp_name +'</td>'
											appendImplementationMain = appendImplementationMain + '<td>'+ formatter.format(values.nominal) +'</td>'
										appendImplementationMain = appendImplementationMain + '</tr>'
									})
								}
							}
						})
					}
				appendImplementationMain = appendImplementationMain + '</tbody>'

				$("#tb_project_implementation_maintenance").append(appendImplementationMain)

				const labelTotalSbeByStatus = [];
				const dataTotalSbeByStatus = [];
				let grand_total_by_status = 0;

				if (result.totalSbeByStatus.length == 0) {
					$("#totalSbeByStatus").before("<span style='display:flex;justify-content:center;vertical-align:center'>No Data..</span>")
			        $("#totalSbeByStatus").next().remove()
				}else{
					$("#totalSbeByStatus").prev().remove()
					result.totalSbeByStatus.forEach((item, index) => {
					    labelTotalSbeByStatus.push(item.status); // Add the status to labels
					    dataTotalSbeByStatus.push(item.total_status); // Add the sum_nominal to data
					    grand_total_by_status += item.total_status
					});

			        $("#totalSbeByStatus").next().remove()
			        $("#totalSbeByStatus").after("<div style='display:flex;justify-content:center'> <div style='width:35px;height:15px;margin-top:5px' class='btn-outline-secondary'></div> <span style='font-size:14px;color:grey'> &nbsp&nbspGrand Total : "+ grand_total_by_status +"</span></div>")
				}

				if (initChartTotalSbeByStatus) {
		            initChartTotalSbeByStatus.destroy()        
		        }

				// var ctx = document.getElementById('totalSbeByStatus').getContext('2d');
		        // var chartTotalSbeByStatus = new Chart(ctx, {
		        //     type: 'pie', // Define the chart type as a Pie chart
		        //     data: {
		        //         labels: labelTotalSbeByStatus, // Labels for the slices
		        //         datasets: [{
		        //             label: 'Total Sbe By Status',
		        //             data: dataTotalSbeByStatus, // Values for each slice in the first dataset
		        //             backgroundColor: ['#5b9bd5', '#ed7d31'], // Slice colors
		        //             borderColor: '#fff',
		        //             borderWidth: 1
		        //         }]
		        //     },
		        //     options: {
		        //         responsive: true, // Make the chart responsive to screen size
		        //         plugins: {
		        //             legend: {
		        //               position:'bottom',
				// 			  display: true,
				// 			  labels: {
				// 			    generateLabels: function (chart) {
				// 			      const data = chart.data;
				// 			      const arcOpts = chart.options.elements.arc;

				// 			      return data.labels.map((label, i) => {
				// 			        const meta = chart.getDatasetMeta(0);
				// 			        const arc = meta.data[i];
				// 			        const dataset = data.datasets[0];

				// 			        // Use dataset values or defaults
				// 			        const backgroundColor = dataset.backgroundColor[i] || arcOpts.backgroundColor;
				// 			        const hidden = arc.hidden;

				// 			        return {
				// 			          text: `${label} : ${parseFloat(dataset.data[i])}`,
				// 			          fillStyle: backgroundColor,
				// 			          hidden: hidden,
				// 			          index: i,
				// 			        };
				// 			      });
				// 			    },
				// 			  },
				// 			},
		        //             tooltip: {
		        //                 enabled: true, // Enable tooltips
		        //             },
		        //             datalabels: {
				// 	            formatter: (value, ctx) => {
				// 	              const dataset = ctx.chart.data.datasets[0];
				// 	              const total = dataset.data.reduce((sum, val) => sum + val, 0);
				// 	              const percentage = ((value / total) * 100).toFixed(1);
				// 	           	  return `${percentage}% (${value})`; // Percentage and value
				// 	            },
				// 	            color: '#fff',
				// 	            font: {
				// 	              size: 14,
				// 	            },
				// 	        }
		        //         }
		        //     },
		        //     plugins:[ChartDataLabels]
		    	// });

		    	const bodyStyles = getComputedStyle(document.body);

				const fontColor = bodyStyles.getPropertyValue('--bs-body-color') || '#333';
				const fontSize = bodyStyles.getPropertyValue('font-size') || '14px';
				const fontFamily = bodyStyles.getPropertyValue('font-family') || 'Lucida Sans, sans-serif';


		    	var optionsSbebyStatus = {
		          	chart: {
			            type: 'pie',
			            height: 350,
			            parentHeightOffset: 0,
			            fontFamily: fontFamily.trim()
			        },
			        series: dataTotalSbeByStatus, // Data values
			        labels: labelTotalSbeByStatus, // Legends
			        colors: [
			            '#5b9bd5', '#ed7d31'
			        ], // Custom colors
			        stroke: {
			            width: 0
			        },
			        legend: {
			            position: 'bottom',
			            markers: {
			              width: 10,
			              height: 10,
			              radius: 12, // Rounded markers
			            },
			            labels: {
			            	colors: fontColor.trim(),
			            }
			        },
		          	tooltip: {
			            enabled: true,
			            y: {
			                formatter: function(value) {
			                    let total = dataTotalSbeByStatus.reduce((sum, val) => sum + val, 0);
			                    let percentage = ((value / total) * 100).toFixed(1);
			                    return `${percentage}% (${value})`;
			                }
			            }
			        },
			        dataLabels: {
			            enabled: true,
			            formatter: function(value, { seriesIndex }) {
			                let total = dataTotalSbeByStatus.reduce((sum, val) => sum + val, 0);
			                let percentage = ((dataTotalSbeByStatus[seriesIndex] / total) * 100).toFixed(1);
			                return `${percentage}% (${dataTotalSbeByStatus[seriesIndex]})`;
			            },
			            style: {
			                fontSize: '14px',
			                colors: ['#fff']
			            }
			        },
			    };

		    	var chartTotalSbeByStatus = new ApexCharts(document.querySelector("#totalSbeByStatus"), optionsSbebyStatus);
        		chartTotalSbeByStatus.render();

        		initChartTotalSbeByStatus = chartTotalSbeByStatus    

		        const labelSumSbeByStatus = [];
				const dataSumSbeByStatus = [];
				let grand_sum_by_status = 0;

				if (result.sumSbeByStatus.length == 0) {
					$("#sumSbeByStatus").before("<span style='display:flex;justify-content:center;vertical-align:center'>No Data..</span>")
			        $("#sumSbeByStatus").next().remove()
				}else{
					$("#sumSbeByStatus").prev().remove()
					result.sumSbeByStatus.forEach((item, index) => {
					    labelSumSbeByStatus.push(item.status); // Add the status to labels
					    dataSumSbeByStatus.push(item.sum_nominal); // Add the sum_nominal to data
					    grand_sum_by_status += item.sum_nominal
					});

			        $("#sumSbeByStatus").next().remove()
			        $("#sumSbeByStatus").after("<div style='display:flex;justify-content:center'> <div style='width:35px;height:15px;margin-top:5px' class='btn-outline-secondary'></div> <span style='font-size:14px;color:grey'> &nbsp&nbspGrand Total : "+ formatter.format(grand_sum_by_status) +"</span></div>")
				}

				if (initChartSumSbeByStatus) {
		            initChartSumSbeByStatus.destroy()        
		        }

		        // var ctx2 = document.getElementById('sumSbeByStatus').getContext('2d');
		        // var chartSumSbeByStatus = new Chart(ctx2, {
		        //     type: 'pie', // Define the chart type as a Pie chart
		        //     data: {
		        //         labels: labelSumSbeByStatus, // Labels for the slices
		        //         datasets: [{
		        //             label: 'Dataset 1',
		        //             data: dataSumSbeByStatus, // Values for each slice in the first dataset
		        //             backgroundColor: ['#5b9bd5', '#ed7d31'], // Slice colors
		        //             borderColor: '#fff',
		        //             borderWidth: 1
		        //         }]
		        //     },
		        //     options: {
		        //         responsive: true, // Make the chart responsive to screen size
		        //         plugins: {
		        //             legend: {
		        //               position:'bottom',
				// 			  display: true,
				// 			  labels: {
				// 			    generateLabels: function (chart) {
				// 			      const data = chart.data;
				// 			      const arcOpts = chart.options.elements.arc;

				// 			      return data.labels.map((label, i) => {
				// 			        const meta = chart.getDatasetMeta(0);
				// 			        const arc = meta.data[i];
				// 			        const dataset = data.datasets[0];

				// 			        // Use dataset values or defaults
				// 			        const backgroundColor = dataset.backgroundColor[i] || arcOpts.backgroundColor;
				// 			        const hidden = arc.hidden;

				// 			        return {
				// 			          text: `${label} : ${formatter.format(parseFloat(dataset.data[i]))}`,
				// 			          fillStyle: backgroundColor,
				// 			          hidden: hidden,
				// 			          index: i,
				// 			        };
				// 			      });
				// 			    },
				// 			  },
				// 			},
		        //             tooltip: {
		        //                 enabled: true, // Enable tooltips
		        //             },
		        //             datalabels: {
				// 	            formatter: (value, ctx) => {
				// 	              const dataset = ctx.chart.data.datasets[0];
				// 	              const total = dataset.data.reduce((sum, val) => sum + val, 0);
				// 	              const percentage = ((value / total) * 100).toFixed(1);
				// 	              return `${formatter.format(value)}`; // Percentage and value
				// 	            },
				// 	            color: '#fff',
				// 	            font: {
				// 	              size: 14,
				// 	            },
				// 	        },
		        //         }
		        //     },
		        //     plugins:[ChartDataLabels]
		        // });

		        var optionsSumSbebyStatus = {
			        series: dataSumSbeByStatus, // Values for each slice
			        chart: {
			            type: 'pie',
			            height: 350,
			            fontFamily: fontFamily.trim()
			        },
			        labels: labelSumSbeByStatus, // Labels for each slice
			        colors: ['#5b9bd5', '#ed7d31'], // Slice colors
			        legend: {
			            position: 'bottom',
			            labels: {
			               	colors: fontColor.trim(),
			                useSeriesColors: false
			            }
			        },
			        tooltip: {
			            enabled: true,
			            y: {
			                formatter: function(value) {
			                    return new Intl.NumberFormat('id-ID').format(value); // Format number
			                }
			            }
			        },
			        dataLabels: {
			            enabled: true,
			            formatter: function(value, { seriesIndex }) {
			                return new Intl.NumberFormat('id-ID').format(dataSumSbeByStatus[seriesIndex]); // Format numbers
			            },
			            style: {
			                fontSize: '14px',
			                colors: ['#fff']
			            }
			        }
			    };

		        var chartSumSbeByStatus = new ApexCharts(document.querySelector("#sumSbeByStatus"), optionsSumSbebyStatus);
        		chartSumSbeByStatus.render();

        		initChartSumSbeByStatus = chartSumSbeByStatus    

		        const labelTotalSbeByType = [];
				const dataTotalSbeByType = [];
				let grand_total_by_type = 0;

				if (result.totalSbeByType.length == 0) {
					$("#totalSbeByType").before("<span style='display:flex;justify-content:center;vertical-align:center'>No Data..</span>")
			        $("#totalSbeByType").next().remove()
				}else{
					$("#totalSbeByType").prev().remove()
					result.totalSbeByType.forEach((item, index) => {
					    labelTotalSbeByType.push(item.project_type); // Add the status to labels
					    dataTotalSbeByType.push(item.count); // Add the sum_nominal to data
					    grand_total_by_type += item.count
					});

			        $("#totalSbeByType").next().remove()
			        $("#totalSbeByType").after("<div style='display:flex;justify-content:center'> <div style='width:35px;height:15px;margin-top:5px' class='btn-outline-secondary'></div> <span style='font-size:14px;color:grey'> &nbsp&nbspGrand Total : "+ grand_total_by_type +"</span></div>")
				}

				if (initChartTotalSbeByType) {
		            initChartTotalSbeByType.destroy()        
		        }

		        // var ctx3 = document.getElementById('totalSbeByType').getContext('2d');
		        // var chartTotalSbeByStatus = new Chart(ctx3, {
		        //     type: 'pie', // Define the chart type as a Pie chart
		        //     data: {
		        //         labels: labelTotalSbeByType, // Labels for the slices
		        //         datasets: [{
		        //             label: 'Dataset 1',
		        //             data: dataTotalSbeByType,
		        //             backgroundColor: ['#ffd700','#ff4100','#0097ff','#ed7d31'], // Slice colors
		        //             borderColor: '#fff',
		        //             borderWidth: 1
		        //         }]
		        //     },
		        //     options: {
		        //         responsive: true, // Make the chart responsive to screen size
		        //         plugins: {
		        //             legend: {
		        //               position:'bottom',
				// 			  display: true,
				// 			  labels: {
				// 			    generateLabels: function (chart) {
				// 			      const data = chart.data;
				// 			      const arcOpts = chart.options.elements.arc;

				// 			      return data.labels.map((label, i) => {
				// 			        const meta = chart.getDatasetMeta(0);
				// 			        const arc = meta.data[i];
				// 			        const dataset = data.datasets[0];

				// 			        // Use dataset values or defaults
				// 			        const backgroundColor = dataset.backgroundColor[i] || arcOpts.backgroundColor;
				// 			        const hidden = arc.hidden;

				// 			        return {
				// 			          text: `${label} : ${parseFloat(dataset.data[i])}`,
				// 			          fillStyle: backgroundColor,
				// 			          hidden: hidden,
				// 			          index: i,
				// 			        };
				// 			      });
				// 			    },
				// 			  },
				// 			},
		        //             tooltip: {
		        //                 enabled: true, // Enable tooltips
		        //             },
		        //             datalabels: {
				// 	            formatter: (value, ctx) => {
				// 	              const dataset = ctx.chart.data.datasets[0];
				// 	              const total = dataset.data.reduce((sum, val) => sum + val, 0);
				// 	              const percentage = ((value / total) * 100).toFixed(1);
				// 	              return `${percentage}% (${value})`; // Percentage and value
				// 	            },
				// 	            color: '#fff',
				// 	            font: {
				// 	              size: 14,
				// 	            },
				// 	        },
		        //         }
		        //     },
		        //     plugins:[ChartDataLabels]
		        // });
		        var optionsTotalSbeByStatus = {
			        series: dataTotalSbeByType, // Values for each slice
			        chart: {
			            type: 'pie',
			            height: 350,
			            fontFamily: fontFamily.trim()
			        },
			        labels: labelTotalSbeByType, // Labels for each slice
			        colors: ['#ffd700', '#ff4100', '#0097ff', '#ed7d31'], // Slice colors
			        legend: {
			            position: 'bottom',
			            labels: {
			            	colors: fontColor.trim(),
			                useSeriesColors: false
			            }
			        },
			        tooltip: {
			            enabled: true,
			            y: {
			                formatter: function(value) {
			                    return new Intl.NumberFormat('id-ID').format(value); // Format number
			                }
			            }
			        },
			        dataLabels: {
			            enabled: true,
			            formatter: function(value, { seriesIndex }) {
			                let total = dataTotalSbeByType.reduce((sum, val) => sum + val, 0);
			                let percentage = ((dataTotalSbeByType[seriesIndex] / total) * 100).toFixed(1);
			                return `${percentage}% (${new Intl.NumberFormat('id-ID').format(dataTotalSbeByType[seriesIndex])})`; // Format percentage + value
			            },
			            style: {
			                fontSize: '14px',
			                colors: ['#fff']
			            }
			        }
			    };

			    var chartTotalSbeByStatus = new ApexCharts(document.querySelector("#totalSbeByType"), optionsTotalSbeByStatus);
    			chartTotalSbeByStatus.render();

        		initChartTotalSbeByType = chartTotalSbeByStatus    

				}
			})
		}
		
	</script>
@endsection
