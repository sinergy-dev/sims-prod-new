<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quotation</title>
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
            margin-top: 0; /* Added space at the top */
            margin-bottom: 10px;
            padding: 0;
        }
        .table-container table {
            border-collapse: collapse;
            table-layout: auto;
            width: 100%;
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
            font-size: 9px !important;
            margin: 0;
            padding: 0;
        }
        .text-10 * {
            font-size: 9px !important;
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
            font-size: 8px;
        }

        .table-content-det {
            font-size: 8px;
        }
    </style>

</head>
<body>
<div style="margin-bottom: -40px;">
    <p class="text-10">PT. Sinergy Informasi Pratama</p>
    <p class="text-10">Jakarta International Tower</p>
    <p class="text-10">Jl. Letjen S. Parman Nomor 1AA</p>
    <p class="text-10">Kemanggisan - Pal Merah</p>
    <p class="text-10" >Jakarta 11480 - Indonesia</p>
    <img src="{{ public_path('img/logo-sip-hd.png') }}" alt="Logo SIP" style="max-width: 20%; height: auto; margin-top: -70px; margin-left: 280px;">
    <p class="text-10" style="margin-left: 550px; margin-top: -50px; margin-bottom: -20px;">
        Phone <span style=""> : </span> <span> 62 21 50865 777 </span>
        <br>
        Email  &nbsp;<span> : </span>  <span> sales@sinergy.co.id </span>
    </p>
</div>
<br>
<div  class="divider">
    <h4 style="margin: 0; text-align: center; ">QUOTATION</h4>
