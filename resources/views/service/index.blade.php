@extends('layouts.main')
@section('title', 'service')
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
                    @auth
                        @if (Auth::user()->role == 0 || Auth::user()->role == 7)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-kode-aset"
                                onclick="addKodeAset()"><i class="fas fa-plus"></i> Add New Service</button>
                            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#import-karyawan"
                                onclick="importKaryawan()"><i class="fas fa-file-excel"></i> Import Karyawan (Excel)</button>
                                <a type="button" class="btn btn-primary" href="{{route('karyawan.export')}}" ><i class="fas fa-file-excel"></i> Export Karyawan (Excel)</a> --}}
                        @endif
                    @endauth
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

                                    <th>Nomor</th>
                                    <th>Nama Tempat</th>
                                    <th>Lokasi</th>
                                    <th>Nama Proyek</th>
                                    <th>Trainset</th>
                                    <th>Car</th>
                                    <th>Perawatan</th>
                                    <th>Perawatan Mulai</th>
                                    <th>Perawatan Selesai</th>
                                    {{-- <th>Komponen Yang Diganti</th> --}}
                                    {{-- <th>Tanggal Komponen</th> --}}
                                    <th>Pic</th>
                                    <th>Keterangan</th>

                                    <th>{{ __('Aksi') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $key => $d)
                                    @php
                                        $data = $d->toArray();
                                    @endphp

                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $d->nama_tempat }}</td>
                                        <td>{{ $d->lokasi }}</td>
                                        <td>{{ $d->nama_proyek }}</td>
                                        <td>{{ $d->trainset }}</td>
                                        <td>{{ $d->car }}</td>
                                        <td>{{ $d->perawatan }}</td>
                                        <td>{{ $d->perawatan_mulai }}</td>
                                        <td>{{ $d->perawatan_selesai }}</td>
                                        {{-- <td>{{ $d->komponen_diganti }}</td> --}}
                                        {{-- <td>{{ $d->tanggal_komponen }}</td> --}}
                                        <td>{{ $d->pic }}</td>
                                        <td>{{ $d->keterangan }}</td>
                                        {{-- <td><img src="{{ asset('/storage/photo/' . $d->file) }}" alt=""
                                                height="100px" width="100px"> </td> --}}

                                        <td class="text-center">
                                            @if (Auth::user()->role == 0 || Auth::user()->role == 7)
                                                <button title="Edit Shelf" type="button" class="btn btn-success btn-xs"
                                                    data-toggle="modal" data-target="#add-kode-aset"
                                                    onclick="editProyek({{ json_encode($data) }})"><i
                                                        class="fas fa-edit"></i></button>

                                                <button title="Lihat Detail" type="button" data-toggle="modal"
                                                    data-target="#detail-pr" class="btn-lihat btn btn-info btn-xs"
                                                    data-detail="{{ json_encode($data) }}"><i
                                                        class="fas fa-list"></i></button>

                                                <button title="Hapus Produk" type="button" class="btn btn-danger btn-xs"
                                                    data-toggle="modal" data-target="#delete-suratkeluar"
                                                    onclick="deleteproyek({{ json_encode($data) }})"><i
                                                        class="fas fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="11">{{ __('No data.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div>
                {{ $items->links('pagination::bootstrap-4') }}
            </div>
        </div>

        {{-- modal detail --}}
        <div class="modal fade" id="detail-pr">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Detail Penggantian Komponen') }}</h4>
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
                                                <th>{{ __('Komponen Yang Diganti') }}</th>
                                                <th>{{ __('Tanggal Penggantian Komponen') }}</th>
                                                <th>{{ __('QTY') }}</th>
                                                <th>{{ __('SAT') }}</th>
                                                <th>{{ __('Keterangan') }}</th>
                                                
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
                                            {{-- <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio1" name="ptype"
                                                    class="custom-control-input" checked value="inka">
                                                <label class="custom-control-label" for="customRadio1">INKA</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio2" name="ptype"
                                                    class="custom-control-input" value="imss">
                                                <label class="custom-control-label" for="customRadio2">IMSS</label>
                                            </div> --}}

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
                                    {{-- <div id="loader" class="card">
                                        <div class="card-body text-center">
                                            <div class="spinner-border text-danger" style="width: 3rem; height: 3rem;"
                                                role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div id="form" class="card">
                                        <div class="card-body">
                                            <form role="form" id="stock-update" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" id="pid" name="pid">
                                                <input type="hidden" id="type" name="type">
                                                <input type="hidden" id="proyek_id_val" name="proyek_id_val">
                                                <div class="form-group row">
                                                    <label for="deskripsi_material"
                                                        class="col-sm-4 col-form-label">{{ __('Komponen Diganti') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="deskripsi_material">
                                                        <input type="hidden" class="form-control" id="pr_id"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="spesifikasi"
                                                        class="col-sm-4 col-form-label">{{ __('Tanggal Komponen') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="spesifikasi">
                                                    </div>
                                                </div>
                                                {{-- <div class="form-group row">
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
                                                </div> --}}

                                                

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
        {{-- end modal detail --}}



        @auth

            @if (Auth::user()->role == 0 || Auth::user()->role == 7)
                <div class="modal fade" id="add-kode-aset">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="modal-title" class="modal-title">{{ __('Add New Service') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" id="save" action="{{ route('service.store') }}" method="post"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    {{-- @method('put') --}}
                                    <input type="hidden" id="id" name="id">


                                    {{-- <div class="form-group row">
                                        <label for="nomor_aset" class="col-sm-4 col-form-label">{{ __('Nomor Aset') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nomor_aset" name="nomor_aset">
                                        </div>
                                    </div> --}}

                                    <div class="form-group row">
                                        <label for="nama_tempat"
                                            class="col-sm-4 col-form-label">{{ __('Nama Tempat') }}</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="nama_tempat" id="nama_tempat">
                                                <option value="">Pilih Tempat</option>
                                                @foreach ($tempats as $tempat)
                                                    <option value="{{ $tempat->nama_tempat }}">{{ $tempat->nama_tempat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lokasi" class="col-sm-4 col-form-label">{{ __('Lokasi') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="lokasi" name="lokasi">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="nama_proyek"
                                            class="col-sm-4 col-form-label">{{ __('Nama Proyek') }}</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="nama_proyek" id="nama_proyek">
                                                <option value="">Pilih Proyek</option>
                                                @foreach ($tempats as $tempat)
                                                    <option value="{{ $tempat->nama_proyek }}">{{ $tempat->nama_proyek }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="trainset" class="col-sm-4 col-form-label">{{ __('Trainset') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="trainset" name="trainset">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="car" class="col-sm-4 col-form-label">{{ __('Car') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="car" name="car">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="perawatan" class="col-sm-4 col-form-label">{{ __('Perawatan') }}</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="perawatan" id="perawatan">
                                                <option value="">Pilih Perawatan</option>
                                                @foreach ($proyeks as $proyek)
                                                    <option value="{{ $proyek->kode_perawatan }}">{{ $proyek->kode_perawatan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="perawatan_mulai"
                                            class="col-sm-4 col-form-label">{{ __('Perawatan Mulai') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="perawatan_mulai"
                                                name="perawatan_mulai">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="perawatan_selesai"
                                            class="col-sm-4 col-form-label">{{ __('Perawatan Selesai') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="perawatan_selesai"
                                                name="perawatan_selesai">
                                        </div>
                                    </div>

                                    {{-- <div class="form-group row">
                                        <label for="komponen_diganti"
                                            class="col-sm-4 col-form-label">{{ __('Komponen Yang diganti') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="komponen_diganti"
                                                name="komponen_diganti">
                                        </div>
                                    </div> --}}

                                    {{-- <div class="form-group row">
                                        <label for="tanggal_komponen"
                                            class="col-sm-4 col-form-label">{{ __('Tanggal Komponen') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="tanggal_komponen"
                                                name="tanggal_komponen">
                                        </div>
                                    </div> --}}

                                    <div class="form-group row">
                                        <label for="pic" class="col-sm-4 col-form-label">{{ __('PIC') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="pic" name="pic">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="keterangan"
                                            class="col-sm-4 col-form-label">{{ __('Keterangan') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                                        </div>
                                    </div>
                                    {{-- <div class="form-group row">
                                        <label for="file" class="col-sm-4 col-form-label">{{ __('File') }}</label>
                                        <div class="col-sm-8">
                                            <input type="file" class="form-control" id="file" name="file">
                                        </div>
                                    </div> --}}




                                </form>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default"
                                    data-dismiss="modal">{{ __('Cancel') }}</button>
                                <button id="button-save" type="button" class="btn btn-primary"
                                    onclick="$('#save').submit();">{{ __('Add') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- editProyek --}}

                {{-- endproyek --}}


                <div class="modal fade" id="delete-suratkeluar">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="modal-title" class="modal-title">{{ __('Delete Proyek') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" id="delete" action="{{ route('service.destroy') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" id="delete_id" name="delete_id">
                                </form>
                                <div>
                                    <p>Anda yakin ingin menghapus service <span id="delete_name"
                                            class="font-weight-bold"></span>?</p>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default"
                                    data-dismiss="modal">{{ __('Batal') }}</button>
                                <button id="button-save" type="button" class="btn btn-danger"
                                    onclick="$('#delete').submit();">{{ __('Ya, hapus') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="import-karyawan">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Import Karyawan (Excel)</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" enctype="multipart/form-data" id="import"
                                    action="{{ route('karyawan.import') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <div class="">
                                            <input type="file" class="" id="file" name="file">
                                            {{-- <label class="" for="file">Choose file</label> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default"
                                    data-dismiss="modal">{{ __('Batal') }}</button>
                                {{-- <button type="button" class="btn btn-default"
                                    id="download-template">{{ __('Download Template') }}</button> --}}
                                <button type="button" class="btn btn-primary"
                                    onclick="$('#import').submit();">{{ __('Import') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </section>
@endsection
@section('custom-js')

    {{-- menghitung umur, pensiun , dan mpp --}}
    <script>
        $(document).ready(function() {
            // Fungsi untuk menghitung umur dan tanggal pensiun
            function hitungUmur() {
                // Ambil nilai tanggal lahir dari input
                var tanggalLahir = $('#tanggal_lahir').val();

                // Hitung umur
                var today = new Date();
                var birthDate = new Date(tanggalLahir);
                var age = today.getFullYear() - birthDate.getFullYear();
                var months = today.getMonth() - birthDate.getMonth();
                if (months < 0 || (months === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                // Tampilkan umur
                $('#umur').val(age + ' Tahun ' + months + ' Bulan');

                // Hitung tanggal pensiun (tambah 56 tahun)
                // var mppDate = new Date(birthDate);
                // mppDate.setFullYear(mppDate.getFullYear() + 55);
                // mppDate.setMonth(mppDate.getMonth() + 9);
                // mppDate.setDate(mppDate.getDate() + 20);
                // var pensiunDate = new Date(birthDate);
                // pensiunDate.setFullYear(pensiunDate.getFullYear() + 56);
                // pensiunDate.setMonth(pensiunDate.getMonth() + 9);
                // pensiunDate.setDate(pensiunDate.getDate() + 20);

                // Tampilkan tanggal pensiun
                $('#mpp').val(mppDate.toISOString().split('T')[0]);
                $('#pensiun').val(pensiunDate.toISOString().split('T')[0]);
            }

            // Panggil fungsi saat input tanggal lahir berubah
            $('#tanggal_lahir').on('change', function() {
                hitungUmur();
            });
        });
    </script>

    <script>
        // $(document).ready(function() {
        //     $("#nomor").inputmask({
        //         "mask": "999/EDP-FJ/99/9999",
        //     });
        // });

        function resetForm() {
            $('#save').trigger("reset");
            $('#kode').val('');
            $('#keterangan').val('');
        }

        function addKodeAset() {
            resetForm();
            // $('#modal-title').text("Add New Kode Aset");
            $('#button-save').text("Add");
        }

        function editProyek(data) {
            console.log(data)
            var title = "Service"
            resetForm();
            $('#modal-title').text("Edit " + title);
            $('#button-save').text("Simpan");
            $('#id').val(data.id);
            // $('#kode_tempat').val(data.kode_tempat);
            $('#nama_tempat').val(data.nama_tempat);
            $('#lokasi').val(data.lokasi);
            $('#nama_proyek').val(data.nama_proyek);
            $('#trainset').val(data.trainset);
            $('#car').val(data.car);
            $('#perawatan').val(data.perawatan);
            $('#perawatan_mulai').val(data.perawatan_mulai);
            $('#perawatan_selesai').val(data.perawatan_selesai);
            $('#komponen_diganti').val(data.komponen_diganti);
            $('#tanggal_komponen').val(data.tanggal_komponen);
            $('#pic').val(data.pic);
            $('#keterangan').val(data.keterangan);
            // $('#update-kode-aset').modal('show');



        }

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

        function clearForm() {
            $('#komponen_diganti').val("");
            $('#tanggal_komponen').val("");
        }

        
        function PRupdate() {
            const id = $('#pr_id').val()

            var inputFile = $("#lampiran")[0].files[0];
            var formData = new FormData();
            formData.append('lampiran', inputFile);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id_service', id);
            // formData.append('id_proyek', $('#proyek_id_val').val());
            formData.append('deskripsi_material', $('#deskripsi_material').val());
            formData.append('spesifikasi', $('#spesifikasi').val());
            // formData.append('stock', $('#stock').val());
            // formData.append('spek', $('#spek').val());
            // formData.append('satuan', $('#satuan').val());
            // formData.append('waktu', $('#waktu').val());
            // formData.append('keterangan', $('#keterangan').val());

            // if ($('#waktu').val() == null || $('#waktu').val() == "") {
            //     toastr.error("Waktu Penyelesaian belum diisi!");
            //     return
            // }

            // if (inputFile == null) {
            //     toastr.error("Lampiran belum diisi!");
            //     return
            // }

            // if (inputFile.type != "application/pdf") {
            //     toastr.error("Lampiran harus berupa file PDF!");
            //     return
            // }

            $.ajax({
                url: "{{ url('update_service_detail') }}",
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
                    $('#id').val(data.service.id);
                    $('#no_surat').text(data.pr.no_pr);
                    $('#tgl_surat').text(data.pr.tanggal);
                    $('#proyek').text(data.pr.proyek);
                    $('#button-update-pr').html('Tambahkan');
                    $('#button-update-pr').attr('disabled', false);
                    clearForm();
                    if (data.service.details.length == 0) {
                        $('#table-pr').append(
                            '<tr><td colspan="15" class="text-center">Tidak ada produk</td></tr>');
                    } else {
                        $('#table-pr').empty();
                        $.each(data.service.details, function(key, value) {
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

                            // if (!value.id_spph && !value.nomor_spph) {
                            //     status = 'Lakukan SPPH';
                            // } else if (value.id_spph && value.nomor_spph && !value.id_po) {
                            //     status = 'PROSES PO';
                            // } else if (value.id_spph && value.nomor_spph && value
                            //     .id_po && value.no_po) {
                            //     status = 'COMPLETED';
                            // }


                            $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + value
                                .deskripsi_material + '</td><td>' + value.spesifikasi + '</td><td>' 
                                    // +
                                // value
                                // .spek + '</td><td>' + value.qty + '</td><td>' + value
                                // .satuan +
                                // '</td><td>' + value.waktu + '</td><td>' +
                                // lampiran +
                                // '</td><td>' + value.keterangan + '</td><td>' + status +
                                // '</td></tr>'
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
        

        

        function deleteproyek(data) {
            $('#delete_id').val(data.id);
            $('#delete_name').text(data.nama_proyek);
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
