@extends('adminlte::page')
@section('title', 'Surat Kontrol & SPRI - Vclaim BPJS')
@section('content_header')
    <h1>Surat Kontrol & SPRI - Vclaim BPJS </h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Filter Surat Kontrol & SPRI" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-6">
                            @php
                                $config = [
                                    'locale' => ['format' => 'YYYY/MM/DD'],
                                ];
                            @endphp
                            <x-adminlte-date-range name="tanggal" label="Periode Tanggal Antrian"
                                enable-default-ranges="Today" :config="$config">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-date-range>
                        </div>
                        <div class="col-6">
                            <x-adminlte-select2 name="formatFilter" label="Format Filter">
                                <option value="1" {{ $request->jenispelayanan == 1 ? 'selected' : null }}>Tanggal Entri
                                </option>
                                <option value="2" {{ $request->jenispelayanan == 2 ? 'selected' : null }}>Tanggal
                                    Kontrol
                                </option>
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" class="withLoad" theme="primary"
                                        label="Cari Surat Kontrol" />
                                </x-slot>
                            </x-adminlte-select2>
                        </div>
                    </div>
                </form>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-4">
                            @php
                                $config = ['format' => 'YYYY-MM'];
                            @endphp
                            <x-adminlte-input-date name="bulan" label="Tanggal Antrian" :config="$config"
                                value="{{ $request->bulan }}" placeholder="Pilih Bulan">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                        <div class="col-4">
                            <x-adminlte-input name="nomorkartu" label="Nomor Kartu" value="{{ $request->nomorkartu }}"
                                placeholder="Pencarian Berdasarkan Nomor Kartu BPJS">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                        <div class="col-4">
                            <x-adminlte-select2 name="formatfilter" label="Format Filter">
                                <option value="1" {{ $request->jenispelayanan == 1 ? 'selected' : null }}>Tanggal Entri
                                </option>
                                <option value="2" {{ $request->jenispelayanan == 2 ? 'selected' : null }}>Tanggal
                                    Kontrol
                                </option>
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" class="withLoad" theme="primary"
                                        label="Cari Surat Kontrol" />
                                </x-slot>
                            </x-adminlte-select2>
                        </div>
                    </div>

                </form>
                <button class="btn btn-success" data-toggle="modal" data-target="#modalSuratKontrol">Buat Surat
                    Kontrol</button>
                <button class="btn btn-success">Buat SPRI</button>
            </x-adminlte-card>
        </div>
        <div class="col-12">
            <x-adminlte-card title="Data Surat Kontrol & SPRI" theme="secondary" collapsible>
                @php
                    $heads = ['Tgl Entry', 'Tgl Kontrol', 'No Surat Kontrol', 'No SEP', 'Jns Pelayanan', 'Poliklinik', 'Dokter', 'Pasien', 'Terbit SEP'];
                @endphp
                <x-adminlte-datatable id="table2" class="nowrap text-xs" :heads="$heads" bordered hoverable compressed>
                    @isset($suratkontrol)
                        @foreach ($suratkontrol as $item)
                            <tr>
                                <td>{{ $item->tglTerbitKontrol }}</td>
                                <td>{{ $item->tglRencanaKontrol }}</td>
                                <td>
                                    {{ $item->noSuratKontrol }}
                                </td>
                                <td>
                                    {{ $item->noSepAsalKontrol }}
                                    <br>
                                    {{ $item->tglSEP }}
                                </td>
                                <td>
                                    {{ $item->namaJnsKontrol }}
                                    <br>
                                    {{ $item->jnsPelayanan }}
                                </td>
                                <td>
                                    Tujuan : {{ $item->namaPoliTujuan }}
                                    <br>
                                    Asal : {{ $item->namaPoliAsal }}
                                </td>
                                <td>
                                    {{ $item->namaDokter }}
                                    <br>
                                    {{ $item->kodeDokter }}
                                </td>
                                <td>
                                    {{ $item->nama }}
                                    <br>
                                    {{ $item->noKartu }}
                                </td>
                                <td>{{ $item->terbitSEP }}</td>
                            </tr>
                        @endforeach
                    @endisset
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <x-adminlte-modal id="modalSuratKontrol" title="Buat Surat Kontrol" theme="success" size="lg"
        icon="fas fa-file-medical">
        <form action="{{ route('suratkontrol.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kodebooking" class="kodebooking-id">
            Surat Kontrol Pasien
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="nomorkartu" class="nomorkartu-id" igroup-size="sm" label="Nomor Kartu"
                        placeholder="Nomor Kartu" />
                    <x-adminlte-input name="norm" class="norm-id" label="No RM" igroup-size="sm" placeholder="No RM " />
                    <x-adminlte-input name="nama" class="nama-id" label="Nama Pasien" igroup-size="sm"
                        placeholder="Nama Pasien" />
                    <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP" igroup-size="sm"
                        placeholder="Nomor HP" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="noSEP" class="noSEP-id" igroup-size="sm" label="Nomor SEP"
                        placeholder="Nomor SEP">
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary btnCariSEP">
                                <i class="fas fa-search"></i> Cari SEP
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    @php
                        $config = ['format' => 'YYYY-MM-DD'];
                    @endphp
                    <x-adminlte-input-date name="tglRencanaKontrol" igroup-size="sm" label="Tanggal Rencana Kontrol"
                        value="{{ $request->tglRencanaKontrol }}" placeholder="Pilih Tanggal Rencana Kontrol"
                        :config="$config">
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary btnCariPoli">
                                <i class="fas fa-search"></i> Cari Poli
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                    <x-adminlte-select igroup-size="sm" name="poliKontrol" label="Poliklinik">
                        <option selected disabled>Silahkan Klik Cari Poliklinik</option>
                        <x-slot name="appendSlot">
                            <div class="btn btn-primary btnCariDokter">
                                <i class="fas fa-search"></i> Cari Dokter
                            </div>
                        </x-slot>
                    </x-adminlte-select>
                    <x-adminlte-select igroup-size="sm" name="kodeDokter" label="Dokter">
                        <option selected disabled>Silahkan Klik Cari Dokter</option>
                    </x-adminlte-select>
                    <x-adminlte-textarea igroup-size="sm" label="Catatan" name="catatan" placeholder="Catatan Pasien" />
                </div>
            </div>
            <button type="submit" class="btn btn-warning withLoad"> <i class="fas fa-save"></i>
                Buat
                Surat Kontrol</button>
        </form>
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
@stop
@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.DateRangePicker', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)

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
            })
            $('.btnAntrian').click(function() {
                $.LoadingOverlay("show");
                var kodebooking = $(this).data("kodebooking");
                var taskid = $(this).data("taskid");
                var namapasien = $(this).data("namapasien");
                var norm = $(this).data("norm");
                var nomorkartu = $(this).data("nomorkartu");
                var nik = $(this).data("nik");
                var nohp = $(this).data("nohp");
                var nomorantrean = $(this).data("nomorantrean");
                var jeniskunjungan = $(this).data("jeniskunjungan");
                var sep = $(this).data("sep");
                var namapoli = $(this).data("namapoli");
                var namadokter = $(this).data("namadokter");
                $(".namapasien").html(namapasien);
                $(".nama-id").val(namapasien);
                $(".norm").html(norm);
                $(".norm-id").val(norm);
                $(".nomorkartu").html(nomorkartu);
                $(".nomorkartu-id").val(nomorkartu);
                $(".nik").html(nik);
                $(".nik-id").val(nik);
                $(".nohp").html(nohp);
                $(".nohp-id").val(nohp);
                $(".kodebooking").html(kodebooking);
                $(".kodebooking-id").val(kodebooking);
                $(".nomorantrean").html(nomorantrean);
                $(".jeniskunjungan").html(jeniskunjungan);
                $(".sep").html(sep);
                $(".namapoli").html(namapoli);
                $(".namadokter").html(namadokter);
                var url = "{{ route('layanipendaftaran') }}?kodebooking=" + kodebooking;
                if (taskid == 1) {
                    $.get(url, function(data, status) {
                        console.log(data);
                    });
                }
                var urllanjut = "{{ route('lanjutpoliklinik') }}?kodebooking=" + kodebooking;
                $("#btnLanjutPoli").attr("href", urllanjut);
                var urlbatal = "{{ route('batalantrian') }}?kodebooking=" + kodebooking +
                    "&keterangan=dibatalkan_dipendaftarn";
                $("#btnBatal").attr("href", urlbatal);
                $('#modalAntrian').modal('show');
                $.LoadingOverlay("hide");
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
                                table.row.add([
                                    value.tglSep,
                                    value.tglPlgSep,
                                    value.noSep,
                                    jenispelayanan,
                                    value.poli,
                                    value.diagnosa,
                                    "<button class='btnPilihSEP btn btn-success btn-xs' data-id=" +
                                    value.noSep +
                                    ">Pilih</button>",
                                ]).draw(false);

                            });
                            $('.btnPilihSEP').click(function() {
                                var nomorsep = $(this).data('id');
                                $.LoadingOverlay("show");
                                $('#noSEP').val(nomorsep);
                                $('#modalSEP').modal('hide');
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
            $('.btnCariPoli').click(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                var sep = $('#noSEP').val();
                var tanggal = $('#tglRencanaKontrol').val();
                var url = "{{ route('suratkontrol_poli') }}?nomor=" + sep + "&tglRencanaKontrol=" +
                    tanggal;
                // alert(url);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $('#poliKontrol').empty()
                            $.each(data.response.list, function(key, value) {
                                optText = value.namaPoli + " (" + value.persentase +
                                    "%)";
                                optValue = value.kodePoli;
                                $('#poliKontrol').append(new Option(optText, optValue));
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
            $('.btnCariDokter').click(function(e) {
                e.preventDefault();
                $.LoadingOverlay("show");
                var poli = $('#poliKontrol').find(":selected").val();
                var tanggal = $('#tglRencanaKontrol').val();
                var url = "{{ route('suratkontrol_dokter') }}?kodePoli=" + poli + "&tglRencanaKontrol=" +
                    tanggal;
                // alert(url);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.metadata.code == 200) {
                            $('#kodeDokter').empty()
                            $.each(data.response.list, function(key, value) {
                                optText = value.namaDokter + " (" + value
                                    .jadwalPraktek +
                                    ")";
                                optValue = value.kodeDokter;
                                $('#kodeDokter').append(new Option(optText, optValue));
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
        });
    </script>

@endsection
