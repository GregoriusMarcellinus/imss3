@extends('layouts.main')
@section('title', __('Work In Progress (WIP)'))
@section('custom-css')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#wip-form" onclick="addProduct()"><i class="fas fa-plus"></i> Add New WIP</button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#import-product" onclick="importProduct()"><i class="fas fa-file-excel"></i> Import WIP (Excel)</button>
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
                                <th>{{ __('Kode Barang') }}</th>
                                <th>{{ __('Nama Barang') }}</th>
                                <th>{{ __('Stok') }}</th>
                                <th>{{ __('Satuan') }}</th>
                                <th>{{ __('Tanggal Masuk') }}</th>
                                <th>{{ __('Keterangan') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($products) > 0)
                            @foreach($products as $key => $d)
                            @php
                                $data = [
                                            "no"        => $products->firstItem() + $key,
                                            "pid"       => $d->product_wip_id,
                                            "pcode"     => $d->product_code,
                                            "pname"     => $d->product_name,
                                            "pamount"   => $d->product_amount,
                                            "satuan"    => $d->satuan,
                                            "date_in"   => date("d/m/Y H:i:s", strtotime($d->date_in)),
                                            "keterangan"   => $d->keterangan,
                                        ];
                            @endphp
                            <tr>
                                <td class="text-center">{{ $data['no'] }}</td>
                                <td class="text-center">{{ $data['pcode'] }}</td>
                                <td>{{ $data['pname'] }}</td>
                                <td class="text-center">{{ $data['pamount'] }}</td>
                                <td class="text-center">{{ $data['satuan'] }}</td>
                                <td class="text-center">{{ $data['date_in'] }}</td>
                                <td class="text-center">{{ $data['keterangan'] }}</td>
                                <td class="text-center"><button title="Selesai" type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#wip-complete" onclick="wipComplete({{ json_encode($data) }})"><i class="fas fa-check"></i></button> 
                                    <button title="Hapus" type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete-product" onclick="deleteProduct({{ json_encode($data) }})"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr class="text-center">
                                <td colspan="8">{{ __('No data.') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
        {{ $products->appends(request()->except('page'))->links("pagination::bootstrap-4") }}
        </div>
    </div>
    <div class="modal fade" id="wip-form">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">{{ __('Add New WIP') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <img width="300px" src="/img/scan.jpg"/>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control" id="pcode" name="pcode" min="0" placeholder="Product Code">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="button-check" onclick="productCheck()">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="loader" class="card">
                        <div class="card-body text-center">
                            <div class="spinner-border text-danger" style="width: 3rem; height: 3rem;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div id="form" class="card">
                        <div class="card-body">
                            <form role="form" id="save" action="{{ route('products.wip.save') }}" method="post">
                                @csrf
                                <input type="hidden" id="product_code" name="product_code" />
                                <div class="form-group row">
                                    <label for="pname" class="col-sm-4 col-form-label">{{ __('Nama Barang') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="pname" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="no_nota" class="col-sm-4 col-form-label">{{ __('No. SJN') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="no_nota" name="no_nota">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="keterangan" class="col-sm-4 col-form-label">{{ __('Keterangan') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="keterangan" name="keterangan">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pamount" class="col-sm-4 col-form-label">{{ __('Jumlah') }}</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="pamount" name="pamount" min="1" value="1">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="wip_date" class="col-sm-4 col-form-label">Tanggal</label>
                                    <div class="col-sm-8">
                                        <div class="input-group date" id="wip_date" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input wip_date_text" id="wip_date" name="wip_date" data-target="#wip_date"/>
                                            <div class="input-group-append" data-target="#wip_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                    <button id="button-update" type="button" class="btn btn-primary" onclick="$('#save').submit()">{{ __('Tambahkan') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="delete-product">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">{{ __('Delete Product') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="delete" action="{{ route('products.wip.delete') }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="hidden" id="delete_id" name="id">
                    </form>
                    <div>
                        <p>Anda yakin ingin menghapus product code <span id="delete_pcode" class="font-weight-bold"></span>?</p>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Batal') }}</button>
                    <button id="button-save" type="button" class="btn btn-danger" onclick="$('#delete').submit();">{{ __('Ya, hapus') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="wip-complete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">{{ __('Selesai') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="complete" action="{{ route('products.wip.complete') }}" method="post">
                        @csrf
                        <input type="hidden" id="wip_id" name="wip_id">
                        <div class="form-group row">
                            <label for="wip_pcode" class="col-sm-4 col-form-label">{{ __('Product Code') }}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="wip_pcode" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="wip_amount" class="col-sm-4 col-form-label">{{ __('Amount') }}</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="wip_amount" name="amount" min="1">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Batal') }}</button>
                    <button id="button-save" type="button" class="btn btn-success" onclick="$('#complete').submit();">{{ __('Stock In') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="import-product">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Import WIP (Excel)</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form role="form" enctype="multipart/form-data" id="import" action="{{ route('products.wip.import') }}" method="post">
                    @csrf
                    <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="file" name="file">
                        <label class="custom-file-label" for="file">Choose file</label>
                    </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Batal') }}</button>
            <button type="button" class="btn btn-default" id="download-template">{{ __('Download Template') }}</button>
            <button type="button" class="btn btn-primary" onclick="$('#import').submit();">{{ __('Import') }}</button>
            </div>
        </div>
        </div>
    </div>
</section>
@endsection
@section('custom-js')
    <script src="/plugins/toastr/toastr.min.js"></script>
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script src="/plugins/moment/moment.min.js"></script>
    <script src="/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <script src="/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
            var user_id;
            $('#form').hide();
            loader(0);
            $('.select2').select2({
            theme: 'bootstrap4'
            });

            $('#wip_date').datetimepicker({
                viewMode: 'years',
                format: 'MM/DD/YYYY HH:mm:ss'
            });

            $('#pcode').on('input', function() {
                $("#form").hide();
                $("#button-update").hide();
            });
        });

        function resetForm(){
            $('#form').trigger("reset");
            $('#pcode').val('');
            $('#product_code').val('');
            $("#button-update").hide();
            $('#pcode').prop("disabled", false);
            $('#button-check').prop("disabled", false);
        }

        function enableStockInput(){
            $('#button-update').prop("disabled", false);
            $("#button-update").show();
            $('#form').show();
        }

        function disableStockInput(){
            $('#button-update').prop("disabled", true);
            $("#button-update").hide();
            $('#form').hide();
        }

        function loader(status=1){
            if(status == 1){
                $('#loader').show();
            } else {
                $('#loader').hide();
            }
        }

        function productCheck(){
            var pcode = $('#pcode').val();
            if(pcode.length > 0){
                loader();
                $('#form').hide();
                $('#pcode').prop("disabled", true);
                $('#button-check').prop("disabled", true);
                $.ajax({
                    url: '/products/check/'+pcode,
                    type: "GET",
                    data: {"format": "json"},
                    dataType: "json",
                    success:function(data) {
                        loader(0);
                        if(data.status == 1){
                            $('#pcode').val(data.data.product_code);
                            $('#product_code').val(data.data.product_code);
                            $('#pname').val(data.data.product_name);
                            enableStockInput();
                        } else {
                            disableStockInput();
                            toastr.error("Product Code tidak dikenal!");
                        }
                        $('#pcode').prop("disabled", false);
                        $('#button-check').prop("disabled", false);
                    }, error:function(){
                        $('#pcode').prop("disabled", false);
                        $('#button-check').prop("disabled", false);
                    }
                });
            } else {
                toastr.error("Product Code belum diisi!");
            }
        }

        function addProduct(){
            $("#form").hide();
            resetForm();
            $('#modal-title').text("Add New WIP");
            $('#button-save').text("Tambahkan");
        }

        function editProduct(data){
            $('#modal-title').text("Edit");
            $('#button-save').text("Simpan");
            resetForm();
            $('#save_id').val(data.pid);
            $('#product_code').val(data.pcode);
            $('#product_name').val(data.pname);
            $('#product_amount').val(data.pamount);
        }

        function wipComplete(data){
            $('#wip_id').val(data.pid);
            $('#wip_pcode').val(data.pcode);
            $('#wip_amount').val(data.pamount);
        }

        function deleteProduct(data){
            $('#delete_id').val(data.pid);
            $('#delete_pcode').text(data.pcode);
            $('#button-save').text("Ya, hapus");
        }

        $("#download-template").click(function(){
            $.ajax({
                url: '/downloads/template_import_wip.xls',
                type: "GET",
                xhrFields: {
                    responseType: 'blob'
                },
                success:function(data) {                    
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(data);
                    a.href = url;
                    a.download = "template_import_wip.xls";
                    document.body.append(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                }
            });
        });
    </script>
    @if(Session::has('success'))
        <script>toastr.success('{!! Session::get("success") !!}');</script>
    @endif
    @if(Session::has('error'))
        <script>toastr.error('{!! Session::get("error") !!}');</script>
    @endif
    @if(!empty($errors->all()))
        <script>toastr.error('{!! implode("", $errors->all("<li>:message</li>")) !!}');</script>
    @endif
@endsection