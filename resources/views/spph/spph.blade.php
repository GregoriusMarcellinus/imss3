@extends('layouts.main')
@section('title', __('SPPH'))
@section('custom-css')
    <style>
        /* Important part */
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

                        {{-- Filter by Nomor Po dan Tanggal --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="filter-spph-no">Filter Nomor SPPH</label>
                                    <input type="text" class="form-control" id="filter-spph-no"
                                        placeholder="Masukkan Nomor spph">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="filter-spph-date">Filter Tanggal SPPH</label>
                                    <input type="date" class="form-control" id="filter-spph-date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-secondary mt-4" id="clear-filter">Clear Filter</button>
                            </div>
                        </div>
                        {{-- End Filter by Nomor Po dan Tanggal --}}

                        <table id="table" class="table table-sm table-bordered table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th>No.</th>
                                    <th>{{ __('Nomor SPPH') }}</th>
                                    <th>{{ __('Nomor PR') }}</th>
                                    <th>{{ __('Lampiran') }}</th>
                                    <th>{{ __('Perihal') }}</th>
                                    <th>{{ __('Tanggal SPPH') }}</th>
                                    <th>{{ __('Batas SPPH') }}</th>
                                    <th>{{ __('Vendor') }}</th>
                                    {{-- <th>{{ __('Penerima') }}</th> --}}
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($spphes) > 0)
                                    @foreach ($spphes as $key => $d)
                                        @php
                                            // $penerima = $d->penerima;
                                            // $penerima = json_decode($penerima);
                                            // $penerima = implode(', ', $penerima);
                                            $vendor = $d->vendor;
                                            $data = [
                                                'no' => $spphes->firstItem() + $key,
                                                'nomor_spph' => $d->nomor_spph,
                                                'id_pr' => $d->id_pr,
                                                'nomor_pr' => $d->nomor_pr,
                                                'lampiran' => $d->lampiran,
                                                'vendor_id' => $d->vendor_id,
                                                'vendor' => $vendor,
                                                'perihal' => $d->perihal,
                                                'tanggal' => date('d/m/Y', strtotime($d->tanggal_spph)),
                                                'batas' => date('d/m/Y', strtotime($d->batas_spph)),
                                                'penerima' => $d->penerima,
                                                'alamat' => $d->alamat,
                                                'id' => $d->id,
                                                'penerima_asli' => $d->penerima,
                                                'alamat_asli' => $d->alamat,
                                            ];
                                        @endphp

                                        <tr>
                                            <td class="text-center"><input type="checkbox" name="hapus[]"
                                                    value="{{ $d->id }}"></td>
                                            <td class="text-center">{{ $data['no'] }}</td>
                                            <td class="text-center">{{ $data['nomor_spph'] }}</td>
                                            <td class="text-center">{{ $data['nomor_pr'] }}</td>

                                            {{-- membuat lampiran lebih dari 1 --}}
                                            <td class="text-center">
                                                @php
                                                    // Memisahkan lampiran berdasarkan koma
                                                    $lampiran = explode(',', $d->lampiran);
                                                @endphp

                                                @if (!empty($lampiran) && is_array($lampiran) && count($lampiran) > 0)
                                                    @foreach ($lampiran as $index => $file)
                                                        @if (!empty($file))
                                                            <a href="{{ asset('lampiran/' . trim($file)) }}"
                                                                target="_blank">
                                                                <i class="fa fa-eye"></i> Lihat
                                                            </a>
                                                            @if ($index < count($lampiran) - 1)
                                                                <br>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            {{-- membuat lampiran lebih dari 1 --}}


                                            <td class="text-center">{{ $data['perihal'] }}</td>
                                            <td class="text-center">{{ $data['tanggal'] }}</td>
                                            <td class="text-center">{{ $data['batas'] }}</td>
                                            <td class="text-center">{{ $data['vendor'] }}</td>
                                            {{-- <td class="text-center">{{ $data['penerima'] }}</td> --}}
                                            <td class="text-center">
                                                <button title="Edit SPPH" type="button" class="btn btn-success btn-xs"
                                                    data-toggle="modal" data-target="#add-SPPH"
                                                    onclick="editSPPH({{ json_encode($data) }})"><i
                                                        class="fas fa-edit"></i></button>

                                                <button title="Lihat Detail" type="button" data-toggle="modal"
                                                    data-target="#detail-spph" class="btn-lihat btn btn-info btn-xs"
                                                    data-detail="{{ json_encode($data) }}"><i
                                                        class="fas fa-list"></i></button>
                                                @if (Auth::user()->role == 0 || Auth::user()->role == 1)
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
                                        <td colspan="9">{{ __('No data.') }}</td>
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
                        <form role="form" id="save" action="{{ route('spph.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="save_id" name="id">
                            <input type="hidden" id="id_pr" name="id_pr">
                            <input type="hidden" id="lampiran_awal" name="lampiran_awal">
                            <input type="hidden" id="nama_lampiran" name="nama_lampiran">
                            <div class="form-group row">
                                <label for="nomor_spph" class="col-sm-4 col-form-label">{{ __('Nomor SPPH') }} </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nomor_spph" name="nomor_spph">
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label for="lampiran" class="col-sm-4 col-form-label">{{ __('Lampiran') }}
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="lampiran" name="lampiran">
                                </div>
                            </div> --}}
                            {{-- <div class="form-group row">
                                <label for="vendor_id" class="col-sm-4 col-form-label">{{ __('Vendor') }} </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="vendor_id" name="vendor_id">
                                    <select class="form-control" id=
                                    "vendor_id" name="vendor_id">
                                        <option value="">Pilih Vendor</option>
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->id }}">{{ $vendor->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="form-group row">
                                <label for="nomor_pr" class="col-sm-4 col-form-label">{{ __('Nomor PR') }}
                                </label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="nomor_pr" id="nomor_pr">
                                    </select>
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

                            {{-- <h6>Penerima -- </h6>

                            <div id="penerima-row">

                            </div>

                            <a id="tambah" style="cursor: pointer">Tambah Penerima</a> --}}

                            <input type="text" id="data_lampiran" value="--" style="display: none">
                            <input type="text" id="data_vendor" value="--" style="display: none">
                            <h6 id="lampiran_text">Lampiran</h6>

                            <div id="lampiran-row">

                            </div>

                            <a id="tambah-lampiran" style="cursor: pointer">Tambah Lampiran</a>
                            <hr>

                            <h6 id="vendor_text">Vendor -- </h6>

                            <div id="vendor-row">

                            </div>

                            <a id="tambah" style="cursor: pointer">Tambah vendor</a>

                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button id="button-save" type="button" class="btn btn-primary"
                            onclick="setSaveIdAndSubmit();">{{ __('Tambahkan') }}</button>
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
                                            <td style="width: 3%;"><b>ID PR</b></td>
                                            <td style="width:2%">:</td>
                                            <td style="width: 55%"><span id="id_pr2"></span></td>
                                        </tr>
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
                                                <button id="button-tambah-produk" type="button"
                                                    class="btn btn-info mb-3">{{ __('Tambah Produk') }}</button>
                                            </td>
                                            {{-- <button title="Edit SPPH" type="button" class="btn btn-success btn-xs"
                                            data-toggle="modal" data-target="#add-SPPH"
                                            onclick="editSPPH({{ json_encode($data) }})"> --}}
                                        </tr>
                                    </table>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <th>NO</th>
                                                <th>Nama Barang</th>
                                                <th>Spesifikasi</th>
                                                <th>QTY</th>
                                                <th>Satuan</th>
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
                                            <button type="button" class="btn btn-primary mb-3"
                                                onclick="addToDetails()"></i>Tambah Pilihan</button>
                                            <div class="input-group input-group-lg">
                                                <input type="text" class="form-control" id="proyek_name"
                                                    name="proyek_name" placeholder="Search By Proyek">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" id="check-proyek"
                                                        onclick="productCheck()">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive card-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Pilih</th>
                                                        <th>Deskripsi</th>
                                                        <th>Spesifikasi</th>
                                                        <th>QTY</th>
                                                        <th>Sat</th>
                                                        <th>NO PR</th>
                                                        <th>No SPPH</th>
                                                        <th>Proyek</th>

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

        //function delete checkbox
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
                    url: 'spph-imss/hapus-multiple',
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

        //Filter by Nomor dan tgl SPPH
        $(document).ready(function() {

            $('#clear-filter').on('click', function() {
                $('#filter-spph-no, #filter-spph-date').val('');
                filterTable();
            });


            $("#nomor_pr").select2({
                placeholder: 'Pilih Tempat',
                width: '100%',
                data: [{
                    id: 'all',
                    text: 'Semua'
                }],
                ajax: {
                    url: "{{ route('nopr.index') }}",
                    processResults: function({
                        data
                    }) {
                        // Menggabungkan opsi "Semua" dengan data dari database
                        let results = $.map(data, function(item) {
                            return {
                                id: item.no_pr,
                                ids: item.id,
                                text: item.no_pr,
                            }
                        });
                        return {
                            results: results
                        }
                    }
                }
            })
            $('#nomor_pr').on('select2:select', function(e) {
                var selectedData = e.params.data;
                $("#id_pr").val(selectedData.ids);
                // alert($("#id_pr").val());
            });


            $('#filter-spph-no, #filter-spph-date').on('keyup change', function() {
                filterTable();
            });

            function filterTable() {
                var filterNoSPPH = $('#filter-spph-no').val().toUpperCase();
                var filterDateSPPH = $('#filter-spph-date').val();

                $('table tbody tr').each(function() {
                    var noSPPH = $(this).find('td:nth-child(3)').text().toUpperCase();
                    var dateSPPH = $(this).find('td:nth-child(6)').text();
                    var id = $(this).find('td:nth-child(1)')
                        .text(); // Ubah indeks kolom ke indeks ID PO jika perlu

                    // Ubah string tanggal ke objek Date untuk perbandingan
                    var dateParts = dateSPPH.split("/");
                    var spphDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[
                        0]); // Format: tahun, bulan, tanggal

                    // Ubah string filterDatePO ke objek Date
                    var filterDateParts = filterDateSPPH.split("-");
                    var filterSPPHDate = new Date(filterDateParts[0], filterDateParts[1] - 1,
                        filterDateParts[
                            2]); // Format: tahun, bulan, tanggal

                    if ((noSPPH.indexOf(filterNoSPPH) > -1 || filterNoSPPH === '') &&
                        (spphDate.getTime() === filterSPPHDate.getTime() || filterDateSPPH === '')) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });
        //End Filter by Nomor dan tgl SPPH


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

        //fungsi generate alamat

        // function generateNamaAlamat(data) {
        //     if (data) {
        //         $('#penerima-row').empty();
        //         var length = data.length;

        //         data.map((item, index) => {
        //             const counter = index + 1
        //             var formGroup =
        //                 '<div class="group">' +
        //                 '<div class="form-group row">' +
        //                 '<label for="penerima' + counter + '" class="col-sm-4 col-form-label">Penerima ' + counter +
        //                 '</label>' +
        //                 '<div class="col-sm-8 d-flex align-items-center">' +
        //                 '<input type="text" class="form-control" id="penerima' + counter +
        //                 '" name="penerima[]" value="' + item.penerima + '">' +
        //                 //remove button
        //                 '<button type="button" class="ml-2 btn btn-danger btn-sm" onclick="removeNamaAlamat(' +
        //                 counter +
        //                 ')"><i class="fas fa-trash"></i></button>' +
        //                 '</div>' +
        //                 '</div>' +
        //                 '<div class="form-group row">' +
        //                 '<label for="alamat' + counter + '" class="col-sm-4 col-form-label">Alamat ' + counter +
        //                 '</label>' +
        //                 '<div class="col-sm-8">' +
        //                 '<textarea class="form-control" id="alamat' + counter +
        //                 '" name="alamat[]" rows="3">' + item.alamat + '</textarea>' +
        //                 '</div>' +
        //                 '</div>' +
        //                 '<hr/>' +
        //                 '</div>';
        //             $("#penerima-row").append(formGroup);
        //         })
        //     } else {
        //         var length = $("#penerima-row").children().length;
        //         var counter = length + 1;

        //         var formGroup =
        //             '<div class="group">' +
        //             '<div class="form-group row">' +
        //             '<label for="penerima' + counter + '" class="col-sm-4 col-form-label">Penerima ' + counter +
        //             '</label>' +
        //             '<div class="col-sm-8 d-flex align-items-center">' +
        //             '<input type="text" class="form-control" id="penerima' + counter + '" name="penerima[]">' +
        //             //remove button
        //             '<button type="button" class="ml-2 btn btn-danger btn-sm" onclick="removeNamaAlamat(' + counter +
        //             ')"><i class="fas fa-trash"></i></button>' +
        //             '</div>' +
        //             '</div>' +
        //             '<div class="form-group row">' +
        //             '<label for="alamat' + counter + '" class="col-sm-4 col-form-label">Alamat ' + counter + '</label>' +
        //             '<div class="col-sm-8">' +
        //             '<textarea class="form-control" id="alamat' + counter + '" name="alamat[]"></textarea>' +
        //             '</div>' +
        //             '</div>' +
        //             '<hr/>' +
        //             '</div>';
        //         $("#penerima-row").append(formGroup);
        //     }
        // }


        //Fungsi tambah lampiran & Vendor
        function generateLampiranList(data) {
            if (data) {
                $('#lampiran-row').empty();
                var length = data.length;
                data.map((item, index) => {
                    const counter = index + 1
                    var formGroup =
                        '<div class="group">' +
                        '<div class="form-group custom-file row">' +
                        '<label for="lampiran' + counter + '" class="col-sm-4 col-form-label">Lampiran ' + counter +
                        '</label>' +
                        '<div class="col-sm-8 d-flex align-items-center ">' +
                        '<input type="file" class="form-control custom-file-input" id="lampiran' + counter +
                        '" name="lampiran[]" value="' + item + '">' +
                        '<button type="button" class="ml-2 btn btn-danger btn-sm" onclick="removeLampiran(' +
                        counter + ')"><i class="fas fa-trash"></i></button>' +
                        '</div>' +
                        '</div>' +
                        // '<hr/>' +
                        '</div>';
                    $("#lampiran-row").append(formGroup);
                })
            } else {
                var length = $("#lampiran-row").children().length;
                var counter = length + 1;

                var formGroup =
                    '<div class="group">' +
                    '<div class="form-group row">' +
                    '<label for="lampiran' + counter + '" class="col-sm-4 col-form-label">Lampiran ' + counter +
                    '</label>' +
                    '<div class="col-sm-8 d-flex align-items-center">' +
                    '<input type="file" class="form-control" id="lampiran' + counter + '" name="lampiran[]">' +
                    //remove button
                    '<button type="button" class="ml-2 btn btn-danger btn-sm" onclick="removeLampiran(' + counter +
                    ')"><i class="fas fa-trash"></i></button>' +
                    '</div>' +
                    '</div>' +
                    // '<hr/>' +
                    '</div>';
                $("#lampiran-row").append(formGroup);
            }
        }

        function generateVendorList(data) {
            if (data) {
                $('#vendor-row').empty();
                var length = data.length;

                data.map((item, index) => {
                    const counter = index + 1;
                    var formGroup =
                        '<div class="group">' +
                        '<div class="form-group row">' +
                        '<label for="vendor' + counter + '" class="col-sm-4 col-form-label">Vendor ' + counter +
                        '</label>' +
                        '<div class="col-sm-8 d-flex align-items-center">' +
                        '<select class="form-control" id="vendor' + counter + '" name="vendor[]">' +
                        '<option value="">Pilih Vendor</option>' +
                        '@foreach ($vendors as $vendor)' +
                        '<option value="{{ $vendor->nama }}">{{ $vendor->nama }}</option>' +
                        // Use vendor name for both value and text
                        '@endforeach' +
                        '</select>' +
                        '<button type="button" class="ml-2 btn btn-danger btn-sm" onclick="removeNamaAlamat(' +
                        counter + ')"><i class="fas fa-trash"></i></button>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    $("#vendor-row").append(formGroup);

                    // Set the selected value after appending the form group
                    $('#vendor' + counter).val(item);
                });
            } else {
                var length = $("#vendor-row").children().length;
                var counter = length + 1;

                var formGroup =
                    '<div class="group">' +
                    '<div class="form-group row">' +
                    '<label for="vendor' + counter + '" class="col-sm-4 col-form-label">Vendor ' + counter + '</label>' +
                    '<div class="col-sm-8 d-flex align-items-center">' +
                    '<select class="form-control" id="vendor' + counter + '" name="vendor[]">' +
                    '<option value="">Pilih Vendor</option>' +
                    '@foreach ($vendors as $vendor)' +
                    '<option value="{{ $vendor->nama }}">{{ $vendor->nama }}</option>' +
                    // Use vendor name for both value and text
                    '@endforeach' +
                    '</select>' +
                    '<button type="button" class="ml-2 btn btn-danger btn-sm" onclick="removeNamaAlamat(' + counter +
                    ')"><i class="fas fa-trash"></i></button>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                $("#vendor-row").append(formGroup);
            }
        }


        function removeNamaAlamat(counter) {
            // $('#penerima' + counter).closest('.group').remove();
            $('#vendor' + counter).closest('.group').remove();
        }

        // function removeLampiran(counter) {
        //     $('#lampiran' + counter).closest('.group').remove();
        // }

        function generateLampiranList(data) {
            if (data) {
                $('#lampiran-row').empty();
                data.forEach((item, index) => {
                    const counter = index + 1;
                    var formGroup =
                        '<div class="form-group row">' +
                        '<label for="lampiran' + counter + '" class="col-sm-4 col-form-label">Lampiran ' + counter +
                        '</label>' +
                        '<div class="col-sm-8">' +
                        '<div class="custom-file">' +
                        '<input type="file" class="custom-file-input" id="lampiran' + counter +
                        '" name="lampiran[]" onchange="showFileName(this, ' + counter + ')">' +
                        '<label class="custom-file-label" for="lampiran' + counter + '">Pilih file</label>' +
                        '</div>' +
                        '<small id="file-name' + counter + '" class="form-text text-muted">' + item + '</small>' +
                        '<button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeLampiran(' +
                        counter + ')"><i class="fas fa-trash"></i> Hapus</button>' +
                        '</div>' +
                        '</div>';
                    $("#lampiran-row").append(formGroup);
                });
            } else {
                var length = $("#lampiran-row").children().length;
                var counter = length + 1;

                var formGroup =
                    '<div class="form-group row">' +
                    '<label for="lampiran' + counter + '" class="col-sm-4 col-form-label">Lampiran ' + counter +
                    '</label>' +
                    '<div class="col-sm-8">' +
                    '<div class="custom-file">' +
                    '<input type="file" class="custom-file-input" id="lampiran' + counter +
                    '" name="lampiran[]" onchange="showFileName(this, ' + counter + ')">' +
                    '<label class="custom-file-label" for="lampiran' + counter + '">Pilih file</label>' +
                    '</div>' +
                    '<small id="file-name' + counter + '" class="form-text text-muted"></small>' +
                    '<button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeLampiran(' + counter +
                    ')"><i class="fas fa-trash"></i> Hapus</button>' +
                    '</div>' +
                    '</div>';
                $("#lampiran-row").append(formGroup);
            }
        }


        function showFileName(input, counter) {
            var fileName = input.files[0].name;
            $('#file-name' + counter).text(fileName);
            // Update the label with the selected file's name
            $(input).next('.custom-file-label').html(fileName);
        }

        function removeLampiran(index) {
            $('#lampiran' + index).closest('.form-group').remove();
        }

        $(document).ready(function() {
            $('#add-lampiran').click(function() {
                generateLampiranList();
            });

            // Example of initializing with data
            // var initialData = ["file1.pdf", "file2.jpg"];
            // generateLampiranList(initialData);
        });



        $(document).ready(function() {
            $("#tambah").click(function() {
                // generateNamaAlamat(null);
                generateVendorList(null);
            });
        });
        $(document).ready(function() {
            $("#tambah-lampiran").click(function() {
                generateLampiranList(null);
            });
        });

        function showAddProduct(data) {
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
                // console.log(data);
            } else {
                $('#detail-spph').find('.modal-dialog').removeClass('modal-xl');
                $('#detail-spph').find('.modal-dialog').addClass('modal-lg');
                $('#button-tambah-produk').text('Tambah Produk');
                $('#container-form').removeClass('col-6');
                $('#container-form').addClass('col-12');
                $('#container-product').removeClass('col-6');
                $('#container-product').addClass('col-0');
                $('#container-product').addClass('d-none');
                $('#proyek_name').val("");
            }

            // getSpphDetail(data);


        }

        function editSPPH(data) {
            $('#modal-title').text("Edit SPPH");
            $('#button-save').text("Simpan");
            console.log(data);
            resetForm();
            var lampiranArray = data.lampiran.split(", ");
            // Mengambil nilai dari elemen input
            $('#lampiran_awal').val(data.lampiran).length;
            var nilaiLampiran = lampiranArray.length;

            $('#nama_lampiran').val(data.lampiran).length;

            // alert($('#nama_lampiran').val());

            var vendorArray = data.vendor.split(", ");
            // Mengambil nilai dari elemen input
            $('#data_vendor').val(data.lampiran).length;
            var nilaiVendor = vendorArray.length;

            // Menambahkan nilai dari elemen input ke teks elemen <h6>
            document.getElementById('lampiran_text').innerHTML = 'Total Lampiran <b>' + nilaiLampiran + '</b>';
            generateLampiranList(lampiranArray);

            // Menambahkan nilai dari elemen input ke teks elemen <h6>
            document.getElementById('vendor_text').innerHTML = 'Total Vendor <b>' + nilaiVendor + '</b>';
            generateVendorList(vendorArray);
            // alert(vendorArray);

            $('#save_id').val(data.id);
            $('#id_pr').val(data.id_pr);
            $('#nomor_spph').val(data.nomor_spph);
            // $('#nomor_pr').val(data.nomor_pr);
            var pr = data.nomor_pr; // edit nomor pr biar muncul di form
            $('#lampiran').val(data.lampiran);
            $('#vendor').val(data.vendor);
            $('#penerima').val(data.penerima);
            $('#alamat').val(data.alamat);
            $('#perihal').val(data.perihal);
            // Ensure the komponen option is present in Select2
            // data edit nomor_pr
            if ($("#nomor_pr option[value='" + pr + "']").length == 0) {
                var newOption = new Option(pr, pr, true, true);
                $('#nomor_pr').append(newOption).trigger('change');
            } else {
                $('#nomor_pr').val(pr).trigger('change');
            }
            // $('#tanggal_spph').val(data.tanggal);
            var date = data.tanggal.split('/');
            var newDate = date[2] + '-' + date[1] + '-' + date[0];
            $('#tanggal_spph').val(newDate)
            // $('#batas_spph').val(data.batas);
            var date = data.batas.split('/');
            var newDate = date[2] + '-' + date[1] + '-' + date[0];
            $('#batas_spph').val(newDate)
            const penerima = JSON.parse(data.penerima_asli);
            const alamat = JSON.parse(data.alamat_asli);
            const dataPenerima = penerima.map((item, index) => {
                return {
                    penerima: item,
                    alamat: alamat[index]
                }
            })
            generateNamaAlamat(dataPenerima);
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



        //SUMBER MASALAH HARI KAMIS BUAT HARI JUMAT 

        //Pilih Item SPPH
        function getSpphDetail(id_pr) {
            // alert(id_pr);
            loader();

            $('#button-check').prop("disabled", true);
            $.ajax({
                url: "{{ url('products/products_pr/') }}/" + id_pr,
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
                        console.log(value);
                        var no_spph
                        if (!value.id_spph) {
                            no_spph = '-'
                        } else {
                            no_spph = value.nomor_spph
                        }

                        var no_pr
                        if (!value.pr_no) {
                            no_pr = '-'
                        } else {
                            no_pr = value.pr_no
                        }

                        var checkbox;
                        if (!value.id_spph) {
                            checkbox = '<input type="checkbox" id="addToDetails" value="' + value.id +
                                '" onclick="addToDetailsJs(' + value.id + ')">'
                        } else {
                            checkbox = '<input type="checkbox" id="addToDetails" value="' + value.id +
                                '" onclick="addToDetailsJs(' + value.id + ')" disabled>'
                        }

                        $('#detail-material').append(
                            '<tr><td>' + (key + 1) + '</td><td>' + checkbox +
                            '</td><td>' + value.uraian +
                            '</td><td>' + value.spek + '</td><td>' + value.qty + '</td><td>' + value
                            .satuan + '</td><td>' + no_pr + '</td><td>' + no_spph + '</td><td>' +
                            value.nama_proyek +
                            '</td></tr>'
                        );
                    });
                },
                error: function() {
                    $('#pcode').prop("disabled", false);
                    $('#button-check').prop("disabled", false);
                }
            });
        }
        //End Pilih item SPPH

        var selected = [];

        function addToDetailsJs(id) {
            if (selected.includes(id)) {
                selected = selected.filter(item => item !== id)
            } else {
                selected.push(id)
            }

            console.log(selected);
        }

        function clearForm() {
            $('#product_id').val("");
            $('#pname').val("");
            $('#stock').val("");
            $('#pcode').val("");
            $('#form').hide();
        }

        function addToDetails() {
            $.ajax({
                url: "{{ url('products/tambah_spph_detail') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "selected_id": selected,
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
                    var id_pr = data.spph.id_pr;
                    getSpphDetail(id_pr);
                    console.log(data);
                    // alert(id_pr);
                    // var selected = [];

                    // function addToDetailsJs(id) {
                    //     if (selected.includes(id)) {
                    //         selected = selected.filter(item => item !== id)
                    //     } else {
                    //         selected.push(id)
                    //     }

                    //     console.log(selected);
                    // }

                    if (!data.success) {
                        toastr.error(data?.message);
                        return
                    }

                    // Clear the form fields here
                    selected = [];

                    // Append to #detail-material
                    $('#table-spph').empty();
                    $.each(data.spph.details, function(key, value) {
                        $('#table-spph').append('<tr><td>' + (key + 1) + '</td><td>' + value
                            .uraian + '</td><td>' + value.spek + '</td><td>' + value.qty +
                            '</td><td>' + value.lampiran +
                            '</td><td>' + value.satuan + '</td></tr>');
                    });
                },
                error: function() {
                    $('#pcode').prop("disabled", false);
                    $('#button-check').prop("disabled", false);
                }
            });
        }


        function productCheck() {
            var proyek_name = $('#proyek_name').val();
            if (proyek_name.length > 0) {
                loader();
                $('#proyek_code').prop("disabled", true);
                $('#button-check').prop("disabled", true);
                $.ajax({
                    url: "{{ url('products/products_pr?proyek=') }}" + proyek_name,
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
                            console.table('a', value)
                            var no_spph
                            if (!value.id_spph) {
                                no_spph = '-'
                            } else {
                                no_spph = value.nomor_spph
                            }

                            var no_pr
                            if (!value.id_pr) {
                                no_pr = '-'
                            } else {
                                no_pr = value.pr_no
                            }

                            var no_po
                            if (!value.id_po) {
                                no_po = '-'
                            } else {
                                no_po = value.po_no
                            }

                            var checkbox;
                            if (!value.id_spph) {
                                checkbox = '<input type="checkbox" id="addToDetails" value="' + value
                                    .id +
                                    '" onclick="addToDetailsJs(' + value.id + ')">'
                            } else {
                                checkbox = '<input type="checkbox" id="addToDetails" value="' + value
                                    .id +
                                    '" onclick="addToDetailsJs(' + value.id + ')" disabled>'
                            }

                            $('#detail-material').append(

                                '<tr><td>' + (key + 1) + '</td><td>' + value.uraian +
                                '</td><td>' + value.spek + '</td><td>' + value.qty + '</td><td>' +
                                value
                                .satuan + '</td><td>' + value.nama_proyek + '</td><td>' + no_spph +
                                '</td><td>' + no_pr + '</td><td>' +
                                no_po + '</td><td>' + checkbox + '</td></tr>'
                            );
                        });

                        $('#detail-material').append(
                            '<tr><td colspan="8" class="text-center">Tidak ada produk</td></tr>');
                    },
                    error: function() {
                        $('#pcode').prop("disabled", false);
                        $('#button-check').prop("disabled", false);
                    }
                });
            } else {
                toastr.error("Nama Proyek tidak ditemukan");
            }
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


        //Delete Detail
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
        //End Delete Detail



        // on modal #detail-spph open
        $('#detail-spph').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var data = button.data('detail');
            console.log(data);
            lihatSjn(data);
            $('#detail-spph').find('.modal-dialog').removeClass('modal-xl');
            $('#detail-spph').find('.modal-dialog').addClass('modal-lg');
            $('#button-tambah-produk').text('Tambah Produk');
            $('#container-form').removeClass('col-6');
            $('#container-form').addClass('col-12');
            $('#container-product').removeClass('col-6');
            $('#container-product').addClass('col-0');
            $('#container-product').addClass('d-none');
            $('#proyek_name').val("");
        });

        //Lihat Detail
        function lihatSjn(data) {
            emptyTableSpph();
            $('#modal-title').text("Detail SPPH");
            $('#button-save').text("Cetak");
            resetForm();
            $('#save_id').val(data.id);
            $('#button-tambah-produk').val(data.id_pr);
            $('#button-tambah-produk').attr('onclick', `showAddProduct(${data.id_pr}); getSpphDetail(${data.id_pr});`);
            $('#id_pr2').text(data.id_pr);
            $('#no_surat').text(data.nomor_spph);
            $('#nama_penerima').text(data.penerima);
            $('#tgl_spph').text(data.tanggal);
            $('#table-spph').empty();
            $.ajax({
                url: "{{ url('products/spph_detail') }}" + "/" + data.id,
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
                            '<tr><td colspan="7" class="text-center">Tidak ada produk</td></tr>'
                        );
                    } else {
                        $.each(data.spph.details, function(key, value) {
                            // var urlLampiran = "{{ asset('lampiran') }}";

                            // var lampiran = null;
                            // if (value.lampiran == null) {
                            //     lampiran = '-';
                            // } else {
                            //     lampiran = '<a href="' + urlLampiran + '/' + lampiran +
                            //         '"><i class="fa fa-eye"></i> Lihat</a>';
                            // }

                            $('#table-spph').append('<tr><td>' + (key + 1) + '</td><td>' + value
                                .uraian + '</td><td>' + value.spek + '</td><td>' + value.qty +
                                '</td><td>' + value.satuan + '</td><tr>');
                        });
                    }

                    // Remove loading
                    $('#table-spph').find('tr:first').remove();
                }
            });
        }

        //Agar ketika klik simpan, dapat submit
        function setSaveIdAndSubmit() {
            // Submit the form
            var allFileNames = getAllFileNames();
            $('#nama_lampiran').val(allFileNames);
            // alert($('#nama_lampiran').val());
            // alert($('#lampiran_awal').val());
            document.getElementById('save').submit();
        }

        //Mengambil semua nama file (lampiran)
        function getAllFileNames() {
            var fileNames = [];
            var counter = 1;
            var maxTries = 100; // Batas atas untuk menghentikan loop jika terlalu banyak percobaan

            while (counter <= maxTries) {
                var element = $("#file-name" + counter);
                if (element.length) {
                    var fileName = element.text().trim();
                    fileNames.push(fileName);
                }
                counter++;
            }

            return fileNames.join(", ");
        }





        //End Lihat Detail

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
