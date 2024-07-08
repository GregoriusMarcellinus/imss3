@extends('layouts.main')
@section('title', __('Purchase Request'))
@section('custom-css')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
                        onclick="addPR()"><i class="fas fa-plus"></i> Add Purchase Request</button>
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

                        {{-- Filter by Nomor Pr dan Tanggal --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="filter-pr-no">Filter Nomor PR</label>
                                    <input type="text" class="form-control" id="filter-pr-no"
                                        placeholder="Masukkan Nomor pr">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="filter-pr-date">Filter Tanggal PR</label>
                                    <input type="date" class="form-control" id="filter-pr-date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-secondary mt-4" id="clear-filter">Clear Filter</button>
                            </div>
                        </div>
                        {{-- End Filter by Nomor Pr dan Tanggal --}}

                        <table id="table" class="table table-sm table-bordered table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th><input type="checkbox" id="select-all"></th>
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
                                                'id' => $d->id,
                                                'status' => $d->status,
                                                'editable' => $d->editable,
                                            ];
                                        @endphp

                                        {{-- backup button tampil semua --}}
                                        {{-- <tr>
                                            <td class="text-center"><input type="checkbox" name="hapus[]"
                                                    value="{{ $d->id }}"></td>
                                            <td class="text-center">{{ $data['no'] }}</td>
                                            <td class="text-center">{{ $data['no_pr'] }}</td>
                                            <td class="text-center">{{ $data['proyek'] }}</td>
                                            <td class="text-center">{{ $data['tanggal'] }}</td>
                                            <td class="text-center">{{ $data['dasar_pr'] }}</td>
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
                                        </tr> --}}
                                        {{-- backup button tampil semua --}}

                                        <tr>
                                            <td class="text-center"><input type="checkbox" name="hapus[]"
                                                    value="{{ $d->id }}"></td>
                                            <td class="text-center">{{ $data['no'] }}</td>
                                            <td class="text-center">{{ $data['no_pr'] }}</td>
                                            <td class="text-center">{{ $data['proyek'] }}</td>
                                            <td class="text-center">{{ $data['tanggal'] }}</td>
                                            <td class="text-center">{{ $data['dasar_pr'] }}</td>
                                            <td class="text-center">
                                                @if (Auth::user()->role == 2 && strpos(strtolower($data['no_pr']), 'wil1') !== false)
                                                    <!-- Tombol hanya ditampilkan untuk role 2 dan no_pr mengandung 'wil1' -->
                                                    <button title="Edit Request" type="button"
                                                        class="btn btn-success btn-xs" data-toggle="modal"
                                                        data-target="#add-pr" onclick="editPR({{ json_encode($data) }})"
                                                        @if ($data['editable'] == 0) disabled @endif>
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button title="Lihat Detail" type="button" data-toggle="modal"
                                                        data-target="#detail-pr" class="btn-lihat btn btn-info btn-xs"
                                                        data-detail="{{ json_encode($data) }}">
                                                        <i class="fas fa-list"></i>
                                                    </button>
                                                    <button title="Hapus Request" type="button"
                                                        class="btn btn-danger btn-xs" data-toggle="modal"
                                                        data-target="#delete-pr"
                                                        onclick="deletePR({{ json_encode($data) }})"
                                                        @if ($data['editable'] == 0) disabled @endif>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @elseif (Auth::user()->role == 3 && strpos(strtolower($data['no_pr']), 'wil2') !== false)
                                                    <!-- Tombol hanya ditampilkan untuk role 3 dan no_pr mengandung 'wil2' -->
                                                    <button title="Edit Request" type="button"
                                                        class="btn btn-success btn-xs" data-toggle="modal"
                                                        data-target="#add-pr" onclick="editPR({{ json_encode($data) }})"
                                                        @if ($data['editable'] == 0) disabled @endif>
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button title="Lihat Detail" type="button" data-toggle="modal"
                                                        data-target="#detail-pr" class="btn-lihat btn btn-info btn-xs"
                                                        data-detail="{{ json_encode($data) }}">
                                                        <i class="fas fa-list"></i>
                                                    </button>
                                                    <button title="Hapus Request" type="button"
                                                        class="btn btn-danger btn-xs" data-toggle="modal"
                                                        data-target="#delete-pr"
                                                        onclick="deletePR({{ json_encode($data) }})"
                                                        @if ($data['editable'] == 0) disabled @endif>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @elseif (Auth::user()->role == 0)
                                                    <!-- Tombol ditampilkan untuk role 0 tanpa melihat nomor PR -->
                                                    <button title="Edit Request" type="button"
                                                        class="btn btn-success btn-xs" data-toggle="modal"
                                                        data-target="#add-pr" onclick="editPR({{ json_encode($data) }})"
                                                        @if ($data['editable'] == 0) disabled @endif>
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button title="Lihat Detail" type="button" data-toggle="modal"
                                                        data-target="#detail-pr" class="btn-lihat btn btn-info btn-xs"
                                                        data-detail="{{ json_encode($data) }}">
                                                        <i class="fas fa-list"></i>
                                                    </button>
                                                    <button title="Hapus Request" type="button"
                                                        class="btn btn-danger btn-xs" data-toggle="modal"
                                                        data-target="#delete-pr"
                                                        onclick="deletePR({{ json_encode($data) }})"
                                                        @if ($data['editable'] == 0) disabled @endif>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @elseif (Auth::user()->role == 1)
                                                    <!-- Tombol ditampilkan untuk role 0 tanpa melihat nomor PR -->
                                                    <button title="Edit Request" type="button"
                                                        class="btn btn-success btn-xs" data-toggle="modal"
                                                        data-target="#add-pr" onclick="editPR({{ json_encode($data) }})"
                                                        @if ($data['editable'] == 0) disabled @endif>
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button title="Lihat Detail" type="button" data-toggle="modal"
                                                        data-target="#detail-pr" class="btn-lihat btn btn-info btn-xs"
                                                        data-detail="{{ json_encode($data) }}">
                                                        <i class="fas fa-list"></i>
                                                    </button>
                                                    <button title="Hapus Request" type="button"
                                                        class="btn btn-danger btn-xs" data-toggle="modal"
                                                        data-target="#delete-pr"
                                                        onclick="deletePR({{ json_encode($data) }})"
                                                        @if ($data['editable'] == 0) disabled @endif>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
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
                        <button type="button" class="btn btn-danger" id="delete-selected"
                            data-token="{{ csrf_token() }}">Hapus yang dipilih</button>
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
                                    <input type="date" class="form-control" id="tgl_pr" name="tgl_pr"
                                        min="{{ date('Y-m-d', strtotime('-7 days')) }}">
                                </div>
                            </div>
                            <div class="form-group
                                        row">
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
                                                <th>{{ __('Uraian Barang/Jasa') }}</th>
                                                <th>{{ __('Spesifikasi') }}</th>
                                                <th>{{ __('QTY') }}</th>
                                                <th>{{ __('SAT') }}</th>
                                                <th>{{ __('Waktu Penyelesaian') }}</th>
                                                <th>{{ __('Nota Pembelian') }}</th>
                                                <th>{{ __('Keterangan') }}</th>
                                                {{-- <th>{{ __('SPPH') }}</th>
                                                <th>{{ __('PO') }}</th> --}}
                                                <th>{{ __('STATUS') }}</th>
                                                <th>{{ __('AKSI') }}</th>
                                            </thead>
                                            <tbody id="table-pr">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>




                                <div class="col-0 d-none" id="container-product">
                                    <div class="card">
                                        {{-- <div class="card-body">
                                            
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
                                        </div> --}}
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
                                            <button id="button-update-pr" type="button"
                                                class="btn btn-primary w-100">{{ __('Tambahkan') }}</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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


        //Filter by Nomor dan tgl PO
        $(document).ready(function() {
            $('#clear-filter').on('click', function() {
                $('#filter-pr-no, #filter-pr-date').val('');
                filterTable();
            });

            $('#filter-pr-no, #filter-pr-date').on('keyup change', function() {
                filterTable();
            });

            function filterTable() {
                var filterNoPR = $('#filter-pr-no').val().toUpperCase();
                var filterDatePR = $('#filter-pr-date').val();

                $('table tbody tr').each(function() {
                    var noPR = $(this).find('td:nth-child(3)').text().toUpperCase();
                    var datePR = $(this).find('td:nth-child(5)')
                        .text(); // Ubah indeks kolom ke indeks tgl_pr jika perlu
                    var id = $(this).find('td:nth-child(1)')
                        .text(); // Ubah indeks kolom ke indeks ID PO jika perlu

                    // Ubah string tanggal ke objek Date untuk perbandingan
                    var dateParts = datePR.split("/");
                    var prDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[
                        0]); // Format: tahun, bulan, tanggal

                    // Ubah string filterDatePR ke objek Date
                    var filterDateParts = filterDatePR.split("-");
                    var filterPRDate = new Date(filterDateParts[0], filterDateParts[1] - 1, filterDateParts[
                        2]); // Format: tahun, bulan, tanggal

                    if ((noPR.indexOf(filterNoPR) > -1 || filterNoPR === '') &&
                        (prDate.getTime() === filterPRDate.getTime() || filterDatePR === '')) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });

        //End Filter by Nomor dan tgl PO

        function addPR() {
            $('#modal-title').text("Add Purchase Request");
            $('#button-save').text("Tambahkan");
            $('#save_id').val("");
            resetForm();
        }


        $('#select-all').change(function() {
            var checkboxes = $(this).closest('table').find(':checkbox');
            checkboxes.prop('checked', $(this).is(':checked'));
        });

        // Function to handle delete selected items
        $('#delete-selected').click(function() {
            var ids = [];
            $('input[name="hapus[]"]:checked').each(function() {
                ids.push($(this).val());
            });

            if (ids.length > 0) {
                var token = $(this).data('token');
                $.ajax({
                    url: 'pr-imss/hapus-multiple',
                    type: 'POST',
                    data: {
                        _token: token,
                        ids: ids
                    },
                    success: function(response) {
                        if (response.success) {
                            // Menghapus status checked dari semua checkbox
                            $('input[name="hapus[]"]').prop('checked', false);
                            $('#select-all').prop('checked', false);
                            // Memuat ulang halaman setelah berhasil menghapus data
                            location.reload();
                            alert('Data berhasil dihapus');
                        } else {
                            alert('Gagal menghapus data');
                        }
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan saat menghapus data');
                    }
                });
            } else {
                alert('Pilih setidaknya satu item untuk dihapus');
            }
        });

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
                $('#button-update-pr').off('click');
                // Menambahkan event listener baru untuk menghandle klik pada tombol
                $('#button-update-pr').text("Simpan").on('click', function() {
                    // Ubah teks tombol menjadi "Loading"
                    // $(this).text("Loading...");

                    // // Nonaktifkan tombol
                    // $(this).prop('disabled', true);

                    // Jalankan fungsi PRinsert()
                    PRinsert();

                    // Setelah 2 detik, kembalikan teks tombol ke semula, aktifkan kembali tombol, dan tampilkan pesan Toastr
                    // setTimeout(function() {
                    //     $('#button-update-pr').text("Simpan").prop('disabled', false);
                    //     toastr.success('Data Berhasil ditambahkan');
                    // }, 2000); // 2000 milidetik = 2 detik
                });

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

        function PRinsert() {
            const id_pr = $('#pr_id').val()
            // const id = $('#id').val()

            var inputFile = $("#lampiran")[0].files[0];
            var formData = new FormData();
            formData.append('lampiran', inputFile);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id_pr', id_pr);
            // formData.append('id', id);
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


            // // Menentukan apakah akan melakukan insert atau update berdasarkan keberadaan id
            if (id) {
                // //     // Jika id sudah ada, lakukan update
                createData(formData);
            } else {
                // Jika id belum ada, lakukan insert
                createData(formData);
            }
        }

        function PRupdate() {
            const id_pr = $('#pr_id').val()
            const id = $('#id').val()

            var inputFile = $("#lampiran")[0].files[0];
            var formData = new FormData();
            formData.append('lampiran', inputFile);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id_pr', id_pr);
            formData.append('id', id);
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


            // // Menentukan apakah akan melakukan insert atau update berdasarkan keberadaan id
            if (id) {
                // //     // Jika id sudah ada, lakukan update
                updateData(formData);
            } else {
                // Jika id belum ada, lakukan insert
                createData(formData);
            }
        }


        // function createData(formData) {
        //     $.ajax({
        //         url: "{{ url('products/update_purchase_request_detail') }}",
        //         type: "POST",
        //         data: formData,
        //         contentType: false,
        //         processData: false,
        //         beforeSend: function() {
        //             $('#table-pr').append('<tr><td colspan="15" class="text-center">Loading...</td></tr>');
        //             $('#button-cetak-pr').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
        //             $('#button-cetak-pr').attr('disabled', true);
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             $('#id').val(data.pr.id);
        //             $('#no_surat').text(data.pr.no_pr);
        //             $('#tgl_surat').text(data.pr.tanggal);
        //             $('#proyek').text(data.pr.proyek);
        //             $('#button-cetak-pr').html('<i class="fas fa-print"></i> Cetak');
        //             $('#button-cetak-pr').attr('disabled', false);
        //             if ($('#detail-pr').find('#container-product').hasClass('d-none')) {
        //                 $('#detail-pr').find('#container-product').removeClass('d-none');
        //                 $('#detail-pr').find('#container-product').addClass('col-5');
        //                 $('#detail-pr').find('#container-form').removeClass('col-12');
        //                 $('#detail-pr').find('#container-form').addClass('col-7');
        //                 $('#button-tambah-produk').text('Kembali');
        //             } else {
        //                 $('#detail-pr').find('#container-product').removeClass('col-5');
        //                 $('#detail-pr').find('#container-product').addClass('d-none');
        //                 $('#detail-pr').find('#container-form').addClass('col-12');
        //                 $('#detail-pr').find('#container-form').removeClass('col-7');
        //                 $('#button-tambah-produk').text('Tambah Item Detail');
        //                 clearForm();
        //             }
        //             var no = 1;

        //             if (data.pr.details.length == 0) {
        //                 $('#table-pr').empty();
        //                 $('#table-pr').append(
        //                     '<tr><td colspan="15" class="text-center">Tidak ada produk</td></tr>'
        //                 ); // Tambahkan pesan bahwa tidak ada produk
        //             } else {
        //                 $('#table-pr').empty();
        //                 $.each(data.pr.details, function(key, value) {
        //                     console.log(value)
        //                     var rowIndex = key + 1;
        //                     var editButton =
        //                         '<button type="button" class="btn btn-success btn-xs mr-1" data-row-id="' +
        //                         value.id + '" title="Edit" onclick="editRow(\'' + value.id + '\', \'' +
        //                         value.kode_material + '\', \'' + value.uraian + '\', \'' + value
        //                         .spek + '\', \'' + value.qty +
        //                         '\', \'' + value.satuan + '\', \'' + value.waktu + '\', \'' + value
        //                         .lampiran +
        //                         '\', \'' + value.keterangan + '\', \'' + value.status +
        //                         '\')"><i class="fas fa-edit"></i></button>';


        //                     var deleteButton =
        //                         '<button type="button" class="btn btn-danger btn-xs mr-1"' +
        //                         ' onclick="deleteDetail(' + value.id + ', \'' + value.uraian
        //                         .toString() + '\')"' +
        //                         ' title="Delete">' +
        //                         '<i class="fas fa-trash"></i>' +
        //                         '</button>';

        //                     var status, spph, po;
        //                     var urlLampiran = "{{ asset('lampiran') }}";
        //                     if (!value.id_spph) {
        //                         spph = '-';
        //                     } else {
        //                         spph = value.nomor_spph
        //                     }

        //                     if (!value.id_po) {
        //                         po = '-';
        //                     } else {
        //                         po = value.no_po
        //                     }
        //                     var keterangan;
        //                     if (value.keterangan == null) {
        //                         keterangan = '';
        //                     } else {
        //                         keterangan = value.keterangan
        //                     }
        //                     var kode_material;
        //                     if (value.kode_material == null) {
        //                         kode_material = '';
        //                     } else {
        //                         kode_material = value.kode_material
        //                     }

        //                     var lampiran = null;
        //                     if (value.lampiran == null) {
        //                         lampiran = '-';
        //                     } else {
        //                         lampiran = '<a href="' + urlLampiran + '/' + value.lampiran +
        //                             '"><i class="fa fa-eye"></i> Lihat</a>';
        //                     }

        //                     //0 = Lakukan SPPH, 1 = Lakukan PO, 2 = Completed
        //                     // if (value.status == 0 || !value.status) {
        //                     //     status = 'Lakukan SPPH';
        //                     // } else if (value.status == 1) {
        //                     //     status = 'Lakukan PO';
        //                     // } else if (value.status == 2) {
        //                     //     status = 'COMPLETED';
        //                     // } else if (value.status == 3) {
        //                     //     status = 'NEGOSIASI';
        //                     // } else if (value.status == 4) {
        //                     //     status = 'JUSTIFIKASI';
        //                     // }
        //                     // if (!value.id_spph) {
        //                     //     status = 'Lakukan SPPH';
        //                     // } else if (value.id_spph && !value.no_sph) {
        //                     //     status = 'Lakukan SPH';
        //                     // } else if (value.id_spph && value.no_sph && !value.no_just) {
        //                     //     status = 'Lakukan Justifikasi';
        //                     // } else if (value.id_spph && value.no_sph && value.no_just && !value.id_po) {
        //                     //     status = 'Lakukan Nego/PO';
        //                     // } else if (value.id_spph && value.no_sph && value
        //                     //     .id_po) {
        //                     //     status = 'COMPLETED';
        //                     // }

        //                     if (!value.id_spph && !value.nomor_spph) {
        //                         status = 'PR DONE , sedang proses SPPH';
        //                     } else if (value.id_spph && value.nomor_spph && !value.id_po) {
        //                         status = 'PROSES PO';
        //                     } else if (value.id_spph && value.nomor_spph && value
        //                         .id_po && value.no_po) {
        //                         status = 'COMPLETED';
        //                     }
        //                     $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + kode_material +
        //                         '</td><td>' + value.uraian + '</td><td>' +
        //                         value
        //                         .spek + '</td><td>' + value.qty + '</td><td>' + value
        //                         .satuan + '</td><td>' + value.waktu + '</td><td>' +
        //                         lampiran + '</td><td>' + keterangan + '</td><td><b>' +
        //                         status + '</td><td>' + editButton + deleteButton +
        //                         '</td></tr>');
        //                 });
        //             }
        //         }
        //     });
        // }

        function createData(formData) {
            $.ajax({
                url: "{{ url('products/update_purchase_request_detail') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#table-pr').append('<tr><td colspan="15" class="text-center">Loading...</td></tr>');
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
                    var no = 1;

                    if (data.pr.details.length == 0) {
                        $('#table-pr').empty();
                        $('#table-pr').append(
                            '<tr><td colspan="15" class="text-center">Tidak ada produk</td></tr>'
                        ); // Tambahkan pesan bahwa tidak ada produk
                    } else {
                        $('#table-pr').empty();
                        $.each(data.pr.details, function(key, value) {
                            console.log(value)
                            var rowIndex = key + 1;
                            var editButton =
                                '<button type="button" class="btn btn-success btn-xs mr-1" data-row-id="' +
                                value.id + '" title="Edit" onclick="editRow(\'' + value.id + '\', \'' +
                                value.kode_material + '\', \'' + value.uraian + '\', \'' + value
                                .spek + '\', \'' + value.qty +
                                '\', \'' + value.satuan + '\', \'' + value.waktu + '\', \'' + value
                                .lampiran +
                                '\', \'' + value.keterangan + '\', \'' + value.status +
                                '\')"><i class="fas fa-edit"></i></button>';


                            var deleteButton =
                                '<button type="button" class="btn btn-danger btn-xs mr-1"' +
                                ' onclick="deleteDetail(' + value.id + ', \'' + value.uraian
                                .toString() + '\')"' +
                                ' title="Delete">' +
                                '<i class="fas fa-trash"></i>' +
                                '</button>';

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
                            var keterangan;
                            if (value.keterangan == null) {
                                keterangan = '';
                            } else {
                                keterangan = value.keterangan
                            }
                            var kode_material;
                            if (value.kode_material == null) {
                                kode_material = '';
                            } else {
                                kode_material = value.kode_material
                            }

                            var lampiran = null;
                            if (value.lampiran == null) {
                                lampiran = '-';
                            } else {
                                lampiran = '<a href="' + urlLampiran + '/' + value.lampiran +
                                    '"><i class="fa fa-eye"></i> Lihat</a>';
                            }

                            if (!value.id_spph && !value.nomor_spph) {
                                status = 'PR DONE , sedang proses SPPH';
                                toastr.info('Purchase Request dibuat, silahkan lanjutkan proses SPPH.');
                            } else if (value.id_spph && value.nomor_spph && !value.id_po) {
                                status = 'PROSES PO';
                            } else if (value.id_spph && value.nomor_spph && value
                                .id_po && value.no_po) {
                                status = 'COMPLETED';
                            }
                            $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + kode_material +
                                '</td><td>' + value.uraian + '</td><td>' +
                                value
                                .spek + '</td><td>' + value.qty + '</td><td>' + value
                                .satuan + '</td><td>' + value.waktu + '</td><td>' +
                                lampiran + '</td><td>' + keterangan + '</td><td><b>' +
                                status + '</td><td>' + editButton + deleteButton +
                                '</td></tr>');
                        });
                    }
                }
            });
        }


        function updateData(formData) {
            // Lakukan operasi insert data
            // Misalnya, Anda dapat menggunakan AJAX untuk mengirim permintaan ke backend
            // atau menggunakan fungsi JavaScript lainnya yang sesuai dengan logika aplikasi Anda
            $.ajax({
                url: "{{ url('products/purchase_request/update_detail') }}", // Ganti URL sesuai dengan endpoint untuk operasi insert
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#table-pr').append('<tr><td colspan="15" class="text-center">Loading...</td></tr>');
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
                    // $('#detail-pr').find('#container-product').removeClass('d-none');
                    // $('#detail-pr').find('#container-product').addClass('col-5');
                    // $('#detail-pr').find('#container-form').removeClass('col-12');
                    // $('#detail-pr').find('#container-form').addClass('col-7');
                    var no = 1;

                    if (data.pr.details.length == 0) {
                        $('#table-pr').empty();
                        $('#table-pr').append(
                            '<tr><td colspan="15" class="text-center">Tidak ada produk</td></tr>'
                        ); // Tambahkan pesan bahwa tidak ada produk
                    } else {
                        $('#table-pr').empty();
                        $.each(data.pr.details, function(key, value) {
                            console.log(value)
                            var rowIndex = key + 1;
                            var editButton =
                                '<button type="button" class="btn btn-success btn-xs mr-1" data-row-id="' +
                                value.id + '" title="Edit" onclick="editRow(\'' + value.id + '\', \'' +
                                value.kode_material + '\', \'' + value.uraian + '\', \'' + value
                                .spek + '\', \'' + value.qty +
                                '\', \'' + value.satuan + '\', \'' + value.waktu + '\', \'' + value
                                .lampiran +
                                '\', \'' + value.keterangan + '\', \'' + value.status +
                                '\')"><i class="fas fa-edit"></i></button>';


                            var deleteButton =
                                '<button type="button" class="btn btn-danger btn-xs mr-1"' +
                                ' onclick="deleteDetail(' + value.id + ', \'' + value.uraian
                                .toString() + '\')"' +
                                ' title="Delete">' +
                                '<i class="fas fa-trash"></i>' +
                                '</button>';

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

                            var keterangan;
                            if (value.keterangan == null) {
                                keterangan = '';
                            } else {
                                keterangan = value.keterangan
                            }
                            var kode_material;
                            if (value.kode_material == null) {
                                kode_material = '';
                            } else {
                                kode_material = value.kode_material
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
                                status = 'PR DONE , sedang proses SPPH';
                            } else if (value.id_spph && value.nomor_spph && !value.id_po) {
                                status = 'PROSES PO';
                            } else if (value.id_spph && value.nomor_spph && value
                                .id_po && value.no_po) {
                                status = 'COMPLETED';
                            }
                            $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + kode_material +
                                '</td><td>' + value.uraian + '</td><td>' +
                                value
                                .spek + '</td><td>' + value.qty + '</td><td>' + value
                                .satuan + '</td><td>' + value.waktu + '</td><td>' +
                                lampiran + '</td><td>' + keterangan + '</td><td><b>' +
                                status + '</td><td>' + editButton + deleteButton +
                                '</td></tr>');
                        });
                    }
                }
            });
        }

        function deleteDetail(id, uraian) {
            if (confirm('Apakah Anda yakin ingin menghapus item dengan nama komponen: ' + uraian + '?')) {
                $.ajax({
                    url: 'detail_purchase_request/' + id + '/delete',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Pastikan token CSRF sudah disediakan di dalam template Anda
                    },
                    success: function(result) {
                        // Menghapus baris dari tabel
                        $('button[data-id="' + result.deletedId + '"]').closest('tr').remove();
                        // alert(result.success); // Tampilkan pesan sukses
                        // alert("Nilai id_pr adalah: " + id_pr);
                        // alert(result.id_pr);
                        $.ajax({
                            url: "{{ url('products/purchase_request_detail') }}" + "/" + result.id_pr,
                            type: "GET",
                            dataType: "json",
                            beforeSend: function() {
                                $('#table-pr').append(
                                    '<tr><td colspan="15" class="text-center">Loading...</td></tr>'
                                );
                                $('#button-cetak-pr').html(
                                    '<i class="fas fa-spinner fa-spin"></i> Loading...');
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
                                        '<tr><td colspan="15" class="text-center">Tidak ada produk</td></tr>'
                                    ); // Tambahkan pesan bahwa tidak ada produk
                                } else {
                                    $('#table-pr').empty();
                                    $.each(data.pr.details, function(key, value) {
                                        console.log(value)
                                        var rowIndex = key + 1;
                                        var editButton =
                                            '<button type="button" class="btn btn-success btn-xs mr-1" data-row-id="' +
                                            value.id +
                                            '" title="Edit" onclick="editRow(\'' + value
                                            .id + '\', \'' +
                                            value.kode_material + '\', \'' + value.uraian +
                                            '\', \'' + value
                                            .spek + '\', \'' + value.qty +
                                            '\', \'' + value.satuan + '\', \'' + value
                                            .waktu + '\', \'' + value
                                            .lampiran +
                                            '\', \'' + value.keterangan +
                                            '\')"><i class="fas fa-edit"></i></button>';


                                        var deleteButton =
                                            '<button type="button" class="btn btn-danger btn-xs mr-1"' +
                                            ' onclick="deleteDetail(' + value.id + ', \'' +
                                            value.uraian
                                            .toString() + '\')"' +
                                            ' title="Delete">' +
                                            '<i class="fas fa-trash"></i>' +
                                            '</button>';

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
                                            lampiran = '<a href="' + urlLampiran + '/' +
                                                value.lampiran +
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
                                            status = 'PR DONE , sedang proses SPPH';
                                        } else if (value.id_spph && value.nomor_spph && !
                                            value.id_po) {
                                            status = 'PROSES PO';
                                        } else if (value.id_spph && value.nomor_spph &&
                                            value
                                            .id_po && value.no_po) {
                                            status = 'COMPLETED';
                                        }
                                        $('#table-pr').append('<tr><td>' + (key + 1) +
                                            '</td><td>' + value
                                            .kode_material + '</td><td>' + value
                                            .uraian + '</td><td>' +
                                            value
                                            .spek + '</td><td>' + value.qty +
                                            '</td><td>' + value
                                            .satuan + '</td><td>' + value.waktu +
                                            '</td><td>' +
                                            lampiran + '</td><td>' + value.keterangan +
                                            '</td><td><b>' +
                                            status + '</td><td>' + editButton +
                                            deleteButton +
                                            '</td></tr>');
                                    });
                                }
                            }
                        });













                    },
                    error: function(err) {
                        alert('Terjadi kesalahan saat menghapus item');
                    }
                });



            }
        }


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
            $('#no_surat').text(data.no_pr);
            $('#tgl_surat').text(data.tanggal);
            $('#proyek').text(data.proyek);
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
                url: "{{ url('products/purchase_request_detail') }}" + "/" + data.id,
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
                    $('#no_surat').text(data.pr.no_pr);
                    $('#tgl_surat').text(data.pr.tanggal);
                    $('#proyek').text(data.pr.proyek);
                    $('#button-cetak-pr').html('<i class="fas fa-print"></i> Cetak');
                    $('#button-cetak-pr').attr('disabled', false);
                    var no = 1;

                    if (data.pr.details.length == 0) {
                        $('#table-pr').empty();
                        $('#table-pr').append(
                            '<tr><td colspan="15" class="text-center">Tidak ada produk</td></tr>'
                        ); // Tambahkan pesan bahwa tidak ada produk
                    } else {
                        $('#table-pr').empty();
                        $.each(data.pr.details, function(key, value) {
                            console.log(value)
                            var rowIndex = key + 1;
                            var editButton =
                                '<button type="button" class="btn btn-success btn-xs mr-1" data-row-id="' +
                                value.id + '" title="Edit" onclick="editRow(\'' + value.id + '\', \'' +
                                value.kode_material + '\', \'' + value.uraian + '\', \'' + value
                                .spek + '\', \'' + value.qty +
                                '\', \'' + value.satuan + '\', \'' + value.waktu + '\', \'' + value
                                .lampiran +
                                '\', \'' + value.keterangan +
                                '\')"><i class="fas fa-edit"></i></button>';


                            var deleteButton =
                                '<button type="button" class="btn btn-danger btn-xs mr-1"' +
                                ' onclick="deleteDetail(' + value.id + ', \'' + value.uraian
                                .toString() + '\')"' +
                                ' title="Delete">' +
                                '<i class="fas fa-trash"></i>' +
                                '</button>';

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
                                status = 'PR DONE , sedang proses SPPH';
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
                                .satuan + '</td><td>' + value.waktu + '</td><td>' +
                                lampiran + '</td><td>' + value.keterangan + '</td><td><b>' +
                                status + '</td><td>' + editButton + deleteButton +
                                '</td></tr>');
                        });
                    }
                }
            });
        }




        function editRow(id, kode_material, uraian, spek, qty, satuan, waktu, lampiran, keterangan) {
            console.log(id, kode_material, uraian, spek, qty, satuan, waktu, lampiran, keterangan);
            resetForm();
            $('#modal-title').text("Edit Detail");
            $('#button-update-pr').text("Simpan");
            $('#button-update-pr').off('click');
            $('#button-update-pr').on('click', function() {
                // Tangani event klik di sini
                PRupdate();
            });

            $('#id').val(id);
            // $('#kode_tempat').val(data.kode_tempat);
            $('#material_kode').val(kode_material) // Mengosongkan nilai input dengan ID 'kode_material'
            $('#pname').val(uraian) // Mengosongkan nilai input dengan ID 'kode_material'
            $('#spek').val(spek); // Mengosongkan nilai input dengan ID 'desc_material'
            $('#stock').val(qty); // Mengosongkan nilai input dengan ID 'spek'
            $('#waktu').val(waktu); // Mengosongkan nilai input dengan ID 'p1'
            $('#satuan').val(satuan); // Mengosongkan nilai input dengan ID 'p3'
            // $('#lampiran').val(lampiran); // Mengosongkan nilai input dengan ID 'p3'
            // $('#lampiran-label').text(lampiran);
            $('#keterangan').val(keterangan);
            if (keterangan === 'null') {
                $('#keterangan').val('');
                // alert(keterangan);
            }
            if (kode_material === 'null') {
                $('#material_kode').val('');
                // alert(keterangan);
            }


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


        // function PRupdate() {
        //     const id = $('#pr_id').val()

        //     var inputFile = $("#lampiran")[0].files[0];
        //     var formData = new FormData();
        //     formData.append('lampiran', inputFile);
        //     formData.append('_token', '{{ csrf_token() }}');
        //     formData.append('id_pr', id);
        //     formData.append('id_proyek', $('#proyek_id_val').val());
        //     formData.append('kode_material', $('#material_kode').val());
        //     formData.append('uraian', $('#pname').val());
        //     formData.append('stock', $('#stock').val());
        //     formData.append('spek', $('#spek').val());
        //     formData.append('satuan', $('#satuan').val());
        //     formData.append('waktu', $('#waktu').val());
        //     formData.append('keterangan', $('#keterangan').val());

        //     if ($('#waktu').val() == null || $('#waktu').val() == "") {
        //         toastr.error("Waktu Penyelesaian belum diisi!");
        //         return
        //     }

        //     // if (inputFile == null) {
        //     //     toastr.error("Lampiran belum diisi!");
        //     //     return
        //     // }

        //     // if (inputFile.type != "application/pdf") {
        //     //     toastr.error("Lampiran harus berupa file PDF!");
        //     //     return
        //     // }

        //     $.ajax({
        //         url: "{{ url('products/update_purchase_request_detail') }}",
        //         type: "POST",
        //         data: formData,
        //         contentType: false,
        //         processData: false,
        //         beforeSend: function() {
        //             $('#button-update-pr').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
        //             $('#button-update-pr').attr('disabled', true);
        //         },
        //         success: function(data) {
        //             if (!data.success) {
        //                 toastr.error(data.message);
        //                 $('#button-update-pr').html('Tambahkan');
        //                 $('#button-update-pr').attr('disabled', false);
        //                 return
        //             }
        //             $('#id').val(data.pr.id);
        //             $('#no_surat').text(data.pr.no_pr);
        //             $('#tgl_surat').text(data.pr.tanggal);
        //             $('#proyek').text(data.pr.proyek);
        //             $('#button-update-pr').html('Tambahkan');
        //             $('#button-update-pr').attr('disabled', false);
        //             clearForm();
        //             if (data.pr.details.length == 0) {
        //                 $('#table-pr').append(
        //                     '<tr><td colspan="15" class="text-center">Tidak ada produk</td></tr>');
        //             } else {
        //                 $('#table-pr').empty();
        //                 $.each(data.pr.details, function(key, value) {
        //                     var urlLampiran = "{{ asset('lampiran') }}";
        //                     var status, spph, po;
        //                     if (!value.id_spph) {
        //                         spph = '-';
        //                     } else {
        //                         spph = value.nomor_spph
        //                     }

        //                     if (!value.id_po) {
        //                         po = '-';
        //                     } else {
        //                         po = value.no_po
        //                     }
        //                     var lampiran = null;
        //                     if (value.lampiran == null) {
        //                         lampiran = '-';
        //                     } else {
        //                         lampiran = '<a href="' + urlLampiran + '/' + value.lampiran +
        //                             '"><i class="fa fa-eye"></i> Lihat</a>';
        //                     }
        //                     //0 = Lakukan SPPH, 1 = Lakukan PO, 2 = Completed, 3 = Negosiasi, 4 = Justifikasi
        //                     // if (value.status == 0 || !value.status) {
        //                     //     status = 'Lakukan SPPH';
        //                     // } else if (value.status == 1) {
        //                     //     status = 'Lakukan PO';
        //                     // } else if (value.status == 2) {
        //                     //     status = 'COMPLETED';
        //                     // } else if (value.status == 3) {
        //                     //     status = 'NEGOSIASI';
        //                     // } else if (value.status == 4) {
        //                     //     status = 'JUSTIFIKASI';
        //                     // }

        //                     // if (!value.id_spph) {
        //                     //     status = 'Lakukan SPPH';
        //                     // } else if (value.id_spph && !value.no_sph) {
        //                     //     status = 'Lakukan SPH';
        //                     // } else if (value.id_spph && value.no_sph && !value.no_just) {
        //                     //     status = 'Lakukan Justifikasi';
        //                     // } else if (value.id_spph && value.no_sph && value.no_just && !value.id_po) {
        //                     //     status = 'Lakukan Nego/PO';
        //                     // } else if (value.id_spph && value.no_sph && value
        //                     //     .id_po) {
        //                     //     status = 'COMPLETED';
        //                     // }

        //                     if (!value.id_spph && !value.nomor_spph) {
        //                         status = 'Lakukan SPPH';
        //                     } else if (value.id_spph && value.nomor_spph && !value.id_po) {
        //                         status = 'PROSES PO';
        //                     } else if (value.id_spph && value.nomor_spph && value
        //                         .id_po && value.no_po) {
        //                         status = 'COMPLETED';
        //                     }


        //                     $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + value
        //                         .kode_material + '</td><td>' + value.uraian + '</td><td>' +
        //                         value
        //                         .spek + '</td><td>' + value.qty + '</td><td>' + value
        //                         .satuan +
        //                         '</td><td>' + value.waktu + '</td><td>' +
        //                         lampiran +
        //                         '</td><td>' + value.keterangan + '</td><td>' + status +
        //                             '<td><button class="btn btn-primary btn-sm btnEdit">Edit</button></td>' +
        //                         '<td><button class="btn btn-danger btn-sm btnDelete">Delete</button></td>' +
        //                         '</b></td></tr>'
        //                         // + <td>' + spph + '</td><td>' + value.sph +
        //                         // '</td><td>' + po +
        //                         // '</td><td>' +
        //                         // status + '</td> +
        //                     );
        //                 });
        //             }
        //         }
        //     });
        // }

        // // on modal #detail-pr open
        // $('#detail-pr').on('show.bs.modal', function(event) {
        //     var button = $(event.relatedTarget);
        //     var data = button.data('detail');
        //     console.log(data);
        //     lihatPR(data);
        // });

        // function lihatPR(data) {
        //     emptyTableProducts();
        //     clearForm()
        //     $('#modal-title').text("Detail Request");
        //     $('#button-save').text("Cetak");
        //     resetForm();
        //     $('#button-tambah-produk').text('Tambah Item Detail');
        //     $('#id').val(data.id);
        //     $('#no_surat').text(data.no_pr);
        //     $('#tgl_surat').text(data.tanggal);
        //     $('#proyek').text(data.proyek);
        //     $('#proyek_id_val').val(data.proyek_id);
        //     $('#pr_id').val(data.id);
        //     $('#table-pr').empty();

        //     //#button-tambah-produk disabled when editable is false
        //     if (data.editable == 0) {
        //         $('#button-tambah-produk').attr('disabled', true);
        //     } else {
        //         $('#button-tambah-produk').attr('disabled', false);
        //     }

        //     $.ajax({
        //         url: "{{ url('products/purchase_request_detail') }}" + "/" + data.id,
        //         type: "GET",
        //         dataType: "json",
        //         beforeSend: function() {
        //             $('#table-pr').append('<tr><td colspan="15" class="text-center">Loading...</td></tr>');
        //             $('#button-cetak-pr').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
        //             $('#button-cetak-pr').attr('disabled', true);
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             $('#id').val(data.pr.id);
        //             $('#no_surat').text(data.pr.no_pr);
        //             $('#tgl_surat').text(data.pr.tanggal);
        //             $('#proyek').text(data.pr.proyek);
        //             $('#button-cetak-pr').html('<i class="fas fa-print"></i> Cetak');
        //             $('#button-cetak-pr').attr('disabled', false);
        //             var no = 1;

        //             if (data.pr.details.length == 0) {
        //                 $('#table-pr').empty();
        //                 $('#table-pr').append(
        //                     '<tr><td colspan="15" class="text-center">Tidak ada produk</td></tr>');
        //             } else {
        //                 $('#table-pr').empty();
        //                 $.each(data.pr.details, function(key, value) {
        //                     var status, spph, po;
        //                     var urlLampiran = "{{ asset('lampiran') }}";
        //                     if (!value.id_spph) {
        //                         spph = '-';
        //                     } else {
        //                         spph = value.nomor_spph
        //                     }

        //                     if (!value.id_po) {
        //                         po = '-';
        //                     } else {
        //                         po = value.no_po
        //                     }

        //                     var lampiran = null;
        //                     if (value.lampiran == null) {
        //                         lampiran = '-';
        //                     } else {
        //                         lampiran = '<a href="' + urlLampiran + '/' + value.lampiran +
        //                             '"><i class="fa fa-eye"></i> Lihat</a>';
        //                     }

        //                     //0 = Lakukan SPPH, 1 = Lakukan PO, 2 = Completed
        //                     // if (value.status == 0 || !value.status) {
        //                     //     status = 'Lakukan SPPH';
        //                     // } else if (value.status == 1) {
        //                     //     status = 'Lakukan PO';
        //                     // } else if (value.status == 2) {
        //                     //     status = 'COMPLETED';
        //                     // } else if (value.status == 3) {
        //                     //     status = 'NEGOSIASI';
        //                     // } else if (value.status == 4) {
        //                     //     status = 'JUSTIFIKASI';
        //                     // }
        //                     // if (!value.id_spph) {
        //                     //     status = 'Lakukan SPPH';
        //                     // } else if (value.id_spph && !value.no_sph) {
        //                     //     status = 'Lakukan SPH';
        //                     // } else if (value.id_spph && value.no_sph && !value.no_just) {
        //                     //     status = 'Lakukan Justifikasi';
        //                     // } else if (value.id_spph && value.no_sph && value.no_just && !value.id_po) {
        //                     //     status = 'Lakukan Nego/PO';
        //                     // } else if (value.id_spph && value.no_sph && value
        //                     //     .id_po) {
        //                     //     status = 'COMPLETED';
        //                     // }

        //                     if (!value.id_spph && !value.nomor_spph) {
        //                         status = 'Lakukan SPPH';
        //                     } else if (value.id_spph && value.nomor_spph && !value.id_po) {
        //                         status = 'PROSES PO';
        //                     } else if (value.id_spph && value.nomor_spph && value
        //                         .id_po && value.no_po) {
        //                         status = 'COMPLETED';
        //                     }

        //                     $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + value
        //                         .kode_material + '</td><td>' + value.uraian + '</td><td>' +
        //                         value
        //                         .spek + '</td><td>' + value.qty + '</td><td>' + value
        //                         .satuan + '</td><td>' + value.waktu + '</td><td>' +
        //                         lampiran + '</td><td>' + value.keterangan + '</td><td><b>' +
        //                         status +
        //                         '<td><button class="btn btn-primary btn-sm btnEdit" data-id="' + value.id + '">Edit</button></td>' +
        //                         '<td><button class="btn btn-danger btn-sm btnDelete" data-id="' + value.id + '">Delete</button></td>' +
        //                         '</b></td></tr>'

        //                         // + <td>' + spph +
        //                         // '</td><td>' + po + '</td><td>' + status + '</td> +

        //                     );
        //                 });
        //             }
        //             //remove loading
        //             // $('#table-pr').find('tr:first').remove();
        //         }
        //     });
        // }

        // Handler klik tombol Edit
        // $(document).on('click', '.btnEdit', function() {
        //     var id = $(this).data('id');
        //     var row = $(this).closest('tr');

        //     // Ambil data dari baris dan masukkan ke dalam modal
        //     $('#editKodeMaterial').val(row.find('td:eq(2)').text());
        //     $('#editUraian').val(row.find('td:eq(3)').text());
        //     $('#editSpek').val(row.find('td:eq(4)').text());
        //     $('#editQty').val(row.find('td:eq(5)').text());
        //     $('#editSatuan').val(row.find('td:eq(6)').text());
        //     $('#editWaktu').val(row.find('td:eq(7)').text());
        //     $('#editLampiran').val(row.find('td:eq(8)').text());
        //     $('#editKeterangan').val(row.find('td:eq(9)').text());


        //     // Simpan ID item di modal untuk digunakan saat submit
        //     $('#editForm').data('id', id);
        //     $('#editModal').modal('show');
        // });

        // Handler klik tombol Delete
        $(document).on('click', '.btnDelete', function() {
            var id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                $.ajax({
                    url: 'products/purchase_request/delete_detail/{id}' + id,
                    type: 'DELETE',
                    success: function(result) {
                        // Menghapus baris dari tabel
                        $('button[data-id="' + id + '"]').closest('tr').remove();
                    },
                    error: function(err) {
                        alert('Terjadi kesalahan saat menghapus item');
                    }
                });
            }
        });

        // $(document).on('submit', '#editForm', function(e) {
        //     e.preventDefault();
        //     var id = $('#editForm').data('id');
        //     var formData = $(this).serialize();

        //     $.ajax({
        //         url: '/products/' + id,
        //         type: 'PUT',
        //         data: formData,
        //         success: function(result) {
        //             // Perbarui baris tabel dengan data baru
        //             var row = $('button[data-id="' + id + '"]').closest('tr');
        //             row.find('td:eq(2)').text($('#editKodeMaterial').val());
        //             row.find('td:eq(3)').text($('#editUraian').val());
        //             row.find('td:eq(4)').text($('#editSpek').val());
        //             row.find('td:eq(5)').text($('#editQty').val());
        //             row.find('td:eq(6)').text($('#editSatuan').val());
        //             row.find('td:eq(7)').text($('#editWaktu').val());
        //             row.find('td:eq(8)').text($('#editLampiran').val());
        //             row.find('td:eq(9)').text($('#editKeterangan').val());

        //             $('#editModal').modal('hide');
        //         },
        //         error: function(err) {
        //             alert('Terjadi kesalahan saat mengubah item');
        //         }
        //     });
        // });

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
