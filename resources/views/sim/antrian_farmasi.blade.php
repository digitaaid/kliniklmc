@extends('adminlte::page')
@section('title', 'Antrian Farmasi')
@section('content_header')
    <h1>Antrian Farmasi</h1>
@stop
@section('content')
    <div class="row">
        @if ($antrians || $orders)
            <div class="col-md-12">
                <div class="row">
                    @foreach ($antrians->where('taskid', 6) as $item)
                        <div class="col-md-3">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $item->nomorantrean }} ({{ $item->jenispasien }})</h3> <br>
                                    <h3 class="card-title">{{ $item->kunjungan->nama }}</h3> <br>
                                </div>
                                <div class="card-body">
                                    <p>
                                        <b>No RM : </b> {{ $item->kunjungan->norm }} <br>
                                        <b>Nama : </b> {{ $item->kunjungan->nama }} <br>
                                        <b>Tgl Lahir : </b> {{ $item->kunjungan->tgl_lahir }} <br>
                                        <b>Kelamin : </b> {{ $item->kunjungan->gender }}
                                    </p>
                                    <hr>
                                    <strong><i class="fas fa-pills mr-1"></i> Resep Obat</strong>
                                    <br>
                                    @if ($item->resepobat)
                                        @foreach ($item->resepobat->resepdetail as $itemobat)
                                            <b> R/ {{ $itemobat->nama }} </b> ({{ $itemobat->jumlah }}) <br>
                                            &emsp;&emsp;
                                            @switch($itemobat->interval)
                                                @case('qod')
                                                    1x1
                                                @break

                                                @case('bid')
                                                    2x1
                                                @break

                                                @case('tid')
                                                    3x1
                                                @break

                                                @case('qid')
                                                    4x1
                                                @break

                                                @case('prn')
                                                    SESUAI KEBUTUHAN
                                                @break

                                                @case('q3h')
                                                    SETIAP 3 JAM
                                                @break

                                                @case('q4h')
                                                    SETIAP 4 JAM
                                                @break

                                                @default
                                            @endswitch


                                            @switch($itemobat->waktu)
                                                @case('pc')
                                                    SETELAH MAKAN
                                                @break

                                                @case('ac')
                                                    SEBELUM MAKAN
                                                @break

                                                @case('hs')
                                                    SEBELUM TIDUR
                                                @break

                                                @case('int')
                                                    DIANTARA WAKTU MAKAN
                                                @break

                                                @default
                                            @endswitch
                                            {{ $itemobat->keterangan }} <br>
                                        @endforeach
                                    @endif
                                    <br>
                                    @if ($item->kunjungan->asesmendokter)
                                        <p>{{ $item->kunjungan->asesmendokter->resep_obat }}</p>
                                        <hr>
                                        <strong><i class="fas fa-pills mr-1"></i> Catatan Resep</strong>
                                        <pre>{{ $item->kunjungan->asesmendokter->catatan_resep }}</pre>
                                    @endif

                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('selesaifarmasi') }}?kodebooking={{ $item->kodebooking }}"
                                        class="btn btn-success withLoad"><i class="fas fa-check"></i> Selesai</a>
                                    <x-adminlte-button icon="fas fa-edit" theme="success" label="Edit"
                                        onclick="editResep(this)" data-kode="{{ $item->kodebooking }}" />
                                    <a href="{{ route('print_asesmenfarmasi') }}?kodebooking={{ $item->kodebooking }}"
                                        class="btn btn-warning" target="_blank"> <i class="fas fa-print"></i> Print</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @foreach ($orders->where('status', 1) as $item)
                        <div class="col-md-3">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $item->id }} ORDER OBAT</h3> <br>
                                    <h3 class="card-title">{{ $item->nama }}</h3> <br>
                                </div>
                                <div class="card-body">
                                    <p>
                                        <b>Kode : </b> {{ $item->kode }} <br>
                                        <b>Nama : </b> {{ $item->nama }} <br>
                                        <b>No Identitas : </b> {{ $item->nik }} {{ $item->nomorkartu }} <br>
                                        {{-- <b>Tgl Lahir : </b> {{ $item->kunjungan->tgl_lahir }} <br> --}}
                                        {{-- <b>Kelamin : </b> {{ $item->kunjungan->gender }} --}}
                                    </p>
                                    <hr>
                                    <strong><i class="fas fa-pills mr-1"></i> Order Obat</strong>
                                    <br>
                                    @if ($item->orderdetail)
                                        @foreach ($item->orderdetail as $itemobat)
                                            <b> R/ {{ $itemobat->nama }} </b> ({{ $itemobat->jumlah }}) <br>
                                            &emsp;&emsp;
                                            @switch($itemobat->interval)
                                                @case('qod')
                                                    1x1
                                                @break

                                                @case('bid')
                                                    2x1
                                                @break

                                                @case('tid')
                                                    3x1
                                                @break

                                                @case('qid')
                                                    4x1
                                                @break

                                                @case('prn')
                                                    SESUAI KEBUTUHAN
                                                @break

                                                @case('q3h')
                                                    SETIAP 3 JAM
                                                @break

                                                @case('q4h')
                                                    SETIAP 4 JAM
                                                @break

                                                @default
                                            @endswitch


                                            @switch($itemobat->waktu)
                                                @case('pc')
                                                    SETELAH MAKAN
                                                @break

                                                @case('ac')
                                                    SEBELUM MAKAN
                                                @break

                                                @case('hs')
                                                    SEBELUM TIDUR
                                                @break

                                                @case('int')
                                                    DIANTARA WAKTU MAKAN
                                                @break

                                                @default
                                            @endswitch
                                            {{ $itemobat->keterangan }} <br>
                                        @endforeach
                                    @endif
                                    <br>
                                    @if ($item->resep_obat || $item->catatan_resep || $item->keterangan)
                                        <p>{{ $item->resep_obat }}</p>
                                        <hr>
                                        <strong><i class="fas fa-pills mr-1"></i> Catatan Resep</strong>
                                        <pre>{{ $item->catatan_resep }}</pre>
                                        <pre>{{ $item->keterangan }}</pre>
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('selesaifarmasi') }}?kodebooking={{ $item->kode }}"
                                        class="btn btn-success withLoad"><i class="fas fa-check"></i> Selesai</a>
                                    <a href="{{ route('selesaifarmasi') }}?kodebooking={{ $item->kode }}"
                                        class="btn btn-danger withLoad"><i class="fas fa-times"></i> Batal</a>
                                    {{-- <x-adminlte-button icon="fas fa-edit" theme="success" label="Edit"
                                        onclick="editResep(this)" data-kode="{{ $item->kodebooking }}" /> --}}
                                    <a href="{{ route('print_asesmenfarmasi') }}?kodebooking={{ $item->kodebooking }}"
                                        class="btn btn-warning" target="_blank"> <i class="fas fa-print"></i> Print</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="col-md-12">
            <x-adminlte-card title="Data Antrian Farmasi" theme="secondary" icon="fas fa-info-circle" collapsible="">
                @if ($antrians)
                    <div class="row">
                        <div class="col-md-3">
                            <x-adminlte-small-box
                                title="{{ $antrians->where('taskid', '>=', 5)->where('taskid', '<', 7)->count() }}"
                                text="Sisa Resep" theme="warning" icon="fas fa-user-injured" />
                        </div>
                        <div class="col-md-3">
                            <x-adminlte-small-box title="{{ $antrians->where('taskid', 7)->count() }}"
                                text="Total Resep Selesai" theme="success" icon="fas fa-user-injured" />
                        </div>
                        <div class="col-md-3">
                            <x-adminlte-small-box
                                title="{{ $antrians->where('taskid', 7)->where('jenispasien', 'JKN')->count() }}"
                                text="Total Resep JKN" theme="primary" icon="fas fa-user-injured" />
                        </div>
                        <div class="col-md-3">
                            <x-adminlte-small-box
                                title="{{ $antrians->where('taskid', 7)->where('jenispasien', 'NON-JKN')->count() }}"
                                text="Total Resep NON-JKN" theme="primary" icon="fas fa-user-injured" />
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-6">
                                    @php
                                        $config = ['format' => 'YYYY-MM-DD'];
                                    @endphp
                                    <x-adminlte-input-date name="tanggalperiksa"
                                        value="{{ $request->tanggalperiksa ?? now()->format('Y-m-d') }}"
                                        placeholder="Pilih Tanggal" igroup-size="sm" :config="$config">
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-primary">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </x-slot>
                                        <x-slot name="appendSlot">
                                            <x-adminlte-button type="submit" theme="primary" label="Cari Tanggal" />
                                        </x-slot>
                                    </x-adminlte-input-date>
                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-button label="Tambah Order Obat" onclick="orderObat()" class="btn-sm"
                                        theme="success" icon="fas fa-plus" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-4">
                        <form action="" method="get">
                            <x-adminlte-input name="pencarian" placeholder="Pencarian Berdasarkan Nama / No RM"
                                igroup-size="sm" value="{{ $request->pencarian }}">
                                <x-slot name="appendSlot">
                                    <x-adminlte-button type="submit" theme="primary" label="Cari" />
                                </x-slot>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text text-primary">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </form>
                    </div>
                </div>
                @php
                    $heads = ['Waktu', 'Kodebooking', 'No RM', 'Pasien', 'Unit', 'Dokter', 'Jenis Pasien', 'Status', 'Action'];
                    $config['order'] = [[7, 'asc']];
                    $config['paging'] = false;
                    $config['scrollY'] = '300px';
                @endphp
                <x-adminlte-datatable id="table1" class="nowrap" :heads="$heads" :config="$config" bordered hoverable
                    compressed>
                    @if ($antrians || $orders)
                        @foreach ($antrians as $item)
                            <tr>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->kodebooking }}</td>
                                <td>{{ $item->norm }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->kunjungan ? $item->kunjungan->units->nama : '-' }}</td>
                                <td>{{ $item->namadokter }}</td>
                                <td>{{ $item->jenispasien }} </td>
                                <td>
                                    @switch($item->taskid)
                                        @case(0)
                                            <span class="badge badge-secondary">98. Belum Checkin</span>
                                        @break

                                        @case(1)
                                            <span class="badge badge-warning">97. Menunggu Pendaftaran</span>
                                        @break

                                        @case(2)
                                            <span class="badge badge-primary">96. Proses Pendaftaran</span>
                                        @break

                                        @case(3)
                                            <span class="badge badge-warning">95. Menunggu Poliklinik</span>
                                        @break

                                        @case(4)
                                            <span class="badge badge-primary">94. Pelayanan Poliklinik</span>
                                        @break

                                        @case(5)
                                            <span class="badge badge-warning">5. Tunggu Farmasi</span>
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
                                    @switch($item->taskid)
                                        @case(5)
                                            <a href="{{ route('terimafarmasi') }}?kodebooking={{ $item->kodebooking }}"
                                                class="btn btn-xs btn-warning withLoad">Terima</a>
                                        @break

                                        @case(6)
                                            <x-adminlte-button icon="fas fa-edit" class="btn-xs" theme="warning" label="Edit"
                                                onclick="editResep(this)" data-kode="{{ $item->kodebooking }}" />
                                            <a href="{{ route('selesaifarmasi') }}?kodebooking={{ $item->kodebooking }}"
                                                class="btn btn-xs btn-success withLoad"> Selesai</a>
                                        @break

                                        @case(7)
                                            <a href="{{ route('print_asesmenfarmasi') }}?kodebooking={{ $item->kodebooking }}"
                                                class="btn btn-xs btn-warning" target="_blank"> <i class="fas fa-print"></i>
                                                Print</a>
                                            <x-adminlte-button icon="fas fa-edit" theme="warning" label="Edit"
                                                onclick="editResep(this)" class="btn-xs" data-kode="{{ $item->kodebooking }}" />
                                            <a href="{{ route('panggilpendaftaran') }}?kodebooking={{ $item->kodebooking }}"
                                                class="btn btn-primary btn-xs withLoad">
                                                <i class="fas fa-volume-down"></i>
                                            </a>
                                        @break

                                        @default
                                            <div class="btn btn-xs btn-secondary">
                                                Belum
                                            </div>
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                        @foreach ($orders as $item)
                            <tr>
                                <td>{{ $item->waktu }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nik }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>FARMASI</td>
                                <td>{{ $item->pic }}</td>
                                <td>ORDER-OBAT</td>
                                <td>
                                    @switch($item->status)
                                        @case(1)
                                            <span class="badge badge-primary">6. Racik Obat</span>
                                        @break

                                        @case(2)
                                            <span class="badge badge-success">7. Selesai</span>
                                        @break

                                        @case(99)
                                            <span class="badge badge-danger">99. Batal</span>
                                        @break

                                        @default
                                            {{ $item->status }}
                                    @endswitch
                                </td>
                                <td>
                                    @switch($item->status)
                                        @case(1)
                                            <x-adminlte-button icon="fas fa-edit" class="btn-xs" theme="warning" label="Edit"
                                                onclick="editResep(this)" data-kode="{{ $item->kode }}" />
                                            <a href="{{ route('selesai_order_obat') }}?kode={{ $item->kode }}"
                                                class="btn btn-xs btn-success withLoad"> Selesai</a>
                                            <a href="{{ route('batal_order_obat') }}?kode={{ $item->kode }}"
                                                class="btn btn-xs btn-danger withLoad"><i class="fas fa-times"></i> Batal</a>
                                        @break

                                        @case(2)
                                            <a href="{{ route('reset_order_obat') }}?kode={{ $item->kode }}"
                                                class="btn btn-xs btn-danger withLoad"><i class="fas fa-sync"></i> Reset</a>
                                        @break

                                        @case(99)
                                            <a href="{{ route('reset_order_obat') }}?kode={{ $item->kode }}"
                                                class="btn btn-xs btn-danger withLoad"><i class="fas fa-sync"></i> Reset</a>
                                        @break

                                        @default
                                            <div class="btn btn-xs btn-secondary">
                                                Belum
                                            </div>
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
    <audio id="myAudio">
        <source src="{{ asset('tingtung.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <x-adminlte-modal id="modalResep" size="xl" title="Resep Obat" icon="fas fa-pills" theme="warning">
        <div id="formResep">
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button icon="fas fa-save" theme="success" label="Simpan" type="submit" form="formEditResep" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Tutup" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-modal id="modalOrder" size="xl" title="Order Obat" icon="fas fa-pills" theme="warning">
        <form id="formOrder" action={{ route('create_order_obat') }} method="POST">
            @csrf
            <style>
                .cariObat {
                    width: 300px !important;
                }
            </style>
            @php
                $config = ['format' => 'YYYY-MM-DD HH:mm:ss'];
            @endphp
            <x-adminlte-input-date name="waktu" label="Tanggal Order" value="{{ now() }}"
                placeholder="Pilih Tanggal Order" igroup-size="sm" :config="$config" />
            <x-adminlte-input name="nama" label="Nama Pasien" igroup-size="sm" placeholder="Nama Pasien" />
            <x-adminlte-input name="nik" label="NIK" igroup-size="sm" placeholder="NIK" />
            <x-adminlte-input name="nomorkartu" label="Kartu BPJS" igroup-size="sm" placeholder="Kartu BPJS" />
            <div class="row">
                <div class="col-md-12">
                    <label class="mb-2">Resep Obat</label>
                    <button id="addObatInput" type="button" class="btn btn-xs btn-success mb-2">
                        <span class="fas fa-plus">
                        </span> Tambah Obat
                    </button>
                    <div id="rowTindakan" class="row">
                        <div class="form-group">
                            <div class="input-group input-group-sm">
                                <select name="obat[]" class="form-control cariObat">
                                </select>
                                <input type="number" name="jumlah[]" placeholder="Jumlah" class="form-control"
                                    multiple>
                                <select name="frekuensi[]" class="form-control frekuensilObat">
                                    <option selected disabled>Interval</option>
                                    <option value="qod">1 x 1</option>
                                    <option value="dod">1 x 2</option>
                                    <option value="bid">2 x 1</option>
                                    <option value="tid">3 x 1</option>
                                    <option value="qid">4 x 1</option>
                                    <option value="202">2-0-2</option>
                                    <option value="303">3-0-3</option>
                                </select>
                                <select name="waktuobat[]" class="form-control waktuObat">
                                    <option selected>Waktu Obat</option>
                                    <option value="pc">Setelah Makan</option>
                                    <option value="ac">Sebelum Makan</option>
                                    <option value="hs">Sebelum Tidur</option>
                                    <option value="int">Diantara Waktu Makan</option>
                                </select>
                                <input type="text" name="keterangan_obat[]" placeholder="Keterangan Obat"
                                    class="form-control" multiple>
                                <button type="button" class="btn btn-xs btn-warning">
                                    <i class="fas fa-pills "></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="newObat"></div>
                </div>
                <div class="col-md-6">
                    <x-adminlte-textarea igroup-size="sm" rows=3 label="Resep Obat (Free Text)" name="resep_obat"
                        placeholder="Resep Obat (Text)">
                        {{ $kunjungan->asesmendokter->resep_obat ?? null }}
                    </x-adminlte-textarea>
                </div>
                <div class="col-md-6">
                    <x-adminlte-textarea igroup-size="sm" rows=3 label="Catatan Resep" name="catatan_resep"
                        placeholder="Catatan Resep">
                        {{ $kunjungan->asesmendokter->catatan_resep ?? null }}
                    </x-adminlte-textarea>
                </div>
            </div>
        </form>
        <x-slot name="footerSlot">
            <x-adminlte-button icon="fas fa-save" class="withLoad" theme="success" label="Simpan" type="submit"
                form="formOrder" />
            <x-adminlte-button theme="danger" icon="fas fa-times" label="Tutup" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
