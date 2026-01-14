@extends('layouts.sbadmin2')

@section('content')
    <div class="card">
        <div class="card-header">Tambah Product <a href="{{ route('product.index') }}" class="text-danger ml-2"><i
                    class="fas fa-backward"></i></a></div>
        <div class="card-body">

            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama"
                        placeholder="Masukkan Nama Produk">
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select class="form-control" id="kategori" name="kategori_id">
                        @foreach ($kategori as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="satuan">Berat Bersih</label>
                    <input type="text" class="form-control" id="berat" name="berat"
                        placeholder="Masukan Berat Bersih (contoh: 250gr, 500gr, 1kg)">
                </div>
                <div class="form-group">
                    <label for="">Stok</label>
                    <input type="number" class="form-control" id="" name="stok" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Harga Jual</label>
                    <input type="number" class="form-control" id="" name="harga" placeholder="">
                </div>

                <div class="form-group">
                    <label for="">Gambar</label>
                    <input type="file" class="form-control" name="gambar">
                </div>

                <div class="form-group">
                    <label for="">Status</label>
                    <select class="form-control" name="status">
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" id="editor" cols="30" rows="15"></textarea>
                </div>
                <button type=submit class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@section('js-custom')
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            console.log('test');

            let editor1;
            ClassicEditor
                .create(document.querySelector('#editor'))
                .then(editor => {
                    editor1 = editor;
                })
                .catch(error => {
                    console.error(error);
                })
        });
    </script>
@endsection
