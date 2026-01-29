@extends('layouts.sbadmin2')

@section('content')
    <div class="card">
        <div class="card-header">Treatment Pasien</div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('treatmentpasien.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i>
                    Tambah
                    Treatment</a>
                <button class="btn btn-info btn-sm"><i class="fas fa-file-excel"></i> Download Excel</button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Total Treatment</th>
                            <th>Produk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($treatment as $item)
                            <tr>
                                <th>{{ $item->kode }}</th>
                                <th>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</th>
                                <th>{{ $item->pasien->nama_pasien }}</th>
                                <th>{{ $item->dokter->nama_dokter }}</th>
                                <th>{{ 'Rp ' . number_format($item->grandtotal, 0, ',', '.') }}</th>
                                <th>
                                    <a href="{{ route('treatmentpasien.inputproduk', ['id' => $item->id]) }}"
                                        class="btn btn-primary btn-sm"><i class="fas fa-box"></i></a>
                                </th>
                                <td style="width: 20%">
                                    <a href="{{ route('treatmentpasien.print', ['id' => $item->id]) }}"
                                        class="btn btn-outline-info btn-sm " target="_blank">
                                        <i class="fas fa-print font-weight-bold"></i>
                                    </a>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#show{{ $item->id }}"><i class="fas fa-eye"></i></button>
                                    <a href="{{ route('treatmentpasien.edit', ['treatmentpasien' => $item->id]) }}"
                                        class="btn btn-success btn-sm"><i class="fas fa-pen"></i></a>
                                    <button type="button" onclick="hapusData({{ $item->id }})"
                                        class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($treatment as $item)
        <!-- Modal -->
        <div class="modal fade" id="show{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Data Treatment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table>
                            <tr>
                                <td>Kode</td>
                                <td>:</td>
                                <td>{{ $item->kode }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <td>Pasien</td>
                                <td>:</td>
                                <td>{{ $item->pasien->nama_pasien }}</td>
                            </tr>

                            <tr>
                                <td>Dokter</td>
                                <td>:</td>
                                <td>{{ $item->dokter->nama_dokter }}</td>
                            </tr>
                        </table>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Harga </th>
                                    <th>Diskon (%)</th>
                                    <th>Diskon (Rp)</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->details as $detail)
                                    <tr>
                                        <td>{{ $detail->treatment->nama }}</td>
                                        <td>{{ 'Rp ' . number_format($detail->harga, 0, ',', '.') }}</td>
                                        <td>{{ $detail->diskon_persen }}</td>
                                        <td>{{ 'Rp ' . number_format($detail->diskon_rupiah, 0, ',', '.') }}</td>
                                        <td>{{ 'Rp ' . number_format($detail->total, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection


@section('js-custom')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function hapusData(id) {
            console.log('tes');

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/penjualan/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                "Dihapus!",
                                "Data penjualan telah dihapus.",
                                "success"
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            // ambil message dari controller
                            let message = 'Terjadi kesalahan';

                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }

                            Swal.fire(
                                'Gagal',
                                message,
                                'error'
                            );

                        }
                    });
                }
            });
        }
    </script>
@endsection
