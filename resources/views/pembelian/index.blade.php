@extends('layouts.sbadmin2')

@section('content')
    <div class="card">
        <div class="card-header">Pembelian Produk</div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('pembelian.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah
                    Pembelian</a>
                <button class="btn btn-info btn-sm"><i class="fas fa-file-excel"></i> Download Excel</button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>Kode Supplier</th>
                            <th>Total Pembelian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembelian as $item)
                            <tr>
                                <th>{{ $item->kode }}</th>
                                <th>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</th>
                                <th>{{ $item->supplier->nama }}</th>
                                <th>{{ $item->kode_supplier }}</th>
                                <th>{{ 'Rp ' . number_format($item->grandtotal, 0, ',', '.') }}</th>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#show{{ $item->id }}"><i class="fas fa-eye"></i></button>
                                    <a href="{{ route('pembelian.edit', ['pembelian' => $item->id]) }}"
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

    @foreach ($pembelian as $item)
        <!-- Modal -->
        <div class="modal fade" id="show{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Data Pembelian</h5>
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
                                <td>Supplier</td>
                                <td>:</td>
                                <td>{{ $item->supplier->nama }}</td>
                            </tr>
                            <tr>
                                <td>Kode Supplier</td>
                                <td>:</td>
                                <td>{{ $item->kode_supplier }}</td>
                            </tr>
                        </table>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga Beli</th>
                                    <th>Qty</th>
                                    <th>Diskon (%)</th>
                                    <th>Diskon (Rp)</th>
                                    <th>Ongkos Kirim (Rp)</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->details as $detail)
                                    <tr>
                                        <td>{{ $detail->produk->nama }}</td>
                                        <td>{{ 'Rp ' . number_format($detail->harga_beli, 0, ',', '.') }}</td>
                                        <td>{{ $detail->qty }}</td>
                                        <td>{{ $detail->diskon_persen }}</td>
                                        <td>{{ 'Rp ' . number_format($detail->diskon_rupiah, 0, ',', '.') }}</td>
                                        <td>{{ 'Rp ' . number_format($detail->ongkos_kirim, 0, ',', '.') }}</td>
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
                        url: '/pembelian/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                "Dihapus!",
                                "Data pembelian telah dihapus.",
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
