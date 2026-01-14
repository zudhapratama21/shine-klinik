@extends('layouts.sbadmin2')

@section('content')
    <div class="card">
        <div class="card-header">Produk Treatment</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambah">Tambah
                Produk</button>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <td>Qty</td>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        ?>
                        @foreach ($treatmentproduct as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->product->nama }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>
                                    <form action="{{ route('treatmentpasien.deleteproduk', ['id'=>$item->id]) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('treatmentpasien.tambahproduk', ['id' => $id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Produk</label>
                            <select name="produk_id" class="form-control" id="">
                                @foreach ($product as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }} - {{ $item->berat }} - Stok :
                                        {{ $item->stok }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group">
                            <label for="nama">Qty</label>
                            <input type="text" id="qty" name="qty" class="form-control">
                            <p class="text-danger" style="font-size:80%">(*) Qty tidak boleh melebihi stok</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal -->
@endsection
