<div class="card card-info mb-1">
    <a data-toggle="collapse" class="card-header" data-parent="#accordion" href="#collapseOne">
        <h3 class="card-title">
            Riwayat CPPT Pasien
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool bg-success">
                <i class="fas fa-file-medical-alt"></i>
                {{ $antrian->pasien ? $antrian->pasien->kunjungans->count() : 0 }} Kunjungan
            </button>
        </div>
    </a>
    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
        <div class="card-body p-1 mb-3">
            <style>
                pre {
                    padding: 0 !important;
                    margin-bottom: 0 !important;
                    font-size: 11px !important;
                    border: none;
                    outline: none;
                }
            </style>
            @include('form.cppt')
        </div>
    </div>
</div>
<x-adminlte-modal id="modalCPPT" title="CPPT" size="xl" icon="fas fa-file-medical" theme="success">
    @include('form.cppt')
    <x-slot name="footerSlot">
        <a href="{{ route('print_cppt') }}?pasien={{ $antrian->norm }}" class="btn btn-warning ml-auto" target="_blank">
            <i class="fas fa-print"></i> Print</a>
        <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
@push('js')
    <script>
        function modalCPPT() {
            $.LoadingOverlay("show");
            $('#modalCPPT').modal('show');
            $.LoadingOverlay("hide");
        }
    </script>
@endpush
