@extends('adminlte::page')
@section('title', 'Sync Antrian BPJS')
@section('content_header')
    <h1>Sync Antrian BPJS</h1>
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
                    <x-adminlte-button type="submit" form="formOnTracer" class="withLoad"
                        theme="{{ $request->sync == 'ON' ? 'success' : 'secondary' }}" label="ON" />
                    <x-adminlte-button type="submit" form="formOffTracer" class="withLoad mr-2"
                        theme="{{ $request->sync == 'OFF' ? 'success' : 'secondary' }}" label="OFF" />
                    <a href="" class="btn btn-warning"> <i class="fas fa-sync"></i> Refresh</a>
                </form>
                <form action="" name="formOnTracer" id="formOnTracer">
                    <input type="hidden" name="tanggal" value="{{ $request->tanggal }}">
                    <input type="hidden" name="sync" value="ON">
                </form>
                <form action="" name="formOffTracer" id="formOffTracer">
                    <input type="hidden" name="tanggal" value="{{ $request->tanggal }}">
                    <input type="hidden" name="sync" value="OFF">
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
                        <x-adminlte-small-box title="{{ $antrians->where('taskid', 99)->count() }}" text="Batal Antrian"
                            theme="danger" icon="fas fa-user-injured" />
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
                    <a href="{{ route('pdflaporanpendaftaran') }}?tanggal={{ $request->tanggal }}" target="_blank"
                        rel="noopener noreferrer" class="btn btn-primary">Print PDF</a>
                    @php
                        $heads = ['No', 'Tanggal', 'Kodeboking', 'Pasien', 'Taskid 1', 'Taskid 2', 'Taskid 3', 'Taskid 4', 'Taskid 5', 'Taskid 6', 'Taskid 7', 'Taskid', 'Status'];
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
                                <td>{{ $item->kodebooking }}</td>
                                <td>{{ $item->norm }} {{ $item->nama }}</td>
                                <td>{{ $item->taskid1 }}</td>
                                <td>{{ $item->taskid2 }}</td>
                                <td>{{ $item->taskid3 }}</td>
                                <td>{{ $item->taskid4 }}</td>
                                <td>{{ $item->taskid5 }}</td>
                                <td>{{ $item->taskid6 }}</td>
                                <td>{{ $item->taskid7 }}</td>
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
@section('plugins.DateRangePicker', true)
@section('plugins.Select2', true)

@section('js')
    <script>
        function syncantrian() {
            location.reload();
        }
        $(function() {
            if ("{{ $request->sync }}" == 'ON') {
                setTimeout(syncantrian, 2000);
            }
        });
    </script>

@endsection
