<!DOCTYPE html>
<html>
<head>
	<title>Claim</title>
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
      		font-family: 'Tahoma', sans-serif;
      		text-align: center;
		}

		.table-content tbody tr td{
			border: solid 0.5px;
      		padding: 4px;
      		font-family: 'Tahoma', sans-serif;
      		font-size: 9px;
		}

		.table-content tbody tr th{
			border: solid 0.5px;
      		padding: 4px;
      		font-family: 'Tahoma', sans-serif;
		}

		.table-content tfoot tr th{
			border: solid 0.5px;
      		padding: 4px;
      		background-color: #9CC3E5;
      		font-family: 'Tahoma', sans-serif;
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
					<h6>Formulir Claim</h6>
				</td>
				<td style="width:20%;"></td>
				<td style="width:30%; text-align: right;">
					<img src="img/logosip.png" style="width:100px">
				</td>
			</tr>
		</table>
	</header>
	<div>
		<table style="width: 100%;font-family: 'Roboto', sans-serif;">
			<tr>
				<th style="font-family: 'Roboto', sans-serif;text-align: left;" width="10%">NAME</th>
				<td style="font-family: 'Roboto', sans-serif;text-align: left;">
					{{$data['claim']['name']}} (No Rekening {{$data['claim']['account_number']}})
				</td>
			</tr>
		</table>
		<table style="width: 100%;">
			<tr>
				<th style="font-family: 'Roboto', sans-serif;text-align: left;" width="10%">EXPENSES</th>
				<td style="font-family: 'Roboto', sans-serif;text-align: left;">
					 Rp.{{number_format($data['claim']['nominal'],2)}}
				</td>
			</tr>
		</table>
		<table style="width: 100%;">
			<tr>
				<th style="font-family: 'Roboto', sans-serif;text-align: left;" width="10%">DATE</th>
				<td style="font-family: 'Roboto', sans-serif;text-align: left;">
					{{ \Carbon\Carbon::parse($data['claim']['date'])->format('d F Y') }}
				</td>
			</tr>
		</table>
		<table class="table-content">
			<thead>
				<tr>
					<th style="font-family:'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;width:5%">No</th>
					<th style="width:15%">DD/MM</th>
					<th>PID</th>
					<!--foreach-->
					@foreach($data['claim']['sub_category'] as $dataHeader)
					<th>{{strtoupper($dataHeader->sub_category)}}</th>
					@endforeach
					<!---->
					<th>TOTAL</th>
					<th>DESCRIPTION</th>
				</tr>
			</thead>
			@foreach($data['claim']['pid_details'] as $keyContent => $dataContent)
			<tbody>
				<?php 
					$count = 0;
				?>
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
						@foreach($data['claim']['sub_category'] as $dataHeader)
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
					<tr>
						<td colspan="3" style="text-align:center;background-color: lightgrey;">TOTAL</td>
					<?php $countFooter = count($data['claim']['sub_category']) + 3 ?>
					@foreach($data['claim']['sub_category'] as $keyFooter => $valueFooter)
						@foreach($valueFooter['total_by_pid'] as $keyDataFooter => $dataFooter)
							@if($keyDataFooter == $dataContent->pid)
								<td style="background-color: lightgrey">Rp.{{number_format($dataFooter,2)}}</td>
							@endif
						@endforeach
					@endforeach
						<td style="background-color: lightgrey">Rp.{{number_format($data['claim']['nominal'],2)}}</td>
						<td style="background-color: lightgrey"></td>
					</tr>
					<?php $countBlankFooter = count($data['claim']['sub_category']) + 5 ?>
					<tr>
						<td colspan="{{$countBlankFooter}}"></td>
					</tr>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3" style="text-align:right;">Total</th>
					<?php $countFooter = count($data['claim']['sub_category']) + 3 ?>
					@foreach($data['claim']['sub_category'] as $keyFooter => $valueFooter)
						@foreach($valueFooter['total_by_pid'] as $keyDataFooter => $dataFooter)
							@if($keyDataFooter == $dataContent->pid)
								<th>Rp.{{number_format($dataFooter,2)}}</th>
							@endif
						@endforeach
					@endforeach
					<th colspan="2">Rp.{{number_format($data['claim']['nominal'],2)}}</th>
				</tr>
			</tfoot>
			@endforeach
		</table>
	</div>
	<br><br>
	<table>
		<caption>Approver Sign</caption>
		@if(count($data['show_ttd']) > 2)
			<tr>
				<td colspan="3" style="text-align:center;"><img src="{{$data['show_ttd'][0]['ttd']}}" width="100px" height="100px" style="padding: 10px;"></td>
				<td colspan="3" style="text-align:center;"><img src="{{$data['show_ttd'][1]['ttd']}}" width="100px" height="100px" style="padding: 10px;"></td>
				<td colspan="3" style="text-align:center;"><img src="{{$data['show_ttd'][2]['ttd']}}" width="100px" height="100px" style="padding: 10px;"></td>
			</tr>
			<tr>
				<td colspan="3" style="text-align:center;font-family:Tahoma, Geneva,sans-serif;"><u>{{$data['show_ttd'][0]['name']}}</u></td>
				<td colspan="3" style="text-align:center;font-family:Tahoma, Geneva,sans-serif;"><u>{{$data['show_ttd'][1]['name']}}</u></td>
				<td colspan="3" style="text-align:center;font-family:Tahoma, Geneva,sans-serif;"><u>{{$data['show_ttd'][2]['name']}}</u></td>
			</tr>
			<tr>
				<th colspan="3" style="text-align:center;font-family:Tahoma, Geneva,sans-serif;">{{$data['show_ttd'][0]['position']}}</th>
				<th colspan="3" style="text-align:center;font-family:Tahoma, Geneva,sans-serif;">{{$data['show_ttd'][1]['position']}}</th>
				<th colspan="3" style="text-align:center;font-family:Tahoma, Geneva,sans-serif;">{{$data['show_ttd'][2]['position']}}</th>
			</tr>
		@else
			<tr>
				<td colspan="3" style="text-align:center;"><img src="{{$data['show_ttd'][0]['ttd']}}" width="100px" height="100px" style="padding: 10px;"></td>
				<td colspan="3" style="text-align:center;"><img src="{{$data['show_ttd'][0]['ttd']}}" width="100px" height="100px" style="padding: 10px;"></td>
			</tr>
			<tr>
				<td colspan="3" style="text-align:center;font-family:Tahoma, Geneva,sans-serif;"><u>{{$data['show_ttd'][0]['name']}}</u></td>
				<td colspan="3" style="text-align:center;font-family:Tahoma, Geneva,sans-serif;"><u>{{$data['show_ttd'][1]['name']}}</u></td>
			</tr>
			<tr>
				<th colspan="3" style="text-align:center;font-family:Tahoma, Geneva,sans-serif;">{{$data['show_ttd'][0]['position']}}</th>
				<th colspan="3" style="text-align:center;font-family:Tahoma, Geneva,sans-serif;">{{$data['show_ttd'][1]['position']}}</th>
			</tr>
		@endif
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
</body>
</html>
