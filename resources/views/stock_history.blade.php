@extends('layouts.main')
@section('title', __('Stock History'))
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
                <button type="button" class="btn btn-primary" onclick="download('xls')"><i class="fas fa-file-excel"></i> Export XLS</button>
                <button type="button" class="btn btn-primary" onclick="download('pdf')"><i class="fas fa-file-pdf"></i> Export PDF</button>
                <div class="card-tools">
                    <form>
                        <div class="input-group input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search" value="{{ Request::get('search') }}">
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
                @if(!empty(Request::get('search')))
                <div class="pb-3">
                    <span>Hasil pencarian:</span> <span class="font-weight-bold">"{{ Request::get('search') }}"</span>
                </div>
                @endif
                <div class="table-responsive">
                    <table id="table" class="table table-sm table-bordered table-hover table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>{{ __('Tanggal') }}</th>
                                <th>{{ __('User') }}</th>
                                <th>{{ __('Lokasi') }}</th>
                                <th>{{ __('Kode Barang') }}</th>
                                <th>{{ __('Nama Barang') }}</th>
                                <th>{{ __('No. SJN') }}</th>
                                <th>{{ __('Nama Vendor') }}</th>
                                <th>{{ __('Stock In') }}</th>
                                <th>{{ __('Stock Out') }}</th>
                                <th>{{ __('Retur') }}</th>
                                <th>{{ __('Stok') }}</th>
                                <th>{{ __('Satuan') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($history) > 0)
                            @foreach($history as $key => $d)
                                @php
                                    if($d->type == 0){
                                        $in     = "";
                                        $out    = $d->product_amount;
                                        $retur  = "";
                                    } else if($d->type == 1){
                                        $in     = $d->product_amount;
                                        $out    = "";
                                        $retur  = "";
                                    } else {
                                        $in     = "";
                                        $out    = "";
                                        $retur  = $d->product_amount;
                                    }

                                @endphp
                                <tr>
                                    <td class="text-center">{{ date('d/m/Y', strtotime($d->datetime)) }}</td>
                                    <td class="text-center">{{ $d->name }}</td>
                                    <td class="text-center">{{ $d->shelf_name }}</td>
                                    <td class="text-center">{{ $d->product_code }}</td>
                                    <td>{{ $d->product_name }}</td>
                                    <td class="text-center">{{ $d->no_nota }}</td>
                                    <td class="text-center">{{ $d->stock_name }}</td>
                                    <td class="text-center">{{ $in }}</td>
                                    <td class="text-center">{{ $out }}</td>
                                    <td class="text-center">{{ $retur }}</td>
                                    <td class="text-center">{{ $d->ending_amount }}</td>
                                    <td class="text-center">{{ $d->satuan }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="text-center">
                                <td colspan="10">{{ __('No data.') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
        {{ $history->links("pagination::bootstrap-4") }}
        </div>
    </div>
</section>
@endsection
@section('custom-js')
    <script src="/plugins/toastr/toastr.min.js"></script>
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script>
        $(function () {
            $('.select2').select2({
            theme: 'bootstrap4'
            });
        });

        $('#sort').on('change', function() {
            $("#sorting").submit();
        });

        function download(type){
            window.location.href="{{ route('products.stock.history') }}?search={{ Request::get('search') }}&dl="+type;
        }
    </script>
@endsection