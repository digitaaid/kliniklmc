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
    {{-- <!-- ======= Appointment Section ======= -->
    <br><br><br><br>
    <section id="appointment" class="appointment section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Daftar Online</h2>
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
            <form action="{{ route('prosesdaftar') }}" id="formDaftar" method="POST" role="form" data-aos="fade-up"
                data-aos-delay="100">
                @csrf
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="nomorkartu" id="nomorkartu"
                        placeholder="Nomor Kartu BPJS" value="{{ $request->nomorkartu }}"
                        {{ $request->nik ? 'readonly' : null }} required>
                </div>
                @if ($request->nik)
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="nik" id="nik" placeholder="NIK"
                            value="{{ $request->nik }}" required readonly>
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
                        <input type="text" class="form-control" name="tanggalperiksa" id="tanggalperiksa"
                            placeholder="Tanggal Periksa" value="{{ $request->tanggalperiksa }}" required>
                    </div>
                @endif
                @if ($request->tanggalperiksa && $jadwals)
                    <div class="form-group mb-3">
                        <select name="jadwal" id="jadwal" class="form-select" required>
                            @foreach ($jadwals as $item)
                                <option value="{{ $item->id }}">{{ $item->jadwal }} {{ $item->namasubspesialis }}
                                    {{ $item->namadokter }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <select name="jeniskunjungan" id="jeniskunjungan" class="form-select" required>
                            <option value="1" {{ $request->jeniskunjungan == '1' ? 'selected' : null }}>Rujukan FKTP
                            </option>
                            <option value="3" {{ $request->jeniskunjungan == '3' ? 'selected' : null }}>Kontrol
                            </option>
                            <option value="4" {{ $request->jeniskunjungan == '4' ? 'selected' : null }}>Rujukan Antar
                                RS</option>
                        </select>
                    </div>
                @endif
                @if ($request->jeniskunjungan)
                    <div class="form-group mb-3">
                        <select name="nomorreferensi" id="nomorreferensi" class="form-select" required>
                            <option selected disabled>Pilih Nomor Referensi</option>
                            @isset($rujukans)
                                @foreach ($rujukans as $rujukan)
                                    <option value="{{ $rujukan->noKunjungan }}">{{ $rujukan->noKunjungan }}
                                        {{ $rujukan->poliRujukan->nama }}</option>
                                @endforeach
                            @endisset

                        </select>
                    </div>
                @endif

                <div class="col text-center">
                    @empty($request->error)
                        <button type="submit" class="btn btn-warning preloader" form="formDaftar">Make
                            an
                            Appointment</button>
                    @endempty
                    <a href="{{ route('daftar') }}" class="btn btn-danger">
                        <i class="icon fas fa-sync"></i>
                        Daftar Ulang
                    </a>

                </div>
            </form>
        </div>
    </section><!-- End Appointment Section --> --}}
    {{-- <!-- ======= Frequently Asked Questioins Section ======= -->
    <section id="faq" class="faq section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Pertanyaan yang Sering Diajukan (FAQ)</h2>
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

                <li>
                    <div data-bs-toggle="collapse" href="#faq2" class="collapsed question">Feugiat scelerisque
                        varius morbi enim nunc faucibus a pellentesque? <i class="bi bi-chevron-down icon-show"></i><i
                            class="bi bi-chevron-up icon-close"></i>
                    </div>
                    <div id="faq2" class="collapse" data-bs-parent=".faq-list">
                        <p>
                            Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum
                            velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec
                            pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus
                            turpis massa tincidunt dui.
                        </p>
                    </div>
                </li>

                <li>
                    <div data-bs-toggle="collapse" href="#faq3" class="collapsed question">Dolor sit amet
                        consectetur adipiscing elit pellentesque habitant morbi? <i
                            class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i>
                    </div>
                    <div id="faq3" class="collapse" data-bs-parent=".faq-list">
                        <p>
                            Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus
                            pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum
                            tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna
                            molestie at elementum eu facilisis sed odio morbi quis
                        </p>
                    </div>
                </li>

                <li>
                    <div data-bs-toggle="collapse" href="#faq4" class="collapsed question">Ac odio tempor orci
                        dapibus. Aliquam eleifend mi in nulla? <i class="bi bi-chevron-down icon-show"></i><i
                            class="bi bi-chevron-up icon-close"></i></div>
                    <div id="faq4" class="collapse" data-bs-parent=".faq-list">
                        <p>
                            Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum
                            velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec
                            pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus
                            turpis massa tincidunt dui.
                        </p>
                    </div>
                </li>

                <li>
                    <div data-bs-toggle="collapse" href="#faq5" class="collapsed question">Tempus quam
                        pellentesque nec nam aliquam sem et tortor consequat? <i class="bi bi-chevron-down icon-show"></i><i
                            class="bi bi-chevron-up icon-close"></i>
                    </div>
                    <div id="faq5" class="collapse" data-bs-parent=".faq-list">
                        <p>
                            Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est
                            ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit
                            adipiscing bibendum est. Purus gravida quis blandit turpis cursus in
                        </p>
                    </div>
                </li>

                <li>
                    <div data-bs-toggle="collapse" href="#faq6" class="collapsed question">Tortor vitae purus
                        faucibus ornare. Varius vel pharetra vel turpis nunc eget lorem dolor? <i
                            class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i>
                    </div>
                    <div id="faq6" class="collapse" data-bs-parent=".faq-list">
                        <p>
                            Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae ultricies leo
                            integer malesuada nunc vel. Tincidunt eget nullam non nisi est sit amet. Turpis nunc
                            eget lorem dolor sed. Ut venenatis tellus in metus vulputate eu scelerisque.
                            Pellentesque diam volutpat commodo sed egestas egestas fringilla phasellus faucibus.
                            Nibh tellus molestie nunc non blandit massa enim nec.
                        </p>
                    </div>
                </li>

            </ul>

        </div>
    </section><!-- End Frequently Asked Questioins Section --> --}}
    @include('vendor.medico.content.contact')
@endsection
