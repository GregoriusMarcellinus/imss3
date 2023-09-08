@extends('layouts.home')
@section('title', __('Dashboard'))
@section('custom-css')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <style>
        .main-header,
        .main-footer,
        .content-wrapper {
            margin-left: 0px !important;
        }
    </style>
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
                    <h2 class="font-weight-bold text-center">Menu {{ $title }}</h2>
                </div>
            </div>
            <div class="row pt-5">
                <div class="col-lg-6 col-12">
                    <a href="{{ url('/') }}">
                        <div class="small-box bg-success">
                            <div class="inner" style="background-color: darkcyan;">
                                <p>Menu</p>
                                <h3>Utama</h3>
                            </div>
                            <div class="icon">
                                <i class="fas fa-arrow-left"></i>
                            </div>
                        </div>
                    </a>
                </div>
                @foreach ($menus as $menu)
                    <div class="col-lg-6 col-12">
                        <a href="{{ url($menu['route']) }}">
                            <div class="small-box bg-success">
                                <div class="inner" style="background-color: {{ $menu['bgcolor'] }};">
                                    <p>Fitur</p>
                                    <h3>{{ $menu['name'] }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-{{ $menu['icon'] }}"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
