    <div class="row">
        <div class="col-md-4">
            <dl class="row">
                <dt class="col-sm-3 m-0">RM</dt>
                <dd class="col-sm-9 m-0">{{ $antrian->norm }} </dd>
                <dt class="col-sm-3 m-0">Nama</dt>
                <dd class="col-sm-9 m-0">{{ $antrian->nama }} ({{ $antrian->kunjungan->gender ?? '-' }})</dd>
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
            </dl>
        </div>
        <div class="col-md-4">
            <dl class="row">
                <dt class="col-sm-4 m-0">Tgl Periksa</dt>
                <dd class="col-sm-8 m-0">{{ $antrian->tanggalperiksa }}</dd>
                <dt class="col-sm-4 m-0">Antrian</dt>
                <dd class="col-sm-8 m-0">
                    {{ $antrian->nomorantrean }} ({{ $antrian->kodebooking }})
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
                            -
                    @endswitch
                </dd>
                <dt class="col-sm-4 m-0">Kunjungan</dt>
                <dd class="col-sm-8 m-0">
                    @if ($antrian->kodekunjungan)
                        {{ $antrian->kodekunjungan }} <span class="badge badge-success">Terintegrasi </span>
                    @else
                        - <span class="badge badge-danger">Belum Integrasi </span>
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
                        -
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
