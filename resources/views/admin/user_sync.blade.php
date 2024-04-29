@extends('adminlte::page')
@section('title', 'User Synchronize')
@section('content_header')
    <h1>User Synchronize</h1>
@stop
@section('content')
    <a href="{{ route('user.index') }}" class="btn btn-danger mb-2">Back</a>
    <a href="{{ route('user_sync') }}" class="btn btn-primary mb-2">Syncronize</a>
    <div class="row">
        <div class="col-6">
            <x-adminlte-card title="Data User Local" theme="secondary" collapsible>
                @php
                    $heads = ['Id', 'Nama', 'Username', 'Status'];
                    $config['paging'] = false;
                    $config['lengthMenu'] = false;
                    $config['searching'] = false;
                    $config['info'] = false;
                    $config['responsive'] = true;
                @endphp
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" hoverable bordered compressed>
                    @foreach ($users as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->username }}</td>
                            <td>
                                @if ($data->firstWhere('username', $item->username))
                                    Ok
                                @else
                                    Not Sync
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
        <div class="col-6">
            <x-adminlte-card title="Data User Server" theme="secondary" collapsible>
                @php
                    $heads = ['Id', 'Nama', 'Username', 'Status'];
                    $config['paging'] = false;
                    $config['lengthMenu'] = false;
                    $config['searching'] = false;
                    $config['info'] = false;
                    $config['responsive'] = true;
                @endphp
                <x-adminlte-datatable id="table2" :heads="$heads" :config="$config" hoverable bordered compressed>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->username }}</td>
                            <td>
                                @if ($users->firstWhere('username', $item->username))
                                    Ok
                                @else
                                    Not Sync
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>

@stop
@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
