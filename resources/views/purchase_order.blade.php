@extends('layouts.main')
@section('title', __('Purchase Order'))
@section('custom-css')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
                                                'no' => $purchases->firstItem() + $key,
                                                'vid' => $d->vendor_id,
                                                'nopo' => $d->no_po,
                                                'tgpo' => date('d/m/Y H:i:s', strtotime($d->tanggal_po)),
                                                'btpo' => date('d/m/Y H:i:s', strtotime($d->batas_po)),
                                            ];
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $data['no'] }}</td>
                                            <td class="text-center">{{ $data['vid'] }}</td>
                                            <td>{{ $data['nopo'] }}</td>
                                            <td class="text-center">{{ $data['tgpo'] }}</td>
                                            <td class="text-center">{{ $data['btpo'] }}</td>
                                            <td class="text-center">
                                                <button title="Edit PO" type="button" class="btn btn-success btn-xs"
                                                    data-toggle="modal" data-target="#add-po"
                                                    onclick="editSjn({{ json_encode($data) }})"><i
                                                        class="fas fa-edit"></i></button>

                                                <button title="Lihat Detail" type="button" data-toggle="modal"
                                                    data-target="#detail-po" class="btn-lihat btn btn-info btn-xs"
                                                    data-detail="{{ json_encode($data) }}"><i
                                                        class="fas fa-barcode"></i></button>
                                                @if (Auth::user()->role == 0)
                                                    <button title="Hapus PO" type="button"
                                                        class="btn btn-danger btn-xs" data-toggle="modal"
                                                        data-target="#delete-po"
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
    <div class="modal fade" id="add-po">
        <div class="modal-dialog">
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
                                <input type="text" class="form-control" id="vendor_id" name="vendor_id">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal_po" class="col-sm-4 col-form-label">{{ __('Tanggal PO') }} </label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="tanggal_po" name="tanggal_po">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="batas_po" class="col-sm-4 col-form-label">{{ __('Batas Akhir PO') }} </label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="batas_po" name="batas_po">
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
        });

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
