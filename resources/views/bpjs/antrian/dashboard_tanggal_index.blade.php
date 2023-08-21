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
                        <x-adminlte-small-box
                            title="{{ $antrians ? number_format(($antrians->sum('jumlah_antrean') / $antrianx->count()) * 100, 2) : '0' }} %"
                            text="Quality Rate Antrian" theme="primary" icon="fas fa-user-injured" />
                    </div>
                </div>
                <x-adminlte-card title="Waktu Pelayanan Antrian BPJS" theme="secondary" collapsible>
                    @php
                        $heads = ['Poliklinik', 'Selesai / Total', 'Checkin', 'Daftar', 'Tunggu Poli', 'Layan Poli', 'Terima Resep', 'Proses Farmasi', 'Total Waktu', 'Q Rate'];
                        $config = ['paging' => false];
                    @endphp
                    <x-adminlte-datatable id="table1" class="text-xs" :heads="$heads" :config="$config" hoverable bordered
                        compressed>
                        @foreach ($antrianx->groupBy('kodepoli') as $key => $item)
                            <tr>
                                <td>{{ strtoupper($item->first()->namapoli) }}</td>
                                <td>{{ $antrians ? $antrians->where('kodepoli', $key)->sum('jumlah_antrean') : '0' }} /
                                    {{ $item->count() }}
                                </td>
                                <td>
                                    {{ $antrians? Carbon\CarbonInterval::seconds($antrians->where('kodepoli', $key)->sum('avg_waktu_task1'))->cascade()->format('%H:%I:%S'): '0' }}
                                </td>
                                <td>
                                    {{ $antrians? Carbon\CarbonInterval::seconds($antrians->where('kodepoli', $key)->sum('avg_waktu_task2'))->cascade()->format('%H:%I:%S'): '0' }}
                                </td>
                                <td>
                                    {{ $antrians? Carbon\CarbonInterval::seconds($antrians->where('kodepoli', $key)->sum('avg_waktu_task3'))->cascade()->format('%H:%I:%S'): '0' }}
                                </td>
                                <td>
                                    {{ $antrians? Carbon\CarbonInterval::seconds($antrians->where('kodepoli', $key)->sum('avg_waktu_task4'))->cascade()->format('%H:%I:%S'): '0' }}
                                </td>
                                <td>
                                    {{ $antrians? Carbon\CarbonInterval::seconds($antrians->where('kodepoli', $key)->sum('avg_waktu_task5'))->cascade()->format('%H:%I:%S'): '0' }}
                                </td>
                                <td>
                                    {{ $antrians? Carbon\CarbonInterval::seconds($antrians->where('kodepoli', $key)->sum('avg_waktu_task6'))->cascade()->format('%H:%I:%S'): '0' }}
                                </td>
                                <td>
                                    {{ $antrians? Carbon\CarbonInterval::seconds($antrians->where('kodepoli', $key)->sum('avg_waktu_task1') + $antrians->where('kodepoli', $key)->sum('avg_waktu_task2') + $antrians->where('kodepoli', $key)->sum('avg_waktu_task3') + $antrians->where('kodepoli', $key)->sum('avg_waktu_task4') + $antrians->where('kodepoli', $key)->sum('avg_waktu_task5') + $antrians->where('kodepoli', $key)->sum('avg_waktu_task6') + $antrians->where('kodepoli', $key)->sum('avg_waktu_task7'))->cascade()->format('%H:%I:%S'): '0' }}
                                </td>
                                <td class="">
                                    {{ $antrians ? number_format(($antrians->where('kodepoli', $key)->sum('jumlah_antrean') / $item->count()) * 100, 2) : '0' }}
                                    %
                                </td>
                            </tr>
                        @endforeach
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th>{{ $antrians ? $antrians->sum('jumlah_antrean') : '0' }} / {{ $antrianx->count() }}</th>
                                <th>
                                    {{ $antrians? Carbon\CarbonInterval::seconds($antrians->sum('avg_waktu_task1') / $antrians->count())->cascade()->format('%H:%I:%S'): '0' }}
                                </th>
                                <th>
                                    {{ $antrians? Carbon\CarbonInterval::seconds($antrians->sum('avg_waktu_task2') / $antrians->count())->cascade()->format('%H:%I:%S'): '0' }}
                                </th>
                                <th>
                                    {{ $antrians? Carbon\CarbonInterval::seconds($antrians->sum('avg_waktu_task3') / $antrians->count())->cascade()->format('%H:%I:%S'): '0' }}
                                </th>
                                <th>
                                    {{ $antrians? Carbon\CarbonInterval::seconds($antrians->sum('avg_waktu_task4') / $antrians->count())->cascade()->format('%H:%I:%S'): '0' }}
                                </th>
                                <th>
                                    {{ $antrians? Carbon\CarbonInterval::seconds($antrians->sum('avg_waktu_task5') / $antrians->count())->cascade()->format('%H:%I:%S'): '0' }}
                                </th>
                                <th>
                                    {{ $antrians? Carbon\CarbonInterval::seconds($antrians->sum('avg_waktu_task6') / $antrians->count())->cascade()->format('%H:%I:%S'): '0' }}
                                </th>
                                <th>
                                    {{ $antrians? Carbon\CarbonInterval::seconds(($antrians->sum('avg_waktu_task1') + $antrians->sum('avg_waktu_task2') + $antrians->sum('avg_waktu_task3') + $antrians->sum('avg_waktu_task4') + $antrians->sum('avg_waktu_task5') + $antrians->sum('avg_waktu_task6') + $antrians->sum('avg_waktu_task7')) / $antrians->count())->cascade()->format('%H:%I:%S'): '0' }}
                                </th>
                                <th>
                                    {{ $antrians ? number_format(($antrians->sum('jumlah_antrean') / $antrianx->count()) * 100, 2) : '0' }}
                                    %
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
