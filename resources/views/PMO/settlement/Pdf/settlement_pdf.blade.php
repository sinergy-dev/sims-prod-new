<!DOCTYPE html>
<html>
<head>
	<title>Settlement</title>
	<style type="text/css">
		.body {
			line-height: 1.1;
			font-size: 9px;
			font-family:Lucida Sans, Lucida Grande, Lucida Sans Unicode, sans-serif
		}
		@page { 
			margin: 80px 40px 100px 40px;
		}

		header { 
			position: fixed; 
			top: -80px; 
			left: 0px; 
			right: 0px; 
			height: 50px; 
		}
		footer { 
			position: fixed; 
			bottom: -50px; 
			left: 0px; 
			right: 0px; 
			height: 50px; 
		}
		.table_cover_footer {
			background-image:url("https://eod-api.sifoma.id//storage/image/pdf_image/footer7.png");
			background-repeat: no-repeat;
		}.

		.table-content {
			width: 100%;
      		border-collapse: collapse;
      		border: solid 0.5px;
      		font-size: 8px;
		}

		.table-content thead tr th, tr.footer-tr td{
      		border: solid 0.5px;
      		background-color: lightgray;
		}

		.table-content tr td{
      		border: solid 0.5px;
      		text-align: justify;
		}
		.table-content tfoot tr th{
      		border: solid 0.5px;
      		text-align: justify;
      		background-color: #3c8dbc;
		}

		.table-image td {
            padding: 8px;
            text-align: left;
        }
	</style>
