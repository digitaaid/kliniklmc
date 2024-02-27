<x-adminlte-modal id="modalCPPT" title="CPPT" size="xl" icon="fas fa-file-medical" theme="success">
    <style>
        pre {
            padding: 0 !important;
            margin-bottom: 0 !important;
            font-size: 14px !important;
            border: none;
            outline: none;
        }
    </style>
    @include('form.cppt')
    <x-slot name="footerSlot">
        <a href="{{ route('print_cppt') }}?pasien={{ $antrian->norm }}" class="btn btn-warning ml-auto" target="_blank"> <i
                class="fas fa-print"></i> Print</a>
        <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
