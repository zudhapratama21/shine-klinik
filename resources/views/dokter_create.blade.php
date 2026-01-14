@extends('layouts.sbadmin2')

@section('content')
    <div class="card">
        <div class="card-header">TAMBAH DOKTER</div>
        <div class="card-body">
            <form action="/dokter" method="POST" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_dokter">Nama Dokter</label>
                            <input class="form-control" type="text" name="nama_dokter" value="{{ old('nama_dokter') }}"
                                autofocus>
                            <span class="text-danger">{{ $errors->first('nama_dokter') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="nomor_hp">Nomor HP</label>
                            <input class="form-control" type="text" name="nomor_hp" value="{{ old('nomor_hp') }}">
                            <span class="text-danger">{{ $errors->first('nomor_hp') }}</span>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input class="form-control" type="date" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir') }}" autofocus>
                            <span class="text-danger">{{ $errors->first('tanggal_lahir') }}</span>
                        </div>
                    </div>                   
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="instagram">Akun Instagram</label>
                            <input class="form-control" type="text" name="instagram"
                                value="{{ old('instagram') !== null ? old('instagram') : '#' }}">
                            <span class="text-danger">{{ $errors->first('instagram') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="tiktok">Akun Tiktok</label>
                            <input class="form-control" type="text" name="tiktok"
                                value="{{ old('tiktok') !== null ? old('tiktok') : '#' }}">
                            <span class="text-danger">{{ $errors->first('tiktok') }}</span>
                        </div>
                    </div>
                </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Status</label>
                        <select name="status" class="form-control">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>

                <div class="form-group ">
                    <label for="">Alamat</label>
                    <textarea name="alamat" class="form-control" id="" cols="10" rows="5"></textarea>
                </div>
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-primary">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
@endsection
