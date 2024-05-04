    <div class="card card-info mb-1">
        <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collInvoice">
            <h3 class="card-title">
                Invoice Billing Pasien
            </h3>
            <div class="card-tools">
                <i class="fas fa-info-circle"></i>

            </div>
        </a>
        <div id="collInvoice" class="collapse" role="tabpanel" aria-labelledby="headLab">
            <div class="card-body">
                <iframe src="" id="invoiceIframe" width="100%" height="500px" frameborder="0"></iframe>
            </div>
        </div>
    </div>
    <x-adminlte-modal id="modalInvoicePasien" title="Invoice Billing Pasien" theme="success"
        icon="fas fa-file-invoice-dollar" size="xl">
        <div id="iframeLoaders" class="loader">
            <h4>Loading...</h4>
        </div>
        <iframe src="" id="urlInvoice" onload="loadInvoices()" width="100%" height="500px"
            frameborder="0"></iframe>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalPendaftaranSelesai" title="Verifikasi Pendaftaran Telah Selesai ?" theme="success"
        icon="fas fa-file-invoice-dollar" size="xl">
        <h6>Apakah pendaftran telah selesai dan bisa dilanjutkan kepemeriksaan berikutnya ? Silahkan cek kembali invoice billing</h6>
        <div id="iframeLoaderx" class="loader">
            <h4>Loading...</h4>
        </div>
        <iframe src="" id="iframeInvoicex" onload="loadInvoicex()" width="100%" height="500px"
            frameborder="0"></iframe>
        <x-slot name="footerSlot">
            <a href="{{ route('lanjutpoliklinik') }}?kodebooking={{ $antrian->kodebooking }}"
                class="btn btn-sm btn-warning withLoad mr-auto">
                <i class="fas fa-user-plus"></i> Lanjut Pemeriksaan Dokter
            </a>
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />

        </x-slot>
    </x-adminlte-modal>
    @push('js')
        <script>
            $(function() {
                var url = "{{ route('print_invoice_billing') }}?kodebooking={{ $antrian->kodebooking }}";
                $('#invoiceIframe').attr('src', url);
                // $('#urlInvoice').attr('src', url);
                // $('#iframeInvoicex').attr('src', url);
            });

            function loadInvoices() {
                $('#iframeLoaders').hide();
                $('#urlInvoice').show();
            }

            function loadInvoicex() {
                $('#iframeLoaderx').hide();
                $('#iframeInvoicex').show();
            }

            function modalInvoicePasien() {
                $.LoadingOverlay("show");
                var url = "{{ route('print_invoice_billing') }}?kodebooking={{ $antrian->kodebooking }}";
                $('#modalInvoicePasien').modal('show');
                $('#urlInvoice').attr('src', url);
                $('#iframeLoaders').show();
                $('#urlInvoice').hide();
                $.LoadingOverlay("hide");
            }

            function modalPendaftaranSelesai() {
                $.LoadingOverlay("show");
                var url = "{{ route('print_invoice_billing') }}?kodebooking={{ $antrian->kodebooking }}";
                $('#modalPendaftaranSelesai').modal('show');
                $('#iframeInvoicex').attr('src', url);
                $('#iframeLoaderx').show();
                $('#iframeInvoicex').hide();
                $.LoadingOverlay("hide");
            }
        </script>
    @endpush
