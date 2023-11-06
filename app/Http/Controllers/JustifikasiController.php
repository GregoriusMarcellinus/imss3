<?php

namespace App\Http\Controllers;

use App\Models\Justifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class JustifikasiController extends Controller
{
    public function index()
    {
        $items = Justifikasi::leftJoin('users', 'users.id', '=', 'justifikasi.user_id')
            ->select('justifikasi.*', 'users.name as pic')
            ->paginate(10);
        return view('justifikasi.index', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $justifikasi_id = $request->justifikasi_id;
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
            if (!empty($justifikasi_id)) {
                //unlink
                $justifikasi = Justifikasi::where('id', $justifikasi_id)->first();
                $file_path = public_path() . '/justifikasi/' . $justifikasi->file;
                unlink($file_path);
            }
            $file = $request->file('file');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'justifikasi';
            $file->move($tujuan_upload, $nama_file);
        } else {
            if (empty($justifikasi_id)) {
                return redirect()->route('product.justifikasi')->with('error', 'File harus diisi');
            } else {
                $just = Justifikasi::where('id', $justifikasi_id)->first();
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

        if (empty($justifikasi_id)) {
            $add = Justifikasi::create($data);
            if ($add) {
                return redirect()->route('product.justifikasi')->with('success', 'Data berhasil ditambahkan');
            } else {
                return redirect()->route('product.justifikasi')->with('error', 'Data gagal ditambahkan');
            }
        } else {
            $update = Justifikasi::where('id', $justifikasi_id)->update($data);

            if ($update) {
                return redirect()->route('product.justifikasi')->with('success', 'Data berhasil diubah');
            } else {
                return redirect()->route('product.justifikasi')->with('error', 'Data gagal diubah');
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

        $delete = Justifikasi::where('id', $delete_id)->delete();

        if ($delete) {
            return redirect()->route('product.justifikasi')->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->route('product.justifikasi')->with('error', 'Data gagal dihapus');
        }
    }
}
