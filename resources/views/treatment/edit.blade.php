@extends('layouts.sbadmin2')

@section('content')
    <div class="card">
        <div class="card-header">Ubah Treatment <a href="{{ route('treatment.index') }}" class="text-danger ml-2"><i
                    class="fas fa-backward"></i></a></div>
        <div class="card-body">

            <form action="{{ route('treatment.update', $treatment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama"
                        placeholder="Masukkan Nama Treatment" value="{{ $treatment->nama }}">
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select class="form-control" id="kategori" name="kategori_id">
                        @foreach ($kategori as $item)
                            @if ($treatment->kategoritreatment_id == $item->id)
                                <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                            @else
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>                
                <div class="form-group">
                    <label for="">Harga</label>
                    <input type="number" class="form-control" id="" name="harga" placeholder=""
                        value="{{ $treatment->harga }}">
                </div>
                <div class="form-group">
                    <label for="">Gambar</label> <br>
                    <a href="" data-toggle="modal" data-target="#imageModal">
                        <img src="{{ asset('storage/' . $treatment->gambar) }}" style="width: 100px" alt="">
                    </a>
                    <input type="file" class="form-control mt-2" name="gambar">
                </div>

                <div class="form-group">
                    <label for="">Status</label>
                    <select class="form-control" name="status">
                        <option value="{{ $treatment->status }}" selected>
                            {{ $treatment->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" id="editor" cols="30" rows="15">{{ $treatment->deskripsi }}</textarea>
                </div>
                <button type=submit class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detil Gambar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('storage/' . $treatment->gambar) }}" style="width: 100%" alt="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                    
                </div>
            </div>
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
