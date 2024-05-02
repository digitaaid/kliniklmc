<div class="card card-info mb-1">
    <a data-toggle="collapse" class="card-header" data-parent="#accordion" href="#collResume">
        <h3 class="card-title">
            Resume Rawat Jalan
        </h3>
    </a>
    <div id="collResume" class="collapse" role="tabpanel">
        <div class="card-body">
            <style>
                dd,
                dl,
                dt {
                    margin-bottom: 0 !important;
                }
            </style>
            @include('form.resume_rajal')
        </div>
    </div>
</div>
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

@push('js')
    <script>
        function btnResumeRajal() {
            $.LoadingOverlay("show");
            $('#modalResumeRajal').modal('show');
            $.LoadingOverlay("hide");
        }
    </script>
@endpush
