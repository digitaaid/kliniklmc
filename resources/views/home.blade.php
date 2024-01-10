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
            @if ($antrians)
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
            @endif
        </div>
    </div>
@stop
@section('plugins.Chartjs', true)
@section('plugins.Datatables', true)
@section('js')
    {{-- <script>
        $(function() {
            var tanggalAntrian = {!! json_encode($tanggalantrian) !!};
            var jumlahAntrian = {!! json_encode($jumlahantrian) !!};
            var waktuAntrian = {!! json_encode($waktuantrian) !!};
            var jumlahChartData = {
                labels: tanggalAntrian,
                datasets: [{
                    label: 'Jumlah Antrian',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: jumlahAntrian
                }]
            }
            var waktuChartData = {
                labels: tanggalAntrian,
                datasets: [{
                    label: 'Waktu Antrian (Detik)',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: waktuAntrian
                }]
            }
            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }
            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#jumlahChart').get(0).getContext('2d');
            var barChartData = $.extend(true, {}, jumlahChartData)
            // var temp0 = jumlahChartData.datasets[0]
            // var temp1 = jumlahChartData.datasets[1]
            // barChartData.datasets[0] = temp1
            // barChartData.datasets[1] = temp0

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })

            var waktuChartCanvas = $('#waktuChart').get(0).getContext('2d');
            var waktuChartData = $.extend(true, {}, waktuChartData)
            new Chart(waktuChartCanvas, {
                type: 'bar',
                data: waktuChartData,
                options: barChartOptions
            })


        })
    </script> --}}
@endsection


