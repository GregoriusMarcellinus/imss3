@extends('layouts.main')
@section('title', __('Purchase Order'))
@section('custom-css')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <style>
        .modal-dialog {
            overflow-y: initial !important
        }

        .modal-body {
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }
    </style>
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-po"
                        onclick="addPo()"><i class="fas fa-plus"></i> Add New PO</button>
                    <div class="card-tools">
                        <form>
                            <div class="input-group input-group">
                                <input type="text" class="form-control" name="q" placeholder="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-sm table-bordered table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No.</th>
                                    <th>{{ __('No PO') }}</th>
                                    <th>{{ __('Proyek') }}</th>
                                    <th>{{ __('Vendor') }}</th>
                                    <th>{{ __('Tanggal PO') }}</th>
                                    <th>{{ __('Batas Akhir PO') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($purchases) > 0)
                                    @foreach ($purchases as $key => $d)
                                        @php
                                            $data = [
                                                'id' => $d->id,
                                                'no' => $purchases->firstItem() + $key,
                                                'vid' => $d->vendor_id,
                                                'nama_vendor' => $d->vendor_name,
                                                'nama_proyek' => $d->proyek_name,
                                                'no_po' => $d->no_po,
                                                'tgpo' => date('d/m/Y', strtotime($d->tanggal_po)),
                                                'btpo' => date('d/m/Y', strtotime($d->batas_po)),
                                                'incoterm' => $d->incoterm,
                                                'pr_no' => $d->pr_no,
                                                'ref_sph' => $d->ref_sph,
                                                'no_just' => $d->no_just,
                                                'no_nego' => $d->no_nego,
                                                'ref_po' => $d->ref_po,
                                                'term_pay' => $d->term_pay,
                                                'garansi' => $d->garansi,
                                                'catatan_vendor' => $d->catatan_vendor,
                                                'proyek_id' => $d->proyek_id,
                                                'vendor_id' => $d->vendor_id,
                                                'detail' => $d->detail,
                                                'pr_id' => $d->pr_id,
                                            ];
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $data['no'] }}</td>
                                            <td>{{ $data['no_po'] }}</td>
                                            <td class="text-center">{{ $data['nama_proyek'] }}</td>
                                            <td class="text-center">{{ $data['nama_vendor'] }}</td>
                                            <td class="text-center">{{ $data['tgpo'] }}</td>
                                            <td class="text-center">{{ $data['btpo'] }}</td>
                                            <td class="text-center">
                                                <button title="Edit PO" type="button" class="btn btn-success btn-xs"
                                                    data-toggle="modal" data-target="#add-po"
                                                    onclick="editPo({{ json_encode($data) }})"><i
                                                        class="fas fa-edit"></i></button>

                                                <button title="Lihat Detail" type="button" data-toggle="modal"
                                                    data-target="#detail-po" class="btn-lihat btn btn-info btn-xs"
                                                    data-detail="{{ json_encode($data) }}"><i
                                                        class="fas fa-list"></i></button>

                                                @if (Auth::user() && Auth::user()->role == 0)
                                                    <button title="Hapus PO" type="button" class="btn btn-danger btn-xs"
                                                        data-toggle="modal" data-target="#delete-po"
                                                        onclick="deletePo({{ json_encode($data) }})"><i
                                                            class="fas fa-trash"></i></button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="text-center">
                                        <td colspan="5">{{ __('No data.') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div>
                {{ $purchases->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>

    {{-- modal tambah --}}
    <div class="modal fade" id="add-po">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">{{ __('Add New PO') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="save" action="{{ route('purchase_order.store') }}" method="post">
                        @csrf
                        <input type="hidden" id="save_id" name="id">
                        <div class="form-group row">
                            <label for="no_po" class="col-sm-4 col-form-label">{{ __('Nomor PO') }} </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="no_po" name="no_po">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vendor_id" class="col-sm-4 col-form-label">{{ __('Vendor') }} </label>
                            <div class="col-sm-8">
                                {{-- <input type="text" class="form-control" id="vendor_id" name="vendor_id"> --}}
                                <select class="form-control" id="vendor_id" name="vendor_id">
                                    <option value="">Pilih Vendor</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal_po" class="col-sm-4 col-form-label w-50">{{ __('Tanggal PO') }} </label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control w-50" id="tanggal_po" name="tanggal_po">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="batas_po" class="col-sm-4 col-form-label">{{ __('Batas Akhir PO') }} </label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control w-50" id="batas_po" name="batas_po">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="incoterm" class="col-sm-4 col-form-label">{{ __('Incoterm') }} </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="incoterm" name="incoterm">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pr_id" class="col-sm-4 col-form-label">{{ __('PR') }} </label>
                            <div class="col-sm-8">
                                {{-- <input type="date" class="form-control" id="proyek_id" name="proyek_id"> --}}
                                <select class="form-control" name="pr_id" id="pr_id">
                                    <option value="">Pilih Purchase Request</option>
                                    @foreach ($prs as $pr)
                                        <option value="{{ $pr->id }}">{{ $pr->no_pr }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ref_sph" class="col-sm-4 col-form-label">{{ __('Referensi SPH') }} </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="ref_sph" name="ref_sph">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="no_just" class="col-sm-4 col-form-label">{{ __('No Justifikasi') }} </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="no_just" name="no_just">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="no_nego" class="col-sm-4 col-form-label">{{ __('No Nego') }} </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="no_nego" name="no_nego">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ref_po" class="col-sm-4 col-form-label">{{ __('Refernsi Po') }} </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="ref_po" name="ref_po">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="term_pay" class="col-sm-4 col-form-label">{{ __('Termin Pembayaran') }} </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="term_pay" name="term_pay">
                                {{-- <select class="form-control" id="term_pay" name="term_pay">
                                    <option value="">Pilih Termin Pembayaran</option>
                                    <option value="0">Cash</option>
                                    <option value="1">Credit</option>
                                </select> --}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="garansi" class="col-sm-4 col-form-label">{{ __('Garansi') }} </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="garansi" name="garansi">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="proyek_id" class="col-sm-4 col-form-label">{{ __('Proyek') }} </label>
                            <div class="col-sm-8">
                                {{-- <input type="date" class="form-control" id="proyek_id" name="proyek_id"> --}}
                                <select class="form-control" name="proyek_id" id="proyek_id">
                                    <option value="">Pilih Proyek</option>
                                    @foreach ($proyeks as $proyek)
                                        <option value="{{ $proyek->id }}">{{ $proyek->nama_proyek }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan_vendor" class="col-sm-4 col-form-label">{{ __('Catatan Vendor') }}
                            </label>
                            <div class="col-sm-8">
                                {{-- <input type="textarea" class="form-control" id="catatan_vendor" name="catatan_vendor"> --}}
                                <textarea class="form-control" name="catatan_vendor" id="catatan_vendor" rows="3"></textarea>
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

    {{-- modal detail --}}
    <div class="modal fade" id="detail-po">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">{{ __('Detail Purchase Order') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12" id="container-form">
                                <form id="cetak-po" method="GET" action="{{ route('cetak_po') }}" target="_blank">
                                    <input type="hidden" name="id_po" id="id_po">
                                </form>
                                <button id="button-cetak-po" type="button" class="btn btn-primary"
                                    onclick="document.getElementById(
                                        'cetak-po').submit();">{{ __('Cetak') }}</button>
                                <table class="align-top w-100">
                                    <tr>
                                        <td style="width: 8%;"><b>No Surat</b></td>
                                        <td style="width:2%">:</td>
                                        <td style="width: 55%"><span id="po_no"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Proyek</b></td>
                                        <td>:</td>
                                        <td><span id="id_proyek"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Vendor</b></td>
                                        <td>:</td>
                                        <td><span id="id_vendor"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Tanggal PO</b></td>
                                        <td>:</td>
                                        <td><span id="po_tanggal"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Batas PO</b></td>
                                        <td>:</td>
                                        <td><span id="po_batas"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Detail</b></td>
                                        <input type="hidden" name="id" id="id">
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <button id="button-tambah-detail" type="button" class="btn btn-info"
                                                onclick="showAddItem()">{{ __('Tambah Item Detail') }}</button>
                                        </td>
                                    </tr>
                                </table>
                                <div class="table-responsive mt-2">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th>Item</th>
                                            <th>Kode Material</th>
                                            <th>Deskripsi</th>
                                            <th>Batas Akhir Diterima</th>
                                            <th>Kuantitas</th>
                                            <th>Unit</th>
                                            <th>Harga Per Unit</th>
                                            <th>Mata Uang</th>
                                            <th>Vat</th>
                                            <th>Total</th>
                                        </thead>

                                        <tbody id="tabel-po">
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
                                                    <i class="fas fa-add"></i>
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
                                        <form role="form" id="material-update" method="post">
                                            @csrf
                                            <input type="hidden" id="pid" name="pid">
                                            <input type="hidden" id="type" name="type">
                                            <div class="form-group row">
                                                <label for="deskripsi"
                                                    class="col-sm-4 col-form-label">{{ __('Deskripsi Barang') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="deskripsi"
                                                        name="deskripsi">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="batas"
                                                    class="col-sm-4 col-form-label">{{ __('Batas Akhir Diterima') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" id="batas"
                                                        name="batas">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="qty"
                                                    class="col-sm-4 col-form-label">{{ __('Kuantitas') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="qty"
                                                        name="qty">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="unit"
                                                    class="col-sm-4 col-form-label">{{ __('Unit') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="unit"
                                                        name="unit">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="hunit"
                                                    class="col-sm-4 col-form-label">{{ __('Harga Per Unit') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="hunit"
                                                        name="hunit">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="mata-uang"
                                                    class="col-sm-4 col-form-label">{{ __('Mata Uang') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="mata-uang"
                                                        name="mata-uang">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="vat"
                                                    class="col-sm-4 col-form-label">{{ __('VAT') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="vat"
                                                        name="vat">
                                                </div>
                                            </div>
                                        </form>
                                        <button id="button-update-sjn" type="button" class="btn btn-primary w-100"
                                            onclick="PoUpdate()">{{ __('Tambahkan') }}</button>
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
    <div class="modal fade" id="delete-po">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">{{ __('Delete PO') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="delete" action="{{ route('purchase_order.destroy') }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="hidden" id="delete_id" name="id">
                    </form>
                    <div>
                        <p>Anda yakin ingin menghapus purchase order <span id="pcode"
                                class="font-weight-bold"></span>?
                        </p>
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

@endsection
@section('custom-js')
    <script src="/plugins/toastr/toastr.min.js"></script>
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script>
        $(function() {
            var user_id;
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $('#loader').hide();
        });

        function resetForm() {
            $('#save').trigger("reset");
            //remove the selected select option all
            $('#vendor_id').find('option').each(function() {
                $(this).attr('selected', false);
            });
            $('#pr_id').find('option').each(function() {
                $(this).attr('selected', false);
            });
            $('#proyek_id').find('option').each(function() {
                $(this).attr('selected', false);
            });
            $('#barcode_preview_container').hide();
        }

        function addPo() {
            $('#modal-title').text("Add Purchase Order");
            $('#button-save').text("Tambahkan");
            resetForm();
        }


        function loader(status = 1) {
            if (status == 1) {
                $('#loader').show();
            } else {
                $('#loader').hide();
            }
        }

        function emptyTablePo() {
            $('#tabel-po').empty();
            $('#po_tanggal').text("");
            $('#po_batas').text("");
            $('#po_no').text("");
            $('#id_proyek').text("");
            $('#id_vendor').text("");

        }

        function editPo(data) {
            console.log(data);
            $('#modal-title').text("Edit PO");
            $('#button-save').text("Simpan");
            resetForm();
            $('#save_id').val(data.id);
            $('#no_po').val(data.no_po);
            $('#vendor_id').val(data.vendor_id);
            $('#vendor_id').find('option').each(function() {
                if ($(this).val() == data.vid) {
                    console.log($(this).val());
                    $(this).attr('selected', true);
                } else {
                    $(this).attr('selected', false);
                }
            });
            var date = data.tgpo.split('/');
            var newDate = date[2] + '-' + date[1] + '-' + date[0];
            $('#tanggal_po').val(newDate);
            var date = data.btpo.split('/');
            var newDate = date[2] + '-' + date[1] + '-' + date[0];
            $('#batas_po').val(newDate);
            $('#incoterm').val(data.incoterm);
            $('#pr_id').find('option').each(function() {
                if ($(this).val() == data.pr_id) {
                    console.log('pr', $(this).val());
                    $(this).attr('selected', true);
                } else {
                    $(this).attr('selected', false);
                }
            });
            $('#ref_sph').val(data.ref_sph);
            $('#no_just').val(data.no_just);
            $('#no_nego').val(data.no_nego);
            $('#ref_po').val(data.ref_po);
            $('#term_pay').val(data.term_pay);
            $('#garansi').val(data.garansi);
            $('#proyek_id').find('option').each(function() {
                if ($(this).val() == data.proyek_id) {
                    console.log('proyek', $(this).val());
                    $(this).attr('selected', true);
                } else {
                    $(this).attr('selected', false);
                }
            });
            $('#catatan_vendor').val(data.catatan_vendor);
        }

        $('#detail-po').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var data = button.data('detail');
            console.log(data);
            lihatPo(data);
        });

        function lihatPo(data) {
            emptyTablePo();
            $('modal-title').text("Detail PO");
            $('#button-save').text("Simpan");
            resetForm();
            $('#po_no').text(data.no_po);
            $('#id_proyek').text(data.proyek_name);
            $('#id_vendor').text(data.vendor_name);
            $('#po_tanggal').text(data.tgpo);
            $('#po_batas').text(data.btpo);
            $('#table-po').empty();

            $.ajax({
                url: '/products/purchase_order_detail/' + data.id,
                type: "GET",
                data: {
                    id: data.id
                },
                dataType: "json",
                beforeSend: function() {
                    $('#tabel-po').append('<tr><td colspan="10" class="text-center">Loading...</td></tr>');
                    $('#button-cetak-po').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                    );
                    $('#button-cetak-po').attr('disabled', true);
                },

                success: function(data) {
                    console.log(data);
                    $('#no_po').text(data.po.no_po);
                    $('#id_proyek').text(data.po.nama_proyek);
                    $('#id_vendor').text(data.po.nama_vendor);
                    $('#po_tanggal').text(data.po.tgpo);
                    $('#po_batas').text(data.po.btpo);
                    $('#id_po').val(data.po.id);
                    $('#button-cetak-po').html('<i class="fas fa-print"></i> Cetak');
                    $('#button-cetak-po').attr('disabled', false);
                    var no = 1;

                    if (data?.po.details?.length == 0) {
                        $('#tabel-po').append(
                            '<tr><td colspan="10" class="text-center">Tidak ada data</td></tr>');
                    } else {
                        $.each(data.po.detail, function(index, value) {
                            var kode_material = value.kode_material;
                            var deskripsi = value.deskripsi;
                            var batas = value.batas;
                            var date = value.batas_po.split('/');
                            var newDate = date[2] + '/' + date[1] + '/' + date[0];
                            var qty = value.qty;
                            var total = value.qty * value.harga_per_unit;
                            var vat = value.vat * total / 100;
                            var total_vat = total + vat;
                            var html = '<tr>' +
                                '<td>' + no + '</td>' +
                                '<td>' + kode_material + '</td>' +
                                '<td>' + deskripsi + '</td>' +
                                '<td>' + newDate + '</td>' +
                                '<td>' + qty + '</td>' +
                                '<td>' + value.unit + '</td>' +
                                '<td>' + value.harga_per_unit + '</td>' +
                                '<td>' + value.mata_uang + '</td>' +
                                '<td>' + value.vat + '</td>' +
                                '<td>' + total_vat + '</td>' +
                                '</tr>';
                            $('#table-po').append(html);
                            no++;
                        });
                    }
                    //remove loading
                    $('#tabel-po').find('tr:first').remove();
                }
            })

        }

        $('#detail-po').on('hidden.bs.modal', function() {
            $('#container-product').addClass('d-none');
            $('#container-product').removeClass('col-4');
            $('#container-form').addClass('col-12');
            $('#container-form').removeClass('col-8');
        });

        function showAddItem() {
            if ($('#container-product').hasClass('d-none')) {
                $('#container-product').removeClass('d-none');
                $('#container-product').addClass('col-4');
                $('#container-form').removeClass('col-12');
                $('#container-form').addClass('col-8');

            } else {
                $('#container-product').addClass('d-none');
                $('#container-product').removeClass('col-4');
                $('#container-form').addClass('col-12');
                $('#container-form').removeClass('col-8');
                $('#button-tambah-detail').removeClass('d-none');
            }
        }

        function productCheck() {
            var pcode = $('#pcode').val();
            var ptype = $('input[name="ptype"]:checked').val();
            if (pcode.length > 0) {
                loader();
                $('#pcode').prop("disabled", true);
                $('#button-check').prop("disabled", true);
                $.ajax({
                    url: '/materials?type=' + ptype + '&kode=' + pcode,
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

        function PoUpdate() {
            var id = $('#id').val();
            var pid = $('#pid').val();
            var type = $('#type').val();
            var deskripsi = $('#pname').val();
            var batas = $('#batas').val();
            var qty = $('#qty').val();
            var unit = $('#unit').val();
            var token = $('input[name=_token]').val();
            var url = '/products/purchase_order_detail/update';
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    id: id,
                    pid: pid,
                    type: type,
                    deskripsi: deskripsi,
                    batas: batas,
                    qty: qty,
                    unit: unit,
                    _token: token
                },
                dataType: "json",

                success: function(data) {
                    console.log(data);
                    if (data.status == 1) {
                        toastr.success(data.message);
                        $('#detail-po').modal('hide');
                        location.reload();
                    } else {
                        toastr.error(data.message);
                    }
                }
            })
        }

        function deletePo(data) {
            $('#delete_id').val(data.id);
        }

        function download(type) {
            window.location.href = "{{ route('products.wip.history') }}?search={{ Request::get('search') }}&dl=" + type;
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
