@extends('adminlte::page')
@section('title', 'Antrian Pasien')
@section('content_header')
    <h1>Antrian Pasien</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Filter Data Antrian" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tanggalperiksa" label="Tanggal Laporan"
                                value="{{ $request->tanggalperiksa }}" placeholder="Pilih Tanggal" :config="$config">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Antrian" />
                </form>
            </x-adminlte-card>
        </div>
        <div class="col-md-12">
            <x-adminlte-card title="Data Antrian" theme="primary" icon="fas fa-info-circle" collapsible>
                @php
                    $heads = ['No Antrian', 'kodebooking', 'Pasien', 'Dokter', 'Poliklinik', 'Jenis Pasien', 'Status', 'Action'];
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" bordered hoverable compressed>
                    @if (isset($antrians))
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $item->nomorantrean }} / {{ $item->angkaantrean }}</td>
                                <td>{{ $item->kodebooking }}</td>
                                <td>{{ $item->norm }} {{ $item->nama }}</td>
                                <td>{{ $item->namadokter }}</td>
                                <td>{{ $item->namapoli }}</td>
                                <td>{{ $item->pasienbaru }}</td>
                                <td>{{ $item->taskid }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endif
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
