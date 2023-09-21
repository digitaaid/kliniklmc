@extends('adminlte::page')
@section('title', 'Antrian Perawat')
@section('content_header')
    <h1>Antrian Perawat</h1>
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
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#keperawatantab"
                                data-toggle="tab">Keperawatan</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#resumetab" data-toggle="tab">Resume</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="keperawatantab">
                            <form action="{{ route('editasesmenperawat') }}" method="POST">
                                @csrf
                                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                                <input type="hidden" name="kodekunjungan" value="{{ $antrian->kunjungan->kode ?? null }}">
                                <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan->id ?? null }}">
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
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <x-adminlte-input name="denyut_jantung" fgroup-class="col-md-6"
                                                label="Denyut Jantung (spm)" igroup-size="sm"
                                                placeholder="Denyut Jantung (spm)"
                                                value="{{ $antrian->asesmenperawat->denyut_jantung ?? null }}" />
                                            <x-adminlte-input name="pernapasan" fgroup-class="col-md-6"
                                                label="Pernapasan (spm)" igroup-size="sm" placeholder="Pernapasan (spm)"
                                                value="{{ $antrian->asesmenperawat->pernapasan ?? null }}" />
                                            <x-adminlte-input name="sistole" fgroup-class="col-md-6" label="Sistole"
                                                igroup-size="sm" placeholder="Sistole"
                                                value="{{ $antrian->asesmenperawat->sistole ?? null }}" />
                                            <x-adminlte-input name="distole" fgroup-class="col-md-6" label="Distole"
                                                igroup-size="sm" placeholder="Distole"
                                                value="{{ $antrian->asesmenperawat->distole ?? null }}" />
                                            <x-adminlte-input name="suhu" fgroup-class="col-md-6"
                                                label="Suhu Tubuh (celcius)" igroup-size="sm"
                                                placeholder="Suhu Tubuh (celcius)"
                                                value="{{ $antrian->asesmenperawat->suhu ?? null }}" />
                                            <x-adminlte-input name="berat_badan" fgroup-class="col-md-6"
                                                label="Berat Badan (kg)" igroup-size="sm" placeholder="Berat Badan (kg)"
                                                value="{{ $antrian->asesmenperawat->berat_badan ?? null }}" />
                                            <x-adminlte-input name="tinggi_badan" fgroup-class="col-md-6"
                                                label="Tinggi Badan (cm)" igroup-size="sm" placeholder="Tinggi Badan (cm)"
                                                value="{{ $antrian->asesmenperawat->tinggi_badan ?? null }}" />
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kesadaran1"
                                                    name="tingkat_kesadaran" value="1"
                                                    {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 1 ? 'checked' : null) : null }}>
                                                <label for="kesadaran1" class="custom-control-label">Sadar baik</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kesadaran2"
                                                    name="tingkat_kesadaran" value="2"
                                                    {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 2 ? 'checked' : null) : null }}>
                                                <label for="kesadaran2" class="custom-control-label">Berespon dengan
                                                    kata-kata</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kesadaran3"
                                                    name="tingkat_kesadaran" value="3"
                                                    {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 3 ? 'checked' : null) : null }}>
                                                <label for="kesadaran3" class="custom-control-label">Hanya berespons jika
                                                    dirangsang nyeri/pain</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kesadaran4"
                                                    name="tingkat_kesadaran" value="4"
                                                    {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 4 ? 'checked' : null) : null }}>
                                                <label for="kesadaran4" class="custom-control-label">Pasien tidak
                                                    sadar/unresponsive </label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kesadaran5"
                                                    name="tingkat_kesadaran" value="5"
                                                    {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 5 ? 'checked' : null) : null }}>
                                                <label for="kesadaran5" class="custom-control-label">Gelisah /
                                                    bingung</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="kesadaran6"
                                                    name="tingkat_kesadaran" value="6"
                                                    {{ $antrian->asesmenperawat ? ($antrian->asesmenperawat->tingkat_kesadaran == 6 ? 'checked' : null) : null }}>
                                                <label for="kesadaran6" class="custom-control-label">Acute Confusional
                                                    State</label>
                                            </div>
                                        </div>
                                        <x-adminlte-textarea igroup-size="sm" rows=4 label="Tanda Vital Keadaan Tubuh"
                                            name="keadaan_tubuh" placeholder="Tanda Vital Fisik">
                                            {{ $antrian->asesmenperawat->keadaan_tubuh ?? null }}
                                        </x-adminlte-textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-adminlte-textarea igroup-size="sm" rows=2 label="Status Psikologi"
                                            name="status_psikologi" placeholder="Status Psikologi">
                                            {{ $antrian->asesmenperawat->status_psikologi ?? null }}
                                        </x-adminlte-textarea>
                                        <x-adminlte-textarea igroup-size="sm" rows=2 label="Status Sosial"
                                            name="status_sosial" placeholder="Status Sosial">
                                            {{ $antrian->asesmenperawat->status_sosial ?? null }}
                                        </x-adminlte-textarea>
                                        <x-adminlte-textarea igroup-size="sm" rows=2 label="Status Spiritual"
                                            name="status_spiritual" placeholder="Status Spiritual">
                                            {{ $antrian->asesmenperawat->status_spiritual ?? null }}
                                        </x-adminlte-textarea>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success withLoad">
                                    <i class="fas fa-file-medical"></i> Simpan Assesmen Keperawatan
                                </button>
                            </form>
                        </div>
                        <div class="tab-pane" id="resumetab">
                            @if ($kunjungan)
                                @if ($antrian->asesmenperawat)
                                    <div id="printMe">
                                        @include('form.asesmen_perawat_rajal')
                                    </div>
                                @else
                                    <x-adminlte-alert title="Belum dilakukan asesmen perawat" theme="danger">
                                        Silahkan lakukan asesmen perawat
                                    </x-adminlte-alert>
                                @endif
                            @endif
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

@endsection
