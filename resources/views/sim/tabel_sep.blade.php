<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collSEP">
        <h3 class="card-title">SEP</h3>
        <div class="card-tools">
            @if ($antrian->sep)
                Sudah Tercetak No SEP {{ $antrian->sep }} <i class="fas fa-check-circle"></i>
            @else
                Belum Cetak SEP <i class="fas fa-times-circle"></i>
            @endif
        </div>
    </a>

    <div id="collSEP" class="collapse" role="tabpanel" aria-labelledby="headSEP">
        <div class="card-body">
            <x-adminlte-alert theme="{{ $antrian->sep ? 'success' : 'danger' }}"
                title="Silahkan buat SEP jika pasien BPJS">
                <b>Nomor SEP</b> : {{ $antrian->sep ?? 'Belum Dibuatkan' }} <br>
                @if ($antrian->sep)
                    <a class="btn btn-xs btn-warning text-dark" target="_blank"
                        href="{{ route('sep_print') }}?noSep={{ $antrian->sep }}" style="text-decoration: none">
                        <i class="fas fa-print"></i> Print SEP
                    </a>
                @endif
            </x-adminlte-alert>
            <form action="{{ route('sep.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-input name="noKartu" class="nomorkartu-id" igroup-size="sm" label="Nomor Kartu"
                            placeholder="Nomor Kartu" value="{{ $antrian->nomorkartu }}" readonly />
                        <x-adminlte-input name="noMR" class="norm-id" label="No RM" igroup-size="sm"
                            placeholder="No RM" value="{{ $antrian->norm }}" readonly />
                        <x-adminlte-input name="nama" class="nama-id" label="Nama Pasien" igroup-size="sm"
                            placeholder="Nama Pasien" value="{{ $antrian->nama }}" readonly />
                        <x-adminlte-input name="noTelp" class="nohp-id" label="Nomor HP" igroup-size="sm"
                            placeholder="Nomor HP" value="{{ $antrian->nohp }}" readonly />
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <x-adminlte-select igroup-size="sm" name="asalRujukan" label="Jenis Rujukan">
                                    <option value="1">Rujukan FKTP</option>
                                    <option value="2">Rujukan Antar RS</option>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-8">
                                <x-adminlte-input name="noRujukan" class="noRujukan-id" igroup-size="sm"
                                    label="Nomor Rujukan" placeholder="Nomor Rujukan" readonly>
                                    <x-slot name="appendSlot">
                                        <div class="btn btn-primary btnCariRujukan">
                                            <i class="fas fa-search"></i> Cari
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </div>
                        </div>
                        <x-adminlte-input name="noSurat" class="noSurat-id" igroup-size="sm" label="Nomor Surat Kontrol"
                            placeholder="Nomor Surat Kontrol" readonly>
                            <x-slot name="appendSlot">
                                <div class="btn btn-primary btnCariSuratKontrol">
                                    <i class="fas fa-search"></i> Cari
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <input type="hidden" name="tglRujukan" id="tglrujukan" value="">
                        <input type="hidden" name="ppkRujukan" id="ppkrujukan" value="">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-select igroup-size="sm" name="klsRawatHak" label="Jenis Pelayanan">
                            <option disabled>Pilih Kelas Pasien</option>
                            <option value="1">Kelas 1</option>
                            <option value="2">Kelas 2</option>
                            <option value="3">Kelas 3</option>
                        </x-adminlte-select>
                        <x-adminlte-select igroup-size="sm" name="jnsPelayanan" label="Jenis Pelayanan">
                            <option disabled>Pilih Jenis Pelayanan</option>
                            <option value="2" selected>Rawat Jalan</option>
                            <option value="1">Rawat Inap</option>
                        </x-adminlte-select>
                        <x-adminlte-select2 igroup-size="sm" name="tujuan" label="Poliklinik" required>
                            <option selected disabled>Pilih Poliklinik</option>
                            @foreach ($polikliniks as $key => $item)
                                <option value="{{ $key }}">{{ $item }}
                                </option>
                            @endforeach
                        </x-adminlte-select2>
                        <x-adminlte-select2 igroup-size="sm" name="dpjpLayan" label="Dokter DPJP" required>
                            <option selected disabled>Pilih Dokter DPJP</option>
                            @foreach ($dokters as $key => $item)
                                <option value="{{ $key }}">{{ $item }}
                                </option>
                            @endforeach
                        </x-adminlte-select2>

                    </div>
                    <div class="col-md-6">
                        <x-adminlte-select igroup-size="sm" name="tujuanKunj" label="Tujuan Kunjungan">
                            <option value="0">Normal</option>
                            <option value="1">Prosedur</option>
                            <option value="2">Konsul Dokter</option>
                        </x-adminlte-select>
                        <x-adminlte-select igroup-size="sm" name="flagProcedure" label="Flag Procedur">
                            <option value="">Normal</option>
                            <option value="0">Prosedur Tidak Berkelanjutan</option>
                            <option value="1">Prosedur dan Terapi Berkelanjutan</option>
                        </x-adminlte-select>
                        <x-adminlte-select igroup-size="sm" name="kdPenunjang" label="Penunjang">
                            <option value="">Normal</option>
                            <option value="1">Radioterapi</option>
                            <option value="2">Kemoterapi</option>
                            <option value="3">Rehabilitasi Medik</option>
                            <option value="4">Rehabilitasi Psikososial</option>
                            <option value="5">Transfusi Darah</option>
                            <option value="6">Pelayanan Gigi</option>
                            <option value="7">Laboratorium</option>
                            <option value="8">USG</option>
                            <option value="9">Lain-Lain</option>
                            <option value="10">Farmasi</option>
                            <option value="11">MRI</option>
                            <option value="12">HEMODIALISA</option>
                        </x-adminlte-select>
                        <x-adminlte-select igroup-size="sm" name="assesmentPel" label="Assesment Pelayanan">
                            <option value="">Normal</option>
                            <option value="0">Poli tujuan beda dengan poli rujukan dan
                                hari beda
                            </option>
                            <option value="1">Poli spesialis tidak tersedia pada hari
                                sebelumnya
                            </option>
                            <option value="2">Jam Poli telah berakhir pada hari sebelumnya
                            </option>
                            <option value="3">Dokter Spesialis yang dimaksud tidak praktek
                                pada
                                hari
                                sebelumnya</option>
                            <option value="4">Atas Instruksi RS</option>
                            <option value="5">Tujuan Kontrol</option>
                        </x-adminlte-select>
                    </div>
                </div>
                <hr>
                <div class="col-md-12">
                    <x-adminlte-select2 igroup-size="sm" name="diagAwal" label="Diagnosa Awal" class="diagnosaid1">
                    </x-adminlte-select2>
                    <x-adminlte-textarea igroup-size="sm" label="Catatan / Keluhan" name="catatan"
                        placeholder="Catatan Pasien" />
                    <button type="submit" class="btn btn-warning withLoad">
                        <i class="fas fa-file-medical"></i> Buat SEP
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
