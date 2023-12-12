@extends('layouts.home')
@section('title', __('Dashboard'))
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
@endsection
@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row mb-5">
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container">
            <div class="row my-5">
                <div class="col-12">
                    <h5 class="font-weight-bold text-center">Unauthorized! Anda tidak diperbolehkan mengakses menu ini</h5>
                    <div class="d-flex justify-content-center">
                        <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Menu Utama</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
