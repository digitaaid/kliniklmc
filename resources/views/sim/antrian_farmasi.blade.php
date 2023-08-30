@extends('adminlte::page')
@section('title', 'Antrian Farmasi')
@section('content_header')
    <h1>Antrian Farmasi</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Filter Data Antrian" theme="secondary" collapsible>
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $config = ['format' => 'YYYY-MM-DD'];
                            @endphp
                            <x-adminlte-input-date name="tanggalperiksa" label="Tanggal Laporan"
                                value="{{ $request->tanggalperiksa }}" placeholder="Pilih Tanggal" :config="$config">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-primary">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input-date>
                        </div>
                    </div>
                    <x-adminlte-button type="submit" class="withLoad" theme="primary" label="Submit Antrian" />
                </form>
            </x-adminlte-card>
        </div>
        @if (isset($antrians))
            <div class="col-md-12">
                <x-adminlte-card title="Data Antrian Sedang Dilayani" theme="success" icon="fas fa-info-circle" collapsible>
                    @php
                        $heads = ['No Antrian', 'kodebooking', 'Pasien', 'Dokter', 'Poliklinik', 'Jenis Pasien', 'Status', 'Action'];
                    @endphp
                    <x-adminlte-datatable id="table2" class="nowrap" :heads="$heads" bordered hoverable compressed>
                        @foreach ($antrians->where('taskid', 6) as $item)
                            <tr>
                                <td>{{ $item->nomorantrean }} / {{ $item->angkaantrean }}</td>
                                <td>{{ $item->kodebooking }}</td>
                                <td>{{ $item->norm }} {{ $item->nama }}</td>
                                <td>{{ $item->namadokter }}</td>
                                <td>{{ $item->namapoli }}</td>
                                <td>{{ $item->pasienbaru }} {{ $item->jenispasien }} </td>
                                <td>{{ $item->taskid }}</td>
                                <td>
                                    <button class="btn btn-xs btn-success btnAntrian"
                                        data-kodebooking="{{ $item->kodebooking }}" data-taskid="{{ $item->taskid }}"
                                        data-namapasien="{{ $item->nama }}" data-norm="{{ $item->norm }}"
                                        data-nomorkartu="{{ $item->nomorkartu }}" data-nik="{{ $item->nik }}"
                                        data-nohp="{{ $item->nohp }}" data-kodebooking="{{ $item->kodebooking }}"
                                        data-nomorantrean="{{ $item->nomorantrean }}"
                                        data-jeniskunjungan="{{ $item->jeniskunjungan }}" data-sep="{{ $item->sep }}"
                                        data-namapoli="{{ $item->namapoli }}" data-namadokter="{{ $item->namadokter }}">
                                        Layani
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
                <x-adminlte-card title="Data Antrian" theme="primary" icon="fas fa-info-circle" collapsible>
                    @php
                        $heads = ['No Antrian', 'kodebooking', 'Pasien', 'Dokter', 'Poliklinik', 'Jenis Pasien', 'Status', 'Action'];
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" bordered hoverable compressed>
                        @foreach ($antrians->where('taskid', '!=', 4) as $item)
                            <tr>
                                <td>{{ $item->nomorantrean }} / {{ $item->angkaantrean }}</td>
                                <td>{{ $item->kodebooking }}</td>
                                <td>{{ $item->norm }} {{ $item->nama }}</td>
                                <td>{{ $item->namadokter }}</td>
                                <td>{{ $item->namapoli }}</td>
                                <td>{{ $item->pasienbaru }} {{ $item->jenispasien }} </td>
                                <td>{{ $item->taskid }}</td>
                                <td>
                                    @if ($item->taskid == 5)
                                        <a href="{{ route('terimafarmasi') }}?kodebooking={{ $item->kodebooking }}"
                                            class="btn btn-xs btn-warning">Terima Resep</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
            </div>
        @endif
    </div>
    <x-adminlte-modal id="modalAntrian" title="Antrian Pasien" icon="fas fa-user" size="xl" theme="success" scrollable>
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <h3 class="profile-username text-center">
                            <span class="namapasien"></span>
                        </h3>
                        <p class="text-muted text-center">
                            <span class="norm"></span>
                            JKN
                        </p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <dl>
                                    <dt>Nomor Kartu</dt>
                                    <dd><span class="nomorkartu"></span></dd>
                                    <dt>NIK</dt>
                                    <dd><span class="nik"></span></dd>
                                    <dt>No HP</dt>
                                    <dd><span class="nohp"></span></dd>
                                </dl>
                            </li>
                            <li class="list-group-item">
                                <dl>
                                    <dt>Nomor / Angka Antrian</dt>
                                    <dd><span class="nomorantrean"></span> <span class="angkaantrean"></span></dd>
                                    <dt>Kodebooking</dt>
                                    <dd><span class="kodebooking"></span></dd>
                                </dl>
                            </li>
                            <li class="list-group-item">
                                <dl>
                                    <dt>Jenis Kunjungan</dt>
                                    <dd><span class="jeniskunjungan"></span></dd>
                                    <dt>SEP</dt>
                                    <dd><span class="sep"></span></dd>
                                </dl>
                            </li>
                            <li class="list-group-item">
                                <dl>
                                    <dt>Poliklinik</dt>
                                    <dd><span class="namapoli"></span></dd>
                                    <dt>Dokter</dt>
                                    <dd><span class="namadokter"></span></dd>
                                </dl>
                            </li>

                        </ul>

                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity"
                                    data-toggle="tab">Keperawatan</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#dokter" data-toggle="tab">Dokter</a></li>
                            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Riwayat</a></li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Indentitas</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#suratkontroltab" data-toggle="tab">Surat
                                    Kontrol</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#farmasitab" data-toggle="tab">Farmasi</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                Pemeriksaan Keperawatan
                            </div>
                            <div class="tab-pane" id="dokter">
                                Pemeriksaan Dokter
                            </div>
                            <div class="tab-pane" id="timeline">
                                Riwayat Pasien
                            </div>
                            <div class="tab-pane" id="settings">
                                Identitas Pasien
                                <form action="{{ route('editantrian') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="kodebooking" class="kodebooking-id">
                                    <x-adminlte-input name="nomorkartu" class="nomorkartu-id" igroup-size="sm"
                                        label="Nomor Kartu" placeholder="Nomor Kartu">
                                        <x-slot name="appendSlot">
                                            <div class="btn btn-primary btnCariKartu">
                                                <i class="fas fa-search"></i> Cari
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                    <x-adminlte-input name="nik" class="nik-id" igroup-size="sm" label="NIK"
                                        placeholder="NIK ">
                                        <x-slot name="appendSlot">
                                            <div class="btn btn-primary btnCariNIK">
                                                <i class="fas fa-search"></i> Cari
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input>
                                    <x-adminlte-input name="norm" class="norm-id" label="No RM" igroup-size="sm"
                                        placeholder="No RM " />
                                    <x-adminlte-input name="nama" class="nama-id" label="Nama Pasien"
                                        igroup-size="sm" placeholder="Nama Pasien" />
                                    <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP" igroup-size="sm"
                                        placeholder="Nomor HP" />
                                    <button type="submit" class="btn btn-warning"> <i class="fas fa-edit"></i> Update
                                        Identitas</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="suratkontroltab">
                                <form action="{{ route('suratkontrol.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="kodebooking" class="kodebooking-id">
                                    Surat Kontrol Pasien
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-adminlte-input name="nomorkartu" class="nomorkartu-id" igroup-size="sm"
                                                label="Nomor Kartu" placeholder="Nomor Kartu" />
                                            <x-adminlte-input name="norm" class="norm-id" label="No RM"
                                                igroup-size="sm" placeholder="No RM " />
                                            <x-adminlte-input name="nama" class="nama-id" label="Nama Pasien"
                                                igroup-size="sm" placeholder="Nama Pasien" />
                                            <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP"
                                                igroup-size="sm" placeholder="Nomor HP" />
                                        </div>
                                        <div class="col-md-6">
                                            <x-adminlte-input name="noSEP" class="noSEP-id" igroup-size="sm"
                                                label="Nomor SEP" placeholder="Nomor SEP">
                                                <x-slot name="appendSlot">
                                                    <div class="btn btn-primary btnCariSEP">
                                                        <i class="fas fa-search"></i> Cari SEP
                                                    </div>
                                                </x-slot>
                                            </x-adminlte-input>
                                            @php
                                                $config = ['format' => 'YYYY-MM-DD'];
                                            @endphp
                                            <x-adminlte-input-date name="tglRencanaKontrol" igroup-size="sm"
                                                label="Tanggal Rencana Kontrol" value="{{ $request->tglRencanaKontrol }}"
                                                placeholder="Pilih Tanggal Rencana Kontrol" :config="$config">
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
                                            <x-adminlte-textarea igroup-size="sm" label="Catatan" name="catatan"
                                                placeholder="Catatan Pasien" />
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-warning"> <i class="fas fa-save"></i> Buat
                                        Surat Kontrol</button>
                                </form>

                            </div>
                            <div class="tab-pane" id="farmasitab">
                                <form action="{{ route('lanjutfarmasi') }}" method="GET">
                                    <input type="hidden" name="kodebooking" class="kodebooking-id">
                                    Farmasi
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-adminlte-select igroup-size="sm" name="jenisresep" label="Dokter">
                                                <option selected disabled>Silahkan Jenis Obat</option>
                                                <option value="racikan">Racikan</option>
                                                <option value="non racikan">Non Racikan</option>
                                            </x-adminlte-select>
                                            <x-adminlte-textarea igroup-size="sm" label="Catatan" name="catatan"
                                                placeholder="Catatan Farmasi" />
                                        </div>
                                        <div class="col-md-6">

                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-warning"> <i class="fas fa-pills"></i>Lanjut
                                        Farmasi</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-slot name="footerSlot">
            <a href="" class="btn btn-success mr-auto" id="btnLanjutPoli"><i
                    class="fas fa-sign"></i> Selesai</a>
            <a href="" class="btn btn-danger" id="btnBatal"><i class="fas fa-times"></i> Batal</a>
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Tutup" data-dismiss="modal" />
        </x-slot>
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
                var urllanjut = "{{ route('selesaifarmasi') }}?kodebooking=" + kodebooking;
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
