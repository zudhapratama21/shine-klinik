@extends('layouts.sbadmin2')

@section('content')
    <div class="card">
        <div class="card-header">Data Treatment</div>
        <div class="card-body">
            <a href="{{ route('treatment.create') }}" class="btn btn-primary mb-2">Tambah Treatment</a>

            <a href="{{ route('kategoritreatment.index') }}" class="btn btn-info mb-2">Kategori Treatment</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Kategori</th>                                                        
                            <th>Harga</th>
                            <th>Status</th>                            
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        ?>
                        @foreach ($treatment as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->kategoritreatment->name }}</td>
                                <td>{{ 'Rp. ' . number_format($item->harga, 0, ',', '.') }}</td>
                                <td>
                                    @if ($item->status == 1)
                                        <span class="badge badge-primary">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Tidak Aktif</span>
                                    @endif
                                </td>                                
                                <td>
                                    <a href="{{ route('treatment.edit', ['treatment' => $item->id]) }}"
                                        class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="/treatment/{{ $item->id }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fas fa-trash"></i></button>
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
