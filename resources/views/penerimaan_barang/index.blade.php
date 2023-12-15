@extends('layouts.main')
@section('title', __('Penerimaan Barang'))
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
                                <th>{{ __('No PR') }}</th>
                                <th>{{ __('No PO') }}</th>
                                <th>{{ __('Jenis PO') }}</th>
                                <th>{{ __('Kode Material') }}</th>
                                <th>{{ __('Nama Barang') }}</th>
                                <th>{{ __('Spesifikasi') }}</th>
                                <th>{{ __('QTY') }}</th>
                                <th>{{ __('Satuan') }}</th>
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
        @if (Auth::user()->role == 0 || Auth::user()->role == 6)
            <div class="modal fade" id="accept-barang">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="modal-title" class="modal-title">{{ __('Konfirmasi Barang') }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" id="save" action="{{ route('registrasi_barang.save') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="id_barang" name="id_barang">
                                <div class="form-group row">
                                    <label for="nama_barang"
                                        class="col-sm-4 col-form-label">{{ __('Nama Barang') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="keterangan" class="col-sm-4 col-form-label">{{ __('Keterangan') }}</label>
                                    <div class="col-sm-8">
                                        <textarea type="text" class="form-control" id="keterangan" name="keterangan"></textarea>
                                    </div>
                                </div>
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
                            <form role="form" id="edit-registrasi-btn" action="{{ route('registrasi_barang.edit') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="id_barang" name="id_barang">
                                <div class="form-group row">
                                    <label for="nama_barang"
                                        class="col-sm-4 col-form-label">{{ __('Nama Barang') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="keterangan"
                                        class="col-sm-4 col-form-label">{{ __('Keterangan') }}</label>
                                    <div class="col-sm-8">
                                        <textarea type="text" class="form-control" id="keterangan" name="keterangan"></textarea>
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
            $('#accept-barang').find('#nama_barang').val(data.uraian);
        }

        function editBarang(data) {
            $('#edit-barang').find('#modal-title').text("Edit Konfirmasi Barang");
            resetForm();
            console.log(data);
            //find edit-barang modal then find #id_barang, #nama_barang
            // $('#id_barang').val(data.id);
            // $('#nama_barang').val(data.uraian);
            // $('#keterangan').val(data.keterangan);
            $('#edit-barang').find('#id_barang').val(data.id);
            $('#edit-barang').find('#nama_barang').val(data.uraian);
            $('#edit-barang').find('#keterangan').val(data.keterangan);
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
