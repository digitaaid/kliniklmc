@extends('adminlte::page')
@section('title', 'Antrian Farmasi')
@section('content_header')
    <h1>Antrian Farmasi</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
        </div>
        <div class="col-md-12">
            <x-adminlte-card title="Data Antrian Farmasi" theme="secondary" icon="fas fa-info-circle" collapsible="">
                {{-- @if ($antrians)
                    <div class="row">
                        <div class="col-md-3">
                            <x-adminlte-small-box
                                title="{{ $antrians->where('taskid', '>=', 5)->where('taskid', '<', 7)->count() }}"
                                text="Sisa Resep" theme="warning" icon="fas fa-user-injured" />
                        </div>
                        <div class="col-md-3">
                            <x-adminlte-small-box title="{{ $antrians->where('taskid', 7)->count() }}"
                                text="Total Resep Selesai" theme="success" icon="fas fa-user-injured" />
                        </div>
                        <div class="col-md-3">
                            <x-adminlte-small-box
                                title="{{ $antrians->where('taskid', 7)->where('jenispasien', 'JKN')->count() }}"
                                text="Total Resep JKN" theme="primary" icon="fas fa-user-injured" />
                        </div>
                        <div class="col-md-3">
                            <x-adminlte-small-box
                                title="{{ $antrians->where('taskid', 7)->where('jenispasien', 'NON-JKN')->count() }}"
                                text="Total Resep NON-JKN" theme="primary" icon="fas fa-user-injured" />
                        </div>
                    </div>
                @endif --}}
                <div class="row">
                    <div class="col-md-4">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-12">
                                    @php
                                        $config = ['format' => 'YYYY-MM-DD'];
                                    @endphp
                                    <x-adminlte-input-date name="tanggalperiksa"
                                        value="{{ $request->tanggalperiksa ?? now()->format('Y-m-d') }}"
                                        placeholder="Pilih Tanggal" igroup-size="sm" :config="$config">
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-primary">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </x-slot>
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button type="submit" theme="primary" label="Cari Tanggal" />
                                        </x-slot>
                                    </x-adminlte-input-date>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <form action="" method="get">
                            <x-adminlte-input name="pencarian" placeholder="Pencarian Berdasarkan Nama / No RM"
                                igroup-size="sm" value="{{ $request->pencarian }}">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" theme="primary" label="Cari" />
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
                    $heads = ['Tgl', 'Kode Resep', 'No RM', 'Pasien', 'Jenis', 'Dokter', 'Resep Obat', 'Action'];
                    $config['order'] = [[7, 'asc']];
                    $config['paging'] = false;
                    $config['scrollY'] = '500px';
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered hoverable
                    compressed>
                    @if ($antrians)
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $item->tanggalperiksa }}</td>
                                <td>{{ $item->resepobat ? $item->resepobat->kode : '-' }}</td>
                                <td>{{ $item->norm }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->jenispasien }}</td>
                                <td>{{ $item->namadokter }}</td>
                                <td>
                                    @if ($item->resepobat)
                                        @foreach ($item->resepobat->resepdetail as $itemobat)
                                            <b> R/ {{ $itemobat->nama }} </b> ({{ $itemobat->jumlah }}) <br>
                                            &emsp;&emsp;
                                            @switch($itemobat->interval)
                                                @case('qod')
                                                    1x1
                                                @break

                                                @case('dod')
                                                    1x2
                                                @break

                                                @case('bid')
                                                    2x1
                                                @break

                                                @case('tid')
                                                    3x1
                                                @break

                                                @case('qid')
                                                    4x1
                                                @break

                                                @case('prn')
                                                    SESUAI KEBUTUHAN
                                                @break

                                                @case('q3h')
                                                    SETIAP 3 JAM
                                                @break

                                                @case('q4h')
                                                    SETIAP 4 JAM
                                                @break

                                                @case('303')
                                                    3 TAB/CAP SETIAP PAGI DAN MALAM
                                                @break

                                                @case('202')
                                                    2 TAB/CAP SETIAP PAGI DAN MALAM
                                                @break

                                                @default
                                            @endswitch
                                            @switch($itemobat->waktu)
                                                @case('pc')
                                                    SETELAH MAKAN
                                                @break

                                                @case('ac')
                                                    SEBELUM MAKAN
                                                @break

                                                @case('hs')
                                                    SEBELUM TIDUR
                                                @break

                                                @case('int')
                                                    DIANTARA WAKTU MAKAN
                                                @break

                                                @default
                                            @endswitch
                                            {{ $itemobat->keterangan }} <br>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
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
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
