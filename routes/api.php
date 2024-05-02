<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\ApotekController;
use App\Http\Controllers\IcareController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\SuratKontrolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VclaimController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// ANTRIAN
Route::prefix('antrian')->group(function () {
    // API BPJS
    Route::get('ref_poli', [AntrianController::class, 'ref_poli'])->name('ref_poli');
    Route::get('ref_dokter', [AntrianController::class, 'ref_dokter'])->name('ref_dokter');
    Route::get('ref_jadwal_dokter', [AntrianController::class, 'ref_jadwal_dokter'])->name('ref_jadwal_dokter');
    Route::get('ref_poli_fingerprint', [AntrianController::class, 'ref_poli_fingerprint'])->name('ref_poli_fingerprint');
    Route::get('ref_pasien_fingerprint', [AntrianController::class, 'ref_pasien_fingerprint'])->name('ref_pasien_fingerprint');
    Route::post('update_jadwal_dokter', [AntrianController::class, 'update_jadwal_dokter'])->name('update_jadwal_dokter');
    Route::post('tambah_antrean', [AntrianController::class, 'tambah_antrean'])->name('tambah_antrean');
    Route::post('tambah_antrean_farmasi', [AntrianController::class, 'tambah_antrean_farmasi'])->name('tambah_antrean_farmasi');
    Route::post('update_antrean', [AntrianController::class, 'update_antrean'])->name('update_antrean');
    Route::post('batal_antrean', [AntrianController::class, 'batal_antrean'])->name('batal_antrean');
    Route::post('taskid_antrean', [AntrianController::class, 'taskid_antrean'])->name('taskid_antrean');
    Route::get('dashboard_tanggal', [AntrianController::class, 'dashboard_tanggal'])->name('dashboard_tanggal');
    Route::get('dashboard_bulan', [AntrianController::class, 'dashboard_bulan'])->name('dashboard_bulan');
    Route::get('antrian_tanggal', [AntrianController::class, 'antrian_tanggal'])->name('antrian_tanggal');
    Route::get('antrian_kodebooking', [AntrianController::class, 'antrian_kodebooking'])->name('antrian_kodebooking');
    Route::get('antrian_belum_dilayani', [AntrianController::class, 'antrian_belum_dilayani'])->name('antrian_belum_dilayani');
    Route::get('antrian_poliklinik', [AntrianController::class, 'antrian_poliklinik'])->name('antrian_poliklinik');
    // API SIMRS
    Route::post('status_antrian', [AntrianController::class, 'status_antrian'])->name('status_antrian');
    Route::post('ambil_antrian', [AntrianController::class, 'ambil_antrian'])->name('ambil_antrian');
    Route::post('sisa_antrian', [AntrianController::class, 'sisa_antrian'])->name('sisa_antrian');
    Route::post('batal_antrian', [AntrianController::class, 'batal_antrian'])->name('batal_antrian');
    Route::post('checkin_antrian', [AntrianController::class, 'checkin_antrian'])->name('checkin_antrian');
    Route::post('info_pasien_baru', [AntrianController::class, 'info_pasien_baru'])->name('info_pasien_baru');
    Route::post('jadwal_operasi_rs', [JadwalOperasiController::class, 'jadwal_operasi_rs'])->name('jadwal_operasi_rs');
    Route::post('jadwal_operasi_pasien', [JadwalOperasiController::class, 'jadwal_operasi_pasien'])->name('jadwal_operasi_pasien');
    Route::post('ambil_antrian_farmasi', [AntrianController::class, 'ambil_antrian_farmasi'])->name('ambil_antrian_farmasi');
    Route::post('status_antrian_farmasi', [AntrianController::class, 'status_antrian_farmasi'])->name('status_antrian_farmasi');
    // MJKN
    Route::get('token', [AntrianController::class, 'token'])->name('token');
    Route::post('statusantrean', [AntrianController::class, 'status_antrian_mjkn'])->name('statusantrean');
    Route::post('ambilantrean', [AntrianController::class, 'ambil_antrian_mjkn'])->name('ambilantrean');
    Route::post('sisaantrean', [AntrianController::class, 'sisa_antrian'])->name('sisaantrean');
    Route::post('batalantrean', [AntrianController::class, 'batal_antrian'])->name('batalantrean');
    Route::post('checkin', [AntrianController::class, 'checkin_antrian'])->name('checkin');
    Route::post('infopasienbaru', [AntrianController::class, 'info_pasien_baru'])->name('infopasienbaru');
    Route::post('jadwaloperasi', [JadwalOperasiController::class, 'jadwal_operasi_rs'])->name('jadwaloperasi');
    Route::post('jadwaloperasipasien', [JadwalOperasiController::class, 'jadwal_operasi_pasien'])->name('jadwaloperasipasien');
    Route::post('ambilantreanfarmasi', [AntrianController::class, 'ambil_antrian_farmasi'])->name('ambilantreanfarmasi');
    Route::post('statusantreanfarmasi', [AntrianController::class, 'status_antrian_farmasi'])->name('statusantreanfarmasi');
});

