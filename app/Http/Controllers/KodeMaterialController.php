<?php

namespace App\Http\Controllers;

use App\Models\KodeMaterial;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KodeMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        return view('kode_material');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function apiKodeMaterial(Request $request)
    {
        $type = $request->type; //inka or imss

        $kode = $request->kode;

        if (!$kode) {
            $materials = SheetController::getDataSheet($request)->original;
            $data = [
                'success' => true,
                'message' => 'Data berhasil diambil',
                'materials' => $materials,
            ];

            return response()->json($data);
        } else {
            $materials = SheetController::getDataSheet($request)->original;
            $materials = collect($materials)->filter(function ($item) use ($kode) {
                //search by kode_material or nama_barang
                return false !== stristr($item['kode_material'], $kode) || false !== stristr($item['nama_barang'], $kode);
            });

            if ($materials->count() == 0) {
                $data = [
                    'success' => false,
                    'message' => 'Data tidak ditemukan',
                    'materials' => [],
                ];

                return response()->json($data);
            } else {
                $materials = $materials->values()->all();
                $materials = $materials[0];
                $data = [
                    'success' => true,
                    'message' => 'Data ditemukan',
                    'materials' => $materials,
                ];
                //return only 1 item array

                return response()->json($data);
            }
        }
    }
}
