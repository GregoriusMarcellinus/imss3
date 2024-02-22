@extends('layouts.main')
@section('title', 'jadwal')
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
                                onclick="addKodeAset()"><i class="fas fa-plus"></i> Add New Jadwal</button>
                            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#import-karyawan"
                                onclick="importKaryawan()"><i class="fas fa-file-excel"></i> Import Karyawan (Excel)</button>
                                <a type="button" class="btn btn-primary" href="{{route('karyawan.export')}}" ><i class="fas fa-file-excel"></i> Export Karyawan (Excel)</a> --}}
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
                    <div class="table-responsive">


                        <table id="table" class="table table-sm table-bordered table-hover table-striped">
                            <thead>
                                <tr class="text-center">

                                    <th>Nomor</th>
                                    <th>Kode Perawatan</th>
                                    <th>Nama Perawatan</th>
                                    <th>Periode Hari</th>
                                    <th>Catatan</th>
                                    


                                    <th>{{ __('Aksi') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $key => $d)
                                    @php
                                        $data = $d->toArray();
                                    @endphp

                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $d->kode_perawatan }}</td>
                                        <td>{{ $d->nama_perawatan }}</td>
                                        <td>{{ $d->periode_hari }}</td>
                                        <td>{{ $d->catatan }}</td>
                                        

                                        

                                        <td class="text-center">
                                            @if (Auth::user()->role == 0 || Auth::user()->role == 7)
                                                <button title="Edit Shelf" type="button" class="btn btn-success btn-xs"
                                                    data-toggle="modal" data-target="#add-kode-aset"
                                                    onclick="editProyek({{ json_encode($data) }})"><i
                                                        class="fas fa-edit"></i></button>
                                                <button title="Hapus Produk" type="button" class="btn btn-danger btn-xs"
                                                    data-toggle="modal" data-target="#delete-suratkeluar"
                                                    onclick="deleteproyek({{ json_encode($data) }})"><i
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
                                <h4 id="modal-title" class="modal-title">{{ __('Add New Jadwal') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" id="save" action="{{ route('jadwal.store') }}" method="post"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    {{-- @method('put') --}}
                                    <input type="hidden" id="id" name="id">


                                    {{-- <div class="form-group row">
                                        <label for="nomor_aset" class="col-sm-4 col-form-label">{{ __('Nomor Aset') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nomor_aset" name="nomor_aset">
                                        </div>
                                    </div> --}}
                                    


                                    


                                    <div class="form-group row">
                                        <label for="kode_perawatan" class="col-sm-4 col-form-label">{{ __('Kode Perawatan') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="kode_perawatan" name="kode_perawatan">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nama_perawatan" class="col-sm-4 col-form-label">{{ __('Nama Perawatan') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nama_perawatan" name="nama_perawatan">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="periode_hari" class="col-sm-4 col-form-label">{{ __('Periode Hari') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="periode_hari" name="periode_hari">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="catatan" class="col-sm-4 col-form-label">{{ __('Catatan') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="catatan" name="catatan">
                                        </div>
                                    </div>

                                    {{-- <div class="form-group row">
                                        <label for="file" class="col-sm-4 col-form-label">{{ __('File') }}</label>
                                        <div class="col-sm-8">
                                            <input type="file" class="form-control" id="file" name="file">
                                        </div>
                                    </div> --}}




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

                {{-- editProyek --}}

                {{-- endproyek --}}


                <div class="modal fade" id="delete-suratkeluar">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="modal-title" class="modal-title">{{ __('Delete Proyek') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" id="delete" action="{{ route('jadwal.destroy') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" id="delete_id" name="delete_id">
                                </form>
                                <div>
                                    <p>Anda yakin ingin menghapus Jadwal <span id="delete_name"
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
                <div class="modal fade" id="import-karyawan">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Import Karyawan (Excel)</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" enctype="multipart/form-data" id="import"
                                    action="{{ route('karyawan.import') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <div class="">
                                            <input type="file" class="" id="file" name="file">
                                            {{-- <label class="" for="file">Choose file</label> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default"
                                    data-dismiss="modal">{{ __('Batal') }}</button>
                                {{-- <button type="button" class="btn btn-default"
                                    id="download-template">{{ __('Download Template') }}</button> --}}
                                <button type="button" class="btn btn-primary"
                                    onclick="$('#import').submit();">{{ __('Import') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </section>
@endsection
@section('custom-js')

    {{-- menghitung umur, pensiun , dan mpp --}}
    <script>
        $(document).ready(function() {
            // Fungsi untuk menghitung umur dan tanggal pensiun
            function hitungUmur() {
                // Ambil nilai tanggal lahir dari input
                var tanggalLahir = $('#tanggal_lahir').val();

                // Hitung umur
                var today = new Date();
                var birthDate = new Date(tanggalLahir);
                var age = today.getFullYear() - birthDate.getFullYear();
                var months = today.getMonth() - birthDate.getMonth();
                if (months < 0 || (months === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                // Tampilkan umur
                $('#umur').val(age + ' Tahun ' + months + ' Bulan');

                // Hitung tanggal pensiun (tambah 56 tahun)
                // var mppDate = new Date(birthDate);
                // mppDate.setFullYear(mppDate.getFullYear() + 55);
                // mppDate.setMonth(mppDate.getMonth() + 9);
                // mppDate.setDate(mppDate.getDate() + 20);
                // var pensiunDate = new Date(birthDate);
                // pensiunDate.setFullYear(pensiunDate.getFullYear() + 56);
                // pensiunDate.setMonth(pensiunDate.getMonth() + 9);
                // pensiunDate.setDate(pensiunDate.getDate() + 20);

                // Tampilkan tanggal pensiun
                $('#mpp').val(mppDate.toISOString().split('T')[0]);
                $('#pensiun').val(pensiunDate.toISOString().split('T')[0]);
            }

            // Panggil fungsi saat input tanggal lahir berubah
            $('#tanggal_lahir').on('change', function() {
                hitungUmur();
            });
        });
    </script>

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

        function editProyek(data) {
            console.log(data)
            var title = "Jadwal"
            resetForm();
            $('#modal-title').text("Edit " + title);
            $('#button-save').text("Simpan");
            $('#id').val(data.id);
            $('#kode_perawatan').val(data.kode_perawatan);
            $('#nama_perawatan').val(data.nama_perawatan);
            $('#periode_hari').val(data.periode_hari);
            $('#catatan').val(data.catatan);
            



        }

        function deleteproyek(data) {
            $('#delete_id').val(data.id);
            // $('#delete_name').text(data.proyek_name);
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
