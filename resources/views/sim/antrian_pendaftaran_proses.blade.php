@extends('adminlte::page')
@section('title', 'Antrian Pendaftaran')
@section('content_header')
    <h1>Antrian Pendaftaran</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                <x-adminlte-alert title="Ops Terjadi Masalah !" theme="danger" dismissable>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-adminlte-alert>
            @endif
            <a href="{{ route('antrianpendaftaran') }}?tanggalperiksa={{ $antrian->tanggalperiksa }}"
                class="btn btn-xs btn-danger mb-2 mr-1 withLoad">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('panggilpendaftaran') }}?kodebooking={{ $antrian->kodebooking }}"
                class="btn btn-xs btn-primary mb-2 mr-1 withLoad">
                <i class="fas fa-volume-up"></i> Panggil
            </a>
            <div class="btn btn-xs btn-{{ $antrian->taskid == 3 ? 'success' : 'secondary' }} mb-2 mr-1">
                <i class="fas fa-{{ $antrian->taskid == 3 ? 'check-circle' : 'info-circle' }}"></i>
                @switch($antrian->taskid)
                    @case(0)
                        Belum Checkin
                    @break

                    @case(1)
                        Tunggu Pendaftaran
                    @break

                    @case(2)
                        Proses Pendaftaran {{ $antrian->taskid1 }}
                    @break

                    @case(3)
                        Tunggu Poliklinik
                    @break

                    @case(4)
                        Pemeriksaan Dokter
                    @break

                    @case(5)
                        Tunggu Farmasi
                    @break

                    @case(6)
                        Proses Farmasi
                    @break

                    @case(7)
                        Selesai Pelayanan
                    @break

                    @case(99)
                        Batal
                    @break

                    @default
                @endswitch
            </div>
            <x-adminlte-card theme="primary" theme-mode="outline">
                @include('sim.antrian_profil3')
                <x-slot name="footerSlot">
                    <x-adminlte-button class="btn-xs btnModalPasien" theme="warning" label="Pencarian Pasien"
                        icon="fas fa-search" />
                    <x-adminlte-button class="btn-xs" theme="warning" label="Riwayat Kunjungan"
                        icon="fas fa-user-injured" />
                    <x-adminlte-button class="btn-xs btnCariRujukanFKTP" theme="warning" label="Rujukan FKTP"
                        icon="fas fa-file-medical" />
                    <x-adminlte-button class="btn-xs btnCariRujukanRS" theme="warning" label="Rujukan RS"
                        icon="fas fa-file-medical" />
                    <x-adminlte-button class="btn-xs btnCariSEP" theme="warning" label="SEP"
                        icon="fas fa-file-medical" />
                    <x-adminlte-button class="btn-xs btnCariSuratKontrol" theme="warning" label="Surat Kontrol"
                        icon="fas fa-file-medical" />
                    <x-adminlte-button class="btn-xs" theme="warning" label="Berkas Upload" icon="fas fa-file-medical" />
                </x-slot>
            </x-adminlte-card>
        </div>
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile p-3" style="overflow-y: auto ;max-height: 550px ;">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        @include('sim.tabel_antrian')
                        @if ($antrian->jenispasien == 'JKN')
                            @include('sim.tabel_sep')
                            @include('sim.tabel_suratkontrol')
                        @endif
                        @include('sim.tabel_kunjungan')
                        @if ($antrian->kunjungan)
                            {{-- layanan --}}
                            @include('sim.tabel_layanan')
                            {{-- laboratorium --}}
                            @if ($antrian->kunjungan->layanan)
                                @if ($antrian->kunjungan->layanan->laboratorium)
                                    @include('sim.tabel_lab')
                                @endif
                            @endif
                            @if ($antrian->kunjungan->layanan)
                                @if ($antrian->kunjungan->layanan->radiologi)
                                    {{-- radiologi --}}
                                    <div class="card card-info mb-1">
                                        <a class="card-header" data-toggle="collapse" data-parent="#accordion"
                                            href="#collRad">
                                            <h3 class="card-title">
                                                E-Radiologi
                                            </h3>
                                        </a>
                                        <div id="collRad" class="collapse" role="tabpanel" aria-labelledby="headRad">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <x-adminlte-textarea igroup-size="sm" rows=4
                                                            label="Catatan Radiologi" name="catatan_rad"
                                                            placeholder="Catatan Radiologi">
                                                            {{ $kunjungan->asesmendokter->catatan_rad ?? null }}
                                                        </x-adminlte-textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            {{-- kasir --}}
                            <div class="card card-info mb-1">
                                <div class="card-header" role="tab" id="headKasir">
                                    <h3 class="card-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collKasir"
                                            aria-expanded="true" aria-controls="collKasir">
                                            Kasir
                                        </a>
                                    </h3>
                                </div>
                                <div id="collKasir" class="collapse" role="tabpanel" aria-labelledby="headKasir">
                                    <div class="card-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                        richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor
                                        brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor,
                                        sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                        shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson
                                        cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo.
                                        Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt
                                        you probably haven't heard of them accusamus labore sustainable VHS.
                                    </div>
                                </div>
                            </div>
                            {{-- riwayatpasien --}}
                            {{-- @include('sim.tabel_riwayat_pasien') --}}
                            {{-- filepenunjang --}}
                            @include('sim.tabel_filepenunjang')
                            <div class="card card-info mb-1">
                                <div class="card-header" role="tab" id="headPrev">
                                    <h3 class="card-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collPreview"
                                            aria-expanded="true" aria-controls="collPreview">
                                            Preview Berkas Pendaftaran
                                        </a>
                                    </h3>
                                </div>
                                <div id="collPreview" class="collapse" role="tabpanel" aria-labelledby="headPrev">
                                    <div class="card-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                        richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor
                                        brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor,
                                        sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                        shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson
                                        cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo.
                                        Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt
                                        you probably haven't heard of them accusamus labore sustainable VHS.
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    @if ($antrian->kunjungan)
                        <a href="{{ route('lanjutpoliklinik') }}?kodebooking={{ $antrian->kodebooking }}"
                            class="btn btn-warning withLoad">
                            <i class="fas fa-user-plus"></i> Lanjut Pemeriksaan Dokter
                        </a>
                    @endif
                    <a href="{{ route('batalantrian') }}?kodebooking={{ $antrian->kodebooking }}&keterangan=Dibatalkan dipendaftaran {{ Auth::user()->name }}"
                        class="btn btn-danger withLoad">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
    <x-adminlte-modal id="modalRujukan" name="modalRujukan" title="Peserta Rujukan Peserta" theme="success"
        icon="fas fa-file-medical" size="xl">
        @php
            $heads = ['tglKunjungan', 'noKunjungan', 'provPerujuk', 'Nama', 'jnsPelayanan', 'poli', 'Action'];
            $config['paging'] = false;
            $config['info'] = false;
        @endphp
        <x-adminlte-datatable id="tableRujukan" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
            hoverable compressed>
        </x-adminlte-datatable>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalSuratKontrol" name="modalSuratKontrol" title="Surat Kontrol Peserta" theme="success"
        icon="fas fa-file-medical" size="xl">
        @php
            $heads = ['tglRencanaKontrol', 'noSuratKontrol', 'Nama', 'jnsPelayanan', 'namaPoliTujuan', 'namaDokter', 'terbitSEP', 'Action'];
            $config['paging'] = false;
            $config['info'] = false;
        @endphp
        <x-adminlte-datatable id="tableSuratKontrol" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
            hoverable compressed>
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
    <x-adminlte-modal id="modalEditSuratKontrol" name="modalEditSuratKontrol" title="Edit Surat Kontrol" theme="success"
        icon="fas fa-file-medical">
        <form action="" id="formUpdate">
            <input type="hidden" name="user" value="{{ Auth::user()->name }}">
            <x-adminlte-input name="noSuratKontrol" class="noSurat-edit" igroup-size="sm" label="Nomor Surat Kontrol"
                placeholder="Nomor Surat Kontrol" readonly>
            </x-adminlte-input>
            <x-adminlte-input name="noSEP" class="noSEP-id" igroup-size="sm" label="Nomor SEP"
                placeholder="Nomor SEP" readonly>
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
            <x-adminlte-button theme="warning" icon="fas fa-edit" class="mr-auto btnUpdateSuratKontrol"
                label="Update" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Tutup" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalPasien" name="modalPasien" title="Pasien" theme="success" icon="fas fa-user-injured"
        size="xl">
        <div class="row">
            <div class="col-md-7">
                <x-adminlte-button id="btnTambah" class="btn-sm mb-2" theme="success" label="Tambah Pasien"
                    icon="fas fa-plus" />
            </div>
            <div class="col-md-5">
                <form action="" method="get">
                    <x-adminlte-input name="search" placeholder="Pencarian No RM / BPJS / NIK / Nama" igroup-size="sm">
                        <x-slot name="appendSlot">
                            <x-adminlte-button id="btnCariPasien" theme="primary" icon="fas fa-search" label="Cari" />
                        </x-slot>
                    </x-adminlte-input>
                </form>
            </div>
        </div>
        @php
            $heads = ['No RM', 'No BPJS', 'NIK', 'Nama Pasien', 'Tgl Lahir', 'Action'];
            $config['paging'] = false;
            $config['info'] = false;
            $config['searching'] = false;
        @endphp
        <x-adminlte-datatable id="tablePasien" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
            hoverable compressed>
        </x-adminlte-datatable>
    </x-adminlte-modal>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.BsCustomFileInput', true)
