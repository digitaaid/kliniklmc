@extends('adminlte::page')
@section('title', 'Laporan Perawat')
@section('content_header')
    <h1>Laporan Perawat</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Filter Data Antrian" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-12">

                            @php
                                $config = [
                                    'timePicker' => false,
                                    'locale' => ['format' => 'YYYY/MM/DD'],
                                ];
                            @endphp
                            <x-adminlte-date-range name="tanggal" :config="$config" label="Periode Tanggal" />
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Antrian" />
                </form>
            </x-adminlte-card>
        </div>
        @if (isset($antrians))
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $antrians->where('taskid', '!=', 99)->count() }}"
                            text="Total Antrian" theme="success" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('jenispasien', 'JKN')->where('taskid', '!=', 99)->count() }}"
                            text="Pasien JKN" theme="primary" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('jenispasien', 'NON-JKN')->where('taskid', '!=', 99)->count() }}"
                            text="Pasien UMUM" theme="primary" icon="fas fa-user-injured" />
                    </div>
                </div>
                <x-adminlte-card title="Data Antrian Pendaftaran" theme="warning" icon="fas fa-info-circle" collapsible>
                    @php
                        $heads = ['No', 'Tanggal', 'No RM', 'Pasien', 'Kartu BPJS', 'Jenis Pasien', 'Method', 'Asesmen', 'PIC'];
                        $config['order'] = [1, 'asc'];
                        $config['paging'] = false;
                        $config['scrollY'] = '300px';
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tanggalperiksa }}</td>
                                <td>{{ $item->norm }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->nomorkartu }}</td>
                                <td>{{ $item->jenispasien }} </td>
                                <td>{{ $item->method }} </td>
                                <td>
                                    @if ($item->asesmenperawat)
                                        Sudah
                                    @else
                                        Belum
                                    @endif
                                </td>
                                <td>
                                    @if ($item->asesmenperawat)
                                        @if ($item->asesmenperawat->pic)
                                            {{ $item->asesmenperawat->pic->name }}
                                        @else
                                            {{ $item->asesmenperawat->user }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
            </div>
        @endif
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Select2', true)
