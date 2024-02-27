<x-adminlte-modal id="modalResumeRajal" title="Resume Rawat" size="xl" icon="fas fa-hand-holding-medical"
    theme="success">
    <style>
        dd,
        dl,
        dt {
            margin-bottom: 0 !important;
        }
    </style>
    @include('form.resume_rajal')
    <x-slot name="footerSlot">
        <a href="{{ route('print_resume_rajal') }}?kodekunjungan={{ $antrian->kunjungan->kode }}"
            class="btn btn-warning ml-auto" target="_blank"> <i class="fas fa-print"></i> Print</a>
        <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
