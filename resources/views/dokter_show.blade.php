@extends('layouts.sbadmin2')

@section('content')
    <div class="card">
        <div class="card-header">Nama Dokter: {{ strtoupper($dokter->nama_dokter) }}</div>
        <div class="card-body">
            <h5>Data Dokter : {{ strtoupper($dokter->nama_dokter) }}</h5>
            <div class="row">                
                <div class="col-md-9">
                    <dl class="row">
                        <dt class="col-sm-2">Kode</dt>
                        <dd class="col-sm-10">: {{ $dokter->kode_dokter }}</dd>
                        <dt class="col-sm-2">Nama</dt>
                        <dd class="col-sm-10">: {{ $dokter->nama_dokter }}</dd>
                        <dt class="col-sm-2">Nomor HP</dt>
                        <dd class="col-sm-10">: {{ $dokter->nomor_hp }}</dd>
                        <dt class="col-sm-2">Spesialis</dt>
                        <dd class="col-sm-10">: {{ $dokter->spesialis }}</dd>                                                
                    </dl>
                </div>
            </div>
            <a href="/dokter" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
