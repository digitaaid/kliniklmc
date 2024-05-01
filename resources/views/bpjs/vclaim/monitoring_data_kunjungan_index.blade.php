@extends('adminlte::page')
@section('title', 'Monitoring Data Kunjungan')
@section('content_header')
    <h1>Monitoring Data Kunjungan</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="primary" theme-mode="outline">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="tanggal" label="Tanggal" :config="$config"
                                value="{{ \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') ?? now()->format('Y-m-d') }}">

                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-select2 fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="jenispelayanan" label="Pelayanan">
                                <option value="1" {{ $request->jenispelayanan == 1 ? 'selected' : null }}>Rawat Inap
                                </option>
                                <option value="2" {{ $request->jenispelayanan == 2 ? 'selected' : null }}>Rawat Jalan
                                </option>
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Cari!" />
                                </x-slot>
                            </x-adminlte-select2>

                        </div>
                    </div>
                </form>
                @php
                    $heads = [
                        'No',
                        'Nama',
                        'No SEP',
                        'Action',
                        'Tgl Masuk',
                        'Tgl Pulang',
                        'Nomor Rujukan',
                        'Jenis Pelayanan',
                        'Nomor BPJS',
                        'Poliklik',
                        'Diagnosa',
                    ];
                    $config['fixedColumns'] = [
                        'leftColumns' => 2,
                    ];
                    $config['order'] = [['0', 'asc']];
                    $config['paging'] = false;
                    $config['scrollX'] = true;
                    $config['scrollY'] = '500px';
                @endphp
                <x-adminlte-datatable id="table2" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                    hoverable compressed>
                    @isset($sep)
                        @foreach ($sep as $item)
                            <tr class="table-secondary">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->noSep }}</td>
                                <td>
                                    <a class="btn btn-xs btn-success" target="_blank"
                                        href="{{ route('sep_print') }}?noSep={{ $item->noSep }}" style="text-decoration: none">
                                        <i class="fas fa-print"></i> Print SEP
                                    </a>
                                </td>
                                <td>{{ $item->tglSep }}</td>
                                <td>{{ $item->tglPlgSep }}</td>
                                <td>{{ $item->noRujukan }}</td>
                                <td>{{ $item->jnsPelayanan }}</td>
                                <td>{{ $item->noKartu }}</td>
                                <td>{{ $item->poli }}</td>
                                <td>{{ $item->diagnosa }}</td>
                            </tr>
                        @endforeach
                    @endisset
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop
@section('plugins.Datatables', true)
@section('plugins.DatatablesFixedColumns', true)
@section('plugins.TempusDominusBs4', true)
