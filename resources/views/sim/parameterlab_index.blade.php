@extends('adminlte::page')

@section('title', 'Parameter Laboratorium')

@section('content_header')
    <h1>Parameter Laboratorium</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Data Parameter Laboratorium" theme="primary" icon="fas fa-info-circle" collapsible>
                @php
                    $heads = ['Nama Parameter', 'Satuan', 'Nilai Rujukan', 'Untuk Pemeriksaan', 'Status', 'Action'];
                    $config['order'] = [0, 'asc'];
                    $config['paging'] = false;
                    $config['scrollY'] = '500px';
                @endphp
                <x-adminlte-button id="btnTambah" class="btn-sm" theme="success" label="Tambah Pemeriksaan Laboratorium"
                    icon="fas fa-plus" />
                <a href="{{ route('obatexport') }}" class="btn btn-sm btn-primary"><i class="fas fa-print"></i> Export</a>
                {{-- <div class="btn btn-sm btn-primary btnModalImport"><i class="fas fa-file-medical"></i> Import</div> --}}
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($parameter as $item)
                        <tr>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td>{{ $item->nilai_rujukan }}</td>
                            <td>
                                @foreach ($item->pemeriksaans as $prksa)
                                    {{ $prksa->nama }} <br>
                                @endforeach
                            </td>
                            <td>{{ $item->status }}</td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" theme="warning" icon="fas fa-edit"
                                    title="Edit Pemeriksaan Laboratoirum {{ $item->nama }}" data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama }}" data-nilai_rujukan="{{ $item->nilai_rujukan }}"
                                    data-satuan="{{ $item->satuan }}" />
                                <x-adminlte-button class="btn-xs btnDelete" theme="danger" icon="fas fa-trash-alt"
                                    title="Hapus Pemeriksaan Laboratorium {{ $item->nama }} "
                                    data-id="{{ $item->id }}" data-nama="{{ $item->nama }}" />
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalLab" title="Parameter Laboratorium" icon="fas fa-pills" theme="success" static-backdrop>
        <form action="" id="formLab" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <x-adminlte-input name="nama" label="Nama Parameter" placeholder="Nama Parameter" enable-old-support
                required />
            <x-adminlte-select2 id="pemeriksaanLab" name="pemeriksaan[]" label="Untuk Pemeriksaan"
                placeholder="Untuk Pemeriksaan" multiple required>
                @foreach ($pemeriksaan as $kode => $item)
                    <option value="{{ $kode }}">{{ $item }}</option>
                @endforeach
            </x-adminlte-select2>
            <x-adminlte-input name="nilai_rujukan" label="Nilai Rujukan" placeholder="Nilai Rujukan" enable-old-support
                required />
            <x-adminlte-input name="satuan" label="Satuan" placeholder="Satuan" enable-old-support required />
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
    <x-adminlte-modal id="modalImport" title="Import Obat" icon="fas fa-pills" theme="success" static-backdrop>
        <form action="{{ route('pemeriksaanlabimport') }}" id="formImport" name="formImport" method="POST"
            enctype="multipart/form-data">
            @csrf
            <x-adminlte-input-file name="file" placeholder="Pilih file Import" igroup-size="sm"
                label="File Import Obat" />
            <x-slot name="footerSlot">
                <x-adminlte-button form="formImport" class="mr-auto" type="submit" icon="fas fa-save" theme="success"
                    label="Import" />
                <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>
@stop
@section('plugins.Datatables', true)
@section('plugins.BsCustomFileInput', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('js')
    <script>
        $(function() {
            $('#btnTambah').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').show();
                $('#btnUpdate').hide();
                $('#formLab').trigger("reset");
                $('#modalLab').modal('show');
                $.LoadingOverlay("hide");
            });
            $('.btnEdit').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').hide();
                $('#btnUpdate').show();
                $('#formLab').trigger("reset");
                // get
                $('#id').val($(this).data("id"));
                $('#nama').val($(this).data("nama"));
                $('#nilai_rujukan').val($(this).data("nilai_rujukan"));
                $('#satuan').val($(this).data("satuan"));
                $('#group').val($(this).data("group")).change();
                $('#modalLab').modal('show');
                $.LoadingOverlay("hide");
            });
            $('#btnStore').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('parameterlab.store') }}";
                $('#formLab').attr('action', url);
                $("#method").prop('', true);
                $('#formLab').submit();
            });
            $('#btnUpdate').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var id = $('#id').val();
                var url = "{{ route('parameterlab.index') }}/" + id;
                $('#formLab').attr('action', url);
                $('#method').val('PUT');
                $('#formLab').submit();
            });
            // $('.btnModalImport').click(function() {
            //     $.LoadingOverlay("show");
            //     $('#modalImport').modal('show');
            //     $.LoadingOverlay("hide");
            // });
            $('.btnDelete').click(function(e) {
                e.preventDefault();
                var nama = $(this).data("nama");
                swal.fire({
                    title: 'Apakah anda ingin menghapus pemeriksaan laboratorium ' + nama + ' ?',
                    showConfirmButton: false,
                    showDenyButton: true,
                    showCancelButton: true,
                    denyButtonText: `Ya, Hapus`,
                }).then((result) => {
                    if (result.isDenied) {
                        $.LoadingOverlay("show");
                        var id = $(this).data("id");
                        var url = "{{ route('parameterlab.index') }}/" + id;
                        $('#formDelete').attr('action', url);
                        $('#formDelete').submit();
                    }
                })
            });
        });
    </script>
@endsection
