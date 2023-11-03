<div class="card card-primary card-outline">
    <div class="card-body box-profile  p-3">
        <h6 class="text-center">
            IDENTITAS PASIEN
            {{-- {{ $antrian->nama }} --}}
        </h6>
        <div class="row">
            <div class="col-md-4">
                <dl class="row">
                    <dt class="col-sm-3 m-0">Nama</dt>
                    <dd class="col-sm-9 m-0">{{ $antrian->nama }} ({{ $antrian->kunjungan->gender ?? '-' }})</dd>
                    <dt class="col-sm-3 m-0">RM</dt>
                    <dd class="col-sm-9 m-0">{{ $antrian->norm }} </dd>
                    <dt class="col-sm-3 m-0">BPJS</dt>
                    <dd class="col-sm-9 m-0">{{ $antrian->nomorkartu }} </dd>
                    <dt class="col-sm-3 m-0">NIK</dt>
                    <dd class="col-sm-9 m-0">{{ $antrian->nik }} </dd>
                    <dt class="col-sm-3 m-0"> Tgl Lahir</dt>
                    <dd class="col-sm-9 m-0">
                        @if ($antrian->kunjungan)
                            {{ $antrian->kunjungan->tgl_lahir ?? '-' }}
                            ({{ \Carbon\Carbon::parse($antrian->kunjungan->tgl_masuk)->diffInYears($antrian->kunjungan->tgl_lahir) }}
                            tahun)
                        @else
                            -
                        @endif
                    </dd>
                    <dt class="col-sm-3 m-0">HP</dt>
                    <dd class="col-sm-9 m-0">{{ $antrian->nohp }}</dd>
                </dl>
            </div>
            <div class="col-md-4">
                <dl class="row">
                    <dt class="col-sm-4 m-0">Tgl Periksa</dt>
                    <dd class="col-sm-8 m-0">{{ $antrian->tanggalperiksa }}</dd>
                    <dt class="col-sm-4 m-0">Antrian</dt>
                    <dd class="col-sm-8 m-0">
                        {{ $antrian->nomorantrean }} ({{ $antrian->kodebooking }})
                        @if ($antrian->status)
                            <span class="badge badge-success">Sudah Bridging</span>
                        @else
                            <span class="badge badge-danger">Belum Bridging</span>
                        @endif
                    </dd>
                    <dt class="col-sm-4 m-0">Jns Kunjungan</dt>
                    <dd class="col-sm-8 m-0">
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
                                Belum Pilih Jenis Kunjungan
                        @endswitch
                    </dd>
                    <dt class="col-sm-4 m-0">Kunjungan</dt>
                    <dd class="col-sm-8 m-0">
                        @if ($antrian->kunjungan)
                            {{ $antrian->kodekunjungan }} <span class="badge badge-success">Terintegrasi </span>
                        @else
                            <span class="badge badge-danger">Belum Integrasi </span>
                        @endif
                    </dd>
                </dl>
            </div>
            <div class="col-md-4">
                <dl class="row">
                    <dt class="col-sm-4 m-0">No Referensi</dt>
                    <dd class="col-sm-8 m-0">
                        {{ $antrian->nomorreferensi ?? '-' }}
                    </dd>
                    <dt class="col-sm-4 m-0">SEP</dt>
                    <dd class="col-sm-8 m-0">
                        @if ($antrian->sep)
                            {{ $antrian->sep }}
                        @else
                            Belum ada SEP
                        @endif
                    </dd>
                    <dt class="col-sm-4 m-0">Srt Kontrol</dt>
                    <dd class="col-sm-8 m-0">
                        @if ($antrian->suratkontrols->count() != 0)
                            @foreach ($antrian->suratkontrols as $item)
                                {{ $item->noSuratKontrol }}
                                ({{ $item->tglRencanaKontrol }})
                                <br>
                            @endforeach
                        @else
                            Belum ada Surat Kontrol
                        @endif
                    </dd>
                    <dt class="col-sm-4 m-0">Diagnosa</dt>
                    <dd class="col-sm-8 m-0">
                        {{ $antrian->kunjungan->diagnosa_awal ?? '-' }}
                    </dd>
                    <dt class="col-sm-4 m-0">Status</dt>
                    <dd class="col-sm-8 m-0">
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
                </dl>
            </div>
        </div>
    </div>
</div>
