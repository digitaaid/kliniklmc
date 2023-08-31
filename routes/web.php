<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\APIController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\IntegrasiController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PoliklinikController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RujukanController;
use App\Http\Controllers\SuratKontrolController;
use App\Http\Controllers\ThermalPrintController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VclaimController;
use App\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('landingpage'); #ok
// Route::get('', [HomeController::class, 'landingpage'])->name('landingpage'); #ok
Auth::routes();
Route::get('verifikasi_akun', [VerificationController::class, 'verifikasi_akun'])->name('verifikasi_akun');
Route::post('verifikasi_kirim', [VerificationController::class, 'verifikasi_kirim'])->name('verifikasi_kirim');
Route::get('user_verifikasi/{user}', [UserController::class, 'user_verifikasi'])->name('user_verifikasi');
Route::get('delet_verifikasi', [UserController::class, 'delet_verifikasi'])->name('delet_verifikasi');
Route::get('login/google/redirect', [SocialiteController::class, 'redirect'])->middleware(['guest'])->name('login.google'); #redirect google login
Route::get('login/google/callback', [SocialiteController::class, 'callback'])->middleware(['guest'])->name('login.goole.callback'); #callback google login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// daftar pasien
Route::get('daftar', [AntrianController::class, 'daftar'])->name('daftar');
Route::get('daftarbpjs', [AntrianController::class, 'daftarbpjs'])->name('daftarbpjs');
Route::post('prosesdaftarbpjs', [AntrianController::class, 'prosesdaftarbpjs'])->name('prosesdaftarbpjs');
Route::get('daftarumum', [AntrianController::class, 'daftarumum'])->name('daftarumum');
Route::post('prosesdaftarumum', [AntrianController::class, 'prosesdaftarumum'])->name('prosesdaftarumum');
Route::get('statusantrian', [AntrianController::class, 'statusantrian'])->name('statusantrian');
Route::get('ambilkarcis', [AntrianController::class, 'ambilkarcis'])->name('ambilkarcis');

// mesin antrian
Route::get('anjunganantrian', [AntrianController::class, 'anjunganantrian'])->name('anjunganantrian');
Route::get('displayAntrian', [AntrianController::class, 'displayAntrian'])->name('displayAntrian');
Route::get('checkinantrian', [AntrianController::class, 'checkinantrian'])->name('checkinantrian');
Route::get('karcisantrian', [AntrianController::class, 'karcisantrian'])->name('karcisantrian');
Route::get('checkinCetakSEP', [AntrianController::class, 'checkinCetakSEP'])->name('checkinCetakSEP');
Route::get('checkinKarcisAntrian', [AntrianController::class, 'checkinKarcisAntrian'])->name('checkinKarcisAntrian');
Route::get('jadwaldokterPoli', [JadwalDokterController::class, 'jadwaldokterPoli'])->name('jadwaldokterPoli');
Route::get('daftarBpjsOffline', [AntrianController::class, 'daftarBpjsOffline'])->name('daftarBpjsOffline');
Route::get('daftarUmumOffline', [AntrianController::class, 'daftarUmumOffline'])->name('daftarUmumOffline');
Route::get('cekPrinter', [ThermalPrintController::class, 'cekPrinter'])->name('cekPrinter');
Route::get('checkinUpdate', [AntrianController::class, 'checkinUpdate'])->name('checkinUpdate');

