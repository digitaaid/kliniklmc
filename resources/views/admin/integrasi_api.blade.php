@extends('adminlte::page')
@section('title', 'Integration Management')
@section('content_header')
    <h1>Integration Management</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Data API Integration" theme="secondary" collapsible>
                @if ($errors->any())
                    <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-adminlte-alert>
                @endif
                <div class="row">
                    <div class="col-md-8">
                        <x-adminlte-button id="btnTambah" name="btnTambah" label="Tambah" class="btn-sm" theme="success"
                            title="Tambah User" icon="fas fa-plus" />
                        <x-adminlte-button label="Refresh" class="btn-sm" theme="warning" title="Refresh User"
                            icon="fas fa-sync" onclick="window.location='{{ route('integrasiAPI.index') }}'" />
                    </div>

                </div>
                @php
                    $heads = ['No', 'Nama', 'UserID', 'BaseURL', 'AuthURL',  'Description', 'Action'];
                    $config['paging'] = false;
                @endphp
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" hoverable bordered compressed>
                    @foreach ($api as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                {{ Str::mask($item->user_id, '*', 1, Str::length($item->user_id) - 2) }}
                            </td>
                            <td>{{ $item->base_url }}</td>
                            <td>{{ $item->auth_url }}</td>
                            <td>{{ $item->description }}</td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" label="Edit" theme="warning" icon="fas fa-edit"
                                    title="Edit API {{ $item->name }}" data-id="{{ $item->id }}"
                                    data-name="{{ $item->name }}" data-user_id="{{ $item->user_id }}"
                                    data-base_url="{{ $item->base_url }}" data-auth_url="{{ $item->auth_url }}"
                                    data-user_key="{{ $item->user_key }}" data-secret_key="{{ $item->secret_key }}"
                                    data-description="{{ $item->description }}" />
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalAPI" title="Integrasi API" icon="fas fa-globe" theme="success" v-centered static-backdrop>
        <form action="" id="formAPI" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <x-adminlte-input name="name" label="Nama" enable-old-support required />
            <x-adminlte-input name="user_id" label="UserID" enable-old-support required />
            <x-adminlte-input name="base_url" label="BaseURL" enable-old-support required />
            <x-adminlte-input name="auth_url" label="AuthURL" enable-old-support required />
            <x-adminlte-input name="user_key" label="UserKey" enable-old-support required />
            <x-adminlte-input name="secret_key" label="SecretKey" enable-old-support required />
            <x-adminlte-input name="description" label="Description" enable-old-support required />
        </form>
        <form id="formDelete" action="" method="POST">
            @csrf
            @method('DELETE')
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button id="btnStore" class="mr-auto" type="submit" icon="fas fa-save" theme="success"
                label="Simpan" />
            <x-adminlte-button id="btnUpdate" class="mr-auto" type="submit" icon="fas fa-edit" theme="warning"
                label="Update" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop
@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('js')
    <script>
        $(function() {
            $('#btnTambah').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').show();
                $('#btnUpdate').hide();
                $('#formAPI').trigger("reset");
                $("#role").val('').change();
                $('#modalAPI').modal('show');
                $.LoadingOverlay("hide");
            });
            $('.btnEdit').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').hide();
                $('#btnUpdate').show();
                $('#formAPI').trigger("reset");
                $('#id').val($(this).data("id"));
                $('#name').val($(this).data("name"));
                $('#user_id').val($(this).data("user_id"));
                $('#base_url').val($(this).data("base_url"));
                $('#auth_url').val($(this).data("auth_url"));
                $('#user_key').val($(this).data("user_key"));
                $('#secret_key').val($(this).data("secret_key"));
                $('#description').val($(this).data("description"));
                $('#modalAPI').modal('show');
                $.LoadingOverlay("hide");
            });
            $('#btnStore').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('integrasiAPI.store') }}";
                $('#formAPI').attr('action', url);
                $("#method").prop('', true);
                $('#formAPI').submit();

            });
            $('#btnUpdate').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var id = $('#id').val();
                var url = "{{ route('integrasiAPI.index') }}/" + id;
                $('#formAPI').attr('action', url);
                $('#method').val('PUT');
                $('#formAPI').submit();
            });
        });
    </script>
@endsection