// ANTRIAN
Route::get('cari_pasien_nomorkartu', [PasienController::class, 'cari_pasien_nomorkartu'])->name('cari_pasien_nomorkartu');
Route::get('cari_pasien_nik', [PasienController::class, 'cari_pasien_nik'])->name('cari_pasien_nik');
Route::get('cari_pasien_norm', [PasienController::class, 'cari_pasien_norm'])->name('cari_pasien_norm');
// VCLAIM
Route::prefix('vclaim')->group(function () {
    // MONITORING
    Route::get('monitoring_data_kunjungan', [VclaimController::class, 'monitoring_data_kunjungan'])->name('monitoring_data_kunjungan');
    Route::get('monitoring_data_klaim', [VclaimController::class, 'monitoring_data_klaim'])->name('monitoring_data_klaim');
    Route::get('monitoring_pelayanan_peserta', [VclaimController::class, 'monitoring_pelayanan_peserta'])->name('monitoring_pelayanan_peserta');
    Route::get('monitoring_klaim_jasaraharja', [VclaimController::class, 'monitoring_klaim_jasaraharja'])->name('monitoring_klaim_jasaraharja');
    // PESERTA
    Route::get('peserta_nomorkartu', [VclaimController::class, 'peserta_nomorkartu'])->name('peserta_nomorkartu');
    Route::get('pasien_nomorkartu', [VclaimController::class, 'pasien_nomorkartu'])->name('pasien_nomorkartu');
    Route::get('peserta_nik', [VclaimController::class, 'peserta_nik'])->name('peserta_nik');
    // REFERENSI
    Route::get('ref_diagnosa', [VclaimController::class, 'ref_diagnosa'])->name('ref_diagnosa');
    Route::get('ref_poliklinik', [VclaimController::class, 'ref_poliklinik'])->name('ref_poliklinik');
    Route::get('ref_faskes', [VclaimController::class, 'ref_faskes'])->name('ref_faskes');
    Route::get('ref_dpjp', [VclaimController::class, 'ref_dpjp'])->name('ref_dpjp');
    Route::get('ref_provinsi', [VclaimController::class, 'ref_provinsi'])->name('ref_provinsi');
    Route::get('ref_kabupaten', [VclaimController::class, 'ref_kabupaten'])->name('ref_kabupaten');
    Route::get('ref_kecamatan', [VclaimController::class, 'ref_kecamatan'])->name('ref_kecamatan');
    Route::get('ref_diagnosa_prb', [VclaimController::class, 'ref_diagnosa_prb'])->name('ref_diagnosa_prb');
    Route::get('ref_obat_prb', [VclaimController::class, 'ref_obat_prb'])->name('ref_obat_prb');
    Route::get('ref_tindakan', [VclaimController::class, 'ref_tindakan'])->name('ref_tindakan');
    Route::get('ref_kelas_rawat', [VclaimController::class, 'ref_kelas_rawat'])->name('ref_kelas_rawat');
    Route::get('ref_dokter_dpjp', [VclaimController::class, 'ref_dokter'])->name('ref_dokter_dpjp');
    Route::get('ref_spesialistik', [VclaimController::class, 'ref_spesialistik'])->name('ref_spesialistik');
    Route::get('ref_ruang_rawat', [VclaimController::class, 'ref_ruang_rawat'])->name('ref_ruang_rawat');
    Route::get('ref_cara_keluar', [VclaimController::class, 'ref_cara_keluar'])->name('ref_cara_keluar');
    Route::get('ref_pasca_pulang', [VclaimController::class, 'ref_pasca_pulang'])->name('ref_pasca_pulang');
    // RENCANA KONTROL
    Route::post('suratkontrol_insert', [VclaimController::class, 'suratkontrol_insert'])->name('suratkontrol_insert');
    Route::put('suratkontrol_update', [SuratKontrolController::class, 'update'])->name('suratkontrol_update');
    Route::delete('suratkontrol_delete', [SuratKontrolController::class, 'destroy'])->name('suratkontrol_delete');
    Route::post('spri_insert', [VclaimController::class, 'spri_insert'])->name('spri_insert');
    Route::put('spri_update', [VclaimController::class, 'spri_update'])->name('spri_update');
    Route::get('suratkontrol_sep', [SuratKontrolController::class, 'suratkontrol_sep'])->name('suratkontrol_sep');
    Route::get('suratkontrol_nomor', [VclaimController::class, 'suratkontrol_nomor'])->name('suratkontrol_nomor');
    Route::get('suratkontrol_peserta', [VclaimController::class, 'suratkontrol_peserta'])->name('suratkontrol_peserta');
    Route::get('suratkontrol_tanggal', [VclaimController::class, 'suratkontrol_tanggal'])->name('suratkontrol_tanggal');
    Route::get('suratkontrol_poli', [VclaimController::class, 'suratkontrol_poli'])->name('suratkontrol_poli');
    Route::get('suratkontrol_dokter', [VclaimController::class, 'suratkontrol_dokter'])->name('suratkontrol_dokter');
    // RUJUKAN
    Route::get('rujukan_nomor', [VclaimController::class, 'rujukan_nomor'])->name('rujukan_nomor');
    Route::get('rujukan_peserta', [VclaimController::class, 'rujukan_peserta'])->name('rujukan_peserta');
    Route::get('rujukan_rs_nomor', [VclaimController::class, 'rujukan_rs_nomor'])->name('rujukan_rs_nomor');
    Route::get('rujukan_rs_peserta', [VclaimController::class, 'rujukan_rs_peserta'])->name('rujukan_rs_peserta');
    Route::get('rujukan_jumlah_sep', [VclaimController::class, 'rujukan_jumlah_sep'])->name('rujukan_jumlah_sep');
    // SEP
    Route::get('sep_nomor', [VclaimController::class, 'sep_nomor'])->name('sep_nomor');
    Route::delete('sep_delete', [VclaimController::class, 'sep_delete'])->name('sep_delete');
    // FINGERPRINT
    Route::get('fingerprint_peserta', [VclaimController::class, 'fingerprint_peserta'])->name('fingerprint_peserta');
    Route::get('fingerprint_sep', [VclaimController::class, 'fingerprint_sep'])->name('fingerprint_sep');
});

Route::get('user_data', [UserController::class, 'user_data'])->name('user_data');
Route::post('user_add', [UserController::class, 'user_add'])->name('user_add');
Route::get('icare', [IcareController::class, 'icare'])->name('icare');

// APOTEK
Route::prefix('apotek')->group(function () {
    // REFERENSI
    Route::get('referensi_dpho', [ApotekController::class, 'referensi_dpho'])->name('referensi_dpho');
});
