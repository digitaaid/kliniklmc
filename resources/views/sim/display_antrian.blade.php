@extends('adminlte::master')
{{-- @inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper') --}}
@section('title', 'Mesin Antrian')
@section('body')
    <link rel="shortcut icon" href="{{ asset('medicio/assets/img/lmc.png') }}" />
    <div class="wrapper">
        <div class="row p-1">
            <div class="col-md-12 mb-2">
                <header class="bg-primary text-white p-4">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <h1>Nama Aplikasi</h1>
                                <p>Slogan atau deskripsi singkat aplikasi Anda.</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <p>Kontak: email@example.com</p>
                                <p>Telepon: (123) 456-7890</p>
                            </div>
                        </div>
                    </div>
                </header>
            </div>
            <div class="col-md-6">
                <x-adminlte-card title="Anjungan Checkin Antrian RSUD Waled" theme="primary" icon="fas fa-qrcode">
                </x-adminlte-card>
            </div>
            <div class="col-md-6">
                <x-adminlte-card title="Video Informasi" theme="primary" icon="fas fa-play">
                    {{-- <iframe width="560" height="315"
                        src="https://www.youtube.com/embed/-rLm4l1yuhU?si=N2MQHFACzBjy-lc7?autoplay=1"
                        title="YouTube video player" frameborder="0" allowfullscreen></iframe> --}}
                    {{-- <iframe src="http://..." onload='playVideo();'> --}}
                    <video width="320" height="240" controls autoplay>
                        <source src="{{ asset('movie.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    {{-- <iframe
                        src="https://www.youtube.com/embed/-rLm4l1yuhU?si=N2MQHFACzBjy-lc7?rel=0&modestbranding=1&autohide=1&mute=1&showinfo=0&controls=1&autoplay=1"
                        width="560" height="315" frameborder="0" allowfullscreen onload='playVideo();'> ></iframe> --}}
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
    </script>
@stop
