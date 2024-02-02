@extends('adminlte::page')
@section('title', 'Laporan Resep Obat')
@section('content_header')
    <h1>Laporan Resep Obat</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Data Resep Obat" theme="secondary" icon="fas fa-info-circle" collapsible>
                <div class="row">
                    <div class="col-md-5">
                        <form action="" method="get">
                            @php
                                $config = [
                                    'timePicker' => false,
                                    'locale' => ['format' => 'YYYY/MM/DD'],
                                ];
                            @endphp
                            <x-adminlte-date-range name="tanggal" value="{{ $request->tanggal }}" :config="$config"
                                label="Periode Tanggal" fgroup-class="row" label-class="text-right col-3" igroup-size="sm"
                                igroup-class="col-9">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text text-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" theme="primary" label="Cari" />
                                </x-slot>
                            </x-adminlte-date-range>
                        </form>
                    </div>
                    <div class="col-md-7">
                    </div>
                </div>
                @php
                    $heads = ['Tanggal', 'Kode', 'No RM', 'Nama', 'Jenis', 'Dokter', 'Action'];
                    $config['order'] = [1, 'asc'];
                    $config['paging'] = false;
                    $config['scrollY'] = '300px';
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered hoverable
                    compressed>
                    @if (isset($reseps))
                        @foreach ($reseps as $key => $item)
                            <tr>
                                <td>{{ $item->antrian->tanggalperiksa }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->antrian->norm }}</td>
                                <td>{{ $item->antrian->nama }}</td>
                                <td>{{ $item->antrian->jenispasien }}</td>
                                <td>{{ $item->antrian->namadokter }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endif
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
        {{-- @if (isset($obats))
            <div class="col-md-12">
                <x-adminlte-card title="Data Pemesanan Obat" theme="warning" icon="fas fa-info-circle" collapsible>
                    @php
                        $heads = ['No', 'Nama', 'Jumlah'];
                        $config['order'] = [1, 'asc'];
                        $config['paging'] = false;
                        $config['scrollY'] = '300px';
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($obats as $key => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $key }}</td>
                                <td>{{ $item->sum('jumlah') }}</td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
            </div>
        @endif --}}
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Select2', true)
