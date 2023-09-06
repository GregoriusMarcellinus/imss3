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
        // $type = $request->type;
        // $query = $request->q;

        // $materials = SheetController::getDataSheet($request)->original;

        // // Create a collection
        // $materialsCollection = collect($materials);

        // if ($query) {
        //     $materialsCollection = $materialsCollection->filter(function ($item) use ($query) {
        //         //search by kode_material or nama_barang
        //         return false !== stristr($item['kode_material'], $query) || false !== stristr($item['nama_barang'], $query);
        //     });
        // }

        // // Define the number of items per page
        // $perPage = 20;

        // // Create a LengthAwarePaginator instance
        // $currentPage = $request->page ?: 1;
        // $pagedMaterials = $materialsCollection->slice(($currentPage - 1) * $perPage, $perPage);
        // $materials = new LengthAwarePaginator($pagedMaterials, $materialsCollection->count(), $perPage, $currentPage, ['path' => $request->url(), 'query' => $request->query()]);


        // return view('kode_material', compact('materials'));
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

        $materials = SheetController::getDataSheet($request)->original;

        $data = [
            'success' => true,
            'message' => 'Data berhasil diambil',
            'materials' => $materials,
        ];

        return response()->json($data);
    }
}
