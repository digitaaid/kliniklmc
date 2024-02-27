<section>
    <div class="col-md-12">
        <div class="row">
            @include('form.assesmen_kop')
            <div class="col-md-12 text-center">
                <b class="">ASESMEN / PENGKAJIAN AWAL RAWAT JALAN</b>
            </div>
            <div class="col-md-12">
                <h5>SUBJECTIVE (S)</h5>
                <div class="row">
                    <div class="col-md-12">
                        <h6>Anamnesa Pasien</h6>
                        <table class="table-sm table table-bordered">
                            <tr>
                                <td style="width: 20%" style="border: 1px solid #000">Sumber Data</td>
                                <td style="width: 80%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 20%">Keluhan Utama</td>
                                <td style="width: 80%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 20%">Riwayat Penyakit Dahulu</td>
                                <td style="width: 80%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 20%">Riwayat Penyakit Keluarga</td>
                                <td style="width: 80%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 20%">Riwayat Alergi</td>
                                <td style="width: 80%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 20%">Riwayat Pengobatan</td>
                                <td style="width: 80%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <h6>Psikologi, Sosial, dan Ekonomi</h6>
                    </div>
                    <div class="col-md-6">
                        <table class="table-sm table table-bordered">
                            <tr>
                                <td style="width: 30%">Status Psikologi</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 30%">Tinggal Dengan</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 30%">Hubungan Keluarga</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 30%">Ekonomi</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 100%" colspan="2">Edukasi Diberikan Kepada Fisik</td>
                            </tr>

                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table-sm table table-bordered">
                            <tr>
                                <td style="width: 30%">Pekerjaan Psikologi</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 30%">Agama</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 30%">Pendidikan</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 30%">Status Nikah</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 30%">Bahasa</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>

                        </table>
                    </div>
                    <div class="col-md-4">
                        <h6>Asesmen Nyeri, Resiko Jatuh, dan Fungsional</h6>
                        <table class="table-sm table table-bordered">
                            <tr>
                                <td style="width: 30%">Skala Nyeri</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 30%">Keluhan Nyeri</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 30%">Resiko Jatuh</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 30%">Alat Bantu</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 30%">Cacat Fisik</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>

                        </table>
                    </div>
                    <div class="col-md-8">
                        <h6>Skrinning Gizi</h6>
                        <table class="table-sm table table-bordered">
                            <tr>
                                <td style="width: 80%">1. Apakah pasien mengalami penurunan berat badan yang tidak
                                    diinginkan dalam 6 bulan terakhir ?</td>
                                <td style="width: 20%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 80%">2. Apakah asupan makanan berkurang karena berkurangnya nafsu
                                    makan
                                    ?</td>
                                <td style="width: 20%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 80%">3. Apakah pasien dengan diagnosa khusus : Penyakit
                                    DM/Ginjal/Hati/Paru/Stroke/Kanker/Penurunan imun/lainnya ?</td>
                                <td style="width: 20%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <h5>OBJECTIVE (O)</h5>
                <div class="row">
                    <div class="col-md-12">
                        <h6>Tanda Vital Tubuh</h6>
                    </div>
                    <div class="col-md-12">
                        <table class="table-sm table table-bordered">
                            <tr>
                                <td style="width: 10%">Denyut Nadi</td>
                                <td style="width: 40%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                                <td style="width: 10%">Kesadaran</td>
                                <td style="width: 40%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 10%">Pernapasan</td>
                                <td style="width: 40%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                                <td rowspan="5" style="width: 10%">Pemeriksaan Fisik</td>
                                <td rowspan="5" style="width: 40%">
                                    {{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 10%">Suhu Tubuh</td>
                                <td style="width: 40%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 10%">Tekanan Darah</td>
                                <td style="width: 40%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 10%">Tinggi Badan</td>
                                <td style="width: 40%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 10%">Berat Badan</td>
                                <td style="width: 40%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <h6>Laboratorium, Radiologi, & Penunjang Lainnya</h6>
                    </div>
                    <div class="col-md-12">
                        <table class="table-sm table table-bordered">
                            <tr>
                                <td style="width: 30%">Pemeriksaan Laboratorium</td>
                                <td style="width: 30%">Pemeriksaan Radiologi</td>
                                <td style="width: 30%">Pemeriksaan Penunjang</td>
                            </tr>
                            <tr>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <h5>ANALYSIS (A)</h5>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table-sm table table-bordered">
                            <tr>
                                <td style="width: 30%">Diagnosis Keperwatan</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <h5>PLANNING (P)</h5>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table-sm table table-bordered">
                            <tr>
                                <td style="width: 30%">Rencana Keperawatan</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 30%">Tindakan Keperawatan</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                            <tr>
                                <td style="width: 30%">Evaluasi Keperwatan</td>
                                <td style="width: 70%">{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8 border-dark">
            </div>
            <div class="col-md-4 border-dark">
                <b> Cirebon,
                    {{ $kunjungan->asesmenperawat ? Carbon\Carbon::parse($kunjungan->asesmenperawat->waktu)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
                    <br>
                    Perawat,</b>

                <br><br><br><br>
                <b>
                    @if ($kunjungan->asesmenperawat->pic1)
                        {{ $kunjungan->asesmenperawat->pic1->name }}
                    @else
                        {{ $kunjungan->asesmenperawat->user }}
                    @endif

                </b>
            </div>
        </div>
    </div>
</section>
@section('css')
    <style>
        pre {
            padding: 0 !important;
            font-size: 15px !important;
        }
    </style>
    <style>
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin-bottom: 3px !important;
        }

        .table,
        td,
        th {
            font-size: 10px;
            padding: 2px !important;
            padding-left: 3px !important;
            margin-bottom: 9px !important;
        }
        h6 {
            font-size: 11px
        }

        h5 {
            font-size: 12px
        }
    </style>
@endsection
