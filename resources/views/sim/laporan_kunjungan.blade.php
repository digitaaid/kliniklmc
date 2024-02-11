@extends('adminlte::page')
@section('title', 'Laporan Kunjungan Pasien')
@section('content_header')
    <h1>Laporan Kunjungan Pasien</h1>
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
                            <x-adminlte-date-range name="tanggal" value="{{ $request->tanggal }}" :config="$config"
                                label="Periode Tanggal" />
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Antrian" />
                </form>
            </x-adminlte-card>
        </div>
        @if (isset($kunjungans))
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $kunjungans->count() }}" text="Total Kunjungan" theme="success"
                            icon="fas fa-user-injured" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $kunjungans->where('counter', 1)->count() }} / {{ $kunjungans->count() - $kunjungans->where('counter', 1)->count() }}"
                            text="Kunj. Baru / Lama" theme="warning" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $kunjungans->count() - $kunjungans->where('antrian.jenispasien', 'JKN')->count() }} / {{ $kunjungans->where('antrian.jenispasien', 'JKN')->count() }}"
                            text="Kunj. Umum / BPJS" theme="warning" icon="fas fa-user-injured" />
                    </div>
                    {{-- <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('jenispasien', 'JKN')->where('taskid', '!=', 99)->count() }}"
                            text="Pasien JKN" theme="primary" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('jenispasien', 'NON-JKN')->where('taskid', '!=', 99)->count() }}"
                            text="Pasien UMUM" theme="primary" icon="fas fa-user-injured" />
                    </div> --}}
                </div>
                <x-adminlte-card title="Data Antrian Pendaftaran" theme="secondary" icon="fas fa-info-circle" collapsible>
                    <a href="{{ route('pdflaporanpendaftaran') }}?tanggal={{ $request->tanggal }}" target="_blank"
                        rel="noopener noreferrer" class="btn btn-primary">Print PDF</a>
                    @php
                        $heads = ['No', 'Tanggal', 'No RM', 'Pasien', 'Penjamin', 'Perujuk', 'Baru/Lama', 'BPJS/UMUM', 'Dokter', 'PIC'];
                        $config['order'] = [1, 'asc'];
                        $config['paging'] = false;
                        $config['scrollY'] = '300px';
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($kunjungans as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tgl_masuk }}</td>
                                <td>{{ $item->norm }}</td>
                                <td>{{ $item->nama }} ({{ $item->gender }})</td>
                                <td>{{ $item->penjamin }}</td>
                                <td>{{ $item->antrian->perujuk }}</td>
                                <td>
                                    @if ($item->counter == 1)
                                        BARU
                                    @else
                                        LAMA
                                    @endif
                                </td>
                                <td>{{ $item->dokters->namadokter }}</td>
                                <td>{{ $item->antrian->jenispasien }}</td>
                                <td>{{ $item->pic->name }}</td>
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
