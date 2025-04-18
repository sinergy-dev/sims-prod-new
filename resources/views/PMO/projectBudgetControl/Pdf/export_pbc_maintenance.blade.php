<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style type="text/css">
    body{
      font-family: "Helvetica Neue", Arial, sans-serif;
      font-size: 9px;
    }

    .page {
    page-break-after:always;
    position: relative;
    }

    table{
      border-spacing: 0;
      width: 100%;
      padding-left: 20px;
      border-collapse: collapse;
      /*border: 0.5px solid #CCC;*/
      border: none;
      padding-top: 10px;
      font-family: "Helvetica Neue", Arial, sans-serif;
    }

    img {
      width: 40px;
      height: 40px;
      border-radius: 100%;
    }

    .center {
      text-align: center;
    }

    .footer {
      position: fixed;
      padding: 10px 10px 0px 10px;
      bottom: 0;
      width: 100%;
    }

    .left {
        flex: 1; /* Takes up 1/2 of the container */
        padding-left: 10px;
    }

    .right {
        flex: 1; /* Takes up 1/2 of the container */
        padding-left: 10px;
        margin-left: 150px;
    }

    .table-maintenance-header th{
      background-color: red;
      color: white;
    }

    .table-maintenance-body th{
      background-color: red;
      color: white;
    }

    .table-maintenance-body td:nth-child(1){
      text-align: center;
      vertical-align: middle;
    }

    .border td{
      border: 0.5px solid black;
    }

    .border th{
      border: 0.5px solid black;
    }

    th[colspan="3"]{
      border: none;
      background-color: white;
    }

    .money{
      text-align: right!important;
    }
  </style>
  <link rel="stylesheet" href="">
  <title>Project Budget Control - Maintenance Service</title>
