@extends('adminlte::page')
@section('title', 'Antrian Pendaftaran')
@section('content_header')
    <h1>Antrian Pendaftaran</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('sim.antrian_profil')
        </div>
        <div class="col-md-9">
            @if ($errors->any())
                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
            <a href="{{ route('antrianpendaftaran') }}?tanggalperiksa={{ $antrian->tanggalperiksa }}"
                class="btn btn-danger mb-2 mr-1 withLoad">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div class="btn btn-{{ $antrian->taskid == 3 ? 'success' : 'secondary' }} mb-2 mr-1">
                <i class="fas fa-{{ $antrian->taskid == 3 ? 'check-circle' : 'info-circle' }}"></i>
                Status Antrian :
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
            </div>
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#antriantab" data-toggle="tab">Antrian</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#septab" data-toggle="tab">SEP</a></li>
                        <li class="nav-item"><a class="nav-link" href="#kunjungantab" data-toggle="tab">Kunjungan</a>
                        <li class="nav-item"><a class="nav-link" href="#pembayarantab" data-toggle="tab">Pembayaran</a>
                        <li class="nav-item"><a class="nav-link" href="#riwayattab" data-toggle="tab">Riwayat</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#suratkontroltab" data-toggle="tab">Surat
                                Kontrol</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#resumetab" data-toggle="tab">Resume</a>

                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="antriantab">
                            @if ($antrian->status)
                                <x-adminlte-alert theme="success" title="Antrian sudah bridgingkan">
                                    <b>Kodebooking</b> : {{ $antrian->kodebooking }}
                                </x-adminlte-alert>
                            @else
                                <x-adminlte-alert theme="danger" title="Antrian belum bridgingkan">
                                    <b>Kodebooking</b> : {{ $antrian->kodebooking }}
                                </x-adminlte-alert>
                            @endif
                            <form action="{{ route('editantrian') }}" method="POST">
                                @csrf
                                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-adminlte-input name="nomorkartu" class="nomorkartu-id" igroup-size="sm"
                                            label="Nomor Kartu" value="{{ $antrian->nomorkartu }}"
                                            placeholder="Nomor Kartu">
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
                                        <x-adminlte-input name="nama" class="nama-id" label="Nama Pasien"
                                            igroup-size="sm" placeholder="Nama Pasien" readonly
                                            value="{{ $antrian->nama }}" />
                                        <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP" igroup-size="sm"
                                            placeholder="Nomor HP" value="{{ $antrian->nohp }}" />
                                    </div>
                                    <div class="col-md-6">
                                        @php
                                            $config = ['format' => 'YYYY-MM-DD'];
                                        @endphp
                                        <x-adminlte-input-date name="tanggalperiksa" class="tanggalperiksa-id"
                                            igroup-size="sm" label="Tanggal Periksa"
                                            value="{{ $antrian->tanggalperiksa }}" placeholder="Tanggal Periksa"
                                            :config="$config">
                                        </x-adminlte-input-date>
                                        <x-adminlte-select igroup-size="sm" name="jenispasien" label="Jenis Pasien">
                                            <option selected disabled>Pilih Jenis Pasien</option>
                                            <option value="JKN"
                                                {{ $antrian->jenispasien == 'JKN' ? 'selected' : null }}>JKN</option>
                                            <option value="NON-JKN"
                                                {{ $antrian->jenispasien == 'NON-JKN' ? 'selected' : null }}>NON-JKN
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
                                                <x-adminlte-select igroup-size="sm" name="asalRujukan"
                                                    label="Jenis Rujukan">
                                                    <option selected disabled>Pilih Jenis Rujukan</option>
                                                    <option value="1"
                                                        {{ $antrian->jeniskunjungan == '1' ? 'selected' : null }}>Rujukan
                                                        FKTP</option>
                                                    <option value="2"
                                                        {{ $antrian->jeniskunjungan == '4' ? 'selected' : null }}>Rujukan
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
                                        <x-adminlte-input name="noSurat" class="noSurat-id" igroup-size="sm"
                                            label="Nomor Surat Kontrol" placeholder="Nomor Surat Kontrol"
                                            value="{{ $antrian->nomorsuratkontrol }}" readonly>
                                            <x-slot name="appendSlot">
                                                <div class="btn btn-primary btnCariSuratKontrol">
                                                    <i class="fas fa-search"></i> Cari
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success withLoad">
                                    <i class="fas fa-edit"></i> Update Identitas
                                </button>
                                <div class="btn btn-warning">
                                    <i class="fas fa-user-plus"></i> Pasien Baru
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="septab">
                            <x-adminlte-alert theme="{{ $antrian->sep ? 'success' : 'danger' }}"
                                title="Silahkan buat SEP jika pasien BPJS">
                                <b>Nomor SEP</b> : {{ $antrian->sep ?? 'Belum Dibuatkan' }} <br>
                                @if ($antrian->sep)
                                    <a class="btn btn-xs btn-warning text-dark" target="_blank"
                                        href="{{ route('sep_print') }}?noSep={{ $antrian->sep }}"
                                        style="text-decoration: none">
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
                                        <x-adminlte-input name="noKartu" class="nomorkartu-id" igroup-size="sm"
                                            label="Nomor Kartu" placeholder="Nomor Kartu"
                                            value="{{ $antrian->nomorkartu }}" readonly />
                                        <x-adminlte-input name="noMR" class="norm-id" label="No RM" igroup-size="sm"
                                            placeholder="No RM" value="{{ $antrian->norm }}" readonly />
                                        <x-adminlte-input name="nama" class="nama-id" label="Nama Pasien"
                                            igroup-size="sm" placeholder="Nama Pasien" value="{{ $antrian->nama }}"
                                            readonly />
                                        <x-adminlte-input name="noTelp" class="nohp-id" label="Nomor HP"
                                            igroup-size="sm" placeholder="Nomor HP" value="{{ $antrian->nohp }}"
                                            readonly />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <x-adminlte-select igroup-size="sm" name="asalRujukan"
                                                    label="Jenis Rujukan">
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
                                        <x-adminlte-input name="noSurat" class="noSurat-id" igroup-size="sm"
                                            label="Nomor Surat Kontrol" placeholder="Nomor Surat Kontrol" readonly>
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
                                                <option value="{{ $key }}">{{ $item }}</option>
                                            @endforeach
                                        </x-adminlte-select2>
                                        <x-adminlte-select2 igroup-size="sm" name="dpjpLayan" label="Dokter DPJP"
                                            required>
                                            <option selected disabled>Pilih Dokter DPJP</option>
                                            @foreach ($dokters as $key => $item)
                                                <option value="{{ $key }}">{{ $item }}</option>
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
                                        <x-adminlte-select igroup-size="sm" name="assesmentPel"
                                            label="Assesment Pelayanan">
                                            <option value="">Normal</option>
                                            <option value="0">Poli tujuan beda dengan poli rujukan dan hari beda
                                            </option>
                                            <option value="1">Poli spesialis tidak tersedia pada hari sebelumnya
                                            </option>
                                            <option value="2">Jam Poli telah berakhir pada hari sebelumnya
                                            </option>
                                            <option value="3">Dokter Spesialis yang dimaksud tidak praktek pada
                                                hari
                                                sebelumnya</option>
                                            <option value="4">Atas Instruksi RS</option>
                                            <option value="5">Tujuan Kontrol</option>
                                        </x-adminlte-select>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <x-adminlte-select2 igroup-size="sm" name="diagAwal" label="Diagnosa Awal"
                                        class="diagnosaid1">
                                    </x-adminlte-select2>
                                    <x-adminlte-textarea igroup-size="sm" label="Catatan" name="catatan"
                                        placeholder="Catatan Pasien" />
                                    <button type="submit" class="btn btn-warning withLoad">
                                        <i class="fas fa-file-medical"></i> Buat SEP
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="kunjungantab">
                            @if ($antrian->kunjungan_id)
                                <x-adminlte-alert theme="success" title="Antrian sudah dibuatkan kunjungan">
                                    <b>Kodekunjungan</b> : {{ $antrian->kunjungan->kode ?? null }}
                                </x-adminlte-alert>
                            @else
                                <x-adminlte-alert theme="danger" title="Antrian belum dibuatkan kunjungan">
                                    Silahkan input untuk data kunjungan
                                </x-adminlte-alert>
                            @endif
                            <form action="{{ route('editkunjungan') }}" method="POST">
                                @csrf
                                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <x-adminlte-input fgroup-class="col-md-6" name="kodekunjungan"
                                                label="Kode Kunjungan" igroup-size="sm" placeholder="Kode Kunjungan"
                                                readonly value="{{ $antrian->kunjungan->kode ?? null }}" />
                                            <x-adminlte-input fgroup-class="col-md-6" name="counter"
                                                label="Counter Kunjungan" igroup-size="sm"
                                                placeholder="Counter Kunjungan"
                                                value="{{ $antrian->kunjungan->counter ?? null }}" readonly />
                                            @php
                                                $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
                                            @endphp
                                            <x-adminlte-input-date fgroup-class="col-md-6" name="tgl_masuk"
                                                igroup-size="sm" label="Tanggal Masuk" placeholder="Tanggal Masuk"
                                                :config="$config" value="{{ $antrian->kunjungan->tgl_masuk ?? null }}">
                                            </x-adminlte-input-date>
                                            {{-- <x-adminlte-input-date fgroup-class="col-md-6" name="tgl_pulang"
                                                igroup-size="sm" label="Tanggal Pulang" placeholder="Tanggal Pulang"
                                                :config="$config">
                                            </x-adminlte-input-date> --}}
                                            <x-adminlte-select igroup-size="sm" fgroup-class="col-md-6" name="jaminan"
                                                label="Jaminan Pasien">
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
                                            <x-adminlte-input name="nik" class="nik-id" fgroup-class="col-md-6"
                                                igroup-size="sm" label="NIK" placeholder="NIK"
                                                value="{{ $antrian->nik }}">
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
                                                fgroup-class="col-md-6" igroup-size="sm" placeholder="Nama Pasien"
                                                readonly value="{{ $antrian->nama }}" />
                                            <x-adminlte-input name="tgl_lahir" class="tgllahir-id" label="Tanggal Lahir"
                                                fgroup-class="col-md-6"
                                                value="{{ $antrian->kunjungan->tgl_lahir ?? null }}" readonly
                                                igroup-size="sm" placeholder="Tanggal Lahir" />
                                            <x-adminlte-input name="gender" class="gender-id" label="Jenis Kelamin"
                                                fgroup-class="col-md-6" value="{{ $antrian->kunjungan->gender ?? null }}"
                                                readonly igroup-size="sm" placeholder="Jenis Kelamin" />
                                            <x-adminlte-input name="kelas"
                                                value="{{ $antrian->kunjungan->kelas ?? null }}" class="kelas-id"
                                                label="Kelas Pasien" fgroup-class="col-md-6" readonly igroup-size="sm"
                                                placeholder="Kelas Pasien" />
                                            <x-adminlte-input name="penjamin" class="penjamin-id" label="Penjamin"
                                                fgroup-class="col-md-6" readonly igroup-size="sm" placeholder="Penjamin"
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
                                                {{ $antrian->kunjungan->cara_masuk ?? null == 'gp' ? 'selected' : null }}>
                                                Rujukan
                                                FKTP</option>
                                            <option value="hosp-trans"
                                                {{ $antrian->kunjungan->cara_masuk ?? null == 'hosp-trans' ? 'selected' : null }}>
                                                Rujukan FKRTL</option>
                                            <option value="mp"
                                                {{ $antrian->kunjungan->cara_masuk ?? null == 'mp' ? 'selected' : null }}>
                                                Rujukan
                                                Spesialis</option>
                                            <option value="outp"
                                                {{ $antrian->kunjungan->cara_masuk ?? null == 'outp' ? 'selected' : null }}>
                                                Dari
                                                Rawat Jalan</option>
                                            <option value="inp"
                                                {{ $antrian->kunjungan->cara_masuk ?? null == 'inp' ? 'selected' : null }}>
                                                Dari
                                                Rawat Inap</option>
                                            <option value="emd"
                                                {{ $antrian->kunjungan->cara_masuk ?? null == 'emd' ? 'selected' : null }}>
                                                Dari
                                                Rawat Darurat</option>
                                            <option value="born"
                                                {{ $antrian->kunjungan->cara_masuk ?? null == 'born' ? 'selected' : null }}>
                                                Lahir
                                                di RS</option>
                                            <option value="nursing"
                                                {{ $antrian->kunjungan->cara_masuk ?? null == 'nursing' ? 'selected' : null }}>
                                                Rujukan Panti Jompo</option>
                                            <option value="psych"
                                                {{ $antrian->kunjungan->cara_masuk ?? null == 'psych' ? 'selected' : null }}>
                                                Rujukan dari RS Jiwa</option>
                                            <option value="rehab"
                                                {{ $antrian->kunjungan->cara_masuk ?? null == 'rehab' ? 'selected' : null }}>
                                                Rujukan Fasilitas Rehab</option>
                                            <option value="other"
                                                {{ $antrian->kunjungan->cara_masuk ?? null == 'other' ? 'selected' : null }}>
                                                Lain-lain</option>
                                        </x-adminlte-select>
                                        <x-adminlte-select2 igroup-size="sm" name="diagnosa_awal" class="diagnosaid2"
                                            label="Diagnosa Awal">
                                            @if ($antrian->kunjungan)
                                                <option value="{{ $antrian->kunjungan->diagnosa_awal }}">
                                                    {{ $antrian->kunjungan->diagnosa_awal }}</option>
                                            @endif
                                        </x-adminlte-select2>
                                        <x-adminlte-select igroup-size="sm" name="jeniskunjungan"
                                            label="Jenis Kunjungan">
                                            <option selected disabled>Pilih Jenis Rujukan</option>
                                            <option value="1"
                                                {{ $antrian->kunjungan->jeniskunjungan ?? null == '1' ? 'selected' : null }}>
                                                Rujukan FKTP</option>
                                            <option value="2"
                                                {{ $antrian->kunjungan->jeniskunjungan ?? null == '2' ? 'selected' : null }}>
                                                Rujukan Internal / Umum</option>
                                            <option value="3"
                                                {{ $antrian->kunjungan->jeniskunjungan ?? null == '3' ? 'selected' : null }}>
                                                Kontrol</option>
                                            <option value="4"
                                                {{ $antrian->kunjungan->jeniskunjungan ?? null == '4' ? 'selected' : null }}>
                                                Rujukan Antar RS</option>
                                        </x-adminlte-select>
                                        <x-adminlte-input name="nomorreferensi" igroup-size="sm" label="Nomor Referensi"
                                            placeholder="Nomor Referensi"
                                            value="{{ $antrian->kunjungan->nomorreferensi ?? null }}" />
                                        <x-adminlte-input name="sep" igroup-size="sm" label="Nomor SEP"
                                            placeholder="Nomor SEP" value="{{ $antrian->kunjungan->sep ?? null }}" />
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success withLoad">
                                    <i class="fas fa-edit"></i> Update Identitas
                                </button>
                                <div class="btn btn-warning">
                                    <i class="fas fa-user-plus"></i> Pasien Baru
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="riwayattab">
                            Riwayat Pasien
                        </div>
                        <div class="tab-pane" id="pembayarantab">
                            Pembayaran
                        </div>
                        <div class="tab-pane" id="suratkontroltab">
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
                                        <x-adminlte-input name="nomorkartu" class="nomorkartu-id" igroup-size="sm"
                                            label="Nomor Kartu" placeholder="Nomor Kartu"
                                            value="{{ $antrian->nomorkartu }}" readonly />
                                        <x-adminlte-input name="norm" class="norm-id" label="No RM" igroup-size="sm"
                                            placeholder="No RM " value="{{ $antrian->norm }}" readonly />
                                        <x-adminlte-input name="nama" class="nama-id" label="Nama Pasien"
                                            igroup-size="sm" placeholder="Nama Pasien" value="{{ $antrian->nama }}"
                                            readonly />
                                        <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP"
                                            igroup-size="sm" placeholder="Nomor HP" value="{{ $antrian->nohp }}"
                                            readonly />
                                    </div>
                                    <div class="col-md-6">
                                        <x-adminlte-input name="noSEP" class="noSEP-id" igroup-size="sm"
                                            label="Nomor SEP" placeholder="Nomor SEP">
                                            <x-slot name="appendSlot">
                                                <div class="btn btn-primary btnCariSEP">
                                                    <i class="fas fa-search"></i> Cari SEP
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                        @php
                                            $config = ['format' => 'YYYY-MM-DD'];
                                        @endphp
                                        <x-adminlte-input-date name="tglRencanaKontrol" class="tglRencanaKontrol-id"
                                            igroup-size="sm" label="Tanggal Rencana Kontrol"
                                            value="{{ $request->tglRencanaKontrol }}"
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
                                        <x-adminlte-select igroup-size="sm" name="kodeDokter" class="kodeDokter-id"
                                            label="Dokter">
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
                        <div class="tab-pane" id="resumetab">
                            <br>
                            <a href="{{ route('lanjutpoliklinik') }}?kodebooking={{ $antrian->kodebooking }}"
                                class="btn btn-warning withLoad">
                                <i class="fas fa-user-plus"></i> Lanjut Pemeriksaan Dokter
                            </a>
                            <a href="{{ route('batalantrian') }}?kodebooking={{ $antrian->kodebooking }}&keterangan=Dibatalkan dipendaftaran {{ Auth::user()->name }}"
                                class="btn btn-danger withLoad">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-adminlte-modal id="modalRujukan" name="modalRujukan" title="Peserta Rujukan Peserta" theme="success"
        icon="fas fa-file-medical" size="xl">
        @php
            $heads = ['tglKunjungan', 'noKunjungan', 'provPerujuk', 'Nama', 'jnsPelayanan', 'poli', 'Action'];
            $config['paging'] = false;
            $config['info'] = false;
        @endphp
        <x-adminlte-datatable id="tableRujukan" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
            hoverable compressed>
        </x-adminlte-datatable>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalSuratKontrol" name="modalSuratKontrol" title="Surat Kontrol Peserta" theme="success"
        icon="fas fa-file-medical" size="xl">
        @php
            $heads = ['tglRencanaKontrol', 'noSuratKontrol', 'Nama', 'jnsPelayanan', 'namaPoliTujuan', 'namaDokter', 'terbitSEP', 'Action'];
            $config['paging'] = false;
            $config['info'] = false;
        @endphp
        <x-adminlte-datatable id="tableSuratKontrol" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
            hoverable compressed>
        </x-adminlte-datatable>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalSEP" name="modalSEP" title="SEP Peserta" theme="success" icon="fas fa-file-medical"
        size="xl">
        @php
            $heads = ['tglSep', 'tglPlgSep', 'noSep', 'jnsPelayanan', 'poli', 'diagnosa', 'Action'];
            $config['paging'] = false;
            $config['info'] = false;
        @endphp
        <x-adminlte-datatable id="tableSEP" class="nowrap text-xs" :heads="$heads" :config="$config" bordered hoverable
            compressed>
        </x-adminlte-datatable>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalEditSuratKontrol" name="modalEditSuratKontrol" title="Edit Surat Kontrol" theme="success"
        icon="fas fa-file-medical">
        <form action="" id="formUpdate">
            <input type="hidden" name="user" value="{{ Auth::user()->name }}">
            <x-adminlte-input name="noSuratKontrol" class="noSurat-edit" igroup-size="sm" label="Nomor Surat Kontrol"
                placeholder="Nomor Surat Kontrol" readonly>
            </x-adminlte-input>
            <x-adminlte-input name="noSEP" class="noSEP-id" igroup-size="sm" label="Nomor SEP"
                placeholder="Nomor SEP" readonly>
            </x-adminlte-input>
            @php
                $config = ['format' => 'YYYY-MM-DD'];
            @endphp
            <x-adminlte-input-date name="tglRencanaKontrol" id="tglRencanaKontrolid" class="tglRencanaKontrol-id"
                igroup-size="sm" label="Tanggal Rencana Kontrol" value="{{ $request->tglRencanaKontrol }}"
                placeholder="Pilih Tanggal Rencana Kontrol" :config="$config">
                <x-slot name="appendSlot">
                    <div class="btn btn-primary btnCariPoli">
                        <i class="fas fa-search"></i> Cari Poli
                    </div>
                </x-slot>
            </x-adminlte-input-date>
            <x-adminlte-select igroup-size="sm" name="poliKontrol" class="poliKontrol-id" label="Poliklinik">
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
            <x-adminlte-textarea igroup-size="sm" label="Catatan" name="catatan" placeholder="Catatan Pasien" />
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="warning" icon="fas fa-edit" class="mr-auto btnUpdateSuratKontrol"
                label="Update" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Tutup" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)

