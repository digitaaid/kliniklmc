@extends('adminlte::page')
@section('title', 'Antrian Pertanggal')
@section('content_header')
    <h1>Antrian Per Tanggal</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Filter Data Antrian" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tanggal" label="Tanggal Laporan"
                                value="{{ $request->tanggal ?? now()->format('Y-m-d') }}" placeholder="Pilih Tanggal"
                                :config="$config">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Antrian" />
                </form>
            </x-adminlte-card>
        </div>
        <div class="col-md-12">
            <x-adminlte-card title="Data Waktu Antrian" theme="primary" icon="fas fa-info-circle" collapsible>
                @php
                    $heads = ['Tanggal', 'Kodebooking', 'Nomor', 'No RM', 'No BPJS', 'Poliklinik', 'No Referensi', 'Created at', 'Status', 'Action'];
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" bordered hoverable compressed>
                    <div class="hidden" hidden>
                        {{ date_default_timezone_set('Asia/Jakarta') }}
                    </div>
                    @if (isset($antrians))
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $item->tanggal }}</td>
                                <td>
                                    <a href="{{ route('antrianPerKodebooking') }}?kodebooking={{ $item->kodebooking }}"
                                        target="_blank">
                                        {{ $item->kodebooking }}
                                    </a>
                                </td>
                                <td>
                                    {{ $item->noantrean }}
                                </td>
                                <td>
                                    {{ $item->norekammedis }}
                                </td>
                                <td>
                                    {{ $item->nokapst }}
                                </td>
                                <td>
                                    {{ $item->kodepoli }} / {{ $item->kodedokter }}
                                </td>
                                <td>
                                    {{ $item->jeniskunjungan }} / {{ $item->nomorreferensi }}
                                </td>
                                <td>{{ date('Y-m-d H:i:s', $item->createdtime / 1000) }}</td>
                                <td>{{ $item->status }} {{ $item->ispeserta }}</td>
                                <td>
                                    @if ($item->status != 'Selesai dilayani')
                                        <a class="btn btn-danger btn-xs"
                                            href="{{ route('antrianKodebookingLanjut') }}?kodebooking={{ $item->kodebooking }}">Batal</a>
                                    @endif
                                </td>
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
@section('plugins.DateRangePicker', true)
