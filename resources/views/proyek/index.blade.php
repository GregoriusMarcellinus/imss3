@extends('layouts.main')
@section('title', 'proyek')
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
                                onclick="addKodeAset()"><i class="fas fa-plus"></i> Add New Proyek</button>
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
                                    <th>Kode Tempat</th>
                                    <th>Nama Tempat</th>
                                    <th>Lokasi</th>
                                    <th>Nama Proyek</th>
                                    <th>Proyek Mulai</th>
                                    <th>Proyek Selesai</th>
                                    <th>Proyek Status</th>
                                    <th>Trainset Kode</th>
                                    <th>Trainset Nama</th>
                                    
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
                                        <td>{{ $d->kode_tempat }}</td>
                                        <td>{{ $d->nama_tempat }}</td>
                                        <td>{{ $d->lokasi }}</td>
                                        <td>{{ $d->nama_proyek  }}</td>
                                        <td>{{ $d->proyek_mulai  }}</td>
                                        <td>{{ $d->proyek_selesai }}</td>
                                        <td>{{ $d->proyek_status }}</td>
                                        <td>{{ $d->trainset_kode }}</td>
                                        <td>{{ $d->trainset_nama }}</td>
                                        
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
                                <h4 id="modal-title" class="modal-title">{{ __('Add New Proyek') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" id="save" action="{{ route('proyek.store') }}" method="post"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <input type="hidden" id="id" name="id">


                                    {{-- <div class="form-group row">
                                        <label for="nomor_aset" class="col-sm-4 col-form-label">{{ __('Nomor Aset') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nomor_aset" name="nomor_aset">
                                        </div>
                                    </div> --}}
                                    <div class="form-group row">
                                        <label for="kode_tempat" class="col-sm-4 col-form-label">{{ __('Kode Tempat') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="kode_tempat" name="kode_tempat">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nama_tempat" class="col-sm-4 col-form-label">{{ __('Nama Tempat') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nama_tempat" name="nama_tempat">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lokasi" class="col-sm-4 col-form-label">{{ __('Lokasi') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="lokasi" name="lokasi">
                                        </div>
                                    </div>
                                    {{-- <div class="form-group row">
                                        <label for="kondisi" class="col-sm-4 col-form-label">{{ __('Kondisi') }} </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="kondisi" name="kondisi">
                                                <option value="Baik">Baik</option>
                                                <option value="Rusak">Rusak</option>
                                                <option value="Hilang">Hilang</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="form-group row">
                                        <label for="nama_proyek" class="col-sm-4 col-form-label">{{ __('Nama Proyek') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nama_proyek" name="nama_proyek">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="proyek_mulai" class="col-sm-4 col-form-label">{{ __('Proyek Mulai') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="proyek_mulai" name="proyek_mulai">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="proyek_selesai" class="col-sm-4 col-form-label">{{ __('Proyek Selesai') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="proyek_selesai" name="proyek_selesai">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="proyek_status" class="col-sm-4 col-form-label">{{ __('Proyek Status') }} </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="proyek_status" name="proyek_status">
                                                <option value=""></option>
                                                <option value="Open">Open</option>
                                                <option value="Close">Close</option>
                                                
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="trainset_kode" class="col-sm-4 col-form-label">{{ __('Trainset Kode') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="trainset_kode" name="trainset_kode">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="trainset_nama" class="col-sm-4 col-form-label">{{ __('Trainset Nama') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="trainset_nama" name="trainset_nama">
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
                                <form role="form" id="delete" action="{{ route('proyek.destroy') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" id="delete_id" name="delete_id">
                                </form>
                                <div>
                                    <p>Anda yakin ingin menghapus proyek <span id="delete_name"
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
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Batal') }}</button>
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
            var title = "proyek"
            resetForm();
            $('#modal-title').text("Edit " + title);
            $('#button-save').text("Simpan");
            $('#id').val(data.id);
            $('#kode_tempat').val(data.kode_tempat);
            $('#nama_tempat').val(data.nama_tempat);
            $('#lokasi').val(data.lokasi);
            $('#nama_proyek').val(data.nama_proyek);
            $('#proyek_mulai').val(data.proyek_mulai);
            $('#proyek_selesai').val(data.proyek_selesai);
            $('#proyek_status').val(data.proyek_status);
            $('#trainset_kode').val(data.trainset_kode);
            $('#trainset_nama').val(data.trainset_nama);
            


        }

        function deleteproyek(data) {
            $('#delete_id').val(data.id);
            $('#delete_name').text(data.nama_proyek);
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
