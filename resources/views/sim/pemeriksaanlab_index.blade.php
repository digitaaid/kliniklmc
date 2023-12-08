@extends('adminlte::page')

@section('title', 'Pemeriksaan Laboratorium')

@section('content_header')
    <h1>Pemeriksaan Laboratorium</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Data Pemeriksaan Laboratorium" theme="primary" icon="fas fa-info-circle" collapsible>
                @php
                    $heads = ['ID', 'Nama Pemeriksaan', 'Kode', 'Kelompok', 'Group', 'Harga', 'Status', 'Action'];
                    $config['order'] = [0, 'asc'];
                    $config['paging'] = false;
                    $config['scrollY'] = '500px';
                @endphp
                <x-adminlte-button id="btnTambah" class="btn-sm" theme="success" label="Tambah Pemeriksaan Laboratorium"
                    icon="fas fa-plus" />
                <a href="{{ route('obatexport') }}" class="btn btn-sm btn-primary"><i class="fas fa-print"></i> Export</a>
                {{-- <div class="btn btn-sm btn-primary btnModalImport"><i class="fas fa-file-medical"></i> Import</div> --}}
                <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($tarifs as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->kelompok }}</td>
                            <td>{{ $item->group }}</td>
                            <td>{{ money($item->tarif->harga ?? 0, 'IDR') }}</td>
                            <td>
                                @if ($item->status)
                                    <span class="badge badge-success">{{ $item->status }}. Aktif</span>
                                @else
                                    <span class="badge badge-danger">{{ $item->status }}. Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <x-adminlte-button class="btn-xs btnEdit" theme="warning" icon="fas fa-edit"
                                    title="Edit Pemeriksaan Laboratoirum {{ $item->nama }}" data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama }}" data-kode="{{ $item->kode }}"
                                    data-kelompok="{{ $item->kelompok }}" data-group="{{ $item->group }}"
                                    data-harga="{{ $item->harga }}" />
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
    <x-adminlte-modal id="modalLab" title="Pemeriksaan Laboratorium" icon="fas fa-pills" theme="success" static-backdrop>
        <form action="" id="formLab" method="POST">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="_method" id="method">
            <x-adminlte-input name="nama" label="Nama Pemeriksaan Laboratorium"
                placeholder="Nama Pemeriksaan Laboratorium" enable-old-support required />
            <x-adminlte-input name="kode" label="Kode" placeholder="Kode" enable-old-support required />
            <x-adminlte-select2 name="kelompok" label="Kelompok">
                <option value="HEMATOLOGI">HEMATOLOGI</option>
                <option value="KLINIK URINE">KLINIK URINE</option>
                <option value="KIMIA DARAH">KIMIA DARAH</option>
                <option value="IMUNOSEROLOGI & SEROLOGI">IMUNOSEROLOGI & SEROLOGI</option>
            </x-adminlte-select2>
            <x-adminlte-select2 name="group" label="Group">
                <option value="RUTIN">RUTIN</option>
                <option value="URINE">URINE</option>
                <option value="KARBOHIDRAT">KARBOHIDRAT</option>
                <option value="FAAL HATI">FAAL HATI</option>
                <option value="FAAL GINJAL">FAAL GINJAL</option>
                <option value="LEMAK">LEMAK</option>
                <option value="FAAL JANTUNG">FAAL JANTUNG</option>
                <option value="ELEKTROLIT DAN GAS DARAH">ELEKTROLIT DAN GAS DARAH</option>
                <option value="HEPATITIS">HEPATITIS</option>
                <option value="PENANDA TUMOR">PENANDA TUMOR</option>
                <option value="HORMON">HORMON</option>
                <option value="RHEUMATIK & PROTEIN SPESIFIK">RHEUMATIK & PROTEIN SPESIFIK</option>
            </x-adminlte-select2>
            <x-adminlte-input name="harga" type="number" label="Harga Tarif" placeholder="Harga Tarif" enable-old-support
                required />
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
                $('#kode').val($(this).data("kode"));
                $('#harga').val($(this).data("harga"));
                $('#kelompok').val($(this).data("kelompok")).change();
                $('#group').val($(this).data("group")).change();
                $('#modalLab').modal('show');
                $.LoadingOverlay("hide");
            });
            $('#btnStore').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var url = "{{ route('pemeriksaanlab.store') }}";
                $('#formLab').attr('action', url);
                $("#method").prop('', true);
                $('#formLab').submit();
            });
            $('#btnUpdate').click(function(e) {
                $.LoadingOverlay("show");
                e.preventDefault();
                var id = $('#id').val();
                var url = "{{ route('pemeriksaanlab.index') }}/" + id;
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
                        var url = "{{ route('pemeriksaanlab.index') }}/" + id;
                        $('#formDelete').attr('action', url);
                        $('#formDelete').submit();
                    }
                })
            });
        });
    </script>
@endsection
