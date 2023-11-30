<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collSK">
        <h3 class="card-title">
            Surat Kontrol
        </h3>
    </a>
    <div id="collSK" class="collapse" role="tabpanel" aria-labelledby="headSK">
        <div class="card-body">
            <x-adminlte-alert theme="{{ $antrian->suratkontrols->count() ? 'success' : 'warning' }}"
                title="Surat Kontrol untuk Pasien BPJS">
                @if ($antrian->suratkontrols->count())
                    @foreach ($antrian->suratkontrols as $item)
                        <b>Nomor Surat Kontrol</b> : {{ $item->noSuratKontrol }} <br>
                        <b>Tgl Rencana Kontrol</b> : {{ $item->tglRencanaKontrol }} <br>
                        <a class="btn btn-xs btn-warning text-dark " target="_blank"
                            href="{{ route('suratkontrol_print') }}?noSuratKontrol={{ $item->noSuratKontrol }}"
                            style="text-decoration: none">
                            <i class="fas fa-print"></i> Print Surat Kontrol
                        </a>
                    @endforeach
                @else
                    Belum ada surat kontrol.
                @endif
            </x-adminlte-alert>
            <form action="{{ route('suratkontrol.store') }}" method="POST">
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
                                <div class="btn btn-primary btnCariSEP">
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
                            <x-slot name="appendSlot">
                                <div class="btn btn-primary btnCariPoli">
                                    <i class="fas fa-search"></i> Cari Poli
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                        <x-adminlte-select igroup-size="sm" name="poliKontrol" class="poliKontrol-id"
                            label="Poliklinik">
                            <option selected disabled>Silahkan Klik Cari Poliklinik</option>
                            <x-slot name="appendSlot">
                                <div class="btn btn-primary btnCariDokter">
                                    <i class="fas fa-search"></i> Cari Dokter
                                </div>
                            </x-slot>
                        </x-adminlte-select>
                        <x-adminlte-select igroup-size="sm" name="kodeDokter" class="kodeDokter-id" label="Dokter">
                            <option selected disabled>Silahkan Klik Cari Dokter</option>
                        </x-adminlte-select>
                        <x-adminlte-textarea igroup-size="sm" label="Catatan" name="catatan"
                            placeholder="Catatan Pasien" />
                    </div>
                </div>
                <button type="submit" class="btn btn-warning withLoad"> <i class="fas fa-save"></i>
                    Buat
                    Surat Kontrol</button>
            </form>
        </div>
    </div>
</div>
