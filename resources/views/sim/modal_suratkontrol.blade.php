<x-adminlte-modal id="modalRujukan" name="modalRujukan" title="Peserta Rujukan Peserta" theme="success"
    icon="fas fa-file-medical" size="xl">
    @php
        $heads = ['tglKunjungan', 'noKunjungan', 'provPerujuk', 'Nama', 'jnsPelayanan', 'poli', 'Action'];
        $config['paging'] = false;
        $config['info'] = false;
    @endphp
    <x-adminlte-datatable id="tableRujukan" class="nowrap text-xs" :heads="$heads" :config="$config" bordered hoverable
        compressed>
    </x-adminlte-datatable>
</x-adminlte-modal>
<x-adminlte-modal id="modalSEP" name="modalSEP" title="SEP Peserta" theme="success" icon="fas fa-file-medical"
    size="xl">
    @php
        $heads = ['tglSep', 'tglPlgSep', 'noSep', 'jnsPelayanan', 'poli', 'diagnosa', 'Action'];
        $config['paging'] = false;
        $config['info'] = false;
    @endphp
    <x-adminlte-datatable id="tableSEP" class="nowrap text-xs" :heads="$heads" :config="$config" bordered hoverable
        compressed>
    </x-adminlte-datatable>
</x-adminlte-modal>
<x-adminlte-modal id="modalSuratKontrol" name="modalSuratKontrol" title="Surat Kontrol Peserta" theme="success"
    icon="fas fa-file-medical" size="xl">
    @php
        $heads = [
            'tglRencanaKontrol',
            'noSuratKontrol',
            'Nama',
            'jnsPelayanan',
            'namaPoliTujuan',
            'namaDokter',
            'terbitSEP',
            'Action',
        ];
        $config['paging'] = false;
        $config['info'] = false;
    @endphp
    <x-adminlte-datatable id="tableSuratKontrol" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
        hoverable compressed>
    </x-adminlte-datatable>
</x-adminlte-modal>
<x-adminlte-modal id="modalEditSuratKontrol" name="modalEditSuratKontrol" title="Edit Surat Kontrol" theme="success"
    icon="fas fa-file-medical">
    <form action="" id="formUpdate">
        <input type="hidden" name="user" value="{{ Auth::user()->name }}">
        <x-adminlte-input name="noSuratKontrol" class="noSurat-edit" igroup-size="sm" label="Nomor Surat Kontrol"
            placeholder="Nomor Surat Kontrol" readonly>
        </x-adminlte-input>
        <x-adminlte-input name="noSEP" class="noSEP-id" igroup-size="sm" label="Nomor SEP" placeholder="Nomor SEP"
            readonly>
        </x-adminlte-input>
        @php
            $config = ['format' => 'YYYY-MM-DD'];
        @endphp
        <x-adminlte-input-date name="tglRencanaKontrol" id="tglRencanaKontrolid" class="tglRencanaKontrol-id"
            igroup-size="sm" label="Tanggal Rencana Kontrol" value="{{ $request->tglRencanaKontrol }}"
            placeholder="Pilih Tanggal Rencana Kontrol" :config="$config">
            <x-slot name="appendSlot">
                <div class="btn btn-primary btnCariPoli">
                    <i class="fas fa-search"></i> Cari Poli
                </div>
            </x-slot>
        </x-adminlte-input-date>
        <x-adminlte-select igroup-size="sm" name="poliKontrol" class="poliKontrol-id" label="Poliklinik">
            <option selected disabled>Silahkan Klik Cari Poliklinik</option>
            <x-slot name="appendSlot">
                <div class="btn btn-primary btnCariDokter">
                    <i class="fas fa-search"></i> Cari Dokter
                </div>
            </x-slot>
        </x-adminlte-select>
        <x-adminlte-select igroup-size="sm" name="kodeDokter" class="kodeDokter-id" label="Dokter">
            <option selected disabled>Silahkan Klik Cari Dokter</option>
        </x-adminlte-select>
        <x-adminlte-textarea igroup-size="sm" label="Catatan" name="catatan" placeholder="Catatan Pasien" />
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="warning" icon="fas fa-edit" class="mr-auto btnUpdateSuratKontrol" label="Update" />
        <x-adminlte-button theme="danger" icon="fas fa-times" label="Tutup" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
