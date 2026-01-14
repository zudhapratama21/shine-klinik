@extends('layouts.sbadmin2')

@section('content')
    <div class="card">
        <div class="card-header">Ubah Treatment <a href="{{ route('treatmentpasien.index') }}" class="text-danger ml-2"><i
                    class="fas fa-backward"></i></a></div>
        <div class="card-body">
            <form action="{{ route('treatmentpasien.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" value="{{ $treatmentpasien->tanggal }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="">Pasien</label>
                            <select name="pasien" id="pasien" class="form-control">
                                @foreach ($pasien as $item)
                                    @if ($item->id == $treatmentpasien->pasien_id)
                                        <option value="{{ $item->id }}" selected>{{ $item->nama_pasien }}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->nama_pasien }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="">Dokter</label>
                            <select name="dokter_id" id="dokter" class="form-control">
                                @foreach ($dokter as $item)
                                    @if ($item->id == $treatmentpasien->dokter_id)
                                        <option value="{{ $item->id }}" selected>{{ $item->nama_dokter }}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->nama_dokter }}</option>
                                    @endif
                                    
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Pilih Treatment</label>
                            <div class="d-flex">
                                <select name="treatment_id" id="treatment_id" class="form-control">
                                    @foreach ($treatment as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->nama }}
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
                            <input id="subtotal" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Diskon Total</label>
                            <input id="diskon_total" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">PPN (11%)</label> <button class="btn btn-outline-warning btn-sm"><i
                                    class="fas fa-money-bill"></i></button>
                            <input id="ppn" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Total</label>
                            <input id="total" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="2">{{ $treatmentpasien->keterangan }}</textarea>
                </div>

                <button type="button" onclick="simpantreatment()" class="btn btn-primary btn-sm"><i
                        class="fas fa-paper-plane"></i> Simpan</button>
            </form>
        </div>
    </div>

    @include('treatmentpasien.modaladd')

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
        let treatmentpasien_id = "{{ $treatmentpasien->id }}";
        var table;
        var treatment_id = null;
        $(document).ready(function() {
            hitungTotal();

            table = $('#datatable').DataTable({
                processing: true,
                paging: false,
                searching: false,
                info: false,
                ajax: {
                    url: '{{ route('treatmentpasien.datatreatmentedit') }}',
                    type: 'POST',
                    data: function(params) {
                        params.id = treatmentpasien_id;
                        params._token = "{{ csrf_token() }}";
                        return params;
                    }
                },
                columns: [{
                        data: 'nama'
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
                        data: 'treatmentpasien_id',
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
            treatment_id = $('#treatment_id').val();
            $('#modalproduct').modal('show');
            $('#page-loader').fadeOut(100);

        }

        function simpanProduct() {
            var harga = $('#harga').val();
            var diskon_persen = $('#diskon_persen').val();
            var diskon_rupiah = $('#diskon_rupiah').val();


            $.ajax({
                type: 'POST',
                url: '{{ route('treatmentpasien.savetreatmentedit') }}',
                dataType: 'html',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#page-loader').fadeIn(100);
                },
                data: {
                    "treatment_id": treatment_id,
                    "treatmentpasien_id": treatmentpasien_id,
                    "harga": harga,
                    "diskon_persen": diskon_persen,
                    "diskon_rp": diskon_rupiah,
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

                    $('#harga').val(0);
                    $('#diskon_persen').val(0);
                    $('#diskon_rupiah').val(0);


                    hitungTotal();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function hapusItem(treatment_id) {
            let dataTreatment = treatment_id
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
                        url: '{{ route('treatmentpasien.hapusitemedit') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": dataTreatment,
                            "treatmentpasien_id": treatmentpasien_id,
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
                url: '{{ route('treatmentpasien.hitungtotaledit') }}',
                dataType: 'html',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'id': "{{ $treatmentpasien->id }}",
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    var result = JSON.parse(data);
                    $('#subtotal').val(result.subtotal);
                    $('#diskon_total').val(result.diskon);
                    $('#total').val(result.total);
                    $('#ppn').val(result.ppn);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function simpantreatment() {
            var tanggal = $('#tanggal').val();
            var pasien = $('#pasien').val();
            var dokter = $('#dokter').val();
            var keterangan = $('#keterangan').val();


            $.ajax({
                type: 'POST',
                url: '{{ route('treatmentpasien.simpanedit') }}',
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
                    "pasien": pasien,
                    "dokter": dokter,
                    "keterangan": keterangan,
                    "treatmentpasien_id": treatmentpasien_id
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

                    window.location.href = "{{ route('treatmentpasien.index') }}";
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    </script>
@endsection
