<!DOCTYPE html>
<html>
<head>
	<title>KPHL</title>
	<style type="text/css">
		.bodyEmail {
			line-height: 1.1;
			font-size: xx-small;
			font-family: Tahoma, Geneva, sans-serif;
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
		}

		table {
			width: 100%;
      		border-collapse: collapse;
      		font-family: Tahoma, Geneva, sans-serif;
		}

		.table-content thead tr th{
			border: solid 0.5px;
			text-align: center;
		}

		.table-content tbody tr td{
			border: solid 0.5px;
      		padding: 4px;
		}

		.table-content tbody tr th{
			border: solid 0.5px;
      		padding: 4px;
		}

		.table-content tbody tr td:nth-child(1){
			text-align: center;
		}

		.table-content tbody tr td:nth-child(2){
			text-align: center;
		}

		.table-content tbody tr td:not(:nth-child(1)){
			text-align: left;
		}

		.table-content tfoot tr th{
			border: solid 0.5px;
      		padding: 4px;
      		background-color: #9CC3E5;
      		font-family: 'Tahoma', sans-serif;
      		text-align: left;
		}

		.table-image td {
            padding: 8px;
            text-align: left;
        }
	</style>
</head>
<body class="bodyEmail">
	<header>
		<table style="width: 100%;" >
			<tr>
				<td style="width:40%;">
					<p style="font-family:Consolas, monaco, monospace; color: grey;">
						DOC : SIP-FI-F006<br>
						REV : 01.00<br>
						DATE : 20/04/2021
					</p>
					<h6>Formulir KPHL</h6>
				</td>
				<td style="width:20%;"></td>
				<td style="width:30%; text-align: right;">
					<img src="img/logosip.png" style="width:100px">
				</td>
			</tr>
		</table>
	</header>
	<div style="text-align:center;">
		<table width="100%" style="text-align:center;margin-bottom: 20px;">
			<tr>
				<td style="text-align:center;">
					PID: {{$data['settlement']['pid_details'][0]['pid']}}				
				</td>
			</tr>
			<tr>
				<td style="text-align:center;">
					{{$data['settlement']['pid_details'][0]['name_project']->name_project}}										
				</td>
			</tr>
		</table>
		<table style="width: 100%;">
			<tr>
				<td>
					{{ \Carbon\Carbon::parse($data['settlement']['date'])->format('l, d F Y') }}
				</td>
			</tr>
		</table>
		<table class="table-content">
			<thead>
				<tr>
					<th width="2%" style="font-size: 10px;">No</th>
					<th style="font-size: 10px;">Description</th>
					<th colspan="2" style="font-size: 10px;">Time</th>
					<th style="font-size: 10px;">Sub Total</th>
					<th style="font-size: 10px;">Total</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data['settlement']['pid_details'][0]['details'] as $value)
					@if($value->sub_category == 'KPHL')
						<tr>
							<td>1</td>
							<td>
								{{$value->description}}<br>
								{{ \Carbon\Carbon::parse($value->start_date)->format('l, d F Y') }}
							</td>
							<td style="text-align:center;">{{$value->days_diff}}</td>
							<td style="text-align:center;">Hari</td>
							<td style="text-align:center;"> Rp {{number_format($value->sub_total,2)}} </td>
							<td>
								Rp {{number_format($value->total,2)}}
							</td>
						</tr>
					@endif
				@endforeach 
			</tbody>
			<tfoot>
				<tr>
					<th colspan="5" style="text-align:right;">Grand Total</th>
					<th style="text-align:left;">
					@foreach($data['settlement']['sub_category'] as $value)
						@if($value->sub_category == 'KPHL')
							Rp {{number_format($value['total_by_pid'][$data['settlement']['pid_details'][0]['pid']],2)}}
						@endif 
					@endforeach
					</th>
				</tr>
			</tfoot>
		</table>
	</div>
	<br><br><br>
	<table>
		<tr>
			<th colspan="3" style="text-align:center;font-family:Tahoma, Geneva,sans-serif;">Issued By:</th>
			<th colspan="3" style="text-align:center;font-family:Tahoma, Geneva,sans-serif;">Approved By:</th>
		</tr>
		<tr>
			<td colspan="3" style="text-align:center;">
				<img src="{{$data['getSign'][3][0]['ttd']}}" width="75px" height="75px" style="padding: 10px;">
			</td>
			<td colspan="3" style="text-align:center;">
				<img src="{{$data['getSign'][0]['ttd']}}" width="75px" height="75px" style="padding: 10px;">
			</td>
		</tr>
		<tr>
			<td colspan="3" style="text-align:center;font-family:Tahoma, Geneva,sans-serif;"><u>{{$data['getSign'][3][0]['name']}}</u></td>
			<td colspan="3" style="text-align:center;font-family:Tahoma, Geneva,sans-serif;"><u>{{$data['getSign'][0]['name']}}</u></td>
		</tr>
		<tr>
			<th colspan="3" style="text-align:center;font-family:Tahoma, Geneva,sans-serif;">{{$data['getSign'][3][0]['position']}}</th>
			<th colspan="3" style="text-align:center;font-family:Tahoma, Geneva,sans-serif;">{{$data['getSign'][0]['position']}}</th>
		</tr>
	</table>
	<div style="page-break-before: always;">
		<h2 style="text-align:center;"><u>Lampiran</u></h2>
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
</body>
</html>
