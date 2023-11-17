@extends('adminlte::master')
{{-- @inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper') --}}
@section('title', 'Display Antrian')
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
                                            <h4>Luthfi Medical Center</h4>
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
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-blue">
                        <div class="text-center">
                            <h4>Antrian Pendaftaran</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <h1><span id="pendaftaran">-</span></h1>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-blue">
                        <div class="text-center">
                            <h4>Antrian Dokter</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <h1><span id="poliklinik">-</span></h1>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-blue">
                        <div class="text-center">
                            <h4>Antrian Farmasi</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <h1><span id="farmasi">-</span></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <x-adminlte-card>
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" height="450" width="100%" src="{{ asset('img/3.jpg') }}" alt="First slide">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>...</h5>
                                    <p>...</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" height="450" width="100%" src="{{ asset('img/4.jpg') }}"
                                    alt="First slide">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>...</h5>
                                    <p>...</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" height="450" width="100%" src="{{ asset('img/5.jpg') }}"
                                    alt="First slide">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>...</h5>
                                    <p>...</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" height="450" width="100%" src="{{ asset('img/6.jpg') }}"
                                    alt="First slide">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>...</h5>
                                    <p>...</p>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </x-adminlte-card>
            </div>
            <div class="col-md-4">
                <x-adminlte-card>
                    {{-- <iframe width="560" height="315"
                        src="https://www.youtube.com/embed/-rLm4l1yuhU?si=N2MQHFACzBjy-lc7?autoplay=1"
                        title="YouTube video player" frameborder="0" allowfullscreen></iframe> --}}
                    {{-- <iframe src="http://..." onload='playVideo();'> --}}
                    {{-- <video width="100%" height="500" controls autoplay>
                        <source src="{{ asset('movie.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video> --}}
                    {{-- <iframe width="560" height="315" src="https://www.youtube.com/embed/rLInKEMHykE?si=sWG-1mT9ydRzXGhS&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe> --}}
                    <iframe
                        src="https://www.youtube.com/embed/rLInKEMHykE?si=sWG-1mT9ydRzXGhS?rel=0&modestbranding=1&autohide=1&mute=1&showinfo=0&controls=1&autoplay=1&loop=1"
                        width="100%" height="450" frameborder="0" allowfullscreen onload='playVideo();'> ></iframe>
                    {{-- <iframe src="https://drive.google.com/file/d/1xhCy7W5YDbGha30VPRttcxEykvV4yixz/preview" width="640"
                        height="480" allow="autoplay"></iframe> --}}
                </x-adminlte-card>
            </div>
        </div>
        {{-- <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-blue">
                        <div class="text-center">
                            <h4>Antrian Pendaftaran</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <h1><span id="pendaftaran">-</span></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-blue">
                        <div class="text-center">
                            <h4>Antrian Dokter</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <h1><span id="poliklinik">-</span></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-blue">
                        <div class="text-center">
                            <h4>Antrian Farmasi</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <h1><span id="farmasi">-</span></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <audio id="suarabel" src="{{ asset('rekaman/Airport_Bell.mp3') }}"></audio>
    <audio id="panggilannomorantrian" src="{{ asset('rekaman/panggilannomorantrian.mp3') }}"></audio>
    <audio id="diloketpendaftaran" src="{{ asset('rekaman/diloketpendaftaran.mp3') }}"></audio>
    <audio id="dipoliklinik" src="{{ asset('rekaman/dipoliklinik.mp3') }}"></audio>
    <audio id="poliklinik" src="{{ asset('rekaman/poliklinik/008.mp3') }}"></audio>
    <audio id="difarmasi" src="{{ asset('rekaman/difarmasi.mp3') }}"></audio>
    <audio id="nomor0" src=""></audio>
    <audio id="nomor1" src=""></audio>
    <audio id="belas" src="{{ asset('rekaman/belas.mp3') }}"></audio>
    <audio id="puluh" src="{{ asset('rekaman/puluh.mp3') }}"></audio>
@stop
@section('adminlte_css')
    <style>
        body {
            background-color: rebeccapurple;
        }
    </style>
@endsection
@section('adminlte_js')
    <script type="text/javascript">
        function playVideo() {
            $('.ytp-large-play-button').click();
        }
        setInterval(function() {
            var url = "{{ route('displaynomor') }}";
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    $('#pendaftaran').html(data.response.pendaftaran);
                    $('#pendaftaranselanjutnya').html(data.response.pendaftaranselanjutnya);
                    $('#poliklinik').html(data.response.poliklinik);
                    $('#poliklinikselanjutnya').html(data.response.poliklinikselanjutnya);
                    $('#farmasi').html(data.response.farmasi);
                    $('#farmasiselanjutnya').html(data.response.farmasiselanjutnya);
                    if (data.response.pendaftaranstatus == 0) {
                        var url = "{{ route('updatenomorantrean') }}?kodebooking=" + data.response
                            .pendaftarankodebooking;
                        $.ajax({
                            url: url,
                            type: "GET",
                            dataType: 'json',
                            success: function(res) {
                                panggilpendaftaran(data.response.pendaftaran);
                            },
                        });
                    }
                    if (data.response.farmasistatus == 0) {
                        var url = "{{ route('updatenomorantrean') }}?kodebooking=" + data.response
                            .farmasikodebooking;
                        $.ajax({
                            url: url,
                            type: "GET",
                            dataType: 'json',
                            success: function(res) {
                                panggilfarmasi(data.response.farmasi);
                            },
                        });
                    }
                    if (data.response.poliklinikstatus == 0) {
                        var url = "{{ route('updatenomorantrean') }}?kodebooking=" + data.response
                            .poliklinikkodebooking;
                        $.ajax({
                            url: url,
                            type: "GET",
                            dataType: 'json',
                            success: function(res) {
                                panggilpoliklinik(data.response.poliklinik);
                            },
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }, 3000);
    </script>

    <script type="text/javascript">
        function panggilpendaftaran(angkaantrian) {
            document.getElementById('suarabel').pause();
            document.getElementById('suarabel').currentTime = 0;
            document.getElementById('suarabel').play();
            totalwaktu = document.getElementById('suarabel').duration * 1000;
            setTimeout(function() {
                document.getElementById('panggilannomorantrian').pause();
                document.getElementById('panggilannomorantrian').currentTime = 0;
                document.getElementById('panggilannomorantrian').play();
            }, totalwaktu);
            totalwaktu = totalwaktu + 2500;
            panggilangka(angkaantrian);
            setTimeout(function() {
                document.getElementById('diloketpendaftaran').pause();
                document.getElementById('diloketpendaftaran').currentTime = 0;
                document.getElementById('diloketpendaftaran').play();
            }, totalwaktu);
        }

        function panggilpoliklinik(angkaantrian) {
            document.getElementById('suarabel').pause();
            document.getElementById('suarabel').currentTime = 0;
            document.getElementById('suarabel').play();
            totalwaktu = document.getElementById('suarabel').duration * 1000;
            setTimeout(function() {
                document.getElementById('panggilannomorantrian').pause();
                document.getElementById('panggilannomorantrian').currentTime = 0;
                document.getElementById('panggilannomorantrian').play();
            }, totalwaktu);
            totalwaktu = totalwaktu + 2500;
            panggilangka(angkaantrian);
            setTimeout(function() {
                document.getElementById('dipoliklinik').pause();
                document.getElementById('dipoliklinik').currentTime = 0;
                document.getElementById('dipoliklinik').play();
            }, totalwaktu);
        }

        function panggilfarmasi(angkaantrian) {
            document.getElementById('suarabel').pause();
            document.getElementById('suarabel').currentTime = 0;
            document.getElementById('suarabel').play();
            totalwaktu = document.getElementById('suarabel').duration * 1000;
            setTimeout(function() {
                document.getElementById('panggilannomorantrian').pause();
                document.getElementById('panggilannomorantrian').currentTime = 0;
                document.getElementById('panggilannomorantrian').play();
            }, totalwaktu);
            totalwaktu = totalwaktu + 2500;
            panggilangka(angkaantrian);
            setTimeout(function() {
                document.getElementById('difarmasi').pause();
                document.getElementById('difarmasi').currentTime = 0;
                document.getElementById('difarmasi').play();
            }, totalwaktu);
        }

        function panggilangka(angkaantrian) {
            if (angkaantrian < 10) {
                $("#nomor0").attr("src", "{{ route('landingpage') }}/public/rekaman/" + angkaantrian + ".mp3");
                setTimeout(function() {
                    document.getElementById('nomor0').pause();
                    document.getElementById('nomor0').currentTime = 0;
                    document.getElementById('nomor0').play();
                }, totalwaktu);
                totalwaktu = totalwaktu + 1000;
            } else if (angkaantrian == 10) {
                $("#nomor0").attr("src", "{{ route('landingpage') }}/public/rekaman/sepuluh.mp3");
                setTimeout(function() {
                    document.getElementById('nomor0').pause();
                    document.getElementById('nomor0').currentTime = 0;
                    document.getElementById('nomor0').play();
                }, totalwaktu);
                totalwaktu = totalwaktu + 1000;
            } else if (angkaantrian == 11) {
                $("#nomor0").attr("src", "{{ route('landingpage') }}/public/rekaman/sebelas.mp3");
                setTimeout(function() {
                    document.getElementById('nomor0').pause();
                    document.getElementById('nomor0').currentTime = 0;
                    document.getElementById('nomor0').play();
                }, totalwaktu);
                totalwaktu = totalwaktu + 1000;
            } else if (angkaantrian < 20) {
                var nomor1 = angkaantrian.charAt(1);
                $("#nomor0").attr("src", "{{ route('landingpage') }}/public/rekaman/" + nomor1 + ".mp3");
                setTimeout(function() {
                    document.getElementById('nomor0').pause();
                    document.getElementById('nomor0').currentTime = 0;
                    document.getElementById('nomor0').play();
                }, totalwaktu);
                totalwaktu = totalwaktu + 1000;
                setTimeout(function() {
                    document.getElementById('belas').pause();
                    document.getElementById('belas').currentTime = 0;
                    document.getElementById('belas').play();
                }, totalwaktu);
                totalwaktu = totalwaktu + 1000;
            } else if (angkaantrian < 100) {
                var angka = angkaantrian;
                var angka1 = angka.charAt(0);
                $("#nomor0").attr("src", "{{ route('landingpage') }}/public/rekaman/" + angka1 + ".mp3");
                setTimeout(function() {
                    document.getElementById('nomor0').pause();
                    document.getElementById('nomor0').currentTime = 0;
                    document.getElementById('nomor0').play();
                }, totalwaktu);
                totalwaktu = totalwaktu + 1000;
                setTimeout(function() {
                    document.getElementById('puluh').pause();
                    document.getElementById('puluh').currentTime = 0;
                    document.getElementById('puluh').play();
                }, totalwaktu);
                totalwaktu = totalwaktu + 1000;
                var angka2 = angka.charAt(1);
                if (angka2 != 0) {
                    $("#nomor1").attr("src", "{{ route('landingpage') }}/public/rekaman/" + angka2 + ".mp3");
                    setTimeout(function() {
                        document.getElementById('nomor1').pause();
                        document.getElementById('nomor1').currentTime = 0;
                        document.getElementById('nomor1').play();
                    }, totalwaktu);
                    totalwaktu = totalwaktu + 1000;
                }
            }
        }
    </script>
@stop