@push('js')
    <script>
        function cariRujukan() {
            $.LoadingOverlay("show");
            var asalRujukan = $("#asalRujukan").find(":selected").val();
            var nomorkartu = $(".nomorkartu-id").val();
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

        function cariRujukanFktp() {
            $.LoadingOverlay("show");
            var asalRujukan = $("#asalRujukan").find(":selected").val();
            var nomorkartu = $(".nomorkartu-id").val();
            $('#modalRujukan').modal('show');
            var table = $('#tableRujukan').DataTable();
            table.rows().remove().draw();
            var url = "{{ route('rujukan_peserta') }}?nomorkartu=" + nomorkartu;
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

        function cariRujukanRS() {
            $.LoadingOverlay("show");
            var asalRujukan = $("#asalRujukan").find(":selected").val();
            var nomorkartu = $(".nomorkartu-id").val();
            $('#modalRujukan').modal('show');
            var table = $('#tableRujukan').DataTable();
            table.rows().remove().draw();
            var url = "{{ route('rujukan_rs_peserta') }}?nomorkartu=" + nomorkartu;
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

        function cariSEP() {
            var nomorkartu = $(".nomorkartu-id").val();
            $('#modalSEP').modal('show');
            var table = $('#tableSEP').DataTable();
            table.rows().remove().draw();
            $.LoadingOverlay("show");
            var url = "{{ route('suratkontrol_sep') }}?nomorkartu=" + nomorkartu;
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    if (data.metadata.code == 200) {
                        $.each(data.response, function(key, value) {
                            if (value.jnsPelayanan == 1) {
                                var jenispelayanan = "Rawat Inap";
                            }
                            if (value.jnsPelayanan == 2) {
                                var jenispelayanan = "Rawat Jalan";
                            }
                            var btnpilih =
                                "<button class='btnPilihSEP btn btn-success btn-xs mr-1' data-id=" +
                                value.noSep +
                                ">Pilih</button>";
                            var btnhapus =
                                "<button class='btnPilihSEP btn btn-success btn-xs mr-1' data-id=" +
                                value.noSep +
                                ">Pilih</button><button class='btnHapusSEP btn btn-danger btn-xs' data-id=" +
                                value.noSep + ">Hapus</button>";
                            if (value.tglPlgSep == null) {
                                var btn = btnhapus;
                            } else {
                                var btn = btnpilih;
                            }
                            table.row.add([
                                value.tglSep,
                                value.tglPlgSep,
                                value.noSep,
                                jenispelayanan,
                                value.poli,
                                value.diagnosa,
                                btn,
                            ]).draw(false);
                        });
                        $('.btnPilihSEP').click(function() {
                            var nomorsep = $(this).data('id');
                            $.LoadingOverlay("show");
                            $('#noSEP').val(nomorsep);
                            $('#modalSEP').modal('hide');
                            $.LoadingOverlay("hide");
                        });
                        $('.btnHapusSEP').click(function() {
                            $.LoadingOverlay("show");
                            var nomorsep = $(this).data('id');
                            var url = "{{ route('sep_hapus') }}?noSep=" +
                                nomorsep;
                            window.location.href = url;
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

        function cariSuratKontrol() {
            $.LoadingOverlay("show");
            var nomorkartu = $(".nomorkartu-id").val();
            $('#modalSuratKontrol').modal('show');
            var table = $('#tableSuratKontrol').DataTable();
            table.rows().remove().draw();
            var url = "{{ route('suratkontrol_peserta') }}?nomorkartu=" + nomorkartu +
                "&bulan={{ now()->format('m') }}&tahun={{ now()->format('Y') }}&formatfilter=2";
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    if (data.metadata.code == 200) {
                        $.each(data.response.list, function(key, value) {
                            table.row.add([
                                value.tglRencanaKontrol,
                                value.noSuratKontrol,
                                value.nama,
                                value.namaJnsKontrol,
                                value.namaPoliTujuan,
                                value.namaDokter,
                                value.terbitSEP,
                                "<button class='btnPilihSurat btn btn-success btn-xs mr-1' data-id=" +
                                value.noSuratKontrol +
                                " >Pilih</button><button class='btnEditSuratKontrol btn btn-warning  mr-1 btn-xs' data-id=" +
                                value.noSuratKontrol +
                                " data-nosepasal=" + value
                                .noSepAsalKontrol +
                                " >Edit</button><button class='btnHapusSuratKontrol btn btn-danger btn-xs' data-id=" +
                                value.noSuratKontrol + " >Hapus</button>",
                            ]).draw(false);
                        });
                        $('.btnPilihSurat').click(function() {
                            $.LoadingOverlay("show");
                            $('.noSurat-id').val($(this).data('id'));
                            $('#modalSuratKontrol').modal('hide');
                            $.LoadingOverlay("hide");
                        });
                        $('.btnEditSuratKontrol').click(function() {
                            $.LoadingOverlay("show");
                            $('#formUpdate').trigger("reset");
                            $('#modalEditSuratKontrol').modal('show');
                            $('.noSurat-edit').val($(this).data('id'));
                            $('.noSEP-id').val($(this).data('nosepasal'));
                            $.LoadingOverlay("hide");
                        });
                        $('.btnHapusSuratKontrol').click(function() {
                            $.LoadingOverlay("show");
                            var nomorsuratkontrol = $(this).data('id');
                            var url =
                                "{{ route('suratkontrol_hapus') }}?noSuratKontrol=" +
                                nomorsuratkontrol;
                            window.location.href = url;
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
