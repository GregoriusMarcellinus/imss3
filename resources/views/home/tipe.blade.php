@extends('layouts.home')
@section('title', __('Dashboard'))
@section('custom-css')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <style>
        button {
            background-color: transparent;
            border: none;
        }
    </style>
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-7">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/img/akhlak_main.png" class="d-block w-100" height="400" alt="/img/slide4.png"
                                    style="object-fit: contain">
                            </div>
                            <div class="carousel-item">
                                <img src="/img/slide2.JPG" class="d-block w-100" height="400" alt="/img/slide4.png"
                                    style="object-fit: cover">
                            </div>
                            <div class="carousel-item">
                                <img src="/img/slide4.png" class="d-block w-100" height="400" alt="/img/slide4.png"
                                    style="object-fit: contain">
                            </div>
                            <div class="carousel-item">
                                <img src="/img/slide1.jpg" class="d-block w-100" height="400" alt="/img/slide4.png"
                                    style="object-fit: contain">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators"
                            data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators"
                            data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-5">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="font-weight-bold text-center">Menu {{ $title }}</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-4">
                                    <a href="{{ !empty($routeBack) ? url($routeBack) : url('/') }}">
                                        <div class="small-box bg-success"
                                            style="border-radius: 0px;box-shadow:0 0 0px transparent;border: 5px solid yellow">
                                            <div class="inner text-center py-4" style="background-color: darkcyan;">
                                                <i class="fas fa-arrow-left" style="font-size:2rem"></i>
                                                <p class="mb-0 mt-2"> Kembali</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @foreach ($menus as $menu)
                                    <div class="col-4">
                                        <a href="{{ url($menu['route']) }}">
                                            <div class="small-box bg-success"
                                                style="border-radius: 0px;box-shadow:0 0 0px transparent;border: 5px solid yellow">
                                                <div class="inner text-center py-4"
                                                    style="background-color: {{ $menu['bgcolor'] }};">
                                                    <i class="fas fa-{{ $menu['icon'] }} " style="font-size:2rem"></i>
                                                    <p class="mb-0 mt-2">{{ $menu['name'] }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
