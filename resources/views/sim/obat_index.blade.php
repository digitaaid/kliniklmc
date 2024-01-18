@extends('adminlte::page')

@section('title', 'Obat')

@section('content_header')
    <h1>Obat</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Data Obat" theme="primary" icon="fas fa-info-circle" collapsible>
                <div class="row">
                    <div class="col-md-8">
                        <x-adminlte-button onclick="tambahObat()" class="btn-sm" theme="success" label="Tambah Obat"
                            icon="fas fa-plus" />
                        <a href="{{ route('obatexport') }}" class="btn btn-sm btn-primary"><i class="fas fa-print"></i>
                            Export</a>
                        <div class="btn btn-sm btn-primary btnModalImport"><i class="fas fa-file-medical"></i> Import</div>
                    </div>
                    <div class="col-md-4">
                        <form action="" method="get">
                            <x-adminlte-input name="pencarian" placeholder="Pencarian Nama / Kode Obat" igroup-size="sm"
                                value="{{ $request->pencarian }}">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" theme="primary" label="Cari" />
                                </x-slot>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text text-primary">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </form>
                    </div>
                </div>
                @php
                    $heads = ['Kode', 'Nama Obat', 'Satuan', 'Harga', 'Jenis Obat', 'Tipe Barang', 'Status', 'Action'];
                    $config['order'] = [1, 'asc'];
                    $config['paging'] = false;
                    $config['lengthMenu'] = false;
                    $config['searching'] = false;
                    $config['info'] = false;
                @endphp

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
                <div class="row">
                    <div class="col-md-5">
                        Tampil data {{ $obats->firstItem() }} sampai {{ $obats->lastItem() }} dari total
                        {{ $total_obat }}
                    </div>
                    <div class="col-md-7">
                        <div class="float-right pagination-sm">
                            {{ $obats->links() }}
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalObat" title="Obat" size="xl" icon="fas fa-pills" theme="success" static-backdrop>
        <form action="" id="formObat" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="nama" label="Nama Obat" placeholder="Nama Lengkap" fgroup-class="row"
                        label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support required />
                    <x-adminlte-input name="harga" fgroup-class="row" label-class="text-right col-3" igroup-size="sm"
                        igroup-class="col-9" type="number" label="Harga Satuan" placeholder="Harga Obat Satuan"
                        enable-old-support required />
                    <x-adminlte-select2 name="satuan" fgroup-class="row" label-class="text-right col-3" igroup-size="sm"
                        igroup-class="col-9" label="Satuan">
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
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="success" onclick="tambahSatuan()" icon="fas fa-plus" />
                        </x-slot>
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="jenisobat" fgroup-class="row" label-class="text-right col-3"
                        igroup-size="sm" igroup-class="col-9" label="Jenis Obat">
                        <option value="">Jenis Obat (Kosong)</option>
                        <option value="Obat Kemoterapi">Obat Kemoterapi</option>
                        <option value="Penunjang Kemoterapi">Penunjang Kemoterapi</option>
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="success" icon="fas fa-plus" />
                        </x-slot>
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="tipebarang" fgroup-class="row" label-class="text-right col-3"
                        igroup-size="sm" igroup-class="col-9" label="Tipe Barang">
                        <option value="">Tipe Barang (Kosong)</option>
                        <option value="Alkes">Alkes</option>
                        <option value="BHP">BHP</option>
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="success" icon="fas fa-plus" />
                        </x-slot>
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="distributor" fgroup-class="row" label-class="text-right col-3"
                        igroup-size="sm" igroup-class="col-9" label="Distributor">
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="success" icon="fas fa-plus" />
                        </x-slot>
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="merk" fgroup-class="row" label-class="text-right col-3"
                        igroup-size="sm" igroup-class="col-9" label="Tipe Barang">
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="success" icon="fas fa-plus" />
                        </x-slot>
                    </x-adminlte-select2>
                </div>
            </div>

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
                <x-adminlte-button form="formImport" class="mr-auto withLoad" type="submit" icon="fas fa-save"
                    theme="success" label="Import" />
                <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalSatuan" title="Tambah Satuan Obat" icon="fas fa-pills" theme="warning" static-backdrop>
        <form id="formSatuan">
            @csrf
            <x-adminlte-input id="nama_satuan" name="nama" label="Satuan Obat" placeholder="Nama Satuan"
                fgroup-class="row" label-class="col-3" igroup-size="sm" igroup-class="col-9" enable-old-support
                required />
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button icon="fas fa-save" theme="success" label="Simpan" onclick="simpanSatuan()" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Tutup" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>

@stop
@section('plugins.Datatables', true)
@section('plugins.BsCustomFileInput', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('css')
    <style>
        .select2-selection__choice {
            border: 0px !important;
        }
    </style>

@endsection
@section('js')
    <script>
        $(function() {
            $('#btnTambah').click(function() {

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
            $("#satuan").select2({
                placeholder: "Silahkan pilih",
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('satuanobat.show', 1) }}",
                    type: "GET",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            nama: params.term // search term
                        };
                    },
                    processResults: function(res) {
                        console.log(res.response);
                        return {
                            results: $.map(res.response, function(item) {
                                return {
                                    text: item.nama,
                                    id: item.nama
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
            $("#jenisobat").select2({
                placeholder: "Silahkan pilih",
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
            });
            $("#tipebarang").select2({
                placeholder: "Silahkan pilih",
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
            });
        });

        function tambahObat() {
            $.LoadingOverlay("show");
            $('#btnStore').show();
            $('#btnUpdate').hide();
            $('#formObat').trigger("reset");
            $('#modalObat').modal('show');
            $('#satuan').empty().change();
            $("#satuan").append('<option value="nama" selected>Pilih</option>');
            $("#satuan").val('nama').change();
            $.LoadingOverlay("hide");
        }

        function tambahSatuan() {
            $.LoadingOverlay("show");
            $('#modalSatuan').modal('show');
            $.LoadingOverlay("hide");
        }

        function simpanSatuan() {
            $.LoadingOverlay("show");
            var formData = $('#formSatuan').serialize();
            console.log(formData);
            $.ajax({
                url: "{{ route('satuanobat.store') }}",
                method: "POST",
                data: formData,
            }).done(function(data) {
                console.log(data);
                $('#modalSatuan').modal('hide');
                $.LoadingOverlay("hide");
            });
        }
    </script>
@endsection
