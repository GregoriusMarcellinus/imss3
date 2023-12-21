@extends('layouts.main')
@section('title', 'Penghapusan Aset')
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
                    {{-- @auth
                        @if (Auth::user()->role == 0 || Auth::user()->role == 7)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-kode-aset"
                                onclick="addKodeAset()"><i class="fas fa-plus"></i> Add New {{ 'Penghapusan Aset' }}</button>
                        @endif
                    @endauth --}}
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
                                <th>Nomor Aset</th>
                                <th>Jenis Aset</th>
                                <th>Merek</th>
                                <th>No Seri</th>
                                <th>Kondisi</th>
                                <th>Lokasi/Unit Kerja</th>
                                <th>Pengguna</th>
                                <th>Tanggal Perolehan</th>
                                <th>Keterangan</th>
                                {{-- <th>{{ __('Aksi') }}</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $key => $d)
                                @php
                                    $data = $d->toArray();
                                @endphp
                                @php

                                    setLocale(LC_TIME, 'id');
                                    setlocale(LC_TIME, 'id_ID.utf8');
                                    \Carbon\Carbon::setLocale('id');

                                    $tanggal_perolehan = \Carbon\Carbon::parse($d->tanggal_perolehan)->isoFormat('D MMMM Y');

                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $d->nomor_aset }}</td>
                                    <td>{{ $d->jenis_aset }}</td>
                                    <td>{{ $d->merek }}</td>
                                    <td>{{ $d->no_seri }}</td>
                                    <td>{{ $d->kondisi }}</td>
                                    <td>{{ $d->lokasi }}</td>
                                    <td>{{ $d->pengguna }}</td>
                                    <td>{{ $tanggal_perolehan }}</td>
                                    <td>{{ $d->keterangan }}</td>
                                    {{-- <td class="text-center">
                                        @if (Auth::user()->role == 0 || Auth::user()->role == 7)
                                            <button title="Edit Shelf" type="button" class="btn btn-success btn-xs"
                                                data-toggle="modal" data-target="#add-kode-aset"
                                                onclick="editAset({{ json_encode($data) }})"><i
                                                    class="fas fa-edit"></i></button>
                                            <button title="Hapus Produk" type="button" class="btn btn-danger btn-xs"
                                                data-toggle="modal" data-target="#delete-suratkeluar"
                                                onclick="deleteAset({{ json_encode($data) }})"><i
                                                    class="fas fa-trash"></i></button>
                                        @endif
                                    </td> --}}
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
            <div>
                {{ $items->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>
@endsection
@section('custom-js')
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

        function editAset(data) {
            console.log(data)
            var title = "{{ 'Penghapusan Aset' }}"
            resetForm();
            $('#modal-title').text("Edit " + title);
            $('#button-save').text("Simpan");
            $('#id').val(data.id);
            $('#aset_id').val(data.aset_id);
            $('#nomor_aset').val(data.nomor_aset);
            $('#jenis_aset').val(data.jenis_aset);
            $('#merek').val(data.merek);
            $('#no_seri').val(data.no_seri);
            $('#kondisi').val(data.kondisi);
            $('#lokasi').val(data.lokasi);
            $('#pengguna').val(data.pengguna);
            $('#tanggal_perolehan').val(data.tanggal_perolehan);
            $('#keterangan').val(data.keterangan);

        }

        function deleteAset(data) {
            $('#delete_id').val(data.id);
            $('#delete_name').text(data.nomor_aset);
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
