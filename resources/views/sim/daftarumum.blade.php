@extends('vendor.medico.master')
@section('title', 'Daftar Antrian Umum')
@section('content')
    <!-- ======= Appointment Section ======= -->
    <br><br><br><br>
    <section id="appointment" class="appointment section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Daftar Antrian Umum</h2>
                <p>
                    Hemat waktu dan nikmati kemudahan dengan pendaftaran online di Klinik Hematologi Onkologi kami. Dengan
                    mengisi formulir sederhana di bawah ini, Anda dapat membuat janji dengan cepat dan praktis.
                </p>
            </div>
            @if ($request->error)
                <div class="alert alert-danger">
                    <h5>
                        <i class="icon fas fa-ban"></i>
                        Ops Terjadi Masalah !
                    </h5>
                    <p>{{ $request->error }}</p>
                </div>
            @endif
            @if ($request->warning)
                <div class="alert alert-warning">
                    <h5>
                        <i class="icon fas fa-ban"></i>
                        Ops Terjadi Masalah !
                    </h5>
                    <p>{{ $request->warning }}</p>
                </div>
            @endif
            <form action="{{ route('prosesdaftarumum') }}" id="formDaftar" method="POST" role="form" data-aos="fade-up"
                data-aos-delay="100">
                @csrf
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="nik" id="nik" placeholder="NIK Pasien"
                        value="{{ $request->nik }}" required {{ $request->nomorkartu ? 'readonly' : null }}>
                </div>
                @if ($request->nik)
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="nomorkartu" id="nomorkartu"
                            placeholder="Nomor Kartu BPJS" value="{{ $request->nomorkartu }}" required readonly>
                    </div>

                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama"
                            value="{{ $request->nama }}" required readonly>
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="norm" id="norm" placeholder="Nomor RM"
                            value="{{ $request->norm }}" required readonly>
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="nohp" id="nohp" placeholder="Nomor HP"
                            value="{{ $request->nohp }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control datepicker" name="tanggalperiksa" id="tanggalperiksa"
                            placeholder="Tanggal Periksa" value="{{ $request->tanggalperiksa }}" required>
                    </div>
                @endif
                @if ($request->tanggalperiksa && $jadwals)
                    <div class="form-group mb-3">
                        <select name="jadwal" id="jadwal" class="form-select" required>
                            <option selected disabled>Pilih jadwal dokter</option>
                            @foreach ($jadwals as $item)
                                <option value="{{ $item->id }}">{{ $item->jadwal }} {{ $item->namasubspesialis }}
                                    {{ $item->namadokter }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <select name="jeniskunjungan" id="jeniskunjungan" class="form-select" required>
                            <option selected disabled>Pilih jenis kunjungan</option>
                            <option value="1" {{ $request->jeniskunjungan == '1' ? 'selected' : null }}>Kunjungan
                                Pertama
                            </option>
                            <option value="3" {{ $request->jeniskunjungan == '3' ? 'selected' : null }}>Kontrol
                            </option>
                        </select>
                    </div>
                @endif
                <div class="col text-center">
                    @empty($request->error)
                        <button type="submit" class="btn btn-warning preloader" form="formDaftar">{{ $request->button }}</button>
                    @endempty
                    <a href="{{ route('daftar') }}" class="btn btn-danger">
                        <i class="icon fas fa-sync"></i>
                        Daftar Ulang
                    </a>

                </div>
            </form>
        </div>
    </section><!-- End Appointment Section -->
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

@section('js')
@endsection
