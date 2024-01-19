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
                    $heads = ['Kode', 'Nama Obat', 'Kemasan', 'x', 'Hrg Beli', 'Satuan', 'Hrg Jual', 'Jenis', 'Tipe', 'Merk', 'Distributor', 'Status', 'Action'];
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
                            <td>{{ $item->kemasan }}</td>
                            <td>{{ $item->konversi_satuan }}</td>
                            <td>{{ money($item->harga_beli ?? 0, 'IDR') }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td>{{ money($item->harga_jual ?? 0, 'IDR') }}</td>
                            <td>{{ $item->jenisobat }}</td>
                            <td>{{ $item->tipeobat }}</td>
                            <td>{{ $item->merk }}</td>
                            <td>{{ $item->distributor }}</td>
                            <td>
                                @if ($item->status)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Non-Aktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('stokobat.show', $item->id) }}" class="btn btn-xs btn-primary"><i
                                        class="fas fa-box"></i> Stok</a>
                                <x-adminlte-button class="btn-xs" onclick="editObat(this)" theme="warning"
                                    icon="fas fa-edit" title="Edit Obat {{ $item->nama }}" data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama }}" data-distributor="{{ $item->distributor }}"
                                    data-jenisobat="{{ $item->jenisobat }}" data-satuan="{{ $item->satuan }}"
                                    data-barcode="{{ $item->barcode }}" data-bpom="{{ $item->bpom }}"
                                    data-harga="{{ $item->harga }}" data-tipeobat="{{ $item->tipeobat }}"
                                    data-merk="{{ $item->merk }}" data-kemasan="{{ $item->kemasan }}"
                                    data-konversisatuan="{{ $item->konversi_satuan }}" />
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
                    <x-adminlte-input name="nama" label="Nama Obat" placeholder="Nama Obat" fgroup-class="row"
                        label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support required />
                    <x-adminlte-input name="bpom" label="Kode BPOM" placeholder="Kode BPOM" fgroup-class="row"
                        label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support required />
                    <x-adminlte-input name="barcode" label="Kode Barcode" placeholder="Kode Barcode" fgroup-class="row"
                        label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support
                        required />
                    <x-adminlte-select2 name="jenisobat" fgroup-class="row" label-class="text-right col-3"
                        igroup-size="sm" igroup-class="col-9" label="Jenis Obat">
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="success" onclick="tambahJenis()" icon="fas fa-plus" />
                        </x-slot>
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="tipeobat" fgroup-class="row" label-class="text-right col-3"
                        igroup-size="sm" igroup-class="col-9" label="Tipe Barang">
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="success" onclick="tambahTipe()" icon="fas fa-plus" />
                        </x-slot>
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="distributor" fgroup-class="row" label-class="text-right col-3"
                        igroup-size="sm" igroup-class="col-9" label="Distributor">
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="success" onclick="tambahDistributor()" icon="fas fa-plus" />
                        </x-slot>
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="merk" fgroup-class="row" label-class="text-right col-3"
                        igroup-size="sm" igroup-class="col-9" label="Merk Barang">
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="success" onclick="tambahMerk()" icon="fas fa-plus" />
                        </x-slot>
                    </x-adminlte-select2>
                </div>
                <div class="col-md-6">
                    <x-adminlte-select2 name="kemasan" fgroup-class="row" label-class="text-right col-3"
                        igroup-size="sm" igroup-class="col-9" label="Kemasan">
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="success" onclick="tambahSatuan()" icon="fas fa-plus" />
                        </x-slot>
                    </x-adminlte-select2>
                    <x-adminlte-input name="konversi_satuan" type="number" label="Konversi Satuan"
                        placeholder="Konversi Satuan" fgroup-class="row" label-class="text-right col-3" igroup-size="sm"
                        igroup-class="col-9" enable-old-support required />
                    <x-adminlte-select2 name="satuan" fgroup-class="row" label-class="text-right col-3"
                        igroup-size="sm" igroup-class="col-9" label="Satuan Terkecil">
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="success" onclick="tambahSatuan()" icon="fas fa-plus" />
                        </x-slot>
                    </x-adminlte-select2>
                    <x-adminlte-input name="harga_beli" label="Hrg Beli Kemasan" placeholder="Harga Beli"
                        fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                        enable-old-support required />
                    <x-adminlte-input name="harga_jual" type="number" label="Hrg Jual Satuan"
                        placeholder="Harga Jual Satuan" fgroup-class="row" label-class="text-right col-3"
                        igroup-size="sm" igroup-class="col-9" enable-old-support readonly />
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
            <x-adminlte-input id="nama_satuan" name="nama" label="Satuan Obat" placeholder="Satuan Satuan"
                fgroup-class="row" label-class="col-3" igroup-size="sm" igroup-class="col-9" enable-old-support
                required />
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button icon="fas fa-save" theme="success" label="Simpan" onclick="simpanSatuan()" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Tutup" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalJenis" title="Tambah Jenis Obat" icon="fas fa-pills" theme="warning" static-backdrop>
        <form id="formJenis">
            @csrf
            <x-adminlte-input id="nama_jenis" name="nama" label="Jenis Obat" placeholder="Jenis Satuan"
                fgroup-class="row" label-class="col-3" igroup-size="sm" igroup-class="col-9" enable-old-support
                required />
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button icon="fas fa-save" theme="success" label="Simpan" onclick="simpanJenis()" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Tutup" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalTipe" title="Tambah Tipe Barang" icon="fas fa-pills" theme="warning" static-backdrop>
        <form id="formTipe">
            @csrf
            <x-adminlte-input name="nama" label="Tipe Barang" placeholder="Tipe Barang" fgroup-class="row"
                label-class="col-3" igroup-size="sm" igroup-class="col-9" enable-old-support required />
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button icon="fas fa-save" theme="success" label="Simpan" onclick="simpanTipe()" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Tutup" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalMerk" title="Tambah Merk Barang" icon="fas fa-pills" theme="warning" static-backdrop>
        <form id="formMerk">
            @csrf
            <x-adminlte-input name="nama" label="Merk Barang" placeholder="Merk Barang" fgroup-class="row"
                label-class="col-3" igroup-size="sm" igroup-class="col-9" enable-old-support required />
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button icon="fas fa-save" theme="success" label="Simpan" onclick="simpanMerk()" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Tutup" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalDistributor" title="Tambah Distributor Barang" icon="fas fa-pills" theme="warning"
        static-backdrop>
        <form id="formDistributor">
            @csrf
            <x-adminlte-input name="nama" label="Distributor Barang" placeholder="Distributor Barang"
                fgroup-class="row" label-class="col-3" igroup-size="sm" igroup-class="col-9" enable-old-support
                required />
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button icon="fas fa-save" theme="success" label="Simpan" onclick="simpanDistributor()" />
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(function() {
            // $('#harga_beli').on('input', function() {
            //     // Menghapus karakter selain digit
            //     let inputValue = $(this).val().replace(/\D/g, '');
            //     // Memformat dengan menambahkan titik setiap seribu
            //     let formattedValue = addThousandSeparator(inputValue);
            //     // Memasukkan nilai yang sudah diformat kembali ke input
            //     $(this).val(formattedValue);
            // });
            $('#harga_beli').mask('000.000.000.000', {
                reverse: true
            });

            // function addThousandSeparator(value) {
            //     return value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            // }
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
            $("#kemasan").select2({
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
                ajax: {
                    url: "{{ route('jenisobat.show', 1) }}",
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
            $("#tipeobat").select2({
                placeholder: "Silahkan pilih",
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('tipebarang.show', 1) }}",
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
            $("#distributor").select2({
                placeholder: "Silahkan pilih",
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('distributorbarang.show', 1) }}",
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
            $("#merk").select2({
                placeholder: "Silahkan pilih",
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('merkbarang.show', 1) }}",
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
        });

        function tambahObat() {
            $.LoadingOverlay("show");
            $('#btnStore').show();
            $('#btnUpdate').hide();
            $('#formObat').trigger("reset");
            $('#satuan').empty().change();
            $('#kemasan').empty().change();
            $('#jenisobat').empty().change();
            $('#tipeobat').empty().change();
            $('#merk').empty().change();
            $('#distributor').empty().change();
            $('#modalObat').modal('show');
            $.LoadingOverlay("hide");
        }

        function editObat(button) {
            $.LoadingOverlay("show");
            $('#btnStore').hide();
            $('#btnUpdate').show();
            $('#formObat').trigger("reset");
            // get
            $('#id').val($(button).data("id"));
            $('#nama').val($(button).data("nama"));
            $('#harga').val($(button).data("harga"));
            $('#barcode').val($(button).data("barcode"));
            $('#bpom').val($(button).data("bpom"));
            $('#konversi_satuan').val($(button).data("konversisatuan"));
            // select2
            $('#satuan').empty().change();
            if ($(button).data("satuan")) {
                $("#satuan").append('<option value="' + $(button).data("satuan") +
                    '" selected>' + $(button).data("satuan") + '</option>');
                $("#satuan").val($(button).data("satuan")).change();
            }
            $('#kemasan').empty().change();
            if ($(button).data("kemasan")) {
                $("#kemasan").append('<option value="' + $(button).data("kemasan") +
                    '" selected>' + $(button).data("kemasan") + '</option>');
                $("#kemasan").val($(button).data("kemasan")).change();
            }
            $('#jenisobat').empty().change();
            if ($(button).data("jenisobat")) {
                $("#jenisobat").append('<option value="' + $(button).data("jenisobat") +
                    '" selected>' + $(button).data("jenisobat") + '</option>');
                $("#jenisobat").val($(button).data("jenisobat")).change();
            }
            $('#tipeobat').empty().change();
            if ($(button).data("tipeobat")) {
                $("#tipeobat").append('<option value="' + $(button).data("tipeobat") +
                    '" selected>' + $(button).data("tipeobat") + '</option>');
                $("#tipeobat").val($(button).data("tipeobat")).change();
            }
            $('#merk').empty().change();
            if ($(button).data("merk")) {
                $("#merk").append('<option value="' + $(button).data("merk") +
                    '" selected>' + $(button).data("merk") + '</option>');
                $("#merk").val($(button).data("merk")).change();
            }
            $('#distributor').empty().change();
            if ($(button).data("distributor")) {
                $("#distributor").append('<option value="' + $(button).data("distributor") +
                    '" selected>' + $(button).data("distributor") + '</option>');
                $("#distributor").val($(button).data("distributor")).change();
            }







            $('#tipebarang').val($(button).data("tipebarang")).change();
            $('#modalObat').modal('show');
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

        function tambahJenis() {
            $.LoadingOverlay("show");
            $('#modalJenis').modal('show');
            $.LoadingOverlay("hide");
        }

        function simpanJenis() {
            $.LoadingOverlay("show");
            var formData = $('#formJenis').serialize();
            console.log(formData);
            $.ajax({
                url: "{{ route('jenisobat.store') }}",
                method: "POST",
                data: formData,
                error: function(data) {
                    console.log(data);
                    $.LoadingOverlay("hide");
                },
            }).done(function(data) {
                console.log(data);
                $('#modalJenis').modal('hide');
                $.LoadingOverlay("hide");
            });
        }

        function tambahTipe() {
            $.LoadingOverlay("show");
            $('#modalTipe').modal('show');
            $.LoadingOverlay("hide");
        }

        function simpanTipe() {
            $.LoadingOverlay("show");
            var formData = $('#formTipe').serialize();
            console.log(formData);
            $.ajax({
                url: "{{ route('tipebarang.store') }}",
                method: "POST",
                data: formData,
                error: function(data) {
                    console.log(data);
                    $.LoadingOverlay("hide");
                },
            }).done(function(data) {
                console.log(data);
                $('#modalTipe').modal('hide');
                $.LoadingOverlay("hide");
            });
        }

        function tambahMerk() {
            $.LoadingOverlay("show");
            $('#modalMerk').modal('show');
            $.LoadingOverlay("hide");
        }

        function simpanMerk() {
            $.LoadingOverlay("show");
            var formData = $('#formMerk').serialize();
            console.log(formData);
            $.ajax({
                url: "{{ route('merkbarang.store') }}",
                method: "POST",
                data: formData,
                error: function(data) {
                    console.log(data);
                    $.LoadingOverlay("hide");
                },
            }).done(function(data) {
                console.log(data);
                $('#modalMerk').modal('hide');
                $.LoadingOverlay("hide");
            });
        }

        function tambahDistributor() {
            $.LoadingOverlay("show");
            $('#modalDistributor').modal('show');
            $.LoadingOverlay("hide");
        }

        function simpanDistributor() {
            $.LoadingOverlay("show");
            var formData = $('#formDistributor').serialize();
            console.log(formData);
            $.ajax({
                url: "{{ route('distributorbarang.store') }}",
                method: "POST",
                data: formData,
                error: function(data) {
                    console.log(data);
                    $.LoadingOverlay("hide");
                },
            }).done(function(data) {
                console.log(data);
                $('#modalDistributor').modal('hide');
                $.LoadingOverlay("hide");
            });
        }
    </script>
@endsection
