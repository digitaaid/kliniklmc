<section>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2 border border-dark">
                <div class="m-2  text-center">
                    <img class="" src="{{ asset('logo3.png') }}" style="height: 80px">
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
                    <b>ASESMEN DOKTER RAWAT JALAN</b>
                </div>
            </div>
            <div class="col-md-6 border border-dark">
                <div class="m-2 ">
                    <u><b>PEMERIKSAAN SPESIALISTIK</b></u>
                    <dl>
                        <dt>Diagnosa Primer :</dt>
                        <dd>
                            {{ $kunjungan->asesmendokter->diagnosa1 ?? null }}
                        </dd>
                        <dt>Diagnosa Sekunder :</dt>
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
@section('css')
    <style>
        pre {
            padding: 0 !important;
            font-size: 15px !important;
        }
    </style>
@endsection
