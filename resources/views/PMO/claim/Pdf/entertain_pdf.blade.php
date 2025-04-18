<!DOCTYPE html>
<html>
<head>
	<title>Entertainment</title>
	<style type="text/css">
		.bodyEmail {
			line-height: 1.1;
			font-size: xx-small;
			font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;
		}

		body {
	      margin: 0; /* Reset body margin */
	      padding: 0; /* Reset body padding */
	    }

		.rightHeader {
            width: 100%; /* Set the table width to 70% of the container */
            border-collapse: collapse; /* Optional: Collapse borders */
            padding: 5px;
            font-size: 8px;
        }

        .table-content {
        	border: solid 0.5px black;
            width: 100%; /* Set the table width to 70% of the container */
            border-collapse: collapse;
        }

        .table-content tr td{
        	padding: 5px;
        	font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;text-align: left;
        	font-size: 7px;
        	text-align: center;
        }

        .table-content-full-border {
            width: 100%; /* Set the table width to 70% of the container */
            border-collapse: collapse; /* Optional: Collapse borders */
        	font-size: 7px;
        	font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;
        	border: solid 0.5px black;
        }

        .table-content-full-border tr td, .table-content-full-border tr th{
        	font-size: 7px;
        	font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;
        	border: solid 0.5px black;
        	text-align: center;
        }

        .table-content-people-attending{
        	width: 100%; /* Set the table width to 70% of the container */
            border-collapse: collapse; /* Optional: Collapse borders */
        	font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;
        	font-size: 7px;
        }

        .table-content-people-sign{
        	width: 100%; /* Set the table width to 70% of the container */
            border-collapse: collapse; /* Optional: Collapse borders */
        	font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;
        	font-size: 7px;
        }

        footer { 
			position: fixed; 
			bottom: 0px; 
			left: 0px; 
			right: 0px; 
			height: 50px; 
		}

		.table_cover_footer {
			background-image:url("https://eod-api.sifoma.id//storage/image/pdf_image/footer7.png");
			background-repeat: no-repeat;
		}

	</style>
