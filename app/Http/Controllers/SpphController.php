<?php

namespace App\Http\Controllers;

use App\Models\DetailPR;
use App\Models\DetailSpph;
use App\Models\Keproyekan;
use App\Models\Purchase_Order;
use App\Models\PurchaseRequest;
use App\Models\Spph;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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
            foreach ($spphes as $key => $item) {
                $id = json_decode($item->vendor_id);
                $item->vendor = Vendor::whereIn('id', $id)->get();
                $item->vendor = $item->vendor->map(function ($item) {
                    return $item->nama;
                });
                //change $item->vendor collection to array
                $item->vendor = $item->vendor->toArray();
                $item->vendor = implode(', ', $item->vendor);
            }
        $vendors = Vendor::all();
// dd($spphes);
        if ($search) {
            $spphes = Spph::where('tanggal_spph', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $categories = Spph::where("warehouse_id", $warehouse_id)->get();

            return response()->json($categories);
        } else {
            return view('spph.spph', compact('spphes', 'vendors'));
        }
    }

    public function indexApps(Request $request)
    {
        $search = $request->q;

        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $spphes = Spph::paginate(50);
        $vendors = Vendor::all();

        if ($search) {
            $spphes = Spph::where('tanggal_spph', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $categories = Spph::where("warehouse_id", $warehouse_id)->get();

            return response()->json($categories);
        } else {
            return view('home.apps.logistik.spph', compact('spphes', 'vendors'));
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
            // 'lampiran' => 'required',
            'vendor' => 'required',
            'tanggal_spph' => 'required',
            'batas_spph' => 'required',
            'perihal' => 'required',
            // 'penerima' => 'required',
            // 'alamat' => 'required'
        ], [
            'nomor_spph.required' => 'Nomor SPPH harus diisi',
            // 'lampiran.required' => 'Lampiran harus diisi',
            'vendor.required' => 'Vendor harus diisi',
            'tanggal_spph.required' => 'Tanggal SPPH harus diisi',
            'batas_spph.required' => 'Batas SPPH harus diisi',
            'perihal.required' => 'Perihal harus diisi',
            'penerima.required' => 'Penerima harus diisi',
            'alamat.required' => 'Alamat harus diisi'
        ]);

        $data = [
            'nomor_spph' => $request->nomor_spph,
            'lampiran' => $request->lampiran,
            // 'vendor' =>json_encode($request->vendor_id),
            'vendor' =>json_encode('$request->vendor_id'),
            'tanggal_spph' => $request->tanggal_spph,
            'batas_spph' => $request->batas_spph,
            'perihal' => $request->perihal,
            'penerima' => json_encode($request->penerima),
            // 'warehouse_id' => $warehouse_id
            'alamat' => json_encode($request->alamat)
        ];

        // dd($data);

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
        //join spph penerima ['x','y'] to x,y
        $spph->penerima = json_decode($spph->penerima);
        $spph->penerima = implode(', ', $spph->penerima);

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

    public function getProductPR(Request $request)
    {
        $proyek = $request->proyek;
        $proyek = strtolower($proyek);
        $products = DetailPR::all();

        $products = $products->map(function ($item) {
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->nomor_spph = Spph::where('id', $item->id_spph)->first()->nomor_spph ?? '';
            $item->pr_no = PurchaseRequest::where('id', $item->id_pr)->first()->no_pr ?? '';
            $item->po_no = Purchase_Order::where('id', $item->id_po)->first()->no_po ?? '';
            $item->nama_proyek = Keproyekan::where('id', $item->id_proyek)->first()->nama_proyek ?? '';
            return $item;
        });

        //filter nama proyek LIKE
        $products = $products->filter(function ($item) use ($proyek) {
            return strpos(strtolower($item->nama_proyek), $proyek) !== false;
        });
        // dd($products);

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
        $spph->tanggal_spph = Carbon::parse($spph->tanggal_spph)->isoFormat('D MMMM Y');
        $spph->batas_spph = Carbon::parse($spph->batas_spph)->isoFormat('D MMMM Y');

        // dd($spph);

        // $page_count = 0;
        // $dummy = PDF::loadview('spph_print', compact('spph', 'page_count'));
        // $dummy->setPaper('A4', 'Potrait');
        // $no_spph = $spph->nomor_spph;
        // $dummy->render();
        // $page_count = $dummy->get_canvas()->get_page_count();
        // $pdf = PDF::loadview('spph_print', compact('spph', 'page_count'));

        $penerimas = $spph->penerima;
        $penerimas = json_decode($penerimas);

        $alamats = $spph->alamat;
        $alamats = json_decode($alamats);

        $newObjects = [];
        foreach ($penerimas as $key => $penerima) {
            $newObject = new \stdClass();
            $newObject->nama = $penerima;
            $newObject->alamat = $alamats[$key];
            $newObjects[] = $newObject;
        }

        $spphs = $newObjects;
        $count = count($spphs);

        $pdf = PDF::loadview('spph.spph_print', compact('spph', 'spphs', 'count'));
        $no_spph = $spph->nomor_spph;
        $pdf->setPaper('A4', 'Potrait');
        return $pdf->stream('SPPH_' . $no_spph . '.pdf');
    }

    function tambahSpphDetail(Request $request)
    {
        $id = $request->spph_id;
        $selected = $request->selected_id;

        //foreach selected_id

        foreach ($selected as $key => $value) {
            $id_barang = $value;
            $add = DetailSpph::create([
                'spph_id' => $id,
                'id_detail_pr' => $id_barang
            ]);

            $update = DetailPR::where('id', $id_barang)->update([
                'id_spph' => $id,
                'status' => 1,
            ]);
        }

        $spph = Spph::where('id', $id)->first();
        $spph->penerima = json_decode($spph->penerima);
        $spph->penerima = implode(', ', $spph->penerima);

        $spph->details = DetailSpph::where('spph_id', $id)
            ->leftjoin('detail_pr', 'detail_pr.id', '=', 'detail_spph.id_detail_pr')
            ->get();
        $spph->details = $spph->details->map(function ($item) {
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->nomor_spph = Spph::where('id', $item->id_spph)->first()->nomor_spph ?? '';
            return $item;
        });

        return response()->json([
            'spph' => $spph
        ]);
    }
}
