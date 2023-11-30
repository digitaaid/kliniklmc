<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collAntrian">
        <h3 class="card-title">
            Antrian
        </h3>
        <div class="card-tools">
            @if ($antrian->status)
                Sudah Terintegrasi <i class="fas fa-check-circle"></i>
            @else
                Belum Terintegrasi <i class="fas fa-times-circle"></i>
            @endif
        </div>
    </a>
    <div id="collAntrian" class="collapse">
        <div class="card-body">
            <form action="{{ route('editantrian') }}" method="POST">
                @csrf
                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-input name="nomorkartu" class="nomorkartu-id" igroup-size="sm" label="Nomor Kartu"
                            value="{{ $antrian->nomorkartu }}" placeholder="Nomor Kartu">
                            <x-slot name="appendSlot">
                                <div class="btn btn-primary btnCariKartu">
                                    <i class="fas fa-search"></i> Cari
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="nik" class="nik-id" igroup-size="sm" label="NIK"
                            placeholder="NIK" value="{{ $antrian->nik }}">
                            <x-slot name="appendSlot">
                                <div class="btn btn-primary btnCariNIK">
                                    <i class="fas fa-search"></i> Cari
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="norm" class="norm-id" label="No RM" igroup-size="sm"
                            placeholder="No RM" value="{{ $antrian->norm }}" />
                        <x-adminlte-input name="nama" class="nama-id" label="Nama Pasien" igroup-size="sm"
                            placeholder="Nama Pasien" value="{{ $antrian->nama }}" />
                        <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP" igroup-size="sm"
                            placeholder="Nomor HP" value="{{ $antrian->nohp }}" />
                    </div>
                    <div class="col-md-6">
                        @php
                            $config = ['format' => 'YYYY-MM-DD'];
                        @endphp
                        <x-adminlte-input-date name="tanggalperiksa" class="tanggalperiksa-id" igroup-size="sm"
                            label="Tanggal Periksa" value="{{ $antrian->tanggalperiksa }}" placeholder="Tanggal Periksa"
                            :config="$config">
                        </x-adminlte-input-date>
                        <x-adminlte-select igroup-size="sm" name="jenispasien" label="Jenis Pasien">
                            <option selected disabled>Pilih Jenis Pasien</option>
                            <option value="JKN" {{ $antrian->jenispasien == 'JKN' ? 'selected' : null }}>JKN
                            </option>
                            <option value="NON-JKN" {{ $antrian->jenispasien == 'NON-JKN' ? 'selected' : null }}>
                                NON-JKN
                            </option>
                        </x-adminlte-select>
                        <x-adminlte-select igroup-size="sm" name="kodepoli" label="Poliklinik">
                            @foreach ($polikliniks as $key => $value)
                                <option value="{{ $key }}">
                                    {{ $value }}</option>
                            @endforeach
                        </x-adminlte-select>
                        <x-adminlte-select igroup-size="sm" name="kodedokter" label="Dokter">
                            @foreach ($dokters as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </x-adminlte-select>
                        <div class="row">
                            <div class="col-md-4">
                                <x-adminlte-select igroup-size="sm" name="asalRujukan" label="Jenis Rujukan">
                                    <option selected disabled>Pilih Jenis Rujukan</option>
                                    <option value="1" {{ $antrian->jeniskunjungan == '1' ? 'selected' : null }}>
                                        Rujukan
                                        FKTP</option>
                                    <option value="2" {{ $antrian->jeniskunjungan == '4' ? 'selected' : null }}>
                                        Rujukan
                                        Antar RS</option>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-8">
                                <x-adminlte-input name="noRujukan" class="noRujukan-id" igroup-size="sm"
                                    label="Nomor Rujukan" placeholder="Nomor Rujukan" readonly
                                    value="{{ $antrian->nomorrujukan }}">
                                    <x-slot name="appendSlot">
                                        <div class="btn btn-primary btnCariRujukan">
                                            <i class="fas fa-search"></i> Cari
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </div>
                        </div>
                        <x-adminlte-input name="noSurat" class="noSurat-id" igroup-size="sm" label="Nomor Surat Kontrol"
                            placeholder="Nomor Surat Kontrol" value="{{ $antrian->nomorsuratkontrol }}" readonly>
                            <x-slot name="appendSlot">
                                <div class="btn btn-primary btnCariSuratKontrol">
                                    <i class="fas fa-search"></i> Cari
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                </div>
                <button type="submit" class="btn btn-success withLoad">
                    <i class="fas fa-edit"></i> Integrasi Antrian
                </button>
            </form>
        </div>
    </div>
</div>
