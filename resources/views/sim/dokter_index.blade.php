@extends('adminlte::page')

@section('title', 'Dokter')

@section('content_header')
    <h1>Dokter</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Data Dokter" theme="primary" icon="fas fa-info-circle" collapsible>
                @php
                    $heads = ['ID', 'Kode', 'Nama Dokter', 'Sex', 'Title', 'SIP', 'Kode BPJS', 'Status', 'Action'];
                @endphp
                <x-adminlte-datatable id="table2" :heads="$heads" bordered hoverable compressed>
                    @foreach ($dokter as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->kodedokter }}</td>
                            <td>{{ $item->namadokter }}</td>
                            <td>{{ $item->gender }}</td>
                            <td>{{ $item->subtitle }}</td>
                            <td>{{ $item->sip }}</td>
                            <td>{{ $item->kodejkn }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" theme="warning" icon="fas fa-edit"
                                    title="Edit Dokter {{ $item->namadokter }}" data-id="{{ $item->id }}"
                                    data-namadokter="{{ $item->namadokter }}" data-kodedokter="{{ $item->kodedokter }}"
                                    data-subtitle="{{ $item->subtitle }}" data-gender="{{ $item->gender }}" data-sip="{{ $item->sip }}"
                                    data-kodejkn="{{ $item->kodejkn }}" />
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
                <a href="{{ route('dokter.create') }}" class="btn btn-warning">Refresh Data Dokter</a>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalEdit" title="Edit Dokter" theme="warning" icon="fas fa-user-plus">
        <form name="formDokter" id="formDokter" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <x-adminlte-input name="namadokter" placeholder="Nama Dokter" label="Nama Dokter" />
            <x-adminlte-input name="kodedokter" placeholder="Kode Dokter" label="Kode Dokter" />
            <x-adminlte-input name="subtitle" placeholder="Subtitle" label="Subtitle" />
            <x-adminlte-input name="gender" placeholder="Gender" label="Gender" />
            <x-adminlte-input name="sip" placeholder="SIP Dokter" label="SIP Dokter" />
            <x-adminlte-input name="kodejkn" placeholder="Kode BPJS" label="Kode BPJS" />
            <x-slot name="footerSlot">
                <x-adminlte-button id="btnStore" class="mr-auto" type="submit" icon="fas fa-save" theme="success"
                    label="Simpan" />
                <x-adminlte-button id="btnUpdate" class="mr-auto" type="submit" icon="fas fa-edit" theme="warning"
                    label="Update" />
                <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>
    {{-- <x-adminlte-modal id="modalUser" title="User" icon="fas fa-user" theme="success" v-centered static-backdrop>
        <form action="" id="formUser" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <x-adminlte-input name="name" label="Nama" placeholder="Nama Lengkap" enable-old-support required />
            <x-adminlte-select2 id="role" name="role" label="Role / Jabatan" enable-old-support required>
                <option value="" selected disabled>Pilih Role / Jabatan</option>
                @foreach ($roles as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                @endforeach
            </x-adminlte-select2>
            <x-adminlte-input name="phone" type="number" label="Nomor HP / Telepon"
                placeholder="Nomor HP / Telepon yang dapat dihubungi" enable-old-support />
            <x-adminlte-input name="email" type="email" label="Email" placeholder="Email" enable-old-support
                required />
            <x-adminlte-input name="username" label="Username" placeholder="Username" enable-old-support required />
            <x-adminlte-input name="password" type="password" label="Password" placeholder="Password" required />
            <x-adminlte-input name="password_confirmation" type="password" label="Konfirmasi Password"
                placeholder="Konfirmasi Password" required />
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
    </x-adminlte-modal> --}}
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('js')
    <script>
        $(function() {
            $('.btnEdit').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').hide();
                $('#btnUpdate').show();
                $('#formDokter').trigger("reset");
                var id = $(this).data("id");
                $('#id').val(id);
                $('#namadokter').val($(this).data("namadokter"));
                $('#kodedokter').val( $(this).data("kodedokter"));
                $('#subtitle').val($(this).data("subtitle"));
                $('#gender').val($(this).data("gender"));
                $('#sip').val($(this).data("sip"));
                $('#kodejkn').val($(this).data("kodejkn"));
                $('#modalEdit').modal('show');
                $.LoadingOverlay("hide");
            });
            $('#btnUpdate').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var id = $('#id').val();
                var url = "{{ route('dokter.index') }}/" + id;
                $('#formDokter').attr('action', url);
                $('#method').val('PUT');
                $('#formDokter').submit();
            });
        });
    </script>
@endsection
