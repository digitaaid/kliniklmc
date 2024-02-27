<section>
    <div class="col-md-12" style="font-size: 12px">
        <div class="row">
            @include('form.assesmen_kop')
            {{-- <div class="col-md-2 border border-dark text-center">
                <b>NORM</b>
            </div>
            <div class="col-md-7 border border-dark text-center">
                <b>NAMA</b>
            </div> --}}
            {{-- <div class="col-md-3 border border-dark text-center">
                <b>REGISTRASI</b>
            </div>
            <div class="col-md-2 border border-dark text-center">
            </div>
            <div class="col-md-7 border border-dark text-center">
            </div>
            <div class="col-md-3 border border-dark text-center">
                {{ $pasien->created_at }}
            </div>
            <div class="col-md-12 border border-dark">
                <div class="row">
                    <div class="col-md-4">
                        <dl class="row">
                            <dt class="col-sm-3 m-0">Nama</dt>
                            <dd class="col-sm-9 m-0">{{ $pasien->nama }}</dd>
                            <dt class="col-sm-3 m-0">Tgl Lahir</dt>
                            <dd class="col-sm-9 m-0">{{ $pasien->tgl_lahir }}</dd>
                            <dt class="col-sm-3 m-0">Jns Kelamin</dt>
                            <dd class="col-sm-9 m-0">{{ $pasien->gender }}</dd>
                            <dt class="col-sm-3 m-0">Alamat</dt>
                            <dd class="col-sm-9 m-0">{{ $pasien->alamat }}</dd>

                        </dl>
                    </div>
                    <div class="col-md-4">
                        <dl class="row">
                            <dt class="col-sm-3 m-0">No RM</dt>
                            <dd class="col-sm-9 m-0">{{ $pasien->norm }}</dd>
                            <dt class="col-sm-3 m-0">NIK</dt>
                            <dd class="col-sm-9 m-0">{{ $pasien->nik }}</dd>
                            <dt class="col-sm-3 m-0">No BPJS</dt>
                            <dd class="col-sm-9 m-0">{{ $pasien->nomorkartu }}</dd>
                            <dt class="col-sm-3 m-0">No HP</dt>
                            <dd class="col-sm-9 m-0">{{ $pasien->nohp }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
            </div> --}}
            <div class="col-md-12 border border-dark text-center bg-warning">
                <b class="">ASESMEN RAWAT JALAN</b>
            </div>
            <div class="col-md-12 border border-dark">
                <div class="row">
                    <div class="col-md-4">
                        <dl class="row">
                            <dt class="col-sm-3 m-0">Antrian</dt>
                            <dd class="col-sm-9 m-0">
                                <span class="badge badge-{{ $antrian->status ? 'success' : 'danger' }}"
                                    title="{{ $antrian->status ? 'Sudah' : 'Belum' }} Integrasi">
                                    {{ $antrian->nomorantrean }} / {{ $antrian->kodebooking }}
                                </span>
                            </dd>
                            <dt class="col-sm-3 m-0">Tgl Periksa</dt>
                            <dd class="col-sm-9 m-0">{{ $antrian->tanggalperiksa }}</dd>
                            <dt class="col-sm-3 m-0">RM</dt>
                            <dd class="col-sm-9 m-0">{{ $antrian->norm ? $antrian->norm : 'Belum Didaftarkan' }} </dd>
                            <dt class="col-sm-3 m-0">Nama</dt>
                            <dd class="col-sm-9 m-0">{{ $antrian->nama ? $antrian->nama : 'Belum Didaftarkan' }}
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
                        </dl>
                    </div>
                    <div class="col-md-3">
                        <dl class="row">
                            <dt class="col-sm-3 m-0">Kunjgn</dt>
                            <dd class="col-sm-9 m-0">
                                <span class="badge badge-{{ $antrian->kodekunjungan ? 'success' : 'danger' }}"
                                    title="{{ $antrian->kodekunjungan ? 'Sudah' : 'Belum' }} Integrasi">
                                    {{ $antrian->kodekunjungan ? $antrian->kunjungan->counter . ' / ' . $antrian->kodekunjungan : 'Belum Kunjungan' }}
                                </span>
                            </dd>
                            <dt class="col-sm-3 m-0">Jenis</dt>
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
                            <dt class="col-sm-3 m-0">Status</dt>
                            <dd class="col-sm-9 m-0">
                                @switch($antrian->taskid)
                                    @case(0)
                                        Belum Checkin
                                    @break

                                    @case(1)
                                        Tunggu Pendaftaran
                                    @break

                                    @case(2)
                                        Proses Pendaftaran
                                    @break

                                    @case(3)
                                        Tunggu Poliklinik
                                    @break

                                    @case(4)
                                        Pemeriksaan Dokter
                                    @break

                                    @case(5)
                                        Tunggu Farmasi
                                    @break

                                    @case(6)
                                        Proses Farmasi
                                    @break

                                    @case(7)
                                        Selesai Pelayanan
                                    @break

                                    @case(99)
                                        <span class="badge badge-danger">Batal</span>
                                    @break

                                    @default
                                @endswitch
                            </dd>
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
                        </dl>
                    </div>
                    <div class="col-md-5">
                        <dl class="row">
                            <dt class="col-sm-3 m-0">Pendaftaran</dt>
                            <dd class="col-sm-9 m-0">
                                {{ $antrian->pic1 ? $antrian->pic1->name : 'Belum Didaftarkan' }}
                            </dd>
                            {{-- <dt class="col-sm-3 m-0">Diagnosa SEP</dt>
                            <dd class="col-sm-8 m-09>
                                {{ $antrian->kunjungan->diagnosa_awal ?? '-' }}
                            </dd> --}}
                            <dt class="col-sm-3 m-0">Unit</dt>
                            <dd class="col-sm-9 m-0">
                                {{ $antrian->kunjungan ? $antrian->kunjungan->units->nama : 'Belum Kunjungan' }}
                            </dd>
                            <dt class="col-sm-3 m-0">Perawat</dt>
                            <dd class="col-sm-9 m-0">
                                {{ $antrian->pic2 ? $antrian->pic2->name : 'Belum Asesmen Perawat' }}
                            </dd>
                            <dt class="col-sm-3 m-0">Dokter</dt>
                            <dd class="col-sm-9 m-0">
                                {{ $antrian->kunjungan ? $antrian->kunjungan->dokters->namadokter : 'Belum Kunjungan' }}
                            </dd>
                            <dt class="col-sm-3 m-0">Farmasi</dt>
                            <dd class="col-sm-9 m-0">
                                {{ $antrian->pic4 ? $antrian->pic4->name : 'Belum Ada Resep Obat' }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-md-12 border border-dark text-center bg-warning">
                <b class="">Diisi Oleh Perawat</b>
            </div>
            <div class="col-md-12 border border-dark">
                <b>Anamnesa Pasien</b>
            </div>
            <div class="col-md-12 border border-dark">
                <dl class="row ml-2">
                    <dt class="col-sm-3">Suber Data</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmenperawat->sumber_data ?? '-' }}</dd>
                    <dt class="col-sm-3">Keluhan Utama</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmenperawat->keluhan_utama ?? '-' }}</dd>
                    <dt class="col-sm-3">Riwayat Penyakit Dahulu</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmenperawat->riwayat_penyakit ?? '-' }}</dd>
                    <dt class="col-sm-3">Riwayat Penyakit Keluarga</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmenperawat->riwayat_penyakit_keluarga ?? '-' }}</dd>
                    <dt class="col-sm-3">Riwayat Alergi</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmenperawat->riwayat_alergi ?? '-' }}</dd>
                    <dt class="col-sm-3">Riwayat Pengobatan</dt>
                    <dd class="col-sm-9">{{ $antrian->asesmenperawat->riwayat_pengobatan ?? '-' }}</dd>
                </dl>
            </div>
            <div class="col-md-12 border border-dark">
                <b>Psikologi, Sosial, dan Ekonomi</b>
            </div>
            <div class="col-md-12 border border-dark">
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row ml-2">
                            <dt class="col-sm-4">Status Psikologi</dt>
                            <dd class="col-sm-8">{{ $antrian->asesmenperawat->status_psikologi ?? '-' }}</dd>
                            <dt class="col-sm-4">Tinggal Dengan</dt>
                            <dd class="col-sm-8">{{ $antrian->asesmenperawat->tinggal_dengan ?? '-' }}</dd>
                            <dt class="col-sm-4">Hubungan Keluarga</dt>
                            <dd class="col-sm-8">{{ $antrian->asesmenperawat->hubungan_keluarga ?? '-' }}</dd>
                            <dt class="col-sm-4">Ekonomi</dt>
                            <dd class="col-sm-8">{{ $antrian->asesmenperawat->ekonomi ?? '-' }}</dd>
                            <dt class="col-sm-4">Edukasi Diberikan Kepada</dt>
                            <dd class="col-sm-8">{{ $antrian->asesmenperawat->edukasi ?? '-' }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row ml-2">
                            <dt class="col-sm-4">Pekerjaan</dt>
                            <dd class="col-sm-8">{{ $antrian->asesmenperawat->pekerjaan ?? '-' }}</dd>
                            <dt class="col-sm-4">Agama</dt>
                            <dd class="col-sm-8">{{ $antrian->asesmenperawat->agama ?? '-' }}</dd>
                            <dt class="col-sm-4">Pendidikan</dt>
                            <dd class="col-sm-8">{{ $antrian->asesmenperawat->pendidikan ?? '-' }}</dd>
                            <dt class="col-sm-4">Status Nikah</dt>
                            <dd class="col-sm-8">{{ $antrian->asesmenperawat->status_nikah ?? '-' }}</dd>
                            <dt class="col-sm-4">Bahasa</dt>
                            <dd class="col-sm-8">{{ $antrian->asesmenperawat->bahasa ?? '-' }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-md-6 border border-dark">
                <b>Asesmen Nyeri</b>
            </div>
            <div class="col-md-6 border border-dark">
                <b>Asesmen Resiko Jatuh, dan Fungsional</b>
            </div>
            <div class="col-md-6 border border-dark">
                <img src="{{ asset('skalanyeri.png') }}" width="100%" alt="">
                <dl class="row ml-2">
                    <dt class="col-sm-4">Skala Nyeri</dt>
                    <dd class="col-sm-8">{{ $kunjungan->asesmenperawat->skala_nyeri ?? '-' }}</dd>
                    <dt class="col-sm-4">Keluhan Nyeri</dt>
                    <dd class="col-sm-8">{{ $kunjungan->asesmenperawat->keluhan_nyeri ?? '-' }}</dd>
                </dl>
            </div>
            <div class="col-md-6 border border-dark">
                <dl class="row ml-2">
                    <dt class="col-sm-4">Resiko Jatuh</dt>
                    <dd class="col-sm-8">{{ $kunjungan->asesmenperawat->resiko_jatuh ?? '-' }}</dd>
                    <dt class="col-sm-4">Alat Bantu</dt>
                    <dd class="col-sm-8">{{ $kunjungan->asesmenperawat->alat_bantu ?? '-' }}</dd>
                    <dt class="col-sm-4">Cacat Fisik</dt>
                    <dd class="col-sm-8">{{ $kunjungan->asesmenperawat->cacat_fisik ?? '-' }}</dd>
                </dl>
            </div>
            <div class="col-md-12 border border-dark">
                <b>Skrinning Gizi</b>
            </div>
            <div class="col-md-12 border border-dark">
                <dl class="row ml-2">
                    <dt class="col-sm-9">1. Apakah pasien mengalami penurunan berat badan yang tidak diinginkan dalam 6
                        bulan terakhir ?</dt>
                    <dd class="col-sm-3">{{ $kunjungan->asesmenperawat->penurunan_berat ?? '-' }}</dd>
                    <dt class="col-sm-9">2. Apakah asupan makanan berkurang karena berkurangnya nafsu makan ?</dt>
                    <dd class="col-sm-3">{{ $kunjungan->asesmenperawat->asupan_makan ?? '-' }}</dd>
                    <dt class="col-sm-9">3. Apakah pasien dengan diagnosa khusus : Penyakit
                        DM/Ginjal/Hati/Paru/Stroke/Kanker/Penurunan imun/lainnya ?</dt>
                    <dd class="col-sm-3">{{ $kunjungan->asesmenperawat->apakah_diagnosa_khusus ?? '-' }}</dd>
                </dl>
            </div>
            <div class="col-md-12 border border-dark">
                <b>Tanda Vital Tubuh</b>
            </div>
            <div class="col-md-4 border border-dark">
                <dl class="row ml-2">
                    <dt class="col-sm-4">Denyut Nadi</dt>
                    <dd class="col-sm-8">{{ $kunjungan->asesmenperawat->detak_jantung ?? '-' }} spm</dd>
                    <dt class="col-sm-4">Pernapasan</dt>
                    <dd class="col-sm-8">{{ $kunjungan->asesmenperawat->pernapasan ?? '-' }} spm</dd>
                    <dt class="col-sm-4">Suhu Tubuh</dt>
                    <dd class="col-sm-8">{{ $kunjungan->asesmenperawat->suhu ?? '-' }} celcius</dd>
                    <dt class="col-sm-4">Tekanan Darah</dt>
                    <dd class="col-sm-8">
                        {{ $kunjungan->asesmenperawat->sistole ?? '-' }}/{{ $kunjungan->asesmenperawat->distole ?? '-' }}
                        mmHg</dd>
                </dl>
            </div>
            <div class="col-md-4 border border-dark">
                <dl class="row ml-2">
                    <dt class="col-sm-4">Tinggi Badan</dt>
                    <dd class="col-sm-8">{{ $kunjungan->asesmenperawat->tinggi_badan ?? '-' }} cm</dd>
                    <dt class="col-sm-4">Berat Badan</dt>
                    <dd class="col-sm-8">{{ $kunjungan->asesmenperawat->berat_badan ?? '-' }} kg</dd>
                    <dt class="col-sm-4">Index BSA</dt>
                    <dd class="col-sm-8">{{ $kunjungan->asesmenperawat->bsa ?? '-' }} kg/m2</dd>
                    <dt class="col-sm-4">Kesadaran</dt>
                    <dd class="col-sm-8">{{ $kunjungan->asesmenperawat->kesadaran ?? '-' }}</dd>
                </dl>
            </div>
            <div class="col-md-4 border border-dark">
                <b>Keadaan Tubuh</b><br>
                {{ $kunjungan->asesmenperawat->keadaan_tubuh ?? '-' }}
            </div>
            <div class="col-md-8 border border-dark">
                <dl class="row">
                    <dt class="col-sm-3">Diagnosis Keperwatan</dt>
                    <dd class="col-sm-9">{{ $kunjungan->asesmenperawat->diagnosa_keperawatan ?? '-' }}</dd>
                    <dt class="col-sm-3">Rencana Keperawatan</dt>
                    <dd class="col-sm-9">{{ $kunjungan->asesmenperawat->rencana_keperawatan ?? '-' }}</dd>
                    <dt class="col-sm-3">Tindakan Keperawatan</dt>
                    <dd class="col-sm-9">{{ $kunjungan->asesmenperawat->tindakan_keperawatan ?? '-' }}</dd>
                    <dt class="col-sm-3">Evaluasi Keperwatan</dt>
                    <dd class="col-sm-9">{{ $kunjungan->asesmenperawat->evaluasi_keperawatan ?? '-' }}</dd>
                </dl>
            </div>
            <div class="col-md-4 border text-center border-dark">
                <b>Perawat,</b> <br>
                {!! QrCode::size(50)->generate('Telah diisi dan dikonfirmasi ' . $antrian->asesmenperawat->waktu) !!} <br>
                <b><u>
                        {{ $antrian->pic2 ? $antrian->pic2->name : 'Belum Asesmen Perawat' }}
                    </u></b>
                <br>
                Waktu : {{ $antrian->asesmenperawat->waktu }}
            </div>
            <div class="col-md-12 border border-dark text-center bg-warning">
                <b class="">Diisi Oleh Dokter</b>
            </div>
            <div class="col-md-6 border border-dark">
                <b>Pemeriksaan Fisik</b><br>
                {{ $antrian->asesmendokter->pemeriksaan_fisik ?? '-' }}
            </div>
            <div class="col-md-6 border border-dark">
                <dl class="row ml-2">
                    <dt class="col-sm-4">Diagnosa</dt>
                    <dd class="col-sm-8">
                        @if (is_array(json_decode($kunjungan->asesmendokter->diagnosa)) ||
                                is_object(json_decode($kunjungan->asesmendokter->diagnosa)))
                            @foreach (json_decode($kunjungan->asesmendokter->diagnosa) as $itemx)
                                @if ($itemx != 'null')
                                    - {{ $itemx }} <br>
                                @endif
                            @endforeach
                        @endif
                        {{ $kunjungan->asesmendokter->catatan_diagnosa ?? null }}
                    </dd>
                    <dt class="col-sm-4">ICD-10 Primer</dt>
                    <dd class="col-sm-8">{{ $kunjungan->asesmendokter->diagnosa1 ?? '-' }}</dd>
                    <dt class="col-sm-4">ICD-10 Sekunder</dt>
                    <dd class="col-sm-8">
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
                </dl>
            </div>
            <div class="col-md-8 border border-dark">
                <dl class="row">
                    <dt class="col-sm-3">Instruksi Dokter</dt>
                    <dd class="col-sm-9">{{ $kunjungan->asesmendokter->instruksi_medis ?? '-' }}</dd>
                    <dt class="col-sm-3">Tindakan Dokter</dt>
                    <dd class="col-sm-9">{{ $kunjungan->asesmendokter->tindakan_medis ?? '-' }}</dd>
                    <dt class="col-sm-3">Catatan Dokter</dt>
                    <dd class="col-sm-9">{{ $kunjungan->asesmendokter->rencana_perawatan ?? '-' }}</dd>
                </dl>
            </div>
            <div class="col-md-4 border text-center border-dark">
                <b>Dokter,</b> <br>
                {!! QrCode::size(50)->generate('Telah diisi dan dikonfirmasi ' . $antrian->asesmendokter->waktu) !!} <br>
                <b><u>
                        {{ $antrian->kunjungan ? $antrian->kunjungan->dokters->namadokter : 'Dokter' }}
                    </u></b> <br>
                Waktu : {{ $antrian->asesmendokter->waktu }}
            </div>
            <div class="col-md-8 border border-dark">
                <dl>
                    <dt>Resep Obat :</dt>
                    @if ($antrian->resepobat)
                        Kode Resep : {{ $antrian->resepobat->kode }} <br>
                        Waktu : {{ $antrian->resepobat->waktu }} <br>
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
                    <dd>
                        <pre id="resepobat">{{ $antrian->asesmendokter->resep_obat ?? '-' }}</pre>
                    </dd>
                    <dt>Catatan Resep :</dt>
                    <dd>
                        <pre>{{ $antrian->asesmendokter->catatan_resep ?? '-' }}</pre>
                    </dd>
                </dl>
            </div>
            <div class="col-md-4 border text-center border-dark">
                <b>Farmasi,</b> <br>
                {!! QrCode::size(50)->generate('Telah diisi dan dikonfirmasi ' . $antrian->asesmenperawat->waktu) !!} <br>
                <b><u>
                        {{ $antrian->pic4 ? $antrian->pic4->name : 'Farmasi' }}
                    </u></b> <br>
                Waktu : {{ $antrian->asesmenperawat->waktu }}
            </div>
        </div>
    </div>
</section>
