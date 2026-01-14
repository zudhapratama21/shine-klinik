@extends('layouts.sbadmin2')

@section('content')
    <div class="card">
        <div class="card-header">{{ $judul }}</div>
        <div class="card-body">
            <a href="/dokter/create" class="btn btn-primary mb-2">Tambah Dokter</a>
            <table class="table table-bordered table-hover" id="datatable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Umur</th>
                        <th>Status</th>
                        <th width="22%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                     $no =1 ;
                    ?>
                    @foreach ($dokter as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->kode_dokter }}</td>
                            <td>{{ $item->nama_dokter }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} tahun</td>
                            <td>
                                @if ($item->status == 1)
                                    <span class="badge badge-primary">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Tidak Aktif</span>    
                                @endif
                            </td>

                            <td>
                                <a href="/dokter/{{ $item->id }}" class="btn btn-info">
                                    Detail
                                </a>
                                <a href="/dokter/{{ $item->id }}/edit" class="btn btn-primary">
                                    Edit
                                </a>
                                <form action="/dokter/{{ $item->id }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
