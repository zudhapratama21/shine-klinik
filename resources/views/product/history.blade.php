@extends('layouts.sbadmin2')

@section('content')
    <div class="card">
        <div class="card-header">{{ $judul }}</div>
        <div class="card-body">
             <div class="row">                
                <div class="col-md-4">Nama Produk : {{$product->nama}}</div>              
             </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                    <thead>
                        <tr>                            
                            <th>Qty</th>
                            <th>Stok</th>
                            <th>Jenis</th>
                            <th>Kode</th>                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=1;
                        ?>
                        @foreach ($history as $item)
                            <tr>                                
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->stok }}</td>                                
                                <td>{{ $item->jenis }}</td>
                                <td>{{ $item->kode_transaksi }}</td>                                                              
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
