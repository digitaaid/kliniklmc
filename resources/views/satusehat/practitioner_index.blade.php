@extends('adminlte::page')

@section('title', 'Practitioner')

@section('content_header')
    <h1>Practitioner</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Data Dokter" theme="info" icon="fas fa-info-circle" collapsible maximizable>
                @php
                    $heads = ['Kode', 'Kode BPJS', 'ID SatuSehat', 'NIK', 'Nama Dokter', 'SIP', 'Action'];
                    $config['paging'] = false;
                    $config['info'] = false;
                    $config['scrollY'] = '500px';
                    $config['scrollCollapse'] = true;
                @endphp
                <x-adminlte-datatable id="table2" :heads="$heads" :config="$config" bordered hoverable compressed>
                    @foreach ($dokter as $item)
                        <tr>
                            <td>{{ $item->kodedokter }}</td>
                            <td>{{ $item->kodejkn }}</td>
                            <td>{{ $item->id_practitioner }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->namadokter }}</td>
                            <td>{{ $item->sip }}</td>
                            <td>
                                <x-adminlte-button class="btn-xs" onclick="editDokter(this)" theme="warning" icon="fas fa-edit"
                                    title="Edit Dokter {{ $item->nama_paramedis }}"
                                    data-kodeparamedis="{{ $item->paramedis ? $item->paramedis->kode_paramedis : '' }}"
                                    data-id="{{ $item->kodedokter }}" data-kodejkn="{{ $item->kodedokter }}"
                                    data-idsatusehat="{{ $item->id_satusehat }}"
                                    data-nik="{{ $item->paramedis ? $item->paramedis->nik : '' }}"
                                    data-namadokter="{{ $item->namadokter }}"
                                    data-sip="{{ $item->paramedis ? $item->paramedis->sip_dr : '' }}" />
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalEdit" title="Edit Dokter" theme="warning" icon="fas fa-user-plus">
        <form name="formInput" id="formInput" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="id" value="">
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="kodedokter" placeholder="Kode SIMRS" label="Kode SIMRS" readonly />
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="kodejkn" placeholder="Kode BPJS" label="Kode BPJS" readonly />
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="idsatusehat" placeholder="IdSatusehat" label="IdSatusehat" readonly>
                <x-slot name="appendSlot">
                    <div class="btn btn-primary btnCariKartu">
                        <i class="fas fa-sync"></i> Sync
                    </div>
                </x-slot>
            </x-adminlte-input>
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="nik" placeholder="NIK Dokter" label="NIK Dokter" />
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="namadokter" placeholder="Nama Dokter" label="Nama Dokter" />
            <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
                name="sip_dr" placeholder="SIP" label="SIP" />
            <x-slot name="footerSlot">
                <x-adminlte-button class="mr-auto" type="submit" form="formInput" label="Update" theme="success"
                    icon="fas fa-save" />
                <x-adminlte-button theme="danger " label="Tutup" icon="fas fa-times" data-dismiss="modal" />
            </x-slot>
        </form>
    </x-adminlte-modal>

@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('js')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        function editDokter(params) {
            $.LoadingOverlay("show");
            var id = $(params).data("id");
            var urlAction = "{{ route('dokter.index') }}/" + id;
            $('#formInput').attr('action', urlAction);
            $('#id').val($(params).data("id"));
            $('#kodedokter').val($(params).data("kodejkn"));
            $('#kode_paramedis').val($(params).data("kodeparamedis"));
            $('#id_satusehat').val($(params).data("idsatusehat"));
            $('#nik').val($(params).data("nik"));
            $('#namadokter').val($(params).data("namadokter"));
            $('#sip_dr').val($(params).data("sip"));
            $('#modalEdit').modal('show');
            $.LoadingOverlay("hide", true);
        }
    </script>
@endsection
