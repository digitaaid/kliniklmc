<section class="invoice p-3 mb-1">
    <div class="col-md-12">
        <div class="row">
            @include('form.assesmen_kop')
            <div class="text-center col-md-12 border border-dark bg-warning">
                <div class="m-2 ">
                    <b>ASESMEN AWAL RAWAT JALAN</b>
                </div>
            </div>
            <div class="col-md-6 border border-dark">
                <div class="m-2 ">
                    <u><b>ANAMNESA</b></u>
                    <dl>
                        <dt>Keluhan Utama :</dt>
                        <dd>
                            <pre>{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</pre>
                        </dd>
                        <dt>Riwayat Penyakit :</dt>
                        <dd>
                            <pre>{{ $kunjungan->asesmenperawat->riwayat_penyakit ?? null }}</pre>
                        </dd>
                        <dt>Riwayat Alergi :</dt>
                        <dd>
                            <pre>{{ $kunjungan->asesmenperawat->riwayat_alergi ?? null }}</pre>
                        </dd>
                        <dt>Riwayat Pengobatan :</dt>
                        <dd>
                            <pre>{{ $kunjungan->asesmenperawat->riwayat_pengobatan ?? null }}</pre>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="col-md-6 border border-dark">
                <div class="m-2 ">
                    <u><b>PEMERIKSAAN FISIK</b></u>
                    <br>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <b>Denyut Jantung : </b>
                            {{ $kunjungan->asesmenperawat->denyut_jantung ?? null }}
                            spm <br>
                            <b>Pernapasan : </b>
                            {{ $kunjungan->asesmenperawat->pernapasan ?? null }} spm
                            <br>
                            <b>Suhu Tubuh : </b>
                            {{ $kunjungan->asesmenperawat->suhu ?? null }} spm <br>
                            <b>Tekanan Darah </b> <br>
                            <b>Sistole : </b>
                            {{ $kunjungan->asesmenperawat->sistole ?? null }} /
                            <b>Diastole : </b>
                            {{ $kunjungan->asesmenperawat->distole ?? null }}
                            <br>
                        </div>
                        <div class="col-md-6">
                            <b>Tinggi Badan : </b>
                            {{ $kunjungan->asesmenperawat->tinggi_badan ?? null }}
                            cm<br>
                            <b>Berat Badan : </b>
                            {{ $kunjungan->asesmenperawat->berat_badan ?? null }}
                            kg<br>
                            <b>Index BSA : </b>
                            {{ $kunjungan->asesmenperawat->bsa ?? null }} m2<br>

                        </div>
                    </div>
                    <dl>
                        <dt>Tingkat Kesadaran :</dt>
                        <dd>
                            @if ($kunjungan->asesmenperawat)
                                @switch($kunjungan->asesmenperawat->tingkat_kesadaran)
                                    @case(1)
                                        Sadar Baik
                                    @break

                                    @case(2)
                                        Berespon dengan kata-kata
                                    @break

                                    @case(3)
                                        Hanya berespons jika dirangsang nyeri/pain
                                    @break

                                    @case(4)
                                        Pasien tidak sadar/unresponsive
                                    @break

                                    @case(5)
                                        Gelisah / bingung
                                    @break

                                    @case(6)
                                        Acute Confusional State
                                    @break

                                    @default
                                @endswitch
                            @endif
                        </dd>
                        <dt>Tanda Vital Tubuh</dt>
                        <dd>
                            <pre>{{ $kunjungan->asesmenperawat->keadaan_tubuh ?? null }}</pre>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="col-md-6 border border-dark">
                <div class="m-2 ">
                    <u><b>PEMERIKSAAN PSIKOLOGI</b></u>
                    <dl>
                        <dt>Kondisi Psikologis :</dt>
                        <dd>
                            <pre>{{ $kunjungan->asesmenperawat->status_psikologi ?? null }}</pre>
                        </dd>
                        <dt>Kondisi Sosial Ekonomi :</dt>
                        <dd>
                            <pre>{{ $kunjungan->asesmenperawat->status_sosial ?? null }}</pre>
                        </dd>
                        <dt>Kondisi Spiritual :</dt>
                        <dd>
                            <pre>{{ $kunjungan->asesmenperawat->status_spiritual ?? null }}</pre>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="col-md-6 border border-dark">
                <div class="m-2 ">
                    <u><b>CATATAN</b></u>
                </div>
            </div>
            <div class="text-center col-md-12 border border-dark bg-warning">
                <div class="m-2 ">
                    <b>ASESMEN DOKTER RAWAT JALAN</b>
                </div>
            </div>
            <div class="col-md-6 border border-dark">
                <div class="m-2 ">
                    <u><b>PEMERIKSAAN SPESIALISTIK</b></u>
                    <dl>
                        <dt>Diagnosa</dt>
                        <dd>
                            {{ $kunjungan->asesmendokter->diagnosa ?? null }}
                        </dd>
                        <dt>Diagnosa Primer ICD-10 :</dt>
                        <dd>
                            {{ $kunjungan->asesmendokter->diagnosa1 ?? null }}
                        </dd>
                        <dt>Diagnosa Sekunder ICD-10 :</dt>
                        <dd>
                            {{ $kunjungan->asesmendokter->diagnosa2 ?? null }}
                        </dd>
                        <dt>Riwayat Pengobatan :</dt>
                        <dd>
                            <pre>{{ $kunjungan->asesmendokter->riwayat_pengobatan ?? null }}</pre>
                        </dd>
                        <dt>Rencana Perawatan :</dt>
                        <dd>
                            <pre>{{ $kunjungan->asesmendokter->rencana_perawatan ?? null }}</pre>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="col-md-6 border border-dark">
                <div class="m-2 ">
                    <u><b>TERAPI DAN OBAT SPESIALISTIK</b></u>
                    <dl>
                        <dt>Tindakan :</dt>
                        <dd>
                            <pre>{{ $kunjungan->asesmendokter->tindakan_medis ?? null }}</pre>
                        </dd>
                        <dt>Instruksi Medis :</dt>
                        <dd>
                            <pre>{{ $kunjungan->asesmendokter->instruksi_medis ?? null }}</pre>
                        </dd>
                        <dt>Resep Obat :</dt>
                        <dd>
                            <pre>{{ $kunjungan->asesmendokter->resep_obat ?? null }}</pre>
                        </dd>
                        <dt>Catatan Resep :</dt>
                        <dd>
                            <pre>{{ $kunjungan->asesmendokter->catatan_resep ?? null }}</pre>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="col-md-6 border border-dark">
                <div class="m-2 ">
                    <u><b>PEMERIKSAAN PENUNJANG</b></u>
                    <dl>
                        <dt>Catatan Laboratorium :</dt>
                        <dd>
                            <pre>{{ $kunjungan->asesmendokter->catatan_lab ?? null }}</pre>
                        </dd>
                        <dt>Catatan Radiologi Ekonomi :</dt>
                        <dd>
                            <pre>{{ $kunjungan->asesmendokter->catatan_rad ?? null }}</pre>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="col-md-6 border border-dark">
                <div class="m-2 ">
                    <u><b>CATATAN</b></u>
                </div>
            </div>
            <div class="col-md-8 border-dark">
            </div>
            <div class="col-md-4 border-dark">
                <b> Cirebon,
                    {{ $kunjungan->asesmendokter ? Carbon\Carbon::parse($kunjungan->asesmendokter->waktu)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
                    <br>
                    Dokter DPJP,</b>
                <br><br><br><br>
                <b>{{ $kunjungan->asesmendokter->user ?? null }}</b>
            </div>
        </div>
    </div>
</section>
{{-- @section('css')
    <style>
        pre {
            padding: 0 !important;
            font-size: 15px !important;
        }
    </style>
@endsection --}}