</head>
<body class="bodyEmail">
	<div style="margin-bottom: 10px;">
		<table class="rightHeader">
			<tr>
				<th colspan="5" width="60%"></th>
				<th style="padding:10px;border-top: solid 0.5px black;border-left: solid 0.5px black;;font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;text-align: left;">ENTERTAINMENT CLAIM FORM</th>
				<td style="padding:10px;border-top: solid 0.5px black;border-right: solid 0.5px black;text-align: right;">
					<table style="border-collapse:collapse;">
						<tr>
							<td style="font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;border: solid 0.5px black;padding: 2px;width: 50px;text-align: center;">FORM NO</td>
							<!--loop nomor?-->
							<td style="border: solid 0.5px black;">0</td>
							<td style="border: solid 0.5px black;">0</td>
							<td style="border: solid 0.5px black;">0</td>
							<td style="border: solid 0.5px black;">0</td>
							<td style="border: solid 0.5px black;">0</td>
							<td style="border: solid 0.5px black;">2</td>
							<!-- -->
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<th colspan="5"></th>
				<td colspan="2" style="text-align: left;border-left: solid 0.5px black;border-right: solid 0.5px black;padding-left: 10px;">This form must be fully complete before processing. Supporting documentation must be attached</td>
			</tr>
			<tr>
				<th colspan="5"></th>
				<td colspan="2" style="text-align:left;border-left: solid 0.5px black;border-bottom: solid 0.5px black;border-right: solid 0.5px black;padding-left: 10px;padding-bottom: 10px;">ONE FORM PER EVENT</td>
			</tr>
		</table>
	</div>
	<div style="margin-bottom: 10px;">
		<table class="table-content">
			<tr>
				<td width="20%">
					<table>
						<tr>
							<td rowspan="2" style="vertical-align: top;">
								Corporate Finance Use Only
							</td>
						</tr>
					</table>
				</td>
				<td width="10%">
					<table style="border-collapse: collapse;text-align: center;border: solid 0.5px black;padding-top: 5px;">
						<tr>
							<td colspan="6" style="text-align: center;vertical-align: middle;">POSTING DATE</td>
						</tr>
						<tr>
							<!-- loop date-->
							<td style="border:solid 0.5px black;height: 40px;">{{\Carbon\Carbon::parse($data['claim']['date'])->format('dmy')[0]}}</td>
							<td style="border: solid 0.5px black;height: 40px;">{{\Carbon\Carbon::parse($data['claim']['date'])->format('dmy')[1]}}</td>
							<td style="border: solid 0.5px black;height: 40px;">{{\Carbon\Carbon::parse($data['claim']['date'])->format('dmy')[2]}}</td>
							<td style="border: solid 0.5px black;height: 40px;">{{\Carbon\Carbon::parse($data['claim']['date'])->format('dmy')[3]}}</td>
							<td style="border: solid 0.5px black;height: 40px;">{{\Carbon\Carbon::parse($data['claim']['date'])->format('dmy')[4]}}</td>
							<td style="border: solid 0.5px black;height: 40px;">{{\Carbon\Carbon::parse($data['claim']['date'])->format('dmy')[5]}}</td>
							<!---->
						</tr>
					</table>
				</td>
				<td width="30%">
					<table style="border-collapse: collapse;text-align: center;border: solid 0.5px black;padding-top: 5px;" width="100%">
						<tr>
							<td style="text-align: center;vertical-align: middle;border: solid 0.5px black;">DOC REF - BPU NO.</td>
						</tr>
						<tr>
							<td style="height: 40px">-</td>
						</tr>
					</table>
				</td>
				<td width="20%">
					<table style="border-collapse: collapse;text-align: center;border: solid 0.5px black;padding-top: 5px;" width="100%">
						<tr>
							<td style="text-align: center;vertical-align: middle;border: solid 0.5px black;">CLAIM ALLOCATION ACCOUNT</td>
						</tr>
						<tr>
							<td style="height: 40px">Internal/project id</td>
						</tr>
					</table>
				</td>
				<td width="20%">
					<table style="border-collapse: collapse;text-align: center;border: solid 0.5px black;padding-top: 5px;" width="100%">
						<tr>
							<td style="text-align: center;vertical-align: middle;border: solid 0.5px black;">PROJECT NAME</td>
						</tr>
						<tr>
							<td style="height: 40px">{{$data['claim']['pid_details'][0]['name_project']->name_project}}</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<div style="margin-bottom: 10px;">
		<table class="table-content-full-border">
			<tr>
				<th style="text-align: center;font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;">DATE OF EVENT</th>
				<td style="text-align: center;font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;"><b>ENTERTAINMENT</b><br>
					<small>(Type of the purpose: Approach, deal/negotiation, closing, maintenance,coordination meeting)</small>
				</td>
				<th style="text-align: center;font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;"> COMPANY NAME</th>
				<th style="text-align: center;font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;">CORE CLIENT NAME OF ATTENDING</th>
				<td colspan="2" style="text-align: center;font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;"><b>PLACE</b><br> 
					<small>(Client name only, not including the associates - spouse & relatives)</small>
				</td>
				<th style="text-align: center;font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;">AMOUNT</th>
			</tr>
		@foreach($data['claim']['pid_details'][0]['details'] as $value)
			@if($value->sub_category == 'Entertainment')
				<tr>
					<td style="font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;font-size: 7px;">
						{{ \Carbon\Carbon::parse($value->date)->format('l, d F Y') }}
					</td>
					<!-- -->
					<td style="font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;font-size: 7px;">
						{{$value->entertainment}}
					</td style="font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;font-size: 7px;">
					<!---->
					<td style="font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;font-size: 7px;">
						{{$data['claim']['pid_details'][0]['name_project']->code_company}}
					</td>
					<td style="font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;font-size: 7px;">
						{!!$value->team_eksternal!!}
					</td>
					<td style="font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;font-size: 7px;">		{{$value->description}}
					</td>
					<td style="font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;font-size: 7px;">		{{$value->location}} 
					</td>
					<td style="font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;font-size: 7px;">
						Rp {{number_format($value->nominal,2)}}
					</td>
				</tr>
				<tr>
					<td style="font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;font-size: 7px;" colspan="6"></td>
					<th style="font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;font-size: 7px;">
						@foreach($data['claim']['sub_category'] as $value)
							@if($value->sub_category == 'Entertainment')
								Rp {{number_format($value['total_by_pid'][$data['claim']['pid_details'][0]['pid']],2)}}
							@endif 
						@endforeach
					</th>
				</tr>
			@endif
		@endforeach
		</table>
	</div>
	<div style="margin-bottom: 10px;">
		<table class="table-content-people-attending">
			<tr>
				<th style="text-align:left;padding-left:5px;padding-top:5px;border-top: solid 0.5px black;border-left: solid 0.5px black;" colspan="3">
					Number of People Attending For The Event
				</th>
				<th style="border-left: solid 0.5px black;"></th>
				<th style="border-left: solid 0.5px black;border-top: solid 0.5px black;border-right: solid 0.5px black;">
				</th>
			</tr>
			<tr>
				<td width="30%" style="padding: 5px;border-left: solid 0.5px black;border-bottom: solid 0.5px black;vertical-align: top">
					<table style="border: solid 0.5px black;" width="100%">
						<tr>
							<td style="padding-left:5px;height:100px;vertical-align:top;">
								Internal Employee Name<br>
								@foreach($data['claim']['pid_details'][0]['details'] as $value)
									@if($value->sub_category == 'Entertainment')
										{!!$value->team_internal!!}
									@endif
								@endforeach
							</td>
						</tr>
					</table>
				</td>
				<td width="30%" style="padding: 5px;border-bottom: solid 0.5px black;vertical-align: top">
					<table style="border: solid 0.5px black;" width="100%">
						<tr>
							<td style="padding-left:5px;height:100px;vertical-align:top;">
								Total Number of Associate Employee:<br><br><br><br><br><br>
								@foreach($data['claim']['pid_details'][0]['details'] as $value)
									@if($value->sub_category == 'Entertainment')
										@php
										    // Split the string by <br> and trim whitespace from each member
										    $memberArray = array_map('trim', explode('<br>', $value->team_internal));
										@endphp
									@endif
								@endforeach
								<b style="margin-left: 110px;">{{count($memberArray)}}</b>
							</td>
						</tr>
					</table>
				</td>
				<td width="30%" style="padding: 5px;border-bottom: solid 0.5px black;vertical-align: top">
					<table style="border: solid 0.5px black;" width="100%">
						<tr>
							<td style="padding-left:5px;height: 100px;vertical-align:top;">
								Total Number Client Associate:<br><br><br><br><br><br>
								@foreach($data['claim']['pid_details'][0]['details'] as $value)
									@if($value->sub_category == 'Entertainment')
										@php
										    // Split the string by <br> and trim whitespace from each member
										    $memberArrayClient = array_map('trim', explode('<br>', $value->team_eksternal));
										@endphp
									@endif
								@endforeach
								<b style="margin-left: 110px;">{{count($memberArrayClient)}}</b>
							</td>
						</tr>
					</table>
				</td> 
				<td width="5%" style="border-left: solid 0.5px black;"></td>
				<td width="30%" style="padding: 5px;border-left: solid 0.5px black;border-right: solid 0.5px black;border-bottom: solid 0.5px black;">
					<table style="border-collapse: collapse;" width="100%">
						<tr>
							<td style="text-align:justify;vertical-align:top;">
								I, being the person whose name and signature appears
								Internal Employee Name Total Number of Internal Total Number Client below certify that 100% of above claim is for company purpose only, not individual interest and the claim has not been claimed elsewhere
							</td>
						</tr>
						<tr>
							<td style="color:#3489cf;font-size: 12px;padding: 5px;position: relative;height: 50px;">	
								@if(count($data['show_ttd']) > 3)
									@if($data['show_ttd'][3]['position'] != $data['show_ttd'][0]['position'])
										<img src="{{$data['show_ttd'][3]['ttd']}}" style="width: 50px;height: 50px;left:0;top: 5;position: absolute;">
									@else
										<img src="{{$data['show_ttd'][3]['ttd']}}" style="width: 50px;height: 50px;left:0;top: 5;position: absolute;">
									@endif
								@else
									<img src="{{$data['show_ttd'][0]['ttd']}}" style="width: 50px;height: 50px;left:0;top: 5;position: absolute;">
								@endif

								<i style="position:absolute;right: 0;">
									{{\Carbon\Carbon::parse($data['claim']['date'])->format(' d - m')}}
								</i><br>
								<i style="position:absolute;right: 0;">{{\Carbon\Carbon::parse($data['claim']['date'])->format('Y')}}
								</i>
							</td>
						</tr>
						@if(count($data['show_ttd']) > 3)
							@if($data['show_ttd'][3]['position'] != $data['show_ttd'][0]['position'])
								<tr>
									<td>
										{{$data['show_ttd'][3]['name']}}<br>
										{{$data['show_ttd'][3]['position']}}
									</td>
								</tr>
							@else
								<tr>
									<td>
										{{$data['show_ttd'][3]['name']}}<br>
										{{$data['show_ttd'][3]['position']}}
									</td>
								</tr>
							@endif
						@else
							<tr>
								<td>
									{{$data['show_ttd'][0]['name']}}<br>
									{{$data['show_ttd'][0]['position']}}
								</td>
							</tr>
						@endif
					</table>
				</td>
			</tr>
		</table>
	</div>
	<div style="margin-bottom: 10px;">
		<table class="table-content-people-sign">
			<tr>
				<td width="30%" style="padding: 5px;border-right: solid 0.5px black;border-left: solid 0.5px black;border-top: solid 0.5px black;vertical-align: top;text-align:justify;position: relative;">
					I certify that I am the person whom claimant											
					report and that I have checked the content of											
					this claim and can confrim that the expenditure											
					has been incurred for appropriate company											
					purposes.	

					<br><br><br><br><br>
					@if(count($data['show_ttd']) > 3)
						@if($data['show_ttd'][3]['position'] != $data['show_ttd'][0]['position'])
							<img src="{{$data['show_ttd'][0]['ttd']}}" style="width: 50px;height: 50px;">
						@else
							<img src="{{$data['show_ttd'][1]['ttd']}}" style="width: 50px;height: 50px;">
						@endif
					@else
						<img src="{{$data['show_ttd'][1]['ttd']}}" style="width: 50px;height: 50px;">
					@endif
				</td>
				<td width="5%"></td>
				<td width="30%" style="padding: 5px;border-right: solid 0.5px black;border-left: solid 0.5px black;border-top: solid 0.5px black;vertical-align: top;text-align:center;">
					REASON FOR REJECTION/ ADDITIONAL NOTE TO BE	
					TOOK IN ACTION												
				</td>
				<td width="5%"></td>
				<td width="30%" style="padding: 5px;border-right: solid 0.5px black;border-left: solid 0.5px black;border-top: solid 0.5px black;vertical-align: top;text-align: justify;height: 100px;position: relative;">
					I, as the autorized person is AGREE/ NOT AGREE to pay											
					that amount above and believe it to be NOT/ IN line with											
					the company purposes		
					@if(count($data['show_ttd']) > 3)
						@if($data['show_ttd'][3]['position'] != $data['show_ttd'][0]['position'])
							<img src="{{$data['show_ttd'][1]['ttd']}}" style="width: 50px;height: 50px;left: 15;top: 40;position: absolute;">
							<img src="{{$data['show_ttd'][2]['ttd']}}" style="width: 50px;height: 50px;right: 20;top: 40;position: absolute;">	
						@else
							<img src="{{$data['show_ttd'][2]['ttd']}}" style="width: 50px;height: 50px;right: 100;top: 40;position: absolute;">	
						@endif
					@endif
				</td> 
			</tr>
			<tr>
				<td width="30%" style="border-bottom: solid 0.5px black;border-right: solid 0.5px black;border-left: solid 0.5px black;padding: 5px;">
					@if(count($data['show_ttd']) > 3)
						@if($data['show_ttd'][3]['position'] != $data['show_ttd'][0]['position'])
							{{$data['show_ttd'][0]['name']}}<br>
							{{$data['show_ttd'][0]['position']}}
						@else
							{{$data['show_ttd'][1]['name']}}<br>
							{{$data['show_ttd'][1]['position']}}
						@endif
					@else
						{{$data['show_ttd'][1]['name']}}<br>
						{{$data['show_ttd'][1]['position']}}
					@endif
				</td>
				<td width="5%"></td>
				<td width="30%" style="border-bottom: solid 0.5px black;border-right: solid 0.5px black;border-left: solid 0.5px black;padding: 5px;">
				</td>
				<td width="5%"></td>
				<td width="30%" style="border-bottom: solid 0.5px black;border-right: solid 0.5px black;border-left: solid 0.5px black;padding: 5px;position: relative;">	
					@if(count($data['show_ttd']) > 3)
						@if($data['show_ttd'][3]['position'] != $data['show_ttd'][0]['position'])
							<span style="position: absolute;left:5">{{$data['show_ttd'][1]['name']}}<br>{{$data['show_ttd'][1]['position']}}</span>
							<span style="position: absolute;right:15;">{{$data['show_ttd'][2]['name']}}<br>{{$data['show_ttd'][2]['position']}}</span>
						@else
							<span style="position: absolute;right:93;">{{$data['show_ttd'][2]['name']}}<br>{{$data['show_ttd'][2]['position']}}</span>
						@endif
					@endif
				</td>
			</tr>
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
