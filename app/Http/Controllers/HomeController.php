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
                // 'route' => 'apps/spph',
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
                // 'route' => 'apps/purchase_request',
                'route' => 'div/wilayah1',
                'bgcolor' => 'red',
                'icon' => 'map-marker-alt'
            ],
            [
                'name' => 'Wilayah 2',
                // 'route' => 'apps/purchase_request',
                'route' => 'div/wilayah1',
                'bgcolor' => 'goldenrod',
                'icon' => 'map'
            ],
            [
                'name' => 'Engineer',
                // 'route' => 'apps/purchase_request',
                'route' => 'div/eng',
                'bgcolor' => 'violet',
                'icon' => 'wrench'
            ],
            [
                'name' => 'Proyek KA',
                // 'route' => 'apps/purchase_request',
                'route' => 'div/proyek',
                'bgcolor' => 'black',
                'icon' => 'train'
            ],
        ];

        $menus2 = [
            [
                'name' => 'Surat Keluar',
                'route' => 'apps/surat-keluar',
                'bgcolor' => 'green',
                'icon' => 'envelope'
            ],
            // [
            //     'name' => 'Peraturan Direksi',
            //     // 'route' => 'apps/spph',
            //     'route' => 'apps/peraturan-direksi',
            //     'bgcolor' => 'violet',
            //     'icon' => 'gavel'
            // ],
        ];

        return view('home.dashboard', compact('menus', 'menus2'));
    }

    public function appType($type)
    {
        if ($type == "logistik") {
            $menus = [
                [
                    'name' => 'Purchase Request',
                    'route' => 'apps/purchase_request',
                    'bgcolor' => 'sagegreen',
                    'icon' => 'cart-arrow-down'
                ],
                [
                    'name' => 'SPPH',
                    'route' => 'apps/spph',
                    'bgcolor' => 'orange',
                    'icon' => 'mail-bulk'
                ],
                [
                    'name' => 'Tracking Purchase Request',
                    'route' => 'apps/purchase_request',
                    'bgcolor' => 'red',
                    'icon' => 'route'
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
                // [
                //     'name' => 'Stock IN',
                //     'route' => 'apps/stock_in',
                //     'bgcolor' => 'blue',
                //     'icon' => 'warehouse'
                // ],
                // [
                //     'name' => 'Stock OUT',
                //     'route' => 'apps/stock_out',
                //     'bgcolor' => 'red',
                //     'icon' => 'map-marker-alt'
                // ],
                // [
                //     'name' => 'Retur',
                //     'route' => 'apps/retur',
                //     'bgcolor' => 'goldenrod',
                //     'icon' => 'retweet'
                // ]
            ];
            $title = "Gudang";
        } else if ($type == "wilayah1") {
            $menus = [
                [
                    'name' => 'Purchase Request',
                    'route' => 'apps/purchase_request',
                    'bgcolor' => 'sagegreen',
                    'icon' => 'cart-arrow-down'
                ],
                [
                    'name' => 'Tracking Purchase Request',
                    'route' => 'apps/purchase_request',
                    'bgcolor' => 'red',
                    'icon' => 'route'
                ]
            ];
            $title = "Wilayah 1";
        } else if ($type == "wilayah2") {
            $menus = [
                [
                    'name' => 'Purchase Request',
                    'route' => 'apps/purchase_request',
                    'bgcolor' => 'sagegreen',
                    'icon' => 'cart-arrow-down'
                ],
                [
                    'name' => 'Tracking Purchase Request',
                    'route' => 'apps/purchase_request',
                    'bgcolor' => 'red',
                    'icon' => 'route'
                ]
            ];
            $title = "Wilayah 2";
        } else if ($type == 'eng') {
            $menus = [
                [
                    'name' => 'Justifikasi',
                    'route' => 'apps/justifikasi',
                    'bgcolor' => 'sagegreen',
                    'icon' => 'folder-open'
                ],
                [
                    'name' => 'Tracking Purchase Request',
                    'route' => 'apps/purchase_request',
                    'bgcolor' => 'red',
                    'icon' => 'route'
                ]
            ];
            $title = "Engineer";
        }

        return view('home.tipe', compact('menus', 'title'));
    }
}
