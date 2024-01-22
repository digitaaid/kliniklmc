@extends('adminlte::page')

@section('title', $obat->nama)

@section('content_header')
    <h1>{{ $obat->nama }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $obat->real_stok }}" text="Real Stok Satuan / Kemasan" theme="success"
                icon="fas fa-pills" />
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $obat->stoks->sum('jumlah') }}" text="Input Stok Obat" theme="primary"
                icon="fas fa-pills" />
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $obat->reseps->sum('jumlah') }}" text="Penggunaan Resep Obat" theme="warning"
                icon="fas fa-pills" />
        </div>
        <div class="col-md-12">
            <x-adminlte-card theme="primary" title="Informasi Obat">
                <form action="{{ route('obat.update', $obat->id) }}" id="formObat" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id" value="{{ $obat->id }}">
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <x-adminlte-input name="nama" label="Nama Obat" placeholder="Nama Obat" fgroup-class="row"
                                label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support
                                required value="{{ $obat->nama }}" />
                            <x-adminlte-input name="bpom" label="Kode BPOM" placeholder="Kode BPOM" fgroup-class="row"
                                label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support
                                value="{{ $obat->bpom }}" />
                            <x-adminlte-input name="barcode" label="Kode Barcode" placeholder="Kode Barcode"
                                fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                                enable-old-support value="{{ $obat->barcode }}" />
                            <x-adminlte-input name="stok_minimum" label="Stok Minimum" placeholder="Stok Minimum"
                                fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                                enable-old-support value="{{ $obat->stok_minimum }}" />
                            <x-adminlte-select2 name="jenisobat" fgroup-class="row" label-class="text-right col-3"
                                igroup-size="sm" igroup-class="col-9" label="Jenis Obat">
                                @if ($obat->jenisobat)
                                    <option value="{{ $obat->jenisobat }}" selected>{{ $obat->jenisobat }}</option>
                                @endif
                                <x-slot name="appendSlot">
                                    <x-adminlte-button theme="success" onclick="tambahJenis()" icon="fas fa-plus" />
                                </x-slot>
                            </x-adminlte-select2>
                            <x-adminlte-select2 name="tipeobat" fgroup-class="row" label-class="text-right col-3"
                                igroup-size="sm" igroup-class="col-9" label="Tipe Obat">
                                @if ($obat->tipeobat)
                                    <option value="{{ $obat->tipeobat }}" selected>{{ $obat->tipeobat }}</option>
                                @endif
                                <x-slot name="appendSlot">
                                    <x-adminlte-button theme="success" onclick="tambahTipe()" icon="fas fa-plus" />
                                </x-slot>
                            </x-adminlte-select2>
                            <x-adminlte-select2 name="distributor" fgroup-class="row" label-class="text-right col-3"
                                igroup-size="sm" igroup-class="col-9" label="Distributor">
                                @if ($obat->distributor)
                                    <option value="{{ $obat->distributor }}" selected>{{ $obat->distributor }}</option>
                                @endif
                                <x-slot name="appendSlot">
                                    <x-adminlte-button theme="success" onclick="tambahDistributor()" icon="fas fa-plus" />
                                </x-slot>
                            </x-adminlte-select2>
                            <x-adminlte-select2 name="merk" fgroup-class="row" label-class="text-right col-3"
                                igroup-size="sm" igroup-class="col-9" label="Merk Barang">
                                @if ($obat->merk)
                                    <option value="{{ $obat->merk }}" selected>{{ $obat->merk }}</option>
                                @endif
                                <x-slot name="appendSlot">
                                    <x-adminlte-button theme="success" onclick="tambahMerk()" icon="fas fa-plus" />
                                </x-slot>
                            </x-adminlte-select2>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-select2 name="kemasan" fgroup-class="row" label-class="text-right col-3"
                                igroup-size="sm" igroup-class="col-9" label="Kemasan">
                                @if ($obat->kemasan)
                                    <option value="{{ $obat->kemasan }}" selected>{{ $obat->kemasan }}</option>
                                @endif
                                <x-slot name="appendSlot">
                                    <x-adminlte-button theme="success" onclick="tambahSatuan()" icon="fas fa-plus" />
                                </x-slot>
                            </x-adminlte-select2>
                            <x-adminlte-input name="harga_beli" label="Harga Beli Kemasan" placeholder="Harga Beli"
                                fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                                enable-old-support required value="{{ $obat->harga_beli }}" />
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-9">
                                    @if ($obat->harga_beli && $obat->konversi_satuan)
                                        <b>Hrg Beli PPN(11%) : </b>
                                        {{ money($obat->harga_beli + ($obat->harga_beli * 11) / 100, 'IDR') }} <br>
                                        <b>Hrg Beli Satuan : </b>
                                        {{ money(($obat->harga_beli + ($obat->harga_beli * 11) / 100) / $obat->konversi_satuan, 'IDR') }}
                                        <br>
                                        <b>Hrg Jual Margin 30% : </b>
                                        {{ money(($obat->harga_beli + ($obat->harga_beli * 11) / 100) / $obat->konversi_satuan + (($obat->harga_beli + ($obat->harga_beli * 11) / 100) / $obat->konversi_satuan) * 0.3, 'IDR') }}
                                        <br>
                                        <b>Hrg Jual PPN(11%) : </b>
                                        {{ money(($obat->harga_beli + ($obat->harga_beli * 11) / 100) / $obat->konversi_satuan + (($obat->harga_beli + ($obat->harga_beli * 11) / 100) / $obat->konversi_satuan) * 0.3 + (($obat->harga_beli + ($obat->harga_beli * 11) / 100) / $obat->konversi_satuan + (($obat->harga_beli + ($obat->harga_beli * 11) / 100) / $obat->konversi_satuan) * 0.3) * 0.11, 'IDR') }}
                                    @endif
                                </div>
                            </div>
                            <br>
                            <x-adminlte-input name="diskon_beli" type="number" max="100" min="0"
                                label="Diskon Pembelian" placeholder="Diskon Pembelian" fgroup-class="row"
                                label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support
                                required value="{{ $obat->diskon_beli }}" />
                            <x-adminlte-input name="konversi_satuan" type="number" label="Konversi Satuan"
                                placeholder="Konversi Satuan" fgroup-class="row" label-class="text-right col-3"
                                igroup-size="sm" igroup-class="col-9" enable-old-support required
                                value="{{ $obat->konversi_satuan }}" />
                            <x-adminlte-select2 name="satuan" fgroup-class="row" label-class="text-right col-3"
                                igroup-size="sm" igroup-class="col-9" label="Satuan Terkecil">
                                @if ($obat->satuan)
                                    <option value="{{ $obat->satuan }}" selected>{{ $obat->satuan }}</option>
                                @endif
                                <x-slot name="appendSlot">
                                    <x-adminlte-button theme="success" onclick="tambahSatuan()" icon="fas fa-plus" />
                                </x-slot>
                            </x-adminlte-select2>
                            <x-adminlte-input name="harga_jual" label="Harga Jual Satuan" placeholder="Harga Jual Satuan"
                                fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                                enable-old-support required readonly value="{{ $obat->harga_jual }}" />
                        </div>
                    </div>
                </form>
                <x-slot name="footerSlot">
                    {{-- <x-adminlte-button class="btn-xs btnIcare" theme="warning" label="I-Care JKN"
                        icon="fas fa-info-circle" /> --}}
                    <x-adminlte-button form="formObat" class="btn-sm" type="submit" icon="fas fa-edit" theme="warning"
                        label="Update" />
                    <x-adminlte-button class="btn-sm" onclick="inputStokObat()" theme="primary" label="Input Stok Obat"
                        icon="fas fa-box" />
                </x-slot>
            </x-adminlte-card>
            <x-adminlte-card theme="primary" title="Kartu Stok">
                @php
                    $heads = ['Tanggal', 'Kode Resep', 'Pasien', 'Nama Obat','Exp. Date', 'In', 'Out', 'PIC'];
                    $config['order'] = [0, 'desc'];
                @endphp
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($obat->reseps as $resep)
                        <tr>
                            <td>{{ Carbon\Carbon::parse($resep->created_at)->format('Y-m-d') }}</td>
                            <td>{{ $resep->koderesep }}</td>
                            <td>
                                {{ $resep->resepobat ? $resep->resepobat->nama : '-' }}
                            </td>
                            <td>{{ $obat->nama }}</td>
                            <td></td>
                            <td></td>
                            <td>{{ $resep->jumlah }}</td>
                            <td>-</td>
                        </tr>
                    @endforeach
                    @foreach ($obat->stoks as $stok)
                        <tr>
                            <td>{{ Carbon\Carbon::parse($stok->tgl_input)->format('Y-m-d') }}</td>
                            <td>{{ $stok->kode }}</td>
                            <td>FARMASI</td>
                            <td>{{ $stok->nama }}</td>
                            <td>{{ $stok->tgl_expire }}</td>
                            <td>{{ $stok->jumlah }}</td>
                            <td></td>
                            <td>-</td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
            <x-adminlte-card theme="primary" title="Riwayat Input Stok Obat">
                @php
                    $heads = ['Tanggal', 'Kode Resep', 'Tgl Expire', 'Nama Obat', 'Hrg/Kmsan', 'Diskon', 'Jumlah', 'Hrg Total'];
                    $config['order'] = [1, 'asc'];
                @endphp
                <x-adminlte-datatable id="table2" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($obat->stoks as $stok)
                        <tr>
                            <td>{{ $stok->tgl_input }}</td>
                            <td>{{ $stok->kode }}</td>
                            <td>{{ $stok->tgl_expire }}</td>
                            <td>{{ $stok->nama }}</td>
                            <td>{{ money($stok->harga_beli, 'IDR') }}</td>
                            <td>{{ $stok->diskon_beli }} %</td>
                            <td>{{ $stok->jumlah }}</td>
                            <td>{{ money($stok->harga_total, 'IDR') }}</td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalInputStok" title="Input Stok Obat" size="xl" icon="fas fa-pills" theme="success"
        static-backdrop>
        <form action="{{ route('stokobat.store') }}" id="formStok" name="formStok" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="obat_id" value="{{ $obat->id }}">
            <x-adminlte-input name="nama" label="Nama Obat" value="{{ $obat->nama }}" placeholder="Nama Obat"
                fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                enable-old-support required />
            <x-adminlte-input name="harga_beli" class="uang" label="Harga Beli Kemasan" placeholder="Harga Beli"
                fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                enable-old-support required value="{{ $obat->harga_beli }}" />
            <x-adminlte-input name="diskon_beli" type="number" max="100" min="0" label="Diskon Pembelian"
                placeholder="Diskon Pembelian" fgroup-class="row" label-class="text-right col-3" igroup-size="sm"
                igroup-class="col-9" enable-old-support required value="{{ $obat->diskon_beli }}" />
            <x-adminlte-input name="jumlah_kemasan" label="Jumlah Kemasan" placeholder="Jumlah Kemasan"
                fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                enable-old-support />
            <x-adminlte-input name="jumlah" label="Jumlah Satuan" placeholder="Jumlah Satuan" fgroup-class="row"
                label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support />
            @php
                $config = ['format' => 'YYYY-MM-DD'];
            @endphp
            <x-adminlte-input-date name="tgl_input" label="Tgl Input" fgroup-class="row" label-class="text-right col-3"
                igroup-size="sm" igroup-class="col-9" value="{{ now()->format('Y-m-d') }}" placeholder="Pilih Tanggal"
                :config="$config">
            </x-adminlte-input-date>
            <x-adminlte-input-date name="tgl_expire" label="Tgl Expire" fgroup-class="row"
                label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                value="{{ now()->format('Y-m-d') }}" placeholder="Pilih Tanggal" :config="$config">
            </x-adminlte-input-date>
            <x-slot name="footerSlot">
                <x-adminlte-button form="formStok" class="mr-auto" type="submit" icon="fas fa-save" theme="success"
                    label="Import" />
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
            <x-adminlte-input id="nama_jenis" name="nama" label="Jenis Obat" placeholder="Jenis Obat"
                fgroup-class="row" label-class="col-3" igroup-size="sm" igroup-class="col-9" enable-old-support
                required />
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button icon="fas fa-save" theme="success" label="Simpan" onclick="simpanJenis()" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Tutup" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalTipe" title="Tambah Tipe Obat" icon="fas fa-pills" theme="warning" static-backdrop>
        <form id="formTipe">
            @csrf
            <x-adminlte-input name="nama" label="Tipe Obat" placeholder="Tipe Obat" fgroup-class="row"
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
@section('plugins.TempusDominusBs4', true)
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
            $('#harga_beli').mask('000.000.000.000', {
                reverse: true
            });
            $('#harga_jual').mask('000.000.000.000', {
                reverse: true
            });
            $('.uang').mask('000.000.000.000', {
                reverse: true
            });
        });
    </script>
    <script>
        function inputStokObat() {
            $.LoadingOverlay("show");
            $('#modalInputStok').modal('show');
            $.LoadingOverlay("hide");
        }
    </script>

    <script>
        $(function() {
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
