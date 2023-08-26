@extends('vendor.medico.master')
@section('title', 'Klinik Luthfi Medical Center')
@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero">
        <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
            <div class="carousel-inner" role="listbox">
                <!-- Slide 1 -->
                <div class="carousel-item active" style="background-image: url(medicio/assets/img/slide/slide-1.jpg)">
                    <div class="container">
                        <h2>Selamat Datang di LMC</span></h2>
                        <p>
                            Selamat datang di Klinik Hematologi Kami! Kami siap memberikan pelayanan terbaik untuk kesehatan
                            Anda. Temukan solusi hematologi yang tepat bersama tim profesional kami.
                        </p>
                        <a href="#about" class="btn-get-started scrollto">Tentang Kami</a>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="carousel-item" style="background-image: url(medicio/assets/img/slide/slide-2.jpg)">
                    <div class="container">
                        <h2>Diagnosis Tepat Waktu</h2>
                        <p>
                            Teknologi mutakhir kami membantu mengidentifikasi dan memahami kondisi Anda dengan akurat,
                            memungkinkan perawatan yang sesuai.
                        </p>
                        <a href="#about" class="btn-get-started scrollto">Read More</a>
                    </div>
                </div>
                <!-- Slide 3 -->
                <div class="carousel-item" style="background-image: url(medicio/assets/img/slide/slide-3.jpg)">
                    <div class="container">
                        <h2>Diagnosis Tepat Waktu</h2>
                        <p>
                            Didukung oleh tim medis berpengalaman dalam hematologi onkologi, kami siap menangani perjalanan
                            kesehatan Anda.
                        </p>
                        <a href="#about" class="btn-get-started scrollto">Read More</a>
                    </div>
                </div>
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


    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="section-title">
                <h2>Hubungi Kami</h2>
                <p>Jika Anda memiliki pertanyaan, ingin membuat janji, atau membutuhkan informasi lebih lanjut tentang
                    layanan kami, jangan ragu untuk menghubungi tim kami. Kami siap membantu Anda.</p>
            </div>
        </div>
        <div>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.6413678992826!2d108.54828587576228!3d-6.69126569330416!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ee3b52bba8f17%3A0x51e6161f20f5f7ce!2sLMC%20Klinik%20Luthfi%20Medical%20Center!5e0!3m2!1sid!2sid!4v1692967886382!5m2!1sid!2sid"
                style="border:0; width: 100%; height: 350px;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="container">
            <div class="row mt-5">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="info-box">
                                <i class="bx bx-map"></i>
                                <h3>Alamat</h3>
                                <p>
                                    Jl. Raya Sunan Gunung Jati No.78 C/D.
                                    <br>
                                    Desa Jadimulya Kec. Gunungjati Kab. Cirebon Jawa Barat 45151,
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box mt-4">
                                <i class="bx bx-envelope"></i>
                                <h3>Email Us</h3>
                                <p>info@example.com<br>contact@example.com</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box mt-4">
                                <i class="bx bx-phone-call"></i>
                                <h3>Call Us</h3>
                                <p>+1 5589 55488 55<br>+1 6678 254445 41</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Your Name" required="">
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Your Email" required="">
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" name="subject" id="subject"
                                placeholder="Subject" required="">
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" name="message" rows="7" placeholder="Message" required=""></textarea>
                        </div>
                        <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div class="text-center"><button type="submit">Send Message</button></div>
                    </form>
                </div>
            </div>
        </div>
    </section><!-- End Contact Section -->
@endsection
