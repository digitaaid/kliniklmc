@extends('adminlte::page')
@section('title', 'Permintaan Pemeriksaan Laboratorium')
@section('content_header')
    <h1>Permintaan Pemeriksaan Laboratorium</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="primary" theme-mode="outline">
                {{-- <h6 class="text-center">
                    IDENTITAS PASIEN <br>
                </h6> --}}
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4 m-0">Nama</dt>
                            <dd class="col-sm-8 m-0">: {{ $permintaan->nama }} </dd>
                            <dt class="col-sm-4 m-0">No RM</dt>
                            <dd class="col-sm-8 m-0">: {{ $permintaan->norm }} </dd>
                            <dt class="col-sm-4 m-0">Tgl. Lahir</dt>
                            <dd class="col-sm-8 m-0">: {{ $permintaan->pasien->tgl_lahir }} </dd>
                            <dt class="col-sm-4 m-0">Jenis Kelamin</dt>
                            <dd class="col-sm-8 m-0">: {{ $permintaan->pasien->gender }} </dd>
                            <dt class="col-sm-4 m-0">Diagnosa</dt>
                            <dd class="col-sm-8 m-0">: {{ $permintaan->diagnosa }} </dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4 m-0">Dokter</dt>
                            <dd class="col-sm-8 m-0">: {{ $permintaan->dpjp }} </dd>
                            <dt class="col-sm-4 m-0">Alamat</dt>
                            <dd class="col-sm-8 m-0">: Klinik LMC </dd>
                            <dt class="col-sm-4 m-0">Tgl Pemeriksaan</dt>
                            <dd class="col-sm-8 m-0">: {{ $permintaan->waktu }} </dd>
                        </dl>
                    </div>
                </div>
            </x-adminlte-card>
            <x-adminlte-card theme="primary" theme-mode="outline">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Nama Pemeriksaan</th>
                            <th>Hasil</th>
                            <th>Nilai Rujukan</th>
                            <th>Satuan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemeriksaan as $item)
                            <tr>
                                <td><b>{{ $item->nama }}</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-adminlte-card>

        </div>

    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Select2', true)
