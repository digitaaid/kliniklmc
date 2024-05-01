@extends('adminlte::page')
@section('title', 'SEP Rawat Jalan')
@section('content_header')
    <h1>SEP Rawat Jalan</h1>
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
            <x-adminlte-card theme="primary" theme-mode="outline">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="jenispelayanan" value="2">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date fgroup-class="row" label-class="text-left col-3" igroup-class="col-9"
                                igroup-size="sm" name="tanggal" label="Tanggal" :config="$config"
                                value="{{ \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d') ?? now()->format('Y-m-d') }}">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Cari!" />
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-button theme="success" icon="fas fa-file-medical" class="btn-sm" label="Buat SEP"
                                onclick="buatSEP()" />

                        </div>
                    </div>
                </form>
                @php
                    $heads = [
                        'No',
                        'Nama',
                        'No SEP',
                        'Action',
                        'Tgl Masuk',
                        'Tgl Pulang',
                        'Nomor Rujukan',
                        'Jenis Pelayanan',
                        'Nomor BPJS',
                        'Poliklik',
                        'Diagnosa',
                    ];
                    $config['order'] = [['0', 'asc']];
                    $config['scrollX'] = true;
                @endphp
                <x-adminlte-datatable id="table2" class="nowrap text-xs" :heads="$heads" :config="$config" bordered
                    hoverable compressed>
                    @isset($sep)
                        @foreach ($sep as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->noSep }}</td>
                                <td>
                                    <a class="btn btn-xs btn-success" target="_blank"
                                        href="{{ route('sep_print') }}?noSep={{ $item->noSep }}" style="text-decoration: none">
                                        <i class="fas fa-print"></i> Print SEP
                                    </a>
                                </td>
                                <td>{{ $item->tglSep }}</td>
                                <td>{{ $item->tglPlgSep }}</td>
                                <td>{{ $item->noRujukan }}</td>
                                <td>{{ $item->jnsPelayanan }}</td>
                                <td>{{ $item->noKartu }}</td>
                                <td>{{ $item->poli }}</td>
                                <td>{{ $item->diagnosa }}</td>
                            </tr>
                        @endforeach
                    @endisset
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalBuatSEP" title="Buat SEP Rawat Jalan" theme="success" size="xl"
        icon="fas fa-file-medical">
        <form action="{{ route('sep.store') }}" id="formSEP" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                        name="nomorkartu" label="No BPJS" placeholder="No BPJS" required enable-old-support>
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="primary" label="Cek" icon="fas fa-search"
                                onclick="cariPeserta()" />
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                        name="norm" label="No RM" placeholder="No RM" readonly required enable-old-support />
                    <x-adminlte-input fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                        name="nik" label="NIK" placeholder="NIK" readonly required enable-old-support />
                    <x-adminlte-input fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                        name="nama" label="Nama" placeholder="Nama Pasien" readonly required enable-old-support />
                    <x-adminlte-input fgroup-class="row" label-class="text-left col-4" igroup-class="col-8" igroup-size="sm"
                        name="nohp" label="No HP" placeholder="No HP" readonly required enable-old-support />
                    <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                        igroup-size="sm" name="asalRujukan" label="Jenis Rujukan" enable-old-support>
                        <option value="1">Rujukan FKTP</option>
                        <option value="2">Rujukan Antar RS</option>
                    </x-adminlte-select>
                    <x-adminlte-input name="noRujukan" class="noRujukan-id" fgroup-class="row" label-class="text-left col-4"
                        igroup-class="col-8" igroup-size="sm" label="Nomor Rujukan" placeholder="No Rujukan" readonly
                        enable-old-support>
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="primary" label="Cari" icon="fas fa-search"
                                onclick="cariRujukan()" />
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
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                </div>
                <div class="col-md-6">
                    <x-adminlte-input-date fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                        igroup-size="sm" name="tglSep" label="Tanggal SEP" :config="$config" required enable-old-support
                        value="{{ now()->format('Y-m-d') }}" />
                    <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                        igroup-size="sm" name="jnsPelayanan" label="Pelayanan" required enable-old-support>
                        <option disabled>Pilih Jenis Pelayanan</option>
                        <option value="2">Rawat Jalan</option>
                    </x-adminlte-select>
                    <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                        igroup-size="sm" name="klsRawatHak" label="Kelas" required enable-old-support>
                        <option value="3">Kelas 3</option>
                        <option value="1">Kelas 1</option>
                        <option value="2">Kelas 2</option>
                    </x-adminlte-select>
                    <x-adminlte-select2 fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                        igroup-size="sm" name="tujuan" label="Poliklinik" required enable-old-support>
                    </x-adminlte-select2>
                    <x-adminlte-select2 fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                        igroup-size="sm" name="dpjpLayan" label="Dokter DPJP" required enable-old-support>
                    </x-adminlte-select2>
                    <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                        igroup-size="sm" name="tujuanKunj" label="Tujuan Kunjg" required enable-old-support>
                        <option value="0">Normal</option>
                        <option value="1">Prosedur</option>
                        <option value="2">Konsul Dokter</option>
                    </x-adminlte-select>
                    <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                        igroup-size="sm" name="flagProcedure" label="Flag Procedur" enable-old-support>
                        <option value="">Normal</option>
                        <option value="0">Prosedur Tidak Berkelanjutan</option>
                        <option value="1">Prosedur dan Terapi Berkelanjutan</option>
                    </x-adminlte-select>
                    <x-adminlte-select fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                        igroup-size="sm" name="kdPenunjang" label="Penunjang" enable-old-support>
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
                        igroup-size="sm" name="assesmentPel" label="Asesmen Pelynan" enable-old-support>
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
                    <x-adminlte-select2 fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                        igroup-size="sm" name="diagAwal" label="Diagnosa Awal" required enable-old-support>
                    </x-adminlte-select2>
                    <x-adminlte-textarea fgroup-class="row" label-class="text-left col-4" igroup-class="col-8"
                        igroup-size="sm" label="Catatan / Keluhan" name="catatan" placeholder="Catatan Pasien" required
                        enable-old-support />

                </div>
            </div>
            {{-- <input type="hidden" name="kodebooking" value="{{ $antrian->kodebooking }}"> --}}
            {{-- <input type="hidden" name="antrian_id" value="{{ $antrian->id }}"> --}}

        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto withLoad" theme="success" label="Buat SEP" form="formSEP"
                type="submit" />
            <x-adminlte-button theme="danger" label="Tutup" icon="fas fa-times" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
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
@stop
@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('js')
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#tujuan").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_poliklinik_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            poliklinik: params.term // search term
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
            $("#dpjpLayan").select2({
                theme: "bootstrap4",
                ajax: {
                    url: "{{ route('ref_dpjp_api') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            jenispelayanan: $("#jnsPelayanan option:selected").val(),
                            kodespesialis: $("#tujuan option:selected").val(),
                            tanggal: $("#tglSep").val(),
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
            $("#diagAwal").select2({
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
        });
    </script>
    <script>
        function buatSEP() {
            $('#modalBuatSEP').modal('show');
        }

        function cariPeserta() {
            $.LoadingOverlay("show");
            var nomorkartu = $("#nomorkartu").val();
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
                        $("#nama").val(pasien.nama);
                        $("#norm").val(pasien.mr.noMR);
                        $("#nik").val(pasien.nik);
                        $("#nomorkartu").val(pasien.noKartu);
                        $("#nohp").val(pasien.mr.noTelepon);
                        if (pasien.mr.noMR == null) {
                            Swal.fire(
                                'Mohon Maaf !',
                                "Pasien baru belum memiliki no RM",
                                'error'
                            )
                        }
                        console.log(pasien);
                    } else {
                        Swal.fire(
                            'Mohon Maaf !',
                            data.metadata.message,
                            'error'
                        )
                    }
                } else {
                    console.log(data);
                    Swal.fire(
                        'Mohon Maaf !',
                        data.metadata.message,
                        'error'
                    )
                }
            });
            $.LoadingOverlay("hide");
        }

        function cariRujukan() {
            $.LoadingOverlay("show");
            var asalRujukan = $("#asalRujukan").find(":selected").val();
            var nomorkartu = $("#nomorkartu").val();
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
                            $('.noRujukan-id').val($(this).data('id'));
                            $('#klsRawatHak').val($(this).data('kelas')).change();
                            $('#tglrujukan').val($(this).data('tglrujukan'));
                            $('#ppkrujukan').val($(this).data('ppkrujukan'));
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

        function cariSuratKontrol() {
            $.LoadingOverlay("show");
            var nomorkartu = $("#nomorkartu").val();
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

@endsection
