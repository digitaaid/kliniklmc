@extends('adminlte::page')
@section('title', 'Approval SEP')
@section('content_header')
    <h1 class="m-0 text-dark">Approval SEP</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="List Approval SEP" theme="secondary" icon="fas fa-user-check" collapsible>
                <div class="row">
                    <div class="col-md-4">
                        <form action="">
                            @php
                                $config = ['format' => 'YYYY-MM'];
                            @endphp
                            <x-adminlte-input-date fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="tanggal" placeholder="Silahkan Pilih Tanggal"
                                value="{{ $request->tanggal ?? now()->format('Y-m') }}" label="Bulan Periksa"
                                :config="$config">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" class="withLoad" theme="primary" icon="fas fa-search"
                                        label="Cari" />
                                </x-slot>
                            </x-adminlte-input-date>

                        </form>
                    </div>
                    <div class="col-md-4">
                        <x-adminlte-button theme="success" icon="fas fa-plus" class="btn-sm" label="Pengajuan Approval"
                            onclick="buatApproval()" />
                        <x-adminlte-button theme="success" icon="fas fa-check" class="btn-sm" label="Approval SEP"
                            onclick="approvalSEP()" />
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="buatApproval" title="Pengajuan Approval SEP" theme="success" icon="fas fa-file-medical">
        <form action="{{ route('pengajuan_approval_sep') }}" id="formPengajuanApproval" method="POST">
            @csrf
            <x-adminlte-input fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                name="noKartu" label="No BPJS" placeholder="No BPJS" required enable-old-support />
            @php
                $config = ['format' => 'YYYY-MM-DD'];
            @endphp
            <x-adminlte-input-date fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                name="tglSep" label="Tanggal SEP" :config="$config" required enable-old-support
                value="{{ now()->format('Y-m-d') }}" />
            <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                name="jnsPelayanan" label="Jenis Pelayanan" enable-old-support>
                <option value="2">Rawat Jalan</option>
                <option value="1">Rawat Inap</option>
            </x-adminlte-select>
            <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                name="jnsPengajuan" label="Jenis Pengajuan" enable-old-support>
                <option value="2">Pengajuan Fingerprint</option>
                <option value="1">Pengajuan Backdate</option>
            </x-adminlte-select>
            <x-adminlte-input fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                name="keterangan" required label="Keterangan" placeholder="Keterangan" required enable-old-support />
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Buat Pengajuan" form="formPengajuanApproval"
                type="submit" />
            <x-adminlte-button theme="danger" label="Tutup" icon="fas fa-times" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="approvalSEP" title="Approval SEP" theme="success" icon="fas fa-file-medical">
        <form action="{{ route('approval_sep') }}" id="formapprovalSEP" method="POST">
            @csrf
            <x-adminlte-input fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                name="noKartu" label="No BPJS" placeholder="No BPJS" required enable-old-support />
            @php
                $config = ['format' => 'YYYY-MM-DD'];
            @endphp
            <x-adminlte-input-date fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                igroup-size="sm" name="tglSep" label="Tanggal SEP" :config="$config" required enable-old-support
                value="{{ now()->format('Y-m-d') }}" />
            <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                name="jnsPelayanan" label="Jenis Pelayanan" enable-old-support>
                <option value="2">Rawat Jalan</option>
                <option value="1">Rawat Inap</option>
            </x-adminlte-select>
            <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                name="jnsPengajuan" label="Jenis Pengajuan" enable-old-support>
                <option value="2">Pengajuan Fingerprint</option>
                <option value="1">Pengajuan Backdate</option>
            </x-adminlte-select>
            <x-adminlte-input fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                name="keterangan" required label="Keterangan" placeholder="Keterangan" required enable-old-support />
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Approval SEP" form="formapprovalSEP"
                type="submit" />
            <x-adminlte-button theme="danger" label="Tutup" icon="fas fa-times" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Select2', true)
@section('plugins.Chartjs', true)
@section('js')
    <script>
        function buatApproval() {
            $('#buatApproval').modal('show');
        }

        function approvalSEP() {
            $('#approvalSEP').modal('show');
        }
    </script>

@endsection
