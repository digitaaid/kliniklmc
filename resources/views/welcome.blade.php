@extends('vendor.medico.master')
@section('title', 'Klinik Luthfi Medical Center')
@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero">
        <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
            <div class="carousel-inner" role="listbox">
                <!-- Slide 1 -->
                <div class="carousel-item active"
                    style="background-image: url({{ asset('medicio/assets/img/slide/slide-1.jpg') }})">
                    <div class="container">
                        <h2>Selamat Datang di LMC</span></h2>
                        <p>
                            Selamat datang di Klinik Hematologi Kami! Kami siap memberikan pelayanan terbaik untuk kesehatan
                            Anda. Temukan solusi hematologi yang tepat bersama tim profesional kami.
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
                        <div class="icon"><i class="fas fa-heartbeat"></i></div>
                        <h4 class="title"><a href="">Tim Ahli Terkemuka</a></h4>
                        <p class="description">
                            Dibimbing oleh para ahli hematologi onkologi terkemuka, kami menyediakan penanganan yang
                            didasarkan pada pengetahuan terbaru dan praktik terbaik.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon"><i class="fas fa-pills"></i></div>
                        <h4 class="title"><a href="">Diagnosis Akurat</a></h4>
                        <p class="description">
                            Dengan peralatan canggih dan teknologi terbaru, kami menghadirkan diagnosis hematologi onkologi
                            yang akurat dan mendalam, memungkinkan rencana perawatan yang disesuaikan.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon"><i class="fas fa-thermometer"></i></div>
                        <h4 class="title"><a href="">Perawatan Terpadu</a></h4>
                        <p class="description">
                            Kami menyatukan perawatan medis, psikologis, dan dukungan sosial untuk memberikan pendekatan
                            yang holistik kepada pasien, menjadikan kesejahteraan keseluruhan sebagai prioritas.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="400">
                        <div class="icon"><i class="fas fa-dna"></i></div>
                        <h4 class="title"><a href="">Terapi Inovatif</a></h4>
                        <p class="description">
                            Selain pengobatan konvensional, kami menyediakan akses ke terapi inovatif dan klinis melalui
                            kolaborasi dengan lembaga penelitian terkemuka, memberikan peluang baru untuk kesembuhan.
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
                <h2>About Us</h2>
                <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                    sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                    ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
            </div>
            <div class="row">
                <div class="col-lg-6" data-aos="fade-right">
                    <img src="{{ asset('medicio/assets/img/about.jpg') }}" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0 content" data-aos="fade-left">
                    <h3>Voluptatem dignissimos provident quasi corporis voluptates sit assumenda.</h3>
                    <p class="fst-italic">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore
                        magna aliqua.
                    </p>
                    <ul>
                        <li><i class="bi bi-check-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo
                            consequat.</li>
                        <li><i class="bi bi-check-circle"></i> Duis aute irure dolor in reprehenderit in voluptate
                            velit.</li>
                        <li><i class="bi bi-check-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda
                            mastiro dolore eu fugiat nulla pariatur.</li>
                    </ul>
                    <p>
                        Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                        reprehenderit in voluptate
                        velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in
                        culpa qui officia deserunt mollit anim id est laborum
                    </p>
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
                        <span data-purecounter-start="0" data-purecounter-end="85" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p><strong>Doctors</strong> consequuntur quae qui deca rode</p>
                        <a href="#">Find out more &raquo;</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
                    <div class="count-box">
                        <i class="far fa-hospital"></i>
                        <span data-purecounter-start="0" data-purecounter-end="26" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p><strong>Departments</strong> adipisci atque cum quia aut numquam delectus</p>
                        <a href="#">Find out more &raquo;</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
                    <div class="count-box">
                        <i class="fas fa-flask"></i>
                        <span data-purecounter-start="0" data-purecounter-end="14" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p><strong>Research Lab</strong> aut commodi quaerat. Aliquam ratione</p>
                        <a href="#">Find out more &raquo;</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
                    <div class="count-box">
                        <i class="fas fa-award"></i>
                        <span data-purecounter-start="0" data-purecounter-end="150" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p><strong>Awards</strong> rerum asperiores dolor molestiae doloribu</p>
                        <a href="#">Find out more &raquo;</a>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Counts Section -->
    <!-- ======= Features Section ======= -->
    <section id="features" class="features">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-6 order-2 order-lg-1" data-aos="fade-right">
                    <div class="icon-box mt-5 mt-lg-0">
                        <i class="bx bx-receipt"></i>
                        <h4>Est labore ad</h4>
                        <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip</p>
                    </div>
                    <div class="icon-box mt-5">
                        <i class="bx bx-cube-alt"></i>
                        <h4>Harum esse qui</h4>
                        <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt</p>
                    </div>
                    <div class="icon-box mt-5">
                        <i class="bx bx-images"></i>
                        <h4>Aut occaecati</h4>
                        <p>Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere</p>
                    </div>
                    <div class="icon-box mt-5">
                        <i class="bx bx-shield"></i>
                        <h4>Beatae veritatis</h4>
                        <p>Expedita veritatis consequuntur nihil tempore laudantium vitae denat pacta</p>
                    </div>
                </div>
                <div class="image col-lg-6 order-1 order-lg-2"
                    style='background-image: url("{{ asset('medicio/assets/img/features.jpg') }}");' data-aos="zoom-in">
                </div>
            </div>

        </div>
    </section><!-- End Features Section -->
    <!-- ======= Services Section ======= -->
    <section id="services" class="services services section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Services</h2>
                <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                    sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                    ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="100">
                    <div class="icon"><i class="fas fa-heartbeat"></i></div>
                    <h4 class="title"><a href="">Lorem Ipsum</a></h4>
                    <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias
                        excepturi sint occaecati cupiditate non provident</p>
                </div>
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="200">
                    <div class="icon"><i class="fas fa-pills"></i></div>
                    <h4 class="title"><a href="">Dolor Sitema</a></h4>
                    <p class="description">Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                        ex ea commodo consequat tarad limino ata</p>
                </div>
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="300">
                    <div class="icon"><i class="fas fa-hospital-user"></i></div>
                    <h4 class="title"><a href="">Sed ut perspiciatis</a></h4>
                    <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                        dolore eu fugiat nulla pariatur</p>
                </div>
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="100">
                    <div class="icon"><i class="fas fa-dna"></i></div>
                    <h4 class="title"><a href="">Magni Dolores</a></h4>
                    <p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                        officia deserunt mollit anim id est laborum</p>
                </div>
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="200">
                    <div class="icon"><i class="fas fa-wheelchair"></i></div>
                    <h4 class="title"><a href="">Nemo Enim</a></h4>
                    <p class="description">At vero eos et accusamus et iusto odio dignissimos ducimus qui
                        blanditiis praesentium voluptatum deleniti atque</p>
                </div>
                <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="300">
                    <div class="icon"><i class="fas fa-notes-medical"></i></div>
                    <h4 class="title"><a href="">Eiusmod Tempor</a></h4>
                    <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam libero
                        tempore, cum soluta nobis est eligendi</p>
                </div>
            </div>

        </div>
    </section><!-- End Services Section -->
    <!-- ======= Departments Section ======= -->
    <section id="departments" class="departments">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Departments</h2>
                <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                    sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                    ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
            </div>
            <div class="row" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <ul class="nav nav-tabs flex-column">
                        <li class="nav-item">
                            <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#tab-1">
                                <h4>Cardiology</h4>
                                <p>Quis excepturi porro totam sint earum quo nulla perspiciatis eius.</p>
                            </a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-2">
                                <h4>Neurology</h4>
                                <p>Voluptas vel esse repudiandae quo excepturi.</p>
                            </a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-3">
                                <h4>Hepatology</h4>
                                <p>Velit veniam ipsa sit nihil blanditiis mollitia natus.</p>
                            </a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-4">
                                <h4>Pediatrics</h4>
                                <p>Ratione hic sapiente nostrum doloremque illum nulla praesentium id</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-8">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tab-1">
                            <h3>Cardiology</h3>
                            <p class="fst-italic">Qui laudantium consequatur laborum sit qui ad sapiente dila parde
                                sonata raqer a videna mareta paulona marka</p>
                            <img src="{{ asset('medicio/assets/img/departments-1.jpg') }}" alt=""
                                class="img-fluid">
                            <p>Et nobis maiores eius. Voluptatibus ut enim blanditiis atque harum sint. Laborum eos
                                ipsum ipsa odit magni. Incidunt hic ut molestiae aut qui. Est repellat minima
                                eveniet eius et quis magni nihil. Consequatur dolorem quaerat quos qui similique
                                accusamus nostrum rem vero</p>
                        </div>
                        <div class="tab-pane" id="tab-2">
                            <h3>Neurology</h3>
                            <p class="fst-italic">Qui laudantium consequatur laborum sit qui ad sapiente dila parde
                                sonata raqer a videna mareta paulona marka</p>
                            <img src="{{ asset('medicio/assets/img/departments-2.jpg') }}" alt=""
                                class="img-fluid">
                            <p>Et nobis maiores eius. Voluptatibus ut enim blanditiis atque harum sint. Laborum eos
                                ipsum ipsa odit magni. Incidunt hic ut molestiae aut qui. Est repellat minima
                                eveniet eius et quis magni nihil. Consequatur dolorem quaerat quos qui similique
                                accusamus nostrum rem vero</p>
                        </div>
                        <div class="tab-pane" id="tab-3">
                            <h3>Hepatology</h3>
                            <p class="fst-italic">Qui laudantium consequatur laborum sit qui ad sapiente dila parde
                                sonata raqer a videna mareta paulona marka</p>
                            <img src="{{ asset('medicio/assets/img/departments-3.jpg') }}" alt=""
                                class="img-fluid">
                            <p>Et nobis maiores eius. Voluptatibus ut enim blanditiis atque harum sint. Laborum eos
                                ipsum ipsa odit magni. Incidunt hic ut molestiae aut qui. Est repellat minima
                                eveniet eius et quis magni nihil. Consequatur dolorem quaerat quos qui similique
                                accusamus nostrum rem vero</p>
                        </div>
                        <div class="tab-pane" id="tab-4">
                            <h3>Pediatrics</h3>
                            <p class="fst-italic">Qui laudantium consequatur laborum sit qui ad sapiente dila parde
                                sonata raqer a videna mareta paulona marka</p>
                            <img src="{{ asset('medicio/assets/img/departments-4.jpg') }}" alt=""
                                class="img-fluid">
                            <p>Et nobis maiores eius. Voluptatibus ut enim blanditiis atque harum sint. Laborum eos
                                ipsum ipsa odit magni. Incidunt hic ut molestiae aut qui. Est repellat minima
                                eveniet eius et quis magni nihil. Consequatur dolorem quaerat quos qui similique
                                accusamus nostrum rem vero</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End Departments Section -->
    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Testimonials</h2>
                <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                    sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                    ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
            </div>
            <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit
                                rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam,
                                risus at semper.
                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                            </p>
                            <img src="{{ asset('medicio/assets/img/testimonials/testimonials-1.jpg') }}"
                                class="testimonial-img" alt="">
                            <h3>Saul Goodman</h3>
                            <h4>Ceo &amp; Founder</h4>
                        </div>
                    </div><!-- End testimonial item -->
                    @foreach ($testimoni as $ts)
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    {{ $ts->testimoni }}
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                                <img src="{{ asset('medicio/assets/img/testimonials/testimonials-2.jpg') }}"
                                    class="testimonial-img" alt="">
                                <h3> {{ $ts->name }}</h3>
                                <h4> {{ $ts->subtitle }}</h4>
                            </div>
                        </div><!-- End testimonial item -->
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section><!-- End Testimonials Section -->
    @include('vendor.medico.content.doctor')
    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Gallery</h2>
                <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                    sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                    ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
            </div>
            <div class="gallery-slider swiper">
                <div class="swiper-wrapper align-items-center">
                    <div class="swiper-slide"><a class="gallery-lightbox"
                            href="{{ asset('medicio/assets/img/gallery/gallery-1.jpg') }}"><img
                                src="{{ asset('medicio/assets/img/gallery/gallery-1.jpg') }}" class="img-fluid"
                                alt=""></a>
                    </div>
                    <div class="swiper-slide"><a class="gallery-lightbox"
                            href="{{ asset('medicio/assets/img/gallery/gallery-2.jpg') }}"><img
                                src="{{ asset('medicio/assets/img/gallery/gallery-2.jpg') }}" class="img-fluid"
                                alt=""></a>
                    </div>
                    <div class="swiper-slide"><a class="gallery-lightbox"
                            href="{{ asset('medicio/assets/img/gallery/gallery-3.jpg') }}"><img
                                src="{{ asset('medicio/assets/img/gallery/gallery-3.jpg') }}" class="img-fluid"
                                alt=""></a>
                    </div>
                    <div class="swiper-slide"><a class="gallery-lightbox"
                            href="{{ asset('medicio/assets/img/gallery/gallery-4.jpg') }}"><img
                                src="{{ asset('medicio/assets/img/gallery/gallery-4.jpg') }}" class="img-fluid"
                                alt=""></a>
                    </div>
                    <div class="swiper-slide"><a class="gallery-lightbox"
                            href="{{ asset('medicio/assets/img/gallery/gallery-5.jpg') }}"><img
                                src="{{ asset('medicio/assets/img/gallery/gallery-5.jpg') }}" class="img-fluid"
                                alt=""></a>
                    </div>
                    <div class="swiper-slide"><a class="gallery-lightbox"
                            href="{{ asset('medicio/assets/img/gallery/gallery-6.jpg') }}"><img
                                src="{{ asset('medicio/assets/img/gallery/gallery-6.jpg') }}" class="img-fluid"
                                alt=""></a>
                    </div>
                    <div class="swiper-slide"><a class="gallery-lightbox"
                            href="{{ asset('medicio/assets/img/gallery/gallery-7.jpg') }}"><img
                                src="{{ asset('medicio/assets/img/gallery/gallery-7.jpg') }}" class="img-fluid"
                                alt=""></a>
                    </div>
                    <div class="swiper-slide"><a class="gallery-lightbox"
                            href="{{ asset('medicio/assets/img/gallery/gallery-8.jpg') }}"><img
                                src="{{ asset('medicio/assets/img/gallery/gallery-8.jpg') }}" class="img-fluid"
                                alt=""></a>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section><!-- End Gallery Section -->

    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Pricing</h2>
                <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                    sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                    ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
            </div>

            <div class="row">

                <div class="col-lg-3 col-md-6">
                    <div class="box" data-aos="fade-up" data-aos-delay="100">
                        <h3>Free</h3>
                        <h4><sup>$</sup>0<span> / month</span></h4>
                        <ul>
                            <li>Aida dere</li>
                            <li>Nec feugiat nisl</li>
                            <li>Nulla at volutpat dola</li>
                            <li class="na">Pharetra massa</li>
                            <li class="na">Massa ultricies mi</li>
                        </ul>
                        <div class="btn-wrap">
                            <a href="#" class="btn-buy">Buy Now</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-4 mt-md-0">
                    <div class="box featured" data-aos="fade-up" data-aos-delay="200">
                        <h3>Business</h3>
                        <h4><sup>$</sup>19<span> / month</span></h4>
                        <ul>
                            <li>Aida dere</li>
                            <li>Nec feugiat nisl</li>
                            <li>Nulla at volutpat dola</li>
                            <li>Pharetra massa</li>
                            <li class="na">Massa ultricies mi</li>
                        </ul>
                        <div class="btn-wrap">
                            <a href="#" class="btn-buy">Buy Now</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-4 mt-lg-0">
                    <div class="box" data-aos="fade-up" data-aos-delay="300">
                        <h3>Developer</h3>
                        <h4><sup>$</sup>29<span> / month</span></h4>
                        <ul>
                            <li>Aida dere</li>
                            <li>Nec feugiat nisl</li>
                            <li>Nulla at volutpat dola</li>
                            <li>Pharetra massa</li>
                            <li>Massa ultricies mi</li>
                        </ul>
                        <div class="btn-wrap">
                            <a href="#" class="btn-buy">Buy Now</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-4 mt-lg-0">
                    <div class="box" data-aos="fade-up" data-aos-delay="400">
                        <span class="advanced">Advanced</span>
                        <h3>Ultimate</h3>
                        <h4><sup>$</sup>49<span> / month</span></h4>
                        <ul>
                            <li>Aida dere</li>
                            <li>Nec feugiat nisl</li>
                            <li>Nulla at volutpat dola</li>
                            <li>Pharetra massa</li>
                            <li>Massa ultricies mi</li>
                        </ul>
                        <div class="btn-wrap">
                            <a href="#" class="btn-buy">Buy Now</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Pricing Section -->
    <!-- ======= Frequently Asked Questioins Section ======= -->
    <section id="faq" class="faq section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Frequently Asked Questioins</h2>
                <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                    sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                    ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
            </div>

            <ul class="faq-list">

                <li>
                    <div data-bs-toggle="collapse" class="collapsed question" href="#faq1">Non consectetur a
                        erat nam at lectus urna duis? <i class="bi bi-chevron-down icon-show"></i><i
                            class="bi bi-chevron-up icon-close"></i></div>
                    <div id="faq1" class="collapse" data-bs-parent=".faq-list">
                        <p>
                            Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non
                            curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus
                            non.
                        </p>
                    </div>
                </li>
                @foreach ($tanyajawab as $tj)
                    <li>
                        <div data-bs-toggle="collapse" href="#faqs{{ $tj->id }}" class="collapsed question">
                            {{ $tj->pertanyaan }}
                            <i class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i>
                        </div>
                        <div id="faqs{{ $tj->id }}" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                {{ $tj->jawaban }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section><!-- End Frequently Asked Questioins Section -->
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