@section('js')
    <script>
        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            $('.btnCariKartu').click(function() {
                $.LoadingOverlay("show");
                var nomorkartu = $(".nomorkartu-id").val();
                var url = "{{ route('peserta_nomorkartu') }}?nomorkartu=" + nomorkartu +
                    "&tanggal={{ now()->format('Y-m-d') }}";
                $.get(url, function(data, status) {
                    if (status == "success") {
                        if (data.metadata.code == 200) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
                            var pasien = data.response.peserta;
                            $(".nama-id").val(pasien.nama);
                            $(".nik-id").val(pasien.nik);
                            $(".nomorkartu-id").val(pasien.noKartu);
                            $(".norm-id").val(pasien.mr.noMR);
                            $(".tgllahir-id").val(pasien.tglLahir);
                            $(".gender-id").val(pasien.sex);
                            $(".penjamin-id").val(pasien.jenisPeserta.keterangan);
                            $(".kelas-id").val(pasien.hakKelas.kode);
                            if (pasien.mr.noMR == null) {
                                Swal.fire(
                                    'Mohon Maaf !',
                                    "Pasien baru belum memiliki no RM",
                                    'error'
                                )
                            }
                            $(".nohp-id").val(pasien.mr.noTelepon);
                            console.log(pasien);
                        } else {
                            // alert(data.metadata.message);
                            Swal.fire(
                                'Mohon Maaf !',
                                data.metadata.message,
                                'error'
                            )
                        }
                    } else {
                        console.log(data);
                        alert("Error Status: " + status);
                    }
                });
                $.LoadingOverlay("hide");
            });
            $('.btnCariNIK').click(function() {
                $.LoadingOverlay("show");
                var nomorkartu = $(".nik-id").val();
                var url = "{{ route('peserta_nik') }}?nik=" + nomorkartu +
                    "&tanggal={{ now()->format('Y-m-d') }}";
                $.get(url, function(data, status) {
                    if (status == "success") {
                        if (data.metadata.code == 200) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
                            });
                            var pasien = data.response.peserta;
                            $(".nama-id").val(pasien.nama);
                            $(".nik-id").val(pasien.nik);
                            $(".nomorkartu-id").val(pasien.noKartu);
                            $(".norm-id").val(pasien.mr.noMR);
                            $(".tgllahir-id").val(pasien.tglLahir);
                            $(".gender-id").val(pasien.sex);
                            $(".penjamin-id").val(pasien.jenisPeserta.keterangan);
                            $(".kelas-id").val(pasien.hakKelas.kode);
                            if (pasien.mr.noMR == null) {
                                Swal.fire(
                                    'Mohon Maaf !',
                                    "Pasien baru belum memiliki no RM",
                                    'error'
                                )
                            }
                            $(".nohp-id").val(pasien.mr.noTelepon);
                            console.log(pasien);
                        } else {
                            // alert(data.metadata.message);
                            Swal.fire(
                                'Mohon Maaf !',
                                data.metadata.message,
                                'error'
                            )
                        }
                    } else {
                        console.log(data);
                        alert("Error Status: " + status);
                    }
                });
                $.LoadingOverlay("hide");
            });
            $('.btnCariRujukan').click(function() {
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
            });
            $('.btnCariRujukanRS').click(function() {
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
            });
            $('.btnCariRujukanFKTP').click(function() {
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
            });
            $('.btnModalPasien').click(function() {
                $('#modalPasien').modal('show');
            });
            $('#btnCariPasien').click(function() {
                $.LoadingOverlay("show");
                var search = $("#search").val();
                var url = "{{ route('pasiensearch') }}?search=" + search;
                var table = $('#tablePasien').DataTable();
                table.rows().remove().draw();
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $.each(data.response, function(key, value) {
                            console.log(value);
                            table.row.add([
                                value.norm,
                                value.nomorkartu,
                                value.nik,
                                value.nama,
                                value.tgl_lahir,
                                "<button class='btnPilihPasien btn btn-success btn-xs mr-1' data-norm=" +
                                value.norm +
                                " >Pilih</button>",
                            ]).draw(false);
                        });
                        $.LoadingOverlay("hide");
                    },
                    error: function(data) {
                        alert('Error');
                        console.log(data);
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('.btnCariSuratKontrol').click(function() {
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
            });
            $(".diagnosaid1").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_icd10_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            diagnosa: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            $(".diagnosaid2").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_icd10_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            diagnosa: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            $('.btnCariSEP').click(function(e) {
                var nomorkartu = $(".nomorkartu-id").val();
                $('#modalSEP').modal('show');
                var table = $('#tableSEP').DataTable();
                table.rows().remove().draw();
                $.LoadingOverlay("show");
                e.preventDefault();
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
            });
            $('.btnCariPoli').click(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                var sep = $('.noSEP-id').val();
                var tanggal = $('.tglRencanaKontrol-id').val();
                if (tanggal == '') {
                    var tanggal = $('#tglRencanaKontrolid').val();
                }
                var url = "{{ route('suratkontrol_poli') }}?nomor=" + sep + "&tglRencanaKontrol=" +
                    tanggal;
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
                                $('.poliKontrol-id').append(new Option(optText,
                                    optValue));
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
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
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('.btnCariDokter').click(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                var poli = $('.poliKontrol-id').find(":selected").val();
                var tanggal = $('.tglRencanaKontrol-id').val();
                if (tanggal == '') {
                    var tanggal = $('#tglRencanaKontrolid').val();
                }
                var url = "{{ route('suratkontrol_dokter') }}?kodePoli=" + poli + "&tglRencanaKontrol=" +
                    tanggal;
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $('.kodeDokter-id').empty()
                            $.each(data.response.list, function(key, value) {
                                optText = value.namaDokter + " (" + value
                                    .jadwalPraktek +
                                    ")";
                                optValue = value.kodeDokter;
                                $('.kodeDokter-id').append(new Option(optText,
                                    optValue));
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Pasien Ditemukan'
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
                        alert(url);
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $('.btnUpdateSuratKontrol').click(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{ route('suratkontrol_update') }}",
                    type: "PUT",
                    data: $('#formUpdate').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data.metadata.code == 200) {
                            Swal.fire(
                                'Success',
                                'Berhasi upadate surat kontrol',
                                'success'
                            );
                            $('#modalSuratKontrol').modal('hide');
                            $('#modalEditSuratKontrol').modal('hide');
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
                        console.log(data);
                        $.LoadingOverlay("hide");
                    }
                });
            });
        });
    </script>
    {{-- dynamic layanan input --}}
    <script>
        $(".cariLayanan").select2({
            placeholder: 'Pencarian Pelayanan',
            theme: "bootstrap4",
            multiple: true,
            maximumSelectionLength: 1,
            ajax: {
                url: "{{ route('ref_tarif_layanan') }}?jenispasien={{ $antrian->jenispasien }}",
                type: "get",
                dataType: 'json',
                delay: 100,
                data: function(params) {
                    return {
                        search: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        $("#addLayanan").click(function() {
            newRowAdd =
                '<div id="row"><div class="form-group"><div class="input-group input-group-sm">' +
                '<select name="layanan[]" class="form-control cariLayanan"></select>' +
                '<input type="number" name="jumlah[]" placeholder="Jumlah" class="form-control" multiple>' +
                '<button type="button" class="btn btn-xs btn-danger" id="deleteLayanan"><i class="fas fa-trash "></i> </div></div></div>';
            $('#newLayanan').append(newRowAdd);
            $(".cariLayanan").select2({
                placeholder: 'Pencarian Pelayanan',
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('ref_tarif_layanan') }}?jenispasien={{ $antrian->jenispasien }}",
                    type: "get",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            search: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
        });
        $("body").on("click", "#deleteLayanan", function() {
            $(this).parents("#row").remove();
        })
    </script>
    <script>
        $(function() {
            $('.btnFilePenunjang').click(function() {
                $('#dataFilePenunjang').attr('src', $(this).data('fileurl'));
                $('#urlFilePenunjang').attr('href', $(this).data('fileurl'));
                $('#modalFilePenunjang').modal('show');
            });
        });
    </script>
@endsection
