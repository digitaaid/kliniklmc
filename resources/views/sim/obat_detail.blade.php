@extends('adminlte::page')

@section('title', $obat->nama)

@section('content_header')
    <h1>{{ $obat->nama }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <x-adminlte-small-box
                title="{{ $obat->stoks->sum('jumlah') - $obat->reseps->sum('jumlah') }} / {{ explode('.', ($obat->stoks->sum('jumlah') - $obat->reseps->sum('jumlah')) / $obat->konversi_satuan)[0] }}"
                text="Real Stok Satuan / Kemasan" theme="success" icon="fas fa-pills" />
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
                <form action="" id="formObat" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="_method" id="method">
                    <div class="row">
                        <div class="col-md-6">
                            <x-adminlte-input name="nama" label="Nama Obat" placeholder="Nama Obat" fgroup-class="row"
                                label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support
                                required />
                            <x-adminlte-input name="bpom" label="Kode BPOM" placeholder="Kode BPOM" fgroup-class="row"
                                label-class="text-right col-3" igroup-size="sm" igroup-class="col-9" enable-old-support
                                required />
                            <x-adminlte-input name="barcode" label="Kode Barcode" placeholder="Kode Barcode"
                                fgroup-class="row" label-class="text-right col-3" igroup-size="sm" igroup-class="col-9"
                                enable-old-support required />
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
                                placeholder="Konversi Satuan" fgroup-class="row" label-class="text-right col-3"
                                igroup-size="sm" igroup-class="col-9" enable-old-support required />
                            <x-adminlte-select2 name="satuan" fgroup-class="row" label-class="text-right col-3"
                                igroup-size="sm" igroup-class="col-9" label="Satuan Terkecil">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button theme="success" onclick="tambahSatuan()" icon="fas fa-plus" />
                                </x-slot>
                            </x-adminlte-select2>
                            <x-adminlte-input name="harga_beli_kemasan" type="number" label="Hrg Beli Kemasan"
                                placeholder="Harga Beli" fgroup-class="row" label-class="text-right col-3"
                                igroup-size="sm" igroup-class="col-9" enable-old-support required />
                            <x-adminlte-input name="harga_beli_satuan" type="number" label="Hrg Beli Satuan"
                                placeholder="Harga Beli" fgroup-class="row" label-class="text-right col-3"
                                igroup-size="sm" igroup-class="col-9" enable-old-support required />
                        </div>
                    </div>
                </form>
                <x-slot name="footerSlot">
                    <x-adminlte-button class="btn-xs btnIcare" theme="warning" label="I-Care JKN"
                        icon="fas fa-info-circle" />
                    <x-adminlte-button class="btn-xs" onclick="inputStokObat()" theme="primary" label="Input Stok Obat"
                        icon="fas fa-box" />
                </x-slot>
            </x-adminlte-card>
            <x-adminlte-card theme="primary" title="Riwayat Resep Obat">
                @php
                    $heads = ['Tanggal', 'Kode Resep', 'Nama Obat', 'Jumlah'];
                    $config['order'] = [1, 'asc'];
                @endphp
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($obat->reseps as $resep)
                        <tr>
                            <td>{{ $resep->created_at }}</td>
                            <td>{{ $resep->koderesep }}</td>
                            <td>{{ $obat->nama }}</td>
                            <td>{{ $resep->jumlah }}</td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
            <x-adminlte-card theme="primary" title="Riwayat Input Stok Obat">
                @php
                    $heads = ['Tanggal', 'Kode Resep', 'Nama Obat', 'Jumlah', 'Tgl Expire'];
                    $config['order'] = [1, 'asc'];
                @endphp
                <x-adminlte-datatable id="table2" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($obat->stoks as $stok)
                        <tr>
                            <td>{{ $stok->tgl_input }}</td>
                            <td>{{ $stok->kode }}</td>
                            <td>{{ $stok->nama }}</td>
                            <td>{{ $stok->jumlah }}</td>
                            <td>{{ $stok->tgl_expire }}</td>
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
@stop
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.BsCustomFileInput', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)

@section('js')
    <script>
        function inputStokObat() {
            $.LoadingOverlay("show");
            $('#modalInputStok').modal('show');
            $.LoadingOverlay("hide");
        }
    </script>

@endsection
