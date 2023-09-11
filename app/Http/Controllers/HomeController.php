<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function getWarehouse()
    {
        $controller = new ProductController;
        return $controller->getWarehouse();
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $warehouse = $this->getWarehouse();
        return View::make("home")->with(compact("warehouse"));
    }

    public function unauthorized()
    {
        return view('home.unauthorized');
    }

    public function indexAwal()
    {
        $menus = [
            [
                'name' => 'Logistik',
                'route' => 'div/logistik',
                'bgcolor' => 'sagegreen',
                'icon' => 'box'
            ],
            [
                'name' => 'Gudang',
                'route' => 'div/gudang',
                'bgcolor' => 'blue',
                'icon' => 'warehouse'
            ],
            [
                'name' => 'Wilayah 1',
                'route' => 'div/wilayah1',
                'bgcolor' => 'red',
                'icon' => 'map-marker-alt'
            ],
            [
                'name' => 'Wilayah 2',
                'route' => 'div/wilayah2',
                'bgcolor' => 'goldenrod',
                'icon' => 'map'
            ],
        ];

        return view('home.dashboard', compact('menus'));
    }

    public function appType($type)
    {
        if ($type == "logistik") {
            $menus = [
                [
                    'name' => 'SPPH',
                    'route' => 'apps/spph',
                    'bgcolor' => 'orange',
                    'icon' => 'mail-bulk'
                ],
                [
                    'name' => 'Purchase Order',
                    'route' => 'apps/purchase_orders',
                    'bgcolor' => 'chocolate',
                    'icon' => 'hand-holding-usd'
                ],
            ];
            $title = "Logistik";
        } else if ($type == "gudang") {
            $menus = [
                [
                    'name' => 'Purchase Order',
                    'route' => 'apps/purchase_orders',
                    'bgcolor' => 'sagegreen',
                    'icon' => 'hand-holding-usd'
                ],
                [
                    'name' => 'Surat Jalan',
                    'route' => 'apps/surat_jalan',
                    'bgcolor' => 'orange',
                    'icon' => 'mail-bulk'
                ],
                [
                    'name' => 'Stock IN',
                    'route' => 'apps/stock_in',
                    'bgcolor' => 'blue',
                    'icon' => 'warehouse'
                ],
                [
                    'name' => 'Stock OUT',
                    'route' => 'apps/stock_out',
                    'bgcolor' => 'red',
                    'icon' => 'map-marker-alt'
                ],
            ];
            $title = "Gudang";
        } else if ($type == "wilayah1") {
            $menus = [
                [
                    'name' => 'Purchase Request',
                    'route' => 'apps/purchase_request',
                    'bgcolor' => 'sagegreen',
                    'icon' => 'hand-holding-usd'
                ],
                [
                    'name' => 'SPPH',
                    'route' => 'apps/spph',
                    'bgcolor' => 'orange',
                    'icon' => 'mail-bulk'
                ]
            ];
            $title = "Wilayah 1";
        } else if ($type == "wilayah2") {
            $menus = [
                [
                    'name' => 'Purchase Request',
                    'route' => 'apps/purchase_request',
                    'bgcolor' => 'sagegreen',
                    'icon' => 'hand-holding-usd'
                ],
                [
                    'name' => 'SPPH',
                    'route' => 'apps/spph',
                    'bgcolor' => 'orange',
                    'icon' => 'mail-bulk'
                ]
            ];
            $title = "Wilayah 2";
        }

        return view('home.tipe', compact('menus', 'title'));
    }
}
