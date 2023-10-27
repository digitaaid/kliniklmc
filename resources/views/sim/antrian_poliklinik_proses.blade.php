@extends('adminlte::page')
@section('title', 'Assesmen Dokter')
@section('content_header')
    <h1>Assesmen Dokter</h1>
@stop
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
            <a href="{{ route('antrianpoliklinik') }}?tanggalperiksa={{ $antrian->tanggalperiksa }}"
                class="btn btn-danger mb-2 mr-1 withLoad">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('panggilpendaftaran') }}?kodebooking={{ $antrian->kodebooking }}"
                class="btn btn-primary mb-2 mr-1 withLoad">
                <i class="fas fa-sync"></i> Panggil
            </a>
            <div class="btn btn-{{ $antrian->taskid == 5 ? 'success' : 'secondary' }} mb-2 mr-1">
                <i class="fas fa-{{ $antrian->taskid == 5 ? 'check-circle' : 'info-circle' }}"></i>
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
            @include('sim.antrian_profil2')
        </div>
        <div class="col-md-12">
            <div class="card card-primary card-tabs">
                <div class="card-header  p-0 pl-1 pt-1">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" href="#riwayattab" data-toggle="tab">Riwayat</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#filepenunjangtab" data-toggle="tab">File
                                Penunjang</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#anamnesatab" data-toggle="tab">Anamnesa</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#doktertab" data-toggle="tab">Konsultasi</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#reseptab" data-toggle="tab">Resep</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#tindakantab" data-toggle="tab">Tindakan</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#labtab" data-toggle="tab">Laboratorium</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#radtab" data-toggle="tab">Radiologi</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#resumetab" data-toggle="tab">Resume</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body" style="overflow-y: auto; max-height: 600px">
                    <div class="tab-content">
                        <div class="active tab-pane" id="riwayattab">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Data Registrasi</th>
                                        <th>Anamnesa</th>
                                        <th>Konsultasi Dokter</th>
                                        <th>Obat</th>
                                        <th>Penunjang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <style>
                                        pre {
                                            padding: 0 !important;
                                            margin-bottom: 0 !important;
                                            font-size: 15px !important;
                                            border: none;
                                            outline: none;
                                        }
                                    </style>
                                    @if ($antrian->pasien)
                                        @foreach ($antrian->pasien->kunjungans as $kunjungan)
                                            <tr>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($kunjungan->tgl_masuk)->format('d/m/Y h:m:s') }}
                                                    ({{ $kunjungan->kode }})
                                                    <br>
                                                    <b>{{ $kunjungan->units->nama }}</b>
                                                </td>
                                                <td>
                                                    <dl>
                                                        <dt>Keluhan Utama :</dt>
                                                        <dd>
                                                            <pre>{{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}</pre>
                                                        </dd>
                                                        <dt>Riwayat Pengobatan :</dt>
                                                        <dd>
                                                            <pre>{{ $kunjungan->asesmenperawat->riwayat_pengobatan ?? null }}</pre>
                                                        </dd>
                                                        <dt>Tanda Vital :</dt>
                                                        <dd>
                                                            Denyut Nadi :
                                                            {{ $kunjungan->asesmenperawat->denyut_jantung ?? null }}
                                                            x/menit<br>
                                                            Pernapasan :
                                                            {{ $kunjungan->asesmenperawat->pernapasan ?? null }}
                                                            x/menit<br>
                                                            Suhu Tubuh : {{ $kunjungan->asesmenperawat->suhu ?? null }}
                                                            celcius<br>
                                                            Tekanan Darah :
                                                            {{ $kunjungan->asesmenperawat->sistole ?? null }} /
                                                            {{ $kunjungan->asesmenperawat->distole ?? null }} mmHg<br>
                                                            Tinggi / Berat / BSA :
                                                            {{ $kunjungan->asesmenperawat->tinggi_badan ?? null }} cm /
                                                            {{ $kunjungan->asesmenperawat->berat_badan ?? null }} kg /
                                                            @if ($kunjungan->asesmenperawat)
                                                                {{ number_format(sqrt(($kunjungan->asesmenperawat->tinggi_badan * $kunjungan->asesmenperawat->berat_badan) / 3600), 2) ?? null }}
                                                            @endif m2 <br>
                                                            Kesadaran :
                                                            @switch($kunjungan->asesmenperawat->tingkat_kesadaran)
                                                                @case(1)
                                                                    Sadar Baik
                                                                @break

                                                                @case(2)
                                                                    Berespon dengan kata-kata
                                                                @break

                                                                @case(3)
                                                                    Hanya berespons jika dirangsang nyeri/pain
                                                                @break

                                                                @case(4)
                                                                    Pasien tidak sadar/unresponsive
                                                                @break

                                                                @case(5)
                                                                    Gelisah / bingung
                                                                @break

                                                                @case(6)
                                                                    Acute Confusional State
                                                                @break

                                                                @default
                                                            @endswitch
                                                            <br>
                                                            Tanda Vital Tubuh :
                                                            {{ $kunjungan->asesmenperawat->keadaan_tubuh ?? '-' }}
                                                        </dd>
                                                    </dl>
                                                </td>
                                                <td>
                                                    <dl>
                                                        <dt>Diagnosa</dt>
                                                        <dd>
                                                            {{ $kunjungan->asesmendokter->diagnosa ?? null }} <br>
                                                            Diag. Primer ICD-10 :
                                                            {{ $kunjungan->asesmendokter->diagnosa1 ?? null }} <br>
                                                            Diag. Sekunder ICD-10 :
                                                            {{ $kunjungan->asesmendokter->diagnosa2 ?? null }}
                                                        </dd>
                                                        <dt>Pemeriksaan Fisik :</dt>
                                                        <dd>
                                                            <pre>{{ $kunjungan->asesmendokter->pemeriksaan_fisik ?? null }}</pre>
                                                        </dd>
                                                        <dt>Tindakan :</dt>
                                                        <dd>
                                                            <pre>{{ $kunjungan->asesmendokter->tindakan_medis ?? null }}</pre>
                                                        </dd>
                                                        <dt>Instruksi Medis :</dt>
                                                        <dd>
                                                            <pre>{{ $kunjungan->asesmendokter->instruksi_medis ?? null }}</pre>
                                                        </dd>
                                                    </dl>
                                                </td>
                                                <td>
                                                    <dd>
                                                        @if ($kunjungan->resepobat)
                                                            @foreach ($kunjungan->resepobat->resepdetail as $itemobat)
                                                                <b> R/ {{ $itemobat->nama }} </b>
                                                                ({{ $itemobat->jumlah }})
                                                                @switch($itemobat->interval)
                                                                    @case('qod')
                                                                        1x1
                                                                    @break

                                                                    @case('dod')
                                                                        1x2
                                                                    @break

                                                                    @case('bid')
                                                                        2x1
                                                                    @break

                                                                    @case('tid')
                                                                        3x1
                                                                    @break

                                                                    @case('qid')
                                                                        4x1
                                                                    @break

                                                                    @case('prn')
                                                                        SESUAI KEBUTUHAN
                                                                    @break

                                                                    @case('q3h')
                                                                        SETIAP 3 JAM
                                                                    @break

                                                                    @case('q4h')
                                                                        SETIAP 4 JAM
                                                                    @break

                                                                    @case('303')
                                                                        3 TAB/CAP SETIAP PAGI DAN MALAM
                                                                    @break

                                                                    @case('202')
                                                                        2 TAB/CAP SETIAP PAGI DAN MALAM
                                                                    @break

                                                                    @default
                                                                @endswitch
                                                                @switch($itemobat->waktu)
                                                                    @case('pc')
                                                                        SETELAH MAKAN
                                                                    @break

                                                                    @case('ac')
                                                                        SEBELUM MAKAN
                                                                    @break

                                                                    @case('hs')
                                                                        SEBELUM TIDUR
                                                                    @break

                                                                    @case('int')
                                                                        DIANTARA WAKTU MAKAN
                                                                    @break

                                                                    @default
                                                                @endswitch
                                                                {{ $itemobat->keterangan }} <br>
                                                            @endforeach
                                                        @endif
                                                    </dd>
                                                    <dt>Catatan Resep :</dt>
                                                    <dd>
                                                        <pre>{{ $kunjungan->asesmendokter->resep_obat ?? null }}</pre>
                                                        <pre>{{ $kunjungan->asesmendokter->catatan_resep ?? null }}</pre>
                                                    </dd>
                                                </td>
                                                <td>-</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            Belum ada riwayat pasien
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="filepenunjangtab">
                            <style>
                                .card.card-tabs .card-tools {
                                    margin: 0px !important;
                                }
                            </style>
                            @if ($antrian->pasien)
                                @if ($antrian->pasien->fileuploads)
                                    <div class="row">
                                        @foreach ($antrian->pasien->fileuploads as $file)
                                            <div class="col-md-6">
                                                <x-adminlte-card header-class="p-2" body-class="p-0"
                                                    title="{{ $file->nama }}" theme="info" icon="fas fa-file"
                                                    collapsible="">
                                                    <x-slot name="toolsSlot">
                                                        Uploaded at : {{ $file->created_at }}
                                                        <a href="{{ $file->fileurl }}" target="_blank"
                                                            class="btn btn-xs btn-tool"><i class="fas fa-download"></i></a>
                                                        <a href="{{ route('hapusfilepenunjang') }}?id={{ $file->id }}"
                                                            class="btn btn-xs btn-tool"> <i class="fas fa-trash"></i></a>
                                                    </x-slot>
                                                    <object data="{{ $file->fileurl }}" width="100%" height="500px">
                                                    </object>
                                                </x-adminlte-card>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @else
                                @foreach ($antrian->fileuploads as $file)
                                    <x-adminlte-card header-class="p-2" body-class="p-0"
                                        title="{{ $file->nama }} {{ $file->created_at }}" theme="info"
                                        icon="fas fa-file" collapsible="collapsed">
                                        <x-slot name="toolsSlot" class="m-0">
                                            Uploaded at : {{ $file->created_at }}
                                            <a href="{{ $file->fileurl }}" target="_blank" class="btn btn-xs btn-tool"><i
                                                    class="fas fa-download"></i></a>
                                            <a href="{{ route('hapusfilepenunjang') }}?id={{ $file->id }}"
                                                class="btn btn-xs btn-tool"> <i class="fas fa-trash"></i></a>
                                        </x-slot>
                                        <object data="{{ $file->fileurl }}" width="100%" height="500px"> </object>
                                    </x-adminlte-card>
                                @endforeach
                            @endif
                        </div>
                        <div class="tab-pane" id="anamnesatab">
                            @if ($antrian->asesmenperawat)
                                <div id="printMe">
                                    @include('form.asesmen_perawat_rajal')
                                </div>
                            @else
                                <x-adminlte-alert title="Belum dilakukan asesmen perawat" theme="danger">
                                    Silahkan lakukan asesmen perawat
                                </x-adminlte-alert>
                            @endif
                        </div>
                        <div class="tab-pane" id="doktertab">
                            <form action="{{ route('editasesmendokter') }}" method="POST">
                                @csrf
                                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                                <input type="hidden" name="kodekunjungan"
                                    value="{{ $antrian->kunjungan->kode ?? null }}">
                                <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan->id ?? null }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Keluhan Utama"
                                            name="keluhan_utama" placeholder="Keluhan Utama">
                                            {{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}
                                        </x-adminlte-textarea>
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Diagnosa" id="diagnosaauto"
                                            name="diagnosa" placeholder="Diagnosa">
                                            {{ $kunjungan->asesmendokter->diagnosa ?? null }}
                                        </x-adminlte-textarea>
                                        <x-adminlte-select2 name="diagnosa1" class="diagnosaid1"
                                            label="Diagnosa Primer ICD-10 : {{ $kunjungan->asesmendokter->diagnosa1 ?? null }}">
                                        </x-adminlte-select2>
                                        <x-adminlte-select2 name="diagnosa2[]" class="diagnosaid2"
                                            label="Diagnosa Sekunder ICD-10 : {{ $kunjungan->asesmendokter->diagnosa2 ?? null }}"
                                            multiple>
                                        </x-adminlte-select2>
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Pengobatan"
                                            name="riwayat_pengobatan" placeholder="Riwayat Pengobatan">
                                            {{ $kunjungan->asesmendokter->riwayat_pengobatan ?? null }}
                                        </x-adminlte-textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <x-adminlte-textarea igroup-size="sm" rows=4 label="Pemeriksaan Fisik"
                                            name="pemeriksaan_fisik" placeholder="Pemeriksaan Fisik">
                                            {{ $antrian->asesmendokter->pemeriksaan_fisik ?? null }}
                                        </x-adminlte-textarea>
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Instruksi Medis"
                                            name="instruksi_medis" placeholder="Instruksi Medis">
                                            {{ $kunjungan->asesmendokter->instruksi_medis ?? null }}
                                        </x-adminlte-textarea>
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Tindakan Medis"
                                            name="tindakan_medis" placeholder="Tindakan Medis">
                                            {{ $kunjungan->asesmendokter->tindakan_medis ?? null }}
                                        </x-adminlte-textarea>
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Rencana Perawatan"
                                            name="rencana_perawatan" placeholder="Rencana Perawatan">
                                            {{ $kunjungan->asesmendokter->rencana_perawatan ?? null }}
                                        </x-adminlte-textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    {{-- resep obat --}}
                                    <div class="col-md-12">
                                        @if ($antrian->resepobat)
                                            <x-adminlte-alert title="Sudah Pemberian Resep Obat" theme="success">
                                                <p>
                                                    Kode : {{ $antrian->resepobat->kode }} <br>
                                                    Waktu : {{ $antrian->resepobat->waktu }}
                                                </p>
                                            </x-adminlte-alert>
                                        @endif
                                        <label class="mb-2">Resep Obat</label>
                                        <button id="addObatInput" type="button" class="btn btn-xs btn-success mb-2">
                                            <span class="fas fa-plus">
                                            </span> Tambah Obat
                                        </button>
                                        @if ($antrian->resepobat)
                                            @foreach ($antrian->resepobat->resepdetail as $itemobat)
                                                <div id="row" class="row">
                                                    <div class="form-group">
                                                        <div class="input-group input-group-sm">
                                                            <select name="obat[]" class="form-control cariObat">
                                                                <option value="{{ $itemobat->obat_id }}">
                                                                    {{ $itemobat->nama }}</option>
                                                            </select>
                                                            <input type="number" name="jumlah[]"
                                                                value="{{ $itemobat->jumlah }}" placeholder="Jumlah"
                                                                class="form-control" multiple>
                                                            <select name="frekuensi[]"class="form-control frekuensilObat">
                                                                <option selected disabled>Interval</option>
                                                                <option value="qod"
                                                                    {{ $itemobat->interval == 'qod' ? 'selected' : null }}>
                                                                    1 x 1</option>
                                                                <option value="dod"
                                                                    {{ $itemobat->interval == 'dod' ? 'selected' : null }}>
                                                                    1 x 2</option>
                                                                <option value="bid"
                                                                    {{ $itemobat->interval == 'bid' ? 'selected' : null }}>
                                                                    2 x 1</option>
                                                                <option value="tid"
                                                                    {{ $itemobat->interval == 'tid' ? 'selected' : null }}>
                                                                    3 x 1</option>
                                                                <option value="qid"
                                                                    {{ $itemobat->interval == 'qid' ? 'selected' : null }}>
                                                                    4 x 1</option>
                                                                <option value="202"
                                                                    {{ $itemobat->interval == '202' ? 'selected' : null }}>
                                                                    2-0-2</option>
                                                                <option value="303"
                                                                    {{ $itemobat->interval == '303' ? 'selected' : null }}>
                                                                    3-0-3</option>
                                                                {{-- <option value="prn"
                                                                    {{ $itemobat->interval == 'prn' ? 'selected' : null }}>
                                                                    Sesuai Kebutuhan</option>
                                                                <option value="q3h"
                                                                    {{ $itemobat->interval == 'q3h' ? 'selected' : null }}>
                                                                    Setiap 3 Jam</option>
                                                                <option value="q4h"
                                                                    {{ $itemobat->interval == 'q4h' ? 'selected' : null }}>
                                                                    Setiap 4 Jam</option> --}}
                                                            </select>
                                                            <select name="waktuobat[]" class="form-control waktuObat">
                                                                <option selected>Waktu Obat</option>
                                                                <option value="pc"
                                                                    {{ $itemobat->waktu == 'pc' ? 'selected' : null }}>
                                                                    Setelah Makan</option>
                                                                <option value="ac"
                                                                    {{ $itemobat->waktu == 'ac' ? 'selected' : null }}>
                                                                    Sebelum Makan</option>
                                                                <option value="hs"
                                                                    {{ $itemobat->waktu == 'hs' ? 'selected' : null }}>
                                                                    Sebelum Tidur</option>
                                                                <option value="int"
                                                                    {{ $itemobat->waktu == 'int' ? 'selected' : null }}>
                                                                    Diantara Waktu Makan</option>
                                                            </select>
                                                            <input type="text" name="keterangan_obat[]"
                                                                value="{{ $itemobat->keterangan }}"
                                                                placeholder="Keterangan Obat" class="form-control"
                                                                multiple>
                                                            <button type="button" class="btn btn-xs btn-danger"
                                                                id="deleteRowObat"><i class="fas fa-trash "></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div id="rowTindakan" class="row">
                                            <div class="form-group">
                                                <div class="input-group input-group-sm">
                                                    <select name="obat[]" class="form-control cariObat">
                                                    </select>
                                                    <input type="number" name="jumlah[]" placeholder="Jumlah"
                                                        class="form-control" multiple>
                                                    <select name="frekuensi[]" class="form-control frekuensilObat">
                                                        <option selected disabled>Interval</option>
                                                        <option value="qod">1 x 1</option>
                                                        <option value="dod">1 x 2</option>
                                                        <option value="bid">2 x 1</option>
                                                        <option value="tid">3 x 1</option>
                                                        <option value="qid">4 x 1</option>
                                                        <option value="202">2-0-2</option>
                                                        <option value="303">3-0-3</option>
                                                        {{-- <option value="prn">Sesuai Kebutuhan</option>
                                                        <option value="q3h">Setiap 3 Jam</option>
                                                        <option value="q4h">Setiap 4 Jam</option> --}}
                                                    </select>
                                                    <select name="waktuobat[]" class="form-control waktuObat">
                                                        <option selected>Waktu Obat</option>
                                                        <option value="pc">Setelah Makan</option>
                                                        <option value="ac">Sebelum Makan</option>
                                                        <option value="hs">Sebelum Tidur</option>
                                                        <option value="int">Diantara Waktu Makan</option>
                                                    </select>
                                                    <input type="text" name="keterangan_obat[]"
                                                        placeholder="Keterangan Obat" class="form-control" multiple>
                                                    <button type="button" class="btn btn-xs btn-warning">
                                                        <i class="fas fa-pills "></i>
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                        <div id="newObat"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Resep Obat (Free Text)"
                                            name="resep_obat" placeholder="Resep Obat (Text)">
                                            {{ $kunjungan->asesmendokter->resep_obat ?? null }}
                                        </x-adminlte-textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Catatan Resep"
                                            name="catatan_resep" placeholder="Catatan Resep">
                                            {{ $kunjungan->asesmendokter->catatan_resep ?? null }}
                                        </x-adminlte-textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-adminlte-textarea igroup-size="sm" rows=4 label="Catatan Laboratorium"
                                            name="catatan_lab" placeholder="Catatan Laboratorium">
                                            {{ $kunjungan->asesmendokter->catatan_lab ?? null }}
                                        </x-adminlte-textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <x-adminlte-textarea igroup-size="sm" rows=4 label="Catatan Radiologi"
                                            name="catatan_rad" placeholder="Catatan Radiologi">
                                            {{ $kunjungan->asesmendokter->catatan_rad ?? null }}
                                        </x-adminlte-textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success withLoad">
                                    <i class="fas fa-file-medical"></i> Simpan Assesmen Dokter
                                </button>
                            </form>
                        </div>
                        <div class="tab-pane" id="resumetab">
                            @if ($kunjungan)
                                @if ($kunjungan->asesmendokter)
                                    <div id="printMe">
                                        @include('form.asesmen_dokter_rajal')
                                    </div>
                                @else
                                    <x-adminlte-alert title="Belum dilakukan asesmen dokter" theme="danger">
                                        Silahkan lakukan asesmen dokter
                                    </x-adminlte-alert>
                                @endif
                            @endif
                            <br>
                            <a href="{{ route('lanjutfarmasi') }}?kodebooking={{ $antrian->kodebooking }}"
                                class="btn btn-warning withLoad">
                                <i class="fas fa-user-plus"></i> Lanjut Farmasi
                            </a>
                            <a href="{{ route('selesaipoliklinik') }}?kodebooking={{ $antrian->kodebooking }}"
                                class="btn btn-success withLoad">
                                <i class="fas fa-user-plus"></i> Selesai Poliklinik
                            </a>
                            <a href="{{ route('batalantrian') }}?kodebooking={{ $antrian->kodebooking }}&keterangan=Dibatalkan dipendaftaran {{ Auth::user()->name }}"
                                class="btn btn-danger withLoad">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                        <div class="tab-pane" id="reseptab">
                            Resep
                        </div>
                        <div class="tab-pane" id="tindakantab">
                            Tindakan
                        </div>
                        <div class="tab-pane" id="labtab">
                            Laboratorium
                        </div>
                        <div class="tab-pane" id="radtab">
                            Radiologi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)

