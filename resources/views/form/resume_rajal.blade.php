<section>
    <div class="col-md-12" style="font-size: 12px">
        <div class="row">
            @include('form.assesmen_kop')
            <div class="col-md-12 border border-dark text-center">
                <b class="">RESUME MEDIS RAWAT JALAN</b>
            </div>
            <div class="col-md-12 border border-dark">
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-3 m-0">RM</dt>
                            <dd class="col-sm-9 m-0">
                                {{ $antrian->norm ? $antrian->norm : 'Belum Didaftarkan' }} </dd>
                            <dt class="col-sm-3 m-0">Nama</dt>
                            <dd class="col-sm-9 m-0">
                                {{ $antrian->nama ? $antrian->nama : 'Belum Didaftarkan' }}
                                {{ $antrian->kunjungan ? '(' . $antrian->kunjungan->gender . ')' : null }}
                            </dd>
                            <dt class="col-sm-3 m-0"> Tgl Lahir</dt>
                            <dd class="col-sm-9 m-0">
                                @if ($antrian->kunjungan)
                                    {{ $antrian->kunjungan->tgl_lahir ?? 'Belum didaftarkan' }}
                                    ({{ \Carbon\Carbon::parse($antrian->kunjungan->tgl_masuk)->diffInYears($antrian->kunjungan->tgl_lahir) }}
                                    tahun)
                                @else
                                    Belum Kunjungan
                                @endif
                            </dd>
                            <dt class="col-sm-3 m-0"> Alamat</dt>
                            <dd class="col-sm-9 m-0">
                                {{ $antrian->pasien ? $antrian->pasien->alamat : '-' }}
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-3 m-0">Tgl Periksa</dt>
                            <dd class="col-sm-9 m-0">{{ $antrian->tanggalperiksa }}</dd>
                            <dt class="col-sm-3 m-0">Unit</dt>
                            <dd class="col-sm-9 m-0">
                                {{ $antrian->kunjungan ? $antrian->kunjungan->units->nama : 'Belum Kunjungan' }}
                            </dd>
                            <dt class="col-sm-3 m-0">Dokter</dt>
                            <dd class="col-sm-9 m-0">
                                {{ $antrian->kunjungan ? $antrian->kunjungan->dokters->namadokter : 'Belum Kunjungan' }}
                            </dd>
                            <dt class="col-sm-3 m-0">Jaminan</dt>
                            <dd class="col-sm-9 m-0">
                                @switch($antrian->jeniskunjungan)
                                    @case(1)
                                        Rujukan FKTP
                                    @break

                                    @case(2)
                                        Umum
                                    @break

                                    @case(3)
                                        Surat Kontrol
                                    @break

                                    @case(4)
                                        Rujukan Antar RS
                                    @break

                                    @default
                                        Belum Kunjungan
                                @endswitch
                            </dd>
                            @if ($antrian->jeniskunjungan != 2)
                                <dt class="col-sm-3 m-0">No Ref</dt>
                                <dd class="col-sm-9 m-0">
                                    {{ $antrian->nomorreferensi ?? '-' }}
                                </dd>
                                <dt class="col-sm-3 m-0">SEP</dt>
                                <dd class="col-sm-9 m-0">
                                    @if ($antrian->sep)
                                        {{ $antrian->sep }}
                                    @else
                                        -
                                    @endif
                                </dd>
                            @endif

                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-md-6 border border-dark">
                <b>ANAMNESA</b>
                <dl class="row">
                    <dt class="col-sm-3">Keluhan Utama</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmenperawat->keluhan_utama ?? '-' }}</dd>
                    <dt class="col-sm-3">RPD</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmenperawat->riwayat_penyakit ?? '-' }}</dd>
                    <dt class="col-sm-3">RPK</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmenperawat->riwayat_penyakit_keluarga ?? '-' }}
                    </dd>
                    <dt class="col-sm-3">R Alergi</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmenperawat->riwayat_alergi ?? '-' }}</dd>
                    <dt class="col-sm-3">Social</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmenperawat->hubungan ?? '-' }}</dd>
                    <dt class="col-sm-3">Pekerjaan</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmenperawat->pekerjaan ?? '-' }}</dd>
                    <dt class="col-sm-3">Ekonomi</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmenperawat->ekonomi ?? '-' }}</dd>
                    <dt class="col-sm-3">Psikologi</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmenperawat->status_psikologi ?? '-' }}</dd>
                </dl>
            </div>
            <div class="col-md-6  border border-dark">
                <b>ANJURAN</b>
                <dl class="row">
                    <dt class="col-sm-3">Instruksi Medis</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmendokter->instruksi_medis ?? '-' }}</dd>
                </dl>
            </div>
            <div class="col-md-6 border border-dark">
                <b>DIAGNOSA</b>
                <dl class="row">
                    <dt class="col-sm-3">Diagnosa Keperawatan</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmenperawat->diagnosa_keperawatan ?? '-' }}</dd>
                    <dt class="col-sm-3">Diagnosa Klinis</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmendokter->diagnosa ?? '-' }}</dd>
                    <dt class="col-sm-3">Diagnosa Sekunder</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmendokter->catatan_diagnosa ?? '-' }}</dd>
                    <dt class="col-sm-3">ICD-10 Primer</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmendokter->diagnosa1 ?? '-' }}</dd>
                    <dt class="col-sm-3">ICD-10 Sekunder</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmendokter->diagnosa2 ?? '-' }}</dd>
                </dl>
            </div>
            <div class="col-md-6  border border-dark">
                <b>TERAPI</b>
                <dl class="row">
                    <dt class="col-sm-3">Tindakan Perawat</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmenperawat->tindakan_keperawatan ?? '-' }}</dd>
                    <dt class="col-sm-3">Tindakan Dokter</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmendokter->tindakan_medis ?? '-' }}</dd>
                </dl>
                <dl>
                    <dt>Resep Obat :</dt>
                    @if ($antrian->resepobat)
                        Kode Resep : {{ $antrian->resepobat->kode }}<br>
                        @if ($antrian->resepobat)
                            @foreach ($antrian->resepobat->resepdetail as $itemobat)
                                <b> R/ {{ $itemobat->nama }} </b> ({{ $itemobat->jumlah }}) <br>
                                &emsp;&emsp;
                                @switch($itemobat->interval)
                                    @case('qod')
                                        1x1
                                    @break

                                    @case('dod')
                                        1x2
                                    @break

                                    @case('bid')
                                        2x1
                                    @break

                                    @case('tid')
                                        3x1
                                    @break

                                    @case('qid')
                                        4x1
                                    @break

                                    @case('prn')
                                        SESUAI KEBUTUHAN
                                    @break

                                    @case('q3h')
                                        SETIAP 3 JAM
                                    @break

                                    @case('q4h')
                                        SETIAP 4 JAM
                                    @break

                                    @case('303')
                                        3 TAB/CAP SETIAP PAGI DAN MALAM
                                    @break

                                    @case('202')
                                        2 TAB/CAP SETIAP PAGI DAN MALAM
                                    @break

                                    @default
                                @endswitch


                                @switch($itemobat->waktu)
                                    @case('pc')
                                        SETELAH MAKAN
                                    @break

                                    @case('ac')
                                        SEBELUM MAKAN
                                    @break

                                    @case('hs')
                                        SEBELUM TIDUR
                                    @break

                                    @case('int')
                                        DIANTARA WAKTU MAKAN
                                    @break

                                    @default
                                @endswitch
                                {{ $itemobat->keterangan }} <br>
                            @endforeach
                        @endif
                    @endif
                </dl>
            </div>
            <div class="col-md-12  border border-dark">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6 text-center">
                        <b>DPJP,</b> <br>
                        {!! QrCode::size(70)->generate('Telah diisi dan dikonfirmasi ' . $antrian->asesmendokter->waktu) !!} <br>
                        <b><u>{{ $antrian->kunjungan->dokters->namadokter }}</u></b> <br>
                        Waktu : {{ $antrian->asesmendokter->waktu }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
