@extends('adminlte::page')
@section('title', 'Diagnosa Casemix')
@section('content_header')
    <h1>Diagnosa Casemix</h1>
@stop
@section('content')
    <div class="row">
        @if (isset($antrians))
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('taskid', 4)->first()->nomorantrean ?? 'Belum Panggil' }}"
                            text="Antrian Dilayani" theme="primary" icon="fas fa-user-injured"
                            url="{{ route('prosespoliklinik') }}?kodebooking={{ $antrians->where('taskid', 3)->first()->kodebooking ?? '00' }}"
                            url-text="Panggil Antrian Selanjutnya" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box
                            title="{{ $antrians->where('taskid', '>=', 2)->where('taskid', '<=', 3)->count() }}"
                            text="Belum Asesmen Dokter" theme="danger" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $antrians->where('taskid', '>=', 5)->count() }}"
                            text="Sudah Asesmen Dokter" theme="warning" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $antrians->count() }}" text="Total Antrian" theme="success"
                            icon="fas fa-user-injured" />
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-12">
            <x-adminlte-card theme="primary" theme-mode='outline'>
                <div class="row">
                    <div class="col-md-4">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-12">
                                    @php
                                        $config = ['format' => 'YYYY-MM-DD'];
                                    @endphp
                                    <x-adminlte-input-date name="tanggal"
                                        value="{{ $request->tanggal ?? now()->format('Y-m-d') }}"
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
                    $heads = [
                        'Tanggal',
                        'No',
                        'No RM',
                        'Nama Pasien',
                        'Action',
                        'Taskid',
                        'Asesmen',
                        'Jenis Pasien',
                        'Diag Awal',
                        'Layanan',
                        'Obat',
                        'Unit',
                        'PIC ',
                        'Dokter',
                    ];
                    $config['order'] = [[6, 'asc'], [7, 'asc']];
                    $config['paging'] = false;
                    $config['scrollX'] = true;
                    $config['scrollY'] = '300px';
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered hoverable
                    compressed>
                    @if (isset($antrians))
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $item->kunjungan->tgl_masuk }}</td>
                                <td>A{{ $item->angkaantrean }}</td>
                                <td>{{ $item->norm }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>{{ $item->jenispasien }} </td>
                                <td>{{ $item->kunjungan->diagnosa_awal }} </td>
                                <td class="text-right">{{ money($item->layanans?->sum('subtotal'), 'IDR') }} </td>
                                <td class="text-right">{{ money($item->resepdetails?->sum('subtotal'), 'IDR') }} </td>
                                <td>{{ $item->kunjungan->units->nama ?? $item->namapoli }} </td>
                                <td>{{ $item->pic3->name ?? 'Belum Periksa' }} </td>
                                <td>{{ $item->kunjungan->dokters->namadokter ?? $item->namadokter }}</td>
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
