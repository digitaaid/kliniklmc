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
                        @include('sim.tabel_filepenunjang')
                        {{-- perawat --}}
                        @include('sim.tabel_anamnesa_perawat')
                        <form action="{{ route('editasesmendokter') }}" method="POST">
                            @csrf
                            {{-- dokter --}}
                            <div class="card card-info mb-1">
                                <a class="card-header" data-toggle="collapse" data-parent="#accordion"
                                    href="#collapseDokter">
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
                                                <x-adminlte-textarea igroup-size="sm" rows=3 label="Catatan Dokter"
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
                                <style>
                                    .cariObat {
                                        width: 300px !important;
                                    }
                                </style>
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
                            {{-- laboratorium --}}
                            <div class="card card-info mb-1">
                                <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collLab">
                                    <h3 class="card-title">
                                        E-Laboratorium
                                    </h3>
                                </a>
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
                                <a class="card-header" data-toggle="collapse" data-parent="#accordion"
                                    href="#collResume" aria-expanded="true" aria-controls="collResume">
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
