<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PurchaseRequestController extends Controller
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

        $requests = PurchaseRequest::select('purchase_request.*', 'keproyekan.nama_proyek as proyek_name')
            ->join('keproyekan', 'keproyekan.id', '=', 'purchase_request.proyek_id')
            ->paginate(50);

        if ($search) {
            $requests = PurchaseRequest::where('nama_proyek', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $requests = PurchaseRequest::where("warehouse_id", $warehouse_id)->get();

            return response()->json($requests);
        } else {
            return view('purchase_request', compact('requests'));
        }
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
        $purchase_request = $request->id;
        $validated = $request->validate([
            'proyek_id' => 'required',
            'no_pr' => 'required',
            'dasar_pr' => 'required',
            'tgl_pr' => 'required',
        ],
        [
            'proyek_id.required' => 'Proyek harus diisi',
            'no_pr.required' => 'No PR harus diisi',
            'dasar_pr.required' => 'Dasar PR harus diisi',
            'tgl_pr.required' => 'Tanggal PR harus diisi',
        ]);

        if (empty($purchase_request)) {
            DB::table('purchase_request')->insert([
                'proyek_id' => $request->proyek_id,
                'no_pr' => $request->no_pr,
                'dasar_pr' => $request->dasar_pr,
                'tgl_pr' => $request->tgl_pr,
            ]);
        } else {
            DB::table('purchase_request')->where('id', $purchase_request)->update([
                'proyek_id' => $request->proyek_id,
                'no_pr' => $request->no_pr,
                'dasar_pr' => $request->dasar_pr,
                'tgl_pr' => $request->tgl_pr,
            ]);
        }

        return redirect()->route('purchase_request.index')->with('success', 'Purchase Request berhasil disimpan');

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
}
