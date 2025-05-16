<div style="color: #555;font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;">
	<p id="emailCancelHeader" style="margin: 0 0 10px;box-sizing: border-box;font-size: 14px;line-height: 1.42857143;color: #555;font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;font-weight: 400;">
		
	</p>
	<table style="width: 401px;">
		<tr style="text-align: right;">
			<td style=" width:120px">
				<h6 style="font-size: 24px;"><b><i>Cancel Ticket</i></b></h6>
			</td>
			<td >
				<img src="{{asset('/image/header-ticketing.jpg')}}">
			</td>
		</tr>
	</table>
	<br>
	<table class="table table2" style="width: 400px;max-width: 100%;margin-bottom: 20px;border-spacing: 0;border-collapse: collapse;line-height: 1.42857143;vertical-align: top;">
		<tr >
			<th style=" border:1px solid #fff; padding: 3px; width:120px;color: #fff;background-color: #337ab7;text-align: left;" class="bg-primary">Ticket ID</th>
			<td style=" border:1px solid; padding: 3px;" class="holderCancelID"></td>
		</tr>
		<tr>
			<th style=" border:1px solid #fff; padding: 3px; width:120px;color: #fff;background-color: #337ab7;text-align: left;" class="bg-primary">Refrence</th>
			<td style=" border:1px solid; padding: 3px;" class="holderCancelRefrence"></td>
		</tr>
		<tr>
			<th style=" border:1px solid #fff;  padding: 3px;width:120px;color: #fff;background-color: #337ab7;text-align: left;" class="bg-primary">Customer</th>
			<td  style=" border:1px solid; padding: 3px;" class="holderCancelCustomer"></td>
		</tr>
		<tr>
			<th style=" border:1px solid #fff;  padding: 3px;width:120px;color: #fff;background-color: #337ab7;text-align: left;" class="bg-primary">PIC</th>
			<td  style=" border:1px solid; padding: 3px;" class="holderCancelPIC"></td>
		</tr>
		<tr>
			<th style=" border:1px solid #fff;  padding: 3px;width:120px;color: #fff;background-color: #337ab7;text-align: left;" class="bg-primary">Contact</th>
			<td  style=" border:1px solid; padding: 3px;" class="holderCancelContact"></td>
		</tr>
		<tr>
			<th style=" border:1px solid #fff;  padding: 3px;width:120px;color: #fff;background-color: #337ab7;text-align: left;" class="bg-primary">Problem</th>
			<td  style=" border:1px solid; padding: 3px;" class="holderCancelProblem"></td>
		</tr>
		<tr>
			<th style=" border:1px solid #fff;  padding: 3px;width:120px;color: #fff;background-color: #337ab7;text-align: left;" class="bg-primary">Location</th>
			<td  style=" border:1px solid; padding: 3px;" class="holderCancelLocation"></td>
		</tr>
		<tr style="display: none" class="holderCancelIDATM2">
			<th style=" border:1px solid #fff;  padding: 3px;width:120px;color: #fff;background-color: #337ab7;text-align: left;" class="bg-primary">ID ATM</th>
			<td  style=" border:1px solid; padding: 3px;" class="holderCancelIDATM"></td>
		</tr>
		<tr>
			<th style=" border:1px solid #fff;  padding: 3px;width:120px;color: #fff;background-color: #337ab7;text-align: left;" class="bg-primary">Engineer</th>
			<td  style=" border:1px solid; padding: 3px;" class="holderCancelEngineer"></td>
		</tr>
		<tr>
			<th style=" border:1px solid #fff;  padding: 3px;width:120px;color: #fff;background-color: #337ab7;text-align: left;" class="bg-primary">Serial number</th>
			<td  style=" border:1px solid; padding: 3px;" class="holderCancelSerial"></td>
		</tr>
		<tr>
			<th style=" border:1px solid #fff;  padding: 3px;width:120px;color: #fff;background-color: #337ab7;text-align: left;" class="bg-primary">Severity</th>
			<td  style=" border:1px solid; padding: 3px;" class="holderCancelSeverity"></td>
		</tr>
		<tr style="display: none" class="holderNumberTicket2">
			<th style=" border:1px solid #fff;  padding: 3px;width:120px;color: #fff;background-color: #337ab7;text-align: left;" class="bg-primary">Ticket Wincore</th>
			<td  style=" border:1px solid; padding: 3px;" class="holderNumberTicket"></td>
		</tr>
		<!-- <tr>
			<th style=" border:1px solid #fff;  padding: 3px;width:120px;color: #fff;background-color: #337ab7;text-align: left;"" class="bg-primary">Counter Measure</th>
			<td  style=" border:1px solid; padding: 3px;" class="holderCancelCounter"></td>
		</tr>
		<tr>
			<th style=" border:1px solid #fff;  padding: 3px;width:120px;color: #fff;background-color: #337ab7;text-align: left;"" class="bg-primary">Root Cause</th>
			<td  style=" border:1px solid; padding: 3px;" class="holderCancelRoot"></td>
		</tr> -->
		<tr>
			<th style=" border:1px solid #fff;  padding: 3px;width:120px;color: #fff;background-color: #337ab7;text-align: left;" class="bg-primary">Open At</th>
			<td  style=" border:1px solid; padding: 3px;" class="holderCancelDate"></td>
		</tr>
		<tr>
			<th style=" border:1px solid #fff;  padding: 3px;width:120px;color: #fff;background-color: #337ab7;text-align: left;" class="bg-warning">Status</th>
			<td rowspan=2 style=" border:1px solid; padding: 3px; text-align: center; background-color: #555299;border-bottom: none;color:#FFFFFF;" class="holderCancelStatus text-center bg-purple-active"></td>
		</tr>
		<tr>
			<th style=" border:1px solid #fff; padding: 3px; width:120px;color: #fff;background-color: #337ab7;text-align: left;" class="bg-warning">Waktu</th>
			<!-- <td style=" border:1px solid; padding: 3px; text-align: center; background-color: #555299; border-top: none; color:#FFFFFF;" class="holderCancelWaktu text-center bg-purple-active" ></td> -->
		</tr>
		<tr>
			<th style=" border:1px solid #fff; padding: 3px; width:120px;color: #fff;background-color: #337ab7;text-align: left;" class="bg-primary">Note</th>
			<td style=" border:1px solid; padding: 3px;" class="holderCancelNote"></td>
		</tr>
	</table>
	<br>
	<p>
		Thanks<br>
		Best Regard,
	</p>
	<h6 style="color: #3c8dbc !important;margin-bottom: 0px" class="text-light-blue" >{{Auth::user()->name}}</h6>
	<h6 style="color: #f39c12 !important;margin-top: 0px" class="text-yellow" ><i>{{Auth::user()->roles()->first()->name}}</i></h6>
	<p>
		----------------------------------------<br>
		PT. Sinergy Informasi Pratama (SIP)<br>
		| Jakarta International Tower 15nd Floor |<br>
		| Jl. Letjen S. Parman Nomor 1AA | Kemanggisan |<br>
		| Pal Merah | Jakarta 11480 – Indonesia |<br>
		| Mobile | 6285810557307 |<br>
		| Phone | 021 - 50865 777 |<br>
		----------------------------------------<br>
	</p>
</div>
