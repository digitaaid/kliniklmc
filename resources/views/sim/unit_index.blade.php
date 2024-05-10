@extends('adminlte::page')

@section('title', 'Unit')

@section('content_header')
    <h1>Unit</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
            <x-adminlte-card theme="primary" theme-mode="outline">
                <x-adminlte-button onclick="btnTambah()" class="btn-sm mb-2" theme="success" label="Tambah Unit"
                    icon="fas fa-plus" />
                @php
                    $heads = [
                        'Id',
                        'Nama Unit',
                        'Action',
                        'Jenis',
                        'Lokasi',
                        'Kode Unit',
                        'Kode Poliklinik',
                        'IdSatusehat',
                        'Status',
                    ];
                    $config['scrollX'] = true;
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($units as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>
                                <x-adminlte-button class="btn-xs" onclick="btnEdit(this)" theme="warning" icon="fas fa-edit"
                                    title="Edit Unit {{ $item->nama }}" data-id="{{ $item->id }}"
                                    data-kode="{{ $item->kode }}" data-nama="{{ $item->nama }}"
                                    data-kodejkn="{{ $item->kodejkn }}" data-idsatusehat="{{ $item->idsatusehat }}"
                                    data-jenis="{{ $item->jenis }}" data-lokasi="{{ $item->lokasi }}" />
                                <x-adminlte-button class="btn-xs" onclick="btnDelete(this)" theme="danger"
                                    icon="fas fa-trash-alt" title="Non-Aktifkan Unit {{ $item->nama }} "
                                    data-id="{{ $item->id }}" data-nama="{{ $item->nama }}" />
                            </td>
                            <td>{{ $item->jenis }}</td>
                            <td>{{ $item->lokasi }}</td>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->kodejkn }}</td>
                            <td>{{ $item->idsatusehat }}</td>
                            <td>
                                @if ($item->status)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Non-Aktif</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalEdit" title="Tambah/Edit Unit" theme="warning" icon="fas fa-user-plus">
        <form name="formUnit" id="formUnit" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="nama" placeholder="Nama Unit" label="Nama Unit" />
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="kode" placeholder="Kode Unit" label="Kode Unit" />
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="kodejkn" placeholder="Kode Poliklinik" label="Kode Poliklinik" />
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="idsatusehat" placeholder="IdSatusehat" label="IdSatusehat" />
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="lokasi" placeholder="Lokasi" label="Lokasi" />
            <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="jenis" label="Jenis">
                <option selected disabled>Pilih Jenis</option>
                <option>Rawat Jalan</option>
                <option>Rawat Inap</option>
                <option>IGD</option>
                <option>Penunjang</option>
                <option>Laboratorium</option>
                <option>Radiologi</option>
                <option>Gudang Farmasi</option>
            </x-adminlte-select>
            <x-slot name="footerSlot">
                <x-adminlte-button id="btnStore" onclick="btnStore()" class="mr-auto" type="submit" icon="fas fa-save"
                    theme="success" label="Simpan" />
                <x-adminlte-button id="btnUpdate" onclick="btnUpdate()" class="mr-auto" type="submit" icon="fas fa-edit"
                    theme="warning" label="Update" />
                <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
            </x-slot>
        </form>
        <form id="formDelete" action="" method="POST">
            @csrf
            @method('DELETE')
        </form>
    </x-adminlte-modal>
@stop
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('js')
    <script>
        function btnTambah() {
            $.LoadingOverlay("show");
            $('#btnStore').show();
            $('#btnUpdate').hide();
            $('#formUnit').trigger("reset");
            $('#modalEdit').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnEdit(button) {
            $.LoadingOverlay("show");
            $('#btnStore').hide();
            $('#btnUpdate').show();
            $('#formUnit').trigger("reset");
            $('#id').val($(button).data("id"));
            $('#nama').val($(button).data("nama"));
            $('#lokasi').val($(button).data("lokasi"));
            $('#kodejkn').val($(button).data("kodejkn"));
            $('#kode').val($(button).data("kode"));
            $('#idsatusehat').val($(button).data("idsatusehat"));
            $('#jenis').val($(button).data("jenis"));
            $('#modalEdit').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnUpdate() {
            $.LoadingOverlay("show");
            var id = $('#id').val();
            var url = "{{ route('unit.index') }}/" + id;
            $('#formUnit').attr('action', url);
            $('#method').val('PUT');
            $('#formUnit').submit();
        }

        function btnStore() {
            $.LoadingOverlay("show");
            var url = "{{ route('unit.store') }}";
            $('#formUnit').attr('action', url);
            $("#method").prop('', true);
            $('#formUnit').submit();
        }

        function btnDelete(button) {
            var nama = $(button).data("nama");
            swal.fire({
                title: 'Konfirmasi Tindakan ?',
                text: 'Apakah anda ingin menonaktifkan Unit ' + nama + ' ?',
                showConfirmButton: false,
                showDenyButton: true,
                showCancelButton: true,
                denyButtonText: `Ya, Non Aktifkan`,
            }).then((result) => {
                if (result.isDenied) {
                    $.LoadingOverlay("show");
                    var id = $(button).data("id");
                    var url = "{{ route('unit.index') }}/" + id;
                    $('#formDelete').attr('action', url);
                    $('#formDelete').submit();
                }
            });
        }
    </script>
@endsection
