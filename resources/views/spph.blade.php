@extends('layouts.main')
@section('title', __('SPPH'))
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-SPPH"
                        onclick="addSPPH()"><i class="fas fa-plus"></i> Add New SPPH</button>
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#import-product" onclick="importProduct()"><i class="fas fa-file-excel"></i> Import Product (Excel)</button> -->
                    <!-- <button type="button" class="btn btn-primary" onclick="download('xls')"><i class="fas fa-file-excel"></i> Export Product (XLS)</button> -->
                    {{-- <div class="card-tools">
                        <form>
                            <div class="input-group input-group">
                                <input type="text" class="form-control" name="q" placeholder="Search">
                                <input type="hidden" name="category" value="{{ Request::get('category') }}">
                                <input type="hidden" name="sort" value="{{ Request::get('sort') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-sm table-bordered table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No.</th>
                                    <th>{{ __('Nomor SPPH') }}</th>
                                    <th>{{ __('Lampiran') }}</th>
                                    <th>{{ __('Perihal') }}</th>
                                    <th>{{ __('Tanggal SPPH') }}</th>
                                    <th>{{ __('Batas SPPH') }}</th>
                                    <th>{{ __('Penerima') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($spphes) > 0)
                                    @foreach ($spphes as $key => $d)
                                        @php
                                            $penerima = $d->penerima;
                                            $penerima = json_decode($penerima);
                                            $penerima = implode(', ', $penerima);
                                            $data = [
                                                'no' => $spphes->firstItem() + $key,
                                                'nomor_spph' => $d->nomor_spph,
                                                'lampiran' => $d->lampiran,
                                                'perihal' => $d->perihal,
                                                'tanggal' => date('d/m/Y', strtotime($d->tanggal_spph)),
                                                'batas' => date('d/m/Y', strtotime($d->batas_spph)),
                                                'penerima' => $penerima,
                                                'alamat' => $d->alamat,
                                                'id' => $d->id,
                                            ];
                                        @endphp

                                        <tr>
                                            <td class="text-center">{{ $data['no'] }}</td>
                                            <td class="text-center">{{ $data['nomor_spph'] }}</td>
                                            <td class="text-center">{{ $data['lampiran'] }}</td>
                                            <td class="text-center">{{ $data['perihal'] }}</td>
                                            <td class="text-center">{{ $data['tanggal'] }}</td>
                                            <td class="text-center">{{ $data['batas'] }}</td>
                                            <td class="text-center">{{ $data['penerima'] }}</td>
                                            <td class="text-center">
                                                <button title="Edit SPPH" type="button" class="btn btn-success btn-xs"
                                                    data-toggle="modal" data-target="#add-SPPH"
                                                    onclick="editSPPH({{ json_encode($data) }})"><i
                                                        class="fas fa-edit"></i></button>

                                                <button title="Lihat Detail" type="button" data-toggle="modal"
                                                    data-target="#detail-spph" class="btn-lihat btn btn-info btn-xs"
                                                    data-detail="{{ json_encode($data) }}"><i
                                                        class="fas fa-list"></i></button>
                                                @if (Auth::user()->role == 0)
                                                    <button title="Hapus SPPH" type="button" class="btn btn-danger btn-xs"
                                                        data-toggle="modal" data-target="#delete-spph"
                                                        onclick="deletespph({{ json_encode($data) }})"><i
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
                {{-- {{ $sjn->appends(request()->except('page'))->links('pagination::bootstrap-4') }} --}}
            </div>
        </div>

        {{-- modal --}}
        <div class="modal fade" id="add-SPPH">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Add New SPPH') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="save" action="{{ route('spph.store') }}" method="post">
                            @csrf
                            <input type="hidden" id="save_id" name="id">
                            <div class="form-group row">
                                <label for="nomor_spph" class="col-sm-4 col-form-label">{{ __('Nomor SPPH') }} </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nomor_spph" name="nomor_spph">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lampiran" class="col-sm-4 col-form-label">{{ __('Lampiran') }}
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="lampiran" name="lampiran">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="penerima" class="col-sm-4 col-form-label">{{ __('Nama Penerima') }}
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="penerima" name="penerima">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-4 col-form-label">{{ __('Alamat') }}
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="alamat" name="alamat">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="perihal" class="col-sm-4 col-form-label">{{ __('Perihal') }}
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="perihal" name="perihal">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal_spph" class="col-sm-4 col-form-label">{{ __('Tanggal SPPH') }}
                                </label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" id="tanggal_spph" name="tanggal_spph">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="batas_spph" class="col-sm-4 col-form-label">{{ __('Batas SPPH') }}
                                </label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" id="batas_spph" name="batas_spph">
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
        <div class="modal fade" id="detail-spph">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Detail SPPH') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="row">
                                <form id="cetak-spph" method="GET" action="{{ route('spph.print') }}"
                                    target="_blank">
                                    <input type="hidden" name="spph_id" id="spph_id">
                                </form>
                                <div class="col-12" id="container-form">
                                    <button id="button-cetak-spph" type="button" class="btn btn-primary"
                                        onclick="document.getElementById('cetak-spph').submit();">{{ __('Cetak') }}</button>
                                    <table class="align-top w-100">
                                        <tr>
                                            <td style="width: 3%;"><b>No SPPH</b></td>
                                            <td style="width:2%">:</td>
                                            <td style="width: 55%"><span id="no_surat"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Penerima</b></td>
                                            <td>:</td>
                                            <td><span id="nama_penerima"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>tanggal</b></td>
                                            <td>:</td>
                                            <td><span id="tgl_spph"></span></td>
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
                                                <th>QTY</th>
                                                <th>SAT</th>
                                            </thead>

                                            <tbody id="table-spph">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-0 d-none" id="container-product">
                                    {{-- <div class="card">
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
                                    </div> --}}
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
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Deskripsi</th>
                                                        <th>Spesifikasi</th>
                                                        <th>QTY</th>
                                                        <th>Sat</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='detail-material'>
                                                </tbody>
                                            </table>
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
        <div class="modal fade" id="delete-spph">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Delete SPPH') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="delete" action="{{ route('spph.destroy') }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" id="delete_id" name="id">
                        </form>
                        <div>
                            <p>Anda yakin ingin menghapus SPPH <span id="pcode" class="font-weight-bold"></span>?</p>
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

        function addSPPH() {
            $('#modal-title').text("Add New SPPH");
            $('#button-save').text("Tambahkan");
            $('#save_id').val("");
            resetForm();
        }

        function showAddProduct() {
            //if .modal-dialog in #detail-spph has class modal-lg, change to modal-xl, otherwise change to modal-lg
            if ($('#detail-spph').find('.modal-dialog').hasClass('modal-lg')) {
                $('#detail-spph').find('.modal-dialog').removeClass('modal-lg');
                $('#detail-spph').find('.modal-dialog').addClass('modal-xl');
                $('#button-tambah-produk').text('Kembali');
                $('#container-form').removeClass('col-12');
                $('#container-form').addClass('col-6');
                $('#container-product').removeClass('col-0');
                $('#container-product').addClass('col-6');
                $('#container-product').removeClass('d-none');
            } else {
                $('#detail-spph').find('.modal-dialog').removeClass('modal-xl');
                $('#detail-spph').find('.modal-dialog').addClass('modal-lg');
                $('#button-tambah-produk').text('Tambah Produk');
                $('#container-form').removeClass('col-6');
                $('#container-form').addClass('col-12');
                $('#container-product').removeClass('col-6');
                $('#container-product').addClass('col-0');
                $('#container-product').addClass('d-none');
            }

            getSpphDetail();

        }

        function editSPPH(data) {
            $('#modal-title').text("Edit SPPH");
            $('#button-save').text("Simpan");
            resetForm();
            $('#save_id').val(data.id);
            $('#nomor_spph').val(data.nomor_spph);
            $('#lampiran').val(data.lampiran);
            $('#penerima').val(data.penerima);
            $('#alamat').val(data.alamat);
            $('#perihal').val(data.perihal);
            // $('#tanggal_spph').val(data.tanggal);
            var date = data.tanggal.split('/');
            var newDate = date[2] + '-' + date[1] + '-' + date[0];
            $('#tanggal_spph').val(newDate)
            // $('#batas_spph').val(data.batas);
            var date = data.batas.split('/');
            var newDate = date[2] + '-' + date[1] + '-' + date[0];
            $('#batas_spph').val(newDate)
        }

        function emptyTableSpph() {
            $('#table-spph').empty();
            $('#no_surat').text("");
            $('#tanggal_spph').text("");
            $('#nama_penerima').text("");
        }

        function loader(status = 1) {
            if (status == 1) {
                $('#loader').show();
            } else {
                $('#loader').hide();
            }
        }

        // $('#form').hide();

        function getSpphDetail() {

            loader();
            $('#button-check').prop("disabled", true);
            $.ajax({
                url: '/products/products_pr/',
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
                    $('#form').show();
                    //append to #detail-material
                    $('#detail-material').empty();
                    $.each(data.products, function(key, value) {
                        $('#detail-material').append(
                            '<tr><td>' + (key + 1) + '</td><td>' + value.uraian +
                            '</td><td>' + value.spek + '</td><td>' + value.qty + '</td><td>' + value
                            .satuan +
                            '</td><td><button class="btn btn-info" onclick="addToDetails(' + value
                            .id + ')">Tambah</button></td></tr>'
                        );
                    });
                },
                error: function() {
                    $('#pcode').prop("disabled", false);
                    $('#button-check').prop("disabled", false);
                }
            });
        }

        function clearForm() {
            $('#product_id').val("");
            $('#pname').val("");
            $('#stock').val("");
            $('#pcode').val("");
            $('#form').hide();
        }

        function addToDetails(id) {
            $.ajax({
                url: '/products/tambah_spph_detail',
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "product_id": id,
                    "spph_id": $('#spph_id').val(),
                },
                dataType: "json",
                beforeSend: function() {
                    $('#loader').show();
                    $('#form').hide();
                },
                success: function(data) {
                    loader(0);
                    $('#form').show();
                    //append to #detail-material
                    $('#table-spph').empty();
                    $.each(data.spph.details, function(key, value) {
                        $('#table-spph').append('<tr><td>' + (key + 1) + '</td><td>' + value
                            .uraian + '</td><td>' + value.spek + '</td><td>' + value.qty +
                            '</td><td>' + value
                            .satuan +
                            '</td></tr>');
                    });
                },
                error: function() {
                    $('#pcode').prop("disabled", false);
                    $('#button-check').prop("disabled", false);
                }
            });
        }

        function sjnProductUpdate() {
            const id = $('#product_id').val();
            $.ajax({
                url: '/products/update_detail_sjn/',
                type: "POST",
                dataType: "json",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "product_id": id,
                    "stock": $('#stock').val(),
                    "spph_id": $('#spph_id').val(),
                },
                beforeSend: function() {
                    $('#button-update-spph').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#button-update-spph').attr('disabled', true);
                },
                success: function(data) {
                    if (!data.success) {
                        toastr.error(data.message);
                        $('#button-update-spph').html('Tambahkan');
                        $('#button-update-spph').attr('disabled', false);
                        return
                    }
                    $('#no_surat').text(data.sjn.no_sjn);
                    $('#tgl_surat').text(data.sjn.datetime);
                    $('#spph_id').val(data.sjn.spph_id);
                    $('#button-update-spph').html('Tambahkan');
                    $('#button-update-spph').attr('disabled', false);
                    clearForm();
                    if (data.sjn.products.length == 0) {
                        $('#table-spph').append(
                            '<tr><td colspan="7" class="text-center">Tidak ada produk</td></tr>');
                    } else {
                        $('#table-spph').empty();
                        $.each(data.sjn.products, function(key, value) {
                            $('#table-spph').append('<tr><td>' + (key + 1) + '</td><td>' + value
                                .uraian + '</td><td>' + value.spek + '</td><td>' + value.qty +
                                '</td><td>' + value
                                .satuan +
                                '</td><td>' + value.nama_proyek + '</td></tr>');
                        });
                    }
                }
            });
        }

        // on modal #detail-spph open
        $('#detail-spph').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var data = button.data('detail');
            // console.log(data);
            lihatSjn(data);
        });

        function lihatSjn(data) {
            emptyTableSpph();
            $('#modal-title').text("Detail SPPH");
            $('#button-save').text("Cetak");
            resetForm();
            $('#save_id').val(data.id);
            $('#no_surat').text(data.nomor_spph);
            $('#nama_penerima').text(data.penerima);
            $('#tgl_spph').text(data.tanggal);
            $('#table-spph').empty();
            $.ajax({
                url: '/products/spph_detail/' + data.id,
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $('#table-spph').append('<tr><td colspan="7" class="text-center">Loading...</td></tr>');
                    $('#button-cetak-spph').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#button-cetak-spph').attr('disabled', true);
                },
                success: function(data) {
                    $('#no_surat').text(data.spph.no_spph);
                    $('#nama_penerima').text(data.spph.penerima);
                    $('#tgl_spph').text(data.spph.tanggal_spph);
                    $('#spph_id').val(data.spph.id);
                    $('#button-cetak-spph').html('<i class="fas fa-print"></i> Cetak');
                    $('#button-cetak-spph').attr('disabled', false);
                    if (data.spph.details.length == 0) {
                        $('#table-spph').append(
                            '<tr><td colspan="7" class="text-center">Tidak ada produk</td></tr>');
                    } else {
                        $.each(data.spph.details, function(key, value) {
                            $('#table-spph').append('<tr><td>' + (key + 1) + '</td><td>' + value
                                .uraian + '</td><td>' + value.spek + '</td><td>' + value.qty +
                                '</td><td>' + value
                                .satuan +
                                '</td></tr>');
                        });
                    }

                    //remove loading
                    $('#table-spph').find('tr:first').remove();
                }
            });
        }

        function detailSjn(data) {
            $('#modal-title').text("Edit SPPH");
            $('#button-save').text("Simpan");
            resetForm();
            $('#save_id').val(data.spph_id);
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

        function deletespph(data) {
            $('#delete_id').val(data.id);
        }

        $("#download-template").click(function() {
            $.ajax({
                url: '/downloads/template_import_product.xls',
                type: "GET",
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(data) {
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(data);
                    a.href = url;
                    a.download = "template_import_product.xls";
                    document.body.append(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                }
            });
        });

        function download(type) {
            window.location.href = "{{ route('products') }}?search={{ Request::get('search') }}&dl=" + type;
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
