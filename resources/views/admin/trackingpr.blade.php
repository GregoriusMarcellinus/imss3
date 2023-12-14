@extends('layouts.main')
@section('title', __('Tracking Purchase Request'))

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
                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-pr"
                        onclick="addPR()"><i class="fas fa-plus"></i> Add Purchase Request</button> --}}
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
                                    <th>{{ __('Nomor PR') }}</th>
                                    <th>{{ __('Proyek') }}</th>
                                    <th>{{ __('Tanggal') }}</th>
                                    <th>{{ __('Dasar PR') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($requests) > 0)
                                    @foreach ($requests as $key => $d)
                                        @php
                                            $data = [
                                                'no' => $requests->firstItem() + $key,
                                                'no_pr' => $d->no_pr,
                                                'proyek' => $d->proyek_name,
                                                'tanggal' => date('d/m/Y', strtotime($d->tgl_pr)),
                                                'dasar_pr' => $d->dasar_pr,
                                                'proyek_id' => $d->proyek_id,
                                                'waktu' => date('d/m/Y', strtotime($d->waktu)),
                                                'id' => $d->id,
                                            ];
                                        @endphp

                                        <tr>
                                            <td class="text-center">{{ $data['no'] }}</td>
                                            <td class="text-center">{{ $data['no_pr'] }}</td>
                                            <td class="text-center">{{ $data['proyek'] }}</td>
                                            <td class="text-center">{{ $data['tanggal'] }}</span></td>
                                            <td class="text-center">{{ $data['dasar_pr'] }}</td>
                                            <td class="text-center">
                                                {{-- @if (Auth::user()->role == 0 || Auth::user()->role == 2 || Auth::user()->role == 3)
                                                <button title="Edit Request" type="button" class="btn btn-success btn-xs"
                                                    data-toggle="modal" data-target="#add-pr"
                                                    onclick="editPR({{ json_encode($data) }})"><i
                                                        class="fas fa-edit"></i></button>
                                                @endif --}}
                                                <button title="Lihat Detail" type="button" data-toggle="modal"
                                                    data-target="#detail-pr" class="btn-lihat btn btn-info btn-xs"
                                                    data-detail="{{ json_encode($data) }}"><i
                                                        class="fas fa-list"></i></button>

                                                {{-- @if (Auth::user()->role == 0 || Auth::user()->role == 2 || Auth::user()->role == 3)
                                                    <button title="Hapus Request" type="button"
                                                        class="btn btn-danger btn-xs" data-toggle="modal"
                                                        data-target="#delete-pr"
                                                        onclick="deletePR({{ json_encode($data) }})"><i
                                                            class="fas fa-trash"></i></button>
                                                @endif --}}
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
                {{ $requests->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
            </div>
        </div>

        {{-- modal --}}
        <div class="modal fade" id="add-pr">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Add Purchase Request') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="save" action="{{ route('products.pr.store') }}" method="post">
                            @csrf
                            <input type="hidden" id="save_id" name="id">
                            <div class="form-group row">
                                <label for="no_pr" class="col-sm-4 col-form-label">{{ __('Nomor PR') }} </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="no_pr" name="no_pr">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tgl_pr" class="col-sm-4 col-form-label">{{ __('Tanggal') }}
                                </label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" id="tgl_pr" name="tgl_pr">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="proyek" class="col-sm-4 col-form-label">{{ __('Proyek') }}
                                </label>
                                <div class="col-sm-8">
                                    {{-- <input type="text" class="form-control" id="proyek" name="proyek"> --}}
                                    <select class="form-control" name="proyek_id" id="proyek_id">
                                        <option value="">Pilih Proyek</option>
                                        @foreach ($proyeks as $proyek)
                                            <option value="{{ $proyek->id }}">{{ $proyek->nama_proyek }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="dasar_pr" class="col-sm-4 col-form-label">{{ __('Dasar Proyek') }}
                                </label>
                                <div class="col-sm-8">
                                    {{-- <input type="text" class="form-control" id="dasar" name="dasar"> --}}
                                    <textarea class="form-control" name="dasar_pr" id="dasar_pr" rows="3"></textarea>
                                </div>
                            </div>
                            {{-- @if (Auth::user()->role == 0 || Auth::user()->role == 1)

                            <div class="form-group row">
                                <label for="proyek" class="col-sm-4 col-form-label">{{ __('Status') }}
                                </label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="proyek_id" id="proyek_id">
                                        <option value="0">Pilih Status</option>
                                        <option value="1">SPPH</option>
                                        <option value="2">SPH</option>
                                        <option value="3">JUSTIFIKASI</option>
                                        <option value="4">NEGO 1</option>
                                        <option value="5">NEGO 2</option>
                                    </select>
                                </div>
                            </div>
                            @endif --}}
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
        <div class="modal fade" id="detail-pr">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Detail Purchase Request') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="row">
                                <form id="cetak-pr" method="GET" action="{{ route('cetak_pr') }}" target="_blank">
                                    <input type="hidden" name="id" id="id">
                                </form>
                                <div class="col-12" id="container-form">
                                    <button id="button-cetak-pr" type="button" class="btn btn-primary"
                                        onclick="document.getElementById('cetak-pr').submit();">{{ __('Cetak') }}</button>
                                    <table class="align-top w-100">
                                        <tr>
                                            <td style="width: 3%;"><b>No PR</b></td>
                                            <td style="width:2%">:</td>
                                            <td style="width: 55%"><span id="no_surat"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Tanggal</b></td>
                                            <td>:</td>
                                            <td><span id="tgl_surat"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Proyek</b></td>
                                            <td>:</td>
                                            <td><span id="proyek"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Produk</b></td>
                                        </tr>
                                        {{-- <tr>
                                            <td colspan="3">
                                                <button id="button-tambah-produk" type="button" class="btn btn-info mb-3"
                                                    onclick="showAddProduct()">{{ __('Tambah Produk') }}</button>
                                            </td>
                                        </tr> --}}
                                    </table>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead style="text-align: center">
                                                <th>{{ __('NO') }}</th>
                                                <th>{{ __('Kode Material') }}</th>
                                                <th>{{ __('Uraian Barang/Jasa') }}</th>
                                                <th>{{ __('Spesifikasi') }}</th>
                                                <th>{{ __('QTY') }}</th>
                                                <th>{{ __('SAT') }}</th>
                                                <th>{{ __('Waktu Penyelesaian') }}</th>
                                                <th>{{ __('Countdown') }}</th>
                                                <th>{{ __('Keterangan') }}</th>
                                                <th>{{ __('SPPH') }}</th>
                                                <th>{{ __('SPH') }}</th>
                                                <th>{{ __('JUST') }}</th>
                                                <th>{{ __('NEGO 1') }}</th>
                                                <th>{{ __('NEGO 2') }}</th>
                                                <th>{{ __('PO') }}</th>
                                                <th>{{ __('STATUS') }}</th>
                                                <th>{{ __('EKSPEDISI') }}</th>
                                                <th>{{ __('QC') }}</th>
                                                <th>{{ __('AKSI') }}</th>
                                            </thead>
                                            <tbody id="table-pr">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-0 d-none" id="container-product">
                                    <div class="card">
                                        <div class="card-body">
                                            {{-- //radio button with label INKA or IMSS option --}}
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio1" name="ptype"
                                                    class="custom-control-input" checked value="inka">
                                                <label class="custom-control-label" for="customRadio1">INKA</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio2" name="ptype"
                                                    class="custom-control-input" value="imss">
                                                <label class="custom-control-label" for="customRadio2">IMSS</label>
                                            </div>

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
                                                    <label for="material_kode"
                                                        class="col-sm-4 col-form-label">{{ __('Kode Material') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="material_kode">
                                                        <input type="hidden" class="form-control" id="pr_id"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="pname"
                                                        class="col-sm-4 col-form-label">{{ __('Nama Barang') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="pname">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="spek"
                                                        class="col-sm-4 col-form-label">{{ __('Spesifikasi') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="spek">
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
                                                <div class="form-group row">
                                                    <label for="satuan"
                                                        class="col-sm-4 col-form-label">{{ __('Satuan') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="satuan"
                                                            name="satuan">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="waktu"
                                                        class="col-sm-4 col-form-label">{{ __('Waktu Penyelesaian') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control" id="waktu"
                                                            name="waktu">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="countdown"
                                                        class="col-sm-4 col-form-label">{{ __('Countdown') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control" id="countdown"
                                                            name="countdown">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="keterangan"
                                                        class="col-sm-4 col-form-label">{{ __('Keterangan') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="keterangan"
                                                            name="keterangan">
                                                    </div>
                                                </div>
                                            </form>
                                            <button id="button-update-pr" type="button" class="btn btn-primary w-100"
                                                onclick="PRupdate()">{{ __('Tambahkan') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal delete --}}
        <div class="modal fade" id="delete-pr">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Delete Purchase Request') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="delete" action="{{ route('purchase_request.destroy') }}"
                            method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" id="delete_id" name="id">
                        </form>
                        <div>
                            <p>Anda yakin ingin menghapus request ini <span id="pcode"
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

        function addPR() {
            $('#modal-title').text("Add Purchase Request");
            $('#button-save').text("Tambahkan");
            $('#save_id').val("");
            resetForm();
        }

        function showAddProduct() {
            if ($('#detail-pr').find('#container-product').hasClass('d-none')) {
                $('#detail-pr').find('#container-product').removeClass('d-none');
                $('#detail-pr').find('#container-product').addClass('col-5');
                $('#detail-pr').find('#container-form').removeClass('col-12');
                $('#detail-pr').find('#container-form').addClass('col-7');
                $('#button-tambah-produk').text('Kembali');
            } else {
                $('#detail-pr').find('#container-product').addClass('d-none');
                $('#detail-pr').find('#container-product').removeClass('col-5');
                $('#detail-pr').find('#container-form').addClass('col-12');
                $('#detail-pr').find('#container-form').removeClass('col-7');
                $('#button-tambah-produk').text('Tambah Item Detail');
            }
        }

        function editPR(data) {
            $('#modal-title').text("Edit Request");
            $('#button-save').text("Simpan");
            resetForm();
            $('#save_id').val(data.id);
            $('#no_pr').val(data.no_pr);
            // $('#tgl_pr').val(data.tgl_pr);
            // $('#proyek_id').val(data.proyek);
            $('#dasar_pr').val(data.dasar_pr);
            var date = data.tanggal.split('/');
            var newDate = date[2] + '-' + date[1] + '-' + date[0];
            $('#tgl_pr').val(newDate);
            $('#proyek_id').find('option').each(function() {
                if ($(this).val() == data.proyek_id) {
                    console.log($(this).val());
                    $(this).attr('selected', true);
                }
            });
        }

        function emptyTableProducts() {
            $('#table-pr').empty();
            $('#no_surat').text("");
            $('#tgl_surat').text("");
            $('proyek').text("");
        }

        function loader(status = 1) {
            if (status == 1) {
                $('#loader').show();
            } else {
                $('#loader').hide();
            }
        }

        // $('#form').hide();

        function productCheck() {
            var pcode = $('#pcode').val();
            var ptype = $('input[name="ptype"]:checked').val();
            if (pcode.length > 0) {
                loader();
                $('#pcode').prop("disabled", true);
                $('#button-check').prop("disabled", true);
                $.ajax({
                    url: "{{ url('materials?type=') }}" + ptype + '&kode=' + pcode,
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
                        if (data.success) {
                            $('#form').show();
                            $('#pname').val(data.materials.nama_barang);
                            $('#material_kode').val(data.materials.kode_material);
                            $('#spek').val(data.materials.spesifikasi);
                            $('#satuan').val(data.materials.satuan);
                        } else {
                            $('#form').show();
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
            $('#pr_id').val("");
            $('#pname').val("");
            $('#stock').val("");
            $('#spek').val("");
            $('#satuan').val("");
            $('#keterangan').val("");
            $('#countdown').val("");
            $('#waktu').val("");
            $('#pcode').val("");
            $('#material_kode').val("");
            // $('#form').hide();
        }

        function PRupdate() {
            const id = $('#pr_id').val()
            $.ajax({
                url: "{{ url('products/update_purchase_request_detail') }}" + "/",
                type: "POST",
                dataType: "json",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id_pr": id,
                    "kode_material": $('#material_kode').val(),
                    "uraian": $('#pname').val(),
                    "stock": $('#stock').val(),
                    "spek": $('#spek').val(),
                    "satuan": $('#satuan').val(),
                    "waktu": $('#waktu').val(),
                    "countdown": $('#countdown').val(),
                    "keterangan": $('#keterangan').val(),

                },
                beforeSend: function() {
                    $('#button-update-pr').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#button-update-pr').attr('disabled', true);
                },
                success: function(data) {
                    if (!data.success) {
                        toastr.error(data.message);
                        $('#button-update-pr').html('Tambahkan');
                        $('#button-update-pr').attr('disabled', false);
                        return
                    }
                    $('#id').val(data.pr.id);
                    $('#no_surat').text(data.pr.no_pr);
                    $('#tgl_surat').text(data.pr.tanggal);
                    $('#proyek').text(data.pr.proyek);
                    $('#button-update-pr').html('Tambahkan');
                    $('#button-update-pr').attr('disabled', false);
                    clearForm();
                    if (data.pr.details.length == 0) {
                        $('#table-pr').append(
                            '<tr><td colspan="17" class="text-center">Tidak ada produk</td></tr>');
                    } else {
                        $('#table-pr').empty();
                        $.each(data.pr.details, function(key, value) {
                            var status, spph, po;
                            if (!value.id_spph) {
                                spph = '-';
                            } else {
                                spph = value.nomor_spph
                            }

                            if (!value.id_po) {
                                po = '-';
                            } else {
                                po = value.no_po
                            }

                            //0 = Lakukan SPPH, 1 = Lakukan PO, 2 = Completed, 3 = Negosiasi, 4 = Justifikasi

                            //optional
                            if (value.status == 0 || !value.status) {
                                status = 'Lakukan SPPH';
                            } else if (value.status == 1) {
                                status = 'Lakukan PO';
                            } else if (value.status == 2) {
                                status = 'COMPLETED';
                            } else if (value.status == 3) {
                                status = 'NEGOSIASI';
                            } else if (value.status == 4) {
                                status = 'JUSTIFIKASI';
                            }

                            $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + value
                                .kode_material + '</td><td>' + value.uraian + '</td><td>' +
                                value.spek + '</td><td>' + value.qty + '</td><td>' + value
                                .satuan + '</td><td>' + value.waktu + '</td><td>' + value
                                .countdown + '</td><td>' + value.keterangan +
                                '</td><td>' + spph + '</td><td>' + value.sph + '</td><td>' + po +
                                '</td><td><b>' + status + '</b></td></tr>'
                            );
                        });
                    }
                }
            });
        }

        // on modal #detail-pr open
        $('#detail-pr').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var data = button.data('detail');
            console.log(data);
            lihatPR(data);
        });

        function lihatPR(data) {
            emptyTableProducts();
            clearForm()
            $('#modal-title').text("Detail Request");
            $('#button-save').text("Cetak");
            resetForm();
            $('#id').val(data.id);
            $('#no_surat').text(data.no_pr);
            $('#tgl_surat').text(data.tanggal);
            $('#proyek').text(data.proyek);
            $('#pr_id').val(data.id);
            $('#table-pr').empty();

            $.ajax({
                url: "{{ url('products/purchase_request_detail') }}" + "/" + data.id,
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $('#table-pr').append('<tr><td colspan="17" class="text-center">Loading...</td></tr>');
                    $('#button-cetak-pr').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#button-cetak-pr').attr('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#id').val(data.pr.id);
                    $('#no_surat').text(data.pr.no_pr);
                    $('#tgl_surat').text(data.pr.tanggal);
                    $('#proyek').text(data.pr.proyek);
                    $('#button-cetak-pr').html('<i class="fas fa-print"></i> Cetak');
                    $('#button-cetak-pr').attr('disabled', false);
                    var no = 1;

                    if (data.pr.details.length == 0) {
                        $('#table-pr').empty();
                        $('#table-pr').append(
                            '<tr><td colspan="17" class="text-center">Tidak ada produk</td></tr>');
                    } else {
                        $('#table-pr').empty();

                        $.each(data.pr.details, function(key, value) {

                            var id = value.id;
                            var status, spph, po;
                            if (!value.id_spph) {
                                spph = '-';
                            } else {
                                spph = value.nomor_spph
                            }

                            if (!value.id_po) {
                                po = '-';
                            } else {
                                po = value.no_po
                            }

                            // alert(value.no_sph)
                            var hasSPPH = data.pr.details.some(function(item) {
                                return item.id_spph !== null;
                            });

                            if (value.batas_akhir == null) {
                                value.batas_akhir = '-';
                            } else {
                                value.batas_akhir = value.batas_akhir;
                            }

                            if (hasSPPH) {
                                $('#edit_pr_save').prop('disabled', false);
                            } else {
                                $('#edit_pr_save').prop('disabled', true);
                            }

                            //0 = Lakukan SPPH, 1 = Lakukan PO, 2 = Completed
                            if (!value.id_spph && !value.nomor_spph) {
                                status = 'Lakukan SPPH';
                            } else if (value.id_spph && value.nomor_spph && !value.id_po) {
                                status = 'PROSES PO';
                            } else if (value.id_spph && value.nomor_spph && value
                                .id_po && value.no_po) {
                                status = 'COMPLETED';
                            }

                            // STATUS LAMA

                            // else if (value.id_spph && !value.no_sph) {
                            //     status = 'Lakukan SPH';
                            // } else if (value.id_spph && value.no_sph && !value.no_just) {
                            //     status = 'Lakukan Justifikasi';
                            // } else if (value.id_spph && value.no_sph && value.no_just && !value.id_po) {
                            //     status = 'Lakukan Nego/PO';
                            // }
                            //  else if (value.id_spph && value.no_sph && value
                            //     .id_po) {
                            //     status = 'COMPLETED';
                            // }

                            var date;
                            var msg = '';

                            if (value.batas_akhir == null) {
                                date = '-';
                                msg = '-';
                            } else {
                                msg = 'batas penerimaan barang : ';
                                date = value.batas_akhir;
                            }

                            // var userRole = data.role;
                            // alert(userRole)
                            // if (userRole === 'wil1' || userRole === 'wil2') {
                            //     $('input[id^="sph"], input[id^="tgl_sph"], input[id^="just"], input[id^="tgl_just"], input[id^="neg1"], input[id^="tgl_nego1"], input[id^="bts_nego1"], input[id^="neg2"], input[id^="tgl_nego2"], input[id^="bts_nego2"]')
                            //         .prop('disabled', true);
                            // }

                            const ekspedisi = value.ekspedisi ? value.ekspedisi : '-';

                            $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + value
                                .kode_material + '</td><td>' + value.uraian + '</td><td>' +
                                value
                                .spek + '</td><td>' + value.qty + '</td><td>' + value
                                .satuan + '</td><td>' + value.waktu + '</td><td style="color:' +
                                value.backgroundcolor + '">' + value
                                .countdown + '</td><td>' + value
                                .keterangan +
                                '</td><td>' + spph +
                                '</td><td><input type="text" class="form-control" style="width:200px;" placeholder="No SPH" id="sph' +
                                id + '" name="sph' + id + '" value="' + value.no_sph +
                                '">' +
                                '<input type="date" class="form-control mt-2" style="width:200px;" id="tgl_sph' +
                                id + '" name="tgl_sph' + id + '" value="' + value
                                .tanggal_sph + '">' +
                                '</td><td><input type="text"  class="form-control" style="width:200px;" placeholder="No Justifikasi" id="just' +
                                id + '" name="just' + id + '" value="' + value.no_just +
                                '">' +
                                '<input type="date"  class="form-control mt-2" style="width:200px;" id="tgl_just' +
                                id + '" name="tgl_just' + id + '" value="' + value
                                .tanggal_just + '">' +
                                '</td><td><input type="text"  class="form-control" style="width:200px;" placeholder="No Nego 1" id="neg1' +
                                id + '" name="neg1' + id + '" value="' + value.no_nego1 +
                                '">' +
                                '<p class="mt-2 mb-0">Tanggal Nego 1</p><input type="date"  class="form-control" style="width:200px;" id="tgl_nego1' +
                                id +
                                '" name="tgl_nego1' + id + '" value="' + value
                                .tanggal_nego1 + '">' +
                                '<p class="mt-2 mb-0">Batas Nego 1</p><input type="date"  class="form-control" style="width:200px;" id="bts_nego1' +
                                id +
                                '" name="bts_nego1' + id + '" value="' + value.batas_nego1 +
                                '">' +
                                '</td><td><input type="text" value="' + value.no_nego2 +
                                '" class="form-control" style="width:200px;" placeholder="No Nego 2" id="neg2' +
                                id + '" name="neg2' + id + '">' +
                                '<p class="mt-2 mb-0">Tanggal Nego 2</p><input type="date"  class="form-control" style="width:200px;" id="tgl_nego2' +
                                id +
                                '" name="tgl_nego2' + id + '" value="' + value
                                .tanggal_nego2 + '">' +
                                '<p class="mt-2 mb-0">Batas Nego 2</p><input type="date"  class="form-control" style="width:200px;" id="bts_nego2' +
                                id +
                                '" name="bts_nego2' + id + '" value="' + value.batas_nego2 +
                                '">' +
                                '</td><td>' + po + '</td><td><b>' + status + '</b><br><br><b>' +
                                msg + date + '</b>' + '</b></td>' +
                                '<td>' + ekspedisi + '</td>' +
                                '<td></td>' +
                                '<td><button id="edit_pr_save" data-id="' + id +
                                '" type="button" class="btn btn-success btn-xs"' +
                                '><i class="fas fa-save"></i></button>' + '</td>' + '</tr>'

                            );
                        });
                    }
                    //remove loading
                    // $('#table-pr').find('tr:first').remove();
                }
            });
        }

        //action edit_po_save
        $(document).on('click', '#edit_pr_save', function() {
            console.log('called')
            var id = $(this).data('id');
            //get the batas{id} input
            var sph = $('#sph' + id).val();
            var tanggal_sph = $('#tgl_sph' + id).val();
            var no_just = $('#just' + id).val();
            var tanggal_just = $('#tgl_just' + id).val();
            var no_nego1 = $('#neg1' + id).val();
            var tanggal_nego1 = $('#tgl_nego1' + id).val();
            var batas_nego1 = $('#bts_nego1' + id).val();
            var no_nego2 = $('#neg2' + id).val();
            var tanggal_nego2 = $('#tgl_nego2' + id).val();
            var batas_nego2 = $('#bts_nego2' + id).val();


            var form = {
                id: id,
                id_pr: $('#id').val(),
                no_sph: sph,
                tanggal_sph: tanggal_sph,
                no_just: no_just,
                tanggal_just: tanggal_just,
                no_nego1: no_nego1,
                tanggal_nego1: tanggal_nego1,
                batas_nego1: batas_nego1,
                no_nego2: no_nego2,
                tanggal_nego2: tanggal_nego2,
                batas_nego2: batas_nego2,
            };

            console.table(form);

            $('#tabel-po').empty();

            //ajax post to products/detail_pr_save

            $.ajax({
                url: "{{ route('detail_pr_save') }}",
                type: "POST",
                data: {
                    ...form,
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                beforeSend: function() {
                    $('#tabel-po').append(
                        '<tr><td colspan="17" class="text-center">Loading...</td></tr>');
                    $('#button-cetak-pr').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#button-cetak-pr').attr('disabled', true);
                },
                success: function(data) {
                    $('#button-cetak-pr').html('<i class="fas fa-print"></i> Cetak');
                    $('#button-cetak-pr').attr('disabled', false);
                    var no = 1;

                    var hasSPPH = false;
                    var hasSPPH = data.pr.details.some(function(item) {
                        return item.id_spph !== null;
                    });

                    if (hasSPPH) {
                        $('#edit_pr_save').prop('disabled', false);
                    } else {
                        $('#edit_pr_save').prop('disabled', true);
                    }

                    if (data.pr.details.length == 0) {
                        $('#table-pr').empty();
                        $('#table-pr').append(
                            '<tr><td colspan="17" class="text-center">Tidak ada produk</td></tr>');
                    } else {
                        $('#table-pr').empty();
                        $.each(data.pr.details, function(key, value) {
                            var id = value.id;

                            var no_sph = value.no_sph;
                            var tanggal_sph = value.tanggal_sph;
                            var no_just = value.no_just;
                            var tanggal_just = value.tanggal_just;
                            var no_nego1 = value.no_nego1;
                            var tanggal_nego1 = value.tanggal_nego1;
                            var batas_nego1 = value.batas_nego1;
                            var no_nego2 = value.no_nego2;
                            var tanggal_nego2 = value.tanggal_nego2;
                            var batas_nego2 = value.batas_nego2;

                            const form = {
                                no_sph: no_sph,
                                tanggal_sph: tanggal_sph,
                                no_just: no_just,
                                tanggal_just: tanggal_just,
                                no_nego1: no_nego1,
                                tanggal_nego1: tanggal_nego1,
                                batas_nego1: batas_nego1,
                                no_nego2: no_nego2,
                                tanggal_nego2: tanggal_nego2,
                                batas_nego2: batas_nego2,
                            };

                            console.log(value.no_sph)
                            console.table(form);

                            var status, spph, po;
                            if (!value.id_spph) {
                                spph = '-';
                            } else {
                                spph = value.nomor_spph
                            }

                            if (!value.id_po) {
                                po = '-';
                            } else {
                                po = value.no_po
                            }

                            //0 = Lakukan SPPH, 1 = Lakukan PO, 2 = Completed
                            if (!value.id_spph && !value.nomor_spph) {
                                status = 'Lakukan SPPH';
                            } else if (value.id_spph && value.nomor_spph && !value.id_po) {
                                status = 'PROSES PO';
                            } else if (value.id_spph && value.nomor_spph && value
                                .id_po && value.no_po) {
                                status = 'COMPLETED';
                            }

                            // STATUS LAMA
                            // if (!value.id_spph) {
                            //     status = 'Lakukan SPPH';
                            // } else if (value.id_spph && !value.no_sph) {
                            //     status = 'Lakukan SPH';
                            // } else if (value.id_spph && value.no_sph && !value.no_just) {
                            //     status = 'Lakukan Justifikasi';
                            // } else if (value.id_spph && value.no_sph && value.no_just && !value
                            //     .id_po) {
                            //     status = 'Lakukan Nego/PO';
                            // } else if (value.id_spph && value.no_sph && value
                            //     .id_po) {
                            //     status = 'COMPLETED';
                            // }

                            var date;
                            var msg = '';

                            if (value.batas_akhir == null) {
                                date = '-';
                                msg = '-';
                            } else {
                                msg = 'batas penerimaan barang : ';
                                date = value.batas_akhir;
                            }

                            $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + value
                                .kode_material + '</td><td>' + value.uraian + '</td><td>' +
                                value
                                .spek + '</td><td>' + value.qty + '</td><td>' + value
                                .satuan + '</td><td>' + value.waktu +
                                '</td><td style="color:' + value.backgroundcolor + '">' +
                                value
                                .countdown + '</td><td>' + value
                                .keterangan +
                                '</td><td>' + spph +
                                '</td><td><input type="text" class="form-control" style="width:200px;" placeholder="No SPH" id="sph' +
                                id + '" name="sph' + id + '" value="' + value.no_sph +
                                '">' +
                                '<input type="date" class="form-control mt-2" style="width:200px;" id="tgl_sph' +
                                id + '" name="tgl_sph' + id + '" value="' + value
                                .tanggal_sph + '">' +
                                '</td><td><input type="text"  class="form-control" style="width:200px;" placeholder="No Justifikasi" id="just' +
                                id + '" name="just' + id + '" value="' + value.no_just +
                                '">' +
                                '<input type="date"  class="form-control mt-2" style="width:200px;" id="tgl_just' +
                                id + '" name="tgl_just' + id + '" value="' + value
                                .tanggal_just + '">' +
                                '</td><td><input type="text"  class="form-control" style="width:200px;" placeholder="No Nego 1" id="neg1' +
                                id + '" name="neg1' + id + '" value="' + value.no_nego1 +
                                '">' +
                                '<p class="mt-2 mb-0">Tanggal Nego 1</p><input type="date"  class="form-control" style="width:200px;" id="tgl_nego1' +
                                id +
                                '" name="tgl_nego1' + id + '" value="' + value
                                .tanggal_nego1 + '">' +
                                '<p class="mt-2 mb-0">Batas Nego 1</p><input type="date"  class="form-control" style="width:200px;" id="bts_nego1' +
                                id +
                                '" name="bts_nego1' + id + '" value="' + value.batas_nego1 +
                                '">' +
                                '</td><td><input type="text" value="' + value.no_nego2 +
                                '" class="form-control" style="width:200px;" placeholder="No Nego 2" id="neg2' +
                                id + '" name="neg2' + id + '">' +
                                '<p class="mt-2 mb-0">Tanggal Nego 2</p><input type="date"  class="form-control" style="width:200px;" id="tgl_nego2' +
                                id +
                                '" name="tgl_nego2' + id + '" value="' + value
                                .tanggal_nego2 + '">' +
                                '<p class="mt-2 mb-0">Batas Nego 2</p><input type="date"  class="form-control" style="width:200px;" id="bts_nego2' +
                                id +
                                '" name="bts_nego2' + id + '" value="' + value.batas_nego2 +
                                '">' +
                                '</td><td>' + po + '</td><td><b>' + status +
                                '</b><br><br><b>' + msg + date + '</b>' + '</b></td>' +
                                '<td><button id="edit_pr_save" data-id="' + id +
                                '" type="button" class="btn btn-success btn-xs"' +
                                '><i class="fas fa-save"></i></button>' + '</td>' + '</tr>'

                            );
                        });
                    }
                }
            });

        });

        function detailPR(data) {
            $('#modal-title').text("Edit Request");
            $('#button-save').text("Simpan");
            resetForm();
            $('#save_id').val(data.id);
            $('#no_pr').val(data.no_pr);
            $('#tgl_pr').val(data.tgl_pr);
            $('#proyek_id').val(data.proyek);
            $('#dasar_pr').val(data.dasar_pr);
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

        function deletePR(data) {
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
