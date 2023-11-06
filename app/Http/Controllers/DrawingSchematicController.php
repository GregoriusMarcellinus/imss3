<?php

namespace App\Http\Controllers;

use App\Models\DrawingSchematic;
use Illuminate\Http\Request;

class DrawingSchematicController extends Controller
{
    public function index()
    {
        $items = DrawingSchematic::leftJoin('users', 'users.id', '=', 'drawing_schematic.user_id')
            ->select('drawing_schematic.*', 'users.name as pic')
            ->paginate(10);
        return view('drawing_schematic.index', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $drawing_id = $request->drawing_id;
        $request->validate([
            'tanggal' => 'required',
            'nomor' => 'required',
            'keterangan' => 'required',
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
            'nomor.required' => 'Nomor harus diisi',
            'keterangan.required' => 'Keterangan harus diisi',
        ]);

        //store file in public/justifikasi

        if ($request->hasFile('file')) {
            if (!empty($drawing_id)) {
                //unlink
                $justifikasi = DrawingSchematic::where('id', $drawing_id)->first();
                $file_path = public_path() . '/drawing/' . $justifikasi->file;
                unlink($file_path);
            }
            $file = $request->file('file');
            $nama_file = time() . "_" . $file->getClientOriginalExtension();
            $tujuan_upload = 'drawing';
            $file->move($tujuan_upload, $nama_file);
        } else {
            if (empty($drawing_id)) {
                return redirect()->route('product.drawing.schematic')->with('error', 'File harus diisi');
            } else {
                $just = DrawingSchematic::where('id', $drawing_id)->first();
                $nama_file = $just->file;
            }
        }

        $data = [
            'tanggal' => $request->tanggal,
            'nomor' => $request->nomor,
            'keterangan' => $request->keterangan,
            'file' => $nama_file,
            'user_id' => auth()->user()->id
        ];

        if (empty($drawing_id)) {
            $add = DrawingSchematic::create($data);
            if ($add) {
                return redirect()->route('product.drawing.schematic')->with('success', 'Data berhasil ditambahkan');
            } else {
                return redirect()->route('product.drawing.schematic')->with('error', 'Data gagal ditambahkan');
            }
        } else {
            $update = DrawingSchematic::where('id', $drawing_id)->update($data);

            if ($update) {
                return redirect()->route('product.drawing.schematic')->with('success', 'Data berhasil diubah');
            } else {
                return redirect()->route('product.drawing.schematic')->with('error', 'Data gagal diubah');
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
        $delete_id = $request->delete_id;

        $delete = DrawingSchematic::where('id', $delete_id);

        //unlink file
        $file_path = public_path() . '/drawing/' . $delete->first()->file;
        unlink($file_path);
        $delete->delete();

        if ($delete) {
            return redirect()->route('product.drawing.schematic')->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->route('product.drawing.schematic')->with('error', 'Data gagal dihapus');
        }
    }
}
