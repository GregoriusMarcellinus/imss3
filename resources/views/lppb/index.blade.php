@extends('layouts.main')
@section('title', __('LPPB'))
@section('custom-css')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
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
                    {{-- <form id="cetak-lppb" action="{{ route('cetak_lppb') }}" method="GET">
                        <input type="hidden" name="data" id="data-input">
                    </form> --}}

                    {{-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-po"
                        onclick="document.getElementById('cetak-lppb').submit();"><i class="fas fa-print"></i> Cetak
                        LPPB</button> --}}
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
                    {{-- <table id="table" class="table table-sm table-bordered table-hover table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>{{ __('No PR') }}</th>
                                <th>{{ __('No PO') }}</th>
                                <th>{{ __('Jenis PO') }}</th>
                                <th>{{ __('Kode Material') }}</th>
                                <th>{{ __('Nama Barang') }}</th>
                                <th>{{ __('Spesifikasi') }}</th>
                                <th>{{ __('QTY') }}</th>
                                <th>{{ __('Satuan') }}</th>
                                <th>{{ __('Diterima Ekspedisi') }}</th>
                                <th>{{ __('Nama Proyek') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $key => $d)
                                @php
                                    $data = $d->toArray();
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $items->firstItem() + $key }}</td>
                                    <td>
                                        {{ $d->no_pr }}
                                    </td>
                                    <td>{{ $d->no_po }}</td>
                                    <td>{{ $d->tipe }}</td>
                                    <td>{{ $d->kode_material }}</td>
                                    <td>{{ $d->uraian }}</td>
                                    <td>{{ $d->spek }}</td>
                                    <td>{{ $d->qty }}</td>
                                    <td>{{ $d->satuan }}</td>
                                    <td>{{ $d->diterima_ekspedisi }}</td>
                                    <td>{{ $d->nama_proyek }}</td>
                                    <td class="text-center">
                                        @if (Auth::user()->role == 0 || Auth::user()->role == 8)
                                            @if (!$d->diterima)
                                                <button title="Accept Barang" type="button" class="btn btn-success btn-xs"
                                                    data-toggle="modal" data-target="#accept-barang"
                                                    onclick="acceptBarang({{ json_encode($data) }})"><i
                                                        class="fas fa-check"></i></button>
                                            @else
                                                <button title="Edit Barang" type="button" class="btn btn-primary btn-xs"
                                                    data-toggle="modal" data-target="#edit-barang"
                                                    onclick="editBarang({{ json_encode($data) }})"><i
                                                        class="fas fa-edit"></i></button>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button title="Accept Barang" type="button" class="btn btn-success btn-xs"
                                            data-toggle="modal" data-target="#accept-barang"
                                            onclick="submitLppbWithData({{ json_encode($data) }})"><i
                                                class="fas fa-print"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="7">{{ __('No data.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table> --}}
                    <table id="table" class="table table-sm table-bordered table-hover table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>{{ __('Nomor LPPB') }}</th>
                                <th>{{ __('Tanggal LPPB') }}</th>
                                <th>{{ __('No PR') }}</th>
                                <th>{{ __('No PO') }}</th>
                                <th>{{ __('Jenis PO') }}</th>
                                <th>{{ __('Aksi') }}</th>
                                {{-- <th>{{ __('Kode Material') }}</th>
                                <th>{{ __('Nama Barang') }}</th>
                                <th>{{ __('Spesifikasi') }}</th>
                                <th>{{ __('QTY') }}</th>
                                <th>{{ __('Satuan') }}</th>
                                <th>{{ __('Nama Proyek') }}</th> --}}
                                {{-- <th></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $key => $d)
                                @php
                                    $data = $d->toArray();
                                    $detailPr = $data['detail_pr'][0] ?? null;
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $items->firstItem() + $key }}</td>
                                    <td class="text-center">
                                        {{ $d->nomor_lppb }}
                                    </td>
                                    <td class="text-center">
                                        @if ($d->tanggal_lppb)
                                            <?php
                                            $date = new DateTime($d->tanggal_lppb);
                                            echo $date->format('d M Y');
                                            ?>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        {{ $d->no_pr }}
                                    </td>
                                    <td class="text-center">
                                        {{ $d->no_po }}
                                    </td>
                                    <td class="text-center">{{ $d->tipe }}</td>
                                    {{-- <td>{{ $d->kode_material }}</td>
                                    <td>{{ $d->uraian }}</td>
                                    <td>{{ $d->spek }}</td>
                                    <td>{{ $d->qty }}</td>
                                    <td>{{ $d->satuan }}</td>
                                    <td>{{ $d->nama_proyek }}</td> --}}
                                    <td class="text-center">
                                        @if (Auth::user()->role == 0 || Auth::user()->role == 8)
                                            @if (!$d->diterima)
                                                {{-- <button title="Accept Barang" type="button" class="btn btn-success btn-xs"
                                                    data-toggle="modal" data-target="#accept-barang"
                                                    onclick="acceptBarang({{ json_encode($data) }})"><i
                                                        class="fas fa-check"></i></button> --}}
                                            @else
                                                <button title="Edit Barang" type="button" class="btn btn-primary btn-xs"
                                                    data-toggle="modal" data-target="#edit-barang"
                                                    onclick="editBarang({{ json_encode($data) }})"><i
                                                        class="fas fa-edit"></i></button>
                                            @endif
                                        @endif
                                        {{-- <button title="Edit Barang" type="button" class="btn btn-primary btn-xs"
                                            data-toggle="modal" data-target="#edit-barang"
                                            onclick="editBarang({{ json_encode($data) }})"><i
                                                class="fas fa-list"></i></button> --}}
                                        <button title="Edit Barang" type="button" class="btn btn-primary btn-xs"
                                            data-toggle="modal" data-target="#edit-barang"
                                            onclick="editBarang({{ json_encode($data) }})"><i
                                                class="fas fa-edit"></i></button>
                                        <button title="Lihat Detail" type="button" data-toggle="modal"
                                            data-target="#detail-pr" class="btn-lihat btn btn-info btn-xs"
                                            data-detail="{{ json_encode($data) }}"><i class="fas fa-list"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="7">{{ __('No data.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal fade" id="detail-pr">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="modal-title" class="modal-title">
                                {{ __('Detail Lembar Pemeriksaan Penerimaan Barang') }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <div class="row">
                                    <form id="cetak-lppb" method="GET" action="{{ route('cetak_lppb') }}"
                                        target="_blank">
                                        <input type="hidden" name="id" id="id">
                                    </form>
                                    <div class="col-12" id="container-form">
                                        <button id="button-cetak-lppb" type="button" class="btn btn-primary"
                                            onclick="document.getElementById('cetak-lppb').submit();">{{ __('Cetak') }}</button>
                                        <br>
                                        <div class="table-responsive">

                                            <table class="table table-bordered">
                                                <thead style="text-align: center">
                                                    <th>{{ __('No PR') }}</th>
                                                    <th>{{ __('No PO') }}</th>
                                                    <th>{{ __('Kode Material') }}</th>
                                                    <th>{{ __('Uraian') }}</th>
                                                    <th>{{ __('Spesifikasi') }}</th>
                                                    <th>{{ __('Qty') }}</th>
                                                    <th>{{ __('Satuan') }}</th>
                                                    <th>{{ __('Proyek') }}</th>
                                                    <th>{{ __('Qty Penerimaan') }}</th>
                                                    <th>{{ __('OK') }}</th>
                                                    <th>{{ __('NOK') }}</th>
                                                    <th>{{ __('Diterima') }}</th>
                                                    <th>{{ __('Belum Diterima') }}</th>
                                                    <th>{{ __('Tanggal Penerimaan') }}</th>
                                                    <th>{{ __('Aksi') }}</th>
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

                                        <div id="form" class="card">
                                            <div class="card-body">
                                                <form role="form" id="stock-update" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" id="id_pr" name="id_pr">
                                                    <input type="hidden" id="id_detail" name="id_detail">
                                                    <input type="hidden" id="type" name="type">
                                                    <input type="hidden" id="no_po" name="no_po">
                                                    <input type="hidden" id="nama_proyek" name="nama_proyek">
                                                    <input type="hidden" id="proyek_id_val" name="proyek_id_val">
                                                    <div class="form-group row">
                                                        <label for="no_nota"
                                                            class="col-sm-4 col-form-label">{{ __('QTY Terima') }}</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="qtyp"
                                                                name="qtyp">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="no_nota"
                                                            class="col-sm-4 col-form-label">{{ __('OK') }}</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="ok"
                                                                name="ok">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="no_nota"
                                                            class="col-sm-4 col-form-label">{{ __('NOK') }}</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="nok"
                                                                name="nok">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="no_nota"
                                                            class="col-sm-4 col-form-label">{{ __('Sudah Diterima') }}</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="sdh_qc"
                                                                name="sdh_qc">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="no_nota"
                                                            class="col-sm-4 col-form-label">{{ __('Belum Diterima') }}</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="blm"
                                                                name="blm">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="no_nota"
                                                            class="col-sm-4 col-form-label">{{ __('Tanggal Diterima') }}</label>
                                                        <div class="col-sm-8">
                                                            <input type="date" class="form-control" id="tgld"
                                                                name="tgld">
                                                        </div>
                                                    </div>
                                                </form>
                                                <button id="button-tambah-detail" type="button"
                                                    class="btn btn-info w-100"
                                                    onclick="hilang()">{{ __('kembali') }}</button>
                                                <br><br>
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
            <div>
                {{ $items->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @if (Auth::user()->role == 0 || Auth::user()->role == 9)
            <div class="modal fade" id="accept-barang">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="modal-title" class="modal-title">{{ __('Pemeriksaan & Penerimaan Barang') }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" id="save" action="{{ route('lppb.save') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="id_barang" name="id_barang">
                                <input type="hidden" id="id_registrasi_barang" name="id_registrasi_barang">
                                <div class="form-group row">
                                    <label for="nama_barang"
                                        class="col-sm-4 col-form-label">{{ __('Nama Barang') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kuantitas_po"
                                        class="col-sm-4 col-form-label">{{ __('Kuantitas PO') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="kuantitas_po" name="kuantitas_po"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kuantitas_penerimaan"
                                        class="col-sm-4 col-form-label">{{ __('Kuantitas Penerimaan') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="kuantitas_penerimaan"
                                            name="kuantitas_penerimaan">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="baik" class="col-sm-4 col-form-label">{{ __('Baik (OK)') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="baik" name="baik">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tidak_baik"
                                        class="col-sm-4 col-form-label">{{ __('Tidak Baik (NOK)') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="tidak_baik" name="tidak_baik">
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <label for="keterangan"
                                        class="col-sm-4 col-form-label">{{ __('Keterangan') }}</label>
                                    <div class="col-sm-8">
                                        <textarea type="text" class="form-control" id="keterangan" name="keterangan"></textarea>
                                    </div>
                                </div> --}}
                            </form>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{ __('Cancel') }}</button>
                            <button id="button-save" type="button" class="btn btn-primary"
                                onclick="$('#save').submit();">{{ __('Simpan') }}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edit-barang">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="modal-title" class="modal-title">{{ __('Konfirmasi Barang') }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" id="edit-registrasi-btn" action="{{ route('nomor_lppb.edit') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="id_prr" name="id_prr">
                                <div class="form-group row">
                                    <label for="nomor_lppb"
                                        class="col-sm-4 col-form-label">{{ __('Nomor LPPB') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nomor_lppb" name="nomor_lppb">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tanggal_lppb"
                                        class="col-sm-4 col-form-label">{{ __('Tanggal LPPB') }}</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" id="tanggal_lppb"
                                            name="tanggal_lppb">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{ __('Cancel') }}</button>
                            <button id="button-save" type="button" class="btn btn-primary"
                                onclick="$('#edit-registrasi-btn').submit();">{{ __('Simpan') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection
@section('custom-js')
    <script>
        // function submitLppbWithData(data) {
        //     // Encode data to JSON string
        //     var jsonData = JSON.stringify(data);
        //     // Set the value of hidden input field
        //     document.getElementById('data-input').value = jsonData;
        //     // Submit the form
        //     document.getElementById('cetak-lppb').submit();
        // }

        function resetForm() {
            $('#id_barang').val('');
            $('#nama_barang').val('');
            $('#keterangan').val('');
        }

        function acceptBarang(data) {
            resetForm();
            console.log(data);
            //find accept-barang modal then find #id_barang, #nama_barang
            // $('#id_barang').val(data.id);
            // $('#nama_barang').val(data.uraian);
            $('#accept-barang').find('#id_barang').val(data.id);
            $('#accept-barang').find('#id_registrasi_barang').val(data.id_registrasi_barang);
            $('#accept-barang').find('#nama_barang').val(data.uraian);
            $('#accept-barang').find('#kuantitas_po').val(data.qty);
        }

        function hilang() {
            $('#detail-pr').find('#container-product').removeClass('col-5');
            $('#detail-pr').find('#container-product').addClass('d-none');
            $('#detail-pr').find('#container-form').addClass('col-12');
            $('#detail-pr').find('#container-form').removeClass('col-7');
        }

        function editBarang(data) {
            $('#edit-barang').find('#modal-title').text("Edit Nomor & Tanggal LPPB");
            resetForm();
            console.log(data);
            //find edit-barang modal then find #id_barang, #nama_barang
            // $('#id_barang').val(data.id);
            // $('#nama_barang').val(data.uraian);
            // $('#keterangan').val(data.keterangan);
            $('#edit-barang').find('#id_prr').val(data.id);
            $('#edit-barang').find('#nomor_lppb').val(data.nomor_lppb);
            $('#edit-barang').find('#tanggal_lppb').val(data.tanggal_lppb);
        }
        $('#detail-pr').on('show.bs.modal', function(event) {
            $('#detail-pr').find('#container-product').removeClass('col-5');
            $('#detail-pr').find('#container-product').addClass('d-none');
            $('#detail-pr').find('#container-form').addClass('col-12');
            $('#detail-pr').find('#container-form').removeClass('col-7');
            $('#button-tambah-detail').text('Kembali');
            var button = $(event.relatedTarget);
            var data = button.data('detail');
            // console.log(data);
            lihatPR(data);
        });


        //function detail LPPB
        function lihatPR(data) {
            $('#id').val(data.id);
            $('#no_surat').text(data.no_pr);
            $('#pr_id').val(data.id);
            $('#table-pr').empty();
            // alert($('#id').val());

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
                    $('#button-cetak-lppb').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#button-cetak-lppb').attr('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#id').val(data.pr.id);
                    $('#button-cetak-lppb').html('<i class="fas fa-print"></i> Cetak');
                    $('#button-cetak-lppb').attr('disabled', false);
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
                            var qtyp, ok, nok;
                            if (!value.penerimaan) {
                                qtyp = '-';
                            } else {
                                qtyp = value.penerimaan
                            }
                            if (!value.hasil_ok) {
                                ok = '-';
                            } else {
                                ok = value.hasil_ok
                            }
                            if (!value.hasil_nok) {
                                nok = '-';
                            } else {
                                nok = value.hasil_nok
                            }
                            if (!value.diterima_qc) {
                                terima_qc = '-';
                            } else {
                                terima_qc = value.diterima_qc
                            }
                            if (!value.belum_diterima_qc) {
                                belum_terima_qc = '-';
                            } else {
                                belum_terima_qc = value.belum_diterima_qc
                            }
                            if (!value.tgl_diterima) {
                                tgl_tampil = '-';
                            } else {
                                // Mendapatkan tanggal dari value.tgl_diterima
                                var date = new Date(value.tgl_diterima);

                                // Membuat array nama bulan
                                var monthNames = [
                                    "Januari", "Februari", "Maret",
                                    "April", "Mei", "Juni", "Juli",
                                    "Agustus", "September", "Oktober",
                                    "November", "Desember"
                                ];

                                // Mendapatkan tanggal, bulan, dan tahun dari tanggal
                                var day = date.getDate();
                                var monthIndex = date.getMonth();
                                var year = date.getFullYear();

                                // Menggabungkan dalam format yang diinginkan
                                tgl_tampil = day + ' ' + monthNames[monthIndex] + ' ' + year;
                            }
                            if (!value.tgl_diterima) {
                                tgl_terima = '-';
                            } else {
                                tgl_terima = value.tgl_diterima
                            }
                            var editButton =
                                '<button type="button" class="btn btn-success btn-xs mr-1" data-row-id="' +
                                value.id + '" title="Edit" onclick="editRow(\'' + value.id + '\', \'' +
                                value.uraian + '\', \'' + value
                                .spek + '\', \'' + value.id_pr +
                                '\', \'' + qtyp + '\', \'' + ok + '\', \'' + nok +
                                '\',  \'' + value.no_po + '\',  \'' + data.pr.nama_proyek +
                                '\',  \'' + terima_qc +
                                '\',  \'' + belum_terima_qc +
                                '\',  \'' + tgl_terima +
                                '\',)"><i class="fas fa-edit"></i></button>';

                            $('#table-pr').append('<tr><td>' + data.pr.no_pr + '</td><td>' + value
                                .no_po + '</td><td>' + value.kode_material + '</td><td>' +
                                value
                                .uraian + '</td><td>' + value.spek + '</td><td>' + value
                                .qty + '</td><td>' + value.satuan + '</td><td>' + data.pr
                                .nama_proyek + '</td><td>' + qtyp +
                                '</td><td>' + ok + '</td><td>' + nok +
                                '</td><td>' + terima_qc +
                                '</td><td>' + belum_terima_qc +
                                '</td><td>' + tgl_tampil +
                                '</td><td>' + editButton + '</td></tr>');
                        });
                    }
                }
            });
        }
        //End function detail LPPB

        function editRow(id, uraian, spek, id_pr, qtyp, ok, nok, no_po, nama_proyek, terima_qc, belum_terima_qc,
            tgl_terima) {
            console.log(id, uraian, spek, id_pr, qtyp, ok, nok, no_po, nama_proyek, terima_qc, belum_terima_qc, tgl_terima);
            resetForm();
            $('#modal-title').text("Edit Detail");
            $('#button-update-pr').text("Simpan");
            $('#button-update-pr').off('click');
            $('#button-update-pr').on('click', function() {
                PRupdate();
            });

            // $('#id').val(id);
            $('#id_detail').val(id);
            $('#no_po').val(no_po);
            $('#nama_proyek').val(nama_proyek);
            $('#pname').val(uraian) // Mengosongkan nilai input dengan ID 'kode_material'
            $('#id_pr').val(id_pr); // Mengosongkan nilai input dengan ID 'desc_material'
            $('#qtyp').val(qtyp); // Mengosongkan nilai input dengan ID 'spek'
            $('#ok').val(ok); // Mengosongkan nilai input dengan ID 'spek'
            $('#nok').val(nok); // Mengosongkan nilai input dengan ID 'spek'
            $('#sdh_qc').val(terima_qc); // Mengosongkan nilai input dengan ID 'spek'
            $('#blm').val(belum_terima_qc); // Mengosongkan nilai input dengan ID 'spek'
            $('#tgld').val(tgl_terima); // Mengosongkan nilai input dengan ID 'spek'
            // $('#lampiran').val(lampiran); // Mengosongkan nilai input dengan ID 'p3'
            // $('#lampiran-label').text(lampiran);

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
            const id = $('#id').val()
            var formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            // formData.append('id', id);
            formData.append('no_po', $('#no_po').val());
            formData.append('nama_proyek', $('#nama_proyek').val());
            formData.append('id_pr', $('#id_pr').val());
            formData.append('id_detail', $('#id_detail').val());
            formData.append('penerimaan', $('#qtyp').val());
            formData.append('ok', $('#ok').val());
            formData.append('nok', $('#nok').val());
            formData.append('sdh_qc', $('#sdh_qc').val());
            formData.append('blm', $('#blm').val());
            formData.append('tgld', $('#tgld').val());
            console.log(formData);
            updateData(formData);
        }

        function updateData(formData) {
            $.ajax({
                url: "{{ url('products/lppb/editlppb') }}", // Ganti URL sesuai dengan endpoint untuk operasi insert
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#table-pr').append('<tr><td colspan="15" class="text-center">Loading...</td></tr>');
                    // $('#button-cetak-lppb').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    // $('#button-cetak-lppb').attr('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#id').val(data.pr.id);
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
                            var qtyp, ok, nok;
                            if (!value.penerimaan) {
                                qtyp = '-';
                            } else {
                                qtyp = value.penerimaan
                            }
                            if (!value.hasil_ok) {
                                ok = '-';
                            } else {
                                ok = value.hasil_ok
                            }
                            if (!value.hasil_nok) {
                                nok = '-';
                            } else {
                                nok = value.hasil_nok
                            }
                            if (!value.diterima_qc) {
                                terima_qc = '-';
                            } else {
                                terima_qc = value.diterima_qc
                            }
                            if (!value.belum_diterima_qc) {
                                belum_terima_qc = '-';
                            } else {
                                belum_terima_qc = value.belum_diterima_qc
                            }
                            if (!value.tgl_diterima) {
                                tgl_tampil = '-';
                            } else {
                                // Mendapatkan tanggal dari value.tgl_diterima
                                var date = new Date(value.tgl_diterima);

                                // Membuat array nama bulan
                                var monthNames = [
                                    "Januari", "Februari", "Maret",
                                    "April", "Mei", "Juni", "Juli",
                                    "Agustus", "September", "Oktober",
                                    "November", "Desember"
                                ];

                                // Mendapatkan tanggal, bulan, dan tahun dari tanggal
                                var day = date.getDate();
                                var monthIndex = date.getMonth();
                                var year = date.getFullYear();

                                // Menggabungkan dalam format yang diinginkan
                                tgl_tampil = day + ' ' + monthNames[monthIndex] + ' ' + year;
                            }
                            if (!value.tgl_diterima) {
                                tgl_terima = '-';
                            } else {
                                tgl_terima = value.tgl_diterima
                            }
                            var editButton =
                                '<button type="button" class="btn btn-success btn-xs mr-1" data-row-id="' +
                                value.id + '" title="Edit" onclick="editRow(\'' + value.id + '\', \'' +
                                value.uraian + '\', \'' + value
                                .spek + '\', \'' + value.id_pr +
                                '\', \'' + qtyp + '\', \'' + ok + '\', \'' + nok +
                                '\',  \'' + data.no_po + '\',  \'' + data.nama_proyek +
                                '\',  \'' + terima_qc +
                                '\',  \'' + belum_terima_qc +
                                '\',  \'' + tgl_terima +
                                '\',)"><i class="fas fa-edit"></i></button>';

                            $('#table-pr').append('<tr><td>' + data.pr.no_pr + '</td><td>' + data
                                .no_po + '</td><td>' + value.kode_material + '</td><td>' +
                                value
                                .uraian + '</td><td>' + value.spek + '</td><td>' + value
                                .qty + '</td><td>' + value.satuan + '</td><td>' + data
                                .nama_proyek + '</td><td>' + qtyp +
                                '</td><td>' + ok + '</td><td>' + nok +
                                '</td><td>' + terima_qc +
                                '</td><td>' + belum_terima_qc +
                                '</td><td>' + tgl_tampil +
                                '</td><td>' + editButton + '</td></tr>');
                        });
                    }
                }
            });
        }
    </script>
    <script src="/plugins/toastr/toastr.min.js"></script>
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
