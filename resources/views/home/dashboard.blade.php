@extends('layouts.home')
@section('title', __('Dashboard'))
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <style>
        button {
            background-color: transparent;
            border: none;

        }
    </style>
@endsection
@section('content')
    <section class="content mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-3">
                    <h2 class="font-weight-bold text-center">Welcome To MALES</h2>
                    <p class="font-italic text-center">Manufactur Logistic Enterprise Software</p>
                </div>
            </div>
        </div>
    </section>

    <div class="content-header mt-3">
        <div class="container-fluid">
            {{-- <div class="row mb-5"> --}}
            <div>
                {{-- <div class="col-7"> --}}
                <div>
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('img/akhlak_main.png') }}" class="d-block w-100" height="400"
                                    alt="/img/slide4.png" style="object-fit: contain">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/slide2.jpg') }}" class="d-block w-100" height="400"
                                    alt="/img/slide4.png" style="object-fit: contain">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/slide4.png') }}" class="d-block w-100" height="400"
                                    alt="/img/slide4.png" style="object-fit: contain">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/slide1.jpg') }}" class="d-block w-100" height="400"
                                    alt="/img/slide4.png" style="object-fit: contain">
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

                {{-- <div class="container-fluid" style="background-color: white;">
                    <h2 class="font-weight-bold text-center"style="padding-top: 28px;">Pilih Menu :</h2>
                    <div>
                        <div class="row">
                            @foreach ($menus2 as $menu)
                                <div>
                                    <a href="{{ url($menu['route']) }}" class="btnmenu">
                                        <div class="small-box bg-success"
                                            style="border-radius: 0px;box-shadow:0 0 0px transparent;border: 5px solid yellow">
                                            <div class="inner text-center py-4"
                                                style="background-color: {{ $menu['bgcolor'] }};">
                                                <i class="fas fa-{{ $menu['icon'] }} " style="font-size:2rem"></i>
                                                <h4 class="mb-0 mt-2">{{ $menu['name'] }}</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                </div> --}}
                <hr class="mb-4" />

                <div class="container-fluid" style="background-color: rgba(240, 237, 237, 0.42);">
                    <h2 class="font-weight-bold text-center"style="padding-top: 28px;">Menu :</h2>
                    <div class="row">
                        @foreach ($menus as $menu)
                            <div class="col-4">
                                <div class="menu-data"
                                    style="border-radius: 1rem;background-color: aliceblue;box-shadow: 0 0 15px;">

                                    {{-- <div class="menu-body">
                                                <h2 class="font-weight-bold text-center"style="padding-top: 28px;"> </h2>
                                            </div> --}}

                                    <a href="{{ url($menu['route']) }}">
                                        <div class="small-box" style="border-radius: 0px;box-shadow:0 0 0px transparent">
                                            <div class="">
                                                <img src="{{ $menu['img'] }}" class="d-block w-100 img-fluid"
                                                    height="110" alt="/img/logistik.png" style="object-fit: contain">
                                                {{-- <i class="fas fa-{{ $menu['icon'] }} " style="font-size:2rem"></i> --}}
                                                {{-- <h4 class="mb-0 mt-2">{{ $menu['name'] }}</h4> --}}
                                            </div>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        @endforeach


                    </div>

                </div>
            </div>



        </div>
    </div>
    </div>

@endsection
