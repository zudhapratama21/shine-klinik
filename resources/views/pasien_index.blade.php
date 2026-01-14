@extends('layouts.sbadmin2')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ $judul }}
        </div>
        <div class="card-body">
            <a href="/pasien/create" class="btn btn-primary mb-2">Tambah Pasien</a>
            <div class="row mb-2">
            </div>
            <table class="table table-bordered table-hover" id="datatable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Nomor HP</th>
                        <th>Umur</th>
                        <th>Tiktok</th>
                        <th>Instagram</th>
                        <th width="18%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->kode_pasien }}</td>
                            <td>{{ $item->nama_pasien }}</td>
                            <td>{{ $item->nomor_hp }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} Tahun</td>
                            <td>{{ $item->tiktok }}</td>
                            <td>{{ $item->instagram }}</td>
                            <td>
                                <a href="/pasien/{{ $item->id }}/edit" class="btn btn-primary">
                                    Edit
                                </a>
                                <form action="/pasien/{{ $item->id }}" method="POST" class="d-inline"
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
