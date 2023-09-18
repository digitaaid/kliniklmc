<section>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2 border border-dark">
                <div class="m-2  text-center">
                    <img class="" src="{{ asset('logo3.png') }}"
                        style="height: 80px">
                </div>
            </div>
            <div class="col-md-6  border border-dark">
                <b>RS</b><br>
                Jl. Raya Sunan Gunung Jati No. 100 A/B <br>
                Desa Pasindangan Kec. Gunungjati Kab. Cirebon Jawa Barat 45151<br>
                www.luthfimedicalcenter.com - Whatasapp 0823 1169 6919 -
                Call Center (0231) 8850943
            </div>
            <div class="col-md-4  border border-dark">
                <div class="row">
                    <div class="p-2">
                        {!! QrCode::size(70)->generate($kunjungan->norm) !!}
                    </div>
                    <div>
                        No RM : <b>{{ $kunjungan->norm }}</b> <br>
                        Nama : <b>{{ $kunjungan->nama }}</b> <br>
                        Tgl Lahir : <b>{{ $kunjungan->tgl_lahir }}</b> <br>
                        Kelamin : <b>{{ $kunjungan->gender }}</b>
                    </div>
                </div>
            </div>
            <div class="text-center col-md-12 border border-dark bg-warning">
                <div class="m-2 ">
                    <b>ASESMEN PERAWAT RAWAT JALAN</b>
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
                            <b>Distole : </b>
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
            <div class="col-md-8 border-dark">
            </div>
            <div class="col-md-4 border-dark">
                <b> Cirebon,
                    {{ $kunjungan->asesmenperawat ? Carbon\Carbon::parse($kunjungan->asesmenperawat->waktu)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
                    <br>
                    Perawat,</b>

                <br><br><br><br>
                <b>{{ $kunjungan->asesmenperawat->user ?? null }}</b>
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
@endsection
