<x-adminlte-modal id="modalAsesmenRajal" title="Asesmen Rajal" size="xl" icon="fas fa-file-medical" theme="success">
    @include('form.asesmen_rajal')
    <x-slot name="footerSlot">
        <a href="{{ route('print_asesmen_rajal') }}?kodekunjungan={{ $antrian->kunjungan->kode }}" class="btn btn-warning ml-auto" target="_blank"> <i
                class="fas fa-print"></i> Print</a>
        <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
