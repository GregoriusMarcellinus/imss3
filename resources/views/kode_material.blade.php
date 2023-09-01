@extends('layouts.main')
@section('title', __('Kode Material'))
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
                    <button id="btn-inka" class="btn btn-outline-primary" onclick="getData('inka')">INKA</button>
                    <button id="btn-imss" class="btn btn-outline-primary" onclick="getData('imss')">IMSS</button>
                    {{-- <div class="card-tools">
                        <form>
                            <div class="input-group input-group">
                                <input type="text" class="form-control" name="q" placeholder="Search">
                                <input type="hidden" name="type" value="{{ request()->type }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable2" class="table table-sm table-bordered table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>{{ __('Kode Material') }}</th>
                                    <th>{{ __('Nama') }}</th>
                                    <th>{{ __('Speksifikasi') }}</th>
                                    <th>{{ __('Satuan') }}</th>
                                </tr>
                            </thead>
                            <tbody id="content-table">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal --}}
        <div class="modal fade" id="add-vendor">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Add New Vendor') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="save" action="{{ route('vendor.store') }}" method="post">
                            @csrf
                            <input type="hidden" id="save_id" name="id">
                            <div class="form-group row">
                                <label for="nama" class="col-sm-4 col-form-label">{{ __('Nama Vendor') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nama" name="nama">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-4 col-form-label">{{ __('Alamat Vendor') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="alamat" name="alamat">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telp" class="col-sm-4 col-form-label">{{ __('Telepon') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="telp" name="telp">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fax" class="col-sm-4 col-form-label">{{ __('Fax') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="fax" name="fax">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label">{{ __('Email') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="email" name="email">
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

        {{-- delete modal --}}
        <div class="modal fade" id="delete-product">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Delete Vendor') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="delete" action="{{ route('vendor.destroy') }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" id="delete_id" name="id">
                        </form>
                        <div>
                            <p>Anda yakin ingin menghapus vendor <span id="nm_proyek" class="font-weight-bold"></span>?
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Batal') }}</button>
                        <button id="button-save" type="button" class="btn btn-danger"
                            onclick="document.getElementById('delete').submit();">{{ __('Ya, hapus') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- custom js --}}
@section('custom-js')
    <script src="/plugins/toastr/toastr.min.js"></script>
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script src="/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
            var user_id;
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });

        $('#sort').on('change', function() {
            $("#sorting").submit();
        });


        function resetForm() {
            $('#save').trigger("reset");
        }

        function addvendor() {
            $('#modal-title').text("Add New Vendor");
            $('#button-save').text("Tambahkan");
            resetForm();
        }

        function editVendor(data) {
            $('#modal-title').text("Edit Vendor");
            $('#button-save').text("Simpan");
            resetForm();
            $('#save_id').val(data.id);
            $('#nama').val(data.nama);
            $('#alamat').val(data.alamat);
            $('#telp').val(data.telp);
            $('#fax').val(data.fax);
            $('#email').val(data.email);

        }

        function deleteVendor(data) {
            $('#delete_id').val(data.id);
            $('#nama').text(data.nama);
        }

        var dataTableInitialized = false;
        var dataTable;

        function initializeDataTable(data) {
            dataTable = $('#datatable2').DataTable({
                data: data,
                responsive: true,
                columns: [{
                        data: 'no',
                        title: '#',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'kode_material',
                        title: 'Kode Material'
                    },
                    {
                        data: 'nama_barang',
                        title: 'Nama'
                    },
                    {
                        data: 'spesifikasi',
                        title: 'Spesifikasi'
                    },
                    {
                        data: 'satuan',
                        title: 'Satuan'
                    },
                ]
            });
            dataTableInitialized = true;
        }

        function getData(type) {
            //jika type=inka, maka #btn-inka menjadi class btn btn-primary, dan #btn-imss menjadi class btn btn-outline-primary
            if (type == 'inka') {
                $('#btn-inka').removeClass('btn-outline-primary').addClass('btn-primary');
                $('#btn-imss').removeClass('btn-primary').addClass('btn-outline-primary');
                //disable both button
                $('#btn-inka').attr('disabled', true);
                $('#btn-imss').attr('disabled', true);
            } else {
                $('#btn-imss').removeClass('btn-outline-primary').addClass('btn-primary');
                $('#btn-inka').removeClass('btn-primary').addClass('btn-outline-primary');
                //disable both button
                $('#btn-inka').attr('disabled', true);
                $('#btn-imss').attr('disabled', true);
            }

            const table = $('#content-table');
            table.empty();
            //fetch api
            $.ajax({
                url: "{{ url('materials') }}?type=" + type,
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    table.append(`
                        <tr class="text-center">
                            <td colspan="8">{{ __('Loading...') }}</td>
                        </tr>
                    `);
                },
                success: function(d) {
                    $('#btn-inka').attr('disabled', false);
                    $('#btn-imss').attr('disabled', false);
                    const data = d.materials
                    console.log(data);
                    if (data.length > 0) {
                        if (dataTableInitialized) {
                            // Hapus dan reinisialisasi DataTables
                            dataTable.clear().rows.add(data).draw();
                        } else {
                            // Inisialisasi DataTables
                            initializeDataTable(data);
                        }
                    } else {
                        table.append(`
                            <tr class="text-center">
                                <td colspan="8">{{ __('No data.') }}</td>
                            </tr>
                        `);
                    }


                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        $(document).ready(function() {
            getData('inka');
        });
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