@stop

@section('plugins.Datatables', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)

@section('css')
    <style>
        pre {
            padding: 0 !important;
            font-size: 15px !important;
        }
    </style>
@endsection

@push('js')
    {{-- otomatis suara pemanggilan --}}
    <script>
        var x = document.getElementById("myAudio");

        function playAudio() {
            x.play();
        }

        function pauseAudio() {
            x.pause();
        }
        $(document).ready(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            var url = "{{ route('getantrianfarmasi') }}";
            var tanggalperiksa = "{{ $request->tanggalperiksa }}";
            var data = {
                'tanggalperiksa': tanggalperiksa,
            };
            if (tanggalperiksa) {
                setInterval(function() {
                    $.ajax({
                        url: url,
                        data: data,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data);
                            if (data.metadata.code == 200) {
                                playAudio();
                                Swal.fire({
                                    title: 'Terima antrian resep obat ?',
                                    text: "Telah dibuatkan resep obat baru oleh dokter.",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Ya, Terima Resep'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        pauseAudio();
                                        var urlterima =
                                            "{{ route('terimafarmasi') }}?kodebooking=" +
                                            data.response.kodebooking;
                                        window.location.href = urlterima;
                                    }
                                });
                            }
                        },
                        error: function(data) {
                            // console.log(data);
                        }
                    });



                }, 5 * 1000);
            }
        });
    </script>
    {{-- resep obat --}}
    <script>
        function editResep(button) {
            $.LoadingOverlay("show");
            var url = "{{ route('form_resep_obat') }}?kode=" + $(button).data("kode");
            $.ajax({
                url: url,
                method: "GET",
            }).done(function(data) {
                console.log(data);
                $('#formResep').html(data);
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
                $('#modalResep').modal('show');
                $.LoadingOverlay("hide");
            }).fail(function(data, textStatus, errorThrown) {
                console.log(data);
                $.LoadingOverlay("hide");
            });
        }
    </script>
    {{-- order obat --}}
    <script>
        function orderObat() {
            // $.LoadingOverlay("show");
            $('#modalOrder').modal('show');
            // var url = "{{ route('form_resep_obat') }}?kode=" + $(button).data("kode");
            // $.ajax({
            //     url: url,
            //     method: "GET",
            // }).done(function(data) {
            //     console.log(data);
            //     $('#formResep').html(data);
            //     $(".cariObat").select2({
            //         placeholder: 'Pencarian Nama Obat',
            //         theme: "bootstrap4",
            //         multiple: true,
            //         maximumSelectionLength: 1,
            //         ajax: {
            //             url: "{{ route('ref_obat_cari') }}",
            //             type: "get",
            //             dataType: 'json',
            //             delay: 100,
            //             data: function(params) {
            //                 return {
            //                     nama: params.term // search term
            //                 };
            //             },
            //             processResults: function(response) {
            //                 return {
            //                     results: response
            //                 };
            //             },
            //             cache: true
            //         }
            //     });
            //     $('#modalResep').modal('show');
            //     $.LoadingOverlay("hide");
            // }).fail(function(data, textStatus, errorThrown) {
            //     console.log(data);
            //     $.LoadingOverlay("hide");
            // });
        }
    </script>
    {{-- dynamic input --}}
    <script>
        $(function() {
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
    </script>
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
@endpush
