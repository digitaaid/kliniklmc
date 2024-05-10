@extends('adminlte::page')

@section('title', 'Dokter')

@section('content_header')
    <h1>Dokter</h1>
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
                <x-adminlte-button onclick="btnTambah()" class="btn-sm mb-2" theme="success" label="Tambah Pasien"
                    icon="fas fa-plus" />
                <a href="{{ route('dokter.create') }}" class="btn btn-sm btn-warning mb-2"><i class="fas fa-sync"></i>
                    Syncron HAFIS</a>
                @php
                    $heads = [
                        'ID',
                        'Nama Dokter',
                        'Action',
                        'Kode',
                        'Kode HAFIS',
                        'NIK',
                        'IdSatusehat',
                        'Sex',
                        'Title',
                        'SIP',
                        'Status',
                        'PIC',
                        'Updated_at',
                    ];
                    $config['scrollX'] = true;
                @endphp
                <x-adminlte-datatable id="table2" class="nowrap" :heads="$heads" :config="$config" bordered hoverable
                    compressed>
                    @foreach ($dokter as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->namadokter }}</td>
                            <td>
                                <x-adminlte-button class="btn-xs" onclick="btnEdit(this)" theme="warning" label="Edit"
                                    icon="fas fa-edit" title="Edit Dokter {{ $item->namadokter }}"
                                    data-id="{{ $item->id }}" data-nik="{{ $item->nik }}"
                                    data-namadokter="{{ $item->namadokter }}" data-kodedokter="{{ $item->kodedokter }}"
                                    data-subtitle="{{ $item->subtitle }}" data-gender="{{ $item->gender }}"
                                    data-sip="{{ $item->sip }}" data-kodejkn="{{ $item->kodejkn }}" />
                                <x-adminlte-button class="btn-xs btnDelete" onclick="btnDelete(this)" theme="danger"
                                    icon="fas fa-trash-alt" title="Non-Aktifkan Pasien {{ $item->namadokter }} "
                                    data-id="{{ $item->id }}" data-name="{{ $item->namadokter }}" />
                            </td>
                            <td>{{ $item->kodedokter }}</td>
                            <td>{{ $item->kodejkn }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->idsatusehat }}</td>
                            <td>{{ $item->gender }}</td>
                            <td>{{ $item->subtitle }}</td>
                            <td>{{ $item->sip }}</td>
                            <td>
                                @if ($item->status)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Non-Aktif</span>
                                @endif
                            </td>
                            <td>{{ $item->pic ? $item->pic->name : $item->user }}</td>
                            <td>{{ $item->updated_at }}</td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalEdit" title="Edit Dokter" theme="warning" icon="fas fa-user-plus">
        <form name="formDokter" id="formDokter" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="namadokter" placeholder="Nama Dokter" label="Nama Dokter" />
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="kodedokter" placeholder="Kode Dokter" label="Kode Dokter" />
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="nik" placeholder="NIK" label="NIK" />
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="idsatusehat" placeholder="IdSatusehat" label="IdSatusehat" />
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="kodejkn" placeholder="Kode BPJS" label="Kode BPJS" />
            <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="subtitle" label="Title">
                <option selected disabled>Pilih Title Dokter</option>
                <option>Dokter Sub Spesialis</option>
                <option>Dokter Spesialis</option>
                <option>Dokter Umum</option>
                <option>Dokter Laboratorium</option>
                <option>Dokter Radiologi</option>
            </x-adminlte-select>
            <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="gender" label="Gender">
                <option selected disabled>Pilih Jenis Kelamin</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </x-adminlte-select>
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="sip" placeholder="SIP Dokter" label="SIP Dokter" />
            <x-slot name="footerSlot">
                <x-adminlte-button id="btnStore" onclick="btnStore()" class="mr-auto" type="submit"
                    icon="fas fa-save" theme="success" label="Simpan" />
                <x-adminlte-button id="btnUpdate" onclick="btnUpdate()" class="mr-auto" type="submit"
                    icon="fas fa-edit" theme="warning" label="Update" />
                <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
            </x-slot>
        </form>
        <form id="formDelete" action="" method="POST">
            @csrf
            @method('DELETE')
        </form>
    </x-adminlte-modal>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('js')
    <script>
        $(function() {
            $('.').click(function(e) {

            });
        });
    </script>

    <script>
        function btnTambah() {
            $.LoadingOverlay("show");
            $('#btnStore').show();
            $('#btnUpdate').hide();
            $('#formDokter').trigger("reset");
            $('#modalEdit').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnEdit(button) {
            $.LoadingOverlay("show");
            $('#btnStore').hide();
            $('#btnUpdate').show();
            $('#formDokter').trigger("reset");
            var id = $(button).data("id");
            $('#id').val(id);
            $('#namadokter').val($(button).data("namadokter"));
            $('#nik').val($(button).data("nik"));
            $('#kodedokter').val($(button).data("kodedokter"));
            $('#subtitle').val($(button).data("subtitle"));
            $('#gender').val($(button).data("gender"));
            $('#sip').val($(button).data("sip"));
            $('#kodejkn').val($(button).data("kodejkn"));
            $('#modalEdit').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnUpdate() {
            $.LoadingOverlay("show");
            var id = $('#id').val();
            var url = "{{ route('dokter.index') }}/" + id;
            $('#formDokter').attr('action', url);
            $('#method').val('PUT');
            $('#formDokter').submit();
        }

        function btnStore() {
            $.LoadingOverlay("show");
            var url = "{{ route('dokter.store') }}";
            $('#formDokter').attr('action', url);
            $("#method").prop('', true);
            $('#formDokter').submit();
        }

        function btnDelete(button) {
            var name = $(button).data("name");
            swal.fire({
                title: 'Apakah anda ingin menonaktifkan dokter ' + name + ' ?',
                showConfirmButton: false,
                showDenyButton: true,
                showCancelButton: true,
                denyButtonText: `Ya, Non Aktifkan`,
            }).then((result) => {
                if (result.isDenied) {
                    $.LoadingOverlay("show");
                    var id = $(button).data("id");
                    var url = "{{ route('dokter.index') }}/" + id;
                    $('#formDelete').attr('action', url);
                    $('#formDelete').submit();
                }
            });
        }
    </script>
@endsection
