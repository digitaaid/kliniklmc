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
                            <x-adminlte-date-range name="tanggal" value="{{ $request->tanggal ?? null }}" :config="$config"
                                label="Periode Tanggal" />
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
                        $heads = [
                            'No',
                            'Tanggal',
                            'Kodeboking',
                            'No RM',
                            'Nama Pasien',
                            'Status',
                            'Action',
                            'Taskid 1',
                            'Taskid 2',
                            'Taskid 3',
                            'Taskid 4',
                            'Taskid 5',
                            'Taskid 6',
                            'Taskid 7',
                            'Taskid',
                        ];
                        $config['order'] = [1, 'asc'];
                        $config['paging'] = false;
                        $config['scrollY'] = '300px';
                        $config['scrollX'] = true;
                        $config['fixedColumns'] = [
                            'leftColumns' => 7,
                        ];
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tanggalperiksa }}</td>
                                <td>{{ $item->kodebooking }}</td>
                                <td>{{ $item->norm }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    <x-adminlte-button class="btn-xs" onclick="editAntrian(this)" theme="warning"
                                        label="Edit" icon="fas fa-edit" title="Edit" data-id="{{ $item->id }}"
                                        data-nama="{{ $item->nama }}" data-norm="{{ $item->norm }}"
                                        data-status="{{ $item->status }}"
                                        data-tanggalperiksa="{{ $item->tanggalperiksa }}"
                                        data-kodebooking="{{ $item->kodebooking }}" data-taskid1="{{ $item->taskid1 }}"
                                        data-taskid2="{{ $item->taskid2 }}" data-taskid3="{{ $item->taskid3 }}"
                                        data-taskid4="{{ \Carbon\Carbon::parse($item->taskid3)->addMinutes(20) }}"
                                        data-taskid5="{{ \Carbon\Carbon::parse($item->taskid3)->addMinutes(40) }}"
                                        data-taskid6="{{ \Carbon\Carbon::parse($item->taskid3)->addMinutes(60) }}"
                                        data-taskid7="{{ \Carbon\Carbon::parse($item->taskid3)->addMinutes(80) }}" />
                                </td>
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
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
            </div>
        @endif
    </div>
    <x-adminlte-modal id="modalAntrian" title="Pasien" icon="fas fa-user-injured" theme="success">
        <form action="{{ route('update_taksid_antrian') }}" id="formAntrian" name="formAntrian" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            @php
                $config = ['format' => 'YYYY-MM-DD'];
            @endphp
            <x-adminlte-input-date name="tanggalperiksa" label="Tgl Periksa" fgroup-class="row"
                label-class="text-left col-4" igroup-size="sm" igroup-class="col-8" :config="$config" required readonly>
            </x-adminlte-input-date>
            <x-adminlte-input name="kodebooking" label="Kodebooking" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" enable-old-support required readonly />
            <x-adminlte-input name="norm" label="No RM" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" enable-old-support required readonly />
            <x-adminlte-input name="nama" label="Nama" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" enable-old-support required readonly />
            <x-adminlte-input name="status" label="Status" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" enable-old-support required readonly />
            @php
                $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
            @endphp
            <x-adminlte-input-date name="taskid1" label="Waktu Taskid1" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" :config="$config">
            </x-adminlte-input-date>
            <x-adminlte-input-date name="taskid2" label="Waktu Taskid2" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" :config="$config">
            </x-adminlte-input-date>
            <x-adminlte-input-date name="taskid3" label="Waktu Taskid3" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" :config="$config">
            </x-adminlte-input-date>
            <x-adminlte-input-date name="taskid4" label="Waktu Taskid4" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" :config="$config">
            </x-adminlte-input-date>
            <x-adminlte-input-date name="taskid5" label="Waktu Taskid5" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" :config="$config">
            </x-adminlte-input-date>
            <x-adminlte-input-date name="taskid6" label="Waktu Taskid6" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" :config="$config">
            </x-adminlte-input-date>
            <x-adminlte-input-date name="taskid7" label="Waktu Taskid7" fgroup-class="row" label-class="text-left col-4"
                igroup-size="sm" igroup-class="col-8" :config="$config">
            </x-adminlte-input-date>
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button form="formAntrian" class="mr-auto" type="submit" icon="fas fa-save" theme="success"
                label="Simpan" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop

@section('plugins.Datatables', true)
@section('plugins.DatatablesFixedColumns', true)
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

        function editAntrian(button) {
            $.LoadingOverlay("show");
            $('#formAntrian').trigger("reset");
            $('#id').val($(button).data("id"));
            $('#tanggalperiksa').val($(button).data("tanggalperiksa"));
            $('#nama').val($(button).data("nama"));
            $('#norm').val($(button).data("norm"));
            $('#kodebooking').val($(button).data("kodebooking"));
            $('#status').val($(button).data("status"));
            $('#taskid1').val($(button).data("taskid1"));
            $('#taskid2').val($(button).data("taskid2"));
            $('#taskid3').val($(button).data("taskid3"));
            $('#taskid4').val($(button).data("taskid4"));
            $('#taskid5').val($(button).data("taskid5"));
            $('#taskid6').val($(button).data("taskid6"));
            $('#taskid7').val($(button).data("taskid7"));
            $('#modalAntrian').modal('show');
            $.LoadingOverlay("hide");
        }
    </script>
@endsection