</head>
<body>
  <img src="img/header-sbe.png" style="height:15px;width: 100%;" />

  <h6 style="text-align: center;">{{$data[0]['name_project']}}</h6>
  <h6 style="text-align: center;">{{$data[0]['customer_name']}}</h6>

  <br>

  @foreach($data[0]['sbe'] as $key => $dataSbe)
    <table class="table-maintenance-header">
      <tr>
        <th colspan="7">{{$dataSbe->project_type}} Project</th>
      </tr>
      <tr>
        <td colspan="7" style="height: 10px;"></td>
      </tr>
      <tr>
        <td>Project ID</td>
        <td width="1%">:</td>
        <td>{{$data[0]['id_project']}}</td>
      </tr>
      <tr>
        <td>Project Owner</td>
        <td width="1%">:</td>
        <td>{{$data[0]['owner']}}</td>
      </tr>
      <tr>
        <td colspan="7" style="height: 10px;"></td>
      </tr>
    </table>
      <!-- loop items-->
    <table class="table-maintenance-body">
      @php
        $alphabets = range('A', 'Z'); // Generate alphabet array
        $number = range('1', '100');
      @endphp
      @foreach($dataSbe['items_sbe']['detail_sbe'] as $key_sbe => $detail_sbe)
        <tr><td style="text-align:left;" colspan="4"><b>{{$alphabets[$loop->index]}}. {{$key_sbe}}</b></td></tr>
        <tr class="border">
          <th style="width:2%">No</th>
          <th>Items</th>
          <th>Detail Items</th>
          <th>Plan Mandays</th>
          <th>Actual Mandays</th>
          <th>Plan SBE</th>
          <th>Actual SBE</th>
        </tr>
        @foreach($detail_sbe as $key_detail => $detail_item)
          @if($key_detail == 0)
            <tr class="border">
              <td>{{$number[$loop->index]}}</td>
              <td rowspan="{{count($detail_sbe)}}" style="text-align:center;vertical-align: middle;">{{$detail_item->item}}</td>
              <td style="vertical-align: top;">{{$detail_item->detail_item}}</td>
              <td style="vertical-align: top;text-align: center;">{{$detail_item->plan_mandays}}</td>
              <td style="vertical-align: top;text-align: center;">{{$detail_item->actual_mandays}}</td>
              <td style="position: relative;">
                <span style="position: absolute; left: 2;">IDR</span>
                <span style="position: absolute; right: 2;">{{number_format($detail_item->plan_sbe,2)}}</span>
              </td>
              <td style="position: relative;">
                <span style="position: absolute; left: 2;">IDR</span>
                <span style="position: absolute; right: 2;">{{number_format($detail_item->actual_sbe,2)}}</span>
              </td>
            </tr>
          @else
            <tr class="border">
              <td>{{$number[$loop->index]}}</td>
              <td style="vertical-align: top;">{{$detail_item->detail_item}}</td>
              <td style="vertical-align: top;text-align: center;">{{$detail_item->plan_mandays}}</td>
              <td style="vertical-align: top;text-align: center;">{{$detail_item->actual_mandays}}</td>
              <td style="position: relative;">
                <span style="position: absolute; left: 2;">IDR</span>
                <span style="position: absolute; right: 2;">{{number_format($detail_item->plan_sbe,2)}}</span>
              </td>
              <td style="position: relative;">
                <span style="position: absolute; left: 2;">IDR</span>
                <span style="position: absolute; right: 2;">{{number_format($detail_item->actual_sbe,2)}}</span>
              </td>
            </tr>
          @endif      
        @endforeach
        @foreach($dataSbe['items_sbe']['grouped_sums'] as $key_item => $grouped_item)
          @if($key_sbe == $key_item)
            <tr>
              <th colspan="5" style="border:solid black 0.5px;">Total Cost</th>
              <th style="position: relative;border:solid black 0.5px;">
                  <span style="position: absolute; left: 2;">IDR</span>
                  <span style="position: absolute; right: 2;vertical-align: middle;">{{number_format($grouped_item['total_plan_sbe'],2)}}</span>
                </th>
                <th style="position: relative;border:solid black 0.5px;">
                  <span style="position: absolute; left: 2;">IDR</span>
                  <span style="position: absolute; right: 2;">{{number_format($grouped_item['total_actual_sbe'],2)}}</span>
                </th>
            </tr> 
          @endif
        @endforeach
        <tr>
          <td colspan="7" style="height:20px"></td>
        </tr>
      @endforeach  
      <!--items-->
      <tr >
        <td colspan="7" style="height:40px"></td>
      </tr>
      <tr class="border">
        <th colspan="3"></th>
        <th colspan="2">Function</th>
        <th>Plan Total SBE</th>
        <th>Actual Total SBE</th>
      </tr>
      @foreach($dataSbe['items_sbe']['grouped_sums'] as $key_item => $grouped_item)
        <tr class="border">
          <th colspan="3"></th>
          <td colspan="2">{{$alphabets[$loop->index]}}. {{$key_item}}</td>
          <td style="position: relative;">
            <span style="position: absolute; left: 2;">IDR</span>
            <span style="position: absolute; right: 2;">{{number_format($grouped_item['total_plan_sbe'],2)}}</span>
          </td>
          <td style="position: relative;">
            <span style="position: absolute; left: 2;">IDR</span>
            <span style="position: absolute; right: 2;">{{number_format($grouped_item['total_actual_sbe'],2)}}</span>
          </td>
        </tr>
      @endforeach
      <tr class="border">
        <th colspan="3"></th>
        <td colspan="2" style="text-align:center;"><b>Total Implementation Budget</b></td>
        <td style="position: relative;">
          <b>
            <span style="position: absolute; left: 2;">IDR</span>
            <span style="position: absolute; right: 2;">{{number_format($dataSbe['items_sbe']['function_cost_plan_sbe'],2)}}</span>
          </b>
        </td>
        <td style="position: relative;">
          <b>
            <span style="position: absolute; left: 2;">IDR</span>
            <span style="position: absolute; right: 2;">{{number_format($dataSbe['items_sbe']['function_cost_actual_sbe'],2)}}</span>
          </b>
        </td>
      </tr>
    </table>
  @endforeach
</body>
</html>