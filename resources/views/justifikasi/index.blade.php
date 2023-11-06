@extends('layouts.main')
@section('title', __('Justifikasi'))
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
                    @if (Auth::user()->role == 0 || Auth::user()->role == 4)
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-justifikasi"
                            onclick="addJustifikasi()"><i class="fas fa-plus"></i> Add New Justifikasi</button>
                    @endif
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
                                <th>{{ __('Tanggal') }}</th>
                                <th>{{ __('Nomor') }}</th>
                                <th>{{ __('Keterangan') }}</th>
                                <th>{{ __('File') }}</th>
                                <th>{{ __('PIC') }}</th>
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
                                    <td>{{ $data['tanggal'] }}</td>
                                    <td>{{ $data['nomor'] }}</td>
                                    <td>{{ $data['keterangan'] }}</td>
                                    <td class="text-center">
                                        <a href="{{ asset('justifikasi/' . $data['file']) }}" target="_blank">
                                            Download
                                        </a>
                                    </td>
                                    <td class="text-center">{{ $data['pic'] }}</td>
                                    <td class="text-center">
                                        @if (Auth::user()->role == 0 || Auth::user()->role == 4)
                                            <button title="Edit Shelf" type="button" class="btn btn-success btn-xs"
                                                data-toggle="modal" data-target="#add-justifikasi"
                                                onclick="editJustifikasi({{ json_encode($data) }})"><i
                                                    class="fas fa-edit"></i></button>
                                            <button title="Hapus Produk" type="button" class="btn btn-danger btn-xs"
                                                data-toggle="modal" data-target="#delete-justifikasi"
                                                onclick="deleteJustifikasi({{ json_encode($data) }})"><i
                                                    class="fas fa-trash"></i></button>
                                        @endif
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
            <div>
                {{ $items->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @if (Auth::user()->role == 0 || Auth::user()->role == 4)
            <div class="modal fade" id="add-justifikasi">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="modal-title" class="modal-title">{{ __('Add New Justifikasi') }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" id="save" action="{{ route('product.justifikasi.save') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="justifikasi_id" name="justifikasi_id">
                                <div class="form-group row">
                                    <label for="tanggal" class="col-sm-4 col-form-label">{{ __('Tanggal') }}</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" id="tanggal" name="tanggal">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nomor" class="col-sm-4 col-form-label">{{ __('Nomor') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nomor" name="nomor">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="keterangan" class="col-sm-4 col-form-label">{{ __('Keterangan') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="keterangan" name="keterangan">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="file" class="col-sm-4 col-form-label">{{ __('File') }}</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="" id="file" name="file">
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
            <div class="modal fade" id="delete-justifikasi">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="modal-title" class="modal-title">{{ __('Delete Justifikasi') }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" id="delete" action="{{ route('product.justifikasi.delete') }}"
                                method="post">
                                @csrf
                                @method('delete')
                                <input type="hidden" id="delete_id" name="delete_id">
                            </form>
                            <div>
                                <p>Anda yakin ingin menghapus justifikasi nomor <span id="delete_name"
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
    </section>
@endsection
@section('custom-js')
    <script>
        function resetForm() {
            $('#save').trigger("reset");
            $('#justifikasi_id').val('');
            $('#tanggal').val('');
            $('#nomor').val('');
            $('#keterangan').val('');
            $('#file').val('');
        }

        function addJustifikasi() {
            resetForm();
            $('#modal-title').text("Add New Justfiikasi");
            $('#button-save').text("Add");
        }

        function editJustifikasi(data) {
            resetForm();
            $('#modal-title').text("Edit Jusifikasi");
            $('#button-save').text("Simpan");
            $('#justifikasi_id').val(data.id);
            $('#tanggal').val(data.tanggal);
            $('#nomor').val(data.nomor);
            $('#keterangan').val(data.keterangan);
        }

        function deleteJustifikasi(data) {
            $('#delete_id').val(data.id);
            $('#delete_name').text(data.nomor);
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
