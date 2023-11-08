@extends('adminlte::page')

@section('title', 'Poliklinik')

@section('content_header')
    <h1>Poliklinik</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Data Poliklinik" theme="primary" icon="fas fa-info-circle" collapsible>
                @php
                    $heads = ['ID', 'Nama Subspesialis', 'Kode Poliklinik', 'Kode Subspesialis', 'Status'];
                    $config['order'] = [4, 'asc'];
                @endphp
                <x-adminlte-datatable id="table1" :heads="$heads" bordered :config="$config" hoverable compressed>
                    @foreach ($polikliniks as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->namasubspesialis }}</td>
                            <td>{{ $item->kodepoli }}</td>
                            <td>{{ $item->kodesubspesialis }}</td>
                            <td>
                                @if ($item->status)
                                    <a href="{{ route('poliklinik.edit', $item) }}" class="btn btn-xs btn-success">Aktif</a>
                                @else
                                    <a href="{{ route('poliklinik.edit', $item) }}"
                                        class="btn btn-xs btn-danger">Non-Aktif</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
                <a href="{{ route('poliklinik.create') }}" class="btn btn-warning">Refresh Data Poliklinik</a>
            </x-adminlte-card>
        </div>
    </div>
@stop
@section('plugins.Datatables', true)
