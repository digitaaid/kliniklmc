@extends('adminlte::page')
@section('title', 'Permintaan Laboratorium')
@section('content_header')
    <h1>Permintaan Laboratorium</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Filter Data Permintaan" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tanggalperiksa" label="Tanggal Antrian"
                                value="{{ $request->tanggalperiksa ?? now()->format('Y-m-d') }}" placeholder="Pilih Tanggal"
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
        @if (isset($permintaanlab))
            <div class="col-md-12">
                <x-adminlte-card title="Data Permintaan Laboratorium" theme="warning" icon="fas fa-info-circle" collapsible>
                    @php
                        $heads = ['Kode', 'Waktu', 'Pasien', 'Permeriksaan', 'PIC', 'Status', 'Action'];
                        $config['order'] = [1, 'desc'];
                        $config['paging'] = false;
                        $config['scrollY'] = '300px';
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($permintaanlab as $item)
                            <tr>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->waktu }}</td>
                                <td>{{ $item->norm }} / {{ $item->nama }}</td>
                                <td>
                                    @foreach (json_decode($item->permintaan_lab) as $pemeriksaan)
                                        - {{ $pemeriksaanlab[$pemeriksaan] }}<br>
                                    @endforeach
                                </td>
                                <td>{{ $item->user }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    <a href="{{ route('permintaanlab_proses') }}?kode={{ $item->kode }}"
                                        class="btn btn-xs btn-primary"><i class="fas fa-vials"></i> Proses</a>
                                </td>
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
@section('plugins.Select2', true)
