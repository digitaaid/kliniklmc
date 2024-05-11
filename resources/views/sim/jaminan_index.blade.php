@extends('adminlte::page')

@section('title', 'Jaminan')

@section('content_header')
    <h1>Jaminan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Data Poliklinik" theme="primary" icon="fas fa-info-circle" collapsible>
                @php
                    $heads = ['ID', 'Kode', 'Nama Jaminan', 'Slug', 'Updated_at', 'Action'];
                @endphp
                <x-adminlte-datatable id="table1" :heads="$heads" bordered hoverable compressed>
                    @foreach ($jaminans as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->slug }}</td>
                            <td>{{ $item->updated_at }}</td>

                            <td></td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop
@section('plugins.Datatables', true)