@section('js')
    <script>
        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            $('.btnCariKartu').click(function() {
                $.LoadingOverlay("show");
                var nomorkartu = $(".nomorkartu-id").val();
                var url = "{{ route('peserta_nomorkartu') }}?nomorkartu=" + nomorkartu +
                    "&tanggal={{ now()->format('Y-m-d') }}";
                $.get(url, function(data, status) {
                    if (status == "success") {
                        if (data.metadata.code == 200) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
                            var pasien = data.response.peserta;
                            $(".nama-id").val(pasien.nama);
                            $(".nik-id").val(pasien.nik);
                            $(".nomorkartu-id").val(pasien.noKartu);
                            $(".norm-id").val(pasien.mr.noMR);
                            $(".tgllahir-id").val(pasien.tglLahir);
                            $(".gender-id").val(pasien.sex);
                            $(".penjamin-id").val(pasien.jenisPeserta.keterangan);
                            $(".kelas-id").val(pasien.hakKelas.kode);
                            if (pasien.mr.noMR == null) {
                                Swal.fire(
                                    'Mohon Maaf !',
                                    "Pasien baru belum memiliki no RM",
                                    'error'
                                )
                            }
                            $(".nohp-id").val(pasien.mr.noTelepon);
                            console.log(pasien);
                        } else {
                            // alert(data.metadata.message);
                            Swal.fire(
                                'Mohon Maaf !',
                                data.metadata.message,
                                'error'
                            )
                        }
                    } else {
                        console.log(data);
                        alert("Error Status: " + status);
                    }
                });
                $.LoadingOverlay("hide");
            });
            $('.btnCariNIK').click(function() {
                $.LoadingOverlay("show");
                var nomorkartu = $(".nik-id").val();
                var url = "{{ route('peserta_nik') }}?nik=" + nomorkartu +
                    "&tanggal={{ now()->format('Y-m-d') }}";
                $.get(url, function(data, status) {
                    if (status == "success") {
                        if (data.metadata.code == 200) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
                            var pasien = data.response.peserta;
                            $(".nama-id").val(pasien.nama);
                            $(".nik-id").val(pasien.nik);
                            $(".nomorkartu-id").val(pasien.noKartu);
                            $(".norm-id").val(pasien.mr.noMR);
                            $(".tgllahir-id").val(pasien.tglLahir);
                            $(".gender-id").val(pasien.sex);
                            $(".penjamin-id").val(pasien.jenisPeserta.keterangan);
                            $(".kelas-id").val(pasien.hakKelas.kode);
                            if (pasien.mr.noMR == null) {
                                Swal.fire(
                                    'Mohon Maaf !',
                                    "Pasien baru belum memiliki no RM",
                                    'error'
                                )
                            }
                            $(".nohp-id").val(pasien.mr.noTelepon);
                            console.log(pasien);
                        } else {
                            // alert(data.metadata.message);
                            Swal.fire(
                                'Mohon Maaf !',
                                data.metadata.message,
                                'error'
                            )
                        }
                    } else {
                        console.log(data);
                        alert("Error Status: " + status);
                    }
                });
                $.LoadingOverlay("hide");
            });
            $('.btnCariRujukan').click(function() {
                $.LoadingOverlay("show");
                var asalRujukan = $("#asalRujukan").find(":selected").val();
                var nomorkartu = $(".nomorkartu-id").val();
                $('#modalRujukan').modal('show');
                var table = $('#tableRujukan').DataTable();
                table.rows().remove().draw();
                var url = "{{ route('rujukan_peserta') }}?nomorkartu=" + nomorkartu;
                switch (asalRujukan) {
                    case '1':
                        var url = "{{ route('rujukan_peserta') }}?nomorkartu=" + nomorkartu;
                        break;
                    case '2':
                        var url = "{{ route('rujukan_rs_peserta') }}?nomorkartu=" + nomorkartu;
                        break;
                    default:
                        Swal.fire(
                            'Error',
                            'Pilih Jenis Rujukan',
                            'error'
                        );
                        break;
                }
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $.each(data.response.rujukan, function(key, value) {
                                table.row.add([
                                    value.tglKunjungan,
                                    value.noKunjungan,
                                    value.provPerujuk.nama,
                                    value.peserta.nama,
                                    value.pelayanan.nama,
                                    value.poliRujukan.nama,
                                    "<button class='btnPilihRujukan btn btn-success btn-xs' data-id=" +
                                    value.noKunjungan +
                                    " data-kelas=" + value.peserta.hakKelas
                                    .kode +
                                    " data-tglrujukan=" + value.tglKunjungan +
                                    " data-ppkrujukan=" + value.provPerujuk
                                    .kode +
                                    " >Pilih</button>",
                                ]).draw(false);
                            });
                            $('.btnPilihRujukan').click(function() {
                                $.LoadingOverlay("show");
                                $('#ppkrujukan').val($(this).data('ppkrujukan'));
                                $('.noRujukan-id').val($(this).data('id'));
                                $('#klsRawatHak').val($(this).data('kelas')).change();
                                $('#tglrujukan').val($(this).data('tglrujukan'));
                                $('#modalRujukan').modal('hide');
                                $.LoadingOverlay("hide");
                            });
                        } else {
                            Swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        alert('Error');
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('.btnCariSuratKontrol').click(function() {
                $.LoadingOverlay("show");
                var nomorkartu = $(".nomorkartu-id").val();
                $('#modalSuratKontrol').modal('show');
                var table = $('#tableSuratKontrol').DataTable();
                table.rows().remove().draw();
                var url = "{{ route('suratkontrol_peserta') }}?nomorkartu=" + nomorkartu +
                    "&bulan={{ now()->format('m') }}&tahun={{ now()->format('Y') }}&formatfilter=2";
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $.each(data.response.list, function(key, value) {
                                table.row.add([
                                    value.tglRencanaKontrol,
                                    value.noSuratKontrol,
                                    value.nama,
                                    value.namaJnsKontrol,
                                    value.namaPoliTujuan,
                                    value.namaDokter,
                                    value.terbitSEP,
                                    "<button class='btnPilihSurat btn btn-success btn-xs mr-1' data-id=" +
                                    value.noSuratKontrol +
                                    " >Pilih</button><button class='btnEditSuratKontrol btn btn-warning  mr-1 btn-xs' data-id=" +
                                    value.noSuratKontrol +
                                    " data-nosepasal=" + value
                                    .noSepAsalKontrol +
                                    " >Edit</button><button class='btnHapusSuratKontrol btn btn-danger btn-xs' data-id=" +
                                    value.noSuratKontrol + " >Hapus</button>",
                                ]).draw(false);
                            });
                            $('.btnPilihSurat').click(function() {
                                $.LoadingOverlay("show");
                                $('.noSurat-id').val($(this).data('id'));
                                $('#modalSuratKontrol').modal('hide');
                                $.LoadingOverlay("hide");
                            });
                            $('.btnEditSuratKontrol').click(function() {
                                $.LoadingOverlay("show");
                                $('#formUpdate').trigger("reset");
                                $('#modalEditSuratKontrol').modal('show');
                                $('.noSurat-edit').val($(this).data('id'));
                                $('.noSEP-id').val($(this).data('nosepasal'));
                                $.LoadingOverlay("hide");
                            });
                            $('.btnHapusSuratKontrol').click(function() {
                                $.LoadingOverlay("show");
                                var nomorsuratkontrol = $(this).data('id');
                                var url =
                                    "{{ route('suratkontrol_hapus') }}?noSuratKontrol=" +
                                    nomorsuratkontrol;
                                window.location.href = url;
                            });
                        } else {
                            Swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        alert('Error');
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $(".diagnosaid1").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_diagnosa_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            diagnosa: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            $(".diagnosaid2").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_diagnosa_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            diagnosa: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            $('.btnCariSEP').click(function(e) {
                var nomorkartu = $(".nomorkartu-id").val();
                $('#modalSEP').modal('show');
                var table = $('#tableSEP').DataTable();
                table.rows().remove().draw();
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('suratkontrol_sep') }}?nomorkartu=" + nomorkartu;
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $.each(data.response, function(key, value) {
                                if (value.jnsPelayanan == 1) {
                                    var jenispelayanan = "Rawat Inap";
                                }
                                if (value.jnsPelayanan == 2) {
                                    var jenispelayanan = "Rawat Jalan";
                                }
                                var btnpilih =
                                    "<button class='btnPilihSEP btn btn-success btn-xs mr-1' data-id=" +
                                    value.noSep +
                                    ">Pilih</button>";
                                var btnhapus =
                                    "<button class='btnPilihSEP btn btn-success btn-xs mr-1' data-id=" +
                                    value.noSep +
                                    ">Pilih</button><button class='btnHapusSEP btn btn-danger btn-xs' data-id=" +
                                    value.noSep + ">Hapus</button>";
                                if (value.tglPlgSep == null) {
                                    var btn = btnhapus;
                                } else {
                                    var btn = btnpilih;
                                }
                                table.row.add([
                                    value.tglSep,
                                    value.tglPlgSep,
                                    value.noSep,
                                    jenispelayanan,
                                    value.poli,
                                    value.diagnosa,
                                    btn,
                                ]).draw(false);

                            });
                            $('.btnPilihSEP').click(function() {
                                var nomorsep = $(this).data('id');
                                $.LoadingOverlay("show");
                                $('#noSEP').val(nomorsep);
                                $('#modalSEP').modal('hide');
                                $.LoadingOverlay("hide");
                            });
                            $('.btnHapusSEP').click(function() {
                                $.LoadingOverlay("show");
                                var nomorsep = $(this).data('id');
                                var url = "{{ route('sep_hapus') }}?noSep=" +
                                    nomorsep;
                                window.location.href = url;
                            });
                        } else {
                            Swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        alert('Error');
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('.btnCariPoli').click(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                var sep = $('.noSEP-id').val();
                var tanggal = $('.tglRencanaKontrol-id').val();
                if (tanggal == '') {
                    var tanggal = $('#tglRencanaKontrolid').val();
                }
                var url = "{{ route('suratkontrol_poli') }}?nomor=" + sep + "&tglRencanaKontrol=" +
                    tanggal;
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $('.poliKontrol-id').empty()
                            $.each(data.response.list, function(key, value) {
                                optText = value.namaPoli + " (" + value.persentase +
                                    "%)";
                                optValue = value.kodePoli;
                                $('.poliKontrol-id').append(new Option(optText,
                                    optValue));
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
                        } else {
                            Swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        alert(url);
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('.btnCariDokter').click(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                var poli = $('.poliKontrol-id').find(":selected").val();
                var tanggal = $('.tglRencanaKontrol-id').val();
                if (tanggal == '') {
                    var tanggal = $('#tglRencanaKontrolid').val();
                }
                var url = "{{ route('suratkontrol_dokter') }}?kodePoli=" + poli + "&tglRencanaKontrol=" +
                    tanggal;
                // alert(url);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $('.kodeDokter-id').empty()
                            $.each(data.response.list, function(key, value) {
                                optText = value.namaDokter + " (" + value
                                    .jadwalPraktek +
                                    ")";
                                optValue = value.kodeDokter;
                                $('.kodeDokter-id').append(new Option(optText,
                                    optValue));
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
                        } else {
                            Swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        alert(url);
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('.btnUpdateSuratKontrol').click(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{ route('suratkontrol_update') }}",
                    type: "PUT",
                    data: $('#formUpdate').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data.metadata.code == 200) {
                            Swal.fire(
                                'Success',
                                'Berhasi upadate surat kontrol',
                                'success'
                            );
                            $('#modalSuratKontrol').modal('hide');
                            $('#modalEditSuratKontrol').modal('hide');
                        } else {
                            Swal.fire(
                                'Error ' + data.metadata.code,
                                data.metadata.message,
                                'error'
                            );
                        }
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        console.log(data);
                        $.LoadingOverlay("hide");
                    }
                });
            });
        });
    </script>
@endsection
