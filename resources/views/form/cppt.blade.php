        <div class="col-md-12" style="font-size: 13px">
            <div class="row">
                <div class="col-md-2 border border-dark">
                    <div class="m-2  text-center">
                        <img class="" src="{{ asset('medicio/assets/img/lmc.png') }}" style="height: 60px">
                    </div>
                </div>
                <div class="col-md-6  border border-dark">
                    <b>KLINIK UTAMA LUTHFI MEDICAL CENTER</b><br>
                    Jl. Raya Sunan Gunung Jati No. 100 A/B <br>
                    Desa Pasindangan Kec. Gunungjati Kab. Cirebon Jawa Barat 45151<br>
                    www.luthfimedicalcenter.com - 0823 1169 6919 - (0231) 8850943
                </div>
                <div class="col-md-4  border border-dark">
                    <div class="row">
                        <div class="p-2">
                            No RM : <b>{{ $pasien->norm ?? '-' }}</b> <br>
                            Nama : <b>{{ $pasien->nama ?? '-' }}</b> <br>
                            Tgl Lahir : <b>{{ $pasien->tgl_lahir ?? '-' }}
                                ({{ \Carbon\Carbon::parse($pasien->tgl_lahir ?? '1998-08-08')->diffInYears(now()) }}
                                tahun)</b> <br>
                            Kelamin : <b>{{ $pasien->gender ?? '-' }}</b>

                        </div>
                    </div>
                </div>
                <div class="col-md-2 border border-dark text-center">
                    <b>NORM</b>
                </div>
                <div class="col-md-7 border border-dark text-center">
                    <b>NAMA</b>
                </div>
                <div class="col-md-3 border border-dark text-center">
                    <b>REGISTRASI</b>
                </div>
                <div class="col-md-2 border border-dark text-center">
                    <h5>{{ $pasien->norm ?? '-' }}</h5>
                </div>
                <div class="col-md-7 border border-dark text-center">
                    <h5>{{ $pasien->nama ?? '-' }}</h5>
                </div>
                <div class="col-md-3 border border-dark text-center">
                    {{ $pasien->created_at ?? '-'}}
                </div>
                <div class="col-md-12 border border-dark">
                    <div class="row">
                        <div class="col-md-5">
                            <dl class="row">
                                <dt class="col-sm-3 m-0">Nama</dt>
                                <dd class="col-sm-9 m-0">{{ $pasien->nama ?? '-' }}</dd>
                                <dt class="col-sm-3 m-0">Tgl Lahir</dt>
                                <dd class="col-sm-9 m-0">{{ $pasien->tgl_lahir ?? '-' }}</dd>
                                <dt class="col-sm-3 m-0">Jns Kelamin</dt>
                                <dd class="col-sm-9 m-0">{{ $pasien->gender ?? '-' }}</dd>
                                <dt class="col-sm-3 m-0">Alamat</dt>
                                <dd class="col-sm-9 m-0">{{ $pasien->alamat ?? '-' }}</dd>

                            </dl>
                        </div>
                        <div class="col-md-5">
                            <dl class="row">
                                <dt class="col-sm-3 m-0">No RM</dt>
                                <dd class="col-sm-9 m-0">{{ $pasien->norm ?? '-' }}</dd>
                                <dt class="col-sm-3 m-0">NIK</dt>
                                <dd class="col-sm-9 m-0">{{ $pasien->nik?? '-' }}</dd>
                                <dt class="col-sm-3 m-0">No BPJS</dt>
                                <dd class="col-sm-9 m-0">{{ $pasien->nomorkartu ?? '-'}}</dd>
                                <dt class="col-sm-3 m-0">No HP</dt>
                                <dd class="col-sm-9 m-0">{{ $pasien->nohp ?? '-'}}</dd>
                            </dl>
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 border border-dark text-center bg-warning">
                    <b class="">CATATAN PERKEMBANGAN PASIEN TERINTEGRASI</b>
                </div>
                <div class="col-md-2  border border-dark">
                    <b>Registrasi</b>
                </div>
                <div class="col-md-3  border border-dark">
                    <b>Perawat</b>
                </div>
                <div class="col-md-2  border border-dark">
                    <b>Penunjang</b>
                </div>
                <div class="col-md-3  border border-dark">
                    <b>Dokter</b>
                </div>
                <div class="col-md-2  border border-dark">
                    <b>Farmasi</b>
                </div>
                @if ($kunjungans)
                    @foreach ($kunjungans as $kunjungan)
                        <div class="col-md-2  border border-dark">
                            {{ \Carbon\Carbon::parse($kunjungan->tgl_masuk)->format('d/m/Y h:m:s') }}
                            ({{ $kunjungan->kode }})
                            <br>
                            <b>{{ $kunjungan->units->nama }}</b>
                        </div>
                        <div class="col-md-3  border border-dark">
                            @if ($kunjungan->asesmenperawat)
                                <dl>
                                    <dt>Keluhan Utama :</dt>
                                    <dd>
                                        <pre>{{ $kunjungan->asesmenperawat->keluhan_utama ?? '-' }}</pre>
                                    </dd>
                                    <dt>Riwayat Pengobatan :</dt>
                                    <dd>
                                        @if ($kunjungan->asesmenperawat)
                                            @if ($kunjungan->asesmenperawat->pernah_berobat == 'Iya')
                                                {{ $kunjungan->asesmenperawat->pernah_berobat ?? null }} pernah berobat
                                                <i class="fas fa-check"></i> <br>
                                            @endif
                                            @if ($kunjungan->asesmenperawat->pernah_berobat == 'Tidak')
                                                {{ $kunjungan->asesmenperawat->pernah_berobat ?? null }} pernah berobat
                                                <i class="fas fa-times"></i> <br>
                                            @endif
                                        @endif
                                        <pre>{{ $kunjungan->asesmenperawat->riwayat_pengobatan ?? '-' }}</pre>
                                    </dd>
                                    <dt>Riwayat Penyakit :</dt>
                                    <dd>
                                        <pre>Dahulu : {{ $kunjungan->asesmenperawat->riwayat_penyakit ?? 'Tidak Ada' }}, Keluarga : {{ $kunjungan->asesmenperawat->riwayat_penyakit_keluarga ?? 'Tidak Ada' }}</pre>
                                        <pre>Reaksi Alergi : {{ $kunjungan->asesmenperawat->riwayat_alergi ?? 'Tidak Ada' }}</pre>
                                    </dd>
                                    {{-- <dt>Riwayat Alergi :</dt>
                                <dd> --}}
                                    </dd>
                                    <dt>Tanda Vital :</dt>
                                    <dd>
                                        Denyut Nadi :
                                        {{ $kunjungan->asesmenperawat->denyut_jantung ?? '-' }}
                                        x/menit<br>
                                        Pernapasan :
                                        {{ $kunjungan->asesmenperawat->pernapasan ?? '-' }}
                                        x/menit<br>
                                        Suhu Tubuh :
                                        {{ $kunjungan->asesmenperawat->suhu ?? '-' }}
                                        celcius<br>
                                        Tekanan Darah :
                                        {{ $kunjungan->asesmenperawat->sistole ?? '-' }}
                                        /
                                        {{ $kunjungan->asesmenperawat->distole ?? '-' }}
                                        mmHg<br>
                                        Tinggi / Berat / BSA :
                                        {{ $kunjungan->asesmenperawat->tinggi_badan ?? '-' }}
                                        cm /
                                        {{ $kunjungan->asesmenperawat->berat_badan ?? '-' }}
                                        kg /
                                        @if ($kunjungan->asesmenperawat)
                                            {{ number_format(sqrt(($kunjungan->asesmenperawat->tinggi_badan * $kunjungan->asesmenperawat->berat_badan) / 3600), 2) ?? '-' }}
                                        @endif m2 <br>
                                        Kesadaran :
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
                                        <br>
                                        @if ($kunjungan->asesmenperawat->keadaan_tubuh)
                                            Pemeriksaan Fisik :
                                            {{ $kunjungan->asesmenperawat->keadaan_tubuh ?? '-' }}
                                        @endif
                                    </dd>
                                    @if ($kunjungan->asesmenperawat->diagnosa_keperawatan)
                                        <dt>Diagnosa Keperawatan :</dt>
                                        <dd>{{ $kunjungan->asesmenperawat->diagnosa_keperawatan }} </dd>
                                    @endif
                                    @if ($kunjungan->asesmenperawat->rencana_keperawatan)
                                        <dt>Rencana Keperawatan :</dt>
                                        <dd>{{ $kunjungan->asesmenperawat->rencana_keperawatan }}</dd>
                                    @endif
                                    @if ($kunjungan->asesmenperawat->tindakan_keperawatan)
                                        <dt>Tindakan Keperawatan :</dt>
                                        <dd>{{ $kunjungan->asesmenperawat->tindakan_keperawatan }}</dd>
                                    @endif
                                </dl>
                            @else
                                Belum Asesmen Perawat
                            @endif
                        </div>
                        <div class="col-md-2 border border-dark">
                            @if ($kunjungan->files->count() != 0)
                                <b>Berkas Penunjang</b><br>
                                @foreach ($kunjungan->files as $file)
                                    <button class="btn btn-xs btn-primary m-1" onclick="btnLihatFile(this)"
                                        data-nama="{{ $file->nama }}" data-fileurl="{{ $file->fileurl }}"><i
                                            class="fas fa-file-medical"></i>
                                        {{ $file->nama }}</button>
                                    <br>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-md-3 border border-dark">
                            @if ($kunjungan->asesmendokter)
                                <dl>
                                    <dt>Diagnosa</dt>
                                    <dd>
                                        @if (is_array(json_decode($kunjungan->asesmendokter->diagnosa)) ||
                                                is_object(json_decode($kunjungan->asesmendokter->diagnosa)))
                                            @foreach (json_decode($kunjungan->asesmendokter->diagnosa) as $itemx)
                                                @if ($itemx != 'null')
                                                    - {{ $itemx }} <br>
                                                @endif
                                            @endforeach
                                        @else
                                            {{ $kunjungan->asesmendokter->diagnosa ?? '-' }}
                                        @endif
                                        {{ $kunjungan->asesmendokter->catatan_diagnosa ?? '' }}<br>
                                        <b> Diag. Primer ICD-10 :</b> <br>
                                        {{ $kunjungan->asesmendokter->diagnosa1 ?? '-' }}
                                        <br>
                                        <b>Diag. Sekunder ICD-10 :</b><br>
                                        @if (is_array(json_decode($kunjungan->asesmendokter->diagnosa2)) ||
                                                is_object(json_decode($kunjungan->asesmendokter->diagnosa2)))
                                            @foreach (json_decode($kunjungan->asesmendokter->diagnosa2) as $item)
                                                @if ($item != 'null')
                                                    - {{ $item }} <br>
                                                @endif
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </dd>
                                    <dt>Pemeriksaan Fisik :</dt>
                                    <dd>
                                        <pre>{{ $kunjungan->asesmendokter->pemeriksaan_fisik ?? '-' }}</pre>
                                    </dd>
                                    <dt>Tindakan :</dt>
                                    <dd>
                                        <pre>{{ $kunjungan->asesmendokter->tindakan_medis ?? '-' }}</pre>
                                    </dd>
                                    <dt>Instruksi Medis :</dt>
                                    <dd>
                                        <pre>{{ $kunjungan->asesmendokter->instruksi_medis ?? '-' }}</pre>
                                    </dd>
                                    @if ($kunjungan->asesmendokter->rencana_perawatan)
                                        <dt>Catatan Dokter :</dt>
                                        <dd>
                                            <pre>{{ $kunjungan->asesmendokter->rencana_perawatan ?? '-' }}</pre>
                                        </dd>
                                    @endif

                                </dl>
                            @else
                                Belum Asesmen Dokter
                            @endif
                        </div>
                        <div class="col-md-2  border border-dark">
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
                                @if ($kunjungan->asesmendokter?->resep_obat || $kunjungan->asesmendokter?->catatan_resep)
                                    <dt>Catatan Resep :</dt>
                                    <dd>
                                        <pre>{{ $kunjungan->asesmendokter->resep_obat ?? '-' }}</pre>
                                        <pre>{{ $kunjungan->asesmendokter->catatan_resep ?? '-' }}</pre>
                                    </dd>
                                @endif
                            @else
                                Belum Ada Resep
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="col-md-12  border border-dark">
                        Belum ada riwayat pasien
                    </div>
                @endif
            </div>
        </div>
