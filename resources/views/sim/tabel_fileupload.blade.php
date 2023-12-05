<x-adminlte-modal id="modalFileUpload" name="modalFileUpload" title="Berkas Upload" theme="warning"
    icon="fas fa-file-medical" size="xl">
    @php
        $heads = ['Tgl Upload', 'Pasien', 'Nama File', 'Label', 'Action'];
        $config['paging'] = false;
        $config['info'] = false;
    @endphp
    <x-adminlte-datatable id="tableFile" class="nowrap text-xs" :heads="$heads" :config="$config" bordered hoverable
        compressed>
    </x-adminlte-datatable>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="success" class="mr-auto btnUploadFile" icon="fas fa-upload" label="Upload File" />
        <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
<x-adminlte-modal id="inputFileUpload" name="inputFileUpload" title="Upload Berkas" theme="success"
    icon="fas fa-file-medical">
    <form action="{{ route('uploadpenunjang') }}" name="formFile" id="formFile" method="POST"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
        <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
        <input type="hidden" name="kodekunjungan" value="{{ $antrian->kunjungan->kode ?? null }}">
        <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan->id ?? null }}">
        <input type="hidden" name="norm" value="{{ $antrian->norm ?? null }}">
        <input type="hidden" name="namapasien" value="{{ $antrian->nama ?? null }}">
        <x-adminlte-input name="nama" placeholder="Nama / Keterangan File" igroup-size="sm" label="Nama File"
            enable-old-support required />
        <x-adminlte-select name="label" label="Label">
            <option selected disabled>Pilih Label File</option>
            <option value="Lain-lain">Lain-lain</option>
            <option value="Laboratorium">Laboratorium</option>
            <option value="Radiologi">Radiologi</option>
            <option value="Patologi Anatomi">Patologi Anatomi</option>
            <option value="Imunohistokimia">Imunohistokimia</option>
            <option value="Rawat Jalan">Rawat Jalan</option>
            <option value="Rawat Inap">Rawat Inap</option>
            <option value="Kemoterapi">Kemoterapi</option>
            <option value="USG">USG</option>
            <option value="Echocardiography">Echocardiography</option>
            <option value="Rekam Medis">Rekam Medis</option>
        </x-adminlte-select>
        <x-adminlte-input-file name="file" placeholder="Pilih file yang akan diupload" igroup-size="sm"
            label="Upload Image" />
    </form>
    <x-slot name="footerSlot">
        <button type="submit" form="formFile" class="btn btn-success withLoad">
            <i class="fas fa-upload"></i> Upload
        </button>
        <x-adminlte-button theme="danger" icon="fas fa-times" label="Kembali" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
<x-adminlte-modal id="lihatFileUpload" name="lihatFileUpload" title="File Penunjang" theme="success"
    icon="fas fa-file-medical" size="xl">
    <iframe id="frameFileUpload" src="" height="600px" width="100%" title="Iframe Example"></iframe>
    <x-slot name="footerSlot">
        <a href="" id="urlFileUpload" target="_blank" class="btn btn-primary mr-auto">
            <i class="fas fa-download "></i>Download</a>
        <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
<script>
    $(function() {
        $('.btnFileUplpad').click(function() {
            $.LoadingOverlay("show");
            $('#modalFileUpload').modal('show');
            var table = $('#tableFile').DataTable();
            table.rows().remove().draw();
            var url = "{{ route('fileupload_norm') }}?norm={{ $antrian->norm }}";
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    if (data.metadata.code == 200) {
                        $.each(data.response, function(key, value) {
                            console.log(value);
                            var btn =
                                "<button class='btnLihatFile btn btn-success btn-xs mr-1' data-fileurl=" +
                                value.fileurl +
                                ">Lihat</button>";
                            table.row.add([
                                value.updated_at,
                                value.norm + " " + value.namapasien,
                                value.nama,
                                value.label,
                                btn,
                            ]).draw(false);
                        });
                        $('.btnLihatFile').click(function() {
                            $.LoadingOverlay("show");
                            $('#frameFileUpload').attr('src', $(this).data(
                                'fileurl'));
                            $('#urlFileUpload').attr('href', $(this).data(
                                'fileurl'));
                            $('#lihatFileUpload').modal('show');
                            $.LoadingOverlay("hide");
                        });
                        // $('.btnHapusSEP').click(function() {
                        //     $.LoadingOverlay("show");
                        //     var nomorsep = $(this).data('id');
                        //     var url = "{{ route('sep_hapus') }}?noSep=" +
                        //         nomorsep;
                        //     window.location.href = url;
                        // });
                    } else {
                        Swal.fire(
                            'Error ' + data.metadata.code,
                            data.metadata.message,
                            'error'
                        );
                    }
                    $.LoadingOverlay("hide");
                },
                error: function(data) {
                    alert('Error');
                    $.LoadingOverlay("hide");
                }
            });
        });
        $('.btnUploadFile').click(function() {
            $.LoadingOverlay("show");
            $('#inputFileUpload').modal('show');
            $.LoadingOverlay("hide");
        });
    });
</script>
