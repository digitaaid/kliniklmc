@extends('adminlte::page')
@section('title', 'Stok Obat')
@section('content_header')
    <h1>Stok Obat</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Data Pemesanan Obat" theme="warning" icon="fas fa-info-circle" collapsible>
                @php
                    $heads = ['No', 'Nama', 'Min Stok', 'Jumlah', 'Status', 'Action'];
                    $config['order'] = [0, 'asc'];
                    $config['paging'] = false;
                    $config['scrollY'] = '500px';
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered hoverable
                    compressed>
                    @foreach ($obats as $key => $item)
                        <tr class="{{ $item->real_stok < $item->stok_minimum ? 'table-danger' : '' }} ">
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->stok_minimum }}</td>
                            <td>{{ $item->real_stok }}</td>
                            <td>
                                @if ($item->real_stok < $item->stok_minimum)
                                    Batas Stok
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('stokobat.show', $item->id) }}" class="btn btn-xs btn-primary"><i
                                        class="fas fa-box"></i> Stok</a>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Select2', true)
