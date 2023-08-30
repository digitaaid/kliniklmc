@extends('adminlte::page')
@section('title', 'Antrian Pendaftaran')
@section('content_header')
    <h1>Antrian Pendaftaran</h1>
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
                        @foreach ($antrians->where('taskid', 2) as $item)
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
                                    <a href="{{ route('layanipendaftaran') }}?kodebooking={{ $item->kodebooking }}"
                                        class="btn btn-xs btn-warning withLoad">Panggil</a>
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </x-adminlte-card>
                <x-adminlte-card title="Data Antrian Menunggu Pendaftaran" theme="primary" icon="fas fa-info-circle"
                    collapsible>
                    @php
                        $heads = ['No Antrian', 'kodebooking', 'Pasien', 'Dokter', 'Poliklinik', 'Jenis Pasien', 'Status', 'Action'];
                        $config['order'] = [[6, 'asc']];
                    @endphp
                    <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered
                        hoverable compressed>
                        @foreach ($antrians->where('taskid', '!=', 2) as $item)
                            <tr>
                                <td>{{ $item->nomorantrean }} / {{ $item->angkaantrean }}</td>
                                <td>{{ $item->kodebooking }}</td>
                                <td>{{ $item->norm }} {{ $item->nama }}</td>
                                <td>{{ $item->namadokter }}</td>
                                <td>{{ $item->namapoli }}</td>
                                <td>{{ $item->pasienbaru }} {{ $item->jenispasien }} </td>
                                <td>
                                    @switch($item->taskid)
                                        @case(0)
                                            <span class="badge badge-secondary">98. Belum Checkin</span>
                                        @break

                                        @case(1)
                                            <span class="badge badge-warning">1. Menunggu Pendaftaran</span>
                                        @break

                                        @case(2)
                                            <span class="badge badge-primary">2. Proses Pendaftaran</span>
                                        @break

                                        @case(3)
                                            <span class="badge badge-warning">3. Menunggu Poliklinik</span>
                                        @break

                                        @case(4)
                                            <span class="badge badge-primary">4. Pelayanan Poliklinik</span>
                                        @break

                                        @case(5)
                                            <span class="badge badge-warning">5. Selesai Poliklinik</span>
                                        @break

                                        @case(6)
                                            <span class="badge badge-primary">6. Racik Obat</span>
                                        @break

                                        @case(7)
                                            <span class="badge badge-success">7. Selesai</span>
                                        @break

                                        @case(99)
                                            <span class="badge badge-danger">99. Batal</span>
                                        @break

                                        @default
                                            {{ $item->taskid }}
                                    @endswitch
                                </td>
                                <td>
                                    @if ($item->taskid == 1)
                                        <a href="{{ route('layanipendaftaran') }}?kodebooking={{ $item->kodebooking }}"
                                            class="btn btn-xs btn-warning withLoad">Panggil</a>
                                    @else
                                        <button class="btn btn-xs btn-secondary btnAntrian"
                                            data-kodebooking="{{ $item->kodebooking }}" data-taskid="{{ $item->taskid }}"
                                            data-namapasien="{{ $item->nama }}" data-norm="{{ $item->norm }}"
                                            data-nomorkartu="{{ $item->nomorkartu }}" data-nik="{{ $item->nik }}"
                                            data-nohp="{{ $item->nohp }}" data-kodebooking="{{ $item->kodebooking }}"
                                            data-nomorantrean="{{ $item->nomorantrean }}"
                                            data-jeniskunjungan="{{ $item->jeniskunjungan }}"
                                            data-sep="{{ $item->sep }}" data-namapoli="{{ $item->namapoli }}"
                                            data-namadokter="{{ $item->namadokter }}">
                                            Lihat
                                        </button>
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
                @include('sim.profile_pasien_antrian')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#identitastab"
                                    data-toggle="tab">Indentitas</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#keperawatantab"
                                    data-toggle="tab">Keperawatan</a>
                            <li class="nav-item"><a class="nav-link" href="#riwayattab" data-toggle="tab">Riwayat</a></li>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#septab" data-toggle="tab">SEP</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="identitastab">
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
                                    <button type="submit" class="btn btn-warning withLoad"> <i class="fas fa-edit"></i>
                                        Update
                                        Identitas</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="keperawatantab">
                                Pemeriksaan Keperawatan
                            </div>
                            <div class="tab-pane" id="riwayattab">
                                Riwayat Pasien
                            </div>
                            <div class="tab-pane" id="septab">
                                Identitas Rujukan atau Surat Kontrol Pasien
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-adminlte-input name="nomorkartu" class="nomorkartu-id" igroup-size="sm"
                                            label="Nomor Kartu" placeholder="Nomor Kartu" />
                                        <x-adminlte-input name="norm" class="norm-id" label="No RM" igroup-size="sm"
                                            placeholder="No RM " />
                                        <x-adminlte-input name="nama" class="nama-id" label="Nama Pasien"
                                            igroup-size="sm" placeholder="Nama Pasien" />
                                        <x-adminlte-input name="nohp" class="nohp-id" label="Nomor HP"
                                            igroup-size="sm" placeholder="Nomor HP" />

                                    </div>
                                    <div class="col-md-6">
                                        <x-adminlte-input name="noRujukan" class="noRujukan-id" igroup-size="sm"
                                            label="Nomor Rujukan" placeholder="Nomor Rujukan">
                                            <x-slot name="appendSlot">
                                                <div class="btn btn-primary btnCariRujukan">
                                                    <i class="fas fa-search"></i> Cari
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                        <x-adminlte-input name="noSurat" class="noSurat-id" igroup-size="sm"
                                            label="Nomor Surat Kontrol" placeholder="Nomor Surat Kontrol">
                                            <x-slot name="appendSlot">
                                                <div class="btn btn-primary btnCariSurat">
                                                    <i class="fas fa-search"></i> Cari
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input>
                                    </div>
                                </div>
                                SEP Pasien
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-adminlte-select igroup-size="sm" name="dpjpLayan" label="Dokter DPJP">
                                            <option selected disabled>Pilih Dokter DPJP</option>
                                        </x-adminlte-select>
                                        <x-adminlte-select igroup-size="sm" name="jnsPelayanan" label="Jenis Pelayanan">
                                            <option selected disabled>Pilih Jenis Pelayanan</option>
                                            <option value="2">Rawat Jalan</option>
                                            <option value="1">Rawat Inap</option>
                                        </x-adminlte-select>
                                        <x-adminlte-textarea igroup-size="sm" name="catatan"
                                            placeholder="Catatan Pasien" />
                                        <x-adminlte-select2 igroup-size="sm" name="diagAwal" label="Diagnosa Awal">
                                            <option>Option 1</option>
                                            <option disabled>Option 2</option>
                                            <option selected>Option 3</option>
                                        </x-adminlte-select2>
                                        <x-adminlte-select2 igroup-size="sm" name="poli" label="Poliklinik">
                                            <option>Option 1</option>
                                            <option disabled>Option 2</option>
                                            <option selected>Option 3</option>
                                        </x-adminlte-select2>
                                    </div>
                                    <div class="col-md-6">
                                        <x-adminlte-select igroup-size="sm" name="tujuanKunj" label="Tujuan Kunjungan">
                                            <option value="0">Normal</option>
                                            <option value="1">Prosedur</option>
                                            <option value="2">Konsul Dokter</option>
                                        </x-adminlte-select>
                                        <x-adminlte-select igroup-size="sm" name="flagProcedure" label="Flag Procedur">
                                            <option value="">Normal</option>
                                            <option value="0">Prosedur Tidak Berkelanjutan</option>
                                            <option value="1">Prosedur dan Terapi Berkelanjutan</option>
                                        </x-adminlte-select>
                                        <x-adminlte-select igroup-size="sm" name="kdPenunjang" label="Penunjang">
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
                                        <x-adminlte-select igroup-size="sm" name="assesmentPel"
                                            label="Assesment Pelayanan">
                                            <option value="">Normal</option>
                                            <option value="0">Poli tujuan beda dengan poli rujukan dan hari beda
                                            </option>
                                            <option value="1">Poli spesialis tidak tersedia pada hari sebelumnya
                                            </option>
                                            <option value="2">Jam Poli telah berakhir pada hari sebelumnya</option>
                                            <option value="3">Dokter Spesialis yang dimaksud tidak praktek pada hari
                                                sebelumnya</option>
                                            <option value="4">Atas Instruksi RS</option>
                                            <option value="5">Tujuan Kontrol</option>
                                        </x-adminlte-select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-warning withLoad"> <i class="fas fa-edit"></i> Buat
                                    SEP</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-slot name="footerSlot">
            <a href="" class="btn btn-warning mr-auto withLoad" id="btnLanjutPoli"><i class="fas fa-sign"></i> Lanjut
                Poliklinik</a>
            <a href="" class="btn btn-danger" id="btnBatal"><i class="fas fa-times"></i> Batal</a>
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Tutup" data-dismiss="modal" />
        </x-slot>
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
                // var url = "{{ route('layanipendaftaran') }}?kodebooking=" + kodebooking;
                // if (taskid == 1) {
                //     $.get(url, function(data, status) {
                //         console.log(data);
                //     });
                // }
                var urllanjut = "{{ route('lanjutpoliklinik') }}?kodebooking=" + kodebooking;
                $("#btnLanjutPoli").attr("href", urllanjut);
                var urlbatal = "{{ route('batalantrian') }}?kodebooking=" + kodebooking +
                    "&keterangan=dibatalkan_dipendaftarn";
                $("#btnBatal").attr("href", urlbatal);
                $('#modalAntrian').modal('show');
                $.LoadingOverlay("hide");
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
        });
    </script>
@endsection
