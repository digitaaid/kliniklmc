{{-- <x-adminlte-modal id="modalEditSuratKontrol" name="modalEditSuratKontrol" title="Edit Surat Kontrol" theme="success"
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
</x-adminlte-modal> --}}
<x-adminlte-modal id="modalBuatSuratKontrol" title="Buat Surat Kontrol" size="xl" theme="warning"
    icon="fas fa-file-medical">
    <form action="{{ route('suratkontrol.store') }}" id="formSuratKontrol" method="POST">
        @csrf
        {{-- <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}"> --}}
        {{-- <input type="hidden" name="antrian_id" value="{{ $antrian->id }}"> --}}
        <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
            name="nomorkartu" class="nomorkartu-suratkontrol" value="{{ $antrian->nomorkartu }}" label="Nomor Kartu"
            placeholder="Nomor Kartu" />
        <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
            name="noSEP" class="noSEP-id" label="Nomor SEP" placeholder="Nomor SEP" readonly>
            <x-slot name="appendSlot">
                <x-adminlte-button theme="primary" label="Cari SEP" icon="fas fa-search" onclick="cariSEP()" />
            </x-slot>
        </x-adminlte-input>
        @php
            $config = ['format' => 'YYYY-MM-DD'];
        @endphp
        <x-adminlte-input-date fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
            name="tglRencanaKontrol" label="Tgl Kontrol" placeholder="Pilih Tanggal Rencana Kontrol" :config="$config">
        </x-adminlte-input-date>
        <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
            name="poliKontrol" class="poliKontrol-id" label="Poliklinik">
            <option selected disabled>Silahkan Klik Cari Poliklinik</option>
            <x-slot name="appendSlot">
                <x-adminlte-button theme="primary" label="Cari Poli" icon="fas fa-search" onclick="cariPoli()" />
            </x-slot>
        </x-adminlte-select>
        <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
            name="kodeDokter" class="kodeDokter-id" label="Dokter">
            <option selected disabled>Silahkan Klik Cari Dokter</option>
            <x-slot name="appendSlot">
                <x-adminlte-button theme="primary" label="Cari Dokter" icon="fas fa-search" onclick="cariDokter()" />
            </x-slot>
        </x-adminlte-select>
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button class="mr-auto withLoad" theme="success" form="formSuratKontrol" type="submit"
            label="Buat Surat Kontrol" />
        <x-adminlte-button theme="danger" label="Tutup" icon="fas fa-times" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
<x-adminlte-modal id="modalSuratKontrolBerikutnya" title="Buat Surat Kontrol Untuk Kunjungan Berikutnya" size="xl"
    theme="success" icon="fas fa-file-medical">
    <form action="{{ route('suratkontrol.store') }}" id="formSuratKontrolBerikutnya" method="POST">
        @csrf
        <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
        <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
        <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
            name="nomorkartu" value="{{ $antrian->nomorkartu }}" label="Nomor Kartu" placeholder="Nomor Kartu" />
        <x-adminlte-input fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
            name="noSEP" class="noSEP-id" id="noSEPBerikutnya" label="Nomor SEP" placeholder="Nomor SEP" readonly>
            <x-slot name="appendSlot">
                <x-adminlte-button theme="primary" label="Cari SEP" icon="fas fa-search" onclick="cariSEP()" />
            </x-slot>
        </x-adminlte-input>
        @php
            $config = ['format' => 'YYYY-MM-DD'];
        @endphp
        <x-adminlte-input-date fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
            igroup-size="sm" name="tglRencanaKontrol" id="tglRencanaKontrolBerikutnya" label="Tgl Kontrol"
            placeholder="Pilih Tanggal Rencana Kontrol" :config="$config">
        </x-adminlte-input-date>
        <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
            name="poliKontrol" class="poliKontrol-id" id="poliKontrolBerikutnya" label="Poliklinik">
            <option selected disabled>Silahkan Klik Cari Poliklinik</option>
            <x-slot name="appendSlot">
                <x-adminlte-button theme="primary" label="Cari Poli" icon="fas fa-search"
                    onclick="cariPoliBerikutnya()" />
            </x-slot>
        </x-adminlte-select>
        <x-adminlte-select fgroup-class="row" label-class="text-left col-3" igroup-class="col-9" igroup-size="sm"
            name="kodeDokter" class="kodeDokter-id" label="Dokter">
            <option selected disabled>Silahkan Klik Cari Dokter</option>
            <x-slot name="appendSlot">
                <x-adminlte-button theme="primary" label="Cari Dokter" icon="fas fa-search"
                    onclick="cariDokterBerikutnya()" />
            </x-slot>
        </x-adminlte-select>
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button class="mr-auto withLoad" theme="success" form="formSuratKontrolBerikutnya" type="submit"
            label="Buat Surat Kontrol" />
        <x-adminlte-button theme="danger" label="Tutup" icon="fas fa-times" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
<x-adminlte-modal id="modalSEP" name="modalSEP" title="SEP Peserta" theme="success" icon="fas fa-file-medical"
    size="xl">
    <x-adminlte-button theme="success" class="btn-sm mb-2" label="Buat SEP" icon="fas fa-file-medical"
        onclick="modalBuatSEP()" />
    @php
        $heads = ['tglSep', 'tglPlgSep', 'noSep', 'Action', 'jnsPelayanan', 'poli', 'ppkPelayanan', 'diagnosa'];
        $config['paging'] = false;
        $config['info'] = false;
        $config['order'] = ['0', 'desc'];
    @endphp
    <x-adminlte-datatable id="tableSEP" class="nowrap text-xs" :heads="$heads" :config="$config" bordered hoverable
        compressed>
    </x-adminlte-datatable>
</x-adminlte-modal>
<x-adminlte-modal id="modalBuatSEP" title="Buat SEP" size="xl" theme="success" icon="fas fa-file-medical">
    <form action="{{ route('sep.store') }}" id="formBuatSEP" method="POST">
        @csrf
        <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
        <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-input name="noKartu" class="nomorkartu-sep" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" label="Nomor Kartu"
                    placeholder="Nomor Kartu" value="{{ $antrian->nomorkartu }}" readonly />
                <x-adminlte-input name="noMR" class="norm-id" label="No RM" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" placeholder="No RM"
                    value="{{ $antrian->norm }}" readonly />
                <x-adminlte-input name="nama" class="nama-id" label="Nama Pasien" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" placeholder="Nama Pasien"
                    value="{{ $antrian->nama }}" readonly />
                <x-adminlte-input name="noTelp" class="nohp-id" label="Nomor HP" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" placeholder="Nomor HP"
                    value="{{ $antrian->nohp }}" readonly />
                <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                    igroup-size="sm" name="asalRujukan" class="asalRujukan-sep" label="Jenis Rujukan"
                    enable-old-support>
                    <option value="1">Rujukan FKTP</option>
                    <option value="2">Rujukan Antar RS</option>
                </x-adminlte-select>
                <x-adminlte-input name="noRujukan" class="noRujukan-id" fgroup-class="row"
                    label-class="text-left col-4" igroup-class="col-8" igroup-size="sm" label="Nomor Rujukan"
                    placeholder="No Rujukan" readonly enable-old-support>
                    <x-slot name="appendSlot">
                        <x-adminlte-button theme="primary" label="Cari" icon="fas fa-search"
                            onclick="cariRujukanSEP()" />
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="noSurat" class="noSurat-id" fgroup-class="row" label-class="text-left col-4"
                    igroup-class="col-8" igroup-size="sm" label="No Surat Kontrol" placeholder="Nomor Surat Kontrol"
                    readonly enable-old-support>
                    <x-slot name="appendSlot">
                        <x-adminlte-button theme="primary" label="Cari" icon="fas fa-search"
                            onclick="cariSuratKontrol()" />
                    </x-slot>
                </x-adminlte-input>
                <input type="hidden" name="tglRujukan" id="tglrujukan" value="">
                <input type="hidden" name="ppkRujukan" id="ppkrujukan" value="">
            </div>
            <div class="col-md-6">
                <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                    igroup-size="sm" name="klsRawatHak" label="Jenis Pelayanan">
                    <option disabled>Pilih Kelas Pasien</option>
                    <option value="1">Kelas 1</option>
                    <option value="2">Kelas 2</option>
                    <option value="3">Kelas 3</option>
                </x-adminlte-select>
                <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                    igroup-size="sm" name="jnsPelayanan" label="Jenis Pelayanan">
                    <option disabled>Pilih Jenis Pelayanan</option>
                    <option value="2" selected>Rawat Jalan</option>
                    <option value="1">Rawat Inap</option>
                </x-adminlte-select>
                <x-adminlte-select2 fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                    igroup-size="sm" name="tujuan" label="Poliklinik" required>
                    <option selected disabled>Pilih Poliklinik</option>
                    @foreach ($polikliniks as $key => $item)
                        <option value="{{ $key }}">{{ $item }}
                        </option>
                    @endforeach
                </x-adminlte-select2>
                <x-adminlte-select2 fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                    igroup-size="sm" name="dpjpLayan" label="Dokter DPJP" required>
                    <option selected disabled>Pilih Dokter DPJP</option>
                    @foreach ($dokters as $key => $item)
                        <option value="{{ $key }}">{{ $item }}
                        </option>
                    @endforeach
                </x-adminlte-select2>
                <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                    igroup-size="sm" name="tujuanKunj" label="Tujuan Kunjungan">
                    <option value="0">Normal</option>
                    <option value="1">Prosedur</option>
                    <option value="2">Konsul Dokter</option>
                </x-adminlte-select>
                <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                    igroup-size="sm" name="flagProcedure" label="Flag Procedur">
                    <option value="">Normal</option>
                    <option value="0">Prosedur Tidak Berkelanjutan</option>
                    <option value="1">Prosedur dan Terapi Berkelanjutan</option>
                </x-adminlte-select>
                <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                    igroup-size="sm" name="kdPenunjang" label="Penunjang">
                    <option value="">Normal</option>
                    <option value="1">Radioterapi</option>
                    <option value="2">Kemoterapi</option>
                    <option value="3">Rehabilitasi Medik</option>
                    <option value="4">Rehabilitasi Psikososial</option>
                    <option value="5">Transfusi Darah</option>
                    <option value="6">Pelayanan Gigi</option>
                    <option value="7">Laboratorium</option>
                    <option value="8">USG</option>
                    <option value="9">Lain-Lain</option>
                    <option value="10">Farmasi</option>
                    <option value="11">MRI</option>
                    <option value="12">HEMODIALISA</option>
                </x-adminlte-select>
                <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                    igroup-size="sm" name="assesmentPel" label="Assesment Pelayanan">
                    <option value="">Normal</option>
                    <option value="0">Poli tujuan beda dengan poli rujukan dan
                        hari beda
                    </option>
                    <option value="1">Poli spesialis tidak tersedia pada hari
                        sebelumnya
                    </option>
                    <option value="2">Jam Poli telah berakhir pada hari sebelumnya
                    </option>
                    <option value="3">Dokter Spesialis yang dimaksud tidak praktek
                        pada
                        hari
                        sebelumnya</option>
                    <option value="4">Atas Instruksi RS</option>
                    <option value="5">Tujuan Kontrol</option>
                </x-adminlte-select>
            </div>
        </div>
        <hr>
        <div class="col-md-12">
            <x-adminlte-select igroup-size="sm" name="diagAwal" label="Diagnosa Awal" class="diagnosaid1">
            </x-adminlte-select>
            <x-adminlte-textarea igroup-size="sm" label="Catatan / Keluhan" name="catatan"
                placeholder="Catatan Pasien" />
        </div>
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button class="mr-auto withLoad" theme="success" form="formBuatSEP" type="submit"
            label="Buat SEP" />
        <x-adminlte-button theme="danger" label="Tutup" icon="fas fa-times" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
<x-adminlte-modal id="modalSuratKontrol" name="modalSuratKontrol" title="Surat Kontrol Peserta" theme="success"
    icon="fas fa-file-medical" size="xl">
    <div class="row">
        <div class="col-md-6">
            @php
                $config = ['format' => 'YYYY-MM'];
            @endphp
            <x-adminlte-input-date fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                igroup-size="sm" name="tanggal" class="tanggalpencariankontrol" placeholder="Silahkan Pilih Tanggal"
                value="{{ $request->tanggal ?? now()->format('Y-m') }}" label="Bulan Periksa" :config="$config">
                <x-slot name="appendSlot">
                    <x-adminlte-button onclick="cariSuratKontrol()" theme="primary" icon="fas fa-search"
                        label="Cari" />
                </x-slot>
            </x-adminlte-input-date>
        </div>
        <div class="col-md-6">
            <x-adminlte-button theme="warning" class="btn-sm mb-2" label="Buat Surat Kontrol"
                icon="fas fa-file-medical" onclick="buatSuratKontrol()" />
            <x-adminlte-button theme="success" class="btn-sm mb-2" label="Buat Surat Kontrol Berikutnya"
                icon="fas fa-file-medical" onclick="modalSuratKontrolBerikutnya()" />
        </div>
    </div>
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
        $config['order'] = ['0', 'desc'];
    @endphp
    <x-adminlte-datatable id="tableSuratKontrol" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
        hoverable compressed>
    </x-adminlte-datatable>
</x-adminlte-modal>
@push('js')
    <script>
        function buatSuratKontrol() {
            $('#modalBuatSuratKontrol').modal('show');
        }

        function modalBuatSEP() {
            $('#modalBuatSEP').modal('show');
        }

        function modalSuratKontrolBerikutnya() {
            $('#modalSuratKontrolBerikutnya').modal('show');
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
            var nomorkartu = $(".nomorkartu-suratkontrol").val();
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
                                btn,
                                jenispelayanan,
                                value.poli,
                                value.ppkPelayanan,
                                value.diagnosa,
                            ]).draw(false);
                        });
                        $('.btnPilihSEP').click(function() {
                            var nomorsep = $(this).data('id');
                            $.LoadingOverlay("show");
                            $('.noSEP-id').val(nomorsep);
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

        function cariPoli() {
            $.LoadingOverlay("show");
            var sep = $('#noSEP').val();
            var tanggal = $('#tglRencanaKontrol').val();
            var url = "{{ route('suratkontrol_poli') }}?nomor=" + sep + "&tglRencanaKontrol=" +
                tanggal + "&jenisKontrol=2";
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    if (data.metadata.code == 200) {
                        $('.poliKontrol-id').empty()
                        $.each(data.response.list, function(key, value) {
                            optText = value.namaPoli + " (" + value.persentase +
                                "%)";
                            optValue = value.kodePoli;
                            $('.poliKontrol-id').append(new Option(optText, optValue));
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Poliklinik Ditemukan'
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.metadata.message
                        });
                    }
                    $.LoadingOverlay("hide");
                },
                error: function(data) {
                    Toast.fire({
                        icon: 'error',
                        title: data.metadata.message
                    });
                    $.LoadingOverlay("hide");
                }
            });
        }

        function cariDokter() {
            $.LoadingOverlay("show");
            var poli = $('#poliKontrol').find(":selected").val();
            var tanggal = $('#tglRencanaKontrol').val();
            var url = "{{ route('suratkontrol_dokter') }}?kodePoli=" + poli + "&tglRencanaKontrol=" +
                tanggal + "&jenisKontrol=2";
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    if (data.metadata.code == 200) {
                        $('.kodeDokter-id').empty();
                        $.each(data.response.list, function(key, value) {
                            optText = value.namaDokter + " (" + value
                                .jadwalPraktek +
                                ")";
                            optValue = value.kodeDokter;
                            $('.kodeDokter-id').append(new Option(optText, optValue));
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Dokter Ditemukan'
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.metadata.message
                        });
                    }
                    $.LoadingOverlay("hide");
                },
                error: function(data) {
                    Toast.fire({
                        icon: 'error',
                        title: data.metadata.message
                    });
                    $.LoadingOverlay("hide");
                }
            });
        }

        function cariPoliBerikutnya() {
            $.LoadingOverlay("show");
            var sep = $('#noSEPBerikutnya').val();
            var tanggal = $('#tglRencanaKontrolBerikutnya').val();
            var url = "{{ route('suratkontrol_poli') }}?nomor=" + sep + "&tglRencanaKontrol=" +
                tanggal + "&jenisKontrol=2";
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    if (data.metadata.code == 200) {
                        $('.poliKontrol-id').empty()
                        $.each(data.response.list, function(key, value) {
                            optText = value.namaPoli + " (" + value.persentase +
                                "%)";
                            optValue = value.kodePoli;
                            $('.poliKontrol-id').append(new Option(optText, optValue));
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Poliklinik Ditemukan'
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.metadata.message
                        });
                    }
                    $.LoadingOverlay("hide");
                },
                error: function(data) {
                    Toast.fire({
                        icon: 'error',
                        title: data.metadata.message
                    });
                    $.LoadingOverlay("hide");
                }
            });
        }

        function cariDokterBerikutnya() {
            $.LoadingOverlay("show");
            var poli = $('#poliKontrolBerikutnya').find(":selected").val();
            var tanggal = $('#tglRencanaKontrolBerikutnya').val();
            var url = "{{ route('suratkontrol_dokter') }}?kodePoli=" + poli + "&tglRencanaKontrol=" +
                tanggal + "&jenisKontrol=2";
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    if (data.metadata.code == 200) {
                        $('.kodeDokter-id').empty();
                        $.each(data.response.list, function(key, value) {
                            optText = value.namaDokter + " (" + value
                                .jadwalPraktek +
                                ")";
                            optValue = value.kodeDokter;
                            $('.kodeDokter-id').append(new Option(optText, optValue));
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Dokter Ditemukan'
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.metadata.message
                        });
                    }
                    $.LoadingOverlay("hide");
                },
                error: function(data) {
                    Toast.fire({
                        icon: 'error',
                        title: data.metadata.message
                    });
                    $.LoadingOverlay("hide");
                }
            });
        }

        function cariSuratKontrol() {
            $.LoadingOverlay("show");
            var nomorkartu = $(".nomorkartu-suratkontrol").val();
            var tanggal = $(".tanggalpencariankontrol").val();
            var table = $('#tableSuratKontrol').DataTable();
            table.rows().remove().draw();
            var url = "{{ route('suratkontrol_peserta') }}?nomorkartu=" + nomorkartu +
                "&tanggal=" + tanggal + "&formatfilter=2";
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
                    $('#modalSuratKontrol').modal('show');
                },
                error: function(data) {
                    alert('Error');
                    $.LoadingOverlay("hide");
                }
            });
        }
    </script>
@endpush
