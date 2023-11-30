@extends('adminlte::page')
@section('title', 'Kunjungan Pasien')
@section('content_header')
    <h1>Kunjungan Pasien</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Filter Kunjungan" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tgl_masuk" label="Tanggal Masuk Kunjungan"
                                value="{{ $request->tgl_masuk ?? now()->format('Y-m-d') }}" placeholder="Pilih Tanggal"
                                :config="$config">
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
        @if (isset($kunjungans))
            <div class="col-md-12">
                <x-adminlte-card title="Data Kunjungan Pasien" theme="warning" icon="fas fa-info-circle" collapsible>
                    <div class="row">
                        <div class="col-md-8">
                            {{-- <x-adminlte-button id="btnTambah" class="btn-sm" theme="success" label="Tambah Pasien"
                                icon="fas fa-plus" />
                            <a href="{{ route('pasienexport') }}" class="btn btn-sm btn-primary"><i class="fas fa-print"></i>
                                Export</a>
                            <div class="btn btn-sm btn-primary btnModalImport"><i class="fas fa-file-medical"></i> Import</div> --}}
                        </div>
                        <div class="col-md-4">
                            <form action="" method="get">
                                <x-adminlte-input name="search" placeholder="Pencarian Kunjungan" igroup-size="sm"
                                    value="{{ $request->search }}">
                                    <x-slot name="appendSlot">
                                        <x-adminlte-button type="submit" theme="outline-primary" label="Cari" />
                                    </x-slot>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-primary">
                                            <i class="fas fa-search"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </form>
                        </div>
                    </div>
                    @php
                        $heads = ['No', 'Tgl Masuk', 'Kode', 'Pasien', 'Unit', 'Jaminan', 'Jenis Kunjungan', 'SEP', 'Asesmen', 'Resep', 'Status'];
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
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->norm }} {{ $item->nama }}</td>
                                <td>{{ $item->units->nama }}</td>
                                <td>{{ $item->jaminans->nama ?? '-' }}
                                    {{-- @if ($item->jaminan)
                                        {{ $item->jaminans }}
                                    @endif --}}
                                </td>
                                <td>
                                    @switch($item->jeniskunjungan)
                                        @case(1)
                                            Rujukan FKTP
                                        @break

                                        @case(2)
                                            Umum
                                        @break

                                        @case(3)
                                            Surat Kontrol
                                        @break

                                        @case(4)
                                            Rujukan Antar RS
                                        @break

                                        @default
                                    @endswitch
                                    {{-- <br>
                                    {{ $item->nomorreferensi }} --}}
                                </td>
                                <td>
                                    @if ($item->sep)
                                        <a class="btn btn-xs btn-success" target="_blank"
                                            href="{{ route('sep_print') }}?noSep={{ $item->sep }}"
                                            style="text-decoration: none">
                                            <i class="fas fa-print"></i> {{ $item->sep }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($item->asesmendokter)
                                        <a class="btn btn-xs btn-success" target="_blank"
                                            href="{{ route('print_asesmendokter') }}?id={{ $item->asesmendokter->kodekunjungan }}">
                                            <i class="fas fa-print"></i> Asesmen Dokter</a>
                                    @else
                                        -
                                    @endif

                                </td>
                                <td>
                                    {{-- {{ $item->kode }} {{ $item->antrian->kodebooking }} --}}
                                    @if ($item->antrian->kodebooking)
                                        <a href="{{ route('print_asesmenfarmasi') }}?kodebooking={{ $item->antrian->kodebooking }}"
                                            class="btn btn-xs btn-success" target="_blank"> <i class="fas fa-print"></i>
                                            Resep
                                            Obat</a>
                                    @else
                                        -
                                    @endif

                                </td>
                                <td>{{ $item->status }}</td>
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
@section('plugins.Select2', true)
