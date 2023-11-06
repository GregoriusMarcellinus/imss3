<?php

namespace App\Http\Controllers;

use App\Models\Keproyekan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KeproyekanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $search = $request->q;
        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $keproyekans = Keproyekan::paginate(50);

        if ($search) {
            $keproyekans = Keproyekan::where('nama_proyek', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $categories = Keproyekan::where("warehouse_id", $warehouse_id)->get();

            return response()->json($categories);
        } else {
            return view('keproyekan', compact('keproyekans'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proyek_id = $request->id;
        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }
        $request->validate([
            'nama_proyek' => 'required'
        ], [
            'nama_proyek.required' => 'Nama Proyek harus diisi'
        ]);

        $data = [
            'nama_proyek' => $request->nama_proyek,
            'warehouse_id' => $warehouse_id
        ];

        if (empty($proyek_id)) {
            $add = Keproyekan::create($data);

            if ($add) {
                return redirect()->route('keproyekan.index')->with('success', 'Data berhasil ditambahkan');
            } else {
                return redirect()->route('keproyekan.index')->with('error', 'Data gagal ditambahkan');
            }
        } else {
            $update = Keproyekan::where('id', $proyek_id)->update($data);

            if ($update) {
                return redirect()->route('keproyekan.index')->with('success', 'Data berhasil diubah');
            } else {
                return redirect()->route('keproyekan.index')->with('error', 'Data gagal diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete_id = $request->id;
        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $delete = Keproyekan::where('warehouse_id', $warehouse_id)->where('id', $delete_id)->delete();

        if ($delete) {
            DB::table('products')->where([["category_id", $request->delete_id], ["warehouse_id", $warehouse_id]])->update(["keproyekan_id" => null]);
            return redirect()->route('keproyekan.index')->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->route('keproyekan.index')->with('error', 'Data gagal dihapus');
        }
    }
}
