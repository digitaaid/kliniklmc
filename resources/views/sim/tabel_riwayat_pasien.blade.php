<table class="table table-sm table-bordered table-hover">
    <thead>
        <tr>
            <th>Data Registrasi</th>
            <th>Anamnesa</th>
            <th>Penunjang</th>
            <th>Konsultasi Dokter</th>
            <th>Obat</th>
        </tr>
    </thead>
    <tbody>
        <style>
            pre {
                padding: 0 !important;
                margin-bottom: 0 !important;
                font-size: 15px !important;
                border: none;
                outline: none;
            }
        </style>
        @if ($antrian->pasien)
            @foreach ($antrian->pasien->kunjungans as $kunjungan)
                <tr>
                    <td>
                        {{ \Carbon\Carbon::parse($kunjungan->tgl_masuk)->format('d/m/Y h:m:s') }}
                        ({{ $kunjungan->kode }})
                        <br>
                        <b>{{ $kunjungan->units->nama }}</b>
                    </td>
                    <td>
                        @if ($kunjungan->asesmenperawat)
                            <dl>
                                <dt>Keluhan Utama :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</pre>
                                </dd>
                                <dt>Riwayat Pengobatan :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->asesmenperawat->riwayat_pengobatan ?? null }}</pre>
                                </dd>
                                <dt>Tanda Vital :</dt>
                                <dd>
                                    Denyut Nadi :
                                    {{ $kunjungan->asesmenperawat->denyut_jantung ?? null }}
                                    x/menit<br>
                                    Pernapasan :
                                    {{ $kunjungan->asesmenperawat->pernapasan ?? null }}
                                    x/menit<br>
                                    Suhu Tubuh :
                                    {{ $kunjungan->asesmenperawat->suhu ?? null }}
                                    celcius<br>
                                    Tekanan Darah :
                                    {{ $kunjungan->asesmenperawat->sistole ?? null }}
                                    /
                                    {{ $kunjungan->asesmenperawat->distole ?? null }}
                                    mmHg<br>
                                    Tinggi / Berat / BSA :
                                    {{ $kunjungan->asesmenperawat->tinggi_badan ?? null }}
                                    cm /
                                    {{ $kunjungan->asesmenperawat->berat_badan ?? null }}
                                    kg /
                                    @if ($kunjungan->asesmenperawat)
                                        {{ number_format(sqrt(($kunjungan->asesmenperawat->tinggi_badan * $kunjungan->asesmenperawat->berat_badan) / 3600), 2) ?? null }}
                                    @endif m2 <br>
                                    Kesadaran :
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
                                    <br>
                                    Tanda Vital Tubuh :
                                    {{ $kunjungan->asesmenperawat->keadaan_tubuh ?? '-' }}
                                </dd>
                            </dl>
                        @else
                            Belum Asesmen Perawat
                        @endif
                    </td>
                    <td>
                        @if ($kunjungan->files->count() != 0)
                            <b>Berkas Penunjang</b><br>
                            @foreach ($kunjungan->files as $file)
                                <button class="btn btn-xs btn-primary" data-nama="{{ $file->nama }}"
                                    data-fileurl="{{ $file->fileurl }}"><i class="fas fa-file-medical"></i>
                                    {{ $file->nama }}</button>
                                <br>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if ($kunjungan->asesmendokter)
                            <dl>
                                <dt>Diagnosa</dt>
                                <dd>
                                    {{ $kunjungan->asesmendokter->diagnosa ?? null }}
                                    <br>
                                    Diag. Primer ICD-10 :
                                    {{ $kunjungan->asesmendokter->diagnosa1 ?? null }}
                                    <br>
                                    Diag. Sekunder ICD-10 :
                                    {{ $kunjungan->asesmendokter->diagnosa2 ?? null }}
                                </dd>
                                <dt>Pemeriksaan Fisik :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->asesmendokter->pemeriksaan_fisik ?? null }}</pre>
                                </dd>
                                <dt>Tindakan :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->asesmendokter->tindakan_medis ?? null }}</pre>
                                </dd>
                                <dt>Instruksi Medis :</dt>
                                <dd>
                                    <pre>{{ $kunjungan->asesmendokter->instruksi_medis ?? null }}</pre>
                                </dd>
                            </dl>
                        @else
                            Belum Asesmen Dokter
                        @endif

                    </td>
                    <td>
                        @if ($kunjungan->resepobat)
                            <dd>
                                @foreach ($kunjungan->resepobat->resepdetail as $itemobat)
                                    <b> R/ {{ $itemobat->nama }} </b>
                                    ({{ $itemobat->jumlah }})
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
                            </dd>
                            <dt>Catatan Resep :</dt>
                            <dd>
                                <pre>{{ $kunjungan->asesmendokter->resep_obat ?? null }}</pre>
                                <pre>{{ $kunjungan->asesmendokter->catatan_resep ?? null }}</pre>
                            </dd>
                        @else
                            Belum Ada Resep
                        @endif

                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5">Belum ada riwayat pasien</td>
            </tr>
        @endif
    </tbody>
</table>
