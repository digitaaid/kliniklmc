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
                    <dd class="col-sm-9 m-0">{{ $pasien->nama }} ({{ $pasien->gender ?? '-' }})</dd>
                    <dt class="col-sm-3 m-0">RM</dt>
                    <dd class="col-sm-9 m-0">{{ $pasien->norm }} </dd>
                    <dt class="col-sm-3 m-0">BPJS</dt>
                    <dd class="col-sm-9 m-0">{{ $pasien->nomorkartu }} </dd>
                    <dt class="col-sm-3 m-0">NIK</dt>
                    <dd class="col-sm-9 m-0">{{ $pasien->nik }} </dd>
                    <dt class="col-sm-3 m-0"> Tgl Lahir</dt>
                    <dd class="col-sm-9 m-0">
                        @if ($pasien->tgl_lahir)
                            {{ $pasien->tgl_lahir }}
                            ({{ now()->diffInYears($pasien->tgl_lahir) }}
                            tahun)
                        @else
                            -
                        @endif
                    </dd>
                    <dt class="col-sm-3 m-0">HP</dt>
                    <dd class="col-sm-9 m-0">{{ $pasien->nohp }}</dd>
                </dl>
            </div>
            @foreach ($pasien->kunjungans as $kunjungan)
                {{ $kunjungan->kode }} <br>
            @endforeach
        </div>
    </div>
</div>
