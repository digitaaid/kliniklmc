@extends('adminlte::page')

@section('title', 'Obat')

@section('content_header')
    <h1>Obat</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Data Obat" theme="primary" icon="fas fa-info-circle" collapsible>
                @php
                    $heads = ['Kode', 'Nama Obat', 'Satuan', 'Harga', 'Jenis Obat', 'Tipe Barang', 'Status', 'Action'];
                    $config['order'] = [1, 'asc'];
                    $config['paging'] = false;
                    $config['scrollY'] = '500px';
                @endphp
                <x-adminlte-button id="btnTambah" class="btn-sm" theme="success" label="Tambah Obat" icon="fas fa-plus" />
                <a href="{{ route('obatexport') }}" class="btn btn-sm btn-primary"><i class="fas fa-print"></i> Export</a>
                <div class="btn btn-sm btn-primary btnModalImport"><i class="fas fa-file-medical"></i> Import</div>
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($obats as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td>{{ money($item->harga ?? 0, 'IDR') }}</td>
                            <td>{{ $item->jenisobat }}</td>
                            <td>{{ $item->tipebarang }}</td>
                            <td>
                                @if ($item->status)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Non-Aktif</span>
                                @endif
                            </td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" theme="warning" label="Edit" icon="fas fa-edit"
                                    title="Edit Obat {{ $item->nama }}" data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama }}" data-jenisobat="{{ $item->jenisobat }}"
                                    data-satuan="{{ $item->satuan }}" data-harga="{{ $item->harga }}"
                                    data-tipebarang="{{ $item->tipebarang }}" />
                                <x-adminlte-button class="btn-xs btnDelete" theme="danger" icon="fas fa-trash-alt"
                                    title="Non-Aktifkan Obat {{ $item->nama }} " data-id="{{ $item->id }}"
                                    data-name="{{ $item->nama }}" />
                                <x-adminlte-button class="btn-xs" theme="secondary" label="PIC" icon="fas fa-user"
                                    title="PIC {{ $item->pic ? $item->pic->name : $item->user }} {{ $item->updated_at }}" />
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalObat" title="Obat" icon="fas fa-pills" theme="success" static-backdrop>
        <form action="" id="formObat" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <x-adminlte-input name="nama" label="Nama Obat" placeholder="Nama Lengkap" enable-old-support required />
            <x-adminlte-input name="harga" type="number" label="Harga Satuan" placeholder="Harga Obat Satuan"
                enable-old-support required />
            <x-adminlte-select2 name="satuan" label="Satuan">
                <option value="">Satuan Obat (Kosong)</option>
                <option value="Tablet">Tablet</option>
                <option value="Kaplet">Kaplet</option>
                <option value="Kapsul">Kapsul</option>
                <option value="Ampul">Ampul</option>
                <option value="Tube">Tube</option>
                <option value="Unit">Unit</option>
                <option value="Kotak">Kotak</option>
                <option value="Bungkus">Bungkus</option>
                <option value="Box">Box</option>
                <option value="Sachet">Sachet</option>
                <option value="Bungkus">Bungkus</option>
                <option value="Lembar">Lembar</option>
                <option value="Dus">Dus</option>
                <option value="Strip">Strip</option>
            </x-adminlte-select2>
            <x-adminlte-select2 name="jenisobat" label="Jenis Obat">
                <option value="">Jenis Obat (Kosong)</option>
                <option value="Obat Kemoterapi">Obat Kemoterapi</option>
                <option value="Penunjang Kemoterapi">Penunjang Kemoterapi</option>
            </x-adminlte-select2>
            <x-adminlte-select2 name="tipebarang" label="Tipe Barang">
                <option value="">Tipe Barang (Kosong)</option>
                <option value="Alkes">Alkes</option>
                <option value="BHP">BHP</option>
            </x-adminlte-select2>
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
        <form action="{{ route('obatimport') }}" id="formImport" name="formImport" method="POST"
            enctype="multipart/form-data">
            @csrf
            <x-adminlte-input-file name="file" placeholder="Pilih file Import" igroup-size="sm"
                label="File Import Obat" />
            <x-slot name="footerSlot">
                <x-adminlte-button form="formImport" class="mr-auto withLoad" type="submit" icon="fas fa-save" theme="success"
                    label="Import" />
                <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>

@stop
@section('plugins.Datatables', true)
@section('plugins.BsCustomFileInput', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('js')
    <script>
        $(function() {
            $('#btnTambah').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').show();
                $('#btnUpdate').hide();
                $('#formObat').trigger("reset");
                $('#modalObat').modal('show');
                $.LoadingOverlay("hide");
            });
            $('.btnEdit').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').hide();
                $('#btnUpdate').show();
                $('#formObat').trigger("reset");
                // get
                $('#id').val($(this).data("id"));
                $('#nama').val($(this).data("nama"));
                $('#harga').val($(this).data("harga"));
                $('#satuan').val($(this).data("satuan")).change();
                $('#jenisobat').val($(this).data("jenisobat")).change();
                $('#tipebarang').val($(this).data("tipebarang")).change();
                $('#modalObat').modal('show');
                $.LoadingOverlay("hide");
            });
            $('#btnStore').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('obat.store') }}";
                $('#formObat').attr('action', url);
                $("#method").prop('', true);
                $('#formObat').submit();

            });
            $('#btnUpdate').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var id = $('#id').val();
                var url = "{{ route('obat.index') }}/" + id;
                $('#formObat').attr('action', url);
                $('#method').val('PUT');
                $('#formObat').submit();
            });
            $('.btnModalImport').click(function() {
                $.LoadingOverlay("show");
                $('#modalImport').modal('show');
                $.LoadingOverlay("hide");
            });
            $('.btnDelete').click(function(e) {
                e.preventDefault();
                var name = $(this).data("name");
                swal.fire({
                    title: 'Apakah anda ingin menonaktifkan obat ' + name + ' ?',
                    showConfirmButton: false,
                    showDenyButton: true,
                    showCancelButton: true,
                    denyButtonText: `Ya, Non Aktifkan`,
                }).then((result) => {
                    if (result.isDenied) {
                        $.LoadingOverlay("show");
                        var id = $(this).data("id");
                        var url = "{{ route('obat.index') }}/" + id;
                        $('#formDelete').attr('action', url);
                        $('#formDelete').submit();
                    }
                })
            });
        });
    </script>
@endsection
