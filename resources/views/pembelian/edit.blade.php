@extends('layouts.sbadmin2')

@section('content')
    <div class="card">
        <div class="card-header">Tambah Pembelian <a href="{{ route('pembelian.index') }}" class="text-danger ml-2"><i
                    class="fas fa-backward"></i></a></div>
        <div class="card-body">
            <form action="{{ route('pembelian.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" value="{{ $pembelian->tanggal }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="">Supplier</label>
                            <select name="supplier_id" id="supplier" class="form-control">
                                @foreach ($supplier as $item)
                                    @if ($item->id == $pembelian->supplier_id)
                                        <option value="{{ $item->id }}" selected>{{ $item->nama }}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="">Kode Supplier</label>
                            <input type="text" name="kode_supplier" id="kode_supplier"
                                value="{{ $pembelian->kode_supplier }}" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Pilih Produk</label>
                            <div class="d-flex">
                                <select name="produk_id" id="produk_id" class="form-control">
                                    @foreach ($product as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama . ' - ' . $item->berat }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-outline-success btn-sm ml-2" onclick="cekProduct()"><i
                                        class="fas fa-spinner"></i></button>
                            </div>

                        </div>
                    </div>
                </div>


                <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Harga Beli</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Diskon (%)</th>
                            <th>Diskon (Rp.)</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Subtotal</label>
                            <input type="number" id="subtotal" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Diskon Total</label>
                            <input type="number" id="diskon_total" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Ongkir</label>
                            <input type="number" id="ongkos_kirim" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">PPN (11%)</label> <button class="btn btn-outline-warning btn-sm"><i
                                    class="fas fa-money-bill"></i></button>
                            <input type="number" id="ppn" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Total</label>
                            <input type="number" id="total" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="2">{{ $pembelian->keterangan }}</textarea>
                </div>

                <button type="button" onclick="simpanpembelian()" class="btn btn-primary btn-sm"><i
                        class="fas fa-paper-plane"></i> Simpan</button>

            </form>
        </div>
    </div>

    @include('pembelian.modaladd')

    <!-- Full Page Spinner -->
    <div id="page-loader" style="display:none;">
        <div class="loader-backdrop"></div>
        <div class="loader-content">
            <div class="spinner-border text-success" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="mt-2 text-white">Memuat produk...</div>
        </div>
    </div>
@endsection

@section('js-custom')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let pembelian_id = "{{ $pembelian->id }}";
        var table;
        var product_id = null;
        $(document).ready(function() {
            hitungTotal();

            table = $('#datatable').DataTable({
                processing: true,
                paging: false,
                searching: false,
                info: false,
                ajax: {
                    url: '{{ route('pembelian.dataproductedit') }}',
                    type: 'POST',
                    data: function(params) {
                        params.id = "{{ $pembelian->id }}";
                        params._token = "{{ csrf_token() }}";
                        return params;
                    }
                },
                columns: [{
                        data: 'nama'
                    },
                    {
                        data: 'harga_beli',
                        render: function(data) {
                            return 'Rp ' + parseInt(data).toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'qty'
                    },
                    {
                        data: 'harga',
                        render: function(data) {
                            return 'Rp ' + parseInt(data).toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'diskon_persen',
                        render: function(data) {
                            return data + '%';
                        }
                    },
                    {
                        data: 'diskon_rupiah',
                        render: function(data) {
                            return 'Rp ' + parseInt(data).toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'subtotal',
                        render: function(data) {
                            return 'Rp ' + parseInt(data).toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'product_id',
                        render: function(data) {
                            return `
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="hapusItem(${data})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            `;
                        }
                    }
                ]
            });
        });

        function cekProduct() {
            $('#page-loader').fadeIn(100);
            product_id = $('#produk_id').val();
            $('#modalproduct').modal('show');
            $('#page-loader').fadeOut(100);

        }

        function simpanProduct() {
            var qty = $('#qty').val();
            var harga_beli = $('#harga_beli').val();
            var diskon_persen = $('#diskon_persen').val();
            var diskon_rupiah = $('#diskon_rupiah').val();
            var ongkos_kirim = $('#ongkir').val();


            $.ajax({
                type: 'POST',
                url: '{{ route('pembelian.saveproductedit') }}',
                dataType: 'html',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#page-loader').fadeIn(100);
                },
                data: {
                    "product_id": product_id,
                    "pembelian_id": pembelian_id,
                    "qty": qty,
                    "harga_beli": harga_beli,
                    "diskon_persen": diskon_persen,
                    "diskon_rp": diskon_rupiah,
                    "ongkos_kirim": ongkos_kirim,
                    "_token": "{{ csrf_token() }}"
                },
                complete: function() {
                    $('#page-loader').fadeOut(100);
                },
                success: function(data) {
                    console.log(data);
                    $('#modalproduct').modal('hide');
                    if (table) {
                        table.ajax.reload(null, false);
                    } else {
                        console.error('DataTable belum terinisialisasi');
                    }

                    $('#qty').val(0);
                    $('#harga_beli').val(0);
                    $('#diskon_persen').val(0);
                    $('#diskon_rupiah').val(0);
                    $('#ongkir').val(0);

                    hitungTotal();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function hapusItem(product_id) {                        
            let id = product_id
            Swal.fire({
                title: "Apakah kamu yakin ?",
                text: "Kamu tidak akan bisa mengembalikan data ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('pembelian.hapusitemedit') }}',
                        dataType: 'html',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            "pembelian_id": pembelian_id,
                            "product_id": id,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(data) {                                                        
                            Swal.fire({
                                title: "Deleted!",
                                text: data.message,
                                icon: data.status
                            });

                            hitungTotal();

                            if (table) {
                                table.ajax.reload(null, false);
                            } else {
                                console.error('DataTable belum terinisialisasi');
                            }
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });

                }
            });


        }


        function hitungTotal() {
            $.ajax({
                type: 'POST',
                url: '{{ route('pembelian.hitungtotaledit') }}',
                dataType: 'html',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'id' : "{{ $pembelian->id }}",
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {                
                    var result = JSON.parse(data);
                    $('#subtotal').val(result.subtotal);
                    $('#diskon_total').val(result.diskon);
                    $('#ongkos_kirim').val(result.ongkir);
                    $('#total').val(result.total);
                    $('#ppn').val(result.ppn);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function simpanpembelian() {
            var tanggal = $('#tanggal').val();
            var supplier = $('#supplier').val();
            var kode = $('#kode_supplier').val();
            var keterangan = $('#keterangan').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('pembelian.simpanedit') }}',
                dataType: 'html',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#page-loader').fadeIn(100);
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "tanggal": tanggal,
                    "supplier": supplier,
                    "kode": kode,
                    "keterangan": keterangan,
                    "pembelian_id": pembelian_id
                },
                complete: function() {
                    $('#page-loader').fadeOut(100);
                },
                success: function(data) {
                    console.log(data);
                    Swal.fire({
                        title: "Success!",
                        text: "Pembelian berhasil disimpan.",
                        icon: "success"
                    });

                    window.location.href = "{{ route('pembelian.index') }}";
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    </script>
@endsection
