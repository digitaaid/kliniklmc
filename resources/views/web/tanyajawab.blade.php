@extends('adminlte::page')
@section('title', 'Tanya Jawab')
@section('content_header')
    <h1>Tanya Jawab</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Data Tanya Jawab" theme="secondary" collapsible>
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
                            title="Tambah" icon="fas fa-plus" />
                    </div>
                </div>
                @php
                    $heads = ['No', 'Pertanyaan', 'Jawaban', 'Status', 'Action'];
                    $config['paging'] = false;
                @endphp
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" hoverable bordered compressed>
                    @foreach ($tanyajawab as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->pertanyaan }}</td>
                            <td>{{ $item->jawaban }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" label="Edit" theme="warning" icon="fas fa-edit"
                                    title="Edit" data-id="{{ $item->id }}" data-pertanyaan="{{ $item->pertanyaan }}"
                                    data-jawaban="{{ $item->jawaban }}" data-status="{{ $item->status }}" />
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalItem" title="Tanya Jawab" icon="fas fa-globe" theme="success" v-centered>
        <form action="" id="formAPI" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <x-adminlte-input name="pertanyaan" igroup-size="sm" label="Pertanyaan" enable-old-support required />
            <x-adminlte-input name="jawaban" igroup-size="sm" label="Jawaban" enable-old-support required />
            <img id="my_image" src="" class="w-100" />
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
@section('plugins.BsCustomFileInput', true)
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
                $("#my_image").attr("src", "");
                $('#modalItem').modal('show');
                $.LoadingOverlay("hide");
            });
            $('.btnEdit').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').hide();
                $('#btnUpdate').show();
                $('#formAPI').trigger("reset");
                $('#id').val($(this).data("id"));
                $('#pertanyaan').val($(this).data("pertanyaan"));
                $('#jawaban').val($(this).data("jawaban"));
                $('#status').val($(this).data("button_text"));
                $('#modalItem').modal('show');
                $.LoadingOverlay("hide");
            });
            $('#btnStore').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('tanyajawab.store') }}";
                $('#formAPI').attr('action', url);
                $("#method").prop('', true);
                $('#formAPI').submit();

            });
            $('#btnUpdate').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var id = $('#id').val();
                var url = "{{ route('tanyajawab.index') }}/" + id;
                $('#formAPI').attr('action', url);
                $('#method').val('PUT');
                $('#formAPI').submit();
            });
        });
    </script>
@endsection
