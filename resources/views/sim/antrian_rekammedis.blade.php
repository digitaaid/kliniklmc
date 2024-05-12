@extends('adminlte::page')
@section('title', 'Diagnosa Casemix')
@section('content_header')
    <h1>Diagnosa Casemix</h1>
@stop
@section('content')
    <div class="row">
        {{-- @if (isset($antrians))
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
        @endif --}}
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
                        'Jenis',
                        'Layanan',
                        'Obat',
                        'Diag Awal',
                        'Antrian',
                        'INACBG',
                        'Satu Sehat',
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
                                <td>{{ $item->jenispasien }} </td>
                                <td class="text-right">{{ money($item->layanans?->sum('subtotal'), 'IDR') }} </td>
                                <td class="text-right">{{ money($item->resepdetails?->sum('subtotal'), 'IDR') }} </td>
                                <td>
                                    {{ $item->kunjungan->diagnosa_awal }}
                                    <x-adminlte-button class="btn-xs" theme="primary" label="Resume" icon="fas fa-file-medical" />
                                </td>
                                <td>
                                    @if ($item->sync_antrian)
                                        <a href="{{ route('sync_update_antrian') }}?kodebooking={{ $item->kodebooking }}"
                                            class="btn btn-xs btn-success withLoad"><i class="fas fa-sync"></i> Sudah Sync</a>
                                    @else
                                        <a href="{{ route('sync_update_antrian') }}?kodebooking={{ $item->kodebooking }}"
                                            class="btn btn-xs btn-warning withLoad"><i class="fas fa-sync"></i> Belum Sync</a>
                                    @endif
                                    <x-adminlte-button class="btn-xs" onclick="editAntrian(this)" theme="warning"
                                        icon="fas fa-edit" title="Edit" data-id="{{ $item->id }}"
                                        data-nama="{{ $item->nama }}" data-norm="{{ $item->norm }}"
                                        data-status="{{ $item->status }}"
                                        data-tanggalperiksa="{{ $item->tanggalperiksa }}"
                                        data-kodebooking="{{ $item->kodebooking }}" data-taskid1="{{ $item->taskid1 }}"
                                        data-taskid2="{{ $item->taskid2 }}"
                                        data-taskid3="{{ \Carbon\Carbon::parse($item->taskid7)->subSeconds(3600, 4200) }}"
                                        data-taskid4="{{ \Carbon\Carbon::parse($item->taskid7)->subSeconds(rand(1500, 2400)) }}"
                                        data-taskid5="{{ \Carbon\Carbon::parse($item->taskid7)->subSeconds(rand(600, 900)) }}"
                                        data-taskid6="{{ \Carbon\Carbon::parse($item->taskid7)->subSeconds(rand(300, 600)) }}"
                                        data-taskid7="{{ $item->taskid7 }}" />

                                    {{-- @if ($item)
                                    @else
                                    @endif --}}
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
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
                igroup-size="sm" igroup-class="col-8" enable-old-support required />
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
@section('plugins.TempusDominusBs4', true)
@section('plugins.Select2', true)

@section('js')
    <script>
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
