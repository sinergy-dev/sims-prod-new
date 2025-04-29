<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exam / Training Application Form</title>
    <style>
        body {
            font-family: Lucida Sans Unicode, sans-serif;
            margin: 0;
            padding: 0;
        }
        .divider {
            border-top: 2px solid #000;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .divider h4 {
            margin: 0;
            text-align: center;
            font-family: Lucida Sans Unicode, sans-serif;
        }
        .table-container {
            margin-top: 0;
            margin-bottom: 10px;
            padding: 0;
        }
        .table-container table {
            border-collapse: collapse;
        }
        .table-container table, .table-container td {
            border: 1px solid #000;
            padding: 1px;
        }
        .table-container th {
            border: 1px solid #000;
            padding: 1px;
            text-align: center;
        }
        .text {
            font-size: 8px;
            margin: 0;
            padding: 0;
        }
        .text-10 {
            font-size: 12px !important;
            margin: 0;
            padding: 0;
        }
        .text-10 * {
            font-size: 12px !important;
        }

        .text-8 {
            font-size: 8px !important;
            margin: 0;
            padding: 0;
            vertical-align: middle;
        }
        .text-8 * {
            font-size: 8px !important;
            vertical-align: middle;
        }

        .pdf-container {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin: 0;
            padding: 0;
        }

        .column {
            display: inline-block;
            width: 30%;
            vertical-align: top;
            padding: 0;
        }

        .column-6 {
            display: inline-block;
            width: 50%;
            vertical-align: top;
            padding: 0;
        }

        .column-12 {
            display: inline-block;
            width: 100%;
            vertical-align: top;
            padding: 0px;
        }

        .column img {
            max-width: 80%;
            height: auto;
            display: block;
            margin-left: 270px;
            margin-top: -10px;
        }

        .column-12 img {
            max-width: 10%;
            height: auto;
            display: block;
            margin-left: 270px;
            margin-top: -10px;
        }
        .table-content-sub {
            background-color: #bbbbbb;
            text-align: left;
            font-size: 10px;
        }

        .table-content-detail {
            font-size: 10px;
        }

        .signature-container {
            display: flex;
            justify-content: space-between;
            text-align: center;
            margin-top: 40px;
        }

        .signature-box {
            width: 30%;
        }

        .footer {
            position: absolute;
            bottom: 10px;
            left: 20px;
            font-size: 10px;
            color: #666;
        }

    </style>

</head>
<body>
<div>
    <img src="{{ public_path('img/logo-sip-hd.png') }}" alt="Logo SIP" style="max-width: 15%; height: auto; margin-left: 600px;">
</div>
<br>
<div>
    <h4 style="margin: 0; text-align: center; ">Exam / Training Application Form</h4>
