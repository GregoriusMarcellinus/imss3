<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VendorController extends Controller
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

        $vendors = Vendor::paginate(50);

        if ($search) {
            $vendors = Vendor::where('nama', 'LIKE', "%$search%")->paginate(50);
        }

        // dd($vendors);
        if ($request->format == "json") {
            $categories = Vendor::where("warehouse_id", $warehouse_id)->get();

            return response()->json($categories);
        } else {
            return view('vendor', compact('vendors'));
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
        $vendor_id = $request->id;
        // if (Session::has('selected_warehouse_id')) {
        //     $warehouse_id = Session::get('selected_warehouse_id');
        // } else {
        //     $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        // }
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            // 'telp' => 'required',
            // 'fax' => 'required',
            // 'email' => 'required'
        ], [
            'nama.required' => 'Nama harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            // 'telp.required' => 'Telepon harus diisi',
            // 'fax.required' => 'Fax harus diisi',
            // 'email.required' => 'Email harus diisi'
        ]);

        $data = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'fax' => $request->fax,
            'email' => $request->email
        ];

        if (empty($vendor_id)) {
            $add = Vendor::create($data);

            if ($add) {
                return redirect()->route('vendor.index')->with('success', 'Data berhasil ditambahkan');
            } else {
                return redirect()->route('vendor.index')->with('error', 'Data gagal ditambahkan');
            }
        } else {
            $update = Vendor::where('id', $vendor_id)->update($data);

            if ($update) {
                return redirect()->route('vendor.index')->with('success', 'Data berhasil diubah');
            } else {
                return redirect()->route('vendor.index')->with('error', 'Data gagal diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
        $delete_id = $request->id;
        // if (Session::has('selected_warehouse_id')) {
        //     $warehouse_id = Session::get('selected_warehouse_id');
        // } else {
        //     $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        // }

        $delete = Vendor::where('id', $delete_id)->delete();

        // $delete = Vendor::find($delete_id)->delete();

        if ($delete) {
            return redirect()->route('vendor.index')->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->route('vendor.index')->with('error', 'Data gagal dihapus');
        }
    }
}