@section('js')
    <script>
        $(function() {
            $(".diagnosaid1").select2({
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
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
            $(".cariObat").select2({
                placeholder: 'Pencarian Nama Obat',
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('ref_obat_cari') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            nama: params.term // search term
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
        });
    </script>
    {{-- dynamic input --}}
    <script>
        $("#addObatInput").click(function() {
            newRowAdd =
                '<div id="row" class="row"><div class="form-group"><div class="input-group input-group-sm">' +
                '<select name="obat[]" class="form-control cariObat"></select>' +
                '<input type="number" name="jumlah[]" placeholder="Jumlah" class="form-control" multiple>' +
                '<select name="frekuensi[]"class="form-control frekuensilObat"> <option selected disabled>Interval</option>' +
                '<option value="qod">1 x 1</option>' +
                '<option value="dod">1 x 2</option>' +
                '<option value="bid">2 x 1</option>' +
                '<option value="tid">3 x 1</option>' +
                '<option value="qid">4 x 1</option>' +
                '<option value="202">2-0-2</option>' +
                '<option value="303">3-0-3</option>' +
                '</select> ' +
                '<select name="waktuobat[]" class="form-control waktuObat"><option selected>Waktu Obat</option>' +
                '<option value="pc">Setelah Makan</option>' +
                '<option value="ac">Sebelum Makan</option>' +
                '<option value="hs">Sebelum Tidur</option>' +
                '<option value="int">Diantara Waktu Makan</option>' +
                '</select> ' +
                '<input type="text" name="keterangan_obat[]" placeholder="Keterangan Obat" class="form-control" multiple>' +
                '<button type="button" class="btn btn-xs btn-danger" id="deleteRowObat"><i class="fas fa-trash "></i> </div></div></div>';
            $('#newObat').append(newRowAdd);
            $(".cariObat").select2({
                placeholder: 'Pencarian Nama Obat',
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('ref_obat_cari') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            nama: params.term // search term
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
        });
        $("body").on("click", "#deleteRowObat", function() {
            $(this).parents("#row").remove();
        })
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript">
        var path = "{{ route('diagnosa_autocomplete') }}";
        $("#diagnosaauto").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $('#diagnosaauto').val(ui.item.label);
                console.log(ui.item);
                return false;
            }
        });
    </script>
    {{-- <script type="text/javascript">
        var path = "{{ route('diagnosa_autocomplete') }}";
        $('#diagnosaauto').typeahead({
                source: function (query, process) {
                    return $.get(path, {
                        query: query
                    }, function (data) {
                        return process(data);
                    });
                }
            });

    </script> --}}
@endsection


