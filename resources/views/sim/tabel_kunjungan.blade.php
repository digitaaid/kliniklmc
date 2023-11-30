<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collKunj">
        <h3 class="card-title">
            Kunjungan
        </h3>
        <div class="card-tools">
            @if ($antrian->kunjungan_id)
                Sudah Terintegrasi <i class="fas fa-check-circle"></i>
            @else
                Belum Terintegrasi <i class="fas fa-times-circle"></i>
            @endif
        </div>
    </a>
    <div id="collKunj" class="collapse">
        <div class="card-body">
            <form action="{{ route('editkunjungan') }}" method="POST">
                @csrf
                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <x-adminlte-input fgroup-class="col-md-6" name="kodekunjungan"
                                label="Kode Kunjungan" igroup-size="sm"
                                placeholder="Kode Kunjungan" readonly
                                value="{{ $antrian->kunjungan->kode ?? null }}" />
                            <x-adminlte-input fgroup-class="col-md-6" name="counter"
                                label="Counter Kunjungan" igroup-size="sm"
                                placeholder="Counter Kunjungan"
                                value="{{ $antrian->kunjungan->counter ?? null }}" readonly />
                            @php
                                $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                            @endphp
                            <x-adminlte-input-date fgroup-class="col-md-6" name="tgl_masuk"
                                igroup-size="sm" label="Tanggal Masuk"
                                placeholder="Tanggal Masuk" :config="$config"
                                value="{{ $antrian->kunjungan->tgl_masuk ?? null }}">
                            </x-adminlte-input-date>
                            {{-- <x-adminlte-input-date fgroup-class="col-md-6" name="tgl_pulang"
                            igroup-size="sm" label="Tanggal Pulang" placeholder="Tanggal Pulang"
                            :config="$config">
                        </x-adminlte-input-date> --}}
                            <x-adminlte-select igroup-size="sm" fgroup-class="col-md-6"
                                name="jaminan" label="Jaminan Pasien">
                                <option selected disabled>Pilih Jaminan</option>
                                @foreach ($jaminans as $key => $item)
                                    <option value="{{ $key }}"
                                        {{ $antrian->kunjungan ? ($antrian->kunjungan->jaminan == $key ? 'selected' : null) : null }}>
                                        {{ $item }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>
                        <hr>
                        <div class="row">
                            <x-adminlte-input name="nomorkartu" class="nomorkartu-id"
                                fgroup-class="col-md-6" igroup-size="sm" label="Nomor Kartu"
                                value="{{ $antrian->nomorkartu }}" placeholder="Nomor Kartu">
                                <x-slot name="appendSlot">
                                    <div class="btn btn-primary btnCariKartu">
                                        <i class="fas fa-search"></i> Cari
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <x-adminlte-input name="nik" class="nik-id"
                                fgroup-class="col-md-6" igroup-size="sm" label="NIK"
                                placeholder="NIK" value="{{ $antrian->nik }}">
                                <x-slot name="appendSlot">
                                    <div class="btn btn-primary btnCariNIK">
                                        <i class="fas fa-search"></i> Cari
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            <x-adminlte-input name="norm" class="norm-id" label="No RM"
                                fgroup-class="col-md-6" igroup-size="sm" placeholder="No RM"
                                value="{{ $antrian->norm }}" />
                            <x-adminlte-input name="nama" class="nama-id" label="Nama Pasien"
                                fgroup-class="col-md-6" igroup-size="sm"
                                placeholder="Nama Pasien" value="{{ $antrian->nama }}" />
                            <x-adminlte-input name="tgl_lahir" class="tgllahir-id"
                                label="Tanggal Lahir" fgroup-class="col-md-6"
                                value="{{ $antrian->kunjungan->tgl_lahir ?? null }}"
                                igroup-size="sm" placeholder="Tanggal Lahir" />
                            <x-adminlte-input name="gender" class="gender-id"
                                label="Jenis Kelamin" fgroup-class="col-md-6"
                                value="{{ $antrian->kunjungan->gender ?? null }}"
                                igroup-size="sm" placeholder="Jenis Kelamin" />
                            <x-adminlte-input name="kelas"
                                value="{{ $antrian->kunjungan->kelas ?? null }}" class="kelas-id"
                                label="Kelas Pasien" fgroup-class="col-md-6" igroup-size="sm"
                                placeholder="Kelas Pasien" />
                            <x-adminlte-input name="penjamin" class="penjamin-id"
                                label="Penjamin" fgroup-class="col-md-6" igroup-size="sm"
                                placeholder="Penjamin"
                                value="{{ $antrian->kunjungan->penjamin ?? null }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-select igroup-size="sm" name="kodepoli" label="Poliklinik">
                            @foreach ($polikliniks as $key => $value)
                                <option value="{{ $key }}"
                                    {{ $antrian->kunjungan ? ($antrian->kunjungan->unit == $key ? 'selected' : null) : null }}>
                                    {{ $value }}</option>
                            @endforeach
                        </x-adminlte-select>
                        <x-adminlte-select igroup-size="sm" name="kodedokter" label="Dokter">
                            @foreach ($dokters as $key => $value)
                                <option value="{{ $key }}"
                                    {{ $antrian->kunjungan ? ($antrian->kunjungan->dokter == $key ? 'selected' : null) : null }}>
                                    {{ $value }}</option>
                            @endforeach
                        </x-adminlte-select>
                        <x-adminlte-select igroup-size="sm" name="cara_masuk" label="Cara Masuk">
                            <option selected disabled>Pilih Cara Masuk</option>
                            <option value="gp"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'gp' ? 'selected' : null) : null }}>
                                Rujukan
                                FKTP</option>
                            <option value="hosp-trans"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'hosp-trans' ? 'selected' : null) : null }}>
                                Rujukan FKRTL</option>
                            <option value="mp"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'mp' ? 'selected' : null) : null }}>
                                Rujukan
                                Spesialis</option>
                            <option value="outp"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'outp' ? 'selected' : null) : null }}>
                                Dari
                                Rawat Jalan</option>
                            <option value="inp"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'inp' ? 'selected' : null) : null }}>
                                Dari
                                Rawat Inap</option>
                            <option value="emd"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'emd' ? 'selected' : null) : null }}>
                                Dari
                                Rawat Darurat</option>
                            <option value="born"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'born' ? 'selected' : null) : null }}>
                                Lahir
                                di RS</option>
                            <option value="nursing"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'nursing' ? 'selected' : null) : null }}>
                                Rujukan Panti Jompo</option>
                            <option value="psych"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'psych' ? 'selected' : null) : null }}>
                                Rujukan dari RS Jiwa</option>
                            <option value="rehab"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'rehab' ? 'selected' : null) : null }}>
                                Rujukan Fasilitas Rehab</option>
                            <option value="other"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->cara_masuk == 'other' ? 'selected' : null) : null }}>
                                Lain-lain</option>
                        </x-adminlte-select>
                        <x-adminlte-select2 igroup-size="sm" name="diagnosa_awal"
                            class="diagnosaid2" label="Diagnosa Awal">
                            @if ($antrian->kunjungan)
                                <option value="{{ $antrian->kunjungan->diagnosa_awal }}">
                                    {{ $antrian->kunjungan->diagnosa_awal }}</option>
                            @endif
                        </x-adminlte-select2>
                        <x-adminlte-select igroup-size="sm" name="jeniskunjungan"
                            label="Jenis Kunjungan">
                            <option selected disabled>Pilih Jenis Rujukan</option>
                            <option value="1"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->jeniskunjungan == '1' ? 'selected' : null) : null }}>
                                Rujukan FKTP</option>
                            <option value="2"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->jeniskunjungan == '2' ? 'selected' : null) : null }}>
                                Umum</option>
                            <option value="3"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->jeniskunjungan == '3' ? 'selected' : null) : null }}>
                                Kontrol</option>
                            <option value="4"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->jeniskunjungan == '4' ? 'selected' : null) : null }}>
                                Rujukan Antar RS</option>
                        </x-adminlte-select>
                        <x-adminlte-input name="nomorreferensi" igroup-size="sm"
                            label="Nomor Referensi" placeholder="Nomor Referensi"
                            value="{{ $antrian->kunjungan->nomorreferensi ?? null }}" />
                        <x-adminlte-input name="sep" igroup-size="sm" label="Nomor SEP"
                            placeholder="Nomor SEP"
                            value="{{ $antrian->kunjungan->sep ?? null }}" />
                    </div>
                </div>
                <button type="submit" class="btn btn-success withLoad">
                    <i class="fas fa-edit"></i> Simpan Kunjungan
                </button>
            </form>
        </div>
    </div>
</div>
