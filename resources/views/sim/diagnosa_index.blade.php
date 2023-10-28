@extends('adminlte::page')
@section('title', 'Diagnosa')
@section('content_header')
    <h1>Diagnosa</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Data Diagnosa" theme="primary" icon="fas fa-info-circle" collapsible>
                @php
                    $heads = ['Kode', 'Diagnosa', 'Action'];
                    $config['order'] = [0, 'asc'];
                    $config['paging'] = false;
                    $config['scrollY'] = '500px';
                @endphp
                <x-adminlte-button id="btnTambah" class="btn-sm" theme="success" label="Tambah Diagnosa" icon="fas fa-plus" />
                {{-- <a href="{{ route('obatexport') }}" class="btn btn-sm btn-primary"><i class="fas fa-print"></i> Export</a> --}}
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($diagnosa as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->diagnosa }}</td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" theme="warning" icon="fas fa-edit"
                                    title="Edit Obat {{ $item->diagnosa }}" data-id="{{ $item->id }}"
                                    data-diagnosa="{{ $item->diagnosa }}" />
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalDiagnosa" title="Diagnosa" icon="fas fa-pills" theme="success" v-centered static-backdrop>
        <form action="" id="formDiagnosa" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <x-adminlte-input name="diagnosa" label="Diagnosa" placeholder="Diagnosa" enable-old-support required />
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
@section('js')
    <script>
        $(function() {
            $('#btnTambah').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').show();
                $('#btnUpdate').hide();
                $('#formDiagnosa').trigger("reset");
                $('#modalDiagnosa').modal('show');
                $.LoadingOverlay("hide");
            });
            $('.btnEdit').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').hide();
                $('#btnUpdate').show();
                $('#formDiagnosa').trigger("reset");
                // get
                $('#id').val($(this).data("id"));
                $('#diagnosa').val($(this).data("diagnosa"));
                $('#modalDiagnosa').modal('show');
                $.LoadingOverlay("hide");
            });
            $('#btnStore').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('diagnosa.store') }}";
                $('#formDiagnosa').attr('action', url);
                $("#method").prop('', true);
                $('#formDiagnosa').submit();

            });
            $('#btnUpdate').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var id = $('#id').val();
                var url = "{{ route('diagnosa.index') }}/" + id;
                $('#formDiagnosa').attr('action', url);
                $('#method').val('PUT');
                $('#formDiagnosa').submit();
            });
            // $('.btnDelete').click(function(e) {
            //     e.preventDefault();
            //     var name = $(this).data("name");
            //     swal.fire({
            //         title: 'Apakah anda ingin menghapus user ' + name + ' ?',
            //         showConfirmButton: false,
            //         showDenyButton: true,
            //         showCancelButton: true,
            //         denyButtonText: `Ya, Hapus`,
            //     }).then((result) => {
            //         if (result.isDenied) {
            //             $.LoadingOverlay("show");
            //             var id = $(this).data("id");
            //             var url = "{{ route('diagnosa.index') }}/" + id;
            //             $('#formDelete').attr('action', url);
            //             $('#formDelete').submit();
            //         }
            //     })
            // });
        });
    </script>
@endsection