</div>
<br><br>
<div class="column-12">
    <table>
        <tr>
            <td style="width: 15%;"><p class="text-10"><strong>Exam Purpose</strong></p></td>
            <td class="text-10" style="width: 1%;">:</td>
            <td style="width: 84%;"> <p class="text-10">{{$exam->exam_purpose}}</p></td>
        </tr>
        <tr>
            <td style="width: 15%;"><p class="text-10"><strong>Project Phase</strong></p></td>
            <td class="text-10" style="width: 1%;">:</td>
            <td style="width: 84%;"> <p class="text-10">{{$exam->project_phase ?: '-'}}</p></td>
        </tr>
        <tr>
            <td><p class="text-10"><strong>Vendor</strong></p></td>
            <td class="text-10">:</td>
            <td> <p class="text-10">{{$exam->vendor}}</p></td>
        </tr>

        @if($exam->lead_id != null)
            <tr>
                <td><p class="text-10"><strong>Lead ID</strong></p></td>
                <td class="text-10">:</td>
                <td> <p class="text-10">{{$exam->lead_id}}</p></td>
            </tr>
        @endif
        <tr>
            <td><p class="text-10"><strong>PID</strong></p></td>
            <td class="text-10">:</td>
            <td> <p class="text-10">{{$exam->pid ?: '-'}}</p></td>
        </tr>

            <tr>
                <td><p class="text-10"><strong>Project Title</strong></p></td>
                <td class="text-10">:</td>
                <td> <p class="text-10">{{$exam->project_title ?: '-'}}</p></td>
            </tr>
    </table>
{{--    <p class="text-10"><strong>Exam Purpose</strong></p>--}}
</div>
<br>
<br>
<div class="table-container" >
    <table style="border: 2px;">
        <tr>
            <th class="table-content-sub" style="width: 40px; border-bottom: 2px;">No</th>
            <th class="table-content-sub" style="width: 130px; border-bottom: 2px;">Participant Name</th>
            <th class="table-content-sub" style="width: 130px; border-bottom: 2px;">Exam Name</th>
            <th class="table-content-sub" style="width: 70px; border-bottom: 2px;">Exam Code</th>
            <th class="table-content-sub" style="width: 70px; border-bottom: 2px;">Exam Deadline</th>
            <th class="table-content-sub" style="width: 80px;border-bottom: 2px;">Level</th>
            <th class="table-content-sub" style="width: 150px;border-bottom: 2px;">Departement</th>
        </tr>
        @foreach($detail as $index => $detail)
            <tr style="height: 4px;">
                <td class="table-content-detail">
                    <center>{{$index+1}}</center>
                </td>
                <td class="table-content-detail">
                    {{$detail->participant_name}}
                </td>
                <td class="table-content-detail">
                    {{$detail->exam_name}}
                </td>
                <td class="table-content-detail">
                   <center>{{$detail->exam_code}}</center>
                </td>
                <td class="table-content-detail">
                    <center>{{$detail->exam_deadline}}</center>
                </td>
                <td class="table-content-detail">
                    {{$detail->level}}
                </td>
                <td class="table-content-detail">
                    {{$detail->departement}}
                </td>
            </tr>
        @endforeach

    </table>
</div>
<br><br><br>
<table style="width: 100%; text-align: center;">
    <tr>
        <td>
            <p class="text-10">Requested By,</p>
            <img src="{{$user->ttd}}" style="width: 80px; height: auto; margin-top: 10px;">
            <p class="text-10"><u><strong> {{ $user->name }}</strong></u></p>
            <p class="text-10"><i>{{ $role->name }}</i></p>
        </td>
        @if(!\Illuminate\Support\Str::of($role->name)->lower()->startsWith('vp'))
            <td>
                <p class="text-10">Acknowledge By,</p>
                <img src="{{$acknowledge->ttd}}" style="width: 80px; height: auto; margin-top: 10px;">
                <p class="text-10"><u><strong>{{$acknowledge->name}}</strong></u></p>
                <p class="text-10"><i>{{$roleAcknowledge}}</i></p>
            </td>
        @endif
        <td>
            <p class="text-10">Approved By,</p>
            <img src="{{$approved->ttd}}" style="width: 80px; height: auto; margin-top: 10px;">
            <p class="text-10"><u><strong>{{$approved->name}} </strong></u></p>
            <p class="text-10"><i>{{$roleApproved}}</i></p>
        </td>
    </tr>
</table>
<div class="footer" style="font-size: 10px; color: #666; text-align: left; line-height: 1.4;">
    <p style="margin: 0;">PT. Sinergy Informasi Pratama</p>
    <p style="margin: 0;">Jakarta International Tower</p>
    <p style="margin: 0;">Jl. Letjen S. Parman Nomor 1AA,</p>
    <p style="margin: 0;">Kemanggisan - Pal Merah, Jakarta 11480</p>
    <p style="margin: 0;">Telp: 021 - 58355599</p>
    <p style="margin: 0;">Email: info@sinergy.co.id</p>
</div>

</body>
</html>