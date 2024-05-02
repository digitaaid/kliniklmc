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
                            <span class="badge bg-success float-right">{{ $pasiencount }} Pasien</span>
                        </a>
                    </li>
                    <li class="nav-item" onclick="modalAntrian()">
                        <a href="#nav" class="nav-link">
                            <i class="fas fa-user-plus"></i> Antrian
                            @if ($antrian->norm)
                                <span class="badge bg-success float-right">Sudah Didaftarkan</span>
                            @else
                                <span class="badge bg-danger float-right">Belum Didaftarkan</span>
                            @endif
                        </a>
                    </li>
                    @if ($antrian->norm)
                        <li class="nav-item" onclick="modalKunjungan()">
                            <a href="#nav" class="nav-link">
                                <i class="fas fa-user-plus"></i> Kunjungan
                                @if ($antrian->kunjungan)
                                    <span class="badge bg-success float-right">Sudah Didaftarkan</span>
                                @else
                                    <span class="badge bg-danger float-right">Belum Kunjungan</span>
                                @endif
                            </a>
                        </li>
                    @endif
                    @if ($antrian->kunjungan)
                        <li class="nav-item" onclick="modalCPPT()">
                            <a href="#nav" class="nav-link">
                                <i class="fas fa-file-medical"></i> CPPT
                                <span class="badge bg-success float-right">
                                    {{ $antrian->pasien ? $antrian->pasien->kunjungans->count() : 0 }} Kunjungan
                                </span>
                            </a>
                        </li>
                        <li class="nav-item" onclick="tambahLayanan()">
                            <a href="#nav" class="nav-link">
                                <i class="fas fa-hand-holding-medical"></i> Layanan & Tindakan
                                <span class="badge bg-success float-right">
                                    {{ $antrian->layanans->count() }} Layanan
                                </span>
                            </a>
                        </li>
                        <li class="nav-item" onclick="modalPasien()">
                            <a href="#nav" class="nav-link">
                                <i class="fas fa-vials"></i> Laboratorium
                            </a>
                        </li>
                        <li class="nav-item" onclick="modalPasien()">
                            <a href="#nav" class="nav-link">
                                <i class="fas fa-file-invoice-dollar"></i> Kasir & Keuangan
                            </a>
                        </li>
                    @endif
                    @if ($antrian->norm)
                        <li class="nav-item" onclick="btnFileUplpad()">
                            <a href="#nav" class="nav-link">
                                <i class="fas fa-file-medical"></i> Berkas Upload
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
                    @endif

                </ul>
            </x-adminlte-card>
        </div>
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile p-3" style="overflow-y: auto ;max-height: 600px ;">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        @include('sim.modal_antrian')
                        @if ($antrian->jenispasien == 'JKN')
                            @include('sim.tabel_sep')
                            @include('sim.tabel_suratkontrol')
                        @endif
                        @if ($antrian->norm)
                            @include('sim.modal_kunjungan')
                        @endif
                        @if ($antrian->kunjungan)
                            @include('sim.modal_cppt')
                            @include('sim.modal_layanan')
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
                        @include('sim.modal_fileupload')
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
    {{-- toast --}}
    <script>
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
    </script>
    <script>
        $(function() {
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
@endsection
