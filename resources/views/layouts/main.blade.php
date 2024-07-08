<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    @hasSection('custom-css')
        @yield('custom-css')
    @endif
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <span class="nav-link">@yield('title')</span>
                </li>
            </ul>
            @if (!empty($warehouse))
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                            @if (Session::has('selected_warehouse_name'))
                                <i class="fas fa-warehouse"></i>
                                <span>{{ Session::get('selected_warehouse_name') }}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
                            style="left: inherit; right: 0px;">
                            <span class="dropdown-item dropdown-header">Warehouse</span>
                            @foreach ($warehouse as $w)
                                <a href="{{ route('warehouse') }}/change/{{ $w->warehouse_id }}"
                                    class="dropdown-item">
                                    {{ $w->warehouse_name }}
                                </a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            @endif
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: maroon;">
            <a href="/" class="brand-link text-center" style="background-color: rgb(255, 253, 253);">
                <img src="{{ asset('img/imss-remove.png') }}" class="d-block w-100" height="30" alt=""
                    style="object-fit: contain">
                <!--  <span class="brand-text font-weight-bold">{{ config('app.name', 'Warehouse') }}</span> -->
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @if (Auth::check())
                            <li class="nav-item">
                                <a class="nav-link {{ Route::current()->getName() == 'home' ? 'active' : '' }}"
                                    href="{{ route('home') }}">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p class="text">{{ __('Dashboard') }}</p>
                                </a>
                            </li>
                            @if (Auth::user()->role == 0 || Auth::user()->role == 4)
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'products.wip' ? 'active' : '' }}"
                                        href="{{ route('products.wip') }}">
                                        <i class="nav-icon fas fa-spinner"></i>
                                        <p class="text">{{ __('Work In Progress (WIP)') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'products.wip.history' ? 'active' : '' }}"
                                        href="{{ route('products.wip.history') }}">
                                        <i class="nav-icon fas fa-history"></i>
                                        <p class="text">{{ __('WIP History') }}</p>
                                    </a>
                                </li>
                            @endif

                            {{-- Menu Sidebar Vendor --}}
                            @if (Auth::user()->role == 0 || Auth::user()->role == 1 || Auth::user()->role == 4 || Auth::user()->role == 7)
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'vendor.index' ? 'active' : '' }}"
                                        href="{{ route('vendor.index') }}">
                                        <i class="nav-icon fas fa-user-cog"></i>
                                        <p class="text">{{ __('Vendor') }}</p>
                                    </a>
                                </li>
                            @endif
                            {{--End Menu Sidebar Vendor --}}

                            {{-- Menu Sidebar Warehouse --}}
                            @if (Auth::user()->role == 0 || Auth::user()->role == 4)
                                <li class="nav-header">Product</li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'products' ? 'active' : '' }}"
                                        href="{{ route('products') }}">
                                        <i class="nav-icon fas fa-boxes"></i>
                                        <p class="text">{{ __('Stok Barang') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'products.categories' ? 'active' : '' }}"
                                        href="{{ route('products.categories') }}">
                                        <i class="nav-icon fas fa-project-diagram"></i>
                                        <p class="text">{{ __('Kategori') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'products.shelf' ? 'active' : '' }}"
                                        href="{{ route('products.shelf') }}">
                                        <i class="nav-icon fas fa-cubes"></i>
                                        <p class="text">{{ __('Lokasi Penyimpanan') }}</p>
                                    </a>
                                </li>
                            @endif
                            {{-- End Menu Sidebar Warehouse --}}

                            {{-- Menu Sidebar Keproyekan --}}
                            @if (Auth::user()->role == 0 || Auth::user()->role == 8 || Auth::user()->role == 9)
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'keproyekan.index' ? 'active' : '' }}"
                                        href="{{ route('keproyekan.index') }}">
                                        <i class="nav-icon fas fa-hard-hat"></i>
                                        <p class="text">{{ __('Keproyekan') }}</p>
                                    </a>
                                </li>
                            @endif
                            {{-- End Menu Sidebar Keproyekan --}}
                            
                            {{-- Menu Sidebar Kode Material --}}
                            @if (Auth::user()->role == 0 ||
                                    Auth::user()->role == 1 ||
                                    Auth::user()->role == 2 ||
                                    Auth::user()->role == 3 ||
                                    Auth::user()->role == 4 ||
                                    Auth::user()->role == 7 ||
                                    Auth::user()->role == 8 ||
                                    Auth::user()->role == 9 ||
                                    Auth::user()->role == 10 ||
                                    Auth::user()->role == 11)
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'kode_material.index' ? 'active' : '' }}"
                                        href="{{ url('products/kode_material') }}">
                                        <i class="nav-icon fas fa-pallet"></i>
                                        <p class="text">{{ __('Kode Material') }}</p>
                                    </a>
                                </li>
                            @endif
                            {{-- End Menu Sidebar Kode Material --}}


                            {{-- @if (Auth::user()->role == 0)
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'keproyekan.index' ? 'active' : '' }}"
                                        href="{{ route('keproyekan.index') }}">
                                        <i class="nav-icon fas fa-hard-hat"></i>
                                        <p class="text">{{ __('Keproyekan') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'products.shelf' ? 'active' : '' }}"
                                        href="{{ route('products.shelf') }}">
                                        <i class="nav-icon fas fa-cubes"></i>
                                        <p class="text">{{ __('Lokasi Penyimpanan') }}</p>
                                    </a>
                                </li> --}}
                            {{-- <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'products.logistik' ? 'active' : '' }}"
                                        href="{{ route('products.logistik') }}">
                                        <i class="nav-icon fas fa-cubes"></i>
                                        <p class="text">{{ __('Tes Tracking Logistik') }}</p>
                                    </a>
                                </li> --}}
                            {{-- @endif --}}
                            <li class="nav-header">Settings</li>
                            @if (Auth::user()->role == 0)
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'warehouse' ? 'active' : '' }}"
                                        href="{{ route('warehouse') }}">
                                        <i class="nav-icon fas fa-warehouse"></i>
                                        <p class="text">{{ __('Warehouse') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'users' ? 'active' : '' }}"
                                        href="{{ route('users') }}">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p class="text">{{ __('Users') }}</p>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link {{ Route::current()->getName() == 'myaccount' ? 'active' : '' }}"
                                    href="{{ route('myaccount') }}">
                                    <i class="nav-icon fas fa-user-cog"></i>
                                    <p class="text">{{ __('My Account') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <form id="logout" action="{{ route('logout') }}" method="post">@csrf</form>
                                <a class="nav-link" href="javascript:;"
                                    onclick="document.getElementById('logout').submit();">
                                    <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                                    <p class="text">{{ __('Logout') }} ({{ Auth::user()->username }})</p>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                                    <p class="text">{{ __('Login') }}</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            @yield('content')
        </div>

        <footer class="main-footer">
            <b>PT</b> {{ config('app.version') }}
            <img src="{{ asset('img/garis.jpg') }}" style="width: 100%;" />
        </footer>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    @hasSection('custom-js')
        @yield('custom-js')
    @endif
    <script>
        let table = new DataTable('#datatable', {
            responsive: true
        });
    </script>
</body>

</html>
