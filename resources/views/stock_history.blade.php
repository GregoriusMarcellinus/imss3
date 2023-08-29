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
                <button typo="button" class="btn btn-danger" id="deleteAllselected"></i>Delete All Selected</button>
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
                                <th><input type="checkbox" name="" id="sellect_all_ids"></th>
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
                                <th></th>
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
                                <tr id="stock_ids{{$d->stock_id}}">
                                    <td><input type="checkbox" name="ids" class="checkbox_ids" id="" value="{{ $d->stock_id}}"></td>
                                    <td class="text-center">{{ date('d/m/Y', strtotime($d->datetime)) }}</td>
                                    <td class="text-center">{{ $d->name }}</td>
                                    <td class="text-center">{{ $d->shelf_name }}</td>
                                    <td class="text-center">{{ $d->product_code }}</td>
                                    <td>{{ $d->product_name }}</td>
                                    <td class="text-center">{{ $d->no_nota }}</td>
                                    <td class="text-center">{{ $d->name }}</td>
                                    <td class="text-center">{{ $in }}</td>
                                    <td class="text-center">{{ $out }}</td>
                                    <td class="text-center">{{ $retur }}</td>
                                    <td class="text-center">{{ $d->ending_amount }}</td>
                                    <td class="text-center">{{ $d->satuan }}</td>
                                    <td class="text-center">
                                    <button title="Hapus Riwayat" type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete-history" onclick="deleteHistory({{ json_encode($d) }})"><i class="fas fa-trash"></i></button></td>
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
        <div class="modal fade" id="delete-history">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">{{ __('Delete History') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="delete" action="{{ route('products.stock.history.delete') }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="hidden" id="delete_id" name="id">
                    </form>
                    <div>
                        <p>Anda yakin ingin menghapus riwayat ini<span id="pcode" class="font-weight-bold"></span>?</p>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Batal') }}</button>
                    <button id="button-save" type="button" class="btn btn-danger" onclick="document.getElementById('delete').submit();">{{ __('Ya, hapus') }}</button>
                </div>
            </div>
        </div>
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
        function deleteHistory(data){
            $('#delete_id').val(data.stock_id);
        }
    </script>

    <script>
        $(function(e){
            $("#sellect_all_ids").click(function(){
                $('.checkbox_ids').prop('checked',$(this).prop('checked'));
            });

            $('#deleteAllselected').click(function(e){
                e.preventDefault();
                var all_ids = [];
                $('input:checkbox[name=ids]:checked').each(function(){
                    all_ids.push($(this).val());
                });
                console.log(all_ids)
                
                $.ajax({
                    url:"{{ route('history.delete') }}",
                    type:"DELETE",
                    data:{
                        ids:all_ids,
                        _token:'{{ csrf_token() }}'
                    },
                    success:function(response){
                        $.each(all_ids,function(key,val){
                            $('#stock_ids'+val).remove();
                        })
                        //window.location.reload()
                }
                })
        })
        });
        </script>
@endsection