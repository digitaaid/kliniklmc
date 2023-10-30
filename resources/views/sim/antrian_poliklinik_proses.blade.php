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
            <div class="card card-primary card-outline">
                <div class="card-body box-profile p-3" style="overflow-y: auto ;max-height: 600px ;">
                    <div id="accordion" role="tablist" aria-multiselectable="true">

                        {{-- riwayatpasien --}}
                        @include('sim.tabel_riwayat_pasien')
                        {{-- icare --}}
                        @include('sim.tabel_icare')
                        {{-- filepenunjang --}}
                        <div class="card card-info mb-1">
                            <div class="card-header" role="tab" id="headFile">
                                <h3 class="card-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFile"
                                        aria-expanded="true" aria-controls="collapseFile">
                                        File Penunjang ({{ $antrian->pasien->fileuploads->count() }} Berkas)
                                    </a>
                                </h3>
                            </div>
                            <div id="collapseFile" class="collapse" role="tabpanel" aria-labelledby="headFile">
                                <div class="card-body">
                                    <form action="{{ route('uploadpenunjang') }}" name="formFile" id="formFile"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                                        <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                                        <input type="hidden" name="kodekunjungan"
                                            value="{{ $antrian->kunjungan->kode ?? null }}">
                                        <input type="hidden" name="kunjungan_id"
                                            value="{{ $antrian->kunjungan->id ?? null }}">
                                        <input type="hidden" name="norm" value="{{ $antrian->norm ?? null }}">
                                        <input type="hidden" name="namapasien" value="{{ $antrian->nama ?? null }}">
                                        <x-adminlte-input name="nama" placeholder="Nama / Keterangan File"
                                            igroup-size="sm" label="Nama File" enable-old-support required />
                                        <x-adminlte-input-file name="file" placeholder="Pilih file yang akan diupload"
                                            igroup-size="sm" label="Upload Image" />
                                        <button type="submit" form="formFile" class="btn btn-success">
                                            <i class="fas fa-upload"></i> Upload
                                        </button>
                                    </form>
                                    <style>
                                        .card.card-tabs .card-tools {
                                            margin: 0px !important;
                                        }
                                    </style>
                                    @if ($antrian->pasien)
                                        @if ($antrian->pasien->fileuploads)
                                            <hr>
                                            <div class="row">
                                                @foreach ($antrian->pasien->fileuploads as $file)
                                                    <div class="col-md-6">
                                                        <x-adminlte-card header-class="p-2" body-class="p-0"
                                                            title="{{ $file->nama }}" theme="secondary"
                                                            icon="fas fa-file" collapsible="">
                                                            <x-slot name="toolsSlot">
                                                                Uploaded at : {{ $file->created_at }}
                                                                <a href="{{ $file->fileurl }}" target="_blank"
                                                                    class="btn btn-xs btn-tool"><i
                                                                        class="fas fa-download"></i></a>
                                                                <a href="{{ route('hapusfilepenunjang') }}?id={{ $file->id }}"
                                                                    class="btn btn-xs btn-tool"> <i
                                                                        class="fas fa-trash"></i></a>
                                                            </x-slot>
                                                            <object data="{{ $file->fileurl }}" width="100%"
                                                                height="500px">
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
                                                    <a href="{{ $file->fileurl }}" target="_blank"
                                                        class="btn btn-xs btn-tool"><i class="fas fa-download"></i></a>
                                                    <a href="{{ route('hapusfilepenunjang') }}?id={{ $file->id }}"
                                                        class="btn btn-xs btn-tool"> <i class="fas fa-trash"></i></a>
                                                </x-slot>
                                                <object data="{{ $file->fileurl }}" width="100%" height="500px">
                                                </object>
                                            </x-adminlte-card>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- perawat --}}
                        <div class="card card-info mb-1">
                            <div class="card-header" role="tab" id="headingTwo">
                                <h3 class="card-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"
                                        aria-expanded="true" aria-controls="collapseTwo">
                                        Anamnesa Keperawatan
                                        @if ($antrian->asesmenperawat)
                                            <i class="fas fa-check-circle"></i> Sudah Diisi Oleh
                                            {{ $antrian->asesmenperawat->pic->name }}
                                            {{ $antrian->asesmenperawat->created_at }}
                                        @else
                                            <i class="fas fa-times-circle"></i> Belum Diisi
                                        @endif
                                    </a>
                                </h3>
                            </div>
                            <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="card-body">
                                    <form action="{{ route('editasesmenperawat') }}" name="formPerawat" id="formPerawat"
                                        method="POST">
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
                                                    {{ $antrian->asesmenperawat->keluhan_utama ?? null }}
                                                </x-adminlte-textarea>
                                                {{-- {{ dd($antrian->asesmenperawat) }} --}}
                                                <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Penyakit"
                                                    name="riwayat_penyakit" placeholder="Riwayat Penyakit">
                                                    {{ $antrian->asesmenperawat->riwayat_penyakit ?? null }}
                                                </x-adminlte-textarea>
                                                <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Alergi"
                                                    name="riwayat_alergi" placeholder="Riwayat Alergi">
                                                    {{ $antrian->asesmenperawat->riwayat_alergi ?? null }}
                                                </x-adminlte-textarea>
                                                <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Pengobatan"
                                                    name="riwayat_pengobatan" placeholder="Riwayat Pengobatan">
                                                    {{ $antrian->asesmenperawat->riwayat_pengobatan ?? null }}
                                                </x-adminlte-textarea>
                                                <x-adminlte-textarea igroup-size="sm" rows=2 label="Status Psikologi"
                                                    name="status_psikologi" placeholder="Status Psikologi">
                                                    {{ $antrian->asesmenperawat->status_psikologi ?? null }}
                                                </x-adminlte-textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <x-adminlte-input name="denyut_jantung" fgroup-class="col-md-6"
                                                        label="Denyut Jantung (spm)" igroup-size="sm" type="number"
                                                        placeholder="Denyut Jantung (spm)"
                                                        value="{{ $antrian->asesmenperawat->denyut_jantung ?? null }}" />
                                                    <x-adminlte-input name="pernapasan" fgroup-class="col-md-6"
                                                        label="Pernapasan (spm)" igroup-size="sm"
                                                        placeholder="Pernapasan (spm)" type="number"
                                                        value="{{ $antrian->asesmenperawat->pernapasan ?? null }}" />
                                                    <x-adminlte-input name="sistole" fgroup-class="col-md-6"
                                                        label="Sistole" igroup-size="sm" placeholder="Sistole"
                                                        type="number"
                                                        value="{{ $antrian->asesmenperawat->sistole ?? null }}" />
                                                    <x-adminlte-input name="distole" fgroup-class="col-md-6"
                                                        label="Diastole" igroup-size="sm" placeholder="Diastole"
                                                        type="number"
                                                        value="{{ $antrian->asesmenperawat->distole ?? null }}" />
                                                    <x-adminlte-input name="suhu" fgroup-class="col-md-6"
                                                        label="Suhu Tubuh (celcius)" igroup-size="sm"
                                                        placeholder="Suhu Tubuh (celcius)"
                                                        value="{{ $antrian->asesmenperawat->suhu ?? null }}" />
                                                    <x-adminlte-input name="berat_badan" fgroup-class="col-md-6"
                                                        label="Berat Badan (kg)" igroup-size="sm"
                                                        placeholder="Berat Badan (kg)" type="number"
                                                        value="{{ $antrian->asesmenperawat->berat_badan ?? null }}" />
                                                    <x-adminlte-input name="tinggi_badan" fgroup-class="col-md-6"
                                                        type="number" label="Tinggi Badan (cm)" igroup-size="sm"
                                                        placeholder="Tinggi Badan (cm)"
                                                        value="{{ $antrian->asesmenperawat->tinggi_badan ?? null }}" />
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio"
                                                            id="kesadaran1" name="tingkat_kesadaran" value="1"
                                                            {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 1 ? 'checked' : null) : null }}>
                                                        <label for="kesadaran1" class="custom-control-label">Sadar
                                                            baik</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio"
                                                            id="kesadaran2" name="tingkat_kesadaran" value="2"
                                                            {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 2 ? 'checked' : null) : null }}>
                                                        <label for="kesadaran2" class="custom-control-label">Berespon
                                                            dengan
                                                            kata-kata</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio"
                                                            id="kesadaran3" name="tingkat_kesadaran" value="3"
                                                            {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 3 ? 'checked' : null) : null }}>
                                                        <label for="kesadaran3" class="custom-control-label">Hanya
                                                            berespons jika
                                                            dirangsang nyeri/pain</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio"
                                                            id="kesadaran4" name="tingkat_kesadaran" value="4"
                                                            {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 4 ? 'checked' : null) : null }}>
                                                        <label for="kesadaran4" class="custom-control-label">Pasien tidak
                                                            sadar/unresponsive </label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio"
                                                            id="kesadaran5" name="tingkat_kesadaran" value="5"
                                                            {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 5 ? 'checked' : null) : null }}>
                                                        <label for="kesadaran5" class="custom-control-label">Gelisah /
                                                            bingung</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio"
                                                            id="kesadaran6" name="tingkat_kesadaran" value="6"
                                                            {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 6 ? 'checked' : null) : null }}>
                                                        <label for="kesadaran6" class="custom-control-label">Acute
                                                            Confusional
                                                            State</label>
                                                    </div>
                                                </div>
                                                <x-adminlte-textarea igroup-size="sm" rows=4 label="Tanda Vital Tubuh"
                                                    name="keadaan_tubuh" placeholder="Tanda Vital Tubuh">
                                                    {{ $antrian->asesmenperawat->keadaan_tubuh ?? null }}
                                                </x-adminlte-textarea>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <button type="submit" form="formPerawat" class="btn btn-success mb-1 w-100 withLoad">
                                <i class="fas fa-edit"></i> Simpan & Tanda Tangan Pemeriksaan Perawat
                            </button>
                        </div>
                        {{-- dokter --}}
                        <form action="{{ route('editasesmendokter') }}" method="POST">
                            @csrf
                            <div class="card card-info mb-1">
                                <div class="card-header" role="tab" id="headDokter">
                                    <h3 class="card-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseDokter"
                                            aria-expanded="true" aria-controls="collapseDokter">
                                            Pemeriksaan Dokter
                                            @if ($antrian->asesmendokter)
                                                <i class="fas fa-check-circle"></i> Sudah Diisi Oleh
                                                {{ $antrian->asesmendokter->pic->name }}
                                                {{ $antrian->asesmendokter->created_at }}
                                            @else
                                                <i class="fas fa-times-circle"></i> Belum Diisi
                                            @endif
                                        </a>
                                    </h3>
                                </div>
                                <div id="collapseDokter" class="collapse" role="tabpanel" aria-labelledby="headDokter">
                                    <div class="card-body">
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
                                                {{-- <x-adminlte-textarea igroup-size="sm" rows=3 label="Diagnosa"
                                                    id="diagnosaauto" name="diagnosa" placeholder="Diagnosa">
                                                    {{ $kunjungan->asesmendokter->diagnosa ?? null }}
                                                </x-adminlte-textarea> --}}
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
                                    </div>
                                </div>
                            </div>
                            {{-- resep obat --}}
                            <div class="card card-info mb-1">
                                <div class="card-header" role="tab" id="headResep">
                                    <h3 class="card-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collResep"
                                            aria-expanded="true" aria-controls="collResep">
                                            E-Resep
                                            @if ($antrian->resepobat)
                                                <i class="fas fa-check-circle"></i> Sudah Diresepkan Dengan Kode
                                                {{ $antrian->resepobat->kode }}
                                                {{ $antrian->resepobat->waktu }}
                                            @else
                                                <i class="fas fa-times-circle"></i> Tidak Diresepkan
                                            @endif
                                        </a>
                                    </h3>
                                </div>
                                <div id="collResep" class="collapse" role="tabpanel" aria-labelledby="headResep">
                                    <div class="card-body">
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
                                    </div>
                                </div>
                            </div>
                            <div class="card card-info mb-1">
                                <div class="card-header" role="tab" id="headLab">
                                    <h3 class="card-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collLab"
                                            aria-expanded="true" aria-controls="collLab">
                                            E-Laboratorium
                                        </a>
                                    </h3>
                                </div>
                                <div id="collLab" class="collapse" role="tabpanel" aria-labelledby="headLab">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-adminlte-textarea igroup-size="sm" rows=4 label="Catatan Laboratorium"
                                                    name="catatan_lab" placeholder="Catatan Laboratorium">
                                                    {{ $kunjungan->asesmendokter->catatan_lab ?? null }}
                                                </x-adminlte-textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-info mb-1">
                                <div class="card-header" role="tab" id="headRad">
                                    <h3 class="card-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collRad"
                                            aria-expanded="true" aria-controls="collRad">
                                            E-Radiologi
                                        </a>
                                    </h3>
                                </div>
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
                            <div class="card card-info mb-1">
                                <div class="card-header" role="tab" id="headRad">
                                    <h3 class="card-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collResume"
                                            aria-expanded="true" aria-controls="collResume">
                                            Preview Resume
                                        </a>
                                    </h3>
                                </div>
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
                            <button type="submit" class="btn btn-success mb-1 w-100 withLoad">
                                <i class="fas fa-edit"></i> Simpan & Tanda Tangan Pemeriksaan Dokter</button>
                        </form>
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
            $(".diagnosa").select2({
                theme: "bootstrap4",
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
    <script>
        $(function() {
            $('.btnFilePenunjang').click(function() {
                $('#dataFilePenunjang').attr('src', $(this).data('fileurl'));
                $('#urlFilePenunjang').attr('href', $(this).data('fileurl'));
                $('#modalFilePenunjang').modal('show');
            });
        });
    </script>
@endsection
