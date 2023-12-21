@extends('layouts.main')
@section('title', $title)
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
                                onclick="addKodeAset()"><i class="fas fa-plus"></i> Add New {{ $title }}</button>
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
                    <table id="table" class="table table-sm table-bordered table-hover table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Nomor Aset</th>
                                <th>Jenis Aset</th>
                                <th>Merek</th>
                                <th>No Seri</th>
                                <th>Kondisi</th>
                                <th>Lokasi/Unit Kerja</th>
                                <th>Pengguna</th>
                                <th>Tanggal Perolehan</th>
                                <th>Keterangan</th>
                                <th>{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $key => $d)
                                @php
                                    $data = $d->toArray();
                                @endphp
                                @php

                                    setLocale(LC_TIME, 'id');
                                    setlocale(LC_TIME, 'id_ID.utf8');
                                    \Carbon\Carbon::setLocale('id');

                                    $tanggal_perolehan = \Carbon\Carbon::parse($d->tanggal_perolehan)->isoFormat('D MMMM Y');

                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $d->nomor_aset }}</td>
                                    <td>{{ $d->jenis_aset }}</td>
                                    <td>{{ $d->merek }}</td>
                                    <td>{{ $d->no_seri }}</td>
                                    <td>{{ $d->kondisi }}</td>
                                    <td>{{ $d->lokasi }}</td>
                                    <td>{{ $d->pengguna }}</td>
                                    <td>{{ $tanggal_perolehan }}</td>
                                    <td>{{ $d->keterangan }}</td>
                                    <td class="text-center">
                                        @if (Auth::user()->role == 0 || Auth::user()->role == 7)
                                            <button title="Edit Shelf" type="button" class="btn btn-success btn-xs"
                                                data-toggle="modal" data-target="#add-kode-aset"
                                                onclick="editAset({{ json_encode($data) }})"><i
                                                    class="fas fa-edit"></i></button>
                                            <button title="Hapus Produk" type="button" class="btn btn-danger btn-xs"
                                                data-toggle="modal" data-target="#delete-suratkeluar"
                                                onclick="deleteAset({{ json_encode($data) }})"><i
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
            <div>
                {{ $items->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @auth

            @if (Auth::user()->role == 0 || Auth::user()->role == 7)
                <div class="modal fade" id="add-kode-aset">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="modal-title" class="modal-title">{{ __('Add New ' . $title) }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" id="save" action="{{ route('aset.save') }}" method="post"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" id="tipe" name="tipe" value="{{ $tipe }}">
                                    <div class="form-group row">
                                        <label for="aset_id" class="col-sm-4 col-form-label">{{ __('Kode Aset') }} </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="aset_id" name="aset_id">
                                                <option value="">Pilih Kode Aset</option>
                                                @foreach ($kode_asets as $item)
                                                    <option value="{{ $item->id }}">{{ $item->kode }} -
                                                        {{ $item->keterangan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nomor_aset" class="col-sm-4 col-form-label">{{ __('Nomor Aset') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nomor_aset" name="nomor_aset">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="jenis_aset" class="col-sm-4 col-form-label">{{ __('Jenis Aset') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="jenis_aset" name="jenis_aset">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="merek" class="col-sm-4 col-form-label">{{ __('Merk') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="merek" name="merek">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="no_seri" class="col-sm-4 col-form-label">{{ __('Nomor Seri') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="no_seri" name="no_seri">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="kondisi" class="col-sm-4 col-form-label">{{ __('Kondisi') }} </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="kondisi" name="kondisi">
                                                <option value="Baik">Baik</option>
                                                <option value="Rusak">Rusak</option>
                                                <option value="Hilang">Hilang</option>
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
                                        <label for="pengguna" class="col-sm-4 col-form-label">{{ __('Pengguna') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="pengguna" name="pengguna">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tanggal_perolehan"
                                            class="col-sm-4 col-form-label">{{ __('Tanggal Perolehan') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="tanggal_perolehan"
                                                name="tanggal_perolehan">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="keterangan"
                                            class="col-sm-4 col-form-label">{{ __('Keterangan') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="keterangan" name="keterangan">
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
                <div class="modal fade" id="delete-suratkeluar">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="modal-title" class="modal-title">{{ __('Delete ' . $title) }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" id="delete" action="{{ route('aset.delete') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" id="delete_id" name="delete_id">
                                </form>
                                <div>
                                    <p>Anda yakin ingin menghapus aset/inventaris nomor <span id="delete_name"
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
            @endif
        @endauth
    </section>
@endsection
@section('custom-js')
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

        function editAset(data) {
            console.log(data)
            var title = "{{ $title }}"
            resetForm();
            $('#modal-title').text("Edit " + title);
            $('#button-save').text("Simpan");
            $('#id').val(data.id);
            $('#aset_id').val(data.aset_id);
            $('#nomor_aset').val(data.nomor_aset);
            $('#jenis_aset').val(data.jenis_aset);
            $('#merek').val(data.merek);
            $('#no_seri').val(data.no_seri);
            $('#kondisi').val(data.kondisi);
            $('#lokasi').val(data.lokasi);
            $('#pengguna').val(data.pengguna);
            $('#tanggal_perolehan').val(data.tanggal_perolehan);
            $('#keterangan').val(data.keterangan);

        }

        function deleteAset(data) {
            $('#delete_id').val(data.id);
            $('#delete_name').text(data.nomor_aset);
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
