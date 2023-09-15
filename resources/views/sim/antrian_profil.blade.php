<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <h6 class="text-center">
            {{ $antrian->nama }}
        </h6>
        <p class="text-muted text-center">
            {{ $antrian->norm }}
        </p>
        <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <dl>
                    <dt>Nomor Kartu</dt>
                    <dd>
                        {{ $antrian->nomorkartu }}
                    </dd>
                    <dt>NIK</dt>
                    <dd>
                        {{ $antrian->nik }}
                    </dd>
                    <dt>No HP</dt>
                    <dd>
                        {{ $antrian->nohp }}
                    </dd>
                </dl>
            </li>
            <li class="list-group-item">
                <dl>
                    <dt>Kodebooking</dt>
                    <dd>
                        {{ $antrian->kodebooking }} / {{ $antrian->method }}
                    </dd>
                    <dt>Nomor / Angka Antrian</dt>
                    <dd>
                        {{ $antrian->nomorantrean }} / {{ $antrian->angkaantrean }}
                    </dd>
                    <dt>Status</dt>
                    <dd>
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
                                Batal
                            @break

                            @default
                        @endswitch
                    </dd>

                </dl>
            </li>
            <li class="list-group-item">
                <dl>
                    <dt>Jenis Pasien</dt>
                    <dd>
                        {{ $antrian->jenispasien }}
                    </dd>
                    <dt>Jenis Kunjungan</dt>
                    <dd>
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
                    <dt>Nomor Referensi</dt>
                    <dd>{{ $antrian->nomorreferensi ?? 'Belum ada nomor referensi' }}</dd>
                    <dt>SEP</dt>
                    <dd>
                        @if ($antrian->sep)
                            {{ $antrian->sep }} <br>
                            <a class="btn btn-xs btn-success" target="_blank"
                                href="{{ route('sep_print') }}?noSep={{ $antrian->sep }}"
                                style="text-decoration: none">
                                <i class="fas fa-print"></i> Print SEP
                            </a>
                        @else
                            Belum ada SEP
                        @endif
                    </dd>
                    <dt>Surat Kontrol</dt>
                    <dd>
                        @if ($antrian->suratkontrols)
                            @foreach ($antrian->suratkontrols as $item)
                                {{ $item->noSuratKontrol }}
                                ({{ $item->tglRencanaKontrol }})
                                <br>
                                <a class="btn btn-xs btn-success" target="_blank"
                                    href="{{ route('suratkontrol_print') }}?noSuratKontrol={{ $item->noSuratKontrol }}"
                                    style="text-decoration: none">
                                    <i class="fas fa-print"></i> Print Surat Kontrol
                                </a>
                                <br>
                            @endforeach
                        @else
                            Belum ada Surat Kontrol
                        @endif
                    </dd>
                </dl>
            </li>
            <li class="list-group-item">
                <dl>
                    <dt>Poliklinik</dt>
                    <dd>
                        {{ $antrian->namapoli }}
                    </dd>
                    <dt>Dokter</dt>
                    <dd>
                        {{ $antrian->namadokter }}
                    </dd>
                </dl>
            </li>
        </ul>
    </div>
</div>
