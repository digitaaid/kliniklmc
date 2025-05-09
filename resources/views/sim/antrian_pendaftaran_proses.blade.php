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
            </x-adminlte-card>
        </div>
        <div class="col-md-3">
            <x-adminlte-card id="nav" theme="primary" title="Navigasi" body-class="p-0">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item" onclick="modalPasien()">
                        <a href="#nav" class="nav-link">
                            <i class="fas fa-user-injured"></i> Data Pasien
                        </a>
                    </li>
                    <li class="nav-item" onclick="lihatHasilLaboratorium()">
                        <a href="#nav" class="nav-link">
                            <i class="fas fa-user-plus"></i> Antrian
                            @if ($antrian->norm)
                                <span class="badge bg-success float-right">Sudah Didaftarkan</span>
                            @else
                                <span class="badge bg-danger float-right">Belum Didaftarkan</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item" onclick="lihatHasilLaboratorium()">
                        <a href="#nav" class="nav-link">
                            <i class="fas fa-user-plus"></i> Kunjungan
                        </a>
                    </li>
                    <li class="nav-item" onclick="modalPasien()">
                        <a href="#nav" class="nav-link">
                            <i class="fas fa-user-injured"></i> Berkas Upload
                        </a>
                    </li>
                    <li class="nav-item" onclick="cariRujukanFktp()">
                        <a href="#nav" class="nav-link">
                            <i class="fas fa-user-injured"></i> Rujukan FKTP
                        </a>
                    </li>
                    <li class="nav-item" onclick="cariRujukanRS()">
                        <a href="#nav" class="nav-link">
                            <i class="fas fa-user-injured"></i> Rujukan Antar RS
                        </a>
                    </li>
                    <li class="nav-item" onclick="cariSEP()">
                        <a href="#nav" class="nav-link">
                            <i class="fas fa-user-injured"></i> SEP
                        </a>
                    </li>
                    <li class="nav-item" onclick="cariSuratKontrol()">
                        <a href="#nav" class="nav-link">
                            <i class="fas fa-user-injured"></i> Surat Kontrol
                        </a>
                    </li>
                </ul>
            </x-adminlte-card>
        </div>
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile p-3" style="overflow-y: auto ;max-height: 600px ;">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        @include('sim.tabel_antrian')
                        @if ($antrian->jenispasien == 'JKN')
                            @include('sim.tabel_sep')
                            @include('sim.tabel_suratkontrol')
                        @endif
                        @include('sim.tabel_kunjungan')
                        @if ($antrian->kunjungan)
                            {{-- riwayatpasien --}}
                            @include('sim.tabel_riwayat_pasien')
                            {{-- layanan --}}
                            @include('sim.tabel_layanan')
                            {{-- laboratorium --}}
                            {{-- @if ($antrian->kunjungan->layanan)
                                @if ($antrian->kunjungan->layanan->laboratorium) --}}
                            @include('sim.tabel_lab')
                            {{-- @endif
                            @endif --}}
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
                            {{-- filepenunjang --}}
                            {{-- @include('sim.tabel_filepenunjang') --}}
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
                        @include('sim.modal_pasien')
                        @include('sim.modal_suratkontrol')
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
    {{-- tarif dan layanan --}}
    <x-adminlte-modal id="modalTarif" name="modalTarif" title="Tarif Layanan & Tindakan" theme="success"
        icon="fas fa-user-injured" size="xl">
        <form name="formInputTarif" id="formInputTarif">
            <div class="row">
                @csrf
                <input type="hidden" name="kodekunjungan" value="{{ $antrian->kodekunjungan }}">
                <input type="hidden" name="kunjungan_id" value="{{ $antrian->kunjungan_id }}">
                <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}">
                <input type="hidden" name="antrian_id" value="{{ $antrian->id }}">
                <input type="hidden" name="norm" value="{{ $antrian->norm }}">
                <input type="hidden" name="nama" value="{{ $antrian->nama }}">
                <div class="col-md-6">
                    <x-adminlte-select2 igroup-size="sm" name="layanan" class="layanan_tarif"
                        label="Layanan & Tindalan :" multiple>
                    </x-adminlte-select2>
                    <x-adminlte-input id="harga-tarif" name="harga" type="number" label="Harga" igroup-size="sm"
                        placeholder="Harga" readonly />
                    <x-adminlte-input id="jumlah-tarif" name="jumlah" type="number" label="Jumlah" igroup-size="sm"
                        placeholder="Jumlah" />
                    <x-adminlte-input id="diskon-tarif" name="diskon" type="number" label="Diskon" igroup-size="sm"
                        placeholder="Diskon" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-select igroup-size="sm" name="jaminan" label="Jaminan Pasien">
                        <option selected disabled>Pilih Jaminan</option>
                        @foreach ($jaminans as $key => $item)
                            <option value="{{ $key }}"
                                {{ $antrian->kunjungan ? ($antrian->kunjungan->jaminan == $key ? 'selected' : null) : null }}>
                                {{ $item }}</option>
                        @endforeach
                    </x-adminlte-select>

                </div>
            </div>
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto btnTambahTarif" theme="success" label="Tambah" />
            <x-adminlte-button class="mr-auto btnUpdateTarif" theme="warning" label="Update" />
            <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
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
            $('.tambahLayanan').click(function() {
                $('.btnUpdateTarif').hide();
                $('.btnTambahTarif').show();
                $("#formInputTarif").trigger('reset');
                $(".layanan_tarif").val(null).change();
                $('#modalTarif').modal('show');
            });
            $(".layanan_tarif").select2({
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                placeholder: "Tarif & Layanan",
                ajax: {
                    url: "{{ route('ref_tarif_layanan') }}?jenispasien={{ $antrian->jenispasien }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
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
            $('.layanan_tarif').on('select2:select', function(e) {
                var data = e.params.data;
                $("#jumlah-tarif").val(1);
                $("#harga-tarif").val(e.params.data.harga);
                $("#diskon-tarif").val(0);
                console.log(data);
            });
            $('.btnTambahTarif').click(function() {
                $.LoadingOverlay("show");
                $.ajax({
                    type: "POST",
                    url: "{{ route('input_tarif_pasien') }}",
                    data: $("#formInputTarif").serialize(),
                    dataType: "json",
                    encode: true,
                }).done(function(data) {
                    console.log(data);
                    if (data.metadata.code == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Tarif layanan & tindakan telah ditambahkan',
                        });
                        $("#formInputTarif").trigger('reset');
                        $(".layanan_tarif").val(null).change();
                        refresTableLayanan();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Tambah tarif layanan & tindakan error',
                        });
                    }
                    $.LoadingOverlay("hide");
                });
            });
            $('.btnUpdateTarif').click(function() {
                $.LoadingOverlay("show");
                $.ajax({
                    type: "POST",
                    url: "{{ route('input_tarif_pasien') }}",
                    data: $("#formInputTarif").serialize(),
                    dataType: "json",
                    encode: true,
                }).done(function(data) {
                    console.log(data);
                    if (data.metadata.code == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Tarif layanan & tindakan telah ditambahkan',
                        });
                        $("#formInputTarif").trigger('reset');
                        $(".layanan_tarif").val(null).change();
                        refresTableLayanan();
                        $('#modalTarif').modal('hide');
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Tambah tarif layanan & tindakan error',
                        });
                    }
                    $.LoadingOverlay("hide");
                });
            });
            $('.getLayananKunjungan').click(function() {
                refresTableLayanan();
            });
            refresTableLayanan();

            function refresTableLayanan() {
                var url = "{{ route('get_layanan_kunjungan') }}?kunjungan={{ $antrian->kunjungan_id }}";
                var table = $('#tableLayanan').DataTable();
                $.ajax({
                    type: "GET",
                    url: url,
                }).done(function(data) {
                    table.rows().remove().draw();
                    if (data.metadata.code == 200) {
                        $.each(data.response, function(key, value) {
                            console.log(value);
                            var btn =
                                '<button class="btn btn-xs btn-warning btnEditTarif" data-nama="' +
                                value.nama + '" data-tarifid="' + value.tarif_id +
                                '" data-harga="' +
                                value.harga +
                                '" data-jumlah="' +
                                value.jumlah +
                                '" data-diskon="' +
                                value.diskon +
                                '"><i class="fas fa-edit"></i> Edit</button> <button class="btn btn-xs btn-danger btnHapusTarif" data-id="' +
                                value.id +
                                '"><i class="fas fa-trash"></i> Hapus</button>';
                            table.row.add([
                                value.tgl_input,
                                btn,
                                value.nama,
                                value.jaminans.nama,
                                'Rp ' + value.harga.toLocaleString() + ' @ ' + value.jumlah,
                                value.diskon + ' %',
                                'Rp ' + (value.subtotal).toLocaleString(),
                            ]).draw(false);
                        });
                        $('.btnEditTarif').click(function() {
                            $("#formInputTarif").trigger('reset');
                            var option = new Option($(this).data('nama'), $(this).data('tarifid'));
                            option.selected = true;
                            $(".layanan_tarif").append(option);
                            $(".layanan_tarif").trigger("change");
                            // $(".layanan_tarif").val(null).change();
                            $('.btnUpdateTarif').show();
                            $('.btnTambahTarif').hide();
                            $("#jumlah-tarif").val($(this).data('jumlah'));
                            $("#harga-tarif").val($(this).data('harga'));
                            $("#diskon-tarif").val($(this).data('diskon'));
                            $('#modalTarif').modal('show');
                        });
                        $('.btnHapusTarif').click(function() {
                            $.LoadingOverlay("show");
                            $.ajax({
                                type: "POST",
                                url: "{{ route('delete_tarif_pasien') }}",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "tarif": tarif = $(this).data('id')
                                },
                                dataType: "json",
                                encode: true,
                            }).done(function(data) {
                                console.log(data);
                                if (data.metadata.code == 200) {
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Tarif layanan & tindakan telah dihapuskan',
                                    });
                                    $("#formInputTarif").trigger('reset');
                                    $(".layanan_tarif").val(null).change();
                                    refresTableLayanan();
                                } else {
                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Tarif layanan & tindakan gagal dihapuskan',
                                    });
                                }
                                $.LoadingOverlay("hide");
                            });
                            $.LoadingOverlay("hide");
                        });
                    } else {
                        Swal.fire(
                            'Mohon Maaf !',
                            data.metadata.message,
                            'error'
                        );
                    }
                });
            }
        });
    </script>
    @include('sim.tabel_fileupload')
@endsection
