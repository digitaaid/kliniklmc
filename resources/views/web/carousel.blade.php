@extends('adminlte::page')
@section('title', 'Carousel')
@section('content_header')
    <h1>Carousel</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Data Carousel" theme="secondary" collapsible>
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
                    $heads = ['No', 'Title', 'Button Text', 'Image Url', 'Action'];
                    $config['paging'] = false;
                @endphp
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" hoverable bordered compressed>
                    @foreach ($carousel as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->button_text }}</td>
                            <td>{{ $item->image }}</td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" label="Edit" theme="warning" icon="fas fa-edit"
                                    title="Edit Carousel {{ $item->title }}" data-id="{{ $item->id }}"
                                    data-title="{{ $item->title }}" data-description="{{ $item->description }}"
                                    data-button_text="{{ $item->button_text }}" data-button_url="{{ $item->button_url }}"
                                    data-image="{{ $item->image }}" />
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalItem" title="Carousel Hero" icon="fas fa-globe" theme="success" v-centered >
        <form action="" id="formAPI" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <x-adminlte-input name="title" igroup-size="sm" label="Title" enable-old-support required />
            <x-adminlte-input name="description" igroup-size="sm" label="Description" enable-old-support required />
            <x-adminlte-input name="button_text" igroup-size="sm" label="Button Text" enable-old-support required />
            <x-adminlte-input name="button_url" igroup-size="sm" label="Button Url" enable-old-support required />
            <x-adminlte-input-file name="image" igroup-size="sm" label="Upload Image" placeholder="Pilih file..." />
            <img id="my_image" src="storage/carousel/Cuplikan layar 2023-08-23 113956.png" class="w-100" />
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
                $('#modalItem').modal('show');
                $.LoadingOverlay("hide");
            });
            $('.btnEdit').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').hide();
                $('#btnUpdate').show();
                $('#formAPI').trigger("reset");
                $('#id').val($(this).data("id"));
                $('#title').val($(this).data("title"));
                $('#description').val($(this).data("description"));
                $('#button_text').val($(this).data("button_text"));
                $('#button_url').val($(this).data("button_url"));
                $("#my_image").attr("src", $(this).data("image"));
                $('#modalItem').modal('show');
                $.LoadingOverlay("hide");
            });
            $('#btnStore').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('carousel.store') }}";
                $('#formAPI').attr('action', url);
                $("#method").prop('', true);
                $('#formAPI').submit();

            });
            $('#btnUpdate').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var id = $('#id').val();
                var url = "{{ route('carousel.index') }}/" + id;
                $('#formAPI').attr('action', url);
                $('#method').val('PUT');
                $('#formAPI').submit();
            });
        });
    </script>
@endsection
