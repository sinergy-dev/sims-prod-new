<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <style type="text/css">
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 0px solid grey;
            padding-top: 14px;
        }

        table, th {
            padding-left: 15px;
        }

        #bg_ket {
            border-radius: 10px;
        }

        #txt_center {
            text-align: center;
        }

        .money:before{
            content:"Rp";
        }

        center > strong::before{
            content: "@";
        }

        .button {
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            background-color: #7868e6;
            border-radius: 4px;
        }

        /*.centered{
            position: absolute;
              top: 50%;
              left: 50%;
              transform: translate(-50%, -40%);
        }*/
    </style>
</head>
<body style="display:block;width:600px;margin-left:auto;margin-right:auto;color: #000000">
<div style="line-height: 1.5em">
    <img src="{{ asset('image/sims_sangar.png')}}" style="width: 30%; height: 30%">
</div>
<div style="line-height: 1.5em;padding-left: 13px;">
    <div style="font-family: 'Montserrat','Helvetica Neue',Helvetica,Arial,sans-serif;">
        <p style="font-size: 20px">
            @if($status == 'Proof of Exam')
                <b>Dear, Tim HCM</b>
            @else
                <b>Hi, {{$receiver->name}}</b>
            @endif
        </p>
        <p style="font-size: 16px">
            @if($status == 'NEW')
                {{\Illuminate\Support\Facades\Auth::user()->name}} telah membuat request certification baru, dengan detail sebagai berikut.
            @elseif($status == 'CIRCULAR')
                Request sudah mulai disirkulasi untuk diperiksa dan disetujui. Kepada masing-masing approver dimohon untuk segera melakukan pemeriksaan dan penyetujuan dari Request yang diajukan.
            @elseif($status == 'REJECTED')
                Untuk Request anda sudah terverifikasi dan ada beberapa perbaikan yang perlu dilakukan sebelum peroses dapat dilanjutkan. Untuk perbaikan bisa dilihat pada note perbaikan dibawah ini.
            @elseif($status == 'EDIT')
                {{\Illuminate\Support\Facades\Auth::user()->name}} baru saja mengubah request certification, dengan detail sebagai berikut.
            @elseif($status == 'APPROVED')
                Request yang anda ajukan telah di Approve, dengan detail sebagai berikut.
            @elseif($status == 'Proof of Exam')
                {{\Illuminate\Support\Facades\Auth::user()->name}} telah upload bukti sertifikasi, dengan detail sebagai berikut.
            @endif
        </p>
        @if($status == 'REJECTED')
            <div id="bg_ket" style="background-color: #ececec; padding: 10px">
                <b><i>Rejected By {{Auth::User()->name}}</i></b>
                <b><i>Note Perbaikan</i></b>
                <table style="font-size: 12px" class="tableLead">
                    <tr>
                        <td>{!! str_replace("\n","<br>",$notes) !!}</td>
                    </tr>
                </table>
            </div>
            <br>
        @endif
        <div id="bg_ket" style="background-color: #ececec; padding: 10px">
            <center><b></b></center>
            <table style="text-align: left;margin: 5px; font-size: 16px" class="tableLead">
                @if($status == 'Proof of Exam')
                    <tr>
                        <th class="tb_ket">Participant Name</th>
                        <th> : </th>
                        <td>{{$detail->participant_name}}</td>
                    </tr>
                    <tr>
                        <th class="tb_ket">Exam Name</th>
                        <th> : </th>
                        <td>{{$detail->exam_name}}</td>
                    </tr>
                    <tr>
                        <th class="tb_ket">Exam Level</th>
                        <th> : </th>
                        <td>{{$detail->level}}</td>
                    </tr>
                    <tr>
                        <th class="tb_ket">Exam Date</th>
                        <th> : </th>
                        <td>{{$detail->exam_date}}</td>
                    </tr>
                    <tr>
                        <th class="tb_ket">Status</th>
                        <th> : </th>
                        <td>{{$detail->status_exam}}</td>
                    </tr>
                    @if($detail->status_exam == 'Pass')
                        <tr>
                            <th>Certificate Expired</th>
                            <th> : </th>
                            <td>{{$detail->expired_date}}</td>
                        </tr>
                    @endif
                @else
                    <tr>
                        <th class="tb_ket">Exam Purpose</th>
                        <th> : </th>
                        <td>{{$detail->exam_purpose}}</td>
                    </tr>
                    <tr>
                        <th>Vendor</th>
                        <th> : </th>
                        <td>{{$detail->vendor}}</td>
                    </tr>
                    @if($detail->lead_id != null)
                    <tr>
                        <th>Lead ID</th>
                        <th> : </th>
                        <td>{{$detail->lead_id}}</td>
                    </tr>
                    @endif
                    @if($detail->pid != null)
                    <tr>
                        <th>PID</th>
                        <th> : </th>
                        <td>{{$detail->pid}}</td>
                    </tr>
                    @endif
                    @if($detail->project_title != null)
                    <tr>
                        <th>Project Title</th>
                        <th> : </th>
                        <td>{{$detail->project_title}}</td>
                    </tr>
                    @endif
                @endif
            </table>
        </div>
        <p style="font-size: 16px">
            <b>Untuk detail dari request dapat dilihat dengan mengunjungi halaman dibawah ini</b>
        </p>
        @if($status == 'Proof of Exam')
            <center><a href="{{url('/certification_list/detail/'.$detail->certification_list_id)}}" target="_blank"><button class="button"> Detail Request Certification </button></a></center>
        @else
            <center><a href="{{url('/certification_list/detail/'.$detail->id)}}" target="_blank"><button class="button"> Detail Request Certification </button></a></center>
        @endif
        <p style="font-size: 16px">
            Mohon periksa kembali jika ada kesalahan atau pertanyaan silahkan hubungi Team Developer (Ext: 384) atau email ke development@sinergy.co.id
        </p>
        <p style="font-size: 16px">
            Best Regard,
        </p><br>
        <p style="font-size: 16px">
            Application Development
        </p>
    </div>
</div>
</body>
<footer style="display:block;width:600px;margin-left:auto;margin-right:auto;">
    <div style="background-color: #7868e6; padding: 20px; color: #ffffff; font-size: 12px; font-family: 'Montserrat','Helvetica Neue',Helvetica,Arial,sans-serif;">
        <p>
        <center>PT. Sinergy Informasi Pratama</center>
        </p>
        <p>
        <center>Jakarta International Tower, Jl. Letjen S. Parman Nomor 1AA, Kemanggisan - Pal Merah, Jakarta 11480 - Indonesia</center>
        </p>
        <p>
        <center><i class="fa fa-phone"></i>021 - 58355599</center>
        </p>
    </div>
</footer>
</html>