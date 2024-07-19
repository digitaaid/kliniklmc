@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">Selamat datang {{ $user->name }} !</p>
                </div>
            </div>
            @if ($kunjungans)
                <h5 class="mb-2">Informasi Kunjungan</h5>
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <x-adminlte-small-box title="{{ $kunjungans::whereMonth('tgl_masuk', now()->month)->count() }}"
                            text="Kunjungan Pasien" theme="warning" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-lg-3 col-6">
                        <x-adminlte-small-box
                            title="{{ $kunjungans::whereMonth('tgl_masuk', now()->month)->where('jeniskunjungan', 2)->count() }}"
                            text="Pasien NON-JKN" theme="warning" icon="fas fa-user-injured" />
                    </div>
                    <div class="col-lg-3 col-6">
                        <x-adminlte-small-box
                            title="{{ $kunjungans::whereMonth('tgl_masuk', now()->month)->where('jeniskunjungan', '!=', 2)->count() }}"
                            text="Pasien JKN" theme="warning" icon="fas fa-user-injured" />
                    </div>
                    {{-- <div class="col-lg-3 col-6">
                        <x-adminlte-info-box title="Pemanfaatan Antrol BPJS" text="{{ $antriansep }}/{{ $kunjungansep }}"
                            icon="fas fa-lg fa-tasks text-orange" theme="warning" icon-theme="dark"
                            progress="{{ $kunjungansep ? ($antriansep / $kunjungansep) * 100 : 0 }}" progress-theme="dark"
                            description="{{ $kunjungansep ? round(($antriansep / $kunjungansep) * 100) : 0 }}% dari antrian online per sep" />
                    </div> --}}
                </div>
                <div class="row">
                    {{-- <div class="col-lg-3 col-6">
                        <x-adminlte-info-box title="SEP Tercetak" text="" icon="fas fa-file-medical"
                            theme="primary" />
                    </div>
                    <div class="col-lg-3 col-6">
                        <x-adminlte-info-box title="Antrian SEP" text="" icon="fas fa-file-medical"
                            theme="primary" />
                    </div> --}}
                </div>
            @endif
            <h5 class="mb-2">Informasi Pengelolaan</h5>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <x-adminlte-small-box title="{{ $pasiens }}" text="Total Pasien" theme="warning"
                        icon="fas fa-users" />
                </div>
                <div class="col-lg-3 col-6">
                    <x-adminlte-small-box title="{{ $dokters }}" text="Dokter" theme="warning"
                        icon="fas fa-user-md" />
                </div>
                <div class="col-lg-3 col-6">
                    <x-adminlte-small-box title="{{ $units }}" text="Unit" theme="warning"
                        icon="fas fa-clinic-medical" />
                </div>
                <div class="col-lg-3 col-6">
                    <x-adminlte-small-box title="{{ $obats }}" text="Obat" theme="warning" icon="fas fa-pills" />
                </div>
            </div>
            {{-- @if ($antrians) --}}
            {{-- <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-card title="Capaian Jumlah Pelayanan Antrian Bulan Ini" theme="success" collapsible>
                            <div class="chart">
                                <canvas id="jumlahChart" style="height: 300px;"></canvas>
                            </div>
                        </x-adminlte-card>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-card title="Capaian Waktu Pelayanan Antrian Bulan Ini" theme="success" collapsible>
                            <div class="chart">
                                <canvas id="waktuChart" style="height: 300px;"></canvas>
                            </div>
                        </x-adminlte-card>
                    </div>
                    <div class="col-md-3">
                        <x-adminlte-small-box title="{{ $antrians->sum('jumlah_antrean') }}" text="Total Antrian"
                            theme="success" icon="fas fa-user-injured" />
                    </div>
                </div> --}}
            {{-- <x-adminlte-card title="Laporan Waktu Pelayanan Antrian Bulan Ini" theme="secondary" collapsible>
                    @php
                        $heads = ['Tanggal', 'Poliklinik', 'Total', 'Tunggu Poli', 'Layan Poli', 'Terima Resep', 'Proses Farmasi', 'Total Waktu'];
                        $config = ['paging' => false];
                    @endphp
                    <x-adminlte-datatable id="table1" class="text-xs" :heads="$heads" :config="$config" hoverable
                        bordered compressed>
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
                </x-adminlte-card> --}}
            {{-- @endif --}}
        </div>
        <div class="col-md-6">
            <x-adminlte-card theme="success" title="Pasien Perbulan Berdasarkan Sumber">
                <div class="chart">
                    <canvas id="stackedBarChart"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </x-adminlte-card>
        </div>
        <div class="col-md-6">
            <x-adminlte-card theme="success" title="Pasien Bulan Ini Berdasarkan Sumber">
                <div class="chart">
                    <canvas id="chartBulanIni"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop
@section('plugins.Chartjs', true)
@section('plugins.Datatables', true)
@section('js')
    <script>
        $(function() {
            var dataPasienUmum = {{ json_encode($antrianlainya) }};
            var dataPasienBPJS = {{ json_encode($antrianjkn) }};
            console.log(dataPasienBPJS);
            var areaChartData = {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                    'Oktober', 'November', 'Desember'
                ],
                datasets: [{
                        label: 'Sumber Lainnya',
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: dataPasienUmum
                    },
                    {
                        label: 'Mobile JKN',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: dataPasienBPJS
                    },
                ]
            }
            var barChartData = $.extend(true, {}, areaChartData)
            var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
            var stackedBarChartData = $.extend(true, {}, barChartData)
            var stackedBarChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }
            new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: stackedBarChartData,
                options: stackedBarChartOptions
            })
        })
        $(function() {
            var dataPasienUmum = {{ json_encode($antrianbulanini) }};
            var dataPasienBPJS = {{ json_encode($antrianbulanini) }};
            console.log(dataPasienBPJS);
            var areaChartData = {
                labels: {{ json_encode($tanggalDalamBulanIni) }},
                datasets: [{
                        label: 'Sumber Lainnya',
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: dataPasienUmum
                    },
                    {
                        label: 'Mobile JKN',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: dataPasienBPJS
                    },
                ]
            }
            var barChartData = $.extend(true, {}, areaChartData)
            var stackedBarChartCanvas = $('#chartBulanIni').get(0).getContext('2d')
            var stackedBarChartData = $.extend(true, {}, barChartData)
            var stackedBarChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }
            new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: stackedBarChartData,
                options: stackedBarChartOptions
            })
        })
    </script>
@endsection
