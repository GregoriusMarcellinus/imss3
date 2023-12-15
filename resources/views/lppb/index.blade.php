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
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-po"
                        onclick="addPo()"><i class="fas fa-print"></i> Cetak LPPB</button>
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
            $('#accept-barang').find('#id_registrasi_barang').val(data.id_registrasi_barang);
            $('#accept-barang').find('#nama_barang').val(data.uraian);
            $('#accept-barang').find('#kuantitas_po').val(data.qty);
        }

        function editBarang(data) {
            $('#edit-barang').find('#modal-title').text("Edit Pemeriksaan & Penerimaan Barang");
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
