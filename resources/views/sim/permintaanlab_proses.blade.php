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
                            <dd class="col-sm-8 m-0">: {{ $permintaan->pasien->tgl_lahir ?? '-' }} </dd>
                            <dt class="col-sm-4 m-0">Jenis Kelamin</dt>
                            <dd class="col-sm-8 m-0">: {{ $permintaan->pasien->gender ?? '-' }} </dd>
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
                <form action="{{ route('permintaanlab_hasil') }}" method="POST">
                    @csrf
                    <input type="hidden" name="kodepermintaan" value="{{ $permintaan->kode }}">
                    <input type="hidden" name="permintaanlab_id" value="{{ $permintaan->id }}">
                    <table class="table table-sm  table-hover">
                        <thead class="bg-secondary">
                            <tr>
                                <th>Nama Pemeriksaan</th>
                                <th>Hasil</th>
                                <th>Nilai Rujukan</th>
                                <th>Satuan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $key = 0;
                            @endphp
                            @foreach ($pemeriksaan as $prksa)
                                <tr>
                                    <td><b>{{ $prksa->nama }}</b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @foreach ($prksa->parameters as $param)
                                    <tr>
                                        <input type="hidden" name="parameter_id[]" value="{{ $param->id }}">
                                        <td>&emsp;&emsp;{{ $param->nama }}</td>
                                        <td> <input class="w-100" type="text" name="hasil[]" id="hasil"
                                                value="{{ $hasillab->hasil[$key] ?? null }}"></td>
                                        <td>{{ $param->nilai_rujukan }}</td>
                                        <td>{{ $param->satuan }}</td>
                                        <td> <input class="w-100" type="text" name="keterangan[]"
                                                value="{{ $hasillab->keterangan[$key] ?? '-' }}" id="hasil"></td>
                                    </tr>
                                    @php
                                        $key++;
                                    @endphp
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                    <a href="{{ route('permintaanlab_hasil_print') }}?kode={{ $permintaan->kode }}"
                        class="btn btn-warning" target="_blank"><i class="fas fa-print"></i> Print</a>
                </form>
            </x-adminlte-card>

        </div>

    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Select2', true)
