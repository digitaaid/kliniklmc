@extends('adminlte::page')
@section('title', 'Laporan Pendaftaran')
@section('content_header')
    <h1>Laporan Pendaftaran</h1>
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
                        <x-adminlte-small-box title="{{ $antrians->where('taskid', 1)->count() }}" text="Sisa Antrian"
                            theme="warning" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $antrians->where('taskid', '!=', 99)->count() }}"
                            text="Total Antrian" theme="success" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $antrians->where('taskid', 99)->count() }}" text="Batal Antrian"
                            theme="danger" icon="fas fa-user-injured" />
                    </div>
                </div>
                <x-adminlte-card title="Data Antrian Pendaftaran" theme="warning" icon="fas fa-info-circle" collapsible>
                    @php
                        $heads = ['No', 'Tanggal', 'No RM','Pasien', 'Kartu BPJS', 'Jenis Pasien', 'Method', 'Action','PIC'];
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
                                    @switch($item->taskid)
                                        @case(0)
                                            98. Belum Checkin
                                        @break

                                        @case(1)
                                            1. Menunggu Pendaftaran
                                        @break

                                        @case(2)
                                           0. Proses Pendaftaran
                                        @break

                                        @case(3)
                                           3. Menunggu Poliklinik
                                        @break

                                        @case(4)
                                           4. Pelayanan Poliklinik
                                        @break

                                        @case(5)
                                           5. Tunggu Farmasi
                                        @break

                                        @case(6)
                                           6. Racik Obat
                                        @break

                                        @case(7)
                                           7. Selesai
                                        @break

                                        @case(99)
                                            99. Batal
                                        @break

                                        @default
                                            {{ $item->taskid }}
                                    @endswitch
                                </td>
                                <td>{{ $item->user1 }} </td>

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
