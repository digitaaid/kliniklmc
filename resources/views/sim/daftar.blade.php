@extends('vendor.medico.master')
@section('title', 'Daftar Pilih Jenis Pasien')
@section('content')
    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
        <div class="container" data-aos="zoom-in">
            <div class="text-center">
                <br><br><br><br> <br>
                <h3>
                    Pendaftaran Antrian Online
                    <br>
                    Silahkan pilih jenis pasien ?
                </h3>
                <p>
                    Kami menyediakan pelayanan bagi pasien BPJS maupun umum. Silakan pilih jenis pasien Anda di bawah ini
                    untuk mendapatkan informasi lebih lanjut tentang prosedur, layanan, dan manfaat yang tersedia untuk
                    Anda.
                </p>
                <a class="cta-btn scrollto" href="{{ route('daftarbpjs') }}">Antrian Pasien BPJS</a>
                <br>
                <a class="cta-btn scrollto" href="{{ route('daftarumum') }}">Antrian Pasien Umum</a>

                <br>
                <br>
                <p>
                    Dengan memilih jenis pasien yang sesuai, kami akan memastikan bahwa Anda mendapatkan panduan yang
                    relevan dan penanganan terbaik sesuai kebutuhan Anda.
                </p>
            </div>
        </div>
    </section><!-- End Cta Section -->
    @include('vendor.medico.content.contact')
@endsection
