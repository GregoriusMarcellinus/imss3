@extends('layouts.main')
@section('title', __('Vendor'))
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-vendor"
                        onclick="addvendor()"><i class="fas fa-plus"></i> Add New Vendor</button>
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
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th>No.</th>
                                    <th>{{ __('Nama Vendor') }}</th>
                                    <th>{{ __('Alamat Vendor') }}</th>
                                    <th>{{ __('Telepon Vendor') }}</th>
                                    <th>{{ __('Fax Vendor') }}</th>
                                    <th>{{ __('Email Vendor') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($vendors) > 0)
                                    @foreach ($vendors as $key => $d)
                                        @php
                                            $data = [
                                                'no' => $vendors->firstItem() + $key,
                                                'id' => $d->id,
                                                'nama' => $d->nama,
                                                'alamat' => $d->alamat,
                                                'telp' => $d->telp,
                                                'fax' => $d->fax,
                                                'email' => $d->email,
                                            ];
                                        @endphp
                                        <tr>
                                            <td class="text-center"><input type="checkbox" name="hapus[]"
                                                value="{{ $d->id }}"></td>
                                            <td class="text-center">{{ $data['no'] }}</td>
                                            <td class="text-center">{{ $data['nama'] }}</td>
                                            <td class="text-center">{{ $data['alamat'] }}</td>
                                            <td class="text-center">{{ $data['telp'] }}</td>
                                            <td class="text-center">{{ $data['fax'] }}</td>
                                            <td class="text-center">{{ $data['email'] }}</td>

                                            <td class="text-center">
                                                <button title="Edit Vendor" type="button" class="btn btn-success btn-xs"
                                                    data-toggle="modal" data-target="#add-vendor"
                                                    onclick="editVendor({{ json_encode($data) }})"><i
                                                        class="fas fa-edit"></i></button>
                                                        @if (Auth::user()->role == 0 || Auth::user()->role == 4)
                                                    <button title="Hapus Produk" type="button"
                                                        class="btn btn-danger btn-xs" data-toggle="modal"
                                                        data-target="#delete-product"
                                                        onclick="deleteVendor({{ json_encode($data) }})"><i
                                                            class="fas fa-trash"></i></button>
                                                @endif
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
                        <button type="button" class="btn btn-danger" id="delete-selected"
                            data-token="{{ csrf_token() }}">Hapus yang dipilih</button>
                    </div>
                </div>
            </div>
            <div>
                {{ $vendors->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
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

        //Fungsi Select All Delete
        $('#select-all').change(function() {
            var checkboxes = $(this).closest('table').find(':checkbox');
            checkboxes.prop('checked', $(this).is(':checked'));
        });

        // Function to handle delete selected items
        $('#delete-selected').click(function() {
            var ids = [];
            $('input[name="hapus[]"]:checked').each(function() {
                ids.push($(this).val());
            });

            if (ids.length > 0) {
                var token = $(this).data('token');
                $.ajax({
                    url: 'vendor-imss/hapus-multiple',
                    type: 'POST',
                    data: {
                        _token: token,
                        ids: ids
                    },
                    success: function(response) {
                        if (response.success) {
                            // Menghapus status checked dari semua checkbox
                            $('input[name="hapus[]"]').prop('checked', false);
                            $('#select-all').prop('checked', false);
                            // Memuat ulang halaman setelah berhasil menghapus data
                            location.reload();
                            alert('Data berhasil dihapus');
                        } else {
                            alert('Gagal menghapus data');
                        }
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan saat menghapus data');
                    }
                });
            } else {
                alert('Pilih setidaknya satu item untuk dihapus');
            }
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
