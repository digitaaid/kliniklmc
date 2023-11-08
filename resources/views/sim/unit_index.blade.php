@extends('adminlte::page')

@section('title', 'Unit')

@section('content_header')
    <h1>Unit</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Data Poliklinik" theme="primary" icon="fas fa-info-circle" collapsible>
                @php
                    $heads = ['ID', 'Kode Unit', 'Nama Unit', 'Kode Poliklinik', 'Jenis Unit'];
                @endphp
                <x-adminlte-datatable id="table1" :heads="$heads" bordered hoverable compressed>
                    @foreach ($units as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kodejkn }}</td>
                            <td>
                                @switch($item->status)
                                    @case(1)
                                        Pelayanan
                                    @break

                                    @case(2)
                                        Non-Pelayanan
                                    @break

                                    @default
                                @endswitch
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop
@section('plugins.Datatables', true)
