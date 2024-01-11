@extends('layouts.main')
@section('title', __('bom'))
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-pr"
                        onclick="addPR()"><i class="fas fa-plus"></i> Add BOM</button>
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
                                    <th>{{ __('Nomor BOM') }}</th>
                                    {{-- <th>{{ __('Tanggal') }}</th> --}}
                                    <th>{{ __('Proyek') }}</th>
                                    <th>{{ __('Tanggal') }}</th>
                                    {{-- <th>{{ __('Dasar PR') }}</th> --}}
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($requests) > 0)
                                    @foreach ($requests as $key => $d)
                                        @php
                                            $data = [
                                                'no' => $requests->firstItem() + $key,
                                                'nomor' => $d->nomor,
                                                'proyek_name' => $d->proyek_name,
                                                'tanggal' => date('d/m/Y', strtotime($d->tanggal)),
                                                'kode_material' => $d->kode_material,
                                                'deskripsi_material' => $d->deskripsi_material,
                                                'spesifikasi' => $d->spesifikasi,
                                                'p1' => $d->p1,
                                                'p3' => $d->p3,
                                                'p6' => $d->p6,
                                                'p12' => $d->p12,
                                                'p24' => $d->p24,
                                                'p36' => $d->p36,
                                                'p48' => $d->p48,
                                                'p60' => $d->p60,
                                                'p72' => $d->p72,
                                                'protective_part' => $d->protective_part,
                                                'satuan' => $d->satuan,
                                                'keterangan' => $d->keterangan,
                                                // 'dasar_pr' => $d->dasar_pr,
                                                'proyek_id' => $d->proyek_id,
                                                'id' => $d->id,
                                                // 'status' => $d->status,
                                                'editable' => $d->editable,
                                            ];
                                        @endphp

                                        <tr>
                                            <td class="text-center">{{ $data['no'] }}</td>
                                            <td class="text-center">{{ $data['nomor'] }}</td>
                                            <td class="text-center">{{ $data['proyek_name'] }}</td>
                                            <td class="text-center">{{ $data['tanggal'] }}</td>
                                            {{-- <td class="text-center">{{ $data['dasar_pr'] }}</td> --}}
                                            <td class="text-center">
                                                <button title="Edit Request" type="button" class="btn btn-success btn-xs"
                                                    data-toggle="modal" data-target="#add-pr"
                                                    onclick="editPR({{ json_encode($data) }})"
                                                    @if ($data['editable'] == 0) disabled @endif><i
                                                        class="fas fa-edit"></i></button>
                                                <button title="Lihat Detail" type="button" data-toggle="modal"
                                                    data-target="#detail-pr" class="btn-lihat btn btn-info btn-xs"
                                                    data-detail="{{ json_encode($data) }}"><i
                                                        class="fas fa-list"></i></button>
                                                @if (Auth::user()->role == 0 || Auth::user()->role == 2 || Auth::user()->role == 3)
                                                    <button title="Hapus Request" type="button"
                                                        class="btn btn-danger btn-xs" data-toggle="modal"
                                                        data-target="#delete-pr"
                                                        onclick="deletePR({{ json_encode($data) }})"
                                                        @if ($data['editable'] == 0) disabled @endif><i
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
                {{ $requests->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
            </div>
        </div>

        {{-- modal --}}
        <div class="modal fade" id="add-pr">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Add BOM') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="save" action="{{ route('bom.store') }}" method="post">
                            @csrf
                            <input type="hidden" id="save_id" name="id">
                            <div class="form-group row">
                                <label for="nomor" class="col-sm-4 col-form-label">{{ __('Nomor BOM') }} </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nomor" name="nomor">
                                </div>
                            </div>
                            <div class="form-group
                                        row">
                                <label for="proyek" class="col-sm-4 col-form-label">{{ __('Proyek') }}
                                </label>
                                <div class="col-sm-8">
                                    {{-- <input type="text" class="form-control" id="proyek" name="proyek"> --}}
                                    <select class="form-control" name="proyek" id="proyek">
                                        <option value="">Pilih Proyek</option>
                                        @foreach ($proyeks as $proyek)
                                            <option value="{{ $proyek->id }}">{{ $proyek->nama_proyek }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-4 col-form-label">{{ __('Tanggal') }}
                                </label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" id="tanggal" name="tanggal"
                                        min="{{ date('Y-m-d', strtotime('-7 days')) }}">
                                </div>
                            </div>


                            {{-- <div class="form-group row">
                                <label for="dasar_pr" class="col-sm-4 col-form-label">{{ __('Dasar Proyek') }}
                                </label>
                                <div class="col-sm-8">
                                    {{-- <input type="text" class="form-control" id="dasar" name="dasar"> --}}
                            {{-- <textarea class="form-control" name="dasar_pr" id="dasar_pr" rows="3"></textarea>
                                </div>
                            </div> --}}
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
                                            <td><span id="proyek_name"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Produk</b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <button id="button-tambah-produk" type="button"
                                                    class="btn btn-info mb-3"
                                                    onclick="showAddProduct()">{{ __('Tambah Item Detail') }}</button>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead style="text-align: center">
                                                <th>{{ __('NO') }}</th>
                                                <th>{{ __('Kode Material') }}</th>
                                                <th>{{ __('Deskripsi Material') }}</th>
                                                <th>{{ __('Spesifikasi') }}</th>
                                                <th>{{ __('P1') }}</th>
                                                <th>{{ __('P3') }}</th>
                                                <th>{{ __('P6') }}</th>
                                                <th>{{ __('P12') }}</th>
                                                <th>{{ __('P24') }}</th>
                                                <th>{{ __('P36') }}</th>
                                                <th>{{ __('P48') }}</th>
                                                <th>{{ __('P60') }}</th>
                                                <th>{{ __('P72') }}</th>
                                                <th>{{ __('Protective Part') }}</th>
                                                <th>{{ __('Satuan') }}</th>
                                                <th>{{ __('Keterangan') }}</th>
                                                {{-- <th>{{ __('QTY') }}</th>
                                                <th>{{ __('SAT') }}</th>
                                                <th>{{ __('Waktu Penyelesaian') }}</th>
                                                <th>{{ __('Nota Pembelian') }}</th>
                                                <th>{{ __('Keterangan') }}</th> --}}
                                                {{-- <th>{{ __('SPPH') }}</th>
                                                <th>{{ __('PO') }}</th> --}}
                                                {{-- <th>{{ __('STATUS') }}</th> --}}
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
                                            <form role="form" id="stock-update" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" id="pid" name="pid">
                                                <input type="hidden" id="type" name="type">
                                                <input type="hidden" id="proyek_id_val" name="proyek_id_val">
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
                                                    <label for="keterangan"
                                                        class="col-sm-4 col-form-label">{{ __('Keterangan') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="keterangan"
                                                            name="keterangan">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="lampiran"
                                                        class="col-sm-4 col-form-label">{{ __('Nota Pembelian') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="file" class="form-control" id="lampiran"
                                                            name="lampiran" />
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

        function addPR() {
            // $('#modal-title').text("Add Bom");
            $('#button-save').text("Tambahkan");
            $('#save_id').val("");
            resetForm();
        }

        $('#detail-pr').on('hidden.bs.modal', function() {
            $('#container-product').addClass('d-none');
            $('#container-product').removeClass('col-5');
            $('#container-form').addClass('col-12');
            $('#container-form').removeClass('col-7');
            $('#button-tambah-detail').text('Tambah Item Detail');
        });

        function showAddProduct() {
            if ($('#detail-pr').find('#container-product').hasClass('d-none')) {
                $('#detail-pr').find('#container-product').removeClass('d-none');
                $('#detail-pr').find('#container-product').addClass('col-5');
                $('#detail-pr').find('#container-form').removeClass('col-12');
                $('#detail-pr').find('#container-form').addClass('col-7');
                $('#button-tambah-produk').text('Kembali');
            } else {
                $('#detail-pr').find('#container-product').removeClass('col-5');
                $('#detail-pr').find('#container-product').addClass('d-none');
                $('#detail-pr').find('#container-form').addClass('col-12');
                $('#detail-pr').find('#container-form').removeClass('col-7');
                $('#button-tambah-produk').text('Tambah Item Detail');
                clearForm();
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
            $('proyek_name').text("");
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
            $('#pname').val("");
            $('#stock').val("");
            $('#spek').val("");
            $('#satuan').val("");
            $('#keterangan').val("");
            $('#waktu').val("");
            $('#pcode').val("");
            $('#material_kode').val("");
            $('#lampiran').val("");
            // $('#form').hide();
        }

        function PRupdate() {
            const id = $('#pr_id').val()

            var inputFile = $("#lampiran")[0].files[0];
            var formData = new FormData();
            formData.append('lampiran', inputFile);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id_pr', id);
            formData.append('id_proyek', $('#proyek_id_val').val());
            formData.append('kode_material', $('#material_kode').val());
            formData.append('uraian', $('#pname').val());
            formData.append('stock', $('#stock').val());
            formData.append('spek', $('#spek').val());
            formData.append('satuan', $('#satuan').val());
            formData.append('waktu', $('#waktu').val());
            formData.append('keterangan', $('#keterangan').val());

            if ($('#waktu').val() == null || $('#waktu').val() == "") {
                toastr.error("Waktu Penyelesaian belum diisi!");
                return
            }

            if (inputFile == null) {
                toastr.error("Lampiran belum diisi!");
                return
            }

            if (inputFile.type != "application/pdf") {
                toastr.error("Lampiran harus berupa file PDF!");
                return
            }

            $.ajax({
                url: "{{ url('products/update_purchase_request_detail') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
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
                            '<tr><td colspan="15" class="text-center">Tidak ada produk</td></tr>');
                    } else {
                        $('#table-pr').empty();
                        $.each(data.pr.details, function(key, value) {
                            var urlLampiran = "{{ asset('lampiran') }}";
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
                            var lampiran = null;
                            if (value.lampiran == null) {
                                lampiran = '-';
                            } else {
                                lampiran = '<a href="' + urlLampiran + '/' + value.lampiran +
                                    '"><i class="fa fa-eye"></i> Lihat</a>';
                            }
                            //0 = Lakukan SPPH, 1 = Lakukan PO, 2 = Completed, 3 = Negosiasi, 4 = Justifikasi
                            // if (value.status == 0 || !value.status) {
                            //     status = 'Lakukan SPPH';
                            // } else if (value.status == 1) {
                            //     status = 'Lakukan PO';
                            // } else if (value.status == 2) {
                            //     status = 'COMPLETED';
                            // } else if (value.status == 3) {
                            //     status = 'NEGOSIASI';
                            // } else if (value.status == 4) {
                            //     status = 'JUSTIFIKASI';
                            // }

                            // if (!value.id_spph) {
                            //     status = 'Lakukan SPPH';
                            // } else if (value.id_spph && !value.no_sph) {
                            //     status = 'Lakukan SPH';
                            // } else if (value.id_spph && value.no_sph && !value.no_just) {
                            //     status = 'Lakukan Justifikasi';
                            // } else if (value.id_spph && value.no_sph && value.no_just && !value.id_po) {
                            //     status = 'Lakukan Nego/PO';
                            // } else if (value.id_spph && value.no_sph && value
                            //     .id_po) {
                            //     status = 'COMPLETED';
                            // }

                            if (!value.id_spph && !value.nomor_spph) {
                                status = 'Lakukan SPPH';
                            } else if (value.id_spph && value.nomor_spph && !value.id_po) {
                                status = 'PROSES PO';
                            } else if (value.id_spph && value.nomor_spph && value
                                .id_po && value.no_po) {
                                status = 'COMPLETED';
                            }


                            $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + value
                                .kode_material + '</td><td>' + value.uraian + '</td><td>' +
                                value
                                .spek + '</td><td>' + value.qty + '</td><td>' + value
                                .satuan +
                                '</td><td>' + value.waktu + '</td><td>' +
                                lampiran +
                                '</td><td>' + value.keterangan + '</td><td>' + status +
                                '</td></tr>'
                                // + <td>' + spph + '</td><td>' + value.sph +
                                // '</td><td>' + po +
                                // '</td><td>' +
                                // status + '</td> +
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
            $('#button-tambah-produk').text('Tambah Item Detail');
            $('#id').val(data.id);
            $('#no_surat').text(data.nomor);
            $('#proyek_name').text(data.proyek_name);
            $('#tgl_surat').text(data.tanggal);
            $('#kode_material').text(data.kode_material);
            $('#deskripsi_material').text(data.deskripsi_material);
            $('#proyek_id_val').val(data.proyek_id);
            $('#pr_id').val(data.id);
            $('#table-pr').empty();

            //#button-tambah-produk disabled when editable is false
            if (data.editable == 0) {
                $('#button-tambah-produk').attr('disabled', true);
            } else {
                $('#button-tambah-produk').attr('disabled', false);
            }

            $.ajax({
                url: "{{ url('/bom_detail') }}" + "/" + data.id,
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $('#table-pr').append('<tr><td colspan="15" class="text-center">Loading...</td></tr>');
                    $('#button-cetak-pr').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#button-cetak-pr').attr('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#id').val(data.pr.id);
                    $('#no_surat').text(data.pr.nomor);
                    $('#tgl_surat').text(data.pr.tanggal);
                    $('#kode_material').text(data.pr.kode_material);
                    $('#deskripsi_material').text(data.pr.deskripsi_material);
                    $('#proyek_name').text(data.pr.proyek_name);
                    $('#button-cetak-pr').html('<i class="fas fa-print"></i> Cetak');
                    $('#button-cetak-pr').attr('disabled', false);
                    var no = 1;

                    if (data.pr.details.length == 0) {
                        $('#table-pr').empty();
                        $('#table-pr').append(
                            '<tr><td colspan="15" class="text-center">Tidak ada produk</td></tr>');
                    } else {
                        $('#table-pr').empty();
                        $.each(data.pr.details, function(key, value) {
                            var status, spph, po;
                            var urlLampiran = "{{ asset('lampiran') }}";
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

                            var lampiran = null;
                            if (value.lampiran == null) {
                                lampiran = '-';
                            } else {
                                lampiran = '<a href="' + urlLampiran + '/' + value.lampiran +
                                    '"><i class="fa fa-eye"></i> Lihat</a>';
                            }

                            //0 = Lakukan SPPH, 1 = Lakukan PO, 2 = Completed
                            // if (value.status == 0 || !value.status) {
                            //     status = 'Lakukan SPPH';
                            // } else if (value.status == 1) {
                            //     status = 'Lakukan PO';
                            // } else if (value.status == 2) {
                            //     status = 'COMPLETED';
                            // } else if (value.status == 3) {
                            //     status = 'NEGOSIASI';
                            // } else if (value.status == 4) {
                            //     status = 'JUSTIFIKASI';
                            // }
                            // if (!value.id_spph) {
                            //     status = 'Lakukan SPPH';
                            // } else if (value.id_spph && !value.no_sph) {
                            //     status = 'Lakukan SPH';
                            // } else if (value.id_spph && value.no_sph && !value.no_just) {
                            //     status = 'Lakukan Justifikasi';
                            // } else if (value.id_spph && value.no_sph && value.no_just && !value.id_po) {
                            //     status = 'Lakukan Nego/PO';
                            // } else if (value.id_spph && value.no_sph && value
                            //     .id_po) {
                            //     status = 'COMPLETED';
                            // }

                            if (!value.id_spph && !value.nomor_spph) {
                                status = 'Lakukan SPPH';
                            } else if (value.id_spph && value.nomor_spph && !value.id_po) {
                                status = 'PROSES PO';
                            } else if (value.id_spph && value.nomor_spph && value
                                .id_po && value.no_po) {
                                status = 'COMPLETED';
                            }

                            $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + value
                                .kode_material + '</td><td>' + value.deskripsi_material +
                                '</td><td>' +
                                value.spesifikasi + '</td><td>' + value.p1 + '</td><td>' + value
                                .p3 + '</td><td>' + value.p6 + '</td><td>' +
                                value.p12 + '</td><td>' + value.p24 +
                                '</td><td>' + value.p36 + '</td><td>' + value.p48 + '</td><td>' +
                                value.p60 + '</td><td>' + value.p72 + '</td><td>' + value
                                .protective_part + '</td><td>' +
                                value.satuan + '</td><td>'+ value.keterangan +'</td>'






                                // + <td>' + spph +
                                // '</td><td>' + po + '</td><td>' + status + '</td> +

                            );
                        });
                    }
                    //remove loading
                    // $('#table-pr').find('tr:first').remove();
                }
            });
        }

        function detailPR(data) {
            $('#modal-title').text("Edit Request");
            $('#button-save').text("Simpan");
            resetForm();
            $('#save_id').val(data.id);
            $('#no_pr').val(data.no_pr);
            $('#tgl_pr').val(data.tgl_pr);
            $('#proyek_id').val(data.proyek_id);
            $('#dasar_pr').val(data.dasar_pr);
            // alert(proyek_id)
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
