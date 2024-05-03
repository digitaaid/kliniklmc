<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collSK">
        <h3 class="card-title">
            Surat Kontrol Kunjungan Berikutnya
        </h3>
        <div class="card-tools">
            <button type="button" onclick="modalSuratKontrolBerikutnya()" class="btn btn-tool bg-warning">
                <i class="fas fa-edit"></i> Buat Surat Kontrol
            </button>
            @if ($antrian->suratkontrols->count())
                <button type="button" class="btn btn-tool bg-success">
                    <i class="fas fa-check"></i> Sudah Dibuatkan
                </button>
            @else
                <button type="button" class="btn btn-tool bg-danger">
                    <i class="fas fa-times"></i> Belum Dibuatkan
                </button>
            @endif
        </div>
    </a>
    <div id="collSK" class="collapse" role="tabpanel" aria-labelledby="headSK">
        <div class="card-body">
            @if ($antrian->suratkontrols->count())
                @foreach ($antrian->suratkontrols as $item)
                    <x-adminlte-alert theme="success" title="Surat Kontrol untuk Pasien BPJS">
                        <b>Nomor Surat Kontrol</b> : {{ $item->noSuratKontrol }} <br>
                        <b>Tgl Rencana Kontrol</b> : {{ $item->tglRencanaKontrol }} <br>
                        <a class="btn btn-xs btn-warning text-dark " target="_blank"
                            href="{{ route('suratkontrol_print') }}?noSuratKontrol={{ $item->noSuratKontrol }}"
                            style="text-decoration: none">
                            <i class="fas fa-print"></i> Print Surat Kontrol
                        </a>
                    </x-adminlte-alert>
                @endforeach
                <div id="loaderSuratKontrol" class="loader">
                    <h4>Loading...</h4>
                </div>
                <iframe src="" id="iframeSuratKontrol" onload="iframeSuratKontrol()" width="100%"
                    height="500px" frameborder="0"></iframe>
            @else
                <x-adminlte-alert theme="danger" title="Surat Kontrol untuk Pasien BPJS">
                    Belum ada surat kontrol.
                </x-adminlte-alert>
            @endif
            {{-- <form action="{{ route('suratkontrol.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-input name="nomorkartu" class="nomorkartu-id" igroup-size="sm" label="Nomor Kartu"
                            placeholder="Nomor Kartu" value="{{ $antrian->nomorkartu }}" readonly />
                        <x-adminlte-input name="norm" class="norm-id" label="No RM" igroup-size="sm"
                            placeholder="No RM " value="{{ $antrian->norm }}" readonly />
                        <x-adminlte-input name="nama" class="nama-id" label="Nama Pasien" igroup-size="sm"
                            placeholder="Nama Pasien" value="{{ $antrian->nama }}" readonly />
                        <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP" igroup-size="sm"
                            placeholder="Nomor HP" value="{{ $antrian->nohp }}" readonly />
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="noSEP" class="noSEP-id" igroup-size="sm" label="Nomor SEP"
                            placeholder="Nomor SEP">
                            <x-slot name="appendSlot">
                                <div class="btn btn-primary" onclick="cariSEP()">
                                    <i class="fas fa-search"></i> Cari SEP
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        @php
                            $config = ['format' => 'YYYY-MM-DD'];
                        @endphp
                        <x-adminlte-input-date name="tglRencanaKontrol" class="tglRencanaKontrol-id" igroup-size="sm"
                            label="Tanggal Rencana Kontrol" value="{{ $request->tglRencanaKontrol }}"
                            placeholder="Pilih Tanggal Rencana Kontrol" :config="$config">

                        </x-adminlte-input-date>
                        <x-adminlte-select igroup-size="sm" name="poliKontrol" class="poliKontrol-id"
                            label="Poliklinik">
                            <option selected disabled>Silahkan Klik Cari Poliklinik</option>
                            <x-slot name="appendSlot">
                                <div class="btn btn-primary" onclick="cariPoli()">
                                    <i class="fas fa-search"></i> Cari Poli
                                </div>
                            </x-slot>

                        </x-adminlte-select>
                        <x-adminlte-select igroup-size="sm" name="kodeDokter" class="kodeDokter-id" label="Dokter">
                            <option selected disabled>Silahkan Klik Cari Dokter</option>
                            <x-slot name="appendSlot">
                                <div class="btn btn-primary" onclick="cariDokter()">
                                    <i class="fas fa-search"></i> Cari Dokter
                                </div>
                            </x-slot>
                        </x-adminlte-select>
                        <x-adminlte-textarea igroup-size="sm" label="Catatan" name="catatan"
                            placeholder="Catatan Pasien" />
                    </div>
                </div>
                <button type="submit" class="btn btn-warning withLoad"> <i class="fas fa-save"></i>
                    Buat
                    Surat Kontrol</button>
            </form> --}}
        </div>
    </div>
</div>
@push('js')
    <script>
        $(function() {
            var countsurat = "{{ $antrian->suratkontrols->count() }}";
            if ("{{ $antrian->suratkontrols->count() }}" != '0') {
                var nosuratkontrol = "{{ $antrian->suratkontrols->first()->noSuratKontrol ?? null }}";
                var url =
                    "{{ route('suratkontrol_print') }}?noSuratKontrol=" + nosuratkontrol;
                $('#iframeSuratKontrol').attr('src', url);
                $('#loaderSuratKontrol').show();
                $('#iframeSuratKontrol').hide();
            }
        });

        function iframeSuratKontrol() {
            $('#loaderSuratKontrol').hide();
            $('#iframeSuratKontrol').show();
        }
    </script>
@endpush
