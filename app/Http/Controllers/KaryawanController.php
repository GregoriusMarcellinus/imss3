<?php

namespace App\Http\Controllers;

use App\Exports\KaryawanExport;
use App\Imports\KaryawanImport;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->q;
        $items = Karyawan::where('nama', 'LIKE', "%$q%")
            ->paginate(10);

        foreach ($items as $item) {

            // Convert the tanggal_masuk to a Carbon instance
            $tanggalMasuk = Carbon::parse($item->tanggal_masuk);


            // Calculate the difference in years and months
            $difference = $tanggalMasuk->diff(Carbon::now());
            $lamaBekerjaTahun = $difference->y;
            $lamaBekerjaBulan = $difference->m;

            //usia
            $tanggalLahir = Carbon::parse($item->tanggal_lahir);

            // Calculate the difference in years and months
            $differenceLahir = $tanggalLahir->diff(Carbon::now());
            $usiaTahun = $differenceLahir->y;
            $usiaBulan = $differenceLahir->m;
            $usia = "$usiaTahun tahun $usiaBulan bulan";

            $item->tanggal_masuk_asli = $item->tanggal_masuk;
            $item->tanggal_pengangkatan_atau_akhir_kontrak_asli = $item->tanggal_pengangkatan_atau_akhir_kontrak;
            $item->tanggal_lahir_asli = $item->tanggal_lahir;
            $item->vaksin_1_asli = $item->vaksin_1;
            $item->vaksin_2_asli = $item->vaksin_2;
            $item->vaksin_3_asli = $item->vaksin_3;
            $item->mpp_asli = $item->mpp;
            $item->pensiun_asli = $item->pensiun;

            // Add the calculated values to the item
            $item->tanggal_masuk = Carbon::parse($item->tanggal_masuk)->isoFormat('D MMMM Y');
            $item->tanggal_pengangkatan_atau_akhir_kontrak = Carbon::parse($item->tanggal_pengangkatan_atau_akhir_kontrak)->isoFormat('D MMMM Y');
            $item->tanggal_lahir = Carbon::parse($item->tanggal_lahir)->isoFormat('D MMMM Y');
            $item->vaksin_1 =  $item->vaksin_1 ? Carbon::parse($item->vaksin_1)->isoFormat('D MMMM Y') : "";
            $item->vaksin_2 =  $item->vaksin_2 ? Carbon::parse($item->vaksin_2)->isoFormat('D MMMM Y') : "";
            $item->vaksin_3 =  $item->vaksin_3 ? Carbon::parse($item->vaksin_3)->isoFormat('D MMMM Y') : "";
            $item->mpp =  $item->mpp ? Carbon::parse($item->mpp)->isoFormat('D MMMM Y') : "";

            //jika item berbeda menggunakan tanda tanya(?) lalu titik dua (:) trus else / isi nya
            $item->pensiun =  $item->pensiun ? Carbon::parse($item->pensiun)->isoFormat('D MMMM Y') : "";

            $item->lama_bekerja_tahun = $lamaBekerjaTahun;
            $item->lama_bekerja_bulan = $lamaBekerjaBulan;
            $item->usia = $usia;
        }
        return view('karyawan.index', compact('items'));
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
        $id = $request->id;
        $request->validate([
            'nip' => 'required',
            'nama' => 'required',
            'tanggal_masuk' => 'required|date',
            'status_pegawai' => 'required',
            'rekrutmen' => 'nullable',
            'domisili' => 'nullable',
            'rekening_mandiri' => 'nullable',
            'rekening_bsi' => 'nullable',
            'sk_pengangkatan_atau_kontrak' => 'nullable',
            'tanggal_pengangkatan_atau_akhir_kontrak' => 'nullable',
            'jabatan_inka' => 'nullable',
            'jabatan_imss' => 'nullable',
            'administrasi_atau_teknisi' => 'nullable',
            'lokasi_kerja' => 'nullable',
            'bagian_atau_proyek' => 'nullable',
            'departemen_atau_subproyek' => 'nullable',
            'divisi' => 'nullable',
            'direktorat' => 'nullable',
            'sertifikat' => 'nullable',
            'surat_peringatan' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable',
            'nomor_ktp' => 'nullable',
            'alamat' => 'nullable',
            'nomor_hp' => 'nullable',
            'email' => 'nullable',
            'bpjs_kesehatan' => 'nullable',
            'bpjs_ketenagakerjaan' => 'nullable',
            'status_pernikahan' => 'nullable',
            'suami_atau_istri' => 'nullable',
            'anak_ke_1' => 'nullable',
            'anak_ke_2' => 'nullable',
            'anak_ke_3' => 'nullable',
            'tambahan' => 'nullable',
            'ayah_kandung' => 'nullable',
            'ibu_kandung' => 'nullable',
            'ayah_mertua' => 'nullable',
            'ibu_mertua' => 'nullable',
            'jumlah_tanggungan' => 'nullable',
            'status_pajak' => 'nullable',
            'npwp' => 'nullable',
            'agama' => 'nullable',
            'pendidikan_diakui' => 'nullable',
            'jurusan' => 'nullable',
            'almamater' => 'nullable',
            'tahun_lulus' => 'nullable',
            'pendidikan_terakhir' => 'nullable',
            'jurusan_terakhir' => 'nullable',
            'almamater_terakhir' => 'nullable',
            'tahun_lulus_terakhir' => 'nullable',
            'mpp' => 'nullable',
            'pensiun' => 'nullable',
            'ukuran_baju' => 'nullable',
            'ukuran_celana' => 'nullable',
            'ukuran_sepatu' => 'nullable',
            'vaksin_1' => 'nullable',
            'vaksin_2' => 'nullable',
            'vaksin_3' => 'nullable',

        ], [
            'nip.required' => 'NIP harus diisi',
            'nama.required' => 'Nama harus diisi',
            'tanggal_masuk.required' => 'Tanggal Masuk harus diisi',
            'status_pegawai.required' => 'Status Pegawai harus diisi',


        ]);

        $data = $request->all();

        if (empty($id)) {
            $add = Karyawan::create($data);


            if ($add) {
                return redirect()->route('karyawan.index')->with('success', 'Data berhasil ditambahkan');
            } else {
                return redirect()->route('karyawan.index')->with('error', 'Data gagal ditambahkan');
            }
        } else {
            // $update = Karyawan::where('id', $id)->update($data);

            // if ($update) {
            //     return redirect()->route('karyawan.index')->with('success', 'Data berhasil diubah');
            // } else {
            //     return redirect()->route('karyawan.index')->with('error', 'Data gagal diubah');
            // }

            $update = Karyawan::findOrFail($id);
            $data['nip'] = $data['nip'] ? $data['nip'] : $update->nip;
            $data['nama'] = $data['nama'] ? $data['nama'] : $update->nama;
            $data['tanggal_masuk'] = $data['tanggal_masuk'] ? $data['tanggal_masuk'] : $update->tanggal_masuk;
            $data['status_pegawai'] = $data['status_pegawai'] ? $data['status_pegawai'] : $update->status_pegawai;
            $data['rekrutmen'] = $data['rekrutmen'] ? $data['rekrutmen'] : $update->rekrutmen;
            $data['domisili'] = $data['domisili'] ? $data['domisili'] : $update->domisili;
            $data['rekening_mandiri'] = $data['rekening_mandiri'] ? $data['rekening_mandiri'] : $update->rekening_mandiri;
            $data['rekening_bsi'] = $data['rekening_bsi'] ? $data['rekening_bsi'] : $update->rekening_bsi;
            $data['sk_pengangkatan_atau_kontrak'] = $data['sk_pengangkatan_atau_kontrak'] ? $data['sk_pengangkatan_atau_kontrak'] : $update->sk_pengangkatan_atau_kontrak;
            $data['tanggal_pengangkatan_atau_akhir_kontrak'] = $data['tanggal_pengangkatan_atau_akhir_kontrak'] ? $data['tanggal_pengangkatan_atau_akhir_kontrak'] : $update->tanggal_pengangkatan_atau_akhir_kontrak;
            $data['jabatan_inka'] = $data['jabatan_inka'] ? $data['jabatan_inka'] : $update->jabatan_inka;
            $data['jabatan_imss'] = $data['jabatan_imss'] ? $data['jabatan_imss'] : $update->jabatan_imss;
            $data['administrasi_atau_teknisi'] = $data['administrasi_atau_teknisi'] ? $data['administrasi_atau_teknisi'] : $update->administrasi_atau_teknisi;
            $data['lokasi_kerja'] = $data['lokasi_kerja'] ? $data['lokasi_kerja'] : $update->lokasi_kerja;
            $data['bagian_atau_proyek'] = $data['bagian_atau_proyek'] ? $data['bagian_atau_proyek'] : $update->bagian_atau_proyek;
            $data['departemen_atau_subproyek'] = $data['departemen_atau_subproyek'] ? $data['departemen_atau_subproyek'] : $update->departemen_atau_subproyek;
            $data['divisi'] = $data['divisi'] ? $data['divisi'] : $update->divisi;
            $data['direktorat'] = $data['direktorat'] ? $data['direktorat'] : $update->direktorat;
            $data['sertifikat'] = $data['sertifikat'] ? $data['sertifikat'] : $update->sertifikat;
            $data['surat_peringatan'] = $data['surat_peringatan'] ? $data['surat_peringatan'] : $update->surat_peringatan;
            $data['jenis_kelamin'] = $data['jenis_kelamin'] ? $data['jenis_kelamin'] : $update->jenis_kelamin;
            $data['tempat_lahir'] = $data['tempat_lahir'] ? $data['tempat_lahir'] : $update->tempat_lahir;
            $data['tanggal_lahir'] = $data['tanggal_lahir'] ? $data['tanggal_lahir'] : $update->tanggal_lahir;
            $data['nomor_ktp'] = $data['nomor_ktp'] ? $data['nomor_ktp'] : $update->nomor_ktp;
            $data['alamat'] = $data['alamat'] ? $data['alamat'] : $update->alamat;
            $data['nomor_hp'] = $data['nomor_hp'] ? $data['nomor_hp'] : $update->nomor_hp;
            $data['email'] = $data['email'] ? $data['email'] : $update->email;
            $data['bpjs_kesehatan'] = $data['bpjs_kesehatan'] ? $data['bpjs_kesehatan'] : $update->bpjs_kesehatan;
            $data['bpjs_ketenagakerjaan'] = $data['bpjs_ketenagakerjaan'] ? $data['bpjs_ketenagakerjaan'] : $update->bpjs_ketenagakerjaan;
            $data['status_pernikahan'] = $data['status_pernikahan'] ? $data['status_pernikahan'] : $update->status_pernikahan;
            $data['suami_atau_istri'] = $data['suami_atau_istri'] ? $data['suami_atau_istri'] : $update->suami_atau_istri;
            $data['anak_ke_1'] = $data['anak_ke_1'] ? $data['anak_ke_1'] : $update->anak_ke_1;
            $data['anak_ke_2'] = $data['anak_ke_2'] ? $data['anak_ke_2'] : $update->anak_ke_2;
            $data['anak_ke_3'] = $data['anak_ke_3'] ? $data['anak_ke_3'] : $update->anak_ke_3;
            $data['tambahan'] = $data['tambahan'] ? $data['tambahan'] : $update->tambahan;
            $data['ayah_kandung'] = $data['ayah_kandung'] ? $data['ayah_kandung'] : $update->ayah_kandung;
            $data['ibu_kandung'] = $data['ibu_kandung'] ? $data['ibu_kandung'] : $update->ibu_kandung;
            $data['ayah_mertua'] = $data['ayah_mertua'] ? $data['ayah_mertua'] : $update->ayah_mertua;
            $data['ibu_mertua'] = $data['ibu_mertua'] ? $data['ibu_mertua'] : $update->ibu_mertua;
            $data['jumlah_tanggungan'] = $data['jumlah_tanggungan'] ? $data['jumlah_tanggungan'] : $update->jumlah_tanggungan;
            $data['status_pajak'] = $data['status_pajak'] ? $data['status_pajak'] : $update->status_pajak;
            $data['npwp'] = $data['npwp'] ? $data['npwp'] : $update->npwp;
            $data['agama'] = $data['agama'] ? $data['agama'] : $update->agama;
            $data['pendidikan_diakui'] = $data['pendidikan_diakui'] ? $data['pendidikan_diakui'] : $update->pendidikan_diakui;
            $data['jurusan'] = $data['jurusan'] ? $data['jurusan'] : $update->jurusan;
            $data['almamater'] = $data['almamater'] ? $data['almamater'] : $update->almamater;
            $data['tahun_lulus'] = $data['tahun_lulus'] ? $data['tahun_lulus'] : $update->tahun_lulus;
            $data['pendidikan_terakhir'] = $data['pendidikan_terakhir'] ? $data['pendidikan_terakhir'] : $update->pendidikan_terakhir;
            $data['jurusan_terakhir'] = $data['jurusan_terakhir'] ? $data['jurusan_terakhir'] : $update->jurusan_terakhir;
            $data['almamater_terakhir'] = $data['almamater_terakhir'] ? $data['almamater_terakhir'] : $update->almamater_terakhir;
            $data['tahun_lulus_terakhir'] = $data['tahun_lulus_terakhir'] ? $data['tahun_lulus_terakhir'] : $update->tahun_lulus_terakhir;
            $data['mpp'] = $data['mpp'] ? $data['mpp'] : $update->mpp;
            $data['pensiun'] = $data['pensiun'] ? $data['pensiun'] : $update->pensiun;
            $data['ukuran_baju'] = $data['ukuran_baju'] ? $data['ukuran_baju'] : $update->ukuran_baju;
            $data['ukuran_celana'] = $data['ukuran_celana'] ? $data['ukuran_celana'] : $update->ukuran_celana;
            $data['ukuran_sepatu'] = $data['ukuran_sepatu'] ? $data['ukuran_sepatu'] : $update->ukuran_sepatu;
            $data['vaksin_1'] = $data['vaksin_1'] ? $data['vaksin_1'] : $update->vaksin_1;
            $data['vaksin_2'] = $data['vaksin_2'] ? $data['vaksin_2'] : $update->vaksin_2;
            $data['vaksin_3'] = $data['vaksin_3'] ? $data['vaksin_3'] : $update->vaksin_3;
            $update->update($data);
            return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diupdate');
        }
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
    public function destroy(Request $request)
    {
        $id = $request->delete_id;

        Karyawan::where('id', $id)->delete();

        return redirect()->route('karyawan.index')->with('success', 'karyawan berhasil dihapus');
    }


    public function import(Request $request)
    {

        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');

        $nama_file = rand() . $file->getClientOriginalName();

        $file->move(public_path('temp'), $nama_file);

        // $file = public_path('karyawan.xlsx');
        Excel::import(new KaryawanImport, public_path('temp/' . $nama_file));

        return redirect()->back()->with('success', 'berhasil di import');
    }
    public function export()
    {
        $nama_file = rand() . '.xlsx';
        return Excel::download(new KaryawanExport, $nama_file);
    }

    public function hapusMultipleKaryawan(Request $request)
    {
        if ($request->has('ids')) {
            Karyawan::whereIn('id', $request->input('ids'))->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
