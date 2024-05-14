<div class="card card-info mb-1">
    <a class="card-header" data-toggle="collapse" data-parent="#accordion" href="#collSEP">
        <h3 class="card-title">SEP</h3>
        <div class="card-tools">
            <button type="button" onclick="modalBuatSEP()" class="btn btn-tool bg-warning">
                <i class="fas fa-edit"></i> Buat SEP
            </button>
            @if ($antrian->kunjungan->sep)
                <button type="button" class="btn btn-tool bg-success">
                    <i class="fas fa-check"></i> Sudah Dibuatkan
                </button>
            @else
                <button type="button" class="btn btn-tool bg-danger">
                    <i class="fas fa-times"></i> Belum Dibuatkan
                </button>
            @endif
        </div>
    </a>
    <div id="collSEP" class="collapse" role="tabpanel" aria-labelledby="headSEP">
        <div class="card-body">
            <x-adminlte-alert theme="{{ $antrian->sep ? 'success' : 'danger' }}"
                title="Silahkan buat SEP jika pasien BPJS">
                <b>Nomor SEP</b> : {{ $antrian->sep ?? 'Belum Dibuatkan' }} <br>
                @if ($antrian->sep)
                    <a class="btn btn-xs btn-warning text-dark" target="_blank"
                        href="{{ route('sep_print') }}?noSep={{ $antrian->sep }}" style="text-decoration: none">
                        <i class="fas fa-print"></i> Print SEP
                    </a>
                @endif
            </x-adminlte-alert>

        </div>
    </div>
</div>
@push('js')
    <script>
        function cariRujukanSEP() {
            $.LoadingOverlay("show");
            var asalRujukan = $(".asalRujukan-sep").find(":selected").val();
            var nomorkartu = $(".nomorkartu-sep").val();
            $('#modalRujukan').modal('show');
            var table = $('#tableRujukan').DataTable();
            table.rows().remove().draw();
            var url = "{{ route('rujukan_peserta') }}?nomorkartu=" + nomorkartu;
            switch (asalRujukan) {
                case '1':
                    var url = "{{ route('rujukan_peserta') }}?nomorkartu=" + nomorkartu;
                    break;
                case '2':
                    var url = "{{ route('rujukan_rs_peserta') }}?nomorkartu=" + nomorkartu;
                    break;
                default:
                    Swal.fire(
                        'Error',
                        'Pilih Jenis Rujukan',
                        'error'
                    );
                    break;
            }
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    if (data.metadata.code == 200) {
                        $.each(data.response.rujukan, function(key, value) {
                            table.row.add([
                                value.tglKunjungan,
                                value.noKunjungan,
                                value.provPerujuk.nama,
                                value.peserta.nama,
                                value.pelayanan.nama,
                                value.poliRujukan.nama,
                                "<button class='btnPilihRujukan btn btn-success btn-xs' data-id=" +
                                value.noKunjungan +
                                " data-kelas=" + value.peserta.hakKelas
                                .kode +
                                " data-tglrujukan=" + value.tglKunjungan +
                                " data-ppkrujukan=" + value.provPerujuk
                                .kode +
                                " >Pilih</button>",
                            ]).draw(false);
                        });
                        $('.btnPilihRujukan').click(function() {
                            $.LoadingOverlay("show");
                            $('#ppkrujukan').val($(this).data('ppkrujukan'));
                            $('.noRujukan-id').val($(this).data('id'));
                            $('#klsRawatHak').val($(this).data('kelas')).change();
                            $('#tglrujukan').val($(this).data('tglrujukan'));
                            $('#modalRujukan').modal('hide');
                            $.LoadingOverlay("hide");
                        });
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
        }
    </script>
@endpush
