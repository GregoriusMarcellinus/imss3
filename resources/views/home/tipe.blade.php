@extends('layouts.home')
@section('title', __('Dashboard'))
@section('custom-css')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
@endsection
@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 mt-3">
                    <h2 class="font-weight-bold text-center">Selamat Datang Di Software IMSS</h2>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col">
                            <h2 class="text-center">OUR VALUE</h2>
                            <hr style="width: 20%; border-top: 2px solid #b01919;">
                        </div>
                    </div>
                        <div class="row rounded mb-2" style="border: 1px solid #b01919;">
                            <div class="col">
                                <h3 class="font-weight-bold text-center mt-2 mb-0">TANGGAP</h3>
                                <p class="text-justify p-2">Senantiasa berusaha untuk memberikan pelayanan yang dapat memuaskan kebutuhan pelanggan secara cepat, tepat dan sesuai dengan persyaratan yang ditetapkan.</p>
                            </div>
                        </div>
                        <div class="row rounded mb-2" style="border: 1px solid #b01919;">
                            <div class="col">
                                <h3 class="font-weight-bold text-center mt-2 mb-0">TANGKAS</h3>
                                <p class="text-justify p-2">Mampu bekerja secara sigap / cekatan untuk memenuhi kebutuhan pelanggan tanpa mengurangi kualitas yang dipersyaratkan.</p>
                            </div>
                        </div>
                        <div class="row rounded mb-2" style="border: 1px solid #b01919;">
                            <div class="col">
                                <h3 class="font-weight-bold text-center mt-2 mb-0">BERKUALITAS</h3>
                                <p class="text-justify p-2">Kemampuan meningkatkan mutu pelayanan secara terus - menerus sesuai dengan persyaratan pelanggan</p>
                            </div>
                        </div>
                </div>
                <div class="col-1"></div>
                <div class="col-5">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="font-weight-bold text-center">Menu {{ $title }}</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
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
                            <div class="col-12">
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
            </div>
        </div>
    </section>
@endsection
