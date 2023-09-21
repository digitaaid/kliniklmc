@extends('adminlte::master')
{{-- @inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper') --}}
@section('title', 'Display Antrian')
@section('body')
    <link rel="shortcut icon" href="{{ asset('medicio/assets/img/lmc.png') }}" />
    <div class="wrapper">
        <div class="row p-1">
            <div class="col-md-12 mb-2">
                <header class="bg-purple text-white p-4">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <img src="{{ asset('medicio/assets/img/lmc-b.png') }}" width="100" alt="">
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
            <div class="col-md-4">
                <x-adminlte-card title="Informasi Pelayanan" theme="purple" icon="fas fa-qrcode">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{ asset('medicio/assets/img/slide/slide-1.jpg') }}"
                                    alt="First slide">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>...</h5>
                                    <p>...</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{ asset('medicio/assets/img/slide/slide-2.jpg') }}"
                                    alt="Second slide">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>...</h5>
                                    <p>...</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{ asset('medicio/assets/img/slide/slide-3.jpg') }}"
                                    alt="Third slide">
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
                <div class="card bg-success">
                    <div class="card-body">
                        <div class="text-center">
                            <h1>Antrian Pendaftaran</h1>
                            <h1><span id="pendaftaran">-</span></h1>
                            <h5>Estimasi Antrian Selanjutnya <span id="pendaftaranselanjutnya">-</span></h5>
                        </div>
                    </div>
                </div>
                <div class="card bg-success">
                    <div class="card-body">
                        <div class="text-center">
                            <h1>Antrian Dokter</h1>
                            <h1><span id="poliklinik">-</span></h1>
                            <h5>Estimasi Antrian Selanjutnya <span id="poliklinikselanjutnya">-</span></h5>
                        </div>
                    </div>
                </div>
                <div class="card bg-success">
                    <div class="card-body">
                        <div class="text-center">
                            <h1>Antrian Farmasi</h1>
                            <h1><span id="farmasi">-</span></h1>
                            <h5>Estimasi Antrian Selanjutnya <span id="farmasiselanjutnya">-</span></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <x-adminlte-card title="Video Informasi" theme="purple" icon="fas fa-play">
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
                        width="560" height="315" frameborder="0" allowfullscreen onload='playVideo();'> ></iframe>
                    {{-- <iframe src="https://drive.google.com/file/d/1xhCy7W5YDbGha30VPRttcxEykvV4yixz/preview" width="640"
                        height="480" allow="autoplay"></iframe> --}}
                </x-adminlte-card>
            </div>
        </div>
    </div>
@stop
@section('adminlte_css')
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
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }, 2000);
    </script>
@stop