</head>
<body class="body">
	<header>
		<table style="width: 100%;" >
			<tr>
				<td style="width:40%;">
					<p style="font-family:Consolas, monaco, monospace; color: grey;">
						DOC : SIP-FI-F006<br>
						REV : 01.00<br>
						DATE : 20/04/2021
					</p>
					<h6>Formulir Pertanggungjawaban</h6>
				</td>
				<td style="width:20%;"></td>
				<td style="width:30%; text-align: right;">
					<img src="img/logosip.png" style="width:100px">
				</td>
			</tr>
		</table>
	</header>
	<div style="text-align:center;">
		<span>
			LAPORAN REKAPITULASI DANA PROYEK<br>
			PEMAKAIAN MONEY REQUEST<br>
			<!--loop PID-->
			@foreach($data['settlement']['pid_details'] as $key => $dataPid)
				PID: {{$dataPid->name_project->id_project_name}} <br>
			@endforeach
			<!-- no rek : sssss - nama acc-->
			No Rek : {{ $data['settlement']['account_number']}} - {{ $data['settlement']['account_name']}} 
		</span><br><br><br>
		<table class="table-content" style="width: 100%;">
			<thead>
				<tr>
					<th style="font-family:'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif">No</th>
					<th style="width:15%">DD/MM</th>
					<th>PID</th>
					@foreach($data['settlement']['sub_category'] as $dataHeader)
					<th>{{strtoupper($dataHeader->sub_category)}}</th>
					@endforeach
					<th>TOTAL</th>
					<th>DESCRIPTION</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$count = 0;
				?>
				@foreach($data['settlement']['pid_details'] as $keyContent => $dataContent)
					@foreach($dataContent['details'] as $keyDetailContent => $dataDetailContent)
						<tr>
							<td style="font-family:'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;text-align:center;">{{++$keyDetailContent}}</td>
							<td>
								@if($dataDetailContent->date != '-')
									{{\Carbon\Carbon::parse($dataDetailContent->date)->format('d F Y')}}
								@else
									-
								@endif
							</td>
							<td>{{$dataContent->pid}}</td>
							@foreach($data['settlement']['sub_category'] as $dataHeader)
								@if($dataDetailContent->sub_category == $dataHeader->sub_category)
									<td style="font-family:'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif">
										Rp.{{number_format($dataDetailContent->nominal,2)}}</td>
								@else
									<td style="font-family:'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif">
										-
									</td>
								@endif
							@endforeach
							<td>Rp.{{number_format($dataDetailContent->nominal,2)}}</td>
							<td>{!!nl2br(e($dataDetailContent->description))!!}</td>
						</tr>
					@endforeach
						<tr class="footer-tr">
							<td colspan="3" style="text-align: right;">TOTAL</td>
						<?php $countFooter = count($data['settlement']['sub_category']) + 3 ?>
						@foreach($data['settlement']['sub_category'] as $keyFooter => $valueFooter)
							@foreach($valueFooter['total_by_pid'] as $keyDataFooter => $dataFooter)
								@if($keyDataFooter == $dataContent->pid)
									<td>Rp.{{number_format($dataFooter,2)}}</td>
								@endif
							@endforeach
						@endforeach
							<td colspan="2"></td>
						</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="{{$countFooter}}" style="text-align:center;">Transferred from finance (Cash)</th>
					<th colspan="2" style="text-align:center;">Rp{{number_format($data['tf_from_finance'],2)}}</th>
				</tr>
				<tr>
					<th colspan="{{$countFooter}}" style="text-align:center;">The amount of use of fund</th>
					<th colspan="2" style="text-align:center;">Rp.{{number_format($data['used_amount'],2)}}</th>
				</tr>
				<tr>
					<th colspan="{{$countFooter}}" style="text-align:center;">Remaining Funds</th>
					<th colspan="2" style="text-align:center;">Rp.{{number_format($data['remaining_funds'],2)}}</th>
				</tr>
			</tfoot>
		</table>
	</div>
	<br><br><br>
	<table style="width:100%">
		<tr>
			<td colspan="2" style="text-align:center;font-family:Tahoma, Geneva,sans-serif;width: 60%;">Approved By:</td>
			<td style="text-align:center;font-family:Tahoma, Geneva,sans-serif;width: 40%;">Acknowledge By:</td>
		</tr>
		<tr>
			<td style="text-align:right;padding-right: 25px;">
				<img src="{{$data['getSign'][0]['ttd']}}" width="80px" height="80px" style="padding: 10px;">
			</td>
			<td style="text-align:left;padding-left: 20px;"><img src="{{$data['getSign'][0]['ttd']}}" width="80px" height="80px" style="padding: 10px;">
			</td>
			<td style="text-align:center;">
				<img src="{{$data['getSign'][2]['ttd']}}" width="80px" height="80px" style="padding: 10px;">
			</td>
		</tr>
		<tr>
			<td style="text-align:right;padding-right: 50px;font-family:Tahoma, Geneva,sans-serif;"><u>{{$data['getSign'][0]['name']}}</u></td>
			<td style="text-align:left;padding-left: 10px;font-family:Tahoma, Geneva,sans-serif;"><u>{{$data['getSign'][1]['name']}}</u></td>
			<td style="text-align:center;font-family:Tahoma, Geneva,sans-serif;"><u>{{$data['getSign'][2]['name']}}</u></td>
		</tr>
		<tr>
			<th style="text-align:right;padding-right: 15px;font-family:Tahoma, Geneva,sans-serif;">{{$data['getSign'][0]['position']}}</th>
			<th style="text-align:left;padding-left: 15px;font-family:Tahoma, Geneva,sans-serif;">{{$data['getSign'][1]['position']}}</th>
			<th style="text-align:center;font-family:Tahoma, Geneva,sans-serif;">{{$data['getSign'][2]['position']}}</th>
		</tr>
	</table>
	<footer>
		<table style="width: 100%" class="table_cover_footer">
			<tr>
				<td colspan="4" style="font: 11px;">
					<b style="color: #7f0f7e">PT. Sinergy Informasi Pratama</b>
				</td>
			</tr>
			<tr>
				<td style="width: 12%;font: 9px;">
					<b>Central Office</b>
				</td>
				<td style="width: 68%;font: 9px;">
					: Jl. Puri Kencana Blok K6 No.2M-2L, Kembangan, Jakarta Barat 11610
				</td>
				<td style="width: 5%;font: 9px;">
					Tel
				</td>
				<td style="width: 15%;font: 9px;">
					: +62 21 583 55599
				</td>
			</tr>
			<tr>
				<td style="width: 12%;font: 9px;">
					<b>Operational Office</b>
				</td>
				<td style="width: 68%;font: 9px;">
					: Gedung Inlingua Jl. Puri indah Kav. A2/3 No. 33-35, Puri Indah, Jakarta Barat 11610
				</td>
				<td style="width: 5%;font: 9px;">
					Fax
				</td>
				<td style="width: 15%;font: 9px;">
					: +62 21 583 55188
				</td>
			</tr>
			<tr>
				<td style="width: 12%;font: 9px;">
				</td>
				<td style="width: 68%;font: 9px;">
				</td>
				<td style="width: 5%;font: 9px;">
				</td>
				<td style="width: 15%;font: 9px;">
				</td>
			</tr>
			<tr>
				<td style="width: 12%;font: 9px;">
				</td>
				<td style="width: 68%;font: 9px;">
				</td>
				<td style="width: 5%;font: 9px;">
				</td>
				<td style="width: 15%;font: 9px;">
				</td>
			</tr>
			<tr>
				<td style="width: 10%;font: 10px;" colspan="2">
					<span style="color:white">.</span>
				</td>
				<td style="width: 5%;font: 9px;">
					Web
				</td>
				<td style="width: 15%;font: 9px;">
					: www.sinergy.co.id
				</td>
			</tr>
		</table>
	</footer>
	<div style="page-break-before: always;">
		<u><h2 style="text-align:center;">Lampiran</h2></u>
		<table class="table-image">
		@php
		    $arrayData = [];
		    foreach ($data['settlement']['pid_details'] as $dataPid) {
		        foreach ($dataPid['details'] as $dataImage) {
	        		$image = $dataImage->receipt ?? $dataImage->image;

		            $url = $image;

		            // Explode the URL by "/d/"
		            $parts = explode('/d/', $url);

		            // Now, explode the second part by the next "/"
		            $fileId = explode('/', $parts[1])[0];

		            // Alias receipt to image
		            // Push the aliased data into the array
		            $arrayData[] = [
		                'image' => $fileId, // Receipt is now treated as image
		            ];
		        }
		    }
		@endphp

		@foreach(array_chunk($arrayData, 2) as $row) 
		    <tr>
		        @foreach($row as $column)
		            <td>
		                <img style="width:250px;height: 400px;" src="https://drive.usercontent.google.com/download?id={{ $column['image'] }}&export=view" alt="Image 1">
		            </td>
		        @endforeach
		    </tr>
		@endforeach
		</table>
	</div>
</body>
</html>
