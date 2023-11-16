<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    private function createRomawi($angka)
    {
        $angka = (int)$angka;
        $hasil = "";
        $romawi = array(
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        );
        foreach ($romawi as $rom => $nilai) {
            $matches = intval($angka / $nilai);
            $hasil .= str_repeat($rom, $matches);
            $angka = $angka % $nilai;
        }
        return $hasil;
    }

    function gantiString($string)
    {

        if (!$string) return 'A';
        // Array berisi urutan string
        $urutanString = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V',  'W', 'X', 'Y', 'Z'];

        // Mencari indeks dari string input
        $index = array_search($string, $urutanString);

        if ($index !== false) {
            // Jika bukan string terakhir, kembalikan string berikutnya
            if ($index < count($urutanString) - 1) {
                return $urutanString[$index + 1];
            } else {
                // Jika string terakhir, kembali ke string pertama
                return $urutanString[0];
            }
        } else {
            // Jika input tidak valid, kembalikan pesan error atau nilai default
            return "Input tidak valid";
        }
    }

    public function generateNomorSurat($type, $tanggal)
    {
        //get count surat
        $count = SuratKeluar::where('type', $type)->orderBy('no_surat', 'desc');

        // dd($count->count());

        if ($count->count() == 0) {
            $count = 1;
        } else {
            //ambil no_surat lalu explode / index 0
            $count = $count->latest()->first()->no_surat;
            // dd($count);
            //remove abjad by regex
            $count = explode('/', $count)[0];
            $count = preg_replace('/[^0-9]/', '', $count);
            //increment count
            $count = $count + 1;
        }


        //format count 001, dll until 100
        $count = str_pad($count, 3, '0', STR_PAD_LEFT);

        //get romawi bulan ini
        $romawi = $this->createRomawi(date('m', strtotime($tanggal)));

        //get tahun ini
        $year = date('Y');

        //uppercase type
        $type = strtoupper($type);

        //append no surat dengan format $count/$romawi/$type/IMSS/$year

        //found the SuratKeluar where created_at = $this->created_at

        $check_date = SuratKeluar::whereDate('created_at', $tanggal)->count();

        $date_now = Carbon::now()->format('Y-m-d');

        if ($check_date > 0 && $tanggal != $date_now) {

            //check by date and type
            $count_check = SuratKeluar::whereDate('created_at', $tanggal)
                ->where('type', $this->type)
                ->latest()->first();

            if ($count_check) {
                if ($count_check->status == 0) {
                    $this->dispatch('alert', [
                        'type' => 'error',
                        'message' => "Surat sebelumnya belum diupload! Mohon hubungi PIC sebelumnya."
                    ]);
                    return;
                }
            }

            $romawi = $this->createRomawi(date('m', strtotime($tanggal)));
            //find latest surat keluar with date $tanggal then get sub nomor, if not found then return A
            $latestSurat = SuratKeluar::whereDate('created_at', $tanggal)
                ->orderBy('no_surat', 'desc')
                ->latest()->first();

            $sub = $latestSurat->no_surat;
            //pecah $sub dengan 3 karakter didepan misal 001A maka ambil A
            $sub = substr($sub, 3, 1);

            if ($sub == '/') {
                $sub = null;
            } else {
                $sub = $sub;
            }
            $increment_sub = $this->gantiString($sub);
            $count = $latestSurat->no_surat;
            $count = explode('/', $count)[0];
            //get the 3 digit number
            $count = substr($count, 0, 3);
            $romawi = $this->createRomawi(date('m', strtotime($tanggal)));
            return $count . $increment_sub . '/' . $romawi . '/' . $type . '/IMSS/' . $year;
        } else {
            return $count . '/' . $romawi . '/' . $type . '/IMSS/' . $year;
        }
    }

    public function direksi()
    {
        $direksi = request()->direksi;
        if (!$direksi) {
            $routeBack = '/';
            $menus = [
                [
                    'name' => 'D1',
                    'route' => 'apps/surat-keluar?direksi=d1',
                    'bgcolor' => 'green',
                    'icon' => 'user'
                ],
                [
                    'name' => 'D2',
                    'route' => 'apps/surat-keluar?direksi=d2',
                    'bgcolor' => 'violet',
                    'icon' => 'user-friends'
                ],
                [
                    'name' => 'D3',
                    'route' => 'apps/surat-keluar?direksi=d3',
                    'bgcolor' => '#ac6bac',
                    'icon' => 'users'
                ],
            ];
            $title = 'Surat Keluar';
            return view('home.tipe', compact('menus', 'title', 'routeBack'));
        } else if ($direksi) {
            $items =  SuratKeluar::leftJoin('users', 'users.id', '=', 'surat_keluar.id_user')
                ->select('surat_keluar.*', 'users.name as pic')
                ->orderBy('surat_keluar.no_surat', 'asc')
                ->paginate(10);
            $type = strtoupper($direksi);
            return view('home.apps.surat_keluar.index', compact('items', 'type'));
        }
    }

    public function index()
    {
        $items = SuratKeluar::leftJoin('users', 'users.id', '=', 'surat_keluar.id_user')
            ->select('surat_keluar.*', 'users.name as pic')
            ->orderBy('surat_keluar.no_surat', 'asc')
            ->paginate(10);

        return view('surat_keluar.index', compact('items'));
    }

    public function create(Request $request)
    {
        $sk = $request->surat_keluar_id;
        $request->validate([
            'direksi' => 'required',
            'type' => 'required',
            'tujuan' => 'required',
            'uraian' => 'required',
            'file' => 'nullable|mimes:pdf|max:2048',
            'tanggal' => 'required|date'
        ]);

        $latestSurat = SuratKeluar::where('type', $request->direksi)->where('status', '0')
            ->orderBy('id', 'desc')->latest()->first();

        if ($latestSurat && empty($sk)) {
            if ($latestSurat->status == 0) {
                return redirect()->back()->with('error', 'Surat sebelumnya belum diupload! Mohon hubungi PIC sebelumnya.');
            }
        }


        $data = $request->all();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '.' . $file->extension();
            $file->move(public_path('sk'), $fileName);
            $data['file'] = $fileName;
        } else {
            $data['file'] = null;
        }
        $data['id_user'] = auth()->user()->id;
        $data['no_surat'] = $this->generateNomorSurat($request->direksi, $request->tanggal);
        $data['created_at'] = $request->tanggal;
        //remove tanggal from $data
        unset($data['tanggal']);

        if (empty($sk)) {
            SuratKeluar::create($data);
            return redirect()->route('surat_keluar.index')->with('success', 'Surat Keluar berhasil ditambahkan');
        } else {
            $update = SuratKeluar::findOrFail($sk);
            $data['no_surat'] = $update->no_surat;
            $data['status'] = 1;
            $update->update($data);
            return redirect()->route('surat_keluar.index')->with('success', 'Surat Keluar berhasil diupdate');
        }
    }

    public function delete(Request $request)
    {
        $id = $request->delete_id;

        $item = SuratKeluar::findOrFail($id);
        $item->delete();

        return redirect()->route('surat_keluar.index')->with('success', 'Surat Keluar berhasil dihapus');
    }
}
