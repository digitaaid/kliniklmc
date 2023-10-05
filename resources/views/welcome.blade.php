@extends('vendor.medico.master')
@section('title', 'Klinik Luthfi Medical Center')
@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero">
        <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
            <div class="carousel-inner" role="listbox">
                <!-- Slide 1 -->
                <div class="carousel-item active" style="background-image: url({{ asset('img/3.jpg') }})">
                    <div class="container">
                        <h2>HELLO</span></h2>
                        <p>
                            Selamat datang di Klinik Utama Luthfi Medical Center. Kami siap memberikan pelayanan terbaik untuk kesehatan anda.
                        </p>
                        <a href="#about" class="btn-get-started scrollto">Tentang Kami</a>
                    </div>
                </div>
                @foreach ($carousel as $cr)
                    <div class="carousel-item" style="background-image: url({{ $cr->image }})">
                        <div class="container">
                            <h2>{{ $cr->title }}</h2>
                            <p>
                                {{ $cr->description }}
                            </p>
                            <a href="#about" class="btn-get-started scrollto">{{ $cr->button_text }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>
        </div>
    </section><!-- End Hero -->
    <!-- ======= Featured Services Section ======= -->
    <section id="featured-services" class="featured-services">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                        <div class="icon"><i class="fas fa-user-md"></i></div>
                        <h4 class="title"><a href="">Dokter Konsultan Hematologi Onkologi Medik</a></h4>
                        <p class="description">
                            Dokter yang memiliki keahlian khusus dalam mendiagnosis menangani dan mengobati penyakit yang
                            diakibatkan oleh kelainan darah dan tindakan kemoterapi.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon"><i class="fas fa-user-md"></i></div>
                        <h4 class="title"><a href="">Dokter Konsultan Patologi Klinik</a></h4>
                        <p class="description">
                            Dokter konsultan yang memiliki keahlian khusus dalam bidang laboratorium (Pemeriksaan tumor
                            marker, kelainan darah/ genetik) untuk mendiagnosis memahami mekanisme penyakit serta memberikan
                            hasil yang relevan untuk pengobatan selanjutnya.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon"><i class="fas fa-hand-holding-medical"></i></div>
                        <h4 class="title"><a href="">Kemoterapi</a></h4>
                        <p class="description">
                            Prosedur pengobatan atau terapi kanker dengan memberikan obat-obatan untuk menghentikan atau
                            memperlambat pertumbuhan dan pembelahan sel kanker yang tumbuh dan berkembang dalam tubuh.
                            Dilakukan oleh tenaga profesional yang sudah melakukan pelatihan dan bersertifikat.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="400">
                        <div class="icon"><i class="fas fa-diagnoses"></i></div>
                        <h4 class="title"><a href="">Patologi Anatomi</a></h4>
                        <p class="description">
                            Pelayanan diagnostik dan labratorium terhadap jaringan tubuh dan/ atau cairan tubuh. Berperan
                            sebagai penegakkan diagnosis yang berbasis perubahan morfologi sel dan jaringan sampai
                            pemeriksaan imunologik dan molekuler (Pemeriksaan Immunohistokimia/ IHK).
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Featured Services Section -->
    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
        <div class="container" data-aos="zoom-in">
            <div class="text-center">
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
    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Profil</h2>
                <p>
                    <b> Klinik Utama Luthfi Medical Center</b> adalah salah satu Klinik Utama yang memberikan pelayanan
                    khusus yaitu
                    pelayanan kemoterapi dan Hematologi Onkologi Medik. Klinik Utama Luthfi Medical Center didirikan pada
                    tanggal 01 Desember 2017 di Jalan Raya Sunan Gunung Jati No. 100 A/B, Desa Pasindangan Klayan, Kabupaten
                    Cirebon.
                </p>
            </div>
            <div class="row">
                <div class="col-lg-6" data-aos="fade-right">
                    <img src="{{ asset('img/2.jpg') }}" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0 content" data-aos="fade-left">
                    <p>
                        <b> Klinik Utama Luthfi Medical Center</b> didirikan untuk memenuhi kebutuhan masyarakat, khususnya
                        pelayanan Kemoterapi dan Hematologi yang terus berkembang, menyediakan pelayanan dokter spesialis
                        dan sub spesialis. Selanjutnya kedepan berencana menyediakan fasilitas yang lengkap guna memenuhi
                        kebutuhan pelayanan kesehatan masyarakat di bidang pelayanan Kemoterapi dan Hematologi.
                    </p>
                    <h3>Visi</h3>
                    <b>
                        “Menjadi Klinik Utama Terbaik dan Terlengkap di Wilayah III Cirebon dalam
                        pelayanan khususnya Kemoterapi dan Hematologi Onkologi Medik”.
                    </b>
                    <br> <br>
                    <h3>Misi</h3>
                    <ul>
                        <li><i class="bi bi-check-circle"></i>
                            Memberikan pelayanan Kemoterapi dan Hematologi yang bermutu, aman dan nyaman.
                        </li>
                        <li><i class="bi bi-check-circle"></i>
                            Melayani masyarakat dengan sarana dan prasarana terlengkap khususnya
                            pelayanan Kemoterapi dan Hematologi Onkologi Medik

                        </li>
                        <li><i class="bi bi-check-circle"></i>
                            Mengembangkan Sumber Daya Manusia yang jujur dan profesional.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section><!-- End About Us Section -->
    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
        <div class="container" data-aos="fade-up">
            <div class="row no-gutters">
                <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
                    <div class="count-box">
                        <i class="fas fa-user-md"></i>
                        <span data-purecounter-start="0" data-purecounter-end="2" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p>
                            <b>Dokter</b> Konsultan Hematologi Onkologi Medik
                            <br>
                            <b>Dokter</b> Konsultan Patologi Klinik
                        </p>
                        <a href="#">Find out more &raquo;</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
                    <div class="count-box">
                        <i class="fas fa-user-md"></i>
                        <span data-purecounter-start="0" data-purecounter-end="6" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p>
                            <b>2 Dokter</b> Spesialis Penyakit Dalam
                            <br>
                            <b>2 Dokter</b> Spesialis Patologi Anatomi
                            <br>
                            <b>1 Dokter</b> Spesialis Radiologi
                            <br>
                            <b>1 Dokter</b> Umum
                        </p>
                        <a href="#">Find out more &raquo;</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
                    <div class="count-box">
                        <i class="fas fa-hand-holding-medical"></i>
                        <span data-purecounter-start="0" data-purecounter-end="100" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p>Rata-rata tindakan kemoterapi setiap bulan.</p>
                        <a href="#">Find out more &raquo;</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
                    <div class="count-box">
                        <i class="fas fa-user-injured"></i>
                        <span data-purecounter-start="0" data-purecounter-end="400" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p>Rata-rata kunjungan rawat jalan/ Poliklinik setiap bulan.</p>
                        <a href="#">Find out more &raquo;</a>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Counts Section -->
    <!-- ======= Services Section ======= -->
    <section id="services" class="services services section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Services</h2>
                {{-- <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                    sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                    ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p> --}}
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="100">
                    <div class="icon"><i class="fas fa-hospital"></i></div>
                    <h4 class="title"><a href="">Poliklinik / Rawat Jalan</a></h4>
                    {{-- <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias
                        excepturi sint occaecati cupiditate non provident</p> --}}
                </div>
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="200">
                    <div class="icon"><i class="fas fa-hand-holding-medical"></i></div>
                    <h4 class="title"><a href="">Kemoterapi</a></h4>
                    {{-- <p class="description">Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                        ex ea commodo consequat tarad limino ata</p> --}}
                </div>
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="300">
                    <div class="icon"><i class="fas fa-vials"></i></div>
                    <h4 class="title"><a href="">Laboratorium</a></h4>
                    {{-- <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                        dolore eu fugiat nulla pariatur</p> --}}
                </div>
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="100">
                    <div class="icon"><i class="fas fa-x-ray"></i></div>
                    <h4 class="title"><a href="">Radiologi</a></h4>
                    {{-- <p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                        officia deserunt mollit anim id est laborum</p> --}}
                </div>
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="200">
                    <div class="icon"><i class="fas fa-diagnoses"></i></div>
                    <h4 class="title"><a href="">Cytotoxic Handling</a></h4>
                    {{-- <p class="description">At vero eos et accusamus et iusto odio dignissimos ducimus qui
                        blanditiis praesentium voluptatum deleniti atque</p> --}}
                </div>
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="300">
                    <div class="icon"><i class="fas fa-pills"></i></div>
                    <h4 class="title"><a href="">Farmasi</a></h4>
                    {{-- <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam libero
                        tempore, cum soluta nobis est eligendi</p> --}}
                </div>
            </div>

        </div>
    </section><!-- End Services Section -->
    @include('vendor.medico.content.jadwal')
    <!-- ======= Pricing Section ======= -->
    <section id="persyaratan" class="pricing section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Persyaratan</h2>
                {{-- <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                    sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                    ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p> --}}
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-3 col-md-6 mt-4 mt-md-0">
                    <div class="box featured" data-aos="fade-up" data-aos-delay="200">
                        <h3>Pasien BPJS</h3>
                        <ul>
                            <li>Status Kepesertaan BPJS AKTIF</li>
                            <li>Memiliki Rujukan / Surat Kontrol</li>
                        </ul>
                        <div class="btn-wrap">
                            <a href="{{ route('daftarbpjs') }}" class="btn-buy">Daftar</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mt-4 mt-md-0">
                    <div class="box featured" data-aos="fade-up" data-aos-delay="200">
                        <h3>Pasien Umum</h3>
                        <ul>
                            <li>Mempunyai NIK</li>
                            <li class="na">Memiliki Rujukan / Surat Kontrol</li>
                        </ul>
                        <div class="btn-wrap">
                            <a href="{{ route('daftarumum') }}" class="btn-buy">Daftar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Pricing Section -->
    {{-- @include('vendor.medico.content.departement') --}}
    @include('vendor.medico.content.doctor')
    @include('vendor.medico.content.testimoni')
    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Gallery</h2>
                {{-- <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                    sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                    ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p> --}}
            </div>
            <div class="gallery-slider swiper">
                <div class="swiper-wrapper align-items-center">
                    <div class="swiper-slide"><a class="gallery-lightbox" href="{{ asset('img/3.jpg') }}">
                            <img src="{{ asset('img/3.jpg') }}" class="img-fluid" alt=""></a>
                    </div>
                    <div class="swiper-slide"><a class="gallery-lightbox" href="{{ asset('img/2.jpg') }}">
                            <img src="{{ asset('img/2.jpg') }}" class="img-fluid" alt=""></a>
                    </div>

                    <div class="swiper-slide"><a class="gallery-lightbox" href="{{ asset('img/4.jpg') }}">
                            <img src="{{ asset('img/4.jpg') }}" class="img-fluid" alt=""></a>
                    </div>
                    <div class="swiper-slide"><a class="gallery-lightbox" href="{{ asset('img/5.jpg') }}">
                            <img src="{{ asset('img/5.jpg') }}" class="img-fluid" alt=""></a>
                    </div>
                    <div class="swiper-slide"><a class="gallery-lightbox" href="{{ asset('img/6.jpg') }}">
                            <img src="{{ asset('img/6.jpg') }}" class="img-fluid" alt=""></a>
                    </div>
                    <div class="swiper-slide"><a class="gallery-lightbox" href="{{ asset('img/1.jpg') }}">
                            <img src="{{ asset('img/1.jpg') }}" class="img-fluid" alt=""></a>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section><!-- End Gallery Section -->
    @include('vendor.medico.content.faq')
    @include('vendor.medico.content.contact')
@endsection
@section('css')
    <style>
        .carousel-item {
            max-width: 100%;
            height: auto;
            opacity: 0.5;
        }
    </style>
@endsection
