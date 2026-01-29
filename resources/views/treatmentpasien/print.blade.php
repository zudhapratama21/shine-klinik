<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>TRM</title>

    <style>
        @page {
            size: A5 landscape;
            margin: 10;
        }


        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000;
        }

        html,
        body {
            margin: 0px;
            padding: 10;
        }


        table {
            width: 100%;
            border-collapse: collapse;
        }

        .border {
            border: 1px solid #000;
        }

        .border th,
        .border td {
            border: 1px solid #000;
            padding: 2px;
            vertical-align: top;            
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-bold {
            font-weight: bold;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            font-size: 16px;
        }

        .capt {
            text-align: center;
            font-size: 12px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .no-border td {
            border: none;
            padding: 1px;
        }

        .signature {
            height: 70px;
        }

        .bordertop {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .border-top-none {
            border-top: none;
            border-bottom: none;
        }

        .item-group {
            border-bottom: none !important;
            border-top: none !important;

        }
        
    </style>
</head>

<body>

    <div class="page-frame">


        <table class="border">
            <tr>
                <td width="59.5%">
                    <b>Kwitansi Treatment</b>
                </td>
                <td width="40.5%">
                    <table class="no-border">
                        <tr>
                            <td width="50%" class="text-left">
                                No. Faktur : {{$treatment->kode}}
                            </td>
                            <td width="50%" class="text-right">
                                Tanggal : {{date('d F Y', strtotime($treatment->tanggal))}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Klinik ShineBeauty Care</b><br>
                   Jl. Dr. Ir. H. Soekarno Ruko Purimas B12 No.23, MERR <br> Kec. Gn. Anyar, Surabaya
                </td>
                <td>
                    <table class="no-border">
                        <tr>
                            <td width="100%"><b>PASIEN :</b><br></td>
                        </tr>
                    </table>
                    <table class="no-border">

                        <tr>
                            <td width="8%">Nama</td>
                            <td width="2%">:</td>
                            <td width="90%">{{$treatment->pasien->nama_pasien}}</td>
                        </tr>                       
                    </table>
                </td>
            </tr>
        </table>
        <table class="border">
            <thead>
                <tr class="text-center bold">
                    <td width="5%">No</td>                    
                    <td width="54.5%">Nama Treatment</td>                    
                    <td width="14.5%">Harga</td>
                    <td width="5%"><b>Disc(%)</b></td>
                    <td width="7%"><b>Disc(Rp.)</b></td>
                    <td width="14%">Jumlah</td>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < $perBaris; $i++)    
                @if (count($treatmentdetail) > $i)
                <tr>                    
                    <td>{{ $i+1 }}</td>
                    <td class="item-group">
                        {{$treatmentdetail[$i]->treatment->nama}}
                    </td>                   
                    <td class="text-right item-group">{{number_format($treatmentdetail[$i]->harga, 0, ',', '.')}}</td>
                    <td class="text-center item-group">{{$treatmentdetail[$i]->diskon_persen}}</td>
                    <td class="text-center item-group">{{$treatmentdetail[$i]->diskon_rupiah}}</td>
                    <td class="text-right item-group">{{number_format($treatmentdetail[$i]->total, 0, ',', '.')}}</td>
                </tr>   
                @else
                <tr>
                    <td class="item-group">&nbsp;</td>
                    <td class="item-group">&nbsp;</td>
                    <td class="item-group">&nbsp;</td>
                    <td class="item-group">&nbsp;</td>
                    <td class="item-group">&nbsp;</td>
                    <td class="item-group">&nbsp;</td>                    
                </tr>  
                @endif                               
              
                 @endfor           
            </tbody>
        </table>

        <table class="border">
            <tr>

                <td width="59.5%">                   

                    <table class="no-border">
                        <tr>
                            <b>Keterangan :</b><br>
                        </tr>
                        <td height="30px">

                        </td>
                    </table>

                </td>
                <td width="40.5%">
                    <table class="no-border">                                                                              
                        <tr class="bold">
                            <td width="66%">Jumlah yang harus dibayar</td>
                            <td width="14%" class="text-left">:Rp. </td>
                            <td width="20%" class="text-right">{{number_format($treatment->grandtotal, 0, ',', '.')}}
                        </tr>
                    </table>
                </td>
            </tr>
        </table>            
    </div>


</body>

</html>