@extends('adminlte::page')

@section('title', 'Laporan Layanan & Tindakan')

@section('content_header')
    <h1>Laporan Layanan & Tindakan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Data Layanan & Tindakan" theme="primary" icon="fas fa-info-circle" collapsible>
                @php
                    $heads = ['ID', 'Tanggal', 'Nama', 'Klasifikasi', 'Jaminan', 'Harga', 'Diskon', 'Subtotal', 'Status'];
                    $config['order'] = [0, 'desc'];
                    $config['paging'] = false;
                    $config['lengthMenu'] = false;
                    $config['info'] = false;
                @endphp
                <x-adminlte-button id="btnTambah" class="btn-sm" theme="success" label="Tambah Tarif" icon="fas fa-plus" />
                <a href="{{ route('obatexport') }}" class="btn btn-sm btn-primary"><i class="fas fa-print"></i> Export</a>
                {{-- <div class="btn btn-sm btn-primary btnModalImport"><i class="fas fa-file-medical"></i> Import</div> --}}
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($laydet as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->klasifikasi }}</td>
                            <td>{{ $item->jaminans->nama }}</td>
                            <td>{{ $item->harga }} @ {{ $item->jumlah }}</td>
                            <td>{{ $item->diskon }}%</td>
                            <td>{{ $item->subtotal }}</td>
                            <td>{{ $item->status }}</td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
                <div class="row">
                    <div class="col-md-5">
                        Tampil data {{ $laydet->firstItem() }} sampai {{ $laydet->lastItem() }} dari total
                        {{ $laydet_total }}
                    </div>
                    <div class="col-md-7">
                        <div class="float-right pagination-sm">
                            {{ $laydet->links() }}
                        </div>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalTarif" title="Tarif Layanan" icon="fas fa-pills" theme="success" static-backdrop>
        <form action="" id="formTarif" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <x-adminlte-input name="nama" label="Nama Tarif" placeholder="Nama Tarif" enable-old-support required />
            <x-adminlte-select2 name="klasifikasi" label="Klasifikasi">
                <option value="Prosedur Non Bedah">Prosedur Non Bedah</option>
                <option value="Prosedur Bedah">Prosedur Bedah</option>
                <option value="Konsultasi">Konsultasi</option>
                <option value="Tenaga Ahli">Tenaga Ahli</option>
                <option value="Keperawatan">Keperawatan</option>
                <option value="Penunjang">Penunjang</option>
                <option value="Radiologi">Radiologi</option>
                <option value="Laboratorium">Laboratorium</option>
                <option value="Pelayanan Darah">Pelayanan Darah</option>
                <option value="Rehabilitasi">Rehabilitasi</option>
                <option value="Akomodasi">Akomodasi</option>
                <option value="Rawat Intensif">Rawat Intensif</option>
                <option value="Obat">Obat</option>
                <option value="Obat Kronis">Obat Kronis</option>
                <option value="Obat Kemoterapi">Obat Kemoterapi</option>
                <option value="Alkes">Alkes</option>
                <option value="BMHP">BMHP</option>
                <option value="Sewa Alat">Sewa Alat</option>
            </x-adminlte-select2>
            <x-adminlte-input name="harga" type="number" label="Harga Tarif" placeholder="Harga Tarif" enable-old-support
                required />
            <x-adminlte-select2 name="jenispasien" label="Jenis Pasien">
                <option value="SEMUA">SEMUA</option>
                <option value="JKN">JKN</option>
                <option value="NON-JKN">NON-JKN</option>
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
@section('js')
    <script>
        $(function() {
            $('#btnTambah').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').show();
                $('#btnUpdate').hide();
                $('#formTarif').trigger("reset");
                $('#modalTarif').modal('show');
                $.LoadingOverlay("hide");
            });
            $('.btnEdit').click(function() {
                $.LoadingOverlay("show");
                $('#btnStore').hide();
                $('#btnUpdate').show();
                $('#formTarif').trigger("reset");
                // get
                $('#id').val($(this).data("id"));
                $('#nama').val($(this).data("nama"));
                $('#harga').val($(this).data("harga"));
                $('#klasifikasi').val($(this).data("klasifikasi")).change();
                $('#jenispasien').val($(this).data("jenispasien")).change();
                $('#modalTarif').modal('show');
                $.LoadingOverlay("hide");
            });
            $('#btnStore').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('tarif.store') }}";
                $('#formTarif').attr('action', url);
                $("#method").prop('', true);
                $('#formTarif').submit();
            });
            $('#btnUpdate').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var id = $('#id').val();
                var url = "{{ route('tarif.index') }}/" + id;
                $('#formTarif').attr('action', url);
                $('#method').val('PUT');
                $('#formTarif').submit();
            });
            // $('.btnModalImport').click(function() {
            //     $.LoadingOverlay("show");
            //     $('#modalImport').modal('show');
            //     $.LoadingOverlay("hide");
            // });
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
            //             var url = "{{ route('tarif.index') }}/" + id;
            //             $('#formDelete').attr('action', url);
            //             $('#formDelete').submit();
            //         }
            //     })
            // });
        });
    </script>
@endsection
