<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\DepoController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\DistributorBarangController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\FarmasiController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IntegrasiController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\JadwalLiburController;
use App\Http\Controllers\JaminanController;
use App\Http\Controllers\JenisObatController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\LaboratoriumController;
use App\Http\Controllers\LaravoltIndonesiaController;
use App\Http\Controllers\LPKController;
use App\Http\Controllers\MerkBarangController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\OrderObatController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ParameterLabController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PerawatController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PoliklinikController;
use App\Http\Controllers\PractitionerController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RujukanController;
use App\Http\Controllers\SatuanObatController;
use App\Http\Controllers\SatuSehatController;
use App\Http\Controllers\SbarController;
use App\Http\Controllers\SepController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\SPRIController;
use App\Http\Controllers\StokObatController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SuratKontrolController;
use App\Http\Controllers\SyncronizeController;
use App\Http\Controllers\TanyaJawabController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\ThermalPrintController;
use App\Http\Controllers\TipeBarangController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VclaimController;
use App\Http\Controllers\WhatsappController;
use App\Models\JadwalLibur;
use App\Models\PemeriksaanLab;
use App\Models\Poliklinik;
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

Route::get('', [HomeController::class, 'landingpage'])->name('landingpage');
Auth::routes();
Route::get('login/google/redirect', [SocialiteController::class, 'redirect'])->middleware(['guest'])->name('login.google'); #redirect google login
Route::get('login/google/callback', [SocialiteController::class, 'callback'])->middleware(['guest'])->name('login.goole.callback'); #callback google login
// daftar pasien
Route::get('daftar', [AntrianController::class, 'daftar'])->name('daftar');
Route::get('daftarbpjs', [AntrianController::class, 'daftarbpjs'])->name('daftarbpjs');
Route::post('prosesdaftarbpjs', [AntrianController::class, 'prosesdaftarbpjs'])->name('prosesdaftarbpjs');
Route::get('daftarumum', [AntrianController::class, 'daftarumum'])->name('daftarumum');
Route::post('prosesdaftarumum', [AntrianController::class, 'prosesdaftarumum'])->name('prosesdaftarumum');
Route::get('statusantrian', [AntrianController::class, 'statusantrian'])->name('statusantrian');
Route::get('batalantrianweb', [PendaftaranController::class, 'batalantrianweb'])->name('batalantrianweb');
Route::get('ceksuratkontrol', [SuratKontrolController::class, 'ceksuratkontrol'])->name('ceksuratkontrol');
Route::put('suratkontrol_update_web', [SuratKontrolController::class, 'suratkontrol_update_web'])->name('suratkontrol_update_web');
// display antrian
Route::get('displayantrian', [AntrianController::class, 'displayAntrian'])->name('displayantrian');
Route::get('updatenomorantrean', [AntrianController::class, 'updatenomorantrean'])->name('updatenomorantrean');
Route::get('displaynomor', [AntrianController::class, 'displaynomor'])->name('displaynomor');
Route::get('getdisplayantrian', [AntrianController::class, 'getdisplayantrian'])->name('getdisplayantrian');
Route::get('displayantrianfarmasi', [FarmasiController::class, 'displayantrianfarmasi'])->name('displayantrianfarmasi');
Route::get('getdisplayfarmasi', [FarmasiController::class, 'getdisplayfarmasi'])->name('getdisplayfarmasi');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('profile', [UserController::class, 'profile'])->name('profile'); #ok
    Route::put('update_profile', [UserController::class, 'update_profile'])->name('update_profile'); #ok
    // settingan umum
    Route::get('get_city', [LaravoltIndonesiaController::class, 'get_city'])->name('get_city');
    Route::get('get_district', [LaravoltIndonesiaController::class, 'get_district'])->name('get_district');
    Route::get('get_village', [LaravoltIndonesiaController::class, 'get_village'])->name('get_village');
    Route::get('get_kabupaten_name', [LaravoltIndonesiaController::class, 'get_kabupaten_name'])->name('get_kabupaten_name');
    // route resource
    Route::group(['middleware' => ['permission:admin']], function () {
        Route::resource('user', UserController::class);
        Route::get('user_verifikasi/{user}', [UserController::class, 'user_verifikasi'])->name('user_verifikasi');
        Route::get('user_synchronize', [UserController::class, 'user_synchronize'])->name('user_synchronize');
        Route::get('user_sync', [UserController::class, 'user_sync'])->name('user_sync');
        Route::resource('role', RoleController::class);
        Route::resource('permission', PermissionController::class);
        Route::get('cekBarQRCode', [BarcodeController::class, 'cekBarQRCode'])->name('cekBarQRCode');
        Route::get('cekThermalPrinter', [ThermalPrintController::class, 'cekThermalPrinter'])->name('cekThermalPrinter');
        Route::get('testThermalPrinter', [ThermalPrintController::class, 'testThermalPrinter'])->name('testThermalPrinter');
        Route::get('whatsapp', [WhatsappController::class, 'whatsapp'])->name('whatsapp');
        Route::resource('carousel', CarouselController::class);
        Route::resource('galeri', GaleriController::class);
        Route::resource('tanyajawab', TanyaJawabController::class);
        Route::resource('testimoni', TestimoniController::class);
        Route::resource('integrasiAPI', IntegrasiController::class);
    });

    Route::resource('lpk', LPKController::class);
    Route::resource('pasien', PasienController::class);
    Route::get('pasienreset', [PasienController::class, 'reset'])->name('pasienreset');
    Route::get('pasiensearch', [PasienController::class, 'search'])->name('pasiensearch');
    Route::resource('unit', UnitController::class);
    Route::resource('diagnosa', DiagnosaController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('poliklinik', PoliklinikController::class);
    Route::resource('obat', ObatController::class);
    Route::resource('jaminan', JaminanController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('stokobat', StokObatController::class);
    Route::resource('depo', DepoController::class);
    Route::resource('jadwaldokter', JadwalDokterController::class);
    Route::resource('jadwallibur', JadwalLiburController::class);
    Route::resource('antrian', AntrianController::class);
    Route::resource('kunjungan', KunjunganController::class);
    Route::resource('suratkontrol', SuratKontrolController::class);
    Route::resource('spri', SPRIController::class);
    Route::resource('satuanobat', SatuanObatController::class);
    Route::resource('jenisobat', JenisObatController::class);
    Route::resource('tipebarang', TipeBarangController::class);
    Route::resource('merkbarang', MerkBarangController::class);
    Route::resource('distributorbarang', DistributorBarangController::class);
    Route::get('kirimpesanlibur', [JadwalLiburController::class, 'kirimpesanlibur'])->name('kirimpesanlibur');


    Route::resource('fileupload', FileUploadController::class);
    Route::get('fileupload_norm', [FileUploadController::class, 'fileupload_norm'])->name('fileupload_norm');

    Route::resource('tarif', TarifController::class);
    Route::get('tarifexport', [TarifController::class, 'tarifexport'])->name('tarifexport');
    Route::post('tarifimport', [TarifController::class, 'tarifimport'])->name('tarifimport');
    Route::get('laporan_layanan_tindakan', [TarifController::class, 'laporan_layanan_tindakan'])->name('laporan_layanan_tindakan');


    // anjungan
    Route::get('anjunganantrian', [PendaftaranController::class, 'anjunganantrian'])->name('anjunganantrian');
    Route::get('checkinantrian', [PendaftaranController::class, 'checkinantrian'])->name('checkinantrian');
    Route::get('ambilkarcis', [PendaftaranController::class, 'ambilkarcis'])->name('ambilkarcis');
    Route::get('karcisantrian', [PendaftaranController::class, 'karcisantrian'])->name('karcisantrian');
    Route::get('testprinterthermal', [ThermalPrintController::class, 'testprinterthermal'])->name('testprinterthermal');
    // form
    Route::get('form_identitaspasien', [FormController::class, 'form_identitaspasien'])->name('form_identitaspasien');
    Route::get('form_assesmentrajal', [FormController::class, 'form_assesmentrajal'])->name('form_assesmentrajal');
    Route::get('form_assesmentdokter', [FormController::class, 'form_assesmentdokter'])->name('form_assesmentdokter');
    // pendaftaran
    Route::get('antrianpendaftaran', [PendaftaranController::class, 'antrianpendaftaran'])->name('antrianpendaftaran');
    Route::get('prosespendaftaran', [PendaftaranController::class, 'prosespendaftaran'])->name('prosespendaftaran');
    Route::get('lihatpendaftaran', [PendaftaranController::class, 'lihatpendaftaran'])->name('lihatpendaftaran');
    Route::get('panggilpendaftaran', [PendaftaranController::class, 'panggilpendaftaran'])->name('panggilpendaftaran');
    Route::post('editantrian', [PendaftaranController::class, 'editantrian'])->name('editantrian');
    Route::post('editkunjungan', [PendaftaranController::class, 'editkunjungan'])->name('editkunjungan');
    Route::post('editlayananpendaftaran', [PendaftaranController::class, 'editlayananpendaftaran'])->name('editlayananpendaftaran');
    Route::get('ref_tarif_pendaftaran', [TarifController::class, 'ref_tarif_pendaftaran'])->name('ref_tarif_pendaftaran');
    Route::get('get_layanan_kunjungan', [TarifController::class, 'get_layanan_kunjungan'])->name('get_layanan_kunjungan');
    Route::get('ref_tarif_layanan', [TarifController::class, 'ref_tarif_layanan'])->name('ref_tarif_layanan');
    Route::post('input_tarif_pasien', [TarifController::class, 'input_tarif_pasien'])->name('input_tarif_pasien');
    Route::post('delete_tarif_pasien', [TarifController::class, 'delete_tarif_pasien'])->name('delete_tarif_pasien');
    Route::get('print_invoice_billing', [TarifController::class, 'print_invoice_billing'])->name('print_invoice_billing');

    Route::get('lanjutpoliklinik', [PendaftaranController::class, 'lanjutpoliklinik'])->name('lanjutpoliklinik');
    Route::get('batalantrian', [PendaftaranController::class, 'batalantrian'])->name('batalantrian');
    Route::get('tidakjadibatal', [PendaftaranController::class, 'tidakjadibatal'])->name('tidakjadibatal');
    Route::get('laporanpendaftaran', [PendaftaranController::class, 'laporanpendaftaran'])->name('laporanpendaftaran');
    Route::get('laporankunjungan', [PendaftaranController::class, 'laporankunjungan'])->name('laporankunjungan');
    Route::get('pdflaporanpendaftaran', [PendaftaranController::class, 'pdflaporanpendaftaran'])->name('pdflaporanpendaftaran');
    Route::get('laporanwaktuantrian', [PendaftaranController::class, 'laporanwaktuantrian'])->name('laporanwaktuantrian');
    // kasir
    Route::get('antriankasir', [KasirController::class, 'antriankasir'])->name('antriankasir');

    // perawat
    Route::resource('sbartbak', SbarController::class);
    Route::get('print_sbar_tbak', [SbarController::class, 'print_sbar_tbak'])->name('print_sbar_tbak');

    Route::get('antrianperawat', [PerawatController::class, 'antrianperawat'])->name('antrianperawat');
    Route::get('prosesperawat', [PerawatController::class, 'prosesperawat'])->name('prosesperawat');
    Route::post('editasesmenperawat', [PerawatController::class, 'editasesmenperawat'])->name('editasesmenperawat');
    Route::get('print_asesmen_perawat', [FormController::class, 'print_asesmen_perawat'])->name('print_asesmen_perawat');
    Route::get('print_resume_rajal', [FormController::class, 'print_resume_rajal'])->name('print_resume_rajal');
    Route::get('print_cppt', [FormController::class, 'print_cppt'])->name('print_cppt');
    Route::get('print_asesmen_rajal', [FormController::class, 'print_asesmen_rajal'])->name('print_asesmen_rajal');
    Route::post('uploadberkas', [PerawatController::class, 'uploadberkas'])->name('uploadberkas');
    Route::get('hapusfilepenunjang', [PerawatController::class, 'hapusfilepenunjang'])->name('hapusfilepenunjang');
    Route::get('laporanperawat', [PerawatController::class, 'laporanperawat'])->name('laporanperawat');
    Route::get('diagnosasearch', [DiagnosaController::class, 'search'])->name('diagnosa.search');
    Route::get('diagnosaexport', [DiagnosaController::class, 'export'])->name('diagnosa.export');
    Route::post('diagnosaimport', [DiagnosaController::class, 'diagnosaimport'])->name('diagnosaimport');
    Route::get('pasienexport', [PasienController::class, 'pasienexport'])->name('pasienexport');
    Route::post('pasienimport', [PasienController::class, 'pasienimport'])->name('pasienimport');
    // poliklinik
    Route::get('antrianpoliklinik', [DokterController::class, 'antrianpoliklinik'])->name('antrianpoliklinik');
    Route::get('prosespoliklinik', [DokterController::class, 'prosespoliklinik'])->name('prosespoliklinik');
    Route::post('editasesmendokter', [DokterController::class, 'editasesmendokter'])->name('editasesmendokter');
    Route::get('lanjutfarmasi', [DokterController::class, 'lanjutfarmasi'])->name('lanjutfarmasi');
    Route::get('selesaipoliklinik', [DokterController::class, 'selesaipoliklinik'])->name('selesaipoliklinik');
    Route::get('print_asesmendokter', [FormController::class, 'print_asesmendokter'])->name('print_asesmendokter');
    // farmasi
    Route::get('antrianfarmasi', [FarmasiController::class, 'antrianfarmasi'])->name('antrianfarmasi');

    Route::prefix('pelayanan')->name('pelayanan.')->group(function () {
        Route::get('farmasi', [FarmasiController::class, 'farmasi'])->name('farmasi');
        Route::prefix('farmasi')->name('farmasi.')->group(function () {
            Route::get('table_antrian_resep_obat', [FarmasiController::class, 'table_antrian_resep_obat'])->name('table_antrian_resep_obat');
        });
    });

    Route::get('getantrianfarmasi', [FarmasiController::class, 'getantrianfarmasi'])->name('getantrianfarmasi');
    Route::get('terimafarmasi', [FarmasiController::class, 'terimafarmasi'])->name('terimafarmasi');
    Route::get('selesaifarmasi', [FarmasiController::class, 'selesaifarmasi'])->name('selesaifarmasi');
    Route::get('laporanfarmasi', [FarmasiController::class, 'laporanfarmasi'])->name('laporanfarmasi');
    Route::get('laporanobat', [FarmasiController::class, 'laporanobat'])->name('laporanobat');
    Route::get('form_resep_obat', [ObatController::class, 'form_resep_obat'])->name('form_resep_obat');
    Route::post('update_resep_obat', [ObatController::class, 'update_resep_obat'])->name('update_resep_obat');
    Route::post('create_order_obat', [OrderObatController::class, 'create_order_obat'])->name('create_order_obat');
    Route::get('selesai_order_obat', [OrderObatController::class, 'selesai_order_obat'])->name('selesai_order_obat');
    Route::get('batal_order_obat', [OrderObatController::class, 'batal_order_obat'])->name('batal_order_obat');
    Route::get('reset_order_obat', [OrderObatController::class, 'reset_order_obat'])->name('reset_order_obat');
    Route::get('ref_obat_cari', [ObatController::class, 'ref_obat_cari'])->name('ref_obat_cari');
    Route::get('obatkemoterapi', [FarmasiController::class, 'obatkemoterapi'])->name('obatkemoterapi');
    Route::delete('batalkemotarapi', [FarmasiController::class, 'batalkemotarapi'])->name('batalkemotarapi');
    Route::get('obatexport', [ObatController::class, 'obatexport'])->name('obatexport');
    Route::post('obatimport', [ObatController::class, 'obatimport'])->name('obatimport');
    Route::post('store_resepkemoterapi', [FarmasiController::class, 'store_resepkemoterapi'])->name('store_resepkemoterapi');
    Route::get('get_resepkemoterapi', [FarmasiController::class, 'get_resepkemoterapi'])->name('get_resepkemoterapi');
    Route::get('print_resepkemoterapi', [FormController::class, 'print_resepkemoterapi'])->name('print_resepkemoterapi');
    Route::get('print_asesmenfarmasi', [FormController::class, 'print_asesmenfarmasi'])->name('print_asesmenfarmasi');
    Route::get('print_kartustokobat', [StokObatController::class, 'print_kartustokobat'])->name('print_kartustokobat');
    Route::get('edit_kartustokobat', [StokObatController::class, 'edit_kartustokobat'])->name('edit_kartustokobat');
    Route::post('update_kartustokobat', [StokObatController::class, 'update_kartustokobat'])->name('update_kartustokobat');
    Route::get('kunci_kartustokobat', [StokObatController::class, 'kunci_kartustokobat'])->name('kunci_kartustokobat');
    Route::get('hapus_kartustokobat', [StokObatController::class, 'hapus_kartustokobat'])->name('hapus_kartustokobat');
    Route::get('laporanobatpasien', [StokObatController::class, 'laporanobatpasien'])->name('laporanobatpasien');
    // lab
    Route::get('antrianlaboratorium', [FormController::class, 'antrianlaboratorium'])->name('antrianlaboratorium');
    Route::get('permintaanlab_index', [LaboratoriumController::class, 'permintaanlab_index'])->name('permintaanlab_index');
    Route::get('permintaanlab_proses', [LaboratoriumController::class, 'permintaanlab_proses'])->name('permintaanlab_proses');
    Route::get('permintaanlab_hasil_print', [LaboratoriumController::class, 'permintaanlab_hasil_print'])->name('permintaanlab_hasil_print');
    Route::post('permintaanlab_hasil', [LaboratoriumController::class, 'permintaanlab_hasil'])->name('permintaanlab_hasil');
    Route::post('permintaanlab_simpan', [LaboratoriumController::class, 'permintaanlab_simpan'])->name('permintaanlab_simpan');
    Route::get('pemeriksaanlabimport', [FormController::class, 'pemeriksaanlabimport'])->name('pemeriksaanlabimport');
    Route::resource('pemeriksaanlab', LaboratoriumController::class);
    Route::resource('parameterlab', ParameterLabController::class);
    Route::get('parameterlabexport', [ParameterLabController::class, 'parameterlabexport'])->name('parameterlabexport');
    Route::post('parameterlabimport', [ParameterLabController::class, 'parameterlabimport'])->name('parameterlabimport');

    // laboratorium
    Route::get('capaianantrian', [AntrianController::class, 'dashboardBulanAntrian'])->name('capaianantrian');
    Route::get('kunjunganwaktu', [KunjunganController::class, 'kunjunganwaktu'])->name('kunjunganwaktu');
    Route::get('riwayatpasien', [PasienController::class, 'riwayatpasien'])->name('riwayatpasien');

    // antrian bpjs
    Route::get('statusAntrianBpjs', [AntrianController::class, 'statusAntrianBpjs'])->name('statusAntrianBpjs');
    Route::get('poliklikAntrianBpjs', [PoliklinikController::class, 'poliklikAntrianBpjs'])->name('poliklikAntrianBpjs');
    Route::get('dokterAntrianBpjs', [DokterController::class, 'dokterAntrianBpjs'])->name('dokterAntrianBpjs');
    Route::get('jadwalDokterAntrianBpjs', [JadwalDokterController::class, 'jadwalDokterAntrianBpjs'])->name('jadwalDokterAntrianBpjs');
    Route::get('fingerprintPeserta', [PasienController::class, 'fingerprintPeserta'])->name('fingerprintPeserta');
    Route::get('antrianBpjsConsole', [AntrianController::class, 'antrianConsole'])->name('antrianBpjsConsole');
    Route::get('antrianBpjs', [PendaftaranController::class, 'antrianpendaftaran'])->name('antrianBpjs');
    Route::get('listTaskID', [AntrianController::class, 'listTaskID'])->name('listTaskID');
    Route::get('dashboardTanggalAntrian', [AntrianController::class, 'dashboardTanggalAntrian'])->name('dashboardTanggalAntrian');
    Route::get('dashboardBulanAntrian', [AntrianController::class, 'dashboardBulanAntrian'])->name('dashboardBulanAntrian');
    Route::get('antrianPerTanggal', [AntrianController::class, 'antrianPerTanggal'])->name('antrianPerTanggal');
    Route::get('monitoringAntrian', [AntrianController::class, 'monitoringAntrian'])->name('monitoringAntrian');
    Route::get('antrianPerKodebooking', [AntrianController::class, 'antrianPerKodebooking'])->name('antrianPerKodebooking');
    Route::get('antrianKodebookingLanjut', [AntrianController::class, 'antrianKodebookingLanjut'])->name('antrianKodebookingLanjut');
    Route::get('antrianBelumDilayani', [AntrianController::class, 'antrianBelumDilayani'])->name('antrianBelumDilayani');
    Route::get('antrianPerDokter', [AntrianController::class, 'antrianPerDokter'])->name('antrianPerDokter');
    // vclaim bpjs
    Route::get('peserta_bpjs', [VclaimController::class, 'peserta_bpjs'])->name('peserta_bpjs');
    Route::get('sep_rajal', [SepController::class, 'sep_rajal'])->name('sep_rajal');
    Route::get('sep_ranap', [SepController::class, 'sep_ranap'])->name('sep_ranap');
    Route::get('referensiVclaim', [VclaimController::class, 'referensiVclaim'])->name('referensiVclaim');
    Route::get('monitoringDataKunjungan', [VclaimController::class, 'monitoringDataKunjungan'])->name('monitoringDataKunjungan');
    Route::get('monitoringDataKlaim', [VclaimController::class, 'monitoringDataKlaim'])->name('monitoringDataKlaim');
    Route::get('monitoringPelayananPeserta', [VclaimController::class, 'monitoringPelayananPeserta'])->name('monitoringPelayananPeserta');
    Route::get('monitoringKlaimJasaraharja', [VclaimController::class, 'monitoringKlaimJasaraharja'])->name('monitoringKlaimJasaraharja');
    Route::get('ref_diagnosa_api', [VclaimController::class, 'ref_diagnosa_api'])->name('ref_diagnosa_api');
    Route::get('ref_icd10_api', [VclaimController::class, 'ref_icd10_api'])->name('ref_icd10_api');
    Route::get('ref_poliklinik_api', [VclaimController::class, 'ref_poliklinik_api'])->name('ref_poliklinik_api');
    Route::get('ref_faskes_api', [VclaimController::class, 'ref_faskes_api'])->name('ref_faskes_api');
    Route::get('ref_dpjp_api', [VclaimController::class, 'ref_dpjp_api'])->name('ref_dpjp_api');
    Route::get('ref_provinsi_api', [VclaimController::class, 'ref_provinsi_api'])->name('ref_provinsi_api');
    Route::get('ref_kabupaten_api', [VclaimController::class, 'ref_kabupaten_api'])->name('ref_kabupaten_api');
    Route::get('ref_kecamatan_api', [VclaimController::class, 'ref_kecamatan_api'])->name('ref_kecamatan_api');
    Route::get('suratKontrolBpjs', [SuratKontrolController::class, 'suratKontrolBpjs'])->name('suratKontrolBpjs');
    // kunjungan
    Route::get('riwayat_kunjungan_norm', [KunjunganController::class, 'riwayat_kunjungan_norm'])->name('riwayat_kunjungan_norm');
    // sep
    Route::resource('sep', SepController::class);
    Route::get('list_approval_sep', [SepController::class, 'list_approval_sep'])->name('list_approval_sep');
    Route::post('pengajuan_approval_sep', [SepController::class, 'pengajuan_approval_sep'])->name('pengajuan_approval_sep');
    Route::post('approval_sep', [SepController::class, 'approval_sep'])->name('approval_sep');
    Route::get('sep_print', [SepController::class, 'print'])->name('sep_print');
    Route::get('sep_hapus', [SepController::class, 'sep_hapus'])->name('sep_hapus');
    Route::get('laporansep', [SepController::class, 'laporansep'])->name('laporansep');
    Route::get('pdflaporansep', [SepController::class, 'pdflaporansep'])->name('pdflaporansep');
    // rujukan
    Route::resource('rujukan', RujukanController::class);
    Route::get('rujukankhusus', [RujukanController::class, 'rujukankhusus'])->name('rujukankhusus');
    // suratkontrol
    Route::get('suratkontrol_print', [SuratKontrolController::class, 'print'])->name('suratkontrol_print');
    Route::get('suratkontrol_hapus', [SuratKontrolController::class, 'suratkontrol_hapus'])->name('suratkontrol_hapus');
    // snyc
    Route::get('sync_antrian_bpjs', [SyncronizeController::class, 'sync_antrian_bpjs'])->name('sync_antrian_bpjs');
    Route::post('update_taksid_antrian', [SyncronizeController::class, 'update_taksid_antrian'])->name('update_taksid_antrian');
    // rekam medis
    Route::get('resumerawatjalan', [RekamMedisController::class, 'resumerawatjalan'])->name('resumerawatjalan');

    Route::prefix('satusehat')->group(function () {
        Route::get('token_generate', [SatuSehatController::class, 'token_generate'])->name('token_generate');
        Route::get('patient', [PatientController::class, 'index'])->name('patient');
        Route::get('patient_by_nik', [PatientController::class, 'patient_by_nik'])->name('patient_by_nik');
        Route::get('patient_sync', [PatientController::class, 'patient_sync'])->name('patient_sync');
        Route::get('practitioner', [PractitionerController::class, 'index'])->name('practitioner');
        Route::get('practitioner_by_nik', [PractitionerController::class, 'practitioner_by_nik'])->name('practitioner_by_nik');
        Route::get('practitioner_sync', [PractitionerController::class, 'practitioner_sync'])->name('practitioner_sync');
        Route::get('organization', [OrganizationController::class, 'index'])->name('organization');
        Route::get('organization_sync', [OrganizationController::class, 'organization_sync'])->name('organization_sync');
    });
    Route::get('download_backup_file', [BackupController::class, 'download_backup_file'])->name('download_backup_file');
    Route::get('printtest', [PrintController::class, 'printtest'])->name('printtest');
});
