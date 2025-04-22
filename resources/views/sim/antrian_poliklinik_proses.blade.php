@extends('adminlte::page')
@section('title', 'Assesmen Dokter')
@section('content_header')
    <h1>Assesmen Dokter</h1>
@stop
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    {{-- test --}}
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
            <x-adminlte-card theme="primary" theme-mode="outline">
                @include('sim.antrian_profil3')
                <x-slot name="footerSlot">
                    <x-adminlte-button class="btn-xs mb-1" theme="warning" label="I-Care JKN" icon="fas fa-info-circle"
                        onclick="btnIcare()" />
                    <x-adminlte-button class="btn-xs btnFileUplpad" theme="warning" label="Berkas Upload"
                        icon="fas fa-file-medical" />
                    <x-adminlte-button class="btn-xs mb-1" theme="warning" label="CPPT" icon="fas fa-file-medical"
                        onclick="btnCPPT()" />
                    {{-- <x-adminlte-button class="btn-xs mb-1" theme="{{ $antrian->asesmenperawat ? 'warning' : 'danger' }}"
                        label="Asesmen Keperawatan" icon="fas fa-hand-holding-medical" onclick="btnPengkajianPerawat()" /> --}}
                    {{-- <x-adminlte-button class="btn-xs mb-1" theme="{{ $antrian->sbar ? 'warning' : 'danger' }}"
                        label="SBAR TBAK" icon="fas fa-envelope" onclick="btnSBAR()" /> --}}
                    {{-- <x-adminlte-button class="btn-xs mb-1" theme="{{ $antrian->asesmendokter ? 'warning' : 'danger' }}"
                        label="Asesmen Dokter" icon="fas fa-user-md" onclick="btnPemeriksaanDokter()" /> --}}
                    <x-adminlte-button class="btn-xs mb-1"
                        theme="{{ $antrian->asesmendokter && $antrian->asesmendokter ? 'warning' : 'danger' }}"
                        label="Asesmen Rajal" icon="fas fa-file-medical" onclick="btnAsesmenRajal()" />
                    <x-adminlte-button class="btn-xs mb-1"
                        theme="{{ $antrian->asesmendokter && $antrian->asesmendokter ? 'warning' : 'danger' }}"
                        label="Resume" icon="fas fa-user-md" onclick="btnResumeRajal()" />
                </x-slot>
            </x-adminlte-card>
        </div>
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile p-3" style="overflow-y: auto ;max-height: 600px ;">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        {{-- riwayatpasien --}}
                        @include('sim.tabel_riwayat_pasien')
                        {{-- layanan --}}
                        @include('sim.tabel_layanan')
                        {{-- perawat --}}
                        @include('sim.tabel_anamnesa_perawat')
                        {{-- dokter --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collapseDokter">
                                <h3 class="card-title">
                                    Pemeriksaan Dokter
                                </h3>
                                <div class="card-tools">
                                    @if ($antrian->asesmendokter)
                                        Sudah Diisi Oleh
                                        {{ $antrian->asesmendokter->pic->name }}
                                        {{ $antrian->asesmendokter->created_at }}
                                        <i class="fas fa-check-circle"></i>
                                    @else
                                        Belum Diisi <i class="fas fa-times-circle"></i>
                                    @endif
                                </div>
                            </a>
                            <div id="collapseDokter" class="collapse" role="tabpanel" aria-labelledby="headDokter">
                                <div class="card-body">
                                    <form action="{{ route('editasesmendokter') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                                        <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                                        <input type="hidden" name="kodekunjungan"
                                            value="{{ $antrian->kunjungan->kode ?? null }}">
                                        <input type="hidden" name="kunjungan_id"
                                            value="{{ $antrian->kunjungan->id ?? null }}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-adminlte-textarea igroup-size="sm" rows=3 label="Keluhan Utama"
                                                    name="keluhan_utama" placeholder="Keluhan Utama">
                                                    {{ $kunjungan->asesmenperawat->keluhan_utama ?? null }}
                                                </x-adminlte-textarea>
                                                <x-adminlte-select2 name="diagnosa[]" class="diagnosa" label="Diagnosa :"
                                                    multiple>
                                                    @if ($antrian->asesmendokter)
                                                        @if (is_array(json_decode($antrian->asesmendokter->diagnosa)) ||
                                                                is_object(json_decode($antrian->asesmendokter->diagnosa)))
                                                            @foreach (json_decode($antrian->asesmendokter->diagnosa) as $item)
                                                                <option value="{{ $item }}" selected>
                                                                    {{ $item }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="{{ $antrian->asesmendokter->diagnosa }}"
                                                                selected>
                                                                {{ $antrian->asesmendokter->diagnosa }}
                                                            </option>
                                                        @endif
                                                    @endif
                                                </x-adminlte-select2>
                                                <x-adminlte-textarea igroup-size="sm" rows=3 label="Diagnosa Sekunder"
                                                    name="catatan_diagnosa" placeholder="Diagnosa Sekunder (Free Text)">
                                                    {{ $kunjungan->asesmendokter->catatan_diagnosa ?? null }}
                                                </x-adminlte-textarea>
                                                <x-adminlte-select2 name="diagnosa1" class="diagnosaid1"
                                                    label="Diagnosa Primer ICD-10 : ">
                                                    @if ($antrian->asesmendokter)
                                                        <option value="{{ $antrian->asesmendokter->diagnosa1 }}" selected>
                                                            {{ $antrian->asesmendokter->diagnosa1 }}
                                                        </option>
                                                    @endif
                                                </x-adminlte-select2>
                                                <x-adminlte-select2 name="diagnosa2[]" class="diagnosaid2"
                                                    label="Diagnosa Sekunder ICD-10 : " multiple>
                                                    @if ($antrian->asesmendokter)
                                                        @if (is_array(json_decode($antrian->asesmendokter->diagnosa2)) ||
                                                                is_object(json_decode($antrian->asesmendokter->diagnosa2)))
                                                            @foreach (json_decode($antrian->asesmendokter->diagnosa2) as $item)
                                                                <option value="{{ $item }}" selected>
                                                                    {{ $item }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="{{ $antrian->asesmendokter->diagnosa2 }}"
                                                                selected>
                                                                {{ $antrian->asesmendokter->diagnosa2 }}
                                                            </option>
                                                        @endif
                                                    @endif
                                                </x-adminlte-select2>
                                               
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
                                                <x-adminlte-textarea igroup-size="sm" rows=3 label="Catatan Dokter"
                                                    name="rencana_perawatan" placeholder="Rencana Perawatan">
                                                    {{ $kunjungan->asesmendokter->rencana_perawatan ?? null }}
                                                </x-adminlte-textarea>
                                            </div>
                                        </div>
                                        <style>
                                            .cariObat {
                                                width: 300px !important;
                                            }
                                        </style>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="mb-2">Resep Obat</label>
                                                <button id="addObatInput" type="button"
                                                    class="btn btn-xs btn-success mb-2">
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
                                                                        value="{{ $itemobat->jumlah }}"
                                                                        placeholder="Jumlah" class="form-control"
                                                                        multiple>
                                                                    <select
                                                                        name="frekuensi[]"class="form-control frekuensilObat">
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
                                                                    </select>
                                                                    <select name="waktuobat[]"
                                                                        class="form-control waktuObat">
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
                                                            <select name="frekuensi[]"
                                                                class="form-control frekuensilObat">
                                                                <option selected disabled>Interval</option>
                                                                <option value="qod">1 x 1</option>
                                                                <option value="dod">1 x 2</option>
                                                                <option value="bid">2 x 1</option>
                                                                <option value="tid">3 x 1</option>
                                                                <option value="qid">4 x 1</option>
                                                                <option value="202">2-0-2</option>
                                                                <option value="303">3-0-3</option>
                                                            </select>
                                                            <select name="waktuobat[]" class="form-control waktuObat">
                                                                <option selected>Waktu Obat</option>
                                                                <option value="pc">Setelah Makan</option>
                                                                <option value="ac">Sebelum Makan</option>
                                                                <option value="hs">Sebelum Tidur</option>
                                                                <option value="int">Diantara Waktu Makan</option>
                                                            </select>
                                                            <input type="text" name="keterangan_obat[]"
                                                                placeholder="Keterangan Obat" class="form-control"
                                                                multiple>
                                                            <button type="button" class="btn btn-xs btn-warning">
                                                                <i class="fas fa-pills "></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="newObat"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <x-adminlte-textarea igroup-size="sm" rows=3
                                                    label="Resep Obat (Free Text)" name="resep_obat"
                                                    placeholder="Resep Obat (Text)">
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
                                        <button type="submit" class="btn btn-success mb-1 w-100 withLoad">
                                            <i class="fas fa-edit"></i> Simpan & Tanda Tangan Pemeriksaan Dokter</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- laboratorium --}}
                        @include('sim.tabel_lab')
                        {{-- resep obat --}}
                        {{-- <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collResep">
                                <h3 class="card-title">
                                    E-Resep
                                </h3>
                                <div class="card-tools">
                                    @if ($antrian->resepobat)
                                        Sudah Diresepkan Dengan Kode
                                        {{ $antrian->resepobat->kode }}
                                        {{ $antrian->resepobat->waktu }}
                                        <i class="fas fa-check-circle"></i>
                                    @else
                                        Tidak Diresepkan <i class="fas fa-times-circle"></i>
                                    @endif
                                </div>
                            </a>
                            <div id="collResep" class="collapse" role="tabpanel" aria-labelledby="headResep">
                                <div class="card-body">
                                    <style>
                                        .cariObat {
                                            width: 300px !important;
                                        }
                                    </style>
                                    <div class="row">
                                        <div class="col-md-12">
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
                                                                <select
                                                                    name="frekuensi[]"class="form-control frekuensilObat">
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
                                </div>
                            </div>
                        </div> --}}
                        {{-- radiologi --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collRad">
                                <h3 class="card-title">
                                    E-Radiologi
                                </h3>
                            </a>
                            <div id="collRad" class="collapse" role="tabpanel" aria-labelledby="headRad">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-adminlte-textarea igroup-size="sm" rows=4 label="Catatan Radiologi"
                                                name="catatan_rad" placeholder="Catatan Radiologi">
                                                {{ $kunjungan->asesmendokter->catatan_rad ?? null }}
                                            </x-adminlte-textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- review --}}
                        <div class="card card-info mb-1">
                            <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collResume"
                                aria-expanded="true" aria-controls="collResume">
                                <h3 class="card-title">
                                    Preview Resume
                                </h3>
                            </a>
                            <div id="collResume" class="collapse" role="tabpanel" aria-labelledby="headRad">
                                <div class="card-body">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
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
            </div>
        </div>
    </div>
    @include('sim.modal_cppt')
    {{-- @include('sim.modal_sbar_tbak_create') --}}
    {{-- @include('sim.modal_asesmen_perawat') --}}
    {{-- @include('sim.modal_asesmen_dokter') --}}
    @include('sim.modal_asesmen_rajal')
    @include('sim.modal_resume_rajal')
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
                placeholder: "Diagnosa Primer ICD-10",
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
                placeholder: "Diagnosa Sekunder ICD-10",
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
            $(".diagnosa").select2({
                theme: "bootstrap4",
                placeholder: "Diagnosa Klinik",
                ajax: {
                    url: "{{ route('diagnosa.search') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term // search term
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
    {{-- icare --}}
    <x-adminlte-modal id="modalICare" name="modalICare" title="I-Care JKN" theme="warning" icon="fas fa-file-medical"
        size="xl">
        <iframe src="" id="urlIcare" width="100%" height="700px" frameborder="0"></iframe>
    </x-adminlte-modal>
    {{-- tarif dan layanan --}}
    <x-adminlte-modal id="modalTarif" name="modalTarif" title="Tarif Layanan & Tindakan" theme="success"
        icon="fas fa-user-injured" size="xl">
        <form name="formInputTarif" id="formInputTarif">
            <div class="row">
                @csrf
                <input type="hidden" name="kodekunjungan" value="{{ $antrian->kodekunjungan }}">
                <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan_id }}">
                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                <input type="hidden" name="norm" value="{{ $antrian->norm }}">
                <input type="hidden" name="nama" value="{{ $antrian->nama }}">
                <div class="col-md-6">
                    <x-adminlte-select2 igroup-size="sm" name="layanan" class="layanan_tarif"
                        label="Layanan & Tindalan :" multiple>
                    </x-adminlte-select2>
                    <x-adminlte-input id="harga-tarif" name="harga" type="number" label="Harga" igroup-size="sm"
                        placeholder="Harga" readonly />
                    <x-adminlte-input id="jumlah-tarif" name="jumlah" type="number" label="Jumlah" igroup-size="sm"
                        placeholder="Jumlah" />
                    <x-adminlte-input id="diskon-tarif" name="diskon" type="number" label="Diskon" igroup-size="sm"
                        placeholder="Diskon" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-select igroup-size="sm" name="jaminan" label="Jaminan Pasien">
                        <option selected disabled>Pilih Jaminan</option>
                        @foreach ($jaminans as $key => $item)
                            <option value="{{ $key }}"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->jaminan == $key ? 'selected' : null) : null }}>
                                {{ $item }}</option>
                        @endforeach
                    </x-adminlte-select>

                </div>
            </div>
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto btnTambahTarif" theme="success" label="Tambah" />
            <x-adminlte-button class="mr-auto btnUpdateTarif" theme="warning" label="Update" />
            <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
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
            $('.tambahLayanan').click(function() {
                $('.btnUpdateTarif').hide();
                $('.btnTambahTarif').show();
                $("#formInputTarif").trigger('reset');
                $(".layanan_tarif").val(null).change();
                $('#modalTarif').modal('show');
            });
            $(".layanan_tarif").select2({
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                placeholder: "Tarif & Layanan",
                ajax: {
                    url: "{{ route('ref_tarif_layanan') }}?jenispasien={{ $antrian->jenispasien }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term // search term
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
            $('.layanan_tarif').on('select2:select', function(e) {
                var data = e.params.data;
                $("#jumlah-tarif").val(1);
                $("#harga-tarif").val(e.params.data.harga);
                $("#diskon-tarif").val(0);
                console.log(data);
            });
            $('.btnTambahTarif').click(function() {
                $.LoadingOverlay("show");
                $.ajax({
                    type: "POST",
                    url: "{{ route('input_tarif_pasien') }}",
                    data: $("#formInputTarif").serialize(),
                    dataType: "json",
                    encode: true,
                }).done(function(data) {
                    console.log(data);
                    if (data.metadata.code == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Tarif layanan & tindakan telah ditambahkan',
                        });
                        $("#formInputTarif").trigger('reset');
                        $(".layanan_tarif").val(null).change();
                        refresTableLayanan();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Tambah tarif layanan & tindakan error',
                        });
                    }
                    $.LoadingOverlay("hide");
                });
            });
            $('.btnUpdateTarif').click(function() {
                $.LoadingOverlay("show");
                $.ajax({
                    type: "POST",
                    url: "{{ route('input_tarif_pasien') }}",
                    data: $("#formInputTarif").serialize(),
                    dataType: "json",
                    encode: true,
                }).done(function(data) {
                    console.log(data);
                    if (data.metadata.code == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Tarif layanan & tindakan telah ditambahkan',
                        });
                        $("#formInputTarif").trigger('reset');
                        $(".layanan_tarif").val(null).change();
                        refresTableLayanan();
                        $('#modalTarif').modal('hide');
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Tambah tarif layanan & tindakan error',
                        });
                    }
                    $.LoadingOverlay("hide");
                });
            });
            $('.getLayananKunjungan').click(function() {
                refresTableLayanan();
            });
            refresTableLayanan();

            function refresTableLayanan() {
                var url = "{{ route('get_layanan_kunjungan') }}?kunjungan={{ $antrian->kunjungan_id }}";
                var table = $('#tableLayanan').DataTable();
                $.ajax({
                    type: "GET",
                    url: url,
                }).done(function(data) {
                    table.rows().remove().draw();
                    if (data.metadata.code == 200) {
                        $.each(data.response, function(key, value) {
                            console.log(value);
                            var btn =
                                '<button class="btn btn-xs btn-warning btnEditTarif" data-nama="' +
                                value.nama + '" data-tarifid="' + value.tarif_id +
                                '" data-harga="' +
                                value.harga +
                                '" data-jumlah="' +
                                value.jumlah +
                                '" data-diskon="' +
                                value.diskon +
                                '"><i class="fas fa-edit"></i> Edit</button> <button class="btn btn-xs btn-danger btnHapusTarif" data-id="' +
                                value.id +
                                '"><i class="fas fa-trash"></i> Hapus</button>';
                            table.row.add([
                                value.tgl_input,
                                btn,
                                value.nama,
                                value.jaminans.nama,
                                'Rp ' + value.harga.toLocaleString() + ' @ ' + value.jumlah,
                                value.diskon + ' %',
                                'Rp ' + (value.subtotal).toLocaleString(),
                            ]).draw(false);
                        });
                        $('.btnEditTarif').click(function() {
                            $("#formInputTarif").trigger('reset');
                            var option = new Option($(this).data('nama'), $(this).data('tarifid'));
                            option.selected = true;
                            $(".layanan_tarif").append(option);
                            $(".layanan_tarif").trigger("change");
                            // $(".layanan_tarif").val(null).change();
                            $('.btnUpdateTarif').show();
                            $('.btnTambahTarif').hide();
                            $("#jumlah-tarif").val($(this).data('jumlah'));
                            $("#harga-tarif").val($(this).data('harga'));
                            $("#diskon-tarif").val($(this).data('diskon'));
                            $('#modalTarif').modal('show');
                        });
                        $('.btnHapusTarif').click(function() {
                            $.LoadingOverlay("show");
                            $.ajax({
                                type: "POST",
                                url: "{{ route('delete_tarif_pasien') }}",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "tarif": tarif = $(this).data('id')
                                },
                                dataType: "json",
                                encode: true,
                            }).done(function(data) {
                                console.log(data);
                                if (data.metadata.code == 200) {
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Tarif layanan & tindakan telah dihapuskan',
                                    });
                                    $("#formInputTarif").trigger('reset');
                                    $(".layanan_tarif").val(null).change();
                                    refresTableLayanan();
                                } else {
                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Tarif layanan & tindakan gagal dihapuskan',
                                    });
                                }
                                $.LoadingOverlay("hide");
                            });
                            $.LoadingOverlay("hide");
                        });
                    } else {
                        Swal.fire(
                            'Mohon Maaf !',
                            data.metadata.message,
                            'error'
                        );
                    }
                });
            }
        });
    </script>
    {{-- file upload --}}
    @include('sim.tabel_fileupload')
    <script>
        function btnIcare() {
            $.LoadingOverlay("show");
            var url =
                "{{ route('icare') }}?nomorkartu={{ $antrian->nomorkartu }}&kodedokter={{ $antrian->kodedokter }}";
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    if (data.metadata.code == 200) {
                        $('#urlIcare').attr('src', data.response.url);
                        $('#modalICare').modal('show');
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
        }

        function btnCPPT() {
            $.LoadingOverlay("show");
            $('#modalCPPT').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnSBAR() {
            $.LoadingOverlay("show");
            $('#modalSBAR').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnPengkajianPerawat() {
            $.LoadingOverlay("show");
            $('#modalAsesmenPerawat').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnPemeriksaanDokter() {
            $.LoadingOverlay("show");
            $('#modalAsesmenDokter').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnResumeRajal() {
            $.LoadingOverlay("show");
            $('#modalResumeRajal').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnAsesmenRajal() {
            $.LoadingOverlay("show");
            $('#modalAsesmenRajal').modal('show');
            $.LoadingOverlay("hide");
        }
    </script>
    {{-- <script src="js/signature_pad.umd.js"></script> --}}
    <!-- <script src="js/app.js"></script> -->
    {{-- <script>
        const wrapper = document.getElementById("signature-pad")
        const clearButton = wrapper.querySelector("[data-action=clear]")
        const changeColorButton = wrapper.querySelector("[data-action=change-color]")
        const undoButton = wrapper.querySelector("[data-action=undo]")
        const savePNGButton = wrapper.querySelector("[data-action=save-png]")
        const saveJPGButton = wrapper.querySelector("[data-action=save-jpg]")
        const saveSVGButton = wrapper.querySelector("[data-action=save-svg]")
        const canvas = wrapper.querySelector("canvas")
        const fileSelector = document.getElementById('fileupload')

        // https://medium.com/the-everyday-developer/detect-file-mime-type-using-magic-numbers-and-javascript-16bc513d4e1e
        const verifyAndSetPictureAsBackground = (event) => {
            const file = event.target.files[0]
            const fReader = new FileReader()
            fReader.onloadend = (e) => {
                if (e.target.readyState === FileReader.DONE) {
                    const uint = new Uint8Array(e.target.result)
                    let bytes = []
                    uint.forEach((byte) => bytes.push(byte.toString(16)))
                    const hex = bytes.join('').toUpperCase()
                    if (!(getMimeType(hex) === 'image/png' || getMimeType(hex) === 'image/gif' || getMimeType(
                            hex) === 'image/jpeg')) {
                        alert('Please choose a picture(.png, .gif, or .jpeg)')
                        // https://stackoverflow.com/a/35323290/1904223
                        file = null
                        fileSelector.value = ''
                        if (!/safari/i.test(navigator.userAgent)) {
                            fileSelector.type = ''
                            fileSelector.type = 'file'
                        }
                    }
                    if (file) {
                        const dataURL = window.URL.createObjectURL(file)
                        signaturePad.fromDataURL(dataURL)
                    }
                }
            }
            fReader.readAsArrayBuffer(file.slice(0, 4))
        }

        const getMimeType = (signature) => {
            switch (signature) {
                case '89504E47':
                    return 'image/png'
                case '47494638':
                    return 'image/gif'
                case 'FFD8FFDB':
                case 'FFD8FFE0':
                case 'FFD8FFE1':
                    return 'image/jpeg'
                default:
                    return 'Not allowed filetype'
            }
        }

        fileSelector.addEventListener('change', verifyAndSetPictureAsBackground, false)

        const signaturePad = new SignaturePad(canvas, {
            // It's Necessary to use an opaque color when saving image as JPEG
            // this option can be omitted if only saving as PNG or SVG
            backgroundColor: 'rgb(255, 255, 255)'
        })

        // Adjust canvas coordinate space taking into account pixel ratio,
        // to make it look crisp on mobile devices.
        // This also causes canvas to be cleared.
        const resizeCanvas = () => {
            // When zoomed out to less than 100%, for some very strange reason,
            // some browsers report devicePixelRatio as less than 1
            // and only part of the canvas is cleared then.
            const ratio = Math.max(window.devicePixelRatio || 1, 1)

            // This part causes the canvas to be cleared
            canvas.width = canvas.offsetWidth * ratio
            canvas.height = canvas.offsetHeight * ratio
            canvas.getContext("2d").scale(ratio, ratio)

            // This library does not listen for canvas changes, so after the canvas is automatically
            // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
            // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
            // that the state of this library is consistent with visual state of the canvas, you
            // have to clear it manually.
            signaturePad.clear()
        }

        // On mobile devices it might make more sense to listen to orientation change,
        // rather than window resize events.
        window.onresize = resizeCanvas
        resizeCanvas()

        const download = (dataURL, filename) => {
            const blob = dataURLToBlob(dataURL)
            const url = window.URL.createObjectURL(blob)

            const a = document.createElement("a")
            a.style = "display: none"
            a.href = url
            a.download = filename

            document.body.appendChild(a)
            a.click()

            window.URL.revokeObjectURL(url)
        }

        // One could simply use Canvas#toBlob method instead, but it's just to show
        // that it can be done using result of SignaturePad#toDataURL.
        function dataURLToBlob(dataURL) {
            // Code taken from https://github.com/ebidel/filer.js
            const parts = dataURL.split('base64,')
            const contentType = parts[0].split(":")[1]
            const raw = window.atob(parts[1])
            const rawLength = raw.length
            const uInt8Array = new Uint8Array(rawLength)

            for (let i = 0; i < rawLength; ++i) {
                uInt8Array[i] = raw.charCodeAt(i)
            }

            return new Blob([uInt8Array], {
                type: contentType
            })
        }

        clearButton.addEventListener("click", () => signaturePad.clear())

        undoButton.addEventListener("click", () => {
            const data = signaturePad.toData()

            if (data) {
                data.pop() // remove the last dot or line
                signaturePad.fromData(data)
            }
        })

        changeColorButton.addEventListener("click", () => {
            const r = Math.round(Math.random() * 255)
            const g = Math.round(Math.random() * 255)
            const b = Math.round(Math.random() * 255)
            const color = "rgb(" + r + "," + g + "," + b + ")"

            signaturePad.penColor = color
        })

        savePNGButton.addEventListener("click", () => {
            if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.")
            } else {
                const dataURL = signaturePad.toDataURL()
                download(dataURL, "signature.png")
            }
        })

        saveJPGButton.addEventListener("click", () => {
            if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.")
            } else {
                const dataURL = signaturePad.toDataURL("image/jpeg")
                download(dataURL, "signature.jpg")
            }
        })

        saveSVGButton.addEventListener("click", () => {
            if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.")
            } else {
                const dataURL = signaturePad.toDataURL('image/svg+xml')
                download(dataURL, "signature.svg")
            }
        })
    </script> --}}
@endsection