Route::middleware('auth')->group(function () {
    Route::get('profile', [UserController::class, 'profile'])->name('profile'); #ok
    // settingan umum
    Route::get('get_city', [LaravotLocationController::class, 'get_city'])->name('get_city');
    Route::get('get_district', [LaravotLocationController::class, 'get_district'])->name('get_district');
    Route::get('get_village', [LaravotLocationController::class, 'get_village'])->name('get_village');
    Route::get('cekBarQRCode', [BarcodeController::class, 'cekBarQRCode'])->name('cekBarQRCode');
    Route::get('cekThermalPrinter', [ThermalPrintController::class, 'cekThermalPrinter'])->name('cekThermalPrinter');
    Route::get('testThermalPrinter', [ThermalPrintController::class, 'testThermalPrinter'])->name('testThermalPrinter');
    Route::get('whatsapp', [WhatsappController::class, 'whatsapp'])->name('whatsapp');
    // route resource
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('integrasiAPI', IntegrasiController::class);
    Route::resource('poliklinik', PoliklinikController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('jadwaldokter', JadwalDokterController::class);
    Route::resource('carousel', CarouselController::class);
    Route::resource('antrian', AntrianController::class);
    Route::resource('suratkontrol', SuratKontrolController::class);
    // pendaftaran
    Route::get('layanipendaftaran', [AntrianController::class, 'layanipendaftaran'])->name('layanipendaftaran');
    Route::get('lanjutpoliklinik', [AntrianController::class, 'lanjutpoliklinik'])->name('lanjutpoliklinik');
    Route::get('batalantrian', [AntrianController::class, 'batalantrian'])->name('batalantrian');
    Route::post('editantrian', [AntrianController::class, 'editantrian'])->name('editantrian');
    // poliklinik
    Route::get('antrianpoliklinik', [AntrianController::class, 'antrianpoliklinik'])->name('antrianpoliklinik');
    Route::get('panggilpoliklinik', [AntrianController::class, 'panggilpoliklinik'])->name('panggilpoliklinik');
    Route::get('lanjutfarmasi', [AntrianController::class, 'lanjutfarmasi'])->name('lanjutfarmasi');
    // farmasi
    Route::get('antrianfarmasi', [AntrianController::class, 'antrianfarmasi'])->name('antrianfarmasi');
    Route::get('terimafarmasi', [AntrianController::class, 'terimafarmasi'])->name('terimafarmasi');
    Route::get('selesaifarmasi', [AntrianController::class, 'selesaifarmasi'])->name('selesaifarmasi');


    // antrian bpjs
    Route::get('statusAntrianBpjs', [AntrianController::class, 'statusAntrianBpjs'])->name('statusAntrianBpjs');
    Route::get('poliklikAntrianBpjs', [PoliklinikController::class, 'poliklikAntrianBpjs'])->name('poliklikAntrianBpjs');
    Route::get('dokterAntrianBpjs', [DokterController::class, 'dokterAntrianBpjs'])->name('dokterAntrianBpjs');
    Route::get('jadwalDokterAntrianBpjs', [JadwalDokterController::class, 'jadwalDokterAntrianBpjs'])->name('jadwalDokterAntrianBpjs');
    Route::get('fingerprintPeserta', [PasienController::class, 'fingerprintPeserta'])->name('fingerprintPeserta');
    Route::get('antrianBpjsConsole', [AntrianController::class, 'antrianConsole'])->name('antrianBpjsConsole');
    Route::get('antrianBpjs', [AntrianController::class, 'index'])->name('antrianBpjs');
    Route::get('listTaskID', [AntrianController::class, 'listTaskID'])->name('listTaskID');
    Route::get('dashboardTanggalAntrian', [AntrianController::class, 'dashboardTanggalAntrian'])->name('dashboardTanggalAntrian');
    Route::get('dashboardBulanAntrian', [AntrianController::class, 'dashboardBulanAntrian'])->name('dashboardBulanAntrian');
    Route::get('jadwalOperasi', [JadwalOperasiController::class, 'jadwalOperasi'])->name('jadwalOperasi');
    Route::get('antrianPerTanggal', [AntrianController::class, 'antrianPerTanggal'])->name('antrianPerTanggal');
    Route::get('antrianPerKodebooking', [AntrianController::class, 'antrianPerKodebooking'])->name('antrianPerKodebooking');
    Route::get('antrianBelumDilayani', [AntrianController::class, 'antrianBelumDilayani'])->name('antrianBelumDilayani');
    Route::get('antrianPerDokter', [AntrianController::class, 'antrianPerDokter'])->name('antrianPerDokter');
    // vclaim bpjs
    Route::get('monitoringDataKunjungan', [VclaimController::class, 'monitoringDataKunjungan'])->name('monitoringDataKunjungan');
    Route::get('monitoringDataKlaim', [VclaimController::class, 'monitoringDataKlaim'])->name('monitoringDataKlaim');
    Route::get('monitoringPelayananPeserta', [VclaimController::class, 'monitoringPelayananPeserta'])->name('monitoringPelayananPeserta');
    Route::get('monitoringKlaimJasaraharja', [VclaimController::class, 'monitoringKlaimJasaraharja'])->name('monitoringKlaimJasaraharja');
    Route::get('referensiVclaim', [VclaimController::class, 'referensiVclaim'])->name('referensiVclaim');
    Route::get('ref_diagnosa_api', [VclaimController::class, 'ref_diagnosa_api'])->name('ref_diagnosa_api');
    Route::get('ref_poliklinik_api', [VclaimController::class, 'ref_poliklinik_api'])->name('ref_poliklinik_api');
    Route::get('ref_faskes_api', [VclaimController::class, 'ref_faskes_api'])->name('ref_faskes_api');
    Route::get('ref_dpjp_api', [VclaimController::class, 'ref_dpjp_api'])->name('ref_dpjp_api');
    Route::get('ref_provinsi_api', [VclaimController::class, 'ref_provinsi_api'])->name('ref_provinsi_api');
    Route::get('ref_kabupaten_api', [VclaimController::class, 'ref_kabupaten_api'])->name('ref_kabupaten_api');
    Route::get('ref_kecamatan_api', [VclaimController::class, 'ref_kecamatan_api'])->name('ref_kecamatan_api');
    Route::get('suratKontrolBpjs', [SuratKontrolController::class, 'suratKontrolBpjs'])->name('suratKontrolBpjs');
    Route::get('rujukanBpjs', [RujukanController::class, 'rujukanBpjs'])->name('rujukanBpjs');
});
