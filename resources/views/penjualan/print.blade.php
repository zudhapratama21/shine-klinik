<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Faktur Penjualan</title>

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
                    <b>Kwitansi</b>
                </td>
                <td width="40.5%">
                    <table class="no-border">
                        <tr>
                            <td width="50%" class="text-left">
                                No. Faktur : {{$penjualan->kode}}
                            </td>
                            <td width="50%" class="text-right">
                                Tanggal : {{date('d F Y', strtotime($penjualan->tanggal))}}
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
                            <td width="100%"><b>PEMBELI :</b><br></td>
                        </tr>
                    </table>
                    <table class="no-border">

                        <tr>
                            <td width="8%">Nama</td>
                            <td width="2%">:</td>
                            <td width="90%">{{$penjualan->pasien->nama_pasien}}</td>
                        </tr>                       
                    </table>
                </td>
            </tr>
        </table>
        <table class="border">
            <thead>
                <tr class="text-center bold">
                    <th width="6%">Qty</th>
                    <th width="10%">Berat</th>
                    <th width="43.5%">Nama Barang</th>                    
                    <th width="17%">Harga</th>
                    <td widt="5%"><b>Disc(%)</b></td>
                    <td width="7%"><b>Disc(Rp.)</b></td>
                    <th width="14%">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < $perBaris; $i++)    
                @if (count($penjualandetail) > $i)
                <tr>
                    <td class="text-center item-group">{{$penjualandetail[$i]->qty}} Pcs</td>
                    <td class="item-group">{{$penjualandetail[$i]->produk->berat}}</td>
                    <td class="item-group">
                        {{$penjualandetail[$i]->produk->nama}}
                    </td>                   
                    <td class="text-right item-group">{{number_format($penjualandetail[$i]->harga_jual, 0, ',', '.')}}</td>
                    <td class="text-center item-group">{{$penjualandetail[$i]->diskon_persen}}</td>
                    <td class="text-center item-group">{{$penjualandetail[$i]->diskon_rupiah}}</td>
                    <td class="text-right item-group">{{number_format($penjualandetail[$i]->total, 0, ',', '.')}}</td>
                </tr>   
                @else
                <tr>
                    <td class="item-group">&nbsp;</td>
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
                        <tr>
                            <td width="66%">Jumlah</td>
                            <td width="14%" class="text-left">:Rp. </td>
                            <td width="20%" class="text-right">
                                {{number_format($penjualan->subtotal - $penjualan->diskon, 0, ',', '.')}}
                            </td>
                        </tr>                                       
                        <tr>
                            <td width="66%">Ongkos Kirim </td>
                            <td width="14%" class="text-left">:Rp. </td>
                            <td width="20%" class="text-right">{{number_format($ongkir, 0, ',', '.')}}</td>
                        </tr>
                        <tr class="bold">
                            <td width="66%">Jumlah yang harus dibayar</td>
                            <td width="14%" class="text-left">:Rp. </td>
                            <td width="20%" class="text-right">{{number_format($penjualan->grandtotal, 0, ',', '.')}}
                        </tr>
                    </table>
                </td>
            </tr>
        </table>            
    </div>


</body>

</html>