<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('nama');
            $table->date('tanggal_masuk');
            $table->string('status_pegawai');
            $table->string('rekrutmen');
            $table->string('domisili');
            $table->string('rekening_mandiri');
            $table->string('rekening_bsi');
            $table->string('sk_pengangkatan_atau_kontrak');
            $table->date('tanggal_pengangkatan_atau_akhir_kontrak');
            $table->string('jabatan_inka');
            $table->string('jabatan_imss');
            $table->string('administrasi_atau_teknisi');
            $table->string('lokasi_kerja');
            $table->string('bagian_atau_proyek');
            $table->string('departemen_atau_subproyek');
            $table->string('divisi');
            $table->string('direktorat');
            $table->string('sertifikat');
            $table->string('surat_peringatan');
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('nomor_ktp');
            $table->string('alamat');
            $table->string('nomor_hp');
            $table->string('email');
            $table->string('bpjs_kesehatan');
            $table->string('bpjs_ketenagakerjaan');
            $table->string('status_pernikahan');
            $table->string('suami_atau_istri');
            $table->string('anak_ke_1');
            $table->string('anak_ke_2');
            $table->string('anak_ke_3');
            $table->string('tambahan');
            $table->string('ayah_kandung');
            $table->string('ibu_kandung');
            $table->string('ayah_mertua');
            $table->string('ibu_mertua');
            $table->string('jumlah_tanggungan');
            $table->string('status_pajak');
            $table->string('npwp');
            $table->string('agama');
            $table->string('pendidikan_diakui');
            $table->string('jurusan');
            $table->string('almamater');
            $table->string('tahun_lulus');
            $table->string('pendidikan_terakhir');
            $table->string('jurusan_terakhir');
            $table->string('almamater_terakhir');
            $table->string('tahun_lulus_terakhir');
            $table->string('mpp');
            $table->date('pensiun');
            $table->string('ukuran_baju');
            $table->string('ukuran_celana');
            $table->string('ukuran_sepatu');
            $table->date('vaksin_1');
            $table->date('vaksin_2');
            $table->date('vaksin_3');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('karyawan');
    }
}
