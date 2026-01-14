@extends('layouts.sbadmin2')

@section('content')
    <div class="card">
        <div class="card-header">{{ $judul }}</div>
        <div class="card-body">
            <a href="{{ route('product.create') }}" class="btn btn-primary mb-2">Tambah Product</a>

            <a href="{{ route('kategoriproduk.index') }}" class="btn btn-info mb-2">Kategori Produk</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Berat</th>
                            <th>Stok</th>                            
                            <th>Harga</th>
                            <th>Stts</th>
                            <th>Hstry</th>                            
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=1;
                        ?>
                        @foreach ($product as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->kategoriproduk->name }}</td>
                                <td>{{ $item->berat }}</td>
                                <td>{{ $item->stok }}</td>                                
                                <td>{{ 'Rp. ' . number_format($item->harga, 0, ',', '.') }}</td>
                                <td>
                                    @if ($item->status == 1)
                                        <span class="badge badge-primary">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td><a href="{{ route('product.historyproduct', ['id'=>$item->id]) }}" class="btn btn-info btn-sm"><i class="fas fa-clock"></i></a></td>                                
                                <td>                                    
                                    <a href="{{ route('product.edit', ['product'=>$item->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="/product/{{ $item->id }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
