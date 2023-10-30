@extends('adminlte::page')
@section('title', 'Antrian Perawat')
@section('content_header')
    <h1>Antrian Perawat</h1>
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
            <a href="{{ route('antrianperawat') }}?tanggalperiksa={{ $antrian->tanggalperiksa }}"
                class="btn btn-danger mb-2 mr-1 withLoad">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div class="btn btn-{{ $antrian->asesmenperawat ? 'success' : 'secondary' }} mb-2 mr-1">
                <i class="fas fa-info-circle"></i>
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
                        <div class="card card-info mb-1">
                            <div class="card-header" role="tab" id="headingOne">
                                <h3 class="card-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                        aria-expanded="true" aria-controls="collapseOne">
                                        Riwayat Pasien ({{ $antrian->pasien->kunjungans->count() }} Kunjungan)
                                    </a>
                                </h3>
                            </div>
                            <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="card-body">
                                    @include('sim.tabel_riwayat_pasien')
                                </div>
                            </div>
                        </div>
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
                                                <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Pengobatan"
                                                    name="riwayat_pengobatan" placeholder="Riwayat Pengobatan">
                                                    {{ $antrian->asesmenperawat->riwayat_pengobatan ?? null }}
                                                </x-adminlte-textarea>
                                                <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Penyakit"
                                                    name="riwayat_penyakit" placeholder="Riwayat Penyakit">
                                                    {{ $antrian->asesmenperawat->riwayat_penyakit ?? null }}
                                                </x-adminlte-textarea>
                                                <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Alergi"
                                                    name="riwayat_alergi" placeholder="Riwayat Alergi">
                                                    {{ $antrian->asesmenperawat->riwayat_alergi ?? null }}
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
                                    <button type="submit" form="formPerawat" class="btn btn-success w-100 withLoad">
                                        <i class="fas fa-edit"></i> Simpan & Tanda Tangan Pemeriksaan Perawat
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{-- resume --}}
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

                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('antrianperawat') }}?tanggalperiksa={{ $antrian->tanggalperiksa }}"
                        class="btn btn-success mb-2 mr-1 withLoad">
                        <i class="fas fa-arrow-left"></i> Selesai & Kembali
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
@section('plugins.BsCustomFileInput', true)
@section('js')
    <script>
        $(function() {
            $('.btnFilePenunjang').click(function() {
                $('#dataFilePenunjang').attr('src', $(this).data('fileurl'));
                $('#modalFilePenunjang').modal('show');
            });
        });
    </script>
@endsection
