@extends('adminlte::page')

@section('title', 'Obat')

@section('content_header')
    <h1>Obat</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Data Poliklinik" theme="primary" icon="fas fa-info-circle" collapsible>
                @php
                    $heads = ['No', 'Nama Obat', 'Satuan'];
                @endphp
            <x-adminlte-button name="btnTambah" class="btn-sm mb-2" theme="success" label="Tambah Obat" icon="fas fa-plus" />

                <x-adminlte-datatable id="table1" :heads="$heads" bordered hoverable compressed>
                    @foreach ($obats as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->satuan }}</td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop
@section('plugins.Datatables', true)
