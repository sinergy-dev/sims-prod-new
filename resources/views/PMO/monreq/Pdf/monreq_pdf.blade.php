<!DOCTYPE html>
<html>
<head>
	<title>Money Request</title>
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
      		font-size: 8px;
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
      		font-family: 'Roboto', sans-serif;
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
					<h6>Formulir Money Request</h6>
				</td>
				<td style="width:20%;"></td>
				<td style="width:30%; text-align: right;">
					<img src="img/logosip.png" style="width:100px">
				</td>
			</tr>
		</table>
	</header>
	<div style="text-align:center;">
		<table style="width: 100%;font-family: 'Roboto', sans-serif;">
			<tr>
				<td width="3%">No :</td>
				<td>{{$data['monReq']->no_monreq}}</td>
			</tr>
		</table>
		<table style="width: 100%;">
			<tr>
				<td>
					{{ \Carbon\Carbon::parse($data['monReq']->request_date)->format('l, d F Y') }}
				</td>
			</tr>
		</table>
		<table class="table-content">
			<thead>
				<tr>
					<th width="2%">No</th>
					<th width="10%">PID</th>
					<th>Description</th>
					<th>Personel</th>
					<th>Qty</th>
					<th>Harga</th>
					<th>Total</th>
					<th>Event Detail</th>
					<th>Start</th>
					<th>Finish</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data['monReq']['pid_details'] as $key => $details)
					@foreach($details->details as $keys => $data_details)
						<tr>
							<td style="font-size: 8px">{{++$keys}}</td>
							<td style="font-size: 8px">{{$data_details->pid}}</td>
							<td style="font-size: 8px">{{$data_details->category}}</td>
							<td style="font-size: 8px">{!! nl2br(e($details->team_name)) !!}</td>
							<td style="font-size: 8px">{{$data_details->unit_concat}}</td>
							<td style="font-size: 8px">Rp.{{number_format($data_details->price,2)}}</td>
							<td style="font-size: 8px">Rp.{{number_format($data_details->total_price,2)}}</td>
							<td style="font-size: 8px">{{$details->event_detail}}</td>
							<td style="font-size: 8px">{{$details->start_date}}</td>
							<td style="font-size: 8px">{{$details->end_date}}</td>
						</tr>
					@endforeach
					<tr>
						<th colspan="6" style="text-align:right;">Total</th>
						<th colspan="4" style="text-align: left;">Rp.{{number_format($details->nominal,2)}}</th>
					</tr>
				@endforeach
				<tr>
					<td colspan="3">Transfer dari finance</td>
					<td colspan="7" style="text-align:left;">{{$data['monReq']->tf_from_finance}}</td>
				</tr>
				<tr>
					<td colspan="3">Rencana Settlement</td>
					<td colspan="7" style="text-align:left;">{{$data['monReq']->settlement_date_plan}}</td>
				</tr>
				<tr>
					<td colspan="3"><span style="color:red">No. Rekening : {{$data['monReq']->account_number}} A/N : {{$data['monReq']->account_name}}</span></td>
					<td colspan="7"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="6" style="text-align:right;">Grand Total</th>
					<th colspan="4" style="text-align:left;">Rp.{{number_format($data['monReq']->nominal,2)}}</th>
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
</body>
</html>
