<div class="card card-info mb-1">
    <a data-toggle="collapse" class="card-header" data-parent="#accordion" href="#collapseOne">
        <h3 class="card-title">
            Riwayat Pasien
        </h3>
        <div class="card-tools">
            {{ $antrian->pasien ? $antrian->pasien->kunjungans->count() : 0 }} Kunjungan <i
                class="fas fa-info-circle"></i>
        </div>
    </a>
    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
        <div class="card-body p-1 mb-3">
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
            <x-adminlte-modal id="modalFilePenunjang" name="modalFilePenunjang" title="File Penunjang" theme="success"
                icon="fas fa-file-medical" size="xl">
                <iframe id="dataFilePenunjang" src="" height="600px" width="100%"
                    title="Iframe Example"></iframe>
                <x-slot name="footerSlot">
                    <a href="" id="urlFilePenunjang" target="_blank" class="btn btn-primary mr-auto">
                        <i class="fas fa-download "></i>Download</a>
                    <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
                </x-slot>
            </x-adminlte-modal>
        </div>
    </div>
</div>
