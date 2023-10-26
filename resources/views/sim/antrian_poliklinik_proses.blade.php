@extends('adminlte::page')
@section('title', 'Assesmen Dokter')
@section('content_header')
    <h1>Assesmen Dokter</h1>
@stop
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
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#keperawatantab"
                                data-toggle="tab">Keperawatan</a>
                        </li>
                        <li class="nav-item"><a class="nav-link " href="#riwayattab" data-toggle="tab">Riwayat</a>
                        </li>
                        <li class="nav-item"><a class="nav-link " href="#filepenunjangtab" data-toggle="tab">File
                                Penunjang</a>
                        </li>
                        <li class="nav-item"><a class="nav-link " href="#labtab" data-toggle="tab">Laboratorium</a>
                        </li>
                        <li class="nav-item"><a class="nav-link " href="#radtab" data-toggle="tab">Radiologi</a>
                        </li>

                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="keperawatantab">
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
                        <div class="tab-pane" id="riwayattab">
                            @if ($antrian->pasien)
                                @foreach ($antrian->pasien->kunjungans as $kunjungan)
                                    <x-adminlte-card title="KUNJUNGAN {{ $kunjungan->tgl_masuk }}" theme="info"
                                        icon="fas fa-file" collapsible="collapsed">
                                        @if ($kunjungan->asesmendokter)
                                            @include('form.asesmen_dokter_rajal')
                                        @else
                                            <x-adminlte-alert title="Belum dilakukan asesmen dokter" theme="danger">
                                                Silahkan lakukan asesmen dokter
                                            </x-adminlte-alert>
                                        @endif
                                    </x-adminlte-card>
                                @endforeach
                            @else
                                Belum ada riwayat pasien
                            @endif
                        </div>
                        <div class="tab-pane" id="filepenunjangtab">
                            @if ($antrian->pasien)
                                @if ($antrian->pasien->fileuploads)
                                    @foreach ($antrian->pasien->fileuploads as $file)
                                        <x-adminlte-card title="{{ $file->nama }}" theme="info" icon="fas fa-file"
                                            collapsible="collapsed">
                                            <a href="{{ $file->fileurl }}" target="_blank"
                                                class="btn btn-xs btn-primary mr-1 mb-1">Donwload</a>
                                            <a href="{{ route('hapusfilepenunjang') }}?id={{ $file->id }}"
                                                class="btn btn-xs btn-danger mr-1 mb-1">Hapus File</a>
                                            Diupload pada tanggal : {{ $file->created_at }}
                                            <br>
                                            <object data="{{ $file->fileurl }}" width="100%" height="700px"> </object>
                                        </x-adminlte-card>
                                    @endforeach
                                @endif
                            @else
                                @foreach ($antrian->fileuploads as $file)
                                    <x-adminlte-card title="{{ $file->nama }} {{ $file->created_at }}" theme="info"
                                        icon="fas fa-file" collapsible="collapsed">
                                        <a href="{{ $file->fileurl }}" target="_blank"
                                            class="btn btn-xs btn-primary mr-1 mb-1">Donwload</a>
                                        <a href="{{ route('hapusfilepenunjang') }}?id={{ $file->id }}"
                                            class="btn btn-xs btn-danger mr-1 mb-1">Hapus File</a>
                                        Diupload pada tanggal : {{ $file->created_at }}
                                        <br>
                                        <object data="{{ $file->fileurl }}" width="100%" height="700px"> </object>
                                    </x-adminlte-card>
                                @endforeach
                            @endif
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
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#doktertab" data-toggle="tab">Dokter</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#resumetab" data-toggle="tab">Resume</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="doktertab">
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
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Diagnosa" name="diagnosa"
                                            placeholder="Diagnosa">
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
                                                {{-- test detail <br> --}}
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <audio id="myAudio">
        <source src="{{ asset('tingtung.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
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

@endsection
