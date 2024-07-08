@extends('layouts.main')
@section('title', 'gangguan')
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
                                onclick="addKodeAset()"><i class="fas fa-plus"></i> Add New Gangguan</button>
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
                                    <th>Proyek</th>
                                    <th>Trainset</th>
                                    <th>Car</th>
                                    <th>Jenis Perawatan</th>
                                    <th>Perkiraan Mulai</th>
                                    <th>Perkiraan Selesai</th>


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
                                        <td>{{ $d->nama_proyek }}</td>
                                        <td>{{ $d->trainset }}</td>
                                        <td>{{ $d->car }}</td>
                                        <td>{{ $d->perawatan }}</td>
                                        <td>{{ $d->perkiraan_mulai }}</td>
                                        <td>{{ $d->perkiraan_selesai }}</td>


                                        <td class="text-center">
                                            @if (Auth::user()->role == 0 || Auth::user()->role == 7)
                                                <button title="Edit Shelf" type="button" class="btn btn-success btn-xs"
                                                    data-toggle="modal" data-target="#add-kode-aset"
                                                    onclick="editGangguan({{ json_encode($data) }})"><i
                                                        class="fas fa-edit"></i></button>

                                                @if($d->perawatan == 'UNSCHEDULE')
                                                <button title="Lihat Detail" type="button" data-toggle="modal"
                                                    data-target="#detail-pr" class="btn-lihat btn btn-info btn-xs"
                                                    data-detail="{{ json_encode($data) }}"><i
                                                        class="fas fa-list"></i></button>
                                                @endif
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
                                            <td style="width: 3%;"><b>Nama Tempat</b></td>
                                            <td style="width:2%">:</td>
                                            <td style="width: 55%"><span id="nama_tempat"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Lokasi</b></td>
                                            <td>:</td>
                                            <td><span id="lokasi"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Nama Proyek</b></td>
                                            <td>:</td>
                                            <td><span id="nama_proyek"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Yang Melaporkan</b></td>
                                            <td>:</td>
                                            <td><span id="pelapor"></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <button id="button-tambah-produk" type="button" class="btn btn-info mb-3"
                                                    onclick="showAddProduct()">{{ __('Tambah Item Detail') }}</button>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="width: max-content;">
                                            <thead style="text-align: center">
                                                <th>{{ __('NO') }}</th>
                                                <th>{{ __('Tanggal Gangguan') }}</th>
                                                <th>{{ __('Perkiraan Gangguan') }}</th>
                                                <th>{{ __('Penyebab Gangguan') }}</th>
                                                <th>{{ __('Jenis Gangguan') }}</th>
                                                <th>{{ __('Tindak Lanjut') }}</th>
                                                <th>{{ __('Hasil Tindak Lanjut') }}</th>
                                                <th>{{ __('Komponen Diganti') }}</th>
                                                <th>{{ __('Jumlah') }}</th>
                                                <th>{{ __('Satuan') }}</th>
                                                <th>{{ __('Keterangan') }}</th>
                                                <th>{{ __('Status') }}</th>



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
                                                    <label for="kode_material"
                                                        class="col-sm-4 col-form-label">{{ __('Kode Material') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="kode_material">
                                                        <input type="hidden" class="form-control" id="pr_id"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nama_barang"
                                                        class="col-sm-4 col-form-label">{{ __('Nama Barang') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="nama_barang">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="spesifikasi"
                                                        class="col-sm-4 col-form-label">{{ __('Spesifikasi') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="spesifikasi">
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
        {{-- end modal detail --}}



        @auth

            @if (Auth::user()->role == 0 || Auth::user()->role == 7)
                <div class="modal fade" id="add-kode-aset">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="modal-title" class="modal-title">{{ __('Tambah Data Gangguan') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" id="save" action="{{ route('gangguan.store') }}" method="post"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    {{-- @method('put') --}}
                                    <input type="hidden" id="id1" name="id">


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
                                            <select class="form-control" name="nama_tempat" id="namatempat">
                                                <option value="">Pilih Tempat</option>
                                                @foreach ($tempats as $tempat)
                                                    <option value="{{ $tempat->nama_tempat }}">{{ $tempat->nama_tempat }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lokasi" class="col-sm-4 col-form-label">{{ __('Lokasi') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="lokasiproyek" name="lokasi">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="nama_proyek"
                                            class="col-sm-4 col-form-label">{{ __('Nama Proyek') }}</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="nama_proyek" id="namaproyek">
                                                <option value="">Pilih Proyek</option>
                                                @foreach ($tempats as $tempat)
                                                    <option value="{{ $tempat->nama_proyek }}">{{ $tempat->nama_proyek }}
                                                    </option>
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
                                                    <option value="{{ $proyek->kode_perawatan }}">
                                                        {{ $proyek->kode_perawatan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="perkiraan_mulai"
                                            class="col-sm-4 col-form-label">{{ __('Perkiraan Mulai') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="perkiraan_mulai"
                                                name="perkiraan_mulai">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="perkiraan_selesai"
                                            class="col-sm-4 col-form-label">{{ __('Perkiraan Selesai') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="perkiraan_selesai"
                                                name="perkiraan_selesai">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="kondisi" class="col-sm-4 col-form-label">{{ __('Kondisi') }}
                                        </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="kondisi" name="kondisi">
                                                <option value=""></option>
                                                <option value="SO">SO</option>
                                                <option value="TSO">TSO</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group row">
                                        <label for="keterangan"
                                            class="col-sm-4 col-form-label">{{ __('Keterangan') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                                        </div>
                                    </div> --}}
                                    {{-- <div class="form-group row">
                                        <label for="file" class="col-sm-4 col-form-label">{{ __('File') }}</label>
                                        <div class="col-sm-8">
                                            <input type="file" class="form-control" id="file" name="file">
                                        </div>
                                    </div> --}}

                                    <div id="unscheduled_form" class="col-sm-12">
                                        <div class="panel panel-dark">
                                            <div class="panel-heading">
                                                <div class="panel-title" style="background-color: brown;color: white;">Detail
                                                    Gangguan
                                                </div>
                                                <div class="panel-body" style="border: outset;">
                                                    <div class="row">

                                                        {{-- start col-md-6 --}}
                                                        <div class="col-sm-6" style="margin-top: 10px;">

                                                            <div class="form-group row">
                                                                <label for="tanggal_gangguan" class="col-sm-5 col-form-label"
                                                                    style="font-size: 13px;">{{ __('Tanggal Gangguan') }}</label>
                                                                <div class="col-sm-7">
                                                                    <input type="date" class="form-control"
                                                                        id="tanggal_gangguan" name="tanggal_gangguan">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="perkiraan_gangguan"
                                                                    class="col-sm-5 col-form-label"
                                                                    style="font-size: 13px;">{{ __('Perkiraan Gangguan') }}</label>
                                                                <div class="col-sm-7">
                                                                    <input type="text" class="form-control"
                                                                        id="perkiraan_gangguan" name="perkiraan_gangguan">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="penyebab_gangguan" class="col-sm-5 col-form-label"
                                                                    style="font-size: 13px;">{{ __('Penyebab Gangguan') }}</label>
                                                                <div class="col-sm-7">
                                                                    <input type="text" class="form-control"
                                                                        id="penyebab_gangguan" name="penyebab_gangguan">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="jenis_gangguan" class="col-sm-5 col-form-label"
                                                                    style="font-size: 13px;">{{ __('Jenis Gangguan') }}</label>
                                                                <div class="col-sm-7">
                                                                    <input type="text" class="form-control"
                                                                        id="jenis_gangguan" name="jenis_gangguan">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- end col-md-6 --}}


                                                        {{-- start col-md-6 --}}
                                                        <div class="col-sm-6" style="margin-top: 10px;">

                                                            <div class="form-group row">
                                                                <label for="tindak_lanjut" class="col-sm-5 col-form-label"
                                                                    style="font-size: 13px;">{{ __('Tindak Lanjut') }}</label>
                                                                <div class="col-sm-7">
                                                                    <input type="text" class="form-control"
                                                                        id="tindak_lanjut" name="tindak_lanjut">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="hasil_tindak_lanjut"
                                                                    class="col-sm-5 col-form-label"
                                                                    style="font-size: 13px;">{{ __('Hasil Tindak Lanjut') }}</label>
                                                                <div class="col-sm-7">
                                                                    <input type="text" class="form-control"
                                                                        id="hasil_tindak_lanjut" name="hasil_tindak_lanjut">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="status" class="col-sm-5 col-form-label"
                                                                    style="font-size: 13px;">{{ __('Status') }}
                                                                </label>
                                                                <div class="col-sm-7">
                                                                    <select class="form-control" id="status"
                                                                        name="status">
                                                                        <option value=""></option>
                                                                        <option value="OK">OK</option>
                                                                        <option value="NOK">NOK</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="pelapor" class="col-sm-5 col-form-label"
                                                                    style="font-size: 13px;">{{ __('Yang Melaporkan') }}</label>
                                                                <div class="col-sm-7">
                                                                    <input type="text" class="form-control" id="pelapor2"
                                                                        name="pelapor">
                                                                </div>
                                                            </div>


                                                        </div>
                                                        {{-- end col-md-6 --}}



                                                    </div>
                                                    <hr>
                                                    <div class="form-group row">
                                                        <label for="nama_barang" class="col-sm-3 col-form-label"
                                                            style="margin-left: 18px;">{{ __('Komponen Diganti') }}</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" id="namabarang"
                                                                name="nama_barang">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="jumlah" class="col-sm-3 col-form-label"
                                                            style="margin-left: 18px;">{{ __('Jumlah') }}</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" id="jumlah"
                                                                name="jumlah">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="satuan" class="col-sm-3 col-form-label"
                                                            style="margin-left: 18px;">{{ __('Satuan') }}</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" id="satuan"
                                                                name="satuan">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="keterangan" class="col-sm-3 col-form-label"
                                                            style="margin-left: 18px;">{{ __('Keterangan') }}</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" id="keterangan"
                                                                name="keterangan">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




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
                                <form role="form" id="delete" action="{{ route('gangguan.destroy') }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" id="delete_id" name="delete_id">
                                </form>
                                <div>
                                    <p>Anda yakin ingin menghapus Data Gangguan <span id="delete_name"
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

                {{-- detail delete --}}
                {{-- <div class="modal fade" id="delete-service">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="modal-title" class="modal-title">{{ __('Delete Detail') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" id="delete" action="{{ route('service.delete') }}" method="post">
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
                </div> --}}

                {{-- end detail delete --}}
            @endif
        @endauth
    </section>
@endsection
@section('custom-js')


    {{-- menghitung umur, pensiun , dan mpp --}}
    <script>
        $(document).ready(function() {

            $('#unscheduled_form').hide()

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
            $('#id1').val('')
            // $('#modal-title').text("Add New Kode Aset");
            $('#button-save').text("Add");
        }

        function editGangguan(data) {
            console.log(data)
            var title = "Gangguan"
            resetForm();
            $('#modal-title').text("Edit " + title);
            $('#button-save').text("Simpan");
            $('#id1').val(data.id);
            $('#namatempat').val(data.nama_tempat);
            $('#lokasiproyek').val(data.lokasi);
            $('#perkiraan_mulai').val(data.perkiraan_mulai);
            $('#perkiraan_selesai').val(data.perkiraan_selesai);
            $('#kondisi').val(data.kondisi);
            $('#namaproyek').val(data.nama_proyek);
            $('#trainset').val(data.trainset);
            $('#car').val(data.car);
            $('#perawatan').val(data.perawatan);
            $('#tanggal_gangguan').val(data.tanggal_gangguan);
            $('#perkiraan_gangguan').val(data.perkiraan_gangguan);
            $('#penyebab_gangguan').val(data.penyebab_gangguan);
            $('#jenis_gangguan').val(data.jenis_gangguan);
            $('#namabarang').val(data.nama_barang);
            $('#jumlah').val(data.jumlah);
            $('#satuan').val(data.satuan);
            $('#tindak_lanjut').val(data.tindak_lanjut);
            $('#hasil_tindak_lanjut').val(data.hasil_tindak_lanjut);
            $('#pelapor2').val(data.pelapor);
            $('#status').val(data.status);
            $('#keterangan').val(data.keterangan);
            var p = data.perawatan
            // alert(p)
            // alert(value)
            if (p == "UNSCHEDULE") {
                $('#unscheduled_form').show()
            } else {
                $('#unscheduled_form').hide()
            }

            // $('#update-kode-aset').modal('show');



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
                $('#button-tambah-produk').text('Tambah Komponen Diganti');
                clearForm();
            }
        }


        function emptyTableProducts() {
            $('#table-pr').empty();
            $('#nama_tempat').text("");
            $('#lokasi').text("");
            $('nama_proyek').text("");
            $('#kode_material').text("");
            $('#nama_barang').text("");
            $('#spesifikasi').text("");
        }



        function loader(status = 1) {
            if (status == 1) {
                $('#loader').show();
            } else {
                $('#loader').hide();
            }
        }




        function PRupdate() {
            const id = $('#pr_id').val()

            // var inputFile = $("#lampiran")[0].files[0];
            var formData = new FormData();
            // formData.append('lampiran', inputFile);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id_service', id);
            // formData.append('id_proyek', $('#proyek_id_val').val());
            formData.append('kode_material', $('#kode_material').val());
            formData.append('nama_barang', $('#nama_barang').val());
            formData.append('spesifikasi', $('#spesifikasi').val());


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
                    $('#nama_tempat').text(data.service.nama_tempat);
                    $('#lokasi').text(data.service.lokasi);
                    $('#nama_proyek').text(data.service.nama_proyek);
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



                            $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + value
                                .kode_material + '</td><td>' + value.nama_barang + '</td><td>' +
                                value.spesifikasi + '</td><td>'
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

        function clearForm() {
            $('#kode_material').val("");
            $('#nama_barang').val("");
            $('#spesifikasi').val("");
        }

        $('#detail-pr').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var data = button.data('detail');
            console.log(data);
            lihatPR(data);
        });

        $('#add-kode-aset').on('show.bs.modal', function(event) {
            $('#perawatan').on('change', function() {
                var value = $(this).val();
                // alert(value)
                if (value == "UNSCHEDULE") {
                    $('#unscheduled_form').show()
                } else {
                    $('#unscheduled_form').hide()
                }
            })
        });

        function lihatPR(data) {
            emptyTableProducts();
            clearForm()
            $('#modal-title').text("Detail Penggantian Komponen");
            $('#button-save').text("Cetak");
            resetForm();
            $('#button-tambah-produk').text('Tambah Komponen Diganti');
            $('#id').val(data.id);
            $('#nama_tempat').text(data.nama_tempat);
            $('#nama_proyek').text(data.nama_proyek);
            $('#lokasi').text(data.lokasi);
            $('#pelapor').text(data.pelapor);
            $('#tanggal_gangguan').text(data.tanggal_gangguan);
            $('#perkiraan_gangguan').text(data.perkiraan_gangguan);
            $('#penyebab_gangguan').text(data.penyebab_gangguan);
            $('#jenis_gangguan').text(data.jenis_gangguan);
            $('#nama_barang').text(data.nama_barang);
            $('#jumlah').text(data.jumlah);
            $('#satuan').text(data.satuan);
            $('#tindak_lanjut').text(data.tindak_lanjut);
            $('#hasil_tindak_lanjut').text(data.hasil_tindak_lanjut);
            $('#pelapor').text(data.pelapor);
            $('#status2').text(data.status);
            $('#keterangan').text(data.keterangan);
            // $('#proyek_id_val').val(data.proyek_id);
            $('#pr_id').val(data.id);
            $('#table-pr').empty();

            //#button-tambah-produk disabled when editable is false
            if (data.editable == 0) {
                $('#button-tambah-produk').attr('disabled', true);
            } else {
                $('#button-tambah-produk').attr('disabled', false);
            }

            $.ajax({
                url: "{{ url('gangguan_detail') }}" + "/" + data.id,
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $('#table-pr').append('<tr><td colspan="15" class="text-center">Loading...</td></tr>');
                    //     $('#button-cetak-pr').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    //     $('#button-cetak-pr').attr('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#id').val(data.gangguan.id);
                    $('#nama_tempat').text(data.gangguan.nama_tempat);
                    $('#lokasi').text(data.gangguan.lokasi);
                    $('#tanggal_gangguan').text(data.gangguan.tanggal_gangguan);
                    $('#perkiraan_gangguan').text(data.gangguan.perkiraan_gangguan);
                    $('#penyebab_gangguan').text(data.gangguan.penyebab_gangguan);
                    $('#jenis_gangguan').text(data.gangguan.jenis_gangguan);
                    $('#tindak_lanjut').text(data.gangguan.tindak_lanjut);
                    $('#hasil_tindak_lanjut').text(data.gangguan.hasil_tindak_lanjut);
                    $('#nama_barang').text(data.gangguan.nama_barang);
                    $('#jumlah').text(data.gangguan.jumlah);
                    $('#satuan').text(data.gangguan.satuan);
                    $('#keterangan').text(data.gangguan.keterangan);
                    $('#button-cetak-pr').html('<i class="fas fa-print"></i> Cetak');
                    $('#button-cetak-pr').attr('disabled', false);
                    var no = 1;

                    if (data.gangguan.details.length == 0) {
                        $('#table-pr').empty();
                        $('#table-pr').append(
                            '<tr><td colspan="15" class="text-center">Tidak ada produk</td></tr>');
                    } else {
                        $('#table-pr').empty();
                        $.each(data.gangguan.details, function(key, value) {


                            $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + value
                                .tanggal_gangguan + '</td><td>' + value.perkiraan_gangguan +
                                '</td><td>' +
                                value
                                .penyebab_gangguan + '</td><td>' + value.jenis_gangguan +
                                '</td><td>' + value.tindak_lanjut +
                                '</td><td>' + value.hasil_tindak_lanjut + '</td><td>' + value
                                .nama_barang + '</td><td>' + value.jumlah +
                                '</td><td>' + value.satuan + '</td><td>' + value.keterangan +
                                '</td><td>' + value.status +
                                '</td>' +
                                // '</td><td>' + value.qty + '</td><td>' + value
                                // .satuan + '</td><td>' + value.waktu + '</td><td>' +
                                // lampiran + '</td><td>' + value.keterangan + '</td><td><b>' +
                                // status +
                                '</tr>'



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

        // $(document).on('click', '#delete_service_save',function(){
        //     var id = $(this).data('id');
        //     $('#delete_id').val(id);
        //     $('#delete-service').modal('show');
        //     // var kode_material = $('#kode_material' + id).text();
        //     // $('#delete_code').text(kode_material);

        // });


        $('#table-pr').on('click', '#delete_service_save', function() {
            var serviceId = $(this).data('id');
            deleteService(serviceId);
        });

        function deleteService(serviceId) {
            if (confirm("Anda yakin ingin menghapus produk ini?")) {
                $.ajax({
                    url: "{{ url('service_delete') }}",
                    type: "DELETE",
                    data: {
                        id: serviceId
                    },
                    success: function(response) {
                        // Handle success response, misalnya refresh halaman atau tampilkan pesan sukses
                        // Contoh:
                        alert('Produk berhasil dihapus');
                        // Kemudian lakukan refresh data atau operasi lain yang sesuai
                        // Misalnya: lihatPR(data);
                    },
                    error: function(xhr, status, error) {
                        // Handle error response, misalnya tampilkan pesan error
                        // Contoh:
                        alert('Terjadi kesalahan saat menghapus produk');
                    }
                });
            }
        }

        function bindRowActionEvents() {
            $('#delete_service_save').click(function() {
                var id = $(this).data('row-id');
                deleteRow(id);

            });
        }


        function detailPR(data) {
            $('#modal-title').text("Edit Request");
            $('#button-save').text("Simpan");
            resetForm();
            $('#save_id').val(data.id);
            $('#nama_tempat').val(data.nama_tempat);
            $('#lokasi').val(data.lokasi);
            $('#nama_proyek').val(data.nama_proyek);
            // $('#dasar_pr').val(data.dasar_pr);
            // alert(proyek_id)
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
