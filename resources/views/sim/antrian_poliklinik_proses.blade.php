@extends('adminlte::page')
@section('title', 'Assesmen Dokter')
@section('content_header')
    <h1>Assesmen Dokter</h1>
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
            <a href="{{ route('antrianpoliklinik') }}?tanggalperiksa={{ $antrian->tanggalperiksa }}"
                class="btn btn-danger mb-2 mr-1 withLoad">
                <i class="fas fa-arrow-left"></i> Kembali
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
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#keperawatantab"
                                data-toggle="tab">Keperawatan</a>
                        </li>
                        <li class="nav-item"><a class="nav-link " href="#riwayattab" data-toggle="tab">Riwayat</a>
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
                            @if ($kunjungan)
                                @if ($kunjungan->asesmenperawat)
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
                        <div class="tab-pane" id="riwayattab">
                            Riwayat Kunjungan
                        </div>
                        <div class="tab-pane" id="riwayattab">
                            Laboratorium
                        </div>
                        <div class="tab-pane" id="riwayattab">
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
                                <input type="hidden" name="kodekunjungan" value="{{ $antrian->kunjungan->kode ?? null }}">
                                <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan->id ?? null }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-adminlte-select2 name="diagnosa1" class="diagnosaid1"
                                            label="Diagnosa Primer : {{ $kunjungan->asesmendokter->diagnosa1 ?? null }}">
                                        </x-adminlte-select2>
                                        <x-adminlte-select2 name="diagnosa2[]" class="diagnosaid2"
                                            label="Diagnosa Sekunder  : {{ $kunjungan->asesmendokter->diagnosa2 ?? null }}"
                                            multiple>
                                        </x-adminlte-select2>
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Riwayat Pengobatan"
                                            name="riwayat_pengobatan" placeholder="Riwayat Pengobatan">
                                            {{ $kunjungan->asesmendokter->riwayat_pengobatan ?? null }}
                                        </x-adminlte-textarea>
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Rencana Perawatan"
                                            name="rencana_perawatan" placeholder="Rencana Perawatan">
                                            {{ $kunjungan->asesmendokter->rencana_perawatan ?? null }}
                                        </x-adminlte-textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Instruksi Medis"
                                            name="instruksi_medis" placeholder="Instruksi Medis">
                                            {{ $kunjungan->asesmendokter->instruksi_medis ?? null }}
                                        </x-adminlte-textarea>
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Tindakan Medis"
                                            name="tindakan_medis" placeholder="Tindakan Medis">
                                            {{ $kunjungan->asesmendokter->tindakan_medis ?? null }}
                                        </x-adminlte-textarea>
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Resep Obat" name="resep_obat"
                                            placeholder="Resep Obat">
                                            {{ $kunjungan->asesmendokter->resep_obat ?? null }}
                                        </x-adminlte-textarea>
                                        <x-adminlte-textarea igroup-size="sm" rows=3 label="Catatan Resep"
                                            name="catatan_resep" placeholder="Catatan Resep">
                                            {{ $kunjungan->asesmendokter->catatan_resep ?? null }}
                                        </x-adminlte-textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-adminlte-textarea igroup-size="sm" rows=2 label="Catatan Laboratorium"
                                            name="catatan_lab" placeholder="Catatan Laboratorium">
                                            {{ $kunjungan->asesmendokter->catatan_lab ?? null }}
                                        </x-adminlte-textarea>
                                        <x-adminlte-textarea igroup-size="sm" rows=2 label="Catatan Radiologi"
                                            name="catatan_rad" placeholder="Catatan Radiologi">
                                            {{ $kunjungan->asesmendokter->catatan_rad ?? null }}
                                        </x-adminlte-textarea>
                                    </div>
                                    <div class="col-md-6">
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
        });
    </script>

@endsection
