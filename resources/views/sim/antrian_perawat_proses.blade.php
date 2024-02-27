@extends('adminlte::page')
@section('title', 'Antrian Perawat')
@section('content_header')
    <h1>Antrian Perawat</h1>
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
            <a href="{{ route('antrianperawat') }}?tanggalperiksa={{ $antrian->tanggalperiksa }}"
                class="btn btn-xs btn-danger mb-2 mr-1 withLoad">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div class="btn btn-xs btn-{{ $antrian->asesmenperawat ? 'success' : 'secondary' }} mb-2 mr-1">
                <i class="fas fa-info-circle"></i>
                Status Antrian :
                @switch($antrian->taskid)
                    @case(0)
                        Belum Checkin
                    @break

                    @case(1)
                        Tunggu Pendaftaran
                    @break

                    @case(2)
                        Proses Pendaftaran
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
                    <x-adminlte-button class="btn-xs mb-1" theme="warning" label="I-Care JKN" icon="fas fa-info-circle"
                        onclick="btnIcare()" />
                    <x-adminlte-button class="btn-xs mb-1 btnFileUplpad" theme="warning" label="Berkas Upload"
                        icon="fas fa-file-medical" />
                    <x-adminlte-button class="btn-xs mb-1" theme="warning" label="CPPT" icon="fas fa-file-medical"
                        onclick="btnCPPT()" />
                    <x-adminlte-button class="btn-xs mb-1" theme="{{ $antrian->asesmenperawat ? 'warning' : 'danger' }}"
                        label="Asesmen Keperawatan" icon="fas fa-hand-holding-medical" onclick="btnPengkajianPerawat()" />
                    <x-adminlte-button class="btn-xs mb-1" theme="{{ $antrian->sbar ? 'warning' : 'danger' }}"
                        label="SBAR TBAK" icon="fas fa-envelope" onclick="btnSBAR()" />
                    <x-adminlte-button class="btn-xs mb-1" theme="{{ $antrian->asesmendokter ? 'warning' : 'danger' }}"
                        label="Asesmen Dokter" icon="fas fa-user-md" onclick="btnPemeriksaanDokter()" />
                    <x-adminlte-button class="btn-xs mb-1"
                        theme="{{ $antrian->asesmendokter && $antrian->asesmendokter ? 'warning' : 'danger' }}"
                        label="Asesmen Rajal" icon="fas fa-file-medical" onclick="btnAsesmenRajal()" />
                    <x-adminlte-button class="btn-xs mb-1"
                        theme="{{ $antrian->asesmendokter && $antrian->asesmendokter ? 'warning' : 'danger' }}"
                        label="Resume" icon="fas fa-file-medical" onclick="btnResumeRajal()" />
                </x-slot>
            </x-adminlte-card>
        </div>
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile p-3" style="overflow-y: auto ;max-height: 600px ;">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        {{-- riwayatpasien --}}
                        <style>
                            pre {
                                padding: 0 !important;
                                margin-bottom: 0 !important;
                                font-size: 11px !important;
                                border: none;
                                outline: none;
                            }
                        </style>
                        @include('sim.tabel_riwayat_pasien')
                        {{-- layanan --}}
                        @include('sim.tabel_layanan')
                        {{-- perawat --}}
                        {{-- @include('sim.tabel_anamnesa_perawat') --}}
                        {{-- laboratorium --}}
                        @include('sim.tabel_lab')
                        {{-- resume --}}
                        <div class="card card-info mb-1">
                            <div class="card-header" role="tab" id="headRad">
                                <h3 class="card-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collResume"
                                        aria-expanded="true" aria-controls="collResume">
                                        Preview Resume
                                    </a>
                                </h3>
                            </div>
                            <div id="collResume" class="collapse" role="tabpanel" aria-labelledby="headRad">
                                <div class="card-body">
                                    @if ($kunjungan)
                                        @if ($kunjungan->asesmendokter)
                                            <div id="printMe">
                                                @include('form.asesmen_dokter_rajal')
                                            </div>
                                        @else
                                            <x-adminlte-alert title="Belum dilakukan asesmen dokter" theme="danger">
                                                Silahkan lakukan asesmen dokter
                                            </x-adminlte-alert>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('antrianperawat') }}?tanggalperiksa={{ $antrian->tanggalperiksa }}"
                        class="btn btn-success mb-2 mr-1 withLoad">
                        <i class="fas fa-arrow-left"></i> Selesai & Kembali
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
            $(".diagnosaid1").select2({
                theme: "bootstrap4",
                multiple: true,
                placeholder: "Diagnosa Primer ICD-10",
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('ref_diagnosa_api') }}",
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
            $(".cariObat").select2({
                placeholder: 'Pencarian Nama Obat',
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('ref_obat_cari') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            nama: params.term // search term
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
                placeholder: "Diagnosa Sekunder ICD-10",
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_diagnosa_api') }}",
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
            $(".diagnosa").select2({
                theme: "bootstrap4",
                placeholder: "Diagnosa Klinik",
                ajax: {
                    url: "{{ route('diagnosa.search') }}",
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
        });
    </script>
    {{-- dynamic input --}}
    <script>
        $("#addObatInput").click(function() {
            newRowAdd =
                '<div id="row" class="row"><div class="form-group"><div class="input-group input-group-sm">' +
                '<select name="obat[]" class="form-control cariObat"></select>' +
                '<input type="number" name="jumlah[]" placeholder="Jumlah" class="form-control" multiple>' +
                '<select name="frekuensi[]"class="form-control frekuensilObat"> <option selected disabled>Interval</option>' +
                '<option value="qod">1 x 1</option>' +
                '<option value="dod">1 x 2</option>' +
                '<option value="bid">2 x 1</option>' +
                '<option value="tid">3 x 1</option>' +
                '<option value="qid">4 x 1</option>' +
                '<option value="202">2-0-2</option>' +
                '<option value="303">3-0-3</option>' +
                '</select> ' +
                '<select name="waktuobat[]" class="form-control waktuObat"><option selected>Waktu Obat</option>' +
                '<option value="pc">Setelah Makan</option>' +
                '<option value="ac">Sebelum Makan</option>' +
                '<option value="hs">Sebelum Tidur</option>' +
                '<option value="int">Diantara Waktu Makan</option>' +
                '</select> ' +
                '<input type="text" name="keterangan_obat[]" placeholder="Keterangan Obat" class="form-control" multiple>' +
                '<button type="button" class="btn btn-xs btn-danger" id="deleteRowObat"><i class="fas fa-trash "></i> </div></div></div>';
            $('#newObat').append(newRowAdd);
            $(".cariObat").select2({
                placeholder: 'Pencarian Nama Obat',
                theme: "bootstrap4",
                multiple: true,
                maximumSelectionLength: 1,
                ajax: {
                    url: "{{ route('ref_obat_cari') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 100,
                    data: function(params) {
                        return {
                            nama: params.term // search term
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
        $("body").on("click", "#deleteRowObat", function() {
            $(this).parents("#row").remove();
        })
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
    {{-- icare --}}
    <x-adminlte-modal id="modalICare" name="modalICare" title="I-Care JKN" theme="warning" icon="fas fa-file-medical"
        size="xl">
        <iframe src="" id="urlIcare" width="100%" height="700px" frameborder="0"></iframe>
    </x-adminlte-modal>
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
    {{-- file upload --}}
    @include('sim.tabel_fileupload')
    @include('sim.modal_cppt')
    @include('sim.modal_sbar_tbak_create')
    @include('sim.modal_asesmen_perawat')
    @include('sim.modal_asesmen_dokter')
    @include('sim.modal_asesmen_rajal')
    @include('sim.modal_resume_rajal')
    <script>
        function btnIcare() {
            $.LoadingOverlay("show");
            var url =
                "{{ route('icare') }}?nomorkartu={{ $antrian->nomorkartu }}&kodedokter={{ $antrian->kodedokter }}";
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    if (data.metadata.code == 200) {
                        $('#urlIcare').attr('src', data.response.url);
                        $('#modalICare').modal('show');
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

        function btnCPPT() {
            $.LoadingOverlay("show");
            $('#modalCPPT').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnSBAR() {
            $.LoadingOverlay("show");
            $('#modalSBAR').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnPengkajianPerawat() {
            $.LoadingOverlay("show");
            $('#modalAsesmenPerawat').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnPemeriksaanDokter() {
            $.LoadingOverlay("show");
            $('#modalAsesmenDokter').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnResumeRajal() {
            $.LoadingOverlay("show");
            $('#modalResumeRajal').modal('show');
            $.LoadingOverlay("hide");
        }

        function btnAsesmenRajal() {
            $.LoadingOverlay("show");
            $('#modalAsesmenRajal').modal('show');
            $.LoadingOverlay("hide");
        }
    </script>
@endsection
