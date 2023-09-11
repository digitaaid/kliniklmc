@extends('adminlte::page')
@section('title', 'Dashboard Tanggal - Antrian BPJS')
@section('content_header')
    <h1 class="m-0 text-dark">Dashboard Tanggal Antrian BPJS</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Pencarian Dashboad Tanggal Antrian" theme="secondary" icon="fas fa-info-circle"
                collapsible>
                <form action="">
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <x-adminlte-input-date name="tanggal" placeholder="Silahkan Pilih Tanggal" value="{{ $request->tanggal }}"
                        label="Tanggal Periksa" :config="$config" />
                    <x-adminlte-select name="waktu" label="Waktu">
                        <option value="rs">Waktu RS</option>
                        <option value="server">Waktu BPJS</option>
                    </x-adminlte-select>
                    <x-adminlte-button label="Cari Antrian" class="mr-auto withLoad" type="submit" theme="success"
                        icon="fas fa-search" />
                </form>
            </x-adminlte-card>
            @isset($antrianx)
                <div class="row">
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $antrians ? $antrians->sum('jumlah_antrean') : '0' }}"
                            text="Selesai Antrian" theme="success" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $antrianx->count() }}" text="Total Antrian" theme="warning"
                            icon="fas fa-user-injured" />
                    </div>
                    <div class="col-md-3">
                        {{-- <x-adminlte-small-box
                            title="{{ $antrians ? number_format(($antrians->sum('jumlah_antrean') / $antrianx->count()) * 100, 2) : '0' }} %"
                            text="Quality Rate Antrian" theme="primary" icon="fas fa-user-injured" /> --}}
                    </div>
                </div>
                <x-adminlte-card title="Waktu Pelayanan Antrian BPJS" theme="secondary" collapsible>
                    @php
                        $heads = ['Tanggal', 'Poliklinik', 'Total', 'Tunggu Poli', 'Layan Poli', 'Terima Resep', 'Proses Farmasi', 'Total Waktu'];
                        $config = ['paging' => false];
                    @endphp
                    <x-adminlte-datatable id="table1" class="text-xs" :heads="$heads" :config="$config" hoverable bordered
                        compressed>
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->namapoli }}</td>
                                <td>{{ $item->jumlah_antrean }}</td>
                                <td>
                                    {{ Carbon\CarbonInterval::seconds($item->avg_waktu_task3)->cascade()->format('%H:%I:%S') }}
                                </td>
                                <td>
                                    {{ Carbon\CarbonInterval::seconds($item->avg_waktu_task4)->cascade()->format('%H:%I:%S') }}
                                </td>
                                <td>
                                    {{ Carbon\CarbonInterval::seconds($item->avg_waktu_task5)->cascade()->format('%H:%I:%S') }}
                                </td>
                                <td>
                                    {{ Carbon\CarbonInterval::seconds($item->avg_waktu_task6)->cascade()->format('%H:%I:%S') }}
                                </td>
                                <td>
                                    {{ Carbon\CarbonInterval::seconds($item->avg_waktu_task3 + $item->avg_waktu_task4 + $item->avg_waktu_task5 + $item->avg_waktu_task6)->cascade()->format('%H:%I:%S') }}
                                </td>
                            </tr>
                        @endforeach
                        <tfoot>
                            <tr>
                                <th colspan="2">Total</th>
                                <th>{{ $antrians->sum('jumlah_antrean') }}</th>
                                <th>
                                    {{ Carbon\CarbonInterval::seconds($antrians->sum('avg_waktu_task3') / $antrians->count())->cascade()->format('%H:%I:%S') }}
                                </th>
                                <th>
                                    {{ Carbon\CarbonInterval::seconds($antrians->sum('avg_waktu_task4') / $antrians->count())->cascade()->format('%H:%I:%S') }}
                                </th>
                                <th>
                                    {{ Carbon\CarbonInterval::seconds($antrians->sum('avg_waktu_task5') / $antrians->count())->cascade()->format('%H:%I:%S') }}
                                </th>
                                <th>
                                    {{ Carbon\CarbonInterval::seconds($antrians->sum('avg_waktu_task6') / $antrians->count())->cascade()->format('%H:%I:%S') }}
                                </th>
                                <th>
                                    {{ Carbon\CarbonInterval::seconds(($antrians->sum('avg_waktu_task1') + $antrians->sum('avg_waktu_task2') + $antrians->sum('avg_waktu_task3') + $antrians->sum('avg_waktu_task4') + $antrians->sum('avg_waktu_task5') + $antrians->sum('avg_waktu_task6') + $antrians->sum('avg_waktu_task7')) / $antrians->count())->cascade()->format('%H:%I:%S') }}
                                </th>
                            </tr>
                        </tfoot>
                    </x-adminlte-datatable>
                </x-adminlte-card>
            @endisset
        </div>
    </div>
@stop
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Select2', true)
