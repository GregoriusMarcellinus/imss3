<?php

namespace App\Http\Controllers;

use App\Models\Bom;
use App\Models\DetailPo;
use App\Models\DetailPR;
use App\Models\DetailSpph;
use App\Models\Keproyekan;
use App\Models\Lppb;
use App\Models\Purchase_Order;
use App\Models\PurchaseRequest;
use App\Models\RegistrasiBarang;
use App\Models\Spph;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use stdClass;

class BomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->q;

        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $requests = Bom::select('bom.*', 'proyek.nama_proyek as proyek_name')
            ->leftjoin('proyek', 'proyek.id', '=', 'bom.proyek_id')
            ->orderBy('bom.id', 'asc')
            ->paginate(50);

        $proyeks = DB::table('proyek')->get();
        //  dd($requests);

        if ($search) {
            $requests = Bom::where('kode_material', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $requests = Bom::where("warehouse_id", $warehouse_id)->get();

            return response()->json($requests);
        } else {

            //looping the paginate
            foreach ($requests as $request) {
                $detail_pr = DetailPR::where('id_pr', $request->id)->get();
                //if detail_pr empty then editable true
                if ($detail_pr->isEmpty()) {
                    $request->editable = TRUE;
                } else {
                    //looping detail_pr then check in detailspph with id_detail_pr exist
                    foreach ($detail_pr as $detail) {
                        $detail_spph = DetailSpph::where('id_detail_pr', $detail->id)->first();
                        $po = Purchase_Order::where('id', $detail->id_po)->first();
                        if ($po && $po->tipe == '1') {
                            $request->editable = FALSE;
                            break;
                        } else {
                            if ($detail_spph) {
                                $request->editable = FALSE;
                                break;
                            } else {
                                $request->editable = TRUE;
                            }
                        }
                    }
                }
            }
            return view('bom.index', compact('requests', 'proyeks'));
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
        //Store untuk menambah data
        $bom = $request->id;
        $request->validate(
            [
                'proyek_id' => 'nullable',
                'nomor' => 'nullable',
                'proyek'=> 'nullable',
                'tanggal'=> 'required|date',
                'kode_material'=> 'nullable',
                'deskripsi_material'=> 'nullable',
                'spesifikasi'=> 'nullable',
                'p1'=> 'nullable',
                'p3'=> 'nullable',
                'p6'=> 'nullable',
                'p12'=> 'nullable',
                'p24'=> 'nullable',
                'p36'=> 'nullable',
                'p48'=> 'nullable',
                'p60'=> 'nullable',
                'p72'=> 'nullable',
                'protective_part'=> 'nullable',
                'satuan'=> 'nullable',
                'keterangan'=> 'nullable',
            ],
            [
                'proyek_id.required' => 'Proyek harus diisi',
                'nomor.required' => 'No PR harus diisi',
                'tanggal.required' => 'Dasar PR harus diisi',
                
            ]
        );

        if (empty($bom)) {
            DB::table('bom')->insert([
                'proyek_id' => $request->proyek_id,
                'nomor' => $request->nomor,
                'proyek' => $request->proyek,
                'tanggal' => $request->tanggal,
                'kode_material' => $request->kode_material,
                'deskripsi_material' => $request->deskripsi_material,
                'spesifikasi' => $request->spesifikasi,
                'p1' => $request->p1,
                'p3' => $request->p3,
                'p6' => $request->p6,
                'p12' => $request->p12,
                'p24' => $request->p24,
                'p36' => $request->p36,
                'p48' => $request->p48,
                'p60' => $request->p60,
                'p72' => $request->p72,
                'protective_part' => $request->protective_part,
                'satuan' => $request->satuan,
                'keterangan' => $request->keterangan,
                // 'id_user' => auth()->user()->id,
            ]);

            return redirect()->route('bom.index')->with('success', 'BOM berhasil ditambahkan');
        } else {
            DB::table('bom')->where('id', $bom)->update([
                'proyek_id' => $request->proyek_id,
                'nomor' => $request->nomor,
                'proyek' => $request->proyek,
                'tanggal' => $request->tanggal,
                'kode_material' => $request->kode_material,
                'deskripsi_material' => $request->deskripsi_material,
                'spesifikasi' => $request->spesifikasi,
                'p1' => $request->p1,
                'p3' => $request->p3,
                'p6' => $request->p6,
                'p12' => $request->p12,
                'p24' => $request->p24,
                'p36' => $request->p36,
                'p48' => $request->p48,
                'p60' => $request->p60,
                'p72' => $request->p72,
                'protective_part' => $request->protective_part,
                'satuan' => $request->satuan,
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->route('bom.index')->with('success', 'BOM berhasil diupdate');
        }

        // return redirect()->route('purchase_request.index')->with('success', 'Purchase Request berhasil disimpan');

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
