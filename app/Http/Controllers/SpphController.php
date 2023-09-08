<?php

namespace App\Http\Controllers;

use App\Models\DetailPR;
use App\Models\DetailSpph;
use App\Models\Spph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class SpphController extends Controller
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

        $spphes = Spph::paginate(50);

        if ($search) {
            $spphes = Spph::where('tanggal_spph', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $categories = Spph::where("warehouse_id", $warehouse_id)->get();

            return response()->json($categories);
        } else {
            return view('spph', compact('spphes'));
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
        $spph = $request->id;
        // if (Session::has('selected_warehouse_id')) {
        //     $warehouse_id = Session::get('selected_warehouse_id');
        // } else {
        //     $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        // }

        $request->validate([
            'nomor_spph' => 'required',
            'tanggal_spph' => 'required',
            'batas_spph' => 'required',
            'perihal' => 'required',
            'penerima' => 'required',
            'alamat' => 'required'
        ], [
            'nomor_spph.required' => 'Nomor SPPH harus diisi',
            'tanggal_spph.required' => 'Tanggal SPPH harus diisi',
            'batas_spph.required' => 'Batas SPPH harus diisi',
            'perihal.required' => 'Perihal harus diisi',
            'penerima.required' => 'Penerima harus diisi',
            'alamat.required' => 'Alamat harus diisi'
        ]);

        $data = [
            'nomor_spph' => $request->nomor_spph,
            'tanggal_spph' => $request->tanggal_spph,
            'batas_spph' => $request->batas_spph,
            'perihal' => $request->perihal,
            'penerima' => $request->penerima,
            // 'warehouse_id' => $warehouse_id
            'alamat' => $request->alamat
        ];

        if (empty($spph)) {
            $add = Spph::create($data);

            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'SPPH berhasil ditambahkan',
            //     'data' => $add
            // ]);
            if ($add) {
                return redirect()->route('spph.index')->with('success', 'SPPH berhasil ditambahkan');
            } else {
                return redirect()->route('spph.index')->with('error', 'SPPH gagal ditambahkan');
            }
        } else {
            $update = Spph::where('id', $spph)->update($data);

            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'SPPH berhasil diupdate',
            //     'data' => $update
            // ]);

            if ($update) {
                return redirect()->route('spph.index')->with('success', 'SPPH berhasil diupdate');
            } else {
                return redirect()->route('spph.index')->with('error', 'SPPH gagal diupdate');
            }
        }

        // return redirect()->route('spph.index')->with('success', 'SPPH berhasil disimpan');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
        $delete_spph = $request->id;
        $delete_spph = DB::table('spph')->where('id', $delete_spph)->delete();

        if ($delete_spph) {
            return redirect()->route('spph.index')->with('success', 'Data SPPH berhasil dihapus');
        } else {
            return redirect()->route('spph.index')->with('error', 'Data SPPH gagal dihapus');
        }
    }

    public function getDetailSPPH(Request $request)
    {
        $id = $request->id;
        $spph = Spph::where('id', $id)->first();

        $spph->details = DetailSpph::where('spph_id', $id)
            ->leftjoin('detail_pr', 'detail_pr.id', '=', 'detail_spph.id_detail_pr')
            ->get();
        $spph->details = $spph->details->map(function ($item) {
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            return $item;
        });

        return response()->json([
            'spph' => $spph
        ]);
    }

    public function getProductPR()
    {
        $products = DetailPR::all();

        $products = $products->map(function ($item) {
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            return $item;
        });

        return response()->json([
            'products' => $products
        ]);
    }

    public function spphPrint(Request $request)
    {
        $id = $request->spph_id;
        $spph = Spph::where('id', $id)->first();

        $spph->details = DetailSpph::where('spph_id', $id)
            ->leftjoin('detail_pr', 'detail_pr.id', '=', 'detail_spph.id_detail_pr')
            ->get();

        // dd($spph);

        $page_count = 0;
        $dummy = PDF::loadview('spph_print', compact('spph', 'page_count'));
        $dummy->setPaper('A4', 'Potrait');
        $no_spph = $spph->nomor_spph;
        $dummy->render();
        $page_count = $dummy->get_canvas()->get_page_count();
        $pdf = PDF::loadview('spph_print', compact('spph', 'page_count'));
        $pdf->setPaper('A4', 'Potrait');
        return $pdf->stream('SPPH_' . $no_spph . '.pdf');
    }

    function tambahSpphDetail(Request $request)
    {
        $id = $request->spph_id;
        $id_barang = $request->product_id;

        DetailSpph::create([
            'spph_id' => $id,
            'id_detail_pr' => $id_barang
        ]);

        $spph = Spph::where('id', $id)->first();

        $spph->details = DetailSpph::where('spph_id', $id)
            ->leftjoin('detail_pr', 'detail_pr.id', '=', 'detail_spph.id_detail_pr')
            ->get();
        $spph->details = $spph->details->map(function ($item) {
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            return $item;
        });

        return response()->json([
            'spph' => $spph
        ]);
    }
}
