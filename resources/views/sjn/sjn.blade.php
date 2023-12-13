@extends('layouts.main')
@section('title', __('Surat Jalan'))
@section('custom-css')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endsection
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-sjn"
                        onclick="addSjn()"><i class="fas fa-plus"></i> Add New SJN</button>
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#import-product" onclick="importProduct()"><i class="fas fa-file-excel"></i> Import Product (Excel)</button> -->
                    <!-- <button type="button" class="btn btn-primary" onclick="download('xls')"><i class="fas fa-file-excel"></i> Export Product (XLS)</button> -->
                    <div class="card-tools">
                        <form>
                            {{-- <div class="input-group input-group">
                                <input type="text" class="form-control" name="q" placeholder="Search">
                                <input type="hidden" name="category" value="{{ Request::get('category') }}">
                                <input type="hidden" name="sort" value="{{ Request::get('sort') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div> --}}
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-sm table-bordered table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No.</th>
                                    <th>{{ __('Nomor SJN') }}</th>
                                    <th>{{ __('Nama Pengirim') }}</th>
                                    <th>{{ __('Tanggal') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($sjn) > 0)
                                    @foreach ($sjn as $key => $d)
                                        @php
                                            $data = [
                                                'no' => $sjn->firstItem() + $key,
                                                'sjn_id' => $d->sjn_id,
                                                'no_sjn' => $d->no_sjn,
                                                'datetime' => date('d/m/Y', strtotime($d->datetime)),
                                                'nama_pengirim' => $d->nama_pengirim,
                                            ];
                                        @endphp

                                        <tr>
                                            <td class="text-center">{{ $data['no'] }}</td>
                                            <td class="text-center">{{ $data['no_sjn'] }}</td>
                                            <td class="text-center">{{ $data['nama_pengirim'] }}</td>
                                            <td class="text-center">{{ $data['datetime'] }}</td>
                                            <td class="text-center">
                                                <button title="Edit SJN" type="button" class="btn btn-success btn-xs"
                                                    data-toggle="modal" data-target="#add-sjn"
                                                    onclick="editSjn({{ json_encode($data) }})"><i
                                                        class="fas fa-edit"></i></button>

                                                <button title="Lihat Detail" type="button" data-toggle="modal"
                                                    data-target="#detail-sjn" class="btn-lihat btn btn-info btn-xs"
                                                    data-detail="{{ json_encode($data) }}"><i
                                                        class="fas fa-list"></i></button>
                                                @if (Auth::user()->role == 0 || Auth::user()->role == 1)
                                                    <button title="Hapus Produk" type="button"
                                                        class="btn btn-danger btn-xs" data-toggle="modal"
                                                        data-target="#delete-sjn"
                                                        onclick="deleteSjn({{ json_encode($data) }})"><i
                                                            class="fas fa-trash"></i></button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="text-center">
                                        <td colspan="8">{{ __('No data.') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div>
                {{ $sjn->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
            </div>
        </div>

        {{-- modal --}}
        <div class="modal fade" id="add-sjn">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Add New SJN') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="save" action="{{ route('products.sjn.store') }}" method="post">
                            @csrf
                            <input type="hidden" id="save_id" name="id">
                            <div class="form-group row">
                                <label for="no_sjn" class="col-sm-4 col-form-label">{{ __('Nomor SJN') }} </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="no_sjn" name="no_sjn">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama_pengirim" class="col-sm-4 col-form-label">{{ __('Nama Pengirim') }}
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nama_pengirim" name="nama_pengirim">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button id="button-save" type="button" class="btn btn-primary"
                            onclick="document.getElementById('save').submit();">{{ __('Tambahkan') }}</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal lihat detail --}}
        <div class="modal fade" id="detail-sjn">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Detail Surat Jalan') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="row">
                                <form id="cetak-sjn" method="GET" action="{{ route('cetak_sjn') }}" target="_blank">
                                    <input type="hidden" name="sjn_id" id="sjn_id">
                                </form>
                                <div class="col-12" id="container-form">
                                    <button id="button-cetak-sjn" type="button" class="btn btn-primary"
                                        onclick="document.getElementById('cetak-sjn').submit();">{{ __('Cetak') }}</button>
                                    <table class="align-top w-100">
                                        <tr>
                                            <td style="width: 3%;"><b>No Surat</b></td>
                                            <td style="width:2%">:</td>
                                            <td style="width: 55%"><span id="no_surat"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Tanggal</b></td>
                                            <td>:</td>
                                            <td><span id="tgl_surat"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Produk</b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <button id="button-tambah-produk" type="button" class="btn btn-info"
                                                    onclick="showAddProduct()">{{ __('Tambah Produk') }}</button>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <th>NO</th>
                                                <th>Nama Barang</th>
                                                <th>Spesifikasi</th>
                                                <th>Kode Material</th>
                                                <th>QTY</th>
                                                <th>SAT</th>
                                                <th>Keterangan</th>
                                            </thead>

                                            <tbody id="table-products">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-0 d-none" id="container-product">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="input-group input-group-lg">
                                                <input type="text" class="form-control" id="pcode" name="pcode"
                                                    min="0" placeholder="Product Code">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" id="button-check"
                                                        onclick="productCheck()">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="loader" class="card">
                                        <div class="card-body text-center">
                                            <div class="spinner-border text-danger" style="width: 3rem; height: 3rem;"
                                                role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="form" class="card">
                                        <div class="card-body">
                                            <form role="form" id="stock-update" method="post">
                                                @csrf
                                                <input type="hidden" id="pid" name="pid">
                                                <input type="hidden" id="type" name="type">
                                                <div class="form-group row">
                                                    <label for="pname"
                                                        class="col-sm-4 col-form-label">{{ __('Nama Barang') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="pname"
                                                            disabled>
                                                        <input type="hidden" class="form-control" id="product_id"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="no_nota"
                                                        class="col-sm-4 col-form-label">{{ __('QTY') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="stock"
                                                            name="stock">
                                                    </div>
                                                </div>
                                            </form>
                                            <button id="button-update-sjn" type="button" class="btn btn-primary w-100"
                                                onclick="sjnProductUpdate()">{{ __('Tambahkan') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal delete sjn --}}
        <div class="modal fade" id="delete-sjn">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Delete Surat Jalan') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="delete" action="{{ route('sjn.delete') }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" id="delete_id" name="id">
                        </form>
                        <div>
                            <p>Anda yakin ingin menghapus surat jalan <span id="pcode"
                                    class="font-weight-bold"></span>?</p>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Batal') }}</button>
                        <button id="button-save" type="button" class="btn btn-danger"
                            onclick="document.getElementById('delete').submit();">{{ __('Ya, hapus') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- custom Js --}}
@section('custom-js')
    <script src="/plugins/toastr/toastr.min.js"></script>
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script src="/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
            var user_id;
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $('#loader').hide();

            $(".btn-lihat").on('click', function() {
                const code = $(this).attr('code');
                $("#pcode_print").val(code);
                $("#barcode").attr("src", "/products/barcode/" + code);
            });

            $('#product_code').on('change', function() {
                var code = $('#product_code').val();
                if (code != null && code != "") {
                    $("#barcode_preview").attr("src", "/products/barcode/" + code);
                    $('#barcode_preview_container').show();
                }
            });
        });

        $('#sort').on('change', function() {
            $("#sorting").submit();
        });

        function resetForm() {
            $('#save').trigger("reset");
            $('#barcode_preview_container').hide();
        }

        function addSjn() {
            $('#modal-title').text("Add New SJN");
            $('#button-save').text("Tambahkan");
            resetForm();
        }

        function showAddProduct() {
            //if .modal-dialog in #detail-sjn has class modal-lg, change to modal-xl, otherwise change to modal-lg
            if ($('#detail-sjn').find('.modal-dialog').hasClass('modal-lg')) {
                $('#detail-sjn').find('.modal-dialog').removeClass('modal-lg');
                $('#detail-sjn').find('.modal-dialog').addClass('modal-xl');
                $('#button-tambah-produk').text('Kembali');
                $('#container-form').removeClass('col-12');
                $('#container-form').addClass('col-8');
                $('#container-product').removeClass('col-0');
                $('#container-product').addClass('col-4');
                $('#container-product').removeClass('d-none');
            } else {
                $('#detail-sjn').find('.modal-dialog').removeClass('modal-xl');
                $('#detail-sjn').find('.modal-dialog').addClass('modal-lg');
                $('#button-tambah-produk').text('Tambah Produk');
                $('#container-form').removeClass('col-8');
                $('#container-form').addClass('col-12');
                $('#container-product').removeClass('col-4');
                $('#container-product').addClass('col-0');
                $('#container-product').addClass('d-none');
            }
        }

        function editSjn(data) {
            $('#modal-title').text("Edit SJN");
            $('#button-save').text("Simpan");
            resetForm();
            $('#save_id').val(data.sjn_id);
            $('#no_sjn').val(data.no_sjn);
            $('#nama_pengirim').val(data.nama_pengirim);
        }

        function emptyTableProducts() {
            $('#table-products').empty();
            $('#no_surat').text("");
            $('#tgl_surat').text("");
        }

        function loader(status = 1) {
            if (status == 1) {
                $('#loader').show();
            } else {
                $('#loader').hide();
            }
        }

        $('#form').hide();

        function productCheck() {
            var pcode = $('#pcode').val();
            if (pcode.length > 0) {
                loader();
                $('#pcode').prop("disabled", true);
                $('#button-check').prop("disabled", true);
                $.ajax({
                    url: "{{ url('products/check') }}" + "/" + pcode,
                    type: "GET",
                    data: {
                        "format": "json"
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $('#loader').show();
                        $('#form').hide();
                    },
                    success: function(data) {
                        loader(0);
                        if (data.status == 1) {
                            $('#form').show();
                            $('#pid').val(data.data.product_id);
                            $('#product_id').val(data.data.product_id);
                            $('#pname').val(data.data.product_name);
                        } else {
                            toastr.error("Product Code tidak dikenal!");
                        }
                        $('#pcode').prop("disabled", false);
                        $('#button-check').prop("disabled", false);
                    },
                    error: function() {
                        $('#pcode').prop("disabled", false);
                        $('#button-check').prop("disabled", false);
                    }
                });
            } else {
                toastr.error("Product Code belum diisi!");
            }
        }

        function clearForm() {
            $('#product_id').val("");
            $('#pname').val("");
            $('#stock').val("");
            $('#pcode').val("");
            $('#form').hide();
        }

        function sjnProductUpdate() {
            const id = $('#product_id').val();
            $.ajax({
                url: "{{ url('products/update_detail_sjn/') }}",
                type: "POST",
                dataType: "json",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "product_id": id,
                    "stock": $('#stock').val(),
                    "sjn_id": $('#sjn_id').val(),
                },
                beforeSend: function() {
                    $('#button-update-sjn').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#button-update-sjn').attr('disabled', true);
                },
                success: function(data) {
                    if (!data.success) {
                        toastr.error(data.message);
                        $('#button-update-sjn').html('Tambahkan');
                        $('#button-update-sjn').attr('disabled', false);
                        return
                    }
                    $('#no_surat').text(data.sjn.no_sjn);
                    $('#tgl_surat').text(data.sjn.datetime);
                    $('#sjn_id').val(data.sjn.sjn_id);
                    $('#button-update-sjn').html('Tambahkan');
                    $('#button-update-sjn').attr('disabled', false);
                    clearForm();
                    if (data.sjn.products.length == 0) {
                        $('#table-products').append(
                            '<tr><td colspan="7" class="text-center">Tidak ada produk</td></tr>');
                    } else {
                        $('#table-products').empty();
                        $.each(data.sjn.products, function(key, value) {
                            $('#table-products').append('<tr><td>' + (key + 1) + '</td><td>' + value
                                .product_name + '</td><td>' + value.spesifikasi + '</td><td>' +
                                value
                                .product_code + '</td><td>' + value.stock + '</td><td>' + value
                                .satuan +
                                '</td><td>' + value.nama_proyek + '</td></tr>');
                        });
                    }
                }
            });
        }

        // on modal #detail-sjn open
        $('#detail-sjn').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var data = button.data('detail');
            // console.log(data);
            lihatSjn(data);
        });

        function lihatSjn(data) {
            emptyTableProducts();
            $('#modal-title').text("Detail SJN");
            $('#button-save').text("Cetak");
            resetForm();
            $('#save_id').val(data.sjn_id);
            $('#no_sjn').val(data.no_sjn);
            $('#datetime').val(data.datetime);
            $('#table-products').empty();
            $.ajax({
                url: "{{ url('products/detail_sjn')}}" + "/" + data.sjn_id,
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $('#table-products').append('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
                    $('#button-cetak-sjn').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#button-cetak-sjn').attr('disabled', true);
                },
                success: function(data) {
                    $('#no_surat').text(data.sjn.no_sjn);
                    $('#tgl_surat').text(data.sjn.datetime);
                    $('#sjn_id').val(data.sjn.sjn_id);
                    $('#button-cetak-sjn').html('<i class="fas fa-print"></i> Cetak');
                    $('#button-cetak-sjn').attr('disabled', false);
                    if (data.sjn.products.length == 0) {
                        $('#table-products').append(
                            '<tr><td colspan="7" class="text-center">Tidak ada produk</td></tr>');
                    } else {
                        $.each(data.sjn.products, function(key, value) {
                            $('#table-products').append('<tr><td>' + (key + 1) + '</td><td>' + value
                                .product_name + '</td><td>' + value.spesifikasi + '</td><td>' +
                                value
                                .product_code + '</td><td>' + value.stock + '</td><td>' + value
                                .satuan +
                                '</td><td>' + value.nama_proyek + '</td></tr>');
                        });
                    }

                    //remove loading
                    $('#table-products').find('tr:first').remove();
                }
            });
        }

        function detailSjn(data) {
            $('#modal-title').text("Edit SJN");
            $('#button-save').text("Simpan");
            resetForm();
            $('#save_id').val(data.sjn_id);
            $('#no_sjn').val(data.no_sjn);
        }

        function barcode(code) {
            $("#pcode_print").val(code);
            $("#barcode").attr("src", "/products/barcode/" + code);
        }

        function printBarcode() {
            var code = $("#pcode_print").val();
            var url = "/products/barcode/" + code + "?print=true";
            window.open(url, 'window_print', 'menubar=0,resizable=0');
        }

        function deleteSjn(data) {
            $('#delete_id').val(data.sjn_id);
        }
    </script>
    @if (Session::has('success'))
        <script>
            toastr.success('{!! Session::get('success') !!}');
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            toastr.error('{!! Session::get('error') !!}');
        </script>
    @endif
    @if (!empty($errors->all()))
        <script>
            toastr.error('{!! implode('', $errors->all('<li>:message</li>')) !!}');
        </script>
    @endif
@endsection
