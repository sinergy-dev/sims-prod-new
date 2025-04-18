@extends('template.main_sneat')
@section('tittle')
	Presence History
@endsection
@section('pageName')
  Presence History
@endsection
@section('head_css')
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
@endsection
@section('content')	
<div class="container-xxl flex-grow-1 container-p-y">
	<section class="content">
		<div class="row">
			<div class="col-md-4 col-xs-12">
				<div class="card">
					<div class="card-header with-border">
						<h6 class="card-title">My Attendance Summary</h6>			
					</div>
					<div class="card-body">
						<div id="pieChart" style="height:300px"></div>
						<!-- <canvas id="pieChart" style="height:300px"></canvas> -->
					</div>
				</div>
			</div>
			<div class="col-md-8 col-xs-12">
				<div class="card">
					<div class="card-header with-border">
						<h6 class="card-title">My Attendance Detail</h6>			
					</div>
					<div class="card-body table-responsive">
						<table class="table table-hover" id="table-presence">
							<thead>
								<tr>
									<th>Date</th>
									<th>Schedule</th>
									<th>Checkin</th>
									<th>Checkout</th>
									<th>Condition</th>
								</tr>
							</thead>
							<tbody>
								@foreach($presenceHistoryDetail as $presence)
								<tr>
									<td>{{$presence->date}}</td>
									<td>{{$presence->schedule}}</td>
									<td>{{$presence->checkin}}</td>
									@if($presence->checkin == $presence->checkout)
									<td>-</td>
									@else
									<td>{{$presence->checkout}}</td>
									@endif
									<td class="text-center">
										@if($presence->condition == "On-Time")
											<span class="label label-success">{{$presence->condition}}</span>
										@elseif($presence->condition == "Injury-Time")
											<span class="label label-warning">{{$presence->condition}}</span>
										@else
											<span class="label label-danger">{{$presence->condition}}</span>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
@section('scriptImport')
	<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
	<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
	<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection
@section('script')
<script type="text/javascript">
	$("#table-presence").DataTable({
		"ajax":{
           "type":"GET",
           "url":"{{url('/presence/history/personalMsp')}}",
        },
        "order": [[ 0, "desc" ]],
        "columns": [
            {
              render: function ( data, type, row ) {
                return '<i>'+ row.date +'</i>';
              }
            },  
            // { "data": "name_product" },  
            {
              render: function ( data, type, row ) {
                 return '<i>'+ row.schedule +'</i>';
                
              }
            },  
            {
              render: function ( data, type, row ) {
                 return '<i>'+ row.checkin +'</i>';
                
              }
            },  
            {
              render: function ( data, type, row ) {
                 return '<i>'+ row.checkout +'</i>';
                
              }
            },  
            {
              render: function ( data, type, row ) {
              	if (row.condition == "On-Time") {
              		return '<span class="label label-success">' + row.condition + '</span>'
              	}else if (row.condition == "Injury-Time") {
              		return '<span class="label label-warning">' + row.condition + '</span>'
              	}else{
              		return '<span class="label label-danger">' + row.condition + '</span>'
              	}
                
              }
            },       
          ],
           // "order": [[ 0, "desc" ]]
	});

	var options = {
	    series: @json($presenceHistoryCounted->pluck('count')), // Data values
	    chart: {
	        type: 'donut',
	        height: 350
	    },
	    labels: @json($presenceHistoryCounted->keys()), // Labels for each slice
	    colors: @json($presenceHistoryCounted->pluck('color')), // Custom slice colors
	    legend: {
	        position: 'bottom',
	        labels: {
	            colors: '#333',
	            useSeriesColors: false
	        }
	    },
	    dataLabels: {
	        enabled: true,
	        formatter: function (val, opts) {
	            return opts.w.globals.labels[opts.seriesIndex] + " : " + opts.w.globals.series[opts.seriesIndex];
	        },
	        style: {
	            fontSize: '14px',
	            fontWeight: 'bold'
	        }
	    },
	    tooltip: {
	        y: {
	            formatter: function (value) {
	                return value;
	            }
	        }
	    }
	};

	var chart = new ApexCharts(document.querySelector("#pieChart"), options);
	chart.render();
</script>
@endsection