</div>
<div class="" style="margin: 0; padding: 0;">
    <table style="width: 100%; border-collapse: collapse; border: 1px solid;" >
        <tr>
            <td colspan="2" style="width: 500px;">
                <table style="font-size: 9px; width: 100%; border: none; line-height: 1.2;">
                    <tr>
                        <td style="width: 70px; padding: 0 2px;">Kepada</td>
                        <td style="padding: 0 2px;">: <b>{{ $config->to }}</b></td>
                    </tr>
                    @if($config->building != null)
                        <tr>
                            <td style="padding: 0 2px;">Alamat</td>
                            <td style="padding: 0 2px;">: {{ $config->building }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0 2px;"></td>
                            <td style="padding: 0 2px 0 10px;">{{ $config->street }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0 2px;"></td>
                            <td style="padding: 0 2px 0 10px;">{{ $config->city }}</td>
                        </tr>
                    @else
                        <tr>
                            <td style="padding: 0 2px;">Alamat</td>
                            <td style="padding: 0 2px 0 10px;">: {{ $config->street }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0 2px;"></td>
                            <td style="padding: 0 2px 0 10px;">{{ $config->city }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td style="padding: 0 2px;">Telp</td>
                        <td style="padding: 0 2px;">: {{ $config->no_telp }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 0 2px;">Email</td>
                        <td style="padding: 0 2px;">: {{ $config->email }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 0 2px;">PIC</td>
                        <td style="padding: 0 2px;">: {{ $config->attention }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 0 2px;">Dari</td>
                        <td style="padding: 0 2px;">: {{ $config->from }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 0 2px;">Subjek</td>
                        <td style="padding: 0 2px;">: {{ $config->title }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 200px; border: 1px solid; vertical-align: top; line-height: 1.2;">
                <table style="font-size: 9px; width: 100%; border: none;">
                    <tr>
                        <td>Tanggal</td>
                        <td>: {{\Carbon\Carbon::parse($config->date)->format('d F Y')}}</td>
                    </tr>
                    <tr>
                        <td>Ref</td>
                        <td>: {{$config->quote_number}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<br>
<div class="column-12" style="margin-bottom: 5px; margin-left: 1px;">
    <p class="text-10">Dengan Hormat,</p>
    <p class="text-10">Bersama ini kami sampaikan penawaran harga, sebagaimana terlampir:</p>
</div>
<div class="table-container" >
    <table style="border: 2px;">
        @php
            $isPriceList = false;
            $colspan = 7;

            foreach ($product as $p){
                if ((float)$p->price_list > 0 && $p->price_list != null){
                    $isPriceList = true;
                    $colspan += 2;
                    break;
                }
            }
            $header1 = null;
            $header2 = null;
            $header3 = null;
            $header4 = null;
            $header5 = null;

            foreach ($product as $prod){
                if ($prod->additional_column_1 != null && $prod->additional_column_1 != ''){
                    $colspan += 1;
                    $parts = explode('-', $prod->additional_column_1);
                    $header1 = trim($parts[0]);
                }
                if ($prod->additional_column_2 != null && $prod->additional_column_2 != ''){
                    $colspan += 1;
                    $parts = explode('-', $prod->additional_column_2);
                    $header2 = trim($parts[0]);
                }
                if ($prod->additional_column_3 != null && $prod->additional_column_3 != ''){
                    $colspan += 1;
                    $parts = explode('-', $prod->additional_column_3);
                    $header3 = trim($parts[0]);
                }
                if ($prod->additional_column_4 != null && $prod->additional_column_4 != ''){
                    $colspan += 1;
                    $parts = explode('-', $prod->additional_column_4);
                    $header4 = trim($parts[0]);
                }
                if ($prod->additional_column_5 != null && $prod->additional_column_5 != ''){
                    $colspan += 1;
                    $parts = explode('-', $prod->additional_column_5);
                    $header5 = trim($parts[0]);
                }
                break;
            }

        @endphp
        <tr>
            @if($isPriceList)
                <th class="table-content-sub" style="width: 20px; border-bottom: 2px;">No</th>
                <th class="table-content-sub" style="width: 70px; border-bottom: 2px;">Produk</th>
                <th class="table-content-sub" style="width: 80px; border-bottom: 2px;">Deskripsi</th>
                @if($header1 != null)
                    <th class="table-content-sub" style=" border-bottom: 2px;">{{$header1}}</th>
                @endif
                @if($header2 != null)
                    <th class="table-content-sub" style=" border-bottom: 2px;">{{$header2}}</th>
                @endif
                @if($header3 != null)
                    <th class="table-content-sub" style=" border-bottom: 2px;">{{$header3}}</th>
                @endif
                @if($header4 != null)
                    <th class="table-content-sub" style=" border-bottom: 2px;">{{$header4}}</th>
                @endif
                @if($header5 != null)
                    <th class="table-content-sub" style=" border-bottom: 2px;">{{$header5}}</th>
                @endif
                <th class="table-content-sub" style="width: 50px; border-bottom: 2px;">Jangka Waktu</th>
                <th colspan="2" class="table-content-sub" style="width: 20px; border-bottom: 2px;">Jumlah</th>
                <th class="table-content-sub" style="width: 75px; border-bottom: 2px;">Harga Jual</th>
                <th class="table-content-sub" style="width: 75px;border-bottom: 2px;">Total Harga Jual</th>
                <th class="table-content-sub" style="width: 75px; border-bottom: 2px;">Harga</th>
                <th class="table-content-sub" style="width: 100px;border-bottom: 2px;">Total Harga</th>
            @else
                <th class="table-content-sub" style="width: 20px; border-bottom: 2px;">No</th>
                <th class="table-content-sub" style="width: 100px; border-bottom: 2px;">Produk</th>
                <th class="table-content-sub" style="width: 100px; border-bottom: 2px;">Deskripsi</th>
                @if($header1 != null)
                    <th class="table-content-sub" style=" border-bottom: 2px;">{{$header1}}</th>
                @endif
                @if($header2 != null)
                    <th class="table-content-sub" style=" border-bottom: 2px;">{{$header2}}</th>
                @endif
                @if($header3 != null)
                    <th class="table-content-sub" style=" border-bottom: 2px;">{{$header3}}</th>
                @endif
                @if($header4 != null)
                    <th class="table-content-sub" style=" border-bottom: 2px;">{{$header4}}</th>
                @endif
                @if($header5 != null)
                    <th class="table-content-sub" style=" border-bottom: 2px;">{{$header5}}</th>
                @endif
                <th class="table-content-sub" style="width: 50px; border-bottom: 2px;">Jangka Waktu</th>
                <th colspan="2" class="table-content-sub" style="width: 20px; border-bottom: 2px;">Jumlah</th>
                <th class="table-content-sub" style="width: 90px; border-bottom: 2px;">Harga</th>
                <th class="table-content-sub" style="width: 90px;border-bottom: 2px;">Total Harga</th>
            @endif
        </tr>
        <tr style="height: 4px;">
            <td class="text-8">&nbsp;</td>
            @if($isPriceList)
                <td></td>
                <td></td>
                @if($colspan == 10)
                    <td></td>
                @elseif($colspan == 11)
                    <td></td>
                    <td></td>
                @elseif($colspan == 12)
                    <td></td>
                    <td></td>
                    <td></td>
                @elseif($colspan == 13)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @elseif($colspan == 14)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
            @else
                @if($colspan == 8)
                    <td></td>
                @elseif($colspan == 9)
                    <td></td>
                    <td></td>
                @elseif($colspan == 10)
                    <td></td>
                    <td></td>
                    <td></td>
                @elseif($colspan == 11)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @elseif($colspan == 12)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
            @endif
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @php
            $nominalTotal = 0;
        @endphp
        @foreach($product as $index => $prod)
            @php
                $nominalFinal = str_replace(',', '.', $prod->nominal);
                $nominalFinal = floatval($nominalFinal);

                $grandTotalFinal = str_replace(',', '.', $prod->grand_total);
                $grandTotalFinal = floatval($grandTotalFinal);

                $nominalPriceList = str_replace(',', '.', $prod->price_list);
                $nominalPriceList = floatval($nominalPriceList);

                $totalPriceList = str_replace(',', '.', $prod->total_price_list);
                $totalPriceList = floatval($totalPriceList);

                if (!function_exists('getAdditionalValue')) {
                    function getAdditionalValue(?string $column): string {
                        $parts = explode('-', $column ?? '');
                        return isset($parts[1]) ? trim($parts[1]) : '';
                    }
                }

                $value1 = getAdditionalValue($prod->additional_column_1);
                $value2 = getAdditionalValue($prod->additional_column_2);
                $value3 = getAdditionalValue($prod->additional_column_3);
                $value4 = getAdditionalValue($prod->additional_column_4);
                $value5 = getAdditionalValue($prod->additional_column_5);

            @endphp
            <tr style="border: 2px;">
                <td class="text-8" style="text-align: right; width: 15px;"><center>{{$index + 1}}</center></td>
                <td class="text-8">{{$prod->name}}</td>
                <td class="text-8">{!! $prod->description !!}</td>
                @if($header1 != null)
                    <td class="text-8">{{$value1}}</td>
                @endif
                @if($header2 != null)
                    <td class="text-8">{{$value2}}</td>
                @endif
                @if($header3 != null)
                    <td class="text-8">{{$value3}}</td>
                @endif
                @if($header4 != null)
                    <td class="text-8">{{$value4}}</td>
                @endif
                @if($header5 != null)
                    <td class="text-8">{{$value5}}</td>
                @endif
                <td class="text-8"> <center>@if($prod->jangka_waktu != null){{$prod->jangka_waktu}} bulan @endif</center></td>
                <td class="text-8" style="text-align: right; width: 10px;"><center>{{$prod->qty}}</center></td>
                <td class="text-8" style="width: 10px;"><center>{{$prod->unit}}</center></td>
                @if($isPriceList)
                    <td class="text-8"><p>Rp  <span style="text-align: center; float:right;"> {{ number_format($nominalPriceList, 2, ',', '.')  }}</span></p></td>
                    <td class="text-8"><p>Rp  <span style="text-align: center; float:right;"> {{ number_format($totalPriceList, 2, ',', '.')  }}</span></p></td>
                @endif
                <td class="text-8" style="display: table-cell; vertical-align: middle; width: 100%;"><p>Rp  <span style="float:right;vertical-align: middle;"> {{ number_format($nominalFinal, 2, ',', '.')  }}</span></p></td>
                <td class="text-8"><p>Rp  <span style="text-align: right; float:right;"> {{ number_format($grandTotalFinal, 2, ',', '.')  }}</span></p></td>
                @php
                    $nominalTotal += $prod->grand_total;
                @endphp
            </tr>
        @endforeach
        <tr style="height: 4px;">
            <td class="text-8">&nbsp;</td>
            @if($isPriceList)
                <td></td>
                <td></td>
                @if($colspan == 10)
                    <td></td>
                @elseif($colspan == 11)
                    <td></td>
                    <td></td>
                @elseif($colspan == 12)
                    <td></td>
                    <td></td>
                    <td></td>
                @elseif($colspan == 13)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @elseif($colspan == 14)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
            @else
                @if($colspan == 8)
                    <td></td>
                @elseif($colspan == 9)
                    <td></td>
                    <td></td>
                @elseif($colspan == 10)
                    <td></td>
                    <td></td>
                    <td></td>
                @elseif($colspan == 11)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @elseif($colspan == 12)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
            @endif
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @php
            $nominalTotalFinal =  str_replace(',', '.', $nominalTotal);
            $nominalTotalFinal = floatval($nominalTotalFinal);

            $nominalGrandTotalFinal = str_replace(',', '.', $config->nominal);
            $nominalGrandTotalFinal = floatval($nominalGrandTotalFinal);
            $dpp = $nominalTotalFinal * 11/12;
            $ppn = $dpp * $config->tax_vat / 100;
        @endphp
        <tr>
            <td colspan="{{$colspan}}" class="text-8" style="text-align: right;">
                <b>Total</b>
            </td>
            <td class="text-8" style="font-style: italic;"><b>Rp</b>  <span style="text-align: right; float:right;"><b> {{ number_format($nominalTotalFinal, 2, ',', '.')  }}</b></span></td>
        </tr>
        <tr>
            <td colspan="{{$colspan}}" class="text-8" style="text-align: right;">
                DPP Nilai Lainnya
            </td>
            <td class="text-8" style="font-style: italic;">Rp <span style="text-align: right; float:right;">{{ number_format($dpp, 2, ',', '.') }}</span></td>
        </tr>
        <tr>
            <td colspan="{{$colspan}}" class="text-8" style="text-align: right;">
                PPN
            </td>
            <td class="text-8" style="font-style: italic;">Rp <span style="text-align: right; float:right;">{{ number_format($ppn, 2, ',', '.') }}</span></td>
        </tr>
        <tr style="border-top: 2px;">
            <td colspan="{{$colspan}}" class="text-8" style="text-align: right; background-color: #bbbbbb; border-top: 2px;">
                <b>Total Setelah PPN</b>
            </td>
            <td class="text-8" style="border-top: 2px; background-color: yellow;"><b>Rp</b> <span style="text-align: right; float:right; "><b>{{ number_format($nominalGrandTotalFinal, 2, ',','.') }}</b></span></td>
        </tr>
    </table>
</div>
<div class="column-12">
    <p class="text-10"> <b>Syarat dan Ketentuan:</b> </p>
    <div class="text-10" style="font-size: 10px; line-height: 1.2;">
        {!! $config->term_payment !!}
    </div>
    <br>
    <p class="text-10">Demikian surat penawaran harga ini kami sampaikan,
    </p>
    <p class="text-10">Apabila ada pertanyaan lebih lanjut perihal penawaran ini, mohon dapat menghubungi kami.</p>
    <br>
    <p class="text-10">Terima kasih atas perhatian dan kerjasama yang telah diberikan.</p>
    <br>
    <p class="text-10">Hormat Saya,</p>
    <br>
    <img src="{{ public_path('img/logo-sip-hd.png') }}" alt="Logo SIP" style="max-width: 18%; height: auto; opacity: 0.5; margin-left: 15px; tab-index: 1; margin-bottom: 10px;">
    @if($config->sign && $config->nik == Auth::user()->nik)
        <img src="{{$config->sign}}" alt="" style="margin-left: -150px; tab-index: 2; margin-top: -10px; margin-bottom: 0; max-width: 17%">
    @endif
    <p class="text-10" style="margin-top: 0; padding: 0;"><u>{{$config->from}}</u></p>
    <p class="text-10"><i>
            @if($role->name == 'Account Executive')
                Account Manager
            @elseif($role->name == 'VP Sales')
                VP Of Sales {{$territory}}
            @else
                {{$role->name}}
            @endif
        </i></p>
</div>

</body>
</html>