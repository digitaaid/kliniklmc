@extends('adminlte::master')
{{-- @inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper') --}}
@section('title', 'Mesin Anjungan Antrian')
@section('body')
    <link rel="shortcut icon" href="{{ asset('medicio/assets/img/lmc.png') }}" />
    <div class="wrapper">
        <div class="row p-1">
            <div class="col-md-12">
                <div class="card">
                    <header class="bg-purple text-white p-4">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <img src="{{ asset('medicio/assets/img/lmc-b.png') }}" width="100"
                                            alt="">
                                        <div class="col">
                                            <h1>Klinik LMC</h1>
                                            <p>Luthfi Medical Center</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <p>Whatsapp : 0823 1169 6919</p>
                                    <p>Telepon : (0231) 8850943</p>
                                </div>
                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="{{ asset('img/3.jpg') }}" alt="First slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>...</h5>
                                        <p>...</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="{{ asset('img/4.jpg') }}" alt="First slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>...</h5>
                                        <p>...</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="{{ asset('img/5.jpg') }}" alt="First slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>...</h5>
                                        <p>...</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="{{ asset('img/6.jpg') }}" alt="First slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>...</h5>
                                        <p>...</p>
                                    </div>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <p hidden>{{ setlocale(LC_ALL, 'IND') }}</p>
                <x-adminlte-card title="Informasi Antrian {{ \Carbon\Carbon::now()->formatLocalized('%A, %d %B %Y') }}"
                    theme="purple" icon="fas fa-calendar-alt">
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $heads = ['Poliklinik', 'Dokter', 'Jam Praktek', 'Kuota', 'Antrian'];
                            @endphp
                            <x-adminlte-datatable id="table1" class="nowrap text-xs" :heads="$heads" striped bordered>
                                @foreach ($jadwals as $jadwal)
                                    @if ($jadwal->libur || $antrians->where('jadwal_id', $jadwal->id)->count() >= $jadwal->kapasitaspasien)
                                        <tr class="table-danger">
                                        @else
                                        <tr>
                                    @endif
                                    <td>{{ $jadwal->namasubspesialis }}</td>
                                    <td>{{ $jadwal->namadokter }}</td>
                                    <td>{{ $jadwal->jadwal }}</td>
                                    <td>{{ $jadwal->kapasitaspasien }}</td>
                                    <td>{{ $antrians->where('jadwal_id', $jadwal->id)->count() }}</td>
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-info-box class="btnDaftarBPJS text-center" text="Ambil Antrian BPJS"
                                theme="success" />
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-info-box class="btnDaftarUmum text-center" text="Ambil Antrian Umum"
                                theme="success" />
                        </div>
                    </div>
                </x-adminlte-card>
                <x-adminlte-card title="Anjungan Checkin Antrian" theme="purple" icon="fas fa-qrcode">
                    <div class="text-center">
                        <x-adminlte-input name="kodebooking" label="Silahkan scan QR Code Antrian atau masukan Kode Antrian"
                            placeholder="Masukan Kode Antrian untuk Checkin" igroup-size="lg">
                            <x-slot name="appendSlot">
                                <x-adminlte-button name="btn_checkin" id="btn_checkin" theme="success"
                                    label="Checkin!" />
                            </x-slot>
                            <x-slot name="prependSlot">
                                <div class="input-group-text text-success">
                                    <i class="fas fa-qrcode"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <i class="fas fa-qrcode fa-5x"></i>
                        <br>
                    </div>
                    <x-slot name="footerSlot">
                        <x-adminlte-button icon="fas fa-sync" class="withLoad reload" theme="warning" label="Reload" />
                        <a href="{{ route('testprinterthermal') }}" class="btn btn-warning withLoad"><i
                                class="fas fa-print"></i>
                            Test
                            Printer</a>
                        <a href="{{ route('checkinantrian') }}" class="btn btn-warning withLoad"><i
                                class="fas fa-print"></i> Checkin
                            Antrian</a>
                    </x-slot>
                </x-adminlte-card>
            </div>
        </div>
    </div>
    <x-adminlte-modal id="modalBPJS" size="xl" title="Ambil Antrian BPJS" theme="success" icon="fas fa-user-plus">
        @foreach ($jadwals as $jadwal)
            <a class="card bg-success withLoad"
                href="{{ route('ambilkarcis') }}?jenispasien=JKN&jadwal={{ $jadwal->id }}">
                <div class="card-body  text-center">
                    {{ $jadwal->jadwal }}
                    {{ $jadwal->namadokter }}
                    ({{ $jadwal->namasubspesialis }})
                </div>
            </a>
        @endforeach
    </x-adminlte-modal>
    <x-adminlte-modal id="modalUMUM" size="xl" title="Ambil Antrian UMUM" theme="success" icon="fas fa-user-plus">
        @foreach ($jadwals as $jadwal)
            <a class="card bg-success withLoad"
                href="{{ route('ambilkarcis') }}?jenispasien=NON-JKN&jadwal={{ $jadwal->id }}">
                <div class="card-body  text-center">
                    {{ $jadwal->jadwal }}
                    {{ $jadwal->namadokter }}
                    ({{ $jadwal->namasubspesialis }})
                </div>
            </a>
        @endforeach
    </x-adminlte-modal>
@stop
@section('adminlte_css')
@section('adminlte_js')
    <script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('loading-overlay/loadingoverlay.min.js') }}"></script>
    <script src="{{ asset('onscan.js/onscan.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- scan --}}
    <script>
        $(function() {
            onScan.attachTo(document, {
                onScan: function(sCode, iQty) {
                    $.LoadingOverlay("show", {
                        text: "Mencari kodebooking " + sCode + "..."
                    });
                    var url = "{{ route('checkinantrian') }}?kodebooking=" + sCode;
                    window.location.href = url;
                },
            });
        });
    </script>
    {{-- btn chekin --}}
    <script>
        $(function() {
            $('#btn_checkin').click(function() {
                var kodebooking = $('#kodebooking').val();
                $.LoadingOverlay("show", {
                    text: "Mencari kodebooking " + kodebooking + "..."
                });
                var url = "{{ route('checkinantrian') }}?kodebooking=" + kodebooking;
                window.location.href = url;
            });
        });
    </script>
    {{-- btn daftar --}}
    <script>
        $(function() {
            $('.btnDaftarBPJS').click(function() {
                $('#modalBPJS').modal('show');
            });
            $('.btnDaftarUmum').click(function() {
                $('#modalUMUM').modal('show');
            });
        });
    </script>
    {{-- withLoad --}}
    <script>
        $(function() {
            $(".withLoad").click(function() {
                $.LoadingOverlay("show");
            });
        })
        $('.reload').click(function() {
            location.reload();
        });
    </script>
@stop
@section('plugins.Datatables', true)-
@include('sweetalert::alert')
